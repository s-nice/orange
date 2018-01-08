<?php
use Classes\GFunc;
/**
 * CardOperator.class.php
 * $Id$
 * $Revision$
 * $Author$
 * $LastChangedDate$
 *
 * @package
 * @version
 * @author Kilin WANG <wangkilin@126.com>
 */
defined('LIB_ROOT_PATH') ? NULL : define('LIB_ROOT_PATH', dirname(dirname(__FILE__)).'/');

require_once LIB_ROOT_PATH . 'Classes/ClassAbstract.class.php';
require_once LIB_ROOT_PATH . 'Classes/GFunc.class.php';
require_once LIB_ROOT_PATH . 'Classes/GFile.class.php';
require_once LIB_ROOT_PATH . '3rdParty/Pear/File_IMC/IMC.php';
require_once LIB_ROOT_PATH . '3rdParty/Pear/File_IMC/IMC/Build.php';
require_once LIB_ROOT_PATH . '3rdParty/Pear/File_IMC/IMC/Parse.php';
require_once LIB_ROOT_PATH . '3rdParty/Pear/File_IMC/IMC/Exception.php';
require_once LIB_ROOT_PATH . '3rdParty/Pear/File_IMC/IMC/Build/Vcard.php';
require_once LIB_ROOT_PATH . '3rdParty/Pear/File_IMC/IMC/Parse/Vcard.php';
require_once LIB_ROOT_PATH . 'Classes/Vcard/VcardBuilder.class.php';
require_once LIB_ROOT_PATH . 'Classes/Vcard/VcardParser.class.php';
require_once LIB_ROOT_PATH . 'Classes/Zip.class.php';

/**
 * @example
 *
$cardOperator = new CardOperator();

$file = 'G:\\Git\\OradtWeb.git\\Public\\temp\\cards\\xxxxx\\xxxxx.vcf';
$tempFile = 'G:\\Git\\OradtWeb.git\\Public\\temp\\cards\\xxxxx\\xxxxx.dat';

// view the card info array
echo '<pre>';
print_r($cardOperator->parseVcardFile($file));
echo '</pre>';

// view the card info array
echo '<pre>';
print_r($cardOperator->parseCardTemplateFile($tempFile));
echo '</pre>';

// view the card info array
echo '<pre>';
print_r($cardOperator->buildVcard('', ''));
echo '</pre>';
 */
class CardOperator extends ClassAbstract
{
    /*
     * 转换数组key成Vcard格式
     * @const int
     */
    CONST CONVERT_KEY_INTO_VCARD = 1;
    /*
     * 转换数组key成常规格式
     * @const int
     */
    CONST CONVERT_KEY_INTO_ARRAY = 2;

    /*
     * 名片存放的路径
     * @var string
     */
    protected $cardStoredInPath = './';
    protected $cardBgurlThumb = false; // 名片背景图暂时不需要缩放图

    protected $terminalEditorSize = array(1200, 720);
    protected $webEditorSize = array(556, 334);

    /*
     * 名片信息数组中， vcard数据格式和常规数据格式的键值映射表
     * @var array
     */
    protected $vcardKeysMap = array (
    	'photo'			=>'PHOTO',
        'name'          => 'FN',
        'nickname'		=> 'NICKNAME',
        'allname'		=> 'NAME',
        'englishname'   => 'ENNAME',
        'company'       => 'ORG',
        'title'         => 'TITLE',
        'mobilephone'   => 'TEL',
        'mobilephone1'  => 'TEL',
        'mobilephone2'  => 'TEL',
        'mobilephone3'  => 'TEL',
        'officephone'   => 'TEL',
        'officephone1'  => 'TEL',
        'officephone2'  => 'TEL',
        'officephone3'  => 'TEL',
        'officephone4'  => 'TEL',
        'mailer'		=> 'MAILER',
        'email'         => 'EMAIL',
        'email1'        => 'EMAIL',
        'email2'        => 'EMAIL',
        'email3'        => 'EMAIL',
        'email4'        => 'EMAIL',
        'email5'        => 'EMAIL',
        'fax'           => 'TEL',
        'fax1'          => 'TEL',
        'fax2'          => 'TEL',
        'fax3'          => 'TEL',
        'fax4'          => 'TEL',
        'fax5'          => 'TEL',
        'fax6'          => 'TEL',
        'address'       => 'ADR',
        'address1'       => 'ADR',
        'address2'       => 'ADR',
        'address3'       => 'ADR',
        'label' 		=> 'LABEL',
        'department'    => 'X-DEPARTMENT',
        'industry'      => 'X-INDUSTRY',
        'web'          => 'URL',
        'web1'          => 'URL',
        'web2'          => 'URL',
        'web3'          => 'URL',
        'qq'            => 'X-QQ',
        'wechat'        => 'X-WECHAT',
        'blog'          => 'X-BLOG',
        'skype'         => 'X-SKYPE',
        'msn'           => 'X-MSN',
        'profile'           => 'PROFILE',
//         'selfdefined1'  => 'X-SELFDEFINED1',
//         'selfdefined2'  => 'X-SELFDEFINED2',
//         'selfdefined3'  => 'X-SELFDEFINED3',
//         'selfdefined4'  => 'X-SELFDEFINED4',
//         'selfdefined5'  => 'X-SELFDEFINED5',
        'clientid'      => 'clientIdKey',
        'carduuid'      => 'cardUuidKey',
        'vcardid'       => 'vcardIdKey',
        'cardtype'      => 'cardTypeKey',
        'class'			=> 'CLASS',
        'cardversion'   => 'X-CARDVERSION',
        'cardstamp'     => 'X-CARDSTAMP',
        'layoutpath'    => 'layoutPathKey',
        'version'       => 'VERSION',
    );

    /*
     * 名片信息数组中， 模板布局数据格式和常规数据格式的键值映射表
    * @var array
    */
    protected $tempKeysMap = array (
    	'photo'			=> 'Photo',
        'name'          => 'Name',
        'nickname'		=> 'NickName',
        'allname'		=> 'AllName',
        'englishname'   => 'EnglishName',
        'company'       => 'Company',
        'title'         => 'Title',
        'mobilephone'   => 'MobilePhone',
        'mobilephone1'  => 'MobilePhone1',
        'mobilephone2'  => 'MobilePhone2',
        'mobilephone3'  => 'MobilePhone3',
        'officephone'   => 'OfficePhone',
        'officephone1'  => 'OfficePhone1',
        'officephone2'  => 'OfficePhone2',
        'officephone3'  => 'OfficePhone3',
        'officephone4'  => 'OfficePhone4',
        'mailer'        => 'Mailer',
        'email'         => 'Email',
        'email1'        => 'Email1',
        'email2'        => 'Email2',
        'email3'        => 'Email3',
        'email4'        => 'Email4',
        'email5'        => 'Email5',
        'fax'           => 'Fax',
        'fax1'          => 'Fax1',
        'fax2'          => 'Fax2',
        'fax3'          => 'Fax3',
        'fax4'          => 'Fax4',
        'fax5'          => 'Fax5',
        'fax6'          => 'Fax6',
        'address'       => 'Address',
        'address1'       => 'Address1',
        'address2'       => 'Address2',
        'address3'       => 'Address3',
        'label'     	=> 'Label',
        'department'    => 'Department',
        'industry'      => 'Industry',
        'web'          => 'Web',
        'web1'          => 'Web1',
        'web2'          => 'Web2',
        'web3'          => 'Web3',
        'qq'            => 'QQ',
        'wechat'        => 'WeChat',
        'blog'          => 'Blog',
        'skype'         => 'SKYPE',
        'msn'           => 'Msn',
        'profile'           => 'PROFILE',
//             'selfdefined1'  => 'self_defined1',
//             'selfdefined2'  => 'self_defined2',
//             'selfdefined3'  => 'self_defined3',
//             'selfdefined4'  => 'self_defined4',
//             'selfdefined5'  => 'self_defined5',
        'cardversion'   => 'CardVersion',
        'cardstamp'     => 'CardStamp',
    );

    protected $uneditableKeys = array ('clientid',
        'carduuid',
        'vcardid',
        'cardtype',
        'class',
        'cardversion',
        'layoutpath',
        'cardstamp',
        'version',
        'fullname',
        'profile',
        'uid',
        'rev',
        'userid',
        'x-carduuid',
        'x-clientid',
        'x-ms-ol-default-postal-address',
        'prodid',
        'sort-string',
        'x-phonetic-last-name',
        'x-phonetic-first-name',
        'x-cardback'
    );

    protected $_selfDefinedLabelMaps = array();

    static protected $_mailIndex = 1;
    static protected $_companyIndex = 1;
    static protected $_addressIndex = 1;
    static protected $_mobileIndex = 1;
    static protected $_officephoneIndex = 1;
    static protected $_faxIndex = 1;
    static protected $_urlIndex = 1;

    /**
     * 构造函数
     * @param unknown $config
     */
    public function __construct($config=array())
    {
        // 设置名片存放的路径
        if (isset($config['cardStoredInPath']) && is_dir($config['cardStoredInPath'])) {
            $this->cardStoredInPath = realpath($config['cardStoredInPath']);
        } else {
            is_dir(C('CARD_STORAGE_PATH')) ? true : mkdir(C('CARD_STORAGE_PATH'), 0777, true);
            $this->cardStoredInPath = C('CARD_STORAGE_PATH');
//            $this->cardStoredInPath = './';
        }
        // 设置名片背景图是否缩放
        if (isset($config['cardBgurlThumb']) && is_bool($config['cardBgurlThumb'])) {
            $this->cardBgurlThumb = $config['cardBgurlThumb'];
        }
    }
    /**
     * 重新赋值参数值
     * @param unknown $config
     */
    public function setConfig($config=array())
    {
        // 设置名片存放的路径
        if (isset($config['cardStoredInPath']) && is_dir($config['cardStoredInPath'])) {
            $this->cardStoredInPath = realpath($config['cardStoredInPath']);
        }
        // 设置名片背景图是否缩放
        if (isset($config['cardBgurlThumb']) && is_bool($config['cardBgurlThumb'])) {
            $this->cardBgurlThumb = $config['cardBgurlThumb'];
        }
        return $this;
    }

    /**
     * 返回label
     * @return $label
     * */
    public  function getLabelKeys()
    {
        foreach($this->vcardKeysMap as $k=>$v){

            $label[] = $k;

        }
        return $label ;

    }


