<?php
namespace H5\Controller;

use BaseController\BaseController;
use Classes\GFunc;
class ImoraController extends BaseController
{
    /*
	 * 是否检查登陆状态。 如果检查登陆状态， controller里面会自动检测登陆。
	 * @var bool
	 */
	protected $toCheckLogin = FALSE;

	/**
	 * 构造函数
	 */
    public function __construct()
    {
        parent::__construct();
        $this->assign('title',$this->translator->h5_imora_title_download_app);
    }

    /**
     * 显示app下载链接页面
     */
    public function index ()
    {
        $this->display('download');
    }

    /**
     * 下载APP
     */
    public function download ()
    {

        $this->display('download');
        return;
        $userAgent = empty($_SERVER['HTTP_USER_AGENT']) ? '' : $_SERVER['HTTP_USER_AGENT'];
        if (stripos($userAgent, 'iphone') || stripos($userAgent, 'ipod')
          || stripos($userAgent, 'Macintosh') || stripos($userAgent, 'Macintosh') ) {
        // 苹果系统下载
            $this->downloadIosApp();
        } else if (stripos($userAgent, 'Android')) {
        // 安卓系统下载
            $this->downloadApk();
        } else {
        // 非苹果， 非安卓， 让用户自行决定下载
            $this->display('download');
        }
    }

    /**
     * 显示扫描仪二维码链接过来的下载app页面
     */
    public function downloadForScanner ()
    {
        $this->display('downloadForScanner');
    }

    /**
     * 下载IOS版本
     */
    public function downloadIosApp ()
    {
        $url = 'itms-apps://itunes.apple.com/app/id'.C('IOS_APP_STORE_ID');
        $url = 'http://itunes.apple.com/cn/app/id'.C('IOS_APP_STORE_ID');
        //redirect($url, 1, $this->translator->H5_jumping_to_app_store);
        $this->assign('url', $url);
        $this->assign('time', 1);
        $this->assign('jumpMsg', $this->translator->H5_jumping_to_app_store);
        $this->display('downloadIosApp');
    }

    /**
     * 跳转到下载Apk的网址
     */
    public function downloadApk ()
    {
        $url = C('ANDROID_APP_LINK');
        //redirect($url);
        $this->assign('url', $url);
        $this->assign('time', 1);
        $this->assign('jumpMsg', $this->translator->h5_download_apk);
        $this->display('downloadApk');
    }

    /**
     * 显示APP关于页面。 如果设定了版本信息,显示指定版本信息的内容；否则显示关于首页
     */
    public function about ()
    {
    	$this->assign('title',$this->translator->h5_imora_title_about_app);
    	$version = I('version');
      /*  $viewFile = 'about_'.$version ;
         // View 文件路径
        $viewPath = TMPL_PATH . MODULE_NAME
                  . DIRECTORY_SEPARATOR . CONTROLLER_NAME
                  . DIRECTORY_SEPARATOR . $viewFile
                  . C('TMPL_TEMPLATE_SUFFIX'); */
        $key = GFunc::getArgeementKeys('about');
        $content = GFunc::h5pageManageShow($key.'_'.$version,1,1);
        if($key && $content){
        //if (file_exists($viewPath)) { // view 文件存在
        	$this->assign('content', $content);
            $this->display('H5Page');
        } else { // view 文件不存在
            $this->display('about');
        }
    }

    /**
     * 常见问题
     */
    public function faq(){
    	$this->assign('title',$this->translator->h5_imora_title_faq);
        $id = I('id');
        //$id = 'S7uzjPVH5Kx1yhwpu9SAQOVMvJfvWn0c';
        $params = array('questionid'=>$id);
        $detail = \AppTools::webService('\Model\News\News','getProblemsContentList',array('params'=>$params));
        $this->assign('data',$detail['data']['list'][0]);
        $this->display('faq');
    }

    /**
     * 新手帮助
     */
    public function manual(){
    	$this->assign('title',$this->translator->h5_imora_title_manual);
    	/**
		 * 固定新手帮助内容  对应运营平台url Appadmin/News/intro
    	 */
    	$key = GFunc::getArgeementKeys('intro');
    	$content = GFunc::h5pageManageShow($key,1,1);
    	$content = $this->_fontsizeProcess($content);
    	$this->assign('content', $content);
    	if (strlen($content)) {
             $this->displayH5Page('intro','intro');
        } else {
            $this->display('about');
        }
    	
    	/**
		 * 多条新手帮助  对应运营平台的url appadmin/news/manual
    	 
        $id = I('id');
        //$id = 'S7uzjPVH5Kx1yhwpu9SAQOVMvJfvWn0c';
        $params = array('questionid'=>$id);
        $detail = \AppTools::webService('\Model\News\News','getProblemsContentList',array('params'=>$params));
        $this->assign('data',$detail['data']['list'][0]);
        $this->display('manual');
        */
    }

    /**
     * 功能介绍
     */
    public function intro(){
    	$this->assign('title',$this->translator->h5_imora_title_intro);
        $key = GFunc::getArgeementKeys('intro');
        $content = GFunc::h5pageManageShow($key,1,1);
        if (strlen($content)) {
             $this->displayH5Page('intro','intro');
        } else {
            $this->display('about');
        }
    }

