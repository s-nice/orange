<!-- 日程卡 查看日程卡用户数页面 -->
<layout name="../Layout/Layout"/>
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="form_margintop">
				<include file="@Layout/nav_stat" />
				<div class="select_xinzeng margin_top js_select_type">
					<input type="text" value="查看日程卡用户数">
					<i><img src="/images/appadmin_icon_xiala.png"></i>
					<ul>
						<li>查看日程卡用户数</li>
						<li>日程卡人均使用次数</li>
					</ul>
				</div>
				<div class="js_stat_date_type">
					<a <if condition="$timeType eq 'day'">class="js_select_time on"<else/>class="js_select_time"</if>>1日</a>
					<a <if condition="$timeType eq 'threeDay'">class="js_select_time on"<else/>class="js_select_time"</if>>3日</a>
					<a <if condition="$timeType eq 'week'">class="js_select_time on"<else/>class="js_select_time"</if>>周</a>
					<a <if condition="$timeType eq 'month'">class="js_select_time on"<else/>class="js_select_time"</if>>月</a>
				</div>	
			</div>
			<!--图表放置-->
			<div id="userStatisticsLine" style="width:820px;height:500px;overflow:hidden;">
				
			</div>
			<div id="userStatisticsData">
				<div class="Data_bt">
					<span class="left_s">查看日程卡用户数</span>
					<if condition="count($tableData) gt 0">
					<form class="js_download" method="post" target="_blank" action="/Appadmin/OraStatScheduleCard/index">
							<input type="hidden" value="{$_GET['s_versions']}" name ="s_versions"/>
							<input type="hidden" value="{$_GET['h_versions']}" name ="h_versions"/>
							<input type="hidden" value="1" name ="downloadStat"/>
							<input type="hidden" value="{$startTime}" name ="startTime"/>
							<input type="hidden" value="{$endTime}" name ="endTime"/>
							<input type="hidden" value="{$type}" name ="type"/>
							<input type="hidden" value="{$timeType}" name ="timeType"/>
						    <button class="right_down" type="button">导出</button>
						</form>
						</if>
				</div>
				<div class="table_content table_scroll">
					<div class="table_list table_tit">
						<span class="span_t1">日期</span>
						<span class="span_t1">软件版本</span>
						<span class="span_t1">硬件版本</span>
						<span class="span_t1">查看用户数</span>
					</div>
					<div class="table_scrolls clear" style="width:100%;">
						<if condition="!empty($tableData)">
							<volist name="tableData" id="vo">
								<div class="table_list clear">
								  <span class="span_t1">{$vo.first_date}</span>
								  <span class="span_t1">{$vo.pro_version}</span>
								  <span class="span_t1">{$vo.model}</span>
								  <span class="span_t1">{$vo.num}</span>
								</div>
							</volist>
							<else/>
							NO DATA
						</if>
					</div>
				<!--	<div class="table_list">
						<span class="span_t1">01-01</span>
						<span class="span_t1">全部</span>
						<span class="span_t1">全部</span>
						<span class="span_t1">234</span>
					</div>-->
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var gAction="{$type}";
	var gSumUrl="{:U('Appadmin/OraStatScheduleCard/index','','','',true)}";
	var gAvgUrl="{:U('Appadmin/OraStatScheduleCard/index',array('type'=>2),'','',true)}";
	var gStatisticDateType="{$gStatisticDateType}";//时间插件参数时间类型
	var gTimeType="{$timeType}";
	var gXdata=<?php echo $line_x ;?>;;
	var gYdata=<?php echo $line_x_val ;?>;
	var gMaxVal="{$maxVal}";

	$(function(){
		$('.js_download button').on('click',function(){ //下载表格
			$('.js_download ').submit();
		});

		gMaxVal= $.OraStatScheduleCard.getMaxVal(gMaxVal);//坐标Y轴最大值 小于10的 整数
		/*配置图表*/
		var myChart = echarts.init(document.getElementById('userStatisticsLine'));
		//console.log(myChart);
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
					name: '日程卡用户数',
					type: 'line',
					//data: [0, 200, 400, 600, 800, 1000]
					data:gYdata
				}

			]
		};
		//console.log(option);
		myChart.setOption(option);
		// 数据整理完毕
		myChart.hideLoading();
		$.OraStatScheduleCard.init();
	});
</script>
