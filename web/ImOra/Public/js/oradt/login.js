var LOGIN_G = {
		AUTO : gRememberpwdkeyAuto,
		UNAME : gRememberpwdkeyUname,
		PWD   : gRememberpwdkeyUpwd
};
;$(function($) {
	getRemindMe();//记住密码
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
	var autologin 	=  form.find('#autologin').prop('checked') || '';//记住密码
	var data = {
		'username' : username,
		'password' : password,
		'usertype' : form.find('#usertype').val(),
		'formkey' : $('#loginKey').val(),
		'autologin' : autologin
	}
	// 验证用户名
	var usernameReg = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
	if (!username || username == form.find('#username').get(0).defaultValue) {
		$('.js_login_error_msg').html(gLoginUsernameCanntEmpty);
		return;
	}
	if (!usernameReg.test(username)) {
		$('.js_login_error_msg').html(gLoginUsernameFormatError);
		return;
	}
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
					var auto = form.find('#autologin').prop('checked') || '';
					if(auto){/*记住密码*/
						var validay = 30;//有效期30天
						$.cookie(LOGIN_G.AUTO+data.usertype,auto,{expires:validay,path:"/"});
						$.cookie(LOGIN_G.UNAME+data.usertype,data.username,{expires:validay,path:"/"});
						$.cookie(LOGIN_G.PWD+data.usertype,result.data.p,{expires:validay,path:"/"});
					}else{/*取消记住密码,必须要加上路径，不然删除不了*/
						$.cookie(LOGIN_G.AUTO+data.usertype,null,{path:"/"});
						$.cookie(LOGIN_G.UNAME+data.usertype,null,{path:"/"});
						$.cookie(LOGIN_G.PWD+data.usertype,null,{path:"/"});
					}
					$('.js_login_error_msg').html('');
					window.location.href = result.data.url;
					break;
				case 10000://用户名错误
					// countreg(1,10000);//登陆统计
				case 10001://密码错误
					// countreg(1,10001);//登陆统计
				default:
					$('.js_login_error_msg').html(error);
				    $('#loginKey').val(result.data.formKey);//更新formkey值
			}
		}
	});
}

//记住密码功能之获取记住的信息
function getRemindMe(){
	var form 	= $('#loginForm');
	var utype = form.find('#usertype').val()
	var remindMe = $.cookie(LOGIN_G.AUTO+utype);
	if(remindMe){
		var username = $.cookie(LOGIN_G.UNAME+utype);
		var password = $.cookie(LOGIN_G.PWD+utype);
		
		form.find('#username').val(username);
		form.find('#password').val(password).attr('type','password');
		form.find('#autologin').prop('checked',true);//.parent().addClass('active')
	}
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
	var remindMe = $.cookie(LOGIN_G.AUTO+utype);
	var username = $.cookie(LOGIN_G.UNAME+utype);
	var password = $.cookie(LOGIN_G.PWD+utype);

	if (type == 'user' && val == '') {
		obj.val(obj.get(0).defaultValue);
		$('#password').attr('type', 'text');
		$('#password').val(gLoginPassword);
		$('#autologin').prop('checked', false);//.parent('i').removeClass('active')
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