<?php
namespace Model\Orange;

use Model\OrangeStat\OrangeStatBase;
use Appadmin\Controller\AdminBaseController;
use Zend\Validator\Between;

class OraStatCard extends OrangeStatBase
{

    /**
     * 累计人均名片数 0
     * @param array $params 搜索条件
     * @return multitype:boolean
     */
    public function getAddPerCapitaCardNum($params){
        $sql ='select
                    dt as time
                    ,card_avg_acu as num
                from dm_app_stats_card
                %s
                order by dt
                ';
        $whereStr = "WHERE dt BETWEEN '{$params['startTime']}' AND '{$params['endTime']} 23:59:59'";
        $sql=sprintf($sql,$whereStr);
        $res = $this->query( $sql);
        return $res;

    }
    /**
     * 累计名片语言分布 1
     * @param array $params 搜索条件
     * @return multitype:boolean
     * */
    public function getAddCardLanguage($params){
        $whereStr = "WHERE dt BETWEEN '{$params['startTime']}' AND '{$params['endTime']} 23:59:59'";
        switch($params['source']){
            case 1://拍照
                $select ='select
                                dt as time
                                ,sum(chinese_sim_card) as num #中文简体
                                ,sum(chinese_tra_card) as num1 #中文繁体
                                ,sum(english_card) as num2 #英语
                                ,sum(japanese_card) as num3 #日语
                                ,sum(russian_card) as num4 #俄语
                                ,sum(other_card) as num5 #其它
                            ';
                $whereStr.=' and (card_from between 1 and 2) ';
                break;
            case 2: //扫描仪
                $select ='select
                                dt as time
                                ,sum(chinese_sim_card) as num #中文简体
                                ,sum(chinese_tra_card) as num1 #中文繁体
                                ,sum(english_card) as num2 #英语
                                ,sum(japanese_card) as num3 #日语
                                ,sum(russian_card) as num4 #俄语
                                ,sum(other_card) as num5 #其它
                            ';
                $whereStr.=' and (card_from between 7 and 8) ';
                break;
            case 3://邮寄
                $select='select
                                dt as time
                                ,chinese_sim_card as num #中文简体
                                ,chinese_tra_card as num1 #中文繁体
                                ,english_card as num2 #英语
                                ,japanese_card as num3 #日语
                                ,russian_card as num4 #俄语
                                ,other_card as num5 #其它
                            ';
                $whereStr.=' and card_from=11 ';
                break;
            default://全部
                $select='select
                                dt as time
                                ,chinese_sim_card as num #中文简体
                                ,chinese_tra_card as num1 #中文繁体
                                ,english_card as num2 #英语
                                ,japanese_card as num3 #日语
                                ,russian_card as num4 #俄语
                                ,other_card as num5 #其它
                            ';
                $whereStr.=' and card_from=0 ';

        }


        $sql =$select.' from dm_app_stats_card_language '.$whereStr .' group by dt order by dt';
        $res = $this->query( $sql);
        return $res;

    }
    /**
     * 累计人均邮寄名片数 2
     * @param array $params 搜索条件
     * @return multitype:boolean
     */
    public function getAddPerCapitaPostCardNum($params){
        $sql ='select
                    dt AS time
                    ,mail_card_avg_acu as num
                from dm_app_stats_card
               %s
                order by dt
                ';
        $whereStr = "WHERE dt BETWEEN '{$params['startTime']}' AND '{$params['endTime']} 23:59:59'";
        $sql=sprintf($sql,$whereStr);
        $res = $this->query( $sql);
        return $res;

    }
    /**
     * 累计我的名片数 3
     * @param array $params 搜索条件
     * @return multitype:boolean
     */
    public function getTotalAddOurCardNum($params){
        $sql ='select
                    dt as time
                    ,sum(if(card_from=1,mycard,0)) +sum(if(card_from=4,mycard,0)) as num#总数
                    ,sum(if(card_from=1,mycard,0)) as num1 #拍照
                    ,sum(if(card_from=4,mycard,0)) as num2 #录入
                from dm_app_stats_card_source
                %s
                    and period=0
                group by dt
                order by dt';
        $whereStr = "WHERE dt BETWEEN '{$params['startTime']}' AND '{$params['endTime']} 23:59:59'";
        $sql=sprintf($sql,$whereStr);
        $res = $this->query( $sql);
        return $res;

    }
    /**
     * 累更新名片用户数 4
     * @param array $params 搜索条件
     * @return multitype:boolean
     */
    public function getUpdateUserNum($params){
        $sql ='select
                    dt as time
                    ,update_mycard_user as num
                from dm_app_stats_card_update
                %s
                order by dt';
        $whereStr = "WHERE dt BETWEEN '{$params['startTime']}' AND '{$params['endTime']} 23:59:59'";
        $whereStr .=' and period ='.$params['date_type'].' ';
        if($params['date_type']=='1'){//三日 条件增加 #周/月不需要
            $whereStr .=sprintf('and mod(datediff(dt,\'%s\'),3)=0 ' ,$params['startTime']);
        }
        $sql=sprintf($sql,$whereStr);
        $res = $this->query( $sql);
        return $res;

    }
    /**
     * 累更新名片数 5
     * @param array $params 搜索条件
     * @return multitype:boolean
     */
    public function getUpdateCardNum($params){
        $sql ='select
                    dt as time
                    ,update_mycard_num as num
                from dm_app_stats_card_update
                %s
                order by dt
                ';
        $whereStr = "WHERE dt BETWEEN '{$params['startTime']}' AND '{$params['endTime']} 23:59:59'";
        $whereStr .=' and period ='.$params['date_type'].' ';
        if($params['date_type']=='1'){//三日 条件增加 #周/月不需要
            $whereStr .=sprintf('and mod(datediff(dt,\'%s\'),3)=0 ' ,$params['startTime']);
        }
        $sql=sprintf($sql,$whereStr);
        $res = $this->query( $sql);
        return $res;

    }
    /**
     *  添加备注用户数 6
     * @param array $params 搜索条件
     * @return multitype:boolean
     */
    public function getAddNotedUserNum($params){
        $sql ='select
                        dt as time
                        ,add_remind_user as num
                    from dm_app_stats_card_remind
                    %s
                    order by dt
  ';
        $whereStr = "WHERE dt BETWEEN '{$params['startTime']}' AND '{$params['endTime']} 23:59:59'";
        $whereStr .=' and period ='.$params['date_type'].' ';
        if($params['date_type']=='1'){//三日 条件增加 #周/月不需要
            $whereStr .=sprintf('and mod(datediff(dt,\'%s\'),3)=0 ' ,$params['startTime']);
        }
        $sql=sprintf($sql,$whereStr);
        $res = $this->query( $sql);
        return $res;

    }
    /**
     * 累计用户身份数分布 7
     * @param array $params 搜索条件
     * @return multitype:boolean
     */
    public function getAddsUserIdNum($params){
        $sql ='select
                    dt as time
                    ,user_total as num
                    ,one_iden_user as num1
                    ,two_iden_user as num2
                    ,three_iden_user as num3
                from dm_app_stats_card_identity
               %s
                order by dt
                  ';
        $whereStr = "WHERE dt BETWEEN '{$params['startTime']}' AND '{$params['endTime']} 23:59:59'";
        $sql=sprintf($sql,$whereStr);
        $res = $this->query( $sql);
        return $res;

    }

