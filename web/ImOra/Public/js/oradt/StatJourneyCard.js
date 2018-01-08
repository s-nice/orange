;(function ($) {
    $.extend({
        OraStatJourneyCard: {
            init: function () { //初始化
                $('.js_search_form').append('<input name="action" class="js_action_input " type="hidden" value="' + gAction + '" />');

                if (gAction != 'airLineUser' && gAction != 'onLineTimeUser') {
                    $('.js_search_form').append('<input name="timeType" class="js_time_type_input js_temp_input" type="hidden" value="' + gTimeType + '" />');

                } else {
                    $('.js_search_form').append('<input name="min" class="js_sub_min_input js_temp_input" type="hidden" value="' + gMin + '" />');
                    $('.js_search_form').append('<input name="max" class="js_sub_max_input js_temp_input" type="hidden" value="' + gMax + '" />');
                    $('.js_search_form').append('<input name="between" class="js_sub_between_input js_temp_input" type="hidden" value="' + gBetween + '" />')
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
                var that=this;
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
                        switch ($(this).index()) {
                            case 1:
                                $('.js_action_input').val('avgAirLine');//人均航段数
                                break;
                            case 2:
                                $('.js_action_input').val('airLineUser');//航段数人数分布
                                break;
                            case 3:
                                $('.js_action_input').val('onLineTime');//人均在途时间
                                break;
                            case 4:
                                $('.js_action_input').val('onLineTimeUser');//在途时间人数分布
                                break;
                            case 5:
                                $('.js_action_input').val('avgUseNum');//人均使用次数
                                break;
                            default:
                                $('.js_action_input').val(''); //查看用户数
                                break;
                        }
                        $('.js_select_action input').val($(this).html());
                        if (gAction == 'airLineUser' || gAction == 'onLineTimeUser'){
                          that.reSetTimeVal();
                        }

                            $('.js_search_form').submit();

                    } else {
                        $(this).closest('ul').hide();
                    }


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
                    $('.js_downloadStat_input').val('');//重置导出input
                    $('.js_search_form').submit();

                });

                /*最大最小值区间段提交*/

                $('.js_condition_sub').on('click', function () {
                    var min =$('.js_min_input').val();
                    var max =$('.js_max_input').val();
                    var between =$('.js_between_input').val();
                    /*判断为正整数*/
                    if((min!='' && isNaN(min) ) || (min!='' && isNaN(max)) || (min!='' && isNaN(between))|| min<0 || min<0 || between <0){
                        $.global_msg.init({gType:'warning',msg:'请填写正确的数值',icon:0});
                        return;
                    }

                    if(min!='' &&  max!='' &&parseInt(min)>parseInt(max)){
                        $.global_msg.init({gType:'warning',msg:'请正确填写最大最小值',icon:0});
                        return;

                    }


                    $('.js_sub_min_input').val(min);
                    $('.js_sub_max_input').val(max);
                    $('.js_sub_between_input').val(between);
                    $('.js_downloadStat_input').val('');//重置导出input
                    $('.js_search_form').submit();

                });
                //导出

                $('.js_downloadStat_button').on('click', function () {
                    $('.js_search_form').append('<input name="downloadStat" class="js_temp_input js_downloadStat_input" type="hidden" value="1" />');
                    $('.js_search_form').submit();
                });

                $('.js_search_form').on('submit',function(){
                    if (gAction != 'airLineUser' && gAction != 'onLineTimeUser') {
                        if($('#js_begintime').val()=='' ^($('#js_endtime').val()=='' || typeof ($('#js_endtime').val())=='undefined')){
                           that.reSetTimeVal();
                        }
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
            checkNum:function(num){
                if (isNaN(parseFloat(num)) || parseFloat($(this).val()) <= 0) $(this).val(1);

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
