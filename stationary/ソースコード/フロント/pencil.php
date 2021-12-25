<?php
session_start();
require "data_base.php";// データベースログインの為の情報を関数化し別のファイルから呼んでいる
$pdo = data_base();
$name = 'ゲスト';
$genre_id = 1; // 始めはシャーペンの商品が表示されるようにする
$login_message = ''; // エラーメッセージ用
$back_image = [];
if(@$_POST['genre_id']){
    $genre_id = @$_POST['genre_id']; //ジャンルによって出力する商品を変える
}
// ログインしている時とログインしていない時で飛ぶページを変えるため、その情報を変数の中に入れている
$action_login = '<form action="login_in.php" method="post">';
$action_cart = '<form action="cart.php" method="post">';
$action_information = '<form action="information.php" method="post">';
$action_history = '<form action="history.php" method="post">';
$form_login = '<p class="btn_p"><button type="submit" class="btn">ログイン</button></p>';
$form_cart = '<p class="btn_p"><button type="submit" class="btn" onclick="btnCheck()">カート</button></p>';
$form_information = '<p class="btn_p"><button type="submit" class="btn" onclick="btnCheck()">会員情報</button></p>';
$form_history = '<p class="btn_p"><button type="submit" class="btn" onclick="btnCheck()">購入履歴</button></p>';
if(isset($_SESSION['user'])){ // userセッションにデータが入っていればログイン状態
    $user_number = @$_SESSION['user']['user_number'];
    $action_login = '<form action="logout.php" method="post">';
    $form_login1 = '<p class="btn_p"><button type="submit" class="btn">ログアウト</button></p>';
    $form_cart1 = '<p class="btn_p"><button type="submit" class="btn">カート</button></p>';
    $form_information1 = '<p class="btn_p"><button type="submit" class="btn">会員情報</button></p>';
    $form_history1 = '<p class="btn_p"><button type="submit" class="btn">購入履歴</button></p>';
    $user_stmt = $pdo->prepare(search_user());
    $user_stmt -> execute([$user_number]);
    foreach ($user_stmt as $row) {
        $name = $row['user_name'];//データベースに保存されているユーザーの名前を$nameに代入する
    }
}

