<layout name="../Layout/Company/AdminLTE_layout" />
<div class="addpay_warp">
	<div class="addpay_content">
		<div class="addpay_name">
			<span class="fontsize_22">公司名称： </span>
			<p class="fontsize_22">{$bizInfo['bizname']}</p>
		</div>
		<div class="addpay_name">
			<span class="fontsize_22">充值金额： </span>
			<label class="fontsize_22"><input name="num" class="fontsize_16" type="text" inputmode="numeric" pattern="[0-9]*" placeholder="起冲金额1000元" />元</label>
		</div>
		<div class="addpay_button">
          <form name="payForm" method="post" target="_blank" action="https://sandbox.99bill.com/gateway/recvMerchantInfoAction.htm">
			<!-- 顺序不可乱 -->
			<input type="hidden" name="inputCharset" value="{$params['inputCharset']}" />
		    <input type="hidden" name="pageUrl" value="" />
			<input type="hidden" id="js_bgUrl" name="bgUrl" value="{$params['bgUrl']}" />
 			<input type="hidden" name="version" value="{$params['version']}" />
			<input type="hidden" name="language" value="{$params['language']}" />
			<input type="hidden" name="signType" value="{$params['signType']}" />
			<input type="hidden" id="js_signMsg" name="signMsg" value="{$params['signMsg']}" />
			<input type="hidden" name="merchantAcctId" value="{$params['merchantAcctId']}" />
			<input type="hidden" name="payerName" value="{$params['payerName']}" />
			<input type="hidden" name="payerContactType" value="{$params['payerContactType']}" />
			<input type="hidden" name="payerContact" value="{$params['payerContact']}" />
			<input type="hidden" id="js_orderId" name="orderId" value="{$params['orderId']}" />
			<input type="hidden" id="js_orderAmount" name="orderAmount" value="{$params['orderAmount']}" />
			<input type="hidden" id="js_orderTime" name="orderTime" value="{$params['orderTime']}" />
			<input type="hidden" name="productName" value="企业充值消费" />
			<input type="hidden" name="productNum" value="{$params['productNum']}" />
			<input type="hidden" name="productId" value="{$params['productId']}" />
			<input type="hidden" name="productDesc" value="{$params['productDesc']}" />
			<input type="hidden" name="ext1" value="" />
			<input type="hidden" name="ext2" value="" />
			<input type="hidden" name="payType" value="{$params['payType']}" />
			<input type="hidden" name="bankId" value="{$params['bankId']}" />
			<input type="hidden" name="redoFlag" value="{$params['redoFlag']}" />
			<input type="hidden" name="pid" value="{$params['pid']}" />
		  <input class="js_submitpay safari fontsize_pubbin16 yuanxing" type="submit" value="立即支付" />
		   </form>
		</div>
	</div>
</div>
<div class="js_addpay_ddan_pop addpay_ddan_pop" style="display:none;">
	<div class="addpaytitle_close"><span>提示信息</span><b class="js_payfail_act hand"></b></div>
	<div class="addpaytitle_text">
		<p>请您在新打开的页面中完成付款！<br/>付款完成前请不要关闭此窗口。<br/>完成付款后请根据您的情况点击下面的按钮：<br/></p>
	</div>
	<div class="addpaytitle_btn">
		<input jsUrl="{:U('Pay/isPaySucc','','',true)}" class="js_paysucc_act safari fontsize_pubbin16 yuanxing" type="button" value="付款完成" />
		<input class="js_payfail_act safari fontsize_pubbin16 yuanxing" type="button" value="付款遇到问题" />
	</div>
</div>
<div class="js_addpay_pop addpay_pop" style="display:none;">
	<div class="pop_img"><img src="__PUBLIC__/images/companycard/company_shibai.jpg"/></div>
	<div class="pop_text">支付失败，请重新支付！</div>
	<div class="pop_tshi">如果您的银行卡已发生扣款，请联系客服<i>400-818-8888</i></div>
	<div class="pop_fhui"><input class="js_reback_submitpay safari fontsize_pubbin16 yuanxing" type="button" value="返回重试" /></div>
</div>
<div class="js_addpay_succ addpay_sccuss" style="display:none;">
	<div class="pop_img"><img src="__PUBLIC__/images/companycard/company_cgong.jpg"/></div>
	<div class="pop_text_t">支付成功</div>
	<div class="pop_fhui"><input class="js_reback_paylist safari fontsize_pubbin16 yuanxing" type="button" value="返回" /></div>
</div>
<script>
var payListUrl = "{:U('Pay/payList','','',true)}";
var createOrderUrl = "{:U('Pay/createOrder','','',true)}";
$(function(){
	$.payManage.payActPage();
});
</script>