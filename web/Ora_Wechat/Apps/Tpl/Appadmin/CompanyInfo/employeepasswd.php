<layout name="../Layout/Appadmin/Layout" />
<div class="content_global">
	<div class="modifyinfo_user">
		<span>{$T->username}：</span><em> {$employee_info['name']}</em>
	</div>

	<div class="modifyinfo_namepass">
		<span>{$T->new_passwd}：</span><input type='password' id='newpasswd'
			name='newpasswd' /><em id='tx_newpasswd'></em>
	</div>

	<div class="modifyinfo_buttonpass">
		<span></span>
		<input type="hidden" id='emp_id' name='emp_id' value="{$employee_info['id']}" />
		<button id='js_submit_passwd' class="big_button">{$T->modify_info_submit}</button>
	</div>
</div>
<script>
 	var bizid='{$employee_info["bizid"]}';
	var str_pwd_len 	= "{$T->str_pwd_len}"; //新密码长度为6至16位 
	var new_passwd_not_empty = "{$T->new_passwd_not_empty}";
	var public = '__PUBLIC__';

	$(function(){
	 
		//修改密码
		$('#js_submit_passwd').on('click',function(){ 
			var newpasswd = $('input[name="newpasswd"]').val(); 
		    var id= $('input[name="emp_id"]').val(); 
			 
			var passwdreg = /^[\w|!|@|#|$|%|^|&|*|\(|\)|,|.|?|<|>|/|_\+]{6,16}$/;
			 
					//$('#tx_oldpasswd').html('');
					if(newpasswd==''){
						$('#tx_newpasswd').html(new_passwd_not_empty);
						return ;
					}else if(!passwdreg.test(newpasswd)){
						$('#tx_newpasswd').html(str_pwd_len);//新密码长度为6至16位
						return ;
					} else{
						//$('#tx_renewpasswd').html('');
						$.ajax({
							url:'/Appadmin/CompanyInfo/employeepasswd',
							type:'post',
							data:{id:id,password:newpasswd},
							success:function(res){	 				
								$.global_msg.init({gType:'warning',msg:res['message'],icon:1,time:2,endFn: function () {
									location.href="/Appadmin/CompanyInfo/employee/bizid/"+bizid; //"/Appadmin/Index/modifyPasswd"
								}}); 
							}
						});
					}				
				 
		});
	});

	
</script>