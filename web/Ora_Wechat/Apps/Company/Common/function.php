<?php
    /**
     *图片验证功能--生成图片验证码的位置存储在session中
     */ 
    function generalImagePos($key=ACTION_NAME){
    	//添加图片验证码
    	$verify = array();
    	session($key.'verify',$verify);
    	$top  = mt_rand(0,74);
    	session($key.'verify.top',$top);
    	return $top;
    }
    
    /**
     * 把UTC时间转换成当前时区的时间
     * @param date $utcDate
     */
    function utcToCurrentTimeZone($utcDate){
        $utc = new \DateTimeZone('UTC');
        $now = new \DateTimeZone(date_default_timezone_get());
        $datetime = new \DateTime($utcDate, $utc);
        $datetime->setTimezone($now);
        return $datetime->format('Y-m-d H:i:s');
    }
    
    /**
     * 把当前时区的时间转换成UTC时间
     * @param date $utcDate
     */
    function currentTimeZoneToUTC($currentDate){
        $utc = new \DateTimeZone('UTC');
        $now = new \DateTimeZone(date_default_timezone_get());
        $datetime = new \DateTime($currentDate, $now);
        $datetime->setTimezone($utc);
        return $datetime->format('Y-m-d H:i:s');
    }
    
    /**
     * 在用户数据里，根据key和lang，返回对应数组
     * @param str $key
     * @param str $lang
     * @param arr $profile
     * @return arr|boolean
     */
    function getValueFromVcard($key, $index, $profile){
        //如果是名字，手机号
        if (in_array($key, ['name', 'mobile'])){
            return $profile[$key][$index];
        }
    
        //如果是自定义标签
        if (strpos($key, "selfdef") === 0){
            return $profile['selfdef'][$key];
        }
    
        //如果是公司相关数据
        if (in_array($key, ['company_name', 'department', 'job', 'web', 'email', 'fax', 'address', 'telephone'])) {
            return $profile['company'][0][$key][$index];
        }
    
        return '';
    }
    
    /**
     * 传入布局数据，生成vcard数据
     * @param arr $data
     * @return arr
     */
    function getVcardDataFromLayout($data){
        $arr = array(
            'name'=>array(),
            'mobile'=>array(),
            'company'=>array(
                array(
                    'department'   => array(),
                    'job'          => array(),
                    'address'      => array(),
                    'company_name' => array(),
                    'telephone'    => array(),
        
                    'fax'   => array(),
                    'email' => array(),
                    'web'   => array(),
                ),
            ),
            'selfdef'=>array(),
        );
        for ($i = 0; $i < count($data['TEXT']); $i++) {
            $tmp = $data['TEXT'][$i]['VALUE'];
            $v   = array('title'=>$tmp['LABEL'], 'value'=>$tmp['VALUE']);
            preg_match("/\\d/", $tmp['FIELD'], $matches);
            $index = 0;
            !empty($matches) && $index = $matches[0];
            $f   = preg_replace("/\\d/", '', $tmp['FIELD']);
        
            //姓名，手机
            if (in_array($f, array('name', 'mobile'))){
                $v['is_chinese'] = $index==0?'1':'0';
                $arr[$f][] = $v;
            }
        
            //公司信息
            if (in_array($f, ['company_name', 'department', 'job', 'web', 'email', 'fax', 'address', 'telephone'])) {
                $v['is_chinese'] = $index==0?'1':'0';
                $arr['company'][0][$f][] = $v;
            }
        
            //自定义标签
            if (strpos($tmp['FIELD'], 'selfdef') === 0){
                $arr['selfdef'][$tmp['FIELD']] = array('title'=>$tmp['LABEL'], 'value'=>$tmp['VALUE'], 'type'=>$tmp['SELFDEFTYPE']);
            }
        }
        return $arr;
    }
    
    /**
     * 把vcard数据揉到layout里，并做一些图片路径处理
     * @param arr $layout
     * @param arr $profile
     * @param str $imgFolder
     */
    function _mixLayoutByVcard(&$layout, $profile, $imgFolder){
        $icons = C('TEMPLATE_ICONS');
        for ($i = 0; $i < count($layout['TEXT']); $i++) {
            $field = $layout['TEXT'][$i]['VALUE']['FIELD'];
            preg_match("/\\d/", $field, $matches);
            $index = 0;
            !empty($matches) && $index = $matches[0];
            $arr = getValueFromVcard(strtolower(preg_replace("/\\d/", '', $field)), $index, $profile);
            $layout['TEXT'][$i]['VALUE']['VALUE'] = $arr['value'];
            $layout['TEXT'][$i]['VALUE']['LABEL'] = $arr['title'];
        }
    
        $rootdir = str_replace("\\", '/', WEB_ROOT_DIR);
        for ($i = 0; $i < count($layout['IMAGE']); $i++) {
            $img = $layout['IMAGE'][$i];
            if (!strpos($img['PHOTO'], '.')){
                //是图标，要替换一下
                $layout['IMAGE'][$i]['PHOTO'] = $icons[intval($img['PHOTO'])];
            } else {
                //一般图片，则添加访问路径
                $url = '/'.str_replace(array("\\", $rootdir), array('/', ''), $imgFolder).'/'.$img['PHOTO'];
                $layout['IMAGE'][$i]['PHOTO'] = $url;
            }
        }
    
        if (!empty($layout['TEMP']['BGURL'])){
            if (strpos($layout['TEMP']['BGURL'], 'http')===0){
                return;
            }
            $uploadDir = str_replace(WEB_ROOT_DIR, '/', C('UPLOAD_PATH')) ;
            if (strpos($layout['TEMP']['BGURL'], $uploadDir)===0){
                return;
            }
            
            $url = '/'.str_replace(array("\\", $rootdir), array('/', ''), $imgFolder).'/'.$layout['TEMP']['BGURL'];
            $layout['TEMP']['BGURL'] = $url;
        }
    }
    