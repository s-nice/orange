/**
 * 用户推广
 */
(function($) {
    $.extend({
        icsearch: {
        	detail: function(){
        		//滚动条
        		$('.ic_other_info').each(function(){
        			if ($(this).height()>450){
        				$(this).mCustomScrollbar({
                            theme:"dark", //主题颜色
                            set_height:450,
                            autoHideScrollbar: false, //是否自动隐藏滚动条
                            scrollInertia :0,//滚动延迟
                            horizontalScroll : false//水平滚动条
                        });
        			}
        		});
        	},
        	listReload: function(){
        		var params={
            		'search_type': $('.select_sketchtwo input:first').attr('val') || 'name',
            		'keyword': $.trim($('.textinput:visible').val()),
            		'order': $('#order').val(),
            		'ordertype': $('#ordertype').val()
            	}
            	params = $.param(params);
            	location.href=URL_LIST+'?'+params;
        	},
        	list: function(){
        		//搜索条件下拉
        		$('.select_sketchtwo input').on('click', function(){
        			$(this).siblings('ul').show();
        		}).on('blur', function(){
        			var $ul=$(this).siblings('ul');
        			setTimeout(function(){
        				$ul.hide();
        			},100);
        		});
        		
        		//搜索下拉点击
        		$('.select_sketchtwo ul li').on('click', function(){
        			var v=$(this).attr('val');
        			$('.select_sketchtwo input').attr('val', v).val($(this).html());
        			if (v=='approvedtime'){
        				$('.textinput:eq(0)').hide();
        				$('.textinput:eq(1)').show();
        			} else {
        				$('.textinput:eq(0)').show();
        				$('.textinput:eq(1)').hide();
        			}
        		});
        		
        		//日期选择初始化
        		$('.textinput:eq(1)').datetimepicker({
            		format:"Y-m-d",lang:'ch',
            		showWeak:true,timepicker:false,
            		step:1
            	});
        		
        		//搜索按钮
        		$('.serach_but input').on('click', function(){
        			$.icsearch.listReload();
        		});
        		
        		//排序
        		$('.userpushlist_name span[order]').on('click', function(){
        			var order=$(this).attr('order');
        			var ordertype=$(this).find('em').attr('type');
        			if (ordertype=='desc'){
        				ordertype='asc';
        			} else if (ordertype=='asc'){
        				ordertype='desc';
        			} else {
        				ordertype='asc';
        			}
        			$('#order').val(order);
        			$('#ordertype').val(ordertype);
        			$.icsearch.listReload();
        		});
        	}
        }
    });
})(jQuery);