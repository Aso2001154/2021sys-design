<?php //管理画面の会員情報検索結果
$user = @$_POST['user'];
$message = 'information 確認';
$user_id = @$_POST['user_id'];
$user_pass = @$_POST['user_pass'];
$user_name = @$_POST['user_name'];
$user_address = @$_POST['user_address'];
$credit_number = @$_POST['credit_number'];
$beforeId = @$_POST['beforeId'];
$flg = 0;
if (!isset($user_id)){//エラー処理
    $message = '問題がありました。';
    $flg = 1;
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員情報更新の確認</title>
    <link rel="stylesheet" href="css/management_input.css">
</head>
<body>
<header class="header">
    <a href="management.php"><img src="img/header_name.png" alt="画像" class="header_name"></a>
    <p class="head_border"></p>
</header>
<div class="container">
    <?php
    if($flg==0) {
        echo '<h1 class="title">', $message, '</h1>';
        echo '<p style="margin-left: 65%;color: red;">※ここでは入力することはできません。</p>';
        echo '<form action="management_update.php" method="post">';
        echo '<h2 class="subtitle">id</h2>';
        echo '<p class="txt_information"><input type="text" class="text" id="id"name="user_id" value="', htmlspecialchars($user_id), '" readonly></p>';
        echo '<h2 class="subtitle">pass</h2>';
        echo '<p class="txt_information"><input type="text" class="text" id="pass" name="user_pass" value="', htmlspecialchars($user_pass), '" readonly></p>';
        echo '<h2 class="subtitle">name</h2>';
        echo '<p class="txt_information"><input type="text" class="text" id="name" name="user_name" value="', htmlspecialchars($user_name), '" readonly></p>';
        echo '<h2 class="subtitle">address</h2>';
        echo '<p class="txt_information"><input type="text" class="text" id="address" name="user_address" value="', htmlspecialchars($user_address), '" readonly></p>';
        echo '<h2 class="subtitle" id="credit_number">credit number</h2>';
        echo '<p class="txt_information"><input type="number" class="number_text" id="credit" name="credit_number" value="', htmlspecialchars($credit_number), '" readonly></p>';
        echo '<button value="send" class="update_btn" id="login_info" type="submit">update</button>';
        echo '<input type="hidden" value="', $user, '" name="user">';
        echo '<input type="hidden" value="', $beforeId, '" name="beforeId">';
        echo '</form>';
    }else{
        echo '<p style="text-align: center;">',$message,'</p>';//エラーメッセージ
        echo '<button value="send" class="update_btn" id="login_info" type="submit">update</button>';//ページの遷移はしない
    }
    ?>
    <form action="management_output.php" method="post">
        <?php
        echo '<input type="hidden" value="',$user,'" name="user">';
        echo '<input type="hidden" value="',$user_pass,'" name="pass">';
        ?>
        <button type="submit" name="action" value="send" class="top">back</button>
    </form>
</div>
</body>
</html>