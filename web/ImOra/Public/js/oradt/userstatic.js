(function($) {
    $.extend({
        users: {
            init: function() {
                /*绑定事件*/

                //点击区域外关闭此下拉框
                $(document).on('click',function(e){

                    if($(e.target).parents('.js_select_ul_list').length>0){
                        var currUl = $(e.target).parents('.js_select_ul_list').find('ul');
                        $('.js_select_ul_list>ul').not(currUl).hide()
                    }else{
                        $('.js_select_ul_list>ul').hide();
                    }


                });
                //时间选择
                //日历插件
                $.dataTimeLoad.init({idArr: [ {start:'js_begintime',end:'js_endtime'} ]});
                //勾选按钮
                this.selectOperate();

                //搜索-模块选择
                $('#js_mod_select,#js_seltitle').on('click',function(){
                    $('#js_selcontent').toggle();
                });
                //模块选中
                $('#js_selcontent li').on('click',function(){
                    var typeval = $(this).html();
                    var typekey = $(this).attr('val');
                    $('#js_mod_select input').val(typeval);
                    $('#js_searchtypevalue').val(typekey);
                    $(this).parent().hide();
                });

            },

            /* 勾选按钮*/
            selectOperate:function(){
                $('.js_select').click(function(){
                        if ( $(this).hasClass('active') ){
                            $(this).removeClass('active');
                        }else{
                            $(this).addClass('active');
                        }
                });
                $('.appadmin_pagingcolumn .span_span11').click(function(){
                    if ( $(this).find('i').hasClass('active') ){
                        $(this).find('i').removeClass('active');
                        $('.js_select').removeClass('active');
                    }else{
                        $(this).find('i').addClass('active');
                        $('.js_select').addClass('active');
                    }
                });
            },
            /*刷新页面*/
            refreshPage:function(){
                window.location.reload();
            }


        }
    });
})(jQuery);