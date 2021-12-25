<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>退会</title>
    <link rel="stylesheet" href="css/information.css"><!-- login_in.php、login_in1.php、signup_in.php、signup_out.php、logout.php、information.php、information_out.php、withdrawal.php、re_withdrawal.php -->
    <link rel="stylesheet" href="css/mobile_information.css" media="screen and (max-width:400px)">
</head>
<body>
<header class="header">
    <p class="head_img"><img src="img/header_name.png" alt="画像" class="header_log"></p>
</header>
<p class="login_message">本当に退会してもいいですか？</p>
<form action="withdrawal.php" method="post"><button value="send" class="withdrawal_yes" type="submit" style="margin-top:50px;margin-right: 25%;">はい</button></form>
<form action="information.php" method="post"><button type="submit" value="send" class="withdrawal_no" style="margin-top:50px;margin-left: 25%;">いいえ</button></form>
</body>
</html>
