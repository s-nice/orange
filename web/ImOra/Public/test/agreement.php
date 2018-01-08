<?php
	$host = "http://beta-awsww.oradt.com"; // 域名
	$url = $host.'/h5/imora/agreement.html?type=applewebsite'; // url地址

	// 发送curl请求
	$ch=curl_init(); 
	$timeout=5; 
	curl_setopt($ch, CURLOPT_URL, $url); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); 
	$lines_string=curl_exec($ch); 
	curl_close($ch); 
	
	// 引入css 和js的引入源调整
	$lines_string = str_replace(array('href="/css','src="/js'), array('href="'.$host.'/css','src="'.$host.'/js'), $lines_string);
	echo $lines_string;
?>
<script type="text/javascript">
	document.title="隐私协议";
</script>

	
	