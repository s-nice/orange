<layout name="../Layout/Company/AdminLTE_layout" xmlns="http://www.w3.org/1999/html"/>
	<script>
		var applyUrl = "__URL__/apply";
		var postUrl = "__URL__/applyPost";
		$(function(){
			$.finance.invoiceList();
		});
	</script>
	<div class="invoice_warp">
		<div class="apply_msg">
			<span class="span_msg">{$T->str_can_apply_num}：<b>10000</b>元</span>
			<span class="span_msg" class="span_msg">{$T->str_cumulative_charge}：<b>20000</b>{$T->str_rmb}</span>
			<span class="span_msg">{$T->str_already_billing}：<b>1000</b>{$T->str_rmb}</span>
			<a href="javascript:void(0)" onclick="window.open('{:U('Company/Finance/apply','','','',true)}')" >
			 <span class="span_btn" id="js_btn_apply">{$T->str_apply}</span>
			</a>
		</div>
		<div class="row apply_title">
			<span class="span_1 col-md-3 border_left">{$T->str_apply_time}</span>
			<span class="span_2 col-md-3">{$T->str_billing_money}</span>
			<span class="span_3 col-md-3">{$T->str_billing_title}</span>
			<span class="span_4 col-md-3 blue_text">{$T->str_billing_status}</span>
		</div>
		<div class="row apply_list">
			<span class="span_1 col-md-3 border_left">2016-9-1 18:30</span>
			<span class="span_2 col-md-3">100.00元</span>
			<span class="span_3 col-md-3">北京橙鑫数据科技有限公司</span>
			<span class="span_4 col-md-3 blue_text">{$T->str_in_billing}</span>
		</div>
		<div class="row apply_list">
			<span class="span_1 col-md-3 border_left">2016-9-1 18:30</span>
			<span class="span_2 col-md-3">100.00元</span>
			<span class="span_3 col-md-3">北京橙鑫数据科技有限公司</span>
			<span class="span_4 col-md-3 blue_text">{$T->str_already_billing}</span>
		</div>
	</div>
	<div id="layer_div" style="display:none;">
	</div>
