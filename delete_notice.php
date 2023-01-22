<?php
session_start();

include 'php/config.php';
include 'php/db_config.php';
$pdo = connectDatabase($dsn, $pdoOptions);

if (isset($_POST['delete_notice'])) {
    $notice_id = $_POST['id_notice'];
    $city_name = $_POST['city_name'];
    $id =$_SESSION['ID'];
    $setteddescription = $_POST['setteddescription'];
    $delete_notice = $pdo->prepare("DELETE FROM notice WHERE id=:id_notice");
    $delete_notice->bindParam('id_notice', $notice_id);
    $delete_notice->execute();

    $message = 'Eltávolította az email értesítőt '.$city_name.' a következő időjárástipushoz:'.$setteddescription;
    $insert_notification = $pdo->prepare("INSERT INTO notifications (user_id, message) VALUES (?,?)");
    $insert_notification->execute([$id, $message]);
    header("Location:notification.php");
}
?>

