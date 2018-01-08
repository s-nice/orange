<layout name="../Layout/Appadmin/Layout" />
<div class="user_order_show">
    <div class="u_o_item">
        <h4>套餐信息</h4>
        <ul>
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
            <li><span>套餐单价：</span><em>
                    <?php
                    if(isset($info['suitejson'])){
                        $suitejson = json_decode($info['suitejson'],true);
                        echo $suitejson['price'];
                    }else{
                        echo "";
                    }
                    ?></em></li>

            <li><span>有效日期：</span><em>{:date('Y-m-d H:i',$info['end_time'])}</em></li>
        </ul>
        <h4>升级套餐</h4>
        <input type="hidden" id="bizid" data-biz_id="{$info.bizid}"/>
        <div class="u_o_item">
            <ul>
                <foreach name="list" item="val">
                    <li>
                        <input type="radio" name="metaid" value="{$val['id']}"> 套餐名称：{$val['name']} 包含:{$val['num']}人, 名片:{$val['sheet']}张, 有效时长:{$val['buy_month']}月, 单价:￥{$val['price']}
                    </em>
                    </li>
                </foreach>
            </ul>
        </div>
        <div style="border: none; text-align:center;margin-top: 50px"><input class="big_button" id="submit_upgrade" type="button" value="确认升级"> &nbsp;&nbsp;<input type="reset" value="重置操作" class="big_button" >&nbsp;&nbsp;<input type="button" value="返回列表" class="big_button" id="goto_list" ></div>
    </div>


    <script type="text/javascript">
        var gSuiteUpgradUrl="{:U('Appadmin/Suite/upgrade','','','',true)}";
        var gSuiteDetailUrl="{:U('Appadmin/Suite/termdetail','','','',true)}";
    </script>
    <literal>
        <script type="text/javascript">
            $(function(){
                //时间选择
                $.suite.init();
            });
        </script>
