<?php
    require_once($_SERVER["DOCUMENT_ROOT"]."/DogsDictionary/db.php");
    $id = $_GET['reply_id'];
    $dog_id = $_GET['dog_id'];
    $user_idx = $_SESSION['user_idx'];
    $stmt = $conn->prepare("SELECT user_id from replys where reply_id = ?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $stmt->bind_result($user_id);
    if($stmt->fetch() && $user_id == $user_idx) {
        $stmt->close();
        $stmt = $conn->prepare("DELETE from replys where reply_id = ?");
        $stmt->bind_param("i",$id);
        $result = $stmt->execute();
        $check = true;
    }
    if($check) {
        header("Location: /DogsDictionary/detail.php?id=$dog_id");
        exit;
    } else {
        header("Content-Type: text/html; charset=UTF-8");
        echo "<script>alert('댓글 삭제에 실패했습니다.');";
        echo "window.location.replace('/DogsDictionary/detail.php?id=$dog_id');</script>";
        exit;
    }
?>