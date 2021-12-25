<?php /*管理画面の商品検索*/?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品検索</title>
    <link rel="stylesheet" href="css/search_merchandise.css">
</head>
<body>
<header>
    <a href="management.php"><img src="img/header_name.png" alt="ヘッダー画像" class="header_name"></a>
    <p class="head_border"></p>
</header>
<p class="search">商品検索</p>
<form action="search_result.php" method="post">
    <p class="txt"><input type="text" name="text" class="input_txt"></p>
    <p class="search_p"><button type="submit" value="send" class="search_btn">検索</button></p>
</form>
<form action="management.php" method="post"><p style="text-align: center;"><button type="submit" value="send" class="top_btn">top</button></p></form>
</body>
</html>
