/**
 * 订单管理页面js
 */
(function($) {
	$.extend({
		//用户服务订单列表页面
		userOrderList:{
			init: function(){
				//日期选择
				$.dataTimeLoad.init();
				
				//下拉菜单选择
				$('.js_select_title').on('click', function(evt){
					evt.stopPropagation();
					$('.js_select_content').hide();
					$(this).siblings('.js_select_content').show();
				});
				$('.js_select_content li').on('click', function(){
					var $obj=$(this).parent().siblings('.js_select_title');
					$obj.attr('val', $(this).attr('val')).val($(this).html());
					$(this).addClass('on').siblings().removeClass('on');
				});
				$(document).on('click',function(e){
                	setTimeout(function(){
                		$('.js_select_content').hide();
                	}, 30);
                });
				
				//搜索
				$('.serach_but input').on('click', function(){
					$.userOrderList.reload();
				});
				//列表排序
        		$('.js_user_service_time_sort').on('click', function(){
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
        			$.userOrderList.reload();
        		});
			},
			//搜索+刷新
			reload: function(){
				var params={
            		'orderId': $('#orderId').val(),
            		'orderStatus': $('#orderStatus').attr('val'),
            		'searchType': $('#searchType').attr('val'),
            		'keyword': $('#keyword').val(),
            		'serviceType': $('#serviceType').attr('val'),
            		'starttime': $('#js_begintime').val(),
            		'endtime': $('#js_endtime').val(),
            		'order': $('#order').val(),
            		'ordertype': $('#ordertype').val()
            	}
            	params = $.param(params);
            	location.href=URL_LIST+'?'+params;
			}
		},
		//企业服务订单列表页面
		companyOrderList:{
			init: function(){
				$.dataTimeLoad.init();//日期选择
				//下拉菜单选择
				$('.js_select_title').on('click', function(evt){
					evt.stopPropagation();
					$('.js_select_content').hide();
					$(this).siblings('.js_select_content').show();
				});
				$('.js_select_content li').on('click', function(){
					var $obj=$(this).parent().siblings('.js_select_title');
					$obj.attr('val', $(this).attr('val')).val($(this).html());
					$(this).addClass('on').siblings().removeClass('on');
				});
				$(document).on('click',function(e){
                	setTimeout(function(){
                		$('.js_select_content').hide();
                	}, 30);
                });
				
				//搜索
				$('.serach_but input').on('click', function(){
					$.companyOrderList.reload();
				});				
				//列表排序
        		$('.js_ent_service_time_sort').on('click', function(){
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
        			$.companyOrderList.reload();
        		});
			},
			//搜索+刷新
			reload: function(){
				var params={
            		'order_id': $('#order_id').val(),
            		'orderStatus': $('#orderStatus').attr('val'),
            		'searchType': $('#searchType').attr('val'),
            		'keyword': $('#keyword').val(),
            		'serviceType': $('#serviceType').attr('val'),
            		'starttime': $('#js_begintime').val(),
            		'endtime': $('#js_endtime').val(),
            		'order': $('#order').val(),
            		'ordertype': $('#ordertype').val()
            	}
				//console.dir(params);
            	params = $.param(params);
            	location.href=URL_LIST+'?'+params;
			}
		},
		orderManage: {
			init: function() {
				$.dataTimeLoad.init();
				this.selModel();
				this.changeSelModel();
				this.orderbyFun();
			},
			// 排序事件
			orderbyFun:function(){
				$('.js_orderby_class').on('click',function(){
					var orderby = $(this).attr('data');
					if(orderby == 'desc'){
						orderby = 'asc';
					}else{
						orderby = 'desc';
					}
					$("input[name='ordertype']").val(orderby);
					$("form[name='searchForm']").submit();
				});
			},
			//点击下拉选择事件
            selModel:function(){
                $('.js_select_title,.js_select_item').on('click',function(){
                	$this = $(this).parents('.js_select_div');
                    var seloDiv = $this.find('.js_select_content');
                    if(seloDiv.is(':hidden')){
                        seloDiv.show();
                    }else{
                        seloDiv.hide();
                    }
                });
              //点击区域外关闭此下拉框
				$(document).on('click',function(e){
					if($(e.target).parents('.js_select_div').length>0){
						var currUl = $(e.target).parents('.js_select_div').find('ul');
						$('.js_select_div>ul').not(currUl).hide()
					}else{
						$('.js_select_div>ul').hide();
					}
				});
            },

            //点击下拉框中的选项
            changeSelModel:function(){
                var selOdiv = $('.js_select_content');
                selOdiv.on('click','li',function(){
                	$(this).parents('.js_select_content').find('li').removeClass('on');
                	$(this).addClass('on');
                    var modelOdiv = $(this).parents('.js_select_div');
                    var model = $(this).attr('val');
                    var content = $(this).text();
                    modelOdiv.find('input').eq(0).val(content);
                    modelOdiv.find('input').eq(1).val(model);
                    selOdiv.hide();
                })
            },
            // 冻结订单
            frozenOrder:function(){
            	$('.js_frozen_order').on('click',function(){
            		var oid = $(this).attr('data');
            		var $this = $(this);
       				$.global_msg.init({gType:'confirm',title:false,msg:'确认冻结订单'+oid+'?',btns:true,btn1:'确认',btn2:'取消',
       					fn:function(){
       	            		$.post(frozenOrderUrl,{orderId:oid},function(re){
       	            			if(re.status == '0'){
       	            				$.global_msg.init({gType:'warning',icon:1,msg:re.msg,endFn:function(){
       	            					$this.parents('.js_orderlist').find('.js_statusshow').html('客服已受理');
       	               		        	$this.remove();
       	               		        }});
       	               			}else{
       	               				$.global_msg.init({gType:'warning',icon:2,msg:re.msg});
       	               			}
       	            			}).error(function(){	
       	               		        $.global_msg.init({gType:'warning',icon:0,msg:'网络错误'});
       	            		});
       				},endFn:''});
            	});
            },
            // 责任认定页面
            liabilityPage:function(){
            	this.liabilityActPage();
            	this.liabilityClose();
            	this.liabilityShowPage();
            	this.liabilityShowClose();
            	var $thisObj = this;
            	// 定责的保存和暂存功能
            	$('body').on('click','.js_liability_save',function(){
            		var $this = $(this);
            		if($this.attr('data') == '1'){
            			$('#js_status').val('1');
                		$("form[name='liabilityForm']").submit();
            		}else{
            			if($("textarea[name='buyer']").val() == ''){
               				$.global_msg.init({gType:'warning',icon:2,msg:'请完善定责信息',endFn:''});
               				return false;
            			}
                		if($("textarea[name='saler']").val() == ''){
                			$.global_msg.init({gType:'warning',icon:2,msg:'请完善定责信息',endFn:''});
               				return false;
                		}
                		if($("textarea[name='customer']").val() == ''){
                			$.global_msg.init({gType:'warning',icon:2,msg:'请完善定责信息',endFn:''});
               				return false;
                		}
                		if(typeof $("input[name='liable']:checked").val() == 'undefined' || $("input[name='liable']:checked").val() == '1'){
                			$.global_msg.init({gType:'warning',icon:2,msg:'请完善定责信息',endFn:''});
               				return false;
                		}
            			$('#js_status').val('2'); 
                		$("form[name='liabilityForm']").submit();
            		}
            		
            	});
            	$('body').on('click','.button_disabel',function(){
            		$.global_msg.init({gType:'warning',icon:2,msg:'请完善定责信息',endFn:''});
            	});
            	$("textarea[name='buyer'],textarea[name='saler'],textarea[name='customer']").on('keyup',function(){
            		$thisObj.changeButtonColor();
            	});
            	$("input[name='liable']").on('change',function(){
            		$thisObj.changeButtonColor();
            	});
//            	// 搜索条件显示
//            	$('.js_search_moreitem').on('click',function(){
//            		$('.js_search_moreitem_div').toggle();
//            	});
            	
            },
            // 定责保存按键置灰功能
            changeButtonColor:function(){
            	if($("textarea[name='buyer']").val() == '' || $("textarea[name='saler']").val() == '' || $("textarea[name='customer']").val() == '' || typeof $("input[name='liable']:checked").val() == 'undefined' || $("input[name='liable']:checked").val() == '1'){
        			$("#js_liability_save").removeClass('js_liability_save').addClass('button_disabel');
            	}else{
            		$("#js_liability_save").removeClass('button_disabel').addClass('js_liability_save');
        		}
            },
            // 定责操作页面
            liabilityActPage:function(){
            	$('.js_liability_act').on('click',function(){
            		var oid = $(this).attr('data');
            		var info = orderIdArr[oid];
            		$('.js_orderid').html(oid);
            		$('#js_orderid').val(oid);
            		$("textarea[name='buyer']").val(info.buyer);
            		$("textarea[name='saler']").val(info.saler);
            		$("textarea[name='customer']").val(info.customer);
            		$("input[name='liable'][value='"+info.liable+"']").trigger('click');
            		if(info.buyer != '' && info.saler != '' && info.customer != '' && info.liable != '1'){
            			$("#js_liability_save").removeClass('button_disabel').addClass('js_liability_save');
            		}else{
            			$("#js_liability_save").removeClass('js_liability_save').addClass('button_disabel');
            		}
            		$('.js_problem_dingz,.appadmin_maskunlock').css('display','block');
            	});
            },
            // 关闭定责页面
            liabilityClose:function(){
            	$('.js_liability_close').on('click',function(){
            		$('.js_problem_dingz,.appadmin_maskunlock').css('display','none');
            		$('.js_orderid').html('');
            		$('#js_orderid').val('');
            		$('#js_status').val('');
            		$("textarea[name='buyer']").val('');
            		$("textarea[name='saler']").val('');
            		$("textarea[name='customer']").val('');
            		$("input[name='liable']").attr("checked",false);
            	});
            },
            // 定责操作
            liabilityAct:function(re){
            	var info = re.info;
            	if(re.status == '0'){
    				$.global_msg.init({gType:'warning',icon:1,msg:re.msg,endFn:function(){
                		orderIdArr[info.orderid] = {buyer:info.buyer,saler:info.saler,customer:info.customer,liable:info.liable,liableshow:info.liableShow};
                		if(info.status == '2'){
                    		var $newObj = $(".js_liability_act[data='"+info.orderid+"']").clone().removeClass('js_liability_act').addClass('js_liability_show').html('定责详情');
                    		$(".js_liability_act[data='"+info.orderid+"']").replaceWith($newObj);
                		}
                		$('.js_liability_close').trigger('click');
    				}});
       			}else{
       				$.global_msg.init({gType:'warning',icon:2,msg:re.msg,endFn:''});
       			}
            },
            // 定责详情页面
            liabilityShowPage:function(){
            	$('body').on('click','.js_liability_show',function(){
            		var oid = $(this).attr('data');
            		var liable = orderIdArr[oid];
            		$('#js_orderid_show').html(oid);
            		$('#js_buyer_show').find('.mCSB_container').html(liable['buyer']);
            		$('#js_saler_show').find('.mCSB_container').html(liable['saler']);
            		$('#js_customer_show').find('.mCSB_container').html(liable['customer']);
            		$('#js_liable_show').html(liable['liableshow']);
            		$('.js_problem_detail,.appadmin_maskunlock').css('display','block');
            	});
            },
            // 关闭定责详情页面
            liabilityShowClose:function(){
            	$('.js_liability_show_close').on('click',function(){
            		$('.js_problem_detail,.appadmin_maskunlock').css('display','none');
            		$('#js_orderid_show').html('');
            		$('#js_buyer_show').find('.mCSB_container').html('');
            		$('#js_saler_show').find('.mCSB_container').html('');
            		$('#js_customer_show').find('.mCSB_container').html('');
            		$('#js_liable_show').find('.mCSB_container').html('');
            	});
            },
            // 不满意订单页面
            problemPage:function(){
            	this.addVisitActPage();
            	this.addVisitClose();
            	this.showVisitPage();
            	this.showVisitClose();
            	this.addVistSubmit();
            	//上一个
            	$('.js_prev').on('click',function(){
            		if (visitIndex > 0){
            			var i = visitIndex;
            			i--;
            			for(i; i>=0; i-- ){
            				if(typeof visitArr[i] != 'undefined' && typeof visitArr[i]['remark'] != 'undefined'){
            					visitIndex = i;
            					$('#js_orderid_show').html(visitArr[i]['id']);
            					$('#js_remark_show').find('.mCSB_container').html(visitArr[i]['remark']);
                        		return false;;
                			}else{
                				continue;
                			}
            			}
                        $.global_msg.init({gType:'warning',msg:'没有上一个回访记录了',icon:2,endFn:''});
            		}else{
                        $.global_msg.init({gType:'warning',msg:'没有上一个回访记录了',icon:2,endFn:''});
                        return false;
                    }
            	});
            	
            	//下一个
            	$('.js_next').on('click',function(){
            		var a = Object.keys(orderIdArr);
            		if (visitIndex < a.length-1){
            			var i = visitIndex;
            			i++;
            			for(i; i<a.length; i++ ){
            				if(typeof visitArr[i] != 'undefined' && typeof visitArr[i]['remark'] != 'undefined'){
                				visitIndex = i;
            					$('#js_orderid_show').html(visitArr[i]['id']);
            					$('#js_remark_show').find('.mCSB_container').html(visitArr[i]['remark']);
                        		return false;
                			}else{
                				continue;
                			}
            			}
        				$.global_msg.init({gType:'warning',msg:'没有下一个回访记录了',icon:2,endFn:''});
            		}else{
                        $.global_msg.init({gType:'warning',msg:'没有下一个回访记录了',icon:2,endFn:''});
                        return false;;
                    }
            	});
            },
            // 新建回访操作页面
            addVisitActPage:function(){
            	$('.js_addvisit_act').on('click',function(){
            		var oid = $(this).attr('data');
            		$('.js_orderid').html(oid);
            		$('#js_orderid').val(oid);
            		$('.js_addVisit_page,.appadmin_maskunlock').css('display','block');
            	});
            },
            // 关闭新建回访页面
            addVisitClose:function(){
            	$('.js_addVisit_close').on('click',function(){
            		$('.js_addVisit_page,.appadmin_maskunlock').css('display','none');
            		$('.js_orderid').html('');
            		$('#js_orderid').val('');
            		$("textarea[name='remark']").val('');
            	});
            },
            // 提交回访操作
            addVistSubmit:function(){
            	$('.js_addVist_submit').on('click',function(){
            		if($("textarea[name='remark']").val() == ''){
            			$('.js_addVist_submit').addClass('button_disabel');
            			$.global_msg.init({gType:'warning',icon:2,msg:'回访内容不能为空!',endFn:''});
            		}else{
            			$("form[name='addVisitForm']").submit();
            		}
            	});
            	$("textarea[name='remark']").on('keyup',function(){
            		if($("textarea[name='remark']").val() == ''){
            			$('.js_addVist_submit').addClass('button_disabel');
            		}else{
            			$('.js_addVist_submit').removeClass('button_disabel');
            		}
            	});
            },
            // 新建回访操作
            addVisitAct:function(re){
            	var info = re.info;
            	if(re.status == '0'){
    				$.global_msg.init({gType:'warning',icon:1,msg:re.msg,endFn:function(){
                		var k = orderIdArr[info.orderid];
                		visitArr[k] = {id:info.orderid,remark:info.remark,time:info.visit_time};
                		$newObj = $(".js_addvisit_act[data='"+info.orderid+"']").clone().removeClass('js_addvisit_act').addClass('js_showvisit_act').html('查看回访');
                		$(".js_addvisit_act[data='"+info.orderid+"']").replaceWith($newObj);
                		$('.js_addVisit_close').trigger('click');
    				}});
       			}else{
       				$.global_msg.init({gType:'warning',icon:2,msg:re.msg,endFn:''});
       			}
            },
            // 回访详情页面
            showVisitPage:function(){
            	$('body').on('click','.js_showvisit_act',function(){
            		var oid = $(this).attr('data');
            		visitIndex = orderIdArr[oid];
            		var visit = visitArr[visitIndex];
            		$('#js_orderid_show').html(oid);
            		$('#js_remark_show').find('.mCSB_container').html(visit['remark']);
            		$('.js_showvisit_page,.appadmin_maskunlock').css('display','block');
            	});
            },
            // 关闭回访详情页面
            showVisitClose:function(){
            	$('.js_showVisit_close').on('click',function(){
            		$('.js_showvisit_page,.appadmin_maskunlock').css('display','none');
            		$('#js_orderid_show').html('');
            		$('#js_remark_show').find('.mCSB_container').html('');
            	});
            },
            // 分享页面操作
            shareCardPage:function(){
            	this.noshareCard();
            	this.onlineSearchCard();
            	this.selectAllcheckbox();
            },
            // 上架操作
            onlineCard:function(){
            	$('.js_online_act').on('click',function(){
            		var cid = $(this).attr('data');
            		$.post(onlineCardUrl,{cardId:cid},function(re){
	            			if(re.status == '0'){
	            				$.global_msg.init({gType:'warning',icon:1,msg:re.msg,endFn:function(){
	            					$.reloadPage.init();
	               		        }});
	               			}else{
	               				$.global_msg.init({gType:'warning',icon:2,msg:re.msg,endFn:''});
	               			}
	            			}).error(function(){	
	               		        $.global_msg.init({gType:'warning',icon:0,msg:'网络错误',endFn:''});
	            		});
            	});
            },
            // 下架事件操作
            noshareCard:function(){
            	$('.js_noshare_act').on('click',function(){
            		var cid = $(this).attr('data');
            		$.orderManage.noshareAct(cid);
            	});
            },
            // 下架具体操作
            noshareAct:function(cid){
            	if(cid == ''){
            		$.global_msg.init({gType:'warning',icon:0,msg:'名片数据不能为空！',endFn:''});
            		return;
            	}
            	$.post(noshareCardUrl,{cardId:cid},function(re){
        			if(re.status == '0'){
        				$.global_msg.init({gType:'warning',icon:1,msg:re.msg,endFn:function(){
        					$.reloadPage.init();
           		        }});
           			}else{
           				$.global_msg.init({gType:'warning',icon:2,msg:re.msg,endFn:''});
           			}
        			}).error(function(){	
           		        $.global_msg.init({gType:'warning',icon:0,msg:'网络错误',endFn:''});
        		});
            },
            // 搜索在售名片
            onlineSearchCard:function(){
            	$('.js_onlineCard_search').on('click',function(){
            		if($("input[name='tel']").val() != '' && $("input[name='name']").val() != '')
            		{
            			$("form[name='onlineForm']").submit();
            		}else{
            			$.global_msg.init({gType:'warning',icon:2,msg:'手机号和姓名必须同时不为空',endFn:''});
            		}
            	});
            },
            // 全选操作
            selectAllcheckbox:function(){
            	// 全选|取消全选
            	$('.js_select_all').on('click',function(){
            		var $this = $(this);
            		if($this.hasClass('active')){
            			$this.removeClass('active');
            			$('.js_select').removeClass('active');
            			$('.js_select_allno_active').removeClass('js_noshare_allAct').css('background','#999 none repeat scroll 0 0');
            		}else{
            			$this.addClass('active');
            			$('.js_select').addClass('active');
            			$('.js_select_allno_active').addClass('js_noshare_allAct').css('background','#666 none repeat scroll 0 0');
            		}
            	});
            	// 单选操作
            	$('.js_select').on('click',function(){
            		var $this = $(this);
            		if($this.hasClass('active')){
            			$this.removeClass('active');
            		}else{
            			$this.addClass('active');
            		}
            		if($('.js_select').length == $('.js_select.active').length){
            			$('.js_select_all').addClass('active');
            		}else{
            			$('.js_select_all').removeClass('active');
            		}
            		if($('.js_select.active').length != 0){
            			$('.js_select_allno_active').addClass('js_noshare_allAct').css('background','#666 none repeat scroll 0 0');
            		}else{
            			$('.js_select_allno_active').removeClass('js_noshare_allAct').css('background','#999 none repeat scroll 0 0');
            		}
            	});
            	// 批量下架事件
            	$('body').on('click','.js_noshare_allAct',function(){
            		var cid = '';
            		var num = $(".js_select.active").length -1;;
            		$(".js_select.active").each(function(t){
            			cid += $(this).attr('data');
            			if(t != num){
            				cid += ',';
            			}
            		});
            		$.orderManage.noshareAct(cid);
            	});
            }
            
		}
	});
})(jQuery);