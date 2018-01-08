<layout name="../Layout/Company/AdminLTE_layout" />
<div class="apply_content">
	<div class="apply_auto">		
		<div class="apply_label">
			<span class="span_apply">{$T->str_company_name}：</span><span class="span_title_apply">北京橙鑫数据科技有限公司</span>
		</div>
		<div class="apply_label">
			<span class="span_apply">{$T->str_can_apply_num}：</span><span class="span_title_apply"><b>10000</b>{$T->str_rmb}</span>
		</div>
		<div class="apply_label">
			<span class="span_apply">类别：</span>
			<span class="apply_xz"><input id="checked-2-1" name="Fruit" type="radio" value="" /><label for="checked-2-1"></label></span><em>普票</em>
			<span class="apply_xz"><input id="checked-2-2" name="Fruit" type="radio" value="" /><label for="checked-2-2"></label></span><em>专票</em>
		</div>
		<div class="apply_label">
			<span class="span_apply">{$T->str_billing_num}：</span><input class="form_focus" type="text" name="money">
		</div>
		<div class="apply_label_btn">
			<span class="btn_sub" id="js_finance_sub">{$T->str_intro_save}</span>
			<span class="btn_can" id="js_finance_can">{$T->str_btn_cancel}</span>
		</div>
	</div>
</div>
