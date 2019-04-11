<?php
    ob_start();

    include 'home_header.php';
    include 'database_connection.php';
    if(!isset($_SESSION)):
        session_start();
    endif;

    $email = $_SESSION['email'];

    $errors = array();
    $success = array();

    if (isset($_GET['value']) && $_GET['value'] == 1){
        array_push($success, "Your request has been submitted to the queue successfully.");
    }

    if (isset($_GET['value']) && $_GET['value'] == 2){
        array_push($success, "Item Deleted successfully.");
    }

    if (isset($_GET['value']) && $_GET['value'] == 3){
        array_push($errors, "Empty Item Field Detected.");
    }
    //for username and id
    $sql_id = "SELECT * FROM users WHERE user_email='$email'";
    $usernameQuery = mysqli_query($conn, $sql_id);
    $rows = mysqli_fetch_assoc($usernameQuery);
    $username = $rows['user_name'];
    $company_id = $rows['id'];

    $sql = "SELECT * FROM customer_request WHERE company_id='$company_id'";
    $result = mysqli_query($conn, $sql);

    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
    $date = $dt->format('Y-m-d');
    $time = $dt->format('h:i:s');
    $month_name = strtolower(date("F", strtotime($date)));


    if (isset($_POST['pack_entry'])):
        $name = mysqli_real_escape_string($conn,$_POST['pack_name']);
        $description = mysqli_real_escape_string($conn,$_POST['description']);
        $code = mysqli_real_escape_string($conn,$_POST['pack_id']);
        $unit = mysqli_real_escape_string($conn,$_POST['pack_unit']);
        $amount = mysqli_real_escape_string($conn,$_POST['pack_amount']);
        $manufacturer = mysqli_real_escape_string($conn,$_POST['pack_maker']);
        $packType = mysqli_real_escape_string($conn,$_POST['packType']);

        //checking unique pack_id is exist
        $code_check_query = "SELECT * FROM `packs` WHERE pack_id='$code' LIMIT 1";
        $result = mysqli_query($conn, $code_check_query);
        $unique = mysqli_fetch_assoc($result);

        if ($unique):
            if ($unique['pack_id'] === $code):
                array_push($errors, "Pack ID already exists");
            endif;
        endif;//end here

        if (empty($code) || empty($description) || empty($name) || empty($amount) || $unit == 'NULL' || $packType == ('NULL') || empty($manufacturer)):
            array_push($errors,"Fields are enpty! Please fill up with appropriate data");
        endif;

        //limit storage for companies
        $ttl = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM limit_package WHERE `name`='$month_name'"));
        $total_packs = $ttl[$username.'._packs'];
        $total_items = $ttl[$username.'._items'];

        //getting expire packege
        $sql_payment = "SELECT * FROM payment WHERE user_mail='$email'";
        $usernameQuery = mysqli_query($conn, $sql_payment);
        $row = mysqli_fetch_assoc($usernameQuery);
        $ex_date = $row['exp_date'];
        $ex_pack_limit = $row['pack_limit'];
        $ex_itrm_imit = $row['item_limit'];

        $select = mysqli_query($conn,"SELECT * FROM payment WHERE user_mail='$email'");
        if(mysqli_num_rows($select)) {
            if ((time() - (60 * 60 * 24)) > strtotime($ex_date)) {
                array_push($errors, 'Your packege date has been expired. Please buy another package.');
            } else {
                if ($total_packs > $ex_pack_limit) {
                    array_push($errors, 'You reached the pack limit of your packege. Are you want to upgrade?.');
                } else {
                    if ($total_items > $ex_itrm_imit) {
                        array_push($errors, 'You reached at the item limits of your package.');
                    } else {
                        if (count($errors) == 0):
                            //for request to the manager for entry in warehouse
                            $amount = (int)$amount;
                            $sql_box = "INSERT INTO `customer_request`
 (`name`,pack_id,amount,short_details,pack_type,unit,pack_manufacturer,company_id,company_name,input_date,input_time) 
VALUES ('$name','$code','$amount','$description','$packType','$unit','$manufacturer','$company_id','$username','$date','$time')";
                            if (mysqli_query($conn, $sql_box) == true):
                                array_push($success, "Request submitted properly.");
                                header('Location: customer-request.php');
                            else:
                                array_push($errors, "Something is missing in action");
                            endif;
                        endif;
                    }
                }
            }
        } else {
            array_push($errors,"Please Buy a package. You haven't any yet.");
        }

    endif;



    if (isset($_POST['delete'])){
        $id = $_POST['gop_del'];
        mysqli_query($conn, "DELETE FROM customer_request WHERE pack_id='$id'");
        header('Location: customer-request.php?value=2');
    }
