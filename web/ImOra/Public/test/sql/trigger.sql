-- 修改sql语句结束标识符
delimiter //
-- 删除同名的触发器
drop trigger if exists updatename//
-- 创建触发器
create trigger updatename after update on db1.basic_user for each row 
begin 
	-- old,new都是代表当前操作的记录行，你把它当成表名，也行
	-- 当表中用户名发生变化时，执行 
	if new.name!=old.name then  
		update db2.comment_info set comment_info.name=new.name where comment_info.u_id=old.id;
		update db2.basic_user set basic_user.name=new.name where basic_user.id=old.id;
	end if; 
end // 
delimiter ;

delimiter // 
drop trigger if exists deletecomment// 
create trigger deletecomment before delete on db1.basic_user for each row 
begin 
	delete from db2.comment_info where comment_info.u_id=old.id; 
end // 
delimiter ;

delimiter // 
drop trigger if exists insertuser// 
create trigger insertuser after insert on db1.basic_user for each row 
begin 
	insert into db2.basic_user (`id`, `name`, `sex`) VALUES (new.id, new.name, new.sex);
end // 
delimiter ;

-- 删除同名的触发器
delimiter //
drop trigger if exists updatename//
drop trigger if exists deletecomment// 
drop trigger if exists insertuser//
delimiter ;