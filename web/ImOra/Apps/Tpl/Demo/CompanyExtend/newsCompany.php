<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title></title>
	<script src="__PUBLIC__/js/oradt/H5/fontSize.js"></script>
	<link rel="stylesheet" href="__PUBLIC__/css/detailOra.css" />
	<style>
		html,body{
			background-color:#fff;
		}
	</style>
</head>
<body>
	<section class="mian-news">
		<div class="news-auto" bizid="{$bizid}" openid="{$openid}">
			<p class="news-p">您已加入{$bizName}，是否退出此公司并创建一个新的公司账号？</p>
			<div class="news-btn">
				<button class="btns ora-bg ensure" type="button">确定</button>
				<button class="btns ora-cancell-bg cancel" type="button">取消</button>
			</div>
		</div>

		<!--弹框-->
		<div class="news-dialog">
			<div class="dialog-box">
				<div class="dia-text">
					<h5>您确定要退出该公司吗？</h5>
					<p>退出后再次加入该公司需要重新申请</p>
				</div>
				<div class="dia-btn">
					<button type="button" class="dialog-cancel">取消</button>
					<button type="button" class="unbind">确定</button>
				</div>
			</div>
		</div>
	</section>
    <script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}&t=<?php time();?>"></script>
    <script>
        var unbindUrl = '{:U("ajaxUnBind")}';
        var bindUrl = '{:U("register")}';
        $(function(){
            $('.ensure').on('click',function(){
                $('.news-dialog').show();
            })
            $('.cancel').on('click',function(){
                window.history.back()
            })
            $('.unbind').on('click',function(){
                var openid = $('.news-auto').attr('openid');
                var bizid = $('.news-auto').attr('bizid');
                $.post(unbindUrl,{openid:openid,bindedId:bizid,bizId:bizid},function(res){
                    if(res.status===0){
                        alert('解绑成功');
                        window.location.href = bindUrl;
                    }
                },'json')
                $('.news-dialog').hide();
            })
            $('.dialog-cancel').on('click',function(){
                $('.news-dialog').hide();
            })
        })

    </script>
</body>
</html>