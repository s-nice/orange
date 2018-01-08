<layout name="../Layout/Appadmin/Layout" />
<div class="user_order_show">
    <div class="u_o_item">
        <h4>套餐信息</h4>
        <ul>
<!--            <li><span>套餐ID：</span><em>{$info.id}</em></li>-->
            <li><span>企业名称：</span><em>{$info.bizname}</em></li>
            <li><span>员工数量：</span><em>{$info.num}</em></li>
            <li><span>名片数量：</span><em>{$info.sheet}</em></li>
            <li><span>套餐等级：</span><em>
                    <php>
                        switch($info['level']){
                        case '0' :
                        echo '试用级';
                        break;
                        case '1':
                        echo '基础级';
                        break;
                        case '2' :
                        echo '黄金级';
                        break;
                        case '3':
                        echo '钻石级';
                        break;
                        case '4' :
                        echo '铂金级';
                        break;
                        default:
                        echo  '未知' ;
                        }
                    </php>
                </em></li>
            <li><span>套餐描述：</span><em>
                    <?php
                    if($info['suitejson']){
                        $suitejson = json_decode($info['suitejson'],true);
                        echo $suitejson['suite_desc'];
                    }else{
                        echo "";
                    }
                    ?></em></li>
            <li><span>套餐单价：</span><em>￥<?php echo $suitejson['price'] ?></em></li>
            <li><span>有效日期：</span><em>{:date('Y-m-d H:i',$info['end_time'])}</em></li>
            <li><span>创建时间：</span><em>{:date('Y-m-d H:i',$info['create_time'])}</em></li>
            <li><span>修改时间：</span><em>{:date('Y-m-d H:i',$info['modifytime'])}</em></li>
        </ul>
    </div>
