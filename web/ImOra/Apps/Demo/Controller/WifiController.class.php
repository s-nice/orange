<?php
namespace Demo\Controller;

use Think\Log;
use Classes\GFunc;
use Demo\Controller\Base\WxBaseController;

import('ConvertFormat', LIB_ROOT_PATH . 'Classes/Wechat/');
import('Request', LIB_ROOT_PATH . 'Classes/Wechat/');
import('WechatListener', LIB_ROOT_PATH . 'Classes/Wechat/');
import('MyWechatHandler', LIB_ROOT_PATH . 'Classes/Wechat/');
class WifiController extends WxBaseController
{
    protected $webSerivce = null;
    private $pageSize = 10;

    public function __construct()
    {
        parent::__construct();
    }

    protected function _initialize()
    {

    }

    public function shopList(){
        $p = I('get.p',1);
        $access_token = $this->getAcessToken();
        $array = array('pageindex'=>$p,'pagesize'=>$this->pageSize);
        $url = 'https://api.weixin.qq.com/bizwifi/shop/list?access_token='.$access_token;
        $destination = C('LOG_PATH').date('y_m_d').'wz'.'.log';      
        $list = array();
        $res = $this->exec($url,json_encode($array),'post');
        $res = json_decode($res,true);
        //Log::write(json_encode($res),'ERR','',$destination);
        if(isset($res['data']['records'])){
            $list = $res['data']['records'];
        }

        //过滤后只剩下密码型设备门店
        $list = $this->filterShopList($list);
        $list = $this->addShopInfo($list,$access_token);
        //p($list);die;
        $this->assign('list',$list);
        $this->display('shopList');
    }

    //将非密码型设备的门店过滤
    private function filterShopList($list){
        $arr = array();
        foreach ($list as  $value) {
            if($value['protocol_type']==4){
                $arr[] = $value;
            }
        }
        return $arr;
    }

    //将门店的详细信息加入
    private function addShopInfo($list,$access_token){
        $url = 'https://api.weixin.qq.com/cgi-bin/poi/getpoi?access_token='.$access_token;
        foreach ($list as $key=>$value) {
            $poi_id = $value['poi_id'];
            $data = $this->getShopInfo($poi_id);
            $value['baseinfo'] = $data;
            $list[$key] = $value;
        }
        return $list;
    }

    private function getShopInfo($poi_id){
        $access_token = $this->getAcessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/poi/getpoi?access_token='.$access_token;
        $array = array('poi_id'=>$poi_id);
        $info = array();
        $res = $this->exec($url,json_encode($array),'post');
        $res = json_decode($res,true);
        if(isset($res['business']['base_info'])){
            $info = $res['business']['base_info'];
        }
        return $info;
    }

    public function shop(){
        $shopId = I('get.shopid','');
        if($shopId){
            $access_token = $this->getAcessToken();
            $array = array('shop_id'=>$shopId);
            $url = 'https://api.weixin.qq.com/bizwifi/shop/get?access_token='.$access_token;   
            $data = array();
            $poi_id = '';
            $res = $this->exec($url,json_encode($array),'post');
            $res = json_decode($res,true);
            if(isset($res['data'])){
                $data = $res['data'];
                $poi_id = $data['poi_id'];
            }
            /*$url = 'https://api.weixin.qq.com/bizwifi/device/list?access_token='.$access_token;   
            $list = array();
            $res = $this->exec($url,json_encode($array),'post');
            $res = json_decode($res,true);*/

            $shopinfo = $this->getShopInfo($poi_id);
            
            $this->assign('shopid',$shopId);
            $this->assign('data',$data);
            $this->assign('shopinfo',$shopinfo);
            $this->display('shop');
        }
    }

    public function map(){
        include_once 'Base/jssdk.php';
        $jssdk = new \JSSDK(C('Wechat')['AppID'], C('Wechat')['AppSecret']);
        $signPackage = $jssdk->GetSignPackage();
        $latitude = I('get.latitude','');
        $longitude = I('get.longitude','');
        $this->assign('signPackage', $signPackage);
        $this->display('map');
    }

