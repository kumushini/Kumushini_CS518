<?php
$to = "kumushinithennakoon@gmail.com.com";
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: kumushiniodu@gmail.com";

ini_set("SMTP", "localhost");
ini_set("smtp_port", "25");
ini_set("sendmail_from", "admin@wampserver.invalid");
ini_set("sendmail_path", "C:\wamp\bin\sendmail.exe -t");

mail($to, $subject, $txt, $headers);


?>