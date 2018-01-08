<?php
namespace Classes;

class GConf
{
	const SUCC = 0; //api处理数据成功
	const NOT_LIMIT_KEY = 255; //下拉框中的不限项实际传递默认值
	const NOT_LIMIT_VAL = '--'; //下拉框中的不限项显示传递默认值

	const AUTH_HR_KEY  = 'hr';//hr权限者默认值
	const AUTH_YPS_KEY = 'yps';//黄页权限者默认值
	/****************
	 ** 定义一些系统默认变量名称 **
	****************/
	const KEY_URL_REDIRECT =  'oridt$$#$#';

	/****************
	 ** 定义一些系统默认常量值 **
	****************/
	const PAGE_RECORD = 10; //分页时每页默认显示记录数
	const API_STATUS_SUCC = 0; //api接口返回正确
	const LOGIN_PWD_ERROR_COUNT = 6;//密码输错最大次数
	const LOGIN_PWD_ERROR_TIME_MAX = 60;//密码输错错误次数重置时间限制，单位分钟

	const SIZE_VEDIO = 5;//5M 黄页产品大小限制
	const SIZE_IMG = 2;//2M 黄页图片限制

    const DEFAULT_VAL = 'NO';//系统默认值
    /****************
     ** 验证码相关 **
     ****************/
    const VERIFY_CODE_LEN            = 6;                        // 验证码长度
    const CO_VERIFY_CODE_NAME        = 'CO_VERIFY_CODE';         // 企业注册第三步短信验证码名字
    const CO_MODIFY_VERIFY_CODE_NAME = 'CO_MODIFY_VERIFY_CODE';  // 企业注册信息修改短信验证码名字

    /********************
     ** 正则表达式相关 **
     *******************/
    const MOBILE_NUMBER_REG  = '/^(13[0-9]{9}|15[012356789][0-9]{8}|18[02356789][0-9]{8}|147[0-9]{8})$/';

    public static $_APP_DOWNLOAD_LINK = array('iso'=>'http://www.apple.com/','android'=>'http://www.baidu.com'); //android和ios下载地址

    public static $_FORMAT_IMAGE = array('jpg','jpeg','png');//黄页产品图片支持格式
    public static $_FORMAT_VEDIO = array('mp4','m4v','avi','wmv','flv','3gp');

    /**
     * 企业规模 size
     */
    public static function getEntSize($T,$index=null)
    {
        $sizeSet = array(
            '1' => $T->STR_ENT_SIZE_ONE,//15人以下
            '2' => $T->STR_ENT_SIZE_TWO,//15-50人
            '3' => $T->STR_ENT_SIZE_THREE,//50-150人
            '4' => $T->STR_ENT_SIZE_FOUR,//150-500人
            '5' => $T->STR_ENT_SIZE_FIVE,//500-2000人
            '6' => $T->STR_ENT_SIZE_SIX,//2000人以上
        );
        if(isset($index)){
        	return isset($sizeSet[$index])?$sizeSet[$index]:'--';
        }
        return $sizeSet;
    }
    /**
     * 企业性质
     */
    public static function getEntNature($T,$key=null)
    {
    	//企业性质 ：不限/国企/民营/外商独资/股份制/上市公司/国家机关/其它
    	$natureSet = array(
    			'不限' => $T->STR_SELECT_NO_LIMIT,//不限
    			'国营' => $T->STR_ENT_NATUAL_ONE, //国营
    			'民营' => $T->STR_ENT_NATUAL_TWO, //民营
    			'外商独资' => $T->STR_ENT_NATUAL_THREE, //外商独资
    			'上市公司' => $T->STR_ENT_NATUAL_FIVE, //上市公司
    			'国家机关' => $T->STR_ENT_NATUAL_SIX,//国家机关
    			'其它' => $T->STR_ENT_NATUAL_SERVER, //其它
    	);
        if (isset($natureSet[$key])) {
            return isset($natureSet[$key])?$natureSet[$key]:'--';
        }
    	return $natureSet;
    }