    /**
     * 返回unLabel
     * @return $unLabel
     * */
    public  function getUnLabelKeys()
    {


        return $this->uneditableKeys ;

    }




    /**
     * 解析名片模板内容
     * @param string $templateData 名片模板数据
     * @return array
     */
    public function parseCardTemplate ($templateData)
    {
        // 名片模板数据以 json格式存在
        $templateInfo = json_decode($templateData, true);

        return $templateInfo;
    }

    /**
     * 解析名片模板文件
     * @param string $templateFilePath 名片模板文件路径
     * @return array
     */
    public function parseCardTemplateFile ($templateFilePath)
    {//dump($templateFilePath);
        // 获取模板文件的内容， 然后解析
        $templateData = file_get_contents($templateFilePath);
        $templateInfo = $this->parseCardTemplate($templateData);
//         if (isset($templateInfo['PicControlsEntity'])) {
//             foreach ($templateInfo['PicControlsEntity'] as $_k=>$_v) {
//                 $templateInfo['PicControlsEntity'][$_k]['style'] = $_v['Properties'];
//                 unset($templateInfo['PicControlsEntity'][$_k]['Properties']);
//             }
//         }
//         print_r($templateInfo);

        return $templateInfo;
    }

    /**
     * 解析vcard内容
     * @param string $vcardData Vcard数据内容
     * @param bool $toConvertKey 是否转换索引key
     * @return array
     */
    public function parseVcardText($vcardData, $toConvertKey=true)
    {
        if(strpos($vcardData, 'X-CARDBACK') !== false){ // 如果有反面数据
            $vcard = explode('END:VCARD',$vcardData);
            foreach ($vcard as $v){
                if(trim($v) == '') continue;
                if(strpos($v,'X-CARDBACK') !== false){
                    $back = $this->parseVcardOneText("{$v}END:VCARD", $toConvertKey);
                }else{
                    $vcardData = $this->parseVcardOneText("{$v}END:VCARD", $toConvertKey);
                }
            }
            $vcardData['back'] = $back[0];
        }else{
            $vcardData = $this->parseVcardOneText($vcardData, $toConvertKey);
            $vcardData['back'] = array();
        }
        return $vcardData;
    }
    /**
     * 解析vcard背面内容
     * @param string $vcardData Vcard数据内容
     * @param bool $toConvertKey 是否转换索引key
     * @return array
     */
    protected function parseVcardOneText($vcardData, $toConvertKey){

        $result = array();
        // create vCard parser
        $parse = new VcardParser();

        // parse a vCard file and store the data in $cardinfo
        $vcardData = $parse->fromText($vcardData);
        // 终端合并了自定义字段，以json形式存储
        foreach ($vcardData['VCARD'] as $_k=>$_v) {
            if (! isset($_v['X-SELFDEFINED'], $_v['X-SELFDEFINED'][0]['value'])) {
                continue;
            }
            $_v['X-SELFDEFINED'][0]['value'][0][0] =
                str_replace(array("\r","\n"), '', $_v['X-SELFDEFINED'][0]['value'][0][0]);
            $tmpArray = json_decode($_v['X-SELFDEFINED'][0]['value'][0][0], true);
            unset($vcardData['VCARD'][$_k]['X-SELFDEFINED']); // 释放不用的键值
            foreach ($tmpArray as $_selfDefinedInfo) {
                $_key = $_selfDefinedInfo['key'];
                $_value = $_selfDefinedInfo['value'];
                //  按照vcard解析后的格式， 进行赋值， 生成新的元素
                $vcardData['VCARD'][$_k][$_key] = array (
                    array (
                        'group' => '',
                        'param' =>  array (),
                        'value' => array ( array($_value)),
                        'label' => $_selfDefinedInfo['label']
                    ),
                );
            }
        }

        // 转换数组key名称
        if (true===$toConvertKey && is_array($vcardData) && isset($vcardData['VCARD'])) {
            // vcard 文件可能包含若干名片数据. 循环修改
            foreach ($vcardData['VCARD'] as $_cardInfo) {
                $result[] = $this->convertVcardKeys($_cardInfo, self::CONVERT_KEY_INTO_ARRAY);
            }
            $vcardData = $result;
        }

        return $vcardData;
    }

    /**
     * 解析vcard文件
     * @param string $vcardFilePath Vcard文件路径
     * @param bool $toConvertKey 是否转换索引key
     * @return array
     */
    public function parseVcardFile($vcardFilePath, $toConvertKey=true)
    {
        // 获取vcard文件的内容， 然后解析
        $vcardData = file_get_contents($vcardFilePath);
        $vcardData = $this->parseVcardText($vcardData, $toConvertKey);
        return $vcardData;
    }

    /**
     * 从解析完的vcard数据信息中， 获取单独key对应的值
     * @param array $vcardInfo Vcard解析后的数据对应的单一key的value
     * @return string|array
     */
    static public function getVcardValue($vcardInfo)
    {
        $value = '';
        // 如果不是数组， 或者不存在指定内容， 返回
        if (!is_array($vcardInfo) || !isset($vcardInfo['value'])) {
            return $value;
        }

        // 从数据信息中， 获取对应的值。
        foreach ($vcardInfo['value'] as $_value) {
            if (!is_array($_value)) {
                $value[] = strval($_value);
                continue;
            }

            $_tmpValue = '';
            foreach ($_value as $__value) {
                $_tmpValue .= strval($__value);
            }
            $value[] = $_tmpValue;
        }

        // 数组只有一个元素， 直接返回该元素。 不以数组形式返回
        if (count($value) == 1) {
            $value = $value[0];
        }

        return $value;
    }

    /**
     * 获取格式化后的名字
     * @param array $vcardFNValue Vcard数据中FN对应的value
     * @return string
     */
    static public function getStringFromFN($vcardFNValue)
    {
        return self::getVcardValue($vcardFNValue);
    }

    /**
     * 获取姓名信息
     * @param array $vcardNValue Vcard数据中 N 对应的value
     * @return string|array
     */
    static public function getStringFromN ($vcardNValue)
    {
        return self::getVcardValue($vcardNValue);
    }

    /**
     * 从Vcard数据中的TEL信息，获取对应的电话号码
     * @param array $vcardTELValue Vcard解析数据中TEL信息
     * @return array
     */
    static public function loadInfoFromTEL ($vcardTELValue)
    {
//        print_r($vcardTELValue);die;
        $_telTypes = $vcardTELValue['param']['TYPE'];

        if (in_array('CELL', $_telTypes)) { // 手机信息
            if (isset ( $_telTypes [1] ) && substr ( $_telTypes [1], 0, 5 ) == 'PREF=') {
                $key = 'mobilephone' . substr ( $_telTypes [1], 5 );
            } else {
                $key = 'mobilephone' . self::$_mobileIndex ++;
            }
        } else if (in_array('FAX', $_telTypes)) { // 传真
            if (isset ( $_telTypes [1] ) && substr ( $_telTypes [1], 0, 5 ) == 'PREF=') {
                $key = 'fax' . substr ( $_telTypes [1], 5 );
            } else {
                $key = 'fax' . self::$_faxIndex++;
            }
        } else if (in_array('HOME', $_telTypes)) { // 家庭电话
            if (isset ( $_telTypes [1] ) && substr ( $_telTypes [1], 0, 5 ) == 'PREF=') {
                $key = 'mobilephone' . substr ( $_telTypes [1], 5 );
            } else {
                $key = 'mobilephone' . self::$_mobileIndex ++;
            }
        } else if (in_array('WORK', $_telTypes)) { // 工作电话
            if (isset ( $_telTypes [1] ) && substr ( $_telTypes [1], 0, 5 ) == 'PREF=') {
                $key = 'officephone' . substr ( $_telTypes [1], 5 );
            } else {
                $key = 'officephone' . self::$_officephoneIndex++;
            }
        } else { // 默认为mobile
            if (isset ( $_telTypes [1] ) && substr ( $_telTypes [1], 0, 5 ) == 'PREF=') {
                $key = 'mobilephone' . substr ( $_telTypes [1], 5 );
            } else {
                $key = 'mobilephone' . self::$_mobileIndex ++;
            }
        }

        // 设置是第一个电话
// 	    if (in_array(2, $_telTypes)) {
// 	        $key = $key . '2';
// 	    } else if (in_array(3, $_telTypes)) {
// 	        $key = $key . '3';
// 	    } else {
// 	        $key = $key . '1';
// 	    }

        $phoneNumber = self::getVcardValue ( $vcardTELValue );
        $phoneInfo = array($key => array('value'=>$phoneNumber, 'editable'=>1));

        return $phoneInfo;
    }

    /**
     * 从Vcard数据的EMAIL信息获取邮件数据
     * @param array $vcardEmailValue Vcard数据中email信息
     * @return array
     */
    static public function loadInfoFromEMAIL ($vcardEmailValue)
    {
        $_telTypes = $vcardEmailValue['param']['TYPE'];

        // 设置是第几个邮箱
        if (isset($_telTypes[0]) && is_numeric($_telTypes[0])) {
            $key = 'email' . $_telTypes[0];
        } else {
            $key = 'email' . self::$_mailIndex++;
        }
// 	    if (in_array(2, $_telTypes)) {
// 	        $key = $key . '2';
// 	    } else if (in_array(3, $_telTypes)) {
// 	        $key = $key . '3';
// 	    } else {
// 	        $key = $key . '1';
// 	    }

        $email = self::getVcardValue ( $vcardEmailValue );
        $emailInfo = array($key => array('value'=>$email, 'editable'=>1));

        return $emailInfo;
    }

    /**
     * 从Vcard数据的ORG信息获取公司和部门数据
     * @param array $vcardOrgValue Vcard数据中的ORG信息
     * @return array
     */
    static public function loadInfoFromORG ($vcardOrgValue)
    {
        $company = isset($vcardOrgValue['value'][0]) ? $vcardOrgValue['value'][0] : '';
        $department = isset($vcardOrgValue['value'][1]) ? $vcardOrgValue['value'][1] : '';

        $orgInfo = array('company' => array('value'=>isset($company[0])?$company[0]:'', 'editable'=>1),
            'department'  => array('value'=>isset($department[0])?$department[0]:'', 'editable'=>1)
        );
        return $orgInfo;
        /*以下是设置多个公司时使用*/
        $_telTypes = $vcardOrgValue['param']['TYPE'];

        // 设置是第几个公司
        if (isset($_telTypes[0]) && is_numeric($_telTypes[0])) {
            $key = 'company' . $_telTypes[0];
        } else {
            $key = 'company' . self::$_companyIndex++;
        }

        $company = isset($vcardOrgValue['value'][0]) ? $vcardOrgValue['value'][0] : '';
        $department = isset($vcardOrgValue['value'][1]) ? $vcardOrgValue['value'][1] : '';

        $orgInfo = array($key => array('value'=>$company[0], 'editable'=>1));
        // 部门不为空
        if ($department && ''!=$department[0]) {
            $orgInfo['department'] = array('value'=>$department[0], 'editable'=>1);
        }
        return $orgInfo;
    }

