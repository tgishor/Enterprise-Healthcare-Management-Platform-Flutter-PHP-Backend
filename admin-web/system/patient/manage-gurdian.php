<!DOCTYPE html>
<html lang="en">

<?php

use FFI\Exception;

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
                <h3>Manage Patient</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php"> <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Patient</li>
                  <li class="breadcrumb-item">Manage Patient</li>
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
                        <th>Gurdian ID</th>
                        <th>Gurdian Name</th>
                        <th>Phone number</th>
                        <th>Description</th>
                        <th>Patient Name | NIC</th>
                        <th>Patient Image</th>
                        <th>Action </th>
                      </tr>
                    </thead>

                    <tbody>

                      <?php
                      include '../../connection/db.php';
                      $sql = "SELECT `gurdiandetails`.*, `patient`.*
                              FROM `gurdiandetails` 
                                INNER JOIN `patient` ON `gurdiandetails`.`p_id_fk` = `patient`.`p_id`;";

                      $exec = mysqli_query($con, $sql);

                      while ($row = mysqli_fetch_array($exec)) {
                      ?>
                        <tr>
                          
                          <td><?php echo $row['gur_id'] ?></td>
                          <td><?php echo $row['gur_name'] ?></td>
                          <td><?php echo $row['gur_phoneNo'] ?></td>
                          <td><?php echo $row['gur_desc'] ?></td>
                          <td><?php echo $row['p_name'] . ' | ' . $row['p_nic'] ?></td>
                          <td><img src="../../uploads/patient/<?php echo $row['p_img'] ?>" width="50px" class="rounded-2" alt=""></td>
                          <td>
                            <a href="update-patient.php?upd_id=<?php echo $row['p_id'] ?>"><button class="btn btn-warning"><i class="fa fa-edit"></i></button></a>
                            <button onclick="deletePatient(<?php echo $row['p_id'] ?>)" class="btn btn-danger"><i class="fa fa-trash"></i></button>
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

  <script>
    function deletePatient(patientID) {
      $.confirm({
        icon: 'fa fa-question-circle',
        title: 'Do you want to delete this Patient...??',
        content: 'If Yes, Please Follow up with Delete Button',
        columnClass: 'col-md-4 col-md-offset-4',
        draggable: false,
        theme: 'modern',
        buttons: {
          back: {
            text: 'Cancel',
            btnClass: 'btn-blue',
            keys: ['enter'],
            action: function() {
              window.location.href = 'manage-patient.php';
            }
          },
          delete: {
            text: 'Delete',
            btnClass: 'btn-danger',
            keys: ['enter'],
            action: function() {
              window.location.href = 'manage-patient.php?del_id=' + patientID;
            }
          }
        }
      });
    }
  </script>

</body>

</html>

<?php

if (isset($_GET['del_id']) != null) {

  $p_id = $_GET['del_id'];

  $sql = "DELETE FROM patient WHERE p_id =  $p_id ";

  try {
    $exec = mysqli_query($con, $sql);

    if ($exec) {
?>
      <script>
        $.confirm({
          icon: 'fa fa-check-circle',
          title: 'Patient Record Deleted Successfully',
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
  } catch (Exception $e) {
    ?>
    <script>
      alert('Error in Deleting the Data');
    </script>
<?php
  }
}

?>