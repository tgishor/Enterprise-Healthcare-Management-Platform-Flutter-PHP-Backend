<?php

// Database Connection String
$con = mysqli_connect("localhost", "root", "", "smart_hrms");


if (!$con) {
?>
	<script>
		alert("Error in Connecting");
	</script>
<?php
}


?>