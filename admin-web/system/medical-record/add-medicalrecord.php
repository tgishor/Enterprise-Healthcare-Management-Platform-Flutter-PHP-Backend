<!DOCTYPE html>
<html lang="en">

<?php

include '../../components/head.php';


if (isset($_GET['book_id'])) {
  $bookingID = $_GET['book_id'];
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
                <h3>Add New Medical Record</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php"> <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Medical Record</li>
                  <li class="breadcrumb-item">Add Medical Record</li>
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


                  <form method="POST" class="needs-validation" novalidate="" enctype="multipart/form-data">
                    <div class="row g-3">

                      <div class="col-md-12 ">
                        <div class="row">

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
                                <button class="btn btn-primary rounded-2" onclick="window.location.href='view-medicalrecord.php?p_id=<?php echo $patientID ?>'" style="margin-right:15px ;"> Previous Medi Records </button>
                                <button class="btn btn-primary rounded-2"> View More Info </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-12 ">
                        <label class="form-label" for="validationCustom01">Medical Record Description</label>
                        <textarea name="mediRecord_desc" rows="5" class="form-control" id="validationCustom01" type="text" placeholder="Overall Summary for the Solution" required=""></textarea>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please Add a Description</div>
                      </div>

                      <div class="d-flex flex-column align-items-start align-items-center sub-btnsize mb-3 ">
                        <button name="submit" id="submit" class="mt-4 btn btn-success" type="submit"><i class="fa fa-plus-square"></i> Proceed with Adding Medicine</button>
                      </div>


                    </div>


                  </form>

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
    // Pass single element
    const element = document.querySelector('.js-choice');
    const choices = new Choices(element);
  </script>

  <script>
    $("#hospitalselector").on('change', function() {

      $('.selectDoctor option:not(:first)').remove();

      var selected_id = this.value;
      console.log(selected_id);

      $.ajax({
        type: "GET",
        url: "select-doctor.php?hos_id=" + selected_id,
        dataType: "html",
        success: function(data) {
          $('.selectDoctor').append(data);
          console.log(data);
        }
      });

    });

    $(".selectDoctor").on('change', function() {

      var selected_id = this.value;

      console.log(selected_id);

      if (this.value > 0) {
        $.ajax({
          type: "GET",
          url: "get-doctor-info.php?doc_id=" + selected_id,
          dataType: "html",
          success: function(data) {
            $("#table-container").html(data)
            console.log(data);
          }
        });
      }

    });
  </script>


</body>

</html>


<?php

if (isset($_POST['submit'])) {

  $medirecord_desc = $_POST['mediRecord_desc'];

  $sql_medicalrecord = "INSERT INTO `medicalrecord`( `mediRec_desc`, `book_id_fk`) VALUES ('$medirecord_desc ','$bookingID')";
  $exec_medicalrecord = mysqli_query($con, $sql_medicalrecord);
  $mediRecInsertID = mysqli_insert_id($con);

  $sql_prescription = "INSERT INTO `prescription`(`mediRec_id_fk`) VALUES ('$mediRecInsertID')";
  $exec_prescription = mysqli_query($con, $sql_prescription);
  $prescriptionInsertID = mysqli_insert_id($con);

  $sql_updateBookStatus = "UPDATE `booking` SET `bookStatus_id_fk`='2' WHERE `book_id`= $bookingID";
  $exec_updateBookStatus = mysqli_query($con, $sql_updateBookStatus);

  if (!$exec_updateBookStatus) {
?>
    <script>
      alert('Error in Updating the Booking Status');
    </script>
  <?php
  }


  if ($prescriptionInsertID > 0) {
  ?>
    <script>
      window.location.href = "assign-medicine.php?pre_id=<?php echo $prescriptionInsertID ?>";
    </script>
  <?php
  } else {
  ?>
    <script>
      $.confirm({
        icon: 'fa fa-exclamation-circle ',
        title: 'Ooppss!! Error in Adding a Medical Record',
        content: 'Faced an issue in adding Medical Record, Please Try Again',
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
              window.location.href = 'add-medicalrecord.php';
            }
          }
        }
      });
    </script>
<?php
  }
}


?>