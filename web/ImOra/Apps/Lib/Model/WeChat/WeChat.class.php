<?php
namespace Model\Wechat;
use Model\WebService;
class Wechat extends WebService
{
    /**
     * 保存图片
     * @param arr $params
     * @return arr
     */
    public function wechatSave($params=array()){
        // 设置请求方法为 新建
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/common/wechat/wechatsave';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $this->setUploadFile($params['picture'], 'picture');
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);

        return parseApi($response);
    }
    public function wechatSave2($params=array()){
    	// 设置请求方法为 新建
    	$webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/common/wechat/wechatsave2';
    	$crudMethod = parent::OC_HTTP_CRUD_C;
    	$this->setUploadFile($params['picpatha'], 'picpatha');
    	$params['picpathb'] && $this->setUploadFile($params['picpathb'], 'picpathb');
    	$response = $this->request($webServiceRootUrl, $crudMethod, $params);
    
    	return parseApi($response);
    }
    /**
     * 获取名片列表
     * @param unknown $params
     * @return Ambigous <multitype:, multitype:string Ambigous <NULL, multitype:> Ambigous <number, NULL, int, unknown> >
     */
    public function getWechatCard($params=array()){
//    	!isset($params['fileds']) && $params['fileds'] = 'cardid,wchatid,uuid,picture,picpatha,picpathb,vcard';
        // 设置请求方法为 新建
        $webServiceRootUrl = C('API_WX_GET_VCARD_LIST');
        $crudMethod = parent::OC_HTTP_CRUD_R;
//        $params['status'] = 1;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
    /**
     * 根据批次号获取个人名片列表
     * @param unknown $params
     * @return Ambigous <multitype:, multitype:string Ambigous <NULL, multitype:> Ambigous <number, NULL, int, unknown> >
     */
    public function getWechatCardByBatch($params=array()){
    	//    	!isset($params['fileds']) && $params['fileds'] = 'cardid,wchatid,uuid,picture,picpatha,picpathb,vcard';
    	// 设置请求方法为 新建
    	$webServiceRootUrl = C('API_WX_GET_BATCH_VCARD_LIST');
    	$crudMethod = parent::OC_HTTP_CRUD_R;
    	//        $params['status'] = 1;
    	$response = $this->request($webServiceRootUrl, $crudMethod, $params);
    	return parseApi($response);
    }
    /**
     * 获取企业名片列表
     * @param unknown $params
     * @return Ambigous <multitype:, multitype:string Ambigous <NULL, multitype:> Ambigous <number, NULL, int, unknown> >
     */
    public function getBizCardList($params=array()){
//        !isset($params['fileds']) && $params['fileds'] = 'cardid,wchatid,uuid,picture,picpatha,picpathb,vcard';
        // 设置请求方法为 新建
        $webServiceRootUrl = C('API_WX_GET_BIZCARD_LIST');
        $crudMethod = parent::OC_HTTP_CRUD_R;
//        $params['status'] = 1;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
    /**
     * 获取企业名片数量
     */
    public function getBizCardCount($params=array()){
        $webServiceRootUrl = C('API_WX_GET_BIZCARD_COUNT');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
    /**
     * 获取企业名片信息
     */
    public function getBizCardInfo($params=array())
    {
        $webServiceRootUrl = C('API_WX_GET_BIZCARD_INFO');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
    /**
     * 获取任意扫描的资源信息
     * @param unknown $params
     * @return Ambigous <multitype:, multitype:string Ambigous <NULL, multitype:> Ambigous <number, NULL, unknown, int> >
     */
    public function getWechatResourceAll($params=array()){
    	//!isset($params['fileds']) && $params['fileds'] = 'cardid,wchatid,picture,picpatha,picpathb,vcard';
    	// 设置请求方法为 新建
    	$webServiceRootUrl = C('API_WX_GET_ANY_SWEEP');
    	$crudMethod = parent::OC_HTTP_CRUD_R;
    	$response = $this->request($webServiceRootUrl, $crudMethod, $params);
    	return parseApi($response);
    }

    /**
     * 获取公司详情
     */
    public function getCompanyInfo($params)
    {
    	// 设置请求方法为 新建
    	$webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/accountbiz/apistore/customer';
    	$crudMethod = parent::OC_HTTP_CRUD_R;
    	$response = $this->request($webServiceRootUrl, $crudMethod, $params);
    	return parseApi($response);
    }
    
    /**
     * 删除名片
     */
    public function wxDelCard($params)
    {
    	// 设置请求方法为 新建
    	$webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/common/wechat/deletecard';
    	$crudMethod = parent::OC_HTTP_CRUD_C;
    	$response = $this->request($webServiceRootUrl, $crudMethod, $params);
    	return parseApi($response);
    }

    /**
     * 名片修改
     */
    public function editCardDetail($params){
        //设置请求方法为修改
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/common/wechat/wechatmodify';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
    
    //保存用户的基本信息到数据库中（绑定用户信息）
    public function bindWxUserInfo($params)
    {
    	// 设置请求方法为 新建
    	$webServiceRootUrl = C('API_WX_Bind_USER_INFO');
    	$crudMethod = parent::OC_HTTP_CRUD_C;
    	$response = $this->request($webServiceRootUrl, $crudMethod, $params);
    	return parseApi($response);
    }
    //保存用户信息
/*     public function bindWxUserInfo2($params)
    {
    	// 设置请求方法为 新建
    	$webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/common/wechat/bindingwechat2';
    	$crudMethod = parent::OC_HTTP_CRUD_C;
    	$response = $this->request($webServiceRootUrl, $crudMethod, $params);
    	return parseApi($response);
    } */
    
    /**
     * 获取绑定的用户信息
     */
    public function getBindWxUserInfo($params)
    {
    	// 设置请求方法为 新建
    	$webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/common/wechat/getwechatuser';
    	$crudMethod = parent::OC_HTTP_CRUD_R;
    	$response = $this->request($webServiceRootUrl, $crudMethod, $params);
    	return parseApi($response);
    }
    
    /**
     * 向扫描仪发送指令，开始扫描名片
     * @param unknown $params
     * @return Ambigous <multitype:, multitype:string Ambigous <NULL, multitype:> Ambigous <number, NULL, int, unknown> >
     */
    public function startScannerOpera($params)
    {
    	// 设置请求方法为 新建
    	$webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/common/wechat/wechatpush';
    	$crudMethod = parent::OC_HTTP_CRUD_C;
    	$response = $this->request($webServiceRootUrl, $crudMethod, $params);
    	return parseApi($response);
    }

    /**
     * 根据openid和batchid生成订单
     */
    public function setOrder($params)
    {
        // 设置请求方法为 新建
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/common/wechat/order';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    /**
     * 根据订单号查询微信支付详情
     */
    public function getOrderDetail($params)
    {
        // 设置请求方法为 新建
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/common/wechat/ordertrade';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    /**
     * 获取未绑定二维码的扫描仪信息
     */
    public function getUnbindSanners($params)
    {
        // 设置请求方法为 新建
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/common/scan/list';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    /**
     * 根据批次号获取设备信息
     */
    public function getBatchScannerQrs($params)
    {
        // 设置请求方法为 新建
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/common/scan/tickets';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    /**
     * 获取所有已经绑定id的批次
     */
    public function getBatchIds($params)
    {
        // 设置请求方法为 新建
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/common/scan/batchidlist';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    /**
     * 扫描仪绑定二维码
     */
    public function bindQrToScanner($params)
    {
        // 设置请求方法为 新建
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/common/scan/bindtickets';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, array('params'=>$params));
        return parseApi($response);
    }

    /**
     * 查询分类
     */
    public function getWechatTags($params)
    {
        // 设置请求方法为 新建
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/common/wechat/anytag';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    /**
     * 根据batchid，openid 查询任意扫各分类数量
     */
    public function getCardsByTag($params)
    {
        // 设置请求方法为 新建
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/common/wechat/cardsbytag';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    /**
     *微信公众号用户绑定橙脉用户获取短信
     */
    public function bindWechatSms($params)
    {
        // 设置请求方法为 新建
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/oauth/apistore/bindwechatsms';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    /**
     *微信公众号用户绑定橙脉用户绑定操作
     */
    public function bindWechat($params)
    {
        // 设置请求方法为 新建
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/oauth/apistore/bindwechat';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
    
    /**
     * 发送邮件(可以包含附件)
     * @param unknown $params
     * @return Ambigous <multitype:, multitype:string Ambigous <NULL, multitype:> Ambigous <number, NULL, int, unknown> >
     */
    public function sendemail($params=array()){
    	// 设置请求方法为 新建
    	$webServiceRootUrl = C('API_SEND_EMAIL');
        //$webServiceRootUrl = 'http://192.168.30.191:9999/app_dev.php/common/apistore/sendmessage';
    	$crudMethod = parent::OC_HTTP_CRUD_C;
    	if(strtoupper(substr(PHP_OS,0,3))==='WIN'){
    		$params['enclosure'] = mb_convert_encoding($params['enclosure'], "UTF-8","GBK"); //解决中文文件名乱码问题
    	}
    	$this->setUploadFile($params['enclosure'],'enclosure');
    	$response = $this->request($webServiceRootUrl, $crudMethod, $params);
    
    	return parseApi($response);
    }

    /**
     * 保存生成的二维码信息
     */
    public function wechatSaveQrs($params)
    {
        // 设置请求方法为 新建
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/common/wechat/qrcodeinfo';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    /**
     * 根据二维码参数获取二维码信息
     */
    public function wechatGetQrs($params)
    {
        // 设置请求方法为 新建
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/common/wechat/qrcodeinfo';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    public function autocompleteM($params=array()){
        // 设置请求方法为 新建
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/common/wechat/otherauto';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
    
    /**
     * 获取企业信息接口
     */
    public function getEntInfo($params)
    {
    	// 设置请求方法为 新建
    	$webServiceRootUrl = C('API_WX_GET_ENT_INFO');
    	$crudMethod = parent::OC_HTTP_CRUD_R;
    	$response = $this->request($webServiceRootUrl, $crudMethod, $params);
    	return parseApi($response);
    }
    
    /**
     * 发送手机验证码
     * @param unknown $params
     * @return Ambigous <multitype:, multitype:string Ambigous <NULL, multitype:> Ambigous <number, NULL, unknown, int> >
     */
    public function sendMobileCode($params)
    {
    	// 设置请求方法为 新建
    	$webServiceRootUrl = C('API_WX_SEND_MOBILE_CODE');
    	$crudMethod = parent::OC_HTTP_CRUD_C;
    	$response = $this->request($webServiceRootUrl, $crudMethod, $params);
    	return parseApi($response);
    }
    
    /**
     * 验证短信验证码
     * @param unknown $params
     * @return Ambigous <multitype:, multitype:string Ambigous <NULL, multitype:> Ambigous <number, NULL, unknown, int> >
     */
    public function verifyMobileCode($params)
    {
    	// 设置请求方法为 新建
    	$webServiceRootUrl = C('API_WX_SEND_MOBILE_CODE');
    	$crudMethod = parent::OC_HTTP_CRUD_R;
    	$response = $this->request($webServiceRootUrl, $crudMethod, $params);
    	return parseApi($response);
    }

    /**
     * 员工绑定企业操作
     * @param unknown $params
     * @return Ambigous <multitype:, multitype:string Ambigous <NULL, multitype:> Ambigous <number, NULL, unknown, int> >
     */
    public function employBindEnt($params)
    {
    	// 设置请求方法为 新建
    	$webServiceRootUrl = C('API_WX_BIND_EMPLOYEE');
    	$crudMethod = parent::OC_HTTP_CRUD_C;
    	$response = $this->request($webServiceRootUrl, $crudMethod, $params);
    	return parseApi($response);
    }
    /*
     * share card to company
     * */
    public function shareCardTocompM($params=array()){
        // 设置请求方法为 新建
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/common/wechat/wechatshare';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
    /**
     * 员工解绑企业操作
     * @param unknown $params
     * @return Ambigous <multitype:, multitype:string Ambigous <NULL, multitype:> Ambigous <number, NULL, unknown, int> >
     */
    public function employUnBindEnt($params)
    {
    	// 设置请求方法为 新建
    	$webServiceRootUrl = C('API_WX_ENT_UNBIND_EMPLOY');
    	$crudMethod = parent::OC_HTTP_CRUD_C;
    	$response = $this->request($webServiceRootUrl, $crudMethod, $params);
    	return parseApi($response);
    }
    /**
     * 公众号个人端企业注册
     * @param unknown $params
     * @return Ambigous <multitype:, multitype:string Ambigous <NULL, multitype:> Ambigous <number, NULL, unknown, int> >
     */
    public function register($params = array())
    {
        $webServiceRootUrl =   C('API_WX_USER_REGISTER');
//        $webServiceRootUrl =   WEB_SERVICE_ROOT_URL.'/wxbiz/admin/regist';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }
    /**
     * 公众号企业入驻检验公司名是否存在
     * @param unknown $params
     * @return Ambigous <multitype:, multitype:string Ambigous <NULL, multitype:> Ambigous <number, NULL, unknown, int> >
     */
    public function checkCompany($params = array())
    {
        $webServiceRootUrl =   C('API_WX_CHECK_COMNAME');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }
    /**
     * 公众号企业入驻检验公司名是否存在
     * @param unknown $params
     * @return Ambigous <multitype:, multitype:string Ambigous <NULL, multitype:> Ambigous <number, NULL, unknown, int> >
     */
    public function checkMobile($params = array())
    {
        $webServiceRootUrl =   C('API_WX_CHECK_Mobile');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }
    /**
     * 公众号取消关注后增加日志
     * @param unknown $params
     * @return Ambigous <multitype:, multitype:string Ambigous <NULL, multitype:> Ambigous <number, NULL, unknown, int> >
     */
    public function addUnsubscribeLog($params = array())
    {
        $webServiceRootUrl = C('API_WX_ADDUNSUBSCRIBE_LOG');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
    /**
     * 名片批量分享
     * @param unknown $params
     * @return Ambigous <multitype:, multitype:string Ambigous <NULL, multitype:> Ambigous <number, NULL, unknown, int> >
     */
    public function batchCardShare($params = array())
    {
        $webServiceRootUrl = C('API_WX_CARD_BATCH_SHARE');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
    /**
     * 查询
     * @param unknown $params
     * @return Ambigous <multitype:, multitype:string Ambigous <NULL, multitype:> Ambigous <number, NULL, unknown, int> >
     */
    public function checkIndent($params = array())
    {
        $webServiceRootUrl = C('API_WX_CHECK_INDENT');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    /**
     * 微信名片分享到企业
     * @param unknown $params
     * @return Ambigous <multitype:, multitype:string Ambigous <NULL, multitype:> Ambigous <number, NULL, unknown, int> >
     */
    public function cardShareToCompany($params = array())
    {
        $webServiceRootUrl = C('API_WX_SHARE_TO_COMPANY');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
    
    /**
     * 微信绑定扫描仪
     * @param unknown $params
     * @return Ambigous <multitype:, multitype:string Ambigous <NULL, multitype:> Ambigous <number, NULL, unknown, int> >
     */
    public function bindScannerInfo($params = array())
    {
    	$webServiceRootUrl = C('API_WX_BIND_SCANNER');
    	$crudMethod = parent::OC_HTTP_CRUD_C;
    	$response = $this->request($webServiceRootUrl, $crudMethod, $params);
    	//$response = json_decode($response,true);
    	//print_r($response);die;
    	$response = parseApi($response);
    	return $response;
    }

    /*任意扫文件夹接口*/
    public function getSweepGroupListM($params=array()){
        // 设置请求方法为 新建
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/common/anyscan/folder';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
    public function addSweepGroupM($params=array()){
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/common/anyscan/folder';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
    public function delSweepGroupM($params=array()){
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/common/anyscan/editfolder';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
    public function delSweepFileM($params=array()){
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/common/anyscan/del';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    /*获取文件夹内名片列表*/
    public function getGroupCardlistM($params=array()){
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/common/anyscan/file';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    /*添加到文件夹*/
    public function addToGroupM($params=array()){
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/common/anyscan/add';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
    /*搜索 任意扫*/
    public function searchM($params=array()){
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/common/anyscan/search';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
    /*搜索历史 任意扫*/
    public function searchHistoryM($params=array()){
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/common/anyscan/keywords';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    /*搜索历史 任意扫*/
    public function delSearchHistoryM($params=array()){
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/common/anyscan/delkwd';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    /*名片列表 任意扫*/
    public function getCardListM($params=array()){
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/common/anyscan/list';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
    /*获取名片日期列表 任意扫*/
    public function getCardDateTimeM($params=array()){
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/common/anyscan/dates';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }

    //获取导出名片日志
    public function getExportLog($params = array())
    {
        $webServiceRootUrl = C('API_WX_EXPORT_LOG');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //$response = json_decode($response,true);
        //print_r($response);die;
        return parseApi($response);
    }

    /**
     * 发送邮件(可以包含附件)
     * @param unknown $params
     * @return Ambigous <multitype:, multitype:string Ambigous <NULL, multitype:> Ambigous <number, NULL, int, unknown> >
     */
    public function sendExcel($params=array()){
        // 设置请求方法为 新建
        $webServiceRootUrl = C('API_WX_EXPORT_EXCEL');
        //$webServiceRootUrl = 'http://192.168.30.191:9999/app_dev.php/common/apistore/sendmessage';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        
        if(!empty($params['enclosure'])){
            if(strtoupper(substr(PHP_OS,0,3))==='WIN'){
                $params['enclosure'] = mb_convert_encoding($params['enclosure'], "UTF-8","GBK"); //解决中文文件名乱码问题
            }
            $this->setUploadFile($params['enclosure'],'enclosure');
        }
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
    
        return parseApi($response);
    }
    /*
     * 公众号企业名删除
     */
    public function bizCardDelete($params=array()){
        // 设置请求方法为 新建
        $webServiceRootUrl = C('API_WX_GET_BIZCARD_DELETE');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
    /*
    * 公众号编辑企业名
    */
    public function bizCardEdit($params=array()){
        $webServiceRootUrl = C('API_WX_GET_BIZCARD_EDIT');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
    /*
   * 公众号获取企业名片详细信息
   */
    public function bizCardDetail($params=array()){
        $webServiceRootUrl = C('API_WX_GET_BIZCARD_DETAIL');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
    /*
     * 获取推送消息历史记录
    */
    public function getPushHistory($params=array()){
    	$webServiceRootUrl = C('API_WX_GET_PUSH_HISTORY');
    	$crudMethod = parent::OC_HTTP_CRUD_C;
    	$response = $this->request($webServiceRootUrl, $crudMethod, $params);
    	return parseApi($response);
    }
    /*
  * 公众号获取企业名片详细信息
  */
    public function remarksAdd($params=array()){
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/wxbiz/doccomment/adddoccomment';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
    public function remarksEdit($params=array()){
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/wxbiz/doccomment/editdoccomment';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
    public function remarksGet($params=array()){
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/wxbiz/doccomment/getdoccommentforwx';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
    public function remarksDel($params=array()){
        $webServiceRootUrl = WEB_SERVICE_ROOT_URL_WECHAT.'/wxbiz/doccomment/deldoccomment';
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);
    }
}
