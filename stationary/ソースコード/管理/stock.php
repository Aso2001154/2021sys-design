<?php //在庫情報
$genre_id = 1;
$message = '';
if(isset($_POST['genre_id'])) {
    $genre_id = @$_POST['genre_id'];
}
if($genre_id==1){ $message = "シャーペン";}
else if($genre_id==2){ $message = "消しゴム";}
else if($genre_id==3){ $message = "ボールペン";}
else if($genre_id==4){ $message = "定規";}
else if($genre_id==5){ $message = "事務用品";}


require "data_base.php";
$pdo = data_base();//データベースログイン
$stmt = $pdo->prepare(merchandise());//商品検索
$stmt -> execute([$genre_id]);

?>
<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>在庫情報</title>
    <link rel="stylesheet" href="css/merchandise_stock.css">
    <?php
    if($genre_id==4){ //ジャンルが定規を選択させている時に呼び出されるcss
        echo '<link rel="stylesheet" href="css/merchandise_stock_ruler.css">';
    }
    ?>
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
<header>
    <a href="management.php"><img src="img/header_name.png" alt="画像" class="header_name"></a>
</header>
<div class="genre_list">
    <form action="stock.php" method="post"><input type="hidden" name="genre_id" value="1"><p class="genre_name"><button type="submit" value="send" class="genre" id="genre1">シャーペン</button></p></form>
    <form action="stock.php" method="post"><input type="hidden" name="genre_id" value="2"><p class="genre_name"><button type="submit" value="send" class="genre" id="genre2">消しゴム</button></p></form>
    <form action="stock.php" method="post"><input type="hidden" name="genre_id" value="3"><p class="genre_name"><button type="submit" value="send" class="genre" id="genre3">ボールペン</button></p></form>
    <form action="stock.php" method="post"><input type="hidden" name="genre_id" value="4"><p class="genre_name"><button type="submit" value="send" class="genre" id="genre4">定規</button></p></form>
    <form action="stock.php" method="post"><input type="hidden" name="genre_id" value="5"><p class="genre_name"><button type="submit" value="send" class="genre" id="genre5">事務用品</button></p></form><br><br>
</div>
<div class="content_class">
    <h2 class="table_contents">在庫情報</h2>
    <p class="period">ジャンル：<?php echo $message; //ジャンル名表示?></p>
    <?php
    foreach ($stmt as $row){
        echo '<div class="content">';
        echo '<p><img src="',htmlspecialchars($row['image']),'" alt="商品画像" class="merchandise_img"></p>';
        echo '<p class="merchandise_information" id="merchandise_name">商品名：',htmlspecialchars($row['merchandise_name']),'</p><br>';
        echo '<p class="merchandise_information" id="merchandise_price">価格：¥',htmlspecialchars(number_format($row ['price'])),'</p><br>';
        echo '<p class="merchandise_information" id="merchandise_stock">在庫：',htmlspecialchars($row ['stock']),'</p><br>';
        echo '<form action="replenishment.php" method="post">';
        echo '<button type="submit" value="send" class="replenishment_btn">補充</button>';
        echo '</div>';
        echo '<div class="cd">回り込み解除</div>';
        echo '<input type="hidden" value="',$row['genre_id'],'" name="genre_id">';
        echo '<input type="hidden" value="',$row['merchandise_id'],'" name="merchandise_id">';
        echo '</form>';


    }
    ?>
</div>
<form action="management.php" method="post"><p style="text-align: center;"><button type="submit" value="send" class="top_btn">top</button></form>
<div class="scroll-button"></div>
</body>
</html>
