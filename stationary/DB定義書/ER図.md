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

    entity "ユーザーマスタ" as user <m_user> <<M,MASTER_MARK_COLOR>> {
        + user_number [PK]
        --
        * user_id
        user_pass
        user_name
        credit_number
        user_address
    }
    
    entity "カートテーブル" as cart <t_cart> <<T,TRANSACTION_MARK_COLOR>> {
        + cart_user_number[PK][FK]
        + cart_count[PK]
        --
        # cart_genre_id [FK]
        # cart_merchandise_id [FK]
        cart_quantity
    }
    
    entity "購入履歴テーブル" as history_purchase  <t_history_purchase> <<T,TRANSACTION_MARK_COLOR>> {
        + history_id[PK]
        --
        # history_user_number [FK]
        purchase_day
        all_price
    }
        
    entity "購入詳細履歴テーブル" as history_detail  <t_history_detail> <<T,TRANSACTION_MARK_COLOR>> {
        + history_detail_id[PK]
        + history_id[PK][FK]
        --
        # history_genre_id [FK]
        # history_merchandise_id [FK]
        history_price
        history_quantity
    }
        
    entity "商品ジャンルマスタ" as genre <m_genre> <<M,MASTER_MARK_COLOR>> {
        + genre_id [PK]
        --
        genre_name
    }
    
    entity "商品マスタ" as merchandise <m_merchandise> <<M,MASTER_MARK_COLOR>> {
        + genre_id [PK][FK]
        + merchandise_id [PK]
        --
        merchandise_name
        price
        image
        merchandise_detail
        stock
    }
    
    
  }
  
user              |o-do-o{     cart
user              |o-ri-o{     history_purchase
history_purchase  ||-ri-|{     history_detail
history_detail    }o-do-o|     merchandise
cart              }o-ri-o|    merchandise
merchandise       }|-do-||     genre

@enduml
```
