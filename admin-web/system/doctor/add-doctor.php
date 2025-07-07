<!DOCTYPE html>
<html lang="en">

<?php 

include '../../components/head.php';

if(isset($_SESSION['adminID'])){
  $adminID = $_SESSION['adminID'];
}else{
  ?>
  <script>
    window.location.href = '<?php echo $base_url."system/home/login.php" ?>'
  </script>
  <?php
}

?>

<style>

</style>

<body onload="startTime()">

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
                <h3>Add New Doctor</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php"> <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Doctor</li>
                  <li class="breadcrumb-item">Add Doctor</li>
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
                      <div class="col-12 d-flex justify-content-center">
                        <div class="col-md-2">
                          <label class="form-label" for="validationCustom01">Doctor Image</label>
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
                        <label class="form-label" for="validationCustom01">Doctor Name</label>
                        <input name="doc_name" class="form-control" id="validationCustom01" type="text" placeholder="Name" required="">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please Add a Name</div>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom01">Doctor Contact</label>
                        <input name="doc_contact" class="form-control" id="validationCustom01" type="number" placeholder="Doctor Contact" required="">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please Add a Number</div>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom01">Patient Medical License No.</label>
                        <input name="doc_medLic" class="form-control" id="validationCustom01" type="text" placeholder="Eg. USMLE-1523VA96-4563, LMCC-153151BGAU-46123" required="">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please Add a License Number</div>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom01">Doctor Email</label>
                        <input name="doc_email" class="form-control" id="validationCustom01" type="email" placeholder="Doctor Email" required="">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please Add a Email</div>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom01">Disease Category Assigned</label>
                        <select name="doc_disCat" class="form-select" id="validationCustom04" required="">
                          <option selected="" disabled="" value="">Choose a Disease Category...</option>
                          <?php
                          include "../../connection/db.php";

                          $sql = "SELECT * FROM diseasecategory";

                          $exec = mysqli_query($con, $sql);
                          while ($row = mysqli_fetch_array($exec)) {
                          ?>
                            <option value="<?php echo $row['disCat_id'] ?>"><?php echo $row['disCat_name'] ?></option>
                          <?php
                          }
                          ?>
                        </select>
                        <div class="invalid-feedback">Please select a valid Disease Category.</div>
                      </div>
                          
                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom01">Incharged Hospital</label>
                        <select name="doc_hosLoc" class="form-select" id="validationCustom04" required="">
                          <option selected="" disabled="" value="">Choose a Hospital Location...</option>
                          <?php

                          $sql = "SELECT * FROM hospital";

                          $exec = mysqli_query($con, $sql);
                          while ($row = mysqli_fetch_array($exec)) {
                          ?>
                            <option value="<?php echo $row['hos_id'] ?>"><?php echo $row['hos_branch'] ?></option>
                          <?php
                          }
                          ?>
                        </select>
                        <div class="invalid-feedback">Please select a valid Disease Category.</div>
                      </div>

                      <div class="">
                        <div class="d-flex justify-content-center align-content-center">
                          <div class="media mb-2 border p-3">
                            <label class="col-form-label m-r-10">Specialist</label>
                            <div class="media-body text-end icon-state">
                              <label class="switch">
                                <input name="doc_spec" type="checkbox" checked><span class="switch-state"></span>
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>

                    <div class="d-flex flex-column align-items-start align-items-center sub-btnsize ">
                      <button name="submit" id="submit" class="mt-4 btn btn-success" type="submit"><i class="fa fa-plus-square"></i> Add Doctor</button>
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



</body>

</html>

<?php

include '../../connection/db.php';
include '../../components/functions.php';

if (isset($_POST['submit'])) {

  $auto_gen_docPassKey = rand_string(9);

  $doc_name = $_POST['doc_name'];
  $doc_contact = $_POST['doc_contact'];
  $doc_medLic = $_POST['doc_medLic'];
  $doc_email = $_POST['doc_email'];
  $doc_disCat = $_POST['doc_disCat'];
  $doc_hosLoc = $_POST['doc_hosLoc'];

  $sessionAdminID = $_SESSION['adminID'];

  if (isset($_POST['doc_spec'])) {
    $doc_spec = "1";
  } else {
    $doc_spec = "0";
  }

  $encryptedPassKey = encryptMessage($auto_gen_docPassKey);

  $errorMessage = " ";
  $target_dir = "../../uploads/doctor/";
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


      $swap_var = array(
        "{DOCTORNAME}" => "$doc_name",
        "{USERNAME}" => "$doc_email",
        "{PASSWORD}" => "$auto_gen_docPassKey"
      );

      if (sendMail($doc_email, "Doctor Account Registration Successful", "email-template.html", $swap_var)) {

        $sql = "INSERT INTO `doctor`(`doc_name`, `doc_contact`, `doc_mediLicenseNo`, `specilist`, `disCat_id_fk`, `hos_id_fk`, `doc_username`, `doc_password`, `adm_id_fk`,`doc_img`) VALUES ('$doc_name','$doc_contact','$doc_medLic','$doc_spec','$doc_disCat','$doc_hosLoc','$doc_email','$encryptedPassKey','$sessionAdminID','$imageName')";

        $exec = mysqli_query($con, $sql);

        if ($exec) {
        ?>
          <script>
            $.confirm({
              icon: 'fa fa-check-circle ',
              title: 'Doctor Added Successfully',
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
                    window.location.href = 'manage-doctor.php';
                  }
                },
                again: {
                  text: 'Add Another Data',
                  btnClass: 'btn-blue',
                  keys: ['enter'],
                  action: function() {
                    window.location.href = 'add-doctor.php';
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
              icon: 'fa fa-check-circle ',
              title: 'Ooops!! Error in Inserting Data',
              content: 'Insert Function Failed...!!! Please Try Again',
              columnClass: 'col-md-4 col-md-offset-4',
              draggable: false,
              theme: 'modern',
              buttons: {
                again: {
                  text: 'Try Again',
                  btnClass: 'btn-blue',
                  keys: ['enter'],
                  action: function() {
                    window.location.href = 'add-doctor.php';
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
          alert("Error in Sending the Mail... Please Try Again")
        </script>
      <?php
      }
    } else {
      ?>
      <script>
        alert("Error in Uploading Image... Please Try Again..... ")
      </script>
<?php
    }
  }
}


?>