<?php
//アドレス検索
$error_message = '';
$flg = 0;
$postalCode = @$_GET['number']; //ここに好きな郵便番号を代入
if (isset($postalCode)) {
    $url = 'http://zipcloud.ibsnet.co.jp/api/search?zipcode=' . $postalCode; //下7桁が任意の郵便番号になったurlを$urlに代入

//urlからはファイルが返される

    $resJson = file_get_contents($url); //ファイルの内容を文字列に読み込む
    $resJson = mb_convert_encoding($resJson, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN'); //文字化け防止
    $res = json_decode($resJson, true); //第二引数を「true」にすると配列型に変換

//返ってきた文字列を、それぞれの変数に代入して整理していく
    if (isset($res['results'][0]['address1'])) { //入力された郵便番号で住所を求めることができたらtrue・住所を求めることができなければfalseに行く
        $prefecture = $res['results'][0]['address1'];
        $city = $res['results'][0]['address2'];
        $city2 = $res['results'][0]['address3'];
        $zipcode = $res['results'][0]['zipcode'];
    } else {
        $error_message = '郵便番号から住所をもとめられません。';
        $flg = 1;
    }
}else{
    $error_message = '問題がありました。';
    $flg = 1;
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>住所取得</title>
    <link rel="stylesheet" href="css/information.css">
</head>
<body>
<header class="header">
    <p class="head_img"><img src="img/header_name.png" alt="画像" class="header_log"></p>
</header>
<?php
if($flg==0) { // flgが0の場合は住所が見つかった
    echo '<form action="signup_in.php" method="post">';
    echo '<input type="hidden" name="addre" value="', $prefecture . $city . $city2, '">';
    echo '<p class="search_p"><button type="submit" class="address_btn">', $prefecture . $city . $city2, '</button></p>';
    echo '</form>';
}else { // 住所が見つからなかった
    echo '<p style="text-align: center;margin-top: 50px;">', $error_message, '</p>';
    echo '<p style="text-align: center;"><a href="signup_in.php" style="border-bottom: 1px solid black;">戻る</a></p>';
}
?>
</body>
</html>
