/**
 *扫描仪管理js
 */
(function($) {
    $.extend({
        scannerManager: {
            layer_div:null,
            layer_div2:null,
            sle_url:'',
            sle_obj:{},
            sle_id:'',
            layer_type:0,
            default_passwd:'',//用于保存默认密码
            current_passwd:'',
            init: function() {
                this.sle_url = url_getpartner;
                /*绑定事件*/
                //判断导入操作
                if(js_is_import===0){
                    //有导入，且成功
                    $.global_msg.init({gType:'alert',icon:1,time:3,msg:js_import_msg});
                }else if(js_is_import==1){
                    //有导入，且有失败的
                    $.global_msg.init({gType:'warning',icon:2,time:3,msg:js_import_msg});
                }else if(js_is_import=='error'){
                    //有导入，且有错误
                    $.global_msg.init({gType:'warning',icon:2,time:3,msg:js_import_msg});
                }

                //点击区域外关闭此下拉框
                $(document).on('click',function(e){

                    if($(e.target).parents('.js_select_ul_list').length>0){
                        var currUl = $(e.target).parents('.js_select_ul_list').find('ul');
                        $('.js_select_ul_list>ul').not(currUl).hide()
                    }else{
                        $('.js_select_ul_list>ul').hide();
                    }


                });

                //绑定扫描仪管理js
                this.sannerManager();
                this.add_edit_scan();

                //导入扫描仪
                $('input[name=uploadfile]').on('change', function (){
                    //判断格式
                    $.scannerManager.fileType($(this).val(), ['xlsx']);

                });
            },
            //判断文件格式xlsx,正确则提交表单
            fileType:function(filename,typeArr){
                var ext, idx;
                if (filename == '') {
                    $.global_msg.init({gType:'warning',icon:2,time:3,msg:js_scanner_import_select});
                    return false;
                } else {
                    idx = filename.lastIndexOf(".");
                    if (idx != -1) {
                        ext = filename.substr(idx + 1).toLowerCase();
                        if ($.inArray(ext,typeArr) <= -1) {
                            $.global_msg.init({gType:'warning',icon:2,time:3,msg:js_scanner_import_format_error});
                            return false;
                        }
                    } else {
                        $.global_msg.init({gType:'warning',icon:2,time:3,msg:js_scanner_import_format_error});
                        return false;
                    }
                    //提交
                    $('#uploadfileFrm').submit();
                    return false;
                }
            },
            sannerManager:function (){
                //勾选按钮
                this.selectOperate();
                //删除
                this.deleteScanner();

                //状态选择下拉框,状态
                $('#js_mod_select,#js_seltitle').on('click',function(){
                    $('#js_selcontent').toggle();
                });
                //状态选择下拉框，类型
                $('#js_mod_select_type,#js_seltitle_type').on('click',function(){
                    $('#js_selcontent_type').toggle();
                });
                //状态选中
                $('#js_selcontent li').on('click',function(){
                    var typeval = $(this).html();
                    var typekey = $(this).attr('val');
                    $('#js_mod_select input').val(typeval);
                    $('#js_statusvalue').val(typekey);
                    $(this).parent().hide();
                });
                //类型选中
                $('#js_selcontent_type li').on('click',function(){
                    var typeval = $(this).html();
                    var typekey = $(this).attr('val');
                    $('#js_mod_select_type input').val(typeval);
                    $('#js_typesvalue').val(typekey);
                    $(this).parent().hide();
                });

                //回收
                //单个回收
                $('.js_simp_recover').on('click',function(){
                    //询问是否回收
                    var _this = $(this);
                    var datastatus = _this.parent().attr('data-status');
                    if( datastatus!=2 ){
                        $.global_msg.init({gType:'warning',icon:2,time:3,msg:js_scanner_recover_cannot});
                        return false;
                    }
                    $.global_msg.init({gType:'confirm',icon:2,msg:js_scanner_confirm_recover_l+'1'+js_scanner_confirm_recover_r ,btns:true,close:true,
                        title:false,btn1:js_scanner_btn_cannel,btn2:js_scanner_btn_ok ,noFn:function(){

                            var ids = _this.parent('span').attr('data-id');
                            $.scannerManager.recoverScanner(ids);

                        }
                    });


                });
                //批量回收
                $('#js_recoverScanner').on('click',function(){
                    //获取id
                    var idstr = '';
                    var scannerNum = 0;
                    var datastatus = 0;
                    $('.scannersection_list_c .js_select').each(function(){
                        if ( $(this).hasClass('active') ){
                            if( $(this).attr('data-status')!=2 ){
                                datastatus = 1;
                            }
                            idstr += $(this).attr('val')+',';
                            scannerNum+=1;
                        }
                    });

                    //判断是否可以回收
                    if(datastatus == 1){
                        $.global_msg.init({gType:'warning',icon:2,width:560,msg:js_scanner_recover_cannot_two});
                        return false;
                    }

                    if(idstr == ''){
                        $.global_msg.init({gType:'warning',icon:2,time:3,msg:js_scanner_confirm_recover_check});
                        return false;
                    }
                    //询问是否回收
                    $.global_msg.init({gType:'confirm',icon:2,msg:js_scanner_confirm_recover_l+scannerNum+js_scanner_confirm_recover_r  ,btns:true,close:true,
                        title:false,btn1:js_scanner_btn_cannel ,btn2:js_scanner_btn_ok ,noFn:function(){
                            $.scannerManager.recoverScanner(idstr,'scannersection_list_c');

                        }
                    });

                });


                
            },
            //去除空格
            trimStrings:function (str){
                return str.replace(/(^\s*)|(\s*$)/g,"");
            },
            //回收扫描仪
            recoverScanner:function(_id){

                $.ajax({
                    url:'/Appadmin/ScannerManager/recover',
                    type:'post',
                    dataType:'json',
                    data:'id='+_id,
                    success:function(res){
                        //回收成功
                        if(res.status==0){
                            $.global_msg.init({gType:'warning',icon:1,time:3,msg:js_scanner_recover_success,endFn:function(){
                                window.location.reload();
                            }});

                        }else{
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_scanner_recover_faild});
                        }

                    },error:function(res){
                        //删除失败
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_scanner_recover_faild});

                    }
                });
            },
            //删除扫描仪bind
            deleteScanner:function(){

                //单个删除
                $('.js_simp_del').on('click',function(){
                    //询问是否删除
                    var _this = $(this);
                    var datastatus = _this.parent().attr('data-status');
                    if( datastatus==2 ){
                        $.global_msg.init({gType:'warning',icon:2,time:3,msg:js_scanner_del_cannot});
                        return false;
                    }
                    $.global_msg.init({gType:'confirm',icon:2,msg:js_scanner_confirm_del ,btns:true,close:true,
                        title:false,btn1:js_scanner_btn_cannel ,btn2:js_scanner_btn_ok ,noFn:function(){

                            var ids = _this.parent('span').attr('data-id');
                            $.scannerManager.delScanner(ids,_this.parents('.scannersection_list_c'));

                        }
                    });


                });
                //批量删除按钮
                $('#js_del').on('click',function(){
                    //获取id
                    var idstr = '';
                    var datastatus = 0;
                    $('.js_select').each(function(){
                        if ( $(this).hasClass('active') ){
                            if( $(this).attr('data-status') == 2 ){
                                datastatus = 1;
                            }
                            idstr += $(this).attr('val')+',';
                        }
                    });

                    //判断是否可以删除
                    if(datastatus == 1){
                        $.global_msg.init({gType:'warning',icon:2,width:560,msg:js_scanner_del_cannot_two});
                        return false;
                    }
                    if(idstr == ''){
                        $.global_msg.init({gType:'warning',icon:2,time:3,msg:js_scanner_confirm_del_check});
                        return false;
                    }
                    //询问是否删除
                    $.global_msg.init({gType:'confirm',icon:2,msg:js_scanner_confirm_del ,btns:true,close:true,
                        title:false,btn1:js_scanner_btn_cannel ,btn2:js_scanner_btn_ok ,noFn:function(){
                            $.scannerManager.delScanner(idstr,'scannersection_list_c');

                        }
                    });

                });
            },

            /*删除扫描仪*/
            delScanner:function(_id,_dom){
                $.ajax({
                    url:'/Appadmin/ScannerManager/deleteScanner',
                    type:'post',
                    dataType:'json',
                    data:'id='+_id,
                    success:function(res){
                        //删除成功
                        if(res.status==0){

                            if( typeof(_dom)=='string'){
                                $('.active').parents('.'+_dom).remove();
                            }else{
                                _dom.remove();
                            }
                            //判断当前页面是否还有列表
                            var listnumb = $('.content_c .js_select').length;

                            if(listnumb<1){
                                //翻页到前一页
                                var nowPage = parseInt($('.page').find('.current').html());
                                var totalPage = parseInt($('.page').find('.jumppage').attr('totalpage'));
                                $.global_msg.init({gType:'alert',icon:1,time:3,msg:js_scanner_del_success,endFn:function(){
                                    if(totalPage>nowPage){
                                        window.location.reload();
                                    }else{
                                        window.location.href = delnewsurl + "/p/"+(nowPage-1);
                                    }

                                }});

                            }else{
                                //刷新页面
                                $.global_msg.init({gType:'alert',icon:1,time:3,msg:js_scanner_del_success,endFn:function(){
                                    window.location.reload();
                                }});
                            }

                        }else{
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_scanner_del_faild});
                        }

                    },error:function(res){
                        //删除失败
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_scanner_del_faild});

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
			
            //新增和编辑扫描仪弹框
            get_layer:function(obj,width,height){
                var _this = this;
                //通过AJAX获取弹框HTML
                $.post(url_add_edit,obj,function(res){
                    if(res.status==0){
                        _this.layer_html(1,res.tpl,width,height);
                        _this.default_passwd = $('#add_scanner_dom input[name=default_passwd]').val();
                        _this.current_passwd = $('#add_scanner_dom input[name=password]').val();
                    }
                });
            },

            //根据弹框种类，HTML，宽，高进行处理
            layer_html:function(type,tpl,width,height){
                var _this = this;
                type=(type==1)?'':'2';
                //this.layer_type的作用是保存弹框种类，防止双击重复弹框
                if(_this.layer_type===type){
                    return false;
                }
                _this.layer_type = type;
                var dom = $('#layer_div'+type);
                dom.html('<div class="layer_in" style="display:none;"></div>');
                dom.find('.layer_in').html(tpl);
                oDiv = {dom:dom.find('.layer_in')};
                //设置弹框垂直居中
                var offsetHeight = parseInt(($(window).height()-height)/2)+'px';
                //将弹框保存在layer_div1,layer_div2中，方便关闭弹框
                this['layer_div'+type] = $.layer({
                        type: 1,
                        title: false,
                        area: [width+'px',height+'px'],
                        offset: [offsetHeight, ''],
                        bgcolor: '#ccc',
                        border: [0, 0.3, '#ccc'], 
                        shade: [0.2, '#000'], 
                        closeBtn:false,
                        page: oDiv,
                        shadeClose:true,
                        //关闭时layer_type置0
                        end:function(){
                            _this.layer_type=0;
                        },
                    });
            },

            add_edit_scan:function(){
                var _this = this;
                //新增扫描仪
                $('#js_addScanner').on('click',function(){
                    _this.get_layer({},440,400);
                });

                //编辑扫描仪弹框
                $('.js_update_scanner').on('click',function(){
                    var id = $(this).parents('.span_span8').attr('data-id');
                    _this.get_layer({id:id},440,464);
                });

                //关闭扫描仪弹框
                $('#layer_div').on('click','.js_logoutcancel,.js_add_cancel,.js_add_partner_cancel',function(){
                    layer.close(_this.layer_div);
                });

                
                //关闭企业弹框
                $('#layer_div2').on('click','.js_add_list_cancel,.js_add_list_sub',function(){
                    layer.close(_this.layer_div2);
                });
                //关闭扫描仪状态弹框
                $('#layer_div').on('click','.role_select',function(){
                    $(this).find('ul').toggle();
                });

                //选择扫描仪状态和扫描仪类型
                $('#layer_div').on('click','.role_select li',function(){
                    var oSpan = $(this).parents('.role_select').find('.js_scanner_status');
                    var val = $(this).attr('val');
                    oSpan.attr('val',val);
                    oSpan.text($(this).text());
                    if($(this).parents('.role_select').find('#js_scanner_type').length==1){
                        if(val==2){
                            $('#add_scanner_dom input[name=password]').val(_this.default_passwd).attr('readonly',true);
                        }else if(val==1){
                            $('#add_scanner_dom input[name=password]').val(_this.current_passwd).attr('readonly',false);
                        }
                    }
                });

                //提交
                $('#layer_div').on('click','.js_add_sub',function(){
                    var is_edit = $('#layer_div .is_edit').attr('val');
                    var scannerid = $('input[name=scanner_id]').val();
                    //var mac = $('input[name=mac]').val();
                    var type = $('#js_scanner_type').attr('val');
                    var passwd = $('input[name=password]').val();
                    var model = $('input[name=s_model]').val();
                    var bool = false;
                    var obj = {};
                    //判断是新增还是编辑，bool表示是否满足必填项
                    if(is_edit){
                        var status = $('#js_scanner_status').attr('val');
                        var id = $('.Administrator_pop_c input[name=id]').val();
                        bool = scannerid&&type&&passwd&&status;
                        obj = {scannerid:scannerid,type:type,passwd:passwd,model:model,status:status,id:id};
                    }else{
                        bool = scannerid&&type&&passwd;
                        obj = {scannerid:scannerid,type:type,passwd:passwd,model:model};
                    }
                    if(bool){
                        $.post(url_add_edit_post,obj,function(res){
                            if(res.status==0){
                                //成功后，先关闭弹框，再提示成功
                                layer.close(_this.layer_div);
                                $.global_msg.init({gType:'alert',icon:1,time:1,msg:tip_save_success,endFn:function(){
                                    window.location.reload();
                                }});
                            }else{
                                $.global_msg.init({gType:'alert',icon:2,time:3,msg:res.msg});
                                return false;
                            }
                        })
                    }else{
                        $.global_msg.init({gType:'alert',icon:2,time:3,msg:tip_has_blank});
                        return false;
                    }
                });

                //外放

                $('#js_outsideScanner').on('click',function(){
                    var arr = [];
                    var statusArr = [];
                    //循环选中的扫描仪，将扫描仪ID保存在arr里。如果有扫描仪状态不为空闲，保存在statusArr中
                    $('.scannersection_list_c .js_select').each(function(){
                        if($(this).hasClass('active')){
                            arr.push($(this).attr('val'));
                            if($(this).parents('.scannersection_list_c').find('.span_span11 i').attr('data-status')!=1){
                                statusArr.push($(this).parents('.scannersection_list_c').find('.span_span1').text());
                            }
                        }

                    });
                    //没有选中扫描仪时，提示
                    if(!arr.length){
                        $.global_msg.init({gType:'alert',icon:2,time:3,msg:tip_sel_scanner});
                        return false;
                    }
                    //当有选中的扫描仪状态不为空闲时，提示
                    if(statusArr.length){
                        $.global_msg.init({gType:'alert',icon:2,time:3,width:560,msg:tip_cannt_setoutside});
                        return false;
                    }
                    //将扫描仪ID拼成字符串提交
                    var str = arr.join(',');
                    $.post(url_setoutside,{str:str},function(res){
                        _this.layer_html(1,res.tpl,440,320);
                    });
                });
    
                //外放单个
                $('.js_simp_outside').on('click',function(){
                    var str = $(this).parents('.scannersection_list_c').find('.js_select').attr('val');
                    var status = $(this).parents('.scannersection_list_c').find('.span_span11 i').attr('data-status');
                    if(status!=1){
                        $.global_msg.init({gType:'alert',icon:2,time:3,msg:tip_cannt_setoutside});
                        return false;
                    }
                    $.post(url_setoutside,{str:str},function(res){
                        _this.layer_html(1,res.tpl,440,320);
                    });
                })

                //点击企业弹出企业选择框
//                $('#layer_div').on('click','#js_partner',function(){
//
//                    $.get(_this.sle_url,this.sle_obj,function(res){
//                        _this.layer_html(2,res.tpl,720,530);
//                        _this.setActive();
//                    })
//                    return false;
//                });

                 //企业按注册日期排序
                $('#layer_div2').on('click','#js_reg_date',function(){
                    var sort = $(this).hasClass('list_sort_asc')?'desc':'asc';
                    var obj = $.extend(_this.sle_obj,{sort:sort});
                    _this.getPartner(_this.sle_url,obj);
                });

                //点击翻页
                $('#layer_div2').on('click','a[href]',function(e){
                    var href=$(this).attr('href');
                    //阻止a标签跳转，使用ajax
                    _this.getPartner(href,{});
                    return false;
                });

                //企业ID、种类下拉切换
                $('#layer_div2').on('click','.waif_name',function(){
                    $('#js_sel_type_content').toggle();
                });

                //企业ID、种类下拉选择
                $('#layer_div2').on('click','#js_sel_type_content li',function(){
                    var val = $(this).attr('val');
                    var text = $(this).text();
                    $('#js_type_value').attr('val',val).attr('title',text).val(text);
                });
                

                //搜索       
                $('#layer_div2').on('click','.butinput',function(){
                    var sle_type = $('#js_type_value').attr('val');
                    var sle_key = $('#layer_div2 .textinput').val();
                    _this.getPartner(url_getpartner,{sle_type:sle_type,sle_key:sle_key});
                });

                //勾选选择企业
                $('#layer_div2').on('click','.js_select_partner',function(){
                    //当前未勾选时
                    if(!$(this).hasClass('active')){
                        $('#layer_div2 .js_select_partner').removeClass('active');
                        $(this).addClass('active');
                        var partner = $(this).parents('.waiflist_list_c').find('.span_span2').attr('title');
                        //this.sle_id用来保存选中的合作商的ID
                        _this.sle_id = $(this).attr('val');
                        $('#js_partner').val(partner);
                    }else{//已勾选的取消
                        $(this).removeClass('active');
                        _this.sle_id = '';
                        $('#js_partner').val('');
                    }
                });

                //双击选择企业
                $('#layer_div2').on('dblclick','.waiflist_list_c',function(){
                    $('#layer_div2 .js_select_partner').removeClass('active');
                    $(this).find('.js_select_partner').addClass('active');
                    var partner = $(this).find('.span_span2').attr('title');
                    _this.sle_id = $(this).find('.js_select_partner').attr('val');
                    $('#js_partner').val(partner);
                    layer.close(_this.layer_div2);
                });

                //合作商列表输入页数跳转
                $('#layer_div2').on('click','form input[type=submit]',function(){
                    var p = $(this).prev().val();
                    if(p){
                        var url = $(this).parents('form').attr('action');
                        _this.getPartner(url,{p:p});
                    }
                    return false;
                });

                //外放提交
                $('#layer_div').on('click','.js_add_partner_sub',function(){
                    var addr = $('#js_address').val();
                    var id_str = $('#layer_div input[name=id_str]').val();
                    var bizname = $('#js_partner').val();
                    //判断是否有选择扫描仪
                    if(!id_str){
                        $.global_msg.init({gType:'alert',icon:2,time:3,msg:tip_sel_scanner});
                        return false;
                    }
                    //判断是否有选择合作商
//                    if(!_this.sle_id){
//                        $.global_msg.init({gType:'alert',icon:2,time:3,msg:tip_sel_partner});
//                        return false;
//                    }
                    //是否填写摆放地址
                    if(!addr){
                        $.global_msg.init({gType:'alert',icon:2,time:3,msg:tip_input_addr});
                        return false;
                    }
                    $.post(url_setoutside_post,{
                    	str:id_str,
                    	addr:addr,
                    	//id:_this.sle_id,
                    	bizname:bizname
                    	},function(res){
                        if(res.status==0){
                            layer.close(_this.layer_div);
                            $.global_msg.init({gType:'alert',icon:1,time:1,msg:res.msg,endFn:function(){
                                window.location.reload();
                            }});
                        }else{
                            $.global_msg.init({gType:'alert',icon:2,time:3,msg:res.msg});
                            return false;
                        }
                    });
                });
            },

            //get方法获取企业列表
            getPartner:function(url,obj){
                var _this = this;
                $.get(url,obj,function(res){
                    _this.sle_url = url;
                    _this.sle_obj = obj;
                    $('#layer_div2 .layer_in').html(res.tpl);
                    _this.setActive();
                });
            },

            //循环企业列表，如果企业ID与保存的ID相同，勾选上此企业
            setActive:function(){
                var _this = this;
                $('#layer_div2 .js_select_partner').each(function(){
                    if($(this).attr('val')==_this.sle_id){
                        $(this).addClass('active');
                    }
                });
            }
        },
        scannerLocation:{
            init:function(){
                //点击区域外关闭此下拉框
                $(document).on('click',function(e){
                    if($(e.target).parents('.js_select_ul_list').length>0){
                        var currUl = $(e.target).parents('.js_select_ul_list').find('ul');
                        $('.js_select_ul_list>ul').not(currUl).hide()
                    }else{
                        $('.js_select_ul_list>ul').hide();
                    }
                });
                //省市下拉框,状态
                $('.js_select_content .js_select_list_pro').on('click','input',function(){
                    $('.js_select_content .js_select_list_pro ul').toggle();
                });
                $('.js_select_content .js_select_list_city').on('click','input',function(){
                    $('.js_select_content .js_select_list_city ul').toggle();
                });

                //点击省，获取市，选择市
                $('.js_select_content .js_select_list_pro ul').on('click','li',function(){
                    var proid = $(this).attr('val');
                    var proname = $(this).html();
                    $.ajax({
                        url:js_getCityUrl,
                        type:'post',
                        dataType:'json',
                        data:'provincecode='+proid,
                        success:function(res){
                            $('.js_select_content .js_select_list_city ul').html(res);
                            $('.js_select_content .js_select_list_pro ul').toggle();
                            $('.js_select_content .js_select_list_pro input').val(proname);
                            $('.js_select_content .js_select_list_city input').val('');
                        },error:function(res){
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:'操作失败'});
                        }
                    });
                });

                //点击市，刷新地图
                $('.js_select_content .js_select_list_city ul').on('click','li',function(){
                    //var proid = $(this).attr('data-proid');
                    var proname = $('.js_select_content .js_select_list_pro input').val();
                    //var cityid = $(this).attr('val');
                    var cityname = $(this).html();
                    $('.js_select_content .js_select_list_city input').val(cityname);
                    $('.js_select_content .js_select_list_city ul').toggle();
                    $.ajax({
                        url:js_getMapUrl,
                        type:'post',
                        dataType:'json',
                        data:'proname='+proname+'&cityname='+cityname,
                        success:function(res){
                            loadJScript(res);
                        },error:function(res){
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:'操作失败'});
                        }
                    });
                });
                //重启扫描仪
                $('.js_scanner_status').on('click','.js_btn_restart',function(){
                    var this_btn = this;
                    var scannerid = $(this).attr('scannerid');
                    if(scannerid){
                        $.ajax({
                            url:js_restartUrl,
                            type:'post',
                            dataType:'json',
                            data:'scannerid='+scannerid,
                            success:function(status){
                                if(status==0){
                                    $(this_btn).html('重启中...');
                                    $(this_btn).removeClass('js_btn_restart');
                                }else{
                                    $.global_msg.init({gType:'warning',icon:0,time:3,msg:'重启失败'});
                                }
                            },error:function(){
                                $.global_msg.init({gType:'warning',icon:0,time:3,msg:'重启失败'});
                            }
                        })
                    }
                    
                })
            },
            scannerlistcomp:function(){
                //点击区域外关闭此下拉框
                $(document).on('click',function(e){
                    if($(e.target).parents('.js_select_ul_list').length>0){
                        var currUl = $(e.target).parents('.js_select_ul_list').find('ul');
                        $('.js_select_ul_list>ul').not(currUl).hide()
                    }else{
                        $('.js_select_ul_list>ul').hide();
                    }
                });
                //删除
                $('.js_listcontent').on('click','.js_scanner_del',function(){
                    var scannerid = $(this).attr('data-id');
                    $.global_msg.init({gType:'confirm',icon:2,msg:'确定删除扫描仪吗？' ,btns:true,close:true,title:false,btn1:'取消' ,btn2:'确定' ,noFn:function(){
                        $.ajax({
                            url:js_del_url,
                            type:'post',
                            dataType:'json',
                            data:'scannerid='+scannerid,
                            success:function(res){
                                if(res==0){
                                    window.location.href = js_listUrl;
                                }else{
                                    $.global_msg.init({gType:'warning',icon:0,time:3,msg:'删除失败'});
                                }
                            },
                            error:function(){
                                $.global_msg.init({gType:'warning',icon:0,time:3,msg:'删除失败'});
                            }

                        });
                    }});
                })
            },
            scannerAdd:function(){
                $(document).on('click',function(e){
                    if($(e.target).parents('.js_select_ul_list').length>0){
                        var currUl = $(e.target).parents('.js_select_ul_list').find('ul');
                        $('.js_select_ul_list>ul').not(currUl).hide()
                    }else{
                        $('.js_select_ul_list>ul').hide();
                    }
                });
                //省市下拉框,状态
                $('.js_area_select .js_pro_select').on('click','input',function(){
                    $('.js_area_select .js_pro_select ul').toggle();
                });
                $('.js_area_select .js_city_select').on('click','input',function(){
                    $('.js_area_select .js_city_select ul').toggle();
                });
                //点击省，获取市，选择市
                $('.js_area_select .js_pro_select ul').on('click','li',function(){
                    var proid = $(this).attr('val');
                    var proname = $(this).html();
                    $.ajax({
                        url:js_getCityUrl,
                        type:'post',
                        dataType:'json',
                        data:'provincecode='+proid,
                        success:function(res){
                            $('.js_area_select .js_city_select ul').html(res);
                            $('.js_area_select .js_pro_select ul').toggle();
                            $('.js_area_select .js_pro_select input').val(proname);
                            $('.js_area_select .js_city_select input').val('');
                        },error:function(res){
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:'操作失败'});
                        }
                    });
                });
                //点击市
                $('.js_area_select .js_city_select ul').on('click','li',function(){
                    var cityname = $(this).html();
                    $('.js_area_select .js_city_select input').val(cityname);
                    $('.js_area_select .js_city_select ul').toggle();
                });

                //提交
                $('.js_content_form').on('click','#js_submitb_scanner',function(){
                    var id = $('#sid').val();
                    var scannerid = $('.js_content_form input[name=scannerid]').val();
                    var province = $('.js_content_form input[name=province]').val();
                    var city = $('.js_content_form input[name=city]').val();
                    var address = $('.js_content_form input[name=address]').val();
                    var placetype = $('.js_content_form input[name=placetype]').val();
                    var scannerstate = $('.js_content_form input[name=scannerstate]').val();
                    if(!scannerid || scannerid==undefined){
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:'设备SN码不能为空'});
                        return false;
                    }
                    if(!address || address==undefined){
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:'详细地址不能为空'});
                        return false;
                    }

                    var subdata = 'scannerid='+scannerid+'&province='+province+'&city='+city+'&address='+address+'&placetype='+placetype+'&scannerstate='+scannerstate;
                    if(id) subdata +='&id='+id;
                    $.ajax({
                        url:js_subUrl,
                        type:'post',
                        dataType:'json',
                        data:subdata,
                        success:function(res){
                            if(res.status!=0){
                                if(res.status==310003) $.global_msg.init({gType:'warning',icon:0,time:3,msg:'该SN码扫描仪已存在'});

                                if(res.status!=310003) $.global_msg.init({gType:'warning',icon:0,time:3,msg:res.msg});

                            }else{
                                window.location.href = js_listUrl;
                            }

                        },error:function(res){
                            //失败
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:'失败'});

                        }
                    });


                })
            }
        }
    });
})(jQuery);