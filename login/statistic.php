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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body{
            background: #000000;
            background-size: cover;
        }
    </style>
    <title>Statistic</title>
</head>
<body>

<?php
    $select_stat = $pdo->prepare("SELECT * FROM statistic ORDER BY score DESC LIMIT 5");
    $select_stat->execute();
    while ($row = $select_stat->fetch(PDO::FETCH_ASSOC)){
        $top[] = $row['name'];
        $amount[] = $row['score'];
    }
?>

<div class="container">
<div class="chart-container" style="position: relative; height:40vh; width:80vw">
    <canvas id="myChart"></canvas>
</div>
</div>
<script>
    const labels = <?php echo json_encode($top)?>;
    const data = {
        labels: labels,
        datasets: [{
            label: 'Legkeresettebb városok',
            data: <?php echo json_encode($amount)?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 205, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(201, 203, 207, 0.2)'
            ],
            borderColor: [
                'rgb(255, 99, 132)',
                'rgb(255, 159, 64)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                'rgb(54, 162, 235)',
                'rgb(153, 102, 255)',
                'rgb(201, 203, 207)'
            ],
            borderWidth: 1
        }]
    };
const config = {
        type: 'bar',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        },
    };
var myChart = new Chart(
    document.getElementById('myChart'),
    config
)
</script>
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"</script>-->

<script src="../js/script.js"></script>
<script src="../ajax/admin.js"></script>
</body>
</html>

