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
        $id_wishlist= $_POST['id_wishlist'];
        $select_wishlist=$pdo->prepare("SELECT * FROM wishlist WHERE id=?");
        $select_wishlist->execute([$id_wishlist]);
        while ($row = $select_wishlist->fetch(PDO::FETCH_ASSOC)){
                $city_name = $row['name'];

                    $apiData = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=" . $city_name . "&appid=cecafc8ca0dea8452deafc59d10a0e08");
                    $weatherArray = json_decode($apiData, true);
                    $tempCelsius = $weatherArray['main']['temp'] - 273;
                    $weather = "<b>" . intval($tempCelsius) . " &deg;C</b> <br>";
                    $weather .= "<b>Időjárási viszonyok : </b>" . $weatherArray['weather']['0']['description'] . "<br>";
                    $weather .= "<b>Légnyomás : </b>" . $weatherArray['main']['pressure'] . "hPa <br>";
                    $weather .= "<b>Szélsebeség : </b>" . $weatherArray['wind']['speed'] . "m/s <br>";
                    $weather .= "<b>Felhősödés : </b>" . $weatherArray['clouds']['all'] . " % <br>";
                    $weather_icon = $weatherArray['weather']['0']['icon'];
                    $weather .= "<img src='http://openweathermap.org/img/wn/" . $weather_icon . "@2x.png'>" . "<br>";
                    date_default_timezone_set('Europe/Belgrade');
                    $sunrise = $weatherArray['sys']['sunrise'];

                //$name = $weatherArray['name'];
                //$weather_type = $weatherArray['weather']['0']['main'];

?>
<div class="container" style="background: var(--white);font-size: 2rem;padding: 2rem;margin-top: 1rem;border-radius: 2rem">
    <div class="quick-view-wishlist">
    <div class="box" style="padding: 2rem">
        <?php
           echo '<h1>'.$city_name.'</h1> ';
?>
    </div>
    <div class="box">
        <?php echo $weather?>
    </div>
        <div class="box-long">
            <form id="box-longg" action="check_weather_type.php" method="post">
                <label for="">Válasszon egyet</label>
                <p>Álitson be értesitést az adott időjáráshoz!</p>
                <input type="radio" id="checked" name="checked" value="Clouds"> Felhős <br>
                <input type="radio" id="checked" name="checked" value="Thunderstorm"> Zivatar <br>
                <input type="radio" id="checked" name="checked" value="Drizzle"> Szitálás <br>
                <input type="radio" id="checked" name="checked" value="Rain"> Eső <br>
                <input type="radio" id="checked" name="checked" value="Snow"> Havazás <br>
                <input type="radio" id="checked" name="checked" value="Atmosphere"> Szélfúvás <br>
                <input type="radio" id="checked" name="checked" value="Clear"> Napos <br>
                <input type="hidden" name="city_name" id="city_name" value="<?php echo $city_name?>">
                <input type="submit" id="submit" name="submit" value="Küldés" class="btn btn-success" style="font-size: 2rem;margin-top: 1rem">
            </form>
        </div>
    </div>
<?php
    }
    }
    ?>
</div>


<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
</body>
</html>