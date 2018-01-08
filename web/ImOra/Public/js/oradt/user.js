/**
 * 注册用户管理
 */

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

                //添加beta用户
                $('.js_addUser').on('click',function(){
                	var $this=$(this);
                	var typeval = $this.attr('typeval') ? $this.attr('typeval') : 3 ;
                    $('#js_cloneDom').append($('.Beta_comment_pop').clone());
                    $('#js_cloneDom .Beta_comment_pop').find('.Betacomment_title').text($this.text())
                    $('#js_cloneDom .Beta_comment_pop').show();
                    $('.js_masklayer').show();
                    $('#js_cloneDom .Beta_comment_close img,.js_add_cancel').on('click',function(){
                        $(this).parents('.Beta_comment_pop').remove();
                        $('.js_masklayer').hide();
                    });

                    //提交
                    $('#js_cloneDom .js_add_sub').on('click',function(){
                        var username = $('#js_cloneDom #js_username').val();
                        var userid = $('#js_cloneDom #js_userid').val();
                        var password = $('#js_cloneDom #js_password').val();
                        var repasswd = $('#js_cloneDom #js_repasswd').val();

                        var nickname = $('#js_cloneDom #js_nickname').val();
                        var cellphone = $('#js_cloneDom #js_cellphone').val();
                        var telephone = $('#js_cloneDom #js_telephone').val();
                        var title = $('#js_cloneDom #js_title').val();
                        var department = $('#js_cloneDom #js_department').val();
                        var company = $('#js_cloneDom #js_company').val();
                        var address = $('#js_cloneDom #js_address').val();
                        var email = $('#js_cloneDom #js_email').val();
                        var fax = $('#js_cloneDom #js_fax').val();
                        var website = $('#js_cloneDom #js_website').val();
                        //判断是否为空，做提示1
                        if( typeof(username)=='string' && username==''){
                            $('#js_cloneDom #js_username').addClass('invalid_warning');
                            $.global_msg.init({gType:'warning',icon:2,time:3,msg:js_verify_username_null});
                            return false;
                        }else{
                            $('#js_cloneDom #js_username').removeClass('invalid_warning');
                        }

                        if( typeof(userid)=='string' && userid==''){
                            $('#js_cloneDom #js_userid').addClass('invalid_warning');
                            $.global_msg.init({gType:'warning',icon:2,time:3,msg:js_verify_mobile_null});
                            return false;
                        }else{
                            $('#js_cloneDom #js_userid').removeClass('invalid_warning');
                        }
                        if( typeof(password)=='string' && password==''){
                            $('#js_cloneDom #js_password').addClass('invalid_warning');
                            $.global_msg.init({gType:'warning',icon:2,time:3,msg:js_verify_password_null});
                            return false;
                        }else{
                            $('#js_cloneDom #js_password').removeClass('invalid_warning');
                        }
                        if( typeof(repasswd)=='string' && ( repasswd=='' || password!=repasswd )){
                            $('#js_cloneDom #js_repasswd').addClass('invalid_warning');
                            $.global_msg.init({gType:'warning',icon:2,time:3,msg:js_verify_password_same});
                            return false;
                        }else{
                            $('#js_cloneDom #js_repasswd').removeClass('invalid_warning');
                        }

                        //扩展信息必填项
                        if( typeof(nickname)=='string' && nickname==''){
                            $('#js_cloneDom #js_nickname').addClass('invalid_warning');
                            $.global_msg.init({gType:'warning',icon:2,time:3,msg:js_verify_ext_name});
                            return false;
                        }else{
                            $('#js_cloneDom #js_nickname').removeClass('invalid_warning');
                        }
                        if( typeof(cellphone)=='string' && cellphone==''){
                            $('#js_cloneDom #js_cellphone').addClass('invalid_warning');
                            $.global_msg.init({gType:'warning',icon:2,time:3,msg:js_verify_ext_mobile});
                            return false;
                        }else {
                            $('#js_cloneDom #js_cellphone').removeClass('invalid_warning');
                        }
                        if( typeof(department)=='string' && department==''){
                            $('#js_cloneDom #js_department').addClass('invalid_warning');
                            $.global_msg.init({gType:'warning',icon:2,time:3,msg:js_verify_ext_department});
                            return false;
                        }else {
                            $('#js_cloneDom #js_department').removeClass('invalid_warning');
                        }
                        if( typeof(company)=='string' && company==''){
                            $('#js_cloneDom #js_company').addClass('invalid_warning');
                            $.global_msg.init({gType:'warning',icon:2,time:3,msg:js_verify_ext_company});
                            return false;
                        }else {
                            $('#js_cloneDom #js_company').removeClass('invalid_warning');
                        }

                        var datastring = 'username='+username+'&userid='+userid+'&password='+password+'&typeval='+typeval;
                        datastring+= '&nickname='+nickname+'&cellphone='+cellphone+'&telephone='+telephone;
                        datastring+= '&title='+title+'&department='+department+'&company='+company;
                        datastring+= '&address='+address+'&email='+email+'&fax='+fax+'&website='+website;
                        $.users.subAddUser(datastring);

                    });
                });

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

                //封号与解封
                $('.js_dolock_user').on('click',function(){
                    var id = $(this).parent().attr('data-cid');
                    $.global_msg.init({gType:'confirm',icon:2,msg:'确定对该用户进行封号吗？' ,btns:true,close:true,title:false,btn1:'取消' ,btn2:'确定' ,noFn:function(){
                        //封号
                        $.users.lockUser(id,'inactive');
                    }});

                });
                $('.js_unlock_user').on('click',function(){
                    var id = $(this).parent().attr('data-cid');
                    $.global_msg.init({gType:'confirm',icon:2,msg:'确定对该用户进行解封吗？' ,btns:true,close:true,title:false,btn1:'取消' ,btn2:'确定' ,noFn:function(){
                        //解封
                        $.users.lockUser(id,'active');
                    }});

                });
                //企业账号封号与解封功能
                $('.js_single_close_account').on('click',function(){
                    var id = $(this).parent().attr('data-id');
                    var type = $(this).attr('data-type');
                    var msg = type=='blocked' ? '确定对该用户进行封号吗？': '确定对该用户进行解封吗？';
                    console.log(id)
                    $.global_msg.init({gType:'confirm',icon:2,msg:msg ,btns:true,close:true,title:false,btn1:'取消' ,btn2:'确定' ,noFn:function(){
                        //解封
                        $.users.lockUser(id,type,gUrlCloseAccount);
                    }});

                });
                //共享开关
                $('.js_do_noshared').on('click',function(){
                    var id = $(this).parent().attr('data-cid');
                    $.global_msg.init({gType:'confirm',icon:2,msg:'确定禁用该用户的共享吗？' ,btns:true,close:true,title:false,btn1:'取消' ,btn2:'确定' ,noFn:function(){
                        //禁用共享
                        $.users.sharedSwitch(id,2);
                    }});

                });
                $('.js_do_shared').on('click',function(){
                    var id = $(this).parent().attr('data-cid');
                    $.global_msg.init({gType:'confirm',icon:2,msg:'确定开启该用户的共享吗？' ,btns:true,close:true,title:false,btn1:'取消' ,btn2:'确定' ,noFn:function(){
                        //开启共享
                        $.users.sharedSwitch(id,1);
                    }});

                });
                //无限量开关
                $('.js_dounlimit').on('click',function(){
                    //open
                    var id = $(this).parent().attr('data-cid');
                    $.global_msg.init({gType:'confirm',icon:2,msg:'确定开启该用户的无限量吗？' ,btns:true,close:true,title:false,btn1:'取消' ,btn2:'确定' ,noFn:function(){
                        //关闭无限量
                        $.users.limitSwitch(id,1);
                    }});

                });
                $('.js_dolimit').on('click',function(){
                    //close
                    var id = $(this).parent().attr('data-cid');
                    $.global_msg.init({gType:'confirm',icon:2,msg:'确定关闭该用户的无限量吗？' ,btns:true,close:true,title:false,btn1:'取消' ,btn2:'确定' ,noFn:function(){
                        //开启无限量
                        $.users.limitSwitch(id,2);
                    }});

                });

            },

            /*添加betauser | 客服用户*/
            subAddUser:function( _datas ){

                $.ajax({
                    url:addUserUrl,
                    type:'post',
                    dataType:'json',
                    data:_datas,
                    success:function(res){
                        if(res.status!==0){
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:res.msg});
                        }else{
                            $('#js_cloneDom .Beta_comment_pop').remove();
                            $('.js_masklayer').hide();
                            //添加成功 (是不是要刷新页面啊？)
                            window.location.reload();
                        }

                    },error:function(res){
                        //添加失败
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_operat_error});

                        return false;
                    }
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

            /* 封号、解封 用户 */
            lockUser:function( _id, _state,url){
            	url = typeof(url) == 'undefined' ? '/Appadmin/User/lockOrUnlock' : url;
                $.ajax({
                    url:url,
                    type:'post',
                    dataType:'json',
                    data:'id='+_id+'&state='+_state,
                    success:function(res){
                        if(res.status!==0){
                            $.global_msg.init({gType:'warning',icon:0,time:3,close:true,msg:js_operat_error});
                        }else{
                            $.global_msg.init({gType:'alert',icon:1,msg:js_operat_success,time:3,close:true,
                                title:false ,endFn:function(){
                                    $.users.refreshPage();
                                }
                            });
                        }

                    },error:function(res){
                        //错误
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_operat_error});

                        return false;
                    }
                });
            },
            /* 共享开关 */
            sharedSwitch:function( _id, _isshared){
                $.ajax({
                    url:'/Appadmin/User/sharedSwitch',
                    type:'post',
                    dataType:'json',
                    data:'id='+_id+'&isshared='+_isshared,
                    success:function(res){
                        if(res.status!==0){
                            $.global_msg.init({gType:'warning',icon:0,time:3,close:true,msg:js_operat_error});
                        }else{
                            $.global_msg.init({gType:'alert',icon:1,msg:js_operat_success,time:3,close:true,
                                title:false ,endFn:function(){
                                    $.users.refreshPage();
                                }
                            });
                        }

                    },error:function(res){
                        //错误
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_operat_error});

                        return false;
                    }
                });
            },
            /* 无限量开关 */
            limitSwitch:function( _id, _limit){
                $.ajax({
                    url:'/Appadmin/User/unlimitSwitch',
                    type:'post',
                    dataType:'json',
                    data:'id='+_id+'&unlimit='+_limit,
                    success:function(res){
                        if(res.status!==0){
                            $.global_msg.init({gType:'warning',icon:0,time:3,close:true,msg:js_operat_error});
                        }else{
                            $.global_msg.init({gType:'alert',icon:1,msg:js_operat_success,time:3,close:true,
                                title:false ,endFn:function(){
                                    $.users.refreshPage();
                                }
                            });
                        }

                    },error:function(res){
                        //错误
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_operat_error});

                        return false;
                    }
                });
            },
            /*刷新页面*/
            refreshPage:function(){
                window.location.reload();
            },
            /*
            * 个人认证js
            * */
            varify:function(){

                $('.pernotcer_bin').on('click','#js_varify_pass',function(){
                    var authid = $(this).parent().attr('data-cid');
                    var opt = 1;
                    $.global_msg.init({gType:'confirm',icon:2,msg:'确定通过认证吗？' ,btns:true,close:true,title:false,btn1:'取消' ,btn2:'确定' ,noFn:function(){
                        //认证通过
                        $.users.varifyRequest(authid,opt,'',js_need_varifylist_url);
                    }});
                });
                $('.pernotcer_bin').on('click','#js_varify_not_pass',function(){
                    $('.reason_shadow').show();
                    $('.js_reason_confirm').show();

                    var authid = $(this).parent().attr('data-cid');
                    var opt = -1;
                    var reasonstr = '';
                    //提交
                    $('.js_submit_reason').on('click',function(){
                        reasonstr = $('.js_reason_confirm .js_reason_content').val();
                        if(reasonstr==''){
                            $.global_msg.init({gType:'warning',icon:0,time:3,close:true,msg:'请输入认证不通过原因备注'});
                            return false;
                        }
                        //认证不通过
                        $.users.varifyRequest(authid,opt,reasonstr,js_need_varifylist_url);
                        $('.reason_shadow').hide();
                        $('.js_reason_confirm').hide();
                    });

                    //关闭按钮
                    $('.js_close_reason').on('click',function(){
                        $('.reason_shadow').hide();
                        $('.js_reason_confirm').hide();
                    });
                });
                //取消认证
                $('.pernotcer_bin').on('click','#js_varify_cancel_auth',function(){
                    $('.reason_shadow').show();
                    $('.js_reason_confirm').show();

                    var authid = $(this).parent().attr('data-cid');
                    var opt = 0;
                    var reasonstr = '';

                    //提交
                    $('.js_submit_reason').on('click',function(){
                        reasonstr = $('.js_reason_confirm .js_reason_content').val();
                        if(reasonstr==''){
                            $.global_msg.init({gType:'warning',icon:0,time:3,close:true,msg:'请输入取消认证原因备注'});
                            return false;
                        }
                        //取消认证
                        $.users.varifyRequest(authid,opt,reasonstr,js_had_varifylist_url);
                        $('.reason_shadow').hide();
                        $('.js_reason_confirm').hide();
                    });

                    //关闭按钮
                    $('.js_close_reason').on('click',function(){
                        $('.reason_shadow').hide();
                        $('.js_reason_confirm').hide();
                    });

                });
            },
            varifyRequest:function(_id,_opt,reasonstr,_url){
                $.ajax({
                    url:'/Appadmin/User/authUser',
                    type:'post',
                    dataType:'json',
                    data:'id='+_id+'&status='+_opt+'&remark='+reasonstr,
                    success:function(res){
                        if(res.status!==0){
                            $.global_msg.init({gType:'warning',icon:0,time:3,close:true,msg:js_operat_error});
                        }else{
                            $.global_msg.init({gType:'alert',icon:1,msg:js_operat_success,time:3,close:true,
                                title:false ,endFn:function(){
                                    window.location.href = _url;
                                }
                            });
                        }

                    },error:function(res){
                        //错误
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_operat_error});

                        return false;
                    }
                });
            }


        }
    });
})(jQuery);