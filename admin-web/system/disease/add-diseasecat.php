<!DOCTYPE html>
<html lang="en">

<?php include '../../components/head.php' ?>

<style>
  .logo-c-image.logo {
    position: relative;
    display: inline-block;
  }

  .logo-c-image img {
    border: 3px dashed #ffffff14;
    object-fit: cover;
    cursor: pointer;
    vertical-align: middle;
    max-width: 100%;
    height: auto;
  }

  .logo-c-image.logo label {
    position: absolute;
    cursor: pointer;
    height: 35px;
    width: 35px;
    border-radius: 50%;
    background: var(--background-color-4);
    display: flex;
    align-items: center;
    justify-content: center;
    top: 19px;
    right: 13px;
    border: 1px solid var(--color-border);
    transition: var(--transition);
  }

  .brows-file-wrapper input {
    display: none;
  }
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
                <h3>Add New Disease Category</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php"> <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Disease</li>
                  <li class="breadcrumb-item">Add Disease Category</li>
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


                      
                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom01">Disease Category Name</label>
                        <input name="disCat_name" class="form-control" id="validationCustom01" type="text" placeholder="Name" required="">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please Add a Name</div>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom01">Disease Category Description</label>
                        <input name="disCat_desc" class="form-control" id="validationCustom01" type="text" placeholder="Description" required="">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please Add a Name</div>
                      </div>


                    <div class="d-flex flex-column align-items-start align-items-center sub-btnsize ">
                      <button name="submit" id="submit" class="mt-4 btn btn-success" type="submit"><i class="fa fa-plus-square"></i> Add New  Disease Category</button>
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
include "../../connection/db.php";

if (isset($_POST['submit'])) {

  $disCat_name = $_POST['disCat_name'];
  $disCat_desc = $_POST['disCat_desc'];
  $sql =  "INSERT INTO `diseasecategory`(`disCat_name`, `disCat_desc`) VALUES ('$disCat_name','$disCat_desc')";

  $exec = mysqli_query($con, $sql);

  if ($exec) {
?>
    <script>
      $.confirm({
        icon: 'fa fa-check-circle ',
        title: 'Disease Category Successfully',
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
              window.location.href = 'manage-diseasecat.php';
            }
          },
          again: {
            text: 'Add Another Data',
            btnClass: 'btn-blue',
            keys: ['enter'],
            action: function() {
              window.location.href = 'add-diseasecat.php';
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
        title: 'Ooppss!! Error in Adding Disease Category',
        content: 'Faced an issue in adding Disease Category, Please Try Again',
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
              window.location.href = 'add-diseasecat.php';
            }
          }
        }
      });
    </script>
<?php
  }
}

?>