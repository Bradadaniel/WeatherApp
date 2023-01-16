<?php
//mobiledetect logolas - +
//europa fobb varosok - -
//tobbnyelv - -

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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"/>

    <title>WeatherAPI</title>
</head>
<body>

<?php include 'user_header.php';

if(array_key_exists('submit', $_GET)){
    //megnezzuk ures e az input+
    if (!$_GET['city']){
        $error = "Figyelem üres beviteli mező";
    }
    if($_GET['city']){
        $apiData=file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=".$_GET['city']."&appid=cecafc8ca0dea8452deafc59d10a0e08");
        $weatherArray = json_decode($apiData, true);
        if ($weatherArray['cod'] == 200){
            $tempCelsius = $weatherArray['main']['temp'] - 273;
            $weather ="<b>".$weatherArray['name'].", ".$weatherArray['sys']['country']." : ".intval($tempCelsius)." &deg;C</b> <br>";
            $weather .="<b>Időjárási viszonyok : </b>" .$weatherArray['weather']['0']['description']."<br>";
            $weather .="<b>Légnyomás : </b>" .$weatherArray['main']['pressure']."hPa <br>";
            $weather .="<b>Szélsebeség : </b>" .$weatherArray['wind']['speed']."m/s <br>";
            $weather .="<b>Felhősödés : </b>" .$weatherArray['clouds']['all']." % <br>";
            $weather_icon =$weatherArray['weather']['0']['icon'];
            $weather .="<img src='http://openweathermap.org/img/wn/".$weather_icon."@2x.png'>"."<br>";
            date_default_timezone_set('Europe/Belgrade');
            $sunrise = $weatherArray['sys']['sunrise'];
            $weather .="<b>Napkelte : </b>" .date("g:i a", $sunrise)."<br>";
            $weather .="<b>Jelenlegi idő : </b>" .date("F j, Y, g:i a");

            $name = $weatherArray['name'];
            $weather_type = $weatherArray['weather']['0']['main'];

            $check_city = $pdo->prepare("SELECT * FROM weather WHERE name = ?");
            $check_city->execute([$name]);
            if ($check_city->rowCount() === 0){

                $insert_city = $pdo->prepare("INSERT INTO weather (name, description) VALUES (?,?)");
                $insert_city->execute([$name, $weather_type]);
            }
        }else{
            $error = "Nem megfelelő városnév!";
        }
    }
}
//Default
$city_name="Subotica";
$apiData1=file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=".$city_name."&appid=cecafc8ca0dea8452deafc59d10a0e08");
$weatherArray = json_decode($apiData1, true);
if ($weatherArray['cod'] == 200){
    $tempCelsius = $weatherArray['main']['temp'] - 273;
    $weather1 ="<b>".$weatherArray['name'].", ".$weatherArray['sys']['country']." : ".intval($tempCelsius)." &deg;C</b> <br>";
    $weather1 .="<b>Időjárási viszonyok : </b>" .$weatherArray['weather']['0']['description']."<br>";
    $weather1 .="<b>Légnyomás : </b>" .$weatherArray['main']['pressure']."hPa <br>";
    $weather1 .="<b>Szélsebeség : </b>" .$weatherArray['wind']['speed']."m/s <br>";
    $weather1 .="<b>Felhősödés : </b>" .$weatherArray['clouds']['all']." % <br>";
    $weather_icon =$weatherArray['weather']['0']['icon'];
    $weather_icons ="<img src='http://openweathermap.org/img/wn/".$weather_icon."@2x.png'>"."<br>";
    date_default_timezone_set('Europe/Belgrade');
}else{
    $error = "Nem megfelelő városnév!";
}

$error_must_login = '';
?>

<div class="swiper Topslider">
    <div class="swiper-wrapper">
        <div class="swiper-slide"><img src="img/bg1.jpg" alt=""></div>
        <div class="swiper-slide"><img src="img/bg-2.jpg" alt=""></div>
        <div class="swiper-slide"><img src="img/bg-3.jpg" alt=""></div>
        <div class="swiper-slide"><img src="img/bg-4.jpg" alt=""></div>
        <div class="swiper-slide"><img src="img/bg-5.jpg" alt=""></div>
    </div>
    <div class="swiper-pagination"></div>
</div>


<div class="default-show">
    <div class="box">
                <?php
                if (isset($weather1)) {
                    echo '<div class="default_city"><b>' . $weather1 . ' </b></div>';
                    echo '<div class="default_city_icon" style="box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.4);">' . $weather_icons . '</div>';
                }
                ?>
    </div>
</div>

<?php if (isset($_GET['wishlist_added_successful'])){
    echo '<p class="empty">Sikeresen hozzáadva a kedvencekhez!</p>';
}?>
<div class="container Search" style="margin-top: 20rem">
<h1>Globális keresés</h1>
    <form action="" method="GET">
        <p><label for="city">Irja be a varos nevet</label><p>
        <p><input type="text" name="city" id="city" placeholder="Varos neve"></p>
        <p><button type="submit" name="submit" class="btn btn-success">Kereses</button></p>
    </form>
</div>


