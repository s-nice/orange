<layout name="../Layout/Layout" />
<div class="showcond_warp">
  <div class="u_o_item">
    <h4>订单基本信息</h4>
    <ul>
      <if condition="$data['status'] eq 2">
      <li><span>{$T->str_invoice_no}：</span><input name="invoice_no" class="num_text js_start_pop" title="" value="" type="text"></li>
      <li><span>{$T->str_attachment}：</span><b class="p_file"><img id="title_pic" hasImage="<if condition="$list['image']">true<else />false</if>" src="<if condition="$list['image']">{$list['image']}<else />__PUBLIC__/images/activeadd.jpg</if>" /><input title=" " val="" type="file"  name="uploadImgField1" id="uploadImgField1" hid="uploadImgField1"></b><input type="hidden" id="js_img_url"><button id="js_save_img" type="button">{$T->str_intro_save}</button></li>
      </if>
      <input type="hidden" name="id" value="{$data.id}">
      <if condition="$data['status'] eq 3">
        <li class="clear"><span>{$T->str_invoice_no}：</span><em>{$data.invoice_no}</em></li>
        <if condition="$data['uploadfile']">
        <li><span>{$T->str_attachment}：</span><b class="p_file"><img  class="js_click_show" src="{$data.uploadfile}" /></b></li>
        </if>
      </if>
      <li class="clear"><span>{$T->str_invoice_type}：</span><em>{$types[$data['type']]}</em></li>
      <li class="clear"><span>{$T->str_invoice_title}：</span><em><if condition="$data['title'] eq 1">个人<else />{$data['company_name']}</if></em></li>
      <li class="clear"><span>{$T->str_card_share_order_account}：</span><em>{$data.order_no}</em></li>
      <li class="clear"><span>{$T->str_order_price}：</span><em>{$data.price}{$T->str_rmb}</em></li>
    </ul>
  </div>
  <if condition="$data['type'] eq 1">
  <div class="showcond_tit">
    <h4>{$T->str_invoice_qualifications}</h4>
  </div>
  <div class="warp_top">
    <div class="warp-left">
      <div class="warp-list">
        <span>{$T->offcialpartner_linkman}：</span>
        <p>{$data.contacts}</p>
      </div>
      <div class="warp-list">
        <span>{$T->offcialpartner_tel}：</span>
        <p>{$data.telephone}</p>
      </div>
      <div class="warp-list">
        <span>{$T->str_partner_name}：</span>
        <p>{$data.company_name}</p>
      </div>
      <div class="warp-list">
        <span>{$T->str_taxpayer_code}：</span>
        <p>{$data.taxpayerid}</p>
      </div>
      <div class="warp-list">
        <span>{$T->str_company_reg_addr}：</span>
        <p>{$data.company_address}</p>
      </div>
      <div class="warp-list">
        <span>{$T->str_company_reg_tel}：</span>
        <p>{$data.company_telephone}</p>
      </div>
      <div class="warp-list">
        <span>{$T->str_bank_name}：</span>
        <p>{$data.bank_name}</p>
      </div>
      <div class="warp-list">
        <span>{$T->str_bank_account}：</span>
        <p>{$data.bank_account}</p>
      </div>
    </div>
    
  </div>
  <div class="warp_bottom">
    <div class="warp_pic">
      <span>{$T->str_business}：</span>
      <i><if condition="$data['uploadfile1']"><img class="js_click_show" src="{$data.uploadfile1}" /></if></i>
    </div>
    <div class="warp_pic1">
      <span>{$T->str_taxpayer_certificate}:</span>
      <i><if condition="$data['uploadfile2']"><img class="js_click_show"  src="{$data.uploadfile2}" /></if></i>
    </div>
  </div>
  </if>
  <if condition="in_array($data['status'],array(1,4))">
  <div class="addpus_bin">
     <span style="width:260px;"></span>
     <div class="textappadmin_button">
          
       <button class="big_button adddata_b" id="js_bill">{$T->str_make_sure_bill}</button>
       <button class="big_button" id="js_refuse">{$T->str_refuse_bill}</button>
       <button class="big_button" id="js_cancel">{$T->str_extend_cancel}</button>
     </div>
 </div>
  </if>
</div>
<!-- 添加管理员 弹出框 -->
<div class="appadmin_addAdministrator" id="add_admin_dom">
    <div class="appadmin_unlock_close"><img class="cursorpointer js_logoutcancel" src="__PUBLIC__/images/appadmin_icon_close.png" /></div>
    <div class="Administrator_pop_c">
        <div class="bill_refuse_title">{$T->str_prompt}</div>
        <div class="bill_refuse_con">
          <span>{$T->str_input_reason}</span>
          <textarea name="" id="js_refuse_reason" cols="30" rows="10"></textarea>
        </div>
        
        <div class="Administrator_bin" style="width:350px;">
            <input class="big_button cursorpointer js_add_sub" type="button" value="{$T->str_extend_warning_ok}" />
            <input class="bill_refuse_btn big_button cursorpointer js_add_cancel" type="button" value="{$T->str_extend_cancel}" />
        </div>
    </div>
</div>
<img style="display:none;" id="js_layer_original" src="" alt="">
<script>
    var tip_img_format = "{$T->tip_img_format}";
    var tip_invoice_no_format = "{$T->tip_invoice_no_format}";
    var str_make_sure_bill = "{$T->str_make_sure_bill}";
    var str_cancel = "{$T->str_extend_cancel}";
    var str_make_sure = "{$T->tip_logsid_submit}";
    var str_input_reason = "{$T->str_input_reason}";
    var str_input_reason_long = "{$T->str_input_reason_long}";
    var uploadUrl = "{:U('Appadmin/Collection/uploadFileTmp')}";
    var billPostUrl = "{:U('Appadmin/FinanceManage/billPost')}";
    //var succTurnUrl = "{:U('Appadmin/FinanceManage/billPost')}";
    $(function(){
        $.finance.bill();
    });
</script>