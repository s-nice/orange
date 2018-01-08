/**
 * h5 页面js
 */
var checkObj;
(function($) {
	$.extend({
		adminLogs: {
			init: function() {
				this.checkbox();
				$.dataTimeLoad.init();
				this.delLogs();
				this.selModel();
				this.changeSelModel();
				// 显示日志详情弹框
				this.showLogDetail ();
				// 关闭日志详情弹框
				this.closeLogDetail ();
			},
			// 复选框
			checkbox:function(){
				checkObj = $('#js_content_hieght').checkDialog({checkAllSelector:'.js_checkAll',checkChildSelector:'.js_select',valAttr:'val',selectedClass:'active'});
			},
			// 删除日志
			delLogs:function(){
	            $('.js_delLogs').on('click',function(){
	            	var $this = $(this);
	            	var idObj = checkObj.getCheck();
					if(idObj.length == 0){
						$.global_msg.init({gType:'warning',msg:tip_logsid_empty,icon:2,time:3});
					}else{
						$.global_msg.init({gType:'confirm',title:false,close:true,msg:tip_logsid_ifdel,btn1:tip_logsid_submit,btn2:tip_logsid_cancel,btns:true,fn:function(){
						$.post($this.attr('jsUrl'),{idObj:idObj},function(result){
		            		result = eval('('+result+')');
		            		if(result.status == '0'){
								$.global_msg.init({gType:'warning',msg:result.msg,icon:1,time:3,endFn:$.reloadPage.init});
							}else{
								$.global_msg.init({gType:'warning',msg:result.msg,icon:0,time:3});
							}
		            	});
						}});
					}
	            });
			},
			//点击下拉选择事件
            selModel:function(){
                $('#js_selModel,#js_mod_select').on('click',function(){
                    var seloDiv = $('#js_selcontent');
                    if(seloDiv.is(':hidden')){
                        seloDiv.show();
                    }else{
                        seloDiv.hide();
                    }
                });
              //点击区域外关闭此下拉框
				$(document).on('click',function(e){
					if($(e.target).parents('.feedbackserach_name').length>0){
						var currUl = $(e.target).parents('.feedbackserach_name').find('ul');
						$('.feedbackserach_name>ul').not(currUl).hide()
					}else{
						$('.feedbackserach_name>ul').hide();
					}
				});
            },

            //点击下拉框中的选项
            changeSelModel:function(){
                var selOdiv = $('#js_selcontent');
                var modelOdiv = $('#js_mod_select');
                selOdiv.on('click','li',function(){
                    var model = $(this).attr('val');
                    var content = $(this).text();
                    modelOdiv.find('input').eq(0).val(content);
                    modelOdiv.find('input').eq(1).val(model);
                    selOdiv.hide();
                })
            },
            
			// 显示日志详情弹框
            showLogDetail : function () {
            	var $this = this;
            	$('.js_show_log_detail').click(function () {
            		var $logInfo = $(this).closest('.js_list_item');
            		$('.js_log_detail .js_username').html($logInfo.find('.js_username').attr('title'));
            		$('.js_log_detail .js_module_name').html($logInfo.find('.js_module_name').html());
            		$('.js_log_detail .js_action_name').html($logInfo.find('.js_action_name').html());
            		$('.js_log_detail .js_api_params').html($logInfo.find('.js_api_params').html());
            		$('.js_log_detail .js_log_time').html($logInfo.find('.js_log_time').html());
            		$('.js_log_detail .js_log_ip').html($logInfo.find('.js_log_ip').html());
            		$this.$layerDiv = $.layer({
            	        type       : 1,
            	        title      : false,
            	        area       : ['600px',, 'auto'],
            	        offset     : ['300px', ''],
            	        bgcolor    : '#ccc',
            	        border     : [0, 0.3, '#ccc'],
            	        shade      : [0.2, '#000'],
            	        shadeClose : true,
            	        closeBtn   : false,
            	        page       : {dom:$('.js_log_detail')}
            	    });
            		
            		return false;
            	});
            },
            
            // 关闭日志详情弹框
            closeLogDetail : function () {
            	var $this = this;
            	$('.js_log_detail').on('click', '.js_close', function () {
                	layer.close($this.$layerDiv);
            	});
            	
            	return false;
            }
		}
	});
})(jQuery);