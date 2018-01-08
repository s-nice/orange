<layout name="../Layout/Layout" />
<div class="appadmin_addAdministrator" id="js_layer_div" style="display:block;">

    <div class="Administrator_pop_c">

        <div class="label_codelist"><span>{$T->str_redeemcode_num}:</span><input class="input_text" type="text" name="num" /></div>
        <div class="label_codelist"><span><!-- <input class="input_checkbox" type="checkbox" name="is_len" checked="checked"> -->{$T->str_exchange_length}:</span><input class="input_text" type="text" name="len"  /><i>天</i></div>
        <div class="label_codelist">
            <span><!-- <input class="input_checkbox" type="checkbox" name="is_stock"> -->{$T->str_exchange_num}:</span><input class="input_text" type="text" name="stock" /><i>张</i></div>
        <div class="label_codelist">
            <div class="select_time_c">
                <span style="margin-right:10px;">{$T->str_redeemcode_effective}:</span>
                <div class="time_c">
                        <input id="js_begintime_code" class="time_input" type="text" readonly="readonly" name="start_time_code" readonly="readonly" />
                        <i class="js_selectTimeStr"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                    </div>
                    <em>--</em>
                    <div class="time_c">
                        <input id="js_endtime_code" class="time_input" type="text" readonly="readonly" name="end_time_code" />
                        <i class="js_selectTimeStr"><img src="__PUBLIC__/images/appadmin_icon_xiala.png" /></i>
                    </div>
                </div>
            </div>
            
       
        <div class="Administrator_bin">
            <input id="js_cancel_close" class="dropout_inputr cursorpointer js_add_cancel" type="button" value="{$T->str_btn_cancel}" />
            <input class="dropout_inputl cursorpointer js_add_sub" type="button" value="{$T->str_btn_ok}" />
        </div>
    </div>
</div>
<script>
var add_post_url="{:U('Appadmin/ActiveOperation/createnumcode','','','',true)}";
$(function(){
    $.activeoperation.addredeem();
    $.dataTimeLoad.init({
        idArr: [{start:'js_begintime_code',end:'js_endtime_code'}],
        minDate:{start:Date(),end:Date()},
        maxDate:{start:false,end:false},
    });
    
});
</script>