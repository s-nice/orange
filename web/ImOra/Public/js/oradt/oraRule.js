/**
 * Created by zhaoge on 2017/6/23.
 */
// ORANGE 提取规则(预警信息规则) js
var checkObj;//全选对象
;(function ($){
    $.extend({
        rule:{
            init:function(){
                //时间选择
                $.dataTimeLoad.init();
                $('.js_select_type').selectPlug({getValId: 'type', defaultVal: ''}); //卡类型
                checkObj = $('.content_hieght').checkDialog({
                    checkAllSelector: '#js_allselect', checkChildSelector: '.js_select',
                    valAttr: 'val', selectedClass: 'active'
                });
                this.event();

            },
            event:function(){

                /*导出*/
                $('#js_export').on('click',function(e){
                    e.preventDefault();
                    var ids = (checkObj.getCheck()).toString();
                    if (ids == '') {
                        $.global_msg.init({gType: 'warning', msg: '请选择至少一项导出', icon: 0});
                    } else {
                        var url =$(this).attr('href')+'/ids/'+ids ;
                        location.href=url;
                    }

                });


            }

        }
    })
})(jQuery);