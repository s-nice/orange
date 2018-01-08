var gNum = 0;
function insertImg(list,len){
	var content=len,
	_margin=0,//2,
	 str="",
	imgNum=1,
	imgLen=list.length;
	_width=Math.floor(($(window).width()-3*_margin-4*2)/4);
	for(var i in list){
		var cardid= list[i].cardid;
		var pica = list[i].picture; //picpatha
		var m=_margin,
			newImg=new Image();
		if(i%4==0) m=0;
		gNum++;
		str+='<li data-pica="'+list[i].picpatha+'" data-batchid="'+
        list[i].batchid+'" data-name="'+gNum+'" data-cardid="'+
        cardid+'" class="animated zoomIn js_scanner_single" style="border:1px solid;width:'+
        _width+'px; height:'+_width*0.6+'px; margin-right:'+m+'px; margin-top:'+_margin+'px;">'+
        '<img src="'+pica+'" style="width:'+_width+'px;height:'+_width*0.6+'px;"/>'+'</li>';
	}
	$('.js_scanner_data').prepend(str);
	//图片数据量大于35张时，删除最先添加的图片,解决iso系统，加载图片刷新的问题
	if($('.js_scanner_data>li').size()>35){
		$('.js_scanner_data>li:gt(34)').remove();
	}
	//$('.js_scanner_data>.js_scanner_single:last').after(str);


}
function showImgCard(){
    //预览大图
    $(".js_scanner_data").on("tap","li",function(){
        var idx=$(this).attr("data-cardid");
        var picaurl=$(this).attr("data-pica");
        $("#showimg").attr("src",picaurl);
        $("#showimg").attr("data-num",idx);
        $(".js_large").show();
    });
    $(".js_container").on("swipeLeft",'.js_large',function(){
        var idx=$("#showimg").attr("data-num");
        var lastli = $('.js_scanner_data li').last().attr('data-cardid');
        if(idx==lastli){return false;}

        var imgdata = $('.js_scanner_data').find('li[data-cardid='+idx+']').next();

        //imgdata.attr('data-name')

        $("#showimg").attr("data-num",imgdata.attr('data-cardid'));
        $("#showimg").attr("src",imgdata.attr('data-pica'));
        $("#showimg").addClass('animated bounceInRight');
        $("#showimg").on("webkitAnimationEnd",function(){
            $("#showimg").removeClass("animated bounceInRight").off("webkitAnimationEnd");
        });
    });
    $(".js_container").on("swipeRight",'.js_large',function(){
        var idx=$("#showimg").attr("data-num");

        var firstli = $('.js_scanner_data li').first().attr('data-cardid');
        if(idx==firstli){return false;}

        var imgdata = $('.js_scanner_data').find('li[data-cardid='+idx+']').prev();

        //imgdata.attr('data-name')

        $("#showimg").attr("data-num",imgdata.attr('data-cardid'));
        $("#showimg").attr("src",imgdata.attr('data-pica'));
        $("#showimg").addClass('animated bounceInLeft');
        $("#showimg").on("webkitAnimationEnd",function(){
            $("#showimg").removeClass("animated bounceInLeft").off("webkitAnimationEnd");
        });

    });
    $(".js_large").on("tap",function(){
        $(this).hide();
    });
}
;(function($){
/*	var content=15,
		_margin=2,
		str="",
		imgNum=1,
		_width=Math.floor(($(window).width()-3*_margin)/4);
	for(var i=1; i<=content; i++){
		var m=_margin,
			newImg=new Image();
		if(i%4==0) m=0;
		str+="<li data-name='"+i+"' class='animated zoomIn' style='width:"+_width+"px; height:"+_width+"px; margin-right:"+m+"px; margin-top:"+_margin+"px;'>"+
			"<canvas id='cvs"+i+"'>此浏览器不支持canvas画布</canvas>"
			+"</li>";
		(function(i){
			newImg.onload=function(){
				var cvs=document.getElementById("cvs"+i),
					cxt=cvs.getContext("2d"),
					w=_width-this.width/2;
					cxt.drawImage(this,w,0,this.width,this.height);
			}
		})(i);
		newImg.src="images/"+i+".jpg";
	}
	$("#small").html(str);*/
/*	$("#small").on("tap","li",function(){
		var imgName=imgNum=$(this).data("name");
		loardimg(imgName);
	})
	$("#large").on("click",function(){
		$(this).hide();
	})
	.on("swipeLeft",function(){
		imgNum++;
		if(imgNum>content) imgNum=content;
		loardimg(imgNum,function(){
				$("#showimg").addClass("animated bounceInRight")
				$("#showimg").on("webkitAnimationEnd",function(){
				$(this).removeClass("animated bounceInRight").off("webkitAnimationEnd");
			})
		});
		
	})
	.on("swipeRight",function(){
		imgNum--;
		if(imgNum<1) imgNum=1;
		loardimg(imgNum,function(){
				$("#showimg").addClass("animated bounceInLeft")
				$("#showimg").on("webkitAnimationEnd",function(){
				$(this).removeClass("animated bounceInLeft").off("webkitAnimationEnd");
			})
		});
		
	})
	function loardimg(imgName,callback){
		//显示大图
		$("#large").show();
		//显示大图片
		$("#showimg").attr({src:'images/'+imgName+'.large.jpg'});
		var bigImg=new Image();
		bigImg.onload=function(){
			var iW=this.width,
				iH=this.height;
			var wW=$(window).width(),
				wH=$(window).height();
			if(iW>iH){//横图
				var scaleH=wW/iW;
				$("#showimg").css({
					"width":"100%",
					"height":iH*scaleH+"px",
					"margin-top":(wH-iH*scaleH)/2+"px",
					"margin-left":0
				})
			}else{//纵图
				var scaleW=wH/iH;
				$("#showimg").css({
					"width":scaleW*iW+"px",
					"height":"100%",
					"margin-left":(wW-scaleW*iW)/2+"px",
					"margin-top":0
				})
			}
		}
		bigImg.src="images/"+imgName+".large.jpg";
		callback&&callback();
	}*/
})(Zepto)