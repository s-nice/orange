<?php
defined('WEB_SERVICE_ROOT_URL') OR define('WEB_SERVICE_ROOT_URL', rtrim(C('WEB_SERVICE_ROOT_URL'), '/'));
defined('ORANGE_WEB_SERVICE_URL') OR define('ORANGE_WEB_SERVICE_URL', rtrim(C('ORANGE_WEB_SERVICE_URL'), '/'));
defined('ORANGE_EXTRACT_RULE_SERVICE_URL') OR define('ORANGE_EXTRACT_RULE_SERVICE_URL', rtrim(C('ORANGE_EXTRACT_RULE_SERVICE_URL'), '/'));

return array(
    'API_VERSION'               => WEB_SERVICE_ROOT_URL . '/common/apistore/version',
    'API_OAUTH'                 => WEB_SERVICE_ROOT_URL . '/oauth',
	'API_OAUTH_APISTORE_CHECKACCOUNT'=> WEB_SERVICE_ROOT_URL . '/oauth/apistore/checkaccount',
    'API_ACCOUNT_DETECTION'     => WEB_SERVICE_ROOT_URL . '/detection',
    'API_ACCOUNT'               => WEB_SERVICE_ROOT_URL . '/account',
    'API_ACCOUNT_FRIEND'        => WEB_SERVICE_ROOT_URL . '/account/friend',
    'API_ACCOUNT_AVATAR'        => WEB_SERVICE_ROOT_URL . '/account/avatar',
    'API_ACCOUNT_QUESTION'      => WEB_SERVICE_ROOT_URL . '/account/question',
    'API_ACCOUNT_QUESTION_VERIFY' => WEB_SERVICE_ROOT_URL . '/account/question/verify',
    'API_ACCOUNT_BIZ'           => WEB_SERVICE_ROOT_URL . '/accountbiz',
    'API_ACCOUNT_BIZ_OPERATOR'  => WEB_SERVICE_ROOT_URL . '/accountbiz/operator',
	'API_ACCOUNT_BIZ_OPERATOR/MOBILE'  => WEB_SERVICE_ROOT_URL . '/accountbiz/operator/mobile',
	'API_ACCOUNT_BIZ_FILE'      => WEB_SERVICE_ROOT_URL . '/accountbiz/file',
	'API_ACCOUNT_BIZ_AUTH_ROLE' => WEB_SERVICE_ROOT_URL . '/accountbiz/authorization/role',//授权账号角色
	'API_ACCOUNT_BIZ_AUTH_ACC'  => WEB_SERVICE_ROOT_URL . '/accountbiz/authorization', //授权账号
    'API_ACCOUNT_BIZ_IMPORT'    => WEB_SERVICE_ROOT_URL . '/accountbiz/apistore/import',//账号角色导入
    'API_ACCOUNT_BIZ_IMPORT_SHOW' => WEB_SERVICE_ROOT_URL . '/accountbiz/apistore/show',//账号角色导入查询
    'API_BIZ_NEWS'				=> WEB_SERVICE_ROOT_URL . '/accountbiz/news', // 企业新闻
    'API_BIZ_NEWS_RESOURCE'     => WEB_SERVICE_ROOT_URL . '/accountbiz/news/resource', // 企业新闻

    'API_BIZ_FOLLOWS_GROUP'     => WEB_SERVICE_ROOT_URL . '/accountbiz/follows/group', // 分组管理
    'API_BIZ_PUBLIC_NUMBER'     => WEB_SERVICE_ROOT_URL . '/accountbiz/public/number', // 公众号
    'API_BIZ_PUSHMESSAGE'       => WEB_SERVICE_ROOT_URL . '/accountbiz/pushmessage', // 公众号推送消息

    'API_ORADT_PUSHMESSAGE'       => WEB_SERVICE_ROOT_URL . '/accountbiz/apistore/pushmessage', // 橙鑫公众号推送消息
    'API_ORADT_DEL_MESSAGE'       => WEB_SERVICE_ROOT_URL . '/accountbiz/apistore/delorapushlog', // 删除橙鑫公众号推送消息
    'API_ORADT_ARTICLE'       => WEB_SERVICE_ROOT_URL . '/accountbiz/article', // 企业文章

	'API_CONTACT'               => WEB_SERVICE_ROOT_URL . '/contact',
    'API_CONTACT_GROUP'         => WEB_SERVICE_ROOT_URL . '/contact/group',
    'API_CONTACT_GROUP_GROUPBY' => WEB_SERVICE_ROOT_URL . '/contact/vcard/groupby',
    'API_CONTACT_VCARD'         => WEB_SERVICE_ROOT_URL . '/contact/vcard',
    'API_CONTACT_VCARD_CARDRES' => WEB_SERVICE_ROOT_URL . '/contact/vcard/cardres',
    'API_CONTACT_VCARD_GROUP'   => WEB_SERVICE_ROOT_URL . '/contact/vcard/group',
    'API_CONTACT_VCARD_PROPERTY'=> WEB_SERVICE_ROOT_URL . '/contact/vcard/property',
    'API_CONTACT_VCARD_DOWNLOADCARDRES'=> WEB_SERVICE_ROOT_URL . '/contact/vcard/downloadcardres',

    'API_CONTACT_VCARD_EXCHANGE'=> WEB_SERVICE_ROOT_URL . '/contact/vcard/exchange',

    'API_VCARD_TEMPLATE'        => WEB_SERVICE_ROOT_URL . '/vcard/template',
    'API_VCARD_TEMPLATE_CARDRES'=> WEB_SERVICE_ROOT_URL . '/vcard/template/cardres',
    'API_SCANCARD'              => WEB_SERVICE_ROOT_URL . '/scancard',
    'API_SCANCARD_PICTURE'      => WEB_SERVICE_ROOT_URL . '/scancard/picture',
    'API_SCANCARD_CARDRES'      => WEB_SERVICE_ROOT_URL . '/scancard/cardres',
    'API_SCANCARD_PROPERTY'     => WEB_SERVICE_ROOT_URL . '/scancard/property',
    'API_SCANCARD_COUNT'        => WEB_SERVICE_ROOT_URL . '/scancard/count',
    'API_BIZ_CARD'              => WEB_SERVICE_ROOT_URL . '/bizcard',
    'API_BIZ_CARDRES'           => WEB_SERVICE_ROOT_URL . '/bizcard/cardres',
    'API_BIZ_CARD_GROUP'        => WEB_SERVICE_ROOT_URL . '/bizcard/group',
    'API_BIZ_CARD_DELIVERY'     => WEB_SERVICE_ROOT_URL . '/bizcard/delivery',
    'API_RELATION'              => WEB_SERVICE_ROOT_URL . '/relation',
    'API_RELATION_ANNAUL_RING'  => WEB_SERVICE_ROOT_URL . '/relation/annualring',
    'API_CALENDAR_EVENT'        => WEB_SERVICE_ROOT_URL . '/calendar/event',
    'API_CALENDAR_NOTE'         => WEB_SERVICE_ROOT_URL . '/calendar/note',
    'API_DOCUMENT'              => WEB_SERVICE_ROOT_URL . '/document',
    'API_DOCUMENT_DOWNLOAD'     => WEB_SERVICE_ROOT_URL . '/document/download',
    'API_DOCUMENT_DIRECTORY'    => WEB_SERVICE_ROOT_URL . '/document/directory',
    'API_TRASHBIN'              => WEB_SERVICE_ROOT_URL . '/trashbin',
    'API_GUILD'                 => WEB_SERVICE_ROOT_URL . '/guild',
    'API_GUILD_LOGO'            => WEB_SERVICE_ROOT_URL . '/guild/logo',
    'API_GUILD_MEMBER'          => WEB_SERVICE_ROOT_URL . '/guild/member',
    'API_GUILD_VCARD'           => WEB_SERVICE_ROOT_URL . '/guild/vcard',
    'API_TOPIC'                 => WEB_SERVICE_ROOT_URL . '/topic',
    'API_TOPIC_CATEGORY'        => WEB_SERVICE_ROOT_URL . '/topic/category',
    'API_TOPIC_COMMENT'         => WEB_SERVICE_ROOT_URL . '/topic/comment',
    'API_MESSAGE'               => WEB_SERVICE_ROOT_URL . '/message',
    'API_NOTICE'                => WEB_SERVICE_ROOT_URL . '/notification',
    'API_TALK'                  => WEB_SERVICE_ROOT_URL . '/talk',
    'API_VERIFY_SMS'            => WEB_SERVICE_ROOT_URL . '/verification/sms',
    'API_VERIFY_EMAIL'          => WEB_SERVICE_ROOT_URL . '/verification/email',
    'API_DEVICE'                => WEB_SERVICE_ROOT_URL . '/device',
    'API_DEVICE_INSTRUCTION'    => WEB_SERVICE_ROOT_URL . '/device/instruction',
    'API_DEVICE_DATA'           => WEB_SERVICE_ROOT_URL . '/device/data',
    'API_ADMIN'                 => WEB_SERVICE_ROOT_URL . '/admin',
    'API_ADMIN_ROLE'            => WEB_SERVICE_ROOT_URL . '/admin/role',
	'API_ADMIN_APISTORE_ADMINLOG'=> WEB_SERVICE_ROOT_URL . '/admin/apistore/adminlog',
    'API_ADMIN_APISTORE_GETCUSTOMER'=> WEB_SERVICE_ROOT_URL . '/admin/apistore/getcustomer',
	'API_APISTORE_CHECKMAIL'    => WEB_SERVICE_ROOT_URL . '/oauth/apistore/checkemail',
    'API_SCANNER_ADD'           => WEB_SERVICE_ROOT_URL . '/admin/scanner/add',
    'API_SCANNER_UPDATE'        => WEB_SERVICE_ROOT_URL . '/admin/scanner/edit',
    'API_SCANNER_USERECORD'     => WEB_SERVICE_ROOT_URL . '/admin/scanner/userecord',
	'API_CONFIG'                => WEB_SERVICE_ROOT_URL . '/config',
    'API_SYSTEM_AVATAR'         => WEB_SERVICE_ROOT_URL . '/system/avatar',
    'API_SYSTEM_AVATAR_DOWNLOAD'=> WEB_SERVICE_ROOT_URL . '/system/avatar/download',
    'API_RESET_PASS_BY_MAIL'    => WEB_SERVICE_ROOT_URL . '/resetpasswd/email/default', //发送邮件
	'API_EDIT_PASS_BY_MAIL'     => WEB_SERVICE_ROOT_URL . '/resetpasswd/email/editpwd', //激活邮箱或重置密码
    'API_UPDATE_MAIL_OR_PWD'     => WEB_SERVICE_ROOT_URL . '/accountbiz/company/editep', //企业账户修改邮箱或密码
    'API_UPDATE_MAIL_OR_PWD_EMP' => WEB_SERVICE_ROOT_URL . '/accountbiz/company/editempep', //企业账户员工修改邮箱或密码
	'API_SEND_MAIL'             => WEB_SERVICE_ROOT_URL . '/accountbiz/company/sendmail', //发送邮件
    'API_RESET_PASS_BY_SMS'     => WEB_SERVICE_ROOT_URL . '/resetpasswd/sms',
    'API_RESET_PASS_BY_QUESTION'=> WEB_SERVICE_ROOT_URL . '/resetpasswd/question',
    'API_STAT'                  => WEB_SERVICE_ROOT_URL . '/statistic/apicalltimes',
    'API_SYNC_VCARD'            => WEB_SERVICE_ROOT_URL . '/contact/vcard/sync',
    'API_SYNC_VCARD_GROUP'      => WEB_SERVICE_ROOT_URL . '/contact/vcard/group/sync',
    'API_SYNC_EVENT'            => WEB_SERVICE_ROOT_URL . '/calendar/event/sync',
    'API_SYNC_NOTE'             => WEB_SERVICE_ROOT_URL . '/calendar/note/sync',
    'API_SYNC_DEVICE_DATA'      => WEB_SERVICE_ROOT_URL . '/device/data/sync',
    'API_SYNC_DOCUMENT'         => WEB_SERVICE_ROOT_URL . '/document/sync',

    ##### HR ####
	'API_HR_BIZDEP'             => WEB_SERVICE_ROOT_URL . '/hr/bizdep',//hr企业部门
	'API_HR_RECRUITER'          => WEB_SERVICE_ROOT_URL . '/hr/recruiter', //hr企业职员
    'API_HR_EXPERIENCE'         => WEB_SERVICE_ROOT_URL . '/hr/expericence',
    'API_HR_SKILL'              => WEB_SERVICE_ROOT_URL . '/hr/skill',
    'API_HR_EDUCATION'          => WEB_SERVICE_ROOT_URL . '/hr/education',
    'API_HR_GET_RESUME'         => WEB_SERVICE_ROOT_URL . '/hr/resume',//获取单个简历的所有信息
	'API_HR_DYNAMIC_PUBLISH'    => WEB_SERVICE_ROOT_URL . '/sns/maxim', //个人动态
    'API_CAREERFAIR_JOB'          => WEB_SERVICE_ROOT_URL . '/careerfair/job',  //hr招聘
	'API_HR_CAREERFAIR_JOBCATEGORY' => WEB_SERVICE_ROOT_URL . '/careerfair/jobcategory',//获取招聘信息分类
	'API_HR_CAREERFAIR_HOTSEARCH'   => WEB_SERVICE_ROOT_URL . '/careerfair/hotsearch',//获取热门搜索
	'API_HR_HUMANSERVICE_CANDIDATE'   => WEB_SERVICE_ROOT_URL . '/humanservice/candidate', //候选人信息
    'API_HR_JOB_APPLYINFO'  	 => WEB_SERVICE_ROOT_URL . '/hr/job/applyinfo', //职位申请信息
	'API_HR_FAVORITE_JOB'   	 => WEB_SERVICE_ROOT_URL . '/hr/favoritejob', //收藏职位
	'API_HR_CATEGORY_POSITION'   => WEB_SERVICE_ROOT_URL . '/careerfair/jobpositioncategory', //职能分类
	'API_HR_CATEGORY_MAJOR'  	 => WEB_SERVICE_ROOT_URL . '/careerfair/jobmajorcategory', //专业分类
	'API_HR_TOTAL'   			 => WEB_SERVICE_ROOT_URL . '/hr/total', //hr权限者查询发布职位、推荐简历等数量
	'API_HR_RECOMMEND_POSITION'	 => WEB_SERVICE_ROOT_URL . '/hr/recommend', //个人获取推荐的职位列表
	'API_HR_FAVORITE_CAND_GROUP'	 => WEB_SERVICE_ROOT_URL . '/hr/favorite/candidate/group',//企业收藏简历分组

	##### SNS ####
    'API_SNS_ACCOUNT'           => WEB_SERVICE_ROOT_URL . '/sns/account',//账号
    'API_SNS_MESSAGE'           => WEB_SERVICE_ROOT_URL . '/sns/talklog',//会话记录
    'API_SNS_MESSAGE_DOWNLOAD'  => WEB_SERVICE_ROOT_URL . '/sns/talking/download',//会话资源下载
    'API_SNS_TAGS'              => WEB_SERVICE_ROOT_URL . '/sns/tags',//标签
    'API_SNS_LATENTFRIENDS'     => WEB_SERVICE_ROOT_URL . '/sns/latentfriends',//推荐好友
    'API_SNS_SHARING'           => WEB_SERVICE_ROOT_URL . '/sns/sharing',//分享
    'API_SNS_SHARING_COMMENT'           => WEB_SERVICE_ROOT_URL . '/sns/sharing/comment',//分享评论
    'API_SNS_ACTIVITY'                  => WEB_SERVICE_ROOT_URL . '/sns/activity',//活动
    'API_SNS_ACTIVITY_SOURCE'           => WEB_SERVICE_ROOT_URL . '/sns/activity/resource',//活动资源文件
    'API_SNS_ACTIVITY_SOURCE_DOWNLOAD'  => WEB_SERVICE_ROOT_URL . '/sns/activity/resource/download',//活动资源文件下载
    'API_SNS_ACTIVITY_COMMENT'          => WEB_SERVICE_ROOT_URL . '/sns/activity/comment',//活动评论
    'API_SNS_ACTIVITY_FOLLOW'           => WEB_SERVICE_ROOT_URL . '/sns/activity/follow',//关注活动
    'API_SNS_TAGS'              => WEB_SERVICE_ROOT_URL . '/sns/tags',//会话
    'API_SNS_MAXIM'             => WEB_SERVICE_ROOT_URL . '/sns/news',//动态
    'API_SNS_MAXIM_COMMENT'     => WEB_SERVICE_ROOT_URL . '/sns/news/comment',//动态评论
    'API_SNS_GROUP'     		=> WEB_SERVICE_ROOT_URL . '/sns/group',//聊天群组
    'API_SNS_GROUP_MEMBER'     		=> WEB_SERVICE_ROOT_URL . '/sns/group/member',//群组成员
    'API_SNS_TALKLOG'             => WEB_SERVICE_ROOT_URL . '/sns/talklog',//个人历史记录、群组历史记录


    ##### BIZ_TIMECARD ####
    'API_BIZ_TIMECARD'             => WEB_SERVICE_ROOT_URL . '/BIZ/TIMECARD',
	'API_ACTIVE_BUSINESS_List' => WEB_SERVICE_ROOT_URL . '', // 已关注的公司列表
	'API_BUSINESS_List'=>WEB_SERVICE_ROOT_URL . '', // 获得系统内公司列表
	'API_MORE_ACTIVE_BUSINESS' => WEB_SERVICE_ROOT_URL .'', // 批量关注公司

	'API_CITY_LIST'         	=> WEB_SERVICE_ROOT_URL . '/cityinfo',
	'API_CITY_PROVINCE_LIST'         	=> WEB_SERVICE_ROOT_URL . '/common/apistore/getprovince',//省份
	'API_COMMON_APISTORE_GETSENDSMS' => WEB_SERVICE_ROOT_URL .'/common/apistore/getsendsms',
	'API_WEATHER_LIST'      	=> WEB_SERVICE_ROOT_URL . '/weather',
	'API_CITY_DEFAULT'      	=> WEB_SERVICE_ROOT_URL . '',

	### 黄页 ###
	'API_YP_BIZ_INFO'        			 => WEB_SERVICE_ROOT_URL . '/yps/bizinfo',//黄页企业信息
	'API_YP_BIZ_CATEGORY'     			 => WEB_SERVICE_ROOT_URL . '/yps/bizcategory',//黄页企业行业分类
	'API_YP_BIZ_PRODUCT'     			 => WEB_SERVICE_ROOT_URL . '/yps/bizproduct',//黄页企业产品信息
	'API_YP_BIZ_PRODUCT_RECOURCE'    	 => WEB_SERVICE_ROOT_URL . '/yps/bizproduct/resource',//黄页企业产品资源文件
	'API_YP_BIZ_PRODUCT_RECOURCE_DOWNLOAD' => WEB_SERVICE_ROOT_URL . '/yps/bizproduct/resource/download',//黄页企业产品资源下载
	'API_YP_BIZ_PRODUCT_CATAGORY'    	 => WEB_SERVICE_ROOT_URL . '/yps/productcategory',//黄页企业产品分类
	'API_YP_BIZ_BRANCH'    	 			 => WEB_SERVICE_ROOT_URL . '/yps/bizinfo/branch',//黄页企业产品分类
	'API_YP_HOT_SEARCH'    	 			 => WEB_SERVICE_ROOT_URL . '/yps/hotsearch',//黄页企业产品分类
	'API_FOLLOWS_BIZ'    	 			 => WEB_SERVICE_ROOT_URL . '/accountbiz/follows',//关注企业

	# 系统名片标签 ##
	'API_CARD_SYSTEM_LABEL_LIST' => WEB_SERVICE_ROOT_URL.'/contact/vcard/hottags', // 系统标签列表

	# 校对扫描名片
	'API_SCANCARD' => WEB_SERVICE_ROOT_URL.'/scancard', // 获取当天已处理好的扫描名片个数

    # batch
    'API_BATCH'    => WEB_SERVICE_ROOT_URL.'/batch',

    #人脉 #
    'API_RELATIONS_ANNUAL' =>WEB_SERVICE_ROOT_URL.'/relation/annualring', //时间年轮接口
    'API_RELATIONS_FORCE' =>WEB_SERVICE_ROOT_URL.'/', //标签球数据获取接口
    'API_RELATIONS_FORCE_SEARCH' =>WEB_SERVICE_ROOT_URL.'/', //标签球搜索接口
    'API_RELATIONS_FORCE_WORDS' =>WEB_SERVICE_ROOT_URL.'/', //标签球搜索联想词接口
    'API_RELATIONS_MAP' => WEB_SERVICE_ROOT_URL.'/relation/map',
	'API_CONTACT_RECOMMEND_ADD' => WEB_SERVICE_ROOT_URL.'/admin/apistore/addreferrer', //添加人脉推荐


    ##   橙秀   ##
    'API_ORSHOW_PUBLISH' => WEB_SERVICE_ROOT_URL.'/sns/trends',   // 橙秀 发布动态
    'API_ORSHOW_ZIXUN' => WEB_SERVICE_ROOT_URL.'/sns/news',   // 橙秀 热门推荐 本地资讯数据
    'API_ORSHOW_COMMENT' => WEB_SERVICE_ROOT_URL.'/sns/trends/comment', //橙秀 动态 评论 type=text  赞 type=praise    的操作接口  c r d
    'API_ORSHOW_PERMISSION' => WEB_SERVICE_ROOT_URL.'sns/trends/permission',  //添加动态的查看权限
    'API_ORSHOW_RESOURCE' => WEB_SERVICE_ROOT_URL.'/sns/trends/resource',  //查看动态资源
    'API_ORSHOW_RESUME_PIC' => WEB_SERVICE_ROOT_URL.'/sns/candidatevideo',  //橙秀简历图片
    'API_ORSHOW_RESUME' => WEB_SERVICE_ROOT_URL.'/sns/candidate',  //橙秀简历

    ##  资讯 问答  ##
    'API_CATEGORY_GET' => WEB_SERVICE_ROOT_URL.'/sns/show/category',   // 行业信息获取接口
    'API_NEWS_PUBLISH' => WEB_SERVICE_ROOT_URL.'/sns/show/news',   // 资讯 发布
    'API_NEWS_DELETE' => WEB_SERVICE_ROOT_URL.'/sns/show/delete',   // 资讯 发布
    'API_NEWS_EDIT' => WEB_SERVICE_ROOT_URL.'/sns/show/edit',   // 资讯 问答 编辑
    'API_ASK_PUBLISH' => WEB_SERVICE_ROOT_URL.'/sns/show/ask',   // 问答 发布（个人）
    'API_NEWS_GET' => WEB_SERVICE_ROOT_URL.'/sns/show/lists',   // 资讯&&问答列表  资讯 type = news  问答 type=ask
    'API_NEWS_GET_NOLOGIN' => WEB_SERVICE_ROOT_URL.'/sns/show/unlists',   // 和API_NEWS_GET一样，但是不用登陆
    'API_NEWS_RESOURCE' => WEB_SERVICE_ROOT_URL.'/sns/show/resource',   // 资讯&&问答资源文件获取
    'API_NEWS_UNRESOURCE' => WEB_SERVICE_ROOT_URL.'/sns/show/unresource',   // 资讯&&问答资源文件获取
    'API_NEWS_COMMENT' => WEB_SERVICE_ROOT_URL.'/sns/show/comment',   // 资讯&&问答的评论发布和获取
    'API_NEWS_UNCOMMENT' => WEB_SERVICE_ROOT_URL.'/sns/show/uncomment',   // 资讯&&问答的评论发布和获取，但是不用登陆
    'API_NEWS_EDIT_COMMENT' => WEB_SERVICE_ROOT_URL.'/sns/show/editcomment',   // 修改评论

	'API_NEWS_BETA_COMMENT' => WEB_SERVICE_ROOT_URL.'/admin/apistore/setbetascomment',   // 添加beta用户评论
	'API_NEWS_BETA_USER_GET' => WEB_SERVICE_ROOT_URL.'/admin/apistore/getbetasuser',   // 获取beta用户

    'API_PICTURE_UPLOAD' =>  WEB_SERVICE_ROOT_URL.'/upload',//图片上传接口

    'API_NEWS_COLLECT' => WEB_SERVICE_ROOT_URL.'/sns/show/collect',   // 资讯&&问答的收藏和收藏列表

	'API_NEWS_PUSH_SETTING' => WEB_SERVICE_ROOT_URL.'/sns/show/pushsetting',   // 推送设置
	## APP主题管理 ##
	'API_APP_THEME' => WEB_SERVICE_ROOT_URL.'/admin/apistore/theme',   //主题添加，获取
	'API_APP_THEME_DEL' => WEB_SERVICE_ROOT_URL.'/admin/apistore/deltheme',   //主题删除
    ######活动#####
    'API_CREATE_OPERATION' => WEB_SERVICE_ROOT_URL . '/admin/apistore/operation',//创建活动,查询活动
    'API_UPDATE_OPERATION' => WEB_SERVICE_ROOT_URL . '/admin/apistore/editoper',//更新活动
    ######兑换码#####
    'API_CREATE_REDEEMCODE' => WEB_SERVICE_ROOT_URL . '/admin/apistore/redeemcode',//生成兑换码
    'API_GET_REDEEMCODE' => WEB_SERVICE_ROOT_URL . '/admin/apistore/getredeemcode',//兑换码列表
    'API_REDEEMCODE_USELIST' => WEB_SERVICE_ROOT_URL . '/admin/apistore/redeemcodeuselist',//兑换码消费列表
    'API_APPEND_REDEEMCODE' => WEB_SERVICE_ROOT_URL . '/admin/apistore/redeemcodedit',//追加兑换码
    'API_INVALID_REDEEMCODE' => WEB_SERVICE_ROOT_URL . '/admin/apistore/redeemcodeoper',//作废兑换码
    ######任务#####
    'API_TASK_LIST' => WEB_SERVICE_ROOT_URL . '/admin/task/list',//任务列表
    'API_TASK_ADD' => WEB_SERVICE_ROOT_URL . '/admin/task/add',//创建任务
    'API_TASK_EDIT' => WEB_SERVICE_ROOT_URL . '/admin/task/edit',//编辑任务
    'API_TASK_DEL' => WEB_SERVICE_ROOT_URL . '/admin/task/del',//删除任务
    'API_TASK_STANDARD_USER' => WEB_SERVICE_ROOT_URL . '/admin/task/standarduser',//任务达标
     ######APP价格管理#####
    'API_CREATE_APPPRICE' => WEB_SERVICE_ROOT_URL . '/admin/apistore/appprice',//新增APP价格,获取列表
    'API_EDIT_APPPRICE' => WEB_SERVICE_ROOT_URL . '/admin/apistore/editappprice',//编辑APP价格
    'API_VIP_GIVELIST' => WEB_SERVICE_ROOT_URL . '/admin/apistore/getgivelist',//橙子会员赠送列表
    ## 云盘  ##
    'API_CLOUD_POST' => WEB_SERVICE_ROOT_URL.'/common/apistore/postrecord',//上传
    'API_CLOUD_GET' => WEB_SERVICE_ROOT_URL.'/common/apistore/getrecord',//获取
    'API_CLOUD_DEL' => WEB_SERVICE_ROOT_URL.'/common/apistore/delrecord',//删除
    'API_CLOUD_EDIT' => WEB_SERVICE_ROOT_URL.'/common/apistore/editrecord',//修改

	##  商品  ##
	'API_DESIGN_PRODUCT' => WEB_SERVICE_ROOT_URL.'/design/product', //商品信息
	'API_DESIGN_PRODUCT_STYLE' => WEB_SERVICE_ROOT_URL.'/design/productstyle', //商品风格
	'API_DESIGN_PRODUCT_IMAGE' => WEB_SERVICE_ROOT_URL.'/design/product/picture', //商品图片
	'API_DESIGN_PRODUCT_DOWNLOAD' => WEB_SERVICE_ROOT_URL.'/design/product/download', //下载商品资源
	'API_DESIGN_DESIGNER' => WEB_SERVICE_ROOT_URL.'/design/designer', //商品作者
	'API_DESIGN_ORDER' => WEB_SERVICE_ROOT_URL.'/design/order', //商品订单
	'API_DESIGN_FUND' => WEB_SERVICE_ROOT_URL.'/design/fund', //用户余额
	'API_DESIGN_PAYTRADE' => WEB_SERVICE_ROOT_URL.'/design/paytrade', //交易流水
    'API_DESIGN_PAYTRADE_FAST' => WEB_SERVICE_ROOT_URL.'/design/fasttrade', //快速交易流水
    'API_DESIGN_WEIXIN' => WEB_SERVICE_ROOT_URL.'/design/wxpay', //微信支付结果查询
    'API_DESIGN_PAYPAL' => WEB_SERVICE_ROOT_URL.'/design/paypalipn', //PAYPAL支付结果查询


    ##  search  ##
    'API_SEARCH'  => WEB_SERVICE_ROOT_URL.'', //搜索接口
    'API_SEARCH_HIS'  => WEB_SERVICE_ROOT_URL.'', //搜索  历史搜索
    'API_SEARCH_HOT'  => WEB_SERVICE_ROOT_URL.'', //搜索  热门搜索
    'API_SEARCH_ASS'  => WEB_SERVICE_ROOT_URL.'/common/hotsearch', //搜索  联想词 /common/hotsearch

    ##  cardpackage  ##
    'API_CARDPACKAGE'               => WEB_SERVICE_ROOT_URL . '/cardpackage',                //卡片
    'API_CARDPACKAGE_GROUP'         => WEB_SERVICE_ROOT_URL . '/cardpackage/group',          //卡包分组
    'API_CARDPACKAGE_BEACHPUT'      =>WEB_SERVICE_ROOT_URL . '/cardpackage/beachput',        //卡片批量修改
    'API_CARDPACKAGE_CONSUMELOG'    => WEB_SERVICE_ROOT_URL . '/cardpackage/consume/log',    //卡片消费记录
    ##  企业后台 角色 员工  ##
    'API_ACCOUNTBIZ_AUTHORIZATION_ROLE'  => WEB_SERVICE_ROOT_URL . '/accountbiz/authorization/role',
    'API_ACCOUNTBIZ_AUTHORIZATION'  => WEB_SERVICE_ROOT_URL . '/accountbiz/authorization',
    'API_ACCOUNTBIZ_EMPLOYEE_ADD'  => WEB_SERVICE_ROOT_URL . '/accountbiz/employee/add',
    'API_ACCOUNTBIZ_EMPLOYEE_EDIT'  => WEB_SERVICE_ROOT_URL . '/accountbiz/employee/edit',
    'API_ACCOUNTBIZ_EMPLOYEE_GET'  => WEB_SERVICE_ROOT_URL . '/accountbiz/employee/get',
    'API_ACCOUNTBIZ_EMPLOYEE_GET_ROLEEMP'  => WEB_SERVICE_ROOT_URL . '/accountbiz/employee/roleemp',
    'API_ACCOUNTBIZ_EMPLOYEE_GET_TITLE'  => WEB_SERVICE_ROOT_URL . '/accountbiz/employee/title',
    'API_ACCOUNTBIZ_EMPLOYEE_IMPORT'  => WEB_SERVICE_ROOT_URL . '/accountbiz/employee/import',
    'API_ACCOUNTBIZ_ORDER_AUTHORLIST'  => WEB_SERVICE_ROOT_URL . '/accountbiz/order/authorizelist',
    ## 消费规则 ##
    'API_ACCOUNTBIZ_CONSUME_LIST'  => WEB_SERVICE_ROOT_URL . '/accountbiz/apistore/consume',
    'API_ACCOUNTBIZ_CONSUME_ADD'  => WEB_SERVICE_ROOT_URL . '/accountbiz/apistore/consume',
    'API_ACCOUNTBIZ_CONSUME_EDIT'  => WEB_SERVICE_ROOT_URL . '/accountbiz/apistore/editconsume',

    ##  NEWS  ##
    'API_ACCOUNTBIZ_AUTHORIZATION_ROLE'  => WEB_SERVICE_ROOT_URL . '/accountbiz/authorization/role',
    'API_ACCOUNTBIZ_AUTHORIZATION'  => WEB_SERVICE_ROOT_URL . '/accountbiz/authorization',
    ##  EXHIBITION  ##
    'API_EXPO_EXHITITION'   => WEB_SERVICE_ROOT_URL . '/expo/info',          //展会信息
    'API_EXPO_FIND'         => WEB_SERVICE_ROOT_URL . '/expo/find',          //展会信息审批通过的
    'API_EXPO_EXHIBITOR'    => WEB_SERVICE_ROOT_URL . '/expo/exhibitor',     //参展商
    'API_EXPO_FOLLOWS'      => WEB_SERVICE_ROOT_URL . '/expo/follows',       //关注展会
	'API_EXPO_RECEIVE'      => WEB_SERVICE_ROOT_URL . '/expo/follows/receive', //是否接收展会信息
    'API_EXPO_RESOURCE'     => WEB_SERVICE_ROOT_URL . '/expo/resource',      //展会资源
    'API_EXPO_PERSONNEL'    => WEB_SERVICE_ROOT_URL . '/expo/personnel',     //人员管理搜索
    'API_EXPO_PERSONNEL_PUSHMESSAGE'    => WEB_SERVICE_ROOT_URL . '/expo/personnel/pushmessage',     //人员管理消息推送
    'API_EXPO_EXHIBITORUSER'=> WEB_SERVICE_ROOT_URL . '/expo/exhibitoruser',  //参展代表
    'API_EXPO_TICKET'       => WEB_SERVICE_ROOT_URL . '/expo/ticket',        //门票导入、领取、分发
    'API_EXPO_STATISTIC'    => WEB_SERVICE_ROOT_URL . '/expo/statistic',        //展会相关统计接口
	'API_EXPO_STORE_SEARCH' =>WEB_SERVICE_ROOT_URL.'/expo/apistore/search',
	'API_EXPO_STORE_SUMTICKET' =>WEB_SERVICE_ROOT_URL.'/expo/apistore/sumticket',
    'API_EXPO_TICKET_DISTRIBUTE'    => WEB_SERVICE_ROOT_URL . '/expo/ticket/distribute',        //门票分发



    ##  EXHIBITION ##
    'API_EXHIBITION'  => WEB_SERVICE_ROOT_URL . '/expo/info',
    ## 参展商 ##
    'API_EXHIBITOR'  => WEB_SERVICE_ROOT_URL . '/expo/exhibitor',
    //get_exhibition_group_cards or get_exhibition_group
    'API_GET_EXHIBITION_GROUP_CARDS'  => WEB_SERVICE_ROOT_URL . '/contact/vcard/exchange',
    'API_DOWNLOAD'=>WEB_SERVICE_ROOT_URL . '/download',
    //ExhibitionLabel get groups
    'API_EXHIBITION_GROUP_CARDS' =>WEB_SERVICE_ROOT_URL .'/accountbiz/follows/group',
    ///expo/vcard/group
    'API_EXHIBITION_VCARD_GROUP' =>WEB_SERVICE_ROOT_URL .'/expo/vcard/group',
    // /expo/vcard/groupcount
    'API_EXHIBITION_VCARD_GROUPCOUNT' =>WEB_SERVICE_ROOT_URL .'/expo/vcard/groupcount',
    'API_EXHIBITION_EXPO_STATISTIC' =>WEB_SERVICE_ROOT_URL.'/expo/statistic',


    ## 我 ##
    'API_GETCANDIDATEID' => WEB_SERVICE_ROOT_URL . '/hr/candidate',
    'API_SHOP' =>WEB_SERVICE_ROOT_URL . '',

    ## 设置接口 ##
    'API_SETTING_BACKGROUND' => WEB_SERVICE_ROOT_URL . '/background',

    ## 云盘资源 添加接口
    'API_STORE_ADDRESOURSE' => WEB_SERVICE_ROOT_URL . '/common/apistore/postrecord',

    //新加（张丽霞）
    'API_SCANCARD_UPLOADFAILEDLIST' => WEB_SERVICE_ROOT_URL.'/scancard/uploadfailedlist',
    'API_SCANCARD_CLOUDCHECK'       => WEB_SERVICE_ROOT_URL.'/scancard/cloudcheck',

	'API_CONTACT_COMMON_GETNAMEPRELIST' => WEB_SERVICE_ROOT_URL.'/contact/common/getnameprelist',
	'API_CONTACT_COMMON_GETNAMEGROUP'   => WEB_SERVICE_ROOT_URL.'/contact/common/getnamegroup',
	'API_COMPANY_LOGO'	                =>WEB_SERVICE_ROOT_URL.'/common/apistore/getcompanylogo', //获取500 强公司logo

    // 获得常见问题
    'API_FAQ_QUESTION' =>WEB_SERVICE_ROOT_URL.'/faq/question',

	'API_INFOMATION_CATEGORY' 			=> WEB_SERVICE_ROOT_URL.'/sns/show/category', //资讯行业分类添加、获得接口
	'API_INFOMATION_CATEGORY_EDIT' 		=> WEB_SERVICE_ROOT_URL.'/sns/show/editcategory', //资讯行业分类编辑接口
	'API_INFOMATION_CATEGORY_DELETE' 	=> WEB_SERVICE_ROOT_URL.'/sns/show/delcategory', //资讯行业分类删除接口
	'API_INFOMATION_COLLECTION_GET' 	=> WEB_SERVICE_ROOT_URL.'/sns/show/crawler', //采集内容的查询
	'API_INFOMATION_COLLECTION_DEL' 	=> WEB_SERVICE_ROOT_URL.'/sns/show/deletecrawler',//采集内容的删除
	'API_INFOMATION_COLLECTION_DEPLOY' 	=> WEB_SERVICE_ROOT_URL.'/sns/show/deploycrawler',//采集内容的发布
	'API_INFOMATION_COLLECTION_EDIT' 	=> WEB_SERVICE_ROOT_URL.'/sns/show/editcrawler',//采集内容的编辑
    //推广
    //'API_POPULAR_CATEGORY' => WEB_SERVICE_ROOT_URL.'/admin/apistore/popularcategory',//获取行业  废弃了
    'API_CATE_POPULAR' => WEB_SERVICE_ROOT_URL.'/admin/apistore/catepopular',  //按行业id推送
    'API_UUID_POPULAR' => WEB_SERVICE_ROOT_URL.'/admin/apistore/uuidpopular', //按照名片id推送
    'API_POPULAR_CARD' => WEB_SERVICE_ROOT_URL.'/admin/apistore/popularcard', //获取推广名片
    'API_IGNORE_POPULAR' => WEB_SERVICE_ROOT_URL.'/admin/apistore/ignorepopular', //删除名片
	//在线客服
	'API_CUSTOM_FRIEND' => WEB_SERVICE_ROOT_URL.'/admin/apistore/customerfriend', //获取客服好友
	'API_GET_VR_CUSTOM' => WEB_SERVICE_ROOT_URL.'/admin/apistore/getcustomer', //获取虚拟客服


	'API_CITY_LIST'         	=> WEB_SERVICE_ROOT_URL . '/cityinfo', //城市
	'API_CITY_PROVINCE_LIST'    => WEB_SERVICE_ROOT_URL . '/common/apistore/getprovince',//省份

    'API_GET_PROVINCE'    => WEB_SERVICE_ROOT_URL . '/admin/apistore/getprovince',//新省份
    'API_GET_CITY'    => WEB_SERVICE_ROOT_URL . '/admin/apistore/getcity',//新城市

    //资源文件上传
    'API_SOURCE_UPLOAD'     => WEB_SERVICE_ROOT_URL.'/common/apistore/upload',

    //用户推广
    'API_USER_PROMOTION'     => WEB_SERVICE_ROOT_URL.'/admin/apistore/userpromotion',
    'API_USER_GETPROMOTION'  => WEB_SERVICE_ROOT_URL.'/admin/apistore/getpromotion',
    'API_USER_EDITPROMOTION' => WEB_SERVICE_ROOT_URL.'/admin/apistore/editpromotion',

    //到期提醒
    'API_ALERT_ADD'  => WEB_SERVICE_ROOT_URL.'/admin/alert/new',
    'API_ALERT_EDIT' => WEB_SERVICE_ROOT_URL.'/admin/alert/edit',
    'API_ALERT_DEL'  => WEB_SERVICE_ROOT_URL.'/admin/alert/delete',
    'API_ALERT_GET'  => WEB_SERVICE_ROOT_URL.'/admin/alert',

    //扫描仪管理
    'API_SCANNER_MANAGER_ADD'     => WEB_SERVICE_ROOT_URL.'/admin/scanner/add', //add
    'API_SCANNER_MANAGER_EDIT'    => WEB_SERVICE_ROOT_URL.'/admin/scanner/edit', //edit
    'API_SCANNER_MANAGER_LIST'    => WEB_SERVICE_ROOT_URL.'/admin/scanner/list', //list
    'API_SCANNER_MANAGER_IMPORT'  => WEB_SERVICE_ROOT_URL.'/admin/scanner/import', //list
    'API_SCANNER_MANAGER_DEL'     => WEB_SERVICE_ROOT_URL.'/admin/scanner/del', //del
    'API_SCANNER_MANAGER_OPERATE' => WEB_SERVICE_ROOT_URL.'/admin/scanner/operate', //外放\回收
    'API_SCANNER_MANAGER_RECORD'  => WEB_SERVICE_ROOT_URL.'/admin/scanner/userecord', //扫描仪外放记录
	'API_SCANNER_MANAGER_VCARD'   => WEB_SERVICE_ROOT_URL.'/admin/scanner/getscan', //获取扫描仪已扫名片记录
	'API_SCANNER_MANAGER_HISTORY' => WEB_SERVICE_ROOT_URL.'/admin/scanner/getbatch', //扫描仪使用记录
	//合作商
	'API_ACCOUNTBIZ_COMPANY_GETBIZ' => WEB_SERVICE_ROOT_URL.'/accountbiz/company/getbiz', //获取合作商
	'API_ACCOUNTBIZ_COMPANY_ADD'    => WEB_SERVICE_ROOT_URL.'/accountbiz/company/add', //修改添加合作商
	'API_ACCOUNTBIZ_COMPANY_EDIT'   => WEB_SERVICE_ROOT_URL.'/accountbiz/company/edit', //修改添加合作商
	'API_ACCOUNTBIZ_COMPANY_active' => WEB_SERVICE_ROOT_URL.'/accountbiz/company/active', //修改合作商状态
	'API_ACCOUNTBIZ_AUTH_ADD' => WEB_SERVICE_ROOT_URL.'/accountbiz/company/ident', //企业认证审核操作
	'API_ACCOUNTBIZ_AUTH_GET' => WEB_SERVICE_ROOT_URL.'/accountbiz/company/getident', //获取企业认证备注信息

	// 名片共享
    'API_CARD_SHARE_LIST'       => WEB_SERVICE_ROOT_URL.'/admin/cardshare/getsharelist', //获取共享列表
	'API_CARD_SHARE_ADD'        => WEB_SERVICE_ROOT_URL.'/admin/cardshare/add', //新建共享
	'API_CARD_SHARE_EDIT'       => WEB_SERVICE_ROOT_URL.'/admin/cardshare/edit', //编辑共享/
	'API_CARD_SHARE_DEL'        => WEB_SERVICE_ROOT_URL.'/admin/cardshare/del', //删除共享
	'API_CARD_SHARE_SHAREDACCOUNT' => WEB_SERVICE_ROOT_URL.'/admin/cardshare/getsharedaccount', //获取被共享账号信息
	'API_CARD_SHARE_CARDLIST'   => WEB_SERVICE_ROOT_URL.'/admin/cardshare/getcardlist', //获取共享名片信息

	'API_CARD_SEE_PERSON'       => WEB_SERVICE_ROOT_URL.'/contact/common/seeme', //谁看过我、我看过谁

    //企业平台登陆注册
	//'API_COMPANY_REGISTER_GET_CATEGORY'=>WEB_SERVICE_ROOT_URL.'/admin/apistore/getcategory', //获取行业接口
	'API_FINANCE_APTITUDE'      => WEB_SERVICE_ROOT_URL.'/accountbiz/apistore/invoice', //财务资质接口
	'API_CUSTOMER_CARD'         => WEB_SERVICE_ROOT_URL.'/bizcard/pool', //客户名片接口
	'API_CUSTOMER_USERGROUP'    => WEB_SERVICE_ROOT_URL.'/accountbiz/employee/depart', // 企业员工部门接口
	'API_CUSTOMER_USER_BYGID'    => WEB_SERVICE_ROOT_URL.'/accountbiz/employee/member', // 根据部门获取企业员工

	'API_ORDERMANAGE_API'       => WEB_SERVICE_ROOT_URL.'/account/order', // 订单管理接口
	'API_ORDERMANAGE_OPERATE'       => WEB_SERVICE_ROOT_URL.'/account/order/handle', //订单订单处理
	'API_COM_REGISTER'          => WEB_SERVICE_ROOT_URL.'/accountbiz/company/register', //企业注册
	'API_ACCOUNTBIZ_EMPLOYEE_GET'          => WEB_SERVICE_ROOT_URL.'/accountbiz/employee/get', //获取企业员工接口

    // 行业和职能 管理
    'API_INDUSTRY_GET'       => WEB_SERVICE_ROOT_URL.'/admin/apistore/getcategory', // 获取
    'API_INDUSTRY_ADD'       => WEB_SERVICE_ROOT_URL.'/admin/apistore/addcategory', // 添加
    'API_INDUSTRY_UPDATE'    => WEB_SERVICE_ROOT_URL.'/admin/apistore/editcategory', // 更新
    'API_INDUSTRY_DELETE'    => WEB_SERVICE_ROOT_URL.'/admin/apistore/deletecategory', // 删除

    // 标签 -> 内容管理
    'API_LABEL_MANAGE'          => WEB_SERVICE_ROOT_URL.'/sns/show/label', // 获取标签， 添加标签
    'API_LABEL_MANAGE_DELETE'   => WEB_SERVICE_ROOT_URL.'/sns/show/deletelabel', // 获取标签

    // 会员卡模板
    'API_ORANGE_TPL_LIST'          => WEB_SERVICE_ROOT_URL.'/admin/orange/getmembershipcard', // 会员卡模板
    'API_ORANGE_TPL_ADD'          => WEB_SERVICE_ROOT_URL.'/admin/orange/addmembershipcard', // 会员卡模板
    'API_ORANGE_TPL_EDIT'          => WEB_SERVICE_ROOT_URL.'/admin/orange/editmembershipcard', // 会员卡模板
    'API_ORANGE_TPL_DEL'          => WEB_SERVICE_ROOT_URL.'/admin/orange/delmembershipcard', // 会员卡模板

    // 用户非模板卡
    'API_ORANGE_USER_TPL_LIST'          => WEB_SERVICE_ROOT_URL.'/admin/orange/getnontempcard', // 会员卡模板
    'API_ORANGE_USER_TPL_EDIT'          => WEB_SERVICE_ROOT_URL.'/admin/orange/editnontempcard', // 会员卡模板

	//设置 ->   地区管理
	'API_GET_PROVINCE_LIST'    => WEB_SERVICE_ROOT_URL .'/admin/apistore/getprovince',//省份列表
	'API_GET_CITY_LIST'    => WEB_SERVICE_ROOT_URL . '/admin/apistore/getcity',//城市列表

	'API_APISTORE_INVITECODECARD'    => WEB_SERVICE_ROOT_URL . '/admin/apistore/invitecodecard',//根据邀请码获得名片信息

	'API_ACCOUNTBIZ_ORDER_RECHARGELOG' => WEB_SERVICE_ROOT_URL . '/accountbiz/order/rechargelog', // 企业账号消费充值接口
	'API_ACCOUNTBIZ_ORDER_ADD' => WEB_SERVICE_ROOT_URL . '/accountbiz/order/add', // 生成企业订单接口
	'API_PAYORDER_LIST' => WEB_SERVICE_ROOT_URL . '/accountbiz/order/list', //获取企业订单接口
	'API_ACCOUNT_COMMON_GETVCARDS' => WEB_SERVICE_ROOT_URL . '/contact/common/getvcards', // 获取他人名片信息详情

	//企业平台->企业动态
	'API_COMPANY_NEWS'=>WEB_SERVICE_ROOT_URL.'/accountbiz/employee/release' ,//获取创建企业动态接口
	'API_COMPANY_EDIT_NEWS'=>WEB_SERVICE_ROOT_URL.'/accountbiz/employee/editrelease' ,//编辑企业动态接口
	//企业平台->客户公司
	'API_COMPANY_DETAIL'=>WEB_SERVICE_ROOT_URL.'/accountbiz/apistore/customer',//获取企业详情接口
    'API_COMPANY_DETAIL_HISTORY'=>WEB_SERVICE_ROOT_URL.'/accountbiz/apistore/customerhistory',//获取企业详情接口
    'API_COMPANYS_LIST'=>WEB_SERVICE_ROOT_URL.'/accountbiz/apistore/companys',//获取企业列表

	//登录后首页
	'API_COMPANY_INDEX_DATA_STATISTICS'=>WEB_SERVICE_ROOT_URL.'/accountbiz/apistore/statistics',//企业平台登陆后首页的数据统计接口

	//orange 标签管理
	'API_ORANGE_TAG_TYPE'=>WEB_SERVICE_ROOT_URL.'/admin/orange/type',//orange获取标签类型接口
	'API_ORANGE_TAG_TYPE_ADD'=>WEB_SERVICE_ROOT_URL.'/admin/orange/tagtype',//orange添加标签类型接口
	'API_ORANGE_TAG'=>WEB_SERVICE_ROOT_URL.'/admin/orange/tag',//orange标签接口
	'API_ORANGE_LABEL_EDIT'=>WEB_SERVICE_ROOT_URL.'/admin/orange/edittag',//orange 标签编辑接口
	'API_ORANGE_LABEL_TYPE_EDIT'=>WEB_SERVICE_ROOT_URL.'/admin/orange/edittagtype',//orange 标签类型编辑接口
	'API_ORANGE_LABEL_DEL'=>WEB_SERVICE_ROOT_URL.'/admin/orange/deltag',//orange 标签删除接口
	'API_ORANGE_LABEL_TYPE_DEL'=>WEB_SERVICE_ROOT_URL.'/admin/orange/deltype',//orange 标签类型删除接口

	//orange 公司别名维护
	'API_ORANGE_ALIAS_GET'=>WEB_SERVICE_ROOT_URL.'/admin/orange/getcompanyalias',//查询公司别名
	'API_ORANGE_ALIAS_ADD'=>WEB_SERVICE_ROOT_URL.'/admin/orange/addcompanyalias',//添加公司别名
	'API_ORANGE_ALIAS_EDIT'=>WEB_SERVICE_ROOT_URL.'/admin/orange/editcompanyalias',//编辑公司别名

	//orange 协议管理
	'API_ORANGE_AGREEMENT_GET'=>WEB_SERVICE_ROOT_URL.'/admin/orange/getagreement',//查询与添加协议
	'API_ORANGE_AGREEMENT_EDIT'=>WEB_SERVICE_ROOT_URL.'/admin/orange/editagreement',//编辑协议
	//静态页面内容管理
	'API_APISTORE_AGREEMENT_GET'=>WEB_SERVICE_ROOT_URL.'/admin/apistore/agreement',//查询与添加内容
	'API_APISTORE_AGREEMENT_EDIT'=>WEB_SERVICE_ROOT_URL.'/admin/apistore/editagreement',//内容编辑

	//orange 预警设置
	'API_ORANGE_WARNING_SET_USER_GET' => WEB_SERVICE_ROOT_URL.'/admin/orange/getwarningset',//获取预警人
	'API_ORANGE_WARNING_SET_USER_ADD' => WEB_SERVICE_ROOT_URL.'/admin/orange/addwarningset',//添加预警人
	'API_ORANGE_WARNING_SET_USER_DEL' => WEB_SERVICE_ROOT_URL.'/admin/orange/delwarningset',//删除预警人
	'API_ORANGE_WARNING_NUM_GET'      => WEB_SERVICE_ROOT_URL.'/admin/orange/getorangeset',//获取预警次数
	'API_ORANGE_WARNING_NUM_EDIT'     => WEB_SERVICE_ROOT_URL.'/admin/orange/editorangeset',//修改预警次数

	//orange 推荐规则
	'API_ORANGE_RECOMMEND_RULE_GET'   => WEB_SERVICE_ROOT_URL.'/admin/orange/getrecommrule',// 推荐规则
	'API_ORANGE_RECOMMEND_RULE_UPDATE'=> WEB_SERVICE_ROOT_URL.'/admin/orange/editrecommrule',// 推荐规则

	// orange  预警信息提取规则
	'API_ORANGE_EXTRACT_RULE_GET'   => ORANGE_EXTRACT_RULE_SERVICE_URL.'/xa-apistore/billmail/failed_issue',// 预警信息提取规则


    // orange 发卡单位
    'API_ORANGE_ISSUE_UNIT_GET'       => WEB_SERVICE_ROOT_URL.'/admin/orange/getcardlssuer',
    'API_ORANGE_ISSUE_UNIT_ADD'       => WEB_SERVICE_ROOT_URL.'/admin/orange/addcardlssuer',
    'API_ORANGE_ISSUE_UNIT_EDIT'      => WEB_SERVICE_ROOT_URL.'/admin/orange/editcardlssuer',
    'API_ORANGE_ISSUE_UNIT_DELETE'    => WEB_SERVICE_ROOT_URL.'/admin/orange/delcardlssuer',
    // orange 卡类型
    'API_ORANGE_CARD_TYPE_ATTR_GET'   => WEB_SERVICE_ROOT_URL.'/admin/orange/getcardattribute',

	//orange 商户详情
	'API_ORANGE_UNIT_DETAIL_GET'   => WEB_SERVICE_ROOT_URL.'/admin/orangestore/getmerch',//获取
	'API_ORANGE_UNIT_DETAIL_ADD'   => WEB_SERVICE_ROOT_URL.'/admin/orangestore/addmerch',//添加
	'API_ORANGE_UNIT_DETAIL_EDIT'   => WEB_SERVICE_ROOT_URL.'/admin/orangestore/editmerch',//编辑

	//硬件管理 权益卡 商户分类管理
	'API_ORANGE_STORE_TYPE_GET'   => WEB_SERVICE_ROOT_URL.'/admin/orangestore/gettype',//获取
	'API_ORANGE_STORE_TYPE_ADD'   => WEB_SERVICE_ROOT_URL.'/admin/orangestore/addtype',//添加
	'API_ORANGE_STORE_TYPE_EDIT'   => WEB_SERVICE_ROOT_URL.'/admin/orangestore/edittype',//编辑
	'API_ORANGE_STORE_TYPE_DEL'   => WEB_SERVICE_ROOT_URL.'/admin/orangestore/deltype',//删除
	'API_ORANGE_STORE_TOP'   => WEB_SERVICE_ROOT_URL.'/admin/orangestore/top',//商户权益城市或分类置顶操作接口
	//硬件管理 权益卡城市管理
	'API_ORANGE_STORE_CITY_GET'   => WEB_SERVICE_ROOT_URL.'/admin/orangestore/getcity',//获取
	'API_ORANGE_STORE_CITY_ADD'   => WEB_SERVICE_ROOT_URL.'/admin/orangestore/addcity',//添加
	'API_ORANGE_STORE_CITY_DEL'   => WEB_SERVICE_ROOT_URL.'/admin/orangestore/delcity',//删除
	'API_ORANGE_STORE_CITY_EDIT'   => WEB_SERVICE_ROOT_URL.'/admin/orangestore/editcity',//编辑

	//获取商户详情分类下的城市中单位的排序
	'API_ORANGE_STORE_SHOW_SORT'   => WEB_SERVICE_ROOT_URL.'/admin/orangestore/getsort',



    // APP版本控制
    'API_ORANGE_APP_VERSION'   => WEB_SERVICE_ROOT_URL.'/admin/apistore/version',//添加post，查询get
    'API_ORANGE_APP_EDIT_VERSION'   => WEB_SERVICE_ROOT_URL.'/admin/apistore/editversion',//编辑，删除
    
    //银联APP下载地址
    'API_ORANGE_APP_DOWNLOAD'   => WEB_SERVICE_ROOT_URL.'/admin/apistore/unionpay',//添加修改POST，查询 GET
    
    // 橙子数据采集规则定义API， 另外一台server
    'API_DAS_PARSE_RULE_GET'    => ORANGE_WEB_SERVICE_URL . '/get_parser',    // 获取已有解释器
    'API_DAS_PARSE_RULE_DELETE' => ORANGE_WEB_SERVICE_URL . '/remove_parser', // 删除已有解析器
    'API_DAS_PARSE_RULE_ADD'    => ORANGE_WEB_SERVICE_URL . '/add_parser',    // 添加新的解释器
    'API_DAS_PARSE_RULE_VERIFY' => ORANGE_WEB_SERVICE_URL . '/verify_parser', // 测试解析器
    'API_DAS_PARSE_RULE_UPDATE' => ORANGE_WEB_SERVICE_URL . '/update_parser', // 更新已有解释器
    'API_DAS_FAIL_RULE_GET'     => ORANGE_WEB_SERVICE_URL . '/get_failed',    // 获取解析失败的所有模版
    'API_DAS_FAIL_RULE_DETAIL'  => ORANGE_WEB_SERVICE_URL . '/get_failed/displayname', // 获取解析失败的模版详情
    'API_DAS_CLOUD_COMPANY'     => ORANGE_WEB_SERVICE_URL . '/xa-apistore/card/cloud/company', // 获取应用数据抓取的公司列表信息
    'API_DAS_CLOUD_BANK'     => ORANGE_WEB_SERVICE_URL . '/xa-apistore/billmail/support_bank', // 获取应用数据抓取的公司列表信息

    //发送短信接口
    'API_SMS'     => WEB_SERVICE_ROOT_URL . '/phonesms', // 发送短信

	//名片扫描服务-获取扫描仪设备列表
	'API_SCANNER_LIST'   =>WEB_SERVICE_ROOT_URL . '/admin/scannerv2/list',
	'API_SCANNER_LOCATION_LIST'   =>WEB_SERVICE_ROOT_URL . '/admin/scannerv2/location',
	//名片扫描服务
	'API_SCANNER_ERR_LIST'   =>WEB_SERVICE_ROOT_URL . '/admin/scannerv2/buglist',//故障历史记录
	'API_SCANNER2_ADD'  =>WEB_SERVICE_ROOT_URL . '/admin/scannerv2/add',//添加扫描仪设备
	'API_SCANNER2_EDIT'  =>WEB_SERVICE_ROOT_URL . '/admin/scannerv2/edit',//编辑扫描仪设备
	'API_SCANNER2_STATISTICS'  =>WEB_SERVICE_ROOT_URL . '/admin/scannerv2/statistics',//扫描仪使用统计
    'API_SCANNER2_USE_LIST'  =>WEB_SERVICE_ROOT_URL . '/admin/scannerv2/uselist',//扫描仪使用列表
	'API_SCANNER2_DEL'  =>WEB_SERVICE_ROOT_URL . '/admin/scannerv2/del',//删除扫描仪
	'API_SCANNER2_RESTART'  =>WEB_SERVICE_ROOT_URL . '/admin/scannerv2/restart',//重启扫描仪
	'API_SCANNER2_BALANCE'  =>WEB_SERVICE_ROOT_URL . '/admin/scannerv2/balance',//余额提醒获取手机号/流量/余额信息等
	'API_SCANNER2_SETREMINDPRICE'  =>WEB_SERVICE_ROOT_URL . '/admin/scannerv2/setremindprice',//余额提醒设置提醒金额
	'API_SCANNER2_ADDREMINDUSER'  =>WEB_SERVICE_ROOT_URL . '/admin/scannerv2/addreminduser',//添加余额提醒接收人
	'API_SCANNER2_GETREMINDUSER'  =>WEB_SERVICE_ROOT_URL . '/admin/scannerv2/getreminduser',//获取余额提醒接收人
	'API_SCANNER2_DELREMINDUSER'  =>WEB_SERVICE_ROOT_URL . '/admin/scannerv2/delreminduser',//删除余额提醒接收人


	//微信公众号接口
	'API_SEND_EMAIL'  =>WEB_SERVICE_ROOT_URL . '/common/apistore/sendmessage',//发送邮件

	//酒店门禁卡
	'API_ADD_ENCRYPT'=>WEB_SERVICE_ROOT_URL . '/admin/orangehotel/addencrypt',//添加加密类型
	'API_GET_ENCRYPT'=>WEB_SERVICE_ROOT_URL . '/admin/orangehotel/getencrypt',//获取加密类型
	'API_EDIT_ENCRYPT'=>WEB_SERVICE_ROOT_URL . '/admin/orangehotel/editencrypt',//修改加密类型
	'API_DEL_ENCRYPT'=>WEB_SERVICE_ROOT_URL . '/admin/orangehotel/delencrypt',//删除加密类型

	'API_ADD_HOTEL'=>WEB_SERVICE_ROOT_URL . '/admin/orangehotel/addhotel',//添加酒店
	'API_GET_HOTEL'=>WEB_SERVICE_ROOT_URL . '/admin/orangehotel/gethotel',//获取酒店
	'API_EDIT_HOTEL'=>WEB_SERVICE_ROOT_URL . '/admin/orangehotel/edithotel',//修改酒店
	'API_DEL_HOTEL'=>WEB_SERVICE_ROOT_URL . '/admin/orangehotel/delhotel',//删除酒店

	'API_ADD_HOTEL_IMG'=>WEB_SERVICE_ROOT_URL . '/admin/orangehotel/addresource',//添加酒店图集
	'API_GET_HOTEL_IMG'=>WEB_SERVICE_ROOT_URL . '/admin/orangehotel/getresource',//获取酒店图集
	'API_EDIT_HOTEL_IMG'=>WEB_SERVICE_ROOT_URL . '/admin/orangehotel/editresource',//修改酒店图集


    //BSSID
    'API_HOTELCARD_GET_BSSID'  =>WEB_SERVICE_ROOT_URL . '/admin/orangehotel/getbssid',//获取酒店bssid
    'API_HOTELCARD_ADD_BSSID'  =>WEB_SERVICE_ROOT_URL . '/admin/orangehotel/addbssid',//新增酒店bssid
    'API_HOTELCARD_EDIT_BSSID'  =>WEB_SERVICE_ROOT_URL . '/admin/orangehotel/editbssid',//编辑酒店bssid
	'API_HOTELCARD_DEL_BSSID'  =>WEB_SERVICE_ROOT_URL . '/admin/orangehotel/delbssid',//删除酒店bssid
	'API_IMPORT_HOTEL'=>WEB_SERVICE_ROOT_URL . '/admin/orangehotel/addbatch',//导入酒店
);
