<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>商城-首页</title>
<link rel="stylesheet" href="__PUBLIC__/css/Officialwebsite.css" />
<style>
.mallindex_banner_img
{
position:relative;
}
.mallindex_banner_img video {
    left: 328px;
    position: absolute;
    top: 191px;
    width: 480px;
}
.mallindex_banner_img img {
    position: absolute;
    z-index: 2;
}
</style>
</head>
<body>
	<div class="Officialwebsite_all">
	<div class="Officialwebsite_header">
	  <include file="Index/_headMenu"/>
	</div>
		<div class="mallindex_content_c">
			<div class="mallindex_banner">
				<div class="mallindex_banner_title">
					<h2>LEAF</h2>
					<span>了解详情&gt;</span>
				</div>
				<div class="mallindex_banner_img">
                  <video src="__PUBLIC__/video/mall_2.mp4" autoplay="autoplay" loop="loop"></video>
				  <img src="__PUBLIC__/images/mallindex_banner.png" />
				</div>
				<div class="mallindex_banner_text">
					<span class="banner_text_t">随身携带的科技艺术臻品,极致轻薄,传承传统礼仪,快速流畅体验</span>
					<span i="0" class="jsAddCart textspan_gm"><i>RMB 4999</i><a style="color:#fff;" href="MallDetail.html"><em>购买</em></a></span>
				</div>
			</div>
			<div class="mallindex_bottom_c">
				<div class="mallindex_bottom_cleft">
					<div class="left_cont">
						<div class="left_cont_title">
							<h2>适配器</h2>
							<span>了解详情&gt;</span>
						</div>
						<div class="left_cont_img"><img src="__PUBLIC__/images/mallindex_cpimg1.jpg" /></div>
						<div class="left_cont_content">
							<span class="cont_text">紧凑便捷电源适配器</span>
							<span class="textspan_rmb">RMB 199</span>
							<span i="1" class="jsAddCart textspan_gmbox">购买</span>
						</div>
					</div>
				</div>
				<div class="mallindex_bottom_cright">
					<div class="right_cont">
						<div class="left_cont_title">
							<h2>连接线</h2>
							<span>了解详情&gt;</span>
						</div>
						<div class="right_cont_img"><img src="__PUBLIC__/images/mallindex_cpimg2.jpg" /></div>
						<div class="right_cont_content">
							<span class="cont_text">专属LEAF USB连接线</span>
							<span class="textspan_rmb">RMB 149</span>
							<span i="2" class="jsAddCart textspan_gmbox">购买</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="mallindex_footer"><p>Copyright © 2016 IMORA Inc. 保留所有权利京公安网安备 11010500896 京ICP备15052779号 </p></div>
	</div>
</body>
<script src="__PUBLIC__/js/jquery-1.9.1.min.js"></script>
<script src="__PUBLIC__/js/jquery.cookie.min.js"></script>
<script>
$(function(){
	// 购面按键
	$('.jsAddCart').on('click',function(){
        //$('.jsShowCart').trigger('click');
	});
	// 详情按键
	$('.jsAddInfo').on('click',function(){
        var i = $(this).attr('i');
    });

});
</script>
</html>