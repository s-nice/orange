/**
 * Created by zhaoge on 2017/3/20.
 * orange 统计 日程卡 js
 */
;(function($){
    $.extend({
        OraStatScheduleCard:({
            init:function(){ //初始化
                $('.js_search_form').append('<input name="type" class="js_action_input " type="hidden" value="' + gAction + '" />');
                $('.js_search_form').append('<input name="timeType" class="js_time_type_input" type="hidden" value="'+gTimeType +'" />');
                this.event();
                //日期插件初始化
                $.dataTimeLoad.init({statistic:gStatisticDateType,idArr: [{start:'js_begintime',end:'js_endtime'}]});
                $('.table_scrolls').mCustomScrollbar({ //初始化表格滚动条
                    theme: "dark", //主题颜色
                    autoHideScrollbar: false, //是否自动隐藏滚动条
                    scrollInertia: 0,//滚动延迟
                    horizontalScroll: false,//水平滚动条
                });
            },
            event:function(){//事件
                //显示隐藏统计类型（总数和平均下拉框）
                $('.js_select_type').on('click',function(){
                    $(this).find('ul').toggle();

                });

                //切换查询类型跳转
                $('.js_select_type li').on('click',function(){
                    if( $('.js_select_type>input').val()!=$(this).html()){
                       if($(this).index()==0){
                           $('.js_action_input').val(1);////使用数
                       }else{
                           $('.js_action_input').val(2);//人均数
                       }
                        $('.js_search_form').submit();
                    }else {
                        $(this).closest('ul').hide();
                    }

                });

                //切换查询点击外部,关闭此下拉框
                $(document).on('click',function(e){
                    if(!$(e.target).parents('.js_select_type').length){

                        $('.js_select_type').find('ul').hide();

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
                    if($inputObj.length){ //隐藏input 赋值
                        $inputObj.val(timeType);
                    }else{
                        $('.js_search_form').append('<input name="timeType" class="js_time_type_input" type="hidden" value="'+timeType +'" />')
                    }

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
            /*取整最大值*/
            getMaxVal:function(num){
                var val=10;
                if(num>10){
                    val=Math.ceil(num/10)*10+10

                }
                return val
            }
        })

    });

})(jQuery);

