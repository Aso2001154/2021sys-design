<?php /*管理画面*/
$file_flg=0;//if文を行うかの判断に利用する変数
$file_name = '';//ファイル名の初期値
if(isset($_POST['file_name'])){
    $file_flg = $_POST['file_flg'];
    $file_name = $_POST['file_name'];
}
if($file_flg==1){//商品登録から登録完了して戻った時に実行される
    copy( '../'.$file_name, $file_name);//管理画面に商品の画像をコピーする
}
?>
<!DOCTYPE html>
<html>
 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>管理画面</title>
     <link rel="stylesheet" href="css/management.css">
 </head>
 <body>
 <header>
    <p class="header_img"><img src="img/header_name.png" alt="ヘッダーの画像" class="header_name"></p>
 </header>
 <h1 style="text-align: center;">管理画面</h1>
 <div class="border">
     <p class="management_stock"><a href="stock.php">　在庫情報　</a></p><br>
     <p class="management_search"><a href="search_merchandise.php">　商品検索　</a></p><br>
     <p class="management_information"><a href="management_input.php">会員情報検索</a></p>
 </div>
 <div class="border1">
     <p class="management_sales"><a href="management_sales.php">　売上情報　</a></p><br>
     <p class="merchandise_signup"><a href="merchandise_signup.php">商品情報登録</a></p><br>
     <p class="information_signup"><a href="management_signup_in.php">会員情報登録</a></p>
 </div>
 </body>
</html>
