<layout name="../Layout/Layout" />
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
            <div class="appadmin_pagingcolumn">
	            <div class="section_bin">
	                <span id='js_dointro' class='hand' style='margin-left:0px;'><i>{$T->str_intro_save}</i></span>
	            </div>
	        </div>
	        <br>
            <textarea class="js_content im-message-area" id="h5content" style="height:600px; word-break: break-all;overflow:hidden;">{$content}</textarea>
        </div>
    </div>
</div>
<!-- 配置文件 -->
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/ueditor/ueditor.all.js"></script>
<script type='text/javascript'>
var gUploadPath   = "{:U('Appadmin/H5Page/uploadActivityImg')}";
var URL_DO_INTRO  = "{:U('Appadmin/H5Page/doActivityRule')}";
var URL_UPLOAD       = "{:U('/Appadmin/Common/uploadSessTmpFile')}"; 
var URL_AUDIO_IMG    = "__PUBLIC__/js/jsExtend/ueditor/themes/audio.png";
var content = '{$content}'; //内容的初始值

$(function(){
	//保存功能介绍
	$('#js_dointro').on('click',function(){
		$.ajax({
	        type: "POST",
	        url: URL_DO_INTRO,
	        data: {content: ue.getContent()}, 
	        async: false,
	        dataType: 'json',
	        success: function (result) {
	            if (result.status == 0) {
	                //成功
	            	$.global_msg.init({gType:'warning',msg:result.msg,icon:1});
	            } else {
	            	$.global_msg.init({gType:'warning',msg:result.msg,icon:2});
	            }
	        }
	    });
	});
});

</script>
