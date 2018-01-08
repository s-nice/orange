<?php
namespace Model\OrangeStat;

use \Think\Model;
class OrangeStatBusiness extends Model
{
    protected $limit = 20;

    private $echoSql = false;

    private $die = false;

    private function _debug(){
        $args = func_get_args();
        if ($this->echoSql){
            for ($i = 0; $i < count($args); $i++) {
                if (is_array($args[$i])){
                    print_r($args[$i]);
                } else {
                    echo $args[$i];
                }
                echo '<hr>
                    ';
            }
            if ($this->die){
                die;
            }
        }
    }
    
    /**
     * 累计卡片数
     * @param arr $params
     * @return arr
     */
    public function totalCardNum($params){
        $field = 'card_all_num';
        switch ($params['type']){
            case 'tpl':
                $field = 'card_mode_num';
                break;
            case 'notpl':
                $field = 'card_no_mode_num';
                break;
            case 'brush':
                $field = 'card_swipe_num';
                break;
            case 'nobrush':
                $field = 'card_no_swipe_num';
                break;
        }
        
        $sql = "select
                	dt
                	,pro_version
                	,model
                	,sum(if(module='3',$field,0))
                		+sum(if(module='89',$field,0))
                		+sum(if(module='4',$field,0))
                		+sum(if(module='88',$field,0))
                		+sum(if(module='6',$field,0))
                		+sum(if(module in ('8','20'),$field,0)) as total #总数
                	,sum(if(module='3',$field,0)) as card3 #航旅卡
                	,sum(if(module='89',$field,0)) as card1 #银行卡
                	,sum(if(module='4',$field,0)) as card4 #酒店卡
                	,sum(if(module='88',$field,0)) as card15_19 #会员卡
                	,sum(if(module='6',$field,0)) as card6 #门禁卡
                	,sum(if(module in ('8','20'),$field,0)) as card0 #其它
                from dm_orange_stats_funccard_accumulate_card
                where
                	pro_version in (%s)
                	and model in (%s)
                	and dt between '%s' and '%s'
                group by
                	dt
                	,pro_version
                	,model
                order by
                	dt
                	,pro_version
                	,model
        ";
        
        $whereValues[] = "'".join("','", $params['sv'])."'";
        $whereValues[] = "'".join("','", $params['hv'])."'";
        $whereValues[] = date('Y-m-d', strtotime($params['endtime'])-3600*24*29);
        $whereValues[] = $params['endtime'];
        $sql = vsprintf($sql, $whereValues);
        
        $sqlChart = "select
                    	dt
                    	,sum(if(module='3',$field,0))
                    		+sum(if(module='89',$field,0))
                    		+sum(if(module='4',$field,0))
                    		+sum(if(module='88',$field,0))
                    		+sum(if(module='6',$field,0))
                    		+sum(if(module in ('8','20'),$field,0)) as total #总数
                    from dm_orange_stats_funccard_accumulate_card
                    where
                    	pro_version = 'all'
                    	and model = 'all'
                    	and dt between '%s' and '%s'
                    group by
                    	dt
                    	,pro_version
                    	,model
                    order by
                    	dt
                    	,pro_version
                    	,model
        ";
        
        $whereValues = array();
        $whereValues[] = date('Y-m-d', strtotime($params['endtime'])-3600*24*29);
        $whereValues[] = $params['endtime'];
        $sqlChart = vsprintf($sqlChart, $whereValues);
        
        $this->_debug($sql, $sqlChart);
        
        $list = $this->query($sql);
        $chart = $this->query($sqlChart);
        
        return $this->_chartData2($list, $chart);
    }
    
    /**
     * 添加卡片数
     * @param arr $params
     * @return arr
     */
    public function addCardNum($params){
        $sql = $sqlChart = '';
        $field = 'card_all';
        switch ($params['type']){
            case 'tpl':
                $field = 'card_mode_num';
                break;
            case 'notpl':
                $field = 'card_no_mode_num';
                break;
            case 'brush':
                $field = 'card_swipe_num';
                break;
            case 'nobrush':
                $field = 'card_no_swipe_num';
                break;
        }
        switch ($params['period']){
            case 'm':
                $sql = "select
                        	dt
                        	,pro_version
                        	,model
                        	,sum(if(module='3',$field,0))
                        		+sum(if(module='89',$field,0))
                        		+sum(if(module='4',$field,0))
                        		+sum(if(module='88',$field,0))
                        		+sum(if(module='6',$field,0))
                        		+sum(if(module in ('8','20'),$field,0)) as total #总数
                        	,sum(if(module='3',$field,0)) as card3 #航旅卡
                        	,sum(if(module='89',$field,0)) as card1 #银行卡
                        	,sum(if(module='4',$field,0)) as card4 #酒店卡
                        	,sum(if(module='88',$field,0)) as card15_19 #会员卡
                        	,sum(if(module='6',$field,0)) as card6 #门禁卡
                        	,sum(if(module in ('8','20'),$field,0)) as card0 #其它
                        from dm_orange_stats_funccard_add_cardnum
                        where
                        	pro_version in (%s)
                        	and model in (%s)
                        	and dt between '%s' and '%s'
                            and period=3
                        group by
                        	dt
                        	,pro_version
                        	,model
                        order by
                        	dt
                        	,pro_version
                        	,model
                ";
                
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sql = vsprintf($sql, $whereValues);
                
                $sqlChart = "select
                            	dt
                            	,sum(if(module='3',$field,0))
                            		+sum(if(module='89',$field,0))
                            		+sum(if(module='4',$field,0))
                            		+sum(if(module='88',$field,0))
                            		+sum(if(module='6',$field,0))
                            		+sum(if(module in ('8','20'),$field,0)) as total #总数
                            from dm_orange_stats_funccard_add_cardnum
                            where
                            	pro_version = 'all'
                            	and model = 'all'
                            	and dt between '%s' and '%s'
                                and period=3
                            group by
                            	dt
                            	,pro_version
                            	,model
                            order by
                            	dt
                            	,pro_version
                            	,model
                ";
                
                $whereValues = array();
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sqlChart = vsprintf($sqlChart, $whereValues);
                break;
            case 'w':
                $sql = "select
                        	dt
                        	,pro_version
                        	,model
                        	,sum(if(module='3',$field,0))
                        		+sum(if(module='89',$field,0))
                        		+sum(if(module='4',$field,0))
                        		+sum(if(module='88',$field,0))
                        		+sum(if(module='6',$field,0))
                        		+sum(if(module in ('8','20'),$field,0)) as total #总数
                        	,sum(if(module='3',$field,0)) as card3 #航旅卡
                        	,sum(if(module='89',$field,0)) as card1 #银行卡
                        	,sum(if(module='4',$field,0)) as card4 #酒店卡
                        	,sum(if(module='88',$field,0)) as card15_19 #会员卡
                        	,sum(if(module='6',$field,0)) as card6 #门禁卡
                        	,sum(if(module in ('8','20'),$field,0)) as card0 #其它
                        from dm_orange_stats_funccard_add_cardnum
                        where
                        	pro_version in (%s)
                        	and model in (%s)
                        	and dt between '%s' and '%s'
                            and period=2
                        group by
                        	dt
                        	,pro_version
                        	,model
                        order by
                        	dt
                        	,pro_version
                        	,model
                ";
                
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sql = vsprintf($sql, $whereValues);
                
                $sqlChart = "select
                            	dt
                            	,sum(if(module='3',$field,0))
                            		+sum(if(module='89',$field,0))
                            		+sum(if(module='4',$field,0))
                            		+sum(if(module='88',$field,0))
                            		+sum(if(module='6',$field,0))
                            		+sum(if(module in ('8','20'),$field,0)) as total #总数
                            from dm_orange_stats_funccard_add_cardnum
                            where
                            	pro_version = 'all'
                            	and model = 'all'
                            	and dt between '%s' and '%s'
                                and period=2
                            group by
                            	dt
                            	,pro_version
                            	,model
                            order by
                            	dt
                            	,pro_version
                            	,model
                ";
                
                $whereValues = array();
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sqlChart = vsprintf($sqlChart, $whereValues);
                break;
            case 'd3':
                $sql = "select
                        	dt
                        	,pro_version
                        	,model
                        	,sum(if(module='3',$field,0))
                        		+sum(if(module='89',$field,0))
                        		+sum(if(module='4',$field,0))
                        		+sum(if(module='88',$field,0))
                        		+sum(if(module='6',$field,0))
                        		+sum(if(module in ('8','20'),$field,0)) as total #总数
                        	,sum(if(module='3',$field,0)) as card3 #航旅卡
                        	,sum(if(module='89',$field,0)) as card1 #银行卡
                        	,sum(if(module='4',$field,0)) as card4 #酒店卡
                        	,sum(if(module='88',$field,0)) as card15_19 #会员卡
                        	,sum(if(module='6',$field,0)) as card6 #门禁卡
                        	,sum(if(module in ('8','20'),$field,0)) as card0 #其它
                        from dm_orange_stats_funccard_add_cardnum
                        where
                        	pro_version in (%s)
                        	and model in (%s)
                        	and dt between '%s' and '%s'
                            and period=1
                        	and mod(datediff(dt,'%s'),3)=0 #周/月不需要
                        group by
                        	dt
                        	,pro_version
                        	,model
                        order by
                        	dt
                        	,pro_version
                        	,model
                ";
                
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $whereValues[] = $params['starttime'];
                $sql = vsprintf($sql, $whereValues);
                
                $sqlChart = "select
                            	dt
                            	,sum(if(module='3',$field,0))
                            		+sum(if(module='89',$field,0))
                            		+sum(if(module='4',$field,0))
                            		+sum(if(module='88',$field,0))
                            		+sum(if(module='6',$field,0))
                            		+sum(if(module in ('8','20'),$field,0)) as total #总数
                            from dm_orange_stats_funccard_add_cardnum
                            where
                            	pro_version = 'all'
                            	and model = 'all'
                            	and dt between '%s' and '%s'
                                and period=1
                            	and mod(datediff(dt,'%s'),3)=0 #周/月不需要
                            group by
                            	dt
                            	,pro_version
                            	,model
                            order by
                            	dt
                            	,pro_version
                            	,model
                ";
                
                $whereValues = array();
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $whereValues[] = $params['starttime'];
                $sqlChart = vsprintf($sqlChart, $whereValues);
                break;
            default:
                $sql = "select
                        	dt
                        	,pro_version
                        	,model
                        	,sum(if(module='3',$field,0))
                        		+sum(if(module='89',$field,0))
                        		+sum(if(module='4',$field,0))
                        		+sum(if(module='88',$field,0))
                        		+sum(if(module='6',$field,0))
                        		+sum(if(module in ('8','20'),$field,0)) as total #总数
                        	,sum(if(module='3',$field,0)) as card3 #航旅卡
                        	,sum(if(module='89',$field,0)) as card1 #银行卡
                        	,sum(if(module='4',$field,0)) as card4 #酒店卡
                        	,sum(if(module='88',$field,0)) as card15_19 #会员卡
                        	,sum(if(module='6',$field,0)) as card6 #门禁卡
                        	,sum(if(module in ('8','20'),$field,0)) as card0 #其它
                        from dm_orange_stats_funccard_add_cardnum
                        where
                        	pro_version in (%s)
                        	and model in (%s)
                        	and dt between '%s' and '%s'
                            and period=0
                        group by
                        	dt
                        	,pro_version
                        	,model
                        order by
                        	dt
                        	,pro_version
                        	,model
                ";
                
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sql = vsprintf($sql, $whereValues);
                
                $sqlChart = "select
                            	dt
                            	,sum(if(module='3',$field,0))
                            		+sum(if(module='89',$field,0))
                            		+sum(if(module='4',$field,0))
                            		+sum(if(module='88',$field,0))
                            		+sum(if(module='6',$field,0))
                            		+sum(if(module in ('8','20'),$field,0)) as total #总数
                            from dm_orange_stats_funccard_add_cardnum
                            where
                            	pro_version = 'all'
                            	and model = 'all'
                            	and dt between '%s' and '%s'
                                and period=0
                            group by
                            	dt
                            	,pro_version
                            	,model
                            order by
                            	dt
                            	,pro_version
                            	,model
                ";
                $whereValues = array();
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sqlChart = vsprintf($sqlChart, $whereValues);
                break;
        }
        
        $this->_debug($sql, $sqlChart);
        
        $list = $this->query($sql);
        $chart = $this->query($sqlChart);
        
        return $this->_chartData2($list, $chart);
    }
    
