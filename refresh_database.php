<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

include 'user_header.php';

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
<body onload="window.setTimeout(function(){document.location.reload(true);},600000)">
<?php
$select_weather=$pdo->prepare("SELECT * FROM weather");
$select_weather->execute();
while ($row = $select_weather->fetch(PDO::FETCH_ASSOC)){
    $city_name = $row['name'];
    $apiData = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=" . $city_name . "&appid=cecafc8ca0dea8452deafc59d10a0e08");
    $weatherArray = json_decode($apiData, true);
    $weather_type = $weatherArray['weather']['0']['main'];
    date_default_timezone_set('Europe/Belgrade');

    $update_city = $pdo->prepare("UPDATE weather SET description=:description WHERE name ='$city_name'");
    $update_city->bindParam(':description',$weather_type,PDO::PARAM_STR);
    $result = $update_city->execute();

    $update_notice = $pdo->prepare("UPDATE notice SET description=:description WHERE city_name ='$city_name'");
    $update_notice->bindParam(':description',$weather_type,PDO::PARAM_STR);
    $result = $update_notice->execute();

}
?>


<script src="js/script.js"></script>
<script src="ajax/admin.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
</body>
</html>
<?php

$check_notice = $pdo->prepare("SELECT * FROM notice");
$check_notice->execute();

while ($row = $check_notice->fetch(PDO::FETCH_ASSOC)){
    $description =$row['description'];
    $setteddescription = $row['setteddescription'];

    if ($description==$setteddescription){
        if (isset($_COOKIE['NOTICE'])){
            echo $row['name'];
        }else{
            $name = $row['name'];
            $email = $row['email'];
            $city_name_database = $row['city_name'];

            $cookie_value = $name;
            setcookie('NOTICE', $cookie_value, time() + 600000, httponly: true);

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
                $mail->Body = 'Kedves <b>'.$name.'</b> - <b>'.$city_name_database.'</b>'.',értesitjük az ön által beálitott időjárás megváltozott <b>'.$setteddescription.'</b>';

                $mail->send();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

        }

    }

}



?>