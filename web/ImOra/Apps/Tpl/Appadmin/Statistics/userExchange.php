<layout name="../Layout/Layout"/>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <form class="form_margintop" action="{:U('Appadmin/Statistics/CardExchange','',false)}" method="get" >
                <div class="content_search">
                    <div class="search_right_c">
                        <!--系统平台-->
                        <div class="select_IOS menu_list toggledom js_select_ul_list">
                          <input type="hidden" name="platform" value="{$search_condition['platform']}">
                          <if condition="$search_condition['platform'] eq 'ios'">
                              <input type="text" marks="mark" title='IOS{$T->str_exchange_plat}' value="IOS{$T->str_exchange_plat}" readonly="true" />
                              <elseif condition="$search_condition['platform'] eq 'android'" />
                              <input type="text" marks="mark" title='Android{$T->str_exchange_plat}'  value="Android{$T->str_exchange_plat}" readonly="true" />
                              <elseif condition="$search_condition['platform'] eq 'leaf'" />
                              <input type="text" marks="mark" title='Leaf'  value="Leaf" readonly="true" />
                              <else/>
                              <input type="text" marks="mark" title='{$T->stat_sys_platform}'  value="{$T->stat_sys_platform}" readonly="true" />
                          </if>
                          <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                          <ul>
                              <li class="on" marks="mark" class="js_platform" title="" data-val="">{$T->stat_sys_platform}</li>
                              <li marks="mark" class="js_platform" title="IOS{$T->str_exchange_plat}" data-val="IOS">IOS{$T->str_exchange_plat}</li>
                              <li marks="mark" class="js_platform" title="Android{$T->str_exchange_plat}" data-val="Android">Android{$T->str_exchange_plat}</li>
                              <li marks="mark" class="js_platform" title="Leaf" data-val="Leaf">Leaf</li>
                          </ul>
                        </div>
                        <div class="select_sketch menu_list toggledom js_select_ul_list js_multi_select">
                            <input type="hidden" name="version" value="{$search_condition['version']}">
                            <empty name="search_condition['version']" >
                                <input type="text" marks="mark" title='{$T->str_exchange_version}' value="{$T->str_exchange_version}" readonly />
                              <else/>
                                <input type="text" marks="mark" title="{$search_condition['version']}" value="{$search_condition['version']}" readonly />
                            </empty>
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                                <ul id="js_version_li" style="max-height:200px;overflow: hidden">
                                    <li class="on" class='js_version js_all_in_one' marks="mark" title="{$T->str_exchange_version}" data-val="">{$T->str_exchange_version}</li>
                                    <foreach name="versionlist['select_list']" item="val">
                                        <li class="js_version" title="{$val}" marks="mark" data-val="{$val}">{$val}</li>
                                    </foreach>
                                </ul>
                            <div class="js_select_container" style="display:none;">
                                {$sys_version}
                            </div>
                        </div>
                        <div class="select_time_c">
                            <span>{$T->str_feedback_time}</span>
                            <div class="time_c">
                                <input class="time_input" type="text" id="js_begintime" readonly="readonly" name="begintime" value="<?php if(!empty($search_condition['timestart_show'])){echo date('Y-m-d',strtotime($search_condition['timestart_show']));} ?>" />
                                <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            </div>
                            <span>--</span>
                            <div class="time_c">
                                <input class="time_input" type="text" id="js_endtime" readonly="readonly" name="endtime" value="<?php if(!empty($search_condition['timeend_show'])){echo date('Y-m-d',strtotime($search_condition['timeend_show']));} ?>" />
                                <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            </div>

                        </div>
                        <input class="submit_button" type="submit" value="{$T->str_exchange_sub}"/>
                  </div>
                </div>
                <div class="select_xinzeng toggledom margin_top js_select_ul_list">
                    <input type="hidden" name="drawtype" value="{$search_condition['drawtype']}">
                    <if condition="$search_condition['drawtype'] eq 'proportion'">
                        <input type="text"  marks='mark' value="{$T->str_exchange_title}{$T->str_exchange_proportion}" readonly />
                        <elseif condition="$search_condition['drawtype'] eq 'usertotal'" />
                        <input type="text"  marks='mark' value="{$T->str_exchange_title}{$T->str_exchange_numbers}" readonly />
                        <else/>
                        <input type="text"  marks='mark' value="{$T->str_exchange_title}{$T->str_exchange_times}" readonly />
                    </if>
                    <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                    <ul>
                        <li class="js_drawtype" marks="mark" data-val="usertotal">{$T->str_exchange_title}{$T->str_exchange_numbers}</li>
                        <li class="js_drawtype" marks="mark" data-val="proportion">{$T->str_exchange_title}{$T->str_exchange_proportion}</li>
                        <li class="js_drawtype" marks="mark" data-val="changenumb">{$T->str_exchange_title}{$T->str_exchange_times}</li>
                    </ul>
                </div>
                <div class="js_stat_date_type" style="z-index:11;position:relative;">
                    <input type="hidden" name="timetype" <notempty name="search_condition['timetype']"> value="{$search_condition['timetype']}" <else/> value="d" </notempty>" >
                    <a <if condition="$search_condition['timetype'] eq 'd'"> class="on"  </if> href="<?php echo U('Appadmin/'.CONTROLLER_NAME.'/'.ACTION_NAME.'/timetype/d', $_GET ); ?>">{$T->str_exchange_time_day}</a>
                    <a <if condition="$search_condition['timetype'] eq 'w'"> class="on"  </if> href="<?php echo U('Appadmin/'.CONTROLLER_NAME.'/'.ACTION_NAME.'/timetype/w', $_GET ); ?>">{$T->str_exchange_time_week}</a>
                    <a <if condition="$search_condition['timetype'] eq 'm'"> class="on"  </if> href="<?php echo U('Appadmin/'.CONTROLLER_NAME.'/'.ACTION_NAME.'/timetype/m', $_GET ); ?>">{$T->str_exchange_time_month}</a>
                </div>
            </form>
            <div id="userStatisticsLine" style="width:820px;height:500px;" class=""></div>
            <div id="userStatisticsData" class="">
            	<div class="Data_bt Data_bt_top">
                    <span class="left_s">
                        <if condition="$search_condition['drawtype'] eq 'usertotal'">
                            {$T->str_exchange_title}{$T->str_exchange_numbers}{$T->str_exchange_data}
                            <elseif condition="$search_condition['drawtype'] eq 'proportion'" />
                            {$T->str_exchange_title}{$T->str_exchange_proportion}{$T->str_exchange_data}
                            <elseif condition="$search_condition['drawtype'] eq 'changenumb'" />
                            {$T->str_exchange_title}{$T->str_exchange_times}{$T->str_exchange_data}
                        </if>
                    </span>
                        <notempty name="reportlist">
                            <span class="right_s" ><a href="<?php echo U('Appadmin/'.CONTROLLER_NAME.'/'.ACTION_NAME.'/downloadStat/1', $param_get ); ?>">{$T->str_exchange_export}</a></span>
                        </notempty>
                </div>
            	<div class="Data_c_content">
                    <div class="Data_userserach_name">
                        <span class="span_c_1">{$T->str_exchange_date}</span>
                        <span class="span_c_2">{$T->stat_sys_platform}</span>
                        <span class="span_c_3">{$T->str_exchange_version}</span>
                        <if condition="$search_condition['drawtype'] eq 'usertotal'">
                            <span class="span_c_4">{$T->str_exchange_title}{$T->str_exchange_numbers}</span>
                            <span class="span_c_5">{$T->str_exchange_scans}{$T->str_exchange_numbers}</span>
                            <span class="span_c_6">{$T->str_exchange_manys}{$T->str_exchange_numbers}</span>
                        <elseif condition="$search_condition['drawtype'] eq 'proportion'" />
                            <span class="span_c_4">{$T->str_exchange_title}{$T->str_exchange_proportions}</span>
                            <span class="span_c_5">{$T->str_exchange_scans}{$T->str_exchange_proportions}</span>
                            <span class="span_c_6">{$T->str_exchange_manys}{$T->str_exchange_proportions}</span>
                        <elseif condition="$search_condition['drawtype'] eq 'changenumb'" />
                            <span class="span_c_4">{$T->str_exchange_totalnumb}</span>
                            <span class="span_c_5">{$T->str_exchange_scans}{$T->str_exchange_times}</span>
                            <span class="span_c_6">{$T->str_exchange_manys}{$T->str_exchange_times}</span>
                        </if>
                    </div>
                    <div id="js_scroll_id" style="height:450px;">
                        <empty name="reportlist">
                            no data!
                        </empty>
                        <volist name="reportlist" id="_vv">
                            <div class="Data_userserach_list">
                                <span class="span_c_1">{$_vv.timetype}</span>
                                <span class="span_c_2">{$_vv.sys_platform}</span>
                                <span class="span_c_3" title="{$_vv.prd_version}">{$_vv.prd_version}</span>
                                <if condition="$search_condition['drawtype'] eq 'usertotal'">
                                    <span class="span_c_4">{$_vv.numb_all}</span>
                                    <span class="span_c_5">{$_vv['numb_s']}</span>
                                    <span class="span_c_6">{$_vv['numb_m']}</span>
                                <elseif condition="$search_condition['drawtype'] eq 'proportion'" />
                                    <span class="span_c_4">{$_vv.proportion_all}</span>
                                    <span class="span_c_5">{$_vv['proportion_s']}</span>
                                    <span class="span_c_6">{$_vv['proportion_m']}</span>
                                <elseif condition="$search_condition['drawtype'] eq 'changenumb'" />
                                    <span class="span_c_4">{$_vv.ext_all}</span>
                                    <span class="span_c_5">{$_vv['ext_s']}</span>
                                    <span class="span_c_6">{$_vv['ext_m']}</span>
                                </if>
                            </div>
                        </volist>
                    </div>
		         </div>
            </div>
        </div>
    </div>
