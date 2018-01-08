/**
 * 统计页面js
 */
var gSelHeight = 300;//下拉框高度定义
(function($) {
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
			}
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
				totalObj.find('li').on('click',totalObj,function(){
					totalObj = $(this).parent().parent();
					selectList = $(this).parent();
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
					var showVal = totalObj.find('li['+opts.liValAttr+'="'+opts.defaultVal+'"]').text();
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
		statistics: {
			echart: function(echartContainerId, echartOption) {
		        // 基于准备好的dom，初始化echarts实例
		        var myChart = echarts.init(document.getElementById(echartContainerId));

		        // 使用刚指定的配置项和数据显示图表。
		        myChart.setOption(echartOption);
			}
			
		},
		pageInfo:{
			// 页面下拉框事件
			selectItem: function(){
				var ulHeight = $('.js_select_item ul').height();
				if(ulHeight>gSelHeight){
					$('.js_select_item ul').height(gSelHeight);
			       	 //给列表添加滚动条
					var scrollObj = $('.js_select_item ul');
			    	if(scrollObj.hasClass('mCustomScrollbar')){
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
				}/*,'mouseout':function(){
					$(this).closest('.js_select_item').find('ul').hide();
				}*/
			    });
				$('.js_select_item li').on({'click':function(){
					    $(this).toggleClass('on'); // 选中/取消选中， 添加/移除 class
					    // 点击列表中的 非"所有", 将所有选项移除
					    if (! $(this).hasClass('js_all_in_one')) {
							$(this).siblings('.js_all_in_one').removeClass('on');
						}
					    
					    var $select = $(this).closest('.js_select_item'); // 当前选择列表
						var doMulti = $select.hasClass('js_multi_select'); // 是否处理多项选择
						var selectedLiLength = $select.find('ul li.on').length; // 选中长度
						var $inputHidden = $select.find('input[type="hidden"]').eq(0).clone(); // 缓存隐藏元素
						// 如果选中“所有” ， 或者， 选择框不具有复选功能
						if ($(this).hasClass('js_all_in_one') || !doMulti) {
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
			        }
			    });
				
				//点击区域外关闭此下拉框
				$(document).on('click',function(e){
					if($(e.target).parents('.js_select_item').length>0){
						var currUl = $(e.target).parents('.js_select_item').find('ul');
						$('.js_select_item>ul').not(currUl).hide()
					}else{
						$('.js_select_item>ul').hide();
					}
				});
				
				/*$('.js_select_item ul').on({'mouseover':function(){
					$(this).closest('.js_select_item').find('ul').show();
				},'mouseout':function(){
					$(this).closest('.js_select_item').find('ul').hide();
				}
				});*/
			},
			scrollData : function  () {
	       	   //给列表添加滚动条
				var scrollObj = $('.js_scroll_data');
		    	if(!scrollObj.hasClass('mCustomScrollbar')){
		    		scrollObj.mCustomScrollbar({
				        theme:"dark", //主题颜色
				        autoHideScrollbar: false, //是否自动隐藏滚动条
				        scrollInertia :0,//滚动延迟
				        horizontalScroll : false,//水平滚动条
				    });
		    	}
			} // end scrollData
			
		},
		
		/**
		 * 联动
		 * @param options
		 * @returns {@G}
		 */
		selectLinkage : function (options) {
			this._options = {
				selectors : [], // 联动的数据项
				prevAttr  : 'value', // 用于计算联动的上一级属性
				nextAttr  : 'data-link-value', // 用户计算联动的下一级属性
				listenEvent: '', // 需要监听的事件名称，如 click。 如果不需要监听事件， 留空
				activeClass: 'on',     // 项目为选定状态时的class
				eventBindActiveClass: false  // 是否在事件激发时， 将 activeClass绑定。 如果绑定， 将 添加/取消 activeClass
			};
			var self = this;
			/**
			 * 参数设置
			 */
			this.setOptions = function (options) {
				$.extend(this._options, options);
				
				return this;
			};

			this.setOptions(options); // 将参数合并
			/**
			 * 监听事件
			 */
			this.listen     = function () {
				if (''==this._options.listenEvent) {
					return;
				}
				var params;
				// 将选项的选中样式绑定到事件中
				for (var i=0; i<this._options.selectors.length; i++) {
					params = {options:this._options, nowIndex:i};
					//params = i==(this._options.selectors.length-1) ? {} : params;
					$(this._options.selectors[i]).on(this._options.listenEvent, params, function (event) {
						if (event.data.options.eventBindActiveClass) {
						    this.toggleClass(event.data.options.activeClass);
						}
						self.change(event.data.options, event.data.nowIndex);
						return false;
					});
				}
			};
			/**
			 * 执行联动效果
			 */
			this.run        = function () {
				// 联动选择器设置小于2， 不能做联动
				if(this._options.selectors.length < 2)
					return;
				this.listen();
				// 从第一级联动开始执行
				this.onLoad(this._options, 0);
			};
			/**
			 * 联动核心方法。 根据选定的参数，做逐级联动
			 * @param options 联动的参数
			 * @param nowIndex 当前联动到第几级。 根据级数和联动参数， 找到对应联动对象
			 */
			this.change     = function (options, nowIndex) {
				// 联动的最后一级， 不做处理。 因为在上一级已经实现本级的联动
				if (nowIndex==options.selectors.length-1)
					return;
				// 查找当前已选定的联动元素
				var $list = $(options.selectors[nowIndex]).filter('.'+options.activeClass);
				// 下一级联动选择器
				var nextSelector = options.selectors[nowIndex+1];
				// 过滤条件
				var showFilterAttr, hideFilterAttr;
				// 将下一级曾选中的元素， 先取消
				$(nextSelector).filter('.'+options.activeClass).trigger('click');
				
				if ($list.length==0) {// 如果本级什么都没选中， 恢复后续级中元素显示状态
					$(options.selectors[nowIndex]+':first').trigger('click').removeClass(options.activeClass);
					$(nextSelector).show();
				} else { // 有选中元素， 先隐藏下一级元素。 但是需要保留第一个元素 “所有” 显示状态
					$(nextSelector+':not(:first)').hide();
				}
				
				// 根据选中的元素， 设定下一级元素
				for(var i=0; i<$list.length; i++) {
					// 本级选中的是 ”所有“， 取消下一级已选中的元素， 将下一级 “所有”恢复选中情况，但是需要将“所有”的选中状态取消掉
					if ($list.eq(i).attr(options.prevAttr)==undefined || $list.eq(i).attr(options.prevAttr)=='') {
						$(nextSelector).filter('.'+options.activeClass).trigger('click');
						$(nextSelector).eq(0).trigger('click');
						$(nextSelector).removeClass(options.activeClass).show();
						
						break;
					}
					// 根据当前选中的元素， 拼装下一级的过滤条件
					showFilterAttr = '[' + options.nextAttr + '*=",' + $list.eq(i).attr(options.prevAttr) +',"]';
					//hideFilterAttr = '[' + options.nextAttr + '!=' + $list.eq(i).attr(options.prevAttr) +']';
					// 将下一级曾选中的元素， 取消选中。
					$(nextSelector).filter('.'+options.activeClass).trigger('click');
					//$(options.selectors[nowIndex+1]+':not(:first)').hide();
					// 将下一级需要联动的元素显示。 其他元素， 已经在上面隐藏了
					$(nextSelector).filter(showFilterAttr).show();
					
					// 当前选择框是单选， 在切换时， 将下一级的 ‘所有’设为默认
					if (! $list.eq(i).hasClass('js_multi_select')) {
						$(nextSelector+':first').trigger('click').removeClass(options.activeClass);
					}
				}
				
				// 递归执行， 逐级调用
				this.change(options, nowIndex+1);
			};
			
			/**
			 * @param options 联动的参数
			 * @param nowIndex 当前联动到第几级。 根据级数和联动参数， 找到对应联动对象
			 */
			this.onLoad     = function (options, nowIndex) {
				// 联动的最后一级， 不做处理。 因为在上一级已经实现本级的联动
				if (nowIndex==options.selectors.length-1)
					return;
				// 查找当前已选定的联动元素
				var $list = $(options.selectors[nowIndex]).filter('.'+options.activeClass);
				// 下一级联动选择器
				var nextSelector = options.selectors[nowIndex+1];
				// 过滤条件
				var showFilterAttr, hideFilterAttr;
				
				if ($list.length==0) {// 如果本级什么都没选中， 恢复后续级中元素显示状态
					$(nextSelector).show();
				} else { // 有选中元素， 先隐藏下一级元素。 但是需要保留第一个元素 “所有” 显示状态
					$(nextSelector+':not(:first)').hide();
				}
				
				// 根据选中的元素， 设定下一级元素
				for(var i=0; i<$list.length; i++) {
					// 本级选中的是 ”所有“， 取消下一级已选中的元素， 将下一级 “所有”恢复选中情况，但是需要将“所有”的选中状态取消掉
					if ($list.eq(i).attr(options.prevAttr)==undefined || $list.eq(i).attr(options.prevAttr)=='') {
						$(nextSelector).show();
						
						break;
					}
					// 根据当前选中的元素， 拼装下一级的过滤条件
					showFilterAttr = '[' + options.nextAttr + '*=",' + $list.eq(i).attr(options.prevAttr) +',"]';
					// 将下一级需要联动的元素显示。 其他元素， 已经在上面隐藏了
					$(nextSelector).filter(showFilterAttr).show();
				}
				
				// 递归执行， 逐级调用
				this.onLoad(options, nowIndex+1);
			};
			
			this.run();
			
			return this;
			
		}
		
	});
	
	$.pageInfo.selectItem();
	// 系统平台 和 渠道 联动
	new $.selectLinkage(
			{
				selectors : ['#select_platform ul li', '#select_channel ul li'], // 联动的数据项
				prevAttr  : 'val', // 用于计算联动的上一级属性
				nextAttr  : 'data-link-value', // 用户计算联动的下一级属性
				listenEvent: 'click', // 需要监听的事件名称，如 click。 如果不需要监听事件， 留空
				activeClass: 'on',     // 项目为选定状态时的class
				eventBindActiveClass: false  // 是否在事件激发时， 将 activeClass绑定。 如果绑定， 将 添加/取消 activeClass
			}
	);
	// 系统平台 和 产品版本 联动
	new $.selectLinkage(
			{
				selectors : ['#select_platform ul li', '#select_prd_version ul li'], // 联动的数据项
				prevAttr  : 'val', // 用于计算联动的上一级属性
				nextAttr  : 'data-link-value', // 用户计算联动的下一级属性
				listenEvent: 'click', // 需要监听的事件名称，如 click。 如果不需要监听事件， 留空
				activeClass: 'on',     // 项目为选定状态时的class
				eventBindActiveClass: false  // 是否在事件激发时， 将 activeClass绑定。 如果绑定， 将 添加/取消 activeClass
			}
	);
	
	// 国家 和 省份 联动
	new $.selectLinkage(
			{
				selectors : ['#select_country ul li', '#select_province ul li'], // 联动的数据项
				prevAttr  : 'val', // 用于计算联动的上一级属性
				nextAttr  : 'data-link-value', // 用户计算联动的下一级属性
				listenEvent: 'click', // 需要监听的事件名称，如 click。 如果不需要监听事件， 留空
				activeClass: 'on',     // 项目为选定状态时的class
				eventBindActiveClass: false  // 是否在事件激发时， 将 activeClass绑定。 如果绑定， 将 添加/取消 activeClass
			}
	);
	
	var statistic=typeof(gStatisticDateType)=='undefined'?false:gStatisticDateType;
	$.dataTimeLoad.init({statistic:statistic,idArr: [{start:'js_begintime',end:'js_endtime'},{start:'js_begintime1',end:'js_endtime1'}]});
    $.pageInfo.scrollData();
    
	// 图标参数没有正确设置 或者 参数类型不匹配
    if ('object'!=typeof(gEchartSettings) || gEchartSettings.length<1) return;
    
    // 画出图标参数
    
    for (var i=0; i<gEchartSettings.length; i++) {
    	$.statistics.echart(gEchartSettings[i].containerId, gEchartSettings[i].option);
    }
    return;
})(jQuery);

