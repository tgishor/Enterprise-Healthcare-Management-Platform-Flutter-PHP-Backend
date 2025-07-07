<!DOCTYPE html>
<html lang="en">

<?php

include '../../components/head.php';

$medi_id = $_GET['upd_id']

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
                                <h3>Update New Medicine</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php"> <i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Medicine</li>
                                    <li class="breadcrumb-item">Update Medicine</li>
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

                                    $medi_id = $_GET['upd_id'];

                                    $sql = "SELECT `medicine`.*, `drugtype`.*
                                            FROM `medicine` 
                                            INNER JOIN `drugtype` ON `medicine`.`dType_id_fk` = `drugtype`.`dType_id` WHERE medi_id = '$medi_id' ";

                                    $exec = mysqli_query($con, $sql);

                                    while ($row = mysqli_fetch_array($exec)) {
                                        $medi_name = $row['medi_name'];
                                        $medi_usageDesc = $row['medi_usageDesc'];
                                        $medi_pillCode = $row['medi_pillCode'];
                                        $medi_frontImg = $row['medi_frontImg'];
                                        $medi_backImg = $row['medi_backImg'];
                                        $dType_id_fk = $row['dType_id_fk'];
                                        $dType = $row['dType_name'];
                                    }
                                    ?>

                                    <form method="POST" class="needs-validation" novalidate="" enctype="multipart/form-data">
                                        <div class="row g-3">

                                            <div class="col-12">
                                                <div class="row">

                                                    <div class="col-6">
                                                        <label class="form-label" for="validationCustom01">Select a New Medicine Front Image to Update</label>
                                                        <div class="p-0">
                                                            <div class="logo-c-image logo p-0">
                                                                <img id="frontImageSeletor" src="../../uploads/medicine/frontimage/<?php echo $medi_frontImg ?>" width=" 40%" alt="Profile-NFT">
                                                                <label for="fatima" title="No File Choosen">
                                                                    <span class="text-center color-white"><i class="feather-edit"></i></span>
                                                                </label>
                                                            </div>
                                                            <div class="button-area">
                                                                <div class="brows-file-wrapper">
                                                                    <!-- actual upload which is hidden -->
                                                                    <input name="frontImage" id="fatima" type="file">
                                                                    <!-- our custom upload button -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <label class="form-label" for="validationCustom01">Select a New Medicine Back Image to Update</label>
                                                        <div class="p-0">
                                                            <div class="logo-c-image logo p-0">
                                                                <img id="backImageSelector" src="../../uploads/medicine/backimage/<?php echo $medi_backImg ?>" width="40%" alt="Profile-NFT">
                                                                <label for="backimg" title="No File Choosen">
                                                                    <span class="text-center color-white"><i class="feather-edit"></i></span>
                                                                </label>
                                                            </div>
                                                            <div class="button-area">
                                                                <div class="brows-file-wrapper">
                                                                    <!-- actual upload which is hidden -->
                                                                    <input name="backImage" id="backimg" type="file">
                                                                    <!-- our custom upload button -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label" for="validationCustom01">Medicine Name</label>
                                                <input name="medi_name" value="<?php echo $medi_name ?>" class="form-control" id="validationCustom01" type="text" placeholder="Name" required="">
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">Please Add a Name</div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label" for="validationCustom01">Medicine Pill Code</label>
                                                <input name="medi_pillCode" value="<?php echo $medi_pillCode ?>" class="form-control" id="validationCustom01" type="text" placeholder="Pill Code" required="">
                                                <div class="valid-feedback">Looks good!</div>
                                                <div class="invalid-feedback">Please Add a Pill Code</div>
                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label" for="validationCustom01">Medicine Usage Description</label>
                                                <textarea rows="3" name="medi_usageDesc" class="form-control" id="validationCustom01" type="date" placeholder="Medicine Description" required=""><?php echo $medi_usageDesc ?></textarea>
                                                <div class="valid-feedback">Looks good!</div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label" for="validationCustom04">Drug Type</label>
                                                <select name="dType" class="form-select" id="validationCustom04" required="">
                                                    <option selected="" value="<?php echo $dType_id_fk ?>"><?php echo $dType ?></option>
                                                    <?php
                                                    include "../../connection/db.php";
                                                    $sql = "SELECT * FROM drugtype WHERE dType_id != $dType_id_fk";
                                                    $exec = mysqli_query($con, $sql);
                                                    while ($row = mysqli_fetch_array($exec)) {
                                                    ?>
                                                        <option value="<?php echo $row['dType_id'] ?> "><?php echo $row['dType_name'] ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="d-flex flex-column align-items-start align-items-center sub-btnsize ">
                                                <button name="submit" id="submit" class="mt-4 btn btn-success" type="submit"><i class="fa fa-pencil-square-o"></i> Update Medicine</button>
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
        $("#frontImageSeletor").click(function(e) {
            $("#fatima").click();
        });

        function rbtPreview() {
            const [file] = fatima.files
            if (file) {
                frontImageSeletor.src = URL.createObjectURL(file)
            }
        }
        $("#fatima").change(function() {
            rbtPreview(this);
        });
    </script>


    <script>
        $("#backImageSelector").click(function(e) {
            $("#backimg").click();
        });

        function rbtPreview1() {
            const [file] = backimg.files
            if (file) {
                backImageSelector.src = URL.createObjectURL(file)
            }
        }
        $("#backimg").change(function() {
            rbtPreview1(this);
        });
    </script>


</body>

</html>

<?php
include "../../connection/db.php";

if (isset($_POST['submit'])) {

    $errorMessage = "";
    $img1UploadStatus = false;
    $img2UploadStatus = false;

    if ($_FILES["frontImage"]["name"] != null) {

        $target_dir = "../../uploads/medicine/frontimage/";
        $imageName1 = rand() . basename($_FILES["frontImage"]["name"]);
        $target_file = $target_dir . $imageName1;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["frontImage"]["tmp_name"]);

        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $errorMessage .= " | File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $errorMessage .= " | Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["frontImage"]["size"] > 9000000) {
            $errorMessage .= " | Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            $errorMessage .= " | Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $errorMessage .= " | Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["frontImage"]["tmp_name"], $target_file)) {

                $img1UploadStatus = true;

                $medi_frontImg = $imageName1;

            } else {
?>
                <script>
                    $.confirm({
                        icon: 'fa fa-exclamation-circle ',
                        title: 'Ooppss!! Error in Uploading Front Image',
                        content: '<?php echo $errorMessage ?>',
                        columnClass: 'col-md-4 col-md-offset-4',
                        type: 'red',
                        draggable: false,
                        buttons: {
                            again: {
                                text: 'Try Again',
                                btnClass: 'btn-red',
                                keys: ['enter'],
                                action: function() {
                                    window.location.href = 'add-medicine.php';
                                }
                            }
                        }
                    });
                </script>
            <?php
            }
        }
    }

    // Image Upload Code for Image One 

    if ($_FILES["backImage"]["name"] != null) {
        // Image Upload Code for Image One 
        $target_dir = "../../uploads/medicine/backimage/";
        $imageName2 = rand() . basename($_FILES["backImage"]["name"]);
        $target_file = $target_dir . $imageName2;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["backImage"]["tmp_name"]);

        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $errorMessage .= " | File is not an image.";
            $uploadOk = 0;
        }

        if (file_exists($target_file)) {
            $errorMessage .= " | Sorry, file already exists.";
            $uploadOk = 0;
        }

        if ($_FILES["backImage"]["size"] > 9000000) {
            $errorMessage .= " | Sorry, your file is too large.";
            $uploadOk = 0;
        }

        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            $errorMessage .= " | Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            $errorMessage .= " | Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["backImage"]["tmp_name"], $target_file)) {
                $img2UploadStatus = true;
                $medi_backImg = $imageName2;
            } else {
            ?>
                <script>
                    $.confirm({
                        icon: 'fa fa-exclamation-circle ',
                        title: 'Ooppss!! Error in Uploading Back Image',
                        content: '<?php echo $errorMessage ?>',
                        columnClass: 'col-md-4 col-md-offset-4',
                        type: 'red',
                        draggable: false,
                        buttons: {
                            again: {
                                text: 'Try Again',
                                btnClass: 'btn-red',
                                keys: ['enter'],
                                action: function() {
                                    window.location.href = 'add-medicine.php';
                                }
                            }
                        }
                    });
                </script>
        <?php
            }
        }
    }

    $medi_name = $_POST['medi_name'];
    $medi_usageDesc = $_POST['medi_usageDesc'];
    $medi_pillCode = $_POST['medi_pillCode'];
    $dType = $_POST['dType'];

    $sql = "UPDATE `medicine` SET `medi_name` = '$medi_name', `medi_usageDesc` = '$medi_usageDesc', 
		`medi_pillCode` = '$medi_pillCode', `medi_frontImg` = '$medi_frontImg', 
		`medi_backImg` = '$medi_backImg', `dType_id_fk` = '$dType' WHERE `medi_id` = '$medi_id' ";

    $exec = mysqli_query($con, $sql);

    if ($exec) {
        ?>
        <script>
            $.confirm({
                icon: 'fa fa-check-circle ',
                title: 'Medicine Updated Successfully',
                content: 'Your Data is Updated Successfully',
                columnClass: 'col-md-4 col-md-offset-4',
                draggable: false,
                theme: 'modern',
                buttons: {
                    confirm: {
                        text: 'Back to View',
                        btnClass: 'btn-blue',
                        keys: ['shift'],
                        action: function() {
                            window.location.href = 'manage-medicine.php';
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
                title: 'Ooppss!! Error in Updating Medicine',
                content: 'Faced an issue in Updating Medicine, Please Try Again',
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
                            window.location.href = '<?php echo basename($_SERVER['PHP_SELF']) . "?" . $_SERVER['QUERY_STRING'] ?>';
                        }
                    }
                }
            });
        </script>
<?php
    }
}





?>