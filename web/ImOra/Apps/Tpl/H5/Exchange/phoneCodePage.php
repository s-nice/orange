	<div class="text_box">
		<input type="hidden" name="type" value="{$type}" />
		<input id="js_v_codeId" type="hidden" name="codeId" value="" />
		<input id="js_v_mcode" type="hidden" value="+86" name="mcode" />
		<div class="num_box">
			<label for="js_v_phone"><span class="pwd_text">{$T->h5_title_phone_code}</span></label><input id="js_v_phone" name="phone" min="0" maxlength="11" inputmode="numeric" pattern="[0-9]*" type="tel" value="{$phone}" placeholder="{$T->h5_input_phone_code}"/>
		</div>
		<div class="num_box  padd_top">
			<label for="js_v_phonecode"><span>{$T->h5_input_verification_code}</span></label><input id="js_v_phonecode" type="tel" value="" name="phoneCode" />
			<button id="js_sendPhoneCode" class="<if condition="$phone neq ''">js_SendPhoneCode exBtn</if> getBtn" jsCheckPhoneUrl="{:U('h5/exchange/checkPhone','','html',true)}" jsUrl="{:U('h5/exchange/sendPhoneCode','','','',true)}" jsGoLoginUrl ="{:U('h5/exchange/login','','',true)}" jsGoRegisterUrl ="{:U('h5/exchange/register','','',true)}">{$T->h5_send_verification_code}</button>
		</div>
		<div class="js_ImOraBin next_box">
			<button id="js_phoneRegister" jsGoUrl ="{$jsGoUrl}" jsUrl="{:U('h5/exchange/phoneRegister','','',true)}" class="js_phoneRegister next_btn">{$T->h5_str_next}</button>
		</div>
	</div>
<script type="text/javascript">
var t = [];
t['sendCode_fail_fornetwork'] = '{$T->sendCode_fail_fornetwork}';
t['phone_code_error'] = '{$T->h5_pop_phone_type_error}';
t['send_succ'] = '{$T->h5_pop_send_succ}';
t['verification_code_error'] = '{$T->h5_pop_verification_code_error}';
t['h5_resend_verification_code'] ='{$T->h5_resend_verification_code}';
t['h5_send_verification_code'] = '{$T->h5_send_verification_code}';
t['login_fail_fornetwork'] = '{$T->login_fail_fornetwork}';
</script>
<script src="__PUBLIC__/js/jsExtend/jquery.cookie.js"></script>
<script type="text/javascript">
$(function(){
	// 判断再次发送验证码的时间
	var nowtime = Date.parse(new Date());
	if($.cookie("h5timesRun") != null){
		var timesrun = nowtime - $.cookie("h5timesRun");
		if(timesrun < 60*1000){
			$.cookie("h5PhoneCode")
			$('#js_v_phone').val($.cookie("h5PhoneCode"));
		    $('#js_v_mcode').val($.cookie("h5PhoneMCode"));
		    $('#js_v_codeId').val($.cookie("h5PhoneCodeId"));
			timesrun = 60-timesrun/1000;
			$.h5.sendPhoneTime(timesrun);
		}
	}
	$.h5.phoneCodePage();
});
</script>