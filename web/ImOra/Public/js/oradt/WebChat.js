/**
 * SNS 聊天插件的输入框，允许输入表情
 */
	;(function($) {$.extend({
		WebChat : {
			/*jQuery选择器 */
			selector : {
				historyBox : '.chatHistoryBox', // 对话历史记录
				inputBox   : '.chatInputBox',   // 对话输入框
				wordLimit  : 1000               // 字数限制
			},
			data: {
				stickIds: {}, /*所有置顶id对象列表*/
				disturbImids:{} /*消息免打扰的imid列表,1:正常，2消息免打扰*/
				,imidUserIds:{} /*聊天号id-用户id的一一对应关系  exp:{10234:FSFDfdsfsdfdsfdsfds0000178,55341:FSFSDGLLNLNLLLLJLJ000334,...}*/
				,groupImids: {} /*所有群组的imid列表 exp:{123232:123232,4446:4446,...}*/
				,groupInfos: {} /*所有的群组中的成员信息 exp:{123:{456:clientid,789:clientid},...}*/
				,groupAdmin: {} /*群组管理员exp:{123:{imid:456,clientid:fFSFDSFDSFSDF00001},789:{imid:6677,clientid:FSFDFDSFDSF00003},...}*/
				,stickResult:{} /*置顶列表返回集*/
				,imidNames: {} /*好友或群组或公众号名称的全称（未截取过）列表，imid-name一一对应关系*/
			},			/**
			 * 定义sns前端使用的常量属性
			 */
			CONST : {
				ING_UPLOAD_IMAGE : 'sending...',
				LEFT_CUT_STR_NUM : 10,
				TOP_CUT_STR_NUM : 25,
				/*二进制文件的int类型表示*/
				RESOURCE_TYPE: {
					PICTURE : 2,
					AUDIO : 3,
					VIDEO : 4,
					CUSTOM : 5
				},
				/*二进制文件的string类型表示*/
				RESOURCE_STR : {
					PICTURE : 'pic',
					AUDIO : 'audio',
					VIDEO : 'video',
					CUSTOM : 'custom'
				},
				RESOURCE_CUSTOM : { /* $.WebChat.CONST.RESOURCE_CUSTOM. */
					VCARD : 'BusinessCard',
					MAP : 'Location',
					ACTIVITY : 'Active'
				},
				RESOURCE_POSITION : {/*消息显示位置，左侧还是右侧*/
					LEFT : 'left',
					RIGHT: 'right',
					RIGHT_SEND_LOADING: 'send_loading',
					LEFT_LIST: 'left_list',
					RIGHT_LIST: 'right_list'
				},
				CHAT_RECORD: 8, /*每页显示对话记录数*/
				CHAT_TYPE:{/*定义聊天类型：个人、群组、公众号*/
					PERSON: 'talk',
					GROUP: 'groupTalk',
					PUBLIC: 'publicNumber'
				},
				TEST:true,
				ITEM_CHECKED_COLOR:'#333', //列表选中后的颜色
				ITEM_DEFAULT_COLOR:'', //列表未选中时的颜色
				NEW_MSG_MAX_NUM: 99, //最大新消息数量
				MAX_PUBLIC_VCARD_POOL_DOWNLOAD:20 /*名片池一下载的张数次最多可以*/
			},
			vars:{
				isOpen:false, //对话框是否被打开
				newmsgnum:[], //新消息数量
				ieWebSocketToUserId : 3333,//IE断开之前发送的测试用户id
				ieQuence: [],//队列
				ieWebSocketTimout: 10, //IE下面websocket断开时间，单位秒
				afterLoginUnreadMsgNum: {} //登陆后未读消息数量
				,allFriends:{}//存放所有好友数据
				,allGroups:{} //存放所有群组数据
				,allPublic:{} //存储所有公众号数据
				,allBlackList:{} //存储所有黑名单数据
				,allTalkType:{} //所有类型,talk talkGroup Public
			},
			/**
			 * 初始化入口
			 */
			init : function (options) {
				if (typeof options !=='object') {
					return this;
				}
				// 合并选择器
				if (typeof options.selector !== 'undefined') {
					this.setSelector(options.selector);
				}
				// 将输入框设置成可编辑状态
				$(this.selector.inputBox).mCustomScrollbar({
			        theme:"dark", //主题颜色
			        autoHideScrollbar: false, //是否自动隐藏滚动条
			        scrollInertia :0,//滚动延迟
			        horizontalScroll : false,//水平滚动条
			        callbacks:{
			            onScroll: function(){} //滚动完成后触发事件
			        }
			    });
				// 定时执行， 保证图片不被缩放
				setInterval($.WebChat._makeImgFixedSize, 10);
				setInterval($.WebChat.checkInput, 10);
				return this;
			},
			imHandGroupList: function(groupXml){/*处理接收的im群组信息
				$(groupXml).children().each(function(i,obj){
					$.bug(8) && console.log('群列表',i,$(obj).attr('id'));
					var groupImid = $(obj).attr('id');
					$.WebChat.data.groupImids[groupImid] = groupImid; //所有的群组imids
				});
				$.webim.getAllGroups(); //群组列表
			*/},
			imHandGroupMember: function(groupId,memberXml){/*im接收到的每个群组里面的群成员信息
				$.WebChat.data.groupInfos[groupId] = {}; //群组中成员信息缓存
				$(memberXml).children().each(function(i,obj){
					$.bug(8) && console && console.log('群组成员', $(obj).attr('account'),$(obj).attr('id'));
					var memImid = $(obj).attr('id');
					var clientid = $(obj).attr('account');
					i == 0 ? $.WebChat.data.groupAdmin[groupId] = {imid:memImid, clientid:clientid} : null; //群管理员
					$.WebChat.data.groupInfos[groupId][memImid] = clientid; //每个群组中的所有成员信息
					$.WebChat.data.imidUserIds[memImid] = clientid; //imid-clientid一一对应关系
				});
			*/},
			getHistoryUrl: function(type){ /*获取历史记录url地址*/
				/*var urlObj =  {
					'talk':  getHistoryUrl, 个人历史获取地址
					'groupTalk': getGHistoryUrl, 群组历史获取地址
					'publicNumber': getPublicHistoryUrl 公众号历史获取地址
				};
				return urlObj[type];*/
			},
			/**
			 * 获取字符串长度
			 * 一个英文、数字算一个，一个汉字算两个长度
			 */
			getStrLen: function(str){
				var realLength = 0, len = str.length, charCode = -1;
			    for (var i = 0; i < len; i++) {
			        charCode = str.charCodeAt(i);
			        if (charCode >= 0 && charCode <= 128) {
			        	realLength += 1;
			        }else{
			        	realLength += 2;
			        }
			    }
			    return realLength;
			},
			
			/**
			 * 最近联系人
			 */
			latelyChatUser:function(imid,text,talkType){/*//groupid,touserid
				text = text  || (typeof(message) == 'undefined' ? '' : message);
				var type = talkType?talkType:$('input[name="talkType"]').val();
				var groupid = touserid = '';
				text = $.WebChat.dealWithFaceTrans(text);
				var dataParam = {type:type,imid:imid,message:text};
				$.ajax({
					 type: "post",
					 data: dataParam,
					 url: gUrlSetLatestSession,
					 success:function(msg){}
				});
			*/},
			/**
			 * 设置选择器
			 */
			setSelector : function (selector) {
				if (typeof selector === 'object') {
					this.selector = $.extend(true, this.selector, selector);
				}	
				return this;
			},
	
			/**
			 * 移除输入框里面图片的宽高属性， 保证图片不被缩放
			 */
			_makeImgFixedSize : function () {
				var $chatInputBox = $($.WebChat.selector.inputBox);
				var $imgs = $chatInputBox.find('img');
				for (var i=0; i<$imgs.length; i++) {
					$imgs.get(i).removeAttribute('width');
					$imgs.get(i).removeAttribute('height');
					$imgs.get(i).removeAttribute('_moz_resizing');// 移除火狐下的属性
				}
			},
	
			/**
			 * 获取输入框的信息内容
			 */
			getInputMessage : function () {
				if($('#contentEditor .mCSB_container').length != 0){
					return $('#contentEditor .mCSB_container').html();
				}else{
					return $(this.selector.inputBox+' .mCSB_container').html();
				}
			},
	
			/**
			 * 清空输入框内容
			 */
			emptyInputBox : function () {
				$(this.selector.inputBox+' .mCSB_container').html('');
				return this;
			},
			/**
			 * 输入监测事件
			 */
			checkInput: function () {
				if($($.WebChat.selector.inputBox+' .lb-v-scrollbar-slider').length == 0){
					$($.WebChat.selector.inputBox).css('height','83px');
					$('#contentEditor .lb-content').css('height','83px');
					$($.WebChat.selector.inputBox).find('.mCSB_container').css('min-height','83px');
					$($.WebChat.selector.inputBox).find('.mCSB_container').attr("contentEditable", "true");
	            }
				if($('#contentEditor .lb-content').length != 0){
					$($.WebChat.selector.inputBox).css('height','83px');
					$('#contentEditor .lb-content').css('width','446px');
					$('#contentEditor .lb-content').css('overflow','hidden');
					$('#contentEditor #lb-wrap-0-contentEditor').css('overflow','hidden');
					$('#contentEditor .lb-content').attr("contentEditable", "true");
					$($.WebChat.selector.inputBox).attr("contentEditable", "false");
				}
			},
			/*给公众号留言*/
			sendToPublicNumber: function(imid, content,html){/*
				var that = this;
				$.bug(5) && console && console.log('留言内容',content);
				$.post(gUrlPublicLeveaMsgUrl,{imid:imid, content:content},function(rst){
					if(rst.status == 0){
						var historyObj = $($.WebChat.selector.historyBox);
						var childObj = historyObj.find('.mCSB_container');
						if(childObj.size() == 1){
							childObj.append(html);
						}else{
							historyObj.append(html);
						}
						$.webim.scrollBottom();
						$.global_msg.init({msg:gImPublicLeaveMessageSucc,icon:1,btns:true});留言成功
					}else{
						$.global_msg.init({msg:gImPublicLeaveMessageFail,icon:0,btns:true});留言失败
					}
				},'json');
			*/},
			/**
			 * 发送聊天信息， 将聊天信息显示在聊天记录中
			 * @todo 聊天信息需要发送到服务器
			 *
			 * @param string messagetype 消息类型 文本 附件 图片 位置 名片 群活动
			 * @param obj messageData 消息数据
			 */
			sendMessage: function () {/*
				//自定义滚动条
				if($($.WebChat.selector.historyBox+' .lb-v-scrollbar-slider').length==0){
					$($.WebChat.selector.historyBox+' #lb-wrap-0-talk_box').css('height','270px');
				}
				var messageType = arguments[0] ? arguments[0] : 'text';
				var messageData = arguments[1] ? arguments[1] : '';
				var $container;
				if(messageData === ''){
					var textMsg = $.WebChat.getInputMessage();
					window.message = textMsg;
					message = message.replace(new RegExp(/( class="mCS_img_loaded")/g),''); //正则实现匹配多次的功能
					message =  $.WebChat.dealWithFaceTrans(message);
					//message = $.WebChat.dealWithTrimHtml(message); //项目路径配置不同，会出问题的
					var judgeMsg = $.WebChat.judgeTrimHtml(message);
					if (judgeMsg==='') {
						return true;
					}
					newMessage = $.WebChat.dealWithTrimShow(message);
					message = newMessage.replace(/<div>/g,'<br/>');// 谷歌
					message = message.replace(/(<div>)|(<\/div>)/g,'');
				}
				var imgsrc = $('.SNS_pop_img').children('img').attr('src');
				var imid = $('#Chatwindow_right .contact_zone').attr('clientid');
	            var groupid = $('#Chatwindow_right .contact_zone').attr('groupid');
				switch (messageType) {
			        case 'text': // 文本消息
			        	$container = '<div class="receiver">\
				        	<div><img src="'+imgsrc+'"></div>\
				        	<div>\
								<div class="right_triangle"></div>\
				        		<p class="SNS_content_tw">\
				        			<span class="SNSchat_right_c">'+newMessage+'</span>\
				        		</p>\
				        	</div>\
				        	</div>';
			        	//替换聊天内容中的img标签,表情
			        	var seqId = Math.uuid();
						var content = $.WebChat.dealWithFaceTrans(message);//过滤表情
						 content = $.WebChat.dealWithTrimShow(content);
						var maxLen = content.length;
						if(maxLen>=$.WebChat.selector.wordLimit){
							$.bug(5) && console && console.log(maxLen);
							$.global_msg.init({msg:gImSendTextMaxLimit.replace('%d%',$.WebChat.selector.wordLimit),btns:true});
							return true;
						}
						if($.trim(content) != ''){
							var talkType = $('input[name="talkType"]').val();
							//content = $.WebChat.dealWithTrimHtml(content);
							//content = content.replace(/<div>/g,'\n');// 谷歌
							//content = content.replace(/(<div>)|(<\/div>)/g,'');
							content = content.replace(/(<br>)|(<br\/>)/ig,"\n"); //发送换行处理 String.fromCharCode(10)
							var tmpContent = $.trim(content.replace(/(\n)|(&nbsp;)/ig,''));
							if(talkType == 'talk' && tmpContent){
								content = content.replace(/(&nbsp;)/ig, String.fromCharCode(32)); //替换空格
								content = content.replace(/(&amp;)/ig, '&'); 
								content = content.replace(/(&quot;)/ig, '"');
								content = content.replace(/(&#039;)/ig, "'");
								content = content.replace(/(&lt;)/ig, '<');
								content = content.replace(/(&gt;)/ig, '>');
								SendTextMessage(oo,0,0,parseInt(imid),seqId,content);
							}else if(talkType == 'groupTalk' && tmpContent){
								content = content.replace(/(&nbsp;)/ig, String.fromCharCode(32)); //替换空格
								content = content.replace(/(&amp;)/ig, '&'); 
								content = content.replace(/(&quot;)/ig, '"');
								content = content.replace(/(&#039;)/ig, "'");
								content = content.replace(/(&lt;)/ig, '<');
								content = content.replace(/(&gt;)/ig, '>');
								SendTextMessage(oo,5,parseInt(imid),0,seqId,content);
							}else if(tmpContent){
								content = content.replace(/(&nbsp;)/ig, String.fromCharCode(32));
								$.WebChat.sendToPublicNumber(imid,content,$container); //给公众号留言
							}
							tmpContent && $.WebChat.setHisLastTypeValue(imid, content);
						}
					    // 清空输入框
					    $.WebChat.emptyInputBox();
			        	break;
			        default : // 其他
			    }
			*/},
			/*设置最后一种值的类型*/
			setHisLastTypeValue:function(imid,text,talkType,opts){/*
				var defaults = {
						chatDate: $.util.ftime(new Date().getTime())
				};
				var opts = $.extend(true,{},defaults,opts);
				newText = $.WebChat.dealWithTrimShow(text);
				newText = $.WebChat.dealWithFaceShow(newText);
				var obj = $('.leftbox_'+imid);
				    obj.find('.SNS_pop_text>p').html(newText);
				    obj.find('.SNS_pop_time>em').html(opts.chatDate);//聊天时间
				    text = $.WebChat.dealWithTrimHtml(text);
				$.WebChat.latelyChatUser(imid,text,talkType);
			*/},
			//消息填充到历史记录框，（单条消息的填充，比如发送后或者接收到消息后操作此方法,异步接收消息处理方法）
			pushHistoryBox:function(fromUid,data,type,opts){/*
				var that = this;
				var setting = {newsType:'text'};
					opts = $.extend(true,{},setting,opts);
					opts.newsType = opts.newsType || 'text';//默认为文本消息
				var $container = '';
				var singleChatCls = ' cls_chat_single_msg ';
				if(type == 'send'){异步发送成功后回调处理
					*//**发送展示start**//*
					所有的发送消息处理 
					if((typeof(message) == 'undefined' || message === '') 
							&& typeof(opts.type) != 'undefined' && opts.type == 2){
						//发送二进制回调处理在此
						var singleObj = $('#'+opts.sSeqID);
						var imgSrc = singleObj.attr('urlImg');
						if(singleObj.attr('customType') == that.CONST.RESOURCE_CUSTOM.ACTIVITY){
							//活动处理
							 opts.headUrl = $('.SNS_pop_img').children('img').attr('src');
							 opts.position  = that.CONST.RESOURCE_POSITION.RIGHT;
							 
							var dataTpl = $.sns_common.tpl.talkSingleActiveTpl(opts);
							singleObj.html(dataTpl);
							$.WebChat.setHisLastTypeValue(opts.eGroupType==0?opts.nToUserID:opts.nGroupID, gImAvatarShowMsgCal);
						}else if(singleObj.attr('customType') == that.CONST.RESOURCE_CUSTOM.MAP){
							$.bug(5) && console && console.log('发送地理位置成功',opts)
							//发送地理位置成功后的处理
							var dataSetJson = singleObj.attr('dataSet');
							var dataSet = JSON.parse(dataSetJson);
							$('#content_child_'+opts.sSeqID).css('boder','1px solid red').next('.cls_map_address').html(dataSet.address);
							$.sns_common.showPosition(dataSet.longitude, dataSet.latitude, 'content_child_'+opts.sSeqID);
							$.WebChat.setHisLastTypeValue(opts.eGroupType==0?opts.nToUserID:opts.nGroupID, gImAvatarShowMsgLocation);
						}else {
							//发送图片、名片显示处理
							var imageHtml = '<img class="cls_chat_pic mCS_img_loaded" data-type="'+singleObj.attr('customType')+'" urlOri="'+imgSrc+'" src="'+imgSrc+'"/>'+'</span>';
							singleObj.find('.SNSchat_right_c').html(imageHtml).addClass('SNSchat_right_picimg').removeClass('SNSchat_right_c');
							if(singleObj.attr('customType') == that.CONST.RESOURCE_CUSTOM.VCARD){
								$.WebChat.setHisLastTypeValue(opts.eGroupType==0?opts.nToUserID:opts.nGroupID, gImAvatarShowMsgVcard);
								singleObj.find('.cls_chat_pic').attr('jsonData',singleObj.attr('jsonData'));
							}else{
							//new	$.WebChat.setHisLastTypeValue(opts.eGroupType==0?opts.nToUserID:opts.nGroupID, gImAvatarShowMsgImage);
							}
							singleObj.find('.SNS_content_tw_righttext').addClass('SNS_content_tw_right').removeClass('SNS_content_tw_righttext');
						}
					}else{
						//发送文件时处理
						var seqId = '';
						var childId = '';
						if(typeof(opts.seqId) != 'undefined'){
							seqId = ' id="'+opts.seqId+'" ';
							childId = ' id="content_child_'+opts.seqId+'" ';
						}
						if(typeof(message) != 'undefined' && message !== ''){
							var imgsrc = $('.SNS_pop_img').children('img').attr('src');
							if(opts.customType == that.CONST.RESOURCE_CUSTOM.MAP){
								//发送地图html结构
								var opts = {};
								opts.position = $.WebChat.CONST.RESOURCE_POSITION.RIGHT_SEND_LOADING;
								opts.headUrl = imgsrc;//头像
			            		opts.seqId  = seqId; //唯一id
			            		opts.childId = childId; //子id
								$container = $.sns_common.tpl.talkSingleLocationTpl(opts);
								$.WebChat.setHisLastTypeValue(opts.eGroupType==0?opts.nToUserID:opts.nGroupID, gImAvatarShowMsgLocation);
							}else{
								var sendMsg = $.WebChat.dealWithFaceShow(message);
								    sendMsg = $.WebChat.dealWithTrimShow(sendMsg);
								var   sendMsg = $.WebChat.dealWithTrimShow(message);
								      sendMsg = $.WebChat.dealWithFaceShow(sendMsg);
								$container = '<div class="receiver '+singleChatCls+'" '+seqId+'>\
					        	<div><img src="'+imgsrc+'" class="cls_sns_user_avatar_right"></div>\
					        	<div >\
									<div class="right_triangle"></div>\
					        		<p class="SNS_content_tw_righttext" '+childId+'>\
					        			<span class="SNSchat_right_c">'+sendMsg+'</span>\
					        		</p>\
					        	</div>\
					        	</div>';
							}
							window.message = '';
						}
					}
				*//**发送展示end**//*
				}else if(type == 'recieve'){异步接收成功后的消息处理
					var thistalkImid = $('#Chatwindow_right .contact_zone').attr('clientid');
					//判断接收到消息是不是正在聊天的用户
					if(thistalkImid == fromUid){
						var friendUrl = $('#Chatwindow_right .contact_zone .SNS_pop_img img').attr('src');
						if(opts.sourceType == 'groupTalk'){
							var groupId = opts.groupId;
							var imid = opts.groupPersonId;
							if(typeof($.WebChat.data.imidUserIds[imid]) == 'undefined'){
								$.ajax({url:'/home/sns/getClientId',data: {imid:imid},async:false,dataType:'json',
									success: function(rst){
										$.WebChat.data.imidUserIds[imid] = rst.data; //存储imid-userId映射关系
										friendUrl = gUrlgetAvatarByImid+'?groupId='+groupId+'&imid='+imid+'&clientid='+rst.data;
									}
								});
							}else{
								friendUrl = gUrlgetAvatarByImid+'?groupId='+groupId+'&imid='+imid+'&clientid='+$.WebChat.data.imidUserIds[imid];
							}
						}
						switch(opts.newsType){
							case 'text': 文本消息
								var content = data;
								//对接收到的文本信息进行表情转换处理
								data = $.WebChat.dealWithTrimShow(data);
								data = $.WebChat.dealWithFaceShow(data);								
								$container += '<div class="sender">\
									<div><img class="cls_sns_user_avatar" src="' + friendUrl + '"></div>\
									<div>\
										<div class="left_triangle"></div>\
										<p class="SNS_content_tw_lefttext">\
											<span class="SNSchat_right_c">' + data + '</span>\
										</p>\
									</div>\
								</div>';
								$.WebChat.setHisLastTypeValue(opts.fromUserId, content);
								break;
							case 'binary':附件消息二进制资源
								var xmlObj = $(data.downXml); //原图对象
								var fileType = xmlObj.attr('filetype');
								var detailType = fileType;
								if(detailType == that.CONST.RESOURCE_STR.PICTURE){图片
									var thumbObj = $(data.thumbXml); //缩略图对象
									var downObj  = $(data.downXml);
									var tmpOpts = {};
										tmpOpts.thumbObj = thumbObj;
										tmpOpts.downObj  = downObj;
										tmpOpts.friendUrl = friendUrl;
										tmpOpts.binaryType = that.CONST.RESOURCE_STR.PICTURE;
									$container += $.sns_common.tpl.talkTpl(tmpOpts);
									$.WebChat.setHisLastTypeValue(opts.fromUserId, gImAvatarShowMsgImage);
								}else if(detailType == that.CONST.RESOURCE_STR.CUSTOM
										|| detailType == that.CONST.RESOURCE_STR.AUDIO){
									//异步处理接收到的自定义的二进制类型
									//1.请求后端
									var zipPath = xmlObj.attr('url');
									var priveteData = {path:zipPath,binaryType:detailType};
							        $.ajax({
							            url: gUrlSnsDealWithCustom,
							            type: "post",
							            dataType: "json",
							            data: priveteData,
							            success: function (rtn) {
							            	if(rtn.status == 0){
								            	//前端展示
								            	var tmpOpts = rtn.data;
								            		tmpOpts.headUrl = friendUrl; //头像
								            		tmpOpts.position  = that.CONST.RESOURCE_POSITION.LEFT_LIST;//左边显示还是右边显示
								            		tmpOpts.seqId = opts.seqId;
								            		tmpOpts.fromUserId = opts.fromUserId;
								            		$container = that.dealWithCustom(tmpOpts);
								            		
								            		$($.WebChat.selector.historyBox+' '+'.mCSB_container').append($container);
								            		
								            		if(tmpOpts.customType == that.CONST.RESOURCE_CUSTOM.MAP){
									            		var mapObj = tmpOpts.mapInfo; //原图对象
														$('#content_child_'+opts.seqId).css('boder','1px solid red');
														$.sns_common.showPosition(mapObj.longitude,mapObj.latitude , 'content_child_'+opts.seqId);
								            		}
													
								        			$.webim.scrollBottom();
							            	}else{//接收后异步解析二进制失败
							            		$.bug(1) && console && console.info(rtn);
							            	}
							            },
							            error: function (error,status) {
							            	$.bug(1) && console && console.info(error,status);
							            }
	
							        });
								}else if(detailType == that.CONST.RESOURCE_STR.AUDIO){
									//音频展示模板 ...audio
									var tmpOpts = {};
									tmpOpts.downObj  = xmlObj;
									tmpOpts.binaryType = that.CONST.RESOURCE_STR.AUDIO;
									tmpOpts.headUrl = friendUrl; //头像
				            		tmpOpts.position  = that.CONST.RESOURCE_POSITION.LEFT_LIST;//左边显示还是右边显示
				            		$container += $.sns_common.tpl.talkTpl(tmpOpts);
				            		$.WebChat.setHisLastTypeValue(opts.fromUserId, gImAvatarShowMsgAudio);
								}else if(detailType == that.CONST.RESOURCE_STR.VIDEO){
									var thumbObj = $(data.thumbXml); //缩略图对象
									//视频
									var tmpOpts = {};
										tmpOpts.downObj  = xmlObj;
										tmpOpts.thumbObj = thumbObj;
										tmpOpts.friendUrl = friendUrl;
										tmpOpts.binaryType = that.CONST.RESOURCE_STR.AUDIO;
									$container += $.sns_common.tpl.tplVideoSingle(tmpOpts);
									$.WebChat.setHisLastTypeValue(opts.fromUserId, gImAvatarShowMsgVideo);
								}
								break;
							default:
						}
					}
				}
				$($.WebChat.selector.historyBox+' '+'.mCSB_container').append($container);
				$.webim.scrollBottom();
			*/},
			getReceiveBinaryVal: function(data,opts){/*
				var that = this;
				var friendUrl = $('#Chatwindow_right .contact_zone .SNS_pop_img img').attr('src');
				if(opts.sourceType == 'groupTalk'){
					var groupId = opts.groupId;
					var imid = opts.groupPersonId;
					$.ajax({url:'/home/sns/getClientId',data: {imid:imid},async:false,dataType:'json',
						success: function(rst){
							friendUrl = gUrlgetAvatarByImid+'?groupId='+groupId+'&imid='+imid+'&clientid='+rst.data;
						}
					});
					
				}
				switch(opts.newsType){
					case 'text': 文本消息
					case 'binary':附件消息二进制资源
						var xmlObj = $(data.downXml); //原图对象
						var fileType = xmlObj.attr('filetype');
						var detailType = fileType;
						if(detailType == that.CONST.RESOURCE_STR.PICTURE){图片
							var thumbObj = $(data.thumbXml); //缩略图对象
							var downObj  = $(data.downXml);
							var tmpOpts = {};
								tmpOpts.thumbObj = thumbObj;
								tmpOpts.downObj  = downObj;
								tmpOpts.friendUrl = friendUrl;
								tmpOpts.binaryType = that.CONST.RESOURCE_STR.PICTURE;
							$container += $.sns_common.tpl.talkTpl(tmpOpts);
							$.WebChat.setHisLastTypeValue(opts.fromUserId, gImAvatarShowMsgImage);
						}else if(detailType == that.CONST.RESOURCE_STR.CUSTOM
								|| detailType == that.CONST.RESOURCE_STR.AUDIO){
							//异步处理接收到的自定义的二进制类型
							//1.请求后端
							var zipPath = xmlObj.attr('url');
							var priveteData = {path:zipPath,binaryType:detailType};
					        $.ajax({
					            url: gUrlSnsDealWithCustom,
					            type: "post",
					            dataType: "json",
					            data: priveteData,
					            success: function (rtn) {
					            	if(rtn.status == 0){
						            	//前端展示
						            	var tmpOpts = rtn.data;
						            		tmpOpts.headUrl = friendUrl; //头像
						            		tmpOpts.position  = that.CONST.RESOURCE_POSITION.LEFT_LIST;//左边显示还是右边显示
						            		tmpOpts.seqId = opts.seqId;
						            		tmpOpts.fromUserId = opts.fromUserId;
						            		$container = that.dealWithCustom(tmpOpts);
					            	}else{//接收后异步解析二进制失败
					            		$.bug(1) && console && console.info(rtn);
					            	}
					            },
					            error: function (error,status) {
					            	$.bug(1) && console && console.info(error,status);
					            }
	
					        });
						}else if(detailType == that.CONST.RESOURCE_STR.AUDIO){
							//音频展示模板 ...audio
							var tmpOpts = {};
							tmpOpts.downObj  = xmlObj;
							tmpOpts.binaryType = that.CONST.RESOURCE_STR.AUDIO;
							tmpOpts.headUrl = friendUrl; //头像
		            		tmpOpts.position  = that.CONST.RESOURCE_POSITION.LEFT_LIST;//左边显示还是右边显示
		            		$container += $.sns_common.tpl.talkTpl(tmpOpts);
		            		$.WebChat.setHisLastTypeValue(opts.fromUserId, gImAvatarShowMsgAudio);
						}else if(detailType == that.CONST.RESOURCE_STR.VIDEO){
							var thumbObj = $(data.thumbXml); //缩略图对象
							//视频
							var tmpOpts = {};
								tmpOpts.downObj  = xmlObj;
								tmpOpts.thumbObj = thumbObj;
								tmpOpts.friendUrl = friendUrl;
								tmpOpts.binaryType = that.CONST.RESOURCE_STR.AUDIO;
							$container += $.sns_common.tpl.tplVideoSingle(tmpOpts);
							$.WebChat.setHisLastTypeValue(opts.fromUserId, gImAvatarShowMsgVideo);
						}
						break;
					default:
			}
			*/},
			//自定义滚动条
			myScroll:function(selector,callbacks){
				var scrollObj = $(selector);
				//滚动条生效后不再执行
	        	if(!scrollObj.hasClass('mCustomScrollbar')){
	        		scrollObj.mCustomScrollbar({
				        theme:"dark", //主题颜色
				        autoHideScrollbar: false, //是否自动隐藏滚动条
				        scrollInertia :0,//滚动延迟
				        horizontalScroll : false,//水平滚动条
				        callbacks:callbacks
				    });
	        		return false;
	        	}else{
	        		return true;
	        	}
			},
			
			/*聊天时ajax上传图片功能*/
			ajaxUploadAttach: function(param){//new
				var that = this;				
				var fileFieldName = param.fileFieldName;
				var seqId    = Math.uuid();
			    var fromUserId = $.webim.CONST.IM_ID;
			    var msg = that.CONST.ING_UPLOAD_IMAGE;
			    
			    //本地临时添加一条发送消息记录，不调用接口
			    var opts = {seqId:seqId,detailType:that.CONST.RESOURCE_STR.PICTURE/*细化后的类型*/};
			    //window.message = msg;
			    //that.pushHistoryBox(fromUserId,msg,'send',opts);
			    //window.message = '';
			    var data = {fileName:fileFieldName, seqId:seqId};
			    $.bug(4) && console && console.log(data)
			 	$.ajaxFileUpload({
		 			url : gUrlSnsUploadFile,
		 			secureuri: false,
		 			fileElementId: fileFieldName,
		 			data: data,
		 			dataType: 'json',
		 			success: function (rtn, status){
		 				$.bug(4) && console && console.log(rtn);
		 				rtn.seqId      = seqId;
		 				rtn.binaryType = param.binaryType;
		 				//rtn.binaryType = that.CONST.RESOURCE_STR.PICTURE;
		 				that.binaryLocalUploadCallback(rtn);
		 			},
		 			error: function (data, status, e){
		 				$.bug(1) && console && console.info(data,status,e);
		 			}    			
		 		});
			},
			
			/*上传二进制文件到资源服务器后的回调函数*/
			binaryLocalUploadCallback: function(rtn){
					var that = this;
					$.bug(4) && console && console.log('上传二进制文件到资源服务器后的回调函数',rtn)
					var data = rtn.data;
					var msg = '';
	 				//上传二进制文件成功
	 			   if(rtn.status == 0){
	 				    if(rtn.succUploadFn && typeof(rtn.succUploadFn) == 'function'){
	 				    	rtn.succUploadFn();
	 				    }
						var resTypeInt = parseInt(data.resTypeInt);
						var resTypeStr = data.resTypeStr;
						var resUrl = data.resUrl;
						var seqId = rtn.seqId;
						var imid  = rtn.imid;
						var content = '';
						switch(rtn.binaryType){
							case that.CONST.RESOURCE_STR.PICTURE: /*图片资源*/
								 content = "<binarymsg filetype='"+resTypeStr+"' id='"+seqId+"' "
								 			+" url='"+resUrl+"' />"; 
								break;
							default: $.bug(4) && console && console.log('没有匹配到对应的类型',rtn.binaryType)
						}		
						var imid = typeof($('#js_right_total').attr('imid')) != 'undefined' ? $('#js_right_total').attr('imid') : $('#js_receive_user').val();
							imid    = parseInt(imid);
						//talkType为talk时表示单聊
							SendBinaryMessage(oo,0,resTypeInt,0,imid,seqId,content);
							//填充发送图片消息到聊天对话框中
							var obj = {
									imid: imid,
									content: content,
									sequence: seqId,
									issend: 0,
									type: 2
								};
							$.custom.fillSingleMsgToChat(obj);
	 			   }else{/*上传二进制资源失败*/
	 				  msg  = rtn.msg;	
	 			   }
	 			   if(msg){
	 				  $.global_msg.init({gType:'warning',icon:2,msg:msg });
	 			   }
			},
			
			/**
			 * ajax上传自定义类型（名片、地图、活动）
			 */
			ajaxUploadCustom: function(opts){
				var that 	= this;
				var seqId   = Math.uuid();
				var dataDefault = {
						binaryType: that.CONST.RESOURCE_STR.CUSTOM,/*二进制类型->自定义类型*/
						customType: that.CONST.RESOURCE_CUSTOM.VCARD,/*自定义类型->名片*/
						detailType: that.CONST.RESOURCE_CUSTOM.VCARD,/*细化后的类型*/
						seqId: seqId
				};
				data = $.extend(true,{},dataDefault,opts);
			    var uploadType = opts['uploadType'];
			    //本地临时添加一条发送消息记录，不调用接口
			    var fromUserId = $.webim.CONST.IM_ID;
			    var msg = that.CONST.ING_UPLOAD_IMAGE;
			    window.message = msg;
			    // console && console.log(dataDefault);
			    //名片、活动、地图，上传到服务之前消息展示
			    that.pushHistoryBox(fromUserId,msg,'send',data);
			    window.message = '';
				$.ajax({
					   type: "POST",
					   url: gUrlSnsUploadFile,
					   data: data,
					   dataType: 'json',
					   success: function(rtn){
						   if(rtn.status == 0){
							   	/*if ('Active' == uploadType) {
							   		$.global_msg.init({msg:gShareSuccess,icon:1});
							   		$('.schedule_fenxpop').hide();
							   	}else{*/
							   	    rtn = $.extend(true,{},rtn,data);
								    that.binaryLocalUploadCallback(rtn);
							   	//}
							   
						   }else{
							   $.global_msg.init({msg:rtn.msg,btns:true});
							   $('#'+rtn.msgId).find('.SNSchat_right_c').html(gMessageInfoSendFailed);
						   }
						  
					   },
					   error: function(XMLHttpRequest, textStatus, errorThrown){
						   // console && console.log(textStatus, errorThrown);
					   }
					});
			},
			
			/**
			 * 渲染聊天消息列表中的地图
			 */
			renderMap: function(dataSet){/*
				var maxLen = dataSet.length;
				if(maxLen>0){
					for(var i=0;i<maxLen;i++){
						var obj = dataSet[i];
						$('#content_child_'+obj.seqId).css('boder','1px solid red');
						$.sns_common.showPosition(obj.lng, obj.lat, 'content_child_'+obj.seqId);
					}
				}
			*/},
			
			/**
			 * 处理接收到的自定义类型压缩包
			 */
			dealWithCustom: function(opts){/*
				$.bug(4) && console && console.log(opts)
				var html = '';
				var customType = typeof(opts.customType)=='undefined'?'':opts.customType;
				var that = this;
				if(customType == that.CONST.RESOURCE_CUSTOM.VCARD){名片
					名片处理
					var tmpOpts = {};
						//tmpOpts.friendUrl = friendUrl;
						tmpOpts.binaryType = that.CONST.RESOURCE_CUSTOM.VCARD;
						tmpOpts = $.extend({},tmpOpts,opts)
	        		    html = $.sns_common.tpl.talkTpl(tmpOpts);
					$.WebChat.setHisLastTypeValue(opts.fromUserId, gImAvatarShowMsgVcard);
				}else if(customType == that.CONST.RESOURCE_CUSTOM.ACTIVITY){日程活动
					$.bug(4) && console && console.log('接收日程')
					var tmpOpts = {};
						//tmpOpts.binaryType = that.CONST.RESOURCE_CUSTOM.ACTIVITY;
						tmpOpts.position  = that.CONST.RESOURCE_POSITION.LEFT_LIST;
						tmpOpts = $.extend(true,{},tmpOpts,opts);
	        		    html = $.sns_common.tpl.talkSingleActiveTpl(tmpOpts);
	        		  $.WebChat.setHisLastTypeValue(opts.fromUserId, gImAvatarShowMsgCal);
				}else if(customType == that.CONST.RESOURCE_CUSTOM.MAP){								
					//异步接收地理位置成功后的处理
					//发送地图html结构
					var mapObj = opts.mapInfo; //原图对象
					var seqId = ' id="'+opts.seqId+'" ';
					var childId = ' id="content_child_'+opts.seqId+'" ';
					var optsTmp = {};
					optsTmp.position = $.WebChat.CONST.RESOURCE_POSITION.LEFT_LIST;
					optsTmp.seqId   = seqId; //唯一id
					optsTmp.childId = childId; //子id
					optsTmp = $.extend(true,optsTmp,opts);
					html = $.sns_common.tpl.talkSingleLocationTpl(optsTmp);
					
					$($.WebChat.selector.historyBox+' '+'.mCSB_container').append(html); //test
					$('#content_child_'+opts.seqId).css('boder','1px solid red');
					//console.log(mapObj.longitude,mapObj.latitude , 'content_child_'+opts.seqId)
					$.sns_common.showPosition(mapObj.longitude,mapObj.latitude , 'content_child_'+opts.seqId);
					$.webim.scrollBottom();
					//html = '';//地图这里特殊处理，避免结构添加两次 //test
					//$('.leftbox_'+opts.fromUserId+' .SNS_pop_text').children('p').html('[地理位置]');
					$.WebChat.setHisLastTypeValue(opts.fromUserId, gImAvatarShowMsgLocation);
				}else if(customType == that.CONST.RESOURCE_STR.AUDIO){
					var optsTmp = opts;
					html = $.sns_common.tpl.tplAudioSingle(optsTmp);
					$.WebChat.setHisLastTypeValue(opts.fromUserId, gImAvatarShowMsgAudio);
				}
				return html;
			*/},
			/*根据消息对象返回消息类型*/
			getMsgTypeByObj: function(obj){
				var type = obj.type;
				switch(type){
					case '1':
						var   content = $.WebChat.dealWithTrimShow(content);
						      content = $.WebChat.dealWithFaceShow(obj.content);
						return content;
					case '2':
						return gImAvatarShowMsgImage;
					case '3':
						return gImAvatarShowMsgAudio;
					case '4':
						return gImAvatarShowMsgVideo;
					case '5':
						var customTypeVal = obj.customData.customType;
						if($.WebChat.CONST.RESOURCE_CUSTOM.VCARD ==  customTypeVal){
							return gImAvatarShowMsgVcard;
						}else if($.WebChat.CONST.RESOURCE_CUSTOM.MAP ==  customTypeVal){
							return gImAvatarShowMsgLocation;
						}else if($.WebChat.CONST.RESOURCE_CUSTOM.ACTIVITY ==  customTypeVal){
							return gImAvatarShowMsgCal;
						}
					default:
						return '';
				}
			},
			/*根据视频的地址获取视频的缩略图地址*/
			getVideoThumb:function(url,separator){/*
				if(!url || !separator){
					return gPublic + '/images/background/sns_vodie_img.png';
				}
				var videoArr = url.split(separator);
				var videoFileName = videoArr[videoArr.length-1];
				var videoFileInfo = videoFileName.split('.');
				var videoSuff     = '.'+videoFileInfo[videoFileInfo.length-1];
				return url.replace(videoSuff,'_thumb.jpg');
			*/},
			getVideoDefaultImage:function(obj){/*
				obj.src = gPublic + '/images/background/sns_vodie_img.png';
			*/},
			//对接收到的文本信息进行表情转换处理
			dealWithFaceShow: function(data){	
				if(!$.trim(data))return data;
				//data = data.replace(/\[f\d{3}\]/g,'<img src=\"/js/jsExtend/expression/js/plugins/exp/img/$&.png\" tags=\"$&\">');
				var faceArr = data.match(/\[f\d{3}\]/g);
				if(faceArr != null){
					var maxLenFace = faceArr.length;
					for(var i=0;i<maxLenFace;i++){
						var faceObj = faceArr[i];
						var faceVal = faceObj.replace(/\[f(\d{3})\]/,"f$1");
						data = data.replace(faceObj,'<img class="face_img_icon" src=\"/js/jsExtend/expression/js/plugins/exp/img/'+faceVal+'.png\" tags=\"'+faceVal+'\">');
					}
				}
				return data;
			},
			/*对表情进行发送之前表情转换的处理*/
			dealWithFaceTrans: function(content){//class="mCS_img_loaded" 
				return content.replace(/<img src="\/js\/jsExtend\/expression\/js\/plugins\/exp\/img\/f(\d{3})\.png" tags="f(\d{3})">/g, "[f$2]");
			},
			/*html标签处理*/
			dealWithTrimHtml: function(str){
				if(!str){
					return '';
				}
				str = str.replace(/<div>/g,'\n');// 谷歌
				str = str.replace(/<br[^>]*>/g,'\n');//火狐 xgm 2015-8-5 速度变慢
				str = str.replace(/<\/?[^>]*>/g,'');
				str = str.replace(/[ | ]*\n/g,'\n'); //去除行尾空白
		            //str = str.replace(/\n[\s| | ]*\r/g,'\n'); //去除多余空行
		        str = str.replace(/&nbsp;/ig,' ');//去掉&nbsp;
		        // console.log(str);
		        return str;
			},
			/*将处理的html内容进行换行转义*/
			dealWithTrimShow:function(str){
				if(!$.trim(str))return str;
				str = str.replace(/ /ig, '&nbsp;');//处理空格
				//var trims = str.match(/\\n/g);
				var trims = str.match(/\n/g);
				var newStr = '';
				if(trims != null){
					// obj = str.split('/n');
					// for (var i = 0; i < obj.length; i++) {
					// 	newStr += obj[i]+'<br>';
					// };
					var maxLenTrim = trims.length;
					for(var i=0;i<maxLenTrim;i++){
						var trimObj = trims[i];
						//var str = str.replace(/\\n/g,"<br>");
						var str = str.replace(/\n/g,"<br>");
					}
				}
				if (newStr) {
					return newStr;
				}else{
					return str;
				}
				
			},
			/*判断是不是没有输入内容*/
			judgeTrimHtml:function(str){
				str = str.replace(/\\n/g,'');//将<br>转换为空
				return str;
			},
			/**
			 * (在页面不刷新的情况下)添加发送或者接收到消息到js缓存中,保持数据的一致性
			 */
			addMsgToHisCache: function(opts){/*
					var imid = '';
					if(opts.msgSource == 'send'){//发送消息
						imid = opts.eGroupType>0 ? opts.nGroupID : opts.nToUserID; //获取群组或者好友的ID
					}else if(opts.msgSource == 'receive'){//接收消息
						imid = opts.eGroupType>0 ? opts.nGroupID : opts.nFromUserID; //获取群组或者好友的ID
					}
					if(typeof(variable.sns[imid]) == 'undefined'){
						// variable.sns[imid]['selectDiff'] = 1;
					}else{
						if (typeof(variable.sns[imid]['selectDiff']) == 'undefined') {
							variable.sns[imid]['selectDiff'] = 1;
						}else{
							variable.sns[imid]['selectDiff']++;
						}
					}
					
					if(historyInfo[imid] != undefined){
						var url = '';
						var selectFlag = true; //是否进行查询
		            	if(opts.nGroupID  == 0){//好友
		            		 url = getHistoryUrl;
		            	}else if(opts.nGroupID  > 0){//群组
		            		 url = getGHistoryUrl;
		            	}else{
		            		$.bug(1) && console && console.log('不符合要求的调用');
		            		selectFlag = false;
		            	}
		            	if(selectFlag === true){
		                	var ajaxParam = {imid:imid,seqId:opts.sSeqID};
		    	        	//获取聊天记录
		    	            $.post(url, ajaxParam, function (dzy) {
		    	                if(dzy.status == '0') {
		    	                	var sdj = [];
		    	                }
		                    	if(dzy.data.numfound > '0'){
		                             sdj = dzy.data.list;
		                        }
		                        //最近的一条消息记录追加到数组中
		                        historyInfo[imid] = historyInfo[imid].concat(sdj);//对数组进行合并
		    	            },'json');
		            	}
					}
			*/},
			/**
			 * IE下面自动激活链接
			 */
			IEActiveConnect: function(){
				if('Explorer' == BrowserDetect.browser || 'Mozilla' == BrowserDetect.browser){
					if($.WebChat.vars.ieQuence.length == 0){
						var dateTime = new Date();
						var time = dateTime.getTime();
						$.WebChat.vars.ieQuence.push(time); //添加数组
						setTimeout(function(){
							$.WebChat.priIESendEmpty(time);
						},$.WebChat.vars.ieWebSocketTimout*1000);
					}
				}
			},
			/**
			 * IE自动断开后链接的私有方法
			 */
			priIESendEmpty: function(t){
				$.bug(5) && console && console.log('ie keep alive send')
				$.WebChat.vars.ieQuence.shift(); //删除数组
				var imid = $.WebChat.vars.ieWebSocketToUserId;
				var seqId= Math.uuid();
				SendTextMessage(oo,0,0,imid,seqId,'');
			},
			/*外部调用发送日程活动的方法*/
			externalActive: function(opts){/*
				if(typeof(opts.scheduleId) == 'undefined' || typeof(opts.toUserId) == 'undefined'){
					$.bug(4) && console && console.error('please enter the param!',opts);
					return;
				}
	            var opts = {
	            		scheduleId: opts.scheduleId,
	            		toUserId: opts.toUserId,
	                    uploadType: $.WebChat.CONST.RESOURCE_CUSTOM.ACTIVITY,
	                    customType: $.WebChat.CONST.RESOURCE_CUSTOM.ACTIVITY,
	                   };
	            $.WebChat.ajaxUploadCustom(opts);
			*/},
			
			/*外部调用发送地理位置的方法*/
			externalLocation: function(opts){/*
				var that = this;
				if(typeof(opts.lat) == 'undefined' || typeof(opts.lng) == 'undefined'){
					$.bug(4) && console && console.error('please enter the param!',opts);
					return true;
				}
	            var defaultOpt = {
	            		lat: 0,
	            		lng: 0,
	            		address: '',
	            		toUserId: $('#Chatwindow_right .contact_zone').attr('clientid'),//既可以表示toUserId,也可以表示群组id,
	                    customType: $.WebChat.CONST.RESOURCE_CUSTOM.MAP,
	                   };
	            var optsSet = $.extend(true,{},defaultOpt,opts);
	            var mapObj = {longitude:optsSet.lng, latitude:optsSet.lat, address:optsSet.address};
	            var mapObjJson = JSON.stringify(mapObj);
	            var tmpOpts = {
	            		mapJson: mapObjJson,
	            		uploadType: $.WebChat.CONST.RESOURCE_CUSTOM.MAP,
	            		customType: $.WebChat.CONST.RESOURCE_CUSTOM.MAP,
	            	};
	            
	            $.WebChat.ajaxUploadCustom(tmpOpts);
			*/},
			externalOpenFriend: function(){/*//外部直接打开与某个好友用户聊天对话框
				var friendImid = gOutImid;//$.WebChat.getUrlParam('outImid');
				if(friendImid != null && friendImid.toString().length>1){
					$('.im_friends').find('.contact_'+friendImid).trigger('click');
				}
			*/},
			getUrlParam: function(name){//获取url中的参数
			     var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
			     var r = window.location.search.substr(1).match(reg);
			     if(r!=null)return  unescape(r[2]); return null;
			},
			/**
			 * 从其他页面进入聊天窗口操作入口
			 */
			outerSourceEnter: function(){/*
				var sourceType = gOutSt;
					gOutSt = '';
					//window.location = gSnsUrlIndex;
				switch(sourceType){
					case 'friendRequest':
						 $.WebChat.friendRequestOpen(gFrFlag);//打开好友请求列表
						break;
					case 'singleFriend':
						$.WebChat.externalOpenFriend(); //打开某个用户进行聊天
						break;
					case 'manyFriend'://创建群组
						if(gOutImids){
							jQuery.getScript(gCreateTalkJs, function(){
								var imids = gOutImids;
								$.sns_talkGroup.groupContacts.mids = $.webim.CONST.IM_ID+','+imids;
								$.sns_talkGroup.groupContacts.names = $('.cls_sns_person_avatar').attr('title');
								$.sns_talkGroup.groupContacts.mids
								var imidArr = imids.split(',');
								var allFriendObj = $('.im_friends');
								$.each(imidArr,function(i,id){
									var name = allFriendObj.find('.contact_'+id).find('.SNS_pop_text b').attr('title');
									$.sns_talkGroup.groupContacts.names += ','+name;
								});
								$.webim.createGroup($.sns_talkGroup.groupContacts.names,$.sns_talkGroup.groupContacts.mids);
							});
						}
						break;
					default:
				}
			*/},
			/**
			 * 给外部使用的打开聊天窗口方法
			 */
			externalOpen: function(opts){/*
				if(typeof(opts.fuserId) == 'undefined' || opts.fuserId == ''){
					$.bug(5) && console && console.log(opts);
					return true;
				}
				var fuserId = opts.fuserId;
					$.post(gUrlGetImid,{fuserId:fuserId},function(rtn){
						$.bug(5) && console && console.log(rtn)
						var contactObj = $('.contact_'+rtn.data);
						$.bug(5) && console && console.log(contactObj)
						contactObj.trigger('click');
					});
			*/},
			/**
			 * 及时更新群组左侧以及顶部的头像
			 */
			updateLeftTopAvatar: function(groupId,newAvatar){/*
				  //修改左侧头像
				  typeof(newAvatar) == 'undefined' ? (newAvatar = $('.im_groups').find('.contact_'+groupId).find('.SNS_pop_img').html()):'';
				  var newNames = $('.im_groups').find('.contact_'+groupId).find('.SNS_pop_text').children('b').attr('title');
				  var nums = $('.im_groups').find('.contact_'+groupId).find('.SNS_pop_text').children('b').attr('data-num');
				  // var newNames = $('.im_groups').find('.contact_'+groupId).find('.SNS_pop_text').children('b').html();
				  var latestObj = $('.mycontacts').find('.leftbox_'+groupId);
				  if(latestObj.length>0){
					  latestObj.find('.SNS_pop_img').html(newAvatar);
					   latestObj.find('.SNS_pop_text').children('b').html(newNames);
				  }else{
					   latestObj = $('.mystick').find('.leftbox_'+groupId);
					   latestObj.find('.SNS_pop_img').html(newAvatar);
					   latestObj.find('.SNS_pop_text').children('b').html(newNames);
				  }
				 //console.log(newAvatar,nums,newNames)
				  var newNamesShort = cutstr_en(newNames,$.WebChat.CONST.LEFT_CUT_STR_NUM,'...');
				  var latestObj = $('#recentBox').find('.leftbox_'+groupId)
				   	  latestObj.find('.SNS_pop_img').html(newAvatar);
					  latestObj.find('.SNS_pop_text').children('b').html(newNamesShort+'('+nums+')').attr('data-num',nums);
				  //修改聊天框顶部头像
				  $('#Chatwindow_right .contact_zone .SNS_pop_img').html(newAvatar);
				  $('#Chatwindow_right .contact_zone .zone_name').html(newNames+'('+nums+')');
			*/},
			//关闭聊天框和空间信息、左右移动主菜单
			closeChatDialogALeft: function(){/*
               // $('.SNS_pop_box .SNS_default_head').addClass('SNS_top_bg'); //添加顶部指向箭头
              //  $('.SNS_pop_box').removeClass('sns_list'); //sns主窗口左右偏远位置
                $('.Chatwindow_right:visible').hide(1000); //隐藏对话主窗口
                $('#Information_Chat:visible').hide(1000);//隐藏设置对话框
               // $('.personalspace_cont_right').hide(1000); //隐藏个人空间
                $('.show_active_details').hide(); //隐藏活动详情页模板
                $('.hiddenactive').hide(); //隐藏日程活动弹出框
                $('.cls_sns_right_default_pic').show(); //显示橙子的背景
			*/},
			//删除群组后，移除群组数据
			removeGroup: function(groupId,tipMsg,groupName){/*
				//清空最近聊天记录后端缓存
				var tmpUrl = gUrlSnsRemoveCacheGroup.replace('.html','');
				var img = new Image();
				img.src = tmpUrl+'?groupId='+groupId;
				
				//删除历史记录
				var img = new Image();
				delGroupTalkUrl = delGroupTalkUrl.replace('.html','');
				img.src = delGroupTalkUrl+'?type=groupTalk&imid='+groupId;

				$.bug(7) && console && console.log($.WebChat.data.groupImids[groupId],$.WebChat.data.groupAdmin[groupId], $.WebChat.data.groupInfos[groupId]);//ok
				//删除缓存
				delete $.WebChat.data.groupImids[groupId]; //群组imids列表
				delete $.WebChat.data.groupAdmin[groupId]; //群管理员imids列表
				delete $.WebChat.data.groupInfos[groupId]; //群成员信息列表
				$.bug(7) && console && console.log($.WebChat.data.groupImids[groupId],$.WebChat.data.groupAdmin[groupId], $.WebChat.data.groupInfos[groupId]);//ok
				
				//移除掉最近聊天信息里和群组里退出的群组
				$('.leftbox_'+groupId).remove();
				var barObj = $('.contact_'+groupId).prev('.left_list_A');
				$('.contact_'+groupId).remove();
    			barObj.next('.left_list_ul').length == 0 ? barObj.remove() : '';
				$('.snsiconzone_liaot_c').hide();
				if(typeof(groupName) != 'undefined'){这里由于默认群组名称为空,app群组信息可以从手机端取，而web不能，造成的，是设计与实现上造成的
					$.global_msg.init({
						msg : tipMsg,
						icon : 1
					});
				}
			*/},
			/**
			 * 转换首字母
			 */
			changeFirstWord: function(first_k,key){
				var regExp = /[^\u4e00-\u9fa5]/;
				if(!regExp.test(first_k)){
					var k = icibahy.indexOf(first_k);					
					var zm = icibahy[k+1];
					var limitzm = $.WebChat._getWord();
					for(var f in limitzm){
						for(var m in f){
							if (typeof(f[m]) == 'string') {
								if(f[m].indexOf(zm)>-1){
									zm = f;
								}	
							}
						}
					}					
					zm = zm.toUpperCase();
					if(zm!=key){
						key = zm;
					}
				}else if(/^[0-9]$/.test(first_k)){
					if(key!='#'){
						key = '#';
					}
				}
				//console.log(first_k,key)
				return key;
			},
			_getWord: function(){
				var limitzm = new Object();
				limitzm['a'] = ['ā','á','ǎ','à'];
				limitzm['e'] = ['e','ē','é','ě','è'];
				limitzm['o'] = ['ō','ó','ǒ','ò'];
				return limitzm;
			},
			/**
			 * 处理im自定义接收的类型(异步修改群组名称、修改群头像)
			 */
			dealImTextCustom: function(msg){/*
				var xmlStr = $(msg.szXmlText);
				var xmlObj = $(xmlStr[1]); //xml对象
				var modifyType = xmlObj.find('action').text();
				var fromUserId = msg.nFromUserID;
				var groupId = msg.nGroupID;
				var time       = msg.nTime;
				var imid = $('#Chatwindow_right .contact_zone').attr('clientid');
				var text = '';
				if(modifyType == 'modify_group_name'){//群名称
					var newGroupName = xmlObj.find('group_new_name').text();
					$.WebChat.updateManyGroupName(groupId,newGroupName);
					var img = new Image();
					 gUrlSnsCacheOperator = gUrlSnsCacheOperator.replace('.html','');
					img.src = gUrlSnsCacheOperator+'?type=U_GROUP&groupId='+groupId;
					text = gGropuNameChange;//+newGroupName
				}else if(modifyType == 'modify_group_icon'){//群头像
					var newGroupAvatar = xmlObj.find('group_new_name').text();
					text = gGropuIconChange;
					var htmImg = '<img src="'+newGroupAvatar+'"/>';
					$.WebChat.updateLeftTopAvatar(groupId,htmImg);
				}
				var name = ''; //修改操作的用户名称
				if(typeof($.WebChat.vars.allFriends[fromUserId]) == 'undefined'){
					$.ajax({url:gUrlSnsGetName,data:{imid:fromUserId},async:false,success:function(rst){
						name = rst.data;
					}});
				}else{
					name = $.WebChat.vars.allFriends[fromUserId]['realname'];
				}
				if(groupId == imid){//判断是当前打开的聊天窗口
					var date = $.util.ftime(time*1000);
					//console.log(text)
					var html = '<div class="all_snsbox"><i class="mCSBtext_align yuanjiao_input">' +date+' '+name+text+ '</i></div>';
					$('#talk_box').find('.mCSB_container').append(html);
				}				
			*/},
			/**
			 * 修改群组名称
			 */
			updateManyGroupName: function(groupId,groupName){/*
				if(!groupName)return;
				var obj = $('#Information_Chat').find('#crewlist').find('.iInformation_all_list');
                var num = obj.length;
                $('#recentBox').find('.leftbox_'+groupId).find('.SNS_pop_text').children('b').attr('title',groupName);
                groupName = cutstr_en(groupName,$.WebChat.CONST.LEFT_CUT_STR_NUM,'...');
                topname = cutstr_en(groupName,$.WebChat.CONST.TOP_CUT_STR_NUM,'...');
                // groupId;
                $('#Chatwindow_right .contact_zone').find('.custom_name').html(topname+'('+num+')');//顶部内容
                // 左侧内容
                $.bug(5) && console && console.log('设置成功',groupId);
                $('#recentBox').find('.leftbox_'+groupId).find('.SNS_pop_text').children('b').html(groupName+'('+num+')');
                $('.contact_'+groupId).find('.SNS_pop_text').children('b').html(groupName+'('+num+')');
			*/},
			/**
			 * 更新新消息数量到后台
			 */
			updateBackNewMsgNum: function(fromImid,num,opera){
				/*var data = {fromImid:fromImid,num:num,opera:opera};
				$.post(gUrlSnsUpdateNewMsgNum,data,function(msg){
				});*/
			},
			/**
			 * 打开web发送消息对话框、聊天框
			 */
			openWebTalk: function(thisObj){/*
				$('.MainContentRight_right').children().hide();
            	imTabLeftClick();//触发左侧tab的点击事件，左侧tab背景变灰 
                var imid = thisObj.attr('imid');
                
                var baseuserinfo = thisObj.attr('headid'); //只有我的联系人、置顶列表有此属性，群组、公共号、最近联系人都未发现此属性
                //获取聊天类型
                var type = thisObj.attr('type');
                $('input[name="talkType"]').val(type);
                //判断是群聊还是个人聊天
                var img_html = thisObj.find('.SNS_pop_img').html(); //获取当前头像html结构
                $('.Chatwindow_right').find('.Chatwindow_title').find('.SNS_pop_img').html(img_html); //设置聊天对话框左上角的聊天对话头像
                var nums = 0;
                $('input[name="clientid"]').val(imid);
                if (type=="talk") {个人
                    $('input[name="groupid"]').val('');  //建议去掉
                    $('input[name="fuid"]').val(baseuserinfo);
                    $('.setGroupTalk').hide(); //隐藏删除并退出群组按钮
                } else if(type == 'groupTalk'){群组
                    $('input[name="groupid"]').val(imid); //建议去掉
                    $('input[name="fuid"]').val(baseuserinfo);
                    nums = thisObj.find('.SNS_pop_text b').attr('data-num');
                    $('.setGroupTalk').show();//显示删除并退出群组按钮
                }else if(type == 'publicNumber'){公众号
                		//$('input[name="groupid"]').val(''); //建议去掉
                	$('.setGroupTalk').hide();//隐藏删除并退出群组按钮
                }
                var name = thisObj.find('.SNS_pop_text b').attr('title'); //名称全称
                		//  var display = .css('display'); //最近聊天对象
                $('#Information_Chat').hide(); //这个好像设置的结构
                		//if (display == 'none') {
                $('#recentBox').is(':hidden') && $('#contactBox').show(); //隐藏通讯录列表结构
                		//}
                
                //个人聊天、群组聊天、公众号聊天
                $.sns_common.userTalk(imid, name,type,nums); //type:talk,groupTalk,publicNumber
                var littleObj = thisObj.find('.cls_little_red_tips');
                if(littleObj.is(':visible')){//清空小红点
                   // $.WebChat.updateBackNewMsgNum(imid,0,'set');
                    littleObj.hide();
                    littleObj.text(0);
                }
			*/},
		  friendRequestOpen: function(type){/*//打开好友请求列表
			  if(type == 1){
				  setTimeout(function(){
					  $('.cls_im_single_notice').click();
				  },1000);
			  }
		  */},
		  friendRequestNum: function(num){/*//设置好友请求的数量
			  var thisObj = $('.cls_im_single_notice');
			  typeof(gFrFlag) == 'undefined' ? (gFrFlag=0): null;
			  if(num>0){
				  thisObj.find('.cls_little_red_tips').html(num);
				  thisObj.find('.cls_little_red_tips').show();
				  thisObj.show();
			  }else if(gFrFlag == 1){
				  thisObj.find('.cls_little_red_tips').html(num);
				  thisObj.find('.cls_little_red_tips').hide();
				  thisObj.show();
			  }else{
				  thisObj.hide();
			  }
		  */},
		  friendRequestList: function(thisObj){/*//打开好友请求列表
            //设置选中项的背景色
          	$('#recentBox').find('.cls_im_single_list').css('background-color',$.WebChat.CONST.ITEM_DEFAULT_COLOR); //重置颜色
          	$('#recentBox').find(thisObj).css('background-color',$.WebChat.CONST.ITEM_CHECKED_COLOR); //设置当前选中颜色
          	
          	$('.MainContentRight_right').children().hide();
          	var pageNum = 1;
          	var paramData = {pageNum:pageNum,type:'friend',rows:10};
          	$.get(gUrlSnsGetFriendRequest,paramData,function(rst){
          		$.sns_common.htmlFriendRequest(rst,pageNum);
          	},'json');      
          	
		  */},
		  uploadGroupAvatar: function(talkType,str_stick_id,talkGroupID,groupNameOld,groupNameNew){/*//上传群组头像到后台
              var imagepath = $('input[name="snsimagePath"]').val();
              if(imagepath == ''){
                  //$.global_msg.init({msg:js_uploadImg,icon:'1'});
            	  //保存个人、群组设置
                  $.WebChat.saveSetOption(talkType,str_stick_id,talkGroupID,groupNameOld,groupNameNew);
              }else{
                  var x1 = $('input[name="snsleft"]').val();
                  var y1 = $('input[name="snstop"]').val();
                  var size = $('input[name="snscut_ratio"]').val();
                  var clientid = $('input[name=clientid]').val();
                  var personalid = $('input[name=personalid]').val();
                  $.post(SnsimagePsUrl,{x1:x1,y1:y1,size:size,url:imagepath,clientid:clientid,personalid:personalid},function(result){
                      if(result.status == '1'){
                          var clientid = $('input[name=clientid]').val();
                          if (clientid) {
                              modifyGroupLogo(clientid);
                          };
                          //$.global_msg.init({msg:result.info,icon:'1'});
                          $('.Information_btin').hide();
                          
                          //修改群组头像后，通知im服务器
                          var toUserId = clientid;
                          var seqId = Math.uuid();
                          var content = '<?xml version="1.0" encoding="utf-8"?>'+
                          	'<XML>'+
                          '<action>modify_group_icon</action>'+
                          '<content>'+
                          	'<group_new_icon>'+result.data+'</group_new_icon>'+
                          '</content>'+
                          '</XML>';
                          SendBinaryMessage(oo,5,6,toUserId,0,seqId,content);
                          var myDate = new Date();
                          var date = myDate.getHours() + ':' + myDate.getMinutes();
                          var content = date+' '+gItIsMe+gGropuIconChange; 更改了群头像
                          var html = '<div style="height: 20px;color: aqua;padding-left: 30%">' +content +'</div>';
      					$('#talk_box').find('.mCSB_container').append(html);
                          //保存个人、群组设置
                          $.WebChat.saveSetOption(talkType,str_stick_id,talkGroupID,groupNameOld,groupNameNew);
                      }else{
                          $.global_msg.init({msg:result.info,icon:'2'});
                      }
                  });
              }
		  */},
		  /**
		   * 修改群组头像
		   */
		  imUpdateGroupAvatar: function(talkGroupID,groupNameNew){/*
				 $.WebChat.updateManyGroupName(talkGroupID,groupNameNew); // 右侧内容
                 //异步修改群名称后
                 var seqId = Math.uuid();
                 var content = '<?xml version="1.0" encoding="utf-8"?>'+
                 	'<XML>'+
                 		'<action>modify_group_name</action>'+
                 			'<content>'+
                 				'<group_new_name>'+groupNameNew+'</group_new_name>'+
                 			'</content>'+
                 	'</XML>';
                 SendBinaryMessage(oo,5,6,talkGroupID,0,seqId,content);
                 
               var myDate = new Date();
               var date = myDate.getHours() + ':' + myDate.getMinutes();
               var content = date+' '+gItIsMe+gGropuNameChange;
               var html = '<div style="height: 20px;color: aqua;padding-left: 30%">' +content +'</div>';
				  $('#talk_box').find('.mCSB_container').append(html); 
		  */},
		  /**
		   * 保存个人、群组设置项目到后台
		   */
		  saveSetOption: function(talkType,str_stick_id,talkGroupID,groupNameOld,groupNameNew){/*
			  $.bug(5) && console && console.log('设置中 str_stick_id='+str_stick_id, 'talkGroupID'+talkGroupID);
				var isSetStick = $('#setStick').prop("checked"); //是否置顶
				var isSetBlack = $('#setBlock').prop("checked"); //是否黑名单
				var isSetNodisturbing = $('#setMsg').prop("checked"); //是否消息免打扰
				var imid = $('#Chatwindow_right .contact_zone').attr('clientid');

			    if (groupNameNew == gImNoNamed || groupNameNew == groupNameOld) {
			    	groupNameNew = '';//群组名称未修改
			    };//未命名
			    var dataParam = {
			    		talkType: talkType,
			    		str_stick_id: str_stick_id,
			    		talkGroupID: talkGroupID,
			    		isSetStick: isSetStick,
			    		isSetBlack: isSetBlack, 
			    		isSetNodisturbing: isSetNodisturbing
				 		};
			    if('groupTalk' == talkType){
			    	var isSaveToContacts = $('#setToContacts').prop("checked");
			    	groupNameNew ? dataParam.groupname = groupNameNew : '';
			    	dataParam.isSaveToContacts = isSaveToContacts;
			    }
				$.ajax({ 
					 type: "post",
					 url: gUrlSnsSetGroupPerson,
					 data: dataParam,
					 success: function(msg){
						 if(msg.status!=0 && msg.flag=='talk'){
							 $.global_msg.init({msg:gImSetPersonInfoFail,btns:true,icon:0});
						 }else if(msg.status!=0 && msg.flag=='groupTalk'){
							 $.global_msg.init({msg:gImSetGroupInfoFail,btns:true,icon:0});
						 }else{
							 $.global_msg.init({msg:gImSetSucc,btns:true,icon:1});
			                 $.webim.getAllGroups();
							 if(talkType == 'groupTalk' && groupNameNew){
							    $.WebChat.imUpdateGroupAvatar(talkGroupID,groupNameNew);//修改群组头像：
			                 }
	
							//加入最近聊天框 或者返回聊天
						     $('.Chat_title_img').click();
							 //如果是取消置顶吧最近聊天框的记录移动到下面
							 if(!isSetStick){
								 if($('.left_list_box .mycontacts').html() == ''){
								 }else{
									 console &&  console.log($('.left_list_box .mycontacts .left_list_ul'));
								 }
								 if(typeof($.WebChat.data.stickIds[imid]) != 'undefined'){
									 delete $.WebChat.data.stickIds[imid];
								 }
							 }else{
								 if(typeof($.WebChat.data.stickIds[imid]) == 'undefined'){
									 $.WebChat.data.stickIds[imid] = '';
								 }
							 }
							$('#Chatwindow_right').show(500);
							var tmpImid = !!talkGroupID?talkGroupID:str_stick_id;
							//console.log('isSetNodisturbing'+isSetNodisturbing,$('#recentBox .leftbox_'+tmpImid))
							
							if(isSetNodisturbing){//设置消息免打扰
								var userObj = $('#recentBox .leftbox_'+tmpImid);
								//console.log('d-------',userObj.find('.clsSnsNotNoticeLebal'),userObj.find('.clsSnsNotNoticeLebal').length)
								if(userObj.find('.clsSnsNotNoticeLebal').length == 0){
									var doNotNotice = '<i class="clsSnsNotNoticeLebal"><img src="' + gPublic + '/images/icons/SNS_mdarao_icon.png" /></i>'; //免打扰标志
									userObj.find('.SNS_pop_time').append(doNotNotice);
								}
								$.WebChat.data.disturbImids[imid] = 2;
							}else{//取消消息免打扰
								var userObj = $('#recentBox .leftbox_'+tmpImid).find('.clsSnsNotNoticeLebal');
									userObj.length == 1 ? userObj.remove() : '';
								$.WebChat.data.disturbImids[imid] = 1;
							}
							
							 var img = $('.leftbox_'+imid+ ' .marginauto').find('img').attr('src');
			                 var latelyname = $('.leftbox_'+imid+ ' .SNS_pop_text').find('b').attr('title');
							 var latelychatcontent = $('.leftbox_'+imid+ ' .SNS_pop_text').find('p').text();
							 var nums = '';
							 if(talkType == 'groupTalk'){
								 nums = $('#Information_Chat').find('#crewlist').find('.iInformation_all_list').length; //计算群组设置中的群组成员个数
							 }
							 var obj = $('#recentBox .leftbox_'+imid); 
							 cancleStaticContacts(str_stick_id,talkType,latelyname,img,latelychatcontent,nums,!!isSetStick,obj); 
							 $.webim.setBlack(isSetBlack,imid);//设置黑名单
						 }
					 } 
					});
				
		  */},
		  pageUtil: function(obj){/*//分页公共处理方法
				//滚动条滚动到底部
				var obj = $('#memberList_group');
				var page      = obj.attr('dataCurrPage'); 
				var totalPage = obj.attr('dataTotalPage');
				if(page<totalPage){
					page++;
					var dataParam = {page:page};
					$.get(gUrlSnsGroupGetList,dataParam,function(rst){
						var data = rst.data;
						var htmlTpl = data.tpl;
						obj.find('.mCSB_container').append(htmlTpl);
						obj.attr('dataCurrPage',data.currPage);
						obj.attr('dataTotalPage',data.totalPage);
					});
				}
		  */},
		  /**
		   * 显示展会名片池结构
		   */
		  showPublicMoreStruct: function(thisObj){/*
			var msgType = thisObj.attr('type');
			if(msgType == 'http'){
				var url = thisObj.attr('url');
				window.open(url); //window.location.href = url;
			}else if(msgType == 'vcard'){
	      		$('#publicMoreVcardTotal').show();
	    	    $('#Chatwindow_right').hide(500);
	    	    $('.clsPublicTab').removeClass('active').first().addClass('active');
	    		var expoid = thisObj.attr('expoid');
	    		var gType = 2;//1:观众、2：参展商
	    		var dataParam = {gType:gType,expoid:expoid};
	    		$.WebChat.getPublicGroupCount(dataParam);
	    		$.sns_common.bindEvtAfter.setting.publicPoolReturnToChat();
			}
		  */},
		  /**
		   * 获取分组总数量
		   */
		  getPublicGroupCount: function(dataParam){/*
	    		dataParam.type = 4;
	    		$.get(gUrlGetPublicVcard, dataParam, function(rst){
	    	  		dataParam.type = 1;
	    	  		dataParam.numfound = rst.data;
	    	  		$.WebChat.getPublicGroup(dataParam);
	    		});
		  */},
		  /**
		   * 获取名片池分组列表数据
		   */
		  getPublicGroup: function(dataParam){/*
     		$.get(gUrlGetPublicVcard, dataParam, function(rst){
        			var data = rst.data;
        			var html = $.sns_common.publicHtmlGroup(data);
        			var scrollObj = $('.clsPublicContent');
      	        	if(!scrollObj.hasClass('mCustomScrollbar')){
    	        		scrollObj.html(html);
    	        		scrollObj.mCustomScrollbar({
    				        theme:"dark", //主题颜色
    				        autoHideScrollbar: false, //是否自动隐藏滚动条
    				        scrollInertia :0,//滚动延迟
    				        horizontalScroll : false,//水平滚动条
    				        callbacks:{
    				            onScroll: function(){} //滚动完成后触发事件
    				        }
    				    });
    	        	}else{
    	        		scrollObj.find('.mCSB_container').html(html)
    	        	}
        		});
		  */},
		  /**
		   * 触发公众号参展商、观众标签的点击
		   */
		  tiggerPublicTab: function(thisObj){/*
			  if(!thisObj.hasClass('active')){
				  thisObj.addClass('active').siblings('.clsPublicTab').removeClass('active');
				  var expoid = $('input[name="clientid"]').val();//展会id
				  
		    	  var gType = thisObj.attr('val');//1:观众、2：参展商
		    	  var dataParam = {gType:gType,expoid:expoid};
		    	  $.WebChat.getPublicGroupCount(dataParam);
			  }
		  */},
		  /**
		   * 触发公众号名片池分组名称的点击事件
		   */
		  trigPublicGroup: function(thisObj){/*
			  var ulObj = thisObj.next('ul');
			  if(ulObj.children().size() == 0){
				  var property = thisObj.attr('property');
				  var groupId = thisObj.attr('groupid');
				  var groupName = thisObj.text();
				  var expoid = $('input[name="clientid"]').val();//展会id
				  
	    		  var dataParam = {type:2, expoid:expoid, property:property, groupId:groupId, groupName:groupName};
				  $.get(gUrlGetPublicVcard, dataParam, function(rst){
					var html = $.sns_common.publicHtmlVcard(rst.data.list);
					ulObj.html(html);
	    		  });
			  }else{
				  ulObj.toggle();
			  }
		  */},
		  //名片池--保存名片池名片
		  trigPublicVcardOk: function(thisObj){/*
			  var checkVcard = $('#publicMoreVcardTotal').find('.clsPublicGroupUl:visible').find('.clsPublicVcardSingleCheck').filter('.active');
			  var dataArr = [];
			  var maxLen = checkVcard.size();
			  if(maxLen == 0){
				  $.global_msg.init({msg:gImPleaseChooseVcardDownload,btns:true,icon:0});请选择要下载的名片
			  }else if(maxLen >$.WebChat.CONST.MAX_PUBLIC_VCARD_POOL_DOWNLOAD){
				  $.global_msg.init({msg:gImVcardDownloadMostNumber.replace('%d%',10),btns:true,icon:0});一次最多能下载n张名片
			  }else if(maxLen>0){
				  checkVcard.each(function(index,dom){
					  var obj = $(this);
					  dataArr[index] = {expoid:obj.attr('expoid'),vcardid:obj.attr('vcardid')};
				  });
				  var expoid = $('input[name="clientid"]').val();
				  var name = $('.im_common .publicno_'+expoid).find('.cls_public_single_name').attr('title');
				  var dataParam = {data:dataArr,type:3,name:name};
				  $.post(gUrlGetPublicVcard,dataParam,function(rst){
					  if(rst.succ){
						  var vcardArr = rst.succ.split(',');
						  $.each(vcardArr,function(i,n){
							  var oldNew = n.split('_');
							  var id = oldNew[0];
							  $('.clsPublicVcardSingleCheck[vcardid="'+id+'"]').removeClass('clsPublicVcardSingleCheck').addClass('default');
						  });
					  }
					  if(rst.flag == true){
						  $.global_msg.init({msg:gImDownloadVcardSucc,btns:true,icon:1});下载名片成功
					  }else{
						  $.global_msg.init({msg:gImDownloadVcardFail,btns:true,icon:0}); 下载名片失败
					  }
				  },'json');
			  }
			  
		  */},
		  //右键菜单设置黑名单
		  /*  rightSetBlack: function(obj){
			  $.bug(5) && console && console.log('xxxxxxxx',obj)
			    var talkType = obj.attr('type');
			  	var imid = obj.attr('imid');
			  	var num = 2;
			  	$.bug(5) && console && console.log(talkType)
				if(talkType == 'talk'){
					ChatManager(oo,0,parseInt(imid),num);
				}else{
					ChatManager(oo,5,parseInt(imid),num);
				}
		  },
		  //右键取消设置黑名单
		  rightCacnelBlack: function(obj){
			  	var talkType = obj.attr('type');
			  	var imid = obj.attr('imid');
			  	var num = 1;
				if(talkType == 'talk'){
					ChatManager(oo,0,parseInt(imid),num);
				}else{
					ChatManager(oo,5,parseInt(imid),num);
				}
		  },
		  //右键移除该会话
		  rightRemoveChat: function(obj){
			  var talkType = obj.attr('type');
			  var imid = obj.attr('imid');
			  var dataParam = {
				  talkType: talkType,
				  operaType:'removeChat',
				  imid: imid
			  };
			  $.post(gUrlRightMenu,dataParam,function(rst){
					 if(rst.status == 0){
						 $('#recentBox .leftbox_'+imid).remove();
						 $('.MainContentRight_right').children(':visible').hide();
						 $('.MainContentRight_right .cls_sns_right_default_pic').show();
					 }
			  },'json');
			  if(obj.parents('.mystick').size() == 1){//并且取消置顶
				  dataParam.operaType = 'cancelStick';
				  $.post(gUrlRightMenu,dataParam,function(rst){
					  if(typeof($.WebChat.data.stickIds[imid]) != 'undefined'){
							delete $.WebChat.data.stickIds[imid];
						 }
				  },'json');
			  }
		  },
		  //右键设置置顶
		    rightSetStick: function(obj){
			  $.bug(5) && console &&  console.log('设置置顶',obj)
			  var talkType = obj.attr('type');
			  var imid = obj.attr('imid');
			  var dataParam = {
				  talkType: talkType,
				  operaType:'setStick',
				  imid: imid
			  };
			  $.post(gUrlRightMenu,dataParam,function(rst){
					 var img = obj.find(' .marginauto').find('img').attr('src');
	                 var latelyname = obj.find('.SNS_pop_text').find('b').attr('title');
					 var latelychatcontent = obj.find('.SNS_pop_text').find('p').text();
					 
					 var nums = (talkType == 'groupTalk') ? obj.find('.SNS_pop_text>b').attr('data-num') : '';
					 cancleStaticContacts(imid,talkType,latelyname,img,latelychatcontent,nums,true,obj);
					 if(typeof($.WebChat.data.stickIds[imid]) == 'undefined'){
						 $.WebChat.data.stickIds[imid] = '';
					 }
			  },'json');
		  },
		  //右键取消置顶
		  rightCancelStick: function(obj){
			  var talkType = obj.attr('type');
			  var imid     = obj.attr('imid');
			  var dataParam = {
				  talkType: talkType,
				  operaType:'cancelStick',
				  imid: imid
			  };
			  $.post(gUrlRightMenu,dataParam,function(rst){
					 var img = $('.leftbox_'+imid+ ' .marginauto').find('img').attr('src');
	                 var latelyname = $('.leftbox_'+imid+ ' .SNS_pop_text').find('b').attr('title');
					 var latelychatcontent = $('.leftbox_'+imid+ ' .SNS_pop_text').find('p').text();
					 
					 var nums = (talkType == 'groupTalk') ? obj.find('.SNS_pop_text>b').attr('data-num') : '';
					 cancleStaticContacts(imid,talkType,latelyname,img,latelychatcontent,nums,false,obj);
					 if(typeof($.WebChat.data.stickIds[imid]) != 'undefined'){
						 delete $.WebChat.data.stickIds[imid];
					 }
			  },'json');
		  },
		  //右键菜单rightMenu
		  bindRightMenu:function(options){
				var defaults = {
						selector: '.cls_im_single_list'
					};
				var opts = $.extend(true,{},defaults,options);
				//自定义右键上下文
				var objDefined = {
						stick:{
							text: gSetTop,置顶
							func: function() {
								$.WebChat.rightSetStick($(this));
							}	
						}, 
						stickCancel: {
							text: gCancleTop,取消置顶
							func: function() {
								//$.WebChat.rightCancelStick($(this));
							}
						},
						removeChat:{
							text: gImRemoveTheChat, 移除该对话
							func: function() {
								$.WebChat.rightRemoveChat($(this));;
							}	
						}, 
						setBlack:{
							text: gImJoinBlack, 加入黑名单
							func: function() {
								$.WebChat.rightSetBlack($(this));
							}
						}, 
						removeBlack:{
							text: gImRemoveBlack,移除黑名单
							func: function() {
								$.WebChat.rightCacnelBlack($(this));
							}	
						}
				};
				var chatMenuData = []; 
				$(opts.selector).smartMenu(chatMenuData, {
					name: "snsChatRightMenu",
					beforeShow: function() {
						var obj = $(this);
						chatMenuData.splice(0,chatMenuData.length); //清空数组中原始数据
						
						if(obj.parents('.mycontacts').length == 1){我的最近联系人
							chatMenuData.push([objDefined.stick]); //设置置顶
							chatMenuData.push([objDefined.removeChat]); //移除该对话
						}
						if(obj.parents('.mystick').length == 1){我的置顶列表
							chatMenuData.push([objDefined.stickCancel]); //取消置顶
							chatMenuData.push([objDefined.removeChat]); //移除该对话
						}			
						
						var imid = obj.attr('imid');
						if(obj.parents('.im_friends').length == 1 && obj.attr('type') == 'talk'){好友列表
							if(typeof($.webim.CONST.BLOCK_LIST[imid]) != 'undefined'){
								chatMenuData.push([objDefined.removeBlack]);  //移除黑名单
							}else{
								chatMenuData.push([objDefined.setBlack]); //设置黑名单
							}
							
							if(typeof($.WebChat.data.stickIds[imid]) == 'undefined'){
								chatMenuData.push([objDefined.stick]); //取消置顶
							}else{
								chatMenuData.push([objDefined.stickCancel]); //设置置顶
							}
						}else if(obj.parents('.im_groups').length == 1 && obj.attr('type') == 'groupTalk'){群组列表
							if(typeof($.WebChat.data.stickIds[imid]) != 'undefined'){
								chatMenuData.push([objDefined.stickCancel]); //取消置顶
							}else{
								chatMenuData.push([objDefined.stick]); //设置置顶
							}
						}else if(obj.parents('.im_blacklist').length == 1){黑名单列表
							chatMenuData.push([objDefined.removeBlack]);  //移除黑名单
						}else if(obj.parents('#recentBox').length == 1 && obj.attr('type') == 'talk'){//最近聊天列表和置顶列表
							var imid = obj.attr('imid');
							if(typeof($.webim.CONST.BLOCK_LIST[imid]) != 'undefined'){
								chatMenuData.push([objDefined.removeBlack]);  //移除黑名单
							}else{
								chatMenuData.push([objDefined.setBlack]); //设置黑名单
							}
						}

					}
				});				
			},*/
			//懒加载群组头像(通过算法)
			lazyGroupAvatar: function(){/*
				return '';
				var contentHeight = 550; //内容高度
				var contactBoxTop = $('#contactBox').offset().top; //右侧固定最高top
				    contactBoxBottom = contactBoxTop+contentHeight; //右侧固定最低top
				var imGroupsObj = $('.im_groups');
				var imGroupsTop = imGroupsObj.offset().top;
				var chooseCommonTop = $('.choose_common').offset().top;
				if(imGroupsObj.is(':visible') && imGroupsTop<contactBoxBottom && chooseCommonTop>contactBoxTop){
					var groupWordObjs = imGroupsObj.find('.left_list_A');
					var groupWrodArr = [];
					var wordsMiddleArr = [], wordsUpArr = [], wordsDownArr = [];
					
					$.each(groupWordObjs,function(){
						var obj = $(this);
						var word = obj.find('span').text();
						groupWrodArr.push(word);
						var wordTop = obj.offset().top;
						if(wordTop<contactBoxTop){
							console.log('up')
							wordsUpArr.push(word);
						}else if(wordTop > contactBoxBottom){
							console.log('down')
							wordsDownArr.push(word);
						}else if(wordTop>=contactBoxTop && wordTop<=contactBoxBottom){
							console.log('middle')
							wordsMiddleArr.push(word);
						}
					});
					
					var getWordData = [];
					if(wordsMiddleArr.length == 0){
						console.log('middle is null')
						var tmpWord = wordsUpArr[wordsUpArr.length-1];
						getWordData.push(tmpWord);
					}else{
						var tmpWord = wordsUpArr[wordsUpArr.length-1];
						getWordData.push(tmpWord);
						getWordData = $.extend([],getWordData,wordsMiddleArr);
					}
					
					console.log('tt',getWordData)
					$.each(getWordData,function(index, thisWord){
						var groupObjs = $('.cls_im_word_list_'+thisWord);
						$.each(groupObjs,function(){
							var thisImage = $(this).find('.snsLazyImg');
							$.each(thisImage,function(i,dom){
								var obj = $(dom);
								obj.attr('src', obj.attr('data-original'));
								obj.removeClass('snsLazyImg');
							});
						});
					});
				}
			*/},
			myScrollTongXunlu:function(selector,callbacks){/*
				var scrollObj = $(selector);
				//滚动条生效后不再执行
	        	if(!scrollObj.hasClass('mCustomScrollbar')){
	        		scrollObj.mCustomScrollbar({
				        theme:"dark", //主题颜色
				        autoHideScrollbar: false, //是否自动隐藏滚动条
				        scrollInertia :0,//滚动延迟
				        horizontalScroll : false,//水平滚动条
				        callbacks:{onScroll: $.WebChat.lazyGroupAvatar}
				    });
	        		return false;
	        	}else{
	        		return true;
	        	}
			*/},
			//根据id获取名称(好友、群组、公众号)
			getNameById: function($imid, $imtype, $nameAll){/*
				$imtype   = $imtype || 'imid'; //imid:聊天号, clientid:用户id
				$nameAll  = $nameAll || 1; // 1:表示名称全称，0：表示名称截取后的部分
			*/},
			//根据id获取头像(好友、群组、公众号)
			getAvatarById: function($imid){
				
			}
			
		},
		/*WebChat模块end*/
		util:{
			/**
			 * 格式化日期，把时间戳转换为2014-10-11 10:14:50
			 * @param timestamp unix时间戳，单位毫秒
			 * @param format  年月日 之间的连接符，默认为 -
			 */
			ftime: function(timestamp,addDay, format){
				if(isNaN(timestamp)){                
					$.bug(1) && console && console.info('参数格式错误，必须为数字:'+timestamp);
					return '';
				}
				timestamp.length == 0 ? (timestamp = timestamp*1000) : '';
				timestamp.length > 13 ? (timestamp = timestamp/1000) : '';
				timestamp = parseInt(timestamp);
				this.fNum = function(num){
					num = num <10?('0'+num):num;
					return num;
				};
				  addDay = addDay || 0;
				 // format = format || '-'; 	
				var date = new Date(parseInt(timestamp + addDay*24*60*60*1000)); 
			    var	Y = date.getFullYear();  
			    var	M = date.getMonth()+1;  
			    var D = date.getDate(); 
			     	//var s = d.toLocaleString();  // toLocaleString()在google浏览器和ie，火狐的结果不一样 
			    var hh = date.getHours(); //截取小时，即8 
				var mm = date.getMinutes(); //截取分钟，即34    
				var ss = date.getTime() % 60000; //获取时间，因为系统中时间是以毫秒计算的，所以秒要通过余60000得到。 
				        ss = (ss - (ss % 1000)) / 1000; //然后，将得到的毫秒数再处理成秒  // ss = d.getSeconds();	 
				    	M = this.fNum(M);
				    	D = this.fNum(D);
				    	hh = this.fNum(hh);
				    	mm = this.fNum(mm);
				    	ss = this.fNum(ss);
				  if(format){
					  var rtnDate = Y+format+M+format+D+' '+hh+":"+mm+":"+ss; 
				  }else{
					  var rtnDate = hh+":"+mm;
				  }				
			     return rtnDate;
			}
		},
		/*
		 * 开启调试模式, 1:error,2:websocket交互信息 , 3:回调信息  4：二进制流程信息， 5：普通的调试信息,6:大量数据的信息回调 , 7：缓存一致性调试
		 */
		bug: function(errCode){
			typeof(debugCode) == 'undefined' ? (debugCode = 10) : null; /*debugCode是通过url传递过来的参数*/
			return debugCode>=errCode;
		},
		s: function(){
			var date = new Date();
			return date.getTime();
		},
		e: function(){
			var date = new Date();
			var end = date.getTime();
			return end;
		}
	});  
})(jQuery);