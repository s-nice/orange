/**
 * 用户推广
 */
(function($) {
    $.extend({
        userpush: {
        	addpush: function(){
        		/*
        		//推送方式下拉
        		var $msgType = $('.addpush_select_name input:first').on('click', function(evt){
        			evt.stopPropagation();
                    $('#js_selcontent').toggle();
        		}).blur(function(){
        			setTimeout(function(){
        				$('#js_selcontent').hide();
        			},100);
        		});*/
        		
        		$('.addpush_radio:first input:radio').change(function(){
        			itemsDisplay($(this).val());
        		});
        		
        		//选择推送规则窗口弹出
        		$('.click_btn_r').on('click', function(){
        			$('.appadmin_maskunlock').show();
        			$('.push_rule').show();
        		});
        		
        		//推送规则窗口弹出-确认
        		$('.push_rule button:first').on('click', function(){
        			$('.push_rule input:checkbox').each(function(){
        				if ($(this).prop('checked')){
        					$('#'+$(this).val()).show();
        				} else {
        					$('#'+$(this).val()).hide();
        				}
        			});
        			
        			$('.appadmin_maskunlock').hide();
        			$('.push_rule').hide();
        		});
        		
        		//推送规则窗口弹出-取消
        		$('.push_rule button:last').on('click', function(){
        			$('.appadmin_maskunlock').hide();
        			$('.push_rule').hide();
        		});
        		
        		function getContent(){
        			var content = ue.getContent();
        			if ($('.addpush_radio:eq(0) input:checked').val() == '3'){
        				content = $('#js_content3').next().val();
        			}
        			return content;
        		}
        		
        		//推送方式下拉点击
        		$('#js_selcontent li').on('click', function(){
        			var v = $(this).attr('val');
                    var content = $(this).html();
                    $msgType.attr('value',content);
                    $msgType.val(content);
                    $msgType.attr('title',content);
                    $msgType.attr('seltitle',v);
                    $(this).parent().hide();
                    
                    //切换正文输入部分
                    itemsDisplay(v);
        		});
        		
        		//日期选择
        		$('#js_releasetime').datetimepicker({
            		format:"Y-m-d H:i",lang:'ch',
            		showWeak:true,timepicker:true,
            		step:1,
            		minDate:new Date().format('Y-m-d H:i'),
            		minTime:new Date().format("H:i"),
                    onSelectDate: function(date,obj){ //解决超过‘今天’ 分钟选择的限制
                        var now=new Date().format();
                        date=date.format();
                        var params={};
                        if (date > now){
                            params.minTime=false;
                        } else {
                            params.minTime=new Date().format('H:i');
                        }
                        obj.datetimepicker(params);
                    }
            	});
        		
        		//预览
        		$('#js_review_now').on('click', function(){
        			var title = $('#pushtitle').val();
        			var content = getContent();
        			
        			var $content=$('<aaa>'+content+'</aaa>');
        			$content.find('img[audio]').each(function(){
        				var src=$(this).attr('audio');
        				var $audio=$("<audio src='"+src+"' controls></audio>");
        				$(this).after($audio).remove();
        			});
        			
        			$('h2.js_title').html(title);
        			$('.js_content1').html($content.html());
        			
        			$('.Check_comment_pop').show();
        			$('.appadmin_maskunlock').show();
        		});
        		
        		//预览关闭
        		$('.js_btn_channel_cancel').on('click', function(){
        			$('.Check_comment_pop').hide();
        			$('.appadmin_maskunlock').hide();
        		});
        		
        		/*
        		//推送范围选择
        		$('.addpush_radio:eq(1) input').on('change', function(){
        			var isalluser=$('.addpush_radio:eq(1) input:checked').map(function(){return $(this).val();}).get().join(',');
        			//TODO AJAX
        			$.post();
        		});*/
        		
        		//确认
        		$('#js_adddata').on('click', function(){
        			var params={
        				'id': $('#id').val(),
        				'title': $('#pushtitle').val(),
        				'type': $('.addpush_radio:eq(0) input:checked').val(),
        				'isalluser':$('.addpush_radio:eq(1) input:checked').val(),
        				'isntice': $('#rule_notice input').is(':checked')?1:2,
        				'content': getContent(),
        				'pushtime':$('#js_releasetime').val(),
        				'isloop':$('#rule_pushtime input:last').prop('checked')?1:2
        			};
        			
        			if ($('.addpush_radio:eq(1) input:checked').length==2){
        				params['isalluser'] = 3;
        			}
        			
        			if (!$.trim(params['type'])){
        				$.global_msg.init({gType:'warning',msg:'推送方式不能为空',icon:0});
        				return;
        			}
        			if (!$.trim(params['isalluser'])){
        				$.global_msg.init({gType:'warning',msg:'推送范围不能为空',icon:0});
        				return;
        			}
        			if (params['type'] != 3 && !$.trim(params['title'])){
        				$.global_msg.init({gType:'warning',msg:'标题不能为空',icon:0});
        				return;
        			}
        			
        			if (!$.trim(params['content'])){
        				$.global_msg.init({gType:'warning',msg:'内容不能为空',icon:0});
        				return;
        			}
        			if ($('#rule_area').is(':visible')){
        				params['region'] = $('#js_push_set_region_code').val();
        			}
    				if ($('#rule_industry').is(':visible')){
        				params['industry'] = $('#js_push_set_category_code').val();
        			}
        			if ($('#rule_job').is(':visible')){
        				params['func'] = $('#js_push_set_job_code').val();
        			}
        			if ($('#rule_regtime').is(':visible')){
        				params['starttime'] = parseInt($('#rule_regtime input:eq(0)').val()) || '';
        				params['endtime']   = parseInt($('#rule_regtime input:eq(1)').val()) || '';
        				if ((params['starttime'] && params['endtime']) && (params['starttime'] > params['endtime'])){
        					$.global_msg.init({gType:'warning',msg:'注册大于等于日期太大',icon:0});
        					return;
        				}
        			}
        			if (!params['region'] && !params['industry'] && !params['func'] && !params['starttime'] && !params['endtime']){
        				$.global_msg.init({gType:'confirm',icon:2,msg:'当前操作会给所有注册用户/持有名片推送消息，请确认是否推送' ,btns:true,close:true,
    	                    title:false,btn1:'取消' ,btn2:'确认' ,noFn:function(){
    	                    dopush(params);
                        }});
        			} else {
        				dopush(params);
        			}
        		});
        		
        		/**
        		 * 提交
        		 * @params arr params
        		 */
        		function dopush(params){
        			var url=URL_DO_ADD;
        			if (params.id){
        				url=URL_DO_EDIT;
        			}
        			$.ajax({
        				url:url,
        				async:false,
        				type:'post',
        				data:params,
        				dataType:'json',
        				success:function(res1){
        					if(res1['status']=='0'){
        						$.global_msg.init({gType:'warning',msg:res1['msg'],icon:1,endFn:function(){
                                    location.href=URL_LIST;
                                }});
        					}else{
        						$.global_msg.init({gType:'warning',msg:res1['msg'],icon:0});
        					}
        				},
        				fail:function(err){
        					$.global_msg.init({gType:'warning',msg:'error',icon:0});
        				}
        			});
        		}
        		
        		//取消
        		$('#js_cancelpub').on('click', function(){
        			location.href=URL_LIST;
        		});
        		
        		//红色边框消失
        		$('#js_push_set_city, #js_push_set_category, #js_push_set_job').on('focus', function(){
        			$(this).parent().removeClass('invalid_warning');
        		});
        		
        		$('#pushtitle, .editer:last').on('focus', function(){
        			$(this).removeClass('invalid_warning');
        		});
        	},
        	listReload: function(){
        		var params={
            		'type': $('.serach_namemanages input:first').attr('seltitle'),
            		'search_type': $('.serach_name input:first').attr('seltitle'),
            		'keyword': $('#js_selkeyword').val(),
            		'starttime': $('#js_begintime').val(),
            		'endtime': $('#js_endtime').val(),
            		'order': $('#order').val(),
            		'ordertype': $('#ordertype').val()
            	}
            	params = $.param(params);
            	location.href=URL_LIST+'?'+params;
        	},
        	pushlist: function(){
        		//日期选择
        		//$.dataTimeLoad.init();
        		$.dataTimeLoad.init({minDate:{start:false,end:false},maxDate:{start:false,end:false}});
        		
        		//删除
        		$('#js_delnews').on('click', function(){
        			var ids=[];
	            	$('.sectionnot_list_c').each(function(){
	            		$(this).find('i:first').hasClass('active') && ids.push($(this).find('i:first').attr('val')); 
	            	});
	            	if (ids.length==0){
	            		$.global_msg.init({gType:'warning',msg:str_userpush_del_at_least_one,icon:2});
	            		return;
	            	}
	            	$.global_msg.init({gType:'confirm',icon:2,msg:gStrconfirmdelnews ,btns:true,close:true,
	                    title:false,btn1:gStrcanceldelnews ,btn2:gStryesdelnews ,noFn:function(){
                        $.post(URL_DEL,{ids:ids.join(',')},function(data){
                        	data = $.parseJSON(data);
                            if('0' == data['status']){
                                $.global_msg.init({gType:'warning',msg:data['msg'],icon:1,endFn:function(){
                                    $.userpush.listReload();
                                }});
                            }else{
                                $.global_msg.init({gType:'warning',msg:data['msg'],icon:2});
                            }
                        });
                    }});
        		});
        		
        		//消息类型下拉
        		var $msgType = $('.serach_namemanages input:first').on('click', function(evt){
        			evt.stopPropagation();
        			var $ul=$(this).parent().parent().find('ul');
        			$ul.find('li[val="'+$(this).attr('seltitle')+'"]').addClass('on').siblings().removeClass('on');
        			$ul.toggle();
        		}).blur(function(){
        			setTimeout(function(){
        				$('#js_selcontent').hide();
        			},100);
        		});
        		
        		//消息类型下拉列表点击
        		$('#js_selcontent li').on('mousedown', function(){
                    var title = $(this).attr('val');
                    var content = $(this).html();
                    $msgType.attr('value',content);
                    $msgType.val(content);
                    $msgType.attr('title',content);
                    $msgType.attr('seltitle',title);
                    $(this).addClass('on').siblings().removeClass('on');
                    $(this).parent().hide();
                });
        		
        		//搜索类型下拉
        		var $searchType = $('.serach_name input:first').on('click', function(evt){
        			evt.stopPropagation();
        			var $ul=$(this).parent().parent().find('ul');
        			$ul.find('li[val="'+$(this).attr('seltitle')+'"]').addClass('on').siblings().removeClass('on');
        			$ul.toggle();
        		}).blur(function(){
        			setTimeout(function(){
        				$('#js_selcontent2').hide();
        			},100);
        		});;
        		
        		//消息类型下拉列表点击
        		$('#js_selcontent2 li').on('mousedown', function(){
                    var title = $(this).attr('val');
                    var content = $(this).html();
                    $searchType.attr('value',content);
                    $searchType.val(content);
                    $searchType.attr('title',content);
                    $searchType.attr('seltitle',title);
                    $(this).addClass('on').siblings().removeClass('on');
                    $(this).parent().hide();
                });
        		
        		//搜索按钮
        		$('#js_searchbutton').on('click', function(){
        			$.userpush.listReload();
        		});
        		
        		//全选checkbox
        		$('#js_allselect').on('click', function(){
        			if ($(this).hasClass('active')){
	                    $(this).removeClass('active');
	                    $('.js_select').removeClass('active');
	                }else{
	                    $(this).addClass('active');
	                    $('.js_select').addClass('active');
	                }
        		});
        		
        		//单选checkbox
        		$('.sectionnot_list_c .js_select').on('click', function(){
        			if ( $(this).hasClass('active') ){
                        $(this).removeClass('active');
                    }else{
                        $(this).addClass('active');
                    }
        		});
        		
        		//编辑
        		$('.sectionnot_list_c .js_single_edit').on('click', function(){
        			location.href=URL_ADD+'?id='+$(this).parent().parent().find('i:first').attr('val');
        		});
        		
        		//推送
        		$('.sectionnot_list_c .push').on('click', function(){
        			var id=$(this).parent().parent().find('i:first').attr('val');
        			$.ajax({
        				url:URL_PUSH,
        				async:false,
        				type:'post',
        				data:{id:id},
        				success:function(res1){
        					res1=$.parseJSON(res1);
        					if(res1['status']=='0'){
        						$.global_msg.init({gType:'warning',msg:res1['msg'],icon:1,endFn:function(){
                                    $.userpush.listReload();
                                }});
        					}else{
        						$.global_msg.init({gType:'warning',msg:res1['msg'],icon:0});
        					}
        				},
        				fail:function(err){
        					$.global_msg.init({gType:'warning',msg:'error',icon:0});
        				}
        			});
        		});
        		
        		//再次推送
        		$('.sectionnot_list_c .push_again').on('click', function(){
        			var id=$(this).parent().parent().find('i:first').attr('val');
        			$.ajax({
        				url:URL_AGAIN,
        				async:false,
        				type:'post',
        				data:{id:id},
        				success:function(res1){
        					res1=$.parseJSON(res1);
        					if(res1['status']=='0'){
        						$.global_msg.init({gType:'warning',msg:res1['msg'],icon:1,endFn:function(){
                                    $.userpush.listReload();
                                }});
        					}else{
        						$.global_msg.init({gType:'warning',msg:res1['msg'],icon:0});
        					}
        				},
        				fail:function(err){
        					$.global_msg.init({gType:'warning',msg:'error',icon:0});
        				}
        			});
        		});
        		
        		//删除
        		$('.sectionnot_list_c .del').on('click', function(){
        			var id=$(this).parent().parent().find('i:first').attr('val');
        			$.global_msg.init({gType:'confirm',icon:2,msg:gStrconfirmdelnews ,btns:true,close:true,title:false,btn1:gStrcanceldelnews ,btn2:gStryesdelnews ,noFn:function(){
                    	$.ajax({
            				url:URL_DEL,
            				async:false,
            				type:'post',
            				data:{ids:id},
            				success:function(res1){
            					res1=$.parseJSON(res1);
            					if(res1['status']=='0'){
            						$.global_msg.init({gType:'warning',msg:res1['msg'],icon:1,endFn:function(){
                                        $.userpush.listReload();
                                    }});
            					}else{
            						$.global_msg.init({gType:'warning',msg:res1['msg'],icon:0});
            					}
            				},
            				fail:function(err){
            					$.global_msg.init({gType:'warning',msg:'error',icon:0});
            				}
            			});
                    }});
        		});
        		
        		//停止推送
        		$('.sectionnot_list_c .stop_loop').on('click', function(){
        			var id=$(this).parent().parent().find('i:first').attr('val');
        			$.ajax({
        				url:URL_STOPLOOP,
        				async:false,
        				type:'post',
        				data:{id:id},
        				success:function(res1){
        					res1=$.parseJSON(res1);
        					if(res1['status']=='0'){
        						$.global_msg.init({gType:'warning',msg:res1['msg'],icon:1,endFn:function(){
                                    $.userpush.listReload();
                                }});
        					}else{
        						$.global_msg.init({gType:'warning',msg:res1['msg'],icon:0});
        					}
        				},
        				fail:function(err){
        					$.global_msg.init({gType:'warning',msg:'error',icon:0});
        				}
        			});
        		});
        		
        		//预览
	            $('.js_review_notpublish').on('click', function(){
	            	var showid=$(this).parent().find('i:first').attr('val');
	            	$.ajax({
        				url:URL_VIEW,
        				async:false,
        				type:'post',
        				data:{showid:showid},
        				success:function(res1){
        					res1 = $.parseJSON(res1);
        					if(res1['status']=='0'){
        						$('.Check_comment_pop .js_title').html(res1.data.list[0].title);
            					$('.Check_comment_pop .js_content1').html(res1.data.list[0].content);
            					$('.Check_comment_pop').show();
        	        			$('.appadmin_maskunlock').show();
        					}else{
        						$.global_msg.init({gType:'warning',msg:res1['msg'],icon:0});
        					}
        				},
        				fail:function(err){
        					$.global_msg.init({gType:'warning',msg:'error',icon:0});
        				}
        			});
	            });
	            
	            //预览关闭
        		$('.js_btn_channel_cancel').on('click', function(){
        			$('.Check_comment_pop').hide();
        			$('.appadmin_maskunlock').hide();
        		});
        		
        		//排序
        		$('.sectionnot_list_name .span_span8, .sectionnot_list_name .span_span1').on('click', function(){
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
        			$.userpush.listReload();
        		});
        	}
        }
    });
})(jQuery);