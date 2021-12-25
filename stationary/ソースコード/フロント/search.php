<?php
session_start();
$user_number = @$_SESSION['user']['user_number'];//データベースにデータを入れるまでこの行は消しておく
$login_message = '';
if(isset($user_number)) {
    $box_merchandise_name = [];
    $genre_name = [];//textにジャンル名が入力された場合にそのジャンルidを代入する
    if(isset($_POST['text'])) {
        if (preg_match('/[,]+/', $_POST['text'])) {//検索欄で複数の検索があった場合：true 違う場合:false
            $search_text = explode(",", $_POST['text']);
        } else {
            $search_text[] = $_POST['text'];
        }
        $count_search_text = count($search_text);//始めに何個検索がかかったのかを変数に代入しておく
        for ($i = 0; $i < $count_search_text; $i++) {

            //ジャンル名から
            if (strpos($search_text[$i], 'シャーペン') !== false || strpos($search_text[$i], 'しゃーぺん') !== false ||
                strpos($search_text[$i], 'pencil') !== false || strpos($search_text[$i], 'shapen') !== false) {
                //textの中に含まれている場合
                $genre_name[] = 1;
            } else if (strpos($search_text[$i], '消しゴム') !== false || strpos($search_text[$i], 'けしごむ') !== false ||
                strpos($search_text[$i], 'ケシゴム') !== false || strpos($search_text[$i], 'keshigomu') !== false ||
                strpos($search_text[$i], 'eraser') !== false) {
                $genre_name[] = 2;
            } else if (strpos($search_text[$i], 'ボールペン') !== false || strpos($search_text[$i], 'ぼーるぺん') !== false ||
                strpos($search_text[$i], 'borupen') !== false || strpos($search_text[$i], 'ballpoint pen') !== false) {
                $genre_name[] = 3;
            } else if (strpos($search_text[$i], '定規') !== false || strpos($search_text[$i], 'じょうぎ') !== false ||
                strpos($search_text[$i], 'ジョウギ') !== false || strpos($search_text[$i], 'jogi') !== false ||
                strpos($search_text[$i], 'zyogi') !== false || strpos($search_text[$i], 'ruler') !== false) {
                $genre_name[] = 4;
            } else if (strpos($search_text[$i], '事務用品') !== false || strpos($search_text[$i], 'じむようひん') !== false ||
                strpos($search_text[$i], 'じむ') !== false || strpos($search_text[$i], 'ジム') !== false ||
                strpos($search_text[$i], 'office supplies') !== false || strpos($search_text[$i], 'zimuyohin') !== false) {
                $genre_name[] = 5;
            } else {
                $genre_name[] = 6;
            }

            //商品名から
            if (preg_match("/^[ァ-ヾー]+$/u", $search_text[$i])) {//カタカナのみ
                $search_text[] = mb_convert_kana($search_text[$i], 'c');//ひらがなに
            } else if (preg_match("/^[ぁ-ゞー]+$/u", $search_text[$i])) {//ひらがなのみ
                $search_text[] = mb_convert_kana($search_text[$i], 'C');//カタカナに
            } else if (preg_match("/^[０-９0-9]+$/u", $search_text[$i])) {
                $search_text[] = mb_convert_kana($search_text[$i], 'n');//半角に
                $search_text[] = mb_convert_kana($search_text[$i], 'N');//全角に
            } else if (preg_match("/^[ぁ-ゞァ-ヾー]+$/u", $search_text[$i])) {//カタカナとひらがな
                $search_text[] = mb_convert_kana($search_text[$i], 'c');
                $search_text[] = mb_convert_kana($search_text[$i], 'C');
            } else if (preg_match("/[ぁ-ゞァ-ヾ０-９0-9ー]+/", $search_text[$i])) {//文字と数字
                $search_text[] = mb_convert_kana($search_text[$i], 'c');
                $search_text[] = mb_convert_kana($search_text[$i], 'C');
                $search_text[] = mb_convert_kana($search_text[$i], 'n');
                $search_text[] = mb_convert_kana($search_text[$i], 'N');
            }
        }

        try {

            require "data_base.php";
            $pdo = data_base();//データベースにログイン
            //ジャンル名
            for ($i = 0; $i < count($genre_name); $i++) {
                $sql = genre_name();//商品名で検索するsql文を関数化しているのでその呼び出す
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$genre_name[$i]]);
                foreach ($stmt as $row) {
                    if (!in_array($row['merchandise_name'], $box_merchandise_name)) {//同じ商品名は表示しないようにする
                        $box_genre_id[] = $row['genre_id'];
                        $box_merchandise_id[] = $row['merchandise_id'];
                        $box_image[] = $row['image'];
                        $box_merchandise_name[] = $row['merchandise_name'];
                        $box_price[] = $row['price'];
                    }
                }
            }

            //商品名
            for ($i = 0; $i < count($search_text); $i++) {
                $sql = merchandise_name();//商品名で検索するsql文を関数化しているのでその呼び出す
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['%' . $search_text[$i] . '%']);
                foreach ($stmt as $row) {
                    if (!in_array($row['merchandise_name'], $box_merchandise_name)) {//同じ商品名は表示しないようにする
                        $box_genre_id[] = $row['genre_id'];
                        $box_merchandise_id[] = $row['merchandise_id'];
                        $box_image[] = $row['image'];
                        $box_merchandise_name[] = $row['merchandise_name'];
                        $box_price[] = $row['price'];
                    }
                }
            }
            if (!isset($box_genre_id)) {
                throw new PDOException('商品がありません');
            }//検索した文字が商品名にない場合に表示させる


        } catch (PDOException $ex) {
            $login_message = $ex->getMessage(); //エラーメッセージ
        }
    }else{
        $login_message = '問題がありました。';
    }
}else{
    $login_message = '問題がありました';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/top.css">
    <link rel="stylesheet" href="css/mobile_top.css" media="screen and (max-width:400px)">
    <title>検索結果</title>
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
    <a class="list" href="pencil.php"><img src="img/header_name.png" alt="画像" class="header_name"></a>
    <form action="logout.php" method="post"><p><button type="submit" class="btn">ログアウト</button></p></form>
    <form action="cart.php" method="post"><p><button type="submit" class="btn">カート</button></p></form>
    <form action="information.php" method="post"><p><button type="submit" class="btn">会員情報</button></p></form>
    <form action="history.php" method="post"><p><button type="submit" class="btn">購入履歴</button></p></form>
</header>
<div class="genre_list">
    <form action="pencil.php" method="post"><input type="hidden" value="1" name="genre_id"><p class="genre_name"><button type="submit" value="send" class="genre" id="genre1">シャーペン</button></p></form><!--開いているジャンルのボタンは押せなくする(disabled)-->
    <form action="pencil.php" method="post"><input type="hidden" value="2" name="genre_id"><p class="genre_name"><button type="submit" value="send" class="genre" id="genre2">消しゴム</button></p></form>
    <form action="pencil.php" method="post"><input type="hidden" value="3" name="genre_id"><p class="genre_name"><button type="submit" value="send" class="genre" id="genre3">ボールペン</button></p></form>
    <form action="pencil.php" method="post"><input type="hidden" value="4" name="genre_id"><p class="genre_name"><button type="submit" value="send" class="genre" id="genre4">定　　規</button></p></form>
    <form action="pencil.php" method="post"><input type="hidden" value="5" name="genre_id"><p class="genre_name"><button type="submit" value="send" class="genre" id="genre5">事務用品</button></p></form>
    <form action="ranking.php" method="post"><p class="genre_name"><button type="submit" value="send" class="genre" id="genre6">ランキング</button></p></form><br><br>
</div>
    <h2 class="search_answer">検索結果</h2>
    <?php
       $cnt = 0;
       $i=1;
       if(isset($box_genre_id)) {
           for ($j = 0; $j < count($box_genre_id); $j++) {
               //$genre_id = $row['genre_id'];
               //$merchandise_id = $row['merchandise_id'];
               if ($i % 2 != 0) {
                   // iが奇数の場合
                   echo '<form action="merchandise_detail.php" method="post" name="a_form', $cnt, '">';
                   echo '<div class="border_vertical">';
                   echo '<input type="hidden" name="genre_id" value="', $box_genre_id[$j], '">';
                   echo '<input type="hidden" name="merchandise_id" value="', $box_merchandise_id[$j], '">';
                   echo '<div class="merchandise_range">';
                   if ($box_genre_id[$j] != 4) {
                       //　定規以外の商品を出力する
                       echo '<p class="p_btn"><a class="merchandise_img_btn" href="#" onclick="document.a_form', $cnt, '.submit();"><img src="', htmlspecialchars($box_image[$j]), '" alt="商品画像" class="merchandise_img"></a></p>';
                       echo '<p class="p_btn"><a class="merchandise_name_btn" href="#" onclick="document.a_form', $cnt, '.submit();">', htmlspecialchars($box_merchandise_name[$j]), '<br>¥', htmlspecialchars(number_format($box_price[$j])), '</a></p>';
                   } else if ($box_genre_id[$j] == 4) {
                       //　定規の商品を出力する(画像のサイズが変わるため分けている)
                       echo '<p class="p_btn"><a class="merchandise_img_btn" href="#" onclick="document.a_form', $cnt, '.submit();"><img src="', htmlspecialchars($box_image[$j]), '" alt="商品画像" class="merchandise_img_ruler"></a></p>';
                       echo '<p class="p_btn"><a class="merchandise_name_btn" href="#" onclick="document.a_form', $cnt, '.submit();">', htmlspecialchars($box_merchandise_name[$j]), '<br>¥', htmlspecialchars(number_format($box_price[$j])), '</a></p>';
                   }
                   echo '</div>';
                   echo '</div>';
                   echo '</form>';
               } else {
                   // iが偶数の場合
                   echo '<form action="merchandise_detail.php" method="post" name="a_form', $cnt, '">';
                   echo '<div class="border_vertical1">';
                   echo '<input type="hidden" name="genre_id" value="', $box_genre_id[$j], '">';
                   echo '<input type="hidden" name="merchandise_id" value="', $box_merchandise_id[$j], '">';
                   echo '<div class="merchandise_range">';
                   if ($box_genre_id[$j] != 4) {
                       //　定規以外の商品を出力する
                       echo '<p class="p_btn"><a class="merchandise_img_btn" href="#" onclick="document.a_form', $cnt, '.submit();"><img src="', htmlspecialchars($box_image[$j]), '" alt="商品画像" class="merchandise_img"></a></p>';
                       echo '<p class="p_btn"><a class="merchandise_name_btn" href="#" onclick="document.a_form', $cnt, '.submit();">', htmlspecialchars($box_merchandise_name[$j]), '<br>¥', htmlspecialchars(number_format($box_price[$j])), '</a></p>';
                   } else if ($box_genre_id[$j] == 4) {
                       //　定規の商品を出力する(画像のサイズが変わるため分けている)
                       echo '<p class="p_btn"><a class="merchandise_img_btn" href="#" onclick="document.a_form', $cnt, '.submit();"><img src="', htmlspecialchars($box_image[$j]), '" alt="商品画像" class="merchandise_img_ruler"></a></p>';
                       echo '<p class="p_btn"><a class="merchandise_name_btn" href="#" onclick="document.a_form', $cnt, '.submit();">', htmlspecialchars($box_merchandise_name[$j]), '<br>¥', htmlspecialchars(number_format($box_price[$j])), '</a></p>';
                   }
                   echo '</div>';
                   echo '</div>';
                   echo '</form>';
               }
               $i++;
               $cnt++;
           }
       }
       echo '<p style="text-align: center;">',$login_message,'</p>';
       ?>
<div class="scroll-button"></div>
</body>
</html>