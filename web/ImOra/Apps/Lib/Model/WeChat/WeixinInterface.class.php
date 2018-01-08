<?php
/**
 * 第三方微信接口类
 * @author zhangpeng
 */
namespace Model\Wechat;
class WeixinInterface 
{
	/**
	 * 获取微信用户信息
	 */
    public function getUserInfo($params=array())
    {
    	$baseToken = $params['baseToken'];
    	$openid    = $params['openid'];
    	$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$baseToken}&openid={$openid}&lang=zh_CN";
    	$rst = httpGet($url);
    	//\Think\Log::write('File:'.__FILE__.' LINE:'.__LINE__." 从微信端获取用户信息： \r\n<pre>".''.var_export($rst,true));
    	if(isset($rst['errcode']) && $rst['errcode'] == '40001' || $rst['errcode'] == '41001'){
    		getWxTokenToLocal(1,__CLASS__.'->'.__METHOD__.' again get weixin token');
    		$this->getUserInfo($baseToken, $openid);
    	}else{
    		return $rst;
    	}
    }
    
    
}
