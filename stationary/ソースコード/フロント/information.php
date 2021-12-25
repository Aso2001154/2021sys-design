<?php
session_start();
 $user_number = @$_SESSION['user']['user_number'];
 $login_message = '';//エラーメッセージ用
 try {
     require "data_base.php";
     $pdo = data_base();//データベースログイン
    $stmt = $pdo->prepare(search_user());//ユーザーの情報を取得する
    $stmt -> execute([$user_number]);
    $cnt = $stmt -> rowCount(); //取得件数
     if($cnt == 0) throw new PDOException('問題があり情報を取得できませんでした。');//失敗時メッセージ

 }catch (PDOException $ex){
    $login_message = $ex->getMessage(); //エラーメッセージ
 }
?>
<!DOCTYPE html>
<html>
 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="css/information.css"><!-- login_in.php、login_in1.php、signup_in.php、signup_out.php、logout.php、information.php、information_out.php、re_signup_in.php、re_information.php-->
     <link rel="stylesheet" href="css/mobile_information.css" media="screen and (max-width:400px)">
     <title>会員情報</title>
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
                 swal('文字数が足りません。');
                 return false;
             }
         }
     </script>
 </head>
 <body>
 <header class="header">
         <a href="pencil.php"><img src="img/header_name.png" alt="画像" class="header_log"></a>
         <p class="head_border"></p>
 </header>
 <div class="container">
         <h1 class="title">information</h1>
     <form action="re_withdrawal.php" method="post"><button type="submit" value="send" class="withdrawal_btn">退会</button></form>
     <form action="re_information.php" method="post">
         <div class="range">
         <?php
         foreach ($stmt as $row) {
             echo '<h2 class="subtitle">id</h2><p class="width_p"><span class="span">※文字種：アルファベット、数字(半角)の組み合わせ/制限：ハイフン、*、@、/、(、)、<、>、$、#、&、%、!、ひらがな、カタカナ、漢字はなし/文字数：8文字</span></p>';
             echo '<p class="txt_information"><input type="text" class="text" id="id"name="user_id" value="',htmlspecialchars($row['user_id']), '"></p>';
             echo '<h2 class="subtitle">pass</h2><p class="width_p"><span class="span">※文字種：数字(半角)/制限:ハイフン、*、@、/、(、)、<、>、$、#、&、%、!、アルファベット、ひらがな、カタカナ、漢字はなし/文字数：4文字</span></p>';
             echo '<p class="txt_information"><input type="password" class="text" id="pass" name="user_pass" value="',htmlspecialchars($row['user_pass']), '"></p>';
             echo '<h2 class="subtitle">name</h2>';
             echo '<p class="txt_information"><input type="text" class="text" id="name" name="user_name" value="',htmlspecialchars($row['user_name']), '"></p>';
             echo '<h2 class="subtitle">address</h2>';
             echo '<p class="txt_information"><input type="text" class="text" id="address" name="user_address" value="',htmlspecialchars($row['user_address']), '"></p>';
             echo '<h2 class="subtitle" id="credit_number">credit number</h2><p class="width_p"><span class="span">※文字種：数字/制限：ハイフンはなし/文字数：16文字</span></p>';
             echo '<p class="txt_information"><input type="number" class="number_text" id="credit" name="credit_number" value="',htmlspecialchars($row['credit_number']),'"></p>';
             $beforeId = $row['user_id'];
         }
        echo '<p style="text-align: center">',$login_message,'</p>';//失敗メッセージ
         echo '<button value="send" class="login" id="login_info" onsubmit="return btnCheck()" onclick="return btnCheck()">確認</button>';
         ?>
         </div>
         <?php echo '<input type="hidden" value="',$beforeId,'" name="beforeId">';?>
     </form>
     <form action="pencil.php" method="post"><button type="submit" value="send" class="top_info">top</button></form>
 </div>
 </body>
</html>
