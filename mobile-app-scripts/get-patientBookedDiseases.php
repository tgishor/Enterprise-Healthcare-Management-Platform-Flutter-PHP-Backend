<?php



try {
    $patientID = 0;

    $con = mysqli_connect('localhost', 'root', '', 'smart_hrms');

    if (!$con) {
        throw new Exception('Database Connection Error', 2000);
    }else{

        if(isset($_GET['id'])){
            $patientID = $_GET['id'];
            $bookingTime = $_GET['bookday'];
        }
        else{
            throw new Exception('No Prescription Data Reterived');
        }

        function toGetDate($date_time)
        {
            $new_date = date("Y-m-d", strtotime($date_time));
            return $new_date;
        }

        $sql = "SELECT `patient`.`p_id`, `paitenthasdisease`.*, `disease`.*
                FROM `patient` 
                INNER JOIN `paitenthasdisease` ON `paitenthasdisease`.`p_id_fk` = `patient`.`p_id` 
                INNER JOIN `disease` ON `paitenthasdisease`.`dis_id_fk` = `disease`.`dis_id`
                WHERE `patient`.`p_id` = '$patientID' AND `paitenthasdisease`.`paHasDis_recordedDate` BETWEEN '" . date("Y-m-d 00:00:00", strtotime($bookingTime)). "' AND '". date("Y-m-d 23:59:59", strtotime($bookingTime))."' ";                                          
        
        // echo $sql;

        $exec = mysqli_query($con, $sql);

        $count = mysqli_num_rows($exec);

        $json_array = array();

        if ($count > 0) {

            while ($row = mysqli_fetch_assoc($exec)) {
                $json_array[] = $row;
            }

            echo json_encode($json_array);

        } else {
            http_response_code(400);
            throw new Exception('No Data Founded', 404);
        }
    }
 

} catch (Exception $e) {
    echo json_encode(
        array(
            [
                'status' => false,
                'message' => $e->getMessage(),
                'error_code' => $e->getCode()
            ]
        )
    );
    exit;
}
