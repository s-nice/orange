4pfd!cs3$,D8<!DOCTYPE html>
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
			.card-list ul li span{position:absolute;right:10px;top:10px;padding:6px 10px;background:#62b651;color:#fff;font-size:14px;}
		</style>
	</head>
	<body>
		<div class="cards">
			<header class="nav-head">
				<div class="filter-warmper">
					<div class="nav-list swiper-container swiper-container-horizontal swiper-container-free-mode">
						<ul class="swiper-wrapper">
							<li class="swiper-slide">
								<a class="on js_top_menu" p="1" data-id="0">最近</a>
							</li>
						<foreach name="cataSet" item="vo" key='k'>
							<li class="swiper-slide">
								<a class="js_top_menu" p="0"  data-id="{$vo.id}">{$vo.tag}</a>
							</li>
						</foreach>

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
						<li class="js_li"><img class="js_img_ori" src="{$vo.picture}" alt="" /><if condition="($vo['batchid'] eq $batchid) and $batchid"><span>新</span></if></li>
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
		  var url = "{:U(MODULE_NAME.'/ConnectScanner/showScanAll','','',true)}";
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
			$(function(){
				//顶部菜单栏切换功能
				$('.js_top_menu').click(function(){
					if($(this).hasClass('on')){
						return;
					}
					p = 0;
					var thisObj = $(this);
					var id = $(this).attr('data-id');
					var data = {catagoryid:id};
					$.get(url,data,function(res){
						thisObj.parent().siblings().find('.js_top_menu').removeClass('on');
						thisObj.addClass('on');
						$(".js_ul_data").children().remove();
						ajaxPage();
					},'json');
				});
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
					var catagoryId = $('.js_top_menu').filter('.on').attr('data-id');
					var data = {catagoryId:catagoryId,p:++p};
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
