<!DOCTYPE html>  
<html>  
<head>  
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>地图</title>  
<style type="text/css">  
html{height:100%}  
body{height:100%;margin:0px;padding:0px}  
#container{height:100%}  
</style>  
<script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak={$key}&s=1">
</script>
</head>  
 
<body>  
<div id="container"></div> 
<script type="text/javascript"> 
var map = new BMap.Map("container");          // 创建地图实例  
var point = new BMap.Point(116.404, 39.915);  // 创建点坐标  
map.centerAndZoom(point, 15);                 // 初始化地图，设置中心点坐标和地图级别  

var myGeo = new BMap.Geocoder();
//将地址解析结果显示在地图上,并调整地图视野
myGeo.getPoint("{$address}", function(point){
	if (point) {
		map.centerAndZoom(point, 16);
		map.addOverlay(new BMap.Marker(point));

		var marker = new BMap.Marker(point);  // 创建标注
		map.addOverlay(marker);              // 将标注添加到地图中

		var label = new BMap.Label("{$address}",{offset:new BMap.Size(20,-10)});
		marker.setLabel(label);
	}else{
		alert("您选择地址没有解析到结果!");
	}
});
</script>  
</body>  
</html>