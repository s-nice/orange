<layout name="../Layout/Layout" />
<include file="head" />
<div class="content_global">
    <div class="content_hieght">
    	<div class="content_c">
            <div class="content_search">
                <div class="right_search">
                    <div class="serach_namemanages menu_list js_select_item">
                        <span class="span_name">
                            <if condition="isset($params['industryName']) AND $params['industryName'] neq ''">
                                <input id="js_industry_select" type="text" value="{$params['industryName']}"  readonly="true" title="{$params['industryName']}" autocomplete="off"/>
                                <else/>
                                <input id="js_industry_select" type="text" value="行业"  readonly="true" title="行业" autocomplete="off"/>
                            </if>
                        </span>
                        <em ><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul id="js_industry_select_wrap" style="max-height:200px">
                            <li class="on" val="title"  title="行业">行业</li>
                            <volist name="industryList" id="vo">
                                <li title="{$vo.name}" data-id="{$vo.categoryid}">{$vo.name}</li>
                            </volist>
                        </ul>
                        <input  id="js_industryId" name="industryId" type="hidden"
                        <if condition="isset($params['industryId'])">value="{$params['industryId']}"</if>>
                    </div>
                    <div class="serach_name menu_list js_select_item">
        				<span class="span_name">
                            <if condition="$params['type'] eq 'title'">
                                <input type="text" value="{$T->str_news_title}" seltitle="title" id="js_titlevalue" readonly="true" title="{$T->str_news_title}" autocomplete="off"/>
                                <elseif condition="$params['type'] eq 'content'" />
                                <input type="text" value="{$T->str_news_content}" seltitle="content" id="js_titlevalue" readonly="true" title="{$T->str_news_content}"/>
                                <elseif condition="$params['type'] eq 'id'" />
                                <input type="text" value="ID" seltitle="id" id="js_titlevalue" readonly="true" title="ID"/>
                                <elseif condition="$params['type'] eq 'label'" />
                                <input type="text" value="{$T->str_label_name}" seltitle="label" id="js_titlevalue" readonly="true" title="{$T->str_label_name}"/>
                                <else/>
                                <input type="text" value="{$T->str_news_publish_user}" seltitle="realname" id="js_titlevalue" readonly="true" title="{$T->str_news_publish_user}"/>
                            </if>
                        </span>
                        <input name="tagsId" type="hidden" value="">
                        <em id="js_seltitle"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul id="js_selcontent">
                            <li class="on" val="title" title="{$T->str_news_title}">{$T->str_news_title}</li>
                            <li val="content" title="{$T->str_news_content}">{$T->str_news_content}</li>
                            <li val="realname" title="{$T->str_news_publish_user}">{$T->str_news_publish_user}</li>
                            <li val="id" title="ID">ID</li>
                            <li val="label" title="{$T->str_label_name}">{$T->str_label_name}</li>
                        </ul>
                        <input class="textinput cursorpointer" type="text" id="js_selkeyword" value="{$params['keyword']}"/>

                    </div>
                    <div class="select_time_c">
                        <span class="span_name">{$T->str_news_time}</span>
                        <div class="time_c">
                            <input id="js_begintime" class="time_input" type="text" name="start_time" readonly="readonly" value="{$params['starttime']}" />
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                        <span>--</span>
                        <div class="time_c">
                            <input id="js_endtime" class="time_input" type="text" name="end_time" readonly="readonly" value="{$params['endtime']}"/>
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                    </div>
                    <div class="serach_but">
                        <input class="butinput cursorpointer" type="button" value="" id="js_searchbutton"/>
                    </div>
                </div>
            </div>
            <div class="section_bin" id="section_bin">
                <span class="span_span11"><i class="" id="js_allselect"></i>{$T->str_news_selectall}</span>
                <span id="js_successaudit" class="js_successaudit"><i>{$T->str_audit_through}</i></span>
                <span id="js_failaudit" class="js_failaudit"><i>{$T->str_audit_notthrough}</i></span>
            </div>
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
	        <div class="sectionnotau_list_name">
	        	<span class="span_span11"></span>
                <if condition="$params['order'] eq 'id'">
                    <span class="span_span1" id="js_orderbyid" type="{$params['ordertype']}"><u>ID</u><em class="list_sort_{$params['ordertype']}"></em></span>
                    <else/>
                    <span class="span_span1" id="js_orderbyid" type="asc"><u>ID</u><em class="list_sort_none"></em></span>
                </if>
	            <span class="span_span2">{$T->str_news_title}</span>
	            <span class="span_span3">{$T->str_iscategory_info}</span>
                <if condition="$params['order'] eq 'releasetime'">
                    <span class="span_span6" id="js_orderbytime" timetype='releasetime'  type="{$params['ordertype']}"><u>{$T->str_news_releasetime}</u><em class="list_sort_{$params['ordertype']}"></em></span>
                    <else/>
                    <span class="span_span6" id="js_orderbytime" timetype='releasetime' type="desc"><u>{$T->str_news_releasetime}</u><em class="list_sort_none"></em></span>
                </if>
	            <span class="span_span8">{$T->str_news_publish_user}</span>
	            <span class="span_span9">{$T->str_news_manage}</span>
	        </div>
	        <if condition="$rstCount neq 0">
    	        <foreach name="list" item="val">
                    <div class="sectionnotau_list_c list_hover js_x_scroll_backcolor">
                    	<span class="span_span11"><i class="js_select" val="{$val['showid']}"></i></span>
                    	<span class="span_span1">{$val['id']}</span>
                    	<span class="span_span2 js_onenews_review" data-type="2" data-id="{$val['showid']}"  title="{$val['title']}">{$val['title']}</span>
                    	<span class="span_span3" title="{$val['category']}">{$val['category']}</span>
                        <span class="span_span6" title="{:date('Y-m-d H:i',$val['releasetime'])}"><?php echo date('Y-m-d',$val['releasetime']);?></span>
                        <span class="span_span8" title="{$val['realname']}">{:!empty($val['realname'])?$val['realname']:$T->str_news_null}</span>
                        <span class="span_span9"><i class="js_successone"  val="{$val['showid']}">{$T->str_audit_through}</i>|<i  val="{$val['showid']}" class="js_failone">{$T->str_audit_notthrough}</i></span>
                    </div>
                </foreach>
	        <else/>
	        No Data
	        </if>
	         
       	</div>
        <div class="appadmin_pagingcolumn">

	        <!-- 翻页效果引入 -->
	        <include file="@Layout/pagemain" />
        </div>
    </div>
</div>
<script>
    var gUrlToGetLabels = "<?php echo U(MODULE_NAME.'/common/getNewsLabels', array('myTemplate'=>'adminManageNews'));?>";
    var searchurl = "{:U('Appadmin/News/getNotAuditNews','','','',true)}";
    $(function(){
        $.news.notauditInit();
    })
</script>
<include file="unlockpop" />