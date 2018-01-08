/**
 *orange卡类型管理js
 */
(function($) {
    $.extend({
        orapay: {
            //
            init: function() {
                _this= this;
                //滚动条
                _this.ScrollBarfunc('#js_scroll_dom');

                //预览
                $('.js_h5_preview').click(function(){
                    return false;
                    var _params = '';
                    //获取新增数据
                    var type=$(this).attr('data-type');
                    if(type==1){
                        var _dom = $('.js_orapay_content');
                        var id = $('.js_formcontent .js_btn_hid').find("input[name='orapayid']").val();
                        var payname = _dom.find("input[name='bankname']").val();
                        var paydebit = _dom.find("input[name='debit']").prop('checked');
                        var paycredit = _dom.find("input[name='credit']").prop('checked');
                        var sorting = _dom.find("input[name='sortnumb']").val();
                        var logo = _dom.find("input[name='logoimg']").val();
                        paydebit===true?paydebit=2:paydebit=1;
                        paycredit===true?paycredit=2:paycredit=1;
                        //必填项
                        if(payname=="" || payname == undefined){
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:'请先添加银行名称'});
                            return false;
                        }
                        if(logo=="" || logo == undefined){
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:'请先上传银行Logo'});
                            return false;
                        }

                        _params += 'type='+type+'&id='+id+'&name='+payname+'&debitcard='+paydebit+'&creditcard='+paycredit+'&logo='+logo+'&sorting='+sorting;
                    }

                    $.ajax({
                        url:js_url_h5list,
                        type:'post',
                        dataType:'json',
                        data:_params,
                        success:function(res){
                            $.orapay.showH5Page(res);
                        },error:function(res){
                            //添加失败
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_operat_error});
                        }
                    });
                });
                //关闭预览框
                $('.js_h5_content').on('click','.js_h5_close',function(){
                    $('.js_h5_content').hide();
                });
            },
            showH5Page:function(_data){
                $('.js_h5_content .js_h5_list .js_orapay_h5_list').html(_data);
                $('.js_h5_content').show();
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
            },
            addOraPay:function(){
                _this = this;
                //附件图片上传按钮
                $('.js_orapay_logo').on('change','input[name=picfile]',function(){
                    _this.ajaxFileUploads(js_uploadimg_url,$(this).attr('id'));

                });
                $('.js_logoimg_show').on('click','em',function(){
                    $('.js_logoimg_show').find('input').val('');
                    $('.js_logoimg_show').find('img').attr('src','');
                    $(this).hide();
                });

            },

            //提交表单，验证排序码
            checkData:function(){
                var _this = this;
                var id = $('.js_btn_hid input[name="orapayid"]').val();
                var bankname = $('.js_orapay_content input[name="bankname"]').val();
                var phone = $('.js_orapay_content input[name="phone"]').val();

                var debit = $('.js_orapay_content input[name="debit"]').prop('checked');
                var credit = $('.js_orapay_content input[name="credit"]').prop('checked');
                var debitcity = $('.js_orapay_content input[name="debitcity"]').val();
                var creditcity = $('.js_orapay_content input[name="creditcity"]').val();

                var logoimg = $('.js_orapay_content input[name="logoimg"]').val();
                var sortnumb = $('.js_orapay_content .js_orapay_sortnumb input[name="sortnumb"]').val();

                if(bankname.length>20 || bankname.length<1){
                    $.global_msg.init({gType:'warning',icon:0,time:3,msg:'银行名称长度必须小于12位，且不为空'});
                    return false;
                }

                if(phone==undefined || phone ==''){
                    $.global_msg.init({gType:'warning',icon:0,time:3,msg:'请填写客服电话'});
                    return false;
                }

                if(debit){
                    debit = 2;
                }else{
                    debit = 1;
                }
                if(credit){
                    credit = 2;
                }else{
                    credit = 1;
                }
                if(debit==1 && credit==1){
                    $.global_msg.init({gType:'warning',icon:0,time:3,msg:'请选择一个支持的银行卡类型'});
                    return false;
                }

                if(logoimg=='' || logoimg==undefined){
                    $.global_msg.init({gType:'warning',icon:0,time:3,msg:'请上传银行Logo'});
                    return false;
                }
                var   reg   =   /^[0-9]*[1-9][0-9]*$/
                //严重序号是否为正整数
                if(isNaN(sortnumb) || sortnumb == '' || sortnumb == undefined || !reg.test(sortnumb)){
                    $.global_msg.init({gType:'warning',icon:0,time:3,msg:'列表顺序必须是正整数'});
                    return false;
                }
                var confition = '';
                var _data = '';
                _data += "bankname="+bankname+"&phone="+phone+"&logoimg="+logoimg+"&sortnumb="+sortnumb+"&debit="+debit+"&credit="+credit+"&debitcity="+debitcity+"&creditcity="+creditcity;
                confition +='sortnumb='+sortnumb;
                //判断排序码是否已经存在
                if(id!='' && id !=undefined){
                    confition += "&id="+id;
                    _data += "&orapayid="+id;
                }

                $.ajax({
                    url:js_url_sortnumb_check,
                    type:'post',
                    dataType:'json',
                    data:confition,
                    success:function(res){
                        if(res==0){
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:'您输入的序号已存在，请重新输入'});
                            return false;
                        }
                        if(res == 1){
                            _this.submitOraPay(_data);
                            //$('.js_formcontent form').submit();
                        }
                    },error:function(res){
                        //添加失败
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_operat_error});
                    }
                });

            },

            /* 提交 数据*/
            submitOraPay:function(_data){
                //orapayid bankname phone logoimg sortnumb debit credit debitcity creditcity
                $.ajax({
                    url:js_url_sortnumb_form,
                    type:'post',
                    dataType:'json',
                    data:_data,
                    success:function(res){

                        if(res!=0){
                            var err_msg = '操作失败';
                            if(res==999022){
                                err_msg = '银行名称已存在';
                            }
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:err_msg});
                            return false;
                        }else{
                            window.location.href = js_url_index;
                        }

                    },error:function(res){
                        //添加失败
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_operat_error});
                    }
                });
            },

            /*是否提交删除*/
            delconfirm:function(_this){
                var id = $(_this).parent().attr('data-id');
                $.global_msg.init({gType:'confirm',icon:2,msg:'确认是否删除？' ,btns:true,close:true,title:false,btn1:'取消' ,btn2:'确定' ,noFn:function(){
                    $.orapay.delOraPay(id);
                }});
            },
            /*删除银行*/
            delOraPay:function(_id){
                $.ajax({
                    url:js_url_delorapay,
                    type:'post',
                    dataType:'json',
                    data:'id='+_id,
                    success:function(res){
                        if(res==0){
                            window.location.href = js_url_index;
                        }else{
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:'删除失败'});
                        }
                    },error:function(res){
                        //添加失败
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_operat_error});
                    }
                });
            },

            /*
             * ajax 图片上传
             * url，domid
             * */
            ajaxFileUploads:function(_tempurl,_id){
                $.ajaxFileUpload({
                    url : _tempurl,
                    secureuri:false,
                    fileElementId:_id,
                    dataType: 'json',
                    success: function (res){
                        if(res.status==0){
                            var res = res.data;
                            $('#'+_id+'Hid').val(res['absolutePath']);
                            $('.'+_id+'_show').find('img').attr('src',res['absolutePath']).show();
                            $('.'+_id+'_show').find('em').show();
                        }else{
                            $.global_msg.init({title:false, gType: 'alert',  msg: res['info'] });
                        }
                    },
                    error: function (data, status, e){
                        if('error'==status && typeof(data)=='object' && data.responseText.indexOf('413 Request Entity Too Large')!=-1 ) {
                            $.global_msg.init({title:false, gType: 'alert',  msg: js_err_invoicetype_img_err_big});
                        } else if (typeof (e)=='string'){
                            $.global_msg.init({title:false, gType: 'alert',  msg: e });
                        }else{
                            $.global_msg.init({title:false, gType: 'alert',  msg: js_err_invoicetype_err_faild});
                        }
                    }
                })
            }


        }
    });
})(jQuery);