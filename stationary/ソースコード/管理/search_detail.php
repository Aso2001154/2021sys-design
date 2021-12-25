<?php //管理画面の商品詳細
$genre_id = @$_POST['genre_id'];//取得した情報を代入する
$merchandise_id = @$_POST['merchandise_id'];//取得した情報を代入する
$message = '';//エラーメッセージ用
$flg = 0;
try {
    if(strcmp($genre_id,'')!=0) {
        require "data_base.php";
        $pdo = data_base();//データベースログイン
        $stmt = $pdo->prepare(genre_merchandise());//商品を検索する
        $stmt->execute([$genre_id, $merchandise_id]);
        $cnt = $stmt->rowCount(); //取得件数
        if ($cnt == 0) throw new PDOException('データベースに登録されていません。');
    }else{
        $flg = 1;
        $message = '問題がありました。';
    }
}catch(PDOException $ex){
    $message = $ex->getMessage();//エラーメッセージ
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品詳細</title>
    <link rel="stylesheet" href="css/search_merchandise_detail.css">
</head>
<body>
<header class="header">
    <a href="management.php"><img src="img/header_name.png" alt="画像" class="header_log"></a>
    <p class="head_border"></p>
</header>
<?php
if($flg==0){
foreach ($stmt as $row){
    echo '<h2 class="merchandise_name">',htmlspecialchars($row['merchandise_name']),'</h2>';
    echo '<p class="image"><img src="',htmlspecialchars($row['image']),'" alt="商品画像" class="image_img"></p>';
    echo '<p class="price">商品価格：　　　¥<span class="cart_price">', htmlspecialchars(number_format($row['price'])),'</span></p>';
    echo '<p class="detail">商品詳細：</p>';
    echo '<p class="detail_contents">',htmlspecialchars($row['merchandise_detail']),'</p>';
}
echo '<p style="text-align: center;">',$message,'</p>';//エラーメッセージ
?>
<form action="management_merchandise_update.php" method="post">
    <?php
    echo '<input type="hidden" name="genre_id" value="',$genre_id,'">';
    echo '<input type="hidden" name="merchandise_id" value="',$merchandise_id,'">';
    ?>
    <button type="submit" value="send" class="search_update">update</button>
</form>
<form action="management.php" method="post"><button type="submit" value="send" class="search_top">top</button></form>

<form action="management_merchandise_delete.php" method="post">
    <?php
    echo '<input type="hidden" name="genre_id" value="',$genre_id,'">';
    echo '<input type="hidden" name="merchandise_id" value="',$merchandise_id,'">';
    ?>
    <p style="text-align: center;"><button type="submit" value="send" class="search_delete">delete</button></p>
</form>
<?php
}else{
    echo '<p style="text-align: center;">',$message,'</p>';//エラーメッセージ
    echo '<button type="button" value="send" class="search_update">update</button>';//ページの遷移はしない
    echo '<form action="management.php" method="post"><button type="submit" value="send" class="search_top">top</button></form>';
    echo '<p style="text-align: center;"><button type="button" value="send" class="search_delete">delete</button></p>';//ページの遷移はしない
}
?>

</body>
</html>
