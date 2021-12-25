<?php
$genre_narrowing = '*';
if(isset($_POST['genre_narrowing'])) {
    $genre_narrowing = $_POST['genre_narrowing'];
}
//ジャンルの絞込み
if($genre_narrowing==1){ $message = "シャーペン";}
else if($genre_narrowing==2){ $message = "消しゴム";}
else if($genre_narrowing==3){ $message = "ボールペン";}
else if($genre_narrowing==4){ $message = "定規";}
else if($genre_narrowing==5){ $message = "事務用品";}
else{ $message = "すべて";}

try {
    require "data_base.php";
    $pdo = data_base();//データベースログイン
    if($genre_narrowing!=1&&$genre_narrowing!=2&&$genre_narrowing!=3&&$genre_narrowing!=4&&$genre_narrowing!=5) {
        $stmt = $pdo->prepare(ranking_all());//すべてのジャンルの商品を表示する
        $stmt->execute();
        $cnt = $stmt -> rowCount(); //取得件数
        if($cnt == 0) throw new PDOException('商品がありません');//エラーメッセージ
        $i=1;//順位を表示する用
        $difference=0;//順位の差を知るのに使われる
        $number=0;//購入された商品の個数を格納する
    }else{
        $stmt = $pdo->prepare(ranking_narrowing());//選択されたジャンルに絞込みを行いその商品を表示する
        $stmt->execute([$genre_narrowing]);
        $cnt1 = $stmt -> rowCount(); //取得件数
        if($cnt1 == 0) throw new PDOException('商品がありません');//エラーメッセージ
        $i=1;//順位を表示する用
        $difference=0;//順位の差を知るのに使われる
        $number=0;//購入された商品の個数を格納する
    }

}catch (PDOException $ex){
    $login_message = $ex->getMessage(); //エラーメッセージ
}
?>
<!DOCTYPE html>
<html>
 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="css/ranking.css"><!--ranking.php、ranking_narrowing.php-->
     <link rel="stylesheet" href="css/mobile_ranking.css" media="screen and (max-width:400px)">
     <title>ランキング</title>
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
     <form action="pencil.php" method="post"><input type="hidden" value="5" name="genre_id"><p class="genre_name"><button type="submit" value="send" class="genre" id="genre5">事務用品</button></p></form><br><br>
 </div>
 <h2 class="subtitle">ランキング</h2>
 <p class="period">ジャンル：<?php echo $message; ?></p>
 <form action="ranking_narrowing.php" method="post">
    <select name="genre_narrowing" class="genre_narrowing">
     <option value="*">すべて</option>
     <option value="1">シャーペン</option>
     <option value="2">消しゴム</option>
     <option value="3">ボールペン</option>
     <option value="4">定規</option>
     <option value="5">事務用品</option>
    </select>
     <p><button type="submit" value="send" class="btn">絞り込み</button></p>
 </form>
 <?php
 foreach ($stmt as $row){
     if($i==1) {
         $number = $row['quantity'];
     }else{
         if($number==$row['quantity']){
             $i--; // 前と同じ個数だった場合同じ順位にする
             $difference++; // この変数を利用して差を求めている
         }
     }
     // ここに問題がある　 $numberに1種類目の商品の個数が入ったままになってループしてしまっている　だから一生同じ順位が出ない
     echo '<div class="range">';
     if($number==$row['quantity']){
         echo '<p class="lank">',$i,'位</p>';
     }else{
         $i = $i + $difference;
        echo '<p class="lank">',$i,'位</p>';
        $difference=0;
     }
     echo '<form action="merchandise_detail.php" method="post">';
     echo '<input type="hidden" value="',$row['genre_id'],'" name="genre_id">';
     echo '<input type="hidden" value="',$row['merchandise_id'],'" name="merchandise_id">';
     if($row['genre_id']!=4) {
         echo '<p><button type="submit" value="send" class="ranking_btn"><img src="', htmlspecialchars($row['image']), '" alt="商品画像" class="merchandise_img"></button></p>';
     }else if($row['genre_id']==4){
         echo '<p><button type="submit" value="send" class="ranking_btn"><img src="', htmlspecialchars($row['image']), '" alt="商品画像" class="merchandise_img" style="height: 50px;margin-top: 100px;margin-bottom: 150px;"></button></p>';
     }
     echo '</form>';
     echo '<p class="merchandise_information" id="merchandise_name">商品名：<span>',htmlspecialchars($row['merchandise_name']),'</span></p>';
     echo '<p class="merchandise_information" id="merchandise_price">価格：¥<span>',htmlspecialchars(number_format($row['price'])),'</span></p>';
     echo '<div class="cd">回り込み解除</div>';
     echo '</div>';
     $number = $row['quantity'];
     $i++;
 }
 ?>
 <p class="explanation">売れ筋ランキングについて</p>
 <p class="explanation">このランキングは実際に売れた商品の個数順で表示されます。1つも売れていない商品はランキング外になります。</p>
 <form action="pencil.php" method="post"><button type="submit" value="send"class="top_btn">top</button></form>
 <div class="scroll-button"></div>
 </body>
</html>
