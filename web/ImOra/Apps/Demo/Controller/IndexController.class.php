<?php
namespace Demo\Controller;
use BaseController\BaseController;
class IndexController extends BaseController
{

    private $rows = 20;
    public function _initialize()
    {
    	parent::_initialize();
    }

	/**
     * demo首页 二度人脉
     * Enter description here ...
     */
	public function index()
    {
        $this->secondConnections();
    }

    /**
     * 我的好友名片
     */
    public function friends ()
    {
    	$this->assign('menunow','hy');
		$this->assign('title','我的好友');
        $params = array('self'=>'false');
        $p = (I('get.p')> 1) ? I('get.p') : 1;
        $params['rows'] = $this->rows;
        $params['start'] = ($p - 1)*$params['rows'];
        //$params['friend'] = 1;
        $params['self'] = 'false';

        $list = \AppTools::webService('\Model\Demo\Demo', 'getFriendsList', array('params'=>$params ));
        $page = getpage($list['data']['numfound'],$this->rows);
        $list = $list['data']['vcards'];
        if($list){
        	require_once LIB_ROOT_PATH . 'Classes/CardOperator.class.php';//导入解析名片数据文件
        	$CardOperator = new \CardOperator();
        	foreach ($list as &$val){
        		$rst = $CardOperator->parseVcardText($val['vcard']);//解析名片数据
        		$fn = $org = $adr = '';
        		if(isset($rst[0])){
        			$info = $rst[0];
        			$fn = isset($info['name']) ? $info['name']['value'] : '';
        			$org = isset($info['company']) ? $info['company']['value'] : '';
        			$adr = isset($info['address']) ? $info['address']['value'] : '';
        		}
        		$val['FN'] = $fn;
        		$val['ORG'] = $org;
        		$val['ADR'] = $adr;
        	}
        }

        //分页
        $this->assign('pagedata',$page->show());

        $this->assign('list', $list);
        $this->display('friends');
    }

    /**
     * 谁看过我的名片
     */
    public function whoSeeMe ()
    {
    	$this->assign('menunow','skw');
    	$this->assign('title','谁看过我的名片');
    	$this->_getSeeCard(2);
    	$this->display('whoSeeMe');
    }

    /**
     * 我看过谁的名片
     */
    public function whoIsee ()
    {
    	$showType = I('st','list');//展示类型list、relation
    	$this->assign('menunow','wks');
    	$this->assign('title','我看过谁的名片');
    	if($showType == 'relation'){
    		$this->_getSeeCardRelation();
    	}else{
    		$this->_getSeeCard(1);
    	}
    	$this->assign('showType',$showType);
    	$this->display('whoISee');
    }
    /**
     * 我看过谁关系图
     */
    private function _getSeeCardRelation()
    {
    	$params = array('userId' => $_SESSION[MODULE_NAME]['clientid'],'rows'=>15);
        $rst1 = \AppTools::webService('\Model\Demo\Demo', 'getISeeRelationshipByUserId', $params);
       // echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',print_r($rst1,1);exit;
    	$this->assign($rst1);
    }
    /**
     * 根据名片ID返回名片图片
     */
    public function getCardImage()
    {
    	$cardId = I('cardid');
    	$param = array();//int 1为我看谁,2为谁看我
    	$param['status']  = 1;
    	$param['vcardid'] = $cardId;
    	$listRst = \AppTools::webService('\Model\Demo\Demo', 'getAlredySeeVcard', array('params'=>$param ));
    	if(isset($listRst['data']['list'][0])){
    		$imagePath = $listRst['data']['list'][0]['picture'];
    		if(IS_AJAX){
    			//echo json_encode($imagePath);exit;
    			echo $imagePath;exit;
    		}
    		$extName = strtolower(array_pop(explode('.', $imagePath)));
    		switch ($extName) {
    			case 'png':
    			case 'gif':
    			case 'jpg':
    				$contentType = 'image/' . $extName;
    				break;
    			case 'bmp':
    				$contentType = 'image/vnd.wap.wbmp';
    				break;
    			default:
    				break;
    		}
    		header('Content-type: ' . $contentType);
    		echo file_get_contents($imagePath);
    	}
    }
    
