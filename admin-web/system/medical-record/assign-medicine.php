<!DOCTYPE html>
<html lang="en">

<?php

if (isset($_GET['pre_id'])) {
  $prescriptionID = $_GET['pre_id'];
} else {
  die(header('location: ../error-404.html'));
}

include '../../components/head.php';




include '../../connection/db.php';

$sql = "SELECT `prescription`.*, `medicalrecord`.*, `booking`.*, `patient`.*
                                      FROM `prescription` 
                                      INNER JOIN `medicalrecord` ON `prescription`.`mediRec_id_fk` = `medicalrecord`.`mediRec_id` 
                                      INNER JOIN `booking` ON `medicalrecord`.`book_id_fk` = `booking`.`book_id` 
                                      INNER JOIN `patient` ON `booking`.`p_id_fk` = `patient`.`p_id`
                                      WHERE `prescription`.`pre_id` = $prescriptionID;";

$exec = mysqli_query($con, $sql);

$no_of_preDetails = mysqli_num_rows($exec);

while ($row = mysqli_fetch_array($exec)) {
  $patientName = $row['p_name'];
  $mediRec_id  = $row['mediRec_id'];
  $bookingID  = $row['book_id'];
}


?>


<body>

  <div class="loader-wrapper">
    <div class="loader-index"><span></span></div>
    <svg>
      <defs></defs>
      <filter id="goo">
        <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
        <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo"> </fecolormatrix>
      </filter>
    </svg>
  </div>

  <!-- tap on top starts-->
  <div class="tap-top"><i data-feather="chevrons-up"></i></div>
  <!-- tap on tap ends-->
  <!-- page-wrapper Start-->
  <div class="page-wrapper compact-wrapper" id="pageWrapper">

    <?php include '../../components/topbar.php' ?>

    <!-- Page Body Start-->
    <div class="page-body-wrapper">

      <?php
            if (isset($_SESSION["adminID"])) {
                include '../../components/sidebar.php';
            } else if (isset($_SESSION["staffType"])) {
                if ($_SESSION["staffType"] == "Inventory Clerk") {
                    include '../../components/sidebar-inventory.php';
                } else if ($_SESSION["staffType"] == "Receptionist") {
                    include '../../components/sidebar-reception.php';
                }
            } else if (isset($_SESSION["doctorID"])) {
                include '../../components/sidebar-doctor.php';
            }
            ?>

      <div class="page-body">
        <div class="container-fluid">
          <div class="page-title">
            <div class="row">
              <div class="col-6">
                <h3>Assign Medicine to Medical Record</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php"> <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Medical Record</li>
                  <li class="breadcrumb-item">Assign Medicine to Medical Record</li>
                </ol>
              </div>
            </div>
          </div>
        </div>

        <!-- Container-fluid starts-->
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <div class="card">
                <!-- <div class="card-header">
                    <h5>Sample Card</h5><span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                  </div> -->
                <div class="card-body">

                  <div class="row g-3">

                    <?php

                    include '../../connection/db.php';

                    $sql = "SELECT `booking`.*, `patient`.*, `doctor`.*, `hospital`.*,`gender`.*
                                      FROM `booking` 
                                      INNER JOIN `patient` ON `booking`.`p_id_fk` = `patient`.`p_id`
                                      INNER JOIN `gender` ON `patient`.`gender_fk` = `gender`.`gender_id`
                                      INNER JOIN `doctor` ON `booking`.`doc_id_fk` = `doctor`.`doc_id` 
                                      INNER JOIN `hospital` ON `booking`.`hos_id_fk` = `hospital`.`hos_id` WHERE `booking`.`book_id` = $bookingID";

                    $exec = mysqli_query($con, $sql);

                    while ($row = mysqli_fetch_array($exec)) {

                      $allocatedDateTime = $row['book_allocateDateTime'];
                      $hospitalName = $row['hos_branch'];
                      $doctorName = $row['doc_name'];

                      $patientName = $row['p_name'];
                      $patientNic = $row['p_nic'];
                      $patientDob = $row['p_dob'];
                      $genderName = $row['gender'];

                      $patientID = $row['p_id'];
                      $bookingTime = $row['book_dateTime'];
                    }

                    function toGetDate($date_time)
                    {
                      $new_date = date("Y-m-d H:i:s", strtotime($date_time));
                      return $new_date;
                    }

                    function agecalculator($dob)
                    {
                      $date = new DateTime($dob);
                      $now = new DateTime();
                      $interval = $now->diff($date);
                      return $interval->y;
                    }


                    ?>

                    <div class="col-6  ">
                      <div class="border p-3">
                        <h6>Booking Details Here</h6>
                        <p class="mt-3"><strong>Booking Allocated Date Time:</strong><?php echo $allocatedDateTime ?> </p>
                        <p><strong>Booking Hospital:</strong> <?php echo $hospitalName ?></p>
                        <p><strong>Doctor Name:</strong> <?php echo $doctorName ?></p>
                        <p>
                          <strong>Current Diseases: </strong>
                          <?php
                          $patientDiseases_sql = "SELECT `patient`.`p_id`, `paitenthasdisease`.*, `disease`.*
                                                          FROM `patient` 
                                                          INNER JOIN `paitenthasdisease` ON `paitenthasdisease`.`p_id_fk` = `patient`.`p_id` 
                                                          INNER JOIN `disease` ON `paitenthasdisease`.`dis_id_fk` = `disease`.`dis_id`
                                                          WHERE `patient`.`p_id` = '$patientID' AND `paitenthasdisease`.`paHasDis_recordedDate` = '" . toGetDate($bookingTime) . "%' ";

                          $patientDiseases_exec = mysqli_query($con, $patientDiseases_sql);

                          while ($row = mysqli_fetch_array($patientDiseases_exec)) {
                          ?>
                            <span class="badge badge-dark" style="font-size: 12px ;"><?php echo $row['dis_name'] ?></span>
                          <?php
                          }

                          ?>
                        </p>

                        <div class="d-flex justify-content-center align-items-center">
                          <button class="btn btn-primary rounded-2"> View More </button>
                        </div>
                      </div>
                    </div>

                    <div class="col-6 ">
                      <div class="border p-3">
                        <h6>Patient Details Here</h6>
                        <p class="mt-3"><strong>Name: </strong> <?php echo $patientName ?> </p>
                        <p><strong>NIC:</strong> <?php echo $patientNic ?> </p>
                        <p><strong>DOB:</strong> <?php echo $patientDob . " (" . agecalculator($patientDob) . " Yrs)" ?> </p>
                        <p><strong>Gender:</strong> <?php echo $genderName ?> </p>

                        <div class="d-flex justify-content-center align-items-center">
                          <button class="btn btn-primary rounded-2" style="margin-right:15px ;"> Previous Medi Records </button>
                          <button class="btn btn-primary rounded-2"> View More Info </button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <form method="POST" class="needs-validation" novalidate="" enctype="multipart/form-data">

                    <div class="col-md-12 mt-3">
                      <label class="form-label" for="validationCustom01">Prescription Summary</label>
                      <textarea name="preDetails" rows="3" class="form-control" id="validationCustom01" type="text" placeholder="Overall Summary for the Prescrption and Special Mentions" required=""></textarea>
                      <div class="valid-feedback">Looks good!</div>
                      <div class="invalid-feedback">Please Add a Description</div>
                    </div>

                    <div class="d-flex flex-column align-items-start align-items-center sub-btnsize mb-3 ">
                      <button name="preSummary" id="submit" class="mt-4 btn btn-success" type="submit"><i class="fa fa-pencil-square"></i> Update Prescription Detail </button>
                    </div>

                  </form>

                  <hr>
                  <div class="d-flex justify-content-center mt-0 mb-0">
                    <h5 class="mt-0 mb-0">Prescription Details</h5>
                  </div>
                  <hr>

                  <form method="POST" class="needs-validation" novalidate="">

                    <div class="col-md-12">
                      <div class="row">

                        <div class="col-12 mb-3 d-flex flex-column justify-content-center align-items-center">

                          <p><strong>Medical Record ID:</strong><span style="margin-left: 5px; font-size: 13px;" class="badge badge-info" style="font-size: 12px ;"> <?php echo $mediRec_id ?></span> </p>
                          <p><strong>Patient Info:</strong><span style="margin-left: 5px; font-size: 13px;" class="badge badge-info" style="font-size: 12px ;"> <?php echo $patientName ?></span></p>
                        </div>

                        <div class="col-6">
                          <div class="row">

                            <div class="col-12">
                              <label for="stateofusing">Select the Medicine</label>
                              <select class="form-select js-choice" id="stateofusing" size="1" name="medicine_id" data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value="">Select the Medicine...</option>
                                <?php
                                include '../../connection/db.php';
                                $sql = "SELECT * FROM medicine";

                                $exec = mysqli_query($con, $sql);

                                while ($row = mysqli_fetch_array($exec)) {
                                ?>
                                  <option value="<?php echo $row['medi_id'] ?>"><?php echo $row['medi_name'] . " | " . $row['medi_pillCode'] ?></option>
                                <?php
                                }
                                ?>
                              </select>
                            </div>

                            <div class="col-12 mt-3">
                              <label class="form-label" for="validationCustom01">Quantity Details</label>
                              <input name="quantity" class="form-control" id="validationCustom01" type="text" placeholder="Quantity" required="">
                              <div class="valid-feedback">Looks good!</div>
                              <div class="invalid-feedback">Please Add a Name</div>
                            </div>

                            <div class="col-12 mt-3">
                              <div class="row">

                                <div class="col-6">
                                  <label class="form-label" for="validationCustom01">Start Date</label>
                                  <input name="startDate" class="form-control" id="validationCustom01" type="date" placeholder="Admin Name" required="">
                                  <div class="valid-feedback">Looks good!</div>
                                  <div class="invalid-feedback">Please Add a Name</div>
                                </div>

                                <div class="col-6">
                                  <label class="form-label" for="validationCustom01">End Date</label>
                                  <input name="endDate" class="form-control" id="validationCustom01" type="date" placeholder="Admin Name" required="">
                                  <div class="valid-feedback">Looks good!</div>
                                  <div class="invalid-feedback">Please Add a Name</div>
                                </div>

                              </div>
                            </div>

                            <div class="col-12 mt-3">
                              <div class="row">

                                <div class="col-6">
                                  <label class="form-label" for="validationCustom04">Usage Time</label>
                                  <select name="usageTime_id" class="form-select" id="validationCustom04" required="">
                                    <option disabled selected value="">Select...</option>
                                    <?php

                                    $sql = "SELECT * FROM usagetime";

                                    $exec = mysqli_query($con, $sql);

                                    while ($row = mysqli_fetch_array($exec)) {
                                    ?>
                                      <option value="<?php echo $row['usageTime_id'] ?>"><?php echo $row['usage_Time'] ?></option>
                                    <?php
                                    }

                                    ?>

                                  </select>
                                  <div class="invalid-feedback">Please select a valid Usage Time.</div>
                                </div>

                                <div class="col-6">
                                  <label>State of Usage</label>
                                  <select class="form-select js-choice" id="usingState" size="1" name="usageState_id">
                                    <option selected disabled>Select the State...</option>
                                    <?php

                                    $sql = "SELECT * FROM medicineusingstate";

                                    $exec = mysqli_query($con, $sql);

                                    while ($row = mysqli_fetch_array($exec)) {
                                    ?>
                                      <option value="<?php echo $row['medicineUsingState_id'] ?>"><?php echo $row['medicineUsing_state'] ?></option>
                                    <?php
                                    }
                                    ?>
                                  </select>
                                </div>

                              </div>
                            </div>

                            <div class="col-12">
                              <div class="d-flex flex-column align-items-start align-items-center sub-btnsize mb-1 ">
                                <button name="addMedicine" id="submit" class="mt-4 btn btn-success" type="submit"><i class="fa fa-plus-square"></i> Add Medicine </button>
                              </div>
                            </div>

                          </div>
                        </div>


                        <div class="col-6">
                          <label>::::: Selected Medicine Info ::::: </label>
                          <div class="table-responsive">
                            <table class="table text-center">
                              <thead class="table-dark">
                                <tr>
                                  <th scope="col">Begin Date</th>
                                  <th scope="col">Over Date</th>
                                  <th scope="col">Medicine Name</th>
                                  <th scope="col">Actions</th>
                                </tr>
                              </thead>

                              <tbody id="medicineRow">
                              
                              </tbody>

                            </table>
                          </div>
                        </div>


                      </div>

                    </div>

                  </form>

                </div>



              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Container-fluid Ends-->

    </div>
  </div>
  </div>

  <?php include '../../components/scripts.php' ?>

  <script>
    const element = document.querySelector('.js-choice');
    const choices = new Choices(element);
  </script>

  <script>
    function loadlink() {
      $('#medicineRow').load('select-medicine.php?pre_id=<?php echo $prescriptionID ?>');
    }

    loadlink(); // This will run on page load

    setInterval(function() {
      loadlink() // this will run after every 5 seconds
    }, 5000);
  </script>

  <script>
    function viewMedicine(medview_id) {
      $.confirm({
        title: 'Medicine View (Medicine ID - ' + medview_id + ')',
        content: 'url:<?php echo $base_url ?>system/medicine/select-medicine.php?id=' + medview_id,
        // onContentReady: function() {
        // 	var self = this;
        // 	this.setContentPrepend('<div>Prepended text</div>');
        // 	setTimeout(function() {
        // 		self.setContentAppend('<div>Appended text after 2 seconds</div>');
        // 	}, 2000);
        // },
        columnClass: 'medium',
      });
    }
  </script>

