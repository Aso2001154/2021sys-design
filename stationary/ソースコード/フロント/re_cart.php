<?php
session_start();
$user_number = @$_SESSION['user']['user_number'];
$sum = 0;
$message = '';
if(isset($user_number)) {
    require "data_base.php";
    $pdo = data_base();//データベースログイン

    $sql = $pdo->prepare(cart());//user_numberでカートに追加している商品をデータベースから探す
    $sql->execute([$user_number]);
    $cnt = $sql->rowCount(); //取得件数
    if ($cnt == 0) {
        $message = 'カートに何も商品が入っていません。';//エラーメッセージ
    }
}else{
    $message = '問題がありました。';
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cart.css"><!-- cart.php、delete.php、comp_purchase.php、add_cart.php、re_cart.php -->
    <link rel="stylesheet" href="css/mobile_cart.css" media="screen and (max-width:400px)">
    <title>ショッピングカート確認</title>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script>
        $(function(){
            var $scroll_button = $(".scroll-button");
            $(window).scroll(function(){
                var scrollTop = $(window).scrollTop();
                if(scrollTop > $(window).height()){
                    $scroll_button.css("opacity", ".7");
                }else{
                    $scroll_button.css("opacity", "0");
                }
            });
            $scroll_button.click(function(){
                $("html,body").animate({scrollTop: 0}, 500, "swing");
            });
        });
    </script>
</head>
<body>
<header class="header">
    <a href="pencil.php"><img src="img/header_name.png" alt="画像" class="header_name"></a>
    <p class="head_border"></p>
</header>
<h1 class="subtitle">ショッピングカート<span style="color: red;">中身の最終確認</span></h1>
<div class="container">

    <?php
    if(isset($user_number)) {
        foreach ($sql as $row) {
            $flg = 0;
            if ($row['cart_genre_id'] == 4) {
                $flg = 1;
            }
            //取得した情報を配列に格納していく
            $box_genre_id[] = $row['cart_genre_id'];
            $box_merchandise_id[] = $row['cart_merchandise_id'];
            $quantity = $row['cart_quantity'];
            $price = $row['price'];
            $sum = $sum + $quantity * $price;
            $box_quantity[] = $quantity;
            $box_price[] = $price;
            $merchandise_name = $row['merchandise_name'];
            $cart_count[] = $row['cart_count'];

            echo '<div class="range">';
            if ($flg == 0) {
                // 出力する商品が定規以外の場合
                echo '<p><img src="', htmlspecialchars($row['image']), '" alt="商品画像" class="merchandise_img"></p>';
            } else if ($flg == 1) {
                //　出力する商品が定規の商品の場合
                echo '<p><img src="', htmlspecialchars($row['image']), '" alt="商品画像" class="merchandise_img" style="height: 50px;margin-top: 100px;margin-bottom: 150px;"></p>';
            }
            echo '<p class="merchandise_information" id="merchandise_name">商品名：', htmlspecialchars($merchandise_name), '</p>';
            echo '<p class="merchandise_information" id="merchandise_price">価格：', htmlspecialchars(number_format($price)), '</p>';
            echo '<p class="merchandise_information" id="merchandise_quantity">個数：', htmlspecialchars(number_format($quantity)), '</p>';
            echo '<div class="cd">回り込み解除</div>';
            echo '</div>';

        }
        echo '<form action="comp_purchase.php" method="post">';
        echo '<p class="sum_price">金額合計：<span class="sum">', number_format($sum), '</span></p>';
        echo '<input type="hidden" name="sum" value="', $sum, '">';
        if (isset($box_genre_id)) {
            for ($i = 0; $i < count($box_genre_id); $i++) {
                //配列で商品ID、等を渡す
                echo '<input type="hidden" name="box_genre_id[]" value="', $box_genre_id[$i], '">';
                echo '<input type="hidden" name="box_merchandise_id[]" value="', $box_merchandise_id[$i], '">';
                echo '<input type="hidden" name="box_quantity[]" value="', $box_quantity[$i], '">';
                echo '<input type="hidden" name="box_price[]" value="', $box_price[$i], '">';
                echo '<input type="hidden" name="cart_count[]" value="', $cart_count[$i], '">';
            }
        }
    }
    echo '<p style="text-align: center;margin-top: 50px;">',$message,'</p>';
    echo '<button type="submit" value="send" class="purchase_btn">purchase</button>';//問題が発生した場合はページの遷移をしない
    echo'</form>';
    ?>
     <form action="cart.php" method="post"><button type="submit" value="send" class="top_btn">back</button></form>

</div>
<div class="scroll-button"></div>
</body>
</html>