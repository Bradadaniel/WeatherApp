<?php

session_start();

include '../php/config.php';
include '../php/db_config.php';
$pdo = connectDatabase($dsn, $pdoOptions);

if (isset($_SESSION['SESSION_EMAIL'])) {
    $email = $_SESSION['SESSION_EMAIL'];
}
else{
    $email = '';
}

if (isset($_SESSION['ID'])) {
    $id =$_SESSION['ID'];
}
else{
    $id = '';
}
?>

<header class="header">

    <section class="flex">

        <a href="../index.php" class="logo"><span>Storm</span>Site</a>

        <nav class="navbar">
            <a href="admin_dashboard.php" style="text-decoration: none">Felhasználók</a>
            <a href="statistic.php" style="text-decoration: none">Statisztika</a>
            <a href="detect_users.php" style="text-decoration: none">Detect</a>


        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div>
        </div>

        <div class="profile">
            <?php
            $select_profile= $pdo->prepare("SELECT * FROM `users` WHERE email = ?");
            $select_profile->execute([$email]);
            if ($select_profile->rowCount() > 0){
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                ?>
                <p class="option-btn" style="background: var(--white);color: var(--black)">Üdv <?= $fetch_profile['username'];?></p>
                <a href="../update_user.php" style="text-decoration: none" class="option-btn">Profil szerkesztése</a>
                <a href="../login/user_logout.php" style="text-decoration: none" onclick="return confirm('Biztosan kijelentkezik?')" class="delete-btn">Kijelentkezés</a>
                <?php
            }else{
                ?>
                <p>Kérlek előbb jelentkezz be!</p>
                <div class="flex-btn">
                    <a href="../login/user_login.php" class="option-btn" style="text-decoration: none;color: white">Bejel.</a>
                    <a href="../login/user_register.php" class="option-btn" style="text-decoration: none;color: white">Regisz.</a>
                </div>
                <?php
            }
            ?>
        </div>


    </section>

</header>