    /**
     * 新功能介绍
     */
    public function newIntro(){
    	$this->assign('title',$this->translator->h5_imora_title_new_intro);
    	$key = GFunc::getArgeementKeys('newIntro');
    	$content = GFunc::h5pageManageShow($key,1,1);
    	if (strlen($content)) {
    		$this->displayH5Page('newIntro','newIntro');
    	} else {
    		$this->display('about');
    	}
    }

    /**
     * 协议(type in (privacy, user, intellectual,userregister))
     * privacy:隐私政策,  user:用户协议, intellectual:知识产权声明,  userregister:用户注册协议
     */
    public function agreement(){
        $this->assign('title',$this->translator->h5_imora_title_agreement);
        $type = I('type');
        $key = GFunc::getArgeementKeys('protocol');
        $key = $key.'+-+-'.$type;
        $content = GFunc::h5pageManageShow($key,1,1);
        if (isMobile()) {
            $this->assign('content', $this->_fontsizeProcess($content));
            $this->display('agreement');
        } else {
            $this->assign('content', $content);
            $this->display('agreementForPC');
        }
    }
    
    /**
     * 橙脉卡类型协议
     */
    public function oraAppCardAgreement(){  
        $id = I('id');
        $params = array('id'=>$id);
        $result = \AppTools::webService('\Model\News\News','getCardTypeAgreement',array('params'=>$params));
        $title = I('title',$result['data']['data'][0]['name']); //页面标题，不传递默认为空
        $content=$result['data']['data'][0]['orangeagree'];
        $this->assign('title',$title);
        if (isMobile()) {
            $this->assign('content', $this->_fontsizeProcess($content));
            $this->display('agreement');
        } else {
            $this->assign('content', $content);
            $this->display('agreementForPC');
        }
    }

    public function appDetail ()
    {
        $this->display('appDetail');
    }

    /**
     * 兑换码兑换规则展示
     */
    public function exchangeRule ()
    {
        // @todo 马朝阳
        $this->assign('title',$this->translator->h5_imora_title_exchange_rule);
        $this->displayH5Page('exchange','exchangeRule');
    }

    /**
     * 活动规则展示页面
     */
    public function activityRule ()
    {
        // @todo 马朝阳
        $this->assign('title',$this->translator->h5_imora_title_activity_rule);
        $this->displayH5Page('activity','activityRule');
    }

    /**
     * 开具发票展示页面
     */
    public function invoiceRule ()
    {
        // @todo 马朝阳
        $this->assign('title',$this->translator->h5_imora_title_invioce_rule);
        $this->displayH5Page('invoice','invoiceRule');
    }

    /**
     * 活动内容展示页面
     */
    public function activityShow ()
    {
        // @todo 马朝阳
        $id   = I('id');    // 通过ID获取信息
        $this->assign('title',$this->translator->h5_imora_title_activity_show);
        //$id = 'S7uzjPVH5Kx1yhwpu9SAQOVMvJfvWn0c';
        $params = array('id'=>$id);
        $detail = \AppTools::webService('\Model\News\News','getActivityInfo',array('params'=>$params));
        $this->assign('data',$detail['data']);
        $this->display('activityShow');
    }

    /**
     * APP 中我的橙子帮助页面
     */
    public function orangeHelp ()
    {
    	$this->assign('title', $this->translator->h5_imora_chengzi_help);
    	$this->displayH5Page('orahelp','H5Page');
    }

    /**
     * 公用显示H5页面方法
     * @param string $key 数据唯一key
     * @param string $tplPage 模板名称
     */
    protected function displayH5Page ($key,$tplPage='H5Page')
    {
        $key = GFunc::getArgeementKeys($key);
        $content = GFunc::h5pageManageShow($key,1,1);
        $content = $this->_fontsizeProcess($content);
        $this->assign('content', $content);
        $this->display($tplPage);
    }

    /**
     * 字体大小处理
     * @param array $data
     */
    protected function _fontsizeProcess ($content)
    {
        /*
        //给安卓微信浏览器用的，不加空格字会变小，因为对rem支持的不是很好
        $count = 300 - mb_strlen(strip_tags($content), 'UTF-8');
        if ($count > 0){
            $str = str_repeat("&nbsp;", $count).'<br/>';
            $content = preg_replace("/(<br\/>)*$/", $str, $content);
        }
        $search = array(
                '<span style="font-size:16px;">', '<span style="font-size: 16px;">',
                '<span style="font-size:20px;">', '<span style="font-size: 20px;">',
                '<span style="font-size:24px;">', '<span style="font-size: 24px;">',
                '<span style="font-size:28px;">', '<span style="font-size: 28px;">',
        );
        $replace = array(
                '<span class="small">', '<span class="small">',
                '<span class="normal">', '<span class="normal">',
                '<span class="big">', '<span class="big">',
                '<span class="bigger">', '<span class="bigger">',
        );
        $content = str_replace($search, $replace, $content);

        return $content;*/
        return _fontSizeToClass($content);
    }
    // 银联列表  不需要权限限制
    public function unionPayList(){
        $params = array();
        $params['rows'] = 9999;
        $params['start']  = 0;
        $res = \AppTools::webService('\Model\OraPay\OraPay', 'oraPayM',array('params'=>$params,'crud'=>'r'));
        $this->assign('list',$res['data']['list']);

    	$this->display('banklist');
    	
    }
}

/* EOF */