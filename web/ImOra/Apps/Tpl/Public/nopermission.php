<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$T->title_no_permission_enter_orgdt}</title>
<style>
body,ul,ol,li,dl,dt,dd,p,h1,h2,h3,h4,h5,h6,form,fieldset,table,tr,td,img,div{margin:0;padding:0;border:0; float:none;}
body{font-size:12px;font-family:'微软雅黑','Tahoma','黑体','宋体';background:url(__PUBLIC__/images/body_repeat.png);}
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
.Nopermission_c{ width:420px; height:170px; margin:0 auto; padding-top:230px;}
.Nopermission_left{ width:56px; height:74px; float:left; margin-right:33px;}
.Nopermission_left img{width:56px; height:74px;}
.Nopermission_right{ width:330px; height:170px; float:left;}
.Nopermission_right span,.Nopermission_right i,.Nopermission_right em{ display:block;}
.Nopermission_right span{color:#fff; font:22px/22px "微软雅黑"; margin-bottom:14px;}
.Nopermission_right i{ color:#999; font:14px/14px "微软雅黑";}
.Nopermission_right em{ width:122px; height:32px; background:#666; margin-top:45px; color:#fff; font:14px/32px "微软雅黑"; text-align:center;-webkit-border-radius:2px 2px; -moz-border-radius:2px 2px; -o-border-radius:2px 2px; -ms-border-radius:2px 2px; border-radius:2px 2px;}
</style>
</head>

<body>
	<div class="Nopermission_all">
		<div class="Nopermission_content">
			<div class="Nopermission_c">
				<div class="Nopermission_left"><img src="__PUBLIC__/images/Error_bgicon.png" /></div>
				<div class="Nopermission_right">
					<span>{$T->str_no_permission_enter_the_opera}<!--非常抱歉，您无权进入此操作--></span>
					<i></i>
					<em onclick="javascript:window.location.href=document.referrer;" style="cursor:pointer;">{$T->btn_return}<!-- 返回 --></em>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<script type="text/javascript">
//自动跳转到首页
var rtnPage = '<?php echo $return;?>';
rtnPage=='1' ? setTimeout('jumpurl()',5000) : null;
function jumpurl(){
	window.location.href = "<?php echo U('Appadmin/Index/index');?>";
}
</script>
