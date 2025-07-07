<!DOCTYPE html>
<html lang="en">

<?php

include '../../components/head.php';

if (isset($_SESSION["adminID"])) {
  $adminID = $_SESSION["adminID"];
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
                <h3>Dashboard</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.html"> <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Dashboard</li>
                </ol>
              </div>
            </div>
          </div>
        </div>

        <!-- Container-fluid starts-->
        <div class="container-fluid">
          <div class="row second-chart-list third-news-update">
            <div class="col-xl-4 col-lg-12 xl-50 morning-sec box-col-12">
              <div class="card o-hidden profile-greeting">
                <div class="card-body">
                  <div class="media">
                    <div class="badge-groups w-100">
                      <div class="badge f-12"><i class="me-1" data-feather="clock"></i><span id="txt"></span></div>
                      <div class="badge f-12"><i class="fa fa-spin fa-cog f-14"></i></div>
                    </div>
                  </div>
                  <div class="greeting-user text-center">
                    <div class="profile-vector"><img class="img-fluid" src="../../assets/images/dashboard/welcome.png" alt=""></div>
                    <h4 class="f-w-600"><span id="greeting">Good Morning</span> <span class="right-circle"><i class="fa fa-check-circle f-14 middle"></i></span></h4>

                    <?php
                    include '../../connection/db.php';

                    date_default_timezone_set('Asia/Colombo');

                    $getTodayDate = date('Y-m-d');

                    $sql = "SELECT * FROM `booking` WHERE book_allocateDateTime BETWEEN '$getTodayDate 00:00:00' AND '$getTodayDate 23:59:00' ";

                    $exec = mysqli_query($con, $sql);

                    $noOfAppointment = mysqli_num_rows($exec);

                    ?>

                    <p><span>Hello, Welcoming you to the GB Health Care System. <br> Today's No. of appointments: <?php echo $noOfAppointment ?> </span></p>
                    <div class="whatsnew-btn"><a class="btn btn-primary">Whats New !</a></div>
                    <div class="left-icon"><i class="fa fa-bell"> </i></div>
                  </div>
                </div>
              </div>
            </div>

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
                          
                        </tbody>

                      </table>
                    </div>
                  </div>

                  
                </div>
              </div>
            </div>

            <div class="col-xl-8 xl-100 dashboard-sec box-col-12">
              <div class="card earning-card">
                <div class="card-body p-0">
                  <div class="row m-0">
                    <div class="col-xl-3 earning-content p-0">
                      <div class="row m-0 chart-left">
                        <div class="col-xl-12 p-0 left_side_earning">
                          <h5>Dashboard</h5>
                          <p class="font-roboto">Overview of Revenue Analysis</p>
                        </div>

                        <div class="col-xl-12 p-0 left_side_earning">
                          <?php
                          $monthStartDate = date("Y-m-01");
                          $monthEndDate = date("Y-m-t");

                          $sql_monthlyIncome = "SELECT pay_id, SUM(payment.pay_amount) AS 'total_income' FROM `payment` 
                                                  WHERE pay_paidDate BETWEEN '$monthStartDate 00:00:00' AND '$monthEndDate 23:59:59'";

                          $exec_monthlyIncome  = mysqli_query($con, $sql_monthlyIncome);

                          while ($row = mysqli_fetch_array($exec_monthlyIncome)) {
                            if ($row['total_income'] == 0) {
                              $monthIncome = 0;
                            } else {
                              $monthIncome = $row['total_income'];
                            }
                          }
                          ?>
                          <h5>Rs. <?php echo number_format($monthIncome) ?> </h5>
                          <p class="font-roboto">This Month Earning</p>
                        </div>



                        <div class="col-xl-12 p-0 left_side_earning">
                          <?php

                          $todayDate = date("Y-m-d");
                          $sql_incomeToday = "SELECT pay_id, SUM(payment.pay_amount) AS 'total_income' FROM `payment` 
                                                WHERE pay_paidDate BETWEEN '$todayDate 00:00:00' AND '$todayDate 23:59:59'";

                          $exec_incomeToday = mysqli_query($con, $sql_incomeToday);
                          ?>

                          <h5>Rs. <?php while ($row = mysqli_fetch_array($exec_incomeToday)) {
                                    if ($row['total_income'] == 0) {
                                      echo '0';
                                    } else {
                                      echo number_format($row['total_income']);
                                    }
                                  } ?>
                          </h5>
                          <p class="font-roboto">Today Earnings</p>
                        </div>
                        <div class="col-xl-12 p-0 left-btn"><a class="btn btn-gradient">Summary</a></div>
                      </div>
                    </div>
                    <div class="col-xl-9 p-0">
                      <div class="chart-right">


                        <div class="row">
                          <div class="col-xl-12">
                            <div class="card-body p-0">
                              <div class="current-sale-container">
                                <div id="mixedchart1"></div>
                              </div>
                            </div>
                          </div>
                        </div>

                      </div>
                      <div class="row border-top m-0 d-flex justify-content-center">

                        <div class="col-xl-4 ps-0 col-md-6 col-sm-6" onclick="window.location.href='<?php echo $base_url . 'system/reports/appointment-report.php' ?>'">
                          <div class="media p-0">
                            <div class="media-left"><i class="icofont icofont-crown"></i></div>
                            <div class="media-body">
                              <h6> View <br>Appointment Analysis</h6>
                            </div>
                          </div>
                        </div>

                        <div onclick="window.location.href='<?php echo $base_url . 'system/reports/patient-report.php' ?>'" class="col-xl-4 col-md-6 col-sm-6">
                          <div class="media p-0">
                            <div class="media-left bg-secondary"><i class="icofont icofont-heart-alt"></i></div>
                            <div class="media-body">
                              <h6> View <br>Patient Analysis</h6>
                            </div>
                          </div>
                        </div>



                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-9 xl-100 chart_data_left box-col-12">
              <div class="card">
                <div class="card-body p-0">
                  <div class="row m-0 chart-main">
                    <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
                      <div class="media align-items-center">
                        <div class="hospital-small-chart">
                          <div class="small-bar">
                            <div class=" flot-chart-container"> <img src="<?php echo $base_url ?>/assets/images/dashboard/advice.png" alt="" width="50px"> </div>
                          </div>
                        </div>
                        <div class="media-body">
                          <div class="right-chart-content">
                            <?php
                            $sql_patient = "SELECT * FROM patient";
                            $exec_patient = mysqli_query($con, $sql_patient);
                            $countPatient = mysqli_num_rows($exec_patient);
                            ?>
                            <h4><?php echo $countPatient ?></h4><span>Patients </span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
                      <div class="media align-items-center">
                        <div class="hospital-small-chart">
                          <div class="small-bar">
                            <div class=" flot-chart-container"><img src="<?php echo $base_url ?>/assets/images/dashboard/online.png" alt="" width="50px"> </div>
                          </div>
                        </div>
                        <div class="media-body">
                          <div class="right-chart-content">
                            <?php
                            $sql_booking = "SELECT * FROM booking";
                            $exec_booking = mysqli_query($con, $sql_booking);
                            $countbooking = mysqli_num_rows($exec_booking);
                            ?>
                            <h4><?php echo $countbooking ?></h4><span>Appoinments </span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
                      <div class="media align-items-center">
                        <div class="hospital-small-chart">
                          <div class="small-bar">
                            <div class="flot-chart-container"><img src="<?php echo $base_url ?>/assets/images/dashboard/growth.png" alt="" width="50px"></div>
                          </div>
                        </div>
                        <div class="media-body">
                          <div class="right-chart-content">
                            <?php
                            include '../../components/functions.php';

                            $todayDate = date("Y-m-d");
                            $sql_incomeToday = "SELECT pay_id, SUM(payment.pay_amount) AS 'total_income' FROM `payment` 
                                                WHERE pay_paidDate BETWEEN '$todayDate 00:00:00' AND '$todayDate 23:59:59'";

                            $exec_incomeToday = mysqli_query($con, $sql_incomeToday);
                            ?>
                            <h4>Rs. <?php while ($row = mysqli_fetch_array($exec_incomeToday)) {
                                      if ($row['total_income'] == 0) {
                                        echo '0';
                                      } else {
                                        echo number_shorten($row['total_income']);
                                      }
                                    } ?>
                            </h4><span>Approx Income Daily</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
                      <div class="media border-none align-items-center">
                        <div class="hospital-small-chart">
                          <div class="small-bar">
                            <div class="flot-chart-container"><img src="<?php echo $base_url ?>/assets/images/dashboard/pills.png" alt="" width="50px"></div>
                          </div>
                        </div>
                        <div class="media-body">
                          <div class="right-chart-content">
                            <?php
                            $sql_medicine = "SELECT * FROM medicine";
                            $exec_medicine = mysqli_query($con, $sql_medicine);
                            $countmedicine = mysqli_num_rows($exec_medicine);
                            ?>
                            <h4><?php echo $countmedicine ?></h4><span>Medicines </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 xl-50 chart_data_right box-col-12">
              <div class="card">
                <div class="card-body">
                  <div class="media align-items-center">
                    <div class="media-body right-chart-content">
                      <?php
                      $sql_doctor = "SELECT * FROM doctor";
                      $exec_doctor = mysqli_query($con, $sql_doctor);
                      $countdoctor = mysqli_num_rows($exec_doctor);

                      $sql_doctorAttends = "SELECT `doctor`.*, `doctorworktime`.*, `doctorschedule`.*, `doctoravastatus`.* FROM `doctor` 
                        INNER JOIN `doctorworktime` ON `doctorworktime`.`doc_id_fk` = `doctor`.`doc_id` 
                        INNER JOIN `doctorschedule` ON `doctorworktime`.`doctorSch_id_fk` = `doctorschedule`.`doctorSch_id` 
                        INNER JOIN `doctoravastatus` ON `doctorschedule`.`doctorAvaStatus_id_fk` = `doctoravastatus`.`doctorAvaStatus_id` 
                        WHERE `doctorschedule`.`attendingDateTime` <= '$getTodayDate' OR `doctorschedule`.`offDateTime` >= '$getTodayDate' 
                        AND `doctoravastatus`.`doctorAvaStatus_name`='On Duty' GROUP BY `doctor`.`doc_id`; ;";

                      $exec_doctorAttends = mysqli_query($con, $sql_doctorAttends);

                      $countdoctorAttends = mysqli_num_rows($exec_doctorAttends);

                      $calculateAttendancePercentage = ($countdoctorAttends / $countdoctor) * 100;
                      ?>
                      <h4><?php echo $countdoctor ?> Doctors <span class="new-box">Hot</span></h4><span>Total No. of Attended Doctors (Today)</span>

                    </div>
                    <div class="knob-block text-center">
                      <input class="knob1" data-width="10" data-height="70" data-thickness=".3" data-angleoffset="0" data-linecap="round" data-fgcolor="#7366ff" data-bgcolor="#eef5fb" value="<?php echo $calculateAttendancePercentage ?>">
                    </div>

                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 xl-50 chart_data_right second d-none">
              <div class="card">
                <div class="card-body">
                  <div class="media align-items-center">
                    <div class="media-body right-chart-content">
                      <h4><?php echo $noOfAppointment ?> Appoinments <span class="new-box">New</span></h4><span>Total No. of Checked Appointments (This Today)</span>
                    </div>

                    <?php
                    $sql_checkedApp = "SELECT * FROM `booking` WHERE `book_allocateDateTime` BETWEEN '$getTodayDate 00:00:00' AND '$getTodayDate 23:59:59' AND `bookStatus_id_fk` = 2";
                    $exec_checkedApp = mysqli_query($con, $sql_checkedApp);
                    $countcheckedApp = mysqli_num_rows($exec_checkedApp);

                    // (No of Today Checked Appointment Divided by No of Total Today Appointment)*100
                    // To Calculate the Checked Appointment Percentage
                    if ($noOfAppointment == 0) {

                    } else {

                      try {
                        $perAppVsDoneApp = ($countcheckedApp / $noOfAppointment) * 100;
                      } catch (DivisionByZeroError $e) {
                        $perAppVsDoneApp = 99;
                      } catch (ErrorException $e) {
                      ?>
                        <script>
                          alert('Error Occured in Calculation')
                        </script>
                      <?php
                      }

                      ?>
                      <div class="knob-block text-center">
                        <input class="knob1" data-width="50" data-height="70" data-thickness=".3" data-fgcolor="#7366ff" data-linecap="round" data-angleoffset="0" value="<?php echo $perAppVsDoneApp ?>">
                      </div>
                    <?php
                    }


                    ?>


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
      $('#appointmentPreview').load('preview-appointment.php?filter=' + filterData);
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

  <script>
    // mixed chart
    var options7 = {
      chart: {
        height: 350,
        type: 'line',
        stacked: false,
        toolbar: {
          show: false
        }
      },
      stroke: {
        width: [0, 2, 5],
        curve: 'smooth'
      },
      plotOptions: {
        bar: {
          columnWidth: '75%'
        }
      },
      series: [

        <?php
        $arrayOfNoPatient = [];
        $arrayOfAppoinment = [];
        $arrayOfPayment = [];

        for ($i = 0; $i < 13; $i++) {
          $sql1 = "SELECT * 
                  FROM patient
                  WHERE MONTH(p_regDate) = MONTH('2022-$i-1')
                  AND YEAR(p_regDate) = YEAR('2022-$i-1')";

          $exec1  = mysqli_query($con, $sql1);
          $countOfRecord1 = mysqli_num_rows($exec1);
          array_push($arrayOfNoPatient, $countOfRecord1);

          $sql2 = "SELECT * 
                  FROM booking
                  WHERE MONTH(book_dateTime) = MONTH('2022-$i-1')
                  AND YEAR(book_dateTime) = YEAR('2022-$i-1')";

          $exec2  = mysqli_query($con, $sql2);
          $countOfRecord2 = mysqli_num_rows($exec2);
          array_push($arrayOfAppoinment, $countOfRecord2);

          $sql3 = "SELECT * 
                  FROM payment
                  WHERE MONTH(pay_paidDate) = MONTH('2022-$i-1')
                  AND YEAR(pay_paidDate) = YEAR('2022-$i-1')";

          $exec3  = mysqli_query($con, $sql3);
          $countOfRecord3 = mysqli_num_rows($exec3);
          array_push($arrayOfPayment, $countOfRecord3);
        }


        echo "
          {
        name: 'No. of Patients',
        type: 'column',
        ";
        echo 'data: [' . $arrayOfNoPatient[1] . ', ' . $arrayOfNoPatient[2] . ', ' . $arrayOfNoPatient[3] . ',' . $arrayOfNoPatient[4] . ', ' . $arrayOfNoPatient[5] . ', ' . $arrayOfNoPatient[6] . ', ' . $arrayOfNoPatient[7] . ', ' . $arrayOfNoPatient[8] . ', ' . $arrayOfNoPatient[9] . ', ' . $arrayOfNoPatient[10] . ', ' . $arrayOfNoPatient[11] . ',' . $arrayOfNoPatient[12] . ']';
        echo " }  ";

        ?>,
        <?php
        echo "{
        name: 'No. of Appointments',
        type: 'area',
        data: ['$arrayOfAppoinment[1]', '$arrayOfAppoinment[2]', '$arrayOfAppoinment[3]','$arrayOfAppoinment[4]', '$arrayOfAppoinment[5]', '$arrayOfAppoinment[6]', '$arrayOfAppoinment[7]', '$arrayOfAppoinment[8]', '$arrayOfAppoinment[9]', '$arrayOfAppoinment[10]', '$arrayOfAppoinment[11]','$arrayOfPayment[12]']
       }"
        ?>,

        <?php
        echo "{
        name: 'No. of Payments ',
        type: 'line',
        data: ['$arrayOfPayment[1]', '$arrayOfPayment[2]', '$arrayOfPayment[3]','$arrayOfPayment[4]', '$arrayOfPayment[5]', '$arrayOfPayment[6]', '$arrayOfPayment[7]', '$arrayOfPayment[8]', '$arrayOfPayment[9]', '$arrayOfPayment[10]', '$arrayOfPayment[11]', '$arrayOfPayment[12]']
        }"
        ?>

      ],
      fill: {
        opacity: [0.85, 0.25, 1],
        gradient: {
          inverseColors: false,
          shade: 'light',
          type: "vertical",
          opacityFrom: 0.85,
          opacityTo: 0.55,
          stops: [0, 100, 100, 100]
        }
      },
      labels: ['01/01/2022', '02/01/2022', '03/01/2022', '04/01/2022', '05/01/2022', '06/01/2022', '07/01/2022', '08/01/2022', '09/01/2022', '10/01/2022', '11/01/2022', '12/01/2022'],
      markers: {
        size: 0
      },
      xaxis: {
        type: 'datetime'
      },
      yaxis: {
        min: 0
      },
      tooltip: {
        shared: true,
        intersect: false,
        y: {
          formatter: function(y) {
            if (typeof y !== "undefined") {
              return y.toFixed(0) + " ";
            }
            return y;

          }
        }
      },
      legend: {
        labels: {
          useSeriesColors: true
        },
      },
      colors: [CubaAdminConfig.secondary, '#51bb25', CubaAdminConfig.primary]
    }
    

    var chart7 = new ApexCharts(
      document.querySelector("#mixedchart1"),
      options7
    );

    chart7.render();


  </script>


</body>

</html>