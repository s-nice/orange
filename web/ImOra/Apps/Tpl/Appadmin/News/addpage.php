<layout name="../Layout/Layout" />
<include file="head" />
<div class="content_global">
    <div class="content_hieght ">
         <div class="textappadmin_name"><span>{$T->str_news_title}</span><input type="text" value="" id="js_title" maxlength="128"></div>
         <div class="textappadmin_name"><span>{$T->str_news_author}</span><input type="text" value="" id="js_titleauthor" maxlength="32"></div>

        <iframe width="100%" height="100%" name="hidden_from1" class="none" style="display: none;" id="hidden_from1"></iframe>
        <div class="textappadmin_name">
            <span>{$T->str_news_title_pic}</span>
            <form id="upload_logo" target="hidden_from1" enctype="multipart/form-data" method="post" action="{:U('Home/Sns/uploadfile')}">
                <input type="text" name="uploadpic" id="uploadpic" hid="uploadImgField1" value="{$T->str_news_click_uploadpic}"/>
                <input type="button" class="logobutton" value="{$T->str_newpicture_upload}" />
                <input type="file"  name="uploadImgField1" id="uploadImgField1" style="opacity: 0; filter:alpha(opacity:0); position:absolute; right:209px; top:1px; width:60px; height:44px;"/>
                <img src="" id="title_pic" style="max-width: 100px; display: none;margin-left: -460px;margin-top: 50px;"/>
            </form>

        </div>
         <div class="addpage_keyword">
            <span>{$T->str_label_name}</span><input type="text" value="" id="js_label" readonly="readonly">
            <div class="add_label js_add_label" style="display: none">
            <div id="selected_labels_wrap" style="width: 457px;">
                <div id="selected_labels" class="display_abel" style="height: auto; max-height: none" ></div>
            </div>
            </div>
         </div>
         <div class="textappadmin_select">
	         <span>{$T->collection_category}</span>
	         <div class="textappadmin_select_name menu_list">
        		<span class="span_name"><input type="text" value="{$category_list[0]['name']}" seltitle="{$category_list[0]['categoryid']}" id="js_titlevalue" readonly="true" /></span>
        		<em id="js_seltitle"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                 <ul id="js_selcontent" class="js_new_cate_list mCustomScrollbar _mCS_3" style="height:150px;">
                     <foreach name="category_list" item="v">
                        <li val="{$v.categoryid}">{$v.name}</li>
                     </foreach>
                 </ul>
        	</div>
         </div>
         <div class="textappadmin_keyword"><span>{$T->str_news_webfrom}</span><input type="text" value="" id="js_webfrom"></div>
         <div class="textappadmin_keyword"><span>{$T->str_news_releasetime}</span><input type="text" readonly value="" id="js_releasetime"></div>
         <div class="textappadmin_textarea js_new_addpage_publish">
             <!-- 文件表单 -->
<!--             <form id="upload_contentpic_form" action="{:U('Home/Sns/uploadfile')}" method="post" enctype="multipart/form-data" target="hidden_upload">-->
<!--                 <input type="hidden" name="uploadcontentpic" id="uploadcontentpic" value="uploadContentImg"/>-->
<!--                 <input type="file"  name="uploadContentImg" id="uploadContentImg" class="js_upload_file_hide" style='left:90px;z-index:10;'/>-->
<!--                 <input type="text" style="display:none" name="uploadImgBtn" id="uploadImgBtn" value="" />-->
<!--             </form>-->
         	<span>{$T->str_news_content}</span>
             <div class="textappadmin_area" id="textarea_right">
<!--                 <div class="textarea_title js_textarea_title" style="width: 600px;"><i style="display: none;"><img src="__PUBLIC__/images/editor_img_icon_w.png" /></i><em class="js_moni_upload" style='z-index: 0;'><img class="js_upload_img" src="__PUBLIC__/images/editor_img_icon_p.png" /></em></div>-->
                 <!-- <textarea>嗡嗡嗡我瓦多好看的健康拉丁罚款了</textarea> -->
                 <div  class="js_content im-message-area" id="js_content" style="height:600px; width:747px;word-break: break-all;overflow: hidden;"></div>
             </div>
         </div>
         <div class="textappadmin_bin">
         	<span></span>
         	<div class="textappadmin_button">
	         	<button id="js_review_now" class="middle_button">{$T->str_news_review}</button>
	         	<button id="js_storagedata" class="middle_button">{$T->str_news_storage}</button>
	         	<button class="middle_button adddata_b" id="js_adddata">{$T->str_news_publish_audit}</button>
	         	<button id="js_cancelpub" class="middle_button">{$T->str_cancel_del_new}</button>
         	</div>
         </div>

    </div>

	<!-- 弹出框， 选择评论人 : 默认隐藏-->
	<div style="display:none;" id="popChooseItem" class="addcomment_pageContent">
	    <div class="layer_title"><h1>{$T->str_news_select_label}</h1><i class="js_close">x</i></div>
	    <!-- 搜索框 -->
	    <div class="js_select_item addpage_maxwidth">
	      <input id="clickChoose" class="btn_label" type="button" value="{$T->str_news_confirm}"/>
		      <label for="js_keyword">{$T->str_label_name}</label>
		      <input class="textinput_search textinput cursorpointer" type="text" id="js_keyword" value=""/>
		      <input id="clickSearch" class="btn_label" type="button" value="搜索">

	    </div>

        <div id="labelsList"></div>
	</div>
</div>

