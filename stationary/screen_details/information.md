### 画面詳細図
## 会員情報
### プロトタイプは以下のリンク先
[プロトタイプ](https://www.figma.com/file/YN8g4ahM3raStzCZMDXhNA/stationary?node-id=1%3A2)
*****
<img src="../img/会員情報.png" width="500">

*****
補足：対応DBの列はDB設計後、○を対応するテーブル・カラム名に差し替えること。

| ID | 要素 | 内容 | アクション | イベント | 対応DB |
|----|------|-----|------------|---------|-------|
|1   |バナー　　　　　        |テキスト画像ボタン|クリック   |シャーペン(ジャンル)へ遷移|-|
|2   |information　　       |テキスト　　　　　|-    　　　|-        　　　   |-|
|3   |id　　　　　　　       |テキスト　　　　　|-    　　　|-        　　　   |-|
|4   |idテキスト　　　       |入力欄　文字種:アルファベット、数字<br>typeをtextにする<br>※ハイフン、アスタリスク、アットマーク、スラッシュ、(、)、<、>、＄、＃、＆、！、％、ひらがな、カタカナ、漢字はなし、アルファベットと数字の組み合わせ(8文字固定)|テキスト入力|-        　　　   |○|
|5   |pass　　　　　　       |テキスト　　　　　|-    　　　|-        　　　   |-|
|6   |passテキスト　　       |入力欄　文字種:数字<br>typeをpasswordにする<br>※ハイフン、アスタリスク、アットマーク、スラッシュ、(、)、<、>、＄、＃、＆、！、％、アルファベット、ひらがな、カタカナ、漢字はなし (4文字固定)|テキスト入力|-        　　    |○|
|7   |name     　　　       |テキスト　　　　　|-    　　　|-        　　　   |-|
|8   |nameテキスト　　       |入力欄　文字種:全角/半角<br>※typeをtextにする|テキスト入力|-        　　　  |○|
|9   |address　　　　        |テキスト　　　　　|-    　　　|-        　　　   |-|
|10  |addressテキスト       |入力欄　文字種:全角/半角<br>※typeをtextにする|テキスト入力|-        　　　   |○|
|11  |credit number　      |テキスト　　　　　|-    　　　|-        　　　   |-|
|12  |credit numberテキスト|入力欄　文字種:数字<br>typeをnumberにする<br>※ハイフンはなし (16文字固定)|テキスト入力|-        　　　   |○|
|13  |確認ボタン　　　      |ボタン　※制限に反した入力があれば更新完了へ遷移しない|クリック　　|会員情報確認へ遷移　　|○|
|14  |トップボタン　　　     |ボタン　　　　　　|クリック　　|シャーペン(ジャンル)へ遷移　　|-|
|15  |制限文(id)　　　     　|テキスト　　　　　|-　　|-　　|-|
|16  |制限文(pass)　　　     |テキスト　　　　　|-　　|-　　|-|
|17  |制限文(credit number) |テキスト　　　　　|-　　|-　　|-|

