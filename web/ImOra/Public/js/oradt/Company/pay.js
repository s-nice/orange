/**
 * 充值管理模块js
 */
(function($) {
	$.extend({
		payManage: {
			init: function() {
				$.selectItem.init(150);
				$('.js_userid_select,.js_time_select').select2();
				$('input[type="checkbox"].minimal').iCheck({
	                  checkboxClass: 'icheckbox_minimal-blue'
	                });
				this.showTimeInput();
				$('#js_endtime').dateMonthPick();
				this.exportAct();
			},
            // 显示时间输入框
            showTimeInput:function(){
            	$(".js_time_select").on('change',function(){
            		if($(this).val() == 'time'){
            			$('.select_time_c').css('display','block');
            		}else{
            			$('.select_time_c').css('display','none');
            		}
            	});
            },
            // 确认支付页面js
            payActPage:function(){
            	this.submitpay();
            	this.payBackFun();
            },
            // 提交支付操作
            submitpay:function(){
            	$('.js_submitpay').on('click',function(){
            		var num = $("input[name='num']").val();
            		if( num == '' || isNaN(num)){
            			$("input[name='num']").focus();
            			$.global_msg.init({gType:'warning',icon:2,msg:'充值金额不能为空且只能是数字'});
            			return false;
            		}
            		// 生成订单
//            		$.post( createOrderUrl,{num:num},function(re){
//            			var info = re.info;
//        				if(re.status == '0'){
//        					$('#js_orderAmount').val(num*100);
//        					$('#js_orderTime').val(info.createtime);
//        					$('#js_orderId').val(info.orderid);
//        					$('#js_bgUrl').val(info.notifyurl);
//        					$('#js_signMsg').val(info.payKey);
//        					$('.js_paysucc_act').attr('payid',info.orderid);
//        					$('.js_addpay_ddan_pop,.js_public_mask_pop').css('display','block');
//        					// $("form[name='payForm']").submit();
//        					$('#submitFormButton').trigger('click');
//        				}else{
//        					$.global_msg.init({gType:'warning',icon:2,msg:re.msg});
//            				return false;
//        				}
//        			}).error(function(){
//        				$.global_msg.init({gType:'warning',icon:2,msg:'系统错误,请稍后再试'});
//        				return false;
//        			});
            		gIsOrderOk = false;
            		$.ajax ({
            			url  : createOrderUrl, 
            			type : 'POST',
            			data : {num:num},
            			async : false,
            			success : function (re, status) {
                			var info = re.info;
            				if(re.status == '0'){
            					$('#js_orderAmount').val(num*100);
            					$('#js_orderTime').val(info.createtime);
            					$('#js_orderId').val(info.orderid);
            					$('#js_bgUrl').val(info.notifyurl);
            					$('#js_signMsg').val(info.payKey);
            					$('.js_paysucc_act').attr('payid',info.orderid);
            					$('.js_addpay_ddan_pop,.js_public_mask_pop').css('display','block');
            					// $("form[name='payForm']").submit();
            					//$('#submitFormButton').trigger('click');
            					gIsOrderOk = true;
            				}else{
            					$.global_msg.init({gType:'warning',icon:2,msg:re.msg});
                				return false;
            				}
            				
            			},
            			error : function () {
            				$.global_msg.init({gType:'warning',icon:2,msg:'系统错误,请稍后再试'});
            				return false;
            		    }
            		});
            		
            		return gIsOrderOk;
            	});
            },
            // 成功支付或是支付失败后的操作
            payBackFun:function(){
            	$('.js_paysucc_act').on('click',function(){
            		var payid = $(this).attr('payid');
            		var jsUrl = $(this).attr('jsUrl');
            		if(payid != 'no'){
            			$.post( jsUrl,{payid:payid},function(re){
            				if(re == '0'){
            					$('.js_addpay_ddan_pop').css('display','none');
            					$('.js_addpay_succ').css('display','block');
            				}else if (re == '1'){
            					$('.js_payfail_act').trigger('click');
            				}else{
            					$.global_msg.init({gType:'warning',icon:2,msg:'系统错误,请稍后再试'});
            				}
            			}).error(function(){
            				$.global_msg.init({gType:'warning',icon:2,msg:'系统错误,请稍后再试'});
            			});
            		}else{
            			$('.js_payfail_act').trigger('click');
            		}
            		
            	});
            	// 支付遇到问题
            	$('.js_payfail_act').on('click',function(){
                	$('.js_addpay_ddan_pop').css('display','none');
                	$('.js_addpay_pop').css('display','block');
            	});
            	// 返回重试|修改网银重新支付
            	$('.js_reback_submitpay').on('click',function(){
            		$('.js_addpay_ddan_pop,.js_addpay_pop,.js_public_mask_pop').css('display','none');
            	});
            	// 返回列表页面
            	$('.js_reback_paylist').on('click',function(){
            		localhost.href = payListUrl;
            	});

            },
            // 导出操作
        	exportAct:function(){
        		$('.js_exportAct').on('click',function(){
        			var $this = $("form[name='payListForm']");
        			var url = $this.attr('action');
        			$this.attr('target',"hidden_form");
            		$this.attr('action',$this.attr('jsUrl')).submit();
            		$this.attr('action',url).removeAttr('target');
        		});
        		
        	}
         
		}
	});
})(jQuery);