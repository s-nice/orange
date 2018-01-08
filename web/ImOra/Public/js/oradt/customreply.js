/*已经回复、未回复js生成页面结构操作*/
;
(function($){
	$.extend({
		replyTable:{
			init: function(opts){/*初始化*/
				var defaults = {currMenuIndex:0};
				var options = $.extend(true,{},defaults,opts);
				this.initData(options);
				this.bindEvnt();				
			},
			initData:function(options){/*加载搜索条件*/
				$('#keyword,#js_begintime,#js_endtime').val('');
				if(options.currMenuIndex == '0'){/*已回复*/
					this.loadDataReply(options);
					$(".js_ask_time").attr('data-sort',2).find('u').html(gStrCustomLastAskTime);
					$(".js_ask_time").find('em').removeClass('list_sort_asc').addClass('list_sort_desc');
				}else if(options.currMenuIndex == '1'){/*未回复*/
					this.loadDataNoReply(options);
					$(".js_ask_time").attr('data-sort',1).find('u').html(gStrCustomAskTime);
					$(".js_ask_time").find('em').removeClass('list_sort_desc').addClass('list_sort_asc');
				}
				var menuChildTitle = gStrCustomTopMenu+'->'+gStrCustomAskRecord;
				if(options.currMenuIndex == 0){
					menuChildTitle += '->'+gStrCustomReplyed;
				}else{
					menuChildTitle += '->'+gStrCustomNotReplyed;
				}
				$('.section_top_navigation>span:eq(1)').html(menuChildTitle);
				
			},			
			bindEvnt: function(){/*绑定事件*/
				var that = this;
				//点击搜索
				$('.js_reply_search').off('click').on('click','.js_btn_search',function(){
					that.search();
				});
				/*点击回复按钮操作*/
				$('.js_reply').off('click').on('click','.js_btn_reply',function(){
					
				});
				//点击列表中的回复按钮
				$('.js_tbody_data').off('click').on('click','.js_reply_look_btn',function(){
					$('.section_top_navigation').hide();
					var obj = $(this).parent();
					$.replyTable.fromReply({sendImid:obj.attr('data-imid')});
				});
				//点击分页按钮操作
				$('.js_page_part').off('click').on('click','.prev,.next,.js_redirect',function(evt){
					var thisObj = $(evt.target);
					var parent = thisObj.parents('.js_page_part');
					var page = 0;
					if(thisObj.hasClass('js_redirect')){
						page = $.trim(parent.find('.js_page_input').val());
						var totalpage = parseInt( parent.find('.js_page_input').attr('totalpage'));
						if(page<1 || isNaN(page)){
							page = 1;
						}else if( page > totalpage){
							page = totalpage;
						}
					}else{
						page = thisObj.attr('data-page');
					}
					parent.find('.js_page_input').val('');
					var sort = $('.js_ask_time').attr('data-sort');
					var opts = {currpage:page, sort:sort};
					that.getParam(opts);
				});
				//咨询记录时间排序
				$('.js_ask_time').off('click').on('click',function(){
					var sort = $(this).attr('data-sort');
					var sortNew = (sort == 1) ? 2 : 1;
					var sortCls = (sort == 1) ? 'list_sort_desc' : 'list_sort_asc';
					$('.js_ask_time').attr('data-sort',sortNew).find('em').attr('class',sortCls);
					var opts = {sort:sortNew};
					that.getParam(opts);
				});
				
			},
			fromReply: function(obj){
				var imid = obj.sendImid;
				if($('#js_left_friend_list .js_friend_single[imid="'+imid+'"]').length == 0){
					$.get(gUrlGetFriendInfo,{imids:imid},function(rst){
						if(rst.data.length != 0){
							$.custom.cache.friendInfo[imid] = rst.data;
							$.custom.cache.userInfo[imid] = rst.data;
							$.custom.cache.imidClientMap[imid] = rst.data.fuserid;
							$.custom.genLeftFriendList();
							$('#js_left_friend_list .js_friend_single[imid="'+imid+'"]').click();
						}else{
							$.bug(4) && console && console.log('获取好友信息错误');
						}
					});
				}else{
					$('#js_left_friend_list .js_friend_single[imid="'+imid+'"]').trigger('click');
				}
				$('.js_reply_frame').hide();
				$('.Customer_collection').show();
				//关于菜单效果变化
				$('.js_custom_menu>li').removeClass('active');
				$('.js_custom_menu').removeClass('car').eq(1).addClass('car')
			},
			search: function(){/*搜索数据*/
				this.getParam();
			},
			getParam: function(option){/*获取参数*/
				var keyword = $.trim($('#keyword').val());
				var start = $('#js_begintime').val();
				var end   = $('#js_endtime').val();
				if(start){
					 start = start.replace(/-/g,'/');
					 start = new Date(start);
					 start = start.getTime()/1000;
				}
				if(end){
					end = end.replace(/-/g,'/');
					end = new Date(end);
					end = end.getTime()/1000;
					end += 86399;
				}

				var opts = {currpage:1,keyword:keyword,start:start,end:end};
				var type = $('.js_page_part').find('.js_reply_data_source').val();
					opts = $.extend(true,{},opts,option);
				if(type == 'noreply'){/*未回复列表*/
					this.loadDataNoReply(opts)
				}else if(type == 'replied'){/*已经回复列表*/
					this.loadDataReply(opts)
				}
			},
			//http://www.jb51.net/article/24536.htm  http://www.w3school.com.cn/jsref/jsref_sort.asp
			loadDataNoReply: function(opts){/*加载未回复数据*/
				var rst = {currpage:1,start:'',end:'',sort:1};
					rst = $.extend(true,{},rst,opts);
				var html='';
				var numfound = 0;
				var listData = [];
				//对未回复消息做排序处理
				var arrDate = [];
				var tmpNoReplyObj = {};
				for(var imid in $.custom.cache.noReply){
					var tmpDate = $.custom.cache.noReply[imid];
					arrDate.push(tmpDate);
					tmpNoReplyObj[tmpDate]  = imid;
				}
				rst.sort == 1 ? arrDate.sort(sortAscNumber) : arrDate.sort(sortDescNumber);
				
				//for(var imid in $.custom.cache.noReply){
				for(var j=0; j<arrDate.length; j++){
					var imid = tmpNoReplyObj[arrDate[j]];
					var info = $.custom.cache.userInfo[imid];
					if(opts.keyword && info.mobile.indexOf(opts.keyword) == -1){
						continue;
					}
					//console.log(2,opts.start,$.custom.cache.noReply[imid], opts.start>$.custom.cache.noReply[imid])
					if(opts.start && opts.start>$.custom.cache.noReply[imid]){
						continue;
					}
					if(opts.end && opts.end<$.custom.cache.noReply[imid]){
						continue;
					}
					listData.push({
							name:   typeof(info.name) == 'undefined' ? 'oradt' : info.name,
							mobile: info.mobile,
							date:  $.util.ftime($.custom.cache.noReply[imid]*1000,false,'-'),
							imid: info.imid
							});
					numfound++;
				}
				var rows = PAGE_ROWS_REPLY;
				var start = (rst.currpage-1)*rows;
				var end   = parseInt(start)+parseInt(rows);
				var maxLen = listData.length;
				//for(var i in listData){
				for(var i=0;i<maxLen; i++){
					//分页处理
					//console.log('分页',start,end,i)
					if(i<start){
						continue;
					}else if(i>=end){
						break;
					}
					//console.log('切割数据',i)
					
					var obj = listData[i];
					var name = typeof(obj.name) == 'undefined' ? '' : obj.name ;
						html +='<div class="showdialog_list js_reply_msg_single" data-imid="'+obj.imid+'">\
									<span title="'+name.replace('"', "'")+'">'+name+'</span>\
									<span>'+obj.mobile+'</span>\
									<span>'+obj.date+'</span>\
									<span class="js_reply_look_btn hand">回复</span>\
								</div>';
				}
				$('.js_tbody_data').html(html);
				
				//分页处理
				var outObj = $('.js_page_part');
				$('.js_reply_data_source').val('noreply');
				if(numfound > 0){
					outObj.is(':hidden') ? outObj.show() : null;
					var currpage = parseInt(rst.currpage); //当前页码
					var totalPage = Math.ceil(numfound/rows); //总页数
					var prev = currpage>1 ? currpage-1 : 0; //上一页
					var next = currpage<totalPage ? currpage+1 : 0; //下一页
					
					outObj.find('.nowandall').html(currpage+'/'+totalPage);
					prev > 0 ? outObj.find('.prev').show().attr('data-page',prev) : outObj.find('.prev').hide();
					next > 0 ? outObj.find('.next').show().attr('data-page',next) : outObj.find('.next').hide();
					outObj.find('.js_page_input').attr('totalpage',totalPage);
					$('.js_custom_noreplyed_icon').html(numfound).show();
				}else{
					outObj.is(':visible') ? outObj.hide() : null;
					$('.js_custom_noreplyed_icon').html(numfound).hide();
				}
			},
			loadDataReply: function(opts){/*加载已经回复数据*/
				var data = {sort:2};
				$.extend(data,opts);
				var that = this;
            	$.ajax({
              		 type: "get",
              		 url: gGetReplyList,
              		 data:   data,
              		 async:false,
              		 dataType:'json',
              		 success: function(rst){
              			 that.genHtml(rst.data);
              		 	}
               	}); 
			},
			genHtml: function(rst){/*生成页面结构*/
				var data = rst.list;
				var html='';
				var index = 0;
				for(var i in data){
					index++;
					var obj = data[i];
					var date = $.util.ftime(obj.datetime*1000,false,'-');
					var name = typeof(obj.name) == 'undefined' ? '' : obj.name ;
					html +='<div class="showdialog_list js_reply_msg_single" data-imid="11'+obj.acceptor+'">\
								<span title="'+name.replace('"', "'")+'">'+name+'</span>\
								<span>'+obj.mobile+'</span>\
								<span>'+date+'</span>\
								<span  class="js_reply_look_btn hand">查看</span>\
							</div>';
					$.custom.cache.replyImids['11'+obj.acceptor]  = 0;//填充已回复对象
				}
				$('.js_tbody_data').html(html);
				
				//分页处理
				var numfound = rst.numfound;
				var outObj = $('.js_page_part');
				$('.js_reply_data_source').val('replied');
				//console.log(numfound > 0 ,index>0,numfound,index)
				if(numfound > 0 && index>0){
					 outObj.show() 
					var currpage = rst.currpage; //当前页码
					var totalPage = rst.totalPage; //总页数
					var prev = rst.prev; //上一页
					var next = rst.next; //下一页
					
					outObj.find('.nowandall').html(currpage+'/'+totalPage);
					prev > 0 ? outObj.find('.prev').show().attr('data-page',prev) : outObj.find('.prev').hide();
					next > 0 ? outObj.find('.next').show().attr('data-page',next) : outObj.find('.next').hide();
					$('.js_custom_replyed_icon').html(numfound).show();
					$('.js_page_input').attr('totalpage',totalPage);
				}else{
					outObj.hide();
					$('.js_custom_replyed_icon').hide();
				}
			},
			getReplyedNum: function(){/*获取已经回复的数量*/
            	$.ajax({
             		 type: "get",
             		 url: gGetReplyList,
             		 data:   {'limit':1},
             		 async: true,
             		 dataType:'json',
             		 success: function(rst){
             			var numfound = rst.data.numfound;
             			if(numfound > 0){
             				$('.js_custom_replyed_icon').html(numfound).show();
             			}else{
             				$('.js_custom_replyed_icon').hide();
             			}
             		 }
              	}); 
			},
			/*定时设置已经回复、未回复数量*/
			setReplyCount: function(){
				setInterval(function(){
					var numfound = 0;
					for(var imid in $.custom.cache.noReply){
						numfound++;
					}
					var $numIcon = $('.js_custom_noreplyed_icon');
					if(numfound>0){						
						$numIcon.html(numfound).show();
						// 页面在未回复。 当有新的未回复进来， 将未回复页面刷新
						/*if (typeof($('#js_right_total').attr('imid')) != 'undefined' 
						 && $numIcon.closest('li').hasClass('active')) {
							$numIcon.closest('li').trigger('click');
						}*/
					}else{
						$numIcon.hide();
					}
				},1000);
			}
		}
	});
})(jQuery);

//排序函数参数
function sortAscNumber(a,b){
	return a-b;
}
function sortDescNumber(a,b){
	return b-a;
}