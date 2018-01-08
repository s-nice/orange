/**
* 设置基础数据管理JS
**/
$.extend({
Position : {
	bind: function () {
		var $this = this;
		/**
		 * 职能选择列表 和 职能编辑列表在鼠标滑过时， 实现区域滚动功能；
		 */
		$('.js_position_list_for_choice,.js_position_list_for_edit').on('mouseover', function () {
			$(this).mCustomScrollbar({
                theme:"dark", //主题颜色
                autoHideScrollbar: false, //是否自动隐藏滚动条
                scrollInertia :1000,//滚动延迟
                horizontalScroll : false//水平滚动条
            });
		});
		
		/**
		 * 在职能列表中选择所属行业作为当前职能父级行业
		 */
		$('.js_position_list_for_choice').on('click', 'li > i', function () {
			// 获取父级行业id和行业名字
			var parentId = $(this).parent().attr('categoryid');
			var name = $(this).text();
			// 点击列表， 将当前选项设置为选中状态
			$('.js_position_list_for_choice').find('li > i').not(this).removeClass('on');
			$(this).toggleClass('on');
			// 选中后再次选择， 取消选中状态
			if (! $(this).hasClass('on')) {
				parentId = '';
				name = '';
			}
            // 将选中的值， 添加到input中
			$('#parentId').val(parentId);
			$('#parentName').val(name);
			// 关闭列表
			$('.js_position_list_for_choice').toggle();
			
			return false;
		});
		
		// 从行业列表中点击职能进行编辑
		$('.js_position_list_for_edit').on('click', 'li[parent_id!="0"] > i', function () {
			// 获取待编辑的职位信息
			var id      = $(this).parent().attr('id');
			var name    = $(this).text();
			var keyword = $(this).parent().attr('keyword');
			var sort    = $(this).parent().attr('sorting');
			var parentId = $(this).parent().attr('parentid');
			var status   = $(this).parent().attr('status');
			var categoryId=$(this).parent().attr('categoryid');
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
			
			$('.js_position_list_for_edit').find('li > i').not(this).removeClass('on');
			$(this).addClass('on');
            // 设置编辑框内的数值
			$('#positionId').val(id);
			$('#positionName').val(name);
			$('#keyword').val(keyword);
			$('#sort').val(sort);
			$('#parentId').val(parentId);
			$('#parentName').val(parentName);
			$('#categoryId').val(categoryId);
			
			return false;
		});
		
		// 点击行业列表左侧箭头， 关闭/打开下级行业列表
		$('.js_position_list_for_edit,.js_position_list_for_choice').on('click', 'li>u', function () {
			$(this).toggleClass('open');
			$(this).next('ul').toggle();
		});
		
		// 点击 父级 行业输入框， 显示/隐藏父级行业列表
		$('#parentName').on('click', function () {
			$('.js_position_list_for_choice').toggle();
		});
		
		// 点击添加行业按钮
		$('#add_position').on('click', function () {
			$this.emptyForm();
			
			return false;
		});
		
		// 点击删除行业按钮
		$('#delete_position').on('click', function () {
			var positionId = $('#positionId').val();
			// 判断是否有子行业。 如果有子行业， 不能删除
			var $li = $('.js_position_list_for_edit li[id="' + positionId + '"]');
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
                    $this.deletePositionById(positionId);
                    return false;
                }
            });
            
            return false;
		});
		
		/**
		 * 停用/启用 职能
		 */
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
		$('.js_formZone').on('click', '#submitItemForm', $this.submitForm);
    },
    
    /**
     * 点击提交职能维护表单
     */
    submitForm : function () {
		//console.info($(this).closest('form').serialize());
		if (! $.Position.checkForm()) {
			return false;
		}
		
		var positionId = $('#positionId').val();
		var action = ''==positionId || '0'==positionId ? 'C' : 'U';
		$.ajax({
            url      : '/Appadmin/BasicData/titlemanage',
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
	                    	msg   : "保存职能信息成功"
	                    });
	            		$('.js_position_list_for_edit ul, .js_position_list_for_choice ul').replaceWith(res);
	            		$('.js_position_list_for_choice').find('li ul, li u').remove();
	            		$.Position.emptyForm();
            		} else {
            			// 保存行业失败
	                	$.Position.showWarningMsg("保存行业失败");
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
                    $.Position.emptyForm();
                } else {
                // 保存行业失败
                	$.Position.showWarningMsg("保存行业失败");
                }

            },
            error : function(res){
            //删除失败
                $.Position.showWarningMsg("保存失败，服务器响应错误");

            }
        });
		
		return false;
	},
    // 查看表单填写状况
    checkForm : function () {
    	if (''==$('#positionName').val()) {
    		$.Position.showWarningMsg("请填写职能名称");
    		$('#positionName').focus();
    		return false;
    	}
    	if (''!=$('#sort').val() && ! /[0-9]+/.test($('#sort').val()) ) {
    		$.Position.showWarningMsg("排序只能输入数字");
    		return false;
    	}
    	
    	var parentId = $('#parentId').val();
    	if (''==parentId) {
    		$.Position.showWarningMsg("请选择所属行业");
    		return false;
    	}
    	var categoryId = $('#categoryId').val();
    	
    	if (''!==categoryId) {
    		// 编辑已有行业， 做了父级移动， 重新计算categoryid
    		if (parentId!=categoryId.substr(1,2)) {
    			categoryId = '';
    		} else {
        		return true;
    		}
    	}

    	var categoryIdPrefix = ''===parentId ? '' : ('F'+parentId);
    	var tmpCategoryId = newCategoryId = '';
    	for (var i=1; i<=99; i++) {
    		tmpCategoryId = categoryIdPrefix + (i<10 ? ('0'+i) : i);
			if (! $('.js_position_list_for_edit li[categoryid="'+tmpCategoryId+'"]').length) {
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
    	$('#positionId, #positionName, #keyword, #sort, #parentId, #parentName, #categoryId').val('');
    	$('#changeStatusDisable, #changeStatusEnable').hide();
    },
    
    deletePositionById : function (positionId) {
    	$.ajax({
            url:'/Appadmin/BasicData/titlemanage',
            type:'post',
            dataType:'json',
            data:{positionId : positionId, action: 'D'},
            success:function(res){
                if (res.status==0) {
                //删除行业成功
                    $.global_msg.init({
                    	gType : 'warning',
                    	icon  : 1,
                    	time  : 3,
                    	msg   : "删除成功",
                    	endFn : function() {
                    		var $li = $('.js_position_list_for_edit li[id="' + positionId + '"]');
                    		$li.remove();
                    		$li = $('.js_position_list_for_choice li[id="' + positionId + '"]');
                    		$li.remove();
                    		$.Position.emptyForm();
                        }
                    });
                } else {
                // 删除行业失败
                	$.Position.showWarningMsg("删除失败");
                }

            },
            error:function(res){
            //删除失败
                $.Position.showWarningMsg("删除失败，服务器响应错误");

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

