<layout name="../Layout/Layout" />
<!-- 似乎是没有用到的页面 -->
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="card_name">
				<span>输入卡类型名称：</span>
				<input type="text">
			</div>
			<div class="swing_card">
				<span>刷卡方式：</span>
				<label for=""><input type="radio">展示</label>
				<label for=""><input type="radio">刷卡</label>
			</div>
			<div class="card_rank">
				<span>输入发卡单位：</span><input type="text"><button type="button">添加</button>
			</div>
			<div class="card_rank_box">
				<div class="rank_title">
					<label><input type="checkbox">全选</label>
					<div class="addBtn"><span>删除</span><span>修改</span></div>
				</div>
				<div class="rank_list">
					<span><label><input type="checkbox">中国银行</label></span>
					<span><label><input type="checkbox">招商银行</label></span>
					<span><label><input type="checkbox">华夏银行</label></span>
					<span><label><input type="checkbox">北京银行</label></span>
					<span><label><input type="checkbox">建设银行</label></span>
				</div>
			</div>
			<div class="card_style_text">
				输入卡片上的属性：<input class="text_w" type="text"><input class="text_w" type="text"><label><input type="radio">加密存储</label><button type="button">添加</button>
			</div>
			<div class="card_style_box card_rank_box">
				<div class="card_style_title rank_title">
					<label><input type="checkbox">全选</label>
					<div class="addBtn"><span>删除</span><span>修改</span></div>
				</div>
				<div class="card_num">
					<div class="card_num_list">
						<span class="span_info"><label><input type="checkbox"><em>卡号</em></label></span>
						<span class="span_num">1234567890</span>
					</div>
					<div class="card_num_list">
						<span class="span_info"><label><input type="checkbox"><em>有效期</em></label></span>
						<span class="span_num">1234567890</span>
					</div>
				</div>
			</div>
			<div class="rank_btn">
				<button class="big_button" type="button">保存</button>
				<button class="big_button" type="button">取消</button>
			</div>
		</div>
	</div>
</div>