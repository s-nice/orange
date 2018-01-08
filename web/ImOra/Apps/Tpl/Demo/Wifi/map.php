<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>门店</title>
	<link rel="stylesheet" href="__PUBLIC__/css/weDialog.min.css?v={:C('WECHAT_APP_VERSION')}">
	<link rel="stylesheet" href="__PUBLIC__/css/weui.min.css?v={:C('WECHAT_APP_VERSION')}">
	<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js?v={:C('WECHAT_APP_VERSION')}"></script>
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

	</section>
	<script>
		wx.config({
		    debug: false,
		    appId: "{$signPackage['appId']}",
		    timestamp: "{$signPackage['timestamp']}",
		    nonceStr: "{$signPackage['nonceStr']}",
		    signature: "{$signPackage['signature']}",
		    jsApiList: ['openLocation']
		});
		wx.openLocation({
		    latitude: 80, // 纬度，浮点数，范围为90 ~ -90
		    longitude: 80, // 经度，浮点数，范围为180 ~ -180。
		    name: 'sdf', // 位置名
		    address: '', // 地址详情说明
		    scale: 1, // 地图缩放级别,整形值,范围从1~28。默认为最大
		    infoUrl: '' // 在查看位置界面底部显示的超链接,可点击跳转
		});
	</script>

</body>
</html>