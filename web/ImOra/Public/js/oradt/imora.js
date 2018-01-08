/**
 */
$(function() {
	$('#ehdel_upload_text').uploadify({ //上传插件
		formData: {
			__PHP_SESSID :gSessionId // 上传同时提交SessionID

		},
		auto:false,//选取文件后自否自动开始上传
		buttonCursor:'hand',//手型鼠标s
		queueSizeLimit:1,//每次最多上传1个文件
		fileTypeExts: '*.zip;*.apk',//文件类型
		fileSizeLimit:gMaxSize+'MB', //限制上传文件大小
		multi: false,//不允许一次选择多个文件
		progressData: 'percentage',//上传显示百分比
		queueID:'upload_show',//进度条显示容器的ID
		swf      : gSwfPath, //插件必填swf路径
		uploader : gUploadThemeUrl, //上传到后台的地址
		onSelect:function(fileObj){ //选择上传文件时触发
			$('#uploadMsg').html(fileObj.name); //提示框显示文件名
			$('#proUpload').css('display','none');
			$('#proUpload').val(0);//进度条值归零
			$('#ehdel_upload_text').uploadify('cancel','*');//取消上传队列
		},
		//checkExisting: gUploadThemeUrl ,//此文件检查正要上传的文件名是否已经存在目标目录中。存在时返回1，不存在时返回0
		onUploadSuccess: function(file,data){ //上传到后台成功后执行
			if(JSON.parse(data).Msg=='success') { //后台验证成功
				$('#addThemeSize').val((file.size / 1024 / 1024).toFixed(2));//上传主题包的大小，单位M
				//上传主题包的URL路径
				$('#addThemeFileName').val(JSON.parse(data).saveName);
			}else {  //后台验证不成功
				$.global_msg.init({msg: JSON.parse(data), icon: 0});
				$('#proUpload').css('display','none');
				$('#proUpload').val(0);//进度条值归零
				$('#uploadMsg').html('点击选择文件');//提示框重置
				$('#ehdel_upload_text').uploadify('cancel','*');//取消上传队列
			}
		},
		onUploadError: function(){ //上传到后台失败
			$.global_msg.init({msg: gUploadFail, icon: 0});

		},
		onUploadProgress: function(file,bytesUploaded,bytesTotal,totalBytesUploaded,totalBytesTotal){
			$('#proUpload').css('display','block');
			//console.log(bytesUploaded+"."+file.size+"."+totalBytesTotal);
			var proVal=Math.round(bytesUploaded/file.size* 100);//进度条的值
			proVal=proVal>100 ? 100 :proVal;
			$('#proUpload').val(proVal);//进度条的值
			$('#uploadMsg').html(proVal+'%');//进度显示的值

		},

	});
	$('#ehdel_upload_btn').on('click',function(){ //开始上传事件
		$('#ehdel_upload_text').uploadify('upload','*');//开始上传文件

	});
	$('.js_logoutcancel').on('click',function(){ //取消按钮
		$('#proUpload').css('display','none');
		$('#proUpload').val(0);//进度条值归零
		$('#uploadMsg').html('点击选择文件');//提示框重置
		$('#ehdel_upload_text').uploadify('cancel','*');//取消上传队列

	})

});
(function($) {
	$.extend({
		imora: {
			init: function() {
				/*绑定事件*/
				this.ManageTheme();
			},
			ManageTheme:function(){
				//添加新theme
				$('.js_add_app_btn').on('click',function(){
					$('.js_add_app_popup, .js_masklayer').show();
					$('.js_add_app_popup input[type="text"]').val('');
					return false;
				});
				/*全选反选*/
				$('#content_c').checkDialog({
					checkAllSelector:'#js_allselect',
					checkChildSelector:'.js_select',
					valAttr:'val',selectedClass:'active'
				});
				/*列表排序*/

				$(".js_sort").click(function(){
					var sortUrl=window.location.pathname; //获取URL中的参数
					var sort=$(this).attr('action'); //获取点击排序列信息
					if(sortUrl.indexOf(sort) > 0){ //判断当前URL是否为点击列的升序排序，是变为降序。，否重新定义
						sortUrl=sortUrl.replace('asc','desc');
						window.location= sortUrl;
					}
					else {
						window.location=gUrl.replace('.html','/p/')+p+'/sort/'+sort+'.html';
					}

				});

				/**
				 * 添加app theme
				 */
				$('#subTheme').on('click', function () {
					var postStatus = 1; //提交数据的状态
					$('.js_Themes_Upload_val').each(function(){ //遍历表单判断是否为空
						if(''== $(this).val()){
							postStatus = 0; //为空，状态为0，弹出错误信息
							$.global_msg.init({msg:gSubmitNull,icon:0,time:2});
						}
					});
					if( postStatus == 1 ){ //不为空后提交
						$.ajax({
							url : gUrl,
							type: 'get',
							data: {
								'action':'add',
								'version':$('#addThemeVersion').val(),
								'content':$('#addThemeContent').val(),
								'fileName' :$('#addThemeFileName').val(),
								'size':$('#addThemeSize').val(),
								'name':$('#addThemeName').val(),
								'author':$('#addThemeAuthor').val(),
								'p':p,
								'sort':gSort
							},
							success:function(response){ //提交成功
								$('.js_add_app_popup, .js_masklayer').hide();
								$('#proUpload').css('display','none');
								$('#proUpload').val(0);//进度条值归零
								$('#uploadMsg').html('点击选择文件');//提示框重置
								$('#ehdel_upload_text').uploadify('cancel','*');//取消上传队列
								if(response.status=='0'){//后台添加成功后刷新列表
									$('#themeList').replaceWith(response.data.list);
									$('.page').replaceWith(response.data.page);
								}else{ //后台添加失败后弹框
									$.global_msg.init({msg:response.msg,icon:0});
								}
							},
							fail:function(){ //ajax提交失败
								$.global_msg.init({msg:gSubmitFail,icon:0});
							}
						});

					}

					return false;
				});
				/*
				 * 删除
				 * */
				$('#content_c').on('mouseover', function () {
					$('.js_delTheme ,#delTheme').off('click').on('click',function(){ //点击事件
						if( $(".Journalsection_list_c .active").length >0 ) { //判断是否有勾选的列表
							$.global_msg.init({   //确认删除弹框
								gType: 'confirm',
								icon:2,
								msg: gDelThememsg[0],
								btns: true, btn1: gDelThememsg[1],
								btn2:  gDelThememsg[2],
								close:true,
								title:false,
								fn: function () { //确定后执行删除
									var _del = $(".Journalsection_list_c .active");//选定的删除列表
									var delId = new Array;
									_del.each(function () { //勾选删除每个列表的ID
										delId.push($(this).attr('val'));
									});
									var delId = delId.join();
									$.ajax({
										url: gUrl,
										type: 'get',
										data: {
											'action':'del',
											id: delId,
											p:p,
											sort:gSort

										},
										success: function (response) { //提交成功
											if (response.status == '0') { //后台删除成功，刷新列表
												$('#themeList').replaceWith(response.data.list);
												$('.page').replaceWith(response.data.page);
											} else { //后台弹出失败弹框
												$.global_msg.init({msg: response.message, icon: 0});
											}
										},
										fail: function () { //ajax提交失败
											$.global_msg.init({msg: gSubmitFail, icon: 0});
										}
									});
								}
							});
							return;
						}

					});

				});
			}

		}
	});
	// 载入页面事件监听
	$.imora.init();
})(jQuery);