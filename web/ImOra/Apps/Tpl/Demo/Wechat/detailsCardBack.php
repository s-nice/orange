<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<!-- uc强制竖屏 -->
		<meta name="screen-orientation" content="portrait">
		<!-- QQ强制竖屏  -->
		<meta name="x5-orientation" content="portrait">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
		<title>{$info['back']['FN'][0]}</title>
		<link rel="stylesheet" href="__PUBLIC__/css/wePage.css?v={:C('WECHAT_APP_VERSION')}" />
		<link rel="stylesheet" href="__PUBLIC__/css/font-awesome/font-awesome.min.css?v={:C('WECHAT_APP_VERSION')}">
		<script src="__PUBLIC__/js/oradt/H5/fontSize.js?v={:C('WECHAT_APP_VERSION')}?v={:C('WECHAT_APP_VERSION')}"></script>
	</head>
	<script>
	var sysType = '{$sysType}'; //手机系统类型
	</script>
	<body>
		<button type="button" id='upload' style="display: none;">上传图片测试</button>
		<empty name="info">
			<br/>
			<center>当前名片未解析到有效信息</center>
			<!-- .info_img i{position:absolute;right:5%;top:20px;font-size:26px;color:#1AAD19;} -->
		<else/>
			<php>
				$isBack = '';
				if(!empty($info['picpathb'])){
					$isBack = 'hasBackCls';
				}
			</php>
			<section class="card_details">
				<div class="card_img">
					<img src="{$info.picpathb}" alt="" class="js_vcard_img {$isBack}"/>
					<a href="{:U('Wechat/showCardDetail',array('cardid'=>$cardid,'side'=>'back','android'=>$isAndroid,'openid'=>$openid),'',true)}">
						<i class="fa fa-edit" style="position:absolute;right:5%;top:20px;font-size:26px;color:#1AAD19;"></i>
					</a>
				</div>
				<div class="card_detail">
					<ul class="detail_list">
						<!--人名 -->
						<notempty name="info['back']['FN']">						
							<li class="li-per" value="{$info['back']['FN'][0]}">
								<span class="per_icon"></span>
								<p>
									{$info['back']['FN'][0]}
									<notempty name="info['back']['JOB']">
									&nbsp;&nbsp;{$info['back']['JOB'][0]}
									</notempty>
								</p>
								<em class="right_icon"></em>
							</li>						
						</notempty>

						<!--公司 -->
						<php> 
							$i=0;
						</php>
						<foreach name="info['back']['ORG']" item="vo">
							<notempty name="vo">
								<php>if($i<1){</php>								
									<li class="li-company" value="{$vo}">
										<span class="buliding_icon"></span>
										<p>{$vo}&nbsp;&nbsp;</p>
										<em class="right_icon"></em>
									</li>								
								<php>}$i++;</php>
							</notempty>
						</foreach>
						
						<!--地址 -->
						<php> 
					  		$addrListArr = $info['back']['ADR'];
					  		$j=0;
						</php>
						<foreach name="addrListArr" item="vo">
							<notempty name="vo">
								<php>if($j<1){</php>								
									<li id="locationId">
										<span class="map_icon"></span>
										<p class="js_locationname">{$vo}</p>
										<em class="right_icon"></em>
									</li>								
								<php>}$j++;</php>
							</notempty>
						</foreach>
	
						<!--电话 -->
						<php> 
					  		$cellListArr =  $info['back']['CELL'];
						</php>
						<foreach name="cellListArr" item="vo" >
							<notempty name="vo">								
								<li class="li-tel" value="tel:{$vo}">
									<span class="tel_icon"></span>
									<p>{$vo}</p>
									<em class="right_icon"></em>
								</li>								
							</notempty>
						</foreach>

						<!--手机 -->
						<php>  
					   		$tellListArr = $info['back']['TEL'];
						</php>
						<foreach name="tellListArr" item="vo" >
							<notempty name="vo">								
								<li class="li-phone" value="tel:{$vo}">
									<span class="phone_icon"></span>
									<p>{$vo}</p>
									<em class="right_icon"></em>
								</li>								
							</notempty>
						</foreach>

						<!--网址 -->
						<php>
							$urlListArr = $info['back']['URL'];
						</php>
						<foreach name="urlListArr" item="vo" >
							<notempty name="vo">
							<php>if(strpos($vo,'http://')===false && strpos($vo,'https://')===false){</php>								
								<li class="li-url" value="http://{$vo}">
									<span class="intenet_icon"></span>
									<p>{$vo}</p>
									<em class="right_icon"></em>
								</li>								
							<php>}else{</php>								
								<li class="li-url" value="{$vo}">
									<span class="intenet_icon"></span>
									<p>{$vo}</p>
									<em class="right_icon"></em>
								</li>								
							<php>}</php>
							</notempty>
						</foreach>
						
						<!--邮箱 -->
						<php>
							$emailListArr = $info['back']['EMAIL'];
						</php>
						<foreach name="emailListArr" item="vo" >
							<notempty name="vo">
								<li>
									<span class="emali_icon"></span>
									<p>{$vo}</p>
									<em class="right_icon"></em>
								</li>
							</notempty>
						</foreach>
					</ul>
				</div>
			</section>
		</empty>
		<if condition="$isMenu eq '0'">
			<footer class="back_btn">
				<button type="button" id="backId" >返回到列表</button>
			</footer>
		</if>
		<div id="js_load_img" style="display:none;">
			<div class="weui-mask_transparent"></div>
			<div class="weui-toast">
				<i class="weui-icon-success-no-circle weui-icon_toast"></i>
				<p class="weui-toast__content js_tip_text"></p>
			</div>
		</div>
		<input id="openid" name="openid" value="{$openid}" type="hidden"/>
		<input id="cardid" name="cardid" value="{$cardid}" type="hidden"/>

<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}?v={:C('WECHAT_APP_VERSION')}"></script>
<script type="text/javascript" src='http://res.wx.qq.com/open/js/jweixin-1.2.0.js?v={:C('WECHAT_APP_VERSION')}'></script>	
<script src="__PUBLIC__/js/oradt/voicedemo.js?v={:C('WECHAT_APP_VERSION')}?v={:C('WECHAT_APP_VERSION')}"></script>
<script type="text/javascript">
var gGetLocationUrl = "{:U(MODULE_NAME.'/Wechat/getLocation','','',true)}";
var gVcardListUrl = "{:U(MODULE_NAME.'/Wechat/wListZp',array('keyword'=>$kwd,'openid'=>$openid,'android'=>$isAndroid),'',true)}";
var gVcardDetailBackUrl = "{:U(MODULE_NAME.'/Wechat/wDetailZp',array('keyword'=>$kwd,'cardid'=>$cardid,'openid'=>$openid,'android'=>$isAndroid),'',true)}"; //名片反面url
var urlSource = "{$urlSource}"; //url来源
var isAndroid = "{$isAndroid}"; //是否来源于android扫描仪
$(function(){
	$('#backId').click(function(){
		if(isAndroid == '1'){
			location.href=gVcardListUrl;
		}else{
			if(urlSource == ''){
				location.href=gVcardListUrl;
			}else{
				window.history.go(-1);
			}
		}
		return false;
	});
	
});
if(!isAndroid){
	wx.config({
	    debug: false, 
	    appId: "{$signPackage['appId']}", 
	    timestamp: "{$signPackage['timestamp']}", 
	    nonceStr: "{$signPackage['nonceStr']}",
	    signature: "{$signPackage['signature']}",
	    jsApiList: ['chooseImage', 'uploadImage','stopRecord','pauseVoice','onVoicePlayEnd','onVoiceRecordEnd','playVoice','translateVoice','checkJsApi','openLocation','getLocation']
	}); 
}

