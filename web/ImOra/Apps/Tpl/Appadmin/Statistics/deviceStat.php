<layout name="../Layout/Layout"/>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
            	<div class="search_right_c">
            		<div class="select_IOS">
            			<input type="text" value="IOS端" />
            			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            			<ul>
            				<li title="IOS端">IOS端</li>
            				<li title="Android端">Android端</li>
            				<li title="Leaf">Leaf</li>
            			</ul>
            		</div>
            		<div class="select_sketch">
            			<input type="text" value="渠道" />
            			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            			<ul>
            				<li title="渠道">渠道</li>
            				<li title="渠道一">渠道一</li>
            				<li title="渠道二">渠道二</li>
            			</ul>
            		</div>
            		<div class="select_time_c">
					    <span>时间</span>
						<div class="time_c">
							<input class="time_input" type="text" name="startTime[]"/>
							<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
						</div>
						<span>--</span>
						<div class="time_c">
							<input class="time_input" type="text" name="endTime[]"/>
							<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
						</div>
			            <input class="time_button" type="button" value="对比时段"/>
			            <div class="time_duibi">
			            	<div class="time_c time_right">
								<input class="time_input" type="text" name="startTime[]"/>
								<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
							</div>
							<span>--</span>
							<div class="time_c">
								<input class="time_input" type="text" name="endTime[]"/>
								<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
							</div>
							<input class="timeduibi_button" type="button" value="对比时段"/>
			            </div>
	            	</div>
            	</div>
            </div>
            <div class="select_xinzeng">
            	<input type="text" value="新增设备量" />
            	<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            	<ul>
            		<li title="新增设备量">新增设备量</li>
            		<li title="新增设备量">新增设备量</li>
            		<li title="新增设备量">新增设备量</li>
            	</ul>
            </div>
            <div id="userStatisticsLine" style="width:820px;height:500px;" class=""></div>
            <div id="userStatisticsData" class="">
            	<div class="Data_bt"><span class="left_s">新增设备量数据表</span><span class="right_s">导出</span></div>
            	<div class="Data_c_content">
		            <if condition="count($statsList) gt 0">
		                <div class="Data_c_name">
		                  <span class="span_c_1">日期</span>
		                  <span class="span_c_1">系统平台</span>
		                  <span class="span_c_1">渠道</span>
		                  <span class="span_c_2">新增设备量</span>
		                </div>
		                <volist name="statsList" id="_stat">
		                <div class="Data_c_list">
		                  <span class="span_c_1">{:date($timeFormat, strtotime($_stat[activate_time]))}</span>
		                  <span class="span_c_1">{$_stat.sys_platform}</span>
		                  <span class="span_c_1">{$_stat.channel}</span>
		                  <span class="span_c_2">{$_stat.count_all}</span>
		                </div>
		                </volist>
		            <else/>
		              No Data
		            </if>
		         </div>
            </div>
        </div>
    </div>
</div>

<script>
var xAxisData = [];
var yAxisData = [];
<volist name="statsList" id="_stat">
xAxisData.push("{:$_stat[$timeType.'_index']}");
yAxisData.push("{:$_stat['count_all']}");
</volist>
// 指定图表的配置项和数据
var echartOptionLine =  {
	    tooltip : {
	        trigger: 'axis'
	    },
	    legend: {
	      //  data:['新增设备量']
	    },
	    grid: {
	        left: '3%',
	        right: '4%',
	        bottom: '3%',
	        containLabel: true
	    },
	    xAxis : [
	        {
	            type : 'category',
	            boundaryGap : false,
	            //data : ['周一','周二','周三','周四','周五','周六','周日'],
	            data : xAxisData,
	            axisLabel : {
		            textStyle : {
			            color : '#999'
		            }
	            },
	            axisLine: {
	                lineStyle: {
	                    // 使用深浅的间隔色
	                    color: '#999',
	                    width: 1
	                }
	            },
	            splitLine: {
	            	show:true,
	                lineStyle: {
	                    // 使用深浅的间隔色
	                    color: ['#ddd'],
	                    type : 'dashed'
	                }
	            }
	        }
	    ],
	    yAxis : [
	        {
	            type : 'value',
	            splitLine: {
	            	show:true,
	                lineStyle: {
	                    // 使用深浅的间隔色
	                    color: ['#ddd'],
	                    type : 'dashed'
	                }
	            }
	        }
	    ],
	    series : [
	        {
	            name:'新增设备量',
	            type:'line',
	            itemStyle : { normal: {color:'#555'}}, // 折线颜色
	            //data:[120, 132, 101, 134, 90, 230, 210]
	            data:yAxisData
	        }
	    ]
	};

var gEchartSettings = [
                       {containerId: 'userStatisticsLine', option : echartOptionLine}
                      ];
</script>