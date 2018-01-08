<!--飞常准 调用数据统计页面  -->
<layout name="../Layout/Layout"/>
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">

			<div class="form_margintop">
				<div class="content_search">
					<div class="search_right_c">
						<form method='get' class="js_search_form">
						<div class="select_time_c behavior_select_time_c">
							<span>日期</span>
							<div class="time_c">
								<input id="js_begintime"  name="startTime" class="time_input" type="text" readonly="readonly"
								<if condition=" isset($startTime)">value="{$startTime}"</if>>
								<i><img src="/images/appadmin_icon_xiala.png"></i>
							</div>
							<span>--</span>
							<div class="time_c">
								<input id="js_endtime" name="endTime" class="time_input" type="text" readonly="readonly"
								<if condition=" isset($endTime)">value="{$endTime}"</if>>
								<i><img src="/images/appadmin_icon_xiala.png"></i>
							</div>

						</div>
						<input type="hidden" value="{$timeType}" class="js_time_type_input" name="timeType">
						<input class="submit_button behavior_submit_button" type="submit" value="提交">
					</div>
					</form>
				</div>
				<div class="select_xinzeng margin_top js_select_type" >
					<input type="text" value="调用数据统计">
					<i><img src="/images/appadmin_icon_xiala.png"></i>
					<ul>
						<li url="{:U('Appadmin/OraStatAirLine/index',array("type"=>"pull"),'','',true)}">调用数据统计</li>
						<li url="{:U('Appadmin/OraStatAirLine/index',array("type"=>"push"),'','',true)}">推送数据统计</li>
					</ul>
				</div>
				<div class="js_stat_date_type">
					<a <if condition="$timeType eq 'day'">class="js_select_time on"<else/>class="js_select_time"</if>>1日</a>
					<a <if condition="$timeType eq 'threeDay'">class="js_select_time on"<else/>class="js_select_time"</if>>3日</a>
					<a <if condition="$timeType eq 'week'">class="js_select_time on"<else/>class="js_select_time"</if>>周</a>
					<a <if condition="$timeType eq 'month'">class="js_select_time on"<else/>class="js_select_time"</if>>月</a>
				</div>	
			</div>
			<div id="userStatisticsData">
				<div class="Data_bt" style="margin-top:0;">
					<span class="left_s">调用数据统计数据表</span>
					<if condition="isset($res) && $res['status'] eq 0">
						<form class="js_download" method="post" target="_blank" action="/Appadmin/OraStatAirLine/index">
							<input type="hidden" value="1" name ="downloadStat"/>
							<input type="hidden" value="{$startTime}" name ="startTime"/>
							<input type="hidden" value="{$endTime}" name ="endTime"/>
							<input type="hidden" value="pull" name ="type"/>
							<input type="hidden" value="{$timeType}" name ="timeType"/>
							<button class="right_down" type="button">导出</button>
						</form>
					</if>
				</div>
				<div class="table_content">
					<div class="table_list table_tit">
						<span class="span_t4 span_height">日期</span>
						<span class="span_t4 span_height">国际调用次数</span>
						<span class="span_t4 span_height">国际直飞调用次数</span>
						<span class="span_t4 span_height">国际经停调用次数</span>
						<span class="span_t4 span_height">国内调用次数</span>
						<span class="span_t4 span_height">国内直飞调用次数</span>
						<span class="span_t4 span_height">国内经停调用次数</span>
						<span class="span_t12 span_height">未知</span>
						<span class="span_t11 span_height">操作</span>
					</div>
					<div class="table_scrolls clear" style="width:100%;max-height:408px;">
						<if condition="isset($res) && $res['status'] eq 0">
							<volist name="res['list']" id="vo">
								<div class="table_list clear">
									<span class="span_t4">{$vo.date_index}</span>
									<span class="span_t4">{$vo.inter}</span>
									<span class="span_t4">{$vo.nostopinter}</span>
									<span class="span_t4">{$vo.stopinter}</span>
									<span class="span_t4">{$vo.domestic}</span>
									<span class="span_t4">{$vo.nostopdomestic}</span>
									<span class="span_t4">{$vo.stopdomestic}</span>
									<span class="span_t12">{$vo.unknown}</span>
									<span class="span_t11">
										<a href="{:U('Appadmin/OraStatAirLine/detail',array('startTime'=>$vo['date_index'],'timeType'=>$timeType,'type'=>'pull'),'','',true)}">明细</a>
									</span>
								</div>
							</volist>
							<else/>
							NO DATA
						</if>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var gType="{$type}";
	var gStatisticDateType="{$gStatisticDateType}";//时间插件参数时间类型
	$(function(){
		$.OraStatAirLine.init();
	})
</script>