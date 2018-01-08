<layout name="../Layout/H5Layout720" />
<header class="head_box">
<!-- 	<i><img src="__PUBLIC__/images/ic_back_normal.png"></i> -->
	<h2>{$T->ha_save_card_end_title}</h2>
</header>
<section class="content">
	<div class="card_img">
		<img id="cardImg" src="{$vcardInfo['picture']}" alt="{: isset($vcardInfo['cardInfo']['name'])?$vcardInfo['cardInfo']['name']:$T->h5_undefined}"/>
	</div>
</section>
<footer class="foot_down">
	<p>{:sprintf($T->ha_save_card_end_info,"<br />","<i>$phone</i>")}</p>
	<a class="a_bin" href="{:U('h5/imora/download','','',true)}"><div class="download_btn">{$T->ha_save_card_end_download_app}</div></a>
</footer>