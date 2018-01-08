<layout name="../Layout/Layout" />

<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<!--头部搜索-->
			<div class="content_search">
            	<div class="search_right_c">
            		<div class="orderlist_input">
            			<span>订单号</span>
            			<input type="text" class="search js_search_params"  name="orderNum"
						<if condition="isset($_GET['orderNum'])"> value="{$_GET['orderNum']}"</if>/>
            		</div>
        	    	<div class="select_Itwo">
            	    	<span>订单状态</span>
            	    	<div class="select_sketchtwo menu_list">
	            			<input class="js_select_title js_search_params" type="text" name="status" readonly="readonly"
							<if condition="isset($_GET['status'])"> value="{:urldecode($_GET['status'])}" <else/>   value="全部" </if> />
	            			<i class="js_select_item"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
	            			<ul class="js_select_content">
	            			    <li class="on">全部</li>
	            			    <li>待邮寄</li>
								<li>处理中</li>
								<li>已完成</li>
								<li>已取消</li>
	            			</ul>
            			</div>
            		</div>
            		<div class="select_sketchtwo menu_list">
            			<input class="js_select_title js_search_params"  name="keywordType" type="text"  readonly="readonly"
						<if condition="isset($_GET['keywordType'])"> value="{:urldecode($_GET['keywordType'])}" <else/>   value="用户ID" </if>/>
            			<i class="js_select_item"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
            			<ul class="js_select_content">
            				<li class="on">用户ID</li>
            				<li>用户名称</li>
            			</ul>
            		</div>
            	    <div class="search_new_w">
            			<input type="text" class="js_search_params" name="keyword"
						<if condition="isset($_GET['keyword'])"> value="{:urldecode($_GET['keyword'])}" </if> />
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
	            	<div class="serach_but js_search">
						<input class="butinput cursorpointer" type="button" value="">
	            	</div>
				</div>
			</div>
			<div class="page_box">
	            <!-- 翻页效果引入 -->
	            <include file="@Layout/pagemain" />
	        </div>
	        <!--订单列表-->
	        <div>
		        <div>
		            <div class="post_list_h warning_title_h js_list_name_title">
		                <span class="span_span11"></span>
		                <span class="span_span1">订单号</span>
		                <span class="span_span1"><u class="js_sort hand">生成时间</u><em
								<if condition="isset($_GET['sort']) && $_GET['sort'] eq 'asc' "> class="list_sort_asc js_sort" <else/>
									class="list_sort_desc js_sort" </if>>
							</em></span>
		                <span class="span_span1">订单状态</span>
		                <span class="span_span1">用户ID</span>
		               <!-- <span class="span_span2">用户名称</span>-->
		                <span class="span_span6">操作</span>
		            </div>
					<if condition="$result['numfound'] neq 0">
						<volist name="result['list']" id="list">
							<div class="post_list_h warning_list_h list_hover js_x_scroll_backcolor">
								<span class="span_span11"></span>
								<span class="span_span1" title="{$list.ordernum}">{$list.ordernum}</span>
								<span class="span_span1" title="{$list.createtime}"><if condition="isset($list['createtime'])">{$list.createtime}<else/>--</if></span>
								<span class="span_span1">
									<php>
									 switch($list['status']){
										 case 1:
											 echo '待邮寄';
											 break;
										 case 2:
											 echo '处理中';
											 break;
										 case 3:
											 echo '已完成';
											 break;
										 case 4:
											 echo '已取消';
											 break;
										 default:
											 echo '--';
									 }
									</php>
								</span>

								<span class="span_span1" title="{$list.clientid}">{$list.clientid}</span>
								<!--<span class="span_span2">
									<if condition="isset($list['name'])"><if condition="isset($list['name'])">{$list.name}<else/>--</if></if>
								</span>-->
								<a href="{:U('Appadmin/OrderManage/postOrderDetail',array('id'=>$list['id']),'','',true)}">
									<span class="span_span6 hand" data-id="{$list.id}">订单详情</span>
								</a>
							</div>
						</volist>
						<else/>
						NO DATA
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

	var gUrl="{:U('Appadmin/OrderManage/postOrderList','','html','',true)}";
	$(function(){
		$.postList.init();
	})
</script>