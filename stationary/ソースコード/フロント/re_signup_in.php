<?php
$user_id = @$_POST['user_id'];
$user_pass = @$_POST['user_pass'];
$user_name = @$_POST['user_name'];
$user_address = @$_POST['user_address'];
$credit_number = @$_POST['credit_number'];
$branch = 0;
$message = '';
if(strcmp($user_id,$message)==0){//エラー処理
    $branch = 1;
}
?>
<!DOCTYPE html>
<html la="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/information.css"><!-- login_in.php、login_in1.php、signup_in.php、signup_out.php、re_signup_in.pho、logout.php、information.php、information_out.php、re_information.php-->
    <link rel="stylesheet" href="css/mobile_information.css" media="screen and (max-width:400px)">
    <title>新規登録</title>


</head>
<body>
<header class="header">
    <a href="login_in.php"><img src="img/header_name.png" alt="画像" class="header_log"></a>
    <p class="head_border"></p>
</header>
<div id="app">
    <div class="container">
        <?php if($branch==0){?>
        <h1 class="title">sign up 確認</h1>
        <p style="margin-left: 65%;color: red;">※ここでは入力することはできません。</p>
        <form action="signup_out.php" method="post">
            <div class="range">
                <h2 class="subtitle">id</h2>
                <?php echo '<p class="txt_information"><input type="text" class="text" name="user_id" id="id" value="',htmlspecialchars($user_id),'" readonly></p>'; ?>

                <h2 class="subtitle">pass</h2>
                <?php echo '<p class="txt_information"><input type="text" class="text" name="user_pass" id="pass" value="',htmlspecialchars($user_pass),'" readonly></p>'; ?>

                <h2 class="subtitle">name</h2>
                <?php  echo '<p class="txt_information"><input type="text" class="text" name="user_name" id="name" value="',htmlspecialchars($user_name),'" readonly></p>'; ?>
                <h2 class="subtitle">address</h2>
                <?php echo '<p class="txt_information"><input type="text" class="text" name="user_address" id="address" value="',htmlspecialchars($user_address),'" readonly></p>'; ?>
                <h2 class="subtitle">credit number</h2>
                <?php echo '<p class="txt_information"><input type="number" class="number_text" name="credit_number" id="credit" value="',htmlspecialchars($credit_number),'" readonly></p>'; ?>
                <p class="signup_login"><button value="send" type="submit" class="login">signup</button></p>
            </div>
        </form>
        <?php
        }else{ echo '<p style="text-align: center;margin-top: 50px;">問題がありました。</p>';}//エラー文
        echo '<form action="signup_in.php" method="post">';
        echo '<input type="hidden" value="',$user_name,'" name="user_name">';
        echo '<input type="hidden" value="',$user_address,'" name="user_address">';
        echo '<button type="submit" value="send" class="top_info">back</button>';
        ?>
        </form>
    </div>
</div>
</body>
</html>
