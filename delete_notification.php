<?php

include "php/config.php";
include "php/db_config.php";

$pdo = connectDatabase($dsn, $pdoOptions);

if (!isset($_GET['id'])){
    echo 'Valami nincs rendben';
}
else{
    $id = $_GET['id'];
    $stmt = $pdo->prepare('DELETE FROM notifications WHERE user_id = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    header("Location:notification.php");
}