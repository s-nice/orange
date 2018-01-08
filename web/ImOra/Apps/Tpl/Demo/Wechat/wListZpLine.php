<!DOCTYPE html>
<html lang="en" style=" width:100%;height:100%;overflow:hidden;">
<head>
	<meta charset="UTF-8">
	<!-- uc强制竖屏 -->
	<meta name="screen-orientation" content="portrait">
	<!-- QQ强制竖屏  -->
	<meta name="x5-orientation" content="portrait">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<title>名片搜索line</title>
	<link rel="stylesheet" href="__PUBLIC__/css/font-awesome/font-awesome.min.css?v={:C('WECHAT_APP_VERSION')}">
	<link rel="stylesheet" href="__PUBLIC__/css/swiper.min.css?v={:C('WECHAT_APP_VERSION')}">
	<link rel="stylesheet" href="__PUBLIC__/css/weui.min.css?v={:C('WECHAT_APP_VERSION')}">
	<link rel="stylesheet" href="__PUBLIC__/css/wList.css?v={:C('WECHAT_APP_VERSION')}">
	<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}&t=<?php time();?>"></script>
</head>
<body style="width:100%;height:100%;overflow:hidden;">
	<div class="warmp" id="outdiv">
		<div class="nav-trim-top"></div>
		<div class="search_top">
			<div class="search_text">
  				<div class="search_box">
            <input id='search' placeholder="搜索（{$datanumber}张名片）" data-totalcard="{$datanumber}" value="{$keyword}" type="text" style="font-size:14px;">
            <input id="weixinVoiceTime" type="hidden" value=""/>
             <input id="weixinVoiceTime2" type="hidden" value=""/>
            <span class="js_x_btn remove"><img src="__PUBLIC__/images/wclose.png"></span>
          </div>
          <button class="weui-btn weui-btn_primary" id="searchBtn">搜索</button> <!-- -->
			</div>
		</div>
		<div class="imgs">
        <div class="content_img swiper-container swiper-container-horizontal swiper-container-3d swiper-container-coverflow js_out_div js_page_numb" data-pagenumb="1">
				<ul class="swiper-wrapper js_list" id="js_scroll">
	                <foreach name='list' item='v' >
	                    <li t1="{$v['isfb']}" class="swiper-slide js_li" style="z-index:1;" data-id="{$v.cardid}" frontUrl="{:U('Demo/Wechat/wDetailZp')}?cardid={$v.cardid}&kwd={:urlencode($keyword)}" backUrl="{:U('Demo/Wechat/detailBack')}?cardid={$v.cardid}&kwd={:urlencode($keyword)}">
	                        <php>
	                        	if($v['isfb'] == 'front'){
	                        </php>
                            	<a href="{:U('Demo/Wechat/wDetailZp')}?cardid={$v.cardid}&kwd={:urlencode($keyword)}&wechatid={$openid}" id="jsDetailId" dd='a'>
                            		<img  currPage="{$currPage}" currIndex="{$key+1}" class="js_img swiper-lazy" data-src="{$v.picpatha}" src-pica="{$v.picture}" src-picb="{$v.picpathb}" side="b" border="0" >
                                	<if condition="$openid eq 'ofIP5vnuTl1UTMpiIu3pO4_mRQ90' OR $openid eq 'ofIP5vg37cRsChKZJweO8lqgk79o' OR $openid eq 'ofIP5vmqP8pfq574aUmTLQtfG2NY'"><em>{$v.cardid}&nbsp;{$currPage}</em></if>
                                	<div class="swiper-lazy-preloader"></div>
                           		</a>
                           	 <php>}else{</php>
                            	<a href="{:U('Demo/Wechat/detailBack')}?cardid={$v.cardid}&kwd={:urlencode($keyword)}&wechatid={$openid}" id="jsDetailId" dd='b'>
                            		<img  currPage="{$currPage}" currIndex="{$key+1}" class="js_img swiper-lazy" data-src="{$v.picpathb}" src-pica="{$v.picture}" src-picb="{$v.picpathb}" side="a" border="0" >
                            	     <if condition="$openid eq 'ofIP5vnuTl1UTMpiIu3pO4_mRQ90' OR $openid eq 'ofIP5vg37cRsChKZJweO8lqgk79o' OR $openid eq 'ofIP5vmqP8pfq574aUmTLQtfG2NY'"><em>{$v.cardid}&nbsp;{$currPage}</em></if>
                                	<div class="swiper-lazy-preloader"></div>
                           		</a>
                            <php>}</php>
                            <span currPage="{$currPage}" currIndex="{$key+1}" data-id="{$v.cardid}" class="remove_card js_btn_remove">删除</span></li>
	                </foreach>
                    <empty name="list">
                        <div class="no_num">
                        <empty name="keyword">
                            <div class="no_num">你当前没有名片，请先创建名片</div>
                        <else/>
                            <div class="no_num">抱歉, 未查询到名片</div>
                        </empty>
                    </empty>
				</ul>
		</div>
		<div id="js_loading" style="display:none;">加载中</div>
		<button id="voiceIdcontroller" type="button" class="b_sound" style="display:none;">
				<div class="sound_btn">
					<span><b></b><!-- <img src="__PUBLIC__/images/wei/iconVoice@3x.png" > --></span>
					<em style="font-size:14px;">按住说话</em>
				</div>
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
	</div>
		<input id="openid" name="openid" value="{$openid}" type="hidden"/>
		<input id="totalPage" name="totalPage" value="{$totalPage}" type="hidden"/>
		<input id="currPage" name="currPage" value="{$currPage}" type="hidden"/>
		<input id="rows" name="rows" value="{$rows}" type="hidden"/>
		<input id="type" name="rows" value="{$type}" type="hidden"/>
		<input id="typekwds" name="rows" value="{$typekwds}" type="hidden"/>
