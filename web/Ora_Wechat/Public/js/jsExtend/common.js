/*
 * 这个文件放一些自己写的常用的插件与常用的函数方法
 * 插件列表有：
 * 		复选框插件(可以兼容复选框美化效果插件)
 * 
 * 常用的函数方法有：
 * 
 */
;(function($){	
	 /**
	  * 给jQuery添加对象插件
	  */
	 $.fn.extend({
		 /**
		  * 复选框插件start code
		  * 功能与作用：此插件除了可以全选、取消全选功能外，还可以设置被选中的数量、返回被选中的数据，
		  * 还可以与杨勇写的复选框美化插件兼容使用(美化插件还需要单独引用css样式)
		  * 调用此插件的对象必须是已经存在于页面的元素，且是所有被操作的复选框的祖先对象(注意如果要兼容平板电脑和手机，最好用id对象，而不要用class)
		  * @param Object 
		  * 参数说明如下：
		  * 	checkAllName       全选按钮name
		  * 	checkChildName     子选择框按钮name
		  * 	checkedNumSelector 需要显示的被选中的元素数量对象
		  *		rtnCheckObj        返回数据类型：默认为false返回被选中对象value集合，为true时返回所有被选中的对象
		  *
		  *调用方式： 注意：为了能够兼容平板电脑和手机，调用对象最好用$('#collectionapp_right')而不是$('.collectionapp_right')
		  *		 var checkObj = $('.collectionapp_right').checkDialog({checkAllName:'checkAllBtn',checkChildName:'checkChildBtn',
		  *	       checkedNumSelector:'#selectedRecordCount'});
		  * 输出被选中的元素数据： console.log(checkObj.getCheck());
		  */
		 checkDialog : function(opts){
			 var $totalObj = $(this); //定义能包含所有需要插件覆盖checkbox框最外层的jQuery对象
			
			 //定义默认参数，此参数可以被被覆盖
			 var defaults = {
					 checkAllName   :'checkAllBtn', //全选checkbox的默认name，可自定义传入
					 checkChildName : 'checkChildBtn', //子全选checkbox的默认name,可自定义传入
					 checkedNumSelector:'', //用来显示被选中数量的对象
					 rtnCheckObj : false /*返回数据格式，false:返回被选中的对象值,true:返回所有被选中的checkbox对象*/
					};
			 var setting = $.extend(true,{},defaults,opts);
			 this.init = function(){/*初始化函数*/
				 this.construct();
				 this.bindEvent();
			 };
			 this.construct = function(){
				 $totalObj.find(':checkbox[name="'+setting.checkAllName+'"]').prop('checked',false); //取消全选复选框(主要用来清除刷新浏览器后的缓存)
				 this.showCheckedCount();
			 }
			 this.bindEvent = function(){/*绑定事件*/
				 var that = this;
				 //全选按钮
				 $totalObj.on('click',':checkbox[name="'+setting.checkAllName+'"]',function(){
					 that.checkAll($(this));
				 });
				 //子按钮
				 $totalObj.on('click',':checkbox[name="'+setting.checkChildName+'"]',function(){
					 that.checkChild($(this));
				 });
			 };
			 this.checkAll = function(allObj){/*点击全选按钮后的操作*/
				 var allObjStatus = allObj.prop('checked');
				 var allChildObj =  $totalObj.find(':checkbox[name="'+setting.checkChildName+'"]');
				     allChildObj.prop('checked',allObjStatus);
			     this.showCheckedCount();
				 //关于复选框样式处理
				 allChildObj.parent().toggleClass('active',allObjStatus);
			 };
			 this.checkChild = function(thisObj){/*点击子复选框按钮后的操作*/
				 var flag = true;
				 $.each($totalObj.find(':checkbox[name="'+setting.checkChildName+'"]'),function(index,obj){
					 if($(obj).prop('checked') == false){
						 flag = false;
						 return;
					 }
				 });
				 $totalObj.find(':checkbox[name="'+setting.checkAllName+'"]').prop('checked',flag);
				 this.showCheckedCount();
				 //关于复选框样式处理
				 $totalObj.find(':checkbox[name="'+setting.checkAllName+'"]').parent().toggleClass('active',flag);
			 };
			 this.nextPage = function(){/*分页时子复选框级联事件(需要手动调用)*/
				 this.checkAll($totalObj.find(':checkbox[name="'+setting.checkAllName+'"]'));
			 };
			 this.showCheckedCount = function(){
				 /*显示被选中的复选框数量*/
				 var checkedObjs = $totalObj.find('input[name="'+setting.checkChildName+'"]:checked');
				 var count		 = checkedObjs.length;
				 setting.checkedNumSelector && $(setting.checkedNumSelector).html(count);


			 };
			 this.getCheck = function(){/*返回所有被选中的复选框的值*/
				 var checkedData = '';
				 var checkedObjs = $totalObj.find('input[name="'+setting.checkChildName+'"]:checked');
				 if(setting.rtnCheckObj){
					return checkedObjs;
				 }
				 /*生成被选中的对象数据*/
				 $.each(checkedObjs,function(index,dom){
					 var currVal = $.trim($(dom).val());						 	 
						if(checkedData){
							checkedData += ','+currVal;
						}else{
							checkedData = currVal;
						}
				  });
				  return checkedData;
			 };
			 this.init();/*此插件调用入口*/
			 return this;
		 },/*复选框插件end code*/
		 
		/*职能选择弹出层插件*/
		categoryPop:function(options){
			 var defaults = {
					nameShow:'',/*用来显示的的name和id的值*/
					nameTrans:'',/*用来传递给后台的name和id的值*/
					totalCheckNum:5, /*复选框最多被选中的数量*/
					classNames:'handClassPosition',/*带有美化效果的复选框class名称(input->class)*/
					openFn:null,/*下拉层打开后的回调函数*/
					closeFn:null,/*下拉层关闭后的回调函数*/
					openParam:[],/*下拉层打开后的传递的参数*/
					closeParam:[],/*下拉层关闭后的传递的参数*/
					scrollHeight:500,/*超过此高度出现滚动条*/
					scrollSelector: '.hr_category_position_scoll' /*滚动条选择器*/
			 };
			 var opts = $.extend(true,{},defaults,options);
			 var that = this;
			 that.totalObj = $(this); /*最外层对象*/
			 that.divData = null; /*数据对象*/
			 if(this.totalObj.lenghth == 0)return;
			 this.init=function(opts){
				 this.initElement();
				 this.bindEvent();
			 };
			 /*自动生成input输入框*/
			 this.initElement=function(){
				 that.divData =  that.totalObj.children('div');
				 /*自动生成传递给后端值的input框*/	
				 var input = that.divData.next('input');
				 if(input.length == 0){
					 var thisShowInput = that.totalObj.children(1).find('input');
					 var dataKey = thisShowInput.attr('data-key'); //实际传递的值
					 if(!dataKey){
						 dataKey=''; 
					 }
					 var inputName = opts.nameTrans || thisShowInput.attr('data-name');
					 var input = '<input type="hidden" name="'+inputName+'" id="'+inputName+'" value="'+dataKey+'"/>'; 
					 that.divData.after(input);
				 }
				  //初始化数据元素的class
				// that.divData.addClass('cls_cate_pop_auto_create');
			 }
			 this.bindEvent = function(){
				 /*点击输入框、下拉箭头时触发的事件*/
				 that.totalObj.on('click','img,.img',function(){
					 var thisDiv = that.totalObj.children('div');
					 if(thisDiv.is(':visible')){
						 thisDiv.hide();
						 $.closeFnBind(opts);
					 }else{ 
						 $('.nicescroll-rails').hide();//解决其他插件滚动条展示问题
					     $('.popup_div').hide();
						 thisDiv.show();
						 $.openFnBind(opts);
					 }
					//return false;
				 });
				 //添加滚动条事件
				 if(opts.scrollSelector && $(opts.scrollSelector).size() == 1){
					 opts.scrollObj = $(opts.scrollSelector).height(opts.scrollHeight).niceScrollMe();
				 }
				//复选框插件
				var className = opts.classNames;
				var defaultOpts = {'selector':'input[class="'+className+'"]','totalObj':that.totalObj};
				var checkOpts = $.extend(true,{},opts,defaultOpts);
				$.CheckBoxPosition.init(checkOpts);
			 }
			 this.init();
		},
		
		/*行业分类弹出层插件(最高层级别为二级)*/
		industryPop:function(options){
			 var defaults = {
					nameShow:'',/*用来显示的的name和id的值*/
					nameTrans:'',/*用来传递给后台的name和id的值*/
					totalCheckNum:5, /*复选框最多被选中的数量*/
					classNames:'',/*复选框class名称*/
					openFn:null,/*下拉层打开后的回调函数*/
					closeFn:null,/*下拉层关闭后的回调函数*/
					openParam:[],/*下拉层打开后的传递的参数*/
					closeParam:[],/*下拉层关闭后的传递的参数*/
					scrollHeight:500,/*超过此高度出现滚动条*/
					scrollSelector: '.hr_category_industry_scoll',/*滚动条选择器*/
			 };
			 var opts = $.extend(true,{},defaults,options);
			 var that = this;
			 that.totalObj = $(this); /*最外层对象*/
			 that.divData = null; /*数据对象*/
			 if(this.totalObj.lenghth == 0)return;
			 this.init=function(opts){
				 this.initElement();
				 this.bindEvent();
			 };
			 /*自动生成input输入框*/
			 this.initElement=function(){
				 that.divData =  that.totalObj.children('div');
				 /*自动生成传递给后端值的input框*/	
				 var input = that.divData.next('input');
				 if(input.length == 0){
					 var thisShowInput = that.totalObj.children(1).children('input');
					 var dataKey = thisShowInput.attr('data-key'); //实际传递的值
					 if(!dataKey){
						 dataKey=''; 
					 }
					 var inputName = opts.nameTrans || thisShowInput.attr('data-name');
					 var input = '<input type="hidden" name="'+inputName+'" id="'+inputName+'" value="'+dataKey+'"/>'; 
					 that.divData.after(input);
				 }
				  //初始化数据元素的class
				 //that.divData.addClass('cls_cate_pop_auto_create');
			 }
			 this.bindEvent = function(){
				 /*点击输入框、下拉箭头时触发的事件*/
				 that.totalObj.on('click','img,.img',function(){
					 var thisDiv = that.totalObj.children('.cls_firstdiv');
					 if(thisDiv.is(':visible')){
						 thisDiv.hide();
						 $.closeFnBind(opts);
					 }else{
						$('.nicescroll-rails').hide();//解决其他插件滚动条展示问题
					 	$('.popup_div').hide();
						 thisDiv.show();
						 $.openFnBind(opts);
					 }
					//return false;
				 });
				 
				//添加滚动条事件
				 if(opts.scrollSelector && $(opts.scrollSelector).size() == 1){
					 opts.scrollObj = $(opts.scrollSelector).height(opts.scrollHeight).niceScrollMe();
				 }
				//复选框插件
				var classNames = opts.classNames;
				var defaultOpts = {'selector':'input[class="'+classNames+'"]','totalObj':that.totalObj};
				var checkOpts = $.extend(true,{},opts,defaultOpts);
				$.CheckBoxIndustry.init(checkOpts);
			 }
			 this.init();
		},
		/*获取input输入框里面的值*/
		zval:function(){
			//console.log($(this))
			var value = $.trim($(this).val());
			if(value == $(this).get(0).defaultValue){
				return '';
			}
			return value;	
		},
		
		/*hr地区下拉选择框插件start*/
		selHrRegionOpt:function(opt){
			 var defaults = {
					showName:'',/*显示的name(传值给后端的文本输入框)*/
					transName:'',/*input的name和id的值(前端显示的输入框)*/
					urlGetCity:'',/*加载城市数据url*/
					focusFlag : false /*是否启动得到焦点失去焦点事件，默认不启动*/
			 };
			 var opts = $.extend(true,{},defaults,opt);
			 var that = this;
			 this.totalObj = $(this);
			 this.divData  = null;
			 if(this.totalObj.lenghth == 0){
				 console && console.log('调用地区选择下拉框插件的全局对象不存在，请检查');
				 return;
			 }
			 this.init=function(opts){
				 this.bindEvent();
				 this.initElement();
			 };
			 /*自动生成input输入框*/
			 this.initElement=function(){
				 var thisShowInput = that.totalObj.find('input[name="'+opts.showName+'"]');//查找数据列表
				 var thisDiv = that.totalObj.find('div');
				// thisDiv.is(':visible') &&　thisDiv.hide();
				 var dataKey = thisShowInput.attr('data-key'); //实际传递的值
				 var dataval = thisShowInput.val();
				 if (!dataval) {
				 	dataval = '';
				 };
				 if(!dataKey){
					 dataKey=''; 
				 }
				 var transInput = thisShowInput.next('input[name="'+opts.transName+'"]');
				 if(transInput.length == 0){
					// var thisShowInput = that.totalObj.find('.img').find('input[name="'+opts.showName+'"]');

					 var inputName = opts.transName || thisShowInput.attr('trans-name');
					 var transInput = '<input type="hidden" name="'+inputName+'" id="'+inputName+'" value="'+dataKey+'" data-val="'+dataval+'"/>'; 
					 thisShowInput.after(transInput);
				 }else{
					 transInput.val(dataKey).attr('data-val',thisShowInput.val());
				 }
				 
				 //初始化默认值
				 if(typeof(thisShowInput.attr('data-default')) != 'undefined' && thisShowInput.val() == ''){
					 thisShowInput.val(thisShowInput.attr('data-default'));
				 }
				 
				 // that.totalObj.find('ul').hide()
				 //初始化ul元素class
				 thisDiv.addClass('cls_select_auto_create');
			 }
			 this.bindEvent = function(){
				 /*点击img时触发的事件*/
				 that.totalObj.on('click','img,.img',function(){
					 var data = that.getData();
					 var thisDiv = that.totalObj.find('div');
					 if(thisDiv.is(':visible')){
						 thisDiv.hide();
					 }else{ 
						// var value = thisDiv.prev().prev('span').find('input').attr('data-key');
						// thisDiv.find('li[data-key="'+value+'"]').css('color','#f9701f').siblings().css('color','');
						 thisDiv.show($('.cls_select_auto_create').not(this).hide());
					 }
					return false;
				 });
				 
				 /*得到焦点、失去焦点处理*/
				 opts.focusFlag && that.totalObj.on({
					 'focus':function(){
						 var obj = $(this);
						 //初始化默认值
						 if(typeof(obj.attr('data-default')) != 'undefined' && obj.attr('data-default') == obj.val()){
							 obj.val('');
						 }
					 },
					 'blur':function(){
						 var obj = $(this);
						 //初始化默认值
						 if($.trim(obj.val()) == '' && typeof(obj.attr('data-default')) != 'undefined'){
							 obj.val(obj.attr('data-default'));
						 }
					 }
				 },'input[name="'+opts.showName+'"]');
				 
				 /*点击显示input时触发的事件*/
				 that.totalObj.on('input','input[name="'+opts.showName+'"]',function(){
					 var data = that.getData();
					 var thisDiv = that.totalObj.find('div');
					 if(thisDiv.is(':hidden')){
						 thisDiv.show();
					 }else{ 
						// var value = thisDiv.prev().prev('span').find('input').attr('data-key');
						// thisDiv.find('li[data-key="'+value+'"]').css('color','#f9701f').siblings().css('color','');
						// thisDiv.show();
					 }
					return false;
				 });
				 /*点击li时触发的事件*/
				 that.totalObj.on('click','li',function(){
					 var thisObj = $(this);
					 var dataval = thisObj.attr('data-val');
					 var datakey = thisObj.attr('data-key');
					// var thisDiv  = thisObj.parent().parent();
					// thisDiv.prev().prev('span').find('input').val(dataval).attr('data-key',datakey);
					 thisObj.parent().parent().hide();
					 that.totalObj.find('input[name="'+opts.showName+'"]').val(dataval);
					 that.totalObj.find('input[name="'+opts.transName+'"]').val(datakey).attr('data-val',dataval);
				 });
				 
				//点击页面其他区域关闭下拉框
				$(document).off('click').on('click',function(event){
					if($('.cls_select_auto_create').is(':visible')){
						$('.cls_select_auto_create').hide();
					}					
				});
			 }
			 this.getData = function(){
				 var kwd= $('input[name="'+opts.showName+'"]').val();
				 $.get(opts.urlGetCity,{term:kwd},function(rst){
					 if(rst && rst.length>0){
						 that.setData(rst);
					 }else{
					 	that.totalObj.find('ul').html('');
						 console && console.log('后端未获取到数据');
						 console && console.log(rst);
					 }
				 });
			 },
			 this.setData = function(arr){
				 if(arr && arr.length>0){
					 var liArr = '';
					 $.each(arr,function(i,vo){
						 liArr += '<li data-key="'+vo['citycode']+'" data-val="'+vo['citynativename']+'">'+vo['citynativename']+'</li>';
					 });
					 that.totalObj.find('ul').html(liArr);
					 //that.totalObj.find('div').show();
				 }
			 }
			 this.init();
		}/*hr地区下拉选择框插件end*/
	 });
	 
	 /**
	  * 给jQuery类添加静态扩展
	  */
	 $.extend({
		 /*打开回调函数*/
		  openFnBind:function(opts){
			  //console.log('打开滚动条',opts.scrollObj)
			    //打开滚动条
			    if(opts.scrollObj){
			    	console.log(opts.scrollObj)
			    	opts.scrollObj.show();
			    } 
				if(opts.openFn && typeof(opts.openFn == 'function')){
					opts.openFn(opts.openParam);
				}
		  },
		  /*关闭回调函数*/
		  closeFnBind:function(opts){
			  //console.log('关闭滚动条',opts.scrollObj)
			  //关闭滚动条
			  opts.scrollObj && opts.scrollObj.hide();
			  if(opts.closeFn && typeof(opts.closeFn == 'function')){
				 opts.closeFn(opts.closeParam);
			  }
		  },
		  /**
		   * 自动验证input输入框的focus、blur事件
		   */
		  inputAutoValid:function(arr){
				for(var i=0,len = arr.length;i<len;i++){
					var objProperty = arr[i];
					var thisObjF = $('input[name="'+objProperty.name+'"]');
					
					//绑定事件处理
					thisObjF.on({
						'focus':function(){
							var thisObj = $(this);
							var ztips = $.ztipsGet(thisObj);
							var ztipsArr = $.ztipsGetArr(thisObj);
							var val = $.trim(thisObj.val());
							//if($.trim(thisObj.val()) == thisObj.attr('ztips')){/*ztips*/
							if($.inArray(val,ztipsArr) != -1){/*ztips*/
								thisObj.val('').css('color','');
							}
						},
						'blur' :function(){
							var thisObj = $(this);
							var ztips = $.ztipsGet(thisObj);							
							if(!$.trim(thisObj.val())){ 
								thisObj.val(ztips).css('color','#808080');
							}
						}
					});
					var ztips = $.ztipsGet(thisObjF);
					//自动赋值处理
					thisObjF.val(ztips).css('color','#808080');
					
				}
			},
			/*把提示信息追加到ztips堆栈中*/
			ztipsSet:function(jObj,val){
				if(!jObj.attr('ztips')){
					jObj.attr('ztips',val);
				}else{
					var old = jObj.attr('ztips');
					var oldArr = old.split('~ `');
					jObj.attr('ztips',old+'~ `'+val).attr('index',oldArr.length);
				}
				jObj.val(val);
			},
			/*从ztips堆栈中获取当前默认提示信息*/
			ztipsGet:function(jObj){
				var currVal = '';
				var old = jObj.attr('ztips');
				if(old){
					var oldArr = old.split('~ `');
					var index  = jObj.attr('index');
					if(!index){
						index = 0;
					}
					currVal = oldArr[index];
				}
				//jObj.val(currVal);
				return currVal;
			},
			/*从ztips堆栈中获取所有提示信息数组*/
			ztipsGetArr:function(jObj){
				var ztips = [];
				var old = jObj.attr('ztips');
				if(old){
					 ztips = old.split('~ `');
				}
				return ztips;
			},
			
			/*鼠标点击弹出层区域外时，关闭此弹出层*/
			closeDiv:function(opts){
				var defaults = {
						closedSel:'', //要被关闭的选择器
						noActClass:'' //当遇到这些class时，不做关闭操作
				};
				var setting = $.extend(true,{},defaults,opts);
				//点击页面其他区域关闭搜索框弹出层
				$('body').on('click',function(event){
					var e = event || window.event;
					var elem = e.srcElement||e.target; 
					if($(elem).is(setting.closedSel) || $(elem).parents(setting.closedSel).length>0 ){
						return ;
					}
					$(setting.closedSel).hide();
				});
			},
			
			/*职能选择复选框插件*/
	        CheckBoxPosition: {
	            selector: 'INPUT',/*复选框选择器*/
	            totalObj: '',/*弹出层全局对象*/
	            name: '',/*传递值的隐藏input对象*/
	            init: function (opts) {
	                if (typeof opts == 'object') {
	                    if (opts.selector) {
	                        this.selector = opts.selector;
	                    }
	                }

	                this.loadte(opts);
	                this.bindEvent(opts);
	                this.setDefaultCheck(opts);
	            },
	            loadte: function (opts) {
	                $(this.selector).each(function (i) {
	                    var wrap = $('<i/>').attr('class', 'myphoto_ttwo');
	                    var elementParent = $(this).parent();
	                    var input = $(this).clone();
	                    $(input).off('click').on('click', function () {
	                        //验证选中个数问题三级选中个数问题
	                        if(opts.totalObj.find(opts.selector+':checked').size()>opts.totalCheckNum){
	                        	$(this).prop('checked',false);
	                        	$.global_msg.init({msg:'选中职能分类数不能超过'+opts.totalCheckNum+'个',btns:true});
	                        	return;
	                        }
	                    	var iObj =  $(this).parent();
	                    	var bObj = iObj.next();
	                        if ($(this).prop('checked') == true) {
	                        	iObj.addClass('active');
	                        	bObj.addClass('active');
	                        } else {
	                        	iObj.removeClass('active');
	                        	bObj.removeClass('active');
	                        }
	                        //处理点击三级菜单后二级菜单的变色问题
	                        var cls_level2_single = $(this).closest('.cls_level2_single');
	                        var levelCheckedCount = cls_level2_single.find('input:checked').size();
	                        if(levelCheckedCount>0){
	                        	cls_level2_single.find('.cls_level2_span').addClass('active');
	                        }else{
	                        	cls_level2_single.find('.cls_level2_span').removeClass('active');
	                        }	
	                    })
	                    if ($(this).parent('i').is('.myphoto_ttwo')) {/*updated by zp*/
	                        $(this).replaceWith(input);
	                        return true;
	                    } else {
	                        $(this).replaceWith(wrap.append(input));
	                    }
	                });
	            },
	            bindEvent: function(opts){
	            	var that = this;
	            	/*对二级元素绑定事件处理*/
	            	$('.cls_level2_em').click(function(){
	            		var cls_level2_single = $(this).closest('.cls_level2_single');//获取此二级整个对象
	            		var span = $(this).parent();
	            		var ul   = cls_level2_single.find('.cls_level2_ul');/*获取此二级对象下面的三级对象*/
	            		if(ul.is(':visible')){
	            			$(this).removeClass('ITchild_jianhao');//显示+号
	            			ul.hide();
	            		}else{
	            			ul.show();
	            			$(this).addClass('ITchild_jianhao');//显示-号	
	            			//同时关闭其他所有打开三级子类对象
	            		 	var otherObjs = $('.cls_level2_single').not(cls_level2_single);
	            			otherObjs.find('.cls_level2_ul:visible').hide();
	            		}
	            		span.toggleClass('active',cls_level2_single.find('.handClassPosition:checked').length>0);
	            		
	            	});
	            	/*保存按钮事件*/
	            	opts.totalObj.on('click','.cls_btn_save',function(){
	            		var allCheckInput = opts.totalObj.find(opts.selector+':checked');
	            		var count = allCheckInput.size();
	            		//验证选中个数问题三级选中个数问题
                        if(count>5){
                        	$.global_msg.init({msg:'选中职能分类数不能超过'+opts.totalCheckNum+'个',btns:true});
                        	return;
                        }
                        if(count == 0){
                        	$.global_msg.init({msg:'请先选择职能',btns:true});
                        	return;
                        }
                        var valStr = '';
                        var valName = '';
                        $.each(allCheckInput,function(index){
                        	if(index === 0){
                        		valStr = $(this).val();
                        		valName = $(this).attr('data-name');
                        	}else{
                        		valStr += ','+$(this).val();
                        		valName += '+'+$(this).attr('data-name');
                        	}
                        })
                        opts.totalObj.find('input[name="'+opts.nameShow+'"]').val(valName); //被选中的显示的名称
                        opts.totalObj.children('input[name="'+opts.nameTrans+'"]').val(valStr);//被选中的隐藏的id
                        opts.totalObj.children('div').hide();
                        
                        $.closeFnBind(opts);
	            	});
	            	/*不限事件、关闭事件*/
	            	opts.totalObj.on('click','.cls_btn_any,.cls_btn_close',function(event){
	            		if($(event.target).hasClass('cls_btn_any')){/*不限*/
	            			opts.nolimit = true;/*不限*/
	            			that.setDefaultCheck(opts);
	            			opts.totalObj.find('input[name="'+opts.nameShow+'"]').val('不限');
	            			opts.totalObj.children('input[name="'+opts.nameTrans+'"]').val('');
	            		}
	            		opts.totalObj.children('div').hide();//隐藏弹出层
	            		//console.log(opts.totalObj.children('div'),opts.totalObj)
	            		
	            		 $.closeFnBind(opts);
	            	});
	            },
	            
	            /*打开弹出层时默认选择的分类以及颜色变化初始化操作*/
	            setDefaultCheck: function(opts){
	            	var valStr = $.trim(opts.totalObj.children('input[name="'+opts.nameTrans+'"]').val());
	            	if(!valStr)return;
	            	var valArr = valStr.split(',');
	            	$.each(valArr,function(index,val){
	            		val = $.trim(val);
	            		if(!val){
	            			return true;/*等效于continue*/
	            		}
	            		// input.prop('checked',true);
	            		var input = opts.totalObj.find('#'+val);
	            		//input.prop('checked',true);
                    	var iObj =  input.parent();
                    	var bObj = iObj.next();
                       // iObj.addClass('active');
                       // bObj.addClass('active');
	            		if(opts.nolimit && opts.nolimit==true){
		            		input.prop('checked',false);
		                    iObj.removeClass('active');
		                    bObj.removeClass('active');
		                  //处理点击三级菜单后二级菜单的变色问题
	                        input.closest('.cls_level2_single').find('.cls_level2_span').removeClass('active');
	            		}else{
		            		input.prop('checked',true);
		                    iObj.addClass('active');
		                    bObj.addClass('active');
		                  //处理点击三级菜单后二级菜单的变色问题
	                        input.closest('.cls_level2_single').find('.cls_level2_span').addClass('active');
	            		}                        
	            	});
	            }
	        },
	        
	        /*行业选择、专业选择复选框插件*/
	        CheckBoxIndustry: {
	            selector: 'INPUT',/*复选框选择器*/
	            totalObj: '',/*弹出层全局对象*/
	            name: '',/*传递值的隐藏input对象*/
	            scrollObj: null,
	            init: function (opts) {
	                if (typeof opts == 'object') {
	                    if (opts.selector) {
	                        this.selector = opts.selector;
	                    }
	                    if (opts.scrollObj) {
	                        this.scrollObj = opts.scrollObj;
	                    }
	                }
	                this.loadte(opts);
	                this.bindEvent(opts);
	                this.setDefaultCheck(opts);
	            },
	            loadte: function (opts) {
	                $(this.selector).each(function (i) {
	                    var wrap = $('<i/>').attr('class', 'myphoto_ttwo');
	                    var elementParent = $(this).parent();
	                    var input = $(this).clone();
	                    $(input).off('click').on('click',function () {
	                 	   //验证选中个数问题三级选中个数问题
	                        if($(opts.selector+':checked').size()>opts.totalCheckNum){
	                        	$(this).prop('checked',false);
	                        	$.global_msg.init({msg:'选中行业分类数不能超过'+opts.totalCheckNum+'个',btns:true});
	                        	return;
	                        }
	                    	var iObj =  $(this).parent();
	                    	var bObj = iObj.next();
	                        if ($(this).prop('checked') == true) {
	                        	iObj.addClass('active');
	                        	bObj.addClass('active');
	                        } else {
	                        	iObj.removeClass('active');
	                        	bObj.removeClass('active');
	                        }
	                    })
	                    if ($(this).parent('i').is('.myphoto_ttwo')) {/*updated by zp*/
	                        $(this).replaceWith(input);
	                        return true;
	                    } else {
	                        $(this).replaceWith(wrap.append(input));
	                    }
	                });
	                /*二级分类添加滚动条*/
	           		//$('.hr_category_scoll').height(opts.scrollHeight).niceScrollMe();
	            },
	            bindEvent: function(opts){
	            	var that = this;
	            	/*保存按钮事件*/
	            	opts.totalObj.on('click','.hrcategories_baocun',function(){
	            		var allCheckInput = opts.totalObj.find(opts.selector+':checked');
	            		var count = allCheckInput.size();
	            		//验证选中个数问题三级选中个数问题
	                    if(count>5){
	                    	$.global_msg.init({msg:'选中行业分类数不能超过'+opts.totalCheckNum+'个',btns:true});
	                    	return;
	                    }
	                    if(count == 0){
	                    	$.global_msg.init({msg:'请先选择行业分类',btns:true});
	                    	return;
	                    }
	                    var valStr = '';
	                    var valName = '';
	                    $.each(allCheckInput,function(index){
	                    	if(index === 0){
	                    		valStr = $(this).val();
	                    		valName = $(this).attr('data-name');
	                    	}else{
	                    		valStr += ','+$(this).val();
	                    		valName += '+'+$(this).attr('data-name');
	                    	}
	                    })
	                    opts.totalObj.find('input[name="'+opts.nameShow+'"]').val(valName); //被选中的显示的名称
	                    opts.totalObj.children('input[name="'+opts.nameTrans+'"]').val(valStr);//被选中的隐藏的id
	                    opts.totalObj.children('div').hide();
	                    $.closeFnBind(opts);
	            	});
	            	/*不限事件、关闭事件*/
	            	opts.totalObj.on('click','.hr_categary_no,.hrcategories_close',function(event){
	            		if($(event.target).hasClass('hr_categary_no')){/*不限*/
	            			opts.nolimit = true;/*不限*/
	            			that.setDefaultCheck(opts);
	            			opts.totalObj.find('input[name="'+opts.nameShow+'"]').val('不限');
	            			opts.totalObj.children('input[name="'+opts.nameTrans+'"]').val('');
	            		}
	            		opts.totalObj.children('div').hide();//隐藏弹出层
	            		 $.closeFnBind(opts);
	            	});
	            },
	            
	            /*打开弹出层时默认选择的分类以及颜色变化初始化操作*/
	            setDefaultCheck: function(opts){
	            	var valStr = $.trim(opts.totalObj.children('input[name="'+opts.nameTrans+'"]').val());
	            	if(!valStr)return;
	            	var valArr = valStr.split(',');
	            	$.each(valArr,function(index,val){
	            		val = $.trim(val);
	            		if(!val){
	            			return true;/*等效于continue*/
	            		}
	            		var input = opts.totalObj.find('#'+val);
	                	var iObj =  input.parent();
	                	var bObj = iObj.next();
	            		if(opts.nolimit && opts.nolimit==true){
		            		input.prop('checked',false);
		                    iObj.removeClass('active');
		                    bObj.removeClass('active');
	            		}else{
		            		input.prop('checked',true);
		                    iObj.addClass('active');
		                    bObj.addClass('active');
	            		}
	            	});
	            }
	        },
	        
	        /**
	         * 在页面中生成隐藏的iframe
	         * @param frameName 隐藏的iframe id和name的名称，可不传递，默认为hidden_frame
	         */
	        getIframe:function(iframeName){
	        	var iframeName = iframeName || 'hidden_frame';
	        	if(typeof($('#'+iframeName).attr('src')) == 'undefined'){
	        		var iframeHtml ='<iframe id="'+iframeName+'" name="'+iframeName+'"  style="display:none;" id="hidden_frame" width="100%" height="100%"></iframe>';
	        		$('body').append(iframeHtml);
	        	}
	        },
	        
	        /**
	         * 选择地区插件
	         */
	        loadRegion:{
	        	selInput: 'input',
	        	nameTrans: 'regionHidden',/*隐藏的传递地区值的对象名称*/
	        	selTotal: null,
	        	selReco: null,
	        	selHot: null,
	        	selHistory: null,
	        	selSearch: null,
	        	closeOther:null,
	        	init: function(opts){
	                if (typeof opts == 'object') {
	                    if (opts.selInput) {
	                        this.selInput = opts.selInput;
	                    }
	                    if (opts.selTotal) {
	                        this.selTotal = opts.selTotal;
	                    }
	                    if (opts.selReco) {
	                        $(opts.selReco).addClass('plugin_auto_hide');
	                    }
	                    if (opts.selSearch) {
	                    	 $(opts.selSearch).addClass('plugin_auto_hide');
	                    }
	                    if(opts.nameTrans){
	                    	this.nameTrans = opts.nameTrans;
	                    }
	                    if(opts.closeOther){
	                    	this.closeOther = opts.closeOther;
	                    }
	                }
	                gUrlLoadRegion = gUrlLoadRegion.replace('.html','');
	                this.bindEvent(opts);
	                this.generalInput(opts);
	        	},
	        	/*输入框得到焦点时加载*/
	        	focusLoad:function(opts){
        			$(opts.selSearch+':visible').hide();
        			$(opts.selReco+':hidden').show();
	        		var that = this;
	        		$.get(gUrlLoadRegion,{'isHot':1}, function(rst){
	        			 that.generalUl(rst,opts.selHot); //热门推荐列表
	        			 var cookieData = $.oradtCookie.getObj(opts.selTotal);
	        			 if(cookieData){
		        			// console.log(cookieData)
		        			 that.generalUl(cookieData,opts.selHistory); //历史记录列表
	        			 }
	        			// console.log(opts.selHot,opts.selHistory)
	        		});
	        	},
	        	/*输入内容时加载*/
	        	enterLoad:function(opts){
	       			$(opts.selSearch+':hidden').show();
        			$(opts.selReco+':visible').hide();
	        		var that = this;
	        		$.get(gUrlLoadRegion,{'term':opts.kwd}, function(rst){
	        			that.generalUl(rst,opts.selSearch);
	        		});
	        	},
	        	/*绑定事件*/
	        	bindEvent:function(opts){
	        		var that = this;
	        		//输入框得到焦点时
	        		$(this.selTotal).on('focus',this.selInput,function(){
	        			inputAutoValid([{name:$(that.selInput).attr('name')}]);
	        			var kwd = $.trim($(that.selInput).val());
	        			if(kwd == '' || kwd == $(that.selInput).get(0).defaultValue){
	        				that.focusLoad(opts);
	        			}
	        		});
	        		/*输入框值变化时,这块注意点，出过问题	$(this.selTotal).on('input',$(this.selInput),*/
	        		$(this.selTotal).on('input',that.selInput,function(e){
	        			var kwd = $.trim($(that.selInput).val());
	        			//alert(kwd+'-'+$(that.selInput).get(0).defaultValue)
	        			if(kwd != $(that.selInput).get(0).defaultValue){
		        			if(kwd == '' || kwd == $(that.selInput).get(0).defaultValue){
		        				that.focusLoad(opts);
		        			}else{
		        				opts.kwd = kwd;
		        				that.enterLoad(opts);
		        			}
	        			}
	        		});
	        		/*点击li结构时进行赋值操作*/
	        		$(this.selTotal).on('click','li',function(){
	        			var item = $(this);
	        			var showValue = item.attr('data-id');
	        			var showName = item.attr('data-name');
	        			$(that.selInput).val(showName);
	        			 $('input[name="'+that.nameTrans+'"]').val(showValue).attr({'data-name':showName});
	        			// console.log('自动赋值'+that.nameTrans,$('input[name="'+that.nameTrans+'"]'));
	        		});
	    			//点击页面其他区域关闭下拉框
	    			$(document).on('click',function(event){/*.off('click')*/
	    				if($(event.target).not(that.selInput).length>0){
	    					$('.plugin_auto_hide').hide();
	    				}
	    				if(that.closeOther){
		    				var otherCloses = that.closeOther.split(';');
		    				$.each(otherCloses,function(index,obj){
		    					//关闭其他弹出层
			    				if(obj && $(obj).size()>0 && $(obj).is(':visible')){
			    					$(obj).hide();
			    				}
		    				});
	    				}	    			
	    			});
	        	},
	        	/*生成UL结构*/
	        	generalUl:function(arr,selUl){
	        		var str = '';
        			for(var i in arr){
        				var obj = arr[i];
        				str +='<li data-id="'+obj.citycode+'" data-name="'+obj.cityname+'">'+obj.cityname+'</li>';
        			}
        			if(selUl && $(selUl).size() == 1){
        				$(selUl).html(str);
        			}else{
        				return str;
        			}        			
	        	},
	        	/*自动生成隐藏的input传值对象*/
	        	generalInput:function(opts){
					 /*自动生成传递给后端值的input框*/	
	        		var thisShowInput = $(this.selInput);
					 var input = $(this.selInput).next('input:hidden');
					 if(input.length == 0){						 
						 var dataKey = thisShowInput.attr('data-key'); //实际传递的值
						 var dataName = thisShowInput.val();
						 if(!dataKey){
							 dataKey=''; 
						 }
						 var inputName = opts.nameTrans || thisShowInput.attr('data-name');
						 var input='<input type="hidden" name="'+inputName+'" id="'+inputName+'" value="'+dataKey+'" data-name="'+dataName+'"/>'; 
						 $(this.selInput).after(input);
					 }
	        	}
	        },
	        
	        /*设置cookie存储值*/
	        oradtCookie:{
	        	opts:{
		        	len:10,//定义历史记录存放关键字数量
		        	cookieSpe:'/#'  //定义cookie中存放关键字分割符号
	        	},
	        	/*初始化并合并参数*/
	        	init:function(options){
	        		this.opts = $.extend(true,{},this.setting,options);
	        	},
	        	/*设置cookie*/
	        	set:function(key,value,options){
	        		this.init(options);
	        		if(!value)return;
		        	if(typeof value === "object"){
		        		this._setObj(key,value);
		        	}

		        },
		        _setObj:function(key,value){
		        	var kwdStr = $.cookie(key);
		        	var exists = false;
		        	if(kwdStr){
		        		var objs =  JSON.parse(kwdStr);//由JSON字符串转换为JSON对象
		        		for(var i in objs){
			        		//if(objs[i].hasOwnProperty(value.citycode)){
			        		if(objs[i]['citycode'] == value.citycode){
			        			exists = true;
			        			break;
			        		}
			        	}
		        	}else{
		        		objs = [];
		        	}
		        	if(!exists){
		        		objs.unshift(value);
		        	}else{//已经存在，直接返回
		        		return;
		        	}
		        	if(objs.length>this.opts.len){
		        		objs = objs.slice(0,this.opts.len);
		        	}
		        	var kwdStr =JSON.stringify(objs);;
		        	$.cookie(key,kwdStr,{expires:36600,path:"/"});

		        },
		        setStr:function(){
	        		this.init(options);
		        	if($.trim(value) == '')return;
		        	var kwdStr = $.cookie(key);
		        	var kwdArr = kwdStr ? kwdStr.split(this.opts.cookieSpe):[];
		        	//判断关键字是否存在与cookie中，若存在直接返回
		        	var len = kwdArr.length;
		        	var exists = false;
		        	for(var i=0; i<len; i++){
		        		if(kwdArr[i] == value){
		        			exists = true;
		        			break;
		        		}
		        	}
		        	if(!exists){
		        		kwdArr.unshift(value);
		        	}else{//已经存在，直接返回
		        		return;
		        	}
		        	if(len>=this.opts.cookieMaxLen){
		        		kwdArr = kwdArr.slice(0,this.opts.cookieMaxLen);
		        	}
		        	kwdStr = kwdArr.join(this.opts.cookieSpe);
		        	$.cookie(key,kwdStr,{expires:7,path:"/"});
		        },
		        get:function(key){
		        	return $.cookie(key);
		        },
		        getObj:function(key){
		        	var data = $.cookie(key);
		        	 if(data){
		        		 data =  JSON.parse(data);
		        	 }else{
		        		 data = [];
		        	 }
		        	return data;
		        }
	     },
	     
	     /*验证提示信息*/
	     showMsg: function(filedName,status,msg){
	    	 var fieldObj = $("[name='" + filedName + "']");
	    		if(status != 0){
	    			$.showError(fieldObj,filedName,msg);
	    		}else{
	    			$.showRight(fieldObj,filedName);
	    		}
	    },
	     /*显示错误信息*/
         showError: function (fieldObj, filedName, warnInfo) {
             fieldObj.css("background", "#FFDFDD");
             var tipObj = $("#" + $.tipname(filedName));
             if (tipObj.length > 0)
                 tipObj.remove();
             var tipPosition = null;
             if (fieldObj.next().length > 0) {
                 var nextAll = fieldObj.nextAll();
                 tipPosition = nextAll.eq(nextAll.length - 1);
             } else {
                 tipPosition = fieldObj.eq(fieldObj.length - 1)
             }
             if ("input_mail" != filedName) {
                 tipPosition.after("<span class='tip' style='color:#f9701f;display: block;font-size: 14px;' id='" + tipname(filedName) + "'> " + warnInfo + " </span>");
             }
         },
         /*显示正确信息*/
         showRight: function (fieldObj, filedName) {
             if ("check_mail" != filedName) {
                 fieldObj.css("background", "#CCFFCC");
             }
             var tipObj = $("#" + $.tipname(filedName));
             if (tipObj.length > 0)
                 tipObj.remove();
             var filedNamea;
             var tipPosition = fieldObj.next().length > 0 ? fieldObj.nextAll().eq(this.length - 1) : fieldObj.eq(this.length - 1);
             // if(filedName=="check_mail"){filedNamea='';}else{filedNamea='正确';}
             //   if(filedName!="bizname"){tipPosition.after("<span style='color:#0C ; display: block;margin:8px 0 0 110px;font-size: 14px  ' id='"+tipname(filedName)+"'>" +filedNamea+" </span>");}
         },
         /*生成唯一对象*/
         tipname: function (namestr) {
             return "tip_" + namestr.replace(/([a-zA-Z0-9])/g, "-$1");
         }
	 });
	 
})(jQuery);

