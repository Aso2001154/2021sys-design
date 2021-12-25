<?php
session_start();
    $genre_id = @$_POST['genre_id']; //ジャンルID
    $merchandise_id = @$_POST['merchandise_id'];//商品ID
    $merchandise_img = '';
    $login_message = '';
try {
    require "data_base.php";
    $pdo = data_base();//データベースログイン
    $stmt = $pdo->prepare(genre_merchandise());//商品をgenre_idとmerchandise_idで絞り込む
    $stmt -> execute([$genre_id,$merchandise_id]);
    $cnt = $stmt -> rowCount(); //取得件数
    if($cnt == 0) throw new PDOException('データベースに登録されていません。');//エラーメッセージ

}catch (PDOException $ex){
    $login_message = $ex->getMessage(); //エラーメッセージ
}

?>
<!DOCTYPE html>
<html>
 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="css/detail.css"><!--merchandise_detail.php-->
     <link rel="stylesheet" href="css/mobile_detail.css" media="screen and (max-width:400px)">
     <title>商品詳細</title>
 </head>
 <body>
  <header class="header">
      <a href="pencil.php"><img src="img/header_name.png" alt="画像" class="header_log"></a>
      <p class="head_border"></p>
  </header>
  <form action="add_cart.php" method="post">
  <?php
   foreach ($stmt as $row){
       echo '<h2 class="merchandise_name">',htmlspecialchars($row['merchandise_name']),'</h2>';
       echo '<p class="image"><img src="',htmlspecialchars($row['image']),'" alt="商品画像" class="image_img"></p>';
       echo '<p class="price">商品価格：　　　¥<span class="cart_price">', htmlspecialchars(number_format($row['price'])),'</span></p>';
       echo '<p class="detail">商品詳細：</p>';
       echo '<p class="detail_contents">',htmlspecialchars($row['merchandise_detail']),'</p>';
       echo '<p class="quantity">個数：';
       echo '<span><select name="cart_quantity" class="select_quantity">';
       for($i = 1;$i <= 10;$i++) {
           echo '<option value="',$i,'">',$i,'</option>';
       }
       echo '</select></span>';
       echo '</p><br>';
   }
        echo '<input type="hidden" name="genre_id" value="',$genre_id,'">';
        echo '<input type="hidden" name="merchandise_id" value="',$merchandise_id,'">';
        echo '<p style="text-align: center;margin-top: 50px;">',$login_message,'</p>';//エラーメッセージ
      ?>
      <button type="submit" value="send" class="cart_btn">add to cart</button>
  </form>
 <form action="pencil.php" method="post"><button type="submit" value="send" class="top_btn">top</button></form>

 </body>
</html>
