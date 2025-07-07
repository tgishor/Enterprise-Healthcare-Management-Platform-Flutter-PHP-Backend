<?php

try {
    $mediID = 0;

    $con = mysqli_connect('localhost', 'root', '', 'smart_hrms');

    if (!$con) {
        throw new Exception('Database Connection Error', 2000);
    }else{

        if(isset($_GET['id'])){
            $mediID = $_GET['id'];
        }
        else{
            throw new Exception('No Patient ID Reterived');
        }

        $sql = "SELECT `medicine`.*, `drugtype`.*
                FROM `medicine` 
                    INNER JOIN `drugtype` ON `medicine`.`dType_id_fk` = `drugtype`.`dType_id`
                WHERE `medicine`.`medi_id` = $mediID";
        
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
