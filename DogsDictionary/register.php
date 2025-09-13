<?php 
    require_once($_SERVER["DOCUMENT_ROOT"]."/DogsDictionary/db.php");

    $username = $password = $password_check ="";

     if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["id"];
        $password = $_POST["password"];
        $password_check = $_POST["passwordCheck"];
        $name = $_POST["name"];

        $result = $conn->query("SELECT * FROM users WHERE name = '$username'");
        if ($result->num_rows > 0) {
            echo "<script>alert('이미 사용중인 아이디입니다.'); window.location.replace('/DogsDictionary/register.php');</script>";
            exit;
        }

        if (empty($username) || empty($password) || empty($password_check) || empty($name)) {
            echo "<script>alert('모든 필드를 채워주세요.'); window.location.replace('/DogsDictionary/register.php');</script>";
            exit;
        }

        if (strlen($username) < 4 || strlen($username) > 20) {
            echo "<script>alert('아이디는 4자 이상 20자 이하로 입력해주세요.'); window.location.replace('/DogsDictionary/register.php');</script>";
            exit;
        }

        if (strlen($password) < 8 || strlen($password) > 20) {
            echo "<script>alert('비밀번호는 8자 이상 20자 이하로 입력해주세요.'); window.location.replace('/DogsDictionary/register.php');</script>";
            exit;
        }

        $stmt->close();

        if ($password !== $password_check) {
            echo "<script>alert('비밀번호가 일치하지 않습니다.'); window.location.replace('/DogsDictionary/register.php');</script>";
            exit;
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (name, password, username) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashed_password, $name);

        if ($stmt->execute()) {
            echo "<script>alert('회원가입이 완료되었습니다. 로그인 해주세요.'); window.location.replace('/DogsDictionary/login.php');</script>";
        } else {
            echo "<script>alert('회원가입 실패: " . $stmt->error . "'); window.location.replace('/DogsDictionary/register.php');</script>";
        }

        $stmt->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/DogsDictionary/assets/css/common.css"/>
</head>
<body>
    <script>
        function goToMain() {
            window.location.href = "/DogsDictionary/index.php";
        }
    </script>
    <div class="login">
        <div class="title">회원가입</div>
        <form action="/DogsDictionary/register.php" name="frm" method="post">
            <div class="inputId">
                <label >아이디</label>
                <input type="text" name="id">
            </div>
            <div class="inputName">
                <label >이름</label>
                <input type="text" name="name">
            </div>
            <div class="inputPassw">
                <label >비밀번호</label>
                <input type="password" name="password">
            </div>
            <div class="inputCheck">
                <label >비밀번호 확인</label>
                <input type="password" name="passwordCheck">
            </div>
            <div class="buttons">
                <input type="submit" value="회원가입">
                <input type="button" onclick='goToMain()' value='뒤로가기'>
            </div>

        </form>
    </div>
</body>
</html>