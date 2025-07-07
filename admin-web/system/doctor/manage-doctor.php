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
                <h3>Manage Doctor</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php"> <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Doctor</li>
                  <li class="breadcrumb-item">Manage Doctor</li>
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
                        <th>Doctor ID</th>
                        <th>Doctor Name</th>
                        <th>Image</th>
                        <th>Contact Number</th>
                        <th>Medical License No</th>
                        <th>Type</th>
                        <th>Disease Category</th>
                        <th>Hospital</th>
                        <th>Email/Username</th>
                        <th>Actions</th>

                      </tr>
                    </thead>

                    <tbody>

                      <?php
                      include '../../connection/db.php';
                      $sql = "SELECT `doctor`.*, `diseasecategory`.*, `admin`.*, `hospital`.*
                              FROM `doctor` 
                                INNER JOIN `diseasecategory` ON `doctor`.`disCat_id_fk` = `diseasecategory`.`disCat_id` 
                                INNER JOIN `admin` ON `doctor`.`adm_id_fk` = `admin`.`adm_id` 
                                INNER JOIN `hospital` ON `doctor`.`hos_id_fk` = `hospital`.`hos_id`";

                      $exec = mysqli_query($con, $sql);

                      while ($row = mysqli_fetch_array($exec)) {
                      ?>
                        <tr>

                          <td><?php echo $row['doc_id'] ?></td>
                          <td><?php echo $row['doc_name'] ?></td>
                          <td> <img src="../../uploads/doctor/<?php echo $row['doc_img'] ?>" width="100%" alt=""> </td>
                          <td><?php echo $row['doc_contact'] ?></td>
                          <td><?php echo $row['doc_mediLicenseNo'] ?></td>

                          <?php
                          if ($row['specilist'] == 1) {
                            $specalistType = "Specialist";
                          } elseif ($row['specilist'] == 0) {
                            $specalistType = "General";
                          }
                          ?>
                          <td><?php echo $specalistType ?></td>
                          <td><?php echo $row['disCat_name'] ?></td>
                          <td><?php echo $row['hos_branch'] ?></td>
                          <td><?php echo $row['doc_username'] ?></td>

                          <td>
                            <button onclick="viewDoctor(<?php echo $row['doc_id'] ?>)" class="btn btn-primary"><i class="fa fa-eye"></i></button>
                            <a href="update-doctor.php?upd_id=<?php echo $row['doc_id'] ?>"><button class="btn btn-warning"><i class="fa fa-edit"></i></button></a>
                            <button class="btn btn-danger" onclick="deleteDoctor('<?php echo $row['doc_id'] ?>')"><i class="fa fa-trash"></i></button>
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
        // onContentReady: function() {
        // 	var self = this;
        // 	this.setContentPrepend('<div>Prepended text</div>');
        // 	setTimeout(function() {
        // 		self.setContentAppend('<div>Appended text after 2 seconds</div>');
        // 	}, 2000);
        // },
        columnClass: 'medium',
      });
    }
  </script>



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

  <script>
    function deleteDoctor(docID) {
      $.confirm({
        icon: 'fa fa-question-circle',
        title: 'Do you want to delete this Doctor...??',
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
              window.location.href = 'manage-doctor.php';
            }
          },
          delete: {
            text: 'Delete',
            btnClass: 'btn-danger',
            keys: ['enter'],
            action: function() {
              window.location.href = 'manage-doctor.php?del_id=' + docID;
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

  $doctorID = $_GET['del_id'];

  $sql = "DELETE FROM doctor WHERE doc_id =  $doctorID ";

  $exec = mysqli_query($con, $sql);

  if ($exec) {
?>
    <script>
      $.confirm({
        icon: 'fa fa-check-circle',
        title: 'Doctor Info Deleted Successfully',
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
              window.location.href = 'manage-doctor.php';
            }
          }
        }
      });
    </script>
<?php
  }
}

?>