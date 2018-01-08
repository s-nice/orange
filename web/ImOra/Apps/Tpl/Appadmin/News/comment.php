<layout name="../Layout/Layout" />
<include file="head" />
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
                <div class="right_search">
                	<div class="serach_name menu_list js_select_item">
        				<span class="span_name">
                            <if condition="$params['type'] eq 'mobile'">
                                <input type="text" value="ID" seltitle="mobile" id="js_titlevalue" readonly="true" title="ID"/>
                                <elseif condition="$params['type'] eq 'content'" />
                                <input type="text" value="{$T->str_comment_content}" seltitle="content" id="js_titlevalue" readonly="true" title="{$T->str_comment_content}"/>
                                <else/>
                                <input type="text" value="{$T->str_news_comment_user}" seltitle="realname" id="js_titlevalue" readonly="true" title="{$T->str_news_comment_user}"/>
                            </if>
                        </span>
                        <em id="js_seltitle" class='hand' ><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                        <input class="textinput cursorpointer" type="text" id="js_selkeyword" value="{$params['keyword']}"/>
                        <ul id="js_selcontent">
                            <li class="on" val="mobile" title="ID">ID</li>
                            <li val="content" title="{$T->str_comment_content}">{$T->str_comment_content}</li>
                            <li val="realname" title="{$T->str_news_comment_user}">{$T->str_news_comment_user}</li>
                        </ul>
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
            <div class="appadmin_pagingcolumn">
	            <div class="section_bin">
	                <span class="span_span11"><i class="hand" id="js_allselect"></i>{$T->str_news_selectall}</span>
	                <if condition="$status eq 1">
                        <span id="js_comment_pass" class='hand'><i>{$T->str_audit_success}</i></span>
                        <span id="js_comment_reject" class='hand'><i>{$T->str_audit_faild}</i></span>
	                </if>
	                <span id='js_comment_preview' class='hand'><i>{$T->str_news_review}</i></span>
	            </div>
		            <!-- 翻页效果引入 -->
            	<include file="@Layout/pagemain" />
	        </div>
            <div class="comment_list_name">
                <span class="span_span11"></span>
                <if condition="$status eq 1">
                    <span class="span_span2">{$T->str_news_status}</span>
                </if>
                <span class="span_span2">{$T->str_news_modular}</span>
                <if condition="$params['order'] eq 'mobile'">
                    <if condition="$params['ordertype'] eq 'asc'">
                        <span class="span_span1" id="js_orderbymobile" type="{$params['ordertype']}"><u>ID</u><em class="list_sort_asc"></em></span>
                    <else/>
                        <span class="span_span1" id="js_orderbymobile" type="{$params['ordertype']}"><u>ID</u><em class="list_sort_desc"></em></span>
                    </if>
                    <else/>
                    <span class="span_span1" id="js_orderbymobile" type="desc"><u>ID</u><em class="list_sort_none"></em></span>
                </if>
                <span class="span_span3">{$T->str_news_comment_content}</span>
                <span class="span_span4">{$T->str_news_comment_user}</span>
                <if condition="$params['order'] eq 'datetime'">
                    <if condition="$params['ordertype'] eq 'asc'">
                        <span class="span_span5" id="js_orderbytime"  timetype='datetime' type="{$params['ordertype']}"><u>{$T->str_news_comment_time}</u><em class="list_sort_asc"></em></span>
                    <else/>
                        <span class="span_span5" id="js_orderbytime" timetype='datetime' type="{$params['ordertype']}"><u>{$T->str_news_comment_time}</u><em class="list_sort_desc"></em></span>
                    </if>
                    <else/>
                    <span class="span_span5" id="js_orderbytime" timetype='datetime' type="desc"><u>{$T->str_news_comment_time}</u><em class="list_sort_none"></em></span>
                </if>
                <if condition="$params['order'] eq 'commentnum'">
                    <if condition="$params['ordertype'] eq 'asc'">
                        <span class="span_span7" id="js_orderbycommentnum" type="{$params['ordertype']}"><u>{$T->str_news_answer_num}</u><em class="list_sort_asc"></em></span>
                    <else/>
                        <span class="span_span7" id="js_orderbycommentnum" type="{$params['ordertype']}"><u>{$T->str_news_answer_num}</u><em class="list_sort_desc"></em></span>
                    </if>
                    <else/>
                    <span class="span_span7" id="js_orderbycommentnum" type="desc"><u>{$T->str_news_answer_num}</u><em class="list_sort_none"></em></span>
                </if>
                <!-- <span class="span_span7"><u>回答数</u><em><b class="b_b1"></b><b class="b_b2"></b></em></span> -->
            </div>
            <if condition="$rstCount neq 0">
                <foreach name="list" item="val">
                    <div class="comment_list_c list_hover js_x_scroll_backcolor">
                        <span class="span_span11" style='width:52px;'><i class="js_select hand" val="{$val['commentid']}"></i></span>
                        <if condition="$status eq 1">
                            <span class="span_span2">{$val.statusname}</span>
                        </if>
                        
                        <span class="span_span2">{$val.type}</span>
                        <span class="span_span1" title="{$val.mobile}">{$val.mobile}</span>
                        <span class="span_span3 js_emoji_toimg" title="{$val.content}">{$val.content}</span>
                        <span class="span_span4" title="{$val.realname}">{$val.realname}</span>
                        <span class="span_span5">{$val.datetime}</span>
                        <span class="span_span6">{$val.commentnum}</span>
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
<script src="__PUBLIC__/js/jsExtend/expression/js/plugins/exp/exp.js"></script>
<script>
    var commentpassurl = "{:U('Appadmin/News/commentPass')}";
    var searchurl = '{$currentUrl}';
    $(function(){
        $.news.commentPassedInit();
    })

</script>
<include file="unlockpop" />