<!-- 配置文件 -->
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/ueditor/ueditor.all.js"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
var URL_UPLOAD="{:U('/Appadmin/Common/uploadSessTmpFile')}";
var URL_AUDIO_IMG="__PUBLIC__/js/jsExtend/ueditor/themes/audio.png";
//实现插件的功能代码
baidu.editor.commands['audio'] = {
    execCommand : function() {
        var _this=this;
        $('#audio_file').remove();
    	var $file=$("<input type='file' id='audio_file' name='tmpFile' style='display:none;'>");
    	$file.on('change', function(){
        	var $obj=$(this);
    		var val = $obj.val();
    	    var names=val.split(".");
    	    var allowedExtentionNames = ['mp3'];
    	    if(names.length<2 || $.inArray(names[names.length-1], allowedExtentionNames)==-1){
    	        //$.global_msg.init({msg:TIP_WRONG_IMG, btns:true});
                $.global_msg.init({gType:'warning',msg:gUeAudioFormatErrMsg,icon:2});
    	        return;
    	    }

    	    $.ajaxFileUpload({
    			url:URL_UPLOAD,
    			secureuri:false,
    			fileElementId:$obj.attr('id'),
    			data : {exts:'mp3'},
    			dataType: 'json',
    			success: function (data, status){
    				if (typeof (data.url) != 'string') {
                    	$.global_msg.init({gType:'warning',msg:gUeAddAudioErrMsg,icon:2});
                    	return;
                    }

    				_this.execCommand('insertHtml',"<img audio='"+data.url+"' src='"+URL_AUDIO_IMG+"'>");
    			},
    			error: function (data, status, e){
                    console.log(e);
                    $.global_msg.init({gType:'warning',msg:gUeAddAudioErrMsg,icon:2});

    			}
    		});
        });
        $('body').append($file);
        setTimeout(function(){
        	$('#audio_file').click();
        }, 100);
        return true;
    },
    queryCommandState : function(){

    }
};
    var ue = UE.getEditor('js_content',{
        toolbars: [
            ['simpleupload','fontsize','fontfamily','link', 'unlink','bold','italic',
             'underline', 'strikethrough', 'superscript', 'subscript',
             'removeformat','justifyleft', 'justifycenter','justifyright','audio'
             ]
        ] ,
        wordCount:false ,
        elementPathEnabled:false,
        autoHeightEnabled:false ,
        autoClearEmptyNode: true,
        zIndex: 9,
        contextMenu:[],
        fontfamily:[{
            label: 'arial',
            name: 'arial',
            val: 'arial, helvetica,sans-serif'
        },{
            label: 'verdana',
            name: 'verdana',
            val: 'verdana'
        },{
            label: 'georgia',
            name: 'georgia',
            val: 'georgia'
        },{
            label: 'tahoma',
            name: 'tahoma',
            val: 'tahoma'
        },{
            label: 'timesNewRoman',
            name: 'timesNewRoman',
            val: 'times new roman'
        },{
            label: 'trebuchet MS',
            name: 'trebuchet MS',
            val: 'Trebuchet MS'
        },{
            label: '宋体',
            name: 'songti',
            val: '宋体,SimSun'
        },{
            label: '黑体',
            name: 'heiti',
            val: '黑体, SimHei'
        },{
            label: '楷体',
            name: 'kaiti',
            val: '楷体,楷体_GB2312, SimKai'
        },{
            label: '仿宋',
            name: 'fangsong',
            val: '仿宋, SimFang'
        },{
            label: '隶书',
            name: 'lishu',
            val: '隶书, SimLi'
        },{
            label: '微软雅黑',
            name: 'yahei',
            val: '微软雅黑,Microsoft YaHei'
        }],
        initialFrameWidth :747,//设置编辑器宽度
        initialFrameHeight:450//设置编辑器高度
    });


    ue.addListener( 'ready', function( editor ) {
        ue.execCommand( 'pasteplain' ); //设置编辑器只能粘贴文本
        ue.setHeight(450);
        setInterval(function(){
            var offset=$('.edui-for-audio .edui-icon').offset();
            $('#audio_file').css('top', offset.top);
            $('#audio_file').css('left', offset.left);
        }, 100);
        /*火狐浏览器BUG兼容*/
        if (navigator.userAgent.indexOf('Firefox')>0){
            var  scrollTop;
            var  tag=0;
            $('.edui-toolbar .edui-button').on('mousedown',function(){
                scrollTop=$(ue.window).scrollTop();
                tag=1;

            });
            $('.edui-toolbar').on('mouseover',function(){
                console.log($(ue.window).scrollTop());
                if( $(ue.window).scrollTop()<=10 && tag==1){
                    $(ue.window).scrollTop(scrollTop);
                    tag=0;
                }
            });

        }

    } );


    // 获取标签列表
    var gUrlToGetLabels = "{:U(MODULE_NAME.'/common/getNewsLabels', array('myTemplate'=>'adminManageNews'))}";
    var urlAppadminAdd = "{:U('Appadmin/News/addContent')}";
    var gUrlUploadFile = "{:U('Appadmin/Collection/uploadFileTmp')}";
    var datainfo = '';  //保存资讯编辑框初始内容
    $(function(){
        $('.appadmin_section_right').addClass('mCustomScrollbar _mCS_1');       //防止内容超出 左侧内容加滚动条
        $('.js_btn_new_preview').css('left','38%');
        $.news. addnewsInit();

    });
</script>
<include file="unlockpop" />
