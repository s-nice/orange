<layout name="../Layout/Layout" />
<div class="showcond_warp">
	<div class="u_o_item">
		<h4>{$T->str_invoice_title_orderinfo}</h4>
		<ul>
			<li class="clear"><span>{$T->str_invoice_type}：</span><em><if condition="$info['invoice_type'] eq 1">{$T->str_invoice_special}<else />{$T->str_invoice_general}</if></em></li>
			<li class="clear"><span>{$T->str_invoice_title}：</span><em><if condition="$info['invoice_type'] eq 1">{$info.company}<else />{$info.invoice_head}</if></em></li>
			<li class="clear"><span>{$T->str_invoice_title_balance}：</span><em>{:number_format($total,2)} {$T->str_rmb}</em></li>
			<li class="clear"><span>{$T->str_invoice_detail}：</span></li>
		</ul>
		<div class="pay_table order_table_w">
			<div class="pay_tit_list">
				<span class="span2">{$T->str_invoice_order_numb}</span>
				<span>{$T->str_invoice_businesstype}</span>
				<span class="span1">{$T->str_order_price}</span>
				<span>{$T->str_invoice_title_use_amount}</span>
				<span>{$T->str_invoice_this_amount}</span>
				<span>{$T->str_invoice_title_balance}</span>
			</div>
		<php>
		$ordersTotal = 0;
		$availableTotal = 0;
		$usedAmountTotal = 0;
		$leftAmountTotal = 0;
		$oList = array();
		</php>
		  <foreach name="ordersList" item="val">
			<div class="pay_con_list">
				<span class="span2">{$val['order_id']}</span>
                <span>{$order_type[$val['type']]}</span>
                <span class="span1">{:number_format($val['price'],2)}</span>
                <span>{:number_format(($val['used_amount']+$val['order_surplus']),2)}</span>
                <span>{:number_format($val['used_amount'],2)}</span>
                <span>{:number_format($val['order_surplus'],2)}</span>
			</div>
			<php>
			$oList[$val['order_id']] = $val['used_amount'];
			$ordersTotal +=$val['price'];
			$availableTotal +=$val['used_amount'];
			$availableTotal +=$val['order_surplus'];
			$usedAmountTotal +=$val['used_amount'];
			$leftAmountTotal +=$val['order_surplus'];
			</php>
		 </foreach>
			<div class="pay_con_list">
				<span class="span2"><b>{$T->str_invoice_sum}</b></span>
				<span>&nbsp;</span>
				<span class="span1">{:number_format($ordersTotal,2)}</span>
				<span>{:number_format($availableTotal,2)}</span>
				<span>{:number_format($usedAmountTotal,2)}</span>
				<span>{:number_format($leftAmountTotal,2)}</span>
			</div>
		</div>
	</div>
	<if condition="$info['invoice_type'] eq 1">
	<div class="showcond_tit">
		<h4>{$T->str_invoice_qualifications}</h4>
	</div>
	<div class="warp_top">
		<div class="warp-left">
			<div class="warp-list">
				<span>{$T->str_invoice_title_contact}：</span>
				<p>{$info.contact}</p>
			</div>
			<div class="warp-list">
				<span>{$T->str_invoice_title_telephone}：</span>
				<p>{$info.contact_phone}</p>
			</div>
			<div class="warp-list">
				<span>{$T->str_invoice_title_compname}：</span>
				<p>{$info.company}</p>
			</div>
			<div class="warp-list">
				<span>{$T->str_invoice_title_taxpercode}：</span>
				<p>{$info.taxpayer_code}</p>
			</div>
			<div class="warp-list">
				<span>{$T->str_invoice_title_regaddr}：</span>
				<p>{$info.company_address}</p>
			</div>
			<div class="warp-list">
				<span>{$T->str_invoice_title_regphone}：</span>
				<p>{$info.company_phone}</p>
			</div>
			<div class="warp-list">
				<span>{$T->str_invoice_title_bankposit}：</span>
				<p>{$info.bank_deposit}</p>
			</div>
			<div class="warp-list">
				<span>{$T->str_invoice_title_bankaccount}：</span>
				<p>{$info.bank_account}</p>
			</div>
		</div>
	</div>
	<div class="warp_bottom">
		<div class="warp_pic">
			<span>{$T->str_invoice_title_certificate}：</span>
			<i><img class="js_click_show" <empty name="info['certificate']">src="__PUBLIC__/images/showcard_pic.jpg"<else />src="{$info['certificate']}"</empty> /></i>
		</div>
		<div class="warp_pic1">
			<span>{$T->str_invoice_title_taxper}:</span>
			<i><img class="js_click_show"  <empty name="info['taxpayer']">src="__PUBLIC__/images/showcard_pic.jpg"<else />src="{$info['taxpayer']}"</empty> /></i>
		</div>
	</div>
	</if>
	<div class="problem_bin js_stayinvoice">
		<input type="hidden" name="invoiceId" value="{$info.invoice_id}"/>
		<input class="problem_inputr big_button js_confirm_biling" type="button" value="{$T->str_make_sure_bill}" />
		<input class="big_button js_refuse_biling" type="button" value="{$T->str_refuse_bill}" />
		<input class="big_button js_cancel_btn" type="button" value="{$T->str_invoice_title_cancel}" />
	</div>
</div>
<!-- 图片预览弹框 -->
<div class="look_img js_preview" style="display:none;">
	<div class="close_img_btn"><img class="js_preview_close" src="__PUBLIC__/images/appadmin_icon_close.png"></div>
	<div class="img_content">
        <img class="js_img_show" src="__PUBLIC__/images/appadmin_nszm.jpg">
    </div>
</div>
<input type="hidden" name="olist" value='{:json_encode($oList)}' />
<!-- 拒绝原因弹框 -->
<div class="refuse_box js_box_refuse_biling">
	<h4>{$T->str_prompt}<em class="js_refuse_cancel">X</em></h4>
	<h5>{$T->str_input_reason}：</h5>
	<textarea id="js_box_refusebiling" cols="30" rows="10"></textarea>
	<div class="refuse_btn">
		<button class="big_button js_refuse_submit" type="button">{$T->str_invoice_title_submit}</button>
		<button class="big_button js_refuse_cancel" type="button">{$T->str_invoice_title_cancel}</button>
	</div>
</div>
<script>
    var js_invoice_list_url = "{:U(MODULE_NAME.'/FinanceManage/createInvoiceList','','',true)}";
    var js_invoice_biling = "{:U(MODULE_NAME.'/FinanceManage/confirmBiling','','',true)}";
    var js_invoice_biling_refuse = "{:U(MODULE_NAME.'/FinanceManage/refuseBiling','','',true)}";

    var js_invoice_addnumb_eight = "{$T->str_invoice_addnumb_eight}";
    var js_invoice_savenumb_faild = "{$T->str_invoice_savenumb_faild}";
    var js_operate_failed = "{$T->str_operate_failed}";
    var js_input_reason = "{$T->str_input_reason}";
    var js_make_sure_bill = "{$T->str_make_sure_bill}";
    var js_invoice_title_cancel = "{$T->str_invoice_title_cancel}";
    var js_g_message_submit1 = "{$T->str_g_message_submit1}";
    $(function(){
        $.finance.invoiceJs();
    });
</script>
