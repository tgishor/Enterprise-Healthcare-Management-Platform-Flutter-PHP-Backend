<!DOCTYPE html>
<html lang="en">

<?php

include '../../components/head.php';


if (isset($_GET['p_id'])) {
  $patientID = $_GET['p_id'];
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
                <h3>Add New Appointment</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php"> <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Appointment</li>
                  <li class="breadcrumb-item">Add Appointment</li>
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

                      <div class="col-md-12">
                        <label class="form-label" for="validationCustom01">Appointment Description</label>
                        <textarea name="book_desc" rows="5" class="form-control" id="validationCustom01" type="text" placeholder="Problems Faced by the Patient & Other" required=""></textarea>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please Add a Description</div>
                      </div>

                      <div class="col-md-12">

                        <label for="organizerMultiple">Select the Diseases</label>
                        <select class="form-select js-choice" id="organizerMultiple" multiple="multiple" size="1" name="diseasesList[]" data-options='{"removeItemButton":true,"placeholder":true}'>
                          <option value="">Select the Problems...</option>
                          <?php
                          include '../../connection/db.php';
                          $sql = "SELECT * FROM disease";

                          $exec = mysqli_query($con, $sql);
                          while ($row = mysqli_fetch_array($exec)) {
                          ?>
                            <option value="<?php echo $row['dis_id'] ?>"><?php echo $row['dis_name'] ?></option>
                          <?php
                          }
                          ?>

                          <!-- <option>University of Chicago</option>
                          <option>GSAS Open Labs At Harvard</option>
                          <option>California Institute of Technology</option> -->
                        </select>

                      </div>

                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom04">Select the Hospital Location</label>
                        <select name="hos_location" id="hospitalselector" class="form-select" id="validationCustom04" required="">
                          <option selected="" disabled="" value="">Choose...</option>
                          <?php
                          include '../../connection/db.php';
                          $sql = "SELECT * FROM hospital";

                          $exec = mysqli_query($con, $sql);
                          while ($row = mysqli_fetch_array($exec)) {
                          ?>
                            <option value="<?php echo $row['hos_id'] ?>"><?php echo $row['hos_branch'] ?></option>
                          <?php
                          }
                          ?>
                        </select>
                        <div class="invalid-feedback">Please select a valid Hospital Location.</div>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label" for="allocatedatetime">Allocate DateTime</label>
                        <input id="allocatedatetime" class="form-control" type="datetime-local" name="book_allocatedDateTime" id="">
                        <!-- <div class="input-group date" id="dt-minimum" data-target-input="nearest">
                          <input name="book_allocatedDateTime" class="form-control datetimepicker-input digits" type="text" data-target="#dt-minimum" required>
                          <div class="input-group-text" data-target="#dt-minimum" data-toggle="datetimepicker"><i class="fa fa-calendar"> </i></div>
                        </div> -->
                      </div>


                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom04">Doctor Name</label>
                        <select name="doctor_id" class="form-select selectDoctor" id="validationCustom04" required="">
                          <option selected="" disabled="" value="">Choose...</option>
                        </select>
                        <div class="invalid-feedback">Please select a valid Doctor Name.</div>
                      </div>

                      <?php
                      if (isset($_GET['p_id'])) {
                      ?>
                        <div class="col-md-6">
                          <label class="form-label" for="validationCustom04">Patient Name</label>
                          <select name="patient_id" class="form-select" id="validationCustom04" required="">
                            <?php
                            include '../../connection/db.php';
                            $sql = "SELECT * FROM patient WHERE p_id = $patientID";

                            $exec = mysqli_query($con, $sql);
                            while ($row = mysqli_fetch_array($exec)) {
                            ?>
                              <option selected="" value="<?php echo $row['p_id'] ?>"><?php echo $row['p_name'] . " | " . $row['p_nic'] ?></option>
                            <?php
                            }
                            ?>
                          </select>
                          <div class="invalid-feedback">Please select a valid Patient Name.</div>
                        </div>
                      <?php
                      } else {
                      ?>
                        <div class="col-md-6">
                          <label class="form-label" for="validationCustom04">Patient Name</label>
                          <select name="patient_id" class="form-select js-choice" id="validationCustom04" required="">
                            <option selected="" disabled="" value="">Choose...</option>
                            <?php
                            include '../../connection/db.php';
                            $sql = "SELECT * FROM patient";

                            $exec = mysqli_query($con, $sql);
                            while ($row = mysqli_fetch_array($exec)) {
                            ?>
                              <option value="<?php echo $row['p_id'] ?>"><?php echo $row['p_name'] . " | " . $row['p_nic'] ?></option>
                            <?php
                            }
                            ?>
                          </select>
                          <div class="invalid-feedback">Please select a valid Patient Name.</div>
                        </div>
                      <?php
                      }
                      ?>

                      <div id="table-container" class="col-md-12 d-flex justify-content-center">

                      </div>

                    </div>

                    <div class="d-flex flex-column align-items-start align-items-center sub-btnsize ">
                      <button name="submit" id="submit" class="mt-4 btn btn-success" type="submit"><i class="fa fa-plus-square"></i> Add New Appointment</button>
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

  $patientID = $_POST['patient_id'];

  foreach ($_POST['diseasesList'] as $diseaseName) {

    $sql = "INSERT INTO `paitenthasdisease`(`p_id_fk`, `dis_id_fk`) VALUES ('$patientID','$diseaseName') ";

?>
    <script>
      alert(<?php echo $sql ?>)
    </script>
  <?php

    $exec = mysqli_query($con, $sql);
  }

  $book_desc = $_POST['book_desc'];
  $hos_location = $_POST['hos_location'];
  $book_allocatedDateTime = $_POST['book_allocatedDateTime'];
  $doctor_id = $_POST['doctor_id'];
  $patient_id = $_POST['patient_id'];

  $staffID = "1";

  $sql_booking = "INSERT INTO `booking`(`book_desc`, `book_allocateDateTime`, `p_id_fk`, `staff_id_fk`, `doc_id_fk`, `hos_id_fk`) VALUES ('$book_desc','$book_allocatedDateTime','$patient_id','$staffID','$doctor_id','$hos_location')";

  ?>
  <script>
    alert('<?php echo $sql_booking ?>')
  </script>
  <?php

  $exec_booking = mysqli_query($con, $sql_booking);

  if ($exec_booking) {
  ?>
    <script>
      $.confirm({
        icon: 'fa fa-check-circle ',
        title: 'Booking Added Successfully',
        content: 'Your Data is Inserted Successfully',
        columnClass: 'col-md-4 col-md-offset-4',
        draggable: false,
        theme: 'modern',
        buttons: {
          confirm: {
            text: 'Back to View',
            btnClass: 'btn-blue',
            keys: ['shift'],
            action: function() {
              window.location.href = 'manage-booking.php';
            }
          },
          again: {
            text: 'Add Another Data',
            btnClass: 'btn-blue',
            keys: ['enter'],
            action: function() {
              window.location.href = 'add-booking.php';
            }
          }
        }
      });
    </script>
  <?php
  } else {
  ?>
    <script>
      $.confirm({
        icon: 'fa fa-exclamation-circle ',
        title: 'Ooppss!! Error in Adding a Booking',
        content: 'Faced an issue in adding Booking, Please Try Again',
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
              window.location.href = 'add-booking.php';
            }
          }
        }
      });
    </script>
<?php
  }
}


?>