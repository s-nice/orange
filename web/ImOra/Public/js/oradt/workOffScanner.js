;(function($){
    $.extend({
        workOffScanner:{
                listInit:function(){//页面初始化
                    $.dataTimeLoad.init();//日期插件
                    this.event();
                },
                event:function(){
                    $('.js_submit').on('click',function(){ //提交搜索
                        $('#js_form').submit();
                    });

                    $('.js_del').on('click',function(){
                        var scannerid =$(this).attr('scannerid');
                        $.global_msg.init({
                            gType: 'confirm', icon: 2, msg: '确认是否删除?', btns: true, close: true,
                            title: false, btn1: '取消', btn2: '确认', noFn: function () {

                                $.ajax({
                                    url:gDelUrl,
                                    type:'post',
                                    data:{
                                        'scannerid':scannerid
                                    },
                                    success:function(res){
                                        if (res['status'] == 0) {
                                            $.global_msg.init({
                                                gType: 'warning', msg: '删除成功', time: 2, icon: 1, endFn: function () {
                                                    location.reload();
                                                }
                                            });
                                        } else {
                                            $.global_msg.init({
                                                gType: 'warning', msg: '删除失败', time: 2, icon: 0, endFn: function () {
                                                    location.reload();
                                                }
                                            });
                                        }
                                    },
                                    fail: function (err) {
                                        $.global_msg.init({
                                            gType: 'warning', msg: '删除失败', time: 2, icon: 0

                                        });
                                    }

                                })
                            }
                        });
                    })
                },
                addInit:function(){ //添加页面初始化
                   this.addEvent();
                } ,
                addEvent:function(){//添加页面事件
                    var that= this;
                    $('.js_main input').on('change',function(){
                        var ifEmpty=false;
                        $('.js_main input').each(function(){
                            if($.trim($(this).val())==''){
                                ifEmpty = true;
                                return false;
                            }
                        });
                        if(!ifEmpty){//都不为空
                            $('#js_save').attr('disabled',false);
                            $('#js_save').removeClass('button_disabel')
                        }else{
                            $('#js_save').attr('disabled',true);
                            $('#js_save').addClass('button_disabel');
                        }

                    });
                    $('#js_save').on('click',function(){
                        var data={
                            scannerid: $.trim($('#js_scannerid').val()),
                            ownername: $.trim($('#js_ownername').val()),
                            contactname:$.trim($('#js_contactname').val()),
                            contactinfo:$.trim($('#js_contactinfo').val())
                        };

                        if($(this).attr('data-id')!=''){
                            data.id=$(this).attr('data-id');
                        }
                        $.ajax({
                            url:gUrl,
                            type:'post',
                            data:data,
                            success:function(res){
                                console.log(res);
                                if (res['status'] == 0) {
                                    $.global_msg.init({
                                        gType: 'warning', msg: '操作成功', time: 2, icon: 1, endFn: function () {
                                            window.location.href = gListUrl;
                                        }
                                    });
                                }
                                 else if(res['status']==310003 )   {
                                        $.global_msg.init({
                                            gType: 'warning', msg: '设备SN码重复', time: 2, icon: 0, endFn: function () {
                                            }
                                        });

                                } else {
                                    $.global_msg.init({
                                        gType: 'warning', msg: '操作失败', time: 2, icon: 0, endFn: function () {
                                            location.reload();
                                        }
                                    });
                                }
                            },
                            fail: function (err) {
                                $.global_msg.init({
                                    gType: 'warning', msg: '操作失败', time: 2, icon: 0

                                });
                            }

                        })

                    })
                }
        }

    })
})(jQuery);