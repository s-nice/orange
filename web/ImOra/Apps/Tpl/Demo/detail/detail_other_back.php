<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
    <meta name="x5-fullscreen" content="true">
    <meta name="full-screen" content="yes">
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>{$info['back']['FN'][0]}</title>
	 <script src="__PUBLIC__/js/oradt/H5/fontSize.js?v={:C('WECHAT_APP_VERSION')}?v={:C('WECHAT_APP_VERSION')}"></script>
    <link rel="stylesheet" href="__PUBLIC__/css/detailOra.css?v={:C('WECHAT_APP_VERSION')}" />
    <link rel="stylesheet" href="__PUBLIC__/css/wePage.css?v={:C('WECHAT_APP_VERSION')}" />
	<style>
		html,body{
			background:#fafafa;
		}
        .code_bg {
            width: 100%;
            height: inherit;
            padding: 0;
        }
	</style>
</head>
<body style='display:none;'>
<section class="min_height">
	<section class="my_main">
		<div class="img_top js_cardimg_dom">
            <php>
                $isBack = '';
                if(!empty($info['picpathb'])){
                $isBack = 'hasBackCls';
                }
            </php>
			<ul class="img_list" id="js_showdown_hide">
				<li>
                    <img class="js_vcard_img {$isBack}" src="{$info.picpathb}" alt="" />
				</li>
			</ul>
			
		</div>
        <section class="info_content z_index js_content_dom" >
            <div class="bg_info" id="js_showdown_show">
                <div class="text_info">
                    <dl class="icon_text">
                        <dt>
                            <img src="__PUBLIC__/images/wei/imgLogo@3x.png" alt="" />
                        </dt>
                        <dd>
                            <div class="name">
                                <span>{$info['back']['FN'][0]}</span>
                                <notempty name="info['back']['JOB']">
                                    <em>{$info['back']['JOB'][0]}</em>
                                </notempty>

                            </div>
                            <p>
                                <foreach name="info['back']['ORG']" key="key" item="val">
                                    <if condition="$key eq 0">
                                        {$val}
                                    </if>
                                </foreach>
                            </p>
                        </dd>
                    </dl>
                </div>
                <a href="{:U('Wechat/showCardDetail',array('cardid'=>$cardid,'side'=>'back','android'=>$isAndroid,'openid'=>$openid),'',true)}">
                    <div class="edit_icon"></div>
                </a>
            </div>
        </section>
		<section class="info_content js_showcontent">
			<div class="j_info">
				<div class="info_center">
					<div class="j_item">
						<div class="icon per_icons"></div>
						<p>
                            <notempty name="info['back']['FN']">
                                <a class="weui-cell weui-cell_access" href="{:U('wechat/personInfo',array('cardid'=>$cardid,'name'=>$nameArr[0]),'',true)}">
                                    {$info['back']['FN'][0]}
                                </a>
                            </notempty>
                            <notempty name="info['back']['JOB']">
                                {$info['back']['JOB'][0]}
                            </notempty>
                        </p>
					</div>
					<div class="j_item">
						<div class="icon buliding_icons"></div>
						<p>
                            <foreach name="info['back']['ORG']" key="key" item="val">
                                <if condition="$key eq 0">
                                    <a class="weui-cell weui-cell_access" href="{:U(MODULE_NAME.'/Wechat/companyComfirm',array('name'=>$val,'cardid'=>$cardid,'android'=>$isAndroid),'',true)}">{$val}</a>
                                </if>
                            </foreach>
                        </p>
					</div>
					<div class="j_item">
						<div class="icon map_icons"></div>
						<p>
                            <foreach name="info['back']['ADR']" key="keys" item="vals">
                                <if condition="$keys eq 0">
                                    <a class="weui-cell weui-cell_access"  href="{:U('demo/Wechat/mapShow',array('addr'=>$vals,),'',true)}" id="locationId">
                                        <ii id="js_locationname">{$vals}</ii>
                                    </a>
                                </if>
                            </foreach>
                        </p>
					</div>
                    <!--电话-->
                    <foreach name="info['back']['CELL']" item="vo" >
                        <notempty name="vo">
                                <div class="j_item">
                                    <div class="icon phone_icons"></div>
                                    <a class="weui-cell weui-cell_access" href="tel:{$vo}">
                                    	<p>{$vo}</p>
                                    </a>
                                </div>
                        </notempty>
                    </foreach>
                    <!--手机-->
                    <foreach name="info['back']['TEL']" item="vo" >
                        <notempty name="vo">
                                <div class="j_item">
                                    <div class="icon mobile_icons"></div>
                                    <a class="weui-cell weui-cell_access" href="tel:{$vo}">
                                    	<p>{$vo}</p>
                                    </a>
                                </div>       
                        </notempty>
                    </foreach>
                    <!--邮箱-->
                    <foreach name="info['back']['EMAIL']" item="valss">
                        <div class="j_item">
                            <div class="icon email_icons"></div>
                            <p>{$valss}</p>
                        </div>
                    </foreach>
                    <!--网站-->
                    <foreach name="info['back']['URL']" item="valss">
                        <div class="j_item">
                            <div class="icon www_icons"></div>
                            <p>
                                <a class="weui-cell weui-cell_access" href="http://{$vo}">
                                    {$valss}
                                </a>
                            </p>
                        </div>
                    </foreach>

				</div>
			</div>
		</section>
	</section>
	<footer class="info_submit">
        <div class="s_btn_width">
            <if condition="$userAgent eq 'weixin'">
                <button class="btn btn-right btn-w js_showVcardQrcode"><span class="span-save">保存到通讯录</span></button>
            </if>
            <if condition="$info['share'] eq 0">
                <button class="btn btn-w" id="js_share_card_tocompany" data-cid="{$cardid}"><span class="span-enjoy">分享到企业</span></button>
                <else/>
                <button class="btn btn-w">已分享</span></button>
            </if>
        </div>
	</footer>
    <div id="js_load_img" style="display:none;">
        <div class="weui-mask_transparent"></div>
        <div class="weui-toast">
            <i class="weui-icon-success-no-circle weui-icon_toast"></i>
            <p class="weui-toast__content js_tip_text"></p>
        </div>
    </div>
    <input id="openid" name="openid" value="{$openid}" type="hidden"/>
    <input id="cardid" name="cardid" value="{$cardid}" type="hidden"/>
