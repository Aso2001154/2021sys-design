<?php /*管理画面の会員情報検索*/?>
<!DOCTYPE html>
    <html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>会員情報検索</title>
        <link rel="stylesheet" href="css/management_input.css">
    </head>
    <body>
    <header>
        <a href="management.php"><img src="img/header_name.png" alt="ヘッダー画像" class="header_name"></a>
        <p class="head_border"></p>
    </header>
        <h2 class="title" style="text-align: center;">会員情報検索</h2>
        <form action="management_output.php" method="post">
            <p class="search">会員idを入力</p>
            <p class="txt"><input type="text" name="user" class="input_txt"></p>
            <p class="search">会員passを入力</p>
            <p class="txt"><input type="text" name="pass" class="input_txt"></p>
            <p class="search_p"><button type="submit" value="send" class="search_btn">検索</button></p>
        </form>
    <form action="management.php" method="post"><p style="text-align: center;"><button type="submit" value="send" class="top_btn">top</button></p></form>
    </body>
 </html>