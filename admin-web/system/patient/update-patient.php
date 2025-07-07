<!DOCTYPE html>
<html lang="en">

<?php

include '../../components/head.php';

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
                <h3>Update Patient Info</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php"> <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Patient</li>
                  <li class="breadcrumb-item">Update Patient Details</li>
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

                  <?php
                  if (isset($_GET['upd_id'])) {

                    include '../../connection/db.php';

                    $patientID = $_GET['upd_id'];

                    $patient_sql = "SELECT `patient`.*, `gender`.*
                              FROM `patient` 
                              INNER JOIN `gender` ON `patient`.`gender_fk` = `gender`.`gender_id` WHERE p_id = '$patientID' ;";

                    $patient_exec = mysqli_query($con, $patient_sql);

                    while ($row = mysqli_fetch_array($patient_exec)) {
                      $patient_image = $row['p_img'];
                      $name = $row['p_name'];
                      $nic = $row['p_nic'];
                      $email = $row['p_email'];
                      $dob = $row['p_dob'];
                      $address = $row['p_address'];
                      $gender_id = $row['gender_fk'];
                      $genderName = $row['gender'];
                      $contact = $row['p_contact'];
                    }
                  }

                  ?>


                  <form method="POST" class="needs-validation" enctype="multipart/form-data" novalidate="">
                    <div class="row g-3">

                      <div class="col-12 d-flex justify-content-center">
                        <div class="col-md-2">
                          <label class="form-label" for="validationCustom01">Select a Patient Image</label>
                          <div class="p-0">
                            <div class="logo-c-image logo p-0">
                              <img id="rbtinput1" src="../../uploads/patient/<?php echo $patient_image ?>" alt="Profile-NFT">
                              <label for="fatima" title="No File Choosen">
                                <span class="text-center color-white"><i class="feather-edit"></i></span>
                              </label>
                            </div>
                            <div class="button-area">
                              <div class="brows-file-wrapper">
                                <!-- actual upload which is hidden -->
                                <input name="fileToUpload" id="fatima" type="file">
                                <!-- our custom upload button -->
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom01">Patient Name</label>
                        <input name="p_name" value="<?php echo $name ?>" class="form-control" id="validationCustom01" type="text" placeholder="Name" required="">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please Add a Name</div>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom01">Patient NIC</label>
                        <input name="p_nic" value="<?php echo $nic ?>" class="form-control" id="validationCustom01" type="text" placeholder="Patient NIC" required="">
                        <div class="valid-feedback">Looks good!</div>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom01">Patient Email</label>
                        <input name="p_email" value="<?php echo $email ?>" class="form-control" id="validationCustom01" type="text" placeholder="Patient Email" required="">
                        <div class="valid-feedback">Looks good!</div>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom01">Patient DOB</label>
                        <input name="p_dob" value="<?php echo $dob ?>" class="form-control" id="validationCustom01" type="date" required="">
                        <div class="valid-feedback">Looks good!</div>
                      </div>

                      <div class="col-12">
                        <div class="row">
                          <div class="col-6">
                            <div class="col-md-12">
                              <label class="form-label" for="validationCustom01">Patient Address</label>
                              <textarea name="p_address" rows="5" class="form-control" id="validationCustom01" type="date" placeholder="Patient Address" required=""><?php echo $address ?></textarea>
                              <div class="valid-feedback">Looks good!</div>
                            </div>
                          </div>

                          <div class="col-6">
                            <div class="col-md-12">
                              <label class="form-label" for="validationCustom04">Gender</label>
                              <select name="p_gender" class="form-select" id="validationCustom04" required="">
                                <option selected="" value="<?php echo $gender_id ?>"><?php echo $genderName ?></option>
                                <?php
                                include "../../connection/db.php";
                                $sql = "SELECT * FROM gender WHERE gender_id !=  $gender_id ";
                                $exec = mysqli_query($con, $sql);
                                while ($row = mysqli_fetch_array($exec)) {
                                ?>
                                  <option value="<?php echo $row['gender_id'] ?> "><?php echo $row['gender'] ?></option>
                                <?php
                                }
                                ?>
                              </select>
                              <div class="invalid-feedback">Please select a valid gender.</div>
                            </div>

                            <div class="col-md-12 mt-4">
                              <label class="form-label" for="validationCustom01">Patient Contact Number</label>
                              <input name="p_contact" value="<?php echo $contact ?>" class="form-control" id="validationCustom01" placeholder="Contact Number" type="number" required="">
                              <div class="valid-feedback">Looks good!</div>
                              <div class="invalid-feedback">Please Enter the Phone Number</div>
                            </div>


                          </div>
                        </div>
                      </div>

                      <!-- <div class="col-md-12 d-flex justify-content-center align-items-center mt-3">
                        <div class="row">
                          <div class="col-3">
                            <button onclick="showGurdianForm()" class="btn btn-primary d-flex justify-content-center align-items-center" style="width: 200px;"><i class="fa fa-plus m-5"></i> ADD A GURDIAN </button>
                          </div>
                        </div>
                      </div> -->

                      <div id="gurdianDetails" class="row g-3">

                      </div>

                      <div class="d-flex flex-column align-items-start align-items-center sub-btnsize ">
                        <button name="submit" class="mt-4 btn btn-success" type="submit"><i class="fa fa-plus-square"></i> Update Patient Info</button>
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
    $("#rbtinput1").click(function(e) {
      $("#fatima").click();
    });

    function rbtPreview() {
      const [file] = fatima.files
      if (file) {
        rbtinput1.src = URL.createObjectURL(file)
      }
    }
    $("#fatima").change(function() {
      rbtPreview(this);
    });
  </script>

  <!-- <script>
    $(document).ready(function() {
      $("#gurdianDetails").hide();
    });

    function showGurdianForm() {
      $("#gurdianDetails").show();
      $("#gurdianDetails").append('<div class="col-md-6"> <label class="form-label" for="validationCustom01">Gurdian Name</label> <input name="gur_name" class="form-control" id="validationCustom01" type="text" placeholder="Name" required=""> <div class="valid-feedback">Looks good!</div> <div class="invalid-feedback">Please Add a Name</div> </div> <div class="col-md-6"> <label class="form-label" for="validationCustom01">Gurdian Phone No. </label> <input name="gur_phone" class="form-control" id="validationCustom01" type="number" placeholder="Phone Number" required=""> <div class="valid-feedback">Looks good!</div> <div class="invalid-feedback">Please Enter a Number</div> </div> <div class="col-12"> <div class="col-md-12"> <label class="form-label" for="validationCustom01">Gurdian Address</label> <textarea name="gur_desc" rows="5" class="form-control" id="validationCustom01" type="date" placeholder="Eg. Admitted the Patient in the Hospital, How is the gurdian Related to the Person" required=""></textarea> <div class="valid-feedback">Looks good!</div> <div class="invalid-feedback">Please Enter a Description</div> </div> </div>')
    }
  </script> -->

