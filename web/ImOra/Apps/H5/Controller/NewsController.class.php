<?php
namespace  H5\Controller;

use BaseController\BaseController;
use Classes\GFunc;
use Think\Log;

/**
 * 新闻资讯H5页面
 * @author wangzx
 *
 */
class NewsController extends BaseController
{
    protected $toCheckLogin = FALSE;

    private $_pageSize = 5;

    public function __construct()
    {
        parent::__construct();
        $this->assign('T',$this->translator);
    }

    public function index (){

    }
    
    /**
     * 咨询详情
     */
    public function news()
    {
        //$_GET['showid'] = 'f2uZEt8JpnRJhKUc8qhzY5enqvh42jtH';
        $showid = I('showid');
        $params = array('showid'=>$showid);
        $detail = \AppTools::webService('\Model\News\News','getContentList2',array('params'=>$params));
//         print_r($detail);die;
        $this->_newsProcess($detail['data']['list'][0]);
//         print_r($detail['data']['list'][0]);die;
        $this->assign('data',$detail['data']['list'][0]);
        $comments = $this->comment(false);
//         print_r($comments);die;
        if (!empty($detail['data']['list'][0]['labels'])){
            $this->assign('showRecommend','1');
        }
        $this->assign('toShowIosAppStoreId', true); // IOS上显示APP下载
        $this->assign('title', $this->translator->str_orangeh5_detail);
        $this->assign('comments',$comments);
        $this->assign('showid',$showid);
        $this->assign('resources',$detail['data']['list'][0][resource]['list'][0]);
        $this->display('news');
    }

    /**
     * 回答详情
     */
    public function ask(){
        $showid = I('showid');
//         $showid = '3Feauv2PI1N2gnXqIE9pdEom2xzyoAh1';
        $params = array('showid'=>$showid);
        $detail = \AppTools::webService('\Model\News\News','getContentList2',array('params'=>$params));
//         print_r($detail);die;
        $this->_askProcess($detail['data']['list'][0]);

        $comments = $this->comment(false);
//         print_r($comments);die;
        $this->assign('comments',$comments);
        $this->assign('data',$detail['data']['list'][0]);
        $this->assign('resources',$detail['data']['list'][0][resource]['list']);
        $this->assign('showid',$showid);
        $this->display('ask');
    }

    /**
     * 评论列表数据
     * @param bool $isAjax 是否为页面ajax请求
     * @return array
     */
    public function comment($isAjax=true){
        $showid = I('showid');
        $p      = I('p', 1);
        $start  = ($p - 1) * $this->_pageSize;

        $params = array('showid'=>$showid, 'sort'=>'datetime,desc', 'start'=>$start, 'rows'=>$this->_pageSize, 'level'=>1);
        $data   = \AppTools::webService('\Model\News\News','comment2',array('params'=>$params));
        $data   = $data['data'];

        $this->_commentProgress($data['list']);
//         print_r($data);die;
        if ($data['start'] + $this->_pageSize < $data['numfound']) {
            $data['isNext'] = true;
        }
        if ($isAjax) {
            echo json_encode($data);
            //$this->ajaxReturn($data['data']);
        } else {
            return $data;
        }
    }

    /**
     * 评论的数据处理
     * @param array $list
     */
    private function _commentProgress(&$list){
        $today = date('Y/m/d');
        for ($i = 0; $i < count($list); $i++) {
            $list[$i]['date'] = date('Y/m/d H:i',$list[$i]['datetime']);
            if ($today == substr($list[$i]['date'], 0, 10)) {
                $list[$i]['date'] = substr($list[$i]['date'], 11);
            } else if (substr($today, 0, 4) == substr($list[$i]['date'], 0, 4)){
                $list[$i]['date'] = substr($list[$i]['date'], 5);
            }

            //子评论查询
            $params = array();
            $params['topid'] = $list[$i]['commentid'];
            $params['showid'] = $list[$i]['showid'];
            $params['rows'] = PHP_INT_MAX;
            $rst = \AppTools::webService('\Model\News\News','comment2',array('params'=>$params));
            $list[$i]['subcomments'] = $rst['data']['list'];
        }
    }

    /**
     * 头像
     */
    public function headImg(){
        $params['path'] = I('clientid');
        $params['defaultHeadImg'] = './images/defaultAvatar.png';
        //$params['path'] = 'AUtCAQKPxdpfdsGmZKmuJbp2ak2Fi00000000766';
        $rst = \AppTools::webService('\Model\Account\Account','headImage',array('params'=>$params));
    }

