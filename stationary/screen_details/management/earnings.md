### 画面詳細図
## 売上情報
### プロトタイプは以下のリンク先
[プロトタイプ](https://www.figma.com/file/YN8g4ahM3raStzCZMDXhNA/stationary?node-id=1%3A2)
*****
<img src="img/売上金額.png" width="500">

*****
補足：対応DBの列はDB設計後、○を対応するテーブル・カラム名に差し替えること。

| ID | 要素 | 内容 | アクション | イベント | 対応DB |
|----|------|-----|------------|---------|-------|
|1   |バナー　　　　　　       |テキスト画像ボタン|クリック|管理画面topへ遷移|-|
|2   |履歴　　　　　　　       |テキスト　　　　　|-    　|-        　　　　　　　　|-|
|3   |商品画像　　　　　       |画像<br>※1列に並べられて、1画面に表示する|-    　|-|○|
|4   |商品名　　　　　　       |テキスト　　　　　|-    　|-        　　　　　　　　|-|
|5   |商品名テキスト　　       |テキスト　　　　　|-    　|-      　　　　　　　　　|○|
|6   |価格　　　　　　　       |テキスト　　　　　|-    　|-      　　　　　　　　　|-|
|7   |価格テキスト　　　       |テキスト<br>※¥マークと3桁のカンマを表示|-    　|-  |○|
|8   |合計金額　　　　　       |テキスト　　　　　|-    　|-      　　　　　　　　　|-|
|9   |合計金額テキスト　       |テキスト<br>※¥マークと3桁のカンマを表示|-    　|-　|-|
|10  |トップページボタン       |ボタン　　　　　　|クリック|管理画面topへ遷移|-|
