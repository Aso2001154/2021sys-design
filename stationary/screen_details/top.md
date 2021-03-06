### 画面詳細図
## トップページ(シャーペン[ジャンル])
### プロトタイプは以下のリンク先
[プロトタイプ](https://www.figma.com/file/YN8g4ahM3raStzCZMDXhNA/stationary?node-id=1%3A2)
*****
<img src="../img/シャーペン.png" width="500">

*****
補足：対応DBの列はDB設計後、○を対応するテーブル・カラム名に差し替えること。

| ID | 要素 | 内容 | アクション | イベント | 対応DB |
|----|------------------------|---------------|------------|-----------------------|-|
|1   |バナー　　　　　　　　　　|テキスト画像ボタン|クリック　　|シャーペン(ジャンル)へ遷移|-|
|2   |ログイン/ログアウトボタン|ボタン |クリック　|ログイン/ログアウトへ遷移             |○|
|3   |カートボタン　　　　　　　|ボタン　　　　　　|クリック　　|カートへ遷移　　　　　　　|○|
|4   |会員情報ボタン　　　　　　|ボタン　　　　　　|クリック　　|会員情報へ遷移　　　　　　|○|
|5   |購入履歴ボタン　　　　　　　　|ボタン　　　　　　|クリック　　|購入履歴へ遷移　　　　　　　　|○|
|6   |シャーペンテキストボタン　|ボタン　　　　　　|クリック|シャーペン(ジャンル)へ遷移|-|
|7   |消しゴムテキストボタン   |ボタン　　　　　　|クリック|消しゴム(ジャンル)へ遷移|-|
|8   |ボールペンテキストボタン |ボタン　　　　　　|クリック|ボールペン(ジャンル)へ遷移|-|
|9   |定規テキストボタン       |ボタン　　　　　　|クリック|定規(ジャンル)へ遷移|-|
|10  |事務用品テキストボタン   |ボタン　　　　　　|クリック|事務用品(ジャンル)へ遷移|-|
|11  |ランキングボタン　　　　　|ボタン　　　　　　|クリック　　|ランキングページへ遷移　　|○|
|12  |商品名検索欄　　　　　　　|入力欄<br>文字種:かな文字/アルファベット/数字<br>カンマを挟んで複数検索|テキスト入力|-|○|
|13  |検索ボタン　　　　　　　　|ボタン　　　　　　|クリック　  |検索結果へ遷移　　　　　　|○|
|14  |ジャンル名　　　　　　　　|テキスト画像　　|-      　　|-            　　　　　　|○|
|15  |商品画像　　　　　　　　　|商品画像ボタン|クリック　　|商品詳細へ遷移　　　　　　|○|
|16  |商品名/価格　　　　　　　 |テキストボタン<br>※値段は￥マークと3桁のカンマをつける<br>※windthが800以下の場合一列で表示する|クリック　　|商品詳細へ遷移|○|
|17  |矢印ボタン　　　　　　　　|ボタン　※4品目から表示|クリック　　|ページ上部へ自動スクロール　　　　|-|
|18  |商品名検索テキスト　　　　|テキスト　|-      　　|薄い文字で表示させ、何を検索させるのかを分かるようにする|-|
|19  |ユーザ名テキスト　　　　 |テキスト　|-      　　|-|-|
|20  |ユーザ名　　　　        |テキスト　|-      　　|データベースに保存された情報を表示する|○|
