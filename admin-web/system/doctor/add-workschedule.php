<!DOCTYPE html>
<html lang="en">

<?php

include '../../components/head.php';


if (isset($_GET['doc_id'])) {
  $doctorID = $_GET['doc_id'];
}


?>

<body>

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
                <h3>Add New Working Schedule</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php"> <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Working Schedule</li>
                  <li class="breadcrumb-item">Add Working Schedule</li>
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



                  <div class="row g-3">

                    <div class="col-6">
                      <div class="row">

                        <form method="POST">
                          <div class="col-12 mb-3 d-flex justify-content-around align-items-center">
                            <input name="setWeeklyWork" class="btn bg-info" type="submit" value="Set Whole Working Week">
                            <input name="setWeeklyLeave" class="btn bg-info" type="submit" value="Set Whole Week Leave">
                          </div>
                        </form>

                        <form method="POST" class="needs-validation" novalidate="" enctype="multipart/form-data">

                          <div class="row">
                            <div class="col-6">
                              <label class="form-label" for="allocatedatetime">From DateTime</label>
                              <input class="form-control" id="validationCustom01" type="datetime-local" name="from_datetime" value="" id="">
                              <div class="valid-feedback">Looks good!</div>
                              <div class="invalid-feedback">Please Add a To Date Time</div>
                            </div>

                            <div class="col-6">
                              <label class="form-label" for="validationCustom02">To DateTime</label>
                              <input name="over_datetime" class="form-control" id="validationCustom02" type="datetime-local" required="">
                              <div class="valid-feedback">Looks good!</div>
                              <div class="invalid-feedback">Please Add a To Date Time</div>
                            </div>

                            <div class="col-12 mt-3">
                              <label class="form-label" for="validationCustom01">Duty Type</label>
                              <select class="form-control" name="selected_duty" id="validationCustom01" required>
                                <option selected disabled>Select the Duty Type</option>

                                <?php
                                include '../../connection/db.php';
                                $sql = "SELECT * FROM doctoravastatus";
                                $exec = mysqli_query($con, $sql);
                                while ($row = mysqli_fetch_array($exec)) {
                                ?>
                                  <option value="<?php echo $row['doctorAvaStatus_id'] ?>"><?php echo $row['doctorAvaStatus_name'] ?></option>
                                <?php
                                }
                                ?>

                              </select>
                              <div class="valid-feedback">Looks good!</div>
                              <div class="invalid-feedback">Please Add a To Date Time</div>
                            </div>

                            <div class="d-flex flex-column align-items-start align-items-center sub-btnsize ">
                              <button name="submit" id="submit" class="mt-4 btn btn-success" type="submit"><i class="fa fa-plus-square"></i> Add New Working Schedule</button>
                            </div>
                          </div>

                        </form>
                      </div>
                    </div>

                    <div class="col-6">
                      <div class="table-responsive">
                        <table class="table text-center">
                          <thead class="table-dark">
                            <tr>
                              <th scope="col">Schedule ID</th>
                              <th scope="col">From Date</th>
                              <th scope="col">To Date</th>
                              <th scope="col">Duty Status</th>
                              <th scope="col">Actions</th>
                            </tr>
                          </thead>

                          <tbody id="">

                            <?php

                            include '../../connection/db.php';

                            $sql = "SELECT `doctorschedule`.*, `doctorworktime`.*, `doctor`.*, `doctoravastatus`.*
                                    FROM `doctorschedule` 
                                    INNER JOIN `doctorworktime` ON `doctorworktime`.`doctorSch_id_fk` = `doctorschedule`.`doctorSch_id` 
                                    INNER JOIN `doctor` ON `doctorworktime`.`doc_id_fk` = `doctor`.`doc_id` 
                                    INNER JOIN `doctoravastatus` ON `doctorschedule`.`doctorAvaStatus_id_fk` = `doctoravastatus`.`doctorAvaStatus_id` WHERE `doctor`.`doc_id`= $doctorID ORDER BY  `doctorschedule`. `doctorSch_id` DESC";

                            $exec = mysqli_query($con, $sql);

                            while ($row = mysqli_fetch_array($exec)) {
                            ?>
                              <tr>
                                <td><?php echo $row['doctorSch_id']; ?></td>
                                <td><?php echo date('d-m-Y h:i:s a ', strtotime($row['attendingDateTime'])); ?></td>
                                <td><?php echo date('d-m-Y h:i:s a ', strtotime($row['offDateTime'])) ?></td>
                                <td><?php echo $row['doctorAvaStatus_name'] ?></td>
                                <td>
                                  <a class="badge badge-danger" href="add-workschedule.php?doc_id=<?php echo $doctorID ?>&doc_sch=<?php echo $row['doctorSch_id'] ?>" data-bs-original-title="" title=""><i class="fa fa-trash" style="font-size: 15px ;"></i></a>
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
        <!-- Container-fluid Ends-->

      </div>
    </div>
  </div>

  <?php include '../../components/scripts.php' ?>

  <script>
    // Pass single element
    const element = document.querySelector('.js-choice');
    const choices = new Choices(element);
  </script>

  <script>
    $("#hospitalselector").on('change', function() {

      $('.selectDoctor option:not(:first)').remove();

      var selected_id = this.value;
      console.log(selected_id);

      $.ajax({
        type: "GET",
        url: "select-doctor.php?hos_id=" + selected_id,
        dataType: "html",
        success: function(data) {
          $('.selectDoctor').append(data);
          console.log(data);
        }
      });

    });

    $(".selectDoctor").on('change', function() {

      var selected_id = this.value;

      console.log(selected_id);

      if (this.value > 0) {
        $.ajax({
          type: "GET",
          url: "get-doctor-info.php?doc_id=" + selected_id,
          dataType: "html",
          success: function(data) {
            $("#table-container").html(data)
            console.log(data);
          }
        });
      }

    });
  </script>


</body>

</html>


<?php

include '../../connection/db.php';

date_default_timezone_set('Asia/Colombo');

$getTodayDate = date('Y-m-d 09:00:00');

$weeklater = date('Y-m-d 21:00:00', strtotime($getTodayDate . ' + 7 days'));


if (array_key_exists('setWeeklyWork', $_POST)) {

  $sql = "INSERT INTO `doctorschedule`( `attendingDateTime`, `offDateTime`, `doctorAvaStatus_id_fk`) 
          VALUES ('$getTodayDate','$weeklater','1')";

  $exec = mysqli_query($con, $sql);

  $docScheduleID = mysqli_insert_id($con);

  $sql_assigndoctor = "INSERT INTO `doctorworktime`(`doc_id_fk`, `doctorSch_id_fk`) VALUES ('$doctorID','$docScheduleID')";

  $exec_assigndoctor = mysqli_query($con, $sql_assigndoctor);

  if ($exec_assigndoctor) {
?>
    <script>
      $.confirm({
        icon: 'fa fa-check-circle ',
        title: 'Your Doctor Schedule Added Successfully',
        content: 'Your Data is Added Successfully',
        columnClass: 'col-md-4 col-md-offset-4',
        draggable: false,
        theme: 'modern',
        buttons: {
          confirm: {
            text: 'Back to View',
            btnClass: 'btn-blue',
            keys: ['shift'],
            action: function() {
              window.location.href = 'manage-workschedule.php';
            }
          },
          again: {
            text: 'Add Another Data',
            btnClass: 'btn-blue',
            keys: ['enter'],
            action: function() {
              window.location.href = 'add-workschedule.php?doc_id=<?php echo $_GET['doc_id'] ?>';
            }
          }
        }
      });
    </script>
  <?php
  } else {
  ?>
    <script>
      alert("Error in Adding the Work Schedule");
    </script>
  <?php
  }
}

if (array_key_exists('setWeeklyLeave', $_POST)) {

  $sql = "INSERT INTO `doctorschedule`( `attendingDateTime`, `offDateTime`, `doctorAvaStatus_id_fk`) 
          VALUES ('$getTodayDate','$weeklater','2')";

  $exec = mysqli_query($con, $sql);

  $docScheduleID = mysqli_insert_id($con);

  $sql_assigndoctor = "INSERT INTO `doctorworktime`(`doc_id_fk`, `doctorSch_id_fk`) VALUES ('$doctorID','$docScheduleID')";

  $exec_assigndoctor = mysqli_query($con, $sql_assigndoctor);

  if ($exec_assigndoctor) {
  ?>
    <script>
      $.confirm({
        icon: 'fa fa-check-circle ',
        title: 'Your Doctor Schedule Added Successfully',
        content: 'Your Data is Added Successfully',
        columnClass: 'col-md-4 col-md-offset-4',
        draggable: false,
        theme: 'modern',
        buttons: {
          confirm: {
            text: 'Back to View',
            btnClass: 'btn-blue',
            keys: ['shift'],
            action: function() {
              window.location.href = 'manage-workschedule.php';
            }
          },
          again: {
            text: 'Add Another Data',
            btnClass: 'btn-blue',
            keys: ['enter'],
            action: function() {
              window.location.href = 'add-workschedule.php?doc_id=<?php echo $_GET['doc_id'] ?>';
            }
          }
        }
      });
    </script>
  <?php
  } else {
  ?>
    <script>
      alert("Error in Adding the Work Schedule");
    </script>
  <?php
  }
}


if (isset($_GET['doc_sch'])) {

  $sql = " DELETE FROM `doctorschedule` WHERE `doctorSch_id`='" . $_GET['doc_sch'] . "'";

  $exec = mysqli_query($con, $sql);

  if ($exec) {
  ?>
    <script>
      $.confirm({
        icon: 'fa fa-check-circle ',
        title: 'Your Doctor Schedule Removed Successfully',
        content: 'Your Data is Added Successfully',
        columnClass: 'col-md-4 col-md-offset-4',
        draggable: false,
        theme: 'modern',
        buttons: {
          confirm: {
            text: 'Ok',
            btnClass: 'btn-blue',
            keys: ['shift'],
            action: function() {
              window.location.href = 'add-workschedule.php?doc_id= <?php echo $_GET['doc_id'] ?>';
            }
          }
        }
      });
    </script>
  <?php
  }
}


if (isset($_POST['submit'])) {

  $from_datetime = $_POST['from_datetime'];
  $over_datetime = $_POST['over_datetime'];
  $selected_duty = $_POST['selected_duty'];

  $sql = "INSERT INTO `doctorschedule`( `attendingDateTime`, `offDateTime`, `doctorAvaStatus_id_fk`) 
          VALUES ('$from_datetime','$over_datetime','$selected_duty')";

  $exec = mysqli_query($con, $sql);

  $docScheduleID = mysqli_insert_id($con);

  $sql_assigndoctor = "INSERT INTO `doctorworktime`(`doc_id_fk`, `doctorSch_id_fk`) VALUES ('$doctorID','$docScheduleID')";

  $exec_assigndoctor = mysqli_query($con, $sql_assigndoctor);


  if ($exec_assigndoctor) {
  ?>
    <script>
      $.confirm({
        icon: 'fa fa-check-circle ',
        title: 'Doctor Schedule Added Successfully',
        content: 'Your Data is Inserted Successfully',
        columnClass: 'col-md-4 col-md-offset-4',
        draggable: false,
        theme: 'modern',
        buttons: {
          confirm: {
            text: 'Back to View',
            btnClass: 'btn-blue',
            keys: ['shift'],
            action: function() {
              window.location.href = 'manage-workschedule.php';
            }
          },
          again: {
            text: 'Add Another Data',
            btnClass: 'btn-blue',
            keys: ['enter'],
            action: function() {
              window.location.href = 'add-workschedule.php?doc_id=<?php echo $_GET['doc_id'] ?>';
            }
          }
        }
      });
    </script>
  <?php
  } else {
  ?>
    <script>
      $.confirm({
        icon: 'fa fa-exclamation-circle ',
        title: 'Ooppss!! Error in Adding this Doctor Schedule',
        content: 'Faced an issue in adding doctor schedule, Please Try Again',
        columnClass: 'col-md-4 col-md-offset-4',
        type: 'red',
        draggable: false,
        theme: 'modern',
        buttons: {
          again: {
            text: 'Try Again',
            btnClass: 'btn-red',
            keys: ['enter'],
            action: function() {
              window.location.href = 'add-booking.php';
            }
          }
        }
      });
    </script>
<?php
  }
}


?>