<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<title>扫描其他</title>
		<link rel="stylesheet" href="__PUBLIC__/css/swiper.min.css?v={:C('WECHAT_APP_VERSION')}">
		<link rel="stylesheet" href="__PUBLIC__/css/wList.css?v={:C('WECHAT_APP_VERSION')}">
		<style>
			html,body{
				width:100%;
				height:100%;
				background:#f8f8f8;
				overflow:hidden;
			}
			.card-list ul li{position:relative;}
			.card-list ul li span{position:absolute;right:10px;top:10px;padding:6px 10px;background:#ea9566;color:#fff;font-size:14px;}
			.nav-list ul li a.on {
			    color: #666;
			    border-bottom: 2px solid #ea9566;
			}
		</style>
	</head>
	<body>
		<div class="cards">
			<header class="nav-head">
				<div class="filter-warmper">
					<div class="nav-list swiper-container swiper-container-horizontal swiper-container-free-mode">
						<ul class="swiper-wrapper">
							<li class="swiper-slide">
								<a class="on js_top_menu" p="1" data-id="0">{$tag}</a>
							</li>
						</ul>
					</div>
				</div>
			</header>
			<section class="card-list js_div_data">
				<ul class="js_ul_data">
				<empty  name="list">
					<center style="backgroup-color:blue;">没有数据</center>
				<else/>
					<foreach name="list" item="vo" key='k'>
						<li class="js_li"><img class="js_img_ori" src="{$vo.picturea}" alt="" /><if condition="($vo['batchid'] eq $batchid) and $batchid"><span>新</span></if></li>
					</foreach>
				</empty>
				</ul>
			</section>
			<!--  显示大图  -->
			<div class="show_img">
				<img src="images/d_card.png" class="js_img_big" alt="" />
			</div>
		</div>
		<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}&t=<?php time();?>"></script>
		<script src="__PUBLIC__/js/jquery/swiper.min.js?v={:C('WECHAT_APP_VERSION')}"></script>
		<script>
		  var url = "{:U(MODULE_NAME.'/ConnectScanner/showCardByTag','','',true)}";
			 var swiper = new Swiper('.swiper-container', {
		        pagination: '.swiper-pagination',
		        slidesPerView: 'auto',
		        paginationClickable: true,
		        spaceBetween: 6
		    });
				var totalPage = "{$totalPage}";
				var isLoading = false;
				var p = 1;
				var batchid = "{$batchid}";
				var type = "{$type}";
			$(function(){
				
 				$('.js_img_big').parent().click(function(){
 					$('.js_img_big').parent().hide();
				}); 
 				bindEvt();
			});

			function bindEvt(){
				$('.js_img_ori').off('click').on('click',function(){
					var url = $(this).attr('src');
					//console.log($(this),url)
					$('.js_img_big').attr('src',url);
					$('.js_img_big').parent().show();
				});
			}
            //下滑触动滚动分页
 		    $('.js_div_data').scroll(function(){  
 		    	if(isLoading) return;
		      		//console.log($(".js_ul_data").height() +'='+ $(".js_div_data").scrollTop() +' ##'+$('.js_div_data').height())
		            if (($(".js_ul_data").height() - $(".js_div_data").scrollTop()) <= $('.js_div_data').height()) {  
		            	ajaxPage();
		            }  
		    });   

  		   //滚动加载分页
			function ajaxPage(){
				if(p < totalPage){
					isLoading = true;
					var data = {type:type,p:++p,batchid:batchid};
					$.ajax({
						type: "GET",
		             	url: url,
		             	data: data,
		             	dataType: "json",
						success:function(rs){
							var html = '';
							for (var i = 0; i < rs.data.length; i++) { 
								var obj = rs['data'][i];
								html +="<li ><img class='js_img_ori' src='"+obj.picturea+"' />";
								if(obj.batchid==batchid){
									html += "<span>新</span>";
								}
								html +="</li>";
							}
							$(".js_ul_data").append(html);
							bindEvt();
							isLoading=false;
						}
					});
				}else{
					//$(".page__bd").hide();
					isLoading = false;
				}
			}
		</script>
	</body>
</html>
