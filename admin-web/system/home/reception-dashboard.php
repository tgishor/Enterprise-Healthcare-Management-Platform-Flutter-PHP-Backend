<!DOCTYPE html>
<html lang="en">

<?php

include '../../components/head.php';

if (isset($_SESSION["staffID"]) && $_SESSION["staffType"] == "Receptionist") {
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
                                <h3>Receptionist Dashboard</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html"> <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Receptionist</li>
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
                                <div class="card">
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

                                        <div class="col-12 mt-3">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="bg-wd-1 p-3 rounded-4 d-flex flex-column align-items-center justify-content-center mt-3 ">
                                                        <img src="<?php echo $base_url ?>assets/images/components/appointment.png" class="img-fluid" alt="">
                                                        <p style="font-size: 15px; line-height: 1.1;" class="mt-2 text-center">Add New Appointment</p>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="bg-primary p-3 rounded-4 d-flex flex-column align-items-center justify-content-center mt-3 ">
                                                        <img src="<?php echo $base_url ?>assets/images/components/book-status.png" class="img-fluid" alt="">
                                                        <p style="font-size: 15px; line-height: 1.1;" class="mt-2 text-center">Check All Booking Status</p>
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
                                                    WHERE `doctorschedule`.`attendingDateTime` BETWEEN '$getTodayDate 00:00:00' AND '$getTodayDate 23:59:59' 
                                                    OR `doctorschedule`.`offDateTime` BETWEEN '$getTodayDate 00:00:00' AND '$getTodayDate 23:59:59' 
                                                    AND `doctoravastatus`.`doctorAvaStatus_name`='On Duty' 
                                                    GROUP BY `doctor`.`doc_id`;";

                                            // echo $sql_doctorAttends;

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

                                            <?php
                                            $sql_checkedApp = "SELECT * FROM `booking` WHERE `book_allocateDateTime` BETWEEN '$getTodayDate 00:00:00' AND '$getTodayDate 23:59:59' AND `bookStatus_id_fk` = 2";
                                            $exec_checkedApp = mysqli_query($con, $sql_checkedApp);
                                            $countcheckedApp = mysqli_num_rows($exec_checkedApp);

                                            // (No of Today Checked Appointment Divided by No of Total Today Appointment)*100
                                            // To Calculate the Checked Appointment Percentage

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

                                            <h4><?php echo $noOfAppointment ?> Appoinments <span class="new-box">New</span></h4><span>Total No. of Checked Appointments (This Today)</span>
                                        </div>
                                        <div class="knob-block text-center">
                                            <input class="knob1" data-width="50" data-height="70" data-thickness=".3" data-fgcolor="#7366ff" data-linecap="round" data-angleoffset="0" value="<?php echo $perAppVsDoneApp ?>">
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


</body>

</html>