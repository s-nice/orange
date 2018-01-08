<!--用户统计 流失用户页面 -->
<layout name="../Layout/Layout"/>
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="form_margintop">
				<div class="content_search">
					<div class="search_right_c">
						<div class="select_sketch menu_list">
							<input type="text" value="全部软件版本">
							<i><img src="/images/appadmin_icon_xiala.png"></i>
							<ul>
								<li class="on">全部</li>
								<li>1.0</li>
								<li>1.1</li>
								<li>1.2</li>
							</ul>
						</div>
						<div class="select_sketch menu_list">
							<input type="text" value="全部硬件版本">
							<i><img src="/images/appadmin_icon_xiala.png"></i>
							<ul>
								<li class="on">全部</li>
								<li>1.0</li>
								<li>1.1</li>
								<li>1.2</li>
							</ul>
						</div>
						<div class="select_time_c behavior_select_time_c">
							<span>日期</span>
							<div class="time_c">
								<input class="time_input" type="text" readonly="readonly">
								<i><img src="/images/appadmin_icon_xiala.png"></i>
							</div>
							<span>--</span>
							<div class="time_c">
								<input class="time_input" type="text" readonly="readonly">
								<i><img src="/images/appadmin_icon_xiala.png"></i>
							</div>
						</div>
						<input class="submit_button behavior_submit_button" type="submit" value="确定">
					</div>
				</div>
				<div class="select_xinzeng margin_top">
					<input type="text" value="流失用户量">
					<i><img src="/images/appadmin_icon_xiala.png"></i>
					<ul>
						<li>新增设备量</li>
						<li>累计设计量</li>
						<li>活跃用户量</li>
						<li>使用时长</li>
						<li>亮屏次数</li>
						<li>留存率</li>
						<li>流失用户量</li>
						<li>回流用户</li>
						<li>人均手机连接状态时长</li>
						<li>地域分布</li>
					</ul>
				</div>
				<div class="js_stat_date_type">
					<a href="">1日</a>
					<a href="">3日</a>
					<a href="">周</a>
					<a href="">月</a>
				</div>	
			</div>
			<!--图表放置-->
			<div id="userStatisticsLine" style="width:820px;height:500px;overflow:hidden;">
				
			</div>
			<div id="userStatisticsData">
				<div class="Data_bt">
					<span class="left_s">流失用户数数据表</span>
					<button class="right_down" type="button">导出</button>
				</div>
				<div class="table_content">
					<div class="table_list table_tit">
						<span class="span_t3">日期</span>
						<span class="span_t3">软件版本</span>
						<span class="span_t3">硬件版本</span>
						<span class="span_t3">小于7天</span>
						<span class="span_t3">7~14天</span>
						<span class="span_t3">14~30天</span>
						<span class="span_t3">小于30天</span>
					</div>
					<div class="table_list">
						<span class="span_t3">01-05</span>
						<span class="span_t3">全部</span>
						<span class="span_t3">全部</span>
						<span class="span_t3">22</span>
						<span class="span_t3">22</span>
						<span class="span_t3">22</span>
						<span class="span_t3">22</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>