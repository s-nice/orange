<?php
//优先级高的配置，越往后越高
$overlays = ['_config191'];//橙源科技配置文件
$domain = 'http://dev.orayun.com'; //橙源科技对外域名 
/* $overlays = ['_configaws'];//imora服务号单独的配置文件
$domain = 'http://wxww.oradt.com'; //imora服务号服务器对外域名      */
//###########

$config_ = array(
	// 配置文件
	'WECHAT_APP_VERSION'           => '1.1.8', // 版本标识
	'REPORT_CLICK_URL' => 'http://dig-visitor.oradt.com/fvisitor',

	'GET_ORADT_WEIXIN_TOKEN_URL' => $domain, //获取oradt服务器上的微信token的url
    //新页面的接口路径
    //'NEWPAGE_API' => 'http://54.223.148.117:8000', //时间轴、人脉图谱、地图相关数据   测试环境接口
/*     'NEWPAGE_API' => 'http://192.168.30.251:8000', //时间轴、人脉图谱、地图相关数据   开发环境接口
	'DM_API_PERSONINFO' => 'http://192.168.30.251:38080', //用户个人信息 相关接口 //$rst   //测试环境  54.223.148.117:38080  //开发环境   192.168.30.251:38080 */
    
    //临时图片保存路径
    'TMP_IMG_SAVE_PATH' => WEB_ROOT_DIR.'temp/cuiwechat/',
	'TOKEN_STORAGE_PATH'     => RUNTIME_PATH.'Temp/WeiXinToken', //微信发送客服消息token缓存路径
	//百度地图key
	'MAP_KEY' =>'QO8ugr8aYY6ULaYcRpWo9zPM',
	'CACHE_CLEAR' => array('LOAD_TOKEN_AGAIN'=>false),
	'SCANNER_QR_ADMIN_INFO' => array(// key扫描仪生成二维码登录账户名称,valuue 扫描仪生成二维码登录账户密码
		'adminScan@oradt.com' => 'verifyok123',
		'test@qq.com' => '123456'
	),
    'SCANNER_QRS_PREFIX'      => 'ora###', // 批量扫描仪二维码前缀
    'SCANNER_QR_PREFIX'      => 'qr###', // 单个扫描仪二维码前缀
    'COMPANY_QR_PREFIX'         => '^&^&&**(_', // toB企业生成二维码
	'WX_DEBUG_PROXY'=> array(
			'PROXY_MSG'   => true, //是否开启微信消息调试代理模式
			'PROXY_ADDRESS'=>'http://192.168.71.20', //代理服务器地址
			'USER_OPENID' => array('ofIP5vnuTl1UTMpiIu3pO4_mRQ90'), //定义走代理模式的用户openid
			),
	'WX_TOKEN_SAVE_MODE' => 'file', //获取微信token方式：redis、file
  

    'EXPORT_EXCEL_COUNT'=>500,

);

for ($i = 0; $i < count($overlays); $i++) {
    $tmp_ = include_once $overlays[$i].'.php';
    $config_ = array_merge($config_, $tmp_);
}
//print_r($config_);die;
return $config_;