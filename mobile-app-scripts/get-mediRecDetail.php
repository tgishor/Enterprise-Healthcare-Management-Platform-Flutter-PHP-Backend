<?php

try {
    $patientID = 0;

    $con = mysqli_connect('localhost', 'root', '', 'smart_hrms');

    if (!$con) {
        throw new Exception('Database Connection Error', 2000);
    }else{

        if(isset($_GET['id'])){
            $medicalRecord = $_GET['id'];
        }
        else{
            throw new Exception('No Medical ID Reterived');
        }

        $sql = "SELECT `medicalrecord`.`mediRec_id`, `medicalrecord`.`mediRec_desc`, `booking`.*, `patient`.`p_id`, `patient`.`p_name`,`prescription`.*, `prescriptionstatus`.*, `bookingstatus`.*, `doctor`.*
                FROM `medicalrecord` 
                    INNER JOIN `booking` ON `medicalrecord`.`book_id_fk` = `booking`.`book_id` 
                    INNER JOIN `doctor` ON `booking`.`doc_id_fk` = `doctor`.`doc_id` 
                    INNER JOIN `patient` ON `booking`.`p_id_fk` = `patient`.`p_id` 
                    INNER JOIN `prescription` ON `prescription`.`mediRec_id_fk` = `medicalrecord`.`mediRec_id` 
                    INNER JOIN `prescriptionstatus` ON `prescription`.`preStatus_id_fk` = `prescriptionstatus`.`preStatus_id` 
                    INNER JOIN `bookingstatus` ON `booking`.`bookStatus_id_fk` = `bookingstatus`.`bookStatus_id`  
                WHERE `medicalrecord`.`mediRec_id` = $medicalRecord";

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
