<layout name="../Layout/Layout" />
<include file="head" />
<div class="content_global">
    <div class="content_hieght ">
        <div class="textappadmin_name"><span>{$T->str_news_title}</span>
            <input type="text" value="{$data.title}" id="js_title" maxlength="128">
        </div>
        <div class="textappadmin_name"><span>{$T->str_news_author}</span>
            <input type="text" value="{$data.author}" id="js_titleauthor" maxlength="32">
        </div>
        <iframe width="100%" height="100%" name="hidden_from1" class="none" style="display: none;" id="hidden_from1"></iframe>
        <div class="textappadmin_name">
            <span>{$T->str_news_title_pic}</span>
            <form id="upload_logo" target="hidden_from1" enctype="multipart/form-data" method="post" action="{:U('Home/Sns/uploadfile')}">
                <input type="text" name="uploadpic" id="uploadpic" hid="uploadImgField1" value="{$data.image}"/>
                <input type="button" class="logobutton" value="{$T->str_newpicture_upload}" />
                <input type="file"  name="uploadImgField1" id="uploadImgField1" style="opacity: 0; filter:alpha(opacity:0); position:absolute; right:209px; top:1px; width:60px; height:44px;"/>
                <img src="{$data.image}" id="title_pic" style="max-width: 100px;display:<if condition="$data['image'] eq ''"> none </else> block</if>;margin-left: -460px;margin-top: 50px;"/>
            </form>

        </div>
        <div class="addpage_keyword">
            <span>{$T->str_label_name}</span><input type="text" value="" id="js_label">

            <div class="add_label js_add_label" style="display: none">
                <div id="selected_labels_wrap" style="max-height: 100px;width: 457px;">
                    <div id="selected_labels" class="display_abel" style="height: auto; max-height: none" >
                        <foreach name="data.labels" item="vo">
                            <span class="js_label" data-id="{$vo.id}" style="">
                                {$vo.name}
                                <em class="js_remove">x</em>
                            </span>
                        </foreach>
                    </div>
                </div>
            </div>

        </div>
        <div class="textappadmin_select">
            <span>{$T->collection_category}</span>
            <div class="textappadmin_select_name">
                <span class="span_name">
                    <input type="text" value="{$data.category}" seltitle="{$data.categoryid}" id="js_titlevalue" readonly="true" />
                </span>
                <em id="js_seltitle"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></em>
                <ul id="js_selcontent" class="js_new_cate_list mCustomScrollbar _mCS_3" style="height:150px;">
                    <foreach name="category_list" item="v">
                        <li val="{$v.categoryid}">{$v.name}</li>
                    </foreach>
                </ul>
            </div>
        </div>
        <div class="textappadmin_keyword"><span>{$T->str_news_webfrom}</span><input type="text" value="{$data.webfrom}" id="js_webfrom"></div>
        <div class="textappadmin_keyword"><span>{$T->str_news_releasetime}</span><input type="text" readonly value="{$data.releasetime}" id="js_releasetime"></div>
        <div class="textappadmin_textarea js_new_addpage_publish">

            <span>{$T->str_news_content}</span>
            <div class="textappadmin_area" id="textarea_right">
                <div  class="js_content im-textappadmin_selectmessage-area" id="js_content" style="height:600px; width:747px;word-break: break-all;overflow: hidden;">
                </div>
            </div>
        </div>
        <div class="textappadmin_bin">
            <span></span>
            <div class="textappadmin_button">
                <button id="js_review_now" class="big_button">{$T->str_news_review}</button>
                <if condition="$data['state'] eq 1">
                <button id="js_news_edit_save" class="big_button">{$T->str_news_storage}</button>
                <button class="adddata_b big_button" id="js_news_edit_audit">{$T->str_news_publish_audit}</button>
                 <else/>
                    <button class="adddata_b big_button" id="js_news_edit_save">{$T->coll_btn_publish}</button>
                 </if>
                <button id="js_edit_cancel" class="big_button">{$T->str_cancel_del_new}</button>
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
<div id="js_temp_content" style="display: none">{$data['content']}</div>
<!-- 配置文件 -->
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="__PUBLIC__/js/jsExtend/ueditor/ueditor.all.js"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
    var URL_UPLOAD="{:U('/Appadmin/Common/uploadSessTmpFile')}";
    var URL_AUDIO_IMG="__PUBLIC__/js/jsExtend/ueditor/themes/audio.png";
    var showId="{$data.showid}";
    var updataUrl="{:U('Appadmin/News/updateAudit','','','',true)}";
    var gstate="{$data.state}";
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
                    url:URL_UPLOAD + "?options[exts]=mp3&options[maxSize]="+(1024*1024*10),
                    secureuri:false,
                    fileElementId:$obj.attr('id'),
                    data : {exts : 'mp3', options:{maxSize:1024*1024*10}},
                    dataType: 'json',
                    success: function (data, status){
                        if (typeof (data.url) != 'string') {
                        	$.global_msg.init({gType:'warning',msg:gUeAddAudioErrMsg,icon:2});
                        	return;
                        }
                        _this.execCommand('insertHtml',"<img audio='"+data.url+"' src='"+URL_AUDIO_IMG+"'>");
                    },
                    error: function (data, status, e){
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

        /*火狐光标跳转调整BUG优化*/
        if (navigator.userAgent.indexOf('Firefox')>0){
            var  scrollTop;
            var  tag=0;
            $('.edui-toolbar .edui-button').on('mousedown',function(){
                scrollTop=$(ue.window).scrollTop();
                tag=1;

            });
            $('.edui-toolbar').on('mouseover',function(){
                if( $(ue.window).scrollTop()<=10 && tag==1){
                    $(ue.window).scrollTop(scrollTop);
                    tag=0;
                }
            });

        }
    } );
    ue.ready(function() {
        ue.setContent($('#js_temp_content').html()+'<br/>');

    });

    // 获取标签列表
    var gUrlToGetLabels = "{:U(MODULE_NAME.'/common/getNewsLabels', array('myTemplate'=>'adminManageNews'))}";
    var urlAppadminAdd = "{:U('Appadmin/News/addContent')}";
    var gUrlUploadFile = "{:U('Appadmin/Collection/uploadFileTmp')}";
    var datainfo = '';  //保存资讯编辑框初始内容
    $(function(){
        $('.appadmin_section_right').addClass('mCustomScrollbar _mCS_1');       //防止内容超出 左侧内容加滚动条
        $('.js_btn_new_preview').css('left','38%');
        $.news.newsEditInit();

        //红色关键字删除时候删除标签
  /*      setInterval(function(){
            //火狐
            if (navigator.userAgent.indexOf('Firefox')>0){
                var spans=ue.iframe.contentDocument.getElementsByTagName('span');
                for (var i=0;i<spans.length;i++){
                    if (spans[i].innerText.length == 0 && spans[i].style.color=='red'){
                        spans[i].remove();
                    }
                }
            } else {
                //IE,谷歌
                var fonts=ue.iframe.contentDocument.getElementsByTagName('font');
                for (var i=0;i<fonts.length;i++){
                    fonts[i].color = '';
                }
            }
        }, 200);*/
   });
</script>
<include file="unlockpop" />
