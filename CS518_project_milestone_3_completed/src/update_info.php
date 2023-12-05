<?php
// Initialize the session
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    // echo "TEST";
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$up_first_name = $up_last_name = "";
$up_firstname_err = $up_lastname_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate firstname
    if (empty(trim($_POST["upfname"]))) {
        $up_firstname_err = "Please enter your first name...";
    } elseif (!preg_match('/^[a-zA-Z]+$/', trim($_POST["upfname"]))) {
        $up_firstname_err = "firstname can only contain letters...";
    } else {
        // Set parameters
        $param_firstname = trim($_POST["upfname"]);
    }


    // Validate lastname
    if (empty(trim($_POST["uplname"]))) {
        $up_lastname_err = "Please enter lastname...";
    } elseif (!preg_match('/^[a-zA-Z]+$/', trim($_POST["uplname"]))) {
        $up_lastname_err = "lastname can only contain letters...";
    } else {
        // Set parameters
        $param_lastname = trim($_POST["uplname"]);
    }


    // Check input errors before updating the database
    if (empty($up_firstname_err) && empty($up_lastname_err)) {
        // Prepare an update statement
        $sql = "UPDATE user SET first_name = ? , last_name = ? WHERE email = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_firstname, $param_lastname, $param_email);

            // Set parameters
            // $param_firstname = $_SESSION["first_name"];
            // $param_lastname = $_SESSION["last_name"];
            $param_email = $_SESSION["username"];


            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // change variables
                 $_SESSION["first_name"] = $param_firstname;
                 $_SESSION["last_name"] = $param_lastname;
                // information updated successfully. Destroy the session, and redirect to login page
                // session_destroy();
                // session_start();
                header("location: welcome_user.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update information</title>
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

    <div class="container wrapper">
        <h2>Update information</h2>
        <p>Please fill out this form to update your information.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>First name</label>
                <input type="text" name="upfname"
                    class="form-control <?php echo (!empty($up_firstname_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $up_first_name; ?>">
                <span class="invalid-feedback">
                    <?php echo $up_firstname_err; ?>
                </span>
            </div>
            <div class="form-group">
                <label>Last name</label>
                <input type="text" name="uplname"
                    class="form-control <?php echo (!empty($up_last_name_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $up_last_name; ?>">
                <span class="invalid-feedback">
                    <?php echo $up_last_name_err; ?>
                </span>
            </div>
            <!-- <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_new_password" class="form-control <?php echo (!empty($confirm_new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_new_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_new_password_err; ?></span>
            </div> -->
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link ml-2" href="welcome.php">Cancel</a>
            </div>
        </form>
    </div>
</body>
 <?php
    include("footer.php");
    ?>


</html>