    /**
     * 累计个人主页使用用户数 8
     * @param array $params 搜索条件
     * @return multitype:boolean
     */
    public function getAddsUseHomepageNum($params){
        $sql ='select
                    dt as time
                    ,user_num_acu as num
                from dm_app_stats_card_home_page
                    %s
                    and period = 0
                  order by dt ';
        $whereStr = "WHERE dt BETWEEN '{$params['startTime']}' AND '{$params['endTime']} 23:59:59'";
        $sql=sprintf($sql,$whereStr);
        $res = $this->query( $sql);
        return $res;

    }

    /**
     * 个人主页更新次数 9
     * @param array $params 搜索条件
     * @return multitype:boolean
     */
    public function getHomepageUpdateNum($params){
        $sql ='select
                    dt as time
                    ,update_num as num
                from dm_app_stats_card_home_page
                %s
                order by dt
;

                ';
        $whereStr = "WHERE dt BETWEEN '{$params['startTime']}' AND '{$params['endTime']} 23:59:59'";
        $whereStr .=' and period ='.$params['date_type'].' ';
        if($params['date_type']=='1'){//三日 条件增加 #周/月不需要
            $whereStr .=sprintf('and mod(datediff(dt,\'%s\'),3)=0 ' ,$params['startTime']);
        }
        $sql=sprintf($sql,$whereStr);
        $res = $this->query( $sql);
        return $res;
    }
    /**
     * 个人主页查看次数 10
     * @param array $params 搜索条件
     * @return multitype:boolean
     */
    public function getHomepageSeeNum($params){
        $sql ='select
                    dt as time
                    ,check_num as num
                from dm_app_stats_card_home_page
                %s
                order by dt
                ';
        $whereStr = "WHERE dt BETWEEN '{$params['startTime']}' AND '{$params['endTime']} 23:59:59'";
        $whereStr .=' and period ='.$params['date_type'].' ';
        if($params['date_type']=='1'){//三日 条件增加 #周/月不需要
            $whereStr .=sprintf('and mod(datediff(dt,\'%s\'),3)=0 ' ,$params['startTime']);
        }
        $sql=sprintf($sql,$whereStr);
        $res = $this->query( $sql);
        return $res;
    }

