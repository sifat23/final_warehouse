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

        <div class="jumbotron" style="background-color: #17A589;">
            <div class="card">
                <table class="table table-striped table-dark" style="margin-top: 15px; text-align: center">

                    <thead>
                    <tr>
                        <th scope="col">Company Name</th>
                        <th scope="col">Company Mail</th>
                        <th scope="col">Active</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while($rows = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td class="nr" ><?php echo $rows['user_name'] ?></td>
                            <td><?php echo $rows['user_email']; ?></td>
                            <td><?php echo $rows['active']?></td>
                            <td>
                                <form action="admin-user.php" method="post">
                                    <input type="hidden" name="gop_del" value="<?php echo $rows['id']; ?>">
                                    <button type="button" class="btn btn-info view_data" id="<?php echo $rows['id']; ?>" data-toggle="modal" data-target="#companyDetails">Details</button>
                                    <input type="submit" class="btn btn-danger" name="remove" value="Remove">
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="companyDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body" id="rrest">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->


    <script>
        //rest data finding with item code
        $(document).on('click', '.view_data', function () {
            var pack = $(this).attr('id');
            //alert(pack);
            $.ajax({
                url: "admin_data.php",
                method: "POST",
                data: {id: pack},
                success: function (data) {
                    $('#rrest').html(data);
                }
            });
        });
    </script>

    <!-- JQuery -->
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="js/popper.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/mdb.js"></script>
    </body>
</html>