    /**
     * 添加卡片用户数
     * @param arr $params
     * @return arr
     */
    public function addCardUserNum($params){
        $sql = $sqlChart = '';
        $field = 'user_all';
        switch ($params['type']){
            case 'tpl':
                $field = 'user_mode_num';
                break;
            case 'notpl':
                $field = 'user_no_mode_num';
                break;
            case 'brush':
                $field = 'user_swipe_num';
                break;
            case 'nobrush':
                $field = 'user_no_swipe_num';
                break;
        }
        switch ($params['period']){
            case 'm':
                $sql = "select
                        	dt
                        	,pro_version
                        	,model
                        	,sum(if(module='90',$field,0)) as total #总数
                        	,sum(if(module='3',$field,0)) as card3 #航旅卡
                        	,sum(if(module='89',$field,0)) as card1 #银行卡
                        	,sum(if(module='4',$field,0)) as card4 #酒店卡
                        	,sum(if(module='88',$field,0)) as card15_19 #会员卡
                        	,sum(if(module='6',$field,0)) as card6 #门禁卡
                        	,sum(if(module in ('8','20'),$field,0)) as card0 #其它
                        from dm_orange_stats_funccard_add_carduser
                        where
                        	pro_version in (%s)
                        	and model in (%s)
                        	and dt between '%s' and '%s'
                            and period=3
                        group by
                        	dt
                        	,pro_version
                        	,model
                        order by
                        	dt
                        	,pro_version
                        	,model
                ";
                
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sql = vsprintf($sql, $whereValues);
                
                $sqlChart = "select
                            	dt
                            	,sum(if(module='90',$field,0)) as total #总数
                            from dm_orange_stats_funccard_add_carduser
                            where
                            	pro_version = 'all'
                            	and model = 'all'
                            	and dt between '%s' and '%s'
                                and period=3
                            group by
                            	dt
                            	,pro_version
                            	,model
                            order by
                            	dt
                            	,pro_version
                            	,model
                ";
                
                $whereValues = array();
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sqlChart = vsprintf($sqlChart, $whereValues);
                break;
            case 'w':
                $sql = "select
                        	dt
                        	,pro_version
                        	,model
                        	,sum(if(module='90',$field,0)) as total #总数
                        	,sum(if(module='3',$field,0)) as card3 #航旅卡
                        	,sum(if(module='89',$field,0)) as card1 #银行卡
                        	,sum(if(module='4',$field,0)) as card4 #酒店卡
                        	,sum(if(module='88',$field,0)) as card15_19 #会员卡
                        	,sum(if(module='6',$field,0)) as card6 #门禁卡
                        	,sum(if(module in ('8','20'),$field,0)) as card0 #其它
                        from dm_orange_stats_funccard_add_carduser
                        where
                        	pro_version in (%s)
                        	and model in (%s)
                        	and dt between '%s' and '%s'
                            and period=2
                        group by
                        	dt
                        	,pro_version
                        	,model
                        order by
                        	dt
                        	,pro_version
                        	,model
                ";
                
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sql = vsprintf($sql, $whereValues);
                
                $sqlChart = "select
                            	dt
                            	,sum(if(module='90',$field,0)) as total #总数
                            from dm_orange_stats_funccard_add_carduser
                            where
                            	pro_version = 'all'
                            	and model = 'all'
                            	and dt between '%s' and '%s'
                                and period=2
                            group by
                            	dt
                            	,pro_version
                            	,model
                            order by
                            	dt
                            	,pro_version
                            	,model
                ";
                
                $whereValues = array();
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sqlChart = vsprintf($sqlChart, $whereValues);
                break;
            case 'd3':
                $sql = "select
                        	dt
                        	,pro_version
                        	,model
                        	,sum(if(module='90',$field,0)) as total #总数
                        	,sum(if(module='3',$field,0)) as card3 #航旅卡
                        	,sum(if(module='89',$field,0)) as card1 #银行卡
                        	,sum(if(module='4',$field,0)) as card4 #酒店卡
                        	,sum(if(module='88',$field,0)) as card15_19 #会员卡
                        	,sum(if(module='6',$field,0)) as card6 #门禁卡
                        	,sum(if(module in ('8','20'),$field,0)) as card0 #其它
                        from dm_orange_stats_funccard_add_carduser
                        where
                        	pro_version in (%s)
                        	and model in (%s)
                        	and dt between '%s' and '%s'
                            and period=1
                        	and mod(datediff(dt,'%s'),3)=0 #周/月不需要
                        group by
                        	dt
                        	,pro_version
                        	,model
                        order by
                        	dt
                        	,pro_version
                        	,model
                ";
                
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $whereValues[] = $params['starttime'];
                $sql = vsprintf($sql, $whereValues);
                
                $sqlChart = "select
                            	dt
                            	,sum(if(module='90',$field,0)) as total #总数
                            from dm_orange_stats_funccard_add_carduser
                            where
                            	pro_version = 'all'
                            	and model = 'all'
                            	and dt between '%s' and '%s'
                                and period=1
                            	and mod(datediff(dt,'%s'),3)=0 #周/月不需要
                            group by
                            	dt
                            	,pro_version
                            	,model
                            order by
                            	dt
                            	,pro_version
                            	,model
                ";
                
                $whereValues = array();
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $whereValues[] = $params['starttime'];
                $sqlChart = vsprintf($sqlChart, $whereValues);
                break;
            default:
                $sql = "select
                        	dt
                        	,pro_version
                        	,model
                        	,sum(if(module='90',$field,0)) as total #总数
                        	,sum(if(module='3',$field,0)) as card3 #航旅卡
                        	,sum(if(module='89',$field,0)) as card1 #银行卡
                        	,sum(if(module='4',$field,0)) as card4 #酒店卡
                        	,sum(if(module='88',$field,0)) as card15_19 #会员卡
                        	,sum(if(module='6',$field,0)) as card6 #门禁卡
                        	,sum(if(module in ('8','20'),$field,0)) as card0 #其它
                        from dm_orange_stats_funccard_add_carduser
                        where
                        	pro_version in (%s)
                        	and model in (%s)
                        	and dt between '%s' and '%s'
                            and period=0
                        group by
                        	dt
                        	,pro_version
                        	,model
                        order by
                        	dt
                        	,pro_version
                        	,model
                ";
                
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sql = vsprintf($sql, $whereValues);
                
                $sqlChart = "select
                        	dt
                        	,sum(if(module='90',$field,0)) as total #总数
                        from dm_orange_stats_funccard_add_carduser
                        where
                        	pro_version = 'all'
                        	and model = 'all'
                        	and dt between '%s' and '%s'
                            and period=0
                        group by
                        	dt
                        	,pro_version
                        	,model
                        order by
                        	dt
                        	,pro_version
                        	,model
                ";
                $whereValues = array();
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sqlChart = vsprintf($sqlChart, $whereValues);
                break;
        }
        
        $this->_debug($sql, $sqlChart);
        
        $list = $this->query($sql);
        $chart = $this->query($sqlChart);
        
        return $this->_chartData2($list, $chart);
    }
    
    /**
     * 当月累计添加卡片数
     * @param arr $params
     * @return arr
     */
    public function monthTotalAddCardNum($params){
        $field = 'card_count_accumulate';
        switch ($params['type']){
            case 'tpl':
                $field = 'card_mode_num';
                break;
            case 'notpl':
                $field = 'card_no_mode_num';
                break;
            case 'brush':
                $field = 'card_swipe_num';
                break;
            case 'nobrush':
                $field = 'card_no_swipe_num';
                break;
        }
        $sql = "select
                	dt
                	,pro_version
                	,model
                	,sum(if(module='3',$field,0))
                		+sum(if(module='89',$field,0))
                		+sum(if(module='4',$field,0))
                		+sum(if(module='88',$field,0))
                		+sum(if(module='6',$field,0))
                		+sum(if(module in ('8','20'),$field,0)) as total #总数
                	,sum(if(module='3',$field,0)) as card3 #航旅卡
                	,sum(if(module='89',$field,0)) as card1 #银行卡
                	,sum(if(module='4',$field,0)) as card4 #酒店卡
                	,sum(if(module='88',$field,0)) as card15_19 #会员卡
                	,sum(if(module='6',$field,0)) as card6 #门禁卡
                	,sum(if(module in ('8','20'),$field,0)) as card0 #其它
                from dm_orange_stats_funccard_month_accumulate
                where
                	pro_version in (%s)
                	and model in (%s)
                	and dt between '%s' and '%s'
                group by
                	dt
                	,pro_version
                	,model
                order by
                	dt
                	,pro_version
                	,model
        ";
        
        $whereValues[] = "'".join("','", $params['sv'])."'";
        $whereValues[] = "'".join("','", $params['hv'])."'";
        $whereValues[] = $params['starttime'];
        $whereValues[] = $params['endtime'];
        $sql = vsprintf($sql, $whereValues);
        
        $sqlChart = "select
                    	dt
                    	,sum(if(module='3',$field,0))
                    		+sum(if(module='89',$field,0))
                    		+sum(if(module='4',$field,0))
                    		+sum(if(module='88',$field,0))
                    		+sum(if(module='6',$field,0))
                    		+sum(if(module in ('8','20'),$field,0)) as total #总数
                    from dm_orange_stats_funccard_month_accumulate
                    where
                    	pro_version = 'all'
                    	and model = 'all'
                    	and dt between '%s' and '%s'
                    group by
                    	dt
                    	,pro_version
                    	,model
                    order by
                    	dt
                    	,pro_version
                    	,model
        ";
        
        $whereValues = array();
        $whereValues[] = $params['starttime'];
        $whereValues[] = $params['endtime'];
        $sqlChart = vsprintf($sqlChart, $whereValues);
        
        $this->_debug($sql, $sqlChart);
        
        $list = $this->query($sql);
        $chart = $this->query($sqlChart);
        
        return $this->_chartData2($list, $chart);
    }
    
