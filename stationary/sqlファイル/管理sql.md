```
<?php
//データベースへログイン
function data_base(){
    return new PDO(
        'mysql:host=mysql153.phy.lolipop.lan;
        dbname=LAA1291139-company;charset=utf8',
        'LAA1291139',
        'company',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
}
//idだけで会員を探すためのsql
function user_id(){
    return 'SELECT * FROM `user` WHERE `user_id` = ?';
}
//会員情報検索(id,pass)
function user(){
    return 'SELECT * FROM `user` WHERE `user_id` = ? AND `user_pass` = ?';
}

//ジャンルIDで出力する商品を求める
function merchandise(){
    return 'SELECT * FROM `merchandise` WHERE `genre_id` = ?';
}

//　ジャンルIDと商品IDから商品を求める
function genre_merchandise(){
    return 'SELECT * FROM `merchandise` WHERE `genre_id` = ? AND `merchandise_id` = ?';
}

//売上を求める
function sales(){
    return 'select merchandise.genre_id,merchandise.merchandise_id,merchandise.merchandise_name,merchandise.image,merchandise.price,(merchandise.price*detail.quantity)as all_price
from (select history_genre_id,history_merchandise_id,sum(history_quantity)as quantity
from history_detail
group by history_genre_id,history_merchandise_id) detail,merchandise
where merchandise.genre_id = detail.history_genre_id and merchandise.merchandise_id = detail.history_merchandise_id
and merchandise.genre_id = ?';
}
//ジャンル名で出力する商品を求める
function genre_name(){
    return 'SELECT * FROM `merchandise` WHERE `genre_id` = ?';
}
//商品名で出力する商品を求める
function merchandise_name(){
    return 'SELECT * FROM `merchandise` WHERE `merchandise_name` LIKE ?';
}

//会員登録(追加)
function user_add(){
    return 'INSERT INTO `user`
            (`user_id`, `user_pass`, `user_name`, `user_address`,`credit_number`)
            VALUES(?,?,?,?,?)';
}

//会員情報(更新)
function user_update(){
    return 'UPDATE `user` SET `user_id` = ?,`user_pass` = ?,`user_name` = ?,`user_address` = ?,`credit_number` = ?
            WHERE `user_id` = ?';
}

//商品検索(同じ商品名があるかどうか)
function merchandise_all(){
    return 'SELECT * FROM merchandise WHERE merchandise_name = ?';
}

//在庫補充(更新)
function stock(){
    return 'update `merchandise` set `stock` =  `stock` + 500 WHERE `genre_id` = ? and `merchandise_id` = ?';
}

//商品登録
function insert_merchandise(){
    return 'INSERT INTO merchandise(genre_id,merchandise_id,merchandise_name,price,image,merchandise_detail,stock)
                                            VALUES (?,?,?,?,?,?,?)';
}

//商品詳細削除
function delete_detail(){
    return 'DELETE FROM `history_detail` WHERE `history_genre_id` = ? AND `history_merchandise_id` = ?';
}
//カートの中身から削除
function delete_cart(){
    return 'DELETE FROM `cart` WHERE `cart_genre_id` = ? AND `cart_merchandise_id` = ?';
}
//商品削除
function delete_merchandise(){
    return 'DELETE FROM `merchandise` WHERE `genre_id` = ? AND `merchandise_id` = ?';
}
//商品更新
function update_merchandise(){
    return 'UPDATE `merchandise` SET `merchandise_id` = ? WHERE `genre_id` = ? AND `merchandise_id` = ?';
}
?>

```