try {
    $sql = merchandise(); //ジャンル別の商品を表示する
    $stmt = $pdo->prepare($sql);
    $stmt -> execute([$genre_id]);
    $cnt = $stmt -> rowCount(); //取得件数
    if($cnt == 0) throw new PDOException('商品がありません'); // cntが0の場合データベースにそのジャンルの商品が一つもないということなのでエラーメッセージを出力するようにしている
    $i=1;
    if($genre_id==1){ $img='シャーペン'; for($i=1;$i<4;$i++){array_push($back_image,'backimage'.$i);}} // ジャンルIDによって出力する背景をここで判断して変えている
    else if($genre_id==2){ $img='消しゴム'; for($i=4;$i<7;$i++){array_push($back_image,'backimage'.$i);}}
    else if($genre_id==3){ $img='ボールペン'; for($i=7;$i<10;$i++){array_push($back_image,'backimage'.$i);}}
    else if($genre_id==4){ $img='定規'; for($i=10;$i<13;$i++){array_push($back_image,'backimage'.$i);}}
    else if($genre_id==5){ $img='事務用品'; for($i=13;$i<16;$i++){array_push($back_image,'backimage'.$i);}}

}catch (PDOException $ex){
    $login_message = $ex->getMessage(); //エラーメッセージ
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/top.css">
    <link rel="stylesheet" href="css/mobile_top.css" media="screen and (max-width:400px)">
    <?php
    if($genre_id==4){ //ジャンルが定規を選択させている時に呼び出されるcss
        echo '<link rel="stylesheet" href="css/top_ruler.css">';
        echo '<link rel="stylesheet" href="css/mobile_top_ruler.css" media="screen and (max-width:400px)">';
    }
    ?>

    <title>商品一覧</title>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script>
        // ログインしていないときに表示させる
        let btnCheck = () =>{
            alert("ログインしないとクリックをすることはできません。");
        }
    </script>

    <script> // 上部にスクロールさせるための処理
        $(function(){
            var $scroll_button = $(".scroll-button");
            $(window).scroll(function(){
                var scrollTop = $(window).scrollTop();
                if(scrollTop > $(window).height()){
                    $scroll_button.css("opacity", ".7");
                }else{
                    $scroll_button.css("opacity", "0");
                }
            });
            $scroll_button.click(function(){
                $("html,body").animate({scrollTop: 0}, 500, "swing");
            });
        });
    </script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script type="text/javascript">
        $(function(){
            var setImg = '#photo';
            var fadeSpeed = 1600;
            var switchDelay = 5000;

            $(setImg).children('img').css({opacity:'0'});
            $(setImg + ' img:first').stop().animate({opacity:'1',zIndex:'20'},fadeSpeed);

            setInterval(function(){
                $(setImg + ' :first-child').animate({opacity:'0'},fadeSpeed).next('img').animate({opacity:'1'},fadeSpeed).end().appendTo(setImg);
            },switchDelay);
        });
    </script>
</head>
<body>
<header class="header">
    <div class="list"><img src="img/header_name.png" alt="画像" class="header_name"></div><!--ヘッダーの画像-->
    <?php echo $action_login;?><!--ログインしていたらログアウトにとぶ-->
    <?php if(isset($form_login1)){echo $form_login1;}echo '</form>';?>

    <?php echo $action_login;?><!--ログインしていなかったらログインのボタンでログイン画面にとぶ-->
    <?php if(!isset($form_login1)){echo $form_login;}echo '</form>';?>

    <?php echo $action_cart;?><!--ログインしていたらカートにとぶ-->
    <?php if(isset($form_cart1)){echo $form_cart1;}echo '</form>';?>

    <?php echo $action_login;?><!--ログインしていなかったらカートのボタンでログイン画面にとぶ-->
    <?php if(!isset($form_cart1)){echo $form_cart;}echo '</form>';?>

    <?php echo $action_information;?><!--ログインしていたら会員情報にとぶ-->
    <?php if(isset($form_information1)){echo $form_information1;}echo '</form>';?>

    <?php echo $action_login;?><!--ログインしていなかったら会員情報のボタンでログイン画面にとぶ-->
    <?php if(!isset($form_information1)){echo $form_information;}echo '</form>';?>

    <?php echo $action_history;?><!--ログインしていたら履歴にとぶ-->
    <?php if(isset($form_history1)){echo $form_history1;}echo '</form>';?>

    <?php echo $action_login;?><!--ログインしていなかったら履歴のボタンでログイン画面にとぶ-->
    <?php if(!isset($form_history1)){echo $form_history;}echo '</form>';?>
</header>
<div class="genre_list">
    <form action="pencil.php" method="post"><input type="hidden" value="1" name="genre_id"><p class="genre_name"><button type="submit" value="send" class="genre" id="genre1">シャーペン</button></p></form><!--開いているジャンルのボタンは押せなくする(disabled)-->
    <form action="pencil.php" method="post"><input type="hidden" value="2" name="genre_id"><p class="genre_name"><button type="submit" value="send" class="genre" id="genre2">消しゴム</button></p></form>
    <form action="pencil.php" method="post"><input type="hidden" value="3" name="genre_id"><p class="genre_name"><button type="submit" value="send" class="genre" id="genre3">ボールペン</button></p></form>
    <form action="pencil.php" method="post"><input type="hidden" value="4" name="genre_id"><p class="genre_name"><button type="submit" value="send" class="genre" id="genre4">定　　規</button></p></form>
    <form action="pencil.php" method="post"><input type="hidden" value="5" name="genre_id"><p class="genre_name"><button type="submit" value="send" class="genre" id="genre5">事務用品</button></p></form>
    <form action="ranking.php" method="post"><p class="genre_name"><button type="submit" value="send" class="genre" id="genre6">ランキング</button></p></form><br><br>
</div>
<?php echo '<div style="float: left;margin-left: 20px;"><p class="user_name">ユーザー名：</p><span class="user_span"><p class="user_name_p">',htmlspecialchars($name),'様</p></span></div>';?>
<div style="float: none;color: white">回り込み解除</div>
<br><br>
<?php
// ログインしていない時としている時で遷移するページが違う
if(isset($form_login1)){
    echo '<form action="search.php" method="post">';
    echo '<div class="search_div"><input type="text" class="text" name="text" placeholder="商品名検索"></div>';
    echo '<button type="submit" class="search_btn"><img src="img/検索ボタン.png" alt="検索" class="search"></button>';
    echo '</form>';
}else{
    echo $action_login;
    echo '<div class="search_div"><input type="text" class="text" name="text" placeholder="商品名検索"></div>';
    echo '<button type="submit" class="search_btn" onclick="btnCheck()"><img src="img/検索ボタン.png" alt="検索" class="search"></button>';
    echo '</form>';
}
?>
<br><br><br>
<?php
echo '<div id="photo">';
echo '<img src="img/',$img,'背景.png" alt="背景画像" class="back_img">';
for($i=0;$i<3;$i++) {
    echo '<img src="img/',$back_image[$i],'.png" alt="背景画像" class="back_img">';
}
echo '</div>';
?>
<?php
$cnt=0;
foreach ($stmt as $row){
    if($i%2!=0){
        // 奇数の場合
        if(isset($_SESSION['user'])) {
            // ログインしている時
            echo '<form action="merchandise_detail.php" method="post" name="a_form',$cnt,'">';
            echo '<div class="border_vertical">';
            echo '<input type="hidden" name="genre_id" value="', $row['genre_id'], '">';
            echo '<input type="hidden" name="merchandise_id" value="', $row['merchandise_id'], '">';
            echo '<div class="merchandise_range">';
            echo '<p class="p_btn"><a class="merchandise_img_btn" href="#" onclick="document.a_form',$cnt,'.submit();"><img src="', htmlspecialchars($row['image']), '" alt="商品画像" class="merchandise_img"></a></p>'; //ボタンをaタグにする
            echo '<p class="p_btn"><a class="merchandise_name_btn" href="#" onclick="document.a_form',$cnt,'.submit();">', htmlspecialchars($row['merchandise_name']), '<br>¥', htmlspecialchars(number_format($row['price'])), '</a></p>';
            echo '</div>';
            echo '</div>';
            echo '</form>';
        }else{
            // ログインしていない時
            echo '<form action="login_in.php" method="post" name="a_form',$cnt,'">'; // login.phpのページへ遷移
            echo '<div class="border_vertical">';
            echo '<div class="merchandise_range">';
            echo '<p class="p_btn"><a class="merchandise_img_btn" href="#" onclick="document.a_form',$cnt,'.submit();"><img src="', htmlspecialchars($row['image']), '" alt="商品画像" class="merchandise_img"></a></p>'; //ボタンをaタグにする
            echo '<p class="p_btn"><a class="merchandise_name_btn" href="#" onclick="document.a_form',$cnt,'.submit();">', htmlspecialchars($row['merchandise_name']), '<br>¥', htmlspecialchars(number_format($row['price'])), '</a></p>';
            echo '</div>';
            echo '</div>';
            echo '</form>';
        }
    }else{
        // 偶数の場合
        if(isset($_SESSION['user'])) {
            // ログインしている時
            echo '<form action="merchandise_detail.php" method="post" name="a_form',$cnt,'">';
            echo '<div class="border_vertical1">';
            echo '<input type="hidden" name="genre_id" value="', $row['genre_id'], '">';
            echo '<input type="hidden" name="merchandise_id" value="', $row['merchandise_id'], '">';
            echo '<div class="merchandise_range">';
            echo '<p class="p_btn"><a class="merchandise_img_btn" href="#" onclick="document.a_form',$cnt,'.submit();"><img src="', htmlspecialchars($row['image']), '" alt="商品画像" class="merchandise_img"></a></p>'; //ボタンをaタグにする
            echo '<p class="p_btn"><a class="merchandise_name_btn" href="#" onclick="document.a_form',$cnt,'.submit();">', htmlspecialchars($row['merchandise_name']), '<br>¥', htmlspecialchars(number_format($row['price'])), '</a></p>';
            echo '</div>';
            echo '</div>';
            echo '</form>';
        }else{
            // ログインしていない時
            echo '<form action="login_in.php" method="post" name="a_form',$cnt,'">'; // login_in.phpのページへ遷移
            echo '<div class="border_vertical1">';
            echo '<div class="merchandise_range">';
            echo '<p class="p_btn"><a class="merchandise_img_btn" href="#" onclick="document.a_form',$cnt,'.submit();"><img src="', htmlspecialchars($row['image']), '" alt="商品画像" class="merchandise_img"></a></p>'; //ボタンをaタグにする
            echo '<p class="p_btn"><a class="merchandise_name_btn" href="#" onclick="document.a_form',$cnt,'.submit();">', htmlspecialchars($row['merchandise_name']), '<br>¥', htmlspecialchars(number_format($row['price'])), '</a></p>';
            echo '</div>';
            echo '</div>';
            echo '</form>';
        }
    }
    $cnt++;
    $i++;
}
echo '<p style="text-align: center;">',$login_message,'</p>'; // データベースに商品の情報が1つもない時に出力する
?>
<div class="scroll-button"></div> <!--スクロールのボタンを表示させる-->
</body>
</html>