<?php
	return array(

		//我的面板
		'mypanel' => array(
            'text' => "str_mypanel",
            'children' => array('Index'),
            'leftmenu' => array(
				'mypanel'           => array(
					'title'=> $this->translator->my_panel,
					'link'=>'Index/index',
				),
            	'personalinfo'         => array(
					'title'=>$this->translator->personal_info,
					'menus'=>array(
						'showModifyPage'   => array(
							'link'=>'Index/showModifyPage',
							'title'=>$this->translator->modify_personal_info,
						),
						'modifyPasswd'   => array(
							'link'=>'Index/modifyPasswd',
							'title'=>$this->translator->modify_passwd,
						),
	                ),
				),
				'adminaccount' => array(
					'title'=>'管理员账号列表',
					'link'=>'Index/AdminAccount',
				),
            ),
        ),
		'companyInfo' => array( //企业管理
			'text' =>'企业管理',
			'children' => array('CompanyInfo'),
			'leftmenu' => array(
				'companyInfoList' => array(
					'title'=>'企业信息列表',
					'link'=>'companyInfo/index',
				),

			),
		),

        'suiteInfo' => array( //套餐管理
            'text' =>'suite',
            'children' => array('Suite'),
            'leftmenu' => array(
                'suiteInfoList' => array(
                    'title'=>'套餐信息',
                    'link'=>'suite/index',
                ),
//                'suiteInfoDetail' => array(
//                    'title'=>'套餐信息详情',
//                    'link'=>'suite/index',
//                ),
                'termInfoList' => array(
                    'title'=>'企业套餐',
                    'link'=>'suite/term',
                ),
//                'termInfoDetail' => array(
//                    'title'=>'企业套餐详情',
//                    'link'=>'suite/termdetail',
//                ),
            ),
        ),

        'orderInfo' => array( //订单管理
            'text' =>'orderbiz',
            'children' => array('Orderbiz'),
            'leftmenu' => array(
                'orderInfoList' => array(
                    'title'=>'订单信息',
                    'link'=>'Orderbiz/index',
                ),
//                'orderInfoDetail' => array(
//                    'title'=>'订单信息详情',
//                    'link'=>'Orderbiz/detail',
//                ),

            ),
        ),

	);

