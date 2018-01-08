 <?php
			include_once WEB_ROOT_DIR . '../Libs/Classes/GFunc.class.php';
			import ( 'Factory', LIB_ROOT_PATH . 'Classes/' );
			$th = Classes\GFunc::getUiLang ();
			
			$globalPopFile = WEB_ROOT_DIR . '../Apps/Lang/' . $th . '.xml';
			$T = Classes\Factory::getTranslator ( $globalPopFile, 'xml' );
			
			// 解决项目配置方法不同时找不到路径的问题
			$projectPath = '';
			$path = $_SERVER ['PHP_SELF'];
			$pathArr = parse_url ( $path );
			
			if (($index = stripos ( $path, '/PUBLIC/' )) !== false) {
				$projectPath = substr ( $path, 0, $index + 7 );
			}
			$projectPath = 'http://' . $_SERVER ['HTTP_HOST'] . $projectPath;
			$errInfo = array (
					strip_tags ( $e ['message'] ),
					isset ( $e ['file'] ) ? $e ['file'] . '&#12288;LINE:' . $e ['line'] : '',
					isset ( $e ['trace'] ) ? nl2br ( $e ['trace'] ) : '' 
			);
			Think\log::write ( 'File:' . __FILE__ . ' LINE:' . __LINE__ . "\r\n" . ' ' . var_export ( $errInfo, true ) );
			?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $T->title_service_opera_fail; ?></title>
<style>
body,ul,ol,li,dl,dt,dd,p,h1,h2,h3,h4,h5,h6,form,fieldset,table,tr,td,img,div
	{
	margin: 0;
	padding: 0;
	border: 0;
	float: none;
}

body {
	font-size: 12px;
	font-family: '微软雅黑', 'Tahoma', '黑体', '宋体';
	background: url(<?php echo $projectPath;?>/images/body_repeat.png);
}

body,html {
	min-width: 1200px;
	height: 100%;
}
/*html,body{width:100%;}*/
ul,ol {
	list-style-type: none;
}

em,i,cite,u {
	font-style: normal;
}

select,input {
	vertical-align: middle;
}

img,embed {
	vertical-align: top;
	border: none;
}

a {
	text-decoration: none;
	color: #666666;
	outline: medium none;
	font-family: '宋体';
}

a:hover {
	color: #0075c2;
	text-decoration: none;
}

.font {
	
}

.left {
	float: left
}

.right {
	float: right;
}

.clear {
	clear: both;
}

textarea {
	overflow: auto;
	resize: none;
}

.clear:after {
	clear: both;
	content: '';
	display: block
}

.clear {
	zoon: 1;
}

.button_confirm {
	background: #ff6600 none repeat scroll 0 0;
	border: medium none;
	border-radius: 2px;
	color: #fff;
	float: left;
	font: 14px/40px "微软雅黑";
	margin-right: 8px;
	text-align: center;
	width: 140px;
}

.button_concel {
	background: #666 none repeat scroll 0 0;
	border: medium none;
	border-radius: 2px;
	color: #fff;
	float: left;
	font: 14px/40px "微软雅黑";
	margin-right: 8px;
	text-align: center;
	width: 140px;
}

.page_box .clsPrePage {
	cursor: pointer;
}

.page_box .clsNextPage {
	cursor: pointer;
}

.Nopermission_all {
	width: 100%;
	height: auto;
	overflow: hidden;
}

.Nopermission_content {
	width: 1200px;
	height: 600px;
	background: #000;
	margin: 0 auto;
	margin-top: 200px;
}

.Nopermission_c {
	width: 420px;
	height: 170px;
	margin: 0 auto;
	padding-top: 230px;
}

.Nopermission_left {
	width: 57px;
	height: 74px;
	float: left;
	margin-right: 33px;
}

.Nopermission_left img {
	width: 57px;
	height: 74px;
}

.Nopermission_right {
	width: 330px;
	height: 170px;
	float: left;
}

.Nopermission_right span,.Nopermission_right i,.Nopermission_right em {
	display: block;
}

.Nopermission_right span {
	color: #fff;
	font: 22px/22px "微软雅黑";
	margin-bottom: 14px;
}

.Nopermission_right i {
	color: #999;
	font: 14px/14px "微软雅黑";
}

.Nopermission_bin {
	width: 264px;
	height: 32px;
}

.Nopermission_bin em {
	float: left;
	width: 122px;
	height: 32px;
	background: #666;
	margin-top: 45px;
	color: #fff;
	font: 14px/32px "微软雅黑";
	text-align: center;
	-webkit-border-radius: 2px 2px;
	-moz-border-radius: 2px 2px;
	-o-border-radius: 2px 2px;
	-ms-border-radius: 2px 2px;
	border-radius: 2px 2px;
}

.Nopermission_bin em.left_em {
	width: 122px;
	height: 32px;
	color: #fff;
	font: 14px/32px "微软雅黑";
	text-align: center;
	background: #ff6600;
	margin-right: 20px;
}

.clickbin {
	cursor: pointer;
}
</style>
<script src="<?php echo $projectPath;?>/js/jquery/jquery.js"></script>
</head>

<body>
	<div class="Nopermission_all">
		<div class="Nopermission_content">
			<div class="Nopermission_c">
				<div class="Nopermission_left">
					<img src="<?php echo $projectPath;?>/images/Error_Failureicon.png" />
				</div>
				
				<div class="Nopermission_right">
					<span><?php echo $T->str_service_opera_fail;?>
						<!--非常抱歉，服务器操作失败~--></span> <i><?php echo $T->str_please_check_service_excption;?>
						<!--请检查服务器是否正常--></i>
					<div class="Nopermission_bin">
						<em class="left_em clickbin cls_page_refresh"><?php echo $T->btn_refresh;?>
							<!--刷新--></em> <em class="right_em clickbin cls_page_return"><?php echo $T->btn_return;?>
							<!--返回--></em>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<?php 
    if ($_REQUEST['__DEV_CHECK_LOG__']){
        echo strip_tags($e['message']);
        echo '<br>
';
        echo 'FILE：'.$e['file'] ;
        echo '<br>
';
        echo 'TRACE：'.nl2br($e['trace']);
        echo '<br>
';
    }
?>
<script type="text/javascript">
	$(function(){
		$('.cls_page_refresh').click(function(){
			window.location.reload();
		});
		$('.cls_page_return').click(function(){
			window.history.back();
		});
	});
</script>