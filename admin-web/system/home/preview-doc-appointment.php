<?php


include '../../connection/db.php';

if (isset($_GET['filter'])) {
    $filterData = $_GET['filter'];
    $doctorID = $_GET['docID'];
}

date_default_timezone_set('Asia/Colombo');
$getTodayDate = date('Y-m-d');

$sql = "SELECT `booking`.*, `bookingstatus`.*, `patient`.*
        FROM `booking` 
        INNER JOIN `bookingstatus` ON `booking`.`bookStatus_id_fk` = `bookingstatus`.`bookStatus_id` 
        INNER JOIN `patient` ON `booking`.`p_id_fk` = `patient`.`p_id`";

if ($filterData == "today") {
    $sql .= " WHERE `booking`.`book_allocateDateTime` BETWEEN '$getTodayDate 00:00:00' AND '$getTodayDate 23:59:00'";
}

if ($filterData == "tomorrow") {

    $oneDayLater = date('Y-m-d', strtotime($getTodayDate . ' + 1 days'));

    $sql .= " WHERE `booking`.`book_allocateDateTime` BETWEEN '$oneDayLater 00:00:00' AND '$oneDayLater 23:59:00'";
}

if ($filterData == "yesterday") {

    $oneDayBefore = date('Y-m-d', strtotime($getTodayDate . ' - 1 days'));

    $sql .= " WHERE `booking`.`book_allocateDateTime` BETWEEN '$oneDayBefore 00:00:00' AND '$oneDayBefore 23:59:00'";
}

$sql .= " AND doc_id_fk =  $doctorID";

// echo $sql;

$exec = mysqli_query($con, $sql);

$checkNoofAppointment = mysqli_num_rows($exec);

if ($checkNoofAppointment > 0) {
    while ($row = mysqli_fetch_array($exec)) {

        $newDate = date("d-M-y", strtotime($row['book_allocateDateTime']));

        if($row['bookStatus_name']=="Pending"){
            $str = '<div class="button btn btn-info">Pending<i class="fa fa-hourglass-half ms-2"></i></div>';
        }else if($row['bookStatus_name'] == "Done"){
            $str = ' <div class="button btn btn-success">Done<i class="fa fa-check-circle ms-2"></i></div>';
        }else{
            $str = '<div class="button btn btn-danger">Cancelled<i class="fa fa-check-circle ms-2"></i></div>';
        }

        echo '<tr height="70px" ">
                    <td class="roundedimage">
                        <div class="image-cropper-roundedimage" style="width: 50px; height: 50px;">
                            <img style="width: 50px; height: 50px;" class="img-fluid rounded-circle mb-3" src="../../uploads/patient/' . $row['p_img'] . '" alt="' . $row['p_name'] . '">
                        </div>
                    </td>
                    <td class="img-content-box"><span class="d-block">' . $row['p_name'] . '</span><span class="font-roboto">' . $row['p_nic'] . '</span></td>
                    <td>
                        <p class="m-0 font-primary">' . $newDate . '</p>
                    </td>
                    <td class="text-end">
                        '. $str .'
                    </td>
                </tr>';
    }
} else {
    echo ' 
    <div class="alert alert-info dark alert-dismissible fade show overflow-visible" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-help-circle"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12" y2="17"></line></svg>
         <p class="overflow-visible">There is no appointments recorded</p>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
    </div>
    ';
}


?>