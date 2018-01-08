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
                                <li title="{$T->stat_sys_platform}">{$T->stat_sys_platform}</li>
	                            <li <if condition="$oneSelect=='IOS'">class='on'</if> title="IOS" val="IOS">IOS</li>
	                            <li <if condition="$oneSelect=='Android'">class='on'</if> title="Android" val="Android">Android</li>
	                            <li <if condition="$oneSelect=='Leaf'">class='on'</if> title="Leaf" val="Leaf" >Leaf</li>
	                        </ul>
	                    </div>
	                    <div class="select_sketch js_select_item js_multi_select">
	                        <input type="text" value="{:$appVersion==''?$T->stat_prod_version:$appVersion}" id="js_productversion" title="{:$appVersion==''?$T->stat_prod_version:$appVersion}"/>
	                        <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	                        <ul class="hand js_sel_ul" id="js_productversionul">
                                <li class='js_all_in_one' val="{$T->stat_prod_version}" title="{$T->stat_prod_version}">{$T->stat_prod_version}</li>
                                <volist name="prdversions" id="_prdversions">
                                    <if condition="in_array($_prdversions['prd_version'], $appversionList)">
                                    <li class='on' data-link-value=",{$_prdversions['sys_platforms']}," val="{$_prdversions['prd_version']}" title="{$_prdversions['prd_version']}">{$_prdversions['prd_version']}</li>
                                    <else/>
                                    <li data-link-value=",{$_prdversions['sys_platforms']}," val="{$_prdversions['prd_version']}" title="{$_prdversions['prd_version']}">{$_prdversions['prd_version']}</li>
                                    </if>
                                </volist>
	                        </ul>
	                    </div>
	                    <div class="select_time_c">
	                        <span>{$T->str_time}</span>
	                        <div class="time_c">
	                            <input id="js_begintime" class="time_input" type="text" name="startTime[]" readonly value="{$startTime}"/>
	                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	                        </div>
	                        <span>--</span>
	                        <div class="time_c">
	                            <input id="js_endtime" class="time_input" type="text" name="endTime[]" readonly value="{$endTime}"/>
	                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	                        </div>
	                        <input class="submit_button_c" type="button" value="{$T->str_submit}" id="js_search"/>

	                    </div>
	                </div>
	            </div>
	            <div class="select_xinzeng margin_top js_select_item">
	                <input type="text" value="{$secondSelect}" id="js_secondselect" title="{$secondSelect}"/>
	                <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	                <ul id="js_secondselectul" style="height: 49px">
	                    <li title="{$T->str_use_usernum}">{$T->str_use_usernum}</li>
	                    <li title="{$T->str_use_num}">{$T->str_use_num}</li>
	                </ul>
	            </div>
	            <div class="select_xinzeng margin_top js_select_item">
	                <input type="text" value="{$thirdSelect}" id="js_thirdselect" title="{$thirdSelect}"/>
	                <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	                <ul id="js_thirdselectul" style="height: 75px">
	                    <li title="{$T->str_search_all}">{$T->str_search_all}</li>
	                    <li title="{$T->str_search_voice}">{$T->str_search_voice}</li>
	                    <li title="{$T->str_search_text}">{$T->str_search_text}</li>
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
                <div class="Data_bt Data_bt_top"><span class="left_s">{$secondSelect}</span>
                    <if condition="count($noZeroData) neq 0">
                        <span class="right_s" id="js_download" style="cursor: pointer;"><a href="{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/search',array('appType'=>$oneSelect,'appVersion'=>$appVersion,'selecttype'=>$secondSelect,'thirdtype'=>$thirdSelect,'startDate'=>$startTime,'endDate'=>$endTime,'download'=>1))}" >{$T->stat_export}</a></span>
                    </if>
                </div>
                <div class="Data_c_content">
                    <div class="Data_search_name">
                        <span class="span_c_1" style="width: 184px;">{$T->stat_date}</span>
                        <span class="span_c_1" style="width: 184px;">{$T->stat_sys_platform}</span>
                        <span class="span_c_1" style="width: 184px;">{$T->stat_prod_version}</span>
                        <span class="span_c_6" style="width: 184px;">{$secondSelect}</span>
                    </div>
                    <div class="js_c_content">
                    <if condition="count($noZeroData) gt 0">
                        <volist name="userStats" id="_userStat">
                            <if condition="$_userStat.searched_count neq 0">
                            <div class="Data_search_list">
                                <span class="span_c_1" style="width: 184px;">{$_userStat.date1}</span>
                                <span class="span_c_1" style="width: 184px;">{$_userStat.sys_platform}</span>
                                <span class="span_c_1" style="width: 184px;" title="{$_userStat.prd_version}">{$_userStat.prd_version}</span>
                                <span class="span_c_6" style="width: 184px;">{$_userStat.searched_count}</span>
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
    var gStatisticDateType = "{$statType}";
    var searchPage=true;
    var gMultiValueSeparator = ',';
    var jsSearchLink = "{:U('Appadmin/BeAnalysis/search','','','',true)}";
    var jssecondselect = "{$secondSelect}";
    var alldata = '{$lineStats}';
    var jsAppVersion = '{$T->str_app_version}';//版本
    var jsSearchUseNum = '{$T->str_search_count}';   //搜索功能使用数
    var currentVersion = $('#js_productversion').val();//当前选择的版本
    if ('{$T->stat_prod_version}'==currentVersion){
    	currentVersion = '{$T->str_label_all}'+jsAppVersion;
    } else {
    	currentVersion = jsAppVersion+'('+currentVersion+')';
    }
    var jsInsertContrastTime = '{$T->str_insert_contrast_time}'; //请填写对比时段
    var jsCardTempUseNum = '{$T->str_card_template_usenumber}';   //名片模板使用数
    var jsCardThemeUseNum = '{$T->str_card_theme_usenumber}';    //名片主题类型使用数
    var tip_select_time = '{$T->tip_select_time}';//请选择时间
    var colors = $.parseJSON('{$colors}');
    var max=0;
    if(alldata != 'null'){
        var xdata = [];//横坐标数据
        alldata = eval('('+alldata+')');
        var gendJsChartData = [];   //保存所有版本的数据

        var t=0;
        for(var i in alldata){
            if(t>=10){
                break;
            }
            var dataarr = alldata[i];
            if(dataarr ==''){
                continue;
            }
            var gJsChartData = [];  //保存每一个版本的数据
            var h = 0;
            for(var j in dataarr){
                xdata[h] = j;      //横坐标展示数据
                gJsChartData[h]  =  dataarr[j];  //单个版本的数量数组
                if (dataarr[j] > max){
                	max = dataarr[j];
            	}
                h++;
            }
            //折线颜色设置    单条时为深灰色  多条时为自动分配颜色
            var itemStyle = {normal: {color:colors[i]}};
            if(alldata.length>1){
                itemStyle = {};
            }
            var obj = {
                name:currentVersion+jsSearchUseNum,   //提示消息标题
                type:'line',
//                stack: '总量',
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
                data:[currentVersion+jsSearchUseNum]
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
            //backgroundColor: '#000' // 设置图表背景颜色
        };

        var gEchartSettings = [
            {containerId: 'userStatisticsLine', option : echartOptionLine},
        ];
    }
    $(function(){
        $.beanalysis.init();
    })
</script>