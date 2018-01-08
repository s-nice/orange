<?php
/**
 * Created by PhpStorm.
 * User: qiuzhigang
 * Date: 2017-11-10
 * Time: 14:16
 */

namespace Appadmin\Controller;


use Model\Appadmin\Suite;
use Model\Appadmin\SuiteTerm;

class SuiteController extends AdminBaseController{
    private $model;
    public function _initialize()
    {
        parent::_initialize();

    }

    /***
     * 企业套餐列表
     */
    public function index(){
        $rows=$this->rows;
        $p=I('p',1);
        $start=($p-1)*$rows;
        $sort = I('get.sort', 'id', 'strval,trim');//排序字段
        $sortType = I('get.sortType', 'desc');//排序升降：asc，desc
        $keyword=urldecode(I('keyword',''));
        $startTime=I('startTime',null);
        $endTime=I('endTime',null);
        $status=I('status',null);
        $createtime='';
        if ($startTime!=null && $endTime!=null) {
            $createtime = strtotime($startTime . ' 00:00:00') . ',' . strtotime($endTime . ' 23:59:59');
        } else {
            //用户只输入了开始时间
            if ($startTime!=null) {
                $createtime = strtotime($startTime . ' 00:00:00');
            }
            //如果用户只输入了结束时间
            if ($endTime!=null) {
                $createtime = strtotime('1970-01-01 00:00:00') . ',' . strtotime($endTime . ' 23:59:59');
            }
        }
        $params=array(
            'p'=>$p,
            'rows'=>$rows,
            'start'=>$start,
            'sort'=>$sort.' '.$sortType,
            'createtime'=>$createtime,
            'status'=>$status,
            'kwds'=>$keyword,
            'type'=>1,

        );
        $this->model = new Suite();
        $result=$this->model->doRequest($params,'R');
        $numFound=$result['data']['numfound'];
        $totalpages = ceil($numFound / $rows);
        $page = getpage($numFound,$rows);//使用分页类
        $this->assign('pagedata', $page->show());//分配分页
        $this->assign('totalpage',$totalpages);//分配总页数
        $sortParams=array( //排序用url 传参
            'sortType'=> $sortType == 'asc' ? 'desc' : 'asc',
            'startTime'=>$startTime,
            'endTime'=>$endTime,
            'keyword'=>$keyword
        );
        $this->assign('list',$result['data']['list']);
        $this->assign('params',$params);
        $this->assign('sortParams',$sortParams);
        $this->assign('sort', $sort);//排序
        $this->assign('keyword', $keyword);//关键词
        $this->assign('sortType', $sortType);//asc or descc
        $this->assign('moreCSSs', array('js/jsExtend/datetimepicker/datetimepicker'));//加载css
        $this->assign('moreScripts', array('js/Appadmin/company','js/jsExtend/datetimepicker/datetimepicker'));
        $this->getCommonMenu('suiteInfoList');
        $this->display('index');
    }


    public function add(){
        if(IS_GET){
            $this->getCommonMenu('suiteInfoList');
            $this->display('add');
            exit;
        }
        if(IS_AJAX){
            $post = I('post.');
            $keyArr = ['name','suite_desc','level','price','num','sheet','buy_month','status'];
            $params = [];
            foreach($post as $k=>$v){
                if(in_array($k,$keyArr)){
                    $params[$k] = $v;
                }
            }
            if(empty($params['name'])||!isset($params['name'])||$params['num']<1&&$params['sheet']<1||$params['buy_month']<1){
                $this->ajaxReturn(['status'=>1,'msg'=>"请正确写入套餐信息"]);
                exit;
            }
            $params['type'] = 1;
            $this->model = new Suite();
            $result=$this->model->doRequest($params,'C');
            if($result['head']['status']==0){
                $this->ajaxReturn(['status'=>0,'msg'=>"新增套餐成功"]);
                exit;
            }
            $this->ajaxReturn(['status'=>1,'msg'=>"新增套餐失败"]);
            exit;
        }
    }

    public function edit(){
        $id=I('id',0);
        if($id<=0){
            $this->redirect('/Appadmin/Suite/index');
        }
        $params=['id'=>$id,];
        $this->model = new Suite();
        $result=$this->model->doRequest($params,'R');
        $params = $result['data']['list'][0];

        if(IS_GET){
            $result = $this->model->doRequest($params,'G');
            $isdefault= 0;
            if(0==$result['status']){
                $suite_id = $result['data']['suite_id'];
                if($id==$suite_id){
                    $isdefault = 1;
                }
            }
            $params['isdefault'] = $isdefault;
            $this->assign('info',$params);
            $this->getCommonMenu('suiteInfoList');
            $this->display('edit');
            exit;
        }
        if(IS_AJAX){
            $status=I('status',null);
            if(!isset($status)){
                $this->ajaxReturn(['status'=>1,'msg'=>"请正确写入套餐信息"]);
                exit;
            }
            $params['status'] = $status;
            $result = $this->model->doRequest($params,"U");
            if($result['head']['status']==0){
                $isdefault = intval(I('isdefault'));
                if($isdefault==1){
                    $this->model->doRequest(['suite_id'=>$id],'F');
                }
                $this->ajaxReturn(['status'=>0,'msg'=>"编辑套餐成功"]);
                exit;
            }
            $this->ajaxReturn(['status'=>1,'msg'=>"编辑套餐失败"]);
            exit;
        }
    }

    public function detail(){
        $id=I('id',0);
        if($id<=0){
            $this->redirect('/Appadmin/Suite/index');
        }
        $params=['id'=>$id,];
        $this->model = new Suite();
        $result=$this->model->doRequest($params,'R');
        $this->assign('info',$result['data']['list'][0]);
        $this->getCommonMenu('suiteInfoList');
        $this->display('detail');
    }

