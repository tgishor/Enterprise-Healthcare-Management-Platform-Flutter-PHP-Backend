<?php
include '../../connection/db.php';

if (isset($_GET['preMed_del_id'])) {
    $preMedID = $_GET['preMed_del_id'];
}

$sql = "DELETE FROM `precribingmedicine` WHERE preMed_id = '$preMedID' ";

$exec = mysqli_query($con, $sql);

if ($exec) {
?>
    <script>
        window.location.href = 'assign-medicine.php?pre_id=<?php echo $_GET['pre_id'] ?>';
    </script>
<?php
} else {
?>
    <script>
        alert("Error in deleting")
    </script>
<?php
}

?>