document.getElementById('upload').addEventListener("click", function () {
	wx.chooseImage({
        count: 1, // 默认9
        sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
        sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
        success: function (res) {
            var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
            wx.uploadImage({
                localId: localIds[0], // 需要上传的图片的本地ID，由chooseImage接口获得
                isShowProgressTips: 1, // 默认为1，显示进度提示
                success: function (res) {
                    var serverId = res.serverId; // 返回图片的服务器端ID
                    document.getElementById('search').value=serverId;
                }
            });
        }
	});
}, true);


$(function(){
	$('#locationId').click(function(){
		var addressOld = $(this).find('.js_locationname').first().html();
		if(addressOld.length>58){
			address = addressOld.substr(0,58);
		}else{
			address = addressOld;
		}
		
		$.get(gGetLocationUrl,{address:encodeURIComponent(address)},function(rst){
			getLocInfo(rst,addressOld);
		},'json');
	});
});

function getLocInfo(obj,address){
	if(obj.status==0){
		var latitude = obj.result.location.lat;
		var longitude = obj.result.location.lng;
		showMap(latitude,longitude,address)
	}else{
		alert('无相关地图');
	}
}
var mapScale = 14;
    if(sysType == 'android'){
         mapScale = 15;
    }
function showMap(latitude,longitude,address){
	wx.openLocation({
	    latitude: latitude, // 纬度，浮点数，范围为90 ~ -90
	    longitude: longitude, // 经度，浮点数，范围为180 ~ -180。
	    name: address, // 位置名
	    address: address, // 地址详情说明
	    scale:mapScale, // 地图缩放级别,整形值,范围从1~28。默认为最大
	    infoUrl: '' // 在查看位置界面底部显示的超链接,可点击跳转
	});
}
//判断名片反面
$('.js_vcard_img').click(function(){
	if($(this).hasClass('hasBackCls')){
		window.location.href = gVcardDetailBackUrl;
	}else{
		// $('.js_tip_text').html('抱歉，此名片没有反面相关信息');
		// $('#js_load_img').show();
		// setTimeout(function(){
		// 	$('#js_load_img').hide();
		// },1500);
	}	
});
$("ul.detail_list li").click(function(){
	var liclass = $(this).attr("class");
	var liurl = getHref($(this), liclass);
	if (liurl !== false) {
		window.location.href = liurl;
	}
});
function getHref(obj,classname){
	switch(classname){
		case 'li-per':
			return "{:U('wechat/personInfo',array('cardid'=>$cardid,'name'=>"+obj.attr('value')+"),'',true)}";
		case 'li-company':
			return "{:U(MODULE_NAME.'/Wechat/companyComfirm',array('name'=>"+obj.attr('value')+",'cardid'=>$cardid,'android'=>"+isAndroid+"),'',true)}";
		case 'li-tel':
			return obj.attr('value');
		case 'li-phone':
			return obj.attr('value');
		case 'li-url':
			return obj.attr('value');	
		default:
			return false;		
	}
}
</script>
	</body>
</html>