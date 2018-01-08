<?php
use BaseController\BaseController;

return array(
        'APP_VERSION'           => '3.1.19.6', // 版本标识。
        'DEFAULT_MODULE'        =>  'Home',  // 默认模块
        // 基本配置。 ！！！不要修改！！！
        'COOKIE_KEY' 			=> 'oradt!123',
        'SESSION_AUTO_START' 	=> true, // set session start automatically
        'DEFAULT_CHARSET' 		=> 'utf-8', // set webpage charset
        'DEFAULT_LANGUAGE' 		=> 'zh-cn', // set the UI default language
        'SUPPORT_LANGUAGES'		=> 'zh-cn,ja', // the supported languages
        'ALLOW_USER_SEE_INTRO'	=> false,	// if allow the registered user to see the production info

        // 模板参数。！！！不要修改！！！
        'TMPL_VAR_IDENTIFY'     => '',
        'TMPL_TEMPLATE_SUFFIX'  => '.php', // 模板文件名后缀
        'TMPL_FILE_DEPR'        => '/', // the separator used in template file between Module name and Action name
        'TMPL_PARSE_STRING'     => array('__PUBLIC__' => __ROOT__,),
        'DEFAULT_M_LAYER'       => '', // 模板默认类名后缀为空

        // 优化配置。 ！！！不要修改 ！！！
        'URL_HTML_SUFFIX'       => '.html', //伪静态
        'URL_CASE_INSENSITIVE'  => true, //
        'URL_MODEL'             => 2, // SEO way to render URL
        'AUTOLOAD_NAMESPACE'    => array(
                                      'Model'          => APP_PATH .'Lib/Model/',
                                      'Classes'        => LIB_ROOT_PATH . 'Classes/',
                                      'BaseController' => APP_PATH . 'Lib/BaseController/',
                                      'Hooks'          => APP_PATH . 'Lib/Hooks/',
                                   ),
        'LOAD_EXT_FILE'         => 'AppTools,common',
        'LOAD_EXT_CONFIG'       => 'ApiInterfaceMaps,ApiInterfaceMapsWechat', // the extended config files to be loaded
        'WEB_SERVICE_ROOT_URL'  => 'http://192.168.30.191:9999', // 运营后台 API 根路径
		'WEB_SERVICE_ROOT_URL_WECHAT'  => 'http://192.168.30.191:9996', //公众号API地址
        'ORANGE_WEB_SERVICE_URL'=> 'http://101.251.193.27:81', // ORANGE 定义数据抓取规则 API 根路径
	    'ORANGE_EXTRACT_RULE_SERVICE_URL'=> 'http://192.168.228.8:8974', // ORANGE 提取规则(预警信息规则) API 根路径
	    'API_LOGIN_URL'         => '/oauth', // 鉴权路径
		'LOG_EXCEPTION_RECORD'  => 	true,    // 是否记录异常信息日志
		'TMPL_EXCEPTION_FILE'   =>  WEB_ROOT_DIR.'../Apps/Tpl/Public/serverFailure.php',// 异常页面的模板文件,debug模式有效
		'URL_404_REDIRECT'      =>  '/Appadmin/Public/error404', // 404 跳转页面 部署模式有效
	    'UPLOAD_PATH'           =>  WEB_ROOT_DIR . 'temp/Upload/', //上传目录

        // 调试模式
        'SHOW_PAGE_TRACE'       => false,
		'DEBUG_TYPE_INT'        => 1, // 日志记录开关 0 不记录任何日志 1 管理员操作日志

		/* 名片相关目录 */
		'TEMPLATE_ZIP_URL'      => APP_PATH.'Static/test.zip',
		'CARD_STORAGE_PATH'     => RUNTIME_PATH.'Temp/Cards',
		'CARD_DEFAULT_FONT'     => APP_PATH.'Static/default.ttf',
		'CARD_DOWNLOAD_PATH'    => WEB_ROOT_DIR.'temp/Cards/', // 下载名片的路径
		/* 客服数据 */
		'CUSTOMERINFO'          => array(
		        'email'    => '',
                'telphone' => '4008987518',
                'web'      => 'http://www.imora.cn',
                'title'    => '客服'),

        /* 统计数据库配置信息 DB setting */
        'DB_TYPE'               => 'mysql',     // 数据库类型
        'DB_HOST'               => '192.168.30.192', // 数据库主机地址
        'DB_NAME'               => 'statistics_20160504',          // 数据库名称
        'DB_USER'               => 'wangkilin',      // 连接数据库用户名
        'DB_PWD'                => '4728999',          // 数据库密码
        'DB_PORT'               => '',        // 端口， 默认是3306
        'DB_PREFIX'             => '',    // 数据库表前缀
        'DB_SQL_LOG'            => true, // 是否将SQL语句写入到日志文件
        'EMPTYDB'				=> '', // 必须为空，方便切换到公共数据库中
		// 企业后台数据库配置信息
/* 		'COMPANYDB'=> array(
            	'db_type' => 'mysql',  // 数据库类型
            	'db_user' => 'userdev', // 数据库用户名
            	'db_pwd'  => 'user_dev', // 数据库密码
            	'db_host' => '192.168.30.192', // 数据库主机
            	'db_port' => '3306', // 端口
            	'db_name' => 'oradt_cloud1520', // 数据库名称
            	'db_charset' => 'utf8' // 数据库字符编码
            ), */
		// 运营后台数据库配置信息
		'APPADMINDB'=> array(
            	'db_type' => 'mysql',  // 数据库类型
            	'db_user' => 'userdev', // 数据库用户名
            	'db_pwd'  => 'user_dev', // 数据库密码
            	'db_host' => '192.168.30.192', // 数据库主机
            	'db_port' => '3306', // 端口
            	'db_name' => 'oradt_cloud1520', // 数据库名称
            	'db_charset' => 'utf8' // 数据库字符编码
            ),
        // 运营后台邮寄名片数据库配置
        'APPADMINDB_EMAIL'=> array(
                'db_type' => 'mysql',  // 数据库类型
                'db_user' => 'imora_scan', // 数据库用户名
                'db_pwd'  => '123456', // 数据库密码
                'db_host' => '192.168.30.192', // 数据库主机
                'db_port' => '3306', // 端口
                'db_name' => 'imora_scan', // 数据库名称
                'db_charset' => 'utf8' // 数据库字符编码
            ),
		//im websocket地址
		'IM_SERVER_IP'          => '192.168.30.17',//IM服务器IP地址 123.57.146.39
		'IM_SERVER_PORT'        => '5123',//IM服务器监听端口
		'WEB_SOCKET_URL'        => '192.168.30.17:9999',//IM服务器监听的websocket 服务端口
		'WEB_SOCKET' => array(
				'START_LOG'            => true, //是否启用日志记录
				'URL_BINARY_UPLOAD'    => 'http://192.168.30.17:10080/welcome/upload',//二进制文件上传路径
				'URL_BINARY_DOWNLOAD'  => 'http://192.168.30.17:8090', //二进制下载路径
				'SNS_ACTIVE_FILE_PATH' => WEB_ROOT_DIR . 'temp/sns/activejsonfile/', //活动json文件存放路径
				'SNS_BINARY_FILE_PATH_VCARD' => WEB_ROOT_DIR . 'temp/sns/vcard',
				'SNS_BINARY_FILE_PATH' => WEB_ROOT_DIR . 'temp/sns',
				'IM_UPLOAD_IMAGE_SIZE' => 2 , //IM发送图片最大限制
		),

        //橙脉小秘书
        'ORA_DOMAIN' =>'http://www.imora.cn/',

        //phantomjs路径
        'PHANTOMJS_DIR'=>dirname(WEB_ROOT_DIR).DIRECTORY_SEPARATOR."Apps".DIRECTORY_SEPARATOR."Static".DIRECTORY_SEPARATOR.'phantomjs'.DIRECTORY_SEPARATOR,

        // APP 软件安装包下载配置
        'IOS_APP_STORE_ID'       => 1040400126, // IOS APP在苹果App Store上的ID。
        'ANDROID_APP_LINK'       => 'http://dev.orayun.com/temp/SoftwareUpdate/App/OraMain-develop-debug.apk', // 安卓App下载地址
		'SCANNER_QR_CODE_KEY'    => '1m02a!123@OraInc', // 加密程序中的key值
		'URL_TO_INVOKE_ANDROID_APP' => 'imora://imora.ecard', // H5中唤起android APP使用的协议
        //'URL_TO_INVOKE_IOS_APP'  => 'http://a.mlinks.cc/Aaif', // H5中唤起IOS APP使用的协议
		'URL_TO_INVOKE_IOS_APP'  => 'https://axpskr.mlinks.cc/AaLY', // H5中唤起IOS APP使用的协议
		'CONFIG_99BILL_AcctId'   => '1001213884201', // 接收款项的人民币账号 必填
		'PEM_99BILL'             => WEB_ROOT_DIR . 'test/99bill/demo/pcarduser.pem', // 快钱支付证书路径
        'H5_FILMIC_PATH'         => 'https://s3.cn-north-1.amazonaws.com.cn/videoshare/',//映画App h5分享视频 路径
        //公众号企业版
        'GET_ORADT_WEIXIN_TOKEN_URL' =>'http://dev.orayun.com', //获取oradt服务器上的微信token的url
);
/* EOF */
