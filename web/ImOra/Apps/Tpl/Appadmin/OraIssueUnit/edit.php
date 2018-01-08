<div id="data-form-layer">
	<div class="card_select js-item-for-copy transparent">
	    <select class="js_unit_attr" name="unitAttrKey[]">
	      <foreach name="cardTypes" item="val">
	        <foreach name="val['attribute']" item="attr">
	         <if condition="$attr['type'] eq 2">
	          <option class="transparent" value="{$attr['id']}"
	            data-cardType="{$val['id']}" data-placeholder="{$attr['alert']}"
	            data-isedit="{$attr['isedit']}" data-val="{:str_replace('"', "'",$attr['val'])}"
	            style="display:none;">{$attr['attr']}</option>
	         </if>
	        </foreach>
	      </foreach>
	    </select>
		<input name="unitAttrValue[]" class="js_unit_attr_value" type="text" value="" />
		<input name="unitAttrId[]" class="js_unit_attr_id" type="hidden" value="" />
		<i class="js-remove-item hand">X</i>
	</div>
   <form id="data-form">
    <div class="js-add-only" style="overflow:hidden;">
      <span>请选择卡类型：</span>
      <span>
       <foreach name="cardTypes" item="val">
        <if condition="$key neq 0">
        <input class="js-cardtype" type="checkbox" name="cardTypes[]" value="{$key}"/>
        <label>{$val['firstname']}</label>
        </if>
       </foreach>
      </span>
    </div>
	<div class="give_input">
		<input name="unitName" type="text" value="" class="text_input js_unit_name" placeholder='输入发卡单位名称'/>
		<input name="unitCode" type="text" value="" class="text_input js_unit_code" placeholder='输入4位数单位序号'/>
		<input name="isPartner" type="hidden" value="1"/>
		<input name="isPartner" type="checkbox" value="2" id="isPartner"/>
		<label for="isPartner">合作商户</label>
	</div>
	<div class="js-buttons">
	  <input type="button" id="add-more-button" value="添加卡单位属性"/>
	</div>
	<div class="alias_btn clear">
	    <input type="hidden" value="{:I('id', '')}" name="id" id="issue_unit_id" />
		<button  id="js_submit" class="big_button" type="button">保存</button>
		<a href="#" class="js-hide-layer"><button class="big_button" type="button">取消</button></a>
	</div>
   </form>
</div>
