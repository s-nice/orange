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
                                <input id="js_begintime" class="time_input" readonly type="text" name="start_time" readonly="readonly" value="{$startTime}" />
                                <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            </div>
                            <span>--</span>
                            <div class="time_c">
                                <input id="js_endtime" class="time_input" readonly type="text" name="end_time" readonly="readonly" value="{$endTime}"/>
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
	                <ul id="js_secondselectul" style="height: 75px">
	                    <li title="{$T->str_add_card_number}">{$T->str_add_card_number}</li>
	                    <li title="{$T->str_add_card_usernumber}">{$T->str_add_card_usernumber}</li>
	                    <li title="{$T->str_card_template_usenumber}">{$T->str_card_template_usenumber}</li>
<!--	                    <li title="{$T->str_card_theme_usenumber}">{$T->str_card_theme_usenumber}</li>-->
	                </ul>
	            </div>
	            
                <div class="js_stat_date_type">
					<a class="{:$statType=='d'?'on':''}" val='d'>{$T->str_day}</a>
					<a class="{:$statType=='w'?'on':''}" val='w'>{$T->str_week}</a>
					<a class="{:$statType=='m'?'on':''}" val='m'>{$T->str_month}</a>
				</div>
	            
           </div>
<!--            <div id="userStatisticsBar" style="width:820px;height:500px; margin-bottom:20px" class=""></div>-->
            <div id="userStatisticsLine" style="width:820px;height:500px;" class=""></div>
            <div id="userStatisticsData" class="">
                <div class="Data_bt"><span class="left_s">{$secondSelect}</span>
                    <if condition="count($userStats) neq 0">
                        <span class="right_s" id="js_download" style="cursor: pointer;"><a href="{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/iAnalysis',array('appType'=>$oneSelect,'selecttype'=>$secondSelect,'startDate'=>$startTime,'endDate'=>$endTime,'download'=>1))}" >{$T->stat_export}</a></span>
                    </if>
                </div>
                <div class="Data_c_content">
                    <div class="Data_c_name">
                        <span class="span_c_1">{$T->str_orange_rownum}</span>
                        <span class="span_c_1">{$T->stat_date}</span>
                        <span class="span_c_1">{$T->str_card_template_name}</span>
                        <span class="span_c_2">{$secondSelect}</span>
                    </div>
                    <div class="js_c_content">
                    <if condition="count($userStats) gt 0">
                        <volist name="userStats" id="_userStat">
                            <if condition="$_userStat.total_count neq 0">
                            <div class="Data_c_list">
                                <span class="span_c_1">{$_userStat.rownum}</span>
                                <span class="span_c_1">{$_userStat.date1}</span>
                                <span class="span_c_1">{$_userStat.template_name}</span>
                                <span class="span_c_2">{$_userStat.total_count}</span>
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

<script type="text/javascript">
    <include file="@Layout/js_stat_widget" />
    var gStatisticDateType = "d";
    var jsSearchLink = "{:U('Appadmin/BeAnalysis/iAnalysis','','','',true)}";
    var jssecondselect = "{$secondSelect}";
    var alldata = '{$lineStats}';
    var jsUpToTime = '{$T->str_up_to_time}'; //截止到
    var jsUsageAmount = '{$T->str_usage_amount}'; //使用量
    var jsInsertContrastTime = '{$T->str_insert_contrast_time}'; //请填写对比时段
    var jsCardTempUseNum = '{$T->str_card_template_usenumber}';   //名片模板使用数
    var jsCardThemeUseNum = '{$T->str_card_theme_usenumber}';    //名片主题类型使用数
    var tip_select_time = '{$T->tip_select_time}';//请选择时间
    var colors = $.parseJSON('{$colors}');
    var max=0;
    if(alldata != 'null'){
        var linedata = [];
        var xdata = [];//横坐标数据
        alldata = eval('('+alldata+')');

        var echartOptionLine;
        //名片模板使用数  和  主题类型使用数   画柱形图
        for(var i in alldata){
            var dataarr = alldata[i];
            if(dataarr ==''){
                continue;
            }
            var h=0;
            var gJsChartData = [];  //保存每一个版本的数据
            var maxLength=dataarr.length>10?10:dataarr.length;
            for(var j=0;j<maxLength;j++){
            	xdata[j] = dataarr[j]['template_name'];
            	gJsChartData[j] = parseInt(dataarr[j]['total_count']);
            	if (gJsChartData[j] > max){
                	max = gJsChartData[j];
            	}
            }
            xdata.reverse();
            gJsChartData.reverse();
            var itemStyle = {normal: {color:colors[i]}};
            var obj = {
                name:jsUsageAmount,   //提示消息标题
                type:'bar',
                itemStyle:itemStyle,
                data:gJsChartData //[120, 132, 101, 134, 90, 230, 210]
            };
            linedata.push(obj); //保存所有版本echarts所需的数据
        }
        var rst=paramsForGrid(max);
        var echartOptionLine =  {
            tooltip : {
                trigger: 'axis'
            },
            color:[
               '#999'
            ],

            legend: {
                show: false,
            	left: 'center',
            	bottom: '0',
            	selectedMode:false,
                data:[jsUsageAmount]
            },
            calculable : true,
            xAxis : [
                {
                    type : 'value',
                    max : rst.max,
                    splitNumber: rst.splitNumber,
                    interval: rst.interval,
                    boundaryGap : [0, 0.01]
                }
            ],
            yAxis : [
                {
                    type : 'category',
                    data : xdata
                }
            ],
            series:linedata
        };
        var gEchartSettings = [
            {containerId: 'userStatisticsLine', option : echartOptionLine},
        ];
    }

    $(function(){
        $.beanalysis.init();
    })
</script>