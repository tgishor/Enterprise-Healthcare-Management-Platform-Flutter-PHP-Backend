<?php

session_start();

if (isset($_SESSION["doctorID"])) {
?>
  <script>
    window.location.href = 'doctor-dashboard.php'
  </script>
<?php
} else if (isset($_SESSION["adminID"])) {
?>
  <script>
    window.location.href = 'index.php'
  </script>
<?php
} else if (isset($_SESSION["staffID"])) {
  if ($_SESSION['staffType'] == "Inventory Clerk") {
    $staff_redirect = "inventory-dashboard.php";
  } else if ($_SESSION['staffType'] == "Receptionist") {
    $staff_redirect = "reception-dashboard.php";
  }
?>
  <script>
    window.location.href = '<?php echo $staff_redirect ?>'
  </script>
<?php
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
  <meta name="keywords" content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
  <meta name="author" content="pixelstrap">
  <link rel="icon" href="../../assets/images/favicon.png" type="image/x-icon">
  <link rel="shortcut icon" href="../../assets/images/favicon.png" type="image/x-icon">
  <title>GB Health Care - Admin Portal Login</title>
  <!-- Google font-->
  <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../../assets/css/font-awesome.css">
  <!-- ico-font-->
  <link rel="stylesheet" type="text/css" href="../../assets/css/vendors/icofont.css">
  <!-- Themify icon-->
  <link rel="stylesheet" type="text/css" href="../../assets/css/vendors/themify.css">
  <!-- Flag icon-->
  <link rel="stylesheet" type="text/css" href="../../assets/css/vendors/flag-icon.css">
  <!-- Feather icon-->
  <link rel="stylesheet" type="text/css" href="../../assets/css/vendors/feather-icon.css">
  <!-- Plugins css start-->
  <!-- Plugins css Ends-->
  <!-- Bootstrap css-->
  <link rel="stylesheet" type="text/css" href="../../assets/css/vendors/bootstrap.css">
  <!--JQuery Confirm-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  <!-- App css-->
  <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">
  <link id="color" rel="stylesheet" href="../../assets/css/color-1.css" media="screen">
  <!-- Responsive css-->
  <link rel="stylesheet" type="text/css" href="../../assets/css/responsive.css">

  <style>
    /* MAIN */
    /* =============================================== */
    .rad-label {
      display: flex;
      align-items: center;

      border-radius: 100px;
      margin: 10px 0;

      cursor: pointer;
      transition: .3s;
    }

    .rad-label:hover,
    .rad-label:focus-within {
      background: hsla(0, 0%, 80%, .14);
    }

    .rad-input {
      position: absolute;
      left: 0;
      top: 0;
      width: 1px;
      height: 1px;
      opacity: 0;
      z-index: -1;
    }

    .rad-design {
      width: 22px;
      height: 22px;
      border-radius: 100px;

      background: linear-gradient(to right bottom, hsl(154, 97%, 62%), hsl(225, 97%, 62%));
      position: relative;
    }

    .rad-design::before {
      content: '';

      display: inline-block;
      width: inherit;
      height: inherit;
      border-radius: inherit;

      background: hsl(0, 0%, 90%);
      transform: scale(1.1);
      transition: .3s;
    }

    .rad-input:checked+.rad-design::before {
      transform: scale(0);
    }

    .rad-text {
      color: hsl(0, 0%, 60%);
      margin-left: 8px;
      letter-spacing: 3px;
      text-transform: uppercase;
      font-size: 12px;
      font-weight: 900;

      transition: .3s;
    }

    .rad-input:checked~.rad-text {
      color: hsl(0, 0%, 40%);
    }


    /* ABS */
    /* ====================================================== */
    .abs-site-link {
      position: fixed;
      bottom: 40px;
      left: 20px;
      color: hsla(0, 0%, 0%, .5);
      font-size: 16px;
    }
  </style>
</head>

<body>
  <!-- login page start-->
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-7"><img class="bg-img-cover bg-center" src="../../assets/images/login/2.jpg" alt="looginpage"></div>
      <div class="col-xl-5 p-0">
        <div class="login-card">
          <div>
            <div><a class="logo text-start" href="#"><img class="img-fluid for-light" src="../../assets/images/logo/logo-final.png" width="200px" alt="looginpage"><img class="img-fluid for-dark" width="200px" src="../../assets/images/logo/logo-final.png" alt="looginpage"></a></div>
            <div class="login-main">
              <form method="POST" class="theme-form">
                <h4>Sign in to account</h4>
                <p>Enter your username & password to login</p>
                <div class="form-group">
                  <label class="col-form-label">Username</label>
                  <input name="username" class="form-control" type="email" required="" placeholder="Test@gmail.com">
                </div>
                <div class="form-group">
                  <label class="col-form-label">Password</label>
                  <div class="form-input position-relative">
                    <input class="form-control" type="password" name="pass-field" required="" placeholder="*********">
                    <div class="show-hide"><span class="show"> </span></div>
                  </div>
                </div>

                <div class="col-12 mt-4">
                  <div class="row">
                    <div class="col-4">
                      <label class="rad-label">
                        <input value="admin" type="radio" class="rad-input" name="usertype" checked>
                        <div class="rad-design"></div>
                        <div class="rad-text">Admin</div>
                      </label>
                    </div>
                    <div class="col-4">
                      <label class="rad-label">
                        <input value="staff" type="radio" class="rad-input" name="usertype">
                        <div class="rad-design"></div>
                        <div class="rad-text">Staff</div>
                      </label>
                    </div>
                    <div class="col-4">
                      <label class="rad-label">
                        <input value="doctor" type="radio" class="rad-input" name="usertype">
                        <div class="rad-design"></div>
                        <div class="rad-text">Doctor</div>
                      </label>
                    </div>
                  </div>
                </div>


                <div class="form-group mb-0 mt-4">

                  <button name="submit" class="btn btn-primary w-100" type="submit">Sign in</button>

                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- latest jquery-->
    <script src="../../assets/js/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap js-->
    <script src="../../assets/js/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- feather icon js-->
    <script src="../../assets/js/icons/feather-icon/feather.min.js"></script>
    <script src="../../assets/js/icons/feather-icon/feather-icon.js"></script>
    <!-- scrollbar js-->

    <!-- Sidebar jquery-->
    <script src="../../assets/js/config.js"></script>
    <!-- Plugins JS start-->
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="../../assets/js/script.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <!-- login js-->
    <!-- Plugin used-->
  </div>
</body>

</html>

<?php

include '../../connection/db.php';
include '../../components/functions.php';

if (isset($_POST['submit'])) {

  if (isset($_SESSION["adminID"]) || isset($_SESSION["staffID"]) || isset($_SESSION["doctorID"])) {
    session_destroy();
  }
  $username = $_POST['username'];
  $password = encryptMessage($_POST['pass-field']);

  if ($_POST['usertype'] == "admin") {
    $sql_checkAdmin = "SELECT * FROM admin WHERE adm_username='$username' AND adm_password='$password'";
    $exec_checkAdmin = mysqli_query($con, $sql_checkAdmin);

    if (mysqli_num_rows($exec_checkAdmin) == 1) {
      while ($row = mysqli_fetch_array($exec_checkAdmin)) {
        $_SESSION["adminID"] = $row['adm_id'];
      }
?>
      <script>
        $.confirm({
          icon: 'fa fa-check-circle',
          title: 'Admin Login Successful',
          content: 'Your Login is Successfully... Continue with the System',
          columnClass: 'col-md-4 col-md-offset-4',
          autoClose: 'again|9000',
          draggable: false,
          theme: 'modern',
          buttons: {
            again: {
              text: 'Continue to System',
              btnClass: 'btn-success',
              keys: ['enter'],
              action: function() {
                window.location.href = 'index.php';
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
          icon: 'fa fa-exclamation-triangle',
          title: 'Ooppss!! Error in Login into Account',
          content: 'Incorrect Username or Password, So Please Try Again',
          columnClass: 'col-md-4 col-md-offset-4',
          draggable: false,
          theme: 'modern',
          buttons: {
            again: {
              text: 'Try Again',
              btnClass: 'btn-red',
              keys: ['enter'],
              action: function() {
                window.location.href = 'login.php';
              }
            }
          }
        });
      </script>
    <?php
    }
  } else if ($_POST['usertype'] == "staff") {
    $sql_checkStaff = "SELECT `staff`.*, `stafftype`.*
                        FROM `staff` 
                        INNER JOIN `stafftype` ON `staff`.`staffType_id_fk` = `stafftype`.`staffType_id`
                        WHERE staff_username= '$username' AND staff_password='$password'";

    $exec_checkStaff = mysqli_query($con, $sql_checkStaff);

    if (mysqli_num_rows($exec_checkStaff) == 1) {
      while ($row = mysqli_fetch_array($exec_checkStaff)) {
        $_SESSION["staffID"] = $row['staff_id'];
        $_SESSION["staffType"] = $row['staffType'];

        if ($row['staffType'] == "Inventory Clerk") {
          $staff_redirect = "inventory-dashboard.php";
        } else if ($row['staffType'] == "Receptionist") {
          $staff_redirect = "reception-dashboard.php";
        }
      }
    ?>
      <script>
        $.confirm({
          icon: 'fa fa-check-circle',
          title: 'Staff Login Successful',
          content: 'Your Login is Successfully... Continue with the System',
          columnClass: 'col-md-4 col-md-offset-4',
          autoClose: 'again|9000',
          draggable: false,
          theme: 'modern',
          buttons: {
            again: {
              text: 'Continue to System',
              btnClass: 'btn-success',
              keys: ['enter'],
              action: function() {
                window.location.href = '<?php echo $staff_redirect ?>';
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
          icon: 'fa fa-exclamation-triangle',
          title: 'Ooppss!! Error in Login into Account',
          content: 'Incorrect Username or Password, So Please Try Again',
          columnClass: 'col-md-4 col-md-offset-4',
          draggable: false,
          theme: 'modern',
          buttons: {
            again: {
              text: 'Try Again',
              btnClass: 'btn-red',
              keys: ['enter'],
              action: function() {
                window.location.href = 'login.php';
              }
            }
          }
        });
      </script>
    <?php
    }
  } else if ($_POST['usertype'] == "doctor") {
    $sql_checkStaff = "SELECT * FROM doctor WHERE doc_username= '$username' AND doc_password='$password'";

    $exec_checkStaff = mysqli_query($con, $sql_checkStaff);

    if (mysqli_num_rows($exec_checkStaff) == 1) {
      while ($row = mysqli_fetch_array($exec_checkStaff)) {
        $_SESSION["doctorID"] = $row['doc_id'];
      }
    ?>
      <script>
        $.confirm({
          icon: 'fa fa-check-circle',
          title: 'Doctor Login Successful',
          content: 'Your Login is Successfully... Continue with the System',
          columnClass: 'col-md-4 col-md-offset-4',
          autoClose: 'again|9000',
          draggable: false,
          theme: 'modern',
          buttons: {
            again: {
              text: 'Continue to System',
              btnClass: 'btn-success',
              keys: ['enter'],
              action: function() {
                window.location.href = 'doctor-dashboard.php';
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
          icon: 'fa fa-exclamation-triangle',
          title: 'Ooppss!! Error in Login into Account',
          content: 'Incorrect Username or Password, So Please Try Again',
          columnClass: 'col-md-4 col-md-offset-4',
          draggable: false,
          theme: 'modern',
          buttons: {
            again: {
              text: 'Try Again',
              btnClass: 'btn-red',
              keys: ['enter'],
              action: function() {
                window.location.href = 'login.php';
              }
            }
          }
        });
      </script>
<?php
    }
  }
}


?>