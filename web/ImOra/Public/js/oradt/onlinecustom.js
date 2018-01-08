/**
 * 在线客服功能主js
 */
;
(function($){
	$.extend({
		custom:{			
			cache:{/*数据缓存处理*/
				msgNewNum:{}, /*每个好友的未读消息数量*/ //未读消息存储[imid] = 5
				noReply:{}, //未回复
				replyImids: {},//已经回复imid列表
				leftGenFriend:{},//好友imid列表：[imid] = 1
				askUserImids: {},//咨询用户imid列表[imid] = 1;
				userInfo:{}, //用户信息
				friendInfo:{}, //好友信息列表
				imidClientMap:{}, //imid-client映射关系
				historyPage: 1,
				currChatImid: 0, //当前正在对话的好友imid
				askUserCount:0, //咨询用户数量
				serviceUserCount:0 //服务用户数量
			},
			init: function(){
				$.replyTable.getReplyedNum();
				$.custom.bindEvt.initBind();
				// 每秒检查消息发送状态
				setInterval($.custom.checkSendingStatus, 1000);
			},
			/*绑定对象方法*/
			bindEvt:{
				initBind:function(){
				    //点击按钮发送聊天消息
			        $('#btn_send_msg').click(function(){
						$.custom.sendTextMsg();
			        });
					//上传图片，发送图片
					$('#uploadImgForm').on('change','#uploadImgFieldIm',function(event){
		            	$.custom.uploadImg($(event.target));
					});
					
					//关闭聊天对话框
					$('#js_right_total').on('click','.close_pic>img', function(){
						$.custom.closeUserDialog();
					});					
					
	                //表情弹出层
	                $('#openFacePop').on('click', function (event) {
	                 	$.custom.openFacePop($(this));
	                });
	                
	                //点击左侧好友列表打开右侧对话框
	                $('#js_left_friend_list').on('click','.js_friend_single',function(){
	                	var obj = $(this);
	                	if(obj.hasClass('on')){
	                		return;
	                	}
	                	obj.removeClass('js_custom_flicker');
	                	$('.section_top_navigation').hide();
	                	var imid = obj.attr('imid');
	                	$.custom.cache.currChatImid = imid; //当前正在聊天的聊天号
	                		obj.parent().children().removeClass('on');
	                		obj.addClass('on');
	                	$.custom.getHistory(imid); //加载历史记录
	                	var rightChatDialog = $('#js_right_total'); //右侧对话框对象
	                		rightChatDialog.is(':hidden') ?　rightChatDialog.show() : null; //显示对话框
	                		rightChatDialog.attr('imid',imid);
	                		//设置右侧头部用户信息
	                	var rightTop = rightChatDialog.find('.Customer_right-top');
	                	var rightTopName = ''==obj.find('.span_name i').text() 
	                	                    ? 
	                	                   obj.find('.span_name em').text() : obj.find('.span_name i').text();
	                		rightTop.find('.safariborder').attr('src',obj.find('img').attr('src'));
	                		rightTop.find('.span_name').text(rightTopName);	                		
	                		$('#js_left_friend_list').find('.js_friend_single[imid="'+imid+'"]').find('i').css('color','');
	                });
	                
	                //客服菜单点击事件
	                $('.js_custom_menu').click(function(){
	                	var divObjs = new Array('js_vr_bind','Customer_collection','js_reply_frame');
	                	var index = $('.js_custom_menu').index($(this));//获取被点击的一级菜单的索引
	                	var currIndex = index;
	                	if(index > 0 && gLoginIm.isBinded == '0'){//未绑定虚拟用户时
	                		$.global_msg.init({gType:'warning',icon:2,msg:gStrCustomPleaseBindVrAccount });
	                		return;
	                	}else{	                		
	                		//对咨询记录子菜单的处理
	                		if(index == 3){//点击资讯自己子菜单时
	                			 currIndex = 2;
	                		}else if(index == 2){//点击咨询记录菜单本身时
	                			if ($('.js_custom_menu>li.active').length==0) {
	                			   $('.js_custom_menu>li:eq(0)').addClass('active');
	                			}
	                		}else{//点击“虚拟用户绑定菜单”、“在线咨询” 菜单时
	                			 $('.js_custom_menu>li').removeClass('active');
	                		}	                		
	                		$('.js_custom_menu').removeClass('car').eq(currIndex).addClass('car');
	                	}
	                	//i=0 表示：绑定虚拟用户，i=1:在线咨询，3：
	                	for(var i=0;i<divObjs.length;i++){
	                		if(i == currIndex){
	                			$('.'+divObjs[currIndex]).show();
	                		}else{
	                			$('.'+divObjs[i]).hide();
	                		}
	                		
	                		if(i == 0 && currIndex==0){
	                			showBindIndex();
	                			$('.section_top_navigation').show();
	                			var menuChildTitle = gStrCustomTopMenu+'->'+gStrCustomVrUserBind;
	                			$('.section_top_navigation>span:eq(1)').html(menuChildTitle);
	                		}else if(i == 2 && currIndex == 2){
	                			var currLiIndex = $('.js_custom_menu li.active').index();
	                			//已经回复、未回复
	                			var opts = {currMenuIndex: currLiIndex};
	                			$.replyTable.init(opts);                			
	                			$('.section_top_navigation').show();
	                		}else if(currIndex == 1){
	                			$('.section_top_navigation').hide();
	                			//点击左侧【在线咨询】菜单时执行这里
	                			var tmpIndex = 0;
	                			for(var j in $.custom.cache.friendInfo){
	                				tmpIndex++;
	                				break;
	                			}
	                			if(tmpIndex == 0){
	                				 $('.Customer_collection').hide(); //默认隐藏右边的部分
	                			}else{
	                				$('.Customer_collection').show();
	                			}
	                			
	                		} 
	                	}
	                });
	                //点击咨询记录子菜单时触发
	                $('.js_custom_menu:eq(3)').on('click','li',function(){
	                	if(gLoginIm.isBinded == '0'){
	                		return true;
	                	}
	                	var obj = $(this);
	                	var indexChild = obj.index();
	                	obj.siblings().removeClass('active');
	                	obj.addClass('active');
	                	$('.js_page_input').val(''); //清空页码输入框中值
	                });
	                // 点击图片信息， 弹出图片展示
	                $('#js_right_total').on('click', '.pic_i img', $.custom.showMsgImg);
	                
	              textControl({num:500,obj:'#js_textarea',numObj:'.js_input_num'})
				}
			},
			/*点击图片信息， 弹出图片层处理*/
			showMsgImg : function () {
				var msg = '<div style="width: 1000px;height: 800px;float: left; margin: 0px 10px 0 0;list-style: none;text-align: center;font-size: 0;">\
					        <span style="display: inline-block; width: 1px; height: 100%; vertical-align: middle;"></span><img style="max-width:100%;max-height:100%; margin-left:-1px;vertical-align:middle;" src="' + $(this).attr('src') + '"/>\
					       </div>';
				//$.global_msg.init({msg:msg, time:0, width:screen.width-200, height:screen.height-200});
				var i = $.layer({
				    type : 1,
				    title : false,
				    fix : false,
				    offset:['50px' , ''],
				    area : ['1000px','800px'],
				    page : {html : msg}
				});
			},
			/*客服左侧菜单功能处理*/
			leftMenu: function(){
				if(gLoginIm.isBinded == '0'){
					$('.js_custom_menu').removeClass('car').eq(0).addClass('car');
				}else{
					$('.js_custom_menu').removeClass('car').eq(1).addClass('car')
				}
			},
			/*设置服务用户和咨询用户数量*/
			setCount: function(num){
				var askCount = 0;
				var serviceCount = 0; //服务用户数
            	$.ajax({
           		 type: "get",
           		 url: gUrlGetFriendInfo,
           		 data:   {flag:1},
           		 async:false,
           		 dataType:'json',
           		 success: function(rst){
           			serviceCount = rst.data.serviceNum;
           			askCount = rst.data.askNum;
           		 }
            	});  
            	$('.js_service_count').text(serviceCount); 
            	$('.js_ask_count').text(askCount);
			},
			/*发送文本消息*/
			sendTextMsg: function(){
				var content = $('#js_textarea').val(); //var content = ueColl.getContent(); //编辑器插件获取内容
	        	if($.trim(content) == ''){
	        		layer.tips('回复内容不能为空！', '#btn_send_msg', {
	        	        time: 2,
	        	        style: ['background-color:#f29c8b ; color:#fff', '#f29c8b '],
	        	        maxWidth:240
	        	    });
	        		return;
	        	}
	        	//发送文本消息时，处理空格、换行
	        	//content = $.trim(content.replace(/(\n)|(&nbsp;)/ig,''));
	    		content = content.replace(/(&nbsp;)/ig, String.fromCharCode(32)); //替换空格
				content = content.replace(/(&amp;)/ig, '&'); 
				content = content.replace(/(&quot;)/ig, '"');
				content = content.replace(/(&#039;)/ig, "'");
				content = content.replace(/(&lt;)/ig, '<');
				content = content.replace(/(&gt;)/ig, '>');
				
				var imid =  0;
				if(typeof($('#js_right_total').attr('imid')) == 'undefined' || $('#js_right_total').attr('imid')==''){
					imid = $('#js_receive_user').val();
				}else{
					imid =  $('#js_right_total').attr('imid');
				}
				//subscribeUserStatus(oo,parseInt(imid));
				var seqId =  Math.uuid();
				var imid  = parseInt(imid);
				SendTextMessage(oo,0,0,imid,seqId,content);
				//ueColl.setContent('');
				$('#js_textarea').val('').trigger('keydown');
				//填充发送文本消息到聊天对话框中
				var obj = {
						imid: imid,
						content: content,
						sequence: seqId,
						issend: 0,
						type: 1,
						issending:1
					};
				$.custom.fillSingleMsgToChat(obj);
			},
			sendTextMsgToSelf: function(){/*登陆成功后给自己发送一条消息*/
				var seqId =  Math.uuid();
				var imid  = parseInt(gLoginIm.imid);
				SendTextMessage(oo,0,0,imid,seqId,'');
			},			
			/*打开表情弹出层*/
			openFacePop: function(thisObj){
                var show = $('.hiddenfaces').css('display');
                if ($('.hiddenfaces').is(':hidden')) {
                	$('.hiddenfaces').show();
                	if($('.hiddenfaces').children().length == 0){
                        //点击表情区域外 隐藏表情框
                        $(document).on('click', function (e) {
                        	if($(e.target).attr('id') != 'openFacePop'){
                                $('.hiddenfaces').hide();
                                e.stopPropagation();//阻止事件向上冒泡
                                thisObj.removeClass('active');
                        	}
                        });                       
                        $.post(getFacesUrl, {}, function (data) {
                            var html = '<div class="message_title_box"><i class="titlespan"></i><em class="spantitle_img" style="display:none;"><img src="'+gPublic+'/images/icons/message_face_iconcolse.jpg" /></em></div>';
                            html +="<div class='cls_face_content' style='height:140px;'>"
                            for (var i = 0; i < data.length; i++) {
                                html += '<span class="select_face"><img src="' + data[i].url + '" tags="' + data[i].tags + '"></span>';
                            }
                            html +='</div><div class="message_point_list_zstub"><img src="'+gPublic+'/images/icons/sns_mapselect.png" /></div>';
                            $('.hiddenfaces').html(html).show();
                            $.custom.myScroll($('.cls_face_content'));
                            //选中表情后事件
                            $('.select_face').click(function () {
                                //$('.hiddenfaces').show();
                                var html = $(this).html();
                                var face = $(this).children('img').attr('tags');
                                //$('#contentEditor').find('.mCSB_container').append(html);//xgm 2015-7-13
                                //往隐藏输入框插入表情对应的关键词
                              //  $('textarea[name="talkContent"]').append(face);
                                //在光标处插入表情标志
                                insertText(document.getElementById('js_textarea'),'['+face+']');
                            });
                        });
                	}else{
                		
                	}
                } else {
                    $('.hiddenfaces').hide();
                }
			},
			/*上传图片*/
			uploadImg: function(thisObj){
            	var id   = thisObj.attr('id');
            	var opts = {'fileFieldName':id, 'binaryType':'pic'};
                var names= thisObj.val().split(".");
                var extentionName = names.pop(names).toLowerCase();// 获取扩展名
                var allowedExtentionNames = ['gif', 'jpg', 'jpeg', 'png']; // 允许的图片扩展名列表
                if($.inArray(extentionName, allowedExtentionNames)==-1){
                    $.global_msg.init({msg:gAllowTupian,btns:true});
                    return true;
                }
            	$.WebChat.ajaxUploadAttach(opts);
			},
			/*发送图片*/
			sendImg: function(){},
			myScroll: function(scrollObj,html){
				//滚动条生效后不再执行
	        	if(!scrollObj.hasClass('mCustomScrollbar')){
	        		typeof(html) != 'undefined' ?  scrollObj.append(html) : null;
	        		scrollObj.mCustomScrollbar({
				        theme:"dark", //主题颜色
				        autoHideScrollbar: false, //是否自动隐藏滚动条
				        scrollInertia :0,//滚动延迟
				        horizontalScroll : false//水平滚动条
				        
				    });
	        	}else{
	        		typeof(html) != 'undefined' ? scrollObj.find('.mCSB_container').append(html) : null;
	        	}
			},
			/*发送消息回调*/
			callbackSend: function(msgObj){
				var msgId = 'msg' + msgObj.sSeqID;
				$('#'+msgId).removeClass('sending');
				if ('0'!=msgObj.nResult) {// 发送失败
					$('#'+msgId).removeClass('sendingOk').addClass('sendingFail');
				} else {
					$('#'+msgId).removeClass('sendingFail').addClass('sendingOk');
				}
				if('undefined' == typeof($.custom.cache.replyImids[msgObj.nToUserID])){
					$.replyTable.getReplyedNum();
					$.custom.cache.replyImids[msgObj.nToUserID]  = 0;//填充已回复对象
				}				
			},
			/*接收消息回调(文本和图片)*/
			callbackReceive: function(obj){
				//处理未回复时间
				if('undefined' != typeof($.custom.cache.noReply[obj.imid])){
					$.custom.cache.noReply[obj.imid] = obj.nTime; //图片与文本消息时间
				}
				// 新消息播放声音
				document.getElementById('new_msg_alert').currentTime = 0;
				document.getElementById('new_msg_alert').muted = false;
				document.getElementById('new_msg_alert').play();
				
				$.custom.fillSingleMsgToChat(obj);				
				
				//判断发消息人是否计入到了咨询用户数中
				var tmpDate = new Date(); //通过时间来大概判断是离线消息还是在线消息，有误差
				if(tmpDate.getTime() - obj.nTime*1000 <= 5 && 'undefined' == typeof($.custom.cache.askUserImids[obj.imid])){
					$.custom.cache.askUserImids[obj.imid] = 1;
	            	$.ajax({
	           		 type: "get",
	           		 url: gUrlGetAskNum,
	           		 async:true,
	           		 dataType:'json',
	           		 success: function(rst){
	           			$('.js_ask_count').text(rst.data);
	           		 }
	            	});  
	            	
				}
			},
			/**
			 * 填充消息到聊天对话框中
			 */
			fillSingleMsgToChat: function(obj){
				//判断对话框是否打开
				if($('.js_custom_menu:eq(1)').hasClass('car') && $('#js_right_total').attr('imid') == obj.imid){//对话框已经打开
					var classArr = $.template.chatLeftRightCls;
					//判断左右边显示及头像,issend:0 自已发的，1 对方发的
					if(obj.issend == 0){
						$.extend(obj,classArr['right']);
						obj.clientid  = $.webim.CONST.U_INFO.clientid;
					}else{
						obj.clientid  = $.custom.cache.imidClientMap[obj.imid];
						$.extend(obj,classArr['left']);
					}
					if(obj.type == 2){
						obj.evt = 'onload="$.webim.scrollToBottom()"';
					}
					var html = $.template.generalHistorySingle(obj);
					//添加聊天记录
					var scrollObj = $('#js_right_total>.js_chat_content');
					//滚动条生效后不再执行
		        	if(!scrollObj.hasClass('mCustomScrollbar')){
		        		scrollObj.append(html);
		        		scrollObj.mCustomScrollbar({
					        theme:"dark", //主题颜色
					        autoHideScrollbar: false, //是否自动隐藏滚动条
					        scrollInertia :0,//滚动延迟
					        horizontalScroll : false//水平滚动条
					        
					    });
		        	}else{
		        		scrollObj.find('.mCSB_container').append(html)
		        	}
				}else{
					//对话框未打开时，放置到未回复对象中
				}
				setTimeout($.webim.scrollToBottom,100);
			},
			/*未回复消息登陆后的回调*/
			callbackNoReply: function(){				
			},
			/*从im发送过来的图片消息*/
			fromImGetImage: function(){
				
			},
			/*从后台获取历史记录*/
			getHistory: function(imid){
			     $.custom.cache.historyPage = 1;
            	//获取聊天记录
                $.post(gUrlGetHistory, {imid: imid,page:$.custom.cache.historyPage}, function (rst) {
                	if(rst.status == 0){
                		 $.template.generateHistoryList(rst.data);
                	}                   
                },'json');
			},
			loadMoreHistory: function(imid){
				$.custom.cache.historyPage++;
            	//获取聊天记录
                $.post(gUrlGetHistory, {imid: imid,page:$.custom.cache.historyPage}, function (rst) {
                	if(rst.status == 0){
                		 $.template.generateHistoryList(rst.data, false);
                	}                   
                },'json');
			},
			/*异步接收到的消息填充到聊天对话框中*/
			receiveMsgFillDialog: function(){				
			},
			/*发送消息后填充到聊天对话框中*/
			sendMsgFillDialog: function(){				
			},
			/*根据每条消息生成会话框(包括发送、接收、查询历史记录)*/
			_generalHistory: function(){
			//包括send,receive,文本、图片				
			},
			//关闭用户聊天会话框
			closeUserDialog: function(){
				var imid = $('#js_right_total').attr('imid');
				$('#js_left_friend_list .js_friend_single[imid="'+imid+'"]').remove();
				
				delete $.custom.cache.leftGenFriend[imid];
				delete $.custom.cache.msgNewNum[imid];
				delete $.custom.cache.friendInfo[imid];
				$('#js_right_total').removeAttr('imid');
				
				var friendList = $('#js_left_friend_list .js_friend_single');
				if(friendList.length>0){
					friendList.first().click();							
				}else{
					$('.Customer_collection').hide();//没有咨询用户是，隐藏所有右侧部分
				}
				$.custom.setCount(); //设置服务用户数和咨询用户数
			},
			//离线消息、离线用户处理
			/*offlineMessage: function(obj){
				$.custom.cache.msgNewNum[obj.sendImid] = obj.num; //未读消息数量
				$.custom.genLeftFriendList();
			},*/
			//判断是否存在好友基本信息
			isExistFriendInfo: function(obj){
				//判断是否有未读消息
				 if($.custom.cache.currChatImid == 0){
					 //当前没有还没有正在打开的窗口的咨询用户
					 $.custom.cache.currChatImid = obj.sendImid;
				 }else{/*当前有打开窗口的咨询用户,新消息处理*/
					if($.custom.cache.currChatImid > 0 && $.custom.cache.currChatImid != obj.sendImid){
						$.custom.cache.msgNewNum[obj.sendImid] = 1;
						var objDiv = $('#js_left_friend_list').find('.js_friend_single[imid="'+obj.sendImid+'"]');
						objDiv.length>0 ? objDiv.addClass('js_custom_flicker') : null;
					}
				 }
				
				if(typeof($.custom.cache.friendInfo[obj.sendImid]) == 'undefined'){
					$.custom.getFreindInfo(obj.sendImid);
				}
			},
			/*获取用户信息*/
			getFreindInfo: function(imid){
				$.get(gUrlGetFriendInfo,{imids:imid},function(rst){
					if(rst.data.length != 0){
						$.custom.cache.friendInfo[imid] = rst.data;
						$.custom.cache.userInfo[imid] = rst.data;
						$.custom.cache.imidClientMap[imid] = rst.data.fuserid;
						$.custom.genLeftFriendList();
					}else{
						$.bug(4) && console && console.log('获取好友信息为空');
					}
				});
			},
			//生成左侧好友列表
			genLeftFriendList: function(){
				//$('.Customer_collection').is(':hidden') ? $('.Customer_collection').show() : null;
				var html = '';
				for(var imid in $.custom.cache.friendInfo){
					if(typeof($.custom.cache.leftGenFriend[imid]) == 'undefined'){
						var obj = $.custom.cache.friendInfo[imid];
						var mobile = obj.mobile;
						var name = obj.name;
						var fuserid = obj.fuserid;
						var avatarpath = obj.avatarpath;
						if(!avatarpath || avatarpath == ''){
							gUrlGetHead = gUrlGetHead.replace('.html','');
							avatarpath = gUrlGetHead+'?headurl='+fuserid;
						}	
						//生成左侧用户信息
						$.custom.cache.leftGenFriend[imid] = 1;
						var redChangeCss = $.custom.cache.msgNewNum[imid] == 1 ?  'js_custom_flicker' : ''; //新消息处理
						var html = '<div class="Customer-left-list js_friend_single '+redChangeCss+'" imid="'+imid+'" fuserid="'+fuserid+'" style="cursor:pointer;">\
										<span class="span_pic safariborder"><img class="safariborder" src="'+avatarpath+'" /></span>\
										<span class="span_name">\
										<i>'+name+'</i>\
										<em>'+mobile+'</em>\
										</span>\
									</div>';
						$.custom.myScroll($('#js_left_friend_list'),html);					  
						  //打开第一个咨询用户对话框
						  if(typeof($('#js_right_total').attr('imid')) == 'undefined' ){
							  $('.js_custom_menu:eq(1)').trigger('click'); // 激活左侧在线咨询菜单
							  $('#js_left_friend_list .js_friend_single:eq(0)').click();
							  $('.Customer_collection').is(':hidden') ? $('.Customer_collection').show() : null;
							  $.custom.setCount(); //设置服务用户数和咨询用户数
						  }	
						  
					}
				}
			},
			/* 检查消息发送状态 */
			checkSendingStatus : function () {
				$('#js_right_total .sending').each(function() {
					var sentTime = $(this).attr('data-sent-time');
					var date = new Date();
					if (5000<(date.getTime()-sentTime)) {
					    $(this).removeClass('sending').removeClass('sendingOk')
					           .addClass('sendingFail');	
					}
				});
			}
		},
		
		/*工具处理类*/
		tools:{
		},
		
		/*所有模板的处理在这里进行*/
		template: {
			chatLeftRightCls:{'left':{'cls1':'sender','cls2':'left_triangle'},'right':{'cls1':'receiver','cls2':'right_triangle'}}, //定义聊天记录class
			//生成历史记录模板
			generateHistoryList: function(dataObj, scrollToBottom){
				scrollToBottom = 'undefined'==(typeof scrollToBottom) ? true : scrollToBottom;
				var html = '';
				if(dataObj.list.length > 0){
					var dataList = dataObj.list;					
					var len = dataList.length;
					var classArr = $.template.chatLeftRightCls;
					for(var i=0; i<len; i++){
						var obj = dataList[i];
						//判断左右边显示及头像,issend:0 自已发的，1 对方发的
						if(obj.issend == 0){
							$.extend(obj,classArr['right']);
							obj.clientid  = $.webim.CONST.U_INFO.clientid;
						}else{
							obj.clientid  = $.custom.cache.imidClientMap[obj.imid];
							$.extend(obj,classArr['left']);
						}
						html += $.template.generalHistorySingle(obj);
					}
					
				}				
			
				//添加聊天记录
				var scrollObj = $('#js_right_total>.js_chat_content');
				//滚动条生效后不再执行
	        	if(!scrollObj.hasClass('mCustomScrollbar')){
	        		$.custom.cache.historyPage==1 ? scrollObj.html(html) : scrollObj.children().first().before(html);
	        		scrollObj.mCustomScrollbar({
				        theme:"dark", //主题颜色
				        autoHideScrollbar: false, //是否自动隐藏滚动条
				        scrollInertia :0,//滚动延迟
				        horizontalScroll : false,//水平滚动条
				        callbacks:{
				            onScroll: function(){}, //滚动完成后触发事件
				            onTotalScrollBack: function(){/*当滚动到底部的时候调用这个自定义回调函数*/
				            	//加载更多聊天记录，滚动分页
				            	var tmpImid = $('#js_right_total').attr('imid');
				            	$.custom.loadMoreHistory(tmpImid);
				            }
				        }				        
				    });
	        	}else{
	        		$.custom.cache.historyPage==1 ? scrollObj.find('.mCSB_container').html(html) : scrollObj.find('.mCSB_container').children().first().before(html);
	        	}
	        	if (scrollToBottom) {
		        	$.webim.scrollToBottom();
	        	} else {
            	    scrollObj.mCustomScrollbar('scrollTo',2,{ moveDragger:true }); // bug#14346
	        	}
	        	$('#js_left_friend_list').mCustomScrollbar("scrollTo",'.on');
			},
			/*单条聊天记录*/
			generalHistorySingle: function(obj){
				 var date = new Date();
				 var nowYear = date.getFullYear();
				 var headUrl =  gUrlGetHead+'?headurl='+obj.clientid;
				 var sendingClass = 'undefined'!=typeof(obj.issending) && obj.issending==1 ? ' sending' : '';
				 var sendingTime = ''==sendingClass ? '' : (' data-sent-time="'+date.getTime()+'"') ;
				 // 设置消息时间。 主动发送的消息，时间显示为当前时间
				 obj.nTime ? date.setTime(obj.nTime*1000) : null; // 收到的即时消息
				 obj.datetime ? date.setTime(obj.datetime*1000) : null; // 历史消息
				 var dateFormat = date.getFullYear()!=nowYear ? 'Y/m/d H:i' : 'm/d H:i';

				 if (obj.type == '2' && obj.content.indexOf("filetype='pic'")===-1) {
					 obj.type = '3';
				 }
				 if(obj.type == '1'){/*文本*/
					 var content = $.WebChat.dealWithTrimShow(obj.content); //转换空格、换行
					     content = $.WebChat.dealWithFaceShow(content);
					 return '<div class="'+ obj.cls1 + sendingClass + '" id="msg' + obj.sequence+'"'+sendingTime+'>\
			 			<div><img class="safariborder" src="'+headUrl+'"></div>\
						<div>\
							<div class="'+obj.cls2+'"></div>\
							<span>'+content+'</span>\
						</div>\
					    <div class="msg_time">' + date.format(dateFormat) + '</div>\
					</div>';
				 }else if(obj.type == '2'){/*图片*/
					 var downObj = $(obj.content);
					 var evt = typeof(obj.evt) == 'undefined' ? '' : obj.evt;
					 return '<div class="'+obj.cls1 + sendingClass + '" id="msg'+obj.sequence+'"'+sendingTime+'>\
			 			<div><img class="safariborder" src="'+headUrl+'"></div>\
						<div>\
							<div class="'+obj.cls2+'"></div>\
							<i class="pic_i"><img src="'+downObj.attr('url')+'" '+evt+'/></i>\
						</div>\
					    <div class="msg_time">' + date.format(dateFormat) + '</div>\
					</div>';
				 } else {/*其他消息类型记录*/
					 var downObj = $(obj.content);
					 var evt = typeof(obj.evt) == 'undefined' ? '' : obj.evt;
					 return '<div class="'+obj.cls1 + sendingClass + '" id="msg'+obj.sequence+'"'+sendingTime+'>\
			 			<div><img class="safariborder" src="'+headUrl+'"></div>\
						<div>\
							<div class="'+obj.cls2+'"></div>\
							<span>不支持的消息类型<img src="'+JS_PUBLIC+'/images/icon_audio_msg.png"/><span>\
						</div>\
					    <div class="msg_time">' + date.format(dateFormat) + '</div>\
					</div>';
				 }
			}
		}		
	});
})(jQuery);

// http://www.nowamagic.net/librarys/veda/detail/1266 光标问题
// http://zhidao.baidu.com/link?url=caEHBo4l9Fuokm6cWbpMNBXuqwMmRm7DHDoOrzbwz5dNylsOnJb9k6DnauuEXAAWZJJIMBO0cwU2GmHsWmKVf_
function insertText(obj,str) {
    if (document.selection) {
        var sel = document.selection.createRange();
        sel.text = str;
    } else if (typeof obj.selectionStart === 'number' && typeof obj.selectionEnd === 'number') {
        var startPos = obj.selectionStart,
            endPos = obj.selectionEnd,
            cursorPos = startPos,
            tmpStr = obj.value;
        obj.value = tmpStr.substring(0, startPos) + str + tmpStr.substring(endPos, tmpStr.length);
        cursorPos += str.length;
        obj.selectionStart = obj.selectionEnd = cursorPos;
    } else {
        obj.value += str;
    }
}


// 文本输入框内容表情、换行的转换。
function textControl(obj){
	var num = obj.num;
	var numObj = obj.numObj;//还可写入多少数字
	var obj = obj.obj;//存放content的div
	var contentObj = $(obj);//$(obj).find('.mCSB_container');
	var val = contentObj.val();//将图片转换成[fXXX]格式
    var val = (val.length > num)?val.substring(0,num):val;	
	var len = val.length;
	var cha = (num - len) >= 0?(num - len):0;
    $(numObj).html(len);
	contentObj.on({
        'keyup':function(){
            var val = contentObj.val();//将图片转换成[fXXX]格式
            if (val.length > num) {
            	val = (val.length > num)?val.substring(0,num):val;
            	contentObj.val(val);
            };
            			            
			var len = val.length;			           
            var cha = (num - len) >= 0?(num - len):0;
            $(numObj).html(len);	
    		////$('.content_text').mCustomScrollbar('update'); 
			//$('.content_text').mCustomScrollbar('scrollTo','bottom'); 
        },
        'keydown' :function(){
            var val = contentObj.val();//将图片转换成[fXXX]格式
             if (val.length > num) {
            	val = (val.length > num)?val.substring(0,num):val;
            	contentObj.val(val);
            };
            val = (val.length > num)?val.substring(0,num):val;
            var len = val.length;
            var cha = (num - len) >= 0?(num - len):0;
            $(numObj).html(len);			           	
     		//$('.content_text').mCustomScrollbar('update'); 
			//$('.content_text').mCustomScrollbar('scrollTo','bottom'); 
        }
    });
}
