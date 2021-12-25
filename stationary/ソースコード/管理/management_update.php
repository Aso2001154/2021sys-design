<?php //会員情報更新結果
$user = @$_POST['user'];//取得した情報を代入する
$user_id = @$_POST['user_id'];//取得した情報を代入する
$user_pass = @$_POST['user_pass'];//取得した情報を代入する
$user_name = @$_POST['user_name'];//取得した情報を代入する
$user_address = @$_POST['user_address'];//取得した情報を代入する
$credit_number = @$_POST['credit_number'];//取得した情報を代入する
$beforeId = @$_POST['beforeId'];//新しいuser_idを入力した場合に実行するif文を変えるための変数
$form_link = 'management_input.php';//リンク先
$from_btn_message = 'search';//ボタン名
$login_message = '';
if (isset($user)) {
    require "data_base.php";
    $pdo = data_base();//データベースログイン
    if (strcmp($beforeId, $user_id) == 0) {
        $stmt = $pdo->prepare(user_update());//user_id以外の書き換えがあった場合に行われる更新処理
        $stmt->execute([$user_id, $user_pass, $user_name, $user_address, $credit_number, $user]);
        $login_message = '更新完了';
        $form_link = 'management.php';//リンク先
        $from_btn_message = 'top';//ボタン名
    } else {
        //user_idを書き換えた場合データベースに入力したuser_idが存在しないかを検索する
        $stmt = $pdo->prepare(user_id());
        $stmt->execute([$user_id]);
        $cnt = $stmt->rowCount(); //取得件数
        if ($cnt > 0) {//同じuser_idがデータベースに存在した場合true
            $login_message = '更新失敗';
        } else {
            $stmt = $pdo->prepare(user_update());
            $stmt->execute([$user_id, $user_pass, $user_name, $user_address, $credit_number, $user]);
            $login_message = '更新成功';
            $form_link = 'management.php';//リンク先
            $from_btn_message = 'top';//ボタン名
        }
    }
}else{
    $login_message = '問題がありました。';
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>更新結果</title>
    <link rel="stylesheet" href="css/management_update.css">
</head>
<body>
<header>
    <a href="management.php"><img src="img/header_name.png" alt="ヘッダーの画像" class="header_name"></a>
    <p class="head_border"></p>
</header>
<div class="container1">
<?php
echo '<form action="',$form_link,'" method="post">';
echo '<p style="text-align: center;margin-top: 50px;">',$login_message,'</p>';
echo '<p style="text-align: center;"><button type="submit" name="action" value="send" class="top_btn">',$from_btn_message,'</button></p>';
echo '</form>';
?>
</div>
</body>
</html>