<script src="__PUBLIC__/js/jquery/swiper.min.js?v={:C('WECHAT_APP_VERSION')}"></script>
<script src="__PUBLIC__/js/jquery/zepto.min.js?v={:C('WECHAT_APP_VERSION')}"></script>
    <script src="__PUBLIC__/js/jsExtend/customscroll/jquery.mCustomScrollbar.concat.min.js?v={:C('WECHAT_APP_VERSION')}"></script>
<script>
var gVcardListUrl = "{:U(MODULE_NAME.'/Wechat/wListZp','','',true)}";
var gVcardListSearchUrl = "{:U(MODULE_NAME.'/Wechat/wListZp',array('keyword'=>$keyword),'',true)}";
var gVcardDetailUrl = "{:U('Demo/Wechat/wDetailZp')}";
var gjsLogUrl = "{:U('Demo/Wechat/jsLog')}";
var gCurrPage = "{$currPage}";//当前页码
var gTotalPage = "{$totalPage}";
var gRows = "{$rows}";
var gNewSearch = "{$newSearch}"; //是否测试新搜索,1:是，0:否
var gSysType = '{$sysType}';
window.startpage = false;
$(function(){
    if($('#search').val()!=''){
        $('.js_x_btn').show();
    }

	//向左边滑动
	$(".js_out_div").on("swipeLeft",'.js_li',function(){
		var matrix="matrix(1, 0, 0, 1, 0, 0)";
		if($(this).css("transform") == matrix){
			$(this).find(".js_btn_remove").css("display","block");
			$('.js_li').find('.js_img').css({"transform":"translateX(0px)","transition":"transform 0.3s linear"});
		  	$(this).find('.js_img').css({"transform":"translateX(-70px)","transition":"transform 0.3s linear"});
		}
	});
	//向右边滑动,(还原或者翻面)
	$(".js_out_div").on("swipeRight",'.js_li',function(){
		if($(this).find('.js_img').css("transform") == 'matrix(1, 0, 0, 1, 0, 0)'){
			//console && console.log('查看名片反面');
			var imgObj = $(this).find('.js_img');
			var side = imgObj.attr('side');
			var otherPic = imgObj.attr('src-pic'+side);
			if(otherPic){
				imgObj.attr('src',otherPic);
				imgObj.attr('side',side=='a'?'b':'a');
				//切换名片正反面的连接url
				var hrefUrl = side=='a' ? $(this).attr('frontUrl'):$(this).attr('backUrl');
				$(this).find('#jsDetailId').attr('href',hrefUrl);
			}
		}else{
			$(this).find('.js_img').css({"transform":"translateX(0px)","transition":"transform 0.3s linear"});
		}
	});
	
	//删除名片
	$('.js_list').on('click','.js_btn_remove',function(){
		var that = $(this);
		var cardid = $(this).attr('data-id');
		var idx=$(this).parents("li").index();

		$.post(gCardDeleteUrl,{cardid:cardid},function(rst){
			if(rst.status == 0){
                oraswiper.removeSlide(idx);
                that.parent().remove();
                var numberli = $('#js_scroll li').length;
                var diffmargin ='-'+(numberli-1)*110+'px'
                $(".content_img").css({"margin-top":diffmargin});
                //搜索框提示内容修改。
                var cardnumber = $('#search').attr('data-totalcard');
                $('#search').attr('data-totalcard',(cardnumber-1));
                $('#search').attr('placeholder','搜索（'+(cardnumber-1)+'张名片）');

			}else{
				alert('删除失败');
			}
		},'json');
	});


    var gCardDeleteUrl = "{:U(MODULE_NAME.'/Wechat/delCard','','',true)}"; //删除名片
    var oraswiper = new Swiper('.swiper-container', {
        direction : 'vertical',
        pagination: '.swiper-pagination',
        effect: 'coverflow',
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: 'auto',
        lazyLoading : true,
        lazyLoadingInPrevNext : true,
        lazyLoadingInPrevNextAmount : 4,
        autoplayDisableOnInteraction:false,
        observer:true,
        coverflow: {
            rotate: 50,
            stretch: 10,
            depth: 100,
            modifier: 1,
            slideShadows: false
        },
        onSlideChangeStart: function(swiper,evnt){
            var lastdata = $('#js_scroll li').last();
            var distanceTop = 0;
            distanceTop = lastdata.offset().top;
          //  alert(distanceTop +'  页1  '+document.documentElement.clientHeight+'#'+swiper.activeIndex)
            //if(distanceTop<document.documentElement.clientHeight){
           // var index = swiper.activeIndex+1;
            //alert(Math.ceil(index/rows)+'-'+ gCurrPage+' total='+gTotalPage)
           /*  alert(Math.ceil(index/gRows)+'-'+ gCurrPage+' total='+gTotalPage+' rows='+rows+' '+window.startpage)
            if(Math.ceil(index/gRows) == gCurrPage && gCurrPage<gTotalPage && window.startpage==false){
           		 alert(3);
           		 swiperPage();//滑动分页功能
            }else{
           	     alert((Math.ceil(index/rows) == gCurrPage) +'=#'+ (gCurrPage<gTotalPage) +'=#'+ (window.startpage==false))
            } */
        },
        onTouchEnd: function(swiper,evnt){
            //使用swiper.touches里的坐标差值来判断
        	//Object {startX: 171, startY: 254, currentX: 198, currentY: 282, diff: 27} 
            /* if(swiper.touches.currentX - swiper.touches.startX > 0){
				alert('下')
            }else{
                alert('上')
            } */
                
       	 	var index = swiper.activeIndex+1;
       	 	var obj = $(evnt.target);
       	 	var currIndex = obj.attr('currIndex');
       	 	var currPage = parseInt(obj.attr('currPage'));
          	 currIndex = (currPage-1)*parseInt(gRows)+parseInt(currIndex);
       	 	//console.log('activeindex='+index);
       	 	//console.info('currindex='+currIndex,parseInt(gCurrPage)-1,currPage-1);
       	 	 index = currIndex>index ? currIndex : index;
       	 	// console.log('real='+index)
       	 	 //console.log(Math.ceil(index/gRows)+'########'+gCurrPage,Math.ceil(index/gRows) == parseInt(gCurrPage) , parseInt(gCurrPage)<parseInt(gTotalPage) , window.startpage==false)
          	 if(Math.ceil(index/gRows) == parseInt(gCurrPage) && parseInt(gCurrPage)<parseInt(gTotalPage) && window.startpage==false){
             	   swiperPage();//滑动分页功能
             }else{      
            	    // alert((Math.ceil(index/rows) == gCurrPage) +'=#'+ (gCurrPage<gTotalPage) +'=#'+ (window.startpage==false))
            	 var openid = $('#openid').val();     
/*             	 if(openid == 'ofIP5vnuTl1UTMpiIu3pO4_mRQ90' || openid == 'ofIP5vmqP8pfq574aUmTLQtfG2NY'){
            	       var param = {'#1=':(Math.ceil(index/gRows) == gCurrPage), '#2=':(parseInt(gCurrPage)<parseInt(gTotalPage)),'#3':(window.startpage==false),
            	    '*1ceil=':index+'>'+Math.ceil(index/gRows) ,'*2gCurrPage=':gCurrPage,'*3gTotalPage=':gTotalPage,'*4startpage=':window.startpage
            	     }                
            	   ajaxLog(param);
            	  }    */                             
             }
        },
       /*  onSlidePrev: function(){
			alert('向上滑动');
        } */
        //}
    });

    var transY=$(".content_img ul").css("transform"),
        ty= transY.substring(7).split(','),
        tys=ty[5].substring(1).split(')');
    $(".content_img").css({"margin-top":"-"+tys[0]+"px"});
	//$('#search').focus();

/*     setInterval(function(){
    	var param = {'running':window.running==true,'js_load_img': $('#js_load_img').is(':visible'),'clsActive':!$('.voiceId').hasClass('clsActive')}
    	//ajaxLog(param);
    	if((window.running==true ||  $('#js_load_img').is(':visible')) && !$('.voiceId').hasClass('clsActive')){
    		$('#js_load_img').find('.js_tip_text').text('');
        	$('#js_load_img').hide();
    		jsStopRecord();
    	}        	
    },1000); */
});


