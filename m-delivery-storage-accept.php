<?php
include 'm-header.php';
include 'database_connection.php';
if(!isset($_SESSION)):
    session_start();
endif;

$success = array();
//manager email
$email = $_SESSION['email'];

//manager id
$sql_name = "SELECT * FROM maneger WHERE m_mail='$email'";
$usernameQuery = mysqli_query($conn, $sql_name);
$row = mysqli_fetch_assoc($usernameQuery);
$manager_id = $row['id'];


if (isset($_GET['value']) == 1){
    array_push($success,"Request submitted properly.");
}

//selecting company
function fill_com_name($conn){
    $output = '';
    $sql = "SELECT * FROM `users`";
    $result = mysqli_query($conn, $sql);
    $output .= '<option value="NULL">Select a company name </option>';
    while($row = mysqli_fetch_array($result))
    {
        $output .= '<option value="'.$row["id"].'">'.$row["user_name"].'</option>';
    }
    return $output;
}


//for search bar action
if(isset($_POST['search'])):
    $valueToSearch = $_POST['valueToSearch'];
    // search in all table columns
    // using concat mysql function
    $query = "SELECT * FROM `packs` WHERE CONCAT(`pack_code`,`name`,`company_name`) LIKE '%".$valueToSearch."%'";
    $search_result = filterTable($query);
else:
    $query = "SELECT * FROM `packs`";
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


$dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
$date = $dt->format('Y-m-d');
$time = $dt->format('h:i:s');


if (isset($_POST['request'])):
    $pack_id = $_POST['pack_id'];
    $req_amount = $_POST['req_amount'];
    mysqli_query($conn,"INSERT INTO manager_temp (pack_code,pack_name,short_details,unit,pack_manufacturer,pack_type,request_date,request_time,accepted_date,accepted_time,company_id,company_name) 
          SELECT pack_code,`name`,short_details,unit,pack_manufacturer,item_type,requested_date,requested_time,`date`,`time`,company_id,company_name
          FROM packs WHERE pack_code='$pack_id'");
    mysqli_query($conn, "UPDATE manager_temp SET `amount`='$req_amount', `deliver_date`='$date', `deliver_time`='$time', `manager_id`='$manager_id'
      WHERE pack_code='$pack_id'");
endif;

if (isset($_POST['delete'])):
    $id = $_POST['gop_del'];
    mysqli_query($conn, "DELETE FROM manager_temp WHERE pack_code='$id'");
    header("location: m-delivery-storage-accept.php");
endif;

?>
    <div class="container-fluid">
        <?php if (count($success) > 0): ?>
            <?php foreach ($success as $suc): ?>
                <div class="form-group" style="text-align: center">
                    <p style="margin-left: 2rem; margin-right: 2rem;" class="alert alert-success"><?php echo $suc; ?></p>
                </div>
            <?php endforeach ?>
        <?php endif; ?>

        <div class="row justify-content-center" style="margin-left: 1px; margin-right: 3rem;">
            <div class="card col-lg-12" style="margin-top: 1rem; margin-bottom: 5px;">
                <div class="card-header" style="text-align: center; background: #A3E4D7;">
                    <p>What you looking for?</p>
                </div>
                <form action="m-delivery-storage-accept.php" method="post">
                    <div class="row">
                        <div class="col-lg-11" style="margin-top: 10px;">
                            <div class="form-group">
                                <input type="text" name="valueToSearch" class="form-control" placeholder="Type the item code here" style="text-align: center;">
                            </div>
                        </div>
                        <div class="col-lg-1" style="margin-top: 10px">
                            <input type="submit" name="search"class="btn btn-info btn-lg" value="Filter">
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
                    <tbody style="height: 450px">
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
                        $rest = mysqli_query($conn, "SELECT * FROM manager_temp");
                        while($rows = mysqli_fetch_assoc($rest)):
                            ?>
                            <tr>
                                <td class="nr"><?php echo $rows['pack_code'] ?></td>
                                <td><?php echo $rows['pack_name'] ?></td>
                                <td><?php echo $rows['amount'] ?></td>
                                <td><?php echo $rows['unit'] ?></td>
                                <form action="m-delivery-storage-accept.php" method="post">
                                    <input type="hidden" name="gop_del" value="<?php echo $rows['pack_code']; ?>">
                                    <td>
                                        <button type="submit" class="btn btn-outline-danger btn-sm" name="delete">D <i class="fas fa-minus-circle"></i></button>
                                    </td>
                                </form>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>

                    </table>

                    <div class="card-footer" align="center">
                        <form method="POST" action="invoice_for_deliverd_product.php" onsubmit="return $.fn.myFunction()">
                            <?php
                            $query = "SELECT invoice_id FROM `delevery_invoice` ORDER BY id DESC LIMIT 1";
                            $result_query = mysqli_query($conn, $query);
                            $r = mysqli_fetch_assoc($result_query);
                            $invoice_id = $r['invoice_id'];
                            ?>
                            <input type="hidden" name="id_invo" value="<?= $invoice_id + 1 ?>"/>
                            <div class="form-group">
                                <select class="form-control" name="id_com" id="id_com">
                                    <?php echo fill_com_name($conn); ?>
                                </select>
                            </div>
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
                        url:"more_data.php",
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
                    <form action="m-delivery-storage-accept.php" method="post">
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
    <br><br><br><br>
    <br><br><br><br>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body" style="height: 15rem">
                    <div id="circle">
                        <div class="loader-pro">
                            <div class="loader-plus">
                                <div class="loader-noob">
                                    <div class="loader-pop"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-md-center" style="margin-top: 1rem">
                        <h4>Processing</h4>
                    </div>
                    <div class="row justify-content-md-center">
                        <small>Please Wait...</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $.fn.myFunction = function() {
                $("#myModal").modal({
                    backdrop: "static", //remove ability to close modal with click
                    keyboard: false, //remove option to close with keyboard
                    show: true //Display loader!
                });
                setTimeout(function() {
                    $("#myModal").modal("hide");
                    $('.modal-backdrop').remove();
                }, 15500);
                return true;
            }
        });
    </script>



<?php
include 'm-footer.php';
?>