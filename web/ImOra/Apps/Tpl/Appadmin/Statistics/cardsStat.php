<layout name="../Layout/Layout"/>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <include file="Statistics/_head" />
            <div id="userStatisticsLine" style="width:820px;height:500px;" class=""></div>
            <div id="userStatisticsData" class="">
            	<div class="Data_bt Data_bt_top">
	            	<span class="left_s">{$select[$selecItem]}{$T->stat_table_title}</span>
	            	<if condition="count($tableArr) gt 0">
	            		<span id="js_download" class="right_s" style="cursor: pointer;">{$T->str_export}</span>
	            	</if>
            	</div>
            	<div class="Data_c_content">
            		<div class="Data_cjs_name cards_content_2">
						<span class="span_c_1">{$T->stat_date}</span>
		                <span class="span_c_2">{$T->stat_sys_platform}</span>
		                <span class="span_c_3">{$T->stat_new_add_cardnum}</span>
		                <span class="span_c_4">{$T->stat_scan_add_card_num}({$T->stat_proportion})</span>
		                <span class="span_c_5">{$T->stat_selfadd_card_num}({$T->stat_proportion})</span>
		                <span class="span_c_6">{$T->stat_contacts_card_num}({$T->stat_proportion})</span>
		                <span class="span_c_7">{$T->stat_exchange_card_num}({$T->stat_proportion})</span>
		                <span class="span_c_8">{$T->stat_qrscan_card_num}({$T->stat_proportion})</span>
		            </div>
		            <div class="js_scroll_data ">
		            <if condition="count($tableArr) gt 0">
		                <foreach name="tableArr" item="timeArr" key='platform'>
		                	<foreach name="timeArr" item="v" key='time'>
			                <div class="Data_c_list_z cards_content_2">
			                  <span class="span_c_1">{$v['time']}</span>
			                  <php> unset($v['time']);$total = array_sum($v);</php>
			                  <span class="span_c_2">{$T->$platform}</span>
			                  <span class="span_c_3">{$total}</span>
			                  <if condition="$total != 0">
			                  <span class="span_c_4">{:isset($v['scan'])?$v['scan'].'('.round($v['scan']/$total,2)*100 .'%)':'0(0%)'}</span>
			                  <span class="span_c_5">{:isset($v['selfadd'])?$v['selfadd'].'('.round($v['selfadd']/$total,2)*100 .'%)':'0(0%)'}</span>
			                  <span class="span_c_6">{:isset($v['contacts'])?$v['contacts'].'('.round($v['contacts']/$total,2)*100 .'%)':'0(0%)'}</span>
			                  <span class="span_c_7">{:isset($v['exchage'])?$v['exchage'].'('.round($v['exchage']/$total,2)*100 .'%)':'0(0%)'}</span>
			                  <span class="span_c_8">{:isset($v['qrscan'])?$v['qrscan'].'('.round($v['qrscan']/$total,2)*100 .'%)':'0(0%)'}</span>
			                  <else />
			                  <span class="span_c_4">0(0%)</span>
			                  <span class="span_c_5">0(0%)</span>
			                  <span class="span_c_6">0(0%)</span>
			                  <span class="span_c_7">0(0%)</span>
			                  <span class="span_c_8">0(0%)</span>
			                  </if>
			                </div>
		                	</foreach>
		                </foreach>
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

</script>