    /**
     * 累计拥有他人名片用户数量 11
     * @param array $params 搜索条件
     * @return multitype:boolean \Think\mixedgetAddCardUser
     */
     public function getHasOtherCardUserNum($params){
         $sql ='select
                    dt as time
                    ,own_othercard_user_acu as num
                from dm_app_stats_card
               %s
                order by dt
                ';
         $whereStr = "WHERE dt BETWEEN '{$params['startTime']}' AND '{$params['endTime']} 23:59:59'";
         $sql=sprintf($sql,$whereStr);
         $res = $this->query( $sql);
         return $res;
     }
    /**
     * 添加名片用户数量 12
     * @param array $params 搜索条件
     * @return multitype:boolean
     */
    public function getAddCardUser($params){
        $sql ='select
                    dt as time
                    ,sum(if(card_from=0,add_card_user,0)) as num #总数
                    ,sum(if(card_from=1,add_card_user,0))as num1  #拍照-APP
                    ,sum(if(card_from=2,add_card_user,0))as num2  #拍照-橙子
                    ,sum(if(card_from=3,add_card_user,0))as num3  #扫描二维码
                    ,sum(if(card_from=4,add_card_user,0))as num4  #录入
                    ,sum(if(card_from=5,add_card_user,0)) as num5 #多人交换-APP
                    ,sum(if(card_from=6,add_card_user,0))as num6  #通讯录里导入
                    ,sum(if(card_from=7,add_card_user,0))as num7  #扫描仪-APP
                    ,sum(if(card_from=8,add_card_user,0))as num8  #扫描仪-橙子
                    ,sum(if(card_from=9,add_card_user,0))as num9  #摇一摇
                    ,sum(if(card_from=10,add_card_user,0))as num10  #碰一碰
                    ,sum(if(card_from=11,add_card_user,0))as num11  #邮寄名片
                    ,sum(if(card_from=12,add_card_user,0))as num12  #邀请交换
                    ,sum(if(card_from=13,add_card_user,0))as num13  #系统监测
                    ,sum(if(card_from=14,add_card_user,0))as num14  #其它
                from dm_app_stats_card_source
                %s
                group by dt
                order by dt
                ';
        $whereStr = "WHERE dt BETWEEN '{$params['startTime']}' AND '{$params['endTime']} 23:59:59'";
        $whereStr .=' and period ='.$params['date_type'].' ';
        if($params['date_type']=='1'){//三日 条件增加 #周/月不需要
            $whereStr .=sprintf('and mod(datediff(dt,\'%s\'),3)=0 ' ,$params['startTime']);
        }
        $sql=sprintf($sql,$whereStr);
        $res = $this->query( $sql);
        return $res;
    }

    /**
     * 累计人均他人名片数 13
     * @param array $params 搜索条件
     * @return multitype:boolean \Think\mixed
     */
    public function getAddUpOtherNum($params){
        $sql ='select
                    dt as time
                    ,othercard_avg_acu as num
                from dm_app_stats_card
               %s
                order by dt
                ';
        $whereStr = "WHERE dt BETWEEN '{$params['startTime']}' AND '{$params['endTime']} 23:59:59'";
        $sql=sprintf($sql,$whereStr);
        $res = $this->query( $sql);
        return $res;
    }

    /**
     * 累计人均我的名片数量 14
     * @param array $params 搜索条件
     * @return multitype:boolean \Think\mixed
     */
    public function getAddUpOurNum($params){
        $sql ='select
                    dt as time
                    ,sum(if(card_from=1,mycard_avg,0)) as num1 #拍照
                    ,sum(if(card_from=4,mycard_avg,0))  as num2 #电子
                    ,sum(if(card_from=1,mycard_avg,0))
                        +sum(if(card_from=4,mycard_avg,0))  as num#总数
                from dm_app_stats_card_source
                %s
                    and period=0
                group by dt
                order by dt
                  ';
        $whereStr = "WHERE dt BETWEEN '{$params['startTime']}' AND '{$params['endTime']} 23:59:59'";
        $sql=sprintf($sql,$whereStr);
        $res = $this->query( $sql);
        return $res;
    }

