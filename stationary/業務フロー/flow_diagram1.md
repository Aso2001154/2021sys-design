```uml
@startuml
alt ログイン成功

opt ログアウト
ユーザー -> Webサーバー : ログアウトボタン
Webサーバー -> ユーザー: ログアウト結果
end

else ログイン失敗
Webサーバー -> ユーザー : 認証結果(失敗)

end

@enduml
```
