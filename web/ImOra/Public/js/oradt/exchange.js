/**
 * 注册用户管理
 */

(function($) {
    $.extend({
        exchange: {
            init: function() {
                /*绑定事件*/

                /*滚动条*/
                $.exchange.scroll_list();

                //下拉框
                $('.content_c').on('click','.toggledom input[marks=mark]',function(){

                    $(this).parent().find('ul').toggle();

                });
                $('.content_c').on('click','.toggledom ul li',function(){

                    //版本，多选
                    if( $(this).hasClass('js_version') ){
                        //选中\取消
                        $(this).toggleClass('on');

                        //是否取消全部
                        if (! $(this).hasClass('js_all_in_one')) {
                            $(this).siblings('.js_all_in_one').removeClass('on');
                        }
                        //全部取消
                        if ($(this).hasClass('js_all_in_one') ) {
                            $(this).siblings().removeClass('on');
                        }

                        var arr=[];
                        var arrtitle=[];
                        var items='';
                        var title='';
                        $('#js_version_li li[class="js_version on"]').each(function(){
                            arr.push($(this).attr('data-val'));
                            arrtitle.push($(this).html());
                        })
                        items = arr.join(',');
                        title = arrtitle.join(',');
                        if(title==''){
                            title = $('.js_all_in_one').html();
                        }

                        $(this).parents('ul').parent().find('input[marks=mark]').val(title);
                        $(this).parents('ul').parent().find('input:hidden').val(items);

                    }else{
                        var vals = $(this).attr('data-val');
                        var htmlvals = $(this).html();
                        $(this).parent().parent().find('input[marks=mark]').val(htmlvals);
                        $(this).parent().parent().find('input:hidden').val(vals);

                        //菜单联动
                        if( $(this).hasClass('js_platform') ){
                            //产品版本联动
                            if(!vals){
                                $('#js_version_li .mCSB_container').html( $('.js_select_container .js_version_li_container_all').html() );
                            }else{
                                $('#js_version_li .mCSB_container ').html( $('.js_select_container .js_version_li_container_'+vals).html() );
                            }

                            $('.select_sketch').find('input[marks=mark]').val(js_str_exchange_version);
                            $('.select_sketch').find('input:hidden').val('');

                            $(this).parent().hide();

                            //滚动条
                            $.exchange.scroll_list();

                        }
                        if( $(this).hasClass('js_drawtype') ){
                            $('.submit_button').click();
                        }
                    }

                });
                //给列表添加滚动条
                var scrollObj = $('#js_scroll_id');
                if(!scrollObj.hasClass('mCustomScrollbar')){
                    scrollObj.mCustomScrollbar({
                        theme:"dark", //主题颜色
                        autoHideScrollbar: false, //是否自动隐藏滚动条
                        scrollInertia :0,//滚动延迟
                        horizontalScroll : false//水平滚动条
                    });
                }

                //点击区域外关闭此下拉框
                $(document).on('click',function(e){

                    if($(e.target).parents('.js_select_ul_list').length>0){
                        var currUl = $(e.target).parents('.js_select_ul_list').find('ul');
                        $('.js_select_ul_list>ul').not(currUl).hide()
                    }else{
                        $('.js_select_ul_list>ul').hide();
                    }


                });

            },
            scroll_list:function(){
                var scrollObjs = $('#js_version_li');

                scrollObjs.mCustomScrollbar({
                    theme:"dark", //主题颜色
                    autoHideScrollbar: false, //是否自动隐藏滚动条
                    scrollInertia :0,//滚动延迟
                    horizontalScroll : false//水平滚动条
                });

            }


        }
    });
})(jQuery);