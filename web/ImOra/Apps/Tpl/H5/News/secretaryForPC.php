<html>
	<head>
		<title>{$data.title}</title>
		<script type="text/javascript" src="__PUBLIC__/js/jquery/jquery.js"></script>
		<script type="text/javascript" src="__PUBLIC__/js/jquery/mobile.js"></script>
		<script type="text/javascript" src="__PUBLIC__/js/jsExtend/ueditor/ueditor.parse.js"></script>
		<script type="text/javascript" src="__PUBLIC__/js/jsExtend/lazyload.js"></script>
		<link rel="stylesheet" href="__PUBLIC__/css/H5/secretaryForPC.css">
	</head>
</html>
<body>
<if condition="$isShare != 'no'">
<header class="head_open js_downloadtop_div">
	<div class="load_text" >
		<div class="load_content">
			<span class="colse js_colse_downloadtop" ><img src="__PUBLIC__/images/c_close.png" alt=""></span>
			<span class="logo"><img src="__PUBLIC__/images/Xxhdpi.png" alt=""></span>
			<p>
				<em class="tit">橙脉</em>
				<em class="text">改变生活，橙鑫开始</em>
			</p>
			<small onclick="location.href='http://qr28.cn/BwGxze'">立即打开</small>
		</div>
	</div>
</header>
</if>
<header class="head-mi">
	<div class="faqsearch_box"><span class="name_top">{$data.title}</span></div>
</header>
<section class="content" id="ueditorcontent">
	<div class="news_content">
		<div class="news_name_l">
			<if condition="!empty($data['name'])">
			<em>{$data.name}</em>
			</if>
			<i>{$data.datetime}</i>
			<if condition="isset($data['category'])">
			<em>{$data.category}</em>
			</if>
		</div>
		<div class="news_content_c js_show_img">
			<p>{$data.content}</p>
		</div>
	</div>
</section>
<!-- 显示大图 -->
<div class="s_big_imgs js_img_box">
	<img class="animated" src="" alt="">
</div>
<script>
// 清除内容中无效图片,图片按照比例显示
$("div.news_content_c p").find("img,video").each(function(){
	if (typeof($(this).attr('src')) == "undefined") {
		$(this).remove();
	} else{
		// 延迟加载预备工作
		if ($(this).is('img')) {
			$(this).attr('data-original',$(this).attr('src'));
		}
	}
});
$(function(){
	// 图片延迟加载
	$("div.news_content_c p").find("img").lazyload({
		threshold:200
	});

	var nav_height=$(".load_text").height();
	var if_height=nav_height/2;
	$('#js_new_open').on('click',function(){
		// pc版本选择直接下载橙脉app
		if(navigator.platform.indexOf("Mac")==0){
			window.location.href = "http://itunes.apple.com/cn/app/id{:C('IOS_APP_STORE_ID')}";
		} else {
			window.location.href = "{:C('ANDROID_APP_LINK')}";
		}
	});
	$('.js_colse_downloadtop').on('click',function(){
		$('.js_downloadtop_div').hide();
	});
	//顶部滚动显示隐藏
	$(window).scroll(function(){
        var before = $(window).scrollTop();
        $(window).scroll(function() {
            var after = $(window).scrollTop();
            if (before<after) {
                $(".load_text").addClass("hide_top");
                $(".load_text").removeClass("show_top");
                if(after <= 0){
                	$(".load_text").addClass("show_top");
                	$(".load_text").removeClass("hide_top");
                }
                before = after;
            };
            if (before>after) {
                $(".load_text").addClass("show_top");
                $(".load_text").removeClass("hide_top");
                if(after <= 0){
                	$(".load_text").addClass("show_top");
                	$(".load_text").removeClass("hide_top");
                }
                before = after;
            };
        });
    });
    
	uParse('#ueditorcontent', { rootPath: '__PUBLIC__/js/jsExtend/ueditor' });
	
	// audio标签替换
	$('audio').each(function(){
		$(this).css({"display":"none"});
		var p = $(this).closest('p');
		p.css({"text-align":"center"});
		html = '<div style="width:300px;background-color:#fff;text-align:center;color:#5d5d5d;display:inline-block;position:relative;">'
		html += '<span>'+'00:00'+'</span><img src="__PUBLIC__/images/ic_show_sonic.png" style="height:100%;position:absolute;" class="audio_img">';
		$(this).after(html);
		html += '</div>'

		$(this)[0].addEventListener("canplay", function(){
			var timedur = $(this)[0].duration;
			var time = Math.floor(timedur/60)+":"+(timedur%60/100).toFixed(2).slice(-2); // 秒转化为 分:秒
		  	$(this).siblings().find('span').html(time);
		});
			
		p.on('click',function(){
			var player = p.find("audio").first()[0];
			if (player.paused){ /*如果已经暂停*/
	            player.play(); /*播放*/
	            	            
	            var timer = setInterval(function(){    //开启定时器 更新时间表
	            	span = p.find('span').first();
	            	var seconds = player.currentTime; // 获取已经播放的时长
	            	var duration = Math.floor(seconds/60)+":"+(seconds%60/100).toFixed(2).slice(-2); // 秒转化为 分:秒
	            	span.html(duration);

			        if (player.paused) {
			        	clearInterval(timer);
			        }
					
			    },1000);

	        }else {
	            player.pause();/*暂停*/
	        }
		});	
	});
});
</script>
</body>