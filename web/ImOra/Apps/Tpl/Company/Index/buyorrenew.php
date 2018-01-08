<layout name="../Layout/Company/AdminLTE_layout" />
<div class="byorren_warp">
	<div class="byorren_center">
		<div class="byorren_title fontsize_b22">选择套餐：</div>
		<div class="byorren_sq js_buy_select">
			<span class="left fontsize_b16 title">购买授权数：</span>
			<div class="left byorren_list">
                <if condition="$authid !== 0 && $type == 7">
                    <span class="yuanxing on" data-val="{$data['authorizenum']}">{$data['authorizenum']}</span>
                    <else />
                    <span class="yuanxing on" data-val="5">5</span>
                    <span class="yuanxing" data-val="10">10</span>
                    <span class="yuanxing" data-val="15">15</span>
                    <span class="yuanxing" data-val="20">20</span>
                    <span class="yuanxing" data-val="30">30</span>
                    <span class="yuanxing" data-val="50">50</span>
                </if>

			</div>
            <if condition="$authid === 0 && $type == 5">
                <div class="left byorren_zdy">
                    <i class="left fontsize_b16">自定义</i>
                    <input type="text" id="js_buy_numb_val" value="" onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" />
                </div>
            </if>

		</div>
		<div class="byorren_sq js_memory_select">
			<span class="left fontsize_b16 title">名片储存量：</span>
			<div class="left byorren_dl">
                <if condition="$authid !== 0 && $type == 7">
                    <span class="yuanxing on" data-val="{$data['storagenum']}">{$data['storagenum']}</span>
                    <else />
                    <span class="yuanxing on" data-val="1000">1000</span>
                    <span class="yuanxing" data-val="2000">2000</span>
                    <span class="yuanxing" data-val="3000">3000</span>
                    <span class="yuanxing" data-val="4000">4000</span>
                    <span class="yuanxing" data-val="5000">5000</span>
                    <span class="yuanxing" data-val="6000">6000</span>
                    <span class="yuanxing" data-val="8000">8000</span>
                    <span class="yuanxing" data-val="10000">10000</span>
                </if>
			</div>
		</div>
		<div class="byorren_sq js_time_select">
			<span class="left fontsize_b16 title">购买时长：</span>
			<div class="left byorren_dl">
                <if condition="$authid !== 0 && $type == 7">
                    <foreach name="yearlength" item="vals">
                        <if condition="$data['length'] eq $vals">
                            <span class="yuanxing on" data-val="{$vals}">{$vals}年</span>
                            <else/>
                            <span class="yuanxing" data-val="{$vals}">{$vals}年</span>
                        </if>
                    </foreach>
                <else />
                    <span class="yuanxing on" data-val="1">1年</span>
                    <span class="yuanxing" data-val="2">2年</span>
                    <span class="yuanxing" data-val="3">3年</span>
                    <span class="yuanxing" data-val="5">5年</span>
                </if>
			</div>
		</div>
		<div class="byorren_fkje">
            <if condition="$authid !== 0 && $type == 7">
                <em class="fontsize_em">应付金额：</em><i class="fontsize_i"><ii>￥</ii><ie id="js_money_id">{$renewmoney}</ie></i>
                <else />
                <em class="fontsize_em">应付金额：</em><i class="fontsize_i"><ii>￥</ii><ie id="js_money_id">500</ie></i>
            </if>

		</div>
		<div class="addpay_button">
            <if condition="$authid !== 0 && $type == 7">
                <input type="hidden" value="{$data['authorizenum']}" class="js_sub_buy_numb">
                <input type="hidden" value="{$data['storagenum']}" class="js_sub_memory_numb">
                <input type="hidden" value="{$renewmoney}" class="js_sub_money">
                <else />
                <input type="hidden" value="5" class="js_sub_buy_numb">
                <input type="hidden" value="1000" class="js_sub_memory_numb">
                <input type="hidden" value="500" class="js_sub_money">
            </if>
            <input type="hidden" value="{$type}" class="js_sub_type">
            <input type="hidden" value="{$authid}" class="js_sub_aid">
            <input type="hidden" value="1" class="js_sub_time_length">

            <input class="safari fontsize_pubbin16 yuanxing js_buy_sub" type="button" value="立即购买" />
            <!---->
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
                <input type="hidden" name="productName" value="企业授权的购买或续费" />
                <input type="hidden" name="productNum" value="{$params['productNum']}" />
                <input type="hidden" name="productId" value="{$params['productId']}" />
                <input type="hidden" name="productDesc" value="{$params['productDesc']}" />
                <input type="hidden" name="ext1" value="" />
                <input type="hidden" name="ext2" value="" />
                <input type="hidden" name="payType" value="{$params['payType']}" />
                <input type="hidden" name="bankId" value="{$params['bankId']}" />
                <input type="hidden" name="redoFlag" value="{$params['redoFlag']}" />
                <input type="hidden" name="pid" value="{$params['pid']}" />
            </form>
            <!---->
        </div>
	</div>
</div>

<div class="js_addpay_ddan_pop addpay_ddan_pop" style="display:none;">
	<div class="addpaytitle_close"><span>提示信息</span><b class="js_close_confirm"></b></div>
	<div class="addpaytitle_text">
		<p>请您在新打开的页面中完成付款！<br/>
付款完成前请不要关闭此窗口。<br/>
完成付款后请根据您的情况点击下面的按钮：<br/>
		</p>
	</div>
	<div class="addpaytitle_btn">
		<input class="safari fontsize_pubbin16 yuanxing js_pay_success_res" type="button" value="付款完成" />
		<input class="safari fontsize_pubbin16 yuanxing js_pay_error_res" type="button" value="付款遇到问题" />
	</div>
</div>

<div class="addpay_pop js_addpay_failed" style="display:none;">
	<div class="pop_img"><img src="__PUBLIC__/images/companycard/company_shibai.jpg"/></div>
	<div class="pop_text">支付失败，请重新支付！</div>
	<div class="pop_tshi">如果您的银行卡已发生扣款，请联系客服<i>400-818-8888</i></div>
	<div class="pop_fhui"><input class="safari fontsize_pubbin16 yuanxing js_backact" type="button" value="返回重试" /></div>
</div>
<div class="addpay_sccuss js_addpay_succ" style="display:none;">
	<div class="pop_img"><img src="__PUBLIC__/images/companycard/company_cgong.jpg"/></div>
	<div class="pop_text_t">支付成功</div>
	<div class="pop_fhui"><input class="safari fontsize_pubbin16 yuanxing js_backto_list" type="button" value="返回" /></div>
</div>
<script type="text/javascript">
    var jsUrl = "{:U(MODULE_NAME.'/Index/isPayOk','','',true)}";
    var js_buyAccreditUrl = "{:U(MODULE_NAME.'/Index/buyAccredit','','',true)}";
    var auth_list_url = "{:U(MODULE_NAME.'/Index/accredit','','',true)}";
    $(function(){
        $.authorization.init();
    });
</script>