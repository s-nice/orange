<?php
namespace Company\Controller;
use BaseController\CommonController as GlobalCommon;
use Model\WebService;
/**
 * 后台控制器基类
 */
class CommonController extends GlobalCommon
{
	public function checkMessage(){
		if(IS_AJAX){	
			$msg = session(MODULE_NAME.'_MSG');
			if($msg){
				$this->assign('msg',$msg);
				$tpl = $this->fetch('checkMsg');
				session(MODULE_NAME.'_MSG',null);
				$this->ajaxReturn(array('status'=>0,'tpl'=>$tpl));
			}else{
				$this->ajaxReturn(array('status'=>1));
			}
		}
	}
}

/* EOF */