<?php

// Include config file
require_once "config.php";

// // Initialize the session
// session_start();

// if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
//     header("location: welcome.php");
//     exit;
// }

// Define variables and initialize with empty values
$firstname = $lastname = $useremail = $password = $confirm_password = "";
$firstname_err = $lastname_err = $useremail_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate firstname
    if (empty(trim($_POST["fname"]))) {
        $firstname_err = "Please enter your first name...";
    } elseif (!preg_match('/^[a-zA-Z]+$/', trim($_POST["fname"]))) {
        $firstname_err = "firstname can only contain letters...";
    } else {
        // Set parameters
        $param_firstname = trim($_POST["fname"]);
    }


    // Validate lastname
    if (empty(trim($_POST["lname"]))) {
        $lastname_err = "Please enter lastname...";
    } elseif (!preg_match('/^[a-zA-Z]+$/', trim($_POST["lname"]))) {
        $lastname_err = "lastname can only contain letters...";
    } else {
        // Set parameters
        $param_lastname = trim($_POST["lname"]);
    }

    // Validate useremail
    if (empty(trim($_POST["email"]))) {
        $useremail_err = "Please enter useremail.";
    } elseif (!preg_match('/^[a-zA-Z0-9@_.]+$/', trim($_POST["email"]))) {
        $useremail_err = "useremail can only contain letters, numbers, @, underscore and dot.";
    } else {
        // Prepare a select statement
        $sql = "SELECT first_name FROM user WHERE email = ? LIMIT 1";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_useremail);

            // Set parameters
            $param_useremail = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $useremail_err = "This email: $param_useremail already exists.";
                } else {
                    $useremail = trim($_POST["email"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if (empty($firstname_err) && empty($lastname_err) && empty($useremail_err) && empty($password_err) && empty($confirm_password_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO user (email,first_name,last_name,password) VALUES (?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_useremail, $param_firstname, $param_lastname, $param_password);

            // Set parameters
            // $param_firstname = $firstname;
            // $param_lastname = $lastname;
            $param_useremail = $useremail;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: login.php");
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }

    }
    $firstname = $lastname = $useremail = $password = $confirm_password = "";

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
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

    <div class="wrapper container">

        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <div class="form-group">
                <label for="fname">First Name</label>
                <input type="text" name="fname" id="fname"
                    class="form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $firstname; ?>">
                <span class="invalid-feedback">
                    <?php echo $firstname_err; ?>
                </span>
            </div>
            <div class="form-group">
                <label for="lname">Last Name</label>
                <input type="text" name="lname" id="lname"
                    class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $lastname; ?>">
                <span class="invalid-feedback">
                    <?php echo $lastname_err; ?>
                </span>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" placeholder='this will be your username' autocomplete="off"
                    class="form-control <?php echo (!empty($useremail_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $useremail; ?>">
                <span class="invalid-feedback">
                    <?php echo $useremail_err; ?>
                </span>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password"
                    class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $password; ?>">
                <span class="invalid-feedback">
                    <?php echo $password_err; ?>
                </span>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password"
                    class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback">
                    <?php echo $confirm_password_err; ?>
                </span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>


    <script src="./../assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="./../assets/js/popper.min.js"></script>
    <script src="./../assets/js/bootstrap.min.js"></script>
</body>

</html>