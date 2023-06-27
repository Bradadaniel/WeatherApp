<?php


function request(){
    header('Content-Type: application/json; charset=utf-8');
    header("HTTP/1.1 400 Bad request");
    $message_json["msg"] =  "Bad request";
    echo json_encode($message_json);
    exit();
}

function contentType(){
    header('Content-Type: application/json; charset=utf-8');
    header("HTTP/1.1 400 Bad request");
    $message_json["msg"] =  "Bad request";
    echo json_encode($message_json);

    exit();
}