</body>

</html>


<?php

if (isset($_POST['preSummary'])) {

  $pre_details = $_POST['preDetails'];

  $sql_prescription_upd = "UPDATE `prescription` SET `pre_desc`='$pre_details' WHERE `pre_id`= $prescriptionID ";

  $exec_prescription_upd = mysqli_query($con, $sql_prescription_upd);

  if ($exec_prescription_upd) {
?>
    <script>
      $.confirm({
        icon: 'fa fa-check-circle ',
        title: 'Prescription Details Updated Successfully',
        content: 'Your Data is prescription details has been updated Successfully',
        columnClass: 'col-md-4 col-md-offset-4',
        draggable: false,
        theme: 'modern'
      });
    </script>
  <?php
  } else {
  ?>
    <script>
      $.confirm({
        icon: 'fa fa-exclamation-circle ',
        title: 'Ooppss!! Error in Updating the Prescription Details',
        content: 'Faced an issue in adding Updating the Prescription Details, Please Try Again',
        columnClass: 'col-md-4 col-md-offset-4',
        type: 'red',
        draggable: false,
        theme: 'modern',
        buttons: {
          again: {
            text: 'Try Again',
            btnClass: 'btn-red',
            keys: ['enter'],
            action: function() {
              window.location.href = '<?php echo basename($_SERVER['REQUEST_URI']) ?>';
            }
          }
        }
      });
    </script>
    <?php
  }
}

