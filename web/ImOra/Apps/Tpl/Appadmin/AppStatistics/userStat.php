<layout name="../Layout/Layout"/>
<div class="content_global">
 <div class="content_hieght">
        <div class="content_c">
        <form class="form_margintop" action="{:U('AppStatistics/user')}" method='post'>
            <div class="content_search">
            	<div class="search_right_c">
            	
            	    <div id="select_platform" class="select_IOS menu_list js_select_item">
            			<input type="text" value="<if condition='!empty($sysPlatform)'>{$sysPlatform}<else/>{$T->str_title_app_type}</if>" name='sysPlatform' readonly="readonly" />
            			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            			<ul>
            			    <li class='on' val="" title="{$T->str_title_app_type}">{$T->str_title_app_type}</li>

<!--             			    <li val="{$T->str_title_app_type}" title="{$T->str_title_app_type}">{$T->str_title_app_type}</li> -->
            				<li val="IOS" title="IOS" <if condition="$sysPlatform=='IOS'"></if> >IOS</li>
            				<li val="Android" title="Android" <if condition="$sysPlatform=='Android'">class='on'</if> >Android</li>
            				<li val="Leaf" title="Leaf" <if condition="$sysPlatform=='Leaf'">class='on'</if> >Leaf</li>
            			</ul>
            		</div>
            		
            	<if condition=' $T.str_new_add__account ==$type'>
            	           		<div id="select_country" class="select_sketch select_IOS menu_list js_select_item js_multi_select">
            			<input type="text" value="<if condition='!empty($country)'>{$country}<else/>{$T->str_country}</if>" name='country' readonly="readonly" />
            			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            			<ul>
            			    <li val="" title="{$T->str_country}" class="js_all_in_one">{$T->str_country}</li>
            			    <foreach name='countrys' item='countr'>
            				<li  val="<php>echo $countr['country'];</php>" title="<php>echo $countr['country'];</php>" <php> if(strstr($country,$countr['country'])!==false){echo "class='on'";}</php> ><php> echo $countr['country'];</php> </li>
            		    	</foreach>
            			</ul>
            		</div>
            		<div id="select_province" class="select_sketch js_select_item  js_multi_select">
            			<input type="text" name="province" value="<if condition='!empty($province)'>{$province}<else/>{$T->str_province}</if>"  readonly="readonly" />
            			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            			<ul>
            			<li val='{$T->str_province}' title='{$T->str_province}' class='js_all_in_one'>{$T->str_province}</li>
            			<foreach name='provinces' item='provinc'>
            				<li data-link-value=",{$provinc['countrys']},"  val="<php>echo $provinc['province'];</php>" title="<php>echo $provinc['province'];</php>" <php> if(strstr($province,$provinc['province'])!==false){echo "class='on'";}</php> ><php>echo $provinc['province'];</php> </li>
            		    </foreach>
            			</ul>
            		</div>
            	
            	</if>
            	

            		<div id="select_channel" class="select_sketch menu_list js_select_item  js_multi_select">
            			<input type="text" name="channel" value="<if condition='!empty($channel)'>{$channel}<else/>{$T->str_channel}</if>"  readonly="readonly" />
            			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            			<ul>
            			<li class="on" val='{$T->str_channel}' title='{$T->str_channel}' class='js_all_in_one'>{$T->str_channel}</li>
            			<foreach name='channels' item='channe'>
            				<li data-link-value=",{$channe['sys_platforms']},"  val="<php>echo $channe['channel'];</php>" title="<php>echo $channe['channel'];</php>" <php> if(strstr($channel,$channe['channel'])!==false){echo "class='on'";}</php> ><php>echo $channe['channel'];</php> </li>
            		    </foreach>
            			</ul>
            		</div>
            	<div class="select_time_c">
					    <span>{$T->str_time}</span>
						<div class="time_c">
							<input id="js_begintime" class="time_input" type="text" name="startTime" value='{$startTime}' readonly="readonly" />
							<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
						</div>
						<span>--</span>
						<div class="time_c">
							<input id="js_endtime" class="time_input" type="text" name="endTime" value='{$endTime}' readonly="readonly" />
							<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
						</div>
			          <!--   <input class="time_button" type="button" value="{$T->str_contrast_time}"/> -->
			             <div class="time_duibi" style='display:<if condition='empty($lstartTime)||empty($lendTime)'>none<else/>block</if>'>
			            	<div class="time_c time_right">
								<input class="time_input" id="js_begintime1" type="text" name="lstartTime" value='{$lstartTime}' readonly="readonly" />
								<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
							</div>
							<span>--</span>
							<div class="time_c">
								<input class="time_input" id="js_endtime1" type="text" name="lendTime" value='{$lendTime}' readonly="readonly" />
								<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
							</div>
							<!-- <input class="timeduibi_button" type="button" value="{$T->str_contrast_time}"/> -->
			            </div>
	            	</div>
	            	<input type='hidden' name='statType' value='<if condition="!empty($statType)">{$statType}<else/>day</if>'>
	            	<input class="submit_button" type="button" value="{$T->str_submit}"/>
            	</div>
            </div>
             <div class="js_stat_date_type">
				<a class="<if condition="empty($statType)||$statType=='day'">on</if>" val='day'>{$T->str_day}</a>
				<a class="<if condition="$statType=='week'">on</if>" val='week'>{$T->str_week}</a>
				<a class="<if condition="$statType=='month'">on</if>" val='month'>{$T->str_month}</a>
			</div>
            <div class="select_xinzeng js_select_item js_select_margintop">
            	<input type="text" value="<if condition='!empty($type)'>{$type}<else/>{$T->str_new_add_device}</if>" name='type' readonly="readonly" />
            	<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            	<ul>
            		<li val="{$T->str_new_add_device}" title="{$T->str_new_add_device}">{$T->str_new_add_device}</li>
            		<li val="{$T->str_new_add__reg_device}" title="{$T->str_new_add__reg_device}">{$T->str_new_add__reg_device}</li>
            		<!-- <li val="{$T->str_new_add__reg_device_rate}" title="{$T->str_new_add__reg_device_rate}">{$T->str_new_add__reg_device_rate}</li> -->
            		<li val="{$T->str_new_add__account}" title="{$T->str_new_add__account}">{$T->str_new_add__account}</li>
            		<li val="{$T->str_activate__account}" title="{$T->str_activate__account}">{$T->str_activate__account}</li>

            	</ul>
            </div>
            </form>
            <div id="userStatisticsLine" style="width:820px;height:500px;" class=""></div>
            <div id="userStatisticsData" class="">
            	<div class="Data_bt Data_bt_top"><span class="left_s">{$type}{$T->str_data_tab}</span><if condition="count($userStats) gt 0"><span class="right_s">
            	<!-- <a href="{:U(CONTROLLER_NAME.'/'.ACTION_NAME, array('platform'=>$platform,'startTime'=>$startTime, 'endTime'=>$endTime,'statType'=>$statType,'downloadStat'=>1,'type'=>$type))}">{$T->str_export}</a> -->
            	  <a href="javascript:void(0);" id="exportBtn" url="{:U(CONTROLLER_NAME.'/'.ACTION_NAME)}">{$T->str_export}</a>
            	</span></if></div>
            	<div class="Data_c_content js_data_area">
		                <div class="Data_c_name">
		                  <span class="span_c_1">{$T->stat_date}</span>
		                  <span class="span_c_1">{$T->stat_sys_platform}</span>
		                  <span class="span_c_1">{$T->stat_channel}</span>
		                  <span class="span_c_2">{$type}</span>
		                </div>
		                <div class="js_scroll_data">
		                 <if condition="count($userStats) gt 0">
		                <volist name="userStats" id="_userStat">
		                <div class="Data_c_list">
		                  <span class="span_c_1">{$_userStat.time}</span>
		                  <span class="span_c_1"><php>if($sysPlatform!==''){echo $_userStat['sys_platform'];}else{echo $T->str_label_all;}</php></span>
		                  <span class="span_c_1"><php>if($channel!==''){echo $_userStat['channel'];}else{echo $T->str_label_all;}</php></span>
		                  <span class="span_c_2"><php>if($type==$T->str_new_add__reg_device_rate){if($_userStat['count_device_id']==0||$_userStat['count_user_id'] ==0){echo '0%';}else{echo ($_userStat['count_device_id']/$_userStat['count_user_id']*100).'%'; }}else{echo $_userStat['count_all'];}</php></span>
		                </div>
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

