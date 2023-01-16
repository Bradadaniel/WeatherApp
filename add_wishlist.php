<?php
session_start();

include 'php/config.php';
include 'php/db_config.php';
$pdo = connectDatabase($dsn, $pdoOptions);

if (isset($_SESSION['SESSION_EMAIL']) && isset($_SESSION['ID'])) {
    $email = $_SESSION['SESSION_EMAIL'];
    $id =$_SESSION['ID'];
}
else{
    $email = '';
    $id = '';
}

if (isset($_POST['add_to_wishlist'])) {
    if ($id !== '') {
        $city_id = $_POST['pid'];
        $city_name_database = $_POST['name'];
        $insert_wishlist = $pdo->prepare("INSERT INTO wishlist (user_id, id_city, name) VALUES (?,?,?)");
        $insert_wishlist->execute([$id, $city_id, $city_name_database]);
        header("Location:index.php?wishlist_added_successful");
    } else {
        header("Location:login/user_login.php");
    }
}




