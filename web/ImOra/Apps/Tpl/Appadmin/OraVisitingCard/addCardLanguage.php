<!--累计名片语言分布-->
<layout name="../Layout/Layout"/>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="form_margintop">
                <form name="headForm" action="{:U('OraStatCard/index','','',true)}" method="get"
                      onsubmit="if(typeof (submitFun)!='undefined'){return submitFun(this);}">
                    <div class="content_search">
                        <div class="search_right_c">
                            <div class="select_time_c">
                                <span>{$T->str_time}</span>
                                <!-- 是否只有截至时间 -->
                                <if condition="$startStopTime != 'stop'">
                                    <div class="time_c">
                                        <input id="js_begintime" class="time_input" type="text" name="startTime"  readonly="readonly" value="{$startTime}" />
                                        <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                                    </div>
                                    <span>--</span>
                                </if>
                                <div class="time_c">
                                    <input id="js_endtime" class="time_input" type="text" name="endTime" readonly="readonly" value="{$endTime}" />
                                    <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                                </div>
                            </div>
                            <input class="submit_button" type="submit" value="{$T->str_submit}"/>
                        </div>
                    </div>
                    <!-- 小标题 -->
                    <div id="js_selectitem_div" class="select_xinzeng margin_top">
                        <input id="itemKeyNow" type="text" >
                        <i><img src="/images/appadmin_icon_xiala.png"></i>
                        <ul></ul>
                    </div>
                    <!---->
                    <span style="float:left;margin:25px 6px 0 6px;font-size:14px;">名片来源</span>
                    <div class="select_xinzeng margin_top js_s_div">
                        <input type="text"
                        <if condition="$params['source'] neq '' " > value='{$source['list'][$params['source']]['name']}'<else/> value='全部'</if>/>
                        <i><img src="/images/appadmin_icon_xiala.png"></i>
                        <input type="hidden" name="source" <if condition="$params['source'] neq ''" >value="{$params['source']}"</if>/>
                        <ul>
                            <foreach name="source['list']" item="j">
                                <a href="{:U('Appadmin/'.CONTROLLER_NAME.'/'.ACTION_NAME ,array('endTime'=>$params['endTime'],source=>$j['val'],'itemKey'=>$itemKey),'','',true)}">
                                    <li>{$j['name']}</li>
                                </a>
                            </foreach>
                        </ul>
                    </div>
                    <!-- 1日3日周月 -->
                    <if condition="isset($statTypeArr)">
                        <div class="js_stat_date_type">
                            <input readonly="readonly" name="stattype" type="hidden" value="{$stattype}" />
                            <foreach name="statTypeArr" key="k" item="v">
                                <a class="js_stattype <if condition="$k == $stattype">on</if>" val="{$k}"
                    href="{:U('Appadmin/'.CONTROLLER_NAME.'/'.ACTION_NAME,
                    array('endTime'=>$params['endTime'],
                    'startTime'=>$params['startTime'],
                    's_versions'=>$params['s_versions'],
                    'h_versions'=>$params['h_versions'],
                    'date_type'=>$k,
                    'itemKey'=>$itemKey))}">{$v}
                    </a>
                    </foreach>
            </div>
            </if>
            </form>
            </div>
            <!--图表放置-->
            <div id="userStatisticsLine" style="width:820px;height:500px;overflow:hidden;">
            </div>
            <div id="userStatisticsData">
                <div class="Data_bt">
                    <span class="left_s">{$selectArr[$itemKey]['name']}数据表</span>
                    <if condition="count($tableArr) gt 0">
                        <a href="{:U('Appadmin/'.CONTROLLER_NAME.'/'.ACTION_NAME,
            			array('download'=>1,'endTime'=>$params['endTime'],source=>$params['source'],'itemKey'=>$itemKey))}"><button class="right_down" id="js_download" style="cursor: pointer;">{$T->str_export}</button></a>
                    </if>
                </div>
                <div class="table_content" style="overflow:visible;">
                    <div>
                        <div class="table_list table_tit">
                            <span class="span_t3">日期</span>
                            <span class="span_t3">中文简体</span>
                            <span class="span_t3">中文繁体</span>
                            <span class="span_t3">英语</span>
                            <span class="span_t3">日语</span>
                            <span class="span_t3">俄语</span>
                            <span class="span_t3">其他</span>
                        </div>
                        <div class="clear" id="js_scroll_dom" style="max-height:438px;">
                            <if condition="count($tableArr) gt 0">
                                <foreach name="tableArr" item="v">
                                    <div class="table_list">
                                        <span class="span_t3">{$v.time}</span>
                                        <span class="span_t3">{$v.num}</span>
                                        <span class="span_t3">{$v.num1}</span>
                                        <span class="span_t3">{$v.num2}</span>
                                        <span class="span_t3">{$v.num3}</span>
                                        <span class="span_t3">{$v.num4}</span>
                                        <span class="span_t3">{$v.num5}</span>

                                    </div>
                                </foreach>
                                <else />
                                No Data
                            </if>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <script type="text/javascript">
                $(function(){
                    function checkAll(oDom){
                        var isAll = true;
                        var boxs = oDom.find('input[type=checkbox]');
                        $.each(boxs,function(k,v){
                            if(k){
                                if(!$(this).is(':checked')){
                                    isAll = false;
                                }
                            }
                        });
                        boxs.eq(0).prop('checked',isAll);
                    }
                    function getCheckValue(oDom){
                        var boxs = oDom.find('input[type=checkbox]');
                        var arr = [];
                        $.each(boxs,function(k,v){
                            if(k){
                                if($(this).is(':checked')){
                                    arr.push($(this).val());
                                }
                            }
                        });
                        var str = arr.join(',');
                        oDom.find('input[type=hidden]').val(str);
                    }
                    //点击区域外关闭此下拉框
                    $(document).on('click',function(e){
                        if(!$(e.target).parents('.js_s_div').length){
                            $('.js_s_div>ul').hide();
                        }
                    });
                    $('.js_s_div').on('click',function(e){
                        if(!$(e.target).parents('ul').length){
                            $(this).find('ul').toggle();
                        }
                    });

                    $('.js_s_div').on('click','input[type=checkbox]',function(){
                        var index = $(this).parent('li').index();
                        if(index){
                            checkAll($(this).parents('.js_s_div'));

                        }else{

                            $(this).parents('.js_s_div').find('input[type=checkbox]').prop('checked',$(this).is(':checked'));
                        }
                        getCheckValue($(this).parents('.js_s_div'));
                    })
                    $.dataTimeLoad.init();
                    $.each($('.js_s_div'),function(){
                        checkAll($(this));
                    })
                });
            </script>
            <!-- 页面内容 -->
            <script type="text/javascript">
                $(function(){
                    $('.js_scroll_list').mCustomScrollbar({
                        theme:"dark", //主题颜色
                        autoHideScrollbar: false, //是否自动隐藏滚动条
                        scrollInertia :0,//滚动延迟
                        horizontalScroll : false,//水平滚动条
                    });

                    $('#js_selectitem_div').selectPlug({
                        getValId: 'itemKey',
                        defaultVal: '{$itemKey}',
                        liValAttr: 'item',
                        dataSet:{:json_encode($selectArr)}
                });
                    // 生成下载模块
                    var hidForm = $('form[name="headForm"]').clone().attr({'style':'display:none','name':'headForm1'}).removeAttr('onsubmit');
                    $('body').append(hidForm);
                    $.each(hidForm.find('input'),function(i,dom){
                        $(dom).removeAttr('id');
                    });
                    $('form[name="headForm1"]').append('<input name="download" type="hidden" value="download" />');
                });
                // 切换小标题 刷新页面
                $('#js_selectitem_div').on('click','li',function(){
                    var olditem="{:$itemKey}";
                    var newitem=$(this).attr('item');

                    if(newitem != olditem){
                        var betweenArr=<?php  echo $betweenArr ?>;//需要查询开始结束时间的页面
                        betweenArr=betweenArr.split(',');
                        console.log(betweenArr);
                        console.log($.inArray(olditem,betweenArr),$.inArray(newitem,betweenArr));
                        var url="{:U('OraStatCard/index','','',true)}" +'?itemKey='+$(this).attr('item');
                        if(($.inArray(olditem,betweenArr)== -1) && ($.inArray(newitem,betweenArr)== -1) ){
                            //都为查询累计 只查询结束时间
                            console.log($('#js_endtime').val());
                            url+='&endTime='+$('#js_endtime').val();
                        }else if($.inArray(olditem,betweenArr)!= -1 && $.inArray(newitem,betweenArr)!= -1) {
                            //都为区间时间查询 开始结束时间
                            url+='&startTime='+$('#js_starttime').val() +'&endTime='+$('#js_endtime').val();
                            if(($('#js_begintime').val()=='' ^ $('#js_endtime').val()=='')){
                                $.global_msg.init({gType: 'warning', icon: 2, msg: "请正确选择时间"});
                                return false;
                            }
                        }else{ //两个页面不相同 时间参数不带入
                            url="{:U('OraStatCard/index','','',true)}"
                                +'?itemKey='+$(this).attr('item');
                        }
                        window.location.href=url;
                    }
                });

                var js_Empty_Time = '{$T->tip_select_time}'; // 请选择时间
                var colorList = {:json_encode(C('STAT_CHART_LINE_COLORS'))}; // 曲线颜色
                // 曲线最大值决定纵轴最大值
                <include file="@Layout/js_stat_widget" />
                var maxVal = paramsForGrid('800');
            </script>
    <script type="text/javascript">
        var name = "{$selectArr[$itemKey]['name']}";
        var gXdata = <?php echo $line_x ;?>;
        var gYdata = <?php echo $line_x_val; ?>;
        var gMaxVal="{$maxVal}";
        function getMaxVal(num) {
            var val = 10;
            if (num > 10) {
                val = Math.ceil(num / 10) * 10

            }
            return val
        }

        $(function(){
            var scrollObjs = $('#js_scroll_dom');
            scrollObjs.mCustomScrollbar({
                theme:"dark", //主题颜色
                autoHideScrollbar: false, //是否自动隐藏滚动条
                scrollInertia :0,//滚动延迟
                height:50,
                horizontalScroll : false//水平滚动条
            });
            gMaxVal= getMaxVal(gMaxVal);//坐标Y轴最大值 小于10的 整数
            /*配置图表*/
            var myChart = echarts.init(document.getElementById('userStatisticsLine'));
            myChart.showLoading({
                text: '正在努力的读取数据中...',
            });
            var option = {
                tooltip: {
                    trigger: 'axis'
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },
                xAxis: {
                    type: 'category',
                    boundaryGap: false,
                    data:gXdata
                },
                yAxis: {
                    max:gMaxVal, //最大刻度/
                    splitNumber:6,//分5个断（6个刻度）
                    minInterval: 1,	//	保证分科刻度为整数
                    type: 'value'
                },
                series: [
                    {
                        name: name,
                        type: 'line',
                        data:gYdata
                    }

                ]
            };
            myChart.setOption(option);
            // 数据整理完毕
            myChart.hideLoading();
        });
    </script>
