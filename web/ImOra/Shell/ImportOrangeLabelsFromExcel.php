<?php
use Appadmin\Controller\ActiveOperationController;
define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);
define('APP_NAME', 'apps');
define('APP_PATH', __DIR__.'/../Apps/');
define('TMPL_PATH',__DIR__.'/../Apps/Tpl/');
define('CONF_PATH', __DIR__.'/../Config/');
define('RUNTIME_PATH',__DIR__.'/../Runtime/');
define('APP_DEBUG', true);
define('WEB_ROOT_DIR', realpath(__DIR__. '/../Public/' ) . DS);

define('LIB_ROOT_PATH', WEB_ROOT_DIR . '../Libs/');

define('__ROOT__', '');


set_include_path(get_include_path()
               . PS . __DIR__ . '/../Apps/Lib'
               . PS . __DIR__  .'/../Libs'
               . PS . __DIR__ . '/../Libs/ThinkPHP/Library' );

$config = require(__DIR__ . '/../Config/config.php');

require(__DIR__ . '/../Apps/Common/Common/AppTools.php');
require(__DIR__ . '/../Apps/Common/Common/common.php');
require(LIB_ROOT_PATH . 'Classes/GFunc.class.php');
require(LIB_ROOT_PATH . 'Classes/ErrorCoder.class.php');
require(LIB_ROOT_PATH . 'Classes/Factory.class.php');

define('EXT', '.php');
define('LIB_PATH', __DIR__ . '/../Libs/ThinkPHP/Library');

require('ThinkPHP/Common/functions.php');
require('Think/Think.class.php');
require('Think/Log.class.php');
require('Think/Log/Driver/File.class.php');


C($config);
$apiConfig = require(__DIR__ . '/../Apps/Common/Conf/ApiInterfaceMaps.php');

C($apiConfig);
define('MODULE_NAME', 'AppAdmin');

C('LOG_PATH', RUNTIME_PATH . 'Logs/Appadmin/');
C('LOG_TYPE', 'File');


require('Model/WebService.class.php');


$user = 'cloud_admin@oradt.com';
$pass = 'Oradt!123';

$user = 'admin@qq.com';
$pass = '123456';
// 注册AUTOLOAD方法
spl_autoload_register('Think\Think::autoload');
// 设定错误和异常处理
register_shutdown_function('Think\Think::fatalError');
set_error_handler('Think\Think::appError');
set_exception_handler('Think\Think::appException');

$tokenInfo = \Classes\GFunc::checkUsernameAndPassword($user, $pass, 'admin');
$session = array(
        'userType'		=> 'admin',
        'loginip'		=> get_client_ip(), // use this ip for check autologin
        'accesstoken'      => $tokenInfo['data']['accesstoken'],
        'tokenExpireTime' => $tokenInfo['data']['expiration'] + time(),
        'loginTimestamp'  => time()
);
session(MODULE_NAME, $session);


########################################
##           业务逻辑代码部分         ##
########################################

//计时开始
$starttime = explode(' ',microtime());

//include('./excel.php');
include('./excel519.php');
$uploadfile = './newexcel.xlsx';
$uploadfile_unit = './unitdata.xlsx';

$result_unit = excelunit($uploadfile_unit);//发卡单位数据
$result = excelToLabels($uploadfile);//标签、卡模板

//卡类型标签 定义
$cardtypetagarr = array('卡组织','卡等级','卡系列','卡种类','城市','卡性质','卡分类','健身种类','商户菜式','酒店等级','币种');

$cardtypeparams = array(
    'rows'=>30,
    'start'=>0,
    'sort'=>'id,asc'
);
$cardtypelist = \AppTools::webService('\Model\Orange\OrangeType', 'cardTypeM',array('params'=>$cardtypeparams));
$cardtypelist = $cardtypelist['data']['list'];

//检测和创建发卡单位属性（客服电话）
foreach($cardtypelist as $cardtypeval){
    //发卡单位属性匹配
    $prop = 0;
    foreach($cardtypeval['attribute'] as $vals){
        if($vals['attr'] == '客服电话' && $vals['type']==2){
            //发卡单位属性存在。
            $prop = 1;
        }
    }
    if($prop==0){
        //新增客服电话属性
        $attribute = '[{"ifdefault":2,"attr":"客服电话","val":"010-88888888","alert":"客服电话号码","type":"2","isedit":"1"}]';
        $params = array('id'=>$cardtypeval['id'],'attribute'=>$attribute);
        $issuerresult = \AppTools::webService('\Model\Orange\OrangeType', 'createIssuerM',array('params'=>$params));
    }
}
//更新卡类型数据
$cardtypelist = \AppTools::webService('\Model\Orange\OrangeType', 'cardTypeM',array('params'=>$cardtypeparams));
$cardtypelist = $cardtypelist['data']['list'];

