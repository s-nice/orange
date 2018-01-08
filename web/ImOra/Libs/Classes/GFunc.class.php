<?php
namespace Classes;
/**
 * 全局函数类
 * @author lichangchun <licc@oradt.com>
 * @date   2014-07-10
 */
class GFunc
{
    /**
     * 成功返回函数，用于函数间调用
     * @access public
     * @param string $info
     */
    public static function successReturn($info)
    {
        echo json_enocde(array('info'=>$info, 'status'=>1));
        exit();
    }

    /**
     * 错误返回函数，用于函数间调用
     * @access public
     * @param string $info
     */

    public static function errorReturn($info)
    {
        echo json_encode(array('status'=>0, 'info'=>$info));
        exit();
    }

    //通过地址获取坐标
    public static function getLatLng($address)
    {

        $baidu_ak = 'PyK7dwXaQe9At6SQ9AQ7KwGQ';
        $maphtml = file_get_contents("http://api.map.baidu.com/geocoder/v2/?address=".$address."&output=json&ak=".$baidu_ak);
        $r = json_decode($maphtml,true);
        return $r['result']['location'];
    }


    //通过坐标获取地址
    public static function getAddress($latlng)
    {

        $baidu_ak = 'PyK7dwXaQe9At6SQ9AQ7KwGQ';
        $maphtml = file_get_contents("http://api.map.baidu.com/geocoder/v2/?location=".$latlng."&output=json&ak=".$baidu_ak);
        $r = json_decode($maphtml,true);
        return $r['result'];
    }
    /**
     *  随机串生成
     *  @access public
     *  @param string $input
     *  @param int $len
     *  @return string
     */
    public static function createRandString($input, $len)
    {
        $output = '';
        $inputLen = strlen($input);
        if (!self::isInteger($len) || !$inputLen) {
            return $output;
        }
        for ($i=0; $i<$len; ++$i) {
            $index = ((rand() % $inputLen) + $inputLen) % $inputLen;
            $output .= $input[$index];
        }
        return $output;
    }
    /**
     * 用户自动登陆解密判断
     * @return bool
     */
    public static function checkAutoLogin()
    {
    	$session = session(MODULE_NAME);
    	// 检查对应程序组的session cookie是否存在
	    if( ( !is_array($session) || !isset($session['username'])) && cookie('Oradt_'.MODULE_NAME) ) {
	    //用户非登陆状态，cookie存在
	    	$accountInfo = self::loadAccountFromCookie(); // load account info from cookie
	    	$result = self::checkUsernameAndPassword($accountInfo['username'], $accountInfo['password'], $accountInfo['userType']);
	    	if(is_array($result) ) {//如果用户存在
		    	$session = array(
	    	            'accountState'  => $result['body']['state'],
	    	            'username' 		=> $accountInfo['username'],
	    	            'password'		=> md5($accountInfo['password']),
	    	            'userType'		=> $accountInfo['userType'],
	    	            'loginip'		=> get_client_ip(), // use this ip for check autologin
	    	            'accesstoken'   => $result['body']['accesstoken'],
	    	            'tokenExpireTime' => $result['body']['expiration'] + time(),
	    	            'login_succ' => true,
	    	    );
	    	    session(MODULE_NAME, $session);

	    	    if (LoginBaseController::USER_TYPE_BASIC == $session['userType']) {
	    	        $userBasicInfo = \AppTools::webService('PersonalAccount', 'getUserBasicInfo');
	    	        $session['avatarPath'] = $userBasicInfo['headurl'];
	    	        $session['email'] = $userBasicInfo['email'];

	    	        session(MODULE_NAME, $session);
	    	    }

		        return true;
	    	}

	    	//cookie('Oradt_'.MODULE_NAME, null); // 验证失败， 注销cookie
	    }

	    return false;
    }

    /**
     * Check if username and password are correct on API side
     * @param string $username Username
     * @param string $password Password
     * @param string $userType The user type: basic, biz, admin
     * @return ErrorCoder|Array
     */
    public static function checkUsernameAndPassword($username, $password, $usertype)
    {
    	//添加密码错误次数限制验证：
/*     	$savePath = C('DATA_CACHE_PATH').'/LoginIntercept/'.$usertype;//保存路径
    	if(!is_dir($savePath)){
    		$flag = mkdir($savePath,0777,true);
    		if(!$flag){
    			\Think\log::write('File:'.__FILE__.' LINE:'.__LINE__."\r\n".' 创建缓存目录失败: '.var_export($savePath,true));
    		}
    	}
    	$cacheParam['temp']   = $savePath;
    	$cacheParam['prefix'] = 'user_';//设置缓存文件名前缀
    	$cache = \Think\Cache::getInstance('File',$cacheParam);
    	$key = $username.get_client_ip(1);
    	$rtn = $cache->get($key);
    	$now = time();
    	if($rtn){
    		$count = $rtn['count']+1;
    		$time  = $rtn['time'];
    		if($count > GConf::LOGIN_PWD_ERROR_COUNT && $time>$now - GConf::LOGIN_PWD_ERROR_TIME_MAX*60){//在登陆限制中
    			import('ErrorCoder', LIB_ROOT_PATH.'Classes/');
    			$errorCode = \ErrorCoder::ERR_LOGIN_WRONG_MORE_THAN_NUMBER;
    			$cache->set($key,array('count'=>$count,'time'=>$time));
    			$errorObject = new \ErrorCoder($errorCode);
    			$errorMsg    = $errorObject->getErrorDesc();
    			$result['data'] = '';
    			$result['status'] = $errorCode;
    			$result['msg']    = sprintf($errorMsg, GConf::LOGIN_PWD_ERROR_TIME_MAX);
    			return $result;
    		}
    	} */

    		$params = array('username'=>$username, 'password'=>$password, 'usertype'=>$usertype);
    		$result = \AppTools::WebService('\Model\Oauth\Oauth', 'getUserToken', $params);
    		if($result['status']){
    			switch ($result['status']) {
    				case 100010://密码错误
    					$errorCode = \ErrorCoder::ERR_LOGIN_PASSWORD_WRONG;
    					/* if(!$rtn){//此账号第一次进行登陆限制计算
    						$cache->set($key,array('count'=>1,'time'=>$now));
    					}else{
    						$count = $rtn['count']+1;
    						$time  = $rtn['time'];
    						if($time<$now - GConf::LOGIN_PWD_ERROR_TIME_MAX*60){ //超过登陆限制次数时间已经过期，重新进行登陆限制计算
    							$cache->set($key,array('count'=>1,'time'=>$now));
    						}else{//登陆限制累加中
    							$cache->set($key,array('count'=>$count,'time'=>$time));
    						}
    					} */
    					break;
    				case 100009: // 用户名错误
    					$errorCode = \ErrorCoder::ERR_LOGIN_USERNAME_WRONG;
    					break;
    				default:
    					$errorCode = $result['status'];
    			}
    			$errorObj = new \ErrorCoder($errorCode);
    			$result['status'] = $errorCode;
    			$result['msg'] = $errorObj->getErrorDesc();
    		}else{
    			//$cache->set($key); //登陆成功，删除缓存文件
    		}
		return $result;
    }

