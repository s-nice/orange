<layout name="../Layout/Company/AdminLTE_layout" />
	<script>
		var postUrl = "__URL__/emailPost";
		var tip_has_blank = '{$T->tip_has_blank}';
		var tip_effective_email = '{$T->tip_effective_email}';
		$(function(){
			$.system.updateEmail();
		});
	</script>
	<div class="invoice_content">
		<div class="updatepass_c">	
			<div class="updatepass_label">
				<span class="updatepass_span"><em>*</em>{$T->str_login_pwd}：</span><input class="form_focus" type="password" name="pass">
			</div>
			<div class="updatepass_label">
				<span class="updatepass_span"><em>*</em>{$T->str_new_email}：</span><input class="form_focus" type="text" name="newemail">
			</div>
			<div class="updatepass_label">
				<span class="updatepass_span huadong"><em>*</em><e id="verifyLabel">滑动验证：</e></span>
				<div class="yanz_position">
	                <!-- 图片验证码模板 -->
	                <div id='imgc' style="display:none;"><span id='img'></span></div>
	                <div id='td'><span id='drag'></span></div>
	                <span id='info'></span><br><!-- 错误提示信息 -->
	            </div>
			</div>
			<div class="div_label_btn change_s_btn">
				<span class="btn_sub" id="js_email_sub">{$T->str_btn_submit}</span>
				<a href="__URL__/sysSet"><span class="btn_can" id="js_upemail_can">{$T->btn_return}</span>
			</div>
		</div>
	</div>
	<include file="Common/imageVerify" />