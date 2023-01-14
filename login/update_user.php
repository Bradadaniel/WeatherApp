<?php

include '../php/config.php';
include '../php/db_config.php';

$pdo = connectDatabase($dsn, $pdoOptions);


if (isset($_POST['submit'])){
    $id = $_POST['id'];
    $username = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $type = $_POST['type'];
    $status = $_POST['status'];
    $encpass = password_hash($password, PASSWORD_BCRYPT);

    $update_user=$pdo->prepare("UPDATE users SET username='$username', email='$email', no_hash='$password', password='$encpass', user_type='$type', status='$status' WHERE user_id='$id'");
    $update_user->execute();

    header("Location:admin_dashboard.php");
}

?>