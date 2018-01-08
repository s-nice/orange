<layout name="../Layout/Layout" />
<div class="user_order_show">
	<notempty name="info">
	<div class="u_o_item">
		<h4>{$T->str_order_service_detail_info}</h4>
		<ul>
			<li><span>{$T->str_order_service_no}：</span><em>{$info.orderid}</em></li>
			<li class="clear"><span>{$T->str_order_service_created_time}：</span><em>{$info['createtime']|date='Y-m-d H:i:s',###}</em></li>
			<li class="clear"><span>{$T->str_order_service_user_id}：</span><em>{$info.mobile}</em></li>
			<li class="clear"><span>{$T->str_order_service_user_name}：</span><em>{$info.username}</em></li>
			<li class="clear"><span>{$T->str_order_service_order_detail}：</span>
            <em>{$T->str_order_service_member_length}</em><em>{$info.equity_time}{$T->str_order_service_member_length_unit}</em>
			<em>{$info.price}{$T->str_order_service_money_unit}</em></li>
		</ul>
	</div>
	<div class="u_o_item u_o_height">
		<h4>{$T->str_order_service_status}</h4>
		<foreach name="info.statuslist" item="vo"> 
			<p class="status_p"><span class="time_w">{$vo['createtime']|date='Y-m-d H:i:s',###}</span><em>{$paystatus[$vo['action']]}</em></p>
		</foreach>
	</div>
	<div class="u_o_item">
		<h4>{$T->str_order_service_pay_info}</h4>
		<ul>
			<li><span>{$T->str_order_service_amount}：</span><em>{$info.price}{$info.unit}</em></li>
			<li class="clear"><span>{$T->str_order_service_pay_way}：</span><em>{$T->str_order_service_personal}</em></li>
			<li class="clear"><span>{$T->str_order_service_pay_type}：</span><em>{$payment[$info['payment']]}</em></li>
			<li class="clear"><span>{$T->str_order_service_pay_no}：</span><em>{$info.tradeno}</em></li>
		</ul>
	</div>
	<else/>
	<center> No Data</center>
	</notempty>
	
</div>