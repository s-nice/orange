<?php
namespace  H5\Controller;

use BaseController\BaseController;

/**
 * 商户详情H5页面
 *
 *
 */
class FilmicController extends BaseController
{
    private $model;
    protected $toCheckLogin = FALSE;
    public function __construct()
    {
        parent::__construct();

    }

    public function index(){
        $name = I("name","17915153840682");
        $filmsrc=$name.".mp4";//视频路径
        $postpic = $name.".jpeg";//视频画布路径
        $time = I('posttime',time());
        $time = date("Y/m/d",$time);
        
        $filmsrc = C('H5_FILMIC_PATH').$filmsrc;
        $postpic = C('H5_FILMIC_PATH').$postpic;

        $this->assign('title'," 我用映画制作一部短片");
        $this->assign('filmsrc',$filmsrc);
        $this->assign('postpic',$postpic);
        $this->assign('posttime',$time);
        $this->display();

    }

}