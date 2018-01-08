<layout name="../Layout/Layout" />
<div class="content_global">
	<div class="content_hieght" id="js_checkboxdiv">
		<div class="content_c">
			<div class="content_search">
			<form method="get" action="{:U('OraParseRule/smsType','','',true)}">
			<input name="search" value="search" type="hidden" />
				<div class="right_search">
                        <input class="s_key" type="text" value="输入类型关键字" name="smstype" value="{$params['smstype']}"/>
					<div class="serach_but">
                        <input class="butinput cursorpointer" type="submit" value="" />
                    </div>
				</div>
			</form>
		</div>
			<div class="section_bin content_btn">
				<!--<span class="span_span11">
					<i id="js_allselect"></i>
				</span>
 				<input jsurl="{: U('OraParseRule/addSmsType','','',true)}" class="js_addSmsType hand" type="button" value="新增" /> -->
			</div>
			<!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" /> 
			<div class="content_list userpushlist_name">
	            <span class="span_span11"></span>
	            <span class="span_span1 hand" order='id'>
	                	<u>ID</u>
	                	<if condition="$order['name'] == 'ID'">
	                    	<a href="{:U('OraParseRule/smsType',array('orderName'=>'ID','orderType'=>$order['type']),'',true)}"><em class="list_sort_{$order['type']}"></em></a>
	                    <else />
	                    	<a href="{:U('OraParseRule/smsType',array('orderName'=>'ID'),'',true)}"><em class="list_sort_none"></em></a>
	                    </if>
	                </span>
	            <span class="span_span2">内容类型</span>
	            <span class="span_span8">提取信息</span>
<!-- 	            <span class="span_span8 hand" order='pushtime'> -->
<!-- 	                <u>添加时间</u> -->
<!-- 					<if condition="$order['name'] == 'time'"> -->
<!-- 	                    <a href="{:U('OraParseRule/smsType',array('orderName'=>'time','orderType'=>$order['type']),'',true)}"><em class="list_sort_{$order['type']}"></em></a> -->
<!-- 	                <else /> -->
<!-- 	                    <a href="{:U('OraParseRule/smsType',array('orderName'=>'time'),'',true)}"><em class="list_sort_none"></em></a> -->
<!-- 	                </if> -->
<!-- 	            </span> -->
<!-- 	            <span class="span_span5">操作</span> -->
	        </div>
	        <foreach name="list" item="v">
		        <div class="content_list userpushlist_c checked_style list_hover">
		        	<span class="span_span11"><!-- <i class="js_select" val="{$v['id']}"></i> --></span>
		            <span class="span_span1">{$v['id']}</span>
		            <span class="span_span2">{$v['name']}</span>
		            <php>
		            $extractinfo = '';
		            foreach($v['extractinfo'] as $i){
		            	$extractinfo .= $i['name'].','; 
		            }
		            $extractinfo = trim($extractinfo,',');
		            </php>
		            <span class="span_span8" <if condition="$extractinfo != ''">title="{$extractinfo}"</if>>{$extractinfo}</span>
<!-- 		            <span class="span_span8">{$v['createdtime']|date='Y-m-d H:i',###}</span> -->
<!-- 		            <span class="span_span5"> -->
<!-- 		                <a href="{: U('OraParseRule/editSmsType',array('id'=>$v['id']),'',true)}"><em class="hand">编辑</em></a> -->
<!-- 		            </span> -->
		        </div>
	        </foreach>
        </div>
        <div class="appadmin_pagingcolumn">
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
        </div>
</div>
</div>
<script>
var smsTypeCheckObj = null;
var smsTypeHaveStatusUrl = "{:U('OraParseRule/smsTypeHaveStatus','','',true)}";
$(function(){
	$.smsType.listPage();
});
</script>