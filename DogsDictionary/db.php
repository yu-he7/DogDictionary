<?php 
    session_start();
    header('Content-Type: text/html; charset=utf-8');


    $user = getenv("DB_ACCOUNT");
    $password = getenv("DB_PASSWORD");
    $name = getenv("DB_NAME");

    $conn = new mysqli("127.0.0.1",$user,$password,$name);

    $conn->set_charset("utf8");
    if($conn->connect_error) {
        die("연결 실패");
    }

    function query($query) {
        global $conn;
        return $conn->query($query);
    }
?>