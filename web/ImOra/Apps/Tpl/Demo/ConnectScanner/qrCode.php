<!DOCTYPE html>
<html lang="en" style="width:100%;height:100%;background:#111;">
<head>
	<meta charset="UTF-8">
	<!-- uc强制竖屏 -->
	<meta name="screen-orientation" content="portrait">
	<!-- QQ强制竖屏  -->
	<meta name="x5-orientation" content="portrait">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<title>{$T->str_cc_qcode}</title>
	<link rel="stylesheet" href="__PUBLIC__/css/weui.min.css?v={:C('WECHAT_APP_VERSION')}">
	<link rel="stylesheet" href="__PUBLIC__/css/wList.css?v={:C('WECHAT_APP_VERSION')}">
</head>
<body style="width:100%;height:100%;background:#111;">
	<div class="code">
		<div class="code_bg">
			<div class="code_img">
				<!-- <img src="{:U('Demo/'.CONTROLLER_NAME.'/getQrCode')}"> -->
				<img src="__PUBLIC__/images/橙橙.jpg"/>
			</div>
			<p>{$userid}</p>
			<p><!-- 请在扫描仪端输入如上序列号进行绑定 --></p>
		</div>
	</div>
</body>
</html>