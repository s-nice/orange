$(function(){
	/**
	 * 修改信息
	 */
	$('#js_submit').off('click').on('click',function(){
		var username = $.trim($('input[name="username"]').val());
		var email = $('input[name="email"]').val();
		var mobile = $('input[name="mobile"]').val();
		/*if(username==''){
			$('#tx_username').html('真实姓名不可为空');
			return ;
		}else if(email==''){
			$('#tx_email').html('电子邮箱不可为空');
			$('#tx_username').html('');
			return ;
		}else{
			$('#tx_email').html('');
		if(email!=''){
			var regexp = /^([\w\.\-_]+)\@([\w\-]+\.)([\w]{2,4})$/; 
			if(!regexp.test(email)){
				$.global_msg.init({gType:'warning',msg:email_format_error,icon:0});
				return false;
			}
		}*/
			$.ajax({
				url:'/Appadmin/Index/modifyInfo',
				type:'post',
				data:{realname:username/*,email:email,mobile:mobile*/},
				success:function(res1){
					if(res1['status']=='0'){
						//alert(res1['message']);
						$.global_msg.init({gType:'warning',msg:res1['message'],time:2,icon:1,endFn: function () {
							location.href = '/Appadmin/Index/showModifyPage';
						}});//,btns:true
						//location.href = '/Appadmin/index/index';
					}else{
						$.global_msg.init({gType:'warning',msg:res1['message'],icon:0});
					}
				},
				fail:function(err){
					$.global_msg.init({gType:'warning',msg:modify_fail,icon:0});
				}
			});
		//}
	});
	//老密码不为空并且正确
	$('#oldpasswd').on('blur',function(){
		var passwd_is_true = false;
		var oldpasswd = $('input[name="oldpasswd"]').val();
		if(oldpasswd==''){
			$('#tx_oldpasswd').html(old_passwd_not_empty);
			return ;
		}else{
			//var passwdreg = /^\w{6,16}$/;
			if(oldpasswd!='' ||oldpasswd!=null){
				$('#tx_oldpasswd').html('');
				/*if(!passwdreg.test(oldpasswd)){
					$('#tx_oldpasswd').html('旧密码长度为6至16位');
					return ;
				}*/
				$.ajax({
					url:'/Appadmin/Index/getOldPasswd',
					type:'post',
					data:{password:oldpasswd},
					async:false,
					success:function(res){
						if(!res['status']){
							passwd_is_true = true;
						}
					}
				});
				if(!passwd_is_true){
					$('#tx_oldpasswd').html(old_passwd_not_correct);
					//$('#tx_newpasswd').html('');
					//$('#tx_renewpasswd').html('');
					return ;
				}else{
					$('#tx_oldpasswd').html("<img src='"+public+"/images/appadmin_icon_yanzheng.png' />");
					return ;
				}				
			}
		}
		
	});
	
	//判断新密码
	$('#newpasswd').on('blur',function(){
		var newpasswd = $('input[name="newpasswd"]').val();
		var passwdreg = /^[\w|!|@|#|$|%|^|&|*|\(|\)|,|.|?|<|>|/|_\+]{6,16}$/;
		if(newpasswd==''){
			$('#tx_newpasswd').html(new_passwd_not_empty);
			return ;
		}else if(!passwdreg.test(newpasswd)){
			$('#tx_newpasswd').html(str_pwd_len);//新密码长度为6至16位
			return ;
		}else if($.trim(newpasswd) == $.trim($('input[name="oldpasswd"]').val())){
			$('#tx_newpasswd').html(str_old_new_pwd_not_same);//新密码与老密码不能相同
		}else{
			$('#tx_newpasswd').html("<img src='"+public+"/images/appadmin_icon_yanzheng.png' />");
		}
		
	});
	//新密码和重复密码一致
	$('#renewpasswd').on('blur',function(){
		var renewpasswd = $('input[name="renewpasswd"]').val();
		var newpasswd = $('input[name="newpasswd"]').val();
		if(renewpasswd==''){
			//$('#tx_newpasswd').html('');
			$('#tx_renewpasswd').html(confirm_new_passwd_not_empty);
			return ;
		}else if(newpasswd!=renewpasswd){
			$('#tx_renewpasswd').html(passwd_not_agreed);

			return ;
		}else{
			$('#tx_renewpasswd').html("<img src='"+public+"/images/appadmin_icon_yanzheng.png' />");
		}		
	});
	
	//修改密码
	$('#js_submit_passwd').on('click',function(){
		var oldpasswd = $('input[name="oldpasswd"]').val();
		var newpasswd = $('input[name="newpasswd"]').val();
		var renewpasswd = $('input[name="renewpasswd"]').val();

		if(oldpasswd==''){
			$('#tx_oldpasswd').html(old_passwd_not_empty);
			return ;
		}else{ 
			var passwdreg = /^[\w|!|@|#|$|%|^|&|*|\(|\)|,|.|?|<|>|/|_\+]{6,16}$/;
			if(oldpasswd!='' ||oldpasswd!=null){
				//$('#tx_oldpasswd').html('');
				if(!passwdreg.test(oldpasswd)){
					$('#tx_oldpasswd').html(str_old_pwd_len); //旧密码长度为6至16位
					return ;
				}
				var passwd_is_true = false;
				$.ajax({
					url:'/Appadmin/Index/getOldPasswd',
					type:'post',
					data:{password:oldpasswd},
					async:false,
					success:function(res){
						if(!res['status']){
							passwd_is_true = true;
						}
					}
				});
				if(!passwd_is_true){
					$('#tx_oldpasswd').html(old_passwd_not_correct);
					return ;
				}				
			}
			if(passwd_is_true){
				//$('#tx_oldpasswd').html('');
				if(newpasswd==''){
					$('#tx_newpasswd').html(new_passwd_not_empty);
					return ;
				}else if(!passwdreg.test(newpasswd)){
					$('#tx_newpasswd').html(str_pwd_len);//新密码长度为6至16位
					return ;
				}else if(renewpasswd==''){
					//$('#tx_newpasswd').html('');
					$('#tx_renewpasswd').html(confirm_new_passwd_not_empty);
					return ;
				}else if(newpasswd!=renewpasswd){
					$('#tx_renewpasswd').html(passwd_not_agreed);
					return ;
				}else if($.trim(oldpasswd) == $.trim(newpasswd)){
					$('#tx_newpasswd').html(str_old_new_pwd_not_same); //新密码与老密码不能相同
				}else{
					//$('#tx_renewpasswd').html('');
					$.ajax({
						url:'/Appadmin/Index/modifyPasswd',
						type:'post',
						data:{password:newpasswd},
						success:function(res){							
							$.global_msg.init({gType:'warning',msg:res['message'],icon:1,time:2,endFn: function () {
								location.href="/Appadmin/Login/logout/delauto/1"; //"/Appadmin/Index/modifyPasswd"
							}});
							//location.href="/Appadmin/adminInfo/modifyPasswd"
						}
					});
				}				
			}
		}
	});
});