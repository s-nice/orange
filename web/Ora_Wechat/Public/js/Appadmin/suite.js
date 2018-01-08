/**
 * orange 单位详情管理 js
 *
 * */
;(function ($) {
    $.extend({
        suite: {
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

                //续费套餐
                $('.js_suite').on('click',function(){
                    var biz_id =$(this).attr('data-biz_id');
                    if(biz_id){
                        var str='续费套餐';
                        $.global_msg.init({gType:'confirm',icon:2,msg:'确认'+str+'所选企业？' ,btns:true,close:true,title:false,btn1:'取消' ,btn2:'确认' ,
                            noFn:function(){
                                var setobj={
                                    url:gSuiteUrl,
                                    data:{bizid:biz_id},
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

                //编辑套餐
                $('#submit_edit').on('click',function(){
                    var suite_id =$("#suite_id").attr('data-suite_id');
                    var status = $("input[name='status']:checked").val();
                    var isdefault = $("input[name='isdefault']:checked").val();
                    if(suite_id){
                        var str='编辑套餐';
                        $.global_msg.init({gType:'confirm',icon:2,msg:'确认编辑所选套餐？' ,btns:true,close:true,title:false,btn1:'取消' ,btn2:'确认' ,
                            noFn:function(){
                                var setobj={
                                    url:gSuiteEditUrl,
                                    data:{id:suite_id,status:status,isdefault:isdefault},
                                    sMsg:str+'成功',
                                    eMsg:str+'失败'
                                };
                                that.ajaxFn(setobj);
                            }});
                    }else{
                        $.global_msg.init({gType: 'warning', msg: '请选择要操作的套餐', icon: 2});
                        return;
                    }

                })

                $("#goto_list").on('click',function () {
                    location.href=gUrl;
                    return;
                })

                //新增套餐
                $('#submit_add').on('click',function(){
                    var name =  $('input[name="name"]').val();
                    var level = $("input[name='level']:checked").val();
                    var status = $("input[name='status']:checked").val();
                    var num =  $('input[name="num"]').val();
                    var sheet =  $('input[name="sheet"]').val();
                    var suite_desc =  $('input[name="suite_desc"]').val();
                    var price =  $('input[name="price"]').val();
                    var buy_month =  $('input[name="buy_month"]').val();
                    if(undefined==name||null==name||''==name){
                        $.global_msg.init({gType: 'warning', msg: '请输入正确的名片名称', icon: 2});
                        return;
                    }

                    if(undefined==num||null==num||num==''||num<0){
                        $.global_msg.init({gType: 'warning', msg: '请输入正确包含的员工数量', icon: 2});
                        return;
                    }

                    if(undefined==sheet||null==sheet||''==sheet||sheet<0){
                        $.global_msg.init({gType: 'warning', msg: '请输入正确包含的名片数量', icon: 2});
                        return;
                    }
                    if(undefined==price||null==price||price==''){
                        $.global_msg.init({gType: 'warning', msg: '请输入正确套餐的价格', icon: 2});
                        return;
                    }

                    if(undefined==buy_month||null==buy_month||''==buy_month||buy_month<0){
                        $.global_msg.init({gType: 'warning', msg: '请输入正确包含的套餐时长', icon: 2});
                        return;
                    }

                    if(name&&price){
                        var str='新增套餐';
                        $.global_msg.init({gType:'confirm',icon:2,msg:'确认'+str+'？' ,btns:true,close:true,title:false,btn1:'取消' ,btn2:'确认' ,
                            noFn:function(){
                                var setobj={
                                    url:gSuiteAddUrl,
                                    data:{name:name,status:status,level:level,num:num,sheet:sheet,price:price,buy_month:buy_month,suite_desc:suite_desc},
                                    sMsg:str+'成功',
                                    eMsg:str+'失败',
                                    type:1
                                };
                                that.ajaxFn(setobj);
                            }});
                    }else{
                        $.global_msg.init({gType: 'warning', msg: '请选择要操作的套餐', icon: 2});
                        return;
                    }

                })

                //升级套餐
                $('#submit_upgrade').on('click',function(){
                    var biz_id =$('#bizid').attr('data-biz_id');
                    var metaid = $("input[name='metaid']:checked").val();
                    if(biz_id&&metaid){
                        var str='升级套餐';
                        $.global_msg.init({gType:'confirm',icon:2,msg:'确认'+str+'所选企业？' ,btns:true,close:true,title:false,btn1:'取消' ,btn2:'确认' ,
                            noFn:function(){
                                var setobj={
                                    url:gSuiteUpgradUrl,
                                    data:{bizid:biz_id,metaid:metaid},
                                    sMsg:str+'成功',
                                    eMsg:str+'失败',
                                    type:2,
                                    bizid:biz_id
                                };
                                that.ajaxFn(setobj);
                            }});
                    }else{
                        $.global_msg.init({gType: 'warning', msg: '请选择要升级的套餐', icon: 2});
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
                                    if(setObj.type==1){
                                        location.href=gUrl;
                                        return;
                                    }
                                    if(setObj.type==2){
                                        location.href=gSuiteDetailUrl+'/bizid/'+setObj.data.bizid;
                                        return;
                                    }
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