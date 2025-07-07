<!DOCTYPE html>
<html lang="en">

<?php

include '../../components/head.php';

if (isset($_SESSION["staffID"]) && $_SESSION["staffType"] == "Inventory Clerk") {
  $staffID = $_SESSION["staffID"];
} else {
?>
  <script>
    window.location.href = 'login.php'
  </script>
<?php
}

?>

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
                <h3>Inventory Dashboard</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.html"> <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Inventory</li>
                  <li class="breadcrumb-item">Dashboard</li>
                </ol>
              </div>
            </div>
          </div>
        </div>

        <!-- Container-fluid starts-->
        <div class="container-fluid">
          <div class="row second-chart-list third-news-update  pb-5">

            <div class="col-xl-6 alert-sec">
              <div class="card bg-img">
                <div class="card-header">
                  <div class="header-top">
                    <h5 class="m-0">Alert </h5>
                    <div class="dot-right-icon"><i class="fa fa-ellipsis-h"></i></div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="body-bottom">
                    <h6> No Events and Alerts Organised </h6>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-6">
                  <a href="<?php echo $system_navigation_url ?>medicine/add-medicine.php">
                    <div class="bg-wd-1 p-4 rounded-4 d-flex flex-column align-items-center justify-content-center d-block" style="background-color:#35DCD2;">
                      <img src="<?php echo $base_url ?>assets/images/components/pill-icon.png" class="img-fluid" alt="">
                      <p style="font-size: 15px;" class="m-0 text-center">Add New Medicine</p>
                    </div>
                  </a>

                  <a href="<?php echo $system_navigation_url ?>medicine/manage-medicine.php">
                    <div class="bg-wd-2 p-4 rounded-4 d-flex flex-column align-items-center justify-content-center mt-3 d-block" style="background-color:#F8D62A;">
                      <img src="<?php echo $base_url ?>assets/images/components/medicines.png" class="img-fluid" alt="">
                      <p style="font-size: 15px;" class="m-0 text-center">Manage Medicines</p>
                    </div>
                  </a>
                </div>

                <div class="col-6">
                  <a href="<?php echo $system_navigation_url ?>drug/manage-drugtype.php">
                    <div class="bg-wd-3 p-4 rounded-4 d-flex flex-column align-items-center justify-content-center d-block" style="height: 100%; width: 100%; background-color:#FF9877;">
                      <img src="<?php echo $base_url ?>assets/images/components/drug-manage.png" class="img-fluid" alt="">
                      <p style="font-size: 16px;" class="m-0 text-center">Manage Drug Types</p>
                    </div>
                  </a>
                </div>

              </div>

            </div>


            <div class="col-xl-4 xl-50 appointment-sec box-col-6">

              <div class="col-12 d-flex flex-column justify-content-around" style="height: 100%; width: 100%;">
                <div class="bg-wd-4 p-4 rounded-4 d-flex flex-column align-items-center justify-content-center">
                  <?php

                  include '../../connection/db.php';

                  $sql_medicine = "SELECT * FROM medicine";
                  $exec_medicine = mysqli_query($con, $sql_medicine);
                  $countmedicine = mysqli_num_rows($exec_medicine);
                  ?>
                  <h5 class="text-uppercase">Total No. of Medicine</h5>
                  <p style="font-size: 20px;" class="m-0 text-center"><?php echo $countmedicine ?></p>
                </div>

                <div class="bg-wd-4 p-4 rounded-4 d-flex flex-column align-items-center justify-content-center mt-3 ">
                  <?php
                  $sql_drugtype = "SELECT * FROM drugtype";
                  $exec_drugtype = mysqli_query($con, $sql_drugtype);
                  $countdrugtype = mysqli_num_rows($exec_drugtype);
                  ?>
                  <h5 class="text-uppercase">Total No. of Drug Type</h5>
                  <p style="font-size: 20px;" class="m-0 text-center"><?php echo $countdrugtype ?></p>
                </div>

                <div class="bg-wd-4 p-4 rounded-4 d-flex flex-column align-items-center justify-content-center mt-3 ">

                  <?php
                  $sql_mostUsedMedi = "SELECT COUNT(medicine.medi_id) AS 'NoMedicines', `precribingmedicine`.*, `medicine`.*
                                      FROM `precribingmedicine` 
                                      INNER JOIN `medicine` ON `precribingmedicine`.`med_id_fk` = `medicine`.`medi_id`
                                      GROUP BY `medicine`.`medi_id` ORDER BY NoMedicines ASC";
                  $exec_mostUsedMedi = mysqli_query($con, $sql_mostUsedMedi);

                  while ($row = mysqli_fetch_array($exec_mostUsedMedi)) {
                    $medicineName = $row['medi_name'];
                    $countMedi = $row['NoMedicines'];
                  }
                  ?>

                  <h5 class="text-uppercase">Most Prescribed Medicine</h5>
                  <p style="font-size: 20px;" class="m-0 text-center"><?php echo $medicineName . " (" . $countMedi . ")" ?></p>
                </div>
              </div>

              <div class="col-xl-12 appointment d-flex justify-content-between" style="height: 100%; width: 100%;">

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

  <script src="<?php echo $base_url ?>assets/js/dashboard/default.js"></script>

  <script>
    $('#myTable').DataTable({
      searching: false,
      paging: false,
      info: false
    });
  </script>


</body>

</html>