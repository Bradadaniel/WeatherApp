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
<body onload="window.setTimeout(function(){document.location.reload(true);},30000)">
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
}
?>


<script src="js/script.js"></script>
<script src="ajax/admin.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
</body>
</html>