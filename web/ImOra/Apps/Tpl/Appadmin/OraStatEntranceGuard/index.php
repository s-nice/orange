<layout name="../Layout/Layout"/>
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="form_margintop">
                <div class="content_search">
                    <form name="headForm" action="{:U('OraStatEntranceGuard/index',array('itemKey'=>$itemKey),'',true)}" method="get" >
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
                            <if condition="$type eq 1 or $type eq 2">
                                <div class="time_c">
                                    <input id="js_begintime" class="time_input" type="text" name="startTime"  readonly="readonly" value="{$startTime}" autocomplete='off'/>
                                    <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                                </div>
                                <span>--</span>
                            </if>
                            <div class="time_c">
                                <input id="js_endtime" class="time_input" type="text" name="endTime" readonly="readonly" value="{$endTime}" autocomplete='off'/>
                                <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                            </div>
                        </div>
                        <input class="submit_button" type="button" value="{$T->str_submit}"/>
                    </div>
                    </form>
                </div>
                <!-- stat type -->
                <div id="js_stat_type" class="select_xinzeng margin_top js_se_div">
                    <input type="text" title="{$typename}" value="{$typename}" val="{$type}">
                    <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png"></i>
                    <ul>
                        <foreach name="stat_types" item="sv" key="sk">
                            <li class="{:($type == $sk ? 'on' : '')}" title="{$sv.name}" val="{$sk}">{$sv.name}</li>
                        </foreach>
                    </ul>
                </div>
                <if condition="isset($date_types)">
                    <div class="js_stat_date_type">
                        <foreach name="date_types" item="dv" key="dk">
                            <a <if condition="$date_type eq $dk">class="on" </if>>{$dv}</a>
                        </foreach>
                    </div>
                </if>
			</div>
			<!--图表放置 -->
			<div id="userStatisticsLine" style="width:820px;height:500px;overflow:hidden;">

			</div>
			<div id="userStatisticsData">
				<div class="Data_bt">
					<span class="left_s">{$stat_types[$type]['name']}数据表</span>
					<if condition="count($data['listdata']) gt 0">
                            <a href="<?php echo U('Appadmin/'.CONTROLLER_NAME.'/'.ACTION_NAME.'/isdownload/1', $param_get ); ?>">
                                <button class="right_down" style="cursor: pointer;">{$T->str_export}</button>
                            </a>
            		</if>
				</div>
                <if condition="$type eq 0">
                    <include file="@Appadmin/OraStatEntranceGuard/datalist1"/>
                    <elseif condition="$type eq 1" />
                    <include file="@Appadmin/OraStatEntranceGuard/datalist2"/>
                    <elseif condition="$type eq 2" />
                    <include file="@Appadmin/OraStatEntranceGuard/datalist3"/>
                    <else/>
                    <include file="@Appadmin/OraStatEntranceGuard/datalist4"/>
                </if>
			</div>
		</div>
	</div>
</div>
<script>
    var selfUrl = "{:U('OraStatEntranceGuard/index','','',true)}";
    var subUrl = "{:U('OraStatEntranceGuard/index',array('itemKey'=>$itemKey),'',true)}";
    var gStatisticDateType = "{$statisc_type}";
    $(function(){
        $.dataTimeLoad.init({statistic:gStatisticDateType,idArr: [ {start:'js_begintime',end:'js_endtime'} ]});
        $.orastatguard.init();
    });
</script>