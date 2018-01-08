function setTime(){
          if($('.js_send').find('em').length){
            var leftTime = $('.js_send').find('em').html();
            var t = parseInt(leftTime)-1;
            if(t>0){
              $('.js_send').find('em').html(t);
              clearTimeout(timeout);
              timeout = setTimeout(setTime,1000);
            }else{
              $('.js_send').html('获取验证码');
              $('.js_send').attr('val','1');
              $('.js_send').attr('disabled',false);
            }
          }
        }
        $(function(){

          $(document).on('keydown','.js_mobile,.js_verify',function(event){
            var e = event || window.event || arguments.callee.caller.arguments[0];
            var f = e&&e.keyCode;
            if(f<8||(f<48&&f>8)||f>105||(f>57&&f<96)){
              return false;
            }
          }).on('keyup','.js_mobile,.js_verify',function(){
            var val = $(this).val();
            $(this).val(val.replace(/[^\d]/g,''));
          });

          //发送验证码
          $('.js_send').on('click',function(){
            var _this = $(this);
            var canSend = _this.attr('val');
            if(canSend==0){
              return false;
            }
            var mobile = $.trim($('input[name=mobile]').val());
            if(!mobile){
              $.dialog.alert({content:"请填写手机号码"});
              return false; 
            }
            if(!(/^1[34578]\d{9}$/.test(mobile))){ 
                $.dialog.alert({content:"手机号码有误，请重填"}); 
                return false; 
            }
            var mcode = $.trim($('input[name=mcode]').val());
            mcode = mcode.replace('+','');
            $.post(verifySendUrl,{mobile:mobile,mcome:mcode},function(re){
              if(re.status==0){
                var str = '<em>60</em>';
                _this.attr('val','0');
                _this.attr('disabled',true);
                _this.html(str);
                clearTimeout(timeout);
                timeout = setTimeout(setTime,1000);
                $.selfTip($('input[name=verify]'),'发送成功');  
              }else{
                if(re.msg){
                  $.selfTip($('input[name=mobile]'),re.msg);  
				          return false;
                }
              }
            });
          });

          //验证企业名称
          $('.js_cname').on('blur',function(){
              var _this = $(this);
              var  cname = _this.val();
              if(cname){
                $.post(checkCompanyUrl,{company:cname},function(re){
                  if(re.status==1){
                    $.selfTip(_this,re.msg);  
                    return false; 
                  }
                })
              }
          });
          //提交
          $('#js_sub_btn').on('click',function(){

            var mobile = $.trim($('input[name=mobile]').val());
            if(!mobile){
              $.dialog.alert({content:"请填写手机号码"}); 
              return false; 
            }
            if(!(/^1[34578]\d{9}$/.test(mobile))){ 
                $.dialog.alert({content:"手机号码有误，请重填"}); 
                return false; 
            }
            var code = $.trim($('input[name=verify]').val());
            if(!code){
              $.dialog.alert({content:"请填写手机验证码"}); 
              return false; 
            }
            var mcode = $.trim($('input[name=mcode]').val());
            mcode = mcode.replace('+','');
            
                //$.post()
              /*}else{
                var email = $.trim($('input[name=email]').val());
                if(!email){
                  selfTip($('input[name=email]'),"请填写邮箱");  
                  return false; 
                }
                if(!(/^[\.a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/.test(email))){ 
                    selfTip($('input[name=email]'),"请填写正确邮箱");  
                    return false; 
                }
              }*/
			var pwd = $.trim($('input[name=pwd]').val());
			if(!pwd){
        $.dialog.alert({content:"请填写密码"});  
				return false; 
			}
			if(pwd.length<6){
        $.dialog.alert({content:"密码不能少于6位"});  
				return false; 
			}
			var repwd = $.trim($('input[name=repwd]').val());
			if(repwd!=pwd){
        $.dialog.alert({content:"两次密码不一致"}); 
				return false; 
			}
			var company = $.trim($('input[name=cname]').val());
			if(!company){
        $.dialog.alert({content:"请填写公司名称"}); 
				return false; 
			}
			var rname = $.trim($('input[name=rname]').val());
      if(!$('input[name=readed]').is(':checked')){
        $.dialog.alert({content:"您未同意服务条款"});   
        return false; 
      }
			$.post(submitPostUrl,{code:code,password:pwd,mcode:mcode,company:company,name:rname,type:1,user:mobile},function(re){
				if(re.status==0){
					$.dialog.alert({content:re.msg,time:3,callback:function(){
						window.location.href=loginUrl;
					}});
				}else if(re.status==1){
          $.dialog.alert({content:re.msg});  
					return false;
				}else{
					$.dialog.alert({content:re.msg});
					return false;
				}
			});
			
          });

          setTime();
        });