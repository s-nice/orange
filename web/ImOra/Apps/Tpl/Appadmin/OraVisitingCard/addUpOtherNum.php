<layout name="../Layout/Layout"/>
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="form_margintop">
                <div class="content_search">
                    <form name="headForm" action="{:U('OraStatCard/index',array('itemKey'=>$itemKey),'',true)}" method="get" >
                    <div class="search_right_c">
                        <div class="js_proversion select_IOS menu_list select_option input_s_width js_s_div">
                            <input type="text" value="{:$_GET['s_versions']?$_GET['s_versions']:'全部软件版本'}" name='sysPlatform' readonly="readonly"  disabled="disabled" />
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            <b></b>
                            <input type="hidden" name="s_versions" value="{$s_versions_name}">
                            <ul class="js_scroll_list" style="max-height:300px;">
                                <li title="全部" val="all"><input name="software" value="all" type="checkbox" >全部</li>
                                <foreach name="s_versions" item="v">
                                    <li title="{$v}"><input type="checkbox" value="{$v}" <if condition="in_array($v,$s_versions_check)">checked="checked"</if>>{$v}</li>
                                </foreach>
                            </ul>
                        </div>
                        <div class="js_modelversion select_IOS menu_list select_option input_s_width js_s_div">
                            <input type="text" name="channel" value="{:$_GET['h_versions']?$_GET['h_versions']:'全部硬件版本'}"  readonly="readonly"  disabled="disabled" />
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            <b></b>
                            <input type="hidden" name="h_versions" value="{$h_versions_name}">
                            <ul class="js_scroll_list" style="max-height:300px;">
                                <li title="全部" val="all"><input name="hardware" value="all" type="checkbox" >全部</li>
                                <foreach name="h_versions" item="v">
                                    <li title="{$v}"><input type="checkbox"  value="{$v}" <if condition="in_array($v,$h_versions_check)">checked="checked"</if>>{$v}</li>
                                </foreach>
                            </ul>
                        </div>
                        <div class="select_time_c">
                            <span>{$T->str_time}</span>
                            <div class="time_c">
                                <input id="js_endtime" class="time_input" type="text" name="endTime" readonly="readonly" value="{$endTime}" />
                                <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            </div>
                        </div>
                        <input class="submit_button" type="button" value="{$T->str_submit}"/>
                    </div>
                    </form>
                </div>
                <!-- stat type -->
                <div id="js_stat_type" class="select_xinzeng margin_top js_se_div">
                    <input type="text" title="{$selectArr[$itemKey]['name']}" value="{$selectArr[$itemKey]['name']}" val="{$selectArr[$itemKey]['id']}">
                    <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png"></i>
                    <ul>
                        <foreach name="selectArr" item="sv" >
                            <li class="{:($itemKey == $sv['id'] ? 'on' : '')}" title="{$sv.name}" val="{$sv.id}">{$sv.name}</li>
                        </foreach>
                    </ul>
                </div>
			</div>
			<!--图表放置-->
			<div id="userStatisticsLine" style="width:820px;height:500px;overflow:hidden;">
				
			</div>
			<div id="userStatisticsData">
				<div class="Data_bt">
					<span class="left_s">累计人均他人名片数量数据表</span>
					<if condition="count($data['data']) gt 0">
                            <a href="<?php echo U('Appadmin/'.CONTROLLER_NAME.'/'.ACTION_NAME.'/itemKey/2/isdownload/1', $param_get ); ?>">
                                <button class="right_down" style="cursor: pointer;">{$T->str_export}</button>
                            </a>
            		</if>
				</div>
				<div class="table_content">
					<div class="table_list table_tit">
						<span class="span_t1">日期</span>
						<span class="span_t1">软件版本</span>
						<span class="span_t1">硬件版本</span>
						<span class="span_t1">累计人均他人名片数量</span>
					</div>
                    <div class="clear" id="js_scroll_dom" style="max-height:438px;">
                        <if condition="count($data['data']) gt 0">
                            <foreach name="data['data']" item="v">
                            <div class="table_list">
                                <span class="span_t1">{$v.timetype}</span>
                                <span class="span_t1">{$v.pro_version}</span>
                                <span class="span_t1">{$v.model}</span>
                                <span class="span_t1">{$v['average_value']}</span>
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
<script>
    var selfUrl = "{:U('OraStatCard/index','','',true)}";
    var subUrl = "{:U('OraStatCard/index',array('itemKey'=>$itemKey),'',true)}";
    $(function(){
        $.orastatcards.init();
        $.orastatcards.addupCardInit();

        var chart = echarts.init(document.getElementById('userStatisticsLine'));
        chart.setOption({
            tooltip : {
                trigger: 'axis'
            },
            legend: {
                data:[]
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '8%',
                containLabel: true
            },
            calculable : true,
            xAxis : [
                {
                    type : 'category',
                    boundaryGap : false,
                    data : [
                        <?php
                        foreach($data['xlinedata'] as $v){
                            echo '"'.$v.'",';
                        }
                    ?>
                    ]
                }
            ],
            yAxis : [
                {
                    type : 'value',
                    splitNumber: 6,
                    minInterval:1,
                    max : {$data['maxval']},
                    interval: {$data['aveval']},
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
                    if(!empty($data['data'])){

                ?>
                {
                    name: '累计人均他人名片数量',
                    type: 'line',
                    itemStyle: {normal: {color: '#123abc'}}, // 折线颜色
                    data: [
                        <?php
                            foreach($data['xlinedata'] as $vv){
                                $mark = 0;
                                foreach($data['data'] as $ke=>$va){
                                    if($vv == $va['timetype']){
                                        echo '"'.sprintf("%.2f", $va['average_value']).'",';
                                        $mark = 1;
                                        break;
                                    }
                                }
                                if($mark){
                                    continue;
                                }else{
                                    echo '"0",';
                                }

                            }
                        ?>
                    ]
                },
                <?php
                    }
                ?>
            ]
        });

    });
</script>