    /**
     * 添加他人名片数 15
     * @param array $params 搜索条件
     * @return multitype:boolean
     */
    public function getAddOtherCardNum($params){
        $sql ='select
                    dt as time
                    ,sum(if(card_from=0,add_other_card,0)) as num #总数
                    ,sum(if(card_from=1,add_other_card,0)) as num1 #拍照-APP
                    ,sum(if(card_from=2,add_other_card,0)) as num2 #拍照-橙子
                    ,sum(if(card_from=3,add_other_card,0)) as num3  #扫描二维码
                    ,sum(if(card_from=4,add_other_card,0)) as num4  #录入
                    ,sum(if(card_from=5,add_other_card,0)) as num5  #多人交换-APP
                    ,sum(if(card_from=6,add_other_card,0)) as num6  #通讯录里导入
                    ,sum(if(card_from=7,add_other_card,0)) as num7 #扫描仪-APP
                    ,sum(if(card_from=8,add_other_card,0)) as num8  #扫描仪-橙子
                    ,sum(if(card_from=9,add_other_card,0)) as num9 #摇一摇
                    ,sum(if(card_from=10,add_other_card,0)) as num10 #碰一碰
                    ,sum(if(card_from=11,add_other_card,0)) as num11 #邮寄名片
                    ,sum(if(card_from=12,add_other_card,0)) as num12 #邀请交换
                    ,sum(if(card_from=13,add_other_card,0)) as num13 #系统监测
                    ,sum(if(card_from=14,add_other_card,0)) as num14 #其它
                from dm_app_stats_card_source
                %s
                group by dt
                order by dt
                ;
                ';
        $whereStr = "WHERE dt BETWEEN '{$params['startTime']}' AND '{$params['endTime']} 23:59:59'";
        $whereStr .=' and period ='.$params['date_type'].' ';
        if($params['date_type']=='1'){//三日 条件增加 #周/月不需要
            $whereStr .=sprintf('and mod(datediff(dt,\'%s\'),3)=0 ' ,$params['startTime']);
        }
        $sql=sprintf($sql,$whereStr);
        $res = $this->query( $sql);
        return $res;
    }

    /**
     * 累计名片数 16
     * @param array $params 搜索条件
     * @return multitype:boolean
     */
    public function getCardNum($params){
        $sql ='select
                    dt as time
                    ,sum(if(card_from=0,card_total,0)) as num #总数
                    ,sum(if(card_from=1,card_total,0)) as num1 #拍照-APP
                    ,sum(if(card_from=2,card_total,0)) as num2 #拍照-橙子
                    ,sum(if(card_from=3,card_total,0)) as num3  #扫描二维码
                    ,sum(if(card_from=4,card_total,0)) as num4  #录入
                    ,sum(if(card_from=5,card_total,0)) as num5  #多人交换-APP
                    ,sum(if(card_from=6,card_total,0)) as num6  #通讯录里导入
                    ,sum(if(card_from=7,card_total,0)) as num7 #扫描仪-APP
                    ,sum(if(card_from=8,card_total,0)) as num8  #扫描仪-橙子
                    ,sum(if(card_from=9,card_total,0)) as num9 #摇一摇
                    ,sum(if(card_from=10,card_total,0)) as num10 #碰一碰
                    ,sum(if(card_from=11,card_total,0)) as num11 #邮寄名片
                    ,sum(if(card_from=12,card_total,0)) as num12 #邀请交换
                    ,sum(if(card_from=13,card_total,0)) as num13 #系统监测
                    ,sum(if(card_from=14,card_total,0)) as num14 #其它
                from dm_app_stats_card_source
                %s
                group by dt
                order by dt
                ;
                ';
        $whereStr = "WHERE dt BETWEEN '{$params['startTime']}' AND '{$params['endTime']} 23:59:59' and period=0";
        $sql=sprintf($sql,$whereStr);
        $res = $this->query( $sql);
        return $res;
    }

