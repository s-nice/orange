<layout name="../Layout/Layout" />
<style type="text/css">
.section_bin span{margin-right:20px!important;}
.appadmincomment_content p{font-size:12px!important;}
.appadmincomment_content p span{line-height: 150%;}
</style>
<div class="appaddmin_comment_pop" style='display: none;'>
	<div class="appadmin_comment_close"><img class="cursorpointer js_btn_channel_cancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
	<div class="appadmin_commentpop_c">
		<div class="appadmincomment_title">{$T->str_news_review}</div>
		<div class="appadmincomment_content">
			<p>--</p>
		</div>
	</div>
</div>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <span style='float: left;margin-top: 4px;'>{$T->str_protocol_type}：</span>
            <div class="serach_name_content menu_list js_select_ul_list" style='width: 134px;'>
                <span class="span_name" id="js_mod_select">
                    <input type="text" value="{$typename}" id="js_searchtype" readonly="true" style='width: 124px;'/>
                    <input type="hidden" value="{$type}" id="ptype"/>
                </span>
                <em id="js_seltitle"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                <ul id="js_selcontent" style='width: 130px;'>
                    <li class="on" style='width: 130px;' val="none">{$T->str_protocol_type_none}</li>
                    <li style='width: 130px;' val="user">{$T->str_protocol_type_user}</li>
                    <li style='width: 130px;' val="privacy">{$T->str_protocol_type_privacy}</li>
                    <li style='width: 130px;' val="intellectual">{$T->str_protocol_type_intellectual}</li>
                    <li style='width: 130px;' val="userregister">{$T->str_protocol_type_register}</li>
                    <li style='width: 130px;' val="applewebsite">苹果官网协议</li>
                    <li style='width: 130px;' val="membershipdescription">会员权限说明</li>
                    <li style='width: 130px;' val="morehelp" title="oraPay银联卡更多帮助">oraPay银联卡更多帮助</li>
                </ul>
            </div><br><br>
            <textarea class="js_content im-message-area" id="h5content" style="height:600px; word-break: break-all;overflow:hidden;">{$content}</textarea>
            <div class="appadmin_pagingcolumn">
	            <div class="section_bin">
                    <span id='js_preview' class='hand'><i>{$T->str_news_review}</i></span>
	                <span id='js_dointro' class='hand'><i>{$T->str_intro_save}</i></span>
	                <span id='js_cancel' class='hand'><i>{$T->str_btn_cancel}</i></span>
	            </div>
	        </div>
	        <br>
        </div>
    </div>
</div>
<!-- 配置文件 -->
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/ueditor/ueditor.all.js"></script>
<script type='text/javascript'>
var URL_DO_INTRO  = "{:U('Appadmin/Protocol/save')}";
var mainurl = "{:U('Appadmin/Protocol/index')}";
var origintype="{$type}";
var editpage="{$edit}";
var tip_protocol_select = "{$T->tip_protocol_select}";
var tip_protocol_content = "{$T->tip_protocol_content}";
var URL_UPLOAD       = "{:U('/Appadmin/Common/uploadSessTmpFile')}"; 
var URL_AUDIO_IMG    = "__PUBLIC__/js/jsExtend/ueditor/themes/audio.png";
var gUeVideoFormatErrMsg="视频格式不正确";//视频格式不正确
var gUeAddVideoErrMsg="添加视频失败:请检查文件大小和格式";//添加视频失败:请检查文件大小和格式
var URL_VIDEO_IMG="__PUBLIC__/js/jsExtend/ueditor/themes/video.png";
var content = '{$content}'; //内容的初始值

$(function(){
	$.protocol.addedit();
});

</script>
