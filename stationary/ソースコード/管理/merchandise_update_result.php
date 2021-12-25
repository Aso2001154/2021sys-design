<?php //管理画面の商品情報更新完了、失敗
$genre_id = @$_POST['genre_id'];//取得した情報を代入する
$genre = @$_POST['merchandise_id'];//取得した情報を代入する
$message='商品の更新完了';
$flg=0;//更新成功失敗のフラグ用変数
if (strcmp($genre_id,'')!=0) {
    require "data_base.php";
    $pdo = data_base();//データベースログイン

    $sql1 = $pdo->prepare(merchandise_all());//同じ商品名がないか検索する
    $sql1->execute([$_POST['goods']]);
    $cnt = $sql1->rowCount();
    if ($cnt == 0) {//0の場合：同じ名前が存在しない　1以上の場合：同じな目がデータベースに存在する
        //フロントに画像を保存
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            if (!file_exists('img')) {//imgのフォルダがあるか
                mkdir('img');//ない場合imgのフォルダを作成する
            }
            $file = '../img/' . basename($_FILES['file']['name']);//フロントのimgのディレクトリの中に保存するためのパスの指定をして変数に代入している
            if (move_uploaded_file($_FILES['file']['tmp_name'], $file)) {
                $file = 'img/' . basename($_FILES['file']['name']);//データベースに保存するために正しいパスの指定にしなおして変数に代入している
                $sql = $pdo->prepare('UPDATE `merchandise` SET `merchandise_name` = ?,`price` = ?,`image` = ?,`merchandise_detail` = ? 
                    WHERE `genre_id` = ? AND `merchandise_id` = ?');
                $sql->execute([$_POST['goods'], $_POST['price'], $file, $_POST['detail'], $genre_id, $genre]);
            } else {
                $message = '商品の更新失敗';
                $flg = 1;
            }
        } else {
            $message = '商品の更新失敗';
            $flg = 1;
        }

    } else {
        $message = '商品の更新失敗';
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
    <title>商品情報更新</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
</head>
<body>
<header class="header">
    <p><img src="img/header_name.png" alt="ヘッダー画像" class="header_name"></p>
    <p class="head_border"></p>
</header>

<?php
if($flg == 0){
    // 無事に更新完了
    echo '<h2 class="message">',$message,'</h2>';
    echo '<form action="management.php" method="post">';
    echo '<input type="hidden" value="1" name="file_flg">';
    echo '<input type="hidden" value="',$file,'" name="file_name">';
    echo '<button type="submit" value="send" class="result_btn">top</button>';
    echo '</form>';
}else if($flg == 1){
// 更新失敗
    echo '<h2 class="message">',$message,'</h2>';
    echo '<form action="search_detail.php" method="post">';
    echo '<input type="hidden" name="genre_id" value="',$genre_id,'">';
    echo '<input type="hidden" name="merchandise_id" value="',$genre,'">';
    echo '<button type="submit" value="send" class="product_btn">product</button>';
    echo '</form>';
}
//DBの接続解除
$pdo = null;
?>
</body>
</html>