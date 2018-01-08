<?php
namespace Company\Controller;

use Model\Departments\Departments;
/**
 * 企业后台 员工管理
 */
class StaffController extends BaseController
{
    private $rows = 20;

    public function _initialize(){
    	parent::_initialize();
    	// 增加翻译文件
    	$this->translator->mergeTranslation(APP_PATH . 'Lang/company-'. $this->uiLang . '.xml', 'xml');
    	$this->assign('T',$this->translator);
        //样式
        $this->assign('moreCSSs',array('css/Company/division'));
    }

    /**
     * 员工管理首页
     */
    public function index()
    {
    	$this->assign('breadcrumbs',array('key'=>'manageset','info'=>'staffmanage','show'=>'')); //没有导航菜单
        $type = I('get.type',1);
        $params = array();
        I('get.departid','')!=''?$params['department']=I('get.departid'):'';
        I('get.dname','')!=''?$params['dname']=urldecode(I('get.dname')):'';
        I('get.name','')!=''?$params['name']=urldecode(I('get.name')):'';
        //页码
        $p = (I('get.p')> 1) ? I('get.p') : 1;
        $params['rows'] = $this->rows;
        if(I('isdownload',0)) $params['rows'] = PHP_INT_MAX;
        $params['start']  = ($p - 1)*$params['rows'];
        $params['enable'] = $type;
        $params['is_del'] = 0;
        $params['bizid'] = $_SESSION['Company']['bizid'];
        $params['sort'] = 'createdtime desc';
        $result = \AppTools::webService('\Model\Departments\Departments', 'getStaffM',array('params'=>$params));
        $this->assign('list',$result['data']['list']);
        $this->assign('searchparams',$params);

        //dload
        //导出
        if(I('isdownload',0)){

            $headers = array(
                'name'=>'姓名',
                'mobile'=>'手机号',
                'email'=>'邮箱',
                'department_name'=>'部门'
            );

            $this->downLoadData($result['data']['list'],$headers,'员工管理');
            return ;
        }
        $this->assign('roleid',$_SESSION['Company']['roleid']);
        //分页
        $page = getpage($result['data']['numfound'],$this->rows);
        $this->assign('pagedata',$page->show());

        //获取部门
        $paramss['rows'] = 99999;
        $paramss['sort'] = 'createdtime asc';
        $depart = A('Departments');
        $retult_d = $depart->getDepartData($paramss);
        $depart->departReturn($retult_d);

        if($type==1){
            $this->display('index');
        }elseif($type==2){
            $this->display('auth');
        }else{
            $this->display('quiter');
        }

    }

