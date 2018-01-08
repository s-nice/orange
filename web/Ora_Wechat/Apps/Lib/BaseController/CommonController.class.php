<?php
namespace BaseController;

use Classes\GFunc;
/**
 * 用户登陆基类
 * @author zhangpeng
 */
import('BaseController');
class CommonController extends BaseController
{
    /**
     * 默认行数
     * @var int
     */
    public $rows = 20;

    public function getNewsLabels($conditions=array(), $templatePath='')
    {
        // @todo 需要使用不同模板， 在这里加入判断提交， 设置相应模板
        $toCheckTemplate = (! $templatePath && I('myTemplate'));
        if ($toCheckTemplate) {
            switch (I('myTemplate')) {
                case '':
                    break;

                case 'adminManageLabel':
                    $templatePath = '';
                    break;

                case 'adminManageNews':
                    $templatePath = '../Appadmin/News/_labelsList';
                    break;

                default:
                    break;
            }
        }

        $params = array();
        $params['p']       = I('p', 1, 'intval');
        $params['rows']    = isset($conditions['rows']) ? $conditions['rows'] : $this->rows;
        $params['keyword'] = I('keyword', null);
        $params['sort']    = I('sort', 'asc');

        $this->assign($params);

        $params['sort']    = 'id,' . $params['sort'];
        $params = array_merge($conditions, $params);

        return $this->getLabels($params, $templatePath);
    }

    /**
     * 获取行业接口，也可以获取职能列表，根据type来区分,默认为1，1:表示获取行业，2：获取职能
     * @param unknown $conditions
     * @param string $templatePath
     * @return Ambigous <void, unknown>
     */
    public function getIndustries ($conditions=array(), $templatePath='',$isReturn=false)
    {
        //trace($conditions);
        //trace($templatePath);
        //trace($isReturn);
        // @todo 如果需要使用不同模板， 在这里加入判断提交， 设置相应模板
        $toCheckTemplate = (! $templatePath && I('myTemplate'));
        if ($toCheckTemplate) {
            switch (I('myTemplate')) {
                case '':
                    break;

                case 'adminManageIndustry':
                    $templatePath = '../Appadmin/BasicData/industry';
                    break;

                default:
                    break;
            }
        }

        $params = array();
        $params['p'] = I('p', 1, 'intval');
        $rows = I('rows', 0, 'intval');
        $params['type'] = I('type',1); //1:表示获取行业，2：获取职能
        $params['parentid'] = I('parentid',null);
        $params['categoryid'] = I('categoryid',null);
        $params['status'] = I('status',1);//默认状态为1已启用的数据 2为已停用的数据
        $max  = I('max',null); //是否获取全部数据,为真表示获取全部数据，不分页
        $max  && $rows = PHP_INT_MAX;
        $max  && $params['max'] = $max;
        $params['rows'] = isset($conditions['rows']) ? $conditions['rows'] : null;
        $params['rows'] = !isset($params['rows']) && $rows ? $rows : $params['rows'];
        $params['rows'] = $params['rows'] > 0 ? $params['rows'] : $this->rows;
        $params['categoryid'] = isset($conditions['categoryid']) &&  !isset($params['categoryid']) ? $conditions['categoryid'] : $params['categoryid'];
        $params['parentid'] = isset($conditions['parentid']) &&  !isset($params['parentid']) ? $conditions['parentid'] : $params['parentid'];
        $params['status'] = isset($conditions['status']) &&  !isset($params['status']) ? $conditions['status'] : $params['status'];
        $params['type'] = isset($conditions['type'])  ? $conditions['type'] : $params['type'];
        $params = array_merge($conditions, $params);

        return $this->_getIndustries($params, $templatePath,$isReturn);
    }

