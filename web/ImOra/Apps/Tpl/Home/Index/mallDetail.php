<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>商城-产品详情页</title>
<link rel="stylesheet" href="__PUBLIC__/css/Officialwebsite.css" />
</head>
<body>
	<div class="Officialwebsite_all">
		<div class="Officialwebsite_header">
	       <include file="Index/_headMenu"/>
        </div>
		<div class="mallindex_content_c">
			<div class="mallindex_detail">
				<div class="detail_leftimg">
				    <img style="display:none; height: 308px; width: 548px;" src="" />
				    <div id="jsVideo0">
					<video class="video_player" src="__PUBLIC__/video/shopping1.mp4" autoplay loop></video>
					<div class="detail_copper"></div>
					</div>
					<em>了解详情&gt;</em>
				</div>
				<div class="detail_rightcont">
					<div class="detail_name">
						<span>外观</span>
						<div class="detail_xz">
							<div colorV="copper" class="jsChangeColor detail_xzfirst active">
								<i class="m"></i>
								<em>玫瑰金</em>
							</div>
							<div colorV="gold" class="jsChangeColor detail_xzfirst">
								<i class="x"></i>
								<em>香槟色</em>
							</div>
							<div colorV="white" class="jsChangeColor detail_xzfirst">
								<i class="y"></i>
								<em>银色</em>
							</div>
							<div colorV="black" class="jsChangeColor detail_xzfirst">
								<i class="h"></i>
								<em>黑色</em>
							</div>
						</div>
					</div>
					<div class="detail_rmb">RMB 4999元</div>
					<div class="jsAddCart detail_gm">购买</div>
				</div>
			</div>
			<div class="detail_content_c">
				<div class="content_c_img"><img src="__PUBLIC__/images/detail_img3.jpg" /></div>
				<div class="content_t_img"><img src="__PUBLIC__/images/detail_img4.jpg" /></div>
				<div class="content_r_img"><img src="__PUBLIC__/images/detail_img5.jpg" /></div>
			</div>
			<div class="detail_video"><img src="__PUBLIC__/images/detail_img6.jpg" /></div>
		</div>
		<div class="mallindex_footer"><p>Copyright © 2016 IMORA Inc. 保留所有权利京公安网安备 11010500896 京ICP备10214630 </p></div>
	</div>
</body>
<script src="__PUBLIC__/js/jquery-1.9.1.min.js"></script>
<script src="__PUBLIC__/js/jquery.cookie.min.js"></script>
<script>
$(function(){
    var i = 0;
    // 切换产品详情
	switch(i){
	   case 0:
		   break;
	   case 1:
		   $('.detail_leftimg img').attr('src','__PUBLIC__/images/mallindex_cpimg1.jpg').css('display','block');
		   $('.detail_rightcont .detail_rmb').text('RMB 199元');
		   $('#jsVideo0').css('display','none');
           break;
	   case 2:
		   $('.detail_leftimg img').attr('src','__PUBLIC__/images/mallindex_cpimg2.jpg').css('display','block');
	       $('.detail_rightcont .detail_rmb').text('RMB 149元');
           $('#jsVideo0').css('display','none');
		   break;
       default:
    	   ;
	}
    // 购买按键
    $('.jsAddCart').on('click',function(){
        $('.jsShowCart').trigger('click');
    });
    // 切换颜色
    $('.jsChangeColor').on('click',function(){
    	$('.jsChangeColor').removeClass('active');
    	$(this).addClass('active');
        $('.detail_leftimg div').attr('class','detail_'+$(this).attr('colorV'));
    });
});
</script>
</html>