<layout name="../Layout/Layout" />
<div class="content_global">
 	<div class="content_hieght">
        <div class="content_c">
			<div class="content_search">
            	<div class="search_right_c">
	            	<a href="{: U('OrderManage/onlineCard','','',true)}">
	            	  <input class="submit_button" type="button" value="搜索在售名片" />
	            	</a>
				</div>
			</div>
			<div class="appadmin_pagingcolumn">
	            <!-- 翻页效果引入 -->
	            <include file="@Layout/pagemain" />
	        </div>
			<div class="scanner_gdtiao">
		        <div class="share_maxwidth">
		            <div class="orderlist_list_name">
		                <span class="span_span11"></span>
		                <span class="span_span1">状态</span>
		                <span class="span_span5">姓名</span>
		                <span class="span_span3">手机号</span>
		                <span class="span_span4">职位</span>
		                <span class="span_span5">公司名称</span>
		                <span class="span_span5">部门</span>
		                <span class="span_span7">邮箱</span>
		                <span class="span_span8">公司地址</span>
		                <span class="span_span9">网址</span>
		                <span class="span_span10">传真</span>
		                <span class="span_span12">电话</span>
		                <span class="span_span13">操作</span>
		            </div>
		            <if condition="count($cardlist) gt 0">
		            <foreach name="cardlist" item="v">
		            <div class="orderlist_list_c js_x_scroll_backcolor list_hover">
		                <span class="span_span11"></span>
                        <span class="span_span1" style="color: red;">已下架</span>
                        <span class="span_span5">{$v['name']}</span>
                        <span title="{$v['mobile']}" class="span_span3">{$v['mobile']}</span>
		                <span title="{$v['job']}" class="span_span4">{$v['job']}</span>
		                <span title="{$v['company_name']}" class="span_span5">{$v['company_name']}</span>
		                <span title="{$v['department']}" class="span_span5">{$v['department']}</span>
		                <span title="{$v['email']}" class="span_span7">{$v['email']}</span>
		                <span title="{$v['address']}" class="span_span8">{$v['address']}</span>
		                <span title="{$v['web']}" class="span_span9">{$v['web']}</span>
		                <span title="{$v['fax']}" class="span_span10">{$v['fax']}</span>
		                <span title="{$v['telephone']}" class="span_span12">{$v['telephone']}</span>
		                <span class="js_online_act span_span13 hand" data="{$v['cardid']}">允许出售</span>
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
var onlineCardUrl = "{: U('OrderManage/online','','',true)}";
$(function(){
	$.orderManage.onlineCard();
});
</script>