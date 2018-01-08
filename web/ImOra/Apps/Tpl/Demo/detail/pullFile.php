<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>{$T->str_onekey_export}</title>
	<script src="__PUBLIC__/js/oradt/H5/fontSize.js?v={:C('WECHAT_APP_VERSION')}?v={:C('WECHAT_APP_VERSION')}"></script>
    <link rel="stylesheet" href="__PUBLIC__/css/detailOra.css?v={:C('WECHAT_APP_VERSION')}" />
</head>
<body>
	<section class="pull_main">
		<div class="pull_secuss">
			<span>{$T->str_onekey_export_sent_success}</span>
		</div>
		<div class="pull_center">
			<div class="pull_font">
				{$T->str_onekey_export_sendto_email}
			</div>
			<div class="pull_text">
				<input type="text" value="279106639@qq.com" />
			</div>
			<div class="pull_btn">
				<button class="btn" type="button">{$T->str_onekey_export_confirm}</button>
			</div>
		</div>
	</section>
</body>
</html>