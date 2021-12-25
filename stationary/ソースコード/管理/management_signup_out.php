<?php //管理画面の会員情報登録成功、失敗
$user_id = @$_POST['user_id'];//取得した情報を代入する
$user_pass = @$_POST['user_pass'];//取得した情報を代入する
$user_name = @$_POST['user_name'];//取得した情報を代入する
$user_address = @$_POST['user_address'];//取得した情報を代入する
$credit_number = @$_POST['credit_number'];//取得した情報を代入する
$form_link = 'management_signup_in.php';//リンク先
$from_btn_message = 'signup';//ボタン名
$login_message = '登録完了';
$message = '';
try {
    require "data_base.php";
    $pdo = data_base();//データベースログイン
    $stmt = $pdo->prepare(user_id());//同じuser_idがいないか検索する
    $stmt->execute([$user_id]);
    $cnt = $stmt->rowCount(); //取得件数
    if ($cnt > 0) {//１以上の場合：同じuser_idが存在する
        $login_message = '登録失敗';
        $message = '既に登録されているidです。';
    } else {
        if(!isset($user_id)){throw new PDOException('問題がありました。');}
        $stmt1 = $pdo->prepare(user_add());//同じuser_idが存在しないからuserテーブルに追加する
        $stmt1->execute([$user_id, $user_pass, $user_name, $user_address, $credit_number]);
        $form_link = 'management.php';//リンク先
        $from_btn_message = 'top';//ボタン名
    }
}catch(PDOException $ex){
    $login_message = $ex->getMessage();
}
?>
<!DOCTYPE html>
<html la="ja">
<head>
    <meta name="viewport" charset="utf-8">
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" >
    <link rel="stylesheet" href="css/management_information.css">
    <title>ログイン認証結果</title>
</head>
<body>
<header class="header">
    <p class="head_img"><img src="img/header_name.png" alt="画像" class="header_log"></p>
</header>
<?php
echo '<form action="',$form_link,'" method="post">';
echo '<h2 class="login_message">',$login_message,'</h2>';
echo '<p class="message">',$message,'</p>';
echo '<button type="submit" value="send" class="back_login">',$from_btn_message,'</button>';
echo '</form>';
?>
</body>
</html>
