<?php



try {
    $patientID = 0;

    $con = mysqli_connect('localhost', 'root', '', 'smart_hrms');

    if (!$con) {
        throw new Exception('Database Connection Error', 2000);
    }else{

        if(isset($_GET['id'])){
            $patientID = $_GET['id'];
            $preStatus = $_GET['preStatus'];
        }
        else{
            throw new Exception('No Prescription Data Reterived');
        }

        $sql = "SELECT `prescription`.*, `prescriptionstatus`.*, `medicalrecord`.*, `booking`.*, `doctor`.`doc_name`,`doctor`.`doc_id`, `patient`.`p_id`
                FROM `prescription` 
                    INNER JOIN `prescriptionstatus` ON `prescription`.`preStatus_id_fk` = `prescriptionstatus`.`preStatus_id` 
                    INNER JOIN `medicalrecord` ON `prescription`.`mediRec_id_fk` = `medicalrecord`.`mediRec_id` 
                    INNER JOIN `booking` ON `medicalrecord`.`book_id_fk` = `booking`.`book_id` 
                    INNER JOIN `doctor` ON `booking`.`doc_id_fk` = `doctor`.`doc_id` 
                    INNER JOIN `patient` ON `booking`.`p_id_fk` = `patient`.`p_id` 
                WHERE `patient`.`p_id` = '$patientID' AND prescriptionstatus.preStatus_name = '$preStatus'";

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
