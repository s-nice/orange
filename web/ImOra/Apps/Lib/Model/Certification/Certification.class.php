<?php
namespace Model\Certification;

/**
 * 账号认证model
 */
use Model\WebService;
class Certification extends WebService
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取账户认证状态
     * @return array
     * */
    public function getCertificationStatus()
    {
        return 0;
        // web service path
        $webServiceRootUrl =   C('API_CERTIFICATION');
        $crudMethod = parent::OC_HTTP_CRUD_R;

        return $this->callAndParseApi($webServiceRootUrl, $crudMethod);
    }

    /**
     * 获取企业账户认证进度
     * @return array
     *
     * */

    public function getCertification_noused()
    {
        $virtualData=array();
        for($i=0;$i<4;$i++){
            $arr['time']=date('Y-m-d h:s',time()+($i*1000));
            $arr['status']=0;
            $arr['state']='营业执照内容模糊，无法完成审核，请重新上传。';
            array_push($virtualData,$arr);
        }
        return $virtualData;
        $webServiceRootUrl =   C('API_CERTIFICATION');
        $crudMethod = parent::OC_HTTP_CRUD_R;

        return $this->callAndParseApi($webServiceRootUrl, $crudMethod);
    }
}