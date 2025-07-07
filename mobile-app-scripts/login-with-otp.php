<?php


try {

    $con = mysqli_connect('localhost', 'root', '', 'smart_hrms');

    if (!$con) {
        throw new Exception('Database Connection Error', 2000);
    } else {

        if ($_POST['username'] && $_POST['mobilenumber'] && $_POST['otp']) {
            $username = $_POST['username'];
            $mobile = $_POST['mobilenumber'];
            $otp = $_POST['otp'];
        } else {
            http_response_code(400);
            throw new Exception('Issue with Data Passed');
        }

        // Select the Specific Patient
        $json_array = array();

        $sql = "SELECT * FROM patient WHERE p_username = '$username' AND p_contact = '$mobile' AND p_conOTP = '$otp' ";

        $exec = mysqli_query($con, $sql);

        $count = mysqli_num_rows($exec);

        if ($count > 0) {

            $row = mysqli_fetch_array($exec);

            date_default_timezone_set("Asia/Colombo");

            // Checking Whether the OTP is valid or not   // OTP is Set be Valid for 15 mins 
            $validTill = strtotime($row["p_otpGenTime"]) + (15 * 60);

            if (strtotime("now") > $validTill) {
                http_response_code(404);
                throw new Exception('OTP maybe expired..!! Please Try Again ');
            }else{

                $finalsql = "SELECT * FROM patient WHERE p_username = '$username' AND p_contact = '$mobile' AND p_conOTP = '$otp' ";

                $final_exec = mysqli_query($con, $finalsql);

                while ($datarow = mysqli_fetch_array($final_exec)) {
                    $patientID = $datarow['p_id'];
                }

                echo json_encode(
                    array(
                        [
                            'status' => true,
                            'message' => "Success",
                            'patient' => $patientID
                        ]
                    )
                );

            }

            // echo json_encode($json_array);

        } else {
            http_response_code(400);
            throw new Exception('Incorrect OTP...!! Please Try Again', 404);
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
