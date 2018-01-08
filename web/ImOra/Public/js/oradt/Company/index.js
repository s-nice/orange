
/**
 * 首页index js
 */
(function($) {
    $.extend({
        //首页js
        index:{
            /*ajax 进入首页后加载首页相关数据(暂不用)*/
            loop:0,
            AjaxGetIndexData:function(gGetDataUrl) {
                var that=this;
                $.ajax({
                    url:gGetDataUrl,
                    type:'get',
                    success:function(res){
                        if(res.status=='0'){
                            $('.js_loding').removeClass('fa fa-fw fa-spinner lodding_icon round');
                            var certification_status=res.data.ident=='3' ? '通过' :'未通过';
                            $('#js_certification_status').html(certification_status);//审核状态
                            var num =res.data.author == null ? 0 :res.data.author;
                            $('#js_accreditNum').html(num);//企业授权数
                             num =res.data.balance == null ? 0 :res.data.balance;
                            $('#js_money').html(num);//企业余额
                            $('#js_card_all').html(res.data.card.total);//名片数量 日周月
                            $('#js_card_day').html(res.data.card.today);
                            $('#js_card_week').html(res.data.card.week);
                            $('#js_card_month').html(res.data.card.month);
                            $('#js_scannerNum').html(res.data.scanner.scannernum);//扫描仪数量
                            $('#js_scan_day').html(res.data.scanner.today);//扫描数量日周月
                            $('#js_scan_week').html(res.data.scanner.week);
                            $('#js_scan_month').html(res.data.scanner.month);
                            that.loop=0;
                        }else{ //再重新请求三次
                            if(that.loop<3){
                                $.index.AjaxGetIndexData(gGetDataUrl);
                                that.loop+=1;
                            }else{
                                $('.js_loding').removeClass('fa fa-fw fa-spinner lodding_icon round');
                                $('.js_loding').html('--')

                            }

                        }
                    },
                    fail:function(){
                        if(that.loop<3){
                            $.index.AjaxGetIndexData(gGetDataUrl);
                            that.loop+=1;
                        }else{
                            $('.js_loding').removeClass('fa fa-fw fa-spinner lodding_icon round');
                            $('.js_loding').html('--')

                        }
                    }


                })

            }

        },

        //购买授权js
        authorization:{
            init:function(){
                _this=this;
                //
                _this.selectdata('.js_buy_select','.js_sub_buy_numb');
                _this.selectdata('.js_memory_select','.js_sub_memory_numb');
                _this.selectdata('.js_time_select','.js_sub_time_length');
                //购买授权数自定义输入框
                $('.js_buy_select').on('keyup paste blur','#js_buy_numb_val',function(){
                    var buynumb = $(this).val();
                    if(buynumb<5){
                        $(this).val('');
                        //如果自定义输入内容为空，默认恢复为当前已选择的项为结果
                        $('.js_sub_buy_numb').val($('.js_buy_select .on').attr('data-val'));
                    }else{
                        $('.js_sub_buy_numb').val(buynumb);
                    }
                    //购买金额处理
                    _this.settlementAmount();
                });

                //提交购买
                $('.addpay_button').on('click','.js_buy_sub',function(){
                    var type = $('.js_sub_type').val();
                    var aid = $('.js_sub_aid').val();
                    //授权数量
                    var auth_numb = $('.js_sub_buy_numb').val();
                    //存储量
                    var memory_numb = $('.js_sub_memory_numb').val();
                    //购买时长
                    var time_length = $('.js_sub_time_length').val();
                    //支付金额(计算公式：100*a*b*c/1000)
                    var money_i = $('.js_sub_money').val();
                    var money = auth_numb*time_length*(memory_numb/1000)*100;
                    //对比数据结果
                    if(money!=money_i){
                        $.global_msg.init({gType:'warning',icon:0,time:3,close:true,msg:'金额错误，请刷新页面重试'});
                    }

                    //生成订单
                    $.ajax({
                        url:js_buyAccreditUrl,
                        type:'post',
                        async: false,
                        dataType:'json',
                        data:'id='+aid+'&type='+type+'&authorizenum='+auth_numb+'&storagenum='+memory_numb+'&length='+time_length+'&price='+money,
                        success:function(res){

                            if(res.status!=0){
                                $('.js_addpay_failed,.js_public_mask_pop').css('display','block');
                            }else{
                                var info = res.info;
                                //订单生成，组装数据，提交给快钱
                                $('#js_orderAmount').val(money*100);
                                $('#js_orderTime').val(info.createtime);
                                $('#js_orderId').val(info.orderid);
                                $('#js_bgUrl').val(info.notifyurl);
                                $('#js_signMsg').val(info.payKey);
                                $('.js_paysucc_act').attr('payid',info.orderid);
                                $('.js_addpay_ddan_pop,.js_public_mask_pop').css('display','block');
                                //提交快钱
                                $("form[name='payForm']").submit();
                            }

                        },error:function(res){
                            //错误
                            $('.js_addpay_failed,.js_public_mask_pop').css('display','block');

                            return false;
                        }
                    });

                });

                /*支付结果*/
                $('.js_close_confirm').on('click',function(){
                    //关闭弹框（验证是否支付）
                    var payid = $('#js_orderId').val();
                    if(payid != 'no'){
                        $.authorization.payResult(payid);
                    }else{
                        $('.js_payfail_act').trigger('click');
                    }
                });
                $('.js_pay_success_res').on('click',function(){
                    //付款成功
                    var payid = $('#js_orderId').val();
                    if(payid != 'no'){
                        $.authorization.payResult(payid);
                    }else{
                        $('.js_payfail_act').trigger('click');
                    }
                });
                $('.js_pay_error_res').on('click',function(){
                    //付款遇到问题
                    var payid = $('#js_orderId').val();
                    if(payid != 'no'){
                        $.authorization.payResult(payid);
                    }else{
                        $('.js_payfail_act').trigger('click');
                    }
                });
                $('.js_backact').on('click',function(){
                    //返回重试
                    $('.js_addpay_failed,.js_public_mask_pop').css('display','none');
                });
                $('.js_backto_list').on('click',function(){
                    //支付成功 ，返回列表
                    location.href = auth_list_url;
                });

            },
            //判断支付是否成功
            payResult:function(_pid){
                $.ajax({
                    url:jsUrl,
                    type:'post',
                    dataType:'json',
                    data:'payid='+_pid,
                    success:function(re){
                        console.log(re);
                        if(re === 0){
                            //支付成功
                            $('.js_addpay_ddan_pop').css('display','none');
                            $('.js_addpay_succ').css('display','block');
                        }else{
                            $('.js_addpay_ddan_pop').css('display','none');
                            $('.js_addpay_failed').css('display','block');
                        }
                    },error:function(re){
                        //错误
                        $.global_msg.init({gType:'warning',icon:2,msg:'支付结果暂未返回，请稍后查看'});
                    }
                });
            },
            //购买条件选择
            selectdata:function(_dom,_subid){
                _this=this;
                $(_dom).on('click','.yuanxing',function(){
                    if( !$(this).hasClass('on') ){
                        $(this).addClass('on');
                        $(this).siblings().removeClass('on');
                        $(_subid).val($(this).attr('data-val'));
                    }
                    if(_dom=='.js_buy_select'){
                        $('#js_buy_numb_val').val('');
                    }

                    _this.settlementAmount();

                });
            },
            //结算金额
            settlementAmount:function(){
                //授权数量
                var auth_numb = $('.js_sub_buy_numb').val();
                //存储量
                var memory_numb = $('.js_sub_memory_numb').val();
                //购买时长
                var time_length = $('.js_sub_time_length').val();
                //支付金额(计算公式：100*a*b*c/1000)
                var money = auth_numb*time_length*(memory_numb/1000)*100;
                $('.js_sub_money').val(money);
                $('#js_money_id').html(money);
            }
        }
    });

})(jQuery);
