<!DOCTYPE html>
<html lang="en">

<?php include '../components/head.php' ?>

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

    <?php include '../components/topbar.php' ?>

    <!-- Page Body Start-->
    <div class="page-body-wrapper">

      <?php include '../components/sidebar.php' ?>

      <div class="page-body">
        <div class="container-fluid">
          <div class="page-title">
            <div class="row">
              <div class="col-6">
                <h3>Add New Hospital</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php"> <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Hospital</li>
                  <li class="breadcrumb-item">Add Hospital</li>
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


                  <form method="POST" class="needs-validation" novalidate="">
                    <div class="row g-3">

                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom01">Hospital Branch</label>
                        <input name="branchname" class="form-control" id="validationCustom01" type="text" placeholder=" Branch Name" required="">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please Add a Name</div>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom01">Hospital Contact No</label>
                        <input name="hos_contactNo" class="form-control" id="validationCustom01" type="number" placeholder="Contact No" required="">
                        <div class="valid-feedback">Looks good!</div>
                      </div>

                    </div>

                    <div class="d-flex flex-column align-items-start align-items-center sub-btnsize ">
                      <button id="submit" class="mt-4 btn btn-success" name="submit" type="submit"><i class="fa fa-plus-square"></i> Add Hospital</button>
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

  <?php include '../components/scripts.php' ?>
  
</body>

</html>

<?php
include "../connection/db.php";

if (isset($_POST['submit'])) {

  $branchname = $_POST['branchname'];
  $hos_contactNo = $_POST['hos_contactNo'];
  $sql =  "INSERT INTO `hospital`(`hos_contact`, `hos_branch`) VALUES ('$hos_contactNo','$branchname')";

  $exec = mysqli_query($con, $sql);

  if ($exec) {
?>
    <script>
      $.confirm({
        icon: 'fa fa-check-circle ',
        title: 'Hospital Successfully',
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
              window.location.href = 'view-hospital.php';
            }
          },
          again: {
            text: 'Add Another Data',
            btnClass: 'btn-blue',
            keys: ['enter'],
            action: function() {
              window.location.href = 'add-hospital.php';
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
        title: 'Ooppss!! Error in Adding Hospital',
        content: 'Faced an issue in adding hospital, Please Try Again',
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
              window.location.href = 'add-hospital.php';
            }
          }
        }
      });
    </script>
<?php
  }
}

?>