<?php

namespace Company\Controller;


class PaymentController extends BaseController
{
    public function _initialize(){
        parent::_initialize();
        // 增加翻译文件
        $this->translator->mergeTranslation(APP_PATH . 'Lang/company-'. $this->uiLang . '.xml', 'xml');
        $this->assign('T',$this->translator);
        //部门样式
        $this->assign('moreCSSs',array('css/Company/division'));
        //$_SESSION['Company']['accesstoken'] = '0A6ZyO1x64z3SRq7CfBBQNNYETcVAarWHRL8D3PV';

    }
    public function index()
    {
        $res = \AppTools::webService('\Model\Company\CompanyPayment', 'suitemeta',array('params'=>array()));
        if($res['status']===0&&$res['data']['ishave']===true){//已经购买过套餐
            $session = session(MODULE_NAME);
            if(!isset($session['payment'])){
                $session['payment'] = $res['data']['suite'];
                session(MODULE_NAME,$session);
            }
//            dump($res);die;
            $this->assign('ishave',1);
        }elseif($res['status']===0&&$res['data']['ishave']===false){//第一次购买
            $this->assign('ishave',0);
        }else{
            $this->assign('ishave',-1);
        }
        $this->display('index');
    }

    //企业初次购买套餐服务
    public function buySuite()
    {
        if(IS_GET){
            $res = \AppTools::webService('\Model\Company\CompanyPayment', 'suitemeta',array('params'=>array()));
            $price = $res['data']['suite']['price'];
//            $session = session(MODULE_NAME);
//            $price = $session['payment']['price'];
//            dump($session);die;
            $this->assign('price',$price);
            $this->assign('buyType',1);
            $this->assign('payTitle','购买套餐');
            $this->display('payment');
        }elseif(IS_AJAX){
            $params = array(
                'num' => (int)I('num'),
                'month' => (int)I('month'),
                'platform' => (int)I('platform'),
                'metaid' => session(MODULE_NAME)['payment']['metaid'],
            );
            $res = \AppTools::webService('\Model\Company\CompanyPayment', 'purchasesuite',array('params'=>$params));
//        dump($params);
            $this->ajaxReturn($res);
        }

    }

    //新增员工接口
    public function addStaff()
    {
        if(IS_GET){
            $session = session(MODULE_NAME);
            $price = $session['payment']['price'];
            $this->assign('payTitle','添加成员');
            $this->assign('price',$price);
            $this->assign('buyType',3);
            $this->display('payment');
        }elseif(IS_AJAX){
            $params = array(
                'num' => (int)I('num'),
                'platform' => (int)I('platform'),
                'metaid' => session(MODULE_NAME)['payment']['metaid'],
            );
            $res = \AppTools::webService('\Model\Company\CompanyPayment', 'addemployeesuite',array('params'=>$params));
            $this->ajaxReturn($res);
        }

    }

    //企业套餐续期接口
    public function renewSuite()
    {
        if(IS_GET){
            $price = session(MODULE_NAME)['price'];
            $this->assign('price',$price);
            $this->assign('payTitle','套餐续费');
            $this->assign('buyType',2);
            $this->display('payment');
        }elseif(IS_AJAX){
            $params = array(
                'month' => I('month'),
                'platform' => (int)I('platform'),
                'metaid' => session(MODULE_NAME)['payment']['metaid'],
            );
            $res = \AppTools::webService('\Model\Company\CompanyPayment', 'renewsuite',array('params'=>$params));
    //        dump($params);
            $this->ajaxReturn($res);
        }
    }

    //获得订单列表
    public function getOrderList()
    {
        $params = array();
        $res = \AppTools::webService('\Model\Company\CompanyPayment', 'getorderlist',array('params'=>$params));
//        dump($params);
        dump($res);
    }

    //订单再次支付
    public function payAgain()
    {
        $params = array(
            'orderid' => I('orderid'),
            'platform' => I('platform'),
        );
        $res = \AppTools::webService('\Model\Company\CompanyPayment', 'getsuiteorder',array('params'=>$params));
//        dump($params);
        $this->ajaxReturn($res);
    }

    //获取套餐信息
    public function getSuiteInfo()
    {
        $params = array();
        $res = \AppTools::webService('\Model\Company\CompanyPayment', 'suitemeta',array('params'=>$params));
        if($res['status']===0){
            return $res['data'];
        }else{
            return null;
        }
    }

    public function test()
    {
    }

}