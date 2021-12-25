<?php //管理画面の商品検索結果
$message = ''; // エラーメッセージ用
$count = 1;//$countの中の数字が偶数か奇数かで出力するときの場所が変わる(css)
$box_merchandise_name = [];//検索に引っかかった商品名を配列に格納していく
$genre_name = [];//textにジャンル名が入力された場合にそのジャンルidを代入する
if(preg_match('/[,]+/',$_POST['text'])) {//検索欄で複数の検索があった場合：true 違う場合:false
    $search_text = explode(",", $_POST['text']);//”,”ごとに区切って配列に格納する
}else{
    $search_text[] = $_POST['text'];
}
$count_search_text = count($search_text);//始めに何個検索がかかったのかを変数に代入しておく
for($i = 0;$i < $count_search_text;$i++) {

    //ジャンル名から検索する
    if(strpos($search_text[$i],'シャーペン') !== false || strpos($search_text[$i],'しゃーぺん') !== false ||
        strpos($search_text[$i],'pencil') !== false || strpos($search_text[$i],'shapen') !== false){
        //textの中に含まれている場合
        $genre_name[] = 1;
    }else if(strpos($search_text[$i],'消しゴム') !== false || strpos($search_text[$i],'けしごむ') !== false ||
        strpos($search_text[$i],'ケシゴム') !== false || strpos($search_text[$i],'keshigomu') !== false ||
        strpos($search_text[$i],'eraser') !== false){
        $genre_name[] = 2;
    }else if(strpos($search_text[$i],'ボールペン') !== false || strpos($search_text[$i],'ぼーるぺん') !== false ||
        strpos($search_text[$i],'borupen') !== false || strpos($search_text[$i],'ballpoint pen') !== false){
        $genre_name[] = 3;
    }else if(strpos($search_text[$i],'定規') !== false || strpos($search_text[$i],'じょうぎ') !== false ||
        strpos($search_text[$i],'ジョウギ') !== false || strpos($search_text[$i],'jogi') !== false ||
        strpos($search_text[$i],'zyogi') !== false || strpos($search_text[$i],'ruler') !== false){
        $genre_name[] = 4;
    }else if(strpos($search_text[$i],'事務用品') !== false || strpos($search_text[$i],'じむようひん') !== false ||
        strpos($search_text[$i],'じむ') !== false || strpos($search_text[$i],'ジム') !== false ||
        strpos($search_text[$i],'office supplies') !== false || strpos($search_text[$i],'zimuyohin') !== false){
        $genre_name[] = 5;
    }else{
        $genre_name[] = 6;
    }

    //商品名から検索する
    if (preg_match("/^[ァ-ヾー]+$/u", $search_text[$i])) {//カタカナのみ
        $search_text[] = mb_convert_kana($search_text[$i], 'c');//ひらがなに
    }else if(preg_match("/^[ぁ-ゞー]+$/u",$search_text[$i])){//ひらがなのみ
        $search_text[] = mb_convert_kana($search_text[$i], 'C');//カタカナに
    }else if(preg_match("/^[０-９0-9]+$/u",$search_text[$i])){
        $search_text[] = mb_convert_kana($search_text[$i], 'n');//半角に
        $search_text[] = mb_convert_kana($search_text[$i], 'N');//全角に
    }else if(preg_match("/^[ぁ-ゞァ-ヾー]+$/u", $search_text[$i])){//カタカナとひらがな
        $search_text[] = mb_convert_kana($search_text[$i], 'c');
        $search_text[] = mb_convert_kana($search_text[$i], 'C');
    }else if(preg_match("/[ぁ-ゞァ-ヾ０-９0-9ー]+/", $search_text[$i])) {//文字と数字
        $search_text[] = mb_convert_kana($search_text[$i], 'c');
        $search_text[] = mb_convert_kana($search_text[$i], 'C');
        $search_text[] = mb_convert_kana($search_text[$i], 'n');
        $search_text[] = mb_convert_kana($search_text[$i], 'N');
    }
}
try{
require "data_base.php";
$pdo = data_base();//データベースログイン
    //ジャンル名
    for($i=0;$i < count($genre_name);$i++){
        $stmt = $pdo->prepare(genre_name());//ジャンルidから商品情報を取得する
        $stmt -> execute([$genre_name[$i]]);
        foreach ($stmt as $row){
            if(!in_array($row['merchandise_name'],$box_merchandise_name)) {//同じ商品名は表示しないようにする
                //同じ名前がない場合配列に格納していく
                $box_genre_id[] = $row['genre_id'];
                $box_merchandise_id[] = $row['merchandise_id'];
                $box_image[] = $row['image'];
                $box_merchandise_name[] = $row['merchandise_name'];
                $box_price[] = $row['price'];
            }
        }
    }

    //商品名から
    for($i=0;$i < count($search_text);$i++){
        $stmt = $pdo->prepare(merchandise_name());//商品名から商品情報を取得する
        $stmt -> execute(['%'.$search_text[$i].'%']);//search_text配列にはあらゆるパターンが格納されている
        foreach ($stmt as $row){
            if(!in_array($row['merchandise_name'],$box_merchandise_name)) {//同じ商品名は表示しないようにする
                //同じ名前がない場合配列に格納していく
                $box_genre_id[] = $row['genre_id'];
                $box_merchandise_id[] = $row['merchandise_id'];
                $box_image[] = $row['image'];
                $box_merchandise_name[] = $row['merchandise_name'];
                $box_price[] = $row['price'];
            }
        }
    }
    if(!isset($box_genre_id)){ throw new PDOException('商品がありません');}// cntが0の場合データベースにそのジャンルの商品が一つもないということなのでエラーメッセージを出力するようにしている

}catch (PDOException $ex){
    $message = $ex->getMessage(); //エラーメッセージ
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>検索結果一覧</title>
    <link rel="stylesheet" href="css/search_merchandise.css">
    <script> // 上部にスクロールさせるための処理
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
    <a href="management.php"><img src="img/header_name.png" alt="ヘッダー画像" class="header_name"></a>
    <p class="head_border"></p>
</header>
<h2 class="search_result" style="text-align: center">商品検索結果一覧</h2>

<?php
$cnt=0;
if(isset($box_genre_id)) {//$box_genre_idに値がない場合検索に何も引っかからなかったという意味
    for($j = 0;$j < count($box_genre_id);$j++) {
        if ($count % 2 != 0) {//$countが奇数の場合
            echo '<form action="search_detail.php" method="post">';
            echo '<div class="border_vertical">';
            echo '<input type=hidden value="', $box_genre_id[$j], '" name="genre_id">';
            echo '<input type=hidden value="', $box_merchandise_id[$j], '" name="merchandise_id">';
            echo '<div class="merchandise_range">';
            if ($box_genre_id[$j] != 4) {//商品がgenre_idが４の場合表示する画像のclass名を変える
                echo '<p class="p_btn"><button type="submit" class="merchandise_img_btn"><img src="', htmlspecialchars($box_image[$j]), '" alt="商品画像" class="merchandise_img"></button></p>';
            } else {
                echo '<p class="p_btn"><button type="submit" class="merchandise_img_btn"><img src="', htmlspecialchars($box_image[$j]), '" alt="商品画像" class="merchandise_img_ruler"></button></p>';
            }
            echo '<p class="p_btn"><button type="submit" class="merchandise_name_btn">', htmlspecialchars($box_merchandise_name[$j]), '<br>￥', htmlspecialchars(number_format($box_price[$j])), '</button></p>';
            echo '</div>';
            echo '</div>';
            echo '</form>';
        } else {//$countが偶数の場合
            echo '<form action="search_detail.php" method="post">';
            echo '<div class="border_vertical1">';
            echo '<input type=hidden value="', $box_genre_id[$j], '" name="genre_id">';
            echo '<input type=hidden value="', $box_merchandise_id[$j], '" name="merchandise_id">';
            echo '<div class="merchandise_range">';
            if ($box_genre_id[$j] != 4) {//商品がgenre_idが４の場合表示する画像のclass名を変える
                echo '<p class="p_btn"><button type="submit" class="merchandise_img_btn"><img src="', htmlspecialchars($box_image[$j]), '" alt="商品画像" class="merchandise_img"></button></p>';
            } else {
                echo '<p class="p_btn"><button type="submit" class="merchandise_img_btn"><img src="', htmlspecialchars($box_image[$j]), '" alt="商品画像" class="merchandise_img_ruler"></button></p>';
            }
            echo '<p class="p_btn"><button type="submit" class="merchandise_name_btn">', htmlspecialchars($box_merchandise_name[$j]), '<br>￥', htmlspecialchars(number_format($box_price[$j])), '</button></p>';
            echo '</div>';
            echo '</div>';
            echo '</form>';
        }
        $count++;
    }
}
echo '<p style="text-align: center;">',$message,'</p>';//エラーメッセージ
echo '<div class="cd">回り込み解除</div>';//float解除要因
?>
<form action="management.php" method="post"><p style="text-align: center;"><button type="submit" value="send" class="top_btn">top</button></p></form>
<div class="scroll-button"></div> <!--スクロールのボタンを表示させる-->
</body>
</html>
