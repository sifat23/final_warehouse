<?php
    if(!isset($_SESSION)):
        session_start();
    endif;


    include 'home_header.php';
    include 'database_connection.php';

    $success = array();

    $email = $_SESSION['email'];



    if ($_GET['value'] == 1){
        array_push($success,"Check Mail. Payment Complete");
    }

    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
    $date = $dt->format('Y-m-d');
    $time = $dt->format('h:i:s');
    $month_name = strtolower(date("F", strtotime($date)));


    //for username and id
    $sql_name = "SELECT * FROM users WHERE user_email='$email'";
    $usernameQuery = mysqli_query($conn, $sql_name);
    $row = mysqli_fetch_assoc($usernameQuery);
    $username = $row['user_name'];
    $company_id = $row['id'];

    $sql = "SELECT * FROM customer_request WHERE company_id='$company_id'";
    $result = mysqli_query($conn, $sql);

    $s = "SELECT * FROM `packs` WHERE company_id ='$company_id'";
    $r = mysqli_query($conn,$s);
    $num_rows = mysqli_num_rows($r);


    if (isset($_POST['update'])):
        $name_new = $_POST['com_name_new'];
        $address_new = $_POST['com_adrs_new'];
        $phone_new = $_POST['com_phn_new'];

        $sql = "UPDATE users SET user_address_one='$address_new', user_phone_number='$phone_new' WHERE id='$company_id'";
        mysqli_query($conn, $sql);
        array_push($success, "Information Updated Successfully");
    endif;

   $test = (mysqli_query($conn, "SELECT * FROM `limit_package`"));

    $dataPoints = array();
    while ($piss = mysqli_fetch_assoc($test)){
        array_push($dataPoints, array("y" => $piss[$username.'._items'], "label" => $piss['name']));
    }


