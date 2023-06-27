<?php

include "../php/config.php";
include "../php/db_config.php";
include "functions.php";

$pdo = connectDatabase($dsn, $pdoOptions);

if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
    request();
}

$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
if(strcasecmp($contentType, 'application/json') != 0) {
    contentType();
}

$data = file_get_contents("php://input");
$data_json = json_decode($data);

$username = $data_json->username;
$no_hash = $data_json->no_hash;

$sql = "SELECT user_id, no_hash FROM users WHERE username = :username";
$query = $pdo->prepare($sql);
$query->bindParam(':username', $username, PDO::PARAM_STR);
$query->execute();
$result = $query->fetch();


if ($result['no_hash'] == $no_hash){
    $message_json["msg"] = 'Sikeresen bejelentkezett';
    echo json_encode($message_json);
}else{
    $message_json["msg"] = 'Sikertelen bejelentkezés';
    echo json_encode($message_json);
}

