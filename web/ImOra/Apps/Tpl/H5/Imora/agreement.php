<layout name="../Layout/H5CompanyIntroLayout" />
<header class="head_box" style='display:none;'>
	<div class="faqsearch_box"><span class="name_top">{$data.question}</span></div>
</header>
<style type="text/css">
	table tr td{
		color:#ccc;
		padding: 5px 10px;
		text-align:left;
		vertical-align:top;
	}
</style>
<section class="content">
	<div class="intro_c news_content_c">
		{$content}
	</div>
	<script type="text/javascript" src="__PUBLIC__/js/jquery/jquery.js"></script>
	<script type="text/javascript">
    $(function(){
        $('.intro_c img').removeAttr('width').removeAttr('height').attr('width', '100%');
    });

    style(); // 调节样式
    function style(){
    	// 替换后的元素的子元素里面跟随父元素的样式
		$(".small,.normal,.big,.bigger").children().each(function(){
			$(this).css('font-size', '');
			$(this).css('font-family', '');
			$(this).css('line-height', '');
		});
		// 加粗标签子元素的处理
		$("strong").children().each(function(){
			$(this).css('font-weight','bold');
		})
    }
    
	</script>
</section>
<include file="../Layout/replaceAudio" />