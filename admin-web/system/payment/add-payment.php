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
                <h3>Make a New Payment</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php"> <i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Payment</li>
                  <li class="breadcrumb-item">Add Payment</li>
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
                  <form method="POST" class="needs-validation" novalidate="">
                    <div class="row g-3">

                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom04">Booking ID</label>
                        <select name="booking" class="form-select" id="validationCustom04" required="">


                          <?php

                          include '../../connection/db.php';

                          $sql = "SELECT `booking`.*, `patient`.*
                                  FROM `booking` 
                                  INNER JOIN `patient` ON `booking`.`p_id_fk` = `patient`.`p_id` ";

                          if (isset($_GET['book_id'])) {
                            $bookingID = $_GET['book_id'];
                            $sql .= " WHERE `booking`.`book_id` =  $bookingID";
                          } else {
                          ?>
                            <option selected disabled="" value="">Choose by Customer Name - Booking ID</option>
                          <?php
                          }

                          $exec = mysqli_query($con, $sql);

                          while ($row = mysqli_fetch_array($exec)) {
                          ?>
                            <option value="<?php echo $row['book_id'] ?>"><?php echo $row['book_id'] . " | " . $row['p_name'] . " | " . $row['p_nic']  ?></option>
                          <?php
                          }
                          ?>

                        </select>
                        <div class="invalid-feedback">Please select a valid booking id.</div>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label">Payment Amount</label>
                        <div class="input-group mb-3"><span class="input-group-text">Rs. </span>
                          <input name="pay_amount" id="validationCustom01" class="form-control" type="number" aria-label="Amount (to the nearest dollar)" required=""><span class="input-group-text">.00</span>
                          <div class="valid-feedback">Looks good!</div>
                          <div class="invalid-feedback">Please Add a Amount</div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label" for="validationCustom04">Payment Type</label>
                        <select name="pay_type" class="form-select" id="validationCustom04" required="">
                          <option selected="" disabled="" value="">Choose a Payment Type...</option>
                          <?php
                          include '../../connection/db.php';
                          $sql_paymentType = "SELECT * FROM `paymenttype`";

                          $exec_paymentType = mysqli_query($con, $sql_paymentType);

                          while ($row = mysqli_fetch_array($exec_paymentType)) {
                          ?>
                            <option value="<?php echo $row['pType_id'] ?>"><?php echo $row['pType_name'] ?></option>
                          <?php
                          }

                          ?>
                        </select>
                        <div class="invalid-feedback">Please select a valid payment type.</div>
                      </div>

                    </div>

                    <div class="d-flex flex-column align-items-start align-items-center sub-btnsize ">
                      <button name="submit" id="submit" class="mt-4 btn btn-success" type="submit"><i class="fa fa-plus-square"></i> Add Payment</button>
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

  <?php include '../../components/scripts.php' ?>



</body>

</html>


<?php

if (isset($_POST['submit'])) {

  $bookID = $_POST['booking'];
  $pay_amt = $_POST['pay_amount'];
  $payType = $_POST['pay_type'];

  $sql_payment = "INSERT INTO payment (pay_amount, pay_typ_fk, book_id_fk) VALUES ('$pay_amt', '$payType', '$bookID') ";
  echo $sql_payment;

  $exec_payment = mysqli_query($con, $sql_payment);

  if ($exec_payment) {
?>
    <script>
      $.confirm({
        icon: 'fa fa-check-circle ',
        title: 'Payment Successfully',
        content: 'Your payement is made successfully',
        columnClass: 'col-md-4 col-md-offset-4',
        draggable: false,
        theme: 'modern',
        buttons: {
          confirm: {
            text: 'Back to View',
            btnClass: 'btn-blue',
            keys: ['shift'],
            action: function() {
              window.location.href = 'add-payment.php';
            }
          },
          again: {
            text: 'Add Another Data',
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
  } else {
  ?>
    <script>
      $.confirm({
        icon: 'fa fa-exclamation-circle ',
        title: 'Ooppss!! Error in Making the Payment ',
        content: 'Faced an issue in adding the payment details, Please Try Again',
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
              window.location.href = 'add-payment.php';
            }
          }
        }
      });
    </script>
<?php
  }
}

?>