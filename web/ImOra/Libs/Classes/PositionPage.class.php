<?php
/**
 * 分页类page.class.php扩展, 增加指定url的静态化
* @author jiyl <jiyl@oradt.com>
* @date   2014-09-29
*/
//导入分页类
import('ORG.Util.Page');
class PositionPage extends Page
{
    /**
     * @access public
     * @param array $totalRows  总的记录数
     * @param array $listRows  每页显示记录数
     * @param array $parameter  分页跳转的参数
     */
    public function __construct($totalRows,$listRows='',$parameter='',$url='') {
        parent::__construct($totalRows,$listRows,$parameter,$url);
    }

    public function setRollPage(){
        $this->rollPage = $this->totalPages;
    }
    /**
     * 分页显示输出
     * @access public
     */
    public function show() {
        if(0 == $this->totalRows) return '';
        $p              =   $this->varPage;
        $nowCoolPage    =   ceil($this->nowPage/$this->rollPage);
        // 分析分页参数
        if($this->url){
            $depr       =   C('URL_PATHINFO_DEPR');
            $url        =   rtrim(U('/'.$this->url,'',false),$depr).$depr.'__PAGE__'.C('URL_HTML_SUFFIX');
        }else{
            if($this->parameter && is_string($this->parameter)) {
                parse_str($this->parameter,$parameter);
            }elseif(is_array($this->parameter)){
                $parameter      =   $this->parameter;
            }elseif(empty($this->parameter)){
                unset($_GET[C('VAR_URL_PARAMS')]);
                $var =  !empty($_POST)?$_POST:$_GET;
                if(empty($var)) {
                    $parameter  =   array();
                }else{
                    $parameter  =   $var;
                }
            }
            $parameter[$p]  =   '__PAGE__';
            $url            =   U('',$parameter);
        }
        //上下翻页字符串
        $upRow          =   $this->nowPage-1;
        $downRow        =   $this->nowPage+1;
        if ($upRow>0){
            $upPage     =   str_replace('__PAGE__',$upRow,$url);
        }else{
            $upPage     =   'javascript:;';
        }

        if ($downRow <= $this->totalPages){
            $downPage   =   str_replace('__PAGE__',$downRow,$url);
        }else{
            $downPage   =  'javascript:;';
        }
        // << < > >>
        if($nowCoolPage == 1){
            $theFirst   =   '';
            $prePage    =   '';
        }else{
            $preRow     =   $this->nowPage-$this->rollPage;
            $prePage    =   "<a href='".str_replace('__PAGE__',$preRow,$url)."' >上".$this->rollPage."页</a>";
            $theFirst   =   "<a href='".str_replace('__PAGE__',1,$url)."' >".$this->config['first']."</a>";
        }
        if($nowCoolPage == $this->coolPages){
            $nextPage   =   '';
            $theEnd     =   '';
        }else{
            $nextRow    =   $this->nowPage+$this->rollPage;
            $theEndRow  =   $this->totalPages;
            $nextPage   =   "<a href='".str_replace('__PAGE__',$nextRow,$url)."' >下".$this->rollPage."页</a>";
            $theEnd     =   "<a href='".str_replace('__PAGE__',$theEndRow,$url)."' >".$this->config['last']."</a>";
        }
        // 1 2 3 4 5
        $linkPage = "";

        for($i=1;$i<=$this->rollPage;$i++){
            $page       =   ($nowCoolPage-1)*$this->rollPage+$i;
            if($page!=$this->nowPage){
                if($page<=$this->totalPages){
                    $linkPage[]= "<a href='".str_replace('__PAGE__',$page,$url)."'>第".$page."页</a>";
                }else{
                    break;
                }
            }else{
//                 if($this->totalPages != 1){
//                     $linkPage []= "<span class='current'>第".$page."页</span>";
//                 }
                $linkPage []= "<span class='current'>第".$page."页</span>";
            }
        }
        $pageStr     =   str_replace(
                array('%header%','%nowPage%','%totalRow%','/%totalPage% 页','%upPage%','%downPage%','%first%','%prePage%','%linkPage%','%nextPage%','%end%'),
                array('',$this->nowPage,'','',$upPage,$downPage,$theFirst,$prePage,$linkPage,$nextPage,$theEnd),$this->config['theme']);
      return   $positionPage = array('upPage'=>$upPage,'nowPage'=>$this->nowPage,'downPage'=>$downPage,'linkPage'=>$linkPage,'totalPages'=>$this->totalPages);
      //  return $pageStr;
    }
}
/* EOF */