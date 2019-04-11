<?php
include 'database_connection.php';

if(isset($_POST["del"])):
    $del_id = $_POST['del'];
    $result = mysqli_query($conn, "SELECT * FROM packs WHERE pack_code='$del_id'");
    $row = mysqli_fetch_array($result);
    $code = $row['pack_code'];
    $name = $row['name'];
    $quantity = $row['amount'];
    $unit = $row['unit'];

    echo "
        <div class='row'>
            <div class='col-md-10'>
                <h6>Pack Code &nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp; $code </h6>
                <h6>nice</h6>
                <h6>Name &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp; $name </h6>
                <h6>Quantity &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp; $quantity &nbsp;($unit) </h6>
            </div>
        </div>
        <div class='form-group' style='padding: 30px'>
            <label for='disabledInput' class='control-label'>Quantity Input Field</label>
            <div>
                <input type='hidden' name='pack_id' value='$code'>
                <input class='form-control' name='req_amount' type='number' max='$quantity'>
            </div>
        </div>";
endif;