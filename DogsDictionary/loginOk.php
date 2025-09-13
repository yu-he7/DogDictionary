<?php 
    require_once($_SERVER["DOCUMENT_ROOT"]."/DogsDictionary/db.php");
    
    if (!isset($_POST['id']) || !isset($_POST['password'])) {
        header("Content-Type: text/html; charset=UTF-8");
        echo "<script>alert('아이디 또는 비밀번호가 빠졌거나 잘못된 접근입니다.');";
        echo "window.location.replace('/DogsDictionary/login.php');</script>";
        exit;
    }

    $user_id = $conn->real_escape_string($_POST["id"]);
    $user_pwd = $_POST["password"];
    $stmt = $conn->prepare("SELECT * FROM users WHERE name = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows <= 0) {
        header("Content-Type: text/html; charset=UTF-8");
        echo "<script>alert('사용자가 존재 하지 않습니다.');";
        echo "window.location.replace('/DogsDictionary/login.php');</script>";
    }
    $row = $result->fetch_assoc();
    if(password_verify($user_pwd,$row['password'])) {
        $_SESSION['user_idx'] = $row['id'];
        header("Location: /DogsDictionary/index.php");
        exit;
    }
    header("Content-Type: text/html; charset=UTF-8");
    echo "<script>alert('아이디 또는 비밀번호가 잘못되었습니다.');";
    echo "window.location.replace('/DogsDictionary/login.php');</script>";
    
?>