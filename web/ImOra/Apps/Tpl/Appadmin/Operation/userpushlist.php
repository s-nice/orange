<layout name="../Layout/Layout" />
<include file="head" />
<style>
    .edui-default .edui-toolbar{
        width:706px; /*设置ueditor 编辑器宽度*/
    }
</style>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
                <div class="right_search">
                	<div class="serach_namemanages menu_list">
                	    <if condition="$get['type'] eq '2'">
                	    <span class="span_name"><input type="text" value="{$T->str_userpush_email}" seltitle="2" readonly="true" autocomplete='off'/></span>
                	    <elseif condition="$get['type'] eq '3'"/>
                	    <span class="span_name"><input type="text" value="{$T->str_userpush_msg}" seltitle="3" readonly="true" autocomplete='off'/></span>
                	    <else/>
                	    <span class="span_name"><input type="text" value="{$T->str_userpush_all}" seltitle="" readonly="true" autocomplete='off'/></span>
                	    </if>
                        <em id="js_seltitle"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul id="js_selcontent">
                            <li class="on" val="" title="">{$T->str_userpush_all}</li>
                            <li val="2" title="">{$T->str_userpush_email}</li>
                            <li val="3" title="">{$T->str_userpush_msg}</li>
                        </ul>
                    </div>
                    <div class="serach_name menu_list">
                        <if condition="$get['search_type'] eq 'name'">
                        <span class="span_name"><input type="text" value="{$T->str_userpush_author}" seltitle="name" readonly="true" /></span>
                        <elseif condition="$get['search_type'] eq 'id'"/>
                        <span class="span_name"><input type="text" value="ID" seltitle="id" readonly="true" /></span>
                        <else/>
                        <span class="span_name"><input type="text" value="{$T->str_userpush_content}" seltitle="content" readonly="true" /></span>
                        </if>
                        <em id="js_seltitle"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <ul id="js_selcontent2">
                            <li class="on" val="content" title="">{$T->str_userpush_content}</li>
                            <li val="name" title="">{$T->str_userpush_author}</li>
                            <li val="id" title="">ID</li>
                            <!-- <li val="title" title="">标题</li> -->
                        </ul>
                        <input class="textinput cursorpointer" type="text" id="js_selkeyword" value="<?php echo urldecode($get['keyword']);?>"/>
                    </div>
                    <div class="select_time_c">
                        <span class="span_name">{$T->str_news_time}</span>
                        <div class="time_c">
                            <input id="js_begintime" class="time_input" type="text" readonly="readonly" name="start_time" readonly="readonly" value="{$get['starttime']}" />
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                        <span>--</span>
                        <div class="time_c">
                            <input id="js_endtime" class="time_input" type="text" readonly="readonly" name="end_time" value="{$get['endtime']}"/>
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </div>
                    </div>
                    <div class="serach_but">
                        <input class="butinput cursorpointer" type="button" value="" id="js_searchbutton"/>
                    </div>
                </div>
            </div>
            <div class="section_bin">
                <span class="span_span11"><i class="" id="js_allselect"></i>{$T->str_news_selectall}</span>
                <a href="{:U('Appadmin/UserPush/addpush')}"><div class="left_bin">{$T->str_userpush_add}</div></a>
                <span id="js_delnews"><i>{$T->str_new_del}</i></span>
            </div>
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
            <div class="sectionnot_list_name userpushlist_name">
                <input type='hidden' id='order' value='{$get.order}'>
                <input type='hidden' id='ordertype' value='{$get.ordertype}'>
                <span class="span_span11"></span>
                <span class="span_span1 hand" order='id'>
                	<u>ID</u>
                	<if condition="$get['order'] eq 'id'">
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
                <span class="span_span6">{$T->str_userpush_type}</span>
                <span class="span_span8">{$T->str_userpush_content}</span>
                <span class="span_span1">{$T->str_userpush_status}</span>
                <span class="span_span8 hand" order='pushtime'>
                	<u>{$T->str_userpush_pushtime}</u>
                	<if condition="$get['order'] eq 'pushtime'">
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
                <span class="span_span5">{$T->str_userpush_author}</span>
                <span class="span_span5">推送用户数量</span>
                <span class="span_span4">{$T->str_userpush_operation}</span>
            </div>
            <foreach name="list" item="val">
            <div class="sectionnot_list_c userpushlist_c list_hover js_x_scroll_backcolor">
            	<span class="span_span11"><i class="js_select" val="{$val['id']}"></i></span>
                <span class="span_span1">{$val['id']}</span>
                <span class="span_span6">
                <if condition="$val['type'] eq '1'">{$T->str_userpush_broadcast}<elseif condition="$val['type'] eq '2'"/>{$T->str_userpush_email}<else/>{$T->str_userpush_msg}</if>
                </span>
                <span class="span_span8 js_review_notpublish hand" title="<?php echo htmlentities($val['content']);?>">{$val['content']}</span>
                <if condition="$val['isloop'] eq '1'"><span class="span_span1" title="循环推送">循环推送</span>
                <elseif condition="$val['pushstatus'] eq '2'" /><span class="span_span1" title="{$T->str_userpush_pushed}">{$T->str_userpush_pushed}</span>
                <elseif condition="$val['pushstatus'] eq '1'" /><span class="span_span1" title="{$T->str_userpush_not_push}">{$T->str_userpush_not_push}</span>
                <else/></if>
                <span class="span_span8"><?php echo date('Y-m-d H:i', $val['pushtime']);?></span>
                <span class="span_span5" title="{$val['name']}">{$val['name']}</span>
                <span class="span_span5" style='text-align: center;'>{$val['pushcount']}</span>
                <span class="span_span4" style="margin-right:0;">
                	<em class="hand js_single_edit">{$T->str_btn_edit}</em>
                	<if condition="($val['pushstatus'] eq '2') AND ($val['isloop'] neq '1')">|<em class='hand push_again'>{$T->str_userpush_push_again}</em></if>
                    <if condition="($val['pushstatus'] eq '1') AND ($val['isloop'] neq '1')">|<em class='hand push'>推送</em></if>
                    <if condition="($val['pushstatus'] eq '1') AND ($val['isloop'] neq '1')">|<em class='hand del'>删除</em></if>
                    <if condition="$val['isloop'] eq '1'">|<em class='hand stop_loop'>停止推送</em></if>
                </span>
            </div>
            </foreach>
        </div>
        <div class="appadmin_pagingcolumn">
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
        </div>
    </div>
