<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/DogsDictionary/db.php");

    $user_idx = $_POST['user_idx'];
    $dog_id = $_POST['dog_id'];
    $liked = $_POST['liked'] === 'true';

    if ($liked) {
        $stmt = $conn->prepare("INSERT INTO user_likes_dogs(user_id,dog_id) VALUES(?,?)");
        $stmt->bind_param("ss", $user_idx, $dog_id);
        $stmt->execute();
    } else {
        $stmt = $conn->prepare("DELETE FROM user_likes_dogs WHERE user_id = ? AND dog_id = ?");
        $stmt->bind_param("ss", $user_idx, $dog_id);
        $stmt->execute();
    }
    echo "ok";
?>