if (isset($_POST['addMedicine'])) {

  $medicine = $_POST['medicine_id'];
  $quantity = $_POST['quantity'];
  $startDate = $_POST['startDate'];
  $endDate = $_POST['endDate'];
  $usageTime_id = $_POST['usageTime_id'];
  $usageState_id = $_POST['usageState_id'];



  $sql_precribingmedicine = "INSERT INTO `precribingmedicine`( `preMed_precribingDate`, `preMed_precribingOverDate`, `pre_id_fk`, `med_id_fk`) 
          VALUES ('$startDate','$endDate','$prescriptionID','$medicine')";

  $exec_precribingmedicine = mysqli_query($con, $sql_precribingmedicine);

  $lastInserted_pm = mysqli_insert_id($con);

  if ($lastInserted_pm > 0) {

    $sql_doseUsage = "INSERT INTO `doseusage`(`preMed_id_fk`, `usageTime_id_fk`, `medicineUsingState_id_fk`, `doseQuantity`) 
                   VALUES ('$lastInserted_pm','$usageTime_id ','$usageState_id ','$quantity')";

    $exec_doseUsage = mysqli_query($con, $sql_doseUsage);

    if ($exec_doseUsage) {
    ?>
      <script>
        $.confirm({
          icon: 'fa fa-check-circle ',
          title: 'Medicine Added Successfully',
          content: 'Medicine has added successfully',
          columnClass: 'col-md-4 col-md-offset-4',
          draggable: false,
          theme: 'modern'
        });
      </script>
    <?php
    } else {
    ?>
      <script>
        $.confirm({
          icon: 'fa fa-exclamation-circle ',
          title: 'Ooppss!! Error adding the medicine',
          content: 'Faced an issue in adding the medicine, Please Try Again',
          columnClass: 'col-md-4 col-md-offset-4',
          type: 'red',
          draggable: false,
          theme: 'modern',
          buttons: {
            again: {
              text: 'Try Again',
              btnClass: 'btn-red',
              keys: ['enter'],
              action: function() {
                window.location.href = '<?php echo basename($_SERVER['REQUEST_URI']) ?>';
              }
            }
          }
        });
      </script>
<?php
    }
  }
}


?>