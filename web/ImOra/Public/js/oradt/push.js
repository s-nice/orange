;(function($){
	
$.extend({
	push:{ 
		allSelect:function(allselect,single){
			//全选 更改自己和单个选项状态
				allselect.on('click',function(){
					var checked = $(this).hasClass('active');
					if(!checked){
						$(this).addClass('active');
						single.addClass('active');
					}else{
						$(this).removeClass('active');
						single.removeClass('active');
					}
				});
				single.on('click',function(){
					var checked = $(this).hasClass('active');;
					var l = single.length;
					if(!checked){
						$(this).addClass('active');
						//全选是否打钩 是否全选/全不选
						var j = 0;
						for(var i = 0; i<l; i++){
							if($(single[i]).hasClass('active')){
								j++;
							}
						}
						if(l == j){
							allselect.addClass('active');
						}
					}else{
						$(this).removeClass('active');
						//判断是否全选取消
						if(allselect.hasClass('active')){
							allselect.removeClass('active');
						}
					}
					
					
				});
				
		},
		
		//推送弹框
		 pushPop:function(pushpop,checks,id,attr,pushone){
			 //批量推送
			 pushpop.on('click',function(){
		 		var groupchecks = checks;
		 		var groupnames = [];
		 		var groupcheckeds = [];
		 		var l = groupchecks.length;
		 		//获取选中
		 		for(var i=0;i<l;i++){
		 			$(groupchecks[i]).hasClass('active')&&groupcheckeds.push(groupchecks[i])&&groupnames.push($(groupchecks[i]).attr(attr));
		 		}
		 		//未选中提示
		 		if(groupnames.length == 0){
		 			$.global_msg.init({msg:unselect,icon:2});
		 			return false;
		 		}
		 		var groupids = [];
		 		var l = groupcheckeds.length;
		 		for(var i=0;i<l;i++){
		 			groupids.push($(groupcheckeds[i]).attr(id));
		 		}
		 		if(groupids.length == 0){
		 			$.global_msg.init({msg:unselect,icon:2});
		 			return false;
		 		}
		 		groupids = groupids.join();//id数组链接为字符串
		 		pop(groupids,groupnames);
		
		 	});
			 
			 //单个推送
			 if(pushone!=''){
			 pushone.on('click',function(){
			 		var groupnames = [];
			 		groupnames[0] = $(this).attr(attr)
			 		var  groupids = $(this).attr(id);
			 		pop(groupids,groupnames);
			
			 	});
			 }
			 //推送弹出提示
			 function pop(groupids,groupnames){
				 	//获取推送名称 单个推送/多个推送
			 		if(groupnames.length==1){
			 			var name = groupnames[0];
			 		}else{
			 			var name = groupnames[0]+groupnames[1]+'...';
			 		}
			 		var msg = '<i>'+to+name+js_push+'：'+'<br>'+push_content+'<br>http://'+serverName+"/h5/imora/download.html<br><img style='width:109px; height:109px; margin:20px 0 40px 82px;' src='"+public+"/images/appadmin_icon_erwm.png'></i>";
			 		//如果是首页  是按照行业id推送 其他是按照名片id推送
			 		if(typeof action !=undefined && action == 'index'){
				 		$.global_msg.init({gType:'confirm',height:440,msg:msg,title:'<b>'+js_push+'</b>',close:true,btns:true,btn1:cancel,btn2:js_push,fn:function(){
				 		},noFn:function(){$.push.ajaxPush(groupids,pushBycategoryId,pushsuccess);	}});
			 		}else{
			 			$.global_msg.init({gType:'confirm',height:440,msg:msg,title:'<b>'+js_push+'</b>',close:true,btns:true,btn1:cancel,btn2:js_push,fn:function(){
				 		},noFn:function(){$.push.ajaxPush(groupids,pushByuuid,pushsuccess);}});
			 		}
			 		$.push.uploadimg($('#uploadfile'),'qrcode',$('#qrcodeimg'));//图片上传
				 
			 }
		 },
		 
		//删除弹框
		 deletePop:function(deletepop,checks,id,deleteone){
			 //批量推送
			 deletepop.on('click',function(){
		 		var groupchecks = checks;
		 		var groupnames = [];
		 		var groupcheckeds = [];
		 		var l = groupchecks.length;
		 		//获取选中
		 		for(var i=0;i<l;i++){
		 			$(groupchecks[i]).hasClass('active')&&groupcheckeds.push(groupchecks[i]);
		 		}
		 		//没有选择提示
		 		if(groupcheckeds.length == 0){
		 			$.global_msg.init({msg:unselect,icon:2});
		 			return false;
		 		}
		 		var groupids = [];
		 		var l = groupcheckeds.length;
		 		for(var i=0;i<l;i++){
		 			groupids.push($(groupcheckeds[i]).attr(id));
		 		}
		 		if(groupids.length == 0){
		 			$.global_msg.init({msg:unselect,icon:2});
		 			return false;
		 		}
		 		groupids = groupids.join();//id数组链接为字符串
		 		pop(groupids);
		
		 	});
			 
			 //单个删除
			 if(deleteone!=''){
				 deleteone.on('click',function(){
			 		var  groupids = $(this).attr(id);
			 		pop(groupids);
			
			 	});
			 }
			 //删除确认弹出
			 function pop(groupids){
			 		var msg = comfirm_delete;
			 			$.global_msg.init({gType:'confirm',msg:msg,title:'',close:true,btns:true,btn1:cancel,btn2:del,fn:function(){
				 		},noFn:function(){$.push.ajaxPush(groupids,deleteByuuid,deletesuccess);}});
			 }
		 },
		 
		 
		 
		 
		 
		 
		 
		//推送/删除
		 ajaxPush:function(groupids,url,msg){
		 	
		 		 $.ajax({  
		 		         type:'post',      
		 		         url:url,  
		 		         data:{ids:groupids},  
		 		         cache:false,  
		 		         dataType:'json',  
		 		         success:function(data){
		 		        	 console.debug(data);
		 		        	 if('0' != data['status']){
		 	                     $.global_msg.init({msg:push_fail,icon:2});//推送失败
		 	                     return;
		 	                 }else{
		 	                	 if(data['data'] !== null){
		 	                		if(data['data']['result']['suc'].length ==0){
		 	                			//推送为空	
		 	                			 $.global_msg.init({msg:empty_msg,icon:2,endFn:function(){
				 	                	 }});
		 	                		}else{
		 	                			//推送成功
		 	                			 $.global_msg.init({msg:msg,icon:1,endFn:function(){	
				 	                		 window.location.reload();
				 	                	 }});
		 	                		}
		 	                	 }else{
		 	                		//推送成功
		 	                		 $.global_msg.init({msg:msg,icon:1,endFn:function(){	
			 	                		 window.location.reload();
			 	                	 }});
		 	                	 }
		 	                 }
		 		          }  
		 		 });  
		 		
		 	
		 },
		 
		 //删除
		 del:function(button,checks,id,url){
			 	button.on('click',function(){
		 		var groupchecks = checks;
		 		var groupids = [];
		 		var l = groupchecks.length;
		 		//获取要删除的元素
		 		for(var i=0;i<l;i++){
		 			$(groupchecks[i]).hasClass('active')&&groupids.push($(groupchecks[i]).attr(id));
		 		}
		 		//一个没有被选中
		 		if(groupids.length == 0){
		 			$.global_msg.init({msg:unselect,icon:2});
		 			return false;
		 		}
		 		groupids = groupids.join();//id数组链接为字符串
		 		 $.ajax({  
		 		         type:'post',      
		 		         url:url,  
		 		         data:{groupid:groupids},  
		 		         cache:false,  
		 		         dataType:'json',  
		 		         success:function(data){
		 		        	 if('0' != data['status']){
		 	                     $.global_msg.init({msg:data['msg'],icon:2});//删除成功
		 	                     return;
		 	                 }
		 		        	 $.global_msg.init({msg:pushsuccess,icon:1});//删除失败
		 		          }  
		 		 });  
		 		
		 	});
		 },
		
		//uploadimg
		uploadimg:function(botton,uploadid,imgid){
		
		    //上传文件
			botton.on('click',function(){
				console.debug(1111);
				   $.ajaxFileUpload({
			            url:uploadpic,//处理图片脚本
			            secureuri :false,
			            fileElementId :uploadid,//file控件id
			            dataType : 'json',
			            success : function (data, status){
			            	console.debug(data);
			                if(typeof(data.error) != 'undefined'){
			                    if(data.error != ''){
			                        alert(data.error);
			                    }else{
			                        alert(data.msg);
			                    }
			                }
			            },
			            error: function(data, status, e){
			                alert(e);
			            }
			        });
				
			});
			
			
	     
			
			
		}
	}

});
})(jQuery);