    public function addStaff(){
        $params = array();
        $params['name'] = urldecode(I('post.sname'));
        $params['password'] = I('post.pwd');
        $params['mobile'] = I('post.mobile');
        $params['email'] = I('post.email','');
        $params['roleid'] = I('post.rid');
        $params['depart'] = I('post.did');
        $params['enable'] = 1;

        $result = \AppTools::webService('\Model\Departments\Departments', 'addStaffM',array('params'=>$params));
        $this->ajaxReturn($result['status']);

    }
    public function editStaff(){
        $params = array();
        I('post.id','')!=''?$params['empid'] = rtrim(I('post.id'),','):'';//id must
        I('post.name','')!=''?$params['name'] = I('post.name'):'';//
        I('post.pwd','')!=''?$params['password'] = strrev(I('post.pwd')):'';//
        I('post.mobile','')!=''?$params['mobile'] = I('post.mobile'):'';//
        I('post.email','')!=''?$params['email'] = I('post.email'):'';//
        I('post.roleid','')!=''?$params['roleid'] = I('post.roleid'):'';//角色
        I('post.did','')!=''?$params['depart'] = I('post.did'):'';//部门
        I('post.type','')!=''?$params['enable'] = I('post.type'):'';//状态（离职、认证）；
        I('post.batch','')!=''?$params['batch'] = I('post.batch'):'';
        $result = \AppTools::webService('\Model\Departments\Departments', 'editStaffM',array('params'=>$params));
        $this->ajaxReturn($result['status']);
    }
    public function delStaff(){
        $params = array();
        I('post.id','')!=''?$params['emp_id'] = I('post.id'):'';//id must
        $result = \AppTools::webService('\Model\Departments\Departments', 'delStaffM',array('params'=>$params));
        $this->ajaxReturn($result['status']);
    }
    /*
     * 批量导入
     * */
    public function importStaff(){
        $this->assign('moreScripts',array(
            'js/jsExtend/ajaxFileUpload/ajaxfileupload'
        ));
        $this->display('importstaff');
    }
    //导入提交
    function importPost(){
        if(IS_POST){
            $uploadfile = $_FILES['uploadfile']['tmp_name'];
            if (empty($uploadfile) or !file_exists($uploadfile)) {
                die('file not exists');
            }
            //Include path
            set_include_path(get_include_path() . PATH_SEPARATOR . LIB_ROOT_PATH . '3rdParty/PHPExcel/');
            // PHPExcel_IOFactory
            include 'PHPExcel.php';
            include 'PHPExcel/IOFactory.php';

            if (!class_exists('PHPExcel_IOFactory')) {
                //PHPExcel类未找到
                echo json_encode(array('status'=>1,'msg'=>'未知错误！'));die;
            }

            $inputFileType = \PHPExcel_IOFactory::identify($uploadfile);
            if (in_array($inputFileType, array('Excel2007', 'Excel5'))) {

                $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($uploadfile);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

                $addData = array();

                //组装入库数组
                foreach ($sheetData as $key => $value) {
                    if($key<=1){
                        continue;
                    }
                    $addData[$key]['name'] = $value['A'];
                    $addData[$key]['password'] = $value['B'];
                    $addData[$key]['mobile'] = $value['C'];
                    $addData[$key]['email'] = $value['D'];
                    $addData[$key]['depart'] = $value['E'];

                }

                $params['json_data'] = json_encode($addData);

                $res = \AppTools::webService('\Model\Departments\Departments', 'importStaffM', array('params'=>$params ));
                if($res['status']==0){
                    echo json_encode(array('status'=>0,'msg'=>'导入完毕'));die;
                }else{
                    echo json_encode(array('status'=>'error','msg'=>'导入失败'));die;
                }

            }

            echo json_encode(array('status'=>1,'msg'=>'文件格式错误'));die;
        }
    }


    /*
     * 数据导出
     * */
    public function exportData($data,$headers = array(),$type){
        $this->downloadData($data, $headers, '门禁卡数据统计_'.$type.'_'.$this->translator->str_exchange_static.date('Y-m-d_H-i-s',time()) );
        return ;
    }
    /**
     * 导出数据
     * @param unknown $statsList
     * @param unknown $headers
     */
    protected function downloadData(array $statsList, array $headers, $filename='Statistics')
    {
        /** Include PHPExcel */
        require_once LIB_ROOT_PATH . '3rdParty/PHPExcel/PHPExcel.php';

        $filename = strlen($filename) ? $filename : 'Stataistics';

        // Create new PHPExcel object
        $objPHPExcel = new \PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()
            ->setCreator("Oradt ImOra")
            ->setLastModifiedBy("Oradt ImOra")
            ->setTitle("Oradt ImOra Statistics Document")
            ->setSubject("Oradt ImOra Statistics Document")
            ->setDescription("Oradt ImOra Statistics Document, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Oradt ImOra Statistics Document");


        // Add some data
        $workSheet = $objPHPExcel->setActiveSheetIndex(0);
        $startColAscii = ord('A'); // 表格起始位置ascii
        $colPos = 0;
        $rowPos = 1;
        foreach ($headers as $_v) {
            $cellName = chr($startColAscii+$colPos).$rowPos;
            $workSheet->setCellValue($cellName, $_v);
            $colPos++;
        }
        $keys = array_keys($headers);
        foreach ($statsList as $_stat) {
            $rowPos++;
            foreach ($keys as $_pos=>$_v) {
                $cellName = chr($startColAscii+$_pos).$rowPos;
                $_v = isset($_stat[$_v]) ? $_stat[$_v] : '';
                $workSheet->setCellValue($cellName, $_v);
            }
        }

        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Statistics');


        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);


        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename*=utf-8\'\''.urlencode($filename).'.xlsx;');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }



    /*public function test(){
        $params = array();
        $params['empid'] = 10;
        $params['enable'] = 1;
        $result = \AppTools::webService('\Model\Departments\Departments', 'editStaffM',array('params'=>$params));
        $this->ajaxReturn($result['status']);
    }*/

}