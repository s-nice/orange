<layout name="../Layout/Company/AdminLTE_layout" />
<div class="staff_warp">
    <div class="container_right">
        <div class="staff_table">
            <div class="search_div_no">
                <a href="{:U('newConsumeRules')}"><input type="button" value="{$T->str_rule_add}"></a>
            </div>
            <div class="data-list">
                <div class="row listrules_tab">
                    <span class="col-md-2 col-xs-2 border_left">{$T->str_rule_title}</span>
                    <span class="col-md-2 col-xs-2">{$T->str_rule_timecycle}</span>
                    <span class="col-md-2 col-xs-2">{$T->str_rule_num}</span>
                    <span class="col-md-2 col-xs-2">{$T->str_rule_money}</span>
                    <span class="col-md-2 col-xs-2">{$T->str_rule_price}</span>
                    <span class="col-md-2 col-xs-2">{$T->str_employee_op}</span>
                </div>
                <div class="list_data">
                    <foreach name="list" item="val">
                    <div class="row listrules_data_c">
                        <span class="col-md-2 col-xs-2 border_left">{$val.title}</span>
                        <span class="col-md-2 col-xs-2">{$cycles[$val['cycle']]}</span>
                        <span class="col-md-2 col-xs-2"><if condition="$val['num'] eq 0">不限<else />{$val.num}</if></span>
                        <span class="col-md-2 col-xs-2"><if condition="$val['sum'] eq 0">不限<else />{$val.sum}.00元</if></span>
                        <span class="col-md-2 col-xs-2"><if condition="$val['price'] eq 0">不限<else />{$val.price}元以内</if></span>
                        <span class="col-md-2 col-xs-2"><a href="{:U('/Company/Staff/newConsumeRules',array('id'=>$val['cumid']))}">编辑</a><a data-id="{$val.cumid}" href="javascript:" class="js_delete">删除</a></span>
                    </div>
                    </foreach>
                </div>
            </div>
    <!-- 翻页效果引入 -->
    <include file="@Layout/pagemain" />
        </div>
    </div>
</div>
<script>
    var delRuleUrl = "__URL__/delConsumeRules";
    $(function(){
        $.staff.consumerRulesJs();
    })
</script>