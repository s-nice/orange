<layout name="../Layout/Layout" />
<div class="wamp_request">
    <form method="post" action="{:U(MODULE_NAME.'/FinanceManage/saveApplyInvoice','','',true)}" onsubmit="return $.finance.checkSubmitData();">
        <div class="request_top">
            <div class="request_text js_get_amountusable">
                <p><span>{$T->str_invoice_title_email}：</span><input name="email" type="text"></p>
                <p><span>{$T->str_invoice_title_id}：</span><input name="userid" maxlength="11" type="text"></p>
                <p><span>{$T->str_invoice_title_amount}：</span><input name="amount" type="text"></p>
                <p>
                    <span>{$T->str_invoice_title_use_amount}：</span><em><lll class="js_amount_result" data-val="">00.00</lll><b> {$T->str_invoice_title_unit}</b></em>
                </p>
                <p><span>{$T->str_invoice_title_type}：</span>
                    <label class="js_invoice_type_switch">
                        <input name="invoicetype" type="radio" value="z" checked>{$T->str_invoice_special}
                    </label>
                    <label class="js_invoice_type_switch">
                        <input name="invoicetype" type="radio" value="p">{$T->str_invoice_general}
                    </label>
                </p>
            </div>
        </div>
        <div class="js_invoice_type_zhuan">
            <div class="request_top request_mr_t clear">
                <div class="request_text">
                    <p><span>{$T->str_invoice_title_contact}：</span><input type="text" name="contact"></p>
                    <p><span>{$T->str_invoice_title_telephone}：</span><input type="text" name="telephone"></p>
                    <p><span>{$T->str_invoice_title_compname}：</span><input type="text" name="compname"></p>
                    <p><span>{$T->str_invoice_title_taxpercode}：</span><input type="text" name="taxpayercode"></p>
                    <p><span>{$T->str_invoice_title_regaddr}：</span><input type="text" name="compregaddress"></p>
                    <p><span>{$T->str_invoice_title_regphone}：</span><input type="text" name="compregphone"></p>
                    <p><span>{$T->str_invoice_title_bankposit}：</span><input type="text" name="bankdeposit"></p>
                    <p><span>{$T->str_invoice_title_bankaccount}：</span><input type="text" name="bankaccount"></p>
                </div>
            </div>
            <div class="request_bottom">
                <div class="request_right request_m_l">
                    <h4>{$T->str_invoice_title_certificate}：</h4>
                    <div class="request_sui js_fileupload_dom">
                        <span>+</span>
                        <input type="file" name="picfile" id="js_certificate">
                        <em><img style="display:none;" src=""></em>
                        <input type="hidden" name="certificate" id="js_certificateHid">
                    </div>
                </div>
                <div class="request_right request_m_l">
                    <h4>{$T->str_invoice_title_taxper}：</h4>
                    <div class="request_sui js_fileupload_dom">
                        <span>+</span>
                        <input type="file" name="picfile" id="js_taxpayer">
                        <em><img style="display:none;" src=""></em>
                        <input type="hidden" name="taxpayer" id="js_taxpayerHid">
                    </div>
                </div>
            </div>
            <div class="request_btn">
                <button class="big_button js_submit_btn_z" type="button">{$T->str_invoice_title_submit}</button>
                <button class="big_button js_cancel_btn" type="button">{$T->str_invoice_title_cancel}</button>
            </div>
        </div>
        <div class="js_invoice_type_pu" style="display:none;">
            <div class="request_top request_mr_t clear">
                <div class="request_text">
                    <p><span>{$T->str_invoice_title_invoicetitle}：</span><input type="text" name="invoicehead"></p>
                </div>
            </div>
            <div class="request_btn">
                <button class="big_button js_submit_btn_p" type="button">{$T->str_invoice_title_submit}</button>
                <button class="big_button js_cancel_btn" type="button">{$T->str_invoice_title_cancel}</button>
            </div>
        </div>
    </form>

</div>
<script>
    var js_invoice_list_url = "{:U(MODULE_NAME.'/FinanceManage/createInvoiceList','','',true)}";
    var js_getamountusable_url = "{:U(MODULE_NAME.'/FinanceManage/getAmountUsable','','',true)}";
    var js_uploadimg_url = "{:U(MODULE_NAME.'/FinanceManage/upLoadImgFile','','',true)}";
    var applyPostUrl = "{:U('Appadmin/FinanceManage/saveApplyInvoice')}";

    var js_err_amount = "{$T->str_invoice_input_err_amount}";
    var js_err_bigamount = "{$T->str_invoice_input_err_bigamount}";
    var js_err_email = "{$T->str_invoice_input_err_email}";
    var js_err_id = "{$T->str_invoice_input_err_id}";
    var js_err_amount_null = "{$T->str_invoice_input_err_amount_null}";
    var js_err_title = "{$T->str_invoice_input_err_title}";
    var js_err_contact = "{$T->str_invoice_input_err_contact}";
    var js_err_phone = "{$T->str_invoice_input_err_phone}";
    var js_err_comp = "{$T->str_invoice_input_err_comp}";
    var js_err_taxpayercode = "{$T->str_invoice_input_err_taxpayercode}";
    var js_err_regaddr = "{$T->str_invoice_input_err_regaddr}";
    var js_err_regphone = "{$T->str_invoice_input_err_regphone}";
    var js_err_bankdeposit = "{$T->str_invoice_input_err_bankdeposit}";
    var js_err_bankaccount = "{$T->str_invoice_input_err_bankaccount}";
    var js_format_err_bankaccount = "{$T->str_invoice_format_err_bankaccount}";
    var js_format_err_telephone = "{$T->str_invoice_format_err_telephone}";
    var js_format_err_comregphone = "{$T->str_invoice_format_err_comregphone}";
    var js_err_taxpayer = "{$T->str_invoice_input_err_taxpayer}";
    var js_err_certificate = "{$T->str_invoice_input_err_certificate}";
    var js_err_invoicetype = "{$T->str_invoice_input_err_invoicetype}";
    var js_err_invoicetype_err_faild = "{$T->str_invoice_err_faild}";
    var js_err_invoicetype_img_err_big = "{$T->str_finance_img_err_big}";
    var js_invoice_error_apply = "{$T->str_invoice_error_apply}";
    var js_invoice_cancel_apply = "{$T->str_invoice_cancel_apply}";
    var js_invoice_title_cancel = "{$T->str_invoice_title_cancel}";
    var js_g_message_submit1 = "{$T->str_g_message_submit1}";

    $(function(){
        $.finance.applyInvoiceJs();
    });
</script>