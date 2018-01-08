;(function ($) {
    $.extend({
        equityCard: {

            //分类管理列表页js 初始化
            index_init: function () {
                var that = this;
                this.index_event();
            },
            //添加分类页面初始化
            add_init: function () {
                var that = this;
                that.uploadImgEvent();//上传图片事件

                $('.js_save_btn').on('click', function () { //保存 添加或编辑
                    if (that.noEmpty()) {
                        var data = {};
                        data.type = $.trim($("input[name='type']").val());//分类名称
                        data.content = $.trim($("input[name='content']").val());//分类名称
                        data.url = $.trim($("input[name='url']").val());//分类名称
                        if (typeof ($(this).attr('data-id')) != 'undefined') { //编辑
                            data.id = $(this).attr('data-id');
                            data.action = 'U';//添加标记
                            if (typeof ($("input[name='url']").attr('nochange')) != 'undefined') { //标记是否重新上传图片
                                data.imgchange = false;
                            } else {
                                data.imgchange = true;
                            }
                        } else {
                            data.action = 'C';//添加标记
                        }
                        $.ajax({
                            url: gAjaxUrl,
                            data: data,
                            type: 'post',
                            success: function (res) {
                                if (0 == res.status) {
                                    $.global_msg.init({
                                        gType: 'warning', icon: 1, time: 3, msg: '保存成功', endFn: function () {
                                            window.location.href = gIndexUrl;
                                        }
                                    });
                                }else if('999005'==res.status){
                                    $.global_msg.init({gType: 'warning', icon: 2, msg: '分类名称已经存在，请重新输入'});
                                } else {
                                    $.global_msg.init({gType: 'warning', icon: 2, msg: '保存失败'});
                                }
                            },
                            fail: function () {
                                $.global_msg.init({gType: 'warning', icon: 2, time: 3, msg: '保存失败'});
                            }
                        })
                    }
                })

            },
            //城市管理页面js 初始化
            city_init: function () {
                var that = this;
                $(window).load(function () { //添加窗口滚动条
                    $(".l_menu").mCustomScrollbar({
                        theme: "dark", //主题颜色
                        autoHideScrollbar: false, //是否自动隐藏滚动条
                        scrollInertia: 0,//滚动延迟
                        horizontalScroll: false//水平滚动条
                    });
                });
                $('#js_add_button').on('click', function () { //添加城市弹窗
                    $('#js_add_city_wrap').show();
                });

                $('#js_city_cancel').on('click', function () { //弹框取消按钮
                    $('#js_add_city_wrap').hide();
                });

                $('#js_city_confirm').on('click', function () { //弹框确认按钮
                    var data = {};
                    data.citycode = addArr.join(',');
                    data.action = 'C';//添加标记
                    $.ajax({
                        url: gAjaxUrl,
                        data: data,
                        type: 'post',
                        success: function (res) {
                            if (0 == res.status) {
                                $.global_msg.init({
                                    gType: 'warning', icon: 1, time: 3, msg: '保存成功', endFn: function () {
                                        window.location.reload();
                                    }
                                });
                            } else {
                                $.global_msg.init({gType: 'warning', icon: 2, msg: '保存失败'});
                            }
                        },
                        fail: function () {
                            $.global_msg.init({gType: 'warning', icon: 2, time: 3, msg: '保存失败'});
                        }
                    })

                });

                that.click_triangle();//点击省份操作

                this.index_event();
            },
            //商户权益列表页面 初始化
            list_init: function () { //权益列表 js初始化
                //时间插件初始化
                $.dataTimeLoad.init();
                this.list_event();

            },
            cardTypeId: '',//卡类型id
            unitsId: '',//发卡单位id
            p: 1,//卡模板列表页数
            otalpage: 1,//卡模板列表总页数
            selectCardModel: [],//选择的卡模板
            selectedCardModel: [],//编辑时默认初始化的卡模板数据
            //添加页面初始化
            list_add_init: function () {
                /*初始化获取编辑时已选择的模板数据*/
                var that= this;

                if($('.js_model_show').length > 0){
                    $('.js_model_show').each(function(){
                        var obj={};
                        obj.id=$(this).attr('val');
                        obj.name=$(this).find('em').html();
                        that.selectedCardModel.push(obj);
                    });


                }


                if ($('.js_cardType_input').length > 0 && $('.js_cardType_input').val() != '') { //编辑时初始化弹窗数据
                    this.cardTypeId = $('.js_cardType_input').attr('val');
                    this.unitsId =    $('.js_units_input').attr('val');
                    var title = $('.js_cardType_input').val()+'类型下查询'+$('.js_units_input').val()+'的卡模板';
                    $('#js_card_model_title').html(title);
                    var params = this.getSearchParams();
                    this.loadCardModel(params);//加载卡模板
                }
                this.list_event();
                this.list_add_event();
                this.uploadImgEvent();

            },
            //城市 类型 列表页 公用事件
            index_event: function () {//分类 城市 管理列表页公用事件
                var that = this;
                $('.js_down').on('click', function () {//向下
                    var id = $(this).parent().attr('data-id');
                    var type = $(this).parent().attr('data-type');
                    var sorting = $(this).parent().attr('data-sort');
                    data = {action: 'U', type: type};
                    var index = $(this).parent().index('.js_sort_list');
                    var id2 = $('.js_sort_list').eq(index + 1).attr('data-id');
                    var sorting2 = $('.js_sort_list').eq(index + 1).attr('data-sort');
                    var sortData = id + '-' + sorting2 + ',' + id2 + '-' + sorting;
                    if (type == 1) { //城市
                        data.citysort = sortData;
                    } else { //分类
                        data.types = sortData
                    }
                    that.sort(type, data);
                });

                $('.js_up').on('click', function () { //向上
                    var id = $(this).parent().attr('data-id');
                    var type = $(this).parent().attr('data-type');
                    var sorting = $(this).parent().attr('data-sort');
                    data = {action: 'U', type: type};
                    var index = $(this).parent().index('.js_sort_list');
                    var id2 = $('.js_sort_list').eq(index - 1).attr('data-id');
                    var sorting2 = $('.js_sort_list').eq(index - 1).attr('data-sort');
                    var sortData = id + '-' + sorting2 + ',' + id2 + '-' + sorting;
                    if (type == 1) { //城市
                        data.citysort = sortData;
                    } else { //分类
                        data.types = sortData
                    }

                    that.sort(type, data);

                });
                $('.js_stick').on('click', function () { //置顶
                    var id = $(this).parent().attr('data-id');
                    var type = $(this).parent().attr('data-type');
                    data = {id: id, action: 'top', type: type};
                    that.sort(type, data);

                });
                $('.js_edit').on('click', function () { //编辑
                    var id = $(this).parent().attr('data-id');
                    window.location.href = gEditUrl + '/id/' + id;

                });

                $('.js_del').on('click', function () { //删除
                    var id = $(this).parent().attr('data-id');
                    that.del(id);
                });

            },

            //商户权益列表页事件
            list_event: function () {
                var that =this;
                $('.js_type_select').selectPlug({getValId: 'typeid', defaultVal: ''}); //类型下拉
                $('.js_city_select').selectPlug({getValId: 'city', defaultVal: ''}); //城市下拉
                //下拉菜单点击外部关闭
                $(document).on('click', function (e) {
                    var clickObj = $(e.target).parents('.js_list_select');
                    if (!clickObj.length) {
                        $('.js_list_select').find('ul').hide();
                    } else {
                        $('.js_list_select').not(clickObj).find('ul').hide();
                    }
                });
                //预览窗口关闭
                $('.js_close_review_box').on('click',function(){
                    $(' .js_masklayer').hide();
                    $('.js_review_box').hide();
                });

                //删除
                $('.js_del_one').click(function () {
                    var id = $(this).parent().attr('data-id');
                    $.global_msg.init({
                        gType: 'confirm', icon: 2, msg: "确认删除么？", btns: true, close: true,
                        title: false, btn1: "取消", btn2: "确认",
                        noFn: function () {
                            that.delstore(id);
                        }
                    });

                    return false;
                });

                //预览
                $('.js_show_one').click(function () {
                    var url=$(this).attr('data-url');
                    that.showOne(url);

                })
            },

            //商户权益 添加 编辑页面事件

            list_add_event:function(){
                var that = this;
                /*初始化滚动条*/
                $('.js_list_select ul,.js_selected_model').mCustomScrollbar({ //初始化滚动条
                    theme: "dark", //主题颜色
                    autoHideScrollbar: false, //是否自动隐藏滚动条
                    scrollInertia: 0,//滚动延迟
                    horizontalScroll: false//水平滚动条
                });

                //下拉列表
                $('.js_list_select,.js_list_select_ct').on('click', function () {
                    if ($(this).find('li').length == 0 && $(this).hasClass('js_units_list')) {
                        $.global_msg.init({gType: 'warning', icon: 2, msg: '请选择卡类型'});
                    } else {
                        $(this).find('ul').toggle();
                    }

                });
                //下拉选择
                $('.js_list_select,.js_list_select_ct').on('click', 'li', function () {
                    var $inputObj = $(this).closest('ul').siblings('input');
                    if($(this).hasClass('js_city_li')){ //城市选择 选择后的隐藏和显示
                        $('.js_city_li_'+$(this).attr('val')).hide();
                        if($.trim($inputObj.attr('val'))!='' && typeof $inputObj.attr('val')!='undefined'){
                            $('.js_city_li_'+$inputObj.attr('val')).show();
                        }
                    } 


                    if (!$(this).hasClass('on')) {
                        $(this).siblings('li').removeClass('on');
                        $(this).addClass('on');
                        $inputObj.val($(this).html());
                        $inputObj.attr('val', $(this).attr('val'));
                        $inputObj.trigger('change');
                    }


                });

                //下拉菜单点击外部关闭
                $(document).on('click', function (e) {
                    var clickObj = $(e.target).parents('.js_list_select_ct');
                    if (!clickObj.length) {
                        $('.js_list_select_ct').find('ul').hide();
                    } else {
                        $('.js_list_select_ct').not(clickObj).find('ul').hide();
                    }
                });

                //卡类型选择
                $('.js_cardType_input').on('change', function () {
                    that.cardTypeId = $(this).attr('val');
                    that.selectCardModel = [];
                    if ($.trim($(this).val()) == '酒店卡') { //显示是否无钥匙入住选项
                        $('#js_select_key').show();
                        if ($('#js_select_key .js_key_input').attr('val') == '1') {
                            $('#js_select_key2').show();
                        }
                    } else {
                        $('#js_select_key,#js_select_key2').hide();
                    }
                    that.loadunits(that.cardTypeId); //加载发卡单位
                    $('.js_units_input').val('');
                    $('.js_model_show').remove();//删除原有卡模板

                });

                //发卡单位选择
                $('.js_units_input').on('change', function () {
                    $(' .js_masklayer').show();
                    var title = $('.js_cardType_input').val()+'类型下查询'+$(this).val()+'的卡模板';
                    that.unitsId = $(this).attr('val');
                    that.selectCardModel=[];
                    var phone = $(this).attr('phone');
                    var params = {};
                    params.cardTypeId = that.cardTypeId;
                    params.cardunits = that.unitsId;
                    $('#js_card_model_title').html(title);
                    $('.js_model_show').remove();//删除原有卡模板
                    that.loadCardModel(params);//加载卡模板

                });

                //酒店卡密钥选项
                $('.js_key_input').on('change', function () {
                    if ($(this).val() == '是') {
                        $('#js_select_key2').show();
                    } else {
                        $('#js_select_key2').hide();
                        $('.js_key_input2').val('否');
                        $('.js_key_input2').attr('val', 2);

                    }
                });

                //城市和排序多个添加
                $('body').on('click', '.js_add', function () {
                    var cloneObj = $('.js_clone_obj').first().clone(true);
                    cloneObj.find('input').val('');
                    cloneObj.find('input').removeAttr('val');
                    cloneObj.find('.js_copy_or_delete').removeClass('js_add').addClass('js_remove').html('-');
                    $('.js_clone_obj').last().after(cloneObj);

                });

                //城市和排序添加多个删除
                $('body').on('click', '.js_remove', function () {
                    var $parentsObj=$(this).parents('.js_clone_obj');
                    $('.js_city_li_'+$parentsObj.find('input').attr('val')).show();
                    $parentsObj.remove();
                });

                //卡模板搜索按钮
                $('.js_serach_card_model input').on('click',function(){
                    params=that.getSearchParams();
                    that.loadCardModel(params);//加载卡模板
                });
                //选择卡模板打开弹窗
                $('.js_card_model').on('click', function () {
                    if ( $('.js_units_input').val()=='' ) {
                        $.global_msg.init({gType: 'warning', icon: 2, msg: '请选择卡类型和发卡单位'});
                    } else {
                        $(' .js_masklayer').show();//遮罩层
                        $('.js_card_model_show').show();
                    }

                });

                //全选
                $('#js_allselect').on('click', function () {
                    if ($(this).hasClass('active')) {
                        $(this).removeClass('active');
                        $('.js_select').removeClass('active');
                    } else {
                        $(this).addClass('active');
                        $('.js_select').addClass('active');
                    }
                });

                //单选
                $('body').on('click', '.js_select', function () {
                    if ($(this).hasClass('active')) {
                        $(this).removeClass('active');
                        $('#js_allselect').removeClass('active');
                    } else {
                        $(this).addClass('active');
                        if($('.js_list_one .js_select').length == $('.js_list_one .active').length){
                            $('#js_allselect').addClass('active')
                        }

                    }
                });

                //卡模板弹窗取消按钮
                $('.js_cancel_select').on('click', function () {
                    $('.js_card_model_show').hide();
                    $('.js_card_model_show input').prop('checked', false);//选择重置
                    $(' .js_masklayer').hide();//关闭遮罩层

                });

                //卡模板弹窗确认按钮
                $('.js_sub_select').on('click', function () {
                    that.getSelectCardModel(that.p);
                    $('.js_model_show').remove();//删除原有卡模板
                    for(var i= 0; i < that.selectCardModel.length; i++){
                        if(that.selectCardModel[i].arr.length){
                            $.each( that.selectCardModel[i].arr,function (n,val) {
                                if(that.selectedCardModel.length){//编辑时和初始化模板做比对
                                    for(var i =0 ; i<that.selectedCardModel.length ; i++){
                                        if(that.selectedCardModel[i].id == val.id){
                                            that.selectedCardModel.splice(i,1);//相同删除
                                        }
                                    }
                                }
                                $('.js_selected_model .mCSB_container').append(
                                    "<span class='js_model_show' val='" + val.id + " '><em>"
                                    + val.name + "" +
                                    "</em><i class='js_del_card_model hand'>x</i></span>"
                                )
                            });
                        }
                    }
                    if(that.selectedCardModel.length){ //编辑时初始化 翻页没显示的
                        for(var j =0 ; j<that.selectedCardModel.length ; j++){
                            $('.js_selected_model .mCSB_container').append(
                                "<span class='js_model_show' val='" + that.selectedCardModel[j].id + " '><em>"
                                + that.selectedCardModel[j].name+ "" +
                                "</em><i class='js_del_card_model hand'>x</i></span>"
                            )
                        }
                    }
                    $('.js_card_model_show').hide();
                    $(' .js_masklayer').hide();//关闭遮罩层

                    //    $.global_msg.init({gType: 'warning', icon: 2 ,msg: '请选择至少一个选择卡模板'});
                });

                //卡模板删除
                $('.js_selected_model').on('click', '.js_del_card_model', function () {
                    $(".js_select[data-id=" + $(this).parent().attr('val') + "]").removeClass('active');//同时删除弹窗列表的勾选
                    $(this).parent().remove();

                });

                //保存添加或编辑
                $('.js_save').on('click', function () {
                    var data = that.checkData();
                    if (data !== false) {
                        that.checkTempid(data);
                        //that.saveData(data);
                    }
                });

                //查看排序
                $('.js_show_sort').on('click',function(){
                    $('.js_show_sort_wrap ul *').remove();
                     var data={};
                     data.cityid=$(this).closest('.js_clone_obj').find('.js_city_input').attr('val');
                     data.typeid=$('.js_type_input').attr('val');
                    if(typeof (data.cityid) == 'undefined' || typeof (data.typeid) == 'undefined'){
                        $.global_msg.init({gType: 'warning', icon: 2, msg: "请选择分类和城市"});
                        return;
                    }
                    $.ajax({
                        url: gShowSortUrl,
                        type: 'post',
                        data: data,
                        success: function (res) {
                            if (res.status == 0 ) {
                                if(res.data!= null){
                                    $.each(res.data.list,function(){
                                        $('.js_show_sort_wrap ul').append(
                                            '<li><em>'+this.sorting+'</em><b>'+this.lssuer+'</b></li>'
                                        )
                                    });
                                }else{
                                    $('.js_show_sort_wrap ul').append(
                                        '<li><em></em><b>NO DATA</b></li>'
                                    )
                                }

                                $(' .js_masklayer').show();
                                $('.js_show_sort_wrap').show();
                            } else {
                                $.global_msg.init({gType: 'warning', icon: 2, msg: "获取失败"});
                            }
                        },
                        fail: function () {
                            $.global_msg.init({gType: 'warning', icon: 2, msg: "获取失败"});
                        }
                    });

                });

                //关闭排序

                $('.js_show_sort_close').on('click',function(){
                    $(' .js_masklayer').hide();
                    $('.js_show_sort_wrap').hide();
                });

                //编辑预览
                $('.js_edit_show_one').on('click', function () {
                    var url = $.trim($('.js_url_input').val());
                    if (that.checkUrl(url)) {
                        that.showOne(url);
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
             * 排序方法
             * @param clickType str 操作类型  'down','up','stick' 向下一位 向上一位 置顶
             * @param data  obj 排序参数数据
             * */
            sort: function (clickType, data) {
                url = gAjaxUrl;
                $.ajax({
                    url: url,
                    data: data,
                    type: 'post',
                    success: function (res) {
                        if (0 == res.status) {
                            $.global_msg.init({
                                gType: 'warning', icon: 1, time: 3, msg: '操作成功', endFn: function () {
                                    window.location.reload();
                                }
                            });
                        } else {
                            $.global_msg.init({gType: 'warning', icon: 2, msg: '操作失败'});
                        }
                    },
                    fail: function () {
                        $.global_msg.init({gType: 'warning', icon: 2, time: 3, msg: '操作失败'});
                    }

                })

            },
            /**
             * 删除
             * @param id str 操作条目的id
             * */
            del: function (id) {
                $.global_msg.init({
                    gType: 'confirm', icon: 2, msg: "确认删除么？", btns: true, close: true,
                    title: false, btn1: "取消", btn2: "确认",
                    noFn: function () {
                        $.ajax({
                            url: gAjaxUrl,
                            data: {id: id, action: 'D'},
                            type: 'post',
                            success: function (res) {
                                if (res.status == '0') {
                                    $.global_msg.init({
                                        gType: 'warning', icon: 1, time: 3, msg: '删除成功', endFn: function () {
                                            window.location.reload();
                                        }
                                    });

                                } else if (res.status = '310004') {
                                    $.global_msg.init({gType: 'warning', icon: 2, msg: '该分类下存在商户权益，不能删除'});

                                } else {
                                    $.global_msg.init({gType: 'warning', icon: 2, msg: '删除失败'});
                                }
                            },
                            fail: function () {
                                $.global_msg.init({gType: 'warning', icon: 2, time: 3, msg: '删除失败'});
                            }
                        })

                    }
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

            /**
             * 检测必填 input
             * */

            noEmpty: function () {
                var res = true;
                $('.js_noempty').each(function () {
                    var value = $(this).val();
                    if ($.trim($(this).val()) == '' || typeof (value) == 'undefined') {
                        $.global_msg.init({gType: 'warning', msg: '请填写完整信息', icon: 2});
                        res = false;
                        return false;
                    }
                });
                return res;

            },

            /**
             * 选择城市弹框三角符号变化
             * */
            triangle: function ($menu) {
                var $triangle = $menu.children(".triangle");//获取三角符号
                if ($triangle.hasClass("triangle-down")) {
                    $triangle.removeClass("triangle-down");
                    $triangle.addClass("triangle-right");
                } else {
                    $triangle.removeClass("triangle-right");
                    $triangle.addClass("triangle-down");
                }
            },

            /**
             * 点击省级下拉菜单事件
             * */
            click_triangle: function () { //菜单点击事件
                var that = this;
                /*点击两个菜单的三角符号的事件*/
                $(".js_province_wrap").on('click', '.triangle', function () {
                    var $menu = $(this).parent();
                    that.triangle($menu);//三角符号变化
                    var $wrap = $(this).parents('.js_province_wrap');
                    var $cityWrap = $wrap.find('.js_city_wrap');
                    if ($cityWrap.find('.js_city_menus').length == 0) {//为加载过
                        var code = $wrap.attr('provincecode');
                        $.ajax({
                            url: getCityUrl,
                            type: "get",
                            data: {
                                provincecode: code
                            },
                            success: function (response) {
                                $.each(response, function () {
                                    var htmlcode = "<div class='up_menus'  code='" + this.prefecturecode + "'>" +
                                        "<span class='menus js_city_menus' >" + this.city + "</span>";
                                    if ($.inArray(this.prefecturecode.toString(), cityCodes) != -1) {
                                        htmlcode += "<input  class='js_choose_city' type='checkbox' checked='checked'  disabled='disabled'  code='" + this.prefecturecode + "'>" + "</div>"
                                    } else {
                                        htmlcode += "<input  class='js_choose_city' type='checkbox'  code='" + this.prefecturecode + "'>" + "</div>"
                                    }
                                    $cityWrap.append(htmlcode);
                                });
                            },
                            fail: function () {
                                $.global_msg.init({ //弹出消息框
                                    gType: 'warning',
                                    icon: 2,
                                    msg: '操作失败！',
                                    close: true,
                                    title: false
                                });
                            }
                        })

                    } else {
                        if ($cityWrap.is(":hidden")) { //判断隐藏和显示
                            $cityWrap.show();
                        } else {
                            $cityWrap.hide();
                        }
                    }

                });

                $(".js_province_wrap").on('click', '.js_choose_city', function () {
                    var code = $(this).attr('code');
                    if ($(this).prop('checked')) {
                        addArr.push(code);
                    } else {
                        addArr.splice($.inArray(code, addArr), 1);
                    }
                })


            },


            /**选定卡类型加载发卡单位
             * @param  cardTypeId   str 卡类型id
             * */
            loadunits: function (cardTypeId) {
                $(' .js_masklayer').show();
                $.ajax({
                    url: gGetUnitsUrl,
                    data: {'cardTypeId': cardTypeId},
                    type: 'get',
                    success: function (res) {
                        if (res.status == 0) {
                            $('.js_units_list ul li').remove();
                            var appendObj = '';
                            $.each(res.list, function (id, info) {
                                appendObj += "<li val='" + id + "' phone='" + info.phone + "'>" + info.name + "</li>";

                            });
                            if ($('.js_units_list ul .mCSB_container').length) {
                                $('.js_units_list ul .mCSB_container').append(appendObj);

                            } else {
                                $('.js_units_list ul ').append(appendObj);
                            }

                        } else {
                            $.global_msg.init({gType: 'warning', icon: 2, msg: '发卡单位获取失败'});
                        }
                        $(' .js_masklayer').hide();//关闭遮罩层
                    },
                    fail: function () {
                        $.global_msg.init({gType: 'warning', icon: 2, msg: '发卡单位获取失败'});
                        $(' .js_masklayer').hide();//关闭遮罩层
                    }
                });

            },

            /**选定卡类型加载卡模板
             * params obj 获取卡模板的参数*
             * */
            loadCardModel: function (params) {
                var that = this;
                $('.js_card_model_list .js_select_mode_one,.js_no_data').remove();//删除弹窗列表
                $('#js_allselect').removeClass('active');
                $.ajax({
                    url: gGetCardModelUrl,
                    data: params,
                    type: 'get',
                    success: function (res) {
                        if (res.status == 0) {
                            if (res.data.numfound > 0) { //有数据
                                var list = res.data.list;
                                var appendObj = '';
                                var pageDate=res.pageData;
                                that.p=res.p;//页数
                                that.otalpage=res.otalpage;//总页数
                                $('.page').html(pageDate);
                                $.each(list, function (index, obj) {
                                    appendObj += "<div class='vipcard_list userpushlist_c checked_style list_hover js_x_scroll_backcolor js_select_mode_one'>" +
                                        "<span class='span_span11 '><i class='js_select' data-id=" + obj.id + " data-name=" + obj.description + "></i></span>" +
                                        "<span class='span_span1'>" + obj.id + "</span>" +
                                        "<span class='span_span2'>" + obj.cardtypename + "</span>" +
                                        "<span class='span_span2' title='"+obj.tempnumber+"'>" + obj.tempnumber + "</span>" +
                                        "<span class='span_span8' title='"+obj.description+"'>" + obj.description + "</span>" +
                                        "<span class='span_span6'>" + obj.iscoop + "</span>" +
                                        "<span class='span_span5'>" + obj.createdtime + "</span>" +
                                        "<span class='span_span6'>" + obj.personnum + "</span>" +
                                        "</div>";
                                });
                                if ($('.js_card_model_list .mCSB_container').length) { //判断滚动条是否加载过
                                    $('.js_card_model_list .mCSB_container').append(appendObj);
                                } else {
                                    $('.js_card_model_list ').append(appendObj);
                                    $('.js_card_model_list').mCustomScrollbar({ //初始化卡模板滚动条
                                        theme: "dark", //主题颜色
                                        autoHideScrollbar: false, //是否自动隐藏滚动条
                                        scrollInertia: 0,//滚动延迟
                                        horizontalScroll: false//水平滚动条
                                    });
                                }
                                if ($('.js_model_show').length > 0) { //编辑回显
                                    $('.js_model_show').each(function () {
                                        var id = $.trim($(this).attr('val'));
                                        $(".js_select[data-id='" + id + "']").addClass('active');
                                    })
                                }
                            } else {
                                $('.js_card_model_list').append("<span class='js_no_data'>NO DATA</span>")
                            }
                        } else {
                            $.global_msg.init({gType: 'warning', icon: 2, msg: '卡模板获取失败'});
                        }
                        $(' .js_masklayer').hide();//关闭遮罩层
                    },
                    fail: function () {
                        $.global_msg.init({gType: 'warning', icon: 2, msg: '卡模板获取失败'});
                        $(' .js_masklayer').hide();//关闭遮罩层
                    }
                })

            },

            /**获取当前卡模板弹窗选择
             * @param  p INT  列表页数
             * */
            getSelectCardModel : function (p){
                var that=this;
                var obj={};
                obj.p=p;
                obj.arr=[];
                $('.js_card_model_list .active').each(function () {
                    var selectObj={};
                    selectObj.id=$(this).attr('data-id');
                    selectObj.name=$(this).attr('data-name');
                    obj.arr.push(selectObj);
                });
                var ifhave=false;
                $.each(this.selectCardModel,function(n,val){
                    if(val.p==p){
                        that.selectCardModel[n]=obj;
                        ifhave=true;
                        return false
                    }
                });
                if(!ifhave){
                    that.selectCardModel.push(obj);
                }
            },

            /**
            * 卡模板弹窗搜索参数
            * */
            getSearchParams :function(){
                var that=this;
                var params={};
                params.cardTypeId = that.cardTypeId;
                params.cardunits = that.unitsId;
                params.starttime = $('#js_begintime').val(); //开始结束时间
                params.endtime = $('#js_endtime').val();
                params.iscoop = $('#js_card_model_iscoop').attr('val');//合作商户
                params.tempnumber = $('#js_card_model_tempnumber').val();//模板编号
                params.keyword =$('#js_card_model_keyword').val();//关键词
                params.order=  $('.js_serach_card_model input').attr('order');
                params.ordertype=  $('.js_serach_card_model input').attr('orderType');
                params.p=that.p;//页数
                return params;

            } ,
            /**
            * 获取当前卡模板弹窗选择
            * */
            getSelectCardModel : function (p){
                var that=this;
                var obj={};
                obj.p=p;
                obj.arr=[];
                $('.js_card_model_list .active').each(function () {
                    var selectObj={};
                    selectObj.id=$(this).attr('data-id');
                    selectObj.name=$(this).attr('data-name');
                    obj.arr.push(selectObj);
                });
                var ifhave=false;
                $.each(this.selectCardModel,function(n,val){
                    if(val.p==p){
                        that.selectCardModel[n]=obj;
                        ifhave=true;
                        return false
                    }
                });
                if(!ifhave){
                    that.selectCardModel.push(obj);
                }
            },

            /**
             * 添加和编辑数据验证组装
             * */
            checkData: function () {
                var that = this;
                var data = {};
                data.cardtypeid = $.trim($('.js_cardType_input').attr('val'));//卡类型
                if (data.cardtypeid == '' || typeof (data.cardtypeid) == 'undefined') {
                    $.global_msg.init({gType: 'warning', icon: 2, msg: '请选择卡类型'});
                    return false;
                }
                data.cardunitid = $.trim($('.js_units_input').attr('val'));//发卡单位
                if (data.cardunitid == '' || typeof (data.cardunitid) == 'undefined') {
                    $.global_msg.init({gType: 'warning', icon: 2, msg: '请选择发卡单位'});
                    return false;
                }
                data.name = $.trim($('.js_units_input').val()); //单位名称
                if (data.name == '' || typeof (data.name) == 'undefined') {
                    $.global_msg.init({gType: 'warning', icon: 2, msg: '请选择发卡单位'});
                    return false;
                }
                data.type= $.trim($('.js_type_input').attr('val')); //分类
                if (data.type == '' || typeof (data.type) == 'undefined') {
                    $.global_msg.init({gType: 'warning', icon: 2, msg: '请选择分类'});
                    return false;
                }

               // data.address = $.trim(that.dataJoin($('.js_address'), 'val')); //地址

                data.citys =that.cityAndSort(); //城市和排序
                if(JSON.stringify( data.citys) == "{}"){
                    $.global_msg.init({gType: 'warning', icon: 2, msg: '请填写城市和排序'});
                    return false;
                }

                data.img= $('.js_img_url').val();
                if($.trim(data.img)=='' || typeof (data.img) == 'undefined'){
                    $.global_msg.init({gType: 'warning', icon: 2, msg: '请上传图片'});
                    return false;
                }

                if( typeof ($('.js_img_url').attr('nochange'))== 'undefined'){//判断编辑时是否重新上传图片
                    data.imgchange=true;
                }else{
                    data.imgchange=false;
                }

                data.tempid = $.trim(that.dataJoin($('.js_model_show'))); //卡模板
                if (data.tempid == '' || typeof (data.tempid) == 'undefined') {
                    $.global_msg.init({gType: 'warning', icon: 2, msg: '请选择卡模板'});
                    return false;
                }

                data.url = $.trim($('.js_url_input').val());
                if (!that.checkUrl(data.url)) { //检测URL
                    return false;
                }

                var imorarights = $.trim($('#js_imorarights_txt').val());
                if (imorarights != '' || typeof (imorarights) != 'undefined') {
                    data.imorarights = imorarights;//mora 权益（非必填）
                }

                if ($('.js_cardType_input').val() == '酒店卡') {
                    data.ifhold = $('.js_key_input').attr('val');//酒店卡是否无钥匙入住（默认否）
                    data.ifkey = $('.js_key_input2').attr('val');//酒店卡无钥匙入住否需要密钥（默认否）
                }

                if ($('#js_edit_id').val() != '' || typeof ($('#js_edit_id').val()) != 'undefined') { //编辑的id
                    data.id = $.trim($('#js_edit_id').val());

                }
                return data

            },

            /**
             * 保存数据添加编辑的数据
             * */
            saveData: function (data) {
                $.ajax({
                    url: gSaveUrl,
                    data: data,
                    type: 'post',
                    success: function (res) {
                        if (res.status == 0) {
                            $.global_msg.init({gType: 'warning', icon: 1, msg: '保存成功'});
                            window.location.href = gUrl;
                        } else if(res.status==999005){
                            $.global_msg.init({gType: 'warning', icon: 2, msg: ' 输入的序号已经存在，请重新输入'});
                        }
                        else {
                            $.global_msg.init({gType: 'warning', icon: 2, msg: '保存失败'});
                        }
                        $(' .js_masklayer').hide();//关闭遮罩层
                    },
                    fail: function () {
                        $.global_msg.init({gType: 'warning', icon: 2, msg: '保存失败'});
                        $(' .js_masklayer').hide();//关闭遮罩层
                    }
                })

            },

            /**
            *检测卡模板是否被占用
             * */
            checkTempid: function (data) {
                var that = this;
                $(' .js_masklayer').show();//遮罩层
                var getDataOBJ = {};
                getDataOBJ.tempid = data.tempid;
                if (data.id != '' || typeof (data.id) != 'undefined') { //编辑
                    getDataOBJ.id = data.id;//用来标识本身的卡模板
                }
                $.ajax({
                    url: gCheckTempIdUrl,
                    data: getDataOBJ,
                    type: 'get',
                    success: function (res) {
                        if (res.status == 0) {
                            if (typeof (res.data) != 'undefined' && '' != res.data.lists.faild) { //存在占用模板
                                var faildObj = res.data.lists.faild;
                                var description;//模板名称(第一个)
                                var count = 0;
                                var tempIdArr = [];
                                $.each(faildObj, function (index,obj) {
                                    if (count == 0) {
                                        description = obj.description;
                                    }
                                    tempIdArr.push(parseInt($.trim(obj.card_temp_id)));
                                    count++;
                                });
                                var msg = '[' + description + ']';
                                if (count > 1) {
                                    msg += '等' + count + '个';
                                }
                                $.global_msg.init({
                                    gType: 'confirm', icon: 2, msg: msg + "模板已存在商户详情，是否变更？", btns: true, close: true,
                                    title: false, btn1: "取消", btn2: "确认",
                                    noFn: function () { //确认
                                        that.saveData(data);
                                    },
                                    fn: function () {
                                        $('.js_model_show').each(function () {
                                            var tempId = parseInt($.trim($(this).attr('val')));
                                            if ($.inArray(tempId,tempIdArr) != -1) {
                                                $(this).find('em').css("color", "red");
                                            }
                                        });
                                        $(' .js_masklayer').hide();//关闭遮罩层*/
                                    }
                                })
                            } else { //不存在暂用模板
                                that.saveData(data);
                            }
                        } else {
                            $.global_msg.init({gType: 'warning', icon: 2, msg: '检测失败，请重试'});
                        }
                        $(' .js_masklayer').hide();//关闭遮罩层*/
                    },
                    fail: function () {
                        $.global_msg.init({gType: 'warning', icon: 2, msg: '检测失败，请重试'});
                        $(' .js_masklayer').hide();//关闭遮罩层
                    }
                })

            },

            /**
             * $obj 循环的html 对象 $(.class)
             * type attr 或 .val()
             *  */
            dataJoin: function ($obj, type) {
                type = type || 'attr';
                var data = [];
                var val = '';
                if (type == 'attr') {
                    $obj.each(function () {
                        val = $.trim($(this).attr('val'));
                        if (val != '') {
                            data.push(val);
                        }
                    });
                } else {
                    $obj.each(function () {
                        val = $.trim($(this).val());
                        if (val != '') {
                            data.push(val);
                        }
                    });
                }
                data = data.join(",");
                return data;

            },

            /**
            *  城市和排序处理
            * */
            cityAndSort:function(){
                var data = {};
                var val='';
                $('.js_clone_obj').each(function(){
                    if($(this).find('.js_city_input').attr('val')!='' && typeof $(this).find('.js_city_input').attr('val') != 'undefined'){
                        var cityId=$(this).find('.js_city_input').attr('val');
                        var sorting= $.trim($(this).find('.js_sorting_input').val());
                        sorting= sorting=='' ? 0 : sorting;
                        data[cityId]=sorting
                    }
                });
              return data;
            },

            /**
             * 检测URL
             * $url str 检测的URL地址
             * */
            checkUrl: function (url) {
                if (url == '' || typeof (url) == 'undefined') {
                    $.global_msg.init({gType: 'warning', icon: 2, msg: '请填写展示URL地址'});
                    return false;
                }
                var urlReg = /(http|https):\/\/[\w\-_]+(\.[\w\-_]+)+([\w\-\.,@?^=%&:/~\+#]*[\w\-\@?^=%&/~\+#])?/;
                if (!urlReg.test(url)) {
                    $.global_msg.init({gType: 'warning', icon: 2, msg: '请正确填写展示URL地址格式,如:http://xxxx.com'});
                    return false;
                }

                return true;

            },

            /**删除商户详情
             *
             * ids str 单个或者多个id 逗号隔开
             * */
            delstore: function (ids) {
                //确认删除
                $.ajax({
                    url: gDeleteUrl,
                    type: 'post',
                    data: {id: ids},
                    success: function (res) {
                        if (res.status == 0) { //删除成功
                            $.global_msg.init({
                                gType: 'alert', icon: 1, msg: '已删除',
                                endFn: function () {
                                    window.location.reload();
                                }
                            });
                        } else {
                            $.global_msg.init({gType: 'warning', icon: 2, msg: "ID" + res.errorIds + "删除失败！"});
                        }
                    },
                    fail: function () {
                        $.global_msg.init({gType: 'warning', icon: 2, msg: "删除失败！"});
                    }
                });

            },
            /**
             *预览
             * url str h5 url
             * */
            showOne: function (url) {
                $('#js_iframe_area').attr('src',url);
                $(' .js_masklayer').show();
                $('.js_review_box').show();

            },

        }
    })

})(jQuery);
