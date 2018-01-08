<?php
namespace Company\Controller;

use Model\Departments\Departments;
/**
 * 企业后台 部门管理
 */
class DepartmentsController extends BaseController
{

    public function _initialize(){
    	parent::_initialize();
    	// 增加翻译文件
    	$this->translator->mergeTranslation(APP_PATH . 'Lang/company-'. $this->uiLang . '.xml', 'xml');
    	$this->assign('T',$this->translator);
        //部门样式
        $this->assign('moreCSSs',array('css/Company/division'));
        //$_SESSION['Company']['accesstoken'] = '0A6ZyO1x64z3SRq7CfBBQNNYETcVAarWHRL8D3PV';

    }
    /**
     * 部门管理首页
     */
    public function index()
    {
    	$this->assign('breadcrumbs',array('key'=>'manageset','info'=>'departmanage','show'=>'')); //没有导航菜单
        $params['rows'] = 99999;
        $params['sort'] = 'createdtime asc';
        $result = $this->getDepartData($params);
        $this->departReturn($result);

        $this->assign("list",$result);
        $staff = $this->getDepartStaff();
        $this->assign('staff',$staff);
        $this->display('index');
    }

    public function getDepartData($params=array()){
        $result = \AppTools::webService('\Model\Departments\Departments', 'getDepartmentListM',array('params'=>$params));
        return $result;
    }

    public function departReturn($result=array()){

        if($result['data']['numfound'] > 0){
            $result = $this->treeDepart($result['data']['list']);
        }else{
            $result = array();
        }
        $tpls = $this->getTempDepart($result);
        if(empty($tpls)) $tpls = '';
        $this->assign('tpls',$tpls);
    }
    /*排序部门*/
    public function treeDepart($data){
        $treelist = array();
        foreach($data as $keys=>$vals){
            if($vals['parentid'] == 0){
                $treelist[$vals['id']] = $vals;
            }
        }
        $res = $this->treelist($treelist,$data);
        return $res;
    }
    public function treelist($listp,$lists){
        foreach($listp as $kp=>$vp){
            if(isset($vp['child'])){
                $listp[$kp]['child'] = $this->treelist($vp['child'],$lists);
            }else{
                foreach($lists as $kc=>$vc){
                    if($kp == $vc['parentid']){
                        $listp[$kp]['child'][$vc['id']] = $vc;
                        $listp[$kp]['child'] = $this->treelist($listp[$kp]['child'],$lists);
                    }
                }
            }
        }
        return $listp;
    }
    public function getTempDepart($listdata,$i=0){
        if(empty($listdata)) return array();
        $html = '';
        if($i!==0){
            $html .= '<ul class="tree-s tree-bg tree-p-top js_siblings">';
        }
        foreach($listdata as $key=>$val){
            if($i===0){
                $html .= '<div class="tree">
                            <ul class="tree-s">
                                <li class="tree-line">
                                    <div class="tree-fu js_showhidefu">';
                if(isset($val['child']) && is_array($val['child'])){
                    $html .= '<em class="add-icon js_showhide"></em>';
                }else{
                    $html .= '<em class="js_showhide"></em>';
                }
                $html.='<b class="line-h"></b><span class="js_depart_selected" title="'.$val['name'].'" data-did="'.$val['id'].'">';
                $html.= $val['name'].'</span>
                        <div class="add-child" data-status="'.$val['status'].'" data-name="'.$val['name'].'" data-did="'.$val['id'].'" data-pid="'.$val['parentid'].'">
                            <span class="add-ic js_adddepart" >添加子部门</span>
                            <span class="exchange-ic js_editdepart">修改</span>
                            <span class="remove-ic js_deldepart">删除</span>
                        </div>
                    </div>';
                if(isset($val['child']) && is_array($val['child'])){
                    $html .= $this->getTempDepart($val['child'],1);
                }
                $html .= '</li></ul></div>';
            }else{
                $html .= '<li class="tree-line tree-top">
                                    <div class="tree-fu js_showhidefu">
                                        <div class="line-w">';
                if(isset($val['child']) && is_array($val['child'])){
                    $html .= '<i class="f-bg bg-fff"><em class="add-icon js_showhide"></em>';
                }else{
                    $html .= '<i class="f-bg">';
                }
                $html .= '</i></div><span class="js_depart_selected" title="'.$val['name'].'" data-did="'.$val['id'].'">';
                $html .= $val['name'].'</span><div class="add-child" data-status="'.$val['status'].'" data-name="'.$val['name'].'" data-did="'.$val['id'].'" data-pid="'.$val['parentid'].'">
                                            <span class="add-ic js_adddepart">添加子部门</span>
                                            <span class="exchange-ic js_editdepart">修改</span>
                                            <span class="remove-ic js_deldepart">删除</span>
                                        </div>
                                    </div>';
                if(isset($val['child']) && is_array($val['child'])){
                    $html .= $this->getTempDepart($val['child'],1);
                }else{
                    $html .= '</li>';
                }
            }

        }
        if($i!==0){
            $html .= '</ul>';
        }

        return $html;
    }
    /*添加部门*/
    public function addDepartment(){
        $params = array();
        $params['name'] = urldecode(I('post.dname',''));
        $params['parentid'] = I('post.parentid','');
        $params['status'] = I('post.status',1);
        $params['bizid'] = $_SESSION['Company']['bizid'];
        $staffid = I('post.staffid','');

        $result = \AppTools::webService('\Model\Departments\Departments', 'addDepartmentM',array('params'=>$params));
        if($result['status']==0){
            if($staffid!=''){
                //修改员工
                $paramss['empid'] = $staffid;
                $paramss['depart'] = $result['data']['departid'];
                $paramss['batch'] = 1;
                $this->batchStaff($paramss);
            }
        }

        $this->ajaxReturn($result);

    }
    /*修改部门信息*/
    public function editDepartInfo(){
        $params = array();
        $params['departid'] = I('post.departid','');
        $params['name'] = urldecode(I('post.dname',''));
        $params['parentid'] = I('post.parentid','');
        $params['status'] = I('post.status',1);
        $staffid = I('post.staffid','');
        if($staffid!=''){
            //修改员工
            $paramss['empid'] = $staffid;
            $paramss['depart'] = $params['departid'];
            $paramss['batch'] = 1;
            $this->batchStaff($paramss);
        }

        $result = \AppTools::webService('\Model\Departments\Departments', 'editDepartmentM',array('params'=>$params));
        $this->ajaxReturn($result);
    }
    public function batchStaff($paramss){

        $staffres = \AppTools::webService('\Model\Departments\Departments', 'editStaffM',array('params'=>$paramss));

    }

