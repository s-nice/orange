<layout name="../Layout/H5Layout720" />
<header class="head_box">
	<a href="{$goBackUrl}">
	 <if condition="strpos($_SERVER['HTTP_USER_AGENT'], 'MQQBrowser') eq 0">
	  <i><img src="__PUBLIC__/images/ic_back_normal.png"></i>
	 </if>
	</a>
	<h2>{$T->h5_title_register_title}</h2>
</header>
<section class="content">
	<div class="logo">
		<div class="logo_img">
			<img src="__PUBLIC__/images/Xxhdpi.png">
		</div>
		<p>{:sprintf($T->h5_function_introduction_info,"<br />")}</p>
	</div>
	<div class="action_form">
		<include file="phoneCodePage" />
	</div>
</section>
<footer class="get_foot">
	<p class="get_card">{$T->h5_login_prompt_information}</p>
</footer>
<script type="text/javascript">
$(function(){
	$.h5.registerPage();
});
</script>