delimiter //
-- 删除同名的触发器
drop trigger if exists `trigger_copy_invoice_into_u8` //
-- 创建触发器
CREATE TRIGGER `trigger_copy_invoice_into_u8` AFTER UPDATE ON `admin_invoice_info` FOR EACH ROW BEGIN
    IF NEW.invoice_numb <> '' THEN
        INSERT INTO u8orderdb.lcwy_fp_bak (ccode, ywtype, kpmoney, fpcode, kpname, kpaddress, cstate) 
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
               0  AS　cstate
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

        UPDATE admin_invoice_extend 
        SET sync_status = 1, 
            sync_date = FROM_UNIXTIME(UNIX_TIMESTAMP())
        WHERE sync_status <> 1
          AND invoice_id = OLD.invoice_id;
    END IF;
END //
delimiter ;