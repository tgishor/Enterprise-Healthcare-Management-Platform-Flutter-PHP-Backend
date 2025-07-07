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
                <h3>Appointment Reports</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php"> <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Report</li>
                  <li class="breadcrumb-item">Appointment Reports</li>
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
                  <h4 class="mb-4" style="font-weight: 500;">Filter Report</h4>

                  <form method="POST" class="needs-validation" novalidate="" enctype="multipart/form-data">
                    <div class="row g-3">

                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom01">Start Date</label>
                        <input name="startDate" class="form-control" id="validationCustom01" type="date" placeholder="Date" required="">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please Add a Date</div>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom04">End Date</label>
                        <input name="endDate" class="form-control" id="validationCustom01" type="date" placeholder="Date" required="">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please Add a Date</div>
                      </div>

                      <div class="media mb-2 col-12">
                        <label class="col-form-label m-r-10">Disease Analysis</label>

                        <div class="media-body text-start icon-state">
                          <label class="switch">
                            <input type="checkbox" name="diseaseAnalysis_check" value="1" checked="" data-bs-original-title="" title=""><span class="switch-state bg-primary"></span>
                          </label>
                        </div>

                        <label class="col-form-label  m-r-10">Disease Category Analysis</label>
                        <div class="media-body text-start icon-state">
                          <label class="switch">
                            <input type="checkbox" name="dieseaseCategory_check" value="1" checked="" data-bs-original-title="" title=""><span class="switch-state bg-success"></span>
                          </label>
                        </div>

                        <label class="col-form-label  m-r-10">Appointment Status Analysis</label>
                        <div class="media-body text-start icon-state">
                          <label class="switch">
                            <input type="checkbox" name="appointmentStatus_check" value="1" checked="" data-bs-original-title="" title=""><span class="switch-state bg-secondary"></span>
                          </label>
                        </div>

                      </div>

                      <div class="d-flex flex-column align-items-start align-items-center sub-btnsize ">
                        <button name="submit" class="mt-4 btn btn-success" type="submit"><i class="fa fa-filter"></i> Filter Details</button>
                      </div>

                    </div>
                  </form>
                </div>
              </div>
            </div>

            <div id="diesaseAnalysisSection" class="col-sm-12 col-xl-6 box-col-6">
              <div class="card">
                <div class="card-body ">

                  <div class="d-flex justify-content-between">
                    <h4> Disease Analysis </h4>
                    <button onclick="printThis1()" class="btn btn-primary"><i class="fa fa-print"></i></button>
                  </div>

                  <?php
                  if (isset($_POST['submit'])) {
                    $startDate = date("Y-m-d", strtotime($_POST['startDate']));
                    $endDate = date("Y-m-d", strtotime($_POST['endDate']));

                    $header = "<h1>Disease Analysis</h1> <h3>[ $startDate  to   $endDate ]</h3> <br>";
                  } else {
                    $header = "<h1>Disease Analysis</h1><h6>[ Overall System ]</h6> <br>";
                  }
                  ?>

                  <script>
                    function printThis1() {
                      $('#diseaseAnalysis').printThis({
                        importCSS: true,
                        importStyle: true,
                        header: null, // prefix to html
                        footer: null, // postfix to html
                        header: "<?php echo $header ?>",
                        removeInline: false, // remove inline styles from print elements
                        removeInlineSelector: "*", // custom selectors to filter inline styles. removeInline 
                      });
                    }
                  </script>

                  <h6>[No of Patients per Disease]</h6>
                  <div class="chart-overflow" id="diseaseAnalysis" style="width: 450px; height: 300px;"></div>
                </div>
              </div>
            </div>

            <div class="col-sm-12 col-xl-6 box-col-6">
              <div class="card">
                <div class="card-body ">

                  <div class="d-flex justify-content-between">
                    <h4>Disease Category Analysis</h4>
                    <button onclick="printThis2()" class="btn btn-primary"><i class="fa fa-print"></i></button>
                  </div>

                  <?php
                  if (isset($_POST['submit'])) {
                    $startDate = date("Y-m-d", strtotime($_POST['startDate']));
                    $endDate = date("Y-m-d", strtotime($_POST['endDate']));

                    $header = "<h1>Disease Category Analysis</h1> <h3>[ $startDate  to   $endDate ]</h3> <br>";
                  } else {
                    $header = "<h1>Disease Category Analysis</h1><h6>[ Overall System ]</h6> <br>";
                  }
                  ?>

                  <script>
                    function printThis2() {
                      $('#diseaseCategoryAnalysis').printThis({
                        importCSS: true,
                        importStyle: true,
                        header: null, // prefix to html
                        footer: null, // postfix to html
                        header: "<?php echo $header ?>",
                        removeInline: false, // remove inline styles from print elements
                        removeInlineSelector: "*", // custom selectors to filter inline styles. removeInline 
                      });
                    }
                  </script>


                  <h6>[No of Patients per Disease Category]</h6>
                  <div class="chart-overflow" id="diseaseCategoryAnalysis" style="width: 450px; height: 300px;"></div>
                </div>
              </div>
            </div>

            <div class="col-sm-12 col-xl-6 box-col-6">
              <div class="card">
                <div class="card-body ">

                  <div class="d-flex justify-content-between">
                    <h4>Appointment Status Analysis</h4>
                    <button onclick="printThis3()" class="btn btn-primary"><i class="fa fa-print"></i></button>
                  </div>

                  <?php
                  if (isset($_POST['submit'])) {
                    $startDate = date("Y-m-d", strtotime($_POST['startDate']));
                    $endDate = date("Y-m-d", strtotime($_POST['endDate']));

                    $header = "<h1>Appointment Status Analysis</h1> <h3>[ $startDate  to   $endDate ]</h3> <br>";
                  } else {
                    $header = "<h1>Appointment Status Analysis</h1><h6>[ Overall System ]</h6> <br>";
                  }
                  ?>

                  <script>
                    function printThis3() {
                      $('#appointmentStatusAnalysis').printThis({
                          importCSS: true,
                          importStyle: true,
                          loadCSS: "#chart-overflow{ width: 1200 px}",
                          header: null, // prefix to html
                          footer: null, // postfix to html
                          header: "<?php echo $header ?>",
                          removeInline: false, // remove inline styles from print elements
                          removeInlineSelector: "*", // custom selectors to filter inline styles. removeInline 
                      });
                    }
                  </script>


                  <div class="chart-overflow" id="appointmentStatusAnalysis" style="width: 450px; height: 300px;"></div>
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
        ['DiseaseName', 'Numbers of Patient'],
        <?php
        include '../../connection/db.php';

        $sql = "SELECT `disease`.*, COUNT(patient.p_id) AS 'no_of_patient'
                FROM `disease` 
                  INNER JOIN `paitenthasdisease` ON `paitenthasdisease`.`dis_id_fk` = `disease`.`dis_id` 
                  INNER JOIN `patient` ON `paitenthasdisease`.`p_id_fk` = `patient`.`p_id`";

        if (isset($_POST['submit'])) {
          if (isset($_POST['diseaseAnalysis_check'])) {

            $startDate = date("Y-m-d", strtotime($_POST['startDate']));

            $endDate = date("Y-m-d", strtotime($_POST['endDate']));

            $sql .= " AND paHasDis_recordedDate BETWEEN '$startDate 00:00:00' AND '$endDate 23:59:59' ";
          }
        }

        $sql .= "GROUP BY `disease`.`dis_id`";

        // echo $sql;

        $exec = mysqli_query($con, $sql);

        while ($row = mysqli_fetch_array($exec)) {
        ?>['<?php echo $row['dis_name'] ?>', <?php echo $row['no_of_patient'] ?>],
        <?php
        }
        ?>

      ]);


      // ---------------------------------------------------------------------------------
      // -------------------------- DISEASE CATEGORY ANALYSIS -------------------------- 
      // ---------------------------------------------------------------------------------
      var options = {
        title: ' ',
        backgroundColor: '#F7F7FF ',

        // Colors only the chart area, with opacity
        chartArea: {
          backgroundColor: {
            fill: '#F7F7FF ',
            fillOpacity: 0.1
          },
        },
        // Colors the entire chart area, simple version
        // backgroundColor: '#FFFFFF',
        // Colors the entire chart area, with opacity
        backgroundColor: {
          fill: '#F7F7FF ',
          fillOpacity: 0
        },

      };

      <?php

      include '../../connection/db.php';

      $sql = "SELECT diseasecategory.*, COUNT(patient.p_id) AS 'no_of_patient'
                  FROM `disease` 
                    INNER JOIN diseasecategory ON `disease`.`disCat_id_fk` = `diseasecategory`.`disCat_id`
                    INNER JOIN `paitenthasdisease` ON `paitenthasdisease`.`dis_id_fk` = `disease`.`dis_id` 
                    INNER JOIN `patient` ON `paitenthasdisease`.`p_id_fk` = `patient`.`p_id`";


      if (isset($_POST['submit'])) {
        if (isset($_POST['dieseaseCategory_check'])) {

          $startDate = date("Y-m-d", strtotime($_POST['startDate']));

          $endDate = date("Y-m-d", strtotime($_POST['endDate']));

          $sql .= " AND paHasDis_recordedDate BETWEEN '$startDate 00:00:00' AND '$endDate 23:59:59' ";
        }
      }

      $sql .= "GROUP BY diseasecategory.disCat_id";

      $exec = mysqli_query($con, $sql);

      if (mysqli_num_rows($exec) > 0) {
      ?>
        var diseaseCatData = google.visualization.arrayToDataTable([
          ['AgeGroup', 'Count of People'],
          <?php

          while ($row = mysqli_fetch_array($exec)) {
          ?>['<?php echo $row['disCat_name'] ?>', <?php echo $row['no_of_patient'] ?>],
          <?php
          }
          ?>
        ]);
      <?php
      } else {
      ?>
        $("#diseaseCategoryAnalysis").append('<div class="alert alert-danger" role="alert"> No Data Found! </div>');
      <?php
      }

      ?>

      var options1 = {
        title: ' ',
        colors: ['#ec8f6e', '#f3b49f', '#f6c7b6'],

        backgroundColor: '#F7F7FF ',

        // Colors only the chart area, with opacity
        chartArea: {
          backgroundColor: {
            fill: '#F7F7FF ',
            fillOpacity: 0.1
          },
        },
        // Colors the entire chart area, simple version
        // backgroundColor: '#FFFFFF',
        // Colors the entire chart area, with opacity
        backgroundColor: {
          fill: '#F7F7FF ',
          fillOpacity: 0
        },


      };





      // ---------------------------------------------------------------------------------
      // -------------------------- APPOINTMENT STATUS ANALYSIS -------------------------- 
      // ---------------------------------------------------------------------------------

      <?php

      $sql = "SELECT `bookingstatus`.*, COUNT(patient.p_id) AS 'no_of_patient'
                FROM `booking` 
                  INNER JOIN `bookingstatus` ON `booking`.`bookStatus_id_fk` = `bookingstatus`.`bookStatus_id` 
                  INNER JOIN `patient` ON `booking`.`p_id_fk` = `patient`.`p_id`";

      if (isset($_POST['submit'])) {
        if (isset($_POST['appointmentStatus_check'])) {

          $startDate = date("Y-m-d", strtotime($_POST['startDate']));

          $endDate = date("Y-m-d", strtotime($_POST['endDate']));

          $sql .= " AND book_allocateDateTime BETWEEN '$startDate 00:00:00' AND '$endDate 23:59:59' ";
        }
      }

      $sql .= "GROUP BY `bookingstatus`.`bookStatus_id`";

      $exec = mysqli_query($con, $sql);

      if (mysqli_num_rows($exec) > 0) {
      ?>
        var appointStatusData = google.visualization.arrayToDataTable([
          ['DiseaseName', 'Numbers of Patient'],
          <?php
          while ($row = mysqli_fetch_array($exec)) {
          ?>['<?php echo $row['bookStatus_name'] ?>', <?php echo $row['no_of_patient'] ?>],
          <?php
          }
          ?>

        ]);

        var options2 = {
          title: ' ',
          colors: ['#006d77', '#8ac926', '#d90429'],

          backgroundColor: '#F7F7FF ',

          // Colors only the chart area, with opacity
          chartArea: {
            backgroundColor: {
              fill: '#F7F7FF ',
              fillOpacity: 0.1
            },
          },
          // Colors the entire chart area, simple version
          // backgroundColor: '#FFFFFF',
          // Colors the entire chart area, with opacity
          backgroundColor: {
            fill: '#F7F7FF ',
            fillOpacity: 0
          },
        };

      <?php
      } else {
      ?>
        $("#appointmentStatusAnalysis").append('<div class="alert alert-danger" role="alert"> No Data Found! </div>');
      <?php

      }
      ?>


      var chart = new google.visualization.PieChart(document.getElementById('diseaseAnalysis'));

      var disCatAnalysis = new google.visualization.BarChart(document.getElementById('diseaseCategoryAnalysis'));

      var appointmentStatusAnalysis = new google.visualization.PieChart(document.getElementById('appointmentStatusAnalysis'));

      chart.draw(data, options);

      disCatAnalysis.draw(diseaseCatData, options1);

      appointmentStatusAnalysis.draw(appointStatusData, options2);

    }
  </script>




</body>

</html>