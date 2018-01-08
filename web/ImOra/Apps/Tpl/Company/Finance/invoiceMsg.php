<layout name="../Layout/Company/AdminLTE_layout" />
<div class="invoice_warp" id="js_show_wrap" <if condition="empty($info) || $info=='fail'">style="display:none"</if>>
	<div class="invoice_content">
		<div class="div_label">
			<span class="span_label">{$T->str_company_name}：</span><span class="span_title title_bold">{: session(MODULE_NAME)['bizname']}</span>
		</div>
		<div class="div_label">
			<span class="span_label">{$T->str_taxpayer_code}：</span>
			<span class="span_title"><if condition="!empty($info) && $info!='fail' ">{$info['code']}</if></span>
		</div>
		<div class="div_label">
			<span class="span_label">{$T->str_reg_addr}：</span>
			<span class="span_title"><if condition="!empty($info) && $info!='fail' ">{$info['regaddress']}</if></span>
		</div>
		<div class="div_label">
			<span class="span_label">{$T->str_reg_tel}：</span>
			<span class="span_title"><if condition="!empty($info) && $info!='fail' ">{$info['regtelephone']}</if></span>
		</div>
		<div class="div_label">
			<span class="span_label">{$T->str_opened_bank}：</span>
			<span class="span_title"><if condition="!empty($info) && $info!='fail' ">{$info['bank']}</if></span>
		</div>
		<div class="div_label">
			<span class="span_label">{$T->str_bank_account}：</span>
			<span class="span_title"><if condition="!empty($info) && $info!='fail' ">{$info['bankaccount']}</if></span>
		</div>
		<div class="div_label div_label_img">
			<span class="span_label">{$T->str_taxpayer_certify}：</span>
			<div class="div_prove">
				<img <if condition="!empty($info) && $info!='fail' ">src="{$info['paytaxprove']}"</if> alt="{$T->str_taxpayer_certify}" class="img_prove" id="js_img_up" picUrl="">
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
		<div class="div_label_btn">
			<span id="js_invoice_edit">编辑</span>
		</div>
	</div>
</div>
<div class="invoice_warp" id="js_edit_wrap" style="display: <if condition="empty($info) || $info=='fail' ">block<else/>none</if>">
		<div class="invoice_content">		
			<div class="div_label">
				<span class="span_label">{$T->str_company_name}：</span><span class="span_title title_bold">{: session(MODULE_NAME)['bizname']}</span>
			</div>
			<div class="div_label">
				<span class="span_label"><em>*</em>{$T->str_taxpayer_code}：</span>
				<input class="form_focus" type="text" name="taxpayer_code"
				<if condition="!empty($info) && $info!='fail'">value="{$info['code']}"</if>
				/>
			</div>
			<div class="div_label">
				<span class="span_label"><em>*</em>{$T->str_reg_addr}：</span>
				<input  class="form_focus" type="text" name="company_addr"
				<if condition="!empty($info) && $info!='fail' ">value="{$info['regaddress']}"</if>
				/>
			</div>
			<div class="div_label">
				<span class="span_label"><em>*</em>{$T->str_reg_tel}：</span>
				<input  class="form_focus" type="text" name="company_tel"
				<if condition="!empty($info) && $info!='fail' ">value="{$info['regtelephone']}"</if>
				/>
			</div>
			<div class="div_label">
				<span class="span_label"><em>*</em>{$T->str_opened_bank}：</span>
				<input  class="form_focus" type="text" name="bank"
				<if condition="!empty($info) && $info!='fail' ">value="{$info['bank']}"</if>
				/>
			</div>
			<div class="div_label">
				<span class="span_label"><em>*</em>{$T->str_bank_account}：</span>
				<input  class="form_focus" type="text" name="bank_account"
				<if condition="!empty($info) && $info!='fail' ">value="{$info['bankaccount']}"</if>
				/>

			</div>
			<div class="div_label_img">
				<span class="span_label"><em>*</em>{$T->str_taxpayer_certify}：</span>
				<div class="div_prove js_uploadImg_single">
					<span class="add_img js_add_img">+</span>
					<span class="remove_img js_remove_img">x</span>
					<input type="file" name="taxpayer_certify" accept="image/gif,image/png,image/jpeg" id="uploadImg"  style="display: none"/>
					<img  id="js_img_show"  <if condition="!empty($info) && $info!='fail' ">src="{$info['paytaxprove']}"
					<else/>style="display: none"</if>
					alt="{$T->str_taxpayer_certify}" >
					<input type="hidden" name="img" <if condition="!empty($info) && $info!='fail' ">value={$info['paytaxprove']}</if>  id="js_img_url"/>
				</div>
				<div class="clear"></div>
				<div class="div_label_ts">请上传扫描件或者复印件加盖<i>企业公章</i>后的拍照图片，并确保各项信息清析可见。</div>
			</div>
			<div class="clear"></div>
			<div class="div_label_btn btn_m_top">
				<span id="finance_sub">{$T->str_submit_save}</span>
				<span class="btn_can" <if condition="!empty($info) && $info!='fail' ">id="js_cancel_edit" <else/>class="right_w"</if>> 取消</span>
			</div>
		</div>
	</div>
<style type="text/css">
	.errinput{
		border: 1px solid red !important;
	}
</style>
<script>
	var postUrl = "__URL__/msgPost";
	var gUrlUploadFile = "{:U('/Company/Common/uploadSessTmpFile')}"; //上传图片;
	var str_please_complete = "{$T->tip_has_blank}";
	var imgPath= "{$info['paytaxprove']}";//是否已经提交过
	$(function(){
		$.finance.invoiceMsg();
	});
</script>