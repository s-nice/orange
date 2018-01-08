<layout name="../Layout/Layout"/>
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="form_margintop">
				<include file="OraVisitingCard/nav_stat" />
			</div>
			<!--图表放置-->
			<div id="userStatisticsLine" style="width:820px;height:500px;overflow:hidden;">

			</div>
			<div id="userStatisticsData">
				<div class="Data_bt">
					<span class="left_s">{$selectArr[$itemKey]['name']}数据表</span>
					<if condition="count($tableArr) gt 0">
						<a href="{:U('Appadmin/'.CONTROLLER_NAME.'/'.ACTION_NAME,
            			array('download'=>1,'startTime'=>$params['startTime'],'endTime'=>$params['endTime'],'date_type'=>$params['date_type'],'itemKey'=>$itemKey))}"><button class="right_down" id="js_download" style="cursor: pointer;">{$T->str_export}</button></a>
					</if>
				</div>
				<div class="table_content" style="overflow:visible;">
					<div class="">
						<div class="table_list table_tit" >
							<span class="span_t4">日期</span>
							<span class="span_t4">总数</span>
							<span class="span_t4">扫码交换</span>
							<span class="span_t4">多人交换-APP</span>
							<span class="span_t4">邀请交换</span>
							<span class="span_t4">摇一摇</span>
							<span class="span_t4">碰一碰</span>
							<span class="span_t4">系统检测</span>
						</div>
						<div class="clear" id="js_scroll_dom" style="max-height:438px;">
							<if condition="count($tableArr) gt 0">
								<foreach name="tableArr" item="v">
									<div class="table_list" >
										<span class="span_t4">{$v.time}</span>
										<span class="span_t4">{$v.num}</span>
										<span class="span_t4">{$v.num1}</span>
										<span class="span_t4">{$v.num2}</span>
										<span class="span_t4">{$v.num3}</span>
										<span class="span_t4">{$v.num4}</span>
										<span class="span_t4">{$v.num5}</span>
										<span class="span_t4">{$v.num6}</span>
									</div>
								</foreach>
								<else />
								No Data
							</if>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var gXdata = <?php echo $line_x ;?>;
		var gYdata = <?php echo $line_x_val; ?>;
		var gMaxVal="{$maxVal}";
		function getMaxVal(num) {
			var val = 10;
			if (num > 10) {
				val = Math.ceil(num / 10) * 10

			}
			return val
		}

		$(function(){
			var scrollObjs = $('#js_scroll_dom');
			scrollObjs.mCustomScrollbar({
				theme:"dark", //主题颜色
				autoHideScrollbar: false, //是否自动隐藏滚动条
				scrollInertia :0,//滚动延迟
				height:50,
				horizontalScroll : false//水平滚动条
			});
			gMaxVal= getMaxVal(gMaxVal);//坐标Y轴最大值 小于10的 整数
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
						name: '总数',
						type: 'line',
						data:gYdata
					}

				]
			};
			myChart.setOption(option);
			// 数据整理完毕
			myChart.hideLoading();
		});
	</script>