    /**
     * 回答详情的数据处理
     * @param array $data
     */
    private function _askProcess(&$data){
        $data['datetime'] = date('Y/m/d H:i',$data['datetime']);
        if (empty($data['avatarpath'])){
            $data['avatarpath'] = U('/H5/News/headImg', array('clientid' => $data['clientid']));
        }
    }

    /**
     * 资讯详情的数据处理
     * @param array $data
     */
    private function _newsProcess(&$data){
        $data['datetime'] = date('m/d H:i',$data['datetime']);
        $data['content'] = GFunc::replaceToImg($data['content'], 1);
        if (empty($data['category'])) {
            $data['category'] = $this->translator->str_orangeh5_category_no;
        }
        /*
        //给安卓微信浏览器用的，不加空格字会变小，因为对rem支持的不是很好
        $count = 300 - mb_strlen(strip_tags($data['content']), 'UTF-8');
        if ($count > 0){
            $str = str_repeat("&nbsp;", $count).'<br/>';
            $data['content'] = preg_replace("/(<br\/>)*$/", $str, $data['content']);
        }
        
        preg_match_all("/<span style=\"(.*?)\">/", $data['content'], $matches);
        $matches = $matches[0];
        for ($i = 0; $i < count($matches); $i++) {
            $tmp = $matches[$i];
            if (strpos($matches[$i], "font-size: 28px;") !== false){
                $tmp = str_replace("font-size: 28px;", "", $tmp);
                $tmp = str_replace("span", 'span class="bigger"', $tmp);
            }
            if (strpos($matches[$i], "font-size: 24px;") !== false){
                $tmp = str_replace("font-size: 24px;", "", $tmp);
                $tmp = str_replace("span", 'span class="big"', $tmp);
            }
            if (strpos($matches[$i], "font-size: 20px;") !== false){
                $tmp = str_replace("font-size: 20px;", "", $tmp);
            }
            if (strpos($matches[$i], "font-size: 16px;") !== false){
                $tmp = str_replace("font-size: 16px;", "", $tmp);
                $tmp = str_replace("span", 'span class="small"', $tmp);
            }
            $data['content'] = str_replace($matches[$i], $tmp, $data['content']);
        }*/
        $data['content'] = _fontSizeToClass($data['content']);
    }

    /**
     * 企业介绍展示页面。 介绍内容为企业在企业平台进行的维护管理内容
     * 根据传入的企业名称或企业id来展示企业主页内容。
     * 如果有企业id，查找入驻企业。 否则通过企业名字获取是否为入驻企业。
     */
    public function companyIntro (){
        $params['name'] = I('cname'); // 通过公司名称获取企业信息
        $match  = I("match");
        empty($params['name']) and redirect(U('H5/News/noInfo'));

        // 查询企业详情信息
        $res = \AppTools::webService('\Model\Common\Common', 'callApi',
            array(
                'url'    => C('API_COMPANY_DETAIL'),
                'params' => $params
            )
        );
        $data = $res['data'];
        
        if (empty($data)) {
            if ($match !== 'no') {
                return $this->companySearch($params); // 公司列表模糊查询
            } else {
                redirect(U('H5/News/noInfo'));
            } 
        }
        $data['content'] = json_decode($data['content'], true);
        $data['companymortgage'] = json_decode($data['companymortgage'], true);
        $this->assign('data', $data);
        $this->assign('title',$this->translator->h5_imora_title_ent_detail);
        $this->display("newCompanyInfo");
        // $this->display('companyIntro');
    }

    /**
     * 格式化公司列表数据,公司名高亮、空值样式、时间样式
     * @param $lists array 公司列表的对象数组
     * @param $keyWord string 搜索关键词
     * @return array 处理后的公司列表数组 
     */
    public function checkCompanyList($lists, $keyWord){
        $lists = json_decode($lists, true);
        foreach ($lists as $key => $company) {
            if (strstr($company['name'], $keyWord) == false) {
                unset($lists[$key]); // 筛除公司名称不含关键字的 
                continue;
            }
            $company['name'] = str_replace($keyWord, '<i>' . ($keyWord) . '</i>', $company['name']); // 公司名称高亮显示
            $company['estiblishTime'] = date('Y/m/d',strtotime($company['estiblishTime']));
            empty($company['legalPersonName']) and $company['legalPersonName'] = '-';
            empty($company['regCapital']) and  $company['regCapital'] = '-';
            $lists[$key] = $company;
        }
        return $lists;
    }

     /**
     * 未找到企业相关信息
     */
    public function noInfo(){
        $this->assign('nodata', 1);
        $this->display('noInfo');
    }

