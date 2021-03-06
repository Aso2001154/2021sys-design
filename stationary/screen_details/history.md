### 画面詳細図
## 購入履歴
### プロトタイプは以下のリンク先
[プロトタイプ](https://www.figma.com/file/YN8g4ahM3raStzCZMDXhNA/stationary?node-id=1%3A2)
*****
<img src="../img/履歴.png" width="500">

*****
補足：対応DBの列はDB設計後、○を対応するテーブル・カラム名に差し替えること。

| ID | 要素 | 内容 | アクション | イベント | 対応DB |
|----|------|-----|------------|---------|-------|
|1   |バナー　　　　　　       |テキスト画像ボタン|クリック|シャーペン(ジャンル)へ遷移|-|
|2   |シャーペンテキストボタン　|ボタン　　　　　　|クリック|シャーペン(ジャンル)へ遷移|-|
|3   |消しゴムテキストボタン   |ボタン　　　　　　|クリック|消しゴム(ジャンル)へ遷移|-|
|4   |ボールペンテキストボタン |ボタン　　　　　　|クリック|ボールペン(ジャンル)へ遷移|-|
|5   |定規テキストボタン       |ボタン　　　　　　|クリック|定規(ジャンル)へ遷移　　|-|
|6   |事務用品テキストボタン   |ボタン　　　　　　|クリック|事務用品(ジャンル)へ遷移|-|
|7   |購入履歴　　　　　　　       |テキスト　　　　　|-    　|-        　　　　　　　　|-|
|8   |期間欄テキスト　　       |テキスト<br>※セレクトボックスで表示|-|-            |-|
|9   |絞込みボタン       　　　|ボタン　　　　　　|クリック|絞り込まれた履歴ページへ遷移|○|
|10  |期間テキスト　　       |テキスト<br>※始めはすべての期間が表示<br>期間が絞られたら絞られた期間が表示(1週間前、1カ月前)|-|-|-|
|11  |商品画像　　　　　       |画像<br>※1列に並べられて、1画面に表示する|-    　|-        　　　　　　　　|○|
|12  |商品名　　　　　　       |テキスト　　　　　|-    　|-        　　　　　　　　|-|
|13  |商品名テキスト　　       |テキスト　　　　　|-    　|-      　　　　　　　　　|○|
|14  |価格　　　　　　　       |テキスト　　　　　|-    　|-      　　　　　　　　　|-|
|15  |価格テキスト　　　       |テキスト<br>※¥マークと3桁のカンマを表示|-    　|-      　　　　　　　　　|○|
|16  |合計価格　　　　　       |テキスト　　　　　|-    　|-      　　　　　　　　　|-|
|17  |合計価格テキスト　       |テキスト<br>※3桁のカンマを表示|-    　|-      　　　　　　　　　|-|
|18  |個数　　　　　　　       |テキスト　　　　　|-    　|-      　　　　　　　　　|-|
|19  |個数テキスト　　　       |テキスト<br>※3桁のカンマを表示|-    　|-      　　　　　　　　　|○|
|20  |購入日　　　　　　       |テキスト　　　　　|-    　|-      　　　　　　　　　|-|
|21  |購入日テキスト　　       |テキスト<br>※年月日を表示|-    　|-      　　　　　　　　　|○|
|22  |トップページボタン       |ボタン　　　　　　|クリック|シャーペン(ジャンル)へ遷移|-|
|23  |矢印ボタン　　　　　　　　|ボタン　※4品目から表示|クリック　　|ページ上部へ自動スクロール　　　　|-|
