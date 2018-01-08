<?php
namespace Demo\Controller\Base;

use Think\Controller;
use Classes\GFunc;
use Classes\Factory;

// 载入工厂类
import('Factory', LIB_ROOT_PATH . 'Classes/');
class SocialController extends Controller{
    
    protected $uiLang;
    
    protected $translator;
    
    public $userAgent;
    
    public function __construct(){
        parent::__construct();

        $agent = isset($_SERVER['HTTP_USER_AGENT'])?strtolower($_SERVER['HTTP_USER_AGENT']):'';
        if (preg_match("/line/", $agent)){
            $this->userAgent = 'line';
        } else {
            $this->userAgent = 'weixin';
        }
        
        $this->uiLang = GFunc::getUiLang();
        if ($this->userAgent == 'line') {
            $this->uiLang = 'ja';
        }
        $globalLangFile = APP_PATH . 'Lang/social-'. $this->uiLang . '.xml';
        $this->translator = Factory::getTranslator($globalLangFile, 'xml');
        $this->assign('T',$this->translator);
        $this->assign('userAgent', $this->userAgent);
    }
}
