$(function(){
	$('.js_content_menu>li').click(function(){
		window.location.href = $(this).attr('url');
	});
});
$.extend({
	//添加短信规则
	addSms:{
		smsInit: function(){
			this.smsBindEvnt();
		},
		smsBindEvnt: function(){
			//调用复选框插件
			window.gChannelCheckObj = $('.js_coll_info_content').checkDialog({checkAllSelector:'.js_allselect',
				checkChildSelector:'.js_select',valAttr:'val',selectedClass:'active'});//,clickFn:$.contactsRec.addIndex.checkCall
			$('#js_btn_ok').click(function(){/*保存按钮*/
				$.addSms.smsSubmitData();
			});
			$('#js_btn_cancel').click(function(){/*取消按钮*/
				
			});
		},
		//验证并提交数据
		smsSubmitData: function(){
			var cardType = $('#cardType').val(); //卡类型
			var pushUnits = $('#pushUnits').val(); //推送单位
			var source  = $('#source').val(); //来源
			var keyword     = $('#kwd').val(); //关键字
			var sign    = $('#sign').val(); //签名
			var data = {cardType:cardType, pushUnits:pushUnits, source:source, keyword:keyword, sign:sign};
			var checkSelect = $('.js_select').filter('.active'); //获取提取信息中选中的数据
			var COLL_ARR_ALL = array('collDate','collCardNum','collPayMoney','collOverage');
			$.each(checkSelect,function(i,dom){
				var index = $('.js_select').index(dom);
				data[COLL_ARR_ALL[index]] = $('#'+COLL_ARR_ALL[index]).val();
			});
			
			$.ajax({
				url: url,
				data:data,
				async: false,
				dataType: 'json',
				success: function(rst){
					
				}
			});
		}
	},
	//添加邮件规则
	addMail:{
		mailInit: function(){
			
		},
		mailBindEvnt: function(){
			
		},
		mailSubmitData: function(){
			
		}
	},
	smsType:{
		listPage:function(){
			// 时间段
			$.dataTimeLoad.init({format:'Y-m-d H:i',timepicker:true,idArr: [{start:'js_begintime',end:'js_endtime'}]});
			// 复选框
			smsTypeCheckObj = $('#js_checkboxdiv').checkDialog({checkAllSelector:'#js_allselect',checkChildSelector:'.js_select',valAttr:'val',selectedClass:'active',clickFn:function(){
				if(smsTypeCheckObj.getCheck().length > 0){
					$('.js_delSmsType').removeClass('button_disabel');
				}else{
					$('.js_delSmsType').addClass('button_disabel');
				}
			}});
			// 新增
			$('.js_addSmsType').on('click',function(){
				window.location.href = $(this).attr('jsurl');
			});
			// 删除
			$('.js_delSmsType').on('click',function(){
				var $this = $(this);
				if(!$this.hasClass('button_disabel')){
					var smsid = smsTypeCheckObj.getCheck();
					var numTotal = smsid.length;
					if(numTotal > 0){
						$.global_msg.init({gType:'confirm',msg:'确认删除内容类型？',btns:true,title:false,btn1:'确定',btn2:'取消',fn:function(){
							var succ = [];
							var fail = [];
							for (var i in smsid){
								// 判断是否被提取规则使用 决定是否可以删除
								var status = $.smsType.smsTypeHaveStatus(smsid[i]);
								if(status == 10){
									succ.push(smsid[i]);
								}else{
									fail.push(smsid[i]);
								}
							}
							if(fail.length >0 ){
								if(fail.length == numTotal){
									$.global_msg.init({gType:'warning',icon:2,msg:'有提取规则在使用所选类型，不能删除'});
								}else if(fail.length < numTotal){
									$.global_msg.init({gType:'warning',icon:2,msg:'有提取规则在使用所选的部分类型，不能删除'});
								}
							}else{
								$.post($this.attr('jsurl'),{id:smsid},function(re){
									if(re.status == '0'){
										$.global_msg.init({gType:'warning',icon:1,msg:re.msg,endFn:function(){
							                window.location.reload(true);
										}});
			               			}else{
			               				$.global_msg.init({gType:'warning',icon:2,msg:re.msg});
			               			}
								}).error(function(){	
									$.global_msg.init({gType:'warning',icon:0,msg:'网络错误'});
				            	});
							}
						}});
					}else{
						$.global_msg.init({gType:'warning',icon:2,msg:'请选择需要删除的内容类型'});
					}
				}
			});
		},
		/**
		 * 指定内容类型中属性是否已被使用   
		 * 状态码(int) 1:已被使用  10:没有使用  3:未知错误
	     * @return int
		 */ 
		typeInfoStatus:function(infoId){
			var status = 1;
			$.ajax({  
		         type : "post",  
		         url : infoStatusUrl,  
		         data : {id:infoId},  
		         async : false,  
		         success : function(re){  
		            status = re;
		         } 
		     });
			return status;
		},
		/**
		 * 指定内容类型是否已被提取规则使用  
		 * 状态码(int) 1:已被使用  10:没有使用  3:未知错误
	     * @return int
		 */ 
		smsTypeHaveStatus:function(smsId){
			var status = 1;
			$.ajax({  
		         type : "post",  
		         url : smsTypeHaveStatusUrl,  
		         data : {smsid:smsId},  
		         async : false,  
		         success : function(re){  
		            status = re;
		         } 
		     });
			return status;
		},
		
		/**
		 * 指定内容类型名称是否存在
		 * 状态码 2:不存在 10：已存在 3：未知错误
	     * @return array $re=array('status'=>状态码,'info'=>array('id','info'))
		 */ 
		typeHaveStatus:function(name){
			var status = {"status":"1"}
			$.ajax({  
		         type : "post",  
		         url : typeHaveStatusUrl,  
		         data : {name:name},  
		         async : false,  
		         success : function(re){  
		            status = re;
		         } 
		     });
			return status;
		},
		// 获得内容类型属性值
		getSmsInfoForArr:function(){
			var arr = [];
			$("input[type='checkbox'][name='type[]']").each(function(e){
				arr.push($(this).val());
			});
			return arr;
		},
		// 全选按键勾选状态
		checkBoxAll:function(){
			($("input[type='checkbox'][name='type[]']").length != 0 && $("input[type='checkbox'][name='type[]']:checked").length == $("input[type='checkbox'][name='type[]']").length) ?
					$('#js_checkbox_all').prop('checked','checked'):
					$('#js_checkbox_all').prop('checked',false);
		},
		// 删除|修改按键的显示隐藏
		btnShowOrHide:function(){
			$("input[type='checkbox'][name='type[]']:checked").length > 0 ?
					$('#js_delinfo').removeClass('button_disabel'):
					$('#js_delinfo').addClass('button_disabel');
			$("input[type='checkbox'][name='type[]']:checked").length == 1 ?
					$('#js_editinfo').removeClass('button_disabel'):
					$('#js_editinfo').addClass('button_disabel');
		},
		editOrAdd:function(){
			// 复选框全选操作
			$('#js_checkbox_all').on('click',function(){
				if($(this).is(':checked')){
					$(this).prop("checked","checked");
					$("input[type='checkbox'][name='type[]']").prop("checked","checked");
				}else{
					$(this).prop("checked",false);
					$("input[type='checkbox'][name='type[]']").prop("checked",false);
				}
				$.smsType.btnShowOrHide();
			});
			// 复选框点击事件
			$('.js_addtext_conttent').on('click',"input[type='checkbox'][name='type[]']",function(){
				$.smsType.checkBoxAll();
				$.smsType.btnShowOrHide();
			});
			// 添加按钮  需要判断是否已存在
			$('.js_addsmstype').on('click',function(){
				var info = $("input[name='newinfo']").val();
				if(info != ''){
					var id = 0;
					// 页面判断是否已经存在
					if($("input[type='checkbox'][value$=',"+info+"']").length > 0){
						$.global_msg.init({gType:'warning',icon:2,msg:'提取信息已经存在，请修改',endFn:function(){
							$("input[name='newinfo']").focus();
						}});
					}else{
						$('.js_addtext_conttent').append('<span title="'+info+'"><label><input name="type[]" type="checkbox" value="'+id+','+info+'"><em>'+info+'</em></label></span>');
						$("input[name='newinfo']").val('');
					}
				}else{
					$.global_msg.init({gType:'warning',icon:2,msg:'提取信息不能为空',endFn:function(){
						$("input[name='newinfo']").focus();
					}});
				}
				$.smsType.checkBoxAll();
				$.smsType.btnShowOrHide();
			});
			// 删除按钮  需要判断是否被使用
			$('#js_delinfo').on('click',function(){
				if(!$(this).hasClass('button_disabel') && $("input[type='checkbox'][name='type[]']:checked").length >0 ){
					$.global_msg.init({gType:'confirm',msg:'确定删除所选的提取信息',btns:true,title:false,btn1:'确定',btn2:'取消',fn:function(){
						var succ = [];
						var fail = [];
						var numTotal = $("input[type='checkbox'][name='type[]']:checked").length;
						$("input[type='checkbox'][name='type[]']:checked").each(function(e){
							var info = $(this).val().split(',');
							if(info[0] == 0){
								succ.push(info[0]+','+info[1]);
							}else{
								// 判断是否被使用 决定是否可以删除
								var status = $.smsType.typeInfoStatus(info[0]);
								if(status == 10){
									succ.push(info[0]+','+info[1]);
									$('.js_addtext_conttent').append('<input type="hidden" name="delid[]" value="'+info[0]+'" />');
								}else{
									fail.push(info[0]+','+info[1]);
								}
							}
						});
						// 删除的已成功删除的页面提取信息
						for(var item in succ) {
							$("input[type='checkbox'][value='"+succ[item]+"']").parent('label').parent('span').remove();
						}
						$.smsType.checkBoxAll();
						$.smsType.btnShowOrHide();
						if(fail.length >0 ){
							if(fail.length == numTotal){
								$.global_msg.init({gType:'warning',icon:2,msg:'提取规则正在使用所选提取信息，不能删除'});
							}else if(fail.length < numTotal){
								$.global_msg.init({gType:'warning',icon:2,msg:'提取规则正在使用部分所选提取信息，部分删除操作失败'});
							}
						}
					}});
				}else{
					// $.global_msg.init({gType:'warning',icon:2,msg:'请选择需要删除的提取信息'});
				}
			});
			// 修改按钮  需要判断是否被使用
			$('#js_editinfo').on('click',function(){
				if(!$(this).hasClass('button_disabel') && $("input[type='checkbox'][name='type[]']:checked").length == 1 ){
					var $this = $("input[type='checkbox'][name='type[]']:checked");
					var info = $this.val().split(',');
					$('.js_editinfo_div').attr('data_obj',$this.val());
					$('.js_editinfo_div').find("input[name='infoid']").val(info[0]);
					$('.js_editinfo_div').find("input[name='infoname']").val(info[1]);
					if(info[0] == 0){
						$('.js_editinfo_div').css('display','block');
					}else{
						// 判断是否被使用 决定是否可以修改
						var status = $.smsType.typeInfoStatus(info[0]);
						if(status == 10){
							$('.js_editinfo_div').css('display','block');
						}else{
							$.global_msg.init({gType:'warning',icon:2,msg:'提取规则正在使用该提取信息，不能修改'});
						}
					}
				}else{
					$.global_msg.init({gType:'warning',icon:2,msg:'当且仅当只有一个提取信息被选中时,修改操作可使用'});
				}
				
			});
			// 修改操作
			$('#js_editinfo_submit').on('click',function(){
				var obj = $('.js_editinfo_div').attr('data_obj');
				var id = $('.js_editinfo_div').find("input[name='infoid']").val();
				var info = $('.js_editinfo_div').find("input[name='infoname']").val();
				if(info == ''){
					$.global_msg.init({gType:'warning',icon:2,msg:'修改提取信不能为空'});
				}else{
					// 页面判断是否已经存在
					if($("input[type='checkbox'][value$=',"+info+"']").length > 0){
						$.global_msg.init({gType:'warning',icon:2,msg:'提取信息已经存在，请修改',endFn:function(){
							$("input[name='infoname']").focus();
						}});
					}else{
						if(id == '0'){
							// 没有入库直接修改web
							$("input[value='"+obj+"']").parent('label').parent('span').replaceWith('<span title="'+info+'"><label><input type="checkbox" name="type[]" value="'+id+','+info+'" ><em>'+info+'</em></label></span>');
							$('#js_editinfo_close').trigger('click');
						}else{
							// 判断是否被使用 决定是否可以修改
							var status = $.smsType.typeInfoStatus(id);
							if(status == 10){
								$("input[value='"+obj+"']").parent('label').parent('span').replaceWith('<span title="'+info+'"><label><input type="checkbox" name="type[]" value="'+id+','+info+'" ><em>'+info+'</em></label></span>');
								$('#js_editinfo_close').trigger('click');
							}else{
								$.global_msg.init({gType:'warning',icon:2,msg:'提取规则正在使用该提取信息，不能修改'});
							}
						}
					}
				}
				$.smsType.checkBoxAll();
				$.smsType.btnShowOrHide();
			});
			// 取消修改操作
			$('#js_editinfo_close').on('click',function(){
				$('.js_editinfo_div').css('display','none');
			});
			// 保存内容类型
			$('.js_saveSmsType_btn').on('click',function(){
				var name = $("input[name='smsname']").val();
				var typeid = $("input[name='id']").val();
				if(name == ''){
					$.global_msg.init({gType:'warning',icon:2,msg:'内容类型名称不能为空',endFn:function(){
						$("input[name='smsname']").addClass('invalid_warning').focus();
					}});
					return;
				}else{
					// 内容管理类型名是否存在
					var status = $.smsType.typeHaveStatus(name);
					if(status.status == '10' && status.info.id != typeid){
						$.global_msg.init({gType:'warning',icon:2,msg:'内容类型已存在,请修改',endFn:function(){
							$("input[name='smsname']").addClass('invalid_warning').focus();
						}});
					}else{
						$("input[name='smsname']").removeClass('invalid_warning');
						if($("input[type='checkbox'][name='type[]']").length > 0){
							var infoarr = $.smsType.getSmsInfoForArr();
							var delid = '';
							$("input[name='delid[]']").each(function(e){
								delid += $(this).val()+','; 
							});
							$.post(saveSmsTypeUrl,{name:name,infoarr:infoarr,id:typeid,delid:delid},function(re){
								if(re.status == '0'){
									$.global_msg.init({gType:'warning',icon:1,msg:re.msg,endFn:function(){
										window.location.href = $('.js_backbtn').parent('a').attr('href');
									}});
								}else{
									$.global_msg.init({gType:'warning',icon:2,msg:re.msg});
								}
							}).error(function(){
								$.global_msg.init({gType:'warning',icon:2,msg:'网络问题,请稍后重试'});
							});
							
						}else{
							$.global_msg.init({gType:'warning',icon:2,msg:'请添加提取信息',endFn:function(){
								$("input[name='newinfo']").focus();
							}});
						}
					}
				}
			});
			
			
		}
	}
});
