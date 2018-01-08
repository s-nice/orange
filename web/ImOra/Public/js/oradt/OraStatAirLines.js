/**
 * Created by zhaoge on 2017/3/20.
 * orange 飞常准 js
 */
;(function(){
    $.extend({
        OraStatAirLine:({
            init:function(){ //初始化
                $('.js_search_form').append('<input name="type" class="js_action_input " type="hidden" value="' + gType + '" />');
                //日期插件初始化
                $.dataTimeLoad.init({statistic:gStatisticDateType,idArr: [{start:'js_begintime',end:'js_endtime'}]});
                $('.table_scrolls').mCustomScrollbar({ //初始化表格滚动条
                    theme: "dark", //主题颜色
                    autoHideScrollbar: false, //是否自动隐藏滚动条
                    scrollInertia: 0,//滚动延迟
                    horizontalScroll: false,//水平滚动条
                });
                this.event();


            },
            event:function(){ //事件
                this.select();
                $('.js_download button').on('click',function(){ //下载表格
                    $('.js_download ').submit();
                });
                //切换查询类型跳转
                $('.js_select_type li').on('click',function(){
                    if( $('.js_select_type>input').val()!=$(this).html()){
                        if($(this).index()==0){
                            $('.js_action_input').val('pull');
                        }else{
                            $('.js_action_input').val('push');
                        }
                        $('.js_search_form').submit();

                    }
                });


                //切换时间区间
                $('.js_select_time').on('click',function(){
                    if(!$(this).hasClass('on')){
                        $('.js_select_time').removeClass('on');
                        $(this).addClass('on');
                        $('#js_begintime').val('');
                        $('#js_endtime').val('');
                    }
                    var timeType='';
                    var $inputObj=$('.js_time_type_input');//隐藏input d对象
                    switch ($(this).index()){
                        case 1 :
                            timeType='threeDay';
                            break;
                        case 2:
                            timeType='week';
                            break;
                        case 3:
                            timeType='month';
                            break;
                        default:
                            timeType='day';
                            break;
                    }
                    $inputObj.val(timeType);
                    $('.js_search_form').submit();

                });
                $('.js_search_form').on('submit',function(){
                    if($('#js_begintime').val()=='' ^ $('#js_endtime').val()==''){
                        $('.js_temp_input').val('');
                        $('#js_begintime').val('');
                        $('#js_endtime').val('');
                    }

                })


            },
            //下拉框
            select:function(){

                //下拉框
                $('.js_select_type').on('click',function(){
                    $(this).find('ul').toggle();

                });

                //切换查询点击外部,关闭此下拉框
                $(document).on('click',function(e){
                    if(!$(e.target).parents('.js_select_type').length){

                        $('.js_select_type').find('ul').hide();

                    }

                });

            },

            detailInit:function(){
                $.dataTimeLoad.init({idArr: [{start:'js_begintime',end:'js_endtime'},{end:'js_goff_date'}]});
                $('.table_scrolls').mCustomScrollbar({ //初始化表格滚动条
                    theme: "dark", //主题颜色
                    autoHideScrollbar: false, //是否自动隐藏滚动条
                    scrollInertia: 0,//滚动延迟
                    horizontalScroll: false,//水平滚动条
                });
                this.select();
                this.detailEvent();



            },
            //详情页选择下拉菜单
            detailEvent:function(){
                $('.js_download button').on('click',function(){ //下载表格
                    $('.js_download ').submit();
                });
                $('.js_select_type li').on('click',function(){
                    if(!$(this).hasClass('on')){
                        $(this).parent().children().removeClass('on');
                        $(this).addClass('on');

                    }
                    var val=$(this).attr('val');
                    var text=$(this).html();
                    $(this).parent().prevAll('input').val(text);
                    $(this).parent().next().val(val);

                });


            }
        })

    })
})(jQuery);
