<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/DogsDictionary/assets/css/common.css">
</head>
<body>

    <header> 
        <div class="logo"><a href="/DogsDictionary/index.php"><img src="/DogsDictionary/assets/images/Logo.png" alt="Logo"></a></div>
        <nav>
            <ul>
                <li><a href="/DogsDictionary/search.php">Dogs search</a></li>
                <li><a href="/DogsDictionary/like.php">좋아요 목록</a></li>
                <li><a href="#">추후 업데이트</a></li>
            </ul>
        </nav>

        <div class="menus">
            <?php
                if(isset($_SESSION['user_idx']) === false) {
            ?>
                    <a href="/DogsDictionary/login.php">로그인</a>
                    <a href="/DogsDictionary/register.php">회원가입</a>    
            <?php } else { ?>
                <a href="/DogsDictionary/logout.php">로그아웃</a>
            <?php } ?>
        </div>

    </header>
