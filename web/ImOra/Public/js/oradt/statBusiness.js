(function($) {
	$.extend({
		business:{
			//初始化
			init: function(){
				//下载
				$('.right_down').on('click', function(){
					var headers=[];
					$('.table_tit span').each(function(){
						headers.push($(this).html());
					});
					$(this).prev().val(headers.join(','));
					$(this).parent().submit();
				});
				
				//数据列表滚动条
				$(".table_scrolls").mCustomScrollbar({
                    theme:"dark",
                    autoHideScrollbar: false,
                    scrollInertia :0,
                    horizontalScroll : false
                });
				
				//下拉select对应input初始化
				$('.menu_list .on').each(function(){
					var v=$(this).html();
					$(this).parent().siblings('input').val(v);
				});
				
				//跳转页面select下拉和隐藏
				$('.select_xinzeng input').on('click', function(){
					$(this).siblings('ul').toggle();
				}).on('blur', function(){
					var $ul=$(this).siblings('ul');
					if ($ul.is(':visible')){
						setTimeout(function(){
							$ul.hide();
						}, 150);
					}
				});
				
				//select跳转页面
				$('.select_xinzeng li').on('click', function(){
					var params={};
					var type=$(this).attr('type');
					type && (params.type=type);
					params=$.business.getUrlParams(params, true);
					if (params===false) return;
					location.href=$(this).attr('href')+'?'+params+'#anchor_statisticsBusiness';
				}).addClass('hand');
				
				//日周月跳转页面
				$('.js_stat_date_type a').on('click', function(){
					$(this).addClass('on').siblings().removeClass('on');
					var params={};
					var type=$('#typeChange').val();
					type && (params.type=type);
					//var type2=$('#typeChange2 .on').attr('type');
					//type2 && (params.type2=type2);
					var url=URL+'?'+$.business.getUrlParams(params)+'#anchor_statisticsBusiness';
					location.href=url;
				});
				
				//搜索按钮
				$('.form_marginauto input:submit').on('click', function(){
					var params=$.business.getUrlParams(null, true);
					if (params===false) return false;
					var url=URL+'?'+params+'#anchor_statisticsBusiness';
					location.href=url;
					return false;
				});
			},
			//获取url参数
			getUrlParams: function(obj,withDates){
				var params={};
				var softV=[],hardV=[];
				
				if ($('.select_IOS:eq(0) ul input:first').is(':checked')){
					params.s_versions='all';
				} else {
					$('.select_IOS:eq(0) ul input:gt(0):checked').each(function(){
						softV.push($(this).val());
					});
					params.s_versions=softV.join(',');
				}
				
				if ($('.select_IOS:eq(1) ul input:first').is(':checked')){
					params.h_versions='all';
				} else {
					$('.select_IOS:eq(1) ul input:gt(0):checked').each(function(){
						hardV.push($(this).val());
					});
					params.h_versions=hardV.join(',');
				}
				
				if (withDates){
					params.starttime=$('#js_begintime').val();
					params.endtime=$('#js_endtime').val();
					if (onlyEndTime){
						if (!params.endtime){
							$.global_msg.init({gType:'warning',icon:2,msg:tip_select_time,time:5});
							return false;
						}
						params.starttime = params.endtime.toDate().addDate(-29).format(); 
					} else {
						if (!params.starttime || !params.endtime){
							$.global_msg.init({gType:'warning',icon:2,msg:tip_select_time,time:5});
							return false;
						}
					}
				}
				
				params.period=$('.js_stat_date_type .on').attr('val');
				return $.param($.extend(params,obj));
			}
		}
	});
})(jQuery);