    public function getShopIndex(){
        /*$shopid = I('shopid');
        $access_token = $this->getAcessToken();
        $uArr = array('url'=>'http://www.baidu.com');
        $array = array('shop_id'=>$shopid,'template_id'=>1,'struct'=>$uArr);
        $url = 'https://api.weixin.qq.com/bizwifi/homepage/set?access_token='.$access_token;  
        $res = $this->exec($url,json_encode($array),'post');
        $res = json_decode($res,true);
        p($res);die;
        $data = array();*/
    }

    public function wifiQrcod(){
        $shopId = I('get.shopid','');
        $ssid = I('get.ssid','');
        if($shopId&&$ssid){
            $src = U(MODULE_NAME.'/Wifi/curlWxImg',array('shopid'=>$shopId,'ssid'=>$ssid));
            $this->assign('src',$src);
            $this->display('wifiQrcod');
        }
    }

    public function curlWxImg(){
        $shopId = I('get.shopid','');
        $ssid = I('get.ssid','');
        if($shopId&&$ssid){
            $access_token = $this->getAcessToken();
            //echo $access_token;die;
            $array = array('shop_id'=>$shopId,'ssid'=>$ssid,'img_id'=>1);
            $url = 'https://api.weixin.qq.com/bizwifi/qrcode/get?access_token='.$access_token;   
            $src = '';
            $res = $this->exec($url,json_encode($array),'post');
            $res = json_decode($res,true);
            //p($res);die;
            if(isset($res['data']['qrcode_url'])){
                $src = $res['data']['qrcode_url'];
                $data = file_get_contents($src);
                header("Content-Type: image/jpeg;text/html; charset=utf-8");
                echo $data;
            }
        }
    }
    //添加WIFI设备
    public function addWifi(){
        $shopid = I('shopid','');
        if(IS_AJAX){
            $access_token = $this->getAcessToken();
            $array = array('shop_id'=>$shopid);
            $ssid = I('post.ssid','');
            $password = I('post.password','');
            $array['ssid'] = $ssid;
            $array['password'] = $password;
            //print_r($array);die;
            $url = 'https://api.weixin.qq.com/bizwifi/device/add?access_token='.$access_token;   
            $list = array();
            $res = $this->exec($url,json_encode($array),'post');
            $res = json_decode($res,true);
            if($res['errcode']==0){
                $this->ajaxReturn(array('status'=>0));
            }elseif($res['errcode']=='9002016'){
                $this->ajaxReturn(array('status'=>1,'msg'=>'WIFI设备名称重复'));
            }
            $this->ajaxReturn(array('status'=>1));
        }else{
            $this->assign('shopid',$shopid);
            $this->display('addWifi');
        }
    }

    //修改WIFI信息
    public function editWifi(){
        $access_token = $this->getAcessToken();
            $array = array('shop_id'=>$shopId);
            $url = 'https://api.weixin.qq.com/bizwifi/shop/get?access_token='.$access_token;   
            $list = array();
            $res = $this->exec($url,json_encode($array),'post');
            $res = json_decode($res,true);
            p($res);die;
            if(isset($res['data']['record'])){
                $list = $res['data']['record'];
            }
            $this->display('shopList');
    }

    //引导页面
    public function guide(){
        $shopId = I('get.shopid','');
        $ssid = I('get.ssid','');
        if($shopId&&$ssid){
            $access_token = $this->getAcessToken();
            $array = array('shop_id'=>$shopId,'ssid'=>$ssid,'img_id'=>1);
            $url = 'https://api.weixin.qq.com/bizwifi/qrcode/get?access_token='.$access_token;   
            $src = '';
            $res = $this->exec($url,json_encode($array),'post');
            $res = json_decode($res,true);
            if(isset($res['data']['qrcode_url'])){
                $src = $res['data']['qrcode_url'];
            }
            $this->assign('src',$src);
            $this->display('guide');
        }
    }

    //将引导页面生成二维码
    public function guideQrcode(){
        $shopId = I('get.shopid','');
        $ssid = I('get.ssid','');
        if($shopId&&$ssid){
            require_once LIB_ROOT_PATH . '3rdParty/phpqrcode/phpqrcode.php';
            $url = U(MODULE_NAME.'/Wifi/guide',array('shopid'=>$shopId,'ssid'=>$ssid),true,true,true);
            \QRcode::png($url);
        }
    }
}
/* EOF */
