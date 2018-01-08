<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>{$T->str_title_join}</title>
<link rel="stylesheet" href="__PUBLIC__/css/Officialwebsite.css" />
<style>
.Officialwebsite_c {
    height: auto;
    background-image: url("__PUBLIC__/images/join_ora_bg.jpg");
    background-repeat: no-repeat;
    background-position: center top;
}
.Officialwebsite_c .imora_content_title
{
margin: 0 auto;
width: 1300px;
padding:260px 0 0;
}
.imora_content_title p
{
text-align: center;
}
.imora_content_title .big
{
font-size:72px;
font-family:微软雅黑,AvenirLT;
color: #333;
}
.imora_content_title .line
{
width:142px;
border:none;
height:1px;
border-bottom:1px solid;
padding: 35px 0 0;
}
.imora_content_title .small
{
font-size:24px;
font-family:AvenirLT,微软雅黑;
margin: 35px 0 0;
color: #333;
}
.imora_content_company{margin: 0 auto;margin-top:505px; width: 1300px; padding-bottom:49px; border-bottom:1px solid #eee; overflow:hidden;}
.imora_content_company span{ display:block; margin-bottom:32px;}
.imora_content_company .english
{
font-family: AvenirLT,微软雅黑;
    font-size: 18px;
    padding: 8px 0 0 0;
    width: 800px;
    color: #333;
    display:block;
    line-height:18px;
}
.imora_content_company .chinese
{
font-family:'Microsoft YaHei','微软雅黑';
    font-size: 30px;
    width: 800px;
    color: #333;
    font-weight:normal;
    display:block;
    line-height:30px;
}
.imora_content_company p
{
font-family: 'Microsoft YaHei','微软雅黑';
    font-size: 14px;
    width: 100%;
    color: #333;
    line-height:24px;
}
.imora_content_company p.p_english{
	font-family: 'Microsoft YaHei','微软雅黑';
    font-size: 14px;
    width: 100%;
    color: #999;
    line-height:16px;
    margin-top:15px;
}
.imora_content_info_1{margin: 0 auto;
    width: 1300px; overflow:hidden; padding-bottom:100px;}

.Officialwebsite_APP_beian {
    height: 67px;
    margin: 123px auto 0;
    width: 310px;
}
blockquote{
	margin: 0 0 0 12px;
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
			  <p class="big">{$T->str_join_01}</p>
			  <hr class="line"/>
              <p class="small">{$T->str_join_02}</p>
			</div>
			<div class="imora_content_company">
              	<span>
                	<b class="chinese">{$T->str_join_03}</b>
                	<i class="english">{$T->str_join_04}</i>
                </span>
                <p>{$T->str_join_05}</p>
				<p class="p_english"><?php echo urldecode($T->str_join_06);?></p>
            </div>
            <div class="imora_content_info_1">
                <foreach name="list" item="val">
                <h2>{$T->str_join_07}{$val.title}</h2>
              	{$val.content}
                </foreach>
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
