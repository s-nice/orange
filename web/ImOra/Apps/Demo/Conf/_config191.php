<?php
//191上橙源科技的配置文件
return array(    
		//新页面的接口路径
		'NEWPAGE_API' => 'http://192.168.30.251:8000', //时间轴、人脉图谱、地图相关数据   开发环境接口
        //'NEWPAGE_API' => 'http://54.223.148.117:8000', //时间轴、人脉图谱、地图相关数据   测试环境接口
		'DM_API_PERSONINFO' => 'http://192.168.30.251:38080', //用户个人信息 相关接口 //$rst   //测试环境  54.223.148.117:38080  //开发环境   192.168.30.251:38080);
		'WX_REDIS_CHANNEL' => array('wx_api','wx_selfdefine','wx_wechat'), // 微信记录日志频道
		//redis配置
		'WX_REDIS_HOST' => '192.168.30.109', // 默认192.168.30.109
		'WX_REDIS_PORT' => '6379', // 9001?
		'WX_REDIS_DB_HOST' => '192.168.30.192:3306',
		'WX_REDIS_DB_NAME' => 'imora_log',
		'WX_REDIS_DB_USER' => 'wangkilin',
		'WX_REDIS_DB_PASS' => '4728999',
	    // 微信配置
	    'Wechat'           => array (
	        'AppID'             => 'wxd74253d6ee55fe12',
	        'AppSecret'         => 'ecd90fa62cd26bb716ebad464fca2fda',
	        'Token'             => 'weixin',
	        'EncodingAESKey'    => 'S0vTZ2ZhED24Fo5kt4niVIaHWjdKOHumV4GBoN1sGH0',
	        'menu'              => array (
	                    'button' => array (
	                          array('name'=>'➕识别',
	                                  	'sub_button'=> array(
	                                  		array(      
                                  					 'type'=>'view',
                                                     'key'=>'view',
                                                     'url'=>$domain . '/demo/wechat/showUpload',
                                                     'name' => '拍照'
	                                  		   ),
		                                      array(                         
		                                            "type"=>"scancode_push", 
								                    "name"=>"扫描", 
								                    "key"=>"rselfmenu_0_1", 
								                    "sub_button"=> [ ]
		                                      ),
		                                      array(      
                                  					 'type'=>'view',
                                                     'key'=>'view',
                                                     'url'=>$domain . '/demo/wechat/oneKeyExport',
                                                     'name' => '一键导出'
	                                  		   ),
		                                      array(
		                                      		"type"=>"click",
		                                      		"name"=>"任意扫",
		                                      		"key"=>"rselfmenu_0_2",
		                                      		"sub_button"=> [ ]
		                                      ),
		                                      array(
		                                      		'type'=>'view',
		                                      		"name"=>"地图",
		                                      		'url'=>$domain . '/demo/page/addressList',
		                                      )
		                                  	)
	                                ),
                                    array('name' => '🔎名片夹',
                                        'sub_button' => array(
                                            array(
                                                'type' => 'view',
                                                'key' => 'view',
                                                'url' => $domain . '/demo/wechat/wListZp',
                                                'name' => '个人名片',
                                            ),
                                            array(
                                                'type' => 'view',
                                                'key' => 'view',
                                                'url' => $domain . '/demo/CompanyCard/bizCardList',
                                                'name' => '企业名片',
                                            ),
                                        )
                                    ),
                                  array('name'=>'👤我',
                                        'sub_button'=> array(
//		                                        array(
//		                                        		'type'=>'view',
//		                                        		'key'=>'view',
//		                                        		'url'=>$domain . '/demo/ConnectScanner/bindingPhone',
//		                                        		'name'=>'绑定同步'
//		                                        ),
                                                array(
                                                    'type'=>'view',
                                                    'key'=>'view',
                                                    'url'=>$domain . '/demo/CompanyExtend/register',
                                                    'name'=>'我的企业'
                                                ),
		                                        array(
		                                        		'type'=>'view',
		                                        		'key'=>'view',
		                                        		'url'=>$domain . '/demo/ConnectScanner/href',
		                                        		'name'=>'测试'
		                                        ),
                                        		array(
                                        				'type'=>'view',
                                        				'key'=>'view',
                                        				'url'=>$domain . '/demo/wechat/wDetailZp/isMenu/1',
                                        				'name'=>'我的名片'
                                        			 ),
                                        		array(
                                        				'type'=>'view',
                                        				'key'=>'view',
                                        				'url'=>$domain . '/demo/page/map',
                                        				'name'=>'人脉360'
                                        			),
                                        		array(
                                        					'type'=>'view',
                                        					'key'=>'view',
                                        					'url'=>$domain . '/demo/ConnectScanner/qrCodeAdmin',
                                        					'name'=>'橙橙'
                                        		),
/*                                         		array(
		                                        		'type'=>'view',
		                                        		'key'=>'view',
		                                        		'url'=>$domain . '/Appadmin/Login/wx',
		                                        		'name'=>'支付'
		                                        ), */
                                        )
                                  ),	
	                        )
	                )
	    ),
		);