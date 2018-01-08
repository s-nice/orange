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
    var gUploadPath   = "{:U('Appadmin/News/uploadImg')}";
    var URL_SAVE = "{:U('Appadmin/OraAgreement/saveEdit')}";
    var URL_UPLOAD       = "{:U('/Appadmin/Common/uploadSessTmpFile')}";  //上传图片、音频的url
    var URL_AUDIO_IMG    = "__PUBLIC__/js/jsExtend/ueditor/themes/audio.png"; //音频的图片地址
    var gUeVideoFormatErrMsg="视频格式不正确";//视频格式不正确
    var gUeAddVideoErrMsg="添加视频失败:请检查文件大小和格式";//添加视频失败:请检查文件大小和格式
    var URL_VIDEO_IMG="__PUBLIC__/js/jsExtend/ueditor/themes/video.png";
    var content = "{$content}"; //内容的初始值
    var id ="{$result['data']['data'][0]['id']}"; //内容的id

    $(function(){
        //保存功能介绍
        $('#js_dointro').on('click',function(){
            $.ajax({
                type: "POST",
                url: URL_SAVE,
                data: {id:id,'agreement':ue.getContent(),'type':1},
                async: false,
                dataType: 'json',
                success: function (result) {
                    if (result.status == 0) {
                        //成功
                        $.global_msg.init({gType: 'warning', icon: 1,time:3 ,msg: '保存成功',endFn:function(){
                            //window.location.href = gUrl;
                            if( typeof window.opener == 'object' && typeof window.opener.closeWindow=='function') {
                                window.opener.closeWindow(window, true); //刷新列表页
                            }

                        }});
                    } else {
                        $.global_msg.init({gType:'warning',msg:'保存失败',icon:2});
                    }
                }
            });
        });
    });

</script>
