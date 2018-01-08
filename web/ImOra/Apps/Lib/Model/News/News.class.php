<?php
namespace Model\News;
/**
 * admin 资讯，问答 管理接口 API 相关接口
 * @author
 * @date   2015-12-21
 */
use Model\WebService;
class News extends WebService
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 批量操作
     * @param array $params
     * @return array
     */
    public function doMany($params){
        $webServiceRootUrl = C('API_BATCH');
        $crudMethod = parent::OC_HTTP_CRUD_C;
//         print_r($params);die;
        $params = array('object'=>json_encode($params));
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        $response = parseApi($response);
        return $response;
    }

    /**
     * 资源
     * @param array $params
     * @return array
     */
    public function resource($params){
        $webServiceRootUrl = C('API_NEWS_UNRESOURCE');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        $response = parseApi($response);
        return $response;
    }

    /**
     * 添加beta用户评论
     * @param array $params
     * @return array
     */
    public function postComment ($params = array())
    {
        $webServiceRootUrl = C('API_NEWS_BETA_COMMENT');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        $response = parseApi($response);

        return $response;
    }

    /**
     * 获取beta用户
     * @param array $params
     * @return array
     */
    public function getBetaUser ($params = array())
    {
        $webServiceRootUrl = C('API_NEWS_BETA_USER_GET');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        $response = parseApi($response);

        return $response;
    }



    /**
     * 获取评论
     * @param array $params
     * @return array
     */
    public function comment($params = array()){
        $webServiceRootUrl = C('API_NEWS_COMMENT');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        $response = parseApi($response);
        return $response;
    }

    /**
     * 获取评论(无需登录)
     * @param array $params
     * @return array
     */
    public function comment2($params = array()){
        $webServiceRootUrl = C('API_NEWS_UNCOMMENT');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        $response = parseApi($response);
        return $response;
    }

    /**
     * 修改评论
     * @param array $params
     * @return array
     */
    public function editComment($params = array()){
        $webServiceRootUrl = C('API_NEWS_EDIT_COMMENT');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        $response = parseApi($response);
        return $response;
    }

    /**
     * 添加资讯信息接口
     * @param array params 传参
     * 以下为数组中的传参内容
     * title true string 标题
     * content true string 内容
     * keyword true string 关键词
     * resource false array(files....)  文件资源  数组
     * @return showid返回资讯id
     */
    public function addContent($params = array()){
        // web service path
        $webServiceRootUrl =   C('API_NEWS_PUBLISH');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        if(!empty($params['image'])){
            $this->setUploadFile($params['image'], 'image');
        }
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }

    /**
     * 获取行业信息
     * @param array $params
     * @return array
     */
    public function getCategory($params = array()){
        $webServiceRootUrl = C('API_CATEGORY_GET');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        $response = parseApi($response);
        return $response;
    }

    /**
    * 获取资讯或问答信息列表接口
    * showid false string 问答/资讯ID
    * type false enum(ask,news) 类型 ask:问答 news:资讯
    * title false string  标题
    * content false string  内容
    * categoryid false int  资讯的行业id
    * clientid false string  用户id
    * name false string  用户姓名
    * commentcount false int  评论数量
    * datetime false string  发布时间
    * state false int  状态  1：待发布；2：发布待审核；3：审核成功；4：审核不成功
    * sorting false int  排序
    * @return 默认返回以上所有字段
    * */
    public function getContentList($params = array()){
        // web service path
        $webServiceRootUrl =   C('API_NEWS_GET');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        //print_r($params);die;
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);

        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }

    /**
    * 获取资讯或问答信息列表接口（不用登陆）
    * showid false string 问答/资讯ID
    * type false enum(ask,news) 类型 ask:问答 news:资讯
    * title false string  标题
    * content false string  内容
    * categoryid false int  资讯的行业id
    * clientid false string  用户id
    * name false string  用户姓名
    * commentcount false int  评论数量
    * datetime false string  发布时间
    * state false int  状态  1：待发布；2：发布待审核；3：审核成功；4：审核不成功
    * sorting false int  排序
    * @return 默认返回以上所有字段
    * */
    public function getContentList2($params = array()){
        // web service path
        $webServiceRootUrl =   C('API_NEWS_GET_NOLOGIN');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);

        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }

    /**
     * 获取常见问题和新人帮助信息列表接口（不用登陆）
     * questionid false string 问题id
     * languageid false string 语言编号
     * question false string  问题
     * answer false string  答案
     * sort false string  排序
     * statue false int  状态
     * typeid false int  常见问题 or  新人帮助
     * @return 默认返回以上所有字段
     * */
    public function getProblemsContentList($params = array()){
        // web service path
        $webServiceRootUrl =   C('API_FAQ_QUESTION');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);

        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }

    /**
     * 更改资讯状态接口
     * showid string true 资讯id
     * state  状态  1：暂存待提交（包括审核未通过）；2：发布待审核；3：审核成功（待推送）；5：删除;6已推送；
     * @return status
     * */
    public function updateNews($params = array()){
        // web service path
        $webServiceRootUrl =   C('API_NEWS_EDIT');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        if(isset($params['image']) && !empty($params['image'])){
            $this->setUploadFile($params['image'], 'image');
        }

        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }


    /**
     * 删除资讯接口
     * showid string true 资讯id
     * @return status
     * */
    public function delNews($params){

        // web service path
        $webServiceRootUrl =   C('API_NEWS_DELETE');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }


    /**
     * 上传图片接口
     * @param resource file true 资源路径
     * @return array
     * */
    public function uploadPic($resource){
        // web service path
        $webServiceRootUrl =   C('API_PICTURE_UPLOAD');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $this->setUploadFile($resource, 'resource');
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $resource);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }

    /**
     * 获取上传图片接口
     * @param string $uploadid true 资源路径
     * @return array
     * */
    public function getUploadPic($params){
        // web service path
        $webServiceRootUrl =   C('API_PICTURE_UPLOAD');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        //print_r($params);die;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }

    /**
     * 获取问答资讯评论接口
     * @param string $showid true 资源路径
     * @return array
     * */
    public function getNewComment($showid){
        // web service path
        $webServiceRootUrl =   C('API_NEWS_COMMENT');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $params['showid'] = $showid;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }

    /**
     * 获取资讯接口
     * @param string
     * @return array
     * */
    public function getNewsList($params){
        // web service path
        $webServiceRootUrl =   C('API_NEWS_GET');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }

    /**
     * 待推送资讯-推送设置接口
     * @param array
     * @return array
     * */
    public function pushSet($params){
        // web service path
        $webServiceRootUrl =   C('API_NEWS_PUSH_SETTING');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }

    /*
  *获取橙脉小秘书内容
  */
    public function getSecretary($params){
        $webServiceRootUrl =   C('API_CREATE_OPERATION');
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        //$response = array ( 'status' => 0, 'msg' =>'', 'data' => array('content'=>"北京橙鑫数据有限公司(以下简称橙鑫数据)成立于2013年，由橙鑫数据科技（香港）有限公司全额投资，目前已投入上亿美元进行智能移动终端和云服务平台自主研发。"));
        return $response;
    }

    /**
     * 获取活动内容详情
     * @param $params
     * @return array
     */
    public function getActivityInfo($params){
        // $webServiceRootUrl =   C('API_NEWS_GET');
        //$crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        //$response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        //$response = parseApi($response);
        $response = array ( 'status' => 0, 'msg' =>'', 'data' => array('content'=>"北京橙鑫数据有限公司(以下简称橙鑫数据)成立于2013年，由橙鑫数据科技（香港）有限公司全额投资，目前已投入上亿美元进行智能移动终端和云服务平台自主研发。"));
        return $response;
    }

    /**
     * 获取卡类型协议
     * @param $params = array('id'=>$id)
     * @return array
     */
    public function getCardTypeAgreement($params){
        $webServiceRootUrl =   WEB_SERVICE_ROOT_URL."/account/orange/getagreement";
        $crudMethod = parent::OC_HTTP_CRUD_R;
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        //* 解析http 请求
        $response = parseApi($response);
        return $response;
    }
}