/**
 * 导出数据
 * @param url String 导出数据时请求的url地址
 * @param exportFormat (FORMAT_EXCEL|FORMAT_CSV)
 * @param params 导出请求时传递给后台的参数，例如:var params = {startTime:startTime,endTime:endTime};
 */
function exportFn(url,params){	
	if(typeof($('#iframe_id').attr('src')) == 'undefined'){
		var iframeHtml = '<iframe id="iframe_id" style="display:none"></iframe>';
		$('body').append(iframeHtml);
	}	
	var params = params || {};
	if(!url){
		$.global_msg.init({msg:t['export_params_err'],time:3});
		return;
	}	
	var paramStr = getEscapeParamStr(params);
	url = url + '/' + paramStr;
	$("#iframe_id").attr('src',url);
}

//编码url
function getEscapeParamStr (jsonData){
	if (!jsonData) return '';
	var qarr = [];
	for(i in jsonData){
		qarr.push(i+"/"+encodeURIComponent(jsonData[i]));
	}
	return qarr.join('/');
}

$(function(){	     
	 //给渠道、版本、省份等下拉框添加滚动条
     var scrollObjs = $('.js_select_item>ul');
     scrollObjs.each(function(i,dom){
  	   var scrollObj = $(dom);
         if(scrollObj.height() >200){
         	   scrollObj.height(200);
             if(!scrollObj.hasClass('mCustomScrollbar')){
                 scrollObj.mCustomScrollbar({
                     theme:"dark", //主题颜色
                     autoHideScrollbar: false, //是否自动隐藏滚动条
                     scrollInertia :0,//滚动延迟
                     horizontalScroll : false,//水平滚动条
                 });
             }
         }
     });          
 });
