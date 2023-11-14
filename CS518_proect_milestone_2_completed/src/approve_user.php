<?php

session_start();

// Include config file
require_once "config.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if ($_POST['email5']) {

        $req_email = $_POST['email5'];
        // var_dump($_POST);

        if (empty($req_email)) {
            header("location: welcome.php");
            exit;

        } else {
            //sql update
            $sql = "UPDATE user SET user_status = 'approved', user_approved_date = CURRENT_TIMESTAMP 
                WHERE email= ?";

            if ($stmt = mysqli_prepare($link, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $req_email);

                // // Set parameters
                // $param_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                // $param_email = $_SESSION["username"];

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    // user approved successfully
                    header("location: welcome.php");
                    exit();
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }

                // Close statement
                mysqli_stmt_close($stmt);
            }

        }

    }

}

?>