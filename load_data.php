<?php
    //load_data.php
    include 'database_connection.php';

    $output = '';
    if(isset($_POST["type"])):
        if($_POST["type"] != ''):
            $sql = "SELECT * FROM cave WHERE cave_type = '".$_POST["type"]."'";
        else:
            $sql = "SELECT * FROM cave";
        endif;
        $result = mysqli_query($conn, $sql);
        $output = '<option value="NULL" selected hidden>Select one...</option>';
        while($row = mysqli_fetch_array($result)):
            $id = $row['id'];
            $s = "SELECT * FROM `rows` WHERE cave_id ='$id' AND cave_type= '".$_POST["type"]."'";
            $r = mysqli_query($conn,$s);
            $num_rows = mysqli_num_rows($r);
            $empty_rows = 5 - $num_rows;
            $output .= '<option value="'.$row["id"].'">'.$row["cave_name"].': '.$empty_rows.' </option>';
        endwhile;
        echo $output;
    endif;

    if(isset($_POST["row"])):
        if($_POST["row"] != ''):
            $sql = "SELECT * FROM `rows` WHERE `cave_id` = '".$_POST["row"]."'";
        else:
            $sql = "SELECT * FROM `rows`";
        endif;
        $result = mysqli_query($conn, $sql);
        $output = '<option value="NULL" selected hidden>Select one...</option>';
        while($row = mysqli_fetch_array($result)):
            $id = $row['id'];
            $s = "SELECT * FROM `boxs` WHERE row_id= '$id'";
            $r = mysqli_query($conn,$s);
            $num_rows = mysqli_num_rows($r);
            $empty_rows = 5 - $num_rows;
            $output .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
        endwhile;
        echo $output;
    endif;

    if(isset($_POST["box"])):
        if($_POST["box"] != ''):
            $sql = "SELECT * FROM `boxs` WHERE `row_id` = '".$_POST["box"]."'";
        else:
            $sql = "SELECT * FROM `boxs`";
        endif;
        $result = mysqli_query($conn, $sql);
        $output = '<option selected hidden>Select one...</option>';
        while($row = mysqli_fetch_array($result)):
            $id = $row['id'];
            $s = "SELECT * FROM `files` WHERE box_id= '$id'";
            $r = mysqli_query($conn,$s);
            $num_rows = mysqli_num_rows($r);
            $empty_rows = 5 - $num_rows;
            $output .= '<option value="'.$row["id"].'">'.$row["name"].' : '.$empty_rows.' </option>';
        endwhile;
        echo $output;
    endif;

    if(isset($_POST["code"])):
        if($_POST["code"] != ''):
            $c = $_POST["code"];
            $sql = "SELECT * FROM `packs` WHERE pack_code='$c'";
        else:
            $sql = "SELECT * FROM `packs`";
        endif;
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_array($result)):
            $invoice = $row['invoice_code'];
            $code = $row['pack_code'];
            $name = $row['name'];
            $des = $row['short_details'];
            $rowid = $row['row_id'];
            $cave = $row['cave_id'];
            $time = $row['time'];
            $date = $row['date'];
            $quantity = $row['amount'];
            $unit = $row['unit'];

            echo "<table>";
            echo "<tr> ";
            echo "<td>Invoice Serial </td>";
            echo "<td>&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;$invoice</td>";
            echo "</tr>";

            echo "<tr> ";
            echo "<td>Pack Code</td>";
            echo "<td>&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;$code</td>";
            echo "</tr>";

            echo "<tr> ";
            echo "<td>Name</td>";
            echo "<td>&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;$name</td>";
            echo "</tr>";

            echo "<tr> ";
            echo "<td>Short Details</td>";
            echo "<td style='width: 300px;'>&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;$des</td>";
            echo "</tr>";

            echo "<tr> ";
            echo "<td>Row ID</td>";
            echo "<td>&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;$rowid</td>";
            echo "</tr>";

            echo "<tr> ";
            echo "<td>Cave ID</td>";
            echo "<td>&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;$cave</td>";
            echo "</tr>";

            echo "<tr> ";
            echo "<td>Entry Date</td>";
            echo "<td>&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;$date</td>";
            echo "</tr>";

            echo "<tr> ";
            echo "<td>Entry Time</td>";
            echo "<td>&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;$time</td>";
            echo "</tr>";

            echo "<tr> ";
            echo "<td>Total Item Number</td>";
            echo "<td>&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;$quantity</td>";
            echo "</tr>";

            echo "<tr> ";
            echo "<td>Item Unit</td>";
            echo "<td>&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp;$unit</td>";
            echo "</tr>";
            echo "</table>";


        endwhile;
        echo $output;
    endif;

    //for manager

    if(isset($_POST["pack"])):
        if($_POST["pack"] != ''):
            $c = $_POST["pack"];
            $sql = "SELECT * FROM `customer_request_after` WHERE pack_id='$c'";
        else:
            $sql = "SELECT * FROM `customer_request_after`";
        endif;
        $result = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_array($result)):
            $code = $row['pack_id'];
            $pack_name = $row['name'];
            $des = $row['short_details'];
            $type = $row['pack_type'];
            $com_id = $row['company_id'];
            $date = $row['input_date'];
            $time = $row['input_time'];
            $amount = $row['amount'];
            $unit = $row['unit'];
            $manu = $row['pack_manufacturer'];
            $com_name = $row['company_name'];

            echo "      <div class='form-group'>
                            <label for='disabledInput' class='control-label'>Pack Name</label>
                            <div >
                                <input class='form-control' name='pack_name' value='$pack_name' type='text'  readonly>
                            </div>
                        </div>
                        
                        <div class='form-group'>
                            <label for='disabledInput' class='control-label'>Pack ID Code</label>
                            <div>
                                <input class='form-control' name='pack_id' value='$code' type='text'  readonly>
                            </div>
                        </div>
                        
                        <div class='form-group'>
                            <label for='disabledInput' class='control-label'>Pack Amount</label>
                            <div>
                                <input class='form-control' name='pack_amount' value='$amount' type='number'  readonly>
                            </div>
                        </div>
                        
                        <div class='form-group'>
                            <label for='disabledInput' class='control-label'>Unit</label>
                            <div>
                                <input class='form-control' name='pack_unit' value='$unit' type='text'  readonly>
                            </div>
                        </div>
                        
                        <div class='form-group'>
                            <label for='disabledInput' class='control-label'>Manufacturer</label>
                            <div>
                                <input class='form-control' name='pack_menu' value='$manu' type='text'  readonly>
                            </div>
                        </div>
                        
                        <div class='form-group'>
                            <label for='disabledInput' class='control-label'>Pack Description</label>
                            <div>
                                <textarea class='form-control autosize-target text-left' name='description' rows='2' readonly>$des</textarea>
                            </div>
                        </div>
                        
                        <div class='form-group'>
                            <label for='disabledInput' class='control-label'>Pack Type</label>
                            <div>
                                <input class='form-control' name='pack_type' value='$type' id='disabledInput' type='text'  readonly>
                            </div>
                        </div>
                        
                        <div class='form-group'>
                            <label for='disabledInput' class='control-label'>Compnay Name</label>
                            <div>
                                <input class='form-control' name='company_name' value='$com_name' id='disabledInput' type='text'  readonly>
                            </div>
                        </div>
                        
                        <div class='form-group'>
                            <label for='disabledInput' class='control-label'>Company ID</label>
                            <div>
                                <input class='form-control' name='pack_com_id' value='$com_id' id='disabledInput' type='text'  readonly>
                            </div>
                        </div>
                        
                        <div class='form-group'>
                            <label for='disabledInput' class='control-label'>Date of Request</label>
                            <div>
                                <input class='form-control' name='pack_date' value='$date' id='disabledInput' type='text'  readonly>
                            </div>
                        </div>
                        
                        <div class='form-group'>
                            <label for='disabledInput' class='control-label'>Time of Request</label>
                            <div>
                                <input class='form-control' name='pack_time' value='$time' id='disabledInput' type='text'  readonly>
                            </div>
                        </div>                     
                      ";
        endwhile;
        echo $output;
    endif;

    //compnay_request_delivery
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
        echo $output;
    endif;
?>