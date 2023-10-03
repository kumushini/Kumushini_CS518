<?php

session_start();

require './../vendor/autoload.php';
require_once "config.php";




// // Define variables and initialize with empty values
// $current_password = $new_password = $confirm_new_password = "";
// $current_password_err = $new_password_err = $confirm_new_password_err = "";
// $curr_pwd_hash = $_SESSION["password_hash"];

// Processing form data when form is submitted
$google2fa = new \PragmaRX\Google2FA\Google2FA();
$secret = $google2fa->generateSecretKey();

// Prepare an update statement
$sql = "UPDATE user SET g2fa_key = ? WHERE email = ?";

if ($stmt = mysqli_prepare($link, $sql)) {
    // Bind variables to the prepared statement as parameters

    mysqli_stmt_bind_param($stmt, "ss", $secret, $param_email);

    // Set parameters
    $param_email = $_SESSION["username"];
    echo $_SESSION["username"];

    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        // Password updated successfully. Destroy the session, and redirect to login page
        echo 'g2fa generaed';
        $_SESSION["otp_key"] = $secret;

        header("location: send_mail_2fa.php");

        // send email as well


    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }

    // Close statement
    mysqli_stmt_close($stmt);
}


// Close connection
mysqli_close($link);

?>


