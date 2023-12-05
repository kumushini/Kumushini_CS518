<?php

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
require './../vendor/autoload.php';
require 'email_config.php';
require_once "config.php";


$email =$_SESSION["useremail"];

try {
   
    $mail = new PHPMailer(true);

    // $mail->SMTPDebug = 2;                                      
    $mail->isSMTP();                                           
    $mail->Host       = "smtp.gmail.com";                  
    $mail->SMTPAuth   = true;                            
    $mail->Username   = SENDER_EMAIL;               
    $mail->Password   = SENDER_EMAIL_PASSWORD;                  
    $mail->SMTPSecure = "tls";   //ssl                          
    $mail->Port       = 587; //"465";
 
    $mail->setFrom('kumushiniodu@gmail.com', 'Kumushini Thennakoon');          
    $mail->addAddress($email);

      
    $mail->isHTML(true);                                 
    $mail->Subject = 'Password Reset';
    $mail->Body    = 'Please find the temporary password-<b></b> '. $_SESSION["temp_password"];
    $mail->AltBody = 'Body in plain text for non-HTML mail clients';
    $mail->send();
    // echo "Mail has been sent successfully!";
    
    header("location: change_pwd_with_reset_pwd.php"); //direct to login

    
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
 
?>

