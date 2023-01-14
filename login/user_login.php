<?php

include '../php/config.php';
include '../php/db_config.php';
include '../php/functions.php';
require_once '../Mobile-Detect-2.8.39/Mobile_Detect.php';

$pdo = connectDatabase($dsn, $pdoOptions);

$msg = '';
$code ='';

session_start();

if (isset($_SESSION['SESSION_EMAIL'])) {
            $email = $_SESSION['SESSION_EMAIL'];
}

if (isset($_GET['verification'])) {
    $ver = $_GET['verification'];
    $check_verification = $pdo->prepare("SELECT * FROM users WHERE code ='$ver' ");
    $check_verification->execute();
    if ($check_verification->rowCount() > 0) {
        $update_verification=$pdo->prepare("UPDATE users SET code='$code' WHERE code='$ver' ");
        $update_verification->execute();
        if ($update_verification){
            $msg = "<div class='alert alert-success'>Sikeresen megerősitetted a fiókod.</div>";
        }
    }else {
        header("Location: ../index.php");
    }
}

if (isset($_POST['submit'])){

    $email = $_POST['email'];
    $passowrd = $_POST['password'];

    $check_login = $pdo->prepare("SELECT * FROM users WHERE email = ? and no_hash = ?");
    $check_login->execute([$email, $passowrd]);

    if ($check_login->rowCount() === 1) {
        $row = $check_login->fetch(PDO::FETCH_ASSOC);
        $id = $row['user_id'];
        $user_type=$row['user_type'];
        $status = $row['status'];

        if ($status == 'active') {
            if (empty($row['code'])) {
                if ($user_type == 'user') {
                    $_SESSION['SESSION_EMAIL'] = $email;
                    $_SESSION['ID'] = $id;

                    $detect = new Mobile_Detect();
                    $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
                    $ip = getIpAddress();
                    $user_agent = $_SERVER['HTTP_USER_AGENT'];

                    $check_detect = $pdo->prepare("SELECT * FROM detect WHERE user_id =$id ");
                    $check_detect->execute();
                    if ($check_detect->rowCount() > 0) {
                        $date = date("Y-M-D") . time();

                        $update_detect = $pdo->prepare("UPDATE detect SET device_type=:device_type, ip_address=:ip_address, user_agent=:user_agent, updated_date=:updated_date WHERE user_id='$id'");
                        $update_detect->bindParam(':device_type', $deviceType, PDO::PARAM_STR);
                        $update_detect->bindParam(':ip_address', $ip, PDO::PARAM_STR);
                        $update_detect->bindParam(':user_agent', $user_agent, PDO::PARAM_STR);
                        $update_detect->bindParam(':updated_date', $updated_date, PDO::PARAM_STR);
                        $update_detect->execute();

                    } else {
                        $insert_detect = $pdo->prepare("INSERT INTO detect (user_id, device_type, ip_address, user_agent) VALUES (?,?,?,?)");
                        $insert_detect->execute([$id, $deviceType, $ip, $user_agent]);
                    }
                    header("Location:../index.php");
                } elseif ($user_type == 'admin') {

                    $_SESSION['SESSION_EMAIL'] = $email;
                    header("Location:admin_dashboard.php");
                }
            } else {

                $msg = "<div class='alert alert-danger'>Erősitse meg a fiók azonosságát.</div>";
            }
        }else{
            $msg = "<div class='alert alert-danger'>A fiókod felfügesztették.</div>";
        }
    }
    else{
        $msg = "<div class='alert alert-danger'>Helytelen felhasználónév vagy jelszó.</div>";
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
                        <h2>Bejelentkezés</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="email" class="email" name="email" id="email" placeholder="Irja be az email cimét" required>
                            <input type="password" class="password" name="password" id="password" placeholder="Irja be a jelszavát" style="margin-bottom: 2px;" required>
                            <p><a href="user_frogot_password.php" style="margin-bottom: 15px; display: block; text-align: right;">Elfelejtette a jelszavát?</a></p>
                            <button name="submit" name="submit" id="submit" class="btn" type="submit">Bejelentkezés</button>
                        </form>
                        <div class="social-icons">
                            <p>Regisztrálj most! <a href="user_register.php">Regisztráció</a>.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

</body>

</html>