    /**
     * 使用卡片数
     * @param arr $params
     * @return arr
     */
    public function usedCardNum($params){
        $sql = $sqlChart = '';
        $field = 'card_all';
        switch ($params['type']){
            case 'tpl':
                $field = 'card_mode_num';
                break;
            case 'notpl':
                $field = 'card_no_mode_num';
                break;
            case 'brush':
                $field = 'card_swipe_num';
                break;
            case 'nobrush':
                $field = 'card_no_swipe_num';
                break;
        }
        
        switch ($params['period']){
            case 'm':
                $sql = "select
                        	dt
                        	,pro_version
                        	,model
                        	,sum(if(module='3',$field,0))
                        		+sum(if(module='89',$field,0))
                        		+sum(if(module='4',$field,0))
                        		+sum(if(module='88',$field,0))
                        		+sum(if(module='6',$field,0))
                        		+sum(if(module in ('8','20'),$field,0)) as total #总数
                        	,sum(if(module='3',$field,0)) as card3 #航旅卡
                        	,sum(if(module='89',$field,0)) as card1 #银行卡
                        	,sum(if(module='4',$field,0)) as card4 #酒店卡
                        	,sum(if(module='88',$field,0)) as card15_19 #会员卡
                        	,sum(if(module='6',$field,0)) as card6 #门禁卡
                        	,sum(if(module in ('8','20'),$field,0)) as card0 #其它
                        from dm_orange_stats_funccard_card
                        where
                        	pro_version in (%s)
                        	and model in (%s)
                        	and dt between '%s' and '%s'
                            and period=3
                        group by
                        	dt
                        	,pro_version
                        	,model
                        order by
                        	dt
                        	,pro_version
                        	,model
                ";
                
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sql = vsprintf($sql, $whereValues);
                
                $sqlChart = "select
                            	dt
                            	,sum(if(module='3',$field,0))
                            		+sum(if(module='89',$field,0))
                            		+sum(if(module='4',$field,0))
                            		+sum(if(module='88',$field,0))
                            		+sum(if(module='6',$field,0))
                            		+sum(if(module in ('8','20'),$field,0)) as total #总数
                            from dm_orange_stats_funccard_card
                            where
                            	pro_version = 'all'
                            	and model = 'all'
                            	and dt between '%s' and '%s'
                                and period=3
                            group by
                            	dt
                            	,pro_version
                            	,model
                            order by
                            	dt
                            	,pro_version
                            	,model
                ";
                
                $whereValues = array();
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sqlChart = vsprintf($sqlChart, $whereValues);
                break;
            case 'w':
                $sql = "select
                        	dt
                        	,pro_version
                        	,model
                        	,sum(if(module='3',$field,0))
                        		+sum(if(module='89',$field,0))
                        		+sum(if(module='4',$field,0))
                        		+sum(if(module='88',$field,0))
                        		+sum(if(module='6',$field,0))
                        		+sum(if(module in ('8','20'),$field,0)) as total #总数
                        	,sum(if(module='3',$field,0)) as card3 #航旅卡
                        	,sum(if(module='89',$field,0)) as card1 #银行卡
                        	,sum(if(module='4',$field,0)) as card4 #酒店卡
                        	,sum(if(module='88',$field,0)) as card15_19 #会员卡
                        	,sum(if(module='6',$field,0)) as card6 #门禁卡
                        	,sum(if(module in ('8','20'),$field,0)) as card0 #其它
                        from dm_orange_stats_funccard_card
                        where
                        	pro_version in (%s)
                        	and model in (%s)
                        	and dt between '%s' and '%s'
                            and period=2
                        group by
                        	dt
                        	,pro_version
                        	,model
                        order by
                        	dt
                        	,pro_version
                        	,model
                ";
                
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sql = vsprintf($sql, $whereValues);
                
                $sqlChart = "select
                            	dt
                            	,sum(if(module='3',$field,0))
                            		+sum(if(module='89',$field,0))
                            		+sum(if(module='4',$field,0))
                            		+sum(if(module='88',$field,0))
                            		+sum(if(module='6',$field,0))
                            		+sum(if(module in ('8','20'),$field,0)) as total #总数
                            from dm_orange_stats_funccard_card
                            where
                            	pro_version = 'all'
                            	and model = 'all'
                            	and dt between '%s' and '%s'
                                and period=2
                            group by
                            	dt
                            	,pro_version
                            	,model
                            order by
                            	dt
                            	,pro_version
                            	,model
                ";
                
                $whereValues = array();
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sqlChart = vsprintf($sqlChart, $whereValues);
                break;
            case 'd3':
                $sql = "select
                        	dt
                        	,pro_version
                        	,model
                        	,sum(if(module='3',$field,0))
                        		+sum(if(module='89',$field,0))
                        		+sum(if(module='4',$field,0))
                        		+sum(if(module='88',$field,0))
                        		+sum(if(module='6',$field,0))
                        		+sum(if(module in ('8','20'),$field,0)) as total #总数
                        	,sum(if(module='3',$field,0)) as card3 #航旅卡
                        	,sum(if(module='89',$field,0)) as card1 #银行卡
                        	,sum(if(module='4',$field,0)) as card4 #酒店卡
                        	,sum(if(module='88',$field,0)) as card15_19 #会员卡
                        	,sum(if(module='6',$field,0)) as card6 #门禁卡
                        	,sum(if(module in ('8','20'),$field,0)) as card0 #其它
                        from dm_orange_stats_funccard_card
                        where
                        	pro_version in (%s)
                        	and model in (%s)
                        	and dt between '%s' and '%s'
                            and period=1
                        	and mod(datediff(dt,'%s'),3)=0 #周/月不需要
                        group by
                        	dt
                        	,pro_version
                        	,model
                        order by
                        	dt
                        	,pro_version
                        	,model
                ";
                
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $whereValues[] = $params['starttime'];
                $sql = vsprintf($sql, $whereValues);
                
                $sqlChart = "select
                            	dt
                            	,sum(if(module='3',$field,0))
                            		+sum(if(module='89',$field,0))
                            		+sum(if(module='4',$field,0))
                            		+sum(if(module='88',$field,0))
                            		+sum(if(module='6',$field,0))
                            		+sum(if(module in ('8','20'),$field,0)) as total #总数
                            from dm_orange_stats_funccard_card
                            where
                            	pro_version = 'all'
                            	and model = 'all'
                            	and dt between '%s' and '%s'
                                and period=1
                            	and mod(datediff(dt,'%s'),3)=0 #周/月不需要
                            group by
                            	dt
                            	,pro_version
                            	,model
                            order by
                            	dt
                            	,pro_version
                            	,model
                ";
                
                $whereValues = array();
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $whereValues[] = $params['starttime'];
                $sqlChart = vsprintf($sqlChart, $whereValues);
                break;
            default:
                $sql = "select
                        	dt
                        	,pro_version
                        	,model
                        	,sum(if(module='3',$field,0))
                        		+sum(if(module='89',$field,0))
                        		+sum(if(module='4',$field,0))
                        		+sum(if(module='88',$field,0))
                        		+sum(if(module='6',$field,0))
                        		+sum(if(module in ('8','20'),$field,0)) as total #总数
                        	,sum(if(module='3',$field,0)) as card3 #航旅卡
                        	,sum(if(module='89',$field,0)) as card1 #银行卡
                        	,sum(if(module='4',$field,0)) as card4 #酒店卡
                        	,sum(if(module='88',$field,0)) as card15_19 #会员卡
                        	,sum(if(module='6',$field,0)) as card6 #门禁卡
                        	,sum(if(module in ('8','20'),$field,0)) as card0 #其它
                        from dm_orange_stats_funccard_card
                        where
                        	pro_version in (%s)
                        	and model in (%s)
                        	and dt between '%s' and '%s'
                            and period=0
                        group by
                        	dt
                        	,pro_version
                        	,model
                        order by
                        	dt
                        	,pro_version
                        	,model
                ";
                
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sql = vsprintf($sql, $whereValues);
                
                $sqlChart = "select
                            	dt
                            	,sum(if(module='3',$field,0))
                            		+sum(if(module='89',$field,0))
                            		+sum(if(module='4',$field,0))
                            		+sum(if(module='88',$field,0))
                            		+sum(if(module='6',$field,0))
                            		+sum(if(module in ('8','20'),$field,0)) as total #总数
                            from dm_orange_stats_funccard_card
                            where
                            	pro_version = 'all'
                            	and model = 'all'
                            	and dt between '%s' and '%s'
                                and period=0
                            group by
                            	dt
                            	,pro_version
                            	,model
                            order by
                            	dt
                            	,pro_version
                            	,model
                ";
                
                $whereValues = array();
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sqlChart = vsprintf($sqlChart, $whereValues);
        }        
        
        $this->_debug($sql, $sqlChart);
        
        $list = $this->query($sql);
        $chart = $this->query($sqlChart);
        
        return $this->_chartData2($list, $chart);
    }
    
