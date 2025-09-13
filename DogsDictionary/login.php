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
        <div class="title">로그인</div>
        <form action="/DogsDictionary/loginOk.php" name="frm" method="post">
            <div class="inputId">
                <label >아이디</label>
                <input type="text" name="id">
            </div>
            <div class="inputPassw">
                <label >비밀번호</label>
                <input type="password" name="password">
            </div>
            <div class="buttons">
                <input type="submit" value="로그인">
                <input type="button" onclick='goToMain()' value='뒤로가기'>
            </div>

        </form>
    </div>
</body>
</html>