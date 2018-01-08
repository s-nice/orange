<layout name="../Layout/Company/AdminLTE_layout" />
<div class="client_list">
<span class="company_name">{$T->customer_company_name}：</span><input  id="js_company_name" class="form_focus client_search" type="text"
    <if condition="isset($params['name'])">{$params['name']}</if>> <button id="js_search_btn" class="client_btn">{$T->customer_company_query}</button>
<div class="row client_info_list">
<p class="row title_bgcolor">
	<span class="col-md-4 col-xs-4 company_span">{$T->customer_company_name}</span>
    <span class="col-md-3 col-xs-3 bank_span">{$T->customer_company_industry}</span>
    <span class="col-md-3 col-xs-3 card_span">{$T->customer_company_card_num}</span>
    <span class="col-md-2 col-xs-2 look_span">{$T->customer_company_operation}</span>
</p>
<if condition="!empty($list)">
    <foreach name="list" item="vo">
        <p class="row comtent_bgcolor">
        	<span class="col-md-4 col-xs-4">{$vo.name}</span>
            <span class="col-md-3 col-xs-3 bank_span">待确定</span>
            <span class="col-md-3 col-xs-3 card_span">{$vo.cardnum}</span>
            <a href="{:U(MODULE_NAME.'/Customer/companyDetail',array('name'=>$vo['name']),'',true)}">
                <span class="col-md-2 col-xs-2 look_span color_look_span js_show_one" name-data="{$vo.name}">{$T->customer_company_show}</span>
                </a>
        </p>
    </foreach>
    <else/>
    NO DATA
</if>
</div>
<!-- 翻页效果引入 -->
<include file="@Layout/pagemain" />
</div>
<script>
    var p="{$params.p}";
    var searchUrl = "{:U((MODULE_NAME.'/Customer/customerCompany'),'','','',true)}";
    var showUrl = "{:U((MODULE_NAME.'/Customer/companyDetail'),'','','',true)}";
    $(function(){
        $.customers.company();


    })
</script>