    public function changeStatus(){

    }

    public function term(){
        $rows=$this->rows;
        $p=I('p',1);
        $start=($p-1)*$rows;
        $sort = I('get.sort', 'id', 'strval,trim');//排序字段
        $sortType = I('get.sortType', 'desc');//排序升降：asc，desc
        $keyword=urldecode(I('keyword',''));
        $startTime=I('startTime',null);
        $endTime=I('endTime',null);
        $status=I('status',null);
        $createtime='';
        if ($startTime!=null && $endTime!=null) {
            $createtime = strtotime($startTime . ' 00:00:00') . ',' . strtotime($endTime . ' 23:59:59');
        } else {
            //用户只输入了开始时间
            if ($startTime!=null) {
                $createtime = strtotime($startTime . ' 00:00:00');
            }
            //如果用户只输入了结束时间
            if ($endTime!=null) {
                $createtime = strtotime('1970-01-01 00:00:00') . ',' . strtotime($endTime . ' 23:59:59');
            }
        }
        $params=array(
            'p'=>$p,
            'rows'=>$rows,
            'start'=>$start,
            'sort'=>$sort.' '.$sortType,
            'createtime'=>$createtime,
            'status'=>$status,
            'kwds'=>$keyword

        );
        $this->model = new SuiteTerm();
        $result=$this->model->doRequest($params,'R');
        $numFound=$result['data']['numfound'];
        $totalpages = ceil($numFound / $rows);
        $page = getpage($numFound,$rows);//使用分页类
        $this->assign('pagedata', $page->show());//分配分页
        $this->assign('totalpage',$totalpages);//分配总页数
        $sortParams=array( //排序用url 传参
            'sortType'=> $sortType == 'asc' ? 'desc' : 'asc',
            'startTime'=>$startTime,
            'endTime'=>$endTime,
            'keyword'=>$keyword
        );
        $this->assign('list',$result['data']['list']);
        $this->assign('params',$params);
        $this->assign('sortParams',$sortParams);
        $this->assign('sort', $sort);//排序
        $this->assign('keyword', $keyword);//关键词
        $this->assign('sortType', $sortType);//asc or descc
        $this->assign('moreCSSs', array('js/jsExtend/datetimepicker/datetimepicker'));//加载css
        $this->assign('moreScripts', array('js/Appadmin/company','js/jsExtend/datetimepicker/datetimepicker'));
        $this->getCommonMenu('termInfoList');
        $this->display('term');
    }

    public function termdetail(){
        $id=I('id',0);
        $bizid = I('bizid');
        if($id<=0&&empty($bizid)){
            $this->redirect('/Appadmin/Suite/term');
        }
        if(!empty($bizid)){
            $params['bizid']=$bizid;
        }
        if(is_numeric($id)&&$id>0){
            $params['id']=$id;
        }

        $this->model = new SuiteTerm();
        $result=$this->model->doRequest($params,'R');
        $this->assign('info',$result['data']['list'][0]);
//        $this->getCommonMenu('termInfoDetail');
        $this->getCommonMenu('termInfoList');
        $this->display('termdetail');
    }

    /***
     * 续期
     */
    public function renewal(){
        $bizid = trim(I('bizid'));
        if(!isset($bizid)){
            $this->ajaxReturn(['status'=>1,'msg'=>"请正确写入套餐信息"]);
            exit;
        }
        $params['bizid']=$bizid;
        $this->model = new SuiteTerm();
        $result=$this->model->doRequest($params,'R');
        if(0!=$result['head']['status']){
            $this->ajaxReturn(['status'=>1,'msg'=>"该企业不支持续期"]);
            exit;
        }
        $termInfo = $result['data']['list'][0];
        $metainfo = json_decode($termInfo['suitejson'],true);
        $params['metaid'] = $metainfo['id'];
        $params['orderType'] = 3;
        $params['bizid']=$bizid;
        $this->model = new Suite();
        $result=$this->model->doRequest($params,'B');
        if($result['head']['status']==0){
            $this->ajaxReturn(['status'=>0,'msg'=>"套餐续期成功"]);
            exit;
        }
        $this->ajaxReturn(['status'=>1,'msg'=>"套餐续期失败"]);
        exit;
    }

    /***
     * 套餐升级
     */
    public function upgrade(){
        $bizid = I('bizid');
        $params['bizid']=$bizid;
        $this->model = new SuiteTerm();
        //查询信息
        $result=$this->model->doRequest($params,'R');
        if(0!=$result['status']){
            $this->ajaxReturn(['status'=>1,'msg'=>"该企业不支持套餐升级"]);
            exit;
        }
        $detail = $result['data']['list'][0];
        if(IS_GET){
            $this->assign('info',$detail);
            $param['level'] = $detail['level'];
            $param['status'] = 100;
            $param['type'] = 1;
            $this->model = new Suite();
            $result=$this->model->doRequest($param,'R');
            $this->assign("list",$result['data']['list']);
            $this->getCommonMenu('termInfoList');
            $this->display();
            exit;
        }
        if(IS_AJAX){
            $metaid = I('metaid');
            if(!isset($bizid) || !isset($metaid) || $metaid < 0){
                $this->ajaxReturn(['status' => 1, 'msg' => "请正确写入套餐信息"]);
                exit;
            }
            $params['orderType'] = 4;
            $params['metaid']    = $metaid;
            $this->model         = new Suite();
            $result              = $this->model->doRequest($params, 'B');
            if($result['head']['status'] == 0){
                $this->ajaxReturn(['status' => 0, 'msg' => "套餐升级成功"]);
                exit;
            }
            $this->ajaxReturn(['status' => 1, 'msg' => "套餐升级失败"]);
            exit;
        }
    }
}