
/**
 * Created by zhaoge on 2015/12/30.
 */
(function($){
    $.extend({
        imora:{
            init: function(){
                this.SoftwareUpdate();
            },
            getUpLoadList: function(){
                var that=this;
                /*获取已添加的更新包列表*/
                var data={
                    action: 'xmlList',
                    p:gP,
                    sort:gSort

                };
                $.get(gUrl,data,function (data) {
                    var obj = JSON.parse(data)
                    $(" .Journalsection_list_c").remove(); //删除之前的列表数据
                    $(".page").children().remove();//删除之前分页数据
                    $(" .Journalsection_list_name").after(obj.list);//刷新列表数据
                    $(".page").append(obj.pagedata);//刷新分页数据

                });
            },

            getZipList: function(){
                /*获取在服务器中未添加的更新包列表*/
                $.get(gUrl, {action: 'zipList'}, function (data) { //获取目录中的zip包名称列表
                    $("#js_SelContent").html("");//删除之前的列表
                    var obj = JSON.parse(data);
                    if (null != obj){
                        $.each(obj, function (index, item) { //每个包名称添加到下拉菜单选项,设置属性url值
                            var _url =gDir+"App/" + item ;
                            var _option = $("<li></li>").text(item);
                            _option.attr('url', _url);
                            $(".Administrator_liukong").show();
                            $("#js_SelContent").append(_option);//更新列表
                        });
                        /*下拉菜单滚动条*/
                        var scrollObj = $('.js_list_scroll');
                        if(!scrollObj.hasClass('mCustomScrollbar')){
                            scrollObj.mCustomScrollbar({
                                theme:"dark", //主题颜色
                                autoHideScrollbar: false, //是否自动隐藏滚动条
                                scrollInertia :0,//滚动延迟
                                horizontalScroll : false,//水平滚动条
                            });
                        }
                        $('#add_zipName').val($('#js_SelContent li:eq(0)').html());
                        $('#add_url').val(window.location.protocol + '//' + window.location.host + $('#js_SelContent li:eq(0)').attr('url'));
                        $('#js_SelContent li').on('click', function () { //添加点击事件，点击后更新包的URL路径值写入表单
                        var zipUrl = window.location.protocol + '//' + window.location.host + $(this).attr('url');
                        $('#add_url').val(zipUrl);
                       })
                    }else {
                        $('#add_zipName').val(gZipListNull);

                    }
                });
            },

            addSoftwareUpdate: function(data){
                /*添加更新包*/
                var that= this;
                $.post(gUrl, data, function (msg) {
                    if ( "" != msg) { //添加不成功
                        $.global_msg.init({msg:msg,icon:0});
                        return false;
                    } ;
                    /*添加成功后初始化弹框*/
                    $('#software_add,.js_masklayer').hide();
                    $("#add_toVersion ").val('');
                    $("#add_desc").val('');
                    $("#add_url").val('');
                    $("#add_store").val('');
                    $("#add_new").val('');
                    //提交后刷新更新包列表
                    that.getUpLoadList();
                    //提交后刷新服务器中的更新包列表
                    that.getZipList();
                });
            },

            delUploadZip: function(){
                /*删除更新包*/
                var that= this;
                var _del= $(".Journalsection_list_c").has($(".active"));//获取删除的包
                var delData= new Array;
                _del.each(function(){
                    delData.push($(this).children(".toVersion").attr('title'));//获取删除更新包的版本
                });
                var data={
                    action:"delList",
                    deldata:delData,
                };
                $.post(gUrl,data , function (data) { //通过更新版本的值删除
                    that.getUpLoadList();//刷新列表
                });
            },

            SoftwareUpdate:function(){
                var that= this;
                /*添加按钮*/
                $('#addbtn').click(function () {
                    that.getZipList();//获取未添加的zip包
                    $("#add_toVersion ").val('');
                    $("#add_desc").val('');
                    $("#add_url").val('');
                    $("#add_store").val('');
                    $("#add_new").val('');
                    $('#software_add,.js_masklayer').show('');
                });
                /*软件包下拉菜单*/
                var seloDiv = $('#js_SelContent');
                var titleOdiv = $('#add_zipName');

                $('#js_SelStatus').on('click',function(event) {
                    if (seloDiv.is(':hidden')) {
                        seloDiv.show();
                    } else {
                        seloDiv.hide();
                    }
                    event.stopPropagation();
                });
               $('#js_SelStatus').parents().on('click',function() {
                    if (seloDiv.is(':visible')) {
                         seloDiv.hide();
                    }
                });
                seloDiv.on('click','li',function(){
                    var content = $(this).html();
                    titleOdiv.val(content);
                });


                /*提交按钮*/
                $("#software_submit").click(function(){
                    var reg = /^[0-9a-z_\-\.\*]+$/i; //判断格式
                    var toVersion = $("#add_toVersion ").val();
                    var desc = $("#add_desc").val();
                    var zip_url = $("#add_url").val();
                    var store = $("#add_store").val();
                    var newfn = $("#add_new").val();
                    if (!reg.test(toVersion)) {
                        $.global_msg.init({msg:gVersionFail,icon:0});
                        return false;
                    } else if (desc == '' || zip_url==''|| store=='' || newfn =='') {
                        $.global_msg.init({msg:gSubmitNull,icon:0});
                        return false
                    };
                    var data = {
                        'action': "add",
                        'toVersion': toVersion,
                        'desc': desc,
                        'zip_url': zip_url,
                        'store': store,
                        'newfn':newfn
                    };
                    that.addSoftwareUpdate(data);
                });

                /*删除更新包*/
                $('#content_c').on('mouseover', function () {
                    $('#del_Update').off('click').on('click', function () { //点击事件
                        if ($(".Journalsection_list_c .active").length > 0) { //判断是否有勾选的列表
                            $.global_msg.init({   //确认删除弹框
                                gType: 'confirm',
                                icon: 2,
                                msg: gDelThememsg[0],
                                btns: true, btn1: gDelThememsg[1],
                                btn2: gDelThememsg[2],
                                close: true,
                                title: false,
                                fn: function () { //确定后执行删除
                                    that.delUploadZip();
                                }
                            });
                        }
                    });
                });

                /*列表排序*/
                $(".js_sort").click(function(){ //点击事件，获取升降规则
                    var sortUrl=window.location.pathname;
                    var sort=$(this).attr('action'); //获取点击排序列信息，默认都为升序
                    if(sortUrl.indexOf(sort) > 0){ //判断当前URL是否为点击列的升序排序，是变为降序。，否重新定义
                        sortUrl=sortUrl.replace('asc','desc');
                        window.location= sortUrl;
                    }
                    else {
                        window.location=gUrl.replace('.html','/p/')+gP+'/sort/'+sort+'.html';
                    }
                });

                /*全选反选*/
                $('#content_c').checkDialog({
                    checkAllSelector:'#js_allselect',checkChildSelector:'.js_select', valAttr:'val',selectedClass:'active'
                });

            }
        }
    });

    // 载入页面事件监听
    $.imora.init();

})(jQuery);

