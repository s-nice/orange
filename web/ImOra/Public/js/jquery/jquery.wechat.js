$.extend({
	wechat:{
		alert:function(obt){
			if(typeof obt=='string'){
				var thisObt = {
					msg:obt,
					endFn:function(){

					}
				};
			}else if(typeof obt == 'object'){
				var thisObt = {
					msg:'',
					endFn:function(){
					}
				};
				thisObt = $.extend(true,thisObt,obt);
			}
			//console.log(thisObt);return false;
			if($('.js_wechat_dialog').length){
				$('.js_wechat_dialog').find('.js_dialog_msg').html(thisObt.msg);
				$('.js_wechat_dialog').show();
			}else{
				var html = '<div class="js_wechat_dialog">';
				html+= '<div class="weui-mask"></div>';
				html+= '<div class="weui-dialog">';
				html+= '<div class="weui-dialog__bd js_dialog_msg">';
				html+= thisObt.msg;
				html+= '</div>';
				html+= '<div class="weui-dialog__ft">';
				html+= '<a class="weui-dialog__btn weui-dialog__btn_primary js_dialog_alert">知道了</a>';
				html+= '</div></div></div>';
				$('body').append(html);
			}
			$('.js_dialog_alert').on('click',function(){
				$('.js_wechat_dialog').hide();
				thisObt.endFn();
			});
		}
	}
});