<layout name="../Layout/Layout" />
<div class="content_global">
 	<div class="content_hieght">
        <div class="content_c">
			<div class="content_search">
            	<div class="search_right_c">
            	 <form name="searchForm" action="{:U('OrderManage/index','','',true)}" method="get">
                	<input type="hidden" name="search" value="search"/>
            		<input type="hidden" name="ordertype" value="{$order}" />
            		<div class="orderlist_input">
            			<span>订单号</span>
            			<input name="orderId" type="text" value="{$params['orderId']}" />
            		</div>
            	    <div class="select_Itwo">
            	    	<span>订单状态</span>
            	    	<div class="js_select_div select_sketchtwo menu_list">
	            			<input class="js_select_title" type="text" name="title" value="{$params['title']}" readonly="readonly" />
	            			<input type="hidden" name="status" value="{$params['status']}" />
	            			<i class="js_select_item"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	            			<ul class="js_select_content">
	            			    <foreach name="orderStatusSelect" item="name" key="k">
	            			         <li val="{$k}" title="{$name}" <if condition="$params['status'] == $k">class="on"</if> >{$name}</li>
	            			    </foreach>
	            			</ul>
            			</div>
            		</div>
            		<div class="js_select_div select_sketchtwo menu_list">
            			<input class="js_select_title" type="text" name="keywordTitle" value="{$params['keywordTitle']}" readonly="readonly" />
            			<input type="hidden" name="keywordKey" value="{$params['keywordKey']}" />
            			<i class="js_select_item"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            			<ul class="js_select_content">
            				<li val="id" title="购买ID" <if condition="$params['keywordKey'] == 'id'">class="on"</if> >购买ID</li>
            				<li val="name" title="购买名称" <if condition="$params['keywordKey'] == 'name'">class="on"</if> >购买名称</li>
            			</ul>
            		</div>
            	    <div id="select_province" class="select_gmid">
            			<input type="text" name="keywordInfo" value="{$params['keywordInfo']}" />
            		</div>
            		<div class="select_time_c">
            			<span>{$T->str_time}</span>
						<div class="time_c">
							<input id="js_begintime" class="time_input" type="text" name="starttime" value="{$params['starttime']}" readonly="readonly" />
							<i class="js_delTimeStr"></i>
						</div>
						<span>-</span>
						<div class="time_c">
							<input id="js_endtime" class="time_input" type="text" name="endtime" value="{$params['endtime']}" readonly="readonly" />
							<i class="js_delTimeStr"></i>
						</div>
        			</div>
	            	<input class="submit_button" type="submit" value="{$T->str_submit}"/>
	            	</form>
				</div>
			</div>
			<div class="appadmin_pagingcolumn">
	            <!-- 翻页效果引入 -->
	            <include file="@Layout/pagemain" />
	        </div>
			<div class="scanner_gdtiao">
		        <div class="scanner_list_maxwidth">
		            <div class="orderlist_list_name">
		                <span class="span_span11"></span>
		                <span class="span_span1">订单号</span>
		                <span class="span_span2"><u>交易时间</u><em data="{$order}" class="js_orderby_class list_sort_{$order}"></em></span>
		                <span class="span_span3">订单状态</span>
		                <span class="span_span4">付款状态</span>
		                <span class="span_span5">出售ID</span>
		                <span class="span_span6">出售名称</span>
		                <span class="span_span7">购买ID</span>
		                <span class="span_span8">购买名称</span>
		                <span class="span_span9">操作</span>
		            </div>
		            <if condition="count($orderlist) gt 0">
		            <foreach name="orderlist" item="order">
		            <div class="js_orderlist list_hover orderlist_list_c js_x_scroll_backcolor">
		                <span class="span_span11"></span>
                        <span class="span_span1">{$order['order_id']}</span>
                        <span class="span_span2">{$order['create_time']|date="Y-m-d H:i:s",###+$timezone}</span>
                        <span class="js_statusshow span_span3">{$status[$order['status']]}</span>
		                <span class="span_span4">{$paystatus[$order['paystatus']]}</span>
		                <span class="span_span5">{$order['to_user_account']}</span>
		                <span class="span_span6">{$order['to_user_name']}</span>
		                <span class="span_span7">{$order['user_account']}</span>
		                <span class="span_span8">{$order['user_name']}</span>
		                <span class="span_span9 hand">
		                	<a href="{:U('OrderManage/showOrder',array('orderid'=>$order['order_id']),'',true)}">订单详情</a>
		                	<if condition="($order['is_abnormal'] eq '0' && $order['status'] eq '9' && $order['confirm_type'] eq '1' ) || ($order['is_abnormal'] eq '0' && $order['status'] eq '7')">
		                	<em class="js_frozen_order" data="{$order['order_id']}">|申诉冻结</em>
		                	</if>
		                </span>
                    </div>
                    </foreach>
                    <else />
                    No Data
                    </if>
		        </div>
		    </div>
		    <div class="appadmin_pagingcolumn">
			   <!-- 翻页效果引入 -->
			   <include file="@Layout/pagemain" />
			</div>
		</div>
	</div>
</div>
<script>
var frozenOrderUrl = "{: U('OrderManage/frozenOrder','','',true)}";
$(function(){
	$.orderManage.init();
	$.orderManage.frozenOrder();
});
</script>