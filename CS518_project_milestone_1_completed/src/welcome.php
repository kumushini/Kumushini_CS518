<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
// if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
//     header("location: login.php");
//     exit;
// }else{
if (($_SESSION["user_role"] == "user") && ($_SESSION["user_status"] == "approved")) {
    // Redirect user to welcome page
    $_SESSION["loggedin"] = true;
    echo "\ninside user role and user status TRUE";
    // header("Refresh:0; url=welcome_user.php");

    // two_factor.php along with user role
    header("location:welcome_user.php");
    exit;

} elseif ($_SESSION["user_role"] == "admin") {
    $_SESSION["loggedin"] = true;
    // Redirect user to welcome page
    header("location: welcome_admin.php");
    exit;
    // header("Refresh:0; url=welcome_admin.php");

} else {
    // $_SESSION["loggedin"] = true;
    $_SESSION["singed_up_login_err"] = "Please wait until admin approval";
    header("location: login.php");
    exit;
}
// }

?>