</div>

<!-- 预览 弹出框 start -->
<div class="Check_comment_pop js_review_box js_btn_new_preview" style='display: none; z-index: 9999;min-height:1300px'>
    <div class="Check_comment_close js_btn_close"><img class="cursorpointer js_btn_channel_cancel"
                                                       src="__PUBLIC__/images/appadmin_icon_close.png"/></div>
    <div class="Check_commentpop_c">
        <div class="Checkcomment_title">{$T->str_news_review}</div>
        <div class="js_new_summey" style="">
            <div class="Check_summey">
                <h2 class="js_title">{$T->str_userpush_title}</h2>
                <!-- 
                <div class="i_em" class="js_source"><i class="js_category" cate-id="">互联网金融</i><em class="js_time">11:21pm</em>
                </div> -->
                <div class="js_content1" style='padding-right: 10px;'>{$T->str_userpush_article_content}</div>
            </div>
        </div>
    </div>
</div>
<!-- 预览 弹出框  end -->

<script type="text/javascript">
var URL_LIST="{:U('Appadmin/UserPush/index')}";
var URL_ADD="{:U('Appadmin/UserPush/addpush')}";
var URL_DEL="{:U('Appadmin/UserPush/delpush')}";
var URL_AGAIN="{:U('Appadmin/UserPush/againpush')}";
var URL_PUSH="{:U('Appadmin/UserPush/push')}";
var URL_STOPLOOP="{:U('Appadmin/UserPush/stopLoop')}";
var URL_VIEW="{:U('Appadmin/UserPush/viewpush')}";

var gStrconfirmdelnews = "{$T->str_userpush_del_confirm}";//确认删除该条资讯
var gStrcanceldelnews = "{$T->str_cancel_del_new}";//取消
var gStryesdelnews = "{$T->str_yes_del_new}";//确认
var str_userpush_del_at_least_one = "{$T->str_userpush_del_at_least_one}";
$(function(){
	$.userpush.pushlist();
});
</script>