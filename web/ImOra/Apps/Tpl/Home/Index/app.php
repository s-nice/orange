<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>{$T->str_title_app}</title>
<link rel="stylesheet" href="__PUBLIC__/css/Officialwebsite.css" />
</head>
<body>

<div class="Officialwebsite_all">
	<div class="Officialwebsite_header">
	  <include file="Index/_headMenu"/>
	</div>
	<div class="Officialwebsite_content_c">
		<div class="Officialwebsite_APP_title"><i>{$T->str_app_01}</i><em>{$T->str_app_02}</em></div>
		<div class="Officialwebsite_APP_c">
			<i><img src="__PUBLIC__/images/Application_gxhimg.png" /></i>
			<em>
			<div id="jquery_jplayer_1"></div>
			<video src="__PUBLIC__/video/application_gxh.mp4" autoplay loop></video>
			</em>
			<div class="mask"><img src="__PUBLIC__/images/Application_gxhimg1.png" /></div>
		</div>

	</div>
	<div class="Officialwebsite_APP_media">
		<div class="Officialwebsite_media_title"><i>{$T->str_app_03}</i><em>{$T->str_app_04}</em></div>
		<div class="Officialwebsite_media_c">
			<i><img src="__PUBLIC__/images/Application_mediaimg.png" /></i>
			<em id='a2'>
			<div id="jquery_jplayer_2" ></div>
			<video src="__PUBLIC__/video/Application_media.mp4" autoplay loop></video>
			</em>
		</div>
	</div>
	<div class="Officialwebsite_APP_exchange">
		<div class="Officialwebsite_exchange_title"><i>{$T->str_app_05}</i><em>{$T->str_app_06}</em></div>
		<div class="Officialwebsite_exchange_c"><img src="__PUBLIC__/images/Application_exchangeimg.png" /></div>
	</div>
	<div class="Officialwebsite_APP_intelligent">
		<div class="Officialwebsite_intelligent_title"><i>{$T->str_app_07}</i><em>{$T->str_app_08}</em></div>
		<div class="Officialwebsite_qiehuan">
			<ul>
				<li i='2'>
					<i><img src="__PUBLIC__/images/Application_videoimg4.jpg" /></i>
					<em><img src="__PUBLIC__/images/Application_videobg2.jpg" /></em>
				</li>
				<li i='3'>
					<i><img src="__PUBLIC__/images/Application_videoimg1.jpg" /></i>
					<em><img src="__PUBLIC__/images/Application_videobg2.jpg" /></em>
				</li>

				<li i='4'>
					<i><img src="__PUBLIC__/images/Application_videoimg2.jpg" /></i>
					<em><img src="__PUBLIC__/images/Application_videobg2.jpg" /></em>
				</li>
				<li i='0' class="video_play">
					<i>
        			<img id='img1' style='display:none;' src="__PUBLIC__/images/Application_videoimg5.jpg" />
					<video src="__PUBLIC__/video/smart1.mp4"></video>
					</i>
					<em><img src="__PUBLIC__/images/Application_videobg2.jpg" /></em>
				</li>
				<li i='1'>
					<i><img src="__PUBLIC__/images/Application_videoimg3.jpg" /></i>
					<em><img src="__PUBLIC__/images/Application_videobg2.jpg" /></em>
				</li>
				<li i='2'>
					<i><img src="__PUBLIC__/images/Application_videoimg4.jpg" /></i>
					<em><img src="__PUBLIC__/images/Application_videobg2.jpg" /></em>
				</li>
				<li i='3'>
					<i><img src="__PUBLIC__/images/Application_videoimg1.jpg" /></i>
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
	<div class="Officialwebsite_APP_Setup">
		<div class="Officialwebsite_Setup_title"><i>{$T->str_app_09}</i><em>{$T->str_app_10}</em></div>
		<div class="Officialwebsite_Setup_c"><img src="__PUBLIC__/images/Application_Setupimg.jpg" /></div>
	</div>
	<div class="Officialwebsite_APP_temperature">
		<div class="Officialwebsite_temperature_title"><i>{$T->str_app_11}</i><em>{$T->str_app_12}</em></div>
		<div class="Officialwebsite_temperature_c"><img src="__PUBLIC__/images/Application_temperatureimg.jpg" /></div>
	</div>
	<div class="Officialwebsite_APP_footer">
<!-- 		<div class="search_footer"> -->
<!-- 			<span class="name">{$T->str_search_label}</span> -->
<!-- 			<span class="right_input"> -->
<!-- 				<input type="text" class="text_input" /> -->
<!-- 				<input type="button" class="button_input" value="{$T->str_search_btn}" /> -->
<!-- 			</span> -->
<!-- 		</div> -->
		<div class="Officialwebsite_APP_beian">
			<p>{$T->str_foot_copyright}</p>
		</div>
	</div>
</div>
</body>
<script type="text/javascript" src="__PUBLIC__/js/jquery/jquery.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/jplayer/jquery.jplayer.min.js"></script>
<script type="text/javascript">
var isIE8,isIE9,isIE10,isWinSafari;
var browser=navigator.appName
var b_version=navigator.appVersion
var version=b_version.split(";");
if (version.length>1){
	var trim_Version=version[1].replace(/[ ]/g,"");
	if(browser=="Microsoft Internet Explorer" && trim_Version=="MSIE8.0"){
		isIE8=true;
	}
	if(browser=="Microsoft Internet Explorer" && trim_Version=="MSIE9.0"){
		isIE9=true;
	}
	if(browser=="Microsoft Internet Explorer" && trim_Version=="MSIE10.0"){
		isIE10=true;
	}
}

