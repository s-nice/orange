<?php
namespace Company\Controller;

use Think\Controller;
use Classes\Factory;
use Classes\GFunc;
import('Factory', LIB_ROOT_PATH . 'Classes/');

class IndexController extends BaseController{
    private $rows = 12;
    
    //最多标签个数
    private $_MAX_TAG_NUM = 6;
    
    public function _initialize(){
        parent::_initialize();
        $this->assign('title','欢迎您登录橙脉企业平台');
    }

    public function demo (){
        echo 1;
    }

    /**
     * 做成vcard数据
     * @param arr $data
     * @return arr
     */
    private function _buildVcard($data){
        $newarr = array();
        $newarr['name']   = array();
        $newarr['mobile'] = array();
        
        $newarr['company'] = array(
            array(
                'company_name' => array(),
                'address'      => array(),
                'job'          => array(),
                'department'   => array(),
                'telephone'    => array(),
                'web'          => array(),
                'email'        => array()
            )
        );
        
        $defaultArr = array(
            'title_self_def' => '0',
            'is_chinese'     => '1',
            'is_changed'     => '1',
            'input'          => '2',
        );
        
        $newarr['name'] = $this->_buildVcardItem($data['FN'], array_merge($defaultArr, array(
            'surname'    => '',
            'given_name' => '',
            'title'      => '姓名',
        )));
        
        $newarr['mobile'] = $this->_buildVcardItem($data['CELL'], array_merge($defaultArr, array(
            'title' => '手机',
        )));
        
        $newarr['company'][0]['company_name'] = $this->_buildVcardItem($data['ORG'], array_merge($defaultArr, array(
            'title' => '公司',
        )));
        
        $newarr['company'][0]['address'] = $this->_buildVcardItem($data['ADR'], array_merge($defaultArr, array(
            'title' => '地址',
        )));
        
        $newarr['company'][0]['job'] = $this->_buildVcardItem($data['TITLE'], array_merge($defaultArr, array(
            'title' => '职位',
        )));
        $newarr['company'][0]['department'] = $this->_buildVcardItem($data['DEPAR'], array_merge($defaultArr, array(
            'title' => '部门',
        )));
        $newarr['company'][0]['telephone'] = $this->_buildVcardItem($data['TEL'], array_merge($defaultArr, array(
            'title' => '电话',
        )));
        
        $newarr['company'][0]['web'] = $this->_buildVcardItem($data['URL'], array_merge($defaultArr, array(
            'title' => '网址',
        )));
        $newarr['company'][0]['email'] = $this->_buildVcardItem($data['EMAIL'], array_merge($defaultArr, array(
            'title' => '邮箱',
        )));
        //print_r($newarr);die;
        return $newarr;
    }
    
    /**
     * 做成vcard数据
     * @param arr $data
     * @return arr
     */
    private function _buildVcardItem($itemList, $defaultArr){
        if (empty($itemList)) return array();
        $newarr = array();
        for ($i = 0; $i < count($itemList); $i++) {
            $tmp = array(
                'value' => $itemList[$i]
            );
            
            $newarr[] = array_merge($tmp, $defaultArr);
        }
        return $newarr;
    }
    
    /**
     * 保存名片信息
     */
    public function cardSave(){
        $front  = I('front');
        $back   = I('back');
        $cardid = I('cardid');
        $image  = I('image');
        $files  = array();
        
        $cardtype = I('cardtype','scan');
        
        //名片图片
        if (!empty($image)) {
            $image = $this->_createCard($image);
            if (is_array($image)){
                $files['picture']  = $image['thum'];
                $files['picpatha'] = $image['path'];
            }
        }
        
        //vCard数据
        $front = $this->_buildVcard($front, 'front');
        $back  = $this->_buildVcard($back, 'back');
        //print_r($front);
        //print_r($back);die;
        $vcard = array(
            'front' => $front,
            'back'  => $back
        );
        $params['vcard'] = json_encode($vcard);
         
        if ($cardid) {
            //更新
            $params['vcardid'] = $cardid;
            
            $callApiParams = array(
                'url'    => C('API_WX_BIZCARD_EDIT'),
                'crud'   => 'C',
                'params' => $params
            );
            
            if ($cardtype == 'custom'){
                $callApiParams['doParseApi'] = true;
                $callApiParams['files'] = $files;
            }
            $rst = \AppTools::webService('\Model\Common\Common', 'callApi', $callApiParams);
        } else {
            //添加
            $rst = \AppTools::webService('\Model\Common\Common', 'callApi',
                array(
                    'url'    => C('API_WX_BIZCARD_ADD'),
                    'crud'   => 'C',
                    'params' => $params,
                    'files'  => $files,
                    
                    'doParseApi' => true,
                )
            );
        }
        
        if ($rst['status'] == 0){
            $rst['msg1'] = '保存成功';
        } else {
            $rst['msg1'] = '保存失败';
        }
        
        foreach ($files as $file) {
            \GFile::delfile($file);
        }
        
        echo json_encode($rst);
    }
    
