<!-- 航旅卡  人均航旅卡数 -->
<layout name="../Layout/Layout"/>
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="form_margintop">
				<include file="../Layout/nav_stat" />
				<div class="select_xinzeng margin_top">
					<input type="text" value="人均航旅卡数">
					<i><img src="/images/appadmin_icon_xiala.png"></i>
					<ul>
						<li>拥有用户数</li>
						<li>使用用户数</li>
						<li>里程人数分布</li>
						<li>人均航旅卡数</li>
						<li>入住使用次数</li>
					</ul>
				</div>
			<!-- 图表放置 -->
			<div id="userStatisticsLine" style="width:820px;height:500px;overflow:hidden;">
				
			</div>
			<div id="userStatisticsData">
				<div class="Data_bt">
					<span class="left_s">人均航旅卡数数据表</span>
					<button class="right_down" type="button">导出</button>
				</div>
				<div class="table_content">
					<div class="table_list">
						<span class="span_t1">日期</span>
						<span class="span_t1">软件版本</span>
						<span class="span_t1">硬件版本</span>
						<span class="span_t1">人均航旅卡数</span>
					</div>
					<div class="table_scrolls clear">
						<div class="table_list">
							<span class="span_t1">01-05</span>
							<span class="span_t1">全部</span>
							<span class="span_t1">全部</span>
							<span class="span_t1">234</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>