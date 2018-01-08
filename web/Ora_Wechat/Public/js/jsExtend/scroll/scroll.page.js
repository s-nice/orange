 $.fn.maskMe = function() {
		var me = $(this);
		var that = this;
		var _position = me.parent().css('position');
		that.mask = $('<div id="maskMeoo"></div>');
		that.init = function() {
			if (_position == 'static') {
				me.parent().css('position', 'relative').attr('data-position', _position);
			}
			var maskpath =   JS_PUBLIC+'/images/mask_loading1.gif';
			var img = $('<img src="' + maskpath + '"/>');
			img.css({
				'position' : 'relative',
				'top' : (me.outerHeight(true)-32)/2
			});
			that.mask.append(img);
			console.log(me);
			if(me && me.length > 0){
				var style = {
					'width' : me.outerWidth(true),
					// 'height' : me.outerHeight(true),
					'height':'88px',
					'position' : 'absolute',
					'opacity' : '0.5',
					'background' : '#ffffff',
					'top' : me.position().top,
					'left' : me.position().left,
					'z-index' : '99',
					'text-align' : 'center',
					'border-radius' : me.css('border-top-left-radius')
				};
				if ($.support.msie && $.support.version <= 8) {
					style = {
						'width' : me.width(),
						// 'height' : me.height(),
						'height':'88px',
						'position' : 'absolute',
						'filter' : 'alpha(opacity=50)',
						'background' : '#ffffff',
						'top' : me.position().top,
						'left' : me.position().left,
						'z-index' : '99',
						'text-align' : 'center',
						'border-radius' : me.css('border-radius')
					};
				}
			}else{
				var style = {}
			}


			that.mask.css(style);
			me.before(that.mask);
		};
		that.closeMaskMe = function(e) {
			var _this = $(this);
			if (_this.parent().attr('data-position')) {
				_this.parent().removeAttr('data-position');
			}
			that.mask.remove();
		}
		that.init();
		return that;
	};

