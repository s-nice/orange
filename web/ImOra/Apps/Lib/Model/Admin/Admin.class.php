<?php
namespace Model\Admin;
/*
 * 鉴权接口 API 相关接口
 * @author jiyl <jiyl@oradt.com>
 * @date   2015-12-15
 */
use Model\WebService;
class Admin extends WebService{
    private $urlAdmin;
    private $urlRole;
	public function __construct()
	{
		parent::__construct();
        $this->urlAdmin =C('API_ADMIN'); 
        $this->urlRole =C('API_ADMIN_ROLE'); 
	}
	
    private function getMethod($crudMethod){
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
        return $crudMethod;
    }

    private function getResponse($webServiceRootUrl, $crudMethod, $params){
        $crudMethod = $this->getMethod($crudMethod);
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }

    //角色列表
	public function getRoleList($params = array(),$crudMethod = 'R')
	{
        $response = $this->getResponse($this->urlRole, $crudMethod, $params);
        return $response;
	}

    //管理员列表
    public function getAdminList($params = array(),$crudMethod = 'R')
    {
        $response = $this->getResponse($this->urlAdmin, $crudMethod, $params);
        return $response;
    }


    //添加管理员
    public function createAdmin($params = array(),$crudMethod = 'C'){

        $response = $this->getResponse($this->urlAdmin, $crudMethod, $params);
        return $response;
    }


    //更新管理员
    public function updateAdmin($params = array(),$crudMethod = 'U'){

        $response = $this->getResponse($this->urlAdmin, $crudMethod, $params);
        return $response;
    }
    //删除管理员
    public function delAdmin($params = array(),$crudMethod = 'D'){

        $response = $this->getResponse($this->urlAdmin, $crudMethod, $params);
        return $response;
    }

    //添加角色
    public function createRole($params = array(),$crudMethod = 'C'){
        $response = $this->getResponse($this->urlRole, $crudMethod, $params);
        return $response;
    }


    //更新角色
    public function updateRole($params = array(),$crudMethod = 'U'){
        $response = $this->getResponse($this->urlRole, $crudMethod, $params);
        return $response;
    }
    //删除角色
    public function delRole($params = array(),$crudMethod = 'D'){
        $response = $this->getResponse($this->urlRole, $crudMethod, $params);
        return $response;
    }

}