    /**
     * 使用次数
     * @param arr $params
     * @return arr
     */
    public function usedNum($params){
        $sql = $sqlChart = '';
        $field = 'use_times_all';
        switch ($params['type']){
            case 'tpl':
                $field = 'use_times_mode';
                break;
            case 'notpl':
                $field = 'use_times_no_mode';
                break;
            case 'brush':
                $field = 'use_times_swipe';
                break;
            case 'nobrush':
                $field = 'use_times_no_swipe';
                break;
        }
        
        switch ($params['period']){
            case 'm':
                $sql = "select
                        	date_sub(dt,interval day(dt)-1 day) as dt1
                        	,pro_version
                        	,model
                        	,sum(if(module='3',$field,0))
                        		+sum(if(module='89',$field,0))
                        		+sum(if(module='4',$field,0))
                        		+sum(if(module='88',$field,0))
                        		+sum(if(module='6',$field,0))
                        		+sum(if(module in ('8','20'),$field,0)) as total #总数
                        	,sum(if(module='3',$field,0)) as card3 #航旅卡
                        	,sum(if(module='89',$field,0)) as card1 #银行卡
                        	,sum(if(module='4',$field,0)) as card4 #酒店卡
                        	,sum(if(module='88',$field,0)) as card15_19 #会员卡
                        	,sum(if(module='6',$field,0)) as card6 #门禁卡
                        	,sum(if(module in ('8','20'),$field,0)) as card0 #其它
                        from dm_orange_stats_funccard_use_times
                        where
                        	pro_version in (%s)
                        	and model in (%s)
                        	and dt between '%s' and '%s'
                        group by
                        	dt1
                        	,pro_version
                        	,model
                        order by
                        	dt1
                        	,pro_version
                        	,model
                ";
                
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sql = vsprintf($sql, $whereValues);
                
                $sqlChart = "select
                            	date_sub(dt,interval day(dt)-1 day) as dt1
                            	,sum(if(module='3',$field,0))
                            		+sum(if(module='89',$field,0))
                            		+sum(if(module='4',$field,0))
                            		+sum(if(module='88',$field,0))
                            		+sum(if(module='6',$field,0))
                            		+sum(if(module in ('8','20'),$field,0)) as total #总数
                            from dm_orange_stats_funccard_use_times
                            where
                            	pro_version = 'all'
                            	and model = 'all'
                            	and dt between '%s' and '%s'
                            group by
                            	dt1
                            	,pro_version
                            	,model
                            order by
                            	dt1
                            	,pro_version
                            	,model
                ";
                
                $whereValues = array();
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sqlChart = vsprintf($sqlChart, $whereValues);
                break;
            case 'w':
                $sql = "select
                        	date_sub(dt,interval mod(datediff(dt,'%s'),7) day) as dt1
                        	,pro_version
                        	,model
                        	,sum(if(module='3',$field,0))
                        		+sum(if(module='89',$field,0))
                        		+sum(if(module='4',$field,0))
                        		+sum(if(module='88',$field,0))
                        		+sum(if(module='6',$field,0))
                        		+sum(if(module in ('8','20'),$field,0)) as total #总数
                        	,sum(if(module='3',$field,0)) as card3 #航旅卡
                        	,sum(if(module='89',$field,0)) as card1 #银行卡
                        	,sum(if(module='4',$field,0)) as card4 #酒店卡
                        	,sum(if(module='88',$field,0)) as card15_19 #会员卡
                        	,sum(if(module='6',$field,0)) as card6 #门禁卡
                        	,sum(if(module in ('8','20'),$field,0)) as card0 #其它
                        from dm_orange_stats_funccard_use_times
                        where
                        	pro_version in (%s)
                        	and model in (%s)
                        	and dt between '%s' and '%s'
                        group by
                        	dt1
                        	,pro_version
                        	,model
                        order by
                        	dt1
                        	,pro_version
                        	,model
                ";
                
                $whereValues[] = $params['starttime'];
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sql = vsprintf($sql, $whereValues);
                
                $sqlChart = "select
                            	date_sub(dt,interval mod(datediff(dt,'%s'),7) day) as dt1
                            	,sum(if(module='3',$field,0))
                            		+sum(if(module='89',$field,0))
                            		+sum(if(module='4',$field,0))
                            		+sum(if(module='88',$field,0))
                            		+sum(if(module='6',$field,0))
                            		+sum(if(module in ('8','20'),$field,0)) as total #总数
                            from dm_orange_stats_funccard_use_times
                            where
                            	pro_version = 'all'
                            	and model = 'all'
                            	and dt between '%s' and '%s'
                            group by
                            	dt1
                            	,pro_version
                            	,model
                            order by
                            	dt1
                            	,pro_version
                            	,model
                ";
                
                $whereValues = array();
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sqlChart = vsprintf($sqlChart, $whereValues);
                break;
            case 'd3':
                $sql = "select
                        	date_sub(dt,interval mod(datediff(dt,'%s'),3) day) as dt1
                        	,pro_version
                        	,model
                        	,sum(if(module='3',$field,0))
                        		+sum(if(module='89',$field,0))
                        		+sum(if(module='4',$field,0))
                        		+sum(if(module='88',$field,0))
                        		+sum(if(module='6',$field,0))
                        		+sum(if(module in ('8','20'),$field,0)) as total #总数
                        	,sum(if(module='3',$field,0)) as card3 #航旅卡
                        	,sum(if(module='89',$field,0)) as card1 #银行卡
                        	,sum(if(module='4',$field,0)) as card4 #酒店卡
                        	,sum(if(module='88',$field,0)) as card15_19 #会员卡
                        	,sum(if(module='6',$field,0)) as card6 #门禁卡
                        	,sum(if(module in ('8','20'),$field,0)) as card0 #其它
                        from dm_orange_stats_funccard_use_times
                        where
                        	pro_version in (%s)
                        	and model in (%s)
                        	and dt between '%s' and '%s'
                        group by
                        	dt1
                        	,pro_version
                        	,model
                        order by
                        	dt1
                        	,pro_version
                        	,model
                ";
                
                $whereValues[] = $params['starttime'];
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sql = vsprintf($sql, $whereValues);
                
                $sqlChart = "select
                            	date_sub(dt,interval mod(datediff(dt,'%s'),3) day) as dt1
                            	,sum(if(module='3',$field,0))
                            		+sum(if(module='89',$field,0))
                            		+sum(if(module='4',$field,0))
                            		+sum(if(module='88',$field,0))
                            		+sum(if(module='6',$field,0))
                            		+sum(if(module in ('8','20'),$field,0)) as total #总数
                            from dm_orange_stats_funccard_use_times
                            where
                            	pro_version = 'all'
                            	and model = 'all'
                            	and dt between '%s' and '%s'
                            group by
                            	dt1
                            	,pro_version
                            	,model
                            order by
                            	dt1
                            	,pro_version
                            	,model
                ";
                
                $whereValues = array();
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sqlChart = vsprintf($sqlChart, $whereValues);
                break;
            default:
                $sql = "select
                        	dt as dt1
                        	,pro_version
                        	,model
                        	,sum(if(module='3',$field,0))
                        		+sum(if(module='89',$field,0))
                        		+sum(if(module='4',$field,0))
                        		+sum(if(module='88',$field,0))
                        		+sum(if(module='6',$field,0))
                        		+sum(if(module in ('8','20'),$field,0)) as total #总数
                        	,sum(if(module='3',$field,0)) as card3 #航旅卡
                        	,sum(if(module='89',$field,0)) as card1 #银行卡
                        	,sum(if(module='4',$field,0)) as card4 #酒店卡
                        	,sum(if(module='88',$field,0)) as card15_19 #会员卡
                        	,sum(if(module='6',$field,0)) as card6 #门禁卡
                        	,sum(if(module in ('8','20'),$field,0)) as card0 #其它
                        from dm_orange_stats_funccard_use_times
                        where
                        	pro_version in (%s)
                        	and model in (%s)
                        	and dt between '%s' and '%s'
                        group by
                        	dt
                        	,pro_version
                        	,model
                        order by
                        	dt
                        	,pro_version
                        	,model
                ";
                
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sql = vsprintf($sql, $whereValues);
                
                $sqlChart = "select
                            	dt as dt1
                            	,sum(if(module='3',$field,0))
                            		+sum(if(module='89',$field,0))
                            		+sum(if(module='4',$field,0))
                            		+sum(if(module='88',$field,0))
                            		+sum(if(module='6',$field,0))
                            		+sum(if(module in ('8','20'),$field,0)) as total #总数
                            from dm_orange_stats_funccard_use_times
                            where
                            	pro_version = 'all'
                            	and model = 'all'
                            	and dt between '%s' and '%s'
                            group by
                            	dt
                            	,pro_version
                            	,model
                            order by
                            	dt
                            	,pro_version
                            	,model
                ";
                
                $whereValues = array();
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sqlChart = vsprintf($sqlChart, $whereValues);
        }

        $this->_debug($sql, $sqlChart);
        
        $list = $this->query($sql);
        $chart = $this->query($sqlChart);
        
        return $this->_chartData2($list, $chart);
    }
    
