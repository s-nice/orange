<layout name="../Layout/Layout"/>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
        <form class="form_margintop" action="{:U('AppStatistics/app')}" method='post'>
              <div class="content_search">
            	<div class="search_right_c">
            		<div id="select_platform" class="select_IOS menu_list js_select_item">
            			<input type="text" value="<if condition='!empty($sysPlatform)'>{$sysPlatform}<else/>{$T->str_title_app_type}</if>" name='sysPlatform' readonly="readonly" />
            			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            			<ul>
            			    <li class="on" val="" title="{$T->str_title_app_type}">{$T->str_title_app_type}</li>
            				<li val="IOS" title="IOS" <if condition="$sysPlatform=='IOS'">class='on'</if> >IOS</li>
            				<li val="Android" title="Android" <if condition="$sysPlatform=='Android'">class='on'</if> >Android</li>
            				<li val="Leaf" title="Leaf" <if condition="$sysPlatform=='Leaf'">class='on'</if> >Leaf</li>
            			</ul>
            		</div>
            		<div id="select_channel" class="select_sketch js_select_item  js_multi_select menu_list">
            			<input type="text" name="channel" value="<if condition='!empty($channel)'>{$channel}<else/>{$T->str_channel}</if>"  readonly="readonly" />
            			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            			<ul>
            			<li class="on" val='{$T->str_channel}' title='{$T->str_channel}' class='js_all_in_one'>{$T->str_channel}</li>
            			<foreach name='channels' item='channe'>
            				<li data-link-value=",{$channe['sys_platforms']},"  val="<php>echo $channe['channel'];</php>" title="<php>echo $channe['channel'];</php>" <php> if(strstr($channel,$channe['channel'])!==false){echo "class='on'";}</php> ><php>echo $channe['channel'];</php> </li>
            		    </foreach>
            			</ul>
            		</div>
            		<if condition="$charttype =='zl' ||$type !==$T.str_user_version ">
            		<div id="select_prd_version" class="select_sketch js_select_item js_multi_select">
            			<input type="text" name='version' value="<if condition='!empty($version)'>{$version}<else/>{$T->str_prd_version}</if>"  readonly="readonly" />
            			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            			<ul>
            			<li val='{$T->str_prd_version}' title='{$T->str_prd_version}' class='js_all_in_one'>{$T->str_prd_version}</li>
            			<foreach name='prdVersions' item='prdVersion'>
            				<li data-link-value=",{$prdVersion['sys_platforms']}," val="<php>echo $prdVersion['prd_version'];</php>" title="<php>echo $prdVersion['prd_version'];</php>" <php> if(strstr($version,$prdVersion['prd_version'])!==false){echo "class='on'";}</php> ><php>echo $prdVersion['prd_version'];</php></li>
            		    </foreach>

            			</ul>
            		</div>
            		</if>

            	<div class="select_time_c">
					    <span>{$T->str_time}</span>
					    <if condition="$charttype =='zx'">
						<div class="time_c">
							<input id="js_begintime" class="time_input" type="text" name="startTime" value='{$startTime}' readonly="readonly" />
							<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
						</div>
						<span>--</span>
						</if>
						<input id="js_begintime" class="time_input" type="hidden" name="startTime" value='2016-1-1' readonly="readonly" />
						<div class="time_c">
							<input id="js_endtime" class="time_input" type="text" name="endTime" value="{$endTime}" readonly="readonly" />
							<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
						</div>
			           <!--  <input class="time_button" type="button" value="{$T->str_contrast_time}"/> -->
			               <div class="time_duibi" style='display:<if condition='empty($lstartTime)||empty($lendTime)'>none<else/>block</if>'>
			            	<div class="time_c time_right">
								<input id="js_begintime1" class="time_input" type="text" name="lstartTime" value='{$lstartTime}' readonly="readonly" />
								<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
							</div>
							<span>--</span>
							<div class="time_c" >
								<input id="js_endtime1" class="time_input" type="text" name="lendTime" value='{$lendTime}' readonly="readonly" />
								<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
							</div>
							<!-- <input class="timeduibi_button" type="button" value="{$T->str_contrast_time}"/> -->
			            </div>
	            	</div>

	            	<input type='hidden' name='statType' value='<if condition="!empty($statType)">{$statType}<else/>day</if>'>
	            	<input class="submit_button" type="button" value="{$T->str_submit}"/>
            	</div>
            </div>
            <if condition="$charttype =='zx'">
             <div class="js_stat_date_type">
				<a class="<if condition="empty($statType)||$statType=='day'">on</if>" val='day'>{$T->str_day}</a>
				<a class="<if condition="$statType=='week'">on</if>" val='week'>{$T->str_week}</a>
				<a class="<if condition="$statType=='month'">on</if>" val='month'>{$T->str_month}</a>
			</div>
			</if>
            <div class="select_xinzeng js_select_item js_select_margintop">
            		<input type="text" value="<if condition='!empty($type)'>{$type}<else/>{$T->str_soft_version_update}</if>" name='type' readonly="readonly"  />
            	<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            	<ul>
            		<li title="{$T->str_soft_version_update}">{$T->str_soft_version_update}</li>
            		<li title="{$T->str_user_version}">{$T->str_user_version}</li>
            		<li title="{$T->str_user_brand}">{$T->str_user_brand}</li>
            		<li title="{$T->str_user_model}">{$T->str_user_model}</li>
            		<li title="{$T->str_user_country}">{$T->str_user_country}</li>
            		<li title="{$T->str_user_province}">{$T->str_user_province}</li>

            	</ul>
            </div>
            </form>
            <div id="userStatisticsLine" style="width:820px;height:500px;" class=""></div>
            <div id="userStatisticsData" class="">
            	<div class="Data_bt Data_bt_top"><span class="left_s">{$type}{$T->str_data_tab}</span><if condition="count($appStats) gt 0"><span class="right_s">
            	 <!-- <a href="{:U(CONTROLLER_NAME.'/'.ACTION_NAME, array('sysPlatform'=>$sysPlatform,'channel'=>$channel,'startTime'=>$startTime, 'endTime'=>$endTime,'statType'=>$statType,'type'=>$type,'downloadStat'=>1))}">{$T->str_export}</a>
            	 -->
            	  <a href="javascript:void(0);" id="exportBtn" url="{:U(CONTROLLER_NAME.'/'.ACTION_NAME)}">{$T->str_export}</a>
            	 </span></if></div>

		        <if condition="$type == $T.str_soft_version_update ">
            	<div class="Data_c_content js_data_area Data_c_content_1" >
		                <div class="Data_cjs_name">
			                  <span class="span_c_1">{$T->stat_date}</span>
				              <span class="span_c_2">{$T->stat_sys_platform}</span>
		                      <span class="span_c_3">{$T->stat_channel}</span>
			                  <span class="span_c_4">{$T->str_old_version}</span>
			                  <span class="span_c_5">{$T->str_new_version}</span>
			                  <span class="span_c_6">{$T->str_update_num}</span>
		                </div>
		                <div class="js_scroll_data">
		                <if condition="count($appStats) gt 0">
			                <volist name="appStats" id="_appStat" key="k">
			                <div class="Data_c_list_z">
		                          <span class="span_c_1">{$_appStat.time}</span>
				                  <span class="span_c_2"><php>if($sysPlatform!==''){echo $_appStat['sys_platform'];}else{echo $T->str_label_all;}</php></span>
				                  <span class="span_c_3"><php>if($channel!==''){echo $_appStat['channel'];}else{echo $T->str_label_all;}</php></span>
				                  <span class="span_c_4" title="{$_appStat.old_version}">{$_appStat.old_version}</span>
				                  <span class="span_c_5" title="{$_appStat.version}">{$_appStat.version}</span>
				                  <span class="span_c_6" title="{$_appStat.count_all}">{$_appStat.count_all}</span>
			                </div>
			                </volist>
		            	<else/>
		              No Data
		            </if>
		             </div>
		         </div>
		         </if>
		         <if condition="$type ==$T.str_user_version ">
		         <div class="Data_c_content js_data_area Data_c_content_2">
		                <div class="Data_cjs_name">
			              <span class="span_c_1">{$T->stat_date}</span>
		                  <span class="span_c_2">{$T->stat_sys_platform}</span>
		                  <span class="span_c_3">{$T->stat_channel}</span>
		                  <span class="span_c_4">{$T->stat_prod_version}</span>
		                  <span class="span_c_5">{$T->str_use_nu}</span>
		                </div>
		                <div class="js_scroll_data">
			                <if condition="count($appStats) gt 0">
				                <volist name="appStats" id="_appStat" key="k">
				                <div class="Data_c_list_z">
		                          <span class="span_c_1">{$_appStat.time}</span>
				                  <span class="span_c_2"><php>if($sysPlatform!==''){echo $_appStat['sys_platform'];}else{echo $T->str_label_all;}</php></span>
				                  <span class="span_c_3"><php>if($channel!==''){echo $_appStat['channel'];}else{echo $T->str_label_all;}</php></span>
				                  <span class="span_c_4" title="{$_appStat['version']}"><php>echo $_appStat['version'];</php></span>
				                  <span class="span_c_5" title="{$_appStat.count_all}">{$_appStat.count_all}</span>
				                </div>
				                </volist>
				            <else/>
			              No Data
			            </if>
		            </div>
		         </div>
		        </if>
		        <if condition="$type ==$T.str_user_brand ">
		        <div class="Data_c_content js_data_area Data_c_content_1">
	                <div class="Data_cjs_name">
		              <span class="span_c_1">{$T->stat_date}</span>
	                  <span class="span_c_2">{$T->stat_sys_platform}</span>
	                  <span class="span_c_3">{$T->stat_channel}</span>
	                  <span class="span_c_4">{$T->stat_prod_version}</span>
	                  <span class="span_c_5">{$T->str_brand}</span>
	                  <span class="span_c_6">{$T->str_num}</span>
	                </div>
	                <div class="js_scroll_data">
	                <if condition="count($appStats) gt 0">
	                <volist name="appStats" id="_appStat" key="k">
		                <div class="Data_c_list_z">
                          <span class="span_c_1">{$_appStat.time}</span>
						  <span class="span_c_2"><php>if($sysPlatform!==''){echo $_appStat['sys_platform'];}else{echo $T->str_label_all;}</php></span>
				          <span class="span_c_3"><php>if($channel!==''){echo $_appStat['channel'];}else{echo $T->str_label_all;}</php></span>
				          <span class="span_c_4" title="<php>if($version!==''){echo $_appStat['version'];}else{echo $T->str_label_all;}</php>"><php>if($version!==''){echo $_appStat['version'];}else{echo $T->str_label_all;}</php></span>
		                  <span class="span_c_5" title="{$_appStat.brand}">{$_appStat.brand}</span>
		                  <span class="span_c_6" title="{$_appStat.count_all}">{$_appStat.count_all}</span>
		                </div>
		                 </volist>
		            <else/>
		              No Data
		            </if>
		            </div>
		         </div>
		         </if>
		         <if condition="$type ==$T.str_user_model ">
		         <div class="Data_c_content js_data_area Data_c_content_3">
	                <div class="Data_cjs_name">
		              	  <span class="span_c_1">{$T->str_no}</span>
		                  <span class="span_c_2">{$T->stat_date}</span>
		                  <span class="span_c_3">{$T->stat_sys_platform}</span>
		                  <span class="span_c_4">{$T->stat_channel}</span>
                          <span class="span_c_5">{$T->str_brand}</span>
		                  <span class="span_c_6">{$T->str_model}</span>
		                  <span class="span_c_7">{$T->str_use_nu}</span>
	                </div>
	                <div class="js_scroll_data">
	                <if condition="count($appStats) gt 0">
	                <volist name="appStats" id="_appStat" key="k">
		                <div class="Data_c_list_z">
	                          <span class="span_c_1">{$k}</span>
	 				  		  <span class="span_c_2">{$_appStat.time}</span>
			     			  <span class="span_c_3"><php>if($sysPlatform!==''){echo $_appStat['sys_platform'];}else{echo $T->str_label_all;}</php></span>
				              <span class="span_c_4"><php>if($channel!==''){echo $_appStat['channel'];}else{echo $T->str_label_all;}</php></span>
			                  <span class="span_c_5">{$_appStat.brand}</span>
			                  <span class="span_c_6">{$_appStat.model}</span>
			                  <span class="span_c_7">{$_appStat.count_all}</span>
		                </div>
		                </volist>
		            <else/>
		              No Data
		            </if>
		            </div>
		         </div>
		         </if>
		         <if condition="$type ==$T.str_user_country ">
		         <div class="Data_c_content js_data_area Data_c_content_1">
	                <div class="Data_cjs_name">
		              	  <span class="span_c_1">{$T->str_no}</span>
		                  <span class="span_c_2">{$T->stat_date}</span>
		                  <span class="span_c_3">{$T->stat_sys_platform}</span>
		                  <span class="span_c_4">{$T->stat_channel}</span>
		                  <span class="span_c_5">{$T->str_country}</span>
		                  <span class="span_c_6">{$T->str_use_nu}</span>
	                </div>
	                <div class="js_scroll_data">
	                <if condition="count($appStats) gt 0">
	                <volist name="appStats" id="_appStat" key="k">
		                <div class="Data_c_list_z">
                          <span class="span_c_1">{$k}</span>
 				  		  <span class="span_c_2">{$_appStat.time}</span>
		                  <span class="span_c_3"><php>if($sysPlatform!==''){echo $_appStat['sys_platform'];}else{echo $T->str_label_all;}</php></span>
				          <span class="span_c_4"><php>if($channel!==''){echo $_appStat['channel'];}else{echo $T->str_label_all;}</php></span>
		                  <span class="span_c_5" title="{$_appStat.country}">{$_appStat.country}</span>
		                  <span class="span_c_6" title="{$_appStat.count_all}">{$_appStat.count_all}</span>
		                </div>
		                </volist>
		            <else/>
		              No Data
		            </if>
		            </div>
		         </div>
		         </if>
		         <if condition="$type ==$T.str_user_province ">
		         <div class="Data_c_content js_data_area Data_c_content_3">
	                <div class="Data_cjs_name">
		              	  <span class="span_c_1">{$T->str_no}</span>
		                  <span class="span_c_2">{$T->stat_date}</span>
		                  <span class="span_c_3">{$T->stat_sys_platform}</span>
		                  <span class="span_c_4">{$T->stat_channel}</span>
		                  <span class="span_c_5">{$T->str_country}</span>
		                  <span class="span_c_6">{$T->str_province}</span>
		                  <span class="span_c_7">{$T->str_use_nu}</span>
	                </div>
	                <div class="js_scroll_data">
	                <if condition="count($appStats) gt 0">
	                <volist name="appStats" id="_appStat" key="k">
		                <div class="Data_c_list_z">
	                          <span class="span_c_1">{$k}</span>
	 				  		  <span class="span_c_2">{$_appStat.time}</span>
			                  <span class="span_c_3"><php>if($sysPlatform!==''){echo $_appStat['sys_platform'];}else{echo $T->str_label_all;}</php></span>
				              <span class="span_c_4"><php>if($channel!==''){echo $_appStat['channel'];}else{echo $T->str_label_all;}</php></span>
			                  <span class="span_c_5" title="{$_appStat.country}">{$_appStat.country}</span>
			                  <span class="span_c_6" title="{$_appStat.province}">{$_appStat.province}</span>
			                  <span class="span_c_7" title="{$_appStat.count_all}">{$_appStat.count_all}</span>
		                </div>
		                </volist>
		            <else/>
		              No Data
		            </if>
		            </div>
		         </div>
		         </if>
            </div>
        </div>
    </div>
