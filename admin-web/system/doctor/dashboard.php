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
                <h3>Doctor Dashboard</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.html"> <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Doctor</li>
                  <li class="breadcrumb-item">Dashboard</li>
                </ol>
              </div>
            </div>
          </div>
        </div>

        <!-- Container-fluid starts-->
        <div class="container-fluid">
          <div class="row second-chart-list third-news-update">



            <div class="col-xl-4 xl-50 appointment-sec box-col-6">

              <div class="col-xl-12 appointment" style="height: 100%; width: 100%;">
                <div class="card" style="height: 500px; width: 100%;">
                  <div class=" card-header card-no-border">
                    <div class="header-top">
                      <h5 class="m-0 d-flex align-items-center">appointment <span class="ml-2 badge badge-primary" style="margin-left: 10px; font-size:12px;">View All</span> </h5>
                      <div class="card-header-right-icon">
                        <div class="dropdown">
                          <button class="btn dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">Today</button>
                          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"><a class="dropdown-item" href="#">Today</a><a class="dropdown-item" href="#">Tomorrow</a><a class="dropdown-item" href="#">Yesterday</a></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-body pt-0" style="overflow-y: scroll;">
                    <div class=" appointment-table table-responsive">
                      <table class="table table-bordernone">
                        <tbody>

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
                            <td><img class="img-fluid img-40 rounded-circle mb-3" src="../../assets/images/appointment/app-ent.jpg" alt="Image description">
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
                            <td><img class="img-fluid img-40 rounded-circle mb-3" src="../../assets/images/appointment/app-ent.jpg" alt="Image description">
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
                            <td><img class="img-fluid img-40 rounded-circle mb-3" src="../../assets/images/appointment/app-ent.jpg" alt="Image description">
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
                          <tr>
                            <td><img class="img-fluid img-40 rounded-circle mb-3" src="../../assets/images/appointment/app-ent.jpg" alt="Image description">
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
                          <tr>
                            <td><img class="img-fluid img-40 rounded-circle mb-3" src="../../assets/images/appointment/app-ent.jpg" alt="Image description">
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
                  </div>
                </div>
              </div>


            </div>

            <div class="col-xl-6 alert-sec">
              <div class="card bg-img">
                <div class="card-header">
                  <div class="header-top">
                    <h5 class="m-0">Alert </h5>
                    <div class="dot-right-icon"><i class="fa fa-ellipsis-h"></i></div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="body-bottom">
                    <h6> Hospital Anniversary Party </h6><span class="font-roboto">There will be a party hosted for all staffs of the hospital for
                      celebrating successful 5th Anniversary of the Hospital</span>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-6">
                  <div class="bg-wd-1 p-4 rounded-4 d-flex flex-column align-items-center justify-content-center">
                    <img src="<?php echo $base_url ?>assets/images/components/medicalrecord.png" class="img-fluid" alt="">
                    <p style="font-size: 15px;" class="m-0 text-center">Create Medical Record</p>
                  </div>

                  <div class="bg-wd-2 p-4 rounded-4 d-flex flex-column align-items-center justify-content-center mt-3 ">
                    <img src="<?php echo $base_url ?>assets/images/components/medicalrecord.png" class="img-fluid" alt="">
                    <p style="font-size: 15px;" class="m-0 text-center">Update Medical Record</p>
                  </div>
                </div>

                <div class="col-6">
                  <div class="bg-wd-3 p-4 rounded-4 d-flex flex-column align-items-center justify-content-center" style="height: 100%; width: 100%;">
                    <img src="<?php echo $base_url ?>assets/images/components/health-calendar.png" class="img-fluid" alt="">
                    <p style="font-size: 16px;" class="m-0 text-center">Schedule Work Time</p>
                  </div>
                </div>


              </div>


            </div>

            <div class="col-xl-8 xl-100 dashboard-sec box-col-12">
              <div class="card earning-card">
                <div class="card-body p-0">
                  <div class="row m-0">
                    <div class="col-xl-3 earning-content p-0">
                      <div class="row m-0 chart-left">
                        <div class="col-xl-12 p-0 left_side_earning">
                          <h5>Recently Diagnosed Patients</h5>
                          <p class="font-roboto">List of Patients you Diagnosed</p>
                        </div>
                        <div class="col-xl-12 p-0 left-btn"><a class="btn btn-gradient">View All</a></div>

                        <div class="col-12">
                          <table id="myTable" class="display" style="width:100%">
                            <thead>
                              <tr>
                                <th>Patient</th>
                                <th>Appoinment Date</th>
                                <th>Digonised Disease</th>
                                <th>More</th>
                              </tr>
                            </thead>

                            <tbody>
                              <tr>
                                <td>
                                  <div class="d-flex flex-row align-items-center">
                                    <img width="60px" class="rounded-circle" src="<?php echo $base_url ?>/assets/images/user/1.jpg" alt="">
                                    <div style="margin-left:10px">
                                      <p class="m-0 fw-bold">Patient Name Here</p>
                                      <p class="m-0">Gender</p>
                                      <p>NIC</p>
                                    </div>
                                  </div>
                                </td>
                                <td>Appoinment Date</td>
                                <td>Digonised Disease</td>
                                <td>
                                  <a href="" class="btn btn-success"><i class="fa fa-eye"></i></a>
                                </td>
                              </tr>
                            </tbody>


                          </table>
                        </div>
                      </div>

                    </div>

                    <div class="col-xl-3 earning-content p-0">

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
    $('#myTable').DataTable({
      searching: false,
      paging: false,
      info: false
    });
  </script>


</body>

</html>