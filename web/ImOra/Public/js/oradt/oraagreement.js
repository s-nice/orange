;
var maxDate= new Date().format(); //时间插件时间限制
var maxTime= new Date().format('H:i');
(function ($) {
$.extend({
    //橙子协议管理
	agreementManage: {
        init: function () {
            //初始化列表的复选框插件
            window.gLabelCheckObj = $('.content_hieght').checkDialog({
                checkAllSelector: '#js_allselect',
                checkChildSelector: '.js_select', valAttr: 'val', selectedClass: 'active'
            });
            this.initBindEvt();//初始化绑定事件
        },
        initBindEvt: function () {
            //点击添加按钮，显示添加频道模板
            $('#js_add_channel').click(function () {
                $('.js_channel_pop,.js_masklayer').show();
                $('#js_channel_pop_type').val('add');
                $('#js_chanel_name').val('');
                $('.js_channel_title').html(gStrAddLabelTitle);
            });
            //弹出层确定按钮
            $('.js_btn_channel_ok').click(function () {
                $.labelManage.modifyLabel();
            });
            //弹出层取消按钮
            $('.js_btn_channel_cancel').click(function () {
                $('.js_channel_pop,.js_masklayer').hide();
            });
            //删除频道
            $('#js_del_channel').click(function () {
                $.labelManage.delLabel();
            });
            //单项删除采集内容
            $('.js_single_del').click(function () {
                var id = $(this).parent().attr('data-id');
                $.labelManage.delLabel(id);
            });
        },
        /**
         * 添加/修改频道
         */
        modifyLabel: function () {
            var name = $.trim($('#js_chanel_name').val());
            var len = $.getStrLen(name);
            if (len == 0) {
                $.global_msg.init({gType: 'warning', icon: 2, msg: gLabelNameEmptyMsg});
                return;
            }
            /*else if(len > gChannelNameLen*2){
             $.global_msg.init({gType:'warning',icon:2,msg:channel_name_limit.replace('%d',gChannelNameLen)});
             return;
             }*/
            $.ajax({
                data: {name: name},
                url: labelAddUrl,
                type: 'POST',
                dataType: 'json',
                success: function (rst) {
                    if (rst.status == 0) {
                        $('.js_channel_pop,.js_masklayer').hide();
                        $('#js_chanel_name').val('');
                    }
                    var icon = rst.status == 0 ? 1 : 2;
                    $.global_msg.init({
                        gType: 'warning', icon: icon, msg: rst.msg,
                        endFn: function () {
                            if (rst.status == 0) {
                                window.location.reload();
                            }
                        }
                    });
                },
                error: function () {
                }
            });
        },
        /**
         * 删除频道
         */
        delLabel: function (ids) {
            var that = this;
            if (typeof(ids) == 'undefined') {
                if (window.gLabelCheckObj.getCheck().length == 0) {
                    $.global_msg.init({gType: 'warning', icon: 2, msg: gStrPleaseSelectData});
                    return;
                } else {
                    $.global_msg.init({
                        gType: 'confirm', icon: 2, msg: gStrConfirmDelSelectData, btns: true, close: true,
                        title: false, btn1: gStrBtnCancel, btn2: gStrBtnOk, noFn: function () {
                            var checkIdArr = window.gLabelCheckObj.getCheck();
                            ids = checkIdArr.join(',');
                            that.delLabelOpera(ids);
                        }
                    });
                }
            } else {
                $.global_msg.init({
                    gType: 'confirm', icon: 2, msg: gStrConfirmDelSelectData, btns: true, close: true,
                    title: false, btn1: gStrBtnCancel, btn2: gStrBtnOk, noFn: function () {
                        that.delLabelOpera(ids);
                    }
                });
            }
        },
        delLabelOpera: function (ids) {
            var data = {id: ids};
            $.ajax({
                data: data,
                url: labelDelUrl,
                type: 'POST',
                dataType: 'json',
                success: function (rst) {
                    $.global_msg.init({
                        gType: 'warning', icon: 1, msg: rst.msg, endFn: function () {
                            if (rst.status == 0) {
                                window.location.href = window.location.href;
                            }
                        }
                    });
                },
                error: function () {
                }
            });
        }
    }
});

})(jQuery);	;
