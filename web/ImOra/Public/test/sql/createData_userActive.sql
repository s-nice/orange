-- 修改sql语句结束标识符；
delimiter //
-- 

drop procedure if exists insertActiveData;

create procedure insertActiveData (counterActive int)
begin
  declare date datetime;
  declare sys_platform varchar(64);
  declare prd_version varchar(32);
  declare channel varchar(32);
  declare is_new_user int(11);
  declare count int(11);
  declare batch_time datetime;
  
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
      
      set tmpDateDiff = floor(rand()*1000);
      set `date` = date_sub(NOW(), INTERVAL tmpDateDiff DAY);
      set sys_platform = substr(rand(), 3)%3;
      set prd_version = concat('V',substr(rand(), 3)%5);
      set channel = substr(rand(), 3)%3;
      set is_new_user = substr(rand(), 3, 1)%2;
      set count = floor(rand()*100);
      set `batch_time` = date_sub(NOW(), INTERVAL tmpDateDiff DAY);

      insert into st_active_user_cnt(`date`, 
                            sys_platform, 
                            prd_version, channel, 
                            is_new_user, count,
                            batch_time)
                  values (date,
--                          sys_platform,
                            CASE sys_platform 
                               WHEN 0 THEN 'IOS' 
                               WHEN 1 THEN  'Android' 
                               else 'Leaf' 
                               end,
                            prd_version, 
--                          channel, 
                            CASE channel 
                               WHEN 0 THEN 'Channel-1' 
                               WHEN 1 THEN  'Channel-2' 
                               when 2 then 'Channel-3' 
                               else 'Channel-4' 
                            end, 
                            is_new_user, count,
                            batch_time);

      set tmpIndex = tmpIndex + 1;
-- 继续循环
      if tmpIndex < counterActive then ITERATE InsertDevice; END IF;
-- 跳出循环
      LEAVE InsertDevice;
  end loop InsertDevice; 
  
end;


//
delimiter ;

CALL insertActiveData(100000);


-- 累计流失用户量存储过程
-- 修改sql语句结束标识符；
delimiter //
-- 
drop procedure if exists insertCumLoseData;
create procedure insertCumLoseData (counterActive int)
begin
  declare date datetime;
  declare sys_platform varchar(64);
  declare prd_version varchar(32);
  declare channel varchar(32);
  declare seven int(11);
  declare fourteen int(11);
  declare thirty int(11);
  declare batch_time datetime;
  
  declare tmpIndex int default 1;
  declare tmpDateDiff int default 1; 

-- 插入数据
-- 使用loop循环， 注意跳出操作    
  InsertDevice: loop  
      set tmpDateDiff = floor(rand()*1000);
      set `date` = date_sub(NOW(), INTERVAL tmpDateDiff DAY);
      set sys_platform = substr(rand(), 3)%3;
      set prd_version = concat('V',substr(rand(), 3)%5);
      set channel = substr(rand(), 3)%3;
      set seven = floor(rand()*10);
      set fourteen = floor(rand()*100);
      set thirty = floor(rand()*1000);
      set `batch_time` = date_sub(NOW(), INTERVAL tmpDateDiff DAY);

      insert into st_cumulative_lose(`date`, 
                            sys_platform, 
                            -- prd_version,
							channel, 
                            seven, fourteen,thirty,
                            batch_time)
                  values (date,
                            CASE sys_platform 
                               WHEN 0 THEN 'IOS' 
                               WHEN 1 THEN  'Android' 
                               else 'Leaf' 
                               end,
                            -- prd_version, 
--                          channel, 
                            CASE channel 
                               WHEN 0 THEN 'Channel-1' 
                               WHEN 1 THEN  'Channel-2' 
                               when 2 then 'Channel-3' 
                               else 'Channel-4' 
                            end, 
                            seven, fourteen,thirty,
                            batch_time);

      set tmpIndex = tmpIndex + 1;
-- 继续循环
      if tmpIndex < counterActive then ITERATE InsertDevice; END IF;
-- 跳出循环
      LEAVE InsertDevice;
  end loop InsertDevice; 
  
end;
//
delimiter ;

call insertCumLoseData(100000); #执行存储过程

-- 日流失用户量存储过程
-- 修改sql语句结束标识符；
delimiter //
-- 
drop procedure if exists insertDailyLoseData;
create procedure insertDailyLoseData (counterActive int)
begin
  declare date datetime;
  declare sys_platform varchar(64);
  declare prd_version varchar(32);
  declare channel varchar(32);
  declare seven int(11);
  declare fourteen int(11);
  declare thirty int(11);
  declare batch_time datetime;
  
  declare tmpIndex int default 1;
  declare tmpDateDiff int default 1; 

