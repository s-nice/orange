-- 修改sql语句结束标识符；
delimiter //
-- 

drop procedure if exists insertDeviceData;

create procedure insertDeviceData (counterDevice int)
begin
  declare device_id varchar(62);
  declare activate_time datetime;
  declare brand varchar(64);
  declare model varchar(64);
  declare sys_platform varchar(64);
  declare sys_version varchar(64);
  declare prd_version varchar(32);
  declare channel varchar(32);
  declare history int(11);
  declare is_new int(11);
  declare activate_day int(11);
  declare activate_week int(11);
  declare activate_month int(11);
  
  declare tmpIndex int default 1;
  declare tmpDateDiff int default 1;
 
-- 序列号  device_id 设备ID  activate_time 设备激活时间    brand 设备品牌  model 设备型号  sys_platform 系统平台   sys_version 系统版本    
-- prd_version 设备激活时APP版本  channel 设备激活时APP渠道  history 用户信息变更历史，默认0，无变更    is_new 用户信息是否最新标识，默认False  
-- batch_time 批处理时间    activate_day    activate_week   activate_month

-- 插入数据
-- 使用loop循环， 注意跳出操作  
  
  InsertDevice: loop
          
--      set device_id varchar(62);
--      set activate_time datetime;
--      set brand varchar(64);
--      set model varchar(64);
--      set sys_platform varchar(64);
--      set sys_version varchar(64);
--      set prd_version varchar(32);
--      set channel varchar(32);
--      set history int(11);
--      set is_new int(11);
--      set activate_day int(11);
--      set activate_week int(11);
--      set activate_month int(11);
      
      set device_id = concat(substr(rand(), 3),substr(rand(), 3),substr(rand(), 3),substr(rand(), 3),substr(rand(), 3),substr(rand(), 3));
      set tmpDateDiff = floor(rand()*100);
      set activate_time = date_sub(NOW(), INTERVAL tmpDateDiff DAY);
      set brand = concat('brand-', substr(rand(), 3));
      set model = concat('mail-',substr(rand(), 3), '@oradt.com');
      set sys_platform = substr(rand(), 3)%3;
      set sys_version = concat('V',substr(rand(), 3, 5));
      set prd_version = concat('V',substr(rand(), 3, 5));
      set channel = substr(rand(), 3)%3;
      set history = substr(rand(), 3);
      set is_new = substr(rand(), 3, 1)%2;
      set activate_day = DATE_FORMAT(activate_time,'%j') ;
      set activate_week = DATE_FORMAT(activate_time,'%u') ;
      set activate_month = DATE_FORMAT(activate_time,'%v') ;

      insert into device_info(device_id, activate_time, brand, 
                            model, sys_platform, sys_version, 
                            prd_version, channel, history, 
                            is_new, activate_day, activate_week,
                            activate_month)
                  values (device_id, activate_time, brand, 
                            model, 
--                          sys_platform,
                            CASE sys_platform 
                               WHEN 0 THEN 'IOS' 
                               WHEN 1 THEN  'Android' 
                               else 'Leaf' 
                               end,
                            sys_version, 
                            prd_version, 
--                          channel, 
                            CASE channel 
                               WHEN 0 THEN 'Channel-1' 
                               WHEN 1 THEN  'Channel-2' 
                               when 2 then 'Channel-3' 
                               else 'Channel-4' 
                            end, 
                            history, 
                            is_new, activate_day, activate_week,
                            activate_month);

      set tmpIndex = tmpIndex + 1;
-- 继续循环
      if tmpIndex < counterDevice then ITERATE InsertDevice; END IF;
-- 跳出循环
      LEAVE InsertDevice;
  end loop InsertDevice; 
  
end;


//
delimiter ;