    public function showCard2()
    {
    	$param = array('params'=>array('vcardid'=>I('cardid')));
    	$listRst = \AppTools::webService('\Model\Contact\ContactVcard', 'contactVcard', $param);
    	if($listRst['data']['numfound']>0 && $listRst['data']['vcards'][0]['picture'] != ''){
    		$imagePath = $listRst['data']['vcards'][0]['picture'];
    	}else{
    		$imagePath = U('/','','',true ).'images/bg_img_cardimg.jpg';
    	}
    	if(IS_AJAX){
    		//echo json_encode($imagePath);exit;
    		echo $imagePath;exit;
    	}
    	$extName = strtolower(array_pop(explode('.', $imagePath)));
    	switch ($extName) {
    		case 'png':
    		case 'gif':
    		case 'jpg':
    			$contentType = 'image/' . $extName;
    			break;
    		case 'bmp':
    			$contentType = 'image/vnd.wap.wbmp';
    			break;
    		default:
    			break;
    	}
    	header('Content-type: ' . $contentType);
    	echo file_get_contents($imagePath);
    }
    /**
     * 查询看过的名片
     * @param $status int	1为我看2为谁看
     */
    private function _getSeeCard($status=1)
    {
    	$params = array('status'=>$status);//int 1为我看谁,2为谁看我
    	$p = (I('get.p')> 1) ? I('get.p') : 1;
    	$params['rows'] = $this->rows;
    	$params['start'] = ($p - 1)*$params['rows'];

    	$listRst = \AppTools::webService('\Model\Demo\Demo', 'getAlredySeeVcard', array('params'=>$params ));
    	$list = $listRst['data']['list'];
    	if($list){
    		require_once LIB_ROOT_PATH . 'Classes/CardOperator.class.php';//导入解析名片数据文件
    		$CardOperator = new \CardOperator();
    		foreach ($list as &$val){
    			$vcard = isset($val['vcard']['vcard']) ? $val['vcard']['vcard'] : $val['vcard'];
    			$rst = $CardOperator->parseVcardText($vcard);//解析名片数据
    			$fn = $org = $adr = '';
    			if(isset($rst[0])){
    				$info = $rst[0];
    				$fn = isset($info['name']) ? $info['name']['value'] : '';
    				$org = isset($info['company']) ? $info['company']['value'] : '';
    				$adr = isset($info['address']) ? $info['address']['value'] : '';
    			}
    			$val['FN'] = $fn;
    			$val['ORG'] = $org;
    			$val['ADR'] = $adr;
    		}
    	}

    	//分页
    	$page = getpage($listRst['data']['numfound'],$this->rows);
    	$this->assign('pagedata',$page->show());
    	$this->assign('list', $list);
    }

    /**
     * 显示二度人脉
     */
    public function secondConnections ()
    {
		$this->assign('menunow','rm');
		$this->assign('title','二度人脉');
        $params = array();
        $p = (I('get.p')> 1) ? I('get.p') : 1;
        $params['rows'] = $this->rows;
        $params['start'] = ($p - 1)*$params['rows'];

        $list = \AppTools::webService('\Model\Demo\Demo', 'getContactList', array('params'=>$params ));

        //分页
        $page = getpage($list['data']['numfound'],$this->rows);
        $this->assign('pagedata',$page->show());

        $this->assign('list',$list['data']['list']);
        $this->assign('keywords','');
        $this->display('Index/index');
    }

    /*
     * 同事
     * */
    public function getColleague(){
    	$this->assign('menunow','ts');

        $this->assign('title','同事');
        $session_info = session(MODULE_NAME);
        $params = array();
        $p = (I('get.p')> 1) ? I('get.p') : 1;
        $params['rows'] = $this->rows;
        $params['start'] = ($p - 1)*$params['rows'];

        $params['org'] = $session_info['company'];

        if(empty($params['org'])){
            $list = array('data'=>array());
            $list['data']['vcards'] = array();
            $list['data']['numfound'] = 0;
        }else{
            $list = \AppTools::webService('\Model\Demo\Demo', 'actionContactM', array('params'=>$params,'crud'=>'r' ));
        }

        //分页
        $page = getpage($list['data']['numfound'],$this->rows);
        $this->assign('pagedata',$page->show());

        $this->assign('list',$list['data']['vcards']);
        $this->assign('keywords','');
        $this->display('Index/colleague');
    }

    /*
     * 同行
     * */
    public function getPeer(){
    	$this->assign('menunow','th');
    	$this->assign('title','同行');

        $session_info = session(MODULE_NAME);
        $params = array();
        $p = (I('get.p')> 1) ? I('get.p') : 1;
        $params['rows'] = $this->rows;
        $params['start'] = ($p - 1)*$params['rows'];

        $params['category'] = $session_info['industry'];
        /*if(empty($params['category'])){
            $list = array();
            $list['data']['vcards'] = array();
        }else {*/
            $list = \AppTools::webService('\Model\Demo\Demo', 'actionContactM', array('params' => $params, 'crud' => 'r'));
        /*}*/
        //分页
        $page = getpage($list['data']['numfound'],$this->rows);
        $this->assign('pagedata',$page->show());

        $this->assign('list',$list['data']['vcards']);
        $this->assign('keywords','');
        $this->display('Index/peer');
    }