    /**
     * 累计人均常用卡
     * @param arr $params
     * @return arr
     */
    public function totalAvgFavoriteCardNum($params){
        $sql = "select
                	u.dt
                	,u.pro_version
                	,u.model
                    ,(travel+bank+hotel+member+door+other)/user_total as total
                    ,travel/user_total as card3
                    ,bank/user_total as card1
                    ,hotel/user_total as card4
                    ,member/user_total as card15_19
                    ,door/user_total as card6
                    ,other/user_total as card0
                from (
                	select
                		dt
                		,pro_version
                		,model
                		,sum(if(module='3',common_used_card_num,0)) as travel #航旅卡
                		,sum(if(module='89',common_used_card_num,0)) as bank #银行卡
                		,sum(if(module='4',common_used_card_num,0)) as hotel #酒店卡
                		,sum(if(module='88',common_used_card_num,0)) as member #会员卡
                		,sum(if(module='6',common_used_card_num,0)) as door #门禁卡
                		,sum(if(module in ('8','20'),common_used_card_num,0)) as other #其它
                	from dm_orange_stats_funccard_accumulate_card
                	where
                		pro_version in (%s)
                		and model in (%s)
                		and dt between '%s' and '%s'
                	group by
                		dt
                		,pro_version
                		,model
                ) as c
                join (
                	select
                		dt
                		,pro_version
                		,model
                        ,user_total
                    from dm_orange_stats_user
                	where
                		pro_version in (%s)
                		and model in (%s)
                		and dt between '%s' and '%s'
                        and user_total!=0
                ) as u
                on u.dt=c.dt
                	and u.pro_version=c.pro_version
                    and u.model=c.model
                order by
                	dt
                	,pro_version
                	,model
        ";
        
        $whereValues[] = "'".join("','", $params['sv'])."'";
        $whereValues[] = "'".join("','", $params['hv'])."'";
        $whereValues[] = date('Y-m-d', strtotime($params['endtime'])-3600*24*29);
        $whereValues[] = $params['endtime'];
        $whereValues[] = "'".join("','", $params['sv'])."'";
        $whereValues[] = "'".join("','", $params['hv'])."'";
        $whereValues[] = date('Y-m-d', strtotime($params['endtime'])-3600*24*29);
        $whereValues[] = $params['endtime'];
        $sql = vsprintf($sql, $whereValues);
        
        $sqlChart = "select
                    	u.dt
                    	,u.pro_version
                    	,u.model
                        ,(travel+bank+hotel+member+door+other)/user_total as total
                        ,travel/user_total as card3
                        ,bank/user_total as card1
                        ,hotel/user_total as card4
                        ,member/user_total as card15_19
                        ,door/user_total as card6
                        ,other/user_total as card0
                    from (
                    	select
                    		dt
                    		,pro_version
                    		,model
                    		,sum(if(module='3',common_used_card_num,0)) as travel #航旅卡
                    		,sum(if(module='89',common_used_card_num,0)) as bank #银行卡
                    		,sum(if(module='4',common_used_card_num,0)) as hotel #酒店卡
                    		,sum(if(module='88',common_used_card_num,0)) as member #会员卡
                    		,sum(if(module='6',common_used_card_num,0)) as door #门禁卡
                    		,sum(if(module in ('8','20'),common_used_card_num,0)) as other #其它
                    	from dm_orange_stats_funccard_accumulate_card
                    	where
                    		pro_version = 'all'
                    		and model = 'all'
                    		and dt = '%s'
                    	group by
                    		dt
                    		,pro_version
                    		,model
                    ) as c
                    join (
                    	select
                    		dt
                    		,pro_version
                    		,model
                            ,user_total
                        from dm_orange_stats_user
                    	where
                    		pro_version = 'all'
                    		and model = 'all'
                    		and dt = '%s'
                            and user_total!=0
                    ) as u
                    on u.dt=c.dt
                    	and u.pro_version=c.pro_version
                        and u.model=c.model
                    order by
                    	dt
                    	,pro_version
                    	,model
        ";
        $whereValues = array();
        $whereValues[] = $params['endtime'];
        $whereValues[] = $params['endtime'];
        $sqlChart = vsprintf($sqlChart, $whereValues);
        
        $this->_debug($sql, $sqlChart);
        
        $list = $this->query($sql);
        $chart = $this->query($sqlChart);
        
        return $this->_chartData($list, $chart);
    }
    
    /**
     * 累计人均卡数
     * @param arr $params
     * @return arr
     */
    public function totalAvgCardNum($params){
        $sql = "select
                	u.dt
                	,u.pro_version
                	,u.model
                    ,(travel+bank+hotel+member+door+other)/user_total as total
                    ,travel/user_total as card3
                    ,bank/user_total as card1
                    ,hotel/user_total as card4
                    ,member/user_total as card15_19
                    ,door/user_total as card6
                    ,other/user_total as card0
                from (
                	select
                		dt
                		,pro_version
                		,model
                		,sum(if(module='3',card_all_num,0)) as travel #航旅卡
                		,sum(if(module='89',card_all_num,0)) as bank #银行卡
                		,sum(if(module='4',card_all_num,0)) as hotel #酒店卡
                		,sum(if(module='88',card_all_num,0)) as member #会员卡
                		,sum(if(module='6',card_all_num,0)) as door #门禁卡
                		,sum(if(module in ('8','20'),card_all_num,0)) as other #其它
                	from dm_orange_stats_funccard_accumulate_card
                	where
                		pro_version in (%s)
                		and model in (%s)
                		and dt between '%s' and '%s'
                	group by
                		dt
                		,pro_version
                		,model
                ) as c
                join (
                	select
                		dt
                		,pro_version
                		,model
                        ,user_total
                    from dm_orange_stats_user
                	where
                		pro_version in (%s)
                		and model in (%s)
                		and dt between '%s' and '%s'
                        and user_total!=0
                ) as u
                on u.dt=c.dt
                	and u.pro_version=c.pro_version
                    and u.model=c.model
                order by
                	dt
                	,pro_version
                	,model
        ";
        
        $whereValues[] = "'".join("','", $params['sv'])."'";
        $whereValues[] = "'".join("','", $params['hv'])."'";
        $whereValues[] = date('Y-m-d', strtotime($params['endtime'])-3600*24*29);
        $whereValues[] = $params['endtime'];
        $whereValues[] = "'".join("','", $params['sv'])."'";
        $whereValues[] = "'".join("','", $params['hv'])."'";
        $whereValues[] = date('Y-m-d', strtotime($params['endtime'])-3600*24*29);
        $whereValues[] = $params['endtime'];
        $sql = vsprintf($sql, $whereValues);
        
        $sqlChart = "select
                    	u.dt
                    	,u.pro_version
                    	,u.model
                        ,(travel+bank+hotel+member+door+other)/user_total as total
                        ,travel/user_total as card3
                        ,bank/user_total as card1
                        ,hotel/user_total as card4
                        ,member/user_total as card15_19
                        ,door/user_total as card6
                        ,other/user_total as card0
                    from (
                    	select
                    		dt
                    		,pro_version
                    		,model
                    		,sum(if(module='3',card_all_num,0)) as travel #航旅卡
                    		,sum(if(module='89',card_all_num,0)) as bank #银行卡
                    		,sum(if(module='4',card_all_num,0)) as hotel #酒店卡
                    		,sum(if(module='88',card_all_num,0)) as member #会员卡
                    		,sum(if(module='6',card_all_num,0)) as door #门禁卡
                    		,sum(if(module in ('8','20'),card_all_num,0)) as other #其它
                    	from dm_orange_stats_funccard_accumulate_card
                    	where
                    		pro_version = 'all'
                    		and model = 'all'
                    		and dt = '%s'
                    	group by
                    		dt
                    		,pro_version
                    		,model
                    ) as c
                    join (
                    	select
                    		dt
                    		,pro_version
                    		,model
                            ,user_total
                        from dm_orange_stats_user
                    	where
                    		pro_version = 'all'
                    		and model = 'all'
                    		and dt = '%s'
                            and user_total!=0
                    ) as u
                    on u.dt=c.dt
                    	and u.pro_version=c.pro_version
                        and u.model=c.model
                    order by
                    	dt
                    	,pro_version
                    	,model
        ";
        
        $whereValues = array();
        $whereValues[] = $params['endtime'];
        $whereValues[] = $params['endtime'];
        $sqlChart = vsprintf($sqlChart, $whereValues);
        
        $this->_debug($sql, $sqlChart);

        $list = $this->query($sql);
        $chart = $this->query($sqlChart);
        return $this->_chartData($list, $chart);
    }
    
