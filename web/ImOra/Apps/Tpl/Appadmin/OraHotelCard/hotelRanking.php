<!-- 酒店卡  酒店累计入住 晚数排名 -->
<layout name="../Layout/Layout"/>
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="form_margintop">
				<include file="../Layout/nav_stat" />
				<div class="select_xinzeng margin_top">
					<input type="text" value="入住晚数排名">
					<i><img src="/images/appadmin_icon_xiala.png"></i>
					<ul>
						<li>拥有用户数</li>
						<li>使用用户数</li>
						<li>可获取账号信息卡数</li>
						<li>人均入住晚数</li>
						<li>入住晚数分布</li>
						<li>累计入住晚数排名</li>
						<li>人均酒店卡数</li>
						<li>人均使用次数</li>
					</ul>
				</div>
			</div>
			<!-- 图表放置 -->
			<div id="userStatisticsLine" style="width:820px;height:500px;overflow:hidden;">
				
			</div>
			<div id="userStatisticsData">
				<div class="Data_bt">
					<span class="left_s">入住晚数分布数据表</span>
					<button class="right_down" type="button">导出</button>
				</div>
				<div class="table_content">
					<div class="table_list table_tit">
						<span class="span_t2">日期</span>
						<span class="span_t2">酒店名称</span>
						<span class="span_t2">软件版本</span>
						<span class="span_t2">硬件版本</span>
						<span class="span_t2">总入住晚数</span>
					</div>
					<div class="scrolls clear">
						<div class="table_list">
							<span class="span_t2">01-05</span>
							<span class="span_t2"></span>
							<span class="span_t2">全部</span>
							<span class="span_t2">全部</span>
							<span class="span_t2">234</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>