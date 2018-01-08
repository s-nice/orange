<layout name="../Layout/Layout" />
<div class="content_global">
	<div class="modifyinfo_user"><span>{$T->username}：</span><em>{$admin_info['email']}</em></div>
	<div class="modifyinfo_time"><span>{$T->end_login_time}：</span><em>{$admin_info['logintime']}</em></div>
	<div class="modifyinfo_IP"><span>{$T->end_login_IP}：</span><em>{$admin_info['loginip']}</em></div>
	<div class="modifyinfo_name"><span>{$T->realname}：</span><input type='text' name='username' maxlength="26" value="{$admin_info['realname']}" /><em id='tx_username'></em></div>
	<!--
	<div class="modifyinfo_maile"><span>{$T->mobile}：</span><input type='text' name='mobile' value="{$admin_info['mobile']}" /><em id='tx_mobile'></em></div>
	 -->
	<div class="modifyinfo_button"><span></span><button id='js_submit'>{$T->modify_info_submit}</button></div>
</div>
<script>
	var email_format_error = "{$T->email_format_error}";
	var modify_fail = "{$T->modify_fail}";
</script>