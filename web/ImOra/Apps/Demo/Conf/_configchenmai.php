<?php
//191上橙脉的配置文件
return array(    
		//新页面的接口路径
		'NEWPAGE_API' => 'http://192.168.30.251:8000', //时间轴、人脉图谱、地图相关数据   开发环境接口
		'DM_API_PERSONINFO' => 'http://192.168.30.251:38080', //用户个人信息 相关接口 //$rst   //测试环境  54.223.148.117:38080  //开发环境   192.168.30.251:38080);
	    // 微信配置
	    'Wechat'           => array (
	        'AppID'             => 'wx4a05b212ff1a53e3',
	        'AppSecret'         => '2f214b649d94d331c978ab6447d62028',//wx4a05b212ff1a53e3
	        'Token'             => 'weixinchenmai',
	        'EncodingAESKey'    => 'qIs6ZCdT5J7pYvBJXmAh0JwclE71uGQ1t2Zms6snMft',
	        'menu'              => array (
	                    'button' => array (
	                                  array('name'=>'名片识别',
	                                                        'type'=>'view',
	                                                        'key'=>'view',
	                                                        'url'=>$domain . '/demo/wechat/showUpload',
	                                  ),
	                                  array('name'=>'朋友圈',
	                                        				'type'=>'view',
	                                        				'key'=>'view',
	                                        				'url'=>$domain . '/demo/wechat/wListZp',
	                                  ),
	                                  array('name'=>'我',
	                                        'sub_button'=> array(
	                                        		array(
	                                        				'type'=>'view',
	                                        				'key'=>'view',
	                                        				'url'=>$domain . '/demo/wechat/showUploadSide',
	                                        				'name'=>'正反面名片识别'),
	                                        		array(
	                                        				'type'=>'view',
	                                        				'key'=>'view',
	                                        				'url'=>$domain . '/demo/wechat/wDetailZp/isMenu/1',
	                                        				'name'=>'我的名片'),
	                                        		array(
	                                        				'type'=>'view',
	                                        				'key'=>'view',
	                                        				'url'=>$domain . '/demo/page/timeline',
	                                        				'name'=>'历史足迹'),
	                                        		array(
	                                        				'type'=>'view',
	                                        				'key'=>'view',
	                                        				'url'=>$domain . '/demo/wechat/qrCode',
	                                        				'name'=>'二维码ID'),
	                                        )
	                                  ),
	
	                        )
	                )
	    ),
		);