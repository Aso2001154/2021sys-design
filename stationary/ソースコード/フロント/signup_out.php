<?php
$user_id = @$_POST['user_id'];//入力された情報を代入
$user_pass = @$_POST['user_pass'];//入力された情報を代入
$user_name = @$_POST['user_name'];//入力された情報を代入
$user_address = @$_POST['user_address'];//入力された情報を代入
$credit_number = @$_POST['credit_number'];//入力された情報を代入
$form_link = 'signup_in.php';//遷移するページのリンク先を代入する
$from_btn_message = 'signup';//ボタン名を新規登録成功・失敗によって変える
$message = '既に登録されているidです。';//失敗時のメッセージ
try {
    require "data_base.php";
    $pdo = data_base();//データベースログイン
    $stmt = $pdo->prepare(user_id());//同じuser_idがないかを確認する
    $stmt->execute([$user_id]);
    $cnt = $stmt->rowCount(); //取得件数
    if ($cnt > 0) {throw new PDOException('登録失敗'); }//失敗メッセージ

    if(isset($user_id)) {
                $sql1 = user_signup();//同じuser_idがない場合に行われる　userのテーブルに追加する
                $stmt1 = $pdo->prepare($sql1);
                $stmt1->execute([$user_id, $user_pass, $user_name, $user_address, $credit_number]);

                $login_message = '登録完了';
                $message = '';//成功時は何も表示しない
                $form_link = 'login_in.php';
                $from_btn_message = 'login';
    }else{
        $login_message = '問題がありました。';
        $message = '';
    }
}catch (PDOException $ex){
    $login_message = $ex->getMessage(); //エラーメッセージ
}
?>
<!DOCTYPE html>
<html la="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/information.css"><!-- login_in.php、login_in1.php、signup_in.php、signup_out.php、re_signup_in.pho、logout.php、information.php、information_out.php、re_information.php-->
    <link rel="stylesheet" href="css/mobile_information.css" media="screen and (max-width:400px)">
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
    echo '<p style="text-align: center;"><button type="submit" value="send" class="back_login">',$from_btn_message,'</button></p>';
    echo '</form>';
    ?>
</body>
</html>
