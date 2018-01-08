<?php
namespace Home\Controller;
use Think\Controller;
use Model\JobInfo\JobInfo;
use Classes\Factory;
use Classes\GFunc;
use Model\Extend\Extend;

import('Factory', LIB_ROOT_PATH . 'Classes/');
class IndexController extends Controller {

    public function _initialize(){
        /*
        $methods  = ['index','app','about','join','support'];
        if (in_array(ACTION_NAME, $methods)){
            if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) + 60 > time()){
                header("http/1.1 304");die;
            }
            $time = time();
            $date = gmdate('H:i:s', $time);
            header("Last-Modified: " . gmdate("D, d M Y $date") . " GMT");
        }*/

        $this->uiLang = GFunc::getUiLang();
		$globalLangFile = APP_PATH . 'Lang/'. $this->uiLang . '.xml';
		$this->translator = Factory::getTranslator($globalLangFile, 'xml');
        $globalLangFile = APP_PATH . 'Lang/website-'. $this->uiLang . '.xml';
        $this->translator->mergeTranslation($globalLangFile, 'xml');//获取语言配置文件
        $this->assign('T', $this->translator);
    }

    public function image(){
        $size = end(explode('/', $_SERVER['REQUEST_URI']));
        header('Content-type: image/jpeg');
        echo file_get_contents('line/444.jpg');
    }
    
    /**
     * 官网首页
     */
    public function index()
    {
        $this->display('imoraIndex');
    }

    /**
     * 招聘
     */
    public function join()
    {
        $model = new JobInfo();
        $list = $model->selectByStatusDate(date('Y-m-d'));

        for ($i = 0; $i < count($list); $i++) {
            $list[$i]['content'] = htmlspecialchars_decode($list[$i]['content']);
        }
        $this->assign('list', $list);
        $this->display('imoraJoin');
    }
}