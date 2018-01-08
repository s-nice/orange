/**
 * 注册用户管理
 */

(function($) {
    $.extend({
        protocol: {
        	//列表页
            index: function() {
                //点击区域外关闭此下拉框
                $(document).on('click',function(e){
                    if($(e.target).parents('.js_select_ul_list').length>0){
                        var currUl = $(e.target).parents('.js_select_ul_list').find('ul');
                        $('.js_select_ul_list>ul').not(currUl).hide()
                    }else{
                        $('.js_select_ul_list>ul').hide();
                    }
                });
                //时间选择日历插件
                $.dataTimeLoad.init({idArr: [ {start:'js_begintime',end:'js_endtime'} ]});

                //搜索-模块选择
                $('#js_mod_select,#js_seltitle').on('click',function(){
                    $('#js_selcontent').toggle();
                });
                //模块选中
                $('#js_selcontent li').on('click',function(){
                    var typeval = $(this).html();
                    var typekey = $(this).attr('val');
                    $('#js_mod_select input').val(typeval);
                    $('#js_searchtypevalue').val(typekey);
                    $(this).parent().hide();
                });
            },
          //添加/修改页面
            addedit:function(){
            	//取消
            	$('#js_cancel').on('click', function(){
            		location.href=mainurl;
            	});
            	
            	//预览
            	$('#js_preview').on('click', function(){
            		//js音频数据处理
                    var content = ue.getContent();
					if (!$.trim(content)){
						$.global_msg.init({gType:'warning',msg:tip_protocol_content,icon:2});
						return;
					}
					var $content = $(content);
                    $content.find('img[audio]').each(function () {
                        var src = $(this).attr('audio');
                        var $audio = $("<audio src='" + src + "' controls></audio>");
                        $(this).after($audio).remove();
                    });
            		$('.js_masklayer').show();
            		$('.appadmincomment_content p').html($content);
            		$('.appaddmin_comment_pop').show();
            	});
            	
            	//选择协议
            	$('.js_select_ul_list').on('click',function(){
                    $(this).closest('.js_select_ul_list').find('ul').toggle();
                });
            	$('#js_selcontent li').on('click',function(){
            		var content = $(this).html();
                    $('#js_searchtype').val(content);
                    $('#ptype').val($(this).attr('val'));
                    setTimeout(function(){
                    	$('#js_selcontent').hide();
                    },100);
                });
            	
            	//关闭预览弹层
                $('.js_btn_channel_cancel').on('click',function(){
                	$('.js_masklayer').hide();
            		$('.appaddmin_comment_pop').hide();
                });
                
            	//保存功能介绍
            	$('#js_dointro').on('click',function(){
            		var type = $('#ptype').val();
            		if (!type || type == 'none'){
            			$.global_msg.init({gType:'warning',msg:tip_protocol_select,icon:2});
            			return;
            		}
            		if (!$.trim(ue.getContent())){
            			$.global_msg.init({gType:'warning',msg:tip_protocol_content,icon:2});
            			return;
            		}
            		
            		//判断是否为修改操作
            		var edit='';
            		if (editpage){
            			edit = origintype == type?1:'';
            		}
            		//ue.getContent()}, //gEditor.html() 
            		$.ajax({
            	        type: "POST",
            	        url: URL_DO_INTRO,
            	        data: {content:ue.getContent(),type:type,edit:edit},
            	        async: false,
            	        dataType: 'json',
            	        success: function (result) {
            	            if (result.status == 0) {
            	                //成功
            	            	$.global_msg.init({gType:'warning',msg:result.msg,icon:1});
            	            	setTimeout(function(){
            		            	location.href=mainurl;
            		            },1000);
            	            } else {
            	            	$.global_msg.init({gType:'warning',msg:result.msg,icon:2});
            	            }
            	        }
            	    });
            	});
            }
        }
    });
})(jQuery);