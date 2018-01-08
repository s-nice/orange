<?php
namespace Demo\Controller;

use Think\Log;
use Classes\GFunc;
use Demo\Controller\Base\WxBaseController;

class ScannerQrController extends WxBaseController
{
	/**
     * 使用设备id批量生成二维码ticket存入数据库
     */
    public function createScanQrZip(){
        // 获取未添加二维码的扫描仪serviceid列----api
        $scannerInfo = \AppTools::webService('\Model\WeChat\WeChat', 'getUnbindSanners', array('params'=>array()));
    
        $rstToken = $this->getWxTokenToLocal(0,'生成微信二维码');
        $access_token = $rstToken['access_token'];
        if (empty($access_token)) {
            $this->assign('msg',"获取token失败,请刷新页面");
            $this->display('getScannerQrZip');
            die();
        }

        $get_ticket_url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$access_token";
        $scanners = "";
        $i = 0;
        $params = array();
        $scannerInfos = array_chunk($scannerInfo['data']['list'], 30);//每30组数据发送一次请求，一次发送过多微信接口返回部分数据为空
        // 批量生成微信二维码的ticket
        foreach ($scannerInfos as $chunk) {
        	foreach ($chunk as $serviceId) {
        		$info = array();  
            	$info['url'] = $get_ticket_url;  
            	$info['data'] = '{"action_name":"QR_LIMIT_STR_SCENE","action_info":{"scene":{"scene_str":"'.C("SCANNER_QRS_PREFIX").$serviceId['scannerid'].'"}}}';
            	$nodes[$serviceId['scannerid']] = $info;
        	}
        	
        	$ticket_results = $this->curlMulti($nodes,'post',5);// 发送批量请求,最大请求时长5秒
        	foreach ($ticket_results as $key=>$result) {
        		$params[$i]['scannerid'] = $key;
	            $params[$i]['wechat_ticket'] = json_decode($result, true)["ticket"];
	            $params[$i]['wechat_url'] = json_decode($result, true)["url"];
	            // 获取记录id 
	            foreach ($chunk as $serviceId) {
	                if ($serviceId['scannerid'] == $key) {
	                    $params[$i]['id'] =  $serviceId['id'];
	                }
	            }
	            $scanners = $scanners.",".$key;
	            $i++;
        	}
        	unset($nodes);
        }
     	
        // 存入数据库----api
        $res = \AppTools::webService('\Model\WeChat\WeChat', 'bindQrToScanner', array('params'=>json_encode($params)));
        if ($res['status'] == 0) {
            if ($scanners != "" ) {
                $this->assign('msg',"已绑定扫描仪".trim($scanners,","));
            }
        } else {
            $this->assign('msg',"绑定扫描仪失败");
            $this->display('getScannerQrZip');
            die();
        }
        
    }
    
    /**
     * 根据参数生成二维码操作
     * https://mp.weixin.qq.com/debug/
     */
    public function getScannerQrZip(){
        $batchid = I('batchid');
        empty($batchid) and $this->createScanQrZip();// 进入页面则先绑定扫描仪

        // api接口获取所有批次号(接口)---api
        $batchAll = \AppTools::webService('\Model\WeChat\WeChat', 'getBatchIds', array('params'=>array()));
        $batchAll = $batchAll['data'];
        // 根据传入的批次号，获取已经处理好的批次包，如果丢失，则重新生成批次包
        
        if (!empty($batchid)) {
            $ScannerQrZip = './temp/Upload/imora/batch'.$batchid.'/ScannerQr'.$batchid.'.zip';
            $ScannerQrDir = './temp/Upload/imora/batch'.$batchid.'/ScannerQr'.$batchid.'/';
            $QrZip = './temp/Upload/imora/batch'.$batchid.'/Qr'.$batchid.'.zip';
            $QrDir = './temp/Upload/imora/batch'.$batchid.'/Qr'.$batchid.'/';
                
        	$this->delDir(WEB_ROOT_DIR.'./temp/Upload/imora/batch'.$batchid.'/'); // 清除服务器缓存目录
        	
            // 根据批次号获取设备id列和tickets列-----api
            $batchResults = \AppTools::webService('\Model\WeChat\WeChat', 'getBatchScannerQrs', array('params'=>array('batchid'=>$batchid)));
            $batchResults = $batchResults['data']['list'];
            
            $downloadurl = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=";
            !is_dir($QrDir) and mkdir(WEB_ROOT_DIR.$QrDir,0777,true); // 二维码存放地址
            !is_dir($ScannerQrDir) and mkdir(WEB_ROOT_DIR.$ScannerQrDir,0777,true); // 修改后的二维码存放地址

            // 从微信获取二维码图片
            foreach ($batchResults as $key=>$batchResult) {
                $downloadurls[$batchResult['scannerid']]['url'] =  $downloadurl.urlencode($batchResult['wechat_ticket']);
            }
            $images = $this->curlMulti($downloadurls,'get',5); // 发送批量请求

            // 请求的图片下载到本地，文件名为设备号
            foreach ($images as $key => $image) {
                $image_name = $QrDir.'/'.$key.'.jpg';
                $local_file = fopen($image_name, 'w');
                if (false !== $local_file) {
                    if (false !== fwrite($local_file, $image)) {
                        fclose($local_file);
                    }
                }
            }

            $dir = scandir($QrDir);
            foreach ($dir as $qr) {
                if (pathinfo($qr,PATHINFO_EXTENSION) == 'jpg') {
                    // 命名使用设备id号
                    $this->createScanQr($QrDir.$qr,basename($qr,".jpg"),$ScannerQrDir.$qr);
                }
            }
            // 生成下载二维码的缩略图
            if (is_dir($ScannerQrDir)) {                
                // 图片打包下载
                import('Zip', LIB_ROOT_PATH.'Classes/');
                $zip = new \PhpZip();
                $zip->zip($ScannerQrZip,array('./'=>$ScannerQrDir));
                $this->downloadZip($ScannerQrZip);
            } 
        }

        $this->assign('batchAll',$batchAll);
        $this->display();
    }
    