<div class="container output">
    <div class="row1">
        <?php
        if (isset($weather)){
            $city= $_GET['city'];
            $select_city = $pdo->prepare("SELECT * FROM weather WHERE name=?");
            $select_city->execute([$city]);
            while ($fetch_city = $select_city->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <form class="wishlist-form" action="add_wishlist.php" method="post">
                    <input type="hidden" name="city" value="<?=  $city?>">
                    <input type="hidden" name="pid" value="<?= $fetch_city['weather_id']; ?>">
                    <input type="hidden" name="name" value="<?= $fetch_city['name']; ?>">
                    <button style="background: var(--light-bg)" type="submit" name="add_to_wishlist"><i style="font-size: 3rem" class="bi bi-heart-fill"></i></button>
                </form>
                <?php
                echo '
                                        <div class="alert" role="alert">
                                ' . $weather . '
                                </div>';
            }
        }

        if (isset($error)) {
            echo '<div class="alert" role="alert">
                                ' . $error . '
                                </div>';
        }
        ?>
    </div>

    <?php
    if (isset($weather)){

        $forecast=file_get_contents("https://api.openweathermap.org/data/2.5/forecast?q=".$_GET['city']."&&appid=cecafc8ca0dea8452deafc59d10a0e08");
        $weatherForecast = json_decode($forecast, true);
    //                $tempCelsiusF = $weatherForecast['main']['temp'] - 273;
    //                $weatherF ="<b>".$weatherForecast['name'].", ".$weatherForecast['sys']['country']." : ".intval($tempCelsiusF)." &deg;C</b> <br>";
    //                $weatherF .="<b>Időjárási viszonyok : </b>" .$weatherForecast['weather']['0']['description']."<br>";
    //                $weatherF .="<b>Légnyomás : </b>" .$weatherForecast['main']['pressure']."hPa <br>";
    //                $weatherF .="<b>Szélsebeség : </b>" .$weatherForecast['wind']['speed']."m/s <br>";
    //                $weatherF .="<b>Felhősödés : </b>" .$weatherForecast['clouds']['all']." % <br>";
    //                $weather_icon =$weatherForecast['weather']['0']['icon'];
    //                $weatherF .="<img src='http://openweathermap.org/img/wn/".$weather_icon."@2x.png'>"."<br>";
    //                date_default_timezone_set('Europe/Belgrade');
    //                $sunrise = $weatherForecast['sys']['sunrise'];
    //                $weatherF .="<b>Napkelte : </b>" .date("g:i a", $sunrise)."<br>";
    //                $weatherF .="<b>Jelenlegi idő : </b>" .date("F j, Y, g:i a");
    //                echo '
    //            <div class="row2">
    //                <div class="swiper middleSlider">
    //                    <div class="swiper-wrapper">
    //
    //                        <div class="box swiper-slide">
    //                            <div class="box-content">
    //                                <div class="alert" role="alert"><h1>Hetfő</h1>' . $weather . '</div>
    //                            </div>
    //                        </div>
    //                        <div class="box swiper-slide">
    //                            <div class="box-content">
    //                                <div class="alert" role="alert"><h1>Kedd</h1>' . $weather . '</div>
    //                            </div>
    //                        </div>
    //                        <div class="box swiper-slide">
    //                            <div class="box-content">
    //                                <div class="alert" role="alert"><h1>Szerda</h1>' . $weather . '</div>
    //                            </div>
    //                        </div>
    //                        <div class="box swiper-slide">
    //                            <div class="box-content">
    //                                <div class="alert" role="alert"><h1>Csütörtök</h1>' . $weather . '</div>
    //                            </div>
    //                        </div>
    //                        <div class="box swiper-slide">
    //                            <div class="box-content">
    //                                <div class="alert" role="alert"><h1>Péntek</h1>' . $weather . '</div>
    //                            </div>
    //                        </div>
    //
    //                    </div>
    //
    //                </div>
    //            </div>
    //            ';
    }
    ?>
</div>
<div class="container" style="max-width: 600px;padding:2rem 0">
<table class="table-index">
    <thead>
        <th colspan="2">Főbb városok</th>
    </thead>
    <tbody>
            <?php
            $cities=["Subotica", "Belgrade", "Pristina", "Niš", "Novi Sad", "Prizren", "Podgorica", "Kragujevac", "Čačak", "Kosovska Mitrovica", "Leskovac", "Novi Pazar"];
            foreach ($cities as $citi) {
            $apiData1 = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=" . $citi . "&appid=cecafc8ca0dea8452deafc59d10a0e08");
            $weatherArray = json_decode($apiData1, true);
            $weather = "<b>" . $weatherArray['name'] . "  " . intval($tempCelsius) . " &deg;C</b>";
            $weather_icon = $weatherArray['weather']['0']['icon'];
            $weather_icons = "<img src='http://openweathermap.org/img/wn/" . $weather_icon . "@2x.png'>" . "<br>";

            echo '
                <tr>
                <td>'.$weather.'</td>
                <td>'.$citi.$weather_icons.'</td>
                </tr>
            ';
            }
            ?>
    </tbody>

</table>
</div>





<?php include "footer.php";?>

<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".Topslider", {
        loop:true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
        },
    });
</script>
<script>
    var swiper = new Swiper(".middleSlider", {
        loop: true,
        slidesPerView: 3,
        spaceBetween: 30,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            // when window width is <= 499px
            300: {
                slidesPerView: 1,
                spaceBetweenSlides: 30
            },
            // when window width is <= 999px
            999: {
                slidesPerView: 3,
                spaceBetweenSlides: 40
            }
        }
    });
</script>
</body>
</html>
