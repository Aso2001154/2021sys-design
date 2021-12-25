<?php
$user_id = @$_POST['user_id'];
$user_pass = @$_POST['user_pass'];
$user_name = @$_POST['user_name'];
$user_address = @$_POST['user_address'];
$credit_number = @$_POST['credit_number'];
$beforeId = @$_POST['beforeId'];

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/information.css"><!-- login_in.php、login_in1.php、signup_in.php、signup_out.php、logout.php、information.php、information_out.php、re_signup_in.php、re_information.php-->
    <link rel="stylesheet" href="css/mobile_information.css" media="screen and (max-width:400px)">
    <title>会員情報</title>
</head>
<body>
<header class="header">
    <a href="pencil.php"><img src="img/header_name.png" alt="画像" class="header_log"></a>
    <p class="head_border"></p>
</header>
<div class="container">
    <form action="information_out.php" method="post">
        <h1 class="title">information 確認</h1>
        <p style="margin-left: 65%;color: red;">※ここでは入力することはできません。</p>
        <div class="range">
            <?php
                echo '<h2 class="subtitle">id</h2>';
                echo '<p class="txt_information"><input type="text" class="text" id="id"name="user_id" value="',htmlspecialchars($user_id), '" readonly></p>';
                echo '<h2 class="subtitle">pass</h2>';
                echo '<p class="txt_information"><input type="text" class="text" id="pass" name="user_pass" value="',htmlspecialchars($user_pass), '" readonly></p>';
                echo '<h2 class="subtitle">name</h2>';
                echo '<p class="txt_information"><input type="text" class="text" id="name" name="user_name" value="',htmlspecialchars($user_name), '" readonly></p>';
                echo '<h2 class="subtitle">address</h2>';
                echo '<p class="txt_information"><input type="text" class="text" id="address" name="user_address" value="',htmlspecialchars($user_address), '" readonly></p>';
                echo '<h2 class="subtitle" id="credit_number">credit number</h2>';
                echo '<p class="txt_information"><input type="number" class="number_text" id="credit" name="credit_number" value="',htmlspecialchars($credit_number),'" readonly></p>';
                echo '<button value="send" class="login" id="login_info" type="submit">update</button>';
                echo '<input type="hidden" value="',$beforeId,'" name="beforeId">';
            ?>
        </div>
    </form>
    <form action="information.php" method="post"><button type="submit" value="send" class="top_info">back</button></form>
</div>
</body>
</html>
