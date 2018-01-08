<!--搜索  人均搜索次数页面 -->
<layout name="../Layout/Layout"/>
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="form_margintop">
			 <include file="../Layout/nav_stat" />
				<div id='typeChange' class="select_xinzeng margin_top menu_list">
					<input type="text" value="使用搜索功能的总次数"  readonly="readonly">
					<i><img src="/images/appadmin_icon_xiala.png"></i>
					<ul>
						<li class="" href="{:U('Appadmin/OraStatSearch/totalUserNum')}" type='total'>使用搜索功能的总用户数量</li>
						<li class="" href="{:U('Appadmin/OraStatSearch/totalSearchNum')}" type='total'>使用搜索功能的总次数</li>
						<li class="on" href="{:U('Appadmin/OraStatSearch/averageSearchNum')}" type='total'>人均搜索次数</li>
					</ul>
				</div>
				<div class="select_xinzeng margin_top">
					<input type="text" value="<if condition="$type eq '2'">语音
					<elseif  condition="$type eq '1'"/> 文本 <else/>总数 </if>"  readonly="readonly" value="">
					<i><img src="/images/appadmin_icon_xiala.png"></i>
					<ul class="js_select_type">
						<li  type=0 <if condition="$type eq '0'">class="on"</if>>总数</li>
						<li  type=1 <if condition="$type eq '1'">class="on"</if>>文本</li>
						<li  type=2 <if condition="$type eq '2'">class="on"</if>>语音</li>
					</ul>
				</div>
				<div class="js_stat_date_type">
					<a href="javascript:void(0);" val='d' <if condition="$period eq 'd'">class='on'</if>>1日</a>
					<a href="javascript:void(0);" val='d3' <if condition="$period eq 'd3'">class='on'</if>>3日</a>
					<a href="javascript:void(0);" val='w' <if condition="$period eq 'w'">class='on'</if>>周</a>
					<a href="javascript:void(0);" val='m' <if condition="$period eq 'm'">class='on'</if>>月</a>
				</div>	
			</div>
			<!--图表放置-->
			<div id="userStatisticsLine" style="width:820px;height:500px;overflow:hidden;">
				
			</div>
			<div id="userStatisticsData">
				<div class="Data_bt">
					<span class="left_s">人均搜索次数</span>
					<if condition="count($list) gt 0">
						<form class="js_download" method="post" target="_blank" action="/Appadmin/OraStatSearch/averageSearchNum ">
							<input type="hidden" value="{$s_versions_name}" name ="s_versions"/>
							<input type="hidden" value="{$h_versions_name}" name ="h_versions"/>
							<input type="hidden" value="1" name ="downloadStat"/>
							<input type="hidden" value="{$startTime}" name ="startTime"/>
							<input type="hidden" value="{$endTime}" name ="endTime"/>
							<input type="hidden" value="{$type}" name ="type"/>
							<input type="hidden" value="{$period}" name ="period"/>
							<button class="right_down" type="button">导出</button>
						</form>
					</if>
				</div>
				<div class="table_content ">
					<div class="table_list table_tit">
						<span class="span_t2">日期</span>
						<span class="span_t2">软件版本</span>
						<span class="span_t2">硬件版本</span>
						<span class="span_t2">人均页面访问次数</span>
						<span class="span_t2">人均使用次数</span>
					</div>
					<div class="table_scrolls table_lines clear">
					<if condition="count($list) gt 0 ">
						<foreach name="list" item="vo">
							<div class="table_list clear ">
								<span class="span_t2" title="{$vo['time']}">{$vo['time']}</span>
								<span class="span_t2" title="{$vo['software']}">{$vo['software']}</span>
								<span class="span_t2" title="{$vo['hardware']}">{$vo['hardware']}</span>
								<span class="span_t2" title="{$vo['pv_count']}">{$vo['pv_count']}</span>
								<span class="span_t2" title="{$vo['search_count']}">{$vo['search_count']}</span>
							</div>
						</foreach>
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
var gStatisticDateType = "{$period}";
var gType= "{$type}";
var tip_select_time = "{$T->tip_select_time}";
var gXdata=<?php echo $line_x ;?>;
var gYdata=<?php echo $line_x_val ;?>;
var gMaxVal="{$maxVal}";
//var colors = $.parseJSON('{$colors}');
function getMaxVal(num) {
	var val = 10;
	if (num > 10) {
		val = Math.ceil(num / 10) * 10

	}
	return val
}

$(function(){
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
				name: '人均搜索次数',
				type: 'line',
				data:gYdata
			}

		]
	};
	myChart.setOption(option);
	// 数据整理完毕
	myChart.hideLoading();
	$.business.init();
});

</script>