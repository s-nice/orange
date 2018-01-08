/**
 *SNS聊天通用JS文件
 *@author dingzy<zp@oradt.com>
 *@date 2015-02-03
 */
var map, marker;
;(function($){
    $.extend({
        sns_common: {
            needPic: {width:80, height:80 },
                    offsetPic: {top:0, left:0},
                    headPic: {picW:0, picH:0},    //头像宽高
                    dragHeadPic:{picW:80, picH:80},    //放大缩小后头像宽高
            init: function () {
            	//初始化绑定事件函数
            	this.bindEvent();
                //点击个人头像修改头像图片
                $('.cls_sns_person_avatar').click(function(){
        			window.location.href = gUrlPersonAvatar;
                });
                
                // 地图定位
                $('.map_click').on('click', function () {
                 	if($('input[name="talkType"]').val() == $.WebChat.CONST.CHAT_TYPE.PUBLIC){
                		return true;
                	}
                    $('.SNSpop_chat_map,.snsmask_pop').show();
                    var thisObj = $(this);
                    thisObj.hasClass('active') ? null : thisObj.addClass('active');
                    // 百度地图API功能
                    map = new BMap.Map("map_image");
                    var point = new BMap.Point(116.400244, 39.92556);
                    map.centerAndZoom(point, 18);
                    var myCity = new BMap.LocalCity();
                    myCity.get($.sns_common.myFun);//城市
                });
                // 关闭地图层
                $('.map_close').on('click', function () {
                    $('.SNSpop_chat_map,.snsmask_pop').hide();
                    $('.map_click').removeClass('active');
                });
                // 城市搜索 地图定位
                $('#mapSearchKwd').on('keyup', function () {
                    var local = $.sns_common.mapSearch(map);
                    local.search($(this).val());
                });
                $('#mapSearchKwdBtn').on('click', function () {
                    var local = $.sns_common.mapSearch(map);
                    local.search($('#mapSearchKwd').val());
                });
                // 城市定位发送
                $('.map_send').on('click', function () {
                    var $this = $('#map_point_list .map_checked2');
                    var lat = $this.attr('lat');
                    var lng = $this.attr('lng');
                    var address = $this.text();
                    //发送地理位置(地图)
                    var opts = {
                    		lat: lat,
                    		lng: lng,
                    		address: address,
                            succUploadFn: function(){
                            	//$('.hiddenactive').hide();
                               }
                            };
                    $.WebChat.externalLocation(opts);
                });
                $('#map_point_list').on('click', 'li', function () {
                	$('#map_point_list .map_checked2').removeClass('map_checked2').find('.active').removeClass('active');
                    $(this).addClass('map_checked2').find('.myphoto_ttwo').addClass('active');
                    var lat = $(this).attr('lat');
                    var lng = $(this).attr('lng');
                    map.centerAndZoom(new BMap.Point(lng, lat), 18);
                    marker.setPosition(new BMap.Point(lng, lat));
                    $.sns_common.showPosition(lng, lat, 'map_image')//重新绘制地图
                });
                // 发送名片,选择名片(联系人)
                $('#card_click').on('click', function () {
                 	if($('input[name="talkType"]').val() == $.WebChat.CONST.CHAT_TYPE.PUBLIC){
                		return true;
                	}
                 	var thisObj = $(this);
                    $.ajax({
                        url:  gUrlgetCardWordList, //sns_sendCardUrl
                        type: 'post',
                        dataType: 'json',
                        data: '',
                        success: function (result) {
                        	thisObj.addClass('active');
                            //$('#snsInfo').html(result);
                        	$('.snsSendVcardPop').html(result);
                        	$('.snsSendVcardPop,.snsmask_pop').show();
        /*                    var pageii = $.layer({
                                style: [],
                                type: 1,
                                fix: false,
                                title: false,
                                area: ['auto', 'auto'],
                                offset: ['66px', '351px'],
                                bgcolor: '#fff',
                                border: [0, 0.3, '#ff9900'], //边框[边框大小, 透明度, 颜色]
                                shade: [0.2, '#000'], //遮罩层
                                closeBtn: [0, false], //去掉默认关闭按钮
                                shift: '', //从左动画弹出
                                page: {
                                    dom: '#snsInfo'
                                },
                                end: function () {
                                    $('#snsInfo').html('');
                                }
                            });*/
                            $.WebChat.myScroll($(".cls_send_card_left_data"));
                            //点击字母打开对应字母下面的联系人列表
                            $('.cls_word_first_row').click(function(){
                            	var thisObj = $(this);
                            	var nextDataObj = thisObj.next('.cls_send_card_single_list'); //紧挨着字母对应的联系人列表对象
                            	if(thisObj.find('.cls_word_frist_num').text()>0){//联系人对象都有数据
	                            	if(nextDataObj.is(':visible')){
	                            		nextDataObj.hide();
	                            	}else{	
                            			if(nextDataObj.children().size() == 0){
                                        	var word = thisObj.find('.cls_word_frist').text();
                                        	var dataParam = {word:word,type:'word'};
                                        	$.post(gUrlgetCardWordList,dataParam,function(rst){
                                        		if(rst.status == 0){
                                        			var html = '';
                                        			for(var i=0;i<rst.data.list.length;i++){
                                        				var obj = rst.data.list[i];
                                        			  html += '<div class="bottom_contdl_list cls_send_vcard_single_contact hand"  clientid="'+obj.clientid+'" vcardid="'+obj.cardid+'">'
                                        					+'<div class="contdl_list_img safariborder"><img class="safariborder" src="'+gUrlGetHead+'?headurl='+obj.clientid+'" /></div> '
                                        					+'<div class="contdl_list_text">'
                                        					+'<i>'+obj.name+'</i><em>'+obj.num+gSnsUnitZhang+'</em>'
                                        					+'</div>';
	                                        			    if(obj.companylogo){
	                                        				  html +='<div class="contdl_list_icon"><img src="'+obj.companylogo+'" /></div>';
	                                        			    } 
	                                        			    html +='</div>';
                                        			}
                                        			thisObj.parent().find('.cls_send_card_single_list').html(html);
                                        			$.WebChat.myScroll($(".cls_send_card_left_data"));
                                        		}
                                        	});
                            			}
                            			nextDataObj.show();
	                            	}
                            	}
                            });
                            
                            //触发第一个字母
                            /*var leftContactObj = $('.cls_word_first_row');
                            if(leftContactObj.size()>0){
                            	leftContactObj.eq(0).click();
                            }*/
                            
                            //点击名片弹出层中左侧的联系人对象
                            $('.cls_send_card_left_data').on('click','.cls_send_vcard_single_contact',function(){
                            	var clientId = $(this).attr('clientid');
                            	$.getJSON(gUrlSnsGetVcardList,{clientId:clientId},function(rst){
                            		var  html='';
                            		if(rst.status == 0){
                            			var maxLen=rst.data.length;
                            			var randParam = '&rand='+Math.random();
                            			for(var i=0;i<maxLen;i++){
                            				var obj = rst.data[i];
                            				var pic = obj.picture?(obj.picture+randParam):gPublic+'/images/default/cards_list_img.png';
                            				html += '<li vcardid="'+obj.vcardid+'" class="hand"><img src="'+pic+'" /></li>';
                            			}
                            		}
                            		
                    				var scrollObj = $('.cls_send_card_pic_ul');
                    				//滚动条生效后不再执行
                    	        	if(!scrollObj.hasClass('mCustomScrollbar')){
                    	        		scrollObj.html(html);
                    	        		scrollObj.mCustomScrollbar({
                    				        theme:"dark", //主题颜色
                    				        autoHideScrollbar: false, //是否自动隐藏滚动条
                    				        scrollInertia :0,//滚动延迟
                    				        horizontalScroll : false//水平滚动条
                    				        
                    				    });
                    	        	}else{
                    	        		scrollObj.find('.mCSB_container').html(html)
                    	        	}
                            	});
                            });
                            
                            $('.cls_send_card_pic_ul').on('click','li',function(){
                            	var thisObj = $(this);
                            	if(thisObj.hasClass('active') === false){
                            		thisObj.addClass('active');
                            		thisObj.siblings().removeClass('active');
                            	}
                            });
                            
            				
                            // 自设关闭
                            $('.cardlistClose').on('click', function () {
                            	$('.snsSendVcardPop,.snsmask_pop').hide();
                                thisObj.removeClass('active');
                            });
                            // 发送名片确定事件
                            $('.cardlistSubmit').on('click', function () {
                                if ($('.cls_send_card_pic_ul li.active').length != 0) {
                                    var vcardid = $('.cls_send_card_pic_ul .active').attr('vcardid');
                                    //$.sns_common.ajaxCard(vcardid); //update by zp
                                    var opts = {vcardId:vcardid,
                                    		uploadType: $.WebChat.CONST.RESOURCE_CUSTOM.VCARD,
                                    		 customType: $.WebChat.CONST.RESOURCE_CUSTOM.VCARD
                                    };
                                    $.WebChat.ajaxUploadCustom(opts);
                                    $('.cardlistClose').click();
                                } else {
                                    $.global_msg.init({msg:js_unselectCard, icon: 0, time: 3});
                                }                                
                            });
                            // 绑定单击事件
                           /* $('.SNSBusiness_content_middle').on('click', '.contactCardList', function () {
                                $('.contactCardList').removeClass('active');
                                $(this).addClass('active');
                            });*/
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                           $.bug(1) && console && console.log(XMLHttpRequest, textStatus, errorThrown);
                        }

                    });
                });
    
                //回车发送消息,暂时注释掉
                /*$('#contentEditor').on('click',function(){
                	document.onkeydown = function(e){
                	    var ev = document.all ? window.event : e;
                	    if(ev.keyCode==13) {
                	    	$('.send_message').click();
                	    }
                	}
                });*/
                //美化选择框
                //$.CheckBoxReplace.init({'selector':'input[type="checkbox"]'});
                //消息框操作
                $('.snsiconzone_liaot').on('click', '.snsiconzone_liaot_icon', function () {
                    var css = $('.snsiconzone_liaot_c').css('display');
                    if (css == 'none') {
                        $('.snsiconzone_liaot_c').show();
                    } else {
                        $('.snsiconzone_liaot_c').hide();
                    }
                });
                //消息框操作滑过事件特效
                $('.snsiconzone_liaot_cont').on('mouseover', '.setTalk', function () {
                    $(this).addClass('active');
                    $(this).siblings().removeClass('active');
                });
                //清空聊天记录
                $('.snsiconzone_liaot_cont').on('click', '.clearTalk', function () {
                    $.global_msg.init({msg:js_delhistory, btns: true, gType: 'confirm',
                        fn: function () {
                            $.sns_common.clearTalk();
                        }
                    });

                });
                //清空聊天记录并退出（删除并退出群组事件）
                $('.snsiconzone_liaot_cont').on('click', '.clearOut', function () {
                    $.global_msg.init({msg:js_quitgroup, btns: true, gType: 'confirm',
                        fn: function () {
                         //   $.sns_common.clearTalk();
                            $.sns_common.clearOut();
                            $.WebChat.closeChatDialogALeft();// $('.close_btn').click();
                        }
                    });
                });       
                
                //联系人、群组、公众号单个用户的点击事件(打开聊天弹出框、聊天对话框)
                $('.cls_total_list').on('click', '.cls_im_single_list', function () { 
                	var thisObj = $(this);
                	$.WebChat.openWebTalk(thisObj);
                });

                //好友请求通知入口
                $('.cls_im_single_notice').click(function(){
                	$.WebChat.friendRequestList($(this));
                });

                //关闭聊天框和空间信息、主菜单移动位置
                $('.close_btn').on('click', function () {
                	$.WebChat.closeChatDialogALeft();
                });

                //表情弹出层
                $('#openFacePop').off('click').on('click', function (event) {
                 	if($('input[name="talkType"]').val() == $.WebChat.CONST.CHAT_TYPE.PUBLIC){
                		return true;
                	}
                 	var thisObj = $(this);
                    var show = $('.hiddenfaces').css('display');
                    if ($('.hiddenfaces').is(':hidden')) {
                    	thisObj.addClass('active');
                    	$('.hiddenfaces').show();
                    	if($('.hiddenfaces').children().length == 0){
                            //点击表情区域外 隐藏表情框
                            $(document).on('click', function (e) {
                            	if($(e.target).attr('id') != 'openFacePop'){
                                    $('.hiddenfaces').hide();
                                    event.stopPropagation();//阻止事件向上冒泡
                                    thisObj.removeClass('active');
                            	}
                            });
                           
                           // event.stopPropagation();
                            $.post(getFacesUrl, {}, function (data) {
                                var html = '<div class="message_title_box"><i class="titlespan">'+gChooseFace+'</i><em class="spantitle_img"><img src="'+gPublic+'/images/icons/message_face_iconcolse.jpg" /></em></div>';
                                html +="<div class='cls_face_content'>"
                                for (var i = 0; i < data.length; i++) {
                                    html += '<span class="select_face"><img src="' + data[i].url + '" tags="' + data[i].tags + '"></span>';
                                }
                                html +='</div><div class="message_point_list_zstub"><img src="'+gPublic+'/images/icons/sns_mapselect.png" /></div>';
                                $('.hiddenfaces').html(html);
                                $.WebChat.myScroll($('.cls_face_content'));
                                /*$.layer({
                                    type: 1,
                                    shade: [0],
                                    area: ['auto', 'auto'],
                                    title: false,
                                    border: [0],
                                    page: {dom: '.hiddefaces'}
                                });*/
                                //选中表情后事件
                                $('.select_face').click(function () {
                                    //$('.hiddenfaces').show();
                                    var html = $(this).html();
                                    var face = $(this).children('img').attr('tags');
                                    $('#contentEditor').find('.mCSB_container').append(html);//xgm 2015-7-13
                                    //往隐藏输入框插入表情对应的关键词
                                    $('textarea[name="talkContent"]').append(face);
                                });
                            });
                    	}

                    } else {
                        $('.hiddenfaces').hide();
                        thisObj.removeClass('active');
                    }
                });               
                
                //群设置(群组设置、个人设置 、公众号设置)
                $('.iconzone_position_pic').on('click', function () {
                	var talkType = $('input[name="talkType"]').val();
                	var clientid = $('input[name="clientid"]').val();
                	var totalObj = $('#Information_Chat');
                	//群组、公众号是设置模板初始化
                	if(talkType == $.WebChat.CONST.CHAT_TYPE.PUBLIC){
                		//展会设置
                		totalObj.html($('#cln_public_set').children().clone());
                		/*获取展会详情*/
                		$.get(gUrlGetExpoInfo,{id:clientid},function(rst){
                			var dataSet = rst.data;
                			if(rst.status == 0 && typeof(dataSet.expoInfo) != 'undefined'){
                				//设置展会详情、邮箱、电话
                				totalObj.find('.cls_public_desc').html(dataSet.expoInfo.messages);
                				totalObj.find('.cls_public_set_desction').mCustomScrollbar({
	        				        theme:"dark", //主题颜色
	        				        autoHideScrollbar: false, //是否自动隐藏滚动条
	        				        scrollInertia :0,//滚动延迟
	        				        horizontalScroll : false,//水平滚动条
	        				        callbacks:{
	        				            onScroll: function(){} //滚动完成后触发事件
	        				        }
                				});
                				
                				//设置是否接受新消息
                				if(dataSet.receive == 1){
                					totalObj.find('#setReceive').parent('i').addClass('setStick active');
                					totalObj.find('#setReceive').prop("checked", true);
                      			    totalObj.find('#setReceivei').css('color','#f9701f');
                				}                			
                			}
                		},'json');
                		
                		//展会名称与logo
                		var publicSingleObj = $('.publicno_'+clientid);
                		var publicLogo = publicSingleObj.find('.cls_public_single_logo').attr('src');
                		var publicName = publicSingleObj.find('.cls_public_single_name').text();
                		var email = publicSingleObj.attr('email');
                		totalObj.find('.cls_public_logo').attr('src',publicLogo);
                		totalObj.find('.cls_public_comname').text(cutstr_en(publicName,12)).attr('title',publicName);
                		//totalObj.find('.cls_public_comuser').text(cutstr_en(email,18)).attr('title',email);
                		
                   		// 显示群成员页面，关闭其他信息页面
                    	totalObj.find('#crewlist').show().siblings().hide();
                    	totalObj.find('.cls_set_text_label').find('span').removeClass('active');
                        //设置初始化（消息设置等）
                    	totalObj.find('.clear_talk').on('click', function () {
                        	$.global_msg.init({msg:js_delhistory, btns: true, gType: 'confirm',
                                fn: function () {
                                    $.sns_common.clearTalk();
                                }
                            });
                        });
                    	
                        $('#Chatwindow_right').hide(500);
                        $('#Information_Chat').show(500).addClass('sns_message');
                          
                        $.sns_common.bindEvtAfter.setting.operaCheck(totalObj);
                		$.sns_common.bindEvtAfter.setting.setPublicNumber(totalObj);
                		$.sns_common.bindEvtAfter.setting.publicNumEvt(totalObj);
                		
                	}else{//群组、个人设置
                		if(talkType=='talk'){
                			if($('#cln_talk_set').find('.blockList').length<=0){//黑名单html结构的添加
                      			var spanhtml= '<div class="Chatbox_one singleobj blockList"><span class="right_span">'
                      				+'<i class="myphoto_ppic"><input id="setBlock" class="hand checkbox" type="checkbox" name="block"></i>'
                      				+'</span>'
                      				+'<i id="setBlocki" style="color: rgb(51, 51, 51);">'+gImJoinBlack+'</i></div>';
                				$('#cln_talk_set').find('.cls_msg_no_disturb').before(spanhtml);
                			}
                			$('#cln_talk_set').find('.cls_save_to_contacts').remove(); //通讯录html结构的删除
                			totalObj.html($('#cln_talk_set').children().clone());
                		}else{
                			$('#cln_talk_set').find('.set_multiple_choice .blockList').remove(); //黑名单html结构的删除
                  			if($('#cln_talk_set').find('.cls_save_to_contacts').length<=0){//保存到通讯录html结构的添加
                      			var spanhtml= '<div class="Chatbox_one singleobj cls_save_to_contacts"><span class="right_span">'
                      				+'<i class="myphoto_ppic"><input  class="hand checkbox" type="checkbox" name="setToContacts" id="setToContacts"></i>'
                      				+'</span>'
                      				+'<i id="setToContactsi" style="color: rgb(51, 51, 51);">'+gSaveToContacts+'</i></div>';
                				$('#cln_talk_set').find('.cls_msg_no_disturb').before(spanhtml);
                			}
                			var groupH = $('#cln_talk_set').children().clone();
                			totalObj.html(groupH);
                			$.sns_common.bindEvtAfter.setting.bindUpdateAvatar(totalObj);
                		}                		
                		
                    	totalObj.find('#crewlist').show().siblings().hide();// 显示群成员页面，关闭其他信息页面
                    	totalObj.find('.cls_set_text_label').find('span').removeClass('active'); //移除下面的文本标签的选中变黄效果

                    	//调用复选框的选中、取消选中效果                        
                       $.sns_common.bindEvtAfter.setting.operaCheck(totalObj);
                        
                        //判断是否置顶、加入黑名单、消息免打扰
                       // var clientid = $('input[name="clientid"]').val();
                    	//var talkType = $('input[name="talkType"]').val();
                        var groupid = $('input[name="clientid"]').val();
  
                        
                       /* totalObj.find('#setStick').parent('i').removeClass('setStick active');
                        totalObj.find('#setStick').prop("checked", false);
                        totalObj.find('#setSticki').css('color','#333');
              		  	
                        totalObj.find('#setBlock').parent('i').removeClass('setBlock active');
                        totalObj.find('#setBlock').prop("checked", false);
                        totalObj.find('#setBlocki').css('color','#333');
                        
                        totalObj.find('#setToContacts').parent('i').removeClass('setToContacts active');
                        totalObj.find('#setToContacts').prop("checked", false);
                        totalObj.find('#setToContactsi').css('color','#333');
              		  	
                        totalObj.find('#setMsg').parent('i').removeClass('setMsg active');
                        totalObj.find('#setMsg').prop("checked", false);
                        totalObj.find('#setMsgi').css('color','#333');*/
                        $.bug(4) && console && console.log($.WebChat.data.groupAdmin)
                        $.bug(4) && console && console.log(groupid,$.WebChat.data.groupAdmin[groupid])
                        if($.WebChat.data.groupAdmin[groupid] != undefined){
                		  	var sadmin = $.WebChat.data.groupAdmin[groupid].clientid;
                            var dataParam = {clientid: clientid,talkType:talkType,groupid:groupid,sadmin:sadmin};
                            $.post(gUrlStickSet,dataParam ,function(data){
    	                        	  if(data.flag==0){
    	                        		  if(data.groupname!=''){//群组名称
    	                        			  totalObj.find('.cls_set_groupname_row #groupnameInput').val(data.groupname);
    	                        			  totalObj.find('.hiddengroupname').val(data.groupname);
    	                        		  }
    	                        		  if(data.sorting>0){//置顶
    	                        			  totalObj.find('#setStick').parent('i').addClass('setStick active');
    	                        			  totalObj.find('#setStick').prop("checked", true);
    	                        			  totalObj.find('#setSticki').css('color','#f9701f');
    	                        		  }
    	                        		  if(data.status==2){//消息免打扰
    	                        			  totalObj.find('#setMsg').parent('i').addClass('setMsg active');
    	                        			  totalObj.find('#setMsg').prop("checked", true);
    	                        			  totalObj.find('#setMsgi').css('color','#f9701f');
    	                        		  }
    	                        		  if(data.issave==2){//保存到通讯录
    	                        			  totalObj.find('#setToContacts').parent('i').addClass('setToContacts active');
    	                        			  totalObj.find('#setToContacts').prop("checked", true);
    	                        			  totalObj.find('#setToContactsi').css('color','#f9701f');
    	                        		  }
    	                        		  if(data.talkType == 'groupTalk'){
    	                        			  $('.cls_sns_edit_groupname_btn').attr({'sadmin':data.sadmin,'clientid':data.clientid});
    	                        			  $.sns_common.bindEvtAfter.setting.setAdminAuth(totalObj);
    	                        		  }
    	                        	  }
        					  		}
        						); 
                        }else{
                        	$.bug(4) && console && console.log('群管理id数据错误')
                        }

                        
                        //黑名单
                    	//var sobj = totalObj.find('.blockList');
                    	//groupid;//分组id
                    	//clientid;//好友id string类型
                    	//eSetChatOper = is_set_black?2:1;//2位拉黑，1为解除拉黑
                    	//ChatManager(sobj,grouptype,toUserID,eSetChatOper);
                       
                        var imid = $('.contact_zone').attr('clientid');
                        if(typeof($.webim.CONST.BLOCK_LIST[imid]) != 'undefined' && !groupid){
                        	totalObj.find('#setBlock').parent('i').addClass('active'); //setBlock
                        	totalObj.find('#setBlock').prop("checked", true);
                        }
                    	//start 黑名单

                    	/*
                    	$('#setBlocki').parent('i').removeClass('setBlock active');
                    	$('#setBlocki').prop("checked", false);
                    	$('#setBlocki').css('color','#333');*/
                    	//结束黑名单
                    	

                     //   $.sns_global.boxDisplay.chatBox = 'none';
                      //  $.sns_global.boxDisplay.setBox = 'block';
                        $.bug(5) && console && console.log(111,$('#Chatwindow_right').is("visible"))
                        $('#Chatwindow_right').hide();
                        $('#Information_Chat').show(500).addClass('sns_message');//
                        $.bug(5) && console && console.log(222,$('#Chatwindow_right').is("visible"))
                       // var TalkType = $('input[name="talkType"]').val();
                       // var TalkClientID = $('input[name="clientid"]').val();
                     //   var TalkGroupID = $('input[name="groupid"]').val();
                        var fuid = $('input[name="fuid"]').val();
                        //显示对应的操作信息
                        if (talkType == 'talk') {
                        	totalObj.find('.show_piclist,.cls_delete_quit').hide();
                        	totalObj.find('.cls_set_groupname_row').hide();
                        } else if(talkType == 'groupTalk'){
                        	totalObj.find('.cls_set_groupname_row').show();
                        	totalObj.find('.show_piclist,.cls_delete_quit').show();
                        }
                        $.bug(5) && console && console.log(333,$('#Chatwindow_right').is("visible"))
                        if (talkType == 'groupTalk' && (groupid != "" || groupid != undefined || groupid != null)) {
                        	var admClientId = $.WebChat.data.groupAdmin[groupid].clientid; //群管理员id
                            //获取群组成员
                            $.get(sns_groupInitUrl, {gid: groupid, TalkType: talkType,admClientId:admClientId}, function (result) {
                                if (result.data.status == 0) {
                                	//totalObj.find('#crewlist').html('');
                                	totalObj.find('#crewnum').text(result.data.data.numfound);
                                    //$(result.page).insertBefore($('#addNewMemberBtn'));
                                	totalObj.find('#crewlist').html(result.page);
                                	 $.WebChat.myScroll(totalObj.find('#crewlist')); //添加滚动条
                                }
                            },'json');
                        } else if (talkType == 'talk' && (clientid != "" || clientid != undefined || clientid != null)){
                        	var cname = $('#Chatwindow_right .Chatwindow_title .SNS_pop_left').find('b').text();
                            var baseuserid = $('input[name="fuid"]').val();
                            $.bug(5) && console && console.log('baseuserid='+baseuserid);
                            baseuserid = baseuserid ? baseuserid : $.WebChat.vars.allFriends[clientid].fuserid;
                            //单人聊天初始化群组成员
                            $.get(sns_groupInitUrl, {baseuserid:baseuserid,clientid: clientid, cname: cname, TalkType: talkType}, function (result) {
                            	totalObj.find('#crewnum').text(2);
                                //$(result.page).insertBefore($('#addNewMemberBtn'));
                                //$('#crewlist,.friendslist').html(result);
                                
                            	totalObj.find('#crewlist').html(result);
                            },'html');
                        }
                        $.bug(5) && console &&  console.log(888,$('#Chatwindow_right').is("visible"))
                        //结构生成后绑定事件
                        $.sns_common.bindEvtAfter.setting.groupName(totalObj);
                        $.sns_common.bindEvtAfter.setting.saveSetBtn(totalObj);//确定保存按钮 
                        $.bug(5) && console && console.log(999,$('#Chatwindow_right').is("visible"))
                	}
                	 
                	$.sns_common.bindEvtAfter.setting.returnToChat(totalObj,talkType,groupid);//返回
                	//$.sns_common.bindEvtAfter.setting.searchHistory(totalObj); //搜索历史记录        
                	$('.cls_delete_quit').click(function(){//删除并退出,暂时无效
                        $.global_msg.init({msg:js_quitgroup, btns: true, gType: 'confirm',
                            fn: function () {
                                $.sns_common.clearOut(); //退出群组
                                $.WebChat.closeChatDialogALeft();// $('.close_btn').click();
                            }
                        });
                	});
                	totalObj.find('.clear_talk').on('click', function () {//清空聊天内容
                    	$.global_msg.init({msg:js_delhistory, btns: true, gType: 'confirm',
                            fn: function () {
                                $.sns_common.clearTalk();
                            }
                        });
                    }); 
                });
                /*个人、群组设置end*/
            },
            /*所有的绑定事件在这里处理*/
            bindEvent: function(){
            	//聊天窗口里面查看大图
            	$('#talk_box').on('click','.cls_chat_pic',function(){ //#talk_box 出问题了，应该是被谁终止了的
            		var customType = $(this).attr('data-type');
            		var url = $(this).attr('urlOri');
            		var img = "<img src='"+url+"' style='max-width:600px;max-height:360px;display:inline-block;' class='cls_big_img'/>";
            		if(customType == $.WebChat.CONST.RESOURCE_CUSTOM.VCARD && $(this).parents('.sender').size()>0){
            			var jsonData = $(this).attr('jsonData');
            			var jsonLebal = "jsonData='"+jsonData+"'";
            			img += '<i style="text-align:center;"><img class="cls_chat_download_vcard" '+jsonLebal+' style="max-width:600px;max-height:360px;" src="'+gPublic+'/images/icons/SNS_iconimg_Download.png" /></i>';
            			img += '<em style="text-align:center;"><img class="cls_chat_download_vcard" '+jsonLebal+' style="max-width:600px;max-height:360px;" src="'+gPublic+'/images/icons/sns_icon_hezuo.png" /></em>';
            		}
            		//conosle.log(customType,img,url)
            		$('.cls_im_big_img').html(img).css('text-align','center');
                    $('.xubox_layer').css('width','auto');
            		var bigImg = $.layer({
            	                type: 1,
            	                title: false,
            	                time: 0,// 自动关闭时间
            	                area: ['auto', 'auto'],// 层的宽高
            	                bgcolor: '#fff',
            	                border: [0, 0.5, '#000'], //边框[边框大小, 透明度, 颜色]
            	                shade: [0.2, '#000'], //遮罩透明度, 遮罩颜色
            	                shadeClose: true, // 点击遮罩层是否关闭弹出层
            	                closeBtn: [0, false], //去掉默认关闭按钮
            	                fix: true, // 不随滚动条而滚动，固定在可视区域
            	                moveOut: false, // 是否允许被拖出可视窗口外
            	                shift: 'top', // 从上面动画弹出
            	                page:{dom:'.cls_im_big_img'},
            	                end: function(){
            	                } // 层被彻底关闭后进行的操作
            	            });
            	});
            /*	$('#talk_box').on('click','.cls_public_expo_more',function(){//展会名片池
            		$('#publicMoreVcard').show();
            	    $('#Chatwindow_right').hide(500);
                    //$('#Information_Chat').show(500).addClass('sns_message');
            	});*/
            	//显示展会的名片池结构
            	$('#talk_box').on('click','.cls_sns_expo',function(){
            		$.WebChat.showPublicMoreStruct($(this));
            	});
            	$('.clsPublicTab').on('click',function(){/*公众号标签点击后切换*/
            		$('.clsPublicVcardDownload').show();
            		$('.clsPublicCheckAll,.clsPublicCheckNoAll,.clsPublicVcardConform').hide();
            		$.WebChat.tiggerPublicTab($(this));
            	});
            	//点击公众号分组名称打开分组下面的名片列表
            	$('#publicMoreVcardTotal').on('click','.clsPublicGroupName',function(){
            		$.WebChat.trigPublicGroup($(this));
            	});
            	//名片池--点击下载按钮
            	$('#publicMoreVcardTotal').on('click','.clsPublicVcardDownload',function(){
            		$(this).hide();
            		$('.clsPublicCheckAll,.clsPublicCheckNoAll,.clsPublicVcardConform').show();
            		$('#publicMoreVcardTotal').find('.clsPublicVcardSingle').show();
            	});
            	//名片池--点击全选按钮
            	$('#publicMoreVcardTotal').on('click','.clsPublicCheckAll',function(){
            		$('#publicMoreVcardTotal').find('.clsPublicGroupUl:visible').find('.clsPublicVcardSingleCheck:not(.active)').addClass('active');
            	});
            	//名片池--反选
            	$('#publicMoreVcardTotal').on('click','.clsPublicCheckNoAll',function(){
            		var objNoChecked = $('#publicMoreVcardTotal').find('.clsPublicGroupUl:visible').find('.clsPublicVcardSingleCheck:not(.active)');
            		var objChecked = $('#publicMoreVcardTotal').find('.clsPublicGroupUl:visible').find('.clsPublicVcardSingleCheck').filter('.active');
            		objNoChecked.addClass('active');
            		objChecked.removeClass('active');
            	});
            	//名片池--确定按钮....................
            	$('#publicMoreVcardTotal').on('click','.clsPublicVcardConform',function(){
            		$.WebChat.trigPublicVcardOk($(this));
            	});
            	//名片池--点击单个名片的选中与取消选中效果
            	$('#publicMoreVcardTotal').on('click','.clsPublicVcardSingleCheck',function(){
            		$(this).toggleClass('active');
            	});
            	
            	$('#talk_box').on('click','.cls_sns_user_avatar',function(){//点击聊天窗口里面的头像,点击头像，显示名片 头像名片
            		var cid = $(this).parents('.cls_chat_single_msg').attr('cid');
            		if(typeof(cid) == 'undefined') {
            			var url = $(this).attr('src');
            			$.bug(5) && console && console.log(url,  url.indexOf('clientid'),  url.substring(url.indexOf('clientid')+9))
            			if(url.indexOf('clientid') == -1){/*没有找到*/
            				$.bug(1) && console && console && console.log('获取名片数据错误,url= ',url);
            			}else{
            				cid = url.substring(url.indexOf('clientid')+9);
            			}            			    
            		}
            		var frends_name = '';
                    /**获取好友的名片*/
                	$.ajax({
                		 type: "get",
                		 url: gUrlGetUserIndexVcard,
                		 data:   "userId="+cid+'&frends_name='+frends_name,
                		 async:false,
                		 dataType:'json',
                		 success: function(msg){
                			 var img = '';
                			 if(msg.status == 1){//名片已经删除的情况
                				 var picture = gPublic+'/images/default/cards_list_img.png';
                				 img = "<img  width='600px' height='360px' src='"+picture+"'>";
                			 }else	if(msg.is_friends){//好友
                				 var picture = msg.picture;
                				     picture += '&rand='+Math.random();
                				     img = "<img  width='600px' height='360px' src='"+picture+"'>";
                				 var jsonData= JSON.stringify({vcardid:msg.vcardid,timestamp:msg.timestamp,key:msg.key});
                				 var jsonLebal =  "jsonData='"+jsonData+"'";
                				img += '<i style="text-align:center;"><img class="cls_chat_download_vcard cls_this_avatar" '+jsonLebal+' style="max-width:600px;max-height:360px;" src="'+gPublic+'/images/icons/SNS_iconimg_Download.png" /></i>';
                			 }else{//群组非好友
                				 var timestamp = new Date().getTime();  
                				     img = "<img  width='600px' height='360px' src='"+msg.picture+"?time="+timestamp+"' '>"; //cls_chat_download_vcard
                				 	 img += '<i style="text-align:center;" ><img userid="'+cid+'" class="clsJoinFriend hand" style="max-width:600px;max-height:360px;" src="'+gPublic+'/images/icons/sns_icon_hezuo.png" /></i>';
                			 }
                			 
            				 $('.friends_cards').html(img);
                             $('.xubox_layer').css('width','auto');
                     		 var bigImg = $.layer({
                     	                type: 1,
                     	                title: false,
                     	                time: 0,// 自动关闭时间
                     	                area: ['auto', 'auto'],// 层的宽高
                     	                bgcolor: '#fff',
                     	                border: [0, 0.5, '#000'], //边框[边框大小, 透明度, 颜色]
                     	                shade: [0.2, '#000'], //遮罩透明度, 遮罩颜色
                     	                shadeClose: true, // 点击遮罩层是否关闭弹出层
                     	                closeBtn: [0, false], //去掉默认关闭按钮
                     	                fix: true, // 不随滚动条而滚动，固定在可视区域
                     	                moveOut: false, // 是否允许被拖出可视窗口外
                     	                shift: 'top', // 从上面动画弹出
                     	                page:{dom:'.friends_cards'},
                     	                end: function(){
                     	                } // 层被彻底关闭后进行的操作
                     	            });
                		 } 
                	}); 
            	});
            	//发送请求加为好友的邀请
            	$('.MainContentRight_right').on('click','.clsJoinFriend',function(){
            		var userId = $(this).attr('userid');
            		$.global_msg.init({msg:gSnsIsSendFriendRequest,gType:'confirm',btns:true,fn:function(){
                	    $.ajax({  
	            	        type: "post",  
	            	        url: gUrlJoinFriendRequest,
	            	        async: true,
	            	        data: {clientid: userId},
	            	        dataType: 'json',
	            	        success: function(result) { 
	            	        	if(result.status == 0){
	            	        		$.global_msg.init({msg:gSnsFriendRequestSendSucc,icon:1});
	            	        	}else{
	            	        		$.global_msg.init({msg:gSnsFriendRequestSendFail,icon:1});
	            	        	}
	            	        }
            	        });
            			}
            		});

            	});
            	
                //选择传送文件,聊天时上传附件
                $('.cls_im_attach_uploadfile').on('click', function () {
                    //要发送的好友id
                    //var clientid = $('.Chatwindow_title').attr('clientid');
                    //选择上传的文件提交
                    $('input[name="trashmitFile"]').click();
                });
                //上传文件表单触发
                $('.cls_im_mid_menu_part').on('change', '#trashmitFile,#uploadImgField',function (event) {
                	//定义操作类型，不同菜单不同的操作
                	var targets = {
                					'trashmitFile':   'attach',
                					'uploadImgField': 'pic'
                				};
                	var thisObj = $(event.target);
                	var id   = thisObj.attr('id');
                	var opts = {'fileFieldName':id, 'binaryType':targets[id]};
                    var names= $(this).val().split(".");
                    var extentionName = names.pop(names).toLowerCase();// 获取扩展名
                    var allowedExtentionNames = ['gif', 'jpg', 'jpeg', 'png']; // 允许的图片扩展名列表
                    if($.inArray(extentionName, allowedExtentionNames)==-1){
                        $.global_msg.init({msg:gAllowTupian,btns:true});
                        return true;
                    }
                	$.WebChat.ajaxUploadAttach(opts);
                });
                //聊天菜单，发送图片
                $('.cls_im_send_img').on('click', function () {
                	if($('input[name="talkType"]').val() == $.WebChat.CONST.CHAT_TYPE.PUBLIC){
                		return true;
                	}
                    //选择上传的文件提交
                    $('input[name="uploadImgField"]').click();
                });

                //用户保存接收或发送的名片(下载名片)
                $('.cls_im_big_img,.friends_cards').on('click','.cls_chat_download_vcard',function(){
                	var jsonData = $(this).attr('jsonData');
                	var data = JSON.parse(jsonData);
                	var url = gUrlSnsSaveVcard; //下载群里面的名片
                	var tipMsg = gImSaveVcardSucc;
                	if($(this).hasClass('cls_this_avatar')){//更新名片
                		url = gSnsUrlUpdateFriendVcard;
                		tipMsg = gSnsVcardUpdateSucc;
                	}
                	$.post(url,data,function(rtn){
  					   if(rtn.status == 0){
  						  $.global_msg.init({msg:tipMsg, btns:true,icon:1});
  					   }else if(rtn.status == 999010){
  						 $.global_msg.init({msg:gSnsSaveVcardExpired,btns:true,icon:0});
  					   }else{
  						  $.global_msg.init({msg:gSavealreadyhave,btns:true,icon:0});
  					   }
                	},'json');
      
                });
                // 设置个人头像
                $('#Information_Chat').on('click','.Information_pho_qh',function(){/*
                	var fatherObj = $(this).parent('.iInformation_all_list');
                    var clientid = fatherObj.attr('clientid');
                    var selfid = $('input[name=sns_selfid]').val();
                    var frends_name = $(this).next().text();
                    frends_name = $.trim(frends_name);

                    if (selfid != clientid) {
                        *//**获取好友的名片*//*
                    	$.ajax({
                    		 type: "get",
                    		 url: "/Home/Sns/getUserIndexVcard",
                    		 data:   "userId="+clientid+'&frends_name='+frends_name,
                    		 async:false,
                    		 dataType:'json',
                    		 success: function(msg){
                    			 if(msg.is_friends){
                    				 var img = "<img  width='600px' height='360px' src='"+msg.picture+"'>";
                    				 //layer.alert(img,10);
                    				 $('.friends_cards').html(img);
                                     $('.xubox_layer').css('width','auto');
                             		var bigImg = $.layer({
                             	                type: 1,
                             	                title: false,
                             	                time: 0,// 自动关闭时间
                             	                area: ['auto', 'auto'],// 层的宽高
                             	                bgcolor: '#fff',
                             	                border: [0, 0.5, '#000'], //边框[边框大小, 透明度, 颜色]
                             	                shade: [0.2, '#000'], //遮罩透明度, 遮罩颜色
                             	                shadeClose: true, // 点击遮罩层是否关闭弹出层
                             	                closeBtn: [0, false], //去掉默认关闭按钮
                             	                fix: true, // 不随滚动条而滚动，固定在可视区域
                             	                moveOut: false, // 是否允许被拖出可视窗口外
                             	                shift: 'top', // 从上面动画弹出
                             	                page:{dom:'.friends_cards'},
                             	                end: function(){
                             	                } // 层被彻底关闭后进行的操作
                             	            });
                    				 
                    			 }else{
                    				 var timestamp = new Date().getTime();  
                    				 var img = "<img  width='600px' height='360px' src='"+msg.picture+"?time="+timestamp+"' '>";
                    				 $('.friends_cards').html(img);
                                     $('.xubox_layer').css('width','auto');
                             		 var bigImg = $.layer({
                             	                type: 1,
                             	                title: false,
                             	                time: 0,// 自动关闭时间
                             	                area: ['auto', 'auto'],// 层的宽高
                             	                bgcolor: '#fff',
                             	                border: [0, 0.5, '#000'], //边框[边框大小, 透明度, 颜色]
                             	                shade: [0.2, '#000'], //遮罩透明度, 遮罩颜色
                             	                shadeClose: true, // 点击遮罩层是否关闭弹出层
                             	                closeBtn: [0, false], //去掉默认关闭按钮
                             	                fix: true, // 不随滚动条而滚动，固定在可视区域
                             	                moveOut: false, // 是否允许被拖出可视窗口外
                             	                shift: 'top', // 从上面动画弹出
                             	                page:{dom:'.friends_cards'},
                             	                end: function(){
                             	                } // 层被彻底关闭后进行的操作
                             	            });
                    			 }
                    			 //弹出图片
                    			 //$.global_msg.init({msg:img});
                    		 } 
                    	}); 
                    	
                    	//$.global_msg.init({msg:'不能修改别人的头像',btns:true});
                    }else{
                        var sns_selfurl_ok = $('input[name=sns_selfurl_ok]').val();
                        $('input[name=groupHeadTwo]').val('');
                        $('input[name=groupHeadOne]').val('');
                        if (sns_selfurl_ok == 1) {
                            //有头像
                            var selfurl = $('input[name=sns_selfurl]').val();
                            $('#drop_pic_sns').attr('src',selfurl).parent('#big_drop_sns').css({'left':'0px','top':'-40px','opacity':'0.3'});
                            $('#drop_img_sns').attr('src',selfurl).css({'left':'-60px','top':'-60px','position':'absolute'});
                            $('.40img').attr('src',selfurl);
                            $('input[name=personalid]').val(clientid);
                            $('#uphead').attr('type','personal').show();
                            $('#crewlist').hide();
                            $('.Chat_left_cont').hide();
                            $('.Information_btin').hide();
                            $("#big_drop_sns").show();
                            $("#drop_sns").show();
                        }else{
                            // 没有头像
                            $('#drop_pic_sns').attr('src','');
                            $('#drop_img_sns').attr('src','').parent('#drop_sns').hide();
                            $('.Chat_left_cont').show();
                            $('.40img').attr('src',selfurl);
                            $('#uphead').attr('type','personal').show();
                            $('.Information_btin').hide();
                            $('#crewlist').hide();
                        }
                        
                    }
                */});
                $('.Information_Chat').on('click','.SearchChat_title',function(){
                    var imid = $(this).attr('data-id');
                    var type = $(this).attr('data-type');
                    var nindex = $(this).attr('data-nindex');
                    $.ajax({
                    url: '/Home/sns/getHistoryInfoByNindex',
                    type: 'post',
                    dataType: 'json',
                    data: {'imid': imid,'type':type,'nindex':nindex},
                    success: function (dzy) {
                        if(dzy.status == '0') {
                            if(dzy.data.numfound != '0'){
                                var sdj = dzy.data.list;
                                //var mycontacts[imid] = dzy.data.latelycontacts;
                            }else{
                                var sdj = dzy.data.numfound;//xgm
                            }
                            var mycontacts = dzy.data.latelycontacts;
                            mycontactsinfo[imid] = mycontacts;
                            historyInfo[imid] = sdj;
                            variable.sns[imid] = {};
                            variable.sns[imid]['page'] = 1;
                            //最近聊天消息框填入数据
                            $.sns_common.pushBox(sdj,imid); //显示最近聊天的用户对话列表
                            // $.sns_common.pushHistory(imid,sdj,'mycontacts');
                            //消息记录存入数组
                            $('#Chatwindow_right').show(500);
                            $('#Information_Chat').hide(500);
                        } else {
                            $('#talk_box').html('');
                        }
                    },
                    error: function (data) {
                        alert('error');
                    }

                });
                });
            },
            bindEvtAfter:{
            	setting:{/*设置后续绑定事件*/
            		/*公众号设置信息,设置是否接收新消息*/
            		setPublicNumber: function(totalObj){
                	    //群设置页面 确定动作
                		totalObj.find('#btnSetPublicNumber').on('click', function () {
                			var expoId = $('#Chatwindow_right .contact_zone').attr('clientid');
                			$.post(gUrlSetExpoInfo,{id:expoId,type:'setNews'},function(rst){
                				if(rst.status == 0){//设置成功
                					 $.global_msg.init({msg:gImSetSucc,icon:1,endFn:function(){
                             			   //改变聊天窗口和群聊窗口的显隐状态
                                         $.sns_global.boxDisplay.chatBox = 'block';
                                         $.sns_global.boxDisplay.setBox = 'none';
                                         $('#Chatwindow_right').show(500);
                                         $('#Information_Chat').hide(500).removeClass('sns_message');
                                         $.webim.scrollBottom();
                					 }});
                				}else{
                					 $.global_msg.init({msg:gImSetFail,icon:0}); //设置失败
                				}
                			},'json');

                	    });
            		},
            		/*公众号的绑定事件*/
            		publicNumEvt: function(totalObj){
            			var expoId = $('#Chatwindow_right .contact_zone').attr('clientid'); 
            			//取消关注
            			totalObj.find('.cls_cancel_follow').on('click',function(){
            				$.post(gUrlSetExpoInfo,{id:expoId,type:'cancelFollow'},function(rst){
            					if(rst.status == 0){
            						$.global_msg.init({msg:gImCancelFollowSucc,btns:true,icon:1});
            						//取消关注后移除展会列表中当前展会
            						var barObj = $('.publicno_'+expoId).prev('.left_list_A');
            						$('.publicno_'+expoId).remove();
            						barObj.next('.left_list_ul').length == 0 ? barObj.remove() : '';
            						$('.leftbox_'+expoId).remove();//删除聊过天的人列表历史记录
            						$.WebChat.closeChatDialogALeft();//关闭对话框和设置框
            					}else{
            						$.global_msg.init({msg:gImCancelFollwFail,btns:true});
            					}
            				},'json');
            			});
            			//公众号清空聊天数据
            			totalObj.find('.cls_public_clear_content').on('click',function(){
                            $.global_msg.init({msg:js_delhistory, btns: true, gType: 'confirm',
                                fn: function () {
                                	$.post(gUrlSetExpoInfo,{id:expoId,type:'clearHistory'},function(rst){
                    					if(rst.status == 0){
                    						$.global_msg.init({msg:gImClearDataSucc,btns:true});
                    						$('#talk_box').find('.mCSB_container').html('');
                    					}else{
                    						$.global_msg.init({msg:gClearHistoryFail,btns:true});
                    					}
                    				},'json');
                                },
                                noFn:function(){
                                }
                            });
            				
            			});
            			//查看公众号的历史记录
            			totalObj.find('.cls_public_history').on('click',function(){
                            var type = $('input[name="talkType"]').val();
                            var url = $.WebChat.getHistoryUrl(type);
                            $.post(url,{imid:expoId,sort:'desc'},function(result){
                                if (0 == result.status) {
                                    var historyInfo = result.data.list;
                                    var listNum = historyInfo.length;
                                    var html='';
                                    for (var i = 0; i < listNum; i++) {
                                        // 只显示图片或者vcard
                                        if (historyInfo[i].content.jumptype !='text') {                                           
                                            html += "<div class='publicHistoryBox_list'>";
                                            html +="<span class='time'>"+historyInfo[i].content.showtime+"</span>";                                                   
                                            html +="<div class='publicHistoryBox_bgcolor messageLT'>";  
                                            if (typeof historyInfo[i].content.title !='undefined') {
                                                var title = historyInfo[i].content.title;
                                            }else{
                                                var title = ''
                                            }
                                            html +="<span class='namttitle'>"+title+"</span>";
                                            html +="<i>";
                                            if (typeof historyInfo[i].content.coverurl !='undefined') {
                                                html +="<img src='"+historyInfo[i].content.coverurl+"'>";      
                                            }                                                                                             
                                            html +="</i>";
                                            html +="</div>";        
                                            html +="</div>";
                                        }else{
                                        // 显示文字模板
                                        }
                                    };
                                    if(!$('#publicHistoryBox').hasClass('mCustomScrollbar')){
                                        $('#publicHistoryBox').mCustomScrollbar({
                                            theme:"dark", //主题颜色
                                            autoHideScrollbar: false, //是否自动隐藏滚动条
                                            scrollInertia :0,//滚动延迟
                                            horizontalScroll : false,//水平滚动条
                                            callbacks:{
                                                onScroll: function(){}, //滚动完成后触发事件
                                                onTotalScroll:function(){
                                                    var tmpImid = $('#Chatwindow_right .contact_zone').attr('clientid');
                                                    $.sns_common.loadMorePublicHistory(tmpImid);
                                                }
                                            }
                                        });
                                    }
                                    $('#publicHistoryBox').find('.mCSB_container').html(html);
                                }else{
                                    $('#publicHistoryBox').find('.mCSB_container').html('');
                                }
                            })
                            // 获得历史记录
                			//改变聊天窗口和群聊窗口的显隐状态
                            /*$.sns_global.boxDisplay.chatBox = 'block';
                            $.sns_global.boxDisplay.setBox = 'none';
                            $('#Chatwindow_right').show(500);
                            $('#Information_Chat').hide(500).removeClass('sns_message');
                            $.webim.scrollBottom();*/
            				totalObj.find('.cls_public_set_desction').hide();
            				totalObj.find('#publicHistoryBox').show();
            			});
            		},
            		
            		/*复选框的选中、取消选中*/
            		operaCheck: function(totalObj){
                    	totalObj.find('.set_multiple_choice').off('click').on('click', '.singleobj', function (e) {                        	
                        	var thisHtml = $(this).find('.myphoto_ppic');
                        	var flag_id = thisHtml.find('.checkbox').attr('id');
                        	var click_id = $(e.target).prop('id');
                        	//标记为修改项
                            thisHtml.addClass(flag_id);
                        	if(click_id ==flag_id){
    	                        if (thisHtml.find('#'+flag_id).is(":checked")) {
    	                        	thisHtml.addClass('active');
    	                        	thisHtml.find('.checkbox').prop("checked",true);
    	                        	//$(this).children('i').css('color','#f9701f');
    	                        } else {
    	                        	thisHtml.removeClass('active');
    	                        	thisHtml.find('.checkbox').prop("checked",false);
    	                        	//$(this).children('i').css('color','#333');
    	                        }
                        	}else{
                        		if (thisHtml.find('#'+flag_id).is(":checked")) {
    	                        	thisHtml.removeClass('active');
    	                        	thisHtml.find('.checkbox').prop("checked",false);
    	                        	//$(this).children('i').css('color','#333');
    	                        } else {
    	                        	thisHtml.addClass('active');
    	                        	thisHtml.find('.checkbox').prop("checked",true);
    	                        	//$(this).children('i').css('color','#f9701f');
    	                        }
                        	}
                        });
            		},
            		/*修改群组名称的输入框事件*/
            		groupName: function(totalObj){
                        /**
                         * 群聊名称js触发事件
                         */
            			totalObj.find('input[name="groupnameInput"]').on('focus',function(){
                        	var groupname = totalObj.find('input[name="groupnameInput"]').val();
                        	if(groupname==gImNoNamed){
                        		totalObj.find('input[name="groupnameInput"]').val('');
                        	}
                        });
                        
            			totalObj.find('input[name="groupnameInput"]').on('blur',function(){
                        	var groupname = totalObj.find('input[name="groupnameInput"]').val();
                        	if(groupname==''){
                        		totalObj.find('input[name="groupnameInput"]').val(gImNoNamed);
                        	}
                        });
            		},
            		/*群组个人的搜索历史记录*/
            		/*searchHistory:function(totalObj){
            	        //聊天内容搜索
	            		totalObj.find(".search_chat_content").on('click', function () {
	            	        //切换按钮选中状态
	            	        $(this).addClass('active');
	            	        totalObj.find('.show_piclist').removeClass('active');
	            	        //获取要搜索的聊天ID和类型
	            	        var id = $('#Chatwindow_right .contact_zone').attr('clientid');
	            	        var type = $('input[name="talkType"]').val();
	            	        $.ajax({
	            	            url: sns_showChatHistory,
	            	            type: 'post',
	            	            dataType: 'json',
	            	            data: 'id=' + id,
	            	            success: function (res) {
	            	            	totalObj.find("#otherBox").html(res.data).show().siblings().hide();
	            	            	totalObj.find("#chat_searchId").click(function () {
	            	                	//获取要搜索的聊天ID和类型
	            	                    var id = $('#Chatwindow_right .contact_zone').attr('clientid');
	            	                    var sea_content = $('#chat_searchValue').val();
	            	                    window.searchcontent={page:0};
	            	                    $.ajax({
	            	                        url: sns_getChatHistory,
	            	                        type: 'post',
	            	                        dataType: 'json',
	            	                        data: 'id=' + id + '&content=' + sea_content+'&type='+type+'&page=1',
	            	                        success: function (res) {
	            	                            //滚动条生效后不再执行
	            	                        	if(!$('.SearchChat_Chat_c').hasClass('mCustomScrollbar')){
	            	                        		$(".SearchChat_Chat_c").html(res.data);
	            	                        		//美化滚动条
	            	            					$('.SearchChat_Chat_c').mCustomScrollbar({
	            	            				        theme:"dark", //主题颜色
	            	            				        autoHideScrollbar: false, //是否自动隐藏滚动条
	            	            				        scrollInertia :0,//滚动延迟
	            	            				        horizontalScroll : false,//水平滚动条
	            	            				        callbacks:{
	            	            				            onScroll: function(){}, //滚动完成后触发事件
	            	            				            onTotalScrollBack: function(){//当滚动到底部的时候调用这个自定义回调函数
	            	            				            	//加载更多聊天记录
	            	            				            	searchcontent.page++
	            	            				            	//$.sns_common.searchContentPage(window.searchcontent.page,id,sea_content,type);
	            	            				            	var searpate = parseInt(window.searchcontent.page)+1;
	            	            				            	if(res.sum_page>=searpate){
		            	            				            	$.ajax({
		            	            				            		 type: "post",
		            	            				            		 url:sns_getChatHistory,
		            	            				            		 dataType: 'json',
		            	            				            		 data: 'id=' + id + '&content=' + sea_content+'&type='+type+'&page='+searpate,
		            	            				            		 success: function(res1){ 
		            	            				            			 $(".SearchChat_Chat_c #mCSB_5_container").append(res1.data);
		            	            				            		 } 
		            	            				            		});
	            	            				            	}
	            	            				            }
	            	            				        }
	            	            				    });
	            	                        	}else{
	            	                        		$(".SearchChat_Chat_c .mCSB_container").html(res.data);
	            	                        	}
	            	                        	//历史记录搜索关键字高亮显示
	            	                        	$('.cls_im_history_content').each(function(){
	            	                        		var obj = $(this);
	            	                        		var keyword = $.trim($('#chat_searchValue').val());
	            	                        		var content = obj.html();            	                        		
	            	                        		var regFace = /\[f\d{3}\]/g; //表情正则表达式
	            	                        		var faceArr = content.match(regFace); //获取内容中所有的表情数组
	            	                        		var regKwd = new RegExp('('+keyword+')','gi');//搜索关键字正则表达式
	            	                        		 
	                                                var sea_content = $('#chat_searchValue').val();
	                                                if('' !=$.trim(sea_content)) {
	                                                    if(faceArr != null){
	                                                        var contentArr = content.split(regFace); //所有内容按照表情进行分割
	                                                        var len = contentArr.length;
	                                                        var newContent = '';
	                                                        for(var i=0;i<len;i++){
	                                                            //对搜索的关键字进行高亮显示
	                                                            if(contentArr[i] != ''){
	                                                                newContent += contentArr[i].replace(regKwd,'<i color="#F9701F">$1</i>');
	                                                            }
	                                                            if(typeof(faceArr[i]) != 'undefined'){
	                                                                //拼接上表情符号表达式
	                                                                newContent += faceArr[i];
	                                                            }
	                                                        }
	                                                        content = newContent;
	                                                    }else{
	                                                        // content = $.WebChat.dealWithTrimShow(content);                                                                                                                
	                                                        content = content.replace(regKwd,'<i color="#F9701F">$1</i>');                                            
	                                                    }
	
	                                                }else{
	                                                    content = $.WebChat.dealWithTrimShow(content);
	
	                                                }    
	            	                        		content = $.WebChat.dealWithTrimShow(content);
	                                                content = $.WebChat.dealWithFaceShow(content); //对内容中的表情进行显示转移处理
	            	                        		obj.html(content)
	            	                        	});
	            	                        },
	            	                        error: function (res) {
	            	                            console && console.log('error',res);
	            	                        }
	            	                    });
	
	            	                });
	            	            },
	            	            error: function (res) {
	
	            	            }
	            	        });
	            	 });
            	},*/
            	/*设置中群组、个人的保存按钮事件*/
            	saveSetBtn:function(totalObj){
            	    //个人、群设置页面 确定动作
            		totalObj.find('#groupCreateBtn').on('click', function () {
            	        var talkType = $('input[name="talkType"]').val();
            	        var talkClientID = $('input[name="clientid"]').val();
            	        var talkGroupID = $('input[name="groupid"]').val(); //后续要去掉这个垃圾变量
            	        $.bug(5) && console && console.log('talkType='+talkType,'talkClientID='+talkClientID,'talkGroupID='+talkGroupID)
            	        //群组设置相关
            	        if (talkType == 'groupTalk' ){ //&& (talkGroupID != "" || talkGroupID != undefined || talkGroupID != null)
            	        //单聊转变为群聊设置
            	        } else if (talkType == 'talk' ) { //&& (talkClientID != "" || talkClientID != undefined || talkClientID != null)
            	        	var groupname = '', mids = '', NewChecked = totalObj.find('#NewChecked').val();
            	            if (NewChecked != null && NewChecked != '') {
            	            	totalObj.find('#crewlist .iInformation_all_list').each(function (i, o) {
            	                    if (i < 5)
            	                        groupname += $(o).find('.Information_text').html() + ',';
            	                    mids += $(o).attr('memberid') + ',';

            	                });
            	                groupname = groupname.substring(0, groupname.length - 1);
            	                //群组名称 [单聊 是否改动初始值，改动则取其值]
            	                var zonename = $('#Chatwindow_right .Chatwindow_title .SNS_pop_left').find('b').text() 
            	                var setgroupname = totalObj.find('.cls_set_groupname_row #groupnameInput').val();
            	                    groupname = zonename != setgroupname ? setgroupname : groupname;

            	                    mids = mids.substring(0, mids.length - 1);
            	                if (groupname != null && mids != null && NewChecked != null) {
            	                	$.post(createGroupUrl, {name: groupname}, function (result) {
            	                        if (result.status == '0') {
            	                            //群组添加联系人
            	                            $.post(addGroupContacts, {groupid: result.data['groupid'], memberid: mids}, function (res) {
            	                                if (res.status == '0') {
            	                                    //最近联系列表中加入群组
            	                                    $('input[name="talkType"]').val('groupTalk');
            	                                    $('input[name="clientid"]').val(result.data['groupid']);
            	                                    $('input[name="groupid"]').val(result.data['groupid']);
            	                                    $('.setGroupTalk').show();

            	                                    $('#Information_Chat').hide();
            	                                    $('.left_list_box').show().siblings().hide();

            	                                } else {
            	                                    layer.msg(js_addgroupmemFail);
            	                                    return true;
            	                                }
            	                            })
            	                        } else {
            	                            layer.msg(result.msg);
            	                            return true;
            	                        }
            	                    });
            	                } else {
            	                    layer.msg(js_addgroupmemOr);
            	                    return true;
            	                }
            	            }
            	        }
            	        
            	        //所有成员拼接
            	        var custom_member = '';
            	        $('.newfiends .iInformation_all_list').each(function(){//应该是新添加的群组成员
        	            	custom_member += $(this).attr('memberid');
        	            });
            	        //更新单聊 群组信息
            	        talkType = $('input[name="talkType"]').val();
            	        talkClientID = $('input[name="clientid"]').val();
            	        talkGroupID = $('input[name="groupid"]').val();
            	        var new_stick = $('#usermid').text();
            	        if(new_stick!=''){
            	        	new_stick = new_stick.substr(0,new_stick.length-1);
            	        	new_stick = ','+new_stick;
            	        }
            	        
            	        var str_stick_id = talkClientID+new_stick;
            	        
            	        var groupNameOld = totalObj.find('.hiddengroupname').val();
            	        var groupNameNew =  totalObj.find('#groupnameInput').val(); //.Information_tname 
            	        imSetup(talkType, str_stick_id, talkGroupID, groupNameOld, groupNameNew);
            	    });
            	},
            	returnToChat: function(totalObj,TalkType,groupid){
            		totalObj.find('.Chat_title_img,.cls_set_public_return').on('click', function () {
                        //改变聊天窗口和群聊窗口的显隐状态
                        $.sns_global.boxDisplay.chatBox = 'block';
                        $.sns_global.boxDisplay.setBox = 'none';
                        $('#Chatwindow_right').show(500);
                        $('#Information_Chat').hide(500).removeClass('sns_message');
                        $.webim.scrollBottom();
                    });
            	},
            	//名片池返回到对话框
            	publicPoolReturnToChat: function(){
            		$('#publicMoreVcardTotal').find('.cls_public_pool_return').on('click', function () {
                        //改变聊天窗口和群聊窗口的显隐状态
                        $.sns_global.boxDisplay.chatBox = 'block';
                        $.sns_global.boxDisplay.setBox = 'none';
                        $('#Chatwindow_right').show(500);
                        $('#Information_Chat').hide(500).removeClass('sns_message');
                        $('#publicMoreVcardTotal').hide(); //隐藏名片池弹出层
                        $.webim.scrollBottom();
                    });
            	},
            	bindUpdateAvatar: function(totalObj){//绑定修改群头像事件
            	    totalObj.off('click').on('click', '.show_piclist',function (){
            	    	//切换按钮选中状态
            	       // $('#otherBox').hide();
            	        var groupid = $("input[name=clientid]").val();
            	        $("input[name=snscut_ratio]").val(1);//设置为1 原图大小
            	        $('.suofang_midd_qiu').css('left','45px');//滑动条滑动到原图大小
            	        $('#drop_sns').show();//截图视区显示
            	        $(this).addClass('active');
            	        $('.search_chat_content').removeClass('active');
            	        $('#uphead').attr('type','group').show();
            	        $('#crewlist').hide();
            	        $("input[name=personalid]").val('');
            	        // 将个人设置为空
            	        // $('input[name=sns_selfid]').val('');
            	        // 图片大小
            	        $('#drop_img_sns,#drop_pic_sns').css({'width':'auto','height':'auto','left':'0px','top':'0px'});
            	        //如果
            	        $('input[name=groupHeadTwo]').val('');
            	        $('input[name=groupHeadOne]').val('');
            	        $.ajax({
            	            url:sns_getGroups,
            	            type:'post',
            	            dataType:'json',
            	            data:{'groupid':groupid},
            	            success: function(res){
            	                if (res.headOk) {
            	                    $('#big_drop_sns').children('img').attr('src',res.headurl);//拖拽窗口
            	                    $('#drop_sns').children('img').attr('src',res.headurl);//裁窗口
            	                    $('.Chat_left_cont').hide();
            	                    $('.40img').attr('src',res.headurl);
            	                    $('.Information_btin').hide();
            	                    // $('#drop_sns').hide();
            	                }else{
            	                    var imgUrl = gUrlGetHead;
            	                    $('#big_drop_sns').children('img').attr('src','');//拖拽窗口
            	                    $('#drop_sns').hide();
            	                    $("#big_drop_sns").hide();
            	                    $('.Chat_left_cont').show();
            	                    $('.40img').attr('src',gUrlGetHead);
            	                    $('.Information_btin').show();
            	                }
            	            }
            	        })
            	        return true;//old false
            	    });
            	    
                    //设置群头像添加
                    $('#Information_Chat').on('change input','#snsTwoHead',function(){
                        $.sns_common.ajaxSnsHead();
                    });
                    //设置群头像2,添加|修改
                    $('#Information_Chat').on('change input','#snsOneHead',function(){
                        $.sns_common.ajaxSnsHead('update');
                    });
                    //提交裁剪后的图片信息
                    $('#Information_Chat').on('click','.Information_btin_b',function(){
                    	$.WebChat.uploadGroupAvatar();
                    });  
                     //取消上传头像
                    /*$('#Information_Chat').on('click','.Information_btin_q',function(){
                        $('#crewlist').show().siblings().hide();
                    });*/
            	},
            	/*设置管理员权限,可以修改群组名称与头像*/
            	setAdminAuth: function(totalObj){
            		  var obj = $('.cls_sns_edit_groupname_btn');
               		  if(obj.attr('sadmin') == obj.attr('clientid')){/*是管理员*/
        				  $('.show_piclist,.cls_sns_edit_groupname_btn').show();
        			  }else{
        				  $('.show_piclist,.cls_sns_edit_groupname_btn').hide();
        			  }        			  
            		  totalObj.on('click','.cls_sns_edit_groupname_btn',function(){
            			  var thisObj = $(this);
                   		  if(thisObj.attr('sadmin') == thisObj.attr('clientid')){/*是管理员*/
            				  $('#groupnameInput').prop('disabled',false);
            			  }else{
            				  $('#groupnameInput').prop('disabled',true);
            			  }
            		  });
            	}
              },
              operaFr: function(){//绑定对好友请求同意与拒绝的处理
            	  $('.cls_friend_request_content').on('click','.cls_fq_set_opera',function(){
                      var _this = $(this);
            		  var thisObj = $(this);
            		  var messageid = thisObj.attr('mid');
            		  var act = 'deny';
            		  if(thisObj.attr('type') == 1){
            			  act = 'access';
            		  }
            		  $.post(gUrlSnsSetFriendRequest,{messageid:messageid,act:act,type:'friend'},function(result){
                        if(result.status==1){
                            var pre = _this.prev();
                            var html = '&nbsp;&nbsp; <span class="span_bint yuanjiao_input clsRequestSes">'+gSnsReqChat+'</span>';
                            _this.remove();
                            pre.after(html);
                        }else{
                            $.global_msg.init({title:false, gType: 'alert', msg: result.msg, icon: 0, time: 3 });
                        }
            		  });
            	  });
            	  
                  /**
                   * 从好友请求列表中打开聊天对话框
                   */
                  $('.cls_friend_request_content').on('click','.clsRequestSes',function(){
                  	var imid = $(this).parents('.friend_request_dl').attr('req_imid');
                  	$('.contact_'+imid).trigger('click');
                  });
              }
            },
            mapSearch: function(map){//显示地图搜索后的列表模板
                var options = {
                        onSearchComplete: function (results) {
                            if (local.getStatus() == BMAP_STATUS_SUCCESS) {
                                // 判断状态是否正确      
                                var s = [], max=results.getCurrentNumPois(), currObj=null;
                                for (var i = 0; i < max; i++) {
                                	currObj = results.getPoi(i);
                                    s.push('<li class="hand" lat=' + currObj.point.lat + ' lng=' + currObj.point.lng + '><span class="left_span"><i>' + currObj.title + '</i><em>' + currObj.address + '</em></span><span class="right_span"><i class="myphoto_ttwo"></i></span></li>');
                                }
                				var scrollObj = $('#map_point_list');
                				//滚动条生效后不再执行
                	        	if(!scrollObj.hasClass('mCustomScrollbar')){
                	        		scrollObj.html(s.join(''));
                	        		scrollObj.mCustomScrollbar({
                				        theme:"dark", //主题颜色
                				        autoHideScrollbar: false, //是否自动隐藏滚动条
                				        scrollInertia :0,//滚动延迟
                				        horizontalScroll : false//水平滚动条
                				        
                				    });
                	        	}else{
                	        		scrollObj.find('.mCSB_container').html(s.join(''))
                	        	}
                            }
                        }
                    };
                var local = new BMap.LocalSearch(map, options, {renderOptions: {map: map}});
                return local;
            },
            //  
            showPosition: function () {
                var lng = arguments[0] ? arguments[0] : '';
                var lat = arguments[1] ? arguments[1] : '';
                var mapid = arguments[2] ? arguments[2] : '';
                var map2 = new BMap.Map(mapid);
                var point2 = new BMap.Point(lng, lat);
                map2.centerAndZoom(point2, 16);
                var marker2 = new BMap.Marker(point2);// 创建标注
                map2.addOverlay(marker2);             // 将标注添加到地图中
                marker2.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
            },

            /* 上传群组头像 */
            ajaxSnsHead: function(){
                var type = arguments[0] ? arguments[0] : 'add';     //上传 OR 更新
                var names= (type == 'update') ? $("#snsOneHead").val().split(".") : $("#snsTwoHead").val().split(".");
                var extentionName = names.pop(names).toLowerCase();// 获取扩展名
                var html = '';
                var allowedExtentionNames = ['gif', 'jpg', 'jpeg', 'png']; // 允许的图片扩展名列表
                if($.inArray(extentionName, allowedExtentionNames)==-1){
                    $.global_msg.init({msg:gAllowTupian,btns:true});
                    return true;
                }
                $("#ajaxGroupHead").submit();
            },
            // 上传图片后-回调函数
            callBack: function(message,success,imgPath){
                if(success=='0'){
                } else {
                    var is_default = $('.sns_unHead').children('img').attr('src');
                    if(is_default==undefined){
                        is_default = 'cardPackage_iconimgbg.png';
                    }
                    var is_default_flag = is_default.indexOf('cardPackage_iconimgbg.png');
                    $('.Information_btin').show();
                    $('input[name="snsimagePath"]').val(imgPath);
                    // $(".uploading").hide();
                    //新建 和  修改
                    // 判断是不是个人的
                    var selfid = $('input[name=sns_selfid]').val();
                    var selfurl = $('input[name=sns_selfurl]').val();
                    var img = '';
                    if (selfid) {
                        // message = selfurl;
                    }
                    if(is_default_flag != -1){
                        $('#big_drop_sns').html('<img src="'+message+'" onload="$.sns_common.PicInit(this)" id="drop_pic_sns">').css({opacity: 0.3, background: "#eee", width: 360 + "px", height: 360 + "px"});
                        $('#drop_sns').html('<img src="'+message+'" onload="$.sns_common.PicInit(this)" id="drop_img_sns">');
                        $('#drop_sns').show();   //遮罩层和修改按钮 显示
                        $("#big_drop_sns").show();//大图片背景图片显示
                        $('#snsdrop_img').attr('src',message);
                        $('input[name="snsimgurl"]').val(message);
                        //联动头像缩略图
                        $(".40img").attr("src",message);//小图
                    }
                    else{
                        $('#big_drop_sns').html('<img src="'+message+'" onload="$.sns_common.PicInit(this)" id="drop_pic_sns">').css({opacity: 0.3, background: "#eee",width: 360 + "px", height: 360 + "px"});
                        $('#drop_sns').html('<img src="'+message+'" onload="$.sns_common.PicInit(this)" id="drop_img_sns">');
                        $('#drop_sns').show();   //遮罩层和修改按钮 显示
                         $("#big_drop_sns").show();//大图片背景图片显示
                        $('#snsdrop_img').attr('src',message);
                        $('input[name="snsimgurl"]').val(message);
                        //联动头像缩略图
                        $(".40img").attr("src",message);//小图
                    }
                    // $('.Chat_big_img').html('<img src="'+message+'" onload="$.sns_common.PicInit(this)" id="drop_sns_pic">').css({opacity: 0.3, background: "#eee"});
                    $('.Chat_left_cont').hide();
                }
            },
            // 拖拽 事件
            /* 头像拖拽裁切初始化 */
                PicInit:function(o){
                    if (o.width < 80) {
                        o.width = 80;
                    };
                    if (o.height < 80) {
                        o.height = 80;
                    };
                    $.sns_common.headPic.picW = $.sns_common.dragHeadPic.picW = o.width;
                    $.sns_common.headPic.picH = $.sns_common.dragHeadPic.picH = o.height;
                  //  console.log(o.width,o.height);
                    //选用区域宽高尺寸
                    var dropTop = $.sns_common.offsetPic.top = parseInt((200 - $.sns_common.needPic.height)/2);
                    var dropLeft = $.sns_common.offsetPic.left = parseInt((200 - $.sns_common.needPic.width)/2);
                    
                    //初始化图片位置  默认居中
                    var dropCoreTop = (200 - parseInt($.sns_common.headPic.picH))/2;
                    var dropCoreLeft = (200 - parseInt($.sns_common.headPic.picW))/2;
                    $('#big_drop_sns').css({top:dropCoreTop + "px", left:dropCoreLeft + "px"});
                    // $('#drop_img_sns').css({width:$.sns_common.needPic.width + "px", height:$.sns_common.needPic.height + "px", top:dropTop + "px", left:dropLeft + "px"});
                    $('#drop_img_sns').css({top:dropCoreTop-dropTop + "px", left:dropCoreLeft-dropLeft + "px"});//确定开始上传后图片位置
                    
                    $("input[name=snstop]").val(dropTop + 1 - dropCoreTop);
                    $("input[name=snsleft]").val(dropLeft + 1 - dropCoreLeft);
                    
                    //拖拽区域限定数据
                    $("#big_drop_sns").data('dropTopMin', parseInt(dropTop) + parseInt($.sns_common.needPic.height) - parseInt($.sns_common.dragHeadPic.picH)  + 1);
                    $("#big_drop_sns").data('dropTopMax', dropTop + 1);    // 1 为css boder宽度
                    $("#big_drop_sns").data('dropLeftMin', parseInt(dropLeft) + parseInt($.sns_common.needPic.width) - parseInt($.sns_common.dragHeadPic.picW) + 1);
                    $("#big_drop_sns").data('dropLeftMax', dropLeft + 1);    // 1 为css boder宽度
                    
                    //遮罩区域拖拽
                    $("#big_drop_sns").draggable({
                            cursor: 'move',                         
                            drag:function(e,ui){
                                $('#drop_sns').show();
                                (ui.position.top < $("#big_drop_sns").data('dropTopMin')) && (ui.position.top = $("#big_drop_sns").data('dropTopMin'));
                                (ui.position.top >= $("#big_drop_sns").data('dropTopMax')) && (ui.position.top = $("#big_drop_sns").data('dropTopMax'));
                                (ui.position.left < $("#big_drop_sns").data('dropLeftMin')) && (ui.position.left = $("#big_drop_sns").data('dropLeftMin'));
                                (ui.position.left >= $("#big_drop_sns").data('dropLeftMax')) && (ui.position.left = $("#big_drop_sns").data('dropLeftMax'));

                                //同时移动内部的图片    
                                var drop_img = $("#drop_img_sns");
                                var top = $("#drop_img_sns").css("top").replace(/px/, "");//取出截取框到顶部的距离
                                var left = $("#drop_img_sns").css("left").replace(/px/, "");//取出截取框到左边的距离
                                drop_img.css({left: parseInt(ui.position.left) - $("#big_drop_sns").data('dropLeftMax') + "px", top: parseInt(ui.position.top) - $("#big_drop_sns").data('dropTopMax') + "px"});

                                //联动缩略图
                                var img40 = $(".40img");
                                // img120.css({"margin-left": parseInt((ui.position.left - $("#image").data('dropLeftMax')) * 120 / $.sns_common.needPic.width ) + "px", "margin-top": parseInt((ui.position.top - $("#image").data('dropTopMax')) * 120 / $.sns_common.needPic.height ) + "px"});
                                // img75.css({"margin-left": parseInt((ui.position.left - $("#image").data('dropLeftMax')) * 75 / $.sns_common.needPic.width ) + "px", "margin-top": parseInt((ui.position.top - $("#image").data('dropTopMax')) * 75 / $.sns_common.needPic.height) + "px"});
                                img40.css({"margin-left": parseInt((ui.position.left - $("#big_drop_sns").data('dropLeftMax')) * 40 / $.sns_common.needPic.width ) + "px", "margin-top": parseInt((ui.position.top - $("#big_drop_sns").data('dropTopMax')) * 40 /$.sns_common.needPic.height) + "px"});

                                $("input[name=snstop]").val($("#big_drop_sns").data('dropTopMax') - parseInt($(this).css("top")));
                                $("input[name=snsleft]").val($("#big_drop_sns").data('dropLeftMax') - parseInt($(this).css("left")));                                 
                            }  
                    });
                    //拖拽区域限定数据
                    $("#drop_img_sns").data('dropTop', dropTop);
                    $("#drop_img_sns").data('dropLeft', dropLeft);
                    $("#drop_img_sns").data('dropTopMin', parseInt($.sns_common.needPic.height) - parseInt($.sns_common.dragHeadPic.picH) + 1);
                    $("#drop_img_sns").data('dropTopMax', 0 + 1);    // 1 为css boder宽度
                    $("#drop_img_sns").data('dropLeftMin', parseInt($.sns_common.needPic.width) - parseInt($.sns_common.dragHeadPic.picW) + 1);
                    $("#drop_img_sns").data('dropLeftMax', 0 + 1);    // 1 为css boder宽度                                
                    //选用区域拖拽
                    $("#drop_img_sns").draggable({
                        cursor: 'move',                         
                        drag:function(e,ui){
                            (ui.position.top < $("#drop_img_sns").data('dropTopMin')) && (ui.position.top = $("#drop_img_sns").data('dropTopMin'));
                            (ui.position.top >= $("#drop_img_sns").data('dropTopMax')) && (ui.position.top = $("#drop_img_sns").data('dropTopMax'));
                            (ui.position.left < $("#drop_img_sns").data('dropLeftMin')) && (ui.position.left = $("#drop_img_sns").data('dropLeftMin'));
                            (ui.position.left >= $("#drop_img_sns").data('dropLeftMax')) && (ui.position.left = $("#drop_img_sns").data('dropLeftMax'));

                            //同时移动div
                            var divimage = $("#big_drop_sns");
                            divimage.css({left: parseInt(ui.position.left + $("#drop_img_sns").data('dropLeft')) + "px", top: parseInt(ui.position.top + $("#drop_img_sns").data('dropTop')) + "px"});
                            //同时移动内部的图片    

                            //联动缩略图
                            var img40 = $(".40img");
                            // img120.css({"margin-left": parseInt(ui.position.left * 120 /$.sns_common.needPic.width ) + "px", "margin-top": parseInt(ui.position.top * 120 /$.sns_common.needPic.height ) + "px"});
                            // img75.css({"margin-left": parseInt(ui.position.left * 75 /$.sns_common.needPic.width ) + "px", "margin-top": parseInt(ui.position.top * 75 /$.sns_common.needPic.height ) + "px"});
                            img40.css({"margin-left": parseInt(ui.position.left * 40 /$.sns_common.needPic.width ) + "px", "margin-top": parseInt(ui.position.top * 40 /$.sns_common.needPic.height ) + "px"});

                            $("input[name=snstop]").val(Math.abs(parseInt($(this).css("top"))));
                            $("input[name=snsleft]").val(Math.abs(parseInt($(this).css("left"))));                                  
                        }     
                    });                            
                    //滑条拖拽
                    $(".suofang_midd_qiu").draggable({
                        cursor: "move", containment: $(".left_suofang_midd"), axis: "x" ,
                        drag: function (e, ui)
                        {
                            //同时显示
                            //同时移动内部的图片    
                            $('#drop_sns').show();
                            var left = parseInt($(this).css("left"));
                            var value = 1 + (left-45) / 100;
                            $("#drop_pic_sns, #drop_img_sns").css({width: parseInt($.sns_common.headPic.picW * value) + "px", height: parseInt($.sns_common.headPic.picH * value) + "px"});
                            //刷新图片宽高值
                            $.sns_common.dragHeadPic.picW = parseInt($.sns_common.headPic.picW * value);
                            $.sns_common.dragHeadPic.picH = parseInt($.sns_common.headPic.picH * value);
                            //刷新缓存数据
                            $.sns_common.offsetData($.sns_common.offsetPic.top, $.sns_common.offsetPic.left);
                            
                            //联动缩略图
                            // var imgW_0 = parseInt($.sns_common.dragHeadPic.picW * 120 /$.sns_common.needPic.width) + "px";
                            // var imgH_0 = parseInt($.sns_common.dragHeadPic.picH * 120 /$.sns_common.needPic.height) + "px";                        
                            // $(".120img").css({width:imgW_0, height:imgH_0});
                            // var imgW_1 = parseInt($.sns_common.dragHeadPic.picW * 75 /$.sns_common.needPic.width) + "px";
                            // var imgH_1 = parseInt($.sns_common.dragHeadPic.picH * 75 /$.sns_common.needPic.height) + "px";
                            // $(".75img").css({width:imgW_1, height:imgH_1});
                            var imgW_2 = parseInt($.sns_common.dragHeadPic.picW * 40 /$.sns_common.needPic.width) + "px";
                            var imgH_2 = parseInt($.sns_common.dragHeadPic.picH * 40 /$.sns_common.needPic.height) + "px";                        
                            $(".40img").css({width:imgW_2, height:imgH_2}); 

                            //图片缩放比例
                            $("input[name=snscut_ratio]").val(value);
                        }
                    });
                    $(".left_suofang_jian").click($.sns_common.bigSmall);
                    $(".left_suofang_jia").click($.sns_common.bigSmall);
                    $.sns_common.thumbPic({top:dropCoreTop, left:dropCoreLeft}, {top:$("#big_drop_sns").data('dropTopMax'), left:$("#big_drop_sns").data('dropLeftMax')}, $.sns_common.needPic);
                },
              //放大缩小按钮
                bigSmall: function(){
                        
                        var size = $(this).attr("id") == "left_suofang_jia" ? 0.01 : -0.01;
                        var value = parseFloat($("input[name=snscut_ratio]").val());
                        var temp = value + size;
                        if (temp < 1.32 && temp > 0.54)
                        {
                                $("#drop_pic_sns, #drop_img_sns").css({width: parseInt($.sns_common.headPic.picW * temp) + "px", height: parseInt($.sns_common.headPic.picH * value) + "px"});
                                //刷新图片宽高值
                                $.sns_common.dragHeadPic.picW = parseInt($.sns_common.headPic.picW * temp);
                                $.sns_common.dragHeadPic.picH = parseInt($.sns_common.headPic.picH * temp);
                                //刷新缓存数据
                                $.sns_common.offsetData($.sns_common.offsetPic.top, $.sns_common.offsetPic.left);

                                //联动缩略图
                                // var imgW_0 = parseInt($.sns_common.dragHeadPic.picW * 120 / $.sns_common.needPic.width) + "px";
                                // var imgH_0 = parseInt($.sns_common.dragHeadPic.picH * 120 / $.sns_common.needPic.height) + "px";
                                // $(".120img").css({width: imgW_0, height: imgH_0});
                                // var imgW_1 = parseInt($.sns_common.dragHeadPic.picW * 75 / $.sns_common.needPic.width) + "px";
                                // var imgH_1 = parseInt($.sns_common.dragHeadPic.picH * 75 / $.sns_common.needPic.height) + "px";
                                // $(".75img").css({width: imgW_1, height: imgH_1});
                                var imgW_2 = parseInt($.sns_common.dragHeadPic.picW * 40 / $.sns_common.needPic.width) + "px";
                                var imgH_2 = parseInt($.sns_common.dragHeadPic.picH * 40 / $.sns_common.needPic.height) + "px";
                                $(".40img").css({width: imgW_2, height: imgH_2});

                                //滑条
                                $(".suofang_midd_qiu").css({left: parseInt($(".suofang_midd_qiu").eq(0).css("left").replace(/px/, "")) + size * 100 + "px"});
                                //缩放比例
                                $("input[name=snscut_ratio]").val((value + size).toString());
                        }                                
                },
                //联动头像缩略图
                thumbPic:function(offset, maxoffset, needPic){
                   // console && console.log(offset,maxoffset)
                    if ($.sns_common.dragHeadPic.picW < $.sns_common.needPic.width) {
                       $.sns_common.dragHeadPic.picW  = $.sns_common.needPic.width
                    };
                    if ($.sns_common.dragHeadPic.picH < $.sns_common.needPic.height) {
                        $.sns_common.dragHeadPic.picH = $.sns_common.needPic.height
                    };
                    var imgW_2 = parseInt($.sns_common.dragHeadPic.picW * 40 /$.sns_common.needPic.width);
                    var imgH_2 = parseInt($.sns_common.dragHeadPic.picH * 40 /$.sns_common.needPic.height);
                    var imgT_2 = parseInt((offset.top - maxoffset.top) * 40 / needPic.height);                            
                    var imgL_2 = parseInt((offset.left - maxoffset.left) * 40 / needPic.width );                             
                    $(".40img").css({width:imgW_2 + "px", height:imgH_2 + "px", "margin-left": imgL_2 + "px", "margin-top": imgT_2 + "px" });
                },
                //缓存各区域偏移数据
                offsetData:function(dropTop, dropLeft){
                    //拖拽区域限定数据 div 遮罩层
                    $("#big_drop_sns").data('dropTopMin', parseInt(dropTop) + parseInt($.sns_common.needPic.height) - parseInt($.sns_common.dragHeadPic.picH)  + 1);
                    $("#big_drop_sns").data('dropTopMax', dropTop + 1);    // 1 为css boder宽度
                    $("#big_drop_sns").data('dropLeftMin', parseInt(dropLeft) + parseInt($.sns_common.needPic.width) - parseInt($.sns_common.dragHeadPic.picW) + 1);
                    $("#big_drop_sns").data('dropLeftMax', dropLeft + 1);    // 1 为css boder宽度  

                    //拖拽区域限定数据
                    $("#drop_img_sns").data('dropTop', dropTop);
                    $("#drop_img_sns").data('dropLeft', dropLeft);
                    $("#drop_img_sns").data('dropTopMin', parseInt($.sns_common.needPic.height) - parseInt($.sns_common.dragHeadPic.picH) + 1);
                    $("#drop_img_sns").data('dropTopMax', 0 + 1);    // 1 为css boder宽度
                    $("#drop_img_sns").data('dropLeftMin', parseInt($.sns_common.needPic.width) - parseInt($.sns_common.dragHeadPic.picW) + 1);
                    $("#drop_img_sns").data('dropLeftMax', 0 + 1);    // 1 为css boder宽度                                  
                },
            // end
            myFun: function (result) {
                map.centerAndZoom(new BMap.Point(result.center.lng, result.center.lat), 18);
                marker = new BMap.Marker(new BMap.Point(result.center.lng, result.center.lat));// 创建标注
                map.addOverlay(marker);             // 将标注添加到地图中
                marker.enableDragging();
                marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
                marker.addEventListener('dragend', function (e) {
                    var geoc = new BMap.Geocoder();
                    geoc.getLocation(e.point, function (rs) {
                        var addComp = rs.addressComponents;
             /*           var options = {
                            onSearchComplete: function (results) {
                                if (local.getStatus() == BMAP_STATUS_SUCCESS) {
                                    // 判断状态是否正确      
                                    var s = [], max=results.getCurrentNumPois(), currObj=null;
                                    for (var i = 0; i < max; i++) {
                                    	currObj = results.getPoi(i);
                                        s.push('<li lat=' + currObj.point.lat + ' lng=' + currObj.point.lng + '><i>' + currObj.title + '</i><em>' + currObj.address + 'b</em></li>');
                                    }
                                    document.getElementById("map_point_list").innerHTML = s.join('');
                                }
                            }
                        };*/
                        var local = $.sns_common.mapSearch(map);;
                        local.search(addComp.city + addComp.district + addComp.street + addComp.streetNumber);

                    });
                });
            },
            //清空聊天内容
            clearTalk: function () {
                var imid = $('#Chatwindow_right .contact_zone').attr('clientid');
                var talkType = $('input[name="talkType"]').val();
                $.post(delGroupTalkUrl,{imid:imid,type:talkType},function(result){
                	if(result.status == '0'){
                		 $.global_msg.init({msg:gImClearDataSucc,icon:1});4
                		 $('#talk_box .mCSB_container').html('');
                		 historyInfo[imid] = [];
                		 //聊天记录被清空，联系人列表中不显示最后一天聊天记录
                		 var opts = {chatDate:''};
                		 $.WebChat.setHisLastTypeValue(imid, '',talkType,opts);
                	}else{
                		$.global_msg.init({msg:result.msg});
                	}
                	$('.snsiconzone_liaot_c:visible') && $('.snsiconzone_liaot_c').hide();//隐藏右上角[清空聊天记录]和[删除并退出]菜单的弹出层
                });
            },
            //退出群组
            clearOut: function () {
            	var groupid = $('#Chatwindow_right .contact_zone').attr('clientid');
                $.webim.leaveGroup(groupid);
            },
            // 修改聊天背景
 /*           snsBackGround: function (result) {
                if (result.status == 1) {
                    //修改背景图
                    $('#talk_box').css('background-image', result.data);
                } else {
                    $.global_msg.init({msg: result.info});
                }
            },*/
            //获取未处理的消息填充到聊天信息框
/*            getNewMessage: function () {
                $.post(untreatedMsgUrl, {}, function (result) {
                    //有新消息做处理填充，没有新消息不做处理
                    if (result.status == '0') {
                        $('.SNS_icon_img span').html(result.num);
                        //判断当前聊天消息框是否存在
                        var contactMsg = $('#Chatwindow_right .contact_zone').attr('contactid');
                        if (contactMsg) {
                            //填充新消息到聊天框
                            var msg = result.data[contactMsg];
                            if (typeof (msg) != 'undefined') {
                                var html = '';
                                for (var i = 0; i < msg.length; i++) {
                                    html += '<div class="left photoi_title">';
                                    html += '<div class="right SNS_pop_photo_c">';
                                    html += '<div class="SNS_pop_img"><img src="' + gUrlGetHead + '?headurl=' + msg[i].clientid + '" /></div>';
                                    html += '<div class="SNS_pop_bg"></div>';
                                    html += '</div>';
                                    html += '<div class="left left_SNSph_pop">';
                                    html += '<div class="border_topbg"></div>';
                                    html += '<div class="border_middlebg"><span>' + msg[i].content + '</span></div>';
                                    html += '<div class="border_bottombg"></div>';
                                    html += '</div>';
                                    html += '</div>';
                                    //每处理一条数据去更新这条数据的状态
                                    $.post(updateMsgUrl, {msgid: msg[i].id}, function (result) {
                                        if (result.status != '0') {
                                        	$.bug(5) && console && console.info(updateMsgFail);
                                        }
                                    })
                                }
                                //计算剩下的未读消息
                                var untreatedMsgNum = parseInt(result.num) - msg.length;
                                $('.SNS_icon_img span').html(untreatedMsgNum);
                                $('#talk_box').append(html);
                                $.webim.scrollBottom();
                            }
                        }
                    }
                });
            },*/
            //置顶的聊天联系人和群组、最近聊过天的人
            getStick: function(){
                  $.ajax({
                	url :gUrlGetStick,
                	async :true,
                	success:function(result){
                		$.webim.CONST.loadStickComplete = 1; //加载左侧列表数据完成
                		
                		$.WebChat.data.stickResult = result;
	                    $.sns_common.genStickContack();
	              		$.webim.getAllFriends();//获取好友列表
                		//$.webim.getAllPublic();
                	},
	                error:function(){}
                });
            },
            //等im登陆成功并且获取置顶结果集完成后再生成结构
            genStickContack: function(){
            	if($.webim.CONST.loadStickComplete == 1 && $.webim.CONST.CONNECTION == true){
            		var result = $.WebChat.data.stickResult;
                    if (result.status == 0) {
                        var arr = result.data.top;                        
                        $.sns_common.genStickHtml(arr); //生成置顶列表结构   
                        //最近联系人,最近聊过天的用户列表
                        var recent = result.data.recent;
                        $.sns_common.genLatelycontacts(recent,gPublic);
                        //滚动条生效后不再执行
                    	if(!$('#recentBox').hasClass('mCustomScrollbar')){
        					$('#recentBox').mCustomScrollbar({
        				        theme:"dark", //主题颜色
        				        autoHideScrollbar: false, //是否自动隐藏滚动条
        				        scrollInertia :0,//滚动延迟
        				        horizontalScroll : false,//水平滚动条
        				        callbacks:{
        				            onScroll: function(){} //滚动完成后触发事件
        				        }
        				    });
                    	}	         
                    	$.WebChat.bindRightMenu(); //右键菜单的绑定事件
                    }
            	}

            },
            /*生成置顶列表结构*/
            genStickHtml: function(arr){
            	var html = '';
            	var doNotNotice = '<i class="clsSnsNotNoticeLebal"><img src="' + gPublic + '/images/icons/SNS_mdarao_icon.png" /></i>'; //免打扰标志
                for(var i in arr){
                	var tmpObj = arr[i];
                	var imid = tmpObj['imid'];
                	$.WebChat.data.stickIds[imid] = ''; //存放置顶数据
                	var groupinfo = '',  personalinfo = '' ,contactclass = '', divid = '';
                	if(tmpObj['talkType']=='groupTalk'){
                		groupinfo = 'imid="'+tmpObj['imid']+'"';
                		divid = 'id ="group_'+tmpObj['imid']+'"';

                        html += '<div class="cls_im_single_list left_list_ul leftbox_' + tmpObj.imid +' '+contactclass+ '" type="'+tmpObj.talkType+'"'+personalinfo+groupinfo+' '+divid+ '>';
                        html += '<div class="marginauto">';
                        html += $.sns_common.getGroupAvatar(tmpObj); //得到群组头像html结构
                        html += '<div class="SNS_pop_bg"></div><div class="SNS_pop_zhiding"></div>';
                        $isHide = '';
                        if(tmpObj.newMsgNum == '0' || tmpObj.newMsgNum == null){
                        	$isHide = ' hide ';
                        	tmpObj.newMsgNum = 0;
                        }
                        html += '</div><div class="SNS_pop_bg_position cls_little_red_tips '+$isHide+'">'+tmpObj.newMsgNum+'</div>';
                        html += '<div class="SNS_pop_text">';
                        	html += '<b title="'+tmpObj.realname +'" data-num="'+tmpObj.membernum+'">' + cutstr_en(tmpObj.realname,$.WebChat.CONST.LEFT_CUT_STR_NUM,'...')+ '('+tmpObj.membernum+')'+'</b>'; 
                        	html += '<p>' +  $.WebChat.getMsgTypeByObj(tmpObj)+ '</p>';
                        html += '</div><div class="SNS_pop_time"><em>'+tmpObj['chatDate']+'</em>'+(tmpObj.status == 2?doNotNotice:'')+'</div>';
                        html += '</div>';
                	}else if(tmpObj['talkType'] == 'talk'){
                		personalinfo = 'imid="'+tmpObj.imid+'" '+ 'headid="'+tmpObj.fuserid+'"';
                		contactclass = 'contact_'+tmpObj.imid;
                        html += '<div class="cls_im_single_list left_list_ul leftbox_' + tmpObj.imid +' '+contactclass+ '" type="'+tmpObj.talkType+'"'+personalinfo+groupinfo+' '+divid+ '>';
                        html += '<div class="marginauto">';
                        html += '<div class="SNS_pop_img SNS_list_ul"><img src="' + gUrlGetHead + '?headurl=' + tmpObj.fuserid + '"></div>';
                        html += '<div class="SNS_pop_bg"></div><div class="SNS_pop_zhiding"></div>';
                        $isHide = '';
                        if(tmpObj.newMsgNum == '0' || tmpObj.newMsgNum == null){
                        	$isHide = ' hide ';
                        	tmpObj.newMsgNum = 0;
                        }
                        html += '</div><div class="SNS_pop_bg_position cls_little_red_tips '+$isHide+'">'+tmpObj.newMsgNum+'</div>';
                        	html += '<div class="SNS_pop_text">';
                        		html += '<b title="'+tmpObj.realname+'">' + cutstr_en(tmpObj.realname,$.WebChat.CONST.LEFT_CUT_STR_NUM,'...') + '</b>'; 
                        		html += '<p>' +  $.WebChat.getMsgTypeByObj(tmpObj)+ '</p>';
                        	html += '</div><div class="SNS_pop_time"><em>'+tmpObj['chatDate']+'</em>'+(tmpObj.status == 2?doNotNotice:'')+'</div>';
                        html += '</div>';
                	}
                	subscribeUserStatus(oo,parseInt(tmpObj.imid));
                	//发送文本消息测试： SendTextMessage(oo,0,0,11590,'&*&**dfdfdfdd','my test content'); 
                	//给群组发送测试消息： SendTextMessage(oo,5,20161,0,'mySeqId','abccc');
                }
                $('.mystick').html(html);
            },
            //最近联系人,最近聊过天的用户
            genLatelycontacts:function(mycontact,gPublic){
            	html = '';
            	var doNotNotice = '<i class="clsSnsNotNoticeLebal"><img src="' + gPublic + '/images/icons/SNS_mdarao_icon.png" /></i>'; //免打扰标志
            	for(var i in mycontact){
            		var tmpObj = mycontact[i];
                	var groupinfo = '';
                	var personalinfo = '';
                	var contactclass = '';
                	var divid = '';
                	imid = ''
                    $isHide = '';
                    if(tmpObj.newMsgNum == '0' || tmpObj.newMsgNum == null){
                    	$isHide = ' hide ';
                    	tmpObj.newMsgNum = 0;
                    }
                 //   var tmpMsg = $.WebChat.getMsgTypeByObj(tmpObj);
                        //$.WebChat.dealWithFaceShow(tmpObj.message); //这两个是有问题的转换，不知道为啥
                    	//tmpMsg = $.WebChat.dealWithTrimShow(tmpMsg);
                    	//tmpMsg == '' ? tmpObj.chatDate='':null;
                	if(tmpObj['talkType'] == 'talk'){
                		groupinfo = 'imid="'+tmpObj['imid']+'"';
                		divid     = 'id ="group_'+tmpObj['imid']+'"';
                		imid      = tmpObj['imid'];
                        html += '<div class="cls_im_single_list left_list_ul leftbox_' + imid +' '+contactclass+ '" type="'+tmpObj.talkType+'"'+personalinfo+groupinfo+' '+divid+ '>';
                        html += '<div class="marginauto">';
                        html += '<div class="SNS_pop_img SNS_list_ul"><img src="' + gUrlGetHead + '?headurl=' + tmpObj.userid + '"></div>';
                        html += '<div class="SNS_pop_bg"></div>';
                        html += '</div><div class="safariborder SNS_pop_bg_position cls_little_red_tips '+$isHide+'">'+tmpObj.newMsgNum+'</div>';
                        html += '<div class="SNS_pop_text">';
                        html += '<b title="'+tmpObj.name+'">' + cutstr_en(tmpObj.name,$.WebChat.CONST.LEFT_CUT_STR_NUM,'...') + '</b>';
                        html += '<p>' + $.WebChat.getMsgTypeByObj(tmpObj) + '</p>';
                        html += '</div>';
                        html += '<div class="SNS_pop_time"><em>'+tmpObj['chatDate']+'</em>'+(tmpObj.status == 2?doNotNotice:'')+'</div>'; //聊天时间与消息免打扰图标
                        html += '</div>';
                	}else if(tmpObj['talkType'] == 'groupTalk'){
                		personalinfo = 'imid="'+tmpObj.imid+'" '+ 'headid="'+tmpObj.userid+'"';
                		contactclass = 'contact_'+tmpObj.imid;
                		imid = tmpObj.imid;
                    
                        html += '<div class="cls_im_single_list left_list_ul leftbox_' + imid +' '+contactclass+ '" type="'+tmpObj.talkType+'"'+personalinfo+groupinfo+' '+divid+ '>';
                        html += '<div class="marginauto">';
                        
                        if (tmpObj.logo) {
                            html += '<div class="SNS_pop_img SNS_list_ul" data-logo="' + tmpObj.iflogo+'"><img src="'+ tmpObj.logo+ '"></div>';
                        // 如果不存在 就是用别人的
                        }else{
                            // 首先判断除了自己还剩几个人
                            if (tmpObj.membernum == 1) {
                                html +='<div class="SNS_pop_img SNS_list_ul" data-logo="' + tmpObj.iflogo+'">'
                                + '<img src="'+ gUrlGetHead+ '?headurl=' + tmpObj.memberinfo[0] + '"/>'
                                + '</div>';
                            }else if (tmpObj.membernum == 2) {
                                html +='<div class="SNS_pop_img SNS_list_ul" data-logo="'+ tmpObj.iflogo+'">'
                                + '<div class="SNS_photo_number" style="position:absolute;margin:0px;">'
                                + '<div class="SNS_photo_num21"><img src="'+ gUrlGetHead+ '?headurl='+ tmpObj.memberinfo[0]+ '" /></div>'
                                + '<div class="SNS_photo_num22"><img src="'+ gUrlGetHead+ '?headurl='+ tmpObj.memberinfo[1]+ '" /></div>'
                                + '</div>'
                                + '</div>';
                            }else if (tmpObj.membernum == 3) {
                                html +='<div class="SNS_pop_img SNS_list_ul" data-logo="' + tmpObj.iflogo +'">'
                                + '<div class="SNS_photo_number" style="position:absolute;margin:0px;">'
                                + '<div class="SNS_photo_num31"><img src="'+ gUrlGetHead+ '?headurl='+ tmpObj.memberinfo[0] + '" /></div>'
                                + '<div class="SNS_photo_num32"><img src="'+ gUrlGetHead+ '?headurl='+ tmpObj.memberinfo[1]+ '" /></div>'
                                + '<div class="SNS_photo_num33"><img src="'+ gUrlGetHead+ '?headurl=' + tmpObj.memberinfo[2] + '" /></div>'
                                + '</div>'
                                + '</div>';
                            }else if(tmpObj.membernum >= 4){
                                html +='<div class="SNS_pop_img SNS_list_ul" data-logo="'+ tmpObj.iflogo +'">'
                                + '<div class="SNS_photo_number" style="position:absolute;margin:0px;">'
                                + '<div class="SNS_photo_num41"><img src="'+ gUrlGetHead+ '?headurl='+ tmpObj.memberinfo[0] + '" /></div>'
                                + '<div class="SNS_photo_num42"><img src="'+ gUrlGetHead+ '?headurl='+ tmpObj.memberinfo[1]+ '" /></div>'
                                + '<div class="SNS_photo_num43"><img src="'+ gUrlGetHead + '?headurl='+ tmpObj.memberinfo[2] + '" /></div>'
                                + '<div class="SNS_photo_num44"><img src="' + gUrlGetHead + '?headurl='+ tmpObj.memberinfo[3]+ '" /></div>'
                                + '</div>'
                                + '</div>';
                            }
                        }
                        // html += '<div class="SNS_pop_img SNS_list_ul"><img src="' + gUrlGetHead+ '?headurl=' + tmpObj.userid + '"></div>';
                        html += '<div class="SNS_pop_bg"></div>';
                        html += '</div><div class="safariborder SNS_pop_bg_position cls_little_red_tips '+$isHide+'">'+tmpObj.newMsgNum+'</div>';
                        html += '<div class="SNS_pop_text">';
                        html += '<b title="'+tmpObj.name+'" data-num="'+tmpObj.membernum+'">' + cutstr_en(tmpObj.name,$.WebChat.CONST.LEFT_CUT_STR_NUM,'...') +' ('+tmpObj.membernum+') '+'</b>';
                        html += '<p>' + $.WebChat.getMsgTypeByObj(tmpObj) + '</p>';
                        html += '</div>';
                        html += '<div class="SNS_pop_time"><em>'+tmpObj['chatDate']+'</em>'+(tmpObj.status == 2?doNotNotice:'')+'</div>';//聊天时间与消息免打扰
                        html += '</div>';
                	}
                	subscribeUserStatus(oo,parseInt(imid))
                }
                $('.mycontacts').html(html);
            },
            getGroupAvatar: function(thisObj){//生成群组头像
            	var html = [];
            	 html.push( '<div class="SNS_pop_img SNS_list_ul" data-logo="'+ thisObj.iflogo +'">');
                if (thisObj.logo) {//群组有自定义头像
                	 html.push( '<img src="'+ thisObj.logo+ '">');
                }else{//群组无自定义头像，头像自动组合而成	
                    if (thisObj.membernum == 1) {
                    	 html.push( '<img src="'+ gUrlGetHead+ '?headurl='+ thisObj.memberinfo[0]+ '"/>');
                    }else if (thisObj.membernum == 2) {
                    	 html.push( '<div class="SNS_photo_number" style="position:absolute;margin:0px;">'
                        + '<div class="SNS_photo_num21"><img src="'+ gUrlGetHead+ '?headurl='+ thisObj.memberinfo[0]+ '" /></div>'
                        + '<div class="SNS_photo_num22"><img src="'+ gUrlGetHead+ '?headurl='+ thisObj.memberinfo[1]+ '" /></div>'
                        + '</div>');
                    }else if (thisObj.membernum == 3) {
                    	 html.push( '<div class="SNS_photo_number" style="position:absolute;margin:0px;">'
                        + '<div class="SNS_photo_num31"><img src="'+ gUrlGetHead+ '?headurl=' + thisObj.memberinfo[0]+ '" /></div>'
                        + '<div class="SNS_photo_num32"><img src="'+ gUrlGetHead+ '?headurl=' + thisObj.memberinfo[1]+ '" /></div>'
                        + '<div class="SNS_photo_num33"><img src="'+ gUrlGetHead+ '?headurl='+ thisObj.memberinfo[2]+ '" /></div>'
                        + '</div>');
                    }else if(thisObj.membernum >= 4){
                    	 html.push( '<div class="SNS_photo_number" style="position:absolute;margin:0px;">'
                        + '<div class="SNS_photo_num41"><img src="'+ gUrlGetHead+ '?headurl='+ thisObj.memberinfo[0]+ '" /></div>'
                        + '<div class="SNS_photo_num42"><img src="' + gUrlGetHead+ '?headurl=' + thisObj.memberinfo[1]+ '" /></div>'
                        + '<div class="SNS_photo_num43"><img src="'+ gUrlGetHead+ '?headurl=' + thisObj.memberinfo[2]+ '" /></div>'
                        + '<div class="SNS_photo_num44"><img src="'+ gUrlGetHead+ '?headurl='+ thisObj.memberinfo[3] + '" /></div>'
                        + '</div>');
                    }
                }
            	 
/*                 if (thisObj.logo) {//群组有自定义头像
                	 html.push( '<img class="snsLazyImg" src="images/background/nav_mune_bg.png" data-original="'+ thisObj.logo+ '">');
                }else{//群组无自定义头像，头像自动组合而成	
                    if (thisObj.membernum == 1) {
                    	html.push( '<img class="snsLazyImg" src="images/background/nav_mune_bg.png" data-original="'+ gUrlGetHead+ '?headurl='+ thisObj.memberinfo[0]+ '"/>');
                    }else if (thisObj.membernum == 2) {
                    	 html.push( '<div class="SNS_photo_number" style="position:absolute;margin:0px;">'
                        + '<div class="SNS_photo_num21"><img class="snsLazyImg" src="images/background/nav_mune_bg.png" data-original="'+ gUrlGetHead+ '?headurl='+ thisObj.memberinfo[0]+ '" /></div>'
                        + '<div class="SNS_photo_num22"><img class="snsLazyImg" src="images/background/nav_mune_bg.png" data-original="'+ gUrlGetHead+ '?headurl='+ thisObj.memberinfo[1]+ '" /></div>'
                        + '</div>');
                    }else if (thisObj.membernum == 3) {
                    	 html.push( '<div class="SNS_photo_number" style="position:absolute;margin:0px;">'
                        + '<div class="SNS_photo_num31"><img  class="snsLazyImg" src="images/background/nav_mune_bg.png" data-original="'+ gUrlGetHead+ '?headurl=' + thisObj.memberinfo[0]+ '" /></div>'
                        + '<div class="SNS_photo_num32"><img  class="snsLazyImg" src="images/background/nav_mune_bg.png" data-original="'+ gUrlGetHead+ '?headurl=' + thisObj.memberinfo[1]+ '" /></div>'
                        + '<div class="SNS_photo_num33"><img  class="snsLazyImg" src="images/background/nav_mune_bg.png" data-original="'+ gUrlGetHead+ '?headurl='+ thisObj.memberinfo[2]+ '" /></div>'
                        + '</div>');
                    }else if(thisObj.membernum >= 4){
                    	html.push( '<div class="SNS_photo_number" style="position:absolute;margin:0px;">'
	                     + '<div class="SNS_photo_num41"><img  class="snsLazyImg" src="images/background/nav_mune_bg.png" data-original="'+ gUrlGetHead+ '?headurl='+ thisObj.memberinfo[0]+ '" clientid="'+ thisObj.memberinfo[0]+ '"/></div>'
	                     + '<div class="SNS_photo_num42"><img  class="snsLazyImg" src="images/background/nav_mune_bg.png" data-original="'+ gUrlGetHead+ '?headurl='+ thisObj.memberinfo[1]+ '" clientid="'+ thisObj.memberinfo[1]+ '"/></div>'
	                     + '<div class="SNS_photo_num43"><img  class="snsLazyImg" src="images/background/nav_mune_bg.png" data-original="'+ gUrlGetHead+ '?headurl='+ thisObj.memberinfo[2]+ '" clientid="'+ thisObj.memberinfo[2]+ '"/></div>'
	                     + '<div class="SNS_photo_num44"><img  class="snsLazyImg" src="images/background/nav_mune_bg.png" data-original="'+ gUrlGetHead+ '?headurl='+ thisObj.memberinfo[3]+ '" clientid="'+ thisObj.memberinfo[3]+ '"/></div>'
	                     + '</div>');
                    }
                }*/
            	 
                html.push('</div>');
                return html.join('');
            },
            /**
             * 生成好友列表结构
             */
            genMenuContackHtml: function(opts){
				$.post(getFriendsUrl,{},function(result) {
					$.WebChat.vars.allFriends = result.friends; //设置好友数据到缓存中
					if (result.status != '0') {
						$.bug(5) && console && console.info('get friends fail');
					} else {
						var data = result.data;
						var html = '',htmlArr=[];
						//var avatarDefault = gPublic+'images/background/nav_mune_bg.png';
						for ( var id in data) {
							var arr = data[id];
							var key = id;
							for ( var i = 0; i < arr.length; i++) {
								id = $.WebChat.changeFirstWord(arr[i].first_k, key);
							}								
/*							html += '<div class="left_list_A"><span>'+ id + '</span></div>';
							var maxLen = arr.length;
							for ( var i = 0; i < maxLen; i++) {
								var tmpObj = arr[i];
								$.WebChat.vars.allTalkType[tmpObj.imid] = 'talk' ; //存储所有类型
								$.WebChat.data.imidUserIds[tmpObj.imid] = tmpObj.fuserid; //存储imid-userId映射关系
								$.WebChat.data.disturbImids[tmpObj.imid] = tmpObj.status; //消息免打扰id列表
								
								friendshead[tmpObj.imid] = tmpObj.fuserid;
								html += '<div class="left_list_ul cls_im_single_list contact_'+ tmpObj.imid
										+ '" headid="'+ tmpObj.fuserid+ '" type="talk" imid="'+ tmpObj.imid + '">';
								html += '<div class="marginauto">';
								html += '<div class="SNS_pop_img SNS_list_ul"><img src="'+gPublic+'/images/background/bk_img_jpg4.jpg"></div>';//'+gUrlGetHead+ '?headurl='+ tmpObj.fuserid+' //好友头像注掉
								html += '<div class="SNS_pop_bg"></div>';
								html += '</div>';
								html += '<div class="SNS_pop_text">';
								html += '<b fuid="'+tmpObj.fuserid+'" title="'+tmpObj.realname+'">'
										+ cutstr_en(tmpObj.realname,$.WebChat.CONST.LEFT_CUT_STR_NUM,'...')
										+ '</b>';
								html += '<p></p>';
								html += '</div>';
								html += '</div>';
								subscribeUserStatus(oo,	parseInt(tmpObj.imid));
							}*/
							
							htmlArr.push('<div class="left_list_A"><span>'+ id + '</span></div>');
							var maxLen = arr.length;
							for ( var i = 0; i < maxLen; i++) {
								var tmpObj = arr[i];
								$.WebChat.data.imidNames[tmpObj.imid] = tmpObj.realname; //imid--名称映射
								$.WebChat.vars.allTalkType[tmpObj.imid] = 'talk' ; //存储所有类型
								$.WebChat.data.imidUserIds[tmpObj.imid] = tmpObj.fuserid; //存储imid-userId映射关系
								$.WebChat.data.disturbImids[tmpObj.imid] = tmpObj.status; //消息免打扰id列表
								
								friendshead[tmpObj.imid] = tmpObj.fuserid;
								htmlArr.push('<div class="left_list_ul cls_im_single_list contact_'+ tmpObj.imid
										+ '" headid="'+ tmpObj.fuserid+ '" type="talk" imid="'+ tmpObj.imid + '">');
								htmlArr.push( '<div class="marginauto">');
								htmlArr.push( '<div class="SNS_pop_img SNS_list_ul"><img src="'+gUrlGetHead+ '?headurl='+ tmpObj.fuserid+'"/></div>');//'+gUrlGetHead+ '?headurl='+ tmpObj.fuserid+' //好友头像注掉
								htmlArr.push( '<div class="SNS_pop_bg"></div>');
								htmlArr.push( '</div>');
								htmlArr.push( '<div class="SNS_pop_text">');
								htmlArr.push( '<b fuid="'+tmpObj.fuserid+'" title="'+tmpObj.realname+'">'
										+ cutstr_en(tmpObj.realname,$.WebChat.CONST.LEFT_CUT_STR_NUM,'...')
										+ '</b>');
								htmlArr.push( '<p></p>');
								htmlArr.push( '</div>');
								htmlArr.push( '</div>');
								subscribeUserStatus(oo,	parseInt(tmpObj.imid));
							}
						}		
						html = htmlArr.join(',');
						$('.im_friends').html(html);//.hide()
						$.WebChat.myScrollTongXunlu('.cls_tab_right_list');//添加滚动条
						$.WebChat.bindRightMenu();
						$.webim.CONST.loadFriendComplete = true;
						$.webim.getAllGroups(); //群组列表
					}
					$.WebChat.outerSourceEnter();//从其他页面进入聊天窗口操作入口
					if(typeof(opts)!='undefined' && typeof(opts.groupFn) == 'function'){
						opts.groupFn();
					}
				});
            },
            /**
             * 生成群组列表结构
             */
            genMenuGroupHtml: function(opts){
            	var flushGroup = (opts == undefined || typeof(opts.flushGroup)=='undefined')?0:opts.flushGroup;
            	var groupIds = '';
            	for(var groupId in $.WebChat.data.groupImids){
            		if(groupIds){
            			groupIds += ','+groupId;
            		}else{
            			groupIds = groupId;
            		}
            	}
            	if(groupIds && $.webim.CONST.NOT_LOADING_GROUP && $.webim.CONST.loadFriendComplete==true){
            		$.webim.CONST.NOT_LOADING_GROUP = false;
    				$.ajax({
    					url: getGroupUrl,
    					data: {flush:flushGroup,groupIds:groupIds},
    					type:'post',
    					dataType: 'json',
    					async: (opts != undefined && typeof(opts.async) != 'undefined')?opts.async:true,
    					success: function(result){
    						$.webim.CONST.NOT_LOADING_GROUP = true;
    						if (result.status != '0') {
    							$.bug(5) && console && console.info('get groups fail');
	    					} else {
	    						var data = result.data;
	    						// 订阅好友，供接口发送接收消息
	/*    						var str = '';
	    						for ( var id in data) {
	    							var arr = data[id];
	    							var tmpLen = arr.length;
	    							var key = id;
	    							for ( var i = 0; i < tmpLen; i++) {
	    								id = $.WebChat.changeFirstWord(arr[i].first_k, key);
	    							}									
	    							str += '<div class="left_list_A"><span>'+ id + '</span></div>';
	    							var maxLen = arr.length;
	    							for ( var i = 0; i < maxLen; i++) {
	    								var tmpObj = arr[i];
	    								$.WebChat.vars.allGroups[tmpObj.imid] = tmpObj;//存放所有的分组数据
	    								$.WebChat.vars.allTalkType[tmpObj.imid] = 'groupTalk' ; //存储所有类型
	    								$.WebChat.data.disturbImids[tmpObj.imid] = tmpObj.status; //消息免打扰id列表
	    								
	    								friendshead[arr[i].imid] = arr[i].cliendid;
	    								str += '<div class="left_list_ul cls_im_single_list contact_'
	    										+ tmpObj.imid+ '" headid="'	+ tmpObj.logo+ '" type="groupTalk" imid="' + tmpObj.imid + '" sorting="'+tmpObj.sorting
	    										+ '">';
	    								str += '<div class="marginauto">';
	    								str += $.sns_common.getGroupAvatar(tmpObj); //得到群组头像html结构
	    								str += '<div class="SNS_pop_bg"></div>';
	    								str += '</div>';
	    								str += '<div class="SNS_pop_text">';
	    								str += '<b fuid="'+tmpObj.imid+'" title="'+tmpObj.name+'" data-num="'+tmpObj.membernum+'">'
	    										+ cutstr_en(tmpObj.name,$.WebChat.CONST.LEFT_CUT_STR_NUM,'...')
	    										+' ('+tmpObj.membernum	+') '+ '</b>';
	    								str += '<p></p>';
	    								str += '</div>';
	    								str += '</div>';
	    								subscribeUserStatus(oo,parseInt(tmpObj.imid));
	    							}
	    						}
	    						$('.im_groups').html(str);*/
	    						var str = [];
	    						for ( var id in data) {
	    							var arr = data[id];
	    							var tmpLen = arr.length;
	    							var key = id;
	    							for ( var i = 0; i < tmpLen; i++) {
	    								id = $.WebChat.changeFirstWord(arr[i].first_k, key);
	    							}									
	    							str.push( '<div class="left_list_A"><span>'+ id + '</span></div>');
	    							var maxLen = arr.length;
	    							for ( var i = 0; i < maxLen; i++) {
	    								var tmpObj = arr[i];
	    								$.WebChat.data.imidNames[tmpObj.imid] = tmpObj.realname; //imid--名称映射
	    								$.WebChat.vars.allGroups[tmpObj.imid] = tmpObj;//存放所有的分组数据
	    								$.WebChat.vars.allTalkType[tmpObj.imid] = 'groupTalk' ; //存储所有类型
	    								$.WebChat.data.disturbImids[tmpObj.imid] = tmpObj.status; //消息免打扰id列表
	    								
	    								friendshead[tmpObj.imid] = tmpObj.cliendid;
	    								str.push( '<div class="left_list_ul cls_im_single_list contact_' + tmpObj.imid+ ' cls_im_word_list_'+id+'" headid="'	+ tmpObj.logo+ '" type="groupTalk" imid="' + tmpObj.imid + '" sorting="'+tmpObj.sorting
	    										+ '">');
	    								str.push( '<div class="marginauto">');
	    								str.push( $.sns_common.getGroupAvatar(tmpObj)); //得到群组头像html结构
	    								str.push( '<div class="SNS_pop_bg"></div>');
	    								str.push( '</div>');
	    								str.push( '<div class="SNS_pop_text">');
	    								str.push( '<b fuid="'+tmpObj.imid+'" title="'+tmpObj.name+'" data-num="'+tmpObj.membernum+'">'
	    										+ cutstr_en(tmpObj.name,$.WebChat.CONST.LEFT_CUT_STR_NUM,'...')
	    										+' ('+tmpObj.membernum	+') '+ '</b>');
	    								str.push( '<p></p>');
	    								str.push( '</div>');
	    								str.push( '</div>');
	    								subscribeUserStatus(oo,parseInt(tmpObj.imid));
	    							}
	    						}
	    						$('.im_groups').html(str.join(''));
	    						if(typeof(opts)!='undefined' && typeof(opts.groupFn) == 'function'){
	    							opts.groupFn();
	    						}
	    						$.WebChat.bindRightMenu();
	    						/*$('.im_groups .snsLazyImg').each(function(){
	    							var obj = $(this);
	    							//var url = obj.attr('data-original');
	    							//obj.attr('src',obj.attr('data-original'));
	    							$.get('/Home/Sns/getImageDataIm',{headurl:obj.attr('clientid')},function(msg){
	    								var data = 'data:image/jpg;base64,'+msg;
	    								obj.attr('src',data);
	    							});
	    						});*/
	    					}
    					// 滚动条生效后不再执行
    					$.WebChat.myScrollTongXunlu('.cls_tab_right_list');
    				}
    				});
            	}
            },
            /**
             * 生成公众号列表结构
             */
            genMenuPublicHmtl: function(opts){
				$.ajax({
					type: 'post',
					url:   getSnsPublicNoUrl,dataType:'json',
					async: typeof(opts.async) == 'undefined' ? true : opts.async,
					success:function(result) {
						$.webim.CONST.loadPublicComplete = 1;
						if (result.status == '1') {
							$.bug(5) && console && console.info('获取关注的公众号列表失败');
						} else {
							var data = result.data;
							// 订阅好友，供接口发送接收消息
							var html = '';
							for ( var id in data) {
								var arr = data[id];
								html += '<div class="left_list_A"><span>'+ id+ '</span></div>';
								for ( var i = 0; i < arr.length; i++) {
									$.WebChat.vars.allPublic[arr[i].numid] = arr[i];//存放所有的分组数据
									$.WebChat.vars.allTalkType[arr[i].numid] = 'publicNumber' ; //存储所有类型
									friendshead[arr[i].imid] = arr[i].cliendid;
									html += '<div class="left_list_ul cls_im_single_list publicno_'
										+ arr[i].numid+ '" type="publicNumber" imid="'+ arr[i].numid+ '" email="'+arr[i].email+'">';
									html += '<div class="marginauto">';
									html += '<div class="SNS_pop_img SNS_list_ul"><img class="cls_public_single_logo" src="'+ arr[i].logo+ '"></div>';
									html += '<div class="SNS_pop_bg"></div>';
									html += '</div>';
									html += '<div class="SNS_pop_text">';
									html += '<b class="cls_public_single_name" fuid="'+arr[i].numid+'" title="'+arr[i].name+'">'+ arr[i].name + '</b>';
									html += '<p></p>';
									html += '</div>';
									html += '</div>';
								}
								$('.im_common').html(html).hide();
							}
							// 滚动条生效后不再执行
							$.WebChat.myScrollTongXunlu('.cls_tab_right_list');
						}
					}
				});
            },
            /**
             * 生成黑名单列表结构
             */
            genMenuBlackListHtml: function(opts){
            	$.bug(5) && console && console.log('黑名单数据列表：',blackList);
            	var friends = $.WebChat.vars.allFriends;
            	var blackList = opts;
            	var data = {};
            	if(friends){
        			for ( var i  in blackList) {
        				if(blackList[i] && typeof(friends[blackList[i]]) != 'undefined'){
        					var userInfo = friends[blackList[i]];
        					var key = $.WebChat.changeFirstWord(userInfo.first_k, userInfo.first_k);
        					if(typeof(data[key]) == 'undefined'){
        						data[key] = [];
        					}
        					var tmpObj = $.extend(true,{},friends[blackList[i]]); //解决共享传递问题
        					tmpObj.isBlack = 1;
        					data[key].push(tmpObj);
        				}        				
					}
        		}
				var html = $.sns_common.genInnerPersonHtml(data);
				$('.im_blacklist').html(html).hide();
				$.WebChat.myScrollTongXunlu('.cls_tab_right_list');//添加滚动条
				//临时数据绑定右键菜单
			    var opts = {'selector':'.im_blacklist .cls_im_single_list'};
				$.WebChat.bindRightMenu(opts);
            },
            genInnerPersonHtml: function(data){
            	var html = '';
				for ( var id in data) {
					var arr = data[id];
					html += '<div class="left_list_A"><span>'+ id + '</span></div>';
					for ( var i = 0; i < arr.length; i++) {
						friendshead[arr[i].imid] = arr[i].cliendid;
						html += '<div class="left_list_ul cls_im_single_list contact_'+ arr[i].imid
								+ '" headid="'+ arr[i].clientid+ '" type="talk" imid="'+ arr[i].imid + '">';
						html += '<div class="marginauto">';
						html += '<div class="SNS_pop_img SNS_list_ul"><img src="'+ gUrlGetHead+ '?headurl='+ arr[i].fuserid+ '"></div>';
						html += '<div class="SNS_pop_bg"></div>';
						html += '</div>';
						html += '<div class="SNS_pop_text">';
						html += '<b fuid="'+arr[i].uid+'" title="'+arr[i].realname+'">'
								+ cutstr_en(arr[i].realname,$.WebChat.CONST.LEFT_CUT_STR_NUM,'...')
								+ '</b>';
						html += '<p></p>';
						html += '</div>';
						html += '</div>';
						subscribeUserStatus(oo,	parseInt(arr[i].imid));
					}
				}
				return html;
            },

            //选择用户聊天
            userTalk: function (imid,name,type,nums){
            	
            	if(typeof(name) == 'undefined' || name == '' ){
            		$.bug(5) && console && console.log('传递过来的群组或个人名称为空哦');
                	//给聊天信息框头部添加属性，填充新信息
                    var newName = $('#group_'+imid).find('.SNS_popgroup_text').children('b').attr('title');
                    if (typeof(newName) == 'undefined') {
                        newName = $('.contact_'+imid).find('.SNS_pop_text').children('b').attr('title');
                    }
                    newName = cutstr_en(newName,$.WebChat.CONST.TOP_CUT_STR_NUM,'...');
                    name = newName ?newName:name;
            	}else{
            		name = cutstr_en(name,$.WebChat.CONST.TOP_CUT_STR_NUM,'...');
            	}

                $('#Chatwindow_right .contact_zone').attr('clientid', imid);
                //发送文件的form表单赋值用户ID
                $('input[name="clientid"]').val(imid);
                
                if(type == 'talk'){
                	var thisHtml = $('.contact_' + imid); //这块会出问题的，可能会存在多个对象，不唯一
                	//获取用户头像
                    var headurl = thisHtml.children('.marginauto').children('.SNS_pop_img').children('img').attr('src');
                    $('#Chatwindow_right .contact_zone').children('.SNS_pop_left').children('b').html(name);
                    //聊天信息框头部头像更新/用户名
                    $('#Chatwindow_right .contact_zone').children('.SNS_pop_left').children('.SNS_pop_img').children('img').attr('src', headurl);
                }else if(type == 'groupTalk'){
                	var thisHtml = $('#group_' + imid);
                	//获取群组头像
                    var headurl = thisHtml.children('.SNS_creategrouppho_img').children('img').attr('src');
                    if(typeof(headurl) == 'undefined' || headurl == ''){
                    	headurl = $('.im_groups .contact_'+imid).find('.SNS_pop_img').html();
                    } 
                    
                    if(typeof(nums) == 'undefined'){
                        var nums = $('#group_'+imid).find('.SNS_popgroup_text').children('b').attr('data-num');
                        if (typeof(nums) == 'undefined') {
                            nums = $('.contact_'+imid).find('.SNS_pop_text').children('b').attr('data-num');
                        };
                    }
                    
                    //聊天信息框头部头像更新/用户名
                    $('#Chatwindow_right .contact_zone').children('.SNS_pop_left').children('.SNS_pop_img').html(headurl);
                    $('#Chatwindow_right .contact_zone').children('.SNS_pop_left').children('b').html(name+'('+nums+')');
                }else if(type == $.WebChat.CONST.CHAT_TYPE.PUBLIC){
                	historyInfo[imid] = undefined;
                    $('#Chatwindow_right .contact_zone').children('.SNS_pop_left').children('b').html(name);
                    //聊天信息框头部头像更新/用户名
                    $('#Chatwindow_right .contact_zone').children('.SNS_pop_left').children('.SNS_pop_img').children('img').attr('src', headurl);
                }

                //判断是否有历史记录存入
                if (historyInfo[imid] == undefined) {
	                var url = $.WebChat.getHistoryUrl(type);//根据类型获取历史记录url地址
                	//获取聊天记录
                    $.post(url, {imid: imid,page:1}, function (dzy) {
                        if(dzy.status == '0') {
	                        var sdj = dzy.data.list;
                        	var mycontacts = dzy.data.latelycontacts;
                        	//mycontactsinfo[imid] = mycontacts;
                            historyInfo[imid] = sdj;
                            variable.sns[imid] = {};
                            variable.sns[imid]['page'] = 1;
                            variable.sns[imid]['numfound'] = dzy.data.numfound;
                            //最近聊天消息框填入数据
                            $.sns_common.pushBox(sdj,imid); //显示最近聊天的用户对话列表
                           // $.sns_common.pushHistory(imid,mycontactsinfo); //显示最近聊天的用户列表
                            $.sns_common.pushHistory(imid,sdj); //显示最近聊天的用户列表
                        } else {
                            $('#talk_box').html('');
                        }
                    },'json');
               } else {
                    //如果数组有存入的消息直接调用
                    var message = historyInfo[imid];
                   // var mycon = mycontactsinfo[imid];
                    var info = {};
                    var array = new Array();
                    array['numfound'] = '1';
                    array['list'] = message;
                    info.status = '0';
                    info.data = array;
                    // info = message;
                    $.sns_common.pushBox(message,imid);
                    // $.sns_common.pushHistory(imid, "'"+info+"'");//xgm
                    $.sns_common.pushHistory(imid, message);//xgm
                    
              }
                $.WebChat.myScroll('#contentEditor');
                $.webim.scrollBottom();
            },

            //最近联系人聊天框的公用方法
            pushHistory: function (imid, message,nums) {
            	$('#Chatwindow_right').show(500);
                //查看置顶消息里是否有当前联系人
            	var leftUserId = $('#recentBox .leftbox_' + imid).attr('imid');
                //历史记录框和置顶消息里没有重新添加，有的话移除重新添加（新消息置顶）
            	var insert = (leftUserId == undefined) ? '0' : '1';
            	$.sns_common.getUserTalk(message, imid, insert);
            	 //临时数据绑定右键菜单
                var opts = {'selector':'#recentBox .leftbox_'+imid};
                $.WebChat.bindRightMenu(opts);
            },
            
            /**
             * 设置最近联系人和置顶联系人的新消息数量(小红点)
             */
            setNewMsgNum: function(fromImim){
                var latestUserId = $('.mycontacts .leftbox_' + fromImim).attr('imid'); //我的最近聊过天的联系人
                //查看置顶消息里是否有当前联系人
                var staticUid = $('.mystick .leftbox_' + fromImim).attr('imid');
               var chatOpenImid = $('#Chatwindow_right .contact_zone').attr('clientid');
               if(typeof(latestUserId) == 'undefined' && typeof(staticUid) == 'undefined'){
            	   $.WebChat.updateBackNewMsgNum(fromImim,1,'add');
            	   return true;
               }else{
            	   var littleRed = $('#recentBox .leftbox_' + fromImim).find('.cls_little_red_tips');
            	   var currNum = parseInt(littleRed.text());
            	   var currNumNew = currNum+1;
            	   (currNumNew>$.WebChat.CONST.NEW_MSG_MAX_NUM || isNaN(currNumNew)) ? (currNumNew = '..') : '';
            	   if(chatOpenImid != fromImim){
            		   littleRed.text(currNumNew);
            		   littleRed.show();
            		   $.WebChat.updateBackNewMsgNum(fromImim,currNumNew,'set');
            	   }else if($('#Chatwindow_right .contact_zone').is(':hidden')){
               		   littleRed.text(currNumNew);
            		   littleRed.show();
            		   $.WebChat.updateBackNewMsgNum(fromImim,currNumNew,'set');
            	   }else{
            		   currNumNew = 0;
            		   littleRed.text(currNumNew);
            		   littleRed.hide();
            		   if(typeof($.WebChat.vars.afterLoginUnreadMsgNum[fromImim]) != 'undefined'){
            			   delete $.WebChat.vars.afterLoginUnreadMsgNum[fromImim];
            		   }
            		   $.WebChat.updateBackNewMsgNum(fromImim,currNumNew,'set');
            	   }
               }               
            },
            /**
             * 获取和某个用户的最后一条聊天记录（最近联系人聊天框展示   ）
             * result 用户聊天历史信息
             * imid 用户id
             * insert 是否是置顶消息
             */
            getUserTalk: function (message, imid, insert) {
            	var msgArr = $.extend(true,[],message); //值的克隆  or msgArr = message.concat()
                var html = '';        
                var talkType = $('input[name="talkType"]').val();
                //消息为空
                if (msgArr.length == '0') {
                	
                    //如果没有聊天记录，手动赋值用户信息
                    var info = {};
                    if(talkType == 'talk'){
                    	info.imid = $('.contact_' + imid).attr('imid');
                        info.clientid = $('.contact_' + imid).attr('headid')
                    }else if(talkType == 'groupTalk'){
                    	info.imid = $('#group_' + imid).attr('groupid');
                        info.clientid = $('#group_' + imid).attr('headid')
                    }else if(talkType == $.WebChat.CONST.CHAT_TYPE.PUBLIC){
                    	info.imid = $('.contact_' + imid).attr('imid');
                        info.clientid = $('.contact_' + imid).attr('headid')
                    }
                    $.bug(5) && console && console.log('历史记录为空哦',info);
                } else {
                    var lastnum = parseInt(msgArr.length) - 1;
                    var info = msgArr[lastnum];
                   	if(typeof(info.clientid) == 'undefined'){
                   		info.clientid = typeof($.WebChat.data.imidUserIds[info.imid]) == 'undefined' ? '' : $.WebChat.data.imidUserIds[info.imid];
                	}
                    if (!info) {
                         /*info = {};
                        if(talkType == 'talk'){
                        	info.imid = $('.contact_' + imid).attr('imid');
                            info.clientid = $('.contact_' + imid).attr('headid')
                        }else if(talkType == 'groupTalk'){
                        	info.imid = $('#group_' + imid).attr('groupid');
                            info.clientid = $('#group_' + imid).attr('headid')
                        }else if(talkType == $.WebChat.CONST.CHAT_TYPE.PUBLIC){
                        	info.imid = $('.contact_' + imid).attr('imid');
                            info.clientid = $('.contact_' + imid).attr('headid')
                        }*/
                    	$.bug(5) &&  console && console.log('历史记录为空哦,好像永远不会执行哦',info);
                    } else {
                        if (info.usertype == '1') {//1:表示自己,这个地方有错误，之前是=
                            var msg = msgArr;
                            //设置变量，每添加一次添加，增加1。判断是否全部是自己发送的消息
                            var j = 0;
                            for (var i = 0; i < msg.length; i++) {
                                if (msg[i].issend == '1') {
                                    info.imid = msg[i].imid;
                                    info.clientid = $('.contact_' + msg[i].frendid).attr('headid');
                                } else {
                                    j++;
                                }
                            }
                            //变量等于消息的总个数（全是自己给好友发送的）
                            if (j == msg.length) {
                                //获取好友或群组的相关信息赋值到最近聊天信息框
                                var talkType = $('input[name="talkType"]').val();
                                if(talkType == 'talk'){
                                	info.imid = $('.contact_' + imid).attr('imid');
                                    info.clientid = $('.contact_' + imid).attr('headid')
                                }else if(talkType == 'groupTalk'){//xgm
                                	info.imid = $('#group_' + imid).attr('groupid');
                                    info.clientid = $('#group_' + imid).attr('headid')
                                }else if(talkType == $.WebChat.CONST.CHAT_TYPE.PUBLIC){
                                	info.imid = $('.contact_' + imid).attr('imid');
                                    info.clientid = $('.contact_' + imid).attr('headid')
                                }
                            }
                            $.bug(5) &&  console && console.log('这里面好像永远不执行哦');
                        }
                    }
                }
                $.bug(5) && console && console.log(' info= ',info);
                var talkname = 'default_oradt',nums='';
                if(talkType == "talk"){
                	 talkname = $('.contact_' + imid).children('.SNS_pop_text').children('b').attr('title');
                }else if(talkType == 'groupTalk'){//xgm 20150711
                	var leftbox = $('.leftbox_'+imid).attr('type');
                	if(leftbox == undefined){
                		talkname = $('#group_' + imid +' .creategroup_friend_list').children('.SNS_popgroup_text').children('b').attr('title');
                        nums = $('#group_' + imid +' .creategroup_friend_list').children('.SNS_popgroup_text').children('b').attr('data-num');
                        if(talkname == undefined || nums == undefined){
                			 talkname = $('.contact_'+imid).children('.SNS_pop_text').children('b').attr('title');
                             nums = $('.contact_'+imid).children('.SNS_pop_text').children('b').attr('data-num');
                		}
                        //console.log(talkname,nums,7777)
                	}else{
                		 talkname = $('.leftbox_'+imid).children('.SNS_pop_text').children('b').attr('title');
                         nums = $('.leftbox_'+imid).children('.SNS_pop_text').children('b').attr('data-num');
                         //console.log(talkname,nums,8888)
                	}
                }else if(talkType == $.WebChat.CONST.CHAT_TYPE.PUBLIC){
                	 talkname = $('.publicno_' + imid).children('.SNS_pop_text').children('b').attr('title');
                }
            
                typeof(info.content) == 'undefined' ? info.content2='':null;
                info.content2 = $.WebChat.getMsgTypeByObj(info);
                typeof(info.chatDate) == 'undefined' ? info.chatDate = '':'';
                // 获得历史聊天个人|群组
                html += '<div class="cls_im_single_list left_list_ul leftbox_' + imid + '" imid="' + imid + '" type="'+talkType+'">';
                html += '<div class="marginauto">';
                // 获得个人头像
                if (talkType =='talk') {
                    html += '<div class="SNS_pop_img SNS_list_ul"><img src="' + gUrlGetHead+ '?headurl=' + info.clientid + '"></div>';
                    html += '<div class="SNS_pop_bg"></div>';
                    html += '</div><div class="safariborder SNS_pop_bg_position cls_little_red_tips hide">0</div>';
                    html += '<div class="SNS_pop_text">';
                    html += '<b title="'+talkname+'">' + cutstr_en(talkname,$.WebChat.CONST.LEFT_CUT_STR_NUM,'...') + '</b>';
                    html += '<p>' + info.content2 + '</p>';
                    html += '</div>';
                }else if(talkType == 'groupTalk'){
                    var img_html = $('.contact_'+imid).find('.SNS_pop_img').html();
                    /*if (info.content2 == undefined) {
                        content = $('.leftbox_'+imid).eq(0).find('.SNS_pop_text').children('p').html();
                    }*/
                    html += '<div class="SNS_pop_img SNS_list_ul">' + img_html + '</div>';
                    html += '<div class="SNS_pop_bg"></div>';
                    html += '</div><div class="safariborder SNS_pop_bg_position cls_little_red_tips hide">0</div>';
                    html += '<div class="SNS_pop_text">';
                    html += '<b title="'+talkname+'" data-num="'+nums+'">' + cutstr_en(talkname,$.WebChat.CONST.LEFT_CUT_STR_NUM,'...')+'('+nums+')' + '</b>';
                    html += '<p>' + info.content2 + '</p>';
                    html += '</div>';
                }else if(talkType == $.WebChat.CONST.CHAT_TYPE.PUBLIC){
                    var img_html = $('.publicno_'+imid).find('.SNS_pop_img').html();
                    /*if (info.content2 == undefined) {
                        content = $('.leftbox_'+imid).eq(0).find('.SNS_pop_text').children('p').html();
                    }*/
                   
                    html += '<div class="SNS_pop_img SNS_list_ul">'+ img_html+ '</div>';
                    html += '<div class="SNS_pop_bg"></div>';
                    html += '</div><div class="safariborder SNS_pop_bg_position cls_little_red_tips hide">0</div>';
                    html += '<div class="SNS_pop_text">';
                    html += '<b title="'+talkname+'">' + cutstr_en(talkname,$.WebChat.CONST.LEFT_CUT_STR_NUM,'...') + '</b>';
                    html += '<p>' + info.content2 + '</p>';
                    html += '</div>';
                }
                var msgNotDisturb = '';
    			if($.WebChat.data.disturbImids[imid] == 2){
    				msgNotDisturb = '<i class="clsSnsNotNoticeLebal"><img src="' + gPublic + '/images/icons/SNS_mdarao_icon.png" /></i>'; //免打扰标志
    			}
                html += '<div class="SNS_pop_time"><em>'+info['chatDate']+'</em>'+msgNotDisturb+'</div>'; //聊天时间与消息免打扰图标
                html += '</div>';
                // 获得群组显示头像
                var str = $('#recentBox .mycontacts .left_list_ul').attr('imid');
                //如果不是置顶消息执行插入操作
                if (insert == '0') {
                    //如果最近聊天框没数据，直接添加，否则插入到现有的数据前面
                	if (str == undefined) {
                        $('.mycontacts').html(html);
                    } else {
                        $(html).insertBefore($('#recentBox .mycontacts .left_list_ul').eq(0));
                    }
                } 
              	//设置选中项的背景色
            	$('#recentBox').find('.cls_im_single_list,.cls_im_single_notice').css('background-color',$.WebChat.CONST.ITEM_DEFAULT_COLOR); //重置颜色
            	$('#recentBox').find('.leftbox_'+imid).css('background-color',$.WebChat.CONST.ITEM_CHECKED_COLOR); //设置当前选中颜色
      
            	$.WebChat.myScroll('#recentBox');
                var css = $('#contactBox').css('display');
                	css == 'none' ? $('#recentBox').show() : $('#recentBox').hide();
                $.webim.scrollBottom();
            },
            
            /**
             * 接收消息后自动向左侧添加添加用户
             */
            autoGenLatestContact: function(imid,talkType){
               	var leftUserId = $('#recentBox .leftbox_' + imid).attr('imid');
                //历史记录框和置顶消息里没有重新添加，有的话移除重新添加（新消息置顶）
            	if(!leftUserId){
                    var talkname = 'default';
                    var info = {content2:'oradt'};
                    if(talkType == "talk"){
                    	 talkname = $('.contact_' + imid).children('.SNS_pop_text').children('b').attr('title');
                    	//html += '<div class="left_list_ul leftbox_' + info.imid + '" imid="' + info.imid + '">';
                    	 info.clientid = $('.contact_' + imid).attr('headid');
                    }else if(talkType == 'groupTalk'){//xgm 20150711
                    	var leftbox = $('.leftbox_'+imid).attr('type');
                    	if(leftbox == undefined){
                    		talkname = $('#group_' + imid +' .creategroup_friend_list').children('.SNS_popgroup_text').children('b').attr('title');
                            nums = $('#group_' + imid +' .creategroup_friend_list').children('.SNS_popgroup_text').children('b').attr('data-num');
                            if(talkname == undefined || nums == undefined){
                    			var talkname = $('.contact_'+imid).children('.SNS_pop_text').children('b').attr('title');
                                var nums = $('.contact_'+imid).children('.SNS_pop_text').children('b').attr('data-num');
                    		}
                    	}else{
                    		 talkname = $('.leftbox_'+imid).children('.SNS_pop_text').children('b').attr('title');
                             nums = $('.leftbox_'+imid).children('.SNS_pop_text').children('b').attr('data-num');
                    	}
                    }
                    
                    var html = '';
                    if (talkType =='talk') {
                        html += '<div class="cls_im_single_list left_list_ul leftbox_' + imid + '" imid="' + imid + '" type="'+talkType+'">';
                        html += '<div class="marginauto">';
                        html += '<div class="SNS_pop_img SNS_list_ul"><img src="' + gUrlGetHead+ '?headurl=' + info.clientid + '"></div>';
                        html += '<div class="SNS_pop_bg"></div>';
                        html += '</div><div class="safariborder SNS_pop_bg_position cls_little_red_tips hide">0</div>';
                        html += '<div class="SNS_pop_text">';
                        html += '<b title="'+talkname+'">' + cutstr_en(talkname,$.WebChat.CONST.LEFT_CUT_STR_NUM,'...') + '</b>';
                        html += '<p>' + info.content2 + '</p>';
                        html += '</div>';
                        html += '<div class="SNS_pop_time"><em>'+info['chatDate']+'</em></div>'; //聊天时间与消息免打扰图标
                        html += '</div>';   
                    }else if(talkType == 'groupTalk'){
                        var img_html = $('.contact_'+imid).find('.SNS_pop_img').html();
                        if (info.content2 == undefined) {
                            content = $('.leftbox_'+imid).eq(0).find('.SNS_pop_text').children('p').html();
                        }
                        html += '<div class="cls_im_single_list left_list_ul leftbox_' + imid + '" imid="' + imid + '" type="'+talkType+'">';
                        html += '<div class="marginauto">';
                        html += '<div class="SNS_pop_img SNS_list_ul">'
                             + img_html
                             + '</div>';
                        html += '<div class="SNS_pop_bg"></div>';
                        html += '</div><div class="safariborder SNS_pop_bg_position cls_little_red_tips hide">0</div>';
                        html += '<div class="SNS_pop_text">';
                        html += '<b title="'+talkname+'" data-num="'+nums+'">' + cutstr_en(talkname,$.WebChat.CONST.LEFT_CUT_STR_NUM,'...')+'('+nums+')' + '</b>';
                        html += '<p>' + info.content2 + '</p>';
                        html += '</div>';
                        html += '<div class="SNS_pop_time"><em>'+info['chatDate']+'</em></div>'; //聊天时间与消息免打扰图标
                        html += '</div>';
                    }
                    //console.log(html)
                    // 获得群组显示头像
                    var str = $('#recentBox .mycontacts .left_list_ul').attr('imid');
                    //如果不是置顶消息执行插入操作
                    //如果最近聊天框没数据，直接添加，否则插入到现有的数据前面
                	if (str == undefined) {
                        $('.mycontacts').html(html);
                    } else {
                        $(html).insertBefore($('#recentBox .mycontacts .left_list_ul').eq(0));
                    }
            	}
            },
            
            //聊天内容框填充公共方法,初始化聊天数据列表(历史记录)
            pushBox: function (message,imid,isAppend) {
            	typeof(isAppend)== 'undefined' ? (isAppend = false) :'';
                var html = '';
                var locationDataObj = []; //渲染地理位置对象
                var maxLen = message.length;
                var singleChatCls = 'cls_chat_single_msg';
                for (var i = 0; i < maxLen; i++) {
                	var msgBody = message[i];
                	var seqId   = msgBody.sequence;
                	//issend 谁发的0 自已发的，1 对方发的
                    //判断是自己的还是好友的聊天信息  
                    if (msgBody.issend == '0') {
                        //判断信息内容类型
                        if (msgBody.type == '1') {//文本消息
                        	var  content = $.WebChat.dealWithTrimShow(msgBody.content);
                        	     content = $.WebChat.dealWithFaceShow(content);
                            html += '<div class="receiver '+singleChatCls+'" id='+seqId+' cid='+msgBody.frendid+'>\
								<div><img src="' + myheadUrl + '" class="cls_sns_user_avatar_right"></div>\
								<div>\
									<div class="right_triangle"></div>\
									<p class="SNS_content_tw_righttext">\
										<span class="SNSchat_right_c">' + content + '</span>\
									</p>\
								</div>\
							</div>';
                        } else if (msgBody.type == $.WebChat.CONST.RESOURCE_TYPE.AUDIO) {
                        	var audioNew = '';//自己发送的就不做已读未读处理msgBody.isread == 0 ? '<img src="'+ gPublic + '/images/icons/SNS_yybaisewd_icon_img.png" />':'';
                        	//音频模板
                        	var url = $(msgBody.content).attr('url');
                        	var urlMp3 = msgBody.customData.urlMp3;
                        	var seconds = msgBody.customData.seconds;
                            html += '<div class="receiver '+singleChatCls+'" id='+seqId+' cid='+msgBody.frendid+'>\
								<div><img src="' + myheadUrl + '" class="cls_sns_user_avatar_right"></div>\
								<div>\
									<div class="right_triangle"><img class="cls_chat_audio" urlMp3="'+urlMp3+'" src="'+ gPublic + '/images/icons/SNS_yuyin_icon_huiseimg.png" /></div>\
									<p class="SNS_content_tw"></p>\
									<p>\
									<span class="SNS_content_time_left">"'+seconds+'"</span>\
									<span class="SNS_content_time_img cls_im_audio" isRead="'+msgBody.isread+'">'+audioNew+'</span>\
									</p>\
								</div>\
							</div>';
                        } else if (msgBody.type == $.WebChat.CONST.RESOURCE_TYPE.VIDEO) {
                        	//视频模板
                        	var url = $(msgBody.content).attr('url');
                        	var videoThumb = $.WebChat.getVideoThumb(url,seqId);
                        	html += '<div class="receiver '+singleChatCls+'" id='+seqId+' cid='+msgBody.frendid+'>\
    						<div><img src="' + myheadUrl +  '" class="cls_sns_user_avatar_right"></div>\
    						<div>\
    							<div class="right_triangle"></div>\
    							<p class="SNS_content_tw_right">\
    								<span class="SNSchat_right_video "  data-url="'+url+'" >' //"' + gPublic + '/images/background/sns_vodie_img.png"
    								+'<img class="mCS_img_loaded" src="'+videoThumb+'" onerror="'+$.WebChat.getVideoDefaultImage(this)+'"/>'+'</span>\
    							</p>\
								<i class="video_i_box cls_play_video">\
								<img src="'+ gPublic + '/images/icons/SNS_video_iconimg.png" />\
								</i>\
    						</div>\
    					</div>';
                        }else if(msgBody.type == '2'){/*2表示图片*/
                        	//二进制资源
                        	var downObj = $(msgBody.content);
                        	var resType  = downObj.attr('filetype');//资源类型pic
                        	switch(resType){
                        		case 'pic':/*图片资源*/
                                	html += '<div class="receiver '+singleChatCls+'" id='+seqId+' cid='+msgBody.frendid+'>\
        								<div><img src="' + myheadUrl +'" class="cls_sns_user_avatar_right"></div>\
        								<div>\
        									<div class="right_triangle"></div>\
        									<p class="SNS_content_tw_right">\
        										<span class="SNSchat_right_picimg hand">' 
        										+'<img class="cls_chat_pic mCS_img_loaded" urlOri="'+downObj.attr('url')+'" src="'+downObj.attr('url')+'"/>'+'</span>\
        									</p>\
        								</div>\
        							</div>';
                        			break;
                        		default:
                        	}
                        }else if(msgBody.type == '5'){/*5表示自定义类型*/
                        	//二进制资源
                        	var customData = msgBody.customData;
                        	var seqId    = msgBody.sequence;
                        	var vcardStrVal = $.WebChat.CONST.RESOURCE_CUSTOM.VCARD;
                        	switch(customData.customType){
                        		case vcardStrVal:/*名片资源*/
                        			var jsonLebal = "jsonData='"+customData.jsonData+"'";
                                	html += '<div class="receiver '+singleChatCls+'" id='+seqId+' cid='+msgBody.frendid+'>\
        								<div><img src="' + myheadUrl +'" class="cls_sns_user_avatar_right"></div>\
        								<div>\
        									<div class="right_triangle"></div>\
        									<p class="SNS_content_tw_right">\
        										<span class="SNSchat_right_picimg hand">' 
        										+'<img class="cls_chat_pic mCS_img_loaded" data-type="'+vcardStrVal+'"  '+jsonLebal+' urlOri="'+customData.image+'" src="'+customData.image+'"/>'+'</span>\
        									</p>\
        								</div>\
        							</div>';
                        			break;
                        		case 'Location':/*地理位置资源(地图)*/
                        			var seqId = ' id="'+msgBody.sequence+'" ';
    								var childId = ' id="content_child_'+msgBody.sequence+'" ';
    								var mapObj = customData.mapInfo
                        			var optsTmp = {
                    					position: $.WebChat.CONST.RESOURCE_POSITION.RIGHT_LIST,
                    					headUrl: myheadUrl,
                    					seqId: seqId,
                    					childId: childId,
                    					singleChatCls: singleChatCls,
                    					address:mapObj.address,
                    					mapInfo:mapObj
                    				};
                        			html +=  $.sns_common.tpl.talkSingleLocationTpl(optsTmp);
                        			
                        			var lng = mapObj.longitude;
                        			var lat = mapObj.latitude;
                        			var mapObj = {lng:lng, lat:lat,seqId:msgBody.sequence};
                        			locationDataObj.push(mapObj);
                        			break;
                        		case 'Active':/*活动资源(右侧显示)*/
                        			var seqIdStr = ' id="'+seqId+'" cid="'+msgBody.frendid+'" ';
                        			var opts = {
                        					xmlObj: downObj,
                        					position: 'right_all',
                        					headUrl: myheadUrl,
                        					activeArr: customData.activeArr,
                        					singleChatCls: singleChatCls,
                        					seqId: seqIdStr
                        					
                        				};
                        			html +=  $.sns_common.tpl.talkSingleActiveTpl(opts);
                        			break;
                        		default:
                        			$.bug(5) && console && console.log(downObj);
                        	}
                        }
                    } else if (msgBody.issend == '1') {
                    	var clientid = msgBody.clientid;
                    	if(typeof(clientid) == 'undefined'){
                    		clientid = typeof($.WebChat.data.imidUserIds[msgBody.imid]) == 'undefined' ? '' : $.WebChat.data.imidUserIds[msgBody.imid];
                    	}
                        if (msgBody.type == '1') {
                        	if(clientid){
                        		userimg = gUrlGetHead + '?headurl=' + clientid;
                        	}else{
                        		//var clientid = message[i].fromuid;
                            	//var zhimg = $('div[clientid="'+clientid+'"]').find('img').attr('src');
                        		//这里还是有问题的，以后修改
                        		var groupId = $('input[name="clientid"]').val();
                        		userimg = gUrlgetAvatarByImid+'?groupId='+groupId+'&imid='+message[i].imid;
                        	}
                        	var content = $.WebChat.dealWithTrimShow(message[i].content);
                        	    content = $.WebChat.dealWithFaceShow(content);
                                
                            html += '<div class="sender '+singleChatCls+'" id='+seqId+' cid='+clientid+'>\
								<div><img src="' + userimg + '" class="cls_sns_user_avatar hand"></div>\
								<div>\
									<div class="left_triangle"></div>\
									<p class="SNS_content_tw_lefttext">\
										<span class="SNSchat_right_c">' + content + '</span>\
									</p>\
								</div>\
							</div>';
                        } else if (msgBody.type == $.WebChat.CONST.RESOURCE_TYPE.AUDIO) {
                        	var audioNew = msgBody.isread == 0 ? '<img class="cls_chat_audio" urlMp3="'+urlMp3+'" src="'+ gPublic + '/images/icons/SNSyuyin_icon_wdimg.png" />':'';
                        	var urlMp3 = msgBody.customData.urlMp3;
                        	var seconds = msgBody.customData.seconds;
                            html += '<div class="sender '+singleChatCls+'" id='+seqId+' customType="'+$.WebChat.CONST.RESOURCE_TYPE.RESOURCE_STR+'" cid='+clientid+'>\
							<div><img src="' + gUrlGetHead+ '?headurl=' + clientid + '" class="cls_sns_user_avatar hand"></div>\
							<div>\
								<div class="left_triangle"><img class="cls_chat_audio" urlMp3="'+urlMp3+'" src="'+ gPublic + '/images/icons/SNS_yuyin_icon_img.png" /></div>\
								<p class="SNS_content_tw"></p>\
								<p>\
								<span class="SNS_content_timeleft">'+seconds+'"</span>\
								<span class="SNS_content_time cls_im_audio" isRead="'+msgBody.isread+'">'+audioNew+'</span>\
								</p>\
							</div>\
						</div>';
                        } else if (msgBody.type == $.WebChat.CONST.RESOURCE_TYPE.VIDEO) {
                        	var url = $(msgBody.content).attr('url');
                        	var videoThumb = $.WebChat.getVideoThumb(url,seqId);
                        	html += '<div class="sender '+singleChatCls+'" id='+seqId+' cid='+clientid+'>\
        						<div><img src="' + gUrlGetHead+ '?headurl=' + clientid +  '" class="cls_sns_user_avatar hand"></div>\
        						<div>\
        							<div class="left_triangle"></div>\
        							<p class="SNS_content_tw">\
        								<span class="SNSchat_right_video hand"  data-url="'+url+'" >' //"' + gPublic + '/images/background/sns_vodie_img.png"
        								+'<img class="mCS_img_loaded" src="'+videoThumb+'" onerror="'+$.WebChat.getVideoDefaultImage(this)+'"/>'+'</span>\
        							</p>\
    								<i class="video_i_box cls_play_video">\
									<img src="'+ gPublic + '/images/icons/SNS_video_iconimg.png" />\
									</i>\
        						</div>\
        					</div>';
                        }else if(msgBody.type == '2'){
                        	//二进制资源
                        	var downObj = $(msgBody.content);
                        	var resType  = downObj.attr('filetype');//资源类型pic
                        	switch(resType){
                        		case 'pic':/*图片资源*/
                                	html += '<div class="sender '+singleChatCls+'" id='+seqId+' cid='+clientid+'>\
        								<div><img src="' + gUrlGetHead+ '?headurl=' + clientid+'" class="cls_sns_user_avatar hand"></div>\
        								<div>\
        									<div class="left_triangle"></div>\
        									<p class="SNS_content_tw">\
        										<span class="SNSchat_right_picimg hand">' 
        										+'<img class="cls_chat_pic mCS_img_loaded" urlOri="'+downObj.attr('url')+'" src="'+downObj.attr('url')+'"/>'+'</span>\
        									</p>\
        								</div>\
        							</div>';
                        			break;
                        		default:                        			
                        	}
                        }else if(msgBody.type == '5'){/*5表示自定义类型*/
                        	if(typeof(msgBody.customData) != 'undefined' && msgBody.customData != ''){
                        		var customData = msgBody.customData;
                            	//二进制资源
                            	var seqId    = msgBody.sequence;
                            	var vcardStrVal = $.WebChat.CONST.RESOURCE_CUSTOM.VCARD;
                            	switch(customData.customType){
                            		case vcardStrVal:/*名片资源*/
                            			var jsonLebal = "jsonData='"+customData.jsonData+"'";
                                    	html += '<div class="sender '+singleChatCls+'" id='+seqId+' cid='+clientid+'>\
            								<div><img src="' + gUrlGetHead+ '?headurl=' + clientid +'" class="cls_sns_user_avatar hand"></div>\
            								<div>\
            									<div class="left_triangle"></div>\
            									<p class="SNS_content_tw">\
            										<span class="SNSchat_right_picimg hand">\
            									    <img class="cls_chat_pic mCS_img_loaded" data-type="'+vcardStrVal+'" '+jsonLebal+' urlOri="'+customData.image+'" src="'+customData.image+'"/>\
            									    </span>\
            									</p>\
            								</div>\
            							</div>';
                            			break;
                            		case 'Location':/*地理位置资源*/
        								var seqId = ' id="'+msgBody.sequence+'" ';
        								var childId = ' id="content_child_'+msgBody.sequence+'" cid="'+clientid+'" ';
        								var mapObj = customData.mapInfo;
                            			var optsTmp = {
                        					position: $.WebChat.CONST.RESOURCE_POSITION.LEFT_LIST,
                        					headUrl: gUrlGetHead+ '?headurl=' + clientid,
                        					//activeSet: msgBody.activeSet,
                        					seqId: seqId,
                        					childId: childId,
                        					singleChatCls: singleChatCls,
                        					mapInfo:mapObj
                        				};
                            			html +=  $.sns_common.tpl.talkSingleLocationTpl(optsTmp);
                            			
                            			var lng = mapObj.longitude;
                            			var lat = mapObj.latitude;
                            			var mapObj = {lng:lng, lat:lat,seqId:msgBody.sequence};
                            			locationDataObj.push(mapObj);
                            			break;
                            		case 'Active':/*活动资源(左侧显示)*/
                            			var seqIdStr = ' id="'+seqId+'" cid="'+clientid+'" ';
                            			var opts = {
                        						xmlObj: downObj,
                        						position: $.WebChat.CONST.RESOURCE_POSITION.LEFT_LIST,
                        						headUrl: gUrlGetHead + '?headurl=' + clientid,
                        						activeArr: customData.activeArr,
                        						singleChatCls: singleChatCls,
                            					seqId: seqIdStr
                        					};
                            			html +=  $.sns_common.tpl.talkSingleActiveTpl(opts);
                            			break;
                            		default:
                            			$.bug(5) && console && console.log(downObj);
                            			var downObj = $('messageattachment',msgBody.content).map(function(){return this});
                            			$.bug(1) && console && console.log('解析列表数据时未匹配到自定的类型',downObj);
                            	}
                        	}

                        }else if(msgBody.type == '11'){/*公众号的历史记录html结构*/
                        	var clientid = msgBody.content.numid;
                        	var zhimg = $('div[clientid="'+clientid+'"]').find('img').attr('src');
                        	var contentinfo = (msgBody.content.title!=undefined || msgBody.content.title!= null)?msgBody.content.title:'';
                        	
                           	html += '<div class="sender '+singleChatCls+'" id='+seqId+' cid="">'
							+'<div><img src="' +zhimg+'" class="cls_sns_user_avatar hand"></div>'
							+'<div class="cls_public_expo_more">'
							+'<div class="left_triangle"></div>';
                           		//	html +="<span class='time'>"+msgBody.content.showtime+"</span>";  //公众号消息接收时间
		                            html +="<div class='publicHistoryBox_bgcolor messageLT hand cls_sns_expo' expoid='"+clientid+"' type='"+msgBody.content.jumptype+"' url='"+msgBody.content.typeparam+"'>";  
		                            if (typeof msgBody.content.title !='undefined') {
		                                var title = msgBody.content.title;
		                            }else{
		                                var title = ''
		                            }
		                            html +="<p class='namttitle'>"+title+"</p>";
		                            html +="<em>";
		                            if (typeof msgBody.content.coverurl !='undefined') {
		                                html +="<img src='"+msgBody.content.coverurl+"'>";      
		                            }                                                                                             
		                            html +="</em>";
		                            html +="</div>"; 
                           	html += '</div>'
						+'</div>';
                        }

                    }
                }
                var msgFirstId = maxLen>0 ? message[0]['sequence'] : '';
                var talkBox = $('#talk_box');
                //聊天消息列表中的滚动条
                if(!talkBox.hasClass('mCustomScrollbar')){
                	talkBox.html(html).attr(
                    		{'data-imid':imid,'first-id':msgFirstId});
            		//美化滚动条
                	talkBox.mCustomScrollbar({
				        theme:"dark", //主题颜色
				        autoHideScrollbar: false, //是否自动隐藏滚动条
				        scrollInertia :0,//滚动延迟
				        horizontalScroll : false,//水平滚动条
				        callbacks:{
				            onScroll: function(){}, //滚动完成后触发事件
				            onTotalScrollBack: function(){/*当滚动到底部的时候调用这个自定义回调函数*/
				            	//加载更多聊天记录
				            	var tmpImid = $('#Chatwindow_right .contact_zone').attr('clientid');
				            	$.sns_common.loadMoreHistory(tmpImid);
				            }
				        }
				    });
					$.webim.scrollBottom();
            	}else{
            		var dataImid = talkBox.attr('data-imid');
            		var firtId = talkBox.attr('first-id');
            		//判断是否是对同一个好友对象进行的分页
            		if(imid == dataImid && isAppend){
            			var oldHtml = talkBox.find('.mCSB_container').html();
            			html += oldHtml;
            		}else{
            			talkBox.attr({'data-imid':imid});
            		}
            		talkBox.attr({'first-id':msgFirstId});
            		talkBox.find('.mCSB_container').html(html);
                }
                
                //jplayer播放元素
                var str = '';
                str += '<div id="jp_container_1" class="jp-video-360p" role="application" aria-label="media player">';
                str += '<div class="jp-type-single">';
                str += '<div id="jquery_jplayer_1" class="jp-jplayer"></div>';
                str += '<div class="jp-no-solution">';
                str += '<span>Update Required</span>';
                str += 'To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>';
                str += '</div>';
                str += '</div>';
                str += '</div>';
                //播放音乐 oldmiddle_yyleft
                $('#talk_box').on('click', '.cls_chat_audio',function () {
                	if($(this).hasClass('starting')){
                		$(this).removeClass('starting')
                		  $("#jquery_jplayer_1").jPlayer('pause');
                	}else{
                		$(this).addClass('starting');
                		
                		//设置语音为已读
                		var parents = $(this).parents('.cls_chat_single_msg');
                		if(parents.find('.cls_im_audio').attr('isread') == 0){
                			var imid = $('#Chatwindow_right .contact_zone').attr('clientid');
                			var talkType = $('#talkType').val();
                			var sequence = parents.attr('id');
                			$.post(gUrlSetAdudioRead,{imid:imid,sequence:sequence,talkType:talkType},function(rst){
                				if(rst.status != 0){
                					$.bug(1) && console && console.log(rst);
                				}else{
                					parents.find('.cls_im_audio').attr('isread',1).html(''); //设置为已读
                				}
                			});
                		}
                	}
                    //关闭正在播放的视频
                    $('.xubox_close1').click();
                    //获取播放的语音消息ID
                    var audioid = $(this).attr('msgid');
                    //移除播放器外层的class属性重新赋值
                    $('#msg_video').removeAttr('class');
                    $('#msg_video').attr('class', audioid);
                    //当前音频的播放元素
                    var player = $('.' + audioid).children('.jp-video-360p').html();
                    if (player != undefined) {
                        var playing = $('.jp-state-playing').html();
                        //如果正在播放当前音频
                        if (playing != undefined) {
                            //清空播放元素 停止播放
                            $('#msg_video').html('');
                        } else {
                            //播放器元素初始化
                            $('#msg_video').html(str);
                        }
                    } else {
                        //播放器元素初始化
                        $('#msg_video').html(str);
                    }
                    var urlAudio = $(this).attr('urlMp3');
                   // console.log(urlAudio)
                    $("#jquery_jplayer_1").jPlayer({
                        ready: function (event) {
                            $(this).jPlayer("setMedia", {
                                title: "Bubble",
                                mp3: urlAudio
                                //m4a: "http://jplayer.org/audio/m4a/Miaow-07-Bubble.m4a",
                                //oga: "http://jplayer.org/audio/ogg/Miaow-07-Bubble.ogg"
                            }).jPlayer("play");
                        },
                        swfPath: "../jsExtend/jplayer/",
                        supplied: "m4a, oga,mp3",
                        wmode: "window",
                        useStateClassSkin: true,
                        autoBlur: false,
                        smoothPlayBar: true,
                        keyEnabled: false,
                        remainingDuration: true,
                        toggleDuration: true
                    });
                    //隐藏菜单栏
                    $('.jp-gui').hide();
                });
                //播放视频
                $('#talk_box').on('click', '.cls_play_video',function () {
                	var videoObj = $(this).prev().children(0)
                    //播放器元素初始化
                    $('#msg_video').html(str);
                    //视频播放地址
                    var videourl = videoObj.attr('data-url');
                    $("#jquery_jplayer_1").jPlayer({
                        ready: function () {
                            $(this).jPlayer("setMedia", {
                                title: "test",
                                //webmv: gPublic + '/video/Wildlife_(new).webm',
                                m4v:videourl,
                                //m4v: "http://www.jplayer.org/video/m4v/Big_Buck_Bunny_Trailer.m4v",
                                //ogv: "http://www.jplayer.org/video/ogv/Big_Buck_Bunny_Trailer.ogv",
                                //webmv: "http://www.jplayer.org/video/webm/Big_Buck_Bunny_Trailer.webm",
                                poster: "http://www.jplayer.org/video/poster/Big_Buck_Bunny_Trailer_480x270.png"

                            }).jPlayer("play");
                        },
                        swfPath: "../jsExtend/jplayer/",
                        supplied: "webmv, ogv, m4v,mp4,m4a,mp3",
                        //solution: "html,flash",
                        size: {
                            width: "640px",
                            height: "360px",
                            cssClass: "jp-video-360p"
                        },
                        useStateClassSkin: true,
                        autoBlur: false,
                        smoothPlayBar: true,
                        keyEnabled: false,
                        remainingDuration: true,
                        toggleDuration: true
                    });
                    //弹出视频播放框
                    $.layer({
                        type: 1,
                        shade: [0],
                        area: ['auto', 'auto'],
                        title: false,
                        border: [0],
                        page: {dom: '#msg_video'}
                    });
                    //隐藏菜单栏
                    $('.jp-gui').hide();
                    //关闭视频框的时候清空播放元素
                    $('.xubox_close1').click(function () {
                        $('#msg_video').html('');
                    });
                });
                /**
                 * 点击活动消息查看详情
                 */
                $('#Chatwindow_right').off('click').on('click','.custom_active',function(){
                	
                	
                	var seqid = $(this).parent().prop('id');
                	var imid = $('input[name="clientid"]').val();
                	var type = $('input[name="talkType"]').val();
                	var actid = $(this).attr('data-id');
                	
                	$.sns_common.showActiveChatDetail(actid,type,seqid,imid);
                });
                
                //数据生成完成后渲染地图数据
                if(locationDataObj.length>0){
                	$.WebChat.renderMap(locationDataObj);
                }                
            },
            //活动详情方法
            showActiveChatDetail: function (__thisparam,stype,seqid,imid) {
            //	var two_domain = $('input[name="root_dir"]').val();
            	var aid = __thisparam;
                $.ajax({
                    url: gPublic+'/Home/schedule/getActive',
                    type: 'post',
                    dataType: 'json',
                    data: 'aid=' + aid +'&stype=sns'+ '&type1='+stype+'&seqid='+seqid
                    +'&imid='+imid,
                    success: function (res) {
                        //$('.show_active_details').html(res);
                        //$('.show_active_details').show();
                        
                        $('#Chatwindow_right').hide();//隐藏聊天框
                        $('#active_details').html('');
                        $('#active_details').append(res['data']);
                        $.bug(5) && (console && res['createid']=='') && console.log('app not add create_id!');
                        $('.Information_partypop').show();
                        //$('#active_details .Information_partypop').show();//显示新的活动详情模板
                        
                        //点击表情区域外 隐藏表情框
                        $('#back_active').on('click', function () {
                            $('.show_active_details').hide();
                        });
                    },
                    error: function (data) {
                        alert('error');
                    }

                });
                $.bug(5) && console && console.log('点击查看群活动详情新版');
            },
            /*各种模板处理*/
            tpl:{
            	/*用户聊天数据二进制文件模板处理方法*/
            	talkTpl:function(opts){ 
					var rtnHtml = '';
					switch(opts.binaryType){
						case $.WebChat.CONST.RESOURCE_STR.PICTURE:/*图片类型*/
		            		var thumbObj = opts.thumbObj;
							//var binaryType = thumbObj.attr('filetype');
							var downObj   = opts.downObj;
							var friendUrl = opts.friendUrl;
							rtnHtml = '<div class="sender">\
								<div><img class="cls_sns_user_avatar hand" src="' + friendUrl + '"></div>\
								<div>\
									<div class="left_triangle"></div>\
									<p class="SNS_content_tw">\
										<span class="SNSchat_right_picimg hand">' 
										+'<img class="cls_chat_pic mCS_img_loaded" urlOri="'+downObj.attr('url')+'" src="'+thumbObj.attr('url')+'"/>'+'</span>\
									</p>\
								</div>\
							</div>';
							break;
						case $.WebChat.CONST.RESOURCE_CUSTOM.VCARD:
							var vcardStrVal = $.WebChat.CONST.RESOURCE_CUSTOM.VCARD;
							var friendUrl = gPublic+opts.headUrl;
						//	var urlZip = opts.path;
							gUrlSnsGetImage = gUrlSnsGetImage.replace('.html','');
							var smallUrl = opts.image;
							var jsonLebal = "jsonData='"+opts.jsonData+"'";
							rtnHtml = '<div class="sender">\
								<div><img class="cls_sns_user_avatar hand" src="' + friendUrl + '"></div>\
								<div>\
									<div class="left_triangle"></div>\
									<p class="SNS_content_tw">\
										<span class="SNSchat_right_picimg hand">' 
										+'<img class="cls_chat_pic mCS_img_loaded" data-type="'+vcardStrVal+'" urlOri="'+smallUrl+'" src="'+smallUrl+'" '+jsonLebal+' />'+'</span>\
									</p>\
								</div>\
							</div>';
							break;
					}
					return rtnHtml;
            	},
            	
            	/*发送和接收的单条活动模板*/
            	talkSingleActiveTpl: function(opts){
            		var that = this;
            		var headUrl  = opts.headUrl; //用户头像
            		//var actid = opts.scheduleId;
            		var position = typeof(opts.position)!= 'undefined' ? opts.position : '';//判断消息显示位置的，显示在左侧还是右侧
            		var rtnHtml = '';
            		var seqId = typeof(opts.seqId)!= 'undefined' ? opts.seqId : '';
            		    seqId.indexOf('id') == -1 ? seqId = ' id="'+seqId+'" ' : null;
            		var singleChatCls = typeof(opts.singleChatCls)!= 'undefined' ? opts.singleChatCls : '';
            		//发送者展示消息(非完整模板,替换子模板)
            		if($.WebChat.CONST.RESOURCE_POSITION.RIGHT == position){
            			var dataSet = $('#'+opts.sSeqID).attr('dataSet');
            			var dataSet = JSON.parse(dataSet);
            			    dataSet = dataSet.content[0];
            			    dataSet.content = $.WebChat.dealWithTrimShow(dataSet.content);
            			    dataSet.content = $.WebChat.dealWithFaceShow(dataSet.content);
            			rtnHtml = '<div><img src="' + headUrl + '" /></div>\
		            	    <div class="active_chat_intro hand custom_active" data-id="'+dataSet.event_id+'">\
		            	        <div class="right_triangle"></div>\
		            	        <p class="SNS_content_tw_rightactive">\
		            	            <span><img src="'+gPublic+'images/background/sns_activities_bg.png" /></span>\
		            				<span class="SNSchat_right_c SNS_chat_schedule_img">\
		            					<b>'+dataSet.content+'</b>\
		            					<i>    </i>\
		            					<em>'+dataSet.starttime+'</em>\
		            				</span>\
		            	        </p>\
		            	    </div>';
            		}else if ($.WebChat.CONST.RESOURCE_POSITION.LEFT_LIST == position){
            				//接受者展示消息
            				 var dataSet = opts.activeArr.content[0];
            				     dataSet.content = $.WebChat.dealWithTrimShow(dataSet.content);
                 				 dataSet.content = $.WebChat.dealWithFaceShow(dataSet.content);                			    
     	               		 rtnHtml = '<div class="sender  '+singleChatCls+'" '+seqId+'>\
   			            	    <div><img class="cls_sns_user_avatar hand" src="' + gPublic+headUrl + '" /></div>\
   			            	    <div class="active_chat_intro hand custom_active" data-id="'+dataSet.event_id+'">\
   			            	        <div class="left_triangle"></div>\
   			            	        <p class="SNS_content_tw_leftactive">\
   			            	            <span><img src="'+gPublic+'images/background/sns_activities_bg.png" /></span>\
   			            				<span class="SNSchat_right_c SNS_chat_schedule_img">\
   			            					<b>'+dataSet.content+'</b>\
   			            					<i></i>\
   			            					<em>'+dataSet.starttime+'</em>\
   			            				</span>\
   			            	        </p>\
   			            	    </div>\
   			            	</div>';
            		}else if('right_all' == position){
            			//console.log(opts)
            			//右侧模板完整展示(发送者),供列表展示使用
 						 var dataSet = opts.activeArr.content[0];
 						 var content = dataSet.content;
 						 var starttime = dataSet.starttime;
 						     content = $.WebChat.dealWithTrimShow(content);
 	        			     content = $.WebChat.dealWithFaceShow(content);
 						 rtnHtml = '<div class="receiver '+singleChatCls+'" '+seqId+'>\
	            			<div><img src="' + headUrl + '" /></div>\
		            	    <div class="active_chat_intro hand custom_active" data-id="'+dataSet.event_id+'">\
		            	        <div class="right_triangle"></div>\
		            	        <p class="SNS_content_tw_rightactive">\
		            	            <span><img src="'+gPublic+'images/background/sns_activities_bg.png" /></span>\
		            				<span class="SNSchat_right_c SNS_chat_schedule_img">\
		            					<b>'+content+'</b>\
		            					<i>    </i>\
		            					<em>'+starttime+'</em>\
		            				</span>\
		            	        </p>\
		            	    </div>\
	            		</div>';
        					 
            		}
            		return rtnHtml;
            	},
            	
            	/*发送和接收单条地理位置模板*/
            	talkSingleLocationTpl: function(opts){
            		var that = this;
            		var rtnHtml = '';
            		var headUrl  = opts.headUrl; //用户头像
            		var position = typeof(opts.position)!= 'undefined' ? opts.position : '';//判断消息显示位置的，显示在左侧还是右侧
            		var seqId = opts.seqId;
            		var singleChatCls = typeof(opts.singleChatCls) != 'undefined'?opts.singleChatCls:'';
            		//发送者展示消息(非完整模板,替换子模板)
            		if($.WebChat.CONST.RESOURCE_POSITION.RIGHT_SEND_LOADING == position){
            			var childId = opts.childId;
            			//用户发送进行中
            			rtnHtml = '<div class="receiver '+singleChatCls+'" '+seqId+'>\
						        	<div><img src="'+headUrl+'"></div>\
						        	<div >\
										<div class="right_triangle"></div>\
						        		<div class="SNS_content_tw_right_map" style="height:300px;width:200px" '+childId+'>\
						        			<span class="SNSchat_right_c">'+message+'</span>\
						        		</div>\
						        		<div class="cls_map_address">'+opts.address+'</div>\
						        		<div class="mask_bg"></div>\
						        	</div>\
						        	</div>';
            		}else if ($.WebChat.CONST.RESOURCE_POSITION.LEFT_LIST == position){
            			var childId = opts.childId;
            			//用户成功接收(展示在左侧)
            			rtnHtml = '<div class="sender '+singleChatCls+'" '+seqId+'>\
			        	<div><img class="cls_sns_user_avatar hand" src="'+headUrl+'"></div>\
			        	<div >\
							<div class="left_triangle"></div>\
			        		<div class="SNS_content_tw_left_map" style="height:300px;width:200px" '+childId+'>\
			        			<span class="SNSchat_right_c">'+'</span>\
			        		</div>\
			        		<div class="cls_mapadd_address">'+opts.mapInfo.address+'</div>\
			        		<div class="maskg_bg"></div>\
			        	</div>\
			        	</div>';

            		}else if($.WebChat.CONST.RESOURCE_POSITION.RIGHT_LIST == position){
            			//展示在右侧完整模板
            			var childId = opts.childId;
            			//用户成功接收(展示在左侧)
            			rtnHtml = '<div class="receiver '+singleChatCls+'" '+seqId+'>\
			        	<div><img src="'+headUrl+'"></div>\
			        	<div >\
							<div class="right_triangle"></div>\
			        		<div class="SNS_content_tw_right_map" style="height:300px;width:200px" '+childId+'>\
			        			<span class="SNSchat_right_c">'+'</span>\
			        		</div>\
			        		<div class="cls_map_address">'+opts.mapInfo.address+'</div>\
			        		<div class="mask_bg"></div>\
			        	</div>\
			        	</div>';        					 
            		}
            		return rtnHtml;
            	},
            	
            	//接收展示单条音频模板 audio
            	tplAudioSingle: function(opts){/*异步接收手机端发来的*/
            		var that = this;
            		var rtnHtml = '';
            		//var headUrl  = opts.headUrl; //用户头像
            		//var position = typeof(opts.position)!= 'undefined' ? opts.position : '';//判断消息显示位置的，显示在左侧还是右侧
            		//var seqId = opts.seqId;
                	var urlMp3 = opts.urlMp3;
                	var seconds = opts.seconds;
                	var headUrl = opts.headUrl;
                	 var singleChatCls = 'cls_chat_single_msg';
                	 var audioNew = '<img src="'+ gPublic + '/images/icons/SNSyuyin_icon_wdimg.png" />';
                	rtnHtml = '<div class="sender '+singleChatCls+'" customType="'+$.WebChat.CONST.RESOURCE_TYPE.RESOURCE_STR+'" id="'+opts.seqId+'">\
						<div><img class="cls_sns_user_avatar hand" src="' + gPublic + headUrl + '"></div>\
						<div>\
							<div class="left_triangle"><img class="cls_chat_audio" urlMp3="'+urlMp3+'" src="'+ gPublic + '/images/icons/SNS_yuyin_icon_img.png" /></div>\
							<p class="SNS_content_tw"></p>\
							<p>\
							<span class="SNS_content_timeleft">"'+seconds+'"</span>\
							<span class="SNS_content_time cls_im_audio" isRead="0">'+audioNew+'</span>\
							</p>\
						</div>\
					</div>';
            		return rtnHtml;
            	},
            	
            	//视频模板(左侧)
            	tplVideoSingle: function(opts){
            		$.bug(5) && console && console.log(opts)
					var downObj   = opts.downObj;
					var friendUrl = opts.friendUrl;
					rtnHtml = '<div class="sender">\
						<div><img class="cls_sns_user_avatar hand" src="' + friendUrl + '"></div>\
						<div>\
							<div class="left_triangle"></div>\
							<p class="SNS_content_tw">\
								<span class="SNSchat_right_video hand"  data-url="'+downObj.attr('url')+'" >' //"' + gPublic + '/images/background/sns_vodie_img.png"
								+'<img class="mCS_img_loaded" src="' + opts.thumbObj.attr('url') + '"/>'+'</span>\
							</p>\
							<i class="video_i_box cls_play_video">\
							<img class="mCS_img_loaded" src="/images/icons/SNS_video_iconimg.png">\
							</i>\
						</div>\
					</div>';
					return rtnHtml;
            	}       	
            },
        	//加载更多聊天历史记录信息
        	loadMoreHistory: function(imid,type){
        		var page = typeof(variable.sns[imid]['page'])?variable.sns[imid]['page']:1;
        		    page = page+1;
        		if(typeof(type) == 'undefined' || type == ''){
        			type = $('input[name="talkType"]').val();
        		}
        		var url = $.WebChat.getHistoryUrl(type);
            	var diff = typeof(variable.sns[imid]['selectDiff']) == 'undefined' ? 0 :variable.sns[imid]['selectDiff'];
            	//获取聊天记录
                $.post(url, {imid: imid,page:page,diff:diff}, function (dzy) {
                    if (dzy.status == '0') {
                    	if(dzy.data.numfound != '0'){
                            sdj = dzy.data.list;
                        }else{
                        	var sdj = '';
                        }
                    	if(sdj.length>0){
                    		if(sdj[0]['sequence'] == $('#talk_box').attr('first-id')){
                    			return true;
                    		}
                    		var isAppend = true;
                            //最近聊天消息框填入数据
                            $.sns_common.pushBox(sdj,imid,isAppend); //显示用户会话消息记录列表
                            //消息记录存入数组
                            //historyInfo[imid] = sdj;
                            historyInfo[imid] = sdj.concat(historyInfo[imid]);//对数组进行合并
                            if(sdj.length>=$.WebChat.CONST.CHAT_RECORD){
                            	variable.sns[imid]['page'] = page;
                            }
                    	}
                    } else {
                        $('#talk_box').html('');
                    }
                },'json');
        	},
            // 加载更多公共号历史记录
            loadMorePublicHistory:function(imid){
            	typeof(variable.sns['his_pub_'+imid]) == 'undefined' ?  (variable.sns['his_pub_'+imid] = {}) : '';
                var page = typeof(variable.sns['his_pub_'+imid]['page']) != 'undefined'?variable.sns['his_pub_'+imid]['page']:1;
                page = page+1;
                type = $('input[name="talkType"]').val();
                var url = $.WebChat.getHistoryUrl(type);
                $.post(url,{imid:imid,sort:'desc',page:page},function(result){
                    if (0==result.status) {
                        var historyInfo = result.data.list;
                        var listNum = historyInfo.length;
                        var html='';
                        for (var i = 0; i < listNum; i++) {
                            // 只显示图片或者vcard
                            if (historyInfo[i].content.jumptype !='text') {                                           
                                html += "<div class='publicHistoryBox_list'>";
                                html +="<span class='time'>"+historyInfo[i].content.showtime+"</span>";                                                   
                                html +="<div class='publicHistoryBox_bgcolor messageLT'>";  
                                if (typeof historyInfo[i].content.title !='undefined') {
                                    var title = historyInfo[i].content.title;
                                }else{
                                    var title = ''
                                }
                                html +="<span class='namttitle'>"+title+"</span>";
                                html +="<i>";
                                if (typeof historyInfo[i].content.coverurl !='undefined') {
                                    html +="<img src='"+historyInfo[i].content.coverurl+"'>";      
                                }                                                                                             
                                html +="</i>";
                                html +="</div>";        
                                html +="</div>";
                            }else{
                            // 显示文字模板
                            }
                        };
                    }else{
                        var  html ='';
                    }
                    $('#publicHistoryBox').find('.mCSB_container').append(html);
                },'json');
                variable.sns['his_pub_'+imid]['page'] = page;
            },
        	htmlFriendRequest: function(rst,pNum){//好友请求html结构
        		var html = '',maxLen=rst.data.length;
        		for(var i=0;i<maxLen;i++){
        			var obj = rst.data[i];
        			var contact = JSON.parse(obj.contact);
        			var imid = contact.params.imid;
        			html +='<div class="friend_request_dl" req_imid="'+imid+'"><em>'+obj.datetime+'</em><div class="friend_request_list messageLT">'
        			     +'<i class="safariborder"><image class="safariborder" src="'+obj.userhead+'"/></i><span class="friend_requestspan"><b class="friend_i">'+obj.sender+'</b>';
        			if(obj.type == 110){
                        if(obj.handleresult=='access'){
                            html += ' '+gSnsReqJoinYouFriends+'</span> '+'&nbsp;&nbsp; <span class="span_bint yuanjiao_input clsRequestSes">'+gSnsReqChat+'</span>';//请求加您为好友     会话
                        }else{
            				html += ' '+gSnsReqJoinYouFriends+'</span> '+'<span class="cls_fq_set_opera" type="1" mid="'
            				+obj.mid+'">'+gSnsReqArgee+'</span>'; //请求加您为好友 同意
                        }
        			}else if(obj.type == 111){
        				html += gSnsReqRefuseJoinYouFriends +'</span>'; //拒绝了您的好友请求
        			}else if(obj.type == 112){
        				html += ' '+gSnsReqAgreeJoinYouFriends +'</span> '+'&nbsp;&nbsp; <span class="span_bint yuanjiao_input clsRequestSes">会话</span>'; //同意并添加您为好友
        			}
        			html +='</div></div>';
        		}
        		var objContent = $('.cls_friend_request_content');
        		objContent.attr('nextPage',rst.pageNum)
        		$('.cls_friend_request_list').show();
        		$.WebChat.myScroll($('.cls_friend_request_content'),{onTotalScroll:function(){ 
        			var pageNum = objContent.attr('nextPage');
        			if(pageNum != -1){
        				var paramData = {pageNum:pageNum,type:'friend',rows:10};
            			$.get(gUrlSnsGetFriendRequest,paramData,function(rst){
                      		$.sns_common.htmlFriendRequest(rst,pageNum);
                      	},'json'); 
        			}        			     
        		}
        		});
        		if(pNum == 1){
        			objContent.find('.mCSB_container').html(html);
        		}else{
        			objContent.find('.mCSB_container').append(html);
        		}
        		$.sns_common.bindEvtAfter.operaFr();
        	},
        	/*
        	 * 公众号名片池群组生成模板
        	 */
        	publicHtmlGroup: function(data){
    			var html = '';
    			if(data){
    				var maxLen = data.length;
    				for(var i=0;i<maxLen;i++){
    					var tmpObj = data[i];
    					html +='<div class="publicMoreVcard_czshang_l">\
						<span class="clsPublicGroupName hand" groupid="'+tmpObj.groupid+'"  property="'+tmpObj.property+'"  total="'+tmpObj.total+'">'+tmpObj.groupname+'</span>\
						<ul class="clsPublicGroupUl"></ul>\
    					</div>';
    				}
    			}
    			return html;
        	},
        	/**
        	 * 名片池--公众号名片池中名片生成模板
        	 */
        	publicHtmlVcard: function(data){
        		var html = '';
        		if(data){
        			var maxLen = data.length;
        			for(var i=0;i<maxLen;i++){
        				var tmpObj = data[i];
        				var cls = 'clsPublicVcardSingleCheck clsPublicVcardSingle';
        				if(tmpObj.saved == 1){
        					cls = 'default clsPublicVcardSingle';	
        				}
        				var display = '';
        				if($('.clsPublicVcardDownload').is(':visible')){
        					display = 'style="display:none;"';
        				}
        				html += '<li>\
								<span><img src="'+tmpObj.picture+'"></span>\
								<i class="'+cls+'"  '+display+' expoid="'+tmpObj.expoid+'" vcardid="'+tmpObj.vcardid+'"></i>\
							</li>';
        			}
        		}
        		return html;
        	}
        },
		//用于显示创建群组的模板   从global.js中提取出来的代码
		sns_global : {
			// 聊天窗口 设置窗口显示隐藏状态{none, block}
			boxDisplay : {
				chatBox : 'none', // 聊天窗口
				setBox : 'none' // 设置窗口
			},
			init : function() {
			// 创建组
			$('#addGroup').on('click',function() {
				$.sns_global.boxDisplay.chatBox = $('#Chatwindow_right').css('display');
				$.sns_global.boxDisplay.setBox = $('#Information_Chat').css('display');
			
				$('#Information_Chat').hide();
				$('#Chatwindow_right').hide();
			
				//$(".SNS_pop_box").addClass('sns_group');
				$.post(sns_getMembersUrl, {},function(result) {
							$('#snsInfo').html(result);
						});
				var pageii = $.layer({
					style : [],
					type : 1,
					fix : false,
					title : false,
					area : [ '275px', 'auto' ],
					offset : [ '72px', '170px', '',
							'' ],
					bgcolor : '',
					border : [ 0, 0.3, '#ff9900' ], // 边框[边框大小,
					// 透明度,
					// 颜色]
					shade : [ 0.2, '#000' ], // 遮罩层
					closeBtn : [ 0, false ], // 去掉默认关闭按钮
					shift : '', // 从左动画弹出
					page : {
						dom : '#snsInfo'
					},
					end : function() {
					}
				});
				
				// 自设关闭,好像这个里面的东西没有使用
				$('#snsInfo').on('click','.createGroup_close',function() {
						$('#Chatwindow_right').css('display',$.sns_global.boxDisplay.chatBox);
						$('#Information_Chat').css('display',$.sns_global.boxDisplay.setBox);
						layer.close(pageii);
						$(".SNS_pop_box").removeClass('sns_group');
				});
			});
		
			}
		}
    })
})(jQuery);
$(document).ready(function () {
    window.pic_of_key = 0;
    //定义全局数组，把历史记录存入数组，下次调用不用call接口
    window.historyInfo = new Array();
    //window.mycontactsinfo =  new Array();
    //滑动次数（带方向）
    window.movecount = 0;
    //滑动偏移方向
    window.movedirection = '';
    window.countnum = 0;
    //存放sns相关变量
    window.variable = {};
    window.variable.sns = []; 
    //获取选中人的数量
    $('#createActiveId').off('click').on('click', function (event) {
     	if($('input[name="talkType"]').val() == $.WebChat.CONST.CHAT_TYPE.PUBLIC){
    		return true;
    	}
        var uid = 1;
        var stype = $('input[name="talkType"]').val();
        var groupid = $('input[name="groupid"]').val();
        var fuid = $('input[name="fuid"]').val();
        var thisObj = $(this);
        //加载活动列表
        $.ajax({
            url: gHttpHost + '/Home/schedule/ShowActive',
            type: "post",
            dataType: "json",
            data: 'type=sns&stype='+stype+'&groupid='+groupid+'&fuid='+fuid,
            success: function (data) {
            	thisObj.addClass('active');
            	$(".hiddenactive,.snsmask_pop").show();
            	$("#act_hidden_div").html(data.data);
            },
            error: function (data) {
                alert(0);
            }

        });
    });

    //获取空间动态方法
    /*function getZoneDatas(obj) {
        //获取用户ID
        var userid = $('#Chatwindow_right .contact_zone').attr('clientid');
        //用户头像和名字
        var headurl = $('#Chatwindow_right .contact_zone').children('.SNS_pop_left').children('.SNS_pop_img').children('img').attr('src');
        // var name = $('#Chatwindow_right .contact_zone').children('.SNS_pop_left').children('b').html();
        var name = $('#Chatwindow_right .contact_zone').children('.SNS_pop_left').children('b').attr('title');
        var nums = $('#Chatwindow_right .contact_zone').children('.SNS_pop_left').children('b').attr('data-num');
        //更新空间头像和名字
        $('.zonehead img').attr('src', headurl);
        $('.zonename').html(name+'('+nums+')');
        $('.Chatwindow_right').hide();
        $('.personalspace_cont_right').show();

        //配置分页
        if (obj) {
            var pagenumb = $(obj).attr('data-pagenum');
        }


        $.post(getUserZoneUrl, {uid: userid, p: pagenumb}, function (result) {
            if (result.status == '0') {
                if (result.pagedata.page > result.pagedata.nums) {

                    return true;
                }
                $("#page_go_up").attr('data-pagenum', result.pagedata.page_up);

                $("#page_go_1").attr('data-pagenum', result.pagedata.page);
                $("#page_go_1").html(result.pagedata.page);
                $("#page_go_2").attr('data-pagenum', parseInt(result.pagedata.page) + 1);
                $("#page_go_2").html(parseInt(result.pagedata.page) + 1);
                $("#page_go_3").attr('data-pagenum', parseInt(result.pagedata.page) + 2);
                $("#page_go_3").html(parseInt(result.pagedata.page) + 2);

                $("#page_go_down").attr('data-pagenum', result.pagedata.page_down);
                if (parseInt(result.pagedata.nums) - parseInt(result.pagedata.page) < 1) {
                    $("#page_go_2").attr({style: "display:none"});
                    $("#page_go_3").attr({style: "display:none"});
                } else {
                    $("#page_go_2").attr({style: "display:''"});
                    $("#page_go_3").attr({style: "display:''"});
                }
                if (parseInt(result.pagedata.nums) - parseInt(result.pagedata.page) < 2) {
                    $("#page_go_3").attr({style: "display:none"});
                } else {
                    $("#page_go_3").attr({style: "display:''"});
                }

                var data = result.data;
                $('.talknum').html(data.numfound);
                $('.fansnum').html(result.fans);
                $('.attentionnum').html(result.attention);
                if (data.numfound == 0) {
                    //var html = '<div>该用户没有动态~。~</div>';
                } else {
                    var talk = data.news;
                    var html = '';
                    for (var i = 0; i < talk.length; i++) {
                        html += '<div class="heightauto">';
                        html += '<div class="left list_dllist_c_left">';
                        html += '<div class="SNS_pop_img SNS_list_ul"><img src="' + headurl + '" /></div>';
                        html += '<div class="SNS_pop_bg"></div>';
                        html += '</div>';
                        html += '<div class="right list_dllist_c_right">';
                        html += '<div class="top_content">';
                        html += '<p><span>' + name + '：</span><i>' + talk[i].content + '</i></p>';
                        html += '</div>';
            //            html += '<div class="Address_time"><span>' + talk[i].ctime + '</span><i>北京</i></div>';
                        html += '<div class="bottom_anniu">';
                        html += '<span>';
                        html += '<b><img src="' + gPublic + '/images/icons/personalspace_fx.jpg" /></b>';
                        html += '<i>14</i>';
                        html += '</span>';
                        html += '<span class="talk_comment" talkid="' + talk[i].id + '">';
                        html += '<b><img src="' + gPublic + '/images/icons/hr_message.png" /></b>';
                        html += '<i>' + talk[i].commNumber + '</i>';
                        html += '</span>';
                        html += '<span>';
                        html += '<b></b><img src="' + gPublic + '/images/icons/hr_zan.png" /></b>';
                        html += '<i>' + talk[i].commNumber + '</i>';
                        html += '</span>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        html += '<div class="personalspace_display_message comment_' + talk[i].id + '" talkid="' + talk[i].id + '" style="display:none">';
                        html += '<i><img src="' + gPublic + '/images/icons/hr_icon_weizhi.png" /></i>';
                        html += '<div class="personalspace_minheight_box">';
                        html += '<div class="personalspace_message_pinglun">';
                        html += '<span><textarea></textarea></span>';
                        //html += '<span><input class="personalspace_botton_input" type="button" value="评论" /></span>';
                        html += '</div>';
                        html += '<div class="comment_list_' + talk[i].id + '"></div>';
                        html += '<div class="personalspace_message_huifu_box" style="display:none">';
                        html += '<span><textarea name="commentContent"></textarea></span>';
                        //html += '<span><input class="personalspace_botton_input" type="button" value="评论" /></span>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                    }
                }
                $('.user_zone').html(html);
            } else {
                layer.msg(loadZoneFail);
            }
            //加载评论信息
            $('.talk_comment').click(function () {
                var commentnum = $(this).children('i').html();
                var talkid = $(this).attr('talkid');
                var show = $('.comment_' + talkid).css('display');
                if (show == 'none') {
                    var html = '';
                    $.post(getCommentUrl, {talkid: talkid}, function (data) {
                        if (data.status = '0') {
                            var info = data.data;
                            for (var i = 0; i < info.length; i++) {
                                html += '<div class="personalspace_message_plun_box">';
                                html += '<div class="left personalspace_message_plun_boxleft">';
                                html += '<div class="personalspace_message_plun_img"><img src="' + gPublic + '/images/background/hr_pinglun_img.png" /></div>';
                                html += '<div class="personalspace_message_plun_bg"></div>';
                                html += '</div>';
                                html += '<div class="right personalspace_message_plun_boxright">';
                                html += '<p><span class="comment_user">' + info[i].username + '：</span><em>' + info[i].content + '</em></p>';
                                html += '<div class="personalspace_plun_boxright_time">';
                                html += '<b>' + info[i].ctime + '</b>';
                               // html += '<em class="comment_click">回复</em>';
                                html += '</div>';
                                html += '</div>';
                                html += '</div>';
                            }
                            $('.comment_list_' + talkid).html(html);
                            //评论回复
                            $('.comment_click').click(function () {
                                $(this).addClass('active');
                                $(this).parent().parent().parent().siblings().children('.right').children('div').children('em').removeClass('active');
                                $('.personalspace_message_huifu_box').show();
                                var user = $('.comment_user').html();
                                //$('textarea[name="commentContent"]').val('回复@' + user);
                            });
                            $('.personalspace_botton_input').click(function () {
                                var content = $(this).parent().siblings('span').children('textarea').val();
                                //回复内容提交
                                $.post(publishCommentUrl, {talkid: talkid, content: content}, function (result) {
                                    if (result.status == '0') {
                                        layer.msg(commentSuc, 2, 1);
                                    }
                                });
                            });

                        }
                    });
                    $('.comment_' + talkid).show();
                } else {
                    $('.comment_' + talkid).hide();
                }

            });
        });
    }*/

    //个人空间
    /*$('.SNS_pop_qzone').click(function () {
        getZoneDatas();
        //添加个人空间div头部上的图标（小箭头）
        var html = '<div class="SNS_top_bg_right"></div>';
        $(html).insertBefore($('.personalspace_cont_right .personalspace_head'));
    });*/
    //个人空间 分页
   /* $('.page_go').click(function () {
        getZoneDatas(this);
    });*/
    $('.snsLeftSearchBtn').on('click',function(){
    	$('input[name="im_search"]').trigger('focus');
    });
    //搜索好友,搜索用户
    $('input[name="im_search"]').on('input propertychange focus', function () {
        var val = $(this).val();

        //实时监控输入值 如果不为空，匹配好友
        if (val != '') {
            $('.search_list_box').show().siblings().hide();
            var isCatch = false;    //最近联系人是否有搜索到
            //搜最近联系人
            // $('#recentBox .left_list_ul').each(function(i, o){
            //     i == 0 && $('.SNS_pop_toggle_c .search_list_box').html('');
            //     if($(o).find('b').text().indexOf(val) != -1){
            //         isCatch = true;
            //         $(o).clone().appendTo('.search_list_box');
            //     }
            // });
            if(!isCatch){
                //搜联系人
                $.post(friendsSearchUrl, {name: val, isAll:1}, function (result) {
                    if ((result.contacts == null || result.contacts.length == 0) && (result.groups == null || result.groups.length == 0) ) {
                    	var obj = $('.search_list_box');
                    	var html = '<div style="color:#fff;text-align:center;margin-top:15px;">'+gHasNoData+'</div>';
                    	if(obj.hasClass('mCustomScrollbar')){
                    		obj.find('.mCSB_container').html(html);
                    	}else{
                    		obj.html(html);
                    	}
                        
                    } else {
                        var html = '';
                        if(result.contacts !=null && typeof(result.contacts) != 'undefined' && result.contacts.length > 0){
                            html += '<div class="messageleft_list_A"><span>'+gActionFriend+'</span></div>';
                            for (var i = 0; i < result.contacts.length; i++) {
                                html += '<div class="messageleft_list_ul cls_im_single_list contact_' + result.contacts[i].imid + '" headid="' + result.contacts[i].clientid + '" type="talk" imid="' + result.contacts[i].imid + '">';
                                html += '<div class="marginauto">';
                                html += '<div class="SNS_pop_img SNS_list_ul"><img src="' + gUrlGetHead + '?headurl=' + result.contacts[i].clientid + '"></div>';
                                html += '</div>';
                                html += '<div class="SNS_pop_text"><b title="'+result.contacts[i].realname+'">' + cutstr_en(result.contacts[i].realname,$.WebChat.CONST.LEFT_CUT_STR_NUM,'...') + '</b><p></p></div>';
                                html += '</div>';     
                            }
                        }
                        if(result.groups !=null && typeof(result.groups) != 'undefined' && result.groups.length > 0){
                            html += '<div class="messageleft_list_A"><span>'+gActionGroup+'</span></div>';
                            for (var i = 0; i < result.groups.length; i++) {
                                html += '<div class="messageleft_list_ul cls_im_single_list" type="groupTalk" imid="' + result.groups[i].groupnum + '">';
                                html += '<div class="marginauto">';
                                // 
                                if (result.groups[i].logo) {
                                    html += '<div class="SNS_pop_img SNS_list_ul" data-logo="'+ result.groups[i].iflogo
                                        +'"><img src="'+ result.groups[i].logo+ '"></div>';
                                // 如果不存在 就是用别人的
                                }else{
                                    // 首先判断除了自己还剩几个人
                                    if (result.groups[i].membernum == 1) {
                                        html +='<div class="SNS_pop_img SNS_list_ul" data-logo="' + result.groups[i].iflogo +'">'
                                        + '<img src="'+ gUrlGetHead+ '?headurl='+ result.groups[i].memberinfo[0]+ '"/>'
                                        + '</div>';
                                    }else if (result.groups[i].membernum == 2) {
                                        html +='<div class="SNS_pop_img SNS_list_ul cls_im_single_list" data-logo="'+ result.groups[i].iflogo+'">'
                                        + '<div class="SNS_photo_number" style="position:absolute;margin:0px;">'
                                        + '<div class="SNS_photo_num21"><img src="'
                                        + gUrlGetHead+ '?headurl='+ result.groups[i].memberinfo[0]+ '" /></div>'
                                        + '<div class="SNS_photo_num22"><img src="'+ gUrlGetHead + '?headurl='
                                        + result.groups[i].memberinfo[1]
                                        + '" /></div>'
                                        + '</div>'
                                        + '</div>';
                                    }else if (result.groups[i].membernum == 3) {
                                        html +='<div class="SNS_pop_img SNS_list_ul" data-logo="'+ result.groups[i].iflogo +'">'
                                        + '<div class="SNS_photo_number" style="position:absolute;margin:0px;">'
                                        + '<div class="SNS_photo_num31"><img src="'+ gUrlGetHead+ '?headurl='
                                        + result.groups[i].memberinfo[0]
                                        + '" /></div>'
                                        + '<div class="SNS_photo_num32"><img src="'+ gUrlGetHead
                                        + '?headurl=' + result.groups[i].memberinfo[1]+ '" /></div>'
                                        + '<div class="SNS_photo_num33"><img src="' + gUrlGetHead+ '?headurl='+ result.groups[i].memberinfo[2]
                                        + '" /></div>'
                                        + '</div>'
                                        + '</div>';
                                    }else if(result.groups[i].membernum >= 4){
                                        html +='<div class="SNS_pop_img SNS_list_ul" data-logo="' + result.groups[i].iflogo +'">'
                                        + '<div class="SNS_photo_number" style="position:absolute;margin:0px;">'
                                        + '<div class="SNS_photo_num41"><img src="'+ gUrlGetHead+ '?headurl='
                                        + result.groups[i].memberinfo[0]
                                        + '" /></div>'
                                        + '<div class="SNS_photo_num42"><img src="' + gUrlGetHead+ '?headurl='
                                        + result.groups[i].memberinfo[1]
                                        + '" /></div>'
                                        + '<div class="SNS_photo_num43"><img src="'+ gUrlGetHead+ '?headurl='
                                        + result.groups[i].memberinfo[2]
                                        + '" /></div>'
                                        + '<div class="SNS_photo_num44"><img src="'+ gPublic+ '?headurl='
                                        + result.groups[i].memberinfo[3]
                                        + '" /></div>'
                                        + '</div>'
                                        + '</div>';
                                    }else{
                                        html += '<div class="SNS_pop_img SNS_list_ul" data-logo="' + result.groups[i].iflogo
                                        +'"><img src="'+ gUrlGetHead+ '?headurl='+ result.groups[i].selfinfo+ '"></div>';
                                    }
                                }

                                // 
                                // html += '<div class="SNS_pop_img SNS_list_ul"><img src="' + gUrlGetHead+ '?headurl=' + result.groups[i].imid + '"></div>';
                                html += '</div>';
                                html += '<div class="SNS_pop_text"><b title="'+result.groups[i].name+'" data-num="'+result.groups[i].membernum+'">' + cutstr_en(result.groups[i].name,$.WebChat.CONST.LEFT_CUT_STR_NUM,'...') + ' ('+result.groups[i].membernum+') ' +'</b><p></p></div>';
                                html += '</div>';     
                            }                        
                        }
                        
                        $.WebChat.myScroll($('.search_list_box'));
                        $('.search_list_box').find('.mCSB_container').html(html);
                    }
                });
            }
        }

    });
    //最近聊天框和联系人框切换
    $(".personal_Chatwindow").on('click', '.cls_im_tab_btn',function () {
        $(this).addClass('active').siblings().removeClass('active');
        var thisname = $(this).attr('name');
        if (thisname == 'thisleft') {
            $("#recentBox").show().siblings().hide();
        } else {
            $(".right_list_box").show().siblings().hide();
        }

    });

});
//点击左侧tab
function imTabLeftClick(){
	var obj = $('.cls_im_tab_left');
	obj.addClass('active').siblings().removeClass('active');
    var thisname = obj.attr('name');
    if (thisname == 'thisleft') {
        $("#recentBox").show().siblings().hide();
    } else {
        $(".right_list_box").show().siblings().hide();
    }
}
//设置置顶
function imSetup(talkType,str_stick_id,talkGroupID,groupNameOld,groupNameNew){
    //上传群组头像
    if($('#uphead').is(':visible')){
    	$.WebChat.uploadGroupAvatar(talkType,str_stick_id,talkGroupID,groupNameOld,groupNameNew);
    }else{
    	 $.WebChat.saveSetOption(talkType,str_stick_id,talkGroupID,groupNameOld,groupNameNew);
    }
}
/**
 * 这里应该是把单项数据添加到最近联系人列表中
 * @param imid
 * @param talkType
 * @param talkname
 * @param img
 * @param latelychatcontent
 * @param nums
 * @param stickMark 是否是置顶数据 true：置顶
 * @param obj
 */
