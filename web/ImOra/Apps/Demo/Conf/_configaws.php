<?php
//aws上IMORA服务号的配置文件
return array(
		//新页面的接口路径
		'NEWPAGE_API' => 'http://172.20.14.176:8000', //时间轴、人脉图谱、地图相关数据   测试环境接口
		'DM_API_PERSONINFO' => 'http://172.20.14.176:38080', //用户个人信息 相关接口 //$rst   //测试环境  54.223.148.117:38080  //开发环境   192.168.30.251:38080
		//redis配置
		'WX_REDIS_HOST' => 'api-redis.hujbcb.0001.cnn1.cache.amazonaws.com.cn', //连接redis地址,外网：54.223.22.102
		'WX_REDIS_PORT' => '6379', // redis端口 外网：8000
		// 微信配置
		'Wechat'           => array (
			'AppID'             => 'wx80d6df38b688339d',
			'AppSecret'         => '245494137374df49582181ca9831f4e1',
			'Token'             => 'weixinora',
			'EncodingAESKey'    => 'TuLlHYBbc4EZ9DQe11fTnImI3MUXsSaAL5yngUjVjL6',
			'menu'              => array (
	                    'button' => array (
	                          array('name'=>'识别',//➕
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
		                             /*          array(
		                                      		"type"=>"click",
		                                      		"name"=>"退出扫描",
		                                      		"key"=>"rselfmenu_0_3",
		                                      ) */
		                                  	)
	                                ),
                                  array('name'=>'搜索', //🔎
                                        		'type'=>'view',
                                        		'key'=>'view',
                                        		'url'=>$domain . '/demo/wechat/wListZp',
                                  ),
                                  array('name'=>'我', //👤
                                        'sub_button'=> array(
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
                                        )
                                  ),	
	                        )
	                )
		)
);