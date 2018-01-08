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
	<link rel="stylesheet" href="__PUBLIC__/css/font-awesome/font-awesome.min.css?v={:C('WECHAT_APP_VERSION')}">
	<link rel="stylesheet" href="__PUBLIC__/css/weui.min.css?v={:C('WECHAT_APP_VERSION')}">
	<link rel="stylesheet" href="__PUBLIC__/css/wList.css?v={:C('WECHAT_APP_VERSION')}">
</head>
	<script>
	var sysType = '{$sysType}'; //手机系统类型
	</script>
<body>
    <button type="button" id='upload' style="display: none;">上传图片测试</button>
	<div class="warmp">
		<div class="content_info">
		<empty name="info">
			<br/>
			<center>当前名片未解析到有效信息</center>
		<else/>
			<div class="info_img"><img src="{$info.picpathb}" class="js_vcard_img"><a href="{:U('wechat/showCardDetail',array('cardid'=>$cardid,'side'=>'back','android'=>$isAndroid),'',true)}"><i class="fa fa-edit"></i></a></div>
	    
			<div class="weui-cells" style="margin-top:0;">
<!--人名 -->
			<notempty name="info['back']['FN']">
				 <a class="weui-cell weui-cell_access" href="{:U('wechat/personInfo',array('cardid'=>$cardid,'name'=>$nameArr[0]),'',true)}"> 
				<!--<a class="weui-cell weui-cell_access" href="https://www.baidu.com/s?wd={:urlencode($nameArr[0])}">-->
					<div class="weui-cell__hd">
						<span class="weui-cell__hd span_w fa fa-user"></span>
					</div>
					<div class="weui-cell__bd">
						<p>
				{$info['back']['FN'][0]}
				<notempty name="info['back']['JOB']">
				&nbsp;&nbsp;{$info['back']['JOB'][0]}
				</notempty>
				</p>
					</div>
					<div class="weui-cell__ft"></div>
				</a>
			</notempty>
<!--公司 -->
				<php> 
				$i=0;
				</php>
				<foreach name="info['back']['ORG']" item="vo">
					<notempty name="vo">
					<php>if($i<1){</php>
				<a class="weui-cell weui-cell_access" href="{:U(MODULE_NAME.'/Wechat/companyRedirect',array('name'=>$vo,'cardid'=>$cardid),'',true)}">
					<div class="weui-cell__hd">
						<span class="weui-cell__hd fa fa-building"></span>
					</div>

					<div class="weui-cell__bd">
						<p>{$vo}&nbsp;&nbsp;</p>
					</div>
					<div class="weui-cell__ft"></div>
				</a>
				<php>}
				$i++;</php>
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
				<a class="weui-cell weui-cell_access" id="locationId">
					<div class="weui-cell__hd">
						<span class="weui-cell__hd span_w fa fa-map-marker" style="font-size:22px;"></span>
					</div>
					<div class="weui-cell__bd js_locationname">
						<p>{$vo}</p>
					</div>
					<div class="weui-cell__ft"></div>
				</a>
				<php>}
				$j++;</php>
				</notempty>
				</foreach>
<!--电话 -->
				<php> 
					  $cellListArr =  $info['back']['CELL'];
				</php>
				<foreach name="cellListArr" item="vo" >
					<notempty name="vo">
				<a class="weui-cell weui-cell_access" href="tel:{$vo}">
					<div class="weui-cell__hd">
						<span class="weui-cell__hd fa fa-phone-square"></span>
					</div>
					<div class="weui-cell__bd">
						<p>{$vo}</p>
					</div>
					<div class="weui-cell__ft"></div>
				</a>
					</notempty>
				</foreach>
<!--手机 -->
				<php>  
					   $tellListArr = $info['back']['TEL'];
				</php>
				<foreach name="tellListArr" item="vo" >
					<notempty name="vo">
				<a class="weui-cell weui-cell_access" href="tel:{$vo}">
					<div class="weui-cell__hd">
						<span class="weui-cell__hd fa fa-mobile-phone" style="font-size:26px;"></span>
					</div>
					<div class="weui-cell__bd">
						<p>{$vo}</p>
					</div>
					<div class="weui-cell__ft"></div>
				</a>
					</notempty>
				</foreach>
