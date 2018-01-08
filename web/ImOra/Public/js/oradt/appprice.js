/**
 * app价格管理
 */
(function($){
	$.extend({
		appprice:{
			priceJs: function(){
				//文本框只能输入整数
				$(".js_time").on("keyup",function(){ 
					this.value=this.value.replace(/\D/gi,"");
				});
				//保存 提示框
				$(".js_save_time").on("click",function(){
					var oInput = $(this).parents('.app_num').find('input');
					var val=$.trim(oInput.val());
					if(val.length == 0){
						$.global_msg.init({gType:'warning',msg:'请填写完整信息',icon:0});
        				return;
					}else{
						
						$.global_msg.init({gType:'confirm',icon:2,msg:'是否保存已更改内容？',btns:true,close:true,title:false,btn1:'确定',btn2:'取消',fn:function(){
							var name = oInput.attr('name');
							$.post(saveUrl,{name:name,val:val},function(re){
								if(re.status===0){
			                        $.global_msg.init({gType:'alert',time:1,icon:1,msg:re.msg});
			                    }else{
			                        $.global_msg.init({gType:'alert',time:3,icon:0,msg:re.msg});
			                    }
							});
						}});
					}
				})
				//新增会员权益
				$(".js_add_vip").on("click",function(){
					var vips=$(".js_vips:nth-child(1)").clone(true);
					vips.attr('val','');
					vips.find('input').val('');
					vips.find('textarea').val('');
					$(".js_push").append(vips);
				})
				//删除会员权益
				$(".js_push").on("click",".js_vips .js_delete",function(){
					var _this=$(this);
					var id = $(this).parents('.js_vips').attr('val');
					if(!id){
						_this.parents(".js_vips").remove();
					}else{
						$.global_msg.init({gType:'confirm',icon:2,msg:'确认删除',btns:true,close:true,title:false,btn1:'确定',btn2:'取消',noFn:function(){},fn:function(){
							$.post(delUrl,{id:id},function(re){
								if(re.status===0){
			                        $.global_msg.init({gType:'alert',time:1,icon:1,msg:re.msg,endFn:function(){
			                                window.location.reload();
			                            }});
			                    }else{
			                        $.global_msg.init({gType:'alert',time:3,icon:0,msg:re.msg});
			                    }
							});
						}});
					}
				})
				//保存会员权益
				$(".js_save_vip").on('click',function(){
					var error=1;
					$(".js_val").each(function(){
						if($(this).val() == ''){
							error=2;	
						}
					});
					if(error == 2){
						$.global_msg.init({gType:'warning',msg:'请填写完整信息',icon:0});
					}else{
						$.global_msg.init({gType:'confirm',icon:2,msg:'是否保存已更改内容？',btns:true,close:true,title:false,btn1:'确定',btn2:'取消',noFn:function(){},fn:function(){
							var arr = [];
							$.each($('.js_vips'),function(){
								var id = $(this).attr('val');
								var title = $(this).find('.js_vip_tit').val();
								var appid = $(this).find('.js_vip_num').val();
								var time = $(this).find('.js_vip_time').val();
								var price = $(this).find('.js_vip_price').val();
								var info = $(this).find('.js_vip_info').val();
								var json = {title:title,appid:appid,equitytime:time,price:price,info:info,id:id};
								arr.push(json);
							});
							var str = JSON.stringify(arr);
							$.post(saveJsonUrl,{str:str},function(re){
								if(re.status===0){
			                        $.global_msg.init({gType:'alert',time:1,icon:1,msg:re.msg,endFn:function(){
			                                window.location.reload();
			                            }});
			                    }else{
			                        $.global_msg.init({gType:'alert',time:3,icon:0,msg:re.msg});
			                    }
							});
						}});
					}
				})
			},
			viplist:function(){
				var _this = this;
				$('.js_select_div').on('click','.span_name,ul,em',function(e){
					$(this).parent('.js_select_div').find('ul').toggle();
					//点击其他地方，隐藏下拉框
					$(document).one("click", function(){
				        $(".js_select_div ul").hide();
				    });
					e.stopPropagation();
				});

				//点击li选中搜索条件
				$('.js_select_div').on('click','ul>li',function(){
					var val = $(this).attr('val');
					var text = $(this).text();
					var oInput = $(this).parents('.js_select_div').find('.span_name input');
					oInput.val(text).attr('title',text).attr('val',val);
				});

				$('#js_searchbutton').on('click',function(){
					var condition='';
		            var keyword = encodeURIComponent($('input[name=keyword]').val());
		            var starttime = $('#js_begintime').val();
		            var endtime = $('#js_endtime').val();
		            var type = $('input[name=searchType]').attr('val'); 
		            condition += '/t/'+type;
		            if(keyword != ''){
		                condition +='/k/'+keyword;
		            }
		            if(starttime != ''){
		                condition +='/starttime/'+starttime;
		            }
		            if(endtime != ''){
		                condition +='/endtime/'+endtime;
		            }
		            window.location.href = searchUrl+condition;
				})
			},
		}
	})
})(jQuery);