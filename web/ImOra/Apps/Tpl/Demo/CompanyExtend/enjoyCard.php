<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>批量分享</title>
	<script src="__PUBLIC__/js/oradt/H5/fontSize.js"></script>
	<link rel="stylesheet" href="__PUBLIC__/css/detailOra.css" />
	<link rel="stylesheet" href="__PUBLIC__/css/wePage.css?v={:C('WECHAT_APP_VERSION')}" />
	<style>
		html,body{
			background-color:#1d212c;
		}
        .selected-card{
            float: right;
        }
        .selected-card i{
            font-style:normal;
        }
	</style>
</head>
<body>
	<div class="joy-mian">
		<section class="joy-content">
			<header class="head-search">
				<div class="sea-i">
					<div class="sea-input">
                        <form action="{:U('batchShareCard')}" id="searchFrom" method="post">
                            <input type="text" name="keyword" placeholder="{$T->str_g_list_search}（{$datanumber}{$T->str_g_list_search_unit}）" data-totalcard="{$datanumber}" value="{$keyword}">
                            <input type="hidden" name="isSearch" value="{$search}">
                        </form>
						<span class="sea-btn" id="sub_search">
							<img src="__PUBLIC__/images/wei/s-search.png" alt="">
						</span>
					</div>
                    <if condition="$list">
                        <div class="joy-all">
                            <label for=""><input type="checkbox" name="checkall"><em></em></label><span>全选</span>
                            <span class="selected-card">已选中<i>0</i>张</span>
                        </div>
                    </if>

				</div>
			</header>
			<div class="joy-card-list">
				<ul class="list-cadrs" id="list" currentPage="{$currentPage}" >
                    <if condition="$list">
                        <foreach name='list' item='v' >
                        <li>
                            <img src="{$v.picpatha}" src-pica="{$v.picpatha}" alt="">
                            <label for=""><input type="checkbox" value="{$v.cardid}"><em></em></label>
                        </li>
                        </foreach>
                    <elseif condition="$datanumber heq 0"/>
                        <p style="color: #fff;margin-top: 1rem;text-align: center;">没有可分享的名片</p>
                    <else/>
                        <p style="color: #fff;margin-top: 1rem;text-align: center;">未查到相关名片</p>
                    </if>
				</ul>
			</div>
		</section>
		<footer class="joy-foot">
			<button type="button" id="batchShare">分享名片到企业</button>
		</footer>
	</div>
	<!--  成功弹框  -->
    <div class="pull_file">
        <div class="dia_w dia-line">
            <img src="__PUBLIC__/images/wei/sucess_icon.png" alt="">
            分享成功
          </div>
    </div>
      <!-- 失败弹框  -->
    <div class="dia_error">
        <div class="error_w">
            <img src="__PUBLIC__/images/wei/error_icon.png" alt="">
            分享失败
            <p style="width: 80%;line-height: .2rem;margin: .08rem auto 0"></p>
        </div>
    </div>
    <!-- 失败弹框  -->
<!--    <div class="dia_error" style="display: block;">-->
<!--        <div class="error_w">-->
<!--            <img src="__PUBLIC__/images/wei/error_icon.png" alt="">-->
<!--            分享失败-->
<!--            <p style="width: 80%;line-height: .2rem;margin: .08rem auto 0">您已绑定企业</p>-->
<!--        </div>-->
<!--    </div>-->
    <script>
        var batchShareUrl = '{:U("Wechat/batchShareCardHandle")}'
        var ajaxGetCardUrl = '{:U("Wechat/ajaxGetCards")}'
    </script>
    <script src="__PUBLIC__/js/jquery/zepto.min.js?v={:C('WECHAT_APP_VERSION')}"></script>
    <script>
        $(function(){
            //全选按钮
            $('input[name=checkall]').on('click',function(){
                $('#list li>label>input').prop('checked',$(this).prop('checked'));
                countNum();
            })
            $('#list').on('click','li',function(){
                var checked = $(this).find('input').prop('checked');
//                alert(checked);
                $(this).find('input').prop('checked',!checked)
                countNum();
            })
            $('#list').on('click','li input',function(){
                var checked = $(this).prop('checked');
//                alert(checked);
                $(this).prop('checked',!checked)
                countNum();
            })
            //执行分享操作
            $('#batchShare').on('click',function(){
                var arr = getCardIds($('#list li>label>input:checked'));
                if(arr.length===0){
                    return;
                }
                $.post(batchShareUrl,{cardid:arr},function(res){
//                    console.log(res);
                    if(res.status===0){
                        $('.pull_file').show();
                        setTimeout(function () {
                            $('.pull_file').fadeOut();
                        },2000)
                        setTimeout(function(){
                            location.reload();
                        },2500)
                    }
                    else if(res.status===1){
                        $('.error_w p').text(res.msg);
                        $('.dia_error').show();
                        setTimeout(function () {
                            $('.dia_error').fadeOut();
                        },2000)}

                    else{
                        $('.dia_error').show();
                        setTimeout(function () {
                            $('.dia_error').fadeOut();
                        },2000)
                    }
                },'json')
            })
            //获取已选中名片张数
            function countNum(){
                $('.selected-card i').text($('#list input:checked').length);
//                console.log($('#list input:checked').length)
            }
            //点击搜索
            $('#sub_search').on('click',function(){
                var keyword = $('input[name=keyword]').val();
                if(keyword!=''){
                    $('#searchFrom').submit();
                }
            })
            //获得要分享名片数组
            function getCardIds(elems){
                var res = [];
                for(var i=0;i<elems.length;i++){
                    res.push(elems[i].value)
                }
                return res;
            }
            //向上滑动加载名片
            $('.joy-card-list').on('swipeUp',function(){
                var  current = $('.list-cadrs').attr('currentPage');
                var keyword = $('input[name=keyword]').val();
                var search = $('input[name=isSearch]').val();
                $.post(ajaxGetCardUrl,{current:current,keyword:keyword,search:search},function(res){
                    if(res.status===0){
                        $('.list-cadrs').attr('currentPage',res.current)
//                        alert(res.html)
                        $('.list-cadrs').append(res.html);
                    }
                },'json')
            })
        })
    </script>
</body>
</html>