    /**
     * 从Vcard数据的ADR信息获取公司地址
     * @param array $vcardADRValue Vcard数据中的ADR信息
     * @return array
     */
    static public function loadInfoFromADR ($vcardAdrValue)
    {
        $_telTypes = $vcardAdrValue['param']['TYPE'];

        // 设置是第几个地址
        if (isset($_telTypes[0]) && is_numeric($_telTypes[0])) {
            $key = 'address' . $_telTypes[0];
        } else {
            $key = 'address' . self::$_addressIndex++;
        }
        $address = array();
        if(is_array($vcardAdrValue['value'])){
            foreach($vcardAdrValue['value'] as $v){
                $address[] = $v[0];
            }
        }
        $addressv = join('',$address);
        $adrInfo = array($key => array('value'=>$addressv, 'editable'=>1));
        return $adrInfo;
    }
    /**
     * 从Vcard数据的URL信息，获取网址数据
     * @param array $vcardUrlValue Vcard数据中的URL信息
     * @return array
     */
    static public function loadInfoFromURL ($vcardUrlValue)
    {
        $url = isset($vcardUrlValue['value'][0]) ? $vcardUrlValue['value'][0] : '';
        $webInfo = array('web' => array('value'=>$url[0], 'editable'=>1));
        return $webInfo;
        /*以下是多个网址时使用*/
        $_telTypes = $vcardUrlValue['param']['TYPE'];

        // 设置是第一个网址
        if (isset ( $_telTypes [0] ) && is_numeric($_telTypes[0])) {
            $key = 'web' . $_telTypes[0];
        } else {
            $key = 'web' . self::$_urlIndex++;
        }
// 	    if (in_array(2, $_telTypes)) {
// 	        $key = $key . '2';
// 	    } else if (in_array(3, $_telTypes)) {
// 	        $key = $key . '3';
// 	    } else {
// 	        $key = $key . '1';
// 	    }

        $url = self::getVcardValue ( $vcardUrlValue );
        $websiteInfo = array($key => array('value'=>$url, 'editable'=>1));

        return $websiteInfo;
    }

    /**
     * 按照中文地址拼写形式来重新组装中文地址。
     * @param string|array $addr 地址信息
     * @return string|array
     */
    protected function _rebuildAddr ($addr)
    {
        if (is_array($addr)) {
            foreach ($addr as $_addrStr) {
                if(preg_match("/[\x{4e00}-\x{9fa5}]+/u", $_addrStr)) {
                    $addr = array_reverse($addr);
                    break;
                }
            }
        }

        return $addr;
    }

    /**
     * 将Vcard数据中的键值与WEB端识别的键值相互转换
     * @param array $cardInfo 原始的数组信息
     * @param int $conversionDirection 数组转换方向： 从Vcard到web，还是从web到Vcard
     * @return array
     */
    public function convertVcardKeys ($cardInfo, $conversionDirection)
    {
//        print_r($cardInfo);die;
//        array_pop($cardInfo);
        $newCardInfo = array();
        if (self::CONVERT_KEY_INTO_ARRAY === $conversionDirection) {
            foreach ($cardInfo as $key=>$value) {
                switch ($key) {
                    case 'FN': // parse FN data
                        $newCardInfo['name'] = array('value'=>self::getStringFromFN($value[0]), 'editable'=>1);
                        break;
                    case 'NICKNAME': // parse NICKNAME data
                        $newCardInfo['nickname'] = array('value'=>self::getVcardValue($value[0]), 'editable'=>1);
                        break;
                    case 'NAME': // parse NICKNAME data
                        $newCardInfo['allname'] = array('value'=>self::getVcardValue($value[0]), 'editable'=>1);
                        break;
                    //case 'ENNAME': // parse FN data
                    //    $newCardInfo['englishname'] = array('value'=>self::getVcardValue($value[0]), 'editable'=>1);
                    //    break;
                    case 'N': // parse name data
                        $newCardInfo['fullname'] = array('value'=>self::getStringFromN($value[0]), 'editable'=>0);
                        break;
                    case 'ADR': // parse address data
                        if (is_array($value[0]['value']) && !empty($value[0]['value'][5][0])) {
                            $zipcode = $value[0]['value'][5][0];
                            $value[0]['value'][5][0] = '';
                        }
                        $newCardInfo['address'] = array('value'=>self::getVcardValue($value[0]), 'editable'=>1);
                        $newCardInfo['address']['value'] = $this->_rebuildAddr($newCardInfo['address']['value']);
                        $newCardInfo['address']['value'] = is_array($newCardInfo['address']['value'])
                            ? join('', $newCardInfo['address']['value']) : $newCardInfo['address']['value'];
                        if (isset($zipcode)) {
                            $newCardInfo['zipcode'] = array('value'=>$zipcode, 'editable'=>1);
                        }
                        break;
                    case 'LABEL': // parse address data
                        $newCardInfo['label'] = array('value'=>self::getVcardValue($value[0]), 'editable'=>1);
                        $newCardInfo['label']['value'] = is_array($newCardInfo['label']['value'])
                            ? join('', $newCardInfo['label']['value']) : $newCardInfo['label']['value'];
                        break;

                    case 'TITLE': // parse tital data
                        $newCardInfo['title'] = array('value'=>self::getVcardValue($value[0]), 'editable'=>1);
                        break;
                    case 'ORG': // parse company name and department name
//                       print_r($value);die;
                        /*多个公司时使用*/
//                        foreach ($value as $_value) {
//                            $emailInfo = self::loadInfoFromORG($_value);
//                            $newCardInfo = array_merge($newCardInfo, $emailInfo);
//                        }
                        /*单个公司时使用*/
                        $orgInfo = self::loadInfoFromORG ($value[0]);
                        $newCardInfo = array_merge($newCardInfo, $orgInfo);
                        break;
//                    case 'ADR': // parse company address
//                        print_r($value);die;
                    /*多个地址时使用*/
//                        foreach ($value as $_value) {
//                            $emailInfo = self::loadInfoFromADR($_value);
//                            $newCardInfo = array_merge($newCardInfo, $emailInfo);
//                        });
//                        break;
                    case 'MAILER': // parse address data
                        $newCardInfo['mailer'] = array('value'=>self::getVcardValue($value[0]), 'editable'=>1);
                        $newCardInfo['mailer']['value'] = is_array($newCardInfo['mailer']['value'])
                            ? join('', $newCardInfo['mailer']['value']) : $newCardInfo['mailer']['value'];
                        break;
                    case 'TEL': // parse telephone/fax data
                        foreach ($value as $_value) {
                            $phoneInfo = self::loadInfoFromTEL ($_value);
                            $newCardInfo = array_merge($newCardInfo, $phoneInfo);
                        }
//                        return $newCardInfo;
//                        print_r($newCardInfo);
                        break;
                    case 'FAX': // parse telephone/fax data
                        foreach ($value as $_value) {
                            $faxInfo = self::loadInfoFromTEL ($_value);
                            $newCardInfo = array_merge($newCardInfo, $faxInfo);
                        }
//                        break;
                    case 'EMAIL': // parse email data
                        foreach ($value as $_value) {
                            $emailInfo = self::loadInfoFromEMAIL($_value);
                            $newCardInfo = array_merge($newCardInfo, $emailInfo);
                        }
                        break;
                    case 'URL': // parse website data
//                        foreach ($value as $_value) {
//                            $websiteInfo = self::loadInfoFromURL($_value);
//                            $newCardInfo = array_merge($newCardInfo, $websiteInfo);
//                        }
                        $websiteInfo = self::loadInfoFromURL($value[0]);
                        $newCardInfo = array_merge($newCardInfo, $websiteInfo);
                        break;
                    case 'PROFILE':
                        break;
                    case 'X-CARDBACK': //背面数据标示
                        $newCardInfo['x-cardback'] = array('value'=>1, 'editable'=>0);
                        break;
                    default:
//                        echo $key;
                        $find = false;
                        foreach ($this->vcardKeysMap as $_k=>$_v) {
                            if(strtoupper($_v)==strtoupper($key)) {
                                $key = $_k;
                                $find = true;
                                break;
                            }
                        }
                        if (! $find) {
                            $key = strtolower($key);
                        }
                        $newCardInfo[$key] = array('value'=>self::getVcardValue($value[0]), 'editable'=>0);

                        if (isset($value[0]['label'])) {
                            $newCardInfo[$key]['label'] = $value[0]['label'];
                        }
                        if (! in_array($key, $this->uneditableKeys)) {
                            $newCardInfo[$key]['editable'] = 1;
                        }
                        break;
                }
            }

        } else if (self::CONVERT_KEY_INTO_VCARD === $conversionDirection) {
            //print_r($_REQUEST);die;
            $selfDefined = array();
            foreach ($cardInfo as $_key => $_value) {
                $_value = $_value['value'];
                //echo $_value;
                switch (strtolower($_key)) {
                    case 'x-cardback':
                        $newCardInfo['X-CARDBACK'] = $_value;
                        break;
                    case 'name':
                        $newCardInfo['FN'] = $_value;
                        break;
                    case 'fullname':
                        if (! is_array($_value)) {
                            $_value = array($_value);
                        }
                        $newCardInfo['N'] = $_value;
                        break;
                    case 'nickname':
                        $newCardInfo['NICKNAME'] = $_value;
                        break;
                    case 'allname':
                        $newCardInfo['NAME'] = $_value;
                        break;
	                case 'englishname':
	                    $newCardInfo['ENNAME'] = $_value;
	                    break;
                    case 'company':
//                    case 'company2':
//                    case 'company3':
//                        $this->buildCompany($newCardInfo, $_key, $_value);
//                        break;
                        /*单个公司时使用*/
//                        print_r($_value);die;
                        $newCardInfo['ORG'] = isset ($newCardInfo['ORG'])
                            ? $newCardInfo['ORG'] : array( array( 'value'=>array() ) );
                        $newCardInfo['ORG'][0]['value'][0] = $_value;
                        break;
                    case 'department':
                    	$newCardInfo['ORG'] = isset ($newCardInfo['ORG'])
                            ? $newCardInfo['ORG'] : array( array( 'value'=>array() ) );
                        $newCardInfo['ORG'][0]['value'][1] = $_value;
                        break;
                    case 'title':
                        $newCardInfo['TITLE'] = $_value;
                        break;
                    case 'photo':
                    	$newCardInfo['PHOTO'] = $_value;
                    	break;
                    case 'mobilephone1':
                    case 'mobilephone2':
                    case 'mobilephone3':
                    case 'officephone1':
                    case 'officephone2':
                    case 'officephone3':
                    case 'officephone4':
                        $this->buildVcardTel($newCardInfo, $_key, $_value);
                        break;
//                    case 'address1':
//                    case 'address2':
//                    case 'address3':
//                        $this->buildVcardAddress($newCardInfo, $_key, $_value);
//                        break;
//                    case 'fax':
                    case 'fax1':
                    case 'fax2':
                    case 'fax3':
                    case 'fax4':
                    case 'fax5':
                    case 'fax6':
                        $this->buildVcardTel($newCardInfo, $_key, $_value);
//                        $newCardInfo['FAX'] = $_value;
                        break;
                    case 'mailer':
                        if (! is_array($_value)) {
                            $_value = array($_value);
                        }
                        $newCardInfo['MAILER'] = $_value;
                        break;
                    case 'email1':
                    case 'email2':
                    case 'email3':
                    case 'email4':
                    case 'email5':
                        $this->buildVcardMail($newCardInfo, $_key, $_value);
                        break;
                    case 'address':
                        if (! is_array($_value)) {
                            $_value = array($_value);
                        }
                        $newCardInfo['ADR'] = $_value;
                        break;
                    case 'label':
                        if (! is_array($_value)) {
                            $_value = array($_value);
                        }

                        $newCardInfo['LABEL'] = $_value;
                        break;
                    case 'web':
//                    case 'web2':
//                    case 'web3':
                        $newCardInfo['URL'] = $_value;
//                        $this->buildVcardUrl($newCardInfo, $_key, $_value);
                        break;
// 	                case 'selfdefined1':
// 	                case 'selfdefined2':
// 	                case 'selfdefined3':
// 	                case 'selfdefined4':
// 	                case 'selfdefined5':
// 	                    $_key = strtolower($_key);
// 	                    $selfDefined[] = array('value'=>$_value, 'key'=>$this->vcardKeysMap[$_key]);
// 	                    break;
                    case 'industry':
                    case 'qq':
                    case 'wechat':
                    case 'blog':
                    case 'skype':
                    case 'msn':
                    case 'clientid':
                    case 'carduuid':
                    case 'vcardid':
                    case 'cardtype':
                    case 'class':
                    case 'cardversion':
                    case 'cardstamp':
                    case 'layoutpath':
                    default:
                        $_tmpKey = strtolower($_key);
                        if (isset($this->vcardKeysMap[$_tmpKey])) {
                            $_newKey = $this->vcardKeysMap[$_tmpKey];
                            $newCardInfo[$_newKey] = $_value;
                        } else {
                            $_tmpUpperKey = strtoupper($_key);
                            $_selftmpArray = array($_tmpUpperKey=>trim($cardInfo[$_key]['label']));
                            $this->setSelfDefinedLabelMaps($_selftmpArray);
                            $_tmpArray = array('value'=>trim($_value),'key'=>$_tmpUpperKey);
                            if (isset($this->_selfDefinedLabelMaps[$_tmpUpperKey])) {
                                $_tmpArray['label'] = $this->_selfDefinedLabelMaps[$_tmpUpperKey];
                            }
                            $selfDefined[] = $_tmpArray;
                        }
                        break;
                }
                if ($selfDefined) {
                    $newCardInfo['X-SELFDEFINED'] = json_encode($selfDefined, JSON_UNESCAPED_UNICODE);
                }
            } // end foreach
        } else {
            $newCardInfo = $cardInfo;
        }
        return $newCardInfo;
    }

