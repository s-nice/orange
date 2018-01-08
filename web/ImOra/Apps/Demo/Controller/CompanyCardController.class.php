<?php


namespace Demo\Controller;

use Think\Log;
use Classes\GFunc;
use Demo\Controller\Base\WxBaseController;

import('ConvertFormat', LIB_ROOT_PATH . 'Classes/Wechat/');
import('Request', LIB_ROOT_PATH . 'Classes/Wechat/');
import('WechatListener', LIB_ROOT_PATH . 'Classes/Wechat/');
import('MyWechatHandler', LIB_ROOT_PATH . 'Classes/Wechat/');
class CompanyCardController extends WxBaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function bizCardList(){
        $type = I('type','');
        $typekwds = I('typekwds','','');
        $kwd = I('keyword','');
        $section = I('section','');
        $kwd = urldecode($kwd);
        $this->_authBase('bizCardList', 'CompanyCard',array('type'=>$type,'typekwds'=>$typekwds,'kwd'=>$kwd,'section'=>$section)); //微信基本授权操作
        if(IS_GET){
            $openid = $this->session['openid'];
            $params = array('wechatid'=>$openid);
            $res = \AppTools::webService('\Model\WeChat\WeChat', 'getBizCardCount', array('params'=>$params));
            $params['section'] = $section;
            $params['vcardtxt'] = $kwd?:'';
            $result = \AppTools::webService('\Model\WeChat\WeChat', 'getBizCardList', array('params'=>$params));
//            dump($result);die;
            //网页调用照片
            if ($this->userAgent == 'weixin'){
                $jssdk = new \JSSDK(C('Wechat')['AppID'], C('Wechat')['AppSecret']);
                $signPackage = $jssdk->GetSignPackage();
                $this->assign('signPackage', $signPackage);
            }
            if($result['status']===0){
                $list = $result['data']['list'];
                if($res['status']===0){
                    $this->assign('selfcount',$res['data']['selfcount']);
                    $this->assign('bindcount',$res['data']['bindcount']);
                }
                $rows = 10;
                $isMy = 0;
                if($section==1){
                    $totalPage = ceil($res['data']['selfcount']/$rows);
                    $cardCount = $res['data']['selfcount'];
                    $isMy = 1;
                }elseif($section==2){
                    $totalPage = ceil($res['data']['bindcount']/$rows);
                    $cardCount = $res['data']['bindcount'];
                }else{
                    $totalPage = ceil(($res['data']['selfcount']+$res['data']['bindcount'])/$rows);
                    $cardCount = $res['data']['selfcount']+$res['data']['bindcount'];
                }
                $this->assign('cardCount',$cardCount);
                $this->assign('totalPage', $totalPage); //总记录数
                $this->assign('currPage',1); //当前页码数
                $this->assign('rows', 10);
                $this->assign('sysType', $this->getAppName());
                $this->assign('list',$list);
                $this->assign('listType',1);
                $this->assign('keyword', $kwd);
                $this->assign('openid', $openid);
                $this->assign('section', $section);
                $this->assign('type', $type);
                $this->assign('typekwds',$typekwds);
                $this->assign('isMy',$isMy);
//                dump($list);die;
                $this->display('bizCardList');
            }else{
                $this->assign('info','您未绑定企业或没有通过企业认证');
                $this->display('errPage');
            }
        }
    }

    public function ajaxGetCards()
    {
        if(IS_AJAX){
            $currentPage = I('currentPage',1);
            $start = ($currentPage-1)*10;
            $keyword = I('keyword','');
            $params = array();
            $openid = $this->session['openid'];
            $params['start'] = $start;
            $params['wechatid'] = $openid;
            if(!empty($keyword)){
                $params['vcardtxt'] = $keyword;
            }
            if(I('section')==1){
                $params['section'] = 1;
            }elseif(I('section')==2){
                $params['section'] = 2;
            }
            if($currentPage>1){
                $result = \AppTools::webService('\Model\WeChat\WeChat', 'getBizCardList', array('params'=>$params));
                $list = $result['data']['list'];
                $this->assign('list',$list);
                $this->assign('openid',$openid);
                $this->assign('currPage',$currentPage);
                $res = $this->fetch('listitem');
                if(!empty($list)&&$result['status']===0){
                    $this->ajaxReturn(array('status'=>0,'msg'=>'','data'=>array('list'=>$res,'currentPage'=>$currentPage)));
                }
            }

        }
    }


    /**
     * 名片详细页面->名片正面
     */
    public function wDetailZp(){
        $this->_authBase('wDetailZp', 'CompanyCard'); //微信基本授权操作
        $mess = $this->_detailData(true,'wDetailZp');
//        dump($mess);die;
        /*$fp = fopen(WEB_ROOT_DIR.'../Shell/vcardLog.txt', 'a+b');
        fwrite($fp, var_export($mess,ture));
        fclose($fp);*/
        if(!file_exists(WEB_ROOT_DIR.'../Public/temp/Cards/'.$mess['info']['uuid'].'.vcf')){
            $this->bulidVcf($mess['info']['vcard'], $mess['info']['uuid'], $mess['info']['wechatid']);
        }
        if ($mess['isMenu'] == '1') {
            //$this->display('wDetailZp');
            if(empty($mess['info'])){
                //网页调用照片
                $jssdk = new \JSSDK(C('Wechat')['AppID'], C('Wechat')['AppSecret']);
                $signPackage = $jssdk->GetSignPackage();
                $this->assign('signPackage', $signPackage);
                $this->assign('openid',$this->session['openid']);
                $this->assign('type',$this->getAppName());

                $this->display('CompanyCard/detail_nodata');
            }else{
                $this->display('CompanyCard/detail_self');
            }

        }else{
            $this->display('CompanyCard/detail_other');
        }
    }

    /**
     * 名片详情页面->名片反面
     */
    public function detailBack()
    {
        $mess = $this->_detailData(true,'detailBack');

        if(!file_exists(WEB_ROOT_DIR.'../Public/temp/Cards/'.$mess['info']['uuid'].'_.vcf')){
            $this->bulidVcf($mess['info']['vcard'], $mess['info']['uuid'], $mess['info']['wechatid'],true);
        }

        if ($mess['isMenu'] == '1') {
            $this->display('CompanyCard/detail_self_back');
        }else{
            $this->display('CompanyCard/detail_other_back');
        }
    }



    /**
     * 名片详情页面公共数据
     * param boolean $showBack
     */
    private function _detailData($showBack=true,$wxCallbackPage)
    {
        $isMy = I('isMy',0);
        $isSourceAndroid = I('android',''); //是否来源于android  1:是，0：不是
        $isMenu = I('isMenu',0); //是否来源于自定义菜单，1：是，0：不是
        $cardid = I('cardid'); //名片id
//     	if(!$isSourceAndroid){
//     		$this->_weixinAuthBase($wxCallbackPage, 'Wechat',array('isMenu'=>$isMenu,'cardid'=>$cardid)); //微信基本授权操作
//     	}
        $params = array();
        $params['vcardid'] = $cardid;
        $params['wechatid'] = $this->session['openid'];

        $res = \AppTools::webService('\Model\WeChat\WeChat', 'getBizCardList', array('params'=>$params));
        $wechatsList = $this->analyShowVcard($res['data']['list'],$showBack);
        $info = $res['data']['numfound']==0?array():$wechatsList[0];
        //echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',print_r($info,1);exit;
        $this->assign('info', $info);
        if(!$isSourceAndroid){
            //网页调用照片
            include_once 'Base/jssdk.php';
            $jssdk = new \JSSDK(C('Wechat')['AppID'], C('Wechat')['AppSecret']);
            $signPackage = $jssdk->GetSignPackage();
            $this->assign('signPackage', $signPackage);
        }
        $this->assign('isAndroid', $isSourceAndroid);
        $this->assign('openid', $this->session['openid']);
        $this->assign('cardid', $cardid?$cardid:$info['vcardid']);
        $this->assign('vcardid', $info['uuid']);
        $this->assign('sysType', $this->getAppName());
        $this->assign('isMy', $isMy);
        $this->assign('ismycreate', $info['section']);
        $urlSource = '';
        if(strpos($_SERVER['HTTP_REFERER'], 'wListZp')===false){
            $urlSource = strpos($_SERVER['HTTP_REFERER'], 'showScanningVcard')===false?'':$_SERVER['HTTP_REFERER'];
        }else{
            $urlSource = $_SERVER['HTTP_REFERER'];
        }
        if($info[''])
        $this->assign('urlSource', $urlSource);
        $this->assign('kwd',urldecode(I('kwd')));
        $this->assign('isMenu', $isMenu);
        return array('info'=>$info, 'isMenu'=>$isMenu);
    }


    //删除名片
    public function bizCardDel(){
        $vcardid = (int)I('vcardid');
        $wechatid = $this->session['openid'];
        $params = array(
            'vcardid'=>$vcardid,
            'wechatid'=>$wechatid
        );
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'bizCardDelete', array('params'=>$params));
        $this->ajaxReturn($res);
    }
    //企业名片编辑
    public function bizCardEdit(){
        $isSourceAndroid = I('android',''); //是否来源于android  1:是，0：不是
        $this->assign('android',$isSourceAndroid); //系统类型,android or ios
        if(IS_POST){//保存编辑信息
            $result = $this->editCardDetail();
            $this->assign('result',$result);
        }
        $side = I('side','front'); //正面或反面
        $vcardid = (int)I('cardid');
        $openid = $this->session['openid'];
        $params = array(
            'vcardid' => $vcardid,
            'wechatid' => $openid
        );
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'getBizCardList', array('params'=>$params));
//        dump($res);die;
        $vcardDetail = $this->analyShowVcard($res['data']['list'],true);
        $info = $vcardDetail[0];
        if(!empty($info[$side]['FN']) && $info[$side]['FN']){
            $info[$side]['FN'] = $info[$side]['FN'][0];
        }else{
            $info[$side]['FN'] = '';
        }
        if(!empty($info[$side]['ORG']) && $info[$side]['ORG']){
            $info[$side]['ORG'] = $info[$side]['ORG'][0];
        }else{
            $info[$side]['ORG'] = '';
        }
        if(!empty($info[$side]['ADR']) && $info[$side]['ADR']){
            $info[$side]['ADR'] = $info[$side]['ADR'][0];
        }else{
            $info[$side]['ADR'] = '';
        }
        if(!empty($info[$side]['JOB']) && $info[$side]['JOB']){ //职位
            $info[$side]['JOB'] = $info[$side]['JOB'][0];
        }else{
            $info[$side]['JOB'] = '';
        }
        $this->assign('info',$info);
        $this->assign('side',$side); //正面或反面变量

        //网页调用照片
        include_once 'Base/jssdk.php';
        $jssdk = new \JSSDK(C('Wechat')['AppID'], C('Wechat')['AppSecret']);
        $signPackage = $jssdk->GetSignPackage();
        $this->assign('signPackage', $signPackage);
        $this->assign('openid', $this->session['openid']);
        $this->assign('cardid', $vcardid);
        $this->assign('sysType', $this->getAppName());
        $this->display('detail_edit');
        if(IS_POST){
            $result = $this->editCardDetail();
            $this->assign('result',$result);
        }
    }


    public function editCardDetail(){
        $name = I('post.name','',''); //个人名称，单条信息
        $company = I('post.company','',''); //公司名称 单条信息
        $address = I('post.address','','');
        $mobile = I('post.mobile');
        $telphone = I('post.telphone');
        $url = I('post.url');
        $cardid = I('cardid');
        $side = I('post.side'); //名片正面或反面，front:正面,back:反面
        $job =I('post.job','','');//职位
        $email =I('post.email','');//职位
        $isself = I('post.isself',0); //是否为自己名片（默认0不是 1是）
        $newInfo = array();
        //获取修改之前的名片信息
        $params['vcardid'] = $cardid;
        $params['wechatid'] = $this->session['openid'];
        $res = \AppTools::webService('\Model\WeChat\Wechat', 'getBizCardList', array('params'=>$params));
//        dump($res);die;
        $paramUpdate = array(
            'name' => array($name),
            'company_name' => array($company),
            'address' => array($address),
            'mobile' => $mobile,
            'telephone' => $telphone,
            'web' => $url,
            'job' => $job,//职位
            'email'=>$email,
        );
        $vcardJson = $this->analyUpdateVcard($res['data']['list'][0]['vcard'],$paramUpdate,$side);
        $newInfo['vcardid'] = $cardid;
        $newInfo['vcard'] = $vcardJson;
        $newInfo['wechatid'] = $this->session['openid'];
        $result = \AppTools::webService('\Model\WeChat\WeChat','bizCardEdit',array('params'=>$newInfo));
        if($result && $result['status']==0){
            return "success";
        }else{
            return "fail";
        }
    }

    public function analyUpdateVcard($vcardJson,$updatedParam=array(),$side='front')
    {
        $rst = array();
        $vcardArr = json_decode($vcardJson,true);
        $sideData    = $vcardArr[$side];
        //$sysFileds = array('name','mobile','company_name','address','telephone','web'); //定义名片中有的所有属性,'email','fax','job'
        $nameArr = isset($sideData['name'])?$sideData['name']:array(); //姓名
        $mobileArr = isset($sideData['mobile'])?$sideData['mobile']:array(); //手机号
        //$telephoneArr = isset($sideData['telephone'])?$sideData['telephone']:array(); //手机号
        $emailArray = isset($sideData['email'])?$sideData['email']:array(); //邮箱
        $companyArr = isset($sideData['company'])?$sideData['company']:array(); //公司
        //修改名字
        if($nameArr){
            foreach ($nameArr as $key=>$value){
                if($key > 0){
                    break;
                }
                $nameArr[$key]['value'] = $updatedParam['name'][0];
                $nameArr[$key]['is_changed'] = 1;
            }
        }else{
            $nameArr[0] = array('title_self_def'=>0, 'is_changed'=>1, 'input'=>'2','is_chinese'=>1,'surname'=>'','given_name'=>'', 'value'=>$updatedParam['name'][0], 'title'=>'姓名');
        }

        //修改手机号
        if($mobileArr){
            foreach ($mobileArr as $key=>$value){
                $mobileArr[$key]['value'] = $updatedParam['mobile'][$key];
                $mobileArr[$key]['is_changed'] = 1;
            }
        }else{
            $mobileArr[0] = array('title_self_def'=>0, 'is_changed'=>1, 'input'=>'2', 'value'=>$updatedParam['mobile'][0], 'title'=>'手机');
        }

        //修改邮箱
        if($emailArray){
            foreach ($emailArray as $key=>$value){
                $emailArray[$key]['value'] = $updatedParam['email'][$key];
                $emailArray[$key]['is_changed'] = 1;
            }
        }else{
            $emailArray[0] = array('title_self_def'=>0, 'is_changed'=>1, 'input'=>'2', 'value'=>$updatedParam['email'][0], 'title'=>'邮箱');
        }
        //修改公司相关信息
        if($companyArr){
            foreach ($companyArr as $key=>$company){
                if($key>0){
                    break;
                }
                //公司名称信息修改
                $company_nameArr = isset($company['company_name'])?$company['company_name']:array();
                if($company_nameArr){
                    foreach ($company_nameArr as $k=>$v){
                        if($k > 0){
                            break;
                        }
                        $company_nameArr[$key]['value'] = $updatedParam['company_name'][0];
                    }
                }else if(!empty($updatedParam['company_name'][0])){
                    $company_nameArr[0] = array('title_self_def'=>0, 'is_changed'=>1, 'input'=>'2', 'value'=>$updatedParam['company_name'][0], 'title'=>'公司');
                }
                $companyArr[$key]['company_name'] = $company_nameArr;

                //公司地址信息修改
                $addressArr = isset($company['address'])?$company['address']:array();
                if($addressArr){
                    foreach ($addressArr as $k=>$v){
                        if($k > 0){
                            break;
                        }
                        $addressArr[$key]['value'] = $updatedParam['address'][0];
                    }
                }else if(!empty($updatedParam['address'][0])){
                    $addressArr[0] = array('title_self_def'=>0, 'is_changed'=>1, 'input'=>'2', 'value'=>$updatedParam['address'][0], 'title'=>'地址');
                }
                $companyArr[$key]['address'] = $addressArr;

                //公司职位修改
                $jobArr = isset($company['job'])?$company['job']:array();
                if($jobArr){
                    foreach ($jobArr as $k=>$v){
                        if($k > 0){
                            break;
                        }
                        $jobArr[$key]['value'] = $updatedParam['job'][0];
                    }
                }else if(!empty($updatedParam['job'][0])){
                    $jobArr[0] = array('title_self_def'=>0, 'is_changed'=>1, 'input'=>'2', 'value'=>$updatedParam['job'][0], 'title'=>'职位');
                }
                $companyArr[$key]['job'] = $jobArr;

                //修改电话号码
                $telephoneArr = isset($company['telephone'])?$company['telephone']:array();
                if($telephoneArr){
                    foreach ($telephoneArr as $k=>$v){
                        $telephoneArr[$k]['value'] = $updatedParam['telephone'][$k];
                    }
                }else if(!empty($updatedParam['telephone'][0])){
                    $telephoneArr[0] = array('title_self_def'=>0, 'is_changed'=>1, 'input'=>'2', 'value'=>$updatedParam['telephone'][0], 'title'=>'电话');
                }

                $companyArr[$key]['telephone'] = $telephoneArr;

                //修改网址
                $webArr = isset($company['web'])?$company['web']:array();
                if($webArr){
                    foreach ($webArr as $k=>$v){
                        $webArr[$k]['value'] = $updatedParam['web'][$k];
                    }
                }else if(!empty($updatedParam['web'][0])){
                    $webArr[0] = array('title_self_def'=>0, 'is_changed'=>1, 'input'=>'2', 'value'=>$updatedParam['web'][0], 'title'=>'网址');
                }
                $companyArr[$key]['web'] = $webArr;

                //修改邮箱
                $emailArr = isset($company['email'])?$company['email']:array();
                if($emailArr){
                    foreach ($emailArr as $k=>$v){
                        $emailArr[$k]['value'] = $updatedParam['email'][$k];
                    }
                }else if(!empty($updatedParam['email'][0])){
                    $emailArr[0] = array('title_self_def'=>0, 'is_changed'=>1, 'input'=>'2', 'value'=>$updatedParam['email'][0], 'title'=>'邮箱');
                }
                $companyArr[$key]['email'] = $emailArr;

            }
        }else{//当公司信息为空时，直接补充一条信息
            !empty($updatedParam['company_name'][0]) && $companyArr[0]['company_name'][0] = array('title_self_def'=>0, 'is_changed'=>1, 'input'=>'2', 'value'=>$updatedParam['company_name'][0], 'title'=>'公司');
            !empty($updatedParam['address'][0]) && $companyArr[0]['address'][0] = array('title_self_def'=>0, 'is_changed'=>1, 'input'=>'2', 'value'=>$updatedParam['address'][0], 'title'=>'地址');
            !empty($updatedParam['job'][0]) && $companyArr[0]['job'][0] = array('title_self_def'=>0, 'is_changed'=>1, 'input'=>'2', 'value'=>$updatedParam['job'][0], 'title'=>'职位');
            !empty($updatedParam['telephone'][0]) && $companyArr[0]['telephone'][0] = array('title_self_def'=>0, 'is_changed'=>1, 'input'=>'2', 'value'=>$updatedParam['telephone'][0], 'title'=>'电话');
            !empty($updatedParam['web'][0]) && $companyArr[0]['web'][0] = array('title_self_def'=>0, 'is_changed'=>1, 'input'=>'2', 'value'=>$updatedParam['web'][0], 'title'=>'网址');
            !empty($updatedParam['email'][0]) && $companyArr[0]['email'][0] = array('title_self_def'=>0, 'is_changed'=>1, 'input'=>'2', 'value'=>$updatedParam['email'][0], 'title'=>'邮箱');
        }
        $sideData['name'] = $nameArr;
        $sideData['mobile'] = $mobileArr;
        $sideData['email'] = $emailArray;
        $sideData['company'] = $companyArr;
        $vcardArr[$side] = $sideData;
        //log::write('File:'.__FILE__.' LINE:'.__LINE__." 修改后的信息格式为： \r\n<pre>".''.var_export($vcardArr,true));
        return json_encode($vcardArr);
    }



















}