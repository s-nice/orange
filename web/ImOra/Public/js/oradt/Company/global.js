;
(function($) {
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
                selectedClass: 'active' //复选框被选中时的class名称
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
                    allChildObj.not('.' + setting.selectedClass).addClass(setting.selectedClass);
                } else {
                    allChildObj.filter('.' + setting.selectedClass).removeClass(setting.selectedClass);
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
            };
            this.getCheck = function () {/*返回所有被选中的复选框的值*/
                var checkedData = [];
                var checkedObjs = $totalObj.find(setting.checkChildSelector).filter('.'+setting.selectedClass);
                if (setting.rtnCheckObj) {
                    return checkedObjs;
                }
                /*生成被选中的对象数据*/
                $.each(checkedObjs, function (index, dom) {
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
        }/*复选框插件end code*/
    });

	
	//http://fengfan876.iteye.com/blog/1541532
    //备份jquery的ajax方法  
    var _ajax=$.ajax;       
    //重写jquery的ajax方法  
    $.ajax=function(opt){
        //备份opt中error和success方法  
        var fn = {  
            error:function(XMLHttpRequest, textStatus, errorThrown){},  
            success:function(data, textStatus){}  
        }  
        if(opt.error){  
            fn.error=opt.error;  
        }  
        if(opt.success){  
            fn.success=opt.success;  
        }  
          
        //扩展增强处理  
        var _opt = $.extend(opt,{  
            error:function(XMLHttpRequest, textStatus, errorThrown){  
                //错误方法增强处理  
                fn.error(XMLHttpRequest, textStatus, errorThrown);  
            },  
            success:function(data, textStatus){  
            	//console && console.log('这是ajax重载');
            	if(status == codeLoginOther){
            		$.global_msg.init({gType:'warning',icon:1,msg:gLoginOtherPlace,endFn:function(){
            			window.location.href = gLogoutUrl;
            		}});
            	}else{
                    //成功回调方法增强处理  
                    fn.success(data, textStatus); 
            	}
            }  
        });  
        _ajax(_opt);  
    }; 

	//日历插件
	$.extend({
		dataTimeLoad: {
			format: 'Y-m-d',
			idArr: [{start:'js_begintime',end:'js_endtime'}],
            init: function (settings) {
                /* 初始化 */
                if (typeof settings == 'object') {
                    if (typeof settings.format == 'string') {
                        this.format = settings.format;
                    }else {
                    	this.format = 'Y-m-d';
                    }
                    if (typeof settings.idArr == 'object') {
                        this.idArr = settings.idArr;
                    }else {
                    	this.idArr = [{start:'js_begintime',end:'js_endtime'}];
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
			    	$('#'+$this.attr('idClass')).datetimepicker({'maxDate':Date(),'minDate':false});
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
			    endObj.attr('idClass',option.start);
			    
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
			    	beginOption = { maxDate:maxDate,format: format,lang:'ch',showWeak:true,formatDate:format,timepicker:false,validateOnBlur:false,
			            onSelectDate:function(d,obj){
			            	var date=_this.getSearchDate(obj.val(),true,_this.statistic);
			            	endObj.datetimepicker({'maxDate':date.format(),'minDate':obj.val()}).val('');
			            },
			            onClose:function(){
			            	$.dataTimeLoad.timeClassFn(beginObj);
			            }
			        };
			    } else {
			    	beginOption = { maxDate: Date(),format: format,lang:'ch',showWeak:true,formatDate:format,timepicker:false,validateOnBlur:false,
			            onSelectDate:function(){
			                var starttime = beginObj.val();
			                endObj.datetimepicker({'minDate':starttime});
			            },
			            onClose:function(){
			            	$.dataTimeLoad.timeClassFn(beginObj);
			            }
			        };
			    	if(endObj.val() != ''){
				    	beginOption.maxDate = endObj.val();
				    }
			    }
			    typeof(beginObj.datetimepicker) == 'function' && beginObj.datetimepicker(beginOption);
			    
			    // 结束时间参数,
			    var endOption;
			    if (this.statistic){
			    	endOption = {maxDate:maxDate,format: format,lang:'ch',showWeak:true,formatDate:format,timepicker:false,validateOnBlur:false};
			    } else {
			    	endOption = { maxDate: Date(),format: format,lang:'ch',showWeak:true,formatDate:format,timepicker:false,validateOnBlur:false,
				        onSelectDate:function(){
				            var endtime = endObj.val();
				            beginObj.datetimepicker({'maxDate':endtime});
				        },
				        onClose:function(){
				        	$.dataTimeLoad.timeClassFn(endObj);
				        }
				    };
			    }
			    
			    if(!beginObj.attr('readonly') && beginObj.val() != ''){
			    	endOption.minDate = beginObj.val();
			    }
			    typeof(endObj.datetimepicker) == 'function' && endObj.datetimepicker(endOption);
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
						default:
							rdate.addDate(30);
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
						default:
							rdate.addDate(-30);
					}
				}
				return rdate;
			}

		},
		/**
		 * 在页面中生成隐藏的iframe
		 * 
		 * @param frameName
		 *            隐藏的iframe id和name的名称，可不传递，默认为hidden_frame
		 */
		genFrame: function (frameName) {
			var frameName = frameName || 'hidden_frame';
			if (typeof ($('#' + frameName).attr('src')) == 'undefined') {
				var iframeHtml = '<iframe id="' + frameName+ '" name="' + frameName					
						+ '"  style="display:none;" id="hidden_frame" width="100%" height="100%"></iframe>';
				$('body').append(iframeHtml);
			}
			return frameName;
		}
	});
	
	/**
	 * 页面下拉框事件
	 * 最外层divClassName js_select_item
	 * 多选功能   需要在最外层追加className js_multi_select
	 * "全选"下拉项增加className js_allCheckbox 
	 * 下拉列表需要增加滚动条 在ul上增加className js_mCustomScrollbar $selectItem.init([number],[string]);
	 * 	number表示下拉选项超过该number时出现滚动条,默认300
	 *  string标识多选后展示值之间的分隔符,默认逗号‘,’
	 * <div class="js_select_item js_multi_select">
					<input readonly="readonly" value="select当前选中展示内容" />
					<input type="hidden" name="select传递name" value="select选中传递值" />
					<i><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
					<ul class="js_mCustomScrollbar">
						<li val="all" class="js_allCheckbox" title="全部">全部</li>
						<li val="select选项传递值1" title="select选项展示值1">select选项展示值1</li>
						<li val="select选项传递值n" title="select选项展示值n">select选项展示值n</li>
					</ul>
				</div>
	 */ 
	$.extend({
		selectItem: {
			init: function(){
				var gSelHeight = arguments[0] ? arguments[0] : 300;
				var gMultiValueSeparator = arguments[1] ? arguments[1] : ',';
				var ulHeight = $('.js_select_item ul').height();
				if(ulHeight>gSelHeight){
					$('.js_select_item ul').height(gSelHeight);
			       	 //给列表添加滚动条
					var scrollObj = $('.js_select_item ul');
			    	if(scrollObj.hasClass('js_mCustomScrollbar')){
			    		scrollObj.mCustomScrollbar({
					        theme:"dark", //主题颜色
					        autoHideScrollbar: false, //是否自动隐藏滚动条
					        scrollInertia :0,//滚动延迟
					        horizontalScroll : false,//水平滚动条
					    });
			    	}
				}
				$('.js_select_item i').on('click',function(){
					$(this).closest('.js_select_item').find('ul').toggle();
			    });
				$('.js_select_item input').on({'click':function(){
					$(this).closest('.js_select_item').find('ul').toggle();
					$(this).blur();
					}
				});
				$('.js_select_item li').on({'click':function(){
					    $(this).toggleClass('on'); // 选中/取消选中， 添加/移除 class
					    // 点击列表中的 非"所有", 将所有选项移除
					    if (! $(this).hasClass('js_allCheckbox')) {
							$(this).siblings('.js_allCheckbox').removeClass('on');
						}
					    
					    var $select = $(this).closest('.js_select_item'); // 当前选择列表
						var doMulti = $select.hasClass('js_multi_select'); // 是否处理多项选择
						var selectedLiLength = $select.find('ul li.on').length; // 选中长度
						var $inputHidden = $select.find('input[type="hidden"]').eq(0).clone(); // 缓存隐藏元素
						// 如果选中“所有” ， 或者， 选择框不具有复选功能
						if ($(this).hasClass('js_allCheckbox') || !doMulti) {
					    	$(this).siblings().removeClass('on');
					    	doMulti = false;
					    }
						// 将隐藏的输入移除掉。 后续动态加入。
					    $select.find('input[type="hidden"]').remove();
		
						//$(this).closest('.js_select_item').find('ul').hide();
						if (true===doMulti && $select.hasClass('js_multi_select')) { // 允许多选的下拉列表
							var newValue = '';
							var valueSeparator = 'undefined'==typeof(gMultiValueSeparator) ? '/' : gMultiValueSeparator;
							
							// 取消了所有选择， 恢复隐藏框
							if (0==selectedLiLength) {
								$select.append($inputHidden.clone().val($select.find('ul li:first').attr('title')));
							}
							// 根据选中项， 设置页面可见元素的内容
							for (var i=0; i<selectedLiLength; i++) {
								if (0==i) 
									newValue = $select.find('ul li.on').eq(i).attr('title');
								else
								    newValue = newValue + valueSeparator + $select.find('ul li.on').eq(i).attr('title');
								// 逐项添加隐藏输入
								$select.append($inputHidden.clone().attr({
									'value':$select.find('ul li.on').eq(i).attr('val'),
									'title':$select.find('ul li.on').eq(i).attr('title')
								}) );
							}
							// 设置可见输入元素的内容
							$select.find('input[type="text"]').val(newValue).attr({'value':newValue,'title':newValue});
							
						} else { // 单选下拉列表
							$select.prepend($inputHidden.clone());
							$select.find('input').val($(this).attr('title'));
							$select.find('input').attr({'val':$(this).attr('val'),'title':$(this).attr('title')});
							$select.find('input[type="hidden"]').attr('value',$(this).attr('val'));
							if (! $select.hasClass('js_multi_select')) {
							    $select.find('ul').hide();
							}
							
						}
			    }});
				
				//点击区域外关闭此下拉框
				$(document).on('click',function(e){
					if($(e.target).parents('.js_select_item').length>0){
						var currUl = $(e.target).parents('.js_select_item').find('ul');
						$('.js_select_item>ul').not(currUl).hide()
					}else{
						$('.js_select_item>ul').hide();
					}
				});
			}
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

$.extend({
	checkMsg:function(){
		setTimeout(function(){
			$.get(checkMsgUrl,function(res){
				if(res.status==0){
					var html = res.tpl;
					$.layer({
					    type:1,
					    shift:'right-bottom',
					    area:['300px','200px'],
					    time:3000,
					    closeBtn:false,
					    title:false,
					    border:[1,0.3,'#ccc'],
					    shadeClose:true,
					    page:{
					        html:html,
					    },
					});
				}
			});
		},500);
		
	}
});
$.checkMsg();
