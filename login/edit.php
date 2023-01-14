<?php

include '../php/config.php';
include '../php/db_config.php';

$pdo = connectDatabase($dsn, $pdoOptions);

if (isset($_GET['id'])) {

    $id = $_GET['id'];
    $query = "SELECT * FROM users WHERE user_id='$id'";
    $result = $pdo->prepare($query);
    $result->execute();
    $data = $result->fetchAll(PDO::FETCH_ASSOC);
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
                    <h2>Szerkesztés</h2>
                    <?php
                    foreach ($data as $row) {
                    ?>
                    <form action="update_user.php" method="post">
                        <input type="hidden" name="id" id="id" value="<?php echo $row['user_id']?>">
                        <input type="text" class="name" name="name" id="name" value="<?php echo $row['username']?>" placeholder="Irja be a nevét">
                        <input type="email" class="email" name="email" id="email" value="<?php echo $row['email']?>" placeholder="Irja be az email cimet">
                        <input type="password" class="password" name="password" id="password" value="<?php echo $row['no_hash']?>" placeholder="Irja be az jelszavát">
                        <input type="text" class="type" name="type" id="type" value="<?php echo $row['user_type']?>" placeholder="Irja be a felhasználó tipust">
                        <select name="status" id="status">
                            <option name="status" id="status" value="active">Active</option>
                            <option name="status" id="status" value="banned">Banned</option>
                        </select>
                        <button name="submit" class="btn" type="submit">Szerkesztés</button>
                    </form>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>




</body>

</html>
