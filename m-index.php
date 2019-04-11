<?php
include 'm-header.php';
include 'database_connection.php';

if(!isset($_SESSION)):
    session_start();
endif;

$email =$_SESSION['email'];


$net = 0;
$used_row_numbers = 0;
$total = 25*20;

$sql = "SELECT * FROM rows";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)):
    $id = $row['id'];
    $s = "SELECT * FROM `pack_receive_details` WHERE row_id ='$id'";
    $r = mysqli_query($conn,$s);
    $num_rows = mysqli_num_rows($r);
    $used_row_numbers = $used_row_numbers + $num_rows;
endwhile;

$percetege = round(($used_row_numbers/$total) * 100, 1);
$net = 100 - $percetege;

$test = (mysqli_query($conn, "SELECT * FROM `transection`"));

$dataPoints = array();
while ($piss = mysqli_fetch_assoc($test)){

    array_push($dataPoints, array("y" => $piss['transection_count'], "label" => $piss['user_name']));
}




?>
<script>
    window.onload = function() {

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            title:{
                text: "TRANSECTION GRAPH FOR COMPANY"
            },
            axisY: {
                title: "Transection Count. Line"
            },
            data: [{
                type: "column",
                yValueFormatString: "#,##0.## tonnes",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

    }
</script>

    <div class="container">
        <div class="row" style="margin-top: 1rem;">
            <div class="col-md-8">
                <div class="card" style="height: 21rem">
                    <div class="card-title">
                        <h4>Warehouse Forum</h4>
                    </div>
                    <div class="card-body"><hr style="margin-top: -1rem !important;">
                        <?php
                        $tmc_number = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users"));
                        $trp_number = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM packs"));
                        $tdp_number = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM pack_delivery_details"));
                        $trqp_number = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM customer_request_after"));
                        $tdqp_number = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM request_item_after"));
                        ?>
                        <h5 style="margin-top: 10px;">Total Number of Company : &nbsp;&nbsp;<?php echo $tmc_number; ?> </h5>
                        <h5 style="margin-top: 25px; margin-bottom: 25px;">Total Recived Pack Number : &nbsp;&nbsp;<?php echo $trp_number; ?> </h5>
                        <h5>Total Delivered Pack Number : &nbsp;&nbsp;<?php echo $tdp_number ?> </h5>
                        <h5 style="margin-top: 25px; color: #CC0000;">Total Pack Number in Receive Queue : &nbsp;&nbsp;<?php echo $trqp_number; ?> </h5>
                        <h5 style="margin-top: 25px; color: #CC0000;">Total Pack Number in Delivery Queue : &nbsp;&nbsp;<?php echo $tdqp_number; ?> </h5>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card" style="height: 21rem;">
                    <div class="card-title">
                        <h4> Storage Status</h4>
                    </div>
                    <div class="card-body"><hr style="margin-top: -1rem !important;">
                        <div class = "referral-credit-outer-circle">
                            <span class="referral-credit-inner-icon" style="color:"></span>
                            <div class = "mask-referral-credit-inner-circle" style = "height: <?php echo $percetege; ?>%">
                                <div class = "referral-credit-inner-circle"></div>
                            </div>
                        </div>
                        <h5 style="margin-top: 14rem; text-align: center; color: black;"><b>Used Storage: <span style="color: #00bcd4;"><?php echo $percetege; ?>%</span></b></h5>
                    </div>
                </div>
            </div>

            <div class="col-md-4" style="margin-top: 2rem">
                <div class="card" style="height: 23rem;">
                    <div class="card-title">
                        <h4> Maneger's Details</h4>
                    </div>
                    <div class="card-body"><hr style="margin-top: -1rem !important; margin-bottom: 2rem ">
                        <?php
                        $sql = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM maneger WHERE m_mail='$email'"));
                        $name = $sql['m_name'];
                        $phone = $sql['m_phone'];
                        $m_id = $sql['m_id'];
                        $t_count = $sql['store_count'];
                        ?>
                        <h6 style="margin-bottom: 1rem;">Singed as <strong><?php echo $name; ?></strong></h6>
                        <h6 style="margin-bottom: 1rem;">ID : <?php echo $m_id; ?></h6>
                        <h6 style="margin-bottom: 1rem;">Phone : <?php echo $phone; ?></h6>
                        <h6 style="margin-bottom: 1rem;">Email : <?php echo $email; ?></h6>
                        <h6 style="margin-bottom: 1rem;">Total Stored Item : <?php echo $t_count; ?> </h6>
                    </div>
                </div>
            </div>

            <div class="col-md-8" style="margin-top: 2rem;">
                <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
            </div>
        </div>
    </div>
<br><br><br><br>

<?php
include 'm-footer.php';
?>