</div>
<script>
var formData = $('.form_margintop').serializeArray();//表单数据
var gStatisticDateType = 'd';//时间类型供限制时间
var str_title_app_type = '{$T->str_title_app_type}';
var str_channel = '{$T->str_channel}';
var str_prd_version = '{$T->str_prd_version}';
var js_Empty_Time = '{$T->tip_select_time}';
//如果为折线图
<if condition="$charttype =='zx'">
var echartOptionLine =  {
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
	            data : {$xdata},
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
// 	            splitLine: {
// 	            	show:true,
// 	                lineStyle: {
// 	                    // 使用深浅的间隔色
// 	                    color: ['#ddd'],
// 	                    type : 'dashed'
// 	                }
// 	            }
	        }
	    ],
	    yAxis : [
	        {
	            type : 'value',
// 	            splitLine: {
// 	            	show:true,
// 	                lineStyle: {
// 	                    // 使用深浅的间隔色
// 	                    color: ['#ddd'],
// 	                    type : 'dashed'
// 	                }
// 	            }
	        }
	    ],
	    series : {$datas},
	    //backgroundColor: '#000' // 设置图表背景颜色
	};
//柱状图
<else/>
 var date = {$date};//y轴数组
// var date1 = [];//显示数据
// var colorList = {$colorList};
// var l = date.length;
var count = {$count};
var colorList = {:json_encode(C('STAT_CHART_LINE_COLORS'))};//设置颜色
var yAxisData = [];//y 轴数据
var list = {:json_encode($chartData)};//x数据
var versionName = [];//版本名称
var initData = [];//初始化数据


    /*图表配置项*/
    var echartOptionLine = {
        tooltip: {
            trigger: 'axis',
            formatter: function (data) {
                for (i = 0; i < data.length; i++) {
                    if (data[i].seriesName == data[i].name) {
                        return data[i].name+':'  + data[i].data;
                    }

                }
                return data.seriesName;
            },
            axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
            }
        },
        legend: {
            data: [],
            bottom:1,
            selectedMode: false
        },
        grid: {
            left: '1%',
            right: '3%',
            bottom: '15%',
            containLabel: true
        },
        xAxis: {
            type: 'value',
        },
        yAxis: {
            type: 'category',
            data: []
        },
        series: []
    };

    /*获取图表数据*/
    if (list[0]) {
        var j = list.length - 1 >= 9 ? 9 : list.length - 1; //top5
        for (var jj = 0; jj <= j; jj++) { //数据值全为0的数组
            initData.push(0);
        }
        for (var i = j, k = 0; i >= 0, k <= j; i--, k++) { //top5
            versionName.push(date[i]); //版本名称
            //echartOptionLine.series[0].data.push(list[i].count_all);
            echartOptionLine.yAxis.data = versionName; //Y轴数据版本名称
            var mydata = initData.concat();
            mydata[k] = list[i].count_all;
            echartOptionLine.series.push(
                {
                    name: date[i],
                    type: 'bar',
                    stack: '总量',
                    label: {
                        normal: {
                            show: true,
                            position: 'right'
                        }
                    },
                    barMaxWidth: 70,
                    data: mydata,
                    itemStyle: {
                        normal: {
                            color: colorList[k]
                        }
                    }

                }
            );
            echartOptionLine.legend.data.push(
                {
                    name: date[i],
                    // 强制设置图形为圆。
                    // icon: 'circle',
                    // 设置文本为
                    textStyle: {
                        color: colorList[k]
                    }
                }
            )


        }
        /*
         整数：统计值最大值为“11213”，进位至“11220”，平均刻度值=11220/5=2244,坐标轴最大值为11220+2244=13464；
         0≤MAX≤5，分5段，平均间距=1
         5＜MAX＜10，分5段，平均间距=2
         */
        if (echartOptionLine.series[j].data[j] <= 5) {
            echartOptionLine.xAxis.max = 5;
            echartOptionLine.xAxis.interval = 1;
        } else if (echartOptionLine.series[j].data[j] < 10) {
            echartOptionLine.xAxis.max = 10;
            echartOptionLine.xAxis.interval = 2;

        } else {
            echartOptionLine.xAxis.max = Math.ceil(list[0].count_all / 10) * 10 * 1.2;
            echartOptionLine.xAxis.interval = echartOptionLine.xAxis.max / 6;
        }
    } else {
        echartOptionLine.series = [
            {
                name: "No Data",
                type: 'bar',
                data: 0
            }

        ];

    }

</if>
//var echartOption = ;

var gEchartSettings = [
                       {containerId: 'userStatisticsLine', option : echartOptionLine},
                      ];

</script>
