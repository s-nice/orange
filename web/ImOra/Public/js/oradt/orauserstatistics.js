$.extend({
	orauserstatistic:{
        myChart:null,
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
                    var dt = $('.js_stat_date_type a.on').index();
                    var url = selfUrl+'/t/'+val;
                    url += '/startTime/'+startTime+'/endTime/'+endTime+'/dt/'+dt+'/ft/'+ft;
            		window.location.href = url;
            	}else{
                    _this.setPost();
                }
            });

            $('.js_stat_date_type').on('click','a',function(){
            	$(this).addClass('on').siblings().removeClass('on');
                var date_type = $(this).index();
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
                $('.js_s_div>ul').hide();
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
            _this.init();
            _this.initPost();
            _this.bindEvent();
		},
        initPost:function(){
            this.setPost();
        },
        bindEvent:function(){

        },
        init:function(){
            var _this = this;
            var title = _this.getTitle();
            var option = {
                title : {
                    text: title+'/时间',
                    textStyle : { color:'#333',fontSize:14,fontWeight:100}
                },
                legend: {
                   // data:titleList//['邮件营销','联盟广告','视频广告','直接访问','搜索引擎']
                },
                tooltip : {
                    trigger: 'axis'
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
                        data : [],
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
                        splitNumber: 6,
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
                series : [],
                color:colorlist,
            }
            _this.myChart = echarts.init(document.getElementById('userStatisticsLine'));
            _this.myChart.setOption(option);
            
        },

        getTitle:function(){
            var title = $('#js_stat_type input').val();
            if($('#js_child_type').length){
                title = $('#js_child_type input').val();
            }
            return title;
        },

		setPost:function(){
            var _this = this;
            var oJson = _this.getPostJson();
            if(oJson){
                _this.myChart.showLoading();
                _this.postJson(oJson);
            }
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
                if($('input[name=endTime]').length){
                    if(!endTime){
                        $('#js_endtime').focus();//结束时间
                        return false;
                    }
                }
                var s_is_all = $('.js_i_s').is(':checked')?1:0;
                var h_is_all = $('.js_i_h').is(':checked')?1:0;
                var oJson = {s_versions:s_versions,h_versions:h_versions,startTime:startTime,stat_type:stat_type,s_is_all:s_is_all,h_is_all:h_is_all};
                if(endTime){
                    oJson.endTime = endTime;
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
		postJson:function(oJson){
            var _this = this;
            $.post(postUrl,oJson,function(result){
                if(result.status==0){
                    //修改表格标题
                    var title = _this.getTitle();
                    $('#js_table_title').text(title);
                    //绘制图形
                    _this.setEchart(result.data);
                    //如果无数据隐藏导出
                    if(result.count>0){
                        $('#js_export').show();
                    }else{
                        $('#js_export').hide();
                    }
                    //绘制表格，如果条数过多，增加滚动
                    $('#js_table_content').html('<div class="scroll_div"></div>');
                    $('#js_table_content .scroll_div').html(result.tpl);
                    if($('#js_table_content .scroll_div .content_list').height()>430){  
                        $('#js_table_content .scroll_div .content_list').mCustomScrollbar({
                            theme:"dark", //主题颜色
                            set_height:430,
                            autoHideScrollbar: false, //是否自动隐藏滚动条
                            scrollInertia :0,//滚动延迟
                            horizontalScroll : false,//水平滚动条
                        });
                    }
                    if(result.timeError=='1'){
                        $.global_msg.init({gType:'alert',time:3,icon:0,msg:'时间选择需包含至少一个周期'});
                        //return false;
                    }
                }
            });
        },
        mapInit:function(){
            var _this = this;
            //数据列表 滚动条
            _this.ScrollBarfunc('#js_scroll_dom');
            //点击区域外关闭此下拉框
            $(document).on('click',function(e){
                if(!$(e.target).parents('.js_se_div').length){
                    $('.js_se_div>ul').hide();
                }
            });
            //搜索种类下拉
            $('.js_se_div').on('click',function(e){
                $(this).find('ul').toggle();
            });
            //点击制图类型下拉框跳转
            $('.js_se_div').on('click','li',function(e){
                var oDiv = $(this).parents('.js_se_div');
                var val = $(this).attr('val');
                var text = $(this).text();
                oDiv.find('input[type=text]').val(text).attr('val',val);
                if(oDiv.attr('id')!=='js_stat_type'){
                    window.location.href = selfUrl+'/t/9/ct/'+val;
                }else{
                    window.location.href = selfUrl+'/t/'+val;
                }
            });
            //统计周期
            $('.js_stat_date_type').on('click','a',function(){
                $(this).addClass('on').siblings().removeClass('on');
                //提交
                _this.mapSubmit(0);
            });
            //点击提交
            $('.submit_button').on('click',function(){
                //提交
                _this.mapSubmit(1);
                return false;
            });

        },
        //地图统计 提交搜索
        mapSubmit:function(_type){
            var s_versions = '';
            if($('.js_proversion ul li[val=all] input').prop('checked')==false){
                s_versions = $('input[name=s_versions]').val();
                if(s_versions) s_versions = '/s_versions/'+s_versions;
            }
            var h_versions = '';
            if($('.js_modelversion ul li[val=all] input').prop('checked')==false){
                h_versions = $('input[name=h_versions]').val();
                if(h_versions) h_versions = '/h_versions/'+h_versions;
            }

            if(_type==1){
                var startTime = $('input[name=startTime]').val();
                if(startTime) startTime = '/startTime/'+startTime;
                var endTime = $('input[name=endTime]').val();
                if(endTime)  endTime = '/endTime/'+endTime;
            }


            var child_type = $('#js_child_type').find('input').attr('val');
            var date_type = $('.js_stat_date_type a.on').index();
            var getcondition = '/t/9/ct/'+child_type+'/dt/'+date_type+s_versions+h_versions;
            if(_type==1) getcondition+=startTime+endTime;

            window.location.href = selfUrl+getcondition;

        },
        /*滚动条*/
        ScrollBarfunc: function (_dom) {
            var scrollObjs = $(_dom);

            scrollObjs.mCustomScrollbar({
                theme:"dark", //主题颜色
                autoHideScrollbar: false, //是否自动隐藏滚动条
                scrollInertia :0,//滚动延迟
                height:50,
                horizontalScroll : false//水平滚动条
            });
        },

        //根据数据作图
        setEchart:function(data){
            var _this = this;
            list = JSON.parse(data);
            var stat_type = $('#js_stat_type').find('input').attr('val');
            var date=[],max=0,avg=0,arr=[];
            for (k in list) {
                date = list[k].date;
                var obj = {};
                obj.name = k;
                obj.type = 'line';
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
                xAxis : [
                    {
                        type : 'category',
                        boundaryGap : false,
                        data : date,
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
                ],
                series : arr,
            }
            if(stat_type=='3'||stat_type=='10'||stat_type=='8'){
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
            _this.myChart.hideLoading();
            _this.myChart.setOption(option);
        },

	}
});
			
