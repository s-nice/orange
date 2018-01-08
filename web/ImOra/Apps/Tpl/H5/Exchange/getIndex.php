<layout name="../Layout/H5Layout720" />
<header class="head_card">
	<b class="x_icon"></b>
	<h2>{$T->h5_index_title}</h2>
	<i class="js_addFriend">{$T->h5_global_create_index_submit}</i>
</header>
<section class="content">
<form name="js_addFriendForm" method="post" action="{:U('h5/exchange/addFriendPage','','','',true)}" target="hidden_form">
	<input type="hidden" name="localuuid" value="{$localuuid}" />
	<input type="hidden" name="vcardid" value="{$basicInfo.vcardid}" />
	<ul class="per_info">
		<li>
			<label for="js_v_name"><i>{$T->h5_global_pop_Name}</i></label><em>&gt;</em>
			<img src="__PUBLIC__/images/line_info.jpg">
			<input class="info_input" id="js_v_name" type="text" name="name" value="{$basicInfo.realname}" placeholder="{$T->h5_global_pop_Name}">
		</li>
		<li>
			<label for="cardInfo1"><i>{$T->h5_global_pop_Mobile}</i></label><em>&gt;</em>
			<img src="__PUBLIC__/images/line_info.jpg">
			<input id="cardInfo1" class="info_input" readonly="readonly" name="mobile" type="text" value="{$phone}" placeholder="{$T->h5_global_pop_Mobile}">
		</li>
	</ul>
	<h5 class="title_name">{$T->h5_global_pop_Firm}</h5>
	<ul class="company_info">
		<li class="bottom_line">
			<label for="cardInfo2"><i>{$T->h5_global_pop_company_name}</i></label><em></em>
			<img src="__PUBLIC__/images/line_info.jpg">
			<input id="cardInfo2" value="{$basicInfo.company}" name="company" type="text" class="info_input" placeholder="{$T->h5_global_pop_company_name}" >
		</li>
		<li class="bottom_line">
			<label for="cardInfo3"><i>{$T->h5_global_pop_Position}</i></label><em></em>
			<img src="__PUBLIC__/images/line_info.jpg">
			<input id="cardInfo3" name="department" value="{$basicInfo.department}" class="info_input" type="text" placeholder="{$T->h5_global_pop_Position}">
		</li>
		<li class="bottom_line">
			<label for="cardInfo4"><i>{$T->h5_global_pop_title}</i></label><em></em>
			<img src="__PUBLIC__/images/line_info.jpg">
			<input id="cardInfo4" value="{$basicInfo.title}" name="title" class="info_input" type="text" placeholder="{$T->h5_global_pop_title}">
		</li>
		<li class="bottom_line">
			<label for="cardInfo5"><i>{$T->h5_global_pop_Address}</i></label><em></em>
			<img src="__PUBLIC__/images/line_info.jpg">
			<input id="cardInfo5" value="{$basicInfo.address}" name="address" class="info_input" type="text" placeholder="{$T->h5_global_pop_Address}">
		</li>
		<li class="bottom_line">
			<label for="cardInfo6"><i>{$T->h5_global_pop_Phone}</i></label><em class="gt_font">&gt;</em>
			<img src="__PUBLIC__/images/line_info.jpg">
			<input id="cardInfo6" value="{$basicInfo.telephone}" name="telephone" class="info_input" min="0" inputmode="numeric" pattern="[0-9]*" type="tel"  placeholder="{$T->h5_global_pop_Phone}">
		</li>
		<li class="bottom_line">
			<label for="cardInfo7"><i>{$T->h5_global_pop_fax}</i></label><em class="gt_font">&gt;</em>
			<img src="__PUBLIC__/images/line_info.jpg">
			<input id="cardInfo7" value="{$basicInfo.fax}" name="fax" class="info_input" type="text" placeholder="{$T->h5_global_pop_fax}">
		</li>
		<li class="bottom_line">
			<label for="js_v_email"><i>{$T->h5_global_pop_Mail}</i></label><em class="gt_font">&gt;</em>
			<img src="__PUBLIC__/images/line_info.jpg">
			<input id="js_v_email" value="{$basicInfo.email1}" name="email" class="info_input" type="text" placeholder="{$T->h5_global_pop_Mail}">
		</li>
		<li>
			<label for="cardInfo8"><i>{$T->h5_global_pop_Www}</i></label><em></em>
			<img src="__PUBLIC__/images/line_info.jpg">
			<input id="cardInfo8" value="{$basicInfo.url}" name="url" class="info_input" type="text" placeholder="{$T->h5_global_pop_Www}">
		</li>
	</ul>
</form>
<iframe name="hidden_form" style="display:none"></iframe>
</section>
<script type="text/javascript">
var t = [];
t['pop_name_no_empty'] = '{$T->h5_pop_name_no_empty}';
t['pop_email1_error'] = '{$T->h5_pop_email1_error}';
</script>
<include file="addFriend" />
<script type="text/javascript">
$(function(){
	$.h5.getIndexPage();
});
</script>