<?php
session_start();
$cart_user_number = @$_POST['cart_user_number'];
$cart_count = @$_POST['cart_count'];
$message = '削除完了';
if(isset($cart_user_number)) {
    require "data_base.php";
    $pdo = data_base();//データベースログイン
    $stmt = $pdo->prepare(delete_cart_count());//選択されたカートの中身の商品を削除する
    $stmt->execute([$cart_user_number, $cart_count]);

    $stmt = $pdo->prepare(delete_update_cart());//cart_countを更新する
    $stmt->execute([$cart_count, $cart_user_number]);
}else{
    $message = '問題がありました';
}

?>
<!DOCTYPE html>
<html>
 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cart.css"><!-- cart.php、delete.php、comp_purchase.php、add_cart.php、re_cart.php -->
     <link rel="stylesheet" href="css/mobile_cart.css" media="screen and (max-width:400px)">
 </head>
 <body>
 <header class="header">
     <p class="head_border"><img src="img/header_name.png" alt="画像" class="header_name"></p>
 </header>
 <?php echo '<p class="cart_delete" style="margin-top: 50px;margin-bottom: 50px;">',$message,'</p>';?>
 <form action="cart.php" method="post"><p style="text-align: center;"><button type="submit" value="send" class="back_login">cart</button></p></form>
 </body>
</html>
