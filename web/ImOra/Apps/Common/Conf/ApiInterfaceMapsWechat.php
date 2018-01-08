<?php
//defined('WEB_SERVICE_ROOT_URL') OR define('WEB_SERVICE_ROOT_URL', rtrim(C('WEB_SERVICE_ROOT_URL'), '/'));
defined('ORANGE_WEB_SERVICE_URL') OR define('ORANGE_WEB_SERVICE_URL', rtrim(C('ORANGE_WEB_SERVICE_URL'), '/'));
defined('ORANGE_EXTRACT_RULE_SERVICE_URL') OR define('ORANGE_EXTRACT_RULE_SERVICE_URL', rtrim(C('ORANGE_EXTRACT_RULE_SERVICE_URL'), '/'));
defined('WEB_SERVICE_ROOT_URL_WECHAT') OR define('WEB_SERVICE_ROOT_URL_WECHAT', rtrim(C('WEB_SERVICE_ROOT_URL_WECHAT'), '/'));
/**
 * 公众号接口定义列表
 */
return array(

	'API_SEND_EMAIL'  =>WEB_SERVICE_ROOT_URL_WECHAT . '/common/apistore/sendmessage',//发送邮件,可以带附件
	'API_WX_GET_VCARD_LIST'  => WEB_SERVICE_ROOT_URL_WECHAT . '/common/wechat/getwechat',//获取名片列表
	'API_WX_GET_BIZCARD_LIST'  => WEB_SERVICE_ROOT_URL_WECHAT . '/common/card/wxgetcard',//获取企业名片列表
	'API_WX_GET_BIZCARD_COUNT'  => WEB_SERVICE_ROOT_URL_WECHAT . '/common/card/wxgetcardcount',//获取企业名片数量
	'API_WX_GET_BIZCARD_INFO'  => WEB_SERVICE_ROOT_URL_WECHAT . '/wxbiz/bizcard/getbizcard',//获取企业名片信息
	'API_WX_GET_BIZCARD_DETAIL'  => WEB_SERVICE_ROOT_URL_WECHAT . '/common/card/wxgetcardinfo',//获取企业名片详细信息
	'API_WX_GET_BIZCARD_EDIT'  => WEB_SERVICE_ROOT_URL_WECHAT . '/common/card/wxeditcard',//编辑企业名片
	'API_WX_GET_BIZCARD_DELETE'  => WEB_SERVICE_ROOT_URL_WECHAT . '/common/card/wxdeletecard',//企业名片删除
	'API_WX_GET_ANY_SWEEP'  => WEB_SERVICE_ROOT_URL_WECHAT . '/common/wechat/otherpic', //获取任意扫列表
	'API_WX_Bind_USER_INFO'  => WEB_SERVICE_ROOT_URL_WECHAT . '/common/wechat/bindingwechat', //绑定用户
	'API_WX_BIND_SCANNER' => WEB_SERVICE_ROOT_URL . '/contact/scanner/addscanner', //微信用户绑定扫描仪,此接口前缀地址在橙子橙脉上
	'API_WX_GET_PUSH_HISTORY' => WEB_SERVICE_ROOT_URL_WECHAT . '/common/wx/getwxpush', //获取推送消息历史记录

    'API_WX_SEND_MOBILE_CODE'  => WEB_SERVICE_ROOT_URL_WECHAT . '/verification/sms', //发送短信验证码
    'API_WX_BIND_EMPLOYEE'  => WEB_SERVICE_ROOT_URL_WECHAT . '/wxbiz/oauth/bindbiz', //绑定员工
    'API_WX_ENT_UNBIND_EMPLOY'  => WEB_SERVICE_ROOT_URL_WECHAT . '/wxbiz/oauth/unbindbiz', //员工解绑企业
    'API_WX_GET_ENT_INFO'  => WEB_SERVICE_ROOT_URL_WECHAT . '/wxbiz/admin/getbiz', //获取企业信息接口
    'API_WX_GET_ENT_BIND_EMPLOY'  => WEB_SERVICE_ROOT_URL_WECHAT . '/wxbiz/admin/getbiz', //员工绑定企业
	'API_WX_USER_REGISTER'  => WEB_SERVICE_ROOT_URL_WECHAT . '/wxbiz/admin/regist', //公众号个人端企业注册
	'API_WX_ADDUNSUBSCRIBE_LOG' => WEB_SERVICE_ROOT_URL_WECHAT . '/common/wechat/unsubscribe', //公众号取消关注添加日志
	'API_WX_CHECK_COMNAME' => WEB_SERVICE_ROOT_URL_WECHAT . '/wxbiz/admin/bizrename', //公众号取消关注添加日志
	'API_WX_CHECK_MOBILE' => WEB_SERVICE_ROOT_URL_WECHAT . '/wxbiz/employee/empcheckmobile', //公众号取消关注添加日志
	'API_WX_CARD_BATCH_SHARE' => WEB_SERVICE_ROOT_URL_WECHAT . '/common/wechat/wechatshare', //公众号取消关注添加日志
	'API_WX_CHECK_INDENT' => WEB_SERVICE_ROOT_URL_WECHAT . '/common/wechat/authuser', //公众号取消关注添加日志
	'API_WX_SHARE_TO_COMPANY' => WEB_SERVICE_ROOT_URL_WECHAT . '/common/wechat/synccardtobiz', //微信分享名片同步到企业
	'API_WX_EXPORT_LOG' => WEB_SERVICE_ROOT_URL_WECHAT . '/common/wx/getdownexcelcardlog', //导出名片日志
	'API_WX_EXPORT_EXCEL'  =>WEB_SERVICE_ROOT_URL_WECHAT . '/common/wx/syncdownexcelcard',//名片导出excel发送邮件,可以带附件
	'API_WX_GET_BATCH_VCARD_LIST'  => WEB_SERVICE_ROOT_URL_WECHAT . '/common/wechat/getwechatcard',//根据批次号获取个人名片列表

);
