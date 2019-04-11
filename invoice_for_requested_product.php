<?php
include 'database_connection.php';

if(!isset($_SESSION)):
    session_start();
endif;

$email = $_SESSION['email'];

$count = $_POST['id_invo'];
$company_id = $_POST['id_dir'];


$rows = mysqli_fetch_array(mysqli_query($conn,"SELECT id FROM posts WHERE id = $company_id AND id IS NOT NULL LIMIT 1"),
    MYSQLI_ASSOC);
if ($rows) { /* Table is not empty */

//seting the invoce code to the requested table
    $sql = "SELECT * FROM `request_item`";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)):
        $id = $row['id'];
        $s = "UPDATE `request_item` SET invoice_id='$count' WHERE id='$id'";
        mysqli_query($conn, $s);
    endwhile;

//finding all things on a company
    $sql_id = "SELECT * FROM users WHERE id='$company_id'";
    $usernameQuery = mysqli_query($conn, $sql_id);
    $rows = mysqli_fetch_assoc($usernameQuery);
    $name = $rows['user_name'];
    $company_email = $rows['user_email'];
    $company_address = $rows['user_address_one'];
    $phone = $rows['user_phone_number'];

//finding total ivoice item
    $s = "SELECT * FROM `request_item` WHERE company_id= '$company_id'";
    $r = mysqli_query($conn, $s);
    $total = mysqli_num_rows($r);

//insert into invoice_requested table
    $sql_invoice = "INSERT INTO invoice_requested(invoice_id,total_item,company_name) VALUES ('$count', '$total', '$name')";
    mysqli_query($conn, $sql_invoice);

//cuurent date allocator
    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
    $date = $dt->format('Y/m/d');
    $time = $dt->format('h:i:s');

//starting dynamic pdf creation
    require 'C:\xampp\htdocs\test\fpdf181\fpdf.php';

    $pdf = new FPDF('p', 'mm', 'A4');

    $pdf->AddPage();

    $pdf->SetFont('Arial', 'B', 18);

//Cell(width , height , text , border , end line , [align] )

    $pdf->Cell(130, 5, 'We-Warehouse', 0, 0);
    $pdf->Cell(59, 5, 'INVOICE', 0, 1);//end of line

//set font to arial, regular, 12pt
    $pdf->SetFont('Arial', '', 12);

    $pdf->Cell(59, 5, '', 0, 1);//end of line

    $pdf->Cell(130, 5, '3/A, Dhaanmondi-15', 0, 0);
    $pdf->Cell(25, 5, 'Date', 0, 0);
    $pdf->Cell(34, 5, $date, 0, 1);//end of line

    $pdf->Cell(130, 5, 'Dhaka-1215, Bangladesh', 0, 0);
    $pdf->Cell(25, 5, 'Invoice No.', 0, 0);
    $pdf->Cell(34, 5, $count, 0, 1);//end of line

    $pdf->Cell(130, 5, 'Phone No [+8801723334556]', 0, 0);
    $pdf->Cell(25, 5, 'Company ID', 0, 0);
    $pdf->Cell(34, 5, $company_id, 0, 1);//end of line

    $pdf->Cell(130, 5, 'Email [we.support@master.com]', 0, 0);

//make a dummy empty cell as a vertical spacer
    $pdf->Cell(189, 10, '', 0, 1);//end of line

//billing address
    $pdf->Cell(100, 5, 'Sender Details', 0, 1);//end of line

//add dummy cell at beginning of each line for indentation
    $pdf->Cell(10, 5, '', 0, 0);
    $pdf->Cell(90, 5, $name, 0, 1);

    $pdf->Cell(10, 5, '', 0, 0);
    $pdf->Cell(90, 5, $company_address, 0, 1);

    $pdf->Cell(10, 5, '', 0, 0);
    $pdf->Cell(90, 5, 'Phone No [' . $phone . ']', 0, 1);

    $pdf->Cell(10, 5, '', 0, 0);
    $pdf->Cell(90, 5, 'Email [' . $company_email . ']', 0, 1);

//make a dummy empty cell as a vertical spacer
    $pdf->Cell(189, 10, '', 0, 1);//end of line

//invoice contents
    $pdf->SetFont('Arial', 'B', 12);

    $pdf->Cell(25, 5, 'Pack ID', 1, 0, 'C');
    $pdf->Cell(60, 5, 'Pack Name', 1, 0, 'C');
    $pdf->Cell(60, 5, 'Manufacturer', 1, 0, 'C');
    $pdf->Cell(20, 5, 'Amount', 1, 0, 'C');
    $pdf->Cell(20, 5, 'Unit', 1, 1, 'C');//end of line

    $pdf->SetFont('Arial', '', 10);

