```startuml
@startuml

!define MASTER_MARK_COLOR Lime 
!define TRANSACTION_MARK_COLOR HotPink
skinparam class {
    BackgroundColor Snow
    BorderColor Black
    ArrowColor Black
}
package "ECサイト" as target_system {
        /'
      マスターテーブルを M、トランザクションを T などで表記
      １文字なら "主" とか "従" まど日本語でも記載可能
     '/

    entity "顧客マスタ" as customer <m_customers> <<M,MASTER_MARK_COLOR>> {
        + customer_code [PK]
        --
        pass
        name
        address
        tel
        mail
        del_flag
        reg_date
    }
    entity "購入テーブル" as order <d_purchase> <<T,TRANSACTION_MARK_COLOR>> {
        + order_id [PK]
        --
        customer_code
        purchase_date
        total_price
    }
    entity "購入詳細テーブル" as order_detail <d_purchase_detail> <<T,TRANSACTION_MARK_COLOR>> {
        + ordet_id [PK]
        + detail_id [PK]
        --
        item_code [FK]
        price
        num
    }
    entity "商品マスタ" as items <m_items> <<M,MASTER_MARK_COLOR>> {
        + item_code [PK]
        --
        item_name
        price
        category_id [FK]
        image
        detail
        del_flag
        reg_date
    }
    entity "カテゴリマスタ" as category <m_category> <<M,MASTER_MARK_COLOR>> {
        + category_id [PK]
        --
        name
        reg_date
    }
    customer       |o-ri-o{     order 
    order          ||-ri-|{     order_detail 
    order_detail    }-do-||     items 
    items          }o-le-||     category 
@enduml
```

