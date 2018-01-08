/**
 * orange 单位详情管理 js
 *
 * */
;(function ($) {
    $.extend({
        company: {
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

                //改标状态 禁用，启用，删除，锁定
                $('.js_change_status').on('click',function(){
                    var id =that.getIds();
                    if(id){
                        console.log(id);
                        var status = $(this).attr('data-status');
                        var str='';
                        switch (status){
                            case 'active':
                                str='启用';
                                break;
                            case 'deleted':
                                str='删除';
                                break;
                            case 'inactive':
                                str='禁用';
                                break;
                            case 'blocked':
                                str='锁定';
                                break;

                        }
                        $.global_msg.init({gType:'confirm',icon:2,msg:'确认'+str+'所选企业？' ,btns:true,close:true,title:false,btn1:'取消' ,btn2:'确认' ,
                            noFn:function(){
                                var setobj={
                                    url:gStatusUrl,
                                    data:{id:id,status:status},
                                    sMsg:str+'成功',
                                    eMsg:str+'失败'
                                };
                                that.ajaxFn(setobj);
                            }});
                    }else{
                        $.global_msg.init({gType: 'warning', msg: '请选择要操作的企业', icon: 2});
                        return;

                    }

                })
                
                
                //赠送套餐
                $('.js_suite').on('click',function(){
                    var suite_id =$(this).attr('data-suite_id');
                    var biz_id =$(this).attr('data-biz_id');
                    if(suite_id){ 
                        var str='赠送套餐';
                        $.global_msg.init({gType:'confirm',icon:2,msg:'确认'+str+'所选企业？' ,btns:true,close:true,title:false,btn1:'取消' ,btn2:'确认' ,
                            noFn:function(){
                                var setobj={
                                    url:gSuiteUrl,
                                    data:{suite_id:suite_id,biz_id:biz_id},
                                    sMsg:str+'成功',
                                    eMsg:str+'失败'
                                };
                                that.ajaxFn(setobj);
                            }});
                    }else{
                        $.global_msg.init({gType: 'warning', msg: '请选择要操作的企业', icon: 2});
                        return;

                    }

                })

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
