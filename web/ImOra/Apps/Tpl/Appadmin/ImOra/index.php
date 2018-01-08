<layout name="../Layout/Layout"/>
<style>
    /*插件的图片路径（没用，为了防止报错）*/
    .uploadify-queue-item .cancel a {
        background: url('__PUBLIC__/js/jsExtend/uploadify/uploadify-cancel.png') 0 0 no-repeat;
    }
   /*上传框 */
    .ehdel_upload_show{
        float: left;
    }
    /*上传按钮*/
    #ehdel_upload_btn{
        float: right;
    }
   /**/
    #upload_show {
        display: none;
    }
    /*插件生成*/
    #ehdel_upload_text,.swfupload{
        height: 26px !important;
        width: 175px !important;
        z-index: 3 !important;
    }
    /*插件生成的对象*/
    .swfupload{
        position: relative !important;
    }
    /*插件自带的按钮隐藏掉不用*/
    .uploadify-button{
        display: none;
    }
    /*进度条，和提示框 重合*/
    #uploadMsg,#proUpload{
        display: block;
        position: absolute;
        height: 26px;
        width: 175px;
        margin: 0px;
        text-align:center;
        color: #a0a0a0;
        z-index: 2;
    }
    /*进度条*/
    #proUpload{
        display: none;
        color:#444;
        border: none;
        z-index: 1;
        overflow: hidden;

    }
    /*弹出框加高*/
    .appadmin_ThemesUpload{
        height: 420px;
    }

    /*进度条兼容*/
    progress::-moz-progress-bar { background: #444; }
    progress::-webkit-progress-bar { background: #444; }
    progress::-webkit-progress-value  { background: #444; }
</style>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c" id="content_c">
            <div class="content_search">
                <div class="section_bin">
                     <span class="span_span11"><i class="" id="js_allselect"></i>{$T->str_extend_selectall}</span>
                     <div class="Journalleft_bin js_add_app_btn" id="addbtn">{$T->imora_theme_add_software_package}</div>
                     <span class="js_delTheme"><i>{$T->str_extend_delete}</i></span>
                </div> 
                <!-- 翻页效果引入 -->
                <include file="@Layout/pagemain"/>
            </div>
            <div class="Journalsection_list_name">
                <span class="span_span11"></span>
                <span class="span_span1">{$T->imora_theme_no}</span>
                <span class="span_span1 js_sort" action="version,asc"><u>{$T->imora_theme_add_version}</u>
                    <if condition="(isset($_GET['sort'])) AND ($_GET['sort'] eq 'version,asc')">
                        <em class="list_sort_asc "></em>
                        <elseif condition=" (isset($_GET['sort'])) AND ($_GET['sort'] eq 'version,desc')" />
                        <em class="list_sort_desc "></em>
                        <else />
                        <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                   </if>
                </span>
                <span class="span_span1">{$T->imora_theme_install}</span>
                <span class="span_span1">{$T->imora_theme_add_name}</span>
                <span class="span_span1">{$T->imora_theme_add_author}</span>
                <span class="span_span1 js_sort" action="size,asc"><u>{$T->imora_theme_size}</u>
                   <if condition="(isset($_GET['sort'])) AND ($_GET['sort'] eq 'size,asc')">
                       <em class="list_sort_asc "></em>
                       <elseif condition="(isset($_GET['sort'])) AND ($_GET['sort'] eq 'size,desc')" />
                       <em class="list_sort_desc "></em>
                       <else />
                       <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                   </if>
                </span>
                <span class="span_span1">{$T->imora_theme_upload_record}</span>
                <span class="span_span1 js_sort" action="createtime,asc"><u>{$T->imora_theme_upload_time}</u>
                    <if condition="(isset($_GET['sort'])) AND ( $_GET['sort'] eq  'createtime,asc')">
                        <em class="list_sort_asc "></em>
                        <elseif condition="(isset($_GET['sort'])) AND ( $_GET['sort'] eq 'createtime,desc')" />
                        <em class="list_sort_desc "></em>
                        <else />
                        <em class="list_sort_asc list_sort_desc list_sort_none"></em>
                    </if>
                </span>

            </div>
            <div id="themeList">
                <if condition="is_array($list) && count($list)">
                    <foreach name="list" item="item" key="k">
                        <div class="Journalsection_list_c">
                            <span class="span_span11"><i class="js_select" val="{$item['id']}"></i></span>
                            <span class="span_span1">{$k+$start+1}</span>
                            <span class="span_span1 " title="{$item.version}">{:cutstr($item['version'],6)}</span>
                            <span class="span_span1 themeZip" title='{:basename($item["url"])}'>
                                {:cutstr( basename($item['url']),5)}
                            </span>
                            <span class="span_span1"title="{$item.name}">{:cutstr($item['name'],9)}</span>
                            <span class="span_span1 "title="{$item.author}">{:cutstr($item['author'],9)}</span>
                            <span class='span_span1' title="{:floatval($item['size']).'M'}">{: floatval($item['size'])}M</span>
                            <span class="span_span1"title="{$item.content}">{:cutstr($item['content'],9)}</span>
                 <span class='span_span1 addTime ' title="{:date('Y-m-d',$item['createtime'])}">
                 {:date('Y-m-d',$item['createtime'])}
                 </span>
                        </div>
                    </foreach>
                    <div class="appadmin_pagingcolumn">
                        <!-- 翻页效果引入 -->
                        <include file="@Layout/pagemain"/>
                    </div>
                    <else />
                    <div class="clist_c_listdl_title">
                        <span>No data</span>
                    </div>
                </if>
            </div>
        </div>
    </div>
</div>
<!-- 主题上传 弹出框 -->
<div class="appadmin_ThemesUpload js_add_app_popup popup_window">
    <div class="appadmin_unlock_close"><img class="cursorpointer js_logoutcancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
    <div class="Administrator_pop_c">
        <div class="Administrator_title">{$T->imora_theme_upload}</div>
        <div class="Administrator_user"><span>{$T->imora_theme_add_version}</span><input type="text" id="addThemeVersion" class="js_Themes_Upload_val" name="version"/></div>
        <div class="Administrator_user"><span>{$T->imora_theme_add_name}</span><input type="text" id="addThemeName" class="js_Themes_Upload_val" name="name"/></div>
        <div class="Administrator_user"><span>{$T->imora_theme_add_author}</span><input type="text"id="addThemeAuthor" class="js_Themes_Upload_val"name="author" /></div>
        <div class="Administrator_user"><span>{$T->imora_theme_add_content}</span><input type="text"id="addThemeContent" class="js_Themes_Upload_val"name="content" /></div>
        <div class="Administrator_ruanjian">
            <span>{$T->imora_theme_add_software}</span>
            <div class="ehdel_upload_show">
                <span id="uploadMsg">{$T->imora_theme_add_select_file}</span>
                <progress value="0" max="100" id="proUpload"></progress>
                <input id="ehdel_upload_text" type="text" name="txt"/>
                <input id="ehdel_upload_btn" type="button" value="{$T->imora_theme_add_upload_file}" />
            </div>
            <div class="clear"></div>
        </div>
        <input type="hidden" id="addThemeSize"class="js_Themes_Upload_val" name="size">
        <input type="hidden" id="addThemeFileName" class="js_Themes_Upload_val" name="fileName">
        <div class="Administrator_bin Administrator_masttop">
            <input class="big_button js_logoutcancel" type="button" value="{$T->str_extend_cancel}" />
            <input id="subTheme" class="big_button js_logoutok" type="submit" value="{$T->str_extend_submit}" />
        </div>
    </div>
</div>
<script type="text/javascript">
    var gUrl= "{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/index')}";
    var gUploadThemeUrl = "{:U(MODULE_NAME.'/'.CONTROLLER_NAME.'/upLoadTheme')}";
    var p ='{$p}';
    var gSort='{$sort}';
    var gMaxSize='{$maxsize}';
    var gSwfPath ="__PUBLIC__/js/jsExtend/uploadify/uploadify.swf";
    var gSessionId = '{$sessionId}';
    var gSubmitFail='{$T->imora_theme_submit_fail}';//“提交失败”
    var gUploadFail='{$T->imora_theme_upload_fail}';//“上传失败”
    var gSubmitNull='{$T->imora_theme_submit_null}';//"主题信息不完整"
    var gDelThememsg=new Array('{$T->imora_theme_submit_del}',
                                '{$T->imora_theme_confirm}',
                                '{$T->imora_theme_cancel}' );//是否删除主题，确认，取消
</script>