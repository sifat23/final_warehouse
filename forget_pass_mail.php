<?php
include 'header.php';
include 'database_connection.php';

$accept = array();
$errors = array();

if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])):
    $email = $_GET['email']; // Set email variable

    $pass = $_POST['pass'];
    $c_pass = $_POST['pass_conf'];

    if ($pass != $c_pass):
        array_push($errors, "Password are not matched");
    endif;

    if (count($errors) == 0):
        $sql = "UPDATE users SET user_password='$c_pass'WHERE user_email='$email'";
        mysqli_query($conn, $sql);
        header('location: index.php');
    endif;
endif;
?>

<div class="bg-local">
    <div class="container">
        <div class="row h-100 justify-content-center align-content-center">
            <div class="card col-md-6" style="background-color: lightseagreen; padding: 20px">

                <?php if (count($errors) > 0): ?>
                    <?php foreach ($errors as $error): ?>
                        <p class="alert alert-danger" align="center" style="margin-bottom: 1rem;"><?php echo $error; ?></p>
                    <?php endforeach ?>
                <?php endif ?>

                <?php if (count($success) > 0): ?>
                    <?php foreach ($success as $suc): ?>
                        <p class="alert alert-success" align="center" style="margin-bottom: 10px;"><?php echo $suc; ?></p>
                    <?php endforeach ?>
                <?php endif; ?>

                <form action="forget_pass.php" method="post">
                    <div class="form-group">
                        <input type="password" class="form-control" name="pass" placeholder="New Password">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="pass_conf" placeholder="Confirm Password">
                    </div>
                    <div align="center" style="margin-top: 20px">
                        <button type="submit" name="forget" class="btn btn-secondary">Verify Mail</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
