
<div>{$T->str_rwp_account_verify}<!-- 账号验证 --></div>
<form action="" id="loginForm" method="post"> </form>
			<input type="hidden" value="{$formKey}" name="formkey" id="loginKey"/>
			<input type="hidden" id="usertype" name="usertype"  value="biz"/>
			<div class="login_from_user">
				<span>邮箱</span>
				<input type="text" value="" id="email" name="email" />
			</div>
			<div class="login_from_user">
				<span>滑动验证</span>
				<!-- 图片验证码模板 -->
				<div id='imgc'><span id='img'></span></div>
				<div id='td'><span id='drag'></span></div>
				<span id='info'></span><br><!-- 错误提示信息 -->
			</div>
			<div class="login_from_bin cursorpointer  yuanjiao_input">
			  <input class="yuanjiao_input cursorpointer cls_login_buton" type="submit" value="确定" />
			</div>
			<!-- <div class="login_from_ts">Forgot password?</div> -->
<link href="__PUBLIC__/css/globalPop.css" rel="stylesheet" type="text/css">
<!-- 引入js -->
<script src="__PUBLIC__/js/jquery/jquery.js"></script>
<include file="Common/imageVerify" /><!-- 引入图片滑动验证公用代码 -->
<script>
var gUrlDoMail = "{:U(MODULE_NAME . '/Login/sendMail',array('key'=>$THINK.ACTION_NAME))}";

$(function(){
	$('.cls_login_buton').click(function(){
		doInputEmail();
		});
});
function doInputEmail(){
	var email = $.trim($('#email').val());
	if(!email){
		$('#info').html('邮箱不能为空');
		return;
	}
	var regexp = /^([\w\.\-_]+)\@([\w\-]+\.)([\w]{2,4})$/; 
	if(!regexp.test(email)){
		$('#info').html('邮箱格式错误');
		return false;
	}
	if(!gVerifyBool){
		$('#info').html(gStrLoginVerifyError);
		return;	
	}
	var data = {email:email};
	$.ajax({
		type : "POST",
		url : gUrlDoMail,
		data : data,
		dataType : 'json',
		success : function(result) {
			var code = result.status;
			var error = result.msg;
			switch (code) {
				case 0: /* 登陆成功 */
					$('#info').html('发送邮件完成,请查看邮箱');
					break;
				default:
					$('#info').html(error);
			}			
		}
	});
}

</script>