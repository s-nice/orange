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
		 <form action="{:U('demo/Login/index')}" id="loginForm" method="post">
			<input type="hidden" value="{$formKey}" name="loginKey" id="loginKey"/>
			<input type="hidden" id="usertype" name="usertype"  value="basic" />
			<div class="login_from_user">
				<span></span>
				<input type="text" value="{$T->login_username}" id="username" name="username" />
			</div>
			<div class="login_from_password">
				<span></span>
				<input type="text" value="{$T->login_password}" autocomplete="off" id="password" name="password"/>
				<i class="js_login_error_msg"></i>
			</div>
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
<script type="text/javascript">
	var gLoginPassword = "{$T->login_password}";/*密码*/
	var gLoginUsernameExist = "{$T->login_username_exist}";/*用户名不存在*/
	var gLoginPasswordError = "{$T->login_password_error}";/*密码错误*/
	var gLoginUsernameCanntEmpty = "{$T->login_put_right_uname_pws}";/*用户名不能为空*/
	var gLoginUsernameFormatError = "{$T->login_put_right_uname_pws}";/*用户名格式错误*/
	var gLoginPasswordCanntEnpty = "{$T->login_put_right_uname_pws}";/*密码不能为空*/

	var gMessageTitle = '{$T->str_g_message_title}';
	var gMessageSubmit1 = '{$T->str_g_message_submit1}';
	var gMessageSubmit2 =  '{$T->str_g_message_submit1}';
	var gHttpHost = gPublic = "{:U('/','','','', true)}";//定义js中静态文件路径前缀
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
// 		if (!usernameReg.test(username)) {
// 			$('.js_login_error_msg').html(gLoginUsernameFormatError);
// 			return;
// 		}
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