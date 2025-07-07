 <?php
    include '../../connection/db.php';

    if (isset($_GET['pre_id'])) {
        $prescriptionID = $_GET['pre_id'];
    }

    $selectedMedicine = "SELECT `prescription`.*, `precribingmedicine`.*, `medicine`.*, `drugtype`.*, `doseusage`.*, `usagetime`.*, `medicineusingstate`.*
                                                      FROM `prescription` 
                                                        INNER JOIN `precribingmedicine` ON `precribingmedicine`.`pre_id_fk` = `prescription`.`pre_id` 
                                                        INNER JOIN `medicine` ON `precribingmedicine`.`med_id_fk` = `medicine`.`medi_id` 
                                                        INNER JOIN `drugtype` ON `medicine`.`dType_id_fk` = `drugtype`.`dType_id` 
                                                        INNER JOIN `doseusage` ON `doseusage`.`preMed_id_fk` = `precribingmedicine`.`preMed_id` 
                                                        INNER JOIN `usagetime` ON `doseusage`.`usageTime_id_fk` = `usagetime`.`usageTime_id` 
                                                        INNER JOIN `medicineusingstate` ON `doseusage`.`medicineUsingState_id_fk` = `medicineusingstate`.`medicineUsingState_id` 
                                                      WHERE `prescription`.`pre_id` = '$prescriptionID' ";

    $exec_selectedMedicine = mysqli_query($con, $selectedMedicine);

    while ($row = mysqli_fetch_array($exec_selectedMedicine)) {

     echo '<tr>
         <th scope="row"> '. $row['preMed_precribingDate'] .' </th>
         <th scope="row"> '. $row['preMed_precribingOverDate'] .' </th>
         <td class="" style="width:50px;">'. $row['medi_name'] . '</td>
         <td class="">

             <a class="badge badge-success" onclick="viewMedicine('.$row['medi_id'].')" data-bs-original-title="" title=""><i class="fa fa-eye" style="font-size: 15px ;"></i></a>

             <a class="badge badge-danger" href="remove-medicine.php?pre_id='.$prescriptionID.'&preMed_del_id=' . $row['preMed_id'] . '" data-bs-original-title="" title=""><i class="fa fa-trash" style="font-size: 15px ;"></i></a>

         </td>
        </tr>'; 

    }
    ?>