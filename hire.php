<?php
    include 'header.php';
    include 'database_connection.php';
    if(!isset($_SESSION)):
        session_start();
    endif;


    $email = $_SESSION['email'];

    //for token
    $sql_token = "SELECT registration_token FROM users WHERE company_email='$email'";
    $tokenQuery = mysqli_query($conn, $sql_token);
    $row = mysqli_fetch_assoc($tokenQuery);
    $token = $row['registration_token'];

    //for username
    $sql_name = "SELECT company_username FROM users WHERE company_email='$email'";
    $usernameQuery = mysqli_query($conn, $sql_name);
    $row = mysqli_fetch_assoc($usernameQuery);
    $username = $row['company_username'];


    //row count
?>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-warning">Hired Item</button>
            </div>
        </div>

        <div class="row justify-content-center">
            <h4>Hire Something</h4>
            <div class="card col-md-12 box_entry">
                <div class="form-group">
                    <label for="universtyName">Enter The Cave Name</label>
                    <input type="text" class="form-control" id="company_name" placeholder="Havana Propartice">
                </div>
                <div class="form-group">
                    <label for="universtyName">Enter The Cave Description</label>
                    <textarea placeholder="Enter description" id="company-content" name="description" rows="2" spellcheck="false" class="form-control autosize-target text-left"></textarea>
                </div>
                <div class="form-group">
                    <label for="universtyName">Enter The Type of Cave</label>
                    <select class="form-control">
                        <option selected hidden>Select one...</option>
                        <option>Data House</option>
                        <option>Grosarry</option>
                    </select>
                </div>
                </div>
            </div>
        </div>

    </div>

<?php
include 'footer.php';
?>