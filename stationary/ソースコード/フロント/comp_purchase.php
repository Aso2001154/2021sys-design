<?php
session_start();
$user_number = @$_SESSION['user']['user_number'];//セッションでユーザーの情報を受け取る
$box_genre_id = @$_POST['box_genre_id']; // 配列で商品のジャンルIDを受け取る
$box_merchandise_id = @$_POST['box_merchandise_id'];// 配列で商品のIDを受け取る
$box_quantity = @$_POST['box_quantity'];// 配列で商品の個数を受け取る
$box_price = @$_POST['box_price'];// 配列で商品の金額を受け取る
$all_price = @$_POST['sum']; // 合計金額を受け取る
$box_cart = @$_POST['cart_count'];
$message = '';
$error_message = '';//エラーメッセージ用
if(isset($user_number)) {
    $no_stock_name = [];//在庫がない商品の商品名を受け取っていく配列
    $sq = 0; // history_idの保管場所として利用する
    $flag = 0; // 在庫があるかどうかを判断するための変数
    $a = 0;//history_purchaseのinsertを1回しか行わせないための変数
    $count = count($box_genre_id);//何個カートに商品を追加したのか知るための変数
    $cart_cnt = 1;//データベースのcart_countの値を更新する要で利用する
    $box_delete_cart = [];
    $no_delete_cart = [];
    $cart = 1; //今何行目なのかを取得する
    require "data_base.php";
    $pdo = data_base();//データベースログイン

    for ($i = 0; $i < $count; $i++) {
        $number = $pdo->prepare(genre_merchandise());//商品の情報を取得する
        $number->execute([$box_genre_id[$i], $box_merchandise_id[$i]]);
        foreach ($number as $st) {
            if ($st['stock'] < 10) {//在庫が10個未満なのかを判断する
                $flag = 1;//フラグが1の場合は在庫が10未満の商品が含まれているという状態・フラグが0の場合は在庫が10より多くあるため購入可能
                if (!in_array($st['merchandise_name'], $no_stock_name)) {//配列の中に同じ商品名がないか判断する
                    array_push($no_stock_name, $st['merchandise_name']);//違う商品名の場合配列にいれる
                }
                array_push($no_delete_cart, $box_cart[$i]);//在庫がないため購入できない商品のcart_countをこの配列に入れていく
                $all_price = $all_price - $box_price[$i];//購入できなかった商品の価格を合計価格から引く

                $error_message = '<p style="text-align: center; margin-top: 60px;">在庫が足りない商品があり購入完了していない商品があります。</p>';//在庫がない商品が1つでもある場合に表示させる

            } else {
                $message = '<p style="text-align: center;margin-top: 60px;">購入完了しました。</p>';//1つでも購入できた場合に表示する
                array_push($box_delete_cart, $box_cart[$i]);//購入することができる商品のcart_countの値を受け取っていく配列

                if ($a == 0) {// この処理は1回しか行わないため$iで回数を保持している
                    date_default_timezone_set('Japan');
                    $stmt = $pdo->prepare(insert_history_purchase());//history_purchaseに追加
                    $stmt->execute([$user_number, date('Y-m-d'), $all_price]);
                }
                $a = 1;
                $stmt1 = $pdo->prepare(max_history_id());// 一番大きいhistory_idをとってdetailの方で利用する
                $stmt1->execute([$user_number]);
                foreach ($stmt1 as $row) {
                    $sq = $row['history_id'];//$sqの中に一番大きいhistory_idを入れていく
                }

                $stmt2 = $pdo->prepare(insert_history_detail());//history_detailに追加
                $stmt2->execute([$sq, $box_genre_id[$i], $box_merchandise_id[$i], $box_price[$i], $box_quantity[$i]]);

                $stmt3 = $pdo->prepare(update_stock());//stockの在庫を更新する
                $stmt3->execute([$box_quantity[$i], $box_genre_id[$i], $box_merchandise_id[$i]]);

            }
        }
        $cart++;//行数を増やしていく
    }
    $difference_cart = $count - count($box_delete_cart);//元のカートの個数と購入完了した商品の差を求めて更新用として利用する
    for ($i = 0; $i < count($box_delete_cart); $i++) { //$box_delete_cartの中にはcartの中でデータを削除する予定の情報が入っている
        $stmt5 = $pdo->prepare(del_cart());// 購入されたらカートテーブルから購入された商品の情報を消す(1行)
        $stmt5->execute([$user_number, $box_delete_cart[$i]]);
    }
    for ($i = 0; $i < $difference_cart; $i++) {
        $sql6 = $pdo->prepare(update_cart_count());
        $sql6->execute([$cart_cnt, $user_number, $no_delete_cart[$i]]);
        $cart_cnt++;
    }


    if ($count != 0) {// カートに何個商品あるか　$countが0:カートに何もない時に行う　1:1個以上カートに商品がある時に行う
        // $flagが0:問題なくすべての商品の購入処理を行う 1:在庫が10未満の商品がある
        if ($flag == 1) {//フラグが1の場合：在庫が10個未満の商品が含まれているということ
            $stmt3 = $pdo->prepare(update_price());//在庫が10未満の商品分の金額を減らしたうえで売上として更新する
            $stmt3->execute([$all_price, $sq]);
        }
    } else {
        //なにもカートの中に商品がない場合
        $message = '<p style="text-align: center;margin-top: 60px;">カートに何も入っていません。</p>';
    }
}else{
    $message = '<p style="text-align: center;margin-top: 60px;">問題がありました。</p>';
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購入</title>
    <link rel="stylesheet" href="css/cart.css"><!-- cart.php、delete.php、comp_purchase.php、add_cart.php、re_cart.php -->
    <link rel="stylesheet" href="css/mobile_cart.css" media="screen and (max-width:400px)">
</head>
<body>
<header class="header">
    <p><img src="img/header_name.png" alt="画像" class="header_name"></p>
    <p class="head_border"></p>
</header>
<?php
echo $message; // 購入完了というメッセージ表示
echo $error_message; // 在庫があるかないかを出力する
if(isset($no_stock_name)) {//在庫がない商品の商品名を表示する
    for($i=0;$i < count($no_stock_name);$i++) {
        echo '<p style="text-align: center;">', $no_stock_name[$i], 'の商品は購入できません。</p>';
    }
}
?>
<form action="pencil.php" method="post"><p style="text-align: center;margin-top: 50px;"><button type="submit" value="send" class="back_login">top</button></p></form>

</body>
</html>
