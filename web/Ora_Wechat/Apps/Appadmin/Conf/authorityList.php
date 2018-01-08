<?php
return array(
        'AuthorityList'=>array(
                //例子 我的面板  总功能
                'mypanel'=>array(
                        'name'=>'mypanel',
                        'text' => "str_mypanel",//设置    翻译
                        'children' => array(//设置里面包含的各个子功能
                                'modify_info'=>array(
                                        'name'=>'modify_info',
                                        'text'=>'modify_info',//翻译    管理员管理
                                        //每个子功能对应N个controller和action
                                        'access'=>array(
                                                array('ctr'=>'Index','act'=>'index,showModifyPage,modifyInfo')
                                        )),
                                'modify_passwd'=>array(
                                        'name'=>'modify_passwd',
                                        'text'=>'modify_passwd',//角色管理
                                        'access'=>array(
                                                array('ctr'=>'Index','act'=>'modifyPasswd,getOldPasswd'),
                                        )),

                        )
                ),
			//例子 企业管理
			'companyInfo'=>array(
				'name'=>'companyInfo',
				'text' => "企业管理",//设置    翻译
				'children' => array(//设置里面包含的各个子功能
					'list'=>array(
						'name'=>'list',
						'text'=>'企业信息列表',//翻译
						//每个子功能对应N个controller和action
						'access'=>array(
							array('ctr'=>'CompanyInfo','act'=>'index,employee,department')
						)),
				    
				)
			),
            'suiteInfo'=>array(
                'name'=>'suite',
                'text' => "suite",//套餐管理    翻译
                'children' => array(//设置里面包含的各个子功能
                    'list'=>array(
                        'name'=>'suite_list',
                        'text'=>'suite_list',//翻译
                        //每个子功能对应N个controller和action
                        'access'=>array(
                            array('ctr'=>'Suite','act'=>'index')
                        )),
                )
            ),
            'orderInfo'=>array(
                'name'=>'orderbiz',
                'text' => "orderbiz",//订单管理    翻译
                'children' => array(//设置里面包含的各个子功能
                    'list'=>array(
                        'name'=>'orderbiz_list',
                        'text'=>'orderbiz_list',//翻译
                        //每个子功能对应N个controller和action
                        'access'=>array(
                            array('ctr'=>'Orderbiz','act'=>'index')
                        )),
                    'detail'=>[
                        'name'=>'orderbiz_detail',
                        'text'=>'orderbiz_detail',//翻译
                        //每个子功能对应N个controller和action
                        'access'=>array(
                            array('ctr'=>'Orderbiz','act'=>'detail')
                        ),
                    ]
                )
            ),
		)


);

