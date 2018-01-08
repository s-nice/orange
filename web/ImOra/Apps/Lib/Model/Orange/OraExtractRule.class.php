<?php

namespace Model\Orange;
use Model\WebService;


class OraExtractRule extends WebService{
    /**
     *  提取规则列表(预警信息规则) 操作接口(查询 )
     * @param Array $params 单位详情操作参数
     * @param string $crud  API的crud操作请求
     * @return Array
     */

    private function doRequest($params=array(), $crud='R')
    {
        // 设置请求方法为 新建
        $crudMethod = parent::OC_HTTP_CRUD_R;
        $crud = strtoupper($crud);
        switch ($crud){
            case 'R'://获取
                $webServiceRootUrl = C("API_ORANGE_EXTRACT_RULE_GET");
                break;
            default:
                trace('File:'.__FILE__.' LINE:'.__LINE__."\r\n".' 提取规则列表model传参错误 '.var_export(func_get_args(),true));
                return;
        }
        $response = $this->request($webServiceRootUrl, $crudMethod, $params);
       return json_decode($response,true);
        //return parseApi($response);
    }

    public function manageExtractRule($params=array(), $crud='R')
    {
        return $this->doRequest($params, $crud);
    }



}
/*EOF*/
