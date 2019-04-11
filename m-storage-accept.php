<?php
include 'm-header.php';
include 'database_connection.php';
if (!isset($_SESSION)):
    session_start();
endif;

$email =$_SESSION['email'];

$errors = array();
$success = array();

if (isset($_GET['value']) && $_GET['value'] == "ok"){
    array_push($success,"Request submitted properly.");
}

$dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
$date = $dt->format('Y-m-d');
$time = $dt->format('h:i:s');

$sql = "SELECT * FROM customer_request_after";
$result = mysqli_query($conn, $sql);

function fill_cave_name($conn)
{
    $output = '';
    $sql = "SELECT * FROM `cave`";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $output .= '<option value="' . $row["id"] . '">' . $row["cave_name"] . '</option>';
    }
    return $output;
}

if (isset($_POST['store_pack'])):
    $cave_id = $_POST['caveName'];
    $row_id = $_POST['rowName'];
    $invoice = $_POST['invoice_code'];

    $pack_name = $_POST['pack_name'];
    $pack_code = $_POST['pack_id'];
    $pack_des = $_POST['description'];
    $pack_type = $_POST['pack_type'];
    $pack_comp = $_POST['pack_com_id'];
    $pack_date = $_POST['pack_date'];
    $pack_time = $_POST['pack_time'];
    $amount = $_POST['pack_amount'];
    $unit = $_POST['pack_unit'];
    $manu = $_POST['pack_menu'];
    $com_name = $_POST['company_name'];


    if ($cave_id == 'NULL' || $row_id == 'NULL'):
        array_push($errors, "Empty field detected! Please check inputs");
    endif;

    if (empty($invoice)):
        array_push($errors, "Please insert the INVOICE NUMBER provided by company invoice");
    else:
        $sql_check = "SELECT * FROM `customer_request_after` WHERE invoice_code='$invoice' AND company_id='$pack_comp'";
        $result = mysqli_query($conn, $sql_check);
        $number = mysqli_num_rows($result);
        //to check is there are any valid invoice number exist or not.
        if ($number > 0):
            if (count($errors) == 0):
                $sql = "INSERT INTO packs (invoice_code,`name`,pack_code,amount,unit,short_details,item_type,requested_date,requested_time,`date`,`time`,cave_id,row_id,company_id,company_name,pack_manufacturer) VALUES ('$invoice', '$pack_name', '$pack_code','$amount','$unit', '$pack_des', '$pack_type', '$pack_date', '$pack_time', '$date', '$time', '$cave_id', '$row_id', '$pack_comp', '$com_name','$manu')";
                if (mysqli_query($conn, $sql) == true):
                    $main = "INSERT INTO pack_receive_details (invoice_code,`name`,pack_code,amount,unit,short_details,request_date,request_time,accepted_date,accepted_time,company_id,company_name,row_id,cave_id,pack_manufacturer) VALUES('$invoice', '$pack_name', '$pack_code', '$amount', '$unit', '$pack_des', '$pack_date', '$pack_time', '$date', '$time', '$pack_comp', '$com_name', '$row_id', '$cave_id','$manu')";
                    mysqli_query($conn, $main);
                    $deletesql = "DELETE FROM customer_request_after WHERE pack_id='$pack_code'";
                    mysqli_query($conn, $deletesql);

                    //manager item count
                    $ttl = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM maneger WHERE `m_mail`='$email'"));
                    $total_packs = $ttl['store_count'];

                    $n_p = $total_packs + 1;
                    mysqli_query($conn,"UPDATE maneger SET `store_count`='$n_p' WHERE `m_mail`='$email'");

                    header('location: m-storage-accept.php?value=ok');
                else:
                    array_push($errors, "Something is missing in action! Please check invoice code and other.");
                endif;
            endif;
        else:
            array_push($errors, "Invoice code is not valid for this product! Please check the company invoice.");
        endif;
    endif;
