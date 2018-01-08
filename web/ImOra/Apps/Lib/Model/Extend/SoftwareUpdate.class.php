<?php
namespace Model\Extend;
import('ErrorCoder', LIB_ROOT_PATH . 'Classes/');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class SoftwareUpdate
{
    private $_xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
            <root>
              <md5><![CDATA[%s]]></md5>
              <fromVersion><![CDATA[%s]]></fromVersion>
              <toVersion><![CDATA[%s]]></toVersion>
              <desc><![CDATA[%s]]></desc>
              <url><![CDATA[%s]]></url>
              <size><![CDATA[%s]]></size>
              <addTime><![CDATA[%s]]></addTime>
              <zipName><![CDATA[%s]]></zipName>
              <store><![CDATA[%s]]></store>
              <newfn><![CDATA[%s]]></newfn>
            </root>";
/*    private $_xmlApp = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
            <root>
              <md5><![CDATA[%s]]></md5>
              <fromVersion><![CDATA[%s]]></fromVersion>
              <toVersion><![CDATA[%s]]></toVersion>
              <desc><![CDATA[%s]]></desc>
              <url><![CDATA[%s]]></url>
            </root>";*/

    private $_ini = "; this file is generated automatically.\n\n%s";

    /**
     * Set current version of Terminal software
     * @param string $version The current version representation string
     * @return bool
     */
    public function setCurrentVersion($version)
    {
        $versionFile = C('UPDATE_PACKAGE_STORAGE_PATH') . 'version.ini';
        $iniLine = 'CurrentVersion = ' . $version;
        $content = sprintf($this->_ini, $iniLine);
        $result = file_put_contents($versionFile, $content)>0;

        return $result;
    }

    /**
     * Get current set software version
     * @return string
     */
    public function getCurrentVersion ()
    {
        $version = null;
        $iniInfo = null;
        $versionFile = C('UPDATE_PACKAGE_STORAGE_PATH') . 'version.ini';
        if (is_file($versionFile)) {
            $iniInfo = @ parse_ini_file($versionFile);
        }
        if(is_array($iniInfo) && isset($iniInfo['CurrentVersion'])) {
            $version = $iniInfo['CurrentVersion'];
        }

        return $version;
    }

    /**
     * Generate a new update description xml file
     * @param string $fromVersion
     * @param string $toVersion
     * @param string $desc
     * @param string $zipUrl
     * @return ErrorCoder|number
     */
    public function addXml($md5,$fromVersion, $toVersion, $desc, $zipUrl, $size, $addTime,$zipName,$store,$newfn)
    {
        $filepath = $this->getFilePath($fromVersion, $toVersion);
        if (file_exists($filepath)) {
            return new \ErrorCoder(\ErrorCoder::ERR_FILE_EXISTING);
        }
        $xmlContent = sprintf($this->_xml,$md5, $fromVersion, $toVersion, $desc, $zipUrl, $size,$addTime,$zipName,$store,$newfn);
        $result = file_put_contents($filepath, $xmlContent);

        return $result;
    }

    /**
     * Get files list
     * @return array
     */
    public function getFilesList ($extension)
    {
        $dir  = C('UPDATE_PACKAGE_STORAGE_PATH');
        $files = glob($dir .'App'. DIRECTORY_SEPARATOR .'*.'.$extension);
        return $files;
    }

    /**
     * Update description file
     * @param unknown $fromVersion
     * @param unknown $toVersion
     * @param unknown $desc
     * @param unknown $zipUrl
     * @return bool
     */
    public function updateXml($md5,$fromVersion, $toVersion, $desc, $zipUrl)
    {
        $filepath = $this->getFilePath($fromVersion, $toVersion);
        $xmlContent = sprintf($this->_xml,$md5,$fromVersion, $toVersion, $desc, $zipUrl);
        $result = file_put_contents($filepath, $xmlContent)>0;

        return $result;
    }

    /**
     * Delete description file
     * @param unknown $fromVersion
     * @param unknown $toVersion
     * @return bool
     */
    public function deleteXml($fromVersion, $toVersion)
    {
        $filepath = $this->getFilePath($fromVersion, $toVersion);
        $result = @unlink($filepath);

        return $result;
    }

    /**
     * Get description file path
     * @param unknown $fromVersion
     * @param unknown $toVersion
     * @return string
     */
    public function getFilePath($fromVersion, $toVersion)
    {
        if (!$fromVersion || $fromVersion=='*') {
            $fromVersion = 'common';
        }
        $filepath = C('UPDATE_PACKAGE_STORAGE_PATH') .'App'. DIRECTORY_SEPARATOR
            . $fromVersion . '_To_' . $toVersion . '.xml';
        return $filepath;
    }

    /**
     * Get xml file content
     * @param string $fromVersion
     * @param string $toVersion
     * @param string $filename
     * @return string
     */
    public function getXmlContent($fromVersion, $toVersion, $filename='')
    {
        if ($filename) {
            $xmlFile = C('UPDATE_PACKAGE_STORAGE_PATH') . $filename;
        }

        if (!isset($xmlFile) || !is_file($xmlFile)){
            $xmlFile = $this->getFilePath($fromVersion, $toVersion);
        }
        $content = '';
        if (is_file($xmlFile)) {
            $content = file_get_contents($xmlFile);
        }
        return $content;
    }


    /**
     * Set App current version of Terminal software
     * @param string $version The current version representation string
     * @return bool
     */
    public function setCurrentVersionApp($version)
    {
        $versionFile = C('UPDATE_PACKAGE_STORAGE_PATH') . 'versionApp.ini';
        $iniLine = 'AppCurrentVersion = ' . $version;
        $content = sprintf($this->_ini, $iniLine);
        $result = file_put_contents($versionFile, $content)>0;

        return $result;
    }

    /**
     * Get App current set software version
     * @return string
     */
    public function getCurrentVersionApp ()
    {
        $version = null;
        $iniInfo = null;
        $versionFile = C('UPDATE_PACKAGE_STORAGE_PATH') . 'versionApp.ini';
        if (is_file($versionFile)) {
            $iniInfo = @ parse_ini_file($versionFile);
        }
        if(is_array($iniInfo) && isset($iniInfo['AppCurrentVersion'])) {
            $version = $iniInfo['AppCurrentVersion'];
        }
        return $version;
    }

    /**
     * Generate App a new update description xml file
     * @param string $toVersion
     * @param string $desc
     * @param string $zipUrl
     * @return ErrorCoder|number
     */
    public function addXmlApp($md5,$fromVersion, $toVersion, $desc, $zipUrl)
    {
        $filepath = $this->getFilePathApp($fromVersion, $toVersion);
//         if (file_exists($filepath)) {
//             return new ErrorCoder(ErrorCoder::ERR_FILE_EXISTING);
//         }
        $xmlContent = sprintf($this->_xmlApp,$md5,$fromVersion, $toVersion, $desc, $zipUrl);
        $result = file_put_contents($filepath, $xmlContent);
        return $result;
    }

    /**
     * Get App files list
     * @param mixed array $extension 待获取文件的扩展名
     * @return array
     */
    public function getFilesListApp ($extension)
    {
        $dir  = C('UPDATE_PACKAGE_STORAGE_PATH');
        if(is_array($extension)) {
            $extension = '{'.join(',', $extension).'}';
            $files = glob($dir . 'App'. DIRECTORY_SEPARATOR .'*.'.$extension, GLOB_BRACE);
        } else {
            $files = glob($dir . 'App'. DIRECTORY_SEPARATOR .'*.'.$extension);
        }

        return $files;
    }

    /**
     * Update App description file
     * @param unknown $fromVersion
     * @param unknown $toVersion
     * @param unknown $desc
     * @param unknown $zipUrl
     * @return bool
     */
    public function updateXmlApp($fromVersion, $toVersion,$md5, $desc, $zipUrl)
    {
        $filepath = $this->getFilePathApp($fromVersion, $toVersion);
        $xmlContent = sprintf($this->_xmlApp,$md5,$fromVersion,$toVersion, $desc, $zipUrl);
        $result = file_put_contents($filepath, $xmlContent)>0;
        return $result;
    }

    /**
     * Delete App description file
     * @param unknown $toVersion
     * @return bool
     */
    public function deleteXmlApp($fromVersion, $toVersion)
    {
        $filepath = $this->getFilePathApp($fromVersion, $toVersion);
        $result = @unlink($filepath);

        return $result;
    }

    /**
     * Get App description file path
     * @param unknown $fromVersion
     * @param unknown $toVersion
     * @return string
     */
    public function getFilePathApp($fromVersion, $toVersion)
    {
        if (!$fromVersion || $fromVersion=='*') {
            $fromVersion = 'common';
        }
        $filepath = C('UPDATE_PACKAGE_STORAGE_PATH') .'App'. DIRECTORY_SEPARATOR
            . $fromVersion . '_To_' . $toVersion . '.xml';

        return $filepath;
    }

    /**
     * Get App xml file content
     * @param string $fromVersion
     * @param string $toVersion
     * @param string $filename
     * @return string
     */
    public function getXmlContentApp($fromVersion, $toVersion, $filename='')
    {
        if ($filename) {
            $xmlFile = C('UPDATE_PACKAGE_STORAGE_PATH') . $filename;
        }
        if (!isset($xmlFile) || !is_file($xmlFile)){
            $xmlFile = $this->getFilePathApp($fromVersion, $toVersion);
        }
        $content = '';
        if (is_file($xmlFile)) {
            $content = file_get_contents($xmlFile);
        }

        return $content;
    }

    /**
     * 获取文件夹所有格式更新包列表(完整路径)，和文件名列表；
     * @return array
     */
    public function getALLFilesList(){
        $arrExtension=C('EXTENSION_PER_PAGE_OF_SOFTWARE_UPDATE');
        $fileList=[];//文件路径列表
        foreach($arrExtension as $extension){
            $fileList=array_merge($fileList,$this->getFilesList($extension));
        }
        return $fileList;

    }
    /**
     * 获取获取已添加更新包的xml文件数据
     * @return array
     */
    public function getXmlData()
    {
        $xmlList = $this->getFilesList('xml');
        if (!empty($xmlList)) { //判断文件列表是否存在
            $k = 0;
            $count = count($xmlList);//总条目
            for ($i = 0; $i<$count; $i++) { //获取全部xml文件数据
                $xmlArray = simplexml_load_file($xmlList[$i]);
                if (false != $xmlArray) {
                    foreach ($xmlArray as $key => $value) {//循环出数据
                        $allList[$k][$key] = (string)$value;
                    }
                }
                $k++;
            };

        }
        return $allList;
    }



    /**
     * 获取已经添加的更新包列表
     * @param int $p
     * @param string $sort
     * @return array
     */
    public  function getUpLoadList($p,$sort){
        $xmlList =$this->getFilesList('xml');
        $numberPerPage = C('NUMBER_PER_PAGE_OF_SOFTWARE_UPDATE', NULL, 10);
        if(null != $xmlList) { //判断文件列表是否存在
            $count=count($xmlList);//总条目
            $p = $p<1 ? 1 : $p; //当页数小于1 页数为1
            $p = $p>ceil($count/ $numberPerPage) ? ceil($count/ $numberPerPage) : $p; //当页数大于总页数，页数为最大页数
            $start=($p-1)*$numberPerPage; //开始条目
            $end=$p*$numberPerPage-1; //结束条目
            $allList=$this->getXmlData(); //获取全部xml文件数据
            /*列表排序*/
            foreach($allList as $value){
                $addTime[]=$value['addTime'];
                $size[]=$value['size'];
                $toVersion[]=$value['toVersion'];

            }
            switch($sort){
                case 'desc_size'://文件大小降序
                    array_multisort($size, SORT_DESC, $allList);
                    break;
                case 'asc_size'://文件大小升序
                    array_multisort($size, SORT_ASC, $allList);
                    break;
                case 'desc_toVersion': //更新版本降序
                    array_multisort($toVersion, SORT_DESC, $allList);
                    break;
                case 'asc_toVersion':
                    array_multisort($toVersion, SORT_ASC, $allList);
                    break;
                case 'desc_addTime':
                    array_multisort($addTime, SORT_DESC, $allList);
                    break;
                case 'asc_addTime'://添加时间升序
                default:
                    array_multisort($addTime, SORT_ASC, $allList);
                    break;
            }

            for($j=$start;$j<=$end;$j++){ //排序后的数据
                if(isset($allList[$j])){
                    $list[]=$allList[$j];
                }else{
                    break;
                }
            }

            $pagedata=getpage($count,$numberPerPage)->show();//分页
            $data['list']=$list ? $list :'NO DATA'; //列表
            $data['pagedata']=$pagedata;
            $data['start']=$start; //开始条目
            $data['count']=$count;//总条目
            return  $data;
        }else{
            return null;
        }

    }
    /**
     *获取未添加的服务器中更新包列表
     */
    public  function getZipList(){

        /*获取所有文件夹中存在的更新包列表*/
        $fileList=$this->getALLFilesList();
        if(!empty($fileList)){ //如果服务器存在更新包

            /*获取文件夹中所有更新包的文件名*/
            foreach($fileList as $filePath){
                $fileNames[]=pathinfo($filePath)['basename'];

            }
            /*获取xml记录已添加的更新包的文件名*/
            $list=$this->getXmlData();
            foreach($list as $data){
                $xmlFileNames[]=pathinfo($data["url"])['basename'];

            }

            /*获取没有写入到XML同时存在MD5的zip文件列表*/
            if(!empty($xmlFileNames)) {
                $newZipList = array_diff($fileNames, $xmlFileNames);
            }else{
                $newZipList =$fileNames;
            }

            return   $newZipList;
        }

    }


}
