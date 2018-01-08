<!DOCTYPE html>
<html lang="en" style=" width:100%;height:100%;overflow:hidden;">
<head>
	<meta charset="UTF-8">
	<!-- uc强制竖屏 -->
	<meta name="screen-orientation" content="portrait">
	<!-- QQ强制竖屏  -->
	<meta name="x5-orientation" content="portrait">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<title>企业名片</title>
	<link rel="stylesheet" href="__PUBLIC__/css/font-awesome/font-awesome.min.css?v={:C('WECHAT_APP_VERSION')}">
	<link rel="stylesheet" href="__PUBLIC__/css/swiper.min.css?v={:C('WECHAT_APP_VERSION')}">
	<link rel="stylesheet" href="__PUBLIC__/css/weui.min.css?v={:C('WECHAT_APP_VERSION')}">
	<link rel="stylesheet" href="__PUBLIC__/css/wList.css?v={:C('WECHAT_APP_VERSION')}">
	<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}&t=<?php time();?>"></script>
	<script type="text/javascript" src='http://res.wx.qq.com/open/js/jweixin-1.2.0.js?v={:C('WECHAT_APP_VERSION')}'></script>
	<script type="text/javascript">
        wx.ready(function(){
            testVoice();
        });
	</script>
    <style>
        .select-bar{
            height: 50px;
            width: 95%;
            margin: 0 auto;
        }
        .select-bar li{
            height: 48px;
            line-height: 48px;
            text-align: center;
            color: #ffffff;
            float: left;
            width:33.33%;
            /*border-bottom: 2px solid ;*/
        }
        .select-bar li a{
            display: block;
            height: 48px;
            line-height: 48px;
            text-align: center;
            color: #ffffff;
            font-size:0.9rem;
            /*float: left;*/
            /*width:33.33%;*/
            /*border-bottom: 2px solid ;*/
        }
        .select-bar .selected{
            border-bottom: 2px solid #ffa776;
            color: #ffa776;
        }
        .select-bar .selected a{
            color: #ffa776;
        }
        .content_img {
            display: none;
        }
        .selectedList{
            display: block;
        }
        .sound_btn {
            width: 120px;
        }

    </style>
