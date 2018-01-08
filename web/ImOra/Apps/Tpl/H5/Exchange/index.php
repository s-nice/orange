<layout name="../Layout/H5Layout720" />
<style>
	@media only screen and (device-width: 375px) and (device-height:812px) and (-webkit-device-pixel-ratio:3) {
	    .pull_box{
	    	padding-bottom:.3rem;
	    }
	    .foot{
	    	height:1.35rem;
	    	background:#1d212c;
	    }
	}
</style>
<if condition="$device eq 'pcCard'">
<div style="width:414px;height:100%;background: #1d212c;margin:0 auto;overflow: auto;">
</if>
<section class="content">
	<div class="card_img swiper-container">
		<div class="swiper-wrapper" ondragstart="return false;">
		<if condition="$vcardInfo['cardtype'] != 'scan' && !empty($vcardInfo['picture'])" >
			<div class="swiper-slide">
				<!-- 如果是本地处理后的图片则从本地调取 -->
				<if condition="strpos($vcardInfo['picture'],'temp') !== false">
				<img class="js_cardImg" src="__PUBLIC__/{$vcardInfo['picture']}" alt="{: isset($vcardInfo['FN'])?$vcardInfo['FN']:$T->h5_undefined}"/>
				<else/>
				<img class="js_cardImg" src="{$vcardInfo['picture']}" alt="{: isset($vcardInfo['FN'])?$vcardInfo['FN']:$T->h5_undefined}"/>
				</if>
			</div>
		</if>
		<if condition="$vcardInfo['cardtype'] != 'custom' && !empty($vcardInfo['picturea'])" >
			<div class="swiper-slide">
				<!-- 如果是本地处理后的图片则从本地调取 -->
				<if condition="strpos($vcardInfo['picturea'],'temp') !== false">
				<img class="js_cardImg" src="__PUBLIC__/{$vcardInfo['picturea']}" alt="{: isset($vcardInfo['FN'])?$vcardInfo['FN']:$T->h5_undefined}"/>
				<else/>
				<img class="js_cardImg" src="{$vcardInfo['picturea']}" alt="{: isset($vcardInfo['FN'])?$vcardInfo['FN']:$T->h5_undefined}"/>
				</if>
			</div>
		</if>
		<if condition="$vcardInfo['cardtype'] != 'custom' && !empty($vcardInfo['pictureb'])" >
			<div class="swiper-slide">
				<!-- 如果是本地处理后的图片则从本地调取 -->
				<if condition="strpos($vcardInfo['pictureb'],'temp') !== false">
				<img class="js_cardImg" src="__PUBLIC__/{$vcardInfo['pictureb']}" alt="{: isset($vcardInfo['FN'])?$vcardInfo['FN']:$T->h5_undefined}"/>
				<else/>
				<img class="js_cardImg" src="{$vcardInfo['pictureb']}" alt="{: isset($vcardInfo['FN'])?$vcardInfo['FN']:$T->h5_undefined}"/>
				</if>
			</div>
		</if>
		</div>
		<!-- 分页器展示样式 -->
		<div class="swiper-pagination"></div>
	</div>
	<php>$showname = ($vcardInfo['FN'] != '')?$vcardInfo['FN']:$vcardInfo['cardInfoFront']['name'][0]['value'];</php>
	<div class="num_a_email box_radius top_name">
		<div class="title_icon">
			<div class="img_icon_t">
				<if condition = "empty($vcardInfo['avatar'])">
					<!-- <img src="__PUBLIC__/images/default/avatar_user_chat.png" /> -->
					<em class="name-first"><?php echo mb_substr($showname,0,1,'utf-8');?></em>
				<else/>
					<img src="{$vcardInfo['avatar']}" />
				</if>
			</div>
			<div class="name_tit name_top">
				<p class="en_name"><span id="js_coount_name">{$showname}</span></p>
				<p class="en_con"><span>{$vcardInfo['signature']}</span></p>
			</div>
	  	</div>
	</div>
	<!--个人主页-->
	<notempty name="contents">
	<div class="ge-zhu" onclick="window.open('{:U('H5/Exchange/getPersonalHomepage','',false)}?cardId={$vcardInfo['vcardid']}', '_blank')">
		<div class="zhu-title">
			<h4>个人主页</h4>
			<span></span>
		</div>
		<div class="zhu-content" style="overflow: hidden;">
			<foreach name="contents" item="content">
			<div class="homepage-content" wid = "{$content['width']}" hgt="{$content['height']}" style="float: left;">
			<if condition="$content['type'] eq 0">
				{$content['content']}
			<elseif condition="$content['type'] eq 1"/>
				<img src="{$content['respath']}" alt="" width="100%" height="100%">
			<elseif condition="$content['type'] eq 2"/>
				<video src="{$content['respath']}"  width="100%" controls="controls">您的浏览器不支持该视频。</video>
			</if>
			</div>
			</foreach>
		</div>
	</div>
	</notempty>
  	<div class="num_a_email box_radius js_phone_div">
  		<foreach name="vcardInfo['cardInfoFront']['mobile']" key="k" item="c">
            <div class="i_phone">
            <if condition="$k eq 0">
			<div class="img_icon_t"><span></span></div>
			<else/>
			<div style="width:1.21rem;height:0.82rem;position:relative;"><span></span></div>
			</if>
			<div class="phone_num bottom_solid">
				<p>
					<if condition="$device eq 'pcCard'">
					<a><span>{$vcardInfo['cardInfoFront']['mobile'][$k]['value']}</span></a>
                    <notempty name="vcardInfo['cardInfoFront']['mobile'][$k]['title_self_def']"><em>{$vcardInfo['cardInfoFront']['mobile'][$k]['title']}</em></notempty>
					<else/>
					<a  href="tel:{$vcardInfo['cardInfoFront']['mobile'][$k]['value']}"><span>{$vcardInfo['cardInfoFront']['mobile'][$k]['value']}</span></a>
                    <notempty name="vcardInfo['cardInfoFront']['mobile'][$k]['title_self_def']"><em>{$vcardInfo['cardInfoFront']['mobile'][$k]['title']}</em></notempty>
                    <a href="sms:{$vcardInfo['cardInfoFront']['mobile'][$k]['value']}"><i>发短信</i></a>
					</if>
                </p>	
			</div>
			</div>
		</foreach>
		
		<foreach name="vcardInfo['cardInfoFront']['email']" key="k" item="c">
		<div class="i_phone">
			<if condition="$k eq 0">
			<div class="img_icon_t"><span class="email_icon"></span></div>
			<else/>
			<div style="width:1.21rem;height:0.82rem;position:relative;"><span></span></div>
			</if>
			<div class="phone_num">				
				<p><span>{$vcardInfo['cardInfoFront']['email'][$k]['value']}</span>
				<if condition="$device eq 'pcCard'">
				<notempty name="vcardInfo['cardInfoFront']['email'][$k]['title_self_def']"><em>{$vcardInfo['cardInfoFront']['email'][$k]['title']}</em></notempty>
				<else/>
				<notempty name="vcardInfo['cardInfoFront']['email'][$k]['title_self_def']"><em>{$vcardInfo['cardInfoFront']['email'][$k]['title']}</em></notempty>
                    <a href="mailto:{$vcardInfo['cardInfoFront']['email'][$k]['value']}"><i>发邮件</i></a>
				</if>    
                </p>				
			</div>
		</div>
		</foreach>
	</div>
	
	<foreach name="vcardInfo['cardInfoFront']['company']" key="k" item="c">
	<div class="num_a_email box_radius js_phone_div1">
		
		<!-- 公司名称 -->
		<foreach name="vcardInfo['cardInfoFront']['company'][$k]['company_name']" key="m" item="n">
        <if condition="count($vcardInfo['cardInfoFront']['company'][$k]['company_name']) eq ($m+1)">
		<div class="title_icon title_border">
		<else/>
		<div class="title_icon">
		</if>
            <h5>{$vcardInfo['cardInfoFront']['company'][$k]['company_name'][$m]['value']}</h5>
        </div>
        </foreach>

        <!-- 公司部门和职位 -->
		<if condition="isset($vcardInfo['cardInfoFront']['company'][$k]['department']) || isset($vcardInfo['cardInfoFront']['company'][$k]['job'])">
            <!-- 选取部门和职位中长度长的循环 -->
            <?php 
            	if(count($vcardInfo['cardInfoFront']['company'][$k]['department']) > count($vcardInfo['cardInfoFront']['company'][$k]['job'])){
            		$departjob = 'department';
            	} else {
            		$departjob = 'job';
            	}
            ?>
			<foreach name="vcardInfo['cardInfoFront']['company'][$k][$departjob]" key="m" item="n">
            <div class="title_icon clear">
            <!-- 只第一个显示图标 -->
            <if condition="$m eq 0">
			<div class="img_icon_t"><span class="buliding_icon"></span></div>
			<else/>
			<div class="img_icon_t"><span style="background:none"></span></div>
			</if>
			<!-- 相同行之间没有下划线 -->
			<if condition="count($vcardInfo['cardInfoFront']['company'][$k][$departjob]) eq ($m+1)">
			<div class="name_tit bottom_solid">
			<else/>
			<div class="name_tit bottom_solid" style="border-bottom:0px solid #eee;">
			</if>
				<if condition="isset($vcardInfo['cardInfoFront']['company'][$k]['department'][$m]['value'])">
				
				<p><span>{$vcardInfo['cardInfoFront']['company'][$k]['department'][$m]['value']}</span></p>
				</if>
				<if condition="isset($vcardInfo['cardInfoFront']['company'][$k]['job'][$m]['value'])">
				
				<p><span>{$vcardInfo['cardInfoFront']['company'][$k]['job'][$m]['value']}</span></p>
				</if>
			</div>
	  		</div>

	  		</foreach>
	  	</if>
		
		<!-- 公司电话 -->
	  	<if condition="isset($vcardInfo['cardInfoFront']['company'][$k]['telephone']) && $vcardInfo['cardInfoFront']['company'][$k]['telephone'][0]['value'] != '' ">
	  	<foreach name="vcardInfo['cardInfoFront']['company'][$k]['telephone']" key="m" item="n">
	  	<div class="title_icon clear">
	  		<if condition="$m eq 0">
			<div class="img_icon_t"><span class="phones_icon"></span></div>
			<else/>
			<div class="img_icon_t"><span style="background:none"></span></div>
			</if>
			
			<if condition="count($vcardInfo['cardInfoFront']['company'][$k]['telephone']) eq ($m+1)">
			<div class="name_tit bottom_solid">
			<else/>
			<div class="name_tit bottom_solid" style="border-bottom:0px solid #eee;">
			</if>

			<if condition="$device eq 'pcCard'">
			<a href=""><p><span>{$vcardInfo['cardInfoFront']['company'][$k]['telephone'][$m]['value']}</span></p></a>
			<else/>
			<a href="tel:{$vcardInfo['cardInfoFront']['company'][$k]['telephone'][0]['value']}"><p><span>{$vcardInfo['cardInfoFront']['company'][$k]['telephone'][$m]['value']}</span></p></a>
			</if>
			</div>
	  	</div>
	  	</foreach>
	  	</if>
		
		<!-- 公司传真 -->
	  	<foreach name="vcardInfo['cardInfoFront']['company'][$k]['fax']" key="m" item="n">
	  	<div class="title_icon clear">
	  		<if condition="$m eq 0">
			<div class="img_icon_t"><span class="com_icon"></span></div>
			<else/>
			<div class="img_icon_t"><span style="background:none"></span></div>
			</if>

			<if condition="count($vcardInfo['cardInfoFront']['company'][$k]['fax']) eq ($m+1)">
			<div class="name_tit bottom_solid">
			<else/>
			<div class="name_tit bottom_solid" style="border-bottom:0px solid #eee;">
			</if>
				<p><span>{$vcardInfo['cardInfoFront']['company'][$k]['fax'][$m]['value']}</span></p>
			</div>
	  	</div>
	  	</foreach>
		
		<!-- 公司邮箱 -->
	  	<foreach name="vcardInfo['cardInfoFront']['company'][$k]['email']" key="m" item="n">
	  	<div class="title_icon clear">
	  		<if condition="$m eq 0">
			<div class="img_icon_t"><span class="email_icon"></span></div>
			<else/>
			<div class="img_icon_t"><span style="background:none"></span></div>
			</if>

			<if condition="count($vcardInfo['cardInfoFront']['company'][$k]['email']) eq ($m+1)">
			<div class="name_tit bottom_solid">
			<else/>
			<div class="name_tit bottom_solid" style="border-bottom:0px solid #eee;">
			</if>

				<if condition="$device eq 'pcCard'">
				<p><span>{$vcardInfo['cardInfoFront']['company'][$k]['email'][$m]['value']}</span></p>
				<else/>
				<p><span><a style="color: #d3d4d6;" href="mailto:{$vcardInfo['cardInfoFront']['company'][$k]['email'][$m]['value']}">{$vcardInfo['cardInfoFront']['company'][$k]['email'][$m]['value']}</a></span></p>
				</if>
				
			</div>
	  	</div>
	  	</foreach>

	  	<!-- 公司地址 -->
	  	<foreach name="vcardInfo['cardInfoFront']['company'][$k]['address']" key="m" item="n">
	  	<div class="title_icon clear">
	  		<if condition="$m eq 0">
			<div class="img_icon_t"><span class="map_icon"></span></div>
			<else/>
			<div class="img_icon_t"><span style="background:none"></span></div>
			</if>

			<if condition="count($vcardInfo['cardInfoFront']['company'][$k]['address']) eq ($m+1)">
			<div class="name_tit bottom_solid">
			<else/>
			<div class="name_tit bottom_solid" style="border-bottom:0px solid #eee;">
			</if>
			<if condition="$device eq 'pcCard'">
			<a  href=""><p>{$vcardInfo['cardInfoFront']['company'][$k]['address'][$m]['value']}</p></a>
			<else/>
			<a  href="{:U('H5/News/map')}?address={$data['content']['baseInfo']['regLocation']}"><p>{$vcardInfo['cardInfoFront']['company'][$k]['address'][$m]['value']}</p></a>
			</if>
			</div>
	  	</div>
	  	</foreach>

	  	<!-- 公司网址 -->
	  	<foreach name="vcardInfo['cardInfoFront']['company'][$k]['web']" key="m" item="n">
	  	<div class="title_icon clear">
	  		<if condition="$m eq 0">
			<div class="img_icon_t"><span class="location_icon"></span></div>
			<else/>
			<div class="img_icon_t"><span style="background:none"></span></div>
			</if>

			<if condition="count($vcardInfo['cardInfoFront']['company'][$k]['web']) eq ($m+1)">
			<div class="name_tit bottom_solid">
			<else/>
			<div class="name_tit bottom_solid" style="border-bottom:0px solid #eee;">
			</if>
			<if condition="$device eq 'pcCard'">
			<a  href=""><p><span>{$vcardInfo['cardInfoFront']['company'][$k]['web'][$m]['value']}</span></p></a>
			<else/>
			<a  href="http://{$vcardInfo['cardInfoFront']['company'][$k]['web'][0]['value']}"><p><span>{$vcardInfo['cardInfoFront']['company'][$k]['web'][$m]['value']}</span></p></a>
			</if>	
			</div>
	  	</div>
	  	</foreach>
	  	
	</div>
	</foreach>
