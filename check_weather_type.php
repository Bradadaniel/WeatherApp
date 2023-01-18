<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

include 'user_header.php';

if (isset($_POST['submit'])){

    $setteddescription = $_POST['checked'];
    $city_name = $_POST['city_name'];
    $check_city = $pdo -> prepare("SELECT * FROM weather WHERE name = ?");
    $check_city->execute([$city_name]);
    $result = $check_city->fetch(PDO::FETCH_ASSOC);
    $city_id = $result['weather_id'];
    $description = $result['description'];
    $check_user = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
    $check_user->execute([$id]);
    $result_user = $check_user->fetch(PDO::FETCH_ASSOC);
    $username = $result_user['username'];
    $email = $result_user['email'];

    $insert_notice = $pdo->prepare("INSERT INTO notice (user_id, id_city, name, email, city_name, description, setteddescription) VALUES (?,?,?,?,?,?,?)");
    $insert_notice->execute([$id, $city_id, $username, $email, $city_name, $description, $setteddescription]);

    echo "<div style='display: none;'>";
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = "danibrada29@gmail.com";
        $mail->Password = "iuwnykymzxfrmepw";                            //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->SMTPSecure = 'tls';

        //Recipients
        $mail->setFrom('danibrada29@gmail.com');
        $mail->addAddress("danibrada29@gmail.com");
        //$email

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'StormSite';
        $mail->Body = 'Email értesitőt állitott be <b>'.$city_name.'</b> a következő időjárástipushoz: <b>'.$setteddescription.'</b>';

        $mail->send();

        $message = 'Email értesitőt állitott be '.$city_name.' a következő időjárástipushoz:'.$setteddescription;
        $insert_notification = $pdo->prepare("INSERT INTO notifications (user_id, message) VALUES (?,?)");
        $insert_notification->execute([$id, $message]);

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.css" integrity="sha512-FA9cIbtlP61W0PRtX36P6CGRy0vZs0C2Uw26Q1cMmj3xwhftftymr0sj8/YeezDnRwL9wtWw8ZwtCiTDXlXGjQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <title>Wishlist</title>
    <style>
        body{
            background: url("img/bg-4.jpg");
            background-size: cover;
        }
    </style>
</head>
<body>

</body>
</html>
