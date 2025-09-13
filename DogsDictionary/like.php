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
    $_GET['sql'] = "select d.id, d.name, d.live, d.pern, d.photo_url, d.views from dogs d, user_likes_dogs l where d.id = l.dog_id and l.user_id = ".$_SESSION['user_idx'];
    $_GET['fileName'] = "like";
    require_once($_SERVER["DOCUMENT_ROOT"]."/DogsDictionary/getList.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/DogsDictionary/includes/tail.php");
?>