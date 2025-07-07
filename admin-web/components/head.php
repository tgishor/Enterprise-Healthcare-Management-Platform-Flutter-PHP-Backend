  <?php
    session_start(); 

    $base_url = "http://localhost/finalproject/admin/";

    date_default_timezone_set("Asia/Colombo");
  ?>

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="a">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo $base_url ?>assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo $base_url ?>assets/images/favicon.png" type="image/x-icon">
    <title>GB Healthcare - Hospital Record Management System</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo $base_url ?>assets/css/font-awesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="<?php echo $base_url ?>assets/css/vendors/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="<?php echo $base_url ?>assets/css/vendors/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="<?php echo $base_url ?>assets/css/vendors/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="<?php echo $base_url ?>assets/css/vendors/feather-icon.css">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="<?php echo $base_url ?>assets/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $base_url ?>assets/css/vendors/animate.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $base_url ?>assets/css/vendors/chartist.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $base_url ?>assets/css/vendors/date-picker.css">

    <!-- Include Choices CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="<?php echo $base_url ?>assets/css/vendors/bootstrap.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="<?php echo $base_url ?>assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $base_url ?>assets/css/img-box.css">
    <link id="color" rel="stylesheet" href="<?php echo $base_url ?>assets/css/color-1.css" media="screen">
    <!-- Font Awesome css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Data Table css-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/date-1.1.2/fh-3.2.4/r-2.3.0/sc-2.0.7/sp-2.0.2/sl-1.4.0/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" />
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="<?php echo $base_url ?>assets/css/responsive.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">



    <style>
      .profile-greeting .card-body {
        padding: 51px 20px;
      }

      .page-wrapper .sidebar-main-title h6 {
        padding: 0;
        margin: 0;
      }

      .sub-btnsize button {
        font-size: 15px;
      }

      div.dataTables_wrapper div.dataTables_length select {
        padding: 0px 24px;
      }

      div.dataTables_wrapper div.dataTables_length label {
        padding-right: 25px;
      }

      .bg-wd-1 {
        color: #ffff;
        background-color: #F73164;
        font-weight: 500;
      }

      .bg-wd-2 {
        color: #ffff;
        background-color: #E35D6A;
        font-weight: 500;
      }

      .bg-wd-3 {
        color: #ffff;
        background-color: #9714F1;
        font-weight: 500;
      }

      .bg-wd-4 {
        color: #ffff;
        background: rgb(116, 103, 255);
        background: linear-gradient(110deg, rgba(116, 103, 255, 1) 0%, rgba(115, 102, 255, 0.794537798029368) 100%);
        font-weight: 500;
      }

      .image-cropper-roundedimage {
        width: 100px;
        height: 100px;
        position: relative;
        overflow: hidden;
        border-radius: 50%;
      }

      .image-cropper-roundedimage > img {
        display: inline;
        margin: 0 auto;
        height: 100%;
        width: auto;
      }
    </style>

  </head>