    /**
     * 地图
     */
    public function map(){
        $this->assign('address', I('address'));
        $this->assign('key', C('BAIDU_AK'));
        $this->display('map');
    }
    
    /**
     * 错误链接
     */
    public function errorurl(){
    	$this->display('invalid');
    }
    /**
     * 橙脉小秘书资讯
     */
    public function secretary ()
    {
        // @todo 马朝阳
        $type = I('type'); // YPE 当前可以为 ： promotion （用户推广）， activity （活动）
        $id   = I('id');    // 通过ID获取信息
        $this->assign('title',$this->translator->h5_imora_title_secretary);
        $isShare = I('imorashare','yes');
        $this->assign('isShare',$isShare);
        //$id = 'S7uzjPVH5Kx1yhwpu9SAQOVMvJfvWn0c';
        switch ($type) {
            case 'activity':
            	// 对应 运营后台的橙脉小秘书
                $params = array('activityid'=>$id);
                $detail = \AppTools::webService('\Model\News\News','getSecretary',array('params'=>$params));
                if($detail['data']['list'][0]['isback'] == 2){
                	// 发现橙脉小秘书撤回， 跳转到app介绍页面
                	redirect(U('H5/News/errorurl'));
                }
                if (!empty($detail['data']['list'][0]['weburl'])) {
                    // 连通则跳转
                    if (checkUrlValid($detail['data']['list'][0]['weburl'])) {
                        redirect($detail['data']['list'][0]['weburl']);
                    } else {
                        // 不连通记录日志
                        Log::write('File:'.__FILE__.' LINE:'.__LINE__." url errorCode ".var_export($detail['data']['list'][0]['weburl']." 打开链接错误",true));
                    }
                }
                $content = $detail['data']['list'][0]['content'];
                // 分享的活动内容是一条资讯， 获取资讯内容主体
                if ($detail['data']['list'][0]['showid']) {
                    $params = array('showid' => $detail['data']['list'][0]['showid']);
                    $newsContent = \AppTools::webService('\Model\News\News','getContentList',
                                                         array('params'=>$params));
                    $content = $newsContent['data']['list'][0]['content'];
                }
                $detail['data'] = array('content' => $content,
                                        'datetime'=> date('Y-m-d', $detail['data']['list'][0]['pushtime']),
                                        'image'   => $detail['data']['list'][0]['image'],
                                        'title'   => htmlspecialchars($detail['data']['list'][0]['title']),
                						'name'	  => !empty($detail['data']['list'][0]['admin'])?$detail['data']['list'][0]['admin']:''
                                  );
                break;
            case 'promotion':
            	// 对应 运营后台的推广信息
                $params = array('proid'=>$id);
                $detail = \AppTools::webService('\Model\User\UserPush', 'userpush',array('params'=>$params));
                $detail['data'] = array('content' => $detail['data']['list'][0]['content'],
                                        'datetime'=> date('Y-m-d', $detail['data']['list'][0]['pushtime']),
                                        'image'   => '',
                                        'title'   => $detail['data']['list'][0]['title'],
                						'name'	  => isset($detail['data']['list'][0]['name'])?$detail['data']['list'][0]['name']:''
                                  );
                break;
            default:
                $detail = array('data'=>array('content'=>''));
                break;
        }
        if (userAgent() !== 'mobile') {
            $this->assign('data',$detail['data']);
            $this->display('secretaryForPC');
            die();
        }
        $detail['data']['content'] = GFunc::replaceToImg($detail['data']['content'], 1);
        $detail['data']['content'] = _fontSizeToClass($detail['data']['content']);
        $this->assign('data',$detail['data']);
        $this->display('secretary');
    }

    /**公司搜索列表**/
    public function companySearch ($params){
        // 查询是否有模糊匹配的公司列表
        $companyList = $res = \AppTools::webService('\Model\Common\Common', 'callApi',
            array(
                'url'    => C('API_COMPANYS_LIST'),
                'params' => $params
            )
        );
        $lists = $this->checkCompanyList($companyList['data']['content'], $params['name']);// 格式化查到的数据
        if (!empty($lists)) {
            $this->assign('keyWord',$params['name']);
            $this->assign('companys', $lists);
            $this->assign('title',$params['name']);
            $this->display('companySearch');
        } else {
            redirect(U('H5/News/noInfo')); // 跳转空白页面
        }
    }

    /**news企业详情**/

    public function newCompanyInfo(){
        $this->display("newCompanyInfo");
    }
}

/* EOF */