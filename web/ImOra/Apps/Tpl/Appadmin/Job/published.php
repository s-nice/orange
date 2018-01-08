<layout name="../Layout/Layout" />
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
        	<div class="unpublished_top">
	        	<div class="section_bin">
	<!--                 <span class="span_span11"><i class="" id="js_allselect"></i>{$T->str_news_selectall}</span> -->
	                <span id="js_unpublishjob" class='hand'><i>{$T->str_job_unpublish}</i></span>
	            </div>
	            <!-- 翻页效果引入 -->
	            <include file="@Layout/pagemain" />
	        </div>
            <div class="unpublished_list_name">
            	<span class="span_span11"></span>
            	<span class="span_span1">{$T->str_job_title}</span>
            	<span class="span_span2 hand" id='sort_starttime'>
                    <u>{$T->str_job_start_end_time}</u>
                    <if condition="$sort_key eq 'start_date'">
                        <if condition="$sort_type eq 'asc'">
                            <em class="list_sort_asc"></em>
                        <else/>
                            <em class="list_sort_desc"></em>
                        </if>
                    <else/>
                        <em class="list_sort_none"></em>
                    </if>
            	</span>
            	<span class="span_span3 hand" id='sort_sort'>
                    <u>{$T->str_job_sort}</u>
                    <if condition="$sort_key eq 'sort'">
                        <if condition="$sort_type eq 'asc'">
                            <em class="list_sort_asc"></em>
                        <else/>
                            <em class="list_sort_desc"></em>
                        </if>
                    <else/>
                        <em class="list_sort_none"></em>
                    </if>
                </span>
            	<span class="span_span5">{$T->str_job_user}</span>
            	<span class="span_span6">{$T->str_job_lang}</span>
            	<span class="span_span4">{$T->str_job_do}</span>
            </div>
            <if condition="$rstCount neq 0">
                <foreach name="list" item="val">
                    <div class="unpublished_list_c list_hover js_x_scroll_backcolor">
                        <span class="span_span11" content="{$val.content}"><i class="js_select" val="{$val['id']}"></i></span>
                        <span class="span_span1" title="{$val.title}">{$val.title}</span>
                        <span class="span_span2">{$val.start_date}--{$val.end_date}</span>
                        <span class="span_span3">{$val.sort}</span>
                        <span class="span_span5" title="{$val.admin_name}">{$val.admin_name}</span>
                        <span class="span_span6" val="{$val.lang}">{$val.lang_name}</span>
                        <span class="span_span4"><i class="js_successone jobedit hand">{$T->str_job_edit}</i>/<i class='jobdelete hand'>{$T->str_job_delete}</i></span>
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
<script type="text/javascript">
var str_job_verify_date    = "{$T->str_job_verify_date}";
var str_job_verify_sort    = "{$T->str_job_verify_sort}";
var str_job_verify_content = "{$T->str_job_verify_content}";
var str_job_confirm        = "{$T->str_job_confirm}";
var str_job_choose_data    = "{$T->str_job_choose_data}";
var str_job_verify_title   = "{$T->str_job_verify_title}";

var str_job_verify_date_compare = "{$T->str_job_verify_date_compare}";

var str_btn_ok     = "{$T->str_btn_ok}";
var str_btn_cancel = "{$T->str_btn_cancel}";

var url_base      = "{:U('Appadmin/Job/published')}";
var url_doaddjob  = "{:U('Appadmin/Job/doAddJob')}";
var url_doeditjob = "{:U('Appadmin/Job/doEditJob')}";
var url_deljob    = "{:U('Appadmin/Job/dodelete')}";
var url_dopublish = "{:U('Appadmin/Job/dopublish')}";
</script>
<include file="unlockpop" />