<layout name="../Layout/H5Layout720" />
<header class="head_box">
	<a href="{$goBackUrl}"><i><img src="__PUBLIC__/images/ic_back_normal.png"></i></a>
	<h2>{$T->h5_mobile_phone_verification_title}</h2>
</header>
<section class="content">
	<div class="logo">
		<div class="logo_img logo_top">
			<img src="__PUBLIC__/images/Xxhdpi.png">
		</div>
	</div>
	<div class="action_form">
		<include file="phoneCodePage" />
	</div>
</section>
<script type="text/javascript">
$(function(){
	$.h5.phoneResetPasswd();
});
</script>