?>
    <div class="container-fluid">
        <div class="card" style="margin-top: 5rem;">
            <div style="height: 3rem;">
                <h4 align="center" style="margin-top: 7px">Request for the storage</h4>
            </div>
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
        </div>
        <div class="row" style="padding-left: 1rem;">
            <div class="card col-lg-5" style="margin-top: 1rem; padding-left: 1rem;">
                <div class="card-body">
                    <div class="card-body">
                        <form method="post" action="customer-request.php">
                            <div class="form-group">
                                <input type="text" placeholder="Enter item name" class="form-control" name="pack_name">
                            </div>

                            <div class="form-group">
                                <input type="text" placeholder="Enter item id (1000****)" maxlength="8" autocomplete="off" class="form-control" name="pack_id">
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" placeholder="Enter item amount" class="form-control" name="pack_amount">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" >
                                        <select class="form-control" id="pack_unit" name="pack_unit">
                                            <option value="NULL" selected hidden>Select item unit...</option>
                                            <option value="box">Box</option>
                                            <option value="pices">Pices</option>
                                            <option value="bottle">Bottle</option>
                                            <option value="case">Case</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="text" placeholder="Enter manufacturer name" class="form-control" name="pack_maker">
                            </div>

                            <div class="form-group" >
                                <select class="form-control" id="packType" name="packType">
                                    <option value="NULL" selected hidden>Select item type...</option>
                                    <option value="Electronic Devices"><p>Electronic Devices</p></option>
                                    <option value="Electronic Accessories">Electronic Accessories</option>
                                    <option value="TV & Home Appliances">TV & Home Appliances</option>
                                    <option value="Health & Beauty">Health & Beauty</option>
                                    <option value="Toys">Toys</option>
                                    <option value="Groceries">Groceries</option>
                                    <option value="Foods">Foods</option>
                                    <option value="Education">Education</option>
                                    <option value="Women's Fashion">Women's Fashion</option>
                                    <option value="Men's Fashion">Men's Fashion</option>
                                    <option value="Sports & Outdoor">Sports & Outdoor</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <textarea placeholder="Enter description (be very specific here)" name="description" rows="2" spellcheck="false" class="form-control autosize-target text-left"></textarea>
                            </div>

                            <div style="text-align: center">
                                <input type="submit" class="btn btn-success btn-lg" value="Insert" name="pack_entry">
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="col-md-7">
                <div class="card" id="content" style="margin-top:1rem; padding-left: 1rem; padding-right: 1rem;">
                    <h3 class="card-title" style="margin-top: 1rem; ">Queue Table</h3>
                    <table class="table table-striped table-dark" style="margin-top: 15px; text-align: center">
                        <thead>
                        <tr>
                            <th scope="col">PACK ID</th>
                            <th style="width: 190px;" scope="col">PACK TYPE</th>
                            <th style="width: 170px" scope="col">PACK NAME</th>
                            <th scope="col">DATE</th>
                        </tr>
                        </thead>

                            <tbody style="height: 280px !important;">
                            <?php while($rows = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td class="nr"><?php echo $rows['pack_id'] ?></td>
                                    <td style="width: 190px;"><?php echo $rows['pack_type']; ?></td>
                                    <td style="width: 170px;"><?php echo $rows['name'] ?></td>
                                    <td><?php echo $rows['input_date'] ?></td>
                                    <form action="customer-request.php" method="post">
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
                        <form method="POST" action="invoice_to_warehouse.php" onsubmit="return $.fn.myFunction()">
                            <?php
                                $query = "SELECT invoice_id FROM `invoice` ORDER BY id DESC LIMIT 1";
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
    </div><br><br>
    <br><br><br>

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
include 'user_footer.php';
?>