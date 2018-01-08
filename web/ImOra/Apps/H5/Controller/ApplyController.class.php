<?php
namespace H5\Controller;

use BaseController\BaseController;
use Think\Controller;
use Classes\GFunc;
use Classes\Factory;

/**
 * 官网报名
 * */
class ApplyController extends BaseController
{
    /*
	 * 是否检查登陆状态。 如果检查登陆状态， controller里面会自动检测登陆。
	 * @var bool
	 */
    protected $toCheckLogin = FALSE;

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 官网报名页面
     * */

    public function index(){
        $show = $this->getAppName() == 'pc' ? 'News/linPc' : 'News/linH5';
        $this->display($show);

    }

    /**
     * 添加操作
     * */
    public function doAdd(){
    	header("Access-Control-Allow-Origin: *");
        $contactname=I('contactname');//姓名
        $contactinfo=I('contactinfo');//联系方式
        $reg = '/^1\d{10}$/';

        if(!empty($contactinfo) && !empty($contactname) &&  preg_match($reg,$contactinfo)){
            $params = array('contactname' => $contactname,'contactinfo'=>$contactinfo,'curip'=> get_client_ip());
            $res = \AppTools::webService('\Model\Common\Common',
                'callApi',
                array(
                    'url'    =>  rtrim(C('WEB_SERVICE_ROOT_URL')) .'/common/apistore/addcontact',
                    'params' => $params,
                    'crud'=>'C'
                )
            );
            $this->ajaxReturn($res);
        }else{
            $this->ajaxReturn(array('status'=>'error'));
        }
    }

    /**
     * 判断访问设备类型
     *
     * */
    protected function getAppName()
    {
        $type='';
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        if(strpos($agent, 'iphone')){
            $type='mobile';
        }elseif(strpos($agent, 'ipad')){
            $type='pc';
        }elseif(strpos($agent, 'android')){
            $type='mobile';
        }else{
            $type = 'pc';
        }
        return $type;
    }





}

/* EOF */