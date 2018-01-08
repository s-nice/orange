<layout name="../Layout/Layout" />
<div class="content_global">
 	<div class="content_hieght">
        <div class="content_c">
			<div class="content_search">
            	<div class="search_right_c">
            	 <form name="onlineForm" action="{:U('OrderManage/onlineCard','','',true)}" method="get">
                	<input type="hidden" name="search" value="search"/>
            	    <div class="select_Iontwo">
                	<span class="select_span">手机号</span>
	            	<input type="text" name="tel" value="{$params['tel']}" />
            		</div>
            		<div class="select_Iitwo">
                	<span>姓名</span>
	            	<input type="text" name="name" value="{$params['name']}" />
            		</div>
            		<div class="select_Iitwo">
                	<span>公司</span>
	            	<input type="text" name="company" value="{$params['company']}" />
            		</div>
	            	<input class="js_onlineCard_search submit_button" type="button" value="{$T->str_submit}"/>
				</form>
				</div>
			</div>			
			<div class="appadmin_pagingcolumn">
			<div class="section_bin">
			<span class="js_select_allno_active hand" style="background:#999 none repeat scroll 0 0;">
			<i>批量下架</i>
			</span>
			</div>
	            <!-- 翻页效果引入 -->
	            <include file="@Layout/pagemain" />
	        </div>
	        <div class="scanner_gdtiao">
		        <div class="share_maxwidth">
		            <div class="orderlist_list_name">
		                <span class="span_span11"><i class="js_select_all"></i></span>
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
		            <div class="orderlist_list_c js_x_scroll_backcolor">
		                <span class="span_span11"><i data="{$v['cardid']}" class="js_select"></i></span>
                        <span class="span_span1">在售</span>
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
		                <span class="js_noshare_act span_span13 hand" data="{$v['cardid']}">禁止出售</span>
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
var noshareCardUrl = "{: U('OrderManage/underShelf','','',true)}";
$(function(){
	$.orderManage.shareCardPage();
});
</script>