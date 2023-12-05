<?php

// Include config file
require_once "config.php";

// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: welcome.php");
    exit;
}


// Define variables and initialize with empty values
$username = $password = $hashed_password = $user_role = $user_status = $temp_password_generated = $rest_api_key = "";
$username_err = $password_err = $login_err = $approve_err = $temp_password_generated_err = $rest_api_key_err = "" ;

// // for temporary passwords
// if (isset($_SESSION["temp_password_generated"]) && $_SESSION["temp_password_generated"] === true) {
//     header("location: change_pwd_with_reset_pwd.php");
//     $temp_password_generated_err = 'you are using a temporary password please set a new password';
//     exit;
// }

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }


    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT first_name, last_name, email, password, user_role, user_status, rest_api_key FROM user WHERE email = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;
            //echo $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                echo "inside mysqli_stmt_execute";
                // Store result
                mysqli_stmt_store_result($stmt);
                

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $first_name, $last_name, $username, $hashed_password, $user_role, $user_status,$rest_api_key);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            echo "\npassword_verify";
                            // Password is correct, so start a new session
                            session_destroy();
                            session_start();

                            // Store data in session variables
                            // $_SESSION["loggedin"] = true; //set this at two factor
                            $_SESSION["username"] = $username;
                            $_SESSION["user_role"] = $user_role;
                            $_SESSION["user_status"] = $user_status;
                            $_SESSION["password_hash"] = $hashed_password;
                            $_SESSION["first_name"] = $first_name;
                            $_SESSION["last_name"] = $last_name;
                            $_SESSION["rest_api_key"] = $rest_api_key;
                            
                            // $_SESSION["singed_up_login_err"] = "Please wait until admin approval";

                            echo $user_status;
                            echo $user_role;


                            if(($_SESSION["user_status"]) == "signed_up"){
                                // $login_err = "Please wait until admin approval";
                                header("location:welcome.php");
                                exit;

                            } 
                                

                            // header("location:two_factor.php");
                            header("location:google2fa_test.php");


                            // two_factor.php along with user role
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else {
                    // Username doesn't exist, display a generic error message
                    $login_err = "user not available";
                }
                // Close statement
                mysqli_stmt_close($stmt);
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close connection
            mysqli_close($link);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login page</title>
    <link rel="shortcut icon" href="./../assets/images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="./../assets/css/distcssbootstrap453.min.css" />
     <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <style>
        body {
            font: 14px sans-serif;
        }

        .wrapper {
            width: 360px;
            padding: 20px;
        }
    </style>
    
    <script type="text/javascript">
      var onloadCallback = function() {
        grecaptcha.render('html_element', {
          'sitekey' : '6LdUixkpAAAAACtx6G2v5XfZldhQ8c6pgSuGTlgr'
        });
      };
    </script>


</head>

<body>

    <?php
    include("navbar.php");
    ?>

    <div class="wrapper container">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php
        if (!empty($login_err)) {
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>
        <?php
        if (isset($_SESSION["singed_up_login_err"])) {
            echo '<div class="alert alert-danger">' . $_SESSION["singed_up_login_err"] . '</div>';
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username"
                    class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $username; ?>">
                <span class="invalid-feedback">
                    <?php echo $username_err; ?>
                </span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password"
                    class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $password; ?>">
                <span class="invalid-feedback">
                    <?php echo $password_err; ?>
                </span>
            </div>
            
            <div class="g-recaptcha" data-sitekey="6LdUixkpAAAAACtx6G2v5XfZldhQ8c6pgSuGTlgr"></div>
      		<br/>
      	    <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="signup.php">Sign up now</a>.</p>
            <p>Forgot password? <a href="reset_password_link.php">Forgot password</a>.</p>
        </form>
        <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit&hl=en"
        async defer>
    	</script>
    </div>

    <script src="./../assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="./../assets/js/popper.min.js"></script>
    <script src="./../assets/js/bootstrap.min.js"></script>

</body>

 <?php
    include("footer.php");
    ?>


</html>
