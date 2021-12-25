<?php
session_start();
unset($_SESSION['user']);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログアウト</title>
    <link rel="stylesheet" href="css/information.css"><!-- login_in.php、login_in1.php、signup_in.php、signup_out.php、logout.php、information.php、information_out.php -->
    <link rel="stylesheet" href="css/mobile_information.css" media="screen and (max-width:400px)">
</head>
<body>
<header class="header">
    <p class="head_img"><img src="img/header_name.png" alt="画像" class="header_log"></p>
</header>
<p class="login_message">ログアウトしました。</p>
<p style="text-align: center;margin-top: 50px;"><a href="pencil.php" class="logout_btn">top</a></p>
</body>
</html>