<script>
<include file="@Layout/js_stat_widget" />
var formData = $('.form_margintop').serializeArray();
var type = '{$statType}';
var max = {$max};//最大值
var rst=paramsForGrid(max);//通过最大值获取格数
var gStatisticDateType = type;//时间
var str_title_app_type = '{$T->str_title_app_type}';
var str_channel = '{$T->str_channel}';
var str_prd_version = '{$T->str_prd_version}';
var js_Empty_Time = '{$T->tip_select_time}';
var echartOptionLine =  {
	    tooltip : {
	        trigger: 'axis'
	    },
	    legend: {
            left: 'center',
            bottom: '0',
            selectedMode:false,
	        data:{$lenged}

        },
	    grid: {
	        left: '3%',
	        right: '4%',
	        bottom: '8%',
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
	            //注册率 加入%
	            <php>if($type==$T->str_new_add__reg_device_rate){
	           echo "axisLabel: {
	                formatter: function (val) {
	                    return val  + '%';
	                }
	            },";}
	            </php>
	            max : rst.max,
                splitNumber: rst.splitNumber,
                interval: rst.interval,
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
	    series :{$datas},
	    //backgroundColor: '#000' // 设置图表背景颜色
	};
//var echartOption = ;

var gEchartSettings = [
                       {containerId: 'userStatisticsLine', option : echartOptionLine},
                      ];
</script>