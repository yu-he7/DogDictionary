<?php 
    require_once($_SERVER["DOCUMENT_ROOT"]."/DogsDictionary/db.php");
    $user_idx = $_SESSION["user_idx"];
    $dog_id = $_POST["dog_id"];
    $content = htmlspecialchars($_POST["content"]);
    $stmt = $conn->prepare("INSERT into replys(user_id,dog_id,content) values(?,?,?)");
    $stmt->bind_param("iis",$user_idx,$dog_id,$content);
    $result = $stmt->execute();
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