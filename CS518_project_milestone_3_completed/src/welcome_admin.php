<?php

// Include config file
require_once "config.php";

// Initialize the session
session_start();



// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome admin</title>
    <link rel="shortcut icon" href="./../assets/images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="./../assets/css/distcssbootstrap453.min.css" />
    <style>
        body {
            font: 14px sans-serif;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php
    include("navbar.php");
    ?>
    <h3 class="my-2">Welcome, <b> <span style="color:blue;">Admin</span>
            <?php echo ucfirst(htmlspecialchars($_SESSION["first_name"])) . ' ' . ucfirst(htmlspecialchars($_SESSION["last_name"])); ?>
        </b>.</h3>

    
    <div class="container">
        <table class="table table-bordered table-hover">
            <thead class="table-info">
                <tr>
                    <th scope="col" colspan="2">Admin Information</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: left;">Name</td>
                    <td>
                        <?php echo htmlspecialchars($_SESSION["first_name"]) . ' ' . htmlspecialchars($_SESSION["last_name"]); ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;">User Email</td>
                    <td>
                        <?php echo htmlspecialchars($_SESSION["username"]) ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- user approvals  -->
    <div class="container">
        <table class="table table-bordered table-hover">
            <thead class="table-success">
                <tr>
                    <th scope="col" colspan="6">user approvals</th>
                </tr>
            </thead>
            <thead class="table-info">
                <tr>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">email</th>
                    <th scope="col">user_role</th>
                    <th scope="col">user_status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $sql = "SELECT first_name, last_name, email, user_role, user_status FROM user";

                if ($result = mysqli_query($link, $sql)) {
                    // Fetch one and one row
                    while ($row = mysqli_fetch_row($result)) {
                        if ($row[4] == 'signed_up') {
                            echo
                                "<tr>
                            <td style='text-align: left;' name='test111'>$row[0]</td>
                            <td style='text-align: left;' name='test112'>$row[1]</td>
                            <td style='text-align: left;' name='test113'>$row[2]</td>
                            <td style='text-align: left;' name='test114'>$row[3]</td>
                            <td style='text-align: left;' name='test115'>$row[4]</td>
                            <td><form method='POST' action='approve_user.php'>
                                <button type='submit' name='email5' value='$row[2]' class='btn btn-info'>Approve User</button>
                            </form><td>

                            </tr>";
                        }

                    }
                    mysqli_free_result($result);
                }

                $sql = "SELECT first_name, last_name, email, user_role, user_status FROM user";

                if ($result = mysqli_query($link, $sql)) {
                    // Fetch one and one row
                    while ($row = mysqli_fetch_row($result)) {
                        if ($row[4] != 'signed_up') {
                            echo
                                "<tr>
                            <td style='text-align: left;' name='test111'>$row[0]</td>
                            <td style='text-align: left;' name='test112'>$row[1]</td>
                            <td style='text-align: left;' name='test113'>$row[2]</td>
                            <td style='text-align: left;' name='test114'>$row[3]</td>
                            <td style='text-align: left;' name='test115'>$row[4]</td>
                            <td><form method='POST' action='approve_user.php'>
                           <button type='submit' name='email5' value='$row[2]' class='btn btn-success' disabled>Already Approved User</button>
                            </form><td>
                            </tr>";
                        }

                    }
                    mysqli_free_result($result);
                }

                mysqli_close($link);
                ?>
            </tbody>
        </table>
    </div>

    <div class="container">
        <div class="row align-items-center">
            <!-- <div class="col-sm">
                <a href="change_password.php" class="btn btn-warning mr-3 mt-3">Reset Your Password</a>
            </div> -->
            <div class="col-sm">
                <a href="change_password.php" class="btn btn-success mr-3 mt-3">Change Your Password</a>
            </div>
            <div class="col-sm">
                <a href="change_password.php" class="btn btn-info mr-3 mt-3">Update Your Information</a>
            </div>
            <div class="col-sm">
                <a href="logout.php" class="btn btn-danger mt-3">Sign Out of Your Account</a>
            </div>
            <!-- <div class="col-sm">
                <a href="send_mail.php" class="btn btn-danger mt-3">Send Email</a>
            </div>
            <div class="col-sm">
                <a href="google2fa_test.php" class="btn btn-danger mt-3">2FA test</a>
            </div>
            <div class="col-sm">
                <a href="validate_secret_key.php" class="btn btn-danger mt-3">validate 2FA test</a>
            </div>
            <div class="col-sm">
                <a href="send_mail_reset_password.php" class="btn btn-danger mt-3">validate 2FA test</a>
            </div> -->
        </div>
    </div>

    <script src="./../assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="./../assets/js/popper.min.js"></script>
    <script src="./../assets/js/bootstrap.min.js"></script>
</body>
 <?php
    include("footer.php");
    ?>


</html>
