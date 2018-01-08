    <?php 
	    //解决项目配置方法不同时找不到路径的问题
   	    /* $projectPath = '';
	    $path = $_SERVER['PHP_SELF'];
	    $pathArr = parse_url($path);
	     
	    if(($index = stripos($path,'/PUBLIC/')) !== false){
	    	$projectPath = substr($path, 0,$index+7);
	    }
	    $projectPath = 'http://'.$_SERVER['HTTP_HOST'].$projectPath; */
    ?>
    
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$T->title_page_not_found}</title>
<style>
body,ul,ol,li,dl,dt,dd,p,h1,h2,h3,h4,h5,h6,form,fieldset,table,tr,td,img,div{margin:0;padding:0;border:0; float:none;}
body{font-size:12px;font-family:'微软雅黑','Tahoma','黑体','宋体';background:url(<?php echo $projectPath;?>/images/body_repeat.png);}
body,html{min-width:1200px; height:100%;}
/*html,body{width:100%;}*/
ul,ol{list-style-type:none;}em,i,cite,u{font-style:normal;}
select,input{vertical-align:middle;}
img,embed{vertical-align:top;border:none;}
a{text-decoration:none;color:#666666; outline: medium none; font-family:'宋体';}
a:hover{color:#0075c2;text-decoration: none;}
.font{}
.left{ float:left}
.right{ float:right;}
.clear{ clear:both;}
textarea{overflow:auto;resize:none;}
.clear:after{clear:both;content:'';display:block}
.clear{zoon:1;}
.button_confirm{background: #ff6600 none repeat scroll 0 0;border: medium none;border-radius: 2px;color: #fff;float: left;font: 14px/40px "微软雅黑";margin-right: 8px;text-align: center;width: 140px;}
.button_concel{background: #666 none repeat scroll 0 0;border: medium none;border-radius: 2px;color: #fff;float: left;font: 14px/40px "微软雅黑";margin-right: 8px;text-align: center;width: 140px;}
.page_box .clsPrePage{cursor:pointer;}
.page_box .clsNextPage{cursor:pointer;}
.Nopermission_all{ width:100%; height:auto; overflow:hidden;}
.Nopermission_content{ width:1200px; height:600px; background:#000; margin:0 auto;  margin-top:200px;}
.Nopermission_c{ width:540px; height:246px; margin:0 auto; padding-top:140px;}
.Nopermission_left{ width:271px; height:246px; float:left; margin-right:33px;}
.Nopermission_left img{width:271px; height:246px;}
.Nopermission_right{ width:230px; height:170px; float:left; margin-top:88px;}
.Nopermission_right span,.Nopermission_right i,.Nopermission_right em{ display:block;}
.Nopermission_right span{color:#fff; font:22px/22px "微软雅黑"; margin-bottom:14px;}
.Nopermission_right i{ color:#999; font:14px/14px "微软雅黑";}
.Nopermission_right em{ width:122px; height:32px; background:#666; margin-top:45px; color:#fff; font:14px/32px "微软雅黑"; text-align:center;-webkit-border-radius:2px 2px; -moz-border-radius:2px 2px; -o-border-radius:2px 2px; -ms-border-radius:2px 2px; border-radius:2px 2px;}
.clickbin{cursor:pointer;}
</style>
<script src="__PUBLIC__/js/jquery/jquery.js"></script>
</head>

<body>
	<div class="Nopermission_all">
		<div class="Nopermission_content">
			<div class="Nopermission_c">
				<div class="Nopermission_left"><img src="__PUBLIC__/images/Error_Error404icon.png" /></div>
				<div class="Nopermission_right">
					<span>{$T->str_page_is_error}<!--哎呀呀，页面错误啦--></span>
					<i>{$T->str_please_check_your_input}<!--请检查输入的网址是否正确--></i>
					<em class="clickbin cls_page_return">{$T->btn_return}<!--返回--></em>
				</div>
			</div>
		</div>
	</div>
</body>
</html>

<script type="text/javascript">
	$(function(){
		$('.cls_page_refresh').click(function(){
			window.location.reload();
		});
		$('.cls_page_return').click(function(){
			window.history.back();
		});
	});
</script>