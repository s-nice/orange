<?php
/**
 * html5 交换名片
 * @author jiyl
 *
 */
namespace H5\Controller;
use BaseController\BaseController;
use Classes\GFunc;
use Company\Controller\AaaController;
class ExchangeController extends BaseController{
	/*
	 * 是否检查登陆状态。 如果检查登陆状态， controller里面会自动检测登陆。
	 * @var bool
	 */
	protected $toCheckLogin = FALSE;
    public function _initialize()
    {
        parent::_initialize();
        $this->assign('T',$this->translator);
//         $this->assign('title',$this->translator->h5_exchange_vcard_title);

    }
    /**
     * 构造函数
     */
    public function __construct()
    {
    	parent::__construct();
    }
    /**
     * 生成vcard数据
     */
    public function bulidVcf($vcard,$uuid,$uid){
    	$arr = @json_decode($vcard, true);
    	$vcardInfo['front'] = isset($arr['front'])?$arr['front']:array();
    	$vcardInfo['back'] = isset($arr['back'])?$arr['back']:array();
    	$vcard = array();
    	foreach(array('front','back') as $v){
    		$arr = array();
    		isset($vcardInfo[$v]['name'][0]['value']) && $arr['name'] = array('value'=> $vcardInfo[$v]['name'][0]['value']); // 姓名
    		isset($vcardInfo[$v]['name'][0]['value']) && $arr['fullname'] = array('value'=> $vcardInfo[$v]['name'][0]['value']); // 姓名
    		isset($vcardInfo[$v]['mobile'][0]['value']) && $arr['mobilephone1'] = array('value'=> $vcardInfo[$v]['mobile'][0]['value']); // 手机
    		isset($vcardInfo[$v]['company'][0]['job'][0]['value']) && $arr['title'] = array('value'=>$vcardInfo[$v]['company'][0]['job'][0]['value'] ); // 职位
    		isset($vcardInfo[$v]['company'][0]['company_name'][0]['value']) && $arr['company'] = array('value'=>$vcardInfo[$v]['company'][0]['company_name'][0]['value']); // 公司
    		isset($vcardInfo[$v]['company'][0]['department'][0]['value']) && $arr['department'] = array('value'=>$vcardInfo[$v]['company'][0]['department'][0]['value']); // 部门
    		isset($vcardInfo[$v]['company'][0]['email'][0]['value']) && $arr['email1'] = array('value'=>$vcardInfo[$v]['company'][0]['email'][0]['value']); // 邮箱
    		isset($vcardInfo[$v]['company'][0]['address'][0]['value']) && $arr['address'] = array('value'=>$vcardInfo[$v]['company'][0]['address'][0]['value']); // 公司地址
    		isset($vcardInfo[$v]['company'][0]['web'][0]['value']) && $arr['web'] = array('value'=>$vcardInfo[$v]['company'][0]['web'][0]['value']); // 网址
    		isset($vcardInfo[$v]['company'][0]['fax'][0]['value']) && $arr['fax1'] = array('value'=>$vcardInfo[$v]['company'][0]['fax'][0]['value']); // 传真
    		isset($vcardInfo[$v]['company'][0]['telephone'][0]['value']) && $arr['officephone1'] = array('value'=>$vcardInfo[$v]['company'][0]['telephone'][0]['value']); // 电话
      		$vcard[$v] = $arr;
    	}
    	
    	//组装名片vcf数据
    	if (!class_exists('CardOperator')) {
    		require_once LIB_ROOT_PATH . 'Classes/CardOperator.class.php';//导入解析名片数据文件
    	}
    	$CardOperator = new \CardOperator();
    	// 不包含头像信息的vcf文件
    	$vcardStr = $CardOperator->buildVcard($vcard['front'],$vcard['back']);
    	$vcardUrl = rtrim(C('CARD_DOWNLOAD_PATH'),'/')."/{$uuid}.vcf";
    	is_dir(C('CARD_DOWNLOAD_PATH')) || @mkdir(C('CARD_DOWNLOAD_PATH'),0777,true);
    	@file_put_contents($vcardUrl,$vcardStr);
    	
    	// 包含头像信息的vcf文件
    	$photoDir = rtrim(C('CARD_DOWNLOAD_PATH'),'/').'/'.$uuid.'/';
    	is_dir($photoDir) || @mkdir($photoDir,0777,true);
    	if(!empty($uid)){
            // 生成通讯录、outlook直接使用带头像的vcf
    		@file_put_contents($photoDir.$uuid.'.png',file_get_contents($uid));
    		$vcard['front']['photo'] = array('value'=>$photoDir.$uuid.'.png');
    		$vcardStr = $CardOperator->buildVcard($vcard['front'],$vcard['back']);
    		$vcardUrl = rtrim(C('CARD_DOWNLOAD_PATH'),'/')."/{$uuid}_img.vcf";
    		@file_put_contents($vcardUrl,$vcardStr);

            //生成微信识别带头像的vcf
            // $vcard['front']['photo'] = array('value'=>$uid);
            // $vcardQrStr = $CardOperator->buildVcard($vcard['front'],$vcard['back']);
            // $vcardQrStr = str_replace(array("https\://","http\://"), array("https://","https://"), $vcardQrStr);
            // @file_put_contents(rtrim(C('CARD_DOWNLOAD_PATH'),'/')."/{$uuid}_qrimg.vcf",$vcardQrStr);
    	}
    	return $vcardInfo;
    }

