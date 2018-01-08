<layout name="../Layout/Layout" />
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<!--头部搜索-->
			<div class="content_search">
            	<div class="search_right_c">
                    <input type='hidden' id='order' value='{$get.order}'>
                    <input type='hidden' id='ordertype' value='{$get.ordertype}'>
            		<div class="orderlist_input">
            			<span>{$T->str_order_service_no}</span>
            			<input id='orderId' type="text" value="{$get.orderId}" />
            		</div>
            	    <div class="select_Itwo">
            	    	<span>{$T->str_order_service_status}</span>
            	    	<div class="select_sketchtwo menu_list">
	            			<input id='orderStatus' class="js_select_title" type="text" value="{$T->str_order_service_all}" readonly="readonly" />
	            			<i class="js_select_item"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	            			<ul id='js_select_content1' class="js_select_content">
	            			    <li val='' class="on">{$T->str_order_service_all}</li>
	            			    <li val='1'>{$T->str_order_service_for_pay}</li>
	            			    <li val='2'>{$T->str_order_service_payed}</li>
	            			</ul>
            			</div>
            		</div>
            		<div class="select_sketchtwo menu_list">
            			<input id='searchType' class="js_select_title" type="text" value="{$T->str_order_service_user_id}" readonly="readonly" val='userid'/>
            			<i class="js_select_item"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            			<ul id='js_select_content2' class="js_select_content">
            				<li class="on" val='userid'>{$T->str_order_service_user_id}</li>
            				<li val='username'>{$T->str_order_service_user_name}</li>
            			</ul>
            		</div>
            	    <div class="search_new_w">
            			<input id='keyword' type="text" value="{$get.keyword}" />
            		</div>
            		<div class="select_time_c">
            			<span>{$T->str_time}</span>
						<div class="time_c">
							<input id="js_begintime" class="time_input" type="text" name="starttime" value="{$get['starttime']}" readonly="readonly" />
							<i class="js_delTimeStr"></i>
						</div>
						<span>-</span>
						<div class="time_c">
							<input id="js_endtime" class="time_input" type="text" name="endtime" value="{$get['endtime']}" readonly="readonly" />
							<i class="js_delTimeStr"></i>
						</div>
        			</div>
	            	<div class="serach_but">
						<input class="butinput cursorpointer" type="button" value="">
	            	</div>
				</div>
			</div>
			<div class="appadmin_pagingcolumn">
	            <!-- 翻页效果引入 -->
	            <include file="@Layout/pagemain" />
	        </div>
	        <!--订单列表-->
	        <div class="scanner_gdtiao">
		        <div class="scanner_lia_maxwidth">
		            <div class="orderlist_list_name">
		                <span class="span_span11"></span>
		                <span class="span_span1">{$T->str_order_service_no}</span>
		                <span class="span_span2 js_user_service_time_sort hand" order='create_time'><u>{$T->str_order_service_created_time}</u>
		                     <if condition="$get['order'] eq 'create_time'">
		                	    <if condition="$get['ordertype'] eq 'desc'">
		                    	   <em class="list_sort_desc" type="desc"></em>
		                    	<elseif condition="$get['ordertype'] eq 'asc'"/>
		                    	   <em class="list_sort_asc" type="asc"></em>
		                    	<else/>
		                    	   <em class="list_sort_none" type=""></em>
		                    	</if>
		                	<else/>
		                	   <em class="list_sort_none" type=""></em>
		                	</if>
		                </span>
		                <span class="span_span3">{$T->str_order_service_status}</span>
		                <span class="span_span3">{$T->str_order_service_pay_type}</span>
		                <span class="span_span4">{$T->str_order_service_member_length}({$T->str_order_service_member_length_unit})</span>
		                <span class="span_span5">{$T->str_order_service_amount}</span>
		                <span class="span_span7">{$T->str_order_service_user_id}</span>
		                <span class="span_span8">{$T->str_order_service_user_name}</span>
		                <span class="span_span9">{$T->str_order_service_operation}</span>
		            </div>
		            <foreach name="list" item="val">
		            <div class="orderlist_list_c list_hover js_x_scroll_backcolor">
		                <span class="span_span11"></span>
                        <span class="span_span1">{$val.orderid}</span>
                        <span class="span_span2">{$val.create_time}</span>
                        <span class="span_span3">{$val.status}</span>
                        <span class="span_span3">{$val.payment}</span>
		                <span class="span_span4">{$val.member}</span>
		                <span class="span_span5">{$val.price}</span>
		                <span class="span_span7">{$val.mobile}</span>
		                <span class="span_span8">{$val.username}</span>
		                <span class="span_span9 hand"><a href="{:U('Appadmin/OrderManage/userOrderDetail')}?id={$val.id}">{$T->str_order_service_detail}</a></span>
                    </div>
                    </foreach>
		        </div>
		    </div>
		    <div class="appadmin_pagingcolumn">
				<!--翻页效果引入-->
	            <include file="@Layout/pagemain" />
		    </div>
		</div>
	</div>
</div>
<script type='text/javascript'>
var URL_LIST="{:U('Appadmin/OrderManage/userOrderList')}";
$(function(){
	$.userOrderList.init();
	var status="{$get.orderStatus}"; //订单状态
	var searchType="{$get.searchType}";//搜索类型
    
	if (status){
		$('#js_select_content1 li[val="'+status+'"]').click();
	}
	if (searchType){
		$('#js_select_content2 li[val="'+searchType+'"]').click();
	}
});
</script>
