<!-- 会员卡  累计拥有用户数 -->
<layout name="../Layout/Layout"/>
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="form_margintop">
				<include file="../Layout/nav_stat" />
				<div class="select_xinzeng margin_top js_select_menu js_select_action">
					<input type="text" value="累计拥有用户数"  />
					<i><img src="/images/appadmin_icon_xiala.png"></i>
					<ul>
						<li>累计拥有用户数</li>
						<li>使用用户数</li>
						<li>累计人均会员卡数</li>
						<li>人均使用次数</li>
					</ul>
				</div>
				<div class="select_xinzeng margin_top js_select_menu js_select_type">
					<input type="text" value="<if condition= "$type eq ''">所有分类<else/>{$cardType[$type]}</if>">
					<i><img src="/images/appadmin_icon_xiala.png"></i>
					<ul>
						<li val="">所有分类</li>
						<volist name="cardType" id="vo" key="k">
							<li val="{$k}">{$vo}</li>
						</volist>
					</ul>
				</div>
			</div>
			<!-- 图表放置 -->
			<div id="userStatisticsLine" style="width:820px;height:500px;overflow:hidden;">
				
			</div>
			<div id="userStatisticsData">
				<div class="Data_bt">
					<span class="left_s">累计拥有用户数数据表</span>
					<if condition="count($tableData) gt 0">
						<form class="js_download" method="post" target="_blank" action="/Appadmin/OraStatMembershipCard/index">
							<input type="hidden" value="{$s_versions_name}" name ="s_versions"/>
							<input type="hidden" value="{$h_versions_name}" name ="h_versions"/>
							<input type="hidden" value="1" name ="downloadStat"/>
							<input type="hidden" value="{$startTime}" name ="startTime"/>
							<input type="hidden" value="{$endTime}" name ="endTime"/>
							<input type="hidden" value="{$type}" name ="type"/>
							<input type="hidden" value="{$action}" name ="action"/>
							<input type="hidden" value="{$period}" name ="timeType"/>
							<input type="hidden" value="{$cardStatus}" name ="cardStatus"/>
							<button class="right_down" type="button">导出</button>
						</form>
					</if>
				</div>
				<div class="table_content">
					<div class="table_list table_tit">
						<span class="span_t4">日期</span>
						<span class="span_t4">软件版本</span>
						<span class="span_t4">硬件版本</span>
						<span class="span_t4">累计拥有用户数</span>
						<span class="span_t4">可刷用户数</span>
						<span class="span_t4">不可刷用户数</span>
						<span class="span_t4">模板用户数</span>
						<span class="span_t4">非模板用户数</span>
					</div>
					<div class="scrolls table_scrolls clear">
						<if condition="count($tableData) gt 0">
							<volist name="tableData" id="list">
								<div class="table_list">
									<span class="span_t4">{$list.dt}</span>
									<span class="span_t4">{$list.pro_version}</span>
									<span class="span_t4">{$list.model}</span>
									<span class="span_t4">{$list.num}</span>
									<span class="span_t4">{$list.user_swipe_num}</span>
									<span class="span_t4">{$list.user_no_swipe_num}</span>
									<span class="span_t4">{$list.user_mode_num}</span>
									<span class="span_t4">{$list.user_no_mode_num}</span>
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
<script>
	var gType="{$type}";
	var gAction="{$action}";
	var gXdata={$line_x};//横轴数据
	var gYdata={$line_x_val};//横轴对应的值
	var gMaxVal={$maxVal};//最大值
	$(function(){
		gMaxVal= $.OraStatMembershipCard.getMaxVal(gMaxVal);//坐标Y轴最大值 小于10的 整数
		/*配置图表*/
		var myChart = echarts.init(document.getElementById('userStatisticsLine'));
		myChart.showLoading({
			text: '正在努力的读取数据中...',
		});
		var option = {
			tooltip: {
				trigger: 'axis'
			},
			grid: {
				left: '3%',
				right: '4%',
				bottom: '3%',
				containLabel: true
			},
			xAxis: {
				type: 'category',
				boundaryGap: false,
				//data: ['周一', '周二', '周三', '周四', '周五', '周六', '周日']
				data:gXdata
			},
			yAxis: {
				max:gMaxVal, //最大刻度/
				splitNumber:6,//分5个断（6个刻度）
				minInterval: 1,	//	保证分科刻度为整数
				type: 'value'
			},
			series: [
				{
					name: '累计拥有用户数',
					type: 'line',
					//data: [0, 200, 400, 600, 800, 1000]
					data:gYdata
				}

			]
		};
		myChart.setOption(option);
		// 数据整理完毕
		myChart.hideLoading();
		$.OraStatMembershipCard.init();
	});

</script>