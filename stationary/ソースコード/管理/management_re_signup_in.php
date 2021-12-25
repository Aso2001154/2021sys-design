<?php //管理画面の会員情報確認
$user_id = @$_POST['user_id'];
$user_pass = @$_POST['user_pass'];
$user_name = @$_POST['user_name'];
$user_address = @$_POST['user_address'];
$credit_number = @$_POST['credit_number'];
$flg = 0;
$message = '';
if(strcmp($user_id,'')==0){//エラー処理
    $message = '問題がありました。';
    $flg = 1;
}
?>
<!DOCTYPE html>
<html la="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/management_information.css">
    <title>新規登録</title>


</head>
<body>
<header class="header">
    <a href="management.php"><img src="img/header_name.png" alt="画像" class="header_log"></a>
    <p class="head_border"></p>
</header>
<div id="app">
    <div class="container">
        <?php if($flg==0){?>
        <h1 class="title">sign up 確認</h1>
        <p style="margin-left: 65%;color: red;">※ここでは入力することはできません。</p>
        <form action="management_signup_out.php" method="post">
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

                <p class="signup_login"><button value="send" type="submit" class="signup_btn">signup</button></p>
            </div>
        </form>
        <?php
        }else{
            echo '<p style="text-align: center;">',$message,'</p>';//エラーメッセージ
            echo '<p class="signup_login"><button value="send" type="submit" class="signup_btn">signup</button></p>';//ページの遷移はしない
        }?>
        <form action="management_signup_in.php" method="post">
            <?php
            echo '<input type="hidden" value="',$user_name,'" name="user_name">';
            echo '<input type="hidden" value="',$user_address,'" name="user_address">';
            ?>
            <button type="submit" value="send" class="top_btn">back</button>
        </form>
    </div>
</div>
</body>
</html>
