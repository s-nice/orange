<?php
namespace Model\Orange;
use Model\WebService;
class OrangeWarningSet extends WebService
{
    /**
     * orange 预警设置接收人 操作接口(添加 ，删除，查询)
     * @param Array $params 预警设置接收人操作参数
     * @param string $crud  API的crud操作请求
     * @return Array
     */
    public function doRequest($params=array(), $crud='R')
    {
        // 设置请求方法为 新建
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $crud = strtoupper($crud);
        switch ($crud){
            case 'R'://获取
                $webServiceRootUrl = C("API_ORANGE_WARNING_SET_USER_GET");
                $crudMethod = parent::OC_HTTP_CRUD_R;
                break;
            case 'C'://创建
                $webServiceRootUrl = C("API_ORANGE_WARNING_SET_USER_ADD");
                break;
            case 'D'://删除
                $webServiceRootUrl = C("API_ORANGE_WARNING_SET_USER_DEL");
                break;
            /*case 'U'://修改
                $webServiceRootUrl = C("API_ORANGE_ALIAS_EDIT");
                break*/;
            default:
                trace('File:'.__FILE__.' LINE:'.__LINE__."\r\n".' 预警设置接收人model传参错误 '.var_export(func_get_args(),true));
                return;
        }
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);

        return parseApi($response);
    }

    public function manageWarningSetUser($params=array(), $crud='R')
    {
        return $this->doRequest($params, $crud);
    }

    /**
     * 获取预警设置，失败几次后预警
     *
     *
     * */

    public function getWarningSetNum(){
        $webServiceRootUrl=C("API_ORANGE_WARNING_NUM_GET");
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $response = $this->request($webServiceRootUrl, $crudMethod, array());
        return parseApi($response);


    }

    /**
     * 修改预警设置，失败几次后预警
     * param  int $int 修改的次数
     *
     * */

    public function editWarningSetNum($int){
        $webServiceRootUrl=C("API_ORANGE_WARNING_NUM_EDIT");
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $params=array('warningnum'=>$int);
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
        return parseApi($response);


    }


}