    /**
     * 创建名片图片和缩略图
     * @param data $image
     * @return arr
     */
    private function _createCard($image){
        $image = base64_decode(str_replace("data:image/png;base64,", '', $image));
        $filepath = C('UPLOAD_PATH');
        if (!is_dir($filepath)) {
            \GFile::mkdir($filepath);
        }
        $filename = md5($image);
        $filepath .= $filename.'.png';
        file_put_contents($filepath, $image);
        
        $thumpath = str_replace(".png", "-thumb.png", $filepath);
        $image = new \Think\Image();
        $image->open($filepath);
        $width = $image->width(); // 返回图片的宽度
        $height = $image->height();
        
        $image->thumb($width/4, $height/4)->save($thumpath);
        return array('path'=>$filepath, 'thum'=>$thumpath);
    }
    
    /**
     * 搜索员工
     * @return unknown
     */
    public function searchEmps($isReturn=false){
        $params['name']   = I('ename');
        $params['enable'] = 1;
        $params['rows']   = PHP_INT_MAX;
        $rst = \AppTools::webService('\Model\Common\Common', 'callApi',
            array(
                'url'    => C('API_COMPANY_STAFF_GET'),
                'params' => $params
            )
        );
        $empList = $rst['data']['list'];
        
        //去掉自己
        for ($i = 0; $i < count($empList); $i++) {
            if ($_SESSION['Company']['clientid'] == $empList[$i]['id']){
                //unset($empList[$i]);
                array_splice($empList, $i, 1);
                break;
            }
        }
        
        if ($isReturn) {
            return $empList;
        } else {
            $rst['list'] = $empList;
            echo json_encode($rst);
        }
    }
    
    /**
     * 搜索部门
     * @return unknown
     */
    public function searchDepts($isReturn=false){
        $params['name'] = I('dname');
        $params['rows'] = PHP_INT_MAX;
        $rst = \AppTools::webService('\Model\Common\Common', 'callApi',
            array(
                'url'    => C('API_COMPANY_DEPART_GET'),
                'params' => $params
            )
        );
        $deptList = $rst['data']['list'];
        if ($isReturn) {
            return $deptList;
        } else {
            $rst['list'] = $deptList;
            echo json_encode($rst);
        }
    }
    

    /**
     * 删除名片共享
     */
    public function delCardAuth(){
        $params['cardid']    = I('card');
        $params['type']      = I('type');
        $params['moduleids'] = I('module');
        
        $rst = \AppTools::webService('\Model\Common\Common', 'callApi',
            array(
                'url'    => C('API_WX_SHARE_DEL'),
                'crud'   => 'C',
                'params' => $params
            )
        );
        
        if ($rst['status'] == 0){
            $rst['msg1'] = '删除成功';
        } else {
            $rst['msg1'] = '删除失败';
        }
        echo json_encode($rst);
    }
    
    /**
     * 卡片查看权限
     */
    public function cardAuth(){
        $cards = I('cards');
        //echo $cards;die;
        $emps  = I('emps');
        $depts = I('depts');
        $s1 = $s2 = 0;
        
        $params['cardid']    = $cards;
        $params['type']      = 1;
        $params['moduleids'] = $emps;
        
        $rst = \AppTools::webService('\Model\Common\Common', 'callApi',
            array(
                'url'    => C('API_WX_SHARE_ADD'),
                'crud'   => 'C',
                'params' => $params
            )
        );
        $s1 = $rst['status'];
        
        $params = array();
        $params['cardid']    = $cards;
        $params['type']      = 2;
        $params['moduleids'] = $depts;
    
        $rst = \AppTools::webService('\Model\Common\Common', 'callApi',
            array(
                'url'    => C('API_WX_SHARE_ADD'),
                'crud'   => 'C',
                'params' => $params
            )
        );
        $s2 = $rst['status'];
        
        $rst = array();
        $rst['status'] = 0;
        if ($s1 == '0' && $s2 == '0') {
            $rst['msg'] = '操作成功';
        } else if ($s1 != 0){
            $rst['status'] = 1;
            $rst['msg'] = '员工权限操作失败';
        } else if ($s2 != 0){
            $rst['status'] = 2;
            $rst['msg'] = '部门权限操作失败';
        } else {
            $rst['status'] = 3;
            $rst['msg'] = '操作失败';
        }
        echo json_encode($rst);
    }
    
