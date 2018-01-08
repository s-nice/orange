
//职能初始化
function jobInit(data, container){
	var xAxisData = [];
    var seriesData = [];
    var maxLength=10;
    for(var i=0;i<data.length;i++){
        var name=data[i].name;
        name.length > maxLength && (name = name.substring(0,maxLength)+'...');
    	xAxisData.push(name);
    	seriesData.push({name:data[i].count+str_360_zhang,value:data[i].count});
    }
    xAxisData.reverse();
    seriesData.reverse();
	var option = {
		title: {
            text: str_360_job_card,
            left: 'center',
            top: 15
        },
	    grid: {
	        left: '3%',
	        right: '10%',
	        bottom: '3%',
	        containLabel: true
	    },
	    yAxis: {
	        type: 'category',
	        data: xAxisData,
	        axisLine: {
	            show: false
	        },
	        axisTick: {
	            show: false,
	            alignWithLabel: true
	        },
	        axisLabel: {
	            textStyle: {
	                color: '#ffb069'
	            }
	        }
	    },
	    xAxis: [{
	        type: 'value',
	        axisLine: {
	            show: false
	        },
	        axisTick: {
	            show: false
	        },
	        axisLabel: {
	            show: false
	        },
	        splitLine: {
	            show: false
	        }
	    }],

	    series: [{
	        name: str_360_count,
	        type: 'bar',
	        data: seriesData,
	        barCategoryGap: '35%',
	        label: {
	            normal: {
	                show: true,
	                position: 'right',
	                formatter: function(params) {
	                    return params.data.name;
	                },
	                textStyle: {
	                    color: '#bcbfff' //color of value
	                }
	            }
	        },
	        itemStyle: {
	            normal: {
	                color: new echarts.graphic.LinearGradient(0, 0, 1, 0, [{
	                    offset: 0,
	                    color: '#ffb069' // 0% 处的颜色
	                }, {
	                    offset: 1,
	                    color: '#ec2e85' // 100% 处的颜色
	                }], false)
	            }
	        }
	    }]
	};
	
	var myChart = echarts.init(document.getElementById(container));
    myChart.setOption(option);
    bindEvt(myChart, 4);
}
//公司初始化
function companyInit(data, container){
	var xAxisData = [];
    var seriesData = [];

    for(var i=0;i<data.length;i++){
    	xAxisData.push(data[i].name);
    	seriesData.push({name:data[i].count+str_360_zhang,value:data[i].count});
    }
    
	var option = {
		title: {
            text: str_360_company_card,
            left: 'center',
            top: 15
        },
	    color: ['#3398DB'],
	    grid: {
	        height: '50%',
	        containLabel: true
	    },
	    xAxis : [{
            type : 'category',
            data : xAxisData,
            axisTick: {
                alignWithLabel: true
            },
            axisLabel: {
            	interval: 0,
            	rotate: rotate
            }
	    }],
	    yAxis : [{
	        type : 'value'
	    }],
	    series : [{
            name:str_360_count,
            type:'bar',
            barWidth: '60%',
            data:seriesData,
            label: {
	            normal: {
	                show: true,
	                position: 'top',
	                formatter: function(params) {
	                    return params.data.name;
	                },
	                textStyle: {
	                    color: '#bcbfff' //color of value
	                }
	            }
	        }
	    }]
	};

	var myChart = echarts.init(document.getElementById(container));
    myChart.setOption(option);
    bindEvt(myChart, 1);
}

//行业初始化
function industryInit(data, container){
    var xAxisData = [];
    var seriesData = [];

    for(var i=0;i<data.length;i++){
    	xAxisData.push(data[i].name);
    	seriesData.push({name:data[i].count+str_360_zhang,value:data[i].count});
    }
    
    function renderItem(params, api) {
    	var yValue = api.value(1);
        var start = api.coord([api.value(0), yValue]);
        var size = api.size([api.value(1) - api.value(0), yValue]);
        var style = api.style();
        return {
            type: 'rect',
            shape: {
                x: start[0]- size[0]/2+1,
                y: start[1],
                width: size[0] - 2,
                height: size[1]
            },
            style: style
        };
    }

    var option = {
        title: {
            text: str_360_industry_card,
            left: 'center',
            top: 15
        },
        /*
	    tooltip : {
	        trigger: 'axis',
	        axisPointer : {            // 坐标轴指示器，坐标轴触发有效
	            type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
	        }
	    },*/
        color: ['rgb(25, 183, 207)'],
        grid: {
            height: '50%',
            containLabel: true
        },
        xAxis: [{
        	data: xAxisData,
        	axisLabel: {
            	interval: 0,
            	rotate: rotate
            }
        }],
        yAxis: [{
            //type: 'value',
        }],
        series: [{
            name: 'height',
            type: 'custom',
            renderItem: renderItem,
            label: {
                normal: {
                    show: true,
                    position: 'insideTop',
                    formatter: function(params) {
	                    return params.data.name;
	                }
                }
            },
            data: seriesData
        }]
    };
    var myChart = echarts.init(document.getElementById(container));
    myChart.setOption(option);
    
    bindEvt(myChart, 2);
}
industryInit(dataJson['static_groups'][0]['results'], 'main1');
companyInit(dataJson['static_groups'][1]['results'], 'main2');
jobInit(dataJson['static_groups'][2]['results'], 'main3');

//事件绑定
function bindEvt(obj,type){
	obj.isDraging_=false;
	obj.on('mousedown', function(params){
		obj.isDraging_=true;
    });
	obj.on('mousemove', function(params){
		obj.isDraging_=false;
    });
	obj.on('mouseup', function(params){
    	if (obj.isDraging_){
        	//alert(listUrl+'?type='+type+'&typekwds='+encodeURIComponent(params.name));
    		location.href=listUrl+'?type='+type+'&typekwds='+encodeURIComponent(params.name);
        }
    });
}