    public function buildVcardTel ( & $newCardInfo, $keyName, $value)
    {
        $newCardInfo['TEL'] = isset ($newCardInfo['TEL'])
            ? $newCardInfo['TEL'] : array();
        $countTel = count ($newCardInfo['TEL']);
        $params = array();
        $_pref = 'PREF='. substr($keyName, -1);
        if (false!==strpos($keyName, 'mobile')) {
            $params['TYPE'] = array('CELL', $_pref);
        } else if (false!==strpos($keyName, 'office')) {
            $params['TYPE'] = array('WORK', $_pref);
        } else if (false!==strpos($keyName, 'fax')) {
            $params['TYPE'] = array('FAX', $_pref);
        }
        //$params['PREF'] = $_pref;
        $newCardInfo['TEL'][$countTel] = array(
            'value' => $value,
            'params' => $params
        );
    }
       
    public function buildVcardMail ( & $newCardInfo, $keyName, $value)
    {
        $newCardInfo['EMAIL'] = isset ($newCardInfo['EMAIL'])
            ? $newCardInfo['EMAIL'] : array();
        $count = count ($newCardInfo['EMAIL']);
        $_pref = substr($keyName, -1);
        $params = array('PREF' => $_pref);
        $newCardInfo['EMAIL'][$count] = array(
            'value' => $value,
            'params' => $params
        );
    }

    public function buildVcardAddress ( & $newCardInfo, $keyName, $value)
    {
        $newCardInfo['ADR'] = isset ($newCardInfo['ADR'])
            ? $newCardInfo['ADR'] : array();
        $count = count ($newCardInfo['ADR']);
        $_pref = substr($keyName, -1);
        $params = array('PREF' => $_pref);
        $newCardInfo['ADR'][$count] = array(
            'value' => is_array($value)?$value:array($value),
            'params' => $params
        );
    }

    public function buildCompany ( & $newCardInfo, $keyName, $value)
    {
        //echo $value;
        $newCardInfo['ORG'] = isset ($newCardInfo['ORG'])
            ? $newCardInfo['ORG'] : array();
        $count = count ($newCardInfo['ORG']);
        $_pref = substr($keyName, -1);
        $params = array('PREF' => $_pref);
        $arr = array('value' => $value, 'params' => $params);
        //print_r($arr);
        array_push($newCardInfo['ORG'],$arr);
        //$newCardInfo['ORG'][$count] = $arr;
//        print_r($newCardInfo);die;
    }
    public function buildVcardUrl ( & $newCardInfo, $keyName, $value)
    {
        $newCardInfo['URL'] = isset ($newCardInfo['URL'])
            ? $newCardInfo['URL'] : array();
        $count = count ($newCardInfo['URL']);
        $_pref = substr($keyName, -1);
        $params = array('PREF' => $_pref);
        $newCardInfo['URL'][$count] = array(
            'value' => $value,
            'params' => $params
        );
    }

    /**
     * 组装Vcard数据
     * @param array $vcardDataInfo 名片信息
     * @param array $vcardBackInfo 名片背面信息
     */
    public function buildVcard($vcardDataInfo,$vcardBackInfo = array())
    {
    	$vcardInfo = $this->buildOneVcard($vcardDataInfo);
        if(!empty($vcardBackInfo)){
            $vcardback = $this->buildOneVcard($vcardBackInfo);
//            $vcardInfo = $vcardInfo."\r\n".$vcardback;
            $vcardInfo = $vcardback;
        }
        return $vcardInfo;
    }
    /**
     * 组装单个Vcard数据
     * @param array $vcardDataInfo 名片信息
     */
    public function buildOneVcard($vcardDataInfo)
    {
//     	$cardInfo = array();
//         foreach ($vcardDataInfo as $_key => $_value) {
//             $cardInfo[$_key] = $_value;
//         } // end foreach
        $vcardDataInfo = $this->convertVcardKeys($vcardDataInfo, self::CONVERT_KEY_INTO_VCARD);
//     	print_r($vcardDataInfo);//exit;
        // instantiate a builder object
        // (defaults to version 3.0)
        $vcard = new VcardBuilder('3.0');
        $_vcardProperties = $vcard->getVcardProperties();
        $defaultPropertyInfo = array('vers' => array('3.0'));
        foreach ($vcardDataInfo as $_vcardKey => $_datas) {
            if ($_vcardKey === 'X-CARDBACK') { //背面标示
                $vcard->set($_vcardKey, $_datas, 'new');
                continue;
            }
        	if ($_vcardKey === 'PHOTO') { //背面标示
                $vcard->set($_vcardKey, $_datas, 'new');
                continue;
            }
            if (!isset($_vcardProperties[$_vcardKey])) {
                $vcard->addVcardProperty($_vcardKey, $defaultPropertyInfo);
            }

            if ((isset($_datas[0]) && is_string($_datas[0])) || (isset($_datas[0]) && !isset($_datas[0]['value']))) {

                //修改ADR 乱码  不确定会不会带来新的问题
                $_datas = array(array('value' => $_datas));
            }
            if (is_array($_datas)) {
                foreach ($_datas as $_data) {
                    $_value = $_data['value'];
                    if ($_value === '') {
                        continue;
                    }
                    $_params = isset($_data['params']) ? $_data['params'] : array();
                    $vcard->set($_vcardKey, $_value, 'new');

                    foreach ($_params as $_paramKey => $_param) {
                        settype($_param, 'array');
                        foreach ($_param as $_tmpParam) {
                            $vcard->addParam($_paramKey, $_tmpParam);
                        }
                    }// end foreach
                }
            }// end foreach
        }
        return $vcard->fetch();
    }
    /**
     * 根据控制器传递过来的名片信息，组装成名片vcard数据和名片模板数据
     * @param array $cardInfo 名片信息内容
     * @return array 包含名片vcard数据和模板数据的数组
     */
    public  function buildCard ($cardInfo)
    {
        $vcardBackInfo = isset($cardInfo['backItem'])?$cardInfo['backItem']:array();
        $vcard = $this->buildVcard($cardInfo['textItem'],$vcardBackInfo); // 构建vcard数据
        $template = $this->buildTemplate($cardInfo); // 构建模板数据
//        return $template;
        $cardData = array('vcard'=>$vcard, 'template'=>$template);

        return $cardData;
    }

