<?php
namespace Company\Controller;

use Think\Controller;
use Classes\Factory;
use Classes\GFunc;
import('Factory', LIB_ROOT_PATH . 'Classes/');

class LabelController extends BaseController
{
    private $rows = 10;
    private $maxNum = 30;
    public function _initialize()
    {
        parent::_initialize();
        $this->assign('title','标签管理-橙鑫科技企业平台');
        $this->assign('moreCSSs',array('css/Company/division'));
    }


    public function index(){
        $p = intval(I('get.p',1));
        $p = max($p,1);
        $session = session(MODULE_NAME);
        $params['bizid'] = $session['bizid'];
        $params['rows'] = $this->rows;
        $params['start'] = ($p-1)*$this->rows;
        $res = \AppTools::webService('\Model\Company\CompanyLabel', 'getLabels', array('params'=>$params));
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
        $this->display('index');
    }

    //修改标签提交
    public function editLabel(){
        if(IS_AJAX){
            $id = I('post.id','');
            $tag = I('post.tag','');
            if($tag){
                $params['tag'] = $tag;
                if($id){
                    $params['id'] = $id;
                    $res = \AppTools::webService('\Model\Company\CompanyLabel', 'editLabel', array('params'=>$params));
                }else{
                    $session = session(MODULE_NAME);
                    $re = \AppTools::webService('\Model\Company\CompanyLabel', 'getLabels', array('params'=>array('rows1'=>1,'bizid'=>$session['bizid'])));
                    $numfound = $re['data']['numfound'];
                    if($numfound>=$this->maxNum){
                        $this->ajaxReturn(array('status'=>1,'msg'=>'标签上限为'.$this->maxNum.'个'));
                    } 
                    $res = \AppTools::webService('\Model\Company\CompanyLabel', 'addLabel', array('params'=>$params));
                }
                if($res['status']==0){
                    $return = array('status'=>0);
                    if(isset($res['data']['id'])){
                        $return['id'] = $res['data']['id'];
                    }
                    $this->ajaxReturn($return);
                }elseif($res['status']=='999005'){
                    $this->ajaxReturn(array('status'=>1,'msg'=>'标签名重复'));
                }
            }
        }
        $this->ajaxReturn(array('status'=>1,'msg'=>'保存失败'));
    }

    //删除标签
    public function delLabel(){
        if(IS_AJAX){
            $id = I('post.id','');
            if($id){
                $params['id'] = $id;
                $res = \AppTools::webService('\Model\Company\CompanyLabel', 'delLabel', array('params'=>$params));
                if($res['status']==0){
                    $this->ajaxReturn(array('status'=>0,'msg'=>'删除成功'));
                }
            }
        }
        $this->ajaxReturn(array('status'=>1,'msg'=>'删除失败'));
    }

}
