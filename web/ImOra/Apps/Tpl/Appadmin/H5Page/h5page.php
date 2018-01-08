<layout name="../Layout/Layout" />
<style>
<!--
#h5content {
    border: 1px solid #a5a5a5;
    overflow: hidden;
    width: 800px;
    word-break: break-all;
}
-->
</style>
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="appadmin_pagingcolumn">
	            <div class="section_bin">
	                <span id='js_save_content' class='hand' style='margin-left:0px;'><i>{$T->str_intro_save}</i></span>
	            </div>
	        </div>
	        <br>
            <textarea class="js_content im-message-area" id="h5content">{$content}</textarea>
        </div>
    </div>
</div>
<!-- 配置文件 -->
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/ueditor/ueditor.all.js"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
var URL_POST_CONTENT = "{:U(MODULE_NAME .'/'.CONTROLLER_NAME . '/' . ACTION_NAME)}";
var URL_UPLOAD       = "{:U('/Appadmin/Common/uploadSessTmpFile')}";
var URL_AUDIO_IMG    = "__PUBLIC__/js/jsExtend/ueditor/themes/audio.png";
var content = '{$content}'; //内容的初始值

$('#js_save_content').click (function () {
	var content = ue.getContent();
    $.ajax(URL_POST_CONTENT, {
        data : {content : content},
        type : 'post',
        success : function (response) {
            if (response.status == 0) {
                //成功
            	$.global_msg.init({gType:'warning',msg:response.msg,time:3,icon:1});
            } else {
            	$.global_msg.init({gType:'warning',msg:response.msg,time:3,icon:2});
            }
        }
    });
});
</script>