```uml
@startuml
opt 未登録
ユーザー -> Webサーバー : ユーザー登録(情報を入力)
Webサーバー -> DBサーバー : ユーザー登録
DBサーバー -> DBサーバー : 登録処理
DBサーバー -> Webサーバー : 登録結果

alt 登録成功
Webサーバー -> ユーザー : 登録成功
else 登録失敗
Webサーバー -> ユーザー : 登録失敗
end
end

ユーザー -> Webサーバー : ログイン(ID・PASS入力)
Webサーバー -> DBサーバー : ログイン照会
DBサーバー -> DBサーバー : ログイン処理
DBサーバー -> Webサーバー : 認証結果

alt ログイン成功
Webサーバー -> ユーザー : 認証結果(成功)

opt 会員情報編集
ユーザー -> Webサーバー : 変更する情報を入力
Webサーバー -> DBサーバー :変更情報
DBサーバー -> DBサーバー : 変更処理
DBサーバー -> Webサーバー : 編集結果
Webサーバー -> ユーザー : 編集結果
end

opt 会員情報削除
ユーザー -> Webサーバー : 登録削除ボタン
Webサーバー -> DBサーバー : 削除情報
DBサーバー-> DBサーバー : 削除処理
end
ユーザー -> Webサーバー : 検索(商品名)
Webサーバー -> DBサーバー : 検索処理(商品名)
DBサーバー -> DBサーバー : 検索処理
DBサーバー -> Webサーバー : 検索結果
Webサーバー -> ユーザー : 検索結果

opt 商品クリック(詳細表示)
ユーザー -> Webサーバー : 商品クリック
Webサーバー -> DBサーバー : 商品照会
DBサーバー -> Webサーバー : 照会結果
Webサーバー -> ユーザー : 詳細情報表示
Webサーバー -> ユーザー : 拡大された画像表示
opt 戻る機能
ユーザー -> Webサーバー : 戻る処理
end
end

opt お気に入り登録
ユーザー -> Webサーバー : 登録ボタンクリック
Webサーバー -> DBサーバー : お気に入り登録処理
DBサーバー -> DBサーバー : お気に入りのリストに登録する
end

opt ランキング機能
ユーザー -> Webサーバー : ランキングボタンクリック
Webサーバー -> ユーザー : ランキング表示
end

alt 在庫あり
opt カートに商品を追加
ユーザー -> Webサーバー : カートに追加
Webサーバー -> DBサーバー : 商品照会
DBサーバー -> DBサーバー : カートに追加された分の商品数を減らす
end
else 在庫なし
ユーザー -> Webサーバー : カートに追加
Webサーバー -> DBサーバー : 商品照会
DBサーバー -> Webサーバー : 照会結果
Webサーバー -> ユーザー : 在庫結果
DBサーバー -> 発注業者 : 商品の発注
end


else ログイン失敗
end
@enduml
```
