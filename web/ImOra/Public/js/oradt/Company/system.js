$.extend({
	'system':{
		layer_user :null,//保存选择员工弹框
		layer_access: null,//保存选择权限弹框
		//角色列表
		role:function(){
			$('.btn_del').on('click',function(){
				var roleid = $(this).parents('.apply_list').attr('roleid');
				$.global_msg.init({gType:'confirm',icon:2,msg:confirm_del_role,btns:true,title:false,close:true,btn1:'取消' ,btn2:'确定',noFn:function(){
					$.post(delRoleUrl,{id:roleid},function(re){
						if(re.status===0){
							$.global_msg.init({gType:'alert',time:1,icon:1,msg:re.msg,endFn:function(){
								window.location.reload();
							}});
						}else{
							$.global_msg.init({gType:'alert',time:3,icon:0,msg:re.msg});
							return false;
						}
					});
				}});
			});
		},

		//新增编辑角色
		addRole:function(){
			//点击添加员工
			_this = this;
			$('#js_add_user').on('click',function(){
				_this.setLayer('user');
			});
			//点击添加权限
			$('#js_add_access').on('click',function(){
				_this.setLayer('access');
			});

			//确认添加员工
			$('#div_layer_user').on('click','.btn-sub',function(){
				$('#js_user_list').html('');
				$('.act').each(function(){
					var obj = {};
					obj.id = $(this).attr('data_val');
					obj.name = $(this).find('.js_user_name').text();
					var num = $('.span_user_name[data_id='+obj.id+']').length;
					if(!num){
						$('#js_user_list').append('<span data_id="'+obj.id+'" class="span_user_name"><i>'+obj.name+'</i><em>X</em></span>');
					}
				});
				layer.close(_this.layer_user);
			});

			//关闭员工选择窗口
			$('#div_layer_user').on('click','.close_X',function(){
				layer.close(_this.layer_user);
			});

			//查询员工
			$('#div_layer_user').on('click','.js_department_search',function(){
				var department = $('#input_department').val();
				var emplayee = $('input[name=employee_name]').val();
				if(emplayee){

					/*$('.div_department_content').hide();
					var oList = $('.span_title[title='+department+']').parents('.div_department_title').next();*/
					/*if(department){
						$('.div_department').hide();
						var oTitle = $('.span_title[title='+department+']');
						if(oTitle.length){
							_this._showOrHide(oTitle.parents('.div_department').find('p.js_user_name'));
						}
					}else{*/
						$('.div_department').hide();
						_this._showOrHide($('p.js_user_name'),emplayee);
					//}
				}else{
					if(department){
						$('.div_department').hide();
						var oTitle = $('.span_title[title='+department+']');
						if(oTitle.length){
							var oDepart = oTitle.parents('.div_department');
							oDepart.show().find('.div_department_content').show().find('.user_block').show();
							//.parents('.div_department_title');
						}
					}else{
						$('.div_department').show().find('.user_block').show();
						$('.div_department_content').hide();
						var oDepart = $('.div_department:eq(0)');
						if(oDepart.length){
							oDepart.find('.div_department_content').show();
							//.parents('.div_department_title');
						}
						/*var oList = $('.span_title[title='+department+']').parents('.div_department_title').next();*/
					}
				}
			});
			
			//显示隐藏
			$('#js_add').on('click','.span_tab',function(){
				$(this).toggleClass('arrow_up'); // 折叠标识箭头切换方向
				$(this).parents('.div_department_title').next().toggle();
			});

			//员工选择取消
			$('#div_layer_user').on('click','.user_block',function(){
				var data_val = $(this).attr('data_val');
				$('.user_block[data_val='+data_val+']').toggleClass('act');
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

			//权限全选
			$('#div_layer_access').on('click','.js_all_check',function(){
				var oInput = $(this).parents('.div_department_title').next().find('.span_access_con input');
				if($(this).is(':checked')){
					oInput.prop('checked',true);
				}else{
					oInput.prop('checked',false);
				}
			});

			//取消已选择的员工
			$('#js_user_list').on('click','.span_user_name',function(){
				var data_id = $(this).attr('data_id');
				$('.user_block[data_val='+data_id+']').removeClass('act');
				$(this).remove();
			})

			//确认选择权限
			$('#div_layer_access').on('click','.btn-sub',function(){
				$('.div_access_list span').hide();
				$('.tr_access').hide(); 
				$('.access_list').hide(); 
				$('.span_access_con input:checked').each(function(){
					var data_val = $(this).parent().attr('data_val');
					var oSpan = $('.div_access_list span[data_val='+data_val+']');
					var oDiv_m = oSpan.parents('.access_middle');
					oSpan.show();
					oSpan.parents('.tr_access').show();
					oDiv_m.parents('.access_list').show();
					_this.setAuthorList(oDiv_m);
				});
				layer.close(_this.layer_access);
			});

			//关闭选择权限窗口
			$('#div_layer_access').on('click','.close_X',function(){
				layer.close(_this.layer_access);
			});

			//取消已选择的权限
			$('.div_access_list span').on('click',function(){
				var data_val = $(this).attr('data_val');
				$(this).hide();
				var oInput = $('.span_access_con[data_val='+data_val+']').find('input');
				oInput.prop('checked',false);
				oInput.parents('.div_department_content').prev().find('input.js_all_check').prop('checked',false);
				var tr_access = $(this).parents('.tr_access');
				var num = tr_access.find('span:visible').length;
				if(num==0){
					tr_access.hide();
					_this.setAuthorList(tr_access.parents('.access_middle'));
				}
			})

			//提交保存
			$('#js_access_save').on('click',function(){
				var id = $('input[name=id]').val();
				var rolename = $('input[name=rolename]').val();
				var remark = $('input[name=remark]').val();
				if(!rolename||!remark){
					$.global_msg.init({gType:'alert',time:3,icon:0,msg:tip_cannt_empty});
					return false;
				}
				var arr_access = [],arr_users = [];
				$('.div_access_list span:visible').each(function(){
					arr_access.push($(this).attr('data_val'));
				});
				$('.span_user_name').each(function(){
					arr_users.push($(this).attr('data_id'));
				});
				var str_users = arr_users.join(',');
				var str_access = arr_access.join(',');
				$.post(setPostUrl,{id:id,rolename:rolename,remark:remark,users:str_users,access:str_access},function(re){
					if(re.status===0){
						$.global_msg.init({gType:'alert',time:1,icon:1,msg:re.msg,endFn:function(){
							window.location.href = successTurnUrl;
						}});
						//return false;
					}else{
						$.global_msg.init({gType:'alert',time:3,icon:0,msg:re.msg});
						return false;
					}
				});
			});

			//取消返回
			$('#js_access_cancel').on('click',function(){
				window.history.back(-1);
			});
		},

		_showOrHide:function(oDom,emplayee){
			$.each(oDom,function(){
					var v = $(this);
					console.log(v.html());
					if(v.html()==emplayee){
						v.parent().show().parents('.div_department_content').show().parents('.div_department').show();
					}else{
						v.parent().hide();
					}
				});
		},

		//更换邮箱
		updateEmail:function(){
			$('#js_email_sub').on('click',function(){
				var pass = $('input[name=pass]').val();
				var newemail = $('input[name=newemail]').val();
				if(!gVerifyBool){
					$('#td').attr('data-content','验证码验证失败');
					$('#td').popover({placement:'left', trigger:'manual'});
					$('#td').popover('show');
					return;
				}
				if(!pass||!newemail){

					$.global_msg.init({gType:'alert',time:3,icon:0,msg:tip_has_blank});
					return false;
				}
				var  emailpreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
				if(!emailpreg.test(newemail)){
					$.global_msg.init({gType:'alert',time:3,icon:0,msg:tip_effective_email});
						return false;
				}
				$.post(postUrl,{pass:pass,newemail:newemail},function(re){
					if(re.status===0){
						$.global_msg.init({gType:'alert',time:1,icon:1,msg:re.msg,endFn:function(){
								window.location.reload();
							}});
					}else{
						$.global_msg.init({gType:'alert',time:3,icon:0,msg:re.msg});
						return false;
					}
				});
			});
		},

		//更改密码
		updatePass:function(){
			$('#js_uppass_sub').on('click',function(){
				var oldpass = $('input[name=oldpass]').val();
				var newpass = $('input[name=newpass]').val();
				var re_newpass = $('input[name=re_newpass]').val();
				if(!gVerifyBool){
					$.global_msg.init({gType:'alert',time:3,icon:0,msg:'验证码验证失败'});
					return false;
				}
				if(!oldpass||!newpass||!re_newpass){
					$.global_msg.init({gType:'alert',time:3,icon:0,msg:tip_has_blank});
					return false;
				}
				if(newpass!==re_newpass){
					$.global_msg.init({gType:'alert',time:3,icon:0,msg:tip_pwd_not_eq});
					return false;
				}
				$.post(postUrl,{oldpass:oldpass,newpass:newpass},function(re){
					if(re.status===0){
						$.global_msg.init({gType:'alert',time:1,icon:1,msg:re.msg,endFn:function(){
								window.location.reload();
							}});
					}else{
						$.global_msg.init({gType:'alert',time:3,icon:0,msg:re.msg});
						return false;
					}
				});
			});
		},
		setLayer:function(name){
			_this = this;
			var oDiv = $('#div_layer_'+name);
			var url = eval('get'+name+'Url');
			var obj = (name=='user')?_this.layer_user:_this.layer_access;
			if(!obj){
				$.ajax({
					'type':'post',
					'async':false,
					'dataType':'json',
					'url':url,
					'success':function(re){
						if(re.status===0){
							oDiv.html(re.html);
							if(name=='user'){
								$('.span_user_name').each(function(){
									var empid = $(this).attr('data_id');
									$('.user_block[data_val='+empid+']').addClass('act');
								});
								$('.div_department').each(function(){
									var bool = true;
									$(this).find('.user_block').each(function(){
										if(!$(this).hasClass('act')){
											bool = false;
											return false;
										}
									});
									if(!$(this).find('.user_block').length){
										bool = false;
									}
									if(bool==true){
										$(this).find('.js_all_check').prop('checked',true);
									}
								});
							}else if(name=='access'){
								$('.js_access_name:visible').each(function(){
									var empid = $(this).attr('data_val');
									console.log(empid);
									$('.span_access_con[data_val='+empid+']').find('input').prop('checked',true);
								});
								$('.div_department').each(function(){
									var bool = true;
									$(this).find('.span_access_con input').each(function(){
										if(!$(this).is(':checked')){
											bool = false;
											return false;
										}
									});
									if(!$(this).find('.span_access_con input').length){
										bool = false;
									}
									if(bool==true){
										$(this).find('.js_all_check').prop('checked',true);
									}
								});
							}
						}
					}
				});

			}
			oScroll = oDiv.find('.js_scroll_height');
			var dHeight = oScroll.height();
            if(dHeight>530){
                oScroll.mCustomScrollbar({
                                theme:"dark", //主题颜色
                                set_height:530,
                                autoHideScrollbar: false, //是否自动隐藏滚动条
                                scrollInertia :0,//滚动延迟
                                horizontalScroll : false//水平滚动条
                            });
            }
			if(name=='user'){
				_this.layer_user= $.layer({
	                type: 1,
	                title: false,
	                area: ['600px','600px'],
	                offset: ['', ''],
	                bgcolor: '#fff',
	                border: [0, 0.3, '#ccc'], 
	                shade: [0.2, '#000'], 
	                closeBtn:false,
	                page:{dom:oDiv},
	                shadeClose:true,
	            });
			}else if(name=='access'){
				_this.layer_access= $.layer({
	                type: 1,
	                title: false,
	                area: ['600px','600px'],
	                offset: ['', ''],
	                bgcolor: '#fff',
	                border: [0, 0.3, '#ccc'], 
	                shade: [0.2, '#000'], 
	                closeBtn:false,
	                page:{dom:oDiv},
	                shadeClose:true,
	            });
			}
		},
		//判断修改权限列表最左侧模块名称的高度样式
		setAuthorList:function(oDiv_m){
			var oDiv_l = oDiv_m.prev();
			var oDiv_t = oDiv_m.parents('.access_list');
			var num = oDiv_m.attr('num');
			var new_num = oDiv_m.find('.tr_access:visible').length;
			oDiv_m.attr('num',new_num).removeClass('access_middle_'+num).addClass('access_middle_'+new_num);
			oDiv_l.removeClass('access_left_'+num).addClass('access_left_'+new_num);
			oDiv_t.removeClass('access_list_'+num).addClass('access_list_'+new_num);
		},
	}
});


