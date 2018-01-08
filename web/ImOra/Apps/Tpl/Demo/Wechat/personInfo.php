<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<!-- uc强制竖屏 -->
	<meta name="screen-orientation" content="portrait">
	<!-- QQ强制竖屏  -->
	<meta name="x5-orientation" content="portrait">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<title>{$T->str_user_info_title}</title>
	<link rel="stylesheet" href="__PUBLIC__/css/weui.min.css?v={:C('WECHAT_APP_VERSION')}">
	<link rel="stylesheet" href="__PUBLIC__/css/wList.css?v={:C('WECHAT_APP_VERSION')}">
</head>
<body>

	<?php  
		if (!empty($data['img'])) {
	?>
		<div class="img_info">
			<img src="{$data.img}">
		</div>	
	<?php
		}
	?>
	
	<div class="weui-cells detail" style="margin-top:0;">
	<?php  
		if (!empty($data['static'])) {
	?>
		<foreach name='data.static' item='v' key='k'>
			<div class="weui-cell">
				<div class="weui-cell__hd">
					<span>{$k}</span>
				</div>
				<div class="weui-cell__bd">
					<p>{$v}</p>
				</div>
			</div>	
		</foreach>
	<?php
		}
	?>	
	</div>
	<div class="weui-panel weui-panel_access">
		<div class="weui-panel__bd">
		<?php  
			if (!empty($data['dynamic'])) {
		?>
			<foreach name='data.dynamic' item='v'>
				<div class="weui-media-box weui-media-box_text">
					<h4 class="weui-media-box__title">
						<!-- 标题 -->
						<a href="{$v.url}">
							{$v.title}
						</a>
					</h4>
					<p class="weui-media-box__desc">
						<!-- 文摘 -->
						<a href="{$v.url}">
							{$v.abstract}
						</a>
					</p>
				</div>	
			</foreach>
		<?php
			}
		?>	
		</div>
	</div>
</body>
</html>