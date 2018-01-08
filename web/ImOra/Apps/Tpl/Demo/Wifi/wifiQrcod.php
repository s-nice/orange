<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="referrer" content="never">
	<title>二维码</title>
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
		.weui-media-box img {width: 80%; margin-left: 10%;}
	</style>
</head>
<body>
	<section class="phone_main">
		<!--   绑定手机号     -->
		<div class="weui-panel__bd">
			<div class="weui-media-box weui-media-box_text">
				<img  src="{$src}" alt="">
			</div>
		</div>

	</section>

</body>
</html>