<?php 

    include '../../connection/db.php';

    $medview_id = $_GET['id'];

    $sql = "SELECT `medicine`.*, `drugtype`.*
            FROM `medicine` 
            INNER JOIN `drugtype` ON `medicine`.`dType_id_fk` = `drugtype`.`dType_id` WHERE medicine.medi_id = '$medview_id'";

    $exec = mysqli_query($con, $sql);

    if(!$exec){ 
        ?>
        <script>alert("Error Occurred in Loading")</script>
        <?php
    }

    while($row=mysqli_fetch_array($exec)){

        echo "<strong style='font-weight: 700;'>Medicine Name : </strong>".$row['medi_name'];
        echo "<br>";
        echo "<strong style='font-weight: 700;'>Medicine Description : </strong> <div>". $row['medi_usageDesc']."</div>";
        echo "<br>";
        echo "<strong style='font-weight: 700;'>Medicine Images : </strong>";
        echo '<img src="../../uploads/medicine/frontimage/'.$row['medi_frontImg'] .'" class="img-fluid rounded p-2" width="150px" alt="">';
        echo '<img src="../../uploads/medicine/backimage/' . $row['medi_backImg'] . '" class="img-fluid rounded p-2" width="150px" alt="">';
        echo "<br>";
        
    }
?>