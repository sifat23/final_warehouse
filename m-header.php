<?php
if(!isset($_SESSION)):
    session_start();
endif;

?>
<html>
<head>

    <title>We Warehouse || Manager</title>
    <link rel="stylesheet" href="custom.css" type="text/css">
    <link rel="stylesheet" href="circle.css">
    <link href="css/addons/datatables.min.css" rel="stylesheet">

    <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">

    <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="jQuery-plugin-progressbar.js"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/addons/datatables.min.js"></script>
</head>

<body class="manager-bg">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="m-index.php">HOME</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link go" href="m-storage-accept.php">Receivable</a>
            </li>

            <li class="nav-item">
                <a class="nav-link go" href="m-storage.php">Storage</a>
            </li>
            <li class="nav-item">
                <a class="nav-link go" href="m-delivery-storage-accept.php">Distribution</a>
            </li>
            <li class="nav-item">
                <a class="nav-link go" href="m-delivery.php">Delivery List</a>
            </li>
            <li class="nav-item">
            &nbsp;&nbsp;&nbsp;<span style="font-size: 1.4em; color: #00bcd4">|</span>&nbsp;&nbsp;
                <a href="login.php?logout='1'" class="btn btn-danger">logout</a>
            </li>
        </ul>
    </div>
</nav>