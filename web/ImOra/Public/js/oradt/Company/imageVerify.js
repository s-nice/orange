/*图片验证码js*/	
var gVFlag = 0;
var gVerifyBool = false;
$(function(){
    $('body').click(function (event) {
        var target = $(event.target);       // 判断自己当前点击的内容
        if (!target.hasClass('popover')
                && !target.hasClass('pop')
                && !target.hasClass('popover-content')
                && !target.hasClass('popover-title')
                && !target.hasClass('arrow')) {
            $('.pop').popover('destroy');      // 当点击body的非弹出框相关的内容的时候，关闭所有popover
        }
    });
    
    var gHideBigImg = false;  //是否在拖动过程,解决鼠标移动过程中不小心越界造成图片闪烁问题
	$('#imgc').hide();//初始化时隐藏验证码图片 
	//显示隐藏验证码图片
	$('#td').on({
		mouseenter: function() {
			if(!gVerifyBool){
				$('#imgc').show();
			}
		},
		mouseleave: function() {
			gHideBigImg == false ? $('#imgc').hide() : null;
		}
	});	
	
	//初始化页面后，第一次拖动滑块时调用
	$('#drag').on('mousedown',function(){
		$('#img').css('top',t+'px');
		gBgUrl = gBgUrl.replace('.html','');	
		if(gVFlag ==0){
			$('#imgc').css('backgroundImage',"url("+gBgUrl+")");
			gVFlag = 1;
		}
		$('#img').show();
		$('#verifyLabel').popover('destroy');//隐藏消息提示框
	});	
		
	$('#drag').draggable({ /*draggable:拖拽插件, draggable:jquery.ui*/
	      containment: 'parent',
		  start: function (){
			  gHideBigImg=true;
		  },
		  stop: function (){
			  gHideBigImg = false;
			  gHideBigImg == false ? $('#imgc').hide() : null;
			  var left = parseInt($('#img').css('left'));
			  var that  = $(this);
				 $.ajax({  
	 		         type:'post',      
	 		         url:checkVerify,  
	 		         data:{left:left},  
	 		         cache:false,  
	 		         dataType:'json',  
	 		         success:function(data){
	 		        	 var tipMsg = '';
	 	 		         if('0'==data['status']){
	 	 	 		       // $('#info').html(gStrVerifyImgSucc).show();
	 	 		        	//tipMsg = gStrVerifyImgSucc;
	 	 		        	$('#imgc').css('backgroundImage',"url(/images/d.png)");
	 	 		        	$('#img').hide();
	 	 		        	//that.data('udraggable').disable();
	 	 		        	that.draggable( "option", "disabled", false );
	 	 		        	gVerifyBool = true;
	 	 		        	$('#drag').css({'background-color':'green','cursor':'auto'});
	 	 	 	 		 }else{
	 	 	 	 			//$('#info').html(gStrVerifyImgFail).show();
	 	 	 	 			tipMsg = gStrVerifyImgFail;
	 	 	 	 			refreshImg();
	 	 	 				$('#verifyLabel').attr('data-content',tipMsg);
		 	 				$('#verifyLabel').popover({placement:'left', trigger:'click'});
		 	 				$('#verifyLabel').popover('show');
	 	 	 	 	 	 }	
	 		          }  
	 		 	 }); 		 
		  },
		  drag: function (e, ui) {
		    var pos = ui.position;
		    //console.log(pos.left, $('#img').width(),$(this).width());
		    if(parseInt(pos.left)>$('#td').width()-($('#img').width()-$(this).width())){
				return false;
			}
		    $('#img').css('left',pos.left);
		  }
	});
});
//刷新验证码操作
function refreshImg(){
	var date = new Date();
	var date = date.getTime();
	var gTempBgUrl = gBgUrl + '/t/'+date;
	$('#imgc').css('backgroundImage',"url("+gTempBgUrl+")");
	//$('#drag,#img').css('left','0px');
	$("#drag,#img").animate({ left: "0px"}, 1000, 'swing' );
	$('#drag').css({'background-color':'red','cursor':'pointer'});
	gVerifyBool = false;
}