<layout name="../Layout/Company/AdminLTE_layout" />
<div class="staff_warp">
    <div class="container_right">
        <div class="staff_table">
            <div class="data-list">
                <form action="{:U('/Company/Staff/saveConsumeRules')}" method="post">
                <div class="transverse">
                    <span class="title_span"><em>*</em>{$T->str_rule_title}：</span><span class="title_input"><input class="pice form_focus" type="text" name="title" value="{$data.title}"></span>
                </div>
                <div class="transverse js_time">
                    <span class="title_span">{$T->str_rule_timecycle}：</span>
                    <span class="radio_input"><input type="radio" name="timecycle" value="0" <if condition="$data['cycle'] eq 0">checked</if>  ><label></label><em>{$T->str_rule_unlimit}</em></span>
                    <span class="radio_input"><input type="radio" name="timecycle" value="1" <if condition="$data['cycle'] eq 1">checked</if>  ><label></label><em>{$T->str_rule_everyday}</em></span>
                    <span class="radio_input"><input type="radio" name="timecycle" value="2" <if condition="$data['cycle'] eq 2">checked</if>  ><label></label><em>{$T->str_rule_everyweek}</em></span>
                    <span class="radio_input"><input type="radio" name="timecycle" value="3" <if condition="$data['cycle'] eq 3">checked</if>  ><label></label><em>{$T->str_rule_everymonth}</em></span>
                    <span class="radio_input"><input type="radio" name="timecycle" value="4" <if condition="$data['cycle'] eq 4">checked</if>  ><label></label><em>{$T->str_rule_everyyear}</em></span>
                    
                </div>
                <div class="transverse js_num">
                	<span class="title_span">{$T->str_rule_num}：</span>
                    <span class="radio_input js_radio_unlimit"><input type="radio" name="numblimit" value="0" <if condition="$data['num'] eq 0">checked</if> ><label></label><em>{$T->str_rule_unlimit}</em></span> 
                    <span class="radio_input"><input type="radio" name="numblimit" value="1" <if condition="$data['num'] gt 0">checked</if> ><label></label><em>{$T->str_rule_limit}</em></span>
                    <span class="num_span"><input class="pice form_focus" type="text" name="num" <if condition="$data['num'] gt 0">value="{$data.num}"</if>>{$T->str_rule_lt_piece}</sapn>
                </div>
                <div class="transverse js_money">
                    <span class="title_span">{$T->str_rule_money}：</span>
                    <span class="radio_input js_radio_unlimit"><input type="radio" name="moneylimit" value="0" <if condition="$data['sum'] eq 0">checked</if>><label></label><em>{$T->str_rule_unlimit}</em></span>
                    <span class="radio_input"><input type="radio" name="moneylimit" value="1" <if condition="$data['sum'] gt 0">checked</if>><label></label><em>{$T->str_rule_limit}</em></span>
                    <span class="num_span"><input class="pice form_focus" type="text" name="money" <if condition="$data['sum'] gt 0">value="{$data.sum}"</if>>{$T->str_rule_lt_yuan}</span>
                </div>
                <div class="transverse js_price">
                    <span class="title_span">{$T->str_rule_price}：</span>
                    <span class="radio_input js_radio_unlimit"><input type="radio" name="unitpricelimit" value="0" <if condition="$data['price'] eq 0">checked</if> ><label></label><em>{$T->str_rule_unlimit}</em></span>
                    <span class="radio_input"><input type="radio" name="unitpricelimit" value="1" <if condition="$data['price'] gt 0">checked</if> ><label></label><em>{$T->str_rule_limit}</em></span>
                    <span class="num_span"><input class="pice form_focus" type="text" name="price" <if condition="$data['price'] gt 0">value="{$data.price}"</if> >{$T->str_rule_lt_yuan}<em class="lettle_text">，{$T->str_rule_max}2000</em></span>
                </div>
                <div class="transverse">
                    <input type="hidden" name="id" value="{$data.cumid}">
                    <input class="btn_time js_btn_sub" type="button" value="{$T->str_submit_save}" >
                    <input class="btn_time2 js_btn_can can_btn" type="button" value="{$T->str_pwd_btn_cancel}" >
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var addPostUrl = "__URL__/saveConsumeRules";
    var listUrl = "__URL__/consumeRules";
    $(function(){
        $.staff.addConsumerRule();
    });
</script>