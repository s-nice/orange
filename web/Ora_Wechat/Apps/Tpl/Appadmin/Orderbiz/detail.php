<layout name="../Layout/Appadmin/Layout" />
<div class="user_order_show">
    <div class="u_o_item">
        <h4>订单信息</h4>
        <ul>
            <li><h5>基础信息</h5></li>
            <li><span>订单ID：</span><em>{$detail.id}</em></li>
            <li><span>订单号：</span><em>{$detail.ordersn}</em></li>
            <li><span>订单类型：</span><em>
                    <php>
                        switch($detail['ordertype']){
                        case '1' :
                        echo '新购';
                        break;
                        case '2':
                        echo '增员';
                        break;
                        case '3':
                        echo '续费';
                        break;
                        case '2':
                        echo '升级';
                        break;
                        default:
                        echo  '未知' ;
                        }
                    </php>
                </em></li>
            <li><span>订单来源：</span><em>
                    <php>
                        switch($detail['ordersource']){
                        case '1' :
                        echo '用户下单';
                        break;
                        case '2':
                        echo '运营赠送';
                        break;
                        default:
                        echo  '未知' ;
                        }
                    </php>
                </em></li>
            <li><span>优惠来源：</span><em>{$detail.discountsource}</em><em style="float: right;font-size: 12px">[优惠来源包含套餐升级抵扣和系统赠送的优惠券]</em></li>
            <li><span>优惠金额：</span><em>￥{$detail.discountamount}</em><em style="float: right">[优惠金额包含套餐升级抵扣的金额]</em></li>
            <li><span>支付金额：</span><em>￥{$detail.payamount}</em></li>
            <li><span>订单金额：</span><em>￥{$detail.totalamount}</em></li>
            <li><span>支付状态：</span><em>
                    <php>
                        switch($detail['paystatus']){
                        case '0' :
                        echo '默认';
                        break;
                        case '1':
                        echo '未支付';
                        break;
                        case '2':
                        echo '已支付';
                        break;
                        case '3':
                        echo '待退款';
                        break;
                        case '4':
                        echo '已退款';
                        break;
                        default:
                        echo  '未知' ;
                        }
                    </php>
                </em></li>
            <li><span>创建时间：</span><em>{:date('Y-m-d H:i',$info['create_time'])}</em></li>
            <li><span>支付时间：</span><em><if condition="isset($detail['paytime'])">{:date('Y-m-d H:i',$detail['paytime'])}<else/> </if></em></li>
            <li><span>第三方订单号：</span><em>{$detail.tradeno}月</em></li>
            <li><span>支付方式：</span><em>
                    <php>
                        switch($detail['platform']){
                        case '0' :
                        echo '默认';
                        break;
                        case '1':
                        echo '支付宝';
                        break;
                        case '2':
                        echo '微信';
                        break;
                        case '3':
                        echo '银联';
                        break;
                        case '4':
                        echo '内部支付';
                        break;
                        default:
                        echo  '未知' ;
                        }
                    </php>
                </em></li>
            <li><span>企业ID：</span><em>{$detail.bizid}</em></li>
            <li><span>企业名称：</span><em>{$detail.bizname}</em></li>
        </ul>
        <ul>
            <li><h5>套餐信息</h5></li>
            <li><span>套餐ID：</span><em>{$info.id}</em></li>
            <li><span>套餐名称：</span><em>{$info.name}</em></li>
            <li><span>员工数量：</span><em>{$info.num}</em></li>
            <li><span>名片数量：</span><em>{$info.sheet}</em></li>
            <li><span>套餐描述：</span><em>{$info.suite_desc}</em></li>
            <li><span>套餐单价：</span><em>￥{$info.price}</em></li>
            <li><span>套餐时长：</span><em>{$info.buy_month}月</em></li>
            <li><span>套餐状态：</span><em>
                    <php>
                        switch($info['status']){
                        case '0' :
                        echo '待激活';
                        break;
                        case '99':
                        echo '不可用';
                        break;
                        default:
                        echo  '可使用' ;
                        }
                    </php>
                </em></li>
            <li><span>创建时间：</span><em>{:date('Y-m-d H:i',$info['create_time'])}</em></li>
            <li><span>修改时间：</span><em><if condition="isset($detail['paytime'])">{:date('Y-m-d H:i',$info['modifytime'])}<else/> </if></em></li>
        </ul>
    </div>
