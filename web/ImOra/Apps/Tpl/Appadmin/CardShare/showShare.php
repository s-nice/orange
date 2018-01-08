<layout name="../Layout/Layout"/>
<div class="share_card_body">
    <div class="share_auto">
        <div class="share_title">
            <span>{$T->str_card_share_original_order}：<span>{$shareaccount}</span></span>
        </div>
        <div class="share_user_title on">{$T->str_card_share_account}</div>
        <div class="share_card_title" shareid="{$shareid}">{$T->str_card_share_card}</div>
        <div class="page js_user_page">
            {$pagedata}
        </div>
        <div class="page js_card_page" style="display: none">
            {$pagedata}
        </div>
        <div class="clear"></div>
        <!--账号列表-->
        <div class="share_user_list">
            <div class="Journalsection_list_name  ">
                <span class="span_span2" style="width: 14%"></span>
                <span class="span_span2" style="width: 27%">{$T->str_card_share_no}</span>
                <span class="span_span3" style="width: 27%">{$T->str_card_share_id}</span>
                <span class="span_span4" style="width: 27%">{$T->str_card_share_name}</span>
            </div>
            <foreach name="list" item="vo">
                <div class='Journalsection_list_c list_hover js_x_scroll_backcolor'>
                    <span class="span_span2" style="width:14%"></span>
                    <span class="span_span2" style="width: 27% " title="{:$start+1}">{:$start+1+$key}</span>
                    <span class="span_span3" style="width: 27%" title="{$vo.account}">{$vo.account}</span>
                    <span class="span_span4" style="width: 27%" title="{$vo.realname}">{$vo.realname}</span>
                </div>

            </foreach>

        </div>
        <!--名片列表-->
        <div class="share_card_list">
            <div class="scanner_gdtiao">
                <div class="scanner_maxwidth_share js_share_card_list">
                    <div class="scannersection_listshare_name">
                        <span class="span_span11"></span>
                        <span class="span_span1">{$T->str_card_share_img}</span>
                        <span class="span_span2">{$T->str_card_share_user_name}</span>
                        <span class="span_span3">{$T->str_card_share_name}</span>
                        <span class="span_span6">{$T->str_card_share_phone}</span>
                        <span class="span_span5">{$T->str_card_share_title}</span>
                        <span class="span_span8">{$T->str_card_share_company_name}</span>
                        <span class="span_span6">{$T->str_card_share_department}</span>
                        <span class="span_span8">{$T->str_card_share_mail}</span>
                        <span class="span_span8">{$T->str_card_share_company_address}</span>
                        <span class="span_span2" style="margin-right:20px;">{$T->str_card_share_tel}</span>
                        <span class="span_span12">{$T->str_card_share_scan_time}</span>
                    </div>
                </div>
            </div>
            <div class="page js_user_page">
                <include file="@Layout/pagemain"/>
            </div>
            <div class="page js_card_page" style="display: none">
                {$pagedata}
            </div>

        </div>
        <!-- 图片点击预览-->
        <div class="Check_comment_pop js_preview_morepic" style='display:none;z-index: 102'>
            <div class="Check_comment_close js_btn_close">
                <img class="cursorpointer js_btn_channel_cancel" src="__PUBLIC__/images/appadmin_icon_close.png"/></div>
            <div class="Check_commentpop_c">
                <div class="Checkcomment_title">{$T->str_news_review}</div>
                <div class="appadmincomment_np">
                </div>
                <div class="show_name_card" style="max-height: 600px;">
                    <div class="Check_commentpop_img js_moreimages_content">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <include file="CardShare/variable"/>
</div>