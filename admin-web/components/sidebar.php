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

          <?php
          if (isset($_SESSION["adminID"])) {
          ?>

            <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i data-feather="bar-chart"></i><span class="lan-6">Analysis</span></a>
              <ul class="sidebar-submenu">
                <li><a href="<?php echo $system_navigation_url ?>reports/appointment-report.php">Appointment Analysis</a></li>
                <li><a href="<?php echo $system_navigation_url ?>reports/patient-report.php">Patient Analysis</a></li>
              </ul>
            </li>


          <?php
          }
          ?>

          <li class="sidebar-main-title">
            <div>
              <h6 class="lan-8">Hospital Management</h6>
            </div>
          </li>

          <?php
          if (isset($_SESSION["adminID"]) || $_SESSION["staffType"] == "Receptionist") {
          ?>
            <li class="sidebar-list">
              <label class="badge badge-danger"></label><a class="sidebar-link sidebar-title" href="#"><i data-feather="user"></i><span>Patient </span></a>
              <ul class="sidebar-submenu">
                <li><a href="<?php echo $system_navigation_url ?>patient/add-patient.php">Add New Patient</a></li>
                <li><a href="<?php echo $system_navigation_url ?>patient/manage-patient.php">Manage Patient</a></li>
                <li><a href="<?php echo $system_navigation_url ?>patient/manage-gurdian.php">Manage Gurdians</a></li>
              </ul>
            </li>
          <?php
          }
          ?>

          <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i data-feather="calendar"></i><span>Bookings</span></a>
            <ul class="sidebar-submenu">
              <li><a href="<?php echo $system_navigation_url ?>booking/add-booking.php">Create Appointment</a></li>
              <li><a href="<?php echo $system_navigation_url ?>booking/manage-booking.php">View All Appointments</a></li>
            </ul>
          </li>

          <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i data-feather="folder-plus"></i><span>Medical Report</span></a>
            <ul class="sidebar-submenu">
              <li><a href="<?php echo $system_navigation_url ?>medical-record/add-medicalrecord.php">Create Medical Report</a></li>
              <li><a href="manage-medicalrecord.php">Manage Medical Report</a></li>
            </ul>
          </li>



          <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i data-feather="credit-card"></i><span>Payment</span></a>
            <ul class="sidebar-submenu">
              <li><a href="<?php echo $system_navigation_url ?>payment/add-payment.php">Add Payment</a></li>
              <li><a href="<?php echo $system_navigation_url ?>payment/manage-payment.php">View Payment History</a></li>
            </ul>
          </li>
          <li class="sidebar-main-title">
            <div>
              <h6>Staff Management</h6>
            </div>
          </li>
          <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i data-feather="file-text"></i><span>General Staffs</span></a>
            <ul class="sidebar-submenu">
              <li><a href="<?php echo $system_navigation_url ?>Staff/add-generalstaff.php">Add General Staff</a></li>
              <li><a href="<?php echo $system_navigation_url ?>Staff/manage-generalstaff.php">Manage General Staffs</a></li>
              <li><a href="<?php echo $system_navigation_url ?>Staff/manage-stafftype.php">Manage Staff Type</a></li>
            </ul>
          </li>

          <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i data-feather="user-check"></i><span>Doctor</span></a>
            <ul class="sidebar-submenu">
              <li><a href="<?php echo $system_navigation_url ?>doctor/add-doctor.php">Add Doctor</a></li>
              <li><a href="<?php echo $system_navigation_url ?>doctor/manage-doctor.php">Manage Doctor</a></li>
            </ul>
          </li>

          <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i data-feather="clock"></i><span>Doctor Scheduling</span></a>
            <ul class="sidebar-submenu">
              <li><a href="<?php echo $system_navigation_url ?>doctor/manage-doctorscheduling.php">View Doctor Scheduling</a></li>
            </ul>
          </li>


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

          <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i data-feather="folder-plus"></i><span>Admin</span></a>
            <ul class="sidebar-submenu">
              <li><a href="<?php echo $system_navigation_url ?>admin/add-admin.php">Add Admin</a></li>
              <li><a href="<?php echo $system_navigation_url ?>admin/manage-admin.php">Manage Admin</a></li>
            </ul>
          </li>

        </ul>
      </div>
      <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
    </nav>
  </div>
</div>
<!-- Page Sidebar Ends-->