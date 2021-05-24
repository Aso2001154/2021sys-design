```uml
@startuml
alt ログイン成功
opt 購入機能
ユーザー -> Webサーバー : 商品の購入
Webサーバー -> DBサーバー : 購入処理
DBサーバー -> DBサーバー : 購入処理
DBサーバー -> Webサーバー : 購入結果
Webサーバー -> ユーザー : 購入結果
end
ユーザー -> Webサーバー : 評価を入力
Webサーバー -> DBサーバー : 評価情報
DBサーバー -> DBサーバー : 評価情報保存
ユーザー -> Webサーバー : ログアウトボタンクリック
Webサーバー -> DBサーバー : ログアウト照会
DBサーバー -> DBサーバー : ログアウト処理
else ログイン失敗
Webサーバー -> ユーザー : 認証結果(失敗)
end
opt 商品情報登録
発注業者 -> DBサーバー : 商品情報を入力して登録
DBサーバー -> DBサーバー : 登録処理
DBサーバー -> 発注業者 : 登録結果
end
DBサーバー -> DBサーバー : 売上検索処理
@enduml
```