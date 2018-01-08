<layout name="../Layout/Layout" />
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<!--头部搜索-->
			<div class="content_search">
            	<div class="search_right_c">
            		<div class="orderlist_input">
            			<span>订单号</span>
            			<input type="text" class="search js_search_params" id="js_orderNum" name="orderNum"
						<if condition="isset($_GET['orderNum'])"> value="{$_GET['orderNum']}"</if>/>
            		</div>
        	    	<div class="select_sketchtwo menu_list">
            			<input class="js_select_title js_search_params"  name="keyWordType" type="text"  readonly="readonly"
						<if condition="isset($_GET['keyWordType'])"> value="{:urldecode($_GET['keyWordType'])}" <else/>  value="企业ID" </if>/>
            			<i class="js_select_item"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            			<ul class="js_select_content">
            			    <li class="on">企业ID</li>
            			    <li>企业名称</li>
            			</ul>
        			</div>
            	    <div class="search_new_w">
            			<input type="text" class="js_search_params" name="keyword"
						<if condition="isset($_GET['keyword'])"> value="{:urldecode($_GET['keyword'])}" </if>/>
            		</div>
            		<div class="select_time_c">
            			<span>{$T->str_time}</span>
						<div class="time_c">
							<input id="js_begintime" class="time_input js_search_params" type="text" name="starttime"  readonly="readonly"
							<if condition="isset($_GET['starttime'])"> value="{$_GET['starttime']}" </if>/>
							<i class="js_delTimeStr"></i>
						</div>
						<span>-</span>
						<div class="time_c">
							<input id="js_endtime" class="time_input js_search_params" type="text" name="endtime"  readonly="readonly"
							<if condition="isset($_GET['endtime'])"> value="{$_GET['endtime']}" </if>/>
							<i class="js_delTimeStr"></i>
						</div>
        			</div>
	            	<div class="serach_but">
						<input class="butinput cursorpointer js_search" type="button" value="">
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
		            <div class="orderlist_list_name exchange_list">
		                <span class="span_span11"></span>
		                <span class="span_span1">订单号</span>
		                <span class="span_span2"><u>生成时间</u><em
								<if condition="isset($_GET['sort']) && $_GET['sort'] eq 'asc' "> class="list_sort_asc js_sort" <else/>
									class="list_sort_desc js_sort" </if>>
							</em></span>
		                <span class="span_span3">订单状态</span>
		                <span class="span_span3">支付方式</span>
		                <span class="span_span4">支付流水号</span>
		                <span class="span_span5">订单金额</span>
		               <!-- <span class="span_span5">可消费金额</span>-->
		                <span class="span_span7">企业ID</span>
		                <span class="span_span8">企业名称</span>
		              <!--  <span class="span_span9">操作</span>-->
		            </div>
					<if condition="$result['numfound'] neq 0">
						<volist name="result['list']" id="list">
							<div class="orderlist_list_c list_hover js_x_scroll_backcolor exchange_list">
								<span class="span_span11"></span>
								<span class="span_span1">{$list.order_id}</span>
								<span class="span_span2">{:date('Y-m-d h:i:s',$list['createtime'])}</span>
								<span class="span_span3">
									<php>
										//订单状态 -2:支付完成删除 -1:已删除  0:已取消订单  1：未支付 2：已支付 3:支付失败
										switch($list['status']){
										    case -2:
										        echo '支付完成删除';
										        break;
										    case -1:
										        echo ':已删除';
										        break;
										    case 0:
										        echo '已取消订单';
										        break;
										    case 1:
										        echo '未支付';
										        break;
									      	case 2:
										        echo '已支付';
										        break;
									      	case 3:
										        echo '支付失败';
										    break;
										    default:
										        echo '--';
										}
									</php>
								</span>
								<span class="span_span3">快钱</span>
								<span class="span_span4">{$list.trade_no}</span>
								<span class="span_span5">{$list.price}</span>
							<!--	<span class="span_span5">暂未定义</span>-->
								<span class="span_span7">{$list.biz_email}</span>
								<span class="span_span8">{$list.biz_name}</span>
								<!--<span class="span_span9 hand">消费详情</span>-->
								</div>
						</volist>
						<else/>
							NO DATA
					</if>

		        <!--    <div class="orderlist_list_c list_hover js_x_scroll_backcolor">
		                <span class="span_span11"></span>
                        <span class="span_span1">DD13527680921</span>
                        <span class="span_span2">2016-08-22 10:33:46</span>
                        <span class="span_span3">已支付</span>
                        <span class="span_span3">快钱</span>
		                <span class="span_span4">1028938120831212</span>
		                <span class="span_span5">1000</span>
		                <span class="span_span5">2000</span>
		                <span class="span_span7">yezi@oradt.com</span>
		                <span class="span_span8">ORA</span>
		                <span class="span_span9 hand">消费详情</span>
                    </div>-->
		        </div>
		    </div>
		    <div class="appadmin_pagingcolumn">
				<!--翻页效果引入-->
				<include file="@Layout/pagemain" />
		    </div>
		</div>
	</div>
</div>
<script>
	var gUrl="{:U('Appadmin/OrderManage/companyPayList','','html','',true)}";
	$(function(){
		$.payList.init();
	})
</script>