<?php

try {
    $patientID = 0;

    $con = mysqli_connect('localhost', 'root', '', 'smart_hrms');

    if (!$con) {
        throw new Exception('Database Connection Error', 2000);
    } else {

        if (isset($_GET['id'])) {
            $prescription = $_GET['id'];
        } else {
            throw new Exception('No Prescription ID Reterived');
        }

        $sql = "SELECT `prescription`.*, `prescriptionstatus`.*, `precribingmedicine`.*, `medicine`.*, `drugtype`.*, `doseusage`.*, `usagetime`.*, `medicineusingstate`.*, `medicalrecord`.*, `booking`.*
                FROM `prescription` 
                    INNER JOIN `prescriptionstatus` ON `prescription`.`preStatus_id_fk` = `prescriptionstatus`.`preStatus_id` 
                    INNER JOIN `precribingmedicine` ON `precribingmedicine`.`pre_id_fk` = `prescription`.`pre_id` 
                    INNER JOIN `medicine` ON `precribingmedicine`.`med_id_fk` = `medicine`.`medi_id` 
                    INNER JOIN `drugtype` ON `medicine`.`dType_id_fk` = `drugtype`.`dType_id` 
                    INNER JOIN `doseusage` ON `doseusage`.`preMed_id_fk` = `precribingmedicine`.`preMed_id` 
                    INNER JOIN `usagetime` ON `doseusage`.`usageTime_id_fk` = `usagetime`.`usageTime_id` 
                    INNER JOIN `medicineusingstate` ON `doseusage`.`medicineUsingState_id_fk` = `medicineusingstate`.`medicineUsingState_id` 
                    INNER JOIN `medicalrecord` ON `prescription`.`mediRec_id_fk` = `medicalrecord`.`mediRec_id` 
                    INNER JOIN `booking` ON `medicalrecord`.`book_id_fk` = `booking`.`book_id`
                WHERE `prescription`.`pre_id` = $prescription";

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
