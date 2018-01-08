<?php
namespace Appadmin\Controller;

use Model\Appadmin\Company;
use Model\Appadmin\Employee;
/**
 *企业信息管理管理控制器
 */
class CompanyInfoController extends AdminBaseController
{
    public function _initialize()
    {
        parent::_initialize();

        // $this->display(ACTION_NAME);
        //exit;
    }

    /*列表页*/
    public function index(){

        $rows=$this->rows;
        $p=I('p',1);
        $start=($p-1)*$rows;
        $sort = I('get.sort', 'id', 'strval,trim');//排序字段
        $sortType = I('get.sortType', 'desc');//排序升降：asc，desc
        $keyword=urldecode(I('keyword',''));
        $startTime=I('startTime',null);
        $endTime=I('endTime',null);
        $status=I('status',null);
        $createtime='';
        if ($startTime!=null && $endTime!=null) {
            $createtime = strtotime($startTime . ' 00:00:00') . ',' . strtotime($endTime . ' 23:59:59');
        } else {
            //用户只输入了开始时间
            if ($startTime!=null) {
                $createtime = strtotime($startTime . ' 00:00:00');
            }
            //如果用户只输入了结束时间
            if ($endTime!=null) {
                $createtime = strtotime('1970-01-01 00:00:00') . ',' . strtotime($endTime . ' 23:59:59');
            }
        }
        $params=array(
            'p'=>$p,
            'rows'=>$rows,
            'start'=>$start,
            'sort'=>$sort.' '.$sortType,
            'createdtime'=>$createtime,
            'status'=>$status,
            'bizname'=>$keyword

        );
        $model=new \Model\Appadmin\Company();
        $result=$model->manageCompanyInfo($params,'R');
        $numFound=$result['data']['numfound'];
        $totalpages = ceil($numFound / $rows);
        $page = getpage($numFound,$rows);//使用分页类
        $this->assign('pagedata', $page->show());//分配分页
        $this->assign('totalpage',$totalpages);//分配总页数
        $sortParams=array( //排序用url 传参
            'sortType'=> $sortType == 'asc' ? 'desc' : 'asc',
            'startTime'=>$startTime,
            'endTime'=>$endTime,
            'keyword'=>$keyword
        );
        $this->assign('list',$result['data']['list']);
        $this->assign('params',$params);
        $this->assign('sortParams',$sortParams);
        $this->assign('sort', $sort);//排序
        $this->assign('keyword', $keyword);//关键词
        $this->assign('sortType', $sortType);//asc or descc
        $this->assign('moreCSSs', array('js/jsExtend/datetimepicker/datetimepicker'));//加载css
        $this->assign('moreScripts', array('js/Appadmin/company','js/jsExtend/datetimepicker/datetimepicker'));
        $this->getCommonMenu('companyInfoList');
        
        $suite=new \Model\Appadmin\Suite();
        $res_suite=$suite->doRequest(array(),'G');
        $this->assign('suitefree',$res_suite['data']['suite_id']);
        $this->display('index');

    }

    //操作状态 激活 禁用 删除 锁定

    public function changeStatus(){
        $id=I('id');
        if(is_array($id)){
            $id=join(',',$id);
        }
        $params['id']=$id;
        $params['status']=I('status');
        $model=new \Model\Appadmin\Company();
        $result=$model->doRequest($params,'U');
        $this->ajaxReturn($result);

    }

    //赠送套餐
     public function suite(){
        $suite_id=I('suite_id');
        $biz_id=I('biz_id');
        $params['metaid']=$suite_id;
        $params['bizid']=$biz_id;
        $params['orderType']=1;
        $model=new \Model\Appadmin\Suite();

        $result=$model->doRequest($params,'B');
        $this->ajaxReturn($result); 
    }

   public function  detail(){
       $params['id']=I('id');
       $model=new \Model\Appadmin\Company();
       $result=$model->manageCompanyInfo($params,'R');
       $info=$result['data']['list'][0];
       $this->assign('info',$info);
       $this->getCommonMenu('companyInfoList');
       $this->display('detail');
   }
   
