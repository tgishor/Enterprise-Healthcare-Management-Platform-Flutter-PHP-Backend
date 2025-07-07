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
                <h3>Manage Payment</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php"> <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Payment</li>
                  <li class="breadcrumb-item">Manage Payment</li>
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

                  <table id="myTable" class="display" style="width:100%">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Patient Info</th>
                        <th>Booking Allocated Date</th>
                        <th>Payment Type</th>
                        <th>Payment Amount</th>
                        <th>Action</th>
                      </tr>
                    </thead>

                    <tbody>

                      <?php
                      include '../../connection/db.php';
                      $sql = "SELECT `booking`.*, `patient`.*, `payment`.*,`paymenttype`.*
                              FROM `booking` 
                              INNER JOIN `patient` ON `booking`.`p_id_fk` = `patient`.`p_id`
                              INNER JOIN `payment` ON `payment`.`book_id_fk` = `booking`.`book_id`
                              INNER JOIN `paymenttype` ON `payment`.`pay_typ_fk` = `paymenttype`.`pType_id`";

                      $exec = mysqli_query($con, $sql);

                      while ($row = mysqli_fetch_array($exec)) {
                      ?>
                        <tr>
                          <td><?php echo $row['pay_id'] ?></td>
                          <td>
                            <?php echo $row['p_name'] . " | " . $row['p_nic'] ?>
                          </td>
                          <td><?php echo $row['book_allocateDateTime'] ?></td>
                          <td><?php echo $row['pType_name'] ?></td>
                          <td><?php echo "Rs. ".number_format($row['pay_amount']) ?></td>
                          <td>
                            <a href="update-payment.php?id=<?php echo $row['pay_id'] ?>"><button class="btn btn-warning"><i class="fa fa-edit"></i></button></a>
                            <a href="manage-payment.php?del_id=<?php echo $row['pay_id'] ?>"><button class="btn btn-danger"><i class="fa fa-trash"></i></button></a>
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
        <!-- Container-fluid Ends-->

      </div>
    </div>
  </div>

  <?php include '../../components/scripts.php' ?>

  <script>
    $(document).ready(function() {

      $('#myTable').DataTable({
        scrollX: true,
        columnDefs: [{
          width: 200,
          targets: -1
        }],
        dom: 'lBfrtip',
        buttons: [{
          extend: 'collection',
          text: 'Export',
          className: 'custom-html-collection',

          buttons: ['pdf',
            'copy',
            {
              extend: 'print',
              title: 'Patient Records',
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

  $adminID = $_GET['del_id'];

  $sql = "DELETE FROM payment WHERE pay_id =  $adminID ";

  $exec = mysqli_query($con, $sql);

  if ($exec) {
?>
    <script>
      $.confirm({
        icon: 'fa fa-check-circle',
        title: 'Payment Deleted Successfully',
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
              window.location.href = 'manage-payment.php';
            }
          }
        }
      });
    </script>
<?php
  }
}

?>