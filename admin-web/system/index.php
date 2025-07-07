<!DOCTYPE html>
<html lang="en">

<?php include '../components/head.php' ?>

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

    <?php include '../components/topbar.php' ?>

    <!-- Page Body Start-->
    <div class="page-body-wrapper">

      <?php include '../components/sidebar.php' ?>

      <div class="page-body">
        <div class="container-fluid">
          <div class="page-title">
            <div class="row">
              <div class="col-6">
                <h3>Dashboard</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.html"> <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Dashboard</li>
                </ol>
              </div>
            </div>
          </div>
        </div>

        <!-- Container-fluid starts-->
        <div class="container-fluid">
          <div class="row second-chart-list third-news-update">
            <div class="col-xl-4 col-lg-12 xl-50 morning-sec box-col-12">
              <div class="card o-hidden profile-greeting">
                <div class="card-body">
                  <div class="media">
                    <div class="badge-groups w-100">
                      <div class="badge f-12"><i class="me-1" data-feather="clock"></i><span id="txt"></span></div>
                      <div class="badge f-12"><i class="fa fa-spin fa-cog f-14"></i></div>
                    </div>
                  </div>
                  <div class="greeting-user text-center">
                    <div class="profile-vector"><img class="img-fluid" src="../assets/images/dashboard/welcome.png" alt=""></div>
                    <h4 class="f-w-600"><span id="greeting">Good Morning</span> <span class="right-circle"><i class="fa fa-check-circle f-14 middle"></i></span></h4>
                    <p><span> Today's appointments is 10 & the profit increase rate is 3.7 over the last 24 hours </span></p>
                    <div class="whatsnew-btn"><a class="btn btn-primary">Whats New !</a></div>
                    <div class="left-icon"><i class="fa fa-bell"> </i></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-4 xl-50 appointment-sec box-col-6">
              <div class="row">
                <div class="col-xl-12 appointment">
                  <div class="card">
                    <div class="card-header card-no-border">
                      <div class="header-top">
                        <h5 class="m-0">appointment</h5>
                        <div class="card-header-right-icon">
                          <div class="dropdown">
                            <button class="btn dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">Today</button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"><a class="dropdown-item" href="#">Today</a><a class="dropdown-item" href="#">Tomorrow</a><a class="dropdown-item" href="#">Yesterday</a></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-body pt-0">
                      <div class="appointment-table table-responsive">
                        <table class="table table-bordernone">
                          <tbody>
                            <tr>
                              <td><img class="img-fluid img-40 rounded-circle mb-3" src="../assets/images/appointment/app-ent.jpg" alt="Image description">
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
                              <td><img class="img-fluid img-40 rounded-circle" src="../assets/images/appointment/app-ent.jpg" alt="Image description">
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
                <div class="col-xl-12 alert-sec">
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
                          <h5>Dashboard</h5>
                          <p class="font-roboto">Overview of last month</p>
                        </div>
                        <div class="col-xl-12 p-0 left_side_earning">
                          <h5>Rs. 4055.56 </h5>
                          <p class="font-roboto">This Month Earning</p>
                        </div>
                        <div class="col-xl-12 p-0 left_side_earning">
                          <h5>Rs. 1004.11</h5>
                          <p class="font-roboto">This Month Profit</p>
                        </div>
                        <div class="col-xl-12 p-0 left_side_earning">
                          <h5>90%</h5>
                          <p class="font-roboto">New Appointments</p>
                        </div>
                        <div class="col-xl-12 p-0 left-btn"><a class="btn btn-gradient">Summary</a></div>
                      </div>
                    </div>
                    <div class="col-xl-9 p-0">
                      <div class="chart-right">
                        <div class="row m-0 p-tb">
                          <div class="col-xl-8 col-md-8 col-sm-8 col-12 p-0">
                            <div class="inner-top-left">
                              <ul class="d-flex list-unstyled">
                                <li>Daily</li>
                                <li class="active">Weekly</li>
                                <li>Monthly</li>
                                <li>Yearly</li>
                              </ul>
                            </div>
                          </div>
                          <div class="col-xl-4 col-md-4 col-sm-4 col-12 p-0 justify-content-end">
                            <div class="inner-top-right">
                              <ul class="d-flex list-unstyled justify-content-end">
                                <li>Online</li>
                                <li>Store</li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xl-12">
                            <div class="card-body p-0">
                              <div class="current-sale-container">
                                <div id="chart-currently"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row border-top m-0">
                        <div class="col-xl-4 ps-0 col-md-6 col-sm-6">
                          <div class="media p-0">
                            <div class="media-left"><i class="icofont icofont-crown"></i></div>
                            <div class="media-body">
                              <h6>Referral Earning</h6>
                              <p>Rs. 5,000.20</p>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-sm-6">
                          <div class="media p-0">
                            <div class="media-left bg-secondary"><i class="icofont icofont-heart-alt"></i></div>
                            <div class="media-body">
                              <h6>Patient Admissions</h6>
                              <p>1000 People</p>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-md-12 pe-0">
                          <div class="media p-0">
                            <div class="media-left"><i class="icofont icofont-cur-dollar"></i></div>
                            <div class="media-body">
                              <h6>Sales forcasting</h6>
                              <p>Rs. 9,478.50 </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-9 xl-100 chart_data_left box-col-12">
              <div class="card">
                <div class="card-body p-0">
                  <div class="row m-0 chart-main">
                    <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
                      <div class="media align-items-center">
                        <div class="hospital-small-chart">
                          <div class="small-bar">
                            <div class="small-chart flot-chart-container"></div>
                          </div>
                        </div>
                        <div class="media-body">
                          <div class="right-chart-content">
                            <h4>1001</h4><span>Purchase </span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
                      <div class="media align-items-center">
                        <div class="hospital-small-chart">
                          <div class="small-bar">
                            <div class="small-chart1 flot-chart-container"></div>
                          </div>
                        </div>
                        <div class="media-body">
                          <div class="right-chart-content">
                            <h4>1005</h4><span>Sales</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
                      <div class="media align-items-center">
                        <div class="hospital-small-chart">
                          <div class="small-bar">
                            <div class="small-chart2 flot-chart-container"></div>
                          </div>
                        </div>
                        <div class="media-body">
                          <div class="right-chart-content">
                            <h4>100</h4><span>Sales return</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
                      <div class="media border-none align-items-center">
                        <div class="hospital-small-chart">
                          <div class="small-bar">
                            <div class="small-chart3 flot-chart-container"></div>
                          </div>
                        </div>
                        <div class="media-body">
                          <div class="right-chart-content">
                            <h4>101</h4><span>Purchase ret</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 xl-50 chart_data_right box-col-12">
              <div class="card">
                <div class="card-body">
                  <div class="media align-items-center">
                    <div class="media-body right-chart-content">
                      <h4>Rs. 95,900<span class="new-box">Hot</span></h4><span>Purchase Order Value</span>
                    </div>
                    <div class="knob-block text-center">
                      <input class="knob1" data-width="10" data-height="70" data-thickness=".3" data-angleoffset="0" data-linecap="round" data-fgcolor="#7366ff" data-bgcolor="#eef5fb" value="60">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 xl-50 chart_data_right second d-none">
              <div class="card">
                <div class="card-body">
                  <div class="media align-items-center">
                    <div class="media-body right-chart-content">
                      <h4>Rs. 95,000<span class="new-box">New</span></h4><span>Product Order Value</span>
                    </div>
                    <div class="knob-block text-center">
                      <input class="knob1" data-width="50" data-height="70" data-thickness=".3" data-fgcolor="#7366ff" data-linecap="round" data-angleoffset="0" value="60">
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-4 xl-50 notification box-col-6">
              <div class="card">
                <div class="card-header card-no-border">
                  <div class="header-top">
                    <h5 class="m-0">notification</h5>
                    <div class="card-header-right-icon">
                      <div class="dropdown">
                        <button class="btn dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">Today</button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"><a class="dropdown-item" href="#">Today</a><a class="dropdown-item" href="#">Tomorrow</a><a class="dropdown-item" href="#">Yesterday </a></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body pt-0">
                  <div class="media">
                    <div class="media-body">
                      <p>20-04-2020 <span>10:10</span></p>
                      <h6>Updated Product<span class="dot-notification"></span></h6><span>Quisque a consequat ante sit amet magna...</span>
                    </div>
                  </div>
                  <div class="media">
                    <div class="media-body">
                      <p>20-04-2020<span class="ps-1">Today</span><span class="badge badge-secondary">New</span></p>
                      <h6>Tello just like your product<span class="dot-notification"></span></h6><span>Quisque a consequat ante sit amet magna... </span>
                    </div>
                  </div>
                  <div class="media">
                    <div class="media-body">
                      <div class="d-flex mb-3">
                        <div class="inner-img"><img class="img-fluid" src="../assets/images/notification/1.jpg" alt="Product-1"></div>
                        <div class="inner-img"><img class="img-fluid" src="../assets/images/notification/2.jpg" alt="Product-2"></div>
                      </div><span class="mt-3">Quisque a consequat ante sit amet magna...</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 xl-50 appointment box-col-6">
              <div class="card">
                <div class="card-header">
                  <div class="header-top">
                    <h5 class="m-0">Market Value</h5>
                    <div class="card-header-right-icon">
                      <div class="dropdown">
                        <button class="btn dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">Year</button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"><a class="dropdown-item" href="#">Year</a><a class="dropdown-item" href="#">Month</a><a class="dropdown-item" href="#">Day</a></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-Body">
                  <div class="radar-chart">
                    <div id="marketchart"> </div>
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

  <?php include '../components/scripts.php' ?>
  <script src="<?php echo $base_url ?>assets/js/dashboard/default.js"></script>

</body>

</html>