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
        $sql = "SELECT * FROM patient WHERE `patient`.`p_id` = ' $patientID' ";

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
