<?php
return array(
	//'配置项'=>'配置值'
		'COMPANY_QR_PREFIX'         => '^&^&&**(_', // toB企业生成二维码
	'LOCK_SCREEN_TIME'             => 1800 ,//登录会话过期时间：单位秒
	'EXPORT_SCANCARD_PAGESIZE' => 1, // 导出扫描名片zip中 每个文件的记录条数
	'CARD_STORAGE_PATH' => WEB_ROOT_DIR . 'temp'.DIRECTORY_SEPARATOR.'Cards'.DIRECTORY_SEPARATOR,
    'TEMPLATE_ICONS' => array(
        '/images/cardEditor/icon.png',
        '/images/cardEditor/icon2.png',
        '/images/cardEditor/2.png'
    ),
	'CUSTOMER_CARD_IMPORT_TEMPLATE_URL' => APP_PATH.'Static/importCustomerCardTemp.xlsx', // 客户名片导入模板文件路径
	// 企业认证图片上传目录. 需要 0777权限
	'COMPANY__CERTIFICATION_IMG_PATH'  => WEB_ROOT_DIR . 'temp/upload/',
    //系统名片模板缓存
    'COMPANY_SYS_TEMPLATES_PATH' => WEB_ROOT_DIR . 'temp/systpls/',
    //企业名片模板缓存（FOR 生成员工名片）
    'COMPANY_COMPANY_TEMPLATES_PATH' => WEB_ROOT_DIR . 'temp/companytpls/',
    //员工名片临时保存路径
    'COMPANY_EMPLOYEE_CARD_PATH' => WEB_ROOT_DIR . 'temp/employeecards/',

    'AJAX_NO_AUTH_CODE'      =>'999999999',
    'FONTS' => array(
        '微软雅黑'=>'微软雅黑',
        '宋体'=>'宋体',
    ),
	/*
	 * 左侧菜单 start
	 * 1.Menutocontr =>array(
			'business' => array(
				'text' => "大标题显示的文字翻译",
				'ctl'=>'大标题展示页面的controller,大标题没有链接 该key值可省略不写或为空',
				'act'=>'大标题展示页面的action,大标题没有链接 该key值可省略不写或为空',
				'children'=>array(
						'infomation'=>array(
								'text'=>'小标题显示的文字翻译',
								'ctl'=>'小标题展示页面的controller',
								'act'=>'小标题展示页面的action'),
						'movement'=>array(
								'text'=>'str_menu_business_movement',
								'ctl'=>'Export',
								'act'=>'exportInfo'),
						'cards'=>array(
								'text'=>'str_menu_business_cards',
								'ctl'=>'Export',
								'act'=>'exportInfo')
				)
		)

		2.count($Menutocontr) = 大标题个数
		3.count($Menutocontr[business][children]) = 大标题business下小标题的个数
	 */
	'LEFTMENUARR'=>array(
		// 名片管理
		'cardmanage' => array(
				'icon' => "card-icon",
				'text' => "str_menu_card_manage",
				'ctl'=>'Index',
				'act'=>'index',
				'children'=>array(
						'cardlist'=>array( //名片列表
								'text'=>'str_menu_card_list',
								'ctl'=>'Index',
								'act'=>'index'),
						'cardsearchresult'=>array( //名片搜索结果
								'text'=>'str_menu_card_search_result',								
								'ctl'=>'Index',
								'act'=>'index'),
						'cardrecover'=>array( //名片回收站
								'text'=>'str_menu_cards_recover',
								'ctl'=>'Recovers',
								'act'=>'index'),
				)
		),
		// 营销邮件
/* 		'mail' => array(
				'icon' => "email-icon",
				'text' => "str_menu_marking_mail",
				'ctl'=>'Staff',
				'act' => 'index',
				'children'=>array(
                     'infomation'=>array(
                            'text'=>'str_menu_employees_invite',
                            'ctl'=>'Staff',
                            'act'=>'index'),
                    'customershare'=>array(
                            'text'=>'str_menu_employees_customer_share',
                            'ctl'=>'Staff',
                            'act'=>'customerShare'),
                    'consumerule'=>array(
                            'text'=>'str_menu_employees_consumption_rules',
                            'ctl'=>'Staff',
                            'act'=>'consumeRules') 
				)
		), */
		// 商谈记录
/* 		'talkrecord' => array(
				'icon' => "ji-icon",
				'text' => "str_menu_talk_record",
				'ctl'=>'Customer',
				'act' => 'index',
				'children'=>array(
						'infomation'=>array(
								'text'=>'str_menu_customer_card',
								'ctl'=>'Customer',
								'act'=>'index'),
				     	'company'=>array(
						        'text'=>'str_menu_customer_company',
						        'ctl'=>'Customer',
						        'act'=>'customerCompany'),
						'movement'=>array(
								'text'=>'str_menu_customer_employees_customer',
								'ctl'=>'Customer',
								'act'=>'employeesCustomer')

				)
		), */
		// 任务
/*         'task' => array(
        		'icon' => "ren-icon",
                'text' => "str_menu_task",
                'ctl'=>'Finance',
                'act' => 'invoiceMsg',
                'children'=>array(
                        'infomation'=>array(
                                'text'=>'str_menu_financial_invoice_qualification',
                                'ctl'=>'Finance',
                                'act'=>'invoiceMsg'),
                        'movement'=>array(
                                'text'=>'str_menu_financial_apply_invoice',
                                'ctl'=>'Finance',
                                'act'=>'invoiceList')
                )
        ), */
        //管理设置
        'manageset' => array(
        		'icon' => "sets-icon",
                'text' => "str_menu_manage_seting",
                'ctl'=>'AdminSet',
                'act' => 'index',
                'children'=>array(
                        'authmanage'=>array( //权限设置
                                'text'=>'str_menu_manage_seting',
                                'ctl'=>'AdminSet',
                                'act'=>'index'),
                        'departmanage'=>array( //部门设置
                                'text'=>'str_menu_depart_manage',
                                'ctl'=>'Departments',
                                'act'=>'index'),
                        'staffmanage'=>array( //员工设置
                                'text'=>'str_menu_staff_manage',
                                'ctl'=>'Staff',
                                'act'=>'index'),
                		'labelmanage'=>array(  //标签设置
                				'text'=>'str_menu_label_manage',
                				'ctl'=>'Label',
                				'act'=>'index')
                )
        )

	),  // 左侧菜单end

	//不需要权限验证的控制器方法
	'FREE_CTR_ACT'=>array(
		 //企业后台首页
		'Index'=>'*',
		'Recovers' => '*',
		//设置--修改密码，修改邮箱
		'System'=>array('sysSet','updatePass','passPost','updateEmail','emailPost'),
		),

	//不需要登陆的控制器方法
	'NO_NEED_LOGIN'=>array(
			'Company'=> array(
						'login'=>array('index','checkVerifyCode','imgUpload','getVerifyCode','error404','wx'),
						'common'=>array('getAddressList'),
						'register'=>array('*'),
						'forgetpwd'=>array('resetPwdTpl','sendMail','setNewPwdTpl','setNewPwdOpera','findPwdComplete','setNewEmailTpl','setNewEmailPost'),
					    'adminset'=>array('entQrCode','downloadQrImg'),
						'test' => array('log')
			)
	),

	//开发平台
	'APPID'=>'wx2ba8a77d7a148401',
	'APPSECRET'=>'be1f9279aa47bcb37617e91f567d2e6b',
);
