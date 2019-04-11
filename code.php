<?php
    include 'database_connection.php';
    if(!isset($_SESSION)):
        session_start();
    endif;

    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
    $date = $dt->format('Y-m-d');
    $time = $dt->format('h:i:s');

    $t = "";

    if (isset($_SESSION['type'])):
        $t = $_SESSION['type'];
    endif;
    if ($t == "user"):
        header("location: home.php");
    endif;
    if ($t == "manager"):
        header("location: m-index.php");
    endif;
    if ($t == "admin"):
        header("location: admin.php");
    endif;

    $email = "";
    $name = "";
    $errors = array();
    $success = array();

    if (isset($_POST['submit'])):
        $username = $conn->real_escape_string($_POST['user_name']);
        $email =  $conn->real_escape_string($_POST['user_email']);
        $address_one = $conn->real_escape_string($_POST['address_one']);
        $address_two = $conn->real_escape_string($_POST['address_two']);
        $user_phone_number = $conn->real_escape_string($_POST['user_phone_number']);
        $previlage = $conn->real_escape_string($_POST['user_previlage']);
        $newPassword =  $conn->real_escape_string($_POST['new_password']);
        $confirmPassword =  $conn->real_escape_string($_POST['confirm_password']);

        //if boxes are empty
        if (empty($username) || empty($email) || empty($newPassword) || empty($address_one) || empty($address_two) || empty($user_phone_number) || $previlage == ('NULL')):
            array_push($errors,"You myst provide username, email and password");
        endif;

        if ($newPassword != $confirmPassword):
            array_push($errors,"Password does not match! Try again.");
        endif;

        $token = 'qwertzuiopasdfghjklyxcvbnmQWERTZUIOPASDFGHJKLYXCVBNM0123456789!$/()*';
        $token = str_shuffle($token);
        $token = substr($token, 0, 7);

        //username and email checking
        $user_check_query = "SELECT * FROM users WHERE user_name='$username' OR user_email='$email' OR reg_token='$token' LIMIT 1";
        $result = mysqli_query($conn, $user_check_query);
        $user = mysqli_fetch_assoc($result);
        if ($user): // if user exists
            if ($user['user_email'] === $email):
                array_push($errors, "Email is already exists");
            endif;
        endif;

        //if all are ok then insert into database sign in
        if(count($errors) == 0):
            $password = md5($confirmPassword);
            $sql = "INSERT INTO users (user_name,user_email,user_password,reg_token,user_previlege,user_address_one,user_address_two,user_phone_number,`reg_date`) VALUES ('$username', '$email', '$password', '$token',  '$previlage', '$address_one', '$address_two', '$user_phone_number','$date')";
            mysqli_query($conn,$sql);

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
                                        <p>We are glad to welcome you to our company. Please complete the signin process by clicking the button bellow.</p>
                                        <table>
                                            <tr>
                                                <td align='center'>
                                                    <p>
                                                        <a href='localhost/test/verify.php?email=".$email."&hash=".$token."' class='button'>Verify Mail</a>
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

            array_push($success, "An Email has been sent to your mail account. please verify the account to login.");
        endif;
    endif;


    if (isset($_POST['login'])):
        $type = $_POST['loginType'];
        $email =  mysqli_real_escape_string($conn, $_POST[ 'company_email']);
        $logPassword =  mysqli_real_escape_string($conn, $_POST['password']);

        if (empty($email)):
            array_push($errors,"Type a registerd email address");
        endif;
        if (empty($logPassword)):
            array_push($errors,"Password is required");
        endif;

        if ($type == "manager"):
            $test = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM maneger WHERE m_mail='$email'"));
            $active = $test['active'];
            if ($active == 0):
                array_push($errors,"Account has not been verified. Please verify first");
            endif;
            if (count($errors) == 0):
                $pass = md5($logPassword);
                $sql = "SELECT * FROM maneger WHERE m_mail='$email' AND m_pass='$logPassword'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result)):
                    $_SESSION['email'] = $email;
                    $_SESSION['type']= $type ;
                    header('location: m-index.php');//redirect to manager homepage
                else:
                    array_push($errors, "Invalid email and password!");
                endif;
            endif;
        elseif ($type == "user"):
            $test = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE user_email='$email'"));
            $active = $test['active'];
            if ($active == 0):
                array_push($errors,"Account has not been verified. Please verify first");
            endif;

             if (count($errors) == 0):
                 $pass = md5($logPassword);
                 $sql = "SELECT * FROM users WHERE user_email='$email' AND user_password='$pass'";
                 $result = mysqli_query($conn, $sql);
                 if (mysqli_num_rows($result)):
                     $_SESSION['email'] = $email;
                     $_SESSION['type'] = $type;
                     header('location: home.php'); //redirect to user homepage
                 else:
                     array_push($errors, "Invalid email and password!");
                 endif;
             endif;
        elseif ($type == "admin"):
            if (count($errors) == 0):
                $sql = "SELECT * FROM admin WHERE email='$email' AND password='$logPassword'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result)):
                    $_SESSION['email'] = $email;
                    $_SESSION['type'] = $type;
                    header('location: admin.php'); //redirect to user homepage
                else:
                    array_push($errors, "Invalid email and password!");
                endif;
            endif;
        endif;
    endif;

    if (isset($_GET['logout'])):
        session_destroy();
        unset($_SESSION['email']);
        header("location: index.php");
    endif;

?>