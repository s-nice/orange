$(function(){

	$("body").keydown(function(event) {
		if (event.keyCode == "13") {//keyCode=13是回车键
		 $('#js_login_btn').trigger('click');
		}
	});
	$('input').on('focus',function(){
		$(this).popover('hide');
	});
	$('.js_tab_btn').on('click',function(){
		$('.js_login_account').toggle();
		$('.js_login_qrcode').toggle();
		$(this).toggleClass('login-wei-icon');
		//$('.js_tab_div').hide();
	});
	$('#js_login_btn').on('click',function(){
		var account = $.trim($('.js_account').val());
		if(!account){
			$.selfTip($('.js_account'),"请填写用户名");  
			return false; 
		}
		var pwd = $.trim($('.js_pwd').val());
		if(!pwd){
			$.selfTip($('.js_pwd'),"请填写密码");  
			return false; 
		}
		if(account&&pwd){
			$.post(loginUrl,{account:account,password:pwd},function(re){
				if(re.status==0){
					$('#js_login_btn').attr('disabled','disabled');
					window.location.href=re.url;
				}else{
					//$.dialog.alert({content:re.msg});
					$.selfTip($('.js_account'),re.msg);  
					return false;
				}
			});
		}
	});
	if(wxLoginMsg){
		$.dialog.alert({content:wxLoginMsg});
	}
	//var redirect_uri = 'http://wp.oradt.com/Ora_Wechat/Public/Company/Login/wx.html';
	var obj = new WxLogin({
	      id:"js_qrcode", 
	      appid: appid, 
	      scope: "snsapi_login", 
	      redirect_uri: redirectUrl,
	      state: wxState,
	      style: "black",
	      href: qrcodeCssUrl,
	    });

	
});