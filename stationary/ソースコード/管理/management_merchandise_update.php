<?php //商品情報更新
$genre_id = @$_POST['genre_id'];//取得した情報を代入する
$merchandise_id = @$_POST['merchandise_id'];//取得した情報を代入する
$message = '';
$flg = 0;
try {
    if(strcmp($genre_id,'')!=0) {
        require "data_base.php";
        $pdo = data_base();//データベースログイン
        $stmt = $pdo->prepare(genre_merchandise());//商品の詳細を取得
        $stmt->execute([$genre_id, $merchandise_id]);
        $cnt = $stmt->rowCount(); //取得件数
        if ($cnt == 0) throw new PDOException('データベースに登録されていません。');
    }else{
        $message = '問題がありました。';
        $flg = 1;
    }
}catch(PDOException $ex){
    $flg = 1;
    $message = $ex->getMessage();//エラーメッセージ
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/merchandise_signup.css">
    <title>商品情報更新</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>
        let btnCheck = () =>{
            let beforeGoods = document.getElementById('goods').value;
            let beforePrice = document.getElementById('price').value;
            let beforeDetail = document.getElementById('detail').value;
            let lenPrice = beforePrice.length;

            if(beforeGoods.match(/[a-zA-Z0-9あ-んァ-ヾA-Z一-龠-ー*@/()$#&!%<>]{1,50}/) && beforeDetail.match(/[a-zA-Z0-9あ-んァ-ヾA-Z一-龠-ー*@/()$#&!%<>]{1,500}/) && lenPrice > 0){
                if(beforeGoods.match(/[a-zA-Z0-9あ-んァ-ヾA-Z一-龠-ー*@/()$#&!%<>]{51}/) || beforeDetail.match(/[a-zA-Z0-9あ-んァ-ヾA-Z一-龠-ー*@/()$#&!%<>]{501}/)){
                    swal('文字数をオーバーしています。');
                    return false;
                }else{
                    if(beforePrice.match(/[-]/)) {
                        swal('誤入力があります。');
                        return false;
                    }else{
                        if(document.File.file.value){
                            if(document.File.file.value.match(/[0-9a-zA-Z.]/)){
                                if(document.File.file.value.match(/[あ-んァ-ヾ一-龠０-９-()<>]/)){
                                    swal('ファイル名に誤りがあります。');
                                    return false;
                                }else {
                                    if (document.File.file.value.indexOf('png') !== -1||document.File.file.value.indexOf('jpeg') !== -1||document.File.file.value.indexOf('jpg') !== -1||document.File.file.value.indexOf('gif') !== -1) {
                                        return true;
                                    }else{
                                        swal('ファイル形式をpng/jpeg/jpg/gifのどれかにしてください。');
                                        return false;
                                    }

                                }
                            }else {
                                swal('ファイル名に誤りがあります。');
                                return false;
                            }
                        }else {
                            swal('ファイルを選択してください。');
                            return false;
                        }
                    }
                }
            }else{
                swal('文字数が足りません。');
                return false;
            }
        }
    </script>
</head>
<body>
<!--ヘッダーテキスト画像-->
<header class="header">
    <a href="management.php"><img src="img/header_name.png" alt="ヘッダー画像" class="header_name"></a>
    <p class="head_border"></p>
</header>
<!--form-->
<form action="merchandise_update_result.php" method="post" enctype="multipart/form-data" name="File">
    <div class="container">
        <h1 class="title">merchandise</h1>
        <h2 class="title" id="subtitle">update</h2>
        <div class="range">
<?php
if($flg==0) {
    echo '<input type="hidden" name="genre_id" value="', $genre_id, '">';
    echo '<input type="hidden" name="merchandise_id" value="', $merchandise_id, '">';
    foreach ($stmt as $row) {
        if ($row['genre_id'] == 1) {
            $genre_name = 'シャーペン';
        } else if ($row['genre_id'] == 2) {
            $genre_name = '消しゴム';
        } else if ($row['genre_id'] == 3) {
            $genre_name = 'ボールペン';
        } else if ($row['genre_id'] == 4) {
            $genre_name = '定規';
        } else {
            $genre_name = '事務用品';
        }
        echo '<p class="subtitle">ジャンル</p>';
        echo '<p class="merchandise">', htmlspecialchars($genre_name), '</p>';
        echo '<p class="subtitle">商品名<span class="span">※文字数：50文字以内/すでに登録されている商品名だと登録することはできません。</span></p>';
        echo '<p class="merchandise"><input type="text" name="goods" id="goods" class="text" value="', htmlspecialchars($row['merchandise_name']), '"></p>';

        echo '<p class="subtitle">価格<span class="span">※文字種：数字/制限：ハイフンはなし</span></p>';
        echo ' <p class="merchandise"><input type="number" name="price" id="price" class="number_text" value="', htmlspecialchars($row['price']), '"></p>';

        echo ' <p class="subtitle">画像<span class="span">※ファイル名：アルファベット(半角)・数字(半角)のみ</span></p>';
        ?>
        <p class="merchandise"><input type="file" name="file" class="file_text" ></p>
        <?php
        echo ' <p class="subtitle">商品詳細<span class="span">※文字数：500文字以内</span></p>';
        echo ' <p class="merchandise"><textarea name="detail" rows="5" cols="50" id="detail" class="textarea"></textarea></p>';
        echo ' <button value="send" class="btn" onsubmit="return btnCheck()" onclick="return btnCheck()">update</button>';
        echo ' </div>';
    }
echo '</form>';
}else{
    echo '<p style="text-align: center;">', $message, '</p>';//エラーメッセージ
    echo ' <button value="send" class="btn" type="button">update</button>';//ページの遷移はしない
}
?>

<form action="search_detail.php" method="post">
    <?php
    echo '<input type="hidden" name="genre_id" value="',$genre_id,'">';
    echo '<input type="hidden" name="merchandise_id" value="',$merchandise_id,'">';
    ?>
    <button type="submit" value="send" class="top_btn">back</button>
</form>
</div>
</body>
</html>