    /*
     * 搜索结果
     * */
    public function getSearchResult(){
    	$this->assign('menunow','search');
    	$this->assign('title','搜索结果');
        $p = (I('get.p')> 1) ? I('get.p') : 1;
        $params['rows'] = $this->rows;
        $params['start'] = ($p - 1)*$params['rows'];
        $params['vcard']= $keywords = I('get.keywords','','urldecode');
        $list = \AppTools::webService('\Model\Demo\Demo', 'actionContactM', array('params'=>$params ));
/*echo '<pre>';
print_r($list);die;*/
        //分页
        $page = getpage($list['data']['numfound'],$this->rows);
        $this->assign('pagedata',$page->show());

        $this->assign('list',$list['data']['vcards']);
        $this->assign('keywords',$keywords);
        $this->display('Index/search');
    }

    public function relationshipGraph ()
    {
        $params = array('userId' => $_SESSION[MODULE_NAME]['clientid']);
        $list = \AppTools::webService('\Model\Demo\Demo', 'getRelationshipByUserId', $params);
        print_r($list);
    }

    public function getAvatar()
    {
    	$url = I('clientid','A0lhg8hmfqHBzUhCoCYn6pSMba72C00000000752');
    	//$clientid = urlencode($clientid);
    	$idType = I('idType');//账号类型，聊天号，还是clientid
    	$apiurl = '/account/avatar'; 	//api地址
    	//输出图片
    	$defaultImage = WEB_ROOT_DIR . 'images/default/avatar_user_chat.png';
    	if(empty($url) || false==$this->getImageFromApi($url, $apiurl, true)) {
    		header('Content-type: image/png');
    		echo file_get_contents($defaultImage);
    	}
    }

    /**
     * 人脉关系
     */
    public function friendGraph(){
    	$this->assign('menunow','gxt');
		$this->assign('title','人脉关系图');
		$search = array('userId' => $_SESSION[MODULE_NAME]['clientid'],'rows'=>20);
		//$search = array('userId' => 'AyRzReaLQs3Hq07uTKhFvnlDhUQ8E00000019725','rows'=>30);
		$data = $this->echartsData($search);
		$this->display('friendGraph');
    }
    /**
     * 人脉关系图2
     */
    public function friendGraphDemo(){
    	$this->assign('menunow','gxtdemo');
    	$this->assign('title','人脉关系图Demo');
    	$search = array('userId' => $_SESSION[MODULE_NAME]['clientid'],'rows'=>20);
    	$rst1 = \AppTools::webService('\Model\Demo\Demo', 'getFriendGraphByUserId', $search);
    	$this->assign($rst1);    	
    	$this->display('friendGraph2');
    }
    /**
     * N度好友2
     */
    public function friendLink2()
    {
    	$level = I('level', 1, 'intval');
    	$rows  = I('rows',10, 'intval');
    	$level = $level < 2 ? 2 : $level;
    	$rows  = $rows < 5 ? 5 : $rows;
    	$this->assign('rows', $rows);
    	$this->assign('level', $level);
    	$this->assign('menunow','nlevel2');
    	$this->assign('title','N度人脉');
    	$search = array('userId' => $_SESSION[MODULE_NAME]['clientid'],'rows'=>$rows, 'level'=>$level);
    	$rst1 = \AppTools::webService('\Model\Demo\Demo', 'getNLevelsFriendByUserId', $search);
    	$this->assign($rst1);    
    	$this->display('friendGraph2');
    }