</section>
    <!--  弹框  -->
    <div class="code_null"></div>
    <div class="js_show_code show_code">
        <div class="tow_code">
            <div class="code_bg">
                <img id="js_showVcardImg" src="{:U('h5/exchange/qrcode',array('fid'=>$vcardid.'_'),'',true)}" alt="">
            </div>
            <p>
                <span>长按识别二维码，保存至手机通讯录</span>
            </p>
            <div class="js_close colse_code">
                <img src="__PUBLIC__/images/w_colse.png">
            </div>
        </div>
    </div>
    <div class="js_no_weui big_no_weui">
        <div class="no_weui">
            <div class="three_btns">
                <div class="hint_btn">下载提示</div>
                <div class="hint_btn hint_color hint_border">{$info['back']['FN'][0]}的名片.vcf</div>
                <a class="js_no_weui" href="{:U('h5/exchange/downloadFile',array('fid'=>$vcardid,'name'=>$info['back']['FN'][0],),'',true)}"><div class="hint_btn hint_color">立即下载</div></a>
            </div>
            <div class="three_btns three_bot">
                <div class="js_close_no_weui hint_btn">取消</div>
            </div>
        </div>
    </div>

    <!--  成功弹框  -->
    <div class="pull_file js_operate_success">
        <div class="dia_w dia-line">
            <img src="__PUBLIC__/images/wei/sucess_icon.png" alt="">分享成功
        </div>
    </div>
    <!-- 失败弹框  -->
    <div class="dia_error js_operate_error">
        <div class="error_w">
            <img src="__PUBLIC__/images/wei/error_icon.png" alt="">
            分享失败
            <p class="js_message"></p>
        </div>
    </div>

