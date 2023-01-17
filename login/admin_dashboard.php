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

    <style>
        body{
            background: url("../img/bg-2.jpg");
            background-size: cover;
        }
    </style>
    <title>Admin</title>
</head>
<body>

<div id="displaydata">
</div>

<br>


<div class="container" style="background: var(--light-bg);padding: 1rem">
    <h1 style="color: var(--black);text-align: center">Felhasználók</h1>
<!--    table-index -->
    <table id="tableNotes" class="table mx-auto">
        <thead class="thead-dark" style="background: var(--black);color:var(--white);">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Felhasználónév</th>
                <th scope="col">Email</th>
                <th scope="col">Jelszó</th>
                <th scope="col">Tipus</th>
                <th scope="col">Státusz</th>
                <th scope="col">Művelet</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($data as $row) {
            ?>
            <tr>
                <td><?php echo $row['user_id']?></td>
                <td><?php echo $row['username']?></td>
                <td><?php echo $row['email']?></td>
                <td><?php echo $row['no_hash']?></td>
                <td><?php echo $row['user_type']?></td>
                <td><?php echo $row['status']?></td>
                <td>
                    <a class='btnUpdate btn btn-warning' href="edit.php?id=<?php echo $row['user_id']?>"><i class="bi bi-pencil"></i></a>
                    <a onclick="return confirm('Biztosan törli a felhasználót?');" class='btnDelete btn btn-danger' href="delete.php?id=<?php echo $row['user_id']?>"><i class="bi bi-trash"></i></a>
                </td>
            </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
</div>



<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <form id="formNotes">
                    <div class="form-group">
                        <label>Felhasználónév</label>
                        <input type="text" class="form-control" id="username" placeholder="Irja be a nevét.">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" id="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label>Jelszó</label>
                        <input type="password" class="form-control" id="no_hash" placeholder="Jelszó">
                    </div>

                    <button type="submit" class="btn btn-primary">Folytatás</button>
                </form>

            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"</script>-->

<script src="../js/script.js"></script>
<script src="../ajax/admin.js"></script>
</body>
</html>
<?php

?>