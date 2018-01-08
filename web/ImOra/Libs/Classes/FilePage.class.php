<?php
/**
* 分页类page.class.php扩展 更改下面分页样式
* @author dzy <dingzy@oradt.com>
* @date   2014-11-13
*/
//导入分页类
import('ORG.Util.Page');
class FilePage extends Page
{
	/**
	 * 架构函数
	 * @access public
	 * @param array $totalRows  总的记录数
	 * @param array $listRows  每页显示记录数
	 * @param array $parameter  分页跳转的参数
	 * @param int $rollPage  每页显示的页数
	 */
	public function __construct($totalRows,$listRows='',$parameter='',$url='',$rollPage='') {
		$this->rollPage = $rollPage;
		$this->totalRows    =   $totalRows;
		$this->parameter    =   $parameter;
		$this->varPage      =   C('VAR_PAGE') ? C('VAR_PAGE') : 'p' ;
		if(!empty($listRows)) {
			$this->listRows =   intval($listRows);
		}
		$this->totalPages   =   ceil($this->totalRows/$this->listRows);     //总页数
		$this->coolPages    =   ceil($this->totalPages/$this->rollPage);
		if($_GET[$this->varPage]){
			$this->nowPage = $_GET[$this->varPage];
		}elseif($_REQUEST['page']){
			$this->nowPage = $_REQUEST['page'];
		}else{
			$this->nowPage = 1;
		}
		if($this->nowPage<1){
			$this->nowPage  =   1;
		}elseif(!empty($this->totalPages) && $this->nowPage>$this->totalPages) {
			$this->nowPage  =   $this->totalPages;
		}
		$this->firstRow     =   $this->listRows*($this->nowPage-1);
		if(!empty($url))    $this->url  =   $url;
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
			$url        =   rtrim(U('/'.$this->url,'',false),$depr).$depr.'__PAGE__';
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
		// << < > >>
		if($nowCoolPage == 1){
			$theFirst   =   '';
			$prePage    =   "<a title='上".$this->rollPage."页' href='javascript:;' >&lt;</a>";
		}else{
			$preRow     =   $this->nowPage-$this->rollPage;
			$prePage    =   "<a title='上".$this->rollPage."页' href='".str_replace('__PAGE__',$preRow,$url)."' >&lt;</a>";
		}
		if($nowCoolPage == $this->coolPages){
			$nextPage   =   "<a title='下".$this->rollPage."页' href='javascript:;' >&gt;</a>";;
			$theEnd     =   '';
		}else{
			$nextRow    =   $this->nowPage+$this->rollPage;
			if($nextRow > $this->totalPages){
				$nextRow = $this->totalPages;
			}
			$theEndRow  =   $this->totalPages;
			$nextPage   =   "<a title='下".$this->rollPage."页' href='".str_replace('__PAGE__',$nextRow,$url)."' >&gt;</a>";
		}
		// 1 2 3 4 5
		$linkPage = "";
		for($i=1;$i<=$this->rollPage;$i++){
			$page       =   ($nowCoolPage-1)*$this->rollPage+$i;
			if($page!=$this->nowPage){
				if($page<=$this->totalPages){
					$linkPage .= "<a href='".str_replace('__PAGE__',$page,$url)."'>".$page."</a>";
				}else{
					break;
				}
			}else{
				$linkPage .= "<span class='current'>".$page."</span>";
			}
		}
		$pageStr     =   str_replace(
				array('/','页','%header%','%nowPage%','%totalRow%','%totalPage%','%upPage%','%downPage%','%first%','%prePage%','%linkPage%','%nextPage%','%end%'),
				array('','','','',$this->totalRows,'','','','',$prePage,$linkPage,$nextPage,''),$this->config['theme']);
		return $pageStr;
	}

}