<?php
namespace Demo\Controller;

use Demo\Controller\Base\WxBaseController;
use Think\Log;

class FaceController extends WxBaseController
{
    protected $webSerivce = null;
    private $pageSize = 10;

    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $tplName = !empty($tplName)?$tplName:'index';
        $this->_weixinAuthBase($tplName, 'Face');
        
        //网页调用照片
        $jssdk = new \JSSDK(C('Wechat')['AppID'], C('Wechat')['AppSecret']);
        $signPackage = $jssdk->GetSignPackage();
        $this->assign('signPackage', $signPackage);
        $this->assign('openid',$this->session['openid']);
        $this->assign('type',$this->getAppName());
        //$this->session['openid'] = 'ofIP5vrO61ORW8tWlNufVS3VUBxQ';
        
        $rst = \AppTools::webService('\Model\Common\Common','callApi',
            array(
                'url'    => WEB_SERVICE_ROOT_URL_WECHAT.'/common/wechat/getwechatuser',
                'params' => array('wechatid'=>$this->session['openid']),
            )
        );
        if (!empty($rst['data']['wechats'][0])) {
            $this->assign('data', $rst['data']['wechats'][0]);
        }
//         print_r($rst);
        $this->display('index');
    }
    
    public function saveFace(){
        $name = I('name');
        //$data = base64_decode(str_replace('data:image/jgp;base64,', '', I('data')));
        $data = (str_replace('data:image/jgp;base64,', '', I('data')));
        if (empty($data)) {
            echo 'no image file';die;
        }
        
        $post_data['api_key'] = 'YhN7wn1xLF9PvMWX_9LRcIrcURrcEfGy';
        $post_data['api_secret'] = '5zteOLtBYAM1pEu5xAS_FVzlFpc-FzTa';
        $post_data['image_base64'] = $data;
        
        $rst = null;
        while (true){
            $rst = $this->__post('https://api-cn.faceplusplus.com/facepp/v3/detect', $post_data);
            if (empty($rst['error_message'])){
                break;
            }
            if ($rst['error_message'] != 'CONCURRENCY_LIMIT_EXCEEDED') {
                echo $rst['error_message'];die;
            }
            sleep(1);
        }
        
        if (empty($rst['faces'])){
            echo 'no faces';die;
        }
        if (count($rst['faces']) > 1){
            echo 'multiple faces';die;
        }
        
        $faceToken = $rst['faces'][0]['face_token'];
        $post_data = array();
        $post_data['api_key']    = 'YhN7wn1xLF9PvMWX_9LRcIrcURrcEfGy';
        $post_data['api_secret'] = '5zteOLtBYAM1pEu5xAS_FVzlFpc-FzTa';
        $post_data['face_token'] = $faceToken;
        $post_data['user_id']    = $this->session['openid'].'$$'.$name;
        
        while (true){
            $rst = $this->__post('https://api-cn.faceplusplus.com/facepp/v3/face/setuserid', $post_data);
            if (empty($rst['error_message'])) {
                break;
            }
            if ($rst['error_message'] != 'CONCURRENCY_LIMIT_EXCEEDED') {
                echo $rst['error_message'];die;
            }
            sleep(1);
        }
        
        $post_data = array();
        $post_data['api_key']     = 'YhN7wn1xLF9PvMWX_9LRcIrcURrcEfGy';
        $post_data['api_secret']  = '5zteOLtBYAM1pEu5xAS_FVzlFpc-FzTa';
        $post_data['outer_id']    = 'test';
        $post_data['face_tokens'] = $faceToken; 
        
        while (true){
            $rst = $this->__post('https://api-cn.faceplusplus.com/facepp/v3/faceset/addface', $post_data);
            if (empty($rst['error_message'])) {
                break;
            }
            if ($rst['error_message'] != 'CONCURRENCY_LIMIT_EXCEEDED') {
                echo $rst['error_message'];die;
            }
            sleep(1);
        }
        
        if (!empty($rst['failure_detail'])) {
            echo json_encode($rst['failure_detail']);die;
        }
        if ($this->_saveFaceInfo($data)) {
            echo 'success';
        } else {
            echo 'save face info fail';
        }
    }
    
    private function _saveFaceInfo($data){
        $filestream = base64_decode($data);
        $filepath = C('TMP_IMG_SAVE_PATH');
        if (!is_dir($filepath)){
            $flag = mkdir($filepath, 0777, true);
            if($flag == false){
                log::write('File:'.__FILE__.' LINE:'.__LINE__." 服务器无权限创建目录： \r\n<pre>".''.var_export($flag,true));
                return false;
            }
        }
        $filename = $filepath.md5($data).'.jpg';
        file_put_contents($filename, $filestream);
        
        $rst = \AppTools::webService('\Model\Common\Common','callApi',
            array(
                'url'        => WEB_SERVICE_ROOT_URL_WECHAT.'/upload',
                'params'     => array('wechatid'=>$this->session['openid']),
                'crud'       => 'C', 
                'doParseApi' => true, 
                'files'      => array(
                    'resource'=>$filename
                )
            )
        );
        
        \GFile::delfile($filename);
        $imageurl = $rst['data']['path'];
        if (empty($imageurl)) {
            echo 'upload image file fail';die;
        }
        
        $rst = \AppTools::webService('\Model\Common\Common','callApi',
            array(
                'url'    => C('API_WX_Bind_USER_INFO'),
                'params' => array(
                    'wechatid'   => $this->session['openid'],
                    'avatarpath' => $imageurl
                ),
                'crud'   => 'C'
            )
        );
        if ($rst['status'] != 0){
            echo $rst['msg'];die;
        }
        return true;
    }
    protected function __post($url, $post_data){
        Log::write("----------facedemo $url with params ".json_encode($post_data), 'INFO');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_CAINFO, WEB_ROOT_DIR.'../Apps/Static/cacert.pem');
        
        $output = curl_exec($ch);
        Log::write("----------facedemo--$output", 'INFO');
        $arr = json_decode($output, true);
        Log::write("----------facedemo $url with params $post_data", 'INFO');
        if (empty($arr)) {
            $msg = "CURL Error:".curl_error($ch);
	        curl_close($ch);
            echo $msg;die;
        }
        curl_close($ch);
        return $arr;
    }
    
}
/* EOF */
