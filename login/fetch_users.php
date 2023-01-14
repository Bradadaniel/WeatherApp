<?php

include "../php/config.php";
include "../php/db_config.php";

$pdo = connectDatabase($dsn, $pdoOptions);

$username =(isset($_POST['username'])) ? $_POST['username']:'';
$email =(isset($_POST['email'])) ? $_POST['email']:'';
$password =(isset($_POST['no_hash'])) ? $_POST['no_hash']:'';
$option =(isset($_POST['option'])) ? $_POST['option']:'';
$id =(isset($_POST['user_id'])) ? $_POST['user_id']:'';

$encpass = password_hash($password, PASSWORD_BCRYPT);
$userType = 'user';
$status = 'active';


?>
