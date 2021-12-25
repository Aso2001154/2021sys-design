<?php //管理画面の商品登録 ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/merchandise_signup.css">
    <title>商品情報登録</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>
        let btnCheck = () =>{
            let beforeGoods = document.getElementById('goods').value;
            let beforePrice = document.getElementById('price').value;
            let beforeDetail = document.getElementById('detail').value;
            let lenPrice = beforePrice.length;

            if(beforeGoods.match(/[a-zA-Z0-9あ-んA-Zァ-ヾ一-龠-ー*@/()$#&!%<>]{1}/) && beforeDetail.match(/[a-zA-Z0-9あ-んァ-ヾ一-龠A-Z-ー*@/()$#&!%<>]{1}/) && lenPrice > 0){
                if(beforeGoods.match(/[a-zA-Z0-9あ-んァ-ヾA-Z一-龠-ー*@/()$#&!%<>]{51}/) || beforeDetail.match(/[a-zA-Z0-9あ-んァ-ヾ一-龠A-Z-ー*@/()$#&!%<>]{501}/)){
                    swal('文字数をオーバーしています。');
                    return false;
                }else{
                    if(beforePrice.match(/[-]/)) {
                        swal('誤入力があります。');
                        return false;
                    }else{
                        if(document.File.file.value){
                            if(document.File.file.value.match(/[0-9a-zA-Z.]/)){
                                if(document.File.file.value.match(/[あ-んァ-ヾ一-龠０-９()<>]/)){
                                    swal('ファイル名に誤りがあります。');
                                    return false;
                                }else {
                                    if (document.File.file.value.indexOf('png') === 0||document.File.file.value.indexOf('jpeg') === 0||document.File.file.value.indexOf('jpg') === 0||document.File.file.value.indexOf('gif') === 0) {
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
<form action="merchandise_result.php" method="post" enctype="multipart/form-data" name="File">
    <div class="container">
        <h1 class="title">new merchandise</h1>
        <div class="range">
            <p class="subtitle">ジャンル</p>
            <select name="genre" class="merchandise">
                <option value="1">シャーペン</option>
                <option value="2">消しゴム</option>
                <option value="3">ボールペン</option>
                <option value="4">定規</option>
                <option value="5">事務用品</option>
            </select>

            <p class="subtitle">商品名<span class="span">※文字数：50文字以内/すでに登録されている商品名だと登録することはできません。</span></p>
            <p class="merchandise"><input type="text" name="goods" id="goods" class="text"></p>

            <p class="subtitle">価格<span class="span">※文字種：数字/制限：ハイフンはなし</span></p>
            <p class="merchandise"><input type="number" name="price" id="price" class="number_text"></p>

            <p class="subtitle">画像<span class="span">※ファイル名：アルファベット(半角)・数字(半角)のみ</span></p>
            <p class="merchandise"><input type="file" name="file" class="file_text" ></p>
            <p class="subtitle">商品詳細<span class="span">※文字数：500文字以内</span></p>
            <p class="merchandise"><textarea name="detail" rows="5" cols="50" id="detail" class="textarea"></textarea></p>
            <button value="send" class="btn" onsubmit="return btnCheck()" onclick="return btnCheck()">register</button>
        </div>
</form>
<form action="management.php" method="post"><button type="submit" value="send" class="top_btn">top</button></form>
</div>
</body>
</html>