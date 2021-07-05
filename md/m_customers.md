```startuml
@startuml

package "ECサイト" as target_system {

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
    entity "購入テーブル" as customer <d_purchase> <<T,MASTER_MARK_COLOR>> {
        + order_id [PK]
        --
        customer_code
        purchase_date
        total_price
    }
    entity "購入詳細テーブル" as customer <d_purchase_detail> <<T,MASTER_MARK_COLOR>> {
        + ordet_id [PK]
        + detail_id [PK]
        --
        item_code [FK]
        price
        num
    }
    entity "商品マスタ" as customer <m_items> <<M,MASTER_MARK_COLOR>> {
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
    entity "カテゴリマスタ" as customer <m_category> <<M,MASTER_MARK_COLOR>> {
        + category_id [PK]
        --
        name
        reg_date
    }
@enduml
```

