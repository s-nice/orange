<!-- 行程卡  航段数人数分布 -->
<layout name="../Layout/Layout"/>
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="form_margintop">
				<form class="form_marginauto js_search_form"  method='get'>
					<div class="content_search">
						<div class="search_right_c">
							<div class="js_proversion select_IOS menu_list select_option input_s_width js_s_div">
								<input type="text" value="{:$_GET['s_versions']?$_GET['s_versions']:'全部软件版本'}" name='sysPlatform' readonly="readonly"  alltext='全部软件版本' autocomplete='off'/>
								<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
								<b></b>
								<input type="hidden" name="s_versions" value="{$s_versions_name}" autocomplete='off'>
								<ul class="js_scroll_list" style="max-height:300px;overflow:hidden;">
									<li title="全部" val="all"><label><input type="checkbox" >全部</label></li>
									<foreach name="s_versions" item="v">
										<li title="{$v}"><label><input type="checkbox" value="{$v}" autocomplete='off' <if condition="in_array($v,$s_versions_check)">checked="checked"</if>><span class="copyright" title="{$v}">{$v}</span></label></li>
									</foreach>
								</ul>
							</div>
							<div class="js_modelversion select_IOS menu_list input_s_width select_option js_s_div">
								<input type="text" name="channel" value="{:$_GET['h_versions']?$_GET['h_versions']:'全部硬件版本'}"  readonly="readonly"  alltext='全部硬件版本' autocomplete='off'/>
								<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
								<b></b>
								<input type="hidden" name="h_versions" value="{$h_versions_name}" autocomplete='off'>
								<ul class="js_scroll_list" style="max-height:300px;overflow:hidden;">
									<li title="全部" val="all"><label><input type="checkbox" >全部</label></li>
									<foreach name="h_versions" item="v">
										<li title="{$v}"><label><input type="checkbox"  value="{$v}" autocomplete='off'<if condition="in_array($v,$h_versions_check)">checked="checked"</if>><span class="copyright" title="{$v}">{$v}</span></label></li>
									</foreach>
								</ul>
							</div>
							<div class="select_time_c">
								<span>{$T->str_time}</span>
								<div class="time_c">
									<input id="js_begintime" class="time_input" type="text" name="startTime"  readonly="readonly" value="{$startTime}" autocomplete='off'/>
									<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
								</div>
							</div>
							<input class="submit_button" type="submit" value="{$T->str_submit}"/>
						</div>
					</div>
				</form>
				<link href="__PUBLIC__/js/jsExtend/datetimepicker/datetimepicker.css" rel="stylesheet" text="text/css">
				<script src="__PUBLIC__/js/jsExtend/datetimepicker/datetimepicker.js"></script>

				<div class="select_xinzeng margin_top js_select_menu js_select_action">
					<input type="text" value="航段数人数分布">
					<i><img src="/images/appadmin_icon_xiala.png"></i>
					<ul>
						<li>查看用户数</li>
						<li>人均航段数</li>
						<li>航段数人数分布</li>
						<li>人均在途时间</li>
						<li>在途时间人数分布</li>
						<li>人均使用次数</li>
					</ul>
				</div>
				<div class="flex_num">
					<div class="min_num num_box">
						<span>最小值:</span>
						<input type="text" class="js_min_input" value="{$min}">
					</div>
					<div class="min_num num_box">
						<span>最大值:</span>
						<input type="text" class="js_max_input" value="{$max}">
					</div>
					<div class="min_num num_box">
						<span>区间段:</span>
						<input type="text" class="js_between_input" value="{$between}">
					</div>
					<input class="sure_b js_condition_sub" type="button"  value="确认">
				</div>
			</div>
			<!-- 图表放置 -->
			<div id="userStatisticsLine" style="width:820px;height:500px;overflow:hidden;">
				
			</div>
			<div id="userStatisticsData">
				<div class="Data_bt">
					<span class="left_s">航段数人数分布数据表</span>
					<if condition="count($tableData) gt 0">
						<form class="js_download" method="post" target="_blank" action="/Appadmin/OraStatJourneyCard/index">
							<input type="hidden" value="{$s_versions_name}" name ="s_versions"/>
							<input type="hidden" value="{$h_versions_name}" name ="h_versions"/>
							<input type="hidden" value="1" name ="downloadStat"/>
							<input type="hidden" value="{$startTime}" name ="startTime"/>
							<input type="hidden" value="{$endTime}" name ="endTime"/>
							<input type="hidden" value="{$action}" name ="action"/>
							<input type="hidden" value="{$period}" name ="timeType"/>
							<input type="hidden" value="{$max}" name ="max"/>
							<input type="hidden" value="{$min}" name ="min"/>
							<button class="right_down" type="button">导出</button>
						</form>
					</if>
				</div>
				<div class="table_content">
					<div class="table_list table_tit">
						<span class="span_t1">日期</span>
						<span class="span_t1">软件版本</span>
						<span class="span_t1">硬件版本</span>
						<span class="span_t1">总里航段数</span>
					</div>
					<div class="table_scrolls clear">
						<if condition="count($tableData) gt 0">
							<volist name="tableData" id="list">
								<div class="table_list">
									<span class="span_t1">{$list.dt}</span>
									<span class="span_t1">{$list.pro_version}</span>
									<span class="span_t1">{$list.model}</span>
									<span class="span_t1">{$list.num}</span>
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
	$(function(){
		$.dataTimeLoad.init();

		//点击区域外关闭此下拉框
		$(document).on('click',function(e){
			if(!$(e.target).parents('.js_s_div').length){
				$('.js_s_div>ul').hide();
			}
		});

		//下拉
		$('.js_s_div').on('click',function(e){
			$('.js_s_div>ul').hide();
			if(!$(e.target).parents('ul').length){
				$(this).find('ul').show();
			}
		});

		$('.js_s_div').each(function(){
			//全选
			var $all=$(this).find('ul input:first');
			$all.on('click', function(evt){
				evt.stopPropagation();
				var $ul=$(this).parents('ul');
				$ul.find('input').prop('checked', $(this).prop('checked'));
				setValues($ul);
			});

			//单选
			var $items=$(this).find('ul input:gt(0)');
			$items.on('click', function(evt){
				evt.stopPropagation();
				setValues($(this).parents('ul'));
			});

			//加载时是否全选
			var hiddenVal=$(this).find('input:eq(1)').val();
			if (hiddenVal!='' && hiddenVal.split(',').length==$items.length){
				$all.prop('checked',false);
				$all.click();
			}
		});

		//赋值
		function setValues($ul){
			var isAllChecked=true;
			var val=[];
			$ul.find('input:gt(0)').each(function(){
				if ($(this).prop('checked')){
					val.push($(this).val());
				} else {
					isAllChecked=false;
				}
			});
			$ul.find('input:first').prop('checked', isAllChecked);
			if (isAllChecked){
				var $input=$ul.parent().find('input:eq(0)');
				$input.val($input.attr('alltext'));
			} else {
				$ul.parent().find('input:eq(0)').val(val.join(','));
			}
			$ul.parent().find('input:eq(1)').val(val.join(','));
		}
		//下拉框添加滚动条
		$('.js_scroll_list').mCustomScrollbar({
			theme:"dark", //主题颜色
			autoHideScrollbar: false, //是否自动隐藏滚动条
			scrollInertia :0,//滚动延迟
			horizontalScroll : false,//水平滚动条
		});
	});
