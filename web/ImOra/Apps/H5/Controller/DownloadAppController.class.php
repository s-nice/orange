<?php
namespace H5\Controller;
class DownloadAppController {


    public function index(){ //二维码APP下载页面
        include_once(LIB_ROOT_PATH . '3rdParty/phpqrcode/phpqrcode.php');
        Vendor('phpqrcode.phpqrcode');
        //生成二维码图片
        $object = new \QRcode();
//        $url=C('ANDROID_APP_LINK');
        $url='http://dev.orayun.com/h5/imora/download.html';
        $level=3;
        $size=9;
        $errorCorrectionLevel =intval($level) ;//容错级别
        $matrixPointSize = intval($size);//生成图片大小
        $object->png($url, false, $errorCorrectionLevel, $matrixPointSize, 2);
    }

}