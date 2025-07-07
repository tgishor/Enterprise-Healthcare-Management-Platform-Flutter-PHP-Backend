<!-- Page Header Start-->
<div class="page-header">
  <div class="header-wrapper row m-0">
    <div class="header-logo-wrapper col-auto p-0">
      <div class="logo-wrapper"><a href="index.html"><img class="img-fluid" src="<?php echo $base_url ?>assets/images/logo/logo-final.png" alt=""></a></div>
      <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i></div>
    </div>
    <div class="left-header col horizontal-wrapper ps-0">

    </div>
    <div class="nav-right col-8 pull-right right-header p-0">
      <ul class="nav-menus">
        <li>
          <div class="mode"><i class="fa fa-moon-o"></i></div>
        </li>
        <li class="maximize"><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>
        <li class="profile-nav onhover-dropdown p-0 me-0">
          <?php
          $userName = "";
          $imagePath = "";
          $userType = "";

          include '../../connection/db.php';

          if (isset($_SESSION["adminID"])) {
            $adminID = $_SESSION["adminID"];

            $sql = "SELECT * FROM admin WHERE adm_id = '$adminID'";

            $exec = mysqli_query($con, $sql);

            while ($row = mysqli_fetch_array($exec)) {
              $userName = $row['adm_name'];
              $imagePath = $base_url.'uploads/admin/'.$row['adm_img'];
              $userType = "Admin";
            }
          } else if (isset($_SESSION["staffType"])) {
            if ($_SESSION["staffType"] == "Inventory Clerk") {

              $staffID = $_SESSION["staffID"];
              $sql = "SELECT * FROM staff WHERE staff_id = '$staffID'";

              $exec = mysqli_query($con, $sql);

              while ($row = mysqli_fetch_array($exec)) {
                $userName = $row['staff_name'];
                $imagePath = $base_url.'uploads/staff/'.$row['staff_img'];
                $userType = "Inventory Clerk";
              }
            } else if ($_SESSION["staffType"] == "Receptionist") {
              $staffID = $_SESSION["staffID"];
              $sql = "SELECT * FROM staff WHERE staff_id = '$staffID'";

              $exec = mysqli_query($con, $sql);

              while ($row = mysqli_fetch_array($exec)) {
                $userName = $row['staff_name'];
                $imagePath = $base_url.'uploads/staff/'.$row['staff_img'];
                $userType = "Receptionist";
              }
            }
          } else if (isset($_SESSION["doctorID"])) {
            $doctorID = $_SESSION["doctorID"];
            $sql = "SELECT * FROM doctor WHERE doc_id = '$doctorID'";

            $exec = mysqli_query($con, $sql);

            while ($row = mysqli_fetch_array($exec)) {
              $userName = $row['doc_name'];
              $imagePath = $base_url.'uploads/doctor/'.$row['doc_img'];
              $userType = "Doctor";
            }
          }


          ?>
          <div class="media profile-media"><img class="b-r-10" width="30px" src="<?php echo $imagePath ?>" alt="">
            <div class="media-body"><span><?php echo $userName ?></span>
              <p class="mb-0 font-roboto"><?php echo $userType ?> <i class="middle fa fa-angle-down"></i></p>
            </div>
          </div>
          <ul class="profile-dropdown onhover-show-div">
            <li><a href="#"><i data-feather="user"></i><span>Account </span></a></li>
            <li><a href="<?php echo $base_url ?>components/signout.php"><i data-feather="log-in"> </i><span>Sign Out</span></a></li>
          </ul>
        </li>
      </ul>
    </div>
    <script class="result-template" type="text/x-handlebars-template">
      <div class="ProfileCard u-cf">                        
            <div class="ProfileCard-avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg></div>
            <div class="ProfileCard-details">
            <div class="ProfileCard-realName">{{name}}</div>
            </div>
            </div>
          </script>
    <script class="empty-template" type="text/x-handlebars-template"><div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div></script>
  </div>
</div>
<!-- Page Header Ends-->