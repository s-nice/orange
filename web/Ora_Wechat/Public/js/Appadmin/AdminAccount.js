/**
 * 管理员账号 js
 *
 * */
;(function ($) {
    $.extend({
        adminAccount: {
            init: function () {
                var that = this;
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

            },
            addInit:function(){ //添加编辑管理员账号页面初始化
                this.addEvent();

            },
            addEvent:function(){ //添加编辑页面js
                var that=this;
                $('#js_submit_add').on('click',function(){
                    that.check();
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
            },

            /**
            * 检测添加管理员账号
            * */
            check:function(){
                //检测邮箱
                var data={};
                var email = $.trim($('input[name="email"]').val());
                if(email=='' || typeof (email)=='undefined'){
                    $('#tx_email').html('电子邮箱不可为空');
                    return false
                }
                var regexp = /^([\w\.\-_]+)\@([\w\-]+\.)([\w]{2,4})$/;
                if(!regexp.test(email)){
                    $('#tx_email').html('请正确添加邮箱格式');
                    return false
                }
                data.email=email;
                $('#tx_email').html('');
                //检测密码
                var password = $.trim($('input[name="password"]').val());
                var password2 = $.trim($('input[name="password2"]').val());
                if(password!='' || password2!='' ){//修改密码
                    if(password=='' || typeof (password)=='undefined'){
                        $('#tx_password').html('密码不可为空');
                        return false
                    }
                    if(password2=='' || typeof (password2)=='undefined'){
                        $('#tx_password2').html('确认密码不可为空');
                        return false
                    }

                    if(password != password2){
                        $('#tx_password').html('密码和确认密码不相同');
                        return false
                    }
                    var passwdreg = /^[\w|!|@|#|$|%|^|&|*|\(|\)|,|.|?|<|>|/|_\+]{6,16}$/;
                    if(!passwdreg.test(password)){
                        $('#tx_password').html('请填写长度为6至16位的密码');
                        return false
                    }
                    if(!passwdreg.test(password2)){
                        $('#tx_password2').html('请填写长度为6至16位的密码');
                        return false
                    }
                    data.password=password;
                    $('#tx_password,#tx_password2').html('');

                }
                //检测姓名
                var realname = $.trim($('input[name="realname"]').val());
                if(realname=='' || typeof (realname)=='undefined'){
                    $('#tx_realname').html('姓名不可为空');
                    return false
                }
                data.realname=realname;
                $('#tx_realname').html('');
                var id=$('#js_submit_add').attr('data-id');
                if(id!='' && typeof (id) != 'undefined' ){ //编辑
                    data.id=id;
                }
                this.doajax(data,subUrl);

            },
            /**
            * 添加或编辑账号
            * */
            doajax:function (data,url){
                    $.ajax({
                        url: url,
                        type:'post',
                        data:data,
                        success:function(res){
                            if(res.status=='0'){
                                $.global_msg.init({
                                    gType: 'warning', msg:'操作成功', time: 2, icon: 1, endFn: function () {
                                        if( typeof window.opener == 'object' && typeof window.opener.closeWindow=='function') {
                                            window.opener.closeWindow(window, true); //关闭当前页，刷新列表页
                                        }
                                    }
                                });
                            }else{
                                $.global_msg.init({
                                    gType: 'warning', msg: '操作失败', time: 2, icon: 0
                                });
                            }
                        },
                        fail:function(err){
                            $.global_msg.init({
                                gType: 'warning', msg:'操作失败', time: 2, icon: 0

                            });
                        }
                    });
            }



        }

    })
})(jQuery);
