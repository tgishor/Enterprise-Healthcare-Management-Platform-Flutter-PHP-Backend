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
                <h3>Add New Gurdian</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php"> <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Gurdian</li>
                  <li class="breadcrumb-item">Add Gurdian</li>
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

                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom01">Gurdian Name</label>
                        <input name="gur_name" class="form-control" id="validationCustom01" type="text" placeholder="Name" required="">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please Add a Name</div>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom01">Gurdian Phone No. </label>
                        <input name="gur_phone" class="form-control" id="validationCustom01" type="number" placeholder="Phone Number" required="">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please Enter a Number</div>
                      </div>

                      <div class="col-12">
                        <div class="col-md-12">
                          <label class="form-label" for="validationCustom01">Gurdian Address</label>
                          <textarea name="gur_desc" rows="5" class="form-control" id="validationCustom01" type="date" placeholder="Eg. Admitted the Patient in the Hospital, How is the gurdian Related to the Person" required=""></textarea>
                          <div class="valid-feedback">Looks good!</div>
                          <div class="invalid-feedback">Please Enter a Description</div>
                        </div>
                      </div>

                    </div>

                    <div class="d-flex flex-column align-items-start align-items-center sub-btnsize ">
                      <button id="submit" class="mt-4 btn btn-success" type="submit"><i class="fa fa-plus-square"></i> Add Gurdian</button>
                      <button id="continue" class="mt-2 btn btn-warning" type="submit"><i class="fa fa-arrow-circle-right"></i> Continue with Add Patient</button>
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