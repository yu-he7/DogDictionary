<?php
    require_once($_SERVER["DOCUMENT_ROOT"]."/DogsDictionary/db.php");
    $id = $_GET['reply_id'];
    $dog_id = $_GET['dog_id'];
    $result = $conn->query("delete from replys where reply_id = $id");
    if($result) {
        header("Location: /DogsDictionary/detail.php?id=$dog_id");
        exit;
    } else {
        header("Content-Type: text/html; charset=UTF-8");
        echo "<script>alert('댓글 삭제에 실패했습니다.');";
        echo "window.location.replace('/DogsDictionary/detail.php?id=$dog_id');</script>";
        exit;
    }
?>