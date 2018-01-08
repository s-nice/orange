<?php
class JSSDK {
	private $appId;
	private $appSecret;
	
	public function __construct($appId, $appSecret) {
		$this->appId = $appId;
		$this->appSecret = $appSecret;
	}
	
	public function getSignPackage() {
		$jsapiTicket = $this->getJsApiTicket ();
		$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$timestamp = time ();
		$nonceStr = $this->createNonceStr ();
		
		// 这里参数的顺序要按照 key 值 ASCII 码升序排序
		$string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
		
		$signature = sha1 ( $string );
		
		$signPackage = array ("appId" => $this->appId, "nonceStr" => $nonceStr, "timestamp" => $timestamp, "url" => $url, "signature" => $signature, "rawString" => $string );
		return $signPackage;
	}
	
	//获取公众号支付签名
	public function getPaySignPackage($prepayId){
		$nonceStr = $this->createNonceStr ();
		$timestamp = time ();
		$param = array(
				'appid'=> $this->appId,
				'timestamp' => $timestamp,
				'nonceStr' => $nonceStr,
				'package' => 'prepay_id='.$prepayId,
				'signType' => 'MD5',
		);
		ksort($param);
		$stringA = http_build_query($param);
		$stringSignTemp = $stringA+"&key=Ora123456Wx123456API65432100000S"; //注：key为商户平台设置的密钥key
		$sign=strtoupper(MD5($stringSignTemp));
		$param['signature'] = $sign;
		return $param;
	}
	
	//普通微信支付
	public function getPaySignJssdk($prepayId){
			$nonceStr = $this->createNonceStr ();
			$timestamp = time ();
			$param = array(
					'appid'=> $this->appId,
					'timestamp' => $timestamp,
					'nonceStr' => $nonceStr,
					'package' => 'prepay_id='.$prepayId,
					'signType' => 'MD5',
			);
			ksort($param);
			$stringA = http_build_query($param);
			$stringSignTemp = $stringA+"&key=Ora123456Wx123456API65432100000S"; //注：key为商户平台设置的密钥key
			$sign=strtoupper(MD5($stringSignTemp));
			$param['signature'] = $sign;
			return $param;
	}
	
	private function createNonceStr($length = 16) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for($i = 0; $i < $length; $i ++) {
			$str .= substr ( $chars, mt_rand ( 0, strlen ( $chars ) - 1 ), 1 );
		}
		return $str;
	}
	
	private function getJsApiTicket() {
		$filePath = "temp".DIRECTORY_SEPARATOR."H5".DIRECTORY_SEPARATOR."tempjsapi_ticket.json";
		// jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
		$data = json_decode ( file_get_contents (  $filePath) );
		if ($data->expire_time < time ()) {
			$accessToken = $this->getAccessToken ();
			$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
			$res = json_decode ( $this->httpGet ( $url ) );
			$ticket = $res->ticket;
			if ($ticket) {
				$data->expire_time = time () + 7000;
				$data->jsapi_ticket = $ticket;
				$fp = fopen ( $filePath, "w" );
				fwrite ( $fp, json_encode ( $data ) );
				fclose ( $fp );
			}
		} else {
			$ticket = $data->jsapi_ticket;
		}
		
		return $ticket;
	}
	
	private function getAccessToken() {
		$filePath = "temp".DIRECTORY_SEPARATOR."H5".DIRECTORY_SEPARATOR."access_token.json" ;
		// access_token 应该全局存储与更新，以下代码以写入到文件中做示例
		$data = json_decode ( file_get_contents ( "temp".DIRECTORY_SEPARATOR."H5".DIRECTORY_SEPARATOR."access_token.json" ) );
		if ($data->expire_time < time ()) {
			$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
			$res = json_decode ( $this->httpGet ( $url ) );
			$access_token = $res->access_token;
			if ($access_token) {
				$data->expire_time = time () + 7000;
				$data->access_token = $access_token;
				$fp = fopen ( $filePath, "w" );
				fwrite ( $fp, json_encode ( $data ) );
				fclose ( $fp );
			}
		} else {
			$access_token = $data->access_token;
		}
		return $access_token;
	}
	
	public function httpGet($url) {
		$curl = curl_init ();
		curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $curl, CURLOPT_TIMEOUT, 500 );
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt ( $curl, CURLOPT_URL, $url );
		
		$res = curl_exec ( $curl );
		curl_close ( $curl );
		
		return $res;
	}
	
	/**
	 * @ name curl
	 */
	public function _curl($url, $method = 'POST', $headers = array(), $postfields = NULL)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_HEADER, false);

		if ('POST' == $method) {
            curl_setopt($curl, CURLOPT_POST, TRUE);
            if (!empty($postfields)) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $postfields);
            }
        }

		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers );
		curl_setopt($curl, CURLINFO_HEADER_OUT, TRUE );

		$response = curl_exec($curl);

		$this->_httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$this->_httpInfo = curl_getinfo($curl);
		curl_close($curl);
	/* 	echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',var_dump($this->_httpCode);
echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',var_dump($this->_httpInfo);
echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',var_dump('<hr/>');
echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',var_dump($postfields);
echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',var_dump($response);exit; */
		return $response;
	}
}

