<layout name="../Layout/Appadmin/Layout" />
<div class="user_order_show">
    <div class="u_o_item">
        <h4>企业信息</h4>
        <ul>
            <li><span>企业ID：</span><em>{$info.id}</em></li>
            <li><span>企业名称：</span><em>{$info.bizname}</em></li>
            <li><span>员工数量：</span><em>{$info.emp_count}</em></li>
            <li><span>名片数量：</span><em>{$info.card_count}</em></li>
            <li><span>地址：</span><em>{$info.address}</em></li>
            <li><span>企业邮箱：</span><em>{$info.bizemail}</em></li>
            <li><span>网址：</span><em>{$info.website}</em></li>
            <li><span>企业规模：</span><em>{$info.biz_size}</em></li>
            <li><span>联系手机：</span><em>{$info.phone}</em></li>
            <li><span>联系人：</span><em>{$info.contact}</em></li>
            <li><span>是否开启共享：</span><em>{$info.open}</em></li>
            <li><span>允许添加的员工数量：</span><em>{$info.count}</em></li>
            <li><span>企业状态：</span><em>
                    <php>
                        switch($info['status']){
                        case 'limited' :
                        echo '待激活';
                        break;
                        case 'blocked' :
                        echo '已锁定';
                        break;
                        case 'inactive':
                        echo '不可用';
                        break;
                        default:
                        echo  '可使用' ;

                        }
                    </php>
                </em></li>
            <li><span>创建时间：</span><em>{:date('Y-m-d H:i',$info['createdtime'])}</em></li>
            <li><span>修改时间：</span><em>{:date('Y-m-d H:i',$info['modifytime'])}</em></li>
            <li><span>二维码创建时间：</span><em>{:date('Y-m-d H:i',$info['qrcodetime'])}</em></li>


        </ul>
    </div>
