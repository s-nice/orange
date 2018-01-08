<?php
namespace Model\Upload;
/**
 * 上传文件到API接口
 */
use Model\WebService;
class Upload extends WebService
{
    /**
     * 上传文件到API接口， API返回上传后的路径和id
     * @param string $filepath
     * @return array
     */
    public function uploadFile($filepath)
    {
        $webServiceRootUrl =   C('API_PICTURE_UPLOAD');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $this->setUploadFile($filepath, 'resource');
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }

    /**
     * 上传文件数组到API接口， API <b style="color:red;">只</b>返回上传后的路径
     * @param string $filepathList 上传文件路径列表
     * @return array
     */
    public function uploadFilesWithoutIds ($filepathList)
    {
        foreach ($filepathList as $key=>$filepath) {
            if (! is_file($filepath)) {
                unset($filepathList[$key]);
            }
        }
        $webServiceRootUrl =   C('API_PICTURE_UPLOAD');
        $crudMethod = parent::OC_HTTP_CRUD_C;
        $this->setUploadFile($filepathList, 'file');
        // 发送http请求
        $response = $this->request($webServiceRootUrl, $crudMethod);
        //* 解析http 请求
        $response = parseApi($response);

        return $response;
    }
}