    /**
     * 加载员工AND部门数据
     */
    public function loadEmpDept(){
        $deptList  = $this->searchDepts(true);
        $empList   = $this->searchEmps(true);
        
        $rst = array();
        $rst['depts']  = $deptList;
        $rst['emps']   = $empList;
        echo json_encode($rst);
    }
    
    /**
     * 名片分享数据
     */
    public function loadShareInfo(){
        $_empList = $_deptList = array();
        $card = I('card');
        $rst = \AppTools::webService('\Model\Common\Common', 'callApi',
            array(
                'url'    => C('API_WX_SHARE_GET'),
                'params' => array('cardid'=>$card, 'rows'=>PHP_INT_MAX)
            )
        );
        
        for ($i = 0; $i < count($rst['data']['data']); $i++) {
            $tmp = $rst['data']['data'][$i];
            if ($tmp['type'] == 1){
                $_empList[] = $tmp;
            }
            if ($tmp['type'] == 2){
                $_deptList[] = $tmp;
            }
        }
        
        $rst = array();
        $rst['depts'] = $_deptList;
        $rst['emps']  = $_empList;
        echo json_encode($rst);
    }
    
    /**
     * 获取员工数据
     */
    public function getEmployees(){
        $params['rows']   = PHP_INT_MAX;
        $params['enable'] = 1;
        $params['is_del'] = 0;
        $params['bizid']  = $_SESSION['Company']['bizid'];
        $params['sort']   = 'name asc';
        $params['fields'] = 'id,name';
        $result = \AppTools::webService('\Model\Departments\Departments', 'getStaffM',array('params'=>$params));
        echo json_encode($result['data']['list']);
    }
    
    /**
     * 标签列表
     */
    public function tags($isReturn=false){
        $rst = \AppTools::webService('\Model\Common\Common', 'callApi',
            array(
                'url' => C('API_WX_BIZTAG_GET'),
                'params' => array('rows'=>PHP_INT_MAX)
            )
        );
        
        $tagList = $rst['data']['list'];
        if ($isReturn){
            return $tagList;
        } else {
            echo json_encode($tagList);
        }
    }
    
    /**
     * 名片数量
     */
    public function cardCount(){
        $rst = \AppTools::webService('\Model\Common\Common', 'callApi',
            array(
                'url' => C('API_WX_BIZCARD_COUNT'),
            )
        );
        echo json_encode($rst['data']);
    }
    
    /**
     * 名片列表
     */
    public function cards(){
        $params = $this->_params();
        //print_r($params);die;
        $url = C('API_WX_BIZCARD_GET');
        if ($params['searchType'] == 1) {
            unset($params['searchType']);
            $url = C('API_WX_BIZCARD_GET_MORE');
        }
        $params['fields'] = 'accountid,accountname,createdtime,picpatha,picpathb,picture,remark,section,vcardid,cardtype,vcard';
        $rst = \AppTools::webService('\Model\Common\Common', 'callApi',
            array(
                'url'    => $url,
                'params' => $params
            )
        );
        
        $rst['data']['list'] = $this->_processData($rst['data']['list']);
        //print_r($rst['data']['list']);die;
        //翻页信息
        $rst['data']['totalpage'] = ceil($rst['data']['numfound'] / $this->rows);
        echo json_encode($rst['data']);
    }
    
