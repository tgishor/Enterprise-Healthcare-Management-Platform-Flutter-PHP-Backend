<?php 

    $con = mysqli_connect('localhost','root','','smart_hrms');

    if(!$con){
        echo json_encode("Eror in Connecting to DB");
    }

    try{
        $patientID = $_GET['id'];
    }catch(Exception $e){
        echo json_encode("Error");
    }

    if (isset($patientID)){
        $sql = "SELECT `booking`.*, `patient`.*, `doctor`.*, `bookingstatus`.*, `medicalrecord`.*
                FROM `booking` 
                LEFT JOIN `patient` ON `booking`.`p_id_fk` = `patient`.`p_id` 
                LEFT JOIN `doctor` ON `booking`.`doc_id_fk` = `doctor`.`doc_id` 
                LEFT JOIN `bookingstatus` ON `booking`.`bookStatus_id_fk` = `bookingstatus`.`bookStatus_id` 
                LEFT JOIN `medicalrecord` ON `medicalrecord`.`book_id_fk` = `booking`.`book_id` 
                WHERE `patient`.`p_id` = ' $patientID' ";

        $exec = mysqli_query($con, $sql);

        $count = mysqli_num_rows($exec);

        $json_array = array();

        if ($count > 0) {

            while ($row = mysqli_fetch_assoc($exec)) {
                $json_array[] = $row;
            }

            echo json_encode($json_array);
        } else {
            echo json_encode("No Data Found..!!!");
        }
    }else{
        echo json_encode("Error");
    }
    

    

    

?>