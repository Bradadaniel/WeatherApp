<?php
error_reporting(0);

$host = "localhost";
$user = "root";
$pass = "";
$db = "weather_app";

$conn = mysqli_connect($host, $user, $pass, $db);

$op = $_GET['op'];
switch($op){
    case '':normal();break;
    default:normal();break;
    case 'create':create();break;
    case 'detail':detail();break;
    case 'update':update();break;
    case 'delete':delete();break;
}

function normal (){
    global $conn;
    $sql1= "SELECT * FROM users order by user_id desc";
    $q1 = mysqli_query($conn, $sql1);
    while($r1 = mysqli_fetch_array($q1)){
        $hash[] = array(
            'user_id' => $r1['user_id'],
            'username' => $r1['username'],
            'no_hash' => $r1['no_hash']
        );
    }
    $data['data']['result'] = $hash;
    echo json_encode($data);
}

function create(){
    global $conn;
    $username = $_POST['username'];
    $no_hash = $_POST['no_hash'];
    $hash = "Failed connect!";
    if($username and $no_hash){
        $sql1 = "INSERT INTO users (username, no_hash) values ('$username','$no_hash')";
        $q1 = mysqli_query($conn, $sql1);
        if($q1){
            $hash = 'Succesful added!';
        }
    }
    $data['data']['result'] = $hash;
    echo json_encode($data);
}

function detail(){
    global $conn;
    $user_id = $_GET['user_id'];
    $sql1 = "SELECT * FROM users WHERE user_id = '$user_id'";
    $q1 = mysqli_query($conn, $sql1);
    while($r1 = mysqli_fetch_array($q1)){
        $hash[] = array(
            'user_id' => $r1['user_id'],
            'username' => $r1['username'],
            'no_hash' => $r1['no_hash']
        );
    }
    $data['data']['result'] = $hash;
    echo json_encode($data);
}

function update(){
    global $conn;
    $user_id = $_GET['user_id'];
    $username = $_POST['username'];
    $no_hash = $_POST['no_hash'];
    if($username){
        $set[] = "username='$username'";
    }
    if($no_hash){
        $set[] = "no_hash='$no_hash'";
    } 
    $hash = "Failed update!";
    if($username or $no_hash){
        $sql1 = "UPDATE users SET ".implode(",",$set)."
        WHERE user_id = '$user_id'";
        $q1 = mysqli_query($conn, $sql1);
        if($q1){
            $hash="Data succesful updated!";
        }
    }
    $data['data']['result'] = $hash;
    echo json_encode($data);
}

function delete(){
    global $conn;
    $user_id = $_GET['user_id'];
    $sql1 = "DELETE FROM users WHERE user_id = '$user_id'";
    $q1 = mysqli_query($conn, $sql1);
    if($q1){
        $hash = "Succesful deleted data!";
    }else{
        $hash = "Failed data delete!";
    }
    $data['data']['result'] = $hash;
    echo json_encode($data);
}

?>



<?php
//error_reporting(0);
//
//$host = "localhost";
//$user = "root";
//$pass = "";
//$db = "api";
//
//$conn = mysqli_connect($host, $user, $pass, $db);
//
//$op = $_GET['op'];
//switch($op){
//    case '':normal();break;
//    default:normal();break;
//    case 'create':create();break;
//    case 'detail':detail();break;
//    case 'update':update();break;
//    case 'delete':delete();break;
//}
//
//function normal (){
//    global $conn;
//    $sql1= "SELECT * FROM user order by id desc";
//    $q1 = mysqli_query($conn, $sql1);
//    while($r1 = mysqli_fetch_array($q1)){
//        $hash[] = array(
//            'id' => $r1['id'],
//            'name' => $r1['name'],
//            'pass' => $r1['pass'],
//            'date' => $r1['date']
//        );
//    }
//    $data['data']['result'] = $hash;
//    echo json_encode($data);
//}
//
//function create(){
//    global $conn;
//    $name = $_POST['name'];
//    $pass = $_POST['pass'];
//    $hash = "Failed connect!";
//    if($name and $pass){
//        $sql1 = "INSERT INTO user (name, pass) values ('$name','$pass')";
//        $q1 = mysqli_query($conn, $sql1);
//        if($q1){
//            $hash = 'Succesful added!';
//        }
//    }
//    $data['data']['result'] = $hash;
//    echo json_encode($data);
//}
//
//function detail(){
//    global $conn;
//    $id = $_GET['id'];
//    $sql1 = "SELECT * FROM user WHERE id = '$id'";
//    $q1 = mysqli_query($conn, $sql1);
//    while($r1 = mysqli_fetch_array($q1)){
//        $hash[] = array(
//            'id' => $r1['id'],
//            'name' => $r1['name'],
//            'pass' => $r1['pass'],
//            'date' => $r1['date']
//        );
//    }
//    $data['data']['result'] = $hash;
//    echo json_encode($data);
//}
//
//function update(){
//    global $conn;
//    $id = $_GET['id'];
//    $name = $_POST['name'];
//    $pass = $_POST['pass'];
//    if($name){
//        $set[] = "name='$name'";
//    }
//    if($pass){
//        $set[] = "pass='$pass'";
//    }
//    $hash = "Failed update!";
//    if($name or $pass){
//        $sql1 = "UPDATE user SET ".implode(",",$set).",date=now()
//        WHERE id = '$id'";
//        $q1 = mysqli_query($conn, $sql1);
//        if($q1){
//            $hash="Data succesful updated!";
//        }
//    }
//    $data['data']['result'] = $hash;
//    echo json_encode($data);
//}
//
//function delete(){
//    global $conn;
//    $id = $_GET['id'];
//    $sql1 = "DELETE FROM user WHERE id= '$id'";
//    $q1 = mysqli_query($conn, $sql1);
//    if($q1){
//        $hash = "Succesful deleted data!";
//    }else{
//        $hash = "Failed data delete!";
//    }
//    $data['data']['result'] = $hash;
//    echo json_encode($data);
//}
//
//?>

