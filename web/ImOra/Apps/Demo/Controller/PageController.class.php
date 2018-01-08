<?php
namespace Demo\Controller;
use Think\Log;
use Demo\Controller\Base\WxBaseController;

class PageController extends WxBaseController{

    private $_rows = 10;

    public function __construct(){
        parent::__construct();
    }
    
	public function index(){
        echo '';
    }

    private function _topMenu(){
        $params['isself'] = 1;
        $params['wechatid'] = $this->session['openid'];
        //$params['wechatid'] = 'ofIP5vrO61ORW8tWlNufVS3VUBxQ';
        
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'getWechatCard', array('params'=>$params));
        if (!empty($res['data']['numfound'])) {
            $this->assign('relation', 1);
            //echo 111;die;
        }
    }
    
    /**
     * 地址列表页面
     */
    public function addressList(){
        //$list = array('北京市海淀区上地10街', '北京市朝阳区花家地东路5号', '北京市朝阳区安家楼');
        
        $rst = \AppTools::webService('\Model\Common\Common','callApi',
            array(
                'url'    => WEB_SERVICE_ROOT_URL.'/common/wechat/getplace',
                'params' => array(),
            )
        );
        
        $list = $rst['data']['list'];
        //$list[] = array('longitude'=>115, 'latitude'=>40);
        $this->assign('list', json_encode($list));
        $this->assign('key', C('MAP_KEY'));
        //$this->display('map');
        $this->_topMenu();
        $this->display('addressList');
    }
    
    public function getAddress(){
        $params['longitude'] = I('lng');
        $params['latitude']  = I('lat');
        $params['dist']      = 5000;
        
        $rst = \AppTools::webService('\Model\Common\Common','callApi',
            array(
                'url'    => WEB_SERVICE_ROOT_URL.'/common/wechat/getscans',
                'params' => $params,
            )
        );
        
        echo json_encode($rst);
    }
    /**
     * 时间轴页面
     */
    public function timeline(){
        $this->_authBase('timeline', 'page');
        $params['userid'] = $this->session['openid'];
        //$params['userid'] = 'ofIP5vrO61ORW8tWlNufVS3VUBxQ';
        //$params['userid'] = 'ofIP5vvZ4HAoidQlsLBGVBZpZ99Y';
        //$params['userid'] = 'oMxRRv3Rk785taQzO-mJ1IJhVcj4';
        //$params['userid'] = 'ofIP5vm7AD7nZL697D8UnWL0vwL8';
        //$params['userid'] = 'oMxRRv-AQp5Q1IOBNXe6m2eL8WDA';
        //$params['userid'] = 'Ua5394a5073246a0c6e6935e1885e42b7';
        
//         print_r($params);die;
        $data = $this->_timelineData($params);
        //print_r($data);die;
        //echo json_encode($data);die;
        $this->assign('json', json_encode($data));
        $this->assign('type', 'timeline');
        $this->_topMenu();
        $this->display('timeline');
    }
    
    /**
     * 时间轴数据AJAX加载
     */
    public function timelineLoad(){
        $p = I('p', 1);
        $params['userid'] = $this->session['openid'];
        //$params['userid'] = 'ofIP5vm7AD7nZL697D8UnWL0vwL8';
        
        $params['page_start_number'] = ($p - 1) * $this->_rows;
        
        $data = $this->_timelineData($params);
        
        $rst['status'] = 0;
        $rst['data']   = $data;
        if (empty($data)){
            $rst['status'] = 1;
        }
        echo json_encode($rst);
    }
    
    /**
     * 时间轴数据获取
     * @param arr $params
     * @return arr
     */
    private function _timelineData($params){
        $params['page_size'] = $this->_rows;
        empty($params['page_start_number']) && $params['page_start_number'] = 0;
        
        $data = $this->_post('/time_line/time_line_data/', $params);
        //print_r($data);die;
        
        for ($i = 0; $i < count($data['sequential']); $i++) {
            for ($j = 0; $j < count($data['sequential'][$i]['cards']); $j++) {
                $this->_replaceSpecialChar($data['sequential'][$i]['cards'][$j]['name']);
                $this->_replaceSpecialChar($data['sequential'][$i]['cards'][$j]['company']);
                $this->_replaceSpecialChar($data['sequential'][$i]['cards'][$j]['position']);
            }
        }
        //print_r($data);die;
        return $data;
    }
    
    /**
     * 过滤特殊字符
     * @param str $str
     */
    private function _replaceSpecialChar(&$str){
        $str = str_replace('"', '', $str);
        $str = str_replace("\\", '', $str);
    }
    
    /**
     * 全国地图页面
     */
    public function map(){
        $this->_authBase('map', 'page');
        $params['user_id'] = $this->session['openid'];
        $params['rows'] = 30;
        //$params['user_id'] = 'ofIP5vsArxs-XVpSIdbQLdy4e8bg';
        //$params['user_id'] = 'oMxRRv7izATnRKO3jnKkXq4qwV2g';
        //$params['user_id'] = 'Ua5394a5073246a0c6e6935e1885e42b7';
        
        $data = $this->_post('/card_distribution/card_distribution_data/', $params);
//         print_r($data);die;
        $this->assign('json', json_encode($data));
        $this->assign('type', 'map');
        $this->assign('key', C('MAP_KEY'));
        //$this->display('map');
        $this->_topMenu();
        $this->display('map2');
    }
    
    /**
     * 关系图页面
     */
    public function relation(){
        $this->_authBase('relation', 'page');
        $params['user_id'] = $this->session['openid'];
        //$params['user_id'] = 'ofIP5vnuTl1UTMpiIu3pO4_mRQ90';
        //$params['user_id'] = 'ofIP5vhcYdgjJquZmViCHieBeju0';
        //$params['user_id'] = 'Ua5394a5073246a0c6e6935e1885e42b7';
        
        $data = $this->_post('/connection_map/connection_map_data/', $params);
        //print_r($data);die;
        $this->assign('json', json_encode($data));
        $this->assign('type', 'relation');
        $this->_topMenu();
        $this->display('relation');
    }
    
    /**
     * 我的统计
     */
    public function grid(){
        $this->_authBase('grid', 'page');
        $params['user_id'] = $this->session['openid'];
        //$params['user_id'] = 'ofIP5vkkfmQIkZtoxG8xs42wvR_E';
        //$params['user_id'] = 'Ua5394a5073246a0c6e6935e1885e42b7';
        
        $data = $this->_post('/static_groups/static_groups_data/', $params);
        //print_r($data);die;
        //$data['static_groups'][0]['results'][0]['name'] = 'a&b';
        $this->assign('json', json_encode($data));
        $this->assign('type', 'grid');
        $this->_topMenu();
        $this->display('grid');
    }
}
/* EOF */
