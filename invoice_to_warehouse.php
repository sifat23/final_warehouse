<?php
include 'database_connection.php';

//session activated
if(!isset($_SESSION)):
    session_start();
endif;

//company emali
$email = $_SESSION['email'];

//comapny id and invoice
$count = $_POST['id_invo'];
$company_id = $_POST['id_dir'];

//$rows = mysqli_fetch_array(mysqli_query($conn,"SELECT id FROM posts WHERE id = $company_id AND id IS NOT NULL LIMIT 1"), MYSQLI_ASSOC);
//
//if ($rows) { /* Table is not empty */


//updating invoice code to every data set
    $sql = "SELECT * FROM `customer_request`";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)):
        $id = $row['id'];
        $s = "UPDATE `customer_request` SET invoice_code='$count' WHERE id='$id'";
        mysqli_query($conn,$s);
    endwhile;

    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
    $date = $dt->format('Y/m/d');
    $time = $dt->format('h:i:s');
    $month_name = strtolower(date("F", strtotime($date)));


//company details
    $sql_id = "SELECT * FROM users WHERE id='$company_id'";
    $usernameQuery = mysqli_query($conn, $sql_id);
    $rows = mysqli_fetch_assoc($usernameQuery);
    $name = $rows['user_name'];
    $company_email = $rows['user_email'];
    $company_address = $rows['user_address_one'];
    $phone = $rows['user_phone_number'];

    $s = "SELECT * FROM `customer_request` WHERE company_id= '$company_id'";
    $r = mysqli_query($conn, $s);
    $total = mysqli_num_rows($r);

    $sql_invoice = "INSERT INTO invoice(invoice_id,total_item,company_name) VALUES ('$count', '$total', '$name')";
    mysqli_query($conn, $sql_invoice);


//limit storage for companies
    $ttl = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM limit_package WHERE `name`='$month_name'"));
    $total_packs = $ttl[$name.'._packs'];
    $total_items = $ttl[$name.'._items'];

//total item from company
    $result = mysqli_query($conn,"SELECT * FROM customer_request WHERE company_id='$company_id'");
    $num = mysqli_num_rows($result);

//total item count from company
    $sum = mysqli_query($conn, "SELECT SUM(amount) AS value_sum FROM customer_request WHERE company_id='$company_id'");
    $r = mysqli_fetch_assoc($sum);
    $amount_total = $r['value_sum'];

    $n_p = $total_packs + $num;
    $n_i = $total_items + $amount_total;
    mysqli_query($conn,"UPDATE limit_package SET `$name._packs`='$n_p',`$name._items`='$n_i' WHERE `name`='$month_name'");


    require 'C:\xampp\htdocs\test\fpdf181\fpdf.php';

    $pdf = new FPDF('p','mm','A4');

    $pdf->AddPage();

    $pdf->SetFont('Arial','B',18);

//Cell(width , height , text , border , end line , [align] )

    $pdf->Cell(130 ,5,'We-Warehouse',0,0);
    $pdf->Cell(59 ,5,'INVOICE',0,1);//end of line

//set font to arial, regular, 12pt
    $pdf->SetFont('Arial','',12);

    $pdf->Cell(59 ,5,'',0,1);//end of line

    $pdf->Cell(130 ,5,'3/A, Dhaanmondi-15',0,0);
    $pdf->Cell(25 ,5,'Date',0,0);
    $pdf->Cell(34 ,5,$date,0,1);//end of line

    $pdf->Cell(130 ,5,'Dhaka-1215, Bangladesh',0,0);
    $pdf->Cell(25 ,5,'Invoice No.',0,0);
    $pdf->Cell(34 ,5,$count,0,1);//end of line

    $pdf->Cell(130 ,5,'Phone No [+8801723334556]',0,0);
    $pdf->Cell(25 ,5,'Company ID',0,0);
    $pdf->Cell(34 ,5,$company_id,0,1);//end of line

    $pdf->Cell(130 ,5,'Email [we.support@master.com]',0,0);

//make a dummy empty cell as a vertical spacer
    $pdf->Cell(189 ,10,'',0,1);//end of line

//billing address
    $pdf->Cell(100 ,5,'Sender Details',0,1);//end of line

//add dummy cell at beginning of each line for indentation
    $pdf->Cell(10 ,5,'',0,0);
    $pdf->Cell(90 ,5,$name,0,1);

    $pdf->Cell(10 ,5,'',0,0);
    $pdf->Cell(90 ,5,$company_address,0,1);

    $pdf->Cell(10 ,5,'',0,0);
    $pdf->Cell(90 ,5,'Phone No ['.$phone.']',0,1);

    $pdf->Cell(10 ,5,'',0,0);
    $pdf->Cell(90 ,5,'Email ['.$company_email.']',0,1);

//make a dummy empty cell as a vertical spacer
    $pdf->Cell(189 ,10,'',0,1);//end of line

//invoice contents
    $pdf->SetFont('Arial','B',12);

    $pdf->Cell(25 ,5,'Pack ID',1,0,'C');
    $pdf->Cell(60 ,5,'Pack Name',1,0,'C');
    $pdf->Cell(60 ,5,'Manufacturer',1,0,'C');
    $pdf->Cell(20 ,5,'Amount',1,0,'C');
    $pdf->Cell(20 ,5,'Unit',1,1,'C');//end of line

    $pdf->SetFont('Arial','',10);

