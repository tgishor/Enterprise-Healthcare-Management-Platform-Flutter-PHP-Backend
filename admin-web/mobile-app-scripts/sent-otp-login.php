<?php

function generateRandNo($n)
{
    $generator = "1357902468";

    $result = "";

    for ($i = 1; $i <= $n; $i++) {
        $result .= substr($generator, (rand() % (strlen($generator))), 1);
    }

    // Return result
    return $result;
}

try {

    $con = mysqli_connect('localhost', 'root', '', 'smart_hrms');

    if (!$con) {
        throw new Exception('Database Connection Error', 2000);
    } else {

        if ($_POST['username'] && $_POST['mobilenumber']) {
            $username = $_POST['username'];
            $mobile = $_POST['mobilenumber'];
        } else {
            http_response_code(400);
            throw new Exception('Issue with Data Passed');
        }

        // Select the Specific Patient

        $sql = "SELECT * FROM patient WHERE p_username = '$username' AND p_contact = '$mobile' ";

        $exec = mysqli_query($con, $sql);

        while ($row = mysqli_fetch_array($exec)) {

            $requestedPatientID = $row['p_id'];

            $patientName = $row['p_name'];

        }

        if (!$exec) {
            http_response_code(400);
            throw new Exception('Issue Retieving Patient');
        }

        $checkPatientAcc = mysqli_num_rows($exec);

        if ($checkPatientAcc > 0) {

            // GET RANDOM Generated Numbers 
            $otp_gen = generateRandNo(4);

            date_default_timezone_set("Asia/Colombo");

            $cur_timestamp = date("Y-m-d h:i:s");

            // Update the Specific Patient conOTP field 
            $update_otp = "UPDATE patient SET p_conOTP = '$otp_gen', p_otpGenTime = '$cur_timestamp' WHERE p_id = '$requestedPatientID'";
            $exec_upd_otp = mysqli_query($con, $update_otp);

            if (!$exec_upd_otp) {
                http_response_code(400);
                throw new Exception('Issue Updating the Data');
            }

            // Sent the OTP to the Respective User
            $user = "94776421885";
            $password = "6260";

            $string = "Dear $patientName, Use the OTP below to login to GB Healthcare App and Your OTP Expired in 15 minutes.%0D%0AYour OTP for login is $otp_gen";
            $text = urlencode($string);

            $to = $mobile;

            $baseurl = "http://www.textit.biz/sendmsg";
            $url = "$baseurl/?id=$user&pw=$password&to=$to&text=$text";

            $ret = file($url);

            $res = explode(":", $ret[0]);

            if (trim($res[0]) == "OK") {
                echo json_encode(
                    array(
                        [
                            'status' => true,
                            'message' => "Success",
                            'OTP' => $otp_gen
                        ]
                    )
                );
            } else {
                http_response_code(400);
                throw new Exception('Incorrect OTP...!! Please Try Again');
            }

        } else {
            http_response_code(404);
            throw new Exception('Error Occured in Sending OTP');
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
