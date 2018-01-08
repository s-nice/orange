<layout name="../Layout/Layout"/>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
        	<div class="form_margintop"> 
	            <div class="content_search">
	                <div class="search_right_c">
	                    <div class="select_IOS" id="js_selectIOS">
	                        <if condition="$oneSelect eq 'Leaf'">
	                            <input type="text" value="{$oneSelect}" title="{$oneSelect}" style="color: #999;" seltitle="{$oneSelect}"/>
	                            <else/>
	                            <input type="text" value="{$oneSelect}{$T->str_terminal}" title="{$oneSelect}" style="color: #999;" seltitle="{$oneSelect}"/>
	                        </if>

	                        <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	                        <ul id="js_selectIOSul" style="height:75px;">
	                            <li title="IOS">IOS{$T->str_terminal}</li>
	                            <li title="Android">Android{$T->str_terminal}</li>
	                            <li title="Leaf">Leaf</li>
	                        </ul>
	                    </div>
	                    <div class="select_sketch js_select_item">
	                        <input type="text" value="{:$appVersion==''?$T->stat_prod_version:$appVersion}" id="js_productversion" title="{:$appVersion==''?$T->stat_prod_version:$appVersion}"/>
	                        <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	                        <ul class="hand js_sel_ul" id="js_productversionul">
                                <li val="{$T->stat_prod_version}" title="{$T->stat_prod_version}">{$T->stat_prod_version}</li>
                                <volist name="prdversions" id="_prdversions">
                                    <li val="{$_prdversions['prd_version']}" title="{$_prdversions['prd_version']}">{$_prdversions['sys_version']}</li>
                                </volist>
	                        </ul>
	                    </div>
	                    <div class="select_time_c">
	                        <span>{$T->str_time}</span>
	                        <div class="time_c">
	                            <input id="js_begintime" class="time_input" type="text" readonly="readonly" name="startTime[]" value="{$startTime}"/>
	                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	                        </div>
	                        <span>--</span>
	                        <div class="time_c">
	                            <input id="js_endtime" class="time_input" type="text" name="endTime[]" value="{$endTime}" readonly="readonly" />
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
                    <if condition="count($userStats) neq 0">
                        <span class="right_s" id="js_download" style="cursor: pointer;"><a href="{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/fileshare',array('appVersion'=>$appVersion,'selecttype'=>$secondSelect,'startDate'=>$startTime,'endDate'=>$endTime,'download'=>1))}" >{$T->stat_export}</a></span>
                    </if>
                </div>
                <div class="Data_c_content">
                    <div class="Data_file_name">
                        <span class="span_c_1">{$T->stat_date}</span>
                        <!--                            <span class="span_c_2">系统平台</span>-->
                        <span class="span_c_3">{$T->stat_prod_version}</span>
                        <!--                            <span class="span_c_4">模块</span>-->
                        <span class="span_c_5">{$secondSelect}</span>
                    </div>
                    <if condition="count($userStats) gt 0">

                        <volist name="userStats" id="_userStat">
                            <if condition="$_userStat.total_count neq 0">
                            <div class="Data_file_list_z">
                                <span class="span_c_1">{$_userStat.date1}</span>
<!--                                <span class="span_c_2">{$oneSelect}</span>-->
                                <span class="span_c_3" title="{$_userStat.prd_version}">{$_userStat.prd_version}</span>
<!--                                <span class="span_c_4">文件共享</span>-->
                                <span class="span_c_5">{$_userStat.total_count}</span>
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

<script>
    var jsSearchLink = "{:U('Appadmin/BeAnalysis/fileShare','','','',true)}";
    var jssecondselect = "{$secondSelect}";
    var alldata = '{$lineStats}';
    var jsAppVersion = '{$T->str_app_version}';//版本
    var jsFileShareUseNum = '{$T->str_fileshare_use_number}';   //文件共享使用数
    var jsInsertContrastTime = '{$T->str_insert_contrast_time}'; //请填写对比时段
    var jsCardTempUseNum = '{$T->str_card_template_usenumber}';   //名片模板使用数
    var jsCardThemeUseNum = '{$T->str_card_theme_usenumber}';    //名片主题类型使用数
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
                xdata[h] = dataarr[j]['date1'];      //横坐标展示数据
                if(dataarr[j]['total_count'] == 0){
                    dataarr[j]['total_count'] =  '0';
                }
                gJsChartData[h]  =  dataarr[j]['total_count'];  //单个版本的数量数组
                h++;
            }
            //折线颜色设置    单条时为深灰色  多条时为自动分配颜色
            var   itemStyle = { normal: {color:'#666'}};
            if(alldata.length>1){
                itemStyle = {};
            }
            var obj = {
                name:jsAppVersion+i+jsFileShareUseNum,   //提示消息标题
                type:'line',
//                stack: '总量',
                itemStyle : itemStyle, // 折线颜色
                data:gJsChartData //[120, 132, 101, 134, 90, 230, 210]
            };
            gendJsChartData.push(obj); //保存所有版本echarts所需的数据
            t++;
        }

        var echartOptionLine =  {
            tooltip : {
                trigger: 'axis'
            },
            legend: {
                show:false
//            data:['邮件营销','联盟广告','视频广告','直接访问','搜索引擎']
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
