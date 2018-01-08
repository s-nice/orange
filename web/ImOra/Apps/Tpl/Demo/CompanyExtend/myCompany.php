<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>我的企业</title>
	<script src="__PUBLIC__/js/oradt/H5/fontSize.js"></script>
	<link rel="stylesheet" href="__PUBLIC__/css/detailOra.css" />
	<style>
		html,body{
			background-color:#fff;
		}
	</style>
</head>
<body>
	<div class="c-main">
		<section class="c-content">
			<div class="c-qure" bizid="{$bizid}" openid="{$openid}">
                <p>公司名称：{$bizname}</p>
				<img src="{:U('CompanyExtend/entQrCode')}" alt="">
				<p>邀请同事，长按二维码保存或分享</p>
			</div>
			<div class="c-btn">
				<button type="button" class="ensure">退出公司并申请新的企业账号</button>
			</div>
		</section>
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
                var openid = $('.c-qure').attr('openid');
                var bizid = $('.c-qure').attr('bizid');
                $.post(unbindUrl,{openid:openid,bindedId:bizid,bizId:bizid},function(res){
                    if(res.status===0){
                        alert('解绑成功');
                        WeixinJSBridge.call('closeWindow');
//                        window.location.href = bindUrl;
                    }else if(res.status===1){
                        alert(res.msg);
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