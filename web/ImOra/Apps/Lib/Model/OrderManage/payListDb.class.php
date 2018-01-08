<?php
namespace Model\OrderManage;

use \Think\Model;


class PayListDb extends Model
{
    public function _initialize()
    { //构造函数
        $this->connection = C('APPADMINDB');
    }

    /**
     * 企业充值订单列表
     * params array $params 搜索条件
     * return array
     *
     * */

    public function getPayList($params = array())
    {
        $res = '';
        $where = [];
        if (isset($params['orderNum'])) { //订单号
            $where[] = '  a.order_id=' . sprintf('\'%s\'', $params['orderNum']);

        };
        if (isset($params['biz_email'])) {//企业id(邮箱)
            $where[] = ' b.biz_email=' . sprintf('\'%s\'', $params['biz_email']);

        }
        if (isset($params['biz_name'])) {//企业名称
            $where[] = ' b.biz_name=' . sprintf('\'%s\'', $params['biz_name']);

        }
        if (isset($params['createtime'])) {//创建时间区间
            $where[] = ' a.create_time BETWEEN ' . $params['createtime'];

        }
        $where = implode(' AND ', $where);
        $where = $where != '' ? ' AND ' . $where : '';
        $sqlNumFound = 'SELECT COUNT(a.id) AS numfound
               FROM biz_order   AS a LEFT JOIN account_biz_detail AS b ON a.biz_id=b.biz_id
               WHERE a.type=6' . $where;
        $numFound = $this->query($sqlNumFound);
        $numFound = $numFound[0]['numfound'];
        if ($numFound != 0) {
            $sql = 'SELECT a.id,a.order_id,a.create_time AS createtime ,a.status,a.trade_no,a.price,b.biz_email,b.biz_name
              FROM biz_order   AS a LEFT JOIN account_biz_detail AS b ON a.biz_id=b.biz_id
              WHERE a.type=6';
            $orderby = $params['sort'] == 'asc' ? ' ORDER BY createtime asc' : ' ORDER BY createtime desc';
            $limit = ' LIMIT ' . $params['start'] . ',' . $params['rows'];
            $sql = $sql . $where . $orderby . $limit;
            $list = $info = $this->query($sql);
            $res = array(
                'numfound' => $numFound,
                'list' => $list
            );
        } else {
            $res = array(
                'numfound' => $numFound,
            );
        }

        return $res;

    }


}