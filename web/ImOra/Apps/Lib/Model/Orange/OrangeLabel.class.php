<?php
namespace Model\Orange;
use Model\WebService;
class OrangeLabel extends WebService
{
    /**
     * orange 标签管理 操作接口(添加、修改、删除、查询)
     * @param Array $params 标签管理类型操作参数
     * @param Int   $type  标签管理请求类型 1 ：操作标签 2：操作标签类型
     * @param string $crud  API的crud操作请求
     * @return Array
     */
    public function doRequest($params=array(),$type=1, $crud='R')
    {
        // 设置请求方法为 新建
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $crud = strtoupper($crud);
        switch ($crud){
            case 'R'://获取
                $webServiceRootUrl = $type==1 ? C("API_ORANGE_TAG") :C("API_ORANGE_TAG_TYPE");
                $crudMethod = parent::OC_HTTP_CRUD_R;
                break;
            case 'C'://创建
                $webServiceRootUrl = $type==1 ? C("API_ORANGE_TAG") :C("API_ORANGE_TAG_TYPE_ADD");
                break;
            case 'D'://删除
                $webServiceRootUrl = $type==1 ? C("API_ORANGE_LABEL_DEL") : C("API_ORANGE_LABEL_TYPE_DEL");
                break;
            case 'U'://修改 只有标签修改
                $webServiceRootUrl = $type==1 ? C("API_ORANGE_LABEL_EDIT") : C("API_ORANGE_LABEL_TYPE_EDIT") ;
                break;
            default:
                trace('File:'.__FILE__.' LINE:'.__LINE__."\r\n".' 标签管理model传参错误 '.var_export(func_get_args(),true));
                return;
        }
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);

        return parseApi($response);
    }

    public function manageLabel($params=array(),$type=1, $crud='R')
    {
        return $this->doRequest($params, $type, $crud);
    }


}
?>