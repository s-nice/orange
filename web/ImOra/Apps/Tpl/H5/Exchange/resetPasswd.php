<layout name="../Layout/H5Layout720" />
<header class="head_box">
	<a href=""><i><img src="__PUBLIC__/images/ic_back_normal.png"></i></a>
	<h2>{$T->h5_reset_passwd_title}</h2>
</header>
<section class="content">
	<div class="logo">
		<div class="logo_img logo_top">
			<img src="__PUBLIC__/images/Xxhdpi.png">
		</div>
	</div>
	<div class="js_resetPasswd_div action_form">
		<div class="text_box">
			<div class="num_box">
				<label for="reset_pwd"><span class="pwd_text">{$T->h5_reset_passwd}</span></label><input id="reset_pwd" type="password" name="passwd1" />
			</div>
			<div class="num_box  padd_top">
				<label for="pwd_sure"><span>{$T->h5_confirm_reset_passwd}</span></label><input id="pwd_sure" type="password" name="passwd2" />
			</div>
			<p>{$T->h5_addacount_passwd_requirement}</p>
			<div class="new_box">
				<button id="js_Login" jsGoUrl ="{:U('h5/exchange/getIndex','','',true)}" jsUrl="{:U('h5/exchange/resetPasswdAct','','',true)}" class="js_Login new_btn">{$T->h5_reset_and_login}</button>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
var t = [];
t['login_fail_fornetwork'] = '{$T->login_fail_fornetwork}';
$(function(){
	$.h5.resetPasswdPage();
});
</script>
<include file="addFriend" />