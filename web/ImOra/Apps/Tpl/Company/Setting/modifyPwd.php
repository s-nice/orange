<layout name="../Layout/Company/Layout" />
			<input type="hidden" value="{$uuid}" name="uuid" id="uuid"/>
			<input type="hidden" id="usertype" name="usertype"  value="biz"/>
			<div class="login_from_user">
				<span>原始密码</span>
				<input type="password" value="" id="oldPwd" name="oldPwd" />
			</div>
			<div class="login_from_user">
				<span>新密码</span>
				<input type="password" value="" id="newPwd" name="newPwd" />
			</div>
			<div class="login_from_password">
				<span>确认新密码</span>
				<input type="password" value="" autocomplete="off" id="pwdAgain" name="pwdAgain"/>
				<i class="js_login_error_msg"></i>
			</div>
			<!-- 图片验证码模板 -->
			<div id='imgc'><span id='img'></span></div>
			<div id='td'><span id='drag'></span></div>
			<span id='info'></span><br><!-- 错误提示信息 -->
			<div class="login_from_bin cursorpointer  yuanjiao_input">
			  <input class="yuanjiao_input cursorpointer cls_login_buton" type="submit" value="确定" />
			</div>


<!-- 引入js -->
<script src="__PUBLIC__/js/jquery/jquery.js"></script>
<include file="Common/imageVerify" /><!-- 引入图片滑动验证公用代码 -->
<script>
var gUpdatePwd = "{:U(MODULE_NAME . '/Setting/modifyPwdOpera',array('key'=>$THINK.ACTION_NAME))}";
var gUrlSucc   = "{:U(MODULE_NAME . '/Setting/success',array('type'=>'updPwdSucc'))}";
$(function(){
	$('.cls_login_buton').click(function(){
		$.setUpdatePwd.init();
	});
});
$.extend({
	setUpdatePwd:{
		init:function(){
			if(this.valid()){
				this.submit();
			}
		},
		valid:function(){
			var data = this.getParam();
			if(data.oldPwd=='' || data.newPwd=='' || data.pwdAgain==''){
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
			var oldPwd = $.trim($('#oldPwd').val());
			var newPwd = $.trim($('#newPwd').val());
			var pwdAgain = $.trim($('#pwdAgain').val());
			return {
				oldPwd: oldPwd,
				newPwd: newPwd,
				pwdAgain: pwdAgain,
				}
		},
		submit:function(){
			var data = this.getParam();
			$.ajax({
				type : "POST",
				url : gUpdatePwd,
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