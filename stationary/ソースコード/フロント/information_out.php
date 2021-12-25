<?php
session_start();
$user_number = @$_SESSION['user']['user_number'];
$user_id = @$_POST['user_id'];//入力された情報を取得
$user_pass = @$_POST['user_pass'];//入力された情報を取得
$user_name = @$_POST['user_name'];//入力された情報を取得
$user_address = @$_POST['user_address'];//入力された情報を取得
$credit_number = @$_POST['credit_number'];//入力された情報を取得
$beforeId = @$_POST['beforeId'];//前からのuser_id　新しく入力されたuser_idとの比較に利用する
$form_link = 'pencil.php';//遷移するページを代入する
$from_btn_message = 'top';//ボタン名を代入する(失敗時)
$message = '既に登録されているidです。';//失敗時メッセージ
require "data_base.php";
$pdo = data_base();//データベースログイン
if(strcmp($beforeId, $user_id) == 0){//idの書き換えがあったかの判定
    //書き換えがなく別の書き換えがあった場合(name・address・passなど)
    if(isset($user_number)) {
        $stmt = $pdo->prepare(update_user());//ユーザーの情報を更新する
        $stmt->execute([$user_id, $user_pass, $user_name, $user_address, $credit_number, $user_number]);
        $message = '';
        $login_message = '更新完了';
        $form_link = 'pencil.php';//リンク先
    }else{
        $login_message = '問題がありました。';
        $message = '';
        $form_link = 'pencil.php';
    }
}else{
    $stmt = $pdo->prepare(user_id());//同じidが存在しないかを探す
    $stmt -> execute([$user_id]);
    $cnt = $stmt -> rowCount(); //取得件数
    if($cnt > 0) {//$cntが1より大きい場合同じidが存在するということで、更新失敗にする
        $login_message = '更新失敗';//エラーメッセージ

    }else {
        if(isset($user_number)) {
            $stmt = $pdo->prepare(update_user());//ユーザーの情報を更新する
            $stmt->execute([$user_id, $user_pass, $user_name, $user_address, $credit_number, $user_number]);
            $message = '';
            $login_message = '更新完了';
            $form_link = 'pencil.php';//リンク先
        }else{
            $login_message = '問題がありました。';
            $message = '';
            $form_link = 'pencil.php';
        }
    }
}


?>
<!DOCTYPE html>
<html>
 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="css/information.css"><!-- login_in.php、login_in1.php、signup_in.php、signup_out.php、logout.php、information.php、information_out.php、re_signup_in.php、re_information.php-->
     <link rel="stylesheet" href="css/mobile_information.css" media="screen and (max-width:400px)">
     <title>会員情報認証画面</title>
 </head>
 <body>
 <header class="header">
     <p class="head_img"><img src="img/header_name.png" alt="画像" class="header_log"></p>
 </header>
     <?php
     echo '<form action="',$form_link,'" method="post">';
     echo '<h2 class="login_message">',$login_message,'</h2>';
     echo '<p class="message">',$message,'</p>';
     echo '<p style="text-align: center;"><button type="submit" value="send" class="back_login">',$from_btn_message,'</button></p>';
     echo '</form>';
     ?>
 </body>
</html>
