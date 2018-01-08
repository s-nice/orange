-- ------
-- 将运营后台的开发票订单数据，传递给U8中间表
-- 
-- ！！！  注意事项 ！！！
--  1. 运营后台数据库操作用户必须要能连接到U8中间库，并能对发票表进行写操作；
--  2. 当前设定的U8数据库名字是 u8orderdb。 如果有变动， 请修改SQL中对应的数据库名；
--  3. 本SQL脚本是在连接到运营后台数据库后执行的操作；
-- ------

ALTER TABLE `admin_invoice_extend` 
  ADD `sync_status` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '数据是否已同步到U8' , 
  ADD `sync_date` DATETIME DEFAULT NULL COMMENT '数据同步到U8的时间' AFTER `sync_status`;
  

DROP TRIGGER IF EXISTS trigger_copy_invoice_into_u8;

-- 修改sql语句结束标识符；
delimiter //
-- 

CREATE TRIGGER trigger_copy_invoice_into_u8 AFTER UPDATE ON admin_invoice_info FOR EACH ROW
BEGIN
    IF NEW.invoice_numb <> '' THEN
-- 将数据同步到 U8
        INSERT INTO u8orderdb.lcwy_fp (ccode, ywtype, kpmoney, fpcode, kpname, kpaddress, khbank, khaccount, cstate) 
        SELECT ior.order_id AS cccode, 
               CASE ioq.order_type WHEN 1 THEN '名片购买' 
                                   WHEN 2 THEN '会员充值' 
                                   WHEN 3 THEN '扩容' 
                                   WHEN 5 THEN '企业购买授权' 
                                   WHEN 6 THEN '企业充值' 
                                   WHEN 7 THEN '企业授权续费' 
                                   ELSE ''
               END AS ywtype,
               ior.used_amount AS kpmoney, 
               ii.invoice_numb AS fpcode, 
               CASE ii.invoice_type WHEN 1 THEN ie.company ELSE ie.invoice_head END AS kpname,
               '' AS kpaddress,
               ie.bank_deposit AS khbank,
               ie.bank_account AS khaccount,
               0  AS cstate
               
--               , ii.id, ie.id
        FROM admin_invoice_info ii
        INNER JOIN admin_invoice_extend ie
           ON ii.invoice_id = ie.invoice_id
        INNER JOIN admin_invoice_order_relation ior
           ON ii.invoice_id = ior.invoice_id
        INNER JOIN admin_invoice_order_queue ioq
           ON ior.order_id = ioq.order_id
        WHERE ii.status = 3
          AND ii.invoice_numb <> ''
          AND ie.sync_status <> 1
          AND ii.id = OLD.id;

--  更新同步状态和时间        
        UPDATE admin_invoice_extend 
        SET sync_status = 1, 
            sync_date = FROM_UNIXTIME(UNIX_TIMESTAMP())
        WHERE sync_status <> 1
          AND invoice_id = OLD.invoice_id;
    END IF;
END;

//

delimiter ;