function swiperPage(){
      var datastring = {};
      //加载分页数据
      var pages = $('.js_page_numb').attr('data-pagenumb');
      pages = parseInt(pages)+1;
      var kword = $('#search').val();
      if(kword!=undefined && kword!=''){
          datastring = {keyword:kword};
      }
	  var type = $('#type').val();
	  var typekwds = $('#typekwds').val();
	  datastring.type = type;
	  datastring.typekwds = typekwds;
      window.startpage = true;
      $.ajax({
          url:gVcardListSearchUrl+'/page/'+pages,
          type:'get',
          dataType:'json',
          data:datastring,
          success:function(res){
          	window.startpage = false;
         	// $('#js_loading').hide();
              //获取ul原始高度
              var oldulheight = $('.js_list').innerHeight();
              if(res!=''){
                  $('#js_scroll').append(res);
                  $('.js_page_numb').attr('data-pagenumb',pages);
                  //重置swiper
                  var numberli = $('#js_scroll li').length;
                  var diffmargin ='-'+(numberli-1)*110+'px'
                  $(".content_img").css({"margin-top":diffmargin});
              }
          },error:function(res){
          	window.startpage = false;
         	// $('#js_loading').hide();
            //  alert('未加载更多数据');
          }
      });
}


</script>
<!-- <script src="__PUBLIC__/js/oradt/voicedemo.js?v={:C('WECHAT_APP_VERSION')}&t=<?php echo time();?>"></script> -->
</body>
</html>
