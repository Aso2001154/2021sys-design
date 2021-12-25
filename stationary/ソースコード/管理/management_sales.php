<?php //売上情報
$genre_id = 1;//始めはシャーペンの情報を表示させる
$message = '';//ジャンル名表示用
$sales = '';//エラーメッセージ用
if(isset($_POST['genre_id'])){
    $genre_id = $_POST['genre_id'];
}
//ジャンルが選択されたらそのジャンルの名前や商品を表示させる
if($genre_id==1){ $message = "シャーペン";}
else if($genre_id==2){ $message = "消しゴム";}
else if($genre_id==3){ $message = "ボールペン";}
else if($genre_id==4){ $message = "定規";}
else if($genre_id==5){ $message = "事務用品";}

try {
    require "data_base.php";
    $pdo = data_base();//データベースログイン
    $stmt = $pdo->prepare(merchandise());//商品検索
    $stmt->execute([$genre_id]);
    $sql1 = $pdo->prepare(sales());//売上があった商品を探している　//別のファイルから呼び出している
    $sql1->execute([$genre_id]);
    $cnt = $sql1->rowCount(); //取得件数
    if($cnt == 0) throw new PDOException('売上がありません。');
}catch (PDOException $ex){
    $sales = $ex->getMessage();//エラーメッセージ
}
?>
<!DOCTYPE html>

<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" >
    <title>売上一覧</title>
    <link rel="stylesheet" href="css/management_sales.css">
    <?php
    if($genre_id==4){
        echo '<link rel="stylesheet" href="css/management_sales_ruler.css">';
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
<header class="header">
    <a href="management.php"><img src="img/header_name.png" alt="画像" class="header_name"></a> <!--//セクションを使ってページの遷移をする-->
</header>
<div class="genre_list">
    <form action="management_sales.php" method="post"><input type="hidden" value="1" name="genre_id"><p class="genre_name"><button type="submit" value="send" class="genre" id="genre1">シャーペン</button></p></form><!--開いているジャンルのボタンは押せなくする(disabled)-->
    <form action="management_sales.php" method="post"><input type="hidden" value="2" name="genre_id"><p class="genre_name"><button type="submit" value="send" class="genre" id="genre2">消しゴム</button></p></form>
    <form action="management_sales.php" method="post"><input type="hidden" value="3" name="genre_id"><p class="genre_name"><button type="submit" value="send" class="genre" id="genre3">ボールペン</button></p></form>
    <form action="management_sales.php" method="post"><input type="hidden" value="4" name="genre_id"><p class="genre_name"><button type="submit" value="send" class="genre" id="genre4">定　　規</button></p></form>
    <form action="management_sales.php" method="post"><input type="hidden" value="5" name="genre_id"><p class="genre_name"><button type="submit" value="send" class="genre" id="genre5">事務用品</button></p></form><br><br>
</div>
<div class="content_class">
    <h2 class="table_contents">売上情報</h2>
    <p class="period">ジャンル：<?php echo $message; //ジャンル名表示?></p>
    <?php
    foreach ($sql1 as $row){//まず売上があった商品を表示する
        echo '<div class = "range">';
        echo '<p><img src="',htmlspecialchars($row['image']),'" alt="商品画像" class="merchandise_img"></p>';
        echo '<p class="merchandise_information" id="merchandise_name">商品名：',htmlspecialchars($row['merchandise_name']),'</p>';
        echo '<p class="merchandise_information" id="merchandise_price">価格：¥',htmlspecialchars(number_format($row['price'])),'</p>';
        echo '<p class="merchandise_information" id="merchandise_sum">合計価格：¥',htmlspecialchars(number_format($row['all_price'])) ,'</p>';
        echo '<div class="cd">回り込み解除</div>';
        echo '</div>';
        $box_merchandise_id[] = $row['merchandise_id'];//売上が合った商品の商品idを配列に入れて後で同じ商品が表示されないようにする
    }
    $i = 0;
    foreach ($stmt as $row){//売上がなかった商品を表示する
        echo '<div class = "range">';
        if(isset($box_merchandise_id)) {//選ばれているジャンルで売上がある商品が1つでもある場合
            if (count($box_merchandise_id) != $i) {
                if ($row['merchandise_id'] != $box_merchandise_id[$i]) {//$box_merchandiseの配列の中にいれられて商品idじゃなければ売上がない商品ということでその商品を表示する
                    echo '<p><img src="', htmlspecialchars($row['image']), '" alt="商品画像" class="merchandise_img"></p>';
                    echo '<p class="merchandise_information" id="merchandise_name">商品名：', htmlspecialchars($row['merchandise_name']), '</p>';
                    echo '<p class="merchandise_information" id="merchandise_price">価格：¥', htmlspecialchars(number_format($row['price'])), '</p>';
                    echo '<p class="merchandise_information" id="merchandise_sum">合計価格：¥0</p>';
                    echo '<div class="cd">回り込み解除</div>';
                } else {
                    $i++;
                }
            } else {//売上がある商品の種類より売上が出ていない商品の方が多い場合
                echo '<p><img src="', htmlspecialchars($row['image']), '" alt="商品画像" class="merchandise_img"></p>';
                echo '<p class="merchandise_information" id="merchandise_name">商品名：', htmlspecialchars($row['merchandise_name']), '</p>';
                echo '<p class="merchandise_information" id="merchandise_price">価格：¥', htmlspecialchars(number_format($row['price'])), '</p>';
                echo '<p class="merchandise_information" id="merchandise_sum">合計価格：¥0</p>';
                echo '<div class="cd">回り込み解除</div>';
            }
        }else{//選ばれているジャンルで売上がある商品が１つもない場合(すべての商品を合計金額0円として表示する)
            echo '<p><img src="', htmlspecialchars($row['image']), '" alt="商品画像" class="merchandise_img"></p>';
            echo '<p class="merchandise_information" id="merchandise_name">商品名：', htmlspecialchars($row['merchandise_name']), '</p>';
            echo '<p class="merchandise_information" id="merchandise_price">価格：¥', htmlspecialchars(number_format($row['price'])), '</p>';
            echo '<p class="merchandise_information" id="merchandise_sum">合計価格：¥0</p>';
            echo '<div class="cd">回り込み解除</div>';
        }
        echo '</div>';
    }
    echo '<p style="text-align: center;margin-bottom: 50px;font-size: 20px;">',$sales,'</p>'; //エラーメッセージ
    ?>
</div>
<form action="management.php" method="post"><p style="text-align: center;"><button type="submit" value="send"class="top_btn">top</button></p></form>
<div class="scroll-button"></div>
</body>
</html>