    /**
     * 当月累计添加名片数  17
     * @param array $params 搜索条件
     * @return multitype:boolean
     */
    public function getAddCardNumMonth($params){
        $sql ='select
                    dt as time
                    ,sum(if(card_from=0,card_month_accumulate,0)) as num #总数
                    ,sum(if(card_from=1,card_month_accumulate,0)) as num1 #拍照-APP
                    ,sum(if(card_from=2,card_month_accumulate,0)) as num2 #拍照-橙子
                    ,sum(if(card_from=3,card_month_accumulate,0)) as num3  #扫描二维码
                    ,sum(if(card_from=4,card_month_accumulate,0)) as num4  #录入
                    ,sum(if(card_from=5,card_month_accumulate,0)) as num5  #多人交换-APP
                    ,sum(if(card_from=6,card_month_accumulate,0)) as num6  #通讯录里导入
                    ,sum(if(card_from=7,card_month_accumulate,0)) as num7 #扫描仪-APP
                    ,sum(if(card_from=8,card_month_accumulate,0)) as num8  #扫描仪-橙子
                    ,sum(if(card_from=9,card_month_accumulate,0)) as num9 #摇一摇
                    ,sum(if(card_from=10,card_month_accumulate,0)) as num10 #碰一碰
                    ,sum(if(card_from=11,card_month_accumulate,0)) as num11 #邮寄名片
                    ,sum(if(card_from=12,card_month_accumulate,0)) as num12 #邀请交换
                    ,sum(if(card_from=13,card_month_accumulate,0)) as num13 #系统监测
                    ,sum(if(card_from=14,card_month_accumulate,0)) as num14 #其它
                from dm_app_stats_card_source
                %s
                group by dt
                order by dt
                ;
                ';
        $whereStr = "WHERE dt BETWEEN '{$params['startTime']}' AND '{$params['endTime']} 23:59:59' 	and period=0";
        $sql=sprintf($sql,$whereStr);
        $res = $this->query( $sql);
        return $res;
    }

    /**
     * 名片交换次数 18
     * @param array $params 搜索条件
     * @return multitype:boolean
     */
    public function getSwitchCardNum($params){
        $sql ='select
                        dt  as time
                        ,sum(if(card_from=3,card_exchanged,0))
                            +sum(if(card_from=5,card_exchanged,0))
                            +sum(if(card_from=9,card_exchanged,0))
                            +sum(if(card_from=10,card_exchanged,0))
                            +sum(if(card_from=12,card_exchanged,0))
                            +sum(if(card_from=13,card_exchanged,0)) as num #总数
                        ,sum(if(card_from=3,card_exchanged,0)) as num1  #扫码
                        ,sum(if(card_from=5,card_exchanged,0)) as num2 #多人交换-App
                        ,sum(if(card_from=9,card_exchanged,0)) as num4 #摇一摇
                        ,sum(if(card_from=10,card_exchanged,0)) as num5 #碰一碰
                        ,sum(if(card_from=12,card_exchanged,0)) as num3#邀请交换
                        ,sum(if(card_from=13,card_exchanged,0)) as num6#系统监测
                    from dm_app_stats_card_source
                    %s
                    group by dt
                    order by dt  ';
        $whereStr = "WHERE dt BETWEEN '{$params['startTime']}' AND '{$params['endTime']} 23:59:59'";
        $whereStr .=' and period ='.$params['date_type'].' ';
        if($params['date_type']=='1'){//三日 条件增加 #周/月不需要
            $whereStr .=sprintf('and mod(datediff(dt,\'%s\'),3)=0 ' ,$params['startTime']);
        }
        $sql=sprintf($sql,$whereStr);
        $res = $this->query( $sql);
        return $res;
    }

    /**
     *  精准识别 19
     * @param array $params 搜索条件
     * @return multitype:boolean
     */

    public function getAccurate($params){
        $sql ='select
                    dt as time
                    ,precise_card_num as num
                    ,precise_card_user as num1
                    ,precise_card_avg as num2
                from dm_app_stats_card_precision
                %s
                order by dt';
        $whereStr = "WHERE dt BETWEEN '{$params['startTime']}' AND '{$params['endTime']} 23:59:59'";
        $whereStr .=' and period ='.$params['date_type'].' ';
        if($params['date_type']=='1'){//三日 条件增加 #周/月不需要
            $whereStr .=sprintf('and mod(datediff(dt,\'%s\'),3)=0 ' ,$params['startTime']);
        }
        $sql=sprintf($sql,$whereStr);
        $res = $this->query( $sql);
        return $res;


    }


}
