<!--飞常准 推送明细页面  -->
<layout name="../Layout/Layout"/>
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<form method='get' class="js_search_form">
				<div class="form_margintop">
					<div class="content_search">
						<div class="search_right_c">
							<div class="orderlist_input">
								<span>航班号</span>
								<input type="text" name="flight_num" <if condition="isset($params['flight_num'])">value="{$params['flight_num']}"</if>>
							</div>
							<div class="orderlist_input time_width_n">
								<span>出发日期</span>
								<input type="text" name="goff_date" id="js_goff_date" <if condition="isset($params['goff_date'])">value="{$params['goff_date']}"</if>>
							</div>
							<div class="select_label menu_list js_select_type" >
								<span>是否经停</span>
								<input type="text"  readonly="readonly" class="hand"
								<if condition="empty($params['is_stop'])">
									value="全部"
									<elseif condition="$params['is_stop'] eq 1"/>
									value="是"
									<elseif condition="$params['is_stop'] eq 0"/>
									value="否"

								</if>>
								<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png"></i>
								<ul>
									<li <if condition="empty($params['is_stop'])"> class="on"</if>>全部</li>
									<li val="1" <if condition="!empty($params['is_stop'] && $params['is_stop'] eq 1 )"> class="on"</if>>是</li>
									<li val="0" <if condition="!empty($params['is_stop'] && $params['is_stop'] eq 0 )"> class="on"</if>>否</li>
								</ul>
								<input type="hidden" name="is_stop" id="js_is_stop_input" <if condition="!empty($params['is_stop'])"> value="{$params['is_stop']}"</if> />
							</div>

							<div class="select_time_c behavior_select_time_c">
								<span>日期</span>
								<div class="time_c">
									<input class="time_input" type="text" readonly="readonly" id="js_begintime" name="startTime" value="{$params['startTime']}">
									<i><img src="/images/appadmin_icon_xiala.png"></i>
								</div>
								<span>--</span>
								<div class="time_c">
									<input class="time_input" type="text" readonly="readonly" id="js_endtime" name="endTime" value="{$params['endTime']}" >
									<i><img src="/images/appadmin_icon_xiala.png"></i>
								</div>
							</div>
							<input class="submit_button behavior_submit_button" type="submit" value="确定">
						</div>
					</div>
					<div class="select_label select_l_w menu_list js_select_type" >
						<span>航段</span>
						<input type="text"  readonly="readonly" class="hand"
						<if condition="empty($params['legType'])">
							value="全部"
							<elseif condition="$params['legType'] eq 1"/>
							value="国内"
							<elseif condition="$params['legType'] eq 2"/>
							value="国际"
							<elseif condition="$params['legType'] eq 0"/>
							value="未知"

						</if>>
						<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png"></i>
						<ul>
							<li <if condition="empty($params['legType'])"> class="on"</if>>全部</li>
							<li val="1" <if condition="!empty($params['legType'] && $params['legType'] eq 1 )"> class="on"</if>>国内</li>
							<li val="2" <if condition="!empty($params['legType'] && $params['legType'] eq 2 )"> class="on"</if>>国际</li>
							<li val="3" <if condition="!empty($params['legType'] && $params['legType'] eq 3 )"> class="on"</if>>未知</li>
						</ul>
						<input type="hidden" id="js_leg_input" name="legType" <if condition="!empty($params['legType'])"> value="{$params['legType']}"</if> />
					</div>
				</div>
			</form>
			<div id="userStatisticsData">
				<div class="Data_bt" style="margin-top:0;">
					<a href="{:U('Appadmin/OraStatAirLine/detail',array(
					'startTime'=>$params['startTime'],'endTime'=>$params['endTime'],'flight_num'=>$params['flight_num'],
					'goff_date'=>$params['goff_date'],'is_stop'=>$params['is_stop'],'legType'=>$params['legType'],'downloadStat'=>1
					),'','',true)}">
						<button class="right_down" type="button">导出</button>
					</a>
				</div>
				<div class="table_content">
					<div class="table_list table_tit">
						<span class="span_t2">推送订阅时间</span>
						<span class="span_t2">航班号</span>
						<span class="span_t2">出发日期</span>
						<span class="span_t2">航段</span>
						<span class="span_t2">是否经停</span>
					</div>
					<div class="table_scrolls clear" style="width:100%;">
						<if condition="isset($res) && $res['status'] eq 0">
							<volist name="res['list']" id="vo">
								<div class="table_list clear">
									<span class="span_t2">{$vo.push_time}</span>
									<span class="span_t2">{$vo.flight_num}</span>
									<span class="span_t2">{$vo.goff_date}</span>
									<span class="span_t2">{$vo.leg}</span>
									<span class="span_t2">{$vo.is_stop}</span>
								</div>
							</volist>
							<else/>
							NO DATA
						</if>
					</div>
					<!--	<div class="table_list">
                            <span class="span_t2">01-01 11:30:28</span>
                            <span class="span_t2">CA1030</span>
                            <span class="span_t2">2017-01-25</span>
                            <span class="span_t2">国内</span>
                            <span class="span_t2">否</span>
                        </div>-->
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$.OraStatAirLine.detailInit();
	})
</script>