<?php
return array(
    //敏感词缓存需要的账号密码
    'ILLEGAL_WORD_USER'=> 'admin@qq.com',
    'ILLEGAL_WORD_PWD' => '123456',
    //扫描仪管理-导入扫描仪-默认密码
    'SCANNER_PASSWD_DEFAULT' => 'Imora_Scanner_12',
	//'配置项'=>'配置值'
	'LOCK_SCREEN_TIME'             => 6000 ,//锁屏时间：单位秒
	// 软件更新包目录. 需要 0777权限
	'UPDATE_PACKAGE_STORAGE_PATH'  => WEB_ROOT_DIR . 'temp/SoftwareUpdate/',
    // 每页显示多少条app皮肤数据 : 整数
    'NUMBER_PER_PAGE_OF_THEME'     => 10,
	//允许上传主题文件的大小：16M
	'MAX_SIZE_UPLOAD_THEME' =>16*1024*1024,
	'UNVALID_LOGIN_AUTO_REDIRECT'  => 5,//会话超时自动登录时间
	// 每页显示多少条软件版本更新数据 : 整数
	'NUMBER_PER_PAGE_OF_SOFTWARE_UPDATE'     => 10,
	//允许软件版本更新包的拓展名
	'EXTENSION_PER_PAGE_OF_SOFTWARE_UPDATE' =>array('zip','apk'),
    //进入会员卡模板编辑页面时，是否去掉正面图片
    'IS_HIDE_FRONT_IMG' => true,
	'LOGS'=>array(
		'login'=> array('index' => array('text'=>'login_user_page'),
						'logout' => array('text'=>'logout_user_page')
		),
		// 名片夹统计信息
		'cardsstat'=>array('index'=>array('text'=>'stat_menu_cards')
		),
		'user'=>array('index'=>array('text'=>'user_list'),
				'userlock'=>array('text'=>'user_lock'),
				'userunlock'=>array('text'=>'user_unlock'),
				'addbetauser'=>array('text'=>'add_beta_user')),
		//我的面板
		'index'=>array(
				'index'=>array('text'=>'index'),
				'nopermission'=>array('text'=>'no_permission'),
				'error404'=>array('text'=>'error404','switch'=>'0'),
				'showmodifypage'=>array('text'=>'show_modify_page'),
				'modifyinfo'=>array('text'=>'modify_info'),
				'getoldpasswd'=>array('text'=>'get_old_passwd'),
				'modifypasswd'=>array('text'=>'modify_passwd')),
		// 日志管理
		'logs'=>array('index'=>array('text'=>'show_admin_logs','switch'=>'0'),
				'dellogs'=>array('text'=>'del_admin_logs','switch'=>'0')),
        // 扩展 - 敏感词 & 意见反馈 & 软件版本管理
        'extend'=>array(
            'index'=>array('text'=>'str_sensitive_list'),
            'addsensitive'=>array('text'=>'str_addSensitive'),
            'delsensitive'=>array('text'=>'str_delSensitive'),
            'updsensitive'=>array('text'=>'str_updSensitive'),
            'feedback'=>array('text'=>'str_feedback_list'),
            'delfeedback'=>array('text'=>'str_delFeedback'),
			'softwareupdate'=>array('text'=>'extend_softwareupdate_index'),
			'getuploadlist'=>array('text'=>'extend_softwareupdate_list'),
			'getziplist'=>array('text'=>'extend_softwareupdate_zipList'),
			'addsoftwareupdate'=>array('text'=>'extend_softwareupdate_add'),
			'deluploadzip'=>array('text'=>'extend_softwareupdate_del'),
            'faq'=>array('text'=>'expand_faq'),
            'manual'=>array('text'=>'expand_manual'),
            'intro'=>array('text'=>'expand_intro'),
            'uploadImg'=>array('text'=>'expand_intro'),
        ),
        // 用户分析 - 行为统计 - 名片交换
        'statistics'=>array(
            'cardexchange'          => array('text'=>'str_statistics_list'),
            'downloaddata'          => array('text'=>'str_statistics_exchange_downloaddata'),
        	'apperror'              => array('text'=>'stat_apperror'),
        	'behaviortotalusers'    => array('text'=>'stat_menu_behavior'),
        	'behavioravgduration'   => array('text'=>'stat_menu_behavior'),
        	'behavioravgvisits'     => array('text'=>'stat_menu_behavior'),
        	'behavioruservisitrate' => array('text'=>'stat_menu_behavior')
        ),
        // 设置 - 管理员管理 & 角色管理
        'admin'=>array(
            'index'=>array('text'=>'str_admin_manage'),
            'role'=>array('text'=>'str_role_manage'),
            'addadminpost'=>array('text'=>'str_add_admin'),
            'addrolepost'=>array('text'=>'str_add_role'),
            'deladmin'=>array('text'=>'str_del_admin'),
            'delrole'=>array('text'=>'str_del_role'),
            'editadmin'=>array('text'=>'str_edit'),
            'editrole'=>array('text'=>'str_edit'),
            'editpermission'=>array('text'=>'str_permission_setting'),
            'setpermissionpost'=>array('text'=>'str_permission_setting'),
        ),
        // 行为统计-人脉管理
        'network'=>array(
            'index'=>array('text'=>'str_network'),
            'task'=>array('text'=>'str_sel_data'),
            'export'=>array('text'=>'str_export'),
        ),
		//资讯 问答控制器    问答部分暂时不用了
        'news'=>array('index'=>array('text'=>'str_news_left_published_news'),
        		'getnotauditnews'=>array('text'=>'str_news_left_waiting_audit_news'),
        		'getnotpublishnews'=>array('text'=>'str_news_left_waiting_publishe_news'),
//				'getauditask'=>array('text'=>'str_news_left_audited_ask'),
//        		'getnotauditask'=>array('text'=>'str_news_left_waiting_audit_ask'),
//        		'getrejectedask'=>array('text'=>'str_news_left_rejected_ask'),
        		'addpage'=>array('text'=>'str_news_left_publish_news'),
        		'addcontent'=>array('text'=>'add_new_infomation','switch'=>'0'),
        		'getonenew'=>array('text'=>'str_get_onenew','switch'=>'0'),
				'delnews'=>array('text'=>'del_infomation','switch'=>'0'),
        		'updateaudit'=>array('text'=>'update_news','switch'=>'0'),
        		'commentpassed'=>array('text'=>'str_news_left_audited_comment'),
        		'commentrejected'=>array('text'=>'str_news_left_rejected_comment'),
        		'commentwait'=>array('text'=>'str_news_left_waiting_audit_comment'),
        		'comment'=>array('text'=>'str_comment_page','switch'=>'0'),
        		'commentpass'=>array('text'=>'str_comment_pass','switch'=>'0'),
        		'_commentprocess'=>array('text'=>'str_comment_process','switch'=>'0'),
        		'_getleftcount'=>array('text'=>'str_getleft_count','switch'=>'0'),
        		'getleftmenu'=>array('text'=>'str_getleft_menu','switch'=>'0'),
        		'getparams'=>array('text'=>'str_get_params','switch'=>'0'),
        		'getallcategory'=>array('text'=>'str_get_allcategory','switch'=>'0') ,
        		'getcategory'=>array('text'=>'str_get_onecategory','switch'=>'0'),
			    'addcomment'=>array('text'=>'str_news_add_comment'),
                'editnews'=>array('text'=>'str_news_edit'),
			    'undonews'=>array('text'=>'str_news_undo'),
		     	'willpush'=>array('text'=>'str_news_will_push'),

            ),
		//拓展 - APP主题管理
		'imoratheme'=>array(
				'index'=>array('text'=>'imora_theme_index'),
				'themelist'=>array('text'=>'imora_themet_list'),
				'upLoadtheme'=>array('text'=>'imora_themet_lupload'),
				'addtheme'=>array('text'=>'imora_theme_add'),
				'deleteTheme'=>array('text'=>'imora_themet_delete'),
				),
		'collection' => array(
				'deletechannelopera' => array('text'=>'str_log_del_channel_opera'),
				'showchanneltpl' => array('text'=>'str_log_show_channel'),
				'editchannelopera' => array('text'=>'str_log_edit_channel_opera'),
				'addchannelopera' => array('text'=>'str_log_add_channel_opera'),
				'getcoll'		  => array('text'=>'str_log_get_single_coll_content'),
				'publish'		  => array('text'=>'str_log_publish_coll_content'),
				'uploadfiletmp'		  => array('text'=>'str_log_coll_content_upload_pic'),
				'index'		  		=> array('text'=>'str_log_get_coll_content_list'),
				'deletecontentopera'	=> array('text'=>'str_log_del_coll_opera'),
		),
        //推广
        'push' => array(
                'push' => array('text'=>'push_pushed'),
                'unpush' => array('text'=>'push_unpush'),
                'index' => array('text'=>'str_log_industry'),
                'detail' => array('text'=>'str_log_detail'),
                'pushbyuuid'=>array('switch'=>'0'),
                'deletebyuuid'>array('switch'=>'0')

        ),
        //用户统计 app统计
        'appstatistics' => array(
                'user' => array('text'=>'str_statistics_user'),
                'app' => array('text'=>'str_statistics_app'),

        ),

		//活跃统计
		'useractive' => array(
			    'active' => array('text'=>'str_active_static_index'),
			    'retained' => array('text'=>'str_remain_static_index')
		),

        // 我  橙秀  搜索 文件共享 等模块行为统计信息
        'beanalysis' => array(
            'ianalysis' => array('text'=>'stat_menu_mine'),
            'orangeshowanalysis' => array('text'=>'stat_menu_show'),
            'search' => array('text'=>'stat_menu_search'),
            'fileshare' => array('text'=>'stat_menu_file')
        ),

	    //招聘
	    'job' => array(
            'index'     => array('text'=>'str_job_nopublished'),
            'published' => array('text'=>'str_job_published'),
            'dodelete'  => array('text'=>'str_job_delete','switch'=>'0'),
            'dopublish' => array('text'=>'str_job_publish_unpublish','switch'=>'0'),
            'dojob'     => array('text'=>'str_job_add_edit_job','switch'=>'0'),
	    ),
     ),


	MODULE_NAME              => '1', // 记录管理员操作日志 1 ,不记录是0或者不定义该参数
    'AJAX_NO_AUTH_CODE'      =>'999999999',
    // 统计页面统一的柱线颜色
    'STAT_CHART_LINE_COLORS' => array('#666666', '#f27d00', '#f1b500', '#8fc320 ', '#45b6ce', '#ce8df1', '#bf0081','#8cd91e','#747419','#ec4f17'),
    'STAT_CHART_LINE_COLORS_EXCHANGE' => array('#FF0000', '#FFFF00', '#2319DC'),
	// 协议所在文件路径
	'PROTOCOL_FILE_DIR'=>APP_PATH.'Static/Protocol',
	'LIST_IS_EMPTY_DEFAULT' => '--', //列表为空时默认值

    'CARD_STORAGE_PATH' => WEB_ROOT_DIR . 'temp/Cards/',//会员卡文件存放路径
    //会员卡编辑器里用到的字体
    'FONTS' => array(
        //'微软雅黑'=>'系统默认字体',
        'CenturyGothicWGL'=>'CenturyGothicWGL',
        'Farrington7B'=>'Farrington7B'
    ),

    'KEEP_REFRESH_SESSION_PERIOD'  => 12, // 单位为小时：在登录后多长时间内自动刷新session， 放置会话过期。
    'COMMISSION_RATE' => 0.02,//财务结算 佣金比例 （即：2%） 。
    //收款手续费（索引值对应支付方式）
    'COUNTER_FEE' => array(
        2=>0.006,//支付宝
        3=>0.01,//微信
        4=>0.3 //苹果商店
    ),

    //推荐策略规则默认项
    'ORANGE_STRATEGY_LIST' => array(
        //1 => '卡标签（非人物）',
        2 => '日历事件',
        3 => '相关地点',
        //4 => '相关时间',
        //5 => '用户使用行为习惯',
        //6 => '商业行为的推荐',
        //7 => '距离的推荐',
    ),
    //卡类型系统属性
    'ORANGE_CARDTYPE_REQUIRED' => array(
        1=>array(
            0=>array('attr'=>'卡号','val'=>'888899998888','alert'=>'卡号码','encrypted'=>'0','type'=>'1','isedit'=>'1','ifdefault'=>'2','contact'=>0 ),
            1=>array('attr'=>'VALID THRU','val'=>'07/17','alert'=>'VALID THRU','encrypted'=>'0','type'=>'1','isedit'=>'1','ifdefault'=>'2','contact'=>0 ),
            2=>array('attr'=>'PIN码','val'=>'PIN码','alert'=>'PIN码，三位数','encrypted'=>'0','type'=>'1','isedit'=>'1','ifdefault'=>'2','contact'=>0 )
        ),
        2=>array(
            0=>array('attr'=>'卡号', 'val'=>'888899998888', 'alert'=>'卡号码', 'encrypted'=>'0', 'type'=>'1','isedit'=>'1','ifdefault'=>'2','contact'=>0 ),
            1=>array('attr'=>'VALID THRU', 'val'=>'07/17', 'alert'=>'VALID THRU', 'encrypted'=>'0', 'type'=>'1','isedit'=>'1','ifdefault'=>'2','contact'=>0 ),
            2=>array('attr'=>'PIN码', 'val'=>'PIN码', 'alert'=>'PIN码，三位数', 'encrypted'=>'0', 'type'=>'1','isedit'=>'1','ifdefault'=>'2','contact'=>0 ),
        ),
        3=>array(
            0=>array('attr'=>'卡号', 'val'=>'888899998888', 'alert'=>'卡号码', 'encrypted'=>'0', 'type'=>'1','isedit'=>'1','ifdefault'=>'2','contact'=>0 ),
            1=>array('attr'=>'VALID THRU', 'val'=>'07/17', 'alert'=>'VALID THRU', 'encrypted'=>'0', 'type'=>'1','isedit'=>'1','ifdefault'=>'2','contact'=>0 ),
        ),
        4=>array(
            0=>array('attr'=>'卡号', 'val'=>'888899998888', 'alert'=>'卡号码', 'encrypted'=>'0', 'type'=>'1','isedit'=>'1','ifdefault'=>'2','contact'=>0 ),
            1=>array('attr'=>'VALID THRU', 'val'=>'07/17', 'alert'=>'VALID THRU', 'encrypted'=>'0', 'type'=>'1','isedit'=>'1','ifdefault'=>'2','contact'=>0 ),
        ),
        5=>array(
            0=>array('attr'=>'卡号', 'val'=>'888899998888', 'alert'=>'卡号码', 'encrypted'=>'0', 'type'=>'1','isedit'=>'1','ifdefault'=>'2','contact'=>0 ),
            1=>array('attr'=>'VALID THRU', 'val'=>'07/17', 'alert'=>'VALID THRU', 'encrypted'=>'0', 'type'=>'1','isedit'=>'1','ifdefault'=>'2','contact'=>0 ),
        ),
        6=>array(
            0=>array('attr'=>'卡号', 'val'=>'888899998888', 'alert'=>'卡号码', 'encrypted'=>'0', 'type'=>'1','isedit'=>'1','ifdefault'=>'2','contact'=>0 ),
            1=>array('attr'=>'VALID THRU', 'val'=>'07/17', 'alert'=>'VALID THRU', 'encrypted'=>'0', 'type'=>'1','isedit'=>'1','ifdefault'=>'2','contact'=>0 ),
        ),
        7=>array(
            0=>array('attr'=>'卡号', 'val'=>'888899998888', 'alert'=>'卡号码', 'encrypted'=>'0', 'type'=>'1','isedit'=>'1','ifdefault'=>'2','contact'=>0 ),
            1=>array('attr'=>'VALID THRU', 'val'=>'07/17', 'alert'=>'VALID THRU', 'encrypted'=>'0', 'type'=>'1','isedit'=>'1','ifdefault'=>'2','contact'=>0 ),
        ),
        8=>array(
            0=>array('attr'=>'卡号', 'val'=>'888899998888', 'alert'=>'卡号码', 'encrypted'=>'0', 'type'=>'1','isedit'=>'1','ifdefault'=>'2','contact'=>0 ),
            1=>array('attr'=>'VALID THRU', 'val'=>'07/17', 'alert'=>'VALID THRU', 'encrypted'=>'0', 'type'=>'1','isedit'=>'1','ifdefault'=>'2','contact'=>0 ),
        ),
        15=>array(
            0=>array('attr'=>'卡号', 'val'=>'888899998888', 'alert'=>'卡号码', 'encrypted'=>'0', 'type'=>'1','isedit'=>'1','ifdefault'=>'2','contact'=>0 ),
            1=>array('attr'=>'VALID THRU', 'val'=>'07/17', 'alert'=>'VALID THRU', 'encrypted'=>'0', 'type'=>'1','isedit'=>'1','ifdefault'=>'2','contact'=>0 ),
        ),
        16=>array(
            0=>array('attr'=>'卡号', 'val'=>'888899998888', 'alert'=>'卡号码', 'encrypted'=>'0', 'type'=>'1','isedit'=>'1','ifdefault'=>'2','contact'=>0 ),
            1=>array('attr'=>'VALID THRU', 'val'=>'07/17', 'alert'=>'VALID THRU', 'encrypted'=>'0', 'type'=>'1','isedit'=>'1','ifdefault'=>'2','contact'=>0 ),
        ),
        17=>array(
            0=>array('attr'=>'卡号', 'val'=>'888899998888', 'alert'=>'卡号码', 'encrypted'=>'0', 'type'=>'1','isedit'=>'1','ifdefault'=>'2','contact'=>0 ),
            1=>array('attr'=>'VALID THRU', 'val'=>'07/17', 'alert'=>'VALID THRU', 'encrypted'=>'0', 'type'=>'1','isedit'=>'1','ifdefault'=>'2','contact'=>0 ),
        ),
        18=>array(
            0=>array('attr'=>'卡号', 'val'=>'888899998888', 'alert'=>'卡号码', 'encrypted'=>'0', 'type'=>'1','isedit'=>'1','ifdefault'=>'2','contact'=>0 ),
            1=>array('attr'=>'VALID THRU', 'val'=>'07/17', 'alert'=>'VALID THRU', 'encrypted'=>'0', 'type'=>'1','isedit'=>'1','ifdefault'=>'2','contact'=>0 ),
        ),
        19=>array(
            0=>array('attr'=>'卡号', 'val'=>'888899998888', 'alert'=>'卡号码', 'encrypted'=>'0', 'type'=>'1','isedit'=>'1','ifdefault'=>'2','contact'=>0 ),
            1=>array('attr'=>'VALID THRU', 'val'=>'07/17', 'alert'=>'VALID THRU', 'encrypted'=>'0', 'type'=>'1','isedit'=>'1','ifdefault'=>'2','contact'=>0 ),
        )
    ),

    //卡模板编辑页面-有效期格式配置
    'DATE_FORMAT'=>array(
        array('format'=>'MM/yy', 'val'=>'03/17'),
        array('format'=>'MM/yyyy', 'val'=>'03/2017'),
        array('format'=>'yyyy-MM-dd', 'val'=>'2017-03-01'),
        array('format'=>'MMM yyyy', 'val'=>'Jul 2017'),
    ),
    
    //卡模板编辑页面-7B字体大小配置
    '7B_FONT_SIZE'=>array(
        array('str'=>'小', 'val'=>80),
        array('str'=>'大', 'val'=>120),
    ),
    
    //卡模板编辑页面-7B字体颜色配置
    '7B_FONT_COLOR'=>array(
        array('str'=>'黑色', 'val'=>'000000'),
        array('str'=>'银色', 'val'=>'EEEEEE'),
        array('str'=>'金色', 'val'=>'E6C248'),
    ),
    
    //不需要权限验证的控制器方法
    'FREE_CTR_ACT'=>array(
         //运营后台首页
        'Index'=>array('index','unlock','lock'),
        'Dbtest'=>array('dbtestone','dbtesttwo','dbtestthree'),
        'Collection'=>array('uploadFileTmp'),
    	'Admin'=>array('importExcel','getMemory'),
    	'ImportData'=>array('importExcel','getMemory','batchUpdateMembership'),
        ),

    //不需要登陆的控制器方法
    'NO_NEED_LOGIN'=>array(
            'Appadmin'=> array(
                        'index'=>array('error404'),
                        'login'=>array('index','wx'),
            		    'admin'=>array('importExcel','getMemory'),
            ),
    ),
    'ADMIN_USERNAME'=>array('admin@qq.com','cloud_admin@oradt.com'),
    //ip访问控制
    'ACCESS_LIST_IP'=>array(),
);
