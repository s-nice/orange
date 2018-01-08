<layout name="../Layout/Layout" />
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<!--头部搜索-->
			<div class="content_search">
            	<div class="search_right_c">
            		<div class="orderlist_input">
            			<span>订单号</span>
            			<input type="text" class="js_search_params"  name="orderNum"
						<if condition="isset($_GET['orderNum'])"> value="{$_GET['orderNum']}"</if> />
            		</div>
        	    	<div class="select_Itwo">
            	    	<span>订单状态</span>
            	    	<div class="select_sketchtwo menu_list">
	            			<input class="js_select_title js_search_params"  name="status" type="text" readonly="readonly"
							<if condition="isset($_GET['status'])"> value="{$_GET['status']}" <else/>   value="全部" </if> />
	            			<i class="js_select_item"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	            			<ul class="js_select_content">
	            			    <li class="on">全部</li>
	            			    <li>已付款</li>
	            			    <li>卖家待确认</li>
	            			</ul>
            			</div>
            		</div>
            		<div class="select_sketchtwo menu_list">
            			<input class="js_select_title js_search_params" type="text"  readonly="readonly" name="keywordType"
						<if condition="isset($_GET['keywordType'])"> value="{$_GET['keywordType']}" <else/>  value="购买ID" </if>/>
            			<i class="js_select_item"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            			<ul class="js_select_content">
            				<li class="on">购买ID</li>
            				<li>购买名称</li>
            			</ul>
            		</div>
            	    <div class="search_new_w">
            			<input type="text" class="js_search_params" name="keyword"
						<if condition="isset($_GET['keyword'])"> value="{$_GET['keyword']}" </if>
						/>
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
							<input id="js_endtime" class="time_input js_search_params" type="text" name="endtime" readonly="readonly"
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
		            <div class="orderlist_list_name">
		                <span class="span_span11"></span>
		                <span class="span_span1">订单号</span>
		                <span class="span_span2"><u>交易时间</u><em
						<if condition="isset($_GET['sort']) && $_GET['sort'] eq 'asc' "> class="list_sort_asc js_sort" <else/>
							class="list_sort_desc js_sort" </if>></em></span>
		                <span class="span_span3">订单状态</span>
		                <span class="span_span3">付款状态</span>
		                <span class="span_span4">订单金额</span>
		                <span class="span_span5">出售ID</span>
		                <span class="span_span5">出售名称</span>
		                <span class="span_span7">购买ID</span>
		                <span class="span_span8">购买名称</span>
		                <span class="span_span9">操作</span>
		            </div>
		            <div class="orderlist_list_c checked_style">
		                <span class="span_span11"></span>
                        <span class="span_span1">DD13527680921</span>
                        <span class="span_span2">2016-08-22 10:33:46</span>
                        <span class="span_span3">已付款</span>
                        <span class="span_span3">已付款</span>
		                <span class="span_span4">100</span>
		                <span class="span_span5">13527680921</span>
		                <span class="span_span5">橙子</span>
		                <span class="span_span7">16527680924</span>
		                <span class="span_span8">叶子</span>
						<a href="{:U('Appadmin/OrderManage/consumeOrderDetail',array('id'=>1),'','',true)}">
		                    <span class="span_span9 hand">订单详情</span>
							</a>
                    </div>
		        </div>
		    </div>
		    <div class="appadmin_pagingcolumn">
				<!--翻页效果引入-->
		    </div>
		</div>
	</div>
</div>
<script>
	var gUrl="{:U('Appadmin/OrderManage/companyConsumeList','','html','',true)}";
	$(function(){
		$.consumeList.init();
	})
</script>