endif;
?>
<div class="container">

    <?php if (count($success) > 0): ?>
        <?php foreach ($success as $suc): ?>
            <div class="form-group" style="margin-top: 10px;">
                <p class="alert alert-success"><?php echo $suc; ?></p>
            </div>
        <?php endforeach ?>
    <?php endif; ?>

    <?php if (count($errors) > 0): ?>
        <?php foreach ($errors as $err): ?>
            <div class="form-group" style="margin-top: 10px;">
                <p class="alert alert-danger"><?php echo $err; ?></p>
            </div>
        <?php endforeach ?>
    <?php endif; ?>

    <div class="card" id="table" style="margin-top:10px; padding-left: 13px; padding-right: 13px;">
        <div class="card-body" style=" padding: 0px !important;">
            <h4 class="card-title" style="margin-bottom: 0 !important; margin-top: 10px;">Receiving Process</h4>
        </div>
        <table class="table table-striped table-dark" id="mytable" style="margin-top: 15px; text-align: center">
            <thead>
            <tr>
                <th scope="col">PACK ID</th>
                <th style="width: 150px" scope="col">PACK NAME</th>
                <th style="width: 300px" scope="col">PACK DESCRIPTION</th>
                <th style="width: 150px" scope="col">PACK TYPE</th>
                <th style="width: 200px" scope="col">COMPANY NAME</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($rows = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $rows['pack_id']; ?></td>
                    <td style="width: 150px"><?php echo $rows['name']; ?></td>
                    <td style="width: 300px"><?php echo $rows['short_details'] ?></td>
                    <td style="width: 150px"><?php echo $rows['pack_type']; ?></td>
                    <td style="width: 200px"><?php echo $rows['company_name']; ?></td>
                    <td>
                        <button type="button" id="<?php echo $rows['pack_id']; ?>"
                                class="btn btn-primary btn-sm view_data">MORE <i class="fas fa-chevron-circle-down"></i>
                        </button>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        //rest data finding with item code
        $(document).on('click', '.view_data', function () {
            var pack = $(this).attr('id');
            //alert(pack);
            $.ajax({
                url: "load_data.php",
                method: "POST",
                data: {pack: pack},
                success: function (data) {
                    $('#selection').html(data);
                }
            });
        });

        //hiding the content
        jQuery(document).ready(function () {
            $('#content').hide();
            jQuery(".view_data").on('click', function (event) {
                jQuery('#content').toggle('show');
            });
        });

        //row finding
        $(document).ready(function () {
            $('#caveName').change(function () {
                var row = $(this).val();
                $.ajax({
                    url: "load_data.php",
                    method: "POST",
                    data: {row: row},
                    success: function (data) {
                        $('#rowName').html(data);
                    }
                });
            });
        });
    </script>


    <div class="card" id="content" style="margin-top: 10px; padding: 15px;">
        <h4 class="card-title" style="text-align: center; margin-bottom: 0 !important; margin-top: 10px;">Stroring
            Proccess</h4>
        <form action="m-storage-accept.php" method="post">
            <div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="universityName">Enter the invoice code</label>
                            <input type="text" class="form-control" name="invoice_code" placeholder="10001">
                            <small style="color: #CC0000">**This is very important code. Do not enter any single item
                                without a valid invoice code.
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="universtyName">Select a cave name name</label>
                            <select class="form-control" id="caveName" name="caveName">
                                <option value="NULL" selected hidden>Select one...</option>
                                <?php echo fill_cave_name($conn); ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="universtyName">Select a cave name name</label>
                            <select class="form-control" id="rowName" name="rowName">
                                <option value="NULL" selected hidden>Select one...</option>
                            </select>
                        </div>

                        <div id="selection">

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div id="rest">
                        </div>
                    </div>
                </div>
            </div>
            <div style="text-align: center;">
                <input type="submit" class="btn btn-success btn-lg" name="store_pack" value="Done">
            </div>
        </form>
    </div>

    <br> <br>
    <br> <br>


    <script>
        //this is the storage progressbar
        $(document).ready(function () {
            $('#caveName').change(function () {
                var cave = $(this).val();
                $.ajax({
                    url: "test_data.php",
                    method: "POST",
                    data: {cave: cave},
                    success: function (data) {
                        $('#rest').html(data);
                    }
                });
            });
        });//ends here

        //this is for row details
        $(document).ready(function () {
            $('#rowName').change(function () {
                var c = $(this).val();
                $.ajax({
                    url: "test_data.php",
                    method: "POST",
                    data: {row: c},
                    success: function (data) {
                        $('#rest').html(data);
                    }
                });
            });
        });//ends here

    </script>
</div>

<?php include 'm-footer.php'?>

