<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<style>
	body{background: #fff;}
	.layer_content{width: 600px; background: #fff;}
	.div_search_content {width: 600px; height: 40px; background: rgb(242,242,242); margin-bottom: 10px;}
	.btn-sub {width: 80px;  margin-top: 5px; height: 30px; line-height: 30px; font-size: 14px; color: #fff; text-align: center;display: inline-block; background: rgb(22,155,213); border-radius: 4px; float: left; cursor: pointer; margin-left: 5px;}
	.btn-search {width: 80px;  margin-top: 5px; height: 30px; line-height: 30px; font-size: 14px; color: rgb(51,51,51); text-align: center;display: inline-block; border:1px solid #CCC; border-radius: 4px; float: left; margin-left: 30px; cursor: pointer;}
	.div_search {height: 40px; float: left;line-height: 40px; margin-left: 30px;}
	.div_search span{display: inline-block; width: 60px; height: 40px; line-height: 40px; color: rgb(51,51,51); text-align: right;}
	.div_search input {width: 100px; height: 16px;}
	.div_search select {width: 100px; height: 24px;}
	.div_department {width: 600px; float: left;}
	.div_department_title {width: 600px; height: 30px; background: rgb(242,242,242);line-height: 30px; margin-bottom: 5px;}
	.span_title {display: inline-block; width: 80px; height: 30px; line-height: 30px; font-size: 14px; margin-right: 20px; margin-left: 20px;}
	.span_tab {display: inline-block; width: 20px; height: 20px; margin:5px; float: right;}
	.user_block {width: 186px; height: 96px; float: left; background: rgb(242,242,242); margin-bottom: 5px; margin-left: 5px; margin-right: 5px; border: 2px solid rgb(242,242,242);}
	.user_block p{line-height:19px; font-size: 13px; height: 19px; width: 150px; margin: 0 auto; text-align: center;}
	.user_block.act{ border: 2px solid red;}
</style>
<body>
	<div class="layer_content">
		<div class="div_search_content">
			<span class="btn-sub">{$T->str_make_sure}</span>
			<div class="div_search">
				<span>{$T->partner_title_name}：</span><input type="text">
			</div>
			<div class="div_search">
				<span>{$T->partner_title_dept}:</span>
				<select>  
				<option>销售部</option>  
				<option>售后服务部</option>  
				</select> 
			</div>
			<span class="btn-search">{$T->str_select}</span>
		</div>
		<div class="div_department">
			<div class="div_department_title">
				<span class="span_title">销售部</span><input class="js_all_check" dept-id="1" type="checkbox">{$T->str_selectall}
				<span class="span_tab"></span>
			</div>
			<div class="div_department_content">
				<div class="user_block" data_val="1" data-departid="1">
					<p class="js_user_name">黄盖</p>
					<p>销售专员</p>
					<p>销售部</p>
					<p>手机：150104203233</p>
					<p>huanggai@oradt.com</p>
				</div>
				<div class="user_block" data_val="2" data-departid="1">
					<p class="js_user_name">周瑜</p>
					<p>销售专员</p>
					<p>销售部</p>
					<p>手机：150104203233</p>
					<p>huanggai@oradt.com</p>
				</div>
				<div class="user_block" data_val="3" data-departid="1">
					<p class="js_user_name">甘宁</p>
					<p>销售专员</p>
					<p>销售部</p>
					<p>手机：150104203233</p>
					<p>huanggai@oradt.com</p>
				</div>
				<div class="user_block" data_val="4" data-departid="1">
					<p class="js_user_name">孙权</p>
					<p>销售专员</p>
					<p>销售部</p>
					<p>手机：150104203233</p>
					<p>huanggai@oradt.com</p>
				</div>
				<div class="user_block" data_val="5" data-departid="1">
					<p class="js_user_name">吕蒙</p>
					<p>销售专员</p>
					<p>销售部</p>
					<p>手机：150104203233</p>
					<p>huanggai@oradt.com</p>
				</div>
			</div>
		</div>
		<div class="div_department">
			<div class="div_department_title">
				<span class="span_title">售后服务部</span><input class="js_all_check" dept-id="2" type="checkbox">{$T->str_selectall}
				<span class="span_tab"></span>
			</div>
			<div class="div_department_content">
				<div class="user_block" data_val="6" data-departid="2">
					<p class="js_user_name">鲁肃</p>
					<p>销售专员</p>
					<p>销售部</p>
					<p>手机：150104203233</p>
					<p>huanggai@oradt.com</p>
				</div>
				<div class="user_block" data_val="7" data-departid="2">
					<p class="js_user_name">陆逊</p>
					<p>销售专员</p>
					<p>销售部</p>
					<p>手机：150104203233</p>
					<p>huanggai@oradt.com</p>
				</div>
				<div class="user_block" data_val="8" data-departid="2">
					<p class="js_user_name">程普</p>
					<p>销售专员</p>
					<p>销售部</p>
					<p>手机：150104203233</p>
					<p>huanggai@oradt.com</p>
				</div>
				<div class="user_block" data_val="9" data-departid="2">
					<p class="js_user_name">凌统</p>
					<p>销售专员</p>
					<p>销售部</p>
					<p>手机：150104203233</p>
					<p>huanggai@oradt.com</p>
				</div>
				<div class="user_block" data_val="10" data-departid="2">
					<p class="js_user_name">周泰</p>
					<p>销售专员</p>
					<p>销售部</p>
					<p>手机：150104203233</p>
					<p>huanggai@oradt.com</p>
				</div>
			</div>
		</div>
	</div>
</body>
</html>