</body>
</html>
<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}?v={:C('WECHAT_APP_VERSION')}"></script>
<script type="text/javascript" src='http://res.wx.qq.com/open/js/jweixin-1.2.0.js?v={:C('WECHAT_APP_VERSION')}'></script>
<script src="__PUBLIC__/js/oradt/voicedemo.js?v={:C('WECHAT_APP_VERSION')}?v={:C('WECHAT_APP_VERSION')}"></script>
<script src="__PUBLIC__/js/jquery/swiper.min.js?v={:C('WECHAT_APP_VERSION')}"></script>
<script src="__PUBLIC__/js/jquery/zepto.min.js?v={:C('WECHAT_APP_VERSION')}"></script>
<script type="text/javascript">

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
var js_trans_str_g_detail_map_nocontact = "{$T->str_g_detail_map_nocontact}";
var js_trans_str_g_detail_no_backside_info = "{$T->str_g_detail_no_backside_info}";

var js_url_sharecard = "{:U(MODULE_NAME.'/Wechat/shareCardToComp','','',true)}";
var gGetLocationUrl = "{:U(MODULE_NAME.'/Wechat/getLocation','','',true)}";
var gVcardListUrl = "{:U(MODULE_NAME.'/Wechat/wListZp',array('keyword'=>$kwd,'openid'=>$openid,'android'=>$isAndroid),'',true)}";
var gVcardDetailBackUrl = "{:U(MODULE_NAME.'/Wechat/wDetailZp',array('keyword'=>$kwd,'cardid'=>$cardid,'openid'=>$openid,'android'=>$isAndroid),'',true)}"; //名片反面url
var urlSource = "{$urlSource}"; //url来源
var isAndroid = "{$isAndroid}"; //是否来源于android扫描仪
var sysType = '{$sysType}'; //手机系统类型

function isWeiXin(){
    var ua = window.navigator.userAgent.toLowerCase();
    if(ua.match(/MicroMessenger/i) == 'micromessenger'){
        return true;
    }else{
        return false;
    }
}
/*
if(!isAndroid){
    wx.config({
        debug: false,
        appId: "{$signPackage['appId']}",
        timestamp: "{$signPackage['timestamp']}",
        nonceStr: "{$signPackage['nonceStr']}",
        signature: "{$signPackage['signature']}",
        jsApiList: ['chooseImage', 'uploadImage','stopRecord','pauseVoice','onVoicePlayEnd','onVoiceRecordEnd','playVoice','translateVoice','checkJsApi','openLocation','getLocation']
    });
}*/

/*document.getElementById('upload').addEventListener("click", function () {
    wx.chooseImage({
        count: 1, // 默认9
        sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
        sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
        success: function (res) {
            var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
            wx.uploadImage({
                localId: localIds[0], // 需要上传的图片的本地ID，由chooseImage接口获得
                isShowProgressTips: 1, // 默认为1，显示进度提示
                success: function (res) {
                    var serverId = res.serverId; // 返回图片的服务器端ID
                    document.getElementById('search').value=serverId;
                }
            });
        }
    });
}, true);*/

