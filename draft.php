<?php
    include 'header.php';
    include 'database_connection.php';
    if(!isset($_SESSION)):
        session_start();
    endif;


    $email = $_SESSION['email'];
    //for token
    //    $sql_token = "SELECT registration_token FROM users WHERE company_email='$email'";
    //    $tokenQuery = mysqli_query($conn, $sql_token);
    //    $row = mysqli_fetch_assoc($tokenQuery);
    //    $token = $row['registration_token'];

    //for username
    $sql_name = "SELECT company_username FROM users WHERE company_email='$email'";
    $usernameQuery = mysqli_query($conn, $sql_name);
    $row = mysqli_fetch_assoc($usernameQuery);
    $username = $row['company_username'];

    $sql_name = "SELECT id FROM users WHERE company_email='$email'";
    $usernameQuery = mysqli_query($conn, $sql_name);
    $row = mysqli_fetch_assoc($usernameQuery);
    $company_id = $row['id'];

    $sql = "SELECT * FROM customer_request WHERE company_id='$company_id'";
    $result = mysqli_query($conn, $sql);
?>
    <div class="container">
        <div class="card" id="content" style="margin-top:10px; padding-left: 13px; padding-right: 13px;">
            <div class="card-body" style=" padding: 0px !important;">
                <h4 class="card-title" style="margin-bottom: 0 !important; margin-top: 10px;">Requested packages</h4>
            </div>
            <table class="table table-striped table-dark" style="margin-top: 15px; text-align: center">
                <thead>
                <tr>
                    <th scope="col">PACK ID</th>
                    <th style="width: 400px;" scope="col">DESCRIPTION</th>
                    <th style="width: 185px;" scope="col">PACK TYPE</th>
                    <th scope="col">DATE</th>
                    <th scope="col">TIME</th>
                </tr>
                </thead>
                <tbody>
                <?php while($rows = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td class="nr"><?php echo $rows['pack_id'] ?></td>
                        <td style="width: 400px;"><?php echo $rows['short_details']; ?></td>
                        <td style="width: 185px;"><?php echo $rows['pack_type']; ?></td>
                        <td><?php echo $rows['input_date']; ?></td>
                        <td><?php echo $rows['input_time']; ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <br><br><br>
    </div>

<?php
    include 'footer.php';
?>