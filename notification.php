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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <title>Wishlist</title>
    <style>
body{
    /*background: #544444;*/
    background: url("img/sun.png") ;
    background-size: cover;
    backdrop-filter: brightness(50%);
        }
    </style>
</head>
<body>
<?php
$count_notifications= $pdo->prepare("SELECT * FROM `notifications` WHERE user_id = ?");
$count_notifications->execute([$id]);
$data = $count_notifications->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container" style="background: var(--light-bg);padding: 1rem">
    <table id="tableNotifications" class="table mx-auto">
        <thead class="thead-dark" style="background: var(--black);color:var(--white);">
        <tr>
            <th scope="col">Üzenet</th>
            <th scope="col">Dátum</th>
            <th scope="col">Művelet</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($data as $row) {
            ?>
            <tr>
                <td><?php echo $row['message']?></td>
                <td><?php echo $row['date_time']?></td>
                <td>
                <a onclick="return confirm('Biztosan törli az üzenetet?');" class='btnDelete btn btn-danger' href="delete_notification.php?id=<?php echo $row['user_id']?>"><i class="bi bi-trash"></i></a>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>

<section class="my_notifications">
    <div class="container">
        <h1 class="heading" style="color: var(--white)">Beálított értesítések!</h1>
    <?php
    if ($id ==''){
        header("Location:login/user_login.php");
    }
    $select_notice = $pdo->prepare("SELECT * FROM notice WHERE user_id = $id");
    $select_notice->execute();
    while ($row= $select_notice->fetch(PDO::FETCH_ASSOC)){
    ?>
            <div class="row" style="    display: grid;
                                        grid-template-columns: repeat(auto-fit, 33rem);
                                        gap: 1.5rem;
                                        align-items: center;
                                        justify-content: center;">
                <form method="post" action="delete_notice.php" class="box"
                   <p>Név: <?php echo $row['name']?></p>
                   <p>Város neve: <?php echo $row['city_name']?></p>
                   <p>Beálított időjárás: <?php echo $row['setteddescription']?></p>
                   <input type="hidden" name="id_notice" value="<?php echo $row['id']?>">
                   <input type="hidden" name="city_name" value="<?php echo $row['city_name']?>">
                   <input type="hidden" name="setteddescription" value="<?php echo $row['setteddescription']?>">
                   <button style="border: 1px solid white;width: 100px" class="btn btn-success" type="submit" name="delete_notice" value="<?php echo $row['id']?>">Törlés</button>
                </form>
            </div>
        </div>
        <?php
    }
    ?>
</section>

<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="ajax/admin.js"></script>
<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
</body>
</html>