    public function buidCardZip2($vcardInfo, $cardInfo, $cardpic, $picList, $cardFolder){
        $filesToZip = array();
        $newcardFolder = $cardFolder;
        $cardFolder = $this->cardStoredInPath . DIRECTORY_SEPARATOR . $cardFolder;

        //GFile::deldir($cardFolder);
        if ($picList) {
            $cardImgFolder = $cardFolder . DIRECTORY_SEPARATOR . 'Images';
            GFile::mkdir($cardImgFolder);
        } else {
            GFile::mkdir($cardFolder);
        }

        $vcardFile = $cardFolder . DIRECTORY_SEPARATOR . $newcardFolder . '.json';
        $vcardFile = str_replace('\\','/',$vcardFile);
        file_put_contents($vcardFile, json_encode($vcardInfo, JSON_UNESCAPED_UNICODE));

        $templateFile = $cardFolder . DIRECTORY_SEPARATOR . $newcardFolder . '.dat';
        $templateFile = str_replace('\\','/',$templateFile);
        file_put_contents($templateFile, json_encode($cardInfo, JSON_UNESCAPED_UNICODE));

        $vcfurl = $newcardFolder .DIRECTORY_SEPARATOR . $newcardFolder . '.json';
        $vcfurl = str_replace('\\','/',$vcfurl);
        $filesToZip[$vcfurl] = $vcardFile;

        $daturl = $newcardFolder .DIRECTORY_SEPARATOR . $newcardFolder . '.dat';
        $daturl = str_replace('\\','/',$daturl);
        $filesToZip[$daturl] = $templateFile;

        foreach ($picList as $_picPath) {
            $picBaseName = basename($_picPath);
            $_newPicPath = $cardImgFolder . '/' . $picBaseName;

            if(strstr($_picPath,"\\")){
                $_picPath =str_replace('\\','/',$_picPath);
            }
            if(strstr($_newPicPath,"\\")){
                $_newPicPath =str_replace('\\','/',$_newPicPath);
            }
            if($_picPath == $_newPicPath){
                $filesToZip[$newcardFolder .'/Images/'. $picBaseName] = $_newPicPath;
            }else{
                if (@copy($_picPath, $_newPicPath)) {
                    $filesToZip[$newcardFolder .'/Images/'. $picBaseName] = $_newPicPath;
                }
            }
        }

        $filesToZip["{$newcardFolder}/{$newcardFolder}-front.png"] = str_replace('\\','/',$cardpic['front']);
        $filesToZip["{$newcardFolder}/{$newcardFolder}-back.png"] = str_replace('\\','/',$cardpic['back']);
        $zipFilePath = $this->cardStoredInPath . DIRECTORY_SEPARATOR . $newcardFolder . '.zip';

        is_file($zipFilePath) && unlink($zipFilePath);
        $zipHanlder = new PhpZip();
        if ($zipHanlder->zip($zipFilePath, $filesToZip)) {
            return array('zip'=>$zipFilePath);
        }
        return null;
    }

    /**
     * 根据名片信息、图片信息和名片ID，生成名片资源包
     * @param array $cardInfo 名片信息
     * @param array $picList 名片中包含的图片信息
     * @param string $cardId 名片ID。 如果不指定，随机生成
     * @return string 生成的名片zip包文件路径
     */
    public function buildCardZip ($cardInfo, $picList=array(),$cardFolder=null, $cardId=null)
    {
        $cardDatas = $this->buildCard($cardInfo); // 组装名片数据
        $filesToZip = array();

//	    if (! $cardId) { // 没有设置名片ID， 随机生成一个   未用到名片id
//	        $cardId = GFunc::createUUID();
//	    }
        if (! $cardFolder) { // 没有设置名片文件夹， 随机生成一个
            $cardFolder = strtolower(\Classes\GFunc::createUUID());
        }
        $cardInfo['templateInfo']['cardFolder'] = $cardFolder;
        $cardInfo['templateInfo']['ID'] = $cardFolder;
        $newcardFolder = $cardFolder;
        // 设置存放名片数据文件的路径
        $cardFolder = $this->cardStoredInPath . DIRECTORY_SEPARATOR . $cardFolder;
        if ($picList) {
            $cardImgFolder = $cardFolder . DIRECTORY_SEPARATOR . 'Images';
            GFile::mkdir($cardImgFolder);
        } else {
            GFile::mkdir($cardFolder);
        }
        // 生成名片数据文件，并打包
        $vcardFile = $cardFolder . DIRECTORY_SEPARATOR . $newcardFolder . '.vcf';
        $templateFile = $cardFolder . DIRECTORY_SEPARATOR . $newcardFolder . '.dat';
        file_put_contents($vcardFile, $cardDatas['vcard']);
        file_put_contents($templateFile, json_encode($cardDatas['template'], JSON_UNESCAPED_UNICODE) );

        $vcfurl = $newcardFolder .DIRECTORY_SEPARATOR . $newcardFolder . '.vcf';
        $vcfurl =str_replace('\\','/',$vcfurl);
        $filesToZip[$vcfurl] = $vcardFile;
        $daturl = $newcardFolder .DIRECTORY_SEPARATOR . $newcardFolder . '.dat';
        $daturl =str_replace('\\','/',$daturl);
        $filesToZip[$daturl] = $templateFile;
        foreach ($picList as $_picPath) {
            $picBaseName = basename($_picPath);
            $_newPicPath = $cardImgFolder . '/' . $picBaseName;

            if(strstr($_picPath,"\\")){
                $_picPath =str_replace('\\','/',$_picPath);
            }
            if(strstr($_newPicPath,"\\")){
                $_newPicPath =str_replace('\\','/',$_newPicPath);
            }
            if($_picPath == $_newPicPath){
                $filesToZip[$newcardFolder .'/Images/'. $picBaseName] = $_newPicPath;
            }else{
                if (@copy($_picPath, $_newPicPath)) {
                    $filesToZip[$newcardFolder .'/Images/'. $picBaseName] = $_newPicPath;
                }
            }
        }
        $this->cardImage($cardInfo,$cardFolder . DIRECTORY_SEPARATOR .$cardInfo['templateInfo']['ID'].'.png');
        $cardpic = $newcardFolder .'/'. $cardInfo['templateInfo']['ID'].'.png';
        $cardpic =str_replace('\\','/',$cardpic);
        $filesToZip[$cardpic] = $cardFolder . DIRECTORY_SEPARATOR .$cardInfo['templateInfo']['ID'].'.png';
        $zipFilePath = $this->cardStoredInPath . DIRECTORY_SEPARATOR . $newcardFolder . '.zip';
        if(file_exists($zipFilePath)){
            unlink($zipFilePath);
        }

        $zipHanlder = new PhpZip();

        if ($zipHanlder->zip($zipFilePath, $filesToZip)) {
            return array('zipurl'=>$zipFilePath,'imgurl'=>$cardFolder . DIRECTORY_SEPARATOR .$cardInfo['templateInfo']['ID'].'.png');
        } else {
            return null;
        }
    }

    /**
     * 根据控制器传递过来的名片信息，生成模板数据
     * @param array $cardInfo 名片信息
     * @return array
     */
    public function buildTemplate (array $cardInfo)
    {
        $templateInfo = array('IMAGE'  => array(),
            'TEMP' => array(),
            'TEXT' => array(),
        );

        $cardInfo['templateInfo']['BGCOLOR'] = \Classes\GFunc::rgb2hex($cardInfo['templateInfo']['BGCOLOR']);
        if (isset($cardInfo['templateInfo']['BGCOLOR'][0]) && '#'!==$cardInfo['templateInfo']['BGCOLOR'][0]) {
            $cardInfo['templateInfo']['BGCOLOR'] = '';
        }
        $templateInfo['IMAGE'] = $this->_buildTemplatePicInfo($cardInfo['picGroup']);
        $templateInfo['TEMP'] = $cardInfo['templateInfo'];
        $templateInfo['TEXT'] = $this->_buildTemplateTextInfo($cardInfo);
        return $templateInfo;
    }

    /**
     * 根据名片信息,生成模板内的文字控制描述内容
     * @param array $cardInfo 名片信息
     * @return array
     */
    protected function _buildTemplateTextInfo ($cardInfo)
    {
        $textInfo = array();
        $i = 0;
        /*循环选项部分  查看是否有自定义的标签没被写入到名片中的  如果有 就保留自定义标签  因为下次还要显示*/
        foreach($cardInfo['textItem'] as $thiskey=>$Itemkey){
            /*这种情况说明是自定义标签  并且没写入到名片中 */
            if((strpos(strtolower($thiskey),'selfdefined') !== false) && $Itemkey['visible']=='false'){
//                return 111111;
                if(!in_array($thiskey,$cardInfo['textGroupStyle'][0]['items'])){
                    $cardInfo['textGroupStyle'][0]['items'][] = $thiskey;
                }
            }
        }
        foreach ($cardInfo['textGroupStyle'] as $_styleInfo) {
            if (isset($_styleInfo['style']['COLOR'])) {
                $_styleInfo['style']['COLOR'] = \Classes\GFunc::rgb2hex($_styleInfo['style']['COLOR']);
            }
            if($_styleInfo['style']['LABEL'] =='true'){
                $_styleInfo['style']['LABEL'] = true;
            }else{
                $_styleInfo['style']['LABEL'] =  false;
            }
            if($_styleInfo['style']['SHADOW'] =='true'){
                $_styleInfo['style']['SHADOW'] = true;
            }else{
                $_styleInfo['style']['SHADOW'] =  false;
            }
            if($_styleInfo['style']['BOLD'] =='true'){
                $_styleInfo['style']['BOLD'] = true;
            }else{
                $_styleInfo['style']['BOLD'] =  false;
            }
            if($_styleInfo['style']['BRONZING'] =='true'){
                $_styleInfo['style']['BRONZING'] = true;
            }else{
                $_styleInfo['style']['BRONZING'] =  false;
            }
//            if($_styleInfo['style']['initial'] =='true'){
//                $_styleInfo['style']['initial'] = true;
//            }else{
//                $_styleInfo['style']['initial'] =  false;
//            }
            $_styleInfo['style']['ID'] =  strtolower(\Classes\GFunc::createUUID());

//            $textInfo[$i] = array('Properties'=>$_styleInfo['style'], 'Values'=>array());
            $textInfo[$i] = $_styleInfo['style'];
            $order = 0;
            foreach ($_styleInfo['items'] as $_textKey) {
                $_tmpTextInfo = array('FIELD'=>strtolower($_textKey));
                $_tmpTextInfo['FIELD'] = isset($this->tempKeysMap[$_tmpTextInfo['FIELD']])
                    ? $this->tempKeysMap[$_tmpTextInfo['FIELD']] : strtoupper($_tmpTextInfo['FIELD']);

                $_tmpTextInfo['LABEL'] = isset($cardInfo['textItem'][$_textKey], $cardInfo['textItem'][$_textKey]['label'])
                    ? $cardInfo['textItem'][$_textKey]['label'] : '';
//	            $_tmpTextInfo['VISIBLE'] = isset($cardInfo['textItem'][$_textKey], $cardInfo['textItem'][$_textKey]['visible'])
//	                                      ? ($cardInfo['textItem'][$_textKey]['visible']==1) : false;
                $_tmpTextInfo['VISIBLE'] = isset($cardInfo['textItem'][$_textKey], $cardInfo['textItem'][$_textKey]['visible'])?$cardInfo['textItem'][$_textKey]['visible']:false;
                if($_tmpTextInfo['VISIBLE'] =='true'){
                    $_tmpTextInfo['VISIBLE'] = true;
                }else{
                    $_tmpTextInfo['VISIBLE'] =  false;
                }

                $_tmpTextInfo['ORADER'] = $order++;

                $textInfo[$i]['VALUES'][] = $_tmpTextInfo;
            } // end foreach
            $i++;
        } // end foreach
//        print_r($textInfo);die;
        return $textInfo;
    }

