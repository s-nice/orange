<layout name="../Layout/Layout" />
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<include file="menus" tabsms="on" tabmail="" tabweb=""/><!-- 内容中的顶部菜单 -->
			<div class="setting_box clear setting_h3">
				<div class="setting_radio">
					<h3>内容类型：</h3>
					<div class="setting_radio_list">
						<foreach name="contentTypeList" item="vo">
							<label for="id_{$vo.id}"><input id="id_{$vo.id}" type="radio" name="contentType">{$vo.name}</label>
						</foreach>
					</div>
					<div class="setting_card clear setting_h3 clear" style="padding-top:10px;">
						<h3>卡类型：</h3>
						<div class="menu_card js_sel_public js_sel_card_type menu_list">
							<input type="text" value="信用卡" readonly="true">
							<em></em>
							<ul>
								<foreach name="cardTypeList" item="vo">
								<li val="{$vo.id}">{$vo.name}</li>
								</foreach>
							</ul>
						</div>
					</div>
					<div class="setting_card clear setting_h3">
						<h3>推送单位：</h3>
						<div class="menu_card js_sel_public js_sel_push_units menu_list">
							<input type="text" value="招商银行" readonly="true">
							<em></em>
							<ul>
								<li class="on">招商银行</li>
								<li>交通银行</li>
								<li>浦发银行</li>
								<li>建设银行</li>
							</ul>
						</div>
					</div>
					<div class="setting_content clear setting_h3">
						<h3>内容示例：</h3>
						<p>您尾号是1086的建行卡于09年31日13:23:58消费人民币10000.00元。当前余额为9000.00元。如有疑问请联系我行客服95533【建设银行】</p>
					</div>
					<div class="setting_come clear setting_h3">
						<h3>来源：</h3>
						<input type="text" value="95533" id="source" name="source">
					</div>
					<div class="setting_key clear setting_h3">
						<h3>关键词：</h3>
						<input type="text" value="输入关键词以“,”号隔开"  id="kwd" name="kwd">
						<span class="add_key">添加</span>
						<div class="add_key_font clear">
							<span><em>消费</em><i>X</i></span><span><em>人民币</em><i>X</i></span>
						</div>
					</div>
					<div class="setting_name clear setting_h3">
						<h3>签名：</h3>
						<input type="text" value="建设银行" name="sign" id="sign">
					</div>
					<div class="setting_get clear setting_h3">
						<h3>提取信息：</h3>
						<div class="setting_get_info js_coll_info_content">
							<div class="setting_info_title setting_checked">
								<span class="span_span11"><i class="js_allselect"></i>&nbsp;全选</span>
							</div>
							<div class="setting_info_list">
								<div class="setting_list setting_checked">
									<span class="span_span11"><i class="js_select"></i>时间</span>
									<input type="text" value="09月11日12:23:58" id="collDate">
								</div>
								<div class="setting_list setting_checked">
									<span class="span_span11"><i class="js_select"></i>卡号</span>
									<input type="text" value="10086" id="collCardNum">
								</div>
								<div class="setting_list setting_checked">
									<span class="span_span11"><i class="js_select"></i>消费金额</span>
									<input type="text" value="1000.0" id="collPayMoney">
								</div>
								<div class="setting_list setting_checked">
									<span class="span_span11"><i class="js_select" id="collOverage"></i>余额</span>
									<input type="text" value="9000.00">
								</div>
							</div>
						</div>
						<div class="website_take clear" style="margin-left:99px;"><em>*</em>注意：输入的字符必须是内容示例中的唯一字符，如不唯一请手动修改实例内容。</div>
						<div class="short_btn website_btn"><button class="big_button btn_right" type="button" id="js_btn_ok">保存</button><button class="big_button" type="button">取消</button></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$(function(){
	 $.addSms.smsInit();
	 $('.js_sel_card_type').selectPlug({getValId:'cardType',defaultVal: ''}); //下拉框
	 $('.js_sel_push_units').selectPlug({getValId:'pushUnits',defaultVal: ''}); //下拉框
});
</script>