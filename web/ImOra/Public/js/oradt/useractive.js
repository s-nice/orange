var gMultiValueSeparator = ',';
;(function(){
	   $(function(){
    	  /* //日期插件
           var opts = {
        		    startDateSel: '#js_begintime',
					endDateSel: '#js_endtime',
					startDateSel1: '#js_begintime_duibi',
					endDateSel1: '#js_endtime_duibi'
				};
           $.pageInfo.dataTimeLoad(opts);    */       
		   //给渠道、版本、省份添加滚动条
           /*var scrollObjs = $('.js_sel_user_channel>ul,.js_sel_user_prd_version>ul,#select_province>ul');
           scrollObjs.each(function(i,dom){
        	   console.log($(dom).height())
        	   var scrollObj = $(dom);
               if(scrollObj.height() >200){
               	   scrollObj.height(200);
                   if(!scrollObj.hasClass('mCustomScrollbar')){
                       scrollObj.mCustomScrollbar({
                           theme:"dark", //主题颜色
                           autoHideScrollbar: false, //是否自动隐藏滚动条
                           scrollInertia :0,//滚动延迟
                           horizontalScroll : false,//水平滚动条
                       });
                   }
               }
           });          */
	   });
})(jQuery);


/**
 * 导出数据
 * @param url String 导出数据时请求的url地址
 * @param exportFormat (FORMAT_EXCEL|FORMAT_CSV)
 * @param params 导出请求时传递给后台的参数，例如:var params = {startTime:startTime,endTime:endTime};
 */
function exportFn(url,params){	
	if(typeof($('#iframe_id').attr('src')) == 'undefined'){
		var iframeHtml = '<iframe id="iframe_id" style="display:none"></iframe>';
		$('body').append(iframeHtml);
	}	
	var params = params || {};
	if(!url){
		$.global_msg.init({msg:t['export_params_err'],time:3});
		return;
	}	
	var paramStr = getEscapeParamStr(params);
	url = url + '/' + paramStr;
	$("#iframe_id").attr('src',url);
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

//异步请求数据
function ajaxRequestData(opts){
	var data = getRemainParam(opts);
	if(data !== false){
		typeof(opts) != 'undefined' ? (data = $.extend(true,{},data, opts)) : null;
		getDataUrlIndex = getDataUrlIndex.replace('.html','');
		window.location.href = getDataUrlIndex+'/'+ getEscapeParamStr(data);
	}
}

/* 		//导出企业名片
$('#comCardsExport').click(function(){
	if(typeof($('#iframe_id').attr('src')) == 'undefined'){
		var iframeHtml = '<iframe id="iframe_id" style="display:none"></iframe>';
		$('body').append(iframeHtml);
	}
	$("#iframe_id").attr('src',urlExport);
}); */