</head>
<body style="width:100%;height:100%;overflow:hidden;">
	<div class="warmp" id="outdiv">
		<div class="nav-trim-top"></div>
		<div class="search_top">
			<div class="search_text">
  				<div class="search_box">
                    <input id='search' placeholder="{$T->str_g_list_search}（{$cardCount}{$T->str_g_list_search_unit}）" data-totalcard="{$cardCount}" value="{$keyword}" type="text" style="font-size:14px;">
                    <input id="weixinVoiceTime" type="hidden" value=""/>
                    <input id="weixinVoiceTime2" type="hidden" value=""/>
                    <span class="js_x_btn remove"><img src="__PUBLIC__/images/wclose.png"></span>
                </div>
                <button class="weui-btn_primary" id="searchBtn">{$T->str_g_list_search}</button> <!-- -->
            </div>
            <ul class="select-bar">
                <li class="totalCard"><a href="{:U('bizCardList',array())}">所有名片(<span>{$selfcount+$bindcount}</span>)</a></li>
                <li class="myCard"><a href="{:U('bizCardList',array('section'=>1))}">我创建的(<span>{$selfcount}</span>)</a></li>
                <li class="otherCard"><a href="{:U('bizCardList',array('section'=>2))}">分享给我的(<span>{$bindcount}</span>)</a></li>
            </ul>
		</div>
		<div class="imgs">
            <div class=" myList selectedList content_img swiper-container swiper-container-horizontal swiper-container-3d swiper-container-coverflow js_out_div js_page_numb" data-pagenumb="1">
            <ul class="swiper-wrapper js_list" id="js_scroll">
                <foreach name='list' item='v' >
                    <li t1="{$v['isfb']}" class="swiper-slide js_li" style="z-index:1;" data-id="{$v.vcardid}" frontUrl="{:U('Demo/CompanyCard/wDetailZp')}?cardid={$v.vcardid}&kwd={:urlencode($keyword)}&wechatid={$openid}&isMy={$isMy}" backUrl="{:U('Demo/CompanyCard/detailBack')}?cardid={$v.vcardid}&kwd={:urlencode($keyword)}&wechatid={$openid}&isMy={$isMy}">
                        <a href="{:U('Demo/CompanyCard/wDetailZp')}?cardid={$v.vcardid}&kwd={:urlencode($keyword)}&wechatid={$openid}&isMy={$isMy}" id="jsDetailId" dd='a'>
                            <img  currPage="{$currPage}" currIndex="{$key+1}" class="js_img swiper-lazy" data-src="{$v.picpatha}" src-pica="{$v.picpatha}" src-picb="{$v.picpathb}" side="b" border="0" >
                            <div class="swiper-lazy-preloader"></div>
                        </a>
                        <span currPage="{$currPage}" currIndex="{$key+1}" data-id="{$v.vcardid}" class="remove_card js_btn_remove">{$T->str_g_list_delete}</span>
                    </li>
                </foreach>
                <empty name="list">
                    <div class="no_num" style="margin-top: 20px;">
                        <empty name="keyword">
                            <div class="no_num">{$T->str_g_list_no_card}</div>
                            <else/>
                            <div class="no_num">{$T->str_g_list_no_search}</div>
                        </empty>
                </empty>
            </ul>
        </div>
        </div>
		<div id="js_loading" style="display:none;">{$T->str_g_list_loading}</div>
		<if condition="$userAgent eq 'weixin'">
		<button id="voiceIdcontroller" type="button" class="b_sound" >
				<div class="sound_btn">
					<span><b></b><!-- <img src="__PUBLIC__/images/wei/iconVoice@3x.png" > --></span>
					<em style="font-size:16px;">{$T->str_g_list_btn_say}</em>
				</div>
			</div></button>
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
    </div>
    <input type="hidden" name="list" value="{$listType}">
    <input id="openid" name="openid" value="{$openid}" type="hidden"/>
    <input id="totalPage" name="totalPage" value="{$totalPage}" type="hidden"/>
    <input id="currPage" name="currPage" value="{$currPage}" type="hidden"/>
    <input id="rows" name="rows" value="{$rows}" type="hidden"/>
    <input id="type" name="rows" value="{$type}" type="hidden"/>
    <input id="typekwds" name="rows" value="{$typekwds}" type="hidden"/>
    <input id="section" name="section" value="{$section}" type="hidden"/>
    <script src="__PUBLIC__/js/jquery/swiper.min.js?v={:C('WECHAT_APP_VERSION')}"></script>
    <script src="__PUBLIC__/js/jquery/zepto.min.js?v={:C('WECHAT_APP_VERSION')}"></script>
    <script src="__PUBLIC__/js/jsExtend/customscroll/jquery.mCustomScrollbar.concat.min.js?v={:C('WECHAT_APP_VERSION')}"></script>
    <script src="__PUBLIC__/js/oradt/voicedemo.js?v={:C('WECHAT_APP_VERSION')}&t=<?php echo time();?>"></script>
    <script>
        var gVcardListUrl = "{:U(MODULE_NAME.'/CompanyCard/bizCardList',array('section'=>$section))}";
        var gVcardListSearchUrl = "{:U(MODULE_NAME.'/Wechat/wListZp',array('keyword'=>$keyword),'',true)}";
        var gVcardDetailUrl = "{:U('Demo/CompanyCard/wDetailZp')}";
        var gjsLogUrl = "{:U('Demo/Wechat/jsLog')}";
        var gCurrPage = "{$currPage}";//当前页码
        var gTotalPage = "{$totalPage}";
        var gRows = "{$rows}";
        var gNewSearch = "{$newSearch}"; //是否测试新搜索,1:是，0:否
        var gSysType = '{$sysType}';
        var bizCardDeleteUrl = '{:U("bizCardDel")}';
        var ajaxGetCadsUrl = "{:U('ajaxGetCards')}"
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

        window.startpage = false;

        var section = $('input[name=section]').val();
        $li = $('.select-bar li');
        $li.removeClass('selected');
        if(section==1){
            $li.eq(1).addClass('selected');
        }else if(section==2){
            $li.eq(2).addClass('selected');
        }else{
            $li.eq(0).addClass('selected');
        }
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
                var count = $('.select-bar .selected span').text();
                var totalCount = $('.totalCard span').text();
                count = parseInt(count);
                totalCount = parseInt(totalCount);
                $.post(bizCardDeleteUrl,{vcardid:cardid},function(rst){
                    if(rst.status == 0){
                        oraswiper.removeSlide(idx);
                        that.parent().remove();
                        $('.select-bar .selected span').text(--count);
                        if(!$('.select-bar .selected').hasClass('totalCard')){
                            $('.totalCard span').text(--totalCount);
                        }else{
                            window.location.reload();
                        }
                        var numberli = $('#js_scroll li').length;
                        var diffmargin ='-'+(numberli-1)*110+'px'
                        $(".content_img").css({"margin-top":diffmargin});
                        //搜索框提示内容修改。
                        var cardnumber = $('#search').attr('data-totalcard');
                        $('#search').attr('data-totalcard',(cardnumber-1));
                        $('#search').attr('placeholder',js_trans_search+'（'+(cardnumber-1)+js_trans_search_unit+'）');

                    }else{
                        alert(js_trans_delete_faild);
                    }
                },'json');
            });

            var oraswiper = new Swiper('.swiper-container', {
//            var oraswiper = new Swiper('.swiper-wrapper', {
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
//                    alert(1234);
                    var index = swiper.activeIndex+1;
                    var obj = $(evnt.target);
                    var currIndex = obj.attr('currIndex');
                    var currPage = parseInt(obj.attr('currPage'));
                    currIndex = (currPage-1)*parseInt(gRows)+parseInt(currIndex);
                    //console.log('activeindex='+index);
                    //console.info('currindex='+currIndex,parseInt(gCurrPage)-1,currPage-1);
                    index = currIndex>index ? currIndex : index;
//                     console.log(index/gRows)
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
            });
            var transY=$(".content_img ul").css("transform");
            var ty= transY.substring(7).split(',');
            var tys=ty[5].substring(1).split(')');
            $(".content_img").css({"margin-top":"-"+tys[0]+"px"});
        });


        function swiperPage(){
            var datastring = {};
            var section = $('input[name=section]').val();
//            var currentPage = parseInt($('input[name=currPage]').val())+1;
            var currentPage = parseInt($('.remove_card:last').attr('currPage'))+1;
//            alert(currentPage);
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
                url:ajaxGetCadsUrl,
                type:'get',
                dataType:'json',
                data:{section:section,currentPage:currentPage,keyword:kword},
                success:function(res){
                    window.startpage = false;
                    // $('#js_loading').hide();
                    //获取ul原始高度
                    var oldulheight = $('.js_list').innerHeight();
                    if(res.data.list!=''){
//                        $('input[name=currPage]').val(res.data.currentPage);
                        $('#js_scroll').append(res.data.list);
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

        wx.config({
            debug: false,
            appId: "{$signPackage['appId']}",
            timestamp: "{$signPackage['timestamp']}",
            nonceStr: "{$signPackage['nonceStr']}",
            signature: "{$signPackage['signature']}",
            jsApiList: ['chooseImage', 'uploadImage','stopRecord','pauseVoice','onVoicePlayEnd','onVoiceRecordEnd','playVoice','translateVoice']
        });

        $('.in-enjoy span').on('click',function () {
            window.location.href = '{:U("batchShareCard")}'
        })
        $('#search').on('input propertychange', function() {
            var _this = this;
            var searchword = $(this).val();
            if(searchword!=''){
                $('.js_x_btn').show();
            }else{
                $('.js_x_btn').hide();
            }

        });
        $('#searchBtn').click(function(){
            ajaxGetData();
        });
        //搜索输入框尾部 X 按钮
        $('.js_x_btn').click(function(){
            $('#search,#type,#typekwds').val('');
            $(this).hide();
            ajaxGetData();
        });

        //ajax异步获取搜索数据
        function ajaxGetData(_keyword){
            var keyword = $('#search').val();
            if(keyword == js_trans_str_g_list_putcontent_search){
                keyword='';
            }
            if(_keyword!=null && _keyword!='') keyword=_keyword;
            var openid = $('#openid').val();
            gVcardListUrl = gVcardListUrl.replace('.html','');
            var weixinVoiceTime = $('#weixinVoiceTime').val();
            var weixinVoiceTime2 = $('#weixinVoiceTime2').val();
            var sendReqTime = new Date().getTime();
            sendReqTime = sendReqTime/1000;
            sendReqTime = sendReqTime.toFixed(4);
            var android = $('#android').val();
            var type = $('#type').val();
            var typekwds = $('#typekwds').val();
//            var paramArr = {'keyword':keyword,openid:openid,android:android, time:weixinVoiceTime,time2:weixinVoiceTime2,sendReqTime:sendReqTime,type:type,typekwds:typekwds};
            var paramArr = {'keyword':keyword};
            var paramStr = getEscapeParamStr(paramArr);
            window.location.href = gVcardListUrl+'/'+paramStr;

        }


        //编码url
        function getEscapeParamStr (jsonData){
            if (!jsonData) return '';
            var qarr = [];
            for(i in jsonData){
                if($.trim(jsonData[i]).length>0){
                    qarr.push(i+"/"+encodeURIComponent(jsonData[i]));
                }
            }
            return qarr.join('/');
        }


    </script>
</body>
</html>
