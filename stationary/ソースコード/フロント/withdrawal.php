<?php
/*退会*/
session_start();
$user_number = @$_SESSION['user']['user_number'];
$message = '退会しました。';
if(isset($user_number)) {
    require "data_base.php";
    $pdo = data_base();//別のファイルから呼び出す

    $delete_stmt = $pdo->prepare(delete_history_detail());//削除する会員の情報を消すために取得する
    $delete_stmt->execute([$user_number]);
    foreach ($delete_stmt as $row) {
        $delete_row = $pdo->prepare(del_history_detail());//history_detailのデータベーステーブルから情報を削除する
        $delete_row->execute([$row['history_detail_id']]);
    }

    $delete_purchase = $pdo->prepare(delete_history_purchase());//history_purchaseのデータベーステーブルから情報を削除する
    $delete_purchase->execute([$user_number]);

    $delete_cart = $pdo->prepare(delete_cart());//cartのデータベーステーブルから削除する
    $delete_cart->execute([$user_number]);

    $stmt = $pdo->prepare(delete_user());//userのデータベーステーブルから削除する
    $stmt->execute([$user_number]);

    unset($_SESSION['user']);
}else{
    $message = '問題がありました。';
}
?>
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
 <?php echo '<p class="login_message">',$message,'</p>'; ?>
 <p style="text-align: center;margin-top: 50px;"><a href="pencil.php" class="logout_btn">top</a></p>
 </body>
</html>
