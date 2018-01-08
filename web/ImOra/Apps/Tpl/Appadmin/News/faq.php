<layout name="../Layout/Layout" />
<include file="head" />
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="content_search">
                <div class="right_search">
                	<div class="serach_name js_select_item">
                	   <!-- 
        				<span class="span_name">
                            <if condition="$params['type'] eq 'question'">
                                <input type="text" value="{$T->str_faq_question}" seltitle="question" id="js_titlevalue" readonly="true" title="{$T->str_faq_question}"/>
                            <elseif condition="$params['type'] eq 'answer'"/>
                                <input type="text" value="{$T->str_faq_answer}" seltitle="answer" id="js_titlevalue" readonly="true" title="{$T->str_faq_answer}"/>
                            <else/>
                                <input type="text" value="{$T->str_faq_question}" seltitle="question" id="js_titlevalue" readonly="true" title="{$T->str_faq_question}"/>
                            </if>
                        </span> 
                        
                        
                        <em id="js_seltitle" class='hand' ><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>-->
                        <label>{$T->str_faq_question}：</label>
                        <input class="textinput cursorpointer" type="text" id="js_selkeyword" value="{$params['keyword']}"/>
                        
                        <ul id="js_selcontent">
                            <li val="question" title="{$T->str_faq_question}">{$T->str_faq_question}</li>
                            <!-- <li val="answer" title="{$T->str_faq_answer}">{$T->str_faq_answer}</li> -->
                        </ul>
                    </div>
                    
                    <div class="serach_but">
                        <input class="butinput cursorpointer" type="button" value="" id="js_searchbutton2"/>
                    </div>
                </div>
            </div>
            <div class="appadmin_pagingcolumn">
	            <div class="section_bin">
	                <!-- <span class="span_span11"><i class="hand" id="js_allselect"></i>{$T->str_news_selectall}</span> -->
	                <span id='js_addfaq' class='hand'><i>{$addtitle}</i></span>
	            </div>
		            <!-- 翻页效果引入 -->
            	<include file="@Layout/pagemain" />
	        </div>
            <div class="faq_list_name">
                <!-- <span class="span_span11"></span> -->
                <span class="span_span1">{$T->str_faq_question}</span>
                <span class="span_span2">{$T->str_faq_answer}</span>
                <!-- 
                <if condition="$params['order'] eq 'sort'">
                    <if condition="$params['ordertype'] eq 'asc'">
                        <span class="span_span5" id="js_orderbysort" type="{$params['ordertype']}"><u>{$T->str_faq_sort}</u><em class="list_sort_asc"></em></span>
                    <else/>
                        <span class="span_span5" id="js_orderbysort" type="{$params['ordertype']}"><u>{$T->str_faq_sort}</u><em class="list_sort_desc"></em></span>
                    </if>
                    <else/>
                    <span class="span_span5" id="js_orderbysort" type="desc"><u>{$T->str_faq_sort}</u><em class="list_sort_none"></em></span>
                </if> -->
                <span class="span_span3" type="desc"><u>{$T->str_faq_sort}</u></span>
                <span class="span_span4">{$T->str_faq_do}</span>
            </div>
            <if condition="$rstCount neq 0">
                <foreach name="list" item="val">
                    <div class="faq_list_c list_hover js_x_scroll_backcolor" qid="{$val['questionid']}">
                        <!-- <span class="span_span11" content="{$val.content}"><i class="js_select" val="{$val['id']}"></i></span> -->
                        <span class="span_span1" title="{$val.question}">{$val.question}</span>
                        <span class="span_span2" title="{$val.answer}">{$val.answer}</span>
                        <span class="span_span3">{$val.sort}</span>
                        <span class="span_span4"><i class="js_successone faqedit hand">{$T->str_faq_edit}</i>/<i class='faqdelete hand'>{$T->str_faq_delete}</i></span>
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

    var str_faq_verify_sort     = "{$T->str_faq_verify_sort}";
    var str_faq_verify_answer   = "{$T->str_faq_verify_answer}";
    var str_faq_confirm         = "{$T->str_faq_confirm}";
    var str_faq_verify_question = "{$T->str_faq_verify_question}";

    var str_faq_verify_question_length = "{$T->str_faq_verify_question_length}"
    var str_faq_verify_answer_length   = "{$T->str_faq_verify_answer_length}"
            
    var str_btn_ok      = "{$T->str_btn_ok}";
    var str_btn_cancel  = "{$T->str_btn_cancel}";
    var str_intro_leave = "{$T->str_intro_leave}";
    
    var typeid     = "{$typeid}";
    var searchurl  = '{$currentUrl}';
    var url_dofaq  = "{:U('Appadmin/News/doFaq')}";
    var url_delfaq = "{:U('Appadmin/News/deleteFaq')}";
    $(function(){
    	$.faq.init();
    })

</script>
<!-- 添加常见问题弹出框 star -->
<div class="faq_comment_pop" style='display: none;'>
	<div class="faq_comment_close"><img class="cursorpointer js_btn_channel_cancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
	<div class="faq_commentpop_c">
        <form>
        <input type="hidden" name="questionid" value=''/>
		<div class="faqcomment_title">{$T->str_faq_add}</div>
		<div class="Administrator_password"><span>{$T->str_faq_question}</span><input type="text" name="question" /></div>
		<div class="Administrator_usertext"><span>{$T->str_faq_answer}</span><textarea rows="" cols="" name='answer'></textarea></div>
		<div class="Administrator_password"><span>{$T->str_faq_sort}</span><input type="text" name="sort" value=""  /></div>
		</form>
		<div class="faq_bin">
			<input class="dropout_inputr big_button cursorpointer js_add_cancel" type="button" value="{$T->str_extend_cancel}" />
			<input class="dropout_inputl big_button cursorpointer js_add_sub" type="button" value="{$T->str_extend_submit}" />
		</div>
		
	</div>
</div>
<!-- 添加常见问题弹出框 end -->