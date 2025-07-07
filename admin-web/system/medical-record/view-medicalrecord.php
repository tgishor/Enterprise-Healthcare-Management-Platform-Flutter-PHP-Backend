<!DOCTYPE html>
<html lang="en">

<?php

include '../../components/head.php';


if (isset($_GET['p_id'])) {
  $patientID = $_GET['p_id'];
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
                <h3>Medical Record Summary</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php"> <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Medical Record</li>
                  <li class="breadcrumb-item">Add Medical Record</li>
                </ol>
              </div>
            </div>
          </div>
        </div>


        <?php
        include '../../connection/db.php';

        $sql = "SELECT `patient`.*, `gender`.*
                                            FROM `patient` 
                                              INNER JOIN `gender` ON `patient`.`gender_fk` = `gender`.`gender_id` 
                                              WHERE patient.p_id = '$patientID'";

        $exec = mysqli_query($con, $sql);

        while ($row = mysqli_fetch_array($exec)) {
          $p_name = $row['p_name'];
          $p_nic = $row['p_nic'];
          $p_dob = $row['p_dob'];
          $p_img = $row['p_img'];
          $p_contact = $row['p_contact'];
          $p_email = $row['p_email'];
          $p_username = $row['p_username'];
          $p_address = $row['p_address'];
          $gender = $row['gender'];
        }


        // $sql = "SELECT `patient`.*, `gender`.*, `booking`.*, `bookingstatus`.*, `medicalrecord`.*, `prescription`.*, `doctor`.*, `diseasecategory`.*
        //           FROM `patient`
        //           INNER JOIN `gender` ON `patient`.`gender_fk` = `gender`.`gender_id`
        //           INNER JOIN `booking` ON `booking`.`p_id_fk` = `patient`.`p_id` 
        //           INNER JOIN `bookingstatus` ON `booking`.`bookStatus_id_fk` = `bookingstatus`.`bookStatus_id` 
        //           INNER JOIN `medicalrecord` ON `medicalrecord`.`book_id_fk` = `booking`.`book_id`
        //           INNER JOIN `prescription` ON `prescription`.`mediRec_id_fk` = `medicalrecord`.`mediRec_id` 
        //           INNER JOIN `doctor` ON `booking`.`doc_id_fk` = `doctor`.`doc_id`
        //           INNER JOIN `diseasecategory` ON `doctor`.`disCat_id_fk` = `diseasecategory`.`disCat_id`
        //           WHERE p_id = $patientID";


        ?>

        <!-- Container-fluid starts-->
        <div class="container-fluid">
          <div class="email-wrap bookmark-wrap">
            <div class="row">
              <div id="patientDetails" class="col-xl-4 box-col-6">
                <div class="email-left-aside">
                  <div class="card">
                    <div class="card-body p-0">
                      <div class="row list-persons" id="addcon">
                        <div class="col-xl-12 xl-45 col-md-12" style="margin: 0 15px;">
                          <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-user">
                              <div class="profile-mail">
                                <div class="media" style="align-items: center; display: flex;">
                                  <img class="img-100 img-fluid m-r-20 rounded-circle update_img_0" src="<?php echo $base_url ?>uploads/patient/<?php echo $p_img ?>" alt="">
                                  <!-- <input class="updateimg" type="file" name="img" onchange="readURL(this,0)"> -->
                                  <div class="media-body mt-0 ">
                                    <h5><span class="first_name_0"><?php echo $p_name ?></span></h5>
                                    <p class="email_add_0"><?php echo $p_email ?></p>
                                  </div>
                                </div>
                                <div class="email-general p-2 mt-3">
                                  <h6 class="mb-3">General</h6>
                                  <ul>


                                    <li>Name <span class="font-primary first_name_0"><?php echo $p_name ?></span></li>
                                    <li>NIC No<span class="font-primary interest_0"><?php echo $p_nic ?></span></li>
                                    <li>Gender <span class="font-primary"><?php echo $gender ?></span></li>
                                    <li>Birthday<span class="font-primary"> <span class="birth_day_0"><?php echo date("d-M-y", strtotime($p_dob)) ?></span></li>
                                    <li>Mobile No<span class="font-primary mobile_num_0"><?php echo $p_contact ?></span></li>
                                    <li>Email Address <span class="font-primary email_add_0"><?php echo $p_email ?></span></li>
                                    <li>Username<span class="font-primary url_add_0"><?php echo $p_username ?></span></li>

                                    <li>Address<span class="font-primary city_0 mb-3"><?php echo $p_address ?></span></li>

                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>


              <div class="col-xl-8 col-md-12 box-col-12">
                <div class="email-right-aside bookmark-tabcontent contacts-tabs">
                  <div class="card email-body radius-left">
                    <div class="ps-0">
                      <div class="tab-content">
                        <div class="tab-pane fade active show" id="pills-personal" role="tabpanel" aria-labelledby="pills-personal-tab">
                          <div class="card mb-0">
                            <div class="card-header d-flex">
                              <?php
                              $sql = "SELECT `patient`.*, `gender`.*, `booking`.*, `bookingstatus`.*, `medicalrecord`.*, `prescription`.*, `doctor`.*, `diseasecategory`.*
                                        FROM `patient`
                                                INNER JOIN `gender` ON `patient`.`gender_fk` = `gender`.`gender_id`
                                                INNER JOIN `booking` ON `booking`.`p_id_fk` = `patient`.`p_id` 
                                                INNER JOIN `bookingstatus` ON `booking`.`bookStatus_id_fk` = `bookingstatus`.`bookStatus_id` 
                                                INNER JOIN `medicalrecord` ON `medicalrecord`.`book_id_fk` = `booking`.`book_id`
                                                INNER JOIN `prescription` ON `prescription`.`mediRec_id_fk` = `medicalrecord`.`mediRec_id` 
                                                INNER JOIN `doctor` ON `booking`.`doc_id_fk` = `doctor`.`doc_id`
                                                INNER JOIN `diseasecategory` ON `doctor`.`disCat_id_fk` = `diseasecategory`.`disCat_id`
                                                WHERE p_id = $patientID";

                              $exec = mysqli_query($con, $sql);

                              $noMediRecord = mysqli_num_rows($exec);
                              ?>
                              <h5>Medical Record Summary</h5><span class="f-14 pull-right mt-0"><?php echo $noMediRecord ?> Medical Records</span>
                            </div>
                            <div class="card-body p-0">
                              <div class="row list-persons" id="addcon">
                                <!-- ------------------------------------------- -->
                                <!-- ----- Personal Side Bar First Section ----- -->
                                <!-- ------------------------------------------- -->
                                <div class="col-md-4">
                                  <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">

                                    <?php


                                    $n = 0;
                                    while ($row = mysqli_fetch_array($exec)) {

                                    ?>

                                      <a class="contact-tab-<?php echo $n ?> nav-link" id="v-pills-<?php echo $n ?>-tab" data-bs-toggle="pill" onclick="activeDiv(<?php echo $n ?>)" href="#v-pills-<?php echo $n ?>" role="tab" aria-controls="v-pills-<?php echo $n ?>">
                                        <div class="media">
                                          <div class="media-body">
                                            <h6> <span class="first_name_0"><?php echo date("d F Y", strtotime($row['book_allocateDateTime'])); ?></span> <br> <span class="first_name_0"><?php echo date("h:i A", strtotime($row['book_allocateDateTime'])); ?></span></h6>
                                            <p class="email_add_0">Booking Date</p>
                                            <button class="btn btn-primary p-r-2 p-l-2 mt-1" onclick="printThis()" style="padding: 0.375rem 0.75rem;"><i class="fa fa-print m-0"></i></button>
                                            <script>
                                              function printThis() {
                                                $("#patientDetails, #mediDetails").printThis({
                                                  importCSS: true, // import parent page css
                                                  importStyle: true, // import style tags
                                                });
                                              }
                                            </script>
                                          </div>
                                        </div>
                                      </a>

                                    <?php

                                      $n++;
                                    }


                                    ?>






                                  </div>
                                </div>


                                <!-- ------------------------------------------- -->
                                <!-- ---- Personal Side Bar Second Section ----- -->
                                <!-- ------------------------------------------- -->

                                <div class="col-md-8">
                                  <div class="tab-content" id="v-pills-tabContent">


                                    <?php
                                    $sql = "SELECT `patient`.*, `gender`.*, `booking`.*, `bookingstatus`.*, `medicalrecord`.*, `prescription`.*, `doctor`.*, `diseasecategory`.*
                                            FROM `patient`
                                            INNER JOIN `gender` ON `patient`.`gender_fk` = `gender`.`gender_id`
                                            INNER JOIN `booking` ON `booking`.`p_id_fk` = `patient`.`p_id` 
                                            INNER JOIN `bookingstatus` ON `booking`.`bookStatus_id_fk` = `bookingstatus`.`bookStatus_id` 
                                            INNER JOIN `medicalrecord` ON `medicalrecord`.`book_id_fk` = `booking`.`book_id`
                                            INNER JOIN `prescription` ON `prescription`.`mediRec_id_fk` = `medicalrecord`.`mediRec_id` 
                                            INNER JOIN `doctor` ON `booking`.`doc_id_fk` = `doctor`.`doc_id`
                                            INNER JOIN `diseasecategory` ON `doctor`.`disCat_id_fk` = `diseasecategory`.`disCat_id`
                                            WHERE p_id = $patientID";

                                    $exec = mysqli_query($con, $sql);

                                    $i = 0;

                                    while ($row = mysqli_fetch_array($exec)) {
                                    ?>
                                      <div class="tab-pane contact-tab-<?php echo $i ?> tab-content-child fade" id="v-pills-<?php echo $i ?>" role="tabpanel" aria-labelledby="v-pills-<?php echo $i ?>-tab">
                                        <div id="mediDetails" class="profile-mail">
                                          <h6 class="mb-3">Doctor Details</h6>
                                          <div class="media d-flex justify-content-center">
                                            <div class="d-flex justify-content-center  m-r-20 update_img_1">
                                              <div class="rounded-circle" style="width:100px;
                                                height:100px;
                                                border-radius: 50% 50% 0 0;
                                                background-image: url('<?php echo $base_url ?>uploads/doctor/<?php echo $row['doc_img'] ?>'); 
                                                background-repeat:no-repeat; 
                                                background-size:cover;"></div>
                                            </div>

                                            <div class=" mt-0">
                                              <h5><span class="first_name_1"><?php echo $row['doc_name'] ?> </span></h5>
                                              <p class="email_add_1"><?php echo $row['doc_contact'] ?></p>
                                              <ul>
                                                <li><a href="#" onclick="printContact(1)" data-bs-toggle="modal" data-bs-target="#printModal">Print</a></li>
                                              </ul>
                                            </div>
                                          </div>
                                          <div class="email-general">
                                            <h6 class="mb-3">Summary</h6>
                                            <ul>
                                              <li>
                                                <div> Appointment Description: </div>
                                                <div> <span class="font-primary"><?php echo $row['book_desc'] ?></span> </div>
                                              </li>

                                              <li>
                                                <div> Medi Record Description: </div>
                                                <div> <span class="font-primary"><?php echo $row['mediRec_desc'] ?></span> </div>
                                              </li>

                                              <li>
                                                <div> Prescription Description: </div>
                                                <div> <span class="font-primary"><?php echo $row['pre_desc'] ?></span> </div>
                                              </li>

                                              <li>
                                                <div class="mb-1"> Diseases Faced: </div>
                                                <div>
                                                  <?php
                                                  $patientID = $row['p_id'];
                                                  $bookRegDate = $row['book_dateTime'];

                                                  $patientDiseases_sql = "SELECT `patient`.`p_id`, `paitenthasdisease`.*, `disease`.*
                                                            FROM `patient` 
                                                            INNER JOIN `paitenthasdisease` ON `paitenthasdisease`.`p_id_fk` = `patient`.`p_id` 
                                                            INNER JOIN `disease` ON `paitenthasdisease`.`dis_id_fk` = `disease`.`dis_id`
                                                            WHERE `patient`.`p_id` = '$patientID' AND `paitenthasdisease`.`paHasDis_recordedDate` 
                                                            BETWEEN '$bookRegDate 00:00:00'  AND  '$bookRegDate 23:59:59'";

                                                  $patientDiseases_exec = mysqli_query($con, $patientDiseases_sql);

                                                  while ($patientDiseases_row = mysqli_fetch_array($patientDiseases_exec)) {
                                                  ?>
                                                    <span class="badge badge-dark" style="font-size: 13px ;"><?php echo $patientDiseases_row['dis_name'] ?></span>
                                                  <?php
                                                  }
                                                  ?>
                                                </div>
                                              </li>
                                            </ul>

                                            <h6 class=" mt-4 mb-3">Prescribed Medicine</h6>

                                            <ul>
                                              <?php
                                              $prescription = $row['pre_id'];

                                              $sql_prescription = "SELECT `prescription`.*, `prescriptionstatus`.*, `precribingmedicine`.*, `medicine`.*, `drugtype`.*, `doseusage`.*, `usagetime`.*, `medicineusingstate`.*, `medicalrecord`.*, `booking`.*
                                                      FROM `prescription` 
                                                          INNER JOIN `prescriptionstatus` ON `prescription`.`preStatus_id_fk` = `prescriptionstatus`.`preStatus_id` 
                                                          INNER JOIN `precribingmedicine` ON `precribingmedicine`.`pre_id_fk` = `prescription`.`pre_id` 
                                                          INNER JOIN `medicine` ON `precribingmedicine`.`med_id_fk` = `medicine`.`medi_id` 
                                                          INNER JOIN `drugtype` ON `medicine`.`dType_id_fk` = `drugtype`.`dType_id` 
                                                          INNER JOIN `doseusage` ON `doseusage`.`preMed_id_fk` = `precribingmedicine`.`preMed_id` 
                                                          INNER JOIN `usagetime` ON `doseusage`.`usageTime_id_fk` = `usagetime`.`usageTime_id` 
                                                          INNER JOIN `medicineusingstate` ON `doseusage`.`medicineUsingState_id_fk` = `medicineusingstate`.`medicineUsingState_id` 
                                                          INNER JOIN `medicalrecord` ON `prescription`.`mediRec_id_fk` = `medicalrecord`.`mediRec_id` 
                                                          INNER JOIN `booking` ON `medicalrecord`.`book_id_fk` = `booking`.`book_id`
                                                      WHERE `prescription`.`pre_id` = $prescription";

                                              $exec_prescription = mysqli_query($con, $sql_prescription);

                                              while ($retriveData = mysqli_fetch_array($exec_prescription)) {

                                              ?>
                                                <li>
                                                  <div><strong>Medi Name:</strong> <?php echo $retriveData['medi_name'] . " [" . $retriveData['medi_pillCode'] . "]" ?></div>
                                                  <div><strong>Type:</strong> <?php echo $retriveData['dType_name'] ?></div>
                                                  <div><strong>Dosage:</strong> <?php echo $retriveData['doseQuantity'] ?></div>
                                                  <div><strong>Usage Desc: </strong> <span class="font-primary"><?php echo $retriveData['medi_usageDesc'] ?></span> </div>
                                                </li>
                                              <?php

                                              }






                                              ?>
                                            </ul>



                                          </div>
                                        </div>
                                      </div>
                                    <?php
                                      $i++;
                                    }



                                    ?>





                                  </div>

                                </div>


                              </div>
                            </div>
                          </div>
                        </div>


                        <div class="modal fade modal-bookmark" id="printModal" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Print preview</h5>
                                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body list-persons">
                                <div class="profile-mail pt-0" id="DivIdToPrint">
                                  <div class="media"><img class="img-100 img-fluid m-r-20 rounded-circle" id="updateimg" src="<?php echo $base_url ?>assets/images/user/2.png" alt="">
                                    <div class="media-body mt-0">
                                      <h5><span id="printname">Bucky </span><span id="printlast">Barnes</span></h5>
                                      <p id="printmail">barnes@gmail.com</p>
                                    </div>
                                  </div>
                                  <div class="email-general">
                                    <h6>General</h6>
                                    <p>Email Address: <span class="font-primary" id="mailadd">barnes@gmail.com </span></p>
                                  </div>
                                </div>
                                <button class="btn btn-secondary" id="btnPrint" type="button" onclick="printDiv();">Print</button>
                                <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Cancel</button>
                              </div>
                            </div>
                          </div>
                        </div>
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


</body>

</html>