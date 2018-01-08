<?php
/**
 * Created by PhpStorm.
 * User: qiuzhigang
 * Date: 2017-11-10
 * Time: 14:14
 */

namespace Appadmin\Controller;


use Model\Appadmin\Orderbiz;

class OrderbizController extends AdminBaseController{

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new Orderbiz();
    }

    public function index(){
        $rows=$this->rows;
        $p=I('p',1);
        $start=($p-1)*$rows;
        $sort = I('get.sort', 'id', 'strval,trim');//排序字段
        $sortType = I('get.sortType', 'desc');//排序升降：asc，desc
        $keyword=urldecode(I('keyword',''));
        $startTime=I('startTime',null);
        $endTime=I('endTime',null);
        $status=I('paystatus',null);
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
            'paystatus'=>$status,
            'kwds'=>$keyword

        );
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
        $this->assign('list',$result['data']['data']);
        $this->assign('params',$params);
        $this->assign('sortParams',$sortParams);
        $this->assign('sort', $sort);//排序
        $this->assign('keyword', $keyword);//关键词
        $this->assign('sortType', $sortType);//asc or descc
        $this->assign('moreCSSs', array('js/jsExtend/datetimepicker/datetimepicker'));//加载css
        $this->assign('moreScripts', array('js/Appadmin/company','js/jsExtend/datetimepicker/datetimepicker'));
        $this->getCommonMenu('orderInfoList');
        $this->display('index');
    }

    /***
     * 订单详情
     */
    public function detail(){
        $id=I('id',0);
        if($id<=0){
            $this->redirect('/Appadmin/Orderbiz/index/');
        }
        $params=['id'=>$id,];
        $result=$this->model->doRequest($params,'R');
        $detail = $result['data']['data'][0];
        $info = json_decode($detail['metadata'],true);
        $this->assign("detail",$detail);
        $this->assign('info',$info);
//        $this->getCommonMenu('orderInfoDetail');
        $this->getCommonMenu('orderInfoList');
        $this->display('detail');
    }
}