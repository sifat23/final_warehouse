<html>
    <head>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/js/bootstrap.min.js" integrity="sha384-ux8v3A6CPtOTqOzMKiuo3d/DomGaaClxFYdCu2HPMBEkf6x2xiDyJ7gkXU0MWwaD" crossorigin="anonymous"></script>
    </head>

    <body>
        <div class="container">
            <div class="card" style="margin-top: 10px;">
                <div style="text-align: center;">
                    <h1>Welcome to the Admin Panel</h1>
                    <a href="login.php?logout='1'" class="btn btn-outline-danger btn-sm" style="margin-bottom: 10px; color: black;">logout</a>
                </div>
            </div>
            <div class="card" style="padding: 15px; margin-top: 10px; text-align: center">
                <div class="jumbotron" style="background-color: #17A589;">
                    <h1 style="color: white">Company Details</h1>
                    <p class="lead" style="color: #00FFCD">Admin can access user profile to visit and can delete user and check the pay ment method allover</p>
                    <a class="btn btn-lg btn-danger" href="admin-user.php" role="button">View company docs »</a>
                </div>
                <div class="jumbotron" style="background-color: #2874A6;">
                    <h1 style="color: white">Worehouse Details</h1>
                    <p class="lead" style="color: #07FFF4">Admin can add and delete and rearrange the cave,box and other schedule</p>
                    <a class="btn btn-lg btn-warning" href="warehouse_edit.php" role="button">View docs »</a>
                </div>
                <div class="jumbotron" style="background-color: #6C3483; color: aqua">
                    <h1 style="color: white">Manage Manager</h1>
                    <p class="lead">An admin can add, delete and edit manager details here</p>
                    <a class="btn btn-lg btn-success" href="admin-manager.php">View manager docs »</a>
                </div>
                <div class="jumbotron" style="background-color: #CB4335;">
                    <h1 style="color: white">Payment Navigator</h1>
                    <p class="lead" style="color: #07FFF4">This is the peyment section for all</p>
                    <a class="btn btn-lg btn-primary" href="admin_payment.php" role="button">View payment docs»</a>
                </div>
                <div class="jumbotron" style="background-color: #17A589">
                    <h1 style="color: #ffffff">About us</h1>
                    <p class="lead" style="color: #00FFCD">This is the details project description, the worker and the substite member details.</p>
                    <a class="btn btn-lg btn-danger" href="about.php" role="button">View member docs »</a>
                </div>
            </div>
        </div>
    </body>
</html>