<layout name="../Layout/Layout" />
<div class="content_global_collection">
    <div class="content_hieght">
        <div class="content_c">
        	<div>{$T->str_cr_recommond_user}<!-- 推荐用户 --></div>
            <div class="showdetail_list_name">
			     <span class="span_span1">{$T->str_cr_user_id}<!-- 用户ID --></span>
			     <span class="span_span2">{$T->str_cr_username}<!-- 姓名 --></span>
			     <span class="span_span3">{$T->str_cr_area}<!-- 地区 --></span>
			     <span class="span_span4">{$T->str_cr_industry}<!-- 行业 --></span>
			     <span class="span_span5">{$T->str_cr_title}<!-- 职位 --></span>
			     <!-- 排序操作 -->
                 <php>
                 	$dbSortField = 'use_num'; //定义数据库中排序属性
                 	$urlparamsTmp = $urlparams;
                 	if($dbSortField != $sortfield && isset($urlparams['sorttype'])){
                 		unset($urlparamsTmp['sorttype']);
                 	}
                 	if(!empty($sortfield2)){
                 		$urlparamsTmp['sortfield2'] = $sortfield2;
                 	}
                 </php>
			     <a href="{:U('/'.MODULE_NAME.'/'.CONTROLLER_NAME.'/showdetail/target/1/sortfield/'.$dbSortField,$urlparamsTmp)}" >
                    <span class="span_span6"><u style="float:left;" >{$T->str_cr_user_cnt}<!-- 使用次数 --></u>
                        <if condition="isset($urlparamsTmp['sorttype']) AND $urlparamsTmp['sorttype'] eq 'asc' and $sortfield eq $dbSortField ">
                            <em class="list_sort_asc "></em>
                        <elseif condition="isset($urlparamsTmp['sorttype']) AND $urlparamsTmp['sorttype'] eq 'desc' and $sortfield eq $dbSortField " />
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
                 	if(!empty($sortfield2)){
                 		$urlparamsTmp['sortfield2'] = $sortfield2;
                 	}
                 </php>
			    <a href="{:U('/'.MODULE_NAME.'/'.CONTROLLER_NAME.'/showdetail/target/1/sortfield/'.$dbSortField,$urlparamsTmp)}" >
                    <span class="span_span7"><u style="float:left;" >{$T->str_cr_last_find_time}<!-- 最后找人时间 --></u>
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
            <empty name="list">
            	<center style="margin-top:20px;">{$T->str_list_no_has_data}</center>
            </empty>
            <foreach name="list" item="val">
                <div class="showdetail_list_c list_hover">
	                 <span class="span_span1" >{$val.mobile|isEmpty}</span>
		             <span class="span_span2 text_hidden" >
                        <em title="{$val.real_name}">{$val.real_name|isEmpty}</em>
                        <if condition="$val['isbinding'] eq 1">
                        <small title="已绑定">已绑定</small>
                        </if>
                     </span>
		             <span class="span_span3" >{$val.region|isEmpty}</span>
		             <span class="span_span4" >{$val.industry|isEmpty}</span>
		             <span class="span_span5 text_hidden" >{$val.position|isEmpty}</span>
		            <span class="span_span6" >{$val.use_num}</span>
		            <span class="span_span7" >
		           <empty name="val['last_find_time']">
		            	---
		            <else/>
		            	{$val.last_find_time|date="Y-m-d H:i:s",###}</span>
		            </empty>
                </div>
            </foreach>
        </div>
        <div class="appadmin_pagingcolumn">
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
        </div>
    </div>
</div>

<!-- 列表2数据 -->
<div class="content_global_collection">
    <div class="content_hieght">
        <div class="content_c">
        	<div>{$T->str_cr__recommended_vcard}<!-- 被推荐名片 --></div>
            <div class="showdetail_list_name">
			     <span class="card_span_span1">{$T->str_cr_mobile}<!-- 手机号 --></span>
			     <span class="card_span_span2">{$T->str_cr_username}<!-- 姓名 --></span>
			     <span class="card_span_span3">{$T->str_cr_company}<!-- 公司 --></span>
			     <span class="card_span_span5">{$T->str_cr_title}<!-- 职位 --></span>
			     <span class="card_span_span4">{$T->str_cr_holder}<!-- 持有人 --></span>
            </div>
            <empty name="list2">
            	<center style="margin-top:20px;">{$T->str_list_no_has_data}</center>
            </empty>
            <foreach name="list2" item="val">
                <div class="showdetail_list_c js_table2_tip list_hover">
	                 <span class="card_span_span1" >{$val.mobile|isEmpty}</span>
		             <span class="card_span_span2 text_hidden" >{$val.contact_name|isEmpty}</span>
		             <span class="card_span_span3" >{$val.vorg|isEmpty}</span>
		             <span class="card_span_span5 text_hidden" >{$val.vtitle|isEmpty}</span>
		             <span class="card_span_span4" >{$val.num}</span>
                </div>
            </foreach>
        </div>
        <div class="appadmin_pagingcolumn">
            <!-- 翻页效果引入 -->
            <include file="pagemain" />
        </div>
    </div>
</div>
<script>
$(function(){
    $.tableAddTitle('.showdetail_list_c'); //给table中的数据列添加title提示
    $.tableAddTitle('.js_table2_tip','card_span_span');
});
</script>