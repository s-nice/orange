/**
 * h5 扫描二维码添加好友页面js
 */
(function($) {
	$.extend({
		h5: {
			init: function() {
				this.submitAction();
			},
			// 登陆按键显示隐藏控制
			submitAction:function(){
				$('#js_v_phone,#js_v_phonecode').on({'keyup':function(){
					$.h5.showHideSubmit();
				},
				'input':function(){
					$.h5.showHideSubmit();
				}
				});
			},
			showHideSubmit:function(){
				if($('#js_v_phone').val() != '' && $('#js_v_phonecode').val() != ''){
					$('#js_phoneLogin').addClass('js_phoneLogin').css('color','#fff');
		        }else{
					$('#js_phoneLogin').removeClass('js_phoneLogin').css('color','#525252');
		    	}
			},
			// 验证码相关js
			phoneCodePage:function(){
				this.sendPhoneCode();
				this.showHideSendCondeBtn();
			},
			// 注册页面js
			registerPage:function(){
				this.sendCodeTrue();
			},
			// 显示发送验证码倒计时
			sendPhoneTime:function (timesRun){
				if(typeof timesRun == 'undefined'){
					timesRun=60;
				}
				var txt = t['h5_resend_verification_code'].replace(/\d{2}/,timesRun);
				$('#js_sendPhoneCode').removeClass('js_SendPhoneCode').html(txt);
				var interval = setInterval(function(){
				timesRun -= 1;
				if(timesRun === 0){
					clearInterval(interval);
					if(!$('#js_v_phone').val().match(/[\d]{11}/g)){
	            		$('#js_sendPhoneCode').html(t['h5_send_verification_code']).removeClass('exBtn js_SendPhoneCode');
	                }else{
	                	$('#js_sendPhoneCode').html(t['h5_send_verification_code']).addClass('exBtn js_SendPhoneCode');
	                }
				}else{
					txt = t['h5_resend_verification_code'].replace(/\d{2}/,timesRun);
					$('#js_sendPhoneCode').removeClass('exBtn js_SendPhoneCode').html(txt);
				}
				}, 1000);
			},
			// 发送验证码
			sendPhoneCode:function(){
	            $('#js_sendPhoneCode').on('click',function(){
	            	if($(this).hasClass('js_SendPhoneCode')){
	            		var type = $("input[name='type']").val();
	            		var phone = $('#js_v_phone').val();
		            	var mcode = $('#js_v_mcode').val();
		            	if(phone=='' || !phone.match(/[\d]{11}/g)){
		            		$.global_msg.init({msg:t['phone_code_error'],title:false,close:false,gType:'alert',btns:true});
		            		return false;
		                }
		            	var $this = $(this);
		            	// 校验是否注册
						var loadpage = $.global_msg.init({gType:'load',time:false});
						var paramsArr = {'type':type,'phone':phone,'mcode':mcode,'loadpage':loadpage,'jsUrl':$this.attr('jsUrl')};
		            	$.post($this.attr('jsCheckPhoneUrl'),{user:phone},function(result){
		            		switch(result){
		            			case 0:
		            				if(type == 'register'){
		            					// 注册时已有账号 跳转到登陆页面
		            					$.global_msg.init({msg:"账号已存在,请直接登录",icon:2,title:false,close:false,gType:'confirm',btns:true,btn1:'去登录',btn2:'取消',fn:function(){
		            						window.location = $this.attr('jsGoLoginUrl')+'?user='+phone;
		            					},noFn:function(){
		            						$('#js_v_phone').focus();
//		            						$('#js_sendPhoneCode').removeClass('exBtn js_SendPhoneCode');
				    	            		layer.close(loadpage);
		            					}});
		            				}else{
		            					// 发送验证码
		            					$.h5._sendPhoneCodeAct(paramsArr);
		            				}
		            				break;
		            			case 1:
		            				if(type == 'forgetPasswd'){
		            					// 找回密码时未注册账号 跳转到注册页面
		            					$.global_msg.init({msg:"账号不存在,请先注册",icon:2,title:false,close:false,gType:'confirm',btns:true,btn1:'去注册',btn2:'取消',fn:function(){
		            						window.location = $this.attr('jsGoRegisterUrl')+'?user='+phone;
		            					},noFn:function(){
		            						$('#js_v_phone').focus();
//		            						$('#js_sendPhoneCode').removeClass('exBtn js_SendPhoneCode');
				    	            		layer.close(loadpage);
		            					}});
		            				}else{
		            					// 发送验证码
		            					$.h5._sendPhoneCodeAct(paramsArr);
		            				}
		            				break;
		            			default:
		    	            		layer.close(loadpage);
		    	            		$.global_msg.init({msg:t['sendCode_fail_fornetwork'],icon:0,title:false,close:false,gType:'alert',btns:true});
		            		}
		            	},'json').error(function() { 
		            		layer.close(loadpage);
		            		$.global_msg.init({msg:t['sendCode_fail_fornetwork'],icon:0,title:false,close:false,gType:'alert',btns:true});
		            	});
	            	}else{
	            		return ;
	            	}
	            });
			},
			// 发送验证码 操作
			_sendPhoneCodeAct:function(paramArr){
				if(typeof paramArr == 'object' && Object.keys(paramArr).length == 5){
					$.cookie("h5timesRun",Date.parse(new Date()));
	            	$.cookie("h5PhoneMCode",paramArr.mcode);
	            	$.cookie("h5PhoneCode",paramArr.phone);
	        		$.h5.sendPhoneTime();
	            	$.post(paramArr.jsUrl,{phone:paramArr.phone,mcode:paramArr.mcode,type:paramArr.type},function(result){
	            		layer.close(paramArr.loadpage);
	            		if(result.status == '0'){
	            			$('#js_v_codeId').val(result.data);
	            			$.cookie("h5PhoneCodeId",result.data);
		            		$.global_msg.init({msg:t['send_succ'],icon:1,title:false,close:false,gType:'alert',btns:true});
						}else{
		            		$.global_msg.init({msg:result.msg,title:false,close:false,gType:'alert',btns:true});
						}
	            	},'json').error(function() {
	            		layer.close(paramArr.loadpage);
	            		$.global_msg.init({msg:t['sendCode_fail_fornetwork'],icon:0,title:false,close:false,gType:'alert',btns:true});
	            	});
				}
			},
			// 高亮|置灰发送验证码操作
			showHideSendCondeBtn: function(){
				$('#js_v_phone').on('keyup change',function(){
					var phone = $('#js_v_phone').val();
					if(!phone.match(/[\d]{11}/g)){
	            		$('#js_sendPhoneCode').removeClass('exBtn js_SendPhoneCode');
	                }else{
	                	if($.cookie("h5timesRun") != null){
	                		var nowtime = Date.parse(new Date());
                			var timesrun = nowtime - $.cookie("h5timesRun");
                			if(timesrun < 60*1000){
                				// nodo
                			}else{
                				$('#js_sendPhoneCode').addClass('exBtn js_SendPhoneCode').html(t['h5_send_verification_code']);
                			}
                		}else{
                			$('#js_sendPhoneCode').addClass('exBtn js_SendPhoneCode').html(t['h5_send_verification_code']);
                		}
	                }
				});
			},
			// 账号密码注册登录页
			registerLoginPage:function(){
				$('.js_ImOraBin').on('click','.js_Login',function(){
					$.h5.loginAct(this);
				});
			},
			// 重置密码登陆功能
			resetPasswdPage:function(){
				$('.js_resetPasswd_div').on('click','.js_Login',function(){
					$.h5.loginAct(this);
				});
			},
			// 账号密码注册登录功能|找回密码登陆功能
			loginAct:function(obj){
				var passwd1 = $("input[name='passwd1']").val();
            	var passwd2 = $("input[name='passwd2']").val();
            	if(passwd1=='' || passwd2 == ''){
            		$.global_msg.init({msg:'密码及确认密码不能为空',title:false,close:false,gType:'alert',btns:true});
            		return false;
                }
            	if(passwd1.match(/[\d]/) && passwd1.match(/[A-Z]/)){
            		// 格式符合标准
            	}else{
            		$.global_msg.init({msg:'密码必须同时包含数字和大写字母',title:false,close:false,gType:'alert',btns:true});
            		return false;
            	}
            	if(passwd1 != passwd2){
            		$.global_msg.init({msg:'请确认两次输入的密码是否相同',title:false,close:false,gType:'alert',btns:true});
            		return false;
            	}
            	var $this = $(obj);
            	var loadpage = $.global_msg.init({gType:'load',time:false});
            	$.post($this.attr('jsUrl'),{passwd1:passwd1,passwd2:passwd2},function(result){
            		layer.close(loadpage);
            		if(result.status == '0'){
            			window.location = $this.attr('jsGoUrl');
					}else{
						if(result.status == '8'){
							$.h5.addFriendBack(result.data);
						}else{
		            		$.global_msg.init({msg:result.msg,title:false,close:false,gType:'alert',btns:true});
						}
					}
            	},'json').error(function() { 
            		layer.close(loadpage);
            		$.global_msg.init({msg:t['login_fail_fornetwork'],icon:0,title:false,close:false,gType:'alert',btns:true});
            	});
			},
			// 首页名片信息页
			getIndexPage:function(){
				this.addFriend();
			},
			// 添加首页名片后互换名片添加好友
			addFriend:function(){
	            $('.js_addFriend').on('click',function(){
	            	// 姓名为必填项
	            	if($('#js_v_name').val() == ''){
	            		$.global_msg.init({msg:t['pop_name_no_empty'],title:false,close:false,gType:'alert',btns:true});
	            		return false;
	            	}
	            	var email = $('#js_v_email').val();
	            	if(email != '' && !email.match(/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/)){
	            		$.global_msg.init({msg:t['pop_email1_error'],title:false,close:false,gType:'alert',btns:true});
	            		return false;
	            	}
					var loadpage = $.global_msg.init({gType:'load',time:false});
	            	$.post($("form[name='js_addFriendForm']").attr('action'), $("form[name='js_addFriendForm']").serialize(),
	            		function(re){
	            			layer.close(loadpage);
	            			if(re.status == '0'){
		            			$.h5.addFriendBack(re.jsurl);
	            			}else{
	    	            		$.global_msg.init({msg:re.msg,icon:0,title:false,close:false,gType:'alert',btns:true,endFn:function(){
	    	            			window.location.reload(true);
	    	            		}});
	            			}
	            		},'json'
	            	).error(function(){
	            		layer.close(loadpage);
	            		$.global_msg.init({msg:t['save_vcard_fail_fornetwork'],icon:0,title:false,close:false,gType:'alert',btns:true});
	            	});
	            });
			},
			// 添加好友后的回馈信息
			addFriendBack:function(jsurl){
				var msgInfo = t['save_vcard_infomation'];
				switch(jsurl['statusCode'])
				{
					case 1:
					case 3:
						msgInfo = t['save_vcard_infomation_savecard'];
						break;
					case -1:
						msgInfo = t['save_vcard_infomation_nocard'];
						break;
					case -2:
					case -3:
						msgInfo = t['save_vcard_infomation_fail'];
						break;
					default:
						;
				}
				$.global_msg.init({msg:msgInfo,title:false,close:false,gType:'confirm',btns:true,btn1:t['pop_cancel'],btn2:t['pop_download'],fn:function(){
					window.location = jsurl[0];
				},noFn:function(){
					window.location = jsurl[1];
				}});
			},
			// 登陆页面
			loginPage:function(){
				this.accountPwdLogin();
				this.showPasswd();
				// 忘记密码
				$('.js_forget_pwd').on('click',function(){
					window.location = $(this).attr('jsUrl')+'?user='+$("input[name='user']").val();
				});
				// 注册
				$('.js_register_btn').on('click',function(){
					window.location = $(this).attr('jsUrl')+'?user='+$("input[name='user']").val();
				});
			},
			// 账号密码登陆操作
			accountPwdLogin:function(){
				$('.js_accountPwd_login').on('click',function(){
					var $this = $(this);
					var name=$("input[name='user']").val();
					var passwd=$("input[name='passwd']").val();
					if(name=='' || !name.match(/[\d]{11}/g)){
	            		$.global_msg.init({msg:t['phone_code_error'],title:false,close:false,gType:'alert',btns:true});
	            		return false;
	                }
					if(passwd == ''){
	            		$.global_msg.init({msg:'密码不能为空',title:false,close:false,gType:'alert',btns:true});
	            		return false;
	            	}
					// 校验是否注册
					var loadpage = $.global_msg.init({gType:'load',time:false});
	            	$.post($this.attr('jsCheckPhoneUrl'),{user:name},function(result){
	            		switch(result){
	            			case 0:
	            				// 账号密码登陆
	            				$.post($this.attr('jsUrl'),{user:name,passwd:passwd},function(result){
	        	            		layer.close(loadpage);
	        	            		if(result.status == '0'){
	        	            			window.location = $this.attr('jsGoUrl');
	        						}else{
	        							if(result.status == '8'){
	        								$.h5.addFriendBack(result.data);
	        							}else{
	        			            		$.global_msg.init({msg:result.msg,title:false,close:false,gType:'alert',btns:true});
	        							}
	        						}
	        	            	},'json').error(function() { 
	        	            		layer.close(loadpage);
	        	            		$.global_msg.init({msg:t['login_fail_fornetwork'],icon:0,title:false,close:false,gType:'alert',btns:true});
	        	            	});
	            				break;
	            			case 1:
	            				// 注册账号
            					$.global_msg.init({msg:"账号不存在,请先注册",title:false,close:false,icon:2,gType:'confirm',btns:true,btn1:'去注册',btn2:'取消',fn:function(){
            						window.location = $this.attr('jsGoToUrl')+'?user='+name;
            					},noFn:function(){
//            						$("input[name='user']").val('').focus();
//            						var passwd=$("input[name='passwd']").val('');
		    	            		layer.close(loadpage);
            					}});
	            				break;
	            			default:
	    	            		layer.close(loadpage);
	    	            		$.global_msg.init({msg:t['login_fail_fornetwork'],icon:0,title:false,close:false,gType:'alert',btns:true});
	            		}
	            	},'json').error(function() { 
	            		layer.close(loadpage);
	            		$.global_msg.init({msg:t['login_fail_fornetwork'],icon:0,title:false,close:false,gType:'alert',btns:true});
	            	});
				});
			},
			// 密码显示问题
			showPasswd:function(){
				$('.js_ImOraPasswd').on('click','em',function(){
					var $this = $(this).parents('.js_ImOraPasswd');
					if($this.find('input').attr('type') == 'text'){
						$this.find('input').attr('type','password');
						$this.find('em').attr("class","class_close");
					}else{
						$this.find('input').attr('type','text');
						$this.find('em').attr("class","class_open");
					}
				});
			},
			// 手机验证找回密码
			phoneResetPasswd:function(){
				this.sendCodeTrue();
			},
			// 校验验证码
			sendCodeTrue:function(){
				$('.js_ImOraBin').on('click','.js_phoneRegister',function(){
					var type = $("input[name='type']").val();
	            	var phone = $('#js_v_phone').val();
	            	var mcode = $('#js_v_mcode').val();
	            	var codeId = $('#js_v_codeId').val();
	            	var phoneCode = $('#js_v_phonecode').val();
	            	if(phone=='' || !phone.match(/[\d]{11}/g)){
	            		$.global_msg.init({msg:t['phone_code_error'],title:false,close:false,gType:'alert',btns:true});
	            		return false;
	                }
	            	if(codeId == '' || phoneCode == ''){
	            		$.global_msg.init({msg:t['verification_code_error'],title:false,close:false,gType:'alert',btns:true});
	            		return false;
	            	}
	            	var $this = $(this);
	            	var loadpage = $.global_msg.init({gType:'load',time:false});
	            	$.post($this.attr('jsUrl'),{phone:phone,mcode:mcode,codeId:codeId,code:phoneCode,type:type},function(result){
	            		layer.close(loadpage);
	            		if(result.status == '0'){
	            			window.location = $this.attr('jsGoUrl')+'?phone='+phone+'&mcode='+mcode+'&codeId='+codeId+'&code='+phoneCode;
						}else{
		            		$.global_msg.init({msg:result.msg,title:false,close:false,gType:'alert',btns:true});
						}
	            	},'json').error(function() { 
	            		layer.close(loadpage);
	            		$.global_msg.init({msg:t['login_fail_fornetwork'],icon:0,title:false,close:false,gType:'alert',btns:true});
	            	});
	            });
				
			}
			
		}
	});
})(jQuery);