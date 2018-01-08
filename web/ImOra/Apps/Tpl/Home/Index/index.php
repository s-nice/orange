<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>{$T->str_title_imora}</title>
<link rel="stylesheet" href="__PUBLIC__/css/Officialwebsite.css" />
<style>
.slice_li_content {
    height: 1200px;
    margin: 106px auto 0;
    width: 1200px;
}

.Officialwebsite_c
{
position:relative;
}
.Officialwebsite_bin {
    width: 100px;
    bottom: 40px;
    position: absolute;
    left:50%;
    margin-left:-50px;
}

.content_middle_c {
    height: 1240px;
    }
.content_middle_c ul li {
    height: 1240px;

}
.content_middle_c ul li.five_li {
    background-image: url("__PUBLIC__/images/content_bg_img2.jpg");
    background-position: center 40px;
    background-repeat: no-repeat;
}
.content_middle_c ul li.four_li {
    background-image: url("__PUBLIC__/images/homepage_slide_5.jpg");
    background-position: center 254px;
    background-repeat: no-repeat;
}
.four_li_content span
{
    clear: both;
    float: right;
    text-align: center;
    width: 860px;
    font-family: 'Microsoft YaHei','微软雅黑';
}

.four_li_content .title
{
color:#333;
font-size: 72px;
    margin: 0px 0 0;
    letter-spacing: 5px;
    line-height:58px;

}
.four_li_content .content
{
font-family: 'Microsoft YaHei','微软雅黑';
color:#666;
font-size: 30px;
margin: 30px 0 0;
letter-spacing: 3px;
line-height:32px;
}
.four_li_content .more
{
margin: 24px 0 0;
font-size: 18px;
line-height:18px;
}
.four_li_content .more a
{
    color: #aaa;
    font-family:'Microsoft YaHei','微软雅黑';
    letter-spacing: 2px;
font-size: 16px;
}
.five_li_content span
{
    clear: both;
    float: right;
    text-align: center;
    width: 740px;
    font-family:'Microsoft YaHei','微软雅黑';
}

.five_li_content .title
{
color:#666;
font-size: 48px;
    margin: 230px 0 0;
    letter-spacing: 3px;
}
.five_li_content .content
{
color:#666;
font-size: 14px;
margin: 30px 0 0;
letter-spacing: 1px;
}
.five_li_content .more
{
margin: 50px 0 0;
font-size: 18px;
}
.five_li_content .more a
{
color:#333;
border: 1px solid #333;
    font-family:'Microsoft YaHei','微软雅黑';
    letter-spacing: 2px;
    padding: 12px 20px;
}
</style>
</head>
<body>
    <div class="Officialwebsite_all">
        <div class="Officialwebsite_header">
	      <include file="Index/_headMenu"/>
        </div>
        <div class="Officialwebsite_c">
            <div class="content_middle_c">
                <ul>
                    <li class="first_li">
                        <div class="first_li_content">
                            <span class="logo"><img src="__PUBLIC__/images/content_img_logo.png" /></span>
                            <span class="Imora"><img src="__PUBLIC__/images/content_img_imora.png" /></span>
                            <span class="video">{$T->str_index_01}</span>
                        </div>
                    </li>
                    <li class="secent_li">
                        <div class="secent_li_content">
                        	<span class="zhanshi"><img src="__PUBLIC__/images/content_img_zhanshi.jpg" /></span>
                        	<span class="zhanshi_c">{$T->str_index_02}</span>
                        </div>
                    </li>
                    <li class="three_li">
                        <div class="three_li_content">
                        	<span class="hudong"><img src="__PUBLIC__/images/content_img_hudong.png" /></span>
                        	<span class="hudong_c"><i>{$T->str_index_03}</i><em>{$T->str_index_04}</em></span>
                        </div>
                    </li>
                    <li class="four_li">
                        <div class="slice_li_content four_li_content">
                            <span class="title">{$T->str_index_05}</span>
                            <span class="content">{$T->str_index_06}</span>
                            <span class="more"><a href="">{$T->str_index_07}&gt;&gt;</a></span>
                        </div>
                    </li>
                    <li class="five_li">
                        <div class="slice_li_content five_li_content">
                            <span class="title">{$T->str_index_08}</span>
                            <span class="content">{$T->str_index_09}
                            <br/>{$T->str_index_10}
                            </span>
                            <!-- <span class="more"><a href="">{$T->str_index_11}</a></span> -->
                        </div>
                    </li>
                </ul>
            </div>
            <div class="Officialwebsite_bin">
                <span class="active"></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div class="footer">
