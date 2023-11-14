<?php
 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
require './../vendor/autoload.php';
require_once "config.php";
require 'email_config.php';

try {

    $mail = new PHPMailer(true);

    $mail->SMTPDebug = 2;                                      
    $mail->isSMTP();                                           
    $mail->Host       = "smtp.gmail.com";                  
    $mail->SMTPAuth   = true;                            
    $mail->Username   = SENDER_EMAIL;               
    $mail->Password   = SENDER_EMAIL_PASSWORD;              
    $mail->SMTPSecure = "tls";   //ssl                          
    $mail->Port       = 587; //"465";
 
    $mail->setFrom('kumushiniodu@gmail.com', 'Kumushini Thennakoon');          
    $mail->addAddress('kumushinithennakoon@gmail.com', 'Kumushini Thennakoon');
      
    $mail->isHTML(true);                                 
    $mail->Subject = 'Subject TEST';
    $mail->Body    = 'HTML message body in <b>bold</b> ';
    $mail->AltBody = 'Body in plain text for non-HTML mail clients';
    $mail->send();
    echo "Mail has been sent successfully!";
    
    header("location:welcome.php");

    
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
 
?>

