var ueColl;
var gSelHeight = 300;//下拉框高度定义
;(function($){
	$(function(){
		var scrollObj = $("#collLeftCate");
    	//if(!scrollObj.hasClass('mCustomScrollbar')){
    		scrollObj.mCustomScrollbar({
		        theme:"dark", //主题颜色
		        autoHideScrollbar: false, //是否自动隐藏滚动条
		        scrollInertia :0,//滚动延迟
		        horizontalScroll : false,//水平滚动条
		    });
    		
    		$("#industryList").mCustomScrollbar({
    	        theme: "dark", //主题颜色
    	        set_height:100,
    	        autoHideScrollbar: true, //是否自动隐藏滚动条
    	        scrollInertia: 0,//滚动延迟
    	        horizontalScroll: false,//水平滚动条
    	        callbacks: {
    	            onScroll: function () {
    	            }, //滚动完成后触发事件
//    	            onTotalScroll:function(){
//    	            	var pagestart = $('#industryList').attr('val');
//    	            	if(pagestart != 'no'){
//    	    	    		$.ajax({
//    	    	                cache: false,
//    	    	                type: "POST",
//    	    	                url: getChannel,
//    	    	                data: {start:pagestart},
//    	    	                async: false,
//    	    	                error: function (result) {
//    	    	                },
//    	    	                success: function (result) {
//    	    	                	var l = result.list.length;
//    	    	                	h = ''
//    	    	                	for(i=0;i<l;i++){
//    	    	                		h+= '<li title="test" val="'+result.list[i].id+'" id="'+result.list[i].id+'" class="hand">'+result.list[i].category+'</li>';
//    	    	                	    
//    	        	                }
//    	    	                	$('#industryList .mCSB_container').append(h);
//    	    	                	$('#industryList').attr('val',result.start);
//    	    	                }
//    	    	            });
//    	            	}
//    	        	}

    	        }
    	    });
    		
    		
    	if(typeof(gCurrCid) != 'undefined'){
    		$("#collLeftCate").mCustomScrollbar('scrollTo','#js_coll_'+gCurrCid);
    	}    	
	});
	$.fn.extend({
		selectPlug:function(opts){
			var defaultOpts = {
					getValId: '', /*【必填项】获取选中下拉框值的id,会自动生成一个隐藏的文本框，用户存放用户选择的值*/
					defaultVal:'', /*【可选】，用来设置下拉框默认显示值*/
					liValAttr: 'val', /*【可选】li标签上显示值的属性*/
					dataSet:[] /*【可选】下拉框数据,可以在页面模板中直接生成，也可以通过插件传入数组对象[{id:1,name:'abc'},{id:2,name:'zp'},...]*/
						};
			var opts = $.extend(true,{},defaultOpts,opts);
			var totalObj = this;
			var selectList = totalObj.children('ul');
			this.init = function(){
				this.bindEvt();
				this.initData();
			};
			//绑定事件
			this.bindEvt = function(){
				var that = this;
				totalObj.children('input').on('click',function(){
					totalObj = $(this).parent();
					selectList = $(this).nextAll('ul');
					that.operaSelect();
				});
				totalObj.find('i').on('click',function(){
					selectList = $(this).nextAll('ul');
					totalObj = $(this).parent();
					that.operaSelect();
				});
				totalObj.on('click','li',function(){
					totalObj = $(this).parents('.js_sel_public');
					selectList = $(this).parents('ul');
					that.setHideVal($(this));
				});
				//点击区域外关闭此下拉框
				$(document).on('click',function(e){
					if($(e.target).parents('.js_sel_public').length>0){
						var currUl = $(e.target).parents('.js_sel_public').find('ul');
						$('.js_sel_public>ul').not(currUl).hide()
					}else{
						$('.js_sel_public>ul').hide();
					}
				});
			}
			//把选中的ul>li中的值设置给input隐藏框
			this.setHideVal = function(obj){
				var that = this;
				if(typeof(obj) != 'undefined'){
					if(totalObj.find('#'+opts.getValId).length == 0){
						var html = '<input type="hidden" name="'+opts.getValId+'" id="'+opts.getValId+'" value="'+obj.attr(opts.liValAttr)+'"/>';
						totalObj.append(html);
					}else{
						totalObj.find('#'+opts.getValId).val(obj.attr(opts.liValAttr));
					}
					totalObj.find('input:eq(0)').val(obj.text()).attr('title',obj.text());
					that.operaSelect();
				}
			};
			//操作下拉框
			this.operaSelect = function(){
				if(selectList.is(':hidden')){
					selectList.show();
				}else{
					selectList.hide();
				}
			}
			//初始化默认数据(私有方法)
			this.initData = function(){
				//初始化下拉框数据
				if(opts.dataSet.length>0){
					var tmpHtml = '';
					$.each(opts.dataSet,function(i,data){
						tmpHtml += '<li '+opts.attr(opts.liValAttr)+'="'+data.id+'">'+data.name+'</li>';
					});
					totalObj.find('ul').html(tmpHtml);
				}
				if(totalObj.find('#'+opts.getValId).length == 0){
					var html = '<input type="hidden" name="'+opts.getValId+'" id="'+opts.getValId+'" value="'+opts.defaultVal+'" readonly="readonly"/>';
						totalObj.append(html);
				}else{
					totalObj.find('#'+opts.getValId).val(opts.defaultVal);
				}
				//刷新页面后设置下拉框默认值
				if(opts.defaultVal){
					var showVal = totalObj.find('li['+opts.liValAttr+'="'+opts.defaultVal+'"]').html();
					totalObj.find('input:eq(0)').val(showVal).attr('title',showVal);
				}
				//给下拉框添加滚动条
				var ulHeight = selectList.height();
				if(ulHeight>gSelHeight){
					selectList.height(gSelHeight);
			       	 //给列表添加滚动条
			    	if(!selectList.hasClass('mCustomScrollbar')){
			    		selectList.mCustomScrollbar({
					        theme:"dark", //主题颜色
					        autoHideScrollbar: false, //是否自动隐藏滚动条
					        scrollInertia :0,//滚动延迟
					        horizontalScroll : false,//水平滚动条
					    });
			    	}
				}
			}
			//取值（公有方法，供外界访问）
			this.getVal = function(){
				return totalObj.find('#'+opts.getValId).val();
			}				
			this.init();
			return this;
		}
	});
	$.extend({
		 //频道相关操作
		channel:{
			init: function(){
				//初始化列表的复选框插件
				window.gChannelCheckObj = $('.content_hieght').checkDialog({checkAllSelector:'#js_allselect',
					checkChildSelector:'.js_select',valAttr:'val',selectedClass:'active'});
				$.channel.initBindEvt();//初始化绑定事件
			},
			initBindEvt: function(){
				//分页跳转按钮
				/*$('#jumpPage').click(function(){
					var pageNum = $('#pageNum').val();
					channelIndexUrl = channelIndexUrl.replace('.html','');
					window.location.href = channelIndexUrl+'/p/'+pageNum;
					
					var obj = JSON.parse(reqP);
						obj.p = pageNum;
						channelIndexUrl = channelIndexUrl.replace('.html','');
						channelIndexUrl = channelIndexUrl + '/'+obj.join('/');
						window.location.href = channelIndexUrl;
				});*/
				//点击添加按钮，显示添加频道模板
		        $('#js_add_channel').click(function(){ 
		        	$('.js_channel_pop,.js_masklayer').show();
		        	$('#js_channel_pop_type').val('add');
		        	$('#js_chanel_name').val('');
		        	$('.js_channel_title').html(pop_title_add);
		         });
		        //弹出层确定按钮
				$('.js_btn_channel_ok').click(function(){
					$.channel.modifyChannel();
				});
				//弹出层取消按钮
				$('.js_btn_channel_cancel').click(function(){
					$('.js_channel_pop,.js_masklayer').hide();
				});
				//删除频道
				$('#js_del_channel').click(function(){
					$.channel.delChannel();
				});
			    //单项删除采集内容
				$('.js_single_del').click(function(){
					var id = $(this).parent().attr('data-id');
					$.channel.delChannel(id);
				});
				//编辑频道弹出层
				$('#js_edit_channel').click(function(){
					$.channel.showEditChannel();
				});
				//单项编辑弹出层(频道)
				$('.js_singe_edit').click(function(){
					var id = $(this).parent().attr('data-id');
					$.channel.showEditChannel(id);
				});
			},
			//显示编辑频道弹出层
			showEditChannel: function(id){
				if(typeof(id) == 'undefined'){
					var objs = window.gChannelCheckObj.getCheck();
					var len = objs.length;
					if(len != 1){
						$.global_msg.init({gType:'warning',icon:2,msg:gStrPleaseSelectData });
						return;
					}
					 id = objs[0];
				}				
				$('.js_channel_pop,.js_masklayer').show();
				$('#js_chanel_name').val($('.js_name_'+id).text());
				$('#js_channel_pop_type').val('modify').attr('dataid',id);
				$('.js_channel_title').html(pop_title_edit);
			},
			/**
			 * 添加/修改频道
			 */
			modifyChannel: function(){
				var name = $.trim($('#js_chanel_name').val());
				var len = $.getStrLen(name);
				if(len == 0){
					$.global_msg.init({gType:'warning',icon:2,msg:gStrChannelNameCannotEmpty });
					return;
				}else if(len > gChannelNameLen*2){
					$.global_msg.init({gType:'warning',icon:2,msg:channel_name_limit.replace('%d',gChannelNameLen)});
					return;
				}
				var data = {channelName:name};
				var type = $('#js_channel_pop_type').val();
				var url = id = '';
				
				if(type == 'add'){//添加操作
					url = channelAddUrl;
				}else if(type == 'modify'){//编辑操作
					url = channelEditOperaUrl;
					id = $('#js_channel_pop_type').attr('dataid');
					data.id = id;
				}else{
					console && console.error('opera error');
					return;
				}				
				$.ajax({
						data: data,
						url: url,
						type: 'POST',
						dataType: 'json',
						success: function(rst){
							if(rst.status == 0){
								if(type == 'modify'){
									window.gChannelCheckObj.noCheck();
									$('.js_name_'+id).html(name);
								}
								$('.js_channel_pop,.js_masklayer').hide();
								$('#js_chanel_name').val('');
							}
							var icon = rst.status == 0 ? 1:2;
							$.global_msg.init({gType:'warning',icon:icon,msg:rst.msg,
								endFn:function(){									
									if(rst.status == 0){
										if(type == 'modify'){
											window.gChannelCheckObj.noCheck();
											$('.js_name_'+id).html(name);
											$('#js_coll_'+id).find('a').html(name);
										}else{
											window.location.reload();
										}
									}
								}});
						},
						error: function(){}
					});
			},
			/**
			 * 删除频道
			 */
			delChannel: function(ids){
				var that = this;
				if(typeof(ids) == 'undefined'){
					if(window.gChannelCheckObj.getCheck().length == 0){
						$.global_msg.init({gType:'warning',icon:2,msg:gStrPleaseSelectData});
						return;
					}else{
						$.global_msg.init({gType:'confirm',icon:2,msg:gStrConfirmDelSelectData ,btns:true,close:true,
							title:false,btn1:gStrBtnCancel ,btn2:gStrBtnOk ,noFn:function(){
							var checkIdArr = window.gChannelCheckObj.getCheck();
						    ids = checkIdArr.join(',');
						    that.delChannelOpera(ids);
						}});
					}	
				}else{
					$.global_msg.init({gType:'confirm',icon:2,msg:gStrConfirmDelSelectData ,btns:true,close:true,
						title:false,btn1:gStrBtnCancel,btn2:gStrBtnOk,noFn:function(){
							that.delChannelOpera(ids);
					}});
				}
			},
			delChannelOpera: function(ids){
				var data = {id:ids};
				$.ajax({
						data: data,
						url: channelDelUrl,
						type: 'POST',
						dataType: 'json',
						success: function(rst){
							$.global_msg.init({gType:'warning',icon:1,msg:rst.msg,endFn:function(){
								if(rst.status == 0){
									window.location.href=window.location.href;
								}
							}});
						},
						error: function(){}
					});
			}
		},

		
		/**
		 * 采集内容相关操作
		 */
		collContent:{
			checkData:[],  //选中的数据
			checkDataIndex:0, //选中数据当前被执行的索引
			init: function(){
				//初始化列表的复选框插件
				window.gCollCheckObj = $('.content_hieght').checkDialog({checkAllSelector:'#js_allselect',
					checkChildSelector:'.js_select',valAttr:'val',selectedClass:'active'});
				this.initBindEvt();//初始化绑定事件
			},
			initBindEvt: function(){
				var that = this;
				var allObj = $('.js_coll_edit_publish');
				//分页跳转按钮
				/*$('#jumpPage').click(function(){
					var pageNum = $('#pageNum').val();
					var obj = JSON.parse(reqP);
					obj.p = pageNum;
					indexUrl = indexUrl.replace('.html','');
					indexUrl = indexUrl + '/'+obj.join('/');
					window.location.href = indexUrl;
				});*/
		        //弹出层确定按钮
				$('.js_btn_channel_ok').click(function(){
					$.channel.modifyCollContent();
				});
				//弹出层取消按钮
				$('.js_btn_channel_cancel').click(function(){
					$('.js_channel_pop,.js_masklayer').hide();
				});
				//删除采集内容
				$('#js_btn_del').click(function(){
					$.collContent.delCollContent();
				});
				//单项删除采集内容 --弹出层中
				$('.js_coll_del').click(function(){
					$.collContent.delCollContent( that.checkData[that.checkDataIndex]);
					that.checkDataIndex = that.checkDataIndex+1;
					var id = that.checkData[that.checkDataIndex];
					
				});
			    //单项删除采集内容
				$('.js_btn_opera_set').on('click','.js_single_del',function(){
					var id = $(this).parent().attr('data-id');
					$.collContent.delCollContent(id);
				});
			    //单项发布采集内容
				$('.js_btn_opera_set').on('click','.js_single_publish',function(){
					var id = $(this).parent().attr('data-id');
					$.collContent.publish(id);
				});
				//单项发布采集内容,弹出层中
				$('.js_coll_publish_content').click(function(){
					//that.checkDataIndex = that.checkDataIndex+1;
					//var id = that.checkData[that.checkDataIndex];
					$.collContent.publish(that.checkData[that.checkDataIndex]);
				});
				//编辑采集内容弹出层
				$('#js_btn_edit').click(function(){
					$.collContent.showEditCollContent();
				});
				//单个编辑采集内容
				$('.js_btn_opera_set').on('click','.js_single_edit',function(){
					var id = $(this).parent().attr('data-id');
					$.collContent.showEditCollContent(id);
				});
				//预览采集内容(批量操作)
				$('#js_btn_preview').click(function(){
					//var objs = that.valid(2);
					//if(objs){
					var objs = window.gCollCheckObj.getCheck();
					//没有选中的情况下，预览整个页面中的数据
					if(objs.length == 0){
						var tmpArr = [];
						var allDoms = $('.js_select');
						$.each(allDoms,function(){
							var obj = $(this);
							tmpArr.push(obj.attr('val'));
						});
						objs = tmpArr;
					}
					that.checkData      = objs;
					that.checkDataIndex = 0;
					$.collContent.preview(objs[0]);
					//}					
				});
				//预览下一个内容 ...
				$('#js_btn_preview_next_coll').click(function(){
					if(that.checkDataIndex+1 > that.checkData.length-1){
						$.global_msg.init({gType:'warning',icon:2,msg:gStrNoHasNext });
					}else{
						that.checkDataIndex = that.checkDataIndex+1;
						var id = that.checkData[that.checkDataIndex];
						$.collContent.preview(id);
					}
				});
				//预览上一个内容
				$('#js_btn_preview_prev_coll').click(function(){
					if(that.checkDataIndex-1 < 0){
						$.global_msg.init({gType:'warning',icon:2,msg:gStrNoHasPrev });
					}else{
						that.checkDataIndex = that.checkDataIndex-1;
						var id = that.checkData[that.checkDataIndex];
						$.collContent.preview(id);
					}	
				});
				//批量发布
				$('#js_btn_publish').click(function(){
					$.collContent.publish();
				});
				//根据列名排序
				$('.js_coll_sort').click(function(){
					var obj = $(this);
					$.collContent.sort(obj);
				});
			
				//编辑时上传文件
				allObj.on('change','#collEditUpload',function(){
					that.collTitlePicUpload();
				});
				//编辑时正文上传内容
				allObj.on('change','#uploadImgField',function(){
					$.collContent.uploadFile();
				});
				//编辑后发布到审核
				allObj.on('click','.js_coll_publish_check', function(){
					if(!$(this).hasClass('clicking')){
						$(this).addClass('clicking');
						that.publishGetData();
					}

					return false;
				});				
			},
			//获取编辑后的取值数据
			publishGetData: function(){
				var that = this;
				var allObj 	= $('.js_coll_edit_publish');
				var newsid 	= allObj.attr('data-id');
				var title  = $.trim(allObj.find('.coll_edit_title').val());
				var image = $.trim(allObj.find('#js_coll_file_path').val());
				var keyword = allObj.find('.coll_edit_keyword').val();
				var category = $.trim(allObj.find('#js_coll_catebtn_val').val()); //行业
				var webfrom = allObj.find('.coll_edit_source').val();
				var js_begintime_coll = allObj.find('.js_begintime_coll').val();
				//var content  = allObj.find('.js_content').find('.mCSB_container').html();
			//	var content  = $.trim(allObj.find('.js_content').html());
				var content = ue.getContent(); //编辑器插件获取内容
				if(!title){
					$('.js_coll_publish_check').removeClass('clicking');
					$.global_msg.init({gType:'warning',icon:2,msg:gStrTitleCannotEmpty ,time:3});
					return;
				}
				/*if(!image){
					$.global_msg.init({gType:'warning',icon:2,msg:gStrTitleImageCannotEmpty ,time:3});
					return;
				}*/
				if(!category){
					//console.log(category);
					$('.js_coll_publish_check').removeClass('clicking');
					$.global_msg.init({gType:'warning',icon:2,msg:gStrIndustryCannotEmpty ,time:3});
					return;
				}
			/*	if(!webfrom){
					$.global_msg.init({gType:'warning',icon:2,msg:gStrCollSourceNotEmpty ,time:3});
					return;
				}*/
				if(!content || content== '<br>' || content== '<br/>'){
					$('.js_coll_publish_check').removeClass('clicking');
					$.global_msg.init({gType:'warning',icon:2,msg:gStrCollContentNotEmpty ,time:3});
					return;
				}
				/*isfilter 是否过滤敏感词  0 过滤 1不过滤*/
				var data = {
							id: newsid,
							title: title,
							image: image,
							keyword: keyword,
							category: category,
							webfrom: webfrom,
							publishDate:js_begintime_coll,
							content: content,
							type: 'edit',
							isfilter:0
							};
				
				that.publishData(data);
			},
			collTitlePicUpload: function(){
				var allObj = $('.js_coll_edit_publish');
				var fileNameHid =  allObj.find('#colluploadpic').val();
			 	$.ajaxFileUpload({
		 			url : gUrlUploadFile,
		 			secureuri: false,
		 			fileElementId: fileNameHid,
		 			data:{fileNameHid:fileNameHid},
		 			dataType: 'json',
		 			success: function (rtn, status){
		 				var imgUrl = rtn.data.absolutePath;
		 				allObj.find('#js_coll_file_path').val(imgUrl);		
		 			},
		 			error: function (data, status, e){
		 				 console && console.info(data,status,e);
		 			}    			
		 		});			
			},
			//点击列名进行排序
			sort:  function(obj){
				var sort = obj.find('em').attr('sort');
				//var currUrl = window.location.href.replace('.html','');
				//window.location.href = currUrl+'/column/'+column+'/sort/'+sort; 
				indexUrl = indexUrl.replace('.html','');
				window.location.href = indexUrl+'/sort/'+sort+'/cid/'+gCurrCid;
			},
			//验证是否选中数据项了
			valid: function(defaulLen){
				defaulLen = defaulLen || 1;
				var that = this;
				var objs = window.gCollCheckObj.getCheck();
				var len = objs.length;
				that.checkData      = objs;
				that.checkDataIndex = 0;
				if(defaulLen == 1 && len != defaulLen){
					$.global_msg.init({gType:'warning',icon:2,msg:gStrPleaseSelectData});
					return false;
				}else if(defaulLen == 2 && len < 1){
					$.global_msg.init({gType:'warning',icon:2,msg:gStrPleaseSelectData});
					return false;
				}else{
					return objs;
				}
			},
			//预览采集内容
			preview: function(id){
				var that = this;
				var data = {id:id}
				$.get(gGetDataUrl,data,function(rst){
					rst = rst.data;
					$('.js_btn_coll_preview,.js_masklayer').show();
					that.previewGeneralPage(rst);
				},'json');
			},
			//预览页面值替换
			previewGeneralPage: function(rst){
				var allObj = $('.js_btn_coll_preview');		
					if(rst.image){
						allObj.find('.js_title_img').parent().show();
						allObj.find('.js_title_img').attr('src',rst.image);
					}else{
						allObj.find('.js_title_img').parent().hide();
					}					
					allObj.find('.js_title').html(rst.title);
					allObj.find('.js_source').html(rst.webfrom);
					allObj.find('.js_time').html(rst.createdtime);
					allObj.find('.js_content').html(rst.content);
					
					//关闭弹出层
					allObj.find('.js_btn_close').click(function(){
						allObj.hide();
						$('.js_masklayer').hide();
					});
					//滚动条
					var scrollObj = allObj.find('.js_coll_preview_scroll');
	 		    	if(!scrollObj.hasClass('mCustomScrollbar')){
	 		    		scrollObj.mCustomScrollbar({
	 				        theme:"dark", //主题颜色
	 				        autoHideScrollbar: false, //是否自动隐藏滚动条
	 				        scrollInertia :0,//滚动延迟
	 				        horizontalScroll : false,//水平滚动条
	 				    });
	 		    	}
			},			
			//显示编辑采集内容弹出层
			showEditCollContent: function(id){
				var that = this;
				var objs = [];
				if(typeof(id) == 'undefined'){
					 objs = this.valid();
				}else{
					objs.push(id);
				}				
				if(objs && objs.length>0){
					var id = objs[0];
					var data = {id:id}
					$.get(gGetDataUrl,data,function(rst){
						that.initCollEditData(rst);
						
					},'json');
				}
			},
			//初始化采集编辑数据
			initCollEditData: function(rst){
				var that = this;
				var data = rst.data;
				var allObj = $('.js_coll_edit_publish');
				allObj.show();
				$('.js_masklayer').show();
				allObj.attr('data-id',data.newsid);
				allObj.find('.coll_edit_title').val(data.title); //标题
				allObj.find('#js_coll_file_path').val(data.image); //标题图片
				allObj.find('.coll_edit_keyword').val(data.keyword); //关键字
				allObj.find('.js_begintime_coll').val(data.publishDate); //发布时间
				allObj.find('.coll_edit_source').val(data.webfrom); //来源
				allObj.find('.js_coll_cate_list').val(data.category); //所属行业
				allObj.find('.js_coll_catebtn_show').val('');//行业名称data.categoryname
				allObj.find('#js_coll_catebtn_val').val('');//行业值：data.categoryid
				var content = data.content;
				if(!content){
					content  = ' ';
				}else{
					content += '<br/>';
				}
				allObj.find('.js_btn_close').click(function(){
					if(allObj.find('.js_coll_cate_list').is(":visible")){
						allObj.find('.js_coll_cate_list').hide();
					}
					allObj.hide();
					$('.js_masklayer').hide();
				});
				//频道下拉点击事件
				allObj.find('#js_coll_catebtn_show,#js_seltitle').off('click').on('click',function(){
					var cateObj = allObj.find('.js_coll_cate_list');
					cateObj.toggle();
				});						
				//采集内容上传图片
				/*
				allObj.find('.js_upload_img').off('click').on('click',function(){
					allObj.find('#uploadImgField').click();
				});*/				
				
				//添加滚动条
				/*var scrollObj = $(".js_coll_edit_publish .js_content");
 		    	if(!scrollObj.hasClass('mCustomScrollbar')){
 		    		scrollObj.mCustomScrollbar({
 				        theme:"dark", //主题颜色
 				        autoHideScrollbar: false, //是否自动隐藏滚动条
 				        scrollInertia :0,//滚动延迟
 				        horizontalScroll : false,//水平滚动条
 				    });
 		    	}*/
 		    	//var contentObj = $(".js_coll_edit_publish .js_content").find('.mCSB_container');
 		  /*  	var contentObj = $(".js_coll_edit_publish .js_content");
 		    		contentObj.attr("contentEditable", "true"); 		    		
 		    		contentObj.html(content);*/
 		    		
				if($('#edui1').length == 0){  //判断是否已经初始化编辑器  如果没有就初始化
						baidu.editor.commands['audio'] = {
							execCommand : function() {
								var _this=this;
								$('#audio_file').remove();
								var $file=$("<input type='file' id='audio_file' name='tmpFile' style='display:none;'>");
								$file.on('change', function(){
									var $obj=$(this);
									var val = $obj.val();
									var names=val.split(".");
									var allowedExtentionNames = ['mp3'];
									if($.inArray(names[1], allowedExtentionNames)==-1){
										//$.global_msg.init({msg:TIP_WRONG_IMG, btns:true});
										$.global_msg.init({gType:'warning',msg:'音频格式不正确',icon:2});
										return;
									}

									$.ajaxFileUpload({
										url:URL_UPLOAD,
										secureuri:false,
										fileElementId:$obj.attr('id'),
										data : {exts:'mp3'},
										dataType: 'json',
										success: function (data, status){
											_this.execCommand('insertHtml',"<img audio='"+data.url+"' src='"+URL_AUDIO_IMG+"'>");
										},
										error: function (data, status, e){
											console.log(e);
											$.global_msg.init({gType:'warning',msg:'添加音频失败',icon:2});
										}
									});
								});
								$('body').append($file);
								setTimeout(function(){
									$('#audio_file').click();
								}, 100);
								return true;
							},
							queryCommandState : function(){

							}
						};
						ue = UE.getEditor('js_content_coll', {
							toolbars: [
								['simpleupload','fontsize','fontfamily','link', 'unlink','bold','italic',
									'underline', 'strikethrough', 'superscript', 'subscript',
									'removeformat','justifyleft', 'justifycenter','justifyright','audio'
								]
							],
							wordCount: false,
							elementPathEnabled: false,
							autoHeightEnabled: false,
							fontfamily:[{
								label: 'arial',
								name: 'arial',
								val: 'arial, helvetica,sans-serif'
							},{
								label: 'verdana',
								name: 'verdana',
								val: 'verdana'
							},{
								label: 'georgia',
								name: 'georgia',
								val: 'georgia'
							},{
								label: 'tahoma',
								name: 'tahoma',
								val: 'tahoma'
							},{
								label: 'timesNewRoman',
								name: 'timesNewRoman',
								val: 'times new roman'
							},{
								label: 'trebuchet MS',
								name: 'trebuchet MS',
								val: 'Trebuchet MS'
							},{
								label: '宋体',
								name: 'songti',
								val: '宋体,SimSun'
							},{
								label: '黑体',
								name: 'heiti',
								val: '黑体, SimHei'
							},{
								label: '楷体',
								name: 'kaiti',
								val: '楷体,楷体_GB2312, SimKai'
							},{
								label: '仿宋',
								name: 'fangsong',
								val: '仿宋, SimFang'
							},{
								label: '隶书',
								name: 'lishu',
								val: '隶书, SimLi'
							},{
								label: '微软雅黑',
								name: 'yahei',
								val: '微软雅黑,Microsoft YaHei'
							}],
							contextMenu: [],
							iframeCssUrl: JS_PUBLIC + '/js/jsExtend/ueditor/themes/review.css',
							initialFrameWidth: 706,//设置编辑器宽度
							initialFrameHeight: 330//设置编辑器高度
						});

				}else{
 	                	 ue.setContent(content);
				}
				ue.addListener('ready', function (editor) {
					ue.execCommand('pasteplain'); //设置编辑器只能粘贴文本
					ue.setHeight(330);
					ue.setContent(content);
					setInterval(function () {
						var offset = $('.edui-for-audio .edui-icon').offset();
						$('#audio_file').css('top', offset.top);
						$('#audio_file').css('left', offset.left);
					}, 100);
				});

 		    	//行业分类列表数据初始化
 		    	that.initChannelSelect();
 		    		
			},
			//初始化频道下拉框数据
			initChannelSelect: function(){ //频道改为行业列表
			/*	var str = '';
				var len = gChannelSelectData.length;
				var tmpObj = null;
				for(var i=0;i<len;i++){
					tmpObj = gChannelSelectData[i];
					str += '<li data-id="'+tmpObj.id+'" class="hand">'+tmpObj.category+'</li>';
				}
				$('.js_coll_cate_list').html(str);*/
				var scrollObj = $('.js_coll_cate_list');
				if(!scrollObj.hasClass('mCustomScrollbar')){
 		    		scrollObj.mCustomScrollbar({
 				        theme:"dark", //主题颜色
 				        autoHideScrollbar: false, //是否自动隐藏滚动条
 				        scrollInertia :0,//滚动延迟
 				        horizontalScroll : false,//水平滚动条
 				    });
 		    	}
				$('.js_coll_cate_list li').click(function(){
					var obj = $(this);
					$('#js_coll_catebtn_show').val(obj.html());
					$('#js_coll_catebtn_val').val(obj.attr('data-id'));
					$('.js_coll_cate_list').hide();
				});
				$(document).click(function(e){
					if($(e.target).attr('id') == 'js_coll_catebtn_show'){
						return;
					}
					if($('.js_coll_cate_list').is(":visible")){
						$('.js_coll_cate_list').hide();
					}
				});
			},
			//上传图片
			uploadFile: function(){
				var fileNameHid = $('#uploadpic').val();;
			 	$.ajaxFileUpload({
		 			url : gUrlUploadFile,
		 			secureuri: false,
		 			fileElementId: fileNameHid,
		 			data:{fileNameHid:fileNameHid},
		 			dataType: 'json',
		 			success: function (rtn, status){
		 				var imgUrl = rtn.data.absolutePath;
		 				var allObj = $('.js_coll_edit_publish');
		 				//var content = allObj.find('.mCSB_container').html();
		 				//var content = allObj.find('.js_content').html();
		 				var content =  '<img src="'+imgUrl+'"/><br/>';
                        //将图片插入到光标显示位置
		 				allObj.find('.js_content').focus();
                        insertHtmlAtCaret(content)
		 				//allObj.find('.mCSB_container').html(content);
		 				//allObj.find('.js_content').html(content);
		 				var scrollObj = $(".js_coll_edit_publish .js_content");
		 		    	/*if(!scrollObj.hasClass('mCustomScrollbar')){
		 		    		scrollObj.mCustomScrollbar({
		 				        theme:"dark", //主题颜色
		 				        autoHideScrollbar: false, //是否自动隐藏滚动条
		 				        scrollInertia :0,//滚动延迟
		 				        horizontalScroll : false,//水平滚动条
		 				    });
		 		    	}else{
		 		    		//$(".js_coll_edit_publish .js_content").find('.mCSB_container').
		 		    	}*/
		 		    	//$(".js_coll_edit_publish .js_content").find('.mCSB_container').attr("contentEditable", "true");
		 				$(".js_coll_edit_publish .js_content").attr("contentEditable", "true");
		 			},
		 			error: function (data, status, e){
		 				 console && console.info(data,status,e);
		 			}    			
		 		});
			},
			/**
			 * 编辑采集内容
			 */
			modifyCollection: function(){
				var name = $('#js_chanel_name').val();
				if($.getStrLen(name) > gChannelNameLen*2){
					$.global_msg.init({gType:'warning',icon:2,msg:channel_name_limit.replace('%d',gChannelNameLen)});
					return;
				}
				var data = {channelName:name}
				var type = $('#js_channel_pop_type').val();
				var url = id = '';
				
				if(type == 'add'){//添加操作
					url = channelAddUrl;
				}else if(type == 'modify'){//编辑操作
					url = channelEditOperaUrl;
					id = $('#js_channel_pop_type').attr('dataid');
					data.id = id;
				}else{
					console && console.error('opera error');
					return;
				}
				
				$.ajax({
						data: data,
						url: url,
						type: 'POST',
						dataType: 'json',
						success: function(rst){
							$.global_msg.init({
								msg : rst.msg,
								btns : true,
								icons: 1
							});
							$('.js_channel_pop,.js_masklayer').hide();
							$('#js_chanel_name').val('');
							if(rst.status == 0){
								if(type == 'modify'){
									$('.js_name_'+id).html(name);
								}else{
									window.location.reload();
								}
							}
						},
						error: function(){}
					});
			},
			/**
			 * 删除采集内容
			 */
			delCollContent: function(id){
				var that = this;
				if(typeof(id) == 'undefined'){
					if(window.gCollCheckObj.getCheck().length == 0){
						$.global_msg.init({gType:'warning',icon:2,msg:gStrPleaseSelectData});
						return;
					}else{
						var checkIdArr = window.gCollCheckObj.getCheck();
						id = checkIdArr.join(',');
					}
				}
				$.global_msg.init({gType:'confirm',icon:2,msg:gStrConfirmDelSelectData ,btns:true,close:true,
					title:false,btn1:gStrBtnCancel ,btn2:gStrBtnOk ,noFn:function(){
						that.delCollContentOpera(id);
				}});
			},
			//删除采集内容的执行后端操作方法
			delCollContentOpera: function(id){
				var that = this;
				var data = {id:id};
				$.ajax({
						data: data,
						url: gDelUrl,
						type: 'POST',
						dataType: 'json',
						success: function(rst){
							$.global_msg.init({gType:'warning',icon:2,msg:rst.msg,endFn:function(){
								if(rst.status == 0){
									//弹出层中删除成功后，自动预览下一篇文章
									if($('.js_btn_coll_preview').is(':visible') &&  (that.checkDataIndex<=that.checkData.length-1)){
										$('.span_span8[data-id="'+id+'"]').parent().remove();
										delete that.checkData[that.checkDataIndex-1];
										var tmpArr = that.checkData;
										var j=0;
										for(var i=0;i<that.checkData.length; i++){
											if(typeof(that.checkData[i]) != 'undefined'){
												tmpArr[j] = that.checkData[i];
												j++;
											}else{
												that.checkDataIndex = that.checkDataIndex-1;
											}											
										}
										that.checkData = tmpArr;
										$.collContent.preview(that.checkData[that.checkDataIndex]);
									}else{
										window.location.reload();
									}									
								}
							}});
						},
						error: function(){}
					});
			},
			/**
			 * 发布采集内容
			 */
			publish: function(ids){
				var that  = this;
				if(typeof(ids) == 'undefined'){
					if(window.gCollCheckObj.getCheck().length == 0){
						$.global_msg.init({gType:'warning',icon:2,msg:gStrPleaseSelectData});
						return;
					}else{
						var checkIdArr = window.gCollCheckObj.getCheck();
						 ids = checkIdArr.join(',');
					}	
				}			
				var data = {id:ids};
				that.publishData(data);
			},
			publishData: function(data){
				$.ajax({
					data: data,
					url: gPublishUrl,
					type: 'post',
					dataType: 'json',
					success: function(rst){
							if(rst.status == 0){

                                    $.global_msg.init({
                                        gType: 'warning',
                                        msg: rst.msg,
                                        icon: 1,
                                        endFn: function () {

                                            location.reload();
                                        }});
								
							}else if('1' == rst.status){
								$('.js_coll_publish_check').removeClass('clicking');
		                        var where = '内容';
		                        if(rst.type == 'title'){
		                            where = '标题';
		                        }
		                        $.global_msg.init({
		                            gType: 'confirm', icon: 2, msg:where+'中有敏感词['+rst.word + '],确认提交吗？', btns: true, close: true,
		                            title: false, btn1: gStrBtnCancel, btn2: gStrBtnOk,
									noFn: function () {
		                            	data.isfilter = 1;
		                                $.post(gPublishUrl, data, function (rst2) {
		                                	$.global_msg.init({	msg : rst2.msg,gType : 'warning',icon: 1,
		            							endFn:function(){
													if($('.js_btn_coll_preview').is(':visible')){
														var thisObj = $('span[data-id="'+data.id+'"]');
														thisObj.parent().find('.js_label_public_text').html(gPublished);
														thisObj.html('<i class="hand js_single_edit">编辑</i>|<em class="hand js_single_del">删除</em>');
													}else{
														location.reload();
													}
		            							}
		            						});
		                                })
		                            },endFn:function(){
										var words = rst['word'].split(',');
										var tmpContent = data.content;
										for ( var i in words) {
											var reg = new RegExp(words[i], "mg");
											tmpContent = tmpContent.replace(reg, '<span style="color:red;">' + words[i] + '</span>');

										}
										ue.setContent(tmpContent);
		                            }
		                        });
		                    }else{
								$('.js_coll_publish_check').removeClass('clicking');
                                $.global_msg.init({
                                    gType: 'warning',
                                    msg: rst.msg,
                                    icon: 1,
                                    endFn: function () {
                                        location.reload();
                                    }});
		                    }
						},
					error: function(){}
				});
			}
		},
		

		/**
		 * 获取字符串长度 包含中文处理(一个中文按照两个英文字母计算)
		 * (参数说明：原字符串)
		 * demo: getStrLen('我收中国人abc他');输出为：15
		 */
		getStrLen:function(str){
		  if(!str)return 0;
		  var chineseRegex = /[^\x00-\xff]/g;
		  var strLength = str.replace(chineseRegex, "**").length;
		  return strLength;
		}
	});
})(jQuery);

