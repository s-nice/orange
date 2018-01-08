<?php
/**
 * 管理设置模块
 * @author zhangpeng
 *
 */
namespace Company\Controller;
use Think\Log;
use Think\Controller;
use Model\Departments\Departments;
import('Factory', LIB_ROOT_PATH . 'Classes/');

class AdminSetController extends BaseController
{
	private $rows = 20;
	public function _initialize()
	{
		parent::_initialize();
		$this->assign('title','欢迎企业平台');
	}

	public function index ()
	{
        $params['bizid'] = $_SESSION['Company']['bizid'];
        $result = \AppTools::webService('\Model\Departments\Departments', 'getBizInfo',array('params'=>$params));
        $this->assign('data',$result['data']['list'][0]);

		$this->assign('breadcrumbs',array('key'=>'manageset','info'=>'authmanage','show'=>'')); //没有导航菜单
		$this->assign('moreCSSs',array('css/Company/division'));
		$this->display('setPower');
	}

    public function setPowers(){
        $params = array();
        $params['open'] = I('post.type','');
        if($params['open']==''){$this->ajaxReturn('error');}
        $result = \AppTools::webService('\Model\Departments\Departments', 'setPowerM',array('params'=>$params));
        $this->ajaxReturn($result['status']);
    }
	
	/**员工管理**/
	public function staff ()
	{
		$this->assign('breadcrumbs',array('key'=>'manageset','info'=>'AdminSet','show'=>'')); //没有导航菜单
		$this->assign('moreCSSs',array('css/Company/division'));
		$this->display('staff');
	}
	/**离职员工管理**/
	public function quitPer ()
	{
		$this->assign('breadcrumbs',array('key'=>'manageset','info'=>'AdminSet','show'=>'')); //没有导航菜单
		$this->assign('moreCSSs',array('css/Company/division'));
		$this->display('quitPer');
	}
	/**标签管理**/
	public function labelManage ()
	{
		//echo 3;die;
		
		$this->assign('moreCSSs',array('css/Company/division'));
		$this->display('labelManage');
	}
	
	//根据企业id获取二维码页面
	public function entQrCode()
	{
		$session = session(MODULE_NAME);
		$params = $session['bizid'];
		if(empty($params)){
			Log::write('File:'.__FILE__.' LINE:'.__LINE__." 生成企业二维码时企业ID为空： \r\n<pre>".''.var_export($session,true));
		}
		$res = \AppTools::webService('\Model\Company\CompanyBaseInfo', 'getBizInfoByXId', array('id'=>$params));
		$name = $res['id']; //企业id
		$session['bizid'] = $res['bizid'];
		$session['bizIntid'] = $res['id'];
		session(MODULE_NAME, $session);
		$name = C('COMPANY_QR_PREFIX').$name;
		$info = $this->getQRByName($name);
		Log::write('File:'.__FILE__.' LINE:'.__LINE__."  \r\n生成企业二维码2：<pre>".''.var_export($info,true));
		//$this->ajaxReturn(array('status'=>$info['status'],'msg'=>$info['msg'],'url'=>$info['url']));
		if($info['status'] == 0){
			$imageBinary = file_get_contents($info['url']);
			$contentType = 'image/jpg';
			header('Content-type: ' . $contentType);
			echo $imageBinary;
		}else{
			echo '';
		}
	}
	
	//根据企业id生产带参数二维码
	private function getQRByName($name){
		$status = 0;
		$session = session(MODULE_NAME);
		//if(empty($session['qrCodeUrl']) || !file_exists($session['qrCodeUrl'])){
			$url = C('GET_ORADT_WEIXIN_TOKEN_URL').U('Demo/Wechat/getWxTokenForExternal',array('source'=>'企业生产二维码'));
			$rstToken = $this->exec($url,array('flush'=>0,'tb'=>1));
			$rstToken = json_decode($rstToken,true);
			$token = $rstToken['access_token'];
			$url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$token";
			$scene = array();
			$scene['scene_id'] = $name;
			$scene['scene_str'] = $name;
			$postArr = array(
					'expire_seconds'=>2592000, //二维码有效期,单位秒
					'action_name'=>'QR_STR_SCENE', //QR_STR_SCENE:临时， QR_LIMIT_STR_SCENE:永久
					'action_info'=>array(
							'scene'=>$scene,
					),
			);
			$postJson = json_encode($postArr);
			$res = $this->exec($url,$postJson,'POST');
		
			$info = json_decode($res,true);
			$msg = $url = '';
			Log::write('File:'.__FILE__.' LINE:'.__LINE__."  \r\n生成企业二维码1：<pre>".''.var_export($info,true));
			if(empty($info['ticket'])){
				$status = $info['errcode'];
				$msg = $info['errmsg'];
				$rstToken = $this->exec($url,array('flush'=>1,'tb'=>1));
			}else{
				$url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.@$info['ticket'];
				
				$session['qrCodeUrl'] = $url;
				session(MODULE_NAME, $session);
			}
		return array('status'=>$status,'msg'=>$msg,'url'=>$url);
	}
	
	public function downloadQrImg(){
		//$file = I('url','https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=gQG68DwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyY3BUeUJzWTNiVi0xLUFsTmhwY1IAAgSkSMpZAwQAjScA');
		$session = session(MODULE_NAME);
		$file_url = $session['qrCodeUrl'];
		$content = file_get_contents($file_url);
		if(!is_dir(C('UPLOAD_PATH'))){
			mkdir(C('UPLOAD_PATH'),0777);
		}
		$file = C('UPLOAD_PATH').$session['bizid'].'.jpg';
		file_put_contents($file, $content);
		header("Content-type: image/png"); //octet/stream
		header("Content-disposition:attachment;filename=".$file.";");
		header("Content-Length:".filesize($file));
		readfile($file);
		exit;
	}
	
	//获取当前员工的用户信息
	public function getEmInfo(){
        if(IS_AJAX){
        	$session = session(MODULE_NAME);
        	$id = $session['clientid'];
            if($id){
                $params['id'] = $id;
                $result = \AppTools::webService('\Model\Departments\Departments', 'getStaffM',array('params'=>$params));
                $data = array();
                if(isset($result['data']['numfound'])&&($result['data']['numfound']==1)){
                    $data = $result['data']['list'][0];
                    $data['bizname'] = '';
                    $res = \AppTools::webService('\Model\Departments\Departments', 'getBizInfo',array('params'=>array('bizid'=>$data['bizid'])));
                    if(isset($res['data']['numfound'])&&($res['data']['numfound']==1)){
                        $data['bizname'] = $res['data']['list'][0]['bizname'];
                    }
                    $this->ajaxReturn(array('status'=>0,'data'=>$data));
                }
            }
        }
        $this->ajaxReturn(array('status'=>1));
    }

    //编辑员工提交
    public function setEmInfo(){
        if(IS_AJAX){
            $session = session(MODULE_NAME);
        	$id = $session['clientid'];
            $key = I('post.key','');
            $val = I('post.val','');
            if($id){ 
                $params['empid'] = $id;   
                $params[$key] = $val;
                $result = \AppTools::webService('\Model\Departments\Departments', 'editStaffM',array('params'=>$params));
                if($result['status']==0){
                    $this->ajaxReturn(array('status'=>0,'msg'=>'保存成功','data'=>$val));
                }elseif($result['status']=='110012'){
                	$this->ajaxReturn(array('status'=>1,'msg'=>'保存失败,此邮箱已被使用！'));
                }
            }
        }
        $this->ajaxReturn(array('status'=>1,'msg'=>'保存失败'));
    }

}