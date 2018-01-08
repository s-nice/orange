/**
 * 注册用户管理
 */
(function($) {
    $.extend({
        finance: {
            isimg:0,
            layer_div:null,
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

                //勾选按钮
                this.selectOperate();

                //搜索-模块选择 -
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

                //结算确认，单
                $('.js_balance').on('click',function(){
                    var orderid = $(this).attr('data-oid');
                    var balanceid = $(this).attr('data-balanceid');
                    var price = $(this).attr('data-p');
                    var username = $(this).attr('data-username');
                    var bind_account = $(this).attr('data-bind_account');
                    var paymentno = parseInt($(this).attr('data-peymentno'));

                    //弹框控制 显示
                    $('#js_cloneDom').append($('.Beta_comment_pop').clone());
                    $('#js_cloneDom .Beta_comment_pop').show();
                    $('.js_masklayer').show();
                    //关闭弹框
                    $('#js_cloneDom .Beta_comment_close img,.js_add_cancel').on('click',function(){
                        $(this).parents('.Beta_comment_pop').remove();
                        $('.js_masklayer').hide();
                    });
                    //佣金结算
                    var seller_commission = 0;
                    var comp_commission = 0;
                    var rec_poundage = 0;
                    //支付方式对应的比例
                    var arrs = [2,3,4];

                    if( !($.inArray( paymentno, arrs ) == -1) ){
                        comp_commission = parseFloat(price)*js_commissionrate;
                        seller_commission = parseFloat(price) - parseFloat(comp_commission);
                        rec_poundage = parseFloat(price)*js_counterfee[paymentno];
                    }

                    //弹框内容展示
                    $('#js_cloneDom .Beta_comment_pop').find('.js_balanceid').text(balanceid);
                    $('#js_cloneDom .Beta_comment_pop').find('.js_username').text(username);
                    $('#js_cloneDom .Beta_comment_pop').find('.js_bind_account').text(bind_account);
                    $('#js_cloneDom .Beta_comment_pop').find('.js_price').text(price);
                    $('#js_cloneDom .Beta_comment_pop').find('.js_seller_commission').text(seller_commission);
                    $('#js_cloneDom .Beta_comment_pop').find('.js_comp_commission').text(comp_commission);
                    $('#js_cloneDom .Beta_comment_pop').find('.js_rec_poundage').text(rec_poundage);

                    //提交
                    $('#js_cloneDom .js_add_sub').on('click',function(){
                        $.finance.settleBalance(orderid);
                    });
                });
                //当日到期结算-批量结算
                $('#js_batch_balance').on('click',function(){

                    var idstr = '';
                    $('.js_select').each(function(){
                        if ( $(this).hasClass('active') ){
                            idstr += $(this).attr('val')+',';
                        }
                    });
                    if(idstr == ''){
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_finance_balance_order_select});
                        return false;
                    }

                    //询问是否批量结算
                    $.global_msg.init({gType:'confirm',icon:2,msg:js_finance_balance_order+'？' ,btns:true,close:true,
                        title:false,btn1:js_g_message_submit2 ,btn2:js_g_message_submit1 ,noFn:function(){
                            $.finance.settleBalance(idstr);
                        }
                    });

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
                //当日到期结算-全选
                $('.order_list_name .span_span11').click(function(){
                    if ( $(this).find('i').hasClass('active') ){
                        $(this).find('i').removeClass('active');
                        $('.js_select').removeClass('active');
                    }else{
                        $(this).find('i').addClass('active');
                        $('.js_select').addClass('active');
                    }
                });
            },
            //结算
            settleBalance:function(_id){
                $.ajax({
                    url:'/Appadmin/FinanceManage/clearOrder',
                    type:'post',
                    dataType:'json',
                    data:'id='+_id,
                    success:function(res){
                        //结算
                        if(res.status==0){
                            $.finance.refreshPage();
                        }else{
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_operate_failed});
                        }
                    },error:function(res){
                        //失败
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_operate_failed});

                    }
                });
            },
            /*刷新页面*/
            refreshPage:function(){
                window.location.reload();
            },
            /*
             * 开票页面js（待录票号、附件；开票，拒绝开票）
             */
            invoiceJs:function(){
                _this = this;
                //附件图片上传按钮
                $('.js_content_detailinvoice').on('change','.js_fileupload_dom input[name=picfile]',function(){
                    _this.ajaxFileUploads(js_uploadimg_url,$(this).attr('id'));
                });
                //提交发票号和附件数据
                $('.js_content_detailinvoice').on('click','.js_submit_invoicenum',function(){
                    var invoice_id = $('#js_invoiceid').val();
                    var invoicenumb = $('.js_content_detailinvoice .js_invoicenumb').val();
                    var attachment = $('.js_content_detailinvoice #js_attachmentHid').val();
                    //判断是否数据正常填写。
                    if(invoicenumb=='' || invoicenumb==undefined || isNaN(invoicenumb) || invoicenumb.length!=8 ){
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_invoice_addnumb_eight});
                        return false;
                    }
                    var datastr = 'id='+invoice_id+'&num='+invoicenumb+'&attachment='+attachment;
                    //submit
                    $.ajax({
                        url:js_saveinvoicenumb_url,
                        type:'post',
                        dataType:'json',
                        data:datastr,
                        success:function(res){
                            //结算
                            if(res=='1'){
                                $.finance.refreshPage();
                            }else{
                                $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_invoice_savenumb_faild});
                            }
                        },error:function(res){
                            //失败
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_operate_failed});

                        }
                    });
                });
                //图片预览
                $('.showcond_warp').on('click','.js_click_show',function(){
                    var imgsrc = $(this).attr('src');
                    $('.js_masklayer').show();
                    if(imgsrc){
                        $('.js_preview .js_img_show').attr('src',imgsrc);
                        $('.js_preview').show();
                    }else{
                        $('.js_preview .js_img_show').attr('src','__PUBLIC__/images/showcard_pic.jpg');
                        $('.js_preview').show();
                    }
                });
                //关闭图片预览
                $('.js_preview').on('click','.js_preview_close',function(){
                    $('.js_preview').hide();
                    $('.js_masklayer').hide();
                });

                //开票
                $('.js_stayinvoice').on('click','.js_confirm_biling',function(){
                    $.global_msg.init({gType:'confirm',icon:2,msg:js_make_sure_bill+'？' ,btns:true,close:true,title:false,btn1:js_invoice_title_cancel ,btn2:js_g_message_submit1 ,noFn:function(){
                        var invoiceid = $('input[name=invoiceId]').val();
                        var orders = $('input[name=orders]').val();
                        var str_json = {invoiceid:invoiceid,status:2,orders:orders};
                        _this.postBill(str_json);
                    }});
                });
                //拒绝开票
                $('.js_stayinvoice').on('click','.js_refuse_biling',function(){
                    $('.js_box_refuse_biling').show();
                    $('.js_masklayer').show();
                    
                });
                //确认 拒绝开票
                $('.js_box_refuse_biling').on('click','.js_refuse_submit',function(){
                    var __this=this;
                    //防止多次点击提交按钮
                    $(__this).removeClass('js_refuse_submit');
                    setTimeout(function(){
                        $(__this).addClass('js_refuse_submit');
                    },5000);

                    var invoiceid = $('input[name=invoiceId]').val();
                    var reason = $('#js_box_refusebiling').val();
                    var olist = $("input[name='olist']").val();
                    if(!reason){
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_input_reason});
                        return false;
                    }
                    var str_json = {invoiceid:invoiceid,status:4,reason:reason,olist:olist};
                    _this.postBill(str_json);

                });
                //取消
                $('.js_box_refuse_biling').on('click','.js_refuse_cancel',function(){
                    $('.js_box_refuse_biling').hide();
                    $('.js_masklayer').hide();
                    //清空数据

                });
                //取消开票页面(返回列表页)
                $('.js_stayinvoice').on('click','.js_cancel_btn',function(){
                    window.location.href = js_invoice_list_url;
                });
            },

            postBill:function(str_json){
                $.ajax({
                    url:js_invoice_biling,
                    type:'post',
                    dataType:'json',
                    data:str_json,
                    success:function(res){
                        //开票
                        if(res.status==0){
                            $.global_msg.init({gType:'alert',time:1,icon:1,msg:res.msg,endFn:function(){
                                    window.location.href = js_invoice_list_url;
                                }});
                        }else{
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:res.msg});
                        }
                    },error:function(res){
                        //失败
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:'操作失败'});

                    }
                });
            },

            /*
             * 申请开票页面js
             */
            applyInvoiceJs:function(){
                _this = this;
                //专票普票切换
                $('.wamp_request').on('click','.js_invoice_type_switch input[type=radio]',function(){
                    var rediotype = $(this).val();
                    if(rediotype == 'p'){
                        $('.js_invoice_type_zhuan').hide();
                        $('.js_invoice_type_pu').show();
                    }else{
                        $('.js_invoice_type_zhuan').show();
                        $('.js_invoice_type_pu').hide();
                    }
                });
                //获取可开金额
                $('.js_get_amountusable').on('change keyup','input[name=userid]',function(){
                    //判断是否为11位电话号码
                    var uid = $(this).val();
                    //判断用户id（手机号）
                    if(!_this.checkUid(uid)){
                        return false;
                    }

                    $.ajax({
                        url:js_getamountusable_url,
                        type:'post',
                        dataType:'json',
                        data:'id='+uid,
                        success:function(res){
                            $('.js_amount_result').html($.globalFun.formatMoney(res));
                            $('.js_amount_result').attr('data-val',res);
                        },error:function(res){
                            $('.js_amount_result').html('0.00');
                            $('.js_amount_result').attr('data-val',0);
                        }
                    });
                });
                //取消按钮
                $('.wamp_request').on('click','.js_cancel_btn',function(){
                    var iscancel = 0;
                    var arr1 = ['email','userid','amount'];
                    var arr2 = ['contact','telephone','compname','taxpayercode','compregaddress','compregphone','bankdeposit','bankaccount','taxpayer','certificate'];

                    for(var item in arr1){
                        if($('.js_get_amountusable input[name='+arr1[item]+']').val()){
                            iscancel = 1;
                        }
                    }
                    if($('.js_invoice_type_pu input[name=invoicehead]').val()){
                        iscancel = 1;
                    }
                    for(var item in arr2){
                        if($('.js_invoice_type_zhuan input[name='+arr2[item]+']').val()){
                            iscancel = 1;
                        }
                    }

                    if(iscancel==1){
                        $.global_msg.init({gType:'confirm',icon:2,msg:js_invoice_cancel_apply+'？' ,btns:true,close:true,title:false,btn1:js_invoice_title_cancel ,btn2:js_g_message_submit1 ,noFn:function(){
                            window.location.href = js_invoice_list_url;
                        }});
                    }else{
                        window.location.href = js_invoice_list_url;
                    }

                });

                //图片上传按钮
                $('.js_invoice_type_zhuan').on('change','.js_fileupload_dom input[name=picfile]',function(){
                    _this.ajaxFileUploads(js_uploadimg_url,$(this).attr('id'));
                });

                //提交
                $('.wamp_request').on('click','.js_submit_btn_z,.js_submit_btn_p',function(){

                    
                    var the_max_account = $('.js_amount_result').attr('data-val');
                    var the_email = $('.js_get_amountusable input[name=email]').val();
                    var the_uid = $('.js_get_amountusable input[name=userid]').val();
                    var the_amount = $('.js_get_amountusable input[name=amount]').val();
                    var the_invoicetype = '';
                    $('.js_get_amountusable input[name=invoicetype]').each(function(i,d){
                        if($(d).prop('checked')){
                            the_invoicetype = $(d).val();
                        }
                    });

                    if(the_email  == '' || the_email == undefined || !_this.checkMail(the_email)){
                        //$.global_msg.init({gType:'warning',icon:0,time:3,msg:js_err_email});
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_invoice_error_apply});
                        $('.js_get_amountusable input[name=email]').css('border-color','red');
                        return false;
                    }else{
                        $('.js_get_amountusable input[name=email]').css('border-color','#b8b8b8');
                    }

                    if(the_uid  == '' || the_uid == undefined || !_this.checkUid(the_uid) ){
                        //$.global_msg.init({gType:'warning',icon:0,time:3,msg:js_err_id});
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_invoice_error_apply});
                        $('.js_get_amountusable input[name=userid]').css('border-color','red');
                        return false;
                    }else{
                        $('.js_get_amountusable input[name=userid]').css('border-color','#b8b8b8');
                    }

                    if(!parseFloat(the_amount)){
                        //$.global_msg.init({gType:'warning',icon:0,time:3,msg:js_err_amount});
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_invoice_error_apply});
                        $('.js_get_amountusable input[name=amount]').css('border-color','red');
                        return false;
                    }else{
                        $('.js_get_amountusable input[name=amount]').css('border-color','#b8b8b8');
                    }
                    if(parseFloat(the_amount) > parseFloat(the_max_account)){
                        //$.global_msg.init({gType:'warning',icon:0,time:3,msg:js_err_bigamount});
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_invoice_error_apply});
                        $('.js_get_amountusable input[name=amount]').css('border-color','red');
                        return false;
                    }else{
                        $('.js_get_amountusable input[name=amount]').css('border-color','#b8b8b8');
                    }

                    if(the_amount  <= 0 || the_amount  == '' || the_amount == undefined || !_this.checkAmount(the_amount) ){
                        //$.global_msg.init({gType:'warning',icon:0,time:3,msg:js_err_amount_null});
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_invoice_error_apply});
                        $('.js_get_amountusable input[name=amount]').css('border-color','red');
                        return false;
                    }else{
                        $('.js_get_amountusable input[name=amount]').css('border-color','#b8b8b8');
                    }

                    //普票、专票
                    if(the_invoicetype == 'p'){
                        //普票提交 - 验证数据
                        var the_invoicehead = $('.js_invoice_type_pu input[name=invoicehead]').val();
                        /*if(!the_invoicehead){
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_err_title});
                            return false;
                        }*/
                        var str_json = {the_email:the_email,the_uid:the_uid,the_amount:the_amount,the_invoicetype:the_invoicetype,the_invoicehead:the_invoicehead};
                    }else if(the_invoicetype =='z'){
                        //专票提交 - 验证数据
                        var the_contact = $('.js_invoice_type_zhuan input[name=contact]').val();
                        var the_telephone = $('.js_invoice_type_zhuan input[name=telephone]').val();
                        var the_compname = $('.js_invoice_type_zhuan input[name=compname]').val();
                        var the_taxpayercode = $('.js_invoice_type_zhuan input[name=taxpayercode]').val();
                        var the_compregaddress = $('.js_invoice_type_zhuan input[name=compregaddress]').val();
                        var the_compregphone = $('.js_invoice_type_zhuan input[name=compregphone]').val();
                        var the_bankdeposit = $('.js_invoice_type_zhuan input[name=bankdeposit]').val();
                        var the_bankaccount = $('.js_invoice_type_zhuan input[name=bankaccount]').val();
                        var the_taxpayer = $('.js_invoice_type_zhuan input[name=taxpayer]').val();
                        var the_certificate = $('.js_invoice_type_zhuan input[name=certificate]').val();
                        var reg_tel = /^([0-9\-]){7,14}$/;

                        if(the_contact  == '' || the_contact == undefined){
                            //$.global_msg.init({gType:'warning',icon:0,time:3,msg:js_err_contact});
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_invoice_error_apply});
                            $('.js_invoice_type_zhuan input[name=contact]').css('border-color','red');
                            return false;
                        }else{
                            $('.js_invoice_type_zhuan input[name=contact]').css('border-color','#b8b8b8');
                        }
                        if(the_telephone  == '' || the_telephone == undefined){
                            //$.global_msg.init({gType:'warning',icon:0,time:3,msg:js_err_phone});
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_invoice_error_apply});
                            $('.js_invoice_type_zhuan input[name=telephone]').css('border-color','red');
                            return false;
                        }else{
                            $('.js_invoice_type_zhuan input[name=telephone]').css('border-color','#b8b8b8');
                        }
                        if(!reg_tel.test(the_telephone)){
                            //$.global_msg.init({gType:'warning',icon:0,time:3,msg:js_format_err_telephone});
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_invoice_error_apply});
                            $('.js_invoice_type_zhuan input[name=telephone]').css('border-color','red');
                            return false;
                        }else{
                            $('.js_invoice_type_zhuan input[name=telephone]').css('border-color','#b8b8b8');
                        }
                        if(the_compname  == '' || the_compname == undefined){
                            //$.global_msg.init({gType:'warning',icon:0,time:3,msg:js_err_comp});
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_invoice_error_apply});
                            $('.js_invoice_type_zhuan input[name=compname]').css('border-color','red');
                            return false;
                        }else{
                            $('.js_invoice_type_zhuan input[name=compname]').css('border-color','#b8b8b8');
                        }
                        if(the_taxpayercode  == '' || the_taxpayercode == undefined){
                            //$.global_msg.init({gType:'warning',icon:0,time:3,msg:js_err_taxpayercode});
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_invoice_error_apply});
                            $('.js_invoice_type_zhuan input[name=taxpayercode]').css('border-color','red');
                            return false;
                        }else{
                            $('.js_invoice_type_zhuan input[name=taxpayercode]').css('border-color','#b8b8b8');
                        }
                        if(the_compregaddress  == '' || the_compregaddress == undefined){
                            //$.global_msg.init({gType:'warning',icon:0,time:3,msg:js_err_regaddr});
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_invoice_error_apply});
                            $('.js_invoice_type_zhuan input[name=compregaddress]').css('border-color','red');
                            return false;
                        }else{
                            $('.js_invoice_type_zhuan input[name=compregaddress]').css('border-color','#b8b8b8');
                        }
                        if(the_compregphone  == '' || the_compregphone == undefined){
                            //$.global_msg.init({gType:'warning',icon:0,time:3,msg:js_err_regphone});
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_invoice_error_apply});
                            $('.js_invoice_type_zhuan input[name=compregphone]').css('border-color','red');
                            return false;
                        }else{
                            $('.js_invoice_type_zhuan input[name=compregphone]').css('border-color','#b8b8b8');
                        }
                        if(!reg_tel.test(the_compregphone)){
                            //$.global_msg.init({gType:'warning',icon:0,time:3,msg:js_format_err_comregphone});
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_invoice_error_apply});
                            $('.js_invoice_type_zhuan input[name=compregphone]').css('border-color','red');
                            return false;
                        }else{
                            $('.js_invoice_type_zhuan input[name=compregphone]').css('border-color','#b8b8b8');
                        }
                        if(the_bankdeposit  == '' || the_bankdeposit == undefined){
                            //$.global_msg.init({gType:'warning',icon:0,time:3,msg:js_err_bankdeposit});
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_invoice_error_apply});
                            $('.js_invoice_type_zhuan input[name=bankdeposit]').css('border-color','red');
                            return false;
                        }else{
                            $('.js_invoice_type_zhuan input[name=bankdeposit]').css('border-color','#b8b8b8');
                        }
                        if(the_bankaccount  == '' || the_bankaccount == undefined){
                            //$.global_msg.init({gType:'warning',icon:0,time:3,msg:js_err_bankaccount});
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_invoice_error_apply});
                            $('.js_invoice_type_zhuan input[name=bankaccount]').css('border-color','red');
                            return false;
                        }else{
                            $('.js_invoice_type_zhuan input[name=bankaccount]').css('border-color','#b8b8b8');
                        }
                        var reg_account = /^(\d{16}|\d{19})$/;
                        if(!reg_account.test(the_bankaccount)){
                            //$.global_msg.init({gType:'warning',icon:0,time:3,msg:js_format_err_bankaccount});
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_invoice_error_apply});
                            $('.js_invoice_type_zhuan input[name=bankaccount]').css('border-color','red');
                            return false;
                        }else{
                            $('.js_invoice_type_zhuan input[name=bankaccount]').css('border-color','#b8b8b8');
                        }
                        if(the_certificate  == '' || the_certificate == undefined){
                            //$.global_msg.init({gType:'warning',icon:0,time:3,msg:js_err_certificate});
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_invoice_error_apply});
                            $('.js_invoice_type_zhuan input[name=certificate]').parents('.js_fileupload_dom').css('border-color','red');
                            return false;
                        }else{
                            $('.js_invoice_type_zhuan input[name=certificate]').parents('.js_fileupload_dom').css('border-color','#b8b8b8');
                        }
                        if(the_taxpayer  == '' || the_taxpayer == undefined){
                            //$.global_msg.init({gType:'warning',icon:0,time:3,msg:js_err_taxpayer});
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_invoice_error_apply});
                            $('.js_invoice_type_zhuan input[name=taxpayer]').parents('.js_fileupload_dom').css('border-color','red');
                            return false;
                        }else{
                            $('.js_invoice_type_zhuan input[name=taxpayer]').parents('.js_fileupload_dom').css('border-color','#b8b8b8');
                        }


                        var str_json = {the_email:the_email,the_uid:the_uid,the_amount:the_amount,the_invoicetype:the_invoicetype,the_contact:the_contact,the_telephone:the_telephone,the_compname:the_compname,the_taxpayercode:the_taxpayercode,the_compregaddress:the_compregaddress,the_compregphone:the_compregphone,the_bankdeposit:the_bankdeposit,the_bankaccount:the_bankaccount,the_taxpayer:the_taxpayer,the_certificate:the_certificate};
                    }else{
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_err_invoicetype});
                        return false;
                    }

                    var index = layer.load(0,1);
                    $.post(applyPostUrl,str_json,function(res){
                        if(res.status==0){
                            layer.close(index);
                            $.global_msg.init({gType:'alert',time:1,icon:1,msg:res.msg,endFn:function(){

                                    window.location.href = js_invoice_list_url;
                                }});
                            
                        }else{
                            layer.close(index);
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:res.msg});
                        }
                    })
                })

            },
            
            /*
             * 检测用户ID是否为电话号码
             * */
            checkUid:function(_mobile){
                if(_mobile.length==11)
                {
                    var myreg = /^1[3578]\d{9}$/ ;
                    if(myreg.test(_mobile))
                    {
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            },
            /*
             * 判断输入的是否为金额，保留两位小数点
             * */
            checkAmount:function(count) {
                var reg=/^[0-9]*(\.[0-9]{1,2})?$/;
                if(!reg.test(count)) {
                    //不符合
                    return false;
                }else{
                    //符合
                    return true;
                }
            },
            checkMail:function(mail){
                var reg  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if (!reg.test(mail)){
                    return false;
                }else{
                    return true;
                }
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
                            $('#'+_id).next().find('img').attr('src',gPublic+res['absolutePath']).show();

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
            },

            waitlist:function(){
                var _this = this;
                $('.js_select_div').on('click','.span_name,ul,em',function(e){
                    $(this).parent('.js_select_div').find('ul').toggle();
                    //点击其他地方，隐藏下拉框
                    $(document).one("click", function(){
                        $(".js_select_div ul").hide();
                    });
                    e.stopPropagation();
                });
                //点击li选中搜索条件
                $('.js_select_div').on('click','ul>li',function(){
                    var val = $(this).attr('val');
                    var text = $(this).text();
                    var oInput = $(this).parents('.js_select_div').find('.span_name input');
                    oInput.val(text).attr('title',text).attr('val',val);
                });

                //搜索
                $('#js_searchbutton').on('click',function(){
                    window.location.href = _this.searchParam();
                }); 
            },

            //开票，订单详情页面
            bill:function(){
                var _this = this;

                //选择附件
                $('#uploadImgField1').on('change',function(event){
                    _this.isimg = 0;
                    var img = event.target.files[0];
                    // 判断图片格式
                    if(!(img.type.indexOf('image')==0 && img.type && /\.(?:jpg|png|gif)$/.test(img.name)) ){
                        $.global_msg.init({gType:'alert',icon:2,time:3,msg:tip_img_format});
                        return false;
                    }
                    /*_this.isimg = 1;
                    var fr = new FileReader();
                    fr.onload = function(e){
                        var imgsrc = this.result;
                        $('#title_pic').attr('src',imgsrc);
                    }
                    fr.readAsDataURL(img);*/
                    $.ajaxFileUpload({
                        url : uploadUrl,
                        secureuri:false,
                        fileElementId:'uploadImgField1',
                        data:{fileNameHid:'uploadImgField1'},
                        dataType: 'json',
                        success: function (rtn){
                            console.log(rtn);
                            if(rtn.status==1){
                                $.global_msg.init({gType:'alert',icon:2,time:3,msg:rtn.info});
                                return false;
                            }else{
                                $('#title_pic').attr('src',rtn.data.absolutePath);
                                $('#js_img_url').val(rtn.data.absolutePath);
                            }
                        },
                        error: function (data, status, e){
                            
                        }
                    });
                });

                //保存附件图片
                $('#js_save_img').on('click',function(){
                    var no = $('input[name=invoice_no]').val();
                    var src = $('#js_img_url').val();
                    var reg = /^\d{8}$/;
                    if(!reg.test(no)){
                        $.global_msg.init({gType:'alert',icon:2,time:3,msg:tip_invoice_no_format});
                        return false;
                    }
                    var id = $('input[name=id]').val();
                    $.post(billPostUrl,{id:id,status:3,src:src,no:no},function(re){
                        if(re.status===0){
                            $.global_msg.init({gType:'alert',time:1,icon:1,msg:re.msg,endFn:function(){
                                    window.location.reload();
                                }});
                        }else{
                            $.global_msg.init({gType:'alert',time:3,icon:0,msg:re.msg});
                        }
                    });
                    
                    
                });

                //开票
                $('#js_bill').on('click',function(){
                    $.global_msg.init({gType:'confirm',icon:2,msg:str_make_sure_bill+'？',btns:true,close:true,title:false,btn1:str_cancel,btn2:str_make_sure ,noFn:function(){
                           var id = $('input[name=id]').val();
                           $.post(billPostUrl,{id:id,status:2},function(re){
                                if(re.status===0){
                                    $.global_msg.init({gType:'alert',time:1,icon:1,msg:re.msg,endFn:function(){
                                            window.location.href=document.referrer;
                                        }});
                                }else{
                                    $.global_msg.init({gType:'alert',time:3,icon:0,msg:re.msg});
                                }
                           });
                        }
                    });
                });

                //拒绝开票
                $('#js_refuse').on('click',function(){
                    //var oDiv = $('#add_admin_dom');
                    _this.layer_div = $.layer({
                        type: 1,
                        title: false,
                        bgcolor: '#ccc',
                        border: [0, 0.3, '#ccc'], 
                        shade: [0.2, '#000'], 
                        closeBtn:false,
                        page: {dom:$('#add_admin_dom')},
                        shadeClose:true,
                    });
                });

                //关闭拒绝开票说明
                $('#add_admin_dom').on('click','.js_logoutcancel,.js_add_cancel',function(){
                    layer.close(_this.layer_div);
                });

                //关闭拒绝开票说明
                $('#add_admin_dom').on('click','.js_add_sub',function(){

                    var reason = $('#js_refuse_reason').val();
                    if(!reason){
                        $.global_msg.init({gType:'alert',icon:2,time:3,msg:str_input_reason});
                        return false;
                    }
                    var length = reason.length;
                    if(length>100){
                        $.global_msg.init({gType:'alert',icon:2,time:3,msg:str_input_reason_long});
                        return false;
                    }
                    var id = $('input[name=id]').val();
                    $.post(billPostUrl,{id:id,status:4,reason:reason},function(re){
                        if(re.status===0){
                            $.global_msg.init({gType:'alert',time:1,icon:1,msg:re.msg,endFn:function(){
                                    window.location.reload();
                                }});
                        }else{
                            $.global_msg.init({gType:'alert',time:3,icon:0,msg:re.msg});
                        }
                    });
                });
                
                //图片预览
                $('.showcond_warp').on('click','.js_click_show',function(){
                    var oImg = $('#js_layer_original');
                    oImg.attr('src','');
                    var imgsrc = $(this).attr('src');
                    if(imgsrc){  
                        oImg.attr('src',imgsrc);
                        _this.layer_div = $.layer({
                            type: 1,
                            title: false,
                            bgcolor: '#ccc',
                            border: [0, 0.3, '#ccc'], 
                            shade: [0.2, '#000'], 
                            closeBtn:false,
                            page: {dom:oImg},
                            shadeClose:true,
                        });
                    }
                });
                //取消
                $('#js_cancel').on('click',function(){
                    window.history.back();
                });
            },

            //搜索提交
            searchParam:function(){
                var condition='';
                var keyword = encodeURIComponent($('input[name=keyword]').val());
                var starttime = $('#js_begintime').val();
                var endtime = $('#js_endtime').val();
                var type = $('input[name=search_type]').attr('val'); 
                if($('input[name=status]').length){
                    var status = $('input[name=status]').attr('val');
                    condition += '/s/'+status;
                }
                condition += '/t/'+type;
                if(keyword != ''){
                    condition +='/k/'+keyword;
                }
                
                if(starttime != ''){
                    condition +='/starttime/'+starttime;
                }
                if(endtime != ''){
                    condition +='/endtime/'+endtime;
                }
                
                return searchurl+condition;
            },




        }
    });
})(jQuery);