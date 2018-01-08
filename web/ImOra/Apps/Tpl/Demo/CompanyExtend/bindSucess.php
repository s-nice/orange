<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>申请结果</title>
	<script src="__PUBLIC__/js/oradt/H5/fontSize.js"></script>
	<link rel="stylesheet" href="__PUBLIC__/css/detailOra.css" />
	<style>
		html,body{
			background-color:#fff;
		}
        .su-btn button {
            width: 45%;
            height: .35rem;
            background-color: #ffa764;
            border: none;
            font-size: .12rem;
            border-radius: .5rem;
            color: #fff;
            float: left;
        }
        .news-auto {
            width: 80%;
            margin: 0 auto;
        }
	</style>
</head>
<body>
	<section class="mian-news">
		<div class="sucess-top">
			<img src="__PUBLIC__/images/wei/right-news.png" alt="">
			<h5>账号申请成功</h5>
		</div>
		<div class="er-item">
			<p>您的企业版账号已成功生成，点击长按右侧二维码进行保存或分享，邀请您的同事加入企业</p>
			<img src="{:U('CompanyExtend/entQrCode')}" alt="">
		</div>
		<div class="news-auto">
			<div class="su-btn">
				<button type="button" class="tomybiz" style="margin-right: 9.5%;">进入我的企业</button>
				<button type="button" class="success">完成</button>
			</div>
		</div>
	</section>
    <script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}&t=<?php time();?>"></script>
    <script src="__PUBLIC__/js/jsExtend/jquery.cookie.js"></script>
    <script src="__PUBLIC__/js/jsExtend/jquery.validate.min.js"></script>
    <script src="__PUBLIC__/js/jsExtend/additional-methods.js"></script>
    <script>
        $('.tomybiz').on('click',function(){
            window.location.href = '{:U("companyExtend/register")}';
        })
        $('.success').on('click',function(){
            window.location.href = '{:U("ConnectScanner/href")}';
        })
    </script>
</body>
</html>