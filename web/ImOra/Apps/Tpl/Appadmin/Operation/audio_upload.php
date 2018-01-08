<input type='file' id='audio_file' name='image' style='width:20px; height:20px; z-index:999999;position:absolute;opacity:0; overflow:hidden;' autocomplete='off'>
<input type='file' id='video_file' name='image1' style='width:20px; height:20px;z-index:999999;position:absolute;opacity:0; overflow:hidden;' autocomplete='off'>
<style>
.edui-for-audio .edui-icon {
    background-position: -18px -40px;
    /*自定义命令按钮的样式*/
}
</style>
<script type="text/javascript">
//var URL_UPLOAD="{:U('Appadmin/UserPush/uploadAudio')}";;
var URL_UPLOAD="{:U('Appadmin/Common/uploadSessTmpFile')}";;
var URL_AUDIO_IMG="__PUBLIC__/js/jsExtend/ueditor/themes/audio.png";

$('#audio_file').on('change', function(){
	var $obj=$(this);
	var val = $obj.val();
    var names=val.split(".");
    var allowedExtentionNames = ['mp3'];
    if(names.length<2 || $.inArray(names[names.length-1], allowedExtentionNames)==-1){
        //$.global_msg.init({msg:TIP_WRONG_IMG, btns:true});
        $.global_msg.init({gType:'warning',msg:'{$T->str_userpush_wrong_audio_type}',icon:2});
        return;
    }
    
    $.ajaxFileUpload({
		url: URL_UPLOAD,
		secureuri:false,
		fileElementId:$obj.attr('id'),
		data : {exts:'mp3'},
		dataType: 'json',
		success: function (data, status){
			if (typeof (data.url) != 'string') {
                $.global_msg.init({gType:'warning',msg:'{$T->str_userpush_wrong_audio_size}',icon:2});
                return;
            }
			ue.execCommand('insertHtml',"<img audio='"+data.url+"' src='"+URL_AUDIO_IMG+"'>");
		},
		error: function (data, status, e){
			$.global_msg.init({gType:'warning',msg:'{$T->str_userpush_audio_fail}',icon:2});
		}
	});
});

$('#video_file').on('change', function () {
    var $obj = $(this);
    var val = $obj.val();
    var names = val.split(".");
    var allowedExtentionNames = ['mp4'];
    if (names.length < 2 || $.inArray(names[names.length - 1], allowedExtentionNames) == -1) {
        //$.global_msg.init({msg:TIP_WRONG_IMG, btns:true});
    	alert(gUeVideoFormatErrMsg+'333');
        $.global_msg.init({gType: 'warning', msg: gUeVideoFormatErrMsg, icon: 2});
        return;
    }

    $.ajaxFileUpload({
        url: URL_UPLOAD + "?options[exts]=mp4&options[maxSize]=" + (1024 * 1024 * 20),
        secureuri: false,
        fileElementId: $obj.attr('id'),
        data: {exts: 'mp4', options: {maxSize: 1024 * 1024 * 20}},
        dataType: 'json',
        success: function (data, status) {
            if (typeof (data.url) != 'string') {
                alert(gUeAddVideoErrMsg+'111');
                $.global_msg.init({gType: 'warning', msg: gUeAddVideoErrMsg, icon: 2});
                return;
            }
            ue.execCommand('insertHtml', "<img class='video_img' video='" + data.url + "' src='" + URL_VIDEO_IMG + "'>");
        },
        error: function (data, status, e) {
        	alert(gUeAddVideoErrMsg+'222');
            $.global_msg.init({gType: 'warning', msg: gUeAddVideoErrMsg, icon: 2});

        }
    });
});

$(function(){
	$('body').append($('#audio_file'));
	$('body').append($('#video_file'));
	
	setInterval(function(){
    	var offset=$('.edui-for-audio .edui-icon').offset();
    	if (offset){
    		$('#audio_file').css('top', offset.top);
            $('#audio_file').css('left', offset.left);
    	}

    	offset=$('.edui-for-video .edui-icon').offset();
    	if (offset){
    		$('#video_file').css('top', offset.top);
            $('#video_file').css('left', offset.left);
    	}

    }, 100);
});
</script>