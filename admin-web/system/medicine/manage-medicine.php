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
                <h3>Manage Medicines</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php"> <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Medicines</li>
                  <li class="breadcrumb-item">Manage Medicines</li>
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
                        <th>Medi ID</th>
                        <th>Medi Name</th>
                        <th>Pill Code</th>
                        <th>Front Image</th>
                        <th>Back Image</th>
                        <th>Drug Type</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      include '../../connection/db.php';
                      $sql = "SELECT `medicine`.*, `drugtype`.* FROM `medicine` 
                              INNER JOIN `drugtype` ON `medicine`.`dType_id_fk` = `drugtype`.`dType_id`";
                      $exec = mysqli_query($con, $sql);

                      while ($row = mysqli_fetch_array($exec)) {
                      ?>
                        <tr>
                          <td><?php echo $row['medi_id'] ?></td>
                          <td><?php echo $row['medi_name'] ?></td>
                          <td><?php echo $row['medi_pillCode'] ?></td>
                          <td class="">
                            <img src="../../uploads/medicine/frontimage/<?php echo $row['medi_frontImg'] ?>" class="img-fluid rounded" width="50px" alt="">
                          </td>
                          <td>
                            <img src="../../uploads/medicine/backimage/<?php echo $row['medi_backImg'] ?>" class="img-fluid rounded" width="50px" alt="">
                          </td>
                          <td><?php echo $row['dType_name'] ?></td>
                          <td>
                            <button onclick="viewMedicine(<?php echo $row['medi_id'] ?>)" class="btn btn-primary"><i class="fa fa-eye"></i></button>

                            <a href="update-medicine.php?upd_id=<?php echo $row['medi_id'] ?>"><button class="btn btn-warning"><i class="fa fa-edit"></i></button></a>

                            <a href="manage-medicine.php?del_id=<?php echo $row['medi_id'] ?>"><button class="btn btn-danger"><i class="fa fa-trash"></i></button></a>
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
    function viewMedicine(medview_id) {
      $.confirm({
        title: 'Medicine View (Medicine ID - ' + medview_id + ')',
        content: 'url:<?php echo $base_url ?>system/medicine/select-medicine.php?id=' + medview_id,
        columnClass: 'medium',
      });
    }
  </script>

  



  <script>
    $(document).ready(function() {
      $('#myTable').DataTable({
        dom: 'lBfrtip',
        buttons: [{
          extend: 'collection',
          text: 'Export',
          className: 'custom-html-collection',

          buttons: ['pdf',
            'copy', {
              extend: 'print',
              title: 'Patient Records',
              customize: function(win) {
                $(win.document.body)
                  .css('font-size', '10pt')
                  .prepend(
                    '<img src="http://localhost/finalproject/admin/assets/images/logo/logo-final.png" style="position: absolute; top:0;left:0; opacity: 0.2;" />'
                  );
                $(win.document.body).find('table')
                  .addClass('compact')
                  .css('font-size', 'inherit');
              }
            }
          ]
        }]
      });
    });
  </script>

</body>

</html>

<?php

if (isset($_GET['del_id']) != null) {

  $mediID = $_GET['del_id'];

  $sql = "SELECT * FROM `medicine` WHERE medi_id = '$mediID'";

  $exec = mysqli_query($con, $sql);

  while ($row = mysqli_fetch_array($exec)) {
    if (file_exists("../../uploads/medicine/frontimage/" +  $row['medi_frontImg'])) {
      unlink("../../uploads/medicine/frontimage/" + $row['medi_frontImg']);
    }
    if (file_exists("../../uploads/medicine/backimage/" + $row['medi_backImg'])) {
      unlink("../../uploads/medicine/backimage/" + $row['medi_backImg']);
    }
  }

  $sql = "DELETE FROM medicine WHERE medi_id =  $mediID ";

  $exec = mysqli_query($con, $sql);

  if ($exec) {
  ?>
    <script>
      $.confirm({
        icon: 'fa fa-check-circle',
        title: 'Medicine Deleted Successfully',
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