    /**生成单面vcard数据
     * @param $vcard
     * @param $uuid
     * @param $uid
     * @param bool $isReverse
     * @return mixed
     */
    public function bulidVcf2($vcard,$uuid,$uid,$isReverse=false){
        if (!class_exists('CardOperator')) {
            require_once LIB_ROOT_PATH . 'Classes/CardOperator.class.php';//导入解析名片数据文件
        }
        $CardOperator = new \CardOperator();
        $arr = @json_decode($vcard, true);
        is_dir(C('CARD_DOWNLOAD_PATH')) || @mkdir(C('CARD_DOWNLOAD_PATH'),0777,true);
        $vcardInfo['front'] = isset($arr['front'])?$arr['front']:array();
        $vcardInfo['back'] = isset($arr['back'])?$arr['back']:array();
        $v = $isReverse?'back':'front';
        $vcard = array();
        $arr = array();
        isset($vcardInfo[$v]['name'][0]['value']) && $arr['name'] = array('value'=> $vcardInfo[$v]['name'][0]['value']); // 姓名
        isset($vcardInfo[$v]['name'][0]['value']) && $arr['fullname'] = array('value'=> $vcardInfo[$v]['name'][0]['value']); // 姓名
        isset($vcardInfo[$v]['mobile'][0]['value']) && $arr['mobilephone1'] = array('value'=> $vcardInfo[$v]['mobile'][0]['value']); // 手机
        isset($vcardInfo[$v]['company'][0]['job'][0]['value']) && $arr['title'] = array('value'=>$vcardInfo[$v]['company'][0]['job'][0]['value'] ); // 职位
        isset($vcardInfo[$v]['company'][0]['company_name'][0]['value']) && $arr['company'] = array('value'=>$vcardInfo[$v]['company'][0]['company_name'][0]['value']); // 公司
        isset($vcardInfo[$v]['company'][0]['department'][0]['value']) && $arr['department'] = array('value'=>$vcardInfo[$v]['company'][0]['department'][0]['value']); // 部门
        isset($vcardInfo[$v]['company'][0]['email'][0]['value']) && $arr['email1'] = array('value'=>$vcardInfo[$v]['company'][0]['email'][0]['value']); // 邮箱
        isset($vcardInfo[$v]['company'][0]['address'][0]['value']) && $arr['address'] = array('value'=>$vcardInfo[$v]['company'][0]['address'][0]['value']); // 公司地址
        isset($vcardInfo[$v]['company'][0]['web'][0]['value']) && $arr['web'] = array('value'=>$vcardInfo[$v]['company'][0]['web'][0]['value']); // 网址
        isset($vcardInfo[$v]['company'][0]['fax'][0]['value']) && $arr['fax1'] = array('value'=>$vcardInfo[$v]['company'][0]['fax'][0]['value']); // 传真
        isset($vcardInfo[$v]['company'][0]['telephone'][0]['value']) && $arr['officephone1'] = array('value'=>$vcardInfo[$v]['company'][0]['telephone'][0]['value']); // 电话
        $vcard = $arr;
        $vcardStr = $CardOperator->buildOneVcard($vcard);
        $filename = $isReverse?$uuid:$uuid.'_';
        $vcardUrl = rtrim(C('CARD_DOWNLOAD_PATH'),'/')."/{$filename}.vcf";
        @file_put_contents($vcardUrl,$vcardStr);
        // 包含头像信息的vcf文件
        $photoDir = rtrim(C('CARD_DOWNLOAD_PATH'),'/').'/'.$uuid.'/';
        is_dir($photoDir) || @mkdir($photoDir,0777,true);
        $imgInfo = $this->getImageFromApi($uid, '/account/avatar', false);
        if($imgInfo&&!$isReverse){
            @file_put_contents($photoDir.$uuid.'.png',$imgInfo);
            $vcard['photo'] = array('value'=>$photoDir.$uuid.'.png');
            $vcardStr = $CardOperator->buildOneVcard($vcard);
            $vcardUrl = rtrim(C('CARD_DOWNLOAD_PATH'),'/')."/{$uuid}_img.vcf";
            @file_put_contents($vcardUrl,$vcardStr);
        }
        return $vcardInfo;
    }
    /**
     * 下载文件
     */
    function downloadFile(){
    	$id = I('get.fid','');
    	//文件路径（路径+文件名）
    	$fileImgPath = rtrim(C('CARD_DOWNLOAD_PATH'),'/')."/{$id}_img.vcf";
    	$filePath = rtrim(C('CARD_DOWNLOAD_PATH'),'/')."/{$id}.vcf";
    	 
    	$fileName = I('get.name','','urldecode');
    	//no cache
    	header('Expires: 0');
    	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    	header('Cache-Control: private',false);
        header('Content-Type: text/x-vcard;charset=utf-8');
    	header('Content-Disposition: attachment;filename*=utf-8\'\' '.urlencode($fileName).'.vcf;');
    	header('Connection: close');
    	//输出到浏览器
    	if(file_exists($fileImgPath))
    	{
    		readfile($fileImgPath);
    	}else{
    		readfile($filePath);
    	}
    	exit();
    }
    /**
     * 生成头像
     */
    public function getHeadImg(){
    	$clientId = $_GET['cid'];
    	/* \AppTools::webService('\Model\Account\Account', 'headImage',array('params'=>array('path'=>$clientId)));
    	
    	$url = I('clientid','A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752'); */
    	//$clientid = urlencode($clientid);
    	$apiurl = '/account/avatar'; 	//api地址
    	//输出图片
    	$defaultImage = WEB_ROOT_DIR . 'images/default/avatar_user_chat.png';
    	if(empty($clientId) || false==$this->getImageFromApi($clientId, $apiurl, true)) {
    		header('Content-type: image/png');
    		echo file_get_contents($defaultImage);
    	}
    }
    /**
     * 生成二维码
     */
    public function qrcode(){
    	$id = I('get.fid','');
        // if (is_file(rtrim(C('CARD_DOWNLOAD_PATH'),'/')."/{$id}_qrimg.vcf")) {
        //     $filePath = rtrim(C('CARD_DOWNLOAD_PATH'),'/')."/{$id}_qrimg.vcf";
        // } else {

        //文件路径（路径+文件名）
        $filePath = rtrim(C('CARD_DOWNLOAD_PATH'),'/')."/{$id}.vcf";

        // }
        
    	// 引入PHP QR库文件
    	include_once LIB_ROOT_PATH."3rdParty/phpqrcode/phpqrcode.php";
    	\QRcode::png(file_get_contents($filePath));
    }
    /**
     * 生成二维码
     */
    public function qrcode1(){
    	// 引入PHP QR库文件
    	include_once LIB_ROOT_PATH."3rdParty/phpqrcode/phpqrcode.php";
//     	\QRcode::png('http://192.168.30.191:8000/h5/imora/manual.html');die;
    	\QRcode::png('http://192.168.30.191:8000/h5/exchange/id.html?q=C4LblFN5kK0wAjyqPOPY9w2a0cWmYFov&from=singlemessage&isappinstalled=0
');
    }
    /**
     * ajax 获取名片信息
     */
    public function getCardInfo()
    {
    	$type = I('get.ajaxType','');
    	$params = array();
    	$vcardInfo = array();
    	switch ($type)
    	{
    		case 'qr':
    			$params['act'] = 'getqrcopycard';
    			$params['keyid'] = I('get.key','0');
    			$vcardInfo = \AppTools::webService('\Model\Contact\VcardExchange','vcardExchange',array('params'=>$params,'crudMethod'=>'C'));
    			break;
    		case 'index':
    			$params['act'] = 'getqrcopycard';
    			$params['vcardid'] = I('get.vcardid','0');
    			$params['key'] = I('get.key','0');
    			$params['timestamp'] = I('get.timestamp','0');
    			$vcardInfo = \AppTools::webService('\Model\Contact\VcardExchange','vcardExchange',array('params'=>$params,'crudMethod'=>'C'));

    			break;
    		case 'id':
    			$params['act'] = 'getqrcopycard';
    			$moreparams = I('get.moreParams','');
    			$params['vcardid'] = I('get.q', '');
    			$vcardInfo = \AppTools::webService('\Model\Contact\VcardExchange','vcardExchange',array('params'=>$params,'crudMethod'=>'C'));
    			break;
    		case 'invitationCode':
    			$params['invitecode'] = I('get.code', '');
    			$params['vcardid'] = I('get.cardId','');
    			$vcardInfo = \AppTools::webService('\Model\Contact\VcardExchange','getCardByCode',array('params'=>$params));
				break;
			default:
				;

    	}
    	if($vcardInfo['status'] == '0' && isset($vcardInfo['data'])){
    		$vcardInfo = $vcardInfo['data'];
    		if($vcardInfo['cardtype'] == 'scan' && !in_array($vcardInfo['handlestate'],array('handled' ,'neverhandle'))){
    			$this->ajaxReturn(3);
    		}else{
    			$this->ajaxReturn(2);
    		}
    	}else{
    		$this->ajaxReturn(1);
    	}
    }
    /**
     * 交换名片新url(2016-12-12)
     * http://oraDomain/H5/exchange/qr?key=***
     */
    public function qr(){
    	$this->assign('minTitle','');
    	$userId = $cardId = '';
    	$vcardInfo = array();
    	$_SESSION['h5Info'] = array();
    	$params = array();
    	I('get.key','0') != '0' && $params['keyid'] = I('get.key','0');
    	if(count($params) != 0){
    		$this->showCard($params,'exchange');
    		$this->assign('ajaxUrl',U('H5/exchange/getCardInfo',array('ajaxType'=>'qr','key'=>$params['keyid']),'html',true));
    	}else{
    		// 名片参数缺失， 跳转到app介绍页面
    		redirect(U('H5/Imora/appDetail'));
    	}
    	$this->display('index');
    }
    /**
     * 二维码交换名片接口
     */
	public function index()
    {
    	//  http://oraDomain/h5/exchange.html?userId=***&cardId=****
    	//  http://qrcodeurl?key=***&clientid=***&vcardid=***&timestamp=***
    	$this->assign('minTitle','');
    	$invitationCode = I('get.code', '');
    	$userId = $cardId = '';
    	$vcardInfo = array();
    	$_SESSION['h5Info'] = array();
    	$params = array();
    	I('get.clientid','0') != '0' && $params['clientid'] = I('get.clientid','0');
    	I('get.vcardid','0') != '0' && $params['vcardid'] = I('get.vcardid','0');
    	I('get.key','0') != '0' && $params['key'] = I('get.key','0');
    	I('get.timestamp','0') != '0' && $params['timestamp'] = I('get.timestamp','0');
    	if(count($params) == 4){
    		$this->showCard($params,'exchange');
    		$params['ajaxType'] = 'index';
    		$this->assign('ajaxUrl',U('H5/exchange/getCardInfo',$params,'html',true));

    	}else{
    		// 名片参数缺失， 跳转到app介绍页面
    		redirect(U('H5/Imora/appDetail'));
    	}
    	$this->display('index');
    }
    /**
     * 二维码扫描 按对方身份名片ID交换名片
     * http://dev.orayun.com/h5/exchange/id.html?q=AEK9TWaoP9QO34lB8EMEM4GBTJHQIO65&from=singlemessage&ttt=123&isSycn=1
     */
    public function id ()
    {
        $isDebug = I('isDebug',2); //调试模式,1、同步调试，2、异步调试，0、不调试
        $this->assign('isDebug', $isDebug);
    	$this->assign('minTitle','');
    	$moreparams = I('get.moreParams','');
    	$cardId = I('get.q', '');
    	$cardfrom = I('get.qmodule','');
    	$self = I('get.self',0); //1：分享自己的 名片（交换名片），0：分享他人的名片（保存名片），
    	$userId = '';
    	$vcardInfo = array();
    	$_SESSION['h5Info'] = array();
    	if(!empty($cardId)){
    		$params = array('idVcardid'=>$cardId,'q'=>$cardId,'moreParams'=>$moreparams,'qmodule'=>$cardfrom,'self'=>$self);
    		$this->showCard($params,'id');
            $this->getPersonalHomepageHead($cardId);// 获取个人主页
            if (userAgent() == 'desktop') {
                $this->assign('device','pcCard');//跳转到pc端名片详情样式
            }
    	}else{
    		// 邀请码错误， 跳转到app介绍页面
    		redirect(U('H5/Imora/appDetail'));
    	}
    	$this->display('index');
    }
    public function writeLogs(){
        $paramsurl = $_POST;
        /*$fp = fopen(WEB_ROOT_DIR.'../Runtime/Logs/H5/wechatlogs.txt', 'a+b');
        fwrite($fp,date("Y-m-d H:i:s",time()).',本次调起app的url为:'.$urls."\n");
        fclose($fp);*/
        \Think\Log::write("-------------------------------------\n", \Think\Log::INFO,'');
        \Think\Log::write('本次调起app的url参数: '.var_export($paramsurl,true), \Think\Log::INFO,'');
        \Think\Log::write("-------------------------------------\n", \Think\Log::INFO,'');
        $this->ajaxReturn(array('status'=>0));
    }
    public function showLogsWechat(){
        $type = I('get.type',0);
        //打开文件,（只读模式+二进制模式）
        @$fp=fopen(WEB_ROOT_DIR.'../Runtime/Logs/H5/wechatlogs.txt', 'rb');
        flock($fp,LOCK_SH);
        if(!$fp){
            echo "<p><strong>没有日志</strong></p>";
        }else{
            while(!feof($fp)){
                $order=fgets($fp,999);
                echo $order."<br/>";
            }
        }
        //释放已有的锁定
        flock($fp,LOCK_UN);
        //关闭文件流
        fclose($fp);

        if($type!=0){
            //读取params 日志
            echo "--------------参数日志---------------</br>";
            @$fp=fopen(WEB_ROOT_DIR.'../Shell/wechatlogs_params.txt', 'rb');
            flock($fp,LOCK_SH);
            if(!$fp){
                echo "<p><strong>没有日志</strong></p>";
            }else{
                while(!feof($fp)){
                    $order=fgets($fp,999);
                    echo $order."<br/>";
                }
            }
            //释放已有的锁定
            flock($fp,LOCK_UN);
            //关闭文件流
            fclose($fp);
        }

        echo '-----------读取完毕----------。';

    }
    /**
     * 通过二维码参数获得名片信息
     * @param array $params 接收到的参数
     * @param string $type exchange|id
     */
    protected function showCard($params,$type){
    	$keyword = array('act'=>'getqrcopycard');
    	// 入口index
    	isset($params['vcardid']) && $keyword['vcardid'] = $params['vcardid'];
    	isset($params['key']) && $keyword['key'] = $params['key'];
    	isset($params['timestamp']) && $keyword['timestamp'] = $params['timestamp'];
    	// 入口 qr
    	isset($params['keyid']) && $keyword['keyid'] = $params['keyid'];
    	// 入口 id
    	isset($params['idVcardid']) && $keyword['vcardid'] = $params['idVcardid'];
    	$vcardInfo = \AppTools::webService('\Model\Contact\VcardExchange','vcardExchange',array('params'=>$keyword,'crudMethod'=>'C'));
    	$this->assign('moreCSSs',array('css/H5/globalPopH5720'));
    	$this->assign('moreScripts',array('js/jsExtend/layer/layer.min','js/oradt/globalPopH5','js/jquery/jquery.qrcode.min'));
    	if($vcardInfo['status'] == '0' && isset($vcardInfo['data'])){
    		$vcardInfo = $vcardInfo['data'];
    		$vcardInfo['userid'] = isset($vcardInfo['userid'])
    		                       ?
    		                       $vcardInfo['userid']
    		                       :
    		                       (isset($vcardInfo['user_id']) ? $vcardInfo['user_id'] : '');
    		$params['clientid'] = $vcardInfo['userid'];
    		if(isset($vcardInfo['vcard'])){
    			$vcard = $this->bulidVcf($vcardInfo['vcard'],$vcardInfo['vcardid'],$vcardInfo['avatar']);
    			$vcardInfo['cardInfoFront'] = $vcard['front'];
    			$vcardInfo['cardInfoBack'] = $vcard['back'];
    			
    		}
    		$_SESSION['h5Info'][$type] = $params;
    		$_SESSION['h5Info']['type'] = $type;
    		$_SESSION['h5Info']['status'] = 'off';
    		$_SESSION['h5Info']['mobile'] = '';
    		$title = ($vcardInfo['FN'] != '')?$vcardInfo['FN']:$vcardInfo['cardInfoFront']['name'][0]['value'];
            $vcardInfo = $this->handlePic($vcardInfo);
            
    		$this->assign('title',$title.$this->translator->h5_card_xxxcard);
    		$this->assign('vcardInfo',$vcardInfo);
    		$this->assign('params',$params);
            //记录数据日志
            \Think\Log::write("-------------</br>-------------\n", \Think\Log::INFO,'');
            \Think\Log::write('params: '.var_export($params,true), \Think\Log::INFO,'');
            \Think\Log::write("-------------</br>-------------\n", \Think\Log::INFO,'');

    	}else{
    		// 错误处理， 跳转到app介绍页面
    		redirect(U('H5/Imora/appDetail'));
    	}
    }

    /**
     * 获取个人主页的头一两条内容展示
     * @param string $cardId 名片id
     */
    public function getPersonalHomepageHead($cardId)
    {
        $contents = $this->getHomePageContents($cardId);
        
        $contentsHead = array();
        foreach ($contents as $key=>$content) {
            if ($key == 0) {
                $contentsHead[0] = $content;
                if($content['width'] == '2.0')  break;
            }
            if ($key == 1) {
                if($content['width'] == '2.0')  break;
                $contentsHead[1] = $content;
                break;
            }
        }
        $this->assign('contents',$contentsHead);
    }

    /**
     * 获取个人主页信息并处理视频的长宽展示
     * @param string $cardId 名片id
     * @return array 
     */
    public function getHomePageContents($cardId)
    {
        $params['vcardid'] = $cardId;
        $contents = \AppTools::webService('\Model\Contact\VcardExchange','getCardExtendDetail',array('params'=>$params));
        $key = 0;
        if ($contents['data']['numfound'] == 0) {
            return array();
        } else {
            foreach ($contents['data']['list'] as $content) {
                $resinfo = json_decode($content['resinfo'], true);
                if ($content['type'] == 2) { // 视频的宽高处理
                    if ($resinfo['width'] > $resinfo['height']) {
                        $contents['data']['list'][$key]['width'] = "2.0";
                        $contents['data']['list'][$key]['height'] = "1.0";
                    } else {
                        $contents['data']['list'][$key]['width'] = "1.0";
                        $contents['data']['list'][$key]['height'] = "1.5";
                    }
                } else {
                    $contents['data']['list'][$key]['width'] = $resinfo['width'];
                    $contents['data']['list'][$key]['height'] = $resinfo['height'];
                }
                unset($contents['data']['list'][$key]['resinfo']);
                $key++;
            }
        }
        return $contents['data']['list'];
    }

    /**
     * 获取名片的个人主页部分
     */
    public function getPersonalHomepage(){
        $cardId = I('cardId');
        $contents = $this->getHomePageContents($cardId);
        $this->assign('title','个人主页');
        $this->assign('contents',$contents);
        $this->display('homePage');
    }

    /**
     * 处理竖版名片
     */
    public function handlePic($vcardInfo){
        $pics = array('picture','picturea','pictureb');
        foreach ($pics as $pic) {
            if (isset($vcardInfo[$pic])) {
                $data = @getimagesize($vcardInfo[$pic]);
                if ($data[1] > $data[0]) {
                    $path = WEB_ROOT_DIR . 'temp/H5';
                    if (!is_dir($path)) {
                        mkdir($path);
                    }
                    $newname = end(explode("/", $vcardInfo[$pic]));
                    // 如果本地已经存在旋转后的图片或者旋转成功则给图片赋值
                    if (file_exists($path.'/'.$newname) || $this->rotateh5($vcardInfo[$pic],$path,90)) {
                        $vcardInfo[$pic] = 'temp/H5/'.$newname;
                    }
                }
            }
        }
        return $vcardInfo;
    }

    /** 
    * 修改一个图片 让其翻转指定度数 
    * 
    * @param string $filename 文件名（包括文件路径） 
    * @param float $degrees 旋转度数 
    * @return boolean 
    */ 
    public function rotateh5($filename,$src,$degrees = 90)  
    {  
        //读取图片  
        $data = @getimagesize($filename);  
        if($data==false)return false;  
        //读取旧图片  
        switch ($data[2]) {  
            case 1:  
                $src_f = imagecreatefromgif($filename);
                $type = 'gif';
                break;  
            case 2:  
                $src_f = imagecreatefromjpeg($filename);
                $type = 'jpeg';
                break;  
            case 3:  
                $src_f = imagecreatefrompng($filename);
                $type = 'png';
                break;  
        }   
        if($src_f=="")return false;  
        $rotate = @imagerotate($src_f, $degrees,0);  // 旋转图片后保存
        $newname = end(explode("/", $filename)); // 保存为图片名称
        $newsrc = $src.'/'.$newname; 
        if(!imagejpeg($rotate,$newsrc,100))return false;  
        @imagedestroy($rotate); 

        return true; 
    }

    /**
     * 通过邀请码交换名片
     */
    public function invitationCode ()
    {
    	$this->assign('minTitle','');
    	$invitationCode = I('get.code', '');
    	$cardfrom = I('get.f','');
    	$cardId = I('get.cardId','');
        $userId = '';
        $vcardInfo = array();
        $_SESSION['h5Info'] = array();
        if(is_numeric($invitationCode)){
        	$dataInfo = \AppTools::webService('\Model\Contact\VcardExchange','getCardByCode',array('params'=>array('invitecode'=>$invitationCode,'vcardid'=>$cardId)));
        	if($dataInfo['status'] == '0' && isset($dataInfo['data'])){
        		$vcardInfo = $dataInfo['data'];
        		$userId = $vcardInfo['userid'];
        		$vcardInfo['type'] == '2'?$cardId = $vcardInfo['cardid']:null;
        		if(isset($vcardInfo['vcard'])){
        			$vcardInfo['cardInfo'] = getCardArr($vcardInfo['vcard']);
        		}
        		$_SESSION['h5Info']['invitationCode'] = array('cardid'=>$cardId,'userid'=>$userId,'code'=>$invitationCode,'cardfrom'=>$cardfrom);
        		$_SESSION['h5Info']['type'] = 'invitationCode';
        		$_SESSION['h5Info']['status'] = 'off';
        		$_SESSION['h5Info']['mobile'] = '';
        	}else{
        		// 错误处理， 跳转到app介绍页面
        	    redirect(U('H5/Imora/appDetail'));
        	}
        }else{
        	// 邀请码错误， 跳转到app介绍页面
            redirect(U('H5/Imora/appDetail'));
        } 
        $this->assign('ajaxUrl',U('H5/exchange/getCardInfo',array('ajaxType'=>'invitationCode','code'=>$invitationCode,'f'=>$cardfrom,'cardId'=>$cardId),'html',true));
        $this->assign('vcardInfo',$vcardInfo);
        $this->assign('moreCSSs',array('css/H5/globalPopH5720'));
        $this->assign('moreScripts',array('js/jsExtend/layer/layer.min','js/oradt/globalPopH5'));
    	$this->display('index');
    }

	/**
	 * 交换名片登陆页面
	 */
    public function login()
    {
    	$this->assign('minTitle',$this->translator->h5_verification_login_title);
    	$_SESSION['h5Info']['mobile'] = '';
    	switch ($_SESSION['h5Info']['type']){
    		case 'exchange':
    			$info = $_SESSION['h5Info']['exchange'];
    			if($info['keyid']){
    				// 入口qr
    				$paramStr = 'key='.$info['keyid'];
    			}else{
    				// 入口 index
    				$paramStr = '';
	    			foreach($info as $k=>$v){
	    				$paramStr .= $k.'='.$v.'&';
	    			}
    				$paramStr = trim($paramStr,'&');
    			}
    			$goBackUrl = U('h5/exchange/index','','html',true).'?'.$paramStr;
    			break;
    		case 'invitationCode':
    			$info = $_SESSION['h5Info']['invitationCode'];
    			$goBackUrl = U('h5/exchange/invitationCode','','html',true).'?code='.$info['code'].'&f='.$info['cardfrom'].'&cardId='.$info['cardid'];
    			break;
    		case 'id':
    			$info = $_SESSION['h5Info']['id'];
    			$goBackUrl = U('h5/exchange/id','','html',true).'?q='.$info['q'].'&moreParams='.$info['moreParams'].'&qmodule='.$info['qmodule'];
    			break;
    		default:
    			// nodo
    			// 异常错误， 跳转到app介绍页面
    			redirect(U('H5/Imora/appDetail'));
    	}
		$phone = I('user','');
		$this->assign('phone',$phone);
		$this->assign('goBackUrl',$goBackUrl);
    	$this->assign('moreCSSs',array('css/H5/globalPopH5720'));
    	$this->assign('moreScripts',array('js/jsExtend/layer/layer.min','js/oradt/globalPopH5'));
    	$this->display('login');
    }
    /**
     * 已有账号登陆操作
     */
    public function loginAct(){
    	$user = I('post.user','');
    	$passwd = I('post.passwd','');
    	$ret = array('status'=>1,'msg'=>'');
    	$info = $_SESSION['h5Info'];
    	$userid = '';
    	// 判断接口
    	switch ($info['type']){
    		case 'exchange':
    			$paramsArr = isset($info['exchange'])?$info['exchange']:array();
    			$userid = isset($paramsArr['clientid'])?$paramsArr['clientid']:'';
    			break;
    		case 'invitationCode':
    			$paramsArr = isset($info['invitationCode'])?$info['invitationCode']:array();
    			$userid = isset($paramsArr['userid'])?$paramsArr['userid']:'';
    			break;
    		case 'id':
    			$paramsArr = isset($info['id'])?$info['id']:array();
    			$userid = isset($paramsArr['clientid'])?$paramsArr['clientid']:'';
    			break;
    		default:
    			// nodo
    	}
    	if($userid == ''){
    		$ret['status'] = 3;
    		$ret['msg'] = $this->translator->h5_cookie_error_info;
    	}else{
	    	if($user == '' || $passwd == ''){
	    	    $ret['status'] = 4;
	    	    $ret['msg'] = $this->translator->h5_login_user_or_passwd_error;
	    	}else{
		    	$params = array('user'=>$user,'passwd'=>$passwd,'type'=>'basic','ip'=>get_client_ip());
		    	$re = \AppTools::webService('\Model\Oauth\Oauth', 'oauth',array('params'=>$params,'crudMethod'=>'C'));
		    	if($re['status'] == 0){
		    		$_SESSION['h5Info']['mobile'] = $user;
		    		if($re['data']['clientid'] == $userid){
		    			$ret['status'] = 10;
		    			$ret['msg'] = $this->translator->h5_add_selfcard_warn;
		    		}else{
		    			$ret['status'] = 0;
		    			/** session */
		    			$session = array(
		    					'state'  =>isset($re['data']['state'])?$re['data']['state']:NULL,
		    					'userType'      => 'basic',
		    					'loginip'       => get_client_ip(), // use this ip for check autologin
		    					'accesstoken'   => $re['data']['accesstoken'],
		    					'tokenExpireTime' => $re['data']['expiration'] + time(),
		    			);
		    			session(MODULE_NAME, $session);
		    			$params = array('nindex'=>'1');
		    			$vcardInfo = \AppTools::webService('\Model\Contact\ContactVcard', 'contactVcard',array('params'=>$params,'crudMethod'=>'R'));
		    			if($vcardInfo['status'] == '0' && $vcardInfo['data']['numfound'] != '0'){
		    				$statusCode = $this->addFriend();
				        	$jsurl[0] = U('exchange/getFriendVcard','','',true);
				        	$jsurl[1] = U('imora/download','','',true);
				        	$jsurl['statusCode'] = isset($statusCode)?$statusCode:-3;
				        	echo json_encode(array('status'=>8,'data'=>$jsurl));
				        	die();
		    			}
		    		}
		    	}else{
		    		$statusArr = array('999003','100009','100012','100013','100010','200014','200015','200013');
		    		if(in_array($re['status'], $statusArr)){
		    			$msg = "h5_accountLogin_fail_{$re['status']}";
		    		}else{
		    			$msg = "h5_login_fail";
		    		}
		    		$ret['msg'] = empty($re['msg'])?$this->translator->h5_login_fail:$this->translator->$msg;
		    	}
	       	}
    	}
    	echo json_encode($ret);
    }
    /**
     * 校验手机号是否注册过
     */
    public function checkPhone(){
    	$phone = I('user','');
    	$params = array('mobile'=>$phone);
    	$status = \AppTools::webService('\Model\Account\Account', 'checkPhone',array('params'=>$params));
		$this->ajaxReturn($status);
    }
    /**
     * 交换名片注册页面一
     */
    public function register()
    {
    	$this->assign('minTitle',$this->translator->h5_title_register_title);
    	$phone = I('user','');
    	$this->assign('phone',$phone);
    	// 返回url
    	$goBackUrl = U('h5/exchange/login','','',true);
    	$this->assign('goBackUrl',$goBackUrl);
    	// 验证码校验成功后跳转url
    	$jsGoUrl = U('h5/exchange/registerTwo','','',true);
    	$this->assign('jsGoUrl',$jsGoUrl);
    	// 验证码接口判断
    	$this->assign('type','register');
    	$this->assign('moreCSSs',array('css/H5/globalPopH5720'));
    	$this->assign('moreScripts',array('js/jsExtend/layer/layer.min','js/oradt/globalPopH5'));
    	$this->display('register');
    }
    /**
     * 交换名片注册页面er
     */
    public function registerTwo()
    {
    	$this->assign('minTitle',$this->translator->h5_title_register_title);
    	$goBackUrl = U('h5/exchange/login','','',true);
    	$this->assign('goBackUrl',$goBackUrl);
    	$this->assign('moreCSSs',array('css/H5/globalPopH5720'));
    	$this->assign('moreScripts',array('js/jsExtend/layer/layer.min','js/oradt/globalPopH5'));
    	$this->display('registerLogin');
    }
    /**
     * 发送验证码
     */
    public function sendPhoneCode(){
    	$type = I('post.type','register');
    	$phone = I('post.phone','');
    	$mcode = I('post.mcode','');
    	$mcode = ltrim($mcode,'+');
    	$mcode = trim($mcode);
    	$ret = array('status'=>1,'msg'=>'');
    	if($phone == '' || $mcode == ''){
    		$ret['status'] = 3;
    		$ret['msg'] = $this->translator->h5_pop_phone_type_error;
    	}else{
    		switch ($type){
    			case 'forgetPasswd':
    				$params = array('mobile'=>$phone,'mcode'=>$mcode,'ip'=>get_client_ip(),'type'=>'basic');
    				$re = \AppTools::webService('\Model\Account\ResetPasswd','resetPasswd',array('params'=>$params,'crudMethod'=>'C'));
    				break;
    			default:
    				$params = array('mobile'=>$phone,'mcode'=>$mcode,'module'=>strtolower(MODULE_NAME).'/'.strtolower(ACTION_NAME));
    				$re = \AppTools::webService('\Model\Verification\Sms','sms',array('params'=>$params,'crudMethod'=>'C'));
    		}

    		if($re['status'] == 0){
    			$ret['status'] = 0;
    			$ret['data'] = $re['data']['messageid'];
    		}else{
    			$ret['msg'] = $this->translator->h5_pop_send_fail;
    		}
    	}
    	echo json_encode($ret);
    }
    /**
     * 检验验证码
     */
    public function phoneRegister(){
    	$type = I('post.type','register');
    	$phone = I('post.phone','');
    	$mcode = I('post.mcode','');
    	$mcode = ltrim($mcode,'+');
    	$mcode = trim($mcode);
    	$codeId = I('post.codeId','');
    	$code = I('post.code','');
    	$ret = array('status'=>1,'msg'=>'');
    	if($phone == '' || $mcode == '' || $code == '' || $codeId == ''){
    	    $ret['status'] = 3;
    	    $ret['msg'] = $this->translator->h5_verification_code_error_or_overtime;
    	}else{
    		switch ($type){
    			case 'forgetPasswd':
    				$params = array('messageid'=>$codeId,'mobile'=>$phone,'mcode'=>$mcode,'code'=>$code);
    				$re = \AppTools::webService('\Model\Account\ResetPasswd','resetPasswd',array('params'=>$params,'crudMethod'=>'R'));
    				break;
    			default:
    				$params = array('messageid'=>$codeId,'mcode'=>$mcode,'mobile'=>$phone,'code'=>$code);
	    			$re = \AppTools::webService('\Model\Verification\Sms','sms',array('params'=>$params,'crudMethod'=>'R'));
    		}

	    	if($re['status'] == 0){
	    		$ret['status'] = 0;
	    		$_SESSION['h5Info']['mobile'] = $phone;
	    	}else{
	    		$_SESSION['h5Info']['mobile'] = '';
	    		$ret['msg'] = $this->translator->h5_verification_code_error_or_overtime;
	    	}
    	}
    	echo json_encode($ret);
    }
    // 账号密码注册鉴权
    public function registerLogin(){
    	$info = $_SESSION['h5Info'];
    	$phone = isset($info['mobile'])?$info['mobile']:'';
    	$passwd1 = I('post.passwd1','');
    	$passwd2 = I('post.passwd2','');
    	$params  = array();
    	// 判断接口
    	switch ($info['type']){
    		case 'exchange':
    			$paramsArr = isset($info['exchange'])?$info['exchange']:array();
    			$paramsIf = count($paramsArr) != 0 ? false : true;
    			$params = array('mobile'=>$phone,'passwd'=>$passwd1,'ip'=>get_client_ip());
    			$userid = isset($paramsArr['clientid'])?$paramsArr['clientid']:'';
    			break;
    		case 'invitationCode':
		    	$paramsArr = isset($info['invitationCode'])?$info['invitationCode']:array();
		    	$paramsIf = (isset($paramsArr['code']) && is_numeric($paramsArr['code']))? false : true;
		    	$params = array('mobile'=>$phone,'passwd'=>$passwd1,'invitecode'=>$paramsArr['code'],'regfrom'=>$paramsArr['cardfrom'],'ip'=>get_client_ip());
		    	$userid = isset($paramsArr['userid'])?$paramsArr['userid']:'';
    			break;
    		case 'id':
    			$paramsArr = isset($info['id'])?$info['id']:array();
    			$paramsIf = count($paramsArr) != 0 ? false : true;
    			$params = array('mobile'=>$phone,'passwd'=>$passwd1,'ip'=>get_client_ip());
    			empty($paramsArr['qmodule']) || $params['regfrom'] = $paramsArr['qmodule'];
    			$userid = isset($paramsArr['clientid'])?$paramsArr['clientid']:'';
    			break;
    		default:
    			// nodo
    	}
    	$ret = array('status'=>1,'msg'=>'');
    	if($phone == '' || $paramsIf || empty($params)){
    		$ret['status'] = 3;
    		$ret['msg'] = $this->translator->h5_cookie_error_info;
    	}else{
    		$re = \AppTools::webService('\Model\Account\Account', 'account',array('params'=>$params,'crudMethod'=>'C'));
    		if($re['status'] == 0){
    			// 理论上不会出现该bug
    			if($re['data']['clientid'] == $userid){
    				$ret['status'] = 10;
    				$ret['msg'] = $this->translator->h5_add_selfcard_warn;
    			}else{
	    			$_SESSION['h5Info']['mobile'] = $phone;
	    			$ret['status'] = 0;
	    			/** session */
	    			  $session = array(
			                'state'  =>isset($re['data']['state'])?$re['data']['state']:NULL,
			                'userType'      => 'basic',
			                'loginip'       => get_client_ip(), // use this ip for check autologin
			                'accesstoken'   => $re['data']['accesstoken'],
			                'tokenExpireTime' => $re['data']['expiration'] + time(),
	    			  );
			        session(MODULE_NAME, $session);
			        $params = array('nindex'=>'1');
			        $vcardInfo = \AppTools::webService('\Model\Contact\ContactVcard', 'contactVcard',array('params'=>$params,'crudMethod'=>'R'));
			        if($vcardInfo['status'] == '0' && $vcardInfo['data']['numfound'] != '0'){
			        	$statusCode = $this->addFriend();
			        	$jsurl[0] = U('exchange/getFriendVcard','','',true);
			        	$jsurl[1] = U('imora/download','','',true);
			        	$jsurl['statusCode'] = isset($statusCode)?$statusCode:-3;
			        	echo json_encode(array('status'=>8,'data'=>$jsurl));
			        	die();
			        }
    			}
		    }else{
		    	$statusArr = array('300001','999003','999017','999022','300002','999016','999024','999026');
		    	if(in_array($re['status'], $statusArr)){
		    		$msg = "h5_accountRegister_fail_{$re['status']}";
		    	}else{
		    		$msg = "h5_login_fail";
		    	}
		    	$ret['msg'] = empty($re['msg'])?$this->translator->h5_register_fail:$this->translator->$msg;
    		}
    	}
    	echo json_encode($ret);
    }
    // 首页名片
    public function getIndex(){
    	if(isset($_SESSION['h5Info']['status']) && $_SESSION['h5Info']['status'] == 'off'){
    		$this->assign('minTitle', $this->translator->h5_create_index_card_title);
	    	$basicInfo = \AppTools::webService('\Model\Account\Account', 'account',array('params'=>array(),'crudMethod'=>'R'));
	    	if($basicInfo['status'] == '0' && $basicInfo['data']['numfound'] != '0'){
	    		$basicInfo = $basicInfo['data']['users'][0];
	    	}else{
	    		$basicInfo = array();
	    	}
	    	$basicInfo['vcardid'] = '';
	    	$this->assign('phone',$_SESSION['h5Info']['mobile']);
	    	$this->assign('basicInfo',$basicInfo);
	    	$this->assign('moreCSSs',array('css/H5/globalPopH5720'));
	    	$this->assign('moreScripts',array('js/jsExtend/layer/layer.min','js/oradt/globalPopH5'));
	    	$this->assign('localuuid',\Classes\GFunc::createUUID());
    		$this->display('getIndex');
    	}else{
    		// 错误处理 , 跳转到app介绍页面
    		redirect(U('H5/Imora/appDetail'));
    	}

    }

    /**
     * 添加首页名片
     */
    protected function addIndexVcard(){

    	$str = '{"front":{"name":[{"title":"\u59d3\u540d","value":"","is_chinese":"1"}],"mobile":[{"title":"\u624b\u673a","value":"","is_chinese":"1"}],"company":[{"department":[{"title":"\u90e8\u95e8","value":"","is_chinese":"1"}],"job":[{"title":"\u804c\u4f4d","value":"","is_chinese":"1"}],"address":[{"title":"\u5730\u5740","value":"","is_chinese":"1"}],"company_name":[{"title":"\u516c\u53f8\u540d\u79f0","value":"","is_chinese":"1"}],"telephone":[{"title":"\u7535\u8bdd","value":"","is_chinese":"1"}],"fax":[{"title":"\u4f20\u771f","value":"","is_chinese":"1"}],"email":[{"title":"\u90ae\u7bb1","value":"","is_chinese":"1"}],"web":[{"title":"\u7f51\u5740","value":"","is_chinese":"1"}]}],"selfdef":[]},"back":{"name":[],"mobile":[],"company":[{"department":[],"job":[],"address":[],"company_name":[],"telephone":[],"fax":[],"email":[],"web":[]}],"selfdef":[]}}';
    	$strArr = json_decode($str,true);
    	$param = $_SESSION['h5Info']['params'];
    	isset($param['realname']) && $strArr['front']['name'][0]['value'] = $param['realname'];
    	isset($param['cellphone']) && $strArr['front']['mobile'][0]['value'] = $param['cellphone'];
    	isset($param['department']) && $strArr['front']['company'][0]['department'][0]['value'] = $param['department'];
    	isset($param['title']) && $strArr['front']['company'][0]['job'][0]['value'] = $param['title'];
    	isset($param['address']) && $strArr['front']['company'][0]['address'][0]['value'] = $param['address'];
    	isset($param['company']) && $strArr['front']['company'][0]['company_name'][0]['value'] = $param['company'];
    	isset($param['telephone']) && $strArr['front']['company'][0]['telephone'][0]['value'] = $param['telephone'];
    	isset($param['fax']) && $strArr['front']['company'][0]['fax'][0]['value'] = $param['fax'];
    	isset($param['email1']) && $strArr['front']['company'][0]['email'][0]['value'] = $param['email1'];
    	isset($param['url']) && $strArr['front']['company'][0]['web'][0]['value'] = $param['url'];


    	$localuuid = $_POST['localuuid'];
    	$uuid = \Classes\GFunc::createUUID();
    	R('Company/Aaa/_addDefaultKeyValue',array(&$strArr));
    	$str = json_encode($strArr, JSON_UNESCAPED_UNICODE);
		if(R('Company/Aaa/createCardForExchange',array($uuid,$str))){
			$dataMd5 = md5($str);
			$picture = WEB_ROOT_DIR."temp/UserCards/{$dataMd5}/{$uuid}/{$uuid}-front.png";
			$file = WEB_ROOT_DIR."temp/UserCards/{$dataMd5}/{$uuid}.zip";
			$params = array(
					'source'=>'web',
					'localuuid'=>$localuuid,
					'nindex'=>'1',
					'self'=>'true',
					'vcard'=>$str,
					'cardres'=>$file,
					'picpatha'=>$picture);
			isset($param['title']) && $params['identityname'] = $param['title'];
			$vcardInfo = \AppTools::webService('\Model\Contact\ContactVcard', 'contactVcard',array('params'=>$params,'crudMethod'=>'C'));
			\GFile::deldir(WEB_ROOT_DIR."temp/UserCards/{$dataMd5}/");
			if($vcardInfo['status'] == '0'){
				$_SESSION['h5Info']['status'] = '1';
			}else{
				$logInfo = "[ERROR] -- Exchange/addIndexVcard -- ".$this->translator->h5_create_index_card_error.": ".print_r($vcardInfo,true);
				trace($logInfo, '', 'DEBUG', true);
				$re = array('status'=>'21','msg'=>$this->translator->h5_add_new_card_action_fail);
				echo json_encode($re);die;
			}
		}else{
			$logInfo = "[ERROR] -- Exchange/addIndexVcard --  ".$this->translator->h5_create_index_card_thumb_error."：R('Company/Aaa/createCardForExchange',array({$uuid},{$str}))";
			trace($logInfo, '', 'DEBUG', true);
			$re = array('status'=>'2','msg'=>$this->translator->h5_add_new_card_action_fail);
			echo json_encode($re);die;
		}

    }
    // 更新个人基本信息
    protected function resetBisca(){
    	!empty($_POST['name']) && $param['realname'] = $_POST['name'];
    	!empty($_POST['department']) && $param['department'] = $_POST['department'];
    	!empty($_POST['company']) && $param['company'] = $_POST['company'];
    	!empty($_POST['title']) && $param['title'] = $_POST['title'];
    	!empty($_POST['mobile']) && $param['cellphone'] = $_POST['mobile'];
    	!empty($_POST['email']) && $param['email1'] = $_POST['email'];
    	!empty($_POST['address']) && $param['address'] = $_POST['address'];
    	!empty($_POST['telephone']) && $param['telephone'] = $_POST['telephone'];
    	!empty($_POST['fax']) && $param['fax'] = $_POST['fax'];
    	!empty($_POST['url']) && $param['url'] = $_POST['url'];
    	$_SESSION['h5Info']['params'] = $param;
    	$basicStatus = \AppTools::webService('\Model\Account\Account', 'account',array('params'=>$param,'crudMethod'=>'U'));
    	if($basicStatus['status'] != '0'){
    		$logInfo = "[ERROR] -- Exchange/resetBisca -- ".$this->translator->h5_update_basicinfo_fail.": ".print_r($basicStatus,true);
    		trace($logInfo, '', 'DEBUG', true);
    		$re = array('status'=>'3','msg'=>$this->translator->h5_add_new_card_action_fail);
    		echo json_encode($re);die;
    	}
    }
    // 添加好友
    protected function addFriend(){
    	$params = session('h5Info');
    	// 判断接口
    	switch ($params['type']){
    		case 'exchange':
    			$params = $params['exchange'];
    			unset($params['clientid']);
    			$params['act'] = 'newqrcopycard';
    			$params['ifaddfriend'] = 'true';
    			$status = \AppTools::webService('\Model\Contact\VcardExchange', 'vcardExchange',array('params'=>$params,'crudMethod'=>'C'));
    			break;
    		case 'invitationCode':
    			$info = $params['invitationCode'];
    			$params = array('vcardid'=>$info['cardid']);
    			$params['act'] = 'reccopycard';
    			$params['invitecode'] = $info['code'];
    			$params['cardfrom'] = $info['cardfrom'];
    			$status = \AppTools::webService('\Model\Contact\VcardExchange', 'vcardExchange',array('params'=>$params,'crudMethod'=>'C'));
    			break;
    		case 'id':
    			// $params[id'] = array('idVcardid'=>$cardId,'q'=>$cardId,'moreParams'=>$moreparams,'clientid'=>$userid ,'qmodule'=>$cardfrom);
    			$params = array('vcardid'=>$params['id']['q'],'module'=>$params['id']['qmodule']);
    			$params['act'] = 'addfriend';
    			$status = \AppTools::webService('\Model\Contact\VcardExchange', 'vcardExchange',array('params'=>$params,'crudMethod'=>'C'));
    			break;
    		default:
    			// nodo
    	}
    	if($status['status'] != '0' || $status['data']['statusCode'] == '-1'){
    		$logInfo = "[ERROR] -- Exchange/addFriend -- " . print_r($status,true);
    		trace($logInfo, '', 'DEBUG', true);
    		$re = array('status'=>'4','msg'=>$this->translator->h5_add_new_card_action_fail);
    		echo json_encode($re);die;
    	}else{
    		return is_numeric($status['data']['statusCode'])?$status['data']['statusCode']:-2;
    	}


	}
    // 添加好友
    public function addFriendPage(){
    	$re = array('status'=>'1');
    	if(isset($_SESSION['h5Info']['status']) && $_SESSION['h5Info']['status'] == 'off'){
	    	$this->resetBisca();
	    	$this->addIndexVcard();
	    	$this->addFriend();
// 	    	$this->getFriendVcard();
	    	$jsurl[0] = U('exchange/getFriendVcard','','',true);
	    	$jsurl[1] = U('imora/download','','',true);
	    	$re['status'] = '0';
	    	$re['jsurl'] = $jsurl;
// 	    	echo '<script type="text/javascript">parent.$.h5.addFriendBack('.json_encode($jsurl).');</script>';
    	}else{
    		$re['msg'] = $this->translator->h5_more_create_index_card_fail;
    	}
    	echo json_encode($re);
    }
    // 获得发送好友后的名片信息
    public function getFriendVcard(){
    	$this->assign('minTitle',$this->translator->ha_save_card_end_title);
    	$params = session('h5Info');
    	// 当前登陆的手机号
		$this->assign('phone',$params['mobile']);
		// 判断接口
		switch ($params['type']){
			case 'exchange':
				$params = $_SESSION['h5Info']['exchange'];
				$params['act'] = 'getqrcopycard';
				unset($params['clientid']);
				$dataInfo = \AppTools::webService('\Model\Contact\VcardExchange','vcardExchange',array('params'=>$params,'crudMethod'=>'C'));
				break;
			case 'invitationCode':
				$invitationCode = $params['invitationCode']['code'];
				$dataInfo = \AppTools::webService('\Model\Contact\VcardExchange','getCardByCode',array('params'=>array('invitecode'=>$invitationCode,'vcardid'=>$params['invitationCode']['cardid'])));
				break;
			case 'id':
				$params = $_SESSION['h5Info']['id'];
				$params = array('vcardid'=>$params['q']);
				$params['act'] = 'getqrcopycard';
				$dataInfo = \AppTools::webService('\Model\Contact\VcardExchange','vcardExchange',array('params'=>$params,'crudMethod'=>'C'));
				break;
			default:
				// nodo
				// 异常错误， 跳转到app介绍页面
				redirect(U('H5/Imora/appDetail'));
		}

		if($dataInfo['status'] == '0' && isset($dataInfo['data'])){
			$vcardInfo = $dataInfo['data'];
			if(isset($vcardInfo['vcard'])){
				$vcardInfo['cardInfo'] = getCardArr($vcardInfo['vcard']);
			}
		}else{
			// 错误处理 , 跳转到app介绍页面
			redirect(U('H5/Imora/appDetail'));
		}
		unset($_SESSION['h5Info']);
		$this->assign('vcardInfo',$vcardInfo);
    	$this->display('saveEnd');
    }
    /**
     * 忘记密码
     */
    public function forgetPasswd(){
    	$this->assign('minTitle',$this->translator->h5_title_forget_passwd_title);
    	$phone = I('user','');
    	$this->assign('phone',$phone);
    	// 返回按键 url
    	$goBackUrl = U('h5/exchange/login','','',true);
    	$this->assign('goBackUrl',$goBackUrl);
    	// 验证码校验成功后跳转url
    	$jsGoUrl = U('h5/exchange/resetPasswd','','html',true);
    	$this->assign('jsGoUrl',$jsGoUrl);
    	// 验证码接口判断
    	$this->assign('type','forgetPasswd');
    	$this->assign('moreCSSs',array('css/H5/globalPopH5720'));
    	$this->assign('moreScripts',array('js/jsExtend/layer/layer.min','js/oradt/globalPopH5'));
    	$this->display('forgetPasswd');
    }
    /**
     * 修改密码页面
     */
    public function resetPasswd(){
    	$this->assign('minTitle',$this->translator->h5_title_forget_passwd_title);
    	$params = array();
    	$params['phone'] = I('phone');
    	$params['mcode'] = I('mcode','','trim');
    	$params['codeId'] = I('codeId');
    	$params['code'] =I('code');
    	$_SESSION['h5Info']['forgetpasswd'] = $params;
    	$_SESSION['h5Info']['mobile'] = $params['phone'];

    	$goBackUrl = U('h5/exchange/login','','',true);
    	$this->assign('goBackUrl',$goBackUrl);
    	$this->assign('moreCSSs',array('css/H5/globalPopH5720'));
    	$this->assign('moreScripts',array('js/jsExtend/layer/layer.min','js/oradt/globalPopH5'));
    	$this->display('resetPasswd');
    }
    /**
     * 修改密码操作
     */
    public function resetPasswdAct(){
    	$info = $_SESSION['h5Info'];
    	$phone = isset($info['mobile'])?$info['mobile']:'';
    	$passwd1 = I('post.passwd1','');
    	$passwd2 = I('post.passwd2','');
    	$param = isset($info['forgetpasswd'])?$info['forgetpasswd']:array();
    	// 判断接口
    	switch ($info['type']){
    		case 'exchange':
    			$paramsArr = isset($info['exchange'])?$info['exchange']:array();
    			$paramsIf = count($paramsArr) != 0 ? false : true;
    			$userid = isset($paramsArr['clientid'])?$paramsArr['clientid']:'';
    			break;
    		case 'invitationCode':
    			$paramsArr = isset($info['invitationCode'])?$info['invitationCode']:array();
    			$paramsIf = (isset($paramsArr['code']) && is_numeric($paramsArr['code']))? false : true;
    			$userid = isset($paramsArr['userid'])?$paramsArr['userid']:'';
    			break;
    		case 'id':
    			$paramsArr = isset($info['id'])?$info['id']:array();
    			$paramsIf = count($paramsArr) != 0 ? false : true;
    			$userid = isset($paramsArr['clientid'])?$paramsArr['clientid']:'';
    			break;
    		default:
    			// nodo
    	}
    	$ret = array('status'=>1,'msg'=>'');
    	if($phone == '' || $paramsIf || empty($param)){
    		$ret['status'] = 3;
    		$ret['msg'] = $this->translator->h5_cookie_error_info;
    	}else{
    		$params = array('passwd'=>$passwd1,'messageid'=>$param['codeId'],'mobile'=>$phone,'mcode'=>$param['mcode'],'code'=>$param['code'],'ip'=>get_client_ip(),'islogin'=>1);
    		$re = \AppTools::webService('\Model\Account\ResetPasswd','resetPasswd',array('params'=>$params,'crudMethod'=>'U'));
    		if($re['status'] == 0){
    			// 理论上不会出现该bug
    			if($re['data']['clientid'] == $userid){
    				$ret['status'] = 10;
    				$ret['msg'] = $this->translator->h5_add_selfcard_warn;
    			}else{
    				$_SESSION['h5Info']['mobile'] = $phone;
    				$ret['status'] = 0;
    				/** session */
    				$session = array(
    						'state'  =>isset($re['data']['state'])?$re['data']['state']:NULL,
    						'userType'      => 'basic',
    						'loginip'       => get_client_ip(), // use this ip for check autologin
    						'accesstoken'   => $re['data']['accesstoken'],
    						'tokenExpireTime' => $re['data']['expiration'] + time(),
    				);
    				session(MODULE_NAME, $session);
    				$params = array('nindex'=>'1');
    				$vcardInfo = \AppTools::webService('\Model\Contact\ContactVcard', 'contactVcard',array('params'=>$params,'crudMethod'=>'R'));
    				if($vcardInfo['status'] == '0' && $vcardInfo['data']['numfound'] != '0'){
    					$this->addFriend();
    					$jsurl[0] = U('exchange/getFriendVcard','','',true);
    					$jsurl[1] = U('imora/download','','',true);
    					echo json_encode(array('status'=>8,'data'=>$jsurl));
    					die();
    				}
    			}
    		}else{
    			$ret['msg'] = $this->translator->h5_change_passwd_fail;
    		}
    	}
    	echo json_encode($ret);
    }
    // 取消页面
    public function exitPage(){
    	unset($_SESSION);
    	$this->redirect(U('/appadmin/index','','',true));
    }

}
/* EOF */
