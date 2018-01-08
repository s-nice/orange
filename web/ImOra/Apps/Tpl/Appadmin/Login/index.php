<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=9" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <META   HTTP-EQUIV="Pragma"   CONTENT="no-cache">
        <META   HTTP-EQUIV="Cache-Control"   CONTENT="no-cache">
        <META   HTTP-EQUIV="Expires"   CONTENT="0">
        <title>Login</title>
        <link rel="shortcut icon" href="__PUBLIC__/images/favicon.ico">
        <link href="__PUBLIC__/css/appadmin.css" rel="stylesheet" type="text/css">
        <link href="__PUBLIC__/css/globalPop.css" rel="stylesheet" type="text/css">
    </head>
<body>
 <div class="appadmin_login" id="tbposition">
	<div class="appadmin_login_c">
		<div class="appadmin_login_b"><img src="__PUBLIC__/images/appadmin_login_banner.jpg" /></div>
		<div class="addmin_login_img"><img src="__PUBLIC__/images/appadmin_login_img.png" /></div>
	</div>
	<div class="appadmin_login_from">
		<div class="appadmin_login_from_c">
		 <form action="{:U('Appadmin/Login/index')}" id="loginForm" method="post">
			<!-- <input type="hidden" value="{$formKey}" name="loginKey" id="loginKey"/> -->
			<input type="hidden" id="usertype" name="usertype"  value="admin" />
			<div class="login_from_user">
				<span></span>
				<input type="text" value="{$T->login_username}" id="username" name="username" autocomplete="off" />
				<i class="js_login_error_msg"></i>
			</div>
			<div class="login_from_password">
				<span></span>
				<input type="text" value="{$T->login_password}" autocomplete="off" id="password" name="password" autocomplete="off" />
			</div>
			<div class="login_from_p"><input class="login_remember_password" style="display:block;" type="checkbox" id="autologin" value="1" name="autologin"/><label class="login_remember_password" for="autologin">{$T->login_remember_pwd}</label></div>
			<div class="login_from_bin cursorpointer  yuanjiao_input"><input class="yuanjiao_input cursorpointer cls_login_buton" type="button" value="{$T->login_ok_btn}" /></div>
			<!-- <div class="login_from_ts">Forgot password?</div> -->
			</form>
		</div>
	</div>
	 <!-- footer部分start -->
	 <include file="@Layout/foot" />
	 <!-- footer部分end -->
</div>
<!-- 引入js -->
<script src="__PUBLIC__/js/jquery/jquery.js"></script>
<script src="__PUBLIC__/js/jsExtend/layer/layer.min.js"></script>
<script src="__PUBLIC__/js/oradt/globalPop.js"></script>
<script src="__PUBLIC__/js/jsExtend/jquery.cookie.js"></script>
<script type="text/javascript">
	var gLoginPassword = "{$T->login_password}";/*密码*/
	var gLoginUsernameExist = "{$T->login_username_exist}";/*用户名不存在*/
	var gLoginPasswordError = "{$T->login_password_error}";/*密码错误*/
	var gLoginUsernameCanntEmpty = "{$T->login_put_right_uname_pws}";/*用户名不能为空*/
	var gLoginUsernameFormatError = "{$T->login_put_right_uname_pws}";/*用户名格式错误*/
	var gLoginPasswordCanntEnpty = "{$T->login_put_right_uname_pws}";/*密码不能为空*/
	var gRememberpwdkeyAuto = "{$rememberpwdkey['auto']}"; //记住密码按钮key
	var gRememberpwdkeyUname = "{$rememberpwdkey.uname}"; //记住密码用户名key
	var gRememberpwdkeyUpwd = "{$rememberpwdkey.upwd}"; //记住密码中密码kye

	var gMessageTitle = '{$T->str_g_message_title}';
	var gMessageSubmit1 = '{$T->str_g_message_submit1}';
	var gMessageSubmit2 =  '{$T->str_g_message_submit1}';
	var gHttpHost = gPublic = "{:U('/','','','', true)}";//定义js中静态文件路径前缀
</script>
<script src="__PUBLIC__/js/oradt/login.js"></script>
</body>
</html>