    /**
     * 人均使用卡片数量
     * @param arr $params
     * @return arr
     */
    public function avgUsedCardNum($params){
        $sql = '';
        $sqlChart = '';
        $field = 'card_all';
        switch ($params['type']){
            case 'brush':
                $field = 'card_swipe_num';
                break;
            case 'nobrush':
                $field = 'card_no_swipe_num';
                break;
        }
        switch ($params['period']){
            case 'w':
                $sql = "select
                        	u.dt
                            ,u.pro_version
                            ,u.model
                            ,(travel+bank+hotel+member+door+other)/user_all as total
                            ,travel/user_all as card3
                            ,bank/user_all as card1
                            ,hotel/user_all as card4
                            ,member/user_all as card15_19
                            ,door/user_all as card6
                            ,other/user_all as card0
                        from (
                        	select
                        		dt
                        		,pro_version
                        		,model
                        		,sum(if(module='3',$field,0)) as travel #航旅卡
                        		,sum(if(module='89',$field,0)) as bank #银行卡
                        		,sum(if(module='4',$field,0)) as hotel #酒店卡
                        		,sum(if(module='88',$field,0)) as member #会员卡
                        		,sum(if(module='6',$field,0)) as door #门禁卡
                        		,sum(if(module in ('8','20'),$field,0)) as other #其它
                        	from dm_orange_stats_funccard_card
                        	where
                        		pro_version in (%s)
                        		and model in (%s)
                        		and dt between '%s' and '%s'
                        		and period=2
                        	group by
                        		dt
                        		,pro_version
                        		,model
                        ) as c
                        join (
                        	select
                        		dt
                        		,pro_version
                        		,model
                        		,user_all
                        	from dm_orange_stats_funccard_user
                        	where
                        		pro_version in (%s)
                        		and model in (%s)
                        		and dt between '%s' and '%s'
                        		and module='90'
                                and period=2
                                and user_all!=0
                        ) as u
                        on u.dt=c.dt
                        	and u.pro_version=c.pro_version
                            and u.model=c.model
                        order by
                        	dt
                        	,pro_version
                        	,model
                ";
                //$whereValues[] = $params['starttime'];
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                
                $sql = vsprintf($sql, $whereValues);
                
                $sqlChart = "select
                            	u.dt
                                ,u.pro_version
                                ,u.model
                                ,(travel+bank+hotel+member+door+other)/user_all as total
                                ,travel/user_all as card3
                                ,bank/user_all as card1
                                ,hotel/user_all as card4
                                ,member/user_all as card15_19
                                ,door/user_all as card6
                                ,other/user_all as card0
                            from (
                            	select
                            		dt
                            		,pro_version
                            		,model
                            		,sum(if(module='3',$field,0)) as travel #航旅卡
                            		,sum(if(module='89',$field,0)) as bank #银行卡
                            		,sum(if(module='4',$field,0)) as hotel #酒店卡
                            		,sum(if(module='88',$field,0)) as member #会员卡
                            		,sum(if(module='6',$field,0)) as door #门禁卡
                            		,sum(if(module in ('8','20'),$field,0)) as other #其它
                            	from dm_orange_stats_funccard_card
                            	where
                            		pro_version = 'all'
                            		and model = 'all'
                            		and dt between '%s' and '%s'
                            		and period=2
                            	group by
                            		dt
                            		,pro_version
                            		,model
                            ) as c
                            join (
                            	select
                            		dt
                            		,pro_version
                            		,model
                            		,user_all
                            	from dm_orange_stats_funccard_user
                            	where
                            		pro_version = 'all'
                            		and model = 'all'
                            		and dt between '%s' and '%s'
                            		and module='90'
                                    and period=2
                                    and user_all!=0
                            ) as u
                            on u.dt=c.dt
                            	and u.pro_version=c.pro_version
                                and u.model=c.model
                            order by
                            	dt
                            	,pro_version
                            	,model
                ";
                
                $params['starttime'] = date('Y-m-d', strtotime('-6 days', strtotime($params['endtime'])));
                $whereValues = array();
                //$whereValues[] = $params['starttime'];
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sqlChart = vsprintf($sqlChart, $whereValues);
                break;
            case 'm':
                $sql = "select
                        	u.dt
                            ,u.pro_version
                            ,u.model
                            ,(travel+bank+hotel+member+door+other)/user_all as total
                            ,travel/user_all as card3
                            ,bank/user_all as card1
                            ,hotel/user_all as card4
                            ,member/user_all as card15_19
                            ,door/user_all as card6
                            ,other/user_all as card0
                        from (
                        	select
                        		dt
                        		,pro_version
                        		,model
                        		,sum(if(module='3',$field,0)) as travel #航旅卡
                        		,sum(if(module='89',$field,0)) as bank #银行卡
                        		,sum(if(module='4',$field,0)) as hotel #酒店卡
                        		,sum(if(module='88',$field,0)) as member #会员卡
                        		,sum(if(module='6',$field,0)) as door #门禁卡
                        		,sum(if(module in ('8','20'),$field,0)) as other #其它
                        	from dm_orange_stats_funccard_card
                        	where
                        		pro_version in (%s)
                        		and model in (%s)
                        		and dt between '%s' and '%s'
                        		and period=3
                        	group by
                        		dt
                        		,pro_version
                        		,model
                        ) as c
                        join (
                        	select
                        		dt
                        		,pro_version
                        		,model
                        		,user_all
                        	from dm_orange_stats_funccard_user
                        	where
                        		pro_version in (%s)
                        		and model in (%s)
                        		and dt between '%s' and '%s'
                        		and module='90'
                                and period=3
                                and user_all!=0
                        ) as u
                        on u.dt=c.dt
                        	and u.pro_version=c.pro_version
                            and u.model=c.model
                        order by
                        	dt
                        	,pro_version
                        	,model
                ";
                
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                
                $sql = vsprintf($sql, $whereValues);
                
                $sqlChart = "select
                            	u.dt
                                ,u.pro_version
                                ,u.model
                                ,(travel+bank+hotel+member+door+other)/user_all as total
                                ,travel/user_all as card3
                                ,bank/user_all as card1
                                ,hotel/user_all as card4
                                ,member/user_all as card15_19
                                ,door/user_all as card6
                                ,other/user_all as card0
                            from (
                            	select
                            		dt
                            		,pro_version
                            		,model
                            		,sum(if(module='3',$field,0)) as travel #航旅卡
                            		,sum(if(module='89',$field,0)) as bank #银行卡
                            		,sum(if(module='4',$field,0)) as hotel #酒店卡
                            		,sum(if(module='88',$field,0)) as member #会员卡
                            		,sum(if(module='6',$field,0)) as door #门禁卡
                            		,sum(if(module in ('8','20'),$field,0)) as other #其它
                            	from dm_orange_stats_funccard_card
                            	where
                            		pro_version = 'all'
                            		and model = 'all'
                            		and dt between '%s' and '%s'
                            		and period=3
                            	group by
                            		dt
                            		,pro_version
                            		,model
                            ) as c
                            join (
                            	select
                            		dt
                            		,pro_version
                            		,model
                            		,user_all
                            	from dm_orange_stats_funccard_user
                            	where
                            		pro_version = 'all'
                            		and model = 'all'
                            		and dt between '%s' and '%s'
                            		and module='90'
                                    and period=3
                                    and user_all!=0
                            ) as u
                            on u.dt=c.dt
                            	and u.pro_version=c.pro_version
                                and u.model=c.model
                            order by
                            	dt
                            	,pro_version
                            	,model
                ";
                
                $params['starttime'] = date('Y-m-d', strtotime('first day of this month', strtotime($params['endtime'])-3600*24));
                $whereValues = array();
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sqlChart = vsprintf($sqlChart, $whereValues);
                break;
            case 'd3':
                $sql = "select
                        	u.dt
                            ,u.pro_version
                            ,u.model
                            ,(travel+bank+hotel+member+door+other)/user_all as total
                            ,travel/user_all as card3
                            ,bank/user_all as card1
                            ,hotel/user_all as card4
                            ,member/user_all as card15_19
                            ,door/user_all as card6
                            ,other/user_all as card0
                        from (
                        	select
                        		dt
                        		,pro_version
                        		,model
                        		,sum(if(module='3',$field,0)) as travel #航旅卡
                        		,sum(if(module='89',$field,0)) as bank #银行卡
                        		,sum(if(module='4',$field,0)) as hotel #酒店卡
                        		,sum(if(module='88',$field,0)) as member #会员卡
                        		,sum(if(module='6',$field,0)) as door #门禁卡
                        		,sum(if(module in ('8','20'),$field,0)) as other #其它
                        	from dm_orange_stats_funccard_card
                        	where
                        		pro_version in (%s)
                        		and model in (%s)
                        		and dt between '%s' and '%s'
                        		and period=1
		                        and mod(datediff(dt,'%s'),3)=0 #周/月不需要
                        	group by
                        		dt
                        		,pro_version
                        		,model
                        ) as c
                        join (
                        	select
                        		dt
                        		,pro_version
                        		,model
                        		,user_all
                        	from dm_orange_stats_funccard_user
                        	where
                        		pro_version in (%s)
                        		and model in (%s)
                        		and dt between '%s' and '%s'
                        		and module='90'
                                and period=1
                        		and mod(datediff(dt,'%s'),3)=0 #周/月不需要
                                and user_all!=0
                        ) as u
                        on u.dt=c.dt
                        	and u.pro_version=c.pro_version
                            and u.model=c.model
                        order by
                        	dt
                        	,pro_version
                        	,model
                ";
                
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $whereValues[] = $params['starttime'];
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $whereValues[] = $params['starttime'];
                
                $sql = vsprintf($sql, $whereValues);
                
                $sqlChart = "select
                            	u.dt
                                ,u.pro_version
                                ,u.model
                                ,(travel+bank+hotel+member+door+other)/user_all as total
                                ,travel/user_all as card3
                                ,bank/user_all as card1
                                ,hotel/user_all as card4
                                ,member/user_all as card15_19
                                ,door/user_all as card6
                                ,other/user_all as card0
                            from (
                            	select
                            		dt
                            		,pro_version
                            		,model
                            		,sum(if(module='3',$field,0)) as travel #航旅卡
                            		,sum(if(module='89',$field,0)) as bank #银行卡
                            		,sum(if(module='4',$field,0)) as hotel #酒店卡
                            		,sum(if(module='88',$field,0)) as member #会员卡
                            		,sum(if(module='6',$field,0)) as door #门禁卡
                            		,sum(if(module in ('8','20'),$field,0)) as other #其它
                            	from dm_orange_stats_funccard_card
                            	where
                            		pro_version = 'all'
                            		and model = 'all'
                            		and dt between '%s' and '%s'
                            		and period=1
		                            and mod(datediff(dt,'%s'),3)=0 #周/月不需要
                            	group by
                            		dt
                            		,pro_version
                            		,model
                            ) as c
                            join (
                            	select
                            		dt
                            		,pro_version
                            		,model
                            		,user_all
                            	from dm_orange_stats_funccard_user
                            	where
                            		pro_version = 'all'
                            		and model = 'all'
                            		and dt between '%s' and '%s'
                            		and module='90'
                                    and period=1
                            		and mod(datediff(dt,'%s'),3)=0 #周/月不需要
                                    and user_all!=0
                            ) as u
                            on u.dt=c.dt
                            	and u.pro_version=c.pro_version
                                and u.model=c.model
                            order by
                            	dt
                            	,pro_version
                            	,model
                ";
                
                $params['starttime'] = date('Y-m-d', strtotime('-2 day', strtotime($params['endtime'])));
                $whereValues = array();
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $whereValues[] = $params['starttime'];
                $sqlChart = vsprintf($sqlChart, $whereValues);
                break;
            default:
                $sql = "select
                        	u.dt
                        	,u.pro_version
                        	,u.model
                            ,(travel+bank+hotel+member+door+other)/user_all as total
                            ,travel/user_all as card3
                            ,bank/user_all as card1
                            ,hotel/user_all as card4
                            ,member/user_all as card15_19
                            ,door/user_all as card6
                            ,other/user_all as card0
                        from (
                        	select
                        		dt
                        		,pro_version
                        		,model
                        		,sum(if(module='3',$field,0)) as travel #航旅卡
                        		,sum(if(module='89',$field,0)) as bank #银行卡
                        		,sum(if(module='4',$field,0)) as hotel #酒店卡
                        		,sum(if(module='88',$field,0)) as member #会员卡
                        		,sum(if(module='6',$field,0)) as door #门禁卡
                        		,sum(if(module in ('8','20'),$field,0)) as other #其它
                        	from dm_orange_stats_funccard_card
                        	where
                        		pro_version in (%s)
                        		and model in (%s)
                        		and dt between '%s' and '%s'
                        		and period=0
                        	group by
                        		dt
                        		,pro_version
                        		,model
                        ) as c
                        join (
                        	select
                        		dt
                        		,pro_version
                        		,model
                                ,user_all
                            from dm_orange_stats_funccard_user
                        	where
                        		pro_version in (%s)
                        		and model in (%s)
                        		and dt between '%s' and '%s'
                                and module='90'
                                and period=0
                                and user_all!=0
                        ) as u
                        on u.dt=c.dt
                        	and u.pro_version=c.pro_version
                            and u.model=c.model
                        order by
                        	dt
                        	,pro_version
                        	,model
                ";
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sql = vsprintf($sql, $whereValues);
                
                $sqlChart = "select
                            	u.dt
                            	,u.pro_version
                            	,u.model
                                ,(travel+bank+hotel+member+door+other)/user_all as total
                                ,travel/user_all as card3
                                ,bank/user_all as card1
                                ,hotel/user_all as card4
                                ,member/user_all as card15_19
                                ,door/user_all as card6
                                ,other/user_all as card0
                            from (
                            	select
                            		dt
                            		,pro_version
                            		,model
                            		,sum(if(module='3',$field,0)) as travel #航旅卡
                            		,sum(if(module='89',$field,0)) as bank #银行卡
                            		,sum(if(module='4',$field,0)) as hotel #酒店卡
                            		,sum(if(module='88',$field,0)) as member #会员卡
                            		,sum(if(module='6',$field,0)) as door #门禁卡
                            		,sum(if(module in ('8','20'),$field,0)) as other #其它
                            	from dm_orange_stats_funccard_card
                            	where
                            		pro_version = 'all'
                            		and model = 'all'
                            		and dt = '%s'
                            		and period=0
                            	group by
                            		dt
                            		,pro_version
                            		,model
                            ) as c
                            join (
                            	select
                            		dt
                            		,pro_version
                            		,model
                                    ,user_all
                                from dm_orange_stats_funccard_user
                            	where
                            		pro_version = 'all'
                            		and model = 'all'
                            		and dt = '%s'
                                    and module='90'
                                    and period=0
                                    and user_all!=0
                            ) as u
                            on u.dt=c.dt
                            	and u.pro_version=c.pro_version
                                and u.model=c.model
                            order by
                            	dt
                            	,pro_version
                            	,model
                ";
                $whereValues = array();
                $whereValues[] = $params['endtime'];
                $whereValues[] = $params['endtime'];
                $sqlChart = vsprintf($sqlChart, $whereValues);
                break;
        }
        
        $this->_debug($sql, $sqlChart);
        
        $list = $this->query($sql);
        $chart = $this->query($sqlChart);
        return $this->_chartData($list, $chart);
    }
    
