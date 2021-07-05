entity "顧客マスタ" as customer <m_customers>
<<M,MASTER_MARK_COLOR>>{
  + customer_code[PK]
  --
  pass
  name
  address
  tel
  mail
  del_flag
  reg_date
 }
