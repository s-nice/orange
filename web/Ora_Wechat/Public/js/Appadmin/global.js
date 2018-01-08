var gSelHeight = 300;//下拉框高度定义
;(function($) {
	$.extend({
		/**
		 * 锁屏js插件
		 */
		lockScreen:function(){
				this.init = function(){
					var that = this;
					
					//判断是否处于锁定状态
					if(gIsLocked == 1){
						that.openDialog();
					}
					
					// 移动了就更新最近一次移动的时间。 
					document.onmousemove = function(){ 
						window.lastMove = new Date().getTime(); 
					}; 					
					document.onkeydown=function(){ 
						window.lastMove = new Date().getTime(); 
					}
					window.lastMove = new Date().getTime();//最近一次移动时间 
					window.setInterval(function(){//每1秒钟检查一次。 
						var now = new Date().getTime(); 
						// 如果超时了 
						if( now - lastMove > G_JS_LOCK_SCREEN_TIME*1000 || gIsLocked == 1){ 
							 if($('.js_lockscreenpop').is(':hidden')){ 
								 that.openDialog(); //打开锁屏框
							 }
						} 
					}, 1000); 
					
				}
				this.openInterval = function(){
					
				}
				this.ajaxUnLock = function(){
					var unlookcode = $('#unlookid').val();
					if(!unlookcode){
						return ;
					}
					var that = this;
					$.ajax({
						   type: "POST",
						   url: gUnLockUrl,
						   data: {unlookcode:unlookcode},
						   dataType:'json',
						   success: function(result){
								if(result.status == 0){
									$('.js_lockscreenpop,.js_masklayer_lock').hide();
									$('.js_masklayer_lock').addClass('appadmin_Administrator');
									window.lastMove = new Date().getTime();
									gIsLocked = 0; //解锁成功
								}else{									
									that.openDialog();
									$.global_msg.init({
										msg : result.msg,
										btns : true,
										endFn:function(){	
										}
									});
									if(result.status == 1001 && typeof(result.data.url) != 'undefined'){
										setInterval(function(){
											window.location.href = result.data.url;
										},gSessionUnValidAutoRedir*1000);
									}
								}
						   }
						});
					
				}
				this.openDialog = function(hand){
					var that = this;
					hand = typeof(hand) == 'undefined'?0:hand;
					if(gIsLocked == 0){
						//var img = new Image();
						//img.src = gLockUrl+'?lscreen=1';
						if(typeof(window.gLocking) == 'undefined' || window.gLocking == false){
							window.gLocking = true;
							$.post(gLockUrl, {lscreen:1,hand:hand},function(msg){
								window.gLocking = false;
								if(msg.status == 0){
									that.showLockDialog();
								}else{
									window.lastMove = parseInt(msg.data);
								}
						    },'json');
						}
					}else{
						that.showLockDialog();
					}
				}
				this.showLockDialog = function(){
					var that = this;
					$('.js_lockscreenpop,.js_masklayer_lock').show();
					$('.js_masklayer_lock').removeClass('appadmin_Administrator');
					$('#unlookid').blur().val('');
					$('#unlookbtn').off('click').on('click',function(){
						that.ajaxUnLock();
					});
				}
				this.init();
				return this;
		},
		/**
		 * 给table中数据列添加title提示功能，需要手动调用
		 */
		tableAddTitle: function(dataSelector, childClsSuffix){
			if($(dataSelector).size() === 0){
				return false;
			}
			childClsSuffix = typeof(childClsSuffix) == 'undefined' ? 'span_span' : childClsSuffix; //前缀class名称
		    $(dataSelector+'>[class^="'+childClsSuffix+'"]').each(function(){
		        var obj = $(this);
		        if(obj.children().length == 0 && $.trim(obj.html()) !== ''){
		        	if(obj.attr('title') == undefined || obj.attr('title') == ''){
		        		obj.attr('title',$.trim(obj.html()));
		        	}
		        }
		      });
		},
		/**
		 * 自定义滚动条 
		 * @param selector 需要添加滚动条的元素对象
		 * @param html字符串结构
		 * @param append 是否追加,默认false调用html() true调用append()
		 * @param callbacks 回调函数
		 */
		myScroll:function(selector,htmlStr,append,callbacks){
			append = typeof(append)=='undefined'?false:true;
			var scrollObj = $(selector);
			//滚动条生效后不再执行
        	if(scrollObj.hasClass('mCustomScrollbar')){
        		if(append){
        			scrollObj.find('.mCSB_container').append(htmlStr);
        		}else{
        			scrollObj.find('.mCSB_container').html(htmlStr);
        		}        		
        	}else{
        		scrollObj.html(htmlStr);
        		scrollObj.mCustomScrollbar({
			        theme:"dark", //主题颜色
			        autoHideScrollbar: false, //是否自动隐藏滚动条
			        scrollInertia :0,//滚动延迟
			        horizontalScroll : false,//水平滚动条
			        callbacks:callbacks
			    });
        	}
		},

		//js  post提交（非AJAX）
		form: function (url, data, method) {
	        if (method == null) method = 'POST';
	        if (data == null) data = {};

	        var form = $('<form>').attr({
	            method: method,
	            action: url,
	            "accept-charset" : "utf-8",     // 重要，解决其他浏览器
	            onsubmit : "document.charset='utf-8';"  //重要，解决IE提交时编码问题
	        }).css({
	            display: 'none'
	        });

	        var addData = function (name, data) {
	            if ($.isArray(data)) {
	                for (var i = 0; i < data.length; i++) {
	                    var value = data[i];
	                    addData(name + '[]', value);
	                }
	            } else if (typeof data === 'object') {
	                for (var key in data) {
	                    if (data.hasOwnProperty(key)) {
	                        addData(name + '[' + key + ']', data[key]);
	                    }
	                }
	            } else if (data != null) {
	                form.append($('<input>').attr({
	                    type: 'hidden',
	                    name: String(name),
	                    value: String(data)
	                }));
	            }
	        };

	        for (var key in data) {
	            if (data.hasOwnProperty(key)) {
	                addData(key, data[key]);
	            }
	        }

	        return form.appendTo('body');
	    },
	});

    /**
     * 复选框插件start code
     * 功能与作用：此插件除了可以全选、取消全选功能外，还可以设置被选中的数量、返回被选中的数据，
     * 调用此插件的对象必须是已经存在于页面的元素，且是所有被操作的复选框的祖先对象(注意如果要兼容平板电脑和手机，最好用id对象，而不要用class)
     * @param Object
     * 参数说明如下：
     * 	checkAllSelector       全选按钮选择器
     * 	checkChildSelector     子选择框按钮选择器
     * 	checkedNumSelector 需要显示的被选中的元素数量对象
     *		rtnCheckObj        返回数据类型：默认为false返回被选中对象value数组集合，为true时返回所有被选中的对象
     *
     *调用方式： 注意：为了能够兼容平板电脑和手机，调用对象最好用$('#collectionapp_right')而不是$('.collectionapp_right')
     *		 var checkObj = $('.collectionapp_right').checkDialog({checkAllSelector:'.checkAllBtn',checkChildSelector:'.checkChildBtn',
		  *	       valAttr:'val',selectedClass:'active'});
     * 输出被选中的元素数据： console.log(checkObj.getCheck());
     */
    $.fn.extend({
        checkDialog: function (opts) {
            var $totalObj = $(this); //定义能包含所有需要插件覆盖checkbox框最外层的jQuery对象

            //定义默认参数，此参数可以被被覆盖
            var defaults = {
                checkAllSelector: '#checkAllBtn', //全选按钮的选择器对象，可自定义传入
                checkChildSelector: '#checkChildBtn', //子选选框的选择器对象,可自定义传入
                rtnCheckObj: false, /*返回数据格式，false:返回被选中的对象值,true:返回所有被选中的checkbox对象*/
                valAttr: 'data-val', //存储数据值的属性  例如val="id123"
                selectedClass: 'active', //复选框被选中时的class名称
                clickFn:null, //复选框点击事件回调函数
                debug: true //是否开启调试模式,开发中可以开启调试模式
            };
            var setting = $.extend(true, {}, defaults, opts);
            this.init = function () {/*初始化函数*/
                this.bindEvent();
            };
            this.bindEvent = function () {/*绑定事件*/
                var that = this;
                //全选按钮
                $totalObj.on('click', setting.checkAllSelector, function () {
                    that.checkAll($(this));
                });
                //子按钮
                $totalObj.on('click', setting.checkChildSelector, function () {
                    that.checkChild($(this));
                });
            };
            this.checkAll = function (allObj) {/*点击全选按钮后的操作*/
                allObj.toggleClass(setting.selectedClass);
                var allObjStatus = allObj.hasClass(setting.selectedClass);
                var allChildObj = $totalObj.find(setting.checkChildSelector);
                if (allObjStatus == true) {
                	var  obj = allChildObj.not('.' + setting.selectedClass);
                    obj.addClass(setting.selectedClass);
                    this.clickCallback(obj);
                } else {
                	var obj = allChildObj.filter('.' + setting.selectedClass);
                	obj.removeClass(setting.selectedClass);
                    this.clickCallback(obj);
                }
            };
            this.checkChild = function (thisObj) {/*点击子复选框按钮后的操作*/
                thisObj.toggleClass(setting.selectedClass);
                var flag = true;
                $.each($totalObj.find(setting.checkChildSelector), function (index, obj) {
                    if (!$(obj).hasClass(setting.selectedClass)) {
                        flag = false;
                        return;
                    }
                });
                $totalObj.find(setting.checkAllSelector).toggleClass(setting.selectedClass, flag);
                this.clickCallback(thisObj);
            };
            //复选框点击回调函数,解决翻页复选的问题
            this.clickCallback = function(thisObj){
                if($.isFunction(setting.clickFn)){
                	setting.clickFn(thisObj);
                }
            },
            this.getCheck = function () {/*返回所有被选中的复选框的值*/
                var checkedData = [];
                var checkedObjs = $totalObj.find(setting.checkChildSelector).filter('.'+setting.selectedClass);
                if (setting.rtnCheckObj) {
                    return checkedObjs;
                }
                /*生成被选中的对象数据*/
                $.each(checkedObjs, function (index, dom) {
                	if(setting.debug){
                		if(typeof($(dom).attr(setting.valAttr)) == 'undefined'){
                			console && console.error('in element not exists attribute : '+setting.valAttr);
                		}else if($(dom).attr(setting.valAttr) == ''){
                			console && console.error('in element '+setting.valAttr+ ' is empty : '+dom);
                		}
                	}
                	// 复选框的值不推送
                	if($.trim($(dom).attr(setting.valAttr)) != ''){
                		checkedData.push($.trim($(dom).attr(setting.valAttr)));
                	}
                });
                return checkedData;
            };
            //取消选中所有已经选中的数据项
            this.noCheck = function(){
            	 var allChildObj = $totalObj.find(setting.checkChildSelector);
            	 allChildObj.filter('.' + setting.selectedClass).removeClass(setting.selectedClass);
            	 $totalObj.find(setting.checkAllSelector).removeClass(setting.selectedClass);
            }
            this.init();
            /*此插件调用入口*/
            return this;
        },/*复选框插件end code*/
        /*下拉框插件*/
		selectPlug:function(opts){
			var defaultOpts = {
					getValId: '', /*【必填项】获取选中下拉框值的id,会自动生成一个隐藏的文本框，用户存放用户选择的值*/
					defaultVal:'', /*【可选】，用来设置下拉框默认显示值，或在input中给定默认值如val=?*/
					liValAttr: 'val', /*【可选】li标签上显示值的属性*/
					dataSet:[] /*【可选】下拉框数据,可以在页面模板中直接生成，也可以通过插件传入数组对象[{id:1,name:'abc'},{id:2,name:'zp'},...]*/
						};
			var opts = $.extend(true,{},defaultOpts,opts);
			$(this).addClass('js_sel_public');
			var totalObj = this;
			var selectList = totalObj.children('ul');
			this.init = function(){
				this.bindEvt();
				this.initData();
			}
			//绑定事件
			this.bindEvt = function(){
				var that = this;
				totalObj.children('input').on('click',function(){
					totalObj = $(this).parent();
					selectList = $(this).nextAll('ul');
					that.operaSelect();
				});
				totalObj.children('span').children('input').on('click',function(){
					totalObj = $(this).parent().parent();
					selectList = $(this).parent().nextAll('ul');
					that.operaSelect();
				});
				totalObj.find('i,em').on('click',function(){
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
					//修改下拉框选中效果
					totalObj.find('li').removeClass('on');
					totalObj.find('li['+opts.liValAttr+'="'+obj.attr(opts.liValAttr)+'"]').addClass('on');
					totalObj.find('input:eq(0)').val(obj.text()).attr('title',obj.text()).attr(opts.liValAttr,obj.attr(opts.liValAttr));
					that.operaSelect();
				}
			}
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
						tmpHtml += '<li '+opts.liValAttr+'="'+data.id+'" title="'+data.name+'">'+data.name+'</li>';
					});
					totalObj.find('ul').html(tmpHtml);
				}

				//刷新页面后设置下拉框默认值
				var showVal = realVal = '';
				if(opts.defaultVal){/*js给定义默认值*/
					 realVal = opts.defaultVal;
					 showVal = totalObj.find('li['+opts.liValAttr+'="'+opts.defaultVal+'"]').html();
				}else if(totalObj.find('input:eq(0)').attr('val')){/*input输入框给定默认值*/
					realVal = totalObj.find('input:eq(0)').attr('val');
					showVal = totalObj.find('li['+opts.liValAttr+'="'+realVal+'"]').html();
				}else{/*获取li第一个作为默认值*/
					realVal = totalObj.find('li:eq(0)').attr('val');
					showVal = totalObj.find('li:eq(0)').html();
				}
				//修改下拉框选中效果
				totalObj.find('li').removeClass('on');
				totalObj.find('li['+opts.liValAttr+'="'+realVal+'"]').addClass('on');
				totalObj.find('input:eq(0)').val(showVal).attr('title',showVal).attr(opts.liValAttr,realVal);
				//初始化传递给后台的值
				if(totalObj.find('#'+opts.getValId).length == 0){
					var html = '<input type="hidden" name="'+opts.getValId+'" id="'+opts.getValId+'" value="'+realVal+'" readonly="readonly"/>';
						totalObj.append(html);
				}else{
					totalObj.find('#'+opts.getValId).val(realVal);
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

	$(function(){
		//点击退出登陆按钮
		$('.js_logoutbtn').click(function(){
			$('.js_logoutpop,.js_masklayer').show();
			$('.js_logoutok').click(function(){
				window.location.href = gLogoutUrl;
			});
			$('.js_logoutcancel').click(function(){
				$('.js_logoutpop,.js_masklayer').hide();
			});
		});
		//点击锁屏按钮
		$('.js_lockscreenbtn').click(function(){
			window.gLockObj.openDialog(1);
		});
		//回车自动登陆
		document.onkeydown=function(event){
		     if($('.js_lockscreenpop').is(':visible')){
		     	var e = event ? event :(window.event ? window.event : null);
			        if(e.keyCode==13){
			        	window.gLockObj.ajaxUnLock();
			        }
		     }
		 };
		 
		/*
		 * 点击弹出层的取消按钮， 关闭图标， 将弹出层隐藏
		 */
		$('.popup_window').on('click', '.js_logoutcancel', function () {
		    $('.popup_window, .js_masklayer').hide();
		    
		    return false;
		});
	});
})(jQuery);
//日历插件
(function($) {
	$.extend({
		dataTimeLoad: {
			format: 'Y-m-d',
			timepicker : false,
			idArr: [{start:'js_begintime',end:'js_endtime'}],
			minDate:{},
			maxDate:{},
            init: function (settings) {
            	//初始化最大最小值
            	var _this = this;
            	_this.initMinMax();
                /* 初始化 */
                if (typeof settings == 'object') {
                    if (typeof settings.format == 'string') {
                        this.format = settings.format;
                    }else {
                    	this.format = 'Y-m-d';
                    }
                    if (typeof settings.timepicker == 'boolean') {
                        this.timepicker=settings.timepicker;
                    }else{
                    	this.timepicker = false;
                    }
                    if (typeof settings.idArr == 'object') {
                        this.idArr = settings.idArr;
                    }else {
                    	this.idArr = [{start:'js_begintime',end:'js_endtime'}];
                    }
                    if (typeof settings.minDate == 'object') {
                        $.extend(this.minDate,settings.minDate);
                    }
                    if (typeof settings.maxDate == 'object') {
                        $.extend(this.maxDate,settings.maxDate);
                    }
                    this.statistic = false;
                    if (settings.statistic){
                    	this.statistic = settings.statistic;
                    }
                }
				// 删除
			    $('.select_time_c').on('click','.js_delTimeStr',function(){
			    	var $this = $(this).parents('.time_c').find('input');
			    	$this.val('');
			    	$.dataTimeLoad.timeClassFn($this);
			    	var se_type = $this.attr('se_type'),obj;
			    	if(se_type=='start'){
			    		obj = {'maxDate':_this.maxDate.end,'minDate':_this.minDate.end};
			    	}else{
			    		obj = {'maxDate':_this.maxDate.start,'minDate':_this.minDate.start};
			    	}
			    	$('#'+$this.attr('idClass')).datetimepicker(obj);
			    });
			    // 选择时间
			    $('.select_time_c').on('click','.js_selectTimeStr',function(){
			    	$(this).parents('.time_c').find('input').focus();
			    });
			    var x;
			    for(x in this.idArr){
			    	$.dataTimeLoad.timeLoad(this.idArr[x],this.format);
			    }
			},
			// 非用户统计页面的初始化
			timeLoad:function(option,format){
				var _this=this;
				var beginObj = $('#'+option.start);
			    var endObj = $('#'+option.end);
			    beginObj.attr('idClass',option.end);
			    beginObj.attr('se_type','start'),
			    endObj.attr('idClass',option.start);
			    endObj.attr('se_type','end');
			    
			    // 删除|选择class判断
			    $.dataTimeLoad.timeClassFn(beginObj);
			    $.dataTimeLoad.timeClassFn(endObj);
			    // 开始时间参数
			    var beginOption;
			    if (this.statistic){
			    	var maxDate = new Date();
			    	
				    switch(this.statistic){
				    	case 'm':
				    		maxDate = maxDate.firstDayOfMonth().addDate(-1).clearTime().format();
				    		break;
				    	case 'w':
				    		maxDate = maxDate.mondayOfWeek().addDate(-1).clearTime().format();
				    		break;
				    	default:
				    		maxDate = maxDate.addDate(-1).clearTime().format();
				    		break;
			    	}
			    	beginOption = { maxDate:maxDate,format: format,lang:'ch',showWeak:true,formatDate:format,timepicker:_this.timepicker,validateOnBlur:false,
			            onSelectDate:function(d,obj){
			            	var date=_this.getSearchDate(obj.val(),true,_this.statistic);
			            	endObj.datetimepicker({'maxDate':date.format(),'minDate':obj.val()}).val('');
			            },
			            onClose:function(){
			            	$.dataTimeLoad.timeClassFn(beginObj);
			            },
			            onGenerate: function(d,obj){
			            	var date=_this.getSearchDate(obj.val(),true,_this.statistic);
			            	endObj.datetimepicker({'maxDate':date.format(),'minDate':obj.val()});
			            }
			        };
			    } else {

			    	beginOption = { minDate:_this.minDate.start,maxDate:_this.maxDate.start,format: format,lang:'ch',showWeak:true,formatDate:format,timepicker:_this.timepicker,validateOnBlur:false,
			            onSelectDate:function(){
			                var starttime = beginObj.val();
			                endObj.datetimepicker({'minDate':_this.getMaxDate(starttime,_this.minDate.end)});
			            },
			            onClose:function(){
			            	$.dataTimeLoad.timeClassFn(beginObj);
			            }
			        };
			    	if(endObj.val() != ''){
				    	beginOption.maxDate = _this.getMinDate(endObj.val(),_this.maxDate.start);
				    }
			    }
			    beginObj.datetimepicker(beginOption);
			    
			    // 结束时间参数,
			    var endOption;
			    if (this.statistic){
			    	endOption = {format: format,lang:'ch',showWeak:true,formatDate:format,timepicker:_this.timepicker,validateOnBlur:false};
			    } else {
			    	endOption = { maxDate:_this.maxDate.end,minDate:_this.minDate.end,format: format,lang:'ch',showWeak:true,formatDate:format,timepicker:_this.timepicker,validateOnBlur:false,
				        onSelectDate:function(){
				            var endtime = endObj.val();
				            beginObj.datetimepicker({'maxDate':_this.getMinDate(endtime,_this.maxDate.start)});
				        },
				        onClose:function(){
				        	$.dataTimeLoad.timeClassFn(endObj);
				        }
				    };
			    }
			    
			    if(beginObj.val() != ''){
			    	endOption.minDate = _this.getMaxDate(beginObj.val(),_this.minDate.end);
			    }
			    endObj.datetimepicker(endOption);
			},
			// 选择|删除class判断
			timeClassFn:function(obj){
				if(obj.val() != ''){
					obj.parents('.time_c').find('i').removeClass('js_selectTimeStr').addClass('js_delTimeStr').find('img').remove();
				}else{
					obj.parents('.time_c').find('i').removeClass('js_delTimeStr').addClass('js_selectTimeStr').find('img').remove();
				}
			},
			/**
			 * 传入开始时间或者结束时间返回结果时间
			 * @param str date 时间（字符串或者DATE类型）
			 * @param bool isStartDate （开始时间传true，结束时间传false）
			 * @param str type （m月统计，w周统计，d日统计）
			 * return date
			 */
			getSearchDate: function(date,isStartDate,type){
				if (typeof(date) == 'string'){
					date = date.toDate();
				}
				date.clearTime();
				var rdate = new Date(date.getTime()).clearTime();
				var today = new Date().clearTime();
				
				//传过来的是开始时间，求结束时间
				if (isStartDate){
					switch(type){
						case 'w':
							rdate.addDate(7*12-rdate.getDay());
							
							//如果结束日期比今天还要大，则是上周日
							var today=new Date();
							if (rdate.getTime() >= today.getTime()){
								rdate = today.addDate(-today.getDay());
							}
							break;
						case 'm':
							rdate.addFullYear(1).firstDayOfMonth().addDate(-1);
							
							//如果结束日期比今天还要大，则是上个月底
							today.firstDayOfMonth();
							if (rdate.getTime() > today.getTime()){
								rdate = today.addDate(-1);
							}
							break;
						case 'd3':
							rdate.addDate(89);
							if (rdate.getTime() >= today.getTime()){
								rdate = today.addDate(-1);
							}
							break;
						default:
							rdate.addDate(29);
							if (rdate.getTime() >= today.getTime()){
								rdate = today.addDate(-1);
							}
					}
				}
				
				//传过来的是结束时间，求开始时间
				if (!isStartDate){
					switch(type){
						case 'w':
							rdate.addDate(-7*12-rdate.getDay()+1);
							break;
						case 'm':
							rdate.addFullYear(-1).firstDayOfMonth().addMonth(1);
							if (date.getFullYear() == today.getFullYear() && date.getMonth() == today.getMonth()){
								rdate.addMonth(-1)
							}
							break;
						case 'd3':
							rdate.addDate(-89);
							break;
						default:
							rdate.addDate(-29);
					}
				}
				return rdate;
			},

			//默认最大值为今天，最小值无
			initMinMax:function(){
				this.minDate.start = false;
				this.minDate.end = false;
				this.maxDate.start = Date();
				this.maxDate.end = Date();
			},

			//获取两个时间中的小的时间
			getMinDate:function(a,b){
				if(a===false){
					return b;
				}
				if(b===false){
					return a;
				}
				if(new Date(a)>new Date(b)){
					return b;
				}else{
					return a;
				}
			},
			//获取两个时间中大的时间
			getMaxDate:function(a,b){
				if(a===false){
					return b;
				}
				if(b===false){
					return a;
				}
				if(new Date(a)<new Date(b)){
					return b;
				}else{
					return a;
				}
			},
		}
	});
})(jQuery);	

/**
 * 日期格式化
 * @param string format
 */
Date.prototype.format = function(format){
	format = format || 'Y-m-d';
	var y = this.getFullYear();
	var m = this.getMonth()+1;
	var d = this.getDate();
	var h = this.getHours();
	var i = this.getMinutes();
	var s = this.getSeconds();
	// 不足两位， 前面补0
	m = m<10 ? ('0'+m) : m;
	d = d<10 ? ('0'+d) : d;
	h = h<10 ? ('0'+h) : h;
	i = i<10 ? ('0'+i) : i;
	s = s<10 ? ('0'+m) : s;
	
	return format.replace('Y',y).replace('m',m).replace('d',d)
	             .replace(/h/i,h).replace('i',i).replace('s',s)
	
	;
};

/**
 * 日期加减
 * @param int num
 */
Date.prototype.addDate = function(num){
	this.setDate(this.getDate()+num);
	return this;
};

/**
 * 月份加减
 * @param int num
 */
Date.prototype.addMonth = function(num){
	this.setMonth(this.getMonth()+num);
	return this;
};

/**
 * 年加减
 * @param int num
 */
Date.prototype.addFullYear = function(num){
	this.setFullYear(this.getFullYear()+num);
	return this;
};

/**
 * 时分秒清零
 */
Date.prototype.clearTime = function(){
	this.setHours(0);
	this.setMinutes(0);
	this.setSeconds(0);
	this.setMilliseconds(0);
	return this;
};

/**
 * 当前月的第一天
 */
Date.prototype.firstDayOfMonth = function(){
	this.setDate(1);
	return this;
};

/**
 * 当前周的星期一
 */
Date.prototype.mondayOfWeek = function(){
	var day = this.getDay();
	if (day == 1){
		return this;
	}
	
	if (day == 0){
		return this.addDate(-6);
	}
	return this.addDate(-(day - 1));
};

/**
 * 字符串转时间
 * @param string format
 */
String.prototype.toDate = function(format){
	var date = new Date();
	format = format || 'Y-m-d';
	var separator = this.match(/[/-]/);
	var strList = this.split(separator);
	var formatList = format.split(separator);
	for(var i=0;i<formatList.length;i++){
		switch(formatList[i]){
			case 'Y':
				date.setFullYear(parseInt(strList[i]));
				break;
			case 'm':
				date.setMonth(parseInt(strList[i])-1);
				break;
			case 'd':
				date.setDate(parseInt(strList[i]));
				break;
			case 'H':
				date.setHours(parseInt(strList[i]));
				break;
			case 'i':
				date.setMinutes(parseInt(strList[i]));
				break;
			case 's':
				date.setSeconds(parseInt(strList[i]));
				break;
		}
	}
	return date;
};
/*
 * formatMoney({money:money,type:formatType}|money)
 * 功能：金额按千位逗号分割
 * 参数：money,需要格式化的金额数值.
 * 参数：formatType,判断格式化后的金额小数位的位数.
 * 返回：返回格式化后的数值字符串.
 */
(function($){
	$.extend({
		globalFun:{
			formatType:2,
			money:0,
			formatMoney:function(options) {
				this.money = 0;
				this.formatType = 2;
				if(typeof options == 'object'){
					this.money = isNaN(options.money)?0:options.money;
					if(!isNaN(options.type)){
						this.formatType = options.type;
					}
				}else if(!isNaN(options)){
					this.money = options;
				}
				var num = new Number(this.money*1);
				num = num.toFixed(this.formatType);
				var num1 = num.split(".")[0].split("").reverse(), num2 = num.split(".")[1];
				var newnum = "";
				for (i = 0; i < num1.length; i++) {
					newnum = newnum+ num1[i] + ((i + 1) % 3 == 0 && (i + 1) != num1.length ? "," : "");
				}
				return newnum.split("").reverse().join("") + "." + num2; 
			}
		}
	});
})(jQuery);	
$(function(){
	//横向滚动条列表中添加效果
	$('body').on('click','.js_x_scroll_backcolor',function(evt){
		var divObj = $(this);
		var obj = $(evt.target);
		if(obj.hasClass('js_no_action') || obj.hasClass('js_no_action') ||  obj.parent().hasClass('js_no_action')){

		}else{
			var flag = divObj.hasClass('tr_click_color');
			$('.js_x_scroll_backcolor').removeClass('tr_click_color');
			divObj.toggleClass('tr_click_color',!flag);
		}
	});
	//全选
	$('#js_allselect').on('click', function () {
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
			$('.js_select').removeClass('active');
		} else {
			$(this).addClass('active');
			$('.js_select').addClass('active');
		}
	});
	//单选
	$('body').on('click', '.js_select', function () {
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
			$('#js_allselect').removeClass('active');
		} else {
			$(this).addClass('active');
			if ($('.js_list_one .js_select').length == $('.js_list_one .active').length) {
				$('#js_allselect').addClass('active')
			}

		}
	});

	//下拉列表
	$('.js_list_select').on('click', function () {
		$(this).find('ul').toggle();
	});

	//下拉选择
	$('.js_list_select').on('click', 'li', function () {
		if (!$(this).hasClass('on')) {
			$(this).siblings('li').removeClass('on');
			$(this).addClass('on');
			var $inputObj = $(this).parents('.js_list_select').find('input');
			$inputObj.val($(this).html());
			$inputObj.attr('val', $(this).attr('val'));
			$inputObj.trigger('change');
		}
	});

	//下拉菜单点击外部关闭
	$(document).on('click', function (e) {
		var clickObj = $(e.target).parents('.js_list_select');
		if (!clickObj.length) {
			$('.js_list_select').find('ul').hide();
		} else {
			$('.js_list_select').not(clickObj).find('ul').hide();
		}
	});
});
