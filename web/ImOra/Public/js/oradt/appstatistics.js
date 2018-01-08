/**
 * 统计页面js
 */
var gMultiValueSeparator = ',';
(function($) {
	//点击下拉
	$('.js_select_item li').on({'click':function(){
		$(this).closest('.js_select_item').find('input').trigger('change');
    	}
    });
	//切换时间
	$('.js_stat_date_type').on('click','a',function(){
        var	v = $(this).attr('val');//获取值
        $('input[name=statType]').val(v);//添加到表单
        $(this).addClass('on');//添加选中样式
        $(this).siblings('a').removeClass('on');//移除兄弟选中样式
        $('input[name=startTime]').val('');//清空开始时间
    	$('input[name=endTime]').val('');//清空结束时间
        $('.form_margintop').submit();//表单提交
    });
	//对比
    $('.time_button').click(function(){
    	$(this).next('.time_duibi').toggle();//切换显示对比
    });
    //切换统计类型
    $('input[name=type]').on('change',function(){
//    	$('input[name=sysPlatform]').val(str_title_app_type);
//    	$('input[name=channel]').val(str_channel);
//    	$('input[name=version]').val(str_prd_version);
 //   	$('input[name=startTime]').val('');
   // 	$('input[name=endTime]').val('');
    	$('.form_margintop').submit();
    });
    //导出
	$('#exportBtn').click(function(){
		var data = {};
		    $.each(formData,function(key,val){
		    	data[val.name] = val.value;//导入表单数据
			  });
		    data.downloadStat = 1;//下载标识
	     var url = $(this).attr('url').replace('.html','');//替换html
	     exportFn(url,data);//下载方法
	});
	//点击对比提交表单
	$('.timeduibi_button').click(function(){
		$('.form_margintop').submit();
	});
	
	//提交判断时间
	$('.submit_button').on('click',function(){
	    var  starttime  =  $('#js_begintime').val();
	    var  endtime  =  $('#js_endtime').val();
	    //时间不能为空
	    if(starttime == '' || endtime == ''){
	        $.global_msg.init({gType:'warning',icon:2,msg:js_Empty_Time});
	    }else{
	    	$('.form_margintop').submit();
	    }
		
	});
	
	
})(jQuery);

/**
 * 导出数据
 * @param url String 导出数据时请求的url地址
 * @param params 导出请求时传递给后台的参数，例如:var params = {startTime:startTime,endTime:endTime};
 */
function exportFn(url,params){	
	if(typeof($('#iframe_id').attr('src')) == 'undefined'){
		var iframeHtml = '<iframe id="iframe_id" style="display:none"></iframe>';//无刷新下载iframe
		$('body').append(iframeHtml);
	}	
	var params = params || {};
	//url 为空提示
	if(!url){
		$.global_msg.init({msg:t['export_params_err'],time:3});
		return;
	}	
	//编码url
	var paramStr = getEscapeParamStr(params);
	url = url + '/' + paramStr;
	$("#iframe_id").attr('src',url);//替换iframe src值 完成下载
}

//编码url
function getEscapeParamStr (jsonData){
	if (!jsonData) return '';
	var qarr = [];
	for(i in jsonData){
		qarr.push(i+"/"+encodeURIComponent(jsonData[i]));
	}
	return qarr.join('/');
}
