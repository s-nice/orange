<layout name="../Layout/H5CompanyIntroLayout" />
<script type="text/javascript" src="__PUBLIC__/js/jquery/mobile.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/ueditor/ueditor.parse.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/lazyload.js"></script>
<style>
ol li{margin-left: 1rem;color:#ccc;font-size: 0.6rem;}
ul li{margin-left: 1rem;color:#ccc;font-size: 0.6rem;}
strong,b{font-weight:bold;}
strong > span{font-weight:bold;}
</style>
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
        </if>
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
		} else if ($(this).is('video')) { // 视频全部宽屏展示
			var pwidth = parseInt($(this).closest("p").width());
			$(this).attr('width', pwidth+'px');
		}
	}
});
$(function(){
	// 图片延迟加载
	$("div.news_content_c p").find("img").lazyload({
		threshold:200,
		load:function(){ // 350像素以上宽屏展示
			if (this.width > 350) { // 大图和video做适应设备屏幕的显示
				var pwidth = parseInt($(this).closest("p").width());
				var pheight = parseInt($(this).closest("p").height());
				$(this).attr('width', pwidth+'px');
				$(this).attr('height', (pwidth*this.height/this.width)+'px');
			} else { // 小图照原样显示
				$(this).attr('width', (this.width*window.devicePixelRatio)+'px');
				$(this).attr('height', (this.height*window.devicePixelRatio)+'px');
			}
		}
	});
	var nav_height=$(".load_text").height();
	var if_height=nav_height/2;
	$('#js_new_open').on('click',function(){
		window.location.href = "{: U('h5/imora/download','','',true)}";
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
    //点击图片显示大图
	$(".js_show_img>p img").each(function(){
		if ($(this).hasClass('audio_img')) { return true; } // 音频的标签图片排除掉
		var tempObj = $(this);
		var src = tempObj.attr('src');
		var domObj = tempObj[0];
		touchEvent.tap(domObj,function(){
			var imgUrl=src;
	    	$(".js_img_box").css("display","block");
	    	$(".js_img_box>img").attr("src",imgUrl);
	    	$(".js_img_box>img").addClass("zoomIn");
		});
	});
	$(".js_img_box").each(function(){
		var tempObj = $(this);
		var domObj = tempObj[0];
		touchEvent.tap(domObj,function(){
			tempObj.css("display","none");
	    	$(".js_img_box>img").removeClass("zoomIn");
		});
	});
	uParse('#ueditorcontent', { rootPath: '__PUBLIC__/js/jsExtend/ueditor' });

	// audio标签替换
	$('audio').each(function(){
		$(this).css({"display":"none"});
		var p = $(this).closest('p');
		p.css({"width":"100%","height":"1.2rem","background-color":"#FFFFFF","text-align":"center","color":"#5D5D5D","margin":"0.4rem 0"});
		html = '<span>'+'00:00'+'</span><img src="__PUBLIC__/images/ic_show_sonic.png" style="width:1.2rem;height:1.2rem" class="audio_img">';
		$(this).after(html);

		$(this)[0].addEventListener("canplay", function(){
			var timedur = $(this)[0].duration;
			var time = Math.floor(timedur/60)+":"+(timedur%60/100).toFixed(2).slice(-2); // 秒转化为 分:秒
		  	$(this).siblings('span').html(time);
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

// 替换后的元素的子元素里面跟随父元素的样式
$(".small,.normal,.big,.bigger").children().each(function(){
	$(this).css('font-size', '');
	$(this).css('font-family', '');
	$(this).css('line-height', '');
});
</script>