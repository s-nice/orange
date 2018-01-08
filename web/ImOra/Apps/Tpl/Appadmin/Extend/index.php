<layout name="../Layout/Layout" />
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
                <div class="serach_but_right">
                    <form action="{:U('Appadmin/news/sensitive','',false)}" method="get" >
                    <input class="textinput" name='search_word' type="text" value="{$condition_arr['search_word']}" />
                    <input class="butinput cursorpointer" type="submit" value="" />
                    </form>
                </div>
            </div>
            <div class="appadmin_pagingcolumn">
	            <div class="feedbacksection_bin">
	                <span class="span_span11"><i class=""></i>{$T->str_extend_selectall}</span>
	                <span class="em_del" id="js_del">{$T->str_extend_delete}</span>
	                <div class="left_binadmin cursorpointer" id="js_addSensitive">{$T->str_addSensitive}</div>
                	<div class="left_binadmin cursorpointer" id="js_incSensitive">{$T->str_impSensitive}</div>
	            </div>
	            <!-- 翻页效果引入 -->
	            <include file="@Layout/pagemain" />
	        </div>
            <div class="extendsection_list_name">
                <span class="span_span11"></span>
                <span class="span_span1">{$T->str_extend_sensitive}</span>
                <!--<span class="span_span2">{$T->str_extend_replace}</span>-->
                <a href="{:U('/Appadmin/news/sensitive/stype/time',$condition_arr)}" >
                <span class="span_span3"><u>{$T->str_extend_time}</u>
                    <if condition="$stype eq 'time' and $condition_arr['sval'] eq 'asc'">
                        <em class="list_sort_asc "></em>
                        <elseif condition="$stype eq 'time' and $condition_arr['sval'] eq 'desc'" />
                        <em class="list_sort_desc "></em>
                        <else />
                        <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                    </if>
                </span>
                </a>
                <span class="span_span4">{$T->str_extend_manage}</span>
            </div>
            <foreach name="list" item="val">
                <div class="extendsection_list_c list_hover js_x_scroll_backcolor">
                    <span class="span_span11">
                        <i class="js_select" val="{$val['id']}"></i>
                    </span>
                    <span class="span_span1" title="{$val['illegalword']}">{$val['illegalword']}</span>
                    <span class="span_span3">{$val['time']|date='Y-m-d H:i:s',###}</span>
                    <span class="span_span4" data-id="{$val['id']}"><ii class="js_update_sensitive">{$T->str_extend_update}</ii>|<ii class="js_simp_del">{$T->str_extend_delete}</ii></span>
                </div>
            </foreach>
        </div>
        <div class="appadmin_pagingcolumn">
            <!-- 翻页效果引入 -->
            <include file="@Layout/pagemain" />
        </div>
    </div>
</div>
<div id="js_cloneDom"></div>
<!-- 添加敏感词 弹出框 -->
<div class="appadmin_Sensitivewords">
    <div class="appadmin_unlock_close"><img class="cursorpointer js_logoutcancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
    <div class="Administrator_pop_c">
        <div class="Administrator_title">{$T->str_addSensitive}</div>
        <div class="Sensitive_user"><span>{$T->str_extend_sensitive}</span><input id="js_sensitiveWord" type="text" /></div>
        <!--<div class="Sensitive_password"><span>{$T->str_extend_replace}</span><input id='js_replaceWord' type="text" /></div>-->
        <div class="Administrator_bin Administrator_masttop">
            <input class="dropout_inputr big_button cursorpointer js_canceladd" type="button" value="{$T->str_extend_cancel}" />
            <input class="dropout_inputl big_button cursorpointer js_addSensitivebtn" type="button" value="{$T->str_extend_submit}" />

        </div>
    </div>
</div>
<!-- 敏感词导入 弹出框 -->
<div class="appadmin_Import">
    <div class="appadmin_unlock_close"><img class="cursorpointer js_logoutcancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
    <div class="Administrator_pop_c">
        <div class="Administrator_title">{$T->str_impSensitive}</div>
        <div class="Import_Sensitivewords">
            <span>{$T->str_extend_sensitive}</span>
            <textarea id="js_imp_words"></textarea>
        </div>
        <div class="Import_text">{$T->str_extend_warning}</div>
        <div class="clear"></div>
        <div class="Administrator_bin Administrator_masttop">
            <input class="dropout_inputr big_button cursorpointer js_cancelimp" type="button" value="{$T->str_extend_cancel}" />
            <input class="dropout_inputl big_button cursorpointer js_impSensitivebtn" type="button" value="{$T->str_extend_submit}" />

        </div>
    </div>
</div>
<script>
    var delnewsurl = "{:U('/Appadmin/news/sensitive/',$delurl)}";
    var js_extend_warning_addsomething = "{$T->str_extend_warning_addsomething}";
    var js_extend_warning_addfield = "{$T->str_extend_warning_addfield}";
    var js_extend_warning_updfield = "{$T->str_extend_warning_updfield}";
    var js_extend_warning_exist = "{$T->str_extend_warning_exist}";
    var js_extend_warning_delfield = "{$T->str_extend_warning_delfield}";
    var js_extend_confirm_cancel = "{$T->str_extend_confirm_cancel}";
    var js_extend_warning_ok = "{$T->str_extend_warning_ok}";
    var js_extend_confirm = "{$T->str_extend_confirm}";
    var js_extend_warning_select = "{$T->str_extend_warning_select}";
    var js_extend_warning_sensitive_exist = "{$T->str_extend_warning_sensitive_exist}";
    var js_str_updSensitive = "{$T->str_updSensitive}"; //修改敏感词

    $(function(){
        $.extends.Sensitive();
    });
</script>
