<?php

include '../../connection/db.php';

$hospitalID = $_GET['hos_id'];

$sql = "SELECT `doctor`.*, `diseasecategory`.*
        FROM `doctor` 
	    INNER JOIN `diseasecategory` ON `doctor`.`disCat_id_fk` = `diseasecategory`.`disCat_id` WHERE `doctor`.`hos_id_fk` = '$hospitalID'";

$exec = mysqli_query($con, $sql);

while($row=mysqli_fetch_array($exec)){

    echo '<option value="'.$row['doc_id']. '">'. $row['doc_name'].' | '. $row['disCat_name'] .'</option>';
    
}


?>