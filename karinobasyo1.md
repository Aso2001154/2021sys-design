## flow_diagramの続き
```
@startuml
alt ログイン成功
alt 在庫なし
ユーザー -> Webサーバー : カートに追加
Webサーバー -> DBサーバー : 商品照会
DBサーバー -> Webサーバー : 照会結果
Webサーバー -> ユーザー : 在庫結果

end

opt ログアウト
ユーザー -> Webサーバー : ログアウトボタン
Webサーバー -> ユーザー: ログアウト結果
end

else ログイン失敗
Webサーバー -> ユーザー : 認証結果(失敗)
end

@enduml
```
