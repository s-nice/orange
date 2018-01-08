<layout name="../Layout/H5Layout720" />
<style>
	html,body{
		width:100%;
		height:100%;
		background:#fff;
	}
</style>
<section class="ap_main">
	<div class="ap_icon">
		<img src="__PUBLIC__/images/imgShareInset@3x.png" alt="">
	</div>
	<div class="ap_video">
		<div class="vedio_item">
			<video id="my-video" class="video-js vjs-big-play-centered" controls preload="auto"
                     poster="{$postpic}" data-setup="{}">
		        <!-- <source src="__PUBLIC__/video/vedio_test.mp4" type="video/mp4"> -->
		        <source src="{$filmsrc}" type="video/mp4">
	            <p class="vjs-no-js">
	              To view this video please enable JavaScript, and consider upgrading to a web browser that
	              <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
	            </p>
            </video>
            <script src="__PUBLIC__/js/jsExtend/h5videojs/video.min.js"></script> 
		</div>
		<div class="ap_time">{$posttime}</div>
		<div class="ap_footer">
			<div class="ap_foote_mar">
				<dl>
					<dt></dt>
					<dd>
						<h4>彩拍</h4>
						<p>制作关于我最真实的故事</p>
					</dd>
				</dl>
				<button type="button">立即下载</button>
			</div>
		</div>
	</div>
</section>
<script>
	var title = "{$title}";
	$("head").append("<meta name='description' content='"+title+"'>");
</script>