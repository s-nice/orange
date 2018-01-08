<layout name="../Layout/Appadmin/Layout" />
<div class="user_order_show">
    <form method="post" action="{:U('Appadmin/Suite/add','',false)}">
        <div class="u_o_item">
            <h4>新增套餐信息</h4>
            <ul>
                <li><span>套餐名称：</span><input class="num_text" type="text" name="name"></li>
                <li><span>员工数量：</span><input class="num_text" type="text" name="num"></li>
                <li><span>名片数量：</span><input class="num_text" type="text" name="sheet"></li>
                <li><span>套餐等级：</span><em>
                    <input type="radio" name="level" value="0" <if condition="$info['level']==0">checked</if>> 试用级
                    <input type="radio" name="level" value="1" <if condition="$info['level']==1">checked</if>> 基础级
                    <input type="radio" name="level" value="2" <if condition="$info['level']==2">checked</if>> 黄金级
                    <input type="radio" name="level" value="3" <if condition="$info['level']==3">checked</if>> 钻石级
                    <input type="radio" name="level" value="4" <if condition="$info['level']==4">checked</if>> 铂金级</em>
                </li>
                <li><span>套餐描述：</span><input class="num_text" type="text" name="suite_desc"></li>
                <li><span>套餐单价：</span><input class="num_text" type="text" name="price"></li>
                <li><span>套餐时长：</span><input class="num_text" type="text" name="buy_month"></li>
                <li><span>套餐状态：</span><em>
                    <input type="radio" name="status" value="0" <if condition="$info['status']==0">checked</if>> 待上线
                    <input type="radio" name="status" value="99" <if condition="$info['status']==99">checked</if>> 禁用(下线)
                    <input type="radio" name="status" value="100" <if condition="$info['status']==100">checked</if>> 正常
                    </em></li>

            </ul>
            <div style="border: none; text-align:center;margin-top: 50px"><!--<button class="big_button" type="button">确认修改</button>--><input class="big_button" id="submit_add" type="botton" value="确认新增"> &nbsp;&nbsp;<input type="reset" value="重置操作" class="big_button" >&nbsp;&nbsp;<input type="button" value="返回列表" class="big_button" id="goto_list" ></div>
        </div>
    </form>
    <script type="text/javascript">
        var gUrl="{:U('Appadmin/Suite/index','','','',true)}";
        var gSuiteAddUrl="{:U('Appadmin/Suite/add','','','',true)}";
    </script>
    <literal>
        <script type="text/javascript">
            $(function(){
                //时间选择
                $.suite.init();
            });
        </script>