</script>
<script>
	var gAction="{$action}";
	var gXdata={$line_x};//横轴数据
	var gYdata={$line_x_val};//横轴对应的值
	var gMaxVal={$maxVal};//最大值
	var gMin="{$min}";
	var gMax="{$max}";
	var gBetween="{$between}";

	$(function(){
		gMaxVal= $.OraStatJourneyCard.getMaxVal(gMaxVal);//坐标Y轴最大值 小于10的 整数
		/*配置图表*/
		var myChart = echarts.init(document.getElementById('userStatisticsLine'));
		myChart.showLoading({
			text: '正在努力的读取数据中...',
		});
		var option = {
			tooltip: {
				trigger: 'axis'
			},
			axisTick: {
				alignWithLabel: true
			},
			grid: {
				left: '3%',
				right: '4%',
				bottom: '3%',
				containLabel: true
			},
			xAxis: {
				type: 'category',
				//boundaryGap: false,
				//data: ['周一', '周二', '周三', '周四', '周五', '周六', '周日']
				data:gXdata,
				axisTick: {
					alignWithLabel: true
				}
			},
			yAxis: {
				max:gMaxVal, //最大刻度/
				splitNumber:6,//分5个断（6个刻度）
				minInterval: 1,	//	保证分科刻度为整数
				type: 'value'

			},
			series: [
				{
					name: '航段数人数分布',
					type: 'bar',
					data:gYdata,
					itemStyle: {
						normal: {
							color: '#f27d00'
						}
					}
				}

			]
		};
		myChart.setOption(option);
		// 数据整理完毕
		myChart.hideLoading();
		$.OraStatJourneyCard.init();
	});

</script>