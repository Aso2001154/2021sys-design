<?php
$user_name = '';
$addre = '';
$user_name = @$_POST['user_name'];
if(isset($_POST['addre'])){//郵便番号の検索結果の処理を行う
    $addre = $_POST['addre'];//検索した郵便番号に合致した住所を$addreに代入する
}else if(isset($_POST['user_address'])){//re_signup_inから入力されている住所を$addreに格納する
    $addre = $_POST['user_address'];
}else{
    $addre="";//一番初期の状態
}
?>
<!DOCTYPE html>
<html la="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/information.css"><!-- login_in.php、login_in1.php、signup_in.php、signup_out.php、re_signup_in.pho、logout.php、information.php、information_out.php、re_information.php-->
    <link rel="stylesheet" href="css/mobile_information.css" media="screen and (max-width:400px)">
    <title>新規登録</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>
        let btnCheck = () =>{
            let beforeId = document.getElementById('id').value;
            let beforePass = document.getElementById('pass').value;
            let beforeCredit = document.getElementById('credit').value;
            if(beforeId.match(/[a-zA-Z0-9]{8}/) && beforePass.match(/[0-9]{4}/) && beforeCredit.match(/[0-9]{16}/)){
                if(beforeId.match(/[a-zA-Z0-9]{9}/) || beforePass.match(/[0-9]{5}/) || beforeCredit.match(/[0-9]{17}/)) {
                    swal('文字数をオーバーしています。');
                    return false;
                }else{
                    if(beforeId.match(/^[a-zA-Z0-9]+$/u) && beforePass.match(/^[0-9]+$/u) && beforeCredit.match(/^[0-9]+$/u)) {
                        if(beforeId.match(/[a-zA-Z]/)&&beforeId.match(/[0-9]/)) {
                            return true;
                        }else{
                            swal('idはアルファベットと数字の組み合わせにしましょう。');
                            return false;
                        }
                    }else{
                        swal('誤入力があります。');
                        return false;
                    }
                }
            }else{
                swal('文字数が足りない部分があります。');
                return false;
            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>
        let btnNumber = () =>{
            let beforeNumber = document.getElementById('id_number').value;
            if(beforeNumber.match(/[-]/)) {
                swal('ハイフンを消しましょう。');
                return false;
            }else{
                if(beforeNumber.match(/[0-9]{7}/)) {
                    if(beforeNumber.match(/[0-9]{8}/)) {
                        swal('文字数をオーバーしています。7桁で入力してください。');
                        return false;
                    }else{
                        return true;
                    }
                }else {
                    swal('文字数が足りません。');
                    return false;
                }
            }
        }
    </script>
</head>
<body>
<header class="header">
    <a href="login_in.php"><img src="img/header_name.png" alt="画像" class="header_log"></a>
    <p class="head_border"></p>
</header>
<div id="app">
<div class="container">
    <h1 class="title">sign up</h1>
   <form action = "address_out.php" method= "get">
       <p class="search"><input type = "number" name ="number" id="id_number" placeholder="郵便番号で検索" class="number_input"></p>
       <p class="search_btn_p"><button value = "send" onsubmit="return btnNumber()" onclick="return btnNumber()" class="search_btn">検索</button>
   </form>
    <form action="re_signup_in.php" method="post">
        <div class="range">
            <h2 class="subtitle">id</h2><p class="width_p"><span class="span">※文字種：アルファベット、数字(半角)の組み合わせ/制限：ハイフン、*、@、/、(、)、<、>、$、#、&、%、!、ひらがな、カタカナ、漢字はなし/文字数：8文字</span></p>
            <?php echo '<p class="txt_information"><input type="text" class="text" name="user_id" id="id" v-model="id"></p>'; ?>
            <p v-if="isInValidId" class="error_signup">制限を満たしていません。</p>

            <h2 class="subtitle">pass</h2><p class="width_p"><span class="span">※文字種：数字(半角)/制限：ハイフン、*、@、/、(、)、<、>、$、#、&、%、!、アルファベット、ひらがな、カタカナ、漢字はなし/文字数：4文字</span></p>
            <?php echo '<p class="txt_information"><input type="password" class="text" name="user_pass" id="pass" v-model="pass"></p>'; ?>
            <p v-if="isInValidPass" class="error_signup">制限を満たしていません。</p>

            <h2 class="subtitle">name</h2>
            <?php  echo '<p class="txt_information"><input type="text" class="text" name="user_name" id="name"value="',htmlspecialchars($user_name),'"></p>'; ?>
            <h2 class="subtitle">address</h2>
            <?php echo '<p class="txt_information"><input type="text" class="text" name="user_address" id="address" value="',htmlspecialchars($addre),'"></p>'; ?>
            <h2 class="subtitle">credit number</h2><p class="width_p"><span class="span">※文字種：数字/制限：ハイフンなし/文字数：16文字</span></p>
            <?php echo '<p class="txt_information"><input type="number" class="number_text" name="credit_number" id="credit" v-model="credit"></p>'; ?>
            <p v-if="isInValidCredit" class="error_signup">制限を満たしていません。</p>

            <p class="signup_login"><button value="send" onsubmit="return btnCheck()" onclick="return btnCheck()" class="signup_btn">確認</button></p>
        </div>
    </form>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="js/limit.js"></script>
</body>
</html>