window.onload=function(){
    $('.js_content_dom').css('margin-top','2rem');
    var domtop = parseInt($('.js_content_dom').css('margin-top'));
    $(window).scrollTop(domtop);
    /*setTimeout(function(){
        $(window).scrollTop(domtop+1);
    },100);*/
};
$(function(){
    //分享到企业
    $('#js_share_card_tocompany').click(function(){
        var cid = $(this).attr('data-cid');
        $.ajax({
            url:js_url_sharecard,
            type:'post',
            dataType:'json',
            data:'cid='+cid,
            success:function(res){
                if(res.status==0){
                    $('.js_operate_success').show();
                    setTimeout(function(){
                        $('.js_operate_success').hide();
                    },3000);
                }else{

                    //$('.js_operate_error .js_message').html(res.status);
                    if(res.status==999005 || res.status==800004){
                        $('.js_operate_error .js_message').html('该名片已分享过');
                    }
                    if(res.status==999025){
                        $('.js_operate_error .js_message').html('您还未绑定企业');
                    }
                    if(res.status==999029){
                        $('.js_operate_error .js_message').html('用户名片不存在');
                    }
                    if(res.status==100017){
                        $('.js_operate_error .js_message').html('用户不存在');
                    }
                    if(res.status==200024){
                        $('.js_operate_error .js_message').html('您的账号暂未通过企业审核');
                    }

                    $('.js_operate_error').show();

                    setTimeout(function(){
                        $('.js_operate_error').hide();
                    },3000);
                }
            },
            error:function(res){}
        });
    });

    $('#backId').click(function(){
        if(isAndroid == '1'){
            location.href=gVcardListUrl;
        }else{
            if(urlSource == ''){
                location.href=gVcardListUrl;
            }else{
                window.history.go(-1);
            }
        }
        return false;
    });

    // 二维码弹出框
    $('.js_showVcardQrcode').on('click',function(){
        if(isWeiXin()){
            $('.js_show_code').show();
            $('.code_null').show();
            $('html').css('overflow',"hidden");
            return;
        }else{
            $('.js_no_weui').show();
            $('.code_null').show();
            $('html').css('overflow',"hidden");
        }

    });
    // 关系二维码|下载vcf层
    $('.js_close,.js_close_no_weui').on('click',function(){
        $('.code_null').hide();
        $('.js_show_code,.js_no_weui').hide();
        $('html').css('overflow',"auto");
    });

    // 地图
    $('#locationId').click(function(){
        /*return false;
        var addressOld = $(this).find('#js_locationname').html();
        if(addressOld.length>58){
            address = addressOld.substr(0,58);
        }else{
            address = addressOld;
        }

        $.get(gGetLocationUrl,{address:encodeURIComponent(address)},function(rst){
            getLocInfo(rst,addressOld);
        },'json');*/
    });
});

function getLocInfo(obj,address){
    if(obj.status==0){
        var latitude = obj.result.location.lat;
        var longitude = obj.result.location.lng;
        showMap(latitude,longitude,address)
    }else{
        alert(js_trans_str_g_detail_map_nocontact);
    }
}
var mapScale = 14;
if(sysType == 'android'){
    mapScale = 15;
}
function showMap(latitude,longitude,address){
    wx.openLocation({
        latitude: latitude, // 纬度，浮点数，范围为90 ~ -90
        longitude: longitude, // 经度，浮点数，范围为180 ~ -180。
        name: address, // 位置名
        address: address, // 地址详情说明
        scale:mapScale, // 地图缩放级别,整形值,范围从1~28。默认为最大
        infoUrl: '' // 在查看位置界面底部显示的超链接,可点击跳转
    });
}
//判断名片反面
$('.js_vcard_img').click(openOtherSide);
$('.js_vcard_img').on('swipeRight',openOtherSide); //向由滑动翻看另一面
function openOtherSide(){
    if($(this).hasClass('hasBackCls')){
        window.location.href = gVcardDetailBackUrl;
    }else{
        $('.js_tip_text').html(js_trans_str_g_detail_no_backside_info);
        $('#js_load_img').show();
        setTimeout(function(){
            $('#js_load_img').hide();
        },1500);
    }
}
$(".info_center li").click(function(){
    var liclass = $(this).attr("class");
    var liurl = getHref($(this), liclass);
    if (liurl !== false) {
        window.location.href = liurl;
    }
});
function getHref(obj,classname){
    switch(classname){
        case 'li-per':
            return "{:U('wechat/personInfo',array('cardid'=>$cardid),'',true)}?name="+obj.attr('value');
        case 'li-company':
            return "{:U(MODULE_NAME.'/Wechat/companyComfirm',array('cardid'=>$cardid,'android'=>"+isAndroid+"),'',true)}?name="+obj.attr('value');
        case 'li-tel':
            return obj.attr('value');
        case 'li-phone':
            return obj.attr('value');
        case 'li-url':
            return obj.attr('value');
        default:
            return false;
    }
}
</script>