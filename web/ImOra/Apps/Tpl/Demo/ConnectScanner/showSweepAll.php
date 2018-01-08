<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<title>{$T->str_scannerall_title}</title>
		<link rel="stylesheet" href="__PUBLIC__/css/swiper.min.css?v={:C('WECHAT_APP_VERSION')}">
        <link rel="stylesheet" href="__PUBLIC__/css/weui.min.css?v={:C('WECHAT_APP_VERSION')}">
		<link rel="stylesheet" href="__PUBLIC__/css/wList.css?v={:C('WECHAT_APP_VERSION')}">
        <link rel="stylesheet" href="__PUBLIC__/js/jsExtend/autocomplete/jquery-ui.css?v={:C('WECHAT_APP_VERSION')}">
		<style>
			html,body{
				width:100%;
				height:100%;
				background:#f8f8f8;
				overflow:hidden;
			}

		</style>
        <style>
            .ui-autocomplete {
                max-height: 200px;
                overflow-y: auto;
                /* 防止水平滚动条 */
                overflow-x: hidden;
            }
            /* IE 6 不支持 max-height
             * 我们使用 height 代替，但是这会强制菜单总是显示为那个高度
             */
            * html .ui-autocomplete {
                height: 200px;
            }
            #alls{ position: relative;}
        </style>
        <script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}&t=<?php time();?>"></script>
        <script type="text/javascript" src='http://res.wx.qq.com/open/js/jweixin-1.2.0.js?v={:C('WECHAT_APP_VERSION')}'></script>
        <script type="text/javascript">
            $(window).load(function(){
                waterfall();
                $(window).scroll(function(){
                    if(checkScollSlide('alls','js_li')){
                        //waterfall();
                    }
                })
            })
            function waterfall(){
                var $boxs=$("#alls>li");
                var w=$boxs.eq(0).outerWidth();
                var cols=Math.floor($(window).width()/w);
                $('#all').width(w*cols).css("margin","0 auto");
                var hArr=[];
                $boxs.each(function(index,value){
                    var h=$boxs.eq(index).outerHeight();
                    if(index<cols){
                        hArr[index]=h;
                    }else{
                        var minH=Math.min.apply(null,hArr);
                        var minHIndex=$.inArray(minH,hArr);
                        $(value).css({
                            'position':'absolute',
                            'top':minH+'px',
                            'left':minHIndex*w+'px'
                        })
                        hArr[minHIndex]+=$boxs.eq(index).outerHeight();
                    }
                });
            }

            function checkScollSlide(parent,clsName){
                var oParent = document.getElementById(parent),
                    aBoxArr = oParent.getElementsByClassName(clsName),
                // 最后一个box元素的offsetTop+高度的一半
                    lastBoxH = aBoxArr[aBoxArr.length - 1].offsetTop + aBoxArr[aBoxArr.length - 1].offsetHeight / 2,
                //兼容js标准模式和混杂模式
                    scrollTop = document.documentElement.scrollTop || document.body.scrollTop,
                    height = document.documentElement.clientHeight || document.body.clientHeight;
                return lastBoxH < scrollTop + height ? true : false;
            }

            wx.ready(function(){
                testVoice();
            });
        </script>
	</head>
	<body>
		<div class="cards" id="outdiv">
			<header class="nav-head js_header_height" <notempty name="cataSet"> style="height:96px;"</notempty> >
                <div class="search_top" style="position: inherit;">
                    <div class="search_text">
                        <div class="search_box">
                            <input id='search' placeholder="{$T->str_g_list_search}" data-totalcard="{$datanumber}" value="{$keyword}" type="text" style="font-size:14px;">
                            <input id="weixinVoiceTime" type="hidden" value=""/>
                            <input id="weixinVoiceTime2" type="hidden" value=""/>
                            <span class="js_x_btn remove"><img src="__PUBLIC__/images/wclose.png"></span>
                        </div>
                        <button class="weui-btn weui-btn_primary" id="searchBtn">{$T->str_g_list_search}</button> <!-- -->
                    </div>
                </div>
                <notempty name="cataSet">
				<div class="filter-warmper js_tag_list" >
					<div class="nav-list swiper-container swiper-container-horizontal swiper-container-free-mode">
						<ul class="swiper-wrapper">
                            <foreach name="cataSet" item="vo">
                                <li class="swiper-slide">
                                    <a class="js_top_menu on" data-val="{$vo}" p="0" >{$vo}</a>
                                </li>
                            </foreach>
						</ul>
					</div>
				</div>
                </notempty>
			</header>
			<section class="card-list js_div_data" id="js_divdatalist">
				<ul class="js_ul_data" id="alls">
				<empty  name="list">
					<center style="backgroup-color:blue;">{$T->str_scannerall_nodata}</center>
				<else/>
					<foreach name="list" item="vo" key='k'>
						<li class="js_li" style="height:auto;" src-pica="{$vo.picturea}" src-picb="{$vo.pictureb}"><img class="js_img_ori" <if condition="$vo['isfb'] eq 'front' or $vo['isfb'] eq 'a'"> src="{$vo.picturea}"<else/> src="{$vo.pictureb}" </if>  /><if condition="($vo['batchid'] eq $batchid) and $batchid"><span>{$T->str_scannerall_new}</span></if></li>
					</foreach>
				</empty>
				</ul>
			</section>
			<!--  显示大图   -->
			<div class="show_img">
				<img src="" class="js_img_big" alt="" />
			</div>
			<footer class="pay_btn pay_btn_bg">
                <if condition="$userAgent eq 'weixin'">
                    <button id="voiceIdcontroller" type="button" class="b_sound" >
                        <div class="sound_btn">
                            <span><b></b><!-- <img src="__PUBLIC__/images/wei/iconVoice@3x.png" > --></span>
                            <em style="font-size:14px;">{$T->str_g_list_btn_say}</em>
                        </div>
                    </button>
                    <div class="sound_trim"></div>
                    <!-- 录音弹框 -->
                    <div id="js_load_img" style="opacity:1;display:none;">
                        <div class="weui-mask_transparent"></div>
                        <div class="weui-toast">
                            <i class="weui-loading weui-icon_toast"></i>
                            <p class="weui-toast__content js_tip_text" style="font-size:14px;"></p>
                        </div>
                    </div>
                </if>
      		</footer>
            <input id="openid" name="openid" value="{$openid}" type="hidden"/>
            <input id="totalPage" name="totalPage" value="{$totalPage}" type="hidden"/>
            <input id="currPage" name="currPage" value="{$currPage}" type="hidden"/>
            <input id="rows" name="rows" value="{$rows}" type="hidden"/>
		</div>
		<script src="__PUBLIC__/js/jquery/swiper.min.js?v={:C('WECHAT_APP_VERSION')}"></script>
        <script src="__PUBLIC__/js/jsExtend/autocomplete/jquery-ui.js?v={:C('WECHAT_APP_VERSION')}"></script>
		<script>
		    var url = "{:U(MODULE_NAME.'/ConnectScanner/showSweepMore','','',true)}";
            var js_url_autocomplete = "{:U(MODULE_NAME.'/ConnectScanner/autocompleteWord','','',true)}";
            var gVcardListUrl = "{:U(MODULE_NAME.'/ConnectScanner/showSweepAll','','',true)}";
            var gVcardListSearchUrl = "{:U(MODULE_NAME.'/ConnectScanner/showSweepAll',array('keyword'=>$keyword),'',true)}";

            var js_trans_str_g_list_putcontent_search = "{$T->str_g_list_putcontent_search}";

            var js_trans_search = "{$T->str_g_list_search}";
            var js_trans_search_unit = "{$T->str_g_list_search_unit}";
            var js_trans_delete_faild = "{$T->str_g_list_delete_faild}";
            var js_trans_str_g_list_btn_say = "{$T->str_g_list_btn_say}";
            var js_trans_str_g_list_up_search = "{$T->str_g_list_up_search}";
            var js_trans_str_g_list_inrecording = "{$T->str_g_list_inrecording}";
            var js_trans_str_g_list_user_denyrecording = "{$T->str_g_list_user_denyrecording}";
            var js_trans_str_g_list_recognition_failure = "{$T->str_g_list_recognition_failure}";
            var js_trans_str_g_list_record_short = "{$T->str_g_list_record_short}";
            var js_trans_str_g_list_putcontent_search = "{$T->str_g_list_putcontent_search}";
            var js_trans_str_g_list_place_friends = "{$T->str_g_list_place_friends}";

            var availableTags = [
                "ActionScript",
                "AppleScript",
                "Asp",
                "BASIC",
                "C",
                "C++",
                "Clojure",
                "COBOL"
            ];
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
                $(document).on('keydown',function(event){
                    var e = event || window.event;
                    if(e.keyCode ==13){
                        ajaxGetData();
                    }
                });
                $(".js_ul_data").on('click','.js_li',function(){
                    var imgurl = $(this).find('img').attr('src');
                    var imglist = [];
                    imglist[0] = $(this).attr('src-pica');
                    imglist[1] = $(this).attr('src-picb');
                    wx.previewImage({
                        current: imgurl,
                        urls: imglist
                    });
                });
                autoselect();
                $('#search').on('keyup',function(){
                    var searchword = $(this).val();
                    $.ajax({
                        url:js_url_autocomplete,
                        async:false,//同步
                        type:'post',
                        data:'searchword='+searchword,
                        success:function(res){
                            availableTags = res;
                        },
                        fail:function(err){
                            return false;
                        }
                    });
                    autoselect();

                });
                if($('#search').val()!=''){
                    $('.js_x_btn').show();
                    $('.js_tag_list').show();

                }
				//label切换
				$('.js_top_menu').click(function(){
                    var kword = $('#search').val();
                    var newkey = $(this).attr('data-val');
                    kword += ' '+newkey;
                    ajaxGetData(kword);
				});
                //图片预览
 				/*$('.js_img_big').parent().click(function(){
 					$('.js_img_big').parent().hide();
				});
 				bindEvt();*/
			});
            function autoselect(){
                $( "#search" ).autocomplete({
                    source: availableTags,
                    select: function( event, ui ) {
                        $('#search').val(ui.item.value);
                        return false;
                    }
                });
            }

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
								html +="<li class='js_li pull-i' style='height:auto;' src-pica='"+obj.picturea+"' src-picb='"+obj.pictureb+"'><img class='js_img_ori' src='";
                                if(obj.isfb==undefined || obj.isfb=='front' || obj.isfb=='a'){
                                    html +=obj.picturea+"' />";
                                }else{
                                    html +=obj.pictureb+"' />";
                                }

								if(obj.batchid==batchid){
									html += "<span>新</span>";
								}
								html +="</li>";
							}
							$(".js_ul_data").append(html);
                            try{
                                //clearTimeout(times);
                                if(waterfall&&typeof(waterfall)=="function"){
                                    var times = setTimeout( waterfall(), 7000 );
                                }
                                if(waterfall&&typeof(waterfall)=="function"){
                                    times = setTimeout( waterfall(), 7000 );
                                }
                            }catch(e){}

							//bindEvt();
							isLoading=false;
						}
					});
				}else{
					isLoading = false;
				}
			}

            wx.config({
                debug: false,
                appId: "{$signPackage['appId']}",
                timestamp: "{$signPackage['timestamp']}",
                nonceStr: "{$signPackage['nonceStr']}",
                signature: "{$signPackage['signature']}",
                jsApiList: ['chooseImage', 'uploadImage','stopRecord','pauseVoice','onVoicePlayEnd','onVoiceRecordEnd','playVoice','translateVoice']
            });

		</script>
	</body>
</html>
<script src="__PUBLIC__/js/oradt/voicedemo.js?v={:C('WECHAT_APP_VERSION')}&t=<?php echo time();?>"></script>
