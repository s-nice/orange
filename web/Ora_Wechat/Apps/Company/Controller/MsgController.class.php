<?php
namespace Company\Controller;

use Think\Controller;
use Classes\Factory;
use Classes\GFunc;
import('Factory', LIB_ROOT_PATH . 'Classes/');

class MsgController extends BaseController
{
    private $rows = 10;
    public function _initialize()
    {
        parent::_initialize();
        $this->assign('title','消息管理-橙鑫科技企业平台');
        $this->assign('moreCSSs',array('css/Company/division'));
    }


    public function index(){
        $p = intval(I('get.p',1));
        $p = max($p,1);
        $session = session(MODULE_NAME);
        //$params['bizid'] = $session['bizid'];
        $params['rows'] = $this->rows;
        $params['start'] = ($p-1)*$this->rows;
        $res = \AppTools::webService('\Model\Company\CompanyMsg', 'getMsg', array('params'=>$params));
        $list = array();
        $numfound = 0;
        if(isset($res['data']['list'])){
            $list = $res['data']['list'];
            $numfound = $res['data']['numfound'];
        }
        $page = getpage($numfound, $this->rows);//使用分页类
        //p($page);die;
        $this->assign('list',$list);
        $this->assign('pagedata',$page->show());
        $this->assign('breadcrumbs',array('key'=>'manageset','info'=>'labelmanage','show'=>'')); //没有导航菜单
        //$this->display('index');
    }

    //获取未读消息数量
    public function getMsgCount(){
        if(IS_AJAX){
            $params['rows'] = PHP_INT_MAX;
            $res = \AppTools::webService('\Model\Company\CompanyMsg', 'getMsg', array('params'=>$params));
            $count = 0;
            if(isset($res['data']['count'])){
                $list = $res['data']['count'];
                $count = intval($list['share']['nodeal'])+intval($list['cooperation']['nodeal'])+intval($list['audit']['nodeal']);
            }
            return $count;
        }
    }

    //消息详情
    public function msgInfo(){
        $id = I('get.id','');
        if($id){
            $params['id'] = $id;
            $res = \AppTools::webService('\Model\Company\CompanyMsg', 'getMsg', array('params'=>$params));
            p($res);
        }
    }

    //将消息置为已读
    private function setMsgDeal($id){
        $params['id'] = $id;
        $res = \AppTools::webService('\Model\Company\CompanyMsg', 'setMsg', array('params'=>$params));
    }

    public function delMsg(){
        $id = I('post.id','');
        if($id){
            $params['id'] = $id;
            $res = \AppTools::webService('\Model\Company\CompanyMsg', 'delMsg', array('params'=>$params));
            
        }
    }
}