-- 插入数据
-- 使用loop循环， 注意跳出操作    
  InsertDevice: loop  
      set tmpDateDiff = floor(rand()*1000);
      set `date` = date_sub(NOW(), INTERVAL tmpDateDiff DAY);
      set sys_platform = substr(rand(), 3)%3;
      set prd_version = concat('V',substr(rand(), 3)%5);
      set channel = substr(rand(), 3)%3;
      set seven = floor(rand()*10);
      set fourteen = floor(rand()*100);
      set thirty = floor(rand()*1000);
      set `batch_time` = date_sub(NOW(), INTERVAL tmpDateDiff DAY);

      insert into st_daily_lose(`date`, 
                            sys_platform, 
                            prd_version,
							channel, 
                            seven, fourteen,thirty,
                            batch_time)
                  values (date,
                            CASE sys_platform 
                               WHEN 0 THEN 'IOS' 
                               WHEN 1 THEN  'Android' 
                               else 'Leaf' 
                               end,
                            prd_version, 
--                          channel, 
                            CASE channel 
                               WHEN 0 THEN 'Channel-1' 
                               WHEN 1 THEN  'Channel-2' 
                               when 2 then 'Channel-3' 
                               else 'Channel-4' 
                            end, 
                            seven, fourteen,thirty,
                            batch_time);

      set tmpIndex = tmpIndex + 1;
-- 继续循环
      if tmpIndex < counterActive then ITERATE InsertDevice; END IF;
-- 跳出循环
      LEAVE InsertDevice;
  end loop InsertDevice; 
  
end;
//
delimiter ;

call insertDailyLoseData(100000); #执行存储过程


-- 日流失用户量存储过程
-- 修改sql语句结束标识符；
delimiter //
-- 
drop procedure if exists insertDailyBackData;
create procedure insertDailyBackData (counterActive int)
begin
  declare date datetime;
  declare sys_platform varchar(64);
  declare prd_version varchar(32);
  declare channel varchar(32);
  declare seven int(11);
  declare fourteen int(11);
  declare thirty int(11);
  declare batch_time datetime;
  
  declare tmpIndex int default 1;
  declare tmpDateDiff int default 1; 

-- 插入数据
-- 使用loop循环， 注意跳出操作    
  InsertDevice: loop  
      set tmpDateDiff = floor(rand()*1000);
      set `date` = date_sub(NOW(), INTERVAL tmpDateDiff DAY);
      set sys_platform = substr(rand(), 3)%3;
      set prd_version = concat('V',substr(rand(), 3)%5);
      set channel = substr(rand(), 3)%3;
      set seven = floor(rand()*10);
      set fourteen = floor(rand()*100);
      set thirty = floor(rand()*1000);
      set `batch_time` = date_sub(NOW(), INTERVAL tmpDateDiff DAY);

      insert into st_daily_back(`date`, 
                            sys_platform, 
                            prd_version,
							channel, 
                            seven, fourteen,thirty,
                            batch_time)
                  values (date,
                            CASE sys_platform 
                               WHEN 0 THEN 'IOS' 
                               WHEN 1 THEN  'Android' 
                               else 'Leaf' 
                               end,
                            prd_version, 
--                          channel, 
                            CASE channel 
                               WHEN 0 THEN 'Channel-1' 
                               WHEN 1 THEN  'Channel-2' 
                               when 2 then 'Channel-3' 
                               else 'Channel-4' 
                            end, 
                            seven, fourteen,thirty,
                            batch_time);

      set tmpIndex = tmpIndex + 1;
-- 继续循环
      if tmpIndex < counterActive then ITERATE InsertDevice; END IF;
-- 跳出循环
      LEAVE InsertDevice;
  end loop InsertDevice; 
  
end;
//
delimiter ;

call insertDailyBackData(100000); #执行存储过程


-- 用户留存量存储过程
-- 修改sql语句结束标识符；
delimiter //
drop procedure if exists insertRemainData;
create procedure insertRemainData (counterActive int)
begin
  declare date datetime;
  declare reg_cnt int(11);
  declare sys_platform varchar(64);
  declare channel varchar(32);
  declare one int(11);
  declare two int(11);
  declare three int(11);
  declare four int(11);
  declare five int(11);
  declare six int(11);
  declare seven int(11);
  declare ten int(11);
  declare fourteen int(11);
  declare thirty int(11);
  declare batch_time datetime;
  
  declare tmpIndex int default 1;
  declare tmpDateDiff int default 1; 

