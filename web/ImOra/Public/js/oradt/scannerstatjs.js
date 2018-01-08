;
// 生成下载模块
var hidForm = $('form[name="headForm"]').clone().attr({'style':'display:none','name':'headForm1'}).removeAttr('onsubmit');
$('body').append(hidForm);
$.each(hidForm.find('input'),function(i,dom){
	$(dom).removeAttr('id');
});
$('form[name="headForm1"]').append('<input name="download" type="hidden" value="download" />');
var gEchartSettings = '';

//切换日  月  周
$('.js_timeselect').on('click',function(){
	$('.js_timeselect').removeClass('active');
	$(this).addClass('active');
    var stattype = $(this).attr('val');
    $('form[name="headForm"]').find('input[name="stattype"]').val(stattype);
    // 切换年月日提交当前时间  $('.js_submit_form').trigger('click');
    // 切换年月日不提交当前时间
    $('#js_begintime').val('');
    $('#js_endtime').val('');
    $('form[name="headForm"]').submit();
    
});
// 切换标题 提交表单
$('.itemClass').on('click',function(){
	var $this = $(this);
	$($('input[name="item1"]')[0]).attr('val',$this.attr('val'));
	$('form[name="headForm"]').submit();
});
// 点击提交
$('.js_submit_form').on('click',function(){
    var  starttime  =  $('#js_begintime').val();
    var  endtime  =  $('#js_endtime').val();
    if(starttime == '' || endtime == ''){
        $.global_msg.init({gType:'warning',icon:2,msg:js_Empty_Time});
    }else{
    	$('form[name="headForm"]').submit();
    }
});
// 点击导出数据
$('#js_download').on('click',function(){
	$('form[name="headForm1"]').submit();
});
function getLineData(dataDict,name,xKey,colorKey){
//	if(typeof xKey == 'undefined'){
//		xKey = 'xKey';
//	}
	if(typeof colorKey == 'undefined'){
		colorKey = '0';
	}
	var x;
	var dataArr = [];
	for (x in xdata[xKey]){
		dataArr.push(dataDict[xdata[xKey][x]]);
	}
	chartSeries.push({
		type:'line',
        name: name,
        itemStyle : { normal: {color:colorList[colorKey]}}, // 折线颜色
        data: dataArr
    });
	dataTitle.push(name);
}

	// 组装折线图数据
	var chartSeries = [];
	var dataTitle = []; // 每天线的标题
	var xLineKey = 'duibi'; // X周对应xdata中的key值
	var i;
    var iNum=0;

	for(i in alldataArr){
		var dataDict = alldataArr[i];
		var j;
		for (j in dataDict){
			// 如果标题存在  是多条线  不存在对应的标题 则为单条线
			if(typeof formType[j] != 'undefined'){
				var name = i!=0?i+'-'+formType[j]:formType[j];
				getLineData(dataDict[j],name,'xKey',iNum); // 按系统平台以及分类画线
				iNum++;
			}else{
				var name = i!=0?i+'-'+getLineTitle:getLineTitle;
				getLineData(dataDict,name,'xKey',iNum); // 按系统平台画线
				iNum++;
				break;
			}
		}
	}
	// 指定图表的配置项和数据
	var echartOptionLine =  {
	    tooltip : {
	        trigger: 'axis',
	    },
	    legend: {
	        data:dataTitle,
	        top:470
	    },
	    grid: {
	        left: '3%',
	        right: '4%',
	        bottom: '8%',
	        containLabel: true
	    },
	    xAxis : [
	        {
	            type : 'category',
	            boundaryGap : false,
	            data : xdata['xData'],
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
	            interval:maxVal['interval'],
	            max:maxVal['max'],
	            splitNumber:maxVal['splitNumber'],
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
	    series : chartSeries,
	    //backgroundColor: '#000' // 设置图表背景颜色
	};
	//var echartOption = ;

	gEchartSettings = [
                       {containerId: 'userStatisticsLine', option : echartOptionLine},
                      ];
