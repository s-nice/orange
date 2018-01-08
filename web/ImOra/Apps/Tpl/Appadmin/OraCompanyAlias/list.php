<layout name="../Layout/Layout" />
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="content_search">
				<div class="right_search search_company_name">
					<input type="text"  id="js_alias_search_input" placeholder="请输入关键字" <if condition="isset($params['keyword'])"> value="{$params['keyword']}"</if>>
					<div class="serach_but">
                        <input  id="js_alias_search"   class="butinput cursorpointer" type="button" value="" />
                    </div>
				</div>
			</div>
			<div class="section_bin company_add">
				<span class="span_span11"></span>
				<a href="{:U('Appadmin/OraCompanyAlias/addOrEdit','','','',true)}"><button type="button">新增</button></a>

			</div>
			<!-- 翻页效果引入 -->
			<include file="@Layout/pagemain" />
			<div class="company_name_list userpushlist_name">
				<span class="span_span11"></span>
	            <span class="span_span1 hand" order='id'>
	                	<u style="float:left;">ID</u>
					     <if condition="isset($params) && $params['sort'] eq 'asc'">
							 <em class="list_sort_asc" type="asc" id="js_alias_sort" ></em>
						 <else/>
							 <em class="list_sort_desc" type="desc" id="js_alias_sort" ></em>
						 </if>

	                </span>
	            <span class="span_span2">公司名称</span>
	            <span class="span_span6">中文关键词</span>
	            <span class="span_span3">别名</span>
	            <span class="span_span5">操作</span>
       		</div>
			<if condition="isset($data) && $data['status'] eq 0">
				<if condition="$data['data']['numfound'] gt 0">
					<volist name="data['data']['list']" id="list">
						<div class="company_name_list company_name_hover userpushlist_c list_hover">
							<span class="span_span11"></span>
							<span class="span_span1">{$list.id}</span>
							<span class="span_span2" title="{$list.name}">{$list.name}</span>
							<span class="span_span6">{$list.keywordscn}</span>
							<span class="span_span3" title="{$list.alias}">{$list.alias}</span>
            	            <span class="span_span5">
                              	<a href="{:U('Appadmin/OraCompanyAlias/addOrEdit',array('id'=>$list['id']),'','',true)}"><em class="hand js_alias_edit" data-id="{$list.id}">编辑</em></a>
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

	var gSort="{$params['sort']}";
	var gKeyword="{$params['keyword']}";
	var gUrl="{:U('Appadmin/OraCompanyAlias/index','','','',true)}";
</script>