/**
 * 如果删除的是图片，则显示上传图片文字
 */
function showUploadImg(){
	if (!data[DATA_KEY].TEMP || data[DATA_KEY].TEMP.BGURL==''){
		$('#imgFile').show().next().show();
	} else {
		$('#imgFile').hide().next().hide();
	}
}
/**
 * 删除保存在服务端的临时会员卡模板数据
 */
function delTmpData(){
	$.ajax({
        'type':'get',
        'async':false,
        'url':URL_SAVE_TMP_TPL+'?delete=1',
        'success':function(rst){
        	
		}
    });
}
/**
 * 关闭窗口
 */
function selfClose(){
	if (window.opener && window.opener.closeWindow){
		window.opener.closeWindow(window, true);
	} else {
		window.close();
	}
}
(function($){
	$.extend({
		//用户非模板卡统计
		nocardList:{
			init: function(){
				//下拉选择
				$('#select, #select2').on('click', function(evt){
					evt.stopPropagation();
					$('#js_selcontent').hide();
					$(this).parent().siblings('ul').show();
				});
				$('#js_selcontent li').on('click', function(){
					var v=$(this).attr('val');
					var $input=$(this).parent().parent().find('input:first');
					$input.attr('val', v).val($(this).html());
					$(this).siblings().removeClass('on').parent().hide();
					$(this).addClass('on');
				});
				
				$(document).on('click',function(e){
                	setTimeout(function(){
                		$('#js_selcontent, #js_selcontent2').hide();
                	}, 30);
                });
				
				//添加卡模板
				$('.section_bin button:eq(0)').on('click', function(){
					var ids=[];
					$('.userpushlist_c .active').each(function(){
						ids.push($(this).attr('val'));
					});
					if (ids.length==0){
						$.global_msg.init({gType: 'warning', msg:str_orangecard_nl_select_data, icon: 2});
						return;
					}
					delTmpData();
					window.open(URL_ADD+'?userCardId='+ids.join(','));
				});
				
				//搜索按钮
				$('#js_searchbutton').on('click', function(){
					$.nocardList.reload();
				});
				
				//全选
				$('#js_allselect').on('click', function(){
					if ($(this).hasClass('active')){
						$(this).removeClass('active');
						$('.js_select').removeClass('active');
					} else {
						$(this).addClass('active');
						$('.js_select').addClass('active');
					}
				});
				
				//单选
	            $('.js_select').click(function(){
                    if ($(this).hasClass('active')){
                        $(this).removeClass('active');
                    } else {
                        $(this).addClass('active');
                    }
	            });
	            
	            //字段排序
	            $('.userpushlist_name span[order]').on('click', function(){
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
        			$.nocardList.reload();
	            });
			},
			//搜索 with 条件
			reload: function(){
				var params={
		    		'cardtype': $('#select').attr('val'),
		    		'keyword': $('.search_text input').val(),
		    		'order': $('#order').val(),
		    		'ordertype': $('#ordertype').val()
		    	}
		    	params = $.param(params);
		    	location.href=URL_LIST+'?'+params;
			}
		},
		//会员卡模板管理列表页面
		templateList:{
			init: function(){
				//初始化标签弹窗
				//$.popLabel.init(1);
				var _this=this;
				//时间选择
				$.dataTimeLoad.init();
				
				//单位选择滚动条
				$("#js_selcontent3").mCustomScrollbar({
                    theme:"dark",
                    autoHideScrollbar: false,
                    scrollInertia :0,
                    horizontalScroll : false
                });
				
				//下拉选择
				$('#select, #select2').on('click', function(evt){
					evt.stopPropagation();
					$('#js_selcontent, #js_selcontent2').hide();
					$(this).parent().siblings('ul').show();
				});
				$('#js_selcontent li, #js_selcontent2 li').on('click', function(){
					var v=$(this).attr('val');
					var $input=$(this).parent().parent().find('input:first');
					$input.attr('val', v).val($(this).html());
					$(this).siblings().removeClass('on').parent().hide();
					$(this).addClass('on');
				});
				
				$(document).on('click',function(e){
                	setTimeout(function(){
                		$('#js_selcontent, #js_selcontent2').hide();
                	}, 30);
                });
				
				//新增页面
				$('.section_bin button:eq(0)').on('click', function(){
					delTmpData();
					window.open(URL_ADD);
				});
				
				//搜索按钮
				$('#js_searchbutton').on('click', function(){
					_this.reload();
				});
				
				//导出数据
				$('.section_bin button:eq(2)').on('click', function(evt){
					var ids=[];
	            	$('.userpushlist_c').each(function(){
	            		if (!$(this).find('i:first').hasClass('active')){
	            			return;
	            		}
	            		ids.push($(this).find('i:first').attr('val'));
	            	});
	            	window.open(URL_EXPORT+'?id='+ids.join(','));
				});
				/*
				//添加标签
				$('.section_bin button:eq(3)').on('click', function(evt){
					if ($(this).hasClass('button_disabel')){
						return;
					}
					
					var tagids=[];
					$('.active').each(function(){
						var tagid=$(this).attr('tagid');
						if (!tagid) return true;
						tagids = tagids.concat(tagid.split(','));
					});
					tagids = tagids.uniqueTrim();
					
					$('.addcard_box input:checkbox').each(function(){
						for(var i=0;i<tagids.length;i++){
							if ($(this).val()==tagids[i]){
								$(this).prop('checked', true);
							}
						}
					});
					
					var left=822;
					var top=228;
					$('.appadmin_maskunlock').show();
					$('.addcard_box').css({left:left,top:top}).show();
				});*/
				
				//全选
				$('#js_allselect').on('click', function(){
					if ($(this).hasClass('active')){
						$(this).removeClass('active');
						$('.js_select').removeClass('active');
					} else {
						$(this).addClass('active');
						$('.js_select').addClass('active');
					}
				});
				
				//单选
	            $('.js_select').click(function(){
                    if ($(this).hasClass('active')){
                        $(this).removeClass('active');
                    } else {
                        $(this).addClass('active');
                    }
	            });
	            
	            //字段排序
	            $('.userpushlist_name span[order]').on('click', function(){
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
        			$.templateList.reload();
	            });
	            
	            //删除
	            $('.section_bin button:eq(1)').on('click', function(evt){
	            	var ids=[];
	            	var flag=false;
	            	$('.userpushlist_c').each(function(){
	            		if (!$(this).find('i:first').hasClass('active')){
	            			return;
	            		}
	            		ids.push($(this).find('i:first').attr('val'));
	            		var num=parseInt($.trim($(this).find('.span_span6:last').html()));
	            		if (num>0) flag=true;
	            	});
	            	
	            	if (flag){
	            		$.global_msg.init({gType:'warning',msg:str_orangecard_tl_using,icon:2});
	            		return;
	            	}
	            	if (ids.length==0){
	            		$.global_msg.init({gType:'warning',msg:str_orangecard_tl_select_data,icon:2});
	            		return;
	            	}
	            	$.global_msg.init({gType:'confirm',icon:2,msg:str_orangecard_tl_del_confirm ,btns:true,close:true,
	                    title:false,btn1:str_orangecard_cancel ,btn2:str_orangecard_confirm ,noFn:function(){
                        $.post(URL_DEL,{ids:ids.join(',')},function(data){
                        	data = $.parseJSON(data);
                            if('0' == data['status']){
                                $.global_msg.init({gType:'warning',msg:data['msg'],icon:1,endFn:function(){
                                    $.templateList.reload();
                                }});
                            }else{
                                $.global_msg.init({gType:'warning',msg:data['msg'],icon:2});
                            }
                        });
                    }});
				});
	            
	            //编辑
	            $('.vipcard_list .span_span7 .edit').on('click', function(){
	            	delTmpData();
	            	var tid=$(this).parent().parent().find('i:first').attr('val');
	            	window.open(URL_EDIT+'?editTemplateId='+tid);
	            });
	            
	            //复制
	            $('.vipcard_list .span_span7 .copy').on('click', function(){
	            	delTmpData();
	            	var tid=$(this).parent().parent().find('i:first').attr('val');
	            	window.open(URL_ADD+'?copyTemplateId='+tid);
	            });
	            
	            /*
	            //添加标签确定按钮
	            $('.addcard_box button:first').on('click', function () {
		            var labelIds=[];
		            $('.js_label_list_wrap input:checked').each(function(){
		            	labelIds.push($(this).val());
		            });
		            if (labelIds.length==0){
						$.global_msg.init({gType: 'warning', msg:str_orangecard_tl_select_label, icon: 2});
		            	return;
		            }
		            
		            var tplIds=[];
		            $('.js_select').each(function(){
		            	if (!$(this).hasClass('active')){
		            		return;
		            	}
		            	tplIds.push($(this).attr('val'));
		            });
		            
		            if (tplIds.length==0){
						$.global_msg.init({gType: 'warning', msg:str_orangecard_tl_select_tpldata, icon: 2});
		            	return;
		            }
		            
		            $.ajax({
			            'type':'post',
			            'async':false,
			            'url':URL_ADD_LABEL,
			            'data':{tplIds:tplIds.join(','),labelIds:labelIds.join(',')},
			            'success':function(rst){
			            	rst=$.parseJSON(rst);
			            	if (rst.status=='0'){
			            		$('.addcard_box input:checkbox').prop('checked', false);
			            		$.global_msg.init({gType:'warning', msg:rst.msg1, btns:true, icon:1});
			            		setTimeout(function(){
			            			location.reload();
			            		}, 1500);
			            	} else {
			            		$.global_msg.init({gType:'warning', msg:rst.msg1, btns:true, icon:0});
			            	}
			    		}
			        });
		            $('.addcard_box').hide();
		        });*/
			},
			//搜索 with 条件
			reload: function(){
				var params={
            		'cardtype': $('#select').attr('val'),
            		'iscoop': $('#select2').attr('val'),
            		'keyword': $('#keyword').val(),
            		'tempnumber': $('#tempnumber').val(),
            		'starttime': $('#js_begintime').val(),
            		'endtime': $('#js_endtime').val(),
            		'order': $('#order').val(),
            		'ordertype': $('#ordertype').val()
            	}
				//console.dir(params);
            	params = $.param(params);
				//return;
            	location.href=URL_LIST+'?'+params;
			}
		},
		//添加/修改名片模板页面
		newCardTemplate:{
			init: function(){
				//协议编辑框
				/*
				var editor;
				KindEditor.ready(function(K) {
					editor = K.create('#js_content', {
						resizeType : null,
						pasteType : 1,
						minWidth: 515,
						items : [
							'source', '|', 'fontsize', 'bold', 'italic', 'underline',
							'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'indent', 'outdent']
					});
				});*/
				//发卡单位关键字过滤
				$('#cardunit').on('keyup', function(){
					var $this=$(this);
					var txt=$.trim($this.val());
					var cid=$('#cardtype').attr('val');
					if (!cid){
						$.global_msg.init({gType: 'warning', msg:str_orangecard_nct_select_cardtype, icon: 2});
						$this.val('');
						return;
					}
					if (!txt){
						$('#cardunits li[cid="'+cid+'"]').show();
						return;
					}
					$('#cardunits li[cid="'+cid+'"]').hide();
					$this.attr('val', '');
					$('#cardunits li').each(function(){
						var _cid=$(this).attr('cid');
						if (_cid!=cid){
							$(this).hide();
						} else {
							if ($(this).html().indexOf(txt)==-1){
								$(this).hide();
							} else {
								$(this).show();
							}
							if ($(this).html()==txt){
								$this.attr('val',$(this).attr('val'));
							}
						}
					});
				});
				
				//下拉选择显示
				$('#cardtype, #cardunit, #rule, #rule_bank').on('click', function(evt){
					evt.stopPropagation();
					$(this).siblings('ul').show();
				});
				
				//下拉选择隐藏
				$(document).on('click',function(e){
                	setTimeout(function(){
                		$('#cardtypes, #cardunits, #rules, #rules_bank').hide();
                		//发卡单位显示重置
                		var cid=$('#cardtype').attr('val');
                		if (cid){
                			$('#cardunits li[cid="'+cid+'"]').show();
                		}
                		
                	}, 30);
                });
				
				//滚动条
				$("#cardtypes,#cardunits,#rules,#rules_bank,.add_label_box,.js_BIN_scroll").mCustomScrollbar({
                    theme:"dark",
                    autoHideScrollbar: false,
                    scrollInertia :0,
                    horizontalScroll : false
                });
				
				//下拉点击
				$('#cardtypes li,#cardunits li,#rules li,#rules_bank li').on('click', function(){
					//通用部分
					var v=$(this).attr('val');
					var $input=$(this).parent().parent().parent().parent().find('input:first');
					$input.attr('val', v).attr('cid', $(this).attr('cid')).val($(this).html());
					$(this).siblings().removeClass('on')
					$(this).addClass('on').parent().parent().parent().hide();
					
					//卡类型下拉点击
					if ($input.attr('id')=='cardtype'){
						filterCardIssuer();
						
						//如果是支付卡，则显示bin添加窗口
						if (v==1 || v==2){
							$('.num_BIN').show();
						} else {
							$('.num_BIN').hide();
						}
						
						//如果是信用卡，则用另一个抓取规则
						if (v==2){
							$('.card_company:eq(2)').hide();
							$('.card_company:eq(3)').show();
						} else {
							$('.card_company:eq(2)').show();
							$('.card_company:eq(3)').hide();
						}
						
						//如果有模板截图，则显示
						var a=$(this).attr('picpatha');
						var b=$(this).attr('picpathb');
						var $imga=$('.template_img img:first');
						if (v==$imga.attr('cardtype')){
							$imga.attr('src', !!$imga.attr('src1')?$imga.attr('src1'):$imga.attr('placeholder'));
						} else {
							if (a){
								$imga.attr('src', a);
							} else {
								$imga.attr('src', $imga.attr('placeholder'));
							}
						}
						
						var $imgb=$('.template_img img:last');
						if (v==$imgb.attr('cardtype')){
							$imgb.attr('src', !!$imgb.attr('src1')?$imgb.attr('src1'):$imgb.attr('placeholder'));
						} else {
							if (b){
								$imgb.attr('src', b);
							} else {
								$imgb.attr('src', $imgb.attr('placeholder'));
							}
						}
					}
				});
				
				//模板名称过滤
				$('#description').on('blur', function(){
					descFilter();
				});
				
				//过滤模板名称
				function descFilter(){
					//var v=$('#description').val().replace(/[^a-zA-Z0-9\u4e00-\u9fa5,，\\s]/g, '');
					var v=$('#description').val();
					$('#description').val(v);
				}
				
				//发卡单位数据过滤
				function filterCardIssuer(){
					var cid=$('#cardtype').attr('val');
					$('#cardtypeid').val(cid);
					
					var flag=true;
					$('#cardunits li').removeClass('on').show();
					$('#cardunits li').each(function(num){
						if ($(this).attr('cid')!=cid){
							$(this).hide();
						} else if(flag){
							$(this).click();
							flag=false;
						}
					});
				}
				
				//选择标签弹框
				$('.add_Span').on('click', function(evt){
					if ($(this).data('disabled')) return;
					$(this).data('disabled', true);
					var $box=$('.addcard_box');
					
					var cid=$('#cardtype').attr('val');
					if (!cid){
						$('.add_Span').data('disabled', null);
						$.global_msg.init({gType: 'warning', msg:str_orangecard_nct_select_cardtype, icon: 2});
						return;
					}
					$box.attr('typeid', cid);
					
					//之前选择的
					var tagids=[];
					$('.add_label_box span').each(function(){
						var tagid=$(this).attr('tid');
						if (!tagid) return true;
						tagids.push(tagid);
					});
					tagids = tagids.uniqueTrim();
					
					$box.attr('selecteds', tagids.join(','));
					var left=$(this).offset().left+255;
					var top=$(this).offset().top;
					$.popLabel.init(1,$box.attr('typeid'),function(){
						$('.appadmin_maskunlock').show();
						$box.css({left:left,top:top}).show();
						$('.add_Span').data('disabled', null);
					});
				});
				
				//模板编辑器页面
				$('#editor').on('click', function(){
					//$(this).attr('disabled', true).html('请稍后...');
					var params={
						'cardtype':$('#cardtype').attr('val'),
						'cardtypeid':$('#cardtypeid').val(),
						'cardunits':$('#cardunit').attr('val'),
						'cardtypename':$('#cardtype').val(),
						'cardunitsname':$('#cardunit').val(),
						'picpatha':$('.template_up img').attr('src'),
						'picpathb':$('.template_down img').attr('src'),
						'rule':$('.rule:visible').find('input').attr('val'),
						'description':$('#description').val(),
						'issynch':$('#async_true').prop('checked')?1:0,
						'keyword':getKeywords().join(','),
						'bin':getBins().join(','),
						'tagid':JSON.stringify(getLabels())
						//'agreement':editor.html()
					};
					
					if (!params['cardunits'] || params['cardunits']=='0'){
						$.global_msg.init({gType: 'warning', msg:str_orangecard_nct_select_company, icon: 2});
						return;
					}
					var typeid=$('#cardtype').attr('val');
					//console.dir(params);return;
					$.ajax({
			            'type':'post',
			            'async':false,
			            'url':URL_SAVE_TMP_TPL,
			            'data':params,
			            'success':function(rst){
			            	var params={
			            		addTemplateId:$('#addTemplateId').val(),
			            		editTemplateId:$('#editTemplateId').val(),
			            		copyTemplateId:$('#copyTemplateId').val(),
			            		cardTypeId:typeid
			            	};
			            	params=$.param(params);
			            	location.href=URL_EDITOR+'?'+params;
			    		}
			        });
				});
				
				//取消
				$('.template_save button:last').on('click', function(){
					delTmpData();
					selfClose();
				});
				
				//获取关键字数组
				function getKeywords(){
					var arr=[];
					$(".search_end:last aa").each(function(){
						arr.push($(this).html());
					});
					return arr;
				}
				
				//获取bin码
				function getBins(){
					var arr=[];
					$(".search_end:first aa").each(function(){
						arr.push($(this).html());
					});
					return arr;
				}
				
				//添加关键字
				$('#addkeyword').on('click', function(){
					var $input=$(this).prev();
					if ($.trim($input.val())=='') return;
					var inputArr=$input.val().replace(/[^a-zA-Z0-9\u4e00-\u9fa5,，\s]/g, '').split(/,|，/);
					var btnArr=getKeywords();
					
					//输入的内容trim+unique
					inputArr=inputArr.uniqueTrim();
					
					for(var i=0;i<btnArr.length;i++){
						for(var j=0;j<inputArr.length;j++){
							if (btnArr[i]==inputArr[j]){
								inputArr.splice(j,1);
								break;
							}
						}
					}
					
					for(var i=0;i<inputArr.length;i++){
						var $obj=$("<span><aa>"+inputArr[i]+"</aa><i>X</i></span>");
						$obj.find('i').on('click', function(){
							delItem($(this));
						});
						$input.parent().find('.Bin_end').append($obj);
					}
					$input.val('');
				});
				
				//添加bin码
				$('#addbin').on('click', function(){
					var $input=$(this).prev();
					if ($.trim($input.val())=='') return;
					var inputArr=$input.val().split(/,|，|\s/);
					var btnArr=getBins();
					
					//输入的内容trim+unique
					inputArr=inputArr.uniqueTrim();
					
					for(var i=0;i<btnArr.length;i++){
						for(var j=0;j<inputArr.length;j++){
							if (btnArr[i]==inputArr[j]){
								inputArr.splice(j,1);
								break;
							}
						}
					}
					
					var flag,errorBin;
					for(var i=0;i<inputArr.length;i++){
						if (/[^0-9]/.test(inputArr[i]) || inputArr[i].length==0 || inputArr[i].length>6){
							flag = true;
							errorBin = inputArr[i];
							break;
						}
					}
					if (flag){
						$.global_msg.init({gType: 'warning', msg:tip_orangecard_bin_failed+'('+errorBin+')', icon: 2});
						return;
					}
					for(var i=0;i<inputArr.length;i++){
						var $obj=$("<span><aa>"+inputArr[i]+"</aa><i>X</i></span>");
						$obj.find('i').on('click', function(){
							delItem($(this));
						});
						$input.parent().find('.Bin_end').append($obj);
					}
					
					$input.val('');
				});
				
				//删除关键字事件绑定
				$(".search_end i").on('click', function(){
					delItem($(this));
				});
				
				//删除已添加标签事件绑定
				$('.add_label_box b').on('click', function(){
					delItem($(this));
				});
				
				//保存
				$('.template_save button:first').on('click', function(){
					descFilter();
					var params={
						'picpatha':$('.template_up img').attr('src'),
						'picpathb':$('.template_down img').attr('src'),
						'cardtype':$('#cardtype').attr('val'),
						'cardunits':$('#cardunit').attr('val'),
						'description':$('#description').val(),
						'keyword':getKeywords().join(','),
						'issynch':$('#async_true').prop('checked')?1:0,
						'bin':getBins().join(','),
						'rule':$('.rule:visible').find('input').attr('val'),
						'tagid':getLabelsID().join(','),
						'vcard':$('#vcard').val(),
						'persondata':$('#persondata').val(),
						//'agreement':editor.html(),
						'addTemplateId':$('#addTemplateId').val(),
						'editTemplateId':$('#editTemplateId').val(),
						'copyTemplateId':$('#copyTemplateId').val()
					};
					
					if (params['picpatha'].indexOf('pleaseUpload')!=-1){
						$.global_msg.init({gType: 'warning', msg:str_orangecard_nct_upload_front, icon: 2});
						return;
					}
					/*
					if (params['picpathb'].indexOf('pleaseUpload')!=-1){
						$.global_msg.init({gType: 'warning', msg:'请上传反面背景图片', icon: 2});
						return;
					}*/
					if (!params['cardtype']){
						$.global_msg.init({gType: 'warning', msg:str_orangecard_nct_select_cardtype, icon: 2});
						return;
					}
					if (!params['cardunits'] || params['cardunits']=='0'){
						$.global_msg.init({gType: 'warning', msg:str_orangecard_nct_select_company, icon: 2});
						return;
					}
					if (!params['description']){
						$.global_msg.init({gType: 'warning', msg:str_orangecard_nct_input_desc, icon: 2});
						return;
					}
					if (params['cardtype']==1 && !params['bin']){
						$.global_msg.init({gType: 'warning', msg:str_orangecard_nct_add_bin, icon: 2});
						return;
					}
					if (!params['keyword']){
						$.global_msg.init({gType: 'warning', msg:str_orangecard_nct_add_keyword, icon: 2});
						return;
					}
					if (!params['tagid']){
						$.global_msg.init({gType: 'warning', msg:str_orangecard_nct_add_label, icon: 2});
						return;
					}
					/*
					if (!params['agreement']){
						$.global_msg.init({gType: 'warning', msg:str_orangecard_nct_input_agreement, icon: 2});
						return;
					}*/
					
					$.ajax({
			            'type':'post',
			            'async':false,
			            'url':URL_SAVE_TPL,
			            'data':params,
			            'success':function(rst){
			            	rst = $.parseJSON(rst);
			            	if (rst.status=='0'){
			            		$.global_msg.init({gType:'warning', msg:rst.msg1, btns:true, icon:1});
			            		//跳转
			            		setTimeout(function(){
			            			selfClose();
			            		},1000);
			            	} else {
			            		$.global_msg.init({gType:'warning', msg:rst.msg1, btns:true, icon:0});
			            	}
			    		}
			        });
				});
				
				//添加标签确定按钮
		        $('.addcard_box button:first').on('click', function () {
		            var rst=[];
		            $('.js_label_list_wrap input:checked').each(function(){
		                var id=$(this).val();
		                var str=$(this).parent().parent().attr('title');
		                var flag=true;
		                for(var i=0;i<rst.length;i++){
		                	if (rst[i].id==id){
		                		flag=false;
		                		break;
		                	}
		                }
		                if (flag){
		                	rst.push({id:id,name:str});
		                }
		            });

		            var ids=getLabelsID();
		            for(var i=0;i<rst.length;i++){
		                var flag=true;
		            	for(var j=0;j<ids.length;j++){
		                	if (ids[j]==rst[i]['id']){
		                		flag=false;
		                    	break;
		                    }
		            	}
		            	if (flag){
		            		var $obj=$('<span tid="'+rst[i]['id']+'"><aa>'+rst[i]['name']+'</aa><b>X</b></span>');
		            		$obj.find('b').on('click', function(){
		            			delItem($(this));
		                	});
		                	$('.add_label_box .mCSB_container').append($obj);
		                }
		            }
		            $('.js_label_type:first').click();
		            $('.appadmin_maskunlock').hide();
		            $('.addcard_box').hide();
		        });
			}
		},
		//名片编辑器页面
		editTemplateStyle:{
			init: function(){
				showUploadImg();
				
				//取消
				$('.template_save button:last').on('click', function(){
					location.href=URL_FROM;
				});
				
				//初始化数据
				initData();
				
				//删除没用的字段
				delete data['FRONT']['TEMP']['BGCOLOR'];
				delete data['FRONT']['TEMP']['ALPHA'];
				delete data['FRONT']['TEMP']['TEMPORI'];
				delete data['BACK']['TEMP']['BGCOLOR'];
				delete data['BACK']['TEMP']['ALPHA'];
				delete data['BACK']['TEMP']['TEMPORI'];
				
				//渲染
				render(true);
				addPhoneIcon();
				$('orbg').show();
				//global_interval
				setInterval(function(){
					//return;
					//----------------------大小屏幕适应START
					//文字wrap宽度动态设置（根据修改的文本内容）
					$canvas.find('ortext').each(function(){
						//if ($(this).html()=='PIN码') return true;
						var $parent=$(this).parent();
						var wp=$parent.width();
						var tp=$(this).width()+(IS_DOUBLE_SIZE?40:20);
						if ($parent.find('img').length>0){
							tp+=parseInt($parent.find('img').width())+parseInt($parent.find('img').css('padding-right'));
						}
						if (wp!=tp){
							var float=$(this).css('float');
							if (float=='none'){
								var offset=tp-wp;
								var left=parseFloat($parent.css('left'));
								$parent.css('left', left-offset/2);
								//$parent.css('left', left-offset);
							}
							if (float=='right'){
								var offset=tp-wp;
								var left=parseFloat($parent.css('left'));
								$parent.css('left', left-offset);
							}
							$parent.width(tp);
						}
					});
					
					//上传图片缩小
					if (!IS_DOUBLE_SIZE){
						$canvas.find('orimgwrap[scale]').each(function(){
							var $img=$(this).find('img:first');
							if ($img.width()>0 && $img.height()>0){
								var w=$img.width()/2;
								var h=$img.height()/2;
								$img.width(w);
								$img.height(h);
								$(this).removeAttr('scale');
							}
						});
					}
					//----------------------大小屏幕适应END
					
					//查找选中元素
					$active=$canvas.find('.active');
					$active.length==0 && ($active=null);
					if (!$active){
						//条形码固定宽高，所以放大旋转按钮隐藏
						$canvas.find('.corner, .side').hide();
						$('#del').addClass('btnBg');
						$tip.hide();
						$x.val('');
						$y.val('');
						return;
					} else {
						$('#del').removeClass('btnBg');
					}
					
					if (IS_STOP_UPDATE) return;
					
					//xy坐标tip显示
					var top=parseInt($active.css('top'));
					var left=parseInt($active.css('left'));
					var top2=top-4;
					var right2=WIDTH/2-left;
					
					$tip.show().css({top:top2+'px',right:right2+'px'});
					if (!IS_STOP_XY){
						switch($active.css('textAlign').toLowerCase()){
						case 'center':
							left=left*2+20;
							break;
						case 'right':
							left=left*2+40;
							break;
						case 'left':
						default:
							left=left*2;
							break;
						}
						top=top*2;
						$x.val(left)
						$y.val(top);
						$tip.find('i:first').html(left);
						$tip.find('i:last').html(top);
					}
					
					
					//文字相关
					var type=$active.attr('type');
					if (type=='text'){
						var color=$('#colorLabel').val();
						var color2=rgbToHex($active.css('color'));
						if (color != color2){
							$active.css('color','#'+color);
						}
						
						//字体
						var font=$active.css('fontFamily');
						var $fontTip=$fontSelect.find('h6');
						if ($fontTip.html()!=font){
							$fontTip.html(font);
						}
						
						//字号+字体颜色
						var fontSize=parseInt($active.css('fontSize'))*(!IS_DOUBLE_SIZE?2:1);
						var $fontSizeTip=$fontSizeSelect.find('h6');
						if (font=='Farrington7B'){
							if (fontSize<=80){
								fontSize=80;
								setFontSize(fontSize/2);
							} else {
								fontSize=120;
								setFontSize(fontSize/2);
							}
							
							//7B字体大小
							for(var i=0;i<fontSizes7BData.length;i++){
								var tmp=fontSizes7BData[i];
								if (fontSize==tmp.val){
									if ($fontSizeTip.html()!=tmp.str) $fontSizeTip.html(tmp.str);
								}
							}
							
							//字体颜色选择器
							var $colorSelect=$('.edit_color:first').hide().next().show();
							var color=rgbToHex($active.css('color'));
							var $colorTip=$colorSelect.find('h6');
							
							//7B字体颜色
							for(var i=0;i<fontColors7BData.length;i++){
								var tmp=fontColors7BData[i];
								if (color==tmp.val){
									if ($colorTip.html()!=tmp.str) $colorTip.html(tmp.str);
								}
							}
						} else {
							fontSize+='px';
							//如果是一般字体
							if ($fontSizeTip.html()!=fontSize) $fontSizeTip.html(fontSize);
							$('.edit_color:first').show().next().hide();
						}
						
						//是否显示卡号格式选项
						if ($active.attr('label')=='卡号'){
							var $numberFormatTip=$('#numberFormat').show().find('h6');
							var format=$active.attr('format');
							if (format){
								$numberFormatTip.html(format);
							} else {
								$numberFormatTip.html('默认连续');
							}
						} else {
							$('#numberFormat').hide();
						}
						
						//是否显示日期格式选项
						if ($active.attr('label')=='VALID THRU'){
							var $numberFormatTip=$('#dateFormat').show().find('h6');
							var format=$active.attr('format');
							$numberFormatTip.html(format);
						} else {
							$('#dateFormat').hide();
						}
					}
					
					//设置图片大小，透明度，旋转
					if (type=='img' || type=='icon'){
						$active.find('.corner').hide();
						$active.find('.side').hide();
						var $img=$active.find('.img');
						var w=$width.val();
						var h=$height.val();
						var o=parseInt($opacity.val())/100;
						var r=$rotation.val();
						
						if ($img.width()!=w){
							var _x=$img.width()-w;
							var ol=parseFloat($active.css('left'));
							$img.width(w);
							var l=ol+_x/2;
							
							//防止图片超出画板范围而找不到
							if (l<0){
								$active.css({left:0});
							} else if(l>$canvas.width()){
								$active.css({left:$canvas.width()-w});
							} else {
								$active.css({left:l});
							}
						}
						if ($img.height()!=h){
							var _y=$img.height()-h;
							var ot=parseFloat($active.css('top'));
							$img.height(h);
							var t=ot+_y/2;
							
							//防止图片超出画板范围而找不到
							if (t<0){
								$active.css({top:0});
							} else if(t>$canvas.height()){
								$active.css({top:$canvas.height()-h});
							} else {
								$active.css({top:t});
							}
						}
						
						if ($img.css('opacity')!=o) $img.css('opacity',o);
						if ($img.attr('rotation')!=r){
							setRotate($img.parent(),r);
						}
					} else {
						$canvas.find('.corner, .side').hide();
					}
				},30);
				
				//collect data 收集布局数据
				setInterval(function(){
					$canvas.find('ortextwrap,orimgwrap,orbg').each(function(){
						var $this=$(this);
						var type=$this.attr('type');
						var _data={};
			    		_data['ID'] = $this.attr('id');
			    		if (type=='bg'){
			    			data[DATA_KEY]['TEMP']['BGURL'] = $this.find('img').attr('src');
			    			//data[DATA_KEY]['TEMP']['ALPHA'] = 1;
			    			if (ORIENTATION=='landscape'){
			    				data[DATA_KEY]['TEMP']['WIDTH']  = WIDTH;
			        			data[DATA_KEY]['TEMP']['HEIGHT'] = HEIGHT;
			    			} else {
			    				data[DATA_KEY]['TEMP']['WIDTH']  = HEIGHT;
			        			data[DATA_KEY]['TEMP']['HEIGHT'] = WIDTH;
			    			}
			    		}
						if (type=='text'){
							_data['ALIGN'] = $this.css('textAlign').toUpperCase();
							switch(_data['ALIGN']){
							case 'LEFT':
								_data['MINX'] = parseInt($this.css('left'))*(!IS_DOUBLE_SIZE?2:1);
								break;
							case 'CENTER':
								_data['MINX'] = (parseInt($this.css('left'))+10)*(!IS_DOUBLE_SIZE?2:1);
								break;
							case 'RIGHT':
								_data['MINX'] = (parseInt($this.css('left'))+20)*(!IS_DOUBLE_SIZE?2:1);
								break;
							}
							_data['WIDTH'] = parseInt(($this.width()-20)*(!IS_DOUBLE_SIZE?2:1));
							_data['HEIGHT'] = parseInt($this.height()*(!IS_DOUBLE_SIZE?2:1));
							_data['MINY'] = parseInt($this.css('top'))*(!IS_DOUBLE_SIZE?2:1);
							_data['COLOR'] = '#'+rgbToHex($this.css('color'));
							_data['SIZE'] = parseInt($this.css('fontSize'))*(!IS_DOUBLE_SIZE?2:1);
							_data['FONT'] = $this.css('fontFamily');
							if (_data['FONT']=='Farrington7B'){
								_data['SIZE']/=2;
							}
							_data['BOLD'] = $this.css('fontWeight')=='700'?1:0;
							_data['UNDERLINE'] = $this.find('ortext').css('textDecoration')=='underline'?1:0;
							_data['ITALIC'] = $this.css('fontStyle')=='italic'?1:0;
							_data['VALUE']={};
							_data['VALUE']['FIELD'] = $this.attr('datatype');
							_data['VALUE']['LABEL'] = $this.attr('label');
							_data['VALUE']['VALUE'] = $this.attr('val');
							_data['VALUE']['FORMAT'] = $this.attr('format') || '';
							_data['VALUE']['CONTACT'] = $this.attr('contact') || '';
							editData(_data, _data['ID'], 'TEXT');
						}
						if (type=='img' || type=='icon'){
							
							var $img=$this.find('.img');
			    			_data['PHOTO'] = $img.attr('src');
			    			_data['WIDTH'] = parseInt($img.width()*(!IS_DOUBLE_SIZE?2:1));
							//_data['HEIGHT'] = parseInt($img.height()*(!IS_DOUBLE_SIZE?2:1));
			    			//_data['HEIGHT'] = 107;
			    			_data['HEIGHT'] = 80;
							_data['MINX'] = parseInt($this.css('left'))*(!IS_DOUBLE_SIZE?2:1);
							_data['MINY'] = parseInt($this.css('top'))*(!IS_DOUBLE_SIZE?2:1);
							_data['ROTATE'] = parseInt($img.parent().attr('rotation')) || 0;
							_data['ORDER'] = $this.css('zIndex');
							_data['OPACITY'] = $img.css('opacity');
							_data['TYPE'] = type;
							if (type=='icon'){
								var c=$img.css('backgroundColor');
								if (c=='transparent' || c=='rgba(0, 0, 0, 0)'){
									_data['COLOR'] = 'transparent';
								} else {
									_data['COLOR'] = rgbToHex($img.css('backgroundColor'));
								}
							}
							//为了barcode单独添加的数据
							_data['FIELD'] = $this.attr('TEXTFIELD');
							_data['LABEL'] = $this.attr('TEXTLABEL');
							_data['VALUE'] = $this.attr('TEXTVALUE');
							//_data['FORMAT'] = $this.attr('TEXTFORMAT') || '';
							_data['CONTACT'] = $this.attr('TEXTCONTACT') || '';
							
							editData(_data, _data['ID'], 'IMAGE');
						}
					});
				},1000);
				
				//画板
				$canvases.on('mousedown', function(evt){
					if (!$active) return;
					if ($active[0].localName=='orbg') return;
					var offset=$(this).offset();
					
					//鼠标原始坐标
					var point={x:evt.pageX-offset.left,y:evt.pageY-offset.top};
					$active.data({'downPoint':point});
					
					//图片拖拽放大缩小START
					var $corner=$active.find('.corner');
					if ($corner.length>0 && $active.data('imgscale') && rectContainsPoint($corner, point, offset)){
						$(this).data('imgscale', true);
						
						var $img=$active.find('.img');
						$active.data({
							'orgSize':{width:$img.width(),height:$img.height()},
							'orgOffset':{top:parseFloat($active.css('top')),left:parseFloat($active.css('left'))}
						});
						IS_STOP_UPDATE=true;
						return;
					}
					
					//图片旋转START
					var $side=$active.find('.side');
					if ($side.length>0 && $active.data('imgrotate') && rectContainsPoint($side, point, offset)){
						$(this).data('imgrotate', true);
						var $img=$active.find('.img');
						$active.data({
							'orgRotate':$img.attr('rotation')
						});
						IS_STOP_UPDATE=true;
						return;
					}
					
					//元素移动START
					if (rectContainsPoint($active,point,offset)){
						$(this).data('move', true);
						$active.data({'orgOffset':{top:parseFloat($active.css('top')),left:parseFloat($active.css('left'))}});
						$canvases.css('opacity', 0.6).find('orbg').animate({opacity:0.5});
						$webcanvas.css('opacity', 1);
						return;
					}
				}).on('mousemove', function(evt){
					if (!$active) return;
					if ($active[0].localName=='orbg') return;
					var offset=$(this).offset();
					
					//元素移动DOING
					if ($(this).data('move')){
						var downPoint=$active.data('downPoint');
						var _x=evt.pageX-downPoint.x-offset.left;
						var _y=evt.pageY-downPoint.y-offset.top;
						
						var orgOffset=$active.data('orgOffset');
						$active.css({top:orgOffset.top+_y,left:orgOffset.left+_x});
						align(true);
					}
					
					//图片拖拽放大缩小DOING
					if ($(this).data('imgscale')){
						var downPoint=$active.data('downPoint');
						var _x=evt.pageX-downPoint.x-offset.left;
						var _y=evt.pageY-downPoint.y-offset.top;
						
						var $img=$active.find('.img');
						var orgSize=$active.data('orgSize');
						var orgOffset=$active.data('orgOffset');
						
						var min=IS_DOUBLE_SIZE?20:10;
						var w=orgSize.width+_x*2;
						var h=orgSize.height+_y*2;
						
						if (w<min){
							w=min;
							_x=(w-orgSize.width)/2;
						}
						if (h<min){
							h=min;
							_y=(h-orgSize.height)/2;
						}
						$img.css({
							width:w,
							height:h
						});
						$active.css({
							top:orgOffset.top-_y+'px',
							left:orgOffset.left-_x+'px'
						});
						$width.val(w);
						$height.val(h);
					}
					
					//图片旋转DOING
					if ($(this).data('imgrotate')){
						var c=getPosition($active);
						var p={x:evt.pageX-offset.left,y:evt.pageY-offset.top};
						var r=parseInt(Math.atan2(p.y-c.y,p.x-c.x)/(Math.PI*2/360));
						setRotate($active.find('orimg'),r,true,true);
					}
					
				}).on('mouseup', function(evt){
					if (!$active || $active[0].localName=='orbg') return;
					var b;//点击空白处，active消失
					
					//元素移动END
					if ($(this).data('move')){
						$(this).data('move', null);
						$active.data({
							'downPoint':null,
							'orgOffset':null
						});
						b=true;
						$canvases.css('opacity', 1).find('orbg').stop().css('opacity', 1);
						$webcanvas.css('opacity', 0);
					}
					//图片拖拽放大缩小END
					if ($(this).data('imgscale')){
						$(this).data('imgscale', null);
						$active.data({
							'downPoint':null,
							'orgSize':null,
							'orgOffset':null,
							'imgscale':null
						});
						b=true;
					}
					//图片旋转END
					if ($(this).data('imgrotate')){
						$(this).data('imgrotate', null);
						$active.data({
							'imgrotate':null
						});
						b=true;
					}
					if (!b){
						removeActive();
					}
					IS_STOP_UPDATE=false;
				});
				
				
				/**
				 * 递归查询data，找到是否存在label=={label}的字段
				 * @param str label
				 * @return bool 
				 */
				var searchDataByLabelResult=false;
				function searchDataByLabel(label, value, _data){
					if (typeof(_data)=='object'){
						for(var k in _data){
							if (typeof(_data[k]) == 'object'){
								searchDataByLabel(label, value, _data[k]);
							} else {
								if (k==label && _data[k]==value){
									searchDataByLabelResult=true;
									return;
								}
							}
						}
					}
				}
				//xy坐标设置
				$x.on('keyup', function(evt){
					if (!$active || $active.attr('type')=='bg') return;
					var v=$(this).val().replace(/[^0-9]/, '');
					if (!v || v<0) v=0;
					if (v>1170) v=1170;
					v=v/2;
					switch($active.css('textAlign').toLowerCase()){
						case 'center':
							v-=10;
							break;
						case 'right':
							v-=20;
							break;
					}
					$active.css('left', v+'px');
					setTimeout(function(){IS_STOP_UPDATE = false;});
					setTimeout(function(){IS_STOP_UPDATE = true;},50);
				}).on('focus', function(){IS_STOP_UPDATE = true; IS_STOP_XY = true;
				}).on('blur',  function(){IS_STOP_UPDATE = false;IS_STOP_XY = false;});
				$y.on('keyup', function(evt){
					if (!$active || $active.attr('type')=='bg') return;
					var v=$(this).val().replace(/[^0-9]/, '');
					if (!v || v<0) v=0;
					if (v>690) v=690;
					$active.css('top', v/2+'px');
					setTimeout(function(){IS_STOP_UPDATE = false;});
					setTimeout(function(){IS_STOP_UPDATE = true;},50);
				}).on('focus', function(){IS_STOP_UPDATE = true; IS_STOP_XY = true;
				}).on('blur',  function(){IS_STOP_UPDATE = false;IS_STOP_XY = false;});
				
				//添加文字
				$('.card_ul li span, .card_ul_text li span').on('click', function(){
					var tid=$(this).parent().attr('tid');
					var label=$(this).html();
					/*
					if ($canvases.find('*[datatype="'+tid+'"]').length>0 || $canvases.find('*[textfield="'+tid+'"]').length>0){
						$.global_msg.init({gType: 'warning', msg:'【'+label+'】'+str_orangecard_ets_label_exist, icon: 2});
						return;
					}*/
					searchDataByLabelResult=false;
					searchDataByLabel('LABEL', label, data);
					if (searchDataByLabelResult){
						searchDataByLabelResult=false;
						$.global_msg.init({gType: 'warning', msg:'【'+label+'】'+str_orangecard_ets_label_exist, icon: 2});
						return;
					}
					searchDataByLabelResult=false;
					if (label=='条形码'){
						var uuid=getUUID();
						addImg(URL_BARCODE,'img',uuid,true);
						var $img=$('#'+uuid);
						if ($img.length>0){
							$img.attr('TEXTFIELD', tid);
							$img.attr('TEXTLABEL', label);
							$img.attr('TEXTVALUE', $(this).next().val());
							$img.attr('TEXTCONTACT', $(this).next().attr('contact'));
							//$img.find('img:first').css({width:544,height:107});
							$img.find('img:first').css({width:500,height:80});
						}
					} else {
						var $input=$(this).next();
						var uuid=addLabel($input.val(), label, 20, 'left', DEFAULT_FONT, null, tid, false, null, true);
						if (label.indexOf('电话')!==-1){
							$('#'+uuid).find('ortext').before('<img src="'+SRC_PHONE+'" style="width:20px;float:left;">');
						}
						var contact=$input.attr('contact');
						contact && $('#'+uuid).attr('contact', contact);
					}
				});
				
				//卡属性输入框
				$('.card_ul li input, .card_ul_text li input').on('keyup click', function(){
					var datatype=$(this).parent().attr('tid');
					if (!!datatype){
						var $obj=$canvases.find('ortextwrap[datatype="'+datatype+'"]');
						$obj.attr('val', $(this).val());
						$obj.find('ortext').html($(this).val());
					}
				}).on('blur', function(){
					/*
					var $this=$(this);
					$this.removeClass('red');
					if (!$.trim($this.val())){
						$this.addClass('red');
						$.global_msg.init({gType: 'warning', msg:str_orangecard_not_empty, icon: 2, endFn:function(){
							//$this.select();
						}});
					}*/
				});
				
				//字体下拉
				$fontSelect.on('click', function(evt){
					hideSelect('#fontList');
					evt.stopPropagation();
					if (!$active || $active.find('ortext').length==0) return;
					var fontName = $active.find('ortext').css('fontFamily');
					fontName = fontName.split(',')[0];
					var $li=$('#fontList li[val='+fontName+']');
					$li.length!=0 && $li.addClass('active').siblings().removeClass('active');
					$('#fontList').toggle();
				});
				
				//点击字体列表
				$('#fontList li').on('click', function(){
					var fontName=$(this).attr('val');
					$active.css('font-family',fontName);
					$(this).siblings().removeClass('active');
					/*
					if (fontName=='Farrington7B'){
						$active.find('ortext').css('top', '3px\0');
					} else {
						$active.find('ortext').css('top', '0px');
					}*/
				});
				
				//字号初始化
				fontListInit();
				
				//字号下拉
				$fontSizeSelect.on('click', function(evt){
					hideSelect('#fontSizeList', '#fontSizeList2');
					evt.stopPropagation();
					if (!$active || $active.find('ortext').length==0) return;
					var fontSize = parseInt($active.find('ortext').css('fontSize'))*2;
					var idStr='#fontSizeList';
					if ($active.css('fontFamily')=='Farrington7B'){
						idStr='#fontSizeList2';
					}
					var $li=$(idStr+' li[val='+fontSize+']');
					$li.addClass('active').siblings().removeClass('active');
					$(idStr).toggle().scrollTop($li.height()*(fontSize-22));
				});
				
				//点击字体大小
				$('#fontSizeList li, #fontSizeList2 li').on('click', function(){
					var size=parseInt($(this).attr('val')-'')/2;
					setFontSize(size);
					$(this).siblings().removeClass('active');
				});

				//改变$active文字大小
				function setFontSize(size){
					var fontSize=size;
					var lineHeight=size;
					var width=size;
					$active.css({'fontSize':fontSize+'px','lineHeight':lineHeight+'px'}).find('img').css({'width':width});
				}
				
				//7B字体颜色选择下拉
				$('.edit_color:last').on('click', function(evt){
					hideSelect('#colorList');
					evt.stopPropagation();
					if (!$active || $active.find('ortext').length==0) return;
					var color='#'+rgbToHex($active.css('color'));
					var $li=$('#colorList li[val='+color+']');
					$li.addClass('active').siblings().removeClass('active');
					$('#colorList').toggle();
				});
				
				//7B字体选择
				$('#colorList li').on('click', function(){
					var color=$(this).attr('val');
					$('#colorLabel').val(color.substring(1));
					$(this).siblings().removeClass('active');
				});
				
				//字体下拉列表和字号下拉列表隐藏
				$(document).on('click', function(){
					hideSelect();
				});
				
				//卡号格式下拉
				$('#numberFormat').on('click', function(evt){
					hideSelect('#numberFormatList');
					evt.stopPropagation();
					if (!$active || $active.find('ortext').length==0) return;
					if ($active.attr('label')!='卡号') return;
					var format=$active.attr('format');
					if (format){
						$(this).find('input').val(format);
						$(this).find('li:last').addClass('active');
					} else {
						$(this).find('input').val('');
						$(this).find('li:first').addClass('active');
					}
					
					$('#numberFormatList').toggle();
				});
				
				$('#numberFormatList li').on('click', function(evt){
					evt.stopPropagation();
				});
				
				//默认卡号格式保存
				$('#numberFormatList .default').on('click', function(){
					$active.attr('format', '');
					$('#numberFormat h6').html('默认连续');
					$('#numberFormatList').hide().find('.active').removeClass('active');
					setCardNum();
				});
				
				//卡号自定义格式保存
				$('#numberFormatList button').on('click', function(evt){
					evt.stopPropagation();
					var format=$(this).prev().val();
					var arr=format.split(/,+|，+|\s+/);
					format=arr.join(',');
					if (/[0]/.test(format)){
						$.global_msg.init({gType: 'warning', msg:'请输入正确卡号格式(如：4,4,4)', icon: 2});
						return;
					}
					$active.attr('format', format);
					$('#numberFormat h6').html(format);
					setCardNum(format);
					$('#numberFormatList').hide().find('.active').removeClass('active');
				});
				
				//生成卡号，写入active->ortext
				function setCardNum(format){
					var str='';
					if (!format){
						str='1111222233334444';
					} else {
						var arr=format.split(',');
						var list=[];
						for(var i=0;i<arr.length;i++){
							var str2='';
							for(var j=0;j<arr[i];j++){
								str2+=(i+1);
							}
							list.push(str2);
						}
						str=list.join(' ');
					}
					$active.attr('val', str).find('ortext').html(str);
				}
				
				//日期格式下拉
				$('#dateFormat').on('click', function(evt){
					hideSelect('#dateFormatList');
					evt.stopPropagation();
					if (!$active || $active.find('ortext').length==0) return;
					var label=$active.attr('label');
					if (label!='VALID THRU') return;
					var format=$active.attr('format');
					var $li=$('#dateFormat li[val="'+format+'"]');
					$li.addClass('active').siblings().removeClass('active');
					$('#dateFormatList').toggle();
				});
				
				//日期格式选择
				$('#dateFormatList li').on('click', function(){
					var format=$(this).attr('val');
					var v=$(this).html();
					$active.attr('format', format).attr('val', v).find('ortext').html(v);
					$(this).siblings().removeClass('active');
				});
				
				//隐藏下拉弹层
				function hideSelect(){
					var list=['#fontSizeList', '#fontSizeList2', '#fontList', '#colorList', '#numberFormatList', '#dateFormatList'];
					for(var i=0;i<list.length;i++){
						var flag=false;
						for (var j=0;j<arguments.length;j++){
							if (arguments[j]==list[i]){
								flag=true;
							}
						}
						if (flag) continue;
						$(list[i]).hide();
					}
				}
				
				//加粗
				$('#bold').on('click', function(){
					if (!$active || $active.find('ortext').length==0) return;
					if ($active.css('fontWeight')=='400'){
						$active.css('fontWeight','700');
						$(this).addClass('active');
					} else {
						$active.css('fontWeight','400');
						$(this).removeClass('active');
					}
				});
				//斜体
				$('#italic').on('click', function(){
					if (!$active || $active.find('ortext').length==0) return;
					if ($active.css('fontStyle')=='normal'){
						$active.css('fontStyle','italic');
						$(this).addClass('active');
					} else {
						$active.css('fontStyle','normal');
						$(this).removeClass('active');
					}
				});
				//下划线
				$('#underline').on('click', function(){
					if (!$active || $active.find('ortext').length==0) return;
					if ($active.find('ortext').css('textDecoration')=='none'){
						$active.find('ortext').css('textDecoration','underline');
						$(this).addClass('active');
					} else {
						$active.find('ortext').css('textDecoration','none');
						$(this).removeClass('active');
					}
				});
				
				//左对齐
				$('#left').on('click', function(){
					if (!$active || $active.find('ortext').length==0) return;
					$active.css('textAlign','left').find('*').css('float', 'left');
					$(this).addClass('active').siblings().removeClass('active');
					var $img=$active.find('img');
					if ($img.length>0){
						var $ortext=$active.find('ortext');
						$img.after($ortext);
					}
					
				});
				//居中
				$('#center').on('click', function(){
					if (!$active || $active.find('ortext').length==0) return;
					$active.css('textAlign','center').find('*').css('float', 'none');
					$(this).addClass('active').siblings().removeClass('active');
					var $img=$active.find('img');
					if ($img.length>0){
						var $ortext=$active.find('ortext');
						$img.after($ortext);
					}
				});
				//右对齐
				$('#right').on('click', function(){
					if (!$active || $active.find('ortext').length==0) return;
					$active.css('textAlign','right').find('*').css('float', 'right');
					$(this).addClass('active').siblings().removeClass('active');
					var $img=$active.find('img');
					if ($img.length>0){
						var $ortext=$active.find('ortext');
						$ortext.after($img);
					}
				});
				//面板居中
				$('.edit_center span').on('click', function(){
					if (!$active) return;
					$active.css('textAlign','center').find('ortext').css('float', 'none');
					$active.css('left', parseInt(WIDTH/4-parseInt($active.width()/2)));
				});
				
				//字体颜色可输入
				$colorLabel.removeAttr('readonly');
				
				//↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑文字操作方法
				//↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑文字操作方法
				//↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑文字操作方法
				
				//确认删除按钮
				$('#del').on('click', function(){
					if (!$active) return;
					$.global_msg.init({gType:'confirm',icon:2,msg:str_orangecard_del_confirm,btns:true,title:false,close:true,btn1:str_orangecard_cancel ,btn2:str_orangecard_confirm,noFn:function(){
						if (data[DATA_KEY].TEXT){
							for(var i=0;i<data[DATA_KEY].TEXT.length;i++){
								data[DATA_KEY].TEXT[i].ID == $active.attr('id') && data[DATA_KEY].TEXT.splice(i,1);
							}
						}
						if (data[DATA_KEY].IMAGE){
							for(var i=0;i<data[DATA_KEY].IMAGE.length;i++){
								data[DATA_KEY].IMAGE[i].ID == $active.attr('id') && data[DATA_KEY].IMAGE.splice(i,1);
							}
						}
						if (data[DATA_KEY].TEMP){
							if (data[DATA_KEY].TEMP.ID == $active.attr('id')){
								data[DATA_KEY].TEMP.BGURL = '';
							}
						}
						$active.remove();
						showUploadImg();
					}});
				});
				
				//正面切换
				$('#front').on('click', function(){
					if ('FRONT' == DATA_KEY || $(this).attr('disabled')) return;
					$canvases.removeClass('flip');
					DATA_KEY = 'FRONT';
					$canvas=$canvases.eq(0);
					removeActive();
					$('#tab_1 .row:gt(0) input:checkbox').removeAttr('uuid').iCheck('uncheck');
					setTimeout(function(){
						render(true);
						addPhoneIcon();
						$('orbg').show();
						$('#front, #back').removeAttr('disabled');
						$('#front').addClass('btnBg');
						$('#back').removeClass('btnBg');
						showUploadImg();
					},300);
				});
				
				//反面切换
				$('#back').on('click', function(){
					if ('BACK' == DATA_KEY || $(this).attr('disabled')) return;
					$canvases.addClass('flip');
					DATA_KEY = 'BACK';
					$canvas=$canvases.eq(1);
					removeActive();
					$('#tab_1 .row:gt(0) input:checkbox').removeAttr('uuid').iCheck('uncheck');
					setTimeout(function(){
						render(true);
						addPhoneIcon();
						$('orbg').show();
						$('#front, #back').removeAttr('disabled');
						$('#back').addClass('btnBg');
						$('#front').removeClass('btnBg');
						showUploadImg();
					},300);
				});
				
				//保存图片
				$('#submit').on('click', function(){
					if (!data['FRONT'].TEMP.BGURL){
						$.global_msg.init({gType: 'warning', msg:str_orangecard_nct_upload_front, icon: 2});
						return;
					}
					
					//判断有没有添加元素
					if (data['FRONT'].TEXT.length==0 && data['BACK'].TEXT.length==0 && 
							data['FRONT'].IMAGE.length==0 && data['BACK'].IMAGE.length==0){
						$.global_msg.init({gType: 'warning', msg:str_orangecard_nct_add_attr, icon: 2}); 
						return;
					}
					
					//判断是否有空值
					/*
					var msg='';
					$('.card_ul_text input').each(function(){
						if ($(this).val()==''){
							msg='【'+$(this).prev().html()+'】'+str_orangecard_not_empty;
							return false;
						}
					});
					 
					if (msg){
						$.global_msg.init({gType: 'warning', msg:msg, icon: 2});
						return;
					}*/
					
					/*
					//必填字段判断
					if (REQUIRED){
						var unpassed=[];
						for(var i=0;i<REQUIRED.length;i++){
							var flag=false;
							for(var j=0;j<data.FRONT.TEXT.length;j++){
								if (data.FRONT.TEXT[j].VALUE.LABEL == REQUIRED[i].attr){
									flag=true;
									break;
								}
							}
							for(var j=0;j<data.BACK.TEXT.length;j++){
								if (data.BACK.TEXT[j].VALUE.LABEL == REQUIRED[i].attr){
									flag=true;
									break;
								}							
							}
							for(var j=0;j<data.FRONT.IMAGE.length;j++){
								if (data.FRONT.IMAGE[j].LABEL == REQUIRED[i].attr){
									flag=true;
									break;
								}
							}
							for(var j=0;j<data.BACK.IMAGE.length;j++){
								if (data.BACK.IMAGE[j].LABEL == REQUIRED[i].attr){
									flag=true;
									break;
								}
							}
							
							if (!flag){
								unpassed.push(REQUIRED[i].attr);
							}
						}
						if (unpassed.length>0){
							$.global_msg.init({gType: 'warning', msg:str_orangecard_nct_add_attr_multiple+unpassed.join(','), icon: 2}); 
							return;
						}
					}*/
					
					//是否为卡类型公用模板
					var applyAll=$('#applyAll').is(':checked')?'fire':'';
					var cardtypeid=$('#cardtypeid').val();
					
					$(this).attr('disabled', true).html(str_orangecard_ets_saving);
					var $_this=$(this);
					setTimeout(function(){
						$.ajax({
				            'type':'post',
				            'async':false,
				            'url':URL_SAVEIMG,
				            'data':{data:data,textData:getTextData(),cardId:cardId, applyAll:applyAll, cardtypeid:cardtypeid},
				            'success':function(rst){
				            	rst = $.parseJSON(rst);
				            	if (rst.status=='0'){
				            		$.global_msg.init({gType:'warning', msg:rst.msg, btns:true, icon:1});
				            		//跳转
				            		setTimeout(function(){
				            			location.href=URL_FROM;
				            		}, 1000);
				            	} else {
				            		$.global_msg.init({gType:'warning', msg:rst.msg, btns:true, icon:0});
				            	}
				    		}
				        });
						$_this.removeAttr('disabled').html(str_orangecard_save);
					},100);
				});
				
				//图片上传
				$('#imgFile').on('change', function(){
					var $em=$(this).next();
					$em.html($em.attr('uploading'));
					uploadImages($(this), function(url){
						$em.html($em.attr('str'));
						if (url){
							addBg(url,data[DATA_KEY].TEMP.ID,true,true);
							$em.hide().prev().hide();
						}
					});
				});
				//IE9 input偏移调整
				if (window.browser.type=='IE' && window.browser.version=='9'){
					$('#imgFile').css('marginLeft', -265);
				}
				
			}
		}
	});
})(jQuery);