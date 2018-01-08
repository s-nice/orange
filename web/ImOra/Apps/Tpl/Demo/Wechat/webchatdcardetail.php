<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<!-- uc强制竖屏 -->
	<meta name="screen-orientation" content="portrait">
	<!-- QQ强制竖屏  -->
	<meta name="x5-orientation" content="portrait">
	<title>微信列表页</title>
	<link rel="stylesheet" href="__PUBLIC__/css/wList.css?v={:C('WECHAT_APP_VERSION')}">
</head>
<body>
	<div class="warmp">
		<div class="content_info">
			<div class="info_img"><img src="{$info.picture}" ></div>
			<ul>
				<li><span>姓名：</span><span>{$info.FN}</span></li>
				<li><span>职务：</span><span>{$info.TITLE}</span></li>
				<li><span>公司：</span><span>{$info.ORG}</span></li>
				<li><span>地址：</span><span>{$info.ADR}</span></li>
				<li><span>邮编：</span><span>{$info.cardzipcode}</span></li>
				<li><span>电话：</span><span>{$info.CELL}</span></li>
				<li><span>手机：</span><span>{$info.TEL}</span></li>
				<li><span>邮箱：</span><span>{$info.EMAIL}</span></li>
				<li><span>官网：</span><span>{$info.URL}</span></li>
			</ul>
		</div>
	</div>
<script>
	var iScale = 1;
	iScale = iScale / window.devicePixelRatio;
	document.write('<meta name="viewport" content="height=device-height,width=device-width,initial-scale='+iScale+',minimum-scale='+iScale+',maximum-scale='+iScale+',user-scalable=yes" />')
	//执行rem动态设置
	var supportOrientation = (typeof window.orientation === 'number' && typeof window.onorientationchange === 'object');
	var orientation;
	var init = function(){
		var updateOrientation = function(){
			if(supportOrientation){
				orientation = window.orientation;
			}else{
				orientation = (window.innerWidth > window.innerHeight) ? 90 : 0;
			}
			fontSize();
	      	reloadPop();
		};
		var eventName = supportOrientation ? 'orientationchange' : 'resize';
		window.addEventListener(eventName, updateOrientation, false);
		updateOrientation();
	};
	window.addEventListener('DOMContentLoaded',init,false);
	/**
	 * 将 html 的字体大小 设置为  屏幕宽度 / 设计稿宽度  * 100. 这样就可以将页面内字体和其他元素的宽度直接 / 100, 将单位顺利从 px 转成 rem 
	 */
	function fontSize(){
		var iWidth;
		var width = document.documentElement.clientWidth;
		var height = document.documentElement.clientHeight;
		var myOrientation = typeof window.orientation === 'number' ? window.orientation : orientation;
		iWidth = ( myOrientation%180 === 0) ? (width > height ? height : width) : (width > height ? width : height);
		document.getElementsByTagName('html')[0].style.fontSize = iWidth / 7.2 + 'px';
	}
	// 弹出框横竖屏重新加载
	function reloadPop(){
		if(typeof layer == 'object'){
	    	$('.xubox_layer').css({top:0,left:0,bottom:0,right:0, margin:'auto'});
		}
	}
</script>
</body>
</html>