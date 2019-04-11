<?php
    include 'database_connection.php';
    include 'header.php';



    $accept = array();
    $errors = array();

    if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
        $email = $_GET['email']; // Set email variable
        $hash = $_GET['hash']; // Set hash variable

        $search = mysqli_query($conn,"SELECT id FROM users WHERE user_email='".$email."' AND reg_token='".$hash."' AND active='0'");
        $row = mysqli_fetch_assoc($search);
        $company_id = $row['id'];

        $query = mysqli_query($conn,"SELECT user_name FROM users WHERE user_email='".$email."' AND reg_token='".$hash."' AND active='0'");
        $rowl = mysqli_fetch_assoc($query);
        $company_username = $rowl['user_name'];

        $sql = "UPDATE users SET active='1'WHERE id='$company_id'";
        if (mysqli_query($conn,$sql) == true){
            mysqli_query($conn,"ALTER TABLE `limit_package` ADD `$company_username._items` INT NOT NULL AFTER `name`, ADD `$company_username._packs` INT NOT NULL AFTER `$company_username._items`");
            mysqli_query($conn,"INSERT INTO transection(user_name) VALUE ('$company_username')");
            array_push($accept,"Your account has been verified. Please login before entering.");
        } else {
            array_push($errors,"Your account has not been verified. Please contact to the admin.");
        }
    }
?>

    <div class="bg">
        <div class="container">
            <div class="row h-100 justify-content-center align-items-center">
                <div class="card" style="margin-top: 10rem">
                    <div class="card-header text-center" style="height: 10rem; background-color: #71bc37; color: #fff;">
                        <h1 style="margin-top: 2rem;">We Warehouse</h1>
                    </div>
                    <div class="card-body">
                        <h5>Hi <?php echo $company_username; ?>,</h5>

                        <?php if (count($accept) > 0): ?>
                            <?php foreach ($accept as $done): ?>
                                <p class="alert alert-success" align="center"><?php echo $done; ?></p>
                                <div align="center" style="margin-top: 1rem;">
                                    <a class="btn btn-success" href="index.php">Login</a>
                                </div>
                            <?php endforeach ?>
                        <?php endif; ?>

                        <?php if (count($errors) > 0): ?>
                            <?php foreach ($errors as $error): ?>
                                <p class="alert alert-danger" align="center"><?php echo $error; ?></p>
                            <?php endforeach ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>