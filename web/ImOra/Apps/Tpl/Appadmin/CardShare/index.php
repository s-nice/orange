<layout name="../Layout/Layout"/>
<div class="share_card_body">
    <div class="content_global">
        <div class="content_hieght">
            <div class="content_c" id="content_c">
                <div class="content_search">
                    <div class="serach_card_right">
                        <form action="{:U('Appadmin/CardShare/index','',false)}" method="get">
                            <!--时间start-->
                            <div class="select_time_c">
                                <span>{$T->stat_apperror_time}</span>
                                <div class="time_c"><!--开始时间-->
                                    <input class="time_input" type="text" name="startTime" id="js_begintime"
                                           value="{$startTime}" readonly="readonly" />
                                    <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png"/></i>
                                </div>
                                <span>--</span>
                                <div class="time_c"><!--结束时间-->
                                    <input class="time_input" type="text" name="endTime" id="js_endtime"
                                           value="{$endTime}" readonly="readonly" />
                                    <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png"/></i>
                                </div>
                            </div>
                            <!--时间end-->
                            <div class="scanner_name_input menu_list js_select_box">
                    	<span class="span_name">
							<input id="js_titlevalue" type="text" title="{$T->str_card_share_original_account}"
                                   readonly="true" seltitle="title"
                            <if condition="$search_type neq ''"> value="{$search_type}" <else/> value="{$T->str_card_share_original_account}"</if>  name="search_type" readonly="readonly" >
						</span>
                                <em id="js_seltitle"><img src="__PUBLIC__/images/appadmin_icon_xiala.png"></em>
                                <ul id="js_selcontent">
                                    <li title="{$T->str_card_share_original_account}"
                                        val="{$T->str_card_share_original_account}" class="on">
                                        {$T->str_card_share_original_account}
                                    </li>
                                    <li title="{$T->str_card_share_order_account}"
                                        val="{$T->str_card_share_order_account}">
                                        {$T->str_card_share_order_account}
                                    </li>
                                   <!-- <li title="{$T->str_card_share_owner}" val="{$T->str_card_share_owner}">
                                        {$T->str_card_share_owner}
                                    </li>-->
                                </ul>
                            </div>
                            <input class="textinput" name='search_word' type="text" value="{$search_word}"/>
                            <input class="butinput cursorpointer" type="submit" value=""/>
                        </form>
                    </div>
                </div>
                <div class="appadmin_pagingcolumn">
                    <div class="feedbacksection_bin">
                        <a href="{:U('Appadmin/CardShare/addShare','',false)}">
                            <div class="left_binadmin cursorpointer">{$T->str_card_share_add}</div>
                        </a>
                    </div>
                    <!-- 翻页效果引入 -->
                    <include file="@Layout/pagemain"/>
                </div>

                <div class="Journalsection_list_name">

                    <span class="span_span3" style="margin-left:30px;">{$T->str_card_share_original_order}</span>
                    <span class="span_span2">{$T->str_card_share_name}</span>
                    <span class="span_span2">{$T->str_card_share_card_num}</span>
                    <span class="span_span2">{$T->str_card_share_account_num}</span>
                    <span class="span_span3">{$T->str_card_share_sync_time}</span>
                    <span class="span_span2">{$T->str_card_share_operation}</span>
                </div>
                <!--列表循环-->
                <foreach name="list" item="vo">
                    <div class='Journalsection_list_c list_hover js_x_scroll_backcolor'>
                        <span class="span_span3 js_account_number" style="margin-left:30px;" title="{$vo.shareaccount}">{$vo.shareaccount}</span>
                        <span class="span_span2" title="{:json_decode($vo['content'],true)['realname']}">{:json_decode($vo['content'],true)['realname']}</span>
                        <span class="span_span2" title="{$vo.cardnum}">{$vo.cardnum}</span>
                        <span class="span_span2" title="{$vo.accountnum}">{$vo.accountnum}</span>
                        <span class="span_span3" title="{:date('Y-m-d H:i',$vo['createdtime'])}">{:date("Y-m-d H:i",$vo['createdtime'])}</span>
                <span class="span_span2">
                    <a href="{:U('Appadmin/CardShare/showShare',array('shareid'=>$vo['shareid'],'shareaccount'=>$vo['shareaccount']),false)}">{$T->str_card_share_show}</a>
                    |<if condition="$vo.status eq 3">
                        <a class="js_Undo cursorpointer"
                           shareID="{$vo.shareid}">{$T->str_card_share_cancel_operation}</a>
                    </if>
                </span>
                    </div>
                </foreach>
                <div class="appadmin_pagingcolumn">
                    <!-- 翻页效果引入 -->
                    <include file="@Layout/pagemain"/>
                </div>
            </div>
        </div>
    </div>
    <include file="CardShare/variable"/>
</div>
<script>
    $(function () {
        //日历插件
        $.dataTimeLoad.init();
    });
</script>

