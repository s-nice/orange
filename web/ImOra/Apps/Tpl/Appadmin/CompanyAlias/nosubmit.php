<layout name="../Layout/Layout" />
<!--意义分词已提交-->
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="content_search">
				<div class="right_search search_company_name">
					<input type="text"  id="js_alias_search_input" default-txt="请输入关键字" <if condition="isset($params['keyword'])"> value="{$params['keyword']}"</if>>
					<div class="serach_but">
                        <input  id="js_alias_search"   class="butinput cursorpointer" type="button" value="" />
                    </div>
				</div>
			</div>
			<div class="section_bin company_add checkbox_right">
				<span class="span_span11"><i id="js_allselect"></i>全选</span>
				<a href="{:U('Appadmin/CompanyAlias/add','','','',true)}"><button type="button" class="hand">新增</button></a>
				<button type="button" id="js_submit_more" class="hand">批量提交</button>
			</div>
			<!-- 翻页效果引入 -->
			<include file="@Layout/pagemain" />
			<div class="company_name_list  js_list_name_title userpushlist_name" >
				<span class="span_span11"></span>
	            <span class="span_span10 hand" order='id'>
	                	<u style="float:left;">ID</u>
					       <if condition="isset($params) && $params['order'] eq 'id'">
							   <if condition="$params['sort'] eq 'asc'">
								   <em class="list_sort_asc js_alias_sort " type="asc"  order='id'></em>
								   <else/>
								   <em class="list_sort_desc js_alias_sort" type="desc"  order='id'></em>
							   </if>
							   <else/>
							   <em class="list_sort_none js_alias_sort" order='id'></em>
						   </if>
	                </span>
	            <span class="span_span2">公司名称</span>
	            <span class="span_span9">中文关键词</span>
	            <span class="span_span3">别名</span>
	            <span class="span_span5 hand">
					<u style="float:left;">名片数量</u>
						   <if condition="isset($params) && $params['order'] eq 'cardnum'">
							   <if condition="$params['sort'] eq 'asc'">
								   <em class="list_sort_asc js_alias_sort " type="asc"  order='cardnum'></em>
								   <else/>
								   <em class="list_sort_desc js_alias_sort" type="desc"  order='cardnum'></em>
							   </if>
							   <else/>
							   <em class="list_sort_none js_alias_sort" order='cardnum'></em>
						   </if>
					</span>
	            <span class="span_span5">操作</span>
       		</div>
			<if condition="isset($data) && $data['status'] eq 0">
				<if condition="$data['data']['numfound'] gt 0">
					<volist name="data['data']['list']" id="list">
						<div class="company_name_list company_name_hover userpushlist_c list_hover checkbox_new js_x_scroll_backcolor">
							<span class="span_span11"><i class="js_select" val="{$list.id}"></i></span>
							<span class="span_span10">{$list.id}</span>
							<span class="span_span2" title="{$list.name}">{$list.name}</span>
							<span class="span_span9">{$list.keywordscn}</span>
							<span class="span_span3" title="{$list.alias}">{$list.alias}</span>
							<span class="span_span5">{$list.cardnum}</span>
            	            <span class="span_span5">
                              	<a href="{:U('Appadmin/CompanyAlias/edit',array('id'=>$list['id'],'status'=>1),'','',true)}">
									<em class="hand js_alias_edit" data-id="{$list.id}">编辑</em></a>
								| <a class="js_submit_one hand" data-id="{$list.id}">提交</a>
           		            </span>
						</div>
					</volist>
				<else/>
					NO DATA
				</if>
			</if>
		</div>
	</div>
	<div class="appadmin_pagingcolumn">
		<!-- 翻页效果引入 -->
		<include file="@Layout/pagemain" />
	</div>
</div>
<script>

	//var gSort="{$params['sort']}";
	var gKeyword="{$params['keyword']}";
	var gUrl="{:U('Appadmin/CompanyAlias/nosubmit','','','',true)}";//列表地址
	var gSubUrl="{:U('Appadmin/CompanyAlias/doSubmit','','','',true)}"; //提交地址

</script>