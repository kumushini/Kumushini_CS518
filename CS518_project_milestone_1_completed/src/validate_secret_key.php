<?php

session_start();

require './../vendor/autoload.php';
require_once "config.php";

$google2fa = new \PragmaRX\Google2FA\Google2FA();
$secret = $google2fa->generateSecretKey();

$useremail = $_SESSION["username"];

// // Define variables and initialize with empty values
// $current_password = $new_password = $confirm_new_password = "";
// $current_password_err = $new_password_err = $confirm_new_password_err = "";
// $curr_pwd_hash = $_SESSION["password_hash"];

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["2fa_key"]))) {
        $useremail_err = "Please enter 2f_key received";
    } else {
        $param_2fa_key = trim($_POST["2fa_key"]);
    }

    $sql = "SELECT g2fa_key FROM user WHERE email = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_username);

        // Set parameters
        $param_username = $_SESSION["username"];
        

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            echo "inside mysqli_stmt_execute";
            // Store result
            mysqli_stmt_store_result($stmt);

            // Check if username exists, if yes then verify password
            if (mysqli_stmt_num_rows($stmt) == 1) {
                // Bind result variables
                mysqli_stmt_bind_result($stmt, $g2fa_key);

                if (mysqli_stmt_fetch($stmt)) {

                    if ($g2fa_key == $param_2fa_key) {
                        header("location:welcome.php");
                        // echo "elakiri";
                    } else {
                        header("location:login.php");
                        // echo 'verification error';
                    }

                    // Close statement
                    mysqli_stmt_close($stmt);
                }
            }
        }
    }

    // Close connection
    mysqli_close($link);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
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

</head>

<body>
    <?php
    include("navbar.php");
    ?>

    <div class="container wrapper">
        <h2>Enter received secret key</h2>
        <p>2 setp verification</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="2fa_key">Please enter 2f_key received</label>
                <input type="2fa_key" name="2fa_key" id="2fa_key" placeholder='2f_key received' autocomplete="off"
                    class="form-control <?php echo (!empty($useremail_err)) ? 'is-invalid' : ''; ?>"
                    value="">
                <span class="invalid-feedback">
                    <?php echo $useremail_err; ?>
                </span>
            </div>

            <div class="form-group">
                <input type="submit" name="password_rest_link" class="btn btn-primary" value="Submit">
                <a class="btn btn-link ml-2" href="login.php">Cancel</a>
            </div>
        </form>
    </div>
</body>

</html>