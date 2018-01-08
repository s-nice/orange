<layout name="../Layout/Layout" />
<script>
var orderIdArr = [];
</script>
<div class="content_global">
 	<div class="content_hieght">
        <div class="content_c">
			<div class="content_search">
            	<div class="search_right_c">
            	 <form name="searchForm" action="{:U('OrderManage/liabilityList','','',true)}" method="get">
                	<input type="hidden" name="search" value="search"/>
            		<input type="hidden" name="ordertype" value="{$order}" />
            		<div class="orderlist_input">
            			<span>订单号</span>
            			<input type="text" name="orderId" value="{$params['orderId']}" />
            		</div>
            	    <div class="select_Itwo">
            	    	<span>订单状态</span>
            	    	<div class="js_select_div select_sketchtwo menu_list">
	            			<input class="js_select_title" type="text" name="title" value="{$params['title']}" readonly="readonly"/>
	            			<input type="hidden" name="status" value="{$params['status']}" />
	            			<i class="js_select_item"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	            			<ul class="js_select_content">
	            			    <foreach name="statusSelect" item="name" key="k">
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
        			<!-- <span class="js_search_moreitem" style="cursor: pointer;">...</span> -->
	            	<input class="submit_button" type="submit" value="{$T->str_submit}"/>
				</div>
			</div>
			<div class="appadmin_pagingcolumn">
			<div class="js_search_moreitem_div" style="display: block;">
				<div class="select_Itwo">
            	    <span>受理状态</span>
            	    <div class="js_select_div select_sketchtwo menu_list">
	            		<input class="js_select_title" type="text" name="statusActTitle" value="{$params['statusActTitle']}" readonly="readonly" />
	            		<input type="hidden" name="statusAct" value="{$params['statusAct']}" />
	            		<i class="js_select_item"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	            		<ul class="js_select_content">
	            		    <foreach name="statusActSelect" item="name" key="k">
	            			    <li val="{$k}" title="{$name}" <if condition="$params['statusAct'] == $k">class="on"</if> >{$name}</li>
	            			</foreach>
	            		</ul>
            		</div>
            	</div>
            </div>
            	</form>
	            <!-- 翻页效果引入 -->
	            <include file="@Layout/pagemain" />
	        </div>
			<div class="scanner_gdtiao">
		        <div class="scanner_lia_maxwidth">
		            <div class="orderlist_list_name">
		                <span class="span_span11"></span>
		                <span class="span_span1">订单号</span>
		                <span class="span_span2">
		                	<u>申诉时间</u><em data="{$order}" class="js_orderby_class list_sort_{$order}"></em>
		                </span>
		                <span class="span_span3">订单状态</span>
		                <span class="span_span3">受理状态</span>
		                <span class="span_span4">出售ID</span>
		                <span class="span_span5">出售名称</span>
		                <span class="span_span5">购买ID</span>
		                <span class="span_span7">购买名称</span>
		                <span class="span_span8">责任人</span>
		                <span class="span_span9">操作</span>
		            </div>
		            <php>$orderIdArr = array();</php>
		            <if condition="count($orderlist) gt 0">
		            <foreach name="orderlist" item="order">
		            <php>$orderIdArr[$order['order_id']] = 
		            	array('buyer'=>$order['buyer'],
		            		'saler'=>$order['saler'],
		            		'customer'=>$order['customer'],
		            		'liable'=>$order['person_liable'],
		            		'liableshow'=>$liable[$order['person_liable']]
		            	);
		            </php>
		            <div class="orderlist_list_c js_x_scroll_backcolor list_hover">
		                <span class="span_span11"></span>
                        <span class="span_span1">{$order['order_id']}</span>
                        <span class="span_span2">{$order['time']|date="Y-m-d H:i:s",###+$timezone}</span>
                        <span class="span_span3">{$status[$order['status']]}</span>
                        <span class="span_span3">
                        <if condition="$order['status'] eq '8'">
		                	未处理
		                <else />
		                	已处理
		                </if>
                        </span>
		                <span class="span_span4">{$order['to_user_account']}</span>
		                <span class="span_span5">{$order['to_user_name']}</span>
		                <span class="span_span5">{$order['user_account']}</span>
		                <span class="span_span7">{$order['user_name']}</span>
		                <span class="span_span8">{$liable[$order['person_liable']]}</span>
		                <if condition="$order['status'] eq '8'">
		                	<span class="js_liability_act span_span9 hand" data="{$order['order_id']}">定责</span>
		                <else />
		                	<span class="js_liability_show span_span9 hand" data="{$order['order_id']}">定责详情</span>
		                	<php>
			                	$orderIdArr[$order['order_id']]['buyer'] = json_decode(str_replace(array('\r\n',' '),array('<br>','&nbsp;'),json_encode($orderIdArr[$order['order_id']]['buyer']))); 
			            		$orderIdArr[$order['order_id']]['saler'] = json_decode(str_replace(array('\r\n',' '),array('<br>','&nbsp;'),json_encode($orderIdArr[$order['order_id']]['saler']))); 
			            		$orderIdArr[$order['order_id']]['customer'] = json_decode(str_replace(array('\r\n',' '),array('<br>','&nbsp;'),json_encode($orderIdArr[$order['order_id']]['customer'])));
		            		</php> 
		                </if>
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

<div class="js_problem_dingz problem_dingz" style="display:none;">
	<div class="js_liability_close problem_close hand"><img src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
	<div class="problem_title">定责</div>
	<form name="liabilityForm" action="{:U('OrderManage/liabilityAct','','',true)}" method="post" target="hidden_form">
	<input type="hidden" name="orderId" id="js_orderid" value="" />
	<input type="hidden" name="status" id="js_status" value="" />
	<div class="problem_content">
		<div class="problem_password"><span>订单号：</span><p class="js_orderid">DD13527680921</p></div>
		<div class="problem_text_dz">
			<span>购买方描述：</span>
			<textarea name="buyer" rows="" cols=""></textarea>
		</div>
		<div class="problem_text_dz">
			<span>出售方描述：</span>
			<textarea name="saler" rows="" cols=""></textarea>
		</div>
		<div class="problem_text_dz">
			<span>客服描述：</span>
			<textarea name="customer" rows="" cols=""></textarea>
		</div>
		<div class="problem_text_se">
			<span class="biaoti">责任判定：</span>
			<div class="problem_check">
				<span>
					<input type="radio" name="liable" value="2" />
					<i>出售方</i>
				</span>
				<span>
					<input type="radio" name="liable" value="3" />
					<i>购买方</i>
				</span>
			</div>
		</div>
		<div class="problem_bin">
			<input id="js_liability_save" style="margin-right:10px;" data="2" class="big_button" type="button" value="确认定责" />
			<input data="1" class="js_liability_save big_button" type="button" value="暂存" />
			<input class="js_liability_close big_button" style="margin-left:10px;" type="button" value="取消" />
		</div>
	</div>
	</form>
</div>
<iframe name="hidden_form" frameborder="0" height="0" width="0"></iframe>


<div class="js_problem_detail problem_detail" style="display:none;">
	<div class="js_liability_show_close problem_close hand"><img src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
	<div class="problem_title">定责详情</div>
	<div class="problem_content">
		<div class="problem_text_dztail"><span>订单号：</span><p id="js_orderid_show">DD13527680921</p></div>
		<div class="problem_text_dzdetail">
			<span>购买方描述：</span>
			<p id="js_buyer_show">假数据！联系不到！</p>
		</div>
		<div class="problem_text_dzdetail">
			<span>出售方描述：</span>
			<p id="js_saler_show">正常进行过联系，名片持有人拒绝与购买方成为好友关系，购买方不愿意支付</p>
			
		</div>
		<div class="problem_text_dzdetail">
			<span>客服描述：</span>
			<p id="js_customer_show">经核实买方描述属实</p>
		</div>
		<div class="problem_text_dzdetail">
			<span class="biaoti">责任判定：</span>
			<p id="js_liable_show">出售方</p>
		</div>
		<div class="problem_bin">
			<input class="js_liability_show_close problem_numone big_button" type="button" value="关闭" />
		</div>
	</div>
</div>

<script>
$(function(){
	// 增加滚动条
    $("#js_buyer_show,#js_saler_show,#js_customer_show").mCustomScrollbar({
//   		set_width:'460px',
  		set_height:'115px',
  		callbacks:{ 
  			onTotalScroll:function(){
  			}
  	    },
  	 	horizontalScroll:false  // 是否创建水平滚动条
   });
	orderIdArr = {: json_encode($orderIdArr)};
	$.orderManage.init();
	$.orderManage.liabilityPage();
});
</script>