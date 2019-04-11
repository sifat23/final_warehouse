<?php
include 'database_connection.php';

$errors = array();
$success = array();

if (isset($_GET['value']) && $_GET['value'] == 1):
    array_push($success, "User Deleted successfully");
endif;

$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);

if (isset($_POST['remove'])):
    $id = $_POST['gop_del'];

    $sql = "DELETE FROM users WHERE id='$id'";
    mysqli_query($conn,$sql);
    header("location; admin-user.php?value=1");
endif;
?>

<html>
<head>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/js/bootstrap.min.js" integrity="sha384-ux8v3A6CPtOTqOzMKiuo3d/DomGaaClxFYdCu2HPMBEkf6x2xiDyJ7gkXU0MWwaD" crossorigin="anonymous"></script>
</head>

<body>
<div class="container">
    <?php if (count($success) > 0): ?>
        <?php foreach ($success as $suc): ?>
            <div class="form-group" style="text-align: center">
                <p style="margin-left: 2rem; margin-right: 2rem;" class="alert alert-success"><?php echo $suc; ?></p>
            </div>
        <?php endforeach ?>
    <?php endif; ?>

    <?php if (count($errors) > 0): ?>
        <?php foreach ($errors as $err): ?>
            <div class="form-group" style="text-align: center">
                <p style="margin-left: 2rem; margin-right: 2rem;" class="alert alert-danger"><?php echo $err; ?></p>
            </div>
        <?php endforeach ?>
    <?php endif; ?>
    <div class="card" style="margin-top: 10px; margin-bottom: 10px;">
        <div style="text-align: center;">
            <h1>Welcome to the admin panale</h1>
            <a href="admin.php" class="btn btn-outline-light btn-sm" style="margin-bottom: 10px; color: #2874A6;">Back</a>
        </div>
    </div>

    <div class="card" style="text-align: center; padding: 20px; margin-bottom: 20px">
        <div>
            <h2 class="card-title">WE WAREHOUSE</h2>
            <p>32/2, shukrabad, Dhaka-1213</p>
            <p>wewarehouse03@gmail.com</p>
            <p>+880162782736</p>
        </div>
    </div>


    <div class="card" style="text-align: center; padding: 20px; margin-bottom: 20px">
        <h3>Cave Details</h3>
        <div>
            <table class="table" style="text-align: center">
                <thead>
                    <tr>
                        <th>Cave ID</th>
                        <th>Cave Name</th>
                        <th>Cave Row</th>
                        <th>Cave Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = mysqli_query($conn, "SELECT * FROM cave");
                        while ($row = mysqli_fetch_assoc($sql)):
                    ?>
                        <tr>
                            <td><?php echo $row['id'] ?></td>
                            <td><?php echo $row['cave_name'] ?></td>
                            <td><?php echo $row['rows_in_use'] ?></td>
                            <td><?php echo $row['cave_details'] ?></td>
                        </tr>
                    <?php endwhile;?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card" style="margin-bottom: 20px; padding: 20px; text-align: center">
        <h3>Row Details</h3>
        <div>
            <table class="table" style="text-align: center">
                <thead>
                <tr>
                    <th>Cave ID</th>
                    <th>Cave Name</th>
                    <th>Cave Row</th>
                    <th>Cave ID</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $sql = mysqli_query($conn, "SELECT * FROM `rows`");
                while ($row = mysqli_fetch_assoc($sql)):
                    ?>
                    <tr>
                        <td><?php echo $row['id'] ?></td>
                        <td><?php echo $row['name'] ?></td>
                        <td><?php echo $row['details'] ?></td>
                        <td><?php echo $row['cave_id'] ?></td>
                    </tr>
                <?php endwhile;?>
                </tbody>
            </table>
        </div>
    </div>
</div>





<!-- JQuery -->
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/popper.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/mdb.js"></script>
</body>
</html>