</section>
<footer class="pull_box"></footer>
<footer class="foot">
<div class="load_btn">
	<if condition="$device eq 'pcCard'">
	<a class="a_bin" href="http://qr28.cn/E87vfT">下载橙脉APP</a>
	<else/>
	<a class="a_bin" id="js_download_openapp">保存至橙脉</a>
	</if>
	<div class="line_solid"></div>
	<a class="js_showVcardQrcode">保存至通讯录</a>
</div>
</footer>
<div class="js_show_code show_code">
	<div class="code_null"></div>
	<div class="tow_code">
		<div class="code_bg">
			<img id="js_showVcardImg" src="{:U('h5/exchange/qrcode',array('fid'=>$vcardInfo['vcardid']),'',true)}" alt="">
		</div>
		<p>
			<if condition="$device eq 'pcCard'">
			<span>请使用手机微信扫描二维码</span>
			<else/>
			<span>长按识别二维码，保存至手机通讯录</span>
			</if>
		</p>
		<div class="js_close colse_code">
			<img src="__PUBLIC__/images/w_colse.png">
		</div>
	</div>
</div>
<div class="js_show_img show_code">
	<!-- 如果是本地处理后的图片则从本地调取 -->
	<if condition="strpos($vcardInfo['picturea'],'temp') !== false">
	<img class="js_big_imgs" id="js_big_imgs" src="__PUBLIC__/{$vcardInfo['picturea']}" alt="{: isset($vcardInfo['cardInfo']['name'])?$vcardInfo['cardInfo']['name']:$T->h5_undefined}"/>
	<else/>
	<img class="js_big_imgs" id="js_big_imgs" src="{$vcardInfo['picturea']}" alt="{: isset($vcardInfo['cardInfo']['name'])?$vcardInfo['cardInfo']['name']:$T->h5_undefined}"/>
	</if>
	<div class="js_child show_img_bg"></div>
