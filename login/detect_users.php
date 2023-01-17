<?php

include 'admin_header.php';

$pdo = connectDatabase($dsn, $pdoOptions);

if (isset($_SESSION['SESSION_EMAIL'])) {
    $email = $_SESSION['SESSION_EMAIL'];
}
else{
    $email = '';
}

$query = "SELECT * FROM users";
$result =$pdo->prepare($query);
$result->execute();
$data = $result->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.css" integrity="sha512-FA9cIbtlP61W0PRtX36P6CGRy0vZs0C2Uw26Q1cMmj3xwhftftymr0sj8/YeezDnRwL9wtWw8ZwtCiTDXlXGjQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"/>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.css"/>
    <title>Detect</title>
    <style>
        body{
            background: url("../img/bg-2.jpg");
            background-size: cover;
        }
    </style>
    <body>

<div class="container" style="background: var(--light-bg);padding: 1rem">
        <h1 style="color: var(--black);text-align: center">Detectálások</h1>
<!--    class="table-index"-->
    <table id="tableDetects" class="table mx-auto" style="align-items: center; text-align: center;background: var(--light-bg);padding: 1rem">
        <thead class="thead-dark" style="background: var(--black);color:var(--white);">
        <tr>
            <th scope="col">Felhasználó ID</th>
            <th scope="col">Készülék</th>
            <th scope="col">Ip cim</th>
            <th scope="col">Böngésző</th>
            <th scope="col">Legutolsó belépés</th>
            <th scope="col">Regisztrált</th>
        </tr>
        </thead>
        <tbody>
            <?php
                $fetch_detect = $pdo->prepare("SELECT * FROM detect");
                $fetch_detect->execute();
                $result = $fetch_detect->fetchAll();
                if ($result){
                    foreach ($result as $row) {
                        ?>
                        <tr>
                        <td><?= $row['user_id']?></td>
                        <td><?= $row['device_type']?></td>
                        <td><?= $row['ip_address']?></td>
                        <td><?= $row['user_agent']?></td>
                        <td><?= $row['updated_date']?></td>
                        <td><?= $row['date_time']?></td>
                        </tr>
                        <?php
                    }
                }else{
                    ?>
                    <tr>
                        <td colspan="6">Nincs adat.</td>
                    </tr>
                <?php
                }
                $id = $row['user_id'];
                $device_type = $row['device_type'];
                $ip_address = $row['ip_address'];
                $user_agent = $row['user_agent'];
                $updated_date = $row['updated_date'];
                $date_time = $row['date_time'];
            ?>

        </tbody>
    </table>
</div>


<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"</script>-->

<script src="../js/script.js"></script>
<script src="../ajax/admin.js"></script>
</body>

