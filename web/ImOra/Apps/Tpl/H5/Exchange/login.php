<layout name="../Layout/H5Layout720" />
<header class="head_box">
	<a href="{$goBackUrl}"><i>
<!-- 	<img src="__PUBLIC__/images/ic_back_normal.png"> -->
	</i></a>
	<h2>{$T->h5_verification_login_title}</h2>
</header>
<section class="content">
	<div class="logo">
		<div class="logo_img">
			<img src="__PUBLIC__/images/Xxhdpi.png">
		</div>
		<p>{:sprintf($T->h5_function_introduction_info,"<br />")}</p>
	</div>
	<div class="action_form">
		<div class="text_box">
			<div class="num_box"><label for="login_numm"><span class="pwd_text">{$T->h5_title_phone_code}</span></label><input id="login_num" min="0" maxlength="11" inputmode="numeric" pattern="[0-9]*" name="user" type="tel" value="{$phone}" placeholder="{$T->h5_input_phone_code}"/></div>
			<div class="js_ImOraPasswd num_box  padd_top">
				<label for="login_pwd"><span class="pwd_text">{$T->h5_title_login_passwd}</span></label>
				<input id="login_pwd" name="passwd" type="password" />
				<div class="login_bg"><em class="class_close"></em></div>
			</div>
			<p style="color:#fdfdfd;" class="js_forget_pwd forget_pwd" jsUrl="{:U('h5/exchange/forgetPasswd','','',true)}">{$T->h5_title_forget_passwd}</p>
			<div class="login_box">
				<button jsCheckPhoneUrl="{:U('h5/exchange/checkPhone','','html',true)}" jsGoToUrl ="{:U('h5/exchange/register','','html',true)}" jsGoUrl ="{:U('h5/exchange/getIndex','','',true)}" jsUrl="{:U('h5/exchange/loginAct','','',true)}" class="js_accountPwd_login login_btn">{$T->h5_verification_login}</button>
			</div>
			<p class="no_number"><span><i>{$T->h5_title_no_account}</i><i style="color:#fdfdfd;" class="js_register_btn left_i" jsUrl="{:U('h5/exchange/register','','',true)}">{$T->h5_title_register}</i></span></p>
		</div>
	</div>
</section>
<footer class="get_foot">
	<p class="get_card">{$T->h5_login_prompt_information}</p>
</footer>
<script type="text/javascript">
var t = [];
t['login_fail_fornetwork'] = '{$T->login_fail_fornetwork}';
t['phone_code_error'] = '{$T->h5_pop_phone_type_error}';
$(function(){
	$.h5.loginPage();
});
</script>
<include file="addFriend" />