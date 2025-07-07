<?php
    include '../../connection/db.php';
    $doc_id = $_GET['doc_id'];

    $sql = "SELECT `doctor`.*, `diseasecategory`.*
        FROM `doctor` 
	    INNER JOIN `diseasecategory` ON `doctor`.`disCat_id_fk` = `diseasecategory`.`disCat_id` WHERE `doctor`.`doc_id` = '$doc_id'";

    $exec = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_array($exec)) {

        if($row['specilist'] == 0){
            $doctype = "General Doctor";
        }else{
        $doctype = "Specialist";
        }

        echo '<div class="border p-4 d-flex flex-column justify-content-center align-items-center">
                          <h5>Selected Doctor Details</h5>
                          <p>
                            <strong>Doctor Name:</strong> '.$row['doc_name'].'
                          </p>
                          <p>
                            <strong>Doctor Type:</strong> ' .$doctype.'
                          </p>
                          <p>
                            <strong>Doctor Category:</strong> '.$row['disCat_name'].'
                          </p>
                        </div>';

        echo '<div class="border p-4 d-flex flex-column justify-content-center align-items-center">
                                <h5>Check Doctor Availability</h5>
                                <a class="btn btn-primary" >Manage Patient</a>
                                
                              </div>';
    }

?>