    /*删除部门信息*/
    public function delDepartInfo(){
        $params['departid'] = I('post.id','');
        if($params['departid'] == '') $this->ajaxReturn(array('status'=>'error','msg'=>'无效操作'));
        $result = \AppTools::webService('\Model\Departments\Departments', 'delDepartmentM',array('params'=>$params));
        $this->ajaxReturn($result);
    }
    /*获取员工*/
    public function getDepartStaff(){
        $name = urldecode(I('post.name',''));
        $name==''?'':$params['name'] = $name;
        $params['rows'] = 999999;
        $params['bizid'] = $_SESSION['Company']['bizid'];
        $params['is_del'] = 0;
        $result = $this->getStafflist($params,$type='listdata');
        $this->assign('list',$result);
        $stafftpl = $this->fetch('Departments/select_staff');
        if(IS_AJAX){
            $this->ajaxReturn($stafftpl);
        }else{
            return $stafftpl;
        }

    }

    /* 获取员工列表 */
    public function getStafflist($params=array(),$type=''){
        if(IS_AJAX && $type==''){
            $params = array();
            $params['department'] = I('post.did','');
            $params['rows'] = 999999;
            $params['bizid'] = $_SESSION['Company']['bizid'];
            $params['is_del'] = 0;
        }
        $result = \AppTools::webService('\Model\Departments\Departments', 'getStaffM',array('params'=>$params));
        if(IS_AJAX && $type=='listdata') {
            return $result['data']['list'];
        }else if(IS_AJAX){
            $returndata = array();
            $returndata['staffidarr'] = array();
            foreach($result['data']['list'] as $val){
                $returndata['staffids'] .= $val['id'].',';
                $returndata['staffnames'] .= $val['name'].',';
                array_push($returndata['staffidarr'],$val['id']);
            }
            $returndata['staffids'] = rtrim($returndata['staffids'],',');
            $returndata['staffnames'] = rtrim($returndata['staffnames'],',');
            $this->ajaxReturn($returndata);
        }else{
            return $result['data']['list'];
        }

    }

    /*获取部门 - 列表*/
    public function getDepartListTemp(){
        $name = urldecode(I('post.name',''));
        $name==''?'':$params['name'] = $name;
        $params['rows'] = 999999;
        $result = $this->getDepartData($params);
        $this->assign('list',$result['data']['list']);
        $stafftpl = $this->fetch('select_depart');
        if(IS_AJAX){
            $this->ajaxReturn($stafftpl);
        }else{
            return $stafftpl;
        }

    }

    /*判断部门是否存在*/
    public function departExist(){
        $params['rows'] = 99999;
        $params['sort'] = 'createdtime asc';
        $res = $this->getDepartData($params);
        if($res['data']['numfound']==0){
            $this->ajaxReturn(0);
        }else{
            $this->ajaxReturn(1);
        }
    }


}