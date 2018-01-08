<!-- 评论预览 弹出框 start -->
<div class="appaddmin_comment_pop" style='display: none;'>
    <div class="appadmin_comment_close"><img class="cursorpointer js_btn_channel_cancel"
                                             src="__PUBLIC__/images/appadmin_icon_close.png"/></div>
    <div class="appadmin_commentpop_c">
        <div class="appadmincomment_title">预览</div>
        <div class="appadmincomment_np">
            <span class="prev_span left hand" id='comment_prev'>上一篇</span>
            <span class="next_span right hand" id='comment_next'>下一篇</span>
        </div>
        <div class="appadmincomment_content">
            <p>
                实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病实际这个是社会的诟病</p>
        </div>
        <div class="appadmincomment_btn section_bin1">
            <span id="js_comment_pass2" class='hand'><i>{$T->str_audit_success}</i></span>
            <span id="js_comment_reject2" class='hand'><i>{$T->str_audit_faild}</i></span>
        </div>
    </div>
</div>
<!-- 评论预览 弹出框  end -->

<!--资讯问答  图片点击预览-->
<div class="Check_comment_pop js_preview_morepic" style='display:none;'>
    <div class="Check_comment_close js_btn_close"><img class="cursorpointer js_btn_channel_cancel"
                                                       src="__PUBLIC__/images/appadmin_icon_close.png"/></div>
    <div class="Check_commentpop_c">
        <div class="Checkcomment_title">{$T->str_news_review}</div>
        <div class="appadmincomment_np">
            <span class="prev_span left js_prev_pic">&lt; {$T->str_pop_prev_pic}</span>
            <span class="next_span right js_next_pic">{$T->str_pop_next_pic} &gt;</span>
        </div>
        <div class="" style="max-height: 600px;">
            <div class="Check_commentpop_img js_moreimages_content">

            </div>

        </div>
    </div>
</div>

<!-- 待审核咨询预览 弹出框 start -->
<div class="Check_comment_pop js_review_box js_btn_new_preview" style='display: none; z-index: 9999;height:1300px;'>
    <div class="Check_comment_close js_btn_close"><img class="cursorpointer js_btn_channel_cancel"
                                                       src="__PUBLIC__/images/appadmin_icon_close.png"/></div>
    <div class="Check_commentpop_c clear">
        <div class="Checkcomment_title">{$T->str_news_review}</div>
        <div class="appadmincomment_np">
            <span class="prev_span left" id='js_btn_preview_prev'>&lt; {$T->str_news_review_prev}</span>
            <span class="next_span right" id='js_btn_preview_next'>{$T->str_news_review_next}  &gt;</span>
        </div>
        <div class="js_new_summey" style="max-height: 950px;">
            <div class="Check_commentpop_img js_commentpop_img"><img class="js_title_img"
                                                                     src="__PUBLIC__/images/Check_content_img.jpg"/>
            </div>
            <div class="Check_summey">
                <h2 class="js_title"></h2>
                <div class="i_em" class="js_source"><i class="js_category" cate-id="">互联网金融</i><em class="js_time">11:21pm</em>
                </div>
                <div class="js_content1 a_color" style='padding-right: 10px;'></div>
            </div>

        </div>
     <!--   <div class="Check_bin">
            <input class="dropout_inputr cursorpointer js_successone big_button" type="button" value="{//$T->str_audit_success}"
                   id="js_set_audit"/>
            <input class="dropout_inputl cursorpointer js_failone" type="button" value="{//$T->str_audit_faild}"
                   id="js_not_publish"/>
            <input class="dropout_inputl cursorpointer js_add_sub big_button" type="button" value="{//$T->str_new_del}"
                   id="js_new_del"/>
        </div>-->
    </div>
</div>
<!-- 待审核咨询预览 弹出框  end -->

