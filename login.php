<?php
ob_start();
include 'header.php';
include 'code.php';
?>

<div class="bg-local">
    <div class="container-fluid">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="card col-md-6">
                <div class="card-header" style="text-align: center; background: #A3E4D7;">
                    <h4>Login Form</h4>
                </div>
                <div class="card-body">

                    <form action="login.php" method="post">

                        <?php if (count($errors) > 0): ?>
                            <?php foreach ($errors as $error): ?>
                                <p class="alert alert-danger" align="center"><?php echo $error; ?></p>
                            <?php endforeach ?>
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="universtyName">Select login type</label>
                            <select class="form-control" id="loginType" name="loginType">
                                <option selected hidden>Select one...</option>
                                <option value="admin">Admin</option>
                                <option value="manager">Manager</option>
                                <option value="user">User</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="universtyName">Enter The Company Email or ID</label>
                            <input type="text" class="form-control" name="company_email" placeholder="Havana_prop@example.com">
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="universtyName">Enter New Password</label>
                                </div>
                                <div class="col d-flex justify-content-end">
                                    <a href="forget_pass.php">Forget Password?</a>
                                </div>
                            </div>
                            <input type="password" class="form-control" name="password" placeholder="Password">
                        </div>

                        <div style="text-align: center;">
                            <input type="submit" class="btn btn-success" name="login" value="Login">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>