    /**
     * 查询单个扫描仪二维码
     * @param $scanner string 扫描仪ID 
     * @param $envir string 查询的服务器环境host地址 
     * @return array('status'=>**,msg=>***) ajax返回 
     */
    public function getQr(){
        $scanner = I('scanner');
        $envir = I('envir');
        switch ($envir) { // 拼装api接口访问路径
            case 'wxww.oradt.com':
                $url = "http://simu-weixin-api-431280862.cn-north-1.elb.amazonaws.com.cn/common/scan/tickets?scannerid=".$scanner;
                break;
            case 'dev.orayun.com':
                $url = "http://192.168.30.191:9996/common/scan/tickets?scannerid=".$scanner;
                break;
            case 'w.oradtcloud.com':
                $url = "http://simu-weixin-api-431280862.cn-north-1.elb.amazonaws.com.cn/common/scan/tickets?scannerid=".$scanner;
                break;
            default:
                break;
        }
        empty($scanner) and $this->ajaxReturn(array('status'=>1,'msg'=>"扫描仪ID错误"));
        empty($url) and $this->ajaxReturn(array('status'=>1,'msg'=>"环境参数错误"));
        $results = $this->send_get($url,''); // 请求API接口
        $results = json_decode($results, true)['body']['list'];
        empty($results) and $this->ajaxReturn(array('status'=>1,'msg'=>"没有该扫描仪信息"));        
        $this->ajaxReturn(array('status'=>0,'msg'=>$results[0]['wechat_qrcode']));
    }

    /**
     * 处理图片：二维码上添加设备号
     * @param $pic       string   要处理的图片在服务器的路径
     * @param $string    string   扫描仪ID号
     * @param $targetdir string   处理后的图片存放地址
     */
    public function createScanQr($pic,$string,$targetdir){
        $im = imagecreate(150, 20);
        $bg = imagecolorallocate($im, 255, 255, 255); //设置画布的背景为白色
        $black = imagecolorallocate($im, 0, 0, 0); //设置一个颜色变量为黑色
        imagestring($im, 3, 0, 0, $string, $black); //水平的将字符串输出到图像中     
        
        $qrpic = imagecreatefromjpeg($pic);
        
        //在内存中建立一张图片
        $images2 = imagecreate(150, 170);
        imagecolorallocate($images2, 255, 255, 255); //设置画布的背景为白色
        imagecopyresampled($images2, $qrpic, 0, 0, 0, 0, 150, 150, 430, 430); 

        //将原图复制到新建图片中
        imagecopyresampled($images2, $im, 5, 150, 0, 0, 150,20, 150,20);

        header('Content-type:image/jpeg'); 
        imagejpeg($images2,$targetdir);
    }

    /**
	 * 下载zip包
	 */
    public function downloadZip($filename){
        //下面是输出下载;
        header ( "Cache-Control: max-age=0" );
        header ( "Content-Description: File Transfer" );
        header ( 'Content-disposition: attachment; filename=' . basename ( $filename ) ); // 文件名
        header ( "Content-Type: application/zip" ); // zip格式的
        header ( "Content-Transfer-Encoding: binary" ); // 告诉浏览器，这是二进制文件
        header ( 'Content-Length: ' . filesize ( $filename ) ); // 告诉浏览器，文件大小
        @readfile ( $filename );//输出文件;
    }

    /**
     * 递归删除文件夹
     * @param $directory string 目录地址
     */
	public function delDir($directory){//自定义函数递归的函数整个目录  
	    if(file_exists($directory)){//判断目录是否存在，如果不存在rmdir()函数会出错  
	        if($dir_handle=@opendir($directory)){//打开目录返回目录资源，并判断是否成功  
	            while($filename=readdir($dir_handle)){//遍历目录，读出目录中的文件或文件夹  
	                if($filename!='.' && $filename!='..'){//一定要排除两个特殊的目录  
	                    $subFile=$directory."/".$filename;//将目录下的文件与当前目录相连  
	                    if(is_dir($subFile)){//如果是目录条件则成了  
	                        $this->delDir($subFile);//递归调用自己删除子目录  
	                    }  
	                    if(is_file($subFile)){//如果是文件条件则成立  
	                        unlink($subFile);//直接删除这个文件  
	                    }  
	                }  
	            }  
	            closedir($dir_handle);//关闭目录资源  
	            rmdir($directory);//删除空目录  
	        }  
	    }  
	}  

}