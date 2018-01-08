<layout name="../Layout/Company/AdminLTE_layout" />
<link rel="stylesheet" href="__PUBLIC__/css/company.css" />
<link rel="stylesheet" href="__PUBLIC__/css/company/register.css" />
<?php $totalSeconds = 3; //倒计时秒?>
<div class="setpwd_warp">
	<div class="setpwd_content">
		<div class="setpwd_text">{$T->str_pwd_admin_email}<!-- 管理员邮箱  -->[{$email}]{$T->str_pwd_auth_succ} <!-- 认证成功， 请设置登录密码。 --></div>
		<form action="{:U(MODULE_NAME . '/ForgetPwd/setNewPwdOpera')}" id="loginForm" method="post" onsubmit="return false;">
					<input type="hidden" value="{$uuid}" name="uuid" id="uuid"/>
					<input type="hidden" id="usertype" name="usertype"  value="biz"/>
					<input type="hidden" id="activeUser" name="activeUser"  value="{$activeUser}"/>
					<div class="login_from_user">
						<span><i>*</i>{$T->str_pwd_password}<!-- 密码 --></span>
						<input type="password" value="" id="password" name="password" autocomplete="off"/>
					</div>
					<div class="login_from_password">
						<span><i>*</i>{$T->str_pwd_again_password}<!-- 确认密码 --></span>
						<input type="password" value="" autocomplete="off" id="passwordAgain" name="passwordAgain"/>
						<i class="js_login_error_msg"></i>
					</div>
					<div class="login_from_ts"><span></span><p>{$T->str_pwd_password_tip}<!-- 注：密码可以为字母、数字、字符组成，不少于8位，最长16位。 --></p></div>
					<div class="login_from_bin cursorpointer  yuanjiao_input">
					  <input class="yuanjiao_input cursorpointer cls_btn_ok" type="submit" value="{$T->str_pwd_btn_ok}" />
					</div>
					<!-- <div class="login_from_ts">Forgot password?</div> -->
		</form>
	</div>
</div>
<link href="__PUBLIC__/css/globalPop.css?v={:C('APP_VERSION')}" rel="stylesheet" type="text/css">
<!-- 引入js -->
<script src="__PUBLIC__/js/jquery/jquery.js"></script>
<script src="__PUBLIC__/js/jsExtend/layer/layer.min.js"></script>
<script src="__PUBLIC__/js/oradt/globalPop.js"></script>

<script>
var gMessageTitle = '{$T->str_g_message_title}';
var gMessageSubmit1 = '{$T->str_g_message_submit1}';
var gMessageSubmit2 =  '{$T->str_g_message_submit1}';
var gHttpHost = gPublic = "{:U('/','','','', true)}";//定义js中静态文件路径前缀

var gUrlDoSetPwd = "{:U('Company/ForgetPwd/setNewPwdOpera')}"; //设置新密码url
var gUrlLoginIndex = "{:U('Company/Login/index')}"; //登录url
//定时倒计时
var gTotalSeconds = '{$totalSeconds}'; //倒计时定时
var str_pwd_password_not_empty = "{$T->str_pwd_password_not_empty}";//密码不能为空!
var str_pwd_again_pwd_not_empty = "{$T->str_pwd_again_pwd_not_empty}"; //确认密码不能为空！
var str_pwd_two_password_not_same = "{$T->str_pwd_two_password_not_same}";//两次输入的密码不一致，请重新输入！
var str_pwd_set_new_succ = "{$T->str_pwd_set_new_succ}"; //密码设置成功，
var str_pwd_sec_redirect_login = "{$T->str_pwd_sec_redirect_login}";//秒后跳转到登录页
var str_pwd_fail = "{$T->str_pwd_fail}"; //失败
$(function(){
	$('.cls_btn_ok').click(function(){
		doSetNewPwd();
	});
	$('#password,#passwordAgain').val('')
});
function doSetNewPwd(){
	var uuid = $('#uuid').val();
	var usertype = $('#usertype').val();
	var activeUser = $('#activeUser').val();
	var password = $.trim($('#password').val());
	var passwordAgain = $.trim($('#passwordAgain').val());
	if(!password){
		return $.global_msg.init({gType:'warning',icon:2,msg:str_pwd_password_not_empty,endFn:function(){}});
	}
	if(!passwordAgain){
		return $.global_msg.init({gType:'warning',icon:2,msg:str_pwd_again_pwd_not_empty,endFn:function(){}});
	}
	if(password != passwordAgain){
		return $.global_msg.init({gType:'warning',icon:2,msg:str_pwd_two_password_not_same,endFn:function(){}});
	}
	//密码格式验证
	//....
	var data = {uuid:uuid,usertype:usertype,activeUser:activeUser,password:password,passwordAgain:passwordAgain};
	$.ajax({
		type : "POST",
		url : gUrlDoSetPwd,
		data : data,
		dataType : 'json',
		success : function(result) {
			var code = result.status;
			var error = result.msg;
			switch (code) {
				case 0: /* 登陆成功 */
					$.global_msg.init({gType:'warning',icon:1,msg: str_pwd_set_new_succ+'<i class="js_countdown">'+gTotalSeconds+'</i>'+str_pwd_sec_redirect_login,endFn:function(){
					}});
					setInterval(function(){
						settime();
					},1000);
					break;
				default:
					$.global_msg.init({gType:'warning',icon:2,msg:str_pwd_fail,endFn:function(){}});
			}
			
		}
	});
}

var countdown = gTotalSeconds; //倒计时定时
function settime() { 
    if (countdown == 0) { 
    		window.location.href = gUrlLoginIndex;
    } else { 
   		countdown--; 
   		$('.js_countdown').html(countdown)
	} 
} 

</script>