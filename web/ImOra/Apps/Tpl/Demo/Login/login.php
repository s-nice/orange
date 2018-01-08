<html>
<head>
<meta charset="UTF-8">
<title>登录橙脉</title>
<link href="__PUBLIC__/css/yanshigao.css?v={:C('APP_VERSION')}" rel="stylesheet" type="text/css">
<link href="__PUBLIC__/css/globalPop.css?v={:C('APP_VERSION')}" rel="stylesheet" type="text/css">
<style>
.menu{color:#666;}
.on{color:faa83f;}
.userinput{border: medium none;color: #333;float: left;font: 14px/30px "Microsoft yahei","微软雅黑";
height: 30px;width: 190px;}
</style>
</head>
<body>
<header class="head_box">
</header>
<section class="content">
	<div class="ImOra_logo" style="height:35px; color:#fff; font: bold 30px/35px 'Microsoft yahei','微软雅黑';">橙脉</div>
	<div class="ImOra_jjie">
<!-- 		<span class="span_lefttitle">{$T->h5_function_introduction_title}：</span> -->
		<span class="p_rightcont">{:str_replace('%s',"<br />",$T->h5_function_introduction_info)}</span>
	</div>
	<div class="ImOra_tixing">开启橙脉之旅吧&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<span divdata="yanzhengdl" class="menu on">验证登陆</span>|<span divdata="mimadl" class="menu">密码登陆</span></div>
	<div class="ImOra_form">
		<div class="ImOra_logo" style="float:left; margin-right:20px;"><img src="__PUBLIC__/images/ic_back_logo.png" /></div>
		<div style="float:left;">
			<div class="menudiv" id="yanzhengdl">
				<div class="ImOra_phone">
					<input id="js_v_codeId" type="hidden" name="codeId" value="" />
					<input class="qz_input" id="js_v_mcode" type="text" value="+86" name="mcode" />
					<span>|</span>
					<input class="qznum_input" id="js_v_phone" type='tel' min="0" inputmode="numeric" pattern="[0-9]*" placeholder="{$T->h5_input_phone_code}" value="" name="phone" />
				</div>
				<div class="ImOra_phone">
					<input class="moblie_numinput" id="js_v_phonecode" type="tel" placeholder="{$T->h5_input_verification_code}" value="" name="phoneCode" />
					<input id="js_sendPhoneCode" class="js_SendPhoneCode mobile_SendPhoneCode" jsUrl="{:U('demo/login/sendPhoneCode','','','',true)}"  type="button" value="{$T->h5_send_verification_code}" />	
				</div>
				<div class="ImOra_bin">
					<input id="js_phoneLogin" jsGoUrl ="{:U('demo/index/index','','',true)}" jsUrl="{:U('demo/login/phoneLogin','','',true)}" type="button" value="{$T->h5_verification_login}" />
				</div>
			</div>
			<div class="menudiv" id="mimadl"  style="display: none;">
			<form action="{:U('demo/Login/index')}" id="loginForm" method="post">
				<input type="hidden" value="{$formKey}" name="loginKey" id="loginKey"/>
				<input type="hidden" id="usertype" name="usertype"  value="basic" />
				<div class="ImOra_phone">
					<input class="userinput" type="text" value="{$T->login_username}" min="0" inputmode="numeric" pattern="[0-9]*" id="username" name="username" />
				</div>
				<div class="ImOra_phone">
					<input class="userinput" type="text" value="{$T->login_password}" autocomplete="off" id="password" name="password"/>
				</div>
				<span style="margin-left:25px;color: red;font: 9px/16px 'Microsoft yahei','微软雅黑';" class="js_login_error_msg"></span>
				<div class="ImOra_bin">
					<input class="yuanjiao_input cursorpointer cls_login_buton" type="button" value="{$T->login_ok_btn}" />
				</div>
			</form>
			</div>
			
		</div>
	</div>
</section>
<script type="text/javascript">
var t = [];
t['sendCode_fail_fornetwork'] = '{$T->sendCode_fail_fornetwork}';
t['phone_code_error'] = '{$T->h5_pop_phone_type_error}';
t['send_succ'] = '{$T->h5_pop_send_succ}';
t['verification_code_error'] = '{$T->h5_pop_verification_code_error}';
t['h5_resend_verification_code'] ='{$T->h5_resend_verification_code}';
t['h5_send_verification_code'] = '{$T->h5_send_verification_code}';
t['login_fail_fornetwork'] = '{$T->login_fail_fornetwork}';
</script>
<script type="text/javascript" src="__PUBLIC__/js/jquery/jquery.src.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/layer/layer.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/oradt/globalPop.js"></script>

<script src="__PUBLIC__/js/jsExtend/jquery.cookie.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/oradt/demo.js?v={:C('APP_VERSION')}"></script>
<script type="text/javascript">
var gMessageTitle = '{$T->h5_global_pop_title}';
var gMessageSubmit1 = '{$T->h5_global_pop_submit}';
var gMessageSubmit2 = '{$T->h5_global_pop_cancel}';
var gPublic = "{:U('/','','','', true)}";
var JS_PUBLIC = "__PUBLIC__";
$(function(){
	// 切换登陆方式
	$('.menu').on('click',function(){
		$('.menu').removeClass('on');
		$(this).addClass('on');
		$('.menudiv').css('display','none');
		$('#'+$(this).attr('divdata')).css('display','block');
	});
	// 判断再次发送验证码的时间
	var nowtime = Date.parse(new Date());
	if($.cookie("h5timesRun") != null){
		var timesrun = nowtime - $.cookie("h5timesRun");
		if(timesrun < 60*1000){
			$.cookie("h5PhoneCode")
			$('#js_v_phone').val($.cookie("h5PhoneCode"));
		    $('#js_v_mcode').val($.cookie("h5PhoneMCode"));
		    $('#js_v_codeId').val($.cookie("h5PhoneCodeId"));
			timesrun = 60-timesrun/1000;
			$.demo.sendPhoneTime(timesrun);
		}
	}
	$.demo.init();
});

/**
 * 密码登陆
 */
var gLoginPassword = "{$T->login_password}";/*密码*/
var gLoginUsernameExist = "{$T->login_username_exist}";/*用户名不存在*/
var gLoginPasswordError = "{$T->login_password_error}";/*密码错误*/
var gLoginUsernameCanntEmpty = "{$T->login_put_right_uname_pws}";/*用户名不能为空*/
var gLoginUsernameFormatError = "{$T->login_put_right_uname_pws}";/*用户名格式错误*/
var gLoginPasswordCanntEnpty = "{$T->login_put_right_uname_pws}";/*密码不能为空*/

$(function($) {
	$('#password').on('focus', function() {
		$(this).attr('type', 'password');
		var pass = $(this).val();
		if (pass != gLoginPassword) {
			return false;
		}
		$(this).val('');
	}).on('blur', function() {
		if ($(this).val() == '' || $(this).val() == gLoginPassword) {
			$(this).attr('type', 'text');
			$(this).val(gLoginPassword);
		}
	});

	//监听登陆事件
	$('.cls_login_buton').on('click', function() {
		doLogin();
	});

	//切换初始化时状态和登录错误时html结构状态
	$('#loginForm').on(
			'click',
			'.clsUsernameError,.clsPwdError',
			function(dom, j, k) {
				var obj = $(this);
				if (obj.hasClass('clsUsernameError')) {
					obj.parents('.user_name').html(
							$('.clsInit>.user_name').children().clone());
					$('#loginForm #username').focus();
				} else if (obj.hasClass('clsPwdError')) {
					obj.parents('.user_password').html(
							$('.clsInit>.user_password').children().clone());
					$('#loginForm #password').focus();
				}
			});

	//绑定用户名失去焦点、获取焦点事件
	$('#loginForm').on(
	// 邮箱手机号
	{
		'focus' : function() {
			var obj = $(this);
			inputDefaultValClear(obj);
		},
		'blur' : function() {
			var obj = $(this);
			inputDefaultValAdd(obj, 'user');
		}
	}, '#username');
	//绑定密码失去焦点、获取焦点事件
	$('#loginForm').on({
		'focus' : function() {
			var obj = $(this);
			inputDefaultValClear(obj);
		},
		'blur' : function() {
			var obj = $(this);
			inputDefaultValAdd(obj, 'pwd');
		}
	}, '#password');

	//回车自动登陆
	document.onkeydown = function(event) {
		if (!$('.cls_login_btn').parent().is(':visible')) {
			e = event ? event : (window.event ? window.event : null);
			if (e.keyCode == 13) {
				//执行的方法
				doLogin();
			}
		}
	}
});

/**
 * 执行登录操作
 */
function doLogin() {
	var form = $('#loginForm');
	var url = form.attr('action');
	var username = $.trim(form.find('#username').val());
	var password = $.trim(form.find('#password').val());
	var data = {
		'username' : username,
		'password' : password,
		'usertype' : form.find('#usertype').val(),
		'formkey' : $('#loginKey').val()
	}
	// 验证用户名
	var usernameReg = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
	if (!username || username == form.find('#username').get(0).defaultValue) {
		$('.js_login_error_msg').html(gLoginUsernameCanntEmpty);
		return;
	}
//		if (!usernameReg.test(username)) {
//			$('.js_login_error_msg').html(gLoginUsernameFormatError);
//			return;
//		}
	// 验证密码
	if (!password || password == form.find('#password').get(0).defaultValue) {
		$('.js_login_error_msg').html(gLoginPasswordCanntEnpty);
		return;
	}
	$.ajax({
		type : "POST",
		url : url,
		data : data,
		dataType : 'json',
		success : function(result) {
			var code = result.status;
			var error = result.msg;
			switch (code) {
				case 0: /* 登陆成功 */
					// countreg(0);//登陆统计
					$('.js_login_error_msg').html('');
					window.location.href = result.data.url;
					break;
				case 10000://用户名错误
					// countreg(1,10000);//登陆统计
				case 10001://密码错误
					// countreg(1,10001);//登陆统计
				default:
					$('.js_login_error_msg').html(error);
			}
		}
	});
}

// 清空默认值
function inputDefaultValClear(obj) {
	var val = $.trim(obj.val());
	if (val == obj.get(0).defaultValue) {
		obj.val('');
	}
}
// 添加默认值
function inputDefaultValAdd(obj, type) {
	var val = $.trim(obj.val());
	var form = $('#loginForm');
	var utype = form.find('#usertype').val();

	if (type == 'user' && val == '') {
		obj.val(obj.get(0).defaultValue);
		$('#password').attr('type', 'text');
		$('#password').val(gLoginPassword);
		$('#autologin').prop('checked', false).parent('i')
				.removeClass('active');
	}
	/*if (type == 'user' && username != val) {
		$('#password').attr('type', 'text');
		$('#password').val(gLoginPassword);
		$('#autologin').prop('checked', false).parent('i')
				.removeClass('active');
	}
	if (type == 'user' && username == val) {
		$('#password').attr('type', 'password');
		$('#password').val(password);
		$('#autologin').prop('checked', true).parent('i').addClass('active');
	}*/
	if (type == 'pwd' && val == '') {
		obj.val(obj.get(0).defaultValue);
	}

}
/**
 * 在页面中生成隐藏的iframe
 * 
 * @param frameName
 *            隐藏的iframe id和name的名称，可不传递，默认为hidden_frame
 */
function genFrame(frameName) {
	var frameName = frameName || 'hidden_frame';
	if (typeof ($('#' + frameName).attr('src')) == 'undefined') {
		var iframeHtml = '<iframe id="'
				+ frameName
				+ '" name="'
				+ frameName
				+ '"  style="display:none;" id="hidden_frame" width="100%" height="100%"></iframe>';
		$('body').append(iframeHtml);
	}
}
</script>
</body>
</html>