function Scroll(){}
 Scroll.prototype = {
			scrollToDown : function(sel) {
				var me;
				if ( typeof sel == "string") {
					me = $(sel);
				} else if ( sel instanceof jQuery) {
					me = sel;
				} else {
					return false;
				}
				var offsetH = me.children().outerHeight(true) - (me.height() + parseInt(me.css("padding-top")) + parseInt(me.css("padding-bottom"))) - 1
				if (me.scrollTop() >= (offsetH)) {
					return true;
				} else {
					return false;
				}
			},
			scrollAjax : function(scbj, scLimH, scAjax, scrollOpts) {//scbj-要绑定滚动条的对象   scLimH-指定超出高度多少后添加滚动条   scAjax-ajax的事件
				//console.log(scbj)
				var that = this;
				var scrollnr = scbj;
				if(scrollnr && scrollnr.length == 0){
					return;
				}
				scrollnr.css({
					'position':'relative'
				})
				//设置滚动条对象
				var scrollWrap = scrollnr.find('>.scrollWrap');
				if (scrollWrap && scrollWrap.length == 0) {
					scrollnr.wrapInner('<div class="scrollWrap"></div>');
					//包裹内部对象
				}
				scbj.removeData('scData');
				scbj.data('scData', scAjax);
				var child = scrollnr.children()//.addClass('scrollWrap');
				//that._Ajax = scAjax;
				var _page = 1;
				if ($.type(scbj.data('scData').data) == 'object') {
					_page = parseInt(scbj.data('scData').data.page);
				} else if ($.type(scbj.data('scData').data) == 'string') {
					var reg = /page=\d+&?/g;
					var reg2 = /[page=]&?/g;
					_page = parseInt(scbj.data('scData').data.match(reg)[0].replace(reg2, ''));
				}
				//设置参数是否可以滚动
				scrollnr.attr('data-canLoad', 'true');

				//设置当前要滚动的次数
				scrollnr.attr('data-times', _page + 1);

				//设置当前要申请的页数
				scrollnr.attr('data-curpage', _page + 1);

				//if (scrollnr.outerHeight() >= scLimH) {//判断滚动块的高度是否大于制定高度，如果大于则
					scrollnr.height(scLimH - parseInt(scrollnr.css("padding-top")) - parseInt(scrollnr.css("padding-bottom")));
					//设置滚动块新高度
					var nice = scrollnr.niceScrollMe(scrollOpts);
					//添加滚动条
					//var SubMargin = parseInt(child.children().eq(0).css('margin-top'))+parseInt(child.children().eq(0).css('margin-bottom'));
					//var SubMargin = parseInt(child.children().eq(0).css('margin-top'));
					var _mask;

					var coverSuccess = {//重新定义ajax的成功事件
						success : function(data) {//updated by zhangpeng
							//if ((data.success && data.mark == 1) || (data.success && data.mark == undefined)) {
							if ((data.msg && data.status == 1) || (data.status && data.status == undefined)) {
								scbj.data('scData').success.call(this, data);
								//调用传参ajax的原始success函数
								var _curP = parseInt(scrollnr.attr('data-curpage')) + 1
								scrollnr.attr('data-curpage', _curP);
								scrollnr.attr('data-times', _curP);
							} else {
								scrollnr.attr('data-times', (parseInt(scrollnr.attr('data-times')) + 1));
							}
							scrollnr.attr('data-canLoad', 'true');
							if (_mask) {
								_mask.closeMaskMe();
								//关掉遮罩
							}
						}
					};
					var coverError = {
						error : function() {
							scbj.data('scData').error.call(this);
							//调用传参的ajax的原始error方法
						}
					};
					var empty = {};
					var settings = $.extend(true, empty, scbj.data('scData'), coverSuccess, coverError);
					//合并传参和默认配置
					nice.scrollend(function(info) {
						var scRelH = scrollnr.find('.scrollWrap').outerHeight(true) - scrollnr.height() - parseInt(scrollnr.css("padding-top")) - parseInt(scrollnr.css("padding-bottom"));//+SubMargin;
						var endY = info.end.y;
						
						if (endY - scRelH >= 0) {
							if (scrollnr.attr('data-canLoad') == 'true') {
								scrollnr.attr('data-canLoad', 'false');
								if (scrollnr.attr('data-times') == scrollnr.attr('data-curpage')) {
									_mask = scrollnr.maskMe();
									//打开遮罩
								}
								if ($.type(settings.data) == 'object') {
									settings.data.page = scrollnr.attr('data-curpage');
								} else if ($.type(settings.data) == 'string') {
									var arr = settings.data.split('&');
									var p = 'page';
									$.each(arr, function(i, n) {
										if (n.search(p) != -1) {
											arr[i] = p + '=' + scrollnr.attr('data-curpage');
										}
									});
									settings.data = arr.join('&');
								}
								if (scrollnr.attr('data-times') <= scrollnr.attr('data-curpage')) {
									$.ajax(settings);
								}
								//调用新配置的ajax
							}

						};
						if ($.type(settings.data) == 'object') {
							settings.data.page = scrollnr.attr('data-curpage');
						} else if ($.type(settings.data) == 'string') {
							var arr = settings.data.split('&');
							var p = 'page';
							$.each(arr, function(i, n) {
								if (n.search(p) != -1) {
									arr[i] = p + '=' + scrollnr.attr('data-curpage');
								}
							});
							settings.data = arr.join('&');
						};
					});
				//}

				/*
				 scrollnr.attr('data-canLoad','true');//设置参数是否可以滚动
				 scrollnr.attr('data-times',2);//设置当前要滚动的次数
				 scrollnr.attr('data-curpage',2);//设置当前要申请的页数
				 if(scrollnr.outerHeight() >= scLimH){//判断滚动块的高度是否大于制定高度，如果大于则
				 scrollnr.height(scLimH - parseInt(scrollnr.css("padding-top"))-parseInt(scrollnr.css("padding-bottom")));//设置滚动块新高度
				 var nice = scrollnr.niceScrollMe();//添加滚动条
				 var SubMargin = parseInt(child.children().eq(0).css('margin-top'))+parseInt(child.children().eq(0).css('margin-bottom'));
				 var _mask;

				 var empty = {};
				 scrollnr.off('scroll').on('scroll',that._Ajax,function(event){//滚动事件绑定
				 //console.log(event.data)
				 var me = $(this);
				 var _ajax = event.data;

				 var coverSuccess = {//重新定义ajax的成功事件
				 success:function(data){
				 var data = this.data;
				 if(data.mark==1){
				 _ajax.success.call(this,data);//调用传参ajax的原始success函数
				 scrollnr.attr('data-curpage',(parseInt(scrollnr.attr('data-curpage'))+1));
				 scrollnr.attr('data-times',scrollnr.attr('data-curpage'));
				 }else{
				 if(scrollnr.attr('data-times') > scrollnr.attr('data-curpage')){
				 cloudWindowCtrl.open_window('alert', {text:"已经没有数据了", callback:function(window_item){}});
				 }
				 scrollnr.attr('data-times',(parseInt(scrollnr.attr('data-times'))+1));
				 }
				 scrollnr.attr('data-canLoad','true');
				 if(_mask){
				 _mask.closeMaskMe();//关掉遮罩
				 }
				 }
				 }
				 var coverError = {
				 error:function(){
				 _ajax.error.call(this);//调用传参的ajax的原始error方法
				 }
				 }

				 var settings = $.extend(true,empty,_ajax,coverSuccess,coverError);//合并传参和默认配置
				 if(that.scrollToDown(me)){//调用是否滚动到底部函数
				 console.log(123321)
				 if(scrollnr.attr('data-canLoad') == 'true'){
				 scrollnr.attr('data-canLoad','false');
				 if(scrollnr.attr('data-times') == scrollnr.attr('data-curpage')){
				 _mask = scrollnr.maskMe();//打开遮罩
				 }
				 if($.type(settings.data) == 'object'){
				 settings.data.page = scrollnr.attr('data-curpage');
				 }else if($.type(settings.data) == 'string'){
				 var arr = settings.data.split('&');
				 var p = 'page';
				 $.each(arr,function(i,n){
				 if(n.search(p) != -1){
				 arr[i] = p+'='+scrollnr.attr('data-curpage');
				 }
				 });
				 settings.data = arr.join('&');
				 }
				 $.ajax(settings);//调用新配置的ajax
				 }
				 }
				 if($.type(settings.data) == 'object'){
				 settings.data.page = scrollnr.attr('data-curpage');
				 }else if($.type(settings.data) == 'string'){
				 var arr = settings.data.split('&');
				 var p = 'page';
				 $.each(arr,function(i,n){
				 if(n.search(p) != -1){
				 arr[i] = p+'='+scrollnr.attr('data-curpage');
				 }
				 });
				 settings.data = arr.join('&');
				 };
				 });
				 }*/
			}
 };
 