    /**
     * 获取职能信息
     * @param unknown $conditions
     * @param string $templatePath
     * @return Ambigous <unknown, NULL, mixed>
     */
    public function getPositions ($conditions=array(), $templatePath='')
    {
        // @todo 如果需要使用不同模板， 在这里加入判断提交， 设置相应模板
        $toCheckTemplate = (! $templatePath && I('myTemplate'));
        if ($toCheckTemplate) {
            switch (I('myTemplate')) {
                case '':
                    $templatePath = '';
                    break;

                default:
                    break;
            }
        }

        $params = array();
        $params['p'] = I('p', 1, 'intval');
        $params['parentid'] = I('parentid',null);
        $params['status'] = I('status',1); //默认状态为1已启用的数据 2为已停用的数据
        $max  = I('max',null); //是否获取全部数据,为真表示获取全部数据，不分页
        $params['rows'] = isset($conditions['rows']) ? $conditions['rows'] : $this->rows;
        $params['parentid'] = isset($conditions['parentid']) &&  !isset($params['parentid']) ? $conditions['parentid'] : $params['parentid'];
        $params['status'] = isset($conditions['status']) &&  !isset($params['status']) ? $conditions['status'] : $params['status'];

        return $this->_getPositions($params, $templatePath);
    }

    /**
     * 获取省、市、区数据
     */
    public function getRegion()
    {
    	//$params = array('parentid' => 0);//一级行业
    	//$industryList = \AppTools::webService('\Model\CompanyLogin\Register', 'getCategoryList', array('params'=>$params));//获取一级行业(职能)列表;
    	$type = I('get.type'); //获取类型provinceSet,citySet,regionSet
    	$id = I('id'); //省份或城市id
    	$dataSet = array();
    	switch ($type){
    		case 'provinceSet':
    			$dataSet = GFunc::getCacheProvince();//所有的省份列表
    			break;
    		case 'citySet':
    			!$id && die('$id is empty');
    			$dataSet = GFunc::getCacheCity($id); //某个省份下面的所有城市数据
    			break;
    		case 'regionSet':
    			!$id && die('$id is empty');
    			$dataSet = GFunc::getCacheRegion($id); //某个城市下面的所有区域数据
    			break;
    		default:
    	}
    	$this->ajaxReturn($dataSet);
    }

    /**
     * 上传会话内临时文件， 返回文件临时存放路径
     */
    public function uploadSessTmpFile ()
    {
        if (! isset($_SESSION[MODULE_NAME])) {
            return;
        }
        $uploadOpt = I('options');
        settype($uploadOpt, 'array');

        $upload = new \Think\Upload();
        $upload->maxSize  = isset($uploadOpt['maxSize']) ? $uploadOpt['maxSize'] : 1048576*10; //文件大小为10M
        $upload->exts     = isset($uploadOpt['exts']) ? explode(',',$uploadOpt['exts']) : null;//允许上传的文件大小
        $upload->rootPath = C('UPLOAD_PATH');
        $upload->saveRule = isset($uploadOpt['exts'])&&function_exists($uploadOpt['exts'])
                              ? $uploadOpt['exts'] : 'uniqueID' ;//上传文件命名规则，覆盖已有的函数
        $upload->autoSub = true;
        $upload->subType = 'date';
        if (! ($info =$upload->upload ()) ) {//上传错误提示错误信
            $errorMsg = $upload->getError ();
            trace('上传文件失败：' . __CONTROLLER__ . '::'.__METHOD__ . ' ('.$errorMsg.')');
            echo json_encode ( array (
                    'msg'    => $errorMsg,
                    'status' => 1
            ) );
        } else {
            $fileName = key($info);
            $path = '/temp/Upload/'.$info [$fileName] ['savepath'] . $info [$fileName] ['savename'];
            GFunc::delImgOrientation(WEB_ROOT_DIR.$path);
            $url = U('/','','','', true) . $path;
            echo json_encode ( array (
                    'url'    => $path,
                    'msg'    => 'success',
                    'status' => 0
            ) );
        }
    }

    /**
     * 待推送设置ajax 根据省id 市id 获取下级地区列表
     **/
    public function getAddressList(){
        $params['provincecode'] = I('id');
        $params['rows'] = PHP_INT_MAX;
        $data = \AppTools::webService('\Model\City\City', 'getCity', array('params'=>$params));
        $data = $data['data']['list'];
        $this->ajaxReturn($data);
    }

