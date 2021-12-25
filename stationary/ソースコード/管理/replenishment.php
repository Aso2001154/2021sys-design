<?php //管理画面の商品補充
$genre_id = @$_POST['genre_id'];//取得した情報を代入する
$merchandise_id = @$_POST['merchandise_id'];//取得した情報を代入する
$message = '商品を補充しました';
try {
    if(!isset($genre_id)){throw new PDOException('問題がありました。');}
    require "data_base.php";
    $pdo = data_base();//デーベースログイン
    $stmt = $pdo->prepare(stock());//商品の在庫を補充する
    $stmt->execute([$genre_id, $merchandise_id]);
}catch (PDOException $ex){
    $message = $ex->getMessage();
}

?>
<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>在庫情報</title>
    <link rel="stylesheet" href="css/merchandise_stock.css">

</head>
<body>
<header>
    <a href="management.php"><img src="img/header_name.png" alt="画像" class="header_name"></a>
    <p style="border-bottom: 2px solid black;"></p>
</header>
<?php echo '<p class="replenishment">',$message,'</p>';?>
<?php
echo '<form action="stock.php" method="post">';
echo '<p style="text-align: center;"><button type="submit" value="send" class="top">top</button></p></form>';
?>
</body>
</html>