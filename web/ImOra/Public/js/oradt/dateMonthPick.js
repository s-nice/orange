/**
 * 最小单位为月的日历
 */
(function( $ ) {
	var default_month_options  = {
		months: ["1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月"],
		selectYear:new Date().getFullYear(),
		selectMonth:new Date().getMonth() +1,
		format:'Y-m',
		onSelectDate:function() {},
		onChangeMonth:function() {},
		id:''
	};
	$.fn.dateMonthPick = function( opt ) {
		var options = ($.isPlainObject(opt)||!opt)?$.extend(true,{},default_month_options,opt):$.extend({},default_month_options);
		var createDateMonthPick = function( input ) {
			// 拼接日历html 添加到页面中  对应的input元素设置为只读
			var m = options.months;
	    	var monthHtml = '<div class="monthInfoHtml">';
	    	for(var i in m){
	    		if(i == options.selectMonth -1){
	    			monthHtml += '<span data="'+i+'" class="monthItemPick on">'+m[i]+'</span>';
	    		}else{
	    			monthHtml += '<span data="'+i+'" class="monthItemPick">'+m[i]+'</span>';
	    		}
	    	}
	    	monthHtml +='</div>'
	    	var YearHtml = '<div class="yearInfoHtml"><span class="changeYearItem" data="-1">上一年</span><span class="yearItemValue" data="'+options.selectYear+'">'+options.selectYear+'</span><span class="changeYearItem" data="1">下一年</span></div>';
	    	var bodyHtml = $('<div '+(options.id?'id="'+options.id+'"':'')+'style="display:none;position:absolute;z-index:9999999 !important;" class="imora_datapick_yearmonth"></div>');
	    	bodyHtml.append($(YearHtml+monthHtml));
	    	$('body').append(bodyHtml);
	    	input.data('imora_datapick_yearmonth',bodyHtml).attr('readonly','readonly');
	    	// 展示位置
	    	var setPos = function() {
				var offset = bodyHtml.data('input').offset(), top = offset.top+bodyHtml.data('input')[0].offsetHeight-1, left = offset.left;
				if( top+bodyHtml[0].offsetHeight>$(window).height()+$(window).scrollTop() )
					top = offset.top-bodyHtml[0].offsetHeight+1;
				if( left+bodyHtml[0].offsetWidth>$(window).width() )
					left = offset.left-bodyHtml[0].offsetWidth+bodyHtml.data('input')[0].offsetWidth;
				bodyHtml.css({
					left:left,
					top:top
				});
			};
			// 日历上添加自定义事件
			bodyHtml
				.on('showImoraDataPick', function() {
					bodyHtml.show();
					setPos();
					bodyHtml.trigger('assignment');
					$(window)
						.off('resize',setPos)
						.on('resize',setPos);
				}).on('closeImoraDataPick', function() {
					bodyHtml.hide();
				}).on('assignment',function(){
					var nowMonth = $('.monthItemPick.on').attr('data')*1+1;
				    var nowMonth = nowMonth>=10 ? nowMonth : '0'+nowMonth; //兼容火狐
					var nowYearMonth = new Date($('.yearItemValue').attr('data')+'-'+nowMonth);
					nowYearMonth = nowYearMonth.format(options.format);
					input.val(nowYearMonth);
				}).data('input',input);
			// 日历上绑定月份的单双击事件
			bodyHtml.find('.monthInfoHtml')
				.on('click .monthItemPick',function(e){
					if( $(e.target).hasClass('monthItemPick') ){
						$('.monthItemPick').removeClass('on');
						$(e.target).addClass('on');
						bodyHtml.trigger('assignment');
					}
				}).on('dblclick .monthItemPick',function(e){
					if( $(e.target).hasClass('monthItemPick') ) {
						$('.monthItemPick').removeClass('on');
						$(e.target).addClass('on');
						bodyHtml.trigger('assignment');
						bodyHtml.trigger('closeImoraDataPick');
					}
				});
			// 日历上绑定年份的点击事件
			bodyHtml.find('.yearInfoHtml')
				.on('click',function(e){
					if( $(e.target).hasClass('changeYearItem') ){
						var i = $(e.target).attr('data')*1;
						var nowYear = $('.yearItemValue').attr('data')*1;
						nowYear = nowYear + i;
						$('.yearItemValue').text(nowYear).attr('data',nowYear);
						bodyHtml.trigger('assignment');
					}
				});
			// 日历绑定元素增加但双击事件
			input.on('click dbclick',function(){
				bodyHtml.trigger('showImoraDataPick');
			});
			// 点击除了日历及绑定日历的元素外其他地方， 均执行自定义事件：关闭日历插件
			$(document).on('click',function(e){
				if($(e.target).parents('.imora_datapick_yearmonth').length<=0 && input[0] != e.target){
					bodyHtml.trigger('closeImoraDataPick');
				}
			});
		};
		// 判断日历插件是否已生成  根据参数创建日历插件 或做出对应的相应
		return this.each(function() {
			var dateMonthPick;
			if( dateMonthPick = $(this).data('imora_datapick_yearmonth') ) {
				if( $.type(opt) === 'string' ) {
					switch(opt) {
						case 'show':
							$(this).select().focus();
							dateMonthPick.trigger( 'showImoraDataPick' );
						break;
						case 'hide':
							dateMonthPick.trigger('closeImoraDataPick');
						break;
					}
				}else{
					dateMonthPick.setOptions(opt);
				}
				return 0;
			}else
				($.type(opt) !== 'string')&&createDateMonthPick($(this));
		});
	};
})( jQuery );