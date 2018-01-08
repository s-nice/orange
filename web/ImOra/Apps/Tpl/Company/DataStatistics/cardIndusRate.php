<layout name="../Layout/Company/AdminLTE_layout" />
<div class="cardindus_warp">
<div class="datastatistics_title">公司获得名片总数：<span>{$sumCnt}</span>张</div> 
<!-- 折线图 start -->
<div class="map_box"> 
<div id="userStatisticsLine" style="width:320px;height:390px; left:60px;" class="datastatistics_canvas"></div>
<div id="userStatisticsLineNoData">
	<div class="big_round">
		<div class="small_round"></div>
	</div>
</div> 
<!-- 折线图 end --> 
<!-- 数据列表 start --> 
<div id="userStatisticsData" class="datastatistics_datalist datalist_min"> 
	<div class="Data_c_content js_active_anyi"> 
	<!-- 其他如  活跃用户量、周活跃占比、人均在线时长、单次登陆平均在线时长、人均登陆次数 --> 
    	<div class="Data_cjs_name js_data_title Data_cjs_5"> 
     		<span class="span_c_1 span_sm_l">行业<!--日期--></span> 
      		<span class="span_c_5 js_sort_cnt  span_sm_l"> <u>名片数量(张)</u> 
      		<if condition="$_GET['sort'] eq 'value,asc'"> 
       			<em class="list_sort_asc " sort="value,desc"></em> 
       		<elseif condition="$_GET['sort'] eq 'value,desc'" /> 
       			<em class="list_sort_desc " sort="value,asc"></em> 
       		<else /> 
       			<em class="list_sort_asc list_sort_desc list_sort_none" sort="value,asc"></em> 
      		</if> 
      	</span> 
    </div> 
    <div class="js_scroll_data"> 
     <if condition="count($dataSet) gt 0"> 
      <php>
       $index = 0;
      </php> 
      <volist name="dataSet" id="_userStat"> 
       <div class="Data_c_list_z js_data_body Data_cjs_5">
        <span class="span_c_1 span_sm_l" index="{$index}" title="{$_userStat.date}"><i class="bgcolor" style="border:3px solid {$colors[$index]};"></i><em>{$_userStat.name}</em></span> 
        <span class="span_c_5 span_sm_l" title="{$_userStat.count}">{$_userStat.value}</span> 
       </div> 
       <php>
        $index++;
       </php> 
      </volist> 
      <else /> 
      <center>
       No Data
      </center> 
     </if> 
    </div> 
   </div> 
  </div>
   </div>
  </div>
  <!-- 数据列表end --> 
  <script>
var getDataUrlIndex =  "{:U(CONTROLLER_NAME.'/cardIndusRate')}";
//请求变量回显使用
var colorList = {:json_encode(C('STAT_CHART_LINE_COLORS'))};
var list = {:json_encode($dataSet)}; //图表数据
list.length ? $('#userStatisticsLineNoData').hide() :$('#userStatisticsLine').hide();
// 指定图表的配置项和数据
var echartOptionLine = {
	    tooltip : {
	        trigger: 'item',
	        formatter: "{a} <br/>{b} : {c} ({d}%)"
	    },
	    legend: {
	        orient: 'vertical',
	        left: 'center'
	    },
	    color:colorList,
	    series : [
	        {
	            name: '名片行业',
	            type: 'pie',
	            radius :  ['40%', '90%'],
	            center: ['50%', '60%'],
	            data:list,
	            label: {
	                normal: {
	                    show: false,
	                    position: 'center'
	                },
	                emphasis: {
	                    show: false,
	                    textStyle: {
	                        fontSize: '30',
	                        fontWeight: 'bold'
	                    }
	                }
	            },
                labelLine: {
                    normal: {
                        show: false
                    }
                },
	            itemStyle: {
	                emphasis: {
	                    shadowBlur: 10,
	                    shadowOffsetX: 0,
	                    shadowColor: 'rgba(0, 0, 0, 0.5)'
	                }
	            }
	        }
	    ]
	};
		

var gEchartSettings = [{containerId: 'userStatisticsLine', option : echartOptionLine}];

 $(function(){
		//排序
	 $('.js_sort_cnt').click(function(){
	 	var obj = $(this);
	 	var sort = obj.find('em').attr('sort');
	 	getDataUrlIndex = getDataUrlIndex.replace(/.html|.htm/g,'');
	 	window.location.href = getDataUrlIndex+'/sort/'+sort;
	 });
});
		
</script> 