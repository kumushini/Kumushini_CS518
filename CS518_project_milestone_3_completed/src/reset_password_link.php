<?php

session_start();

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$useremail = $password_reset_success ="";
$useremail_err = $password_reset_success_err = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate useremail
    if (empty(trim($_POST["email"]))) {
        $useremail_err = "Please enter useremail.";
    } elseif (!preg_match('/^[a-zA-Z0-9@_.]+$/', trim($_POST["email"]))) {
        $useremail_err = "useremail can only contain letters, numbers, @, underscore and dot.";
    } else {
        // Set parameters
        $useremail = trim($_POST["email"]);
        $_SESSION["useremail"] = trim($_POST["email"]);

        // echo  $_SESSION["useremail"];

        $sql = "SELECT email FROM user WHERE email = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_useremail);

            // Set parameters
            $param_useremail = $_SESSION["useremail"];

            if (mysqli_stmt_execute($stmt)) {
                // echo "inside mysqli_stmt_execute";
                // Store result
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // echo "user exists";

                    $_SESSION["temp_password_generated"] = true;
                    $_SESSION["temp_password"] = rand(100000, 999999);

                    $sql = "UPDATE user SET password = ?, temp_pwd = 'yes' WHERE email = ?";

                    if ($stmt = mysqli_prepare($link, $sql)) {
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "ss", $param_temp_password, $param_email);

                        // Set parameters
                        $param_temp_password = password_hash($_SESSION["temp_password"], PASSWORD_DEFAULT);
                        $param_email = $_SESSION["useremail"];

                        // Attempt to execute the prepared statement
                        if (mysqli_stmt_execute($stmt)) {
                            // Password updated successfully.
                            $password_reset_success = "Temporary password sent to your email";
                            // send email to user to reset the password
                            header("location: send_mail_reset_password.php");
                        } else {
                            $password_reset_success_err = "something went wrong";
                        }
                    }

                }
            }
        }
    }
}


// reset password

// when user press the submit button after entering the email
// whether user exist in database
// if exist true
// $_SESSION["temp_password_generated"] = true;
// generate random password using rand() -- gen_pwd
// get the hash for gen_pwd -- hashed_gen_pwd
// sql query to update the current passwrod with hashed_gen_pwd and set temp_pwd = 'yes'
// send the mail to user -- $_POST["email"] including "gen_pwd"
// redirect login   



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="shortcut icon" href="./../assets/images/favicon.png" type="image/x-icon">
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
    <?php
        if (!empty($login_err)) {
            echo '<div class="alert alert-success">' . $password_reset_success . '</div>';
        }
    ?>

    <div class="container wrapper">
        <h2>Reset Password</h2>
        <p>Please enter your email to reset password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" placeholder='this will be your username' autocomplete="off"
                    class="form-control <?php echo (!empty($useremail_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $useremail ?>">
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
 <?php
    include("footer.php");
    ?>


</html>
