<?php
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
<body>


<section class="wishlist">
    <h1 style="color: var(--white)">Kedvencek</h1>
    <div class="container">
        <div class="row1">
        <?php
            $select_wishlist = $pdo->prepare("SELECT * FROM wishlist WHERE user_id=?");
            $select_wishlist->execute([$id]);
            if ($select_wishlist->rowCount() > 0){
                while ($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)){
        ?>
                    <form class="box" style="background: white" method="post" action="quick_wiew.php">
                        <h1><?php echo $fetch_wishlist['name']?></h1>
                        <iframe width="100%" height="100%" src="https://maps.google.com/maps?q=<?php echo $fetch_wishlist['name']?>&output=embed"></iframe>
                        <button style="background: var(--light-bg);transform: scale(1.5)" type="submit" name="delete_wishlist" value="<?= $fetch_wishlist['id']?>"><i class="bi bi-trash"></i></button>
                        <input type="hidden" name="id_wishlist" value="<?= $fetch_wishlist['id']?>">
                        <button type="submit" style="background: var(--light-bg);transform: scale(1.5);margin-left: .5rem" name="quick_view" value="<?= $fetch_wishlist['id']?>"><i class="bi bi-eye"></i></button>
                    </form>
        <?php
                        }
                    }else{
                        echo '<p class="empty">Nincsennek kedvenceid!</p>';
                    }
            ?>
        </div>
    </div>
</section>


<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
</body>
</html>

<?php

?>
