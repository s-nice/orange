<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>门店</title>
	<link rel="stylesheet" href="__PUBLIC__/css/weDialog.min.css?v={:C('WECHAT_APP_VERSION')}">
	<link rel="stylesheet" href="__PUBLIC__/css/weui.min.css?v={:C('WECHAT_APP_VERSION')}">
	<style>
		html,body{
			background:#f8f8f8;
		}
		.phone_main{
			width:100%;
			padding-bottom:20px;
		}
		.weui-vcode-btn{
			width:110px;
		}
	</style>
</head>
<body>
	<section class="phone_main">
		<!--   绑定手机号     -->
		<div class="weui-panel__bd">
			<div class="weui-media-box weui-media-box_text">
				<h4 class="weui-media-box__title">{$data.shop_name}</h4>
				<p class="weui-media-box__desc">地址:{$shopinfo.address}<a href='{:U(MODULE_NAME.'/Wifi/map',array('longitude'=>$shopinfo['longitude'],'latitude'=>$shopinfo['latitude']))}'>(查看地图)</a></p>
				<p class="weui-media-box__desc">电话:{$shopinfo.telephone}</p>
				<p class="weui-media-box__desc">主营:{$shopinfo.introduction}</p>
				<p class="weui-media-box__desc">营业时间:{$shopinfo.open_time}</p>
			</div>
		</div>
		<map id="map" longitude="{$shopinfo.longitude}" latitude="{$shopinfo.latitude}" scale="14" controls="{{controls}}" bindcontroltap="controltap" markers="{{markers}}" bindmarkertap="markertap" polyline="{{polyline}}" circles="{{circles}}" bindregionchange="regionchange" show-location style="width: 100%; height: 350px;">
		</map>
		<div class="weui-cells weui-cells_form">
			<foreach name="data.ssid_list" item="val">
			<div class="weui-cell">
				<a href="{:U(MODULE_NAME.'/Wifi/wifiQrcod',array('shopid'=>$shopid,'ssid'=>$val))}">{$val}</a>
				&nbsp;&nbsp;
				<a href="{:U(MODULE_NAME.'/Wifi/guideQrcode',array('shopid'=>$shopid,'ssid'=>$val))}">引导页二维码</a>
				&nbsp;&nbsp;
				<a href="{:U(MODULE_NAME.'/Wifi/guide',array('shopid'=>$shopid,'ssid'=>$val))}">引导页</a>

			</div>
			</foreach>
		</div>
		<div class="weui-btn-area">
			<a href="{:U(MODULE_NAME.'/Wifi/addWifi',array('shopid'=>$shopid))}" class="weui-btn weui-btn_primary">添加WIFI设备</a>
			
			
		</div>
		<!--  提示弹出框   -->

	</section>

</body>
</html>