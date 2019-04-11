<?php
include 'header.php';
include 'database_connection.php';

$success = array();
$errors = array();

if (isset($_POST['forget'])):
    $email = $_POST['company_email'];

    if (empty($email)):
        array_push($errors ,"Enter a valid mail first");
    endif;

    $user_check_query = "SELECT * FROM users WHERE user_email='$email' LIMIT 1";
    $result = mysqli_query($conn, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    if ($user): // if user exists
        if ($user['user_email'] === $email):
            $sql_name = "SELECT user_name FROM users WHERE user_email='$email'";
            $usernameQuery = mysqli_query($conn, $sql_name);
            $row = mysqli_fetch_assoc($usernameQuery);
            $username = $row['user_name'];

            $sql_token = "SELECT reg_token FROM users WHERE user_email='$email'";
            $tokenQuery = mysqli_query($conn, $sql_token);
            $rowt = mysqli_fetch_assoc($tokenQuery);
            $token = $rowt['reg_token'];
            //mail
            $to      = $email; // Send email to our user
            $subject = "Signup | Verification"; // Give the email a subject
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
                                        <h2>Hi $username,</h2>
                                        <p>We are glad for your comeback to our company. Please verify the mail with clicking the button bellow.</p>
                                        <table>
                                            <tr>
                                                <td align='center'>
                                                    <p>
                                                        <a href='localhost/test/forget_pass_mail.php?email=".$email."&hash=".$token."' class='button'>Verify Mail</a>
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
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

            array_push($success, "An Email has been sent to your mail account.");
        else:
            array_push($errors, "Invalid Mail Address");
        endif;
    endif;
endif;
?>
<div class="bg-local">
    <div class="container">
        <div class="row h-100 justify-content-center align-content-center">
            <div class="card col-md-6" style="background-color: lightseagreen; padding: 20px">

                <?php if (count($errors) > 0): ?>
                    <?php foreach ($errors as $error): ?>
                        <p class="alert alert-danger" align="center" style="margin-bottom: 1rem;"><?php echo $error; ?></p>
                    <?php endforeach ?>
                <?php endif ?>

                <?php if (count($success) > 0): ?>
                    <?php foreach ($success as $suc): ?>
                        <p class="alert alert-success" align="center" style="margin-bottom: 10px;"><?php echo $suc; ?></p>
                    <?php endforeach ?>
                <?php endif; ?>

                <form action="forget_pass.php" method="post">
                    <div class="form-group">
                        <label for="universtyName" style="color: white">Enter The Registerd Email</label>
                        <input type="text" class="form-control" name="company_email" placeholder="Havana_prop@example.com">
                        <div align="center" style="margin-top: 20px">
                            <button type="submit" name="forget" class="btn btn-secondary">Verify Mail</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
