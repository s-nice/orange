<!-- Orange>提取规则管理>规则列表>新增规则>提取规则异常 -->
<layout name="../Layout/Layout" />
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="unusual_point">
				<h3>提取规则异常描述</h3>
				<h5>消费金额获取失败</h5>
				<h5>卡号获取失败</h5>
			</div>
			<div class="tab_setting setting_h3 clear">
				<h3>规则类型：</h3>
				<ul>
					<li class="on">短信</li>
					<li>邮件</li>
					<li>网站</li>
				</ul>
			</div>
			<div class="setting_box">
				<div class="setting_radio setting_h3 clear">
					<h3>内容类型：</h3>
					<div class="short_style">消费类型</div>
				</div>
					<div class="setting_card setting_h3 clear">
						<h3>卡类型：</h3>
						<div class="short_style">储蓄卡</div>
					</div>
					<div class="setting_rank setting_h3 clear">
						<h3>推送单位：</h3>
						<div class="short_style">招商银行</div>
					</div>
					<div class="setting_content setting_h3 clear">
						<h3>内容示例：</h3>
						<p>您尾号是1086的建行卡于09年31日13:23:58消费人民币10000.00元。当前余额为9000.00元。如有疑问请联系我行客服95533【建设银行】</p>
						<button class="get_news" type="button">获取最新</button>
					</div>
					<div class="setting_come setting_h3 clear">
						<h3>来源：</h3>
						<input type="text" value="95533">
					</div>
					<div class="setting_key setting_h3 clear">
						<h3>关键词：</h3>
						<input type="text" value="输入多个关键词以“,”号隔开">
						<span class="add_key">添加</span>
						<div class="add_key_font clear">
							<span><em>消费</em><i>X</i></span>
							<span><em>人民币</em><i>X</i></span>
						</div>
					</div>
					<div class="setting_name setting_h3 clear">
						<h3>签名：</h3>
						<input type="text" value="建设银行">
					</div>
					<div class="setting_get setting_h3 clear">
						<h3>提取信息：</h3>
						<div class="setting_get_info">
							<div class="setting_info_title setting_checked">
								<span class="span_span11"><i class="js_select"></i>&nbsp;全选</span>
							</div>
							<div class="setting_info_list setting_checked">
								<div class="setting_list">
									<span class="span_span11"><i class="js_select"></i>时间</span>
									<input type="text" value="09月11日12:23:58">
								</div>
								<div class="setting_list">
									<span class="span_span11"><i class="js_select"></i>卡号</span>
									<input type="text" value="10086">
								</div>
								<div class="setting_list">
									<span class="span_span11"><i class="js_select"></i>消费金额</span>
									<input type="text" value="1000.0">
								</div>
								<div class="setting_list">
									<span class="span_span11"><i class="js_select"></i>余额</span>
									<input type="text" value="9000.00">
								</div>
							</div>
						</div>
					</div>
					<div class="website_take" style="margin-left:99px;"><em>*</em>注意：输入的字符必须是内容示例中的唯一字符，如不唯一请手动修改实例内容。</div>
					<div class="short_btn website_btn"><button class="big_button btn_right" type="button">保存</button><button class="big_button" type="button">取消</button></div>
				</div>
			</div>
		</div>
	</div>
</div>