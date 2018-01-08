/**
 * orange 单位详情管理 js
 *
 * */
;(function ($) {
    $.extend({
        orderbiz: {
            init: function () {
                var that = this;

                /*初始化滚动条*/
                /*        $('.js_list_select ul,.js_selected_model,.js_phone_address_wrap').mCustomScrollbar({ //初始化滚动条
                 theme: "dark", //主题颜色
                 autoHideScrollbar: false, //是否自动隐藏滚动条
                 scrollInertia: 0,//滚动延迟
                 horizontalScroll: false//水平滚动条
                 });*/

                this.event();
            },
            event: function () {
                var that = this;
                //下拉菜单跳转
                $('.js_input_select').on('change',function(){
                    var url= gUrl;
                    $('.js_input_select').each(function(){
                        var val= $.trim($(this).attr('val'));
                        if(typeof (val) !='undefined' && val!=''){
                            var name =$(this).attr('data-name');
                            url+='/'+name+'/'+val
                        }

                    });
                    window.location.href =url;
                });

            },
            /**
             * 获取批量选择的id
             *
             * */
            getIds:function(){
                if($('.js_select.active').length <=0){
                    return false
                }else{
                    var ids=[];
                    $('.js_select.active').each(function(){
                        ids.push( $(this).attr('data-id'))
                    });
                    return ids ;
                }
            },
            /**
             * ajax 操作数据
             * setObj 参数设置对象
             * */
            ajaxFn:function(setObj){
                $.ajax({
                    url:setObj.url,
                    type:'post',
                    data:setObj.data,
                    success:function(res){
                        if(res.status=='0'){
                            $.global_msg.init({
                                gType: 'warning', msg: setObj.sMsg, time: 2, icon: 1, endFn: function () {
                                    location.reload();
                                }
                            });
                        }else{
                            $.global_msg.init({
                                gType: 'warning', msg: setObj.eMsg, time: 2, icon: 0, endFn: function () {
                                    location.reload();
                                }
                            });
                        }
                    },
                    fail:function(err){
                        $.global_msg.init({
                            gType: 'warning', msg:setObj.eMsg, time: 2, icon: 0

                        });
                    }
                });
            }

        }

    })
})(jQuery);