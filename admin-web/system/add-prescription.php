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
                <h3>Add New Prescription</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php"> <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Prescription</li>
                  <li class="breadcrumb-item">Add Prescription</li>
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


                  <form class="needs-validation" novalidate="">
                    <div class="row g-3">

                      <div class="col-md-12">
                        <label class="form-label" for="validationCustom01">Prescription Description</label>
                        <textarea rows="5" class="form-control" id="validationCustom01" type="text" placeholder="Information About the Precription" required=""></textarea>
                        <div class="valid-feedback">Looks good!</div>
                      </div>

                      <div class="col-md-4">
                        <label class="form-label" for="validationCustom01">Prescription Status</label>
                        <select class="form-select" id="validationCustom04" required="">
                          <option selected="" disabled="" value="">Choose...</option>
                          <option>Active</option>
                          <option>Not Active</option>
                        </select>
                        <div class="invalid-feedback">Please select a valid Status.</div>
                      </div>


                     ````````````````` SHOULD USE SELECT 2 ````````

                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom01">Patient NIC</label>
                        <input class="form-control" id="validationCustom01" type="text" placeholder="Patient NIC" required="">
                        <div class="valid-feedback">Looks good!</div>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom01">Patient Email</label>
                        <input class="form-control" id="validationCustom01" type="text" placeholder="Patient Email" required="">
                        <div class="valid-feedback">Looks good!</div>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom01">Patient DOB</label>
                        <input class="form-control" id="validationCustom01" type="date" required="">
                        <div class="valid-feedback">Looks good!</div>
                      </div>

                      <div class="col-12">
                        <div class="row">
                          <div class="col-6">
                            <div class="col-md-12">
                              <label class="form-label" for="validationCustom01">Patient Address</label>
                              <textarea rows="5" class="form-control" id="validationCustom01" type="date" placeholder="Patient Address" required=""></textarea>
                              <div class="valid-feedback">Looks good!</div>
                            </div>
                          </div>

                          <div class="col-6">
                            <div class="col-md-12">
                              <label class="form-label" for="validationCustom04">Gender</label>
                              <select class="form-select" id="validationCustom04" required="">
                                <option selected="" disabled="" value="">Choose...</option>
                                <option>Male</option>
                                <option>Female</option>
                              </select>
                              <div class="invalid-feedback">Please select a valid gender.</div>
                            </div>

                            <div class="col-md-12 mt-4">
                              <label class="form-label" for="validationCustom01">Patient Profile Pic</label>
                              <div>
                                <input class="form-control" type="file" aria-label="file example" required="">
                                <div class="invalid-feedback">No Image Selected</div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom04">Select the Gurdian</label>
                        <div class="row">
                          <div class="col-8" style="padding-right:0;">
                            <select class="form-select" id="validationCustom04" required="">
                              <option selected="" disabled="" value="">Choose...</option>
                              <option>Male</option>
                              <option>Female</option>
                            </select>
                            <div class="invalid-feedback">Please select a valid Gurdian.</div>
                          </div>
                          <div class="col-3">
                            <button class="btn btn-primary d-flex justify-content-center align-items-center"><i class="fa fa-plus"></i> ADD </button>
                          </div>
                        </div>

                      </div>

                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom01">Patient Contact No.</label>
                        <div class="col-12">
                          <div class="row">
                            <div class="col-8" style="padding-right:0;">
                              <input class="form-control" id="validationCustom01" placeholder="Contact Number" type="number" required="">
                              <div class="valid-feedback">Looks good!</div>
                              <div class="invalid-feedback">Please Enter the Phone Number</div>
                            </div>
                            <div class="col-4">
                              <button class="btn btn-primary d-flex justify-content-center align-items-center"><i class="fa fa-commenting-o mr-1"></i> SENT OTP </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="d-flex flex-column align-items-start align-items-center sub-btnsize ">
                      <button id="submit" class="mt-4 btn btn-success" type="submit"><i class="fa fa-plus-square"></i> Add Patient</button>
                      <button id="continue" class="mt-2 btn btn-warning" type="submit"><i class="fa fa-arrow-circle-right"></i> Continue with Appointment</button>
                    </div>
                  </form>

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



</body>

</html>