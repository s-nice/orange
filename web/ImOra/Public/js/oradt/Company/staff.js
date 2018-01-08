/**
 *资讯  问答 页面js
 */
var gloable_showid = '';//已选资讯id
(function($) {
    $.extend({
        staff: {
            layer_user :null,//保存选择员工弹框
            init: function() {
                /*绑定事件*/
                //下拉框
                $('#js_mod_select,#js_seltitle').on('click',function(){
                    $('#js_selcontent').toggle();
                });
                //点击区域外关闭此下拉框
                /*$(document).on('click',function(e){
                    if($(e.target).parents('.js_select_ul_list').length>0){
                        var currUl = $(e.target).parents('.js_select_ul_list').find('ul');
                        $('.js_select_ul_list>ul').not(currUl).hide()
                    }else{
                        $('.js_select_ul_list>ul').hide();
                    }
                });*/
                
                //选择部门
                $('#js_select_type').on('change',function(){
                    var language = $("option:selected",this).attr('lval');
                    $('input[name=l]').val(language);
                });

                
                //delete
                $('.data-list').on('click','.js_delete_btn',function(){
                    var oDel = $(this);
                    $.global_msg.init({gType:'confirm',icon:2,msg:'确定删除此员工吗？',btns:true,close:true,
                        title:false,btn1:'取消',btn2:'确定' ,noFn:function(){
                            var ids = oDel.attr('data-id');

                            $.staff.delStaff(ids);

                        }
                    });
                });

                //点击新增
                $('.js_btn_add_import').on('click',function(){
                    var url = $(this).attr('ahref');
                    var str = $(this).find('input').val();
                    $.get(getAuthorUrl,function(re){
                        if(re.status==0){
                            window.location.href = url;
                        }else{
                            $.global_msg.init({gType:'confirm',icon:2,msg:'您未购买企业授权，暂时不能添加员工，是否前去购买',btns:true,close:true,
                        title:false,btn1:'继续'+str,btn2:'确定' ,noFn:function(){
                                window.location.href = buyAuthorUrl;
                                },fn:function(){
                                    window.location.href = url;
                                }
                            });
                        }
                    })
                });

            },
            staffAdd:function(){
                var _this = this;
                _this._common();
                /* 多项 input 改变，则取值拼接*/
                $('.js_input_sub').on('change',function(){
                    var name = $(this).attr('data-name');
                    var values = '';
                    $('.js_'+name).each(function(i){
                        if($(this).val()!=''){
                            values +=$(this).val()+',';
                        }
                    });
                    $('input[name='+name+']').val(values);

                });
                //复制输入框
                $('.list_text .js_clone_div').on('click','.js_ei_add',function(){
                    //如果当前职位输入框为空，则不允许添加新输入框
                    if($(this).parent().find('input').val()==''){
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:'请填写后再进行添加'});
                        return false;
                    }
                    var _dom = $(this).parent().clone(true);
                    _dom.find('ei').addClass('js_ei_subtract').removeClass('js_ei_add').html('-');
                    var data_name = $(this).parent().attr('data-name');
                    var length = $(this).parents('.js_tab_div').find('.js_'+data_name).length;
                    if(length>=20){
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:'最多添加20个'});
                        return false;
                    }
                    //判断是否是复制职位
                    if(data_name=='position'){
                        var keynumb = $(this).parents('.js_tab_div').find('.js_div_position:last').attr('data-key');
                        _dom.attr('data-key',parseInt(keynumb)+1);
                        var _departmentorig = $(this).parents('.js_tab_div').find('.js_div_department[data-key='+keynumb+']');
                        var _departmentdom = _departmentorig.clone(true);
                        _departmentdom.attr('data-key',(parseInt(keynumb)+1));
                        _departmentdom.find('input').val('');
                        _departmentorig.after(_departmentdom);
                        //$.staff.chageInputValue('department');
                    }
                    _dom.find('input').val('');

                    $(this).parents('.input_float_left').find('.js_clone_div:last').after(_dom);
                });
                //删减输入项
                $('.list_text .input_addstaff').on('click','.js_ei_subtract',function(){
                    //判断是否是删除职位
                    if($(this).parent().attr('data-name')=='position'){
                        var keynumb = $(this).parent().attr('data-key');
                        $(this).parents('.js_tab_div').find('.js_div_department[data-key='+keynumb+']').remove();
                    }
                    $(this).parents('.input_addstaff').remove();

                    /*$.staff.chageInputValue('position');
                    $.staff.chageInputValue('department');*/

                });

                //提交保存
                $('#js_sub_btn').on('click',function(){
                    var empid = $('input[name=empid]').val();
                    var name = $('input[name=name]').val();
                    var eng_name = $('input[name=eng_name]').val();
                    var superior = $('input[name=superior]').attr('val');
                    var department = _this._getValue($('.js_tab_div').eq(0).find('.js_department'),true);
                    var position = _this._getValue($('.js_tab_div').eq(0).find('.js_position'),true);
                    var eng_department = _this._getValue($('.js_tab_div').eq(1).find('.js_department'),true);
                    var eng_position = _this._getValue($('.js_tab_div').eq(1).find('.js_position'),true);
                    var mobile = _this._getValue($('.js_mobile'));
                    var email = _this._getValue($('.js_email'));
                    var tel = _this._getValue($('.js_telephone'));
                    var fax = _this._getValue($('.js_fax'));
                    var authorid = $('.js_div_authorid .color_red').length?$('.js_div_authorid .color_red').attr('data-id'):0;
                    var payid = $('.js_div_payid .color_red').length?$('.js_div_payid .color_red').attr('data-id'):0;
                    var otherpay = $('#js_otherpay_show').is(':checked')?1:0;
                    var platform = $('#js_platform_show').is(':checked')?1:0;
                    var roleid = '';
                    if($('#js_platform_show').is(':checked')){
                        var arr = [];
                        $.each($('.js_div_roleid .color_red'),function(){
                            arr.push($(this).attr('data-id'));
                        });
                        roleid = arr.join(',');
                    }
                    if(!name||!position||!mobile||!email){
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:'请填写完整'});
                        return false;
                    }
                    if(!_this._checkAllDepartment()){
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:'部门名称不能使用所有部门'});
                        return false;
                    }
                    var index = layer.load(0,1);
                    $.post(postUrl,{empid:empid,name:name,eng_name:eng_name,superior:superior,department:department,position:position,eng_department:eng_department,eng_position:eng_position,mobile:mobile,email:email,phones:tel,fax:fax,authorid:authorid,payid:payid,otherpay:otherpay,platform:platform,roleid:roleid},function(re){
                        if(re.status===0){
                            layer.close(index);
                            $.global_msg.init({gType:'alert',time:1,icon:1,msg:re.msg,endFn:function(){
                                window.location.href = indexUrl ;
                            }});
                        }else{
                            layer.close(index);
                            $.global_msg.init({gType:'alert',time:3,icon:0,msg:re.msg});
                            return false;
                        }
                    })
                });
                
                //中 英文 切换
                $('.js_tab_lang').on('click',function(){
                    $(this).addClass('bg_btn').siblings().removeClass('bg_btn');
                    var index = $(this).index();
                    $('.js_tab_div').eq(index).show().siblings('.js_tab_div').hide();
                    if(index==1){
                        $('.js_sle_div').hide();
                    }else{
                        $('.js_sle_div').show();
                    }
                });

                
                //点击下拉箭头
                $('.text_info').on('click','.span_img',function(){
                    var ul = $(this).parents('.input_addstaff').find('.staff_list');
                    $(this).find("b").toggleClass("up");
                    if(ul.html()){
                        ul.toggle();
                    }
                });

                //点击其他部位，隐藏下拉框
                $(document).on('click',function(e){
                    
                    if($(e.target).parents('.js_input_sub').length>0||$(e.target).parents('.span_img').length>0){
                        /*var currUl = $(e.target).parents('.js_select_ul_list').find('ul');
                        $('.js_select_ul_list>ul').not(currUl).hide();*/
                    }else{
                        $('ul.staff_list').hide();
                        $(".span_img").find("b").removeClass("up");
                    }
                });

                //点击li选择选项
                $('.text_info').on('click','.staff_list li',function(){
                    var oInput = $(this).parents('.js_clone_div').find('input');
                    var val = $(this).text();
                    var va = $(this).attr('val');
                    oInput.val(val).attr('val',va);
                    $(this).parents('ul').hide();
                    $(this).addClass("libg").siblings().removeClass("libg");
                    $(".span_img").find("b").removeClass("up");
                    if($(this).parents('.js_div_department').length>0){
                        oInput.trigger('input');
                    }
                });

                //部门输入框变化
                $('.text_info').on('input propertychange','.js_department',function(){
                    var index = $(this).parents('.js_div_department').index();
                    var oUl = $(this).parents('.input_div').find('.js_div_position').eq(index).find('ul.staff_list');
                    var department = $(this).val();
                    var language = $(this).attr('language');
                    $.ajax({
                        url:getTitleUrl,
                        type:'GET',
                        dataType:'json',
                        async:true,
                        data:{department:department,language:language},
                        success:function(re){
                            if(re.status==0){
                                var html = '';
                                if(re.data){
                                    //console.log(re.data);
                                    $.each(re.data,function(k,v){
                                        if(v.title){
                                            html += '<li>'+v.title+'</li>';
                                        }
                                    });
                                }
                                oUl.html('<div class="js_scroll_div">'+html+'</div>');
                                var scObj = oUl.find('.js_scroll_div');
                                if(scObj.find('li').length>7){
                                    scObj.mCustomScrollbar({
                                        theme:"dark", //主题颜色
                                        set_height:200,
                                        autoHideScrollbar: false, //是否自动隐藏滚动条
                                        scrollInertia :0,//滚动延迟
                                        horizontalScroll : false//水平滚动条
                                    });
                                }
                                
                            }
                        }
                    })
                    /*$.get(getTitleUrl,{department:department,departid:departid},function(re){
                        if(re.status==0){
                            var html = '';
                            if(re.data){
                                //console.log(re.data);
                                $.each(re.data,function(k,v){
                                    if(v.title){
                                        html += '<li>'+v.title+'</li>';
                                    }
                                });
                            }
                            oUl.html(html);
                        }
                    });*/
                });
                
               /* //点击职位下拉框
                $('.text_info').on('click','.js_div_position .span_img',function(){
                    var oUl = $(this).next();
                    if(oUl.is(':visible')){
                        oUl.hide();
                        return false;
                    }
                    oUl.html('');
                    var oInput = $(this).parents('.input_div').find('.js_div_department').find('input');
                    var department = oInput.val();
                    var departid = oInput.attr('val');
                    $.get(getTitleUrl,{department:department,departid:departid},function(re){
                        if(re.status==0){
                            if(re.data){
                                var html = '';
                                $.each(re.data,function(k,v){
                                    if(v.title){
                                        html += '<li>'+v.title+'</li>';
                                    }
                                });
                                if(html){
                                    oUl.html(html);
                                    oUl.show();
                                }
                            }
                        }
                    });
                });*/
                $.each($('.staff_list'),function(){
                    var num = $(this).find('li').length;
                    if(num>7){
                        $(this).mCustomScrollbar({
                            theme:"dark", //主题颜色
                            set_height:200,
                            autoHideScrollbar: false, //是否自动隐藏滚动条
                            scrollInertia :0,//滚动延迟
                            horizontalScroll : false//水平滚动条
                        });
                    }
                });
                $.each($('.js_department'),function(k,v){
                    $(this).trigger('propertychange');
                });
            },
            _checkAllDepartment:function(){
                var bool = true;
                $.each($('.js_department'),function(k,v){
                    if($(this).val()=='所有部门'){
                        bool = false;
                        return false;
                    }
                });
                return bool;
            },
            _getValue:function(obj,noCheck){
                var arr = [];
                $.each(obj,function(){
                    if(noCheck===true){
                        arr.push($(this).val());
                    }else{  
                        if($(this).val()){
                            arr.push($(this).val());
                        }
                    }
                });
                return arr.join(',');
            },
            chageInputValue:function(_name){
                var values = '';
                $('.js_'+_name).each(function(i){
                    if($(this).val()!=''){
                        values +=$(this).val()+',';
                    }
                });
                $('input[name='+_name+']').val(values);
            },
            delStaff:function(_id){
                $.ajax({
                    url:delStaffUrl,
                    type:'post',
                    dataType:'json',
                    data:'id='+_id,
                    success:function(res){
                        //回收成功
                        if(res.status==0){
                            $.global_msg.init({gType:'warning',icon:1,time:3,msg:res.msg,endFn:function(){
                                window.location.reload();
                            }});

                        }else{
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:res.msg});
                        }

                    },error:function(res){
                        //删除失败
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:'删除失败'});

                    }
                });
            },

            _common:function(){
                                //找人消费
                $('#js_otherpay_show').on('click',function(){
                    if($(this).is(':checked')){
                        //console.log($('.js_div_payid').html());
                        if(!$('.js_div_payid').find('.color_gray').length){
                            $.global_msg.init({gType:'confirm',icon:2,msg:'您还未新增消费规则，是否前去新增消费规则？',btns:true,close:true,
                        title:false,btn1:'取消',btn2:'确定' ,noFn:function(){
                                    window.location.href = addRuleUrl;

                                }
                            });
                            return false;
                        }
                        $('#js_rule_show').show();
                    }else{
                        $('#js_rule_show').hide();
                    }

                });

                //平台使用
                $('#js_platform_show').on('click',function(){

                    if($(this).is(':checked')){
                        if(!$('.js_div_roleid').html()){
                            $.global_msg.init({gType:'confirm',icon:2,msg:'您还未新增企业平台角色，是否前去新增角色？',btns:true,close:true,
                        title:false,btn1:'取消',btn2:'确定' ,noFn:function(){
                                    window.location.href = addRoleUrl;

                                }
                            });
                            return false;
                        }
                        $('#js_role_show').show();
                    }else{
                        $('#js_role_show').hide();
                    }

                });

                //员工权限 角色 选项
                $('.js_sle_div').on('click','.select_item,.shop_item',function(){
                    var key = $(this).attr('data-key');
                    if(key=='authorid'){
                        if($(this).find('.js_residuenum').length){
                            var num = parseInt($(this).find('.js_residuenum').text());
                            if(num<=0){
                                $.global_msg.init({gType:'alert',time:3,icon:0,msg:'此授权无剩余数量'});
                                return false;
                            }
                        }
                    }
                    if(key=='authorid'||key=='payid'){
                        $(this).siblings().removeClass('color_red');
                    }
                    $(this).toggleClass('color_red');
                });

                //新增、编辑，导入员工，取消按钮
                $('#js_cancel_btn').on('click',function(){
                    window.history.back(-1);
                });
            },

            //导入
            importstaff:function(){
                this._common();
                $('#js_btn_import').on('click',function(){
                    var file = $('input[name=uploadfile]').val();
                    if(!file){
                        $.global_msg.init({gType:'alert',time:3,icon:0,msg:'请选择文件'});
                        return false;
                    }
                    var ext = file.split('.').pop().toLowerCase();
                    if((ext!='xlsx')&&(ext!='xls')){
                        $.global_msg.init({gType:'alert',time:3,icon:0,msg:'文件格式不正确'});
                        return false;
                    }
                    var payid = $('input[name=payid]').val();
                    var roleid = $('input[name=roleid]').val();
                    var authorid = $('input[name=authorid]').val();
                    var otherpay = $('input[name=otherpay]').is(':checked')?1:0;
                    var platform = $('input[name=platform]').is(':checked')?1:0;
                    var index = layer.load(0,1);
                    $.ajaxFileUpload({
                        url : postUrl,
                        secureuri: false,
                        fileElementId: 'exampleInputFile',
                        data:{payid:payid,roleid:roleid,authorid:authorid,otherpay:otherpay,platform:platform},
                        dataType: 'json',
                        success: function (rtn, status){
                            if(rtn.status==1){
                                layer.close(index);
                                $.global_msg.init({gType:'alert',icon:2,time:3,msg:rtn.msg});
                                return false;
                            }else if(rtn.status==0){
                                layer.close(index);
                                $.global_msg.init({gType:'alert',icon:1,time:3,msg:rtn.msg,endFn:function(){
                                    window.location.reload();
                                }});
                            }
                        },
                        error: function (data, status, e){
                        }
                    });
                });

                //员工权限 角色 点击
                $('.js_sle_div').on('click','.select_item,.shop_item',function(){
                    var key = $(this).attr('data-key');
                    if(key=='authorid'){
                        var data_id = $(this).attr('data-id');
                        $('input[name=authorid]').val(data_id);
                    }else if(key=='payid'){
                        var data_id = $(this).attr('data-id');
                        $('input[name=payid]').val(data_id);
                    }else{
                        var bool = $(this).hasClass('color_red');
                        var data_id = $(this).attr('data-id');
                        var roleid = $('input[name=roleid]').val();
                        if(!roleid){
                            $('input[name=roleid]').val(data_id);
                            return false;
                        }
                        var arr = roleid.split(',');
                        var newArr = [];
                        if(bool){
                            var hasRoleid = false;
                            $.each(arr,function(k,v){
                                if(v==data_id){
                                    hasRoleid = true;
                                    return false;
                                }
                            });
                            if(!hasRoleid){
                                arr.push(data_id);
                                newArr = arr;
                            }
                        }else{
                            $.each(arr,function(k,v){
                                if(v!=data_id){
                                    newArr.push(v);
                                }
                            });
                        }
                        var str = newArr.join(',');
                        $('input[name=roleid]').val(str);
                    }
                });

            },

            /*过滤空格，回车*/
            trimStrings:function (str){
                return str.replace(/(^\s*)|(\s*$)/g,"");
            },

            /*刷新页面*/
            refreshPage:function(){
                window.location.reload();
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
            /*员工共享*/
            customerShareJs:function(){
                _this=this;
                //共享开关
                $('.js_open').on('click',function(){
                    var keyid = $(this).parent().attr('data-key');
                    $.staff.switchShare(1,keyid,this);

                });
                $('.js_close').on('click',function(){
                    var keyid = $(this).parent().attr('data-key');
                    $.staff.switchShare(2,keyid,this);
                });

                //删除共享
                $('.js_delete').on('click',function(){

                    var keyid = $(this).attr('data-key');
                    $.ajax({
                        url:'/Company/Staff/deleteCustomRules',
                        type:'post',
                        dataType:'json',
                        data:'id='+keyid,
                        success:function(res){
                            //成功
                            if(res==0){
                                _this.refreshPage();
                            }else if(res==200019){
                                $.global_msg.init({gType:'alert',time:3,icon:0,msg:'组内有成员，不能删除'});
                            }else{
                                $.global_msg.init({gType:'alert',time:3,icon:0,msg:'删除失败'});
                            }

                        },error:function(res){
                            //失败
                            $.global_msg.init({gType:'alert',time:3,icon:0,msg:'操作失败'});
                        }
                    });
                });

            },
            /*共享开关*/
            switchShare:function(_type,_id,_dom){
                $.ajax({
                    url:'/Company/Staff/switchButton',
                    type:'post',
                    dataType:'json',
                    data:'type='+_type+'&id='+_id,
                    success:function(res){
                        //成功
                        if(res.status==0){
                            $(_dom).removeClass('css_close');
                            $(_dom).addClass('css_open');
                            $(_dom).siblings().addClass('css_close');
                            $(_dom).siblings().removeClass('css_open');
                        }else{
                            $.global_msg.init({gType:'alert',time:3,icon:0,msg:'操作失败'});
                        }

                    },error:function(res){
                        //失败
                        $.global_msg.init({gType:'alert',time:3,icon:0,msg:'操作失败'});
                    }
                });
            },
            /*消费规则*/
            consumerRulesJs:function(){
                //删除消费规则
                $('.js_delete').on('click',function(){
                    var oDel = $(this);
                    $.global_msg.init({gType:'confirm',icon:2,msg:'确定删除此规则吗？',btns:true,close:true,
                        title:false,btn1:'取消',btn2:'确定' ,noFn:function(){
                            var id = oDel.attr('data-id');
                            $.post(delRuleUrl,{id:id},function(re){
                                if(re.status===0){
                                    $.global_msg.init({gType:'alert',time:1,icon:1,msg:re.msg,endFn:function(){
                                            window.location.reload();
                                        }});
                                }else{
                                    $.global_msg.init({gType:'alert',time:3,icon:0,msg:re.msg});
                                    return false;
                                }
                            });

                        }
                    });
                });
            },

            //新增消费规则
            addConsumerRule:function(){
                var _this = this;
                var arrName = ['time','num','money','price'];
                var arrNameLang = ['时间周期','数量','金额','单价'];

                //保存提交
                $('.js_btn_sub').on('click',function(){
                    //检验标题
                    var title = $('input[name=title]').val();
                    if(!title){
                        $.global_msg.init({gType:'alert',time:3,icon:0,msg:'请填写标题'});
                        return false;
                    }
                    //循环判断radio的选择情况
                    var isBreak = false;
                    for (var i = 0; i < arrName.length; i++) {
                        var b = false;
                        $('.js_'+arrName[i]+' input[type=radio]').each(function(){
                            if($(this).is(':checked')){
                                b = true;
                                return false;
                            }
                        });
                        if(!b){
                            $.global_msg.init({gType:'alert',time:3,icon:0,msg:'请选择'+arrNameLang[i]});
                            isBreak = true;
                            break;
                        }
                        if(i>0){
                            if($('.js_'+arrName[i]+' input[type=radio]:eq(1)').is(':checked')&&!$('.js_'+arrName[i]+' input[type=text]').val()){
                                $.global_msg.init({gType:'alert',time:3,icon:0,msg:'请填写限制'+arrNameLang[i]});
                                isBreak = true;
                                break;
                            }
                        }
                    };
                    if(isBreak){
                        return false;
                    }
                    var id = $('input[name=id]').val();
                    var timecycle = _this._getRadioValue($('input[name=timecycle]'));
                    var numblimit = _this._getRadioValue($('input[name=numblimit]'));

                    var num = parseInt($('input[name=num]').val());
                    var moneylimit = _this._getRadioValue($('input[name=moneylimit]'));
                    var money = parseInt($('input[name=money]').val());
                    var unitpricelimit = _this._getRadioValue($('input[name=unitpricelimit]'));
                    var price = parseInt($('input[name=price]').val());
                    if((numblimit>0)&&((num<=0)||(!num))){
                        $.global_msg.init({gType:'alert',time:3,icon:0,msg:'数量应大于0'});
                        return false;
                    }
                    if((moneylimit>0)&&((money<=0)||(!money))){
                        $.global_msg.init({gType:'alert',time:3,icon:0,msg:'金额应大于0'});
                        return false;
                    }
                    if(unitpricelimit>0){
                        if((price<=0)||(!price)){
                            $.global_msg.init({gType:'alert',time:3,icon:0,msg:'单价应大于0'});
                            return false;
                        }
                        if(price>2000){
                            $.global_msg.init({gType:'alert',time:3,icon:0,msg:'单价不能大于2000'});
                            return false;
                        }
                    }
                    $.post(addPostUrl,{id:id,title:title,cycle:timecycle,numblimit:numblimit,num:num,moneylimit:moneylimit,money:money,unitpricelimit:unitpricelimit,price:price},function(re){
                        if(re.status===0){
                            $.global_msg.init({gType:'alert',time:1,icon:1,msg:re.msg,endFn:function(){
                                    window.location.href = listUrl;
                                }});
                        }else{
                            $.global_msg.init({gType:'alert',time:3,icon:0,msg:re.msg});
                            return false;
                        }
                    });
                });

                //取消
                $('.js_btn_can').on('click',function(){
                    window.history.back(-1);
                });

                //点击不限，清空后面数值
                $('.js_radio_unlimit').on('click',function(){
                    $(this).next().next().find('input').val('');
                });

                //输入数值，自动改为不限
                $('.num_span .pice').on('blur input focus',function(){
                    var val = $(this).val();
                    if(val){
                        $(this).parent().prev().find('input[type=radio]').prop('checked','checked');
                    }
                })

            },
            /*自定义共享规则*/
            shareRule:function(){
                //点击添加员工
                _this = this;
                $('#js_add_user').on('click',function(){
                    _this.setLayer('user');
                });
                //确认添加员工
                $('#div_layer_user').on('click','.btn-sub',function(){
                    //$('#js_user_list').html('');
                    //获取已确认选择的员工id
                    var idselected = [];
                    $('#js_user_list .js_get_list').each(function(i,doms){
                        idselected[i] = $(doms).attr('data_id');
                    });
                    //
                    $('.act').each(function(){
                        var obj = {};
                        obj.id = $(this).attr('data_val');
                        obj.name = $(this).find('.js_user_name').text();
                        obj.deptid = $(this).attr('data-departid');
                        if($.inArray(obj.id,idselected) < 0){
                            //判断，没确认选择的员工，则加入确认列表
                            $('#js_user_list').append('<div class="per_box js_get_list" data_id="'+obj.id+'" data-btn="2" data-departid="'+obj.deptid+'"><span class="close_staff close_x js_close">X</span><div class="per_top">'+obj.name+'</div><div class="per_bottom"><span class="open_span js_open_btn">开</span><span class="close_span js_close_btn">关</span></div></div>');
                        }

                    });
                    
                    //员工id记录 刷新
                    _this._selectedMember();

                    layer.close(_this.layer_user);
                    _this.noSelect();
                });
                //部门员工显示隐藏
                $('#js_add').on('click','.span_tab',function(){
                    $(this).toggleClass('arrow_up'); // 折叠标识箭头切换方向
                    $(this).parents('.div_department_title').next().toggle();
                    var gethistory = $(this).attr('data-get');

                    if(gethistory!=1){
                        var gid = $(this).parents('.div_department_title').find('.js_all_check').attr('dept-id');
                        //获取部门下的员工列表
                        _this.getEmpList(gid,$(this).parent().siblings());
                        $(this).attr('data-get',1);
                    }
                });

                //员工选择取消-弹框
                $('#div_layer_user').on('click','.user_block',function(){
                    $(this).toggleClass('act');
                    //取消全选
                    if(!$(this).hasClass('act')){
                        var did = $(this).attr('data-departid');
                        $('#div_layer_user .js_all_check[dept-id='+did+']').attr("checked", false);
                    }
                });

                //员工全选-弹框
                $('#div_layer_user').on('click','.js_all_check',function(){
                    var oDiv = $(this).parents('.div_department_title').next().find('.user_block');
                    if($(this).is(':checked')){
                        oDiv.addClass('act');
                    }else{
                        oDiv.removeClass('act');
                    }
                });
                //关闭弹框
                $('#div_layer_user').on('click','.js_close_layer',function(){
                    layer.close(_this.layer_user);
                    _this.noSelect();
                });

                //取消已选择的员工-添加自定义共享页面
                $('#js_user_list').on('click','.per_box .close_x',function(){

                    var data_id = $(this).parents('.per_box').attr('data_id');
                    var dept_id = $(this).parents('.per_box').attr('data-departid');
                    var btn_status = $(this).parents('.per_box').attr('data-btn');
                    $('.layer_content .div_department[data-depid='+dept_id+'] .div_department_content .user_block[data_val='+data_id+'][data-departid='+dept_id+']').removeClass('act');
                    $(this).parents('.per_box').remove();
                    //员工id记录 刷新
                    _this._selectedMember();

                    //全选按钮取消
                    $('#div_layer_user .js_all_check[dept-id='+dept_id+']').attr("checked", false);
                });

                //共享-开关
                $('#js_user_list').on('click','.per_box .js_open_btn',function(){
                    //开
                    $(this).parents('.per_box').attr('data-btn',1);
                    $(this).addClass('close_span');
                    $(this).removeClass('open_span');
                    $(this).siblings().addClass('open_span');
                    $(this).siblings().removeClass('close_span');
                    //员工id记录 刷新
                    _this._selectedMember();
                });
                $('#js_user_list').on('click','.per_box .js_close_btn',function(){
                    //关
                    $(this).parents('.per_box').attr('data-btn',2);
                    $(this).addClass('close_span');
                    $(this).removeClass('open_span');
                    $(this).siblings().addClass('open_span');
                    $(this).siblings().removeClass('close_span');
                    //员工id记录 刷新
                    _this._selectedMember();
                });

                $('form').on('click','.js_submitform',function(){
                    var gname = $('form input[name=groupname]').val();
                    var gid = $('form input[name=groupid]').val();
                    var members = $('form input[name=members]').val();

                    var subdata = '';
                    if(gname != ''){
                        subdata += 'groupname='+gname;
                        $('form input[name=groupname]').css('border-color','');
                    }else{
                        $('form input[name=groupname]').css('border-color','red');

                        $.global_msg.init({gType:'alert',time:3,icon:0,msg:'请填写组名称'});
                        return false;
                    }
                    if(gid != undefined){
                        subdata += '&groupid='+gid;
                    }
                    if(members != undefined){
                        subdata += '&members='+members;
                    }

                    $.ajax({
                        url:'/Company/Staff/saveCustomRules',
                        type:'post',
                        dataType:'json',
                        data:subdata,
                        success:function(res){
                            //成功
                            if(res==0){
                                $.global_msg.init({gType:'alert',icon:1,time:3,msg:'保存成功，3秒钟后跳转到客户共享页面',
                                    title:false ,endFn:function(){
                                        window.location.href=sharelistUrl;
                                    }
                                });
                            }else if(res==2){
                                $.global_msg.init({gType:'alert',time:3,icon:0,msg:'您输入的分组名称已存在，请重新输入'});
                            }else{
                                $.global_msg.init({gType:'alert',time:3,icon:0,msg:'保存失败'});
                            }

                        },error:function(res){
                            //失败
                            $.global_msg.init({gType:'alert',time:3,icon:0,msg:'操作失败'});
                        }
                    });



                });



            },
            //已选择的员工
            _selectedMember:function(){
                var memberstr = '';
                $('#js_user_list .js_get_list').each(function(i,doms){
                    memberstr += $(doms).attr('data_id')+'-'+$(doms).attr('data-btn')+',';
                });
                $('#js_input_members').val(memberstr);
            },
            //全部取消（全选按钮+员工）- 弹框
            noSelect:function(){
                $('.layer_content .div_department .user_block').removeClass('act');
                $('.layer_content .div_department .js_all_check').attr("checked",false);
            },
            setLayer:function(){
                _this = this;
                var oDiv = $('#div_layer_user');
                var url = eval('getuserUrl');
                var obj = _this.layer_user;
                if(!obj){
                    $.ajax({
                        'type':'post',
                        'async':false,
                        'dataType':'json',
                        'url':url,
                        'success':function(re){
                            if(re.status===0){
                                oDiv.html(re.html);
                            }
                        }
                    });

                };

                oScroll = oDiv.find('.js_scroll_height');
                var dHeight = oScroll.height();
                if(dHeight>450){
                    oScroll.mCustomScrollbar({
                        theme:"dark", //主题颜色
                        set_height:450,
                        autoHideScrollbar: false, //是否自动隐藏滚动条
                        scrollInertia :0,//滚动延迟
                        horizontalScroll : false//水平滚动条
                    });
                };
                _this.layer_user= $.layer({
                    type: 1,
                    title: false,
                    area: ['600px','600px'],
                    offset: ['', ''],
                    fix:false,
                    bgcolor: '#fff',
                    border: [0, 0.3, '#ccc'],
                    shade: [0.2, '#000'],
                    closeBtn:false,
                    page:{dom:oDiv},
                    shadeClose:true
                });

            },
            //点击展开按钮获取该部门下的员工列表
            getEmpList:function(_gid,_dom){
                $.ajax({
                    'type':'post',
                    'async':false,
                    'dataType':'json',
                    'url':getEmpUrl,
                    'data':'gid='+_gid,
                    'success':function(res){
                        _dom.html(res);
                    }
                });
            },
            empSearch:function(){
                $('#div_layer_user').on('click','.js_search_btn',function(){
                    $('#div_layer_user .div_search_content .js_search_emp_name').val();
                    var empname = $('#div_layer_user .div_search_content .js_search_emp_name').val();
                    var gid = $('#div_layer_user .div_search_content .js_search_depart_select').find("option:selected").val();

                    $.ajax({
                        'type':'post',
                        'async':false,
                        'dataType':'json',
                        'url':getEmpUrl,
                        'data':'gid='+gid+'&empname='+empname,
                        'success':function(res){
                            if(res){
                                //对应部门修改员工列表
                                $('#div_layer_user .div_department[data-depid='+gid+'] .div_department_content').html(res);
                                $('#div_layer_user .div_department[data-depid='+gid+'] .div_department_content').show();

                            }
                        }
                    });

                });
            },

            //获取jq对象的value值
            _getRadioValue:function(oDom){
                var b = false;
                oDom.each(function(){
                    if($(this).is(':checked')){
                        b = $(this).val();
                        return false;
                    }
                });
                return b;
            },



        }
    });
})(jQuery);