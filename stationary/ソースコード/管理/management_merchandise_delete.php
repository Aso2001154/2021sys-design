<?php
/*商品情報削除*/
$genre_id = @$_POST['genre_id'];//取得した情報を代入する   3
$merchandise_id = @$_POST['merchandise_id'];//取得した情報を代入する   7
$cnt = 1;//商品idの更新用で利用する
$message = '商品を削除しました';
if (strcmp($genre_id,'')!=0) {
    require "data_base.php";
    $pdo = data_base();//データベースログイン
    $stmt = $pdo->prepare(delete_detail());//history_detailから商品を削除する
    $stmt->execute([$genre_id, $merchandise_id]);

    $stmt = $pdo->prepare(delete_cart());//cartから商品を削除する
    $stmt->execute([$genre_id, $merchandise_id]);


    $stmt = $pdo->prepare(delete_merchandise());//merchandiseから商品を削除する
    $stmt->execute([$genre_id, $merchandise_id]);

}else{
    $message = '問題がありました。';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/merchandise_signup.css">
    <title>商品削除</title>
</head>
<body>
<header class="header">
    <p><img src="img/header_name.png" alt="画像" class="header_name"></p>
    <p class="head_border"></p>
</header>
 <?php echo '<p style="text-align: center;">',$message,'</p>';?>
<form action="management.php" method="post"><button type="submit" class="result_btn">top</button></form>
</body>
</html>
