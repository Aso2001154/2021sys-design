<?php
session_start();
$user_id = 0;
$user_pass = 0;
$login_flg = 0;//ログイン成功なのかを判断する変数
$user_id = @$_POST['user_id'];
$user_pass = @$_POST['user_pass'];
$login_flg = @$_POST['login_flg'];
$user_number = 0;
$branch = 0; //IDとパスワードがデータベースにある場合
$message = "";//エラーメッセージ用
require "data_base.php";
$pdo = data_base();//データベースにログイン
$stmt = $pdo->prepare(user());//データベースに保存されている情報なのかをuser_idとuser_passで絞り込む
$stmt -> execute([$user_id,$user_pass]);
$cnt = $stmt -> rowCount(); //取得件数
if($cnt == 0){ $branch = 1; //IDとパスワードがデータベースにない場合
}else {foreach ($stmt as $row){
    $_SESSION['user'] = ['user_number'=>$row['user_number'],'user_name'=>$row['user_name']];
    }
    $login_flg = 0;//ログイン成功
}
if($login_flg==1){
    $message = "ID、パスワードを間違っています。";
}


?>
<!DOCTYPE html>
<html la="ja">
 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="css/information.css"><!-- login_in.php、login_in1.php、signup_in.php、signup_out.php、logout.php、information.php、information_out.php -->
     <link rel="stylesheet" href="css/mobile_information.css" media="screen and (max-width:400px)">
     <title>ログイン</title>
 </head>
 <body>
  <header class="header">
      <p class="head_img"><img src="img/header_name.png" alt="画像" class="header_log"></p>
  </header>
  <?php if($branch==0){
      echo '<form action="pencil.php" method="post">';
      echo '<p class="login_message">ログインに成功しました。</p>';
      echo '<p class="message">沢山買いましょう!!</p>';
      echo '<p style="text-align: center;"><button type="submit" value="send" class="back_login">top</button></p>';
  }else{
      echo '<div class="container_info">';
      echo '<form action="login_in1.php" method="post">';
      echo '<h1 class="title">login</h1>';
      echo '<p class="error">',$message,'</p>';
      echo '<h2 class="sub">id</h2>';
      echo '<p class="txt"><input type="text" class="text" name="user_id"></p>';
      echo '<h2 class="sub">pass</h2>';
      echo '<p class="txt"><input type="text" class="text" name="user_pass"></p>';
      echo '<p style="text-align: center;"><button type="submit" value="send" class="login_in">login</button></p>';
      echo '</form>';
      echo '</div>';
      echo '<p class="link_a"><a href="signup_in.php" class="sign_up">sign up</a></p>';
  }
  ?>
 </body>
</html>
