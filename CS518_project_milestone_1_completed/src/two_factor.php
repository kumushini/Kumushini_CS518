<?php
// Initialize the session
session_start();

// require_once 'GoogleAuthenticator.php';

// $ga = new PHPGangsta_GoogleAuthenticator();
// $secret = $ga->createSecret();
// echo "Secret is: ".$secret."\n\n";

// $qrCodeUrl = $ga->getQRCodeGoogleUrl('Blog', $secret);
// echo "Google Charts URL for the QR-Code: ".$qrCodeUrl."\n\n";

// $oneCode = $ga->getCode($secret);
// echo "Checking Code '$oneCode' and Secret '$secret':\n";

// $checkResult = $ga->verifyCode($secret, $oneCode, 2);    // 2 = 2*30sec clock tolerance
// if ($checkResult) {
//     echo 'OK';

// } else {
//     echo 'FAILED';
// }

//*** https://www.spaceotechnologies.com/blog/google-two-factor-authentication-tutorial-php/
// https://medium.com/@richb_/easy-two-factor-authentication-2fa-with-google-authenticator-php-108388a1ea23/

// if ("two_factor" == "success"){

//     $_SESSION["loggedin"] = true;

    
//     //inside two_factor php after the authentication
//     if (($user_role == "user") && ($user_status == "approved")){
//         // Redirect user to welcome page
//         echo "\ninside user role and user status TRUE";
//         // header("Refresh:0; url=welcome_user.php");
    
//         // two_factor.php along with user role
//         header("location:welcome_user.php");
        
//     } elseif($user_role == "admin"){
//         // Redirect user to welcome page
//         header("location: welcome_admin.php");
//         // header("Refresh:0; url=welcome_admin.php");
    
//     }else{
//         echo "two factor failed";
//         header("Refresh:0; url=login.php");
//     }

// }else{
//     header("Refresh:0; url=login.php");
// }

// // Destroy the session.
// session_destroy();
 
// // Redirect to login page
// header("location: login.php");
// exit;
?>




<!-- show message to enter phone number -->
<!DOCTYPE html>
<html>
<title>Two factor authentication</title>
<link rel="stylesheet" type="text/css" href="./../assets/css/distcssbootstrap453.min.css" />

    <style>
        body {
            font: 14px sans-serif;
        }

        .wrapper {
            width: 360px;
            padding: 20px;
        }
    </style>
<body>

<?php
    include("navbar.php");
 ?>


<div>
    <form action="process.php" method="post">
    Name:<input class="input" type="text" placeholder="name" name="name" required><br><br>
    Email:<input class="input" type="email" placeholder="email" name="email" required><br><br>
    Phone:<input class="input" type="text" placeholder="phone" name="phone" required><br><br>
        <button  type="submit" name="btn-save">Submit</button>
    </form>
</div>
</body>
</html>