//Numbers are right-aligned so we give 'R' after new line parameter
    $data_query = "SELECT * FROM `request_item`";
    $result = mysqli_query($conn, $data_query);
    while ($row = mysqli_fetch_array($result)):
        $pdf->Cell(25, 5, $row['pack_id'], 1, 0, 'C');
        $pdf->Cell(60, 5, $row['pack_name'], 1, 0, 'C');
        $pdf->Cell(60, 5, $row['pack_manufacturer'], 1, 0, 'C');
        $pdf->Cell(20, 5, $row['pack_quantity'], 1, 0, 'C');
        $pdf->Cell(20, 5, $row['pack_unit'], 1, 1, 'C');//end of line
    endwhile;

//summary
    $pdf->Cell(30, 5, '', 0, 1, 'R');//end of line

    $pdf->Cell(130, 5, '', 0, 0);
    $pdf->Cell(25, 5, 'TOTAL ITEMS', 0, 0);
    $pdf->Cell(30, 5, $total, 1, 1, 'R');//end of line


//******EMAIL TO CLIENT*********//


    $subject = "WE Warehouse || Confirmation for Delivery Request";
    $message = "<div style='border: solid 5px #888; margin-left: 15rem; margin-right: 15rem;'>
                <div  style='background-color: #71bc37; height: 10rem; padding-top: 1rem;' align='center'>
                    <p style='color: #fff;'>Invoice Number</p>
                    <h1 style='color: #fff; font-size: 300%;'>$count</h1>
                </div>

                <div style='padding-left: 2rem;'>
                    <h4>Hello $name,</h4>
                    <p>This is a mail with PDF that send by WEWAREHOUSE make you sure that the request is confirm and it is in under proecessing.</p>
                    <p>Just dounload the PDF file bellow which can help you track down your records.</p>
                    <br>
                    <p>Thank you for using our servise.</p>
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
    $headers = "From: " . $from . $eol;
    $headers .= "MIME-Version: 1.0" . $eol;
    $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"";

// no more headers after this, we start the body! //
    $body = "--" . $separator . $eol;
    $body .= "Content-Transfer-Encoding: 7bit" . $eol . $eol;
    $body .= "--" . $separator . $eol;
    $body .= "Content-Type: text/html; charset=\"iso-8859-1\"" . $eol;
    $body .= "Content-Transfer-Encoding: 8bit" . $eol . $eol;
    $body .= $message . $eol;
    $body .= "--" . $separator . $eol;
    $body .= "Content-Type: application/octet-stream; name=\"" . $filename . "\"" . $eol;
    $body .= "Content-Transfer-Encoding: base64" . $eol;
    $body .= "Content-Disposition: attachment" . $eol . $eol;
    $body .= $attachment . $eol;
    $body .= "--" . $separator . "--";

// send message
    mail($company_email, $subject, $body, $headers);


//***************Mail To the agent*******************//

    $subject = "WE Warehouse || Customer Delivery Request";
    $message = "<div style='border: solid 5px #888; margin-left: 15rem; margin-right: 15rem;'>
                <div  style='background-color: #71bc37; height: 10rem; padding-top: 1rem;' align='center'>
                    <p style='color: #fff;'>Invoice Number</p>
                    <h1 style='color: #fff; font-size: 300%;'>$count</h1>
                </div>

                <div style='padding-left: 2rem;'>
                    <h4>Hello Manager,</h4>
                    <p>This is a mail with PDF that have a request of the delivery. Follow the invoice to track down the company and the products.</p>
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
    $headers = "From: " . $from . $eol;
    $headers .= "MIME-Version: 1.0" . $eol;
    $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"";

// no more headers after this, we start the body! //
    $body = "--" . $separator . $eol;
    $body .= "Content-Transfer-Encoding: 7bit" . $eol . $eol;
    $body .= "--" . $separator . $eol;
    $body .= "Content-Type: text/html; charset=\"iso-8859-1\"" . $eol;
    $body .= "Content-Transfer-Encoding: 8bit" . $eol . $eol;
    $body .= $message . $eol;
    $body .= "--" . $separator . $eol;
    $body .= "Content-Type: application/octet-stream; name=\"" . $filename . "\"" . $eol;
    $body .= "Content-Transfer-Encoding: base64" . $eol;
    $body .= "Content-Disposition: attachment" . $eol . $eol;
    $body .= $attachment . $eol;
    $body .= "--" . $separator . "--";

// send message
    mail("saleh15-6124@diu.edu.bd", $subject, $body, $headers);


    $sql_copy = "INSERT INTO request_item_after SELECT * FROM request_item";
    mysqli_query($conn, $sql_copy);
    $sql_delete = "DELETE FROM request_item";
    mysqli_query($conn, $sql_delete);

    $tr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM transection WHERE company_id='$name'"));
    $am_total = $tr['transection_count'];

    $total_transection = $am_total + 1;
    mysqli_query($conn, "UPDATE transection SET `transection_count`='$total_transection' WHERE `user_name`='$name'");

    header("location: company_request_delivery.php?value=1");
} else {
    header("location: customer-request.php?value=3");
}

?>