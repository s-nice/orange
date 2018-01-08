<layout name="../Layout/Layout"/>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
			<div class="form_margintop">
	        <include file="Statistics/_behaviorStatForm" />
            <include file="Statistics/_behaviorStatChoosePage" />
	        <include file="Statistics/_behaviorStatChoosePeriod" />
	        </div>
            <div id="userStatisticsLine" style="width:820px;height:500px; overflow:hidden;" class=""></div>
            <div id="userStatisticsData" class="">
            	<div class="Data_bt">
            	  <span class="left_s">{$T->stat_sheet_avg_visit_times}</span>
            	  <if condition="count($statsList) gt 0">
            	  <php>
            	  $params =array(
            	             'platform' => $platform,
            	             'moduleId' => $reqModuleIds,
            	             'channel'  => $reqChannels,
            	             'version'  => $reqVersions,
            	             'startTime'=> $startTime,
            	             'endTime'  => $endTime,
            	             'timeType' => $timeType,
            	             'downloadStat'=>1);
            	  $urlParams = http_build_query($params);
            	  </php>
            	  <span class="right_s"><a
                       href="{:(U(CONTROLLER_NAME.'/'.ACTION_NAME).'?'.$urlParams)}">{$T->stat_export}</a>
                  </span>
            	  </if>
            	</div>
            	<div class="Data_c_content stat_behavior_sheet">
		                <div class="Data_search_name">
		                  <span class="span_c_1">{$T->stat_date}</span>
		                  <span class="span_c_2">{$T->stat_sys_platform}</span>
		                  <span class="span_c_3">{$T->stat_channel}</span>
		                  <span class="span_c_4">{$T->stat_prod_version}</span>
						  <span class="span_c_5">{$T->stat_l1_module_name}</span>
						  <span class="span_c_5">{$T->stat_avg_visit_times}</span>
						  <span class="span_c_5">{$T->stat_l2_module_name}</span>
						  <span class="span_c_6">{$T->stat_avg_visit_times}</span>
		                </div>
		                <div class="js_scroll_data">
		            <if condition="count($statsSheet) gt 0">
		                <volist name="statsSheet" id="_stat">
    		              <php>
    		              if ('week'==$timeType) {
    		                 $_stat['enter_time'] = date('o-\WW', strtotime($_stat['enter_time']));
    		              }
    		              </php>
		                <div class="Data_search_list">
		                  <span class="span_c_1">{:date($timeFormat, strtotime($_stat['enter_time']))}</span>
		                  <span class="span_c_2" title="{:htmlspecialchars($_stat['sys_platform'], ENT_QUOTES)}">{$_stat.sys_platform}</span>
		                  <span class="span_c_3" title="{:htmlspecialchars($_stat['channel'], ENT_QUOTES)}">{$_stat.channel}</span>
		                  <span class="span_c_4" title="{:htmlspecialchars($_stat['prd_version'], ENT_QUOTES)}">{$_stat.prd_version}</span>
		                  <span class="span_c_5" title="{:htmlspecialchars($_stat['parent_page_name'], ENT_QUOTES)}">{$_stat.parent_page_name}</span>
		                  <span class="span_c_5">{$_stat.count_level_one}</span>
		                  <span class="span_c_5" title="{:htmlspecialchars($_stat['page_name'], ENT_QUOTES)}">{$_stat.page_name}</span>
		                  <span class="span_c_6">{$_stat.count_all}</span>
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
var sheetTitle="{$T->stat_avg_visit_times}";
<include file="@Layout/js_stat_widget"/>
<include file="Statistics/_behaviorStatChartJs" />
</script>