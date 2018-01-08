<layout name="../Layout/Company/AdminLTE_layout" />
	<script>
		var postUrl = "__URL__/passPost";
		var tip_has_blank = '{$T->tip_has_blank}';
		var tip_pwd_not_eq = '{$T->tip_pwd_not_eq}';
		$(function(){
			$.system.updatePass();
		});
	</script>
	<div class="updatepass_content">
		<div class="updatepass_c">	
			<div class="updatepass_label">
				<span class="updatepass_span"><em>*</em>{$T->str_old_pwd}：</span><input class="form_focus" type="password" name="oldpass">
			</div>
			<div class="updatepass_label">
				<span class="updatepass_span"><em>*</em>{$T->new_passwd}：</span><input class="form_focus" type="password" name="newpass">
			</div>
			<div class="updatepass_label">
				<span class="updatepass_span"><em>*</em>{$T->affirm_new_passwd}：</span><input class="form_focus" type="password" name="re_newpass">
			</div>
			<div class="updatepass_label">
				<span class="updatepass_span huadong"><em>*</em>滑动验证：</span>
				<div class="yanz_position">
	                <!-- 图片验证码模板 -->
	                <div id='imgc' style="display:none;"><span id='img'></span></div>
	                <div id='td'><span id='drag'></span></div>
	                <span id='info'></span><br><!-- 错误提示信息 -->
	            </div>
			</div>
			<div class="div_label_btn change_s_btn">
				<span class="btn_sub" id="js_uppass_sub">{$T->str_btn_submit}</span>
				<a href="__URL__/sysSet"><span class="btn_can" id="js_uppass_can">{$T->btn_return}</span>
			</div>
		</div>	
	</div>
	<include file="Common/imageVerify" />
