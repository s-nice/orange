<layout name="../Layout/Layout" />
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="content_search">
				<div class="right_search">
					<div class="select_Itwo" style="width:100px;">
						<div class="select_sketchtwo menu_list"">
							<input type="text" value="企业名称" readonly="readonly" autocomplete='off'>
							<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" alt=""></i>
							<ul>
								<li val='name'>企业名称</li>
								<li val='regnumber'>工商注册号</li>
								<li val='legalperson'>法人</li>
								<li val='approvedtime'>核准时间</li>
							</ul>
						</div>
					</div>
					<input class="textinput key_width cursorpointer" type="text" autocomplete='off'>
					<input class="textinput key_width cursorpointer" type="text" autocomplete='off' readonly style='display:none;'>
					<div class="serach_but">
						<input class="butinput cursorpointer" type="button">
					</div>
				</div>
			</div>
			<div class="section_bin"></div>
			<!-- 翻页效果引入 -->
			<include file="@Layout/pagemain" />
			<div style="width:820px;overflow-x:scroll;">
			<div class="company_name_list userpushlist_name" style="width:1500px;margin-top:15px;">
			    <input type='hidden' id='order' value='{$get.order}'>
                <input type='hidden' id='ordertype' value='{$get.ordertype}'>
				<span class="span_span11"></span>
	            <span class="span_span9 hand">工商注册号</span>
	            <span class="span_span2">公司名称</span>
	            <span class="span_span9">法人</span>
	            <span class="span_span1">核准日期</span>
	            <span class="span_span1">企业类型</span>
	            <span class="span_span3">行业</span>
	            <span class="span_span1">所在地</span>
	            <span class="span_span6 hand" order='createdtime'>
	               <u style="float:left;">获取日期</u>
	               <if condition="$get['order'] eq 'createdtime'">
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
	            <span class="span_span6 hand" order='lastupdatetime'>
	               <u style="float:left;">更新日期</u>
	               <if condition="$get['order'] eq 'lastupdatetime'">
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
	            <span class="span_span5">操作</span>
       		</div>
            <foreach name="list" item='v'>
            <div class="company_name_list company_name_hover userpushlist_c list_hover checkbox_new js_x_scroll_backcolor" style="width:1500px;">
				<span class="span_span11"></span>
				<span class="span_span9" title="{$v['content']['baseInfo']['regNumber']}">{$v['content']['baseInfo']['regNumber']}</span>
				<span class="span_span2" title="{$v['content']['baseInfo']['name']}">{$v['content']['baseInfo']['name']}</span>
				<span class="span_span9" title="{$v['content']['baseInfo']['legalPersonName']}">{$v['content']['baseInfo']['legalPersonName']}</span>
				<span class="span_span1" title="{$v['content']['baseInfo']['approvedTime']}">{$v['content']['baseInfo']['approvedTime']/1000|date='Y-m-d',###}</span>
				<span class="span_span1" title="{$v['content']['baseInfo']['companyOrgType']}">{$v['content']['baseInfo']['companyOrgType']}</span>
				<span class="span_span3" title="{$v['content']['baseInfo']['industry']}">{$v['content']['baseInfo']['industry']}</span>
				<span class="span_span1" title="{$v['content']['baseInfo']['regLocation']}">{$v['content']['baseInfo']['regLocation']}</span>
				<span class="span_span6" title="{$v.createdtime}">{$v.createdtime}</span>
				<span class="span_span6" title="{$v.lastupdatetime}">{$v.lastupdatetime}</span>
	            <span class="span_span5">
                  	<a href="{:U('Appadmin/IC/icinfo')}?id={$v.id}">详情</a>
	            </span>
			</div>
            </foreach>
			</div>
		</div>
	</div>
	<div class="appadmin_pagingcolumn">
		<!-- 翻页效果引入 -->
		<include file="@Layout/pagemain" />
	</div>
</div>
<script type='text/javascript'>
var URL_LIST="{:U('Appadmin/IC/icsearch')}";
var searchType="{$get.search_type}";
var keyword="{$get.keyword}";
$(function(){
	$.icsearch.list();
	if (!!searchType){
		$('.select_sketchtwo ul li[val="'+searchType+'"]').click();
		if (searchType=='approvedtime'){
			$('.textinput:eq(1)').val(keyword);
		} else {
			$('.textinput:eq(0)').val(keyword);
		}
	}
});
</script>