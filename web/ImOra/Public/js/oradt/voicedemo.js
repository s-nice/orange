$(function(){
	window.running = false; //未录音
    //if(!localStorage.rainAllowRecord || localStorage.rainAllowRecord !== 'true'){
    	//testVoice();
   // }
    
    //按下开始录音
    $('#outdiv').on('touchstart','.voiceId', function(event){
    	/*$('#js_load_img').show();
        $(this).css('background','#CCC').addClass('clsActive');
        $(this).find('em').html('松开搜索');*/
        var thisObj = $(this);
        event.preventDefault();
        START = new Date().getTime();
        //recordTimer = setTimeout(function(){
            wx.startRecord({
                success: function(){
                	//$("title").html("朋友圈"); //document.title='朋友圈';
                	$('#js_load_img').show();
                	thisObj.css('opacity','.6').addClass('clsActive');
                	thisObj.find('em').html(js_trans_str_g_list_up_search);
                	$('#js_load_img').find('.js_tip_text').text(js_trans_str_g_list_inrecording);
                	localStorage.rainAllowRecord = 'true';
                    window.running = true;
                },
                fail: function () {
                	$('#js_load_img').find('.js_tip_text').text('');
                	$('#js_load_img').hide();
                },
                cancel: function () {
                	$('#js_load_img').find('.js_tip_text').text('');
                	$('#js_load_img').hide();
                    alert(js_trans_str_g_list_user_denyrecording);
                }
            });
        //},10);

    });
    $('#outdiv').on('touchend', '.voiceId',function(event){
        //$(this).removeClass('js_btn_active');
       $(this).css({'background':'#ea9566','opacity':'1'});//.removeClass('clsActive');
        setTimeClear();
        $(this).find('em').html(js_trans_str_g_list_btn_say);
        ajaxLog({'voice':1});
        window.logStartTime = new Date().getTime();
        event.preventDefault();
        END = new Date().getTime();
        var total=1500;
        ajaxLog({'voice-1-a':(END-START),'flag':(END - START) < 500,'flagb':parseInt(END - START) < 500});
        if((END - START) < 600){
        	ajaxLog({'voice-1-b':total-(END-START)});
        	setTimeout(function(){
        		 ajaxLog({'voice':2});
        		jsStopRecord();
        	},total-(END - START));
        }else{
        	setTimeClear();
        	jsStopRecord();
        }
    });
    //定时去掉录音崩溃提示
    function setTimeClear(){
    	setTimeout(function(){
    		if(window.running == true){
            	$('#js_load_img').find('.js_tip_text').text('');
            	$('#js_load_img').hide();
            	//alert('识别失败,请重新语音');
            	$('.voiceId').css({'background':'#ea9566','opacity':'1'}).removeClass('clsActive');
            	updateTitle();
    		}    		
    	},2000)
    }
    
    //停止语音接口
    function jsStopRecord(){
    	  window.logStartTime2 = new Date().getTime();
        wx.stopRecord({
            success: function (res) {
            	 ajaxLog({'voice':3});
            	window.running = false;
            	$('#js_load_img').find('.js_tip_text').text('');
            	$('#js_load_img').hide();
		        window.localId = res.localId;
		        voiceComplate(res.localId);
            },
            fail: function (res) {
            	window.running = false;
            	$('#js_load_img').find('.js_tip_text').text('');
            	$('#js_load_img').hide();
            	var json = JSON.stringify(res);
            	var msg = js_trans_str_g_list_recognition_failure;
            	if(res.errMsg == 'stopRecord:fail'){
            		msg = js_trans_str_g_list_recognition_failure;
            	}else if(res.errMsg == 'stopRecord:tooshaort'){
            		msg = js_trans_str_g_list_record_short;
            	}
                alert(msg);
            }
        });
    }
    
	//监听录音自动停止接口
	wx.onVoiceRecordEnd({
	    // 录音时间超过一分钟没有停止的时候会执行 complete 回调
	    complete: function (res) {
	        window.localId = res.localId; 
	        voiceComplate(res.localId);
	    }
	});
	//监听语音播放完毕接口
/*	wx.onVoicePlayEnd({
	    success: function (res) {
	        var localId = res.localId; // 返回音频的本地ID
	    }
	});*/
	
});

