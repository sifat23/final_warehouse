<?php
include 'database_connection.php';

if(!isset($_SESSION)):
    session_start();
endif;

$errors = array();
$success = array();

$name = "";
if (isset($_SESSION['email'])){
    $email = $_SESSION['email'];


    //for username
    $sql_name = "SELECT user_name FROM users WHERE user_email='$email'";
    $usernameQuery = mysqli_query($conn, $sql_name);
    $row = mysqli_fetch_assoc($usernameQuery);
    $name = $row['user_name'];
}

if (isset($_POST['sent'])):
    $sql_copy = "INSERT INTO customer_request_after SELECT * FROM customer_request";
    $result = mysqli_query($conn,$sql_copy);
    if ($result):
        $sql_delete ="DELETE FROM customer_request";
        mysqli_query($conn,$sql_delete);
        array_push($success,"Mail was sent successfully");
    else:
        array_push($errors,"Something is wrong inside there");
    endif;
endif;
?>
<!--Main Navigation-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Material Design Bootstrap</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="style.css" rel="stylesheet">
</head>

<body class="log-bg">

<!--Main Navigation-->
<header>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark default-color scrolling-navbar">
        <a class="navbar-brand" href="home.php"><strong>HOME</strong></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="customer-request.php">Request Pack</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="company-storage.php">Inspaction</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="package.php">Packege Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="company_request_delivery.php">Make Request</a>
                </li>
            </ul>
            <ul class="navbar-nav nav-flex-icons">
                <?php
                    if (isset($_SESSION['email'])):
                ?>
                    <li>
                        <p style="margin-top: 10px; margin-right: 10px"><?php echo $name; ?></p>
                    </li>
                    <li>
                        <a class="nav-link log-button" href="login.php?logout='1'"><b>LOGOUT</b></a>
                    </li>
                <?php
                    endif;
                ?>
            </ul>
        </div>
    </nav>

</header>

<!-- JQuery -->
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/popper.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/mdb.js"></script>

