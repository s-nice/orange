<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>测试</title>
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
		<div class="weui-cells weui-cells_form">
            <div class="weui-cell">
                <a href="{:U(MODULE_NAME.'/ConnectScanner/showSweepScannerCardGroupList')}">任意扫（新）</a>
            </div>
			<div class="weui-cell">
				<a href="{:U(MODULE_NAME.'/ConnectScanner/showSweepAll')}">扫描所有</a>
			</div>
			<div class="weui-cell">
				<a href="{:U(MODULE_NAME.'/Wifi/shopList')}">免费WIFI</a>
			</div>
			<div class="weui-cell">
				<a href="{:U(MODULE_NAME.'/Face/index')}">face++</a>
			</div>
            <div class="weui-cell">
                <a href="{:U(MODULE_NAME.'/ConnectScanner/bindingPhone')}">绑定同步</a>
            </div>
		</div>
		<div class="weui-btn-area">
			<a class="weui-btn weui-btn_primary">添加门店</a>
		</div>
		<!--  提示弹出框   -->

	</section>

</body>
</html>