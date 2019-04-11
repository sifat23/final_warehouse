<?php
include 'home_header.php';
include 'database_connection.php';

$errors = array();

$pack_Limit = "";
$item_Limit = "";
$community_Access = "";
$transport_Shipment = "";
$monthly_Status = "";
$phone_Support = "";
$bonus_Point = "";
$price = "";
$name = "";

if ($_GET['option'] == 1){
    $id = $_GET['id'];
    $row = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE id='$id'"));
    $user_name = $row['user_name'];
    $email = $row['user_email'];

    $pack_Limit = "5";
    $item_Limit = "1500";
    $community_Access = "Community Access Granted";
    $transport_Shipment = "10% Off";
    $monthly_Status = " Visible";
    $phone_Support = "Shared";
    $bonus_Point = "Every 6 Month";
    $price = 29.99;
    $name = "Primary Offers";
} elseif ($_GET['option'] == 2){
    $id = $_GET['id'];
    $row = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE id='$id'"));
    $user_name = $row['user_name'];
    $email = $row['user_email'];

    $pack_Limit = "15";
    $item_Limit = "7000";
    $community_Access = "Community Access Granted";
    $transport_Shipment = "20% Off";
    $monthly_Status = " Visible";
    $phone_Support = "Shared";
    $bonus_Point = "Every Month";
    $price = 109.99;
    $name = "Standared Offers";
} elseif ($_GET['option'] == 3){
    $id = $_GET['id'];
    $row = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE id='$id'"));
    $user_name = $row['user_name'];
    $email = $row['user_email'];

    $pack_Limit = "25";
    $item_Limit = "15000";
    $community_Access = "Community Access Granted";
    $transport_Shipment = "Free";
    $monthly_Status = " Visible";
    $phone_Support = "Dedicated";
    $bonus_Point = "Every Week";
    $price = 299.99;
    $name = "Plus Offers";
} else {
    $id = $_GET['id'];
    $row = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE id='$id'"));
    $user_name = $row['user_name'];
    $email = $row['user_email'];

    $pack_Limit = "50";
    $item_Limit = "25000";
    $community_Access = "Community Access";
    $transport_Shipment = "Free";
    $monthly_Status = " Visible";
    $phone_Support = "Dedicated";
    $bonus_Point = "Every Day";
    $price = 489.99;
    $name = "Pro Offers";
}