    /**
     * 获取所有省数据
     * @return array
     */
    public function getProvince(){
        $params['provincecode'] = I('provinceCodes');
        $params['rows'] = PHP_INT_MAX;
        $data = \AppTools::webService('\Model\City\City', 'getProvinceList', array('params'=>$params));
        if(IS_AJAX){
        	return $this->ajaxReturn($data);
        }else{
        	return $data;
        }
    }

    /**
     * 地区，行业，只能数据（用户推广，活动运营里用到）
     * @param array $data
     */
    public function getAreaCateJob($data){
//         print_r($data);die;
        //地区
        //$provinces = GFunc::getCacheProvince();//省份列表
        $provinces = $this->getProvince();//省份列表
        $this->assign('provinces', $provinces);
        $regionArr = $this->_getCityNames($data['region']);
        $this->assign('selectedProvinceCodes', $regionArr['selectedProvinceCodes']);
        $this->assign('selectedCityCodes',$data['region']);
        $this->assign('cityNames',$regionArr['cityNames']);

        //行业
        $industryArr = $this->getIndustryNames($data['industry']);
//         print_r($industryArr);die;
        $this->assign('industryList', $industryArr['industryList']);   //全部行业列表
        $this->assign('selectedIndustryParentCodes',$industryArr['selectedIndustryParentCodes']);
        $this->assign('selectedIndustryCodes',$data['industry']);
        $this->assign('industryNames',$industryArr['industryNames']);

        //职能
        $positionArr = $this->getPositionNames($data['func']);
        $this->assign('positionList',$positionArr['positionsList']);//全部职能列表
        $this->assign('selectedJobParentCodes',$positionArr['selectedJobParentCodes']);
        $this->assign('selectedJobCodes',$data['func']);
        $this->assign('jobNames',$positionArr['jobNames']);
    }

    /**
     * 根据城市code，获取城市名
     * @param str $region
     * @return str
     */
    public function _getCityNames($region){
        $str_selectedProvinceCodes = '';
        $cityNames = '';
        if($region){
            $selectedProvinceCodes = array();
            $cityNameList = array();

            $params = array();
            $params['prefecturecode'] = $region;
            $params['rows'] = PHP_INT_MAX;

            $data = \AppTools::webService('\Model\City\City', 'getCity', array('params'=>$params));
            for ($i = 0; $i < count($data['data']['list']); $i++) {
                $tmp = $data['data']['list'][$i];
                $selectedProvinceCodes[] = $tmp['provincecode'];
                $cityNameList[] = $tmp['city'];
            }
            $selectedProvinceCodes = array_unique($selectedProvinceCodes);
            $str_selectedProvinceCodes = join(',', $selectedProvinceCodes);
            $cityNames = join(',', $cityNameList);
        }
        return array('cityNames'=>$cityNames,'selectedProvinceCodes'=>$str_selectedProvinceCodes);
    }


    //根据行业代号获取名称
    public function getIndustryNames($industry){
        $industryList = $this->getIndustries(array('rows'=>PHP_INT_MAX, 'type'=>1),'',true);//获取所有行业数据;
        $industryList = $industryList['data']['list'];
        $selectedIndustryParentCodes = '';
        $industryNames = '';
        //如果有行业数据
        if ($industry){
            $selectedIndustryParentCodes = array();
            $industryNames = array();
            $industryCodes = explode(',', $industry);
            for ($i = 0; $i < count($industryCodes); $i++) {
                for ($j = 0; $j < count($industryList); $j++) {
                    if ($industryList[$j]['categoryid'] == $industryCodes[$i]){
                        $parentid = $industryList[$j]['parentid'];
                        for ($k = 0; $k < count($industryList); $k++) {
                            if ($industryList[$k]['parentid'] == '0' && $industryList[$k]['categoryid'] == $parentid){
                                $industryNames[] = $industryList[$j]['name'];
                                $selectedIndustryParentCodes[] = $industryList[$k]['categoryid'];
                                break;
                            }
                        }
                    }
                }
            }
            $selectedIndustryParentCodes = array_unique($selectedIndustryParentCodes);
            $selectedIndustryParentCodes = join(',', $selectedIndustryParentCodes);
            $industryNames = join(',', $industryNames);
        }
        return array('selectedIndustryParentCodes'=>$selectedIndustryParentCodes,'industryNames'=>$industryNames,'industryList'=>$industryList);
    }


