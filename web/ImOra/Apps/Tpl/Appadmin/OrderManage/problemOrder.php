<layout name="../Layout/Layout" />
<script>
var visitIndex = 0;
var orderIdArr = {};
var visitArr = [];
</script>
<div class="content_global">
 	<div class="content_hieght">
        <div class="content_c">
			<div class="content_search">
            	<div class="search_right_c">
            	 <form name="searchForm" action="{:U('OrderManage/problemOrder','','',true)}" method="get">
                	<input type="hidden" name="search" value="search" />
            	    <input type="hidden" name="ordertype" value="{$order}" />
<!--             	    <div class="select_Itwo"> -->
<!--                 	<span>订单状态</span> -->
<!--             	    	<div class="js_select_div select_sketchtwo"> -->
<!-- 	            			<input class="js_select_title" type="text" name="title" value="{$params['title']}" readonly="readonly" /> -->
<!-- 	            			<input type="hidden" name="status" value="{$params['status']}" /> -->
<!-- 	            			<i class="js_select_item"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i> -->
<!-- 	            			<ul class="js_select_content"> -->
<!-- 	            			    <foreach name="status" item="name" key="k"> -->
<!-- 	            			         <li val="{$k}" title="{$name}" <if condition="$params['status'] == $k">class="on"</if> >{$name}</li> -->
<!-- 	            			    </foreach> -->
<!-- 	            			</ul> -->
<!--             			</div> -->
<!--             		</div> -->
            		<div class="js_select_div select_sketchtwo menu_list">
            			<input class="js_select_title" type="text" name="keywordTitle" value="{$params['keywordTitle']}" readonly="readonly" />
            			<input type="hidden" name="keywordKey" value="{$params['keywordKey']}" />
            			<i class="js_select_item"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            			<ul class="js_select_content">
            				<li val="name" title="订单号" <if condition="$params['keywordKey'] == 'corderId'">class="on"</if> >订单号</li>
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
		        <div class="scanner_prolem_maxwidth">
		            <div class="orderlist_list_name">
		                <span class="span_span11"></span>
		                <span class="span_span1">订单号</span>
		                <span class="span_span2"><u>交易时间</u><em data="{$order}" class="js_orderby_class list_sort_{$order}"></em></span>
		                <span class="span_span3">订单状态</span>
<!-- 		                <span class="span_span4">付款状态</span> -->
		                <span class="span_span5">出售ID</span>
		                <span class="span_span6">出售名称</span>    
		                <span class="span_span7">购买ID</span>
		                <span class="span_span8">购买名称</span>
		                <span class="span_span9">操作</span>
		            </div>
		            <if condition="count($orderlist) gt 0">
		            <php>$k = 0;$visitArr = array();</php>
		            <foreach name="orderlist" item="order">
		            <div class="orderlist_list_c js_x_scroll_backcolor list_hover">
		                <span class="span_span11"></span>
                        <span class="span_span1">{$order['order_id']}</span>
                        <span class="span_span2">{$order['create_time']|date="Y-m-d H:i:s",###+$timezone}</span>
                        <span class="span_span3">{$status[$order['status']]}</span>
<!-- 		                <span class="span_span4">{$paystatus[$order['paystatus']]}</span> -->
		                <span class="span_span5">{$order['to_user_account']}</span>
		                <span class="span_span6">{$order['to_user_name']}</span>
		                <span class="span_span7">{$order['user_account']}</span>
		                <span class="span_span8">{$order['user_name']}</span>
		                <if condition="$order['is_visit'] eq 1">
		                	<php>$visitArr[$k] = array(
		                	'id'=>$order['order_id'],
		                	'remark'=>json_decode(str_replace(array('\r\n',' '),array('<br>','&nbsp;'),json_encode($order['remark']))),
		                	'time'=>$order['visit_time']);</php>
		                	<script>
		                		orderIdArr["{$order['order_id']}"] = {$k};
			                </script>
		                <span class="js_showvisit_act span_span9 hand" data="{$order['order_id']}">查看回访</span>
		                <else />
		                	<php>$visitArr[$k] = array();</php>
		                	<script>
		                		orderIdArr["{$order['order_id']}"] = {$k};
			                </script>
		                <span class="js_addvisit_act span_span9 hand" data="{$order['order_id']}">回访</span>
		                </if>
                    </div>
                   	<php>$k++;</php>
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

<div class="js_addVisit_page problem_pop" style="display:none;">
	<div class="js_addVisit_close problem_close hand"><img src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
	<div class="problem_title">回访记录</div>
	<form name="addVisitForm" action="{:U('OrderManage/addVisit','','',true)}" method="post" target="hidden_form">
	<input type="hidden" name="orderId" id="js_orderid" value="" />
	<div class="problem_content">
		<div class="problem_password"><span>订单号：</span><p class="js_orderid">DD13527680921</p></div>
		<div class="problem_text">
			<span>回访记录：</span>
			<textarea name="remark" rows="" cols=""></textarea>
		</div>
		<div class="problem_bin" style="margin-top:20px;">
			<input class="js_addVist_submit problem_r button_disabel hand" type="button" value="确认" />
			<input class="js_addVisit_close problem_l hand" type="button" value="取消" />
		</div>  
	</div>
	</form>
</div>
<iframe name="hidden_form" frameborder="0" height="0" width="0"></iframe>

<div class="js_showvisit_page problem_poptwo" style="display:none;">
	<div class="js_showVisit_close problem_close hand"><img src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
	<div class="problem_title">回访记录</div>
	<div class="problem_content">
		<div class="problem_poplist">
			<div class="problem_tow"><span>订单号：</span><p id="js_orderid_show"></p></div>
			<div class="problem_tow"><span>回访记录：</span><p id="js_remark_show"></p></div>
		</div>
		<div class="problem_bin">
			<input class="js_prev problem_r hand" type="button" value="上一个" />
			<input class="js_next problem_l hand" type="button" value="下一个" />
		</div>  
	</div>
</div>
<script>
$(function(){
	visitArr = {: json_encode($visitArr)};
	// 增加滚动条
    $("#js_remark_show").mCustomScrollbar({
//   		set_width:'460px',
  		set_height:'295px',
  		callbacks:{ 
  			onTotalScroll:function(){
  			}
  	    },
  	 	horizontalScroll:false  // 是否创建水平滚动条
   });
	$.orderManage.init();
	$.orderManage.problemPage();
});
</script>