function cancleStaticContacts(imid,talkType,talkname,img,latelychatcontent,nums,stickMark,obj){
	$.bug(5) && console.log(imid,talkType,talkname,img,latelychatcontent,nums,stickMark,obj)
	var html = '';
	$('#recentBox').find('.leftbox_' + imid).remove(); //先移除，然后在下面在添加,不然会重复
	var checkCurrColor = ''; //判断是否选中当前用户
	if($('input[name="clientid"]').val() == imid && ($('#Chatwindow_right').is(":visible") || $('#Information_Chat').is(":visible"))){
		$('#recentBox').find('.cls_im_single_list').css('background-color',$.WebChat.CONST.ITEM_DEFAULT_COLOR);
		checkCurrColor = 'style="background:'+$.WebChat.CONST.ITEM_CHECKED_COLOR+'"';
	}
	var chatDate = '', msgNotDisturb='';
	$.bug(5) && console && console.log(obj)
	if(obj && obj.length>0){
		chatDate = obj.find('.SNS_pop_time>em').length>0 ? obj.find('.SNS_pop_time>em').html() : ''; //聊天时间
		var notice = obj.find('.clsSnsNotNoticeLebal');
		$.bug(5) && console && console.log(obj.parents('#recentBox'))
		if(obj.parents('#recentBox').size() == 1){
			msgNotDisturb = notice.length>0?notice.wrap('<div></div>').parent().html(): ''; //消息免打扰图标
		}else{
			$.bug(5) && console && console.log($.WebChat.data.disturbImids[imid])
			if($.WebChat.data.disturbImids[imid] == 2){
				msgNotDisturb = '<i class="clsSnsNotNoticeLebal"><img src="' + gPublic + '/images/icons/SNS_mdarao_icon.png" /></i>'; //免打扰标志
			}
		}
	}else{
		$.bug(5) && console && console.log($.WebChat.data.disturbImids[imid])
		if($.WebChat.data.disturbImids[imid] == 2){
			msgNotDisturb = '<i class="clsSnsNotNoticeLebal"><img src="' + gPublic + '/images/icons/SNS_mdarao_icon.png" /></i>'; //免打扰标志
		}
	} 
	if (talkType =='talk') {
        html += '<div class="cls_im_single_list left_list_ul leftbox_' + imid + '" imid="' + imid + '" type="'+talkType+'" '+checkCurrColor+'>';
        html += '<div class="marginauto">';
        html += '<div class="SNS_pop_img SNS_list_ul"><img src="' + img + '"></div>';
        html += '<div class="SNS_pop_bg"></div>';
        stickMark ? html += '<div class="SNS_pop_zhiding"></div>' : '';
        html += '</div><div class="safariborder SNS_pop_bg_position cls_little_red_tips hide">0</div>';
        html += '<div class="SNS_pop_text">';
        html += '<b title="'+talkname+'">' + cutstr_en(talkname,$.WebChat.CONST.LEFT_CUT_STR_NUM,'...') + '</b>';
        html += '<p>'+latelychatcontent+'</p>';
        html += '</div>';
        html += '<div class="SNS_pop_time"><em>'+chatDate+'</em>'+msgNotDisturb+'</div>'; //消息免打扰
        html += '</div>';   
    }else if(talkType == 'groupTalk'){
        var img_html = $('.contact_'+imid).find('.SNS_pop_img').html();
        html += '<div class="cls_im_single_list left_list_ul leftbox_' + imid + '" imid="' + imid + '" type="'+talkType+'" '+checkCurrColor+'>';
        html += '<div class="marginauto">';
        html += '<div class="SNS_pop_img SNS_list_ul">' + img_html + '</div>';
        html += '<div class="SNS_pop_bg"></div>';
        stickMark ? html += '<div class="SNS_pop_zhiding"></div>' : '';
        html += '</div><div class="safariborder SNS_pop_bg_position cls_little_red_tips hide">0</div>';
        html += '<div class="SNS_pop_text">';
        html += '<b title="'+talkname+'" data-num="'+nums+'">' + cutstr_en(talkname,$.WebChat.CONST.LEFT_CUT_STR_NUM,'...') +'('+nums+')'+ '</b>';
        html += '<p>'+latelychatcontent+'</p>';
        html += '</div>';
        html += '<div class="SNS_pop_time"><em>'+chatDate+'</em>'+msgNotDisturb+'</div>'; //消息免打扰
        html += '</div>';
    }else if(talkType == $.WebChat.CONST.CHAT_TYPE.PUBLIC){
        var img_html = $('.publicno_'+imid).find('.SNS_pop_img').html();
        html += '<div class="cls_im_single_list left_list_ul leftbox_' + imid + '" imid="' + imid + '" type="'+talkType+'" '+checkCurrColor+'>';
        html += '<div class="marginauto">';
        html += '<div class="SNS_pop_img SNS_list_ul">' + img_html  + '</div>';
        html += '<div class="SNS_pop_bg"></div>';
        html += '</div><div class="safariborder SNS_pop_bg_position cls_little_red_tips hide">0</div>';
        html += '<div class="SNS_pop_text">';
        html += '<b title="'+talkname+'">' + cutstr_en(talkname,$.WebChat.CONST.LEFT_CUT_STR_NUM,'...') + '</b>';
        html += '<p>'+latelychatcontent+'</p>';
        html += '</div>';
        html += '<div class="SNS_pop_time"><em></em></div>'; //消息免打扰
        html += '</div>';
    }
	
	//$(html).insertBefore($('.left_list_box .mycontacts .left_list_ul').eq(0))
	if(stickMark){
		$('.SNS_pop_box .mystick').append(html);
	}else{
		$('.SNS_pop_box .mycontacts').append(html);
	}
	//临时数据绑定右键菜单
    var opts = {'selector':'#recentBox .leftbox_'+imid};
    $.WebChat.bindRightMenu(opts);
}
//置顶聊天,old应该没有使用了
function setStick(TalkType,fuid, clientid, groupid, stick){
    $.post(setStickUrl, {TalkType:TalkType,fuid:fuid,clientid: clientid, groupid: groupid, stick: stick}, function (result) {
        if(result.status!=0){
        	$.global_msg.init({msg:gImSetStickFail,btns:true});
        }else{
        	$.global_msg.init({msg:gImSetStickSucc,btns:true});
        }
    })         
}
//加入黑名单 ,old应该没有使用了
function setBlock(obj, clientid, groupid, block, setOrnot) {
    var setResult = true;    
    $.ajax({  
        type: "post",  
        url: setBlockUrl,
        async: false,
        data: {clientid: clientid, groupid: groupid, block: block},
        success: function(result) {    
        }
    });
    return setResult;
}
//设置消息免打扰, old应该没有使用了
function setMsg(obj, clientid, groupid, msg, setOrnot) {
    $.ajax({  
        type: "post",  
        url: setMsgUrl,
        async: false,
        data: {clientid: clientid, groupid: groupid, msg: msg},
        success: function(result) {          
            if (result.status != '0') {
                layer.msg(js_setnomsgfail);
                //如果是设置失败，移除选中，反之 给选中状态
                if (setOrnot) {
                    $(obj).find('.myphoto_ppic').removeClass('active');
                    $(obj).find('.checkbox').prop("checked", false);
                } else {
                    $(obj).find('.myphoto_ppic').addClass('active');
                    $(obj).find('.checkbox').prop("checked", true);                
                }
            }
        }
    });
}
//更新群组头像
function modifyGroupLogo(groupId){
    $.ajax({  
        type: "post",  
        url: getGroupNewLogo,
        async: false,
        data: {groupId: groupId},
        success: function(logo) {     
        	$.bug(5) && console && console.log(logo);
            var clientid = $('.contact_zone').attr('clientid');
            var img = "<img class='mCS_img_loaded' src='"+logo+"'>";
            $('.leftbox_'+clientid).find('.SNS_pop_img').html(img);
            $('.contact_'+clientid).find('.SNS_pop_img').html(img);
            $('.contact_'+clientid).attr('headid',logo);
            $('.contact_zone').find('.SNS_pop_img').html(img);
        }
    });
}
