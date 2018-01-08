<layout name="../Layout/H5CompanyIntroLayout" />
<style>
	.homepage-content{
		font-size: 0.6rem;
		/*clear: both;*/
		float: left;
		/*display: block;*/
		/*position: fixed;*/
		overflow: hidden;
	}
</style>
<section class="content">
	<div class="intro_c news_content_c">
		<foreach name="contents" item="content">
			<div class="homepage-content" wid = "{$content['width']}" hgt="{$content['height']}" style="">
			<if condition="$content['type'] eq 0">
				<div style="margin: 20% 10%;overflow: hidden;width: 80%;height:50%;word-break: break-all;">
					{$content['content']}
				</div>
			<elseif condition="$content['type'] eq 1"/>
				<img src="{$content['respath']}" alt="" width="100%" height="100%">
			<elseif condition="$content['type'] eq 2"/>
				<video src="{$content['respath']}"  width="100%" controls="controls">您的浏览器不支持该视频。</video>
			</if>
			</div>
		</foreach>
	</div>
	<script type="text/javascript" src="__PUBLIC__/js/jquery/jquery.js"></script>
	<script type="text/javascript">
	$(".homepage-content").each(function(){
		var initWidth = parseInt(parseInt($(this).closest(".news_content_c").css("width"))/2);
		var width = parseInt($(this).attr('wid')*initWidth)+'px';
		var height = parseInt($(this).attr('hgt')*initWidth)+'px';
		$(this).css('width',width);
		$(this).css('height',height);
	})
	</script>	
</section>
