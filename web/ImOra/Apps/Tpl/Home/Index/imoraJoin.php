<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>加入我们</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="__PUBLIC__/css/imora.cn/imoraJoin.css">
	<script src="__PUBLIC__/js/jquery/jquery.js"></script>
</head>
<body>
	<div class="warp">
		<!--  左侧导航  -->
		<div class="bg_op js_bg"></div>
		<nav class="js_nav m_menu">
			<a href="/"><h5>IMORA</h5></a>
			<ul>
				<li><a>登录</a></li>
				<li><a>注册</a></li>
			</ul>
		</nav>
		<div class="header">
			<div class="header_banner">
			<!-- web大图 -->
			 <img class="pc_img" src="__PUBLIC__/images/imora.cn/ban_join.jpg">
			 <!-- app大图 -->
			 <img class="app_img" src="__PUBLIC__/images/imora.cn/m_join.png">
			</div>
			<!--  pc  -->
			<div class="top">
				<div class="top_center">
					<div class="login">
				        <a href="/">
						<img src="__PUBLIC__/images/imora.cn/join_login1.png">
						</a>
					</div>
					<div class="login_box">
						<ul>
						 	<li><a href="">登录</a></li>
						 	<li><a href="">注册</a></li>
						 	<li><span class="country_icon"></span><em class="hand">中文</em>/<em class="hand">英文</em></li>
						</ul>
					</div>
					<!-- <div class="language"><span></span><em>中文</em>/<em>英文</em></div> -->
				</div>
			</div>
			<!--  mobile  -->
			<div class="m_top">
				<div class="m_ter">
					<span class="js_menu"></span>
				</div>
			</div>

		</div>
		<div class="hr_com">
			<h5>简历请投至hr@oradt.com</h5>
		</div>
		<div class="content_info">
			<div class="info_center">
               <foreach name="list" item="val">
				<div class="info_item">
                    <h2>岗位名称：{$val.title}</h2>
					<h5></h5>
                  	{$val.content}
				</div>
               </foreach>
			</div>
		</div>
		<div class="footer">
			<div class="footer_center">
				<div class="center_auto">
					<p>Copyright © 2016 IMORA Inc. 保留所有权利京公安网安备 11010500896 京ICP备10214630 </p>
					<div class="href_box">
						<a href=""><span class="span1"></span></a>
						<a href=""><span class="span2"></span></a>
						<a href=""><span class="span3"></span></a>
						<a href=""><span class="span4"></span></a>
					</div>
				</div>
			</div>
		</div>
	</div>
<script>
	//左侧导航
	$(".js_menu").on("click",function(){
		$(".js_nav").addClass("show_menu");
		$(".js_bg").css("display","block");
	});
	$(".js_bg").on("click",function(){
		$(".js_nav").removeClass("show_menu");
		$(this).css("display","none");
	});
</script>
</body>
</html>