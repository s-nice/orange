/*orange预警设置js*/
;(function($){
    $.extend({
        warningSet:({
            defaultNum:'',
            $saveNumButton: $('#js_set_num_save'),//失败次数报警保存按钮
            $addUserButton:$('#js_add_user_button'),//添加用户按钮
            reg:{ //正则
                num:/^[1-9]\d{0,7}$/,
                mail:/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/,
                phone:/^\d{11}$/
            },
            userData:'',
            init:function(){
                var that=this;
                that.defaultNum=typeof ($('#js_set_num').val())!='undefined' ? $('#js_set_num').val() : '';//默认的失败次数报警

                $('#js_set_num').on('keyup',function(){ //设置失败次数报警
                    var num= $.trim($(this).val());
                    if( num!= that.defaultNum && that.reg.num.test(num)){
                        that.buttonFn(that.$saveNumButton,'on')
                    }else{
                        that.buttonFn(that.$saveNumButton,'off')
                    }


                });
                /*点击次数保存按钮*/
                that.$saveNumButton.on('click',function(){ //点击保存
                    that.buttonFn(that.$saveNumButton,'off');
                    that.saveNum($('#js_set_num').val());
                });

                /*添加预警接收人input*/
                $('.js_add_user').on('keyup',function(){
                    var data={};
                    data.name= $.trim($('#js_add_user_name').val());
                    data.mail= $.trim($('#js_add_user_mail').val());
                    data.phone= $.trim($('#js_add_user_phone').val());
                    if(data.name!='' && data.mail!='' && data.phone!=''){
                        that.buttonFn(that.$addUserButton,'on');
                        that.userData=data;
                    }else{
                        that.buttonFn(that.$addUserButton,'off');

                    }
                });

                /*预警接收人保存按钮*/
                that.$addUserButton.on('click',function(){
                    that.checkUserParams(that.userData);
                });

                /*预警接收人删除*/

                $('.js_user_del').on('click',function(){
                    var id=$(this).attr('data-id');
                    $.global_msg.init({gType: 'confirm',
                        icon: 2,
                        msg: '确认删除所选预警接收人？',
                        btns: true, close: true,
                        title: false, btn1: '取消',
                        btn2: '确认',
                        noFn: function () {
                            that.delUser(id);
                        }});

                })

            },
            buttonFn:function(obj,status){
                if(status=='on'){
                    obj.removeClass('button_disabel');
                    obj .attr('disabled',false);
                }else{
                    obj.addClass('button_disabel');
                    obj.attr('disabled',true);
                }

            },

            saveNum:function(num){
                var that=this;
                $.ajax({
                    url:gSetNumUrl,
                    type:'post',
                    data:{
                        num:num
                    },
                    success:function(res){
                        if(0==res.status){
                            that.defaultNum=num;
                            $.global_msg.init({gType: 'warning', icon: 1,msg: '保存成功'});
                        }else{
                            that.buttonFn(that.$saveNumButton,'on');
                            $.global_msg.init({gType: 'warning', icon: 2 ,msg: '保存失败'});
                        }
                    },
                    fail:function(){
                        that.buttonFn(that.$saveNumButton,'on');
                        $.global_msg.init({gType: 'warning', icon: 2 ,msg: '保存失败'});

                    }
                });
            },
            /*检查 添加与预警人的 邮箱手机参数*/
            checkUserParams:function(data){
                var that=this;
                if(!that.reg.mail.test(data.mail)){
                    $.global_msg.init({gType: 'warning', icon: 2 ,msg: '邮箱输入错误,请修改'});
                    return;
                }

                if(!that.reg.phone.test(data.phone)){
                    $.global_msg.init({gType: 'warning', icon: 2 ,msg: '手机号输入错误,请修改'});
                    return;
                }
                that.buttonFn(that.$addUserButton,'off');
                that.saveUser(data);

            },

            /*添加预警人*/
            saveUser:function(data){
                var that=this;
                $.ajax({
                    url:gAddUrl,
                    type:'post',
                    data:data,
                    success:function(res){
                        if(0==res.status){
                            $('.js_add_user').val('');
                            $.global_msg.init({gType: 'warning', icon: 1,msg: '保存成功'});
                            window.location.reload();//刷新当前页面.

                        }else if(999005==res.status){
                            that.buttonFn(that.$addUserButton,'on');
                            $.global_msg.init({gType: 'warning', icon: 2 ,msg: '接收人信息已经存在，请修改'});

                        }else{
                            that.buttonFn(that.$addUserButton,'on');
                            $.global_msg.init({gType: 'warning', icon: 2 ,msg: '保存失败'});
                        }
                    },
                    fail:function(){
                        that.buttonFn(that.$addUserButton,'on');
                        $.global_msg.init({gType: 'warning', icon: 2 ,msg: '保存失败'});
                    }
                });
            },

            /*删除预警人*/
            delUser:function(id){
                var that=this;
                $.ajax({
                    url:gDelUrl,
                    type:'post',
                    data:{
                        id:id,
                    },
                    success:function(res){
                        if(0==res.status){
                            $.global_msg.init({gType: 'warning', icon: 2,msg: '删除成功'});
                            window.location.reload();//刷新当前页面.
                        }else{
                            $.global_msg.init({gType: 'warning', icon: 2 ,msg: '删除失败'});
                        }
                    },
                    fail:function(){
                        that.buttonFn(that.$addUserButton,'on');
                        $.global_msg.init({gType: 'warning', icon: 2 ,msg: '删除失败'});
                    }
                });
            }

        })

    });

    $.warningSet.init();
})(jQuery);