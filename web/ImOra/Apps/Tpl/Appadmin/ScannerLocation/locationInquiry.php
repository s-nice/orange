<!--定位查询-->
<layout name="../Layout/Layout" />

<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="content_search">
				<div class="card_company clear js_select_content">
					<div class="card_company_list border_style menu_list js_select_list_pro js_select_ul_list">
						<input type="text" value="北京市" autocomplete="off" readonly="readonly" />
						<em></em>
						<ul>
                            <foreach name="provinces" item="prolist">
                                <li val="{$prolist['provincecode']}">{$prolist['province']}</li>
                            </foreach>
						</ul>
					</div>
					<div class="card_company_list border_style menu_list js_select_list_city js_select_ul_list">
						<input type="text" value="北京市" autocomplete="off" readonly="readonly" />
						<em></em>
						<ul>
						</ul>
					</div>
				</div>
				<div class="map_content">
					<!--   放置地图  -->
					<div class="scanner_map left" id="maplocaition"> </div>

					<div class="u_o_item js_scanner_status" style="width:300px;">
						<ul class="order_left right">
							<li class="clear">
								<span>设备SN：</span>
								<em id="js_scanner_sn"></em>
							</li>
							<li class="clear">
								<span>最新使用时间：</span>
								<em id="js_scanner_use_time"></em>
							</li>
							<li class="clear">
								<span>当前状态：</span>
								<em id="js_scanner_now_status"></em>
							</li>
							<li class="clear">
								<span>性质：</span>
								<em id="js_scanner_nature"></em>
							</li>
							<li class="clear">
								<span>故障上报时间：</span>
								<em id="js_scanner_fault_time"></em>
							</li>

							<b class="middle_button js_btn_restart js_btnrestartcontroller" style="display:none;">重新启动</b>

						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
    var lists = <?php echo $scannerlist;?>;
    var js_getCityUrl = "{:U(MODULE_NAME.'/ScannerManager/getCity','','',true)}";
    var js_getMapUrl = "{:U(MODULE_NAME.'/ScannerManager/getMap','','',true)}";
    var js_getScannerUrl = "{:U(MODULE_NAME.'/ScannerManager/getScannerById','','',true)}";
    var js_restartUrl = "{:U(MODULE_NAME.'/ScannerManager/scannerRestart','','',true)}";

    //百度地图API功能
    function loadJScript(_list) {
        if(_list!=undefined) lists = _list;
        if(_list===null || lists===null) lists = [];
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = "http://api.map.baidu.com/api?v=2.0&ak={$keys}&callback=inits";
        document.body.appendChild(script);
    }
    function inits() {

        var map = new BMap.Map("maplocaition", {enableMapClick:false});            // 创建Map实例
        var point = new BMap.Point(116.404, 39.915);   // 创建点坐标
        map.centerAndZoom(point,15);                    // 初始化地图，设置中心点坐标和地图级别
        map.enableScrollWheelZoom();                    //启用滚轮放大缩小
        // 创建地址解析器实例
        for(var i=0;i<lists.length;i++){
            // 将地址解析结果显示在地图上,并调整地图视野
            var sid = lists[i]['scannerid'];
            var address = lists[i]['address'];

            var p = new BMap.Point(lists[i]['longitude'], lists[i]['latitude']); // 创建点坐标
            map.centerAndZoom(p, 16);//设置中心点坐标和地图级别
            var marker=new BMap.Marker(p);
            map.addOverlay(marker);               // 将标注添加到地图中

            var content="<span >"+address+"</span><input type=\"hidden\" id=\"scannerid\"  value=\""+sid+"\" name=\"scannerid\" />";
            var  infoWindow = new BMap.InfoWindow(content);
            marker.addEventListener('click',function(){
                marker.openInfoWindow(infoWindow);
                var scannerid = $('#scannerid').val();
                showScannerInfo(scannerid);
            });

        }
    }

    function showScannerInfo(_id){
        $.ajax({
            url:js_getScannerUrl,
            type:'post',
            dataType:'json',
            data:'id='+_id,
            success:function(res){
                $('#js_scanner_sn').html(res.scannerid);
                $('#js_scanner_use_time').html(res.lastusetime);
                if(res.state==1){
                    //1正常2故障3回收
                    $('#js_scanner_now_status').html('正常');
                }else if(res.state==2){
                    $('#js_scanner_now_status').html('故障');
                }else{
                    $('#js_scanner_now_status').html('已回收');
                }

                if(res.type==1){
                    //1公司发放2售出
                    $('#js_scanner_nature').html('公司发放');
                }else{
                    $('#js_scanner_nature').html('售出');
                }

                $('#js_scanner_fault_time').html(res.reporttime);

                $('.js_scanner_status .js_btnrestartcontroller').attr('scannerid',res.scannerid);
                $('.js_scanner_status .js_btnrestartcontroller').html('重新启动');
                if(res.state==2 && (res.reporttype==1|| res.reporttype==2)) {
                    $('.js_scanner_status .js_btnrestartcontroller').show();
                    $('.js_scanner_status .js_btnrestartcontroller').addClass('js_btn_restart');
                }
            },error:function(res){
                $.global_msg.init({gType:'warning',icon:0,time:3,msg:'操作失败'});
            }
        });

    }


    $(function(){
        $.scannerLocation.init();
        loadJScript();
    });


</script>