    /**
     * 人脉关系
     */
    public function friendLink()
    {
        $level = I('level', 1, 'intval');
        $rows  = I('rows',10, 'intval');
        $level = $level < 1 ? 1 : $level;
        $rows  = $rows < 5 ? 5 : $rows;
        $this->assign('rows', $rows);
        $this->assign('level', $level);
    	$this->assign('menunow','nlevel');
		$this->assign('title','N度人脉');
		$search = array('userId' => $_SESSION[MODULE_NAME]['clientid'],'rows'=>$rows, 'level'=>$level);
		//$search = array('userId' => 'AyRzReaLQs3Hq07uTKhFvnlDhUQ8E00000019725','rows'=>$rows, 'level'=>$level);
		$data = $this->echartsData($search, 'getNLevelsFriendByUserId');
		$this->display('friendGraph');
    }
    /**
     * 获得名片
     */
    public function showCard(){
    	$params = array('params'=>array('vcardid'=>I('cardid')));
    	$cardInfo = \AppTools::webService('\Model\Contact\ContactVcard', 'contactVcard', $params);
    	if($cardInfo['data']['numfound']>0 && $cardInfo['data']['vcards'][0]['picture'] != ''){
    		$imagePath = $cardInfo['data']['vcards'][0]['picture'];
    	}else{
    		$imagePath = U('/','','',true ).'images/bg_img_cardimg.jpg';
    	}
    	$extName = strtolower(array_pop(explode('.', $imagePath)));
    	switch ($extName) {
    		case 'png':
    		case 'gif':
    		case 'jpg':
    			$contentType = 'image/' . $extName;
    			break;
    		case 'bmp':
    			$contentType = 'image/vnd.wap.wbmp';
    			break;
    		default:
    			break;
    	}
    	header('Content-type: ' . $contentType);
    	echo file_get_contents($imagePath);
    }
    /**
     * 整理echarts绘图数据
     */
    protected function echartsData($params, $methodInModel='getFriendGraphByUserId'){
    	// 页面数据
    	$this->assign('moreScripts',array('js/jsExtend/echart/echarts.min'));
    	$color = array('#b21111','#f39707','#006538');
    	$return = array(
    			'nodeType'=> array('search'=>'搜索','user'=>'好友','company'=>'公司','card'=>'名片'),
    			'linkType' => array('Has'=>'名片','Work'=>'公司','Friend'=>'好友'),
    			'legend' => array('搜索','朋友','名片','公司'),
    			'color' => array('#b21111','#f39707','#006538','black')
    	);
    	$this->assign('params',$return);

    	// 整理数据
    	$result = \AppTools::webService('\Model\Demo\Demo', $methodInModel, $params);
    	$searchName = ''; // 高亮显示的节点名
    	$nodeArr = json_decode($result['nodes'],true);
    	$linkArr = json_decode($result['links'],true);
    	$nodes = $links = array();
    	// 节点数据
    	foreach ($nodeArr as $v){
    		$nodeV = isset($v['data'])?$v['data']:array();
    		switch($nodeV['type']){
    			case 'User':
    			    $label = $nodeV['name'];
    			    if ($nodeV['company']) {
    			        $label = $label. '/'.$nodeV['company'];
    			    }
    			    if ($nodeV['title']) {
    			        $label = $label. '/'.$nodeV['title'];
    			    }
    				// C('WEB_SERVICE_ROOT_URL')
    				$nodes[$nodeV['id']] = array('category'=>1,'draggable'=>true,
    				'symbol' => 'image://'.U('Demo/Index/getAvatar',array('clientid'=>$nodeV['userid']),'',true),
    				'symbolSize'=>[40,40],'label'=>$nodeV['name'],
    				'name'=>$label.'+'.$nodeV['id'],'type'=>'user');
    				$nodes[$nodeV['id']]['isSelf'] = 0;
    				if($nodeV['userid'] == $params['userId']){
    				    $nodes[$nodeV['id']]['isSelf'] = 1;
    					$nodes[$nodeV['id']]['category'] = 0;
    					$nodes[$nodeV['id']]['symbolSize'] = [65,65];
    					$nodes[$nodeV['id']]['name'] = '我' .'+'.$nodeV['id'] ;
    					$nodes[$nodeV['id']]['label'] = '我';
    					$searchName = $nodeV['name'].'+'.$nodeV['id'];
    				}
    				break;
    			case 'Company':
    				$nodes[$nodeV['id']] = array('category'=>2,'draggable'=>true,
    				'symbol' => 'image://'.U('/','','',true ).'/test/echarts/image/ps3.png',
    				'symbolSize'=>[50,50],'label'=>$nodeV['name'],
    				'name'=>$nodeV['name'].'+'.$nodeV['id'],'type'=>'company');
    				break;
    			case 'Card':
    				$nodes[$nodeV['id']] = array('category'=>3,'draggable'=>true,
    				'symbol' => 'image://'.U('Demo/Index/showcard',array('cardid'=>$nodeV['cardid']),'',true),
    				'symbolSize'=>[50,30],'label'=>$nodeV['name'],
    				'name'=>$nodeV['cardid'].'+'.$nodeV['id'],'type'=>'card');
    				break;
    			default:
    				;
    		}
    	}
    	// 关系线数据
    	foreach ($linkArr as $v){
    		$linkV = isset($v['data'])?$v['data']:array();
    		$links[] = array('source'=>$nodes[$linkV['source']]['name'], 'target'=> $nodes[$linkV['target']]['name'], 'label'=>$linkV['relationship'],'name'=>$linkV['relationship']);
    	}
    	$nodes = array_values($nodes);
    	$this->assign('nodes',$nodes);
    	$this->assign('links',$links);
    	$this->assign('searchName',$searchName);
    }
    /**
     * 服务器异常模板
     */
    public function noPermission ()
    {
    	$this->assign('return',isset($_GET['redirect']));
    	$this->display('../Public/nopermission');
    }
	/**
	 * 404页面模板
	 */
    public function error404 ()
    {
    	$this->display('../Public/error404');
    }
}
/* EOF */
