<!DOCTYPE html>
<html lang="en">

<?php include '../../components/head.php' ?>

<style>
    .logo-c-image.logo {
        position: relative;
        display: inline-block;
    }

    .logo-c-image img {
        border: 3px dashed #ffffff14;
        object-fit: cover;
        cursor: pointer;
        vertical-align: middle;
        max-width: 100%;
        height: auto;
    }

    .logo-c-image.logo label {
        position: absolute;
        cursor: pointer;
        height: 35px;
        width: 35px;
        border-radius: 50%;
        background: var(--background-color-4);
        display: flex;
        align-items: center;
        justify-content: center;
        top: 19px;
        right: 13px;
        border: 1px solid var(--color-border);
        transition: var(--transition);
    }

    .brows-file-wrapper input {
        display: none;
    }

    input {
        background: var(--background-color-4);
        border-radius: 5px;
        color: var(--color-white);
        font-size: 14px;
        padding: 10px 20px;
        border: 2px solid var(--color-border);
        transition: 0.3s;
        margin-top: 15px;
        height: 40px;
    }
</style>

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
                                <h3>Add New Admin</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php"> <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Admin</li>
                                    <li class="breadcrumb-item">Add Admin</li>
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


                                    <form method="POST" class="needs-validation" enctype="multipart/form-data">
                                        <div class="row g-3">

                                            <div class="col-12 d-flex justify-content-center">
                                                <div class="col-md-2">
                                                    <label class="form-label" for="validationCustom01">Admin Profile Image</label>
                                                    <div class="p-0">
                                                        <div class="logo-c-image logo p-0">
                                                            <img id="rbtinput1" src="../../assets/images/imageupload-preview.jpeg" alt="Profile-NFT">
                                                            <label for="fatima" title="No File Choosen">
                                                                <span class="text-center color-white"><i class="feather-edit"></i></span>
                                                            </label>
                                                        </div>
                                                        <div class="button-area">
                                                            <div class="brows-file-wrapper">
                                                                <!-- actual upload which is hidden -->
                                                                <input name="fileToUpload" id="fatima" type="file">
                                                                <!-- our custom upload button -->

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label" for="validationCustom01">Admin Name</label>
                                                <input name="adm_name" class="form-control" id="validationCustom01" type="text" placeholder="Admin Name" required="">
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">Please Add a Name</div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label" for="validationCustom01">Admin Contact No</label>
                                                <input name="adm_contactNo" class="form-control" id="validationCustom01" type="number" placeholder="Contact No" required="">
                                                <div class="valid-feedback">Looks good!</div>
                                            </div>


                                            <div class="col-md-6">
                                                <label class="form-label" for="validationCustom01">Admin Username</label>
                                                <input name="adm_username" class="form-control" id="validationCustom01" type="text" placeholder="Admin Username" required="">
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">Please Add a Username</div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label" for="validationCustom01">Admin Password</label>
                                                <input name="adm_password" class="form-control" id="validationCustom01" type="text" placeholder="Password" required="">
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">Please Add a Password</div>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-column align-items-start align-items-center sub-btnsize ">
                                            <button id="submit" class="mt-4 btn btn-success" name="submit" type="submit"><i class="fa fa-plus-square"></i> Add Admin</button>
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

    <script>
        $("#rbtinput1").click(function(e) {
            $("#fatima").click();
        });

        function rbtPreview() {
            const [file] = fatima.files
            if (file) {
                rbtinput1.src = URL.createObjectURL(file)
            }
        }
        $("#fatima").change(function() {
            rbtPreview(this);
        });
    </script>

</body>

</html>

<?php

if (isset($_POST['submit'])) {

    $target_dir = "../../uploads/admin/";
    $imageName = rand() . basename($_FILES["fileToUpload"]["name"]);
    $target_file = $target_dir . $imageName;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {


            include "../../connection/db.php";
            include "../../components/functions.php";

            $adm_name = $_POST['adm_name'];
            $adm_contact = $_POST['adm_contactNo'];
            $adm_username = $_POST['adm_username'];
            $adm_password = encryptMessage($_POST['adm_password']);

            $sql = "INSERT INTO `admin`( `adm_name`, `adm_contact`, `adm_username`, `adm_password`,`adm_img`) VALUES ('$adm_name','$adm_contact','$adm_username','$adm_password','$imageName')";

            $exec = mysqli_query($con, $sql);

            if ($exec) {
?>
                <script>
                    $.confirm({
                        icon: 'fa fa-check-circle ',
                        title: 'Admin Successfully',
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
                                    window.location.href = 'manage-admin.php';
                                }
                            },
                            again: {
                                text: 'Add Another Data',
                                btnClass: 'btn-blue',
                                keys: ['enter'],
                                action: function() {
                                    window.location.href = 'add-admin.php';
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
                        icon: 'fa fa-check-circle ',
                        title: 'Hospital Successfully',
                        content: 'Your Data is Inserted Successfully',
                        columnClass: 'col-md-4 col-md-offset-4',
                        draggable: false,
                        theme: 'modern',
                        buttons: {
                            again: {
                                text: 'Try Again',
                                btnClass: 'btn-blue',
                                keys: ['enter'],
                                action: function() {
                                    window.location.href = 'add-hospital.php';
                                }
                            }
                        }
                    });
                </script>
            <?php
            }
        } else {
            ?>
            <script>
                $.confirm({
                    icon: 'fa fa-exclamation-circle ',
                    title: 'Ooppss!! Error in Adding Admin',
                    content: 'Faced an issue in adding admin, Please Try Again',
                    columnClass: 'col-md-4 col-md-offset-4',
                    draggable: false,
                    type: 'red',
                    theme: 'modern',
                    buttons: {
                        again: {
                            text: 'Try Again',
                            btnClass: 'btn-red',
                            keys: ['enter'],
                            action: function() {
                                window.location.href = 'add-admin.php';
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