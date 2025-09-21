<?php
    require_once($_SERVER["DOCUMENT_ROOT"]."/DogsDictionary/db.php");
    $id = $_POST['reply_id'];
    $check = false;
    $content = htmlspecialchars($_POST['content']);
    $dog_id = $_POST['dog_id'];
    $user_idx = $_SESSION['user_idx'];
    $stmt = $conn->prepare("SELECT user_id from replys where reply_id = ?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $stmt->bind_result($user_id);
    if($stmt->fetch() && $user_id == $user_idx) {
        $stmt->close();
        $stmt = $conn->prepare("UPDATE replys SET content = ? WHERE reply_id = ?");
        $stmt->bind_param("si", $content, $id);
        $result = $stmt->execute();
        $check = true;
    }
    if($check) {
        header("Location: /DogsDictionary/detail.php?id=$dog_id");
        exit;
    } else {
        header("Content-Type: text/html; charset=UTF-8");
        echo "<script>alert('댓글 수정에 실패했습니다.');";
        echo "window.location.replace('/DogsDictionary/detail.php?id=$dog_id');</script>";
        exit;
    }
?>