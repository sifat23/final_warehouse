<?php
include 'home_header.php';
include 'database_connection.php';
if(!isset($_SESSION)):
    session_start();
endif;

$errors = array();
$success = array();

if (isset($_GET['value']) && $_GET['value'] == 1){
    array_push($success, "Your request has been submitted to the queue successfully. Check Mail");
}

if (isset($_GET['value']) && $_GET['value'] == 2){
    array_push($success, "Item Deleted successfully.");
}

$email = $_SESSION['email'];
$sql_name = "SELECT id FROM users WHERE user_email='$email'";
$usernameQuery = mysqli_query($conn, $sql_name);
$row = mysqli_fetch_assoc($usernameQuery);
$company_id = $row['id'];

//for search bar action
if(isset($_POST['search'])):
    $valueToSearch = $_POST['valueToSearch'];
    // search in all table columns
    // using concat mysql function
    $query = "SELECT * FROM `packs` WHERE company_id='$company_id' AND CONCAT(`pack_code`,`name`) LIKE '%".$valueToSearch."%'";
    $search_result = filterTable($query);
else:
    $query = "SELECT * FROM `packs` WHERE company_id='$company_id' ";
    $search_result = filterTable($query);
endif;

// function to connect and execute the query
function filterTable($query){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    $filter_Result = mysqli_query($conn, $query);
    return $filter_Result;
}


if (isset($_POST['request'])):
    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
    $date = $dt->format('Y-m-d');
    $time = $dt->format('h:i:s');
    $pack_id = $_POST['pack_id'];
    $req_amount = $_POST['req_amount'];
    mysqli_query($conn,"INSERT INTO request_item (pack_id,pack_name,company_id,pack_unit,company_name,pack_manufacturer,item_type) 
          SELECT pack_code, `name`, company_id, unit, company_name, pack_manufacturer,item_type
          FROM packs WHERE pack_code='$pack_id'");
    mysqli_query($conn, "UPDATE request_item SET pack_quantity='$req_amount', request_date='$date', request_time='$time'
      WHERE pack_id='$pack_id'");
endif;

if (isset($_POST['delete'])){
    $id = $_POST['gop_del'];
    mysqli_query($conn, "DELETE FROM request_item WHERE pack_id='$id'");
    header('Location: company_request_delivery.php?value=2');
}
?>
    <div class="container-fluid">
        <div class="row justify-content-center" style="margin-left: 1px; margin-right: 3rem;">
            <div class="card col-lg-12" style="margin-top: 5rem; margin-bottom: 5px;">
                <div class="card-header" style="text-align: center; background: #A3E4D7;">
                    <p>What you looking for?</p>
                </div>
                <form action="company_request_delivery.php" method="post">

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


                    <div class="row">
                        <div class="col-lg-10" style="margin-top: 10px;">
                            <div class="form-group">
                                <input type="text" name="valueToSearch" class="form-control" placeholder="Type the item code here" style="text-align: center;">
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <input type="submit" name="search" style="margin-left: 2.5rem;" class="btn btn-info" value="Filter">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row col-md-12" style="padding: 1rem">
            <div class="card col-md-6">
                <table class="table table-striped table-dark" style="margin-top: 15px; text-align: center">
                    <thead>
                    <tr>
                        <th scope="col">CODE</th>
                        <th scope="col">NAME</th>
                        <th style="width: 250px;" scope="col">DESCRIPTION</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while($rows = mysqli_fetch_assoc($search_result)): ?>
                        <tr>
                            <td class="nr"><?php echo $rows['pack_code'] ?></td>
                            <td><?php echo $rows['name']; ?></td>
                            <td style="width: 250px;" ><?php echo $rows['short_details']; ?></td>
                            <td>
                                <button type="button" class="btn btn-secondary btn-sm view_data" data-toggle="modal" data-target="#exampleModalrequest">REQUEST <i class="fas fa-exchange-alt"></i></button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="col-md-6">
                <div class="card" id="content" style="padding-left: 1rem; padding-right: 1rem;">
                    <h3 class="card-title" style="margin-top: 1rem; ">Request Table</h3>
                    <table class="table table-striped table-dark" style="margin-top: 15px; text-align: center">
                        <thead>
                        <tr>
                            <th scope="col">PACK ID</th>
                            <th scope="col">PACK NAME</th>
                            <th scope="col">QANTITY</th>
                            <th scope="col">UNIT</th>
                        </tr>
                        </thead>

                        <tbody style="height: 280px !important;">
                        <?php
                            $result = mysqli_query($conn,"SELECT * FROM request_item WHERE company_id='$company_id'");
                            while($rows = mysqli_fetch_assoc($result)):
                        ?>
                            <tr>
                                <td class="nr"><?php echo $rows['pack_id'] ?></td>
                                <td><?php echo $rows['pack_name'] ?></td>
                                <td><?php echo $rows['pack_quantity'] ?></td>
                                <td><?php echo $rows['pack_unit'] ?></td>
                                <form action="company_request_delivery.php" method="post">
                                    <input type="hidden" name="gop_del" value="<?php echo $rows['pack_id']; ?>">
                                    <td>
                                        <button type="submit" class="btn btn-outline-danger btn-sm view_data" name="delete">Delete</button>
                                    </td>
                                </form>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>

                    </table>

                    <div class="card-footer" align="center">
                        <form method="POST" action="invoice_for_requested_product.php">
                            <?php
                            $query = "SELECT invoice_id FROM `invoice_requested` ORDER BY id DESC LIMIT 1";
                            $result_query = mysqli_query($conn, $query);
                            $r = mysqli_fetch_assoc($result_query);
                            $invoice_id = $r['invoice_id'];
                            ?>
                            <input type="hidden" name="id_invo" value="<?= $invoice_id + 1 ?>"/>
                            <input type="hidden" name="id_dir" value="<?= $company_id ?>"/>
                            <div align="center">
                                <button type="submit" class="btn btn-warning">SUBMIT</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <script>
            $(document).ready(function(){
                $(".view_data").click(function(){
                    var id = $(this).closest("tr");
                    var text = id.find(".nr").text();
                    //alert(text);
                    $.ajax({
                        url:"load_data.php",
                        method:"POST",
                        data:{del:text},
                        success:function(data){
                            $('#request').html(data);
                        }
                    });
                });
            });
        </script>



        <div class="modal fade" id="exampleModalrequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Item Details</h5>
                    </div>
                    <form action="company_request_delivery.php" method="post">
                        <div class="modal-body" id="request">
                        </div>
                        <div class="modal-footer">
                            <button type ="button" class ="btn btn-info" data-dismiss="modal">Close</button>
                            <button type ="submit" class="btn btn-secondary" name="request">Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br>



<?php
include 'user_footer.php';
?>