<!--网址 -->
				<php> 
					//$emailListArr =  $info['back']['EMAIL'];
				</php>
				<php>  //$urlList = $info['URL'];
						$urlListArr = $info['back']['URL'];
				</php>
				<foreach name="urlListArr" item="vo" >
					<notempty name="vo">
						<php>if(strpos($vo,'http://')===false && strpos($vo,'https://')===false){</php>
				<a class="weui-cell weui-cell_access" href="http://{$vo}">
					<div class="weui-cell__hd">
						<span class="weui-cell__hd fa fa-television" style="font-size:14px;"></span>
					</div>
					<div class="weui-cell__bd">
						<p>{$vo}</p>
					</div>
					<div class="weui-cell__ft"></div>
				</a>
				<php>}else{</php>
				<a class="weui-cell weui-cell_access" href="{$vo}">
					<div class="weui-cell__hd">
						<span class="weui-cell__hd fa fa-television" style="font-size:14px;"></span>
					</div>
					<div class="weui-cell__bd">
						<p>{$vo}</p>
					</div>
					<div class="weui-cell__ft"></div>
				</a>
				<php>}</php>
					</notempty>
				</foreach>
			</div>
			<!-- <a class="weui-btn weui-btn_primary" href="{:U('wechat/relationChat',array('cardid'=>$cardid),'',true)}">人脉关系图</a> -->
			</empty>
			 <!-- 
			<div class="weui-cells">
				<a href="{:U('wechat/relationChat',array('cardid'=>$cardid),'',true)}" class="weui-cell weui-cell_access">
					<div class="weui-cell__hd">
						<span class="weui-cell__hd fa fa-object-ungroup" style="font-size:13px;"></span>
					</div>
					<div class="weui-cell__bd">
						<p>人脉图谱(测试中)</p>
					</div>
					<div class="weui-cell__ft"></div>
				</a>
			</div>
			 -->
		</div>
	<if condition="$isMenu eq '0'">
	<a style="margin:15px 0;" href="javascript:void(0);" id="backId" class="weui-btn weui-btn_primary">返回到列表</a>
	</if>
	</div>
	<input id="openid" name="openid" value="{$openid}" type="hidden"/>
	<input id="cardid" name="cardid" value="{$cardid}" type="hidden"/>
	
	<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}"></script>
	<!--  -->
<script type="text/javascript" src='http://res.wx.qq.com/open/js/jweixin-1.2.0.js?v={:C('WECHAT_APP_VERSION')}'></script>	
<script src="__PUBLIC__/js/oradt/voicedemo.js?v={:C('WECHAT_APP_VERSION')}"></script>

<script type="text/javascript">
var gGetLocationUrl = "{:U(MODULE_NAME.'/Wechat/getLocation','','',true)}";
var gVcardListUrl = "{:U(MODULE_NAME.'/Wechat/wListZp',array('keyword'=>$kwd,'android'=>$isAndroid),'',true)}";
var gVcardDetailUrl = "{:U(MODULE_NAME.'/Wechat/wDetailZp',array('keyword'=>$kwd,'cardid'=>$cardid,'openid'=>$openid,'android'=>$isAndroid),'',true)}"; //名片反面url
var urlSource = "{$urlSource}"; //url来源
var isAndroid = "{$isAndroid}"; //是否来源于android扫描仪
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
		var addressOld = $(this).find('.js_locationname p').html();
		if(addressOld.length>58){
			address = addressOld.substr(0,58);
		}else{
			address = addressOld;
		}
		//var url = 'http://api.map.baidu.com/geocoder/v2/?address='+address+'&output=json&ak=GNMfmaHWOLrt5HMqz4ofS1t1&callback=getLocInfo';
/* 		var url = 'http://api.map.baidu.com/geocoder/v2/';
		var data = {address:address,output:'json',ak:'GNMfmaHWOLrt5HMqz4ofS1t1',callback:'getLocInfo'};
		$.get(url,data,function(rst){
			alert('test')
			var len = rst.length
			//getLocInfo(rst,address);
		},'jsonp'); */

		
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
	window.location.href = gVcardDetailUrl;
});
</script>
<!--  -->

</body>
</html>