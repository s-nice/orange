<layout name="../Layout/Layout"/>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
	        <div class="form_margintop">
	            <div class="content_search">
	            	<div class="search_right_c">
	            		<div class="select_IOS menu_list">
	            			<input name="platform" type="text" val="{$platform}" value="<if condition='$platform'>{$platform}<else />{$T->str_all_platform}</if>" readonly="readonly" />
	            			<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	            			<ul>
                                <li class="on" title="{$T->str_all_platform}" val="">{$T->str_all_platform}</li>
	            				<li title="IOS" val="IOS">IOS</li>
	            				<li title="Android" val="Android">Android</li>
	            				<li title="Leaf" val="Leaf">Leaf</li>
	            			</ul>
	            		</div>
	            		<div class="select_time_c">
						    <span>{$T->str_time}</span>
							<div class="time_c">
								<input class="time_input" type="text" name="start_time" readonly="readonly" id="start_time" value="{$start_time}" />
								<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
							</div>
							<span>--</span>
							<div class="time_c">
								<input class="time_input" type="text" name="end_time" readonly="readonly" id="end_time" value="{$end_time}" />
								<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
							</div>
				            <input id="statistics" class="submit_button_c" type="button" value="{$T->str_submit}"/>
		            	</div>
	            	</div>
	            </div>
	            <div class="js_stat_date_type">
	                  <a val="day" <if condition="$type eq 'day'">class="on"</if>>{$T->str_day}</a>
	                  <a val="week" <if condition="$type eq 'week'">class="on"</if>>{$T->str_week}</a>
	                  <a val="month" <if condition="$type eq 'month'">class="on"</if>>{$T->str_month}</a>
	                  <input type="hidden" name="type" value="{$type}" />
	            </div>
	            <div class="select_xinzeng margin_top">
	            	<input name="sle_type" type="text" val="{$sle_type}" value="{$sle_name}" readonly="readonly" />
	            	<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	            	<ul>
	            		<li val="1" ahref="{:U(MODULE_NAME.'/Network/index',array('t'=>1))}" title="{$T->str_new_task}">{$T->str_new_task}</li>
	            		<li val="2" ahref="{:U(MODULE_NAME.'/Network/index',array('t'=>2))}" title="{$T->str_task_user}">{$T->str_task_user}</li>
	            		<li val="3" ahref="{:U(MODULE_NAME.'/Network/index',array('t'=>3))}" title="{$T->str_task_user_per}">{$T->str_task_user_per}</li>
	            		<li val="4" ahref="{:U(MODULE_NAME.'/Network/index',array('t'=>4))}" title="{$T->str_new_record}">{$T->str_new_record}</li>
	            		<li val="5" ahref="{:U(MODULE_NAME.'/Network/index',array('t'=>5))}" title="{$T->str_record_user_per}">{$T->str_record_user_per}</li>
	            		<li val="6" ahref="{:U(MODULE_NAME.'/Network/index',array('t'=>6))}" title="{$T->str_im_user}">{$T->str_im_user}</li>
	            		<li val="7" ahref="{:U(MODULE_NAME.'/Network/index',array('t'=>7))}" title="{$T->str_im_user_per}">{$T->str_im_user_per}</li>
	            		<li val="8" title="{$T->str_record_sum}">{$T->str_record_sum}</li>
	            	</ul>
	            </div>
            </div>
            <div id="userStatisticsBar" style="width:820px;height:500px; margin-bottom:20px" class=""></div>
            <div id="userStatisticsData" class="">
            	<div class="Data_bt Data_bt_top"><span class="left_s">{$T->str_new_task}</span><span class="right_s" id="export">{$T->str_export}</span></div>
                  <div style="display:none">
                        <iframe id="down-file-iframe" >
                        </iframe>
                        <form id="exportForm" action="{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/export')}" method="post" target="down-file-iframe">
                              <input type="hidden" name="data" value='' />
                              <input type="hidden" name="ex_platform" value='' />
                              <input type="hidden" name="ex_channel" value='' />
                              <input type="hidden" name="ex_sle_type" value='' />
                        </form>
                  </div>
            	<div class="Data_c_content_1">
	                 
		      </div>
            </div>
        </div>
    </div>
</div>
<script>
var postUrl = "{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/task')}";
var slefUrl = "{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/index')}";
var postTabUrl = "{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/ajaxTab')}";
var colorlist = '{$colorlist}';
colorlist = JSON.parse(colorlist);
</script>