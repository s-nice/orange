$(function(){
	//点击添加管理员,角色
	$.extend({
		admin:{
			layer_div:null,//弹出框，保存在这，方便关闭
			wHeight:null,//屏幕高度
			type:null,//ADD_ADMIN,ADD_ROLE,EDIT_ADMIN,EDIT_ROLE,DEL_ADMIN
			layer_admin:null,
			layer_role:null,
			layer_size:{ADD_ADMIN:{width:440,height:500},ADD_ROLE:{height:400,width:440},EDIT_ADMIN:{height:500,width:440},EDIT_ROLE:{height:300,width
				:440},EDIT_PERMISSION:{width:692,height:636}},
			init:function(){
				//初始化，获取角色弹框和管理员弹框的对象以及高度信息
				this.wHeight = $(window).height();
				this.layer_admin = $('#add_admin_dom');
				this.layer_role = $('#add_role_dom');
				this.layer_size.ADD_ADMIN.height = this.layer_size.EDIT_ADMIN.height = this.layer_admin.height();
				this.layer_size.ADD_ROLE.height = this.layer_size.EDIT_ROLE.height = this.layer_role.height();
			},
			//返回数据处理，根据当前的type值，可以判断此时的操作，并处理返回的数据
			ajaxReturn:function(result){
				switch(this.type){
					case 'ADD_ADMIN':
						//添加修改管理员成功
						if(result.status==0){
							layer.close(this.layer_div);
							var params = {gType:'alert',time:1,icon:1,msg:result.msg,endFn:function(){window.location.reload();}};
							if(typeof result.endFn != 'undefined'){
								params = {gType:'alert',time:3,icon:1,msg:result.msg,endFn:function(){location.href = result.endFn;}};
							}
							$.global_msg.init(params);
						}else{
							$.global_msg.init({gType:'alert',time:3,icon:0,msg:result.msg});
						}
							
					break;
					case 'EDIT_ADMIN':
						//点击修改管理员后，得到此管理员的所有数据
						if(result.status=='0'){
							//将此管理员的数据填充到弹框中
							this.fillData(result.data);
						}
					break;
					case 'ADD_ROLE':
						//添加角色成功
						if(result.status==0){
							layer.close(this.layer_div);
							var params = {gType:'alert',icon:1,time:1,msg:result.msg,endFn:function(){window.location.reload();}};
							if(typeof result.endFn != 'undefined'){
								params = {gType:'alert',icon:1,time:1,msg:result.msg,endFn:function(){location.href = result.endFn;}};
							}
							$.global_msg.init(params);
						}else{
							$.global_msg.init({gType:'alert',time:3,icon:0,msg:result.msg});
						}
					break;
					case 'EDIT_ROLE':
						//点击修改角色后，得到此角色的所有数据
						if(result.status=='0'){
							//将此角色的数据填充到弹框中
							this.fillData(result.data);
						}
					break;
					case 'EDIT_PERMISSION':
						//点击修改权限后，获取到此角色的权限列表所生成的TPL，并弹出
						if(result.status==0){
							this.layer(result.html);
						}
					break;

				}
			},
			//弹出框，根据不同的type值，弹出不同的框
			layer:function(html){
				var oDiv;
				switch(this.type){
					case 'ADD_ADMIN':
					 oDiv = {dom:this.layer_admin};
					break;
					case 'ADD_ROLE':
					 oDiv = {dom:this.layer_role};
					break;
					case 'EDIT_ADMIN':
					 oDiv = {dom:this.layer_admin};
					break;
					case 'EDIT_ROLE':
					 oDiv = {dom:this.layer_role};
					break;
					case 'EDIT_PERMISSION':
						//当修改权限时，之所以在权限tpl外再套一个DIV是为了好清空
						$('#layer_div').html('<div id="layer_in" style="display:none;"></div>');
						$('#layer_in').html(html);
						this.layer_size[this.type].height = $('#layer_in').height();
						oDiv = {dom:$('#layer_in')};
					break;
				}
				//弹框高度
				var oHeight = this.layer_size[this.type].height;
				var oWidth = this.layer_size[this.type].width;
				//当弹框高度高于屏幕高度时，滚动
				if(oHeight>this.wHeight){
					var offsetHeight = '0px';
					oDiv.dom.mCustomScrollbar({
                                theme:"dark", //主题颜色
                                set_height:this.wHeight,
                                autoHideScrollbar: false, //是否自动隐藏滚动条
                                scrollInertia :0,//滚动延迟
                                horizontalScroll : false//水平滚动条
                            });
				}else{					
					var offsetHeight = parseInt((this.wHeight-oHeight)/2)+'px';
				}
				this.layer_div = $.layer({
	                type: 1,
	                title: false,
	                area: [oWidth+'px',, oHeight+'px'],
	                offset: [offsetHeight, ''],
	                bgcolor: '#ccc',
	                border: [0, 0.3, '#ccc'], 
	                shade: [0.2, '#000'], 
	                closeBtn:false,
	                page: oDiv,
	                shadeClose:true,
	            });
			},
			//清除管理员和角色弹框中的数据，此操作发生在添加管理员和添加角色的时候
			clearInput:function(){
				switch(this.type){
					case 'ADD_ADMIN':
						this.layer_admin.find('input[type=text],input[type=hidden],input[type=password]').val('');
						this.layer_admin.find('input[name=email]').attr('readonly',false).css({'border-width':'1px'});
						$('#add_admin_dom .js_role_name').html('');
						$('#add_admin_dom input[name=roleid]').val('');
					break;
					case 'ADD_ROLE':
						this.layer_role.find('input[type=text],input[type=hidden]').val('');
						this.layer_role.find('.js_status_span').text('');
						$('#js_sel_content').hide();
					break;
				}
			},
			//填充数据，将从后台获取的数据填充到弹框中，修改管理员，修改角色，修改权限时用到
			fillData:function(data){
				switch(this.type){
					case 'EDIT_ADMIN':
						$('.Administrator_password b:lt(2)').html('');
						$('.Administrator_user b').html('');
						$('.Administrator_title').html(str_edit_admin);
						this.layer_admin.find('input[name=email]').val(data.email).attr('readonly',true).css({'border-width':'0px'});
						this.layer_admin.find('input[name=password]').val(data.password);
						this.layer_admin.find('input[name=repassword]').val(data.password);
						this.layer_admin.find('input[name=realname]').val(data.realname);
						this.layer_admin.find('input[name=adminid]').val(data.adminid);
					break;
					case 'EDIT_ROLE':
						this.layer_role.find('input[name=name]').val(data.name);
						this.layer_role.find('input[name=dispname]').val(data.displayname);
						this.layer_role.find('input[name=roleid]').val(data.roleid);
						this.layer_role.find('input[name=status]').val(data.status);
						var val = data.status;
						var text = $('#js_sel_content').find("li[val="+val+"]").text();
						this.layer_role.find('.js_status_span').text(text);
						$('#js_sel_content').hide();
					break;
					case 'EDIT_PERMISSION':

					break;
				}
				this.layer();
			},
			//管理员弹框中的 角色下拉菜单 进行填充
			fillSelect:function(rolelist,roleid){
				$('#js_sel_content').remove();
				var html = '<ul id="js_sel_content">';
				$.each(rolelist,function(k,v){
					if(roleid&&(v.roleid==roleid)){
						$('#add_admin_dom .js_role_name').html(v.name);
						$('#add_admin_dom .js_role_name').attr('title',v.name);
						$('#add_admin_dom input[name=roleid]').val(v.roleid);
					}
					html+='<li val="'+v.roleid+'" title="'+v.name+'">'+v.name+'</li>';
				});
				html+='</ul>';
				$('#js_sel_status').after(html);
				$('#js_sel_content').mCustomScrollbar({
		            theme:"dark", //主题颜色
		            set_height:50,
		            autoHideScrollbar: false, //是否自动隐藏滚动条
		            scrollInertia :0,//滚动延迟
		            horizontalScroll : false,//水平滚动条
		        });
			}
		}

	});
	$.admin.init();

	//点击添加管理员
	$('#js_addadmin').click(function(){
		$.admin.type='ADD_ADMIN';
		$.post(url_editadmin,{},function(result){
			$.admin.clearInput();
			$.admin.fillSelect(result.rolelist,null);
			$('.Administrator_password b:lt(2)').html('*');
			$('.Administrator_user b').html('*');
			$('.Administrator_title').html(str_add_admin);
			$.admin.layer();
		})
	});

	//选择角色状态
	$(document).on('click','#js_sel_status',function(){
		$('#js_sel_content').toggle();
	});
	//点击角色状态选择
	$('#add_role_dom').on('click','#js_sel_content li',function(){
		var val = $(this).attr('val');
		var text = $(this).text();
		$('#add_role_dom').find('input[name=status]').val(val);
		$('#add_role_dom').find('.js_status_span').html(text);
		$('#js_sel_content').hide();
	});
	//角色下拉框 选择角色
	$('#add_admin_dom').on('click','#js_sel_content li',function(){
		var val = $(this).attr('val');
		var text = $(this).text();
		$('#add_admin_dom input[name=roleid]').val(val);
		$('#add_admin_dom .js_role_name').html(text);
		$('#add_admin_dom .js_role_name').attr('title',text);
		$('#js_sel_content').hide();
	});
	//添加角色
	$('#js_addrole').click(function(){
		$.admin.type= 'ADD_ROLE';
		$('.Administrator_title').html(str_add_role);
		$.admin.clearInput();
		$.admin.layer();
	});
	//添加修改管理员提交
	$('#add_admin_dom').on('click','.js_add_sub',function(){
		var adminid = $('#add_admin_dom input[name=adminid]').val();
		var password = $('#add_admin_dom input[name=password]').val();
		var repassword = $('#add_admin_dom input[name=repassword]').val();
		var email = $('#add_admin_dom input[name=email]').val();
		var realname = $('#add_admin_dom input[name=realname]').val();
		var roleid = $('#add_admin_dom input[name=roleid]').val();
		//adminid有值为修改管理员，否则为添加
		if(adminid){
			$.admin.type='EDIT_ADMIN';
			if(!email||!realname){
				$.global_msg.init({gType:'alert',icon:0,msg:tip_has_blank,time:3});
				return false;
			}
		}else{
			$.admin.type='ADD_ADMIN';
			//添加管理员时，都不能为空
			if(!email||!password||!repassword||!realname){
				$.global_msg.init({gType:'alert',icon:0,msg:tip_has_blank,time:3});
				return false;
			}
		}
		//两次密码是否一致
		if(password!==repassword){
			$.global_msg.init({gType:'alert',icon:0,msg:tip_passwds_not_match,time:3});
			return false;
		}
		//是否选择角色
		if(!roleid){
			$.global_msg.init({gType:'alert',icon:0,msg:tip_no_roleid,time:3});
			return false;
		}
		//json_str为所提交的数据对象
		if($.admin.type=='ADD_ADMIN'){
			var json_str= {email:email,realname:realname,passwd:password,roleid:roleid};
		}else if($.admin.type=='EDIT_ADMIN'){
			var json_str = {email:email,realname:realname,passwd:password,adminid:adminid,roleid:roleid};
		}
		$.post(url_addadmin_post,json_str,function(result){
			$.admin.type='ADD_ADMIN';
			$.admin.ajaxReturn(result);
		});
	});

	//添加修改角色提交
	$('#add_role_dom').on('click','.js_add_sub',function(){
		var name = $('#add_role_dom input[name=name]').val();
		var dispname = $('#add_role_dom input[name=dispname]').val();
		var roleid = $('#add_role_dom input[name=roleid]').val();
		var status = $('#add_role_dom input[name=status]').val();
		//角色名，描述，状态都不能为空
		if(!name||!dispname||!status){
			$.global_msg.init({gType:'alert',icon:0,msg:tip_has_blank,time:3});
			return false;
		}
		if(name.length>48){
			$.global_msg.init({gType:'alert',icon:0,msg:tip_rolename_length,time:3});
			return false;
		}
		if(dispname.length>48){
			$.global_msg.init({gType:'alert',icon:0,msg:tip_dispname_length,time:3});
			return false;
		}
		if(roleid){
			$.admin.type='EDIT_ROLE';
		}else{
			$.admin.type='ADD_ROLE';
		}
		//json_str为要提交的数据对象
		if($.admin.type=='ADD_ROLE'){
			var json_str= {name:name,dispname:dispname,status:status};
		}else if($.admin.type=='EDIT_ROLE'){
			var json_str = {name:name,dispname:dispname,roleid:roleid,status:status};
		}
		$.post(url_addrole_post,json_str,function(result){
			$.admin.type='ADD_ROLE';
			$.admin.ajaxReturn(result);
		});
	});

	//关闭弹框
	$('.appadmin_addAdministrator').on('click','.js_add_cancel,.appadmin_unlock_close img',function(){
		layer.close($.admin.layer_div);
	});


	//删除管理员
	$('.js_op_admin').on('click','em',function(){
		var _this = $(this);
		$.global_msg.init({gType:'confirm',icon:2,msg:tip_confirm_admin,btns:true,title:false,close:true,btn1:str_btn_cancel ,btn2:str_btn_ok,noFn:function(){
			var adminid = _this.parent().attr('adminid');
			$.post(url_deladmin,{adminid:adminid},function(result){
				if(result.status==0){
					$.global_msg.init({gType:'alert',icon:1,msg:result.msg,time:1,endFn:function(){
						window.location.reload();
					}});
				}else{
					$.global_msg.init({gType:'alert',icon:0,msg:result.msg,time:3});
				}
			})
		}});	
		
	});

	//编辑 管理员
	$('.js_op_admin').on('click','b',function(){
		$.admin.type = 'EDIT_ADMIN';
		var adminid = $(this).parent().attr('adminid');
		$.post(url_editadmin,{adminid:adminid},function(result){
			if (typeof result.status != 'undeinfed' && result.status!=0) {
				$.global_msg.init({gType:'warning',icon:2,msg:result.msg,time:5});
				return;
			}
			$.admin.fillSelect(result.rolelist,result.data.roleid);
			$.admin.ajaxReturn(result);
		})
	})

	//编辑 角色
	$('.js_op_role').on('click','.js_edit_role',function(){
		$.admin.type = 'EDIT_ROLE';
		$('.Administrator_title').html(str_edit_role);
		var roleid = $(this).parent().attr('roleid');
		$.post(url_editrole,{roleid:roleid},function(result){	
			$.admin.ajaxReturn(result);
		})
	});
	//删除角色
	$('.js_op_role').on('click','.js_del_role',function(){
		var _this = $(this);
		$.global_msg.init({gType:'confirm',icon:2,msg:tip_confirm_role,btns:true,title:false,close:true,btn1:str_btn_cancel ,btn2:str_btn_ok,noFn:function(){
			var roleid = _this.parent().attr('roleid');
			$.post(url_delrole,{roleid:roleid},function(result){	
				if(result.status==0){
					$.global_msg.init({gType:'alert',icon:1,msg:result.msg,time:1,endFn:function(){
						window.location.reload();
					}});
				}else{
					$.global_msg.init({gType:'alert',icon:0,msg:result.msg,time:3});
				}
			})
		}});
	});

	//权限设置
	$('.js_op_role').on('click','.js_permission',function(){
		$.admin.type = 'EDIT_PERMISSION';
		var roleid = $(this).parent().attr('roleid');
		$.post(url_editpermission,{roleid:roleid},function(result){
			$.admin.ajaxReturn(result);
		})
	});

	//点击权限选择框
	$(document).on('click','.check-td i',function(){
		$(this).toggleClass('active');
	});

	//关闭权限管理弹框
	$(document).on('click','#role_permission .js_logoutcancel,#role_permission .js_add_cancel',function(){
		layer.close($.admin.layer_div);
	});

	//权限设置提交
	$(document).on('click','#role_permission .js_add_sub',function(){
		var arr = [];
		$('#role_permission .check-td i.active').each(function(){
			var rname = $(this).parent().attr('rname');
			arr.push(rname);
		});
		var roleid = $('#role_permission input[name=roleid]').val();
		var str = $.trim(arr.join(','));
		$.post(url_permission_post,{str:str,roleid:roleid},function(result){
			//alert(result);return false;
			if(result.status==0){
				layer.close($.admin.layer_div);
				var params = {gType:'alert',icon:1,msg:result.msg,time:1};
				if(typeof result.endFn != 'undefined'){
					params = {gType:'alert',icon:1,msg:result.msg,time:1,endFn:function(){location.href = result.endFn;}};
				}
				$.global_msg.init(params);
				return false;
			}else if(result.status==1){
				$.global_msg.init({gType:'alert',icon:0,msg:result.msg,time:3});
				return false;
			}else{
				$.global_msg.init({gType:'alert',icon:0,msg:tip_program_error,time:3});
				return false;
			}
		})
	});
});