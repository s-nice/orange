<layout name="../Layout/Company/AdminLTE_layout" />
<div class="cardindus_warp">
	<div class="datastatistics_title">公司获得名片总数：<span>{$sumCnt}</span>张</div>
	<!-- 折线图 start -->
	<div id="userStatisticsLine" class="arearate_left"></div>
	<!-- 折线图 end -->
	<!-- 数据列表 start -->
	<div id="userStatisticsData" class="arearate_right">
	<!--	<div class="Data_bt Data_bt_top"><span class="left_s js_table_title_last"></span>--><!-- 新增设备量数据表 -->
	<!-- 	 <if condition="count($dataSet) gt 0"> -->
	<!--	     <span class="right_s js_active_export_btn">{$T->str_btn_export}</span>--><!--导出-->
	<!-- 	 </if> -->
	<!-- 	</div> -->
		<div id="userStatisticsData" class="datastatistics_cardAlist">
			<div class="Data_c_content js_active_anyi">
				<!-- 其他如  活跃用户量、周活跃占比、人均在线时长、单次登陆平均在线时长、人均登陆次数 -->
			    <div class="Data_carda_name js_data_title Data_cjs_5">
					<span class="span_c_1">行业<!--日期--></span>
				     <span class="span_c_5 js_sort_cnt">			                  	
				         <u>名片数量(张)</u>
					     <if condition="$_GET['sort'] eq 'value,asc'">
					         <em class="list_sort_asc " sort='value,desc'></em>
					     <elseif condition="$_GET['sort'] eq 'value,desc'" />
					         <em class="list_sort_desc " sort='value,asc'></em>
					     <else />
					         <em class="list_sort_asc list_sort_desc list_sort_none" sort='value,asc'></em>
					     </if>
					 </span>
			    </div>             	                  
				<div class="js_scroll_data">
					<if condition="count($dataSet) gt 0">
						<php>$index = 1;</php>
				           <volist name="dataSet" id="_userStat">
				                <div class="Data_carda_list_z js_data_body Data_cjs_5">
				                  <span class="span_c_1" index="{$index}" title="{$_userStat.date}">{$_userStat.name}</span>
				                  <span class="span_c_5" title="{$_userStat.count}"><i>{$_userStat.value}</i><em><b></b><u></u></em></span>
				                </div>
				                 <php>$index++;</php>
				           </volist>
					<else/>
						<center>No Data</center>
					</if>			            
				</div>	                               
			</div>
		</div>
	</div>
</div>
<!-- 数据列表end -->       		                			           	             	          	       	           	            	                               	
<script>
//echarts中省份名称的定义列表
//var echartProvinceDeline = ['台湾','河北','山西','内蒙古','辽宁','吉林','黑龙江','江苏','浙江','安徽','福建','江西','山东','河南','湖北','湖南','广东','广西','海南','四川','贵州','云南','西藏','陕西','甘肃','青海','宁夏','新疆','北京','天津','上海','重庆','香港','澳门'];

var list = {:json_encode($dataSet)}; //图表数据
/* for(var i=0,maxi=list.length; i<maxi; i++){
	for(var j=0,maxj=echartProvinceDeline.length; j<maxj; j++){
		console.log(list[i].name.substr(0,2) , echartProvinceDeline[j].substr(0,2))
		if(list[i].name.substr(0,2) == echartProvinceDeline[j].substr(0,2)){
			list[i].name = echartProvinceDeline[j];
			console.log(list[i].name)
		}
	}
} */
var getDataUrlIndex =  "{:U(CONTROLLER_NAME.'/cardAreaRate')}";
// 指定图表的配置项和数据
function randomData() {
    return Math.round(Math.random()*1000);
}
$(function(){
	$.get('__PUBLIC__/js/jsExtend/echart/china.json', function (chinaJson) {
	    echarts.registerMap('china', chinaJson);
	
	option = {
	    
	    tooltip: {
	        trigger: 'item'
	    },  
	    series: [
	        {
	           // name: 'iphone3',
	            type: 'map',
	            mapType: 'china',
	            roam: false,
	            label: {
	                normal: {
	                    show: true
	                },
	                emphasis: {
	                    show: true
	                }
	            },
	            data:list/*[
	                {name: '北京',value: 2 },
	                {name: '天津',value: randomData() },
	                {name: '上海',value: randomData() },
	                {name: '重庆',value: randomData() },
	                {name: '河北',value: randomData() },
	                {name: '河南',value: randomData() },
	                {name: '云南',value: randomData() },
	                {name: '辽宁',value: randomData() },
	                {name: '黑龙江',value: randomData() },
	                {name: '湖南',value: randomData() },
	                {name: '安徽',value: randomData() },
	                {name: '山东',value: randomData() },
	                {name: '新疆',value: randomData() },
	                {name: '江苏',value: randomData() },
	                {name: '浙江',value: randomData() },
	                {name: '江西',value: randomData() },
	                {name: '湖北',value: randomData() },
	                {name: '广西',value: randomData() },
	                {name: '甘肃',value: randomData() },
	                {name: '山西',value: randomData() },
	                {name: '内蒙古',value: randomData() },
	                {name: '陕西',value: randomData() },
	                {name: '吉林',value: randomData() },
	                {name: '福建',value: randomData() },
	                {name: '贵州',value: randomData() },
	                {name: '广东',value: randomData() },
	                {name: '青海',value: randomData() },
	                {name: '西藏',value: randomData() },
	                {name: '四川',value: randomData() },
	                {name: '宁夏',value: randomData() },
	                {name: '海南',value: randomData() },
	                {name: '台湾',value: randomData() },
	                {name: '香港',value: randomData() },
	                {name: '澳门',value: randomData() }
	            ]*/
	        }
	       
	    ]
	};
	
		//基于准备好的dom，初始化echarts实例
		var myChart = echarts.init(document.getElementById('userStatisticsLine'));
		// 使用刚指定的配置项和数据显示图表。
		myChart.setOption(option);
	});	

		//排序
		 $('.js_sort_cnt').click(function(){
		 	var obj = $(this);
		 	var sort = obj.find('em').attr('sort');
		 	getDataUrlIndex = getDataUrlIndex.replace(/.html|.htm/g,'');
		 	window.location.href = getDataUrlIndex+'/sort/'+sort;
		 });
});
</script>
