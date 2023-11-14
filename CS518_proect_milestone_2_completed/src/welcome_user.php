<?php
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
    <title>Welcome</title>
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
    <h3 class="my-2">Welcome, <b> <span style="color:blue;">user</span>
            <?php echo ucfirst(htmlspecialchars($_SESSION["first_name"])) . ' ' . ucfirst(htmlspecialchars($_SESSION["last_name"])); ?>
        </b>.</h3>

<div class="container">
    <table class="table table-bordered table-hover">
        <thead class="table-info">
            <tr>
                <th scope="col" colspan="2">User Information</th>
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
                <td><?php echo htmlspecialchars($_SESSION["username"]) ?></td>
            </tr>
        </tbody>
    </table>
</div>

<br>

    <div class="container">
    <div class="row align-items-center">
        <!-- <div class="col-sm">
        <a href="change_password.php" class="btn btn-warning mr-3 mt-3">Reset Your Password</a>
        </div> -->
        <div class="col-sm">
        <a href="change_password.php" class="btn btn-success mr-3 mt-3">Change Your Password</a>
        </div>
        <div class="col-sm">
        <a href="update_info.php" class="btn btn-info mr-3 mt-3">Update Your Information</a>
        </div>
        <div class="col-sm">
        <a href="logout.php" class="btn btn-danger mt-3">Sign Out of Your Account</a>
        </div>
        <div class="col-sm">
        <a href="add_item.php" class="btn btn-dark mt-3">Add new dissertation item</a>
        </div>
    </div>
    </div>


<!-- 
    <p>
        <a href="change_password.php" class="btn btn-warning mr-3">Reset Your Password</a>
        <a href="change_password.php" class="btn btn-success mr-3">Change Your Password</a>
        <a href="change_password.php" class="btn btn-info mr-3">Update Your Information</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p> -->

    <script src="./../assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="./../assets/js/popper.min.js"></script>
    <script src="./../assets/js/bootstrap.min.js"></script>
</body>

</html>
