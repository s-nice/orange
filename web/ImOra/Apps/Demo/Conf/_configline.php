<?php
//191上橙源科技的配置文件
return array(    
		//新页面的接口路径
		'NEWPAGE_API' => 'http://106.37.218.158:8008', //时间轴、人脉图谱、地图相关数据   开发环境接口
        //'NEWPAGE_API' => 'http://54.223.148.117:8000', //时间轴、人脉图谱、地图相关数据   测试环境接口
		'DM_API_PERSONINFO' => 'http://106.37.218.158:8008', //用户个人信息 相关接口 //$rst   //测试环境  54.223.148.117:38080  //开发环境   192.168.30.251:38080);
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
                                  array('name'=>'🔎搜索',
                                        		'type'=>'view',
                                        		'key'=>'view',
                                        		'url'=>$domain . '/demo/wechat/wListZp',
                                  ),
                                  array('name'=>'👤我',
                                        'sub_button'=> array(
		                                        array(
		                                        		'type'=>'view',
		                                        		'key'=>'view',
		                                        		'url'=>$domain . '/demo/ConnectScanner/bindingPhone',
		                                        		'name'=>'绑定同步'
		                                        ),
		                                        array(
		                                        		'type'=>'view',
		                                        		'key'=>'view',
		                                        		'url'=>$domain . '/demo/ConnectScanner/showScanAll',
		                                        		'name'=>'扫描所有'
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