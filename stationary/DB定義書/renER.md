```uml
@startuml

skinparam class {
    '図の背景
    BackgroundColor Snow
    '図の枠
    BorderColor Black
    'リレーションの色
    ArrowColor Black
}

!define MASTER_MARK_COLOR Orange 
!define TRANSACTION_MARK_COLOR DeepSkyBlue

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
    
    entity "購入テーブル" as order <order> <<T,TRANSACTION_MARK_COLOR>> {
        + order_id [PK]
        --
        # customer_code [FK]
        purchase_date
        total_price
    }
    
    entity "購入詳細テーブル" as order_detail  <order_detail> <<T,TRANSACTION_MARK_COLOR>> {
        + detail_id[PK]
        + order_id[PK]
        --
        # item_code [FK]
        price
        num
    }
    
    entity "商品マスタ" as items <m_items> <<M,MASTER_MARK_COLOR>> {
        + item_code [PK]
        --
        item_name
        price
        # category_id [FK]
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
  }
  
  customer       |o-ri-o{     order
order          ||-ri-|{     order_detail
order_detail    }-do-||     items
items          }o-le-||     category


@enduml
```
