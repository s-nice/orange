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
                $.global_msg.init({gType:'warning',msg:'音频格式不正确',icon:2});
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
                        $.global_msg.init({gType:'warning',msg:'添加音频失败:请检查文件大小和格式',icon:2});
                        return;
                    }

                    _this.execCommand('insertHtml',"<img audio='"+data.url+"' src='"+URL_AUDIO_IMG+"'>");
                },
                error: function (data, status, e){
                    console.log(e);
                    $.global_msg.init({gType:'warning',msg:'添加音频失败',icon:2});

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
baidu.editor.commands['video'] = {
    execCommand: function () {
        var _this = this;
        $('#video_file').remove();
        var $file = $("<input type='file' id='video_file' name='tmpFile' style='display:none;'>");
        $file.on('change', function () {
            var $obj = $(this);
            var val = $obj.val();
            var names = val.split(".");
            var allowedExtentionNames = ['mp4'];
            if (names.length < 2 || $.inArray(names[names.length - 1], allowedExtentionNames) == -1) {
                //$.global_msg.init({msg:TIP_WRONG_IMG, btns:true});
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
                        $.global_msg.init({gType: 'warning', msg: gUeAddVideoErrMsg, icon: 2});
                        return;
                    }
                    _this.execCommand('insertHtml', "<img video='" + data.url + "' src='" + URL_VIDEO_IMG + "'>");
                },
                error: function (data, status, e) {
                    $.global_msg.init({gType: 'warning', msg: gUeAddVideoErrMsg, icon: 2});

                }
            });
        });
        $('body').append($file);
        setTimeout(function () {
            $('#video_file').click();
        }, 100);
        return true;
    }
};
    var ue = UE.getEditor('h5content',{
        toolbars: [
            ['simpleupload','insertimage','fontsize','fontfamily','link', 'bold','italic',
                'underline', 'strikethrough', 'superscript', 'subscript',
                'removeformat','formatmatch','justifyleft', 'justifycenter','justifyright','','rowspacingbottom'],
            ['source','searchreplace','audio','video','forecolor','backcolor','spechars','insertorderedlist',
                'insertunorderedlist','horizontal','inserttable',
                'insertrow', //前插入行
                'insertcol', //前插入列
                'mergeright', //右合并单元格
                'mergedown', //下合并单元格
                'deleterow', //删除行
                'deletecol', //删除列
                'splittorows', //拆分成行
                'splittocols', //拆分成列
                'splittocells', //完全拆分单元格
                'deletecaption', //删除表格标题
                'inserttitle', //插入标题
                'mergecells', //合并多个单元格
                'deletetable', //删除表格
                'cleardoc', //清空文档
                'insertparagraphbeforetable', //"表格前插入行"
            ]
        ] ,
        labelMap:{
            'video':'视频'
        },
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
        initialFrameWidth :800,//设置编辑器宽度
        initialFrameHeight:800//设置编辑器高度
    });

    ue.addListener( 'ready', function( editor ) {
        ue.execCommand( 'pasteplain' ); //设置编辑器只能粘贴文本
        //$('#h5content').css('height', 600);
        content && ue.setContent(content);
        setInterval(function(){
            var offset=$('.edui-for-audio .edui-icon').offset();
            $('#audio_file').css('top', offset.top);
            $('#audio_file').css('left', offset.left);
        }, 100);
        /*火狐浏览器BUG兼容,解决当正文内容比较多时，出现滚动条后，点击导航栏菜单，滚动条自动跳到最上面的问题*/
        if (navigator.userAgent.indexOf('Firefox')>0){
            var  scrollTop;
            var  tag=0;
            $('.edui-toolbar .edui-button').on('mousedown',function(){
                scrollTop=$(ue.window).scrollTop();
                tag=1;
                return false;
            });
            $('.edui-toolbar').on('mouseover',function(){
                if( $(ue.window).scrollTop()<=10 && tag==1){
                    $(ue.window).scrollTop(scrollTop);
                    tag=0;
                }
                return false;
            });
        }
    } );