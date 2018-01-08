<layout name="../Layout/Layout" />
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
		<include file="menus" tabsms="" tabmail="" tabweb="on"/><!-- 内容中的顶部菜单 -->
<div class="website_wramp">
	<div class="setting_radio setting_h3">
		<h3>内容类型：</h3>
		<div class="setting_radio_list">
			<label for=""><input name="shop" type="radio">酒店</label>
			<label for=""><input name="shop" type="radio">票务预定</label>
			<label for=""><input name="shop" type="radio">生活类预定</label>
			<label for=""><input name="shop" type="radio">餐厅/娱乐设施预定</label>
			<label for=""><input name="shop" type="radio">行程预定</label>
		</div>
	</div>
	<div class="setting_card clear setting_h3 menu_list">
		<h3>卡类型：</h3>
		<div class="menu_card">
			<input type="text" value="信用卡" readonly="true">
			<em></em>
			<ul>
				<li>信用卡</li>
				<li>储蓄卡</li>
			</ul>
		</div>
	</div>
	<div class="setting_card clear setting_h3 menu_list">
		<h3>推送单位：</h3>
		<div class="menu_card">
			<input type="text" value="如家酒店" readonly="true">
			<em></em>
			<ul>
				<li>七天连锁酒店</li>
				<li>交通银行</li>
				<li>浦发银行</li>
				<li>建设银行</li>
			</ul>
		</div>
	</div>
	<div class="setting_come clear setting_h3">
		<h3>登录URL：</h3>
		<input class="website_addres" type="text" value="http://www.orange.com">
		<div class="regx_box">
			<span>登录验证类型：</span><label><input name="regx" type="radio">验证码</label><label><input name="regx" type="radio">图片滑动</label><label><input name="regx" type="radio">混合</label>
		</div>
	</div>
	<div class="setting_post_info setting_h3">
		<h3>提取信息：</h3>
		<div class="website">
			<div class="website_title website_checked">
				<span class="website_span span_span11"><i class="js_select"></i>全选</span>
			</div>
			<div class="post_url website_checked">
				<span class="website_span span_span11"><i class="js_select"></i>积分</span>
				<input class="url_time" type="text">
				<div class="website_url">提取信息URL：<input type="text" value="http://www.homeinns.com/member"></div>
			</div>
			<div class="ajax_true clear">
				<div class="ajax_right">
					<span>
						是否异步：<input type="text" readonly="true" value="否">
						<em></em>
						<ul>
							<li>否</li>
							<li>是</li>
						</ul>
					</span>
					<span>
						请求方式：<input type="text" readonly="true" value="空">
						<em></em>
						<ul>
							<li>空</li>
							<li>post</li>
							<li>get</li>
						</ul>
					</span>
					<span>
						请求参数：<input type="text" readonly="true" value="post">
						<em></em>
						<ul>
							<li>空</li>
							<li>paramtar</li>
						</ul>
					</span>
					<span>
						数据位置：<input type="text" readonly="true" value="空">
						<em></em>
						<ul>
							<li>空</li>
							<li>索引</li>
							<li>正则</li>
						</ul>
					</span>
				</div>
			</div>
			<div class="website_edit">
				<h4>内容示例：</h4>
				<div class="website_text">
					<textarea name="" id="" cols="30" rows="10"></textarea>
				</div>
			</div>
			<div class="info_url clear">
				<div class="url_list website_checked clear">
					<span class="website_span span_span11"><i class="js_select"></i>里程：</span>
					<span class="website_num"><input type="text" value="1008"></span>
					<span class="span_get">提取信息URL：<input type="text" value="http://www.homeeinns.com/member"></span>
				</div>
				<div class="url_list website_checked clear">
					<span class="website_span span_span11"><i class="js_select"></i>消费金额：</span>
					<span class="website_num"><input type="text" value="1008"></span>
					<span class="span_get">提取信息URL：<input type="text" value="http://www.homeeinns.com/member"></span>
				</div>
				<div class="url_list website_checked clear">
					<span class="website_span span_span11"><i class="js_select"></i>余额：</span>
					<span class="website_num"><input type="text" value="1008"></span>
					<span class="span_get">提取信息URL：<input type="text" value="http://www.homeeinns.com/member"></span>
				</div>
			</div>
		</div>
		<div class="website_take clear" style="margin-left:100px;"><em>*</em>注意：输入的字符必须是内容示例中的唯一字符，如不唯一请手动修改示例内容。</div>
		<div class="website_btn">
			<button class="big_button btn_right" type="button">保存</button>
			<button class="big_button" type="button">取消</button>
		</div>
	</div>
</div>
		</div>
	</div>
</div>