function voiceComplate(localId){
	$('#sourdId').hide();
	//alert('识别start'+localId);
	wx.translateVoice({
		   localId: localId, // 需要识别的音频的本地Id，由录音相关接口获得
		    isShowProgressTips: 1, // 默认为1，显示进度提示
		    success: function (res) {
		    	$('.voiceId').css({'background':'#ea9566','opacity':'1'});//.removeClass('clsActive');
		    	//alert('识别end');
		        //alert(123+'-'+res.translateResult); // 语音识别的结果
		    	setVoiceToInput(res.translateResult);
		    },
		    complete: function(){
		    	$('.voiceId').css({'background':'#ea9566','opacity':'1'});//.removeClass('clsActive');
		    },
		    fail: function(){
		    	$('.voiceId').css({'background':'#ea9566','opacity':'1'});//.removeClass('clsActive');
		    }

		});
}
//设置识别后的数据到文本框中
function setVoiceToInput(text){
	text=text.substring(0,text.length-1)
	$('#search').val(text);
	window.logEndTime = new Date().getTime();
	var t = (window.logEndTime - window.logStartTime);
	var t2 = (window.logEndTime - window.logStartTime2); 
	//var param = {'微信转换执行时间：':t/1000};
	var tRound = t/1000;
	var tRound2 = t2/1000;
	var time = tRound.toFixed(3);
	var time2 = tRound2.toFixed(3);
	$('#weixinVoiceTime').val(time);
	$('#weixinVoiceTime2').val(time2);
	//ajaxLog(param);
	ajaxGetData();
}
//搜索输入框变化，请求数据
$('#search').on('input propertychange', function() {
    var _this = this;
    var searchword = $(this).val();
    if(searchword!=''){
        $('.js_x_btn').show();
    }else{
        $('.js_x_btn').hide();
    }

});
$('#searchBtn').click(function(){
	ajaxGetData();
});
//搜索输入框尾部 X 按钮
$('.js_x_btn').click(function(){
    $('#search,#type,#typekwds').val('');
    $(this).hide();
    ajaxGetData();
});

//ajax异步获取搜索数据
	function ajaxGetData(_keyword){
		var keyword = $('#search').val();
		if(keyword == js_trans_str_g_list_putcontent_search){
		    keyword='';
		}
        if(_keyword!=null && _keyword!='') keyword=_keyword;
		var openid = $('#openid').val();
		gVcardListUrl = gVcardListUrl.replace('.html','');
		var weixinVoiceTime = $('#weixinVoiceTime').val();
		var weixinVoiceTime2 = $('#weixinVoiceTime2').val();
		var sendReqTime = new Date().getTime();
		sendReqTime = sendReqTime/1000;
		sendReqTime = sendReqTime.toFixed(4);
		var android = $('#android').val();
		var type = $('#type').val();
		var typekwds = $('#typekwds').val();
		var paramArr = {'keyword':keyword,openid:openid,android:android, time:weixinVoiceTime,time2:weixinVoiceTime2,sendReqTime:sendReqTime,type:type,typekwds:typekwds};
		var paramStr = getEscapeParamStr(paramArr);
		window.location.href = gVcardListUrl+'/'+paramStr;

	}
	
	
	//编码url
	function getEscapeParamStr (jsonData){
		if (!jsonData) return '';
		var qarr = [];
		for(i in jsonData){
			if($.trim(jsonData[i]).length>0){
				qarr.push(i+"/"+encodeURIComponent(jsonData[i]));
			}
		}
		return qarr.join('/');
	}
	
    //记录日志到后台
    function ajaxLog(param){
    	if(typeof(gjsLogUrl) != 'undefined'){
    		$.post(gjsLogUrl,param,function(){});
    	}
    }
    
    document.setTitle = function(t) {
    	  document.title = t;
    	  var i = document.createElement('iframe');
    	  i.src = '//m.baidu.com/favicon.ico';
    	  i.style.display = 'none';
    	  i.onload = function() {
    	    setTimeout(function(){
    	      i.remove();
    	    }, 9)
    	  }
    	  document.body.appendChild(i);
    }
    
    //修改微信浏览器页面title
    function updateTitle($title){
    	 var $body = $('body');
    	  document.title = typeof($title) == 'undefined'?js_trans_str_g_list_place_friends:'';
    	  var $iframe = $("<iframe style='display:none;' src='/favicon.ico'></iframe>");
    	  $iframe.on('load',function() {
    	    setTimeout(function() {
    	      $iframe.off('load').remove();
    	    }, 0);
    	  }).appendTo($body);
    }
    
    function testVoice(){
    	/*if(typeof(gSysType) != 'undefined' && gSysType=='ios'){
    		$('.voiceId').show();
    	}*/
        wx.startRecord({
            success: function(){
            	$('#voiceIdcontroller').addClass('voiceId');
                localStorage.rainAllowRecord = 'true';
                window.running = true;
                if(typeof(gSysType) != 'undefined' && gSysType=='ios'){
                	setTimeout(function(){
                		wx.stopRecord();
                	},200)
                }else{
                	wx.stopRecord();
                }
                setTimeClear();
            },
            cancel: function () {
                alert(js_trans_str_g_list_user_denyrecording);
            }
        });
    }
