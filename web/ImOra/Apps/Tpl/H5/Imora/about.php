<layout name="../Layout/H5Layout" />
<header class="head_box">
	<!-- <div class="about_box"><span>V1.13版本更新</span></div> -->
</header>
<section class="content">
	<div class="about_content">
		<div class="about_content_g">
			<span><i>个性化</i><em>我的名片多重身份工作中、生活中，展示不同名片</em></span>
			<img src="__PUBLIC__/images/mobile_img_gex.jpg" />
		</div>
		<div class="about_content_f">
			<span><i>富媒体名片</i><em>加视频、录语音，订制专属名片名片夹，我，我的富媒体名片</em></span>
			<img src="__PUBLIC__/images/mobile_img_f.jpg" />
		</div>
		<div class="about_content_d">
			<span><i>多选交换</i><em>手指推、雷达扫，单人多人同时换名片</em></span>
			<img src="__PUBLIC__/images/mobile_img_d.jpg" />
		</div>
		<div class="about_content_z">
			<span><i>智能化</i><em>分组管理  智能分组、自定义分组，轻松管理名片</em></span>
			<div class="Officialwebsite_qiehuan" style='overflow-x:hidden;'>
				<ul>
				    <li i='3'>
						<i><img src="__PUBLIC__/images/Application_videoimg11.jpg" /></i>
						<em><img src="__PUBLIC__/images/Application_videobg2.jpg" /></em>
					</li>
				    <li i='4'>
						<i><img src="__PUBLIC__/images/Application_videoimg41.jpg" /></i>
						<em><img src="__PUBLIC__/images/Application_videobg2.jpg" /></em>
					</li>
					<li i='0' class="video_play">
						<i><img src="__PUBLIC__/images/Application_videoimg31.jpg" /></i>
						<em><img src="__PUBLIC__/images/Application_videobg2.jpg" /></em>
					</li>
					<li i='1'>
						<i><img src="__PUBLIC__/images/Application_videoimg21.jpg" /></i> 
						<em><img src="__PUBLIC__/images/Application_videobg2.jpg" /></em>
					</li>
					<li i='2'>
						<i><img src="__PUBLIC__/images/Application_videoimg51.jpg" /></i>
						<em><img src="__PUBLIC__/images/Application_videobg2.jpg" /></em>
					</li>
				</ul>
			</div>
			<div class='Officialwebsite_btn'>
				<ol>
					<li class="active"></li>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
				</ol>
			</div>
		</div>
		<div class="about_content_sz">
			<span><i>设置任务</i><em>任务提示、主动约好友，人脉维护更省心</em></span>
			<img src="__PUBLIC__/images/mobile_img_sz.jpg" />
		</div>
		<div class="about_content_wd">
			<span><i>有温度</i><em>记录互动  分享生活、趣味互动，记录你与我的共同回忆</em></span>
			<img src="__PUBLIC__/images/mobile_img_wd.jpg" />
		</div>
	</div>
</section>
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/touch/touch-0.2.14.min.js"></script>


<script type="text/javascript">
$(function(){
	var boxWidth;//ul容器宽度
	var index=0;//当前显示的video
	var liWidth=$('.Officialwebsite_qiehuan ul li').width();//轮播li宽度
	var ulWidth=liWidth*$('.Officialwebsite_qiehuan ul li').length+10;//所有轮播li宽度总和
	var animationDuration=1000;//动画播放时间
	var $obj=$('.Officialwebsite_qiehuan');
    var flag=false;//切换按钮是否可以点击

    //不同分辨率的切换自适应
	$(window).on('resize',function(){
		boxWidth=$(this).width();
		boxWidth = boxWidth > 1700 ? 1700 : boxWidth;
		$obj.width(boxWidth);
		$obj.find('ul').width(ulWidth);

		//需要手动居中了
		if (ulWidth > boxWidth){
			$obj.scrollLeft((ulWidth-boxWidth)/2);
		}
	});
	$(window).resize();
	
	touch.on('.Officialwebsite_qiehuan', 'swipeleft', function(e){
		e.preventDefault();
		aaa(1);
	});

	touch.on('.Officialwebsite_qiehuan', 'swiperight', function(e){
		e.preventDefault();
		aaa(-1);
	});

	function aaa(n){
		if (flag) return;
		flag=true;
		$obj.find('ul').width(9999999);
		$obj.find('em').css('opacity',0);
		
		//把相应的下一个 OR 上一个元素克隆到 尾部 OR 头部 
		if (n>0){
			$obj.find('ul li:last').after($obj.find('ul li:first').clone(true).removeClass('video_play'));
		} else {
			$obj.find('ul li:first').before($obj.find('ul li:last').clone(true).removeClass('video_play'));
			var left=parseInt($obj.scrollLeft());
			$obj.scrollLeft(left+liWidth);
		}

		//放大，淡入淡出动画
		if (n>0){
			//IE8只有淡入淡出，没有放大
			$li=$obj.find('ul li:eq('+(2+n)+')');
			$li.addClass('video_play').find('em').animate({opacity:1},animationDuration);
			$('.video_play:first').removeClass('video_play');
		} else {
			$li=$obj.find('ul li:eq('+(2)+')');
			$li.addClass('video_play').find('em').animate({opacity:1},animationDuration);
			$('.video_play:last').removeClass('video_play');
		}
		

		//毛玻璃遮罩
		$('.moreShadow').removeClass('moreShadow');
		$('.video_play').prev().find('i > img, i > video').addClass('moreShadow');
        $('.video_play').next().find('i > img, i > video').addClass('moreShadow');
        
        //li移动动画
		$obj.find('ul li').each(function(idx){
			var left=parseInt($(this).css('left'));
			if (!left) left=0;
			left=left+(-n*liWidth);
			$(this).animate({left:left},animationDuration);
		});

		//动画结束后的收尾工作
		setTimeout(function(){
			$obj.find('ul li').css('left',0);
			$obj.find('ul').width(ulWidth);

			//多余的li删除掉
			for(var j=0;j<Math.abs(n);j++){
				if (n>0){
					$obj.find('ul li:first').remove();
				} else {
					$obj.find('ul li:last').remove();
				}
			}

			//最后，ul的滚动条需要对其
			if (n<0){
				$obj.scrollLeft((ulWidth-$obj.width())/2);
			}
			flag=false;
		},animationDuration+50);
		index+=n;
		$('.Officialwebsite_btn li').removeClass('active');
		$('.Officialwebsite_btn li:eq('+(index%5)+')').addClass('active');
	}
});
</script>