    /**
     * 根据传递过来的图片信息，生成模板中的图片布局数据
     * @param array $cardPicGroupInfo 图片信息数组
     * @return array
     */
    protected function _buildTemplatePicInfo ($cardPicGroupInfo)
    {
        $picInfo = array();
        $picvalue = array();
        $i = 0;
        foreach ($cardPicGroupInfo as $_picInfo) {
//            print_r($_picInfo);die;
            $picInfo[$i] = $_picInfo['style'];
//            $picInfo[$i] = array('Properties'=>$_picInfo['style'], 'Values'=>array());
//            $picInfo[$i]['Values'] = array();
            $order = 0;
            foreach ($_picInfo['items'] as $_value) {
//                $picInfo[$i]['VISIBLE'] = $_value['visible'];
//                if($picInfo[$i]['VISIBLE'] == 'true'){//确保返回值是布尔值
//                    $picInfo[$i]['VISIBLE'] = true;
//                }else{
//                    $picInfo[$i]['VISIBLE'] = false;
//                }
                $picInfo[$i]['PHOTO'] = $_value['path'];
                $picInfo[$i]['LABEL'] = $_value['LABEL'];
                $picInfo[$i]['ID'] = strtolower(\Classes\GFunc::createUUID());
//                $picInfo[$i]['Values'][] = array('LABEL'   => $_value['label'],
//                    'VISIBLE' => $_value['visible'],
//                    'PHOTO'   => $_value['path']
//                );
            } // end foreach
            /*
             * @todo 终端图片分组里，只有一张图片。 不再支持多张图片
             */
//            $_picInfo[$i] = array_merge($_picInfo[$i],$picInfo[$i]['Values'][0]);
//            $picInfo[$i]['Values'] = $picInfo[$i]['Values'][0];
            $i++;
        }
        return $picInfo;
    }

    protected function _resetStatic ()
    {
        self::$_mailIndex = 1;
        self::$_companyIndex = 1;
        self::$_addressIndex = 1;
        self::$_mobileIndex = 1;
        self::$_officephoneIndex = 1;
        self::$_faxIndex = 1;
        self::$_urlIndex = 1;
    }

    public function parseCard2($zipPath, $layout){
        $imgList = array();
        $zipHandler = new PhpZip();
        GFile::deldir(trim($zipPath, '.zip'));
        $filesList = $zipHandler->unzip($zipPath, $this->cardStoredInPath);

        $cardId = explode('/', $filesList[0])[0];
        $folder = $this->cardStoredInPath.DIRECTORY_SEPARATOR.$cardId;
        $profile = $folder.DIRECTORY_SEPARATOR.$cardId.'.json';
        $profile = json_decode(file_get_contents($profile), true);

        $folderImg = $folder.'-image';
        if (is_dir($folder.DIRECTORY_SEPARATOR.'Images')){
            GFile::copydir($folder.DIRECTORY_SEPARATOR.'Images', $folderImg);
        }

        function _func($key, $lang, $index, $profile){
            //如果是名字，手机号
            if (in_array($key, ['name', 'mobile'])){
                //return $profile[$key][$index];
                for ($i = 0; $i < count($profile[$key]); $i++) {
                    if ($profile[$key][$i]['lang']==$lang){
                        return $profile[$key][$i];
                    }
                }
                return '';
            }

            //如果是自定义标签
            if (strpos($key, "selfdef") === 0){
                return $profile['selfdef'][$key];
            }

            //如果是公司相关数据
            if (in_array($key, ['company_name', 'department', 'job', 'web', 'email', 'fax', 'address', 'telephone'])) {
                //return $profile['company'][$key][$index];
                for ($i = 0; $i < count($profile['company'][0][$key]); $i++) {
                    if ($profile['company'][0][$key][$i]['lang']==$lang){
                        return $profile['company'][0][$key][$i];
                    }
                }
                return '';
            }

            return false;
        }

        foreach ($layout as $key=>$v) {
            foreach ($v as $key1=>$v1) {
                if ($key1 == 'TEMP' && !empty($layout[$key][$key1]['BGURL'])){
                    $url = str_replace("\\", '/', str_replace(substr(WEB_ROOT_DIR, 0, strlen(WEB_ROOT_DIR)-1), '', $folderImg).'/'.$layout[$key][$key1]['BGURL']);
                    $layout[$key][$key1]['BGURL'] = $url;
                    $imgList[] = $url;
                } else if ($key1 == 'IMAGE'){
                    for ($i = 0; $i < count($v1); $i++) {
                        if ($layout[$key][$key1][$i]['TYPE'] == 'icon') {
                            continue;
                        }
                        $url = '/'.str_replace("\\", '/', trim($folderImg, WEB_ROOT_DIR).'/'.$layout[$key][$key1][$i]['PHOTO']);
                        $layout[$key][$key1][$i]['PHOTO'] = $url;
                        $imgList[] = $url;
                    }
                } else if ($key1 == 'TEXT'){
                    for ($i = 0; $i < count($v1); $i++) {
                        $tmp = $v1[$i]['VALUES'][0];
                        $data = _func($tmp['FIELD'], $tmp['LANG'], $tmp['INDEX'], $profile[strtolower($key)]);
                        if ($data){
                            $layout[$key]['TEXT'][$i]['VALUES']['LABEL'] = $data['title'];
                            $layout[$key]['TEXT'][$i]['VALUES']['VALUE'] = $data['value'];
                        }
                    }
                }
            }
        }

        return array('layout'=>$layout, 'imgList'=>$imgList);
    }
    /**
     * 解析名片信息, 返回名片的模板信息，名片中的数据， 名片中数据的样式
     * @param string $vcard Vcard数据内容或者Vcard文件地址
     * @param string $cardInfoZipFilePath 名片格式化压缩包路径
     * @return array 名片信息内容数组
     */
    public function parseCard ($vcard, $cardInfoZipFilePath,$cardtype='EDIT_CARD_SIZE')
    {
        $this->_resetStatic();

        // 将名片格式化压缩包解压
        $templateInfo = $this->parseTempByZip($cardInfoZipFilePath);
//        return $templateInfo;
        // 解析vcard数据
        if (is_file($vcard)) {
            $cardInfo = $this->parseVcardFile($vcard);
        } else {
            $cardInfo = $this->parseVcardText($vcard);
//            print_r($cardInfo);die;
        }
//        print_r($cardInfo);die;
        $cardBackInfo = $cardInfo['back'];
        $cardInfo = $cardInfo[0];

        /* 格式化&组装数据 */
        $textGroup = array();
        $i = 0; $selfDefinedIndex = 1;
//        print_r($templateInfo['TEXT']);die;


        // 解析模板中的文本内容
        foreach (isset($templateInfo['TEXT'])?$templateInfo['TEXT']:array() as $_textInfo) {
            $textvalue = $_textInfo['VALUES'];
            unset($_textInfo['VALUES']);
            $textGroup[$i] = array('style'=>$_textInfo, 'items'=>array()); // 返回的文本组数据
//            $textGroup[$i] = array('style'=>$_textInfo['Properties'], 'items'=>array()); // 返回的文本组数据
//            print_r($_textInfo);die;
            foreach ($textvalue as $_itemInfo) {
                $_key = array_search($_itemInfo['FIELD'], $this->tempKeysMap);
                if(empty($_textInfo['LABEL'])){
                    $_textInfo['LABEL'] = 0;
                }
                $_moreCardInfo = array('label'=>$_itemInfo['LABEL'],  'visible'=>$_itemInfo['VISIBLE'], 'editable'=>true,'startX'=>$_textInfo['MINX'],'startY'=>$_textInfo['MINY'],'hastitle'=>$_textInfo['LABEL']);
                if ($_key===false) {
                    $_key = $_itemInfo['FIELD'];
                }
                $_key = strtolower($_key);
                if (in_array($_key, $this->uneditableKeys)) {
                    $_moreCardInfo['editable'] = false;
                }
                if (!isset($cardInfo[$_key])) {
                    $cardInfo[$_key] = array('value'=>'');
                }
                // 将模板中的数据和vcard中的数据组合
                $_itemInfo['ORADER'] = ($_itemInfo['ORADER']<=0 || isset($textGroup[$i]['items'][$_itemInfo['ORADER']]))
                    ? (count($textGroup[$i]['items'])+1):$_itemInfo['ORADER'];
                $textGroup[$i]['items'][$_itemInfo['ORADER']] = $_key;
                $cardInfo[$_key] = array_merge($cardInfo[$_key], $_moreCardInfo);
            }

            $i++;
        }
        // 解析图片数据
        $picGroup = array();
        $i = 0;
        foreach (isset($templateInfo['IMAGE'])?$templateInfo['IMAGE']:array() as $_picInfo) {
//            print_r($_picInfo);die;
            $picGroup[$i] = array('style'=>$_picInfo, 'items'=>array());
            $picGroup[$i]['items'][] = array('label'   => $_picInfo['LABEL'],
                'visible' => $_picInfo['VISIBLE'],
                //'path'    => $_itemInfo['PHOTO'],
                'path'    => basename($_picInfo['PHOTO'])
            );
//            $picGroup[$i] = array('style'=>$_picInfo['Properties'], 'items'=>array());
            /*
             * @todo 终端图片分组里，只有一张图片。 不再支持多张图片
             */
//            if (isset($_picInfo['Values']['LABEL']) || isset($_picInfo['Values']['PHOTO'])) {
//                $_picInfo['Values'] = array($_picInfo['Values']);
//            }
//            foreach ($_picInfo['Values'] as $_itemInfo) {
//                $picGroup[$i]['items'][] = array('label'   => $_itemInfo['LABEL'],
//                    'visible' => $_itemInfo['VISIBLE'],
//                    //'path'    => $_itemInfo['PHOTO'],
//                    'path'    => basename($_itemInfo['PHOTO'])
//                );
//            }

            $i++;
        }

        $templateInfo['TEMP']['cardFolder'] = $templateInfo['cardFolder'];
        $templateInfo['TEMP']['BGURL'] = isset($templateInfo['TEMP']['BGURL'])?basename($templateInfo['TEMP']['BGURL']):''; // 终端图片路径转换

        /* 判断是否需要缩略图 */
        if($this->cardBgurlThumb && $templateInfo['TEMP']['BGURL'] != ''){
            $picurl = $this->makeThumbImg(WEB_ROOT_DIR . 'temp/cards/' . $templateInfo['TEMP']['cardFolder'] . '/Images/'.$templateInfo['TEMP']['BGURL'],'','background',$cardtype, WEB_ROOT_DIR . 'temp/cards/' . $templateInfo['TEMP']['cardFolder'] . '/Images/');
//	    	$templateInfo['TEMP']['BGURL'] = 's-' . $templateInfo['TEMP']['BGURL'];
            if('SHOW_CARD_SIZE' == $cardtype){
                $templateInfo['TEMP']['BGURL'] = 'show-' . $picurl;
            }else if('EDIT_SELF_CARD' == $cardtype){
                $templateInfo['TEMP']['BGURL'] = 'p-' . $picurl;
            }else{
                $templateInfo['TEMP']['BGURL'] = 's-' . $picurl;
            }

        }

        // 组装返回数据
        $result = array('templateInfo'   => $templateInfo['TEMP'], // 模板信息
            'textGroupStyle' => $textGroup, // 文本分组信息和样式
            'textItem'       => $cardInfo,  // 文本内容
            'picGroup'       => $picGroup,	// 图片信息
            'backItem'		=> $cardBackInfo // 名片背面数据
        );

        return $result;
    }

