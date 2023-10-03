<?php
// Initialize the session
session_start();

// }
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    // echo "TEST";
    header("location: login.php");
    exit;
}

 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$current_password = $new_password = $confirm_new_password = "";
$current_password_err = $new_password_err = $confirm_new_password_err = "";
$curr_pwd_hash = $_SESSION["password_hash"];
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm new password
    if(empty(trim($_POST["confirm_new_password"]))){
        $confirm_new_password_err = "Please confirm the password.";
    } else{
        $confirm_new_password = trim($_POST["confirm_new_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_new_password)){
            $confirm_new_password_err = "Password did not match.";
        }
    }

    // check current password
    if(empty(trim($_POST["current_password"]))){
        $current_password_err = "Please enter the current password.";     
    } else{
        $current_password = trim($_POST["current_password"]);
        if (!(password_verify($current_password, $curr_pwd_hash))) {
            $current_password_err = 'Current password wrong';
        }else{
            echo 'test error';
        }
    }

        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_new_password_err) && empty($current_password_err)){
        // Prepare an update statement
        $sql = "UPDATE user SET password = ?, temp_pwd = 'no' WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_new_password, $param_email);
            
            // Set parameters
            $param_new_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_email = $_SESSION["username"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                // session_start();
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
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
    <title>Change Password</title>
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
        <h2>Change Password</h2>
        <p>Please fill out this form to change your password.</p>
        <p><?php echo (!empty($temp_password_generated_err)) ? 'is-invalid' : ''; ?><p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group">
                <label>Current Password</label>
                <input type="password" name="current_password" class="form-control <?php echo (!empty($current_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $current_password; ?>">
                <span class="invalid-feedback"><?php echo $current_password_err; ?></span>
            </div>
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
                <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_new_password" class="form-control <?php echo (!empty($confirm_new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_new_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_new_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link ml-2" href="welcome.php">Cancel</a>
            </div>
        </form>
    </div>    
</body>
</html>