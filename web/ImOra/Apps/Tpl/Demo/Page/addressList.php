<!DOCTYPE html>  
<html>  
<head>  
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>{$T->str_aimap_title}</title>  
<style type="text/css">  
html{height:100%}  
body{height:100%;margin:0px;padding:0px}  
#container{height:100%}  
</style>  
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak={$key}">
</script>
</head>  
 
<body>  
<div id="container"></div>
<img id='center' src='/images/icons/pin.png' style='position: absolute;top:50%;left:50%;margin-top:-36px;margin-left:-10px;' width=20>
<div style='position: absolute;width:100%;top:2%;text-align:center;'>
    <input id='keyword' type='text' style='width:90%;'>
</div>
<script src="/static/common/jquery-1.11.0.min.js"></script>
<script type="text/javascript">
var URL_LOAD="{:U('Demo/Page/getAddress')}";

//信息窗口
var SCONTENT =
	"<h4 style='margin:0 0 5px 0;padding:0.2em 0'>__TITLE</h4>" +  
	"<p style='margin:0;line-height:1.5;font-size:13px;text-indent:2em'>__CONTENT</p>" + 
	"<p>到这里去：<a href='javascript:walk(__POINT);' style='margin-left:10px;'>步行</a>"+
	"<a href='javascript:bus(__POINT);' style='margin-left:10px;'>公交</a>"+
	"<a href='javascript:drive(__POINT);' style='margin-left:10px;'>驾车</a></p>" +
	"</div>";

//当前位置坐标
var CURRENT_POINT={};

//地图初始化
var map = new BMap.Map("container");
var point = new BMap.Point(116.331398,39.897445);
map.centerAndZoom(point,14);
map.enableScrollWheelZoom(true);
map.addEventListener("dragend",function(type,target){
	var center=this.getCenter();
	load(center.lng, center.lat);
});

//建立一个自动完成的对象
var ac = new BMap.Autocomplete({"input" : "keyword","location" : map});
ac.addEventListener("onhighlight", function(e) {  //鼠标放在下拉列表上的事件
	var str = "";
	var _value = e.fromitem.value;
	var value = "";
	if (e.fromitem.index > -1) {
		value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
	}    
	str = "FromItem<br />index = " + e.fromitem.index + "<br />value = " + value;
	
	value = "";
	if (e.toitem.index > -1) {
		_value = e.toitem.value;
		value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
	}    
	str += "<br />ToItem<br />index = " + e.toitem.index + "<br />value = " + value;
	//G("searchResultPanel").innerHTML = str;
});

var myValue;
ac.addEventListener("onconfirm", function(e) {    //鼠标点击下拉列表后的事件
    var _value = e.item.value;
	myValue = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
	//G("searchResultPanel").innerHTML ="onconfirm<br />index = " + e.item.index + "<br />myValue = " + myValue;
	setPlace();
});

function setPlace(){
	clearOverlsys();
	function myFun(){
		var pp = local.getResults().getPoi(0).point;    //获取第一个智能搜索的结果
		map.centerAndZoom(pp, 14);
		load(pp.lng, pp.lat);
	}
	var local = new BMap.LocalSearch(map, { //智能搜索
	    onSearchComplete: myFun
	});
	local.search(myValue);
}
	
//红色坐标点
var OVERLAYS=[];

//步行搜索
var SEARCH_WALK=new BMap.WalkingRoute(map, {renderOptions:{map: map, autoViewport: true}});

//公交搜索
var SEARCH_BUS=new BMap.TransitRoute(map, {renderOptions: {map: map, autoViewport: true}});

//驾车搜索
var SEARCH_DRIVE=new BMap.DrivingRoute(map, {renderOptions:{map: map, autoViewport: true}});

//步行搜索
function walk(lng, lat){
	clearSearchResult();
	var p1=new BMap.Point(CURRENT_POINT.lng, CURRENT_POINT.lat);
	var p2=new BMap.Point(lng, lat);
	SEARCH_WALK.search(p1, p2);
}

//公交搜索
function bus(lng, lat){
	clearSearchResult();
	var p1=new BMap.Point(CURRENT_POINT.lng, CURRENT_POINT.lat);
	var p2=new BMap.Point(lng, lat);
	SEARCH_BUS.search(p1, p2);
}

//步行搜索
function drive(lng, lat){
	clearSearchResult();
	var p1=new BMap.Point(CURRENT_POINT.lng, CURRENT_POINT.lat);
	var p2=new BMap.Point(lng, lat);
	SEARCH_DRIVE.search(p1, p2);
}

//清除搜索结果
function clearSearchResult(){
	SEARCH_WALK.clearResults();
	SEARCH_BUS.clearResults();
	SEARCH_DRIVE.clearResults();
}

//清除红色坐标
function clearOverlsys(){
	for(var i=0;i<OVERLAYS.length;i++){
		map.removeOverlay(OVERLAYS[i]);
	}
}

//加载坐标数据
function load(lng,lat){
	clearOverlsys();
	$.post(URL_LOAD,{lng:lng,lat:lat},function(rst){
		rst=$.parseJSON(rst);
		var list=rst.data.list;

		for(var i=0;i<list.length;i++){
			var p = new BMap.Point(list[i]['longitude'],list[i]['latitude']);
			var overlay=new BMap.Marker(p);
			overlay.__msgOpts = {
				point: p,
                title : list[i]['telephone'],
                msg:list[i]['address']
			};
			
			map.addOverlay(overlay);
			OVERLAYS.push(overlay);

			overlay.addEventListener("click", function(){
				var opts=this.__msgOpts;
				var content=SCONTENT.replace('__TITLE', opts.title)
				                    .replace('__CONTENT', opts.msg)
			                        .replace(/__POINT/g, opts.point.lng+','+opts.point.lat);
				var infoWindow = new BMap.InfoWindow(content); 
				infoWindow.addEventListener('open', function(){
					$('#center').hide();
				});
				infoWindow.addEventListener('close', function(){
					$('#center').show();
				});
				map.openInfoWindow(infoWindow,this.point);
			});
		}
	});
}
/*
CURRENT_POINT.lng=116.477427;
CURRENT_POINT.lat=39.962069;

map.panTo(new BMap.Point(CURRENT_POINT.lng, CURRENT_POINT.lat));
load(CURRENT_POINT.lng, CURRENT_POINT.lat, true);
*/
//当前位置
var geolocation = new BMap.Geolocation();
geolocation.getCurrentPosition(function(r){
	if(this.getStatus() == BMAP_STATUS_SUCCESS){
		var myIcon = new BMap.Icon("/images/icons/round.png", new BMap.Size(21,21));
		var mk = new BMap.Marker(r.point,{icon:myIcon});
		map.addOverlay(mk);
		map.panTo(r.point);
		CURRENT_POINT.lng=r.point.lng;
		CURRENT_POINT.lat=r.point.lat;
		load(r.point.lng, r.point.lat, true);
	}
	else {
		alert('failed'+this.getStatus());
	}        
},{enableHighAccuracy: true});
</script>  
</body>  
</html>