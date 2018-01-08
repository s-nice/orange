<?php
use Classes\GFunc;
class GFile
{
    /**
     * Create dir
     * @param string $dirPath The dir path to be created
     * @param int $mode The mode applied on the new dir
     * @return boolean
     */
    static public function mkdir ($dirPath, $mode=0777)
    {
        // 如果目录不存在， 尝试递归创建目录
        $result = is_dir($dirPath) ? true : mkdir($dirPath, $mode, true);

        return $result;

        $dirList = explode(DIRECTORY_SEPARATOR, $dirPath);
        $tempDir = '';
        while (($dir = array_shift($dirList))) {
            $tempDir = $tempDir . DIRECTORY_SEPARATOR . $dir;
            if (is_dir($tempDir)) {
                continue;
            }
            if(! @mkdir($tempDir, $mode)) {
                return false;
            }
        }

        return true;
    }
    
    /**
     * 删除文件夹以及里面的内容
     * @param string $dir
     * @return boolean
     */
    public static function deldir($dir) {
        $dh=opendir($dir);
        while ($file = readdir($dh)) {
            if($file!="." && $file!="..") {
                $fullpath=$dir.DIRECTORY_SEPARATOR.$file;
                if(!is_dir($fullpath)) {
                    unlink($fullpath);
                } else {
                    GFile::deldir($fullpath);
                }
            }
        }
        closedir($dh);
        if(rmdir($dir)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 删除文件
     * @param unknown $filename
     */
    public static function delfile($filename){
        return unlink($filename);
    }
    
    /**
     * 复制文件夹内容
     * @param dir $src
     * @param dir $dst
     */
    public static function copydir($src, $dst){
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . DIRECTORY_SEPARATOR . $file) ) {
                    GFile::copydir($src . DIRECTORY_SEPARATOR . $file,$dst . DIRECTORY_SEPARATOR . $file);
                }
                else {
                    copy($src . DIRECTORY_SEPARATOR . $file,$dst . DIRECTORY_SEPARATOR . $file);
                }
            }
        }
        closedir($dir);
    }

    /**
     * 获取路径下所有文件
     * @param str $path
     * @param arr $rlist 结果集
     */
    public static function allfile($path, &$rlist){
        $current_dir = opendir($path);
        while(($file = readdir($current_dir)) !== false) {
            $sub_dir = $path . DIRECTORY_SEPARATOR . $file;    //构建子目录路径
            if($file == '.' || $file == '..') {
                continue;
            } else if(is_dir($sub_dir)) {    //如果是目录,进行递归
                //echo 'Directory ' . $file . ':<br>';
                GFile::allfile($sub_dir, $rlist);
            } else {    //如果是文件,直接输出
                //echo 'File in Directory ' . $path . ': ' . $file . '<br>';
                $rlist[] = "$path".DIRECTORY_SEPARATOR."$file";
            }
        }
    }
    
    /**
     * 获取路径下所有文件夹
     * @param str $path
     * @param arr $rlist 结果集
     */
    public static function alldir($path, &$rlist){
        $current_dir = opendir($path);
        while(($file = readdir($current_dir)) !== false) {
            $sub_dir = $path . DIRECTORY_SEPARATOR . $file;    //构建子目录路径
            if($file == '.' || $file == '..') {
                continue;
            } else if(is_dir($sub_dir)) {    //如果是目录,进行递归
                //echo 'Directory ' . $file . ':<br>';
                $rlist[] = $sub_dir;
                GFile::alldir($sub_dir, $rlist);
            } else {
                //如果是文件,则忽略
                
            }
        }
    }
}

