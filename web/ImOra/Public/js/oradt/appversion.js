/**
 * APP版本控制
 */
(function($) {
    $.extend({
        appversion: {
        	//银联APP下载地址管理
        	unionpayUrls: function(){
        		$('.app_download button').on('click', function(){
        			var $input=$(this).prev();
        			var params={
        				'key':$input.attr('name'),
        				'val':$.trim($input.val())
        			};
        			
        			//表单验证
        			if (params.val==''){
        				$.global_msg.init({gType:'warning',msg:'参数不能为空',icon:0});
        				return;
        			}
        			if (params.val.length>512){
        				$.global_msg.init({gType:'warning',msg:'长度不能超过512',icon:0});
        				return;
        			}
        			$.ajax({
        				url:URL_DO,
        				async:false,
        				type:'post',
        				data:params,
        				dataType:'json',
        				success:function(res1){
        					if(res1['status']=='0'){
        						$.global_msg.init({gType:'warning',msg:'保存成功',icon:1});
        					}else{
        						$.global_msg.init({gType:'warning',msg:res1['msg1'] || res1['msg'],icon:0});
        					}
        				},
        				fail:function(err){
        					$.global_msg.init({gType:'warning',msg:'error',icon:0});
        				}
        			});
        		});
        	},
        	
        	//APP版本控制列表页
        	versionList: function(){
        		//新增版本页面
        		$('#addversion').on('click', function(){
        			location.href=URL_ADD;
        		});
        		
        		//排序
        		$('.userpushlist_name .sort').on('click', function(){
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
        			$.appversion.listReload();
        		});
        		
        		//搜索按钮
        		$('#js_searchbutton').on('click', function(){
        			$.appversion.listReload();
        		});
        		
        		//修改
        		$('.edit').on('click', function(){
        			location.href=$(this).attr('href');
        		});
        		
        		//删除
        		$('.delete').on('click', function(){
        			var url=$(this).attr('href');
        			$.global_msg.init({gType:'confirm',icon:2,msg:'确认删除？',btns:true,title:false,close:true,btn1:'取消' ,btn2:'确定',noFn:function(){
        				$.ajax({
            				url:url,
            				async:false,
            				type:'post',
            				//data:params,
            				dataType:'json',
            				success:function(res1){
            					if(res1['status']=='0'){
            						$.global_msg.init({gType:'warning',msg:res1['msg1'],icon:1,endFn:function(){
            							$.appversion.listReload();
                                    }});
            					}else{
            						$.global_msg.init({gType:'warning',msg:res1['msg1'],icon:0});
            					}
            				},
            				fail:function(err){
            					$.global_msg.init({gType:'warning',msg:'error',icon:0});
            				}
            			});
        			}});
        		});
        		
        		//开启/关闭IOS审核控制
        		$('.switch').on('click', function(){
        			var aid=$(this).parent().siblings('.span_span1:first').html();
        			var $isios=$(this).parent().siblings('.span_span2:eq(1)');
        			var isios=$isios.attr('isios')=='1'?2:1;
        			var params={'id':aid,'isios':isios};
        			$.ajax({
        				url:URL_SWITCH,
        				async:false,
        				type:'post',
        				data:params,
        				dataType:'json',
        				success:function(res1){
        					if(res1['status']=='0'){
        						$.global_msg.init({gType:'warning',msg:res1['msg1'],icon:1,endFn:function(){
        							$.appversion.listReload();
                                }});
        					}else{
        						$.global_msg.init({gType:'warning',msg:res1['msg1'],icon:0});
        					}
        				},
        				fail:function(err){
        					$.global_msg.init({gType:'warning',msg:'error',icon:0});
        				}
        			});
        		});
        	},
        	
        	//APP版本控制列表页搜索方法
        	listReload: function(){
        		var params={
            		'keyword': $('.s_key').val(),
            		'order': $('#order').val(),
            		'ordertype': $('#ordertype').val()
            	}
            	params = $.param(params);
            	location.href=URL_LIST+'?'+params;
        	},
        	
        	//添加/修改版本控制页面
        	addversion: function(){
        		//Android IOS 切换
        		$('.card_name_w:eq(0) input').on('click', function(){
        			$('#android,#ios,.apkurl').hide();
        			var id=$(this).val().toLowerCase()
        			$('#'+id).show();
        			if (id=='android'){
        				$('.apkurl').show();
        			}
        			if (id=='ios'){
        				$('#ios').show();
        			}
        		});
        		//强制更新切换
        		$('.card_name_w:eq(3) input').on('click', function(){
        			if ($(this).val()==1){
        				$('#noUpdateTip').hide();
                        $("input[name='iscontrol'][value='1']").attr('checked','checked');
                        $("input[name='iscontrol'][value='2']").attr({'disabled':'disabled','checked':false});
        			} else {
        				$('#noUpdateTip').show();
                        $("input[name='iscontrol'][value='2']").attr({'disabled':false});
        			}
        		});
        		$("input[name='iscontrol']").on('click',function(){
                    if ($(this).attr('value') == '1') {
                        $("input[name='iscontrol'][value='1']").attr('checked','checked');
                        $("input[name='iscontrol'][value='2']").attr({'checked':false});
                    } else {
                        $("input[name='iscontrol'][value='1']").attr('checked',false);
                        $("input[name='iscontrol'][value='2']").attr({'checked':'checked'});
                    }
                });
        		//日期选择
        		$('#updatetime').datetimepicker({
            		format:"Y-m-d H:i",lang:'ch',
            		showWeak:true,timepicker:true,
            		step:1,
            		minDate:new Date().format('Y-m-d H:i'),
            		minTime:new Date().format("H:i"),
                    onSelectDate: function(date,obj){ //解决超过‘今天’ 分钟选择的限制
                        var now=new Date().format();
                        date=date.format();
                        var params={};
                        if (date > now){
                            params.minTime=false;
                        } else {
                            params.minTime=new Date().format('H:i');
                        }
                        obj.datetimepicker(params);
                    }
            	}).next().on('click', function(){
            		$('#updatetime').datetimepicker('show');
            	});
        		
        		//上传按钮
        		$('.click_btn_r').on('click', function(){
        			$('#file').click();
        		});
        		
        		//图片上传
        		$('#file').on('change', function(){
        			$('.click_btn_r').html('上传中...');
        			var filename=$(this).val().split('\\').pop();
        			uploadImages($(this), function(url){
        				$('.apkurl').show().find('i').html(url);
        				$('#android em').show().find('b').html(filename);
        				$('.click_btn_r').html('上传');
        			});
        		});
        		
        		//上传提示成功
        		/**
        		 * 上传图片方法
        		 * @param $obj (input=='file' 的 jquery对象)
        		 * @param func (回调方法)
        		 */
        		function uploadImages($obj, func){
        			var val = $obj.val();
        		    var names=val.split(".");
        		    //var allowedExtentionNames = ['gif', 'jpg', 'jpeg', 'png'];
        		    var allowedExtentionNames = ['apk'];
        		    if($.inArray(names.pop().toLowerCase(), allowedExtentionNames)==-1){
        		        //$.global_msg.init({msg:TIP_WRONG_IMG, btns:true});
        		        $.global_msg.init({gType:'warning', msg:'文件格式不对', btns:true, icon:2});
        		        $('.click_btn_r').html('上传');
        		        return;
        		    }
        		    $.ajaxFileUpload({
        				url:URL_UPLOAD,
        				secureuri:false,
        				fileElementId:$obj.attr('id'),
        				dataType: 'json',
        				success: function (data, status){
        					if (data.status!='0'){
        						$.global_msg.init({gType:'warning', msg:data.info, btns:true, icon:2});
        						$('.click_btn_r').html('上传');
        						return;
        					}
        					func(data.url);
        				},
        				error: function (data, status, e){
        					alert(e);
        				}
        			});
        		}
        		
        		//取消
        		$('#cancel').on('click', function(){
        			location.href=URL_LIST;
        		});
        		
        		//保存
        		$('#save').on('click', function(){
        			var params={
        				'id':$('#id').val(),
        				'version':$.trim($('#version').val()),
        				'updateprompt':$.trim($('#updateprompt').val()),
        				'unionpaynum':$.trim($('#unionpaynum').val()),
        				'upbutton':$.trim($('#upbutton').val()),
        				'noupbutton':$.trim($('#noupbutton').val()),
        				'updatetime':$('#updatetime').val(),
        				'updatelog':$.trim($('#updatelog').val()),
        				'url':$.trim($('#url').val()),
        				'devicetype':$('input[name="devicetype"]:checked').val(),
        				'isios':$('input[name="isios"]:checked').val(),
        				'isredeemcode':$('input[name="isredeemcode"]:checked').val(),
        				'isupdate':$('input[name="isupdate"]:checked').val(),
                        'iscontrol':$('input[name="iscontrol"]:checked').val()
        			};
        			
        			if (params.version==''){
        				$.global_msg.init({gType:'warning', msg:'【APP版本】不能为空', btns:true, icon:2});
        				return;
        			}
        			if (params.version.length>80){
        				$.global_msg.init({gType:'warning', msg:'【APP版本】长度不能超过80', btns:true, icon:2});
        				return;
        			}
        			if (params.updateprompt==''){
        				$.global_msg.init({gType:'warning', msg:'【版本更新提示语】不能为空', btns:true, icon:2});
        				return;
        			}
        			if (params.updateprompt.length>80){
        				$.global_msg.init({gType:'warning', msg:'【版本更新提示语】长度不能超过50', btns:true, icon:2});
        				return;
        			}
        			/*
        			if (params.unionpaynum==''){
        				$.global_msg.init({gType:'warning', msg:'【银联SDK限制版本号】不能为空', btns:true, icon:2});
        				return;
        			}*/
        			if (params.unionpaynum.length>80){
        				$.global_msg.init({gType:'warning', msg:'【银联SDK限制版本号】长度不能超过80', btns:true, icon:2});
        				return;
        			}
        			if (params.upbutton==''){
        				$.global_msg.init({gType:'warning', msg:'【更新按钮显示】不能为空', btns:true, icon:2});
        				return;
        			}
        			if (params.upbutton.length>20){
        				$.global_msg.init({gType:'warning', msg:'【更新按钮显示】长度不能超过20', btns:true, icon:2});
        				return;
        			}
        			if (params.isupdate=='2' && params.noupbutton==''){
        				$.global_msg.init({gType:'warning', msg:'【暂不更新按钮显示】不能为空', btns:true, icon:2});
        				return;
        			}
        			if (params.isupdate=='2' && params.noupbutton.length>20){
        				$.global_msg.init({gType:'warning', msg:'【暂不更新按钮显示】长度不能超过20', btns:true, icon:2});
        				return;
        			}
        			if (params.updatelog==''){
        				$.global_msg.init({gType:'warning', msg:'【更新内容】不能为空', btns:true, icon:2});
        				return;
        			}
        			if (params.devicetype=='ios'){
        				params.url='';
        			} else {
        				if (params.url==''){
            				$.global_msg.init({gType:'warning', msg:'【Android安装包】不能为空', btns:true, icon:2});
            				return;
            			}
        				params.isredeemcode=1;
        			}
        			//console.info(params);return;
        			var url=URL_DO_ADD;
        			if (params.id){
        				url=URL_DO_EDIT;
        			}
        			$.ajax({
        				url:url,
        				async:false,
        				type:'post',
        				data:params,
        				dataType:'json',
        				success:function(res1){
        					if(res1['status']=='0'){
        						$.global_msg.init({gType:'warning',msg:res1['msg1'],icon:1,endFn:function(){
                                    location.href=URL_LIST;
                                }});
        					}else{
        						$.global_msg.init({gType:'warning',msg:res1['msg1'],icon:0});
        					}
        				},
        				fail:function(err){
        					$.global_msg.init({gType:'warning',msg:'error',icon:0});
        				}
        			});
        		});
        	}
        }
    });
})(jQuery);