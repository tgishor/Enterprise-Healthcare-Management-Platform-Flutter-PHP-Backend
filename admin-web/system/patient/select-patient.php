<?php 

    include '../../connection/db.php';

    $patient_id = $_GET['id'];

    $sql = "SELECT `patient`.*, `paitenthasdisease`.*, `disease`.*
            FROM `patient` 
            INNER JOIN `paitenthasdisease` ON `paitenthasdisease`.`p_id_fk` = `patient`.`p_id` 
            INNER JOIN `disease` ON `paitenthasdisease`.`dis_id_fk` = `disease`.`dis_id`
            WHERE patient.p_id = '$patient_id'";

    $exec = mysqli_query($con, $sql);

    if(!$exec){ 
        ?>
        <script>alert("Error Occurred in Loading")</script>
        <?php
    }

    while($row=mysqli_fetch_array($exec)){
        echo "<strong style='font-weight: 700;'>Patient Name : </strong>".$row['medi_name'];
        echo "<br>";
        echo "<strong style='font-weight: 700;'>Medicine Description : </strong> <div>". $row['medi_usageDesc']."</div>";
        echo "<br>";
        echo "<strong style='font-weight: 700;'>Medicine Images : </strong>";
        echo '<img src="../../uploads/medicine/frontimage/'.$row['medi_frontImg'] .'" class="img-fluid rounded p-2" width="150px" alt="">';
        echo '<img src="../../uploads/medicine/backimage/' . $row['medi_backImg'] . '" class="img-fluid rounded p-2" width="150px" alt="">';
        echo "<br>";
    }
?>