//Numbers are right-aligned so we give 'R' after new line parameter
    $data_query = "SELECT * FROM `customer_request`";
    $result = mysqli_query($conn, $data_query);
    while($row = mysqli_fetch_array($result)):
        $pdf->Cell(25 ,5,$row['pack_id'],1,0,'C');
        $pdf->Cell(60 ,5,$row['name'],1,0,'C');
        $pdf->Cell(60 ,5,$row['pack_manufacturer'],1,0,'C');
        $pdf->Cell(20 ,5,$row['amount'],1,0,'C');
        $pdf->Cell(20 ,5,$row['unit'],1,1,'C');//end of line
    endwhile;

//summary
    $pdf->Cell(30 ,5,'',0,1,'R');//end of line

    $pdf->Cell(130 ,5,'',0,0);
    $pdf->Cell(25 ,5,'TOTAL ITEMS',0,0);
    $pdf->Cell(30 ,5,$total,1,1,'R');//end of line




//******EMAIL TO CLIENT*********//


    $subject = "WE Warehouse || Request Confirmation for Request";
    $message = "<div style='border: solid 5px #888; margin-left: 15rem; margin-right: 15rem;'>
                <div  style='background-color: #71bc37; height: 10rem; padding-top: 1rem;' align='center'>
                    <p style='color: #fff;'>Invoice Number</p>
                    <h1 style='color: #fff; font-size: 300%;'>$count</h1>
                </div>

                <div style='padding-left: 2rem;'>
                    <h4>Hello $name,</h4>
                    <p>This is a mail with PDF that send by the otherity of the website and make you that the request is confirm and it is in under proecessing.</p>
                    <p>Just dounload the PDF file bellow which can help you track down your records.</p>
                    <br>
                    <p>Thank you for using our servise.</p>
                    <p>Good to see you</p>
                    <div style='padding-right: 2rem;' align='right'>
                        <h5><i>-Faithfull Othority</i></h5>
                    </div>
                </div>
            </div>";

    $separator = md5(time());
    $eol = PHP_EOL;
    $filename = "invoice-$count-$date.pdf";
    $pdfdoc = $pdf->Output("", "S");
    $attachment = chunk_split(base64_encode($pdfdoc));

// main header
    $headers  = "From: ".$from.$eol;
    $headers .= "MIME-Version: 1.0".$eol;
    $headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";

// no more headers after this, we start the body! //
    $body = "--".$separator.$eol;
    $body .= "Content-Transfer-Encoding: 7bit".$eol.$eol;
    $body .= "--".$separator.$eol;
    $body .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
    $body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
    $body .= $message.$eol;
    $body .= "--".$separator.$eol;
    $body .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol;
    $body .= "Content-Transfer-Encoding: base64".$eol;
    $body .= "Content-Disposition: attachment".$eol.$eol;
    $body .= $attachment.$eol;
    $body .= "--".$separator."--";

// send message
    mail($company_email, $subject, $body, $headers);


//***************Mail To the agent*******************//

    $subject = "WE Warehouse || Managers";
    $message = "<div style='border: solid 5px #888; margin-left: 15rem; margin-right: 15rem;'>
                <div  style='background-color: #71bc37; height: 10rem; padding-top: 1rem;' align='center'>
                    <p style='color: #fff;'>Invoice Number</p>
                    <h1 style='color: #fff; font-size: 300%;'>$count</h1>
                </div>

                <div style='padding-left: 2rem;'>
                    <h4>Hello Manager,</h4>
                    <p>This is a mail with PDF that send by the otherity of the website and make you sure that the request is confirm and it is in under proecessing.</p>
                    <p>Just insert the request data with appropriate invoice form id. Otherwise no data will be save in the storage server.</p>
                    <br>
                    <p>Good to see you</p>
                    <div style='padding-right: 2rem;' align='right'>
                        <h5><i>-Faithfull Othority</i></h5>
                    </div>
                </div>
            </div>";

    $separator = md5(time());
    $eol = PHP_EOL;
    $filename = "invoice-$count-$date.pdf";
    $pdfdoc = $pdf->Output("", "S");
    $attachment = chunk_split(base64_encode($pdfdoc));

// main header
    $headers  = "From: ".$from.$eol;
    $headers .= "MIME-Version: 1.0".$eol;
    $headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";

// no more headers after this, we start the body! //
    $body = "--".$separator.$eol;
    $body .= "Content-Transfer-Encoding: 7bit".$eol.$eol;
    $body .= "--".$separator.$eol;
    $body .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
    $body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
    $body .= $message.$eol;
    $body .= "--".$separator.$eol;
    $body .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol;
    $body .= "Content-Transfer-Encoding: base64".$eol;
    $body .= "Content-Disposition: attachment".$eol.$eol;
    $body .= $attachment.$eol;
    $body .= "--".$separator."--";

// send message
    mail("saleh15-6124@diu.edu.bd", $subject, $body, $headers);

    $sql_copy = "INSERT INTO customer_request_after SELECT * FROM customer_request";
    mysqli_query($conn,$sql_copy);
    $sql_delete ="DELETE FROM customer_request";
    mysqli_query($conn,$sql_delete);

    //total traansection count
    $tr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM transection WHERE company_id='$name'"));
    $am_total = $tr['transection_count'];

    $total_transection = $am_total + 1;
    mysqli_query($conn,"UPDATE transection SET `transection_count`='$total_transection' WHERE `user_name`='$name'");

    header("location: customer-request.php?value=1");

//} else {
//    header("location: customer-request.php?value=3");
//}

?>