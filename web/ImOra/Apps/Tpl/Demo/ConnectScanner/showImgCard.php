<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<title>最新名片</title>
	<link rel="stylesheet" href="__PUBLIC__/css/wList.css?v={:C('WECHAT_APP_VERSION')}">
	<style>
		html,body{
			width:100%;height:100%;
			overflow: hidden;
		}
		body{
			background:#000;
		}
	</style>
</head>
<body>
	<ul class="small" id="small">
	</ul>
	<div class="large" id="large">
		<img id="showimg" src="images/1.large.jpg">
	</div>

	<script src="__PUBLIC__/js/jquery/zepto.min.js?v={:C('WECHAT_APP_VERSION')}"></script>
	<script>
		;(function($){
			var content=15,
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
			$("#small").html(str);
			$("#small").on("tap","li",function(){
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
			}
		})(Zepto)
	</script>
</body>
</html>