<!-- 业务 人均银行卡页面 -->
<layout name="../Layout/Layout"/>
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="form_margintop">
				<include file="../Layout/nav_stat" />
				<div class="select_xinzeng margin_top">
					<input type="text" value="人均银行卡数">
					<i><img src="/images/appadmin_icon_xiala.png"></i>
					<ul>
						<li>拥有用户数</li>
						<li>人均银行卡数</li>
						<li>人均使用次数</li>
					</ul>
				</div>
				<div class="select_xinzeng margin_top">
					<input type="text" value="总数">
					<i><img src="/images/appadmin_icon_xiala.png"></i>
					<ul>
						<li>总数</li>
						<li>可刷</li>
						<li>不可刷</li>
					</ul>
				</div>
			</div>
			<!-- 图表放置 -->
			<div id="userStatisticsLine" style="width:820px;height:500px;overflow:hidden;">
				
			</div>
			<div id="userStatisticsData">
				<div class="Data_bt">
					<span class="left_s">人均银行卡数数据表</span>
					<button class="right_down" type="button">导出</button>
				</div>
				<div class="table_content">
					<div class="table_list table_tit">
						<span class="span_t10">日期</span>
						<span class="span_t10">软件版本</span>
						<span class="span_t10">硬件版本</span>
						<span class="span_t10">总数 </span>
						<span class="span_t10">模板添加</span>
						<span class="span_t10">非模板添加</span>
					</div>
					<div class="table_scrolls clear">
						<div class="table_list">
							<span class="span_t10">01-05</span>
							<span class="span_t10">全部</span>
							<span class="span_t10">全部</span>
							<span class="span_t10">234</span>
							<span class="span_t10">234</span>
							<span class="span_t10">11</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>