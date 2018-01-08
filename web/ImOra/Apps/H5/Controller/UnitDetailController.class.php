<?php
namespace  H5\Controller;

use BaseController\BaseController;
use Model\Orange\OraUnitDetail;
use Classes\GFunc;
/**
 * 商户详情H5页面
 *
 *
 */
class UnitDetailController extends BaseController
{
    private $model;
    protected $toCheckLogin = FALSE;
    public function __construct()
    {
        parent::__construct();

    }

    public function index(){
        $id=I('id',null);//商户ID
        $this->model=new \Model\Orange\OraUnitDetail();
        $res=$this->model->manageUnitDetail(array('id'=>$id),'R');
        $info=$res['data']['list'][0];
        //$info['servicegallery'] = GFunc::replaceAudioToImg( $info['servicegallery'],1);//将展示内容中的音频uuid替换成图片
        $info['servicegallery'] = GFunc::replaceToImg( $info['servicegallery'],1);   //将展示内容中的图片uuid替换成图片地址
        //$info['imorarights'] = GFunc::replaceAudioToImg( $info['imorarights'],1);//将展示内容中的音频uuid替换成图片
        $info['imorarights'] = GFunc::replaceToImg( $info['imorarights'],1);   //将展示内容中的图片uuid替换成图片地址
      //  var_dump($info['servicegallery']);
        $this->assign('info',$info);
        $this->display();

    }


}