    /**
     * parse stored cookie, and load the parsed data into user account information
     * @return array:
     */
    static public function loadAccountFromCookie ()
    {
    	$cookie = cookie('Oradt_'.MODULE_NAME);
    	$prefix = substr($cookie, 0, 7);	// get the stored key
    	$accountInfo = substr($cookie, 7);// get the account data
    	$key = $prefix . C('COOKIE_KEY');			// compose the secret key
    	$str_decrypt=mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $accountInfo, MCRYPT_MODE_ECB);
    	$str_decrypt=rtrim($str_decrypt, "\0");
    	$accountInfo = explode("\t\r", $str_decrypt);
    	$accountInfo = array(
    		'username' => $accountInfo[0],
    		'password' => base64_decode($accountInfo[1]),
    		'userType' => $accountInfo[2],
    	);
    	return $accountInfo;
    }

    /**
     * Store user account info into Cookie
     * @param array $userInfo	The user account information
     * @param number $cookieLifeTime	The cookie life time
     * @return void
     */
    static public function storeAccountIntoCookie ($userInfo, $cookieLifeTime=0)
    {
    	$cookieLifeTime = intval($cookieLifeTime);
    	$prefix = mt_rand(1000000, 9999999); 		// get a random string, to be used to create a secret key ,updated length from 3 wei to 7wei,否则加密函数报错
    	$key = $prefix . C('COOKIE_KEY'); 	// generate the secret key
    	$userCookieInfo = array(
    		$userInfo['email'],
    	    base64_encode($userInfo['password']), // password could have special chars
    		$userInfo['userType'],
    	);

    	$userInfo = implode("\t\r", $userCookieInfo);// merge userInfo into a string
    	// encrypt account info
    	$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    	$userInfo = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $userInfo, MCRYPT_MODE_ECB);
    	// add the prefix at the beginning of encrypted string. it will be used to decrept the string
    	$userInfo = $prefix . $userInfo;
    	cookie('Oradt_'.MODULE_NAME, $userInfo, $cookieLifeTime);
    	//echo $userInfo;exit;
    }

    /**   系统邮件发送函数
     *   @param string $to    接收邮件者邮箱
     *   @param string $name  接收邮件者名称
     *   @param string $subject 邮件主题
     *   @param string $body    邮件内容
     *   @param string $attachment 附件列表
     *   @return boolean
     *
     */
    public static function think_send_mail($to, $name, $subject = '', $body = '', $attachment = null)
    {
    	$config = C('THINK_EMAIL');
    	//vendor('PHPMailer.class#phpmailer'); //从PHPMailer目录导class.phpmailer.php类文件
    	alias_import('Mailer');
    	$mail = new PHPMailer(); //PHPMailer对象
    	$mail->CharSet    = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    	$mail->IsSMTP();  // 设定使用SMTP服务
    	$mail->SMTPDebug  = 0;  // 关闭SMTP调试功能
    	// 1 = errors and messages
    	// 2 = messages only
    	$mail->SMTPAuth   = true;                  // 启用 SMTP 验证功能
    	$mail->SMTPSecure = 'ssl';                 // 使用安全协议
    	$mail->Host       = $config['SMTP_HOST'];  // SMTP 服务器
    	$mail->Port       = $config['SMTP_PORT'];  // SMTP服务器的端口号
    	$mail->Username   = $config['SMTP_USER'];  // SMTP服务器用户名
    	$mail->Password   = $config['SMTP_PASS'];  // SMTP服务器密码
    	$mail->SetFrom($config['FROM_EMAIL'], $config['FROM_NAME']);
    	$replyEmail       = $config['REPLY_EMAIL']?$config['REPLY_EMAIL']:$config['FROM_EMAIL'];
    	$replyName        = $config['REPLY_NAME']?$config['REPLY_NAME']:$config['FROM_NAME'];
    	$mail->AddReplyTo($replyEmail, $replyName);
    	$mail->Subject    = $subject;
    	$mail->MsgHTML($body);
    	$mail->AddAddress($to, $name);
    	if(is_array($attachment)){ 		// 添加附件
    		foreach ($attachment as $file){
    			is_file($file) && $mail->AddAttachment($file);
    		}
    	}
    	return $mail->Send() ? true : $mail->ErrorInfo;
    }
    
    /**
     * 发送邮件服务(用smtp包,非第三方平台)
     * @param string $title   邮件标题
     * @param string $content 邮件内容
     * @param string $to_email 收件人
     * @return boolean
     */
    public  function sendEmail($args){
    	$subject       = isset($args['title'])   ? $args['title'] : '发送邮件默认标题';
    	$message       = isset($args['content']) ? $args['content'] : '发送邮件测试内容';
    	$to_email      = isset($args['to'])      ? $args['to'] : '846606478@qq.com';
    	if(empty($to_email))return false;
    
    	$subject = mb_convert_encoding ($subject, 'GBK', 'UTF-8'); //解决邮件标题乱码问题：标题和内容同时转码方可解决标题乱码   mb_convert_encoding
    	$message = mb_convert_encoding ($message, 'GBK', 'UTF-8'); //, 'UTF-8'
    
    	$additional_headers = '<meta http-equiv="Content-Type" content="text/html; charset=GBK">'; //解决html乱码
    	$additional_headers = '';
    
    	$mailtype = "HTML"; //邮件格式（HTML/TXT）,TXT为文本邮件
    	$sendUser = array(
    			'1' => array('user'=>'noreply@tltcspace.com',    'pass'=>'tltchoutai2014', 'smtpserver'=>'smtp.qq.com', 'smtpserverport'=>25),
    			'2' => array('user'=>'peng.zhang@tltcspace.com', 'pass'=>'zhangpeng_1987', 'smtpserver'=>'smtp.qq.com', 'smtpserverport'=>25),
    	);
    	$index = 1;
    	$smtpusermail 		= $sendUser[$index]['user']; //发件人
    	isset($args['debug']) && $sendUser[$index]['debug']  = $args['debug'];
    	$smtp = self :: create_smtp ($sendUser[$index]);
    	return $smtp -> sendmail ($to_email, $smtpusermail, $subject, $message, $mailtype, '', '', $additional_headers);
    }
    
    /**
     * 创建邮件smtp服务
     * @param unknown $sendUser
     * @return smtp
     */
    private static function create_smtp($sendUser){
    	require_once SRC_PATH. '/common/Smtp.class.php';
    	static $smtp;
    	$smtpserver 	= $sendUser['smtpserver']; //SMTP服务器
    	$smtpserverport = $sendUser['smtpserverport']; //SMTP服务器端口
    	$smtpuser		= $sendUser['user']; //SMTP服务器的用户帐号
    	$smtppass		= $sendUser['pass']; //SMTP服务器的用户密码
    	if (NULL == $smtp) {
    		$smtp = new smtp ($smtpserver, $smtpserverport, true, $smtpuser, $smtppass);
    		$smtp -> debug = isset($sendUser['debug'])?$sendUser['debug']:false; //是否显示发送的调试信息
    	}
    	return $smtp;
    }

    /**
     * 时区时间转换
     * @param $time 要转换的时间
     * @param $fromTimezone $time的时区时间
     * @param $toTimezone 要转换成的时区时间
     */
    public static function converTime($time,$fromTimezone,$toTimezone)
    {
    	$timeZone = new DateTimeZone($fromTimezone);
    	$newTimezone = new DateTimeZone($toTimezone);
    	$dateTime = new DateTime();
    	$dateTime->setTimeZone($timeZone);
    	list($year, $month, $day, $hour, $minute) = sscanf($time, '%d-%d-%d %d:%d:%d' );
    	$dateTime->setDate($year, $month, $day);
    	$dateTime->setTime($hour, $minute);
    	$dateTime->setTimeZone($newTimezone);
    	return $dateTime->format('Y-m-d H:i:s');
    }

    /**
     * 随机数据生成器
     * @access public
     * @param string $type eg. string, int, float, numberString,
     * @return string
     */
    public static function dataMaker($type='string', $require=array())
    {
        $input = '';
        $output = '';
        // 普通E字符
        $alpha      = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // 其他字符
        $otherAlpha = '@&!#-=+*$%';
        // 数字串
        $number     = '1234567890';
        // 最大长度
        $maxLen     = '2048';
        if (isset($require['length']) && self::isInteger($require['length'])){
            $maxLen = intval($require['length']);
        }
        switch (strtolower($type)) {
            case 'string':
                if (!isset($require['level'])) {
                    $require['level'] == '';
                }
                switch(intval($require['level'])) {
                    case 0:      // 英文串
                        $input = $alpha;
                        break;
                    case 1:      // 英文串+数字串
                        $input = $alpha.$number;
                        break;
                    case 2:      // 英文串+数字串+特殊字符串
                        $input = $alpha.$number.$otherAlpha;
                        break;
                    default:     // 英文字符串
                       $input  = $alpha;
                }
                $output = strval(self::createRandString($input, $maxLen));
                break;
            case 'int':
                $input  = $number;
                $output = intval((((rand()%9+9)%9)+1).self::createRandString($input, $maxLen-1));
                break;
            case 'numberstring':
                $input = $number;
                // 保证第一位数不能为0
                $output = strval((((rand()%9+9)%9)+1).self::createRandString($input, $maxLen-1));
                break;
            default:
        }
        return $output;
    }
    /**
     * 查看是否是整数或者整数字符串
     * @access public
     * @param string or int $input
     * var_dump(isInteger(23)); //bool(true)
     * var_dump(isInteger("23")); //bool(true)
     * var_dump(isInteger(23.5)); //bool(false)
     * var_dump(isInteger(NULL)); //bool(false)
     * var_dump(isInteger("")); //bool(false)
     */
    public static function isInteger($input){
        return(ctype_digit(strval($input)));
    }

	public static function getSupportLanguages ()
	{
	    $langs = explode(',', C('SUPPORT_LANGUAGES'));
	    $supportLangs = array();
	    foreach ($langs as $_key=>$_value) {
	        $_value = strtolower($_value);
	        if (! is_dir(APP_PATH . 'Lang/' . $_value)) {

	        }
	        $supportLangs[] = $_value;
	    }

	    return $supportLangs;
	}

    static public function getUiLang ()
    {
    	$supportLangs = self::getSupportLanguages();
        $lang = strtolower(I('get.lang'));
    	$session = session(MODULE_NAME);
    	if (isset($lang) && in_array($lang, $supportLangs)) {
            $session = is_array($session) ? ($session['lang'] = $lang) : null;
            session(MODULE_NAME, $session);
    	    return $lang;
    	}
    	if (isset($session['lang']) && in_array($session['lang'], $supportLangs)) {
    	    return $session['lang'];
    	}
    	$lang = C('DEFAULT_LANGUAGE');// 系统默认语言
    	//  从浏览器支持的语言中， 获取默认语言
    	$browserLangInfo = explode(';', I('server.HTTP_ACCEPT_LANGUAGE', '', 'strval,strtolower'));
    	foreach ($browserLangInfo as $_langInfo) {
    	    $_langInfo = explode(',', $_langInfo);
    	    foreach ($_langInfo as $_lang) {
    	        if (! in_array($_lang, $supportLangs)) {
    	            continue;
    	        }
    	        $lang = $_lang;
    	        break 2; // 跳出2层循环
    	    }
    	}

    	return $lang;
    }
    /**
     * 获取汉字拼音首字母
     * @param string $str
     * @return string|NULL
     */
    public static function getPinyinInitial($str)
    {
    	$fchar = ord($str[0]);
    	if($fchar >= ord("A") && $fchar <= ord("z")) return strtoupper($str[0]);

    	$s1 = mb_convert_encoding($str,'gb2312','Utf-8');
    	$s2 = mb_convert_encoding($s1,'Utf-8','gb2312');

    	if($s2 == $str){
    		$s = $s1;
    	} else {
    		$s = $str;
    	}
    	$asc = ord($s[0]) * 256 + ord($s[1]) - 65536;
    	if($asc >= -20319 && $asc <= -20284) return "A";
    	if($asc >= -20283 && $asc <= -19776) return "B";
    	if($asc >= -19775 && $asc <= -19219) return "C";
    	if($asc >= -19218 && $asc <= -18711) return "D";
    	if($asc >= -18710 && $asc <= -18527) return "E";
    	if($asc >= -18526 && $asc <= -18240) return "F";
    	if($asc >= -18239 && $asc <= -17923) return "G";
    	if($asc >= -17922 && $asc <= -17418) return "I";
    	if($asc >= -17417 && $asc <= -16475) return "J";
    	if($asc >= -16474 && $asc <= -16213) return "K";
    	if($asc >= -16212 && $asc <= -15641) return "L";
    	if($asc >= -15640 && $asc <= -15166) return "M";
    	if($asc >= -15165 && $asc <= -14923) return "N";
    	if($asc >= -14922 && $asc <= -14915) return "O";
    	if($asc >= -14914 && $asc <= -14631) return "P";
    	if($asc >= -14630 && $asc <= -14150) return "Q";
    	if($asc >= -14149 && $asc <= -14091) return "R";
    	if($asc >= -14090 && $asc <= -13319) return "S";
    	if($asc >= -13318 && $asc <= -12839) return "T";
    	if($asc >= -12838 && $asc <= -12557) return "W";
    	if($asc >= -12556 && $asc <= -11848) return "X";
    	if($asc >= -11847 && $asc <= -11056) return "Y";
    	if($asc >= -11055 && $asc <= -10247) return "Z";
    	return null;
    }


    /**
     * 格式化文件大小表示方式
     * @param int $size File size in byte
     * @param int $precision The precision returned
     * @return string
     */
    public static function formatFileSize ($fileBytes, $precision = 2)
    {
        $unit = array ("B", "KB", "MB", "GB", "TB", "PB" );
        $pos = 0;
        while ( $fileBytes >= 1024 ) {
            $fileBytes /= 1024;
            $pos ++;
        }
        $formatedFileSize = round ( $fileBytes, $precision ) . ' ' . $unit[$pos];

        return $formatedFileSize;
    }


    /**
     * 重写Image类中的生成图像验证码函数， 添加是否区分大小写参数
     * @static
     * @access public
     * @param string $length  位数
     * @param string $mode  类型
     * @param bool $caseSensitive 是否区分大小写
     * @param string $type 图像格式
     * @param string $width  宽度
     * @param string $height  高度
     * @return string
     */
    static function buildImageVerify($length=4, $mode=1, $caseSensitive=true, $type='png', $width=48, $height=22, $verifyName='verify') {
        import('ORG.Util.String');
        import('ORG.Util.Image');
        $randval = $sessionStr = String::randString($length, $mode);
        if (true<>$caseSensitive) {
            $sessionStr = strtolower($sessionStr);
        }
        session($verifyName, md5($sessionStr));
        $width = ($length * 10 + 10) > $width ? $length * 10 + 10 : $width;
        if ($type != 'gif' && function_exists('imagecreatetruecolor')) {
            $im = imagecreatetruecolor($width, $height);
        } else {
            $im = imagecreate($width, $height);
        }
        $r = Array(225, 255, 255, 223);
        $g = Array(225, 236, 237, 255);
        $b = Array(225, 236, 166, 125);
        $key = mt_rand(0, 3);

        $backColor = imagecolorallocate($im, $r[$key], $g[$key], $b[$key]);    //背景色（随机）
        $borderColor = imagecolorallocate($im, 100, 100, 100);                    //边框色
        imagefilledrectangle($im, 0, 0, $width - 1, $height - 1, $backColor);
        imagerectangle($im, 0, 0, $width - 1, $height - 1, $borderColor);
        $stringColor = imagecolorallocate($im, mt_rand(0, 200), mt_rand(0, 120), mt_rand(0, 120));
        // 干扰
        for ($i = 0; $i < 10; $i++) {
            imagearc($im, mt_rand(-10, $width), mt_rand(-10, $height), mt_rand(30, 300), mt_rand(20, 200), 55, 44, $stringColor);
        }
        for ($i = 0; $i < 25; $i++) {
            imagesetpixel($im, mt_rand(0, $width), mt_rand(0, $height), $stringColor);
        }
        for ($i = 0; $i < $length; $i++) {
            imagestring($im, 5, $i * 10 + 5, mt_rand(1, 8), $randval{$i}, $stringColor);
        }
        Image::output($im, $type);
    }

    /**
     * 生成 UUID
     * @return string
     */
    static public function createUUID ()
    {
        if (function_exists('com_create_guid') === true) {
            $uuid = trim(com_create_guid(), '{}');
        } else {
            $uuid =sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X',
                            mt_rand(0, 65535),
                            mt_rand(0, 65535),
                            mt_rand(0, 65535),
                            mt_rand(16384, 20479),
                            mt_rand(32768, 49151),
                            mt_rand(0, 65535),
                            mt_rand(0, 65535),
                            mt_rand(0, 65535)
                   );
        }

        return $uuid;
    }

    /**
     * 将16进制颜色，提取出RGB颜色
     * @param string $colour
     * @return array
     */
    static public function hex2rgb( $colour )
    {
//        echo strlen ( $colour );die;
        if ($colour [0] == '#') {
            $colour = substr ( $colour, 1 );
        }
        if (strlen ( $colour ) == 6) {
            list ( $r, $g, $b ) = array (
                    $colour [0] . $colour [1],
                    $colour [2] . $colour [3],
                    $colour [4] . $colour [5]
            );
        } elseif (strlen ( $colour ) == 3) {
            list ( $r, $g, $b ) = array (
                    $colour [0] . $colour [0],
                    $colour [1] . $colour [1],
                    $colour [2] . $colour [2]
            );
        } else {
            return false;
        }
        $r = hexdec ( $r );
        $g = hexdec ( $g );
        $b = hexdec ( $b );

        return array (
                'red' => $r,
                'green' => $g,
                'blue' => $b
        );
    }

    /**
     * 将RGB颜色转换成十六进制颜色值
     * @param string $rgbState
     * @return string
     */
    static public function rgb2hex($rgbState)
    {
        $_rgbState = strtolower($rgbState);
        $_rgbState = trim(trim($_rgbState), 'rgb()');
        $_rgbState = explode(',', $_rgbState);
        if (count($_rgbState)==3) {
            list($r, $g, $b) = $_rgbState;
            $color = sprintf('#%02s%02s%02s', dechex(intval($r)), dechex(intval($g)), dechex(intval($b)) );
            $color = strtoupper($color);
        } else {
            $color = $rgbState;
            if(strlen($color)==4 && $color[0]=='#') {
                $color = '#' . $color[1].$color[1] . $color[2].$color[2] . $color[3].$color[3];
            }
        }

        return $color;
    }

    /*
     * 根据图片路径和保存路径 生成一张要求的最大宽度的图片  因为大图和小图之间的比例是固定的 故不再生成小图
     * @param string $path 原图片路径
     * @param string $filename 原图片名称
     * @param string $pictype 图片类型
     * @param string $cardwidth 图片宽度
     * @param string $savepath 生成的图片保存路径
     * */
    static public function createThumbPic($path,$filename='',$pictype,$cardwidth='EDIT_CARD_SIZE', $savepath = '')
    {
//        G('begin');
        if ($savepath == '') {
            $savepath = './temp/upload/';
        } else {
            $savepath = rtrim($savepath, '/') . '/';
        }
//        $image = rtrim($path, '/') . '/' . $filename;
        $image = $path;

        //        $image =  WEB_ROOT_DIR . 'images/test/logo.gif';

        //取得源图片的宽度和高度
        $size_src = getimagesize($path);
        $w = $size_src['0'];
        $h = $size_src['1'];
        //对需要进行缩放的图片进行拷贝，创建为新的资源
        if ($size_src['mime'] == 'image/png') {
            $src = imagecreatefrompng($image);
        } elseif ($size_src['mime'] == 'image/gif') {
            $src = imagecreatefromgif($image);
        } else {
            $src = imagecreatefromjpeg($image);
        }
        imagesavealpha($src, true); //这里很重要,意思是不要丢了$thumb图像的透明色;
        $arr = array();
        if($cardwidth == 'EDIT_SELF_CARD'){//自己的名片生成格式不同
            $arr[0] =['width'=>690,'height'=>414,'name'=>'p-background.png'];
        }else{//企业版生成
            $arr = C($cardwidth);
        }


//        return $arr;
        foreach($arr as $val){
            //指定缩放出来的最大的宽度和高度
            $maxwidth = $val['width'];
            $maxheight = $val['height'];
            $picname = $val['name'];
            $w1 = $w;
            $h1 = $h;
            if($w >= $maxwidth){
                $w1 = $maxwidth;
                $radio= $maxwidth/$w;
                $h1 = $h*$radio;
                if($h1<1){//不能缩放的没有高度了
                    $h1 = 1;
                }
            }

            if($h1 >= $maxheight){
                $radio = $maxheight/$h1;
                $h1 = $maxheight;
                $w1 = $w1*$radio;
                if($w1<1){//不能缩放的没有宽度了
                    $w1 = 1;
                }
            }
            //声明个$w宽，$h高的真彩图片资源
            $image1 = imagecreatetruecolor($w1, $h1);
            imagealphablending($image1, false); //这里很重要,意思是不合并颜色,直接用$img图像颜色替换,包括透明色;
            //关键函数，参数（目标资源，源，目标资源的开始坐标x,y, 源资源的开始坐标x,y,目标资源的宽高w,h,源资源的宽高w,h）
            imagecopyresampled($image1, $src, 0, 0, 0, 0, $w1, $h1, $size_src['0'], $size_src['1']);
            imagesavealpha($image1, true); //这里很重要,意思是不要丢了$thumb图像的透明色;
            if('logo' == $pictype){//上传的是LOGO图
                $thisname = explode('-'
                    ,$picname);
                imagepng($image1, $savepath . $thisname[0].'-' . $filename);
            }else{//上传的是背景图
                /*已存在就删除*/
                if(file_exists($savepath .$picname)){
                    unlink($savepath . $picname);
                }
                imagepng($image1, $savepath . $picname);

            }
            //销毁资源
            imagedestroy($image1);

        }
//        G('end');
//        echo G('begin','end').'s';die;
        return true;

    }
    /**
     * 根据传入的ip地址，返回ip所在的区域(省份、城市)
     * @param string $ip ip地址
     * @return mixed 失败或者非法的ip地址返回false，其他返回查询到的ip地址信息
     */
    public static function getIpAreaByIp($ip){
    	if(ereg( "^[1-9][0-9]{1,2}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$",$ip))  {
    		include_once dirname(__FILE__).'/IpSource/IpArea.class.php';
    		$ipObj = new IpArea();
    		return  $ipObj->get ( $ip );
    	} else {
    		return false;
    	}
    }


    /*根据图片路径和保存路径 生成两张不同尺寸的图片*/
    static public function createLogoPic($path, $filename,$pictype='', $savepath = '')
    {
        if ($savepath == '') {
            $savepath = './temp/upload/';
        } else {
            $savepath = rtrim($savepath, '/') . '/';
        }

        $image = rtrim($path, '/') . '/' . $filename;
        //        $image =  WEB_ROOT_DIR . 'images/test/logo.gif';

        //取得源图片的宽度和高度
        $size_src = getimagesize($image);
        $w = $size_src['0'];
        $h = $size_src['1'];

        //对需要进行缩放的图片进行拷贝，创建为新的资源
        if ($size_src['mime'] == 'image/png') {
            $src = imagecreatefrompng($image);
        } elseif ($size_src['mime'] == 'image/gif') {
            $src = imagecreatefromgif($image);
        } else {
            $src = imagecreatefromjpeg($image);
        }
        imagesavealpha($src, true); //这里很重要,意思是不要丢了$thumb图像的透明色;

        //指定缩放出来的最大的宽度和高度
        $maxwidth1 = C('CARD_SIZE.showmaxwidth');
        $maxheight1 = C('CARD_SIZE.showmaxheight');
        $w1 = $w;
        $h1 = $h;
        if ($w >= $maxwidth1) { //如果当前宽度大于要求的最大宽度
            $radio1 = $maxwidth1 / $w; //缩略图1需要修改比例
            $w1 = $maxwidth1;
            $h1 = $h * $radio1;
        }

        if ($w < $maxwidth1) { //如果当前宽度大于缩略图3的最大宽度小于缩略图1的最大宽度
            $w1 = $w; //缩略图1的宽高取原值
            $h1 = $h;
        }


        if ($h1 >= $maxheight1) { //如果缩略图1的高度大于要求高度  调整缩略图1的宽和高
            $radio1 = $maxheight1 / $h1;
            $w1 = $w1 * $radio1;
            $h1 = $maxheight1;
        }

        //声明两个$w宽，$h高的真彩图片资源
        $image1 = imagecreatetruecolor($w1, $h1);
        imagealphablending($image1, false); //这里很重要,意思是不合并颜色,直接用$img图像颜色替换,包括透明色;
        //关键函数，参数（目标资源，源，目标资源的开始坐标x,y, 源资源的开始坐标x,y,目标资源的宽高w,h,源资源的宽高w,h）
        imagecopyresampled($image1, $src, 0, 0, 0, 0, $w1, $h1, $size_src['0'], $size_src['1']);
        imagesavealpha($image1, true); //这里很重要,意思是不要丢了$thumb图像的透明色;
        //告诉浏览器以图片形式解析
        //        header('content-type:image/png');
        if('logo' == $pictype){//上传的是LOGO图
            if ($size_src['mime'] == 'image/png') {
                imagepng($image1, $savepath . 'm-' . $filename);
            } elseif ($size_src['mime'] == 'image/gif') {
                imagepng($image1, $savepath . 'm-' . $filename);
            } else {
                imagepng($image1, $savepath . 'm-' . $filename);

            }
        }else{//上传的是背景图
            /*已存在就删除*/
            if(file_exists(WEB_ROOT_DIR .$savepath . 's-background.png')){
                @unlink(WEB_ROOT_DIR .$savepath . 's-background.png');
            }
            if(file_exists(WEB_ROOT_DIR .$savepath . 'background.png')){
                @unlink(WEB_ROOT_DIR .$savepath . 'background.png');
            }
            if(file_exists(WEB_ROOT_DIR .$savepath . 'background.png')){
                @unlink(WEB_ROOT_DIR .$savepath . 'background.png');
            }
            imagepng($image1, $savepath . 's-background.png');

        }

//        imagepng($image1, $savepath . 'm-' . $filename);
//        imagepng($image2, $savepath . 's-' . $filename);

        //销毁资源
        imagedestroy($image1);
        return true;
    }


    /**
     * 获取行业分类缓存数据方法
     * @param boolean $flushCache 是否刷新缓存，默认为false
     * @param string $rtnFormat 返回数据格式，R_ONE_TWO:一二级递归格式，ONE：只返回所有一级数据,ALL:返回所有一级和二级未处理的数据
     * @return array 返回获取到的数据
     */
	public static function getCacheIndustryData($rtnFormat='R_ONE_TWO',$flushCache = false){
		$name = 'industry_data_';
		$cache = Cache::getInstance('File',array('prefix'=>$name,'temp' => C('DATA_CACHE_PATH').'/Industry'));
		(C('CACHE_CLEAR.YELLOW_INDUSTRY') || $flushCache == 1) && $cache->rm($name);
		$dataSet = $cache->get($name);
		if(empty($dataSet)){
			set_time_limit(0);
			$params = array();
			$result = AppTools::WebService('Common', 'getAllCategory', $params);
			if($result['status'] == 0){
				$dataSet = $result['data'];
			}else{
				log::write('File:'.__FILE__.' LINE:'.__LINE__."\r\n".' 获取行业数据存储到缓存时出错：'.var_export($result,true));
			}
			$cache->set($name,$dataSet);
		}
		/**
		 * 处理获取到的原始数据
		 */
		$dataSet = Common::handleIndustry($dataSet,$rtnFormat);
		return $dataSet;
	}


	/**
	 * 获取省份数据
	 * @param int $format 返回数据格式，1:xml，2数组,默认为xml
	 * @param boolean $flushCache 是否刷新缓存中的数据
	 */
	public static function getCacheProvince($flushCache=false)
	{   set_time_limit(0);
        $flushCache=true;//每次刷新缓存（暂时）
		$name = 'province_data_';
		$cache = \Think\Cache::getInstance('File',array('prefix'=>$name,'temp' => C('DATA_CACHE_PATH').'/Province','expire'=>18000));
		(C('CACHE_CLEAR.LOAD_ALL_CITY_AGAIN') || $flushCache === true) && $cache->rm($name);
		$rst = $cache->get($name);
		if(empty($rst)){
				$params = array();
				$data = \AppTools::webService('\Model\RegionManage\RegionManage', 'getProviceList', array('params'=>$params ));//
                $data=$data['data']['list'];
					$simplexml = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><cities/>');
					foreach ($data as $v){
						$content = $simplexml->addChild ( 'code',$v['provincecode'] );
						$content->addAttribute ( 'code', $v['provincecode'] );
						$content->addAttribute ( 'name', $v['province'] );//
					}
					$rst = $simplexml->asXML ();
				$cache->set($name,$rst);
		}
		$returnStr = simplexml_load_string($rst);
		$arrData = array();
		foreach ($returnStr as $key=>$val){
			$code = (int)$val->attributes()->code;
			$arrData[$code] = array(
					'code'   => $code,
					'name'   => (string)$val->attributes()->name,
			);
		}
		$rst = $arrData;
		return $rst;
	}

	/**
	 * 获取发送客服消息token
	 * @param string $flushCache
	 * @return multitype:multitype:string number
	 */
	public static function getCustomMessageToken($appid,$secret,$expires=7200,$flushCache=false)
	{
		$name = 'custom_message'; //定义微信token的文件名称
		$cache = \Think\Cache::getInstance('File',array('prefix'=>$name,'temp' => C('TOKEN_STORAGE_PATH'), 'expire'=>$expires));
		if(C('CACHE_CLEAR.LOAD_TOKEN_AGAIN') || $flushCache === true){
			 $cache->rm($name);
		}
		$rst = $cache->get($name);
		$data = json_decode($rst,true);
		$logPath = C('LOG_PATH');
		if(!is_dir($logPath)){
			mkdir($logPath,0777,true);
		}
		$logPath .= 'wx_token_'.date('y_m_d').'.log';
		\Think\Log::write($rst.' ++ '.empty($data['access_token']).' ### GFunc auth start ##########'.print_r($data,1), \Think\Log::INFO,'',$logPath);
		if(empty($rst) || empty($data['access_token']) || $data['expires_in']<time()){
       		 $p = array('grant_type'=>'client_credential','appid'=>$appid,'secret'=>$secret);
        	 $urlToken = "https://api.weixin.qq.com/cgi-bin/token?".http_build_query($p);
             $rstToken = json_decode(self::httpGet($urlToken), true);
             $data = array();
             $data['access_token'] = $rstToken['access_token'];
             $data['expires_in'] = $rstToken['expires_in']+time(); 
             \Think\Log::write(' ### GFunc auth middle ##########'.print_r($data,1), \Think\Log::INFO,'',$logPath);
			 $cache->set($name,json_encode($data));
		}
		\Think\Log::write(' ### GFunc auth end ##########'.print_r($data,1), \Think\Log::INFO,'',$logPath);
		return $data;
	}
	
	/**
	 * 从redis缓存中获取微信token信息
	 * @param unknown $appid
	 * @param unknown $secret
	 * @param number $expires
	 * @param string $flushCache
	 */
	public static function getCustomMessageTokenFromRedis($appid,$secret,$expires=7200,$flushCache=false)
	{
		$redisObj = CacheRedis::getInstance();
		$key      = 'wx_token_msg'.C('Wechat.Token');
		if(C('CACHE_CLEAR.LOAD_TOKEN_AGAIN') || $flushCache === true){
			$redisObj->delete($key);
		}

		$rst  = $redisObj->get($key);
		$data = json_decode($rst,true);
		$logPath = C('LOG_PATH');
		if(!is_dir($logPath)){
			mkdir($logPath,0777,true);
		}
		$logPath .= 'wx_token_'.date('y_m_d').'.log';
		\Think\Log::write(' ### GFunc redis token  result ##########'.var_export(array(C('CACHE_CLEAR.LOAD_TOKEN_AGAIN'),$flushCache,$data),1), \Think\Log::INFO,'',$logPath);
		if(empty($rst) || empty($data['access_token']) || $data['expires_in']<time()){
			$p = array('grant_type'=>'client_credential','appid'=>$appid,'secret'=>$secret);
			$urlToken = "https://api.weixin.qq.com/cgi-bin/token?".http_build_query($p);
			$rstToken = json_decode(self::httpGet($urlToken), true);
			$data = array();
			$data['access_token'] = $rstToken['access_token'];
			$data['expires_in']   = $rstToken['expires_in']+time();
			\Think\Log::write(' ### GFunc redis set token ##########'.$urlToken.' == '.print_r($rstToken,1), \Think\Log::INFO,'',$logPath);
			$flag = $redisObj->set($key,json_encode($data),$expires);
		}
		\Think\Log::write(' ### GFunc redis get end ##########'.print_r($data,1), \Think\Log::INFO,'',$logPath);
		return $data;
	}
	
	/**
	 * 当发送微信消息失败后，如果返回0，再次发送
	 */
	public static function getSendWxMsgIndex($expires=300, $flushCache=false)
	{
		$name = 'send_message_again_index'; //定义微信token的文件名称
		$cache = \Think\Cache::getInstance('File',array('prefix'=>$name,'temp' => C('TOKEN_STORAGE_PATH'), 'expire'=>$expires));
		(C('CACHE_CLEAR.LOAD_TOKEN_AGAIN') || $flushCache === true) && $cache->rm($name);
		$rst = $cache->get($name);
		if(empty($rst)){
			$data = array('index'=>1);
			$cache->set($name,json_encode($data));
		}else{
			$data = json_decode($rst,true);
			$cache->set($name,json_encode(array('index'=>$data['index']+1)));
		}
		return $data;
	}
	/**
	 * curl get请求
	 * @param unknown $url
	 * @return mixed
	 */
	public static function httpGet($url) {
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
	 * 获取城市数据
	 * @param int $format 返回数据格式，1:xml，2数组,默认为数组
	 * @param boolean $flushCache 是否刷新缓存中的数据
	 */
	public static function getCacheCity($provinceCode=null,$flushCache=false)
	{   set_time_limit(0);
        $flushCache=true;//每次刷新缓存（暂时）
		$name = 'city_data_'.($provinceCode?$provinceCode:'');
		$cache = \Think\Cache::getInstance('File',array('prefix'=>$name,'temp' => C('DATA_CACHE_PATH').'/City','expire'=>18000));
		(C('CACHE_CLEAR.LOAD_ALL_CITY_AGAIN') || $flushCache === true) && $cache->rm($name);
		$rst = $cache->get($name);
		if(empty($rst)){
			$rst = array();
			if($provinceCode){
				$params = array('provincecode'=>$provinceCode);
				$result = \AppTools::WebService('\Model\RegionManage\RegionManage', 'manageCity', array('params'=>$params));
				if($result['status'] == 0){
					$data = $result['data']['list'];//
					foreach ($data as $v){
						$rst[] = array('code'=>$v['prefecturecode'],'name'=>$v['city']);//
					}
				}else{
					$rst = 'api interface return wrong!'.var_export($rst);
				}
			}else{
				$provinceList = self::getCacheProvince($flushCache);
				foreach ($provinceList as $province){
					$params = array('provincecode'=>$province['code']);
					$result = \AppTools::WebService('\Model\RegionManage\RegionManage', 'manageCity', array('param'=>$params));
					if($result['status'] == 0){
						$data = $result['data']['list'];
						foreach ($data as $v){
							$rst[$province['code']][] = array('code'=>$v['prefecturecode'],'name'=>$v['city']);
						}
					}else{
						$rst = 'api interface return wrong!'.var_export($rst);
					}
				}
			}
			$rst = serialize($rst);
			$cache->set($name,$rst);
		}
		$rst = unserialize($rst);
		return $rst;
	}

	/**
	 * 获取区数据
	 * @param int $format 返回数据格式，1:xml，2数组,默认为数组
	 * @param boolean $flushCache 是否刷新缓存中的数据
	 */
	public static function getCacheRegion($cityCode=null,$flushCache=false)
	{   set_time_limit(0);
        $flushCache=true;//每次刷新缓存（暂时）
		$name = 'region_data_'.($cityCode?$cityCode.'_':'');
		$cache = \Think\Cache::getInstance('File',array('prefix'=>$name,'temp' => C('DATA_CACHE_PATH').'/Region','expire'=>18000));
		(C('CACHE_CLEAR.LOAD_ALL_CITY_AGAIN') || $flushCache === true) && $cache->rm($name);
		$rst = $cache->get($name);
		if(empty($rst)){
			$rst = array();
			if($cityCode){
				$params = array('parentcode'=>$cityCode,'nocity'=>1);
				$result = \AppTools::WebService('\Model\City\City', 'getAllCity', array('param'=>$params));
				if($result['status'] == 0){
					$data = $result['data'];
					foreach ($data as $v){
						$rst[] = array('code'=>$v['citycode'],'name'=>$v['cityname']);
					}
				}else{
					$rst = 'api interface return wrong!'.var_export($rst);
				}
			}else{
				$cityList = self::getCacheCity(null,false);
				foreach ($cityList as $city){
					foreach ($city as $val){
						$params = array('parentcode'=>$val['code'],'nocity'=>1);
						$result = \AppTools::WebService('\Model\City\City', 'getAllCity', array('param'=>$params));
						if($result['status'] == 0){
							$data = $result['data'];
							foreach ($data as $v){
								$rst[$val['code']][] = array('code'=>$v['citycode'],'name'=>$v['cityname']);
							}
						}else{
							$rst = 'api interface return wrong!'.var_export($rst);
						}
					}
				}
			}

			$rst = serialize($rst);
			$cache->set($name,$rst);
		}
		$rst = unserialize($rst);
		return $rst;
	}

	/**
	 * 获取分类数据：(Hr职能分类数据、Hr专业分类数据、Hr行业分类数据)
	 * @param string $cateKey 分类模块名称，对应值为：position(hr职能分类) major(hr专业分类)
	 *        hrindustry((hr行业分类)) ypindustry(黄页企业行业分类) ypproduct(黄页产品分类)
	 * @param int $format 返回数据格式，1:xml，2数组,默认为xml
	 * @param boolean $flushCache 是否刷新缓存中的数据
	 * @param array $others 附加参数，可以返回键名对应的键值  showName=>ids 返回ids对应的名称数组
	 * @return mixed 可返还递归数组、一纬数组等
	 */
	public static function getCacheCategory($cateKey,$format=1,$flushCache=false,$others=array()){
		//定义分类模块参数
		$paramMap = array(
				'position' => array( /*hr职能分类*/
						'filePre'    =>'hr_position_data_', //文件名称前缀
						'dirName'    =>'HrPosition', //缓存目录名称
						'modelName'  => 'getHrPosiCate',//model类中的方法名称
						'listKey'    => 'list', //api返回的数据集合键名
				),
				'major' => array( /*hr专业分类*/
						'filePre'    =>'hr_major_data_', //文件名称前缀
						'dirName'    =>'HrMajor', //缓存目录名称
						'modelName'  => 'getHrMajorCate',//model类中的方法名称
						'listKey'    => 'list', //api返回的数据集合键名
				),
				'hrindustry' => array( /*hr行业分类*/
						'filePre'    =>'hr_industry_data_', //文件名称前缀
						'dirName'    =>'HrIndustry', //缓存目录名称
						'modelName'  => 'getHrInduCate',//model类中的方法名称
						'listKey'    => 'jobcategories', //api返回的数据集合键名
				),
				'ypindustry' => array( /*黄页企业行业分类*/
						'filePre'    =>'yp_industry_data_', //文件名称前缀
						'dirName'    =>'YpIndustry', //缓存目录名称
						'modelName'  => 'getYpIndusCate',//model类中的方法名称
						'listKey'    => 'bizcategories', //api返回的数据集合键名
				),
				'ypproduct' => array( /*黄页产品分类*/
						'filePre'    =>'yp_product_data_', //文件名称前缀
						'dirName'    =>'YpProduct', //缓存目录名称
						'modelName'  => 'getYpProductCate',//model类中的方法名称
						'listKey'    => 'productcategories', //api返回的数据集合键名
				),
		);
		if(!isset($paramMap[$cateKey])){
			log::write('File:'.__FILE__.' LINE:'.__LINE__."\r\n".' 查询分类数据出错：'.var_export(func_get_args(),true));
			return;
		}
		$map = $paramMap[$cateKey];

		//翻译文件列表
		$langFileMap = array(
				'hrindustry' => 'hrcateindustry',
				'position' 	 => 'hrcateposition',
				'major'      => 'hrcatemajor',
				'ypindustry' => 'ypcatebiz',
				'ypproduct'  => 'ypcateproduct'
		);
		//翻译文件中的变量前缀
		$iniVariableArr = array(
				'hrindustry' => 'HR_CATE_INDUSTRY_',
				'position'	 => 'HR_CATE_POSITION_',
				'major'	     => 'HR_CATE_MAJOR_',
				'ypindustry' => 'YP_CATE_INDUSTRY_',
				'ypproduct'  => 'YP_CATE_PRODUCT_'
		);
        $lang 	  = self::getUiLang();
        $langObj  = Factory::getTranslator();
        $langObj->mergeTranslation(LANG_PATH.$lang."/{$langFileMap[$cateKey]}.ini", 'ini');

		$name     = $map['filePre'];
		$cache = Cache::getInstance('File',array('prefix'=>$name,'temp' => C('DATA_CACHE_PATH').'/'.$map['dirName']));
		(C('CACHE_CLEAR.LOAD_ALL_CITY_AGAIN') || $flushCache === true) && $cache->rm($name);
		$rst = $cache->get($name);
		if(empty($rst)){
			$params = array('others'=>array('fnName'=>$map['modelName'],'listKey'=>$map['listKey'],'rows'=>30));
			$result = AppTools::WebService('Common', 'getAllCategory', $params);
			if($result['status'] == 0){
				$data = $result['data'];
				$simplexml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><positions/>');
				foreach ($data as $v){
					$content = $simplexml->addChild ( 'position',$v['name'] );
					$content->addAttribute ( 'id', $v['categoryid'] );
					$content->addAttribute ( 'pid', $v['parentid'] );
					$content->addAttribute ( 'name', $v['name'] );
				}
				$rst = $simplexml->asXML ();
			}else{
				$rst = 'api interface return wrong!'.var_export($rst);
			}
			$cache->set($name,$rst);
		}
		if($format == 2){//返回数组格式
			if(isset($others['showName'])){
				$xmlObj = simplexml_load_string($rst);
				$arrIds = explode(',', $others['showName']);
				$arrIds = array_flip($arrIds);//键值对转换
				$rtnArr = array();
				foreach ($xmlObj as $key=>$val){
					$id = (int)$val->attributes()->id;
					$transName = $iniVariableArr[$cateKey].$id;
					if(isset($arrIds[$id])){
						$rtnArr[$id] = $langObj->$transName;
					}
				}
				return $rtnArr;
			}else{
				//根据id返回名称数组
				Load('extend');
				$xmlObj = simplexml_load_string($rst);
				$arrData = array();
				foreach ($xmlObj as $key=>$val){
					$id = (int)$val->attributes()->id;
					$transName = $iniVariableArr[$cateKey].$id;
					$arrData[] = array(
							'id'   => $id,
							'name' => $langObj->$transName,
							'pid'  => (int)$val->attributes()->pid
					);
				}
				$rst = list_to_tree($arrData,'id','pid','child','0');//递归处理
			}

		}
		return $rst;
	}


	/**
	 * 分页数据处理
	 * @param $result 数据集合，包括status、msg、data
	 * @param $page   当前页码数
	 * @param $record 每页显示记录数
	 * @param $dataKey 数据集合的key值，默认为data,具体每个模块可能不同，参考api返回的值
	 */
	public static function handlePage($result,$page=1,$record=10,$dataKey='key')
	{
		if(!$page || !is_numeric($page)){
			$page = 1;
		}
		$dataSet      = $result['data'];
		//返回数据错误时
		if($result['status'] != 0 || empty($dataSet[$dataKey])){
			return array('data'=>array());
		}

		if(count($dataSet[$dataKey]) > $record){//针对假数据的处理
			$dataSet[$dataKey] = array_slice($dataSet[$dataKey], ($page-1)*$record,$record);
		}
		//对上一页、下一页进行处理
		$numfound  = intval($dataSet['numfound']); //api返回的查询到的总记录数
		$pagefound = ceil($numfound/$record); //总页数
		$nextpage  = $prevpage = '';
		$page > 1  && ($prevpage = $page-1);
		$page < $pagefound && ($nextpage = $page+1);

		$rtn = array(
				'numfound'  => $numfound,  //总记录数
				'pagecount'	=> $pagefound, //总页数
				'pagenext' 	=> $nextpage,  //下一页
				'pageprev'  => $prevpage,  //上一页
				'pagecurr'  => $page,       //当前页码数
				'data'      => $dataSet[$dataKey]
		);
		return $rtn;
	}

	/**
	 * 获得视频文件的缩略图
	 * @param string $file 视频文件路径
	 * @param string $name 生成缩略图存放路径
	 * @param int    $time
	 */
	public static function getVideoImg($file, $name='', $time='1')
	{
		if(empty($time)) $time = '1';//默认截取第一秒第一帧
		if(empty($name)){
			$name = WEB_ROOT_DIR . 'temp/tmp/' . self::createUUID() . '.jpg';
		}
		//exec("ffmpeg -i ".$file." -y -f mjpeg -ss ".$time." -t 0.001 -s 320x240 ".$name."",$out,$status);
// 		$str = "ffmpeg -i ".$file." -y -f mjpeg -ss 3 -t ".$time." -s 320x240 ".$name;
		//$str = "ffmpeg -i {$file} -y -q:v 2 -f image2 -ss 1 -vframes 1 {$name}";
		$str = "ffmpeg -i {$file} -vframes 1 -y -f image2 {$name}";
		//print_r($str);
		//echo $str."</br>";
		exec($str, $out, $status);
		$result = array('pic'=>$name, 'output'=>$out, 'result'=>$status);

		return $result;
	}

    //获得视频文件的缩略图
    public static function getUploadVideoImg($videourl,$videopicurl='',$time='1') {
        if(empty($time))$time = '1';//默认截取第一秒第一帧
        if(empty($videopicurl)){
            $videopicurl = WEB_ROOT_DIR.'temp/uploadvideos/videopic.png';
        }
//        return $videourl;
        $a = system('ffmpeg -i '.$videourl." -y -f image2 -ss 2 -t $time -s 640*360 ".$videopicurl,$retval);
//        print_r($retval);
        return $retval;//状态码  如果为0 则代表成功
    }

    //获得名片的缩略图
    function getMakeCardImg($returnUrl) {
        $imgurl = WEB_ROOT_DIR.'temp/uploadvideos/background1111.png';
        $retval =system('phantomjs rasterize.js '.$returnUrl .' '.$imgurl);
//        print_r($retval);
        return $retval;//状态码  如果为0 则代表成功
    }

	/**
	 * 生成带logo的二维码
	 * @param string $logoPath Logo文件路径
	 * @param string $qrText 二维码包含的信息
	 * @param number $matrixPointSize 图像大小。 1=>31pixel, 2=>62pixel, ...
	 * @param string $savePath 图像保存路径。 如果设置图像保存路径，不输出图像。
	 */
	public static function qrCodeWithLogo ($logoPath, $qrText, $matrixPointSize=3, $margin=4, $savePath=null)
	{
	    require_once LIB_ROOT_PATH."3rdParty/phpqrcode/phpqrcode.php";//引入PHP QR库文件
	    $errorCorrectionLevel = 'L';//容错级别
	    //生成二维码图片
	    $_tmpQrImg = TEMP_PATH . self::createUUID() . '_qrCode.png';
	    \QRcode::png($qrText, $_tmpQrImg, $errorCorrectionLevel, $matrixPointSize, $margin);

	    $result = false;
	    if ($logoPath !== FALSE && file_exists($_tmpQrImg)) {
	        $_tmpQrImg = imagecreatefrompng($_tmpQrImg);
	        $logo = imagecreatefromstring(file_get_contents($logoPath));
	        $QR_width = imagesx($_tmpQrImg);//二维码图片宽度
	        $QR_height = imagesy($_tmpQrImg);//二维码图片高度
	        $logo_width = imagesx($logo);//logo图片宽度
	        $logo_height = imagesy($logo);//logo图片高度
	        $logo_qr_width = $QR_width / 5;
	        $scale = $logo_width/$logo_qr_width;
	        $logo_qr_height = $logo_height/$scale;
	        $from_width = ($QR_width - $logo_qr_width) / 2;
	        //重新组合图片并调整大小
	        imagecopyresampled($_tmpQrImg, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,
	        $logo_qr_height, $logo_width, $logo_height);

	        if ($savePath) {
	            $result = ImagePng($_tmpQrImg, $savePath);
	        } else {
	            //输出图片
	            Header("Content-type: image/png");
	            $result = ImagePng($_tmpQrImg);
	        }
	    }

	    return $result;
	}

    /**
     * 资讯中用到的   图片替换成uub格式
     *正则匹配html标签中的图片
     * @param  string $content html字符串
     * @return $content 返回替换后的html字符串
     */
   static public function replaceToUub($content){
        //匹配content中的所有图片    $match[0]是整个图片标签   $match[1]是图片路径
        preg_match_all("/\<img.*?src\=\"(.*?)\"[^>]*>/i", $content, $match);
        //print_r($match);die;
        $uploadPaths = array();
        for ($i = 0; $i < count($match[0]); $i++) {
            if (preg_match("/audio/", $match[0][$i])){
                continue;
            }

            if(strstr($match[1][$i],'http')){//判断是服务器上的图片地址还是本地的图片地址  如果是本地的添加上绝对路径
                continue;
            }else{
                $url =  rtrim($_SERVER['DOCUMENT_ROOT'],'/') . '/'.ltrim($match[1][$i],'/');
                $uploadinfo = \AppTools::webService('\Model\Upload\Upload', 'uploadFile', array('filepath'=>$url));
                //print_r($uploadinfo);die;
                if ($uploadinfo['status'] == 0) {
                    $uploadPaths[$i] = $uploadinfo['data']['path'];
                }
            }
        }

        //将content中的图片标签  替换成上传后的图片id
        for($i=0;$i<count($match[0]);$i++){
            if(strpos($match[0][$i],'http') === false){  //如果不包含http证明是本地图片   可以替换
                $content = str_replace($match[1][$i], $uploadPaths[$i],$content );
            }
        }

        $content = str_replace(array('color:red;'), "",$content );   //替换掉关键字的红色
        $content = str_replace("<br/></p>", "&nbsp;</p>",$content );   //不替换的话，火狐保存的1个空行在IE下显示2个
        $content = preg_replace("/<p>&nbsp;<\/p>$/", "", $content); //解决编辑时尾部增加新的空行的问题
        return $content;
    }

    /**
     * 资讯中用到的   uub格式替换成图片
     * 将字符串中的uub格式替换回原图片
     * @param string $content 资讯内容
     * @param int $type 1不需要登陆 empty需要登陆
     * @return $content 替换图片后的内容
     * */
    static public function replaceToImg($content, $type=''){
        //$content  = str_replace(array("\r\n","\n",' '), array("<br/>","<br>","&nbsp;&nbsp;"),$content );  //替换换行符
        //$content  = str_replace('[b]', '<strong>',$content );  //替换strong  字体加粗标签
        //$content  = str_replace('[/b]', '</strong>',$content );
        $result = array();
        preg_match_all("/\[\[(.*?)\]\]/",$content, $result);//正则匹配中括号内的内容
//        print_r($content);die;
        $html = '';
        if(!empty($result[1])){
            $j=0;
            foreach($result[1] as $v){
                $params = array();
                $params['uploadid'] = $v;
                $params['type'] = $type;
                $picinfo = \AppTools::webService('\Model\News\News', 'getUploadPic', array('params'=>$params));
//                 print_r($picinfo);die;
                if($picinfo['status'] == '0' && $picinfo['data']['numfound'] != 0){
                    $html = '<img class="mCS_img_loaded" uuid="'.$v.'" src="'.$picinfo['data']['list'][0]['path'].'">';
                    $content = str_replace($result[0][$j], $html,$content );//将uub格式替换成图片地址
                }else{
                    $html = '<img class="mCS_img_loaded" uuid="'.$v.'" src="" title="图片未找到">';
                    $content = str_replace($result[0][$j], $html,$content );//将uub格式替换成图片地址
                }

                $j++;
            }
        }
//        $content  = str_replace(array("\r\n","\n",' '), array("<br/>","<br/>","&nbsp;&nbsp;"),$content );
        return $content;
    }

    /**
     * 播放器图片换成audio标签
     * @param str $content
     * @return str
     */
    public static function replaceImgToAudio($content){
        //$root = U('/','','','', true);
        preg_match_all("/<img[^>]*audio(.*?)\/>/", $content, $arr);
        $images = $arr[0];
        $audios = array();
        for ($i = 0; $i < count($images); $i++) {
            preg_match_all("/audio\=\"(.*?)\"/", $images[$i], $audio);
            if (strpos($audio[1][0], "http") === 0){
                $audios[] = $audio[1][0];
            } else {
                //$audios[] = $_SERVER['DOCUMENT_ROOT'].$audio[1][0];
                $audios[] =  WEB_ROOT_DIR.ltrim($audio[1][0],'/');
            }

        }

        for ($i = 0; $i < count($audios); $i++) {
            $replace_str = '';
            if (strpos($audios[$i], "http") === 0){
                $replace_str = "<audio src=\"{$audios[$i]}\" controls ></audio>";
            } else {
                $rst = \AppTools::webService('\Model\Upload\Upload', 'uploadFile', array('filepath'=>$audios[$i]));
                if ($rst['status'] == 0){
                    $replace_str = "<audio src=\"{$rst['data']['path']}\" controls >Do not support audio tag!</audio>";
                }
            }
            $content = str_replace($images[$i], $replace_str, $content);
        }
        return $content;
    }

    /**
     * audio标签换成播放器图片
     * @param str $content
     * @return str
     */
    public static function replaceAudioToImg($content){
        preg_match_all("/<audio src=(.*?) controls >Do not support audio tag!<\/audio>/", $content, $arr);
        $playerImg = U('/','','','', true).'js/jsExtend/ueditor/themes/audio.png';
        $audios = $arr[0];
        for ($i = 0; $i < count($arr[1]); $i++) {
            $url = trim($arr[1][$i], '"');
            $replace_str = "<img audio=\"{$url}\" src=\"{$playerImg}\" />";
            $content = str_replace($audios[$i], $replace_str, $content);
        }

        return $content;
    }

    /**
     * 播放器图片换成video标签
     * @param str $content
     * @return str
     */
    public static function replaceImgToVideo($content){
        //$root = U('/','','','', true);
        preg_match_all("/<img[^>]*video(.*?)\/>/", $content, $arr);
        $images = $arr[0];
        $videos = array();
        for ($i = 0; $i < count($images); $i++) {
            preg_match_all("/video\=\"(.*?)\"/", $images[$i], $video);
            if (strpos($video[1][0], "http") === 0){
                $videos[] = $video[1][0];
            } else {
                //$audios[] = $_SERVER['DOCUMENT_ROOT'].$audio[1][0];
                $videos[] =  WEB_ROOT_DIR.ltrim($video[1][0],'/');
            }

        }

        for ($i = 0; $i < count($videos); $i++) {
            $replace_str = '';
            if (strpos($videos[$i], "http") === 0){
                $replace_str = "<video src=\"{$videos[$i]}\" controls ></video>";
            } else {
                $rst = \AppTools::webService('\Model\Upload\Upload', 'uploadFile', array('filepath'=>$videos[$i]));
                if ($rst['status'] == 0){
                    $replace_str = "<video src=\"{$rst['data']['path']}\" controls >Do not support video tag!</video>";
                }
            }
            $content = str_replace($images[$i], $replace_str, $content);
        }
        return $content;
    }

    /**
     * video标签换成播放器图片
     * @param str $content
     * @return str
     */

    public static function replaceVideoToImg($content){
        preg_match_all("/<video src=(.*?) controls >Do not support video tag!<\/video>/", $content, $arr);
        $playerImg = U('/','','','', true).'js/jsExtend/ueditor/themes/video.png';
        $videos = $arr[0];
        for ($i = 0; $i < count($arr[1]); $i++) {
            $url = trim($arr[1][$i], '"');
            $replace_str = "<img video=\"{$url}\" src=\"{$playerImg}\" />";
            $content = str_replace($videos[$i], $replace_str, $content);
        }

        return $content;
    }

    /**
     * 处理带有Orientation图片翻转信息的JPEG图片
     * param $imagePath 图片资源路径
     * param $dscPath 目标路径
     * 照片中EXIF Orientation 参数让你随便照像但都可以看到正确方向的照片而无需手动旋转（前提要图片浏览器支持，Windows 自带的不支持）
     *
     * */
    public static function delImgOrientation($imagePath, $dscPath = null)
    {
        /* exif_imagetype($imagePath)返回2为JPGE,为可能数码相机拍摄的照片
        ，可能包含Orientation信息， 先判断图片资源存在且为JPEG*/
        if (!file_exists($imagePath) || exif_imagetype($imagePath) != 2) {
            return false;
        }
        //$exifInfo['Orientation']值1为不旋转 3为旋转180度 6为顺时针90度 8为逆时针90度
        $exifInfo = @read_exif_data($imagePath, 'EXIF', 0);//获取图片的exif信息
        if ($exifInfo && in_array($exifInfo['Orientation'], array(3, 6, 8))) { //如果图片Orientation翻转，拷贝图像
            $size = getimagesize($imagePath);
            $weight = $size[0];
            $height = $size[1];
            $dstImg = @imagecreatetruecolor($weight, $height);//创建目标图像
            $srcImg = @imagecreatefromjpeg($imagePath);//读取源图像
            imagecopy($dstImg, $srcImg, 0, 0, 0, 0, $weight, $height);//复制图像
            $dscPath = isset($dscPath) ? $dscPath : $imagePath;//如未设置目标图片路径覆盖原图片
            imagejpeg($dstImg, $dscPath);//输出图片（覆盖原图片）
            imagedestroy($dstImg);//释放图像内存
            imagedestroy($srcImg);
        }
    }

    /**
     * 公用管理H5页面内容:回显处理操作
     * @param string  $key 唯一key值
     * @param int     $isPlay 默认0，音频不可播放,1:可以播放
     * @param string  $type 1 没权限   不填：有权限
     */
    public static function h5pageManageShow($key,$isPlay=0,$type='')
    {
    	$param = array('params'=>array('key'=>$key), 'crud'=>'R');
    	$result = \AppTools::webService('\Model\Admin\Apistore', 'apistoreAgreement',$param);
    	$content = empty($result['data']['list'])?'':$result['data']['list'][0]['content'];
    	if($content){
    		!$isPlay && $content = GFunc::replaceAudioToImg($content);
    		$content = GFunc::replaceToImg($content,$type);   //将内容中的图片uuid替换成图片地址
    	}
    	return $content;
    }

    /**
     * 公用管理H5页面内容:存储处理操作
     * @param string $key 唯一key值
     * @param string $content 要存储的富文本内容
     */
    public static function h5pageManageSave($key,$content)
    {

    	//匹配并替换content中的所有图片
    	if (!empty($content)) {
    		$content = GFunc::replaceToUub($content);
            // 替换音频
            $content = GFunc::replaceImgToAudio($content);
            //替换视频
            $content = GFunc::replaceImgToVideo($content);
    	}

    	//先查询判断数据是否存在
    	$param = array('params'=>array('key'=>$key), 'crud'=>'R');
    	$result = \AppTools::webService('\Model\Admin\Apistore', 'apistoreAgreement',$param);
    	//对数据进行更新操作
    	$saveMethod = empty($result['data']['list']) ? 'C' : 'U';//判断是添加还是修改操作
    	$param = array('params'=>array('key'=>$key,'content'=>$content), 'crud'=>$saveMethod);
    	$saveMethod == 'U' && $param['params']['id'] = $result['data']['list'][0]['id'];
    	$result = \AppTools::webService('\Model\Admin\Apistore', 'apistoreAgreement',$param);
    	return $result['status'];
    }

    /**
     * 获取内容协议key
     */
    public static function getArgeementKeys($index='')
    {
    	$keyList = array(
       			'activity'	=> 'OraAgreement_activityRule', //活动简介/活动规则
        		'invoice'	=>'OraAgreement_invoiceRule',  //开具发票介绍
        		'exchange'	=>'OraAgreement_exchangeRule', //兑换规则介绍
        		'orahelp'	=>'OraAgreement_oraHelp',      //APP橙子帮助
        		'intro'		=>'OraAgreement_intro', //功能简介或橙脉介绍
    			'newIntro'	=>'OraAgreement_newIntro', //新功能简介
        		'protocol'	=>'OraAgreement_protocol',  //协议管理
    	);
    	if($index && isset($keyList[$index])){
    		return $keyList[$index];
    	}else if($index && !isset($keyList[$index])){
    		return '';
    	}else{
    		return $keyList;
    	}
    }
}