-- 插入数据
-- 使用loop循环， 注意跳出操作    
  InsertDevice: loop  
      set tmpDateDiff = floor(rand()*1000);
      set reg_cnt = floor(rand()*1500);
      set `date` = date_sub(NOW(), INTERVAL tmpDateDiff DAY);
      set sys_platform = substr(rand(), 3)%3;
      set channel = substr(rand(), 3)%3;
      set one   = floor(rand()*10);
      set two   = floor(rand()*20);
      set three   = floor(rand()*30);
      set four   = floor(rand()*40);
      set five   = floor(rand()*50);
      set six   = floor(rand()*60);
      set seven = floor(rand()*70);
      set ten   = floor(rand()*100);
      set fourteen = floor(rand()*1400);
      set thirty = floor(rand()*3000);
      set `batch_time` = date_sub(NOW(), INTERVAL tmpDateDiff DAY);

      insert into st_user_remain(`date`, reg_cnt,
                            sys_platform, 
							channel, one,two,three,four,five,six,seven,
                            ten,fourteen,thirty,
                            batch_time)
                  values (date,reg_cnt,
                            CASE sys_platform 
                               WHEN 0 THEN 'IOS' 
                               WHEN 1 THEN  'Android' 
                               else 'Leaf' 
                               end,
                           -- prd_version, 
--                          channel, 
                            CASE channel 
                               WHEN 0 THEN 'Channel-1' 
                               WHEN 1 THEN  'Channel-2' 
                               when 2 then 'Channel-3' 
                               else 'Channel-4' 
                            end, 
                            one,two,three,four,five,six,seven,
                            ten,fourteen,thirty,
                            batch_time);

      set tmpIndex = tmpIndex + 1;
-- 继续循环
      if tmpIndex < counterActive then ITERATE InsertDevice; END IF;
-- 跳出循环
      LEAVE InsertDevice;
  end loop InsertDevice; 
  
end;
//
delimiter ;

call insertRemainData(100000); #执行存储过程


-- 用户每天登陆存储过程
-- 修改sql语句结束标识符；
delimiter //
-- 
drop procedure if exists insertLastLoginData;
create procedure insertLastLoginData (counterActive int)
begin
  declare date datetime;
  declare sys_platform varchar(64);
  declare prd_version varchar(32);
  declare channel varchar(32);
  declare user_id int(11);
  declare device_id int(11);
  declare time datetime;
  declare batch_time datetime;
  
  declare tmpIndex int default 1;
  declare tmpDateDiff int default 1; 

-- 插入数据
-- 使用loop循环， 注意跳出操作    
  InsertDevice: loop  
      set tmpDateDiff = floor(rand()*1000);
      set `time` = date_sub(NOW(), INTERVAL tmpDateDiff DAY);
      set sys_platform = substr(rand(), 3)%3;
      set prd_version = concat('V',substr(rand(), 3)%5);
      set channel = substr(rand(), 3)%3;
      set user_id = floor(rand()*20000) + 100000;
      set device_id = floor(rand()*100);
      set `batch_time` = date_sub(NOW(), INTERVAL tmpDateDiff DAY);

      insert into user_daily_last_login(`time`, 
                            sys_platform, 
                            prd_version,
							channel, 
                            user_id, device_id,
                            batch_time)
                  values (time,
                            CASE sys_platform 
                               WHEN 0 THEN 'IOS' 
                               WHEN 1 THEN  'Android' 
                               else 'Leaf' 
                               end,
                            prd_version, 
--                          channel, 
                            CASE channel 
                               WHEN 0 THEN 'Channel-1' 
                               WHEN 1 THEN  'Channel-2' 
                               when 2 then 'Channel-3' 
                               else 'Channel-4' 
                            end, 
                            user_id, device_id,
                            batch_time);

      set tmpIndex = tmpIndex + 1;
-- 继续循环
      if tmpIndex < counterActive then ITERATE InsertDevice; END IF;
-- 跳出循环
      LEAVE InsertDevice;
  end loop InsertDevice; 
  
end;
//
delimiter ;

call insertLastLoginData(100000); #执行存储过程


-- 用户日周活跃占比存储过程
-- 修改sql语句结束标识符；
delimiter //
-- 
drop procedure if exists insertDayWeekRateData;
create procedure insertDayWeekRateData (counterActive int)
begin
  declare date datetime;
  declare sys_platform varchar(64);
  declare channel varchar(32);
  declare day_active_cnt int(11);
  declare week_active_cnt int(11);
  declare p7_active_cnt int(11);
  declare p30_active_cnt int(11);
  declare batch_time datetime;
  
  declare tmpIndex int default 1;
  declare tmpDateDiff int default 1; 