    /**
     * 首页
     */
    public function index(){
        //print_r($_SESSION);die;
        //部门、员工数据
        $paramss['rows'] = 99999;
        $paramss['sort'] = 'createdtime asc';
        $depart = A('Departments');
        $retult_d = $depart->getDepartData($paramss);
        $depart->departReturn($retult_d);
        $staff = $depart->getDepartStaff();
        $this->assign('staff',$staff);
        
        //全部共享数据（1：开，2：关）
        $params['bizid'] = $_SESSION['Company']['bizid'];
        $result = \AppTools::webService('\Model\Departments\Departments', 'getBizInfo',array('params'=>$params));
        $this->assign('isopen',$result['data']['list'][0]['open']);
       
        //$info = I('get.issearch') == '1'? 'cardsearchresult' : 'cardlist';
        $this->assign('breadcrumbs',array('key'=>'cardmanage','info'=>'cardlist','show'=>''));
        $this->assign('moreCSSs',array(
            'css/Company/index',
        ));
        $this->assign('moreScripts', array(
            'js/jquery/angular.min',
            'js/oradt/global',
            'js/jsExtend/String',
            'js/jsExtend/jquery.cookie',
        ));
        $this->assign('maxtagnum', $this->_MAX_TAG_NUM);
        $this->display('index');
    }
    
    /**
     * 名片回收站
     */
    public function cardRecyclebin (){
    	$this->assign('moreCSSs',array('css/Company/index'));
    	$this->display('cardRecyclebin');
    }

    /**
     * 删除名片
     */
    public function delCard(){
        $cards = explode(',', I('cards'));
        $successCount = 0;
        for ($i = 0; $i < count($cards); $i++) {
            $params['vcardid'] = $cards[$i];
            $rst = \AppTools::webService('\Model\Common\Common', 'callApi',
                array(
                    'url'    => C('API_WX_BIZCARD_DEL'),
                    'crud'   => 'C',
                    'params' => $params
                )
            );
            if ($rst['status'] == 0){
                $successCount++;
            }
        }
        
        $rst = array();
        if (count($cards) == $successCount){
            $rst = array('status'=>0, 'msg'=>'删除成功');
        } else {
            $rst = array('status'=>1, 'msg'=>'部分名片删除失败');
        }
        
        echo json_encode($rst);
    }
    
    /**
     * 给名片添加标签
     */
    public function addTag(){
        $cards = explode(',', I('cards'));
        $tagid = I('tags');
        
        $successCount = 0;
        for ($i = 0; $i < count($cards); $i++) {
            $rst = \AppTools::webService('\Model\Common\Common', 'callApi',
                array(
                    'url'    => C('API_WX_BIZCARD_ADDTAG'),
                    'crud'   => 'C',
                    'params' => array('vcardid'=>$cards[$i], 'remark'=>$tagid)
                )
            );
            if ($rst['status'] == 0){
                $successCount++;
            }
        }
        
        $rst = array();
        if (count($cards) == $successCount){
            $rst = array('status'=>0, 'msg'=>'操作成功');
        } else {
            $rst = array('status'=>1, 'msg'=>'部分标签添加失败');
        }
        
        echo json_encode($rst);
    }
    
    /**
     * 处理名片列表数据
     * @param arr $list
     * @return arr
     */
    private function _processData($list){
        for ($i = 0; $i < count($list); $i++) {
            $list[$i]['createdtime'] = date('Y-m-d', $list[$i]['createdtime']);
            
            //图片（如果没有小图，则用大图）
            if (empty($list[$i]['picture'])){
                $list[$i]['picture'] = $list[$i]['picpatha'];
            }
        }
        //print_r($list);die;
        return $this->analyShowVcard($list, true);
    }
    
    /**
     * 解析名片数据用于显示
     * @param array $list 列表数据
     * @param bool $showBack 是否解析名片反面数据
     * @param bool $isJson 是否解析vcard数据
     */
    private function analyShowVcard($list,$showBack=false,$isJson=true){// vcardid=16452
        if($list){
            foreach ($list as $key=>$val){
                unset($list[$key]['ENG'],$list[$key]['DEPT'],$list[$key]['FN'],$list[$key]['TITLE'],$list[$key]['ORG'],$list[$key]['ADR'],$list[$key]['CELL'],$list[$key]['TEL'],$list[$key]['URL'],$list[$key]['EMAIL']);
                $vcard = $val['vcard'] ? json_decode($val['vcard'],true) : array();
                if(empty($val['vcard']) || empty($vcard['front'])){
                    //continue;
                }
                //echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',print_r($vcard,1);exit;
                $front = $vcard['front']; //名片正面数据
                $list[$key]['front'] = $this->_getVcardSingleData($front);
                $back = array();
                if($showBack==true && !empty($vcard['back'])){ //名片反面数据
                    $back = $this->_getVcardSingleData($vcard['back']);
                }
                $list[$key]['back'] = $back;
                unset($list[$key]['vcard']);//去掉VCARD数据
            }
        }
        return $list;
    }
    