var isVideo=$('video')[0].play?true:false;
var u = navigator.userAgent.toLowerCase();
if (u.indexOf('windows')!=-1 && u.indexOf('safari')!=-1 && u.indexOf('chrome')==-1){
	isWinSafari=true;
	$('#a2').css('left',0.98);
}
$(function(){
	//IE8和windows的safari，添加flash播放器
	if (isIE8 || isWinSafari){
		$("#jquery_jplayer_1").jPlayer({
			preload: 'auto',
			ready: function () {
				$(this).jPlayer("setMedia", {
					m4v: "__PUBLIC__/video/application_gxh.mp4",
				}).jPlayer('play');
			},
			loop: true,
			swfPath: "__PUBLIC__/js/jsExtend/jplayer",
			solution: "flash",
			supplied: "m4v",
			size: {width: "254px",height: "712px"}
		});

		$("#jquery_jplayer_2").jPlayer({
			preload: 'auto',
			ready: function () {
				$(this).jPlayer("setMedia", {
					m4v: "__PUBLIC__/video/Application_media.mp4",
				}).jPlayer('play');
			},
			loop: true,
			swfPath: "__PUBLIC__/js/jsExtend/jplayer",
			solution: "flash",
			supplied: "m4v",
			size: {width: "503px",height: "703px"}
		});
		$('#img1').show();
	}
	
	var boxWidth;//ul容器宽度
	var index=0;//当前显示的video
	var liWidth=$('.Officialwebsite_qiehuan ul li').width();//轮播li宽度
	var ulWidth=liWidth*$('.Officialwebsite_qiehuan ul li').length+10;//所有轮播li宽度总和
	var animationDuration=1000;//动画播放时间
	var $obj=$('.Officialwebsite_qiehuan');
    var flag=false;//切换按钮是否可以点击
    
	//不同分辨率的切换自适应
	$(window).on('resize',function(){
		boxWidth=$(this).width()-200;
		boxWidth = boxWidth > 1700 ? 1700 : boxWidth;
		$obj.width(boxWidth);
		$obj.find('ul').width(ulWidth);

		//需要手动居中了
		if (ulWidth > boxWidth){
			$obj.scrollLeft((ulWidth-boxWidth)/2);
		}
	});
	$(window).resize();
	
	if (isIE8){
		$('.video_play em').css({opacity:1});
		//取消中间元素的透明度
		$obj.find('ul li:eq('+(3)+')').find('img:first').css({opacity:1});
	}

	if (isIE10){
		setTimeout(function(){
			$obj.append('<aaa>111</aaa>');
			setTimeout(function(){
				$('aaa').remove();
			},500);
		},500);
	}
	
	//视频播放
	if (isVideo){
		$('video').on('mouseover',function(){
			if ($(this).css('opacity')!=1){
				return;
			}
			$(this)[0].play();
		});
	}
	
	//切换按钮
	$('.Officialwebsite_btn ol li').each(function(i){
		$(this).attr('i',i).on('click',function(){
			if ($(this).hasClass('active')) return;
			if (flag) return;
			flag=true;
			var i=$(this).attr('i')-'';
			if (index==i){
				return;
			}

			//高亮效果
			$('.Officialwebsite_btn ol li').removeClass('active');
			$(this).addClass('active');

			//视频停止并还原
			if (!isIE8 && isVideo){
				$obj.find('video')[0].pause();
				$obj.find('video')[0].currentTime=0;
			}
			
			var n=i-index;
			$obj.find('ul').width(9999999);
			if (isIE8 || isIE9){
				$obj.find('i img').css('opacity',0.3);
				$obj.find('video').css('opacity',0.3);
				$obj.find('li').removeClass('video_play');
			}
			$obj.find('em').css('opacity',0);
			
			//把相应的下一个 OR 上一个元素克隆到 尾部 OR 头部 
			for(var j=0;j<Math.abs(n);j++){
				if (n>0){
					$obj.find('ul li:last').after($obj.find('ul li:eq('+(j+2)+')').clone(true).removeClass('video_play'));
				} else {
					$obj.find('ul li:first').before($obj.find('ul li:eq('+(4)+')').clone(true).removeClass('video_play'));
					var left=parseInt($obj.scrollLeft());
					$obj.scrollLeft(left+liWidth);
				}
			}

			//放大，淡入淡出动画
			if (n>0){
				//IE8只有淡入淡出，没有放大
				$li=$obj.find('ul li:eq('+(3+n)+')');
				if (isIE8){
					$li.find('img:first').animate({opacity:1},animationDuration);
					$li.find('em').animate({opacity:1},animationDuration);	
				} else if(isIE9){
					$li.addClass('video_play').find('img:first').animate({opacity:1},animationDuration);
					$li.find('video').animate({opacity:1},animationDuration);
					$li.find('em').animate({opacity:1},animationDuration);
				} else {
					$li.addClass('video_play').find('em').animate({opacity:1},animationDuration);
					$('.video_play:first').removeClass('video_play');
				}
			} else {
				$li=$obj.find('ul li:eq('+(3)+')');
				if (isIE8){
					$li.find('img:first').animate({opacity:1},animationDuration);
					$li.find('em').animate({opacity:1},animationDuration);	
				} else if(isIE9){
					$li.addClass('video_play').find('img:first').animate({opacity:1},animationDuration);
					$li.find('video').animate({opacity:1},animationDuration);
					$li.find('em').animate({opacity:1},animationDuration);
				} else {
					$li.addClass('video_play').find('em').animate({opacity:1},animationDuration);
					$('.video_play:last').removeClass('video_play');
				}
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

				//如果有视频，则播放
				$('.video_play video').length && $('.video_play video')[0].play && $('.video_play video')[0].play();
				flag=false;
			},animationDuration+50);
			index=i;
		});
	});
});
</script>
</html>
