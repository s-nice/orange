$.extend(true,{
	orauserstatistic:{

		//根据数据作图
        setEchart:function(data){
            var _this = this;
            list = JSON.parse(data);
            
            var date,max=0,avg=0,arr=[],max1=0,avg1=0,names=[];
            for (k in list) {
                date = list[k].date;
                names.push(k);
                var obj = {};
                obj.data = list[k].num;
                if($.inArray(k,['页面访问用户数','使用搜索功能的总用户数量','有搜索结果人数','点击搜索结果用户数','页面访问次数','使用次数','有搜索结果次数','点击搜索结果次数'])!='-1'){
                	obj.name = k;
                	obj.type = 'bar';
                	for(j in list[k].num){
	                    max1 = Math.max(max1,list[k].num[j]);
	                }
                }else{
                	obj.name = k;
                	obj.type = 'line';
                	obj.yAxisIndex=1;
                	for(j in list[k].num){
	                    max = Math.max(max,list[k].num[j]);
	                }
                }
                
                arr.push(obj);
            };
            //console.log(max,max1);
            avg = Math.ceil(max/5);
            max = avg*6;
            avg1 = Math.ceil(max1/5);
            max1 = avg1*6;
            var title = _this.getTitle();
            var option = {
                tooltip : {
                    trigger: 'axis',
                    formatter:function(params,ticket,callback){
                        var str = '';
                        for (var i = 0; i < params.length; i++) {
                            if(i==0){
                                str += params[i]['name']+'<br />';
                            }
                            str += params[i]['seriesName']+':'+params[i]['value'];
                            if(params[i]['seriesType']=='line'){
                                str += '%';
                            }
                            str += '<br />';
                        };
                        return str;
                    },
                },
                legend: {
                    data:names,
                },
                xAxis : [
                    {
                        type : 'category',
                        data : date,
                    }
                ],
                yAxis : [
                    
                    {
                        type : 'value',
                        max : max1,
                        splitNumber: 6,
                        interval: avg1,
                        splitLine: {
                            show:true,
                            lineStyle: {
                                // 使用深浅的间隔色
                                color: ['#ddd'],
                                type : 'dashed'
                            }
                        }
                    },
                    {
                        type : 'value',
                        max : max,
                        splitNumber: 6,
                        interval: avg,
                        splitLine: {
                            show:true,
                            lineStyle: {
                                // 使用深浅的间隔色
                                color: ['#ddd'],
                                type : 'dashed'
                            }
                        },
                        axisLabel : {
			                formatter: '{value}%'
			            }
                    }

                ],
                series : arr,
            }
            /*if(isPropor){
                option.yAxis[0].axisLabel={formatter:'{value} %'};
            }*/
            //myChart = echarts.init(document.getElementById('userStatisticsLine'));
            _this.myChart.hideLoading();
            _this.myChart.setOption(option);
        },

        getTitle:function(){
            var title = $('#js_stat_type input').val();
            return title;
        },

        init:function(){
            var _this = this;
            var title = _this.getTitle();
            var option = {
                series : [],
                color:colorlist,
            }
            _this.myChart = echarts.init(document.getElementById('userStatisticsLine'));
            _this.myChart.setOption(option);
            
        },
	}
});