-- 插入数据
-- 使用loop循环， 注意跳出操作    
  InsertDevice: loop  
      set tmpDateDiff = floor(rand()*1000);
      set `date` = date_sub(NOW(), INTERVAL tmpDateDiff DAY);
      set sys_platform = substr(rand(), 3)%3;
      set channel = substr(rand(), 3)%3;
      set day_active_cnt = floor(rand()*10);
      set week_active_cnt = floor(rand()*100);
      set p7_active_cnt = floor(rand()*500);
      set p30_active_cnt = floor(rand()*1000);
      set `batch_time` = date_sub(NOW(), INTERVAL tmpDateDiff DAY);

      insert into st_day_week_active_ratio(`date`, 
                            sys_platform, 
							channel, 
                            day_active_cnt, week_active_cnt,p7_active_cnt,p30_active_cnt,
                            batch_time)
                  values (date,
                            CASE sys_platform 
                               WHEN 0 THEN 'IOS' 
                               WHEN 1 THEN  'Android' 
                               else 'Leaf' 
                               end,
--                          channel, 
                            CASE channel 
                               WHEN 0 THEN 'Channel-1' 
                               WHEN 1 THEN  'Channel-2' 
                               when 2 then 'Channel-3' 
                               else 'Channel-4' 
                            end, 
                            day_active_cnt, week_active_cnt,p7_active_cnt,p30_active_cnt,
                            batch_time);

      set tmpIndex = tmpIndex + 1;
-- 继续循环
      if tmpIndex < counterActive then ITERATE InsertDevice; END IF;
-- 跳出循环
      LEAVE InsertDevice;
  end loop InsertDevice; 
  
end;
//
delimiter ;

call insertDayWeekRateData(100000); #执行存储过程

-----------------------------------------------------------------------------------------------------
-- 橙子搜索统计的存储过程start
delimiter //
-- 
drop procedure if exists insertDmOrangeStatsSearchData;
create procedure insertDmOrangeStatsSearchData (counterActive int)
begin
  declare pro_version varchar(64);
  declare model varchar(32);
  declare search_type int(11);
  declare pv_num int(11);
  declare pv_user int(11);
  declare search_num int(11);
  declare search_user int(11);
  declare rs_search_num int(11);
  declare rs_search_user int(11);
  declare rclick_num int(11);
  declare rclick_user int(11);
  declare dt date;
  declare create_time datetime;
  
  declare tmpIndex int default 1;
  declare tmpDateDiff int default 1; 

-- 插入数据
-- 使用loop循环， 注意跳出操作    
  InsertDevice: loop  
      set tmpDateDiff = floor(rand()*1000);
      set dt = date_sub(NOW(), INTERVAL tmpDateDiff DAY);
      set pro_version = substr(rand(), 3)%3;
      set model = substr(rand(), 3)%3;
      set search_type = substr(rand(),3)%3;
      set pv_num = floor(rand()*10);
      set pv_user = floor(rand()*100);
      set search_num = floor(rand()*500);
      set search_user = floor(rand()*1000);
      set rs_search_num = floor(rand()*700);
      set rs_search_user = floor(rand()*800);
      set rclick_num = floor(rand()*1000);
      set rclick_user = floor(rand()*1000);
      set create_time = date_sub(NOW(), INTERVAL tmpDateDiff DAY);

      insert into dm_orange_stats_search(pro_version, 
                            model, search_type, pv_num, pv_user,
                            search_num, search_user, rs_search_num, rs_search_user,
                             rclick_num, rclick_user, dt, create_time)                            
                  values (CASE pro_version 
                               WHEN 0 THEN 's1.1' 
                               WHEN 1 THEN  's1.2' 
                               else 's1.3' 
                               end,
                            CASE model 
                               WHEN 0 THEN 'h1.1' 
                               WHEN 1 THEN  'h1.2' 
                               else 'h1.3' 
                            end, 
                           CASE search_type 
                               WHEN 0 THEN 1 
                               WHEN 1 THEN 1 
                               else 2 
                            end, 
                            pv_num, pv_user, search_num, search_user, rs_search_num,rs_search_user,rclick_num, rclick_user,
                            dt,create_time);

      set tmpIndex = tmpIndex + 1;
-- 继续循环
      if tmpIndex < counterActive then ITERATE InsertDevice; END IF;
-- 跳出循环
      LEAVE InsertDevice;
  end loop InsertDevice; 
  
end;
//
delimiter ;

call insertDmOrangeStatsSearchData(100000); #执行存储过程
-- 橙子搜索统计的存储过程end