<?php
session_start();
$user_number = @$_SESSION['user']['user_number'];
$period = @$_POST['period'];
$login_message = '';
$sum = 0; // 合計金額
// 絞る日数をここで判断
date_default_timezone_set('Japan');
$day = date('Y-m-d',strtotime("-1 month"));
if($period==7){
    $day = date('Y-m-d',strtotime("-1 week"));
    $message = "1週間前";
}else if($period==31){
    $message = "1ヶ月前";
}else{
    $message = "全ての期間";
}

require "data_base.php";
$pdo = data_base();//データベースログイン

if($period == 7 || $period == 31){
        $sql = $pdo->prepare(history_period());// 絞込みされた期間の履歴のデータを抽出する
        $sql->execute([$user_number, $day]);
        $cnt = $sql->rowCount();
        if($cnt!=0) {
            $array = [];
            foreach ($sql as $row) {
                array_push($array, $row['purchase_day']);//購入した日付を配列に格納していく
            }
            $sql1 = $pdo->prepare(history_period_detail());//絞り込まれた履歴の詳しい情報を取得する
            $sql1->execute([$user_number, $day]);
            $cnt = $sql1->rowCount(); //取得件数
            if ($cnt == 0) {
                $login_message = '何も購入していません。';
            }
        }
    }else {
        $sql = $pdo->prepare(history_all());// 絞込みがなく全て履歴を抽出する
        $sql->execute([$user_number]);
        $cnt = $sql->rowCount();
        if($cnt!=0) {
            $array = [];
            foreach ($sql as $row) {
                array_push($array, $row['purchase_day']);//購入した日付を配列に格納していく
            }
            $sql1 = $pdo->prepare(history_all_detail());//絞り込まれた履歴の詳しい情報を取得する
            $sql1->execute([$user_number]);
            $cnt = $sql1->rowCount();
            if($cnt==0){
                $login_message = '何も購入していません。';
            }
        }
    }

?>
<!DOCTYPE html>
<html>
 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="css/history.css"><!--history.php、history_genre.php-->
     <link rel="stylesheet" href="css/mobile_history.css" media="screen and (max-width:400px)">
     <title>購入履歴</title>
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
     <a href="pencil.php"><img src="img/header_name.png" alt="画像" class="header_name"></a> <!--//セクションを使ってページの遷移をする-->
 </header>
 <div class="genre_list">
     <form action="pencil.php" method="post"><input type="hidden" value="1" name="genre_id"><p class="genre_name"><button type="submit" value="send" class="genre" id="genre1">シャーペン</button></p></form><!--開いているジャンルのボタンは押せなくする(disabled)-->
     <form action="pencil.php" method="post"><input type="hidden" value="2" name="genre_id"><p class="genre_name"><button type="submit" value="send" class="genre" id="genre2">消しゴム</button></p></form>
     <form action="pencil.php" method="post"><input type="hidden" value="3" name="genre_id"><p class="genre_name"><button type="submit" value="send" class="genre" id="genre3">ボールペン</button></p></form>
     <form action="pencil.php" method="post"><input type="hidden" value="4" name="genre_id"><p class="genre_name"><button type="submit" value="send" class="genre" id="genre4">定　　規</button></p></form>
     <form action="pencil.php" method="post"><input type="hidden" value="5" name="genre_id"><p class="genre_name"><button type="submit" value="send" class="genre" id="genre5">事務用品</button></p></form>
     <form action="ranking.php" method="post"><p class="genre_name"><button type="submit" value="send" class="genre" id="genre6">ランキング</button></p></form><br><br>
 </div>
 <br>
 <h2 class="subtitle">購入履歴</h2>
 <p class="period">期間：<?php echo $message;?></p>
 <form action="history.php" method="post">
     <select name="period" class="period_list">
         <option value="*">すべて</option>
         <option value="7">1週間前</option>
         <option value="31">1ヶ月前</option>
     </select>
     <p><button type="submit" value="send" class="btn">絞り込み</button></p>
 </form>
     <div class="container">
         <?php
         $i = 0;
         $history_id = 0;
         if(isset($sql1)) {
             foreach ($sql1 as $row) {
                 $genre_id = $row['history_genre_id'];
                 $merchandise_id = $row['history_merchandise_id'];
                 $merchandise_name = $row['merchandise_name'];
                 if ($i == 0) {
                     $history_id = $row['history_id'];
                 } else {
                     if ($history_id == $row['history_id']) {
                         $i--; // 同じ時に購入した場合は-1をして同じ配列の値の日付を出力するようにする処理
                     }else{
                         $history_id = $row['history_id'];
                     }
                 }
                 $sum = $sum + $row['history_quantity'] * $row['history_price'];
                 echo '<div class="range">';
                 if($genre_id!=4) {
                     echo '<p><img src="', htmlspecialchars($row['image']), '" alt="商品画像" class="merchandise_img"></p>';
                 }else if($genre_id==4){
                     echo '<p><img src="', htmlspecialchars($row['image']), '" alt="商品画像" class="merchandise_img" style="height: 50px;margin-top: 90px;margin-bottom: 160px;"></p>';
                 }
                 echo '<p class="merchandise_information" id="merchandise_name">商品名：<span>', htmlspecialchars($row['merchandise_name']), '</span></p>';
                 echo '<p class="merchandise_information" id="merchandise_price">価格：¥<span>', htmlspecialchars(number_format($row['history_price'])), '</span></p>';
                 echo '<p class="merchandise_information" id="merchandise_quantity">個数：<span>', htmlspecialchars(number_format($row['history_quantity'])), '</span></p>';
                 echo '<p class="merchandise_information" id="merchandise_day">購入日時：<span>', $array[$i], '</span></p>';
                 echo '<div class="cd">回り込み解除</div>';
                 echo '</div>';
                 $i++; //history_idが変わればiにプラスする　(日付が変わるから)
             }
         }
         echo '<p style="text-align: center;">',$login_message,'</p>';
         echo '<p class="sum_price" style="text-align: center;">合計価格：<span class="border_sum_price">',htmlspecialchars(number_format($sum)),'</span></p>';
         ?>
         <form action="pencil.php" method="post"><p style="text-align: center;"><button type="submit" value="send" class="top_btn">top</button></p></form>
     </div>
 <div class="scroll-button"></div>
 </body>
</html>
