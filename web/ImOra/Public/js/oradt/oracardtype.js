/**
 *orange卡类型管理js
 */
(function($) {
    $.extend({
        oracardtype: {
            //
            init: function() {

            },
            //新增卡类型页面js
            addjs:function(){
                _this = this;
                _this.ScrollBarfunc('#js_scroll_cardprop');//滚动条 卡属性
                //选择功能
                _this.selectOperateCardAttr('.js_select_all','.js_select','.js_cardbank_content');

                //添加卡属性
                $('.js_add_cardprop').on('click',function(){
                    //显示弹框
                    var clonedom = $('.js_cardprop_upd').clone(true,true);
                    $('.js_updcardprop_box').append(clonedom);
                    $('.js_updcardprop_box').show();
                    clonedom.show();
                    $('.js_masklayer').show();
                    _this.selectPropJs(clonedom);
                    //关闭弹框
                    $('.js_cardprop_upd .js_cancel_btn').on('click',function(){
                        $('.js_updcardprop_box').hide();
                        clonedom.remove();
                        $('.js_masklayer').hide();
                    });
                    //提交
                    clonedom.find('.js_submit_btn').on('click',function(){
                        _this.submitProp(clonedom,1);
                    });

                });

                //卡属性 举例
                /*$('.js_cardprop_name').on('focus',function(){
                    $('.js_cardpropname_example').show();
                });
                $('.js_cardprop_name').on('blur',function(){
                    $('.js_cardpropname_example').hide();
                });
                $('.js_cardpropname_example li').on('mouseover',function(){
                    var nameval = $(this).html();
                    $('.js_cardprop_name').val(nameval);
                });*/

                //修改卡属性
                $('.js_updprop_act').on('click',function(){
                    var updprop = $('#js_scroll_cardprop .js_select:checked');

                    if(updprop.length==0 || updprop.length!=1){
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_msg_select_cardprop});
                        return false;
                    }

                    var proptype = updprop.parents('.js_submit_prop').attr('data-proptype');
                    var propusetype = updprop.parents('.js_submit_prop').attr('data-propusetype');
                    var propname = updprop.parents('.js_submit_prop').attr('data-propname');
                    var propexample = updprop.parents('.js_submit_prop').attr('data-propexample');
                    var propcontact = updprop.parents('.js_submit_prop').attr('data-contact');
                    var prophint = updprop.parents('.js_submit_prop').attr('data-prophint');
                    var propencrypt = updprop.parents('.js_submit_prop').attr('data-encrypt');
                    var propsystem = updprop.parents('.js_submit_prop').attr('data-isdefault');

                    //修改框
                    var clonedom = $('.js_cardprop_upd').clone(true);
                    $('.js_updcardprop_box').append(clonedom);

                    //是否可输入，1可输入，2只展示
                    if(propusetype==2){
                        clonedom.find('.js_prop_encrypt,.js_prop_input input[name=prophint]').remove();
                        clonedom.find('.js_prop_usetype_input').remove();
                        clonedom.find('.js_prop_usetype_show input').prop('checked',true);
                    }else{
                        clonedom.find('.js_prop_usetype_show').remove();
                        clonedom.find('.js_prop_usetype_input input').prop('checked',true);
                    }
                    //类型，1通用，2发卡单位
                    if(proptype==2){
                        clonedom.find('.js_prop_encrypt').remove();
                        clonedom.find('.js_prop_type_common').remove();
                        clonedom.find('.js_prop_type_issuer input').prop('checked',true);
                    }else{
                        clonedom.find('.js_prop_type_issuer').remove();
                        clonedom.find('.js_prop_type_common input').prop('checked',true);
                    }
                    //显示关联属性
                    if(proptype==1 && propusetype==2){
                        clonedom.find('.js_contactprop').show();//关联属性显示
                        if(propcontact!=0){
                            clonedom.find('.js_contactprop input[name=contactprop]').val(propcontact);
                            clonedom.find('.js_contactprop input[name=contactshow]').val(clonedom.find('.js_contactprop ul li[val='+propcontact+']').html());
                        }
                    }

                    if(parseInt(propsystem)==2 || (propusetype==1 && proptype==1 )){
                        clonedom.find('.js_prop_input input[name=propname]').attr('readonly',true);
                        clonedom.find('.js_prop_input input[name=propname]').css('border','0px');
                    }

                    clonedom.find('.js_prop_input input[name=propname]').val(propname);
                    clonedom.find('.js_prop_input textarea[name=propexample]').val(propexample);
                    if(propusetype!=2){
                        clonedom.find('.js_prop_input input[name=prophint]').val(prophint);
                        if(proptype!=2 && propencrypt==1){
                            clonedom.find('.js_prop_encrypt input').prop('checked',true);
                        }
                    }

                    $('.js_updcardprop_box').show();
                    clonedom.show();
                    $('.js_masklayer').show();

                    //提交
                    clonedom.find('.js_submit_btn').on('click',function(){
                        _this.submitProp(clonedom,0,propname);
                    });
                    //关闭弹框
                    $('.js_cardprop_upd .js_cancel_btn').on('click',function(){
                        $('.js_updcardprop_box').hide();
                        clonedom.remove();
                        $('.js_masklayer').hide();
                    });

                });
                //删除卡属性
                $('.js_delprop_act').on('click',function(){
                    var propid = '';
                    var isdel = 0;
                    var isdefault = 0;
                    var isnotallow = 0;
                    $('#js_scroll_cardprop .js_select:checked').each(function(_index,_doms){
                        //判断是否存在通用可输入属性
                        if($(_doms).parents('.js_submit_prop').attr('data-id') && parseInt($(_doms).parents('.js_submit_prop').attr('data-proptype'))==1 && parseInt($(_doms).parents('.js_submit_prop').attr('data-propusetype'))==1){
                            isnotallow = 1;
                        }
                        //判断是否有系统默认项被删除操作。
                        if(parseInt($(_doms).parents('.js_submit_prop').attr('data-isdefault'))==2) isdefault = 1;

                        if($(_doms).parents('.js_submit_prop').attr('data-id')==undefined){
                            //未入库项删除
                            isdel = 1;
                        }else{
                            propid += $(_doms).parents('.js_submit_prop').attr('data-id')+',';
                        }
                    });

                    if(propid=='' && isdel==0){
                        //没有被删除的项
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_msg_select_del_prop});
                        return false;
                    }

                    //存在系统属性，无法删除，提示
                    if(isdefault===1){
                        //没有被删除的项
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:'你勾选了系统默认属性，无法删除操作'});
                        return false;
                    }

                    //判断，通用可输入属性，不可删除（v1.0需求）
                    if(isnotallow===1){
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:'存在通用可输入属性，不可删除'});
                        return false;
                    }


                    $.global_msg.init({gType:'confirm',icon:2,msg:js_msg_sure_del_prop ,btns:true,close:true,title:false,btn1:js_msg_cancel ,btn2:js_msg_sure ,noFn:function(){
                        //页面处理
                        $('#js_scroll_cardprop .js_select:checked').each(function(i,d){
                            if(!($(d).parents('.js_submit_prop').attr('data-id')==undefined)){
                                $('.js_delete_proplist').append('<li>'+$(d).parents('.js_submit_prop').attr('data-id')+'</li>');
                            }
                            $(d).parents('.js_submit_prop').remove();
                            _this.switchBtn($('.js_delprop_act'),'.js_select','.js_cardbank_content');

                            //标记卡属性已修改。
                            $('.js_cardprop_change').attr('data-res',1);

                        });
                    }});
                });

                //保存卡类型
                $('.js_submit').on('click',function(){
                    //cardtype id
                    var cid = $('.js_hiddenid').attr('data-cid');

                    //判断是否需要验证必填项
                    /*if(js_tip_cardtyperequired_arr[cid]!==undefined){
                        //判断卡属性是否存在必须值js_tip_cardtyperequired_arr
                        var namelist = [];
                        $('#js_scroll_cardprop .js_submit_prop').each(function(_index,_doms){
                            namelist.push($(_doms).find('em').attr('data-propname'));
                        });
                        var lens = js_tip_cardtyperequired_arr[cid].length;
                        for( var i = 0;i<lens;i++){
                            if($.inArray(js_tip_cardtyperequired_arr[cid][i],namelist) == -1){
                                $.global_msg.init({gType:'warning',icon:0,time:3,msg:'请添加'+js_tip_cardtyperequired_arr[cid][i]+'属性'});
                                return false;
                            }
                        }
                    }*/


                    //组装提交数据
                    var datastr = '';
                    var contactval = 0;
                    //获取属性
                    var propstr = '[{';
                    $('#js_scroll_cardprop .js_submit_prop').each(function(_index,_doms){
                        if($(_doms).attr('data-used')!=1){
                            //非使用中属性（使用中的无法修改）
                            //获取id（修改属性有id）
                            if($(_doms).attr('data-id')!=undefined && $(_doms).attr('data-id')!=''){
                                propstr += '"id":'+$(_doms).attr('data-id')+',';
                            }
                            propstr += '"ifdefault":'+$(_doms).attr('data-isdefault')+',';
                            //关联属性
                            $(_doms).attr('data-contact')? contactval=$(_doms).attr('data-contact'):contactval=0;
                            propstr += '"contact":'+contactval+',';
                            //获取属性名称
                            if($(_doms).attr('data-propname')!=undefined && $(_doms).attr('data-propname')!='' ){
                                propstr += '"attr":"'+$(_doms).attr('data-propname')+'",';
                            }
                            //是否加密
                            if($(_doms).attr('data-encrypt')!=undefined && $(_doms).attr('data-encrypt')!='' ){
                                propstr += '"encrypted":"'+$(_doms).attr('data-encrypt')+'",';
                            }
                            //属性实例
                            if($(_doms).attr('data-propexample')!=undefined && $(_doms).attr('data-propexample')!=''){
                                var aStr = $(_doms).attr('data-propexample');
                                //替换换行符
                                if (aStr.indexOf("\n") >= 0) {
                                    aStr = aStr.replace(new RegExp(/\n/g),"\\n");
                                }
                                propstr += '"val":"'+aStr+'",';
                            }
                            //属性提示
                            if($(_doms).attr('data-prophint')!=undefined && $(_doms).attr('data-prophint')!=''){
                                propstr += '"alert":"'+$(_doms).attr('data-prophint')+'",';
                            }
                            //获取属性类型
                            if($(_doms).attr('data-proptype')!=undefined && $(_doms).attr('data-proptype')!='' ){
                                propstr += '"type":"'+$(_doms).attr('data-proptype')+'",';
                            }
                            //获取属性展示方式
                            if($(_doms).attr('data-propusetype')!=undefined && $(_doms).attr('data-propusetype')!='' ){
                                propstr += '"isedit":"'+$(_doms).attr('data-propusetype')+'"},{';
                            }

                        }

                    });
                    //获取被删除的属性
                    $('.js_delete_proplist li').each(function(i,_d){
                        propstr += '"isdelete":1,"id":'+$(_d).html()+'},{';
                    });

                    propstr = propstr.substring(0,propstr.length-2);
                    propstr += ']';
                    if(propstr.length < 5){
                        propstr = '';
                    }

                    //使用方式
                    /*
                    var showtype = $('.js_showtype input:checked').val();
                    if( showtype=='' || showtype == undefined ){
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_msg_no_swipe_type});
                        return false;
                    }
                    */

                    datastr+= 'id='+cid+'&attribute='+propstr;

                    $.ajax({
                        url:addCardTypeUrl,
                        type:'post',
                        dataType:'json',
                        data:datastr,
                        success:function(res){
                            if(res.status==0){
                                if( $('.js_cardprop_change').attr('data-res')==1 ){
                                    //属性变更，是否去编辑卡模板样式
                                    //弹框
                                    $('.js_style_box .js_warning_title').html(js_msg_prop_change);
                                    $('.js_style_box').show();
                                    $('.js_masklayer').show();

                                }else if( $('.js_to_style').attr('data-res')==1 ){
                                    //没有模板样式，是否去编辑卡模板样式
                                    //弹框
                                    $('.js_style_box .js_warning_title').html(js_msg_no_model);
                                    $('.js_style_box').show();
                                    $('.js_masklayer').show();

                                }else{
                                    $.global_msg.init({gType:'warning',icon:1,msg:'保存成功' ,time:3,close:true,title:false ,endFn:function(){
                                        //页面处理-关闭当前页，父页面刷新
                                        //父页面刷新
                                        window.opener.location.reload();
                                        //关闭当前页面
                                        window.close();
                                    }});
                                }



                            }else{
                                $.global_msg.init({gType:'warning',icon:0,time:3,msg:res.msg});
                            }

                        },error:function(res){
                            //失败
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:'失败'});

                        }
                    });

                });
                //关闭添加卡类型页面
                $('.js_cancel').on('click',function(){
                    window.close();
                });
                //跳转卡模板样式编辑页面
                $('.js_style_box .js_warning_submit').on('click',function(){
                    window.location.href = js_to_style_Url;
                });
                $('.js_style_box .js_warning_cancel').on('click',function(){
                    //页面处理-关闭当前页，父页面刷新
                    //父页面刷新
                    window.opener.location.reload();
                    //关闭当前页面
                    window.close();
                });

            },
            submitProp:function(_data,_type,_oldpropname){
                if(_type==1){
                    //添加属性
                    var proptype = _data.find('.js_prop_type input:checked').val();
                    var propusetype = _data.find('.js_prop_usetype input:checked').val();
                    var cardpropname = _data.find('.js_prop_input input[name=propname]').val();
                    var cardpropexample = _data.find('.js_prop_input textarea[name=propexample]').val();
                    var cardpropcontact = 0;
                    var cardprophint = '';
                    var encrypted = '';

                    //可输入
                    if(propusetype==1) cardprophint = _data.find('.js_prop_input input[name=prophint]').val();
                    //通用可输入
                    if(proptype==1 && propusetype==1) encrypted = _data.find('.js_prop_encrypt input').prop('checked');
                    //通用只展示
                    if(proptype==1 && propusetype==2) cardpropcontact = _data.find('.js_contactprop input[name=contactprop]').val();
                    if(cardpropcontact==undefined || cardpropcontact=='') cardpropcontact=0;

                    if(encrypted!==''){
                        if(encrypted){
                            encrypted = 1;
                        }else{
                            encrypted = 0;
                        }
                    }

                    var propid = '';
                    //判断是否是添加了原有卡属性
                    if($.inArray(cardpropname,js_proparr) !== -1){
                        propid = $.inArray(cardpropname,js_proparr);
                        //解除被删除标记
                        $('.js_delete_proplist').find('li').each(function(i,d){
                            if($(this).html()==propid){
                                $(this).remove();
                            }
                        });
                    }

                    if(proptype==undefined){
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:'请选择属性类型'});
                        return false;
                    }
                    if(propusetype==undefined){
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:'请选择属性展示方式'});
                        return false;
                    }
                    if(cardpropname==''){
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_msg_prop_name});
                        return false;
                    }
                    if(cardpropexample==''){
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_msg_content});
                        return false;
                    }

                    //判断是否已存在
                    var isused = 0;
                    $('#js_scroll_cardprop .mCSB_container .js_submit_prop').each(function(i,d){
                        if($(d).find('label em').attr('data-propname')==cardpropname){
                            isused = 1;
                        }
                    });
                    if(isused == 1){
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_msg_prop_name_used});
                        return false;
                    }
                    //判断属于通用还是发卡单位
                    if(proptype==1){
                        $('#js_scroll_cardprop .mCSB_container .js_common_prop_dom').append('<div class="card_num_list js_submit_prop clear" data-isdefault="1" data-contact="'+cardpropcontact+'"  data-proptype="'+proptype+'" data-propusetype="'+propusetype+'" data-encrypt="'+encrypted+'" data-propname="'+cardpropname+'" data-propexample="'+cardpropexample+'" data-prophint="'+cardprophint+'" data-id="'+propid+'"><span class="span_info"><label><input type="checkbox" class="js_select"><em title="'+cardpropname+'">'+cardpropname+'</em></label></span><span class="span_num js_prop_content" title="'+cardpropexample+'">'+cardpropexample+'</span><span class="span_num js_prop_mark" title="'+cardprophint+'">'+cardprophint+'</span></div>');
                    }else{
                        $('#js_scroll_cardprop .mCSB_container .js_issuer_prop_dom').append('<div class="card_num_list js_submit_prop clear" data-isdefault="1" data-proptype="'+proptype+'" data-propusetype="'+propusetype+'" data-encrypt="'+encrypted+'" data-propname="'+cardpropname+'" data-propexample="'+cardpropexample+'" data-prophint="'+cardprophint+'" data-id="'+propid+'"><span class="span_info"><label><input type="checkbox" class="js_select"><em title="'+cardpropname+'">'+cardpropname+'</em></label></span><span class="span_num js_prop_content" title="'+cardpropexample+'">'+cardpropexample+'</span><span class="span_num js_prop_mark" title="'+cardprophint+'">'+cardprophint+'</span></div>');
                    }

                    //页面处理
                    $('.js_updcardprop_box').hide();
                    _data.remove();
                    $('.js_masklayer').hide();

                    //标记卡属性已修改。
                    $('.js_cardprop_change').attr('data-res',1);


                }else{
                    //修改属性

                    var proptype = _data.find('.js_prop_type input:checked').val();
                    var propusetype = _data.find('.js_prop_usetype input:checked').val();

                    var cardpropname = _data.find('.js_prop_input input[name=propname]').val();
                    var cardpropexample = _data.find('.js_prop_input textarea[name=propexample]').val();
                    var cardpropcontact = 0;
                    var cardprophint = '';
                    var encrypted = '';

                    //可输入
                    if(propusetype==1) cardprophint = _data.find('.js_prop_input input[name=prophint]').val();
                    //通用可输入
                    if(proptype==1 && propusetype==1) encrypted = _data.find('.js_prop_encrypt input').prop('checked');
                    //通用只展示
                    if(proptype==1 && propusetype==2) cardpropcontact = _data.find('.js_contactprop input[name=contactprop]').val();
                    if(cardpropcontact==undefined || cardpropcontact=='') cardpropcontact=0;

                    if(encrypted!==''){
                        if(encrypted){
                            encrypted = 1;
                        }else{
                            encrypted = 0;
                        }
                    }

                    var propid = '';
                    //判断是否是添加了原有卡属性
                    if($.inArray(cardpropname,js_proparr) !== -1){
                        propid = $.inArray(cardpropname,js_proparr);
                        //解除被删除标记
                        $('.js_delete_proplist').find('li').each(function(i,d){
                            if($(this).html()==propid){
                                $(this).remove();
                            }
                        });
                    }

                    if(cardpropname==''){
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_msg_prop_name});
                        return false;
                    }
                    if(cardpropexample==''){
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_msg_content});
                        return false;
                    }

                    //判断是否已存在
                    if(cardpropname!=_oldpropname){
                        $('#js_scroll_cardprop .mCSB_container .js_submit_prop').each(function(i,d){
                            if($(d).attr('data-propname')==cardpropname){
                                isused = 1;
                            }
                        });
                        if(isused == 1){
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_msg_prop_name_used});
                            return false;
                        }
                    }
                    var isused = 0;


                    //显示数据
                    $('#js_scroll_cardprop .js_select:checked').siblings().html(cardpropname);
                    $('#js_scroll_cardprop .js_select:checked').siblings().attr('title',cardpropname);
                    $('#js_scroll_cardprop .js_select:checked').parents('.js_submit_prop').find('.js_prop_content').html(cardpropexample);
                    $('#js_scroll_cardprop .js_select:checked').parents('.js_submit_prop').find('.js_prop_content').attr('title',cardpropexample);

                    //提交数据
                    $('#js_scroll_cardprop .js_select:checked').parents('.js_submit_prop').attr('data-propname',cardpropname);
                    $('#js_scroll_cardprop .js_select:checked').parents('.js_submit_prop').attr('data-propexample',cardpropexample);
                    //关联属性
                    if(proptype==1 && propusetype==2){
                        $('#js_scroll_cardprop .js_select:checked').parents('.js_submit_prop').attr('data-contact',cardpropcontact);
                    }
                    if(cardprophint!==''){
                        $('#js_scroll_cardprop .js_select:checked').parents('.js_submit_prop').attr('data-prophint',cardprophint);
                        $('#js_scroll_cardprop .js_select:checked').parents('.js_submit_prop').find('.js_prop_mark').attr('title',cardprophint);
                        $('#js_scroll_cardprop .js_select:checked').parents('.js_submit_prop').find('.js_prop_mark').html(cardprophint);
                    }
                    if(encrypted!==''){
                        $('#js_scroll_cardprop .js_select:checked').parents('.js_submit_prop').attr('data-encrypt',encrypted);
                    }

                    //页面处理
                    $('.js_updcardprop_box').hide();
                    _data.remove();
                    $('.js_masklayer').hide();

                    //标记卡属性已修改。
                    $('.js_cardprop_change').attr('data-res',1);
                }

            },
            /*
            * 属性弹框js
            * */
            selectPropJs:function(_cloneDom){
                //是否有加密项（通用有，发卡单位没有）
                _cloneDom.find('.js_prop_type input').click(function(){
                    if($(this).val()==1){
                        _cloneDom.find('.js_prop_encrypt').show();
                        if(_cloneDom.find('.js_prop_usetype input:checked').val()==2){
                            _cloneDom.find('.js_prop_input input[name=prophint]').hide();//提示文字隐藏
                            _cloneDom.find('.js_contactprop').show();//关联属性显示
                        }
                    }else{
                        _cloneDom.find('.js_prop_encrypt').hide();
                        _cloneDom.find('.js_contactprop').hide();//关联属性隐藏
                    }
                    _cloneDom.find('.js_prop_encrypt input').prop('checked',false);
                });
                //是否有提示项（可输入有，只展示没有）;+是否添加关联属性（通用可输入：11加）
                _cloneDom.find('.js_prop_usetype input').click(function(){
                    if($(this).val()==1 && _cloneDom.find('.js_prop_type input:checked').val()==1){
                        _cloneDom.find('.js_prop_encrypt,.js_prop_input input[name=prophint]').show();
                        _cloneDom.find('.js_contactprop').hide();//关联属性隐藏
                        //_cloneDom.find('.js_prop_input input').show();
                    }else if($(this).val()==1 && _cloneDom.find('.js_prop_type input:checked').val()==2){
                        _cloneDom.find('.js_prop_input input').show();
                        _cloneDom.find('.js_prop_encrypt').hide();
                        _cloneDom.find('.js_contactprop').hide();//关联属性隐藏
                    }else if($(this).val()==2  && _cloneDom.find('.js_prop_type input:checked').val()==1){
                        _cloneDom.find('.js_prop_encrypt,.js_prop_input input[name=prophint]').hide();
                        _cloneDom.find('.js_contactprop').show();//关联属性显示
                    }else if($(this).val()==2  && _cloneDom.find('.js_prop_type input:checked').val()==2){
                        _cloneDom.find('.js_prop_encrypt,.js_prop_input input[name=prophint]').hide();
                        _cloneDom.find('.js_contactprop').hide();//关联属性隐藏
                    }
                    _cloneDom.find('.js_prop_encrypt input').prop('checked',false);
                });
            },
             /*
             * 卡模板样式
             * */
            cardstyle:function(){
                //点击区域外关闭此下拉框
                $(document).on('click',function(e){
                    if($(e.target).parents('.js_select_ul_list').length>0){
                        var currUl = $(e.target).parents('.js_select_ul_list').find('ul');
                        $('.js_select_ul_list ul').not(currUl).hide()
                    }else{
                        $('.js_select_ul_list ul').hide();
                    }
                });
                //搜索-模块选择
                $('#js_mod_select,#js_seltitle').on('click',function(){
                    $('#js_selcontent').toggle();
                });
                //类型选中
                $('#js_selcontent li').on('click',function(){
                    var typeval = $(this).html();
                    var typekey = $(this).attr('val');
                    var pica = $(this).attr('data-pa');
                    var picb = $(this).attr('data-pb');
                    $('#js_mod_select').val(typeval);
                    $(this).addClass("on").siblings().removeClass("on");
                    if(pica==''|| pica==undefined){
                        $('.js_pic_content .js_pic_a').attr('src','/images/pleaseUploadImg.png');
                    }else{
                        $('.js_pic_content .js_pic_a').attr('src',pica);
                    }
                    if(picb==''|| picb==undefined){
                        $('.js_pic_content .js_pic_b').attr('src','/images/pleaseUploadImg.png');
                    }else{
                        $('.js_pic_content .js_pic_b').attr('src',picb);
                    }

                    $('#js_type_url').attr('href',js_to_style_Url+'/cardTypeId/'+typekey);
                    $('#js_type_url_back').attr('href',js_to_style_Url+'/cardTypeId/'+typekey+'/back/1');
                    $(this).parent().hide();
                });
            },
            /* 勾选按钮 发卡行、属性*/
            selectOperateCardAttr:function(_alldom,_seldom,_parentdom){
                _this=this;
                // 全选|取消全选
                $(_alldom).on('click',function(){
                    var $this = $(this);
                    if($this.prop('checked')){
                        $this.parents(_parentdom).find(_seldom).prop('checked',true);
                    }else{
                        $this.parents(_parentdom).find(_seldom).prop('checked',false);
                    }
                    _this.switchBtn($this,_seldom,_parentdom);
                });
                //单选
                $('.js_cardbank_content').on('click','.js_select',function(){
                    var alen = $(this).parents(_parentdom).find(_seldom).length;
                    var blen = $(this).parents(_parentdom).find(_seldom+':checked').length;
                    if(alen == blen){
                        $(this).parents(_parentdom).find(_alldom).prop('checked',true);
                    }else{
                        $(this).parents(_parentdom).find(_alldom).prop('checked',false);
                    }
                    _this.switchBtn($(this),_seldom,_parentdom);
                });

            },
            /*按钮点击效果切换*/
            switchBtn:function(_alldom,_seldom,_parentdom){
                var checklen = _alldom.parents(_parentdom).find(_seldom+':checked').length;
                if(checklen==1){
                    _alldom.parents(_parentdom).find('.js_updatebtn').removeClass('button_disabel');
                    _alldom.parents(_parentdom).find('.js_updatebtn').attr('disabled',false);
                    _alldom.parents(_parentdom).find('.js_deletebtn').removeClass('button_disabel');
                    _alldom.parents(_parentdom).find('.js_deletebtn').attr('disabled',false);
                }else if(checklen>1){
                    _alldom.parents(_parentdom).find('.js_updatebtn').addClass('button_disabel');
                    _alldom.parents(_parentdom).find('.js_deletebtn').attr('disabled','disabled');
                    _alldom.parents(_parentdom).find('.js_deletebtn').removeClass('button_disabel');
                    _alldom.parents(_parentdom).find('.js_deletebtn').attr('disabled',false);
                }else{
                    _alldom.parents(_parentdom).find('.js_updatebtn').addClass('button_disabel');
                    _alldom.parents(_parentdom).find('.js_deletebtn').addClass('button_disabel');
                    _alldom.parents(_parentdom).find('.js_updatebtn').attr('disabled','disabled');
                    _alldom.parents(_parentdom).find('.js_deletebtn').attr('disabled','disabled');
                }
            },
            /*滚动条*/
            ScrollBarfunc: function (_dom) {
                var scrollObjs = $(_dom);

                scrollObjs.mCustomScrollbar({
                    theme:"dark", //主题颜色
                    autoHideScrollbar: false, //是否自动隐藏滚动条
                    scrollInertia :0,//滚动延迟
                    height:50,
                    horizontalScroll : false//水平滚动条
                });
            }

        }
    });
})(jQuery);