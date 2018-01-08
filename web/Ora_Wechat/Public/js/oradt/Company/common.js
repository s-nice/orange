$.extend({
	selfTip:function(obt,msg,position){
		var po = arguments[2]?arguments[2]:'left';
		obt.attr('data-content',msg);
		obt.popover({placement:po, trigger:'manual'});
		obt.popover('show');
		$(document).one('click',function(){
			obt.popover('hide');
		})
	}
});
$(function(){
	$('input').on('focus',function(){
		$(this).popover('hide');
	});
	
});