</div>
<div class="js_no_weui big_no_weui">
	<div class="no_weui">
		<div class="three_btns">
			<div class="hint_btn">下载提示</div>
			<div class="hint_btn hint_border">{$showname|substrtext=8}的名片.vcf</div>
			<a class="js_no_weui" href="{:U('h5/exchange/downloadFile',array('fid'=>$vcardInfo['vcardid'],'name'=>$showname,),'',true)}"><div class="hint_btn">立即下载</div></a>
		</div>
		<div class="three_btns three_bot">
			<div class="js_close_no_weui hint_btn">取消</div>
		</div>
	</div>
</div>
<div class="js_open_page open_page" style="display:none;">
	<img src="__PUBLIC__/images/enjoy_text.png">
</div>
<if condition="$device eq 'pcCard'">
</div>
</if>
<php>
//扫描二维码和摇一摇功能
if(isset($params['qmodule']) && in_array($params['qmodule'],array('qrscan','ibeacon'))){
	$actiontype = 'addfriends';
}else if(isset($params['self']) && $params['self']==1){ //分享自己的名片
	$actiontype = 'addfriends';
}else if(isset($params['self']) && $params['self']==0){
	$actiontype = 'savecard';
}else{
	$actiontype = '';
}
</php>
<script type="text/javascript">
var isselfshare = "{$params['self']}";
var appVcardId = "{$vcardInfo['vcardid']}";
var appFromVcard = "{: isset($params['qmodule'])?$params['qmodule']:''}";
/* var actiontype = "{: (isset($params['qmodule'])&& !empty($params['qmodule']))?'addfriends':''}";
if(actiontype=='') {
    if(isselfshare==1){
        actiontype='addfriends';
    }else{
        actiontype='savecard';
    }
} */
//var actiontype = "{: (isset($params['self']) && $params['self']==1)?'addfriends':'savecard'}";
var actiontype = "{$actiontype}";
</script>
<include file="Imora/_weixinIf" />
<script type="text/javascript" src="__PUBLIC__/js/jquery/swiper.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery/jQueryRotate.js"></script>

