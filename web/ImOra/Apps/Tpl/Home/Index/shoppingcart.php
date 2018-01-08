<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>商城-购物车</title>
<link rel="stylesheet" href="__PUBLIC__/css/Officialwebsite.css" />
</head>
<body>
	<div class="Officialwebsite_all">
		<div class="Officialwebsite_header">
	      <include file="Index/_headMenu"/>
	    </div>
		<div class="mallindex_content_c">
			<div class="shoppingcart_title">
				<span class="namespan">我的购物车 </span>
				<span class="tsspan">全场满￥1000顺丰包邮，支持支付宝、银联、微信付款</span>
			</div>
			<div class="shoppingcart_name">
				<span class="commodity">商品</span>
				<span class="number">价格</span>
				<span class="money">数量</span>
				<span class="Subtotal">小计</span>
			</div>
			<div class="shoppingcart_l">
				<div class="shoppingcart_list_c">
					<span class="input_check"><input name="Fruit" type="checkbox" value="" /></span>
					<span class="commodity_img"><img src="__PUBLIC__/images/detail_img3.jpg" /></span>
					<span class="cart_ms"><i>LEAF 型号 名称说明</i><em>预计出货时间：1-2个工作日</em></span>
					<span class="span_money">RMB <i class="unit_price">4999</i></span>
					<span class="span_jis">
						<i><img src="__PUBLIC__/images/shoppingcart_imgjian.jpg" /></i>
						<b>1</b>
						<em><img src="__PUBLIC__/images/shoppingcart_imgjia.jpg" /></em>
					</span>
					<span class="span_ljz">RMB <i class="sub_total_price">4999</i></span>
					<span class="span_del">删除</span>
				</div>
				<div class="shoppingcart_list_c">
					<span class="input_check"><input name="Fruit" type="checkbox" value="" /></span>
					<span class="commodity_img"><img src="__PUBLIC__/images/detail_img4.jpg" /></span>
					<span class="cart_ms"><i>适配器 名称说明</i><em>预计出货时间：1-2个工作日</em></span>
					<span class="span_money">RMB <i class="unit_price">199</i></span>
					<span class="span_jis">
						<i><img src="__PUBLIC__/images/shoppingcart_imgjian.jpg" /></i>
						<b>1</b>
						<em><img src="__PUBLIC__/images/shoppingcart_imgjia.jpg" /></em>
					</span>
					<span class="span_ljz">RMB <i class="sub_total_price">199</i></span>
					<span class="span_del">删除</span>
				</div>
				<div class="shoppingcart_list_c">
					<span class="input_check"><input name="Fruit" type="checkbox" value="" /></span>
					<span class="commodity_img"><img src="__PUBLIC__/images/detail_img5.jpg" /></span>
					<span class="cart_ms"><i>连接线 名称说明</i><em>预计出货时间：1-2个工作日</em></span>
					<span class="span_money">RMB <i class="unit_price">149</i></span>
					<span class="span_jis">
						<i><img src="__PUBLIC__/images/shoppingcart_imgjian.jpg" /></i>
						<b>1</b>
						<em><img src="__PUBLIC__/images/shoppingcart_imgjia.jpg" /></em>
					</span>
					<span class="span_ljz">RMB <i class="sub_total_price">149</i></span>
					<span class="span_del">删除</span>
				</div>

			</div>
			<div class="shoppingcart_jiesuan">
				<div class="shoppingcart_checkbox"><input id="check_all" name="Fruit" type="checkbox" value="" /><i>全选</i></div>
				<div class="shoppingcart_right">
					<p><i>已选择<em id="total_num">1</em>件商品</i><span>总计（不包括运费）：<em>RMB <ii id="total_price">5297</ii></em></span></p>
					<div class="js_bin">
						<a href="Mallindex.html"><span class="span_bin1">继续购物</span></a>
						<a href="SubmitOrder.html"><span class="span_bin2">去结算</span></a>
					</div>
				</div>
			</div>
			<div class="shoppingcart_bottom">
				<span>有优惠券或者Ora币？</span>
				<i>您可以在结账时使用优惠券或Ora币，但请注意两者不能同时使用</i>
			</div>
		</div>
		<div class="mallindex_footer"><p>Copyright © 2016 IMORA Inc. 保留所有权利京公安网安备 11010500896 京ICP备15052779号 </p></div>
	</div>
</body>
<script src="__PUBLIC__/js/jquery-1.9.1.min.js"></script>
<script src="__PUBLIC__/js/jquery.cookie.min.js"></script>
<script src="__PUBLIC__/js/shoppingcart.js"></script>
<script>
$(function(){
});
</script>
</html>