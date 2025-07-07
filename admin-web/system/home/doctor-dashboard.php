<!DOCTYPE html>
<html lang="en">

<?php

include '../../components/head.php';

if (isset($_SESSION["doctorID"])) {
  $doctorID = $_SESSION["doctorID"];
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
                <h3>Doctor Dashboard</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.html"> <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Doctor</li>
                  <li class="breadcrumb-item">Dashboard</li>
                </ol>
              </div>
            </div>
          </div>
        </div>

        <!-- Container-fluid starts-->
        <div class="container-fluid">
          <div class="row second-chart-list third-news-update">



            <div class="col-xl-4 xl-50 appointment-sec box-col-6">
              <div class="col-xl-12 appointment" style="width: 100%; height: 95%;">
                <div class="card" style="width: 100%; height: 100%;">
                  <div class="card-header card-no-border">
                    <div class="header-top">
                      <h5 class="m-0">appointment <span style="font-size: 15px;" id="titleWithFilter"></span> </h5>
                      <div class="card-header-right-icon">
                        <div class="dropdown">

                          <button class="btn dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">Filter</button>
                          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <button class="dropdown-item dropdown-set" id="todayButtonFilter" onclick="loadAppointment('today')" value="[Today]">Today</button>
                            <button class="dropdown-item dropdown-set" onclick="loadAppointment('tomorrow')" value="[Tomorrow]">Tomorrow</button>
                            <button class="dropdown-item dropdown-set" onclick="loadAppointment('yesterday')" value="[Yesterday]">Yesterday</button>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-body pt-0" style="overflow-y: scroll;">
                    <div class="appointment-table table-responsive">
                      <table class="table table-bordernone">
                        <tbody id="appointmentPreview">
                          <tr>
                            <td><img class="img-fluid img-40 rounded-circle mb-3" src="../../assets/images/appointment/app-ent.jpg" alt="Image description">
                              <div class="status-circle bg-primary"></div>
                            </td>
                            <td class="img-content-box"><span class="d-block">Venter Loren</span><span class="font-roboto">Now</span></td>
                            <td>
                              <p class="m-0 font-primary">28 Sept</p>
                            </td>
                            <td class="text-end">
                              <div class="button btn btn-primary">Done<i class="fa fa-check-circle ms-2"></i></div>
                            </td>
                          </tr>
                          <tr>
                            <td><img class="img-fluid img-40 rounded-circle" src="../../assets/images/appointment/app-ent.jpg" alt="Image description">
                              <div class="status-circle bg-primary"></div>
                            </td>
                            <td class="img-content-box"><span class="d-block">John Loren</span><span class="font-roboto">11:00</span></td>
                            <td>
                              <p class="m-0 font-primary">22 Sept</p>
                            </td>
                            <td class="text-end">
                              <div class="button btn btn-danger">Pending<i class="fa fa-clock-o ms-2"></i></div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-6 alert-sec mb-3">
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
                  <a href="<?php echo $system_navigation_url ?>doctor/add-workschedule.php">
                    <div class="bg-wd-1 p-4 rounded-4 d-flex flex-column align-items-center justify-content-center d-block">
                      <img src="<?php echo $base_url ?>assets/images/components/medicalrecord.png" class="img-fluid" alt="">
                      <p style="font-size: 15px;" class="m-0 text-center">Create Medical Record</p>
                    </div>
                  </a>

                  <a href="<?php echo $system_navigation_url ?>doctor/add-workschedule.php">
                    <div class="bg-wd-2 p-4 rounded-4 d-flex flex-column align-items-center justify-content-center mt-3 d-block ">
                      <img src="<?php echo $base_url ?>assets/images/components/medicalrecord.png" class="img-fluid" alt="">
                      <p style="font-size: 15px;" class="m-0 text-center">Update Medical Record</p>
                    </div>
                  </a>
                </div>

                <div class="col-6">
                  <a href="<?php echo $system_navigation_url ?>doctor/add-workschedule.php">
                    <div class="bg-wd-3 p-4 rounded-4 d-flex flex-column align-items-center justify-content-center d-block" style="height: 100%; width: 100%;">
                      <img src="<?php echo $base_url ?>assets/images/components/health-calendar.png" class="img-fluid" alt="">
                      <p style="font-size: 16px;" class="m-0 text-center">Schedule Work Time</p>
                    </div>
                  </a>
                </div>

              </div>


            </div>

            <div class="col-xl-8 xl-100 dashboard-sec box-col-12">
              <div class="card earning-card">
                <div class="card-body p-0">
                  <div class="row m-0">
                    <div class="col-xl-12 earning-content p-0">
                      <div class="row m-0 chart-left">

                        <div class="col-xl-12 p-0 left_side_earning">
                          <h5>Recently Diagnosed Patients</h5>
                          <p class="font-roboto">List of Patients you Diagnosed</p>
                        </div>
                        <div class="col-xl-12 p-0 left-btn"><a class="btn btn-gradient">View All</a></div>

                        <div class="col-12">
                          <table id="myTable" class="display" style="width:100%">
                            <thead>
                              <tr>
                                <th>Patient</th>
                                <th>Appoinment Date</th>
                                <th>Digonised Disease</th>
                                <th>More</th>
                              </tr>
                            </thead>

                            <tbody>
                              <?php
                              include '../../connection/db.php';
                              include '../../components/functions.php';

                              $sql_bookingInfo = "SELECT `booking`.*, `patient`.*, `doctor`.*,`bookingstatus`.*, `gender`.*
                                        FROM `booking` 
                                        INNER JOIN `patient` ON `booking`.`p_id_fk` = `patient`.`p_id` 
                                        INNER JOIN `doctor` ON `booking`.`doc_id_fk` = `doctor`.`doc_id`
                                        INNER JOIN `bookingstatus` ON `booking`.`bookStatus_id_fk` = `bookingstatus`.`bookStatus_id`
                                        INNER JOIN `gender` ON `patient`.`gender_fk` = `gender`.`gender_id`
                                        WHERE `doctor`.`doc_id` = $doctorID AND `bookingstatus`.`bookStatus_id` = '2' LIMIT 10";

                              // $sql.= " AND `bookingstatus`.`bookStatus_id` = 2";

                              $exec_bookingInfo = mysqli_query($con, $sql_bookingInfo);
                              
                              while ($row = mysqli_fetch_array($exec_bookingInfo)) {
                                $patientID = $row['p_id'];
                                $bookingTime = $row['book_dateTime'];
                              ?>
                                <tr>
                                  <td>
                                    <div class="d-flex flex-row align-items-center">
                                      <img width="60px" class="rounded-circle img-50" src="<?php echo $base_url ?>/uploads/patient/<?php echo $row['p_img'] ?>" alt="">
                                      <div style="margin-left:15px">
                                        <p class="m-0 fw-bold"><?php echo $row['p_name'] ?></p>
                                        <p class="m-0"><?php echo $row['gender'] ?></p>
                                        <p><?php echo $row['p_nic'] ?></p>
                                      </div>
                                    </div>
                                  </td>
                                  <td><?php echo date("d-M-Y", strtotime($row['book_allocateDateTime'])) ?></td>
                                  <td>
                                    <?php

                                    if (!function_exists("toGetDate")) {

                                      function toGetDate($date_time)
                                      {
                                        $new_date = date(
                                          "Y-m-d",
                                          strtotime($date_time)
                                        );
                                        return $new_date;
                                      }
                                    }

                                    $bookRegDate = toGetDate($bookingTime);

                                    $patientDiseases_sql = "SELECT `patient`.`p_id`, `paitenthasdisease`.*, `disease`.*
                                                            FROM `patient` 
                                                            INNER JOIN `paitenthasdisease` ON `paitenthasdisease`.`p_id_fk` = `patient`.`p_id` 
                                                            INNER JOIN `disease` ON `paitenthasdisease`.`dis_id_fk` = `disease`.`dis_id`
                                                            WHERE `patient`.`p_id` = '$patientID' AND `paitenthasdisease`.`paHasDis_recordedDate` 
                                                            BETWEEN '$bookRegDate 00:00:00'  AND  '$bookRegDate 23:59:59'";

                                    $patientDiseases_exec = mysqli_query($con, $patientDiseases_sql);

                                    while ($row = mysqli_fetch_array($patientDiseases_exec)) {
                                    ?>
                                      <span class="badge badge-dark" style="font-size: 12px ;"><?php echo $row['dis_name'] ?></span>
                                    <?php
                                    }
                                    ?>
                                  </td>
                                  <td>
                                    <a href="" class="btn btn-success"><i class="fa fa-eye"></i></a>
                                  </td>
                                </tr>
                              <?php
                              }
                              ?>

                            </tbody>


                          </table>
                        </div>
                      </div>

                    </div>


                  </div>
                </div>
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


  <script>
    $(function() {
      $('#todayButtonFilter').click();
    });
  </script>


  <script>
    $(".dropdown-set").click(function() {
      var buttonValue = $(this).val();
      $('#titleWithFilter').html(buttonValue);
    });
  </script>

  <script>
    var intervalID;

    function previewAppoinment(filterData) {
      $('#appointmentPreview').load('preview-doc-appointment.php?docID=<?php echo $doctorID ?>&filter=' + filterData);
    }

    function loadAppointment(filterData) {

      $('#appointmentPreview').empty();

      clearInterval(intervalID);

      previewAppoinment(filterData); // This will run on page load

      intervalID = setInterval(function() {
        previewAppoinment(filterData) // this will run after every 5 seconds
      }, 5000);

    }
  </script>


</body>

</html>