
var lineColorsList = {:json_encode(C('STAT_CHART_LINE_COLORS'))};
var gStatisticDateType = "{$timeType[0]}";
<php>
$xAxisData = array();
$stats = array();
$maxYAxis = 0;
</php>
<volist name="statsList" id="_stat">
<php>
if ('week'==$timeType) {
   $_stat['enter_time'] = date('o-\WW', strtotime($_stat['enter_time']));
}
$tmpKey = date($timeFormat, strtotime($_stat['enter_time']));
$xAxisData[$tmpKey] = $tmpKey;
$maxYAxis = floatval($maxYAxis) > floatval($_stat['count_all']) ? $maxYAxis : $_stat['count_all'];
$stats[] = floatval($_stat['count_all']);
</php>

</volist>
var xAxisData = {:json_encode(array_keys($xAxisData))};
var maxYAxis = "{:floatval($maxYAxis)}";
var yAxisInfo = paramsForGrid(maxYAxis);//return {max:max, interval:interval, splitNumber:splitNumber};
// 指定图表的配置项和数据
var echartOptionLine =  {
	title: {
	//	text: sheetTitle
	},
	    tooltip : {
	        trigger: 'axis'
	    },
	    legend: {
           left: 'center',
           bottom: '0',
           selectedMode:false,
	       data:[sheetTitle]
	    },
	    grid: {
	        left: '3%',
	        right: '4%',
	        bottom: '8%',
	        top   : '3%',
	        containLabel: true
	    },
	    xAxis : [
	        {
	            type : 'category',
	            boundaryGap : false,
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
	            	show:false,
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
                max : yAxisInfo.max,
                splitNumber: yAxisInfo.splitNumber,
                interval: yAxisInfo.interval,
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
	            name:sheetTitle,
	            type:'line',
	            itemStyle : { normal: {color:lineColorsList.shift()}}, // 折线颜色
	            data:{:json_encode($stats)}
	        }
	    ]
	};

var gEchartSettings = [
                       {containerId: 'userStatisticsLine', option : echartOptionLine}
                      ];