<script type="text/javascript">
//单击展示大图
$('.js_cardImg').on('click',function(){
    var widthscreen = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
    var heightscreen = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
    var marginlength = (heightscreen-widthscreen)/2;
    $('#js_big_imgs').rotate(90);
    $('#js_big_imgs').css('width',heightscreen+'px');
    $('#js_big_imgs').css('height',widthscreen+'px');
    $('#js_big_imgs').css('margin-top',marginlength+'px');
    $('#js_big_imgs').css('margin-left',-marginlength+'px');
    $('.js_show_img').show();
    $('#js_big_imgs').attr('src',$(this).attr('src')).show();
    $('html').css('overflow',"hidden");
});
$('.js_child,.js_show_img').on('click',function(){
	$(".js_show_img").hide();
	$('html').css('overflow',"auto");
});

/**
 * 轮播效果js
 */ 
var mySwiper = new Swiper ('.swiper-container', {
	direction: 'horizontal',
	pagination: '.swiper-pagination',
});

	// 二维码弹出框
	$('.js_showVcardQrcode').on('click',function(){
		if(isWeiXin()){
			$('.js_show_code').show();
			$('html').css('overflow',"hidden");
			return;
		}else if(isWeiBo()){
			$('.js_open_page').show();
			return;
		} else {
			$('.js_no_weui').show();
			$('html').css('overflow',"hidden");
		}
		
	});
	// 关系二维码|下载vcf层
	$('.js_close,.js_close_no_weui').on('click',function(){
		$('.js_show_code,.js_no_weui').hide();
		$('html').css('overflow',"auto");
	});

	// 电脑端展示样式
	function pcCardStyle(){
		$("html").first().css({"font-size":'50px',"background":"#fff"});
		$("body").first().css({"background":"#fff"});
		$("footer.foot").first().css({"position":"static"});
		$(".big_no_weui").first().css({"width":"414px","left":"auto"});
		$('.js_open_page').first().css({"width":"414px","left":"auto"});
		$('.js_cardImg').unbind('click'); //pc端去掉大图展示功能
		$(".swiper-pagination-bullet").css({"width":"0.1rem","height":"0.1rem"}); // 轮播图分页器显示样式大小

		// 适配火狐浏览器
		$("body").css('display',"-webkit-box");
		$(".load_btn").css('display',"-webkit-box");
		$(".js_cardImg").css("width","414px");

		// 微信浏览器两个保存功能都提示跳转
		if (isWeiXin()) {
			$(".js_show_code").css({"width":"414px","left":"auto"});
		}
	}
	// 个人主页样式适配
	$(".homepage-content").each(function(){
		var initWidth = parseInt(parseInt($(this).closest(".zhu-content").css("width"))/2);
		var width = (parseInt($(this).attr('wid'))*initWidth)+'px';
		var height = (parseInt($(this).attr('hgt'))*initWidth)+'px';
		$(this).css('width',width);
		$(this).css('height',height);
	})
    </script>
