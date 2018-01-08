<layout name="../Layout/Layout" />
<div class="user_order_show">
	<div class="u_o_item">
		<h4>{$T->str_order_service_detail_info}</h4>
		<ul>
			<li><span>{$T->str_order_service_no}：</span><em>{$info.orderid}</em></li>
			<li class="clear"><span>{$T->str_order_service_created_time}：</span><em>{$info['createtime']|date='Y-m-d H:i:s',###}</em></li>
			<li class="clear"><span>{$T->str_order_service_company_id}：</span><em>{$info.bizemail}</em></li>
			<li class="clear"><span>{$T->str_order_service_company_name}：</span><em>{$info.bizname}</em></li>
			<li class="clear">
				<span>{$T->str_order_service_order_detail}：</span>
				<ol>
					<li><em>{$T->str_order_service_length}：{$info.length}{$T->str_order_service_year}</em><em>{$T->str_order_service_authorization}：{$info.authorize}{$T->str_order_service_unit1}</em><em>{$T->str_order_service_stock}：{$info.storage}{$T->str_order_service_unit2}</em></li>
				</ol>
			</li>
		</ul>
	</div>
	<div class="u_o_item u_o_height">
		<h4>{$T->str_order_service_status}</h4>
		<foreach name="info['statuslist']" item="vo"> 
			<p class="status_p"><span class="time_w">{$vo['createtime']|date='Y-m-d H:i:s',###}</span><em>{$paystatus[$vo['status']]}</em></p>
		</foreach>
	</div>
	<div class="u_o_item">
		<h4>{$T->str_order_service_pay_info}</h4>
		<ul>
			<li><span>{$T->str_order_service_amount}：</span><em>{$info.price}{$T->str_order_service_money_unit}</em></li>
			<li class="clear"><span>{$T->str_order_service_pay_way}：</span><em>{$T->str_order_service_company}</em></li>
			<li class="clear"><span>{$T->str_order_service_pay_type}：</span><em>{$T->str_order_service_99bill}</em></li>
			<li class="clear"><span>{$T->str_order_service_pay_no}：</span><em>{$info.tradeno}</em></li>
		</ul>
	</div>
</div>