//创建发卡单位，添加客服电话属性
foreachfuncunit($result_unit,$cardtypelist);

$cardtypeid = '';
set_time_limit(0);
foreach($result as $keys => $val){
    //匹配当前卡类型的id
    foreach($cardtypelist as $cardtypeval){
        if($val['cardType'] == $cardtypeval['firstname']){
            $cardtypeid = $cardtypeval['id'];
        }
    }
    if(empty($cardtypeid)){
        trace($cardtypeid,'创建标签类型日志','ERR',true);
    }else{
        $val['labels'] = buildTagsArr($val['list'],$cardtypetagarr);//组建标签数据
        foreachfunctag($val,$cardtypeid,$cardtypetagarr);//创建标签类型和标签（入库）
        createCardModel($val['list'],$cardtypeid,$cardtypetagarr);//生成卡模板
    }
}


/*计时结束*/
$endtime = explode(' ',microtime());
$thistime = $endtime[0]+$endtime[1]-($starttime[0]+$starttime[1]);
$thistime = round($thistime,3);

$fp = fopen('./logs.txt', 'a+b');
fwrite($fp, '本次导入执行耗时：'.$thistime." 秒。日期：".date('Y-m-d H:i:s')."\n");
fclose($fp);

/*
 * 循环组建标签数组
 * */
function buildTagsArr($list,$cardtypetagarr){
    $labels = array();
    foreach($list as $k=>$v){
        foreach($v as $kk => $vv){
            if(!in_array($kk,$cardtypetagarr)) continue;
            foreach($vv as $vvv){
                if( !isset($labels[$kk]) ) $labels[$kk] = array();
                if( !empty($vvv) && '…'!=$vvv && '无'!=$vvv ) array_push($labels[$kk],$vvv);
            }
            $labels[$kk] = array_unique($labels[$kk]);
        }
    }
    return $labels;
}

/*
 * 导入标签类型和标签
 * $val 标签数组
 * $cardtypeid 卡类型id
 * $cardtypetagarr 标签类型组
 * */
function foreachfunctag($val,$cardtypeid,$cardtypetagarr=array()){
    foreach($val['labelTypes'] as $vals){
        if(in_array($vals,$cardtypetagarr)){
            //创建卡类型标签类型
            $res = \AppTools::webService('\Model\Orange\OrangeLabel', 'manageLabel',array('params'=>array('name' => $vals,'cardtypeid'=>$cardtypeid),'type'=> 2,'crud'=> 'C'));
            if($res['status']!=0) trace($res,'创建标签类型日志','ERR',true);
        }
    }

    //获取卡类型的标签类型
    $tagtypelist = \AppTools::webService('\Model\Orange\OrangeLabel', 'manageLabel',array('params'=>array('rows'=>10000,'cardtypeid'=>$cardtypeid), 'type'=>2,'crud'=> 'R') );
    //循环已添加的标签类型
    foreach($tagtypelist['data']['list'] as $val_tagtype){
        //循环待添加的标签类型
        foreach($val['labels'] as $k_label => $vals_label){
            //判断是否存在标签类型
            if($val_tagtype['name'] == $k_label){
                //给标签类型添加标签
                foreach($vals_label as $vals_label_tag){
                    if(isset($vals_label_tag) && !empty($vals_label_tag)){
                        $params=array(
                            'tag'=>$vals_label_tag,
                            'typeid'=>$val_tagtype['id']
                        );
                        $res_r = \AppTools::webService('\Model\Orange\OrangeLabel', 'manageLabel',array('params'=>$params, 'type'=>1,'crud'=> 'C'));
                        if($res_r['status']!=0) trace($res_r,'创建标签日志','ERR',true);
                    }
                }
            }
        }
    }
}

/*
 * 导入发卡单位
 *
 * */
function foreachfuncunit($exceldata,$cardtypelist){
        //卡类型
        foreach($cardtypelist as $typeval){
                //发卡单位
                foreach($exceldata as $dbvals){
                    //判断是否匹配卡类型
                    if($dbvals['cardType']==$typeval['firstname']){
                        foreach($dbvals['list'] as $dbval){
                            $cardTypeAttrs = getPropSys($typeval['attribute']);
                            if($dbval['客服电话']!=''){
                                $cardTypeAttrs['adminValue'] = $dbval['客服电话'];
                            }else{
                                //表格数据客服电话为空时，给默认事例值
                                $cardTypeAttrs['adminValue'] = '010-88888888';
                            }

                            //创建发卡单位
                            $params = array(
                                'cardtypeid'=>$typeval['id'],
                                'lssuername'=> $dbval['发卡单位'],
                                'lssuernumber' => $dbval['单位序号'],
                                'attribute'=> json_encode($cardTypeAttrs, JSON_UNESCAPED_UNICODE)
                            );
                            $url = C('API_ORANGE_ISSUE_UNIT_ADD');
                            $res = \AppTools::webService('\Model\Common\Common',
                                'callApi',
                                array(
                                    'url'    => $url,
                                    'params' => $params,
                                    'crud'   => 'C'
                                )
                            );
                            if($res['status']!=0) trace($res,'创建发卡单位日志','ERR',true);
                        }
                    }
                }
        }

}

