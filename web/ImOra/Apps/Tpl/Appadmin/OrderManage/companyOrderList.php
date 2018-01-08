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
            			<input id='order_id' type="text" value="{$get.order_id}" autocomplete='off'/>
            		</div>
            	    <div class="select_Itwo">
            	    	<span>{$T->str_order_service_status}</span>
            	    	<div class="select_sketchtwo menu_list">
	            			<input autocomplete='off' id='orderStatus' class="js_select_title" type="text" value="{$T->str_order_service_all}" readonly="readonly"/>
	            			<i class="js_select_item"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	            			<ul id='js_select_content1' class="js_select_content">
	            			    <li val='' class='on'>{$T->str_order_service_all}</li>
	            			    <li val='1'>{$T->str_order_service_for_pay}</li>
	            			    <li val='2'>{$T->str_order_service_payed}</li>
	            			</ul>
            			</div>
            		</div>
            		<div class="select_sketchtwo menu_list">
            			<input id='searchType' class="js_select_title" type="text" value="{$T->str_order_service_company_id}" readonly="readonly" autocomplete='off' val='company_id'/>
            			<i class="js_select_item"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            			<ul id='js_select_content2' class="js_select_content">
            				<li class='on' val='company_id'>{$T->str_order_service_company_id}</li>
            				<li val='company_name'>{$T->str_order_service_company_name}</li>
            			</ul>
            		</div>
            	    <div class="search_new_w">
            			<input id='keyword' type="text" value="{$get.keyword}" autocomplete='off'/>
            		</div>
            		<div class="select_time_c">
            			<span>{$T->str_time}</span>
						<div class="time_c">
							<input id="js_begintime" class="time_input" type="text" name="starttime" value="{$get.starttime}" readonly="readonly" autocomplete='off'/>
							<i class="js_delTimeStr"></i>
						</div>
						<span>-</span>
						<div class="time_c">
							<input id="js_endtime" class="time_input" type="text" name="endtime" value="{$get.endtime}" readonly="readonly" autocomplete='off'/>
							<i class="js_delTimeStr"></i>
						</div>
        			</div>
	            	<div class="serach_but">
						<input class="butinput cursorpointer" type="button" value="">
	            	</div>
				</div>
			</div>
			<div class="appadmin_pagingcolumn">
				<div class="js_search_moreitem_div" style="display: block;">
					<div class="select_Itwo">
	            	    <span>{$T->str_order_service_stype}</span>
	            	    <div class="select_sketchtwo menu_list">
		            		<input id='serviceType' class="js_select_title" type="text" value="{$T->str_order_service_all}" readonly="readonly" autocomplete='off'/>
		            		<i class="js_select_item"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
		            		<ul id='js_select_content3' class="js_select_content">
		            		    <li val='' class='on'>{$T->str_order_service_all}</li>
		            		    <li val='length'>{$T->str_order_service_length}</li>
		            		    <li val='authorize'>{$T->str_order_service_authorization}</li>
		            		    <li val='storage'>{$T->str_order_service_stock}</li>
		            		</ul>
	            		</div>
	            	</div>
	            </div>
	            <!-- 翻页效果引入 -->
	            <include file="@Layout/pagemain" />
	        </div>
	        <!--订单列表-->
	        <div class="scanner_gdtiao">
		        <div class="">
		            <div class="orderlist_list_name order_list_w">
		                <span class="span_span11"></span>
		                <span class="span_span1">{$T->str_order_service_no}</span>
		                <span class="span_span2 js_ent_service_time_sort hand" order='create_time'><u>{$T->str_order_service_created_time}</u>
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
		                <span class="span_span4">{$T->str_order_service_length}</span>
		                <span class="span_span5">{$T->str_order_service_authorization}</span>
		                <span class="span_span5">{$T->str_order_service_stock}</span>
		                <span class="span_span5">{$T->str_order_service_amount}</span>
		                <span class="span_span7">{$T->str_order_service_company_id}</span>
		                <span class="span_span8">{$T->str_order_service_company_name}</span>
		                <span class="span_span9">{$T->str_order_service_operation}</span>
		            </div>
		            <if condition="sizeof($list)">
		            <foreach name="list" item="val">
		            <div class="orderlist_list_c order_list_w list_hover js_x_scroll_backcolor">
		                <span class="span_span11"></span>
                        <span class="span_span1">{$val.order_id}</span>
                        <span class="span_span2">{$val.create_time}</span>
                        <span class="span_span3">{$val.status}</span>
                        <span class="span_span3">{$val.pay}</span>
		                <span class="span_span4">{$val.length}{$T->str_order_service_year}</span>
		                <span class="span_span5">{$val.authorize_num}{$T->str_order_service_unit1}</span>
		                <span class="span_span5">{$val.storage_num}{$T->str_order_service_unit2}</span>
		                <span class="span_span5">{$val.price}</span>
		                <span class="span_span7">{$val.biz_email}</span>
		                <span class="span_span8">{$val.biz_name}</span>
		                <span class="span_span9 hand"><a href="{:U('Appadmin/OrderManage/companyOrderDetail')}?id={$val.id}">{$T->str_order_service_detail}</a></span>
                    </div>
		            </foreach>
		        	<else />
					nodata
		        	</if>
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
var URL_LIST="{:U('Appadmin/OrderManage/companyOrderList')}";
$(function(){
	$.companyOrderList.init();
	var status="{$get.orderStatus}";
	var searchType="{$get.searchType}";
	var stype="{$get.serviceType}";
    
	if (status){
		$('#js_select_content1 li[val="'+status+'"]').click();
	}
	if (searchType){
		$('#js_select_content2 li[val="'+searchType+'"]').click();
	}
	if (stype){
		$('#js_select_content3 li[val="'+stype+'"]').click();
	}
});
</script>
