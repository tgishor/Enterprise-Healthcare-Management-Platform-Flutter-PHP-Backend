<!DOCTYPE html>
<html lang="en">

<?php

include '../../components/head.php';

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
                <h3>Manage Booking</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php"> <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Booking</li>
                  <li class="breadcrumb-item">Manage Booking</li>
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

                <div class="d-flex justify-content-center align-items-center mt-3">
                  <div class="col-6 d-flex justify-content-center align-items-center">
                    <a href="manage-booking.php?filter=today" class="btn btn-primary">Show Today Appointments</a>
                    <a style="margin-left:10px" href="manage-booking.php?filter=tomorrow" class="btn btn-primary">Show Tomorrow Appointments</a>
                  </div>
                </div>

                <div class="card-body">

                  <table id="myTable" class="display" style="width:100%">
                    <thead>
                      <tr>
                        <th>Booking ID</th>
                        <th>Booking Status</th>
                        <th>Action</th>
                        <th>Appointment Date</th>
                        <th>Patient Picture</th>
                        <th>Patient Name/NIC</th>
                        <th>Doctor Info</th>
                      </tr>
                    </thead>

                    <tbody>

                      <?php
                      include '../../connection/db.php';

                      date_default_timezone_set('Asia/Colombo');
                      $getTodayDate = date('Y-m-d');

                      $sql = "SELECT `booking`.*, `bookingstatus`.*, `patient`.*, `doctor`.*
                              FROM `booking` 
                                INNER JOIN `bookingstatus` ON `booking`.`bookStatus_id_fk` = `bookingstatus`.`bookStatus_id` 
                                INNER JOIN `patient` ON `booking`.`p_id_fk` = `patient`.`p_id` 
                                INNER JOIN `doctor` ON `booking`.`doc_id_fk` = `doctor`.`doc_id` WHERE `booking`.`book_id` != '0'  ";

                      if (isset($_SESSION['doctorID'])) {
                        $sql .= " AND `doctor`.`doc_id`= '" . $_SESSION['doctorID'] . "'";
                      }

                      if (isset($_GET['filter'])) {
                        if ($_GET['filter'] == "today") {
                          $sql .= " AND `booking`.`book_allocateDateTime` BETWEEN ' $getTodayDate 00:00:00' AND '$getTodayDate 23:59:00'";
                        } else if ($_GET['filter'] == "tomorrow") {
                          $oneDayLater = date('Y-m-d', strtotime($getTodayDate . ' + 1 days'));
                          $sql .= " AND `booking`.`book_allocateDateTime` BETWEEN '$oneDayLater 00:00:00' AND '$oneDayLater 23:59:00'";
                        }
                      }

                      $exec = mysqli_query($con, $sql);

                      while ($row = mysqli_fetch_array($exec)) {
                      ?>
                        <tr>
                          <td><?php echo $row['book_id'] ?></td>
                          <?php
                          if ($row['bookStatus_name'] == "Pending") {
                            $str = '<div class="button btn btn-info"><i class="fa fa-hourglass-half"></i></div>'; //Pending
                          } else if ($row['bookStatus_name'] == "Done") {
                            $str = ' <div class="button btn btn-success"><i class="fa fa-check-circle"></i></div>'; //Success
                          } else {
                            $str = '<div class="button btn btn-danger"><i class="fa fa-exclamation-triangle "></i></div>'; //Cancelled
                          }
                          ?>
                          <td class="text-center">
                            <?php echo $str ?>
                          </td>

                          <td class="text-center">

                            <?php
                            if (isset($_SESSION["staffType"]) && $_SESSION["staffType"] == "Receptionist") {
                            ?>
                              <a href="update-booking.php?upd_id=<?php echo $row['doc_id'] ?>"><button class="btn btn-warning  mt-1"><i class=" fa fa-edit"></i></button></a>

                              <a href="<?php echo $base_url ?>system/payment/add-payment.php?book_id=<?php echo $row['book_id'] ?>"><button class="btn btn-success  mt-1"><i class=" fa fa-money"></i></button></a>
                            <?php
                            }
                            ?>

                            <?php
                            if (isset($_SESSION["doctorID"])) {
                            ?>
                              <!-- Add Medical Record -->
                              <a href="<?php echo $base_url ?>system/medical-record/add-medicalrecord.php?book_id=<?php echo $row['book_id'] ?>">
                                <button class="btn btn-secondary mt-1">
                                  <i class="fa fa-plus-square"></i>
                                  <i class="fa fa-address-book-o"></i>
                                </button>
                              </a>
                            <?php
                            }
                            ?>

                            <!-- View Medical Record -->
                            <a href="<?php echo $base_url ?>system/medical-record/view-medicalrecord.php?p_id=<?php echo $row['p_id'] ?>">
                              <button class="btn btn-dark mt-1">
                                <i class="fa fa-eye"></i>
                                <i class="fa fa-address-book-o"></i>
                              </button>
                            </a>

                          </td>

                          <td><?php echo $row['book_allocateDateTime'] ?></td>
                          <td> <img src="../../uploads/patient/<?php echo $row['p_img'] ?>" width="75px" alt=""> </td>
                          <td><?php echo $row['p_name'] . " | " . $row['p_nic'] ?></td>

                          <td><?php echo $row['doc_name'] ?></td>
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

    // $('#example').DataTable({

    // });
  </script>

</body>

</html>

<?php

if (isset($_GET['del_id']) != null) {

  $mediID = $_GET['del_id'];

  $sql = "DELETE FROM admin WHERE medi_id =  $mediID ";

  $exec = mysqli_query($con, $sql);

  if ($exec) {
?>
    <script>
      $.confirm({
        icon: 'fa fa-check-circle',
        title: 'medicine Deleted Successfully',
        content: 'Your Data is Deleted Successfully',
        columnClass: 'col-md-4 col-md-offset-4',
        draggable: false,
        theme: 'modern',
        buttons: {
          confirm: {
            text: 'Back to View',
            btnClass: 'btn-blue',
            keys: ['enter'],
            action: function() {
              window.location.href = 'manage-medicine.php';
            }
          }
        }
      });
    </script>
<?php
  }
}

?>