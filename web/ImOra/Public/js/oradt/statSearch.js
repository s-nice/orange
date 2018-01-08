(function ($) { //橙子统计 人均搜索次数 用
    $.extend({
        business: {
            //初始化
            init: function () {
                $('.js_search_form').append('<input name="type" class="js_type_input " type="hidden" value="' + gType + '" />');
                $('.js_search_form').append('<input name="period" class="js_time_type_input" type="hidden" value="' + gStatisticDateType + '" />')

                //日期插件初始化
                $.dataTimeLoad.init({
                    statistic: gStatisticDateType,
                    idArr: [{start: 'js_begintime', end: 'js_endtime'}]
                });


                //数据列表滚动条
                $(".table_scrolls").mCustomScrollbar({
                    theme: "dark",
                    autoHideScrollbar: false,
                    scrollInertia: 0,
                    horizontalScroll: false
                });

                //下拉select对应input初始化
                $('.menu_list .on').each(function () {
                    var v = $(this).html();
                    $(this).parent().siblings('input').val(v);
                });

                //跳转页面select下拉和隐藏
                $('.select_xinzeng input').on('click', function () {
                    $(this).siblings('ul').toggle();
                }).on('blur', function () {
                    var $ul = $(this).siblings('ul');
                    if ($ul.is(':visible')) {
                        setTimeout(function () {
                            $ul.hide();
                        }, 100);
                    }
                });

                //select跳转页面
                $('.select_xinzeng li').on('click', function () {
                    //var params={};
                    var type = $(this).attr('type');
                    $('.js_type_input').val(type);
                    $('.js_search_form').submit();

                });

                //日周月跳转页面
                $('.js_stat_date_type a').on('click', function () {
                    $(this).addClass('on').siblings().removeClass('on');
                    $('.js_time_type_input').val($(this).attr('val'));
                    $('.js_search_form').submit();
                });

                $('.js_download button').on('click', function () { //下载表格
                    $('.js_download ').submit();
                });


            }
        }
    });
})(jQuery);