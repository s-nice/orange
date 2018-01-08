<?php
namespace Demo\Controller;
use BaseController\BaseController;
use Classes;

class DevTestController extends BaseController
{
    public function _initialize()
    {

    }
    /**
     * 带Logo的二维码 (保存名片信息到通讯录)
     * @noLink
     */
    public function qrCodeWithLogo ()
    {
        import('GFunc', LIB_ROOT_PATH . 'Classes/');
        //print_r(get_declared_classes());
        //exit;
        $logoPath = WEB_ROOT_DIR . 'images/logo_h5.png';
        $qrText = "BEGIN:VCARD
VERSION:4.0
FN:鑫小橙
PROFILE:VCARD
ADR:北京市朝阳区地球村一号院2号楼;;;;;;
TEL;TYPE=CELL,PREF=1:15011203916
TEL;TYPE=CELL,PREF=2:15011203917
TEL;TYPE=WORK,PREF=1:电话\:818-691-2800
EMAIL;PREF=1:admin@oradt.com
TITLE:职位
ORG:北京橙鑫数据科技有限公司;部门
URL:网址\:www.oranamer.com
X-ENGLISHNAME:Oranamer
N:鑫小橙;;;;
END:VCARD";
        $matrixPointSize=3;
        $margin=1;
        $savePath = null;
        //$savePath=TEMP_PATH . GFunc::createUUID() . '.png';
        \Classes\GFunc::qrCodeWithLogo ($logoPath, $qrText, $matrixPointSize, $margin, $savePath);
    }
    
    /**
     * 保存多张名片信息到手机通讯录
     */
    public function saveVcardMany(){
    	import('GFunc', LIB_ROOT_PATH . 'Classes/');
    	//print_r(get_declared_classes());
    	//exit;
    	$logoPath = WEB_ROOT_DIR . 'images/logo_h5.png';
    	$qrText = "BEGIN:VCARD
VERSION:3.0
FN:常颖
PROFILE:VCARD
ADR:中国北京东城区建国门内大街a号中粮广场B座1405室;;;;;;
TEL;TYPE=CELL,PREF=1:13810828904
TEL;TYPE=FAX,PREF=1:01065263980
TEL;TYPE=WORK,PREF=1:01085001096
EMAIL:chang-ying@cofco.com
TITLE:写字楼租务部经理
ORG:北京中粮广场发展有限公司;Office Leasing Department
URL:http\://www.cofco.com
N:常颖;;;;
END:VCARD
BEGIN:VCARD
VERSION:3.0
FN:Irl VJ
PROFILE:VCARD
ORG:RSTSA
N:Irl VJ;;;;
END:VCARD
BEGIN:VCARD
VERSION:4.0
FN:鑫小橙
PROFILE:VCARD
ADR:北京市朝阳区地球村一号院2号楼;;;;;;
TEL;TYPE=CELL,PREF=1:15011203916
TEL;TYPE=CELL,PREF=2:15011203917
TEL;TYPE=WORK,PREF=1:电话\:818-691-2800
EMAIL;PREF=1:admin@oradt.com
TITLE:职位
ORG:北京橙鑫数据科技有限公司;部门
URL:网址\:www.oranamer.com
X-ENGLISHNAME:Oranamer
N:鑫小橙;;;;
END:VCARD";
    	$matrixPointSize=3;
    	$margin=1;
    	$savePath = null;
    	//$savePath=TEMP_PATH . GFunc::createUUID() . '.png';
    	\Classes\GFunc::qrCodeWithLogo ($logoPath, $qrText, $matrixPointSize, $margin, $savePath);
    }
    
    public function redis(){
    	$redisObj = Classes\CacheRedis::getRedis();
    	//$redisObj->set('name','c');
    	//echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',var_dump($redisObj->get('name'));exit;
    	
    	$key = 't1';
    	$redisObj->lPush($key,'a');
    	$redisObj->lPush($key,'b');
    	echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',var_dump($redisObj->lrange($key,0,-1));exit;
    	
    }
    
    public function getKeys(){
    	$redisObj = Classes\CacheRedis::getRedis();
    	$keys = $redisObj->getKeys('*');
    	echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',var_dump($keys);
    	//echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',var_dump($redisObj->lPop('wx_api'));
    }
    
    public function getValByKey(){
    	$key = I('k');
    	$func = I('func','getKey');
    	$redisObj = Classes\CacheRedis::getRedis();
    	$keys = $redisObj->$func($key);
    	echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',var_dump($keys);exit;
    }
    
    public function getWxToken(){
    	$rstToken = Classes\GFunc::getCustomMessageToken(C('Wechat')['AppID'], C('Wechat')['AppSecret'],7200,false);
    	echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',print_r($rstToken,1);exit;
    }
    public function getWxTokenRedis(){
    	$rstToken = Classes\GFunc::getCustomMessageTokenFromRedis(C('Wechat')['AppID'], C('Wechat')['AppSecret'],7200,false);
    	echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',print_r($rstToken,1);exit;
    }
}

/* EOF */
