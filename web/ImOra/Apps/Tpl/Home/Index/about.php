<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>{$T->str_title_about}</title>
<link rel="stylesheet" href="__PUBLIC__/css/Officialwebsite.css" />
<style>

.Officialwebsite_c {
    height: auto;
    background-image: url("__PUBLIC__/images/about_ora_bg.jpg");
    background-repeat: no-repeat;
    background-position: center top;
}

.Officialwebsite_c .imora_content_title
{
margin: 0 auto;
width: 1200px;
padding:250px 0 0;
}
.imora_content_title p
{
text-align: center;
}
.imora_content_title .big
{
font-size:72px;
color: #333;
}
.imora_content_title .line
{
width:142px;
border:none;
height:1px;
border-bottom:1px solid;
padding: 10px 0 0;
}
.imora_content_title .small
{
font-size:24px;
margin: 50px 0 0;
color: #333;
}
.imora_content_title .logo
{
padding:90px 0 0;
}
.content_middle_c ul li.first_li {
    background-position: center center;
    background-repeat: no-repeat;
    background-size: auto;
}
.imora_content_company{margin: 0 auto;
    width: 1200px;}
.imora_content_company .english
{
    font-size: 36px;
    margin: 0 auto;
    padding: 35px 0 0;
    text-align: center;
    width: 800px;
    color: #555;
}
.imora_content_company .chinese
{
font-family:'Microsoft YaHei','微软雅黑';
    font-size: 30px;
    margin: 0 auto;
    padding: 35px 0 0;
    text-align: center;
    width: 800px;
    color: #555;
}
.imora_content_company .chinese_small
{
font-family: 'Microsoft YaHei','微软雅黑';
    font-size: 18px;
    margin: 0 auto;
    text-align: center;
    width: 800px;
    color: #666;
}
.Officialwebsite_c .imora_content_info_1
{
margin:100px auto 0;
width:1200px;
}
.imora_content_info_1 p
{
height: auto;
overflow:hidden;
}
.imora_content_info_1 span
{
color: #666;
    float: left;
    font-size: 14px;
    width: 330px;
    text-align:center;
    line-height: 24px;
}
.imora_content_info_1 span.middle
{

padding:0 105px;
}
.imora_content_info_1 .title
{
color: #333;
font-size: 24px;
font-weight: normal;
margin: 55px auto;
 float: left;
    width: 100%;
}
.Officialwebsite_c .imora_content_img
{
width:1200px;
margin:0 auto;
margin-top: 162px;
}
.imora_content_img img
{
}
.Officialwebsite_c .imora_content_info_2
{
margin: 0 auto ;
height:auto;
width: 1000px;
margin-top:125px;
overflow:hidden;
}
.imora_content_info_2 p
{
float: left;
    padding: 0 30px;
    width: 440px
}
.imora_content_info_2 span
{
float: left;
width: 100%;
color:#666;
font-size:14px;
line-height: 26px;
}
.imora_content_info_2 .title
{
font-weight: normal;
float: left;
width: 100%;
margin: 55px 0;
font-size:24px;
color: #333;
}
.imora_content_info_2 p.left
{
text-align:right;
}
.imora_content_info_2 p.right
{
text-align:left;
margin: 80px 0 0;
}
.imora_content_info_2 p.right span
{
float: left;
    width: 100%
}
.imora_content_info_2 p.right .title
{
}
.Officialwebsite_Language_foot {
    bottom: 40px;
    float: right;
    height: 20px;
    margin-right: 8px;
    margin-top: 29px;
    position: absolute;
    right: 0;
    width: auto;
}
.Officialwebsite_Language_foot span{display:block; float:left; font-size:12px; line-height:20px; font-family:'Microsoft YaHei','微软雅黑'; color:#333;}
.Officialwebsite_Language_foot span.china_span{ margin-right:8px;}
.Officialwebsite_Language_foot span.gq_span{ margin-right:28px;}
.Officialwebsite_Language_foot span.gq_span img{width:30px; height:20px;}

.Officialwebsite_APP_beian {
    height: 67px;
    margin: 123px auto 0;
    position: relative;
    width: 310px;
}
</style>
</head>
<body>
	<div class="Officialwebsite_all">
		<div class="Officialwebsite_header">
			<include file="Index/_headMenu"/>
		</div>
		<div class="Officialwebsite_c">
			<div class="imora_content_title">
			  <p class="big">{$T->str_about_01}</p>
			  <hr class="line"/>
              <p class="small">{$T->str_about_02}</p>
              <p class="logo"><img src="__PUBLIC__/images/about_ora_black_logo.png"/></p>
			</div>
            <div class="imora_content_company">
              <!-- <p class="english">{$T->str_about_03}</p> -->
              <p class="chinese">{$T->str_about_04}</p>
              <p class="chinese_small">{$T->str_about_05}</p>
            </div>
            <div class="imora_content_info_1">
              <p>
                <span>
                  <b class="title">{$T->str_about_06}</b>
                  {$T->str_about_07}
                </span>
                <span class="middle">
                  <b class="title">{$T->str_about_08}</b>
                  {$T->str_about_09}
                </span>
                <span>
                  <b class="title">{$T->str_about_10}</b>
                  {$T->str_about_11}
                </span>
              </p>
              <p>
                <span>
                  <b class="title">{$T->str_about_12}</b>
                  {$T->str_about_13}
                </span>
                <span class="middle">
                  <b class="title">{$T->str_about_14}</b>
                 {$T->str_about_15}
                </span>
                <span>
                  <b class="title">{$T->str_about_16}</b>
                  {$T->str_about_17}
                </span>
              </p>
            </div>
            <div class="imora_content_img">
              <p ><img src="__PUBLIC__/images/about_ora_content_img.jpg"/></p>
            </div>
            <div class="imora_content_info_2">
              <p class="left">
                <span>
                  <b class="title">{$T->str_about_18}</b>
                  {$T->str_about_19}<br/>
                  {$T->str_about_191}<br/>
                  {$T->str_about_192}<br/>
                  {$T->str_about_193}<br/>
                </span>
                <span>
                  <b class="title">{$T->str_about_21}</b>
                    {$T->str_about_22}<br/>
                    {$T->str_about_23}<br/>
                    {$T->str_about_24}<br/>
                    {$T->str_about_25}<br/>
                </span>
                <span>
                  <b class="title">{$T->str_about_30} </b>
                  {$T->str_about_31}<br/>
                  {$T->str_about_32}<br/>
                  {$T->str_about_33}<br/>
                  {$T->str_about_34}
                </span>
              </p>
              <p class="right">
                <span>
                  <b class="title">{$T->str_about_35}</b>
                    {$T->str_about_36}<br/>
                </span>
                <span>
                  <b class="title">{$T->str_about_41} </b>
                  {$T->str_about_42}
                </span>
                <span>
                  <b class="title">{$T->str_about_43}</b>
                    {$T->str_about_44}<br/>
                    {$T->str_about_45}<br/>
                    {$T->str_about_46}<br/>
                    {$T->str_about_47}
                </span>
              </p>
            </div>
            <div class="imora_content_bin">
            	<div class="bin_left"><span><a href="">{$T->str_about_48}</a></span></div>
            	<div class="bin_right"><span><a href="{:U('Home/Index/join')}">{$T->str_title_join}</a></span></div>
            </div>
		</div>
    	<div class="Officialwebsite_APP_footer">
<!--     		<div class="search_footer"> -->
<!--     			<span class="name">{$T->str_search_label}</span> -->
<!--     			<span class="right_input"> -->
<!--     				<input type="text" class="text_input" /> -->
<!--     				<input type="button" class="button_input" value="{$T->str_search_btn}" /> -->
<!--     			</span> -->
<!--     		</div> -->
    		<div class="Officialwebsite_APP_beian">
    			<p>{$T->str_foot_copyright}</p>
    		</div>
    	</div>
	</div>
</body>
</html>
