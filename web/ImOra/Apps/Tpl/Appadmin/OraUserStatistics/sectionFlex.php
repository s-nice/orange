<!--用户统计 地域分布页面 -->
<layout name="../Layout/Layout"/>
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
            <div class="form_margintop">
                <!-- nav -->
                <include file="@Layout/nav_stat" />
                <div id="js_stat_type" class="select_xinzeng margin_top js_se_div">
                    <input type="text" title="{$typename}" value="{$typename}" val="{$type}">
                    <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png"></i>
                    <ul>
                        <foreach name="stat_types" item="sv" key="sk">
                            <li class="{:($type == $sk ? 'on' : '')}" title="{$sv.name}" val="{$sk}">{$sv.name}</li>
                        </foreach>
                    </ul>
                </div>
                <if condition="isset($child_stat_types)">
                    <div id="js_child_type" class="select_xinzeng margin_top js_se_div">
                        <input type="text" val="{$child_type}" value="{$child_typename}">
                        <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png"></i>
                        <ul>
                            <foreach name="child_stat_types" item="val" key="kk">
                                <li class="{:($child_type == $kk ? 'on' : '')}" val="{$kk}">{$val}</li>
                            </foreach>
                        </ul>
                    </div>
                </if>
                <if condition="isset($date_types)">
                    <div class="js_stat_date_type">
                        <foreach name="date_types" item="dv" key="dk">
                            <a <if condition="$date_type eq $dk">class="on" </if>>{$dv}</a>
                        </foreach>
                    </div>
                </if>
            </div>

            <!--图表放置-->
			<div id="userStatisticsLine" style="width:820px;height:500px;overflow:hidden;"></div>
			<div id="userStatisticsData">
				<div class="Data_bt">
					<span class="left_s">
                        {:$child_type=='world'?'国际地域':'国内地域'}分析数据表
                    </span>
                        <notempty name="data['listdata']" >
                            <a href="<?php echo U('Appadmin/'.CONTROLLER_NAME.'/'.ACTION_NAME.'/isdownload/1', $param_get ); ?>">
                                <button class="right_down" type="button">导出</button>
                            </a>
                        </notempty>
				</div>
				<div class="table_content" style="width:815px;">

					<div class="table_list table_tit">
						<span class="span_t14">日期</span>
						<span class="span_t14">软件版本</span>
						<span class="span_t14">硬件版本</span>
						<span class="span_t14">{:$child_type=='world'?'国家':'省份'}</span>
						<span class="span_t14">使用人数</span>
					</div>
                    <div class="clear" id="js_scroll_dom" style="max-height:438px;">
                        <empty name="data['listdata']">
                            No data!!!
                        </empty>

                        <foreach name="data['listdata']" item="val" >
                            <div class="table_list clear">
                                <span class="span_t14">{$val['dt']}</span>
                                <span class="span_t14">{:($param_get['s_versions']=='')?'全部':$val['pro_version']}</span>
                                <span class="span_t14">{:($param_get['h_versions']=='')?'全部':$val['model']}</span>
                                <span class="span_t14">{$val['area']}</span>
                                <span class="span_t14">{$val['active_user']}</span>
                            </div>
                        </foreach>
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
    var selfUrl = "__URL__/index"
    var postUrl = "__URL__/postData";
    var gStatisticDateType = "{$static_type}";
    $(function(){
        $.orauserstatistic.mapInit();
        var chart = echarts.init(document.getElementById('userStatisticsLine'));
        chart.setOption({
            /*legend: {
                orient: 'vertical',
                x:'left',
                data:['iphone3','iphone4','iphone5']
            },*/
            dataRange: {
                min: 0,
                max: "{$maxusernumber}",
                text:['High','Low'],
                realtime: false,
                calculable : false,
                color: ['red','yellow','lightskyblue']
            },
            series: [
                {
                    name:'maps',
                    type: 'map',
                    map: "{$child_type}",
                    itemStyle:{
                        normal:{label:{show:false}},//是否地名显示
                        emphasis:{label:{show:true}}//鼠标悬停显示地名
                    },
                    data:[
                        <?php
                            foreach($data['mapdata'] as $keys => $vals){
                                if($child_type=='china'){
                        ?>
                        {name:"{:mb_substr($vals['area'],0,(mb_strlen($vals['area'],'UTF-8')-1),'utf8')}",value:"{$vals['user_numb']}"},
                        <?php }else{ ?>
                        {name:"{$vals['area']}",value:"{$vals['user_numb']}"},
                        <?php }
                            }
                        ?>
                    ]
                }
                /*,
                {
                    name:'maps2',
                    type: 'map',
                    map: "{$child_type}",
                    itemStyle:{
                        emphasis:{label:{show:true}}
                    },
                    data:[
                        <?php
                            //foreach($data as $keys => $vals){
                        ?>
                        {name:"{$vals['area']}",value:"{$vals['active_user']}"},
                        <?php
                            //}
                        ?>
                    ]
                }*/
            ]
        });
    });
</script>
