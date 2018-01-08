function bindback(arr){
	if(arr['status'] == 0){
		// 绑定成功,重置页面
		$.global_msg.init({msg:arr['msg'],title:false,close:false,gType:'alert',btns:true,icon:1,endFn:function(){
//			$($('.js_custom_menu')[0]).trigger('click');
			//showBindIndex();
			window.location.href = window.location.href;
		}});
	}else{
		$.global_msg.init({msg:arr['msg'],title:false,close:false,gType:'alert',btns:true});
	}
}
function showBindIndex(){
	$.ajax({
		type:'post',
		url:jsbindurl,
		success:function(re){
			$('.js_vr_bind').html(re);
			$.custom.setCount();
		},
		error:function(){
			$.global_msg.init({msg:'未知错误',title:false,close:false,gType:'alert',btns:true});
		}
	});
}