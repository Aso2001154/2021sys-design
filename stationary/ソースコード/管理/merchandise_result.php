<?php //管理画面の商品情報登録完了、失敗
$message='商品の登録完了';
$flg=0;
if(isset($_POST['genre'])) {
    require "data_base.php";
    $pdo = data_base();//データベースログイン

    $sql = $pdo->prepare(merchandise());//商品検索
    $sql->execute([$_POST['genre']]);
    foreach ($sql as $row) {
        $max_merchandise = $row['merchandise_id'];//maxの商品idを取得する
    }
    $max_merchandise = $max_merchandise + 1;//すでに登録されているmaxの商品の商品idに＋１をしてデータベース追加に利用する
    $sql1 = $pdo->prepare(merchandise_all());//すべての商品から同じ商品名がないかを確かめるために取得する
    $sql1->execute([$_POST['goods']]);
    $cnt = $sql1->rowCount();
    if ($cnt == 0) {//0の場合：同じ名前がデータベースに存在しない　1より大きい場合：同じ名前が存在した
        //フロントに画像を保存
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            if (!file_exists('img')) {//imgのフォルダがなければimgのフォルダを作成する
                mkdir('img');
            }
            $file = '../img/' . basename($_FILES['file']['name']);//フロントのimgのディレクトリの中に保存するためのパスの指定をして変数に代入している
            if (move_uploaded_file($_FILES['file']['tmp_name'], $file)) {
                $file = 'img/' . basename($_FILES['file']['name']);//データベースに保存するために正しいパスの指定にしなおして変数に代入している
                $sql = $pdo->prepare(insert_merchandise());//商品の登録
                $sql->bindValue(1, htmlspecialchars($_POST['genre']), PDO::PARAM_STR);
                $sql->bindValue(2, htmlspecialchars($max_merchandise), PDO::PARAM_STR);
                $sql->bindValue(3, htmlspecialchars($_POST['goods']), PDO::PARAM_STR);
                $sql->bindValue(4, htmlspecialchars($_POST['price']), PDO::PARAM_STR);
                $sql->bindValue(5, htmlspecialchars($file), PDO::PARAM_STR);
                $sql->bindValue(6, htmlspecialchars($_POST['detail']), PDO::PARAM_STR);
                $sql->bindValue(7, htmlspecialchars(500), PDO::PARAM_STR);
                $sql->execute();
            } else {
                $message = '商品の登録失敗';
                $flg = 1;
            }
        } else {
            $message = '商品の登録失敗';
            $flg = 1;
        }

    } else {
        $message = '商品の登録失敗';
        $flg = 1;
    }
}else{
    $message = '問題がありました。';
    $flg = 1;
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/merchandise_signup.css">
    <title>商品情報登録</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
</head>
<body>
<header class="header">
        <p><img src="img/header_name.png" alt="ヘッダー画像" class="header_name"></p>
        <p class="head_border"></p>
</header>

<?php
if($flg == 0){
    // 無事に登録完了
    echo '<h2 class="message">',$message,'</h2>';
    echo '<form action="management.php" method="post">';
    echo '<input type="hidden" value="1" name="file_flg">';
    echo '<input type="hidden" value="',$file,'" name="file_name">';
    echo '<button type="submit" value="send" class="result_btn">top</button>';
    echo '</form>';
}else if($flg == 1){
// 登録失敗
    echo '<h2 class="message">',$message,'</h2>';
    echo '<form action="merchandise_signup.php" method="post">';
    echo '<button type="submit" value="send" class="product_btn">product</button>';
    echo '</form>';
}
//DBの接続解除
$pdo = null;
?>
</body>
</html>