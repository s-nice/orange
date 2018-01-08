<layout name="../Layout/Layout" />
<style>
    .js_list_select ul{
        max-height: 200px;
    }

</style>
<div class="content_global">
    <div class="content_hieght">
            <div class="newsCard_text">
               <form id="data-form">
                <div class="card_company clear">
                  <span>卡类型<i class="form_required"></i>：</span>
                  <div class="card_company_list border_style menu_list js_list_select">
                     <input type="text" placeholder="下拉选择" AUTOCOMPLETE="off" class="js_cardType_input" readonly="readonly"
                     <if condition="isset($cardtypeid)"> value={$cardTypes[$cardtypeid]} val={$cardtypeid} </if>
                     />
                     <em></em>
                     <ul>
                       <foreach name="cardTypes" item="val" >
                           <if condition="isset($cardtypeid) && $key eq $cardtypeid">
                               <li val="{$key}" class="on">{$val}</li>
                               <else/>
                               <li val="{$key}">{$val}</li>
                           </if>
                       </foreach>
                     </ul>
                  </div>
                </div>
                <div class="card_company clear">
                  <span>发卡单位<i class="form_required"></i>：</span>
                  <div  style="float:left;" class="card_company_list border_style menu_list js_list_select js_units_list">
                     <input type="text" placeholder="下拉选择" AUTOCOMPLETE="off" class="js_units_input"
                      <if condition="isset($info) && isset($units[$info['cardunitid']])"> value={$info['name']} val={$info['cardunitid']}</if>/>
                     <em></em>
                     <ul>
                         <if condition="isset($cardtypeid)">
                             <foreach name="units" item="val" >
                                 <if condition="$key eq $info['cardunitid']">
                                     <li val="{$key}" class="on">{$val}</li>
                                     <else/>
                                     <li val="{$key}">{$val}</li>
                                 </if>
                             </foreach>
                         </if>
                     </ul>
                  </div>
                    <div id="js_select_key"
                    <if condition="isset($info) && ($info['cardtypeid'] eq 4)">style=";width:200px;float:left;"
                        <else/>style="display:none;width:200px;float:left;"</if>>
                        <span style="width:110px;">可无钥匙入住<i class="form_required"></i>：</span>
                        <div class="card_company_list border_style menu_list js_list_select" style="width:80px;">
                            <input type="text" class="js_key_input" AUTOCOMPLETE="off"
                            <if condition=" isset($info) && $info['ifhold'] eq 1"> value="是" val="1" <else/> value="否" val="2"</if>>
                            <em></em>
                            <ul style="width:80px;">
                                <if condition="isset($info) && $info['cardtypeid'] eq 4 && ($info['ifhold'] eq '1')">
                                    <li  val="1" class="on">是</li>
                                    <li  val="2">否</li>
                             <else/>
                                    <li  val="1">是</li>
                                    <li class="on" val="2">否</li>
                                </if>
                            </ul>
                        </div>
                    </div>

                    <div id="js_select_key2"
                   <if condition="isset($info) && ($info['cardtypeid'] eq 4) && ($info['ifhold'] eq 1)">style=";width:200px;float:left;"
                       <else/>style="display:none;width:200px;float:left;"</if>>
                        <span style="width:100px;">需要秘钥<i class="form_required"></i>：</span>
                        <div class="card_company_list border_style menu_list js_list_select" style="width:80px;">
                            <input type="text" class="js_key_input2" AUTOCOMPLETE="off"
                            <if condition="isset($info) && $info['ifkey'] eq 1">value="是" val="1"<else/>value="否" val="2"</if>>
                            <em></em>
                            <ul style="width:80px;">
                                <if condition=" isset($info) && $info['cardunitid'] eq 37 && $info['ifkey'] eq '1'">
                                    <li  val="1" class="on">是</li>
                                    <li  val="2">否</li>
                                    <else/>
                                    <li  val="1">是</li>
                                    <li class="on" val="2">否</li>
                                </if>
                            </ul>
                        </div>
                    </div>

                </div>
             <div class="js_phone_address_wrap" style="max-height: 100px">
                 <if condition="isset($info)">
                     <foreach name="address" item="item">
                         <if condition="$key eq 0">
                             <div class="js_add_div" style="overflow:hidden;max-height:150px;">
                                 <div class="card_company left">
                                     <span>电话<i class="form_required"></i>：</span>
                                     <div class="left js_add_wrap">
                                         <div class="phone_add">
                                             <div class="card_company_list border_style menu_list" style="float:left;">
                                                 <input name="telephone[]" type="text" value="{$phones[$key]}" class="js_telephone" placeholder='' autocomplete="off" />
                                             </div>
                                             <!-- <i class="js_copy_or_delete remove_x js_add">+</i> -->
                                         </div>
                                     </div>
                                 </div>
                                 <div class="card_company left">
                                     <span>地址<i class="form_required"></i>：</span>
                                     <div class="left js_add_wrap">
                                         <div class="phone_add">
                                             <div class="card_company_list border_style menu_list" style="float:left;">
                                                 <input name="address[]" type="text" value="{$item}" class="js_address" placeholder='' autocomplete="off" />
                                             </div>
                                             <i class="js_copy_or_delete remove_x js_add">+</i>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <else/>
                             <div class="js_add_div" style="overflow:hidden;max-height:150px;">
                                 <div class="card_company left">
                                     <span>电话<i class="form_required"></i>：</span>
                                     <div class="left js_add_wrap">
                                         <div class="phone_add">
                                             <div class="card_company_list border_style menu_list" style="float:left;">
                                                 <input name="telephone[]" type="text" value="{$phones[$key]}" class="js_telephone" placeholder='' autocomplete="off" />
                                             </div>
                                             <!-- <i class="js_copy_or_delete remove_x js_add">+</i> -->
                                         </div>
                                     </div>
                                 </div>
                                 <div class="card_company left">
                                     <span>地址<i class="form_required"></i>：</span>
                                     <div class="left js_add_wrap">
                                         <div class="phone_add">
                                             <div class="card_company_list border_style menu_list" style="float:left;">
                                                 <input name="address[]" type="text" value="{$item}" class="js_address" placeholder='' autocomplete="off" />
                                             </div>
                                             <i class="js_copy_or_delete remove_x js_remove">-</i>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </if>
                     </foreach>
                     <else/>
                     <div class="js_add_div" style="overflow:hidden;max-height:150px;max-height:150px;">
                         <div class="card_company left">
                             <span>电话<i class="form_required"></i>：</span>
                             <div class="left js_add_wrap">
                                 <div class="phone_add">
                                     <div class="card_company_list border_style menu_list" style="float:left;">
                                         <input name="telephone[]" type="text" value="" class="js_telephone" placeholder='' autocomplete="off" />
                                     </div>
                                     <!-- <i class="js_copy_or_delete remove_x js_add">+</i> -->
                                 </div>
                             </div>
                         </div>
                         <div class="card_company left">
                             <span>地址<i class="form_required"></i>：</span>
                             <div class="left js_add_wrap">
                                 <div class="phone_add">
                                     <div class="card_company_list border_style menu_list" style="float:left;">
                                         <input name="address[]" type="text" value="" class="js_address" placeholder='' autocomplete="off" />
                                     </div>
                                     <i class="js_copy_or_delete remove_x js_add">+</i>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </if>
             </div>
              <div class="card_company clear">
                  <span>应用到卡模板<i class="form_required"></i>：</span>
                  <div class="js_card_tpl_container add_jia_l left">
                      <div  class="add_save js_card_model hand">+</div>
                  </div>
                  <div class="left card_item text_item card_list_l js_selected_model " style="max-height: 200px;border:1px solid #b8b8b8;margin-top:15px;margin-left:145px;">
                      <if condition="isset($selectCardModel)">
                          <foreach name="selectCardModel" item="name">
                              <span class="js_model_show " val="{$key}"><em>{$name}</em><i class="js_del_card_model hand">x</i></span>
                          </foreach>
                      </if>
                      <!--<span class="js_model_show "><em>如家酒店卡模板</em><i class="js_del_card_model hand">x</i></span>-->
                  </div>
                </div>
                <div class="card_company clear" style="overflow:hidden;">
                  <span>商户展示URL<i class="form_required"></i>：</span>
                    <input type="text" class="js_url_input"  <if condition="isset($info)">value="{$info['url']}"</if>  placeholder='' autocomplete="off"/>
                </div>
                <div class="card_company clear" style="overflow:hidden;">
                  <span>IMORA权益<i class="form_required"></i>：</span>
                  <div  style="margin-left:137px;" class="js_textarea_wrap">
                      <textarea style="width:660px;" name="" id="js_imorarights_txt" cols="30" rows="10" autocomplete="off"><if condition="isset($info)">{$info['imorarights']}</if></textarea>
                  </div>
                </div>
              <div class="alias_btn clear">
                  <input type="hidden" value="{:I('id', '')}" name="id" id="issue_unit_id" />
                  <button type="button" class="big_button js_edit_show_one">预览</button>
                  <button  id="js_save " class="big_button js_save" type="button">保存</button>
                  <a href="{:U('Appadmin/OraUnitDetail/index','','','',true)}" class="js-hide-layer">
                      <button class="big_button" type="button">取消</button></a>
              </div>
               </form>
            </div>
        <span id="js_content_temp"  style="display: none" >
            <if condition="isset($info) && $info['servicegallery'] neq ''">{$info['servicegallery']}</if>
        </span><!--编辑器展示回显暂存数据-->

        <span id="js_content_temp2"  style="display: none" >
            <if condition="isset($info) && $info['imorarights'] neq ''">{$info['imorarights']}</if>
        </span><!--编辑器权益回显暂存数据-->

        <if condition="isset($info)"><!--id-->
            <input type="hidden" name="id" id="js_edit_id" value="{$info['id']}">
        </if>

        <!--卡模板弹窗-->
          <div class="card_modle js_card_model_show" style="width:820px; min-height:550px;padding:10px;z-index: 999;">
          <div style="width:99%;padding:5px;">
              <h2 id="js_card_model_title" style="text-align:center;font-size:18px;color:#333;font-weight:normal;"></h2>
            <div class="right_search" style="margin:10px 0;">
                <input id="js_card_model_tempnumber" class="textinput key_width cursorpointer"  autocomplete="off" type="text" placeholder="模板编号" title="模板编号">
                <input id="js_card_model_keyword" class="textinput key_width cursorpointer" autocomplete="off" type="text" placeholder="输入标签、关键词、名称等查询" title="输入标签、关键词、名称等查询">
                <div class="serach_namemanages border_w menu_list js_list_select">
                    <span class="span_name">
                        <input id="js_card_model_iscoop" class="width_w " type="text" value="全部商户">
                    </span>
                    <em><img src="__PUBLIC__/images/appadmin_icon_xiala.png" alt=""></em>
                    <ul style="z-index:12;">
                      <li val="">全部商户</li>
                      <li val="2">合作商户</li>
                      <li val="1">未合作</li>
                    </ul>
                </div>
                <div class="select_time_c">
                    <span class="span_name">时间</span>
                    <div class="time_c">
                        <input id="js_begintime" autocomplete="off" class="time_input" type="text"  name="starttime">
                        <i class="js_selectTimeStr"></i>
                    </div>
                    <span>--</span>
                    <div class="time_c">
                        <input id="js_endtime" autocomplete="off" class="time_input" type="text"  name="endtime">
                        <i class="js_selectTimeStr"></i>
                    </div>
                </div>
                <div class="serach_but js_serach_card_model">
                    <input class="butinput cursorpointer" type="button" order="" orderType="">
                </div>
            </div>
            </div>
            <div class="section_bin add_vipcard">
                <span class="span_span11" ><i id="js_allselect"></i></span>
                <button type="button" class="js_sub_select">确定</button>
                <button type="button" class="js_cancel_select">取消</button>
            </div>
              <div class="page"></div>
            <div class="vipcard_list border_vipcard userpushlist_name js_list_one" style="margin-top:80px;">
                <span class="span_span11"></span>
                <span class="span_span1 hand"><u>ID</u><em class="list_sort_none js_sort_data" sort_type="id"></em></span>
                <span class="span_span2">卡类型</span>
                <span class="span_span2">模板编号</span>
                <span class="span_span8">模板名称</span>
                <span class="span_span6">合作商户</span>
                <span class="span_span5 hand"><u style="float:left;">添加时间</u><em class="list_sort_none js_sort_data" sort_type="createdtime"></em></span>
                <span class="span_span6 hand"><u style="float:left;">使用人数</u><em class="list_sort_none js_sort_data" sort_type="personnum"></em></span>
            </div>
            <div class="model_scroll js_card_model_list" style="height: 350px"></div>
          </div>
        <!--卡模板弹窗end-->
        <!--预览弹框 start -->
        <div class="Check_comment_pop js_review_box js_btn_new_preview" style="z-index: 9999; height: 1200px;display:none;">
            <div class="Check_comment_close js_btn_close">
                <img src="__PUBLIC__/images/appadmin_icon_close.png" class="hand" alt="">
            </div>
            <div class="Check_commentpop_c clear">
                <div class="Checkcomment_title">预览</div>
                <div class="js_new_summey" style="height:1050px;">
                    <textarea id="js_iframe_area_1" style="height:25%;width:100%;background:#111;border:1px solid #ccc;color:#ccc;" ></textarea>
                    <iframe  id="js_iframe_area_2"  src="" height='75%' width="100%" style="display: block"></iframe>
                </div>
            </div>
        </div>
        <!--预览弹框 end -->
    </div>
</div>
<!-- 实例化编辑器 -->
<script type="text/javascript">

    var gGetUnitsUrl="{:U('Appadmin/OraUnitDetail/getUnits','','','',true)}";
    var gGetCardModelUrl="{:U('Appadmin/OraUnitDetail/getCardModel','','','',true)}";
    var gSaveUrl="{:U('Appadmin/OraUnitDetail/doAddOrEdit','','','',true)}";
    var gCheckTempIdUrl="{:U('Appadmin/OraUnitDetail/checkCardModel','','','',true)}";//检测卡模板是否占用
    var gUrl = "{:U('Appadmin/OraUnitDetail/index','','','',true)}";
    $(function(){
        //时间选择;
        $.dataTimeLoad.init();
        $.OraUnitDetail.init();
    });
</script>

