<!DOCTYPE html>
<html lang="en">

<?php

include '../../components/head.php';
$staffID = $_GET['id'];
?>


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
                                <h3>Update Staff</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php"> <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Staff</li>
                                    <li class="breadcrumb-item">Update Staff</li>
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

                                    <?php
                                    include '../../connection/db.php';

                                    $sql = "SELECT * FROM staff WHERE staff_id = '$staffID' ";
                                    $exec = mysqli_query($con, $sql);
                                    while ($row = mysqli_fetch_array($exec)) {
                                        $staffName = $row['staff_name'];
                                        $staffPic = $row['staff_img'];
                                        $staffUsername = $row['staff_username'];
                                        $staffPassword = $row['staff_password'];
                                        $staffType = $row['staffType_id_fk'];
                                    }
                                    ?>

                                    <form method="POST" class="needs-validation" enctype="multipart/form-data">
                                        <div class="row g-3">

                                            <div class="col-12 d-flex justify-content-center">
                                                <div class="col-md-2">
                                                    <label class="form-label" for="validationCustom01">Staff Profile Image</label>
                                                    <div class="p-0">
                                                        <div class="logo-c-image logo p-0">
                                                            <img id="rbtinput1" src="../../uploads/staff/<?php echo $staffPic?>" alt="Profile-NFT">
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
                                                <label class="form-label" for="validationCustom01">Staff Name</label>
                                                <input name="staff_name" value="<?php echo $staffName ?>" class="form-control" id="validationCustom01" type="text" placeholder="Staff Name" required="">
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">Please Update Name</div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label" for="validationCustom01">Staff Username</label>
                                                <input name="staff_username" value="<?php echo $staffUsername ?>" class="form-control" id="validationCustom01" type="text" placeholder="Staff Username" required="">
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">Please Update Password</div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label" for="validationCustom01">Staff Password</label>
                                                <input name="staff_password" class="form-control m-0" id="validationCustom01" type="password" placeholder="Staff password" required="">
                                                <div class="valid-feedback">Looks good!</div>
                                            </div>
                                    
                                            <div class="col-md-6">
                                            <label class="form-label" for="validationCustom04">Staff Type</label>
                                            <select name="stafftype"  class="form-select" id="validationCustom04" required="">
                                            <option selected="" disabled="" value="<?php echo $staffType?>">Choose a Staff Type...</option>
                                            <?php
                                            include "../../connection/db.php";
                                            $sql = "SELECT * FROM stafftype";
                                            $exec = mysqli_query($con, $sql);
                                            while ($row = mysqli_fetch_array($exec)) {
                                            ?>
                                                <option value="<?php echo $row['staffType_id'] ?> "><?php echo $row['staffType'] ?></option>
                                            <?php
                                            }
                                            ?>
                                            </select>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-column align-items-start align-items-center sub-btnsize ">
                                            <button id="submit" class="mt-4 btn btn-success" name="submit" type="submit"><i class="fa fa-pencil-square-o"></i> Update Staff</button>
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

    $imageUploaded = false;

    if ($_FILES["fileToUpload"]["name"] != null) {

        $target_dir = "../../uploads/staff/";
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

                $imageDone = true;

                $staffPic = $imageName;

            ?>
                <script>
                    alert("Image is Selected and Uploaded")
                </script>
            <?php

            } else {
            ?>
                <script>
                    $.confirm({
                        icon: 'fa fa-exclamation-circle ',
                        title: 'Ooppss!! Error in Uploading Image',
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

    include "../../connection/db.php";
    include "../../components/functions.php";

    $staff_name = $_POST['staff_name'];
    $staff_username = $_POST['staff_username'];
    $stafftype = $_POST['staffType_id_fk'];
    $staff_password = encryptMessage($_POST['staff_password']);

    $sql = "UPDATE `staff` SET `staff_name`='$staff_name',`staffType_id_fk`='$staffType',`staff_username`='$staff_username',`staff_password`='$staff_password',`staff_img`='$staffPic' WHERE `staff_id`= '$staffID' ";
    echo $sql;
    $exec = mysqli_query($con, $sql);

    if ($exec) {
        ?>
        <script>
            $.confirm({
                icon: 'fa fa-check-circle ',
                title: 'Staff Updated Successfully',
                content: 'Your Data is Updated Successfully',
                columnClass: 'col-md-4 col-md-offset-4',
                draggable: false,
                theme: 'modern',
                buttons: {
                    confirm: {
                        text: 'Back to View',
                        btnClass: 'btn-blue',
                        keys: ['enter'],
                        action: function() {
                            window.location.href = 'manage-generalstaff.php';
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
                title: 'Ooppss!! Error in Updating Staff',
                content: 'Faced an issue in Updating Staff, Please Try Again',
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
                            window.location.href = 'add-generalstaff.php';
                        }
                    }
                }
            });
        </script>
<?php
    }
}
?>