<?php
namespace Company\Controller;

use Model\Departments\Departments;
/**
 * 企业后台 回收站
 */
class RecoversController extends BaseController
{
    private $rows = 20;

    public function _initialize(){
    	parent::_initialize();
    	// 增加翻译文件
    	$this->translator->mergeTranslation(APP_PATH . 'Lang/company-'. $this->uiLang . '.xml', 'xml');
    	$this->assign('T',$this->translator);
        //样式
        $this->assign('moreCSSs',array('css/Company/index'));

    }
    /**
     * 回收站首页
     */
    public function index()
    {
        //页码
        $p = (I('get.p')> 1) ? I('get.p') : 1;
        $params['rows'] = $this->rows;
        $params['start']  = ($p - 1)*$params['rows'];
        $params['sort'] = 'modifiedtime desc';
        $result = \AppTools::webService('\Model\Departments\Departments', 'getRecovers',array('params'=>$params));
        $this->assign('recovercardnumb',$result['data']['numfound']);

        //分页
        $page = getpage($result['data']['numfound'],$this->rows);
        $this->assign('pagedata',$page->show());
        $result = $result['data']['list'];
        foreach($result as $key=>$val){
            $result[$key]['vcard'] = json_decode($val['vcard'],true);
            $result[$key]['name'] = $result[$key]['vcard']['front']['name'][0]['given_name']?$result[$key]['vcard']['front']['name'][0]['given_name']:'';
            $result[$key]['jobs'] = $result[$key]['vcard']['front']['company'][0]['job'][0]['value']?$result[$key]['vcard']['front']['company'][0]['job'][0]['value']:'';
            $result[$key]['companys'] = $result[$key]['vcard']['front']['company'][0]['company_name'][0]['value']?$result[$key]['vcard']['front']['company'][0]['company_name'][0]['value']:'';
            $result[$key]['contactphone'] = $result[$key]['vcard']['front']['mobile'][0]['value']?$result[$key]['vcard']['front']['mobile'][0]['value']:'';
        }
        $this->assign('breadcrumbs',array('key'=>'cardmanage','info'=>'cardrecover','show'=>''));
        $this->assign('list',$result);
        $this->display('index');
    }

    public function vcardDel(){
        $params['id'] = rtrim(I('post.rcardid'),',');
        $params['vcardid'] = rtrim(I('post.id'),',');
        $params['type'] = 2;
        I('post.batch','')!=''?$params['batch'] = I('post.batch'):'';//id must
        $result = \AppTools::webService('\Model\Departments\Departments', 'revokeRecovers',array('params'=>$params));
        $this->ajaxReturn($result['status']);
    }
    public function vcardRevoke(){
        $params['id'] = rtrim(I('post.rcardid'),',');
        $params['vcardid'] = rtrim(I('post.id'),',');
        $params['type'] = 1;
        I('post.batch','')!=''?$params['batch'] = I('post.batch'):'';//id must
        $result = \AppTools::webService('\Model\Departments\Departments', 'revokeRecovers',array('params'=>$params));
        $this->ajaxReturn($result['status']);
    }



}