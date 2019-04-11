<?php
include 'database_connection.php';

if(isset($_POST["id"])):
    if($_POST["id"] != ''):
        $sql = "SELECT * FROM users WHERE id = '".$_POST["id"]."'";
    else:
        $sql = "SELECT * FROM users";
    endif;
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)):
        $id = $row['id'];
        $email = $row['user_email'];
        $name = $row['user_name'];
        $address = $row['user_address_one'];
        $phone = $row['user_phone_number'];
        $sql = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM payment WHERE user_name='$name'"));
        $offer_name = $sql['packege_name'];
        $item_limit = $sql['item_limit'];
        $pack_limit = $sql['pack_limit'];
        $paid = $sql['amount'];
        $exp_date = $sql['exp_date'];
        echo "

             <div class='row justify-content-md-center'>
                <h1>Comapny Details</h1>
            </div>
            <div class='row justify-content-md-center'>
                <h3 style='text-decoration: underline'>$name</h3>
            </div><br>
            <div class='row justify-content-md-center'>
                <h4>$address</h4>
            </div>
            <div class='row justify-content-md-center'>
                <h4>$email</h4>
            </div>
            <div class='row justify-content-md-center'>
                <h4>$phone</h4>
            </div><hr>
            <div class='row justify-content-md-center'>
                <h1>Payment Details</h1>
            </div><hr>
            <div class='row justify-content-md-center'>
                <h3>Package Name: $offer_name</h3>
            </div>
            <div class='row justify-content-md-center'>
                <h4>Expire Date: $exp_date</h4>
            </div>
            <div class='row justify-content-md-center'>
                <h4>Itel Limit: $item_limit</h4>
            </div>
            <div class='row justify-content-md-center'>
                <h4>Pack Limit: $pack_limit</h4>
            </div>
            <div class='row justify-content-md-center'>
                <h4>Cost: $$paid</h4>
            </div>";
    endwhile;
endif;