    /**
     * 解析模板zip文件
     * @param string $TempZipFilePath 名片模板压缩包路径
     * @return array 模板信息内容数组
     */
    public function parseTempByZip ($TempZipFilePath)
    {
        // 将名片模板压缩包解压
        $zipHandler = new PhpZip();
        $filesList = $zipHandler->unzip($TempZipFilePath, $this->cardStoredInPath);
//        return $filesList;
		if(is_array($filesList)){
			sort($filesList);

	        // 解析名片模板数据
	        foreach ($filesList as $_filePath) {
	            if(substr($_filePath, -4)=='.dat') {
	                $templateFile = realpath($this->cardStoredInPath) . DIRECTORY_SEPARATOR . $_filePath;
	                break;
	            }
	        }
        	$templateInfo = $this->parseCardTemplateFile($templateFile);
		}else{
			$templateInfo = array();
		}
        $cardFolder = explode('/', $filesList[0], 2);
        $templateInfo['cardFolder'] = $cardFolder[0];

        return $templateInfo;
    }

    /*制作缩略图*/
    protected function makeThumbImg($path, $filename, $pictype,$cardtype,$savepath)
    {
    	\Classes\GFunc::createThumbPic($path, $filename,$pictype,$cardtype,$savepath);
//        $filename = explode('.',$filename);
//        if($filename[1]=='JPEG'){
//            $filename[1]='jpg';
//        }
//        $filename[1] = strtolower($filename[1]);
//        $filename = 'background.'.$filename[1];
        $filename = 'background.png';
        return $filename;
    }

	/**
	 * 名片生成预览图片
	 * @param array $cardInfo 名片数据信息
	 * @param string $savename 生成名片图片的路径
	 * @param boolean $re 是否展示名片图片 默认展示
	 */

