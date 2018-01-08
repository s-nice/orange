<layout name="../Layout/Appadmin/Layout" />
<div class="content_global">
	<div class="modifyinfo_user"><span>{$T->username}：</span><em>{$session_info['email']}</em></div>
	<!--
	<div class="modifyinfo_mail"><span>{$T->Email}：</span><em>{$session_info['email']}</em></div>
	 -->
	<div class="modifyinfo_namepass"><span>{$T->old_passwd}：</span><input type='password' id='oldpasswd' name='oldpasswd' /><em id='tx_oldpasswd'></em></div>
	<div class="modifyinfo_namepass"><span>{$T->new_passwd}：</span><input type='password' id='newpasswd' name='newpasswd' /><em id='tx_newpasswd'></em></div>
	<div class="modifyinfo_password"><span>{$T->affirm_new_passwd}：</span><input type='password' id='renewpasswd' name='renewpasswd' /><em id='tx_renewpasswd'></em></div>
	<div class="modifyinfo_buttonpass"><span></span><button id='js_submit_passwd' class="big_button">{$T->modify_info_submit}</button></div>
</div>
<script>
	var old_passwd_not_empty = "{$T->old_passwd_not_empty}";
	var old_passwd_not_correct = "{$T->old_passwd_not_correct}";
	var new_passwd_not_empty = "{$T->new_passwd_not_empty}";
	var confirm_new_passwd_not_empty = "{$T->confirm_new_passwd_not_empty}";
	var passwd_not_agreed = "{$T->passwd_not_agreed}";
	var str_pwd_len 	= "{$T->str_pwd_len}"; //新密码长度为6至16位
	var str_old_pwd_len = "{$T->str_old_pwd_len}"; //旧密码长度为6至16位
	var str_old_new_pwd_not_same = "{$T->str_old_new_pwd_not_same}"; //新密码与老密码不能相同
	var public = '__PUBLIC__';
</script>