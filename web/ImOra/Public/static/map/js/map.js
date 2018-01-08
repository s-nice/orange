var area_dict = {
    '北京':[116.24,39.55],
    '广东':[113.14,23.08],
    '安徽':[117.17,31.52],
    '重庆':[106.54,29.59],
    '福建':[119.18,26.05],
    '甘肃':[103.51,36.04],
    '广西':[108.19,22.48],
    '贵州':[106.42,26.35],
    '海南':[110.20,20.02],
    '河北':[114.30,38.02],
    '河南':[113.14,34.46],
    '黑龙江':[126.14,47.08],
    '湖北':[114.17,30.35],
    '湖南':[112.59,28.12],
    '江苏':[118.46,33.08],
    '江西':[115.55,28.40],
    '辽宁':[123.25,41.48],
    '吉林':[126.14,43.08],
    '内蒙':[111.41,40.48],
    '宁夏':[106.16,38.27],
    '青海':[101.48,36.38],
    '山东':[117.00,36.40],
    '山西':[112.33,37.54],
    '陕西':[108.57,34.17],
    '上海':[121.29,31.14],
    '四川':[100.04,30.40],
    '天津':[117.12,39.02],
    '西藏':[91.08,29.39],
    '新疆':[87.36,43.45],
    '云南':[100.42,25.04],
    '浙江':[120.10,30.16],
    '香港':[114.12,22.33],
    '澳门':[113.07,22.33],
    '台湾':[121.30,25.03]
};

for(var key in area_dict){
	var tmp=area_dict[key];
	var count=false;
	var fname=false;
	for(var i=0;i<dataJson['distribution'].length;i++){
		if (dataJson['distribution'][i]['area'].indexOf(key)!=-1){
			fname=dataJson['distribution'][i]['area'];
			count = dataJson['distribution'][i]['count'];
			break;
		}
	}
	if (count===false) continue;
	
	var point = new BMap.Point(tmp[0], tmp[1]);
	var opts = {
	    position : point
	}
	var label = new BMap.Label(key+count+str_360_ren, opts);  // 创建文本标注对象
	label.setTitle(fname);
	label.setStyle({
        color : "red",
        fontSize : "12px",
        height : "20px",
        lineHeight : "20px",
        fontFamily:"微软雅黑"
	});
	label.addEventListener('click',function(evt){
		location.href=listUrl+'?type=5&typekwds='+evt.target.getTitle();
	});
    map.addOverlay(label);  
}
var styleJson = [{
    "featureType": "road",
    "elementType": "all",
    "stylers": {
           "visibility": "off"
    }
}];
map.setMapStyle({
    styleJson:styleJson
});
map.centerAndZoom(new BMap.Point(116.4035,39.915), 5);
map.enableScrollWheelZoom(true);