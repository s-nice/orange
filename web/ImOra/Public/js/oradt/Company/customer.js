/**
 * 客户模块js
 */
(function($) {
    $.extend({
        customers: {
            init: function() {
            	
            },
            // 客户名片数据列表页面
            cardlist:function(){
            	$.dataTimeLoad.init();
            	this.exportcard();
            	this.changeCardshow();
            	this.selectAllcheckbox();
            	this.jumpGoshowInfo();
            },
            //员工客户
            employeerCust:function(){
                $.dataTimeLoad.init();//时间插件
                this.changeCardshow();//浏览方式切换
            },
            //数据分配 按钮
            dataDistribution:function(){
                this.selectAllcheckbox(1);

                //点击选择员工
                _this = this;
                $('.search_div').on('click','.js_add_user',function(){
                    _this.setLayer('user');
                });
                //确认分配
                $('#div_layer_user').on('click','.btn-sub',function(){
                    //提交分配**************************
                    var types = $('.js_distrib_type').attr('data-type');
                    _this.distibutionAct(types);

                });
                //点击部门，获取部门内员工

                //部门员工显示隐藏
                $('#div_layer_user').on('click','.span_tab',function(){
                    $(this).parents('.div_department_title').next().toggle();
                    var gethistory = $(this).attr('data-get');

                    if(gethistory!=1){
                        var gid = $(this).parents('.div_department_title').find('.js_all_check').attr('dept-id');
                        //获取部门下的员工列表
                        _this.getEmpList(gid,$(this).parent().siblings());
                        $(this).attr('data-get',1);
                    }

                });
                //员工选择取消
                $('#div_layer_user').on('click','.user_block',function(){
                    $(this).toggleClass('act');
                    //取消全选
                    if(!$(this).hasClass('act')){
                        var did = $(this).attr('data-departid');
                        $('#div_layer_user .js_all_check[dept-id='+did+']').attr("checked", false);
                    }
                });
                //员工全选
                $('#div_layer_user').on('click','.js_all_check',function(){
                    var oDiv = $(this).parents('.div_department_title').next().find('.user_block');
                    if($(this).is(':checked')){
                        oDiv.addClass('act');
                    }else{
                        oDiv.removeClass('act');
                    }
                });
                //关闭弹框
                $('#div_layer_user').on('click','.js_close_layer',function(){
                    layer.close(_this.layer_user);
                });


            },
            //数据分配操作
            distibutionAct:function(_type){
                _this = this;
                var eid = '';
                var vid = '';
                var clientids = '';
                if(_type=='emp'){
                    //获取列表员工id
                    $('.list_data_c .active').each(function(i,domi){
                        eid += $(domi).attr('data-id')+',';
                    });
                }else{
                    //获取列表客户名片id
                    $('.bution_list_l .active').each(function(j,domj){
                        vid += $(domj).attr('data')+',';
                    });
                }

                //获取弹框 员工id
                $('.layer_content .act').each(function(){
                    clientids += $(this).attr('data-cid')+',';
                });

                $.ajax({
                    'type':'post',
                    'async':false,
                    'dataType':'json',
                    'url':distribUrl,
                    'data':'vid='+vid+'&fid='+eid+'&cid='+clientids,
                    'success':function(res){

                        if(res.status==0){
                            $.global_msg.init({gType:'alert',icon:1,msg:'数据分配成功'});
                            //关闭选择框
                            window.location.href = listUrl;
                        }else{
                            $.global_msg.init({gType:'warning',icon:2,msg:'数据分配失败'});
                        }

                    }
                });


            },
            //点击展开按钮获取该部门下的员工列表
            getEmpList:function(_gid,_dom){
                $.ajax({
                    'type':'post',
                    'async':false,
                    'dataType':'json',
                    'url':getEmpUrl,
                    'data':'gid='+_gid,
                    'success':function(res){
                        _dom.html(res);
                    }
                });
            },
            //搜索部门、员工
            empSearch:function(){
                $('#div_layer_user').on('click','.js_search_btn',function(){
                    $('#div_layer_user .div_search_content .js_search_emp_name').val();
                    var empname = $('#div_layer_user .div_search_content .js_search_emp_name').val();
                    var gid = $('#div_layer_user .div_search_content .js_search_depart_select').find("option:selected").val();

                    $.ajax({
                        'type':'post',
                        'async':false,
                        'dataType':'json',
                        'url':getEmpUrl,
                        'data':'gid='+gid+'&empname='+empname,
                        'success':function(res){
                            if(res){
                                //对应部门修改员工列表
                                $('#div_layer_user .div_department[data-depid='+gid+'] .div_department_content').html(res);
                                $('#div_layer_user .div_department[data-depid='+gid+'] .div_department_content').show();

                            }
                        }
                    });

                });
            },
            //员工选择弹框
            setLayer:function(){
                _this = this;
                var oDiv = $('#div_layer_user');
                var url = eval('getuserUrl');
                var obj = _this.layer_user;
                if(!obj){
                    $.ajax({
                        'type':'post',
                        'async':false,
                        'dataType':'json',
                        'url':url,
                        'success':function(re){
                            if(re.status===0){
                                oDiv.html(re.html);
                            }
                        }
                    });

                };

                oScroll = oDiv.find('.js_scroll_height');
                var dHeight = oScroll.height();
                if(dHeight>450){
                    oScroll.mCustomScrollbar({
                        theme:"dark", //主题颜色
                        set_height:450,
                        autoHideScrollbar: false, //是否自动隐藏滚动条
                        scrollInertia :0,//滚动延迟
                        horizontalScroll : false//水平滚动条
                    });
                };

                _this.layer_user= $.layer({
                    type: 1,
                    title: false,
                    area: ['600px','600px'],
                    offset: ['', ''],
                    fix:false,
                    bgcolor: '#fff',
                    border: [0, 0.3, '#ccc'],
                    shade: [0.2, '#000'],
                    closeBtn:false,
                    page:{dom:oDiv},
                    shadeClose:true
                });

            },
            /*过滤空格，回车*/
            trimStrings:function (str){
                return str.replace(/(^\s*)|(\s*$)/g,"");
            },
            menuSwitch:function(){
                $('.js_menulist').on('click',function(){
                    if(!$(this).hasClass('on ')){ //菜单样式
                        $('.js_menulist').removeClass('on ');
                        $(this).addClass('on');

                    }

                    var menukey = $(this).attr('data-menu-key');

                    $.ajax({
                        url:'/Company/Customer/menuSwitch',
                        type:'post',
                        dataType:'json',
                        data:'type='+menukey,
                        success:function(res){
                            //成功
                            if(res.status==0){
                                $('#js_data_content').html(res.datas);
                            }else{

                            }

                        },error:function(res){
                            //失败

                        }
                    });

                });



            },
            // 导出名片
            exportcard:function(){
            	$('.js_export').on('click',function(){
            		$this = $(this);
            		if($this.hasClass('js_exportSubmit')){
            			var url =$("form[name='cardlist']").attr('action');
            			var cid = $.customers.getCheckBoxVal();
            			console.log(cid);
            			var jsurl = '';
            			if(cid != ''){
            				jsurl = '?cid='+cid;
            			}
            			if(typeof $this.attr('jssrc') != 'undefined'){
            				// 扫描仪导出
                    		$("form[name='cardlist']").attr('action',$this.attr('jssrc')+jsurl);
            			}else{
            				// 扫描名片导出操作
                    		$("form[name='cardlist']").attr('action',$this.attr('src')+jsurl);
            			}
                		$("form[name='cardlist']").submit();
            			$("form[name='cardlist']").attr('action',url);
            		}else{
           		        $.global_msg.init({gType:'warning',icon:2,msg:'只可以导出查询后的数据'});
            		}
            	});
            	
            },
            // 切换名片列表浏览方式
            changeCardshow:function(){
                $('#js_graph').on('click',function(){
                    $('.js_data-list').hide();
                    $('.js_data-list_card').show();
                    $(this).hide();
                    $('#js_list').show();
                    $.cookie("showCardList",'img');
                });
                $('#js_list').on('click',function(){
                    $('.js_data-list_card').hide();
                    $('.js_data-list').show();
                    $(this).hide();
                    $('#js_graph').show();
                    $.cookie("showCardList",'list');
                });
            },
            // 全选操作
            selectAllcheckbox:function(_showbtn){
            	// 全选|取消全选
            	$('.js_select_all').on('click',function(){
            		var $this = $(this);
            		if($this.hasClass('active')){
            			$this.removeClass('active');
            			$('.js_select').removeClass('active');
            			$('.js_select_pic_div').removeClass('on');
                        //扩展：数据分配按钮显示
                        if(_showbtn==1){
                            $('.js_distribution_btn').addClass('span_sjfp_h');
                            $('.js_distribution_btn').removeClass('js_add_user');
                        }
            		}else{
            			$this.addClass('active');
            			$('.js_select').addClass('active');
            			$('.js_select_pic_div').addClass('on');
                        //扩展：数据分配按钮显示
                        if(_showbtn==1 &&$('.js_select').length>0){
                            $('.js_distribution_btn').removeClass('span_sjfp_h');
                            $('.js_distribution_btn').addClass('js_add_user');
                        }
            		}
                    //已选计数
                    var cardselectednumb = $('.js_select.active').length;
                    $('#card_selected_no').html(cardselectednumb);
            	});
            	// 列表单选操作
            	$('.js_select').on('click',function(){
            		var $this = $(this);
            		var cid = $this.attr('data');
            		if($this.hasClass('active')){
            			$this.removeClass('active');
            			$(".js_select_pic_div[data='"+cid+"']").removeClass('on');
            		}else{
            			$this.addClass('active');
            			$(".js_select_pic_div[data='"+cid+"']").addClass('on');

            		}
            		if($('.js_select').length == $('.js_select.active').length){
            			$('.js_select_all').addClass('active');
            		}else{
            			$('.js_select_all').removeClass('active');
            		}

                    //扩展：数据分配按钮显示
                    if(_showbtn==1){
                        if($('.js_select.active').length<1){
                            $('.js_distribution_btn').addClass('span_sjfp_h');
                            $('.js_distribution_btn').removeClass('js_add_user');
                        }else{
                            $('.js_distribution_btn').removeClass('span_sjfp_h');
                            $('.js_distribution_btn').addClass('js_add_user');
                        }
                        //已选计数
                        var cardselectednumb = $('.js_select.active').length;
                        $('#card_selected_no').html(cardselectednumb);
                    }
               	});
            	// 图片单选操作
            	$('.js_select_pic').on('click',function(){
            		var $this = $(this).parents('.js_select_pic_div');
            		var cid = $this.attr('data');

            		if($this.hasClass('on')){
            			$this.removeClass('on');
            			$(".js_select[data='"+cid+"']").removeClass('active');

            		}else{
            			$this.addClass('on');
            			$(".js_select[data='"+cid+"']").addClass('active');

            		}
            		if($('.js_select_pic_div').length == $('.js_select_pic_div.on').length){
            			$('.js_select_all').addClass('active');
            		}else{
            			$('.js_select_all').removeClass('active');
            		}
                    //扩展：数据分配按钮显示
                    if(_showbtn==1){
                        if($('.js_select_pic_div.on').length<1){
                            $('.js_distribution_btn').addClass('span_sjfp_h');
                            $('.js_distribution_btn').removeClass('js_add_user');
                        }else{
                            $('.js_distribution_btn').removeClass('span_sjfp_h');
                            $('.js_distribution_btn').addClass('js_add_user');
                        }
                        //已选计数
                        var cardselectednumb = $('.js_select.active').length;
                        $('#card_selected_no').html(cardselectednumb);
                    }
               	});
       	
            },
            // 获取选中数据
            getCheckBoxVal:function(){
            	var cid = '';
        		var num = $(".js_select.active").length -1;
        		$(".js_select.active").each(function(t){
        			cid += $(this).attr('data');
        			if(t != num){
        				cid += ',';
        			}
        		});
        		return cid;
            },
            // 名片点击跳转功能
            jumpGoshowInfo:function(){
            	$('.js_select_pic_div').find('img').on('click',function(){
            		var jsurl = $(this).attr('jsGoUrl');
            		location.href = jsurl;
            	});
            },
            // 导入页面
            import:function(){
            	this.upload();
            	this.addUserPage();
            	this.delUserOrGroup();
            },
            // 上传文件
           upload:function(){
            	$('.js_upload').on('change',function(){
            		$("form[name='upload']").submit();
            	});
           },
           // 上传结果
           uploadReturn:function(re){
            	if(re['status'] == '0'){
            		$("input[name='filepath']").val(re.data);
            		$('#js_upload_error').text('').css('display','none');
            	}else{
            		$("input[name='filepath']").val('');
            		$('#js_upload_error').text(re.msg).css('display','block');
            	}
           },
           // 展示添加员工页面
           addUserPage:function(){
				$('#js_adduser').on('click',function(){
					var $this=$(this);
					if($('#showUserGroup').html() == ''){
						$.get($this.attr('gurl'),'',function(data){
							$('#showUserGroup').html(data);
							$.customers.groupUserList();
						});
					}
					var pageii = $.layer({
						type: 1,
						title: false,
						area: ['600px', '600px'],
						offset: ['',''],
						bgcolor: '#fff',
						border: [0, 0.3, '#ff9900'], //边框[边框大小, 透明度, 颜色]
						shade: [0.2, '#000'], //遮罩层
						closeBtn: [0, false], //去掉默认关闭按钮
						shift: '', //从左动画弹出
						page: {
							dom:'#showUserGroup'
						}
					});
					//自设关闭
					$('body').on('click','.js_close', function(){
						layer.close(pageii);
					});
				});
           },
           // 部门员工弹出层
           groupUserPop:function(){
        	   $.selectItem.init(150);
        	   this.userlistDisplay();
        	   this.checkboxAll();

               // 提交表单
               $('.js_submitGroupUser').on('click',function(){
//            	   $("form[name='groupUserForm']").submit();
            	   $('.js_user.user_active').each(function(){
            		   // 循环添加员工
            		   if($('#user'+$(this).attr('data')).length == 0){
            			   var id = $(this).attr('data');
            			   var name = $($(this).find('p')[0]).html();
            			   var gid = $(this).parents('.js_group').attr('data');
    					   var uobj = '<div class="js_userid import_list u'+gid+'" id="user'+id+'">\
       	                	<input type="hidden" name="userId[]" value="'+id+'" />\
       	                 	<em>'+name+'</em>\
       	                 	<span class="js_delUserId">X</span>\
       	                 	</div>';
       	        		   $('.js_userlist').append(uobj);
    				   }
            	   });
            	   $('.js_groupuser_div').find("input[type='checkbox']").removeAttr('checked');
            	   $('.js_groupuser_div').find(".js_user").removeClass('user_active');
            	   $('.js_close').trigger('click');
               });
               // 搜索表单
               $('.js_searchBtn_groupUser').on('click',function(){
            	    var $this = $(this);
   					var name = $("input[name='name']").val();
   					var gid = $("input[name='partmentid']").val();

   					$.get($this.attr('gurl'),{name:name,gid:gid},function(data){
   						$('#showUserGroup').find('.js_groupuser_div').find('.mCSB_container').html(data);
   						$.customers.groupUserList();
   					});
               });
               // 增加滚动条
               $(".js_groupuser_div").mCustomScrollbar({
              		//set_width:'100px',
              		callbacks:{ 
              			onTotalScroll:function(){
              			}
              	    },
              	 	horizontalScroll:false  // 是否创建水平滚动条
               });
               $('input[type="checkbox"].minimal').iCheck({
	                  checkboxClass: 'icheckbox_minimal-blue'
	                });
           },
           // 部门员工列表事件
           groupUserList:function(){
        	   // 增加滚动条
               $(".js_user_div").mCustomScrollbar({
             		//set_width:'100px',
             		callbacks:{ 
             			onTotalScroll:function(){
             			}
             	    },
             	 	horizontalScroll:false  // 是否创建水平滚动条
              });
               $('input[type="checkbox"].minimal').iCheck({
	                  checkboxClass: 'icheckbox_minimal-blue'
	                });
           },
           // 部门员工全选| 单个员工选择操作
           checkboxAll:function(){
        	   // 部门员工全选
        	   $('#showUserGroup').on('ifChanged',"input[type='checkbox']",function(){
        		   $.customers.userlist(this);
        		   var $this = $(this).parents('.js_group');
        		   if($this.find("input[type='checkbox']").is(':checked')){
        			   $this.find(".js_user").addClass('user_active');
        		   }else{
        			   $this.find(".js_user").removeClass('user_active');
        		   }
        	   });
        	   // 部门员工单选
        	   $('#showUserGroup').on('click','.js_user',function(){
        		   var $this = $(this).parents('.js_group');
        		   if($(this).hasClass('user_active')){
        			   $(this).removeClass('user_active');
        		   }else{
        			   $(this).addClass('user_active');
        		   }
        		   if($this.find('.js_user').length == $this.find('.js_user.user_active').length){
        			   $this.find("input[type='checkbox']").iCheck('check'); 
        		   }else{
        			   $this.find("input[type='checkbox']").iCheck('uncheck');
        		   }
        	   });
        	   
           },
           
           // 加载部门员工数据
           userlist:function(obj){
    		   $this = $(obj).parents('.js_group');
        	   if($this.find('.js_user_div').find('.mCSB_container').find('.js_user').length == 0){
     			  $.post(getUserlistUrl,{gid:$this.attr('data')},function(re){
     				   $this.find('.js_user_div').find('.mCSB_container').append(re);
     				   // 全选
     				   if($this.find("input[type='checkbox']").is(':checked')){
     					   $this.find(".js_user").addClass('user_active');
	           		   }else{
	           			   $this.find(".js_user").removeClass('user_active');
	           		   }
	           		}).error(function(){
	           			$.global_msg.init({gType:'warning',icon:2,msg:'系统错误,请稍后再试'});
	           		});
     		   }
           },
           // 展开关闭部门详情
           userlistDisplay:function(){
        	   $('.js_groupuser_div').on('click','.js_showgroup',function(){
        		   var $this = $(this).parents('.js_group');
        		   ($this.find('.js_showgroup').hasClass('arrow_up'))?$this.find('.js_showgroup').removeClass('arrow_up'):$this.find('.js_showgroup').addClass('arrow_up');
        		   $.customers.userlist(this);
        		   $this.find('.js_user_div').toggle();
        	   });
           },
           // 添加部门员工后确定后的操作 -- 弃用
           showuser:function(re){
        	   var userid = re.userid;
        	   var groupid = re.groupid;
        	   var uid = '';
        	   // 循环添加部门
        	   for(var group in groupid)
        	   {
        		   $('.js_userlist').find('.u'+group).remove(); // 删除属于这个组的单个员工
        		   if($('#group'+group).length == 0){
	        		   var gobj = '<div class="js_userid" id="group'+group+'">\
	                	<input type="hidden" name="groupId[]" value="'+group+'" />\
	                 	<span>'+groupid[group]+'</span>\
	                 	<span class="js_delUserId">X</span>\
	                 	</div>';
	        		   $('.js_userlist').append(gobj);
        		   }
        	   }
        	   // 循环添加员工
        	   for(var user in userid)
        	   {
        		   if($('#group'+user).length != 0){
        			   continue; // 所在部门存在退出循环
        		   }else{
        			   var userArr = userid[user];
        			   for(var id in userArr){
        				   if($('#user'+userArr[id]['id']).length == 0){
        					   var uobj = '<div class="js_userid u'+user+'" id="user'+userArr[id]['id']+'">\
	       	                	<input type="hidden" name="userId[]" value="'+userArr[id]['id']+'" />\
	       	                 	<span>'+userArr[id]['name']+'</span>\
	       	                 	<span class="js_delUserId">X</span>\
	       	                 	</div>';
	       	        		   $('.js_userlist').append(uobj);
        				   }
        			   }
        		   }
        	   }
        	   $('.js_close').trigger('click');
           },
           // 删除部门|员工
           delUserOrGroup:function(){
        	   $('body').on('click','.js_delUserId',function(){
        		   $(this).parent('.js_userid').remove();
        	   });
           },
           // 导入操作表单验证
           fempty:function (){
        	   if($("input[name='filepath']").val() == ''){
        		   $('#js_upload_error').text('还没有上传客户数据模板文件').css('display','block');
        		   return false;
        	   }else{
       				$('#js_upload_error').text('').css('display','none');
        	   }
        	   if($(".js_userlist").find('.js_userid').length == 0){
       				$('#js_user_error').text('还没有分配员工').css('display','block');
       				return false;
       		   }else{
       			    $('#js_user_error').text('').css('display','none');
       		   }
       		   return true;
       		},
       		// 导入后回掉
       		importReturn:function(re){
       			if(re.status == '1'){
       		        $.global_msg.init({gType:'warning',icon:re.status,msg:re.msg,endFn:function(){location.href = re.url;}});
       			}else{
       		        $.global_msg.init({gType:'warning',icon:re.status,msg:re.msg});
       			}
       		},
            //客户公司页面
            company:function(){
                var that = this;
                $('#js_search_btn').on('click',function(){ //点击查询
                    that. searchCompany();
                });

              /*  $('.js_show_one').on('click',function(){
                    var name= $(this).attr('name-data');
                    that.showCompany(name);

                })*/

            },
            //查询客户公司
            searchCompany:function(){
                var condition = '';
                var name=encodeURIComponent($('#js_company_name').val());
                if(name!=''){ //企业名称
                    condition+='/name/' + name;
                }
                if(p!=''){ //页数
                    condition+='/p/'+p;
                }
                window.location.href=searchUrl+condition;

            },
            //查看单个公司
            showCompany:function(name){
                window.location.href=showUrl+'/name/'+name;

            },
            /*企业详情菜单切换*/
            companyDetailMenuSwitch:function(){
                $('.js_menu_list').on('click',function(){
                    if(!$(this).hasClass('menuli')){ //菜单样式
                        $('.js_menu_list').removeClass('menuli');
                        $(this).addClass('menuli');
                        $(".js_content_warmp").hide();
                        var menukey = $(this).attr('data-menu-key');
                        if($(".js_content_warmp[data-menu-key="+menukey+"]").length ==1){ //判断是否加载过
                            $(".js_content_warmp[data-menu-key="+menukey+"]").show();
                        }else{
                            $.ajax({
                                url:'/Company/Customer/menuSwitch',
                                type:'post',
                                dataType:'json',
                                data:{
                                    type:menukey,
                                    name:$('#js_name_info').html()
                                },success:function(res){
                                    //成功
                                    if(res.status==0){
                                        $('#js_data_content').append(res.datas);
                                    }else{

                                    }
                                },error:function(res){
                                    //失败

                                }
                            });

                        }
                    }


                });

            }

        }
    });
})(jQuery);