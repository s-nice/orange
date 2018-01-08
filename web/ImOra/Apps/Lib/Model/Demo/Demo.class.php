<?php
namespace Model\Demo;
/*
 * admin 个人中心
 * @author wuzj
 * @date   2015-12-23
 */
use Model\WebService;
class Demo extends WebService
{
	private $_nodeIds = array();//存储neo4j第二次查询的所有节点id，供第三次查询时，使用
    public function __construct()
    {
        parent::__construct();
    }

    /*
    * 个人中心人脉操作model
    * @param array $params
    * @param array $crud
    * @return array
    * */
    public function actionContactM($params = array(),$crud = 'r'){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/contact/elassearch';
        switch($crud){
            case 'c':
                $crudMethod = parent::OC_HTTP_CRUD_C;
                break;
            case 'u':
                $crudMethod = parent::OC_HTTP_CRUD_U;
                break;
            case 'd':
                $crudMethod = parent::OC_HTTP_CRUD_D;
                break;
            default :
                    $crudMethod = parent::OC_HTTP_CRUD_R;
        }

        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }

    /**
     * 获取二度人脉列表
     * @param array|array $params 接口参数
     * @return array
     */
    public function getContactList($params = array()){
        // web service path
        $webServiceRootUrl =   C('WEB_SERVICE_ROOT_URL').'/relation/apistore/secfriend';
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }

    /**
     * 获取好友列表
     * @param array|array $params 接口参数
     * @return array
     */
    public function getFriendsList($params = array())
    {
        // web service path
        $webServiceRootUrl =   C('API_CONTACT_VCARD');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }

    /**
     * 获取我看过谁，谁看过我的名片
     * @param array|array $params 接口参数
     * @return array
     */
    public function getAlredySeeVcard($params = array())
    {
    	// web service path
    	$webServiceRootUrl =   C('API_CARD_SEE_PERSON');
    	$crudMethod = parent::OC_HTTP_CRUD_R;
    	// 发送http请求
    	$response = $this->request($webServiceRootUrl, $crudMethod, $params);
    	//* 解析http 请求
    	$response = parseApi($response);
    	return $response;
    }

    /**
     * 根据用户ID获取Neo4j中的人脉关系网
     * @param string $userId 用户id
     * @param int $page 页码：从0开始
     * @param int $rows 返回的行数
     * @return unknown
     */
    public function getRelationshipByUserId ($userId, $page=0, $rows=25)
    {
        settype($page, 'int');
        settype($rows, 'int');
        $startPos = $page * $rows;
        $statements = "MATCH (n)-[r]-() WHERE n.userid=\\\"%s\\\" RETURN r skip %d  LIMIT %d";
        $statements = sprintf($statements, $userId, $startPos, $rows);

        return $this->queryNeo($statements);
    }

    /**
     * 通过请求的查询语句和参数向Neo查询
     * @param string $statement
     * @return \ErrorCoder
     */
    public function queryNeo ($statement, $parameters=null)
    {
        //static $url = null;
        //if (! $url) {
            $url = $this->getNeoTransactionUrl();
        //}
        $parameters = isset($parameters) ? $parameters : 'null';
        $rawBody = '{
                      "statements": [
                        {
                          "statement": "%s",
                          "parameters": %s,
                          "resultDataContents": [
                            "row",
                            "graph"
                          ],
                          "includeStats": true
                        }
                      ]
                    }';
        $rawBody = sprintf($rawBody, $statement, $parameters);
        $response = $this->sendQueryToNeo($url, $rawBody);

