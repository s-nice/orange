;(function($){
	$.extend({
		contactsRec:{
			/*人脉推荐首页*/
			listIndex:{
				init: function(){
					this.bindEvt();
					$.dataTimeLoad.init({idArr: [{start:'js_begintime',end:'js_endtime'}]});//日历插件
				},
				bindEvt: function(){/*绑定事件*/
					$('#js_btn_add').click(function(){/*列表中点击人脉推荐按钮触发*/
						window.location.href = gUrlAddIndex;
					});
				}
			},
			
			/*添加推荐功能首页*/
			addIndex:{
				init: function(){
					this.sle_url = gUrlGetRecedList;
					this.bindEvt();
				},
				bindEvt: function(){
					var that = this;
					//模板中取消按钮
					$('#js_btn_cancel').click(function(){
						window.location.href = gUrlContactsIndex;
					});
					//添加模板中的确定按钮
					$('.js_add_form_total').on('click','#js_btn_ok',function(){
						var title 	= $.trim($('#title').val());
						var recedListHide = $.trim($('#recedListHide').val());
						var recListHide = $.trim($('#recListHide').val());
						if(!title){
							return $.global_msg.init({msg : str_cr_enter_title,btns : true,icons: 2}); //请输入标题
						}
						if(!recedListHide){
							return $.global_msg.init({msg : str_cr_choose_recom_person,btns : true,icons: 2}); //请选择被推荐人
						}
						if(!recListHide){
							return $.global_msg.init({msg : str_cr_choose_recom_vcard,btns : true,icons: 2}); //请选择推荐人脉
						}
						var data = {title:title, reced:recedListHide, rec:recListHide};
						$.post(gUrlAddContacts,data,function(rtn){
							if(rtn.status == 0){
		                        $.global_msg.init({
		                            gType: 'confirm', icon: 1, msg:str_cr_recom_succ_tips, btns: true, close: true,
		                            title: false, btn1: str_cr_add_btn_continue, btn2: str_cr_add_btn_ok, fn: function () { //gStrBtnCancel gStrBtnOk //推荐成功，点击继续将接着推荐，确认将返回推荐首页   继续  确认
		                            	window.location.href = window.location.href; 
		                            },noFn: function(){ window.location.href = gUrlContactsIndex;}
		                        });
							}else{
								$.global_msg.init({msg : str_cr_recom_fail_tips,btns : true,icons: 2}); //推荐失败
							}
						},'json');
					});
					//点击显示被推荐人弹出层 、点击显示推荐人列表
					$('.js_add_form_total').on('click','#recedList,#recList',function(evt){
						  var _this = $(this);
						  var source = $(this).attr('data-type');
						  if(!window.isOpenningPop1){
							  window.isOpenningPop1 = true;
			                  $.get(gUrlGetRecedList,{source:source},function(res){
			                        that.layer_html(1,res.tpl,820,630);
			                        that.setActive(true);		
			                        window.isOpenningPop1 = false;
			                        that.showPageTpl(gUrlGetRecedList,{source:source});
			                    });
			                  setTimeout(function(){/*15秒后修改变量，使按钮可点击*/
			                	  window.isOpenningPop1 = false;
			                  },15000);
						  }else{
							  $.global_msg.init({msg : str_cr_recom_open_pop_waitting,btns : true,icons: 2});//系统正在为您打开弹出层，请稍候再点击
						  }		                  	  
					});
					$('#layer_div').on('blur','#search_word',function(){
						if($('#kwdType').val() == '1'){
							var mobile = $.trim($(this).val());
							if(mobile){
								var flag = mobile.isMobile();
								if(!flag){
									$.global_msg.init({msg : str_cr_mobile_format_tips,btns : true,icons: 2}); //用户ID格式错误，必须为完整的手机号格式
								}
							}
						}
					});
	                //关闭一次弹出层弹框
	                $('#layer_div').on('click','.js_add_list_cancel',function(){//,.js_add_list_sub
	                	$.contactsRec.popLevelTwo.clearCache(); //清空二次弹出层中的html缓存
	                    layer.close(that.layer_div);
	                });;
	                //搜索     (点击搜索按钮)  
	                $('#layer_div').on('click','.js_btn_search',function(){
	                	var region = '';
	                    var kwdType = $('#kwdType').val();
	                    var kwd = $('#search_word').val();
	                    var source = $('#dataSourceId').val();
	                    var region = $('#region').attr('hideVal'); //地区传递给sql使用的
	                    var regionShow = $('#region').val();
	                    var industryShow = $('#industry').val();
	                    var industry = $('#industry').attr('hideVal');
	                    var positionShow = $('#position').val();
	                    var position = $('#position').attr('hideVal');
	                    var title = $('#usertitle').val();
	                    var dataSourceId = $('#dataSourceId').val();
	                    var data = {kwdType:kwdType,kwd:kwd,source:source,regionShow:regionShow,
	                    		region:region,industry:industry, industryShow:industryShow};
	                    if(dataSourceId == 'recListHide'){//名片列表
	                    	//regionTrans = $('#region').attr('hideVal');
	                    	data.position     = position;
	                    	data.positionShow = positionShow;
	                    	data.isRegister = $('#isNotRegistUser').prop('checked');
	                    	data.isNotShare = $('#isNotSharedCard').prop('checked');
	                    }else if(dataSourceId == 'recedListHide'){//用户列表
	                    	//regionTrans = $('#region').attr('hideRelName');
	                    	data.title = title;
	                    }
	                  //  data.regionTrans = regionTrans;
	                    that.getInPopPage(gUrlGetRecedList,data);
	                });
	                //弹出层点击翻页
	                $('#layer_div').on('click','a[href]',function(e){
	                    var href=$(this).attr('href');
	                    //阻止a标签跳转，使用ajax
	                    that.getInPopPage(href,{});
	                    return false;
	                })
	                //弹出层输入页数跳转
	                $('#layer_div').on('click','form>input[type=submit]',function(){
	                    var p = $(this).prev().val();
	                    if(isNaN(p) || p<1){
	                    	p = 1;
	                    }
	                    if(p){
	                    	var totalPage = parseInt($(this).prev().attr('totalpage'));
	                    	p = parseInt(p);
	                    	totalPage<p ? (p = totalPage) : null;
	                        var url = $(this).parents('form').attr('action');
	                        that.getInPopPage(url,{p:p});
	                    }
	                    return false;
	                });
	                 //企业日期排序
	                $('#layer_div').on('click','#js_reg_date',function(){
	                    var sort = $(this).hasClass('list_sort_asc')?'desc':'asc';
	                    var obj = $.extend(that.sle_obj,{sort:sort});
	                    that.getInPopPage(that.sle_url,obj);
	                });
	                //选择人脉复选框后，点击确认按钮
	                $('#layer_div').on('click','#js_btn_add_confirm',function(){
	                	var dataSourceId = $('#dataSourceId').val();
	                	var hideObj = $('#'+dataSourceId);
	                	var checkStr  = $('#'+dataSourceId).attr('tmpval');
	                	if(checkStr){
	                		var checkArr = checkStr.split(',');
	                		if(checkArr.length<=99){
	                			hideObj.val(checkStr);
			                    that.genChooseEleList(dataSourceId, hideObj.attr('tmpname')); //生成选中用户或名片列表
			                	layer.close(that.layer_div);
			                	$.contactsRec.popLevelTwo.clearCache(); //清空二次弹出层中的html缓存
	                		}else{
	                			$.global_msg.init({msg : str_cr_max_recom_person_num, btns : true,icons: 2}); //一次最多能选择99用户
	                		}
	                	}else{
	                		$.global_msg.init({msg : str_cr_please_choose_recom_person,btns : true,icons: 2}); //请先选择推荐人
	                	}
	                });
	                //新增人脉页面中,点击x后，删除元素
	                $('.js_selected_items').on('click','.js_remove',function(){
	                	var obj = $(this);
	                	var dataSourceId = obj.parent().parent().attr('dataSource'); //获类型，是存放用户的还是存放名片的
	                	var id = obj.attr('data-id');
	                	var val = obj.attr('data-val');
	                	var regId = new RegExp(id+"[,]{0,1}",'g');//id的正则表达式
	                	var regName = new RegExp(val+"[,]{0,1}",'g');//名字的正则表达式
	                	var oldStr = $('#'+dataSourceId).val();
	                		oldStr = oldStr.replace(regId,'').replace(/([,]{0,1}$)/g,"");
	                	var oldNameStr = $('#'+dataSourceId).attr('tmpName'); //增加显示名称
	                		oldNameStr = oldNameStr.replace(regName,'').replace(/([,]{0,1}$)/g,"");//增加显示名称
	                	$('#'+dataSourceId).val(oldStr).attr({'tmpval':oldStr,'tmpname':oldNameStr});
	                	obj.parent().remove(); //删除当前元素
	                });
					//初始化列表的复选框插件
					window.gChannelCheckObj = $('#layer_div').checkDialog({checkAllSelector:'#js_allselect',
						checkChildSelector:'.js_select',valAttr:'val',selectedClass:'active',clickFn:$.contactsRec.addIndex.checkCall});
					setInterval($.contactsRec.addIndex.setIntervalTime,1000); //定时检测确定按钮
				},
				//定时检查确定按钮
				setIntervalTime: function(){
					  var hideObjs = $('#recedListHide,#recListHide');
					  $.each(hideObjs,function(i,dom){
						  var hideObj = $(dom);
					  	  if(hideObj.attr('tmpname') == undefined){
						  		hideObj.val('').attr('tmpval','');
						  	  }/*else{
						  		  hideObj.attr('tmpval',hideObj.val());
						  	}*/
					  });

					var $flag = true;
					var title 	= $.trim($('#title').val());
					var recedListHide = $.trim($('#recedListHide').val());
					var recListHide = $.trim($('#recListHide').val());
					if(!title || !recedListHide || !recListHide){
						$flag = false;
					}
					if(!$flag){
						$('input[name="js_btn_ok"]').addClass('button_disabel').removeAttr('id','js_btn_ok');
					}else{
						$('input[name="js_btn_ok"]').removeClass('button_disabel').attr('id','js_btn_ok');
					}
				},
				genChooseEleList: function(dataSourceId,namedata){/*点击弹出层的确认按钮后在添加页面生成选中用户或名片列表*/
					var nameArr = namedata.split(',');
					var childHtml = '';
					$.each(nameArr,function(i,val){
						var arr = val.split('#&');
						childHtml += '<span class="js_contact_ele" >'+arr[1]+'<em class="hand js_remove" data-id="'+arr[0]+'" data-val="'+val+'">x</em></span>';
					});
					 $('.js_selected_items[dataSource="'+dataSourceId+'"').html(childHtml);
				},
				/*复选框点击回调函数,获取选中的子元素数据*/
				checkCall: function(obj){
					var dataSourceId = $('#dataSourceId').val();
                	var oldStr = $('#'+dataSourceId).attr('tmpval');
                	var oldNameStr = $('#'+dataSourceId).attr('tmpName'); //增加显示名称
					obj.each(function(){
						var obj = $(this);
						var val = obj.attr('val');
						var name = obj.parent().parent().find('.js_name').text();
						if(obj.hasClass('active')){
							oldStr = oldStr ? (oldStr+','+val) : val;
							oldNameStr = oldNameStr ? (oldNameStr+','+val+'#&'+name) : val+'#&'+name;//增加显示名称
						}else{
		                	var regId = new RegExp(val+"[,]{0,1}",'g');//id的正则表达式
		                	var regName = new RegExp(val+'#&'+name+"[,]{0,1}",'g');//名字的正则表达式
							oldStr = oldStr.replace(regId,'').replace(/([,]{0,1}$)/g,"");
							oldNameStr = oldNameStr.replace(regName,'').replace(/([,]{0,1}$)/g,"");//增加显示名称
						}
					});
                	$('#'+dataSourceId).attr({'tmpval':oldStr,'tmpname':oldNameStr});
				},
	            //根据弹框种类，HTML，宽，高进行处理
	            layer_html:function(type,tpl,width,height){
	                var that = this;
	                type=(type==1)?'':'2';
	                //this.layer_type的作用是保存弹框种类，防止双击重复弹框
	                if(that.layer_type===type){
	                    return false;
	                }
	                that.layer_type = type;
	                var dom = $('#layer_div'+type);
	                dom.html('<div class="layer_in" style="display:none;"></div>');
	                dom.find('.layer_in').html(tpl);
	                oDiv = {dom:dom.find('.layer_in')};
	                //设置弹框垂直居中
	                var offsetHeight = parseInt(($(window).height()-height)/2)+'px';
	                //将弹框保存在layer_div1,layer_div中，方便关闭弹框
	                this['layer_div'+type] = $.layer({
	                        type: 1,
	                        title: false,
	                        area: [width+'px',height+'px'],
	                        offset: [offsetHeight, ''],
	                        bgcolor: '#ccc',
	                        border: [0, 0.3, '#ccc'], 
	                        shade: [0.2, '#000'], 
	                        closeBtn:false,
	                        page: oDiv,
	                        shadeClose:false,//true表示点击遮罩关闭弹出层
	                        //关闭时layer_type置0
	                        end:function(){
	                            that.layer_type=0;
	                        },
	                    });	                
	            },
	            initPopData: function(){	
	            	$('.js_sel_keyword_type').selectPlug({getValId:'kwdType',defaultVal: ''}); //账号类型下拉框
					this.categoryBindEvt();
	            },
	            categoryBindEvt: function(){/*一次弹出层初始化绑定事件*/
	            	var that = this;
					//点击显示区域、行业、职能弹出层
					$('#region,#industry,#position').click(function(evt){
						 $(this).blur();
						 $.contactsRec.popLevelTwo.init($(this));
					});
	                //关闭二次弹框
	                $('#layer_div2').on('click','.js_add_list_cancel',function(){
	                    layer.close(that.layer_div2);
	                });
	            },
	            //get方法获取推荐列表
	            getInPopPage:function(url,obj){
	                var that = this;
	            	url = url.replace('/dataTotolNumAnsy/1','');//非分页url处理
	                $.get(url,obj,function(res){
	                    that.sle_url = url;
	                    $('#layer_div .layer_in').html(res.tpl);
	                    that.showPageTpl(url,obj);
	                    that.setActive();
	                });
	               
	            },
	            //获取生成关于分页部分的数据
	            showPageTpl: function(url,obj){
	            	var paramPage = {};
	            	for(var i in obj){
	            		paramPage[i] = obj[i];
	            	}
	            	paramPage['dataTotolNumAnsy'] = 1;
	            	var tmpUrl = url;
	                $.get(tmpUrl,paramPage,function(res){
	                    $('#layer_div .js_pop_page_tpl .page').html(res.pagedata);
	                });
	            },
	            //循环推荐人列表，如果推荐人ID与保存的ID相同，勾选上此推荐人
	            setActive:function(isValue){
	            	this.initPopData();
	                var dataSourceId = $('#dataSourceId').val();
	                if(typeof(isValue) != 'undefined' && isValue == true){/*打开弹出层时初始化列表数据*/
	                	  var dataStr = $('#'+dataSourceId).val();
	                	  $('#'+dataSourceId).attr('tmpval', dataStr);
	                }else{
	                	  var dataStr = $('#'+dataSourceId).attr('tmpval');
	                }
	              
	                if(dataStr){
		                var dataArr = dataStr.split(',');
		                var allCheckFlag = true;
		                $('#layer_div .js_select').each(function(){
		                	var obj = $(this);
		                    if($.inArray($.trim(obj.attr('val')),dataArr) != -1){
		                    	obj.addClass('active');
		                    }else{
		                    	allCheckFlag = false;
		                    }
		                });
		                $('#js_allselect').toggleClass('active',allCheckFlag);
	                }
	            },
			},
			
			/**
			 * 二次弹出层所有功能操作
			 */
			popLevelTwo:{
				totalSelector: '#layer_div2', //定义弹出层存储容器
				actionObj: {
						'region':{'type':'citySet','code':'provincecode','name':'province'},
						'industry':{'type':1,'code':'categoryid'},
						'position':{type:2,'code':'categoryid'}
						}, //定义类型
				cacheHtml: {}, //缓存html结构
				cacheData:{}, //缓存数据
				initFlag: false, //用于存储是否调用过添加监听事件方法,只有对象第一次调用是才会调用事件监听
				targetObj:null,
				init: function(obj){
					$.contactsRec.addIndex.layer_html(2,$('#categoryHideHtml').html(),580,530);
					this.targetObj = obj;
					this.genOneHtml();
					//默认初始化绑定事件
					if(!this.initFlag){
						$.contactsRec.popLevelTwo.bindEvtPop(); 
						this.initFlag = true;
					}	
					this.initSetTitle();
				},
				//初始化时设置标题
				initSetTitle: function(){
					var id = this.targetObj.attr('id');
					var titleSet = {'region':['选择地区','省/直辖市','市'], 'industry':['选择行业','一级分类','二级分类'], 'position':['选择职能','行业','职能']};
					$('.js_pop_top_title').html(titleSet[id][0]);
					$('.js_pop_level1_title').html(titleSet[id][1]);
					$('.js_pop_level2_title').html(titleSet[id][2]);
				},
				/*清空html缓存*/
				clearCache: function(){
					this.cacheHtml = {};
				},
				//生成一级列表
				genOneHtml: function(){
					var datatype = this.targetObj.attr('id');
					if(typeof(this.cacheHtml[datatype+'one']) != 'undefined' && typeof(this.cacheHtml[datatype+'two']) != 'undefined'){
						var htmlStr = this.cacheHtml[datatype+'one'];
						$.myScroll(this.totalSelector+' .js_pop_level_1',htmlStr);
						var htmlStr = this.cacheHtml[datatype+'two'];
						$.myScroll(this.totalSelector+' .js_pop_level_2',htmlStr);
						this.setPopActive();
					}else{
						var num1 = this.targetObj.attr('num1');
						if(typeof(this.cacheData[datatype]) == 'undefined' || !this.cacheData[datatype]){
							this.getOneData(datatype);
						}
						var data = this.cacheData[datatype];
						var htmlStr = '';
						var codeKey = this.actionObj[datatype]['code'];
						var nameKey = typeof(this.actionObj[datatype]['name'])=='undefined'?false:this.actionObj[datatype]['name'];
						$.each(data,function(i,val){
							var code = val[codeKey];
							var name = nameKey?val[nameKey]:val.name;
							htmlStr += '<label class="label_1-'+num1+'"><input name="levelOne" class="clsLevelPop clsLevelOne" '
									+' datatype="'+datatype+'" type="checkbox"  id="levelOne'+code+'" value="'+code+'"/>'+name+'</label>';
						});
						$.myScroll(this.totalSelector+' .js_pop_level_1',htmlStr);
						$(this.totalSelector+' .js_pop_level_2').html('');
					}
				},
				/*获取一级数据*/
				getOneData: function(datatype){
					var typeSet = {'region':{action:'provinceSet',url:gUrlGetProvinceList},'industry':{action:'industry',url:gUrlGetIndustryList},
							'position':{action:'position',url:gUrlGetIndustryList}};
					var that = this;
					var data = {};
					var typekey = typeSet[datatype]['action'];
					if(datatype == 'region'){
						data.type = typekey;
					}else if(datatype == 'industry' || datatype == 'position'){
						data.parentid = 0;
						data.max = 1;
					}
					$.ajax({
						url:typeSet[datatype]['url'],
						data:data,
						async: false,
						dataType: 'json',
						success: function(rst){
							if(rst){
								that.cacheData[datatype] = rst;
							}
						}
					});
				},
				//获取二级列表数据
				getTwoData: function(obj){
					var typeSet = {'region':{action:'provinceSet',url:gUrlGetRegionList},'industry':{action:'industry',url:gUrlGetIndustryList}
							,'position':{action:'position',url:gUrlGetIndustryList}};
					var that = this;
					var datatype = obj.attr('datatype');
					var code = obj.val();
					var data = {type:this.actionObj[datatype]['type']};
					if(datatype == 'region'){
						data.id = code;
					}else if(datatype == 'industry'){
						data.parentid = code;
						data.max = 1;
						//data.type = 1; //表示职能
					}else if(datatype == 'position'){
						data.parentid = code;
						data.max = 1;
						//data.type = 2; //表示职能
					}
					if(typeof(window.popLevel2) == 'undefined' || !window.popLevel2){
						window.popLevel2 = true;;
						$.get(typeSet[datatype]['url'],data,function(rst){
							window.popLevel2 = false;
							if(rst){
								rst && that.genTwoHtml(rst,code,datatype);
							}
						},'json');
					}

				},
				//生成二级列表HTML结构
				genTwoHtml: function(data,parentCode,datatype){
					var num = this.targetObj.attr('num2');
					var htmlStr = '';
					var codeName = this.actionObj[datatype]['code'];
					$.each(data,function(i,val){
						var code = val[codeName];
						var name = val.name;
						if(datatype == 'region'){
							code = val['prefecturecode'];
							name = val['city'];
						}else if(datatype == 'position'){
							code = val['id'];
						}
						htmlStr += '<label class="label_1-'+num+'"><input name="levelTwo" class="clsLevelPop clsLevelTwo_'+parentCode+'"'
								+' value="'+code+'" data-pid="'+parentCode+'" type="checkbox"/>'+name+'</label>';
					});
					$.myScroll(this.totalSelector+' .js_pop_level_2',htmlStr,true);
				},
				//设置二次弹出层选中回显效果
				setPopActive: function(){
					var ids = this.targetObj.attr('hideVal');
					if(ids){
						ids = ids.split(',');
						$.each(ids,function(i,code){
							var childObj= $('.clsLevelPop[value="'+code+'"]');
							var pid = childObj.attr('data-pid');//获取父类id
							$('#levelOne'+pid).prop('checked',true); //设置一级父类选中
							//设置子类选中
							if(childObj.attr('data-checked') == '1'){
								childObj.prop('checked', true);
							}			
						});
					}
				},
				bindEvtPop: function(){
					var that = this;
					//点击一级列表复选框
					$(that.totalSelector).on('click','.clsLevelOne',function(){
						var obj = $(this);
						if(obj.is(":checked")){
							that.getTwoData(obj);
						}else{
							$('.clsLevelTwo_'+obj.val()).parent().remove();
						}						
					});
					//点击二次弹出层确定按钮
					$(that.totalSelector).on('click','.js_pop_two_ok',function(){
						 that.popTwoConfirmBtn();
					});					
				},
				//二次弹出层点击确定按钮
				popTwoConfirmBtn: function(){
					var /*levelRegionNameRelation = [],*/levelOneNames = []; //存储选中的一级(一级选中并且二级全选的情况)
					var levelTwoIds = [],levelTwoNames = []; //存储选中的二级(一级选中二级选中一部分)
					//var allIds = [];
					//var countryName = '中国';
					$('.clsLevelOne:checked').each(function(){
						var oneObj = $(this);
						var oneCode = oneObj.val();
						var checkTwoObjs = $('.clsLevelTwo_'+oneCode+':checked');
						var totalLen = $('.clsLevelTwo_'+oneCode).size();
						var checkChildLen = checkTwoObjs.size();
						if(checkChildLen == 0){
							levelOneNames.push(oneObj.parent().text());//levelOneIds.push(oneCode);
							$.each($('.clsLevelTwo_'+oneCode),function(){
								var obj = $(this);
								obj.removeAttr('data-checked');
								levelTwoIds.push(obj.val());
								//获取省份和城市的名称
								var provinceName = $('#levelOne'+oneCode).parent().text();
								var cityName = obj.parent().text();
								//levelRegionNameRelation.push(countryName+provinceName+cityName);
							});
						}else{
							//判断子类是否全选中
							/*if(checkChildLen == totalLen){
								var pid = checkTwoObjs.eq(0).attr('data-pid');
								$('#levelOne'+pid).attr('data-all-checked',1);
							}*/
							$.each(checkTwoObjs,function(){
								var obj = $(this);
								obj.attr('data-checked','1');
								levelTwoIds.push(obj.val());//allIds.push($(this).val());
								levelTwoNames.push(obj.parent().text());
								//获取省份和城市的名称
								var provinceName = $('#levelOne'+oneCode).parent().text();
								var cityName = obj.parent().text();
								//levelRegionNameRelation.push(countryName+provinceName+cityName);
							});
						}
					});
					this.targetObj.val(levelOneNames.join(',') + levelTwoNames.join(',')).attr({'hideVal':levelTwoIds.join(',')/*,'hideRelName':levelRegionNameRelation.join(',')*/});
					var oneHtml = $(this.totalSelector+' .js_pop_level_1 .mCSB_container').html();
					var twoHtml = $(this.totalSelector+' .js_pop_level_2 .mCSB_container').html();
					var targetObj = this.targetObj;
					this.cacheHtml[targetObj.attr('id')+'one'] = oneHtml;
					this.cacheHtml[targetObj.attr('id')+'two'] = twoHtml;
					$('#layer_div2 .js_add_list_cancel').click(); //关闭二次弹出层
				}
			}	
		}
	});
})(jQuery);