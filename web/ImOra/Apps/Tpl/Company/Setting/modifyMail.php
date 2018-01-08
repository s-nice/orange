<layout name="../Layout/CompanyLayout" />
<form action="{:U(MODULE_NAME . '/Setting/modifyMailOpera')}" id="loginForm" method="post"></form>
			<input type="hidden" value="{$formKey}" name="formkey" id="loginKey"/>
			<input type="hidden" id="usertype" name="usertype"  value="biz"/>
			 <div class="login_from_password">
				<span>登录密码</span>
				<input type="password" value="" autocomplete="off" id="password" name="password"/>
				<i class="js_login_error_msg"></i>
			</div> 
			<div class="login_from_user">
				<span>新邮箱</span>
				<input type="text" value="" id="mail" name="mail" />
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

<include file="Common/imageVerify" /><!-- 引入图片滑动验证公用代码 -->
<script>
var gUpdateMail = "{:U(MODULE_NAME . '/Setting/modifyMailOpera',array('key'=>$THINK.ACTION_NAME))}";
var gUrlSucc   = "{:U(MODULE_NAME . '/Setting/success',array('type'=>'updMailSucc'))}";
$(function(){
	$('.cls_login_buton').click(function(){
		$.setUpdateMail.init();
	});
});
$.extend({
	setUpdateMail:{
		init:function(){
			if(this.valid()){
				this.submit();
			}
		},
		valid:function(){
			var data = this.getParam();
			if(data.password=='' || data.mail==''){
				$('#info').html('参数不能为空');
				return false;
			}
			if(data.pwdAgain != data.newPwd){
				$('#info').html('确认新密码必须和新密码不相同');
				return false;
			}
			if(!gVerifyBool){
				$('#info').html(gStrLoginVerifyError);
				return false;	
			}
			return true;
		},
		getParam:function(){
			var password = $.trim($('#password').val());
			var mail     = $.trim($('#mail').val());
			return {
				password: password,
				mail:	  mail,
				}
		},
		submit:function(){
			var data = this.getParam();
			$.ajax({
				type : "POST",
				url : gUpdateMail,
				data : data,
				dataType : 'json',
				success : function(result) {
					var code = result.status;
					var error = result.msg;
					switch (code) {
						case 0: /* 登陆成功 */
							window.location.href = gUrlSucc;
						default:
							$('#info').html(error);
					}					
				}
			});
		}
	}
});
</script>