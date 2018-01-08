<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>{$T->str_title_support}</title>
<link rel="stylesheet" href="__PUBLIC__/css/Officialwebsite.css" />
<style>
.Official_Language {
    bottom: 40px;
    float: right;
    height: 20px;
    margin-right: 8px;
    margin-top: 29px;
    position: absolute;
    right: 0;
    width: auto;
}
.Official_Language span{display:block; float:left; font-size:12px; line-height:20px; font-family:'Microsoft YaHei','微软雅黑'; color:#333;}
.Official_Language span.china_span{ margin-right:8px;}
.Official_Language span.gq_span{ margin-right:28px;}
.Official_Language span.gq_span img{width:30px; height:20px;}
.Official_Language span.name_span{ margin-top:2px;}
.Official_Language span.name_span img{width:14px; height:16px;}
.Official_Language span i,.Officialwebsite_Language span em{ margin:0 4px 0 4px;}
</style>
</head>
<body>
	<div class="Officialwebsite_all">
		<div class="Officialwebsite_header">
	       <include file="Index/_headMenu"/>
        </div>
		<div class="mallindex_content_c">
			<div class="search_width">
				<div class="support_search">
					<i>{$T->str_support_01}</i>
					<em>{$T->str_support_02}</em>
<!-- 					<div class="support_divs"> -->
<!-- 						<input placeholder="{$T->str_support_03}" class="jsAskInput test" type="text"/> -->
<!-- 						<input class="button" type="button" value="{$T->str_support_04}" /> -->
<!-- 					</div> -->
				</div>
			</div>
			<div class="support_content">
				<div class="support_content_c">
					<div class="support_c_title">{$T->str_support_05}</div>
					<div class="support_c_cont">
					   <!-- 
						<p class="top_margin">
							<span>{$T->str_support_06}</span>
							<i>{$T->str_support_07}</i>
						</p>
						<p>
							<span>{$T->str_support_08}</span>
							<i>{$T->str_support_09}</i>
						</p> -->
						<foreach name="list" item="val">
						<p>
							<span>{$val.question}</span>
							<i>{$val.answer}</i>
						</p>
						</foreach>
					</div>
				</div>
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
