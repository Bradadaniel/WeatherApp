<?php
include 'user_header.php';

if (isset($_POST['delete_wishlist'])){
    $id_wishlist = $_POST['delete_wishlist'];
    $id = $_SESSION['ID'];
    $delete_wishlist = $pdo->prepare("DELETE FROM wishlist WHERE id=:id_wishlist && user_id=:id");
    $delete_wishlist->bindParam('id_wishlist', $id_wishlist);
    $delete_wishlist->bindParam(':id', $id);
    $delete_wishlist->execute();
    header("Location:wishlist.php");
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
<?php if (isset($_POST['quick_view'])){
        echo 'asd';
}?>
<div class="container">
    <h1></h1>
    <div class="titles">
    </div>
    <div class="datas">

    </div>

</div>


<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
</body>
</html>