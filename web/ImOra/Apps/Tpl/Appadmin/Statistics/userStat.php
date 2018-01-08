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
            <div id="userStatisticsBar" style="width:820px;height:500px; margin-bottom:20px" class=""></div>
            <div id="userStatisticsLine" style="width:820px;height:500px;" class=""></div>
            <div id="userStatisticsData" class="">
            	<div class="Data_bt"><span class="left_s">新增设备量数据表</span><span class="right_s">导出</span></div>
            	<div class="Data_c_content">
		            <if condition="count($userStats) gt 0">
		                <div class="Data_c_name">
		                  <span class="span_c_1">Count All</span>
		                  <span class="span_c_1">User Id</span>
		                  <span class="span_c_1">Create Time</span>
		                  <span class="span_c_2">Create Time</span>
		                </div>
		                <volist name="userStats" id="_userStat">
		                <div class="Data_c_list">
		                  <span class="span_c_1">{$_userStat.count_all}</span>
		                  <span class="span_c_1">{$_userStat.user_id}</span>
		                  <span class="span_c_1">{$_userStat.created_time}</span>
		                  <span class="span_c_2">{$_userStat.created_time}</span>
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
// 指定图表的配置项和数据
var echartOptionBar = {
        title: {
            text: 'ECharts 入门示例'
        },
        tooltip: {},
        legend: {
            data:['销量', 'test1', 'test2']
        },
        yAxis: {
        	type : 'value', // 表明是值
        },
        xAxis: {
        	type : 'category',  // 表明是分类
            data: ["衬衫","羊毛衫","雪纺衫","裤子","高跟鞋","袜子"],
            splitLine: {
            	show:true,
                lineStyle: {
                    // 使用深浅的间隔色
                    color: ['#ddd'],
                    type : 'dashed'
                }
            }
        },
        series: [{
            name: '销量',
            type: 'bar',
            itemStyle : { normal: {color:'rgba(255,0,0,0.5)'}}, // 柱形颜色
            data: [5, 20, 36, 10, 10, 20]
        },{
            name: 'test1',
            type: 'bar',
            itemStyle : { normal: {color:'rgba(0,255,0,0.5)'}}, // 柱形颜色
            data: [5, 20, 36, 10, 10, 20]
        },{
            name: 'test2',
            type: 'bar',
            itemStyle : { normal: {color:'rgba(0,0,255,0.5)'}}, // 柱形颜色
            data: [5, 20, 36, 10, 10, 20]
        }]
    };

var echartOptionLine =  {
	    tooltip : {
	        trigger: 'axis'
	    },
	    legend: {
	        data:['邮件营销','联盟广告','视频广告','直接访问','搜索引擎']
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
	            data : ['周一','周二','周三','周四','周五','周六','周日'],
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
	            name:'邮件营销',
	            type:'line',
	            stack: '总量',
	            itemStyle : { normal: {color:'#999'}}, // 折线颜色
	            data:[120, 132, 101, 134, 90, 230, 210]
	        },
	        {
	            name:'联盟广告',
	            type:'line',
	            stack: '总量',
	            itemStyle : { normal: {color:'rgba(255,0,0,0.5)'}}, // 折线颜色
	            data:[220, 182, 191, 234, 290, 330, 310]
	        },
	        {
	            name:'视频广告',
	            type:'line',
	            stack: '总量',
	            itemStyle : { normal: {color:'rgba(255,0,0,0.5)'}}, // 折线颜色
	            data:[150, 232, 201, 154, 190, 330, 410]
	        },
	        {
	            name:'直接访问',
	            type:'line',
	            stack: '总量',
	            itemStyle : { normal: {color:'rgba(255,0,0,0.5)'}}, // 折线颜色
	            data:[320, 332, 301, 334, 390, 330, 320]
	        },
	        {
	            name:'搜索引擎',
	            type:'line',
	            stack: '总量',
	            itemStyle : { normal: {color:'rgba(255,0,0,0.5)'}}, // 折线颜色
	            data:[820, 932, 901, 934, 1290, 1330, 1320]
	        }
	    ],
	    //backgroundColor: '#000' // 设置图表背景颜色
	};
//var echartOption = ;

var gEchartSettings = [
                       {containerId: 'userStatisticsBar', option : echartOptionBar},
                       {containerId: 'userStatisticsLine', option : echartOptionLine},
                      ];
</script>