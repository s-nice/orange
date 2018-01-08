<layout name="../Layout/Appadmin/Layout" />
<div class="user_order_show">
    <form method="post" action="{:U('Appadmin/Suite/edit','',false)}" class="form_suite_edit">
    <div class="u_o_item">
        <h4>编辑套餐信息</h4>
        <ul>
            <input type="hidden" name="id" value="{$info.id}" id="suite_id" data-suite_id="{$info.id}"/>
            <li><span>套餐ID：</span><em>{$info.id}</em></li>
            <li><span>套餐名称：</span><em>{$info.name}</em></li>
            <li><span>员工数量：</span><em>{$info.num}</em></li>
            <li><span>名片数量：</span><em>{$info.sheet}</em></li>
            <li><span>套餐等级：</span><em>
                    <input type="radio" name="level" disabled value="0" <if condition="$info['level']==0">checked</if>> 试用级
                    <input type="radio" name="level" disabled value="1" <if condition="$info['level']==1">checked</if>> 基础级
                    <input type="radio" name="level" disabled value="2" <if condition="$info['level']==2">checked</if>> 黄金级
                    <input type="radio" name="level" disabled value="3" <if condition="$info['level']==3">checked</if>> 钻石级
                    <input type="radio" name="level" disabled value="4" <if condition="$info['level']==4">checked</if>> 铂金级</em>
            </li>
            <li><span>套餐描述：</span><em>{$info.suite_desc}</em></li>
            <li><span>套餐单价：</span><em>￥{$info.price}</em></li>
            <li><span>套餐时长：</span><em>{$info.buy_month}月</em></li>
            <li><span>创建时间：</span><em>{:date('Y-m-d H:i',$info['create_time'])}</em></li>
            <li><span>修改时间：</span><em>{:date('Y-m-d H:i',$info['modifytime'])}</em></li>
            <li><span>套餐状态：</span><em>

            <input type="radio" name="status" value="0" <if condition="$info['status']==0">checked</if>> 待上线
            <input type="radio" name="status" value="99" <if condition="$info['status']==99">checked</if>> 禁用(下线)
            <input type="radio" name="status" value="100" <if condition="$info['status']==100">checked</if>> 正常

                </em></li>
            <li><span>设为赠送套餐：</span><em>
                    <input type="radio" name="isdefault" value="0" <if condition="$info['isdefault']==0">checked</if>> 否
                    <input type="radio" name="isdefault" value="1" <if condition="$info['isdefault']==1">checked</if>> 是
                </em></li>

        </ul>
        <div style="border: none; text-align:center;margin-top: 50px"><!--<button class="big_button" type="button">确认修改</button>--><input class="big_button" id="submit_edit" type="button" value="确认修改"> &nbsp;&nbsp;<input type="reset" value="重置操作" class="big_button" >&nbsp;&nbsp;<input type="button" value="返回列表" class="big_button" id="goto_list" ></div>
    </div>
    </form>
    <script type="text/javascript">
        var gSuiteEditUrl="{:U('Appadmin/Suite/edit','','','',true)}";
        var gUrl="{:U('Appadmin/Suite/index','','','',true)}";
    </script>
    <literal>
        <script type="text/javascript">
            $(function(){
                //时间选择
                $.suite.init();
            });
        </script>