    /**
     * 人均添加卡片数量
     * @param arr $params
     * @return arr
     */
    public function avgAddCardNum($params){
        $sql = '';
        $sqlChart = '';
        $field = 'card_all';
        switch ($params['type']){
            case 'tpl':
                $field = 'card_mode_num';
                break;
            case 'notpl':
                $field = 'card_no_mode_num';
                break;
        }
        switch ($params['period']){
            case 'w':
                $sql = "select
                        	u.dt
                            ,u.pro_version
                            ,u.model
                            ,(travel+bank+hotel+member+door+other)/vals as total
                            ,travel/vals as card3
                            ,bank/vals as card1
                            ,hotel/vals as card4
                            ,member/vals as card15_19
                            ,door/vals as card6
                            ,other/vals as card0
                        from (
                        	select
                        		dt
                        		,pro_version
                        		,model
                        		,sum(if(module='3',$field,0)) as travel #航旅卡
                        		,sum(if(module='89',$field,0)) as bank #银行卡
                        		,sum(if(module='4',$field,0)) as hotel #酒店卡
                        		,sum(if(module='88',$field,0)) as member #会员卡
                        		,sum(if(module='6',$field,0)) as door #门禁卡
                        		,sum(if(module in ('8','20'),$field,0)) as other #其它
                        	from dm_orange_stats_funccard_add_cardnum
                        	where
                        		pro_version in (%s)
                        		and model in (%s)
                        		and dt between '%s' and '%s'
                                and period=2
                        	group by
                        		dt
                        		,pro_version
                        		,model
                        ) as c
                        join (
                        	select
                        		dt
                        		,pro_version
                        		,model
                        		,vals
                        	from dm_orange_stats_week
                        	where
                        		pro_version in (%s)
                        		and model in (%s)
                        		and dt between '%s' and '%s'
                        		and module=1
                        		and field=1
                        		and detail=0
                                and vals!=0
                        ) as u
                        on u.dt=c.dt
                        	and u.pro_version=c.pro_version
                            and u.model=c.model
                        order by
                        	dt
                        	,pro_version
                        	,model
                ";
                
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                
                $sql = vsprintf($sql, $whereValues);
                
                $sqlChart = "select
                            	u.dt
                                ,u.pro_version
                                ,u.model
                                ,(travel+bank+hotel+member+door+other)/vals as total
                                ,travel/vals as card3
                                ,bank/vals as card1
                                ,hotel/vals as card4
                                ,member/vals as card15_19
                                ,door/vals as card6
                                ,other/vals as card0
                            from (
                            	select
                            		dt
                            		,pro_version
                            		,model
                            		,sum(if(module='3',$field,0)) as travel #航旅卡
                            		,sum(if(module='89',$field,0)) as bank #银行卡
                            		,sum(if(module='4',$field,0)) as hotel #酒店卡
                            		,sum(if(module='88',$field,0)) as member #会员卡
                            		,sum(if(module='6',$field,0)) as door #门禁卡
                            		,sum(if(module in ('8','20'),$field,0)) as other #其它
                            	from dm_orange_stats_funccard_add_cardnum
                            	where
                            		pro_version = 'all'
                            		and model = 'all'
                            		and dt between '%s' and '%s'
                                    and period=2
                            	group by
                            		dt
                            		,pro_version
                            		,model
                            ) as c
                            join (
                            	select
                            		dt
                            		,pro_version
                            		,model
                            		,vals
                            	from dm_orange_stats_week
                            	where
                            		pro_version = 'all'
                            		and model = 'all'
                            		and dt between '%s' and '%s'
                            		and module=1
                            		and field=1
                            		and detail=0
                                    and vals!=0
                            ) as u
                            on u.dt=c.dt
                            	and u.pro_version=c.pro_version
                                and u.model=c.model
                            order by
                            	dt
                            	,pro_version
                            	,model
                ";
                
                //图表数据，需要重新计算开始日期
                $params['starttime'] = date('Y-m-d', strtotime('-6 days', strtotime($params['endtime'])));
                $whereValues = array();
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sqlChart = vsprintf($sqlChart, $whereValues);
                break;
            case 'm':
                $sql = "select
                        	u.dt
                            ,u.pro_version
                            ,u.model
                            ,(travel+bank+hotel+member+door+other)/vals as total
                            ,travel/vals as card3
                            ,bank/vals as card1
                            ,hotel/vals as card4
                            ,member/vals as card15_19
                            ,door/vals as card6
                            ,other/vals as card0
                        from (
                        	select
                        		dt
                        		,pro_version
                        		,model
                        		,sum(if(module='3',$field,0)) as travel #航旅卡
                        		,sum(if(module='89',$field,0)) as bank #银行卡
                        		,sum(if(module='4',$field,0)) as hotel #酒店卡
                        		,sum(if(module='88',$field,0)) as member #会员卡
                        		,sum(if(module='6',$field,0)) as door #门禁卡
                        		,sum(if(module in ('8','20'),$field,0)) as other #其它
                        	from dm_orange_stats_funccard_add_cardnum
                        	where
                        		pro_version in (%s)
                        		and model in (%s)
                        		and dt between '%s' and '%s'
                                and period=3
                        	group by
                        		dt
                        		,pro_version
                        		,model
                        ) as c
                        join (
                        	select
                        		dt
                        		,pro_version
                        		,model
                        		,vals
                        	from dm_orange_stats_month
                        	where
                        		pro_version in (%s)
                        		and model in (%s)
                        		and dt between '%s' and '%s'
                        		and module=1
                        		and field=1
                        		and detail=0
                                and vals!=0
                        ) as u
                        on u.dt=c.dt
                        	and u.pro_version=c.pro_version
                            and u.model=c.model
                        order by
                        	dt
                        	,pro_version
                        	,model
                ";
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                
                $sql = vsprintf($sql, $whereValues);
                
                $sqlChart = "select
                            	u.dt
                                ,u.pro_version
                                ,u.model
                                ,(travel+bank+hotel+member+door+other)/vals as total
                                ,travel/vals as card3
                                ,bank/vals as card1
                                ,hotel/vals as card4
                                ,member/vals as card15_19
                                ,door/vals as card6
                                ,other/vals as card0
                            from (
                            	select
                            		dt
                            		,pro_version
                            		,model
                            		,sum(if(module='3',$field,0)) as travel #航旅卡
                            		,sum(if(module='89',$field,0)) as bank #银行卡
                            		,sum(if(module='4',$field,0)) as hotel #酒店卡
                            		,sum(if(module='88',$field,0)) as member #会员卡
                            		,sum(if(module='6',$field,0)) as door #门禁卡
                            		,sum(if(module in ('8','20'),$field,0)) as other #其它
                            	from dm_orange_stats_funccard_add_cardnum
                            	where
                            		pro_version = 'all'
                            		and model = 'all'
                            		and dt between '%s' and '%s'
                                    and period=3
                            	group by
                            		dt
                            		,pro_version
                            		,model
                            ) as c
                            join (
                            	select
                            		dt
                            		,pro_version
                            		,model
                            		,vals
                            	from dm_orange_stats_month
                            	where
                            		pro_version = 'all'
                            		and model = 'all'
                            		and dt between '%s' and '%s'
                            		and module=1
                            		and field=1
                            		and detail=0
                                    and vals!=0
                            ) as u
                            on u.dt=c.dt
                            	and u.pro_version=c.pro_version
                                and u.model=c.model
                            order by
                            	dt
                            	,pro_version
                            	,model
                ";
                
                //图表数据，需要重新计算开始日期
                $params['starttime'] = date('Y-m-d', strtotime('first day of this month', strtotime($params['endtime'])-3600*24));
                $whereValues = array();
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sqlChart = vsprintf($sqlChart, $whereValues);
                
                break;
            case 'd3':
                $sql = "select
                        	u.dt
                            ,u.pro_version
                            ,u.model
                            ,(travel+bank+hotel+member+door+other)/vals as total
                            ,travel/vals as card3
                            ,bank/vals as card1
                            ,hotel/vals as card4
                            ,member/vals as card15_19
                            ,door/vals as card6
                            ,other/vals as card0
                        from (
                        	select
                        		dt
                        		,pro_version
                        		,model
                        		,sum(if(module='3',$field,0)) as travel #航旅卡
                        		,sum(if(module='89',$field,0)) as bank #银行卡
                        		,sum(if(module='4',$field,0)) as hotel #酒店卡
                        		,sum(if(module='88',$field,0)) as member #会员卡
                        		,sum(if(module='6',$field,0)) as door #门禁卡
                        		,sum(if(module in ('8','20'),$field,0)) as other #其它
                        	from dm_orange_stats_funccard_add_cardnum
                        	where
                        		pro_version in (%s)
                        		and model in (%s)
                        		and dt between '%s' and '%s'
                        		and period=1
                        		and mod(datediff(dt,'%s'),3)=0 #周/月不需要，开始日期
                        	group by
                        		dt
                        		,pro_version
                        		,model
                        ) as c
                        join (
                        	select
                        		dt
                        		,pro_version
                        		,model
                        		,vals
                        	from dm_orange_stats_three_day
                        	where
                        		pro_version in (%s)
                        		and model in (%s)
                        		and dt between '%s' and '%s'
                        		and module=1
                        		and field=1
                        		and detail=0
                        		and mod(datediff(dt,'%s'),3)=0 #周/月不需要，开始日期
                                and vals!=0
                        ) as u
                        on u.dt=c.dt
                        	and u.pro_version=c.pro_version
                            and u.model=c.model
                        order by
                        	dt
                        	,pro_version
                        	,model
                ";
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $whereValues[] = $params['starttime'];
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $whereValues[] = $params['starttime'];
                
                $sql = vsprintf($sql, $whereValues);
                
                $sqlChart = "select
                            	u.dt
                                ,u.pro_version
                                ,u.model
                                ,(travel+bank+hotel+member+door+other)/vals as total
                                ,travel/vals as card3
                                ,bank/vals as card1
                                ,hotel/vals as card4
                                ,member/vals as card15_19
                                ,door/vals as card6
                                ,other/vals as card0
                            from (
                            	select
                            		dt
                            		,pro_version
                            		,model
                            		,sum(if(module='3',$field,0)) as travel #航旅卡
                            		,sum(if(module='89',$field,0)) as bank #银行卡
                            		,sum(if(module='4',$field,0)) as hotel #酒店卡
                            		,sum(if(module='88',$field,0)) as member #会员卡
                            		,sum(if(module='6',$field,0)) as door #门禁卡
                            		,sum(if(module in ('8','20'),$field,0)) as other #其它
                            	from dm_orange_stats_funccard_add_cardnum
                            	where
                            		pro_version = 'all'
                            		and model = 'all'
                            		and dt between '%s' and '%s'
                            		and period=1
                            		and mod(datediff(dt,'%s'),3)=0 #周/月不需要，开始日期
                            	group by
                            		dt
                            		,pro_version
                            		,model
                            ) as c
                            join (
                            	select
                            		dt
                            		,pro_version
                            		,model
                            		,vals
                            	from dm_orange_stats_three_day
                            	where
                            		pro_version = 'all'
                            		and model = 'all'
                            		and dt between '%s' and '%s'
                            		and module=1
                            		and field=1
                            		and detail=0
                            		and mod(datediff(dt,'%s'),3)=0 #周/月不需要，开始日期
                                    and vals!=0
                            ) as u
                            on u.dt=c.dt
                            	and u.pro_version=c.pro_version
                                and u.model=c.model
                            order by
                            	dt
                            	,pro_version
                            	,model
                ";
                $params['starttime'] = date('Y-m-d', strtotime('-2 day', strtotime($params['endtime'])));
                $whereValues = array();
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $whereValues[] = $params['starttime'];
                $sqlChart = vsprintf($sqlChart, $whereValues);
                break;
            default:
                $sql = "select
                        	u.dt
                        	,u.pro_version
                        	,u.model
                            ,(travel+bank+hotel+member+door+other)/active_user as total
                            ,travel/active_user card3
                            ,bank/active_user card1
                            ,hotel/active_user card4
                            ,member/active_user card15_19
                            ,door/active_user card6
                            ,other/active_user card0
                        from (
                        	select
                        		dt
                        		,pro_version
                        		,model
                        		,sum(if(module='3',$field,0)) as travel #航旅卡
                        		,sum(if(module='89',$field,0)) as bank #银行卡
                        		,sum(if(module='4',$field,0)) as hotel #酒店卡
                        		,sum(if(module='88',$field,0)) as member #会员卡
                        		,sum(if(module='6',$field,0)) as door #门禁卡
                        		,sum(if(module in ('8','20'),$field,0)) as other #其它
                        	from dm_orange_stats_funccard_add_cardnum
                        	where
                        		pro_version in (%s)
                        		and model in (%s)
                        		and dt between '%s' and '%s'
                                and period=0
                        	group by
                        		dt
                        		,pro_version
                        		,model
                        ) as c
                        join (
                        	select
                        		dt
                        		,pro_version
                        		,model
                                ,active_user
                            from dm_orange_stats_user
                        	where
                        		pro_version in (%s)
                        		and model in (%s)
                        		and dt between '%s' and '%s'
                                and active_user!=0
                        ) as u
                        on u.dt=c.dt
                        	and u.pro_version=c.pro_version
                            and u.model=c.model
                        order by
                        	dt
                        	,pro_version
                        	,model
                ";
                
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $whereValues[] = "'".join("','", $params['sv'])."'";
                $whereValues[] = "'".join("','", $params['hv'])."'";
                $whereValues[] = $params['starttime'];
                $whereValues[] = $params['endtime'];
                $sql = vsprintf($sql, $whereValues);
                
                $sqlChart = "select
                        	u.dt
                        	,u.pro_version
                        	,u.model
                            ,(travel+bank+hotel+member+door+other)/active_user as total
                            ,travel/active_user card3
                            ,bank/active_user card1
                            ,hotel/active_user card4
                            ,member/active_user card15_19
                            ,door/active_user card6
                            ,other/active_user card0
                        from (
                        	select
                        		dt
                        		,pro_version
                        		,model
                        		,sum(if(module='3',$field,0)) as travel #航旅卡
                        		,sum(if(module='89',$field,0)) as bank #银行卡
                        		,sum(if(module='4',$field,0)) as hotel #酒店卡
                        		,sum(if(module='88',$field,0)) as member #会员卡
                        		,sum(if(module='6',$field,0)) as door #门禁卡
                        		,sum(if(module in ('8','20'),$field,0)) as other #其它
                        	from dm_orange_stats_funccard_add_cardnum
                        	where
                        		pro_version = 'all'
                        		and model = 'all'
                        		and dt = '%s'
                                and period=0
                        	group by
                        		dt
                        		,pro_version
                        		,model
                        ) as c
                        join (
                        	select
                        		dt
                        		,pro_version
                        		,model
                                ,active_user
                            from dm_orange_stats_user
                        	where
                        		pro_version = 'all'
                        		and model = 'all'
                        		and dt = '%s'
                                and active_user!=0
                        ) as u
                        on u.dt=c.dt
                        	and u.pro_version=c.pro_version
                            and u.model=c.model
                        order by
                        	dt
                        	,pro_version
                        	,model
                ";
                
                $whereValues = array();
                $whereValues[] = $params['endtime'];
                $whereValues[] = $params['endtime'];
                $sqlChart = vsprintf($sqlChart, $whereValues);
                break;
        }
        
        $this->_debug($sql, $sqlChart);
        
        $list = $this->query($sql);
        $chart = $this->query($sqlChart);
        return $this->_chartData($list, $chart);
    }
    
