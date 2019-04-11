<?php
    include 'database_connection.php';

    $errors = array();
    $success = array();

    if (isset($_POST['manager_entry'])):
        $name = $_POST['manager_name'];
        $log_id = $_POST['manager_login_id'];
        $pass = $_POST['manager_pass'];
        $email = $_POST['manager_email'];
        $phone = $_POST['manager_phone'];
        $address = $_POST['manager_address'];

        $sql = "INSERT INTO maneger (m_id,m_pass,m_mail,m_name,m_phone,m_address) VALUES ('$log_id','$pass','$email','$name','$phone','$address')";
        mysqli_query($conn,$sql);
        array_push($success, "Manager added successfully");

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

            <div class="card" style="margin-top: 10px; margin-bottom: 10px;">
                <div style="text-align: center;">
                    <h1>Welcome to the admin panale</h1>
                    <a href="admin.php" class="btn btn-outline-light btn-sm" style="margin-bottom: 10px; color: #2874A6;">Back</a>
                </div>
            </div>

            <div class="jumbotron" style="background-color: #6C3483;">
                <div class="card">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Maneger Entry</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Manager Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Manager Activity</a>
                        </li>
                    </ul><!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <div class="card" style="padding: 10px;">
                                <form method="post" action="admin-manager.php">
                                    <?php if (count($success) > 0): ?>
                                        <?php foreach ($success as $suc): ?>
                                            <p class="alert alert-success"><?php echo $suc; ?></p>
                                        <?php endforeach ?>
                                    <?php endif; ?>

                                    <?php if (count($errors) > 0): ?>
                                        <?php foreach ($errors as $err): ?>
                                            <p class="alert alert-danger"><?php echo $err; ?></p>
                                        <?php endforeach ?>
                                    <?php endif; ?>

                                    <div class="row justify-content-md-center">
                                        <h2>Maneger Registration</h2>
                                    </div>

                                    <div class="form-group">
                                        <label for="universtyName">Enter the manager name :</label>
                                        <input type="text" class="form-control" name="manager_name">
                                    </div>

                                    <div class="form-group">
                                        <label for="universtyName">Enter the login ID :</label>
                                        <input type="text" class="form-control" name="manager_login_id">
                                    </div>

                                    <div class="form-group">
                                        <label for="universtyName">Enter the login password :</label>
                                        <input type="text" class="form-control" name="manager_pass">
                                    </div>

                                    <div class="form-group">
                                        <label for="universtyName">Enter the manager email :</label>
                                        <input type="text" class="form-control" name="manager_email">
                                    </div>

                                    <div class="form-group">
                                        <label for="universtyName">Enter the manager phone number :</label>
                                        <input type="text" class="form-control" name="manager_phone">
                                    </div>

                                    <div class="form-group">
                                        <label for="universtyName">Enter the manager address :</label>
                                        <input type="text" class="form-control" name="manager_address">
                                    </div>

                                    <div style="text-align: center">
                                        <input type="submit" class="btn btn-success btn-lg" value="Request" name="manager_entry">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabs-2" role="tabpanel">
                            <div style="padding: 1rem; text-align: center;">
                                <h3 style="margin-bottom: 1rem;">Maneger Details</h3>
                                <table class="table" style="text-align: center">
                                    <thead>
                                    <tr>
                                        <th>Manager Name</th>
                                        <th>Manager Email</th>
                                        <th>Manager Address</th>
                                        <th>Manager Phone Number</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sql = mysqli_query($conn, "SELECT * FROM maneger");
                                    while ($row = mysqli_fetch_assoc($sql)):
                                    ?>
                                    <tr>
                                        <td><?php echo $row['m_name']; ?></td>
                                        <td><?php echo $row['m_mail']; ?></td>
                                        <td><?php echo $row['m_address']; ?></td>
                                        <td><?php echo $row['m_phone']; ?></td>
                                    </tr>
                                    <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabs-3" role="tabpanel">
                            <div style="padding: 1rem; text-align: center;">
                                <h3 style="margin-bottom: 1rem;">Mnagaer Activity</h3>
                                <table class="table" style="text-align: center">
                                    <thead>
                                    <tr>
                                        <th>Manager Name</th>
                                        <th>Manager Active</th>
                                        <th>Entry Count</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sql = mysqli_query($conn, "SELECT * FROM maneger");
                                    while ($row = mysqli_fetch_assoc($sql)):
                                        ?>
                                        <tr>
                                            <td><?php echo $row['m_name']; ?></td>
                                            <td><?php echo $row['active']; ?></td>
                                            <td><?php echo $row['store_count']; ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>