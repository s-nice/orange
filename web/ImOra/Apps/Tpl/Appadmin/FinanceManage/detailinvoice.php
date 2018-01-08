<layout name="../Layout/Layout" />
<div class="showcond_warp">
	<div class="u_o_item js_content_detailinvoice">
		<h4>{$T->str_invoice_title_orderinfo}</h4>
		<ul>
            <if condition="$data['status'] eq 2">
                <li><span>{$T->str_invoice_numb}：</span><input class="num_text js_invoicenumb" autocomplete="off" name="invoicenumb" type="text"></li>
                <li>
                    <span>{$T->str_attachment}：</span>
                    <b class="p_file js_fileupload_dom">
                        <i>+</i>
                        <input type="file" name="picfile" id="js_attachment">
                        <em><img style="display:none;" src=""></em>
                        <input type="hidden" name="attachment" id="js_attachmentHid">
                    </b>
                    <input type="hidden" id="js_invoiceid" value="{$data['invoice_id']}">
                    <button type="button" class="js_submit_invoicenum">{$T->str_invoice_save}</button>
                </li>
            <else />
                <li><span>{$T->str_invoice_numb}：</span>{$data['invoice_numb']}</li>
                <notempty name="data['enclosure']">
                    <li>
                        <span>{$T->str_attachment}：</span>
                        <b class="p_file js_fileupload_dom">
                            <em><img src="{$data['enclosure']}"></em>
                        </b>
                    </li>
                </notempty>
            </if>

			<li class="clear"><span>{$T->str_invoice_type}：</span><em><if condition="$data['invoice_type'] eq 1">{$T->str_invoice_special}<else/>{$T->str_invoice_general}</if></em></li>
			<li class="clear">
                <span>{$T->str_invoice_title}：</span>
                <em>
                    <if condition="$data['invoice_type'] eq 1">
                        {$data['company']}
                        <else/>
                        {$data['invoice_head']}
                    </if>
                </em>
            </li>
			<li class="clear"><span>{$T->str_invoice_title_balance}：</span><em>{:number_format($balance,2)} {$T->str_invoice_title_unit}</em></li>
			<li class="clear"><span>{$T->str_invoice_billingdetail}：</span></li>
		</ul>
		<div class="pay_table order_table_w">
			<div class="pay_tit_list">
				<span class="span2">{$T->str_invoice_order_numb}</span>
				<span class="span1">{$T->str_invoice_businesstype}</span>
				<span>{$T->str_order_price}</span>
				<span>{$T->str_invoice_title_use_amount}</span>
				<span>{$T->str_invoice_this_amount}</span>
				<span>{$T->str_invoice_title_balance}</span>
			</div>
            <foreach name="orderdata" item="val">
                <div class="pay_con_list">
                    <span class="span2">{$val['order_id']}</span>
                    <span class="span1">{$order_type[$val['type']]}</span>
                    <span>{:number_format($val['price'],2)}</span>
                    <span>{:number_format($val['order_amount'],2)}</span>
                    <span>{:number_format($val['used_amount'],2)}</span>
                    <span>{:number_format($val['order_surplus'],2)}</span>
                </div>
            </foreach>
		</div>
	</div>
    <if condition="$data['invoice_type'] eq 1">
        <div class="showcond_tit">
            <h4>{$T->str_invoice_qualifications}</h4>
        </div>
        <div class="warp_top">
            <div class="warp-left">
                <div class="warp-list">
                    <span>{$T->str_invoice_title_contact}：</span>
                    <p>{$data['contact']}</p>
                </div>
                <div class="warp-list">
                    <span>{$T->str_invoice_title_telephone}：</span>
                    <p>{$data['contact_phone']}</p>
                </div>
                <div class="warp-list">
                    <span>{$T->str_invoice_title_compname}：</span>
                    <p>{$data['company']}</p>
                </div>
                <div class="warp-list">
                    <span>{$T->str_invoice_title_taxpercode}：</span>
                    <p>{$data['taxpayer_code']}</p>
                </div>
                <div class="warp-list">
                    <span>{$T->str_invoice_title_regaddr}：</span>
                    <p>{$data['company_address']}</p>
                </div>
                <div class="warp-list">
                    <span>{$T->str_invoice_title_regphone}：</span>
                    <p>{$data['company_phone']}</p>
                </div>
                <div class="warp-list">
                    <span>{$T->str_invoice_title_bankposit}：</span>
                    <p>{$data['bank_deposit']}</p>
                </div>
                <div class="warp-list">
                    <span>{$T->str_invoice_title_bankaccount}：</span>
                    <p>{$data['bank_account']}</p>
                </div>
            </div>
        </div>
        <div class="warp_bottom">
            <div class="warp_pic">
                <span>{$T->str_invoice_title_certificate}：</span>
                <i><img class="js_click_show" <empty name="data['certificate']">src="__PUBLIC__/images/showcard_pic.jpg"<else />src="{$data['certificate']}"</empty> /></i>
            </div>
            <div class="warp_pic1">
                <span>{$T->str_invoice_title_taxper}:</span>
                <i><img class="js_click_show"  <empty name="data['taxpayer']">src="__PUBLIC__/images/showcard_pic.jpg"<else />src="{$data['taxpayer']}"</empty> /></i>
            </div>
        </div>
    </if>
    <if condition="$data['status'] gt 1">
        <div class="record">
            <h4>{$T->str_finance_auditrecord}</h4>
            <div class="record_time">
                <span>{$T->str_g_datetime}</span>
                <span>{$T->str_finance_operatetype}</span>
                <span>{$T->str_entuser_note}</span>
            </div>
            <div class="record_time">
                <span>{$data['update_time']|date="Y-m-d H:i:s",###}</span>
                <span>
                    <if condition="$data['status'] lt 4">
                            {$T->str_make_sure_bill}
                        <elseif condition="$data['status'] eq 4" />
                            {$T->str_refuse_bill}
                        <else/>
                        ---
                    </if>
                </span>
                <notempty name="data['reason']"><span>{$data['reason']}</span></notempty>
            </div>
        </div>
    </if>
</div>
<!-- 图片预览弹框 -->
<div class="look_img js_preview" style="display:none;">
	<div class="close_img_btn"><img class="js_preview_close" src="__PUBLIC__/images/appadmin_icon_close.png"></div>
	<div class="img_content">
        <img class="js_img_show" src="__PUBLIC__/images/showcard_pic.jpg">
    </div>
</div>
<script>
    var js_uploadimg_url = "{:U(MODULE_NAME.'/FinanceManage/upLoadImgFile','','',true)}";
    var js_saveinvoicenumb_url = "{:U(MODULE_NAME.'/FinanceManage/saveInvoiceNumb','','',true)}";
    var js_invoice_addnumb_eight = "{$T->str_invoice_addnumb_eight}";
    var js_err_invoicetype_err_faild = "{$T->str_invoice_err_faild}";
    var js_err_invoicetype_img_err_big = "{$T->str_finance_img_err_big}";
    var js_operate_failed = "{$T->str_operate_failed}";
    var js_invoice_savenumb_faild = "{$T->str_invoice_savenumb_faild}";
    $(function(){
        $.finance.invoiceJs();
    });
</script>