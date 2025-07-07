<?php

function encryptMessage($simple_string)
{

    // Store the cipher method
    $ciphering = "AES-128-CTR";

    // Use OpenSSl Encryption method
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;

    // Non-NULL Initialization Vector for encryption
    $encryption_iv = '1234567891011121';

    // Store the encryption key
    $encryption_key = "gbhealthcare1234";

    // Use openssl_encrypt() function to encrypt the data
    $encryption = openssl_encrypt(
        $simple_string,
        $ciphering,
        $encryption_key,
        $options,
        $encryption_iv
    );

    return $encryption;
}

try{
    $patientID = 0;

    $con = mysqli_connect('localhost', 'root', '', 'smart_hrms');

    if(!$con){
        throw new Exception('Database Connection Error', 2000);
    }else{
        $username = $_POST['username'];
        $password = encryptMessage($_POST['password']);

        $sql = "SELECT * FROM patient WHERE p_username = '". $username. "' AND p_password='". $password."'";
        $exec = mysqli_query($con,$sql);
        $count = mysqli_num_rows($exec);

        if($count == 1){

            while($row = mysqli_fetch_array($exec)){
                $patientID = $row['p_id'];
            }
            
            if($patientID > 0){
                echo json_encode(
                    array([
                            'status' => true,
                            'message' => "Success",
                            'patient' => $patientID
                        ]
                    )
                );
            }else{
                throw new Exception('No Patient ID Founded');
            }
        } else {
            throw new Exception('Incorrect Username or Password');
        }   
    }
}catch(Exception $e){
    echo json_encode(
        array([
                'status' => false,
                'message' => $e->getMessage(),
                'error_code' => $e->getCode()
            ]
        )
    );
    exit;
}





?>