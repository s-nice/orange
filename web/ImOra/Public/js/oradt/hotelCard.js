/**
 * Created by zhaoge on 2016/12/20.
 */
;(function ($) {
    $.extend({
        hotelCard: {
            init: function () { //门禁卡加密类型列表页初始化
                this.pulicEvent();
                $('.js_edit').on('click', function () {
                    $('.js_name_input').val($(this).attr('data-name'));
                    $('.js_key_input').val($(this).attr('data-key'));
                    $('#js_add_confirm').attr('data-id', $(this).attr('data-id'));
                    $('.js_masklayer').show();//遮罩层
                    $('#js_add_wrap').show(); //显示添加弹框
                });

                $('#js_add_cancel').on('click', function () {
                    $('.js_name_input').val('');
                    $('.js_key_input').val('');
                    $('#js_add_confirm').removeAttr('data-id');
                    $('.js_masklayer').hide();//关闭遮罩层
                    $('#js_add_wrap').hide(); //添加取消
                });

                //提交编辑 或添加
                $('#js_add_confirm').on('click', function () {
                    var name = $.trim($('.js_name_input').val());
                    var key = $.trim($('.js_key_input').val());
                    if (name == '' || key == '') {
                        $.global_msg.init({gType: 'alert', icon: 2, time: 3, msg: '请填写完整信息'});
                        return false;
                    }
                    var data = {};
                    data.name = name;
                    data.key = key;
                    data.type = 'C';//创建
                    if ($(this).attr('data-id') != '' && typeof ($(this).attr('data-id')) != 'undefined') { //编辑
                        data.id = $(this).attr('data-id');
                        data.type = 'U';//更新
                    }
                    $.ajax({
                        url: doUrl,
                        type: 'post',
                        data: data,
                        success: function (res) {
                            if (res.status == '0') {
                                $.global_msg.init({
                                    gType: 'warning', msg: '操作成功', time: 2, icon: 1, endFn: function () {
                                        $('#js_add_wrap').hide();
                                        $('.js_name_input').val('');
                                        $('.js_key_input').val('');
                                        window.location.reload();
                                    }
                                });
                            } else if (res.status == '999022') {
                                $.global_msg.init({
                                    gType: 'warning', msg: '加密类型名称已存在，请重新输入', time: 2, icon: 0
                                });
                            }else if (res.status == '999023') {
                                $.global_msg.init({
                                    gType: 'warning', msg: '秘钥已存在，请重新输入', time: 2, icon: 0
                                });
                            }else {
                                $.global_msg.init({
                                    gType: 'warning', msg: '操作失败', time: 2, icon: 0
                                });
                            }
                        },
                        fail: function (err) {
                            $.global_msg.init({
                                gType: 'warning', msg: '操作失败', time: 2, icon: 0

                            });
                        }
                    });

                });
                //删除
                $('.js_del').on('click', function () {
                    var id = $(this).attr('data-id');
                    $.global_msg.init({
                        gType: 'confirm',
                        icon: 2,
                        msg: '确认删除加密类型吗？',
                        btns: true,
                        close: true,
                        title: false,
                        btn1: '取消',
                        btn2: '确认',
                        noFn: function () {
                            $.ajax({
                                url: doUrl,
                                type: 'post',
                                data: {id: id, type: 'D'},
                                success: function (res) {
                                    if (res.status == '0') {
                                        $.global_msg.init({
                                            gType: 'warning', msg: '删除成功', time: 2, icon: 1, endFn: function () {
                                                window.location.reload();
                                            }
                                        });
                                    }else if(res.status == '999022'){
                                        $.global_msg.init({
                                            gType: 'warning', msg: '已有酒店选择该加密类型，不能删除', time: 2, icon: 0
                                        });
                                    } else {
                                        $.global_msg.init({
                                            gType: 'warning', msg: '删除失败', time: 2, icon: 0
                                        });
                                    }
                                },
                                fail: function (err) {
                                    $.global_msg.init({
                                        gType: 'warning', msg: '删除失败', time: 2, icon: 0

                                    });
                                }
                            });
                        }
                    });
                });

            },
            pulicEvent: function () { //公用事件

                $('#js_add').on('click', function () {//添加按钮
                    $('.js_masklayer').show();//遮罩层
                    $('#js_add_wrap').show(); //显示添加弹框
                });

                $('.js_sort').on('click', function () {//点击排序
                    var oldSort = $("input[name='sort']").val();
                    var newSort = oldSort == 'desc' ? 'asc' : 'desc';
                    $("input[name='sort']").val(newSort);
                    $('#js_search_form').submit();
                });


                $('.js_select input').on('click', function () {    //下拉菜单点击
                    $(this).closest('.js_select').find('ul').toggle();
                });

                $('.js_select').on('click','li', function () {   //下拉菜单选择
                    var $input = $(this).closest('.js_select').find('input');
                    if( $input.val()!=$(this).html()){
                        $input.val($(this).html());
                        $input.attr('val', $(this).attr('data-id'));
                        $input.trigger('change');
                        $(this).siblings('li').removeClass('on');
                        $(this).addClass('on');
                    }
                    $(this).closest('ul').hide();

                });

                //下拉菜单点击外部关闭
                $(document).on('click', function (e) {
                    var clickObj = $(e.target).parents('.js_select');
                    if (!clickObj.length) {
                        $('.js_select').find('ul').hide();
                    } else {
                        $('.js_select').not(clickObj).find('ul').hide();
                    }
                });
                //下拉菜单滚动条
                $('.js_select ul').mCustomScrollbar({ //初始化卡模板滚动条
                    theme: "dark", //主题颜色
                    autoHideScrollbar: false, //是否自动隐藏滚动条
                    scrollInertia: 0,//滚动延迟
                    horizontalScroll: false//水平滚动条
                });
            },
            hotelInit: function () {
                this.pulicEvent();
                var that=this;
                //提交编辑 或添加
                $('#js_add_confirm').on('click', function () {
                    var name = $.trim($('.js_name_input').val());
                    if (name == '') {
                        $.global_msg.init({gType: 'alert', icon: 2, time: 3, msg: '请填写完整信息'});
                        return false;
                    }
                    var unitid = $.trim($('#js_unit_input').attr('val'));
                    var encrypid = $.trim($('#js_encryption_type_input').attr('val'));
                    var logo = $.trim($('#js_logos_input').attr('val'));
                    var path= $.trim($('#js_imgs_input').attr('val'));
                    var city = $.trim($('#js_city_input').val());
                    var data = {};
                    data.name = name;
                    data.unitid = unitid;
                    data.encrypid = encrypid;
                    data.city=city;
                    data.logo=logo;
                    data.path=path;
                    data.type = 'C';//创建
                    if ($(this).attr('data-id') != '' && typeof ($(this).attr('data-id')) != 'undefined') { //编辑
                        data.id = $(this).attr('data-id');
                        data.type = 'U';//更新
                    }
                    $.ajax({
                        url: doUrl,
                        type: 'post',
                        data: data,
                        success: function (res) {
                            if (res.status == '0') {
                                $.global_msg.init({
                                    gType: 'warning', msg: '操作成功', time: 2, icon: 1, endFn: function () {
                                        if( typeof window.opener == 'object' && typeof window.opener.closeWindow=='function') {
                                            window.opener.closeWindow(window, true); //刷新列表页
                                        }
                                    }
                                });
                            } else if (res.status == '999022') {
                                $.global_msg.init({
                                    gType: 'warning', msg: '酒店名称已存在，请重新输入', time: 2, icon: 0
                                });
                            }
                            else {
                                $.global_msg.init({
                                    gType: 'warning', msg: '操作失败', time: 2, icon: 0
                                });
                            }
                        },
                        fail: function (err) {
                            $.global_msg.init({
                                gType: 'warning', msg: '操作失败', time: 2, icon: 0

                            });
                        }
                    });

                });

                //推荐，取消推荐
                $('.js_isrec').on('click', function () {
                    var data = {};
                    data.isrec = $(this).attr('data-isrec') == '1' ? '2' : '1';
                    data.id = $(this).attr('data-id');
                    data.type = 'U';
                    $.ajax({
                        url: doUrl,
                        type: 'post',
                        data: data,
                        success: function (res) {
                            if (res.status == '0') {
                                $.global_msg.init({
                                    gType: 'warning', msg: '操作成功', time: 2, icon: 1, endFn: function () {
                                        window.location.reload();
                                    }
                                });
                            } else {
                                $.global_msg.init({
                                    gType: 'warning', msg: '操作失败', time: 2, icon: 0
                                });
                            }
                        },
                        fail: function (err) {
                            $.global_msg.init({
                                gType: 'warning', msg: '操作失败', time: 2, icon: 0

                            });
                        }
                    });
                });

                //删除
                $('.js_del').on('click', function () {
                    var id = $(this).attr('data-id');
                    $.global_msg.init({
                        gType: 'confirm',
                        icon: 2,
                        msg: '确认删除酒店吗？',
                        btns: true,
                        close: true,
                        title: false,
                        btn1: '取消',
                        btn2: '确认',
                        noFn: function () {
                            $.ajax({
                                url: doUrl,
                                type: 'post',
                                data: {id: id, type: 'D'},
                                success: function (res) {
                                    if (res.status == '0') {
                                        $.global_msg.init({
                                            gType: 'warning', msg: '删除成功', time: 2, icon: 1, endFn: function () {
                                                window.location.reload();
                                            }
                                        });
                                    }
                                    else {
                                        $.global_msg.init({
                                            gType: 'warning', msg: '删除失败', time: 2, icon: 0
                                        });
                                    }
                                },
                                fail: function (err) {
                                    $.global_msg.init({
                                        gType: 'warning', msg: '删除失败', time: 2, icon: 0

                                    });
                                }
                            });
                        }
                    });
                });

                // 加载 城市列表
                $('#js_province_input').on('change',function(){
                    var provincecode =$(this).attr('val');
                    that.loadCitys({provincecode:provincecode});

                });

                //选择图片 左侧图片变化
                $('#js_imgs_input,#js_logos_input').on('change',function(){
                    var $inputObj=$(this);
                    $inputObj.parent().find('li').each(function(index,obj){
                        if($(obj).attr('data-id')==$inputObj.attr('val')){
                           $inputObj.parents('.js_img_parent').find('.js_img_show').attr('src',$(this).attr('data-src'));
                            return false;
                        }
                    });
                })
            },
            importInit: function () {
                this.pulicEvent();
                $('#js_upload').on('click',function(){ //点击导入
                    $('#js_upload_input').trigger('click');
                });

                $('#js_import_cancel,#js_is_confirm,#js_is_cancel').on('click',function(){
                    if( typeof window.opener == 'object' && typeof window.opener.closeWindow=='function') {
                        window.opener.closeWindow(window, true); //刷新列表页
                    }

                });

                $('#js_upload_input').off('change').on('change', function () { //上传文件后显示文件名
                    $('#js_file_name').html($('#js_upload_input').val());

                });
                //确认导入
                $('#js_import_confirm').on('click',function(){
                    if($('#js_upload_input').val()==''){
                        $.global_msg.init({gType: 'alert', icon: 2, time: 3, msg: '请选择上传文件'});
                        return false;
                    }
                    $.ajaxFileUpload({
                        url: doUrl,
                        secureuri: false,
                        fileElementId: 'js_upload_input',
                        data: {unitId: $('#js_unit_input').attr('val')},
                        dataType: 'json',
                        success: function (rtn) {
                            if(rtn.status==0){
                                $('.js_end_wrap .js_all_unm').html(rtn.data.success+rtn.data.fails);
                                $('.js_end_wrap .js_success_unm').html(rtn.data.success);
                                $('.js_end_wrap .js_fails_unm').html(rtn.data.fails);
                                if(rtn.data.fails>0){
                                    $('#js_is_check').removeClass('button_disabel');//导出检查按钮
                                    $("input[name='errData']").val(JSON.stringify(rtn.errData));
                                }
                                $('.js_masklayer').show();//遮罩层
                                $('.js_end_wrap').show();

                            }else if(rtn.status == 'error') {
                                $.global_msg.init({gType: 'alert', icon: 2, time: 3, msg: rtn.msg});
                            }else{
                                $.global_msg.init({gType: 'alert', icon: 2, time: 3, msg: '导入失败'});
                            }

                        },
                        error: function (data, status, e) {
                            $.global_msg.init({gType: 'alert', icon: 2, time: 3, msg: '导入失败'});
                        }
                    });
                });

                //导出检查
                $('#js_is_check').on('click',function(){
                    if(!$(this).hasClass('button_disabel')){
                        $('.js_end_wrap form').submit();
                    }
                })


            },
            imgInit:function(){
                this.pulicEvent();
                this.uploadImgEvent();
              //弹框取消
                $('#js_add_cancel').on('click', function () {
                    $('.js_name_input').val('');
                    $('.js_img_url').val('');
                    $('#js_add_confirm').removeAttr('data-id');
                    $('.js_logoimg_show img').attr('src','');
                    $('.js_close').hide();
                    $('.js_masklayer').hide();//关闭遮罩层
                    $('#js_add_wrap').hide(); //添加取消
                });

                //编辑
                $('.js_edit').on('click',function(){
                    var id=$(this).parent().attr('data-id');
                    $.ajax({ //初始化弹框
                        url: gUrl,
                        type: 'get',
                        data: {id:id},
                        success: function (res) {
                            if (res.status == '0') {
                                $('.js_name_input').val(res.data.list[0].name);
                                $('.js_logoimg_show img').attr('src',res.data.list[0].path);
                                $('.js_close').show();
                                $('.js_img_url').attr('nochange',1);
                                $('.js_img_url').val(res.data.list[0].path);
                                $('#js_add_confirm').attr('data-id',id)
                                $('.js_masklayer').show();//遮罩层
                                $('#js_add_wrap').show(); //显示添加弹框
                            }else {
                                $.global_msg.init({
                                    gType: 'warning', msg: '获取编辑数据失败', time: 2, icon: 0
                                });
                            }
                        },
                        fail: function (err) {
                            $.global_msg.init({
                                gType: 'warning', msg: '获取编辑数据失败', time: 2, icon: 0

                            });
                        }
                    });
                });

                //提交编辑 或添加
                $('#js_add_confirm').on('click', function () {
                    var name = $.trim($('.js_name_input').val());
                    var url = $.trim($('.js_img_url').val());
                    if (name == '' || url == '') {
                        $.global_msg.init({gType: 'alert', icon: 2, time: 3, msg: '请填写完整信息'});
                        return false;
                    }
                    var data = {};
                    data.name = name;
                    data.type=gType;
                    if (typeof ( $('.js_img_url').attr('nochange')) == 'undefined'){//判断是否是编辑时默认的图片
                        data.url = url;
                    }
                        var doUrl=gAddUrl;
                    if ($(this).attr('data-id') != '' && typeof ($(this).attr('data-id')) != 'undefined') { //编辑
                        data.id = $(this).attr('data-id');
                        doUrl=gUpdateUrl
                    }
                    $.ajax({
                        url: doUrl,
                        type: 'post',
                        data: data,
                        success: function (res) {
                            if (res.status == '0') {
                                $.global_msg.init({
                                    gType: 'warning', msg: '操作成功', time: 2, icon: 1, endFn: function () {
                                        $('#js_add_wrap').hide();
                                        window.location.reload();
                                    }
                                });
                            } else if (res.status == '999022') {
                                $.global_msg.init({
                                    gType: 'warning', msg: '名称已存在，请重新输入', time: 2, icon: 0
                                });
                            }else {
                                $.global_msg.init({
                                    gType: 'warning', msg: '操作失败', time: 2, icon: 0
                                });
                            }
                        },
                        fail: function (err) {
                            $.global_msg.init({
                                gType: 'warning', msg: '操作失败', time: 2, icon: 0

                            });
                        }
                    });

                });

                //删除
                $('.js_del').on('click',function(){
                    var id=$(this).parent().attr('data-id');
                    var msgStr= gType== 1 ? 'LOGO' : '卡面';
                    $.global_msg.init({
                        gType: 'confirm',
                        icon: 2,
                        msg: '确认删除'+msgStr+'吗？',
                        btns: true,
                        close: true,
                        title: false,
                        btn1: '取消',
                        btn2: '确认',
                        noFn: function () {
                            $.ajax({
                                url: gDelUrl,
                                type: 'post',
                                data: {id: id},
                                success: function (res) {
                                    if (res.status == '0') {
                                        $.global_msg.init({
                                            gType: 'warning', msg: '删除成功', time: 2, icon: 1, endFn: function () {
                                                window.location.reload();
                                            }
                                        });
                                    }else if(res.status == '999022'){
                                        $.global_msg.init({
                                            gType: 'warning', msg: '已有酒店选择该'+msgStr+'图片，不能删除', time: 2, icon: 0
                                        });
                                    } else {
                                        $.global_msg.init({
                                            gType: 'warning', msg: '删除失败', time: 2, icon: 0
                                        });
                                    }
                                },
                                fail: function (err) {
                                    $.global_msg.init({
                                        gType: 'warning', msg: '删除失败', time: 2, icon: 0

                                    });
                                }
                            });
                        }
                    });
                });



            },
            /**
            * 加载城市列表
             * @params data 省份查询信息
            * */
            loadCitys:function(data){
                $.ajax({
                    url: gUrl,
                    type: 'get',
                    data: data,
                    success: function (res) {
                        if (res.status == '0') {
                            var list=res.data.list;
                            var $inputObj=$('#js_city_input');
                            var  $ulObj=$inputObj.siblings('ul');
                            $ulObj.children().remove();
                            if(typeof (data.provincecode)!='undefined'){
                                $inputObj.val(list[0].city);
                            }else{ //编辑回显
                                $('#js_province_input').val(list[0].province);
                                $('#js_province_input').attr('val',list[0].provincecode);
                            }
                            $.each(list,function(index,obj){
                                $ulObj.append(
                                    "<li data-id=''>"+obj.city+"</li>"
                                )
                            })
                        }
                        else {

                            $.global_msg.init({
                                gType: 'warning', msg: '加载城市失败', time: 2, icon: 0
                            });
                        }
                    },
                    fail: function (err) {
                        $.global_msg.init({
                            gType: 'warning', msg: '加载城市失败', time: 2, icon: 0

                        });
                    }
                });
            },
            //上传图片相关公用event
            uploadImgEvent: function () {
                var that = this;
                $('.js_upload_button').on('click',function(){
                    $('#js_logoimg').trigger('click');
                });
                $('#js_logoimg').off('change').on('change', function () { //长传图片
                    that.uploadAddPageFile('js_logoimg', 'picfile');

                });

                $('.js_close').on('click', function () { //取消上传图片
                    $('.js_logoimg_show img').removeAttr('src');
                    $('.js_img_url').val('');
                    $(this).hide();
                });
            },
            /**
             * 上传图片
             *  @param  fileElementId str 上传INPUT ID
             *  @param  fileNameHid  str input name
             * */
            uploadAddPageFile: function (fileElementId, fileNameHid) {
                $.ajaxFileUpload({
                    url: gUrlUploadFile,
                    secureuri: false,
                    fileElementId: fileElementId,
                    data: {fileNameHid: fileNameHid},
                    dataType: 'json',
                    success: function (rtn, status) {
                        var imgUrl = rtn.data.absolutePath;
                        if (rtn.status == 1) {
                            $.global_msg.init({gType: 'alert', icon: 2, time: 3, msg: rtn.info});
                            return false;
                        } else {
                            $('.js_logoimg_show img').attr('src', imgUrl);
                            $('.js_img_url').val(imgUrl);
                            if (typeof ( $('.js_img_url').attr('nochange')) != 'undefined') {
                                $('.js_img_url').removeAttr('nochange')
                            }
                            $('.js_close').show();
                        }
                    },
                    error: function (data, status, e) {
                    }
                });
            },



        }

    });

})(jQuery);