<!--             <div class="footer_top"> -->
<!--                 <div class="footer_left"  style="position:relative"><a href="AboutOra.html"> -->
<!--                 <img src="__PUBLIC__/images/content_img_aboutus.png" /> -->
<!--                 </a> -->
<!--                 <object class="object_flash" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0"  width="415" height="272"> -->
<!-- <param name="movie" value="__PUBLIC__/video/flash1.swf" /> -->
<!-- <param name="quality" value="high" /> -->
<!-- <param name="allowFullScreen" value="true" /> -->
<!-- <param value="transparent" name="wmode"> -->
<!-- <param value="opaque/" name="wmode"> -->
<!-- <param value="window" name="wmode"> -->
<!-- <embed src="__PUBLIC__/video/flash1.swf" allowfullscreen="true" wmode="transparent" flashvars="vcastr_file=2.flv&IsAutoPlay=0&LogoUrl=images/logo.jpg" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"  width="415" height="272"></embed> -->
<!-- </object> -->
<!--                 </div> -->
<!--                 <div class="footer_middle" style="position:relative"> -->
<!--                 <a href="support.html" style="position:absolute;width:415px;height:272px;z-index:100;"></a> -->
<!--                 <img src="__PUBLIC__/images/content_img_FindImora.png" /> -->
<!--                 <object class="object_flash" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="415" height="272"> -->
<!-- <param name="movie" value="__PUBLIC__/video/flash2.swf" /> -->
<!-- <param name="quality" value="high" /> -->
<!-- <param name="allowFullScreen" value="true" /> -->
<!-- <param value="transparent" name="wmode"> -->
<!-- <param value="opaque/" name="wmode"> -->
<!-- <param value="window" name="wmode"> -->
<!-- <embed src="__PUBLIC__/video/flash2.swf" allowfullscreen="true" wmode="transparent" flashvars="vcastr_file=2.flv&IsAutoPlay=0&LogoUrl=images/logo.jpg" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"  width="415" height="272"></embed> -->
<!-- </object> -->
<!--                 </div> -->
<!--                 <div class="footer_right" style="position:relative"> -->
<!--                 <a href="AboutOra.html" style="position:absolute;width:415px;height:272px;z-index:100;"><img src="__PUBLIC__/images/content_img_contactus.png" /></a> -->
<!--                 <object class="object_flash" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0"  width="415" height="272"> -->
<!-- <param name="movie" value="__PUBLIC__/video/flash2.swf" /> -->
<!-- <param name="quality" value="high" /> -->
<!-- <param name="allowFullScreen" value="true" /> -->
<!-- <param value="transparent" name="wmode"> -->
<!-- <param value="opaque/" name="wmode"> -->
<!-- <param value="window" name="wmode"> -->
<!-- <embed src="__PUBLIC__/video/flash3.swf" allowfullscreen="true" wmode="transparent" flashvars="vcastr_file=2.flv&IsAutoPlay=0&LogoUrl=images/logo.jpg" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"  width="415" height="272"></embed> -->
<!-- </object> -->
<!--                 </div> -->
<!--             </div> -->
            <div class="Officialwebsite_beian">
	            <p>{$T->str_foot_copyright}</p>
	        </div>
        </div>
    </div>
</body>
<script src="__PUBLIC__/js/jquery/jquery.js"></script>
<script type="text/javascript">
$(function(){
    var winWidth;//屏幕宽
    var index=0;//第几个幻灯片
    var duration=5000;//首页轮播时间间隔
    var isAutoplay=true;

    //不同分辨率的切换自适应
    $(window).on('resize',function(){
        winWidth=$(this).width();
        winWidth = winWidth > 1900?1900 : winWidth;
        $('.content_middle_c ul li').width(winWidth);
        $('.Officialwebsite_bin span:eq('+index+')').attr('noAnimate',1).click();

        //切换按钮位置调整
        $('.Officialwebsite_bin').css('paddingLeft',$('.Officialwebsite_bin').width()/2-30);

    });
    $(window).resize();

    //切换按钮
    $('.Officialwebsite_bin span').each(function(i){
        $(this).attr('i',i).on('click',function(){
            index=$(this).attr('i');
            if ($(this).attr('noAnimate')){
                $('.content_middle_c').scrollLeft(winWidth*index);
            } else {
                $('.content_middle_c').animate({'scrollLeft':winWidth*index},'normal');
            }

            $('.Officialwebsite_bin span').removeClass('active').removeAttr('noAnimate');
            $(this).addClass('active');
        }).on('mouseover',function(){
            isAutoplay=false;
        }).on('mouseout',function(){
            isAutoplay=true;
        });
    });

    //自动轮播
    setInterval(function(){
        if (!isAutoplay) return;
        var btn=$('.Officialwebsite_bin .active').next();
        if (btn.length==0){
            btn=$('.Officialwebsite_bin span:first');
        }
        btn.click();
    },5000);

})
</script>
</html>
