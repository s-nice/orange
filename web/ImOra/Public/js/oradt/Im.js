/**
 *IM通用聊天
 */
;
(function($){
	$.extend({
		webim : {
			init : function() {
				$.webim.loginIM();
				//$.webim.CONST.isImModule ? $.sns_common.getStick():null; //获取置顶列表与最近聊天列表
			},
			CONST:{
				CONNECTION: false, /*是否连接上im了*/
				CONN_MAX: 10, /*最多连接次数*/
				CON_CONN_MAX: 10,
				CONN_WAIT_TIME: 10000, /*多次连接时间间隔，单位秒*/
				U_INFO: [], /*存放用来登陆的信息*/
				IM_ID:0 //当前登录用户imid
			},
			/**
			 * 聊天框滚动条定位到底部
			 */
			scrollBottom:function(){
			},
			scrollToBottom:function(){
				$('.js_chat_content').mCustomScrollbar('update'); 
				$('.js_chat_content').mCustomScrollbar('scrollTo','bottom'); 
			},
			/**
			 * 登陆IM(im相关操作)
			 */
			loginIM : function() {
				window.oo = new Object();
				// 获取用户账号，登陆并且订阅好友
				$.webim.CONST.U_INFO = gLoginIm;
				login2(oo, gLoginIm.clientid, gLoginIm.passwd, gLoginIm.sid,1,socketServerUrl, socketServerPort, websocketUrl);
				$.bug(5) && console && console.info('第一次登陆sessionid=',gLoginIm.sid);
				// 登录回调函数
				oo.OnLogin = function(msg) {
					if (parseInt(msg.userID) > 0) {
						GetAllPushMsg(oo);
						//$.custom.sendTextMsgToSelf();/*给自己发送一条空消息，解决客服收不到手机端消息问题*/
						//$.webim.CONST.isImModule ? $.sns_common.genStickContack():null; //获取置顶列表与最近聊天列表
						$.WebChat.IEActiveConnect(); //解决IE断开的问题
						$.webim.CONST.IM_ID = msg.userID;
						$.bug(2) && console && console.info('IM登陆成功',oo);
						$.webim.CONST.CONNECTION = true;
						$.webim.CONST.CONN_MAX = $.webim.CONST.CON_CONN_MAX;
						$.replyTable.setReplyCount();
					} else {
						$.bug(1) && console && console.error('IM登陆失败',oo,msg);
						$.webim.CONST.CONNECTION = false;
						$.webim.loginAgain();
						$.global_msg.init({msg : '失去服务器的连接, 请刷新页面重试',icon : 0, time : 3});//gImLoginFail
					}
				};
				// 连接服务器状态回调
				oo.OnConnectResult = function(msg) {
					//console && console.info("onConnectResult: 连接服务器回调" + msg.nRet,msg);
					 oo.socket.onclose = function(){//客户端与服务器断网回调
					       $.bug(1) && console && console.info("websocket closed!");
					        $.webim.CONST.CONNECTION = false;
	       　　　　				 oo = login2(oo, $.webim.CONST.U_INFO.mobile, $.webim.CONST.U_INFO.passwd,$.webim.CONST.U_INFO.sid ,1,
										socketServerUrl, socketServerPort, websocketUrl);
	       　　　　				 if (1 != oo.socket.readyState) {
	       　　　　					 $.global_msg.init({msg : '失去服务器的连接, 请刷新页面重试',icon : 0, time : 2000});
	       　　　　				 }
					 } 

				};
				/**
				 * 上线后显示离线的消息数量的回调
				 */
				oo.OnChatMsgNum = function (msg){
					$.bug(3) && console && console.log('上线后收到的离线消息数量回调',msg)
					//$.custom.offlineMessage({sendImid:msg.nSender,num:msg.nMsgNum}); //好友用户信息列表
					$.custom.isExistFriendInfo({sendImid:msg.nSender, num:msg.nMsgNum}); //好友用户信息列表
					//$.custom.cache.noReply[msg.nSender] = 1; //离线消息值赋给未回复
					var tmpDate = new Date();
					var time = tmpDate.getTime();
					$.custom.cache.noReply[msg.nSender] = Math.ceil(time/1000); 
				},
				// 发送文本消息回调(二进制回调也是用这个)
				oo.OnSendText = function(msg) {
					$.bug(2) && console && console.info('发送回调函数：',msg);
					if(msg.nFromUserID == msg.nToUserID){
						return ;
					}
					if('Explorer' == BrowserDetect.browser || 'Mozilla' == BrowserDetect.browser){
						if(msg.nToUserID == $.WebChat.vars.ieWebSocketToUserId){
							return;
						}
					}					
					
					delete $.custom.cache.noReply[msg.nToUserID]; //删除未回复数据
					
					// 消息成功处理
					if (msg.nResult == '0') {
						if($.webim.CONST.isImModule == false ){
							if(typeof($.cards_global.shareSucc) == 'function'){
								$.cards_global.shareSucc(msg);
							}
						}else{
							var formSourceId = msg.eGroupType>0?msg.nGroupID:msg.nFromUserID;
							msg.fromUserId = formSourceId;
							msg.toUserId   = msg.nToUserID;
							$.WebChat.pushHistoryBox(0, 0, 'send',msg);
							$.webim.scrollBottom();
							msg.msgSource = 'send';
							$.WebChat.addMsgToHisCache(msg); //自动把发送的消息添加到历史记录缓缓存中
						}
					} else {
						$.bug(1) && console && console.info('回调->发送消息失败：',oo);
						//$.global_msg.init({msg : '发送消息失败',icon : 0,time : 3}); //gImSendMsgFail
					}
					
					$.custom.callbackSend(msg);
					//setTimeout($.webim.scrollToBottom,100);//滚动到页面底部
				};
				//收到点对点文本信息回调函数(接收文本消息、接收消息)
				oo.OnRecvText = function(msg) {
					$.bug(2) && console && console.info('收到文本消息回调：',msg);
					if(msg.nFromUserID == msg.nToUserID){
						return ;
					}	
					if('Explorer' == BrowserDetect.browser || 'Mozilla' == BrowserDetect.browser){
						if(msg.nToUserID == $.WebChat.vars.ieWebSocketToUserId){
							return;
						}
					}
					$.WebChat.IEActiveConnect(); //解决IE断开的问题
					
					$.custom.isExistFriendInfo({sendImid:msg.nFromUserID}); //判断用户信息是否存在
					//var content = $.WebChat.dealWithTrimShow(msg.szXmlText); //换行转换处理
					var content = msg.szXmlText;
					var opts = {
								imid: msg.nFromUserID,
								content: content,
								sequence: msg.sSeqID,
								issend: 1,
								type: 1,
								nTime: msg.nTime
							};
					$.custom.callbackReceive(opts);
				};
				/*接收点对点 二进制回调*/
				oo.OnRecvBinary = function (msg){
					if('Explorer' == BrowserDetect.browser || 'Mozilla' == BrowserDetect.browser){
						if(msg.nToUserID == $.WebChat.vars.ieWebSocketToUserId){
							return;
						}
					}
					$.WebChat.IEActiveConnect(); //解决IE断开的问题
					$.bug(2) && console && console.info('回调->接收二进制文件返回消息：',msg);
					
					$.custom.isExistFriendInfo({sendImid:msg.nFromUserID}); //判断用户信息是否存在					
					var opts = {
								imid: msg.nFromUserID,
								content: msg.szDownURL,
								sequence: msg.sSeqID,
								issend: 1,
								type: 2,
								nTime: msg.nTime
							};					
					$.custom.callbackReceive(opts);	
				};
				// 更新用户状态回调
				oo.OnUpdateStatus = function(msg) {
					$.custom.sendTextMsgToSelf();/*给自己发送一条空消息，解决客服收不到手机端消息问题*/
					/*console && console.info("OnUpdateStatus: " + msg.nUserID + " "+ msg.euetype + " " + msg.nNewStatus + " "+ msg.szStatusDesc);*/
				}
				// 获取群组成员 
				oo.OnGetGroupMember = function(msg) {//这个回调和最后加的群列表回调(oo.OnGroupList)、群成员回调重复(oo.OnGroupMemberList)
					//delete $.bug(8) && console && console.log('获取群成员回调：',msg);
				}
				// 创建用户群组回调
				oo.OnCreateGroup = function(msg) {};
				/*获取群组用户信息回调,貌似有问题*/
				oo.OnGetGroupUserInfo =function (msg){};
				// 添加进群回调 no_use
				oo.OnInviteJoinGroup = function(msg) {
					//$.bug(3) && console && console.info('添加进群回调Join',msg);
				};
				//收到添加进群组的回调
				oo.OnAddGroupInfo = function(msg) {};
				/*添加群组账号时收到的回调,给群组添加成员时回调*/
				oo.OnAddGroupUserInfo =function (msg){};
				/*自己退出群组时收到的回调*/
				oo.OnLeaveGroupInfo =function (msg){}
				/*自己被踢出群组收到的回调*/
				oo.OnKickGroupUser =function (msg){}
				/*他人被踢出群组收到的回调*/
				oo.OnDelGroupUser =function (msg){}

				// 退出IM系统
				oo.OnLogoutResult = function(msg) {
					$.bug(3) && console && console.info("退出系统时回调 onLogoutResult: " + msg.nRet);
				}
				oo.OnLogoutResult2 =function (msg){/*登录回调*/
					$.bug(2) && console &&  console.info("onLogoutResult: "+msg.nRet+" "+msg.nUserID,msg) 
					$.post(getImUrl, {}, function(result) {
						$.bug(3) && console &&  console.info('该账号在别处已经登陆，被迫下线，若非本人，请修改密码',result.sid,msg.sSessionID);
						if(result.sid != msg.sSessionID){
							 $.global_msg.init({gType:'warning',icon:2,msg:gStrCustomYourAccountLoginOthers });
					/*		$.global_msg.init({
								msg : gImYouAccountLoginingOthers,
								icon : 1,
								endFn:function(){
									window.location.href = gUrlLoginOut;
								}
							});*/
							
		                    /*$.global_msg.init({msg:gImYouAccountLoginingOthers, btns: true,btn1:gSnsLogouout,btn2:gLoginAgain, gType: 'confirm',
		                    	fn: function (){
		                    		window.location.href = gUrlLoginOut;
		                        },
		                        noFn:function(){
		                        	 login2(oo, $.webim.CONST.U_INFO.mobile, $.webim.CONST.U_INFO.password,$.webim.CONST.U_INFO.sid ,1,
		 									socketServerUrl, socketServerPort, websocketUrl);
		                        }
		                    });*/
						}
					});
				}
				oo.OnLogin2 = function(msg){
					//console && console.info("OnLogin2:不知道这个回调是干啥使得 " ,msg);
				}
				oo.OnChatManagerResult = function(msg){}
				oo.OnBlockList = function (msg){},

				//接收自定义消息回调接口
				oo.OnRecvCustomText = function(msg){
					/* $.bug(2) && console && console.log('接收到的自定义文本类型',msg);
					$.WebChat.dealImTextCustom(msg);*/
				},
				oo.OnGroupList = function (msg){}

				oo.OnGroupMemberList = function (msg){}
			},
			//断开连接后重新登录
			loginAgain : function(){
				if($.webim.CONST.CONN_MAX>0){
			        if($.webim.CONST.CONNECTION == false){
			        	var timeConnect = $.webim.CONST.CONN_WAIT_TIME;
			       　　　　		 setTimeout(function(){
			       　　　　			 if($.webim.CONST.CONNECTION == false){
			       　　　　				 $.webim.CONST.CONN_MAX = $.webim.CONST.CONN_MAX-1;
			       　　　　				 login2(oo, $.webim.CONST.U_INFO.mobile, $.webim.CONST.U_INFO.passwd,$.webim.CONST.U_INFO.sid ,1,
									socketServerUrl, socketServerPort, websocketUrl);
			       　　　　			 }
				        },timeConnect);
			        }
				}else{
					$.bug(1) && console && console.log('最大连接次数已用尽，系统不会再自动连接im');
				}
			},
			// 添加黑名单
			setBlack : function(val,imid){},
			// 创建群组
			createGroup : function(groupname, userid) {},
			// 添加群组成员,给群组添加成员
			addGroupUser: function(userid,names){},
			//删除群组成员
			DelGroupUser : function(groupid,imid){
			//	DelGroupUser(oo,5,parseInt(groupid),parseInt(imid));
			},
			//退出群组
			leaveGroup : function(groupid){
			//	LeaveGroup(oo,5,parseInt(groupid));
			},
			//列表点击事件
			listClick : function(){},
			// 获取好友、群组、公众号列表
			getFriends : function(opts) {},
			getAllFriends:function(opts){},
			getAllGroups:function(opts){},
			getAllPublic:function(opts){},
			// 定时从API获取好友更新数据
			getIntervalFriends : function() {
				/*$.post(getFriendsApi, {}, function(result) {
					if (result.status == '0') {
						console && console.info('好友信息已更新');
					} else {
						console && console.info('好友数据更新失败');
					}
				});*/
			}
		}
	});
})(jQuery);