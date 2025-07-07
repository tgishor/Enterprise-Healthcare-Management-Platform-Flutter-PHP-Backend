<?php

    $decrypt_key = "your decryption key here";  
    $decrypt_key = $_GET['key'];
    $password = $_GET['pass'];

    function decryptMessage($encryption)
    {
        global $decrypt_key;
        $ciphering = "AES-128-CTR"; // Store the cipher method
        $iv_length = openssl_cipher_iv_length($ciphering); // Use OpenSSl Encryption method
        $options = 0;
        $decryption_iv = '1234567891011121';  // Non-NULL Initialization Vector for decryption

        $decryption_key = $decrypt_key; // Store the Decryption key

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


    echo decryptMessage($password);

?>