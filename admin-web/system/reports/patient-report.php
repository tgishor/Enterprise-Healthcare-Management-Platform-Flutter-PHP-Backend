<!DOCTYPE html>
<html lang="en">

<?php include '../../components/head.php' ?>

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
                <h3>Patient Reports</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php"> <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Report</li>
                  <li class="breadcrumb-item">Patient Reports</li>
                </ol>
              </div>
            </div>
          </div>
        </div>

        <!-- Container-fluid starts-->
        <div class="container-fluid">
          <div class="row">

            <div class="col-sm-12 col-xl-6 box-col-6">
              <div class="card">
                <div class="card-body ">
                  <h4> Gender Analysis </h4>
                  <div class="chart-overflow" id="patientGender" style="width: 450px; height: 300px;"></div>
                </div>
              </div>
            </div>
            
            <div class="col-sm-12 col-xl-6 box-col-6"> 
              <div class="card">
                <div class="card-body ">
                  <h4>Patient's Age Analysis </h4>
                  <div class="chart-overflow" id="patientAgeRange" style="width: 450px; height: 300px;"></div>
                </div>
              </div>
            </div>

            <div class="col-sm-12">
              <div class="card">
                <!-- <div class="card-header">
                    <h5>Sample Card</h5><span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                  </div> -->
                <div class="card-body">
                  <h4 class="mb-4" style="font-weight: 500;">Filter Patient</h4>

                  <form method="POST" class="needs-validation" novalidate="" enctype="multipart/form-data">
                    <div class="row g-3">

                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom01">From Appoinment Date</label>
                        <input name="start_appDate" class="form-control" id="validationCustom01" type="date" placeholder="Date" required="">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please Add a Date</div>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom04">To Appoinment Date</label>
                        <input name="end_appDate" class="form-control" id="validationCustom01" type="date" placeholder="Date" required="">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please Add a Date</div>
                      </div>

                      <div class="d-flex flex-column align-items-start align-items-center sub-btnsize ">
                        <button name="submit" class="mt-4 btn btn-success" type="submit"><i class="fa fa-filter"></i> Filter Appointment</button>
                      </div>

                    </div>
                  </form>

                  <?php
                  if (isset($_POST['submit'])) {

                    $appStartDate = $_POST['start_appDate'];
                    $appEndDate = $_POST['end_appDate'];

                    include '../../connection/db.php';

                    $sql = "SELECT `patient`.*, `booking`.*, `bookingstatus`.*, `doctor`.*
                                    FROM `patient` 
                                  INNER JOIN `booking` ON `booking`.`p_id_fk` = `patient`.`p_id` 
                                  INNER JOIN `bookingstatus` ON `booking`.`bookStatus_id_fk` = `bookingstatus`.`bookStatus_id` 
                                  INNER JOIN `doctor` ON `booking`.`doc_id_fk` = `doctor`.`doc_id` 
                                  WHERE booking.book_allocateDateTime >= '$appStartDate' AND booking.book_allocateDateTime <= '$appEndDate'";

                    $exec = mysqli_query($con, $sql);

                  ?>
                    <div class="mt-5">
                      <div class="col-12">
                        <div class="row">
                        </div>
                      </div>
                      <table id="myTable" class="display" style="width:100%">
                        <thead>
                          <tr>
                            <th>Booking ID</th>
                            <th>Patient Image</th>
                            <th>Patient Name</th>
                            <th>NIC</th>
                            <th>Contact</th>
                            <th>Booking Date</th>
                            <th>Booking Status</th>
                            <th>Assigned Doctor</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php

                          while ($row = mysqli_fetch_array($exec)) {
                            if ($row['bookStatus_name'] == "Pending") {
                              $str = '<div class="button btn btn-info"><i class="fa fa-hourglass-half"></i></div>'; //Pending
                            } else if ($row['bookStatus_name'] == "Done") {
                              $str = ' <div class="button btn btn-success"><i class="fa fa-check-circle"></i></div>'; //Success
                            } else {
                              $str = '<div class="button btn btn-danger"><i class="fa fa-exclamation-triangle "></i></div>'; //Cancelled
                            }
                          ?>
                            <tr>
                              <td><?php echo $row['book_id'] ?></td>
                              <td class="d-flex justify-content-center">
                                <img src="../../uploads/patient/<?php echo $row['p_img'] ?>" class="img-fluid rounded" width="50px" alt="">
                              </td>
                              <td>
                                <?php echo $row['p_name'] ?>
                              </td>
                              <td><?php echo $row['p_nic'] ?></td>
                              <td><?php echo $row['p_contact'] ?></td>
                              <td><?php echo $row['book_allocateDateTime'] ?></td>
                              <td><?php echo $str ?></td>
                              <td>
                                <?php echo $row['doc_name'] ?>
                              </td>
                            </tr>
                          <?php
                          }
                          ?>

                        </tbody>
                      </table>
                    </div>
                  <?php
                  }

                  ?>

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
    $(document).ready(function() {

      $('#myTable').DataTable({
        scrollX: true,
        dom: 'lBfrtip',
        buttons: [{
          extend: 'collection',
          text: 'Export',
          className: 'custom-html-collection',

          buttons: ['pdf',
            'copy',
            {
              extend: 'print',
              title: 'Doctor Records',
              exportOptions: {
                stripHtml: false,
                columns: [0, ':visible']
              },
              customize: function(win) {
                $(win.document.body)
                  .css('font-size', '10pt')
                  .prepend(
                    '<img src="http://localhost/finalproject/admin/assets/images/logo/logo-final.png" style="position: absolute; top:0;left:0; opacity: 0.2;" />'
                  );
                $(win.document.body).find('table')
                  .addClass('compact')
                  .css('font-size', 'inherit');
              },
            }, 'colvis'
          ]
        }]
      });
    });
  </script>

  <script type="text/javascript">
    google.charts.load('current', {
      'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = google.visualization.arrayToDataTable([
        ['Gender', 'Number of People'],
        <?php
        include '../../connection/db.php';

        $sql = "SELECT `gender`.`gender`, COUNT(patient.p_id) AS 'number_of_people'
                  FROM `patient` 
                    INNER JOIN `gender` ON `patient`.`gender_fk` = `gender`.`gender_id`
                    GROUP BY `patient`.`gender_fk`";

        $exec = mysqli_query($con, $sql);

        while ($row = mysqli_fetch_array($exec)) {
        ?>['<?php echo $row['gender'] ?>', <?php echo $row['number_of_people'] ?>],
        <?php
        }
        ?>

      ]);

      var options = {
        title: ' '
      };

      var dataforGender = google.visualization.arrayToDataTable([
        ['AgeGroup', 'Count of People'],
        <?php
        include '../../connection/db.php';

        $sql = "WITH AgeData as
                (
                  SELECT 
                    patient.p_id,
                    TIMESTAMPDIFF(YEAR, patient.p_dob, CURDATE()) AS age 
                    FROM patient 
                ),GroupAge AS
                (
                  SELECT age,
                        CASE
                            WHEN AGE < 30 THEN 'Under 30'
                            WHEN AGE BETWEEN 31 AND 40 THEN '31 - 40'
                            WHEN AGE BETWEEN 41 AND 50 THEN '41 - 50'
                            WHEN AGE > 50 THEN 'Over 50'
                            ELSE 'Invalid Birthdate'
                        END AS Age_Groups
                  FROM AgeData
                )
                SELECT COUNT(*) AS AgeGrpCount,
                      Age_Groups
                FROM GroupAge
                GROUP BY Age_Groups;";

        $exec = mysqli_query($con, $sql);

        while ($row = mysqli_fetch_array($exec)) {
        ?>['<?php echo $row['Age_Groups'] ?>', <?php echo $row['AgeGrpCount'] ?>],
        <?php
        }
        ?>
      ]);

      var chart = new google.visualization.PieChart(document.getElementById('patientGender'));

      var chartforGender = new google.visualization.PieChart(document.getElementById('patientAgeRange'));

      chart.draw(data, options);

      chartforGender.draw(dataforGender, options);
    }
  </script>




</body>

</html>