</div>

<script>
    var gStatisticDateType = '{$search_condition["timetype"]}';
    var js_str_exchange_version = "{$T->str_exchange_version}";


// 指定图表的配置项和数据
var echartOptionLine =  {
	    tooltip : {
	        trigger: 'axis'
	    },
	    legend: {
            left: 'center',
            bottom: '0',
            selectedMode:false,
	        data:[
                <?php
                    echo '"'.$T->str_exchange_all.'","'.$T->str_exchange_many.'","'.$T->str_exchange_scan.'"';
                ?>
            ]

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
	            data : [
                    <?php
                        foreach($timelist as $v){
                            echo '"'.$v.'",';
                        }
                    ?>
                ],
	            axisLabel : {
		            textStyle : {
			            color : '#656565'
		            }
	            },
	            axisLine: {
	                lineStyle: {
	                    // 使用深浅的间隔色
	                    color: '#B8B8B8',
	                    width: 1
	                }
	            },
	            splitLine: {
	            	show:false,
	                lineStyle: {
	                    // 使用深浅的间隔色
	                    color: ['#fff'],
	                    type : 'dashed'
	                }
	            }
	        }
	    ],
	    yAxis : [
	        {
	            type : 'value',
                splitNumber: 6,
                max : {$y_max},
                interval: {$y_avg},
	            splitLine: {
	            	show:true,
	                lineStyle: {
	                    // 使用深浅的间隔色
	                    color: ['#B8B8B8'],
	                    type : 'dashed'
	                }
	            }
	        }
	    ],
	    series : [
            <?php
        if(!empty($drawline)){
            if($search_condition['drawtype'] == 'usertotal'){
                $i=0;
                foreach($drawline as $kk => $vv){
            ?>
                {
                    name: '<?php if($kk=='all'){echo $T->str_exchange_all;}else if($kk=='scan'){echo $T->str_exchange_scan;}else if($kk=='many'){echo $T->str_exchange_many;} ?>',
                    type: 'line',
                    itemStyle: {normal: {color: '<?php echo $colorlist[$i];?>'}}, // 折线颜色
                    data: [
                        <?php
                            foreach($vv as $ke=>$va){
                                echo '"'.$va['numb'].'",';
                            }
                        ?>
                    ]
                },
            <?php
                $i++;
                }
            } else if($search_condition['drawtype'] == 'proportion') {
                $i=0;
                foreach($drawline as $kk => $vv){

            ?>
            {
                name: '<?php if($kk=='all'){echo $T->str_exchange_all;}else if($kk=='scan'){echo $T->str_exchange_scan;}else if($kk=='many'){echo $T->str_exchange_many;} ?>',
                type: 'line',
                itemStyle: {normal: {color: '<?php echo $colorlist[$i];?>'}}, // 折线颜色
                data: [
                    <?php
                        foreach($vv as $ke=>$va){
                            echo '"'.$va['proportion'].'",';
                        }
                    ?>
                ]
            },
            <?php
                $i++;
                }

            } else if($search_condition['drawtype'] == 'changenumb') {
                $i=0;
                foreach($drawline as $kk => $vv){
            ?>
            {
                name: '<?php if($kk=='all'){echo $T->str_exchange_all;}else if($kk=='scan'){echo $T->str_exchange_scan;}else if($kk=='many'){echo $T->str_exchange_many;} ?>',
                type: 'line',
                itemStyle: {normal: {color: '<?php echo $colorlist[$i];?>'}}, // 折线颜色
                data: [
                    <?php
                        foreach($vv as $ke=>$va){
                            echo '"'.$va['ext'].'",';
                        }
                    ?>
                ]
            },
            <?php
                $i++;
                }
            }
        }
            ?>
	    ]
	    //backgroundColor: '#000' // 设置图表背景颜色
	};
//var echartOption = ;

var gEchartSettings =   [
                               {
                                   containerId: 'userStatisticsLine',  //dom id
                                   option : echartOptionLine            //config
                               },
                            ];


$(function(){

    //
    $.exchange.init();

});

</script>