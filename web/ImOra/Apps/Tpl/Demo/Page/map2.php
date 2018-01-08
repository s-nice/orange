<!DOCTYPE html>  
<html>  
<head>  
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<meta name="screen-orientation" content="portrait">
<meta name="x5-orientation" content="portrait">
<title>{$T->str_360_title}</title>  
<style type="text/css">  
html{height:100%}  
body{height:100%;margin:0px;padding:0px}  
#container{height:100%}  
</style>
<script type="text/javascript" src="//api.map.baidu.com/api?v=2.0&ak={$key}"></script>
</head>  
 
<body>  
<include file="@Layout/nav_demo" />
<div id="container"></div> 
<script type="text/javascript"> 
var listUrl = "{:U('Demo/Wechat/wListZp')}";
var map = new BMap.Map("container");
var dataJson = JSON.parse('{$json}');
var str_360_ren="{$T->str_360_ren}";
</script>  
<script src="/static/map/js/map.js?v={:C('WECHAT_APP_VERSION')}"></script>
</body>  
</html>