    /**
     * 解析名片单面数据,单独解析名片正面数据或反面数据，根据传递的数据源来决定
     * @param array $oneSideData 名片单面的数据
     * @return multitype:unknown multitype: multitype:unknown
     */
    private function _getVcardSingleData($oneSideData){
        $rst = array();
        $ENG = $DEPAR = $FN = $ORG = $ADR = $CELL = $TEL = $URL = $TITLE = $EMAIL = array();
        $FN = $this->_getVcardValue($oneSideData,'name'); //人名
        $ENG = $this->_getVcardValue($oneSideData,'name', true); //人名
        $CELL = $this->_getVcardValue($oneSideData,'mobile'); //手机
        if(!empty($oneSideData['company'])){
            foreach ($oneSideData['company'] as $company){
                $ORG = $this->_getVcardValue($company,'company_name'); //公司名称
                $ADR = $this->_getVcardValue($company,'address'); //地址
                $TEL = $this->_getVcardValue($company,'telephone'); //电话
                $URL = $this->_getVcardValue($company,'web'); //网址
                $TITLE = $this->_getVcardValue($company,'job'); //职位
                $EMAIL = $this->_getVcardValue($company,'email'); //邮箱
                $DEPAR = $this->_getVcardValue($company,'department'); //部门
            }
        }
        $rst = array('FN' => $FN,
            'ENG' => $ENG,
            'ORG' => $ORG,
            'ADR' => $ADR,
            'CELL' => $CELL,
            'TEL' => $TEL,
            'URL' => $URL,
            'TITLE' => $TITLE,
            'EMAIL' => $EMAIL,
            'DEPAR' => $DEPAR
        );
        return $rst;
    }
    
    /**
     * 获取名片json字符串中的value
     * param $dataSet 数据数组
     * param $jsonName 数据健名
     */
    private function _getVcardValue($dataSet,$jsonName, $englishname = false){
        $rst = array();
        if(isset($dataSet[$jsonName])){
            foreach ($dataSet[$jsonName] as $dataElement){
                if ($jsonName == 'name') { // 姓名项区分中英文
                    if ($englishname) {
                        if ($dataElement['is_chinese'] == '0') { //英文
                            $rst[] = $dataElement['value'];
                        }
                    } else {
                        if ($dataElement['is_chinese'] == '1') { //中文
                            $rst[] = $dataElement['value'];
                        }
                    }
                } else {
                    $rst[] = $dataElement['value'];
                }
            }
        }
        return $rst;
    }
    
    /**
     * 列表页参数
     * @return arr
     */
    private function _params(){
        $p = (I('p') > 1) ? I('p') : 1;
        
        //类型
        $params['section'] = I('type');
        $searchType = I('searchType');
        //echo $searchType;die;
        //print_r($_GET);
        if (empty($searchType)){
            //普通搜索，搜素内容判断
            $keyword = (I('keyword') !== '') ? trim(urldecode(I('keyword'))) : '';
            if (!empty($keyword)) {
                $params['vcardtxt'] = $keyword;
            }
        } else if($searchType=='2'){
            //标签搜索
            $params['remark'] = I('tags');
        } else {
            //高级搜索
            $params['creatorid'] = I('eid');
            $params['cardname']  = I('fn');
            
            $params['org']   = I('org');
            $params['depar'] = I('depar');
            $params['title'] = I('title');
            $params['adr']   = I('adr');
            $params['email'] = I('email');
            
            $starttime = strtotime(I('stime'));
            $endtime   = strtotime(I('etime'))+3600*24;
            if (!empty($starttime)) {
                $params['createdtimeinfo'] = "$starttime,$endtime";
            }
            
            $params['searchType'] = 1;
        }
        
        
        $params['rows'] = $this->rows;
        $params['start'] = ($p > 1) ? ($p - 1) * $params['rows'] : 0;
        //print_r($params);
        return $params;
    }

}
