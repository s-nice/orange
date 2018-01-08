<?php
namespace Think;
class NewPage extends Page{
    /**
     * 生成链接URL
     * @param  integer $page 页码
     * @return string
     */
    protected function url($page){
        $url = str_replace(urlencode('[PAGE]'), $page, $this->url);
        return urldecode($url);
    }

    /**
     * 组装分页链接
     * @return string
     */
    public function show($theme=MODULE_NAME) {
        if(0 == $this->totalRows) return '';

        /* 生成URL */
        $this->parameter[$this->p] = '[PAGE]';
        $this->url = U(ACTION_NAME, $this->parameter);
        /* 计算分页信息 */
        $this->totalPages = ceil($this->totalRows / $this->listRows); //总页数
        if(!empty($this->totalPages) && $this->nowPage > $this->totalPages) {
            $this->nowPage = $this->totalPages;
        }

        /* 计算分页临时变量 */
        $now_cool_page      = $this->rollPage/2;
        $now_cool_page_ceil = ceil($now_cool_page);
        $this->lastSuffix && $this->config['last'] = $this->totalPages;

        //上一页
        $up_row  = $this->nowPage - 1;
        $up_page = $up_row > 0 ? '<a class="prev" href="' . $this->url($up_row) . '">' . $this->config['prev'] . '</a>' : '';

        //下一页
        $down_row  = $this->nowPage + 1;
        $down_page = ($down_row <= $this->totalPages) ? '<a class="next" href="' . $this->url($down_row) . '">' . $this->config['next'] . '</a>' : '';

        //第一页
        $the_first = '';
        if($this->totalPages > $this->rollPage && ($this->nowPage - $now_cool_page) >= 1){
            $the_first = '<a class="first" href="' . $this->url(1) . '">' . $this->config['first'] . '</a>';
        }

        //最后一页
        $the_end = '';
        if($this->totalPages > $this->rollPage && ($this->nowPage + $now_cool_page) < $this->totalPages){
            $the_end = '<a class="end" href="' . $this->url($this->totalPages) . '">' . $this->config['last'] . '</a>';
        }

        //跳转页面
        $jumparr = $this->parameter;
        unset($jumparr[$this->p]);
        $jumpurl =  urldecode(U(ACTION_NAME, $jumparr));
        $jumppage = '<form action="'.$jumpurl.'" method="get" onsubmit="return _checkPage'.$this->p.'(this,\''.$this->p.'\');"><input type="text" style="width:25px;" totalPage="'.$this->totalPages.'" class="jumppage" name="'.$this->p.'"/><input type="submit" value="跳转"/></form> ';

        //数字连接
        $link_page = "";
        for($i = 1; $i <= $this->rollPage; $i++){
            if(($this->nowPage - $now_cool_page) <= 0 ){
                $page = $i;
            }elseif(($this->nowPage + $now_cool_page - 1) >= $this->totalPages){
                $page = $this->totalPages - $this->rollPage + $i;
            }else{
                $page = $this->nowPage - $now_cool_page_ceil + $i;
            }
            if($page > 0 && $page != $this->nowPage){

                if($page <= $this->totalPages){
                    $link_page .= '<a class="num" href="' . $this->url($page) . '">' . $page . '</a>';
                }else{
                    break;
                }
            }else{
                if($page > 0 && $this->totalPages != 1){
                    $link_page .= '<span class="current">' . $page . '</span>';
                }
            }
        }
        //替换分页内容
    	switch ($theme){
        	case 'Company':
        		$page_str = str_replace(
        				array('%HEADER%', '%NOW_PAGE%', '%UP_PAGE%', '%DOWN_PAGE%', '%FIRST%', '%LINK_PAGE%', '%END%', '%TOTAL_ROW%', '%TOTAL_PAGE%','%NOW_PAGE/TOTAL_PAGE%','%JUMP_PAGE%'),
        				array($this->config['header'], '<span class="current" style="display:none;">'.$this->nowPage.'</span>', $up_page, $down_page, $the_first, $link_page, $the_end, $this->totalRows, $this->totalPages,'<span class="nowandall">'.$this->nowPage.'/'.$this->totalPages.'</span>',$jumppage),
        				$this->config['theme']);
        		break;
        	case 'AppAdmin':
        		$page_str = str_replace(
        				array('%HEADER%', '%NOW_PAGE%', '%UP_PAGE%', '%DOWN_PAGE%', '%FIRST%', '%LINK_PAGE%', '%END%', '%TOTAL_ROW%', '%TOTAL_PAGE%','%JUMP_PAGE%','%LISTROWS%','%NOWPAGE%','%TOTALPAGES%'),
        				array($this->config['header'], $this->nowPage, $up_page, $down_page, $the_first, $link_page, $the_end, $this->totalRows, $this->totalPages,$jumppage,$this->listRows,$this->nowPage,$this->totalPages),
        				$this->config['theme']);
        		break;
        	default:
	        $page_str = str_replace(
	            array('%HEADER%', '%NOW_PAGE%', '%UP_PAGE%', '%DOWN_PAGE%', '%FIRST%', '%LINK_PAGE%', '%END%', '%TOTAL_ROW%', '%TOTAL_PAGE%','%NOW_PAGE/TOTAL_PAGE%','%JUMP_PAGE%'),
	            array($this->config['header'], '<span class="current" style="display:none;">'.$this->nowPage.'</span>', $up_page, $down_page, $the_first, $link_page, $the_end, $this->totalRows, $this->totalPages,'<span class="nowandall">'.$this->nowPage.'/'.$this->totalPages.'</span>',$jumppage),
	            $this->config['theme']);
        }
        return "<div>{$page_str}</div>";
    }
}