<layout name="../Layout/H5Layout720" />
<header class="head_box">
	<a href="{$goBackUrl}"><i><img src="__PUBLIC__/images/ic_back_normal.png"></i></a>
	<h2>{$T->h5_title_register_title}</h2>
</header>
<section class="content">
	<div class="logo">
		<div class="logo_img">
			<img src="__PUBLIC__/images/Xxhdpi.png">
		</div>
		<p>{:sprintf($T->h5_function_introduction_info,"<br />")}</p>
	</div>
	<div class="js_ImOraBin action_form">
		<div class="text_box">
			<div class="num_box"><label for="pwd1"><span class="pwd_text">{$T->h5_title_input_passwd}</span></label><input id="pwd1" type="password" name="passwd1" /></div>
			<div class="num_box padd_top"><label for="pwd2"><span class="pwd_text">{$T->h5_title_confirm_passwd}</span></label><input id="pwd2" type="password" name="passwd2" /></div>
			<p>{$T->h5_addacount_passwd_requirement}</p>
			<div id="js_Login" jsGoUrl ="{:U('h5/exchange/getIndex','','',true)}" jsUrl="{:U('h5/exchange/registerLogin','',true)}" class="js_Login register_btn">{$T->h5_register_and_login}</div>
		</div>
	</div>
</section>
<footer class="get_foot">
	<p class="get_card">{$T->h5_login_prompt_information}</p>
</footer>
<script type="text/javascript">
var t = [];
t['login_fail_fornetwork'] = '{$T->login_fail_fornetwork}';
$(function(){
	$.h5.registerLoginPage();
});
</script>
<include file="addFriend" />