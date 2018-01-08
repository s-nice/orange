$.extend(true,{
    orauserstatistic:{
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

        getTitle:function(){
            var title = $('#js_stat_type input').val();
            return title;
        },

        initPost:function(){
            //if(!$('.js_max_min').length){
                this.setPost();
            //}
        },

        bindEvent:function(){
            var _this = this;
            $('.js_sub_another').on('click',function(){
                _this.setPost();
                return false;
            });
        },
        //获取 要提交的字段JSON
        getPostJson:function(){
                var s_versions = $('input[name=s_versions]').val();
                var h_versions = $('input[name=h_versions]').val();
                var startTime = $('input[name=startTime]').val();
                var endTime = $('input[name=endTime]').val();
                var stat_type = $('#js_stat_type').find('input').attr('val');
                if(!s_versions){
                    $.global_msg.init({gType:'alert',time:3,icon:0,msg:'请选择软件版本'});
                    return false;
                }
                if(!h_versions){
                    $.global_msg.init({gType:'alert',time:3,icon:0,msg:'请选择硬件版本'});
                    return false;
                }
                if($('input[name=startTime]').length){
                    if(!startTime){
                        $('#js_begintime').focus();//开始时间
                        return false;
                    }
                }               
                if(!endTime){
                    $('#js_endtime').focus();//结束时间
                    return false;
                }
                var s_is_all = $('.js_i_s').is(':checked')?1:0;
                var h_is_all = $('.js_i_h').is(':checked')?1:0;
                var oJson = {s_versions:s_versions,h_versions:h_versions,endTime:endTime,stat_type:stat_type,s_is_all:s_is_all,h_is_all:h_is_all};
                if(startTime){
                    oJson.startTime = startTime;
                }
                if($('.js_max_min').length){
                    var minValue = $('input[name=minValue]').val();
                    var maxValue = $('input[name=maxValue]').val();
                    var rangeValue = $('input[name=rangeValue]').val();
                    var regMin = /^\d+$/;
                    var regMax = /^[1-9]\d*$/;
                    if(minValue==''){
                        $.global_msg.init({gType:'warning',icon:2,time:3,msg:'请填写最小值'});
                        return false;
                    }
                    if(!regMin.test(minValue)){
                        $.global_msg.init({gType:'warning',icon:2,time:3,msg:'最小值为不小于0的整数'});
                        return false;
                    }
                    if(maxValue==''){
                        $.global_msg.init({gType:'warning',icon:2,time:3,msg:'请填写最大值'});
                        return false;
                    }
                    if(!regMax.test(maxValue)){
                        $.global_msg.init({gType:'warning',icon:2,time:3,msg:'最大值为正整数'});
                        return false;
                    }
                    if(parseInt(maxValue)<=parseInt(minValue)){
                        $.global_msg.init({gType:'warning',icon:2,time:3,msg:'最大值应大于最小值'});
                        return false;
                    }
                    if(rangeValue==''){
                        $.global_msg.init({gType:'warning',icon:2,time:3,msg:'请填写区间段'});
                        return false;
                    }
                    if(!regMax.test(rangeValue)){
                        $.global_msg.init({gType:'warning',icon:2,time:3,msg:'区间段为正整数'});
                        return false;
                    }
                    if((parseInt(maxValue)-parseInt(minValue))%parseInt(rangeValue)){
                        $.global_msg.init({gType:'warning',icon:2,time:3,msg:'区间段不能平均划分'});
                        return false;
                    }
                    $.extend(oJson,{minValue:minValue,maxValue:maxValue,rangeValue:rangeValue},true);
                }
                if($('.js_stat_date_type').length){
                        var date_type = $('.js_stat_date_type a.on').index();
                        oJson.date_type = date_type;
                }
                if($('#js_child_type').length){
                        var child_type = $('#js_child_type').find('input').attr('val');
                        oJson.child_type = child_type;
                }
                return oJson;
        },

        //根据数据作图
        setEchart:function(data){
            var _this = this;
            list = JSON.parse(data);
            var stat_type = $('#js_stat_type').find('input').attr('val');
            var date,max=0,avg=0,arr=[],names=[];
            for (k in list) {
                date = list[k].date;
                names.push(k);
                var obj = {};
                var obj1 = {};
                obj.data = list[k].num;
                obj1.data = list[k].num;
                if(stat_type=='5'){
                    obj.name = k;
                    obj.type = 'bar';
                    arr.push(obj);
                }else if(stat_type=='4'){
                    obj.name = k;
                    obj.type = 'bar';
                    arr.push(obj);
                }else{
                    obj.name = k;
                    obj.type = 'line';
                    arr.push(obj);
                }
                for(j in list[k].num){
                    max = Math.max(max,list[k].num[j]);
                }
            };
            avg = Math.ceil(max/5);
            max = avg*6;
            var title = _this.getTitle();
            var x = [
                    {
                        type : 'category',
                        data : date,
                    }
                ];
            var y = [
                    
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
                    },

                ];
            var option = {
                tooltip : {
                    trigger: 'axis'
                },
                series : arr,
            }
            if(stat_type=='5'){
                option.xAxis = y;
                option.yAxis = x;
                if(arr[0].data.length){
                    option.grid = {x:150};
                }
            }else{
                option.xAxis = x;
                option.yAxis = y;
            }
            _this.myChart.hideLoading();
            _this.myChart.setOption(option);
        },
    }
});