<!-- 待审核咨询预览编辑 弹出框 start -->
<div class="Check_comment_pop js_new_edit_publish" style='display: none;overflow-x: hidden;overflow-y: auto;'>
    <div class="Check_comment_close js_btn_close"><img class="cursorpointer js_btn_channel_cancel"
                                                       src="__PUBLIC__/images/appadmin_icon_close.png"/></div>
    <div class="Check_commentpop_c">
        <div class="Checkcomment_title">{$T->str_news_eidt_review}</div>
        <!--		<div class="appadmincomment_np">-->
        <!--			<span class="prev_span left" id='comment_prev'>&lt; 上一篇</span>-->
        <!--			<span class="next_span right" id='comment_next'>下一篇  &gt;</span>-->
        <!--		</div>-->
        <div class="Administrator_keyword"><span>{$T->str_news_title}</span>
            <input type="text" class="new_edit_title" id="js_title" maxlength="128"/></div>
        <div class="Administrator_keyword"><span>作者</span><input type="text" value="" id="js_titleauthor" maxlength="32"></div>
        <div class="Administrator_keyword"><span>{$T->str_news_title_pic}</span>
            <!-- 文件表单 -->
            <form id="" action="{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/uploadFileTmp')}" method="post"
                  enctype="multipart/form-data" target="hidden_upload">
                <input type="hidden" name="newuploadpic" id="newuploadpic" value="newEditUpload"/>
                <input type="text" id="js_new_file_path" name="js_new_file_path"
                       value="{$T->str_news_click_uploadpic}"/>
                <input class="button_input " type="button" value="{$T->str_newpicture_upload}"/>
                <img style="max-width: 100px;display: none;" id="title_pic" src="">
                <input type="file" class="file js_new_edit_file" name="newEditUpload" id="newEditUpload"/>
            </form>
            <!--        <form id="upload_logo" target="hidden_from1" enctype="multipart/form-data" method="post" action="{:U('Home/Sns/uploadfile')}">
                        <input type="text" name="uploadpic" id="uploadpic" hid="uploadImgField1" value="{$T->str_news_click_uploadpic}"/>
                        <input type="button" class="logobutton" value="{$T->str_newpicture_upload}" />
                        <input type="file"  name="uploadImgField1" id="uploadImgField1" style="opacity: 0; filter:alpha(opacity:0); position:absolute; right:209px; top:1px; width:60px; height:44px;"/>
                        <img src="" id="title_pic" style="max-width: 100px; display: none;margin-left: -460px;margin-top: 50px;"/>
                    </form>-->
        </div>
        <div class="Administrator_keyword">
            <span>标签</span><input type="text" value="" id="js_label">
            <div id="selected_labels" class="display_label" ></div>
        </div>
        <div class="Administrator_select">
            <span>所属行业</span>
                <input type="text" class="js_new_catebtn_show" value=""
                       seltitle="" id="js_titlevalue" readonly="true"/>
            <em id="js_seltitle"><img src="__PUBLIC__/images/appadmin_icon_xiala.png"/></em>
            <ul id="js_selcontent" class="js_new_cate_list" style="height:150px;">
            </ul>
        </div>
        <div class="Administrator_keyword"><span>{$T->str_news_webfrom}</span><input type="text" id="js_webfrom"/></div>
        <div class="Administrator_keyword"><span>{$T->str_news_releasetime}</span><input type="text" readonly
                                                                                         id="js_releasetime"/></div>
        <div class="Administrator_textarea">

            <!-- 文件表单 -->
            <!--            <form id="" action="{:U('Home/Sns/uploadfile')}" method="post" enctype="multipart/form-data" target="hidden_upload" style='position: relative;'>-->
            <!--                <input type="hidden" name="newuploadpic" id="newuploadpic" value="newUploadImgField"/>-->
            <!--                <input type="file" name="newUploadImgField" id="newUploadImgField" style="display:block;z-index:10;left:116px;opacity:0;position:absolute;top:10px;width:17px;" />-->
            <!--                <input type="text" style="display:none" name="newUploadImgBtn" id="newUploadImgBtn" value="" />-->
            <!--            </form>-->
            <span>{$T->str_news_content}</span>
            <div class="textarea_right">
                <!--                <div class="textarea_title"><i style="display:none;;"><img src="__PUBLIC__/images/editor_img_icon_w.png" /></i><em class="js_upload_img"><img src="__PUBLIC__/images/editor_img_icon_p.png" /></em></div>-->
                <div class="js_content" id="js_content"
                     style="height:300px; word-break: break-all;overflow-y: auto;"></div>
            </div>
        </div>
        <div class="Check_bin">
            <input id="js_review_now" class="dropout_inputr cursorpointer big_button" type="button" value="预览"/>
            <input class="dropout_inputr cursorpointer js_edit_pushlish_save big_button" type="button" value="暂存"
                   style="display: none"/>
            <input class="dropout_inputr cursorpointer js_publish_toaudit big_button" type="button"
                   value="{$T->str_news_publish_audit}"/>
            <input class="dropout_inputr cursorpointer js_edit_pushlish_cancel big_button" type="button" value="取消"/>

        </div>
    </div>
</div>
<!-- 待审核咨询预览编辑 弹出框 end -->

<!-- 推送设置地区弹框 start-->
<div class="get_comment_pop js_push_news_region_pop" popName='region' style="display: none">
    <div class="get_comment_close "><img class="cursorpointer js_btn_channel_cancel"
                                         src="__PUBLIC__/images/appadmin_icon_close.png"/></div>
    <div class="getproblem_title">选择地区</div>
    <if condition="isset($provinces)">
        <div class="getproblem_content">
            <div class="get_s_title">省/直辖市</div>
            <div class="get_s_list js_provinces_wrap">
                <foreach name="provinces" item="vo" key="k">
                    <label class="label_1-5 '">
                        <input class="js_set_province" name="Fruit" type="checkbox" value="{$vo.code}"/>
                        <span>{$vo.name}</span>
                    </label>
                </foreach>
            </div>
            <div class="get_shi_title">市</div>
            <div class="get_shi_list js_set_city_wrap " style="overflow: hidden">
                <div id="city_list"></div>
                <!-- <label class="label_1-5 "><input name="Fruit" type="checkbox" value="" />北京市</label>-->
            </div>
            <div class="get_list_btn">
                <input class="problem_inputr js_set_city_confirm" type="button" value="确认"/>
                <input class="problem_inputl js_set_city_cancel" type="button" value="取消"/>
            </div>
        </div>
    </if>