    public function cardImage($cardInfo=array(),$savename,$re=true)
    {
        if(empty($cardInfo)){
            $cardInfo['vcf'] = file_get_contents(WEB_ROOT_DIR . C('TEMPLATE_VCF_URL'));
//            $cardInfo['cardZipPath'] = WEB_ROOT_DIR . 'temp/cards/test.zip';
            $cardInfo['cardZipPath'] = WEB_ROOT_DIR . C('TEMPLATE_ZIP_URL');
        }
//        print_r($cardInfo);die;
//        $savename = 'temp/upload';
//        $cardInfo = array (
//            'templateInfo' =>
//                array (
//                    'BGType' => '3',
//                    'BGCOLOR' => 'rgb(255, 255, 255)',
//                    'BGURL' => 'background.png',
//                    'ID' => 'C895B539-89C5-4DAF-BD3A-B495907E1DC1',
//                    'Description' => '',
//                    'TemplateOritation' => '1',
//                    'cardFolder' => 'C895B539-89C5-4DAF-BD3A-B495907E1DC1',
//                ),
//            'textGroupStyle' =>
//                array (
//                    0 =>
//                        array (
//                            'style' =>
//                                array (
//                                    'MINY' => '831',
//                                    'MINX' => '726',
//                                    'COLOR' => 'rgb(0, 0, 0)',
//                                    'SIZE' => '39',
//                                    'BOLD' => 'false',
//                                    'ALIGN' => 'left',
//                                    'FONT' => '方正楷体',
//                                    'SHADOW' => 'false',
//                                    'LABEL' => 'false',
//                                ),
//                            'items' =>
//                                array (
//                                    0 => 'name',
//                                ),
//                        ),
//                    1 =>
//                        array (
//                            'style' =>
//                                array (
//                                    'MINY' => '716',
//                                    'MINX' => '595',
//                                    'COLOR' => 'rgb(0, 0, 0)',
//                                    'SIZE' => '39',
//                                    'BOLD' => 'false',
//                                    'ALIGN' => 'left',
//                                    'FONT' => '方正楷体',
//                                    'SHADOW' => 'false',
//                                    'LABEL' => 'false',
//                                ),
//                            'items' =>
//                                array (
//                                    0 => 'company',
//                                ),
//                        ),
//                    2 =>
//                        array (
//                            'style' =>
//                                array (
//                                    'MINY' => '696',
//                                    'MINX' => '337',
//                                    'COLOR' => 'rgb(0, 0, 0)',
//                                    'SIZE' => '39',
//                                    'BOLD' => 'false',
//                                    'ALIGN' => 'left',
//                                    'FONT' => '方正楷体',
//                                    'SHADOW' => 'false',
//                                    'LABEL' => 'false',
//                                ),
//                            'items' =>
//                                array (
//                                    0 => 'address',
//                                ),
//                        ),
//                    3 =>
//                        array (
//                            'style' =>
//                                array (
//                                    'MINY' => '700',
//                                    'MINX' => '487',
//                                    'COLOR' => 'rgb(0, 0, 0)',
//                                    'SIZE' => '39',
//                                    'BOLD' => 'false',
//                                    'ALIGN' => 'left',
//                                    'FONT' => '方正楷体',
//                                    'SHADOW' => 'false',
//                                    'LABEL' => 'false',
//                                ),
//                            'items' =>
//                                array (
//                                    0 => 'department',
//                                ),
//                        ),
//                ),
//            'textItem' =>
//                array (
//                    'name' =>
//                        array (
//                            'value' => '你好',
//                            'visible' => 'true',
//                            'label' => '中文名字',
//                        ),
//                    'address' =>
//                        array (
//                            'value' => '做下自我介绍吧',
//                            'visible' => 'true',
//                            'label' => '公司地址',
//                        ),
//                    'company' =>
//                        array (
//                            'value' => '你叫什么名字',
//                            'visible' => 'true',
//                            'label' => '公司名称',
//                        ),
//                    'department' =>
//                        array (
//                            'value' => '介绍详细点哈哈',
//                            'visible' => 'true',
//                            'label' => '部门',
//                        ),
//                    'englishname' =>
//                        array (
//                            'value' => '',
//                            'visible' => 'false',
//                            'label' => '英文名字',
//                        ),
//                    'title' =>
//                        array (
//                            'value' => '',
//                            'visible' => 'false',
//                            'label' => '职位',
//                        ),
//                    'mobilephone1' =>
//                        array (
//                            'value' => '',
//                            'visible' => 'false',
//                            'label' => '手机号码',
//                        ),
//                    'officephone1' =>
//                        array (
//                            'value' => '',
//                            'visible' => 'false',
//                            'label' => '电话',
//                        ),
//                    'email1' =>
//                        array (
//                            'value' => '',
//                            'visible' => 'false',
//                            'label' => '电子邮箱',
//                        ),
//                    'fax1' =>
//                        array (
//                            'value' => '',
//                            'visible' => 'false',
//                            'label' => '传真',
//                        ),
//                    'industry' =>
//                        array (
//                            'value' => '',
//                            'visible' => 'false',
//                            'label' => '行业',
//                        ),
//                    'web1' =>
//                        array (
//                            'value' => '',
//                            'visible' => 'false',
//                            'label' => '网址',
//                        ),
//                    'qq' =>
//                        array (
//                            'value' => '',
//                            'visible' => 'false',
//                            'label' => 'QQ',
//                        ),
//                    'wechat' =>
//                        array (
//                            'value' => '',
//                            'visible' => 'false',
//                            'label' => '微信',
//                        ),
//                    'blog' =>
//                        array (
//                            'value' => '',
//                            'visible' => 'false',
//                            'label' => '微博',
//                        ),
//                    'skype' =>
//                        array (
//                            'value' => '',
//                            'visible' => 'false',
//                            'label' => 'Skype',
//                        ),
//                    'msn' =>
//                        array (
//                            'value' => '',
//                            'visible' => 'false',
//                            'label' => 'msn',
//                        ),
//                    'version' =>
//                        array (
//                            'value' => '3.0',
//                        ),
//                    'fullname' =>
//                        array (
//                            'value' =>
//                                array (
//                                    0 => 'xuelizhu',
//                                ),
//                        ),
//                ),
//            'picGroup' =>
//                array (
//                    0 =>
//                        array (
//                            'style' =>
//                                array (
//                                    'opacity' => '1',
//                                    'zindex' => '10',
//                                    'boxshadow' => 'false',
//                                    'HEIGHT' => '281',
//                                    'WIDTH' => '281',
//                                    'MINX' => '379',
//                                    'MINY' => '981',
//                                ),
//                            'items' =>
//                                array (
//                                    0 =>
//                                        array (
//                                            'path' => 'g-QWxBaU80WnYxdDZiS1dnSThxWXRwWDZIa0gyUWYwMDAwMDAwMDAwNC84YzFPOHVKN0cwMjAxNTAxMTMxNDUzNTEucG5n.png',
//                                            'label' => 'logo',
//                                            'visible' => 'true',
//                                        ),
//                                ),
//                        ),
//                ),
//        );
//        $cardInfo = array();
        // 指定vcard和名片模板资源
        // 设置字体绑定

        // load the global language strings
        $uiLang = \Classes\GFunc::getUiLang();
        $translator = \Classes\Factory::getTranslator(APP_PATH . 'Lang/'. $uiLang . '/CardEditor.ini', 'ini');
        $fontMaps = array (
            /*Simplified Chinese文件夹下的*/
            /*Simplified Chinese文件夹下的*/
            $translator->form_font_fangsong         => 'CFangSongPRC-Light.ttf',
            $translator->form_font_mkaim         => 'MKaiM18030_C.ttf',
            $translator->form_font_msungm         => 'MSungM18030_C.ttf',
            $translator->form_font_myingheibold         => 'MYingHeiBold18030C.ttf',
            $translator->form_font_myuensemibd         => 'MYuenSemiBd18030C.ttf',
            /*Traditional  Chinese文件夹下的*/
            $translator->form_font_cfangsonghk         => 'CFangSongHK-Light.ttf',
            $translator->form_font_csongbig         => 'CSong-Big5HK-Light_C.ttf',
            $translator->form_font_mkaicmedium         => 'MKaiC-Medium-Big5HKSCS.ttf',
            $translator->form_font_myingheicboldbig         => 'MYingHeiC-Bold-Big5HKSCS.ttf',
            $translator->form_font_myuensemibold         => 'MYuenC-SemiBold-Big5HKSCS.ttf',
            /*Traditional  Chinese文件夹下的*/
            $translator->form_font_ahmedltregular         => 'AhmedLTRegular.ttf',
            $translator->form_font_badiyaltregular         => 'BadiyaLT-Regular.ttf',
            $translator->form_font_dinnextltarabic         => 'DINNextLTArabic-Regular.ttf',
            $translator->form_font_firas         => 'Firas.ttf',
            $translator->form_font_frutigerltarabic         => 'FrutigerLTArabic-55Roman.ttf',
            $translator->form_font_midan         => 'Midan.ttf',
            $translator->form_font_universnextarabic         => 'UniversNextArabic-Regular.ttf',
            //HelveticaWorld文件夹
            $translator->form_font_helveticaworld         => 'HelveticaWorld-Regular.ttf',
            /*Korean文件夹下*/
            $translator->form_font_crecooljazzb         => 'CreCoolJazzB.ttf',
            $translator->form_font_cregothicm         => 'CreGothicM.ttf',
            $translator->form_font_crehappinessb         => 'CreHappinessB.ttf',
            $translator->form_font_cremyungjom         => 'CreMyungjoM.ttf',
            $translator->form_font_dcmasseb         => 'DSMassEB.ttf',
            $translator->form_font_dsromanticguyb         => 'DSRomanticGuyB.ttf',
            $translator->form_font_fbnewgothicb         => 'FBNewGothicB.ttf',
            $translator->form_font_fbnewgothicl         => 'FBNewGothicL.ttf',
            $translator->form_font_fbnewgothicm         => 'FBNewGothicM.ttf',
            $translator->form_font_fbnewgothicsb         => 'FBNewGothicSB.ttf',
            $translator->form_font_fbnewmiungjob         => 'FBNewMiungJoB.ttf',
            $translator->form_font_fbnewmiungjol         => 'FBNewMiungJoL.ttf',
            $translator->form_font_fbnewmiungjom         => 'FBNewMiungJoM.ttf',
            $translator->form_font_ydgothic530         => 'YDGothic530.ttf',
            $translator->form_font_ydmyungjo540         => 'YDMyungjo540.ttf',
            /*Latin文件夹下*/
            $translator->form_font_am263         => 'AM263___.ttf',
            $translator->form_font_ari         => 'ari_____.ttf',
            $translator->form_font_avenirnextltpro         => 'AvenirNextLTPro-Regular.ttf',
            $translator->form_font_dinnextltpro         => 'DINNextLTPro-Regular.ttf',
            $translator->form_font_frutigerltcom         => 'FrutigerLTCom-Roman.ttf',
            $translator->form_font_gil         => 'gil_____.ttf',
            $translator->form_font_lte50138         => 'lte50138.ttf',
            $translator->form_font_lte50152         => 'lte50152.ttf',
            $translator->form_font_lte50259         => 'LTe50259.ttf',
            $translator->form_font_lte50338         => 'LTe50338.ttf',
            $translator->form_font_lte50535         => 'LTe50535.ttf',
            $translator->form_font_lte51250         => 'lte51250.ttf',
            $translator->form_font_proximanova         => 'ProximaNova-Reg.ttf',
            /*thai文件夹下*/
            $translator->form_font_angsa         => 'angsa.ttf',
            $translator->form_font_anuparpltthai         => 'AnuParpLTThai.ttf',
            $translator->form_font_lt53900         => 'LT_53900.ttf',
            $translator->form_font_neuefrutigerthaimodern         => 'NeueFrutigerThaiModern-Rg.ttf',
            $translator->form_font_sirichanaltregular         => 'SirichanaLT-Regular.ttf',
            $translator->form_font_sukothailtregular         => 'SukothaiLT-Regular.ttf',
            $translator->form_font_tt7047m         => 'tt7047m_.ttf',
            /*Japanese文件夹下*/
            $translator->form_font_iwaggopro         => 'iwaggopro-md.ttf',
            $translator->form_font_iwagrgopro         => 'iwagrgopro-md.ttf',
            $translator->form_font_iwagtxtpro         => 'iwagtxtpro-bd.ttf',
            $translator->form_font_iwaminpr6n         => 'iwaminpr6n-md.ttf',
            $translator->form_font_iwaudgodppro         => 'iwaudgodppro-md.ttf',
            $translator->form_font_nudmotoyaaporostd         => 'nudmotoyaaporostd-w4',
            $translator->form_font_nudmotoyacedarstd         => 'nudmotoyacedarstd-w3',


//            $translator->FORM_FONTREGULAR         => 'FZKTJW.TTF',
//            $translator->FORM_FONTCIRCULAR => 'FZLanTYJW_Zhun.TTF',
//            $translator->FORM_FONTBLACKFLAT  => 'FZLTHBJW.TTF',
//            $translator->FORM_FONTPERMITBLACK  => 'FZLTZHUNHJW.TTF',
//            $translator->FORM_FONTELEGANTSONG    => 'FZTYSJW.TTF',
//            $translator->FORM_FONTCORAL    => 'FZXSHJW.TTF',
//            $translator->FORM_FONTFINEROUND     => 'FZY1JW.TTF',
//            $translator->FORM_FONTYANSONG     => 'FZYanSJW.TTF',
//            $translator->FORM_FONTCURSIVE => 'FZZJ-HJYBXCJW.ttf'
        );
        // 字体存放路径
        $fontDirPath = WEB_ROOT_DIR . 'newfonts/';
        if(isset($cardInfo['templateInfo']['TEMPORI']) && $cardInfo['templateInfo']['TEMPORI']=='1'){
            $cardImage = new CardImage($toWidth=334, $toHeight=556, $fromWidth=720, $fromHeight=1200);
        }else{
            $cardImage = new CardImage();
        }
        $cardImage->setCardInfo($cardInfo)     // 指定名片信息
        ->setFontDir($fontDirPath)   // 设置字体路径
        ->setFontMaps($fontMaps)     // 设置字体映射关系
        ;
        error_reporting(E_ALL);
        $cardImage->printCardImage($savename,$re);          // 输出图片到浏览器
    }

    /**
     *
     * @param array $labelsInfo
     * @return CardOperator
     */
    public function setSelfDefinedLabelMaps (array $labelsInfo)
    {
        settype($labelsInfo, 'array');
        $this->_selfDefinedLabelMaps = $labelsInfo;

        return $this;
    }
}

/* @example 调用实例
$cardFolder = dirname(__FILE__) . '/../../Public/temp/cards'; // 设置名片压缩包解压路径
$cardOperator = new CardOperator(array('cardStoredInPath'=>$cardFolder));

$file = $cardFolder . '\\sampleVcard.vcf';
$tempFile = $cardFolder . '\\yyyyy\\template.dat';

$tempZipFile = $cardFolder . '\\cardUuid.zip';

//include($cardFolder. '/yyyyy/layoutArray.php');
//file_put_contents($cardFolder . '/yyyyy/template.dat', json_encode($layoutArray));
//exit;
// view the card info array
$cardInfo = ($cardOperator->parseVcardFile($file)); // 从vcard文件解析
$cardInfo1 = ($cardOperator->parseVcardFile($file, false)); // 从vcard文件解析
print_r($cardOperator->buildVcard($cardInfo[0])); // 创建vcard
print_r($cardInfo1);exit;

// view the card info array
//var_export($cardOperator->parseCardTemplateFile($tempFile)); // 解析模板文件

// view the card info array
//print_r($cardOperator->buildVcard('', '')); // 创建vcard

// view the card info array
$cardInfo = $cardOperator->parseCard($file, $tempZipFile);
//var_export($cardInfo); // 解析名片
$picList = array('G:/Git/OradtWeb.git/Public/temp/cards/myCardId/Images/background.png','G:/Git/OradtWeb.git/Public/temp/cards/myCardId/Images/PHOTO.png');
$newCardInfo = $cardOperator->buildCard($cardInfo, $picList);
//var_export($newCardInfo);
echo $cardOperator->buildCardZip($cardInfo, $picList);
//*/