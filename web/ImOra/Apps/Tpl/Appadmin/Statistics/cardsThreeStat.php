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
            			<span class="right_s" id="js_download" style="cursor: pointer;">{$T->str_export}</span>
            		</if>
            	</div>
            	<div class="Data_c_content">
            			<div class="Data_cjs_name cards_content_4">
		                  <span class="span_c_1">{$T->stat_date}</span>
		                  <span class="span_c_2">{$T->stat_sys_platform}</span>
		                  <span class="span_c_3">{$T->stat_exchange_add_friend}({$T->stat_proportion})</span>
		                  <span class="span_c_4">{$T->stat_qrscancard_add_friend}({$T->stat_proportion})</span>
		                  <span class="span_c_5">{$T->stat_recommend_add_friend}({$T->stat_proportion})</span>
		                  <span class="span_c_6">{$T->stat_contacts_add_friend}({$T->stat_proportion})</span>
		                  <span class="span_c_7">{$T->stat_other_add_friend}({$T->stat_proportion})</span>
		                </div>
		                <div class="js_scroll_data ">
		            <if condition="count($tableArr) gt 0">
		                <foreach name="tableArr" item="timeArr" key='platform'>
		                	<foreach name="timeArr" item="v" key='time'>
			                <div class="Data_c_list_z cards_content_4">
			                  <span class="span_c_1">{$v['time']}</span>
			                  <php> unset($v['time']);$total = array_sum($v);</php>
			                  <span class="span_c_2">{$T->$platform}</span>
			                  <if condition="$total != 0">
			                  <span class="span_c_3">{:isset($v['1'])?$v['1'].'('.round($v['1']/$total,2)*100 .'%)':'0(0%)'}</span>
			                  <span class="span_c_4">{:isset($v['2'])?$v['2'].'('.round($v['2']/$total,2)*100 .'%)':'0(0%)'}</span>
			                  <span class="span_c_5">{:isset($v['3'])?$v['3'].'('.round($v['3']/$total,2)*100 .'%)':'0(0%)'}</span>
			                  <span class="span_c_6">{:isset($v['4'])?$v['4'].'('.round($v['4']/$total,2)*100 .'%)':'0(0%)'}</span>
			                  <span class="span_c_7">{:isset($v['5'])?$v['5'].'('.round($v['5']/$total,2)*100 .'%)':'0(0%)'}</span>
			                  <else />
			                  <span class="span_c_3">0(0%)</span>
			                  <span class="span_c_4">0(0%)</span>
			                  <span class="span_c_5">0(0%)</span>
			                  <span class="span_c_6">0(0%)</span>
			                  <span class="span_c_7">0(0%)</span>
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