//
?>

    <script>
        window.onload = function() {

            var chart = new CanvasJS.Chart("chart", {
                animationEnabled: true,
                theme: "hard",
                title:{
                    text: "Transection Summary Graph"
                },
                axisY: {
                    title: "Pack Transection"
                },
                data: [{
                    type: "column",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();

        }
    </script>
    <div class="log-bg">
        <div class="container" style="margin-top: 5rem;">
<!--            <div class="card">-->
<!--                --><?php
//                while ($piss = mysqli_fetch_assoc($test)){
//                    $a = $piss['sifat._items']."\n";
//                    echo $a;
//                }
//                 ?>
<!--            </div>-->
            <?php if (count($success) > 0): ?>
                <?php foreach ($success as $suc): ?>
                    <p class="alert alert-success" align="center" style="margin-bottom: 10px;"><?php echo $suc; ?></p>
                <?php endforeach ?>
            <?php endif; ?>
            <div class="row" style="margin-top: 1rem;">
                <div class="col-md-6">
                    <div class="card" style="height: 15rem;">
                        <h3 class="card-title" style="margin-top: 10px; margin-left: 10px;">Stored Invetroy Details</h3>
                        <div class="card-body"><hr style="margin-top: -1rem !important;">
                            <?php
                                //total stored
                                $tsi = "SELECT * FROM pack_receive_details WHERE company_id='$company_id'";
                                $result_tsi = mysqli_query($conn, $tsi);
                                $tsi_number = mysqli_num_rows($result_tsi);

                                //total draft
                                $tdi = "SELECT * FROM customer_request_after WHERE company_id='$company_id'";
                                $result_tdi = mysqli_query($conn, $tdi);
                                $tdi_number = mysqli_num_rows($result_tdi);

                                //total received
                                $tri = "SELECT * FROM pack_receive_details WHERE company_id='$company_id'";
                                $result_tri = mysqli_query($conn, $tri);
                                $tri_number = mysqli_num_rows($result_tri);

                                //low stock
                                $low_sql = "SELECT * FROM pack_receive_details WHERE company_id='$company_id' AND amount<=50";
                                $result_low = mysqli_query($conn, $low_sql);
                                $low_number = mysqli_num_rows($result_low);
                            ?>
                            <h6 style="margin-bottom: 1rem;">Total Stored Item : &nbsp;&nbsp;<?php echo $tsi_number; ?> </h6>
                            <h6 style="margin-bottom: 1rem;">Total Draft Item : &nbsp;&nbsp;<?php echo $tdi_number; ?> </h6>
                            <h6 style="margin-bottom: 1rem;">Total Received Item : &nbsp;&nbsp;<?php echo $tri_number; ?> </h6>
                            <h6 style="color: #f90808">Low Stock Item : &nbsp;&nbsp;<?php echo $low_number; ?>  </h6>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card" style="height: 15rem;">
                        <h3 class="card-title" style="margin-top: 10px; margin-left: 10px;"> Requested Invetroy Details</h3>
                        <div class="card-body"><hr style="margin-top: -1rem !important;">
                            <?php
                            //total stored
                            $tsi = "SELECT * FROM request_item WHERE company_id='$company_id'";
                            $result_tsi = mysqli_query($conn, $tsi);
                            $tsi_number = mysqli_num_rows($result_tsi);

                            //total draft
                            $tdi = "SELECT * FROM request_item_after WHERE company_id='$company_id'";
                            $result_tdi = mysqli_query($conn, $tdi);
                            $tdi_number = mysqli_num_rows($result_tdi);

                            //total received
                            $tri = "SELECT * FROM company_delivery_receive WHERE company_id='$company_id'";
                            $result_tri = mysqli_query($conn, $tri);
                            $tri_number = mysqli_num_rows($result_tri);

                            //low stock
                            $low_sql = "SELECT * FROM invoice WHERE company_name='$username'";
                            $result_low = mysqli_query($conn, $low_sql);
                            $low_number = mysqli_num_rows($result_low);
                            ?>
                            <h6 style="margin-bottom: 1rem;">Total Requested Item : &nbsp;&nbsp;<?php echo $tsi_number; ?> </h6>
                            <h6 style="margin-bottom: 1rem;">Total Draft-Request Item : &nbsp;&nbsp;<?php echo $tdi_number; ?> </h6>
                            <h6 style="margin-bottom: 1rem;">Total Received Item : &nbsp;&nbsp;<?php echo $tri_number; ?> </h6>
                            <h6 style="color: #f90808">Current Transaction : &nbsp;&nbsp;<?php echo $low_number; ?>  </h6>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card" style=" margin-top:2rem; height: 15.5rem;">
                        <h3 class="card-title" style="margin-top: 10px; margin-left: 10px;">Curently Using</h3>
                        <div class="card-body"><hr style="margin-top: -1rem !important;">
                            <?php
                            //total stored
                            $sql =mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM payment WHERE user_mail='$email'"));
                            $com = $sql['user_name'];
                            $p_name = $sql['packege_name'];
                            $p_limit = $sql['pack_limit'];
                            $i_limit = $sql['item_limit'];
                            $expire_date = $sql['exp_date'];

                            //limit storage for companies
                            $ttl = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM limit_package WHERE `name`='$month_name'"));
                            $total_packs = $ttl[$username.'._packs'];
                            $total_items = $ttl[$username.'._items'];

                                if (empty($com)):
                            ?>

                                <h4>Nothing has been purched yet.</h4>
                                <h6>Please buy a packege for getting started</h6>
                            <?php else: ?>

                            <h4><?php echo $p_name; ?> </h4>
                            <h6><b>Expire Date : &nbsp;&nbsp;<?php echo $expire_date; ?></b></h6>
                            <h6>Item Limit : &nbsp;&nbsp;<?php echo $i_limit; ?> </h6>
                            <h6>Pack Limit : &nbsp;&nbsp;<?php echo $p_limit; ?> </h6>
                            <h6 style="color: #f90808">Item Limit Left : &nbsp;&nbsp;<b><?php echo $i_limit - $total_items; ?></b></h6>
                            <h6 style="color: #f90808">Pack Limit Left : &nbsp;&nbsp;<b><?php echo $p_limit - $total_packs; ?></b></h6>

                            <?php endif;?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card" style="margin-top: 2rem; height: 15.5rem;">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="card-title" style="margin-top: 10px; margin-left: 10px;">Personal Details</h3>
                            </div>
                            <div class="col-md-6" align="right" style="padding-right: 20px;">
                                <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#exampleModalCenter">Edit</button>
                            </div>
                        </div>
                        <div class="card-body"><hr style="margin-top: -1rem !important;">
                            <?php
                                $sql = "SELECT * FROM `users` WHERE id='$company_id'";
                                $result = mysqli_query($conn, $sql);
                                while($row = mysqli_fetch_array($result)):
                                    $name = $row['user_name'];
                                    $address = $row['user_address_one'];
                                    $date = $row['reg_date'];
                                    $phone = $row['user_phone_number'];
                                    $email = $row['user_email'];
                                    echo "<h6><b>Comapany Name</b> : &nbsp;&nbsp;$name</h6>
                                          <h6><b>Joining Date</b> : &nbsp;&nbsp;$date</h6>
                                          <h6><b>Comapany Address</b> : &nbsp;&nbsp;$address</h6>
                                          <h6><b>Company Contact</b> : &nbsp;&nbsp;$phone</h6>
                                          <h6><b>Comapany Mail</b> : &nbsp;&nbsp;$email</h6>";
                                endwhile;
                            ?>
                        </div>
                    </div>
                </div>

            </div>

            <div class="card" style="margin-top: 2rem; height: 30rem;">
                <div class="card-body"><hr style="margin-top: -1rem !important;">
                    <div id="chart"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Details</h5>
                </div>
                <form action="home.php" method="post">
                    <div class="modal-body">
                    <?php
                        $sql = "SELECT * FROM `users` WHERE id='$company_id'";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_array($result)):
                            $name = $row['user_name'];
                            $address = $row['user_address_one'];
                            $date = $row['reg_date'];
                            $phone = $row['user_phone_number'];
                            $email = $row['user_email'];
                            echo "
                                <div class='input-group mb-3'>
                                    <div class='input-group-prepend'>
                                        <span class='input-group-text' id='basic-addon1'>Company Name</span>
                                    </div>
                                    <input type='text' class='form-control' value='$name' name='com_name_new' readonly>
                                </div>
    
                                <div class='input-group mb-3'>
                                    <div class='input-group-prepend'>
                                        <span class='input-group-text' id='basic-addon1'>Company Address</span>
                                    </div>
                                    <input type='text' class='form-control' value='$address' name='com_adrs_new'>
                                </div>
        
                                <div class='input-group mb-3'>
                                    <div class='input-group-prepend'>
                                        <span class='input-group-text' id='basic-addon1'>Company Phone Number</span>
                                    </div>
                                    <input type='text' class='form-control' value='$phone' name='com_phn_new'>
                                </div>
        
                                <div class='input-group mb-3'>
                                    <div class='input-group-prepend'>
                                        <span class='input-group-text' id='basic-addon1'>Company Email Address</span>
                                    </div>
                                    <input type='text' class='form-control' value='$email' readonly>
                                </div>";
                        endwhile;
                    ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="update">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <br><br>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<?php
include 'user_footer.php';
?>