/**
 * demojs
 */
(function($) {
	$.extend({
		demo: {
			init: function() {
				this.submitAction();
				this.sendPhoneCode();
				this.phoneLogin();
			},
			// 登陆按键显示隐藏控制
			submitAction:function(){
				$('#js_v_phone,#js_v_phonecode').on({'keyup':function(){
					$.demo.showHideSubmit();
				},
				'input':function(){
					$.demo.showHideSubmit();
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
			// 显示发送验证码倒计时
			sendPhoneTime:function (timesRun){
				if(typeof timesRun == 'undefined'){
					timesRun=60;
				}
				var txt = t['h5_resend_verification_code'].replace(/\d{2}/,timesRun);
				$('#js_sendPhoneCode').removeClass('js_SendPhoneCode').val(txt);
				var interval = setInterval(function(){
				timesRun -= 1;
				if(timesRun === 0){
					clearInterval(interval);
					$('#js_sendPhoneCode').val(t['h5_send_verification_code']).addClass('js_SendPhoneCode');
				}else{
					txt = t['h5_resend_verification_code'].replace(/\d{2}/,timesRun);
					$('#js_sendPhoneCode').val(txt);
				}
				}, 1000);
			},
			// 发送验证码
			sendPhoneCode:function(){
	            $('#js_sendPhoneCode').on('click',function(){
	            	if($(this).hasClass('js_SendPhoneCode')){
	            		var phone = $('#js_v_phone').val();
		            	var mcode = $('#js_v_mcode').val();
		            	if(phone=='' || !phone.match(/[\d]/g)){
		            		$.global_msg.init({msg:t['phone_code_error'],title:false,close:false,gType:'alert',btns:true});
		            		return false;
		                }
		            	$.cookie("h5timesRun",Date.parse(new Date()));
		            	$.cookie("h5PhoneMCode",mcode);
		            	$.cookie("h5PhoneCode",phone);
	            		$.demo.sendPhoneTime();
		            	var $this = $(this);
		            	$.post($this.attr('jsUrl'),{phone:phone,mcode:mcode},function(result){
		            		if(result.status == '0'){
		            			$('#js_v_codeId').val(result.data);
		            			$.cookie("h5PhoneCodeId",result.data);
			            		$.global_msg.init({msg:t['send_succ'],icon:1,title:false,close:false,gType:'alert',btns:true});
							}else{
			            		$.global_msg.init({msg:result.msg,title:false,close:false,gType:'alert',btns:true});
							}
		            	},'json').error(function() { 
		            		$.global_msg.init({msg:t['sendCode_fail_fornetwork'],icon:0,title:false,close:false,gType:'alert',btns:true});
		            	});
		            	
	            	}else{
	            		return ;
	            	}
	            });
			},
			// 手机登陆验证
			phoneLogin:function(){
	            $('.ImOra_bin').on('click','.js_phoneLogin',function(){
	            	var phone = $('#js_v_phone').val();
	            	var mcode = $('#js_v_mcode').val();
	            	var codeId = $('#js_v_codeId').val();
	            	var phoneCode = $('#js_v_phonecode').val();
	            	if(phone=='' || !phone.match(/[\d]/g)){
	            		$.global_msg.init({msg:t['phone_code_error'],title:false,close:false,gType:'alert',btns:true});
	            		return false;
	                }
	            	if(codeId == '' || phoneCode == ''){
	            		$.global_msg.init({msg:t['verification_code_error'],title:false,close:false,gType:'alert',btns:true});
	            		return false;
	            	}
	            	var $this = $(this);
	            	var loadpage = $.global_msg.init({gType:'load',time:false});
	            	$.post($this.attr('jsUrl'),{phone:phone,mcode:mcode,codeId:codeId,code:phoneCode},function(result){
	            		layer.close(loadpage);
	            		if(result.status == '0'){
	            			window.location = $this.attr('jsGoUrl');
						}else{
		            		$.global_msg.init({msg:result.msg,title:false,close:false,gType:'alert',btns:true});
						}
	            	},'json').error(function() { 
	            		layer.close(loadpage);
	            		$.global_msg.init({msg:t['login_fail_fornetwork'],icon:0,title:false,close:false,gType:'alert',btns:true});
	            	});
	            });
			},
			lookBigPic:function(){
				$('.warp_tongs_list,.warp_card_list .warp_card_pic').on('click',function(event){
					event.stopPropagation();
					var src = $(this).find('img').attr('srca')?$(this).find('img').attr('srca'):$(this).find('img').attr('src');
					var rsrc = $(this).find('img').attr('srcb')?$(this).find('img').attr('srcb'):$(this).find('img').attr('src');
					$('.pop_imgpic img').attr('src',src).attr('rsrc',rsrc);
					$('.warp_mask_pop').show();
					$('.warp_pop').show(200);
					$('.pop_imgpic img').on('click',function(){
						reverseCard($(this),200);
					});
					
					// 汇报我看了谁的名片
					var $target = $(this).hasClass('js_report_click') ? $(this) : $(this).closest('.js_report_click');
					if ($target.hasClass('click_reported')) {
						return;
					}
					$target.addClass('click_reported')
					       .siblings('.js_report_click')
					       .removeClass('click_reported');
					var userId = $target.attr('userId');
					var vcardId = $target.attr('vcardId');
					var cardOwnerId = $target.attr('cardOwnerId');
					var nowDate = new Date();
					// 如果用户id， 名片id 或者名片所有者id为空， 不发送点击报告。 直接返回
					if (''===userId || ''===vcardId || ''===cardOwnerId) {
						return;
					}
					
					var params = {
							userId : userId, 
							vcardId : vcardId, 
							cardOwnerId : cardOwnerId,
							timestamp   : nowDate.getTime()
						};
					params = "{" +
       "\"head\" : {" +
              "\"version\" : \"1.1\"," +
              "\"type\" : \"1\"" +
       "}," +
       "\"body\" : {" +
              "\"vcardId\" : \"" + vcardId + "\"," +
              "\"timestamp\" : \""+ nowDate.getTime() +"\"," +
              "\"cardOwnerId\" : \"" + cardOwnerId + "\"," +
              "\"userId\" : \"" + userId + "\"" +
       "}" +
       "}" ;
					$.post(gReportClickUrl, params);
				});
				$('.pop_colse,.warp_mask_pop').on('click',function(){
					$('.warp_mask_pop').hide();
					$('.warp_pop').hide(200);
				});
            },
            // 将搜索结果文字高亮
            highlightKeyword : function () {
            	var keyword = $('#search_key_word').val();
            	var $cardList = $('#search_result_list .js_highlight_keyword');
            	var $item, text, newText, tmpText;
            	
        		for (var j=0; j<$cardList.length; j++) {
        			$item = $cardList.eq(j).find('i, em, p');
        			for (var k=0; k<$item.length; k++) {
        			    text = $item.eq(k).text();
            			newText = '';
        			    for (var l=0; l<text.length; l++) {
        			    	tmpText = text[l];
                			for(var i=0; i<keyword.length; i++) {
            			        if(keyword[i]==text[l]) {
            			        	tmpText = '<font color="#f00">' + text[l] + '</font>';
            			        	break;
            			        }
            			    }
                			newText = newText + tmpText;
            			}
            			$item.eq(k).html(newText);
            		}
            	}
            }
			
		}
	});
})(jQuery);
function reverseCard(obj,time){
    var img1 = obj.attr('src');
    var img2 = obj.attr('rsrc');
    if(!img2){
        img2 = obj.attr('src');
    }
    var mLeft = parseInt(obj.css('marginLeft'));
    var str_m_left = mLeft+'px';
    var width = obj.width();
    var str_width_half = (mLeft+Math.ceil(width/2))+'px';
    var _str_width_half='-'+str_width_half;
    var str_width = width+'px';

    if(!obj.is(':animated')){
        obj.animate({width:'0px',marginLeft:str_width_half},time,function(){
            obj.attr('src',img2);
            obj.attr('rsrc',img1);
            //alert(1);
            obj.animate({width:str_width,marginLeft:str_m_left},time);
        });
    }
}
/*点击图片信息， 弹出图片层处理*/
function showMsgImg(src) {
		var msg = '<div style="width: 800px;height: 600px;float: left; margin: 0px 10px 0 0;list-style: none;text-align: center;font-size: 0;">\
			        <span style="display: inline-block; width: 1px; height: 100%; vertical-align: middle;"></span><img style="max-width:100%;max-height:100%; margin-left:-1px;vertical-align:middle;" src="' + src + '"/>\
			       </div>';
		//$.global_msg.init({msg:msg, time:0, width:screen.width-200, height:screen.height-200});
		var i = $.layer({
		    type : 1,
		    title : false,
		    fix : false,
		    offset:['50px' , ''],
		    area : ['800px','600px'],
		    page : {html : msg}
		});
	}
