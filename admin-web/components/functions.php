<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($reciever_mail, $subject, $htmlTemplate_path, $swar_var_array) : bool {
    
    require '../../vendor/autoload.php'; //Load Composer's autoloader
    
    $mail = new PHPMailer(true);  //Create an instance; passing `true` enables exceptions

    try {
        //Server settings    
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'mail.grandstarhall.com ';              //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'springbrook@grandstarhall.com';        //SMTP username
        $mail->Password   = 'springbrook123';                       //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect 

        //Recipients
        $mail->setFrom('springbrook@grandstarhall.com', 'Accounts Center');
        $mail->addAddress($reciever_mail);               //Name is optional

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;

        $message = file_get_contents($htmlTemplate_path);

        foreach(array_keys($swar_var_array) as $key){
            if(strlen($key) > 2 && trim($key) != ""){
                $message = str_replace($key, $swar_var_array[$key], $message);
            }
        }


        $mail->msgHTML($message); //Sending HTML file with the pre-defined Message 

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}



function encryptMessage($simple_string){ 
    $ciphering = "AES-128-CTR";   // Store the cipher method
    $iv_length = openssl_cipher_iv_length($ciphering);  // Use OpenSSl Encryption method
    $options = 0;
    $encryption_iv = '1234567891011121';  // Non-NULL Initialization Vector for encryption
    $encryption_key = "gbhealthcare1234";  // Store the encryption key
    $encryption = openssl_encrypt($simple_string, $ciphering,  // Use openssl_encrypt() 
                $encryption_key, $options, $encryption_iv);    // function to encrypt the data
    return $encryption; // Encrypted String will be Returned 
}


function decryptMessage($encryption){
    $ciphering = "AES-128-CTR"; // Store the cipher method
    $iv_length = openssl_cipher_iv_length($ciphering); // Use OpenSSl Encryption method
    $options = 0;
    $decryption_iv = '1234567891011121';  // Non-NULL Initialization Vector for decryption

    $decryption_key = "gbhealthcare1234"; // Store the Decryption key

    $decryption = openssl_decrypt(
        $encryption,
        $ciphering,
        $decryption_key,
        $options,
        $decryption_iv
    );

    // Display the decrypted string
    return $decryption;
}


function rand_string($length)
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($chars), 0, $length);
}

function generateNumericOTP($n)
{
    // Take a generator string which consist of
    // all numeric digits
    $generator = "1357902468";

    // Iterate for n-times and pick a single character
    // from generator and append it to $result

    // Login for generating a random character from generator
    //     ---generate a random number
    //     ---take modulus of same with length of generator (say i)
    //     ---append the character at place (i) from generator to result

    $result = "";

    for ($i = 1; $i <= $n; $i++) {
        $result .= substr($generator, (rand() % (strlen($generator))), 1);
    }

    // Return result
    return $result;
}

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


function number_shorten($number, $precision = 0, $divisors = null)
{

    // Setup default $divisors if not provided
    if (!isset($divisors)) {
        $divisors = array(
            pow(1000, 0) => '', // 1000^0 == 1
            pow(1000, 1) => 'K', // Thousand
            pow(1000, 2) => 'M', // Million
            pow(1000, 3) => 'B', // Billion
            pow(1000, 4) => 'T', // Trillion
            pow(1000, 5) => 'Qa', // Quadrillion
            pow(1000, 6) => 'Qi', // Quintillion
        );
    }

    // Loop through each $divisor and find the
    // lowest amount that matches
    foreach ($divisors as $divisor => $shorthand) {
        if (abs($number) < ($divisor * 1000)) {
            // We found a match!
            break;
        }
    }

    // We found our match, or there were no matches.
    // Either way, use the last defined value for $divisor.
    return number_format($number / $divisor, $precision) . $shorthand;
}






?>