        return $response;
    }

    /**
     * 向指定的NeoURL发送查询请求
     * @param string $url 请求的URL
     * @param string $rawBody 请求的主体字符串
     * @return mixed
     */
    protected function sendQueryToNeo ($url, $rawBody)
    {
        $neo4jInfo = C('Neo4j');
        // 组装验证方式
        $authorization = 'Basic ' . base64_encode($neo4jInfo['user'] . ':' . $neo4jInfo['pass']);
        $headers = array('Authorization' => $authorization,
                         'Content-Type'  => 'application/json;charset=utf-8',
                         'X-stream'      => 'true'
        );
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $this->setRawBody($rawBody);
        $params = array();
        // 发送http请求
        $response = $this->request($url, $crudMethod, $params, $headers);
        //* 解析http 请求
        $resonse = json_decode($response, true);

        return $resonse;
    }

    /**
     * 获取Neo4j事务请求的临时URL
     * @return mixed
     */
    protected function getNeoTransactionUrl ()
    {
        $neo4jInfo = C('Neo4j');
        // web service path
        $webServiceRootUrl =   $neo4jInfo['url'];
        $rawBody = '{"statements": []}';
        $response = $this->sendQueryToNeo($webServiceRootUrl, $rawBody);
        $url = $response['commit'];

        return $url;
    }

    /**
     * 根据用户ID获取Neo4j中的我看过谁关系网
     * @param string $userId 用户id
     * @param int $page 页码：从0开始
     * @param int $rows 返回的行数
     * @return unknown
     */
    public function getISeeRelationshipByUserId ($userId, $page=0, $rows=25)
    {
    	settype($page, 'int');
    	settype($rows, 'int');
    	$startPos = $page * $rows;
    	$statements = "MATCH p=(user:User{userid:\\\"%s\\\"})-[r:SeeCard]->(card:Card)<-[r1:Has]-() RETURN p skip %d  LIMIT %d";
    	$statements = sprintf($statements, $userId, $startPos, $rows);
    	$result = $this->queryNeo($statements);
    	$list = $this->_parseNeo4j1($result,'cycoscape');
    	$this->_nodeIds = array_keys($this->_nodeIds);
    	$list2 = $this->getISeeRelationshipByNode($this->_nodeIds,$this->_nodeIds);
    	$list2 = $this->_parseNeo4j1($list2,'cycoscape');
    	return $list2;
    }
    /**
     * 查询我看过谁|card-user-company关系--二次查询  通用
     * @param unknown $node_ids
     * @param unknown $new_node_ids
     * @return Ambigous <ErrorCoder, mixed>
     */
    public function getISeeRelationshipByNode ($node_ids=array(),$new_node_ids=array())
    {
    	settype($page, 'int');
    	settype($rows, 'int');
    	$startPos = $page * $rows;
    	$parameters = array('new_node_ids'=>$new_node_ids,'node_ids'=>$node_ids);
    	$parameters = json_encode( $parameters);
    	$statements = "MATCH (a)-[r]->(b) WHERE id(a) IN {node_ids} AND id(b) IN {new_node_ids} RETURN r";
    	return $this->queryNeo($statements,$parameters);//
    }

    /**
     * 根据用户ID获取Neo4j中的名片公司好友关系数据
     * @param string $userId 用户id
     * @param int $page 页码：从0开始
     * @param int $rows 返回的行数
     * @return array $list
     */
    public function getFriendGraphByUserId ($userId, $page=0, $rows=25)
    {
    	settype($page, 'int');
    	settype($rows, 'int');
    	$startPos = $page * $rows;
    	$statements = "MATCH p=(card:Card)<-[r:Has]-(user:User{userid:\\\"%s\\\"})-[r1:Friend]-(:User) RETURN p skip %d  LIMIT %d union MATCH p=(company:Company)-[]-(user:User{userid:\\\"%s\\\"})-[r1:Friend*1..3]-(:User) return p skip %d  LIMIT %d";
    	$statements = sprintf($statements, $userId, $startPos, $rows, $userId, $startPos, $rows);
    	$result = $this->queryNeo($statements);
    	$list = $this->_parseNeo4j1($result);
    	$this->_nodeIds = array_keys($this->_nodeIds);
    	$list2 = $this->getISeeRelationshipByNode($this->_nodeIds,$this->_nodeIds);
    	$list2 = $this->_parseNeo4j1($list2);
    	return $list2;
    }

    /**
     * 根据用户ID获取Neo4j中的N度好友关系数据
     * @param string $userId 用户id
     * @param int $page 页码：从0开始
     * @param int $rows 返回的行数
     * @return array $list
     */
    public function getNLevelsFriendByUserId ($userId, $level=3, $page=0, $rows=25)
    {
    	settype($page, 'int');
    	settype($rows, 'int');
    	settype($level, 'int');
    	$startPos = $page * $rows;
    	$statements = "MATCH p=(user:User{userid:\\\"%s\\\"})-[r1:Friend*1..%d]-(:User) return p skip %d  LIMIT %d";
    	$statements = sprintf($statements, $userId, $level, $startPos, $rows);
    	$result = $this->queryNeo($statements);
    	$list = $this->_parseNeo4j1($result);
    	$this->_nodeIds = array_keys($this->_nodeIds);
    	$list2 = $this->getISeeRelationshipByNode($this->_nodeIds,$this->_nodeIds);
    	$list2 = $this->_parseNeo4j1($list2);
    	return $list2;
    }

    /**
     * 我看过谁->解析数据返回的接
     * @param array() $result
     * @return multitype:
     */
    public function _parseNeo4j1($result,$type='echart')
    {
    	$results = $result['results'][0]['data'];
    	$nodeArr = $linkArr  =  array();
    	$i = 0;
    	if($results){
    		foreach ($results as $key=>$val){
    			$graph = $val['graph'];
    			$nodes = $graph['nodes'];
    			$relationships = $graph['relationships'];
    			foreach ($nodes as $val){//解析节点数组
    				$node = $this->_parseNodes($val,$type);
    				$nodeArr[$node['data']['id']] = $node;
    				$this->_nodeIds[$node['data']['id']] = 0; //取得所有的节点ids
    			}
    			foreach ($relationships as $val){//解析关系数组
    				$linkArr[] =  array('data'=>array(
    						'relationship' => $val['type'],
    						'source' => $val['startNode'],
    						'target' => $val['endNode'],
    						'classes' =>  $val['type'],
    						'faveColor' => $val['type'] == 'SeeCard' ? '#FFAEB9' : '#C2C2C2'
    				));
    			}

    		}
    		$nodeArr = array_values($nodeArr);
    	}
    	$params = array('nodes'=>$nodeArr,'links'=>$linkArr);
    	$params = array_map('json_encode', $params);
    	return $params;
    }
    private function _parseNodes($nodes,$type='echart')
    {
    	$rtn = $rst = array();
    	$labelype = $nodes['labels'][0]; //User Company Card
    	switch ($labelype){
    		case 'User':
    			$name = $nodes['properties']['name'];
    			$company = $nodes['properties']['company'];
    			$title = $nodes['properties']['title'];
    			$show  = $name.(empty($company)?'':' '.$company).(empty($title)?'':' '.$title);
    			$nameKey = $type == 'echart' ? 'name' : 'name';
    			$rst = array(
    				$nameKey => $name,
	    			'company' => $company,
	    			'title' => $nodes['properties']['title'],
	    			'userid' => $nodes['properties']['userid'],
	    			'show'=> $show
    			);
    			break;
    		case 'Company':
    			$rst = array(
	    			'name' => $nodes['properties']['name'],
	    			'show' => $nodes['properties']['name'],
    			);
    			break;
    		case 'Card':
    			$rst = array(
	    			'name' => '名片',
	    			'cardid' => $nodes['properties']['cardid'],
    			);
    			break;
    		default:
    	}
    	$rst['id'] = $nodes['id'];
    	$rst['type'] = $labelype;
    	$rtn['data'] = $rst;//User Company Card
    	return $rtn;
    }


}