    /**
     * 返回职位年薪
     * @return multitype:string
     */
    public static function getSalaryYear($T,$key=null)
    {
    	$salarySet = array(
    			'7'	=> $T->STR_SELECT_NEGOTIABLE,//不限
    			'1'		=> $T->STR_SALARY_YEAR_ONE, //5W以下
    			'2'		=> $T->STR_SALARY_YEAR_TWO, //5-10W
    			'3'		=> $T->STR_SALARY_YEAR_THREE, //10-20W
    			'4'		=> $T->STR_SALARY_YEAR_FOUR, //20W-50W
    			'5'		=> $T->STR_SALARY_YEAR_FIVE, //50W-100W
    			'6'		=> $T->STR_SALARY_YEAR_SIX, //100W以上
    	);
        if (!empty($key)) {
            return isset($salarySet[$key])?$salarySet[$key]:'--';
        }
    	return $salarySet;
    }
    /**
     * 获得学位要求
     * @return
     */
    public static function getDegree($T,$key=null)
    {
        $degreeSet = array(
            '10'    =>  $T->ACCOUNT_INFORMATION_DEGREE_UNLIMIT,//不限
            '1'     =>  $T->ACCOUNT_INFORMATION_DEGREE_JUNIOR,//初中
            '2'     =>  $T->ACCOUNT_INFORMATION_DEGREE_HIGH,//高中
            '3'     =>  $T->ACCOUNT_INFORMATION_DEGREE_SECONDARY,//中专
            '4'     =>  $T->ACCOUNT_INFORMATION_DEGREE_COLLEGE,//大专
            '5'     =>  $T->ACCOUNT_INFORMATION_DEGREE_UNDERGRADUATE,//本科
            '6'     =>  $T->ACCOUNT_INFORMATION_DEGREE_MASTER,//硕士
            '7'     =>  $T->ACCOUNT_INFORMATION_DEGREE_MBA,// MBA
            '8'     =>  $T->ACCOUNT_INFORMATION_DEGREE_EMBA,//EMBA
            '9'     =>  $T->ACCOUNT_INFORMATION_DEGREE_DOCTOR,//博士
        );
        if (!empty($key)) {
            return isset($degreeSet[$key])?$degreeSet[$key]:'--';
        }
        return $degreeSet;
    }
    /**
     * 工作经验
     */
    public static function getExperience($T,$key=null)
    {
    	$experienceSet = array(
            '7'=>$T->STR_EXPERIENCE_UNLIMIT,//不限
    		'1'=>$T->STR_EXPERIENCE_NOWORKS,//无经验
    		'2'=>$T->STR_EXPERIENCE_ONE,//1年以下
    		'3'=>$T->STR_EXPERIENCE_THREE,//1-3年
    		'4'=>$T->STR_EXPERIENCE_FIVE,//3-5年
    		'5'=>$T->STR_EXPERIENCE_TEN,//5-10年
    		'6'=>$T->STR_EXPERIENCE_OVER_TEN//10年以上
    	);
        if (isset($key)) {
            return isset($experienceSet[$key])?$experienceSet[$key]:'--';
        }
    	return $experienceSet;
    }

    /**
     * 目前状态
     */
    public static function getWorkStatus($T,$key=null)
    {
    	$workStatic = array(
    		'1'=>$T->HR_RESUME_STATIC_ON_JOB,
    		'2'=>$T->HR_RESUME_STATIC_LEAVE_OFFICE,
    		'3'=>$T->HR_RESUME_STATIC_CURRENT
    	);
        if (!empty($key)) {
            return isset($workStatic[$key])?$workStatic[$key]:'--';
        }
    	return $workStatic;
    }
    /**
     * 招聘人数
     */
    public static function getTotalJobs($T,$key=null)
    {
        $totalJobs = array(
            '101'    =>    '若干',
            '1'    =>    1,
            '2'    =>    2,
            '3'    =>    3,
            '4'    =>    4,
            '5'    =>    5,
            '6'    =>    6,
            '7'    =>    7,
            '8'    =>    8,
            '9'    =>    9,
            '10'   =>    10,
        );
        return $totalJobs;
    }
    /**
     * 年龄要求
     */
    public static function getAges($T,$key=null)
    {
        $ageStatic = array(
            '1'    =>    '不限',
            '2'    =>    '20-25',
            '3'    =>    '25-30',
            '4'    =>    '30-45',
            '5'    =>    '45-45',
            '6'    =>    '55-65',
        );
        if (!empty($key)) {
            return isset($ageStatic[$key])?$ageStatic[$key]:self::DEFAULT_VAL;
        }
        return $ageStatic;
    }
    /**
     * 婚姻状况
     */
    public static function getMarrige($T,$key=null)
    {
        $marrigeStatic = array(
            '1'    =>    '未婚',
            '2'    =>    '已婚',
            '3'    =>    '离异',
            '4'    =>    '丧偶',
            '5'    =>    '其他',
        );
        if (!empty($key)) {
            return isset($marrigeStatic[$key])?$marrigeStatic[$key]:DEFAULT_VAL;
        }
        return $marrigeStatic;
    }

    /**
     * 星期
     */
    public static function getWeek()
    {
    	$week = array(
    		'0'=>'星期日',
    		'1'=>'星期一',
    		'2'=>'星期二',
    		'3'=>'星期三',
    		'4'=>'星期四',
    		'5'=>'星期五',
    		'6'=>'星期六'
    	);
    	return $week;
    }
}