if (isset($_POST['confirm'])):
    $user_name_new = $_POST['u_name'];
    $email_new = $email;
    $pay_process = $_POST['optradio'];
    $name_new = $_POST['p_name'];
    $amount = $_POST['amount'];
    $pack_Limit_new = $_POST['pack_lim'];
    $item_Limit_new = $_POST['item_lim'];

    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
    $date = $dt->format('Y-m-d');
    $exp_date = date('Y-m-d', strtotime($date. ' + 30 days'));



    if (empty($pay_process)):
        array_push($errors,"Payment method is empty. Please try again");
    endif;


    if (count($errors) == 0):
        mysqli_query($conn, "INSERT INTO payment(user_name,user_mail,reg_date,exp_date,packege_name,amount,process,pack_limit,item_limit)
                VALUES ('$user_name_new','$email_new','$date','$exp_date','$name_new','$amount','$pay_process','$pack_Limit_new','$item_Limit_new')");

        //?????? Mail ?????////

        $to      = $email_new; // Send email to our user
        $subject = "Confirmation | Payment"; // Give the email a subject
        $message = "
                <html>
                <head>
                    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                    <meta name='viewport' content='width=device-width'/>
                    <style type='text/css'>
                        * {
                            margin: 0;
                            padding: 0;
                            font-size: 100%;
                            font-family: 'Avenir Next', \"Helvetica Neue\", \"Helvetica\", Helvetica, Arial, sans-serif;
                            line-height: 1.65; }

                        img {
                            max-width: 100%;
                            margin: 0 auto;
                            display: block; }

                        body, .body-wrap {
                            width: 100% !important;
                            height: 100%;
                            background: #f8f8f8; }

                        a {
                            color: #71bc37;
                            text-decoration: none; }

                        a:hover {
                            text-decoration: underline; }

                        .text-center {
                            text-align: center; }

                        .text-right {
                            text-align: right; }

                        .text-left {
                            text-align: left; }

                        .button {
                            display: inline-block;
                            color: white !important;
                            background: #71bc37;
                            border: solid #71bc37;
                            border-width: 10px 20px 8px;
                            font-weight: bold;
                            border-radius: 4px; }

                        .button:hover {
                            text-decoration: none; }

                        h1, h2, h3, h4, h5, h6 {
                            margin-bottom: 20px;
                            line-height: 1.25; }

                        h1 { font-size: 32px; }
                        h2 { font-size: 28px; }
                        h3 { font-size: 24px; }
                        h4 { font-size: 20px; }
                        h5 { font-size: 16px; }

                        p, ul, ol {
                            font-size: 16px;
                            font-weight: normal;
                            margin-bottom: 20px; }

                        .container {
                            display: block !important;
                            clear: both !important;
                            margin: 0 auto !important;
                            max-width: 580px !important; }

                        .container table {
                            width: 100% !important;
                            border-collapse: collapse; }

                        .container .masthead {
                            padding: 80px 0;
                            background: #71bc37;
                            color: white; }

                        .container .masthead h1 { margin: 0 auto !important;
                            max-width: 90%;
                            text-transform: uppercase; }

                        .container .content {
                            background: white;
                            padding: 30px 35px; }

                        .container .content.footer { background: none; }

                        .container .content.footer p {
                            margin-bottom: 0;
                            color: #888;
                            text-align: center;
                            font-size: 14px; }

                        .container .content.footer a {
                            color: #888;
                            text-decoration: none;
                            font-weight: bold; }

                        .container .content.footer a:hover { text-decoration: underline; }
                    </style>
                </head>
                <body>
                <table class='body-wrap'>
                    <tr>
                        <td class='container'>
                            <table>
                                <tr>
                                    <td align='center' class='masthead'>
                                        <h1>We Warehouse</h1>
                                    </td>
                                </tr>
                                <tr>
                                    <td class='content'>
                                        <h2>Hi $user_name_new,</h2>
                                        <p>Yor are successfully activate the $name_new for this month.
                                            your expire date of this package is $exp_date.
                                            Do not Forget to pay bill monthly to continue this package.
                                            Now you can continue your storing process.</p>
                                        <br>
                                        <br>
                                        <p>Thank You<br>Authority</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class='container'>
                            <table>
                                <tr>
                                    <td class='content footer' align='center'>
                                        <p>Sent by <a href='#'>We Warehouse</a>, 31/1, Gulash Aavanue, Gulshan-2, Dhaka-1212</p>
                                        <p><a href='#'>Customer Care</a>| <a href='mailto:'>warehousewe3@gmail.com</a> | </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                </body>
                </html>
                ";

        $headers = "From: warehousewe3@gmail.com" . "\r\n";
        $headers .= "Reply-To: warehousewe3@gmail.com" . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        mail($to, $subject, $message, $headers); // Send our email

        header('Location: home.php?value=1');
    endif;
endif;
?>
<div>
    <div class="container">
        <div class="card" style="text-align: center; margin-top: 6rem; padding: 1rem; margin-bottom: 1rem">
           <h2>Payment Process</h2>
        </div>

        <div class="card d-flex" style="padding: 1rem">
            <div class="row">
                <div class="col-md-6" style="text-align: center">
                    <h4><?php echo $name; ?></h4>
                    <hr>
                    <p><i class="fas fa-check"></i> <?php echo $pack_Limit; ?> Packs Limits</p>
                    <p><i class="fas fa-check"></i> <?php echo $item_Limit; ?> Items Limits</p>
                    <p><i class="fas fa-check"></i> <?php echo $community_Access; ?></p>
                    <p><i class="fas fa-check"></i> <?php echo $transport_Shipment; ?> in Transport and Shipment</p>
                    <p><i class="fas fa-check"></i> Monthly <?php echo $monthly_Status; ?> Status</p>
                    <p><i class="fas fa-check"></i> <?php echo $phone_Support; ?> Phone Support</p>
                    <p><i class="fas fa-check"></i> Bonus Point in <?php echo $bonus_Point; ?></p>
                </div>
                <div class="col-md-6" style="text-align: center">
                    <h4><?php echo $user_name; ?></h4>
                    <?php if (count($errors) > 0): ?>
                        <?php foreach ($errors as $error): ?>
                            <p class="alert alert-danger" align="center" style="margin-bottom: 10px;"><?php echo $error; ?></p>
                        <?php endforeach ?>
                    <?php endif; ?>
                    <hr>
                    <p>Payment Method</p>
                    <form action="payment.php?option=<?php echo $_GET['option']; ?>&id=<?php echo $_GET['id']; ?>" method="post" onsubmit="return $.fn.myFunction()">
                        <input type="hidden" name="u_name" value="<?php echo $user_name; ?>">
                        <input type="hidden" name="p_name" value="<?php echo $name; ?>">
                        <input type="hidden" name="amount" value="<?php echo $price; ?>">
                        <input type="hidden" name="pack_lim" value="<?php echo $pack_Limit; ?>">
                        <input type="hidden" name="item_lim" value="<?php echo $item_Limit; ?>">
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="optradio" value="bkash">Bkash
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="optradio" value="rocket">Rocket
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="optradio" value="g-pay">G-pay
                            </label>
                        </div>

                       <div style="margin-top: 5px; padding-right: 5rem; padding-left: 5rem">
                           <div class="form-group">
                               <input type="email" class="form-control" value="<?php echo $email; ?>" readonly>
                           </div>
                       </div>

                        <div>
                            <h6><?php echo $price; ?><span class="period">/month</span></h6>
                        </div>

                        <div style="margin-top: 25px">
                            <button type="submit" class="btn btn-outline-secondary" name="confirm">Confirm Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

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
