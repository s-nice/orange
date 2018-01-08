;(function ($) {
    $.extend({
        OraStatMembershipCard: {
            init: function () { //初始化
                $('.js_search_form').append('<input name="type" class="js_card_type_input js_temp_input" type="hidden" value="' + gType + '" />');
                $('.js_search_form').append('<input name="action" class="js_action_input" type="hidden" value="' + gAction + '" />');


                if (gAction == 'useNum' || gAction == 'avgUseNum') {
                    $('.js_search_form').append('<input name="timeType" class="js_time_type_input js_temp_input" type="hidden" value="' + gTimeType + '" />');

                }
                if (gAction == 'avgUserNum') {
                    $('.js_search_form').append('<input name="cardStatus" class="js_card_status_input js_temp_input" type="hidden" value="' + gCardStatus + '" />');
                }

                $('.table_scrolls').mCustomScrollbar({ //初始化表格滚动条
                    theme: "dark", //主题颜色
                    autoHideScrollbar: false, //是否自动隐藏滚动条
                    scrollInertia: 0,//滚动延迟
                    horizontalScroll: false//水平滚动条
                });
                this.event();//事件

            },
            event: function () {//页面事件
                var that= this;
                //选择下拉菜单
                $('.js_select_menu input,.js_select_menu i').on('click', function () {
                    $(this).siblings('ul').toggle();

                });
                $('.js_download button').on('click',function(){ //下载表格
                    $('.js_download ').submit();
                });
                //下拉菜单点击外部关闭
                $(document).on('click', function (e) {
                    var clickObj = $(e.target).parents('.js_select_menu');
                    if (!clickObj.length) {
                        $('.js_select_menu').find('ul').hide();
                    } else {
                        $('.js_select_menu').not(clickObj).find('ul').hide();

                    }
                });
                //选择下拉菜单 选择统计项目
                $('.js_select_action li').on('click', function () {
                    if ($(this).html() != $('.js_select_action input').val()) {
                        var oldAciton=   $('.js_action_input').val();
                        switch ($(this).index()) {
                            case 1:
                                if(oldAciton!='avgUseNum'){
                                    that.reSetTimeVal();
                                }
                                $('.js_action_input').val('useNum');//使用用户数
                                break;
                            case 2:
                                if(oldAciton!=''){
                                    that.reSetTimeVal();
                                }
                                $('.js_action_input').val('avgUserNum');//人均会员数
                                break;
                            case 3:
                                if(oldAciton!='useNum'){
                                    that.reSetTimeVal();
                                }
                                $('.js_action_input').val('avgUseNum');//人均使用次数
                                break;
                            default:
                                if(oldAciton!='avgUserNum'){
                                    that.reSetTimeVal();
                                }
                                $('.js_action_input').val(''); //拥有用户数
                                break;
                        }
                        $('.js_select_action input').val($(this).html());
                        $('.js_search_form').submit();

                    } else {
                        $(this).closest('ul').hide();
                    }


                });

                //下拉菜单选择查询分类
                $('.js_select_type li').on('click', function () {
                    $('.js_select_type input').val($(this).html());
                    $('.js_card_type_input').val($(this).attr('val'));
                    $('.js_downloadStat_input').val('');//重置导出input
                    $('.js_search_form').submit();
                });

                //下拉菜单选择卡状态类型
                $('.js_select_card_status li').on('click', function () {
                    $('.js_select_card_status input').val($(this).html());
                    $('.js_card_status_input').val($(this).attr('val'));
                    $('.js_downloadStat_input').val('');//重置导出input
                    $('.js_search_form').submit();
                });

                //统计时间类型选择
                $('.js_stat_date_type a').on('click', function () {
                    if (!$(this).hasClass('on')) {
                        $('.js_stat_date_type a').removeClass('on');
                        $(this).addClass('on');
                        $('.js_time_type_input').val($(this).attr('val'));
                        $('#js_begintime').val('');
                        $('#js_endtime').val('');

                    }
                    $('.js_search_form').submit();

                });

                $('.js_search_form').on('submit',function(){
                    if($('#js_begintime').val()=='' ^ $('#js_endtime').val()==''){
                      that.reSetTimeVal()
                    }

                })

            },
            /*取整最大值*/
            getMaxVal: function (num) {
                var val = 10;
                if (num > 10) {
                    val = Math.ceil(num / 10) * 10+10

                }
                return val

            },

            /*清空时间表单（同一模块下，不同时间表单时重置）*/

            reSetTimeVal:function(){
                $('.js_temp_input').val('');
                $('#js_begintime').val('');
                $('#js_endtime').val('');

            }
        }
    })
})(jQuery);
