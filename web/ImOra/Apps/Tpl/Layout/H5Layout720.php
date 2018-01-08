<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="UTF-8">
<!-- uc强制竖屏 -->
<meta name="screen-orientation" content="portrait">
<!-- QQ强制竖屏  -->
<meta name="x5-orientation" content="portrait">
<title>{$title}<if condition="!empty($minTitle)">-{$minTitle}</if></title>
<link rel="stylesheet" href="__PUBLIC__/css/H5/mobile720.css?v={:C('APP_VERSION')}" />
<link href="__PUBLIC__/js/jsExtend/h5videojs/video-js.css" rel="stylesheet">
<link href="__PUBLIC__/css/swiper.min.css" rel="stylesheet">
<script src="__PUBLIC__/js/jsExtend/h5videojs/videojs-ie8.min.js"></script>
<script type="text/javascript">
if (navigator.userAgent.indexOf('MQQBrowser')>=0){
	document.write('<link rel="stylesheet" href="__PUBLIC__/css/mobile-qq-weixin.css?v={:C('APP_VERSION')}" />');
}
</script>
<script type="text/javascript" src="__PUBLIC__/js/jquery/jquery.src.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/expression/js/plugins/exp/exp1.js"></script>
{// 加载自定义的css }
<if condition="isset($moreCSSs)">
	<volist name="moreCSSs" id="_css">
		<link href="__PUBLIC__/{$_css}.css?v={:C('APP_VERSION')}" rel="stylesheet" type="text/css">
	</volist>
</if>
<script>
	var iScale = 1;
	iScale = iScale / window.devicePixelRatio;
	document.write('<meta name="viewport" content="height=device-height,width=device-width,initial-scale='+iScale+',minimum-scale='+iScale+',maximum-scale='+iScale+',user-scalable=yes,viewprot-fit:contain"  />')
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
			if ("{$device}" === 'pcCard') {
				pcCardStyle(); // 电脑端名片详情页样式
			} else {
				fontSize(); // 手机端样式
			}
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
		$(".swiper-pagination-bullet").css({"width":"0.1rem","height":"0.1rem"}); // 名片详情页轮播图分页器显示样式大小
	}
	// 弹出框横竖屏重新加载
	function reloadPop(){
		if(typeof layer == 'object'){
	    	$('.xubox_layer').css({top:0,left:0,bottom:0,right:0, margin:'auto'});
		}
	}
</script>
</head>
<body onload="typeof(RefreshOnce)==='undefined' ? null : RefreshOnce();">
{__CONTENT__}
{// 加载本模块js }
<if condition="is_file(WEB_ROOT_DIR . 'js/oradt/H5/'.strtolower(CONTROLLER_NAME).'.js')">
	<script src="__PUBLIC__/js/oradt/H5/{:strtolower(CONTROLLER_NAME)}.js?v={:C('APP_VERSION')}<php>echo time()</php>" charset="utf-8"></script>
</if>
<if condition="isset($moreScripts)">
<volist name="moreScripts" id="_script">
	<if condition="substr($_script, 0 ,7)=='http://'||substr($_script, 0 ,8)=='https://'">
		<script src="{$_script}"></script>
	<else/>
		<script src="__PUBLIC__/{$_script}.js?v={:C('APP_VERSION')}<php>echo time()</php>" charset="utf-8"></script>
	</if>
	</volist>
</if>
<script>
var gMessageTitle = '{$T->h5_global_pop_title}';
var gMessageSubmit1 = '{$T->h5_global_pop_submit}';
var gMessageSubmit2 = '{$T->h5_global_pop_cancel}';
var gPublic = "{:U('/','','', true)}";
var JS_PUBLIC = "__PUBLIC__";
</script>
</body>
</html>