</body>

</html>


<?php

include '../../connection/db.php';

include '../../components/functions.php';

if (isset($_POST['submit'])) {

  // Null Variable Declaring
  $gur_id_fk = " ";

  $patientImage = 'defaultpatient.jpg';
  $imageUploadStatus = true;

  if ($_FILES["fileToUpload"]["name"] != null) {

    $patient_image = $imageName;

    $imageUploadStatus = false;
    $errorMessage = " ";
    $target_dir = "../../uploads/patient/";
    $imageName = rand() . basename($_FILES["fileToUpload"]["name"]);
    $target_file = $target_dir . $imageName;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
      $uploadOk = 1;
    } else {
      $errorMessage .= "File is not an image.";
      $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
      $errorMessage .= "Sorry, file already exists.";
      $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
      $errorMessage .= "Sorry, your file is too large.";
      $uploadOk = 0;
    }

    // Allow certain file formats
    if (
      $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif"
    ) {
      $errorMessage .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      $errorMessage .= "Sorry, your file was not uploaded.";
      // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $imageUploadStatus = true;
        $patient_image = $imageName;
      } else {
    ?>
        <script>
          alert("Error in Uploading Image...!! Error Status: <?php echo $errorMessage ?> ")
        </script>
    <?php
      }
    }
  }
    
    $p_name = $_POST['p_name'];
    $p_nic = $_POST['p_nic'];
    $p_email = $_POST['p_email'];
    $p_dob = $_POST['p_dob'];
    $p_address = $_POST['p_address'];
    $p_gender = $_POST['p_gender'];
    $p_contact = $_POST['p_contact'];

    $patient_upd_sql = "UPDATE `patient` SET `p_name`='$p_name',`p_nic`='$p_nic',`p_dob`='$p_dob',`p_img`='$patient_image',`p_contact`='$p_contact',`p_email`='$p_email', `gender_fk`='$p_gender',`p_address`='$p_address' WHERE patient.p_id = '$patientID' ";

    $exec_upd_pai = mysqli_query($con, $patient_upd_sql);

    if ($exec_upd_pai) {
        ?>
        <script>
          $.confirm({
            icon: 'fa fa-check-circle ',
            title: 'Patient Updated Successfully',
            content: 'Your Data is Updated Successfully',
            columnClass: 'col-md-4 col-md-offset-4',
            draggable: false,
            theme: 'modern',
            buttons: {
              confirm: {
                text: 'Back to View',
                btnClass: 'btn-blue',
                keys: ['shift'],
                action: function() {
                  window.location.href = 'manage-patient.php';
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
          title: 'Ooppss!! Error in Updating Patient',
          content: 'Faced an issue in adding Patient, Please Try Again',
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
                window.location.href = 'manage-patient.php';
              }
            }
          }
        });
      </script>
    <?php
    
  }
}




?>