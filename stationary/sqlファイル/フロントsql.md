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
//会員情報登録
function user_signup(){
    return 'INSERT INTO `user`
            (`user_id`, `user_pass`, `user_name`, `user_address`,`credit_number`)
            VALUES(?,?,?,?,?)';
}

//会員情報更新
function update_user(){
    return 'UPDATE `user` SET `user_id` = ?,`user_pass` = ?,`user_name` = ?,`user_address` = ?,`credit_number` = ?
            WHERE `user_number` = ?';
}
//会員情報検索(user_number)
function search_user(){
    return 'SELECT * FROM `user` WHERE `user_number` = ?';
}
//ジャンルIDで出力する商品を求める
function merchandise(){
    return 'SELECT * FROM `merchandise` WHERE `genre_id` = ?';
}
function genre_merchandise(){
    return 'select * from `merchandise` where `genre_id` = ? and `merchandise_id` = ?';
}
//ジャンル名で出力する商品を求める
function genre_name(){
    return 'SELECT * FROM `merchandise` WHERE `genre_id` = ?';
}
//商品名で出力する商品を求める
function merchandise_name(){
    return 'SELECT * FROM `merchandise` WHERE `merchandise_name` LIKE ?';
}
//すべての商品のランキング
function ranking_all(){
    return 'SELECT merchandise.genre_id,merchandise.merchandise_id,merchandise.merchandise_name,merchandise.price,merchandise.image,ranking.quantity
            FROM (select history_genre_id,history_merchandise_id,sum(history_quantity)as quantity 
                  from history_detail 
                  group by history_genre_id,history_merchandise_id) ranking,merchandise
            WHERE ranking.history_genre_id=merchandise.genre_id AND ranking.history_merchandise_id=merchandise.merchandise_id
            ORDER BY ranking.quantity DESC';
}
//選択されたジャンルの商品だけのランキング
function ranking_narrowing(){
    return 'SELECT merchandise.genre_id,merchandise.merchandise_id,merchandise.merchandise_name,merchandise.price,merchandise.image,ranking.quantity
            FROM (select history_genre_id,history_merchandise_id,sum(history_quantity)as quantity 
                  from history_detail 
                  where history_genre_id = ?
                  group by history_genre_id,history_merchandise_id) ranking,merchandise
            WHERE ranking.history_genre_id=merchandise.genre_id AND ranking.history_merchandise_id=merchandise.merchandise_id
            ORDER BY ranking.quantity DESC';
}

//すべての期間の履歴を出力する
function history_all(){
    return 'SELECT * FROM history_purchase WHERE user_number = ?';
}
//絞り込まれた期間の履歴を出力する
function history_period(){
    return 'SELECT * FROM `history_purchase` WHERE `user_number` = ? AND `purchase_day` >= ?';
}
//すべての期間の履歴を出力する　さらに中身を詳しく
function history_all_detail(){
    return 'SELECT * FROM merchandise m,history_detail h WHERE h.history_id in (select history_id from history_purchase where user_number = ?)
                         AND m.genre_id=h.history_genre_id AND m.merchandise_id=h.history_merchandise_id';
}
//絞り込まれた期間の履歴を出力する　さらに中身を詳しく
function history_period_detail(){
    return 'SELECT * FROM merchandise m,history_detail h WHERE h.history_id in (select history_id from history_purchase where `user_number` = ? AND `purchase_day` >= ?)
                         AND m.genre_id=h.history_genre_id AND m.merchandise_id=h.history_merchandise_id';
}

//history_purchaseに追加
function insert_history_purchase(){
    return 'INSERT INTO `history_purchase`
            (`user_number`, `purchase_day`,`all_price`)
            VALUES(?,?,?)';
}

//指定されたuser_numberのmaxのhistory_idを取得する
function max_history_id(){
    return 'SELECT max(`history_id`)as history_id FROM `history_purchase` WHERE `user_number` = ?';
}

//history_detailに追加
function insert_history_detail(){
    return 'INSERT INTO `history_detail`
            (`history_id`, `history_genre_id`, `history_merchandise_id`,`history_price`,`history_quantity`)
            VALUES(?,?,?,?,?)';
}

//stockの更新
function update_stock(){
    return 'UPDATE `merchandise` SET `stock` = `stock` - ? WHERE `genre_id` = ? AND `merchandise_id` = ?';
}

//cartの商品を削除する
function del_cart(){
    return 'DELETE FROM `cart` WHERE `user_number` = ? AND `cart_count` = ?';
}

//cartのcountを更新する
function update_cart_count(){
    return 'UPDATE cart SET cart_count = ? WHERE user_number = ? AND cart_count = ?';
}

//合計金額の更新
function update_price(){
    return 'UPDATE `history_purchase` SET `all_price` = ? WHERE `history_id` = ?';
}


//カートの中身を出力する
function cart(){
    return 'SELECT * FROM merchandise,cart WHERE merchandise.genre_id = cart.cart_genre_id
           AND merchandise.merchandise_id = cart.cart_merchandise_id
           AND cart.user_number = ?';
}

//カートの中身取得
function cart_user_number(){
    return 'SELECT * FROM `cart` WHERE `user_number` = ?';
}
//カートに商品の追加
function add_cart(){
    return 'INSERT INTO `cart`
            (`user_number`, `cart_count`, `cart_genre_id`, `cart_merchandise_id`,`cart_quantity`)
            VALUES(?,?,?,?,?)';
}

//カートの中身削除(1つ指定)
function delete_cart_count(){
    return 'DELETE FROM `cart` WHERE `user_number` = ? AND `cart_count` = ?';
}

//カートの中身削除してからのcart_countの更新
function delete_update_cart(){
    return 'UPDATE `cart` SET `cart_count` = `cart_count` - 1 WHERE `cart_count` > ? AND `user_number` = ?';
}

//会員が購入した商品の詳細情報を取得(退会時使用)
function delete_history_detail(){
    return 'select d.history_detail_id from history_detail d,
                                (select history_id from history_purchase where user_number = ?)as p 
            where d.history_id = p.history_id';
}

//history_detailの情報削除
function del_history_detail(){
    return 'DELETE FROM `history_detail` WHERE `history_detail_id` = ?';
}

//history_purchaseの情報削除
function delete_history_purchase(){
    return 'DELETE FROM `history_purchase` WHERE `user_number` = ?';
}

//cartの情報削除
function delete_cart(){
    return 'DELETE FROM `cart` WHERE `user_number` = ?';
}

//userの情報削除
function delete_user(){
    return 'DELETE FROM `user` WHERE `user_number` = ?';
}
?>
