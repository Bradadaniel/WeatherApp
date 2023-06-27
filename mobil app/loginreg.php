<?php
error_reporting(0);

header("Content-type: application/json; charset=UTF-8");

$host = "localhost";
$user = "root";
$pass = "";
$db = "weather_app";

$conn = mysqli_connect($host, $user, $pass, $db);

$op = $_GET['op'];
switch($op){
    case 'signin':signin();break;
    case 'signup':signup();break;
}

function signup(){
    global $conn;
    $test=[];
    if (!empty($_POST)) {
        $test = $_POST;
    } else {
        $test = get_object_vars(json_decode(file_get_contents('php://input')));
    }
    $username = $test['username'];
    $email = $test['email'];
    $no_hash = $test['no_hash'];
    $password = password_hash($no_hash, PASSWORD_BCRYPT);
    $user_type = 'user';
    $status = "FAILED";
    $message = "Failed signup";

    $sql2 = "SELECT * FROM users WHERE email = '$email' and no_hash = '$no_hash'";
    $sameNameorPass = mysqli_query($conn, $sql2);
    while($result = mysqli_fetch_array($sameNameorPass)){
        $usernameSame=$result['username'];
        $emailSame=$result['email'];
    }

    if($username!==$usernameSame and $email!==$emailSame) {
        $sql1 = "INSERT INTO users (username, email, password, no_hash, user_type) values ('$username','$email','$password','$no_hash','$user_type')";
        $q1 = mysqli_query($conn, $sql1);
        if ($q1) {
            $sql1 = "SELECT * FROM users WHERE email = '$email' and no_hash = '$no_hash'";
            $q1 = mysqli_query($conn, $sql1);
            while ($r1 = mysqli_fetch_array($q1)) {
                $hash[] = array(
                    'user_id' => $r1['user_id'],
                    'username' => $r1['username'],
                    'password' => $r1['password'],
                    'no_hash' => $r1['no_hash'],
                    'email' => $r1['email'],
                    'user_type' => $r1['user_type'],
                );
                $status = "SUCCESS";
                $message = "Successful signup";
                http_response_code(200);
            }
        }
    }
            $data= $hash;
            echo json_encode([
                "status"=>$status,
                "message" => $message,
                "data" => $data,
            ]);
}

//&email=bela@email.com&no_hash=abelaaa

function signin(){
    global $conn;
    $test=[];
    if (!empty($_POST)) {
        $test = $_POST;
    } else {
        $test = get_object_vars(json_decode(file_get_contents('php://input')));
    }
    $email = $test['email'];
    $no_hash = $test['no_hash'];
    $sql1 = "SELECT * FROM users WHERE email = '$email' and no_hash = '$no_hash'";
    $q1 = mysqli_query($conn, $sql1);
    $status = "FAILED";
    $message = "Failed signin";
    while($r1 = mysqli_fetch_array($q1)){
        $hash[] = array(
            'user_id' => $r1['user_id'],
            'username' => $r1['username'],
            'password' => $r1['password'],
            'no_hash' => $r1['no_hash'],
            'email' => $r1['email'],
            'user_type' => $r1['user_type'],
        );
        $status = "SUCCESS";
        $message = "Successful signin";
    }
    $data= $hash;
    echo json_encode([
        "status"=>$status,
        "message" => $message,
        "data" => $data,
    ]);
}

