<?php 
    require_once($_SERVER["DOCUMENT_ROOT"]."/DogsDictionary/db.php");
    $user_idx = $_SESSION["user_idx"];
    $dog_id = $_POST["dog_id"];
    $content = $_POST["content"];
    $result = $conn->query("insert into replys(user_id,dog_id,content) values($user_idx,$dog_id,'$content')");
    if ($result) {
        header("Location: /DogsDictionary/detail.php?id=$dog_id");
        exit;
    } else {
        header("Content-Type: text/html; charset=UTF-8");
        echo "<script>alert('댓글 작성에 실패했습니다.');";
        echo "window.location.replace('/DogsDictionary/detail.php?id=$dog_id');</script>";
        exit;
    }
?>