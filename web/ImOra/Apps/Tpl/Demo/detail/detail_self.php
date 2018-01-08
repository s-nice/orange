<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>{$T->str_g_detail_mycard}</title>
	 <script src="__PUBLIC__/js/oradt/H5/fontSize.js?v={:C('WECHAT_APP_VERSION')}?v={:C('WECHAT_APP_VERSION')}"></script>
    <link rel="stylesheet" href="__PUBLIC__/css/detailOra.css?v={:C('WECHAT_APP_VERSION')}" />
	<style>
		html,body{
			background:#fafafa;
		}
	</style>
</head>
<body style='display:none;'>
<section class="min_height">
	<section class="my_main">
		<div class="img_top">
            <php>
                $isBack = '';
                if(!empty($info['picpathb'])){
                $isBack = 'hasBackCls';
                }
            </php>
			<ul class="img_list">
				<li>
					<img src="{$info.picpatha}" class="js_vcard_img {$isBack}" alt="" />
				</li>
			</ul>
			
		</div>
		<section class="info_content z_index js_content_dom">
			<div class="bg_info">
				<div class="text_info">
					<dl class="icon_text">
						<dt>
							<img src="__PUBLIC__/images/wei/imgLogo@3x.png" alt="" />
						</dt>
						<dd>
							<div class="name">
								<span>
                                    {$info['front']['FN'][0]}
                                </span>
								<em>
                                    <notempty name="info['front']['JOB']">
                                        {$info['front']['JOB'][0]}
                                    </notempty>
                                </em>
							</div>
							<p>
                                <foreach name="info['front']['ORG']" key="key" item="val">
                                    <if condition="$key eq 0">
                                        {$val}
                                    </if>
                                </foreach>
                            </p>
						</dd>
					</dl>
				</div>
                    <a href="{:U('Wechat/showCardDetail',array('cardid'=>$cardid,'side'=>'front','android'=>$isAndroid),'',true)}">
                        <div class="edit_icon"></div>
                    </a>
			</div>
		</section>
		<section class="info_content">
			<div class="j_info">
				<div class="info_center">
					<div class="j_item">
						<div class="icon per_icons"></div>
						<p>
                            <a class="weui-cell weui-cell_access" href="{:U('wechat/personInfo',array('cardid'=>$cardid,'name'=>$nameArr[0]),'',true)}">
                                {$info['front']['FN'][0]}
                            </a>
                            <notempty name="info['front']['JOB']">
                                &nbsp;{$info['front']['JOB'][0]}
                            </notempty>
                        </p>
					</div>
					<div class="j_item">
						<div class="icon buliding_icons"></div>
						<p>
                            <foreach name="info['front']['ORG']" key="key" item="val">
                                <if condition="$key eq 0">
                                    <a class="weui-cell weui-cell_access" href="{:U(MODULE_NAME.'/Wechat/companyComfirm',array('name'=>$val,'cardid'=>$cardid,'android'=>$isAndroid),'',true)}">
                                    {$val}
                                    </a>
                                </if>
                            </foreach>
                        </p>
					</div>
					<div class="j_item">
						<div class="icon map_icons"></div>
						<p>
                            <foreach name="info['front']['ADR']" item="vo">
                                <a class="weui-cell weui-cell_access"  href="{:U('demo/Wechat/mapShow',array('addr'=>$vo,),'',true)}" id="locationId">
                                    <ii id="js_locationname">{$vo}</ii>
                                </a>
                            </foreach>
                        </p>
					</div>
                    <!--电话-->
                    <foreach name="info['front']['CELL']" item="vo" >
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
                    <foreach name="info['front']['TEL']" item="vo" >
                        <notempty name="vo">
                            <div class="j_item">
                                <div class="icon mobile_icons"></div>
                                <a class="weui-cell weui-cell_access" href="tel:{$vo}">
                                    <p>{$vo}</p>
                                </a>
                            </div>
                        </notempty>
                    </foreach>
                    </foreach>
                    <foreach name="info['front']['EMAIL']" item="valss">
                        <div class="j_item">
                            <div class="icon email_icons"></div>
                            <p>{$valss}</p>
                        </div>
                    </foreach>
                    <foreach name="info['front']['URL']" item="valss">
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
			<!--<button class="btn">确认提交</button>-->
		</div>
	</footer>
    <input id="openid" name="openid" value="{$openid}" type="hidden"/>
    <input id="cardid" name="cardid" value="{$cardid}" type="hidden"/>
</section>
</body>
</html>
<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}?v={:C('WECHAT_APP_VERSION')}"></script>
<script type="text/javascript" src='http://res.wx.qq.com/open/js/jweixin-1.2.0.js?v={:C('WECHAT_APP_VERSION')}'></script>
<script src="__PUBLIC__/js/oradt/voicedemo.js?v={:C('WECHAT_APP_VERSION')}?v={:C('WECHAT_APP_VERSION')}"></script>
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

    var gGetLocationUrl = "{:U(MODULE_NAME.'/Wechat/getLocation','','',true)}";
    var gVcardListUrl = "{:U(MODULE_NAME.'/Wechat/wListZp',array('keyword'=>$kwd,'openid'=>$openid,'android'=>$isAndroid),'',true)}";
    var gVcardDetailBackUrl = "{:U(MODULE_NAME.'/Wechat/detailBack',array('keyword'=>$kwd,'cardid'=>$cardid,'openid'=>$openid,'android'=>$isAndroid),'',true)}"; //名片反面url
    var urlSource = "{$urlSource}"; //url来源
    var isAndroid = "{$isAndroid}"; //是否来源于android扫描仪
    var sysType = '{$sysType}'; //手机系统类型

    window.onload=function(){
        $('.js_content_dom').css('margin-top','2rem');
        var domtop = parseInt($('.js_content_dom').css('margin-top'));
        $(window).scrollTop(domtop);
        /*setTimeout(function(){
         $(window).scrollTop(domtop+1);
         },100);*/
    };

    $(function(){
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
    $('.js_vcard_img').click(function(){
        if($(this).hasClass('hasBackCls')){
            window.location.href = gVcardDetailBackUrl;
        }else{
            $('.js_tip_text').html(js_trans_str_g_detail_no_backside_info);
            $('#js_load_img').show();
            setTimeout(function(){
                $('#js_load_img').hide();
            },1500);
        }
    });
</script>
