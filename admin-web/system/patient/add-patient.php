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
                <h3>Add New Patient</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php"> <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Patient</li>
                  <li class="breadcrumb-item">Add Patient</li>
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


                  <form method="POST" class="needs-validation" enctype="multipart/form-data" novalidate="">
                    <div class="row g-3">

                      <div class="col-12 d-flex justify-content-center">
                        <div class="col-md-2">
                          <label class="form-label" for="validationCustom01">Patient Image</label>
                          <div class="p-0">
                            <div class="logo-c-image logo p-0">
                              <img id="rbtinput1" src="../../assets/images/imageupload-preview.jpeg" alt="Profile-NFT">
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
                        <input name="p_name" class="form-control" id="validationCustom01" type="text" placeholder="Name" required="">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please Add a Name</div>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom01">Patient NIC</label>
                        <input name="p_nic" class="form-control" id="validationCustom01" type="text" placeholder="Patient NIC" required="">
                        <div class="valid-feedback">Looks good!</div>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom01">Patient Email</label>
                        <input name="p_email" class="form-control" id="validationCustom01" type="text" placeholder="Patient Email" required="">
                        <div class="valid-feedback">Looks good!</div>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom01">Patient DOB</label>
                        <input name="p_dob" class="form-control" id="validationCustom01" type="date" required="">
                        <div class="valid-feedback">Looks good!</div>
                      </div>

                      <div class="col-12">
                        <div class="row">
                          <div class="col-6">
                            <div class="col-md-12">
                              <label class="form-label" for="validationCustom01">Patient Address</label>
                              <textarea name="p_address" rows="5" class="form-control" id="validationCustom01" type="date" placeholder="Patient Address" required=""></textarea>
                              <div class="valid-feedback">Looks good!</div>
                            </div>
                          </div>

                          <div class="col-6">
                            <div class="col-md-12">
                              <label class="form-label" for="validationCustom04">Gender</label>
                              <select name="p_gender" class="form-select" id="validationCustom04" required="">
                                <option selected="" disabled="" value="">Choose...</option>
                                <?php
                                include "../../connection/db.php";
                                $sql = "SELECT * FROM gender";
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
                              <input name="p_contact" class="form-control" id="validationCustom01" placeholder="Contact Number" type="number" required="">
                              <div class="valid-feedback">Looks good!</div>
                              <div class="invalid-feedback">Please Enter the Phone Number</div>
                            </div>


                          </div>
                        </div>
                      </div>

                      <div class="col-md-12 d-flex justify-content-center align-items-center mt-3">
                        <div class="row">
                          <div class="col-3">
                            <button onclick="showGurdianForm()" class="btn btn-primary d-flex justify-content-center align-items-center" style="width: 200px;"><i class="fa fa-plus m-5"></i> ADD A GURDIAN </button>
                          </div>
                        </div>
                      </div>

                      <div id="gurdianDetails" class="row g-3">

                      </div>

                      <div class="d-flex flex-column align-items-start align-items-center sub-btnsize ">
                        <button name="submit" class="mt-4 btn btn-success" type="submit"><i class="fa fa-plus-square"></i> Add New Patient</button>
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

  <script>
    $(document).ready(function() {
      $("#gurdianDetails").hide();
    });

    function showGurdianForm() {
      $("#gurdianDetails").show();
      $("#gurdianDetails").append('<div class="col-md-6"> <label class="form-label" for="validationCustom01">Gurdian Name</label> <input name="gur_name" class="form-control" id="validationCustom01" type="text" placeholder="Name" required=""> <div class="valid-feedback">Looks good!</div> <div class="invalid-feedback">Please Add a Name</div> </div> <div class="col-md-6"> <label class="form-label" for="validationCustom01">Gurdian Phone No. </label> <input name="gur_phone" class="form-control" id="validationCustom01" type="number" placeholder="Phone Number" required=""> <div class="valid-feedback">Looks good!</div> <div class="invalid-feedback">Please Enter a Number</div> </div> <div class="col-12"> <div class="col-md-12"> <label class="form-label" for="validationCustom01">Gurdian Address</label> <textarea name="gur_desc" rows="5" class="form-control" id="validationCustom01" type="date" placeholder="Eg. Admitted the Patient in the Hospital, How is the gurdian Related to the Person" required=""></textarea> <div class="valid-feedback">Looks good!</div> <div class="invalid-feedback">Please Enter a Description</div> </div> </div>')
    }
  </script>

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
        $patientImage = $imageName;
      } else {
?>
        <script>
          alert("Error in Uploading Image...!! Error Status: <?php echo $errorMessage ?> ")
        </script>
    <?php
      }
    }
  }


  if ($imageUploadStatus) {

    $p_name = $_POST['p_name'];
    $p_nic = $_POST['p_nic'];
    $p_email = $_POST['p_email'];
    $p_dob = $_POST['p_dob'];
    $p_address = $_POST['p_address'];
    $p_gender = $_POST['p_gender'];
    $p_contact = $_POST['p_contact'];

    $usernameSplit = explode(" ", $p_name);
    $usernamefinal = $usernameSplit[0];

    $randNumber = generateRandNo(4);
    
    $p_password =  $randNumber . "-" . $usernamefinal; // Should Generate Automatically <RAND>-<NAME>-<DOB>

    $p_contactOTP = " "; // Should Generate Automatically
    $p_emailVeriLink = "emailVeriLink"; // Should Generate Automatically

    $encrypt_password = encryptMessage($p_password);

    $patient_ins_sql = "INSERT INTO `patient`( `p_name`, `p_nic`, `p_dob`, `p_img`, `p_contact`, `p_email`, `p_emailVeriLink`, `p_password`, `gender_fk`,`p_address`) VALUES ('$p_name','$p_nic','$p_dob','$patientImage','$p_contact','$p_email','$p_emailVeriLink','$encrypt_password','$p_gender','$p_address')";


    $exec_ins_pai = mysqli_query($con, $patient_ins_sql);

    if ($exec_ins_pai) {

      $patient_id = mysqli_insert_id($con);

      $p_username = "PA-" . $patient_id . "-" . $usernamefinal; 

      // echo $p_username;

      $updateUsername = "UPDATE `patient` SET `p_username`='$p_username' WHERE `p_id`= $patient_id ";

      $exec_upd_username = mysqli_query($con, $updateUsername);
      if ($exec_upd_username) {

        if (isset($_POST['gur_name']) && isset($_POST['gur_phone']) && isset($_POST['gur_desc'])) {
          $gur_name = $_POST['gur_name'];
          $gur_phone = $_POST['gur_phone'];
          $gur_desc = $_POST['gur_desc'];

          $gur_sql = "INSERT INTO `gurdiandetails`( `gur_name`, `gur_phoneNo`, `gur_desc`,`p_id_fk` ) VALUES ('$gur_name','$gur_phone','$gur_desc','$patient_id')";

          $gur_exec = mysqli_query($con, $gur_sql);

          if (!$gur_exec) {
          ?>
            <script>
              alert("Ooops!! Error in inserting the gurdian... Please Try Again")
            </script>
          <?php
          }
        }

        $user = "94776421885";
        $password = "6260";
        $string = "Hii, Thank you for Registering with GB Health Care.%0D%0AHere are your login credentials%0D%0AUsername %3A $p_username %0D%0APassword %3A $p_password " ;       
        $text = urlencode($string);

        $to = $p_contact;

        $baseurl = "http://www.textit.biz/sendmsg";
        $url = "$baseurl/?id=$user&pw=$password&to=$to&text=$text";

        $ret = file($url);

        $res = explode(":", $ret[0]);

        if (trim($res[0]) == "OK") {
          
        } else {
          ?>
            <script>
              alert("<?php echo "Sent Failed - Error : " . $res[1]; ?>");
            </script>
          <?php
        }
        
        ?>
        <script>
          $.confirm({
            icon: 'fa fa-check-circle ',
            title: 'Patient Inserted Successfully',
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
                  window.location.href = 'manage-patient.php';
                }
              },
              proceed: {
                text: 'Continue to Appointment',
                btnClass: 'btn-blue',
                keys: ['enter'],
                action: function() {
                  window.location.href = '<?php echo $base_url ?>system/booking/add-booking.php?p_id=<?php echo $patient_id ?>';
                }
              },
              again: {
                text: 'Add Another Data',
                btnClass: 'btn-blue',
                keys: ['enter'],
                action: function() {
                  window.location.href = 'add-patient.php';
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
            title: 'Ooppss!! Error in Adding Patient',
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
                  window.location.href = 'add-patient.php';
                }
              }
            }
          });
        </script>
      <?php
      }
    } else {
      ?>
      <script>
        $.confirm({
          icon: 'fa fa-exclamation-circle ',
          title: 'Ooppss!! Error in Adding Patient',
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
                window.location.href = 'add-patient.php';
              }
            }
          }
        });
      </script>
<?php
    }


    // Phone iku Message Pora Code Eluththanum 

  }
}




?>