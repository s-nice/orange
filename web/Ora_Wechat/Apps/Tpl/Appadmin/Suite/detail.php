<layout name="../Layout/Appadmin/Layout" />
<div class="user_order_show">
    <div class="u_o_item">
        <h4>套餐信息</h4>
        <ul>
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
            <li><span>修改时间：</span><em>{:date('Y-m-d H:i',$info['modifytime'])}</em></li>
        </ul>
    </div>
