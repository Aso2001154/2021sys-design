<?php
session_start();
$user_number = @$_SESSION['user']['user_number'];//入力された情報を取得
$message = 'カートに追加しました';
$from_btn_message = 'top';//ボタン名
if(isset($user_number)) {
    $cart_quantity = @$_POST['cart_quantity'];//入力された情報を取得
    $cart_genre_id = @$_POST['genre_id'];//入力された情報を取得
    $cart_merchandise = @$_POST['merchandise_id'];//入力された情報を取得
    $su = 0;//$cart_countの値を代入していく用

    require "data_base.php";
    $pdo = data_base();//データベースログイン

    $stmt = $pdo->prepare(cart_user_number());//カートの中身の情報を取得する
    $stmt->execute([$user_number]);
    $cnt = $stmt->rowCount(); //取得件数
    if ($cnt == 0) {
        $su = 1;
    } else {
        foreach ($stmt as $row) {
            $su = $row['cart_count'];
        }
        $su++;
    }
    $stmt1 = $pdo->prepare(add_cart());//cartテーブルの中に追加していく
    $stmt1->execute([$user_number, $su, $cart_genre_id, $cart_merchandise, $cart_quantity]);
}else{
    $message = '問題がありました。';
}

?>
<!DOCTYPE html>
<html la="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cart.css">
    <link rel="stylesheet" href="css/mobile_cart.css" media="screen and (max-width:400px)">
    <title>カートに追加</title>
</head>
<body>
<header class="header">
    <p class="head_border"><img src="img/header_name.png" alt="画像" class="header_name"></p>
</header>
<?php
echo '<p class="cart_add" style="margin-bottom: 50px;margin-top: 60px;">',$message,'</p>';
echo '<form action="pencil.php" method="post"><p style="text-align: center;"><button type="submit" value="send" class="back_login">',$from_btn_message,'</button></p></form>';
?>
</body>
</html>
