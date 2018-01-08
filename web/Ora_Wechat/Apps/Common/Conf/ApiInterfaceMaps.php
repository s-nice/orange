<?php
defined('WEB_SERVICE_ROOT_URL') OR define('WEB_SERVICE_ROOT_URL', rtrim(C('WEB_SERVICE_ROOT_URL'), '/'));
defined('ORANGE_WEB_SERVICE_URL') OR define('ORANGE_WEB_SERVICE_URL', rtrim(C('ORANGE_WEB_SERVICE_URL'), '/'));
defined('ORANGE_EXTRACT_RULE_SERVICE_URL') OR define('ORANGE_EXTRACT_RULE_SERVICE_URL', rtrim(C('ORANGE_EXTRACT_RULE_SERVICE_URL'), '/'));

return array(
	'API_WX_GET_ENT_INFO'    => WEB_SERVICE_ROOT_URL.'/wxbiz/admin/getbiz', //获取企业信息接口
    //企业名片
    'API_WX_BIZCARD_GET'      => WEB_SERVICE_ROOT_URL.'/wxbiz/bizcard/getbizcard',
    'API_WX_BIZCARD_GET_MORE' => WEB_SERVICE_ROOT_URL.'/wxbiz/bizcard/getbizcardsenior',
    'API_WX_BIZCARD_ADD'      => WEB_SERVICE_ROOT_URL.'/wxbiz/bizcard/addcard',
    'API_WX_BIZCARD_EDIT'     => WEB_SERVICE_ROOT_URL.'/wxbiz/bizcard/editcard',
    'API_WX_BIZCARD_DEL'      => WEB_SERVICE_ROOT_URL.'/wxbiz/bizcard/deletecard',
    'API_WX_BIZCARD_ADDTAG'   => WEB_SERVICE_ROOT_URL.'/wxbiz/bizcard/addcardtag',
    'API_WX_BIZCARD_COUNT'    => WEB_SERVICE_ROOT_URL.'/wxbiz/bizcard/bizcardcount',
    
    //图片上传接口
    'API_PICTURE_UPLOAD'     =>  WEB_SERVICE_ROOT_URL.'/upload',
    
    //名片分享
    /*'API_WX_SHARE_SETTINGS' => WEB_SERVICE_ROOT_URL.'/wxbiz/cardshare/settings',//废弃不用*/
    'API_WX_SHARE_ADD'      => WEB_SERVICE_ROOT_URL.'/wxbiz/cardshare/addshare',
    'API_WX_SHARE_GET'      => WEB_SERVICE_ROOT_URL.'/wxbiz/cardshare/get',
    'API_WX_SHARE_DEL'      => WEB_SERVICE_ROOT_URL.'/wxbiz/cardshare/delshare',
    
    //企业名片标签
    'API_WX_BIZTAG_GET'  => WEB_SERVICE_ROOT_URL.'/wxbiz/admin/getbiztag',
    'API_WX_BIZTAG_ADD'  => WEB_SERVICE_ROOT_URL.'/wxbiz/admin/addbiztag',
    'API_WX_BIZTAG_EDIT' => WEB_SERVICE_ROOT_URL.'/wxbiz/admin/editbiztag',
    'API_WX_BIZTAG_DEL'  => WEB_SERVICE_ROOT_URL.'/wxbiz/admin/delbiztag',

    //企业后台 部门、员工接口定义
    'API_COMPANY_DEPART_GET'=>WEB_SERVICE_ROOT_URL.'/wxbiz/admin/getdepart',//获取部门
    'API_COMPANY_DEPART_ADD'=>WEB_SERVICE_ROOT_URL.'/wxbiz/admin/depart',//添加部门
    'API_COMPANY_DEPART_EDIT'=>WEB_SERVICE_ROOT_URL.'/wxbiz/admin/edpart',//修改部门
    'API_COMPANY_DEPART_DEL'=>WEB_SERVICE_ROOT_URL.'/wxbiz/admin/delpart',//删除部门
    'API_COMPANY_STAFF_GET'=>WEB_SERVICE_ROOT_URL.'/wxbiz/admin/getemp',//获取员工
    'API_COMPANY_STAFF_ADD'=>WEB_SERVICE_ROOT_URL.'/wxbiz/admin/addemp',//添加员工
    'API_COMPANY_STAFF_EDIT'=>WEB_SERVICE_ROOT_URL.'/wxbiz/admin/editemp',//删除员工
    'API_COMPANY_REG_RESETPWD'=>WEB_SERVICE_ROOT_URL.'/wxbiz/oauth/resetpassword',//重置密码


    //检查手机是否注册
    'API_EMP_CHECK_MOBILE'=>WEB_SERVICE_ROOT_URL.'/wxbiz/employee/empcheckmobile',//检查手机是否注册
	'API_COMPANY_CHECK_NAME'=>WEB_SERVICE_ROOT_URL.'/wxbiz/admin/bizrename',//检查公司名是否注册

	//#管理后台#
	//管理后台-管理员账号
	'API_ADMIN_LOGIN'=>WEB_SERVICE_ROOT_URL.'/admin/biz/login',//管理员登陆
	'API_ADMIN_ADD'=>WEB_SERVICE_ROOT_URL.'/admin/add',//管理员账户添加
	'API_ADMIN_GET'=>WEB_SERVICE_ROOT_URL.'/admin/get',//管理员账户获取
	'API_ADMIN_EDIT'=>WEB_SERVICE_ROOT_URL.'/admin/edit',//管理员账户编辑
	'API_ADMIN_DEL'=>WEB_SERVICE_ROOT_URL.'/admin/delete',//管理员账户删除
	
	//管理后台-企业信息接口
	'API_ADMIN_COMPANY_INFO'=>WEB_SERVICE_ROOT_URL.'/admin/biz/getbizlist',//获取企业信息列表
	'API_ADMIN_COMPANY_STATUS_EDIT'=>WEB_SERVICE_ROOT_URL.'/admin/biz/status',//修改企业状态
	
    'API_ADMIN_COMPANY_EMPLOYEE_LIST'=>WEB_SERVICE_ROOT_URL.'/admin/biz/getemployeelist',//获取企业员工列表
    'API_ADMIN_COMPANY_EMPLOYEE_STATUS_EDIT'=>WEB_SERVICE_ROOT_URL.'/admin/biz/employeestatus',//修改状态
    'API_ADMIN_COMPANY_EMPLOYEE_PASSWORD_EDIT'=>WEB_SERVICE_ROOT_URL.'/admin/biz/employeepassword',//修改密码
    
    
    'API_ADMIN_COMPANY_DEPARTMENT_LIST'=>WEB_SERVICE_ROOT_URL.'/admin/biz/getdepartmentlist',//获取部门列表
    
    //系统消息
    'API_COMPANY_GET_MSG'=>WEB_SERVICE_ROOT_URL.'/wxbiz/sysmsg/getmsglist',//获取系统消息
    'API_COMPANY_SET_MSG'=>WEB_SERVICE_ROOT_URL.'/wxbiz/sysmsg/setmsgdeal',//处理系统消息
    'API_COMPANY_DEL_MSG'=>WEB_SERVICE_ROOT_URL.'/wxbiz/sysmsg/delmsg',//删除系统消息


    //套餐元数据列表
    'API_SUITE_GET'=>WEB_SERVICE_ROOT_URL.'/admin/suite/getsuitemetadatalist',//获取套餐元数据列表
    'API_SUITE_ADD'=>WEB_SERVICE_ROOT_URL.'/admin/suite/add',//套餐元数据添加
    'API_SUITE_SET'=>WEB_SERVICE_ROOT_URL.'/admin/suite/update',//套餐元数据修改
    'API_SUITE_DEL'=>WEB_SERVICE_ROOT_URL.'/admin/suite/update',//套餐元数据删除
    'API_SUITE_FREE_GET'=>WEB_SERVICE_ROOT_URL.'/admin/suite/suitefree',//获取赠送套餐（是否有赠送）
    'API_SUITE_BUY'=>WEB_SERVICE_ROOT_URL.'/admin/suite/suite',//套餐购买（赠送）
    'API_SUITE_FREE'=>WEB_SERVICE_ROOT_URL.'/admin/suite/updatesuitefree',//套餐赠送id修改
    
    //企业套餐数据列表
    'API_BIZSUITE_GET'=>WEB_SERVICE_ROOT_URL.'/admin/suite/getsuitelist',//获取企业套餐元数据列表
    'API_BIZSUITE_ADD'=>WEB_SERVICE_ROOT_URL.'/admin/bizsuite/add',//套餐元数据添加
    'API_BIZSUITE_SET'=>WEB_SERVICE_ROOT_URL.'/admin/bizsuite/update',//套餐元数据修改
    'API_BIZSUITE_DEL'=>WEB_SERVICE_ROOT_URL.'/admin/bizsuite/update',//套餐元数据删除

    //套餐订单列表
    'API_ORDERBIZ_GET'=>WEB_SERVICE_ROOT_URL.'/admin/order/getorderlist',//获取订单套餐数据列表
    'API_ORDERBIZ_ADD'=>WEB_SERVICE_ROOT_URL.'/admin/suite/add',//套餐元数据添加
    'API_ORDERBIZ_SET'=>WEB_SERVICE_ROOT_URL.'/admin/suite/update',//套餐元数据修改
    'API_ORDERBIZ_DEL'=>WEB_SERVICE_ROOT_URL.'/admin/suite/update',//套餐元数据删除
);