//实时获取内容的光标位置
/*var gRange;
$('.js_content').on('focus',function(){
	var sel;
	setInterval(function(){
		 if (window.getSelection) {
			sel = window.getSelection();
			try{
				if (sel.anchorNode.parentNode.className!='js_content'){
					return;
				}
		        if (sel.getRangeAt && sel.rangeCount) {
		        	gRange = sel.getRangeAt(0);
		        	//gRange.deleteContents();
		        }	
			} catch(e){
				return;
			}
		 }
	},100);
}).focus();*/

//可编辑的div中获取光标位置
function insertHtmlAtCaret(html) {
    var sel, range;
    if (window.getSelection) {
        // IE9 and non-IE
        sel = window.getSelection();
        if (sel.getRangeAt && sel.rangeCount) {
            range = sel.getRangeAt(0);
            range.deleteContents();
            //if (gRange){
            	//range = gRange;
           // }
            // Range.createContextualFragment() would be useful here but is
            // non-standard and not supported in all browsers (IE9, for one)
            var el = document.createElement("div");
            el.innerHTML = html;
            var frag = document.createDocumentFragment(), node, lastNode;
            while ( (node = el.firstChild) ) {
                lastNode = frag.appendChild(node);
            }
            range.insertNode(frag);
            // Preserve the selection
            if (lastNode) {
                range = range.cloneRange();
                range.setStartAfter(lastNode);
                range.collapse(true);
                sel.removeAllRanges();
                sel.addRange(range);
            }
        }
    } else if (document.selection && document.selection.type != "Control") {
        // IE < 9
        document.selection.createRange().pasteHTML(html);
    }
}
