<?php
session_start();
$user_number = @$_SESSION['user']['user_number'];
$sum = 0;
require "data_base.php";
$pdo = data_base();//データベースログイン

$sql = $pdo->prepare(cart());//user_numberでカートに追加している商品をデータベースから探す
    $sql -> execute([$user_number]);
    $cnt = $sql -> rowCount(); //取得件数
    if($cnt == 0){
        $message = 'カートに何も商品が入っていません。';//エラーメッセージ
    }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cart.css"><!-- cart.php、delete.php、comp_purchase.php、add_cart.php、re_cart.php -->
    <link rel="stylesheet" href="css/mobile_cart.css" media="screen and (max-width:400px)">
    <title>ショッピングカート</title>
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
<h1 class="subtitle">ショッピングカート</h1>
<div class="container">

    <?php
    foreach ($sql as $row){
        $flg = 0;
        if($row['cart_genre_id']==4){
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


        echo '<form action="delete.php" method="post">';
        echo '<div class="range">';
        if($flg==0) {
            // 出力する商品が定規以外の場合
            echo '<p><img src="', htmlspecialchars($row['image']), '" alt="商品画像" class="merchandise_img"></p>';
        }else if($flg==1){
            //　出力する商品が定規の商品の場合
            echo '<p><img src="', htmlspecialchars($row['image']), '" alt="商品画像" class="merchandise_img" style="height: 50px;margin-top: 100px;margin-bottom: 150px;"></p>';
        }
        echo '<p class="merchandise_information" id="merchandise_name">商品名：',htmlspecialchars($merchandise_name),'</p>';
        echo '<p class="merchandise_information" id="merchandise_price">価格：',htmlspecialchars(number_format($price)),'</p>';
        echo '<p class="merchandise_information" id="merchandise_quantity">個数：',htmlspecialchars(number_format($quantity)),'</p>';
        echo '<input type="hidden" name="cart_user_number" value="',$user_number,'">';
        echo '<input type="hidden" name="cart_count" value="',$row['cart_count'],'">';
        echo '<button type="submit" value="send" class="btn">delete</button>';
        echo '<div class="cd">回り込み解除</div>';
        echo '</div>';
        echo '</form>';

    }
    echo '<form action="re_cart.php" method="post">';
    echo '<p class="sum_price">金額合計：<span class="sum">',number_format($sum),'</span></p>';
    echo '<input type="hidden" name="sum" value="',$sum,'">';
    if(isset($box_genre_id)) {
        for ($i = 0; $i < count($box_genre_id); $i++) {
            //配列で商品ID、等を渡す
            echo '<input type="hidden" name="box_genre_id[]" value="', $box_genre_id[$i], '">';
            echo '<input type="hidden" name="box_merchandise_id[]" value="', $box_merchandise_id[$i], '">';
            echo '<input type="hidden" name="box_quantity[]" value="', $box_quantity[$i], '">';
            echo '<input type="hidden" name="box_price[]" value="', $box_price[$i], '">';
            echo '<input type="hidden" name="cart_count[]" value="', $cart_count[$i], '">';
        }
    }

    if(!isset($message)) {//何もカートにない場合表示しない
        echo '<button type="submit" value="send" class="purchase_btn">next</button>';
    }
    echo'</form>';
    ?>
    <?php
    if(isset($message)) {//カート数によって表示するtopの位置を変える
        echo '<form action="pencil.php" method="post"><p style="text-align: center;"><button type="submit" value="send" class="top_button">top</button></p></form>';
    }else{
        echo '<form action="pencil.php" method="post"><button type="submit" value="send" class="top_btn">top</button></form>';
    }
    ?>

</div>
<div class="scroll-button"></div>
</body>
</html>