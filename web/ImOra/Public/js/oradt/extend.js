/**
 *资讯  问答 页面js
 */
var gloable_showid = '';//已选资讯id
(function($) {
    $.extend({
        extends: {
            init: function() {
                /*绑定事件*/
                //点击区域外关闭此下拉框
                $(document).on('click',function(e){
                    if($(e.target).parents('.js_select_ul_list').length>0){
                        var currUl = $(e.target).parents('.js_select_ul_list').find('ul');
                        $('.js_select_ul_list>ul').not(currUl).hide()
                    }else{
                        $('.js_select_ul_list>ul').hide();
                    }
                });
            },
            //添加/修改提醒相关方法
            remindadd :function(){
            	//类型下拉列表
            	var selOdiv = $('.addrem_lx ul');
            	var titleOdiv = $('.addrem_lx input');
            	titleOdiv.on('click',function(evt){
                	evt.stopPropagation();
                    $(this).parent().find('ul').toggle();
                }).blur(function(){
                	setTimeout(function(){
                		$('.addrem_lx ul, .addrem_day ul').hide();
        			},100);
        		});
                
                selOdiv.on('click','li',function(){
                    var title = $(this).attr('val');
                    var content = $(this).html();
                    titleOdiv.attr('value',content);
                    titleOdiv.val(content);
                    titleOdiv.attr('title',content);
                    titleOdiv.attr('seltitle',title);
                    selOdiv.hide();
                    
                    if (title == 1){
                    	$('.addrem_title').hide();
                    	$('.addrem_lx span:last').hide();
                    } else {
                    	$('.addrem_title').show();
                    	$('.addrem_lx span:last').show();
                    }
                });
                
                //日期下拉列表
                var selOdiv2 = $('.addrem_day ul');
            	var titleOdiv2 = $('.addrem_day input');
            	titleOdiv2.on('click',function(evt){
                	evt.stopPropagation();
                    $(this).parent().find('ul').toggle();
                }).blur(function(){
                	setTimeout(function(){
                		$('.addrem_lx ul, .addrem_day ul').hide();
        			},100);
        		});;
                
                selOdiv2.on('click','li',function(){
                    var title = $(this).attr('val');
                    var content = $(this).html();
                    titleOdiv2.attr('value',content);
                    titleOdiv2.val(content);
                    titleOdiv2.attr('title',content);
                    titleOdiv2.attr('seltitle',title);
                    selOdiv2.hide();
                });
                
                //点击区域外关闭此下拉框
                $(document).on('click',function(e){
                	setTimeout(function(){
                		$('.addrem_day ul, .addrem_lx ul').hide();
                	}, 30);
                });
                
                //添加/修改提醒
                $('#js_adddata').on('click', function(){
                	var params={
                		'id': $('#id').val(),
                		'type': $('.addrem_lx input:first').attr('seltitle'),
                		'isnotify': $('.addrem_lx input:checkbox').is(':checked')?1:0,
                		//'title': $('.addrem_title input:first').val(),
                		'content': $('.textarea textarea').val(),
                		'alertdate': $('.addrem_day input:first').attr('seltitle')
                	}
                	
                	if (!$.trim(params['content'])){
        				$.global_msg.init({gType:'warning',msg:str_expire_content_empty,icon:0});
        				return;
        			}
                    if ($.trim(params['content']).length>60){
                        $.global_msg.init({gType:'warning',msg:str_expire_content_out,icon:0});
                        return;
                    }
                	
                	//console.dir(params);return;
                	
                	var url=URL_DO_ADD;
                	if (params.id){
                		url=URL_DO_EDIT;
                	}
                	$.ajax({
        				url:url,
        				async:false,
        				type:'post',
        				data:params,
        				success:function(res1){
        					res1 = $.parseJSON(res1);
        					if(res1['status']=='0'){
        						$.global_msg.init({gType:'warning',msg:res1['msg'],icon:1,endFn:function(){
        							location.href=URL_REMIND_LIST
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
                
                //取消
                $('#js_cancelpub').on('click', function(){
	            	location.href=URL_REMIND_LIST;
	            });
                
                //提交按钮样式
                setInterval(function(){
                	if ($.trim($('#content_txt').val())){
                		$('#js_adddata').removeClass('button_disabel').removeAttr('disabled');
                	} else {
                		$('#js_adddata').addClass('button_disabel').attr('disabled', true);
                	}
                },100);
            },
            //到期提醒列表重新加载
            remindListReload: function(){
            	var params={
            		'type': $('#js_titlevalue').attr('seltitle'),
            		'keyword': $('#select_province input').val(),
            		'starttime': $('#js_begintime').val(),
            		'search_type': 'content',
            		'endtime': $('#js_endtime').val(),
            		'order': $('#order').val(),
            		'ordertype': $('#ordertype').val()
            	}
            	params = $.param(params);
            	location.href=URL_LIST_REMIND+'?'+params;
            },
            //到期提醒相关方法
            remindlist: function(){
            	//类型下拉
            	var selOdiv = $('#js_selcontent');
            	var titleOdiv = $('#js_titlevalue');
            	titleOdiv.on('click',function(evt){
                	evt.stopPropagation();
                    $(this).parent().find('ul').toggle();
                });
                
                selOdiv.on('click','li',function(){
                    var title = $(this).attr('val');
                    var content = $(this).html();
                    titleOdiv.attr('value',content);
                    titleOdiv.val(content);
                    titleOdiv.attr('title',content);
                    titleOdiv.attr('seltitle',title);
                    selOdiv.hide();
                });

                //点击区域外关闭此下拉框
                $(document).on('click',function(e){
                	setTimeout(function(){
                		$('.js_select_item .left ul').hide();
                	}, 30);
                });
                
                //查询日期初始化
                $.dataTimeLoad.init();
                
                //全选
	            $('.rem_list_name .span_span11 i').click(function(){
	                if ($(this).hasClass('active')){
	                    $(this).removeClass('active');
	                    $('.js_select').removeClass('active');
	                }else{
	                    $(this).addClass('active');
	                    $('.js_select').addClass('active');
	                }
	            });
	            
	            //单选
	            $('.js_select').click(function(){
                    if ( $(this).hasClass('active') ){
                        $(this).removeClass('active');
                    }else{
                        $(this).addClass('active');
                    }
	            });
	            
	            //编辑
	            $('.js_single_edit').on('click', function(){
	            	location.href=URL_ADD_REMIND+'?id='+$(this).parent().parent().find('i:first').attr('val');
	            });
	            
	            //单个删除
	            $('.js_single_delete').on('click', function(){
	            	var showid=$(this).parent().parent().find('i:first').attr('val');
	            	$.global_msg.init({gType:'confirm',icon:2,msg:gStrconfirmdelnews ,btns:true,close:true,
                    title:false,btn1:gStrcanceldelnews ,btn2:gStryesdelnews ,noFn:function(){
                        $.post(URL_DEL_REMIND,{showid:showid},function(data){
                        	data = $.parseJSON(data);
                            if('0' == data['status']){
                                $.global_msg.init({gType:'warning',msg:data['msg'],icon:1,endFn:function(){
                                    $.extends.remindListReload();
                                }});
                            }else{
                                $.global_msg.init({gType:'warning',msg:data['msg'],icon:2});
                            }
                        });
                    }});
	            });
	            
	            //全部删除
	            $('.button_del').on('click', function(){
	            	var ids=[];
	            	$('.rem_list_c').each(function(){
	            		$(this).find('i:first').hasClass('active') && ids.push($(this).find('i:first').attr('val')); 
	            	});
	            	if (ids.length==0){
	            		$.global_msg.init({gType:'warning',msg:str_expire_del_one,icon:2});
	            		return;
	            	}
	            	$.global_msg.init({gType:'confirm',icon:2,msg:gStrconfirmdelnews ,btns:true,close:true,
	                    title:false,btn1:gStrcanceldelnews ,btn2:gStryesdelnews ,noFn:function(){
                        $.post(URL_DEL_REMIND,{showid:ids.join(',')},function(data){
                        	data = $.parseJSON(data);
                            if('0' == data['status']){
                                $.global_msg.init({gType:'warning',msg:data['msg'],icon:1,endFn:function(){
                                    $.extends.remindListReload();
                                }});
                            }else{
                                $.global_msg.init({gType:'warning',msg:data['msg'],icon:2});
                            }
                        });
                    }});
	            });
	            
	            //新增
	            $('.button_z').on('click', function(){
	            	location.href=URL_ADD_REMIND;
	            });
	            
	            //搜索提交
	            $('.submit_button').on('click', function(){
	            	$.extends.remindListReload();
	            });
	            
	            //预览
	            $('.js_review_notpublish').on('click', function(){
	            	var showid=$(this).parent().find('i:first').attr('val');
	            	$.ajax({
        				url:URL_SHOW_REMIND,
        				async:false,
        				type:'post',
        				data:{showid:showid},
        				success:function(res1){
        					res1=$.parseJSON(res1);
        					if(res1['status']=='0'){
        						$('.Check_comment_pop .js_title').html('');
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
        		$('#js_orderbytime').on('click', function(){
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
        			$.extends.remindListReload();
        		});
            },
            
            trimStrings:function (str){
                return str.replace(/(^\s*)|(\s*$)/g,"");
            },
            //敏感词事件绑定
            Sensitive:function(){
                //勾选按钮
                this.selectOperate();

                //批量删除按钮
                $('#js_del').on('click',function(){


                    var idstr = '';
                    $('.js_select').each(function(){
                        if ( $(this).hasClass('active') ){
                            idstr += $(this).attr('val')+',';
                        }
                    });
                    if(idstr == ''){
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_extend_warning_select});
                        return false;
                    }
                    //询问是否删除
                    $.global_msg.init({gType:'confirm',icon:2,msg:js_extend_confirm ,btns:true,close:true,
                        title:false,btn1:js_extend_confirm_cancel ,btn2:js_extend_warning_ok ,noFn:function(){
                            $.extends.delSensitive(idstr,'extendsection_list_c');

                        }
                    });

                });
                //单个删除
                $('.js_simp_del').on('click',function(){
                    //询问是否删除
                    var _this = $(this);

                    $.global_msg.init({gType:'confirm',icon:2,msg:js_extend_confirm ,btns:true,close:true,
                        title:false,btn1:js_extend_confirm_cancel ,btn2:js_extend_warning_ok ,noFn:function(){

                            var ids = _this.parent('span').attr('data-id');
                            $.extends.delSensitive(ids,_this.parents('.extendsection_list_c'));

                        }
                    });


                });

                //添加敏感词
                $('#js_addSensitive').on('click',function(){
                    $('#js_cloneDom').append($('.appadmin_Sensitivewords').clone());
                    $('#js_cloneDom .appadmin_Sensitivewords').show();
                    $('.js_masklayer').show();
                    //关闭按钮
                    $('#js_cloneDom .appadmin_unlock_close img,.js_canceladd').on('click',function(){
                        $(this).parents('.appadmin_Sensitivewords').remove();
                        $('.js_masklayer').hide();
                    });

                    //提交
                    $('#js_cloneDom .js_addSensitivebtn').on('click',function(){
                        var senword = $.extends.trimStrings($('#js_cloneDom #js_sensitiveWord').val());
                        /*var repword = $('#js_cloneDom #js_replaceWord').val();*/
                        //判断是否为空，做提示1
                        if(typeof(senword)=='string' && senword==''){
                            $.global_msg.init({gType:'warning',icon:3,time:3,msg:js_extend_warning_addsomething});
                            return false;
                        }

                        /*var datastring = 'senword='+senword+'&repword='+repword+'&type=1';*/
                        var datastring = 'senword='+senword+'&type=1';

                        $.extends.subSensitive(datastring);

                    });


                });

                //导入敏感词
                $('#js_incSensitive').on('click',function(){
                    $('#js_cloneDom').append($('.appadmin_Import').clone());
                    $('#js_cloneDom .appadmin_Import').show();
                    $('.js_masklayer').show();
                    $('#js_cloneDom .appadmin_unlock_close img,.js_cancelimp').on('click',function(){
                        $(this).parents('.appadmin_Import').remove();
                        $('.js_masklayer').hide();
                    });

                    //提交
                    $('#js_cloneDom .js_impSensitivebtn').on('click',function(){
                        var wordstring = $.extends.trimStrings($('#js_cloneDom #js_imp_words').val());
                        //判断是否为空，做提示1
                        if(typeof(wordstring)=='string' && wordstring==''){
                            $.global_msg.init({gType:'warning',icon:3,time:3,msg:js_extend_warning_addsomething});
                            return false;
                        }

                        var datastring = 'wordstring='+wordstring+'&type=2';

                        $.extends.subSensitive(datastring);

                    });
                });

                //修改敏感词
                $('.js_update_sensitive').on('click',function(){

                    var thesensitive = $(this).parents('.extendsection_list_c').find('.span_span1').html();
                    /*var thereplace = $(this).parents('.extendsection_list_c').find('.span_span2').html();*/
                    var id = $(this).parent('span').attr('data-id');

                    $('#js_cloneDom').append($('.appadmin_Sensitivewords').clone());
                    $('#js_cloneDom .appadmin_Sensitivewords').show();
                    $('#js_cloneDom .Administrator_title').html(js_str_updSensitive);
                    $('#js_cloneDom .appadmin_unlock_close img,.js_canceladd').on('click',function(){
                        $(this).parents('.appadmin_Sensitivewords').remove();
                        $('.js_masklayer').hide();
                    });
                    $('#js_cloneDom .js_addSensitivebtn').attr('data-id',id);
                    $('#js_cloneDom #js_sensitiveWord').val(thesensitive);
                    /*$('#js_cloneDom #js_replaceWord').val(thereplace);*/
                    $('.js_masklayer').show();

                    //提交修改
                    $('#js_cloneDom .js_addSensitivebtn').on('click',function(){

                        var senword = $.extends.trimStrings($('#js_cloneDom #js_sensitiveWord').val());
                        /*var repword = $('#js_cloneDom #js_replaceWord').val();*/
                        var id = $(this).attr('data-id');

                        //判断是否为空，做提示
                        if(typeof(senword)=='string' && senword==''){
                            $.global_msg.init({gType:'warning',icon:3,time:3,msg:js_extend_warning_addsomething});
                            return false;
                        }

                        /*var datastring = 'senword='+senword+'&repword='+repword+'&id='+id;*/
                        var datastring = 'senword='+senword+'&id='+id;

                        $.extends.updSensitive(datastring);

                    });

                });


            },
            //意见反馈事件绑定
            feedback:function(){

                //勾选按钮
                this.selectOperate();

                //时间插件
                $.dataTimeLoad.init({idArr: [ {start:'js_begintime',end:'js_endtime'} ]});

                //批量删除按钮
                $('#js_del').on('click',function(){
                    //询问是否删除
                    //if(confirm('delete these sensitive,are you sure ?')){
                        var idstr = '';
                        $('.js_select').each(function(){
                            if ( $(this).hasClass('active') ){
                                idstr += $(this).attr('val')+',';
                            }
                        });

                        $.extends.delFeedback(idstr,'feedbacksection_list_c');

                    //}
                });

                //搜索-模块选择
                $('#js_mod_select').on('click',function(){
                    $('#js_selcontent').toggle();
                });
                //模块选中
                $('#js_selcontent li').on('click',function(){
                    var modval = $(this).html();
                    $('#js_mod_select input').val(modval);
                    $(this).parent().hide();
                });

            },

            /* 删除意见反馈 已作废 */
            delFeedback:function(_id ,_dom){
                /*$.ajax({
                    url:'/Appadmin/Extend/delFeedback',
                    type:'post',
                    dataType:'json',
                    data:'id='+_id,
                    success:function(res){
                        //添加成功
                        if(res.status==0){
                            if( typeof(_dom)=='string'){
                                $('.active').parents('.'+_dom).remove();
                            }else{
                                _dom.remove();
                            }

                        }else{
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_feedback_warning_delfield});
                        }

                    },error:function(res){
                        //添加失败
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_feedback_warning_delfield});

                    }
                });*/
            },

            /*提交敏感词*/
            subSensitive:function( _datas ){

                var datastring;
                datastring = _datas;

                $.ajax({
                    url:'/Appadmin/News/addSensitive',
                    type:'post',
                    dataType:'json',
                    data:datastring,
                    success:function(res){
                        //敏感词字数大于限制，50字符，提示添加失败
                        if(res.status == 102){
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_extend_warning_addfield});
                            return ;
                        }else if(res.status==10404){
                            $.global_msg.init({gType:'warning',icon:3,time:3,msg:js_extend_warning_addsomething});
                            return false;
                        }else{
                            //关闭添加弹框
                            $('#js_cloneDom .appadmin_Sensitivewords').remove();
                            $('#js_cloneDom .appadmin_Import').remove();

                            //判断是否有重复的，做提示
                            if(res.data.repeat != ''){
                                if(res.data.repeat.length > 10){
                                    var alertstring = res.data.repeat.substr(0,10)+'...';
                                }else{
                                    var alertstring = res.data.repeat;
                                }
                                $.global_msg.init({gType:'warning',icon:2,msg:alertstring + js_extend_warning_sensitive_exist ,time:5,close:true,
                                    title:false ,endFn:function(){
                                        $.extends.refreshPage();
                                    }
                                });
                            }else{
                                $.extends.refreshPage();
                            }
                        }

                    },error:function(res){
                        //添加失败
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_extend_warning_addfield});
                        return false;
                    }
                });
            },

            /*删除敏感词*/
            delSensitive:function(_id ,_dom){
                $.ajax({
                    url:'/Appadmin/News/delSensitive',
                    type:'post',
                    dataType:'json',
                    data:'id='+_id,
                    success:function(res){
                        //添加成功
                        if(res.status==0){
                            if( typeof(_dom)=='string'){
                                $('.active').parents('.'+_dom).remove();
                            }else{
                                _dom.remove();
                            }
                            //判断当前页面是否还有列表
                            var listnumb = $('.content_c .js_select').length;

                            if(listnumb<1){
                                //翻页到前一页
                                var nowPage = parseInt($('.page').find('.current').html());
                                var totalPage = parseInt($('.page').find('.jumppage').attr('totalpage'));
                                if(totalPage>nowPage){
                                    $.extends.refreshPage();
                                }else{
                                    window.location.href = delnewsurl + "/p/"+(nowPage-1);
                                }

                            }else{
                                $.extends.refreshPage();
                            }

                        }else{
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_extend_warning_delfield});
                        }

                    },error:function(res){
                        //添加失败
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_extend_warning_delfield});

                    }
                });
            },
            /*刷新页面*/
            refreshPage:function(){
                window.location.reload();
            },
            /*修改敏感词*/
            updSensitive:function(_data){
                $.ajax({
                    url:'/Appadmin/News/updSensitive',
                    type:'post',
                    dataType:'json',
                    data:_data,
                    success:function(res){
                        //已存在敏感词提示
                        if(res.status==999005){
                            $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_extend_warning_exist});
                            return false;
                        }else if(res.status==10404){
                            $.global_msg.init({gType:'warning',icon:3,time:3,msg:js_extend_warning_addsomething});
                            return false;
                        }
                        //修改成功
                        $('#js_cloneDom .appadmin_Sensitivewords').remove();
                        $('#js_cloneDom .appadmin_Import').remove();
                        $('.js_masklayer').hide();
                        $.extends.refreshPage();

                    },error:function(res){
                        //修改失败
                        $.global_msg.init({gType:'warning',icon:0,time:3,msg:js_extend_warning_updfield});
                        return false;
                    }
                });
            },

            /* 勾选按钮*/
            selectOperate:function(){
                $('.js_select').click(function(){
                        if ( $(this).hasClass('active') ){
                            $(this).removeClass('active');
                        }else{
                            $(this).addClass('active');
                        }
                });
                $('.appadmin_pagingcolumn .span_span11').click(function(){
                    if ( $(this).find('i').hasClass('active') ){
                        $(this).find('i').removeClass('active');
                        $('.js_select').removeClass('active');
                    }else{
                        $(this).find('i').addClass('active');
                        $('.js_select').addClass('active');
                    }
                });
            }
        }
    });
})(jQuery);