    //根据职能代号获取名称
    public function getPositionNames($func){
        $parentIndustryList = $this->getIndustries(array('rows'=>PHP_INT_MAX, 'type'=>1, 'parentid'=>0),'',true);
        $parentIndustryList = $parentIndustryList['data']['list'];

        $positionsList = $this->getIndustries(array('rows'=>PHP_INT_MAX, 'type'=>2),'',true);//获取所有职能数据(type==2);
        $positionsList = $positionsList['data']['list'];

        $positionsList = array_merge($parentIndustryList, $positionsList);
//         print_r($positionsList);die;
        $selectedJobParentCodes = '';
        $jobNames = '';
        //如果有职能数据
        if (!empty($func)){
            $selectedJobParentCodes = array();
            $jobNames = array();
            $jobCodes = explode(',', $func);
            for ($i = 0; $i < count($jobCodes); $i++) {
                for ($j = 0; $j < count($positionsList); $j++) {
                    if ($positionsList[$j]['categoryid'] == $jobCodes[$i]){
                        $parentid = $positionsList[$j]['parentid'];
                        for ($k = 0; $k < count($positionsList); $k++) {
                            if ($positionsList[$k]['parentid'] == '0' && $positionsList[$k]['categoryid'] == $parentid){
                                $jobNames[] = $positionsList[$j]['name'];
                                $selectedJobParentCodes[] = $positionsList[$k]['categoryid'];
                                break;
                            }
                        }
                    }
                }
            }

            $selectedJobParentCodes = array_unique($selectedJobParentCodes);
            $selectedJobParentCodes = join(',', $selectedJobParentCodes);
            $jobNames = join(',', $jobNames);
        }
        return array('positionsList'=>$positionsList,'selectedJobParentCodes'=>$selectedJobParentCodes,'jobNames'=>$jobNames);
    }



    //获取orange标签类型
    public function getOraLabelType($params=array()){
        $params['cardtypeid']=isset($params['cardtypeid']) ? $params['cardtypeid'] : I('cardTypeId',null);
        $params['rows']=isset($params['rows']) ? $params['rows'] : I('rows',PHP_INT_MAX);
        $data = \AppTools::webService('\Model\Orange\OrangeLabel', 'manageLabel', array('params'=>$params,'type'=>2));
        if(IS_AJAX){
            return $this->ajaxReturn($data);
        }else{
            return $data;
        }
    }


    //获取orange标签
    public function getOraLabel($params=array()){
        $p = isset($params['p']) ? $params['p'] : I('p', 1, 'intval'); //页数
        $rows = isset($params['rows']) ? $params['rows'] : I('rows',$this->rows); //每页显示数量
        $name = isset($params['name']) ? $params['name'] : urldecode(I('name', null));//标签名称
        $typeid = isset($params['typeid']) ? $params['typeid'] : I('type', null);//标签类型
        $cardtypeid=isset($params['cardtypeid']) ? $params['cardtypeid'] : I('cardTypeId',null);//卡类型
        $params = array(
            'start' =>($p-1)*$rows,
            'rows' => $rows,
            'tag' => $name,
            'typeid' => $typeid,
            'cardtypeid'=>$cardtypeid,
            'sort' => 'id desc'
        );
        $data = \AppTools::webService('\Model\Orange\OrangeLabel', 'manageLabel', array('params'=>$params));
        if(IS_AJAX){
            return $this->ajaxReturn($data);
        }else{
            return $data;
        }

    }


}

/* EOF */
