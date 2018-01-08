$(function(){
	if(typeof(rdtCode)!='undefined' && typeof(gLoginOtherPlace) != 'undefined' && rdtCode == codeLoginOther){
		$.global_msg.init({gType:'warning',icon:1,msg:gLoginOtherPlace,endFn:function(){}});
		//$('#info').html(gLoginOtherPlace);
	}
	$('.js_login_btn_parent').on('click','.cls_login_buton',doLogin);
	//绑定用户名失去焦点、获取焦点事件
	$('#loginFormEnt').on({
		'focus' : function() {
			// 输入焦点，将错误提示删除
			$('#usernameEnt').popover('destroy');
			inputDefaultValClear($(this));
		},
		'blur' : function() {
			inputDefaultValAdd($(this), 'user');
		}
	}, '#usernameEnt');// 邮箱手机号
	//绑定密码失去焦点、获取焦点事件
	$('#loginFormEnt').on({
		'focus' : function() {
			var obj = $(this);
			inputDefaultValClear(obj);
			if(obj.attr('type') == 'text'){
				obj.attr('type', 'password');
				obj.val('');
			}
			// 输入焦点，将错误提示删除
			$('#passwordEnt').popover('destroy').attr('type','password');
		},
		'blur' : function() {
			var obj = $(this);
			inputDefaultValAdd(obj, 'pwd');
			
		}
	}, '#passwordEnt');
});
function doLogin(){
	var username = $.trim($('#usernameEnt').val());
	var password = $.trim($('#passwordEnt').val());
	// 验证用户名
	var usernameReg = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
	if(!username){
		// 错误提示
		$('#usernameEnt').attr('data-content',gLoginUsernameCanntEmpty);
		$('#usernameEnt').popover({placement:'left', trigger:'manual'});
		$('#usernameEnt').popover('show');
		return;
	}
	if (!usernameReg.test(username)) {
		//$('#info').html(gLoginUsernameFormatError);
		// 错误提示
		$('#usernameEnt').attr('data-content',gLoginUsernameFormatError);
		$('#usernameEnt').popover({placement:'left', trigger:'manual'});
		$('#usernameEnt').popover('show');
		return;
	}	
	if(!password || password == gLoginPassword){
		//$('#info').html(gLoginUsernameCanntEmpty);
		// 错误提示
		$('#passwordEnt').attr('data-content',gLoginPasswordCanntEnpty);
		$('#passwordEnt').popover({placement:'left', trigger:'manual'});
		$('#passwordEnt').popover('show');
		return;	
	}	
	if(!gVerifyBool){
		//$('#info').html(gStrLoginVerifyError);
		$('#verifyLabel').attr('data-content',gStrLoginVerifyError);
		$('#verifyLabel').popover({placement:'left', trigger:'manual'});
		$('#verifyLabel').popover('show');
		return;	
	}
	$('#info').html('');
	var usertype = $('#usertype').val();
	var formkey = $('#formkey').val();
	var data = {
			username: username,
			password: password,
			usertype: usertype,
			formkey:  formkey
			};
	$.ajax({
		type : "POST",
		url : gUrlDoLogin,
		data : data,
		dataType : 'json',
		success : function(result) {
			var code = result.status;
			var error = result.msg;
			switch (code) {
				case 0: /* 登陆成功 */
					// countreg(0);//登陆统计
					window.location.href = result.data.url;
					break;
				case 10000://用户名错误
					// countreg(1,10000);//登陆统计
				case 10001://密码错误
					// countreg(1,10001);//登陆统计
				default:
				//	$.global_msg.init({gType:'warning',icon:1,msg:error,endFn:function(){}});
				//$('#info').html(error); gLoginUserPwdError
					var html = '<div class="alert alert-warning alert-dismissible js_login_tips">\
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>\
                <h4><i class="icon fa fa-warning"></i> 登录失败!</h4>\
                <span class="js_error_tips">'+error+'</span>\
                </div>';
				if($('.js_login_tips').size() == 1){
					$('.js_login_tips').removeClass('hidden');
					$('.js_login_tips .js_error_tips').html(error);
				}else{
					$('.login-box-msg').append(html);
				}	
				refreshImg(); //刷新验证码
			}
			
		}
	});
}

//清空默认值
function inputDefaultValClear(obj) {
	var val = $.trim(obj.val());
	if (val == obj.get(0).defaultValue) {
		//console && console.log('test',val)
		obj.val('');
		//console && console.log(obj.val())
	}
}

//添加默认值
function inputDefaultValAdd(obj, type) {
	var val = $.trim(obj.val());
	if (type == 'user' && val=='') {
		obj.val(obj.get(0).defaultValue);
	}else if(type == 'pwd' && val==''){
		if (obj.val() == '' || obj.val() == gLoginPassword) {
			//obj.attr('type', 'text');
			//obj.val(gLoginPassword);
		}
	}
}

var gButtonInterval = 1;
setInterval(setButtonDisabled,gButtonInterval);
//未输入用户名和邮箱时设置按钮不可点击
function setButtonDisabled(){
	gButtonInterval = 1000;
	if(!$.trim($('#usernameEnt').val()) ||  !$.trim($('#passwordEnt').val()) || $.trim($('#passwordEnt').val()) == gLoginPassword || gVerifyBool==false){
		$('#cls_login_buton').addClass('button_disabled').removeClass('cls_login_buton');
	}else{
		$('#cls_login_buton').removeClass('button_disabled').addClass('cls_login_buton');
	}
}