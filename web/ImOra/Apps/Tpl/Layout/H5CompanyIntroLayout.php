<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- uc强制竖屏 -->
<meta name="screen-orientation" content="portrait">
<!-- QQ强制竖屏 -->
<meta name="x5-orientation" content="portrait">
{// 加载自定义的css }
<if condition="isset($toShowIosAppStoreId)">
<meta name="apple-itunes-app" content="app-id={:C('IOS_APP_STORE_ID')}">
</if>
<meta charset="UTF-8">
<title>{$title}</title>
<link rel="stylesheet" href="__PUBLIC__/css/H5/mobile.css?v={:C('APP_VERSION')}" />
<script type="text/javascript">
/*if (navigator.userAgent.indexOf('MQQBrowser')>=0){
	document.write('<link rel="stylesheet" href="__PUBLIC__/css/H5/mobile-qq-weixin.css?v={:C('APP_VERSION')}" />');
}*/
</script>
<script type="text/javascript" src="__PUBLIC__/js/jquery/jquery.js"></script>
{// 加载自定义的css }
<if condition="isset($moreCSSs)">
	<volist name="moreCSSs" id="_css">
		<link href="__PUBLIC__/{$_css}.css?v={:C('APP_VERSION')}" rel="stylesheet" type="text/css">
	</volist>
</if>
<script>

	var iScale = 1;
	iScale = iScale / window.devicePixelRatio;

	document.write('<meta name="viewport" content="height=device-height,width=device-width,initial-scale='+iScale+',minimum-scale='+iScale+',maximum-scale='+iScale+',user-scalable=no,viewprot-fit:contain" />')

	var iWidth = document.documentElement.clientWidth;
	document.getElementsByTagName('html')[0].style.fontSize = iWidth / 16 + 'px';
	function Wonresize(){
		setTimeout(function(){
			var iWidth = document.documentElement.clientWidth;
			document.getElementsByTagName('html')[0].style.fontSize = iWidth / 16 + 'px';
		},200);
	 }
	window.addEventListener("onorientationchange" in window ? "orientationchange" : "resize", Wonresize, false);
</script>
</head>
<body onload="typeof(RefreshOnce)==='undefined' ? null : RefreshOnce();" orient="portrait">
{__CONTENT__}
{// 加载本模块js }
<if condition="is_file(WEB_ROOT_DIR . 'js/oradt/H5/'.strtolower(CONTROLLER_NAME).'.js')">
	<script src="__PUBLIC__/js/oradt/H5/{:strtolower(CONTROLLER_NAME)}.js?v={:C('APP_VERSION')}" charset="utf-8"></script>
</if>
<if condition="isset($moreScripts)">
<volist name="moreScripts" id="_script">
	<if condition="substr($_script, 0 ,7)=='http://'||substr($_script, 0 ,8)=='https://'">
		<script src="{$_script}"></script>
	<else/>
		<script src="__PUBLIC__/{$_script}.js?v={:C('APP_VERSION')}" charset="utf-8"></script>
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