    /**
     * 数据处理【累计人均卡片数，累计人均常用卡片数，人均添加卡片数，人均使用卡片数】
     * @param arr $list
     * @param arr
     */
    private function _chartData($list, $chartData){
        //print_r($chartData);die;
        $this->_getPercent($list);
        $chartData = $chartData[0];
        
        //$chartData['card0_'] = $chartData['card0_']-$chartData['card3_']-$chartData['card1_']-$chartData['card4_']-$chartData['card15_19_']-$chartData['card6_'];
        //$chartData['card0_'] < 0 && $chartData['card0_'] = 0;
        //print_r($chartData);die;
        foreach ($chartData as $key=>$value) {
            if (in_array($key, array('dt', 'model', 'pro_version', 'total'))){
                continue;
            }
            $newlist['chart'][] = array('name'=>rtrim($key, '_'), 'count'=>$value);
        }
        
        $newlist['chart'] = array_sort($newlist['chart'], 'count');
        $newlist['list'] = $list;
        $this->_replaceAllStr($newlist['list']);
        return $newlist;
    }
    
    /**
     * 数据处理【累计卡片数，添加卡片数，添加卡片用户数，当月累计添加卡片数，使用卡片数，使用卡片次数】
     * @param arr $list
     * @param arr
     */
    private function _chartData2($list, $chartData){
        $this->_getPercent($list);
        //print_r($chartData);die;
        $newlist['chart'] = $chartData;
        $newlist['list'] = $list;
        $this->_replaceAllStr($newlist['list']);
        return $newlist;
    }
    
    /**
     * 计算占比
     * @param arr $list
     */
    private function _getPercent(&$list){
        for ($i = 0; $i < count($list); $i++) {
            $tmp = $list[$i];
        
            !empty($tmp['card0']) && $tmp['card0_'] = '('.round($tmp['card0']/$tmp['total']*100).'%)';
            !empty($tmp['card3']) && $tmp['card3_'] = '('.round($tmp['card3']/$tmp['total']*100).'%)';
            !empty($tmp['card1']) && $tmp['card1_'] = '('.round($tmp['card1']/$tmp['total']*100).'%)';
            !empty($tmp['card4']) && $tmp['card4_'] = '('.round($tmp['card4']/$tmp['total']*100).'%)';
            !empty($tmp['card6']) && $tmp['card6_'] = '('.round($tmp['card6']/$tmp['total']*100).'%)';
            !empty($tmp['card15_19']) && $tmp['card15_19_'] = '('.round($tmp['card15_19']/$tmp['total']*100).'%)';
        
            $tmp['card0'] = round($tmp['card0'], 2);
            $tmp['card3'] = round($tmp['card3'], 2);
            $tmp['card1'] = round($tmp['card1'], 2);
            $tmp['card4'] = round($tmp['card4'], 2);
            $tmp['card15_19'] = round($tmp['card15_19'], 2);
            $tmp['card6'] = round($tmp['card6'], 2);
            $tmp['total'] = round($tmp['total'], 2);
        
            empty($tmp['card0']) ? $tmp['card0'] = '0(0%)' : $tmp['card0'] = $tmp['card0'].$tmp['card0_'];
            empty($tmp['card3']) ? $tmp['card3'] = '0(0%)' : $tmp['card3'] = $tmp['card3'].$tmp['card3_'];
            empty($tmp['card1']) ? $tmp['card1'] = '0(0%)' : $tmp['card1'] = $tmp['card1'].$tmp['card1_'];
            empty($tmp['card4']) ? $tmp['card4'] = '0(0%)' : $tmp['card4'] = $tmp['card4'].$tmp['card4_'];
            empty($tmp['card6']) ? $tmp['card6'] = '0(0%)' : $tmp['card6'] = $tmp['card6'].$tmp['card6_'];
            empty($tmp['card15_19']) ? $tmp['card15_19'] = '0(0%)' : $tmp['card15_19'] = $tmp['card15_19'].$tmp['card15_19_'];
        
            unset($tmp['card0_']);
            unset($tmp['card3_']);
            unset($tmp['card1_']);
            unset($tmp['card4_']);
            unset($tmp['card6_']);
            unset($tmp['card15_19_']);
        
            $list[$i] = $tmp;
        }
    }
    
    /**
     * all to 全部
     * @param arr $list
     */
    private function _replaceAllStr(&$list){
        for ($i = 0; $i < count($list); $i++) {
            $list[$i]['pro_version'] == 'all' && $list[$i]['pro_version'] = '全部';
            $list[$i]['model']       == 'all' && $list[$i]['model']       = '全部';
        }
    }
}