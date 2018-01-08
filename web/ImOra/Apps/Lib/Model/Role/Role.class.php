<?php
namespace Model\Role;
/*
 * 鉴权接口 API 相关接口
 * @author jiyl <jiyl@oradt.com>
 * @date   2015-12-15
 */
use Model\WebService;
class Role extends WebService{
	public function __construct()
	{
		parent::__construct();
	}

	public function getRoleList($params = array(),$crudMethod = 'R')
	{
		/*return array(
			array('username'=>'wang','role'=>'管理员','ip'=>'127.0.0.1','lastlogintime'=>'2014-10-22','email'=>'wang@oradt.com','realname'=>'wang'),
			array('username'=>'wu','role'=>'管理员','ip'=>'127.0.0.1','lastlogintime'=>'2014-10-22','email'=>'wu@oradt.com','realname'=>'wu'),
			array('username'=>'zhang','role'=>'管理员','ip'=>'127.0.0.1','lastlogintime'=>'2014-10-22','email'=>'zhang@oradt.com','realname'=>'zhang'),
			array('username'=>'li','role'=>'管理员','ip'=>'127.0.0.1','lastlogintime'=>'2014-10-22','email'=>'li@oradt.com','realname'=>'li'),
			array('username'=>'zhao','role'=>'管理员','ip'=>'127.0.0.1','lastlogintime'=>'2014-10-22','email'=>'zhao@oradt.com','realname'=>'zhao'),
			array('username'=>'liu','role'=>'管理员','ip'=>'127.0.0.1','lastlogintime'=>'2014-10-22','email'=>'liu@oradt.com','realname'=>'liu'),
			);*/
		// web service 接口路径
		$webServiceRootUrl = C('WEB_SERVICE_ROOT_URL'). '/admin/role';
        //echo $webServiceRootUrl = C('LOAD_EXT_CONFIG.API_ACCOUNTBIZ_AUTHORIZATION_ROLE');die;
        // 设置请求方法为 读取
        switch ($crudMethod){
            case 'R':
                // 设置请求方法为 读取
                $crudMethod = parent::OC_HTTP_CRUD_R;
                break;
            case 'U':
                // 设置请求方法为 更新
                $crudMethod = parent::OC_HTTP_CRUD_U;
                break;
            case 'C':
                // 设置请求方法为 新建
                $crudMethod = parent::OC_HTTP_CRUD_C;
                break;
            case 'D':
                // 设置请求方法为 删除
                $crudMethod = parent::OC_HTTP_CRUD_D;
                break;
            default:
                $crudMethod = parent::OC_HTTP_CRUD_R;
        }
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
	}

    //获取企业角色列表
    public function getBizRoleList($params){
        // web service 接口路径
        $webServiceRootUrl = C('API_ACCOUNTBIZ_AUTHORIZATION_ROLE');
        // 设置请求方法为 读取
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 设置请求参数
        //$params = array();
        // 发送http请求
        //print_r($params);die;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        $result = parseApi($response);
        return $result;
    }

    //创建角色列表
    public function createBizRole($params){
        // web service 接口路径
        $webServiceRootUrl = C('API_ACCOUNTBIZ_AUTHORIZATION_ROLE');
        // 设置请求方法为 读取
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 设置请求参数
        //$params = array();
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        $result = parseApi($response);
        return $result;
    }

    //更新角色
    public function updateBizRole($params){
        // web service 接口路径
        $webServiceRootUrl = C('API_ACCOUNTBIZ_AUTHORIZATION_ROLE');
        // 设置请求方法为 读取
        $crudMethod = parent::OC_HTTP_CRUD_U;
        // 设置请求参数
        //$params = array();
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        $result = parseApi($response);
        return $result;
    }

    //创建角色
    public function delBizRole($params){
        // web service 接口路径
        $webServiceRootUrl = C('API_ACCOUNTBIZ_AUTHORIZATION_ROLE');
        // 设置请求方法为 读取
        $crudMethod = parent::OC_HTTP_CRUD_D;
        // 设置请求参数
        //$params = array();
        // 发送http请求
        //print_r($params);die;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);

        $result = parseApi($response);
        return $result;
    }

    //获取员工
    public function getEmployee($params){
        // web service 接口路径
        $webServiceRootUrl = C('API_ACCOUNTBIZ_EMPLOYEE_GET_ROLEEMP');
        // 设置请求方法为 读取
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 设置请求参数
        //$params = array();
        // 发送http请求
        /*echo '<pre>';
        print_r($params);die;*/
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);

        $result = parseApi($response);
        return $result;
    }

    //发送邮件
    public function sendMail($params){
        // web service 接口路径
        $webServiceRootUrl = C('API_SEND_MAIL');
        // 设置请求方法为 读取
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 设置请求参数
        //$params = array();
        // 发送http请求
        /*echo '<pre>';
        print_r($params);die;*/
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);

        $result = parseApi($response);
        return $result;
    }
    //发送短信
    public function sendSMS($params){
        // web service 接口路径
        $webServiceRootUrl = C('API_SMS');
        // 设置请求方法为 读取
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 设置请求参数
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);

        $result = parseApi($response);
        return $result;
    }
}
