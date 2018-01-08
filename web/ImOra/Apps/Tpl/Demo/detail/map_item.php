<!doctype html>
<html>
<body>
<div class="" STYLE="height:100%;width:100%;position:absolute;" id="maplocaition"></div>
</body>
</html>
<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}?v={:C('WECHAT_APP_VERSION')}"></script>
<script>
    var addrname = "{$addr}";
    //百度地图API功能
    function loadJScript() {
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = "http://api.map.baidu.com/api?v=2.0&ak={$keys}&callback=inits";
        document.body.appendChild(script);
    }
    function inits() {
        // 百度地图API功能
        var map = new BMap.Map("maplocaition", {enableMapClick:false});
        var point = new BMap.Point(116.331398,39.897445);
        map.enableScrollWheelZoom(true);
        map.centerAndZoom(point,15);
        // 创建地址解析器实例
        var myGeo = new BMap.Geocoder();
        // 将地址解析结果显示在地图上,并调整地图视野
        myGeo.getPoint(addrname, function(point){
            if (point) {
                map.centerAndZoom(point, 10);
                map.setZoom(30);
                map.addOverlay(new BMap.Marker(point));
            }else{
                return false;
            }
        }, "北京市");
    }

    $(function(){
        loadJScript();
    });
</script>