<?php
/**
 * 在穿过来的HTML字符串里，找到对应大小的span，并添加相应class
 * @param str $content
 * @return str
 */
function _fontSizeToClass($content){ 
    //给安卓微信浏览器用的，不加空格字会变小，因为对rem支持的不是很好
    $count = 300 - mb_strlen(strip_tags($content), 'UTF-8');
    if ($count > 0){
        $str = str_repeat("&nbsp;", $count).'<br/>';
        $content = preg_replace("/(<br\/>)*$/", $str, $content);
    }
/*     $search = array(
        '<span style="font-size:16px;">', '<span style="font-size: 16px;">',
        '<span style="font-size:20px;">', '<span style="font-size: 20px;">',
        '<span style="font-size:24px;">', '<span style="font-size: 24px;">',
        '<span style="font-size:28px;">', '<span style="font-size: 28px;">',
    );
    $replace = array(
        '<span class="small">', '<span class="small">',
        '<span class="normal">', '<span class="normal">',
        '<span class="big">', '<span class="big">',
        '<span class="bigger">', '<span class="bigger">',
    );
    $content = str_replace($search, $replace, $content); */
    //替换字体大小
    preg_match_all('/<span style="(.*?)?font-size:\s?([16|20|24|28]+)px;(.*?)?">/i', $content, $match);
    if($match[0]){
    	$classesName = array('16'=>'small','20'=>'normal','24'=>'big','28'=>'bigger');
    	$searchPreg = $replacePreg = array();
    	foreach ($match[0] as $index=>$oriData){
    		$searchPreg[] = $oriData;
    		$styleValue = $match[1][$index].$match[3][$index];
    		$style = trim($styleValue) ? 'style="'.$styleValue.'"' : '';
    		$replacePreg[] = '<span '.$style.' class="'.$classesName[$match[2][$index]].'" >';
    	}
    	$content = str_replace($searchPreg, $replacePreg, $content);
    }
    //替换 行后距
    preg_match_all('/style="(.*?)?margin-bottom:\s?([5|10|15|20|25|30]+)px;(.*?)?">/i', $content, $match);
    if($match[0]){
        $classesName = array('5'=>'marginb5','10'=>'marginb10','15'=>'marginb15','20'=>'marginb20','25'=>'marginb25','30'=>'marginb30');
        $searchPreg = $replacePreg = array();
        foreach ($match[0] as $index=>$oriData){
            $searchPreg[] = $oriData;
            $styleValue = $match[1][$index].$match[3][$index];
            $style = trim($styleValue) ? 'style="'.$styleValue.'"' : '';
            $replacePreg[] = '<span class="'.$classesName[$match[2][$index]].'" '.$style.'>';
        }
        $content = str_replace($searchPreg, $replacePreg, $content);
    }

    return $content;
}

/*移动端判断*/
function isMobile()
{ 
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    } 
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
    { 
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    } 
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
            ); 
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        } 
    } 
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT']))
    { 
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        } 
    } 
    return false;
} 

/**
 * 判断url是否能正常访问
 * @param $url string 访问网址
 * @return boolean 
 */
function checkUrlValid($url){
    $array = get_headers($url,1); 
    if(preg_match('/200/',$array[0])){ 
        return true;
    }else{ 
        return false;
    }
}

/**
 * 判断手机、平板、pc
 * @param $url string 访问网址
 * @return boolean 
 */
function userAgent(){
    $ua = $_SERVER['HTTP_USER_AGENT'];
    $iphone = strstr(strtolower($ua), 'mobile'); //Search for 'mobile' in user-agent (iPhone have that)
    $android = strstr(strtolower($ua), 'android'); //Search for 'android' in user-agent
    $windowsPhone = strstr(strtolower($ua), 'phone'); //Search for 'phone' in user-agent (Windows Phone uses that)
      
      
    function androidTablet($ua){ //Find out if it is a tablet
        if(strstr(strtolower($ua), 'android') ){//Search for android in user-agent
            if(!strstr(strtolower($ua), 'mobile')){ //If there is no ''mobile' in user-agent (Android have that on their phones, but not tablets)
                return true;
            }
        }
    }
    $androidTablet = androidTablet($ua); //Do androidTablet function
    $ipad = strstr(strtolower($ua), 'ipad'); //Search for iPad in user-agent
      
    if($androidTablet || $ipad){ //If it's a tablet (iPad / Android)
        return 'tablet';
    }
    elseif($iphone && !$ipad || $android && !$androidTablet || $windowsPhone){ //If it's a phone and NOT a tablet
        return 'mobile';
    }
    else{ //If it's not a mobile device
        return 'desktop';
    }    
}