</div>

<!-- 推送设置地区弹框 end-->

<!-- 推送设置行业弹框 start-->
<div class="get_comment_pop js_push_news_category_pop" popName='category' style="display: none">
    <div class="get_comment_close "><img class="cursorpointer js_btn_channel_cancel"
                                         src="__PUBLIC__/images/appadmin_icon_close.png"/></div>
    <div class="getproblem_title">选择行业</div>
    <if condition="isset($industryList)">
    <div class="getproblem_content">
        <div class="get_s_title">一级分类</div>
        <div class="get_s_list js_first_menu_list"">
            <foreach name="industryList" item="vo" key="k">
                <if condition="$vo.parentid eq '0' AND $vo.type eq 1">
                    <label class="label_1-5 ">
                        <input class="js_set_category" name="Fruit" type="checkbox" value="{$vo.categoryid}"/>
                        <span>{$vo.name}</span>
                    </label>
                </if>
            </foreach>
        </div>
        <div class="get_shi_title">二级分类</div>
        <div class="get_shi_list js_set_category_wrap">
        <foreach name="industryList" item="vo" key="k">
            <if condition="$vo.parentid neq '0'">
                <label class="label_1-5 js_set_second_label " style="display: none" parentid="{$vo.parentid }">
                    <input class="js_set_second_category" name="Fruit" type="checkbox" value="{$vo.categoryid}"
                           parentid="{$vo.parentid }"/>
                    <span>{$vo.name}</span>
                </label>
            </if>
        </foreach>


        </div>
        <div class="get_list_btn">
            <input class="problem_inputr js_set_category_confirm" type="button" value="确认"/>
            <input class="problem_inputl js_set_category_cancel" type="button" value="取消"/>
        </div>
    </div>
        </if>
</div>
<!-- 推送设置行业弹框 end-->


<!-- 推送设置职能弹框 start-->
<div class="get_comment_pop js_push_news_job_pop" popName="job" style="display: none">
    <div class="get_comment_close "><img class="cursorpointer js_btn_channel_cancel"
                                         src="__PUBLIC__/images/appadmin_icon_close.png"/></div>
    <div class="getproblem_title">选择职能</div>
    <if condition="isset($industryList) ">
        <div class="getproblem_content">
            <div class="get_s_title">行业</div>
            <div class="get_s_list js_first_menu_list">
                <foreach name="industryList" item="vo" key="k">
                    <if condition="$vo.parentid eq '0'"><!--一级行业列表-->
                        <label class="label_1-5 '">
                            <input class="js_set_industry" name="Fruit" type="checkbox" value="{$vo.categoryid}"/>
                            <span>{$vo.name}</span>
                        </label>
                    </if>
                </foreach>
            </div>
            <div class="get_shi_title">职能</div>
            <div class="get_shi_list js_set_job_wrap">
                <foreach name="positionsList" item="vo" key="k"> <!--全部职能列表-->
                    <label class="label_1-5 js_set_job_label " style="display: none" parentid="{$vo.parentid }">
                        <input class="js_set_job" name="Fruit" type="checkbox" value="{$vo.categoryid}" parentid="{$vo.parentid }"/>
                        <span>{$vo.name}</span>
                    </label>
                </foreach>
            </div>

            <div class="get_list_btn">
                <input class="problem_inputr js_set_job_confirm" type="button" value="确认"/>
                <input class="problem_inputl js_set_job_cancel" type="button" value="取消"/>
            </div>
        </div>

    </if>
</div>
<!-- 推送设置职能弹框 end-->


<!-- 弹出框， 选择标签 : 默认隐藏-->
<div style="display:none;" id="popChooseItem" class="addcomment_pageContent">
    <div class="layer_title"><h1>选择标签</h1><i class="js_close">x</i></div>
    <!-- 搜索框 -->
    <div class="js_select_item">
        <input class="btn_label" id="clickChoose" style="margin-right:3px;" type="button" value="确定"/>
        <label for="js_keyword">标签</label>
        <input class="textinput_search cursorpointer" type="text" id="js_keyword" value=""/>
        <input class="btn_label" id="clickSearch" type="button" value="搜索">
    </div>

    <div id="labelsList"></div>
</div>
