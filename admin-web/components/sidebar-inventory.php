<?php

$system_navigation_url = $base_url . 'system/';

?>

<div class="sidebar-wrapper">
  <div>
    <div class="logo-wrapper d-flex justify-content-center align-items-center" style="padding: 10px 25px;"><a class="d-flex justify-content-center align-items-center" href="index.php"><img class="img-fluid for-light" src="<?php echo $base_url ?>assets/images/logo/logo-final.png" alt=""><img class="img-fluid for-dark" style="width: 85%;" src="<?php echo $base_url ?>assets/images/logo/logo-final.png" alt=""></a>
      <div class="back-btn"><i class="fa fa-angle-left"></i></div>
      <!-- <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div> -->
    </div>
    <div class="logo-icon-wrapper"><a href="index.php"><img class="img-fluid" src="<?php echo $base_url ?>assets/images/logo/logo-icon.png" alt=""></a></div>
    <nav class="sidebar-main">
      <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
      <div id="sidebar-menu">
        <ul class="sidebar-links" id="simple-bar">

          <li class="back-btn"><a href="index.php"><img class="img-fluid" src="<?php echo $base_url ?>assets/images/logo/logo-icon.png" alt=""></a>
            <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
          </li>

          <li class="sidebar-main-title">
            <div>
              <h6 class="lan-1">General</h6>
            </div>
          </li>

          <?php
          if (isset($_SESSION["adminID"])) {
            $dashboard_url = $system_navigation_url . "home/index.php";
          } else if (isset($_SESSION["staffType"])) {
            if ($_SESSION["staffType"] == "Inventory Clerk") {
              $dashboard_url = $system_navigation_url . "home/inventory-dashboard.php";
            } else if ($_SESSION["staffType"] == "Receptionist") {
              $dashboard_url = $system_navigation_url . "home/reception-dashboard.php";
            }
          } else if (isset($_SESSION["doctorID"])) {
            $dashboard_url = $system_navigation_url . "home/doctor-dashboard.php";
          }
          ?>
          <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="<?php echo $dashboard_url ?>"><i data-feather="home"> </i><span>Dashboard</span></a></li>


          <li class="sidebar-main-title">
            <div>
              <h6>Inventory Management</h6>
            </div>
          </li>

          <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i data-feather="box"></i><span>Medicines</span></a>
            <ul class="sidebar-submenu">
              <li><a href="<?php echo $system_navigation_url ?>medicine/add-medicine.php">Add Medicines</a></li>
              <li><a href="<?php echo $system_navigation_url ?>medicine/manage-medicine.php">Manage Medicines</a></li>
              <li><a href="<?php echo $system_navigation_url ?>drug/manage-drugtype.php">Manage Drug Type</a></li>
            </ul>
          </li>

          <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i data-feather="circle"></i><span>Disease</span></a>
            <ul class="sidebar-submenu">
              <li><a href="<?php echo $system_navigation_url ?>disease/add-disease.php">Add Diseases</a></li>
              <li><a href="<?php echo $system_navigation_url ?>disease/manage-disease.php">Manage Diseases</a></li>
              <li><a href="<?php echo $system_navigation_url ?>disease/manage-diseasecat.php">Manage Diseases Category</a></li>
            </ul>
          </li>

          

        </ul>
      </div>
      <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
    </nav>
  </div>
</div>
<!-- Page Sidebar Ends-->