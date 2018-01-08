/**
 * 合作商js
 */
(function($){
	
	$.extend({
		offcialpartner:{ 
			allSelect:function(allselect,single){
				//点击全选 全选按钮/单个选择切换状态
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
					//点击单个
					single.on('click',function(){
						var checked = $(this).hasClass('active');;
						var l = single.length;
						if(!checked){
							$(this).addClass('active');
							//全选是否打钩判断是否全选/不全选
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
			 
			//删除弹框
			 deletePop:function(deletepop,checks,id,deleteone){
				 //批量删除
				 deletepop.on('click',function(){
			 		var groupchecks = checks;
			 		var groupnames = [];
			 		var groupcheckeds = [];
			 		var l = groupchecks.length;
			 		//获取删除数据
			 		for(var i=0;i<l;i++){
			 			$(groupchecks[i]).hasClass('active')&&groupcheckeds.push(groupchecks[i]);
			 		}
			 		//没有选中
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
				 //弹出提示
				 function pop(groupids){
				 		var msg = comfirm_delete;
				 			$.global_msg.init({gType:'confirm',msg:msg,title:'',close:true,btns:true,btn1:cancel,btn2:del,fn:function(){
					 		},noFn:function(){$.offcialpartner.ajaxPush(groupids,deleteByuuid,deletesuccess);}});
				 }
			 },
			//删除
			 ajaxPush:function(groupids,url,msg){
			 		 $.ajax({  
			 		         type:'post',      
			 		         url:url,  
			 		         data:{ids:groupids},  //可以批量操作
			 		         cache:false,  
			 		         dataType:'json',  
			 		         success:function(data){
			 		        	 if('0' != data['status']){
			 	                     return;
			 	                 }else{
			 	                		 $.global_msg.init({msg:msg,icon:1,endFn:function(){	
				 	                		 window.location.reload();
				 	                	 }});

			 	                 }
			 		          }  
			 		 });  
			 		
			 	
			 },
			 //更改状态
			 changeSta:function(changeone,url){
				
				 if(changeone!=''){
					 changeone.on('click',function(){
						 var changone = $(this).html();
						 var   bizid= $(this).attr('bizid');//获取企业id
					 	 var   status = $(this).attr('status');//获取状态
					 	 //是否更改提示
						 $.global_msg.init({gType:'confirm',msg:sf+changone,title:'',close:true,btns:true,btn1:cancel,btn2:changone,fn:function(){
					 		},noFn:function(){
								
						 		 $.ajax({  
					 		         type:'post',      
					 		         url:url,  
					 		         data:{bizid:bizid,status:status},  
					 		         cache:false,  
					 		         dataType:'json',  
					 		         success:function(data){
					 		        	 if('0' != data['status']){
					 	                     return;
					 	                 }else{
						 	                		 window.location.reload();
						 	                	
	
					 	                 }
					 		          }  
					 		 });

					 			
					 		}});
				 	});
				 }
			 },
			 //发邮件
			 sendemail:function(sendemail,url){
				
				 if(sendemail!=''){
					 sendemail.on('click',function(){
						 var   email= $(this).attr('email');
						 		 $.ajax({  
					 		         type:'post',      
					 		         url:url,  
					 		         data:{email:email,isajax:1},  
					 		         cache:false,  
					 		         dataType:'json',  
					 		         success:function(data){
					 		        	 if('0' != data['status']){//发送失败
					 		        		$.global_msg.init({msg:send+fail,icon:2});
					 	                     return;
					 	                 }else{
					 	                	$.global_msg.init({msg:send+success,icon:1});//发送成功	 
						 	                	
	
					 	                 }
					 		          }  
					 		 });

					 			
					 	
				 	});
				 }
			 },
			 
			 
			 
			 //排序	
			  sort:  function(){
					$('.js_coll_sort').click(function(){
						var id = $('input[name=sid]').val();
						if(id  != ''){
							var sid = '/sid/'+id;
						}else{
							var sid = '';
						}
						var sort = $(this).find('em').attr('sort');
						indexUrl = indexUrl.replace('.html','');//替换html
						window.location.href = indexUrl+'/sort/'+sort+sid;
					});
					
				},
			//	打开添加框
			addOff:function(obj){
				obj.click(function(){
					$('#chan_offi').html(add);
					$('#add_offi_dom').show();
					$('.js_masklayer').show();
				});
				
				
			},
			//打开编辑框	
			editOff:function(obj,url){
				obj.click(function(){
					var bizid = $(this).attr('bizid'); 
					$('#chan_offi').html(edit);
			 		 $.ajax({  
		 		         type:'post',      
		 		         url:url,  
		 		         data:{bizid:bizid},  
		 		         cache:false,  
		 		         dataType:'json',  
		 		         success:function(data){
		 		        	 if('0' != data['status']){
		 	                     return;
		 	                 }else{
		 	                	 //获取数据后把数据添加到表单
		 	                	$('input[name=bizid]').val(data.data.accountbizs[0]['bizid']);
		 						$('input[name=name]').val(data.data.accountbizs[0]['name']);
		 						var dtype = data.data.accountbizs[0]['type'] || 0;
		 						var type = $('.typelist').find('li[val='+dtype+']');
		 						$('.type').attr('val',dtype);
		 						$('.type').html(type.html());
		 						$('input[name=email]').val(data.data.accountbizs[0]['email']);
		 						$('input[name=yemail]').val(data.data.accountbizs[0]['email']);
		 						$('input[name=contact]').val(data.data.accountbizs[0]['contact']);
		 						var dcategory = data.data.accountbizs[0]['categoryid'] || 0;
		 						var category = $('.categorylist').find('li[val='+dcategory+']');
		 						$('.category').attr('val',dcategory);
		 						$('.category').html(category.html());
		 						$('input[name=phone]').val(data.data.accountbizs[0]['phone']);
		 						var dsize = data.data.accountbizs[0]['size'] ||0;
		 						var size = $('.sizelist').find('li[val='+dsize+']');
		 						$('.size').attr('val',dsize);
		 						$('.size').html(size.html());
		 						$('input[name=address]').val(data.data.accountbizs[0]['address']);
		 						$('input[name=website]').val(data.data.accountbizs[0]['website']);
		 						var dorgcode = data.data.accountbizs[0]['orgcode'] ||0;
		 						//省份
		 						var province = $('.provincelist').find('li[val='+dorgcode+']');
		 						$('.province').attr('val',dorgcode);
		 						$('.province').html(province.html());
		 						$('.province').attr('title',province.html());
		 						var orgcode = data.data.accountbizs[0]['orgcode']||0;
		 						var citycode =data.data.accountbizs[0]['citycode']||0;
		 						var regioncode =data.data.accountbizs[0]['region']||0;
		 						$('.city').attr('val',citycode);
		 						$('.city').html(data.data.accountbizs[0]['cityname']||city1);
		 						$('.city').attr('title',data.data.accountbizs[0]['cityname']||city1);
			 					$('.region').attr('val',regioncode);
			 					$('.region').html(data.data.accountbizs[0]['regionname']||region1);
			 					$('.region').attr('title',data.data.accountbizs[0]['regionname']||region1);
		 						//市
		 						 $.ajax({  
		 					         type:'post',      
		 					         url:getCityInfo,  
		 					         data:{type:1,id:orgcode,isajax:1},  
		 					         cache:false,
		 					         async: false,
		 					         dataType:'json',  
		 					         success:function(data){
		 						         var l = data.length;
		 						         var h = '<li val=0 title='+city1+'>'+city1+'</li>';
		 						         for(i=0;i<l;i++){
		 									h += '<li val='+data[i].code+' title='+data[i].name+'>'+data[i].name+'</li>';
		 							         
		 							     }   
		 						        
		 						     	if(!$('.citylist').hasClass('mCustomScrollbar')){
		 						     		$('.citylist').html(h);
		 									$('.citylist').mCustomScrollbar({
		 									    theme:"dark", //主题颜色
		 									    set_height:130,
		 									    autoHideScrollbar: false, //是否自动隐藏滚动条
		 									    scrollInertia :0,//滚动延迟
		 									    horizontalScroll : false,//水平滚动条
		 									});
		 								}else{
		 									$('.citylist').find('.mCSB_container').html(h);
		 								}
		 					         }  
		 						 });
		 					     
	 						        
		 						 //区
		 						 $.ajax({  
		 					         type:'post',      
		 					         url:getCityInfo,  
		 					         data:{type:2,id:citycode,isajax:1},
		 					         async: false,
		 					         cache:false,  
		 					         dataType:'json',  
		 					         success:function(data){
		 						         var l = data.length;
		 						         var h = '<li val=0 title='+region1+'>'+region1+'</li>';
		 						         for(i=0;i<l;i++){
		 									h += '<li val='+data[i].code+' title='+data[i].name+'>'+data[i].name+'</li>';
		 							     }
		 						        
		 						   	if(!$('.regionlist').hasClass('mCustomScrollbar')){
		 						   	$('.regionlist').html(h);
		 								$('.regionlist').mCustomScrollbar({
		 								    theme:"dark", //主题颜色
		 								    set_height:130,
		 								    autoHideScrollbar: false, //是否自动隐藏滚动条
		 								    scrollInertia :0,//滚动延迟
		 								    horizontalScroll : false,//水平滚动条
		 								});
		 							}else{
		 								$('.regionlist').find('.mCSB_container').html(h);
		 							}			 					   
		 					        
		 					         }  
		 						 });
		 						$('#add_offi_dom').show();
		 						$('.js_masklayer').show();
		 	                 }
		 		          }  
			 		 }); 
				});
				
			},
			//确认提交
			comfirmCommit:function(obj,url){
				obj.click(function(){
					var bizid = $('input[name=bizid]').val(); 
					var name = $('input[name=name]').val();
					var type = $('.type').attr('val');
					var email = $('input[name=email]').val();
					var yemail = $('input[name=yemail]').val();
					var contact = $('input[name=contact]').val();
					var categoryid = $('.category').attr('val');
					var phone = $('input[name=phone]').val();
					var size = $('.size').attr('val');
					var address = $('input[name=address]').val();
					var website = $('input[name=website]').val();
					var province = $('.province').attr('val');
					var city = $('.city').attr('val');
					var region = $('.region').attr('val');
					
					if(type=='0'){//选择类型
						$.global_msg.init({msg:offcialpartner_select_type,icon:2});
						return false;
					}					
					if(name ==''){//合作商名称
						 $.global_msg.init({msg:offcialpartner_name+offcialpartner_no_empty,icon:2});
						return false;
					}					
					if(email ==''){//email不能为空
						$.global_msg.init({msg:'email'+offcialpartner_no_empty,icon:2});
						return false;
					}
				　　var Regex = /^(?:\w+\.?)*\w+@(?:\w+\.)*\w+$/;            

				　　if (!Regex.test(email)){ //验证邮箱               
						$.global_msg.init({msg:'email'+offcialpartner_format_error,icon:2});
						return false;
				　　       
				　　}            
					
					if(contact==''){//联系人不能为空
						$.global_msg.init({msg:offcialpartner_linkman+offcialpartner_no_empty,icon:2});
						return false;
					}
					
					if(categoryid==0){//没有选行业
						$.global_msg.init({msg:offcialpartner_select_industry,icon:2});
						return false;
					}
					
					if(phone ==''){//电话不能为空
						$.global_msg.init({msg:offcialpartner_tel+offcialpartner_no_empty,icon:2});
						return false;
					}
				　　var isPhone = /^([0-9]{3,4}-)?[0-9]{7,8}$/;
					var isMob= /^((\+?86)|(\(\+86\)))?(13[012356789][0-9]{8}|15[012356789][0-9]{8}|18[02356789][0-9]{8}|147[0-9]{8}|1349[0-9]{7})$/;        

				　　if (!isPhone.test(phone)&&!isMob.test(phone)){                

				　　       $.global_msg.init({msg:offcialpartner_tel+offcialpartner_format_error,icon:2});
				　　       return false;
				　　}  
					
//					if(size==0){
//						  $.global_msg.init({msg:offcialpartner_select_scale,icon:2});
//						  return false;
//					}
					
//					if(province=='0'){
//						$.global_msg.init({msg:offcialpartner_select_province,icon:2});
//						return false;
//					} 
//					
//					if(city=='0'){
//						$.global_msg.init({msg:offcialpartner_select_city,icon:2});
//						return false;
//					}
//					
//					if(region=='0'){
//						$.global_msg.init({msg:offcialpartner_select_region,icon:2});
//						return false;
//					}
//					
//				
//					
//					if(address==''){
//						$.global_msg.init({msg:offcialpartner_company_address+offcialpartner_no_empty,icon:2});
//						return false;
//					}
//					if(website == ''){
//						$.global_msg.init({msg:offcialpartner_company_website+offcialpartner_no_empty,icon:2});
//						return false;
//					}
					
					  var strRegex="^((https|http|ftp|rtsp|mms)?://)"  
						    + "?(([0-9a-z_!~*'().&=+$%-]+: )?[0-9a-z_!~*'().&=+$%-]+@)?" // ftp的user@  
						    + "(([0-9]{1,3}\.){3}[0-9]{1,3}" // IP形式的URL- 199.194.52.184  
						    + "|" // 允许IP和DOMAIN（域名）  
						    + "([0-9a-z_!~*'()-]+\.)*" // 域名- www.  
						    + "([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\." // 二级域名  
						    + "[a-z]{2,6})" // first level domain- .com or .museum  
						    + "(:[0-9]{1,4})?" // 端口- :80  
						    + "((/?)|" // a slash isn't required if there is no file name  
						    + "(/[0-9a-z_!~*'().;?:@&=+$,%#-]+)+/?)$"; 
					  var reg=/((http|ftp|https):\/\/)?[\w\-_]+(\.[\w\-_]+)+([\w\-\.,@?^=%&:/~\+#]*[\w\-\@?^=%&/~\+#])?/;
				    //var re=new RegExp(strRegex);
					if(website!=''&&!reg.test(website)){
						$.global_msg.init({msg:offcialpartner_company_website+offcialpartner_format_error,icon:2});
						return false;
					}	
					
					//ajax 提交
			 		 $.ajax({  
		 		         type:'post',      
		 		         url:url,  
		 		         data:{bizid:bizid,name:name,province:province,city:city,region:region,type:type,email:email,yemail:yemail,contact:contact,categoryid:categoryid,phone:phone,size:size,address:address,website:website},  
		 		         cache:false,  
		 		         dataType:'json',  
		 		         success:function(data){
		 		        	 if('0' != data['status']){
		 		        		 if(data['status'] == '200006'){
			 	                		$.global_msg.init({msg:offcialpartner_name+no_repeat,icon:2});//合作商名称重复
			 	                	 }
			 	                	 if(data['status'] == '999022'||data['status'] == '110012'){//email重复
				 	                		$.global_msg.init({msg:'email'+no_repeat,icon:2});
				 	                 }
			 	               	 if(data['status'] == '200003'){
			 	                		$.global_msg.init({msg:'email'+offcialpartner_format_error,icon:2});//email格式不对
			 	                 }
				 	           	 if(data['status'] == '999022'||data['status'] == '999024'){//email重复
			 	                		$.global_msg.init({msg:'email'+no_repeat,icon:2});
			 	                 }
		 	                     return;
		 	                 }else{
		 	                	var tip = $('#chan_offi').html();
		 	                	$.global_msg.init({msg:tip+success,icon:1});
		 	                	$('#offcialpartnerform')[0].reset();//重置表单
		 	                	window.location.reload();//刷新页面
		 	                 }
		 		          }  
			 		 }); 
				});
				
			}
			
		}
		
		
	});
	
})(jQuery);