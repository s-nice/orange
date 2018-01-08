<layout name="../Layout/Layout"/>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <include file="Statistics/_scannerhead" />
            <div id="userStatisticsLine" style="width:820px;height:500px;" class=""></div>
            <div id="userStatisticsData" class="">
            	<div class="Data_bt Data_bt_top">
            		<span class="left_s">{$select[$selecItem]}({$itemselectArr[$itemselect]}){$T->stat_table_title}</span>
            		<if condition="count($tableArr) gt 0">
            			<span class="right_s" id="js_download" style="cursor: pointer;">{$T->str_export}</span>
            		</if>
            	</div>
            	<div class="Data_c_content">
            			<div class="Data_cjs_name cards_content_6">
		                  <span class="span_c_1">{$T->stat_date}</span>
		                  <span class="span_c_2">{$T->stat_scanner_add_cardnum}</span>
		                </div>
		                <div class="js_scroll_data ">
		            <if condition="count($tableArr) gt 0">
		                <foreach name="tableArr" item="v">
			                <div class="Data_c_list_z cards_content_6">
			                  <span class="span_c_1">{$v['time']}</span>
			                  <span class="span_c_2">{$v['scancardnum']}</span>
			                </div>
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