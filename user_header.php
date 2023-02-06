<?php

session_start();

include 'php/config.php';
include 'php/db_config.php';
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




if(isset($_GET["lang"])){
    $lang = $_GET["lang"];
}else{
    $lang = "eng";
}
$language = parse_ini_file("languages/$lang");


?>


<header class="header">

    <section class="flex">

        <a href="index.php" class="logo"><span>Storm</span>Site</a>

        <nav class="navbar">
            <a href="index.php" style="text-decoration: none"><?= $language["index"]?></a>
            <a href="#Seach" style="text-decoration: none"><?= $language["about"]?></a>
            <a href="#maincity" style="text-decoration: none"><?= $language["location"]?></a>
            <a href="#Footer" style="text-decoration: none"><?= $language["contact"]?></a>
            <a href="?lang=eng" style="text-decoration: none"><img style="height: 20px;width: 30px" src="img/eng.png"></a>
            <a href="?lang=hun" style="text-decoration: none"><img style="height: 20px;width: 30px" src="img/hun.png"></a>

        </nav>

        <div class="icons">
<?php
                $count_wishlist_items= $pdo->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
                $count_wishlist_items->execute([$id]);
                $total_wishlist_items = $count_wishlist_items->rowCount();

                $count_notifications= $pdo->prepare("SELECT * FROM `notifications` WHERE user_id = ?");
                $count_notifications->execute([$id]);
                $total_notifications = $count_notifications->rowCount();

            ?>
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="notification.php"><i class="bi bi-bell-fill"></i><span>
                    (<?php echo $total_notifications;?>)
                </span></a>
            <a href="wishlist.php"><i class="fas fa-heart"></i><span>
                    (<?php echo $total_wishlist_items;?>)
                </span></a>
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
            <a href="update_user.php" style="text-decoration: none" class="option-btn">Profil szerkesztése</a>
            <a href="login/user_logout.php" style="text-decoration: none" onclick="return confirm('Biztosan kijelentkezik?')" class="delete-btn">Kijelentkezés</a>
            <?php
                }else{
            ?>
                <p><?= $language["firstlogin"]?></p>
                <div class="flex-btn">
                    <a href="login/user_login.php" class="option-btn" style="text-decoration: none;color: white"><?= $language["login"]?></a>
                    <a href="login/user_register.php" class="option-btn" style="text-decoration: none;color: white"><?= $language["register"]?></a>
                </div>
                <?php
            }
            ?>
        </div>



    </section>

</header>
