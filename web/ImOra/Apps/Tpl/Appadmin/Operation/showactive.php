<style>
    .activity_view_span2 ee{margin-right: 10px;}
</style>
<div class="Check_showinfo_pop js_review_box js_btn_new_preview">
    <div class="Check_comment_close js_btn_close"><img class="cursorpointer js_btn_channel_cancel" src="__PUBLIC__/images/appadmin_icon_close.png"/></div>
    <div class="Check_commentpop_c">
        <div class="Checkcomment_title">{$T->str_news_review}</div>
        <if condition="$isone eq 0">
        <div class="appadmincomment_np">
            <span class="prev_span left" id='js_btn_preview_prev'>&lt; {$T->str_news_review_prev}</span>
            <span class="next_span right" id='js_btn_preview_next'>{$T->str_news_review_next}  &gt;</span>
        </div>
        </if>
        <div class="js_new_summey">

            <div class="Check_commentpop_img js_commentpop_img"><img id="js_show_img" class="js_title_img"
                                                                     src="{$data.image}"/>
            </div>
            
            <div class="activity_view">
                <h2 class="js_title" id="js_show_title">{$data.title}</h2>
                <div class="i_em">
                    <span id="js_show_city" class="activity_view_span1" title="{$cityNames}">地区: <ee>{$cityNames}</ee></span>
                    <span id="js_show_cate" class="activity_view_span2" title="{$industryNames}">行业: <ee>{$industryNames}</ee></span>
                </div>
                <div class="i_em">
                    <span id="js_show_job" class="activity_view_span1" title="{$jobNames}">职能: <ee>{$jobNames}</ee></span>
                    <span id="js_show_adminname" class="activity_view_span2" title="{$data.name}">创建者: <ee>{$data.name}</ee></span>
                </div>
                <div class="i_em">
                    <span id="js_show_btime" class="activity_view_span1" title="{$data.func}">推送时间: <ee>{:date('Y-m-d H:i',$data['pushtime'])}</ee></span>
                    <span id="js_show_regtime" class="activity_view_span2">注册时间: <ee class="js_ee_lt" <if condition="!isset($regtime_lt)">style="display:none;"</if>>小于等于<e class="js_e_lt">{$regtime_lt}</e>天</ee><ee class="js_ee_gt" <if condition="!isset($regtime_gt)">style="display:none;"</if>>大于等于<e class="js_e_gt">{$regtime_gt}</e>天</ee></span>
                </div>
                <div id="js_show_con" class="js_content1" style='padding-right: 10px;'>
                    {$data.content}
                </div>
            </div>

        </div>

    </div>
</div>