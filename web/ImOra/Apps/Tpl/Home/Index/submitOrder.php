<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>商城-生成订单</title>
<link rel="stylesheet" href="__PUBLIC__/css/Officialwebsite.css" />
<script src="__PUBLIC__/js/jquery-1.9.1.min.js"></script>
<script src="__PUBLIC__/js/jquery.cookie.js"></script>
<script src="__PUBLIC__/js/order.js"></script>
</head>
<body>
	<div class="Officialwebsite_all">
		<div class="Officialwebsite_header">
			<div class="Officialwebsite_l">
	  <include file="Index/_headMenu"/>
			</div>
		</div>
		<div class="mallindex_content_c">
			<div class="submitorder_title">提交订单</div>
			<div class="submitorder_theway">
				<div class="theway_title">1. 购买方式</div>
				<div class="theway_c">
					<div class="theway_c_left">
						<div class="theway_tishi">
							<span>已有Ora账号？</span>
							<p>请登录以便享受更加快捷方便的购物体验</p>
						</div>
						<div class="theway_login_ora">
							<span><input name="email" class="text_input" type="text" placeholder="邮箱" /></span>
<span><input name="password" class="text_input" type="password" placeholder="密码" /></span>
							<span><input class="button_input" type="button" value="登录购买" /></span>
						</div>
					</div>
					<div class="theway_c_right">
						<div class="theway_tishi">
							<span>没有Ora账号？</span>
							<p>没关系，请输入邮箱地址即可开始下单</p>
						</div>
						<div class="theway_login_noora">
							<span><input name="email" class="text_input" type="text" placeholder="邮箱" /></span>
<span><input name="remail" class="text_input" type="text" placeholder="确认邮件" /></span>
							<span><input class="button_input" type="button" value="以游客身份购买" /></span>
							<i>邮箱非常重要，订单信息将发送到您的信箱。请放心，我们将对您的私人信息严格保密</i>
						</div>
					</div>
				</div>
			</div>
			<div class="submitorder_information">
				<div class="theway_title">2. 收货信息</div>
				<div class="information_c">
					<div class="information_c_left">
						<div class="c_left_top">
							<div class="information_shr">
								<span>收货人</span>
								<input name="receiver" type="text" />
							</div>
							<div class="information_phone">
								<span>手机号码／固定电话</span>
								<input name="tel" type="text" />
							</div>
							<div class="information_ZipCode">
								<span>邮编</span>
								<input type="text" />
							</div>
						</div>
						<div class="c_left_middle">
							<div class="information_biaot">
								<span class="gj">国家／地区</span>
								<span class="s">省</span>
								<span class="city">城市</span>
								<span class="sq">区／县</span>
								<span class="jd">街道／乡道</span>
							</div>
							<div class="information_select">
								<div class="gj_select">
									<input type="text" readonly="true" value="中国大陆" />
									<i><img src="__PUBLIC__/images/shoppingcart_select.jpg" /></i>
									<ul>
										<li>中国</li>
										<li>中国</li>
										<li>中国</li>
										<li>中国</li>
									</ul>
								</div>
								<div class="city_select">
									<input type="text" readonly="true" value="请选择" />
									<i><img src="__PUBLIC__/images/shoppingcart_select.jpg" /></i>
									<ul>
										<li>河北</li>
										<li>河北</li>
										<li>河北</li>
										<li>河北</li>
									</ul>
								</div>
								<div class="qx_select">
									<input type="text" readonly="true" value="请选择" />
									<i><img src="__PUBLIC__/images/shoppingcart_select.jpg" /></i>
									<ul>
										<li>保定</li>
										<li>保定</li>
										<li>保定</li>
										<li>保定</li>
									</ul>
								</div>
								<div class="jd_select">
									<input type="text" readonly="true" value="请选择" />
									<i><img src="__PUBLIC__/images/shoppingcart_select.jpg" /></i>
									<ul>
										<li>清苑</li>
										<li>清苑</li>
										<li>清苑</li>
										<li>清苑</li>
									</ul>
								</div>
								<div class="xd_select">
									<input type="text" readonly="true" value="请选择" />
									<i><img src="__PUBLIC__/images/shoppingcart_select.jpg" /></i>
									<ul>
										<li>东吕</li>
										<li>东吕</li>
										<li>东吕</li>
										<li>东吕</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="c_left_bottom">
							<span>详细地址</span>
							<input type="text" name="address" placeholder="路名或街道地址门牌号" />
						</div>
					</div>
					<div class="information_c_right">
						<p>如果您所在的城市不在下拉菜单中的城市范围内，我们目前无法送货。请点击这里查看您附近的 IMORA 授权经销商。<br/>
