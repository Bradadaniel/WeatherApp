<?php

session_start();

if (isset($_SESSION['SESSION_EMAIL'])) {
    header("Location:../index.php");
    die();
}

include '../php/config.php';
include '../php/db_config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$pdo = connectDatabase($dsn, $pdoOptions);

$msg = "";

if (isset($_POST['submit'])) {
    $email =  $_POST['email'];
    $code =md5(rand());


$check_email = $pdo->prepare("SELECT * FROM users WHERE email ='$email' ");
$check_email->execute();
if ($check_email->rowCount() > 0) {
    $update_user =$pdo->prepare("UPDATE users SET code = '$code' WHERE email='$email'");
    $result=$update_user->execute();

    if ($result) {
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
            $mail->addAddress($email);

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'no reply';
            $mail->Body = 'Itt a megerősitő linked: <b><a href="http://localhost/WeatherApp/login/user_change_password.php?reset=' . $code . '">http://localhost/WeatherApp/login/user_change_password.php?reset=' . $code . '</a></b>';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        echo "</div>";
        $msg = "<div class='alert alert-info'>A megerősitő email elküldve, kérem fogadja el.</div>";
        }
    }else{
    $msg = "<div class='alert alert-danger'>$email - Ezzel az email cimmel nem található felhasználó.</div>";
}
}


?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Login Form</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords"
          content="Login Form" />


    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/register_style.css" type="text/css" media="all" />

    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>

</head>

<body>

<section class="w3l-mockup-form">
    <div class="container">
        <div class="workinghny-form-grid">
            <div class="main-mockup">
                <div class="alert-close">
                    <a href="../index.php" style="color: var(--white)"><span class="fa fa-close"></span></a>
                </div>
                <div class="w3l_form align-self">
                    <div class="left_grid_info">
                        <img src="../img/icon1.png" alt="">
                    </div>
                </div>
                <div class="content-wthree">
                    <h2>Elfelejtett jelszó</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
                    <?php echo $msg; ?>
                    <form action="" method="post">
                        <input type="email" class="email" name="email" placeholder="Irja be az email cimet" required>
                        <button name="submit" class="btn" type="submit">Új jelszó küldése</button>
                    </form>
                    <div class="social-icons">
                        <p>Vissza! <a href="user_login.php">Bejelentkezés</a>.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

</body>

</html>