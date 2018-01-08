<layout name="../Layout/H5Layout" />
<header class="head_box" style='display:none;'>
	<div class="faqsearch_box"><span class="name_top">{$data.question}</span></div>
</header>
<section class="content">
	<div class="intro_c news_content_c h5_main_content">
		{$content}
	</div>
	<script type="text/javascript" src="__PUBLIC__/js/jquery/jquery.js"></script>
	<script type="text/javascript">
		$(function(){
			$('.intro_c img').removeAttr('width').removeAttr('height').attr('width', '100%');
		});
	</script>
</section>
<include file="../Layout/replaceAudio" />