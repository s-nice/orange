<layout name="../Layout/Layout" />
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
                <form action="{:U('Appadmin/news/feedback','',false)}" method="get" >
                <div class="right_searchfeed">
        			<div class="feedback_user">
        				<span>{$T->str_feedback_username}</span>
        				<input class="textinput_feed" name="uname" type="text" value="{$searchlist['uname']}" />
        			</div>
        			<div class="feedbackserach_time select_time_c">
        				<span class="span_name">{$T->str_feedback_time}</span>

        				<span class="span_input time_star time_c">
                            <input type="text"  class="Wdate" readonly id="js_begintime" type="text" name="begintime" value="{$searchlist['begintime']}" />
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </span>
        				<i>-</i>
        				<span class="span_input time_end time_c">
                            <input type="text" class="Wdate" readonly id="js_endtime" type="text" name="endtime" value="{$searchlist['endtime']}" />
                            <i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                        </span>

        			</div>
        			<div class="feedbackserach_but">
        				<input class="butinput cursorpointer" type="submit" value="" id="js_searchbutton"/>
        			</div>
        		</div>
                </form>
            </div>
            <div class="appadmin_pagingcolumn">
<!-- 	            <div class="feedbacksection_bin"> -->
<!-- 	                <span class="span_span11"><i class=""></i>{$T->str_extend_selectall}</span> -->
<!-- 	                <span class="em_del" id="js_del">{$T->str_extend_delete}</span> -->
<!-- 	            </div> -->
	            <!-- 翻页效果引入 -->
	            <include file="@Layout/pagemain" />
	        </div>
            <div class="feedbacksection_list_name">
                <span class="span_span1">{$T->str_feedback_username}</span>
                <a href="{:U('/Appadmin/news/feedback/stype/feedid',$searchlist)}" >
                <span class="span_span2"><u>{$T->str_feedback_id}</u>
                    <if condition="$condition_arr['stype'] eq 'feedid' and $searchlist['sval'] eq 'asc'">
                        <em class="list_sort_asc "></em>
                        <elseif condition="$condition_arr['stype'] eq 'feedid' and $searchlist['sval'] eq 'desc'" />
                        <em class="list_sort_desc "></em>
                        <else />
                        <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                    </if>
                </span>
                </a>
                <span class="span_span3">{$T->str_feedback_intro}</span>
                <a href="{:U('/Appadmin/news/feedback/stype/datetime',$searchlist )}" >
                <span class="span_span5"><u>{$T->str_feedback_subtime}</u>
                    <if condition="$condition_arr['stype'] eq 'datetime' and $searchlist['sval'] eq 'asc'">
                        <em class="list_sort_asc "></em>
                        <elseif condition="$condition_arr['stype'] eq 'datetime' and $searchlist['sval'] eq 'desc'" />
                        <em class="list_sort_desc "></em>
                        <else />
                        <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                    </if>
                </span>
                </a>
                <span class="span_span6">{$T->str_feedback_terminal}</span>
            </div>
            <foreach name="list" item="val">
                <div class="feedbacksection_list_c list_hover js_x_scroll_backcolor">
                    <span class="span_span1" title="{$val['realname']}">{$val['realname']}</span>
                    <span class="span_span2" title="{$val['mobile']}">{$val['mobile']}</span>
                    <span class="span_span3" title="{$val['content']|htmlspecialchars=###}">{$val['content']|htmlspecialchars=###}</span>
                    <span class="span_span5"><?php echo date('Y-m-d H:i:s',strtotime("+8 hour",strtotime($val['datetime']) ) ); ?></span>
                    <span class="span_span6" title="{$val['type']}">{$val['type']}</span>
                </div>
            </foreach>
        </div>
        <div class="appadmin_pagingcolumn">
<!--             <div class="feedbacksection_bin"> -->
<!--                 <span class="span_span11"><i class=""></i>{$T->str_extend_selectall}</span> -->
<!--                 <span class="em_del" id="js_del">{$T->str_extend_delete}</span> -->
<!--             </div> -->
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
        </div>
    </div>
</div>

<script>
    var js_feedback_warning_delfield = "{$T->str_feedback_warning_delfield}";
    $(function(){

        $.extends.feedback();
        $.extends.init();

    });

</script>