/*
 * 获取客服电话属性
 * */
function getPropSys($proplist=array()){
    foreach($proplist as $vv){
        if($vv['attr']=='客服电话'){
            return $vv;
        }
    }
}

/*
 * 创建卡模板
 * $vallsit 卡模板数据组
 * $cardtypeid 卡类型id
 * */
function createCardModel($vallsit,$cardtypeid,$cardtypetagarr){
    //获取卡类型下所有的标签，得到标签id，用于创建模板，根据名称传参tagid
    $taglist = \AppTools::webService('\Model\Orange\OrangeLabel', 'manageLabel',array('params'=>array('start'=>0,'rows'=>10000,'cardtypeid'=>$cardtypeid),'type'=> 1,'crud'=> 'R'));
    $taglist = $taglist['data']['list'];

    if(!empty($vallsit)){
        foreach($vallsit as $modelkey=>$modelval){

            $params = array();
            $params['cardtype'] = $cardtypeid;
            $params['bin'] = 0;
            $params['rule'] = '';
            $params['action'] = 'updatecard';

            $modelval['BIN码']!=''?$params['bin'] = $modelval['BIN码'][0]:$params['bin'] = '';
            $modelval['同步到橙子'][0]=='是'?$params['issynch'] = 1:$params['issynch'] = 0;
            $params['keyword'] = $modelval['搜索关键词'][0]; //多个用‘,’隔开
            $params['description'] = $modelval['卡模板名称'][0];

            //发卡单位cardunits
            $issuerparam = array();
            $issuerparam['cardtypeid'] = $cardtypeid;
            $issuerlist = \AppTools::webService('\Model\Orange\OrangeType', 'getIssuerM',array('params'=>$issuerparam));
            if(isset($issuerlist['data']['list']) && !empty($issuerlist['data']['list'])){
                $issuerlist = $issuerlist['data']['list'];
            }else{
                $issuerlist = array();
            }

            //标签
            foreach($modelval as $modelkeyk => $modelvalv){
                //发卡单位
                if($modelkeyk=='发卡单位'){
                    foreach($issuerlist as $issuerval){
                        if($issuerval['lssuername'] == $modelvalv[0]){
                            $params['cardunits'] = $issuerval['id'];
                        }
                    }
                }

                if(!in_array($modelkeyk,$cardtypetagarr)) continue;
                foreach($modelvalv as $modelkeykk => $modelvalvv){
                    foreach($taglist as $tag){
                        if($tag['tag'] == $modelvalvv) $params['tagid'] .= $tag['id'].',';
                    }
                }
            }

            //去掉‘,’
            $params['tagid'] = rtrim($params['tagid'],',');

            //获取模板编辑id
            $id = getCardDataId($cardtypeid);
            $params['id'] = $id;
            if($id!=0){
                $rst = \AppTools::webService('\Model\Orange\OrangeTemplate', 'cardTpl', array('params' => $params, 'crud'=>'C'));
                if($rst['status']!=0) trace($rst,'创建卡模板日志','ERR',true);
            }
        }
    }
}

//获取卡模板编辑id
function getCardDataId($cardtypeid){
    //没有经过模板编辑的添加
    //先保存卡类型里的模板数据，然后再添加
    $cardtype = \AppTools::webService('\Model\Orange\OrangeType', 'cardTypeM', array('params' => array('id'=>$cardtypeid), 'crud'=>'R'));
    $cardtype = $cardtype['data']['list'][0];
    if (!empty($cardtype)) {
        $tmpParam['picpatha'] = $cardtype['picpatha'];
        $tmpParam['picpathb'] = $cardtype['picpathb'];
        $tmpParam['snapshot'] = $cardtype['snapshot'];
        $tmpParam['vcard']      = $cardtype['vcard'];
        $tmpParam['persondata'] = $cardtype['persondata'];
        $tmpParam['action']     = 'updatetplstyle';

        $rst = \AppTools::webService('\Model\Orange\OrangeTemplate', 'cardTpl', array('params' => $tmpParam, 'crud'=>'C'));
        $id  = $rst['data']['id'];

        if (!empty($id)) {
            return $id;
        }else{
            trace($rst,'创建模板数据日志','ERR',true);
            return 0;
        }
    }else{
        trace($cardtype,'创建模板数据日志','ERR',true);
        return 0;
    }
}

exit;
/*
$fp = fopen('./a.txt', 'a+b');
fwrite($fp, var_export($result,ture));
fclose($fp);
die;
*/