   //企业员工列表
   public function  employee(){
       
       $rows=$this->rows;
       $p=I('p',1);
       $start=($p-1)*$rows;
       $sort = I('get.sort', 'id', 'strval,trim');//排序字段
       $sortType = I('get.sortType', 'desc');//排序升降：asc，desc
       $keyword=urldecode(I('keyword','')); 
       $status=I('status',null);
       
       $params=array(
           'p'=>$p,
           'rows'=>$rows,
           'start'=>$start,
           'sort'=>$sort.' '.$sortType, 
           'enable'=>$status,
           'name'=>$keyword
       
       );
 
       $params['bizid']=I('bizid');
       $model=new \Model\Appadmin\Employee();
       $result=$model->doRequest($params,'R');

       $list=$result['data']['list'];  
       $this->assign('list',$list);
       
       $numFound=$result['data']['numfound'];
       $totalpages = ceil($numFound / $rows);
       $page = getpage($numFound,$rows);//使用分页类
       $this->assign('pagedata', $page->show());//分配分页
       $this->assign('totalpage',$totalpages);//分配总页数
       $sortParams=array( //排序用url 传参
           'bizid'=>$params['bizid'],
           'sortType'=> $sortType == 'asc' ? 'desc' : 'asc', 
           'keyword'=>$keyword
       );
       $this->assign('params',$params);
       $this->assign('sortParams',$sortParams);
       $this->assign('sort', $sort);//排序
       $this->assign('keyword', $keyword);//关键词
       $this->assign('sortType', $sortType);//asc or descc
       $this->assign('moreScripts', array('js/Appadmin/company'));
       $this->getCommonMenu('companyInfoList');  
       $this->display('employee');
   }
   //修改员工密码
   public function employeepasswd(){

       $id=I('id'); 
       if(IS_POST){ 
           $params['id']=$id;
           $params['password']=I('password');
           $model=new \Model\Appadmin\Employee();
           $result=$model->doRequest($params,'P');
           $result['message'] = "密码修改成功";
           $this->ajaxReturn($result);
       }else{ 

          $params['id']=$id;
          $model=new \Model\Appadmin\Employee();

          $result=$model->doRequest($params,'R');
          $employee_info=$result["data"]["list"][0]; 
          $this->assign('employee_info',$employee_info);

          $this->getCommonMenu('companyInfoList');   
          $this->display('employeepasswd');
       }
        
   }
   //修改员工状态
   public function employeeStatus(){
       $id=I('id');
       if(is_array($id)){
           $id=join(',',$id);
       }
       $params['id']=$id;
       $params['status']=I('status');
       $model=new \Model\Appadmin\Employee();
       $result=$model->doRequest($params,'U');
       $this->ajaxReturn($result);
   
   }
   
   // 部门信息
   public function department(){
       $params['bizid']=I('bizid');
       $params['rows'] = 99999;
       $params['sort'] = 'createdtime asc';
       $model=new \Model\Appadmin\Department(); 
       $result=$model->doRequest($params,'R'); 
       $this->departReturn($result);
       $this->getCommonMenu('companyInfoList');
       $this->display('department');
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
               /* $html.= $val['name'].'</span>
                        <div class="add-child" data-status="'.$val['status'].'" data-name="'.$val['name'].'" data-did="'.$val['id'].'" data-pid="'.$val['parentid'].'">
                            <span class="add-ic js_adddepart" >添加子部门</span>
                            <span class="exchange-ic js_editdepart">修改</span>
                            <span class="remove-ic js_deldepart">删除</span>
                        </div>
                    </div>'; */
               $html.= $val['name'].'</span> 
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
               /* $html .= $val['name'].'</span><div class="add-child" data-status="'.$val['status'].'" data-name="'.$val['name'].'" data-did="'.$val['id'].'" data-pid="'.$val['parentid'].'">
                                            <span class="add-ic js_adddepart">添加子部门</span>
                                            <span class="exchange-ic js_editdepart">修改</span>
                                            <span class="remove-ic js_deldepart">删除</span>
                                        </div>
                                    </div>'; */
               $html.= $val['name'].'</span> 
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



}

/* EOF */
