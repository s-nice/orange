/**
 * orange 推荐规则管理-标签管理js
 *
 * */
var checkObj = '';//全选功能对象
var startIndex = 1; //类型菜单显示第一个的index （‘全部’类型为0 所以1开始）
var lastIndex = $('.js_label_type:last').index();//类型菜单显示最后一个的index
;(function ($) {
    $.extend({
        loop: 0,
        orangeLabel: {
            /*事件初始化*/
            init: function () {
                this.initEvent();//初始化页面事件
                this.initScrollBar();//初始化'全部'标签列表容器滚动条
                this.initCheck();//初始化页面中的全选框功能
                this.search();//搜索标签
                this.selectType();//选择标签类型
                this.del();//删除标签
                this.delType();//删除标签类型
                this.typeMenu();//类型菜单左右显示隐藏
                this.showNoData();
            },
            /*初始化页面事件*/
            initEvent: function () {
                /*所有弹框取消按钮*/
                var that = this;
                $('.js_box_cancel').on('click', function () {
                    that.resetBox();
                });
                
                /*所有弹框input输入内容后确定按钮可用,无内容不可用*/
                $('.js_box_input').on('keyup', function () {
                    var $buttonObj = $(this).next('.eidt_label_btn').find('.js_submit_button');
                    if ($.trim($(this).val()) != '') {
                        $buttonObj.attr('disabled', false);
                        $buttonObj.removeClass('button_disabel');
                    } else {
                        $buttonObj.attr('disabled', true);
                        $buttonObj.addClass('button_disabel');
                    }
                });

                /*添加类事件*/
                $('#js_add_label_type').on('click', function () { //显示弹出框
                    $('#js_add_type_box .js_submit_button').addClass('js_submit_label_type');
                    $('#js_add_type_box .js_submit_button').removeClass('js_submit_edit_type');
                    $('#js_add_type_box,.js_masklayer').show();


                });
                $('#js_add_type_box ').on('click','.js_submit_label_type', function () { //点击提交
                    if (!$(this).hasClass('clicking')) {
                        var val = $.trim($('.js_box_input:visible').val());
                        $(this).addClass('clicking');
                        that.addType(val);
                    }
                });
                /*修改标签类型*/
                $('.js_label_type_wrap').on('click','.js_edit_type',function(){
                    var oldName = $.trim($(this).siblings('h6').html());//原类型名
                    var typeId  =$(this).parent('li').attr('type-id');
                    $(this).parent('li').attr('edit','on');//标记被编辑的类型
                    $('#js_add_type_box input').val(oldName);
                    $('#js_add_type_box input').attr('type-id',typeId);
                    $('#js_add_type_box .js_submit_button').addClass('js_submit_edit_type');
                    $('#js_add_type_box .js_submit_button').removeClass('js_submit_label_type');
                    $('#js_add_type_box,.js_masklayer').show();
                });
                $('#js_add_type_box'). on('click','.js_submit_edit_type',function(){
                    var data={};
                    data.name=  $('#js_add_type_box input').val();
                    data.typeId=$('#js_add_type_box input').attr('type-id');
                    if (typeof(data.name) != 'undefined' && typeof(data.typeId) != 'undefined' && !$(this).hasClass('clicking')) {
                        $(this).addClass('clicking');
                        that.editType(data);
                    } else {
                        $.global_msg.init({gType: 'warning', icon: 2, msg: '编辑失败'});
                    }

                });
                /*修改标签事件*/
                $('#js_edit_label').on('click', function () { //显示弹出框
                    var oldName = $.trim($('.js_select.active:visible').attr('data-name'));//原标签名
                    $('#js_add_label_box input').val(oldName);
                    $('#js_add_label_box .js_submit_button').addClass('js_edit_sub');
                    $('#js_add_label_box .js_submit_button').removeClass('js_add_sub');
                    $('#js_add_label_box,.js_masklayer').show();

                });
                $('#js_add_label_box').on('click', '.js_edit_sub', function () { //点击提交
                    var type = $('.js_select.active:visible').attr('type-id');//类型id
                    var data = {};
                    data.type = type;//类型id
                    data.action = 'editLabel';
                    data.id = checkObj.getCheck()[0];//标签id
                    data.tag = $.trim($('#js_add_label_box input').val());//标签名称
                    if (typeof(data.id) != 'undefined' && typeof(data.tag) != 'undefined' && !$(this).hasClass('clicking')) {
                        $(this).addClass('clicking');
                        that.addOrEditLabel(data);
                    } else {
                        $.global_msg.init({gType: 'warning', icon: 2, msg: '编辑失败'});
                    }
                });
                /*添加标签事件*/
                $('#js_add_label').on('click', function () { //显示弹框
                    $('#js_add_label_box,.js_masklayer').show();
                    $('#js_add_label_box .js_submit_button').addClass('js_add_sub');
                    $('#js_add_label_box .js_submit_button').removeClass('js_edit_sub');

                });
                $('#js_add_label_box').on('click', '.js_add_sub', function () { //点击提交
                    var data = {};
                    data.tag = $.trim($('#js_add_label_box input').val());//标签名
                    data.type = $('.js_label_type.on').attr('type-id');//类型id
                    data.cardtypeid=gCardtypeid;
                    data.action = 'addLabel';
                    if (typeof(data.tag) != 'undefined' && !$(this).hasClass('clicking')) {
                        $(this).addClass('clicking');
                        that.addOrEditLabel(data);
                    } else {
                        $.global_msg.init({gType: 'warning', icon: 2, msg:gAddFailMsg});
                    }
                });
                //选择卡类型事件
                $('.js_card_type_list>li').on('click', function () {
                    if(!$(this).hasClass('on')){
                        $('.js_card_type_list>li').removeClass('on');
                        $(this).addClass('on');
                        window.location.href="?cardType=" + $(this).attr('val');
                    }
                });
            },
            /*初始化页面中的选择框功能*/
            initCheck: function () {
                checkObj = $('.content_hieght').checkDialog({
                    checkAllSelector: '#js_allselect',
                    checkChildSelector: '.js_select',
                    valAttr: 'data-id',
                    selectedClass: 'active',
                    clickFn: function () { //根据勾选个数 判断删除和编辑按钮状态
                        switch ($('.rank_label .active:visible').length) {
                            case 0://无勾选时删除编辑按钮都为不可用
                                $('#js_del_label').attr('disabled', true);
                                $('#js_del_label').addClass('button_disabel');
                                $('#js_edit_label').attr('disabled', true);
                                $('#js_edit_label').addClass('button_disabel');
                                break;
                            case 1://只勾一个时编辑删除按钮都为可用
                                $('#js_del_label').attr('disabled', false);
                                $('#js_del_label').removeClass('button_disabel');
                                $('#js_edit_label').attr('disabled', false);
                                $('#js_edit_label').removeClass('button_disabel');
                                break;
                            default://默认 勾选大于1 删除按钮可用，编辑不可用）
                                $('#js_del_label').attr('disabled', false);//有勾选删除按钮为可用
                                $('#js_del_label').removeClass('button_disabel');
                                $('#js_edit_label').attr('disabled', true);
                                $('#js_edit_label').addClass('button_disabel');
                        }
                    }
                });

            },
            /*标签搜索*/
            search: function () {
                var that = this;
                $('#js_label_search').on('click', function () {
                	var cardType  = gCardtypeid;
                    var searchVal = encodeURIComponent($.trim($('#js_search_val').val()));//搜索的值
                    window.location.href = gUrl + '?name=' + searchVal + '&cardType='+cardType;//跳转
                });
            },
            /*点击选择类型*/
            selectType: function () {
                /*点击类型选项事件*/
                var that = this;
                $('.js_label_type_wrap').on('click', 'h6', function () {
                    var $wrap=$(this).parent('li');
                    if (!$wrap.hasClass('on')) { //样式
                        var typeId = $wrap.attr('type-id');//类型id
                        var $wrapObj = $(".js_label_list_wrap[type-id=" + typeId + "]");//对应类型的容器对象
                        $('.js_label_type').removeClass('on');
                        $wrap.addClass('on');
                        that.resetSelect();//重置勾选
                        if (typeId == 'all') { //类型为全部时添加按钮不可用
                            $('#js_add_label').attr('disabled', true);
                            $('#js_add_label').addClass('button_disabel');
                        } else {
                            $('#js_add_label').attr('disabled', false);
                            $('#js_add_label').removeClass('button_disabel');
                        }
                        $('.js_label_list_wrap').hide();//隐藏其它类型容器
                        if ($wrapObj.length == 0) { //根据对应容器是否存在判断是否加载过
                            $('#js_wrap_main').append( //未加载过添加对应容器
                                "<div class='rank_list_content js_label_list_wrap' type-id='" + typeId + "' load-p='" + 0 + "' >" +
                                "<span class='js_loading'>loading....</span>" +
                                "</div>"
                            );
                            that.scrollbarAjax();//加载数据
                        } else if ($wrapObj.attr('load-p') == '0') { //添加或编辑后的重新加载数据
                            $wrapObj.append("<span class='js_loading'>loading....</span>")
                            that.scrollbarAjax($wrapObj);//加载数据
                            $wrapObj.show();
                        } else { //已加载 显示容器
                            $wrapObj.show();
                        }
                    }
                });

            },
            /*判断删除和显示 'no data'*/
            showNoData: function () {
                if ($('.rank_label:visible').length == 0 && $('.js_no_data:visible').length == 0) {
                    $('.js_label_list_wrap:visible').append("<span class='js_no_data'>NO DATA</span>");
                } else if ($('.rank_label').length > 0 && $('.js_no_data:visible').length > 0) {
                    $('.js_no_data:visible').remove();
                }
            },
            /*删除标签*/
            del: function () {
                var that = this;
                $('#js_del_label').on('click', function () { //点击删除按钮事件
                    $.global_msg.init({
                        gType: 'confirm', icon: 2, msg: gDelConfirmMsg, btns: true, close: true,
                        title: false, btn1: gCancelMsg, btn2: gConfirmMsg, noFn: function () {//确认删除
                            var checkIdArr = checkObj.getCheck();//返回的勾选删除标签的ID
                            var data = checkIdArr.join(',');//每个id逗号隔开
                            /*如果在‘全部’类型中删除 获取删除类型id的集合用来重置对应容器*/
                            if ($('.js_label_list_wrap:visible').attr('type-id') == 'all') {
                                var typeList = [];
                                $('.js_select.active:visible').each(function () { //循环勾选的对象
                                    var typeId = $(this).attr('type-id'); //每个勾选标签的类型id
                                    if (typeList.indexOf(typeId) == -1) { //判断去重
                                        typeList.push(typeId);//不重复加入数组
                                    }
                                });
                            }
                            if (typeof(data) != 'undefined') {//id不为空提交数据
                                $.ajax({
                                    url: gUrl,
                                    type: 'post',
                                    data: {
                                        id: data, action: 'delLabel'
                                    },
                                    success: function (res) {
                                        if (res.status == 0) { //删除成功
                                            if(typeof(res.data.fai)!='undefined'){//判断已使用的标签删除失败
                                             /*   var failArr=res.data.fai;
                                                for(var i=0;i<failArr.length;i++){
                                                      failArr[i]=$(".js_select[data-id="+failArr[i]+"]").attr('data-name')
                                                }
                                                var failMsg=failArr.join(',')+'已添加到卡模板中，不可删除';*/
                                                var failMsg='已应用到卡模板中的标签未能删除';
                                                $.global_msg.init({gType: 'warning', icon: 2, msg: failMsg});

                                            }
                                            $('.rank_label:visible').remove();//删除所有删除前的标签
                                            $('.js_label_list_wrap:visible').attr('load-p', 0);//标记加载为0，未加载
                                            that.scrollbarAjax();//ajax重新加载
                                            that.resetSelect();//重置按钮
                                            // 在单个类型容器下删除标签，重置‘全部’类型容器
                                            // 相反在‘全部’ 类型下删除标签 重置删除的标签对应类型下的容器
                                            if (typeof (typeList) == 'undefined') { //判断点击删除所在的容器
                                                that.resetWrap($('.js_label_list_wrap[type-id=all]'));//在单个类型中点击删除 只重置‘全部类型’的容器
                                            } else { //在‘全部’类型中删除 把删除标签对应的类型的容器都重置
                                                for (var i = 0; i < typeList.length; i++) {
                                                    that.resetWrap($(".js_label_list_wrap[type-id=" + typeList[i] + "]"));
                                                }
                                            }

                                        } else {
                                            $.global_msg.init({gType: 'warning', icon: 2, msg: gDelFailMsg});
                                        }
                                    },
                                    fail: function () {
                                        $.global_msg.init({gType: 'warning', icon: 2, msg: gDelFailMsg});
                                    }
                                })
                            } else {
                                $.global_msg.init({gType: 'warning', icon: 2, msg:gDelFailMsg});
                            }
                        }
                    });
                });
            },
            /*类型菜单左右显示隐藏*/
            typeMenu: function () {
                if (lastIndex <= 6) {
                    $('#js_right_btn').find('b').addClass('r_color'); //初始化右侧箭头 少于5个标签样式不可点击
                }

                $('#js_right_btn').on('click', function () {
                    if (lastIndex > startIndex + 5) {
                        startIndex += 5;
                        $(".js_label_type:gt(0)").hide();
                        $(".js_label_type:gt(" + (startIndex - 1) + "):lt(5)").show();
                        $('#js_left_btn').find('b').removeClass('l_color');
                        if (lastIndex <= startIndex + 5) {
                            $(this).find('b').addClass('r_color');
                        }
                    }
                  //  console.log(startIndex,lastIndex);
                });
                $('#js_left_btn').on('click', function () {
                    if (startIndex > 1) {
                        startIndex -= 5;
                        $(".js_label_type:gt(0)").hide();
                        $(".js_label_type:gt(" + (startIndex - 1) + "):lt(5)").show();
                        $('#js_right_btn').find('b').removeClass('r_color');
                        if (startIndex <= 1) {
                            $(this).find('b').addClass('l_color');
                        }
                    }
                    //console.log(startIndex,lastIndex);
                });

            },
            /*初始化容器滚动条*/
            initScrollBar: function ($wrapObj) {
                var that = this;
                $wrapObj = typeof ($wrapObj) == 'object' ? $wrapObj : $('.js_label_list_wrap:visible');
                var numfound = parseInt($wrapObj.attr('numfound'));
                var type = $wrapObj.attr('type-id');
                if (numfound > gMaxNum) {
                    var maxHeight = $wrapObj.height() - 10 + 'px';
                    $wrapObj.css('max-height', maxHeight);
                    var scrollObj = $wrapObj;
                    if (!scrollObj.hasClass('mCustomScrollbar')) {
                        scrollObj.mCustomScrollbar({
                            theme: "dark", //主题颜色
                            autoHideScrollbar: false, //是否自动隐藏滚动条
                            scrollInertia: 0,//滚动延迟
                            horizontalScroll: false,//水平滚动条
                            callbacks: {
                                onTotalScroll: function () {
                                    var p = $wrapObj.attr('load-p');
                                    if ($('.js_loading:visible').length == 0 && numfound > gMaxNum * p) {
                                        $('.mCSB_container:visible').append("<span class='js_loading'>loading....</span>");
                                        that.scrollbarAjax();
                                    }
                                }
                            }
                        });
                    }
                }
            },
            /*加载失败重新加载 标记*/
            /*ajax查询标签失败运行*/
            ajaxLoadFail: function () {
                if (this.loop > 3) {//失败后 最多请求3次
                    this.scrollbarAjax();
                    this.loop += 1;
                } else {
                    $('.js_loading:visible').html(gLoadingFailMsg)
                }
            },
            /*ajax滚动加载和初始化数据*/
            scrollbarAjax: function ($wrapObj) {
                var that = this;
                $wrapObj = typeof ($wrapObj) == 'object' ? $wrapObj : $('.js_label_list_wrap:visible');
                var p = parseInt($wrapObj.attr('load-p'));
                var type = $wrapObj.attr('type-id');
                type = type == 'all' ? '' : type;
                $.ajax({
                    url: gUrl,
                    type: 'get',
                    data: {p: p + 1, type: type, name: gName ,cardType:gCardtypeid},
                    success: function (res) {
                        // console.log(res.data.list);
                        if (res.status != 0) {
                            that.ajaxLoadFail();
                        } else {
                            $wrapObj.attr('load-p', p + 1);
                            $('.js_loading:visible').remove();
                            if (res.data.numfound != 0) {
                                var list = res.data.list;
                                var data = '';
                                for (var i = 0; i < list.length; i++) {
                                    data += "<div class='rank_label'>" +
                                        "<span class='span_span11'>" +
                                        "<i class='js_select' data-name='" + list[i].tag + "' type-id='" + list[i].typeid + "' data-id='" + list[i].id + "'></i>" +
                                        "</span><em class='js_label_name' title='" + list[i].tag + "'>" + list[i].tag + "</em></div>";
                                }
                                if ($('.mCSB_container:visible').length > 0) {
                                    $('.mCSB_container:visible').append(data);
                                } else {//首次加载
                                    $wrapObj.append(data);
                                    $wrapObj.attr('numfound', res.data.numfound);
                                    that.initScrollBar($wrapObj);//初始化新容器滚动条
                                }
                            } else {
                                that.showNoData();
                            }
                            $('#js_allselect').removeClass('active');
                        //    that.resetSelect();//重置勾选
                        }
                    },
                    fail: function () {
                        this.ajaxLoadFail();
                    }
                });
            },
            /*重置勾选*/
            resetSelect: function () {
                $('.js_select').removeClass('active');
                $('#js_del_label').attr('disabled', true);
                $('#js_del_label').addClass('button_disabel');
                $('#js_edit_label').attr('disabled', true);
                $('#js_edit_label').addClass('button_disabel');
                $('#js_allselect').removeClass('active');//全选按钮
            },
            /*重置弹框*/
            resetBox: function () {
                $('.js_masklayer').hide();
                $('.js_box_input').val("");
                $('.show_label').hide();
                var $buttonObj = $('.js_submit_button');
                $buttonObj.attr('disabled', true);
                $buttonObj.addClass('button_disabel');
            },
            /*添加标签类型*/
            addType: function (val) {
                var that = this;
                if (val.length > 32) {
                    $.global_msg.init({gType: 'warning', msg: gMaxLengthFailMsg, icon: 2});
                    return;
                }
                $.ajax({
                    url: gUrl,
                    type: 'post',
                    data: {
                        name: val,
                        cardtypeid:gCardtypeid,
                        action: 'addType'
                    },
                    success: function (res) {
                        if (res.status == '0') {
                            lastIndex += 1;
                            var data=  "<li class='js_label_type' type-id='" + res.data.id + "' style='display:none'><h6>" +
                                res.data.name + "</h6><i class='i_edit js_edit_type'>"+
                                "<img src='/images/icon_pencil-edit.png'>"+
                               "</i><i class='js_del_type i_remove'>X</i></li>";//插入的数据
                            if( $('.js_label_type').length>1){ //除‘全部外’不为空
                                $('.js_label_type').last().after(data);
                            }else{ //在左侧按钮后插入
                                $('#js_left_btn').after(data);
                            }

                            if ($('.js_label_type:visible').length < 6) { //如果是最后一页 显示新添加的标签
                                $('.js_label_type').last().show();

                            } else if ($('.js_label_type:visible').length == 6) {
                                $('#js_right_btn').find('b').removeClass('r_color'); //右侧箭头可点击

                            }
                            that.resetBox();//重置弹框

                        } else if (res.status == '999005') {//有重复
                            $.global_msg.init({gType: 'warning', msg: gExistTypeMsg, icon: 2});

                        } else {
                            $.global_msg.init({gType: 'warning', msg: gAddFailMsg, icon: 2});
                        }
                    },
                    fail: function () {
                        $.global_msg.init({gType: 'warning', msg: gAddFailMsg, icon: 2});
                    }
                });
                $('.js_submit_label_type').removeClass('clicking');
            },
            /*编辑标签类型*/
            editType:function(data){
                var that = this;
                if (data.name.length > 32) {
                    $.global_msg.init({gType: 'warning', msg: gMaxLengthFailMsg, icon: 2});
                    return;
                }
                data.action='editType';
                $.ajax({
                    url:gUrl,
                    type:'post',
                    data:data,
                    success:function(res){
                        if(res.status==0){//成功
                            var obj=   $('.js_label_type[edit=on]');//被编辑类型的对象
                            obj.find('h6').html(data.name);
                            obj.removeAttr('edit');
                            that.resetBox();//重置弹框
                        }else if(res.status==360002){
                            $.global_msg.init({gType: 'warning', msg: '编辑的类型已不存在', icon: 2});

                        }else if(res.status==999005){
                            $.global_msg.init({gType: 'warning', msg: '所属卡类型下类型名称重复', icon: 2});

                        }

                    },
                    fail:function(){
                        $.global_msg.init({gType: 'warning', msg: '编辑失败', icon: 2});
                    }

                });
                $('.js_submit_edit_type').removeClass('clicking');


            },
            /*删除标签类型*/
            delType:function(){
                /*删除标签类型事件*/
                $('.js_label_type_wrap').on('click', '.js_del_type', function () {
                    var $wrap=$(this).parent('li');
                    $.global_msg.init({
                        gType: 'confirm', icon: 2, msg:'是否删除所选标签类型?', btns: true, close: true,
                        title: false, btn1: gCancelMsg, btn2: gConfirmMsg, noFn: function () {
                            var typeId=$wrap.attr('type-id');
                            if(typeof(typeId) != 'undefined'){
                                $.ajax({
                                    url: gUrl,
                                    type: 'post',
                                    data: {
                                        typeId:typeId , action: 'delType'
                                    },
                                    success:function(res){
                                        if(res.status==0){ //删除成功
                                            $wrap.remove();
                                            lastIndex=lastIndex >1 ? lastIndex-1 : 1;
                                            //删除成功后，如果剩余菜单超过5个，把隐藏的一个类型菜单 显示出来
                                            if(lastIndex>6){
                                                $(".js_label_type:eq(5)").show();

                                            }

                                            //删除成功后，如果剩余菜单正好5个，把右侧点击按钮设置不可点击 1到5显示全部
                                            if(lastIndex==6){
                                                $(".js_label_type:gt(0)").show();
                                                $('#js_right_btn').find('b').addClass('r_color');
                                                $('#js_left_btn').find('b').addClass('l_color');

                                            }


                                        }else if(res.status==360002){
                                            $.global_msg.init({gType: 'warning', icon: 2, msg: '标签类型不存在,已被删除，请刷新页面'});

                                        }else if(res.status==360003){
                                            $.global_msg.init({gType: 'warning', icon: 2, msg: '该标签类型包含标签，不能被删除'});
                                        }else{
                                            $.global_msg.init({gType: 'warning', icon: 2, msg: '删除失败'});
                                        }
                                    },
                                    fail:function(){
                                        $.global_msg.init({gType: 'warning', icon: 2, msg: '删除失败'});
                                    }

                                });
                            }

                        }});//确认删除

                });

            },
            /*编辑和添加标签*/
            addOrEditLabel: function (data) {
                if (data.tag.length > 32) {
                    $.global_msg.init({gType: 'warning', msg: gMaxLengthFailMsg, icon: 2});
                    $('#js_submit_label').removeClass('clicking');
                    return;
                }
                var that = this;
                var str = typeof (data.id) == 'undefined' ?  gAddStr :  gEditStr;
                $.ajax({
                    url: gUrl,
                    type: 'post',
                    data: data,
                    success: function (res) {
                        if (res.status == 0) {
                            $('.rank_label:visible,.js_no_data:visible').remove();
                            $('.js_label_list_wrap:visible').attr('load-p', 0);
                            that.scrollbarAjax();//成功后ajax重新加载
                            that.resetSelect();//重置按钮
                            that.resetBox();//重置弹框
                            if (str == '添加') { //如果是添加标签，重置‘所有'类型中的标签
                                that.resetWrap($('.js_label_list_wrap[type-id=all]'));

                            } else { //如果是编辑标签 在单个类型容器下编辑重置‘全部’类型容器
                                // 相反在‘全部’ 类型下编辑后重置 编辑的标签对应类型下的容器
                                if ($('.js_label_list_wrap:visible').attr('type-id') != 'all') {
                                    that.resetWrap($('.js_label_list_wrap[type-id=all]'));
                                } else {
                                    that.resetWrap($(".js_label_list_wrap[type-id=" + data.type + "]"));
                                }
                            }

                        } else if (res.status == '999005') {
                            $.global_msg.init({gType: 'warning', icon: 2, msg: gExistMsg});
                        } else {
                            $.global_msg.init({gType: 'warning', icon: 2, msg: str +gLabelStr+ gFailStr});
                        }

                    },
                    fail: function () {
                        $.global_msg.init({gType: 'warning', icon: 2, msg: str + gLabelStr+ gFailStr});

                    }
                });
                $('#js_submit_label').removeClass('clicking');
            },
            /*重置类型下对应的容器为未加载过的状态*/
            resetWrap: function ($wrap) {
                if (typeof ($wrap) == 'object') {
                    $wrap.find('.rank_label').remove();
                    $wrap.find('.js_no_data').remove();
                    $wrap.attr('load-p', 0);
                }
            }
        }
    });

})(jQuery);