送货时间按照送货至市中心地区进行估算。送货至边远地区可能需要更长的时间。您的发货通知电子邮件中将包括按照您的具体地址估算的送货时间。<br/>
对于军事禁区，保税监管区或者其他任何政府监管区域，(我们)将无法提供运送服务。<br/>
送货时间：星期一至星期日 上午 8:30 至下午 5:30 (公众假期暂停交货)</p>
					</div>
				</div>
			</div>
			<div class="submitorder_Pay">
				<div class="Pay_title">3. 支付方式</div>
				<div class="Pay_content">
					<div class="Pay_zfb">
						<span><i class="active"></i></span>
						<em><img src="__PUBLIC__/images/pay_imgzfb.jpg" /></em>
						<p><font>（推荐）</font>支付宝付款说明支付宝付款说明支付宝付款说明支付宝付款说明</p>
					</div>
					<div class="Pay_weixin">
						<span><i class=""></i></span>
						<em><img src="__PUBLIC__/images/pay_imgweixin.jpg" /></em>
						<p>微信支付说明微信支付说明微信支付说明微信支付说明微信支付</p>
					</div>
					<div class="Pay_yinlian">
						<span><i class=""></i></span>
						<em><img src="__PUBLIC__/images/pay_imgzyinl.jpg" /></em>
						<p>银联付款说明银联付款说明银联付款说明银联付款说明银联付款</p>
					</div>
				</div>
			</div>
			<div class="submitorder_message">
				<div class="Pay_title">4. 订单信息</div>
				<div class="message_content">
					<div class="message_content_l">
						<div class="message_list">
							<span class="commodity_img"><img src="__PUBLIC__/images/detail_img3.jpg" /></span>
							<span class="cart_ms"><i>LEAF 型号 名称说明</i><em>预计出货时间：1-2个工作日</em></span>
							<span class="span_money">RMB <ii>4999</ii></span>
							<span class="span_num">1</span>
						</div>
						<div class="message_list">
							<span class="commodity_img"><img src="__PUBLIC__/images/shoppingcart_img1.jpg" /></span>
							<span class="cart_ms"><i>适配器 名称说明</i><em>预计出货时间：1-2个工作日</em></span>
							<span class="span_money">RMB <ii>199</ii></span>
							<span class="span_num">1</span>
						</div>
						<div class="message_list">
							<span class="commodity_img"><img src="__PUBLIC__/images/shoppingcart_img.jpg" /></span>
							<span class="cart_ms"><i>连接线 名称说明</i><em>预计出货时间：1-2个工作日</em></span>
							<span class="span_money">RMB <ii>149</ii></span>
							<span class="span_num">1</span>
						</div>
					</div>
					<div class="message_fpiao">
						<h2>发票信息</h2>
						<div class="message_fpiao_c"><span><i class="active"></i><em>不开发票</em></em></span><span><i class=""></i><em>开发票</em></span></div>
						<div class="message_fpiao_input" style="display:none;"><span>发票抬头</span><input name="fpiao" type="text" /></div>
					</div>
					<div class="message_spinmessage">
						<div class="spinmessage_c">
							<div class="spinmessage_c_p">
								<p><span><ii id="total_num">3</ii>件商品，总商品金额：</span><i>RMB <ii class="total_price">5297</ii></i></p>
								<p><span>运费：</span><i>免费</i></p>
								<p><span>优惠：</span><i>0</i></p>
								<p><span>合计：</span><i>RMB <ii class="total_price">5297</ii></i></p>
							</div>
							<div class="bin_submit">提交订单</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="mallindex_footer"><p>Copyright © 2016 IMORA Inc. 保留所有权利京公安网安备 11010500896 京ICP备15052779号 </p></div>
	</div>
</body>
<script>
$(function(){
});
</script>
</html>