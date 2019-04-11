<?php
include 'm-header.php';
include 'database_connection.php';
if (!isset($_SESSION)):
    session_start();
endif;


$dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
$date = $dt->format('Y-m-d');
$time = $dt->format('h:i:s');

$sql = "SELECT * FROM pack_delivery_details";
$result = mysqli_query($conn, $sql);
?>
<div class="container-fluid">
    <div class="card" id="table" style="margin-top:10px; padding-left: 13px; padding-right: 13px;">
        <div class="card-body" style=" padding: 0px !important;">
            <h4 class="card-title" style="margin-bottom: 0 !important; margin-top: 10px;">Requested packages</h4>
        </div>
        <table class="table table-striped table-dark" id="mytable" style="margin-top: 15px; text-align: center">
            <thead>
            <tr>
                <th style="height: 70px" scope="col">PACK ID</th>
                <th style="height: 70px" scope="col">PACK NAME</th>
                <th style="height: 70px; width: 235px" scope="col">PACK DESCRIPTION</th>
                <th style="height: 70px" scope="col">PACK AMOUNT</th>
                <th style="height: 70px" scope="col">PACK UNIT</th>
                <th style="height: 70px" scope="col">RECEIVE DATE</th>
                <th style="height: 70px" scope="col">DELIVERY DATE</th>
                <th style="height: 70px" scope="col">PACK TYPE</th>
                <th style="height: 70px" scope="col">COMPANY NAME</th>
                <th style="height: 70px" scope="col">MANAGER NAME</th>

            </tr>
            </thead>
            <tbody>
            <?php while ($rows = mysqli_fetch_assoc($result)):
                $m_id = $rows['manager_id'];
                $mn = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM maneger"));
                $m_name = $mn['m_name'];
                ?>
                <tr>
                    <td ><?php echo $rows['pack_code']; ?></td>
                    <td ><?php echo $rows['pack_name']; ?></td>
                    <td style="width: 235px;"><?php echo $rows['short_details'] ?></td>
                    <td ><?php echo $rows['amount']; ?></td>
                    <td ><?php echo $rows['unit']; ?></td>
                    <td ><?php echo $rows['accepted_date']; ?></td>
                    <td ><?php echo $rows['deliver_date']; ?></td>
                    <td ><?php echo $rows['pack_type']; ?></td>
                    <td ><?php echo $rows['comany_name']; ?></td>
                    <td ><?php echo $m_name; ?></td>
<!--                    <td>-->
<!--                        <button type="button" id="--><?php //echo $rows['pack_id']; ?><!--"-->
<!--                                class="btn btn-primary btn-sm view_data">MORE <i class="fas fa-chevron-circle-down"></i>-->
<!--                        </button>-->
<!--                    </td>-->
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

