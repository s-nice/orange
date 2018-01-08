/**
 * 行业管理js
 */
$.extend({
Industry : {
	bind: function () {
		var $this = this;
		
		$('.js_industry_list_for_choice,.js_industry_list_for_edit').on('mouseover', function () {
			$(this).mCustomScrollbar({
                theme:"dark", //主题颜色
                autoHideScrollbar: false, //是否自动隐藏滚动条
                scrollInertia :1000,//滚动延迟
                horizontalScroll : false//水平滚动条
            });
		});
		// 选择所属父级行业
		$('.js_industry_list_for_choice').on('click', 'li > i', function () {
			if ('0'===$('#parentId').val()) {
				return false;
			}
			// 不能选择本身作为父级行业
			if ($('#industryId').val()!='' && $(this).parent().attr('id')==$('#industryId').val()) {
				return false;
			}
			var parentId = $(this).parent().attr('categoryid');
			var name = $(this).text();
			$('.js_industry_list_for_choice').find('li > i').not(this).removeClass('on');
			$(this).toggleClass('on');
			
			if (! $(this).hasClass('on')) {
				parentId = '';
				name = '';
			}

			$('#parentId').val(parentId);
			$('#parentName').val(name);
			
			$('.js_industry_list_for_choice').toggle();
			
			return false;
		});
		// 从行业列表中点击行业进行编辑
		$('.js_industry_list_for_edit').on('click', 'li > i', function () {
			var id      = $(this).parent().attr('id');
			var name    = $(this).text();
			var keyword = $(this).parent().attr('key');
			var sort    = $(this).parent().attr('sorting');
			var parentId   = $(this).parent().attr('parentid');
			var categoryId = $(this).parent().attr('categoryid');
			var status   = $(this).parent().attr('status');
			var parentName = '';
			
			if ('0'!=parentId) {
				parentName = $(this).parent().parent().siblings('i').eq(0).text();
			}
			if ('1'==status) {
				$('#changeStatusDisable').show();
				$('#changeStatusEnable').hide();
			} else {
				$('#changeStatusDisable').hide();
				$('#changeStatusEnable').show();
			}
			
			$('.js_industry_list_for_edit').find('li > i').not(this).removeClass('on');
			$(this).addClass('on');

			$('#industryId').val(id);
			$('#industryName').val(name);
			$('#keyword').val(keyword);
			$('#sort').val(sort);
			$('#parentId').val(parentId);
			$('#categoryId').val(categoryId);
			$('#parentName').val(parentName);
			
			return false;
		});
		
		// 点击行业列表左侧箭头， 关闭/打开下级行业列表
		$('.js_industry_list_for_edit,.js_industry_list_for_choice').on('click', 'li>u', function () {
			$(this).toggleClass('open');
			$(this).next('ul').toggle();
		});
		
		// 点击 父级 行业输入框， 显示/隐藏父级行业列表
		$('#parentName').on('click', function () {
			if ('0'===$('#parentId').val()) {
				$('.js_industry_list_for_choice').hide();
				return false;
			}
			$('.js_industry_list_for_choice').toggle();
		});
		
		// 点击添加行业按钮
		$('#add_industry').on('click', function () {
			$this.emptyForm();
			
			return false;
		});
		
		// 点击删除行业按钮
		$('#delete_industry').on('click', function () {
			var industryId = $('#industryId').val();
			// 判断是否有子行业。 如果有子行业， 不能删除
			var $li = $('.js_industry_list_for_edit li[id="' + industryId + '"]');
			if ($li.find('li').length) {
                $.global_msg.init({
                	gType : 'warning',
                	icon  : 2,
                	time  : 3,
                	msg   : "当前行业下有子行业，不能被删除"
                });
                
                return false;
            }
			// 是否确认删除行业？
            $.global_msg.init({
            	gType  : 'confirm',
            	icon   : 2,
            	msg    : "确认删除么？",
            	btns   : true,
            	close  : true,
                title  : false,
                btn1   : "取消",
                btn2   : "确认",
                noFn   : function(){
                    $this.deleteIndustryById(industryId);
                    return false;
                }
            });
            
            return false;
		});
		
		$('#changeStatusDisable, #changeStatusEnable').on('click', function () {
			var msg = '确认停用么？';
			var status = 2;
			if ('changeStatusEnable'==$(this).attr('id')) {
				msg = '确认启用么？';
				status = 1;
			}
			// 是否确认停用职能？
            $.global_msg.init({
            	gType  : 'confirm',
            	icon   : 2,
            	msg    : msg,
            	btns   : true,
            	close  : true,
                title  : false,
                btn1   : "取消",
                btn2   : "确认",
                noFn   : function(){
                	var $status = $('<input/>').attr({type:'hidden', id:'tmpStatus', name:'changeStatus',value:status});
                	$('#item_manage_form').append($status);
                    $this.submitForm();
                    $('#tmpStatus').remove();
                    return false;
                }
            });
            
            return false;
			
		});

		// 点击表单提交按钮， 提交表单数据。 
		$('.js_formZone').on('click', '#submitIndustryForm', $this.submitForm);
    },
    
    submitForm : function () {
		//console.info($(this).closest('form').serialize());
		if (! $.Industry.checkForm()) {
			return false;
		}
		var industryId = $('#industryId').val();
		var action = ''==industryId || '0'==industryId ? 'C' : 'U';
		$.ajax({
            url      : '/Appadmin/BasicData/industry',
            type     : 'post',
            dataType : 'json',
            data     : $('#item_manage_form').serialize() + '&action=' + action,
            success  : function(res){
            	if (typeof res == 'string') {
            		if ($(res).find('li').length) {
	                    $.global_msg.init({
	                    	gType : 'warning',
	                    	icon  : 1,
	                    	time  : 3,
	                    	msg   : "保存行业成功"
	                    });
	            		$('.js_industry_list_for_edit ul, .js_industry_list_for_choice ul').replaceWith(res);
	            		$('.js_industry_list_for_choice').find('li ul, li u').remove();
	            		$.Industry.emptyForm();
            		} else {
            			// 保存行业失败
	                	$.Industry.showWarningMsg("保存行业失败");
            		}
            		return;
            	}
                if (res.status==0) {
                //保存行业成功
                    $.global_msg.init({
                    	gType : 'warning',
                    	icon  : 1,
                    	time  : 3,
                    	msg   : "保存行业成功",
                    	endFn : function() {
                        }
                    });
                    $.Industry.emptyForm();
                } else {
                // 保存行业失败
                	if (/[\u4e00-\u9fa5]/.test(res.msg)) { // 匹配中文错误信息
                	    $.Industry.showWarningMsg(res.msg);
                	} else {
                	    $.Industry.showWarningMsg("保存行业失败");
                	}
                }

            },
            error : function(res){
            //删除失败
                $.Industry.showWarningMsg("保存失败，服务器响应错误");

            }
        });
		
		return false;
	},
    // 查看表单填写状况
    checkForm : function () {
    	if (''==$('#industryName').val()) {
    		$.Industry.showWarningMsg("请填写行业名称");
    		$('#industryName').focus();
    		return false;
    	}
    	
    	var parentId = $('#parentId').val();
    	var categoryId = $('#categoryId').val();
    	
    	if (''!==categoryId) {
    		// 编辑已有行业， 做了父级移动， 重新计算categoryid
    		//console.info(parentId, categoryId, categoryId.substr(1,2));
    		if ('0'!==parentId && ''!==parentId && parentId!=categoryId.substr(1,2)) {
    			categoryId = '';
    		} else {
        		return true;
    		}
    	}
    	
    	var categoryIdPrefix = ''===parentId ? '' : ('I'+parentId);
    	var tmpCategoryId = newCategoryId = '';
    	var i = 1;
    	if (''==parentId) { // 前面数据已经占用； 21被“通用”职能占用；
    		i=22;
    	}
    	for (; i<=99; i++) {
    		tmpCategoryId = categoryIdPrefix + (i<10 ? ('0'+i) : i);
			if (! $('.js_industry_list_for_edit li[categoryid="'+tmpCategoryId+'"]').length) {
				newCategoryId = newCategoryId === '' ? tmpCategoryId : newCategoryId;
				//break;
			} else {
				newCategoryId = '';
			}
		}
		$('#categoryId').val(newCategoryId);
    	
    	return true;
    },
    
    // 情况表单内元素数据的value值
    emptyForm : function () {
    	$('#industryId, #industryName, #keyword, #sort, #parentId, #parentName, #categoryId').val('');
    	$('#changeStatusDisable, #changeStatusEnable').hide();
    },
    
    deleteIndustryById : function (industryId) {
    	$.ajax({
            url:'/Appadmin/BasicData/industry',
            type:'post',
            dataType:'json',
            data:{industryId : industryId, action: 'D'},
            success:function(res){
                if (res.status==0) {
                //删除行业成功
                    $.global_msg.init({
                    	gType : 'warning',
                    	icon  : 1,
                    	time  : 3,
                    	msg   : "删除成功",
                    	endFn : function() {
                    		var $li = $('.js_industry_list_for_edit li[id="' + industryId + '"]');
                    		$li.remove();
                    		$li = $('.js_industry_list_for_choice li[id="' + industryId + '"]');
                    		$li.remove();
                    		$.Industry.emptyForm();
                        }
                    });
                } else {
                // 删除行业失败
                	$.Industry.showWarningMsg("删除失败");
                }

            },
            error:function(res){
            //删除失败
                $.Industry.showWarningMsg("删除失败，服务器响应错误");

            }
        });
    },
    
    // 显示警告弹框
    showWarningMsg : function (msg) {
        $.global_msg.init({
        	gType : 'warning',
        	icon  : 0,
        	time  : 3,
        	msg   : msg
        });
    },
    
    // 载入初始化
    init : function () {
    	// 监听页面关键dom的点击操作
    	this.bind();
    }
	
}	
});

$(function () {
	$.Industry.init();
});