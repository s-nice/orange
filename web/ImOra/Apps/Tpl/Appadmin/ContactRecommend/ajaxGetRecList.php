<if condition="$source eq 'recedListHide'">
<!-- 推荐用户列表 start-->
<div class="waiflist_pop">
<input type="hidden" id="dataSourceId" value="{$source}"/>
	<div class="waiflist_close"><img class="cursorpointer js_add_list_cancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
	<div class="waiflist_comment_c">
		<div class="waiflist_commenttitle">{$T->str_cr_user_list}<!-- 用户列表 --></div>
		<div class="waiflist_serach">
			 <!-- 下拉框模板->账号类型start -->
			<div class="select_IOS menu_list js_sel_public js_sel_keyword_type">
				<input type="text"  readonly="readonly" class="hand" val="{$urlparams['kwdType']}" />
				<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
				<ul class="hand js_sel_ul">
					<li title="{$T->str_partner_id}" val="1">{$T->str_cr_user_id}</li><!-- 用户ID -->
					<li title="{$T->str_partner_name}" val="2">{$T->str_cr_username}</li><!-- 姓名 -->
				</ul>
			</div>
			<input class="textinput" name='search_word' id="search_word" type="text" value="{$urlparams['kwd']}" maxlength="32"/>
			<!-- 省市区、行业、职能 -->
			<input class="textinput"  name="region" id="region" value="{$urlparams['regionShow']}" hideVal="{$urlparams['region']}"  type="text" placeholder="{$T->str_cr_area}" num1="5" num2="5"> <!-- num1:表示一级数据显示个数，num2:表示二级说显示个数 -->
			<input class="textinput"  name="industry" id="industry" value="{$urlparams['industryShow']}" hideVal="{$urlparams['industry']}" type="text" placeholder="{$T->str_cr_industry}" num1="3" num2="4">
			<input class="textinput" name="usertitle" id="usertitle" value="{$urlparams['title']}"  type="text" placeholder="{$T->str_cr_title}">
            <input class="butinput cursorpointer js_btn_search" type="submit" value="" /><!-- 搜索按钮 -->
		</div>
		      <!-- 顶部 导航栏 -->
              <div class="appadmin_collection_comment appadmin_coll">
	            <div class="collectionsection_bin" style="width:440px">
	                <span class="span_span11"><i class="" id="js_allselect"></i></span>
	                <span class="em_del hand" id="js_btn_add_confirm" >{$T->str_cr_confirm}<!-- 确认 --></span>
	              
	            </div>
	            <include file="@Layout/pagemain" />
	        </div>
		<!-- 列表title -->
		<div class="showdetail_list_name">
		     <span class="span_span11"></span>
		     <span class="span_span1">{$T->str_cr_user_id}<!-- 用户ID --></span>
		     <span class="span_span2">{$T->str_cr_username}<!-- 姓名 --></span>
		     <span class="span_span3">{$T->str_cr_area}</span>
		     <span class="span_span4">{$T->str_cr_industry}</span>
		     <span class="span_span5">{$T->str_cr_title}</span>
	     	 <!-- 排序操作 -->
                 <php>
                     $dbSortField = 'use_num'; //定义数据库中排序属性
                     $urlparamsTmp = $urlparams;
                 	 if($dbSortField != $sortfield && isset($urlparams['sorttype'])){
                 		unset($urlparamsTmp['sorttype']);
                 	}                 	
                 </php>
			    <a href="{:U('/'.MODULE_NAME.'/'.CONTROLLER_NAME.'/ajaxGetRecList/source/'.$source.'/sortfield/'.$dbSortField,$urlparamsTmp)}" >
                    <span class="span_span6"><u style="float:left;" >{$T->str_cr_user_cnt}</u>
                        <if condition="isset($urlparamsTmp['sorttype']) AND $urlparamsTmp['sorttype'] eq 'asc' and $sortfield eq $dbSortField ">
                            <em class="list_sort_asc "></em>
                        <elseif condition="isset($urlparamsTmp['sorttype']) and $urlparamsTmp['sorttype'] eq 'desc' and $sortfield eq $dbSortField " />
                            <em class="list_sort_desc "></em>
                        <else />
                            <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                        </if>
                    </span>
                </a>
		     	 <!-- 排序操作 -->
                 <php>
                     $dbSortField = 'last_find_time'; //定义数据库中排序属性
                     $urlparamsTmp = $urlparams;
                 	 if($dbSortField != $sortfield && isset($urlparams['sorttype'])){
                 		unset($urlparamsTmp['sorttype']);
                 	}
                 </php>
			    <a href="{:U('/'.MODULE_NAME.'/'.CONTROLLER_NAME.'/ajaxGetRecList/source/'.$source.'/sortfield/'.$dbSortField,$urlparamsTmp)}" >
                    <span class="span_span7"><u style="float:left;" >{$T->str_cr_last_find_time}</u>
                        <if condition="isset($urlparamsTmp['sorttype']) AND $urlparamsTmp['sorttype'] eq 'asc' and $sortfield eq $dbSortField ">
                            <em class="list_sort_asc "></em>
                        <elseif condition="isset($urlparamsTmp['sorttype']) AND $urlparamsTmp['sorttype'] eq 'desc' and $sortfield eq $dbSortField " />
                            <em class="list_sort_desc "></em>
                        <else />
                            <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                        </if>
                    </span>
                </a>
		</div>
		<if condition="sizeof($list)">
		<div style="height: 250px;overflow-y:auto;overflow-x:hidden;">
        <foreach name="list" item="val">
			<div class="showdetail_list_c list_hover">
	             <span class="span_span11">
	             	<i class="js_select" val="{$val['user_id']}"></i>
	             </span>
	             <span class="span_span1" >{$val.mobile|isEmpty}</span>
	             <span class="span_span2 js_name" >
	             <em title="{$val.real_name}">{$val.real_name|isEmpty}</em>
	             <if condition="$val['isbinding'] eq 1">
	            	 <small title="已绑定">已绑定</small>
	             </if>
	             </span>
	             <span class="span_span3" >{$val.region|isEmpty}</span>
	             <span class="span_span4" >{$val.industry|isEmpty}</span>
	             <span class="span_span5" >{$val.position|isEmpty}</span>
	             <span class="span_span6" >{$val.use_num}</span>
	             <span class="span_span7" > <empty name="val['last_find_time']">
		            	---
		            <else/>{$val.last_find_time|date="Y-m-d H:i:s",###}</empty></span>     
	        </div>
        </foreach>
        </div>
		<else />
			<div class="waiflist_list_empty"><span>{$T->str_no_data}</span></div>
		</if>
        <div class="appadmin_collection_comment js_pop_page_tpl">
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
        </div>
	</div>
</div>
<!-- 推荐用户列表end -->

<elseif condition="$source eq 'recListHide'"/>
<!-- 推荐名片列表start -->
<div class="waiflist_pop">
<input type="hidden" id="dataSourceId" value="{$source}"/>
	<div class="waiflist_close"><img class="cursorpointer js_add_list_cancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
	<div class="waiflist_comment_c">
		<div class="waiflist_commenttitle">{$T->str_cr_vcard_list}<!-- 名片列表 --></div>
		<div class="waiflist_serach waiflist_serachmargin">
			 <!-- 下拉框模板->账号类型start -->
			<div class="select_IOS menu_list js_sel_public js_sel_keyword_type">
				<input type="text"  readonly="readonly" class="hand" val="{$urlparams['kwdType']}" />
				<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
				<ul class="hand js_sel_ul">
					<li class="on" title="{$T->str_partner_id}" val="1">{$T->str_cr_mobile}</li>
					<li title="{$T->str_partner_name}" val="2">{$T->str_cr_username}</li>
				</ul>
			</div>
			<input class="textinput" name='search_word' id="search_word" type="text" value="{$urlparams['kwd']}" maxlength="32"/>
			<!-- 省市区、行业、职能 -->
			<input class="textinput" name="region" id="region" value="{$urlparams['regionShow']}" hideVal="{$urlparams['region']}" type="text" placeholder="{$T->str_cr_area}" num1="5" num2="5"> <!-- num1:表示一级数据显示个数，num2:表示二级说显示个数 -->
			<input class="textinput"  name="industry" id="industry" value="{$urlparams['industryShow']}" hideVal="{$urlparams['industry']}" type="text" placeholder="{$T->str_cr_industry}" num1="3" num2="4">
			<input class="textinput"  name="position" id="position" value="{$urlparams['positionShow']}" hideVal="{$urlparams['position']}" type="text" placeholder="{$T->str_cr_position}" num1="3" num2="5">
            <input class="butinput cursorpointer js_btn_search" type="submit" value="" />
		</div>
		      <!-- 顶部 导航栏 -->
              <div class="appadmin_collection_comment appadmin_coll">
	            <div class="collectionsection_bin" style="width:440px">
	                <span class="span_span11"><i class="" id="js_allselect"></i></span>
	                <span class="em_del hand" id="js_btn_add_confirm" >{$T->str_cr_confirm}</span>
	            </div>
	            <include file="@Layout/pagemain" />
	        </div>
		<!-- 列表title -->
		<div class="showget_list_name">
		     <span class="span_span11"></span>
		     <span class="span_span1">{$T->str_cr_mobile}</span>
		     <span class="span_span2">{$T->str_cr_username}</span>
		     <span class="span_span3">{$T->str_cr_company}</span>
		     <span class="span_span4">{$T->str_cr_title}</span>
		     <span class="span_span5">{$T->str_cr_holder}</span>
		</div>
		<if condition="sizeof($list)">
        <foreach name="list" item="val">
			<div class="showget_list_c list_hover">
	             <span class="span_span11">
	             	<i class="js_select" val="{$val['vcard_id']}"></i>
	             </span>
	             <span class="span_span1" >{$val.mobile|isEmpty}</span>
	             <span class="span_span2 js_name" >{$val.contact_name|isEmpty}</span>
	              <span class="span_span3" >{$val.vorg|isEmpty}</span>
	              <span class="span_span4" >{$val.vtitle|isEmpty}</span>
	             <span class="span_span5" >{$val.num}</span>
	        </div>
        </foreach>
		<else />
			<div class="waiflist_list_empty"><span>{$T->str_no_data}</span></div>
		</if>
        <div class="appadmin_collection_comment js_pop_page_tpl">
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
        </div>
	</div>
</div>
<!-- 推荐名片列表end -->
<else/>
</if>
<script>
$.tableAddTitle('.showdetail_list_c'); //给table中的数据列添加title提示
$.tableAddTitle('.showget_list_c'); //给table中的数据列添加title提示
</script>