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
					<span class="left_s">累计拥有他人名片用户数量数据表</span>
					<if condition="count($tableArr) gt 0">
            			<a href="{:U('Appadmin/'.CONTROLLER_NAME.'/'.ACTION_NAME,
            			array('download'=>1,'endTime'=>$params['endTime'],'s_versions'=>$params['s_versions'],'h_versions'=>$params['h_versions']))}"><button class="right_down" id="js_download" style="cursor: pointer;">{$T->str_export}</button></a>
            		</if>
				</div>
				<div class="table_content">
					<div class="table_list table_tit">
						<span class="span_t1">日期</span>
						<span class="span_t1">软件版本</span>
						<span class="span_t1">硬件版本</span>
						<span class="span_t1">用户数量</span>
					</div>
					<div class="clear" id="js_scroll_dom" style="max-height:438px;">
					<if condition="count($tableArr) gt 0">
					<foreach name="tableArr" item="v">
					<div class="table_list">
						<span class="span_t1">{$v.time}</span>
						<span class="span_t1" title="{$v.software}">{$v.software}</span>
						<span class="span_t1" title="{$v.hardware}">{$v.hardware}</span>
						<span class="span_t1">{$v.usernum}</span>
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
					name: '用户数量',
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
