/**
 * orange 单位详情管理 js
 *
 * */
;(function ($) {
    $.extend({
        OraUnitDetail: {
            cardTypeId : '',//卡类型id
            unitsId:'',//发卡单位id
            p : 1,//卡模板列表页数
            otalpage : 1,//卡模板列表总页数
            selectCardModel : [],//选择的卡模板
            selectedCardModel: [],//编辑时默认初始化的卡模板数据
            init: function () {
                var that = this;
                $('.js_firsttype').selectPlug({getValId: 'cardType', defaultVal: ''}); //卡类型

                /*初始化滚动条*/
                $('.js_list_select ul,.js_selected_model,.js_phone_address_wrap').mCustomScrollbar({ //初始化滚动条
                    theme: "dark", //主题颜色
                    autoHideScrollbar: false, //是否自动隐藏滚动条
                    scrollInertia: 0,//滚动延迟
                    horizontalScroll: false//水平滚动条
                });

                /*初始化获取编辑时已选择的模板数据*/

                if($('.js_model_show').length > 0){
                    $('.js_model_show').each(function(){
                        var obj={};
                        obj.id=$(this).attr('val');
                        obj.name=$(this).find('em').html();
                        that.selectedCardModel.push(obj);
                    })

                }


                if ($('.js_cardType_input').length > 0 && $('.js_cardType_input').val() != '') { //编辑时初始化弹窗数据
                    this.cardTypeId = $('.js_cardType_input').attr('val');
                    this.unitsId =    $('.js_units_input').attr('val');
                    var title = $('.js_cardType_input').val()+'类型下查询'+$('.js_units_input').val()+'的卡模板';
                    $('#js_card_model_title').html(title);
                    var params = this.getSearchParams();
                    this.loadCardModel(params);//加载卡模板
                }

                this.event();
            },
            event: function () {
                var that = this;
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

                //删除
                $('#js-delete').click(function () {
                    var itemLength = $('.js_select.active').length;
                    if (itemLength < 1) {
                        $.global_msg.init({gType: 'warning', icon: 2, msg: "请选择单位详情！"});
                        return false;
                    }
                    var ids = [];
                    for (var i = 0; i < itemLength; i++) {
                        ids.push($('.js_select.active').eq(i).attr('val'));
                    }
                    ids = ids.join(',');

                    $.global_msg.init({
                        gType: 'confirm', icon: 2, msg: "确认删除么？", btns: true, close: true,
                        title: false, btn1: "取消", btn2: "确认",
                        noFn: function () {
                            that.del(ids);
                        }
                    });

                    return false;
                });

                //下拉列表
                $('.js_list_select').on('click', function () {
                    if ($(this).find('li').length == 0 && $(this).hasClass('js_units_list')) {
                        $.global_msg.init({gType: 'warning', icon: 2, msg: '请选择卡类型'});
                    } else {
                        $(this).find('ul').toggle();
                    }

                });

                //下拉选择
                $('.js_list_select').on('click', 'li', function () {
                    if (!$(this).hasClass('on')) {
                        $(this).siblings('li').removeClass('on');
                        $(this).addClass('on');
                        var $inputObj = $(this).parents('.js_list_select').find('input');
                        $inputObj.val($(this).html());
                        $inputObj.attr('val', $(this).attr('val'));
                        if(typeof $(this).attr('phone') != 'undefined'){ //电话
                            $inputObj.attr('phone', $(this).attr('phone'));
                        }
                        $inputObj.trigger('change');
                    }
                });

                //下拉菜单点击外部关闭
                $(document).on('click', function (e) {
                    var clickObj = $(e.target).parents('.js_list_select');
                    if (!clickObj.length) {
                        $('.js_list_select').find('ul').hide();
                    } else {
                        $('.js_list_select').not(clickObj).find('ul').hide();
                    }
                });

                //卡类型选择
                $('.js_cardType_input').on('change', function () {
                    that.cardTypeId = $(this).attr('val');
                    that.selectCardModel=[];
                    if ($.trim($(this).val()) == '酒店卡') { //显示是否无钥匙入住选项
                        $('#js_select_key').show();
                        if( $('#js_select_key .js_key_input').attr('val')=='1'){
                            $('#js_select_key2').show();
                        }
                    } else {
                        $('#js_select_key,#js_select_key2').hide();
                    }
                    that.loadunits(that.cardTypeId); //加载发卡单位
                    $('.js_units_input').val('');
                    $('.js_model_show').remove();//删除原有卡模板
                    /*默认电话*/
                    $('.js_add_div:gt(0)').remove();
                    $('.js_add_div input').val("");
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
                               /*默认电话*/
                    $('.js_add_div:gt(0)').remove();
                    $('.js_add_div input').val("");
                    $('.js_telephone').eq(0).val(phone);


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

                //电话和地址添加多个添加
                $('body').on('click', '.js_add', function () {
                    var cloneObj = $('.js_add_div').first().clone();
                    cloneObj.find('input').val('');
                    cloneObj.find('.js_copy_or_delete').removeClass('js_add').addClass('js_remove').html('-');
                    $('.js_add_div').last().after(cloneObj);

                });

                //电话和地址添加多个删除
                $('body').on('click', '.js_remove', function () {
                    $(this).parents('.js_add_div').remove();
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

                //权益选择事件
                $('input:radio').on('change', function () {
                    if ($(this).val() == 'img') {
                        $('.js_img_upload_wrap').show();
                        $('.js_textarea_wrap').hide();
                    } else {
                        $('.js_img_upload_wrap').hide();
                        $('.js_textarea_wrap').show();
                    }
                });

                //保存添加或编辑
                $('.js_save').on('click', function () {
                    var data = that.checkData();
                    if (data !== false) {
                        that.checkTempid(data);
                        //that.saveData(data);
                    }
                });

                //列表预览
                $('.js_show_one').on('click', function () {
                    var data = {};
                    data.imorarights = $(this).attr('data-imorarights');
                    data.url=$(this).attr('data-url');
                    that.showOne(data);

                });

                //编辑预览
                $('.js_edit_show_one').on('click', function () {
                    var data = {};
                    var imorarights = $('#js_imorarights_txt').val();
                    if (typeof (imorarights) != 'undefined') {
                        data.imorarights = imorarights;//mora 权益（非必填）
                    } else {
                        data.imorarights = '';
                    }
                    data.url = $.trim($('.js_url_input').val());

                    if (that.checkUrl(data.url)) {
                        that.showOne(data);
                    }

                });

                //关闭预览框
                $('.js_btn_close img').on('click', function () {
                    $('.js_review_box ').hide();
                    $(' .js_masklayer').hide();
                });

                //卡模板搜索按钮
                $('.js_serach_card_model input').on('click',function(){
                    params=that.getSearchParams();
                    that.loadCardModel(params);//加载卡模板
                });

                //卡模板弹窗排序

                $('.js_sort_data').on('click',function(){
                    $('.js_sort_data').not($(this)).removeClass('list_sort_desc','list_sort_asc').addClass('list_sort_none');
                    var orderType='asc';
                    if($(this).hasClass('list_sort_none')){
                        $(this).removeClass('list_sort_none').addClass('list_sort_desc');
                    }else if($(this).hasClass('list_sort_desc')){
                        $(this).removeClass('list_sort_desc').addClass('list_sort_asc');
                        orderType='desc';
                    }else if($(this).hasClass('list_sort_asc')){
                        $(this).removeClass('list_sort_asc').addClass('list_sort_desc');
                    }
                    $('.js_serach_card_model input').attr('order',$(this).attr('sort_type'));
                    $('.js_serach_card_model input').attr('orderType',orderType);
                    var params=that.getSearchParams();
                    that.loadCardModel(params);
                });

                //卡模板弹窗翻页
                $('.js_card_model_show .page').on('click','.next',function(e){ //向下翻页
                    e.preventDefault();//阻止a默认行为
                    that.getSelectCardModel(that.p);//获取当前页选择的模板
                    that.p=parseInt(that.p)+1;
                    var params=that.getSearchParams();
                    that.loadCardModel(params);

                });

                $('.js_card_model_show  .page').on('click','.prev',function(e){ //向上翻页
                    e.preventDefault();//阻止a默认行为
                    that.getSelectCardModel(that.p);//获取当前页选择的模板
                    that.p=parseInt(that.p)-1;
                    var params=that.getSearchParams();
                    that.loadCardModel(params);

                });

                $('.js_card_model_show  .page').on('click',':submit',function(e){ //直接跳转
                    e.preventDefault();//阻止a默认行为
                    that.getSelectCardModel(that.p);//获取当前页选择的模板
                    var p = $('.page :text').val();
                    p = p < 0 ? 1 : p;
                    p = p > that.otalpage ? that.otalpage : p;
                    that.p=p;
                    var params=that.getSearchParams();
                    that.loadCardModel(params);
                });


            },

            /**删除单位
             *
             * ids str 单个或者多个id 逗号隔开
             * */
            del: function (ids) {
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
                                    window.location.href = gBackUrl;
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

            /**选定卡类型加载发卡单位
             *
             *cardTypeId str 卡类型id
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
                                appendObj += "<li val='" + id + "' phone='"+info.phone+"'>" + info.name + "</li>";

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
             *
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

            /*添加和编辑数据验证组装*/
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

                data.address = $.trim(that.dataJoin($('.js_address'), 'val')); //地址
                data.phones = $.trim(that.dataJoin($('.js_telephone'), 'val')); //电话
                if (data.address == '' || data.phones == '' || typeof (data.address) == 'undefined' || typeof (data.phones) == 'undefined') {
                    $.global_msg.init({gType: 'warning', icon: 2, msg: '请填写地址和电话'});
                    return false;
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
            /**/
            /*保存数据添加编辑的数据*/
            saveData: function (data) {
                $.ajax({
                    url: gSaveUrl,
                    data: data,
                    type: 'post',
                    success: function (res) {
                        if (res.status == 0) {
                            $.global_msg.init({gType: 'warning', icon: 1, msg: '保存成功'});
                            window.location.href = gUrl;
                        } else {
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
            /*检测卡模板是否被占用*/
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

            /*预览*/
            showOne: function (data) {
                $('#js_iframe_area_1').html(data.imorarights);
                $('#js_iframe_area_2').attr('src', data.url);
                $(' .js_masklayer').show();
                $('.js_btn_new_preview').show();

            },
            /*检测URL*/
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
            /*卡模板弹窗搜索参数*/
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
            /*获取当前卡模板弹窗选择*/
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
            /*数组数据返回‘，’组装*/
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

            }
        }
    })
})(jQuery);
