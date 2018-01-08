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
        <link href="__PUBLIC__/css/globalPop.css" rel="stylesheet" type="text/css">

    </head>
<body>
		 <div action="{:U(MODULE_NAME . '/Login/index')}" id="loginForm" method="post" onsubmit="return false;">
			<input type="hidden" value="{$formKey}" name="formkey" id="formkey"/>
			<input type="hidden" id="usertype" name="usertype"  value="biz"/>
			<div class="login_from_user">
				<span></span>
				<input type="text" value="{$T->login_username}" id="username" name="username" />
			</div>
			<div class="login_from_password">
				<span></span>
				<input type="text" value="{$T->login_password}" autocomplete="off" id="password" name="password"/>
				<i class="js_login_error_msg"></i>
			</div>
			<!-- 图片验证码模板 -->
			<div id='imgc'><span id='img'></span></div>
			<div id='td'><span id='drag'></span></div>
			<span id='info'></span><br><!-- 错误提示信息 -->
			
			<div class="login_from_bin cursorpointer  yuanjiao_input">
			  <input class="yuanjiao_input cursorpointer cls_login_buton" type="submit" value="{$T->login_ok_btn}" />
				<a href="{:U(MODULE_NAME.'/Login/register')}">注册</a>
			</div>
			<!-- <div class="login_from_ts">Forgot password?</div> -->
		</div>
		<a href="{:U(MODULE_NAME.'/Login/resetPwdTpl')}">忘记密码?</a>
<!-- 引入js -->
<script src="__PUBLIC__/js/jquery/jquery.js"></script>
<script src="__PUBLIC__/js/oradt/Company/login.js"></script>
<script src="__PUBLIC__/js/oradt/Company/global.js"></script>
<include file="Common/imageVerify" /><!-- 引入图片滑动验证公用代码 -->
<script type="text/javascript">
    var codeLoginOther = "{$code}";//用户在其他地方登录code
    var rdtCode = "{$rdtCode}";
    var gUrlDoLogin = "{:U(MODULE_NAME . '/Login/index',array('key'=>$THINK.ACTION_NAME))}";
	var gLoginPassword = "{$T->login_password}";/*密码*/
	var gLoginUsernameExist = "{$T->login_username_exist}";/*用户名不存在*/
	var gLoginPasswordError = "{$T->login_password_error}";/*密码错误*/
	var gLoginUsernameCanntEmpty = "{$T->login_put_right_uname_pws}";/*用户名不能为空*/
	var gLoginUsernameFormatError = "{$T->login_put_right_uname_pws}";/*用户名格式错误*/
	var gLoginPasswordCanntEnpty = "{$T->login_put_right_uname_pws}";/*密码不能为空*/
	var gLoginOtherPlace = "{$T->str_login_other_place}"; //用户在其他地方登录提示信息
	var gMessageTitle = '{$T->str_g_message_title}';
	var gMessageSubmit1 = '{$T->str_g_message_submit1}';
	var gMessageSubmit2 =  '{$T->str_g_message_submit1}';	
	var gHttpHost = gPublic = "{:U('/','','','', true)}";//定义js中静态文件路径前缀
</script>
</body>
</html>