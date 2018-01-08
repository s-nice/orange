
;(function ($) {
    $.extend({
        popLabel: {
            init: function (type,cardTypeId,fn) { //初始化 type 为1 or 2 1 为弹窗
                this.type=type==2 ? 2 :1;
                this.cardTypeId=cardTypeId || 1;
                this.initLabelType();//初始化标签类型
                this.selectType();//类型选择事件
                var wrapObj= $('.js_label_list_wrap[type-id="all"]');
                if(this.type==1){
                    wrapObj.find('span').remove(); //还原属性
                    wrapObj.attr('load-p',0);
                    wrapObj.removeAttr('numfound');
                    this.selectedsArr=$('#js_wrap_main').parents('.addcard_box').attr('selecteds').split(",");//已选标签 标记勾选
                    this.maxNum=16;//一次最多加载多少个标签
                    this.maxHeight='210px';

                }


                this.scrollbarAjax(wrapObj,fn);//初始化‘全部’类型的标签
                if(type==2){
                    $('#js_card_type_container').mCustomScrollbar({ //卡类型滚动条
                        theme: "dark", //主题颜色
                        autoHideScrollbar: false, //是否自动隐藏滚动条
                        scrollInertia: 0,//滚动延迟
                        horizontalScroll: false,//水平滚动条

                    });
                    if(!cardTypeId){
                      $('.js_card_type_list li').eq(0).addClass('on'); //没传卡类型ID默认卡类型高亮

                    }
                    this.selectCardType();//选择卡类型列表
                }
            },
            type:1,//1 为弹框 2静态页面
            loop: 1,//循环标记
            maxNum : 24, //一次最多加载多少个标签
            maxHeight : '250px', //
            cardTypeId:1,
            selectedsArr:[],
            initLabelType: function () { //初始化标签类型
                var that = this;
                that.cardTypeId = arguments[0] ? arguments[0] : that.cardTypeId;//设置cardTypeId默认值为1
                if($('.js_label_type').length>1)$('.js_label_type:gt(0)').remove(); //清除上一个选择卡类型的标签类型
                $('.js_type_loading').remove();
                $('#js_left_btn').after("<li class='js_type_loading'>loading...</li>")
                $.ajax({
                    url: gGetLabelTypeUrl,
                    type: 'get',
                    data: {cardTypeId: that.cardTypeId},
                    success: function (res) {
                        if (res.status == 0) {
                            if(res.data.numfound!=0){
                                var list = res.data.list;
                                that._buildLabelTypes(list);

                            }else{
                                $('.js_type_loading').html('NO DATA')
                            }

                            that.loop = 1;
                        } else {
                            if (that.loop <= 3) { //失败后再请求3次
                                this.initLabelType();
                            } else {
                                $('#js_left_btn').after('获取标签类型失败');
                            }
                        }
                    },
                    fail: function () {
                        if (that.loop <= 3) { //失败后再请求3次
                            this.initLabelType();
                        } else {
                            $('#js_left_btn').after('获取标签类型失败');
                        }
                    }
                })

            },
            // 构建标签类型列表供点击
            _buildLabelTypes : function (labelTypesList) {
                var that=this;
                $('.js_type_loading').remove();
                var startIndex=1;
                var lastIndex=labelTypesList.length+1;
                this.typeMenu(startIndex,lastIndex);
                var $li='';
                for (var i = 0; i < labelTypesList.length; i++) {
                    if (i == 0) {
                        if(that.type==1){
                              $li="<li class='js_label_type' type-id=" + labelTypesList[i].id + " title="+ labelTypesList[i].name +">"
                                + labelTypesList[i].name + "</li>"
                        }else{
                              $li="<li class='js_label_type' type-id=" + labelTypesList[i].id + " title="+ labelTypesList[i].name +"><em>"
                                  + labelTypesList[i].name + "</em><i>&uarr;</i></li>"
                        }
                        $('#js_left_btn').after($li);

                    }
                    else if (i < 5) {
                        if(that.type==1){
                            $li="<li class='js_label_type' type-id=" + labelTypesList[i].id + ">"
                                + labelTypesList[i].name + "</li>"
                        }else{
                            $li="<li class='js_label_type' type-id=" + labelTypesList[i].id + "><em>"
                                + labelTypesList[i].name + "</em><i>&uarr;</i></li>"
                        }

                        $('.js_label_type:last').after($li);
                    }
                    else {
                        if(that.type==1){
                            $li="<li style='display:none' class='js_label_type' type-id=" + labelTypesList[i].id + ">"
                                + labelTypesList[i].name + "</li>"
                        }else{
                            $li="<li style='display:none' class='js_label_type' type-id=" + labelTypesList[i].id + "><em>"
                                + labelTypesList[i].name + "</em><i>&uarr;</i></li>"
                        }
                        $('.js_label_type:last').after($li);
                    }
                }
            },
            initScrollBar: function ($wrapObj) {
                var that = this;
                $wrapObj = typeof ($wrapObj) == 'object' ? $wrapObj : $('.js_label_list_wrap:visible');
                var numfound = parseInt($wrapObj.attr('numfound'));
             //   console.log(numfound);
                var type = $wrapObj.attr('type-id');
                if (numfound > that.maxNum ) {
                    $wrapObj.css('max-height', that.maxHeight);
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
                                    if ($('.js_loading:visible').length == 0 && numfound > that.maxNum * p) {
                                        $wrapObj.find('.mCSB_container:visible').append("<span class='js_loading'>loading....</span>");
                                        that.scrollbarAjax();
                                    }
                                }
                            }
                        });
                    }
                }
            },
            selectType: function () {
                /*点击类型选项事件*/
                var that = this;
                var obj= '.js_label_type';
                if(that.type==2) obj='.js_label_type:first,em';
                $('.js_label_type_wrap').on('click',obj, function () {
                    var $menuObj= typeof ($(this).attr('type-id'))!='undefined' ? $(this) :$(this).parent('.js_label_type');
                    if (!$menuObj.hasClass('allbg') && !$menuObj.hasClass('on')) { //样式
                        var typeId = $menuObj.attr('type-id');//类型id
                        var $wrapObj = $(".js_label_list_wrap[type-id=" + typeId + "]");//对应类型的容器对象
                        if(that.type==1){
                            $('.js_label_type').removeClass('allbg');
                            $menuObj.addClass('allbg');
                        }else{
                            $('.js_label_type').removeClass('on');
                            $menuObj.addClass('on');
                        }
                        //that.resetSelect();//重置勾选
                        $('.js_label_list_wrap').hide();//隐藏其它类型容器
                        if ($wrapObj.length == 0) { //根据对应容器是否存在判断是否加载过
                            var appendData='';
                            if(that.type==1){
                                appendData="<div class='card_item clear js_label_list_wrap' type-id='" + typeId + "' load-p='" + 0 + "' >" +
                                    "<h3 class='js_loading'>loading....</h3>" +
                                    "</div>"

                            }else{
                                appendData="<div class='move_label important_info clear js_label_list_wrap' type-id='" + typeId + "' load-p='" + 0 + "' >" +
                                    "<h3 class='js_loading'>loading....</h3>" +
                                    "</div>"
                            }

                            $('#js_wrap_main').append( //未加载过添加对应容器
                                appendData
                            );
                            that.scrollbarAjax();//加载数据
                        } else { //已加载 显示容器
                            if(that.type==1){ //判断勾选
                                $wrapObj.find('input').each(function(){
                                    if(that.selectedsArr.indexOf($(this).val())!=-1){
                                        $(this).prop('checked',true);
                                        //console.log($(this).val(),$(this).attr('checked'));
                                    }
                                })
                            }
                            $wrapObj.show();
                        }
                    }
                });
            },
            /*ajax滚动加载和初始化数据*/
            scrollbarAjax: function ($wrapObj,fn) {
                var that = this;
                $wrapObj = typeof ($wrapObj) == 'object' ? $wrapObj : $('.js_label_list_wrap:visible');
                var p = parseInt($wrapObj.attr('load-p'));
                var type = $wrapObj.attr('type-id');
                type = type == 'all' ? '' : type;
                $.ajax({
                    url: gGetLabelUrl,
                    type: 'get',
                    data: {p: p + 1, type: type, rows:that.maxNum ,cardTypeId:that.cardTypeId},
                    success: function (res) {
                        if (res.status != 0) {
                            if(that.loop<=3){
                                that.scrollbarAjax($wrapObj);//最多请求3次
                            }else{
                                $wrapObj.append('加载标签失败');
                            }
                        } else {
                            $wrapObj.attr('load-p', p + 1);
                            $('.js_loading:visible').remove();
                            if (res.data.numfound != 0) {
                                var list = res.data.list;
                                var data = '';
                                for (var i = 0; i < list.length; i++) {
                                    if(that.type==1){ //窗口形式
                                       // console.log(selectedsArr.indexOf(list[i].id ));
                                        if(that.selectedsArr.indexOf(list[i].id )==-1){ //未选择
                                            data += "<span title='" + list[i].tag + "' data-name='" + list[i].tag + "' >" +
                                                "<label ><input type='checkbox' value='" + list[i].id + "'></label><em>"+ list[i].tag +"</em></span>";
                                        }else{//已选
                                            data += "<span title='" + list[i].tag + "' data-name='" + list[i].tag + "' >" +
                                                "<label ><input type='checkbox' checked='checked' value='" + list[i].id + "'></label><em>"+ list[i].tag +"</em></span>";
                                        }
                                    }else{//页面形式
                                        data += "<span class='js_one_label' title='" + list[i].tag + "' data-name='" + list[i].tag + "'  data-id='" + list[i].id +  "' type-id='" + list[i].typeid+ "'><em>" +
                                            list[i].tag+
                                        "</em><b>↑</b></span>";
                                    }
                                }

                                if ($wrapObj.find('.mCSB_container').length > 0) {
                                    $wrapObj.find('.mCSB_container').append(data);
                                } else { //首次加载
                                    $wrapObj.append(data);
                                    $wrapObj.attr('numfound', res.data.numfound);
                                    that.initScrollBar($wrapObj);//初始化新容器滚动条
                                }
                            } else {
                                $wrapObj.append("<b class='js_no_label_data'>NO DATA</b>");
                            }
                            that.loop=1;
                        }
                        if(fn)fn();
                        if(that.type==2)$('.js_nav_bg').hide();
                    },
                    fail: function () {
                        if(that.loop<=3){
                            that.scrollbarAjax($wrapObj);//最多请求3次
                        }else{
                            $wrapObj.append('加载标签失败');
                        }
                        if(that.type==2)$('.js_nav_bg').hide();
                        if(that.type==1 && fn) fn();
                    }
                });
            },
            /*选择卡类型列表*/
            selectCardType:function(){
                var that=this;
                $('.js_cardtype_mark li').on('click',function(){
                    var cardTypeId=$(this).attr('val');
                    if(that.cardTypeId!=cardTypeId){
                        $('.js_nav_bg').show();//遮罩层
                        $('.js_cardtype_mark li').removeClass('on');
                        $(this).addClass('on');
                        that.cardTypeId=cardTypeId;
                        that.initLabelType();//重置标签类型
                        var wrapObj= $('.js_label_list_wrap[type-id="all"]'); //重置全部容器
                        $('.js_label_list_wrap').hide();
                        $('.js_label_type').first().addClass('on');
                        wrapObj.find('.js_one_label,.js_no_label_data').remove();
                        wrapObj.attr('load-p',0);
                        wrapObj.removeAttr('numfound');
                        wrapObj.show();
                        that.scrollbarAjax(wrapObj);//初始化‘全部’类型的标签

                    }
                })
            },
            /*类型菜单左右显示隐藏*/
            typeMenu: function (startIndex,lastIndex) {
                var that =this;
                $('#js_left_btn').find('b').attr('class','left_l l_color');
                if (lastIndex <= 6) {
                    $('#js_right_btn').find('b').attr('class','right_l r_color'); //初始化右侧箭头 少于5个标签样式不可点击
                }else{
                    $('#js_right_btn').find('b').attr('class','right_l');
                }

                $('#js_right_btn').off('click').on('click', function () {
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
                $('#js_left_btn').off('click').on('click', function () {
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

            }
        }
    })
})(jQuery);
