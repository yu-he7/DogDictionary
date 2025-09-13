<?php 
    session_start();
    if(isset($_SESSION['user_idx']) === false) {
        header("Content-Type: text/html; charset=UTF-8");
        echo "<script>alert('로그인이 필요합니다. 로그인 해주세요!');";
        echo "window.location.replace('/DogsDictionary/login.php');</script>";
    }
    include $_SERVER["DOCUMENT_ROOT"]."/DogsDictionary/dp.php";
    require_once($_SERVER["DOCUMENT_ROOT"]."/DogsDictionary/includes/head.php");
    $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
    $_GET['page'] = $page;
    $_GET['sql'] = "select * from dogs";
    $_GET['fileName'] = "search";
    require_once($_SERVER["DOCUMENT_ROOT"]."/DogsDictionary/getList.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/DogsDictionary/includes/tail.php");
?>