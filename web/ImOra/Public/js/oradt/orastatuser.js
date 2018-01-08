$.extend(true,{
	orauserstatistic:{
        stat_type:'',
        index:function(){
            //点击区域外关闭此下拉框
            var _this = this;
            $(document).on('click',function(e){
                if(!$(e.target).parents('.js_s_div').length){
                    $('.js_s_div>ul').hide();
                }
            });
            //搜索种类下拉
            $('.js_se_div').on('click',function(e){
                $(this).find('ul').toggle();
            });
            //点击第一个 下拉框跳转
            $('.js_se_div').on('click','li',function(e){
                //下拉框选中样式
                $(this).addClass('on').siblings().removeClass('on');
                var ft = $('#js_stat_type input').attr('val');
                var oDiv = $(this).parents('.js_se_div');
                var val = $(this).attr('val');
                var text = $(this).text();
                var oInput = oDiv.find('input[type=text]');
                //return false;
                oInput.val(text).attr('val',val);
                if(oDiv.attr('id')=='js_stat_type'){
                    var startTime = $('input[name=startTime]').val();
                    var endTime = $('input[name=endTime]').val();
                    var dt = $('.js_stat_date_type a.on').attr('val');
                    var url = selfUrl+'/t/'+val;
                    url += '/startTime/'+startTime+'/endTime/'+endTime+'/dt/'+dt+'/ft/'+ft;
                    window.location.href = url;
                }else{
                    _this.setPost();
                }
            });

            $('.js_stat_date_type').on('click','a',function(){
                $(this).addClass('on').siblings().removeClass('on');
                var date_type = $(this).attr('val');
                $.get(tabUrl,{date_type:date_type},function(result){
                    if(result.status==0){
                        $('#js_begintime').val(result.data.startTime);
                        $('#js_endtime').val(result.data.endTime);
                        $.dataTimeLoad.init({statistic:result.data.statisticType});
                        _this.setPost();
                    }
                })
            });
            //点击提交
            $('.submit_button').on('click',function(){
                _this.setPost();
                return false;
            });

            //点击导出
            $('#js_export').on('click',function(){
                var oJson = _this.getPostJson();
                if(oJson){
                    $.form(postUrl,oJson).submit();
                }
            });
            _this.stat_type = $('#js_stat_type').find('input').attr('val');
            if(_this.stat_type !='11'){
                _this.init();
            }
            _this.initPost();
            _this.bindEvent();
            
        },

        setPost:function(){
            var _this = this;
            var oJson = _this.getPostJson();
            if(oJson){
                if(_this.stat_type !='11'){
                    _this.myChart.showLoading();
                }
                _this.postJson(oJson);
            }
        },
		//获取 要提交的字段JSON
        getPostJson:function(){
                var platform = ($('input[name=platform]').length)?$('input[name=platform]').val():'';
                var s_versions = ($('input[name=s_versions]').length)?$('input[name=s_versions]').val():'';
                var province = ($('input[name=choose_area]').length)?$('input[name=choose_area]').val():'';
                var channel = ($('input[name=choose_from]').length)?$('input[name=choose_from]').val():'';
                var startTime = $('input[name=startTime]').val();
                var endTime = $('input[name=endTime]').val();
                var stat_type = $('#js_stat_type').find('input').attr('val');
                if($('input[name=startTime]').length){
                    if(!startTime){
                        $('#js_begintime').focus();//开始时间
                        return false;
                    }
                }
                if($('input[name=endTime]').length){
                    if(!endTime){
                        $('#js_endtime').focus();//结束时间
                        return false;
                    }
                }
                var sys_is_all = $('.js_i_sys').is(':checked')?1:0;//系统平台
                var s_is_all = $('.js_i_s').is(':checked')?1:0;//软件版本
                var f_is_all = $('.js_i_f').is(':checked')?1:0;//渠道
                var a_is_all = $('.js_i_a').is(':checked')?1:0;//省份
                var oJson = {s_versions:s_versions,platform:platform,channel:channel,province:province,startTime:startTime,stat_type:stat_type,s_is_all:s_is_all,sys_is_all:sys_is_all,f_is_all:f_is_all,a_is_all:a_is_all};
                if(endTime){
                    oJson.endTime = endTime;
                }
                if($('.js_stat_date_type').length){
                        var date_type = $('.js_stat_date_type a.on').attr('val');
                        oJson.date_type = date_type;
                }
                if($('#js_child_type').length){
                        var child_type = $('#js_child_type').find('input').attr('val');
                        oJson.child_type = child_type;
                }
                return oJson;
        },

        setEchart:function(data){
            var _this = this;
            list = JSON.parse(data);
            var stat_type = $('#js_stat_type').find('input').attr('val');
            var date=[],max=0,avg=0,arr=[];
            for (k in list) {
                date = list[k].date;
                var obj = {};
                obj.name = k;
                if(stat_type=='7'){
                    obj.type = 'bar';
                }else{
                    obj.type = 'line';
                }
                obj.data = list[k].num;
                for(j in list[k].num){
                    max = Math.max(max,list[k].num[j]);
                }
                arr.push(obj);
            };
            avg = Math.ceil(max/5);
            max = avg*6;
            var title = _this.getTitle();
            var option = {
                title : {
                    text: title+'/时间',
                    textStyle : { color:'#333',fontSize:14,fontWeight:100}
                },
                series : arr,
            }
            var x = [
                    {
                        type : 'category',
                        //boundaryGap : false,
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
                        }
                    }
                ];
            if(stat_type=='7'){
                option.xAxis = y;
                option.yAxis = x;
                option.title.text = title+'/数量';
            }else{
                option.xAxis = x;
                option.yAxis = y;
            }
            if(stat_type=='9'||stat_type=='8'){
                option.yAxis[0].axisLabel={
                    formatter:function(value){
                        var totalsec = Math.floor(value/1000);
                        var min = Math.floor(totalsec/60);
                        min = min?min:'00';
                        var sec = (totalsec%60);
                        sec = (sec<10)?('0'+sec):sec;
                        return min+':'+sec;
                    }
                };
                option.tooltip = {
                    trigger: 'axis',
                    formatter:function(params,ticket,callback){
                        var totalsec = Math.floor(params[0]['value']/1000);
                        var min = Math.floor(totalsec/60);
                        min = min?min:'00';
                        var sec = (totalsec%60);
                        sec = (sec<10)?('0'+sec):sec;
                        var str = '';
                        str += params[0]['name']+'<br />';
                        str += params[0]['seriesName']+':'+min+':'+sec;
                        return str;
                    },
                }
            }
            console.log(option);
            if(stat_type!='11'){
                _this.myChart.hideLoading();
                _this.myChart.setOption(option);
            }
        },
	}
});