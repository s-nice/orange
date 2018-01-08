<layout name="../Layout/Layout"/>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
        	<div class="form_margintop">
	            <div class="content_search">
	                <div class="search_right_c">
	                    <div class="select_IOS js_select_item" id="js_selectIOS">
	                        <if condition="$oneSelect eq 'all'">
                                <input type="text" value="{$T->stat_sys_platform}" title="{$T->stat_sys_platform}" seltitle="all"/>
                                <else/>
                                <input type="text" value="{$oneSelect}" title="{$oneSelect}" seltitle="{$oneSelect}"/>
	                        </if>
	
	                        <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	                        <ul id="js_selectIOSul" style="height:99px;">
                                <li title="all">{$T->stat_sys_platform}</li>
	                            <li title="IOS">IOS</li>
	                            <li title="Android">Android</li>
	                            <li title="Leaf">Leaf</li>
	                        </ul>
	                    </div>
	                    <!--                    <div class="select_sketch">-->
	                    <!--                        <input type="text" value="渠道" />-->
	                    <!--                        <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>-->
	                    <!--                        <ul>-->
	                    <!--                            <li title="渠道">渠道</li>-->
	                    <!--                            <li title="渠道一">渠道一</li>-->
	                    <!--                            <li title="渠道二">渠道二</li>-->
	                    <!--                        </ul>-->
	                    <!--                    </div>-->
                        <div class="select_time_c">
                            <span class="span_name">{$T->str_time_step}</span>
                            <div class="time_c">
                                <input id="js_begintime" class="time_input" type="text" name="start_time" readonly="readonly" value="{$startTime}" />
                                <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            </div>
                            <span>--</span>
                            <div class="time_c">
                                <input id="js_endtime" class="time_input" type="text" name="end_time" readonly="readonly" value="{$endTime}"/>
                                <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            </div>
                            <!-- <input class="time_button" type="button" value="{$T->str_contrast_time}" id="js_contrast"/> -->
                            <!--判断是否显示对比时间弹框   如果对比时间有值  则显示-->
                            <if condition="$conStart neq '' || $conEnd neq ''">
                                <div class="time_duibi" style="width: 220px;display: block" id="js_time_duibi">
                            <else/>
                                 <div class="time_duibi" style="width: 220px;" id="js_time_duibi">
                            </if>
                                <div class="time_c">
                                    <input id="js_begintime1" class="time_input" type="text" name="lstart_time" value="{$conStart}"/>
                                    <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                                </div>
                                <span>--</span>
                                <div class="time_c time_right">
                                    <input id="js_endtime1" class="time_input" type="text" name="lend_time" value="{$conEnd}"/>
                                    <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                                </div>
                                <input class="js_submit_duibi timeduibi_button" type="button" value="{$T->str_start_contrast}" id="js_contrast_time"/>
                            </div>
                        </div>
                        <input class="submit_button_c" type="button" value="{$T->str_submit}" id="js_search"/>
	                </div>
	            </div>
	            <div class="select_xinzeng margin_top js_select_item">
	                <input type="text" value="{$secondSelect}" id="js_secondselect" title="{$secondSelect}"/>
	                <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	                <ul id="js_secondselectul" style="height: 100px">
                        <!-- <li title="{$T->str_publish_question_number}">{$T->str_publish_question_number}</li> -->
	                    <li title="{$T->str_save_user_number}">{$T->str_save_user_number}</li>
	                    <li title="{$T->str_comment_user_number}">{$T->str_comment_user_number}</li>
	                    <li title="{$T->str_share_user_number}">{$T->str_share_user_number}</li>
	                    <li title="{$T->str_share_number}">{$T->str_share_number}</li>
	                </ul>
	            </div>
	            <!-- 资讯，问答子选项
	            <div class="select_xinzeng margin_top js_select_item">
	                <input type="text" value="{$thirdSelect}" id="js_thirdselect" title="{$thirdSelect}"/>
	                <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	                <ul id="js_thirdselectul" style="height: 75px">
	                    <li title="{$T->str_search_all}">{$T->str_search_all}</li>
	                    <li title="{$T->str_show_news}">{$T->str_show_news}</li>
	                    <li title="{$T->str_show_asks}">{$T->str_show_asks}</li>
	                </ul>
	            </div> -->
	            <div class="js_stat_date_type">
                    <a class="{:$statType=='d'?'on':''}" val='d'>{$T->str_day}</a>
                    <a class="{:$statType=='w'?'on':''}" val='w'>{$T->str_week}</a>
                    <a class="{:$statType=='m'?'on':''}" val='m'>{$T->str_month}</a>
				</div>
			</div>
            <!--            <div id="userStatisticsBar" style="width:820px;height:500px; margin-bottom:20px" class=""></div>-->
            <div id="userStatisticsLine" style="width:820px;height:500px;" class=""></div>
            <div id="userStatisticsData" class="">
                <div class="Data_bt Data_bt_top"><span class="left_s">{$secondSelect}</span>
                    <if condition="count($noZeroData) neq 0">
                        <span class="right_s" id="js_download" style="cursor: pointer;"><a href="{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/orangeShowAnalysis',array('appType'=>$oneSelect,'selecttype'=>$secondSelect,'thirdtype'=>$thirdSelect,'startDate'=>$startTime,'endDate'=>$endTime,'download'=>1))}" >{$T->stat_export}</a></span>
                    </if>

                </div>
                <div class="Data_c_content">
                    <div class="Data_c_name">
                        <span class="span_c_1" style='width:135px;'>{$T->stat_date}</span>
                        <span class="span_c_1" style='width:135px;'>{$T->stat_sys_platform}</span>
                        <span class="span_c_1" style='width:135px;'>{$T->str_share_number_inside_count}</span>
                        <span class="span_c_1" style='width:135px;'>{$T->str_share_number_inside_percent}</span>
                        <span class="span_c_1" style='width:135px;'>{$T->str_share_number_outside_count}</span>
                        <span class="span_c_2" style='width:135px;'>{$T->str_share_number_outside_percent}</span>
                    </div>
                   <div class="js_c_content">
                    <if condition="count($noZeroData) gt 0">
                        <volist name="userStats" id="_userStat">
                            <if condition="$_userStat.total_count neq 0">
                            <div class="Data_c_list">
                                <span class="span_c_1" style='width:135px;'>{$_userStat.date1}</span>
                                <span class="span_c_1" style='width:135px;'>{$_userStat.sys_platform}</span>
                                <span class="span_c_1" style='width:135px;'>{$_userStat.inside_count}</span>
                                <span class="span_c_1" style='width:135px;'>{$_userStat.inside_percent}</span>
                                <span class="span_c_1" style='width:135px;'>{$_userStat.outside_count}</span>
                                <span class="span_c_2" style='width:135px;'>{$_userStat.outside_percent}</span>
                            </div>
                            </if>
                        </volist>
                        <else/>
                        No Data
                    </if>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type='text/javascript'>
    <include file="@Layout/js_stat_widget" />
    var gStatisticDateType = "{$statType}";
    var jsSearchLink = "{:U('Appadmin/BeAnalysis/orangeShowAnalysis','','','',true)}";
    var jssecondselect = "{$secondSelect}";
    var alldata = '{$lineStats}';
    var jsInsertContrastTime = '{$T->str_insert_contrast_time}'; //请填写对比时段
    var jsCardTempUseNum = '{$T->str_card_template_usenumber}';   //名片模板使用数
    var jsCardThemeUseNum = '{$T->str_card_theme_usenumber}';    //名片主题类型使用数
    var tip_select_time = '{$T->tip_select_time}';//请选择时间
    var legendData=['{$T->str_share_number_inside_count}','{$T->str_share_number_outside_count}'];
    var colors = $.parseJSON('{$colors}');
    var max=0;
    if(alldata != 'null'){
        var linedata = [];
        var xdata = [];//横坐标数据
        alldata = eval('('+alldata+')');
        var gendJsChartData = [];   //保存所有曲线的数据
        var t=0;
        for(var i in alldata){
            if(t>=10){
                break;
            }
            var dataarr = alldata[i];
            if(dataarr ==''){
                continue;
            }
            var gJsChartData = [];  //保存单条曲线的数据
            var h=0;
            for(var j in dataarr){
            	xdata[h] = j;      //横坐标展示数据
            	gJsChartData[h]  =  dataarr[j];  //单个曲线的数量数组
            	if (dataarr[j] > max){
                	max = dataarr[j];
            	}
            	h++;
            }
            //折线颜色设置    单条时为深灰色  多条时为自动分配颜色
            var itemStyle = {normal: {color:colors[i]}};
            var obj = {
                name:legendData[i],   //提示消息标题
                type:'line',
                itemStyle : itemStyle, // 折线颜色
                data:gJsChartData //[120, 132, 101, 134, 90, 230, 210]
            };
            gendJsChartData.push(obj); //保存所有版本echarts所需的数据
            t++;
        }
        var rst=paramsForGrid(max);
        var echartOptionLine =  {
            tooltip : {
                trigger: 'axis'
            },
            legend: {
            	left: 'center',
            	bottom: '0',
            	selectedMode:false,
                data:legendData
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '6%',
                containLabel: true
            },
            xAxis : [
                {
                    type : 'category',
                    boundaryGap : false,
                    data : xdata,
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
                    }
                }
            ],
            yAxis : [
                {
                    type : 'value',
                    max : rst.max,
                    splitNumber: rst.splitNumber,
                    interval: rst.interval,
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
            series : gendJsChartData
        };


        var gEchartSettings = [
            {containerId: 'userStatisticsLine', option : echartOptionLine},
        ];
    }

    $(function(){
        $.beanalysis.init();
    })
</script>